<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('mongo_db', array('activate' => 'arata'), 'aratadb');
    }
    public function dataSupplier($id = null)
    {
        if ($id) {
            $dt = $this->aratadb->get_where('supplier', ['_id' => $id]);
        } else {
            $dt = $this->aratadb->order_by(['name' => 'ASC'])->get('supplier');
        }
        if (!$dt) {
            return [];
        } else {
            return $dt;
        }
    }
    public function addSupplier($json)
    {
        $data = [
            "_id"        => (string) new MongoDB\BSON\ObjectId(),
            "name"       => ucwords(strtolower(htmlspecialchars($json->name))),
            "created_at" => $this->mongo_db->date(),
            "updated_at" => $this->mongo_db->date()
        ];
        $result = $this->aratadb->insert('supplier', $data);
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
    public function editSupplier($json)
    {
        $params['_id'] = $json->_id;
        $update['name'] = ucwords(strtolower(htmlspecialchars($json->name)));
        $update['updated_at'] = $this->mongo_db->date();
        $db = $this->aratadb->where($params)->set($update)->update('supplier');
        if ($db->getModifiedCount() === 0) {
            $result = [
                'action' => 'Edit',
                'status' => 'failed',
                'name'   => $update['name']
            ];
        } else {
            $result = [
                'action' => 'Edit',
                'status' => 'success',
                '_id'    => $json->_id,
                'name'   => $update['name']
            ];
        }
        return $result;
    }
    public function deleteSupplier($id)
    {
        $params['_id'] = $id;
        $supplier = $this->aratadb->where($params)->get('supplier');
        $db = $this->aratadb->where($params)->delete('supplier');
        if ($db->getDeletedCount() === 0) {
            $result = [
                'status' => 'failed',
                'name'   => $supplier[0]['name'],
                'id'     => $id
            ];
        } else {
            $result = [
                'status' => 'success',
                'name'   => $supplier[0]['name'],
                'id'     => $id
            ];
        }
        return $result;
    }
    public function checkSupplier($name)
    {
        return $this->aratadb->get_where('supplier', ['name' => $name]);
    }
}
