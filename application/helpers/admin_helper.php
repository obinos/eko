<?php
function trim_wa($data = null)
{
    $result = ltrim(rtrim(str_replace('&', 'dan', ucwords($data))));
    return $result;
}
function total_order_courier($data)
{
    if (strpos($data, '/') !== false) {
        return (int)substr($data, strpos($data, "/") + 1);
    } else {
        return (int)$data;
    }
}
function payment_method()
{
    return ['BCA', 'Mandiri', 'OVO', 'GOPAY', 'SHOPEEPAY', 'QRIS', 'CREDITCARD', 'COD'];
}
function remove_icon($data)
{
    $string = preg_replace('/[^^a-zA-Z0-9#@:$%&+=<>?*_(),.!"\/\- ]/', '', $data);
    return $string;
}
function filter_status($array, $data)
{
    if (is_array($array)) {
        foreach ($array as $val) {
            if ($val == $data) {
                return 'checked';
            }
        }
    }
}
function check_boolean($data, $field = null)
{
    if ($data === true) {
        return '<svg width="22" height="22" fill="#8ab661" viewBox="0 0 16 16">
        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
      </svg>';
    } elseif ($data === false && $field == 'is_bestseller') {
        return null;
    } elseif ($data === false) {
        return '<svg width="22" height="22" fill="#fd8664" viewBox="0 0 16 16">
        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
      </svg>';
    }
}
function count_courier($data)
{
    if ((int)$data < 7) {
        return 'table-warning';
    } elseif ((int)$data <= 9) {
        return 'table-success';
    } elseif ((int)$data > 9) {
        return 'table-danger';
    }
}
function count_cust_ord($data)
{
    if ((int)$data == 1) {
        return 'table-success';
    } elseif ((int)$data == 2) {
        return 'table-warning';
    } elseif ((int)$data == 3) {
        return 'table-danger';
    } else {
        return null;
    }
}
function total_courier($data)
{
    if ((int)$data > 1900000) {
        return 'table-danger';
    }
}
function sum_index($arr, $from)
{
    $sum = 0;
    if (is_array($arr)) {
        if ($from == 'api') {
            foreach ($arr as $item) {
                $sum += $item['price']['total'];
            }
        } else {
            foreach ($arr as $item) {
                $sum += $item['price']->total;
            }
        }
    }
    return thousand($sum);
}
function check_COD($data)
{
    foreach ($data as $val) {
        if (strpos($val['method'], 'COD') !== false) {
            $result = 'COD: ' . thousand($val['payment_amount']);
        }
    }
    return $result;
}
function warning_courier($data)
{
    if (strpos($data, 'COD') !== false) {
        return 'table-warning';
    } elseif ($data >= 400000) {
        return 'table-warning';
    } else {
        return null;
    }
}
function check_price($price, $sale)
{
    if ($price > $sale) {
        return "strike";
    } else {
        return null;
    }
}
function internal_notes($data)
{
    if ($data) {
        return 'table-warning';
    } else {
        return null;
    }
}
function first_word($data)
{
    $result = preg_split("/[-\s:]/", $data);
    return $result[0];
}
function payment_string($data, $tipe = null)
{
    if (!empty($data)) {
        foreach (json_decode(json_encode($data), true) as $val) {
            $payment = preg_split("/[-\s:]/", $val['method']);
            if ($tipe == 'nominal') {
                $result[] = $payment[0] . ' (' . thousand($val['payment_amount']) . ')';
            } else {
                $result[] = $payment[0];
            }
        }
        return implode(", ", $result);
    } else {
        return null;
    }
}
function nominal_inv($data)
{
    $char = 7 - strlen($data);
    for ($i = 0; $i < $char; $i++) {
        $data = ' ' . $data;
    }
    return $data;
}
function send_telegram($id, $text)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, getenv("URL_TELEGRAM") . '/sendMessage?chat_id=' . $id . '&text=' . urlencode($text) . '&parse_mode=html');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
}
function all_packinglist_courier($date, $id = null)
{
    $ch = curl_init(getenv("API_URL_ADMIN") . "/allpackinglistcourier/?date=$date&id=$id");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'key: ' . getenv("API_KEY_ADMIN"),
            'Authorization: Basic ' . getenv("API_AUTH_ADMIN")
        )
    );
    $order = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($order, true);
    if ($data['status'] == 'true') {
        $status = $data['data'];
    } else {
        $status = $data['status'];
    }
    return $status;
}
function rute_courier($date, $id = null)
{
    $ch = curl_init(getenv("API_URL_ADMIN") . "/rutecourier/?date=$date&id=$id");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'key: ' . getenv("API_KEY_ADMIN"),
            'Authorization: Basic ' . getenv("API_AUTH_ADMIN")
        )
    );
    $order = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($order, true);
    if ($data['status'] == 'true') {
        $status = $data['data'];
    } else {
        $status = $data['status'];
    }
    return $status;
}
function all_packinglist($date)
{
    $ch = curl_init(getenv("API_URL_ADMIN") . "/allpackinglist/?date=$date");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'key: ' . getenv("API_KEY_ADMIN"),
            'Authorization: Basic ' . getenv("API_AUTH_ADMIN")
        )
    );
    $order = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($order, true);
    if ($data['status'] == 'true') {
        $status = $data['data'];
    } else {
        $status = $data['status'];
    }
    return $status;
}
function all_packinglist2($date)
{
    $ch = curl_init(getenv("API_URL_ADMIN") . "/allpackinglist2/?date=$date");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'key: ' . getenv("API_KEY_ADMIN"),
            'Authorization: Basic ' . getenv("API_AUTH_ADMIN")
        )
    );
    $order = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($order, true);
    if ($data['status'] == 'true') {
        $status = $data['data'];
    } else {
        $status = $data['status'];
    }
    return $status;
}
function view_packinglist($id)
{
    $ch = curl_init(getenv("API_URL_ADMIN") . "/viewpackinglist/?id=$id");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'key: ' . getenv("API_KEY_ADMIN"),
            'Authorization: Basic ' . getenv("API_AUTH_ADMIN")
        )
    );
    $order = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($order, true);
    if ($data['status'] == 'true') {
        $status = $data['data'];
    } else {
        $status = $data['status'];
    }
    return $status;
}
function view_labelsticker($id)
{
    $ch = curl_init(getenv("API_URL_ADMIN") . "/viewlabelsticker/?id=$id");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'key: ' . getenv("API_KEY_ADMIN"),
            'Authorization: Basic ' . getenv("API_AUTH_ADMIN")
        )
    );
    $order = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($order, true);
    if ($data['status'] == 'true') {
        $status = $data['data'];
    } else {
        $status = $data['status'];
    }
    return $status;
}
function dropship($data)
{
    if ($data == true) {
        return '<svg class="mr-2" width="16px" height="16px" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M3 2.5a2.5 2.5 0 0 1 5 0 2.5 2.5 0 0 1 5 0v.006c0 .07 0 .27-.038.494H15a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 1 14.5V7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h2.038A2.968 2.968 0 0 1 3 2.506V2.5zm1.068.5H7v-.5a1.5 1.5 0 1 0-3 0c0 .085.002.274.045.43a.522.522 0 0 0 .023.07zM9 3h2.932a.56.56 0 0 0 .023-.07c.043-.156.045-.345.045-.43a1.5 1.5 0 0 0-3 0V3zM1 4v2h6V4H1zm8 0v2h6V4H9zm5 3H9v8h4.5a.5.5 0 0 0 .5-.5V7zm-7 8V7H2v7.5a.5.5 0 0 0 .5.5H7z" />
                </svg> <b>Kirim Sebagai Hadiah</b>';
    } else {
        return null;
    }
}
function packinglist_payment($data, $img)
{
    if ($img) {
        if (strpos($data, 'COD') !== false && getimagesize(base_url('assets/uploads/' . $img)) !== false) {
            return "left";
        } else {
            return "center";
        }
    } else {
        return "center";
    }
}
function status_payment($data)
{
    if ($data == true) {
        $result = [
            "alert"    => "success",
            "title"    => "Sudah",
            "text"     => "Uncheck jika pembeli membatalkan pembayaran",
            "checkbox" => "checked"
        ];
    } elseif ($data == false) {
        $result = [
            "alert"    => "warning",
            "title"    => "Belum",
            "text"     => "Aktifkan jika pembeli sudah melakukan pembayaran",
            "checkbox" => null
        ];
    }
    return $result;
}
function status_order($data)
{
    if ($data == 'open') {
        $result = [
            "button"   => "success",
            "title"    => "Baru"
        ];
    } elseif ($data == 'onprocess') {
        $result = [
            "button"   => "warning",
            "title"    => "Diproses"
        ];
    } elseif ($data == 'closed') {
        $result = [
            "button"   => "primary",
            "title"    => "Terkirim"
        ];
    } elseif ($data == 'canceled') {
        $result = [
            "button"   => "danger",
            "title"    => "Batal"
        ];
    }
    return $result;
}
function addSpaces($string = '', $valid_string_length = 0)
{
    if (strlen($string) < $valid_string_length) {
        $spaces = $valid_string_length - strlen($string);
        for ($index1 = 1; $index1 <= $spaces; $index1++) {
            $string = $string . ' ';
        }
    }
    return $string;
}
function spaces($length = 0)
{
    $string = '';
    for ($i = 1; $i <= $length; $i++) {
        $string = $string . ' ';
    }
    return $string;
}
function sendemail($email, $subject, $message)
{
    $ci = get_instance();
    $ci->load->library('Email_Server');
    $result = $ci->email_server->sendEmail($email, $subject, $message);
    return $result;
}
function check_nominal($data)
{
    if ($data > 100000000) {
        return 100000000;
    } else {
        return $data;
    }
}
function resize($path, $img)
{
    if ($img == 'qris') {
        $width = 500;
        $height = 500;
    } elseif ($img == 'banner') {
        $width = 1280;
        $height = 450;
    }
    $ci = get_instance();
    $ci->load->library('image_lib');
    $image_data = $path;
    $configer =  array(
        'image_library'   => 'gd2',
        'source_image'    =>  $image_data['full_path'],
        'maintain_ratio'  =>  TRUE,
        'width'           =>  $width,
        'height'          =>  $height
    );
    $ci->image_lib->clear();
    $ci->image_lib->initialize($configer);
    $ci->image_lib->resize();
}
function check_cohort($data)
{
    if (is_null($data)) {
        return null;
    } else {
        return $data . '%';
    }
}
function color_cohort($data)
{
    if (is_null($data)) {
        return null;
    } else {
        if ($data == 0) {
            return 'table-cohort0';
        } elseif ($data > 0 && $data <= 1) {
            return 'table-cohort1';
        } elseif ($data > 1 && $data <= 2) {
            return 'table-cohort2';
        } elseif ($data > 2 && $data <= 3) {
            return 'table-cohort3';
        } elseif ($data > 3 && $data <= 4) {
            return 'table-cohort4';
        } elseif ($data > 4 && $data <= 5) {
            return 'table-cohort5';
        } elseif ($data > 5 && $data <= 6) {
            return 'table-cohort6';
        } elseif ($data > 6 && $data <= 7) {
            return 'table-cohort7';
        } elseif ($data > 7 && $data <= 8) {
            return 'table-cohort8';
        } elseif ($data > 8 && $data <= 9) {
            return 'table-cohort9';
        } elseif ($data > 9) {
            return 'table-cohort10';
        }
    }
}
function color_cohort_new($data)
{
    if (is_null($data)) {
        return null;
    } else {
        if ($data == 0) {
            return 'table-cohort0';
        } elseif ($data > 0 && $data <= 3) {
            return 'table-cohort1';
        } elseif ($data > 3 && $data <= 6) {
            return 'table-cohort2';
        } elseif ($data > 6 && $data <= 9) {
            return 'table-cohort3';
        } elseif ($data > 9 && $data <= 12) {
            return 'table-cohort4';
        } elseif ($data > 12 && $data <= 15) {
            return 'table-cohort5';
        } elseif ($data > 15 && $data <= 18) {
            return 'table-cohort6';
        } elseif ($data > 18 && $data <= 21) {
            return 'table-cohort7';
        } elseif ($data > 21 && $data <= 24) {
            return 'table-cohort8';
        } elseif ($data > 24 && $data <= 27) {
            return 'table-cohort9';
        } elseif ($data > 27) {
            return 'table-cohort10';
        }
    }
}
function unset_filter()
{
    $ci = get_instance();
    $ci->session->unset_userdata(['filter_plan', 'filter_level', 'filter_status', 'filter_start', 'filter_end', 'date_start', 'date_end', 'product_min', 'product_max', 'pesanto_min', 'pesanto_max', 'quicklink_min', 'quicklink_max', 'order_min', 'order_max', 'success_min', 'success_max', 'manual_min', 'manual_max']);
}
function getStartAndEndDate($week, $year)
{
    $dto = new DateTime();
    $dto->setISODate($year, $week);
    $ret['week_start'] = $dto->format('Y-m-d');
    $dto->modify('+6 days');
    $ret['week_end'] = $dto->format('Y-m-d');
    return $ret;
}
function getStartAndEndDateMonth($month, $year)
{
    $date = DateTimeImmutable::createFromFormat('Y-m-d', $year . '-' . $month . '-13');
    $ret['date_start'] = $date->modify('first day of this month')->format('Y-m-d');
    $ret['date_end'] = $date->modify('last day of this month')->format('Y-m-d');
    return $ret;
}
function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('id')) {
        redirect('auth');
    }
}
function is_session_1jam()
{
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 28800)) {
        session_unset();
        session_destroy();
        redirect('auth');
    }
    $_SESSION['LAST_ACTIVITY'] = time();
}
function sweetalert($title, $text, $type, $show = null)
{
    $ci = get_instance();
    if (!$show) {
        $data = array(
            'title' => $title,
            'text'  => $text,
            'type'  => $type
        );
    } else {
        $data = array(
            'title' => $title,
            'text'  => $text,
            'type'  => $type,
            'show'  => 'yes'
        );
    }
    $ci->session->set_flashdata($data);
}
function value($data)
{
    if ($data) {
        return $data;
    } else {
        return null;
    }
}
function sidebar($data1, $data2)
{
    $ci = get_instance();
    if ($data1 == $data2) {
        return "active";
    } elseif ($data1 == 'voucher') {
        if ($data2 == 'report' && $ci->uri->segment(2) == 'report') {
            return "active";
        } elseif ($data2 == 'settings' && $ci->uri->segment(2) == 'index') {
            return "active";
        }
    } elseif ($data1 == 'payment') {
        if ($data2 == 'report' && $ci->uri->segment(2) == 'report') {
            return "active";
        } elseif ($data2 == 'settings' && $ci->uri->segment(2) == 'index') {
            return "active";
        }
    } elseif ($data1 == 'config' && $data2 == 'settings') {
        return "active";
    } elseif ($data1 == 'cluster' && $data2 == 'settings') {
        return "active";
    } elseif ($data1 == 'supplier' && $data2 == 'settings') {
        return "active";
    } elseif ($data1 == 'telegram' && $data2 == 'settings') {
        return "active";
    } elseif ($data1 == 'message' && $data2 == 'settings') {
        return "active";
    } elseif ($data1 == 'user' && $data2 == 'settings') {
        return "active";
    } elseif ($data1 == 'stock' && $data2 == 'report') {
        return "active";
    } elseif ($data1 == 'buffer' && $data2 == 'report') {
        return "active";
    } elseif ($data1 == 'recapitem' && $data2 == 'report') {
        return "active";
    } elseif ($data1 == 'charts' && $data2 == 'report') {
        return "active";
    } elseif ($data1 == 'hpp' && $data2 == 'report') {
        return "active";
    } elseif ($data1 == 'profit' && $data2 == 'report') {
        return "active";
    } elseif ($data1 == 'payment' && $data2 == 'report') {
        return "active";
    } else {
        return null;
    }
}
function badge_status($data)
{
    if ($data == 'pending' || $data == null) {
        return "warning";
    } elseif ($data == 'error' || $data == 'n') {
        return "danger";
    } elseif ($data == 'success' || $data == 'y') {
        return "success";
    }
}
function day_range($date)
{
    $now = new DateTime(date('Y-m-d'));
    $next = new DateTime($date);
    $result = $next->diff($now)->days;
    return $result;
}
function map_color($value)
{
    if ($value <= 10) {
        $color = '#163a5f';
    } elseif ($value > 10 and $value <= 100) {
        $color = '#21aba5';
    } elseif ($value > 100 and $value <= 1000) {
        $color = '#ffd201';
    } elseif ($value > 1000) {
        $color = '#ed5565';
    }
    return $color;
}
function domain($data)
{
    $data = str_replace(" ", "", $data);
    $string = preg_replace('/[^\p{L}\p{N}\s]/u', '', $data);
    return $string;
}
function nohp($nohp)
{
    $no = preg_replace("/[^0-9]/", "", $nohp);
    if (substr($no, 0, 1) == '0') {
        $hasil = substr_replace($no, '62', 0, 1);
    } elseif (substr($no, 0, 1) == '8') {
        $hasil = '62' . $no;
    } else {
        return $no;
    }
    return $hasil;
}
function nohpplus($nohp)
{
    if (substr($nohp, 0, 1) == '0') {
        $hasil = substr_replace($nohp, '+62', 0, 1);
    } elseif (substr($nohp, 0, 2) == '62') {
        $hasil = substr_replace($nohp, '+62', 0, 2);
    } elseif (substr($nohp, 0, 1) == '8') {
        $hasil = '+62' . $nohp;
    } else {
        return $nohp;
    }
    return $hasil;
}
function filter_city($city)
{
    if (substr($city, 0, 5) == 'Kota ' or substr($city, 0, 5) == 'Kab. ') {
        $result = substr_replace($city, '', 0, 5);
    } else {
        return $city;
    }
    return $result;
}
function nohpnol($nohp)
{
    $no = preg_replace("/[^0-9]/", "", $nohp);
    if (substr($no, 0, 2) == '62') {
        $hasil = substr_replace($no, '0', 0, 2);
    } elseif (substr($no, 0, 1) == '8') {
        $hasil = '0' . $no;
    } else {
        return $no;
    }
    return $hasil;
}
function nohpdash($nohp)
{
    $split = str_split($nohp, 4);
    return implode('-', $split);
}
function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}
function thousand($angka)
{
    $thousand = "" . number_format($angka, 0, ',', '.');
    return $thousand;
}
function currency($number)
{
    if ($number) {
        $numeric = preg_replace("/[^0-9]/", "", $number);
        if (strlen((string)$numeric) >= 6) {
            $data = (int)$numeric / 1000;
            $result = number_format($data, 0, ',', '.') . 'k';
        } else {
            $result = number_format($numeric, 0, ',', '.');
        }
    } else {
        $result = '-';
    }
    return $result;
}
function percentage($exist, $compare)
{
    if ($exist and $compare) {
        $result = abs(round(($exist - $compare) / $exist * 100));
    } else {
        $result = '-';
    }
    return $result . '%';
}
function icon_arrow($exist, $compare)
{
    if ($exist > $compare) {
        $result = 'M13,20H11V8L5.5,13.5L4.08,12.08L12,4.16L19.92,12.08L18.5,13.5L13,8V20Z';
    } elseif ($exist < $compare) {
        $result = 'M11,4H13V16L18.5,10.5L19.92,11.92L12,19.84L4.08,11.92L5.5,10.5L11,16V4Z';
    } elseif ($exist == $compare) {
        $result = 'M19,10H5V8H19V10M19,16H5V14H19V16Z';
    }
    return $result;
}
function color_arrow($exist, $compare)
{
    if ($exist > $compare) {
        $result = 'text-success';
    } elseif ($exist < $compare) {
        $result = 'text-danger';
    } elseif ($exist == $compare) {
        $result = 'text-orange';
    }
    return $result;
}
function payment_status($status)
{
    if ($status == 'paid') {
        return "text-success";
    } elseif ($status == 'cancel') {
        return "text-danger";
    } elseif ($status == 'pending') {
        return "text-orange";
    }
}
function active_alias($data)
{
    if ($data == 'y') {
        $result = 'active';
    } elseif ($data == 'n') {
        $result = 'inactive';
    } else {
        $result = '-';
    }
    return $result;
}
function filter_user($plan, $level, $start, $end)
{
    $ci = get_instance();
    $startDate = $ci->mongo_db->date((new DateTime($start))->getTimestamp() * 1000);
    $endDate = $ci->mongo_db->date(((new DateTime($end))->getTimestamp() + 86399) * 1000);
    $where = ['active' => 'y'];
    $where_plan = ['plan' => $plan];
    $where_level = ['funnel' => $level];
    $where_date = ['created_at' => ['$gte' => $startDate, '$lte' => $endDate]];
    if ($start and $end) {
        $where = array_merge($where, $where_date);
    }
    if ($plan) {
        $where = array_merge($where, $where_plan);
    }
    if ($level) {
        $where = array_merge($where, $where_level);
    }
    $user = $ci->mongo_db->order_by(['created_at' => 'DESC'])->where($where)->get('users');
    return $user;
}
function filter_domain($status, $start, $end, $db)
{
    $ci = get_instance();
    $startDate = $ci->mongo_db->date((new DateTime($start))->getTimestamp() * 1000);
    $endDate = $ci->mongo_db->date(((new DateTime($end))->getTimestamp() + 86399) * 1000);
    $where = [];
    $where_status = ['status' => $status];
    $where_date = ['created_at' => ['$gte' => $startDate, '$lte' => $endDate]];
    if ($start and $end) {
        $where = array_merge($where, $where_date);
    }
    if ($status) {
        $where = array_merge($where, $where_status);
    }
    $domain = $ci->mongo_db->order_by(['created_at' => 'DESC'])->where($where)->get($db);
    return $domain;
}
function wablas($phone_number, $message)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => getenv("WABLAS_URL") . "/send-message",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "phone=$phone_number&message=" . urlencode($message),
        CURLOPT_HTTPHEADER => array(
            "Authorization: " . getenv("WABLAS_KEY"),
            "Content-Type: application/x-www-form-urlencoded"
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true);
    if ($data['status'] == 'true') {
        $status = 'ok';
    } else {
        $status = 'bad';
    }
    return $status;
}
function delete_token($otp)
{
    $ci = get_instance();
    $data = array(
        'token'     => null,
        'token_exp' => null
    );
    $ci->mongo_db->where(array('token' => $otp))->set($data)->update('superuser');
}
function update_token($phone)
{
    $ci = get_instance();
    $token = rand(1000, 9999);
    $data = array(
        'token'     => "$token",
        'token_exp' => time()
    );
    $ci->mongo_db->where(array('phone_number' => $phone))->set($data)->update('superuser');
    return $token;
}
function otp_message($token)
{
    $ci = get_instance();
    $params['code'] = 'otp';
    $params['app'] = 'whatsapp';
    $message = $ci->mongo_db->where($params)->get('message');
    return str_replace('$otp', $token, $message[0]['message']);
}
function send_otp($phone)
{
    $token = update_token($phone);
    $message = otp_message($token);
    return wablas($phone, $message);
}
function check_invoice()
{
    $ci = get_instance();
    do {
        $no_invoice = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 4) . str_shuffle(date('dmy'));
        $result = $ci->mongo_db->get_where('invoice_member', ['no_invoice' => $no_invoice]);
        if ($result) {
            $data = 'false';
        } else {
            $data = 'true';
            return $no_invoice;
        }
    } while ($data == 'true');
}
function check_id($_id)
{
    if (is_string($_id) && strlen($_id) === 24 && ctype_xdigit($_id)) {
        return new MongoDB\BSON\ObjectID($_id);
    } else {
        return $_id;
    }
}
function string_id($_id)
{
    if (is_object($_id)) {
        return $_id->__ToString();
    } else {
        return $_id;
    }
}
function hplus1($data)
{
    if ($data) {
        if (is_string($data)) {
            $time = strtotime($data);
        } elseif (is_object($data)) {
            $time = date_timestamp_get($data->toDateTime()->setTimeZone(new DateTimeZone('Asia/Jakarta')));
        } else {
            return false;
        }
        if ($time + 172800 > time()) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
function timephp($data)
{
    if ($data) {
        return date_timestamp_get($data->toDateTime()->setTimeZone(new DateTimeZone('Asia/Jakarta')));
    } else {
        return '-';
    }
}
function dateindo($data, $format = "d-m-Y H:i:s")
{
    $hari = date("D", $data / 1000);

    switch ($hari) {
        case 'Sun':
            $hari_ini = "Minggu ";
            break;

        case 'Mon':
            $hari_ini = "Senin ";
            break;

        case 'Tue':
            $hari_ini = "Selasa ";
            break;

        case 'Wed':
            $hari_ini = "Rabu ";
            break;

        case 'Thu':
            $hari_ini = "Kamis ";
            break;

        case 'Fri':
            $hari_ini = "Jumat ";
            break;

        case 'Sat':
            $hari_ini = "Sabtu ";
            break;

        default:
            $hari_ini = " ";
            break;
    }
    return $hari_ini . date($format, $data / 1000);
}
function datephp($format, $data)
{
    if ($data) {
        return $data->toDateTime()->setTimeZone(new DateTimeZone('Asia/Jakarta'))->format($format);
    } else {
        return '-';
    }
}
function signature($method, $access_token)
{
    $user_id = getenv("API_USERID");
    $tid = mt_rand();
    $expiration = rand(1890645999, 2690645999) * 1000;
    $stringToSign = implode(':', [
        $method, $user_id, $access_token, $tid, $expiration
    ]);
    $signature = hash_hmac('sha256', $stringToSign, getenv("API_SECRET"));
    $data = array(
        "tid"           => $tid,
        "expiration"    => $expiration,
        "signature"     => $signature,
        "access_token"  => $access_token
    );
    return $data;
}
function header_api($tid, $expiration, $signature, $access_token)
{
    $data = array(
        "Accept: application/json",
        "Content-Type: application/json",
        "X-PL-Transaction-ID: $tid",
        "X-PL-Expiration: $expiration",
        "X-PL-Signature: $signature",
        "Authorization: Bearer $access_token"
    );
    return $data;
}
function get_recap_order()
{
    $signature = signature("GET", access_token());
    $ch = curl_init(getenv("API_URL") . '/api/v3/recap-order/json?export=items');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        header_api($signature['tid'], $signature['expiration'], $signature['signature'], $signature['access_token'])
    );
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);
    return $data['data'];
}

