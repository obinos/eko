<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Purchase_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('mongo_db', array('activate' => 'arata'), 'aratadb');
    }
    public function dataPurchase($id = null)
    {
        if ($id) {
            $params['_id'] = $id;
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
                ['$match' => ['$and' => [$params]]],
                ['$project' => ['_id' => '$_id', 'created_at' => ['$dateToString' => ['format' => '%d-%m-%Y %H:%M', 'date' => '$created_at', 'timezone' => '+07:00']], 'transaction_date' => ['$dateToString' => ['format' => '%d-%m-%Y', 'date' => '$transaction_date', 'timezone' => '+07:00']], 'transactiondate' => '$transaction_date', 'no' => '$no', 'notes' => '$notes', 'id_supplier' => '$id_supplier', 'supplier' => ['$arrayElemAt' => ['$supplier.name', 0]], 'items' => '$items', 'total' => '$total', 'usermaker' => ['$arrayElemAt' => ['$usermaker.name', 0]], 'userupdate' => ['$arrayElemAt' => ['$userupdate.name', 0]], 'is_cancel' => '$is_cancel']]
            ];
            $dt = $this->aratadb->aggregate('purchase', $pipeline);
        } else {
            $dt = $this->aratadb->order_by(['no' => 'DESC'])->get('purchase');
        }
        return $dt;
    }
    public function addPurchase($json)
    {
        $this->load->model('Counter_model');
        $counter = $this->Counter_model->get_counter('IP');
        $warehouse = $this->aratadb->get_where('warehouse', ['name' => 'Arata DC']);
        $_id = (string) new MongoDB\BSON\ObjectId();
        $transaction_date = new MongoDB\BSON\UTCDateTime((new DateTime($json->date))->getTimestamp() * 1000);
        $now = $this->mongo_db->date();
        $item = $this->stockPurchase($json->item, $json->supplier, $warehouse[0]['_id'], $now, $_id);
        $purchase = [
            "_id"              => $_id,
            "no"               => "IP-" . date('ymd') . "-" . $counter,
            "id_supplier"      => $json->supplier,
            "transaction_date" => $transaction_date,
            "created_at"       => $now,
            "updated_at"       => $now,
            "maker"            => $this->session->userdata('id'),
            "notes"            => $json->notes,
            "file"             => $json->file,
            "items"            => $item,
            "total"            => (int)$json->total_buy
        ];
        if ($json->id_po) {
            $purchase += ['id_po' => $json->id_po];
            $params2['_id'] = $json->id_po;
            $update2['status'] = 'closed';
            $update2['updated_at'] = $this->mongo_db->date();
            $update2['who_update'] = $this->session->userdata('id');
            $this->aratadb->where($params2)->set($update2)->update('po');
        }
        $result = $this->aratadb->insert('purchase', $purchase);
        if ($result) {
            $result += ['status' => 'success'];
        } else {
            $result['status'] = 'failed';
            $result['text'] = 'Server Error';
        }
        return $result;
    }
    public function editPurchase($json)
    {
        $warehouse = $this->aratadb->get_where('warehouse', ['name' => 'Arata DC']);
        $this->itemPurchase($json->_id);
        $this->aratadb->where(['id_trans' => $json->_id])->delete_all('stocks');
        $transaction_date = new MongoDB\BSON\UTCDateTime((new DateTime($json->date))->getTimestamp() * 1000);
        $now = $this->mongo_db->date();
        $item = $this->stockPurchase($json->item, $json->supplier, $warehouse[0]['_id'], $now, $json->_id);
        $purchase = [
            "id_supplier"      => $json->supplier,
            "transaction_date" => $transaction_date,
            "updated_at"       => $this->mongo_db->date(),
            "who_update"       => $this->session->userdata('id'),
            "notes"            => $json->notes,
            "file"             => $json->file,
            "items"            => $item,
            "total"            => (int)$json->total_buy
        ];
        $params['_id'] = $json->_id;
        $db = $this->aratadb->where($params)->set($purchase)->update('purchase');
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
    public function cancelPurchase($id)
    {
        $params['_id'] = $id;
        $purchase = $this->aratadb->where($params)->get('purchase');
        if ($purchase[0]['is_cancel'] !== true) {
            $this->itemPurchase($id);
            $this->aratadb->where(['id_trans' => $id])->delete_all('stocks');
            // unlink("./assets/uploads/invoice/" . $purchase[0]['file']);
            // unlink("./assets/uploads/invoice/thumbnail/" . $purchase[0]['file']);
            $cancel['is_cancel'] = true;
            $cancel['who_update'] = $this->session->userdata('id');
            $cancel['updated_at'] = $this->mongo_db->date();
            $db = $this->aratadb->where($params)->set($cancel)->update('purchase');
            if ($db->getModifiedCount() === 0) {
                $result = [
                    'status' => 'failed',
                    'no'   => $purchase[0]['no']
                ];
            } else {
                $result = [
                    'status' => 'success',
                    'no'   => $purchase[0]['no']
                ];
            }
        } else {
            $result = [
                'status' => 'failed',
                'no'   => $purchase[0]['no']
            ];
        }
        return $result;
    }
    public function itemPurchase($id)
    {
        $params['_id'] = $id;
        $pipeline = [
            ['$match' => ['$and' => [$params]]],
            ['$unwind' => '$items'],
            ['$lookup' => [
                'from' => 'items',
                'localField' => 'items.id_item',
                'foreignField' => '_id',
                'as' => 'data'
            ]],
            ['$project' => ['_id' => '$items.id_item', 'no' => '$no', 'qty' => '$items.qty', 'price' => '$items.price', 'total_price' => '$items.total_price', 'stock' => ['$arrayElemAt' => ['$data.stock', 0]], 'stock_default' => ['$arrayElemAt' => ['$data.stock_default', 0]], 'stock_managed' => ['$arrayElemAt' => ['$data.stock_managed', 0]], 'purchase_price' => ['$arrayElemAt' => ['$data.purchase_price', 0]]]]
        ];
        $result = $this->aratadb->aggregate('purchase', $pipeline);
        foreach ($result as $op) {
            if (!$op['stock_default'] || $op['stock_default'] == 0 || $op['stock_default'] == '0' || $op['stock_default'] == '' || $op['stock_default'] == null) {
                if ($op['stock_managed'] === true) {
                    $old_item['stock'] = $op['stock'] - $op['qty'];
                    $old_avg = $old_item['stock'] > 0 ? ceil((($op['stock'] * $op['purchase_price']->avg_price) - $op['total_price']) / $old_item['stock']) : 0;
                } else {
                    $old_avg = $this->lastPrice($op['_id'], $op['no']);
                }
            } else {
                $old_avg = $this->lastPrice($op['_id'], $op['no']);
            }
            $old_item['purchase_price']['last']['price'] = $old_avg;
            $old_item['purchase_price']['last']['updated_at'] = $this->mongo_db->date();
            $old_item['purchase_price']['avg_price'] = $old_avg;
            $this->aratadb->where(['_id' => $op['_id']])->set($old_item)->update('items');
        }
    }
    public function stockPurchase($itempurchase, $id_supplier, $id_warehouse, $now, $_id)
    {
        foreach ($itempurchase as $key => $val) {
            $qty_pack = round((int)$val->qty_pack, 2);
            $price_pack = (int)$val->price_pack;
            $params['_id'] = $val->_id;
            $params['merchant'] = '606eba1c099777608a38aeda';
            $get_items = $this->aratadb->where($params)->get('items');
            if ($get_items && $price_pack != 0) {
                $avg = $price_pack;
                if (!$get_items[0]['stock_default'] || $get_items[0]['stock_default'] == 0 || $get_items[0]['stock_default'] == '0' || $get_items[0]['stock_default'] == '' || $get_items[0]['stock_default'] == null) {
                    if ($get_items[0]['stock_managed'] === true) {
                        $stock_item['stock'] = $get_items[0]['stock'] + $qty_pack;
                        $avg_item = $get_items[0]['purchase_price']->avg_price ? $get_items[0]['purchase_price']->avg_price : 0;
                        $qty_item = $get_items[0]['stock'] > 0 ? $get_items[0]['stock'] : 0;
                        $avg = ceil((($qty_item * $avg_item) + ($qty_pack * $price_pack)) / ($qty_item + $qty_pack));
                    }
                }
                if (!$get_items[0]['id_supplier']) {
                    $stock_item['id_supplier'] =  $id_supplier;
                }
                $stock_item['purchase_price']['last']['price'] = $price_pack;
                $stock_item['purchase_price']['last']['updated_at'] = $this->mongo_db->date();
                $stock_item['purchase_price']['last']['id_supplier'] = $id_supplier;
                $stock_item['purchase_price']['avg_price'] = $avg;
                $this->aratadb->where($params)->set($stock_item)->update('items');
            }
            $data_item = [
                "id_item"     => $val->_id,
                "qty_unit"    => (int)$val->qty_beli,
                "qty"         => $qty_pack,
                "price"       => $price_pack,
                "total_price" => (int)$val->total_price,
                "unit"        => $val->weight_unit
            ];
            $item[] = $data_item;
            $data_stock = [
                "_id"              => (string) new MongoDB\BSON\ObjectId(),
                "id_item"          => $val->_id,
                "id_warehouse"     => $id_warehouse,
                "batch"            => '-',
                "qty"              => $qty_pack,
                "transaction_date" => $now,
                "id_trans"         => $_id,
                "type"             => 'purchase',
                "condition"        => 'good',
                "created_at"       => $now
            ];
            $stock[] = $data_stock;
        }
        $this->aratadb->batch_insert('stocks', $stock);
        return $item;
    }
    public function avgPrice($id)
    {
        $params['items.id_item'] = $id;
        $pipeline = [
            ['$match' => ['$and' => [$params]]],
            ['$unwind' => '$items'],
            ['$match' => ['$and' => [$params]]],
            ['$sort'  => ['transaction_date' => -1]],
            ['$limit'  => 3],
            ['$group' => ['_id' => '$items.id_item', 'count' => ['$sum' => 1], 'nominal' => ['$sum' => '$items.price']]],
            ['$project' => ['avg' => ['$round' => [['$divide' => ['$nominal', '$count']], 0]]]]
        ];
        $purchase = $this->aratadb->aggregate('purchase', $pipeline);
        $result = $purchase[0]['avg'] ? $purchase[0]['avg'] : 0;
        return $result;
    }
    public function lastPrice($id, $no)
    {
        $params2['items.id_item'] = $id;
        $purchase = $this->aratadb->limit(2)->order_by(['transaction_date' => 'DESC'])->where($params2)->get('purchase');
        $price = 0;
        foreach ($purchase as $p) {
            if ($p['no'] != $no) {
                foreach ($p['items'] as $k => $itm) {
                    if ($itm->id_item == $id) {
                        $price = $itm->price;
                    }
                }
            }
        }
        return $price;
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
            ['$project' => ['_id' => '$_id', 'created_at' => '$created_at', 'created_at1' => ['$dateToString' => ['format' => '%Y%m%d%H%M %d-%m-%Y %H:%M', 'date' => '$created_at', 'timezone' => '+07:00']], 'updated_at' => ['$dateToString' => ['format' => '%Y%m%d%H%M %d-%m-%Y %H:%M', 'date' => '$updated_at', 'timezone' => '+07:00']], 'transaction_date' => ['$dateToString' => ['format' => '%Y%m%d%H%M %d-%m-%Y', 'date' => '$transaction_date', 'timezone' => '+07:00']], 'no' => '$no', 'notes' => '$notes', 'supplier' => ['$arrayElemAt' => ['$supplier.name', 0]], 'total' => '$total', 'usermaker' => ['$arrayElemAt' => ['$usermaker.name', 0]], 'userupdate' => ['$arrayElemAt' => ['$userupdate.name', 0]], 'is_cancel' => '$is_cancel']],
            ['$match' => ['$and' => [$where]]],
            ['$project' => ['_id' => '$_id', 'created_at1' => '$created_at1', 'created_at' => '$created_at', 'updated_at' => '$updated_at', 'transaction_date' => '$transaction_date', 'no' => '$no', 'notes' => '$notes', 'supplier' => '$supplier', 'total' => '$total', 'usermaker' => '$usermaker', 'userupdate' => '$userupdate', 'is_cancel' => '$is_cancel']],
            ['$sort'  => $order]
        ];
        if ($x) {
            $pipeline = array_merge($pipeline, [['$skip' => (int)$start]]);
            $pipeline = array_merge($pipeline, [['$limit' => (int)$limit]]);
        }
        $result = $this->aratadb->aggregate('purchase', $pipeline);
        return $result;
    }
    private function filter($where, $order, $limit, $start, $search, $where_search)
    {
        $result['all_data'] = $this->aratadb->where($where)->count('purchase');
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
        if ($data['start'] and $data['end']) {
            $startDate = $this->mongo_db->date(strtotime($data['start']) * 1000);
            $endDate = $this->mongo_db->date((strtotime($data['end']) + 86399) * 1000);
            $where_date = ['created_at' => ['$gte' => $startDate, '$lte' => $endDate]];
            $where = array_merge($where, $where_date);
        }
        $result = $this->filter($where, $params['$order'], $params['limit'], $params['start'], $params['search'], $data['where_search']);
        $callback = $this->callback($result);
        return json_encode($callback);
    }
}
