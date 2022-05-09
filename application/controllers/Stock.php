<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Stock extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Stock_model');
        $this->lang->load('message', getenv("APP_BRAND"));
        $this->merchant = '606eba1c099777608a38aeda';
        is_logged_in();
        is_session_1jam();
    }
    public function data()
    {
        if ($_POST) {
            $data['filter_store'] = $this->input->post('filter_store');
        } else {
            $data['filter_store'] = '60fbe096ba0f658aaccc0340';
        }
        $data['title'] = 'Data Stock - ' . $this->lang->line('copyright');
        $data['stock'] = $this->Stock_model->dataStock($data['filter_store']);
        $data['store'] = $this->aratadb->get('warehouse');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('stock/data', $data);
        $this->load->view('templates/footer');
    }
    public function saldo()
    {
        if ($_POST) {
            $data['filter_date'] = $this->input->post('filter_date');
            $data['filter_store'] = $this->input->post('filter_store');
        } else {
            $data['filter_date'] = date("Y-m-d");
            $data['filter_store'] = '60fbe096ba0f658aaccc0340';
        }
        $data['title'] = 'Saldo Stock - ' . $this->lang->line('copyright');
        $data['stock'] = $this->Stock_model->saldoStock($data['filter_date'], $data['filter_store']);
        $data['store'] = $this->aratadb->get('warehouse');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('stock/saldo', $data);
        $this->load->view('templates/footer');
    }
    public function excel($filter_date, $filter_store)
    {
        $params['_id'] = $filter_store;
        $warehouse = $this->aratadb->where($params)->get('warehouse');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'SKU');
        $sheet->setCellValue('C1', 'Station');
        $sheet->setCellValue('D1', 'Nama Produk');
        $sheet->setCellValue('E1', 'Stock');
        $sheet->setCellValue('F1', 'Satuan');
        $stock = $this->Stock_model->saldoStock($filter_date, $filter_store);
        $no = 1;
        $x = 2;
        foreach ($stock as $data) {
            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, $data['barcode']);
            $sheet->setCellValue('C' . $x, $data['station']);
            $sheet->setCellValue('D' . $x, $data['name']);
            $sheet->setCellValue('E' . $x, $data['stock']);
            $sheet->setCellValue('F' . $x, $data['weight_unit']);
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'Saldo Stock ' . $warehouse[0]['name'] . ' -' . $filter_date . '-' . date("H.i.s");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
    public function print_opname()
    {
        if ($_POST) {
            $data['filter_station'] = $this->input->post('filter_station');
            $data['filter_active'] = $this->input->post('filter_active');
            $data['filter_stock'] = $this->input->post('filter_stock');
        } else {
            $data['filter_station'] = 'all';
            $data['filter_active'] = 'true';
            $data['filter_stock'] = 'null';
        }
        $this->load->model('Item_model');
        $station = $this->Item_model->getStation();
        $result[] = 'all';
        foreach ($station as $s) {
            if ($s['_id'] === null or $s['_id'] == '') {
                $result[] = 'null';
            } else {
                $result[] = $s['_id'];
            }
        }
        $unique = array_unique($result);
        foreach ($unique as $arr) {
            if ($arr != 'null') {
                $data['station'][] = $arr;
            }
        }
        foreach ($unique as $arr) {
            if ($arr == 'null') {
                $data['station'][] = $arr;
            }
        }
        $data['active'] = ['null' => 'none', 'true' => 'yes', 'false' => 'no'];
        $data['title'] = 'Data Stock Opname - ' . $this->lang->line('copyright');
        $array['station'] = $data['filter_station'];
        $array['active'] = $data['filter_active'];
        $array['stock'] = $data['filter_stock'];
        $data['stock'] = $this->Stock_model->dataStockOpname($array);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('stock/print_opname', $data);
        $this->load->view('templates/footer');
    }
    public function get_stock()
    {
        $json = json_decode($_POST['data']);
        $array['id_item'] = $json->id_item;
        $array['condition'] = $json->condition;
        $array['transaction_date'] = $json->transaction_date;
        $array['id_warehouse'] = $this->input->get_post('id_warehouse');
        $stock = $this->Stock_model->getStock($array);
        echo json_encode($stock);
    }
    public function get_data()
    {
        $data['id_item'] = $this->input->get_post('id_item');
        $data['condition'] = $this->input->get_post('condition');
        $search = $_POST['search']['value'];
        $data['where_search'] = ['$or' => [
            ['type' => new MongoDB\BSON\Regex($search, 'i')]
        ]];
        echo $this->Stock_model->serverside($data);
    }
}
