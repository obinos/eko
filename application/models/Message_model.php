<?php

class Message_model extends CI_Model
{
    public function dataMessage($array = null)
    {
        if ($array['_id']) {
            $params['_id'] = $array['_id'];
        }
        if ($array['app']) {
            $params['app'] = $array['app'];
        }
        if ($array['code']) {
            $params['code'] = $array['code'];
        }
        if ($array['desc'] == 'true') {
            $params['$nor'] = [['desc' => null], ['desc' => ""], ['desc' => " "]];
        } elseif ($array['desc'] == 'false') {
            $params['$or'] = [['desc' => null], ['desc' => ""], ['desc' => " "]];
        }
        $dt = $this->mongo_db->order_by(['code' => 'ASC'])->where($params)->get('message');
        if (!$dt) {
            return [];
        } else {
            return $dt;
        }
    }
    public function editMessage()
    {
        $otp = htmlspecialchars($this->input->get_post('otp', true));
        if ($otp) {
            $this->mongo_db->set(["otp" => $otp])->update('message');
        }
    }
    public function checkMessage($code, $app)
    {
        return $this->mongo_db->get_where('message', ['code' => $code, 'app' => $app]);
    }
    public function addMessage($json)
    {
        $code = preg_replace('/\s/', '', $json->code);
        $params['code'] = $code;
        $params['app'] = $json->app;
        $message = $this->mongo_db->where($params)->get('message');
        if ($message) {
            $result = ['status' => 'failed'];
            return $result;
        } else {
            $validation = $json->validation === 'true' ? true : false;
            $data = [
                "_id"        => (string) new MongoDB\BSON\ObjectId(),
                "code"       => $code,
                "desc"       => $json->desc,
                "message"    => $json->message,
                "validation" => $validation,
                "app"        => $json->app
            ];
            $result = $this->mongo_db->insert('message', $data);
            if ($result) {
                $result += ['status' => 'success'];
                return $result;
            } else {
                $result = ['status' => 'failed'];
                return $result;
            }
        }
    }
    public function updateMessage($json)
    {
        $params['_id'] = $json->_id;
        $validation = $json->validation === 'true' ? true : false;
        $data = [
            "code"       => $json->code,
            "desc"       => $json->desc,
            "message"    => $json->message,
            "validation" => $validation,
            "app"        => $json->app
        ];
        $db = $this->mongo_db->where($params)->set($data)->update('message');
        $array['_id'] = $json->_id;
        $result = $this->dataMessage($array);
        if ($db->getModifiedCount() === 0) {
            $result[0]['status'] = 'failed';
        } else {
            $result[0]['status'] = 'success';
        }
        return $result[0];
    }
    public function deleteMessage($id)
    {
        $params['_id'] = $id;
        $message = $this->mongo_db->where($params)->get('message');
        $db = $this->mongo_db->where($params)->delete('message');
        $result = [
            'code'   => $message[0]['code'],
            'id'     => $id
        ];
        if ($db->getDeletedCount() === 0) {
            $result['status'] = 'failed';
        } else {
            $result['status'] = 'success';
        }
        return $result;
    }
}
