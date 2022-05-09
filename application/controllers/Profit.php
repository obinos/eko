<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Profit_model');
        $this->lang->load('message', getenv("APP_BRAND"));
        is_logged_in();
        is_session_1jam();
    }
    public function index()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'List Profit - ' . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('profit/index', $data);
        $this->load->view('templates/footer');
    }
    public function get_data()
    {
        $search = $_POST['search']['value'];
        $data['where_search'] = ['$or' => [
            ['totalprice' => new MongoDB\BSON\Regex($search, 'i')],
            ['totalhpp'   => new MongoDB\BSON\Regex($search, 'i')],
            ['profit'     => new MongoDB\BSON\Regex($search, 'i')]
        ]];
        echo $this->Profit_model->serverside($data);
    }
    public function get_profit()
    {
        $stock = $this->Profit_model->getProfit();
        echo json_encode($stock);
    }
}
