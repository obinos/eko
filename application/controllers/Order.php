<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('message', getenv("APP_BRAND"));
        $this->load->model('order_model');
        is_logged_in();
        is_session_1jam();
    }
    public function index()
    {
        $data['title'] = 'Data Order - ' . $this->lang->line('copyright');
        $data['name'] = base64_decode($_GET['id']);
        $data['all_order'] = json_encode($this->aratadb->select(['_id', 'invno', 'customer.name', 'customer.phone', 'recipient.name', 'recipient.phone'])->order_by(['delivery_time' => 'DESC'])->where(['merchant' => '606eba1c099777608a38aeda'])->get('orders'), true);
        $array['status'] = ['open', 'onprocess'];
        $order1 = $this->order_model->sum_order($array);
        $array['status'] = ['closed', 'canceled'];
        $array['start'] = $array2['start'] = date("d-m-Y");
        $order2 = $this->order_model->sum_order($array);
        $order = array_merge($order1, $order2);
        foreach ($order as $val) {
            $data['count_' . $val['_id']] = $val['count'];
            $data['total_' . $val['_id']] = $val['total'];
        }
        $unique = $this->order_model->uniqueCustomer($array2);
        foreach ($unique as $ord) {
            $result[$ord['_id']] = $ord['total'];
        }
        $data['uniqueopen'] = $result['open'] ? $result['open'] : 0;
        $data['uniqueonprocess'] = $result['onprocess'] ? $result['onprocess'] : 0;
        $data['uniqueclosed'] = $result['closed'] ? $result['closed'] : 0;
        $data['uniquecanceled'] = $result['canceled'] ? $result['canceled'] : 0;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('order/index', $data);
        $this->load->view('templates/footer');
    }
    public function list($status)
    {
        $data['start'] = $this->input->get_post('start');
        $data['end'] = $this->input->get_post('end');
        $data['status'] = $status;
        $data['status_order'] = status_order($status);
        $data['data_status'] = [
            "open"      => "Order Baru",
            "onprocess" => "Proses Order",
            "closed"    => "Selesaikan Order",
            "canceled"  => "Batalkan Order"
        ];
        $data['title'] = "Data Order $status" . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('order/list', $data);
        $this->load->view('templates/footer');
    }
    public function gift()
    {
        if ($_POST) {
            $data['filter_start'] = $this->input->post('filter_start');
            $data['filter_end'] = $this->input->post('filter_end');
            $data['filter_payment'] = $this->input->post('filter_payment');
        }
        $data['title'] = "Data Order Gift " . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('order/gift', $data);
        $this->load->view('templates/footer');
    }
    public function get_gift()
    {
        $data['start'] = $this->input->get_post('start');
        $data['end'] = $this->input->get_post('end');
        $search = $_POST['search']['value'];
        $data['where_search'] = ['$or' => [
            ['invno'     => new MongoDB\BSON\Regex($search, 'i')],
            ['customer'  => new MongoDB\BSON\Regex($search, 'i')],
            ['recipient' => new MongoDB\BSON\Regex($search, 'i')],
            ['price'     => new MongoDB\BSON\Regex($search, 'i')]
        ]];
        echo $this->order_model->serverside2($data);
    }
    public function view($id)
    {
        $data['title'] = "Detail Transaksi" . $this->lang->line('copyright');
        $data['order'] = $this->order_model->view_order($id);
        $shipping = strpos($data['order'][0]['shipping'], 'Sidoarjo') !== false ? 'Sidoarjo' : $data['order'][0]['shipping'];
        $data['address'] = strpos(ucwords($data['order'][0]['customer']->address), $shipping) !== false ? $data['order'][0]['customer']->address : $data['order'][0]['customer']->address . ', ' . $shipping;
        $data['shipping_weight'] = $data['order'][0]['shipping_weight'] ? round($data['order'][0]['shipping_weight'] / 1000, 2) : 0;
        $data['delivery_time'] = $data['order'][0]['delivery_shift'] ? 'Dikirim: ' . datephp('d M y', $data['order'][0]['delivery_time']) . ', ' . ucwords($data['order'][0]['delivery_shift']) : 'Dikirim: ' . datephp('d M y', $data['order'][0]['delivery_time']);
        $data['payment'] = status_payment($data['order'][0]['is_paid']);
        $data['status_order'] = status_order($data['order'][0]['status']);
        $data['data_status'] = [
            "open"      => "Order Baru",
            "onprocess" => "Order Diproses",
            "closed"    => "Order Terkirim",
            "canceled"  => "Order Batal"
        ];
        if ($data['order'][0]['is_dropship'] == true) {
            $cust = $data['order'][0]['customer']->name . "%20" . nohp($data['order'][0]['customer']->phone) . "%0ADetail%20penerima%3A%0A" . $data['order'][0]['recipient']->name . "%20" . nohp($data['order'][0]['recipient']->phone) . "%0A" . $data['order'][0]['recipient']->address;
        } else {
            $cust = $data['order'][0]['recipient']->name . "%20" . nohp($data['order'][0]['recipient']->phone) . "%0A" . $data['order'][0]['recipient']->address;
        }

        $no = 1;
        $items = json_decode(json_encode($data['order'][0]['items']), true);
        $keys = array_column($items, 'name');
        array_multisort($keys, SORT_ASC, $items);
        foreach ($items as $item) :
            if ($item['note']) {
                $note = "Catatan%3A%20_" . $item['note'] . "_%0A";
            } else {
                $note = null;
            }
            $items_customer[] = $no++ . ".%20%2A" . $item['qty'] . "x%20" . $item['name'] . "%2A%0A%28" . rupiah($item['price']) . "%29%20%3D%20" . rupiah($item['qty'] * $item['price']) . "%0A" . $note;
        endforeach;
        $products = implode("%0A", $items_customer);
        $data['rincian'] = "%2A%5BJangan%20Dibalas%5D%2A%0ADetail%20ordermu%20di%20%2AArata%20Mart%2A.%0A%0A" . $cust . "%0A%0A" . $products . "%0ASub%20Total%3A%20%2A" . rupiah($data['order'][0]['price']->subtotal) . "%2A%0AOngkir%3A%20" . rupiah($data['order'][0]['price']->shipping) . "%0ATotal%3A%20%2A" . rupiah($data['order'][0]['price']->total) . "%2A%0A%0ACatatan%20Penjual%3A%20" . $data['order'][0]['merchant_notes'] . "%0AWaktu%20Kirim%3A%20" . datephp('d M y', $data['order'][0]['delivery_time']) . "%0APengiriman%3A%20" . $data['order'][0]['shipping'] . "%0APembayaran%3A%20%2A" . $data['order'][0]['payment'][0]->method . "%2A%0A%0ATerima%20Kasih%20%F0%9F%99%8F";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('order/view', $data);
        $this->load->view('templates/footer');
    }
    public function download($id)
    {
        $data['order'] = $this->order_model->view_order($id);
        $this->load->view('order/pdf', $data);
    }
    public function close_cancel()
    {
        $array['status'] = ['closed', 'canceled'];
        $array['start'] = $this->input->get_post('start');
        $array['end'] = $this->input->get_post('end');
        $order = $this->order_model->sum_order($array);
        foreach ($order as $val1) {
            $data['count_' . $val1['_id']] = $val1['count'];
            $data['total_' . $val1['_id']] = $val1['total'];
        }
        foreach ($array['status'] as $val2) {
            $data['count_' . $val2] = $data['count_' . $val2] ? $data['count_' . $val2] : 0;
            $data['total_' . $val2] = $data['total_' . $val2] ? $data['total_' . $val2] : 0;
        }
        echo json_encode($data);
    }
    public function unique_customer()
    {
        $array['start'] = $this->input->get_post('start');
        $array['end'] = $this->input->get_post('end');
        $order = $this->order_model->uniqueCustomer($array);
        foreach ($order as $ord) {
            $data[$ord['_id']] = $ord['total'];
        }
        $result['open'] = $data['open'] ? $data['open'] : 0;
        $result['onprocess'] = $data['onprocess'] ? $data['onprocess'] : 0;
        $result['closed'] = $data['closed'] ? $data['closed'] : 0;
        $result['canceled'] = $data['canceled'] ? $data['canceled'] : 0;
        echo json_encode($result);
    }
    public function get_data($status)
    {
        $data['start'] = $this->input->get_post('start');
        $data['end'] = $this->input->get_post('end');
        $data['payment'] = $this->input->get_post('payment');
        $data['refund'] = $this->input->get_post('refund');
        $data['status'] = $status;
        $search = $_POST['search']['value'];
        $data['where_search'] = ['$or' => [
            ['payment.method' => new MongoDB\BSON\Regex($search, 'i')],
            ['customer.name' => new MongoDB\BSON\Regex($search, 'i')],
            ['recipient.name' => new MongoDB\BSON\Regex($search, 'i')],
            ['invno' => new MongoDB\BSON\Regex($search, 'i')]
        ]];
        echo $this->order_model->serverside($data);
    }
    public function bulk_status($status, $update)
    {
        $this->order_model->update_status($update);
        sweetalert('Data Order', 'berhasil diupdate', 'success');
        redirect('order/list/' . $status);
    }
    public function update_status($status, $id)
    {
        $this->order_model->update_status($status, $id);
        sweetalert('Status Order', 'berhasil diupdate', 'success');
        redirect('order/view/' . $id);
    }
    public function update_kresek()
    {
        $id = $this->input->post('id');
        $kresek = $this->input->post('kresek');
        $this->order_model->update_kresek((int)$kresek, $id);
        sweetalert('Jumlah Kresek', 'berhasil diupdate', 'success');
        redirect('order/view/' . $id);
    }
    public function update_paid()
    {
        $json = json_decode($_POST['data']);
        $result = $this->order_model->update_paid($json);
        echo json_encode($result);
    }
}