function reset_otp($phone_number)
{
    $phone_number = nohpplus($phone_number);
    $signature = signature("PUT", access_token());
    $ch = curl_init(getenv("API_URL") . "/api/v1/manage/users/$phone_number/resetotp");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        header_api($signature['tid'], $signature['expiration'], $signature['signature'], $signature['access_token'])
    );
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}
function delete_user($id)
{
    $signature = signature("DELETE", access_token());
    $ch = curl_init(getenv("API_URL") . "/api/v1/manage/users/$id");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        header_api($signature['tid'], $signature['expiration'], $signature['signature'], $signature['access_token'])
    );
    curl_exec($ch);
    curl_close($ch);
}
function get_user($id)
{
    $signature = signature("GET", access_token());
    $ch = curl_init(getenv("API_URL") . "/api/v1/manage/users/$id");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        header_api($signature['tid'], $signature['expiration'], $signature['signature'], $signature['access_token'])
    );
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}
function get_merchant($id)
{
    $signature = signature("GET", access_token());
    $ch = curl_init(getenv("API_URL") . "/api/v1/manage/merchant/$id");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        header_api($signature['tid'], $signature['expiration'], $signature['signature'], $signature['access_token'])
    );
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}
function get_all_users()
{
    $signature = signature("GET", access_token());
    $ch = curl_init(getenv("API_URL") . "/api/v1/manage/users");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        header_api($signature['tid'], $signature['expiration'], $signature['signature'], $signature['access_token'])
    );
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}
function edit_user($id, $data)
{
    $signature = signature("PUT", access_token());
    $data_string = json_encode($data);
    $ch = curl_init(getenv("API_URL") . "/api/v1/manage/users/$id");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        header_api($signature['tid'], $signature['expiration'], $signature['signature'], $signature['access_token'])
    );
    $response = curl_exec($ch);
    curl_close($ch);
}
function add_user($data)
{
    $signature = signature("POST", access_token());
    $data_string = json_encode($data);
    $ch = curl_init(getenv("API_URL") . "/api/v1/register");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        header_api($signature['tid'], $signature['expiration'], $signature['signature'], $signature['access_token'])
    );
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);
    if ($data['data']) {
        return $data['data']['_id'];
    } else {
        return null;
    }
}
function access_token()
{
    $data = array(
        "grant_type"    => "password",
        "client_id"     => getenv("API_CLIENTID"),
        "client_secret" => getenv("API_CLIENTSECRET"),
        "username"      => getenv("API_USERNAME"),
        "password"      => getenv("API_PASSWORD")
    );
    $data_string = json_encode($data);
    $ch = curl_init(getenv("API_URL") . "/oauth/token");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            "Accept: application/json",
            "Content-Type: application/json"
        )
    );
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);
    return $data['access_token'];
}
function core_script()
{
?>
    <script src="<?= base_url('assets/'); ?>js/jquery-3.1.1.min.js"></script>
    <script src="<?= base_url('assets/'); ?>js/popper.min.js"></script>
    <script src="<?= base_url('assets/'); ?>js/bootstrap.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/metisMenu/jquery.metisMenu.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?= base_url('assets/'); ?>js/inspinia.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/pace/pace.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
<?php
}
function core_script_footer()
{
?>
    <script src="<?= base_url('assets/'); ?>js/jquery-3.1.1.min.js"></script>
    <script src="<?= base_url('assets/'); ?>js/popper.min.js"></script>
    <script src="<?= base_url('assets/'); ?>js/bootstrap.js"></script>
<?php
}
function sweetalert2()
{
?>
    <script src="<?= base_url('assets/'); ?>vendor/sweetalert/sweetalert2.all.min.js"></script>
<?php
}
function validate()
{
?>
    <script src="<?= base_url('assets/'); ?>vendor/validate/jquery.validate.min.js"></script>
    <script src='<?= base_url('assets/'); ?>vendor/validate/additional-methods.min.js'></script>
<?php
}
function select2()
{
?>
    <link href="<?= base_url('assets/'); ?>vendor/select2/select2.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/'); ?>vendor/select2/select2-bootstrap4-<?= getenv("APP_BRAND") ?>.css" rel="stylesheet" type="text/css">
    <script src="<?= base_url('assets/'); ?>vendor/select2/select2.full.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/select2/id.js"></script>
<?php
}
function footable()
{
?>
    <link href="<?= base_url('assets/'); ?>vendor/footable/footable.core.css" rel="stylesheet">
    <script src="<?= base_url('assets/'); ?>vendor/footable/footable.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.footable').footable({
                "breakpoints": {
                    phone: 480,
                    tablet: 780,
                    notebook: 1200,
                    lcd: 2000
                }
            });
            document.getElementById("total-row").innerHTML = document.getElementById('table').tBodies[0].rows.length;
        });
    </script>
