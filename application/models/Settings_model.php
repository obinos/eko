<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('mongo_db', array('activate' => 'arata'), 'aratadb');
        $this->merchant = '606eba1c099777608a38aeda';
    }
    public function dataCluster($id = null)
    {
        if ($id) {
            $dt = $this->aratadb->get_where('cluster', ['_id' => $id]);
        } else {
            $dt = $this->aratadb->order_by(['name' => 'ASC'])->get('cluster');
        }
        return $dt;
    }
    public function addCluster($name)
    {
        $data = [
            "_id"         => (string) new MongoDB\BSON\ObjectId(),
            "name"        => $name,
            "updated_at"  => $this->mongo_db->date()
        ];
        $this->aratadb->insert('cluster', $data);
    }
    public function editCluster($array)
    {
        $data = [
            "name"       => $array['name'],
            "updated_at" => $this->mongo_db->date()
        ];
        $this->aratadb->where(['_id' => $array['id']])->set($data)->update('cluster');
    }
    public function deleteCluster($id)
    {
        $this->aratadb->where(['_id' => $id])->delete('cluster');
    }
    public function dataCourier($id = null)
    {
        if ($id) {
            $dt = $this->aratadb->get_where('courier', ['_id' => $id]);
        } else {
            $dt = $this->aratadb->order_by(['order' => 'ASC'])->get('courier');
        }
        return $dt;
    }
    public function addCourier($array)
    {
        $data = [
            "_id"   => $array['id'],
            "order" => $array['order'],
            "name"  => $array['name'],
            "phone" => $array['phone']
        ];
        $this->aratadb->insert('courier', $data);
    }
    public function editCourier($array)
    {
        $data = [
            "order" => $array['order'],
            "name"  => $array['name'],
            "phone" => $array['phone']
        ];
        $this->aratadb->where(['_id' => $array['id']])->set($data)->update('courier');
    }
    public function deleteCourier($id)
    {
        $this->aratadb->where(['_id' => $id])->delete('courier');
    }
    public function allBanner()
    {
        $dt = $this->aratadb->get('banners');
        return $dt;
    }
    public function updateBanner($image, $urut)
    {
        $data = [
            "title" => 'Banner ' . $urut,
            "image" => '/banner/' . $image,
            "urut"  => $urut
        ];
        $banner = $this->aratadb->get_where('banners', ['urut' => $urut]);
        if ($banner) {
            $this->aratadb->where(['urut' => $urut])->set($data)->update('banners');
        } else {
            $this->aratadb->insert('banners', $data);
        }
    }
    public function deleteBanner($image)
    {
        $this->aratadb->where(['image' => $image])->delete('banners');
    }
    public function addApiAuth()
    {
        $data = [
            "user"       => strtolower(htmlspecialchars($this->input->post('user', true))),
            "password"   => strtolower(htmlspecialchars($this->input->post('password', true))),
            "key"        => bin2hex(random_bytes(32)),
            "created_at" => $this->mongo_db->date()
        ];
        $this->mongo_db->insert('apiauth', $data);
    }
    public function editApiAuth()
    {
        $data = [
            "user"       => strtolower(htmlspecialchars($this->input->post('user', true))),
            "password"   => strtolower(htmlspecialchars($this->input->post('password', true)))
        ];
        $this->mongo_db->where(['_id' => check_id($this->input->post('id'))])->set($data)->update('apiauth');
    }
    public function dataItemRecom($array = null)
    {
        if ($array['_id']) {
            $params['_id'] = $array['_id'];
        }
        if ($array['urut']) {
            $params['urut'] = $array['urut'];
        }
        $params['$nor'] = [['urut' => null]];
        $pipeline = [
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
            ['$match' => ['$and' => [$params]]],
            ['$project' => ['id_item' => '$id_item', 'urut' => '$urut', 'name' => ['$arrayElemAt' => ['$item.name', 0]], 'photo' => ['$arrayElemAt' => [['$arrayElemAt' => ['$item.photo.src_webp', 0]], 0]]]],
            ['$sort'  => ['urut' => 1]]
        ];
        $result = $this->aratadb->aggregate('item_recom', $pipeline);
        if (!$result) {
            return [];
        } else {
            return $result;
        }
    }
    public function updateItemRecom($array = null)
    {
        $params['urut'] = $array['urut'];
        if ($array['id_item']) {
            $update['id_item'] = $array['id_item'];
        } else {
            $update['id_item'] = null;
        }
        $db = $this->aratadb->where($params)->set($update)->update('item_recom');
        if ($db->getModifiedCount() === 0) {
            $result[0] = [
                'status' => 'failed',
                'urut'   => $array['urut']
            ];
        } else {
            if ($array['id_item']) {
                $result = $this->dataItemRecom($params);
            } else {
                $result[0]['urut'] = $array['urut'];
            }
            $result[0]['status'] = 'success';
        }
        return $result[0];
    }
    public function editItemPackage($json)
    {
        $params['_id'] = $json->_id;
        foreach ($json->item as $keys => $val) {
            $data_item = [
                "id_item" => $val->_id,
                "qty"     => $val->qty
            ];
            $item[] = $data_item;
        }
        $purchase['composition'] = $item;
        $db = $this->aratadb->where($params)->set($purchase)->update('items');
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
}
