<?php
class Auth_model extends CI_Model
{
    public function login($json)
    {
        $phone_number = nohp($json->phone_number);
        $user = $this->mongo_db->get_where('superuser', ['phone_number' => $phone_number]);
        if ($user) {
            if ($user[0]['pin']) {
                $this->session->set_userdata('otp_phone', $phone_number);
                $result['status'] = 'success';
                $result['pin'] = 'true';
                $result['redirect'] = 'auth/pin';
                return $result;
            } else {
                $status = send_otp($phone_number);
                if ($status == 'ok') {
                    $this->session->set_userdata('otp_phone', $phone_number);
                    $result['status'] = 'success';
                    $result['otp'] = 'true';
                    $result['redirect'] = 'auth/otp';
                    return $result;
                } else {
                    $result['status'] = 'failed';
                    $result['otp'] = 'true';
                    return $result;
                }
            }
        } else {
            $result['status'] = 'failed';
            return $result;
        }
    }
    public function verifyOTP($json)
    {
        $user = $this->mongo_db->get_where('superuser', ['token' => $json->otp]);
        if ($user) {
            if (time() - $user[0]['token_exp'] < 120) {
                delete_token($json->otp);
                $result['status'] = 'success';
                $result['redirect'] = 'auth/setpin';
                return $result;
            } else {
                $result['status'] = 'failed';
                $result['otp'] = 'true';
                return $result;
            }
        } else {
            $result['status'] = 'failed';
            return $result;
        }
    }
    public function setPIN($json)
    {
        $this->mongo_db->where(['phone_number' => $this->session->userdata('otp_phone')])->set(['pin' => password_hash($json->pin, PASSWORD_DEFAULT)])->update('superuser');
        $user = $this->mongo_db->get_where('superuser', ['phone_number' => $this->session->userdata('otp_phone')]);
        $data = [
            "id"        => $user[0]['_id'],
            "name"      => $user[0]['name'],
            "role"      => $user[0]['role']
        ];
        $this->session->set_userdata($data);
        $this->session->unset_userdata('otp_phone');
        $result['status'] = 'success';
        if (getenv("CHANNEL") == 'localhost') {
            $result['redirect'] = 'thermal';
        } else {
            $result['redirect'] = 'order?id=' . base64_encode($user[0]['name']);
        }
        return $result;
    }
    public function verifyPIN($json)
    {
        $user = $this->mongo_db->get_where('superuser', ['phone_number' => $this->session->userdata('otp_phone')]);
        if ($user) {
            if (password_verify($json->pin, $user[0]['pin'])) {
                $this->session->unset_userdata('otp_phone');
                $data = [
                    "id"    => $user[0]['_id'],
                    "name"  => $user[0]['name'],
                    "role"  => $user[0]['role'],
                    "phone" => $user[0]['phone_number']
                ];
                $this->session->set_userdata($data);
                $result['status'] = 'success';
                if (getenv("CHANNEL") == 'localhost') {
                    $result['redirect'] = 'thermal';
                } else {
                    $result['redirect'] = 'order?id=' . base64_encode($user[0]['name']);
                }
                return $result;
            } else {
                $result['status'] = 'failed';
                $result['pin'] = 'true';
                return $result;
            }
        } else {
            $result['status'] = 'failed';
            return $result;
        }
    }
    public function changeOTP()
    {
        $status = send_otp($this->session->userdata('otp_phone'));
        if ($status == 'ok') {
            $result['status'] = 'success';
            return $result;
        } else {
            $result['status'] = 'failed';
            return $result;
        }
    }
}
