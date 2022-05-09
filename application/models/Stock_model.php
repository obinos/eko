<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('mongo_db', array('activate' => 'arata'), 'aratadb');
        $this->merchant = '606eba1c099777608a38aeda';
        $this->main_warehouse = '60fbe096ba0f658aaccc0340';
    }
    public function allStock($condition, $id_warehouse = null)
    {
        $warehouse = $id_warehouse ? $id_warehouse : $this->main_warehouse;
        $params['condition'] = $condition;
        $params['id_warehouse'] = $warehouse;
        if ($id_warehouse) {
            $pipeline = [
                ['$match' => ['$and' => [$params]]],
                ['$group' => ['_id' => '$id_item', 'stock' => ['$sum' => ['$round' => ['$qty', 1]]]]],
                ['$lookup' => [
                    'from' => 'items',
                    'localField' => '_id',
                    'foreignField' => '_id',
                    'as' => 'items'
                ]],
                ['$project' => ['_id' => '$_id', 'name' => ['$arrayElemAt' => ['$items.name', 0]], 'stock' => '$stock', 'active' => ['$cond' => [['$arrayElemAt' => ['$items.active', 0]], "✅", "❌"]]]],
                ['$sort' => ['stock' => -1]]
            ];
        } else {
            $pipeline = [
                ['$match' => ['$and' => [$params]]],
                ['$group' => ['_id' => '$id_item', 'stock' => ['$sum' => ['$round' => ['$qty', 1]]]]],
                ['$sort' => ['stock' => -1]]
            ];
        }
        $result = $this->aratadb->aggregate('stocks', $pipeline);
        if (!$result) {
            return [];
        } else {
            return $result;
        }
    }
    public function dataStock($id_warehouse = null)
    {
        $params['$nor'] = [['_id' => null]];
        if ($id_warehouse) {
            $params['id_warehouse'] = $id_warehouse;
        }
        $pipeline = [
            ['$match' => ['$and' => [$params]]],
            ['$group' => ['_id' => ['$concat' => ['$id_item', '-', '$condition']], 'stock' => ['$sum' => ['$round' => ['$qty', 1]]]]],
            ['$sort' => ['stock' => -1]]
        ];
        $stock = $this->aratadb->aggregate('stocks', $pipeline);
        $this->load->model('Item_model');
        $array['active'] = 'true';
        $item = $this->Item_model->get_items($array);
        $params2['status'] = 'open';
        $po = $this->aratadb->where($params2)->get('po');
        $itempo = [];
        foreach ($po as $item_po) {
            foreach (json_decode(json_encode($item_po['items']), true) as $p) {
                $itempo[] = $p;
            }
        }
        foreach ($item as $val) {
            $good = array_search($val['_id'] . '-good', array_column($stock, "_id"));
            $val['qty_physical']['good'] = $good !== false ? round($stock[$good]['stock'], 2) : 0;
            $damage = array_search($val['_id'] . '-damage', array_column($stock, "_id"));
            $val['qty_physical']['damage'] = $damage !== false ? round($stock[$damage]['stock'], 2) : 0;
            $reject = array_search($val['_id'] . '-reject', array_column($stock, "_id"));
            $val['qty_physical']['reject'] = $reject !== false ? round($stock[$reject]['stock'], 2) : 0;
            $key = array_search($val['_id'], array_column($itempo, "id_item"));
            $val['open_po'] = $key !== false ? $itempo[$key]['qty'] : 0;
            $result[] = $val;
        }
        if (!$result) {
            return [];
        } else {
            return $result;
        }
    }
    public function totalStock($array = null)
    {
        if ($array['id']) {
            $params['id_item'] = $array['id'];
        }
        if ($array['condition']) {
            $params['condition'] = $array['condition'];
        }
        $params['$nor'] = [['id_item' => null]];
        $pipeline = [
            ['$match' => ['$and' => [$params]]],
            ['$group' => ['_id' => ['id_item' => '$id_item', 'condition' => '$condition'], 'qty' => ['$sum' => ['$round' => ['$qty', 1]]]]],
            ['$sort' => ['qty' => -1]]
        ];
        $stocks = $this->aratadb->aggregate('stocks', $pipeline);
        foreach ($stocks as $key => $val) {
            $result[$val['_id']->id_item][$val['_id']->condition] = $val['qty'];
        }
        if (!$result) {
            return [];
        } else {
            return $result;
        }
    }
    public function saldoStock($date, $store = null)
    {
        $endDate = $this->mongo_db->date((strtotime("$date") + 86399) * 1000);
        $params['transaction_date']['$lte'] = $endDate;
        $params['condition'] = 'good';
        if ($store) {
            $params['id_warehouse'] = $store;
        }
        $params2['merchant'] = $this->merchant;
        $params2['$nor'] = [['station' => null], ['station' => '']];
        $pipeline = [
            ['$match' => ['$and' => [$params]]],
            ['$group' => ['_id' => '$id_item', 'stock' => ['$sum' => ['$round' => ['$qty', 1]]]]],
            ['$lookup' => [
                'from' => 'items',
                'localField' => '_id',
                'foreignField' => '_id',
                'as' => 'items'
            ]],
            ['$project' => ['_id' => '$_id', 'barcode' => ['$arrayElemAt' => ['$items.barcode', 0]], 'name' => ['$arrayElemAt' => ['$items.name', 0]], 'station' => ['$arrayElemAt' => ['$items.station', 0]], 'merchant' => ['$arrayElemAt' => ['$items.merchant', 0]], 'weight_unit' => ['$arrayElemAt' => ['$items.weight_unit', 0]], 'stock' => '$stock']],
            ['$match' => ['$and' => [$params2]]],
            ['$sort' => ['station' => 1, 'name' => 1]]
        ];
        $result = $this->aratadb->aggregate('stocks', $pipeline);
        if (!$result) {
            return [];
        } else {
            return $result;
        }
    }
    public function dataStockOpname($array)
    {
        if ($array['station'] && $array['station'] == 'null') {
            $params['$or'] = [['station' => ""], ['station' => null], ['station' => " "]];
        } elseif ($array['station'] && $array['station'] != 'null' && $array['station'] != 'all') {
            $params['station'] = $array['station'];
        }
        if ($array['active'] && $array['active'] != 'null') {
            $params['active'] = $array['active'] === 'true' ? true : false;
        }
        if ($array['stock'] && $array['stock'] != 'null') {
            if ($array['stock'] === 'true') {
                $params['$nor'] = [['stock_default' => ""], ['stock_default' => null], ['stock_default' => " "], ['stock_default' => 0], ['stock_default' => '0']];
            } else {
                if ($params['$or']) {
                    $params['$or'] += [['stock_default' => ""], ['stock_default' => null], ['stock_default' => " "], ['stock_default' => 0], ['stock_default' => '0']];
                } else {
                    $params['$or'] = [['stock_default' => ""], ['stock_default' => null], ['stock_default' => " "], ['stock_default' => 0], ['stock_default' => '0']];
                }
            }
        }
        $params['merchant'] = $this->merchant;
        $pipeline_receipt = [
            ['$match' => ['$and' => [$params]]],
            ['$project' => ['lowername' => ['$toLower' => '$name'], '_id' => '$_id', 'active' => '$active', 'barcode' => '$barcode', 'name' => '$name', 'station' => '$station', 'stock' => '$stock']],
            ['$sort'  => ['active' => -1, 'station' => 1, 'lowername' => 1]]
        ];
        $items = $this->aratadb->aggregate('items', $pipeline_receipt);
        $array['status'] = 'open';
        $open = $this->stockOrder($array);
        $array['status'] = 'onprocess';
        $onprocess = $this->stockOrder($array);
        foreach ($items as $val) {
            $key = array_search($val['_id'], array_column($open, "id_item"));
            $val['open'] = $key !== false ? $open[$key]['qty'] : 0;
            $key = array_search($val['_id'], array_column($onprocess, "id_item"));
            $val['onprocess'] = $key !== false ? $onprocess[$key]['qty'] : 0;
            $val['total'] = $val['stock'] + $val['open'] + $val['onprocess'];
            $val['active'] = $val['active'] ? 'yes' : 'no';
            $result[] = $val;
        }
        if (!$result) {
            return [];
        } else {
            return $result;
        }
    }
    public function stockOrder($array)
    {
        if ($array['status'] && is_array($array['status'])) {
            foreach ($array['status'] as $stat) {
                $params_status[] = ['status' => $stat];
            }
            $params['$or'] = $params_status;
        } elseif ($array['status']) {
            $params['status'] = $array['status'];
        }
        $params['merchant'] = $this->merchant;
        $dt = $this->aratadb->where($params)->get('orders');
        $params2['merchant'] = $this->merchant;
        if (!$dt) return [];
        $dtitems = $this->aratadb->where($params2)->get('items');
        for ($i = 0, $n = count($dtitems); $i < $n; $i++) {
            $items[$dtitems[$i]['_id']] = $dtitems[$i];
        }
        for ($i = 0, $n = count($dt); $i < $n; $i++) {
            for ($a = 0, $b = count($dt[$i]['items']); $a < $b; $a++) {
                foreach ($dt[$i]['items'] as $a => $dti) {
                    $ri[$dti->id_item]['nama_produk'] = $dti->name;
                    $ri[$dti->id_item]['qty'] += $dti->qty;
                }
            }
        }
        foreach ((array)$ri as $iditem => $val) {
            $composition[$iditem]['id_item'] = $iditem;
            $composition[$iditem]['nama_produk'] = $items[$iditem]['name'];
            $composition[$iditem]['station'] = $items[$iditem]['station'];
            $composition[$iditem]['qty'] = $val['qty'];
            if ($items[$iditem]['id_category'] == '606ec9a050ce4a112d139b50') {
                foreach ($items[$iditem]['composition'] as $k => $v) {
                    $composition[$v->id_item]['qty'] = $composition[$v->id_item]['qty'] ? $composition[$v->id_item]['qty'] + ((float)$v->qty * (float)$val['qty']) : (float)$v->qty * (float)$val['qty'];
                }
            }
        }
        foreach ($composition as $ck => $cv) {
            if ($array['id']) {
                if ($array['id'] == $ck) {
                    $resi['id_item'] = $ck;
                    $resi['nama_produk'] = $cv['nama_produk'];
                    $resi['station'] = $cv['station'];
                    $resi['qty'] = $cv['qty'];
                    $res[] = $resi;
                }
            } else {
                $resi['id_item'] = $ck;
                $resi['nama_produk'] = $cv['nama_produk'];
                $resi['station'] = $cv['station'];
                $resi['qty'] = $cv['qty'];
                $res[] = $resi;
            }
        }
        return $res;
    }
    public function getStock($array = null)
    {
        if ($array['_id']) {
            $params['_id'] = $array['_id'];
        }
        if ($array['transaction_date']) {
            $endDate = $this->mongo_db->date((strtotime($array['transaction_date']) + 86399) * 1000);
            $params['transaction_date']['$lte'] = $endDate;
        }
        if ($array['condition'] == 'good' || $array['condition'] == 'damage' || $array['condition'] == 'reject') {
            if ($array['id_item']) {
                $params['id_item'] = $array['id_item'];
            }
            if ($array['condition']) {
                $params['condition'] = $array['condition'];
            }
            $params['id_warehouse'] = $array['id_warehouse'];
            $pipeline_receipt = [
                ['$lookup' => [
                    'from' => 'adjustment',
                    'localField' => 'id_trans',
                    'foreignField' => '_id',
                    'as' => 'adjustment'
                ]],
                ['$lookup' => [
                    'from' => 'purchase',
                    'localField' => 'id_trans',
                    'foreignField' => '_id',
                    'as' => 'purchase'
                ]],
                ['$match' => ['$and' => [$params]]],
                ['$project' => ['id_item' => '$id_item', 'qty' => '$qty', 'transaction_date' => '$transaction_date', 'date' => ['$dateToString' => ['format' => '%d-%m-%Y', 'date' => '$transaction_date', 'timezone' => '+07:00']], 'type' => '$type', 'id_maker' => [
                    '$cond' => [
                        'if' => ['$eq' => ['$type', 'purchase']],
                        'then' => ['$arrayElemAt' => ['$purchase.maker', 0]], 'else' => [
                            '$cond' => [
                                'if' => ['$eq' => ['$type', 'adjustment']],
                                'then' => ['$arrayElemAt' => ['$adjustment.maker', 0]], 'else' => [
                                    '$cond' => [
                                        'if' => ['$eq' => ['$type', 'transfer_condition']],
                                        'then' => ['$arrayElemAt' => ['$adjustment.maker', 0]], 'else' => null
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]]],
                ['$lookup' => [
                    'from' => 'superuser',
                    'localField' => 'id_maker',
                    'foreignField' => '_id',
                    'as' => 'superuser'
                ]],
                ['$project' => ['id_item' => '$id_item', 'qty' => '$qty', 'transaction_date' => '$transaction_date', 'date' => '$date', 'type' => '$type', 'maker' => ['$arrayElemAt' => ['$superuser.name', 0]]]],
                ['$group' => ['_id' => ['type' => '$type', 'date' => '$date'], 'id_item' => ['$last' => '$id_item'], 'transaction_date' => ['$last' => '$transaction_date'], 'date' => ['$last' => '$date'], 'type' => ['$last' => '$type'], 'maker' => ['$last' => '$maker'], 'qty' => ['$sum' => ['$round' => ['$qty', 1]]]]],
                ['$sort'  => ['transaction_date' => -1]]
            ];
            $result['data'] = $this->aratadb->aggregate('stocks', $pipeline_receipt);
            $result['th1'] = 'Tgl Transaksi';
            $result['th2'] = 'Tipe';
        } elseif ($array['condition'] == 'open') {
            if ($array['id_item']) {
                $params['items.id_item'] = $array['id_item'];
            }
            if ($array['condition']) {
                $params['status'] = $array['condition'];
            }
            $supplier = $this->aratadb->order_by(['name' => 'ASC'])->get('supplier');
            $po = $this->aratadb->where($params)->get('po');
            $newpo = [];
            foreach ($po as $p) {
                foreach (json_decode(json_encode($p['items']), true) as $q) {
                    if ($q['id_item'] == $array['id_item']) {
                        $p['qty'] = $q['qty'];
                    }
                }
                $key = array_search($p['id_supplier'], array_column($supplier, "_id"));
                if ($key !== false) {
                    $p['supplier'] = $supplier[$key]['name'];
                }
                $newpo[] = $p;
            }
            $result['data'] = $newpo;
            $result['th1'] = 'No PO';
            $result['th2'] = 'Supplier';
        } elseif ($array['condition'] == 'open-onprocess') {
            $result['data'] = [];
            $filter['id'] = $array['id_item'];
            $filter['status'] = 'open';
            $open = $this->stockOrder($filter);
            if ($open) {
                $open[0]['status'] = 'open';
                $result['data'][] = $open[0];
            }
            $filter['status'] = 'onprocess';
            $onprocess = $this->stockOrder($filter);
            if ($onprocess) {
                $onprocess[0]['status'] = 'onprocess';
                $result['data'][] = $onprocess[0];
            }
            $result['th1'] = 'Station';
            $result['th2'] = 'Status';
        }
        if (!$result) {
            return [];
        } else {
            return $result;
        }
    }
    public function dataBufferStock()
    {
        $params['condition'] = 'good';
        $params2['active'] = true;
        $params2['merchant'] = $this->merchant;
        $params2['$nor'] = [['stock_min' => "0"], ['stock_min' => 0], ['stock_max' => ""], ['stock_max' => null], ['stock_max' => "0"], ['stock_max' => 0]];
        $params2['$or'] = [['stock_default' => "0"], ['stock_default' => 0], ['stock_default' => ""], ['stock_default' => null]];
        $pipeline = [
            ['$match' => ['$and' => [$params]]],
            ['$group' => ['_id' => '$id_item', 'stock' => ['$sum' => ['$round' => ['$qty', 1]]]]],
            ['$lookup' => [
                'from' => 'items',
                'localField' => '_id',
                'foreignField' => '_id',
                'as' => 'item'
            ]],
            ['$project' => ['lowername' => ['$toLower' => ['$arrayElemAt' => ['$item.name', 0]]], 'merchant' => ['$arrayElemAt' => ['$item.merchant', 0]], 'active' => ['$arrayElemAt' => ['$item.active', 0]], 'barcode' => ['$arrayElemAt' => ['$item.barcode', 0]], 'stock_default' => ['$arrayElemAt' => ['$item.stock_default', 0]], 'name' => ['$arrayElemAt' => ['$item.name', 0]], 'price' => ['$arrayElemAt' => ['$item.price', 0]], 'id_supplier' => ['$arrayElemAt' => ['$item.id_supplier', 0]], 'station' => ['$arrayElemAt' => ['$item.station', 0]], 'stock' => '$stock', 'stock_min' => ['$arrayElemAt' => ['$item.stock_min', 0]], 'stock_max' => ['$arrayElemAt' => ['$item.stock_max', 0]], 'last_hpp' => ['$arrayElemAt' => ['$item.purchase_price.last.price', 0]], 'avg_hpp' => ['$arrayElemAt' => ['$item.purchase_price.avg_price', 0]]]],
            ['$match' => ['$and' => [$params2]]],
            ['$lookup' => [
                'from' => 'supplier',
                'localField' => 'id_supplier',
                'foreignField' => '_id',
                'as' => 'supplier'
            ]],
            ['$project' => ['lowername' => '$lowername', 'barcode' => '$barcode', 'name' => '$name', 'price' => '$price', 'supplier' => ['$arrayElemAt' => ['$supplier.name', 0]], 'station' => '$station', 'stock' => '$stock', 'stock_min' => '$stock_min', 'stock_max' => '$stock_max', 'last_hpp' => '$last_hpp', 'avg_hpp' => '$avg_hpp']],
            ['$sort'  => ['station' => 1, 'lowername' => 1]]
        ];
        $stock = $this->aratadb->aggregate('stocks', $pipeline);
        $result = [];
        foreach ($stock as $data) {
            if ($data['stock'] <= $data['stock_min']) {
                $data['purchase'] = $data['stock_max'] - $data['stock'];
                $result[$data['supplier']][] = $data;
            }
        }
        ksort($result);
        if (!$result) {
            return [];
        } else {
            return $result;
        }
    }
    private function params()
    {
        $params['search'] = $_POST['search']['value'];
        $params['limit'] = $_POST['length'];
        $params['start'] = $_POST['start'];
        $order_field = $_POST['order'][0]['column'];
        $ascdesc = $_POST['order'][0]['dir'];
        $order_data = $_POST['columns'][$order_field]['data'];
        $params['$order'] = [$order_data => $ascdesc];
        return $params;
    }
    private function filter($where, $order, $limit, $start, $search, $where_search, $collection)
    {
        $result['all_data'] = $this->aratadb->where($where)->count($collection);
        $result['show_data'] = $this->aratadb->order_by($order)->get_where($collection, $where);
        if ($search) {
            $where = array_merge($where, $where_search);
            $result['show_data'] = $this->aratadb->order_by($order)->get_where($collection, $where);
        }
        $result['filter_data'] = count($result['show_data']);
        if ($limit != -1) {
            $result['show_data'] = $this->aratadb->limit($limit)->offset($start)->order_by($order)->get_where($collection, $where);
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
        $where = ['$nor' => [['_id' => null]]];
        if ($data['id_item']) {
            $where_id_item = ['id_item' => $data['id_item']];
            $where = array_merge($where, $where_id_item);
        }
        if ($data['condition']) {
            $where_condition = ['condition' => $data['condition']];
            $where = array_merge($where, $where_condition);
        }
        $result = $this->filter($where, $params['$order'], $params['limit'], $params['start'], $params['search'], $data['where_search'], 'stocks');
        $callback = $this->callback($result);
        return json_encode($callback);
    }
}