<?php
}
function jasny()
{
?>
    <link href="<?= base_url('assets/'); ?>vendor/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    <script src="<?= base_url('assets/'); ?>vendor/jasny/jasny-bootstrap.min.js"></script>
<?php
}
function datepicker()
{
?>
    <link href="<?= base_url('assets/'); ?>vendor/datepicker/datepicker.min.css" rel="stylesheet">
    <script src="<?= base_url('assets/'); ?>vendor/datepicker/datepicker.min.js"></script>
<?php
}
function datatables()
{
?>
    <link href="<?= base_url('assets/'); ?>vendor/datatables/datatables.min.css" rel="stylesheet">
    <script src='<?= base_url(); ?>assets/vendor/datatables/datatables.min.js'></script>
    <script src='<?= base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.js'></script>
<?php
}
function daterangepicker()
{
?>
    <link href="<?= base_url('assets/'); ?>vendor/daterangepicker/daterangepicker.css" rel="stylesheet">
    <script src="<?= base_url('assets/'); ?>vendor/daterangepicker/moment.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/daterangepicker/daterangepicker.min.js"></script>
<?php
}
function jqvmap()
{
?>
    <link href="<?= base_url('assets/'); ?>vendor/jqvmap/jquery-jvectormap-2.0.5.css" rel="stylesheet">
    <script src="<?= base_url('assets/'); ?>vendor/jqvmap/jquery-jvectormap-2.0.5.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/jqvmap/maps/jquery.vmap.surabaya.js"></script>
<?php
}
function datepickercompare()
{
?>
    <link href="<?= base_url('assets/'); ?>vendor/datepickercompare/datepickercompare-<?= getenv("APP_BRAND") ?>.css" rel="stylesheet">
    <script src="<?= base_url('assets/'); ?>vendor/datepickercompare/datepickercompare.js"></script>
<?php
}
function datetimepicker()
{
?>
    <link href="<?= base_url('assets/'); ?>vendor/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <script src="<?= base_url('assets/'); ?>vendor/datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <script>
        $("#datetime").datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose: true
        });
    </script>
