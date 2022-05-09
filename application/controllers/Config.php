<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Config extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Config_model');
        $this->lang->load('message', getenv("APP_BRAND"));
        is_logged_in();
        is_session_1jam();
    }
    public function index()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'Data Super User - ' . $this->lang->line('copyright');
        $config = $this->Config_model->dataConfig();
        $result = [];
        foreach ($config as $val) {
            $result += [$val['_id'] => $val['val']];
        }
        $data['config'] = $result;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('settings/config/index', $data);
        $this->load->view('templates/footer');
    }
    public function edit_config()
    {
        $update = $this->Config_model->update_status($_POST['_id'], $_POST['val']);
        echo json_encode($update);
    }
    public function update_config()
    {
        $json = json_decode($_POST['data']);
        $update = $this->Config_model->editConfig($json);
        echo json_encode($update);
    }
}
