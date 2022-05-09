<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Message extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Message_model');
        $this->lang->load('message', getenv("APP_BRAND"));
        is_logged_in();
        is_session_1jam();
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
    }
    public function whatsapp()
    {
        $data['title'] = 'Template Message Whatsapp - ' . $this->lang->line('copyright');
        $array['app'] = 'whatsapp';
        $data['message'] = $this->Message_model->dataMessage($array);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('message/whatsapp/index', $data);
        $this->load->view('templates/footer');
    }
    public function add_whatsapp()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'Tambah Data Whatsapp - ' . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('message/whatsapp/add', $data);
        $this->load->view('templates/footer');
    }
    public function telegram()
    {
        $data['title'] = 'Template Message Telegram - ' . $this->lang->line('copyright');
        $array['app'] = 'telegram';
        $data['message'] = $this->Message_model->dataMessage($array);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('message/telegram/index', $data);
        $this->load->view('templates/footer');
    }
    public function add_telegram()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'Tambah Data Telegram - ' . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('message/telegram/add', $data);
        $this->load->view('templates/footer');
    }
    public function check_message($app)
    {
        $code = preg_replace('/\s/', '', $_POST['code']);
        $result = $this->Message_model->checkMessage($code, $app);
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
    public function get_message()
    {
        $array['_id'] = $_POST['data'];
        $item = $this->Message_model->dataMessage($array);
        echo json_encode($item);
    }
    public function update_message()
    {
        $json = json_decode($_POST['data']);
        if ($json->_id) {
            $update = $this->Message_model->updateMessage($json);
        } else {
            $update = $this->Message_model->addMessage($json);
        }
        echo json_encode($update);
    }
    function delete_message()
    {
        $update = $this->Message_model->deleteMessage($_POST['data']);
        echo json_encode($update);
    }
}