<?php
}
function icheck()
{
?>
    <link href="<?= base_url('assets/'); ?>vendor/iCheck/custom.css" rel="stylesheet">
    <script src="<?= base_url('assets/'); ?>vendor/iCheck/icheck.min.js"></script>
<?php
}
function toast()
{
?>
    <link href="<?= base_url('assets/'); ?>vendor/toast/jquery.toast.css" rel="stylesheet">
    <script src="<?= base_url('assets/'); ?>vendor/toast/jquery.toast.js"></script>
<?php
}
function colorbox()
{
?>
    <link href="<?= base_url('assets/'); ?>vendor/colorbox/colorbox.css" rel="stylesheet">
    <script src="<?= base_url('assets/'); ?>vendor/colorbox/jquery.colorbox.js"></script>
<?php
}
function selectpure()
{
?>
    <link href="<?= base_url('assets/'); ?>vendor/SelectPure/style.css" rel="stylesheet">
    <script src="<?= base_url('assets/'); ?>vendor/SelectPure/bundle.min.js"></script>
<?php
}
function sortable()
{
?>
    <link href="<?= base_url('assets/'); ?>vendor/sortable/jquery-ui.min.css" rel="stylesheet">
    <script src="<?= base_url('assets/'); ?>vendor/sortable/jquery-ui.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/sortable/jquery.ui.touch-punch.min.js"></script>
<?php
}
function highchart()
{
?>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
<?php
}
function blueimp()
{
?>
    <link href="<?= base_url('assets/'); ?>vendor/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/'); ?>vendor/blueimp/css/jquery.fileupload.css" rel="stylesheet">
    <link href="<?= base_url('assets/'); ?>vendor/blueimp/css/jquery.fileupload-ui.css" rel="stylesheet">
    <!-- The blueimp Gallery widget -->
    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" aria-label="image gallery" aria-modal="true" role="dialog" data-filter=":even">
        <div class="slides" aria-live="polite"></div>
        <h3 class="title"></h3>
        <a class="prev" aria-controls="blueimp-gallery" aria-label="previous slide" aria-keyshortcuts="ArrowLeft"></a>
        <a class="next" aria-controls="blueimp-gallery" aria-label="next slide" aria-keyshortcuts="ArrowRight"></a>
        <a class="close" aria-controls="blueimp-gallery" aria-label="close" aria-keyshortcuts="Escape"></a>
        <a class="play-pause" aria-controls="blueimp-gallery" aria-label="play slideshow" aria-keyshortcuts="Space" aria-pressed="false" role="button"></a>
        <ol class="indicator"></ol>
    </div>
    <!-- The template to display files available for upload -->
    <script id="template-upload" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
          <tr class="template-upload fade{%=o.options.loadImageFileTypes.test(file.type)?' image':''%}">
              <td>
                  <span class="preview"></span>
              </td>
              <td>
                  <p class="name">{%=file.name%}</p>
                  <strong class="error text-danger"></strong>
              </td>
              <td>
                  <p class="size">Processing...</p>
                  <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
              </td>
              <td>
                  {% if (!o.options.autoUpload && o.options.edit && o.options.loadImageFileTypes.test(file.type)) { %}
                    <button class="btn btn-success edit" data-index="{%=i%}" disabled>
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg>
                        <span>Edit</span>
                    </button>
                  {% } %}
                  {% if (!i && !o.options.autoUpload) { %}
                      <button class="btn btn-primary start" disabled>
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/>
                        </svg>
                          <span> Start</span>
                      </button>
                  {% } %}
                  {% if (!i) { %}
                      <button class="btn btn-warning cancel">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        </svg>   
                          <span> Cancel</span>
                      </button>
                  {% } %}
              </td>
          </tr>
      {% } %}
    </script>
    <!-- The template to display files available for download -->
    <script id="template-download" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
          <tr class="template-download fade{%=file.thumbnailUrl?' image':''%}">
              <td>
                  <span class="preview">
                      {% if (file.thumbnailUrl) { %}
                          <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                      {% } %}
                  </span>
              </td>
              <td>
                  <p class="name">
                      {% if (file.url) { %}
                          <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                      {% } else { %}
                          <span>{%=file.name%}</span>
                      {% } %}
                  </p>
                  {% if (file.error) { %}
                      <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                  {% } %}
              </td>
              <td>
                  <span class="size">{%=o.formatFileSize(file.size)%}</span>
              </td>
              <td>
                  {% if (file.deleteUrl) { %}
                      <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>      
                          <span> Delete</span>
                      </button>
                  {% } else { %}
                      <button class="btn btn-warning cancel">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        </svg>   
                          <span> Cancel</span>
                      </button>
                  {% } %}
              </td>
          </tr>
      {% } %}
    </script>
    <script src="<?= base_url('assets/'); ?>vendor/blueimp/js/vendor/jquery.ui.widget.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/blueimp/js/tmpl.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/blueimp/js/load-image.all.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/blueimp/js/canvas-to-blob.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/blueimp/js/jquery.blueimp-gallery.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/blueimp/js/jquery.iframe-transport.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/blueimp/js/jquery.fileupload.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/blueimp/js/jquery.fileupload-process.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/blueimp/js/jquery.fileupload-image.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/blueimp/js/jquery.fileupload-audio.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/blueimp/js/jquery.fileupload-video.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/blueimp/js/jquery.fileupload-validate.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/blueimp/js/jquery.fileupload-ui.js"></script>
<?php
}
