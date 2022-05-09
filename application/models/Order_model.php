<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('mongo_db', array('activate' => 'arata'), 'aratadb');
        $this->merchant = '606eba1c099777608a38aeda';
    }
    public function recap($status, $start = null, $end = null)
    {
        if ($start) {
            if (!$end) {
                $end = $start;
            }
            $startDate = $this->mongo_db->date(strtotime("$start") * 1000);
            $endDate = $this->mongo_db->date((strtotime("$end") + 86399) * 1000);
            $params['delivery_time']['$gte'] = $startDate;
            $params['delivery_time']['$lte'] = $endDate;
        }
        $params['merchant'] = $this->merchant;
        if (is_array($status)) {
            foreach ($status as $stat) {
                $params_status[] = ['status' => $stat];
            }
            $params['$or'] = $params_status;
        } elseif ($status == 'open_onprocess') {
            $params['$or'] = [['status' => "open"], ['status' => "onprocess"]];
        } else {
            $params['status'] = $status;
        }
        $dt = $this->aratadb->where($params)->get('orders');
        if (!$dt) return [];
        $dtKat = $this->aratadb->where(['merchant' => $this->merchant])->get('categories');
        for ($i = 0, $n = count($dtKat); $i < $n; $i++) {
            $kat[$dtKat[$i]['_id']] = $dtKat[$i];
        }
        $dtSup = $this->aratadb->get('supplier');
        for ($i = 0, $n = count($dtSup); $i < $n; $i++) {
            $sup[$dtSup[$i]['_id']] = $dtSup[$i];
        }
        $dtitems = $this->aratadb->where(['merchant' => $this->merchant])->get('items');
        for ($i = 0, $n = count($dtitems); $i < $n; $i++) {
            $items[$dtitems[$i]['_id']] = $dtitems[$i];
            $items[$dtitems[$i]['_id']]['category'] = $kat[$dtitems[$i]['id_category']]['name'];
            $items[$dtitems[$i]['_id']]['supplier'] = $sup[$dtitems[$i]['id_supplier']]['name'];
        }
        for ($i = 0, $n = count($dt); $i < $n; $i++) {
            for ($a = 0, $b = count($dt[$i]['items']); $a < $b; $a++) {
                foreach ($dt[$i]['items'] as $a => $dti) {
                    $ri[$dti->id_item]['nama_produk'] = $dti->name;
                    $ri[$dti->id_item]['price'] += $dti->price * $dti->qty;
                    $ri[$dti->id_item]['qty'] += $dti->qty;
                    if ($dti->note) $ri[$dti->id_item]['note'] .= $dt[$i]['id_courier'] . ': ' . $dti->qty . 'x ' . $dti->note . ' (' . $dt[$i]['recipient']->name . ')' . "\n";
                    $ri[$dti->id_item]['penerima'] .= $dti->qty . 'x ' . $dt[$i]['recipient']->name . "\n";
                    $ri[$dti->id_item]['penerima_qty'][] = $dti->qty;
                    $ri[$dti->id_item]['total_courier'][$dt[$i]['id_courier']] = $ri[$dti->id_item]['total_courier'][$dt[$i]['id_courier']] + $dti->qty;
                }
            }
        }
        foreach ((array)$ri as $iditem => $val) {
            $resi['id_item'] = $iditem;
            $resi['id_supplier'] = $items[$iditem]['id_supplier'];
            $resi['supplier'] = $items[$iditem]['supplier'];
            $resi['station'] = $items[$iditem]['station'];
            $resi['sku'] = $items[$iditem]['barcode'];
            $resi['kategori'] = $items[$iditem]['category'];
            $resi['nama_produk'] = $items[$iditem]['name'];
            $resi['alias'] = $items[$iditem]['alias'];
            $resi['qty'] = $val['qty'];
            $resi['price'] = $val['price'];
            $resi['satuan'] = $items[$iditem]['weight_unit'];
            $resi['berat'] = $resi['satuan'] == 'gr' || $resi['satuan'] == 'g' ? $items[$iditem]['weight'] : 1;
            $resi['total_berat'] = $resi['berat'] * $resi['qty'];
            $resi['note'] = $val['note'];
            $resi['curr_stock'] = $items[$iditem]['stock'];
            $resi['stock_weight'] = $resi['curr_stock'] * $resi['berat'];
            $resi['penerima'] = $val['penerima'];
            if (is_array($val['penerima_qty'])) {
                rsort($val['penerima_qty']);
                $resi['penerima_qty'] = implode(', ', $val['penerima_qty']);
            } else {
                $resi['penerima_qty'] = '';
            }
            if (is_array($val['total_courier'])) {
                $total_courier = [];
                foreach ($val['total_courier'] as $k => $c) {
                    $total_courier[] = $k . ': ' . $c;
                }
                sort($total_courier);
                $resi['total_courier'] = implode(', ', $total_courier);
            } else {
                $resi['total_courier'] = '';
            }
            $res[] = $resi;
        }
        foreach ($res as $rec) {
            if ($rec['kategori'] == 'Menu Paketan') {
                $key1 = array_search($rec['id_item'], array_column($dtitems, "_id"));
                if ($key1 !== false) {
                    foreach ($dtitems[$key1]['composition'] as $k => $v) {
                        $key2 = array_search($v->id_item, array_column($dtitems, "_id"));
                        if ($key2 !== false) {
                            $price = $dtitems[$key2]['sales_price'] ? $dtitems[$key2]['sales_price'] : $dtitems[$key2]['price'];
                            $composition[$v->id_item]['id_item'] = $v->id_item;
                            $composition[$v->id_item]['id_supplier'] = $dtitems[$key2]['id_supplier'];
                            $composition[$v->id_item]['supplier'] = $sup[$dtitems[$key2]['id_supplier']]['name'];
                            $composition[$v->id_item]['station'] = $dtitems[$key2]['station'];
                            $composition[$v->id_item]['sku'] = $dtitems[$key2]['barcode'];
                            $composition[$v->id_item]['kategori'] = $kat[$dtitems[$key2]['id_category']]['name'];
                            $composition[$v->id_item]['nama_produk'] = $dtitems[$key2]['name'];
                            $composition[$v->id_item]['alias'] = $dtitems[$key2]['alias'];
                            $composition[$v->id_item]['qty'] = $composition[$v->id_item]['qty'] ? $composition[$v->id_item]['qty'] + ((float)$v->qty * (float)$rec['qty']) : (float)$v->qty * (float)$rec['qty'];
                            $composition[$v->id_item]['price'] = $composition[$v->id_item]['price'] ? $composition[$v->id_item]['price'] + ((float)$v->qty * (float)$price) : (float)$v->qty * (float)$price;
                            $composition[$v->id_item]['berat'] =  $dtitems[$key2]['weight'];
                            $composition[$v->id_item]['satuan'] = $dtitems[$key2]['weight_unit'];
                            $composition[$v->id_item]['total_berat'] = $composition[$v->id_item]['total_berat'] ? $composition[$v->id_item]['total_berat'] + ((float)$composition[$v->id_item]['berat'] * $composition[$v->id_item]['qty']) : (float)$composition[$v->id_item]['berat'] * $composition[$v->id_item]['qty'];
                            $composition[$v->id_item]['note'] = $composition[$v->id_item]['note'] ? $composition[$v->id_item]['note'] . (float)$v->qty * (float)$rec['qty'] . ': ' . $rec['qty'] . 'x ' . $rec['nama_produk'] . "\n" : (float)$v->qty * (float)$rec['qty'] . ': ' . $rec['qty'] . 'x ' . $rec['nama_produk'] . "\n";
                            $composition[$v->id_item]['curr_stock'] = $dtitems[$key2]['stock'];
                            $composition[$v->id_item]['stock_weight'] = $composition[$v->id_item]['stock_weight'] ? $composition[$v->id_item]['stock_weight'] + ((float)$composition[$v->id_item]['curr_stock'] * (float)$composition[$v->id_item]['berat']) : (float)$composition[$v->id_item]['curr_stock'] * (float)$composition[$v->id_item]['berat'];
                            $composition[$v->id_item]['penerima'] = $composition[$v->id_item]['penerima'] ? $composition[$v->id_item]['penerima'] . $rec['qty'] . 'x ' . $rec['nama_produk'] . "\n" : $rec['qty'] . 'x ' . $rec['nama_produk'] . "\n";
                            // $composition[$v->id_item]['penerima_qty'] = $composition[$v->id_item]['penerima_qty'];
                        }
                    }
                }
            }
        }
        foreach ($res as $rec) {
            foreach ($composition as $p => $paket) {
                if ($rec['id_item'] == $paket['id_item']) {
                    $rec['qty2'] = $rec['qty'] . ' + ' . $paket['qty'];
                    $rec['qty'] = (float)$rec['qty'] + (float)$paket['qty'];
                    $rec['price'] = (float)$rec['price'] + (float)$paket['price'];
                    $rec['total_berat'] = (float)$rec['total_berat'] + ((float)$paket['qty'] * (float)$rec['berat']);
                    $rec['note'] = $rec['note'] . $paket['note'];
                    $rec['penerima'] = $rec['penerima'] . $paket['penerima'];
                    $rec['penerima_qty'] = $rec['penerima_qty'];
                    $rec['total_courier'] = $rec['total_courier'];
                    unset($composition[$paket['id_item']]);
                }
            }
            $result[] = $rec;
        }
        if ($composition) {
            foreach ($composition as $p => $paket) {
                $result[] = $paket;
            }
        }
        if (is_array($result)) {
            array_multisort(array_column($result, 'nama_produk'), SORT_ASC, $result);
        }
        return $result;
    }
    public function RecapCourierItem($tgl, $station = null)
    {
        if ($tgl) {
            $startDate = $this->mongo_db->date(strtotime("$tgl") * 1000);
            $endDate = $this->mongo_db->date((strtotime("$tgl") + 86399) * 1000);
            $params['delivery_time']['$gte'] = $startDate;
            $params['delivery_time']['$lte'] = $endDate;
        }
        $params['$nor'] = [['id_courier' => null], ['id_courier' => '']];
        $params['status'] = 'onprocess';
        $params['merchant'] = $this->merchant;
        if (is_array($station)) {
            foreach ($station as $stat) {
                $params_station[] = ['_id.station' => $stat];
            }
            $params2['$or'] = $params_station;
        } elseif ($station) {
            $params2['_id.station'] = $station;
        } else {
            $params2['$nor'] = [['_id.station' => null]];
        }
        $pipeline = [
            ['$match' => ['$and' => [$params]]],
            ['$project' => ['id_courier' => '$id_courier', 'items' => '$items']],
            ['$unwind' => '$items'],
            ['$lookup' => [
                'from' => 'items',
                'localField' => 'items.id_item',
                'foreignField' => '_id',
                'as' => 'data'
            ]],
            ['$group' => ['_id' => ['id_courier' => '$id_courier', 'id_item' => '$items.id_item', 'name' => '$items.name', 'station' => ['$arrayElemAt' => ['$data.station', 0]]], 'qty' => ['$sum' => '$items.qty']]],
            ['$match' => ['$and' => [$params2]]],
            ['$group' => ['_id' => '$_id.id_courier', 'item' => ['$addToSet' => ['id_item' => '$_id.id_item', 'qty' => '$qty', 'name' => '$_id.name', 'station' => '$_id.station']]]],
            ['$sort'  => ['_id' => 1]]
        ];
        $orders = $this->aratadb->aggregate('orders', $pipeline);
        if ($orders) {
            foreach ($orders as $ord) {
                $items = [];
                foreach ($ord['item'] as $k => $data) {
                    $items[$data->station][] = $data;
                    array_multisort(array_column($items[$data->station], 'name'), SORT_ASC, $items[$data->station]);
                }
                ksort($items);
                $result[$ord['_id']]['_id'] = $ord['_id'];
                $result[$ord['_id']]['item'] = $items;
            }
        }
        if (!$result) {
            return [];
        } else {
            return $result;
        }
    }
    public function all_order_packinglist($tgl = null)
    {
        if ($tgl) {
            $startDate = $this->mongo_db->date(strtotime("$tgl") * 1000);
            $endDate = $this->mongo_db->date((strtotime("$tgl") + 86399) * 1000);
            $params['delivery_time']['$gte'] = $startDate;
            $params['delivery_time']['$lte'] = $endDate;
        }
        $params['status'] = 'onprocess';
        $params['merchant'] = $this->merchant;
        $pipeline_receipt = [
            ['$match' => ['$and' => [$params]]],
            ['$sort'  => ['name' => 1]]
        ];
        $order = $this->aratadb->aggregate('orders', $pipeline_receipt);
        $item = $this->aratadb->where(['merchant' => $this->merchant])->get('items');
        $finalArray = [];
        foreach ($order as $data) {
            $items = json_decode(json_encode($data['items']), true);
            array_multisort(array_column($items, 'name'), SORT_ASC, $items);
            $finalItem = [];
            foreach ($items as $data1) {
                $key = array_search($data1['id_item'], array_column($item, "_id"));
                if ($item[$key]['station']) {
                    $station = $item[$key]['station'];
                } else {
                    $station = 'No Station';
                }
                $data1 += ['station' => $station];
                $finalItem[] = $data1;
            }
            ksort($finalItem);
            unset($data['items']);
            $data += ['items' => $finalItem];
            $finalArray[] = $data;
        }
        return $finalArray;
    }
    public function all_order_packinglist2($tgl = null)
    {
        if ($tgl) {
            $startDate = $this->mongo_db->date(strtotime("$tgl") * 1000);
            $endDate = $this->mongo_db->date((strtotime("$tgl") + 86399) * 1000);
            $params['delivery_time']['$gte'] = $startDate;
            $params['delivery_time']['$lte'] = $endDate;
        }
        $params['status'] = 'onprocess';
        $params['merchant'] = $this->merchant;
        $pipeline_receipt = [
            ['$match' => ['$and' => [$params]]],
            ['$project' => ['customer' => '$customer', 'delivery_time' => '$delivery_time', 'invno' => '$invno', 'is_dropship' => '$is_dropship', 'is_paid' => '$is_paid', 'items' => '$items', 'merchant' => '$merchant', 'merchant_notes' => '$merchant_notes', 'shipping' => '$shipping', 'payment' => '$payment', 'price' => '$price', 'recipient' => '$recipient', 'name' => ['$toLower' => '$recipient.name'], 'status' => '$status', 'transaction_date' => '$transaction_date', 'id_courier' => '$id_courier', 'internal_notes' => '$internal_notes', 'voucher' => '$voucher']],
            ['$sort'  => ['name' => 1]]
        ];
        $order = $this->aratadb->aggregate('orders', $pipeline_receipt);
        $item = $this->aratadb->where(['merchant' => $this->merchant])->get('items');
        $finalArray = [];
        foreach ($order as $data) {
            $items = json_decode(json_encode($data['items']), true);
            array_multisort(array_column($items, 'name'), SORT_ASC, $items);
            $finalItem = [];
            foreach ($items as $data1) {
                $key = array_search($data1['id_item'], array_column($item, "_id"));
                if ($item[$key]['station']) {
                    $station = $item[$key]['station'];
                } else {
                    $station = 'No Station';
                }
                $finalItem[$station][] = $data1;
            }
            ksort($finalItem);
            unset($data['items']);
            $data += ['items' => $finalItem];
            $finalArray[] = $data;
        }
        return $finalArray;
    }
    public function all_order_cluster($tgl = null)
    {
        if ($tgl) {
            $startDate = $this->mongo_db->date(strtotime("$tgl") * 1000);
            $endDate = $this->mongo_db->date((strtotime("$tgl") + 86399) * 1000);
            $params['delivery_time']['$gte'] = $startDate;
            $params['delivery_time']['$lte'] = $endDate;
        }
        $params['status'] = 'onprocess';
        $params['merchant'] = '606eba1c099777608a38aeda';
        $pipeline_receipt = [
            ['$lookup' => [
                'from' => 'customers',
                'localField' => 'customer.phone',
                'foreignField' => 'phone',
                'as' => 'customers'
            ]],
            ['$match' => ['$and' => [$params]]],
            ['$group' => ['_id' => '$recipient.id_cluster', 'count' => ['$sum' => 1], 'note' => ['$addToSet' => ['id_order' => '$_id', 'lower' => ['$toLower' => '$recipient.name'], 'name' => '$recipient.name', 'address' => '$recipient.address', 'shipping' => '$shipping', 'merchant_notes' => '$merchant_notes', 'preferences' => ['$arrayElemAt' => ['$customers.preferences', 0]], 'payment' => '$payment', 'total' => '$price.total', 'shipping_weight' => '$shipping_weight', 'courier' => '$id_courier']]]]
        ];
        $orders = $this->aratadb->aggregate('orders', $pipeline_receipt);
        $result = [];
        foreach ($orders as $o) {
            if (!$o['_id']) {
                $c['_id'] = 'null';
                $c['name'] = 'NULL';
                $c['count'] = $o['count'] ? $o['count'] : 0;
                $c['order'] = $o['note'];
                $result[] = $c;
            }
        }
        $cluster = $this->aratadb->order_by(['code' => 'ASC'])->get('cluster');
        foreach ($cluster as $c) {
            $key = array_search($c['_id'], array_column($orders, "_id"));
            if ($key !== false) {
                $c['count'] = $orders[$key]['count'];
                $c['order'] = $orders[$key]['note'];
            } else {
                $c['count'] = 0;
            }
            $result[] = $c;
        }
        return $result;
    }
    public function order_packinglist($id)
    {
        $params['_id'] = $id;
        $params['merchant'] = $this->merchant;
        $pipeline_receipt = [
            ['$lookup' => [
                'from' => 'customers',
                'localField' => 'customer.phone',
                'foreignField' => 'phone',
                'as' => 'cust'
            ]],
            ['$match' => ['$and' => [$params]]],
            ['$project' => ['customer' => '$customer', 'preferences' => ['$arrayElemAt' => ['$cust.preferences', 0]], 'delivery_time' => '$delivery_time', 'invno' => '$invno', 'is_dropship' => '$is_dropship', 'is_paid' => '$is_paid', 'items' => '$items', 'merchant' => '$merchant', 'merchant_notes' => '$merchant_notes', 'shipping' => '$shipping', 'payment' => '$payment', 'price' => '$price', 'recipient' => '$recipient', 'name' => ['$toLower' => '$recipient.name'], 'status' => '$status', 'transaction_date' => '$transaction_date', 'id_courier' => '$id_courier', 'internal_notes' => '$internal_notes', 'voucher' => '$voucher']],
            ['$sort'  => ['name' => 1]]
        ];
        $order = $this->aratadb->aggregate('orders', $pipeline_receipt);
        if ($order) {
            $pipeline = [
                ['$match' => ['$and' => [['merchant' => '606eba1c099777608a38aeda', '$or' => [['customer.phone' => $order[0]['customer']->phone]], '$nor' => [['status' => 'canceled']]]]]],
                ['$group' => ['_id' => '$customer.phone', 'count' => ['$sum' => 1]]]
            ];
            $count = $this->aratadb->aggregate('orders', $pipeline);
            $item = $this->aratadb->where(['merchant' => $this->merchant])->get('items');
            $finalArray = [];
            foreach ($order as $data) {
                $key1 = array_search($data['customer']->phone, array_column($count, "_id"));
                $data['new_customer'] = $key1 !== false ? $count[$key1]['count'] : null;
                $items = json_decode(json_encode($data['items']), true);
                array_multisort(array_column($items, 'name'), SORT_ASC, $items);
                $finalItem = [];
                foreach ($items as $data1) {
                    $key = array_search($data1['id_item'], array_column($item, "_id"));
                    if ($item[$key]['station']) {
                        $station = $item[$key]['station'];
                    } else {
                        $station = 'No Station';
                    }
                    $finalItem[$station][] = $data1;
                }
                ksort($finalItem);
                unset($data['items']);
                $data += ['items' => $finalItem];
                $finalArray[] = $data;
            }
        }
        return $finalArray;
    }
    public function label_sticker($id)
    {
        $params['_id'] = $id;
        $params['merchant'] = $this->merchant;
        $pipeline_receipt = [
            ['$lookup' => [
                'from' => 'customers',
                'localField' => 'customer.phone',
                'foreignField' => 'phone',
                'as' => 'cust'
            ]],
            ['$match' => ['$and' => [$params]]],
            ['$project' => ['recipient' => '$recipient', 'shipping' => '$shipping', 'merchant_notes' => '$merchant_notes', 'preferences' => ['$arrayElemAt' => ['$cust.preferences', 0]], 'id_courier' => '$id_courier', 'items' => '$items']],
            ['$unwind' => '$items'],
            ['$lookup' => [
                'from' => 'items',
                'localField' => 'items.id_item',
                'foreignField' => '_id',
                'as' => 'data'
            ]],
            ['$project' => ['name' => '$recipient.name', 'address' => '$recipient.address', 'shipping' => '$shipping', 'merchant_notes' => '$merchant_notes', 'preferences' => ['$arrayElemAt' => ['$cust.preferences', 0]], 'id_courier' => '$id_courier', 'item' => '$items.name', 'station' => ['$arrayElemAt' => ['$data.station', 0]]]],
            ['$group' => ['_id' => '_id', 'name' => ['$last' => '$name'], 'address' => ['$last' => '$address'], 'shipping' => ['$last' => '$shipping'], 'merchant_notes' => ['$last' => '$merchant_notes'], 'preferences' => ['$last' => '$preferences'], 'id_courier' => ['$last' => '$id_courier'], 'items' => ['$addToSet' => ['name' => '$item', 'station' => '$station']]]]
        ];
        $order = $this->aratadb->aggregate('orders', $pipeline_receipt);
        foreach ($order[0]['items'] as $k => $v) {
            $name = strtolower($v->name);
            if (strpos($name, 'telur') !== false && strpos($name, 'ayam') !== false) {
                $kresek['telur'] = 1;
            } elseif (strpos($name, 'semangka') !== false || strpos($name, 'melon') !== false || strpos($name, 'pepaya') !== false) {
                $kresek['semangka'] = 1;
            } elseif (strpos($name, 'pisang cavendish') !== false || strpos($name, 'pisang mas') !== false || strpos($name, 'pisang kepok') !== false) {
                $kresek['pisang'] = 1;
            } elseif ($v->station == '4' || strpos($name, 'tahu susu') !== false) {
                $kresek['tahu'] = 1;
            } elseif ($v->station == '5C') {
                $kresek['5C'] = 1;
            } else {
                $kresek['station'] = 1;
            }
        }
        $order[0]['sticker'] = count($kresek);
        return $order;
    }
    public function all_order_delivery($start = null, $end = null, $status = null)
    {
        if ($start) {
            $startDate = $this->mongo_db->date(strtotime("$start") * 1000);
            $endDate = $this->mongo_db->date((strtotime("$end") + 86399) * 1000);
            $params['delivery_time']['$gte'] = $startDate;
            $params['delivery_time']['$lte'] = $endDate;
        }
        if ($status) {
            if ($status == 'open_onprocess') {
                $params['$or'] = [['status' => "open"], ['status' => "onprocess"]];
            } else {
                $params['status'] = $status;
            }
        }
        $params['merchant'] = $this->merchant;
        $pipeline_receipt = [
            ['$match' => ['$and' => [$params]]],
            ['$project' => ['customer' => '$customer', 'delivery_time' => '$delivery_time', 'invno' => '$invno', 'is_dropship' => '$is_dropship', 'is_paid' => '$is_paid', 'items' => '$items', 'merchant' => '$merchant', 'merchant_notes' => '$merchant_notes', 'payment' => '$payment', 'price' => '$price', 'recipient' => '$recipient', 'name' => ['$toLower' => '$recipient.name'], 'status' => '$status', 'transaction_date' => '$transaction_date', 'id_courier' => '$id_courier', 'internal_notes' => '$internal_notes', 'voucher' => '$voucher', 'shipping' => '$shipping']],
            ['$sort'  => ['name' => 1]]
        ];
        $dt = $this->aratadb->aggregate('orders', $pipeline_receipt);
        if (!$dt) {
            return [];
        } else {
            return $dt;
        }
    }
    public function report_order_delivery($start = null, $end = null, $status = null)
    {
        if ($start) {
            $startDate = $this->mongo_db->date(strtotime("$start") * 1000);
            $endDate = $this->mongo_db->date((strtotime("$end") + 86399) * 1000);
            $params['delivery_time']['$gte'] = $startDate;
            $params['delivery_time']['$lte'] = $endDate;
        }
        if ($status) {
            $params['status'] = $status;
        }
        $params['merchant'] = $this->merchant;
        $pipeline_receipt = [
            ['$match' => ['$and' => [$params]]],
            ['$project' => ['customer' => '$customer', 'delivery_time' => '$delivery_time', 'invno' => '$invno', 'is_dropship' => '$is_dropship', 'is_paid' => '$is_paid', 'items' => '$items', 'merchant' => '$merchant', 'merchant_notes' => '$merchant_notes', 'payment' => '$payment', 'price' => '$price', 'recipient' => '$recipient', 'name' => ['$toLower' => '$recipient.name'], 'status' => '$status', 'transaction_date' => '$transaction_date', 'id_courier' => '$id_courier', 'internal_notes' => '$internal_notes', 'voucher' => '$voucher']],
            ['$sort'  => ['name' => 1]]
        ];
        $dt = $this->aratadb->aggregate('orders', $pipeline_receipt);
        $items = $this->aratadb->where(['merchant' => $this->merchant])->get('items');
        foreach ($dt as $ord) {
            $item = json_decode(json_encode($ord['items']), true);
            foreach ($item as $itm) {
                $key = array_search($itm['id_item'], array_column($items, "_id"));
                if ($key !== false) {
                    $sku = $items[$key]['barcode'];
                } else {
                    $sku = null;
                }
                $data = [
                    "invno"             => $ord['invno'],
                    "transaction_date"  => $ord['transaction_date'],
                    "customer_name"     => $ord['customer']->name,
                    "customer_phone"    => $ord['customer']->phone,
                    "recipient_address" => $ord['recipient']->address,
                    "recipient_city"    => $ord['recipient']->city,
                    "recipient_kodepos" => $ord['recipient']->kodepos,
                    "merchant_notes"    => $ord['merchant_notes'],
                    "sku"               => $sku,
                    "item_name"         => $itm['name'],
                    "item_qty"          => $itm['qty'],
                    "item_price"        => $itm['price'],
                    "shipping"          => $ord['shipping'],
                    "delivery_time"     => $ord['delivery_time'],
                    "payment"           => payment_string($ord['payment'], 'nominal'),
                    "voucher"           => $ord['voucher'],
                    "discount"          => $ord['price']->discount,
                    "total"             => $itm['qty'] * $itm['price'],
                    "refund"            => $itm['qty_return'] * $itm['price'],
                    "internal_notes"    => $ord['internal_notes']
                ];
                $newitems[] = $data;
            }
            $ongkir = [
                "invno"             => $ord['invno'],
                "transaction_date"  => $ord['transaction_date'],
                "customer_name"     => $ord['customer']->name,
                "customer_phone"    => $ord['customer']->phone,
                "recipient_address" => $ord['recipient']->address,
                "recipient_city"    => $ord['recipient']->city,
                "recipient_kodepos" => $ord['recipient']->kodepos,
                "merchant_notes"    => $ord['merchant_notes'],
                "sku"               => null,
                "item_name"         => 'ONGKIR',
                "item_qty"          => null,
                "item_price"        => $ord['price']->shipping,
                "shipping"          => $ord['shipping'],
                "delivery_time"     => $ord['delivery_time'],
                "payment"           => payment_string($ord['payment'], 'nominal'),
                "voucher"           => $ord['voucher'],
                "discount"          => $ord['price']->discount,
                "total"             => $ord['price']->shipping,
                "refund"            => null,
                "internal_notes"    => $ord['internal_notes']
            ];
            $newitems[] = $ongkir;
            if ($ord['voucher']) {
                $voucher = [
                    "invno"             => $ord['invno'],
                    "transaction_date"  => $ord['transaction_date'],
                    "customer_name"     => $ord['customer']->name,
                    "customer_phone"    => $ord['customer']->phone,
                    "recipient_address" => $ord['recipient']->address,
                    "recipient_city"    => $ord['recipient']->city,
                    "recipient_kodepos" => $ord['recipient']->kodepos,
                    "merchant_notes"    => $ord['merchant_notes'],
                    "sku"               => null,
                    "item_name"         => 'VOUCHER',
                    "item_qty"          => null,
                    "item_price"        => $ord['price']->shipping,
                    "shipping"          => $ord['shipping'],
                    "delivery_time"     => $ord['delivery_time'],
                    "payment"           => payment_string($ord['payment'], 'nominal'),
                    "voucher"           => $ord['voucher'],
                    "discount"          => $ord['price']->discount,
                    "total"             => $ord['price']->discount * -1,
                    "refund"            => null,
                    "internal_notes"    => $ord['internal_notes']
                ];
                $newitems[] = $voucher;
            }
        }
        if (!$newitems) {
            return [];
        } else {
            return $newitems;
        }
    }
    public function report_payment($start = null, $end = null, $status = null)
    {
        if ($start) {
            $startDate = $this->mongo_db->date(strtotime("$start") * 1000);
            $endDate = $this->mongo_db->date((strtotime("$end") + 86399) * 1000);
            $params['delivery_time']['$gte'] = $startDate;
            $params['delivery_time']['$lte'] = $endDate;
        }
        if ($status) {
            $params['status'] = $status;
        }
        $params['merchant'] = $this->merchant;
        $pipeline_receipt = [
            ['$match' => ['$and' => [$params]]],
            ['$project' => ['customer' => '$customer', 'delivery_time' => '$delivery_time', 'invno' => '$invno', 'is_dropship' => '$is_dropship', 'is_paid' => '$is_paid', 'items' => '$items', 'merchant' => '$merchant', 'merchant_notes' => '$merchant_notes', 'payment' => '$payment', 'price' => '$price', 'recipient' => '$recipient', 'name' => ['$toLower' => '$recipient.name'], 'status' => '$status', 'transaction_date' => '$transaction_date', 'id_courier' => '$id_courier', 'internal_notes' => '$internal_notes', 'voucher' => '$voucher']],
            ['$sort'  => ['name' => 1]]
        ];
        $dt = $this->aratadb->aggregate('orders', $pipeline_receipt);
        foreach ($dt as $ord) {
            foreach ($ord['payment'] as $key => $val) {
                $data = [
                    "invno"             => $ord['invno'],
                    "transaction_date"  => $ord['transaction_date'],
                    "delivery_time"     => $ord['delivery_time'],
                    "customer_name"     => $ord['customer']->name,
                    "customer_phone"    => $ord['customer']->phone,
                    "payment_method"    => $val->method,
                    "payment_amount"    => $val->payment_amount,
                    "paid_at"           => $val->paid_at,
                    "shipping"          => $ord['price']->shipping,
                    "discount"          => $ord['price']->discount,
                    "total"             => $ord['price']->total
                ];
                $newitems[] = $data;
            }
        }
        if (!$newitems) {
            return [];
        } else {
            return $newitems;
        }
    }
    public function all_order_transaction($start = null, $end = null, $status = null)
    {
        if ($start) {
            $startDate = $this->mongo_db->date(strtotime("$start") * 1000);
            $endDate = $this->mongo_db->date((strtotime("$end") + 86399) * 1000);
            $params['transaction_date']['$gte'] = $startDate;
            $params['transaction_date']['$lte'] = $endDate;
        }
        if ($status) {
            $params['status'] = $status;
        }
        $params['merchant'] = $this->merchant;
        $pipeline_receipt = [
            ['$match' => ['$and' => [$params]]],
            ['$project' => ['customer' => '$customer', 'delivery_time' => '$delivery_time', 'invno' => '$invno', 'is_dropship' => '$is_dropship', 'is_paid' => '$is_paid', 'items' => '$items', 'merchant' => '$merchant', 'merchant_notes' => '$merchant_notes', 'payment' => '$payment', 'price' => '$price', 'recipient' => '$recipient', 'name' => ['$toLower' => '$recipient.name'], 'status' => '$status', 'transaction_date' => '$transaction_date', 'id_courier' => '$id_courier', 'internal_notes' => '$internal_notes', 'voucher' => '$voucher']],
            ['$sort'  => ['name' => 1]]
        ];
        $dt = $this->aratadb->aggregate('orders', $pipeline_receipt);
        if (!$dt) {
            return [];
        } else {
            return $dt;
        }
    }
    public function sum_order($array)
    {
        $params['merchant'] = $this->merchant;
        if ($array['start']) {
            if (!$array['end']) {
                $end = $array['start'];
            } else {
                $end = $array['end'];
            }
            $startDate = $this->mongo_db->date(strtotime($array['start']) * 1000);
            $endDate = $this->mongo_db->date((strtotime("$end") + 86399) * 1000);
            $params['delivery_time']['$gte'] = $startDate;
            $params['delivery_time']['$lte'] = $endDate;
        }
        if ($array['status']) {
            foreach ($array['status'] as $stat) {
                $params_status[] = ['status' => $stat];
            }
            $params['$or'] = $params_status;
        }
        $pipeline_receipt = [
            ['$match' => ['$and' => [$params]]],
            ['$group' => ['_id' => '$status', 'total' => ['$sum' => ['$toInt' => '$price.total']], 'count' => ['$sum' => 1]]],
            ['$sort'  => ['_id' => 1]],
        ];
        $receipt = $this->aratadb->aggregate('orders', $pipeline_receipt);
        return $receipt;
    }
    public function chart_sum_order($array)
    {
        $params['merchant'] = $this->merchant;
        $params['status'] = "closed";
        if ($array['start']) {
            if (!$array['end']) {
                $end = $array['start'];
            } else {
                $end = $array['end'];
            }
            $startDate = $this->mongo_db->date(strtotime($array['start']) * 1000);
            $endDate = $this->mongo_db->date((strtotime("$end") + 86399) * 1000);
            $params['delivery_time']['$gte'] = $startDate;
            $params['delivery_time']['$lte'] = $endDate;
        }
        $pipeline = [
            ['$match' => ['$and' => [$params]]],
            ['$group' => ['_id' => ['$dateToString' => ['format' => '%Y-%m-%d', 'date' => '$delivery_time', 'timezone' => '+07:00']], 'omset' => ['$sum' => ['$toInt' => '$price.total']], 'order' => ['$sum' => 1]]],
            ['$sort'  => ['_id' => 1]]
        ];
        $closed = $this->aratadb->aggregate('orders', $pipeline);
        $result = [];
        foreach ($closed as $close) {
            $startDate = $this->mongo_db->date(strtotime($close['_id']) * 1000);
            $endDate = $this->mongo_db->date((strtotime($close['_id']) + 86399) * 1000);
            $params['delivery_time']['$gte'] = $startDate;
            $params['delivery_time']['$lte'] = $endDate;
            $pipeline = [
                ['$match' => ['$and' => [$params]]],
                ['$group' => ['_id' => '$customer.phone']]
            ];
            $phones = $this->aratadb->aggregate('orders', $pipeline);
            foreach ($phones as $phone) {
                $params['$or'][] = ['customer.phone' => $phone['_id']];
            }
            unset($params['delivery_time']['$gte']);
            $pipeline = [
                ['$match' => ['$and' => [$params]]],
                ['$group' => ['_id' => '$customer.phone', 'customer' => ['$sum' => 1]]],
                ['$match' => ['$and' => [['customer' => 1]]]],
                ['$count' => "new_customer"]
            ];
            $customer = $this->aratadb->aggregate('orders', $pipeline);
            $close['new_customer'] = $customer[0]['new_customer'] ? $customer[0]['new_customer'] : 0;
            $result[] = $close;
            unset($params['$or']);
        }
        return $result;
    }
    public function uniqueCustomer($array)
    {
        $params['merchant'] = $this->merchant;
        if ($array['start']) {
            if (!$array['end']) {
                $end = $array['start'];
            } else {
                $end = $array['end'];
            }
            $startDate = $this->mongo_db->date(strtotime($array['start']) * 1000);
            $endDate = $this->mongo_db->date((strtotime("$end") + 86399) * 1000);
            $params['delivery_time']['$gte'] = $startDate;
            $params['delivery_time']['$lte'] = $endDate;
        }
        $pipeline = [
            ['$match' => ['$and' => [$params]]],
            ['$group' => ['_id' => ['phone' => '$customer.phone', 'status' => '$status']]],
            ['$group' => ['_id' => '$_id.status', 'total' => ['$sum' => 1]]],
            ['$sort'  => ['_id' => 1]],
        ];
        $result = $this->aratadb->aggregate('orders', $pipeline);
        return $result;
    }
    public function view_order($id)
    {
        $params['_id'] = $id;
        $params['merchant'] = $this->merchant;
        $dt = $this->aratadb->where($params)->get('orders');
        if (!$dt) {
            return [];
        } else {
            return $dt;
        }
    }
    public function update_status($status, $id = null)
    {
        if ($id) {
            $params['_id'] = $id;
        } else {
            $id = $_POST['id'];
            foreach ($id as $data) {
                $orderid[] = ['_id' => $data];
            }
            $params['$or'] = $orderid;
        }
        $params['merchant'] = $this->merchant;
        $this->aratadb->where($params)->set(["status" => $status])->update_all('orders');
    }
    public function update_paid($json)
    {
        $params['_id'] = $json->id;
        $params['merchant'] = $this->merchant;
        $params['payment.method'] = $json->name;
        $params['payment.payment_amount'] = (int)$json->amount;
        $payment = $json->payment == 'true' ? true : false;
        $update['payment.$.is_paid'] = $payment;
        if ($payment) {
            $update['payment.$.paid_at'] = $this->mongo_db->date();
        } else {
            $update['payment.$.paid_at'] = null;
        }
        $db = $this->aratadb->where($params)->set($update)->update('orders');
        if ($db->getModifiedCount() === 0) {
            $result['status'] = 'failed';
        } else {
            $result['status'] = 'success';
            $result['id'] = 'alert' . first_word($json->name) . $json->amount;
            $result['date'] = $update['payment.$.paid_at'] ? datephp('d M y', $update['payment.$.paid_at']) : null;
            $result['new'] = $json->payment == 'true' ? 'alert-success' : 'alert-warning';
            $result['old'] = $result['new'] == 'alert-warning' ? 'alert-success' : 'alert-warning';
        }
        return $result;
    }
    public function update_kresek($kresek, $id)
    {
        $params['_id'] = $id;
        $params['merchant'] = $this->merchant;
        $this->aratadb->where($params)->set(["kresek" => $kresek])->update('orders');
    }
    public function inputCourier($json)
    {
        foreach ($json->item as $keys => $val) {
            $id_courier = $val->id_courier ? $val->id_courier : null;
            $param['_id'] = $val->id_order;
            $update['id_courier'] = $id_courier;
            $this->aratadb->where($param)->set($update)->update('orders');
        }
        return $this->sum_courier($json->date);
    }
    public function sum_courier($tgl = null)
    {
        if ($tgl) {
            $startDate = $this->mongo_db->date(strtotime("$tgl") * 1000);
            $endDate = $this->mongo_db->date((strtotime("$tgl") + 86399) * 1000);
            $params['delivery_time']['$gte'] = $startDate;
            $params['delivery_time']['$lte'] = $endDate;
        }
        $params['status'] = 'onprocess';
        $params['merchant'] = $this->merchant;
        $pipeline_receipt = [
            ['$match' => ['$and' => [$params]]],
            ['$group' => ['_id' => '$id_courier', 'count' => ['$sum' => 1], 'total' => ['$sum' => '$price.total'], 'shipping_weight' => ['$sum' => '$shipping_weight']]],
            ['$lookup' => [
                'from' => 'courier',
                'localField' => '_id',
                'foreignField' => '_id',
                'as' => 'courier'
            ]],
            ['$project' => ['_id' => '$_id', 'urut' => ['$arrayElemAt' => ['$courier.order', 0]], 'name' => ['$arrayElemAt' => ['$courier.name', 0]], 'count' => '$count', 'total' => '$total', 'shipping_weight' => '$shipping_weight']],
            ['$sort'  => ['urut' => 1]]
        ];
        $orders = $this->aratadb->aggregate('orders', $pipeline_receipt);
        $courier = $this->aratadb->order_by(['order' => 'ASC'])->get('courier');
        foreach ($orders as $o) {
            if (!$o['_id']) {
                $c['_id'] = 'NULL';
                $c['order'] = 0;
                $c['name'] = 'NULL';
                $c['count'] = $o['count'];
                if ($o['count'] < 7) {
                    $c['count_color'] = 'table-warning';
                } else if ($o['count'] <= 9) {
                    $c['count_color'] = 'table-success';
                } else if ($o['count'] > 9) {
                    $c['count_color'] = 'table-danger';
                } else {
                    $c['count_color'] = null;
                }
                $c['shipping_weight'] = round($o['shipping_weight'] / 1000, 2);
                if ($c['shipping_weight'] < 30) {
                    $c['weight_color'] = 'table-warning';
                } else if ($c['shipping_weight'] > 45) {
                    $c['weight_color'] = 'table-danger';
                } else {
                    $c['weight_color'] = null;
                }
                $result[] = $c;
            }
        }
        foreach ($courier as $c) {
            $key = array_search($c['_id'], array_column($orders, "_id"));
            if ($key !== false) {
                $c['count'] = $orders[$key]['count'];
                if ($c['count'] < 7) {
                    $c['count_color'] = 'table-warning';
                } else if ($c['count'] <= 9) {
                    $c['count_color'] = 'table-success';
                } else if ($c['count'] > 9) {
                    $c['count_color'] = 'table-danger';
                } else {
                    $c['count_color'] = null;
                }
                $c['shipping_weight'] = round($orders[$key]['shipping_weight'] / 1000, 2);
                if ($c['shipping_weight'] < 30) {
                    $c['weight_color'] = 'table-warning';
                } else if ($c['shipping_weight'] > 45) {
                    $c['weight_color'] = 'table-danger';
                } else {
                    $c['weight_color'] = null;
                }
            } else {
                $c['shipping_weight'] = 0;
                $c['weight_color'] = null;
                $c['count'] = 0;
                $c['count_color'] = null;
            }
            $result[] = $c;
        }
        return $result;
    }
    public function inputCluster($json)
    {
        $params['merchant'] = $this->merchant;
        $params['phone'] = $json->phone;
        $params['shipping_address.address'] = $json->address;
        $dt = $this->aratadb->get_where('customers', $params);
        $shipping_address = json_decode(json_encode($dt[0]['shipping_address']), true);
        if ($shipping_address) {
            $col = array_search($json->address, array_column($shipping_address, "address"));
            if ($col !== false) {
                $update["shipping_address.$col.id_cluster"] = $json->cluster;
                $this->aratadb->where($params)->set($update)->update('customers');
            }
        }
        $id['_id'] = $json->_id;
        $db = $this->aratadb->where($id)->set(["recipient.id_cluster" => $json->cluster])->update('orders');
        if ($db->getModifiedCount() === 0) {
            $result = [
                'status' => 'failed',
                'name'    => $dt[0]['name']
            ];
        } else {
            $result = [
                'status' => 'success',
                'name'    => $dt[0]['name']
            ];
        }
        return $result;
    }
    public function inputRefund($json)
    {
        $params['_id'] = $json->_id;
        $params['merchant'] = $this->merchant;
        if (isset($json->internal_notes)) {
            $order['internal_notes'] = $json->internal_notes;
        } else {
            if ($json->refund_price) {
                $refund_paid = $json->refund_paid === 'true' ? true : false;
                $label = $json->refund_paid === 'true' ? 'label label-success' : 'label label-danger';
                $order['refund']['refund_category'] = $json->refund_category;
                $order['refund']['refund_price'] = (int)$json->refund_price;
                $order['refund']['refund_method'] = $json->refund_method;
                $order['refund']['refund_notes'] = $json->refund_notes;
                $order['refund']['refund_paid'] = $refund_paid;
                $order['refund']['file'] = $json->file;
                if ($json->refund_voucher) {
                    $order['refund']['refund_voucher'] = $json->refund_voucher;
                }
            } else {
                if ($json->refund_voucher) {
                    $params2['code'] = $json->refund_voucher;
                    $this->aratadb->where($params2)->delete('voucher');
                }
                $order['refund'] = null;
            }
        }
        $db = $this->aratadb->where($params)->set($order)->update('orders');
        if ($db->getModifiedCount() === 0) {
            $result['status'] = 'failed';
            $result['name'] = $json->name;
        } else {
            $result['_id'] = $json->_id;
            $result['status'] = 'success';
            $result['name'] = $json->name;
            $result['phone'] = $json->phone;
            if ($json->refund_price) {
                $result['refund_price'] = $json->refund_price;
                $result['refund_method'] = $json->refund_method;
                $result['file'] = $json->file;
                $result['refund_paid'] = $json->refund_paid === 'true' ? true : false;
                $result['label'] = $label;
            }
        }
        return $result;
    }
    public function ruteCourier($tgl)
    {
        if ($tgl) {
            $startDate = $this->mongo_db->date(strtotime("$tgl") * 1000);
            $endDate = $this->mongo_db->date((strtotime("$tgl") + 86399) * 1000);
            $params['delivery_time']['$gte'] = $startDate;
            $params['delivery_time']['$lte'] = $endDate;
        }
        $params['$nor'] = [['id_courier' => ""], ['id_courier' => null], ['id_courier' => " "]];
        $params['status'] = 'onprocess';
        $params['merchant'] = $this->merchant;
        $pipeline_receipt = [
            ['$lookup' => [
                'from' => 'customers',
                'localField' => 'customer.phone',
                'foreignField' => 'phone',
                'as' => 'customers'
            ]],
            ['$match' => ['$and' => [$params]]],
            ['$project' => ['_id' => '$_id', 'id_courier' => '$id_courier', 'recipient' => '$recipient', 'merchant_notes' => '$merchant_notes', 'preferences' => ['$reduce' => ['input' => '$customers.preferences', 'initialValue' => [], 'in' => ['$concatArrays' => ['$$value', '$$this']]]], 'nominal' => '$price.total']],
            ['$project' => ['_id' => '$_id', 'id_courier' => '$id_courier', 'recipient' => '$recipient', 'merchant_notes' => '$merchant_notes', 'nominal' => '$nominal', 'preferences' => ['$reduce' => ['input' => '$preferences', 'initialValue' => '', 'in' => [
                '$cond' => [
                    'if' => [
                        '$eq' => [
                            [
                                '$indexOfArray' => [
                                    '$preferences',
                                    '$$this'
                                ]
                            ],
                            0
                        ]
                    ],
                    'then' => [
                        '$concat' => [
                            '$$value',
                            '$$this'
                        ]
                    ],
                    'else' => [
                        '$concat' => [
                            '$$value',
                            ', ',
                            '$$this'
                        ]
                    ]
                ]
            ]]]]],
            ['$group' => ['_id' => ['id_courier' => '$id_courier', 'phone' => '$recipient.phone'], 'count' => ['$sum' => 1], 'nominal' => ['$sum' => '$nominal'], 'note' => ['$addToSet' => ['name' => '$recipient.name', 'merchant_notes' => '$merchant_notes', 'preferences' => '$preferences']]]],
            ['$group' => ['_id' => '$_id.id_courier', 'order' => ['$sum' => 1], 'total' => ['$sum' => '$count'], 'nominal' => ['$sum' => '$nominal'], 'note' => ['$addToSet' => '$note']]],
            ['$lookup' => [
                'from' => 'courier',
                'localField' => '_id',
                'foreignField' => '_id',
                'as' => 'courier'
            ]],
            ['$project' => ['_id' => '$_id', 'order' => '$order', 'total' => '$total', 'nominal' => '$nominal', 'note' => '$note', 'urut' => ['$arrayElemAt' => ['$courier.order', 0]]]],
            ['$sort'  => ['urut' => 1]]
        ];
        $order = $this->aratadb->aggregate('orders', $pipeline_receipt);
        foreach ($order as $ord) {
            $ord['cat'] = [];
            foreach ($ord['note'] as $o) {
                if ($o[0]->merchant_notes || $o[0]->preferences) {
                    $hub = $o[0]->merchant_notes && $o[0]->preferences ? ', ' : null;
                    $name = $o[0]->name ? $o[0]->name . ': ' : null;
                    $merchant_notes = $o[0]->merchant_notes ? $o[0]->merchant_notes : null;
                    $preferences = $o[0]->preferences ? $o[0]->preferences : null;
                    $cat = $name . $merchant_notes . $hub . $preferences;
                    array_push($ord['cat'], $cat);
                }
            }
            $result[] = $ord;
        }
        return $result;
    }
    public function waCourier($tgl, $id = null, $status = null, $textwa = null)
    {
        if ($tgl) {
            $startDate = $this->mongo_db->date(strtotime("$tgl") * 1000);
            $endDate = $this->mongo_db->date((strtotime("$tgl") + 86399) * 1000);
            $params['delivery_time']['$gte'] = $startDate;
            $params['delivery_time']['$lte'] = $endDate;
            $rute = $this->aratadb->order_by(['created_at' => 'DESC'])->where($params)->get('rute_courier');
        }
        if ($id) {
            if ($id == 'null') {
                $params['$or'] = [['id_courier' => ""], ['id_courier' => null], ['id_courier' => " "]];
            } else {
                $params['id_courier'] = $id;
            }
        }
        if ($status) {
            $params['status'] = $status;
        } else {
            $params['status'] = 'onprocess';
        }
        $params['merchant'] = $this->merchant;
        $pipeline_receipt = [
            ['$lookup' => [
                'from' => 'customers',
                'localField' => 'customer.phone',
                'foreignField' => 'phone',
                'as' => 'customers'
            ]],
            ['$match' => ['$and' => [$params]]],
            ['$group' => ['_id' => ['id_courier' => '$id_courier', 'phone' => '$recipient.phone'], 'count' => ['$sum' => 1], 'nominal' => ['$sum' => '$price.total'], 'note' => ['$addToSet' => ['id_order' => '$_id', 'customer_phone' => '$customer.phone', 'lower' => ['$toLower' => '$recipient.name'], 'customers' => ['$arrayElemAt' => ['$customers.shipping_address', 0]], 'name' => '$recipient.name', 'phone' => '$recipient.phone', 'address' => '$recipient.address', 'shipping' => '$shipping', 'merchant_notes' => '$merchant_notes', 'preferences' => ['$arrayElemAt' => ['$customers.preferences', 0]], 'payment' => ['$filter' => ['input' => '$payment', 'as' => 'pay', 'cond' => ['$eq' => ['$$pay.method', 'COD - Bayar Di Tujuan (Hanya Untuk Pembelian Kedua)']]]], 'kerupuk' => ['$filter' => ['input' => '$items', 'as' => 'item', 'cond' => ['$eq' => ['$$item.id_item', '618f3d201d73507bfe3930ff']]]], 'peyek_ebi' => ['$filter' => ['input' => '$items', 'as' => 'item', 'cond' => ['$eq' => ['$$item.id_item', '6202c8256462d03ab651ceb5']]]], 'peyek_kacang' => ['$filter' => ['input' => '$items', 'as' => 'item', 'cond' => ['$eq' => ['$$item.id_item', '6202c7dd06177d531c167c62']]]]]]]],
            ['$group' => ['_id' => '$_id.id_courier', 'order' => ['$sum' => 1], 'total' => ['$sum' => '$count'], 'nominal' => ['$sum' => '$nominal'], 'note' => ['$addToSet' => '$note']]],
            ['$lookup' => [
                'from' => 'courier',
                'localField' => '_id',
                'foreignField' => '_id',
                'as' => 'courier'
            ]],
            ['$project' => ['_id' => '$_id', 'urut' => ['$arrayElemAt' => ['$courier.order', 0]], 'name' => ['$arrayElemAt' => ['$courier.name', 0]], 'phone' => ['$arrayElemAt' => ['$courier.phone', 0]], 'order' => '$order', 'total' => '$total', 'nominal' => '$nominal', 'recipient' => ['$reduce' => ['input' => '$note', 'initialValue' => [], 'in' => ['$concatArrays' => ['$$value', '$$this']]]]]],
            ['$sort'  => ['urut' => 1]]
        ];
        $courier = $this->aratadb->aggregate('orders', $pipeline_receipt);
        $jam = date('H');
        if ($rute) {
            foreach ($courier as $val) {
                if ($jam < 10 || $jam > 20) {
                    $key = array_search($val['_id'], array_column($rute[0]['data'], "_id"));
                    $val['time_courier'] = $key !== false ? $rute[0]['data'][$key]->time : null;
                    if ($val['time_courier']) {
                        $order = $val['order'] < 4 ? 4 : $val['order'];
                        $hours1 = strtotime(date($val['time_courier'])) + 2400;
                        $hours2 = $hours1 + ($order * 900);
                        $val['time_customer'] = date('H:i', $hours1) . '-' . date('H:i', $hours2);
                    }
                }
                if ($textwa) {
                    $keys = array_column($val['recipient'], 'lower');
                    array_multisort($keys, SORT_ASC, $val['recipient']);
                    $total = $val['total'] == $val['order'] ? $val['order'] : $val['total'] . '/' . $val['order'];
                    $time_courier = $val['time_courier'] ? 'Jam paket siap: *' . $val['time_courier'] . "*\n" : null;
                    $time_customer = $val['time_customer'] ? 'Target customer terima: *' . $val['time_customer'] . "*\n" : null;
                    $text = '*' . $val['_id'] . ' = ' . $total . " alamat*\n$time_courier$time_customer\n";
                    $no = 1;
                    foreach ($val['recipient'] as $key => $data) {
                        $shipping = strpos($data->shipping, 'Sidoarjo') !== false ? 'Sidoarjo' : $data->shipping;
                        $address = strpos(ucwords($data->address), $shipping) !== false ? $data->address : $data->address . ', ' . $shipping;
                        $location = null;
                        foreach ($data->customers as $k => $v) {
                            if (strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $v->address)) == strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $data->address)) && $v->latitude) {
                                $location = 'https://www.google.com/maps/place/' . $v->latitude . ',' . $v->longitude . "\n";
                                break;
                            }
                        }
                        $hub = $data->merchant_notes && $data->preferences ? "\n" : null;
                        $preferences = $data->preferences ? implode("\n", $data->preferences) : null;
                        $note = $data->merchant_notes || $data->preferences ? '*Note:* ' . $data->merchant_notes . $hub . $preferences . "\n" : null;
                        $cod = $data->payment ? '*COD:* ' . thousand($data->payment[0]->payment_amount) . "\n" : null;
                        $text = $text . '*' . $no++ . '. ' . $data->name . ' (wa.me/' . nohp($data->phone) . ")*\n" . $address . "\n" . $location . $note . $cod . "\n";
                    }
                    $search = array('&', '<', '>');
                    $replace = array(" dan ", "", "");
                    $val['textwa'] = str_replace($search, $replace, $text);
                }
                $result[] = $val;
            }
            return $result;
        } else {
            return $courier;
        }
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
            ['$match' => ['$and' => [$where]]],
            ['$project' => ['delivery_time' => ['$dateToString' => ['format' => '%Y%m%d%H%M %d-%m-%Y', 'date' => '$delivery_time', 'timezone' => '+07:00']], 'transaction_date' => ['$dateToString' => ['format' => '%Y%m%d%H%M %d-%m-%Y %H:%M', 'date' => '$transaction_date', 'timezone' => '+07:00']], 'delivery_shift' => '$delivery_shift', 'invno' => '$invno', 'customer' => '$customer', 'recipient' => '$recipient', 'price' => '$price', 'payment' => '$payment', 'merchant' => '$merchant', 'refund' => '$refund', 'voucher' => '$voucher', 'shipping_weight' => ['$round' => [['$divide' => ['$shipping_weight', 1000]], 2]]]],
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
        $result['all_data'] = $this->aratadb->where($where)->count('orders');
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
        $where = ['merchant' => $this->merchant, 'status' => $data['status']];
        if ($data['start'] and $data['end']) {
            $startDate = $this->mongo_db->date(strtotime($data['start']) * 1000);
            $endDate = $this->mongo_db->date((strtotime($data['end']) + 86399) * 1000);
            $where_date = ['delivery_time' => ['$gte' => $startDate, '$lte' => $endDate]];
            $where = array_merge($where, $where_date);
        }
        if ($data['payment']) {
            $where_payment = ['payment.method' => new MongoDB\BSON\Regex($data['payment'], 'i')];
            $where = array_merge($where, $where_payment);
        }
        if ($data['refund']) {
            $where_refund = ['$nor' => [['refund' => null]]];
            $where = array_merge($where, $where_refund);
        }
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
    private function pipeline2($where, $order, $limit, $start, $x = null)
    {
        $pipeline = [
            ['$match' => ['$and' => [['merchant' => $this->merchant]]]],
            ['$addFields' => ['aEq' => ['$eq' => ['$customer.phone', '$recipient.phone']]]],
            ['$match' => ['aEq' => false]],
            ['$project' => ['transaction_date' => '$transaction_date', 'delivery_time' => '$delivery_time', 'delivery_shift' => '$delivery_shift', 'invno' => '$invno', 'customer' => '$customer.name', 'recipient' => '$recipient.name', 'price' => '$price', 'payment' => '$payment', 'merchant' => '$merchant']],
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
    private function filter2($where, $order, $limit, $start, $search, $where_search)
    {
        $pipe = [
            ['$match' => ['$and' => [['merchant' => $this->merchant]]]],
            ['$addFields' => ['aEq' => ['$eq' => ['$customer.phone', '$recipient.phone']]]],
            ['$match' => ['aEq' => false]],
            ['$project' => ['transaction_date' => '$transaction_date', 'delivery_time' => '$delivery_time', 'invno' => '$invno', 'customer' => '$customer.name', 'recipient' => '$recipient.name', 'price' => '$price', 'payment' => '$payment', 'merchant' => '$merchant']],
            ['$match' => ['$and' => [$where]]]
        ];
        $result['all_data'] = count($this->aratadb->aggregate('orders', $pipe));
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
        if ($data['start'] and $data['end']) {
            $startDate = $this->mongo_db->date(strtotime($data['start']) * 1000);
            $endDate = $this->mongo_db->date((strtotime($data['end']) + 86399) * 1000);
            $where_date = ['delivery_time' => ['$gte' => $startDate, '$lte' => $endDate]];
            $where = array_merge($where, $where_date);
        }
        $result = $this->filter2($where, $params['$order'], $params['limit'], $params['start'], $params['search'], $data['where_search']);
        $callback = $this->callback2($result);
        return json_encode($callback);
    }
}
