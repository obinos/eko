<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Item_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('mongo_db', array('activate' => 'arata'), 'aratadb');
        $this->merchant = '606eba1c099777608a38aeda';
    }
    public function get_items($array = null)
    {
        if ($array['_id']) {
            $params['_id'] = $array['_id'];
        }
        if ($array['station'] && $array['station'] == 'null') {
            $params['$or'] = [['station' => ""], ['station' => null], ['station' => " "]];
        } elseif ($array['station'] && $array['station'] != 'null' && $array['station'] != 'all') {
            $params['station'] = $array['station'];
        }
        if ($array['active'] && $array['active'] != 'null') {
            $params['active'] = $array['active'] === 'true' ? true : false;
        }
        if ($array['is_bestseller'] && $array['is_bestseller'] != 'null') {
            $params['is_bestseller'] = $array['is_bestseller'] === 'true' ? true : false;
        }
        $params['merchant'] = $this->merchant;
        $pipeline_receipt = [
            ['$lookup' => [
                'from' => 'categories',
                'let' => ['id_category' => '$id_category'],
                'pipeline' => [[
                    '$match' => [
                        '$expr' => ['$eq' => ['$_id', '$$id_category']],
                        'merchant' => $this->merchant
                    ]
                ]],
                'as' => 'category'
            ]],
            ['$lookup' => [
                'from' => 'supplier',
                'localField' => 'id_supplier',
                'foreignField' => '_id',
                'as' => 'supplier'
            ]],
            ['$match' => ['$and' => [$params]]],
            ['$project' => ['lowername' => ['$toLower' => '$name'], '_id' => '$_id', 'active' => '$active', 'is_bestseller' => '$is_bestseller', 'is_preorder' => '$is_preorder', 'barcode' => '$barcode', 'name' => '$name', 'alias' => '$alias', 'desc' => '$desc', 'price' => '$price', 'sales_price' => '$sales_price', 'weight' => '$weight', 'weight_unit' => '$weight_unit', 'id_supplier' => '$id_supplier', 'supplier' => ['$arrayElemAt' => ['$supplier.name', 0]], 'station' => '$station', 'id_category' => '$id_category', 'category' => ['$arrayElemAt' => ['$category.name', 0]], 'stock_managed' => '$stock_managed', 'stock' => '$stock', 'stock_default' => '$stock_default', 'stock_min' => '$stock_min', 'stock_max' => '$stock_max', 'profit_best' => '$profit_best', 'profit_min' => '$profit_min', 'profit_max' => '$profit_max', 'created_at' => '$created_at', 'purchase_price' => '$purchase_price', 'order_limit' => '$order_limit', 'store_price' => '$store_price']],
            ['$sort'  => ['active' => -1, 'station' => 1, 'lowername' => 1]]
        ];
        $items = $this->aratadb->aggregate('items', $pipeline_receipt);
        if (!$items) {
            return [];
        } else {
            return $items;
        }
    }
    public function typeaheadPurchase()
    {
        $params['merchant'] = $this->merchant;
        $result = $this->aratadb->select(['_id', 'name', 'station', 'active', 'weight_unit', 'weight', 'purchase_price'])->order_by(['active' => 'DESC', 'name' => 'ASC'])->where($params)->get('items');
        return $result;
    }
    public function typeaheadOpname()
    {
        $params['merchant'] = $this->merchant;
        $result = $this->aratadb->select(['_id', 'name', 'active', 'stock', 'barcode', 'stock_default', 'purchase_price'])->order_by(['active' => 'DESC', 'name' => 'ASC'])->where($params)->get('items');
        return $result;
    }
    public function nominalStock()
    {
        $params['active'] = true;
        $params['stock_managed'] = true;
        $params['merchant'] = $this->merchant;
        $params['$or'] = [['stock_default' => 0], ['stock_default' => '0'], ['stock_default' => ''], ['stock_default' => null]];
        $pipeline = [
            ['$match' => ['$and' => [$params]]],
            ['$project' => ['name' => '$name', 'merchant' => '$merchant', 'station' => '$station', 'stock' => '$stock', 'avg_price' => '$purchase_price.avg_price', 'nominal' => ['$multiply' => ['$stock', '$purchase_price.avg_price']]]],
            ['$group' => ['_id' => '$merchant', 'total' => ['$sum' => '$nominal'], 'items' => ['$addToSet' => ['_id' => '$_id', 'name' => '$name', 'station' => '$station', 'stock' => '$stock', 'avg_price' => '$avg_price', 'nominal' => '$nominal']]]]
        ];
        $result = $this->aratadb->aggregate('items', $pipeline);
        if (!$result) {
            return [];
        } else {
            return $result;
        }
    }
    public function getStation()
    {
        $params['$nor'] = [['station' => null], ['station' => '']];
        $params['merchant'] = $this->merchant;
        $pipeline_receipt = [
            ['$match' => ['$and' => [$params]]],
            ['$group' => ['_id' => '$station']],
            ['$sort'  => ['_id' => 1]]
        ];
        $station = $this->aratadb->aggregate('items', $pipeline_receipt);
        foreach ($station as $s) {
            $result[] = $s['_id'];
        }
        return $result;
    }
    public function editItem($json)
    {
        $params['_id'] = $json->_id;
        $params['merchant'] = $this->merchant;
        $items = $this->aratadb->where($params)->get('items');
        $desc = $items[0]['desc'] ? $items[0]['desc'] : '';
        $active = $json->active === 'true' ? true : false;
        $sales_price = $json->sales_price ? (int)$json->sales_price : (int)$json->price;
        $stock_managed = $json->stock_managed === 'true' ? true : false;
        $is_preorder = $json->is_preorder === 'true' ? true : false;
        $stock_default = $json->stock_default ? $json->stock_default : '0';
        $order_limit = $json->order_limit ? (int)$json->order_limit : null;
        $is_bestseller = $json->is_bestseller === 'true' ? true : false;
        $hpp = (int)$json->hpp;
        $profit_min = (int)$json->profit_min;
        $profit_max = (int)$json->profit_max;
        if ($active === false) {
            $item["stock"] = 0;
        }
        $item = [
            "desc"                     => $desc,
            "active"                   => $active,
            "is_bestseller"            => $is_bestseller,
            "is_preorder"              => $is_preorder,
            "barcode"                  => $json->barcode,
            "id_category"              => $json->id_category,
            "name"                     => $json->name,
            "alias"                    => $json->alias,
            "price"                    => (int)$json->price,
            "sales_price"              => $sales_price,
            "purchase_price.avg_price" => $hpp,
            "weight"                   => (int)$json->weight,
            "weight_unit"              => $json->weight_unit,
            "stock_managed"            => $stock_managed,
            // "stock"                 => (int)$json->stock,
            "stock_default"            => $stock_default,
            "stock_min"                => (int)$json->stock_min,
            "stock_max"                => (int)$json->stock_max,
            "profit_min"               => $profit_min,
            "profit_best"              => (int)$json->profit_best,
            "profit_max"               => $profit_max,
            "order_limit"              => $order_limit,
            "id_supplier"              => $json->id_supplier,
            "station"                  => strtoupper($json->station),
            "updated_at"               => $this->mongo_db->date()
        ];
        if ($items[0]['purchase_price']->last->price == '0' || $items[0]['purchase_price']->last->price == 0 || !$items[0]['purchase_price']->last->price) {
            $price = $hpp;
        } else {
            $price = $items[0]['purchase_price']->last->price;
        }
        $lastprice = [
            'purchase_price.last.price' => $price,
            'purchase_price.last.updated_at' => $this->mongo_db->date()
        ];
        $item = array_merge($item, $lastprice);
        $db = $this->aratadb->where($params)->set($item)->update('items');
        $array['_id'] = $json->_id;
        $result = $this->get_items($array);
        if ($db->getModifiedCount() === 0) {
            $result[0]['status'] = 'failed';
        } else {
            $profit = round((($sales_price - $hpp) / $sales_price) * 100, 2);
            if ($profit < $profit_min || $profit > $profit_max) {
                $icon = $profit < $profit_min ? "table-danger" : "table-success";
                $result[0]['bg_hpp'] = $icon;
            }
            $result[0]['current_profit'] = $profit;
            $result[0]['status'] = 'success';
        }
        return $result[0];
    }
    public function editItemStore($json)
    {
        $params['_id'] = $json->_id;
        $params['merchant'] = $this->merchant;
        $items = $this->aratadb->where($params)->get('items');
        $data['base_price'] = (int)$json->base_price;
        $data['rack'] = $json->rack;
        $data['retur'] = $json->retur;
        $data['unit'] = $json->unit;
        $data['discount'] = $json->discount ? (int)$json->discount : 0;
        $data['sales_price'] = $data['base_price'] - $data['discount'];
        if (!$items[0]['store_price']) {
            $items[0]['store_price'] = new stdClass();
        }
        $items[0]['store_price']->{$json->id_store} = $data;
        $item = [
            "store_price" => $items[0]['store_price'],
            "updated_at"  => $this->mongo_db->date()
        ];
        $db = $this->aratadb->where($params)->set($item)->update('items');
        if ($db->getModifiedCount() === 0) {
            $result['status'] = 'failed';
        } else {
            $result['status'] = 'success';
            $item = $this->aratadb->where($params)->get('items');
            $result['_id'] = $item[0]['_id'];
            $result['name'] = $item[0]['name'];
            $result['avg_hpp'] = $item[0]['purchase_price']->avg_price ? thousand($item[0]['purchase_price']->avg_price) : thousand($item[0]['purchase_price']->last->price);
            $result['rack'] = $item[0]['store_price']->{$json->id_store}->rack ? $item[0]['store_price']->{$json->id_store}->rack : null;
            $result['retur'] = $item[0]['store_price']->{$json->id_store}->retur ? $item[0]['store_price']->{$json->id_store}->retur : null;
            $result['unit'] = $item[0]['store_price']->{$json->id_store}->unit ? $item[0]['store_price']->{$json->id_store}->unit : null;
            $result['base_price'] = $item[0]['store_price']->{$json->id_store}->base_price ? thousand($item[0]['store_price']->{$json->id_store}->base_price) : 0;
            $result['discount'] = $item[0]['store_price']->{$json->id_store}->discount ? thousand($item[0]['store_price']->{$json->id_store}->discount) : 0;
            $result['sales_price'] = $item[0]['store_price']->{$json->id_store}->sales_price ? thousand($item[0]['store_price']->{$json->id_store}->sales_price) : 0;
            $result['label'] = $result['sales_price'] < $result['avg_hpp'] ? 'table-danger' : null;
        }
        return $result;
    }
    public function checkItem($barcode)
    {
        $params['barcode'] = $barcode;
        $params['merchant'] = $this->merchant;
        $result = $this->aratadb->where($params)->get('items');
        return $result;
    }
}
