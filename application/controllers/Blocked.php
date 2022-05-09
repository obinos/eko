<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Blocked extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        is_session_1jam();
        $this->lang->load('message', getenv("APP_BRAND"));
    }
    public function index()
    {
        $data['title'] = 'Blocked - ' . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('blocked/index');
        $this->load->view('templates/footer');
    }
}
