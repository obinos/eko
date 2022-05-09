<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Customer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model');
        $this->lang->load('message', getenv("APP_BRAND"));
        is_logged_in();
        is_session_1jam();
    }
    public function list()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'List Customers - ' . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('customer/list', $data);
        $this->load->view('templates/footer');
    }
    public function address()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'Address Customers - ' . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('customer/address', $data);
        $this->load->view('templates/footer');
    }
    public function order()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'List Customers - ' . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('customer/order', $data);
        $this->load->view('templates/footer');
    }
    public function add()
    {
        $data['title'] = 'Add Customer - ' . $this->lang->line('copyright');
        $this->load->model('Cluster_model');
        $data['cluster'] = $this->Cluster_model->dataCluster();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('customer/add', $data);
        $this->load->view('templates/footer');
    }
    public function edit($id)
    {
        $data['title'] = 'Edit Customer - ' . $this->lang->line('copyright');
        $data['customer'] = $this->Customer_model->dataCustomer($id);
        $this->load->model('Cluster_model');
        $data['cluster'] = $this->Cluster_model->dataCluster();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('customer/edit', $data);
        $this->load->view('templates/footer');
    }
    public function check_customer($id)
    {
        $phone = nohpplus($_POST['phone']);
        $result = $this->Customer_model->checkCustomer($phone);
        if ($result) {
            if ($result[0]['_id'] == $id) {
                echo 'true';
            } else {
                echo 'false';
            }
        } else {
            echo 'true';
        }
    }
    public function update_customer()
    {
        $json = json_decode($_POST['data']);
        if ($json->_id) {
            $result = $this->Customer_model->editCustomer($json);
        } else {
            $result = $this->Customer_model->addCustomer($json);
        }
        echo json_encode($result);
    }
    function delete_customer()
    {
        $update = $this->Customer_model->deleteCustomer($_POST['data']);
        echo json_encode($update);
    }
    public function view($id)
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'Detail Customers - ' . $this->lang->line('copyright');
        $data['customer'] = $this->Customer_model->dataCustomer($id);
        $this->load->model('Cluster_model');
        $cluster = $this->Cluster_model->dataCluster();
        $shipping_address = json_decode(json_encode($data['customer'][0]['shipping_address']), true);
        foreach ($shipping_address as $val) {
            $key = array_search($val['id_cluster'], array_column($cluster, "_id"));
            if ($key !== false) {
                $val['cluster'] = $cluster[$key]['name'];
            } else {
                $val['cluster'] = null;
            }
            $data['shipping_address'][] = $val;
        }
        $order = $this->aratadb->order_by(['delivery_time' => 'DESC'])->where(['merchant' => '606eba1c099777608a38aeda', 'customer.phone' => $data['customer'][0]['phone']])->get('orders');
        if ($order) {
            foreach ($order as $ord) {
                $res = ($key == 'open') ? "1Baru" : (($key == 'onprocess')  ? "2Proses" : (($key == 'closed')  ? "3Selesai" : "4Batal"));
                $dataorder['transaction_date'] = datephp('d M y', $ord['transaction_date']);
                $dataorder['transaction_date_number'] = datephp('Ymd', $ord['transaction_date']);
                $dataorder['delivery_time'] = datephp('d M y', $ord['delivery_time']);
                $dataorder['delivery_time_number'] = datephp('Ymd', $ord['delivery_time']);
                $dataorder['invno'] = $ord['invno'];
                $dataorder['invno_link'] = base_url('payment/view_payment/' . $ord['_id']);
                $dataorder['voucher'] = $ord['voucher'];
                $dataorder['total'] = thousand($ord['price']->total);
                $dataorder['status'] = $ord['status'];
                $dataorder['bg'] = ($ord['status'] == 'open') ? "bg-success" : (($ord['status'] == 'onprocess')  ? "bg-warning" : (($ord['status'] == 'closed')  ? "bg-primary" : "bg-danger"));
                $dataorder['res'] = ($ord['status'] == 'open') ? "Baru" : (($ord['status'] == 'onprocess')  ? "Proses" : (($ord['status'] == 'closed')  ? "Selesai" : "Batal"));
                $data['order'][$ord['status']][] = $dataorder;
                if ($ord['voucher'] && $ord['status'] != 'canceled') {
                    $data['voucher'][] = $ord['voucher'];
                }
            }
            krsort($data['order']);
            foreach ($data['order'] as $key => $stat) {
                $res = ($key == 'open') ? "Baru" : (($key == 'onprocess')  ? "Proses" : (($key == 'closed')  ? "Selesai" : "Batal"));
                $data['status'][] = $res;
            }
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('customer/view', $data);
        $this->load->view('templates/footer');
    }
    public function get_data()
    {
        $search = $_POST['search']['value'];
        $data['where_search'] = ['$or' => [
            ['name'  => new MongoDB\BSON\Regex($search, 'i')],
            ['phone' => new MongoDB\BSON\Regex($search, 'i')]
        ]];
        echo $this->Customer_model->serverside($data);
    }
    public function get_data2()
    {
        $search = $_POST['search']['value'];
        $data['where_search'] = ['$or' => [
            ['name'    => new MongoDB\BSON\Regex($search, 'i')],
            ['phone'   => new MongoDB\BSON\Regex($search, 'i')]
        ]];
        echo $this->Customer_model->serverside2($data);
    }
    public function get_data3()
    {
        $search = $_POST['search']['value'];
        $data['where_search'] = ['$or' => [
            ['name'    => new MongoDB\BSON\Regex($search, 'i')],
            ['address' => new MongoDB\BSON\Regex($search, 'i')],
            ['phone'   => new MongoDB\BSON\Regex($search, 'i')]
        ]];
        echo $this->Customer_model->serverside3($data);
    }
    public function group()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'Group Customers - ' . $this->lang->line('copyright');
        $data['customer'] = $this->Customer_model->groupCustomer();
        $data['total'] = array_sum(array_column($data['customer'], 'count'));
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('customer/group', $data);
        $this->load->view('templates/footer');
    }
    public function grouplist($circle)
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'List Customers - ' . $this->lang->line('copyright');
        $params['code'] = 'grouplist';
        $params['app'] = 'whatsapp';
        $message = $this->mongo_db->where($params)->get('message');
        $data['message'] = $message[0]['message'];
        $data['circle'] = $circle;
        $data['customer'] = $this->Customer_model->groupCustomer($circle);
        $keys = array_column($data['customer']['data'], 'last');
        array_multisort($keys, SORT_DESC, $data['customer']['data']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('customer/grouplist', $data);
        $this->load->view('templates/footer');
    }
    public function export_excel($circle)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'First Order');
        $sheet->setCellValue('B1', 'Last Order');
        $sheet->setCellValue('C1', 'Nama');
        $sheet->setCellValue('D1', 'Phone');
        $sheet->setCellValue('E1', 'Order');
        $sheet->setCellValue('F1', 'Nominal');
        $customer = $this->Customer_model->groupCustomer($circle);
        $keys = array_column($customer['data'], 'last');
        array_multisort($keys, SORT_DESC, $customer['data']);
        $x = 2;
        foreach ($customer['data'] as $data) {
            $sheet->setCellValue('A' . $x, substr($data['first'], 9));
            $sheet->setCellValue('B' . $x, substr($data['last'], 9));
            $sheet->setCellValue('C' . $x, $data['name']);
            $sheet->setCellValue('D' . $x, nohp($data['_id']));
            $sheet->setCellValue('E' . $x, $data['order']);
            $sheet->setCellValue('F' . $x, $data['total']);
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'List Customer ' . $circle . '-' . date("dmy H.i.s");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
