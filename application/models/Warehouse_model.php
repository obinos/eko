<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Warehouse_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('mongo_db', array('activate' => 'arata'), 'aratadb');
    }
    public function dataWarehouse($id = null)
    {
        if ($id) {
            $dt = $this->aratadb->get_where('warehouse', ['_id' => $id]);
        } else {
            $dt = $this->aratadb->order_by(['name' => 'ASC'])->get('warehouse');
        }
        if (!$dt) {
            return [];
        } else {
            return $dt;
        }
    }
    public function nameWarehouse($name)
    {
        $dt = $this->aratadb->get_where('warehouse', ['name' => $name]);
        if (!$dt) {
            return [];
        } else {
            return $dt;
        }
    }
    public function addWarehouse($json)
    {
        $data = [
            "_id"  => (string) new MongoDB\BSON\ObjectId(),
            "name" => ucwords(strtolower(htmlspecialchars($json->name))),
            "phone" => nohp($json->phone),
            "address" => htmlspecialchars($json->address),
            "city" => ucwords(strtolower(htmlspecialchars($json->city)))
        ];
        $result = $this->aratadb->insert('warehouse', $data);
        if ($result) {
            $result += ['status' => 'success'];
            $result += ['action' => 'Add'];
            return $result;
        } else {
            $result = ['status' => 'failed'];
            $result = ['action' => 'Add'];
            return $result;
        }
    }
    public function editWarehouse($json)
    {
        $phone = nohp($json->phone);
        $params['_id'] = $json->_id;
        $update = [
            "name" => ucwords(strtolower(htmlspecialchars($json->name))),
            "phone" => $phone,
            "address" => htmlspecialchars($json->address),
            "city" => ucwords(strtolower(htmlspecialchars($json->city)))
        ];
        $db = $this->aratadb->where($params)->set($update)->update('warehouse');
        if ($db->getModifiedCount() === 0) {
            $result = [
                'action' => 'Edit',
                'status' => 'failed',
                'name'   => $json->name
            ];
        } else {
            $result = [
                'action'  => 'Edit',
                'status'  => 'success',
                '_id'     => $json->_id,
                'name'    => $json->name,
                'phone'   => $phone,
                'address' => $json->address,
                'city'    => $json->city
            ];
        }
        return $result;
    }
    public function deleteWarehouse($id)
    {
        $params['_id'] = $id;
        $warehouse = $this->aratadb->where($params)->get('warehouse');
        $db = $this->aratadb->where($params)->delete('warehouse');
        if ($db->getDeletedCount() === 0) {
            $result = [
                'status' => 'failed',
                'name'   => $warehouse[0]['name'],
                'id'     => $id
            ];
        } else {
            $result = [
                'status' => 'success',
                'name'   => $warehouse[0]['name'],
                'id'     => $id
            ];
        }
        return $result;
    }
    public function checkWarehouse($name)
    {
        return $this->aratadb->get_where('warehouse', ['name' => $name]);
    }
}
