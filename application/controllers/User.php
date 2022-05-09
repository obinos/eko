<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->lang->load('message', getenv("APP_BRAND"));
        $this->role = ['viewer', 'admin', 'finance', 'sales'];
    }
    public function superuser()
    {
        is_logged_in();
        is_session_1jam();
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'Data Super User - ' . $this->lang->line('copyright');
        $data['user'] = $this->User_model->dataSuperUser();
        $data['role'] = $this->role;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('user/superuser/index', $data);
        $this->load->view('templates/footer');
    }
    public function get_superuser()
    {
        is_logged_in();
        is_session_1jam();
        $superuser = $this->User_model->dataSuperUser($_POST['data']);
        echo json_encode($superuser);
    }
    public function update_superuser()
    {
        is_logged_in();
        is_session_1jam();
        $json = json_decode($_POST['data']);
        if ($json->_id) {
            $update = $this->User_model->editSuperUser($json);
        } else {
            $update = $this->User_model->addSuperUser($json);
        }
        echo json_encode($update);
    }
    function delete_superuser()
    {
        is_logged_in();
        is_session_1jam();
        $update = $this->User_model->deleteSuperUser($_POST['data']);
        echo json_encode($update);
    }
    public function check_user($data)
    {
        is_logged_in();
        is_session_1jam();
        $phone = $_POST['phone_number'] ? $_POST['phone_number'] : $_POST['phone'];
        $phone_number = nohp($phone);
        $result = $this->User_model->checkUser($phone_number, $data);
        if ($result) {
            if ($result[0]['_id'] == $_POST['id']) {
                echo 'true';
            } else {
                echo 'false';
            }
        } else {
            echo 'true';
        }
    }
    public function broadcast()
    {
        is_logged_in();
        is_session_1jam();
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'Data Broadcast - ' . $this->lang->line('copyright');
        $data['telegram'] = $this->User_model->dataTelegram();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('user/telegram/index', $data);
        $this->load->view('templates/footer');
    }
    public function get_telegram()
    {
        is_logged_in();
        is_session_1jam();
        if ($_POST['data']) {
            $array['_id'] = $_POST['data'];
            $result['user'] = $this->User_model->dataTelegram($array);
        }
        $params['app'] = 'telegram';
        $params['$or'] = [['desc' => null], ['desc' => ""], ['desc' => " "]];
        $code = $this->mongo_db->select('code')->order_by(['code' => 'ASC'])->where($params)->get('message');
        foreach ($code as $val) {
            $data['label'] = $val['code'];
            $data['value'] = $val['code'];
            $result['code'][] = $data;
        }
        echo json_encode($result);
    }
    public function update_telegram()
    {
        is_logged_in();
        is_session_1jam();
        $json = json_decode($_POST['data']);
        if ($json->_id) {
            $update = $this->User_model->editTelegram($json);
        } else {
            $update = $this->User_model->addTelegram($json);
        }
        echo json_encode($update);
    }
    function delete_telegram()
    {
        is_logged_in();
        is_session_1jam();
        $update = $this->User_model->deleteTelegram($_POST['data']);
        echo json_encode($update);
    }
    public function webhook()
    {
        $update = file_get_contents('php://input');
        $update = json_decode($update, TRUE);
        $data['id_telegram'] = $update['message']['from']['id'];
        $data['username'] = $update['message']['from']['username'];
        $data['text'] = $update['message']['text'];
        $this->checkid($data);
        $message = $this->checktext($data);
        $this->sendmsg($data['id_telegram'], $message);
    }
    private function sendmsg($id, $text)
    {
        $url = getenv("URL_TELEGRAM") . '/sendMessage?chat_id=' . $id . '&text=' . urlencode($text);
        file_get_contents($url);
    }
    private function checktext($data)
    {
        $this->load->model('Message_model');
        if ($data['text'] !== '/start' && $data['text'] !== '/help') {
            $array['code'] = $data['text'];
        }
        $array['app'] = 'telegram';
        $message = $this->Message_model->dataMessage($array);
        $params['app'] = 'telegram';
        $params['desc'] = 'false';
        $private_message = $this->Message_model->dataMessage($params);
        $params['desc'] = 'true';
        $public_message = $this->Message_model->dataMessage($params);
        if ($message) {
            if ($message[0]['validation'] === true) {
                $active = $this->checkactive($data['id_telegram']);
                if ($active) {
                    return $message[0]['message'];
                } else {
                    $key = array_search('inactive', array_column($private_message, "code"));
                    return $private_message[$key]['message'];
                }
            } else {
                if ($data['text'] == '/start' || $data['text'] == '/help') {
                    $key = array_search('greeting', array_column($private_message, "code"));
                    $all[] = str_replace('$username', $data['username'], $private_message[$key]['message']);
                    foreach ($public_message as $val) {
                        $all[] = $val['code'] . ' - ' . $val['desc'];
                    }
                    return implode("\n", $all);
                } else {
                    return $message[0]['message'];
                }
            }
        } else {
            $key = array_search('notfound', array_column($private_message, "code"));
            return $private_message[$key]['message'];
        }
    }
    private function checkid($data)
    {
        $array['id_telegram'] = $data['id_telegram'];
        $user = $this->User_model->dataTelegram($array);
        if (!$user) {
            $array['username'] = $data['username'];
            $user = $this->User_model->addTelegram($array);
        }
        return $user;
    }
    private function checkactive($id_telegram)
    {
        $array['id_telegram'] = $id_telegram;
        $array['is_active'] = true;
        $user = $this->User_model->dataTelegram($array);
        return $user;
    }
    public function pos()
    {
        is_logged_in();
        is_session_1jam();
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'Data POS - ' . $this->lang->line('copyright');
        $params['$nor'] = [['_id' => '60fbe096ba0f658aaccc0340']];
        $data['store'] = $this->aratadb->where($params)->get('warehouse');
        $data['pos'] = $this->User_model->dataPOS();
        $data['role'] = ['cashier', 'spv'];
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('user/pos/index', $data);
        $this->load->view('templates/footer');
    }
    public function get_posuser()
    {
        is_logged_in();
        is_session_1jam();
        $posuser = $this->User_model->dataPOS($_POST['data']);
        echo json_encode($posuser);
    }
    public function update_posuser()
    {
        is_logged_in();
        is_session_1jam();
        $json = json_decode($_POST['data']);
        if ($json->_id) {
            $update = $this->User_model->editPOSUser($json);
        } else {
            $update = $this->User_model->addPOSUser($json);
        }
        echo json_encode($update);
    }
    function delete_posuser()
    {
        is_logged_in();
        is_session_1jam();
        $update = $this->User_model->deletePOSUser($_POST['data']);
        echo json_encode($update);
    }
}
