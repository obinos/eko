<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('mongo_db', array('activate' => 'arata'), 'aratadb');
        $this->merchant = '606eba1c099777608a38aeda';
    }
    public function dataCustomer($id = null)
    {
        $params['merchant'] = $this->merchant;
        if ($id) {
            $dt = $this->aratadb->get_where('customers', ['_id' => $id]);
        } else {
            $pipeline = [
                ['$match' => ['$and' => [$params]]],
                ['$project' => ['lowername' => ['$toLower' => '$name'], 'name' => '$name', 'phone' => '$phone', 'shipping_address' => '$shipping_address', 'order_seq' => '$order_seq', 'created_at' => '$created_at', 'updated_at' => '$updated_at']],
                ['$sort'  => ['lowername' => 1]]
            ];
            $dt = $this->aratadb->aggregate('customers', $pipeline);
        }
        if (!$dt) {
            return [];
        } else {
            return $dt;
        }
    }
    public function addCustomer($json)
    {
        foreach ($json->address as $keys => $val) {
            $main_address = $val->main_address ? true : false;
            $data_address = [
                "title"           => $val->shipping_name,
                "address"         => $val->shipping_address,
                "is_main_address" => $main_address,
                "latitude"        => $val->latitude,
                "longitude"       => $val->longitude,
                "id_cluster"      => $val->id_cluster
            ];
            $address[] = $data_address;
        }
        $data = [
            "_id"              => (string) new MongoDB\BSON\ObjectId(),
            "merchant"         => $this->merchant,
            "name"             => $json->name,
            "phone"            => nohpplus($json->phone),
            "preferences"      => $json->preferences,
            "shipping_address" => $address,
            "created_at"       => $this->mongo_db->date(),
            "updated_at"       => $this->mongo_db->date()
        ];
        $result = $this->aratadb->insert('customers', $data);
        if ($result) {
            $result += ['status' => 'success'];
        } else {
            $result = ['status' => 'failed'];
        }
        return $result;
    }
    public function editCustomer($json)
    {
        $params['_id'] = $json->_id;
        foreach ($json->address as $keys => $val) {
            $main_address = $val->main_address ? true : false;
            $data_address = [
                "title"           => $val->shipping_name,
                "address"         => $val->shipping_address,
                "is_main_address" => $main_address,
                "latitude"        => $val->latitude,
                "longitude"       => $val->longitude,
                "id_cluster"      => $val->id_cluster
            ];
            $address[] = $data_address;
        }
        $customers = [
            "name"             => $json->name,
            "phone"            => nohpplus($json->phone),
            "preferences"      => $json->preferences,
            "shipping_address" => $address,
            "updated_at"       => $this->mongo_db->date()
        ];
        $db = $this->aratadb->where($params)->set($customers)->update('customers');
        if ($db->getModifiedCount() === 0) {
            $result = [
                'status' => 'failed',
                'text'   => 'data yg diupdate salah'
            ];
        } else {
            $result = [
                'status' => 'success'
            ];
        }
        return $result;
    }
    public function deleteCustomer($id)
    {
        $params['_id'] = $id;
        $customers = $this->aratadb->where($params)->get('customers');
        $db = $this->aratadb->where($params)->delete('customers');
        if ($db->getDeletedCount() === 0) {
            $result = [
                'status' => 'failed',
                'name'   => $customers[0]['name'],
                'id'     => $id
            ];
        } else {
            $result = [
                'status' => 'success',
                'name'   => $customers[0]['name'],
                'id'     => $id
            ];
        }
        return $result;
    }
    public function checkCustomer($phone)
    {
        return $this->aratadb->get_where('customers', ['phone' => $phone, "merchant" => $this->merchant]);
    }
    public function groupCustomer($circle = null)
    {
        $params['merchant'] = $this->merchant;
        $params['status'] = "closed";
        $customer = $this->pipelinegroup($params);
        $params['status'] = "canceled";
        $cancel = $this->pipelinegroup($params);
        foreach ($cancel as $can) {
            $key = array_search($can['_id'], array_column($customer, "_id"));
            if ($key === false && strlen($can['_id']) > 12) {
                $result['circle1;LEAD;bg-secondary;#d9d9d9'][] = $can;
            }
        }
        foreach ($customer as $cust) {
            if (strlen($cust['_id']) > 12) {
                if ($cust['order'] == 1) {
                    $result['circle2;Order 1x;bg-danger;#fd8665'][] = $cust;
                } elseif ($cust['order'] == 2) {
                    $result['circle3;Order 2x;bg-warning;#fabe0f'][] = $cust;
                } elseif ($cust['order'] == 3) {
                    $result['circle4;Order 3x;bg-primary;#8ab662'][] = $cust;
                } elseif ($cust['order'] <= 10) {
                    $result['circle5;Order 4-10x;bg-success;#24bbb3'][] = $cust;
                } elseif ($cust['order'] <= 30) {
                    $result['circle6;Order 11-30x;bg-success;#24bbb3'][] = $cust;
                } elseif ($cust['order'] <= 60) {
                    $result['circle7;Order 31-60x;bg-success;#24bbb3'][] = $cust;
                } elseif ($cust['order'] > 60) {
                    $result['circle8;Order >60x;bg-success;#24bbb3'][] = $cust;
                }
            }
        }
        foreach ($result as $key => $res) {
            $array = explode(";", $key);
            $result2['title'] = $array[1];
            $result2['icon'] = $array[0];
            $result2['bg'] = $array[2];
            $result2['color'] = $array[3];
            $result2['count'] = count($res);
            $result2['data'] = $res;
            $final[$array[0]] = $result2;
        }
        if ($circle) {
            return $final[$circle];
        } else {
            return $final;
        }
    }
    private function pipelinegroup($params)
    {
        $pipeline = [
            ['$match' => ['$and' => [$params]]],
            ['$group' => ['_id' => '$customer.phone', 'first' => ['$first' => '$transaction_date'], 'last' => ['$last' => '$transaction_date'], 'name' => ['$last' => '$customer.name'], 'address' => ['$last' => '$customer.address'], 'order' => ['$sum' => 1], 'total' => ['$sum' => '$price.total']]],
            ['$project' => ['_id' => '$_id', 'first' => ['$dateToString' => ['format' => '%Y%m%d %d-%m-%Y', 'date' => '$first', 'timezone' => '+07:00']], 'last' => ['$dateToString' => ['format' => '%Y%m%d %d-%m-%Y', 'date' => '$last', 'timezone' => '+07:00']], 'name' => '$name', 'address' => '$address', 'order' => '$order', 'total' => '$total']],
            ['$sort'  => ['order' => 1]]
        ];
        $result = $this->aratadb->aggregate('orders', $pipeline);
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
                'from' => 'orders',
                'let' => ['phone' => '$phone'],
                'pipeline' => [[
                    '$match' => [
                        '$expr' => ['$eq' => ['$customer.phone', '$$phone']],
                        'merchant' => $this->merchant
                    ]
                ]],
                'as' => 'order'
            ]],
            ['$match' => ['$and' => [$where]]],
            ['$project' => ['_id' => '$_id', 'created_at' => ['$dateToString' => ['format' => '%Y%m%d%H%M %d-%m-%Y', 'date' => '$created_at', 'timezone' => '+07:00']], 'name' => '$name', 'phone' => '$phone', 'order' => ['$size' => '$order'], 'total' => ['$sum' => '$order.price.total'], 'count_address' => ['$cond' => ['if' => ['$isArray' => '$shipping_address'], 'then' => ['$size' => '$shipping_address'], 'else' => 'NA']]]],
            ['$sort'  => $order]
        ];
        if ($x) {
            $pipeline = array_merge($pipeline, [['$skip' => (int)$start]]);
            $pipeline = array_merge($pipeline, [['$limit' => (int)$limit]]);
        }
        $result = $this->aratadb->aggregate('customers', $pipeline);
        return $result;
    }
    private function filter($where, $order, $limit, $start, $search, $where_search)
    {
        $result['all_data'] = $this->aratadb->where($where)->count('customers');
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
        $where['merchant'] = $this->merchant;
        $result = $this->filter($where, $params['$order'], $params['limit'], $params['start'], $params['search'], $data['where_search']);
        $callback = $this->callback($result);
        return json_encode($callback);
    }
    private function params2()
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
    private function pipeline2($where, $order, $limit = null, $start = null, $x = null)
    {
        $pipeline = [
            ['$match' => ['$and' => [['merchant' => $this->merchant]]]],
            ['$lookup' => [
                'from' => 'orders',
                'localField' => 'phone',
                'foreignField' => 'customer.phone',
                'as' => 'data'
            ]],
            ['$project' => ['_id' => '$_id', 'merchant' => '$merchant', 'created_at' => ['$dateToString' => ['format' => '%Y%m%d%H%M %d-%m-%Y', 'date' => '$created_at', 'timezone' => '+07:00']], 'last' => ['$dateToString' => ['format' => '%Y%m%d%H%M %d-%m-%Y', 'date' => ['$arrayElemAt' => ['$data.created_at', -1]], 'timezone' => '+07:00']], 'name' => '$name', 'phone' => '$phone', 'order_seq' => '$order_seq']],
            ['$match' => ['$and' => [$where]]],
            ['$sort'  => $order]
        ];
        if ($x) {
            $pipeline = array_merge($pipeline, [['$skip' => (int)$start]]);
            $pipeline = array_merge($pipeline, [['$limit' => (int)$limit]]);
        }
        $result = $this->aratadb->aggregate('customers', $pipeline);
        return $result;
    }
    private function filter2($where, $order, $limit, $start, $search, $where_search)
    {
        $result['all_data'] = $this->aratadb->where($where)->count('customers');
        $result['show_data'] = $this->pipeline2($where, $order, $limit, $start);
        if ($search) {
            $where = array_merge($where, $where_search);
            $result['show_data'] = $this->pipeline2($where, $order, $limit, $start);
        }
        $result['filter_data'] = count($result['show_data']);
        if ($limit != -1) {
            $result['show_data'] = $this->pipeline2($where, $order, $limit, $start, 'limit');
        }
        return $result;
    }
    private function callback2($result)
    {
        $callback = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $result['all_data'],
            'recordsFiltered' => $result['filter_data'],
            'data' => $result['show_data']
        );
        return $callback;
    }
    function serverside2($data)
    {
        $params = $this->params2();
        $where['merchant'] = $this->merchant;
        $result = $this->filter2($where, $params['$order'], $params['limit'], $params['start'], $params['search'], $data['where_search']);
        $callback = $this->callback2($result);
        return json_encode($callback);
    }
    private function params3()
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
    private function pipeline3($where, $order, $limit = null, $start = null, $x = null)
    {
        $pipeline = [
            ['$match' => ['$and' => [['merchant' => $this->merchant]]]],
            ['$lookup' => [
                'from' => 'orders',
                'localField' => 'phone',
                'foreignField' => 'customer.phone',
                'as' => 'data'
            ]],
            ['$project' => ['_id' => '$_id', 'merchant' => '$merchant', 'name' => '$name', 'phone' => '$phone', 'address' => [
                '$reduce' => [
                    'input' => '$shipping_address.address',
                    'initialValue' => '',
                    'in' => ['$concat' => ['$$value', " - ", '$$this']]
                ]
            ], 'count_address' => ['$cond' => ['if' => ['$isArray' => '$shipping_address'], 'then' => ['$size' => '$shipping_address'], 'else' => 'NA']]]],
            ['$match' => ['$and' => [$where]]],
            ['$sort'  => $order]
        ];
        if ($x) {
            $pipeline = array_merge($pipeline, [['$skip' => (int)$start]]);
            $pipeline = array_merge($pipeline, [['$limit' => (int)$limit]]);
        }
        $result = $this->aratadb->aggregate('customers', $pipeline);
        return $result;
    }
    private function filter3($where, $order, $limit, $start, $search, $where_search)
    {
        $result['all_data'] = $this->aratadb->where($where)->count('customers');
        $result['show_data'] = $this->pipeline3($where, $order, $limit, $start);
        if ($search) {
            $where = array_merge($where, $where_search);
            $result['show_data'] = $this->pipeline3($where, $order, $limit, $start);
        }
        $result['filter_data'] = count($result['show_data']);
        if ($limit != -1) {
            $result['show_data'] = $this->pipeline3($where, $order, $limit, $start, 'limit');
        }
        return $result;
    }
    private function callback3($result)
    {
        $callback = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $result['all_data'],
            'recordsFiltered' => $result['filter_data'],
            'data' => $result['show_data']
        );
        return $callback;
    }
    function serverside3($data)
    {
        $params = $this->params3();
        $where['merchant'] = $this->merchant;
        $result = $this->filter3($where, $params['$order'], $params['limit'], $params['start'], $params['search'], $data['where_search']);
        $callback = $this->callback3($result);
        return json_encode($callback);
    }
}
