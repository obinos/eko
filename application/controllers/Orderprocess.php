<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orderprocess extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('order_model');
        $this->load->model('Settings_model');
        $this->load->model('Rute_model');
        $this->load->model('Po_model');
        $this->load->model('Item_model');
        $this->lang->load('message', getenv("APP_BRAND"));
        $this->start = ['05:30', '05:35', '05:40', '05:45', '05:50', '05:55', '06:00'];
        is_logged_in();
        is_session_1jam();
    }
    public function invoice()
    {
        if ($_POST) {
            $data['filter_date'] = $this->input->post('filter_date');
        } elseif ($_GET) {
            $data['filter_date'] = $this->input->get('filter_date');
        } else {
            $data['filter_date'] = date("d-m-Y", strtotime('tomorrow'));
        }
        $data['order'] = $this->order_model->all_order_packinglist($data['filter_date']);
        $data['title'] = 'Data Invoice - ' . $this->lang->line('copyright');
        $data['message'] = $this->mongo_db->get('message');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('orderprocess/invoice/index', $data);
        $this->load->view('templates/footer');
    }
    public function cluster()
    {
        $data['title'] = 'Data Order - ' . $this->lang->line('copyright');
        if ($_POST) {
            $data['filter_date'] = $this->input->post('filter_date');
        } elseif ($_GET) {
            $data['filter_date'] = $this->input->get('filter_date');
        } else {
            $data['filter_date'] = date("d-m-Y", strtotime('tomorrow'));
        }
        $this->load->model('Cluster_model');
        $data['cluster'] = $this->Cluster_model->dataCluster();
        $order = $this->order_model->all_order_delivery($data['filter_date'], $data['filter_date'], 'open_onprocess');
        $data['order'] = [];
        if ($order) {
            foreach ($order as $res) {
                $phone[] = ['customer.phone' => $res['customer']->phone];
            }
            $pipeline = [
                ['$match' => ['$and' => [['$or' => $phone, '$nor' => [['status' => 'canceled']], 'merchant' => '606eba1c099777608a38aeda']]]],
                ['$group' => ['_id' => '$customer.phone', 'count' => ['$sum' => 1]]]
            ];
            $count = $this->aratadb->aggregate('orders', $pipeline);
            foreach ($order as $val) {
                $key = array_search($val['customer']->phone, array_column($count, "_id"));
                $val['new_customer'] = $key !== false ? $count[$key]['count'] : null;
                $data['order'][$val['shipping']][] = $val;
            }
        }
        krsort($data['order']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('orderprocess/cluster/index', $data);
        $this->load->view('templates/footer');
    }
    public function update_cluster()
    {
        $json = json_decode($_POST['data']);
        $update = $this->order_model->inputCluster($json);
        echo json_encode($update);
    }
    public function courier()
    {
        if ($_POST) {
            $data['filter_date'] = $this->input->post('filter_date');
        } elseif ($_GET) {
            $data['filter_date'] = $this->input->get('filter_date');
        } else {
            $data['filter_date'] = date("d-m-Y", strtotime('tomorrow'));
        }
        $data['title'] = 'Data Order - ' . $this->lang->line('copyright');
        $data['order'] = $this->order_model->all_order_cluster($data['filter_date']);
        $data['kurir'] = $this->order_model->sum_courier($data['filter_date']);
        $data['courier'] = $this->aratadb->order_by(['order' => 'ASC'])->get('courier');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('orderprocess/courier/index', $data);
        $this->load->view('templates/footer');
    }
    public function input_courier()
    {
        $json = json_decode($_POST['data']);
        $result = $this->order_model->inputCourier($json);
        echo json_encode($result);
    }
    public function rute($menu)
    {
        if ($menu == 'rute_input') {
            if ($_POST) {
                $data['filter_date'] = $this->input->post('filter_date');
            } elseif ($_GET) {
                $data['filter_date'] = $this->input->get('filter_date');
            } else {
                $data['filter_date'] = date("d-m-Y", strtotime('tomorrow'));
            }
            $data['title'] = 'Rute Kurir - ' . $this->lang->line('copyright');
            $courier = $this->order_model->ruteCourier($data['filter_date']);
            $no = 0;
            foreach ($courier as $c) {
                $data['courier'][$no++ % 3][] = $c;
            }
            $data['start'] = $this->start;
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('orderprocess/rute/input', $data);
            $this->load->view('templates/footer');
        } else if ($menu == 'rute_list') {
            $data['title'] = 'Rute Kurir - ' . $this->lang->line('copyright');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('orderprocess/rute/list', $data);
            $this->load->view('templates/footer');
        }
    }
    public function print($menu)
    {
        if ($menu == 'courier') {
            if ($_POST) {
                $data['filter_date'] = $this->input->post('filter_date');
                $data['filter_station'] = $this->input->post('filter_station');
            } else {
                $data['filter_date'] = date("d-m-Y", strtotime('tomorrow'));
                $data['filter_station'] = ['5A'];
            }
            $data['title'] = 'Print Kurir - ' . $this->lang->line('copyright');
            $data['print'] = $this->order_model->RecapCourierItem($data['filter_date'], $data['filter_station']);
            $data['station'] = $this->Item_model->getStation();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('orderprocess/print/courier', $data);
            $this->load->view('templates/footer');
            // } elseif ($menu == 'po') {
            //     if ($_POST) {
            //         $data['filter_date'] = $this->input->post('filter_date');
            //     } else {
            //         $data['filter_date'] = date("d-m-Y", strtotime('tomorrow'));
            //     }
            //     $data['title'] = 'Print PO - ' . $this->lang->line('copyright');
            //     $data['recap'] = $this->order_model->recap('onprocess', $data['filter_date']);
            //     $this->load->view('templates/header', $data);
            //     $this->load->view('templates/sidebar');
            //     $this->load->view('templates/topbar');
            //     $this->load->view('orderprocess/print/po', $data);
            //     $this->load->view('templates/footer');
        } elseif ($menu == 'stocker') {
            if ($_POST) {
                $data['filter_date'] = $this->input->post('filter_date');
            } else {
                $data['filter_date'] = date("d-m-Y", strtotime('tomorrow'));
            }
            $data['title'] = 'Print Stocker - ' . $this->lang->line('copyright');
            $data['recap'] = $this->order_model->recap('onprocess', $data['filter_date']);
            foreach ($data['recap'] as $item) {
                if ($item['station']) {
                    $arr[$item['station']][] = $item;
                } else {
                    $arr['No Station'][] = $item;
                }
            }
            ksort($arr);
            $data['station'] = $arr;
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('orderprocess/print/stocker', $data);
            $this->load->view('templates/footer');
        } elseif ($menu == 'station') {
            if ($_POST) {
                $data['filter_date'] = $this->input->post('filter_date');
            } else {
                $data['filter_date'] = date("d-m-Y", strtotime('tomorrow'));
            }
            $data['title'] = 'Print Station - ' . $this->lang->line('copyright');
            $data['recap'] = $this->order_model->recap('onprocess', $data['filter_date']);
            foreach ($data['recap'] as $item) {
                if ($item['station']) {
                    $arr[$item['station']][] = $item;
                } else {
                    $arr['No Station'][] = $item;
                }
            }
            unset($arr['5A'], $arr['5B'], $arr['5C']);
            ksort($arr);
            $data['station'] = $arr;
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('orderprocess/print/station', $data);
            $this->load->view('templates/footer');
        } elseif ($menu == 'rekap') {
            if ($_POST) {
                $data['filter_date'] = $this->input->post('filter_date');
            } else {
                $data['filter_date'] = date("d-m-Y", strtotime('tomorrow'));
            }
            $data['title'] = 'Print Rekap - ' . $this->lang->line('copyright');
            $data['recap'] = $this->order_model->recap('onprocess', $data['filter_date']);
            foreach ($data['recap'] as $item) {
                if ($item['station']) {
                    $arr[$item['station']][] = $item;
                } else {
                    $arr['No Station'][] = $item;
                }
            }
            unset($arr['5A'], $arr['5B'], $arr['5C']);
            ksort($arr);
            $data['station'] = $arr;
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('orderprocess/print/rekap', $data);
            $this->load->view('templates/footer');
        }
    }
    public function edit_rute($id)
    {
        $data['title'] = 'Rute Kurir - ' . $this->lang->line('copyright');
        $data['rute'] = $this->Rute_model->dataRute(null, $id);
        $data['start'] = $this->start;
        foreach ($data['rute'][0]['data'] as $k => $rute) {
            $data['rak'][$rute->status][] = $rute;
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('orderprocess/rute/edit', $data);
        $this->load->view('templates/footer');
    }
    public function update_rute()
    {
        $json = json_decode($_POST['data']);
        if ($json->_id) {
            $result = $this->Rute_model->editRute($json);
        } else {
            $result = $this->Rute_model->addRute($json);
        }
        echo json_encode($result);
    }
    public function delete_rute()
    {
        $update = $this->Rute_model->deleteRute($_POST['data']);
        echo json_encode($update);
    }
    public function get_data()
    {
        $search = $_POST['search']['value'];
        $data['where_search'] = ['$or' => [
            ['maker' => new MongoDB\BSON\Regex($search, 'i')]
        ]];
        echo $this->Rute_model->serverside($data);
    }
    public function wa_courier()
    {
        if ($_POST) {
            $data['filter_date'] = $this->input->post('filter_date');
        } elseif ($_GET) {
            $data['filter_date'] = $this->input->get('filter_date');
        } else {
            $data['filter_date'] = date("d-m-Y", strtotime('tomorrow'));
        }
        $data['title'] = 'WA Kurir - ' . $this->lang->line('copyright');
        $data['courier'] = $this->order_model->waCourier($data['filter_date'], null, null, 'text');
        $data['hpcourier'] = $this->aratadb->order_by(['order' => 'ASC'])->get('courier');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('orderprocess/wa/index', $data);
        $this->load->view('templates/footer');
    }
    public function send_wa_courier()
    {
        wablas(nohp($_POST['hp']), $_POST['textwa']);
        // wablas($this->session->userdata('phone'), $_POST['textwa']);
    }
}
