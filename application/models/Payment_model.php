<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('mongo_db', array('activate' => 'arata'), 'aratadb');
        $this->merchant = '606eba1c099777608a38aeda';
    }
    public function dataPayment($id = null)
    {
        if ($id) {
            $dt = $this->aratadb->get_where('payment_types', ['_id' => $id, 'merchant' => $this->merchant]);
        } else {
            $dt = $this->aratadb->order_by(['name' => 'ASC'])->where(['merchant' => $this->merchant])->get('payment_types');
        }
        if (!$dt) {
            return [];
        } else {
            return $dt;
        }
    }
    public function checkPayment($accountno)
    {
        return $this->aratadb->get_where('payment_types', ['accountno' => $accountno]);
    }
    public function addPayment($json)
    {
        $created_at = $this->mongo_db->date();
        $active = $json->active === 'true' ? true : false;
        $is_payment = $json->is_payment === 'true' ? true : false;
        $data = [
            "_id"        => (string) new MongoDB\BSON\ObjectId(),
            "merchant"   => $this->merchant,
            "name"       => $json->name,
            "accountno"  => $json->accountno,
            "active"     => $active,
            "created_at" => $created_at
        ];
        if ($is_payment) {
            $ispayment = [
                "is_payment" => $is_payment
            ];
            $data = array_merge($data, $ispayment);
        }
        $result = $this->aratadb->insert('payment_types', $data);
        if ($result) {
            $result['created_at'] = datephp('d-m-Y', $created_at);
            $result += ['ispayment' => $is_payment];
            $result += ['status' => 'success'];
            $result += ['action' => 'Add'];
            return $result;
        } else {
            $result = ['status' => 'failed'];
            $result = ['action' => 'Add'];
            return $result;
        }
    }
    public function editPayment($json)
    {
        $updated_at = $this->mongo_db->date();
        $active = $json->active === 'true' ? true : false;
        $is_payment = $json->is_payment === 'true' ? true : null;
        $params['_id'] = $json->_id;
        $update = [
            "name"       => $json->name,
            "accountno"  => $json->accountno,
            "active"     => $active,
            "is_payment" => $is_payment,
            "updated_at" => $updated_at
        ];
        $db = $this->aratadb->where($params)->set($update)->update('payment_types');
        if ($db->getModifiedCount() === 0) {
            $result = [
                'action' => 'Edit',
                'status' => 'failed',
                'name'   => $json->name
            ];
        } else {
            $result = [
                'action'     => 'Edit',
                'status'     => 'success',
                '_id'        => $json->_id,
                'name'       => $json->name,
                "accountno"  => $json->accountno,
                "active"     => $active,
                "is_payment" => $is_payment,
                "updated_at" => datephp('d-m-Y', $updated_at)
            ];
        }
        return $result;
    }
    public function deletePayment($id)
    {
        $params['_id'] = $id;
        $params['merchant'] = $this->merchant;
        $payment_types = $this->aratadb->where($params)->get('payment_types');
        $db = $this->aratadb->where($params)->delete('payment_types');
        if ($db->getDeletedCount() === 0) {
            $result = [
                'status' => 'failed',
                'name'   => $payment_types[0]['name'],
                'id'     => $id
            ];
        } else {
            $result = [
                'status' => 'success',
                'name'   => $payment_types[0]['name'],
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
            ['$match' => ['$and' => [['merchant' => $this->merchant, '$or' => [['status' => 'onprocess'], ['status' => 'closed']]]]]],
            ['$unwind' => '$payment'],
            ['$project' => ['transaction_date' => ['$dateToString' => ['format' => '%Y%m%d %d-%m-%Y', 'date' => '$transaction_date', 'timezone' => '+07:00']], 'deliverytime' => '$transaction_date', 'delivery_time' => ['$dateToString' => ['format' => '%Y%m%d %d-%m-%Y', 'date' => '$delivery_time', 'timezone' => '+07:00']], 'invno' => '$invno', 'customer' => '$customer.name', 'paid_at' => ['$ifNull' => [['$dateToString' => ['format' => '%Y%m%d %d-%m-%Y', 'date' => '$payment.paid_at', 'timezone' => '+07:00']], "-"]], 'method' => '$payment.method', 'payment_amount' => ['$toString' => ['$ifNull' => ['$payment.payment_amount', '0']]], 'total' => ['$toString' => '$price.total'], 'merchant' => '$merchant', 'status' => '$status']],
            ['$match' => ['$and' => [$where]]],
            ['$sort'  => $order]
        ];
        if ($x) {
            $pipeline = array_merge($pipeline, [['$skip' => (int)$start]]);
            $pipeline = array_merge($pipeline, [['$limit' => (int)$limit]]);
        }
        $result = $this->aratadb->aggregate('orders', $pipeline);
        return $result;
    }
    private function filter($where, $order, $limit, $start, $search, $where_search)
    {
        $pipe = [
            ['$match' => ['$and' => [['merchant' => $this->merchant, '$or' => [['status' => 'onprocess'], ['status' => 'closed']]]]]],
            ['$unwind' => '$payment'],
            ['$project' => ['deliverytime' => '$transaction_date', 'method' => '$payment.method', 'payment_amount' => ['$toString' => ['$ifNull' => ['$payment.payment_amount', '0']]], 'merchant' => '$merchant', 'status' => '$status']],
            ['$match' => ['$and' => [$where]]]
        ];
        $result['all_data'] = count($this->aratadb->aggregate('orders', $pipe));
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
        $where = ['merchant' => $this->merchant, '$or' => [['status' => 'onprocess'], ['status' => 'closed']]];
        if ($data['start'] and $data['end']) {
            $startDate = $this->mongo_db->date(strtotime($data['start']) * 1000);
            $endDate = $this->mongo_db->date((strtotime($data['end']) + 86399) * 1000);
            $where_date = ['deliverytime' => ['$gte' => $startDate, '$lte' => $endDate]];
            $where = array_merge($where, $where_date);
        }
        if ($data['payment']) {
            $where_payment = ['method' => new MongoDB\BSON\Regex($data['payment'], 'i')];
            $where = array_merge($where, $where_payment);
        }
        $result = $this->filter($where, $params['$order'], $params['limit'], $params['start'], $params['search'], $data['where_search']);
        $callback = $this->callback($result);
        return json_encode($callback);
    }
}
