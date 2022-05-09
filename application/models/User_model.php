<?php

class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('mongo_db', array('activate' => 'arata'), 'aratadb');
    }
    public function dataSuperUser($id = null)
    {
        if ($id) {
            $dt = $this->aratadb->get_where('superuser', ['_id' => $id]);
        } else {
            $dt = $this->aratadb->order_by(['name' => 'ASC'])->get('superuser');
        }
        if (!$dt) {
            return [];
        } else {
            return $dt;
        }
    }
    public function addSuperUser($json)
    {
        $phone_number = nohp($json->phone_number);
        $created_at = $this->mongo_db->date();
        $data = [
            "_id"           => (string) new MongoDB\BSON\ObjectId(),
            "name"          => $json->name,
            "role"          => $json->role,
            "phone_number"  => $phone_number,
            "created_at"    => $created_at,
            "token"         => null,
            "token_exp"     => null
        ];
        $result = $this->mongo_db->insert('superuser', $data);
        if ($result) {
            $result += ['phone_number1' => $phone_number];
            $result += ['created_at1'   => datephp('d M y', $created_at)];
            $result += ['status'        => 'success'];
            $result += ['action'        => 'Add'];
            return $result;
        } else {
            $result = ['status' => 'failed'];
            $result = ['action' => 'Add'];
            return $result;
        }
    }
    public function editSuperUser($json)
    {
        $phone_number = nohp($json->phone_number);
        $params['_id'] = $json->_id;
        $update = [
            "name"          => $json->name,
            "role"          => $json->role,
            "phone_number"  => $phone_number
        ];
        $db = $this->mongo_db->where($params)->set($update)->update('superuser');
        if ($db->getModifiedCount() === 0) {
            $result = [
                'action' => 'Edit',
                'status' => 'failed',
                'name'   => $json->name
            ];
        } else {
            $result = [
                'action'       => 'Edit',
                'status'       => 'success',
                '_id'          => $json->_id,
                'name'         => $json->name,
                "role"         => $json->role,
                "phone_number" => $phone_number
            ];
        }
        return $result;
    }
    public function deleteSuperUser($id)
    {
        $params['_id'] = $id;
        $superuser = $this->mongo_db->where($params)->get('superuser');
        $db = $this->mongo_db->where($params)->delete('superuser');
        if ($db->getDeletedCount() === 0) {
            $result = [
                'status' => 'failed',
                'name'   => $superuser[0]['name'],
                'id'     => $id
            ];
        } else {
            $result = [
                'status' => 'success',
                'name'   => $superuser[0]['name'],
                'id'     => $id
            ];
        }
        return $result;
    }
    public function checkUser($phone_number, $data)
    {
        if ($data == 'superuser') {
            return $this->mongo_db->get_where('superuser', ['phone_number' => $phone_number]);
        } elseif ($data == 'telegram') {
            return $this->mongo_db->get_where('telegram', ['phone' => $phone_number]);
        } elseif ($data == 'pos') {
            return $this->mongo_db->get_where('posuser', ['phone' => $phone_number]);
        }
    }
    public function dataTelegram($array = null)
    {
        if ($array['_id']) {
            $params['_id'] = $array['_id'];
        }
        if ($array['id_telegram']) {
            $params['id_telegram'] = $array['id_telegram'];
        }
        if ($array['username']) {
            $params['username'] = $array['username'];
        }
        if ($array['is_active']) {
            $params['is_active'] = $array['is_active'];
        }
        $params['$nor'] = [['created_at' => null]];
        $dt = $this->mongo_db->order_by(['created_at' => 'DESC'])->where($params)->get('telegram');
        if (!$dt) {
            return [];
        } else {
            return $dt;
        }
    }
    public function addTelegram($array)
    {
        $id_telegram = is_array($array) ? $array['id_telegram'] : null;
        $username = is_array($array) ? $array['username'] : $array->username;
        $phone = is_array($array) ? null : $array->phone;
        $role = is_array($array) ? null : $array->role;
        $is_active = is_array($array) ? null : ($array->is_active === 'true' ? true : false);
        $data = [
            "_id"         => (string) new MongoDB\BSON\ObjectId(),
            "id_telegram" => $id_telegram,
            "username"    => $username,
            "phone"       => nohp($phone),
            "is_active"   => $is_active,
            "role"        => $role,
            "created_at"  => $this->mongo_db->date()
        ];
        $result = $this->mongo_db->insert('telegram', $data);
        if ($result) {
            $result += ['status' => 'success'];
            $result += ['action' => 'Add'];
            $result += ['role1' => implode(', ', $result['role'])];
            $result += ['is_active1' => check_boolean($result['is_active'])];
            $result += ['created_at1' => datephp('Ymd', $result['created_at'])];
            $result += ['created_at2' => datephp('d M y', $result['created_at'])];
        } else {
            $result = ['status' => 'failed'];
        }
        return $result;
    }
    public function editTelegram($json)
    {
        $params['_id'] = $json->_id;
        $is_active = $json->is_active === 'true' ? true : false;
        $data = [
            "username"  => $json->username,
            "phone"     => nohp($json->phone),
            "is_active" => $is_active,
            "role"      => $json->role
        ];
        $db = $this->mongo_db->where($params)->set($data)->update('telegram');
        $array['_id'] = $json->_id;
        $result = $this->dataTelegram($array);
        $result[0]['action'] = 'Edit';
        if ($db->getModifiedCount() === 0) {
            $result[0]['status'] = 'failed';
        } else {
            $result[0]['status'] = 'success';
        }
        return $result[0];
    }
    public function deleteTelegram($id)
    {
        $params['_id'] = $id;
        $telegram = $this->mongo_db->where($params)->get('telegram');
        $db = $this->mongo_db->where($params)->delete('telegram');
        $result = [
            'username' => $telegram[0]['username'],
            'id'       => $id
        ];
        if ($db->getDeletedCount() === 0) {
            $result['status'] = 'failed';
        } else {
            $result['status'] = 'success';
        }
        return $result;
    }
    public function dataPOS($id = null)
    {
        $params['$nor'] = [['_id' => null]];
        if ($id) {
            $params['_id'] = $id;
        }
        $pipeline = [
            ['$lookup' => [
                'from' => 'warehouse',
                'localField' => 'id_store',
                'foreignField' => '_id',
                'as' => 'data'
            ]],
            ['$match' => ['$and' => [$params]]],
            ['$project' => ['created_at' => ['$dateToString' => ['format' => '%d-%m-%Y', 'date' => '$created_at', 'timezone' => '+07:00']], 'name' => '$name', 'phone' => '$phone', 'role' => '$role', 'id_store' => '$id_store', 'store' => ['$arrayElemAt' => ['$data.name', 0]]]],
            ['$sort' => ['name' => 1]]
        ];
        $dt = $this->aratadb->aggregate('posuser', $pipeline);
        if (!$dt) {
            return [];
        } else {
            return $dt;
        }
    }
    public function addPOSUser($json)
    {
        $phone_number = nohp($json->phone_number);
        $created_at = $this->mongo_db->date();
        $data = [
            "_id"        => (string) new MongoDB\BSON\ObjectId(),
            "name"       => $json->name,
            "role"       => $json->role,
            "id_store"   => $json->id_store,
            "phone"      => $phone_number,
            "created_at" => $created_at,
            "token"      => null,
            "token_exp"  => null
        ];
        $result = $this->mongo_db->insert('posuser', $data);
        if ($result) {
            $result['phone'] = $phone_number;
            $result['created_at'] = datephp('d-m-Y', $created_at);
            $result += ['store'  => $json->store];
            $result += ['status' => 'success'];
            $result += ['action' => 'Add'];
            return $result;
        } else {
            $result = ['status' => 'failed'];
            $result = ['action' => 'Add'];
            return $result;
        }
    }
    public function editPOSUser($json)
    {
        $phone_number = nohp($json->phone_number);
        $params['_id'] = $json->_id;
        $update = [
            "name"     => $json->name,
            "role"     => $json->role,
            "id_store" => $json->id_store,
            "phone"    => $phone_number
        ];
        $db = $this->mongo_db->where($params)->set($update)->update('posuser');
        if ($db->getModifiedCount() === 0) {
            $result = [
                'action' => 'Edit',
                'status' => 'failed',
                'name'   => $json->name
            ];
        } else {
            $result = [
                'action' => 'Edit',
                'status' => 'success',
                '_id'    => $json->_id,
                'name'   => $json->name,
                "role"   => $json->role,
                "store"  => $json->store,
                "phone"  => $phone_number
            ];
        }
        return $result;
    }
    public function deletePOSUser($id)
    {
        $params['_id'] = $id;
        $posuser = $this->mongo_db->where($params)->get('posuser');
        $db = $this->mongo_db->where($params)->delete('posuser');
        if ($db->getDeletedCount() === 0) {
            $result = [
                'status' => 'failed',
                'name'   => $posuser[0]['name'],
                'id'     => $id
            ];
        } else {
            $result = [
                'status' => 'success',
                'name'   => $posuser[0]['name'],
                'id'     => $id
            ];
        }
        return $result;
    }
}
