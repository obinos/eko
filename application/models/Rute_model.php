<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rute_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('mongo_db', array('activate' => 'arata'), 'aratadb');
    }
    public function dataRute($tgl = null, $id = null)
    {
        if ($tgl) {
            $startDate = $this->mongo_db->date(strtotime("$tgl") * 1000);
            $endDate = $this->mongo_db->date((strtotime("$tgl") + 86399) * 1000);
            $params['delivery_time']['$gte'] = $startDate;
            $params['delivery_time']['$lte'] = $endDate;
        }
        if ($id) {
            $params['_id'] = $id;
        }
        $params['$nor'] = [['_id' => null]];
        $pipeline = [
            ['$lookup' => [
                'from' => 'superuser',
                'localField' => 'maker',
                'foreignField' => '_id',
                'as' => 'user'
            ]],
            ['$match' => ['$and' => [$params]]],
            ['$project' => ['_id' => '$_id', 'created_at' => ['$dateToString' => ['format' => '%d-%m-%Y %H:%M', 'date' => '$created_at', 'timezone' => '+07:00']], 'delivery_time' => ['$dateToString' => ['format' => '%Y-%m-%d', 'date' => '$delivery_time', 'timezone' => '+07:00']], 'delivery_time2' => '$delivery_time', 'user' => ['$arrayElemAt' => ['$user.name', 0]], 'data' => '$data']],
            ['$sort'  => ['_id' => -1]]
        ];
        $result = $this->aratadb->aggregate('rute_courier', $pipeline);
        if (!$result) {
            return [];
        } else {
            for ($i = 0; $i < count($result); $i++) {
                $rak = [];
                foreach ($result[$i]['data'] as $k => $r) {
                    $rak[$r->status][] = $r;
                }
                $result[$i]['split'] = count($rak);
                array_multisort(array_column($result[$i]['data'], 'time'), SORT_ASC, $result[$i]['data']);
            }
            return $result;
        }
    }
    public function addRute($json)
    {
        $rute = [
            "_id"           => (string) new MongoDB\BSON\ObjectId(),
            "created_at"    => $this->mongo_db->date(),
            "delivery_time" => new MongoDB\BSON\UTCDateTime((new DateTime($json->date))->getTimestamp() * 1000),
            "maker"         => $this->session->userdata('id'),
            "data"          => $json->data
        ];
        $result = $this->aratadb->insert('rute_courier', $rute);
        if ($result) {
            $result += ['status' => 'success'];
        } else {
            $result['status'] = 'failed';
            $result['text'] = 'Server Error';
        }
        return $result;
    }
    public function editRute($json)
    {
        $params['_id'] = $json->_id;
        $update = [
            "maker"         => $this->session->userdata('id'),
            "data"          => $json->data
        ];
        $db = $this->aratadb->where($params)->set($update)->update('rute_courier');
        if ($db->getModifiedCount() === 0) {
            $result = [
                'status' => 'failed'
            ];
        } else {
            $result = [
                'status' => 'success'
            ];
        }
        return $result;
    }
    public function deleteRute($id)
    {
        $params['_id'] = $id;
        $db = $this->aratadb->where($params)->delete('rute_courier');
        if ($db->getDeletedCount() === 0) {
            $result = [
                'status' => 'failed',
                'id'     => $id
            ];
        } else {
            $result = [
                'status' => 'success',
                'id'     => $id
            ];
        }
        return $result;
    }
    private function params()
    {
        $params['search'] = $_POST['search']['value'];
        $params['limit'] = $_POST['length'];
        $params['start'] = $_POST['start'];
        $order_field = $_POST['order'][0]['column'];
        $ascdesc = $_POST['order'][0]['dir'];
        if ($ascdesc == "desc") {
            $sort = -1;
        } else {
            $sort = 1;
        }
        $order_data = $_POST['columns'][$order_field]['data'];
        $params['$order'] = [$order_data => $sort];
        return $params;
    }
    private function pipeline($where, $order, $limit, $start, $x = null)
    {
        $pipeline = [
            ['$lookup' => [
                'from' => 'superuser',
                'localField' => 'maker',
                'foreignField' => '_id',
                'as' => 'user'
            ]],
            ['$project' => ['_id' => '$_id', 'created_at' => ['$dateToString' => ['format' => '%Y%m%d%H%M %d-%m-%Y %H:%M', 'date' => '$created_at', 'timezone' => '+07:00']], 'delivery_time' => ['$dateToString' => ['format' => '%Y%m%d%H%M %d-%m-%Y', 'date' => '$delivery_time', 'timezone' => '+07:00']], 'user' => ['$arrayElemAt' => ['$user.name', 0]], 'courier' => ['$size' => '$data']]],
            ['$match' => ['$and' => [$where]]],
            ['$project' => ['_id' => '$_id', 'created_at' => '$created_at', 'delivery_time' => '$delivery_time', 'user' => '$user', 'courier' => '$courier']],
            ['$sort'  => $order]
        ];
        if ($x) {
            $pipeline = array_merge($pipeline, [['$skip' => (int)$start]]);
            $pipeline = array_merge($pipeline, [['$limit' => (int)$limit]]);
        }
        $result = $this->aratadb->aggregate('rute_courier', $pipeline);
        return $result;
    }
    private function filter($where, $order, $limit, $start, $search, $where_search)
    {
        $result['all_data'] = $this->aratadb->where($where)->count('rute_courier');
        $result['show_data'] = $this->pipeline($where, $order, $limit, $start);
        if ($search) {
            $where = array_merge($where, $where_search);
            $result['show_data'] = $this->pipeline($where, $order, $limit, $start);
        }
        $result['filter_data'] = count($result['show_data']);
        if ($limit != -1) {
            $result['show_data'] = $this->pipeline($where, $order, $limit, $start, 'limit');
        }
        return $result;
    }
    private function callback($result)
    {
        $callback = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $result['all_data'],
            'recordsFiltered' => $result['filter_data'],
            'data' => $result['show_data']
        );
        return $callback;
    }
    function serverside($data)
    {
        $params = $this->params();
        $where['$nor'] = [['_id' => null]];
        $result = $this->filter($where, $params['$order'], $params['limit'], $params['start'], $params['search'], $data['where_search']);
        $callback = $this->callback($result);
        return json_encode($callback);
    }
}
