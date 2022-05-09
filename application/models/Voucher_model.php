<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Voucher_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('mongo_db', array('activate' => 'arata'), 'aratadb');
        $this->merchant = '606eba1c099777608a38aeda';
    }
    public function dataVoucher($id = null)
    {
        if ($id) {
            $dt = $this->aratadb->get_where('voucher', ['_id' => $id]);
        } else {
            $dt = $this->aratadb->order_by(['code' => 'ASC'])->get('voucher');
        }
        if (!$dt) {
            return [];
        } else {
            return $dt;
        }
    }
    public function viewVoucher($code)
    {
        $pipeline = [
            ['$match' => ['$and' => [['merchant' => $this->merchant], ['voucher' => $code]]]],
            ['$group' => ['_id' => ['voucher' => '$voucher', 'status' => '$status'], 'usage' => ['$sum' => 1]]],
            ['$group' => ['_id' => '$_id.voucher', 'total_usage' => ['$sum' => '$usage'], 'detail' => ['$addToSet' => ['status' => '$_id.status', 'usage' => '$usage']]]],
            ['$lookup' => [
                'from' => 'voucher',
                'localField' => '_id',
                'foreignField' => 'code',
                'as' => 'vouchers'
            ]],
            ['$project' => ['_id' => '$_id', 'type' => ['$arrayElemAt' => ['$vouchers.type', 0]], 'nominal' => ['$arrayElemAt' => ['$vouchers.nominal', 0]], 'expired' => ['$arrayElemAt' => ['$vouchers.expired', 0]], 'min_order' => ['$arrayElemAt' => ['$vouchers.min_order', 0]], 'order_usage' => ['$arrayElemAt' => ['$vouchers.order_usage', 0]], 'limit' => ['$arrayElemAt' => ['$vouchers.limit', 0]], 'max_usage' => ['$arrayElemAt' => ['$vouchers.max_usage', 0]], 'hp' => ['$arrayElemAt' => ['$vouchers.hp', 0]], 'is_public' => ['$arrayElemAt' => ['$vouchers.is_public', 0]], 'total_usage' => '$total_usage', 'detail' => '$detail']]
        ];
        $result = $this->aratadb->aggregate('orders', $pipeline);
        if (!$result) {
            return [];
        } else {
            return $result;
        }
    }
    public function getVoucher($json)
    {
        $params['merchant'] = $this->merchant;
        if ($json->code) {
            $params['voucher'] = new MongoDB\BSON\Regex($json->code, 'i');
        }
        if ($json->status) {
            $params['status'] = $json->status;
        }
        $result['data'] = $this->aratadb->order_by(['delivery_time' => 'DESC'])->where($params)->get('orders');
        if (!$result) {
            return [];
        } else {
            return $result;
        }
    }
    public function checkVoucher($code)
    {
        return $this->aratadb->get_where('voucher', ['code' => $code]);
    }
    public function addVoucher($json)
    {
        $limit = $json->limit == 'unlimited' ? PHP_INT_MAX : (int)$json->limit;
        $max_usage = $json->max_usage == 'unlimited' ? PHP_INT_MAX : (int)$json->max_usage;
        $expired = strtotime($json->expired . '  23:59:59');
        $updated_at = $this->mongo_db->date();
        $is_public = $json->is_public === 'true' ? true : false;
        $data = [
            "_id"         => (string) new MongoDB\BSON\ObjectId(),
            "code"        => strtoupper(htmlspecialchars($json->code)),
            "expired"     => $expired,
            "min_order"   => (int)$json->min_order,
            "order_usage" => (int)$json->order_usage,
            "limit"       => $limit,
            "max_usage"   => $max_usage,
            "nominal"     => (int)$json->nominal,
            "type"        => $json->type,
            "hp"          => $json->hp,
            "is_public"   => $is_public,
            "maker"       => $this->session->userdata('id'),
            "updated_at"  => $updated_at
        ];
        $result = $this->aratadb->insert('voucher', $data);
        if ($result) {
            $result += ['expired1'    => date('d-m-Y', $expired)];
            $result += ['updated_at1' => datephp('d-m-Y', $updated_at)];
            $result += ['usermaker'   => $this->session->userdata('name')];
            $result += ['newlimit'    => $json->limit];
            $result += ['status'      => 'success'];
            $result += ['action'      => 'Add'];
            return $result;
        } else {
            $result = ['status' => 'failed'];
            $result = ['action' => 'Add'];
            return $result;
        }
    }
    public function editVoucher($json)
    {
        $limit = $json->limit == 'unlimited' ? PHP_INT_MAX : (int)$json->limit;
        $max_usage = $json->max_usage == 'unlimited' ? PHP_INT_MAX : (int)$json->max_usage;
        $expired = strtotime($json->expired . '  23:59:59');
        $updated_at = $this->mongo_db->date();
        $code = strtoupper(htmlspecialchars($json->code));
        $params['_id'] = $json->_id;
        $is_public = $json->is_public === 'true' ? true : false;
        $update = [
            "code"        => $code,
            "expired"     => $expired,
            "min_order"   => (int)$json->min_order,
            "order_usage" => (int)$json->order_usage,
            "limit"       => $limit,
            "max_usage"   => $max_usage,
            "nominal"     => (int)$json->nominal,
            "type"        => $json->type,
            "hp"          => $json->hp,
            "is_public"   => $is_public,
            "who_update"  => $this->session->userdata('id'),
            "updated_at"  => $updated_at
        ];
        $db = $this->aratadb->where($params)->set($update)->update('voucher');
        if ($db->getModifiedCount() === 0) {
            $result = [
                'action' => 'Edit',
                'status' => 'failed',
                'name'   => $code
            ];
        } else {
            $newlimit = $limit > 100000 ? 'unlimited' : $limit;
            $result = [
                'action'      => 'Edit',
                'status'      => 'success',
                '_id'         => $json->_id,
                'is_public'   => $is_public,
                'code'        => $code,
                'expired'     => date('d-m-Y', $expired),
                "min_order"   => (int)$json->min_order,
                "order_usage" => (int)$json->order_usage,
                "limit"       => $newlimit,
                "max_usage"   => $max_usage,
                "nominal"     => (int)$json->nominal,
                "type"        => $json->type,
                "userupdate"  => $this->session->userdata('name'),
                'updated_at'  => datephp('d-m-Y', $updated_at)
            ];
        }
        return $result;
    }
    public function deleteVoucher($id)
    {
        $params['_id'] = $id;
        $voucher = $this->aratadb->where($params)->get('voucher');
        $db = $this->aratadb->where($params)->delete('voucher');
        if ($db->getDeletedCount() === 0) {
            $result = [
                'status' => 'failed',
                'code'   => $voucher[0]['code'],
                'id'     => $id
            ];
        } else {
            $result = [
                'status' => 'success',
                'code'   => $voucher[0]['code'],
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
                'as' => 'usermaker'
            ]],
            ['$lookup' => [
                'from' => 'superuser',
                'localField' => 'who_update',
                'foreignField' => '_id',
                'as' => 'userupdate'
            ]],
            ['$project' => ['_id' => '$_id', 'expired' => ['$dateToString' => ['format' => '%Y%m%d%H%M %d-%m-%Y', 'date' => ['$toDate' => ['$multiply' => ['$expired', 1000]]], 'timezone' => '+07:00']], 'updated_at' => ['$dateToString' => ['format' => '%Y%m%d%H%M %d-%m-%Y', 'date' => '$updated_at', 'timezone' => '+07:00']], 'usermaker' => ['$arrayElemAt' => ['$usermaker.name', 0]], 'userupdate' => ['$arrayElemAt' => ['$userupdate.name', 0]], 'code' => '$code', 'min_order' => '$min_order', 'order_usage' => '$order_usage', 'limit' => '$limit', 'max_usage' => '$max_usage', 'nominal' => '$nominal', 'type' => '$type', 'hp' => '$hp', 'is_public' => '$is_public']],
            ['$match' => ['$and' => [$where]]],
            ['$project' => ['_id' => '$_id', 'expired' => '$expired', 'updated_at' => '$updated_at', 'usermaker' => '$usermaker', 'userupdate' => '$userupdate', 'code' => '$code', 'min_order' => '$min_order', 'order_usage' => '$order_usage', 'limit' => '$limit', 'max_usage' => '$max_usage', 'nominal' => '$nominal', 'type' => '$type', 'hp' => '$hp', 'is_public' => '$is_public']],
            ['$sort'  => $order]
        ];
        if ($x) {
            $pipeline = array_merge($pipeline, [['$skip' => (int)$start]]);
            $pipeline = array_merge($pipeline, [['$limit' => (int)$limit]]);
        }
        $result = $this->aratadb->aggregate('voucher', $pipeline);
        return $result;
    }
    private function filter($where, $order, $limit, $start, $search, $where_search)
    {
        $result['all_data'] = $this->aratadb->where($where)->count('voucher');
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
    private function params_report()
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
    private function pipeline_report($where, $order, $limit, $start, $x = null)
    {
        $pipeline = [
            ['$match' => ['$and' => [['merchant' => $this->merchant]]]],
            ['$group' => ['_id' => ['voucher' => '$voucher', 'status' => '$status'], 'usage' => ['$sum' => 1]]],
            ['$group' => ['_id' => '$_id.voucher', 'total_usage' => ['$sum' => '$usage'], 'detail' => ['$addToSet' => ['status' => '$_id.status', 'usage' => '$usage']]]],
            ['$lookup' => [
                'from' => 'voucher',
                'localField' => '_id',
                'foreignField' => 'code',
                'as' => 'vouchers'
            ]],
            ['$project' => ['_id' => '$_id', 'type' => ['$arrayElemAt' => ['$vouchers.type', 0]], 'nominal' => ['$arrayElemAt' => ['$vouchers.nominal', 0]], 'total_usage' => '$total_usage', 'detail' => '$detail']],
            ['$match' => ['$and' => [$where]]],
            ['$sort'  => $order]
        ];
        if ($x) {
            $pipeline = array_merge($pipeline, [['$skip' => (int)$start]]);
            $pipeline = array_merge($pipeline, [['$limit' => (int)$limit]]);
        }
        $orders = $this->aratadb->aggregate('orders', $pipeline);
        foreach ($orders as $ord) {
            foreach ($ord['detail'] as $detail) {
                $ord[$detail->status] = $detail->usage;
            }
            unset($ord['detail']);
            $result[] = $ord;
        }
        return $result;
    }
    private function filter_report($where, $order, $limit, $start, $search, $where_search)
    {
        $pipe = [
            ['$match' => ['$and' => [['merchant' => $this->merchant]]]],
            ['$group' => ['_id' => ['voucher' => '$voucher', 'status' => '$status'], 'usage' => ['$sum' => 1]]],
            ['$group' => ['_id' => '$_id.voucher', 'total_usage' => ['$sum' => '$usage'], 'detail' => ['$addToSet' => ['status' => '$_id.status', 'usage' => '$usage']]]],
            ['$lookup' => [
                'from' => 'voucher',
                'localField' => '_id',
                'foreignField' => 'code',
                'as' => 'vouchers'
            ]],
            ['$project' => ['_id' => '$_id', 'type' => ['$arrayElemAt' => ['$vouchers.type', 0]], 'nominal' => ['$arrayElemAt' => ['$vouchers.nominal', 0]], 'total_usage' => '$total_usage', 'detail' => '$detail']],
            ['$match' => ['$and' => [$where]]]
        ];
        $result['all_data'] = count($this->aratadb->aggregate('orders', $pipe));
        $result['show_data'] = $this->pipeline_report($where, $order, $limit, $start);
        if ($search) {
            $where = array_merge($where, $where_search);
            $result['show_data'] = $this->pipeline_report($where, $order, $limit, $start);
        }
        $result['filter_data'] = count($result['show_data']);
        if ($limit != -1) {
            $result['show_data'] = $this->pipeline_report($where, $order, $limit, $start, 'limit');
        }
        return $result;
    }
    private function callback_report($result)
    {
        $callback = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $result['all_data'],
            'recordsFiltered' => $result['filter_data'],
            'data' => $result['show_data']
        );
        return $callback;
    }
    function serverside_report($data)
    {
        $params = $this->params_report();
        $where['$nor'] = [['_id' => null], ['_id' => '']];
        $result = $this->filter_report($where, $params['$order'], $params['limit'], $params['start'], $params['search'], $data['where_search']);
        $callback = $this->callback_report($result);
        return json_encode($callback);
    }
}
