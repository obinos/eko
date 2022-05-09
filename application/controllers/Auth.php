<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library('mongo_db', array('activate' => 'arata'), 'aratadb');
        $this->lang->load('message', getenv("APP_BRAND"));
    }
    public function index()
    {
        if ($this->session->userdata('id')) {
            redirect('order');
        }
        $data['title'] = 'Login - ' . $this->lang->line('copyright');
        $this->load->view('templates/auth_header', $data);
        $this->load->view('auth/login');
        $this->load->view('templates/auth_footer');
    }
    public function check_auth()
    {
        $json = json_decode($_POST['data']);
        if ($json->action == 'login') {
            $update = $this->Auth_model->login($json);
        } elseif ($json->action == 'otp') {
            $update = $this->Auth_model->verifyOTP($json);
        } elseif ($json->action == 'pin') {
            $update = $this->Auth_model->verifyPIN($json);
        } elseif ($json->action == 'changeotp') {
            $update = $this->Auth_model->changeOTP($json);
        } elseif ($json->action == 'setpin') {
            $update = $this->Auth_model->setPIN($json);
        }
        echo json_encode($update);
    }
    public function otp()
    {
        if (!$this->session->userdata('otp_phone')) {
            redirect('auth');
        }
        $data['title'] = 'OTP - ' . $this->lang->line('copyright');
        $this->load->view('templates/auth_header', $data);
        $this->load->view('auth/otp');
        $this->load->view('templates/auth_footer');
    }
    public function pin()
    {
        if (!$this->session->userdata('otp_phone')) {
            redirect('auth');
        }
        $data['title'] = 'PIN - ' . $this->lang->line('copyright');
        $this->load->view('templates/auth_header', $data);
        $this->load->view('auth/pin');
        $this->load->view('templates/auth_footer');
    }
    public function setpin()
    {
        if (!$this->session->userdata('otp_phone')) {
            redirect('auth');
        }
        $data['title'] = 'SetPIN - ' . $this->lang->line('copyright');
        $this->load->view('templates/auth_header', $data);
        $this->load->view('auth/setpin');
        $this->load->view('templates/auth_footer');
    }
    public function check($data)
    {
        $all_user_prod = get_all_users();
        if ($data == 'email') {
            $email = $this->input->get_post('email');
            foreach ($all_user_prod['data']['users'] as $data) {
                if ($data['email'] == $email) {
                    $result_id = $data['_id'];
                }
            }
        } else {
            $phone_number = nohpplus($this->input->get_post('phone_number'));
            foreach ($all_user_prod['data']['users'] as $data) {
                if ($data['phone_number'] == $phone_number) {
                    $result_id = $data['_id'];
                }
            }
        }
        if ($result_id) {
            echo 'false';
        } else {
            echo 'true';
        }
    }
    public function logout()
    {
        session_destroy();
        sweetalert('Logout', 'berhasil', 'success');
        redirect('auth');
    }
    public function page_not_found()
    {
        $data['title'] = '404 - ' . $this->lang->line('copyright');
        $this->load->view('templates/auth_header', $data);
        $this->load->view('auth/page_not_found');
        $this->load->view('templates/auth_footer');
    }
    public function get_cohort($tgl = null)
    {
        $this->load->model('Report_model');
        $this->Report_model->getCohort($tgl);
    }
    public function delivery()
    {
        $date = date("Y-m-d");
        $startDate = $this->mongo_db->date(strtotime("$date") * 1000);
        $endDate = $this->mongo_db->date((strtotime("$date") + 86399) * 1000);
        $params['delivery_time']['$gte'] = $startDate;
        $params['delivery_time']['$lte'] = $endDate;

        $rute = $this->aratadb->where($params)->get('rute_courier');
        $wa = $rute[0]['wa'] ? $rute[0]['wa'] : 0;
        $cou['_id'] = $rute[0]['data'][$wa]->_id;
        $courier = $this->aratadb->where($cou)->get('courier');
        $courier_name = $courier[0]['name'] == 'Custom 2' ? 'Kurir' : $courier[0]['name'];
        $greeting = $courier[0]['phone'] == '333' ? "ordermu akan segera diberangkatkan.\nKira2" : "kurir ArataMart sudah berangkat.\nOrderanmu";
        $wa_courier = strlen($courier[0]['phone']) > 10 ? "atau langsung kontak ke kurir\nPak " . $courier_name . " : wa.me/" . nohp($courier[0]['phone']) : null;

        $order = (int)$rute[0]['data'][$wa]->order < 4 ? 4 : (int)$rute[0]['data'][$wa]->order;
        $hours1 = strtotime(date($rute[0]['data'][$wa]->time)) + 2400;
        $hours2 = $hours1 + ($order * 900);
        $hours = date('H:i', $hours1) . '-' . date('H:i', $hours2);

        $params['id_courier'] = $rute[0]['data'][$wa]->_id;
        $params['status'] = 'onprocess';
        $result['courier'] = $rute[0]['data'][$wa]->_id;
        $result['time'] = $rute[0]['data'][$wa]->time;
        $result['order'] = $this->aratadb->select(['customer', 'recipient'])->where($params)->get('orders');
        if ($result['courier']) {
            $params2['_id'] = $rute[0]['_id'];
            $update['wa'] = $wa + 1;
            $this->aratadb->where($params2)->set($update)->update('rute_courier');
            if ($result['order'] && $courier[0]['phone'] != '999') {
                $params3['code'] = 'delivery';
                $params3['app'] = 'whatsapp';
                $delivery = $this->mongo_db->where($params3)->get('message');
                foreach ($result['order'] as $phone) {
                    $customer = trim_wa($phone['customer']->name);
                    $recipient = $phone['customer']->phone == $phone['recipient']->phone ? null : ' ke _' . trim_wa($phone['recipient']->name) . '_';
                    $search = array('$customer', '$greeting', '$recipient', '$hours', '$wa_courier');
                    $replace = array($customer, $greeting, $recipient, $hours, $wa_courier);
                    $message = str_replace($search, $replace, $delivery[0]['message']);
                    // log_message('error', $message);
                    // wablas('6281230038999', $message);
                    wablas($phone['customer']->phone, $message);
                }
                // echo json_encode($result);
            }
        }
    }
    public function warningprofit()
    {
        $logo['1'] = '🌿';
        $logo['2'] = '🌶️';
        $logo['3'] = '🍆';
        $logo['4'] = '🐓';
        $logo['5A'] = '🥫';
        $logo['5B'] = '🍎';
        $logo['5C'] = '🥩';
        $params['role'] = 'warningprofit';
        $params['is_active'] = true;
        $idtelegram = $this->mongo_db->select('id_telegram')->order_by(['id_telegram' => 'ASC'])->where($params)->get('telegram');
        if ($idtelegram) {
            $params2['code'] = 'warningprofit';
            $params2['app'] = 'telegram';
            $message = $this->mongo_db->where($params2)->get('message');
            $text = $message[0]['message'];
            $params3['merchant'] = '606eba1c099777608a38aeda';
            $params3['active'] = true;
            $params3['$nor'] = [['profit_min' => null], ['profit_min' => 0], ['profit_max' => null], ['profit_max' => 0], ['purchase_price' => null]];
            $pipeline = [
                ['$match' => ['$and' => [$params3]]],
                ['$project' => ['lowername' => ['$toLower' => '$name'], 'name' => '$name', 'price' => '$price', 'sales_price' => '$sales_price', 'station' => '$station', 'purchase_price' => '$purchase_price', 'profit_best' => '$profit_best', 'profit_min' => '$profit_min', 'profit_max' => '$profit_max']],
                ['$sort'  => ['station' => 1, 'lowername' => 1]]
            ];
            $item = $this->aratadb->aggregate('items', $pipeline);
            if ($item) {
                foreach ($item as $i) {
                    $newitem[$i['station']][] = $i;
                }
                foreach ($newitem as $key => $val) {
                    $no = 1;
                    $text = $text . "\n<b>Station: " . $key . $logo[$key] . "</b>\n";
                    foreach ($val as $v) {
                        $price = $v['sales_price'] ? $v['sales_price'] : $v['price'];
                        $hpp = $v['purchase_price']->avg_price ? $v['purchase_price']->avg_price : $v['purchase_price']->last->price;
                        $profit = round((($price - $hpp) / $price) * 100, 2);
                        if ($profit < $v['profit_min'] || $profit > $v['profit_max']) {
                            $icon = $profit < $v['profit_min'] ? "🔴" : "🟢";
                            $result = $no++ . '. ' . $v['name'] . ' = ' . $profit . "%$icon\n";
                            $text = $text . $result;
                        }
                        if (strlen($text) > 3500) {
                            $datatext[] = $text;
                            $text = "";
                        }
                    }
                }
                $datatext[] = $text;
                foreach ($idtelegram as $id) {
                    foreach ($datatext as $finaltext) {
                        send_telegram($id['id_telegram'], $finaltext);
                    }
                }
            }
        }
    }
    public function bufferstock()
    {
        $params['role'] = 'bufferstock';
        $params['is_active'] = true;
        $idtelegram = $this->mongo_db->select('id_telegram')->order_by(['id_telegram' => 'ASC'])->where($params)->get('telegram');
        if ($idtelegram) {
            $params2['code'] = 'bufferstock';
            $params2['app'] = 'telegram';
            $message = $this->mongo_db->where($params2)->get('message');
            $this->load->model('Stock_model');
            $stock = $this->Stock_model->dataBufferStock();
            $text = $message[0]['message'];
            foreach ($stock as $s => $val) {
                $supplier = "\n<b>Supplier: " . $s . "</b>\n";
                $text = $text . $supplier;
                $no = 1;
                foreach ($val as $v) {
                    $item = $no++ . '. ' . $v['name'] . ' (' . $v['stock'] . ")\n";
                    $text = $text . $item;
                }
                if (strlen($text) > 3000) {
                    $datatext[] = $text;
                    $text = "";
                }
            }
            $datatext[] = $text;
            foreach ($idtelegram as $id) {
                foreach ($datatext as $finaltext) {
                    send_telegram($id['id_telegram'], $finaltext);
                }
            }
        }
    }
    public function yesterdayorder()
    {
        $params['role'] = 'yesterdayorder';
        $params['is_active'] = true;
        $idtelegram = $this->mongo_db->select('id_telegram')->order_by(['id_telegram' => 'ASC'])->where($params)->get('telegram');
        if ($idtelegram) {
            $params2['code'] = 'yesterdayorder';
            $params2['app'] = 'telegram';
            $message = $this->mongo_db->where($params2)->get('message');
            $this->load->model('order_model');
            // yesterday
            $array1['start'] = date('Y-m-d');
            $order = $this->order_model->chart_sum_order($array1);
            $oms = $order[0]['omset'] ? $order[0]['omset'] : 0;
            $ord = $order[0]['order'] ? $order[0]['order'] : 0;
            $avgorder = $oms && $ord ? ceil($order[0]['omset'] / $order[0]['order']) : 0;
            $cust = $order[0]['new_customer'] ? $order[0]['new_customer'] : 0;
            // last 7 day
            $array2['start'] = date('Y-m-d', strtotime('-7 days'));
            $order7 = $this->order_model->chart_sum_order($array2);
            $oms7 = $order7[0]['omset'] ? $order7[0]['omset'] : 0;
            $ord7 = $order7[0]['order'] ? $order7[0]['order'] : 0;
            $avgorder7 = $oms7 && $ord7 ? ceil($order7[0]['omset'] / $order7[0]['order']) : 0;
            $cust7 = $order7[0]['new_customer'] ? $order7[0]['new_customer'] : 0;
            // yesterday vs last 7 day
            $diff_omset = $oms7 ? round((($oms - $oms7) / $oms7) * 100, 2) : 0;
            $diff_order = $ord7 ? round((($ord - $ord7) / $ord7) * 100, 2) : 0;
            $diff_avg = $avgorder7 ? round((($avgorder - $avgorder7) / $avgorder7) * 100, 2) : 0;
            $diff_cust = $cust7 ? round((($cust - $cust7) / $cust7) * 100, 2) : 0;
            // this month
            $array3['start'] = date('Y-m') . '-01';
            $array3['end'] = date('Y-m-d');
            $ordermonth = $this->order_model->chart_sum_order($array3);
            $total_date = count($ordermonth);
            $total_omset_ordermonth = $ordermonth ? array_sum(array_column($ordermonth, 'omset')) : 0;
            $total_order_ordermonth = $ordermonth ? array_sum(array_column($ordermonth, 'order')) : 0;
            $avgordermonth = $total_omset_ordermonth && $total_omset_ordermonth ? ceil($total_omset_ordermonth / $total_order_ordermonth) : 0;
            $avg_omset_ordermonth = $total_omset_ordermonth && $total_date ? ceil($total_omset_ordermonth / $total_date) : 0;
            $avg_order_ordermonth = $total_order_ordermonth && $total_date ? ceil($total_order_ordermonth / $total_date) : 0;
            $total_new_customermonth = $ordermonth ? array_sum(array_column($ordermonth, 'new_customer')) : 0;
            // last month
            $array4['start'] = date('Y-m', strtotime('-1 month')) . '-01';
            $array4['end'] = date('Y-m-d', strtotime('-1 month'));
            $orderlastmonth = $this->order_model->chart_sum_order($array4);
            $total_date_last = count($orderlastmonth);
            $total_omset_orderlastmonth = $orderlastmonth ? array_sum(array_column($orderlastmonth, 'omset')) : 0;
            $total_order_orderlastmonth = $orderlastmonth ? array_sum(array_column($orderlastmonth, 'order')) : 0;
            $avgorderlastmonth = $total_omset_orderlastmonth && $total_order_orderlastmonth ? ceil($total_omset_orderlastmonth / $total_order_orderlastmonth) : 0;
            $avg_omset_orderlastmonth = $total_omset_orderlastmonth && $total_date_last ? ceil($total_omset_orderlastmonth / $total_date_last) : 0;
            $avg_order_orderlastmonth = $total_order_orderlastmonth && $total_date_last ? ceil($total_order_orderlastmonth / $total_date_last) : 0;
            $total_new_customerlastmonth = $orderlastmonth ? array_sum(array_column($orderlastmonth, 'new_customer')) : 0;
            // this month vs last month
            $diff_avg_omsetmonth = $avg_omset_orderlastmonth ? round((($avg_omset_ordermonth - $avg_omset_orderlastmonth) / $avg_omset_orderlastmonth) * 100, 2) : 0;
            $diff_avg_ordermonth = $avg_order_orderlastmonth ? round((($avg_order_ordermonth - $avg_order_orderlastmonth) / $avg_order_orderlastmonth) * 100, 2) : 0;
            $diff_avgordermonth = $avgorderlastmonth ? round((($avgordermonth - $avgorderlastmonth) / $avgorderlastmonth) * 100, 2) : 0;
            $diff_omset_ordermonth = $total_omset_orderlastmonth ? round((($total_omset_ordermonth - $total_omset_orderlastmonth) / $total_omset_orderlastmonth) * 100, 2) : 0;
            $diff_order_ordermonth = $total_order_orderlastmonth ? round((($total_order_ordermonth - $total_order_orderlastmonth) / $total_order_orderlastmonth) * 100, 2) : 0;
            $diff_new_customermonth = $total_new_customerlastmonth ? round((($total_new_customermonth - $total_new_customerlastmonth) / $total_new_customerlastmonth) * 100, 2) : 0;

            $text = "<b>" . dateindo(strtotime(date('Y-m-d')) * 1000, 'd M Y') . " (vs " . date('d M', strtotime('-7 days')) . ")</b>\n<code>" . addSpaces('Revenue', 13) . ": " . rupiah($oms) . " ($diff_omset%)\n" . addSpaces('Jml Order', 13) . ": " . $ord . " ($diff_order%)\n" . addSpaces('AvgBasketSize', 13) . ": " . rupiah($avgorder) . " ($diff_avg%)\n" . addSpaces('New Cust', 13) . ": $cust ($diff_cust%)</code>\n\n<b>Month to date (vs last month)</b>\n<code>" . addSpaces('Revenue', 13) . ": " . rupiah($total_omset_ordermonth) . " ($diff_omset_ordermonth%)\n" . addSpaces('Jml Order', 13) . ": " . thousand($total_order_ordermonth) . " ($diff_order_ordermonth%)\n" . addSpaces('AvgBasketSize', 13) . ": " . rupiah($avgordermonth) . " ($diff_avgordermonth%)\n" . addSpaces('Avg Rev/Day', 13) . ": " . rupiah($avg_omset_ordermonth) . " ($diff_avg_omsetmonth%)\n" . addSpaces('Avg JO/Day', 13) . ": $avg_order_ordermonth ($diff_avg_ordermonth%)\n" . addSpaces('New Cust', 13) . ": $total_new_customermonth ($diff_new_customermonth%)</code>";
            $finaltext = str_replace('$data', $text, $message[0]['message']);
            foreach ($idtelegram as $id) {
                send_telegram($id['id_telegram'], $finaltext);
            }
        }
    }
    public function stationorder()
    {
        $params['role'] = 'stationorder';
        $params['is_active'] = true;
        $params['$nor'] = [['id_telegram' => null]];
        $idtelegram = $this->mongo_db->select('id_telegram')->order_by(['id_telegram' => 'ASC'])->where($params)->get('telegram');
        if ($idtelegram) {
            $params2['code'] = 'stationorder';
            $params2['app'] = 'telegram';
            $message = $this->mongo_db->where($params2)->get('message');
            $this->load->model('order_model');
            // now
            $data['filter_status'] = ['onprocess'];
            $recap = $this->order_model->recap($data['filter_status']);
            if ($recap) {
                foreach ($recap as $val) {
                    $newrecap[$val['station']][] = $val;
                }
                ksort($newrecap);
                foreach ($newrecap as $key1 => $val1) {
                    $result[$key1]['qty'] = array_sum(array_column($val1, 'qty'));
                    $result[$key1]['price'] = array_sum(array_column($val1, 'price'));
                }
                $text1 = "<b>" . dateindo(strtotime('now') * 1000, 'd M Y') . "</b>\n";
                //old week
                $data_old['filter_status'] = ['closed'];
                $data_old['start'] = date('Y-m-d', strtotime('-7 days'));
                $data_old['start'] = date('Y-m-d');
                $recap_old = $this->order_model->recap($data_old['filter_status'], $data_old['start'], $data_old['start']);
                foreach ($recap_old as $val) {
                    $newrecap_old[$val['station']][] = $val;
                }
                ksort($newrecap_old);
                foreach ($newrecap_old as $key3 => $val3) {
                    $result_old[$key3]['qty'] = ceil(array_sum(array_column($val3, 'qty')) / 7);
                    $result_old[$key3]['price'] = ceil(array_sum(array_column($val3, 'price')) / 7);
                }
                $text3 = "<b>Rata-rata 7 hari terakhir\n" . date('d M', strtotime('-7 days')) . ' - ' . date('d M Y') . "</b>\n";
                foreach ($result_old as $key4 => $val4) {
                    $text3 = "$text3<b>Station: $key4</b>\n<code>Nominal   : " . rupiah($val4['price']) . "\nTotal Qty : " . $val4['qty'] . "</code>\n";
                }
                foreach ($result as $key2 => $val2) {
                    $diff_price = round((($val2['price'] - $result_old[$key2]['price']) / $result_old[$key2]['price']) * 100, 2) . '%';
                    $diff_qty = round((($val2['qty'] - $result_old[$key2]['qty']) / $result_old[$key2]['qty']) * 100, 2) . '%';
                    $text1 = "$text1<b>Station: $key2</b>\n<code>Nominal   : " . rupiah($val2['price']) . " ($diff_price)\nTotal Qty : " . $val2['qty'] . " ($diff_qty)</code>\n";
                }
                $finaltext1 = str_replace('$data', $text1, $message[0]['message']) . "\n" . $text3;
                foreach ($idtelegram as $id) {
                    send_telegram($id['id_telegram'], $finaltext1);
                }
            }
        }
    }
    public function stationorder2()
    {
        $icon['1'] = '🌿';
        $icon['2'] = '🌶️';
        $icon['3'] = '🍆';
        $icon['4'] = '🐓';
        $icon['5A'] = '🥫';
        $icon['5B'] = '🍎';
        $icon['5C'] = '🥩';
        $params['role'] = 'stationorder2';
        $params['is_active'] = true;
        $params['$or'] = [['id_telegram' => null]];
        $whatsapp = $this->mongo_db->select('phone')->where($params)->get('telegram');
        unset($params['$or']);
        $params['$nor'] = [['id_telegram' => null]];
        $idtelegram = $this->mongo_db->select('id_telegram')->order_by(['id_telegram' => 'ASC'])->where($params)->get('telegram');
        if ($idtelegram) {
            $params2['code'] = 'stationorder';
            $params2['app'] = 'telegram';
            $message = $this->mongo_db->where($params2)->get('message');
            $this->load->model('order_model');
            // now
            $data['filter_status'] = ['onprocess'];
            $recap = $this->order_model->recap($data['filter_status']);
            $startDate = $this->mongo_db->date(strtotime(date('Y-m-d')) * 1000);
            $endDate = $this->mongo_db->date((strtotime(date('Y-m-d')) + 86399) * 1000);
            $count_order = $this->mongo_db->where(['status' => 'onprocess', 'merchant' => '606eba1c099777608a38aeda'])->count('orders');
            $count_order_yest = $this->mongo_db->where(['status' => 'closed', 'merchant' => '606eba1c099777608a38aeda', 'delivery_time' => ['$gte' => $startDate, '$lte' => $endDate]])->count('orders');
            $co_yest = $count_order_yest ? "(kemarin $count_order_yest)" : null;
            if ($recap) {
                foreach ($recap as $val) {
                    $newrecap[$val['station']][] = $val;
                }
                ksort($newrecap);
                foreach ($newrecap as $key1 => $val1) {
                    $result[$key1]['qty'] = array_sum(array_column($val1, 'qty'));
                    $result[$key1]['price'] = array_sum(array_column($val1, 'price'));
                }
                $datenow = dateindo(strtotime('now') * 1000, 'd M Y');
                $text2 = "<b>" . $datenow . "</b>\nJumlah Pesanan: $count_order $co_yest\n\nJumlah pack yang diproses:\n";
                $text4 = "*$datenow*\nJumlah Pesanan: $count_order $co_yest\n\nJumlah pack yang diproses:\n";
                //yesterday
                $data_yest['start'] = date('Y-m-d');
                $data_yest['filter_status'] = ['closed'];
                $recap_yest = $this->order_model->recap($data_yest['filter_status'], $data_yest['start'], $data_yest['end']);
                foreach ($recap_yest as $val) {
                    $newrecap_yest[$val['station']][] = $val;
                }
                foreach ($newrecap_yest as $key3 => $val3) {
                    $result_yest[$key3]['qty'] = array_sum(array_column($val3, 'qty'));
                }
                foreach ($result as $key2 => $val2) {
                    $result_yest_qty = $result_yest[$key2]['qty'] ? " (kemarin " . $result_yest[$key2]['qty'] . ")" : null;
                    $text2 = "$text2<b>Station: $key2 " . $icon[$key2] . "</b>\n<code>Total Qty : " . $val2['qty'] . $result_yest_qty . "</code>\n";
                    $text4 = "$text4*Station: $key2 " . $icon[$key2] . "*\n```Total Qty : " . $val2['qty'] . $result_yest_qty . "```\n";
                }

                $finaltext2 = str_replace('$data', $text2, $message[0]['message']);
                $finaltext3 = "📢 *Report Order Proses per Station*\n\n" . $text4;
                foreach ($idtelegram as $id) {
                    send_telegram($id['id_telegram'], $finaltext2);
                }
                foreach ($whatsapp as $wa) {
                    wablas($wa['phone'], $finaltext3);
                }
            }
        }
    }
    public function profit()
    {
        $startDate = $this->mongo_db->date(strtotime(date('Y-m-d')) * 1000);
        $endDate = $this->mongo_db->date((strtotime(date('Y-m-d')) + 86399) * 1000);
        $params1['delivery_time']['$gte'] = $startDate;
        $params1['delivery_time']['$lte'] = $endDate;
        $params1['merchant'] = $params2['merchant'] = '606eba1c099777608a38aeda';
        $params1['status'] = 'closed';
        $orders = $this->aratadb->where($params1)->get('orders');
        if ($orders) {
            $params2['active'] = true;
            $items = $this->aratadb->where($params2)->get('items');
            $params['role'] = 'profit';
            $params['is_active'] = true;
            $params['$nor'] = [['id_telegram' => null]];
            $idtelegram = $this->mongo_db->select('id_telegram')->order_by(['id_telegram' => 'ASC'])->where($params)->get('telegram');
            $params3['code'] = 'profit';
            $params3['app'] = 'telegram';
            $message = $this->mongo_db->where($params3)->get('message');
            foreach ($orders as $order) {
                foreach ($order['items'] as $key => $val) {
                    $groupitems[$val->id_item][] = $val;
                }
            }
            foreach ($groupitems as $key => $item) {
                $col = array_search($key, array_column($items, "_id"));
                $station = $col !== false ? $items[$col]['station'] : null;
                $newitem['id'] = $key;
                $newitem['name'] = $item[0]->name;
                $newitem['station'] = $station;
                $newitem['qty'] = array_sum(array_column($item, 'qty'));
                $newitem['price'] = $item[0]->price;
                $newitem['hpp'] = $col !== false ? $items[$col]['purchase_price']->avg_price : 0;
                $newitem['totalprice'] = $newitem['qty'] * $newitem['price'];
                $newitem['totalhpp'] = $newitem['qty'] * $newitem['hpp'];
                if ($station) {
                    $finalitem[$station][] = $newitem;
                }
            }
            ksort($finalitem);
            foreach ($finalitem as $key => $val) {
                $data['totalprice'] = array_sum(array_column($val, 'totalprice'));
                $data['totalhpp'] = array_sum(array_column($val, 'totalhpp'));
                $data['profit'] = round(($data['totalprice'] - $data['totalhpp']) / $data['totalprice'] * 100, 2) . '%';
                $result[$key] = $data;
            }
            $totalprice = 0;
            $totalhpp = 0;
            foreach ($result as $key => $val) {
                $totalprice = $totalprice + $val['totalprice'];
                $totalhpp = $totalhpp + $val['totalhpp'];
                $val['station'] = $key;
                $detail[] = $val;
            }
            $profit = round(($totalprice - $totalhpp) / $totalprice * 100, 2) . '%';
            $insert = [
                "_id"        => (string) new MongoDB\BSON\ObjectId(),
                "created_at" => new MongoDB\BSON\UTCDateTime((new DateTime(date('Y-m-d')))->getTimestamp() * 1000),
                "detail"     => $detail,
                "totalprice" => $totalprice,
                "totalhpp"   => $totalhpp,
                "profit"     => $profit
            ];
            $this->aratadb->insert('profit', $insert);
            $result['all']['totalprice'] = $totalprice;
            $result['all']['totalhpp'] = $totalhpp;
            $result['all']['profit'] = $profit;
            $text = "<b>" . dateindo(strtotime('now') * 1000, 'd M Y') . "</b>\n";
            foreach ($result as $key => $val) {
                $text = $text . "Station: $key\n<code>" . addSpaces('Total Harga', 12) . ": " . rupiah($val['totalprice']) . "\n" . addSpaces('Total HPP', 12) . ": " . rupiah($val['totalhpp']) . "\n" . addSpaces('Profit', 12) . ": " . $val['profit'] . "</code>\n";
            }
            $finaltext = str_replace('$data', $text, $message[0]['message']);
            foreach ($idtelegram as $id) {
                send_telegram($id['id_telegram'], $finaltext);
            }
        }
    }
    public function new_customer()
    {
        $date =  date("Y-m-d", strtotime('tomorrow'));
        $this->load->model('order_model');
        $order = $this->order_model->all_order_delivery($date, $date, 'onprocess');
        if ($order) {
            $params['role'] = 'newcustomer';
            $params['is_active'] = true;
            $params['$nor'] = [['id_telegram' => null]];
            $idtelegram = $this->mongo_db->select('id_telegram')->order_by(['id_telegram' => 'ASC'])->where($params)->get('telegram');
            $params3['code'] = 'newcustomer';
            $params3['app'] = 'telegram';
            $message = $this->mongo_db->where($params3)->get('message');
            foreach ($order as $res) {
                $phone[] = ['customer.phone' => $res['customer']->phone];
            }
            $pipeline = [
                ['$match' => ['$and' => [['$or' => $phone, '$nor' => [['status' => 'canceled']], 'merchant' => '606eba1c099777608a38aeda']]]],
                ['$group' => ['_id' => '$customer.phone', 'count' => ['$sum' => 1]]],
                ['$group' => ['_id' => '$count', 'total' => ['$sum' => 1]]]
            ];
            $count = $this->aratadb->aggregate('orders', $pipeline);
            foreach ($count as $val) {
                $result[$val['_id']] = $val['total'];
            }
        }
        $customer1 = $result[1] ? 'NEW : ' . $result[1] . ' Customer' : 'NEW : 0 Customer';
        $customer2 = $result[2] ? 'TWO : ' . $result[2] . ' Customer' : 'TWO : 0 Customer';
        $customer3 = $result[3] ? 'THREE : ' . $result[3] . ' Customer' : 'THREE : 0 Customer';
        $text = $customer1 . "\n" . $customer2 . "\n" . $customer3;
        $finaltext = str_replace('$data', $text, $message[0]['message']);
        foreach ($idtelegram as $id) {
            send_telegram($id['id_telegram'], $finaltext);
        }
    }
    public function sync_stock()
    {
        $params['active'] = true;
        $params['stock_managed'] = true;
        $params['$or'] = [['stock_default' => ''], ['stock_default' => '0'], ['stock_default' => null]];
        $params['merchant'] = '606eba1c099777608a38aeda';
        $result = $this->aratadb->select(['_id', 'name', 'active', 'stock', 'barcode', 'stock_default', 'purchase_price', 'station'])->order_by(['station' => 'ASC'])->where($params)->get('items');
        $this->load->model('Stock_model');
        $array['condition'] = 'good';
        $resultcondition = $this->Stock_model->totalStock($array);
        $array_stock['status'] = ['open', 'onprocess'];
        $stocks = $this->Stock_model->stockOrder($array_stock);
        foreach ($stocks as $v) {
            $resultstock[$v['id_item']] = $v['qty'];
        }
        foreach ($result as $res) {
            $qty = $resultstock[$res['_id']] ? $resultstock[$res['_id']] : 0;
            if ($res['qty'] + $qty !== $resultcondition[$res['_id']]['good']) {
                $good = $resultcondition[$res['_id']]['good'] - $qty >= 0 ? $resultcondition[$res['_id']]['good'] - $qty : 0;
                $stock_item['stock'] = round($good, 2);
                $params3['_id'] = $res['_id'];
                $this->aratadb->where($params3)->set($stock_item)->update('items');
                $update[$res['_id']] = $res['name'];
            }
        }
    }
}
