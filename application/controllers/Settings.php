<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Settings_model');
        $this->lang->load('message', getenv("APP_BRAND"));
        is_logged_in();
        is_session_1jam();
        $this->role = ['viewer', 'admin', 'finance', 'sales'];
    }
    public function courier()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'Data Kurir - ' . $this->lang->line('copyright');
        $data['courier'] = $this->Settings_model->dataCourier();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('settings/courier/index', $data);
        $this->load->view('templates/footer');
    }
    function delete_courier($id)
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $this->Settings_model->deleteCourier($id);
        sweetalert('Data Kurir', 'berhasil dihapus', 'success');
        redirect('settings/courier/index');
    }
    public function edit_courier($id)
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        if ($_POST) {
            $array['id'] = strtoupper(htmlspecialchars($this->input->post('id', true)));
            $array['order'] = (int) $this->input->post('order');
            $array['name'] = ucwords(strtolower(htmlspecialchars($this->input->post('name', true))));
            $array['phone'] = nohpplus($this->input->post('phone'));
            $this->Settings_model->editCourier($array);
            sweetalert('Data Kurir', 'berhasil diupdate', 'success');
            redirect('settings/courier/index');
        }
        $data['title'] = 'Edit Kurir - ' . $this->lang->line('copyright');
        $data['courier'] = $this->Settings_model->dataCourier($id);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('settings/courier/edit', $data);
        $this->load->view('templates/footer');
    }
    public function add_courier()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        if ($_POST) {
            $array['id'] = strtoupper(htmlspecialchars($this->input->post('id', true)));
            $array['order'] = (int) $this->input->post('order');
            $array['name'] = ucwords(strtolower(htmlspecialchars($this->input->post('name', true))));
            $array['phone'] = nohpplus($this->input->post('phone'));
            $this->Settings_model->addcourier($array);
            sweetalert('Data Kurir', 'berhasil ditambahkan', 'success');
            redirect('settings/courier/index');
        }
        $data['title'] = 'Tambah Kurir - ' . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('settings/courier/add', $data);
        $this->load->view('templates/footer');
    }
    public function apiauth()
    {
        $data['title'] = 'Data API Auth - ' . $this->lang->line('copyright');
        $data['user'] = $this->mongo_db->order_by(['created_at' => 'DESC'])->get('apiauth');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('settings/apiauth/index', $data);
        $this->load->view('templates/footer');
    }
    public function add_apiauth()
    {
        if ($_POST) {
            $this->Settings_model->addApiAuth();
            sweetalert('Data API', 'berhasil ditambahkan', 'success');
            redirect('settings/apiauth/index');
        }
        $data['title'] = 'Tambah API Auth - ' . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('settings/apiauth/add');
        $this->load->view('templates/footer');
    }
    public function edit_apiauth($id)
    {
        if ($_POST) {
            $this->Settings_model->editApiAuth();
            sweetalert('Data API Auth', 'berhasil diupdate', 'success');
            redirect('settings/apiauth/index');
        }
        $data['title'] = 'Edit API Auth - ' . $this->lang->line('copyright');
        $data['api'] = $this->mongo_db->get_where('apiauth', ['_id' => check_id($id)]);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('settings/apiauth/edit', $data);
        $this->load->view('templates/footer');
    }
    public function delete_apiauth($id)
    {
        $this->mongo_db->where(['_id' => new MongoDB\BSON\ObjectID($id)])->delete('apiauth');
        sweetalert('Data API Auth', 'berhasil dihapus', 'success');
        redirect('settings/apiauth/index');
    }
    public function qris()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'Data Super User - ' . $this->lang->line('copyright');
        $data['message'] = $this->mongo_db->get('message');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('settings/qris/index', $data);
        $this->load->view('templates/footer');
    }
    function upload_qris()
    {
        $config['upload_path']   = './assets/uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 3000;
        $config['file_name']     = 'QRIS';
        $config['overwrite']     = TRUE;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('userfile')) {
            $path = $this->upload->data('file_name');
            resize($this->upload->data(), 'qris');
            $this->mongo_db->set(['qris' => $path])->update('message');
            sweetalert('Image QRIS', 'berhasil diupload', 'success');
            redirect('settings/qris');
        } else {
            sweetalert('Image QRIS', 'gagal diupload', 'error');
            redirect('settings/qris');
        }
    }
    function delete_qris($img = null)
    {
        if (getimagesize(base_url('assets/uploads/' . $img)) !== false) {
            unlink("./assets/uploads/$img");
            $this->mongo_db->set(['qris' => null])->update('message');
            sweetalert('Image QRIS', 'berhasil dihapus', 'success');
            redirect('settings/qris');
        } else {
            sweetalert('Image QRIS', 'tidak ada', 'error');
            redirect('settings/qris');
        }
    }
    public function banner()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'Banner - ' . $this->lang->line('copyright');
        $banner = $this->Settings_model->allBanner();
        foreach ($banner as $val) {
            $data['banner' . $val['urut']] = $val['image'];
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('settings/banner/index', $data);
        $this->load->view('templates/footer');
    }
    function upload_banner($no)
    {
        $config['upload_path']   = getenv("PATH_BANNER");
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 3000;
        $config['file_name']     = time();
        $config['overwrite']     = TRUE;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('userfile')) {
            $path = $this->upload->data('file_name');
            resize($this->upload->data(), 'banner');
            $this->Settings_model->updateBanner($path, (int)$no);
            sweetalert('Image Banner', 'berhasil diupload', 'success');
            redirect('settings/banner');
        } else {
            sweetalert('Image Banner', 'gagal diupload', 'error');
            redirect('settings/banner');
        }
    }
    function delete_banner($img = null)
    {
        if ($img) {
            $base64_img = base64_decode($img);
            $arr_img = explode("/", $base64_img);
            if (getimagesize(getenv("URL_IMG") . $base64_img) !== false) {
                unlink(getenv("PATH_BANNER") . '/' . $arr_img[2]);
                $this->Settings_model->deleteBanner($base64_img);
                sweetalert('Image Banner', 'berhasil dihapus', 'success');
                redirect('settings/banner');
            } else {
                sweetalert('Image Banner', 'tidak ada', 'error');
                redirect('settings/banner');
            }
        }
    }
    public function item_recom()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'Item Recom - ' . $this->lang->line('copyright');
        $data['item'] = $this->Settings_model->dataItemRecom();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('settings/itemrecom/index', $data);
        $this->load->view('templates/footer');
    }
    public function update_itemrecom()
    {
        if ($_POST['id_item']) {
            $array['id_item'] = $_POST['id_item'];
        }
        $array['urut'] = (int)$_POST['urut'];
        $result = $this->Settings_model->updateItemRecom($array);
        echo json_encode($result);
    }
    public function item_package()
    {
        if ($this->session->userdata('role') != 'admin') {
            redirect('blocked');
        }
        $data['title'] = 'Item Recom - ' . $this->lang->line('copyright');
        $params['merchant'] = '606eba1c099777608a38aeda';
        $params['id_category'] = getenv("ID_PAKET");
        $params['active'] = true;
        $data['item'] = $this->aratadb->order_by(['name' => 'ASC'])->where($params)->get('items');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('settings/itempackage/index', $data);
        $this->load->view('templates/footer');
    }
    public function add_item_package($id)
    {
        $data['title'] = 'Input Stock Opname - ' . $this->lang->line('copyright');
        $params['merchant'] = '606eba1c099777608a38aeda';
        $params['active'] = true;
        $items = $this->aratadb->order_by(['name' => 'ASC'])->where($params)->get('items');
        $params['id_category'] = getenv("ID_PAKET");
        $params['_id'] = $id;
        $data['item'] = $this->aratadb->where($params)->get('items');
        $data['composition'] = [];
        if ($data['item'][0]['composition']) {
            foreach ($data['item'][0]['composition'] as $keys => $val) {
                $key = array_search($val->id_item, array_column($items, "_id"));
                if ($key !== false) {
                    $i['id_item'] = $val->id_item;
                    $i['name'] = $items[$key]['name'];
                    $i['qty'] = $val->qty;
                    $i['unit'] = $items[$key]['weight_unit'];
                }
                $data['composition'][] = $i;
            }
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('settings/itempackage/add', $data);
        $this->load->view('templates/footer');
    }
    public function update_item_package()
    {
        $json = json_decode($_POST['data']);
        if ($json->item) {
            $result = $this->Settings_model->editItemPackage($json);
        } else {
            $result['status'] = 'failed';
            $result['text'] = 'Produk Tidak Boleh Kosong';
        }
        echo json_encode($result);
    }
    public function data_item()
    {
        $params['merchant'] = '606eba1c099777608a38aeda';
        $params['active'] = true;
        $result = $this->aratadb->where($params)->get('items');
        echo json_encode($result, true);
    }
}
