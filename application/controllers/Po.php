<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Po extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Po_model');
        $this->lang->load('message', getenv("APP_BRAND"));
        is_logged_in();
        is_session_1jam();
    }
    public function pasar()
    {
        if ($_POST) {
            $data['filter_date'] = $this->input->post('filter_date');
        } elseif ($_GET) {
            $data['filter_date'] = $this->input->get('filter_date');
        } else {
            $data['filter_date'] = date("d-m-Y", strtotime('tomorrow'));
        }
        $data['title'] = 'Data Rekap PO - ' . $this->lang->line('copyright');
        $this->load->model('order_model');
        $recap = $this->order_model->recap('onprocess', $data['filter_date']);
        $this->load->model('Stock_model');
        $stock = $this->Stock_model->allStock('good');
        $data['recap'] = [];
        foreach ($recap as $rec) {
            if ($rec['station'] == '5A' || $rec['station'] == '5B' || $rec['station'] == '5C') {
            } else {
                $key = array_search($rec['id_item'], array_column($stock, "_id"));
                $rec['stock_physic'] = $key !== false && $stock[$key]['stock'] > 0 ? round($stock[$key]['stock'], 2) : 0;
                $rec['stock_physic_weight'] = $rec['stock_physic'] * $rec['berat'];
                $data['recap'][] = $rec;
            }
        }
        $data['poexisting'] = $this->Po_model->poexisting($data['filter_date']);
        foreach ($data['poexisting'] as $val) {
            foreach (json_decode(json_encode($val['items']), true) as $vali) {
                $rekappoitem[$vali['id_item']] = $vali;
            }
        }
        foreach ($data['recap'] as $val) {
            $rekapitem[] = $val;
            $input = (($val['qty'] - $val['stock_physic']) * $val['berat']) - $rekappoitem[$val['id_item']]['qty_unit'];
            $data['openpo'][$val['id_item']] =  $rekappoitem[$val['id_item']]['qty_unit'] ? $rekappoitem[$val['id_item']]['qty_unit'] : 0;
            $data['inputpo'][$val['id_item']] =  $input > 0 ? round($input, 2) : 0;
            $data['notespo'][$val['id_item']] = $rekappoitem[$val['id_item']]['notes'] ? $rekappoitem[$val['id_item']]['notes'] :  $val['note'];
        }
        array_multisort(array_column($data['recap'], 'supplier'), SORT_ASC, array_column($data['recap'], 'nama_produk'), SORT_ASC, $data['recap']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('po/pasar', $data);
        $this->load->view('templates/footer');
    }
    public function update_po()
    {
        $json = json_decode($_POST['data']);
        if ($json->item) {
            if ($json->_id) {
                $result = $this->Po_model->editPO($json);
            } else {
                $result = $this->Po_model->addPO($json);
            }
        } else {
            $result['result'] = 'failed';
            $result['text'] = 'Produk Tidak Boleh Kosong';
        }
        echo json_encode($result);
    }
    public function list()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        if ($_POST) {
            $data['filter_status'] = $this->input->post('filter_status');
        } else {
            $data['filter_status'] = 'open';
        }
        $data['title'] = 'Data PO - ' . $this->lang->line('copyright');
        $data['status'] = ['all', 'open', 'closed'];
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('po/list', $data);
        $this->load->view('templates/footer');
    }
    public function view_po()
    {
        $po = $this->Po_model->dataPO($_POST['data']);
        $po[0]['created'] = datephp('d-m-Y H:i', $po[0]['created_at']);
        $po[0]['transaction_date'] = datephp('d-m-Y', $po[0]['transaction_date']);
        echo json_encode($po[0]);
    }
    public function pdf($id)
    {
        $data['po'] = $this->Po_model->dataPO($id);
        $this->load->view('po/pdf', $data);
    }
    public function get_po()
    {
        $data['status'] = $this->input->get_post('status');
        $search = $_POST['search']['value'];
        $data['where_search'] = ['$or' => [
            ['pono'             => new MongoDB\BSON\Regex($search, 'i')],
            ['supplier'         => new MongoDB\BSON\Regex($search, 'i')],
            ['usermaker'        => new MongoDB\BSON\Regex($search, 'i')],
            ['userupdate'       => new MongoDB\BSON\Regex($search, 'i')],
            ['created_at'       => new MongoDB\BSON\Regex($search, 'i')],
            ['updated_at'       => new MongoDB\BSON\Regex($search, 'i')],
            ['transaction_date' => new MongoDB\BSON\Regex($search, 'i')],
            ['status'           => new MongoDB\BSON\Regex($search, 'i')]
        ]];
        echo $this->Po_model->serverside($data);
    }
    public function realisasi($id)
    {
        $data['title'] = 'Realisasi PO - ' . $this->lang->line('copyright');
        $data['po'] = $this->Po_model->dataPO($id);
        $data['supplier'] = $this->aratadb->order_by(['name' => 'ASC'])->get('supplier');
        $this->load->model('Item_model');
        $allitem = $this->Item_model->get_items();
        $data['item'] = [];
        foreach (json_decode(json_encode($data['po'][0]['items']), true) as $all) {
            $key = array_search($all['id_item'], array_column($allitem, "_id"));
            if ($key !== false) {
                $all['weight'] = $allitem[$key]['weight'];
                $all['station'] = $allitem[$key]['station'];
                $all['hpp'] = $allitem[$key]['purchase_price']->last->price;
                $all['colorstation'] = (int)$all['station'] < 5 ? 'form-control-warning' : 'form-control-danger';
            }
            $data['item'][] = $all;
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('po/realisasi', $data);
        $this->load->view('templates/footer');
    }
    public function supplier()
    {
        $data['title'] = 'Input PO - ' . $this->lang->line('copyright');
        $data['heading'] = 'Input';
        $this->update(null, $data);
    }
    public function edit($id)
    {
        $data['title'] = 'Edit PO - ' . $this->lang->line('copyright');
        $data['heading'] = 'Edit';
        $this->update($id, $data);
    }
    public function duplicate($id)
    {
        $data['title'] = 'Duplicate PO - ' . $this->lang->line('copyright');
        $data['heading'] = 'Duplicate';
        $this->update($id, $data);
    }
    private function update($id, $data)
    {
        $data['supplier'] = $this->aratadb->order_by(['name' => 'ASC'])->get('supplier');
        $data['item'] = [];
        $data['po'] = [];
        if ($data['heading'] != 'Input') {
            $data['po'] = $this->Po_model->dataPO($id);
            if ($data['heading'] == 'Edit') {
                $data['idpo'] = $data['po'][0]['_id'];
            } else {
                $data['idpo'] = null;
            }
            $this->load->model('Item_model');
            $allitem = $this->Item_model->get_items();
            foreach (json_decode(json_encode($data['po'][0]['items']), true) as $all) {
                $key = array_search($all['id_item'], array_column($allitem, "_id"));
                if ($key !== false) {
                    $all['weight'] = $allitem[$key]['weight'];
                    $all['station'] = $allitem[$key]['station'];
                    $all['colorstation'] = (int)$all['station'] < 5 ? 'form-control-warning' : 'form-control-danger';
                }
                $data['item'][] = $all;
            }
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('po/edit', $data);
        $this->load->view('templates/footer');
    }
    function delete_po()
    {
        $update = $this->Po_model->deletePO($_POST['data']);
        echo json_encode($update);
    }
    public function po_excel($filter_date, $id)
    {
        $data['filter_date'] = $filter_date;
        $this->load->model('order_model');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Station');
        $sheet->setCellValue('C1', 'Nama Produk');
        $sheet->setCellValue('D1', 'Berat');
        $sheet->setCellValue('E1', 'Satuan');
        $sheet->setCellValue('F1', 'Catatan');
        $sheet->setCellValue('G1', 'Req');
        $sheet->setCellValue('H1', 'Total');
        $sheet->setCellValue('I1', 'PO Pembelian');
        $sheet->setCellValue('J1', 'Catatan PO');
        $sheet->setCellValue('K1', 'Stock Awal');
        $sheet->setCellValue('L1', 'Pembelian 1 (satuan)');
        $sheet->setCellValue('M1', 'Pembelian 1 (pack)');
        $sheet->setCellValue('N1', 'Pembelian 2 (satuan)');
        $sheet->setCellValue('O1', 'Pembelian 2 (pack)');
        $sheet->setCellValue('P1', 'Pembelian 3 (satuan)');
        $sheet->setCellValue('Q1', 'Pembelian 3 (pack)');
        $sheet->setCellValue('R1', 'Total Pembelian (pack)');
        $sheet->setCellValue('S1', 'Total Pembelian (satuan)');
        $sheet->setCellValue('T1', 'Req Total (pack)');
        $sheet->setCellValue('U1', 'Total Pembelian + Stock Awal');
        $sheet->setCellValue('V1', 'Total stock - request');
        $sheet->setCellValue('W1', 'Brg Siap Dijual (pack)');
        $sheet->setCellValue('X1', 'Sisa Stock (pack)');
        $sheet->setCellValue('Y1', 'Barang Reject (pack)');
        $sheet->setCellValue('Z1', 'Barang hilang (pack)');
        $sheet->setCellValue('AA1', '% Reject (pack)');
        $sheet->setCellValue('AB1', '% Hilang (pack)');
        $recap = $this->order_model->recap('onprocess', $filter_date);
        $this->load->model('Stock_model');
        $stock = $this->Stock_model->allStock('good');
        $result = [];
        foreach ($recap as $rec) {
            if ($rec['station'] == '5A' || $rec['station'] == '5B' || $rec['station'] == '5C') {
            } else {
                $key = array_search($rec['id_item'], array_column($stock, "_id"));
                $rec['stock_physic'] = $key !== false && $stock[$key]['stock'] > 0 ? $stock[$key]['stock'] : 0;
                $rec['stock_physic_weight'] = $rec['stock_physic'] * $rec['berat'];
                $result[$rec['id_item']] = $rec;
            }
        }
        $po = $this->Po_model->dataPO($id);
        foreach ($po[0]['items'] as $k => $val) {
            $resultpo[$val->id_item]['qty_unit'] = $val->qty_unit;
            $resultpo[$val->id_item]['po_notes'] = $val->notes;
            $resultpo[$val->id_item]['station'] = $result[$val->id_item]['station'];
            $resultpo[$val->id_item]['nama_produk'] = $result[$val->id_item]['nama_produk'];
            $resultpo[$val->id_item]['berat'] = $result[$val->id_item]['berat'];
            $resultpo[$val->id_item]['satuan'] = $result[$val->id_item]['satuan'];
            $resultpo[$val->id_item]['note'] = $result[$val->id_item]['note'];
            $resultpo[$val->id_item]['qty'] = $result[$val->id_item]['qty2'] ? $result[$val->id_item]['qty2'] : $result[$val->id_item]['qty'];
            $resultpo[$val->id_item]['total_berat'] = $result[$val->id_item]['total_berat'];
            $resultpo[$val->id_item]['stock_physic'] = $result[$val->id_item]['stock_physic'];
        }
        array_multisort(array_column($resultpo, 'station'), SORT_ASC, array_column($resultpo, 'nama_produk'), SORT_ASC, $resultpo);
        $no = 1;
        $x = 2;
        foreach ($resultpo as $data) {
            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, $data['station']);
            $sheet->setCellValue('C' . $x, $data['nama_produk']);
            $sheet->setCellValue('D' . $x, $data['berat']);
            $sheet->setCellValue('E' . $x, $data['satuan']);
            $sheet->setCellValue('F' . $x, $data['note']);
            $sheet->setCellValue('G' . $x, $data['qty']);
            $sheet->setCellValue('H' . $x, $data['total_berat']);
            $sheet->setCellValue('I' . $x, $data['qty_unit']);
            $sheet->setCellValue('J' . $x, $data['po_notes']);
            $sheet->setCellValue('K' . $x, $data['stock_physic']);
            $sheet->setCellValue('L' . $x, null);
            $sheet->setCellValue('M' . $x, null);
            $sheet->setCellValue('N' . $x, null);
            $sheet->setCellValue('O' . $x, null);
            $sheet->setCellValue('P' . $x, null);
            $sheet->setCellValue('Q' . $x, null);
            $sheet->setCellValue('R' . $x, null);
            $sheet->setCellValue('S' . $x, null);
            $sheet->setCellValue('T' . $x, null);
            $sheet->setCellValue('U' . $x, null);
            $sheet->setCellValue('V' . $x, null);
            $sheet->setCellValue('W' . $x, null);
            $sheet->setCellValue('X' . $x, null);
            $sheet->setCellValue('Y' . $x, null);
            $sheet->setCellValue('Z' . $x, null);
            $sheet->setCellValue('AA' . $x, null);
            $sheet->setCellValue('AB' . $x, null);
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'PO Rekap-' . $filter_date . '-' . date("H.i.s");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
    public function excel_buyer($filter_date, $id)
    {
        $this->load->model('order_model');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Buyer');
        $sheet->setCellValue('C1', 'Supplier');
        $sheet->setCellValue('D1', 'Nama Produk');
        $sheet->setCellValue('E1', 'Qty order/pack');
        $sheet->setCellValue('F1', 'PO Pembelian');
        $sheet->setCellValue('G1', 'Order');
        $sheet->setCellValue('H1', 'Harga');
        $recap = $this->order_model->recap('onprocess', $filter_date);
        $result = [];
        foreach ($recap as $rec) {
            if ($rec['station'] != '5A' || $rec['station'] != '5B' || $rec['station'] != '5C') {
                $result[$rec['id_item']] = $rec;
            }
        }
        $po = $this->Po_model->dataPO($id);
        foreach ($po[0]['items'] as $k => $val) {
            $resultpo[$val->id_item]['supplier'] = $result[$val->id_item]['supplier'];
            $resultpo[$val->id_item]['alias'] = $result[$val->id_item]['alias'] ? $result[$val->id_item]['alias'] : $result[$val->id_item]['nama_produk'];
            $resultpo[$val->id_item]['qty'] = $result[$val->id_item]['qty2'] ? $result[$val->id_item]['qty2'] : $result[$val->id_item]['qty'];
            $resultpo[$val->id_item]['qty_unit'] = $val->qty_unit;
            $resultpo[$val->id_item]['satuan'] = $result[$val->id_item]['satuan'];
        }
        array_multisort(array_column($resultpo, 'station'), SORT_ASC, array_column($resultpo, 'nama_produk'), SORT_ASC, $resultpo);
        $no = 1;
        $x = 2;
        foreach ($resultpo as $data) {
            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, null);
            $sheet->setCellValue('C' . $x, $data['supplier']);
            $sheet->setCellValue('D' . $x, $data['alias']);
            $sheet->setCellValue('E' . $x, $data['qty']);
            $sheet->setCellValue('F' . $x, $data['qty_unit']);
            $sheet->setCellValue('G' . $x, $data['qty_unit'] . $data['satuan']);
            $sheet->setCellValue('H' . $x, null);
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'PO Buyer-' . $filter_date . '-' . date("H.i.s");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
    public function excel($filter_date)
    {
        $data['filter_date'] = $filter_date;
        $this->load->model('order_model');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Supplier');
        $sheet->setCellValue('C1', 'SKU');
        $sheet->setCellValue('D1', 'Kategori');
        $sheet->setCellValue('E1', 'Nama Produk');
        $sheet->setCellValue('F1', 'Nama Alias');
        $sheet->setCellValue('G1', 'Qty order/pack');
        $sheet->setCellValue('H1', 'Berat');
        $sheet->setCellValue('I1', 'Total');
        $sheet->setCellValue('J1', 'Satuan');
        $sheet->setCellValue('K1', 'Catatan Produk');
        $sheet->setCellValue('L1', 'Current Stock/pack');
        $sheet->setCellValue('M1', 'Stock / satuan');
        $sheet->setCellValue('N1', 'Detail Qty');
        $sheet->setCellValue('O1', 'Input PO');
        $sheet->setCellValue('P1', 'Catatan PO');
        $sheet->setCellValue('Q1', 'Realisasi Total Beli');
        $sheet->setCellValue('R1', 'R. Satuan');
        $sheet->setCellValue('S1', 'R. Bayar (total)');
        $data['recap'] = $this->order_model->recap('onprocess', $filter_date);
        $poexisting = $this->Po_model->poexisting($data['filter_date']);
        foreach ($poexisting as $val) {
            foreach (json_decode(json_encode($val['items']), true) as $vali) {
                $rekappoitem[$vali['id_item']] = $vali;
            }
        }
        foreach ($data['recap'] as $val) {
            $rekapitem[] = $val;
            $input = (($val['qty'] - $val['stock_physic']) * $val['berat']) - $rekappoitem[$val['id_item']]['qty_unit'];
            $inputpo[$val['id_item']] = $input > 0 ? $input : 0;
            $notespo[$val['id_item']] = $rekappoitem[$val['id_item']]['notes'] ? $rekappoitem[$val['id_item']]['notes'] :  $val['note'];
        }
        array_multisort(array_column($data['recap'], 'supplier'), SORT_ASC, array_column($data['recap'], 'nama_produk'), SORT_ASC, $data['recap']);
        $no = 1;
        $x = 2;
        foreach ($data['recap'] as $data) {
            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, $data['supplier']);
            $sheet->setCellValue('C' . $x, $data['sku']);
            $sheet->setCellValue('D' . $x, $data['kategori']);
            $sheet->setCellValue('E' . $x, $data['nama_produk']);
            $sheet->setCellValue('F' . $x, $data['alias']);
            $sheet->setCellValue('G' . $x, $data['qty']);
            $sheet->setCellValue('H' . $x, $data['berat']);
            $sheet->setCellValue('I' . $x, $data['total_berat']);
            $sheet->setCellValue('J' . $x, $data['satuan']);
            $sheet->setCellValue('K' . $x, $data['note']);
            $sheet->setCellValue('L' . $x, $data['curr_stock']);
            $sheet->setCellValue('M' . $x, $data['stock_weight']);
            $sheet->setCellValue('N' . $x, $data['penerima_qty']);
            $sheet->setCellValue('O' . $x, $inputpo[$data['id_item']]);
            $sheet->setCellValue('P' . $x, null);
            $sheet->setCellValue('Q' . $x, null);
            $sheet->setCellValue('R' . $x, null);
            $sheet->setCellValue('S' . $x, null);
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'PO-' . $filter_date . '-' . date("H.i.s");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
    public function input()
    {
        $json = json_decode($_POST['data']);
        $result = $this->Po_model->inputpo($json);
        echo json_encode($result);
    }
}
