<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hpp extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Hpp_model');
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
            $data['filter_supplier'] = $this->input->post('filter_supplier');
        } else {
            $data['filter_supplier'] = null;
        }
        $data['title'] = 'List Item - ' . $this->lang->line('copyright');
        $data['supplier'] = $this->aratadb->order_by(['name' => 'ASC'])->get('supplier');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('hpp/index', $data);
        $this->load->view('templates/footer');
    }
    public function print($filter_supplier = null)
    {
        $data['title'] = 'Data HPP - ' . $this->lang->line('copyright');
        if ($filter_supplier) {
            $where['id_supplier'] = $filter_supplier;
        }
        $where['$nor'] = [['_id' => null]];
        $where['merchant'] = '606eba1c099777608a38aeda';
        $pipeline = [
            ['$lookup' => [
                'from' => 'supplier',
                'localField' => 'id_supplier',
                'foreignField' => '_id',
                'as' => 'supplier'
            ]],
            ['$match' => ['$and' => [['merchant' => '606eba1c099777608a38aeda']]]],
            ['$project' => ['lowername' => ['$toLower' => '$name'], 'barcode' => '$barcode', 'name' => '$name', 'active' => '$active', 'merchant' => '$merchant', 'price' => '$sales_price', 'id_supplier' => '$id_supplier', 'supplier' => ['$arrayElemAt' => ['$supplier.name', 0]], 'station' => '$station', 'hpp' => ['$ifNull' => ['$purchase_price.last.price', null]]]],
            ['$match' => ['$and' => [$where]]],
            ['$project' => ['lowername' => ['$toLower' => '$name'], 'barcode' => '$barcode', 'name' => '$name', 'active' => '$active', 'price' => '$price', 'id_supplier' => '$id_supplier', 'supplier' => '$supplier', 'station' => '$station', 'hpp' => '$hpp', 'percentage' => ['$cond' => ['if' => ['$gte' => ['$price', 1]], 'then' => ['$concat' => [['$toString' => ['$round' => [['$multiply' => [['$divide' => [['$subtract' => ['$price', '$hpp']], '$price']], 100]], 2]]], '%']], 'else' => null]]]],
            ['$sort' => ['lowername' => 1]]
        ];
        $data['result'] = $this->aratadb->aggregate('items', $pipeline);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('hpp/print', $data);
        $this->load->view('templates/footer');
    }
    public function get_data()
    {
        $search = $_POST['search']['value'];
        $data['supplier'] = $this->input->get_post('supplier');
        $data['where_search'] = ['$or' => [
            ['barcode'  => new MongoDB\BSON\Regex($search, 'i')],
            ['name'     => new MongoDB\BSON\Regex($search, 'i')],
            ['supplier' => new MongoDB\BSON\Regex($search, 'i')],
            ['station'  => new MongoDB\BSON\Regex($search, 'i')]
        ]];
        echo $this->Hpp_model->serverside($data);
    }
}
