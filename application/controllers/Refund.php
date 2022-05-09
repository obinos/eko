<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Refund extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('message', getenv("APP_BRAND"));
        $this->load->model('order_model');
        is_logged_in();
        is_session_1jam();
    }
    public function input()
    {
        if ($_POST) {
            $data['filter_start'] = $this->input->post('filter_start');
            $data['filter_end'] = $this->input->post('filter_end');
            $data['filter_payment'] = $this->input->post('filter_payment');
        } else {
            $data['filter_start'] = date('d-m-Y', strtotime("6 days ago"));
            $data['filter_end'] = date('d-m-Y', strtotime("now"));
            $data['filter_payment'] = null;
        }
        $data['title'] = "Data Order Terkirim - " . $this->lang->line('copyright');
        $data['payment'] = ['BCA', 'Mandiri', 'OVO', 'GOPAY', 'SHOPEEPAY', 'QRIS', 'CREDITCARD', 'COD'];
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('refund/input', $data);
        $this->load->view('templates/footer');
    }
    public function list()
    {
        $data['title'] = "Data Semua Refund - " . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('refund/list', $data);
        $this->load->view('templates/footer');
    }
    public function update_refund()
    {
        $json = json_decode($_POST['data']);
        $update = $this->order_model->inputRefund($json);
        echo json_encode($update);
    }
    public function get_order()
    {
        $params['_id'] = $_POST['data'];
        $order = $this->mongo_db->where($params)->get('orders');
        $shipping = strpos($order[0]['shipping'], 'Sidoarjo') !== false ? 'Sidoarjo' : $order[0]['shipping'];
        $order[0]['address'] = strpos(ucwords($order[0]['customer']->address), $shipping) !== false ? $order[0]['customer']->address : $order[0]['customer']->address . ', ' . $shipping;
        $order[0]['tgl_trx'] = datephp('d-m-Y H:i', $order[0]['transaction_date']);
        $delivery_shift = $order[0]['delivery_shift'] ? ', ' . ucwords($order[0]['delivery_shift']) : null;
        $order[0]['tgl_krm'] = 'Dikirim: ' . datephp('d M y', $order[0]['delivery_time']) . $delivery_shift;
        $order[0]['payment_nominal'] = payment_string($order[0]['payment'], 'nominal');
        $order[0]['refundpaid'] = $order[0]['refund']->refund_paid === true ? 'true' : 'false';
        echo json_encode($order[0]);
    }
    public function update_order()
    {
        $json = json_decode($_POST['data']);
        if ($json->refund_voucher) {
            $this->load->model('Voucher_model');
            $vou = new stdClass;
            $params['code'] = $json->refund_voucher;
            $voucher = $this->aratadb->where($params)->get('voucher');
            $vou->code = $json->refund_voucher;
            $vou->expired = date('y-m-d', strtotime('+30 days'));
            $vou->min_order = 0;
            $vou->limit = 1;
            $vou->max_usage = 1;
            $vou->type = 'value';
            $vou->nominal = $json->refund_price;
            $vou->hp = array($json->phone);
            if ($voucher) {
                $vou->_id = $voucher[0]['_id'];
                $this->Voucher_model->editVoucher($vou);
            } else {
                $this->Voucher_model->addVoucher($vou);
            }
        }
        $update = $this->order_model->inputRefund($json);
        if ($update['refund_paid'] === true) {
            $params['code'] = 'refund';
            $params['app'] = 'whatsapp';
            $message = $this->mongo_db->where($params)->get('message');
            $nominal = "Nominal: Rp. " . thousand($update['refund_price']) . "\n";
            $status = "Status: Refund Sukses";
            if ($update['refund_method'] == 'transfer') {
                $bukti = null;
                $no = 1;
                if ($update['file']) {
                    foreach ($update['file'] as $file) {
                        $bukti = $bukti . $no++ . ". " . getenv("UPLOAD_URL_REFUND") . rawurlencode($file) . "\n";
                    }
                }
                $img = $bukti ? "Bukti Transfer: \n" . $bukti : null;
            } else {
                $img = "Kode Voucher: " . $json->refund_voucher . "\n";
            }
            $text = $nominal . $img . $status;
            $refund = str_replace('$data', $text, $message[0]['message']);
            wablas($this->session->userdata('phone'), $refund);
            wablas(nohp($update['phone']), $refund);
        }
        echo json_encode($update);
    }
    public function sendwa()
    {
        $params['_id'] = $_POST['data'];
        $order = $this->mongo_db->where($params)->get('orders');
        if ($order[0]['refund']) {
            $params2['code'] = 'refund';
            $params2['app'] = 'whatsapp';
            $message = $this->mongo_db->where($params2)->get('message');
            if ($order[0]['refund']->refund_method == 'transfer') {
                $nominal = "Nominal: Rp. " . thousand($order[0]['refund']->refund_price) . "\n";
                $bukti = null;
                $no = 1;
                if ($order[0]['refund']->file) {
                    foreach ($order[0]['refund']->file as $file) {
                        $bukti = $bukti . $no++ . ". " . getenv("UPLOAD_URL_REFUND") . rawurlencode($file) . "\n";
                    }
                }
                $img = $bukti ? "Bukti Transfer: " . $bukti : null;
                $status = "Status: Refund Sukses";
                $text = $nominal . $img . $status;
                $refund = str_replace('$data', $text, $message[0]['message']);
            }
        }
        $result['phone'] = nohp($order[0]['customer']->phone);
        $result['text'] = urlencode($refund);
        echo json_encode($result);
    }
    public function edit($id)
    {
        $this->order_model->inputRefund($id);
        sweetalert('Data Refund', 'berhasil ditambahkan', 'success');
        redirect("refund/view/$id");
    }
    function upload()
    {
        error_reporting(E_ALL | E_STRICT);
        require APPPATH . 'libraries/UploadHandlerRefund.php';
        $upload_handler = new UploadHandler();
    }
    public function search()
    {
        return $this->order_model->all_order_delivery();
    }
}
