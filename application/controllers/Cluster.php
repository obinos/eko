<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cluster extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Cluster_model');
        $this->lang->load('message', getenv("APP_BRAND"));
        is_logged_in();
        is_session_1jam();
    }
    public function index()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'Data Cluster - ' . $this->lang->line('copyright');
        $data['cluster'] = $this->Cluster_model->dataCluster();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('settings/cluster/index', $data);
        $this->load->view('templates/footer');
    }
    public function check_cluster()
    {
        $name = ucwords(strtolower(htmlspecialchars($_POST['name'])));
        $result = $this->Cluster_model->checkCluster($name);
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
    public function update_cluster()
    {
        $json = json_decode($_POST['data']);
        if ($json->_id) {
            $update = $this->Cluster_model->editCluster($json);
        } else {
            $update = $this->Cluster_model->addCluster($json);
        }
        echo json_encode($update);
    }
    function delete_cluster()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $update = $this->Cluster_model->deleteCluster($_POST['data']);
        echo json_encode($update);
    }
}
