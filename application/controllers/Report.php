<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Report_model');
        $this->load->model('order_model');
        $this->lang->load('message', getenv("APP_BRAND"));
    }
    public function cluster()
    {
        $data['title'] = 'Report Cluster - ' . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('report/cluster', $data);
        $this->load->view('templates/footer');
    }
    public function courier()
    {
        if ($_POST) {
            $data['filter_date'] = $this->input->post('filter_date');
        } elseif ($_GET) {
            $data['filter_date'] = $this->input->get('filter_date');
        } else {
            $data['filter_date'] = date("Y-m-d", strtotime('now'));
        }
        $data['title'] = 'Kurir - ' . $this->lang->line('copyright');
        $data['courier'] = $this->order_model->waCourier($data['filter_date'], null, 'closed');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('report/courier', $data);
        $this->load->view('templates/footer');
    }
    public function get_cluster()
    {
        $cluster = $this->Report_model->reportCluster();
        echo json_encode($cluster);
    }
    public function cohort()
    {
        $data['title'] = 'Cohort Analysis - ' . $this->lang->line('copyright');
        $data['trx1'] = $this->mongo_db->order_by(['created_at' => 'ASC'])->get_where('arata_cohort', ['filter' => 'trx1']);
        if ($data['trx1']) {
            $data['count_trx1'] = count($data['trx1'][0]) - 5;
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('report/cohort', $data);
        $this->load->view('templates/footer');
    }
    public function order()
    {
        if ($this->session->userdata('role') == 'viewer') {
            redirect('blocked');
        }
        $data['status'] = [
            "open"      => "Order Baru",
            "onprocess" => "Order Diproses",
            "closed"    => "Order Terkirim",
            "canceled"  => "Order Batal"
        ];
        $data['title'] = 'Data Order - ' . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('report/order/index', $data);
        $this->load->view('templates/footer');
    }
    public function order_excel()
    {
        ini_set('memory_limit', '2048M');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No. Transaksi');
        $sheet->setCellValue('B1', 'Tgl Transaksi');
        $sheet->setCellValue('C1', 'Pelanggan');
        $sheet->setCellValue('D1', 'Phone');
        $sheet->setCellValue('E1', 'Alamat');
        $sheet->setCellValue('F1', 'Kota / Kabupaten');
        $sheet->setCellValue('G1', 'Kodepos');
        $sheet->setCellValue('H1', 'Catatan Penjual');
        $sheet->setCellValue('I1', 'SKU');
        $sheet->setCellValue('J1', 'Produk');
        $sheet->setCellValue('K1', 'Jml Produk');
        $sheet->setCellValue('L1', 'Harga');
        $sheet->setCellValue('M1', 'Pengiriman');
        $sheet->setCellValue('N1', 'Tgl Kirim');
        $sheet->setCellValue('O1', 'Pembayaran');
        $sheet->setCellValue('P1', 'Voucher');
        $sheet->setCellValue('Q1', 'Diskon');
        $sheet->setCellValue('R1', 'Total Harga');
        $sheet->setCellValue('S1', 'Refund');
        $sheet->setCellValue('T1', 'Internal Note');
        $recap = $this->order_model->report_order_delivery($_POST['filter_start'], $_POST['filter_end'], $_POST['filter_status']);
        $x = 2;
        foreach ($recap as $data) {
            $sheet->setCellValue('A' . $x, $data['invno']);
            $sheet->setCellValue('B' . $x, datephp('d-m-Y', $data['transaction_date']));
            $sheet->setCellValue('C' . $x, $data['customer_name']);
            $sheet->setCellValue('D' . $x, $data['customer_phone']);
            $sheet->setCellValue('E' . $x, $data['recipient_address']);
            $sheet->setCellValue('F' . $x, $data['recipient_city']);
            $sheet->setCellValue('G' . $x, $data['recipient_kodepos']);
            $sheet->setCellValue('H' . $x, $data['merchant_notes']);
            $sheet->setCellValue('I' . $x, $data['sku']);
            $sheet->setCellValue('J' . $x, $data['item_name']);
            $sheet->setCellValue('K' . $x, $data['item_qty']);
            $sheet->setCellValue('L' . $x, $data['item_price']);
            $sheet->setCellValue('M' . $x, $data['shipping']);
            $sheet->setCellValue('N' . $x, datephp('d-m-Y', $data['delivery_time']));
            $sheet->setCellValue('O' . $x, $data['payment']);
            $sheet->setCellValue('P' . $x, $data['voucher']);
            $sheet->setCellValue('Q' . $x, $data['discount']);
            $sheet->setCellValue('R' . $x, $data['total']);
            $sheet->setCellValue('S' . $x, $data['refund']);
            $sheet->setCellValue('T' . $x, $data['internal_notes']);
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'Rekap Order-' . $_POST['filter_start'] . '#' . $_POST['filter_end'] . '#' . $_POST['filter_status'] . '#' . date("H.i.s");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
    public function payment_excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No. Transaksi');
        $sheet->setCellValue('B1', 'Tgl Transaksi');
        $sheet->setCellValue('C1', 'Tgl Kirim');
        $sheet->setCellValue('D1', 'Pelanggan');
        $sheet->setCellValue('E1', 'Phone');
        $sheet->setCellValue('F1', 'Payment Method');
        $sheet->setCellValue('G1', 'Payment Amount');
        $sheet->setCellValue('H1', 'Tgl Bayar');
        $sheet->setCellValue('I1', 'Ongkir');
        $sheet->setCellValue('J1', 'Diskon');
        $sheet->setCellValue('K1', 'Total');
        $recap = $this->order_model->report_payment($_POST['filter_start'], $_POST['filter_end'], $_POST['filter_status']);
        $x = 2;
        foreach ($recap as $data) {
            $sheet->setCellValue('A' . $x, $data['invno']);
            $sheet->setCellValue('B' . $x, datephp('d-m-Y', $data['transaction_date']));
            $sheet->setCellValue('C' . $x, datephp('d-m-Y', $data['delivery_time']));
            $sheet->setCellValue('D' . $x, $data['customer_name']);
            $sheet->setCellValue('E' . $x, $data['customer_phone']);
            $sheet->setCellValue('F' . $x, $data['payment_method']);
            $sheet->setCellValue('G' . $x, $data['payment_amount']);
            $sheet->setCellValue('H' . $x, datephp('d-m-Y', $data['paid_at']));
            $sheet->setCellValue('I' . $x, $data['shipping']);
            $sheet->setCellValue('J' . $x, $data['discount']);
            $sheet->setCellValue('K' . $x, $data['total']);
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'Rekap Payment-' . $_POST['filter_start'] . '#' . $_POST['filter_end'] . '#' . $_POST['filter_status'] . '#' . date("H.i.s");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
    public function purchase_excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No. Purchase');
        $sheet->setCellValue('B1', 'Tgl Transaksi');
        $sheet->setCellValue('C1', 'Supplier');
        $sheet->setCellValue('D1', 'Operator');
        $sheet->setCellValue('E1', 'Catatan');
        $sheet->setCellValue('F1', 'SKU');
        $sheet->setCellValue('G1', 'Produk');
        $sheet->setCellValue('H1', 'Qty Beli');
        $sheet->setCellValue('I1', 'Qty Pack');
        $sheet->setCellValue('J1', 'Harga Satuan');
        $sheet->setCellValue('K1', 'Total Harga');
        $sheet->setCellValue('L1', 'Total');
        $sheet->setCellValue('M1', 'Status');
        $recap = $this->Report_model->report_purchase($_POST['filter_start'], $_POST['filter_end']);
        $x = 2;
        foreach ($recap as $data) {
            $sheet->setCellValue('A' . $x, $data['no']);
            $sheet->setCellValue('B' . $x, datephp('d-m-Y', $data['transaction_date']));
            $sheet->setCellValue('C' . $x, $data['supplier']);
            $sheet->setCellValue('D' . $x, $data['who_update']);
            $sheet->setCellValue('E' . $x, $data['notes']);
            $sheet->setCellValue('F' . $x, $data['sku']);
            $sheet->setCellValue('G' . $x, $data['name']);
            $sheet->setCellValue('H' . $x, $data['qty_unit']);
            $sheet->setCellValue('I' . $x, $data['qty']);
            $sheet->setCellValue('J' . $x, $data['price']);
            $sheet->setCellValue('K' . $x, $data['total_price']);
            $sheet->setCellValue('L' . $x, $data['total']);
            $sheet->setCellValue('M' . $x, $data['status']);
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'Rekap Purchase-' . $_POST['filter_start'] . '#' . $_POST['filter_end'] . '#' . $_POST['filter_status'] . '#' . date("H.i.s");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
