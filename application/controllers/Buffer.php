<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Buffer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Stock_model');
        $this->lang->load('message', getenv("APP_BRAND"));
        is_logged_in();
        is_session_1jam();
    }
    public function index()
    {
        $data['title'] = 'Data Buffer Stock - ' . $this->lang->line('copyright');
        $data['stock'] = $this->Stock_model->dataBufferStock();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('buffer/index', $data);
        $this->load->view('templates/footer');
    }
}
