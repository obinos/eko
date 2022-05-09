<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hpp_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('mongo_db', array('activate' => 'arata'), 'aratadb');
        $this->merchant = '606eba1c099777608a38aeda';
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
        if ($order_field && $ascdesc) {
            $params['$order'] = [$order_data => $sort];
        } else {
            $params['$order'] = ['active' => -1, 'station' => 1, 'lowername' => 1];
        }
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
            ['$match' => ['$and' => [['merchant' => $this->merchant]]]],
            ['$project' => ['lowername' => ['$toLower' => '$name'], 'barcode' => '$barcode', 'name' => '$name', 'active' => '$active', 'merchant' => '$merchant', 'price' => '$sales_price', 'id_supplier' => '$id_supplier', 'supplier' => ['$arrayElemAt' => ['$supplier.name', 0]], 'station' => '$station', 'hpp' => ['$ifNull' => ['$purchase_price.last.price', null]]]],
            ['$match' => ['$and' => [$where]]],
            ['$project' => ['lowername' => ['$toLower' => '$name'], 'barcode' => '$barcode', 'name' => '$name', 'active' => '$active', 'price' => '$price', 'id_supplier' => '$id_supplier', 'supplier' => '$supplier', 'station' => '$station', 'hpp' => '$hpp', 'percentage' => ['$cond' => ['if' => ['$gte' => ['$price', 1]], 'then' => ['$concat' => [['$toString' => ['$round' => [['$multiply' => [['$divide' => [['$subtract' => ['$price', '$hpp']], '$price']], 100]], 2]]], '%']], 'else' => null]]]],
            ['$sort'  => $order]
        ];
        if ($x) {
            $pipeline = array_merge($pipeline, [['$skip' => (int)$start]]);
            $pipeline = array_merge($pipeline, [['$limit' => (int)$limit]]);
        }
        $result = $this->aratadb->aggregate('items', $pipeline);
        return $result;
    }
    private function filter($where, $order, $limit, $start, $search, $where_search)
    {
        $result['all_data'] = $this->aratadb->where($where)->count('items');
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
        $where['merchant'] = $this->merchant;
        if ($data['supplier']) {
            $where_supplier = ['id_supplier' => $data['supplier']];
            $where = array_merge($where, $where_supplier);
        }
        $result = $this->filter($where, $params['$order'], $params['limit'], $params['start'], $params['search'], $data['where_search']);
        $callback = $this->callback($result);
        return json_encode($callback);
    }
}
