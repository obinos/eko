<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Supplier_model');
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
        $data['title'] = 'Data Supplier - ' . $this->lang->line('copyright');
        $data['supplier'] = $this->Supplier_model->dataSupplier();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('settings/supplier/index', $data);
        $this->load->view('templates/footer');
    }
    public function check_supplier()
    {
        $name = ucwords(strtolower(htmlspecialchars($_POST['name'])));
        $result = $this->Supplier_model->checkSupplier($name);
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
    public function update_supplier()
    {
        $json = json_decode($_POST['data']);
        if ($json->_id) {
            $update = $this->Supplier_model->editSupplier($json);
        } else {
            $update = $this->Supplier_model->addSupplier($json);
        }
        echo json_encode($update);
    }
    function delete_supplier()
    {
        $update = $this->Supplier_model->deleteSupplier($_POST['data']);
        echo json_encode($update);
    }
}
