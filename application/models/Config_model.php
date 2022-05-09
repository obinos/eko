<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Config_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('mongo_db', array('activate' => 'arata'), 'aratadb');
    }
    public function dataConfig()
    {
        $dt = $this->aratadb->get('config');
        if (!$dt) {
            return [];
        } else {
            return $dt;
        }
    }
    public function editConfig($json)
    {
        $params['_id'] = $json->_id;
        if ($params['_id'] == 'MAX_LIMIT_ORDER') {
            $update['val'] = (int)$json->val;
        } elseif ($params['_id'] == 'FREE_ONGKIR') {
            $update['val'] = $json->val == 'true' ? true : false;
        }
        $check = $this->aratadb->where($params)->get('config');
        if ($check) {
            $db = $this->aratadb->where($params)->set($update)->update('config');
            if ($db->getModifiedCount() === 0) {
                $result = [
                    'status' => 'failed',
                    '_id'    => $json->_id,
                    'val'    => $update['val']
                ];
            } else {
                $config = $this->aratadb->where($params)->get('config');
                $config[0] += ['status' => 'success'];
                $result = $config[0];
            }
        } else {
            $data = [
                "_id" => $json->_id,
                "val" => $update['val']
            ];
            $config = $this->aratadb->insert('config', $data);
            $config += ['status' => 'success'];
            $result = $config;
        }
        return $result;
    }
}
