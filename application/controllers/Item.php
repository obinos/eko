<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Item extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Item_model');
        $this->lang->load('message', getenv("APP_BRAND"));
        is_logged_in();
        is_session_1jam();
    }
    public function view1()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        if ($_POST) {
            $data['filter_station'] = $this->input->post('filter_station');
            $data['filter_active'] = $this->input->post('filter_active');
            $data['filter_bestseller'] = $this->input->post('filter_bestseller');
        } else {
            $data['filter_station'] = 'all';
            $data['filter_active'] = 'true';
            $data['filter_bestseller'] = 'null';
        }
        $data['station'] = $this->Item_model->getStation();
        array_unshift($data['station'], "all");
        $data['active'] = ['null' => 'none', 'true' => 'yes', 'false' => 'no'];
        $data['title'] = 'Item List - ' . $this->lang->line('copyright');
        $array['station'] = $data['filter_station'];
        $array['active'] = $data['filter_active'];
        $array['is_bestseller'] = $data['filter_bestseller'];
        $item = $this->Item_model->get_items($array);
        $data['item'] = [];
        foreach ($item as $itm) {
            $price = $itm['sales_price'] ? $itm['sales_price'] : $itm['price'];
            $price = $price ? $price : 1;
            $profit = round((($price - $itm['purchase_price']->avg_price) / $price) * 100, 2);
            if ($profit < $itm['profit_min'] || $profit > $itm['profit_max']) {
                $icon = $profit < $itm['profit_min'] ? "table-danger" : "table-success";
                $itm['bg_hpp'] = $icon;
            } else {
                $itm['bg_hpp'] = null;
            }
            $data['item'][] = $itm;
        }
        $data['category'] = $this->aratadb->where(['merchant' => '606eba1c099777608a38aeda'])->get('categories');
        $data['supplier'] = $this->aratadb->order_by(['name' => 'ASC'])->get('supplier');
        $data['satuan'] = ['gr', 'pack', 'pcs', 'ikat'];
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('item/view1', $data);
        $this->load->view('templates/footer');
    }
    public function view2()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        if ($_POST) {
            $data['filter_station'] = $this->input->post('filter_station');
            $data['filter_active'] = $this->input->post('filter_active');
            $data['filter_bestseller'] = $this->input->post('filter_bestseller');
        } else {
            $data['filter_station'] = 'all';
            $data['filter_active'] = 'true';
            $data['filter_bestseller'] = 'null';
        }
        $data['station'] = $this->Item_model->getStation();
        array_unshift($data['station'], "all");
        $data['active'] = ['null' => 'none', 'true' => 'yes', 'false' => 'no'];
        $data['title'] = 'Item List - ' . $this->lang->line('copyright');
        $array['station'] = $data['filter_station'];
        $array['active'] = $data['filter_active'];
        $array['is_bestseller'] = $data['filter_bestseller'];
        $item = $this->Item_model->get_items($array);
        $data['item'] = [];
        foreach ($item as $itm) {
            $price = $itm['sales_price'] ? $itm['sales_price'] : $itm['price'];
            $price = $price ? $price : 1;
            $avg_price = $itm['purchase_price']->avg_price ? $itm['purchase_price']->avg_price : $itm['purchase_price']->last->price;
            $profit = round((($price - $avg_price) / $price) * 100, 2);
            $itm['current_profit'] = $profit;
            if ($profit < $itm['profit_min'] || $profit > $itm['profit_max']) {
                $icon = $profit < $itm['profit_min'] ? "table-danger" : "table-success";
                $itm['bg_hpp'] = $icon;
            } else {
                $itm['bg_hpp'] = null;
            }
            $data['item'][] = $itm;
        }
        $data['category'] = $this->aratadb->where(['merchant' => '606eba1c099777608a38aeda'])->get('categories');
        $data['supplier'] = $this->aratadb->order_by(['name' => 'ASC'])->get('supplier');
        $data['satuan'] = ['gr', 'pack', 'pcs', 'ikat'];
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('item/view2', $data);
        $this->load->view('templates/footer');
    }
    public function nominal()
    {
        $data['title'] = 'Item List - ' . $this->lang->line('copyright');
        $item = $this->Item_model->nominalStock();
        foreach ($item[0]['items'] as $k => $i) {
            $result['name'] = $i->name;
            $result['station'] = $i->station;
            $result['stock'] = $i->stock;
            $result['avg_price'] = thousand($i->avg_price);
            $result['nominal'] = thousand($i->nominal);
            $data['item'][] = $result;
        }
        array_multisort(array_column($data['item'], 'station'), SORT_ASC, array_column($data['item'], 'name'), SORT_ASC, $data['item']);
        $data['total'] = thousand($item[0]['total']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('item/nominal', $data);
        $this->load->view('templates/footer');
    }
    public function store()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        if ($_POST) {
            $data['filter_store'] = $this->input->post('filter_store');
        } else {
            $data['filter_store'] = null;
        }
        $data['title'] = 'Item List - ' . $this->lang->line('copyright');
        $params['$nor'] = [['_id' => '60fbe096ba0f658aaccc0340']];
        $data['store'] = $this->aratadb->where($params)->get('warehouse');
        if ($data['filter_store']) {
            $data['satuan'] = ['gr', 'pack'];
            $data['retur'] = ['R', 'P'];
            $params2['active'] = true;
            $params2['$nor'] = [['barcode' => ''], ['barcode' => null]];
            $params2['merchant'] = '606eba1c099777608a38aeda';
            $item = $this->aratadb->where($params2)->get('items');
            $data['item'] = [];
            foreach ($item as $itm) {
                $result['_id'] = $itm['_id'];
                $result['barcode'] = $itm['barcode'];
                $result['station'] = $itm['station'];
                $result['name'] = $itm['name'];
                $result['price'] = $itm['price'] > $itm['sales_price'] ? '<s>' . thousand($itm['price']) . '</s> ' . thousand($itm['sales_price']) : thousand($itm['price']);
                $result['avg_hpp'] = $itm['purchase_price']->avg_price ? thousand($itm['purchase_price']->avg_price) : thousand($itm['purchase_price']->last->price);
                $result['rack'] = $itm['store_price']->{$data['filter_store']}->rack ? $itm['store_price']->{$data['filter_store']}->rack : null;
                $result['retur'] = $itm['store_price']->{$data['filter_store']}->retur ? $itm['store_price']->{$data['filter_store']}->retur : null;
                $result['unit'] = $itm['store_price']->{$data['filter_store']}->unit ? $itm['store_price']->{$data['filter_store']}->unit : null;
                $result['base_price'] = $itm['store_price']->{$data['filter_store']}->base_price ? thousand($itm['store_price']->{$data['filter_store']}->base_price) : 0;
                $result['discount'] = $itm['store_price']->{$data['filter_store']}->discount ? thousand($itm['store_price']->{$data['filter_store']}->discount) : 0;
                $result['sales_price'] = $itm['store_price']->{$data['filter_store']}->sales_price ? thousand($itm['store_price']->{$data['filter_store']}->sales_price) : 0;
                $result['label'] = $result['sales_price'] < $result['avg_hpp'] ? 'table-danger' : null;
                $data['item'][] = $result;
            }
            array_multisort(array_column($data['item'], 'station'), SORT_ASC, array_column($data['item'], 'name'), SORT_ASC, $data['item']);
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('item/store', $data);
        $this->load->view('templates/footer');
    }
    public function sync_price()
    {
        $params2['active'] = true;
        $params2['$nor'] = [['barcode' => ''], ['barcode' => null]];
        $params2['merchant'] = '606eba1c099777608a38aeda';
        $item = $this->aratadb->where($params2)->get('items');
        foreach ($item as $itm) {
            $data['base_price'] = $itm['price'];
            $data['unit'] = $itm['weight_unit'] == 'gr' || $itm['weight_unit'] == 'g' ? 'gr' : 'pack';
            $data['discount'] = $itm['price'] - $itm['sales_price'];
            $data['sales_price'] = $itm['sales_price'];
            if (!$itm['store_price']) {
                $itm['store_price'] = new stdClass();
            }
            $itm['store_price']->{$_POST['data']} = $data;
            $result = [
                "store_price" => $itm['store_price'],
                "updated_at"  => $this->mongo_db->date()
            ];
            $params['_id'] = $itm['_id'];
            $this->aratadb->where($params)->set($result)->update('items');
        }
        $result['status'] = 'success';
        echo json_encode($result);
    }
    public function get_item()
    {
        $array['_id'] = $_POST['data'];
        $item = $this->Item_model->get_items($array);
        echo json_encode($item);
    }
    public function update_item()
    {
        $json = json_decode($_POST['data']);
        $update = $this->Item_model->editItem($json);
        echo json_encode($update);
    }
    public function update_item_store()
    {
        $json = json_decode($_POST['data']);
        $update = $this->Item_model->editItemStore($json);
        echo json_encode($update);
    }
    public function check_item()
    {
        $barcode = strtoupper(htmlspecialchars($_POST['sku']));
        $result = $this->Item_model->checkItem($barcode);
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
    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Active');
        $sheet->setCellValue('C1', 'Best Seller');
        $sheet->setCellValue('D1', 'Tanggal');
        $sheet->setCellValue('E1', 'SKU');
        $sheet->setCellValue('F1', 'Kategori');
        $sheet->setCellValue('G1', 'Station');
        $sheet->setCellValue('H1', 'Nama Produk');
        $sheet->setCellValue('I1', 'Harga');
        $sheet->setCellValue('J1', 'Promo');
        $sheet->setCellValue('K1', 'Berat');
        $sheet->setCellValue('L1', 'Satuan');
        $sheet->setCellValue('M1', 'Supplier');
        $sheet->setCellValue('N1', 'Stock Manage');
        $sheet->setCellValue('O1', 'Stock');
        $sheet->setCellValue('P1', 'Stock Default');
        $recap = $this->Item_model->get_items();
        $no = 1;
        $x = 2;
        foreach ($recap as $data) {
            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, $data['active']);
            $sheet->setCellValue('C' . $x, $data['is_bestseller']);
            $sheet->setCellValue('D' . $x, datephp('d-m-Y', $data['created_at']));
            $sheet->setCellValue('E' . $x, $data['barcode']);
            $sheet->setCellValue('F' . $x, $data['category']);
            $sheet->setCellValue('G' . $x, $data['station']);
            $sheet->setCellValue('H' . $x, $data['name']);
            $sheet->setCellValue('I' . $x, $data['price']);
            $sheet->setCellValue('J' . $x, $data['sales_price']);
            $sheet->setCellValue('K' . $x, $data['weight']);
            $sheet->setCellValue('L' . $x, $data['weight_unit']);
            $sheet->setCellValue('M' . $x, $data['supplier']);
            $sheet->setCellValue('N' . $x, $data['stock_managed']);
            $sheet->setCellValue('O' . $x, $data['stock']);
            $sheet->setCellValue('P' . $x, $data['stock_default']);
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'List Produk ' . date("d-m-Y H.i.s");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
    public function def()
    {
        $params['$or'] = [['station' => '5A'], ['station' => '5B'], ['station' => '5C']];
        $params['$nor'] = [['stock_default' => '0'], ['stock_default' => 0]];
        $params['merchant'] = '606eba1c099777608a38aeda';
        $po = $this->aratadb->where($params)->get('items');
        foreach ($po as $p) {
            $param['_id'] = $p['_id'];
            $item['stock_default'] = '0';
            $this->aratadb->where($param)->set($item)->update('items');
        }
    }
    public function test()
    {
        phpinfo();
    }
}
