<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cluster_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('mongo_db', array('activate' => 'arata'), 'aratadb');
    }
    public function dataCluster($id = null)
    {
        if ($id) {
            $dt = $this->aratadb->get_where('cluster', ['_id' => $id]);
        } else {
            $dt = $this->aratadb->order_by(['code' => 'ASC'])->get('cluster');
        }
        if (!$dt) {
            return [];
        } else {
            return $dt;
        }
    }
    public function addCluster($json)
    {
        $data = [
            "_id"        => (string) new MongoDB\BSON\ObjectId(),
            "name"       => ucwords(strtolower(htmlspecialchars($json->name))),
            "code"       => strtoupper($json->code),
            "created_at" => $this->mongo_db->date(),
            "updated_at" => $this->mongo_db->date()
        ];
        $result = $this->aratadb->insert('cluster', $data);
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
    public function editCluster($json)
    {
        $params['_id'] = $json->_id;
        $update['name'] = ucwords(strtolower(htmlspecialchars($json->name)));
        $update['code'] = strtoupper($json->code);
        $update['updated_at'] = $this->mongo_db->date();
        $db = $this->aratadb->where($params)->set($update)->update('cluster');
        if ($db->getModifiedCount() === 0) {
            $result = [
                'action' => 'Edit',
                'status' => 'failed',
                'code'   => $update['code'],
                'name'   => $update['name']
            ];
        } else {
            $result = [
                'action' => 'Edit',
                'status' => 'success',
                '_id'    => $json->_id,
                'code'   => $update['code'],
                'name'   => $update['name']
            ];
        }
        return $result;
    }
    public function deleteCluster($id)
    {
        $params['_id'] = $id;
        $cluster = $this->aratadb->where($params)->get('cluster');
        $db = $this->aratadb->where($params)->delete('cluster');
        if ($db->getDeletedCount() === 0) {
            $result = [
                'status' => 'failed',
                'name'   => $cluster[0]['name'],
                'id'     => $id
            ];
        } else {
            $result = [
                'status' => 'success',
                'name'   => $cluster[0]['name'],
                'id'     => $id
            ];
        }
        return $result;
    }
    public function checkCluster($name)
    {
        return $this->aratadb->get_where('cluster', ['name' => $name]);
    }
}
