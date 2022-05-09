<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Adjustment_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('mongo_db', array('activate' => 'arata'), 'aratadb');
        $this->merchant = '606eba1c099777608a38aeda';
    }
    public function dataAdjustment($id)
    {
        $pipeline = [
            ['$match' => ['$and' => [['_id' => $id]]]],
            ['$unwind' => '$items'],
            ['$lookup' => [
                'from' => 'items',
                'localField' => 'items.id_item',
                'foreignField' => '_id',
                'as' => 'item'
            ]],
            ['$lookup' => [
                'from' => 'superuser',
                'localField' => 'maker',
                'foreignField' => '_id',
                'as' => 'usermaker'
            ]],
            ['$project' => ['no' => '$no', 'created_at' => ['$dateToString' => ['format' => '%d-%m-%Y %H:%M', 'date' => '$created_at', 'timezone' => '+07:00']], 'usermaker' => ['$arrayElemAt' => ['$usermaker.name', 0]], 'items.id_item' => '$items.id_item', 'items.physic' => '$items.physic', 'items.good' => '$items.good', 'items.damage' => '$items.damage', 'items.reject' => '$items.reject', 'items.difference' => '$items.difference', 'items.hpp' => '$items.hpp', 'items.name' => ['$arrayElemAt' => ['$item.name', 0]], 'items.barcode' => ['$arrayElemAt' => ['$item.barcode', 0]], 'items.stock' => ['$arrayElemAt' => ['$item.stock', 0]], 'items.active' => ['$arrayElemAt' => ['$item.active', 0]], 'items.table' => ['$cond' => ['if' => ['$eq' => ['$items.difference', 0]], 'then' => null, 'else' => 'table-warning']], 'total' => '$total', 'notes' => '$notes']],
            ['$group' => ['_id' => ['id' => '$_id', 'no' => '$no', 'created_at' => '$created_at', 'total' => '$total', 'notes' => '$notes', 'usermaker' => '$usermaker'], 'items' => ['$push' => '$items']]]
        ];
        $result = $this->aratadb->aggregate('adjustment', $pipeline);
        if (!$result) {
            return [];
        } else {
            return $result;
        }
    }
    public function dataAdjustmentWarehouse($id)
    {
        $pipeline = [
            ['$match' => ['$and' => [['_id' => $id]]]],
            ['$unwind' => '$items'],
            ['$lookup' => [
                'from' => 'items',
                'localField' => 'items.id_item',
                'foreignField' => '_id',
                'as' => 'item'
            ]],
            ['$lookup' => [
                'from' => 'superuser',
                'localField' => 'maker',
                'foreignField' => '_id',
                'as' => 'usermaker'
            ]],
            ['$project' => ['no' => '$no', 'created_at' => ['$dateToString' => ['format' => '%d-%m-%Y %H:%M', 'date' => '$created_at', 'timezone' => '+07:00']], 'usermaker' => ['$arrayElemAt' => ['$usermaker.name', 0]], 'items.id_item' => '$items.id_item', 'items.name' => ['$arrayElemAt' => ['$item.name', 0]], 'items.barcode' => ['$arrayElemAt' => ['$item.barcode', 0]], 'items.awal' => '$items.awal', 'items.transfer' => '$items.transfer', 'items.akhir' => '$items.akhir', 'notes' => '$notes']],
            ['$group' => ['_id' => ['id' => '$_id', 'no' => '$no', 'created_at' => '$created_at', 'notes' => '$notes', 'usermaker' => '$usermaker'], 'items' => ['$push' => '$items']]]
        ];
        $result = $this->aratadb->aggregate('adjustment', $pipeline);
        if (!$result) {
            return [];
        } else {
            return $result;
        }
    }
    public function checkItem($json)
    {
        $startDate = $this->mongo_db->date(strtotime("-1 week") * 1000);
        $params_adj['created_at']['$gte'] = $startDate;
        $adjustment = $this->aratadb->where($params_adj)->get('adjustment');
        $new_adjust = [];
        foreach ($adjustment as $adjust) {
            $new_adjust = array_merge($new_adjust, $adjust['items']);
        }
        foreach ($json->item as $key => $val) {
            $id_item[] = ['_id' => $val->_id];
        }
        $params['merchant'] = $this->merchant;
        $params['active'] = true;
        $params['$nor'] = $id_item;
        $params['stock']['$gte'] = 1;
        $items = $this->aratadb->select(['_id', 'name', 'stock', 'station'])->order_by(['station' => 'ASC'])->where($params)->get('items');
        $result['data'] = [];
        foreach ($items as $item) {
            $key = array_search($item['_id'], array_column($new_adjust, "id_item"));
            if ($key === false) {
                $result['data'][] = $item;
            }
        }
        return $result;
    }
    public function addAdjustment($json)
    {
        $this->load->model('Counter_model');
        $this->load->model('Stock_model');
        $counter = $this->Counter_model->get_counter('SO');
        $warehouse = $this->aratadb->get_where('warehouse', ['name' => 'Arata DC']);
        $_id = (string) new MongoDB\BSON\ObjectId();
        $now = $this->mongo_db->date();
        $total = 0;
        foreach ($json->item as $key => $val) {
            $difference = round((float)$val->difference, 2);
            $physic = (float)$val->physic;
            $params['_id'] = $val->_id;
            $params['merchant'] = '606eba1c099777608a38aeda';
            $get_items = $this->aratadb->where($params)->get('items');
            if ($get_items && !$get_items[0]['stock_default'] && $get_items[0]['stock_managed'] === true) {
                $array['id'] = $val->_id;
                $array['status'] = ['open', 'onprocess'];
                $stock = $this->Stock_model->stockOrder($array);
                $qty = $stock[0]['qty'] ? $stock[0]['qty'] : 0;
                $stock_item['stock'] = $physic - $qty;
                $this->aratadb->where($params)->set($stock_item)->update('items');
            }
            $data_item = [
                "id_item"    => $val->_id,
                "physic"     => $physic,
                "difference" => $difference,
                "hpp"        => (int)$val->hpp
            ];
            $item[] = $data_item;
            if ($difference != 0) {
                $total = $total + ($difference * (int)$val->hpp);
                $data_stock[$val->_id] = [
                    "_id"              => (string) new MongoDB\BSON\ObjectId(),
                    "id_item"          => $val->_id,
                    "id_warehouse"     => $warehouse[0]['_id'],
                    "batch"            => '-',
                    "qty"              => $difference,
                    "transaction_date" => $now,
                    "id_trans"         => $_id,
                    "type"             => 'adjustment',
                    "condition"        => 'good',
                    "created_at"       => $now
                ];
            }
        }
        if ($data_stock) {
            $this->aratadb->batch_insert('stocks', $data_stock);
        }
        $purchase = [
            "_id"        => $_id,
            "no"         => "SO-" . date('ymd') . "-" . $counter,
            "created_at" => $now,
            "maker"      => $this->session->userdata('id'),
            "items"      => $item,
            "total"      => $total,
            "notes"      => $json->notes
        ];
        $result = $this->aratadb->insert('adjustment', $purchase);
        if ($result) {
            $result += ['status' => 'success'];
        } else {
            $result['status'] = 'failed';
            $result['text'] = 'Server Error';
        }
        return $result;
    }
    public function addTransfer($json)
    {
        $this->load->model('Counter_model');
        $counter = $this->Counter_model->get_counter('TC');
        $warehouse = $this->aratadb->get_where('warehouse', ['name' => 'Arata DC']);
        $_id = (string) new MongoDB\BSON\ObjectId();
        $now = $this->mongo_db->date();
        foreach ($json->item as $key => $val) {
            $data_item["id_item"] = $array['id_item'] = $val->_id;
            $array['warehouse'] = $warehouse[0]['_id'];
            $array['now'] = $now;
            $array['id_trans'] = $_id;
            $array['type'] = 'transfer_condition';
            if ($val->good) {
                $data_item["good"] = (int)$val->good;
                $array['qty'] = (int)$val->good;
                $array['condition'] = 'good';
                $stock[] = $this->addStockTransfer($array);
            }
            if ($val->damage) {
                $data_item["damage"] = (int)$val->damage;
                $array['qty'] = (int)$val->damage;
                $array['condition'] = 'damage';
                $stock[] = $this->addStockTransfer($array);
            }
            if ($val->reject) {
                $data_item["reject"] = (int)$val->reject;
                $array['qty'] = (int)$val->reject;
                $array['condition'] = 'reject';
                $stock[] = $this->addStockTransfer($array);
            }
            $item[] = $data_item;
        }
        if ($stock) {
            $this->aratadb->batch_insert('stocks', $stock);
        }
        $purchase = [
            "_id"              => $_id,
            "no"               => "TC-" . date('ymd') . "-" . $counter,
            "created_at"       => $now,
            "maker"            => $this->session->userdata('id'),
            "items"            => $item,
            "notes"            => $json->notes
        ];
        $result = $this->aratadb->insert('adjustment', $purchase);
        if ($result) {
            $result += ['status' => 'success'];
        } else {
            $result['status'] = 'failed';
            $result['text'] = 'Server Error';
        }
        return $result;
    }
    private function addStockTransfer($array)
    {
        $stock = [
            "_id"              => (string) new MongoDB\BSON\ObjectId(),
            "id_item"          => $array['id_item'],
            "id_warehouse"     => $array['warehouse'],
            "batch"            => '-',
            "qty"              => $array['qty'],
            "transaction_date" => $array['now'],
            "id_trans"         => $array['id_trans'],
            "type"             => $array['type'],
            "condition"        => $array['condition'],
            "created_at"       => $array['now']
        ];
        return $stock;
    }
    public function dataTransfer()
    {
        $pipeline = [
            ['$group' => ['_id' => ['id_item' => '$id_item', 'condition' => '$condition'], 'id_item' => ['$last' => '$id_item'], 'condition' => ['$last' => '$condition'], 'stock' => ['$sum' => '$qty']]],
            ['$lookup' => [
                'from' => 'items',
                'let' => ['id_item' => '$id_item'],
                'pipeline' => [[
                    '$match' => [
                        '$expr' => ['$eq' => ['$_id', '$$id_item']],
                        'merchant' => $this->merchant
                    ]
                ]],
                'as' => 'item'
            ]],
            ['$project' => ['_id' => '$_id', 'id_item' => '$id_item', 'condition' => '$condition', 'stock' => '$stock', 'name' => ['$arrayElemAt' => ['$item.name', 0]], 'active' => ['$cond' => [['$arrayElemAt' => ['$item.active', 0]], "✅", "❌"]]]],
            ['$match' => ['$and' => [['$nor' => [['stock' => 0], ['name' => null]]]]]],
            ['$sort' => ['name' => 1]]
        ];
        $stock = $this->aratadb->aggregate('stocks', $pipeline);
        if (!$stock) {
            return [];
        } else {
            return $stock;
        }
    }
    public function dataTransferWarehouse()
    {
        $pipeline = [
            ['$group' => ['_id' => ['id_item' => '$id_item', 'condition' => '$condition'], 'id_item' => ['$last' => '$id_item'], 'condition' => ['$last' => '$condition'], 'stock' => ['$sum' => '$qty']]],
            ['$lookup' => [
                'from' => 'items',
                'let' => ['id_item' => '$id_item'],
                'pipeline' => [[
                    '$match' => [
                        '$expr' => ['$eq' => ['$_id', '$$id_item']],
                        'merchant' => $this->merchant
                    ]
                ]],
                'as' => 'item'
            ]],
            ['$project' => ['_id' => '$_id', 'id_item' => '$id_item', 'condition' => '$condition', 'stock' => '$stock', 'name' => ['$arrayElemAt' => ['$item.name', 0]], 'active' => ['$cond' => [['$arrayElemAt' => ['$item.active', 0]], "✅", "❌"]]]],
            ['$match' => ['$and' => [['$nor' => [['stock' => 0], ['name' => null]]]]]],
            ['$sort' => ['name' => 1]]
        ];
        $stock = $this->aratadb->aggregate('stocks', $pipeline);
        if (!$stock) {
            return [];
        } else {
            return $stock;
        }
    }
    public function addTransferWarehouse($json)
    {
        $this->load->model('Counter_model');
        $counter = $this->Counter_model->get_counter('TW');
        $_id = (string) new MongoDB\BSON\ObjectId();
        $now = $this->mongo_db->date();
        foreach ($json->item as $key => $val) {
            if ($val->_id) {
                $data_item["id_item"] = $array['id_item'] = $val->_id;
                $data_item["awal"] = (int)$val->awal;
                $data_item["transfer"] = (int)$val->transfer;
                $data_item["akhir"] = (int)$val->akhir;
                $item[] = $data_item;
                $array['warehouse'] = $json->store1;
                $array['qty'] = $data_item["transfer"] * -1;
                $array['now'] = $now;
                $array['id_trans'] = $_id;
                $array['type'] = 'transfer_warehouse';
                $array['condition'] = 'good';
                $stock[] = $this->addStockTransfer($array);
                $array['warehouse'] = $json->store2;
                $array['qty'] = $data_item["transfer"];
                $stock[] = $this->addStockTransfer($array);
            }
        }
        if ($stock) {
            $this->aratadb->batch_insert('stocks', $stock);
        }
        $purchase = [
            "_id"              => $_id,
            "no"               => "TW-" . date('ymd') . "-" . $counter,
            "created_at"       => $now,
            "maker"            => $this->session->userdata('id'),
            "items"            => $item,
            "notes"            => $json->notes
        ];
        $result = $this->aratadb->insert('adjustment', $purchase);
        if ($result) {
            $result += ['status' => 'success'];
        } else {
            $result['status'] = 'failed';
            $result['text'] = 'Server Error';
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
            ['$project' => ['no' => '$no', 'created_at' => ['$dateToString' => ['format' => '%Y%m%d%H%M %d-%m-%Y %H:%M', 'date' => '$created_at', 'timezone' => '+07:00']], 'usermaker' => ['$arrayElemAt' => ['$usermaker.name', 0]], 'items' => ['$cond' => ['if' => ['$isArray' => '$items'], 'then' => ['$size' => '$items'], 'else' => '0']], 'total' => '$total', 'notes' => '$notes']],
            ['$match' => ['$and' => [$where]]],
            ['$project' => ['no' => '$no', 'created_at' => '$created_at', 'usermaker' => '$usermaker', 'items' => '$items', 'total' => '$total', 'notes' => '$notes']],
            ['$sort'  => $order]
        ];
        if ($x) {
            $pipeline = array_merge($pipeline, [['$skip' => (int)$start]]);
            $pipeline = array_merge($pipeline, [['$limit' => (int)$limit]]);
        }
        $result = $this->aratadb->aggregate('adjustment', $pipeline);
        return $result;
    }
    private function filter($where, $order, $limit, $start, $search, $where_search)
    {
        $result['all_data'] = $this->aratadb->where($where)->count('adjustment');
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
        $where['no'] = new MongoDB\BSON\Regex($data['adjustment'], 'i');
        $result = $this->filter($where, $params['$order'], $params['limit'], $params['start'], $params['search'], $data['where_search']);
        $callback = $this->callback($result);
        return json_encode($callback);
    }
}
