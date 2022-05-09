<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Counter_model extends CI_Model
{
    public function get_counter($invprefix = "ORDER")
    {
        $params['code'] = "ARATAMART";
        $params['invprefix'] = $invprefix;
        $params['year'] = intval(date('Y'));
        $params['month'] = intval(date('n'));
        $check = $this->mongo_db->where($params)->get('counter');
        if ($check) {
            $update['seq'] = intval($check[0]['seq']) + 1;
            $this->mongo_db->where($params)->set($update)->update('counter');
            $result =  str_pad($update['seq'], 4, '0', STR_PAD_LEFT);
        } else {
            $data = [
                "code"      => "ARATAMART",
                "invprefix" => $invprefix,
                "month"     => $params['month'],
                "year"      => $params['year'],
                "seq"       => 1
            ];
            $this->mongo_db->insert('counter', $data);
            $result = '0001';
        }
        return $result;
    }
}
