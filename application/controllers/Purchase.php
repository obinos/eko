<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Purchase extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Purchase_model');
        $this->lang->load('message', getenv("APP_BRAND"));
        is_logged_in();
        is_session_1jam();
    }
    public function index()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        if ($_POST) {
            $data['filter_start'] = $this->input->post('filter_start');
            $data['filter_end'] = $this->input->post('filter_end');
        } else {
            $data['filter_start'] = date('d-m-Y', strtotime("6 days ago"));
            $data['filter_end'] = date('d-m-Y', strtotime("now"));
        }
        $data['title'] = 'Data Purchase Supplier - ' . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('purchase/index', $data);
        $this->load->view('templates/footer');
    }
    public function get_purchase()
    {
        $data['start'] = $this->input->get_post('start');
        $data['end'] = $this->input->get_post('end');
        $search = $_POST['search']['value'];
        $data['where_search'] = ['$or' => [
            ['no'               => new MongoDB\BSON\Regex($search, 'i')],
            ['supplier'         => new MongoDB\BSON\Regex($search, 'i')],
            ['usermaker'        => new MongoDB\BSON\Regex($search, 'i')],
            ['userupdate'       => new MongoDB\BSON\Regex($search, 'i')],
            ['created_at'       => new MongoDB\BSON\Regex($search, 'i')],
            ['updated_at'       => new MongoDB\BSON\Regex($search, 'i')],
            ['transaction_date' => new MongoDB\BSON\Regex($search, 'i')],
            ['notes'            => new MongoDB\BSON\Regex($search, 'i')]
        ]];
        echo $this->Purchase_model->serverside($data);
    }
    public function add_purchase()
    {
        $data['title'] = 'Input Purchase - ' . $this->lang->line('copyright');
        $this->load->model('Item_model');
        $data['typeahead'] = json_encode($this->Item_model->typeaheadPurchase(), true);
        $data['supplier'] = $this->aratadb->order_by(['name' => 'ASC'])->get('supplier');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('purchase/add', $data);
        $this->load->view('templates/footer');
    }
    public function view_purchase($id)
    {
        $data['title'] = 'View Purchase - ' . $this->lang->line('copyright');
        $data['purchase'] = $this->Purchase_model->dataPurchase($id);
        $items = json_decode(json_encode($data['purchase'][0]['items']), true);
        $this->load->model('Item_model');
        $allitem = $this->Item_model->get_items();
        $data['item'] = [];
        foreach ($items as $i) {
            $key = array_search($i['id_item'], array_column($allitem, "_id"));
            if ($key !== false) {
                $i['barcode'] = $allitem[$key]['barcode'];
                $i['name'] = $allitem[$key]['name'];
                $i['weight'] = $allitem[$key]['weight'];
                $i['station'] = $allitem[$key]['station'];
                $i['colorstation'] = (int)$i['station'] < 5 ? 'table-warning' : 'table-danger';
            }
            $data['item'][] = $i;
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('purchase/view', $data);
        $this->load->view('templates/footer');
    }
    public function edit_purchase($id)
    {
        $data['title'] = 'Edit Purchase - ' . $this->lang->line('copyright');
        $this->load->model('Item_model');
        $data['typeahead'] = json_encode($this->Item_model->typeaheadPurchase(), true);
        $data['purchase'] = $this->Purchase_model->dataPurchase($id);
        if (hplus1($data['purchase'][0]['created_at']) === false) {
            redirect('blocked');
        }
        $items = json_decode(json_encode($data['purchase'][0]['items']), true);
        $this->load->model('Item_model');
        $allitem = $this->Item_model->get_items();
        $data['item'] = [];
        foreach ($items as $i) {
            $key = array_search($i['id_item'], array_column($allitem, "_id"));
            if ($key !== false) {
                $i['name'] = $allitem[$key]['name'];
                $i['weight'] = $allitem[$key]['weight'];
                $i['station'] = $allitem[$key]['station'];
                $i['colorstation'] = (int)$i['station'] < 5 ? 'form-control-warning' : 'form-control-danger';
            }
            $data['item'][] = $i;
        }
        $data['supplier'] = $this->aratadb->order_by(['name' => 'ASC'])->get('supplier');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('purchase/edit', $data);
        $this->load->view('templates/footer');
    }
    public function repeat_purchase($id)
    {
        $data['title'] = 'Repeat Purchase - ' . $this->lang->line('copyright');
        $this->load->model('Item_model');
        $data['typeahead'] = json_encode($this->Item_model->typeaheadPurchase(), true);
        $data['purchase'] = $this->Purchase_model->dataPurchase($id);
        $items = json_decode(json_encode($data['purchase'][0]['items']), true);
        $this->load->model('Item_model');
        $allitem = $this->Item_model->get_items();
        $data['item'] = [];
        foreach ($items as $i) {
            $key = array_search($i['id_item'], array_column($allitem, "_id"));
            if ($key !== false) {
                $i['name'] = $allitem[$key]['name'];
                $i['weight'] = $allitem[$key]['weight'];
                $i['station'] = $allitem[$key]['station'];
                $i['colorstation'] = (int)$i['station'] < 5 ? 'form-control-warning' : 'form-control-danger';
            }
            $data['item'][] = $i;
        }
        $data['supplier'] = $this->aratadb->order_by(['name' => 'ASC'])->get('supplier');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('purchase/repeat', $data);
        $this->load->view('templates/footer');
    }
    public function cancel_purchase()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $update = $this->Purchase_model->cancelPurchase($_POST['data']);
        echo json_encode($update);
    }
    public function update_purchase()
    {
        $json = json_decode($_POST['data']);
        if ($json->item) {
            if ($json->discount) {
                $newval = [];
                $newtotal = 0;
                $newnote = $json->notes ? $json->notes . "\ndiskon=" . $json->discount : "diskon=" . $json->discount;
                foreach ($json->item as $key => $val) {
                    $res = new stdClass();
                    $res->_id = $val->_id;
                    $res->qty_beli = $val->qty_beli;
                    $res->qty_pack = $val->qty_pack;
                    $ratio = (int)$val->total_price / (int)$json->total_buy * 100;
                    $res->price_pack = ceil(((int)$val->total_price - ((int)$json->discount * $ratio / 100)) / (int)$res->qty_pack);
                    $res->total_price = $res->price_pack * (int)$val->qty_pack;
                    $res->weight_unit = $val->weight_unit;
                    $newtotal = $newtotal + $res->total_price;
                    $newval[] = $res;
                }

                unset($json->item);
                unset($json->total_buy);
                unset($json->notes);
                $json->item = $newval;
                $json->total_buy = $newtotal;
                $json->notes = $newnote;
            }
            if ($json->_id) {
                $result = $this->Purchase_model->editPurchase($json);
            } else {
                $result = $this->Purchase_model->addPurchase($json);
            }
        } else {
            $result['status'] = 'failed';
            $result['text'] = 'Produk Tidak Boleh Kosong';
        }
        echo json_encode($result);
    }
    public function pdf($id)
    {
        $data['purchase'] = $this->Purchase_model->dataPurchase($id);
        $items = json_decode(json_encode($data['purchase'][0]['items']), true);
        $this->load->model('Item_model');
        $allitem = $this->Item_model->get_items();
        $data['item'] = [];
        foreach ($items as $i) {
            $key = array_search($i['id_item'], array_column($allitem, "_id"));
            if ($key !== false) {
                $i['name'] = $allitem[$key]['name'];
            }
            $data['item'][] = $i;
        }
        $keys = array_column($data['item'], 'name');
        array_multisort($keys, SORT_ASC, $data['item']);
        $this->load->view('purchase/pdf', $data);
    }
    function upload()
    {
        error_reporting(E_ALL | E_STRICT);
        require APPPATH . 'libraries/UploadHandler.php';
        $upload_handler = new UploadHandler();
    }
}
