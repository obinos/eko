<?php

require APPPATH . 'libraries/REST_Controller.php';

class Apis extends REST_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('order_model');
    $this->load->model('Settings_model');
  }
  public function allpackinglist_get()
  {
    $date = $this->get('date');
    if ($date) {
      $order = $this->order_model->all_order_packinglist($date);
      if ($order) {
        $this->response([
          'status' => true,
          'message' => 'List all order.',
          'data' => $order,
        ], 200);
      } else {
        $this->response([
          'status' => false,
          'message' => 'No such order found.'
        ], 404);
      }
    } else {
      $this->response([
        'status' => false,
        'message' => 'Paramater date cannot be empty.'
      ], 404);
    }
  }
  public function allpackinglist2_get()
  {
    $date = $this->get('date');
    if ($date) {
      $order = $this->order_model->all_order_packinglist2($date);
      if ($order) {
        $this->response([
          'status' => true,
          'message' => 'List all order.',
          'data' => $order,
        ], 200);
      } else {
        $this->response([
          'status' => false,
          'message' => 'No such order found.'
        ], 404);
      }
    } else {
      $this->response([
        'status' => false,
        'message' => 'Paramater date cannot be empty.'
      ], 404);
    }
  }
  public function allpackinglistcourier_get()
  {
    $date = $this->get('date');
    $id = $this->get('id');
    if ($date) {
      if ($id) {
        $order = $this->order_model->waCourier($date, $id);
      } else {
        $order = $this->order_model->waCourier($date);
      }
      if ($order) {
        $new_res = [];
        foreach ($order as $res) {
          $new_recipient = [];
          foreach ($res['recipient'] as $key => $val) {
            $params2['merchant'] = '606eba1c099777608a38aeda';
            $params2['customer.phone'] = $val->customer_phone;
            $params2['$nor'] = [['status' => "canceled"]];
            $dt = $this->aratadb->where($params2)->get('orders');
            $val->new_customer = count($dt);
            $new_recipient[] = $val;
          }
          unset($res['recipient']);
          $res['recipient'] = $new_recipient;
          $new_res[] = $res;
        }
        $this->response([
          'status' => true,
          'message' => 'List all order.',
          'data' => $new_res
        ], 200);
      } else {
        $this->response([
          'status' => false,
          'message' => 'No such order found.'
        ], 404);
      }
    } else {
      $this->response([
        'status' => false,
        'message' => 'Paramater date cannot be empty.'
      ], 404);
    }
  }
  public function viewreset_get()
  {
    $id = $this->get('id');
    if ($id) {
      $params['no_reset'] = $id;
      $reset = $this->mongo_db->where($params)->get('reset');
      $params2['_id'] = $reset[0]['id_store'];
      $warehouse = $this->mongo_db->where($params2)->get('warehouse');
      $params3['_id'] = $reset[0]['id_user'];
      $posuser = $this->mongo_db->where($params3)->get('posuser');
      $result['reset'] = $reset[0];
      $result['warehouse'] = $warehouse[0];
      $result['posuser'] = $posuser[0];
      if ($result['reset']) {
        $this->response([
          'status' => true,
          'message' => 'Data Reset.',
          'data' => $result,
        ], 200);
      } else {
        $this->response([
          'status' => false,
          'message' => 'No such order found.'
        ], 404);
      }
    } else {
      $this->response([
        'status' => false,
        'message' => 'Paramater id cannot be empty.'
      ], 404);
    }
  }
  public function viewkasawal_get()
  {
    $id = $this->get('id');
    if ($id) {
      $params['_id'] = $id;
      $warehouse = $this->mongo_db->where($params)->get('warehouse');
      $params2['code'] = 'INITIAL_CASH';
      $params2['id_store'] = $id;
      $nominal = $this->mongo_db->where($params2)->get('config');
      $result['warehouse'] = $warehouse[0];
      $result['nominal'] = thousand($nominal[0]['val']);
      if ($result['nominal']) {
        $this->response([
          'status' => true,
          'message' => 'Data Kas Awal.',
          'data' => $result,
        ], 200);
      } else {
        $this->response([
          'status' => false,
          'message' => 'No such order found.'
        ], 404);
      }
    } else {
      $this->response([
        'status' => false,
        'message' => 'Paramater id cannot be empty.'
      ], 404);
    }
  }
  public function vieworderpos_get()
  {
    $id = $this->get('id');
    $id_store = $this->get('id_store');
    if ($id && $id_store) {
      $order = $this->order_model->order_packinglist($id);
      $params['_id'] = $id_store;
      $warehouse = $this->mongo_db->where($params)->get('warehouse');
      $params2['$or'] = [['code' => 'FOOTER_INVOICE1'], ['code' => 'FOOTER_INVOICE2']];
      $params2['id_store'] = $id_store;
      $footer = $this->mongo_db->where($params2)->get('config');
      $result['order'] = $order[0];
      $result['warehouse'] = $warehouse[0];
      $result['footer'] = $footer;
      if ($order) {
        $this->response([
          'status' => true,
          'message' => 'Detail order.',
          'data' => $result,
        ], 200);
      } else {
        $this->response([
          'status' => false,
          'message' => 'No such order found.'
        ], 404);
      }
    } else {
      $this->response([
        'status' => false,
        'message' => 'Paramater id cannot be empty.'
      ], 404);
    }
  }
  public function viewpackinglist_get()
  {
    $id = $this->get('id');
    if ($id) {
      $order = $this->order_model->order_packinglist($id);
      if ($order) {
        $this->response([
          'status' => true,
          'message' => 'Detail order.',
          'data' => $order,
        ], 200);
      } else {
        $this->response([
          'status' => false,
          'message' => 'No such order found.'
        ], 404);
      }
    } else {
      $this->response([
        'status' => false,
        'message' => 'Paramater id cannot be empty.'
      ], 404);
    }
  }
  public function viewlabelsticker_get()
  {
    $id = $this->get('id');
    if ($id) {
      $order = $this->order_model->label_sticker($id);
      if ($order) {
        $this->response([
          'status' => true,
          'message' => 'Detail order.',
          'data' => $order,
        ], 200);
      } else {
        $this->response([
          'status' => false,
          'message' => 'No such order found.'
        ], 404);
      }
    } else {
      $this->response([
        'status' => false,
        'message' => 'Paramater id cannot be empty.'
      ], 404);
    }
  }
  public function rutecourier_get()
  {
    $id = $this->get('id') == 'null' ? null : $this->get('id');
    $date = $this->get('date') == 'null' ? null : $this->get('date');
    if ($date || $id) {
      $this->load->model('Rute_model');
      $rute = $this->Rute_model->dataRute($date, $id);
      if ($rute) {
        $this->response([
          'status' => true,
          'message' => 'List all rute.',
          'data' => $rute,
        ], 200);
      } else {
        $this->response([
          'status' => false,
          'message' => 'No such rute found.'
        ], 404);
      }
    } else {
      $this->response([
        'status' => false,
        'message' => 'Paramater date cannot be empty.'
      ], 404);
    }
  }
}
