<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Adjustment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Adjustment_model');
        $this->lang->load('message', getenv("APP_BRAND"));
        is_logged_in();
        is_session_1jam();
    }
    public function opname()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'Data Stock Opname - ' . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('adjustment/opname/index', $data);
        $this->load->view('templates/footer');
    }
    public function add_opname()
    {
        $this->load->model('Item_model');
        $this->load->model('Stock_model');
        $data['typeahead'] = json_encode($this->Item_model->typeaheadOpname(), true);
        if ($_POST) {
            $array['station'] = $this->input->post('filter_station');
            $array['active'] = 'true';
            $item = $this->Item_model->get_items($array);
            $stock = $this->Stock_model->allStock('good');
            $data['items'] = [];
            foreach ($item as $i) {
                $newObject = new stdClass();
                $newObject->_id = $i['_id'];
                $newObject->active = $i['active'] === true ? "✅" : "❌";
                $newObject->barcode = $i['barcode'];
                $newObject->name = $i['name'];
                $key = array_search($i['_id'], array_column($stock, "_id"));
                if ($key !== false) {
                    $newObject->good = $stock[$key]['stock'];
                } else {
                    $newObject->good = 0;
                }
                $data['items'][] = $newObject;
            }
            $data['filter_station'] = $this->input->post('filter_station');
        }
        $data['title'] = 'Input Stock Opname - ' . $this->lang->line('copyright');
        $data['station'] = $this->Item_model->getStation();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('adjustment/opname/add', $data);
        $this->load->view('templates/footer');
    }
    public function re_opname($id)
    {
        $data['title'] = 'Input Stock Opname - ' . $this->lang->line('copyright');
        $this->load->model('Item_model');
        $data['typeahead'] = json_encode($this->Item_model->typeaheadOpname(), true);
        $adjustment = $this->Adjustment_model->dataAdjustment($id);
        $this->load->model('Stock_model');
        $stock = $this->Stock_model->allStock('good');
        $data['items'] = [];
        foreach ($adjustment[0]['items'] as $k => $i) {
            $i->active = $i->active === true ? "✅" : "❌";
            $key = array_search($i->id_item, array_column($stock, "_id"));
            if ($key !== false) {
                $i->good = $stock[$key]['stock'];
            } else {
                $i->good = 0;
            }
            $data['items'][] = $i;
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('adjustment/opname/add', $data);
        $this->load->view('templates/footer');
    }
    public function view_opname($id)
    {
        $data['title'] = 'View Stock Opname - ' . $this->lang->line('copyright');
        $data['adjustment'] = $this->Adjustment_model->dataAdjustment($id);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('adjustment/opname/view', $data);
        $this->load->view('templates/footer');
    }
    public function excel_opname($id)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'SKU');
        $sheet->setCellValue('C1', 'Nama Produk');
        $sheet->setCellValue('D1', 'Stok Fisik');
        $sheet->setCellValue('E1', 'Selisih');
        $sheet->setCellValue('F1', 'Total');
        $result = $this->Adjustment_model->dataAdjustment($id);
        $no = 1;
        $x = 2;
        foreach ($result[0]['items'] as $k => $data) {
            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, $data->barcode);
            $sheet->setCellValue('C' . $x, $data->name);
            $sheet->setCellValue('D' . $x, $data->physic);
            $sheet->setCellValue('E' . $x, $data->difference);
            $sheet->setCellValue('F' . $x, $data->hpp);
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        $note = $result[0]['_id']->notes ? '-' . $result[0]['_id']->notes : null;
        $filename = 'PO' . $note . '-' . date("H.i.s");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
    public function get_adjustment($adjustment)
    {
        $search = $_POST['search']['value'];
        $data['where_search'] = ['$or' => [
            ['no'               => new MongoDB\BSON\Regex($search, 'i')],
            ['usermaker'        => new MongoDB\BSON\Regex($search, 'i')],
            ['created_at'       => new MongoDB\BSON\Regex($search, 'i')],
            ['notes'            => new MongoDB\BSON\Regex($search, 'i')]
        ]];
        $data['adjustment'] = $adjustment;
        echo $this->Adjustment_model->serverside($data);
    }
    public function get_stock()
    {
        $array['id'] = $_POST['data'];
        $array['status'] = ['open', 'onprocess'];
        $this->load->model('Stock_model');
        $stock = $this->Stock_model->stockOrder($array);
        $result['qty'] = $stock[0]['qty'] ? $stock[0]['qty'] : 0;
        echo json_encode($result);
    }
    public function ledger_stock()
    {
        $array['id'] = $_POST['id'];
        $array['condition'] = $_POST['condition'];
        $this->load->model('Stock_model');
        $stock = $this->Stock_model->totalStock($array);
        $result['good'] = $stock[$_POST['id']]['good'] ? $stock[$_POST['id']]['good'] : 0;
        $result['damage'] = $stock[$_POST['id']]['damage'] ? $stock[$_POST['id']]['damage'] : 0;
        $result['reject'] = $stock[$_POST['id']]['reject'] ? $stock[$_POST['id']]['reject'] : 0;
        $result['total'] = $result['good'] + $result['damage'] + $result['reject'];
        echo json_encode($result);
    }
    public function update_opname()
    {
        $json = json_decode($_POST['data']);
        if ($json->item) {
            $result = $this->Adjustment_model->addAdjustment($json);
        } else {
            $result['status'] = 'failed';
            $result['text'] = 'Produk Tidak Boleh Kosong';
        }
        echo json_encode($result);
    }
    public function test($station)
    {
        $params['station'] = $station;
        $params['merchant'] = '606eba1c099777608a38aeda';
        $result = $this->aratadb->select(['_id', 'name', 'active', 'stock', 'barcode', 'stock_default', 'purchase_price', 'station'])->order_by(['station' => 'ASC'])->where($params)->get('items');
        $this->load->model('Stock_model');
        $array['condition'] = 'good';
        $resultcondition = $this->Stock_model->totalStock($array);
        $array_stock['status'] = ['open', 'onprocess'];
        $this->load->model('Stock_model');
        $stocks = $this->Stock_model->stockOrder($array_stock);
        foreach ($stocks as $v) {
            $resultstock[$v['id_item']] = $v['qty'];
        }
        $object = new stdClass();
        $array = [];
        foreach ($result as $res) {
            $item = new stdClass();
            $item->_id = $res['_id'];
            $good = $resultcondition[$res['_id']]['good'] ? $resultcondition[$res['_id']]['good'] : 0;
            $qty = $resultstock[$res['_id']] ? $resultstock[$res['_id']] : 0;
            $physic = $res['stock'] + $qty;
            $item->physic = $physic;
            $item->difference = $physic - $good;
            $item->hpp = 0;
            $array[] = $item;
        }
        $object->item = $array;
        $object->notes = 'update query station ' . $station;
        $this->Adjustment_model->addAdjustment($object);
    }
    public function check_item()
    {
        $json = json_decode($_POST['data']);
        if ($json->item) {
            $result = $this->Adjustment_model->checkItem($json);
        } else {
            $result['data'] = 'failed';
        }
        echo json_encode($result);
    }
    public function transfer()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'Data Transfer Stock - ' . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('adjustment/transfer/index', $data);
        $this->load->view('templates/footer');
    }
    public function add_transfer()
    {
        $data['title'] = 'Input Transfer Stock - ' . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('adjustment/transfer/add', $data);
        $this->load->view('templates/footer');
    }
    public function update_transfer()
    {
        $json = json_decode($_POST['data']);
        if ($json->item) {
            $result = $this->Adjustment_model->addTransfer($json);
        } else {
            $result['status'] = 'failed';
            $result['text'] = 'Produk Tidak Boleh Kosong';
        }
        echo json_encode($result);
    }
    public function view_transfer($id)
    {
        $data['title'] = 'View Transfer Stock - ' . $this->lang->line('copyright');
        $data['adjustment'] = $this->Adjustment_model->dataAdjustment($id);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('adjustment/transfer/view', $data);
        $this->load->view('templates/footer');
    }
    public function data_transfer()
    {
        $result = $this->Adjustment_model->dataTransfer();
        echo json_encode($result, true);
    }
    public function warehouse()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'Data Transfer Warehouse - ' . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('adjustment/warehouse/index', $data);
        $this->load->view('templates/footer');
    }
    public function add_warehouse()
    {
        $data['title'] = 'Input Transfer Warehouse - ' . $this->lang->line('copyright');
        $data['store'] = $this->aratadb->get('warehouse');
        if ($_GET) {
            $data['filter_store1'] = $this->input->get('filter_store1');
            $data['filter_store2'] = $this->input->get('filter_store2');
        } else {
            $data['filter_store1'] = '60fbe096ba0f658aaccc0340';
            $data['filter_store2'] = '624a3d3fbc3af75c4109418c';
        }
        $this->load->model('Stock_model');
        $data['typeahead'] = json_encode($this->Stock_model->allStock('good', $data['filter_store1']), true);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('adjustment/warehouse/add');
        $this->load->view('templates/footer');
    }
    public function data_warehouse()
    {
        $this->load->model('Stock_model');
        $result = $this->Stock_model->allStock('good', $_POST['data']);
        echo json_encode($result, true);
    }
    public function update_warehouse()
    {
        $json = json_decode($_POST['data']);
        if ($json->item) {
            $result = $this->Adjustment_model->addTransferWarehouse($json);
        } else {
            $result['status'] = 'failed';
            $result['text'] = 'Produk Tidak Boleh Kosong';
        }
        echo json_encode($result);
    }
    public function view_warehouse($id)
    {
        $data['title'] = 'View Transfer Warehouse - ' . $this->lang->line('copyright');
        $data['adjustment'] = $this->Adjustment_model->dataAdjustmentWarehouse($id);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('adjustment/warehouse/view', $data);
        $this->load->view('templates/footer');
    }
    public function re_transfer_warehouse($id)
    {
        $data['title'] = 'Input Stock Opname - ' . $this->lang->line('copyright');
        $this->load->model('Item_model');
        $data['typeahead'] = json_encode($this->Item_model->typeaheadOpname(), true);
        $adjustment = $this->Adjustment_model->dataAdjustment($id);
        $this->load->model('Stock_model');
        $stock = $this->Stock_model->allStock('good');
        $data['items'] = [];
        foreach ($adjustment[0]['items'] as $k => $i) {
            $i->active = $i->active === true ? "✅" : "❌";
            $key = array_search($i->id_item, array_column($stock, "_id"));
            if ($key !== false) {
                $i->good = $stock[$key]['stock'];
            } else {
                $i->good = 0;
            }
            $data['items'][] = $i;
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('adjustment/opname/add', $data);
        $this->load->view('templates/footer');
    }
}
