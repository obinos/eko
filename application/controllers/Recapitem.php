<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Recapitem extends CI_Controller
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
        if ($_POST) {
            $data['filter_status'] = $this->input->post('filter_status');
            $data['filter_start'] = $this->input->post('filter_start');
            $data['filter_end'] = $this->input->post('filter_end');
        } else {
            $data['filter_status'] = ['open', 'onprocess'];
            $data['filter_start'] = null;
            $data['filter_end'] = null;
        }
        $data['title'] = 'Rekap Produk - ' . $this->lang->line('copyright');
        $data['status'] = [
            "open"      => "Baru",
            "onprocess" => "Proses",
            "closed"    => "Selesai",
            "canceled"  => "Batal"
        ];
        $data['recap'] = $this->order_model->recap($data['filter_status'], $data['filter_start'], $data['filter_end']);
        array_multisort(array_column($data['recap'], 'station'), SORT_ASC, array_column($data['recap'], 'nama_produk'), SORT_ASC, $data['recap']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('recapitem/index', $data);
        $this->load->view('templates/footer');
    }
    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'SKU');
        $sheet->setCellValue('C1', 'Station');
        $sheet->setCellValue('D1', 'Nama Produk');
        $sheet->setCellValue('E1', 'Qty order/pack');
        $sheet->setCellValue('F1', 'Detail Qty');
        $recap = $this->order_model->recap($_POST['excel_status'], $_POST['excel_start'], $_POST['excel_end']);
        array_multisort(array_column($recap, 'station'), SORT_ASC, array_column($recap, 'nama_produk'), SORT_ASC, $recap);
        $no = 1;
        $x = 2;
        foreach ($recap as $data) {
            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, $data['sku']);
            $sheet->setCellValue('C' . $x, $data['station']);
            $sheet->setCellValue('D' . $x, $data['nama_produk']);
            $sheet->setCellValue('E' . $x, $data['qty']);
            $sheet->setCellValue('F' . $x, $data['penerima']);
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'Recap Produk ' . date("d-m-Y H.i.s");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
