<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Po_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('mongo_db', array('activate' => 'arata'), 'aratadb');
    }
    public function dataPO($id = null)
    {
        if ($id) {
            $params['_id'] = $id;
        } else {
            $params['$nor'] = [['_id' => null]];
        }
        $pipeline = [
            ['$lookup' => [
                'from' => 'supplier',
                'localField' => 'id_supplier',
                'foreignField' => '_id',
                'as' => 'supplier'
            ]],
            ['$match' => ['$and' => [$params]]],
            ['$project' => ['created_at' => '$created_at', 'transaction_date' => '$transaction_date', 'pono' => '$pono', 'status' => '$status', 'id_supplier' => '$id_supplier', 'supplier' => ['$arrayElemAt' => ['$supplier.name', 0]], 'items' => '$items', 'total' => '$total']],
            ['$sort'  => ['created_at' => -1]]
        ];
        $result = $this->aratadb->aggregate('po', $pipeline);
        if (!$result) {
            return [];
        } else {
            return $result;
        }
    }
    public function inputpo($json)
    {
        $this->load->model('Counter_model');
        $counter = $this->Counter_model->get_counter('PO');
        foreach ($json->item as $k => $data) {
            $new_item = [
                "id_item"            => $data->id_item,
                "name"               => $data->name,
                "qty"                => (int)$data->qty,
                "qty_unit"           => (int)$data->qty_unit,
                "qty_purchased"      => 0,
                "qty_unit_purchased" => 0,
                "qty_balance"        => (int)$data->qty - 0,
                "qty_unit_balance"   => (int)$data->qty_unit - 0,
                "notes"              => $data->notes,
                "unit"               => $data->unit
            ];
            $item[] = $new_item;
        }
        $data_po = [
            "_id"              => (string) new MongoDB\BSON\ObjectId(),
            "pono"             => "PO-" . date('ymd') . "-" . $counter,
            "maker"            => $this->session->userdata('id'),
            "id_supplier"      => '624a5bb2e3e9176de67e5027',
            "status"           => "open",
            "transaction_date" => new MongoDB\BSON\UTCDateTime((new DateTime($json->filter_date))->getTimestamp() * 1000),
            "created_at"       => $this->mongo_db->date(),
            "items"            => $item
        ];
        $result = $this->aratadb->insert('po', $data_po);
        if ($result) {
            $result = ['status' => 'success'];
        } else {
            $result['status'] = 'failed';
            $result['text'] = 'Server Error';
        }
        return $result;
    }
    // public function inputpo($json)
    // {
    //     $this->load->model('Counter_model');
    //     $counter = $this->Counter_model->get_counter('PO');
    //     foreach ($json->item as $k => $data) {
    //         if ($data->id_supplier) {
    //             $supplier = $data->id_supplier;
    //             $new_item = [
    //                 "id_item"            => $data->id_item,
    //                 "name"               => $data->name,
    //                 "qty"                => (int)$data->qty,
    //                 "qty_unit"           => (int)$data->qty_unit,
    //                 "qty_purchased"      => 0,
    //                 "qty_unit_purchased" => 0,
    //                 "qty_balance"        => (int)$data->qty - 0,
    //                 "qty_unit_balance"   => (int)$data->qty_unit - 0,
    //                 "notes"              => $data->notes,
    //                 "unit"               => $data->unit
    //             ];
    //             $item[$supplier][] = $new_item;
    //             $data_po[$supplier] = [
    //                 "_id"              => (string) new MongoDB\BSON\ObjectId(),
    //                 "pono"             => "PO-" . date('ymd') . "-" . $counter,
    //                 "maker"            => $this->session->userdata('id'),
    //                 "id_supplier"      => $supplier,
    //                 "status"           => "open",
    //                 "transaction_date" => new MongoDB\BSON\UTCDateTime((new DateTime($json->filter_date))->getTimestamp() * 1000),
    //                 "created_at"       => $this->mongo_db->date(),
    //                 "items"            => $item[$supplier]
    //             ];
    //         }
    //     }
    //     $result = $this->aratadb->batch_insert('po', $data_po);
    //     if ($result) {
    //         $result = ['status' => 'success'];
    //     } else {
    //         $result['status'] = 'failed';
    //         $result['text'] = 'Server Error';
    //     }
    //     return $result;
    // }
    public function addPO($json)
    {
        $this->load->model('Counter_model');
        $counter = $this->Counter_model->get_counter('PO');
        $now = $this->mongo_db->date();
        foreach ($json->item as $key => $val) {
            $data_item = [
                "id_item"     => $val->_id,
                "name"        => $val->name,
                "qty_unit"    => (int)$val->qty_beli,
                "qty"         => (int)$val->qty_pack,
                "unit"        => $val->weight_unit,
                "price"       => (int)$val->price_pack,
                "total_price" => (int)$val->total_price
            ];
            $item[] = $data_item;
        }
        $po = [
            "_id"              => (string) new MongoDB\BSON\ObjectId(),
            "pono"             => "PO-" . date('ymd') . "-" . $counter,
            "maker"            => $this->session->userdata('id'),
            "id_supplier"      => $json->supplier,
            "status"           => "open",
            "transaction_date" => $now,
            "created_at"       => $now,
            "items"            => $item,
            "total"            => $json->total_buy
        ];
        $result = $this->aratadb->insert('po', $po);
        if ($result) {
            $result += ['result' => 'success'];
        } else {
            $result['result'] = 'failed';
            $result['text'] = 'Server Error';
        }
        return $result;
    }
    public function editPO($json)
    {
        $params['_id'] = $json->_id;
        foreach ($json->item as $keys => $val) {
            $data_item = [
                "id_item"     => $val->_id,
                "name"        => $val->name,
                "qty_unit"    => (int)$val->qty_beli,
                "qty"         => (int)$val->qty_pack,
                "unit"        => $val->weight_unit,
                "price"       => (int)$val->price_pack,
                "total_price" => (int)$val->total_price
            ];
            $item[] = $data_item;
        }
        $po = [
            "who_update"  => $this->session->userdata('id'),
            "id_supplier" => $json->supplier,
            "status"      => $json->status,
            "updated_at"  => $this->mongo_db->date(),
            "items"       => $item,
            "total"       => $json->total_buy
        ];
        $db = $this->aratadb->where($params)->set($po)->update('po');
        if ($db->getModifiedCount() === 0) {
            $result = [
                'result' => 'failed',
                'text'   => 'data yg diupdate salah'
            ];
        } else {
            $result = [
                'result' => 'success'
            ];
        }
        return $result;
    }
    public function deletePO($id)
    {
        $params['_id'] = $id;
        $po = $this->aratadb->where($params)->get('po');
        $db = $this->aratadb->where($params)->delete('po');
        if ($db->getDeletedCount() === 0) {
            $result = [
                'status' => 'failed',
                'pono'   => $po[0]['pono'],
                'id'     => $id
            ];
        } else {
            $result = [
                'status' => 'success',
                'pono'   => $po[0]['pono'],
                'id'     => $id
            ];
        }
        return $result;
    }
    public function poexisting($date)
    {
        $startDate = $this->mongo_db->date((new DateTime($date))->getTimestamp() * 1000);
        $endDate = $this->mongo_db->date(((new DateTime($date))->getTimestamp() + 86399) * 1000);
        $user = $this->aratadb->get_where('po', ['status' => 'open', 'transaction_date' => ['$gte' => $startDate, '$lte' => $endDate]]);
        return $user;
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
                'from' => 'supplier',
                'localField' => 'id_supplier',
                'foreignField' => '_id',
                'as' => 'supplier'
            ]],
            ['$lookup' => [
                'from' => 'superuser',
                'localField' => 'maker',
                'foreignField' => '_id',
                'as' => 'usermaker'
            ]],
            ['$lookup' => [
                'from' => 'superuser',
                'localField' => 'who_update',
                'foreignField' => '_id',
                'as' => 'userupdate'
            ]],
            ['$project' => ['_id' => '$_id', 'created_at' => ['$dateToString' => ['format' => '%Y%m%d%H%M %d-%m-%Y %H:%M', 'date' => '$created_at', 'timezone' => '+07:00']], 'updated_at' => ['$dateToString' => ['format' => '%Y%m%d%H%M %d-%m-%Y %H:%M', 'date' => '$updated_at', 'timezone' => '+07:00']], 'transaction_date' => ['$dateToString' => ['format' => '%Y%m%d%H%M %d-%m-%Y', 'date' => '$transaction_date', 'timezone' => '+07:00']], 'pono' => '$pono', 'status' => '$status', 'supplier' => ['$arrayElemAt' => ['$supplier.name', 0]], 'usermaker' => ['$arrayElemAt' => ['$usermaker.name', 0]], 'userupdate' => ['$arrayElemAt' => ['$userupdate.name', 0]]]],
            ['$match' => ['$and' => [$where]]],
            ['$project' => ['_id' => '$_id', 'created_at' => '$created_at', 'updated_at' => '$updated_at', 'transaction_date' => '$transaction_date', 'pono' => '$pono', 'status' => '$status', 'supplier' => '$supplier', 'usermaker' => '$usermaker', 'userupdate' => '$userupdate']],
            ['$sort'  => $order]
        ];
        if ($x) {
            $pipeline = array_merge($pipeline, [['$skip' => (int)$start]]);
            $pipeline = array_merge($pipeline, [['$limit' => (int)$limit]]);
        }
        $result = $this->aratadb->aggregate('po', $pipeline);
        return $result;
    }
    private function filter($where, $order, $limit, $start, $search, $where_search)
    {
        $result['all_data'] = $this->aratadb->where($where)->count('po');
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
        if ($data['status']) {
            if ($data['status'] == 'all') {
                $where_status = ['$or' => [['status' => "open"], ['status' => 'closed']]];
            } else {
                $where_status = ['status' => $data['status']];
            }
            $where = array_merge($where, $where_status);
        }
        $result = $this->filter($where, $params['$order'], $params['limit'], $params['start'], $params['search'], $data['where_search']);
        $callback = $this->callback($result);
        return json_encode($callback);
    }
}
