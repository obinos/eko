<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Voucher extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Voucher_model');
        $this->lang->load('message', getenv("APP_BRAND"));
        is_logged_in();
        is_session_1jam();
    }
    public function index()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'Data Voucher - ' . $this->lang->line('copyright');
        $data['tipe'] = ['value', 'percent'];
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('voucher/index', $data);
        $this->load->view('templates/footer');
    }
    public function report()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'Data Voucher - ' . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('voucher/report', $data);
        $this->load->view('templates/footer');
    }
    public function view_voucher()
    {
        $voucher = $this->Voucher_model->viewVoucher($_POST['data']);
        $hp1 = $voucher[0]['hp'] ? implode(", ", $voucher[0]['hp']) : '';
        $limit1 = $voucher[0]['limit'] > 100000 ? 'unlimited' : $voucher[0]['limit'];
        $is_public1 = $voucher[0]['expired'] ? 'iya' : 'tidak';
        if ($voucher[0]['detail']) {
            foreach ($voucher[0]['detail'] as $k => $v) {
                $voucher[0] += [$v->status => $v->usage];
            }
        }
        $voucher[0] += ['expired1' => date('d-m-Y', $voucher[0]['expired'])];
        $voucher[0] += ['hp1' => $hp1];
        $voucher[0] += ['limit1' => $limit1];
        $voucher[0] += ['is_public1' => $is_public1];
        echo json_encode($voucher);
    }
    public function get_voucher()
    {
        $voucher = $this->Voucher_model->dataVoucher($_POST['data']);
        $voucher[0] += ['expired1' => date('d-m-Y', $voucher[0]['expired'])];
        echo json_encode($voucher);
    }
    public function get_order()
    {
        $json = json_decode($_POST['data']);
        $voucher = $this->Voucher_model->getVoucher($json);
        echo json_encode($voucher);
    }
    public function check_voucher()
    {
        $code = strtoupper(htmlspecialchars($_POST['code']));
        $result = $this->Voucher_model->checkVoucher($code);
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
    public function update_voucher()
    {
        $json = json_decode($_POST['data']);
        if ($json->_id) {
            $update = $this->Voucher_model->editVoucher($json);
        } else {
            $update = $this->Voucher_model->addVoucher($json);
        }
        echo json_encode($update);
    }
    function delete_voucher()
    {
        $update = $this->Voucher_model->deleteVoucher($_POST['data']);
        echo json_encode($update);
    }
    public function get_data()
    {
        $search = $_POST['search']['value'];
        $data['where_search'] = ['$or' => [
            ['code'       => new MongoDB\BSON\Regex($search, 'i')],
            ['usermaker'  => new MongoDB\BSON\Regex($search, 'i')],
            ['userupdate' => new MongoDB\BSON\Regex($search, 'i')],
            ['expired'    => new MongoDB\BSON\Regex($search, 'i')],
            ['updated_at' => new MongoDB\BSON\Regex($search, 'i')]
        ]];
        echo $this->Voucher_model->serverside($data);
    }
    public function get_data_report()
    {
        $search = $_POST['search']['value'];
        $data['where_search'] = ['$or' => [
            ['_id' => new MongoDB\BSON\Regex($search, 'i')]
        ]];
        echo $this->Voucher_model->serverside_report($data);
    }
    public function view_order($id)
    {
        $data['title'] = "Detail Transaksi - " . $this->lang->line('copyright');
        $this->load->model('order_model');
        $data['order'] = $this->order_model->view_order($id);
        $shipping = strpos($data['order'][0]['shipping'], 'Sidoarjo') !== false ? 'Sidoarjo' : $data['order'][0]['shipping'];
        $data['address'] = strpos(ucwords($data['order'][0]['customer']->address), $shipping) !== false ? $data['order'][0]['customer']->address : $data['order'][0]['customer']->address . ', ' . $shipping;
        $data['shipping_weight'] = $data['order'][0]['shipping_weight'] ? round($data['order'][0]['shipping_weight'] / 1000, 2) : 0;
        $data['delivery_time'] = $data['order'][0]['delivery_shift'] ? 'Dikirim: ' . datephp('d M y', $data['order'][0]['delivery_time']) . ', ' . ucwords($data['order'][0]['delivery_shift']) : 'Dikirim: ' . datephp('d M y', $data['order'][0]['delivery_time']);
        $data['status_order'] = status_order($data['order'][0]['status']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('payment/view', $data);
        $this->load->view('templates/footer');
    }
}
