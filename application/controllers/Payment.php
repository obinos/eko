<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Payment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Payment_model');
        $this->load->model('order_model');
        $this->lang->load('message', getenv("APP_BRAND"));
    }
    public function list()
    {
        if ($this->session->userdata('role') == 'viewer') {
            redirect('blocked');
        }
        if ($_POST) {
            $data['filter_date'] = $this->input->post('filter_date');
        } elseif ($_GET) {
            $data['filter_date'] = $this->input->get('filter_date');
        } else {
            $data['filter_date'] = date("Y-m-d", strtotime('tomorrow'));
        }
        $data['recap'] = $this->order_model->all_order_delivery($data['filter_date'], $data['filter_date'], 'closed');
        $data['title'] = 'Data Payment Arata - ' . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('payment/list', $data);
        $this->load->view('templates/footer');
    }
    public function view_payment($id)
    {
        $data['title'] = "Detail Transaksi - " . $this->lang->line('copyright');
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
    public function date()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        if ($_POST) {
            $data['filter_start'] = $this->input->post('filter_start');
            $data['filter_end'] = $this->input->post('filter_end');
            $data['filter_payment'] = $this->input->post('filter_payment');
        } elseif ($_GET) {
            $data['filter_start'] = $this->input->post('filter_start');
            $data['filter_end'] = $this->input->post('filter_end');
            $data['filter_payment'] = $this->input->get('filter_payment');
        }
        $data['title'] = 'List Payment - ' . $this->lang->line('copyright');
        $data['payment'] = payment_method();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('payment/date', $data);
        $this->load->view('templates/footer');
    }
    public function index()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'List Payment - ' . $this->lang->line('copyright');
        $data['payment'] = $this->Payment_model->dataPayment();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('payment/index', $data);
        $this->load->view('templates/footer');
    }
    public function check_payment()
    {
        $accountno = $_POST['accountno'];
        $result = $this->Payment_model->checkPayment($accountno);
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
    public function get_payment()
    {
        $payment = $this->Payment_model->dataPayment($_POST['data']);
        echo json_encode($payment);
    }
    public function update_payment()
    {
        $json = json_decode($_POST['data']);
        if ($json->_id) {
            $update = $this->Payment_model->editPayment($json);
        } else {
            $update = $this->Payment_model->addPayment($json);
        }
        echo json_encode($update);
    }
    function delete_payment()
    {
        $update = $this->Payment_model->deletePayment($_POST['data']);
        echo json_encode($update);
    }
    public function get_data()
    {
        $data['start'] = $this->input->get_post('start');
        $data['end'] = $this->input->get_post('end');
        $data['payment'] = $this->input->get_post('payment');
        $search = $_POST['search']['value'];
        $data['where_search'] = ['$or' => [
            ['transaction_date' => new MongoDB\BSON\Regex($search, 'i')],
            ['delivery_time'    => new MongoDB\BSON\Regex($search, 'i')],
            ['customer'         => new MongoDB\BSON\Regex($search, 'i')],
            ['status'           => new MongoDB\BSON\Regex($search, 'i')],
            ['paid_at'          => new MongoDB\BSON\Regex($search, 'i')],
            ['payment_amount'   => new MongoDB\BSON\Regex($search, 'i')],
            ['total'            => new MongoDB\BSON\Regex($search, 'i')],
            ['invno'            => new MongoDB\BSON\Regex($search, 'i')]
        ]];
        echo $this->Payment_model->serverside($data);
    }
}
