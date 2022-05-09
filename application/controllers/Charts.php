<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Charts extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('message', getenv("APP_BRAND"));
        is_logged_in();
        is_session_1jam();
    }
    public function index()
    {
        $data['title'] = 'Data Supplier - ' . $this->lang->line('copyright');
        $data['data_chart'] = $this->datachart();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('charts/index', $data);
        $this->load->view('templates/footer');
    }
    public function datachart()
    {
        $array['start'] = date('Y-m-d', strtotime('today - 30 days'));
        $array['end'] = date('Y-m-d');
        $this->load->model('order_model');
        $order = $this->order_model->chart_sum_order($array);
        $data1 = 'Date;Omset;Order';
        $data2 = 'Date;Avg Basket Size;New Customer';
        foreach ($order as $row) {
            $avgbasketsize = ceil($row['omset'] / $row['order']);
            $data1 = $data1 . '\n' . $row['_id'] . ';' . $row['omset'] . ';' . $row['order'];
            $data2 = $data2 . '\n' . $row['_id'] . ';' . $avgbasketsize . ';' . $row['new_customer'];
        }
        $result['data1'] = $data1;
        $result['data2'] = $data2;
        return $result;
    }
}
