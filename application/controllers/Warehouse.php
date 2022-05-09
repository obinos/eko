<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Warehouse extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Warehouse_model');
        $this->lang->load('message', getenv("APP_BRAND"));
        is_logged_in();
        is_session_1jam();
        $this->role = ['viewer', 'admin', 'finance', 'sales'];
    }
    public function index()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'Data Warehouse - ' . $this->lang->line('copyright');
        $data['warehouse'] = $this->Warehouse_model->dataWarehouse();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('settings/warehouse/index', $data);
        $this->load->view('templates/footer');
    }
    public function get_warehouse()
    {
        $warehouse = $this->Warehouse_model->dataWarehouse($_POST['data']);
        echo json_encode($warehouse);
    }
    public function check_warehouse()
    {
        $name = ucwords(strtolower(htmlspecialchars($_POST['name'])));
        $result = $this->Warehouse_model->checkWarehouse($name);
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
    public function update_warehouse()
    {
        $json = json_decode($_POST['data']);
        if ($json->_id) {
            $update = $this->Warehouse_model->editWarehouse($json);
        } else {
            $update = $this->Warehouse_model->addWarehouse($json);
        }
        echo json_encode($update);
    }
    function delete_warehouse()
    {
        $update = $this->Warehouse_model->deleteWarehouse($_POST['data']);
        echo json_encode($update);
    }
}
