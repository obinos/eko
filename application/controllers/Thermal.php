<?php
defined('BASEPATH') or exit('No direct script access allowed');

// use Mike42\Escpos;
use Mike42\Escpos\Printer;
// use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
// use Mike42\Escpos\PrintBuffers\ImagePrintBuffer;
// use Mike42\Escpos\CapabilityProfiles\DefaultCapabilityProfile;
// use Mike42\Escpos\CapabilityProfiles\SimpleCapabilityProfile;
use Mike42\Escpos\EscposImage;

class Thermal extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('order_model');
        $this->lang->load('message', getenv("APP_BRAND"));
        is_logged_in();
        is_session_1jam();
    }
    public function index()
    {
        if ($_POST) {
            $data['filter_date'] = $this->input->post('filter_date');
        } elseif ($_GET) {
            $data['filter_date'] = $this->input->get('filter_date');
        } else {
            $data['filter_date'] = date("d-m-Y", strtotime('tomorrow'));
        }
        $data['order'] = all_packinglist_courier($data['filter_date']);
        $data['rute'] = rute_courier($data['filter_date']);
        $data['title'] = 'Data Packing List - ' . $this->lang->line('copyright');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('thermal/index', $data);
        $this->load->view('templates/footer');
    }
    public function get_rute()
    {
        $id = $_POST['data'];
        $rute = rute_courier(null, $id);
        $rute[0]['text'] = '';
        $no = 1;
        foreach ($rute[0]['data'] as $r) {
            $rute[0]['text'] = $rute[0]['text'] . $no++ . '. ' . $r['_id'] . ' = ' . $r['time'] . "\n";
        }
        echo json_encode($rute);
    }
    public function all_print($id)
    {
        $this->print_invoice($id);
        $this->print_packinglist($id);
        $this->print_label($id);
    }
    public function print_rutecourier($id, $status)
    {
        $connector = new FilePrintConnector("//localhost/FK80Printer");
        $rute = rute_courier(null, $id);
        $printer = new Printer($connector);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setFont(Printer::FONT_B);
        $printer->setTextSize(2, 2);
        $printer->setEmphasis(true);
        $printer->text(strtoupper($status) . ' - ' . dateindo($rute[0]['delivery_time2']['$date']['$numberLong'], "d-m-Y") . "\n");
        $printer->feed();
        if ($status == 'all') {
            foreach ($rute[0]['data'] as $rut) {
                $this->status_print_rutecourier($printer, $rut);
            }
        } else if ($status == 'rak-1') {
            foreach ($rute[0]['data'] as $rut) {
                if ($rut['status'] == 'rak-1') {
                    $this->status_print_rutecourier($printer, $rut);
                }
            }
        } else if ($status == 'rak-2') {
            foreach ($rute[0]['data'] as $rut) {
                if ($rut['status'] == 'rak-2') {
                    $this->status_print_rutecourier($printer, $rut);
                }
            }
        } else if ($status == 'rak-3') {
            foreach ($rute[0]['data'] as $rut) {
                if ($rut['status'] == 'rak-3') {
                    $this->status_print_rutecourier($printer, $rut);
                }
            }
        }
        $printer->cut();
        $printer->pulse();
        $printer->close();
    }
    private function status_print_rutecourier($printer, $rut)
    {
        $name = addSpaces($rut['_id'], 5) . addSpaces($rut['time'], 7) . $rut['order'];
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setFont(Printer::FONT_B);
        $printer->setTextSize(3, 3);
        $printer->setEmphasis(false);
        $printer->text($name . "\n");
        if ($rut['note']) {
            foreach ($rut['note'] as $val) {
                $printer->setFont(Printer::FONT_B);
                $printer->setTextSize(2, 2);
                $printer->text(remove_icon($val) . "\n");
            }
        }
        $printer->feed();
    }
    public function print_packinglist($id)
    {
        $connector = new FilePrintConnector("//localhost/FK80Printer");
        $order = view_packinglist($id);
        if ($order[0]['is_dropship'] == true) {
            $dropship = ' - GFT';
        } else {
            $dropship = null;
        }
        if ($order[0]['new_customer'] == 1) {
            $new = '(NEW) ';
        } elseif ($order[0]['new_customer'] == 2) {
            $new = '(TWO) ';
        } elseif ($order[0]['new_customer'] == 3) {
            $new = '(THREE) ';
        } else {
            $new = null;
        }
        $address = preg_replace("/\r|\n/", " ", $order[0]['recipient']['address']);
        $merchant_notes = $order[0]['merchant_notes'] ? preg_replace("/\r|\n/", " ", $order[0]['merchant_notes']) : null;
        $preferences = $order[0]['preferences'] ? " " . implode(", ", $order[0]['preferences']) : null;
        $allnotes = $merchant_notes . $preferences;
        $name = $order[0]['recipient']['name'] . ' - ' . $address;
        $printer = new Printer($connector);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setEmphasis(true);
        $printer->setFont(Printer::FONT_B);
        $printer->setTextSize(3, 3);
        $printer->text($new . $order[0]['recipient']['name'] . $dropship . " - " . $order[0]['id_courier'] . "\n");
        $printer->setFont(Printer::FONT_A);
        $printer->setTextSize(1, 1);
        $printer->text($order[0]['invno'] . "\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setEmphasis(false);
        $printer->text($address . "\n");
        if ($allnotes) {
            $printer->text('Catatan: ' . remove_icon($allnotes) . "\n");
        }
        foreach ($order[0]['items'] as $key => $val) {
            $printer->feed();
            $printer->setEmphasis(true);
            $printer->text('Station: ' . $key . "\n");
            $printer->setEmphasis(false);
            $printer->text("------------------------------------------------\n");
            foreach ($val as $item) {
                $text = str_split('[ ] ' . $item['qty'] . 'x ' . $item['name'], 48);
                $no = 1;
                foreach ($text as $t) {
                    $newtxt = $no++ == 1 ? $t : '    ' . $t;
                    $printer->text($newtxt . "\n");
                }
                if ($item['note']) {
                    $printer->text('    Cat: ' . remove_icon($item['note']) . "\n");
                }
            }
        }
        $printer->setEmphasis(true);
        $printer->feed();
        $printer->cut();
        $printer->setFont(Printer::FONT_B);
        $printer->setTextSize(2, 1);
        unset($order[0]['items']['2'], $order[0]['items']['3A'], $order[0]['items']['5A']);
        foreach ($order[0]['items'] as $key => $val) {
            if ($key == 1 || $key == 4) {
                $station['end'][$key] = $val;
            } else {
                $name = substr($name, 0, 32);
                $printer->setEmphasis(true);
                $printer->text($name . "\n");
                $printer->text('Station: ' . $key . "\n");
                $printer->setEmphasis(false);
                $printer->text("--------------------------------\n");
                $no = 1;
                foreach ($val as $item) {
                    $text = str_split($item['qty'] . 'x ' . $item['name'], 30 - strlen($no));
                    $num = 1;
                    $space = spaces(strlen($no) + 2);
                    foreach ($text as $t) {
                        $newtxt = $num == 1 ? $no . '. ' . $t : $space . $t;
                        $printer->text($newtxt . "\n");
                        $num++;
                    }
                    if ($item['note']) {
                        $printer->text('Cat: ' . remove_icon($item['note']) . "\n");
                    }
                    $no++;
                }
                $printer->setEmphasis(true);
                $printer->feed();
                $printer->cut();
            }
        }
        if ($station['end']) {
            foreach ($station['end'] as $key => $val) {
                $name = substr($name, 0, 32);
                $printer->setEmphasis(true);
                $printer->text($name . "\n");
                $printer->text('Station: ' . $key . "\n");
                $printer->setEmphasis(false);
                $printer->text("--------------------------------\n");
                $no = 1;
                foreach ($val as $item) {
                    $text = str_split($item['qty'] . 'x ' . $item['name'], 30 - strlen($no));
                    $num = 1;
                    $space = spaces(strlen($no) + 2);
                    foreach ($text as $t) {
                        $newtxt = $num == 1 ? $no . '. ' . $t : $space . $t;
                        $printer->text($newtxt . "\n");
                        $num++;
                    }
                    if ($item['note']) {
                        $printer->text('Cat: ' . remove_icon($item['note']) . "\n");
                    }
                    $no++;
                }
                $printer->setEmphasis(true);
                $printer->feed();
                $printer->cut();
            }
        }
        $printer->pulse();
        $printer->close();
    }
    public function print_label($id, $loop = null)
    {
        $connector = new FilePrintConnector("//localhost/okay");
        $order = view_labelsticker($id);
        $printer = new Printer($connector);
        for ($x = 1; $x <= $order[0]['sticker']; $x++) {
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setEmphasis(true);
            $printer->setFont(Printer::FONT_B);
            $printer->setTextSize(3, 3);
            $printer->text($order[0]['name'] . ' - ' . $order[0]['id_courier'] . "\n");
            $printer->feed();
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setEmphasis(false);
            $printer->setFont(Printer::FONT_B);
            $printer->setTextSize(2, 1);
            $address = preg_replace("/\r|\n/", " ", $order[0]['address']);
            $shipping = strpos($order[0]['shipping'], 'Sidoarjo') !== false ? 'Sidoarjo' : $order[0]['shipping'];
            $alamat = strpos(ucwords($address), $shipping) !== false ? $address : $address . ', ' . $shipping;
            $merchant_notes = $order[0]['merchant_notes'] ? preg_replace("/\r|\n/", " ", $order[0]['merchant_notes']) : null;
            $preferences = $order[0]['preferences'] ? " " . implode(", ", $order[0]['preferences']) : null;
            $allnotes = $merchant_notes . $preferences;
            $printer->text($alamat . "\n");
            if ($allnotes) {
                $printer->feed();
                $printer->text('Catatan: ' . remove_icon($allnotes) . "\n");
            }
            $printer->cut();
            if ($loop) {
                break;
            }
        }
        $printer->pulse();
        $printer->close();
    }
    public function print_label_2($id)
    {
        for ($x = 1; $x <= 2; $x++) {
            $this->print_label($id, 'false');
        }
    }
    public function print_courier_list_thermal($date, $id)
    {
        $connector = new FilePrintConnector("//localhost/FK80Printer");
        $order = all_packinglist_courier($date, $id);
        $printer = new Printer($connector);
        $title = ['ADMIN', 'KURIR'];
        foreach ($title as $t) {
            foreach ($order as $ord) {
                $keys = array_column($ord['recipient'], 'lower');
                array_multisort($keys, SORT_ASC, $ord['recipient']);
                $jmlorder = $ord['total'] == $ord['order'] ? $ord['total'] : $ord['total'] . '/' . $ord['order'];
                $kerupuk = 0;
                $peyek_ebi = 0;
                $peyek_kacang = 0;
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->setEmphasis(true);
                $printer->setFont(Printer::FONT_A);
                $printer->setTextSize(3, 2);
                $printer->text($t . "\n");
                $printer->feed();
                $printer->setFont(Printer::FONT_B);
                $printer->setTextSize(2, 2);
                $printer->text($ord['name'] . " - " . $jmlorder . "\n");
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                if ($ord['time_courier']) {
                    $printer->setTextSize(2, 1);
                    $printer->text('Jam paket siap: ' . $ord['time_courier'] . "\n");
                    $printer->text('Customer terima: ' . $ord['time_customer'] . "\n");
                }
                $printer->setEmphasis(true);
                $no = 1;
                foreach ($ord['recipient'] as $data) {
                    $address = preg_replace("/\r|\n/", " ", $data['address']);
                    $shipping = strpos($data['shipping'], 'Sidoarjo') !== false ? 'Sidoarjo' : $data['shipping'];
                    $alamat = strpos(ucwords($address), $shipping) !== false ? $address : $address . ', ' . $shipping;
                    $merchant_notes = $data['merchant_notes'] ? preg_replace("/\r|\n/", " ", $data['merchant_notes']) : null;
                    $preferences = $data['preferences'] ? " " . implode(", ", $data['preferences']) : null;
                    $allnotes = $merchant_notes . $preferences;
                    $printer->feed();
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->setFont(Printer::FONT_B);
                    $printer->setTextSize(2, 1);
                    $printer->text("-------------- " . $no++ . " --------------\n");
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text("Nama: " . $data['name'] . "\n");
                    $printer->text("Alamat: " . $alamat . "\n");
                    if ($allnotes) {
                        $printer->text('Catatan: ' . remove_icon($allnotes) . "\n");
                    }
                    $printer->text("No HP: " . $data['phone'] . "\n");
                    if ($data['kerupuk'] || $data['peyek_ebi'] || $data['peyek_kacang'] || $data['payment']) {
                        if ($data['kerupuk']) {
                            $printer->setFont(Printer::FONT_B);
                            $printer->setTextSize(2, 2);
                            $printer->feed();
                            $printer->text("Kerupuk: " . $data['kerupuk'][0]['qty']);
                            $kerupuk = $kerupuk + (int)$data['kerupuk'][0]['qty'];
                        }
                        if ($data['peyek_ebi']) {
                            $printer->setFont(Printer::FONT_B);
                            $printer->setTextSize(2, 2);
                            $printer->feed();
                            $printer->text("Peyek Ebi: " . $data['peyek_ebi'][0]['qty']);
                            $peyek_ebi = $peyek_ebi + (int)$data['peyek_ebi'][0]['qty'];
                        }
                        if ($data['peyek_kacang']) {
                            $printer->setFont(Printer::FONT_B);
                            $printer->setTextSize(2, 2);
                            $printer->feed();
                            $printer->text("Peyek Kacang: " . $data['peyek_kacang'][0]['qty']);
                            $peyek_kacang = $peyek_kacang + (int)$data['peyek_kacang'][0]['qty'];
                        }
                        if ($data['payment']) {
                            $printer->setFont(Printer::FONT_B);
                            $printer->setTextSize(2, 2);
                            $printer->feed();
                            $printer->text("COD: " . thousand($data['payment'][0]['payment_amount']));
                        }
                        $printer->feed();
                    }
                }
                if ($kerupuk > 0 || $peyek_ebi > 0 || $peyek_kacang > 0) {
                    $printer->setJustification(Printer::JUSTIFY_CENTER);
                    $printer->setFont(Printer::FONT_B);
                    $printer->setTextSize(2, 1);
                    $printer->text("\n--------------------------------\n");
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->setFont(Printer::FONT_B);
                    $printer->setTextSize(2, 2);
                    if ($kerupuk > 0) {
                        $printer->text("\nTotal Kerupuk: " . $kerupuk);
                    }
                    if ($peyek_ebi > 0) {
                        $printer->text("\nTotal Peyek Ebi: " . $peyek_ebi);
                    }
                    if ($peyek_kacang > 0) {
                        $printer->text("\nTotal Peyek Kacang: " . $peyek_kacang);
                    }
                }
                $printer->feed();
                $printer->cut();
            }
        }
        $printer->pulse();
        $printer->close();
    }
    public function print_invoice($id)
    {
        $connector = new FilePrintConnector("//localhost/FK80Printer");
        $order = view_packinglist($id);
        $no = 1;
        foreach ($order[0]['items'] as $val) {
            foreach ($val as $val1) {
                $data_item[] = $val1;
            }
        }
        // array_multisort(array_column($data_item, 'name'), SORT_ASC, $data_item);
        $address = preg_replace("/\r|\n/", " ", $order[0]['recipient']['address']);
        $merchant_notes = $order[0]['merchant_notes'] ? preg_replace("/\r|\n/", " ", $order[0]['merchant_notes']) : null;
        $preferences = $order[0]['preferences'] ? " " . implode(", ", $order[0]['preferences']) : null;
        $allnotes = $merchant_notes . $preferences;
        $subtotal = new item('Subtotal', thousand($order[0]['price']['subtotal']));
        $voucher = new item('Voucher (' . $order[0]['voucher'] . ')', '- ' . thousand($order[0]['price']['discount']));
        $tax = new item('Ongkir', thousand($order[0]['price']['shipping']));
        $total = new item('Total', thousand($order[0]['price']['total']), true);
        $date = dateindo($order[0]['transaction_date']['$date']['$numberLong']);
        $logo = EscposImage::load("../public/assets/img/aratamart_logo.png");
        $printer = new Printer($connector);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setFont(Printer::FONT_A);
        $printer->setTextSize(2, 2);
        $printer->text("INVOICE\n");
        $printer->feed();
        $printer->bitImage($logo);
        $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer->selectPrintMode();
        $printer->feed();
        $printer->setEmphasis(true);
        $printer->setFont(Printer::FONT_A);
        $printer->setTextSize(1, 1);
        $printer->text($order[0]['invno'] . "\n");
        $printer->text($date . "\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->feed();
        $printer->text('Nama   : ' . $order[0]['recipient']['name'] . "\n");
        $printer->text('Alamat : ' . $address . "\n");
        $printer->text('No HP  : ' . $order[0]['recipient']['phone'] . "\n");
        $printer->text('Payment: ' . payment_string($order[0]['payment']) . "\n");
        if ($allnotes) {
            $printer->setFont(Printer::FONT_A);
            $printer->setTextSize(1, 1);
            $printer->text('Catatan: ' . remove_icon($allnotes) . "\n");
        }
        $printer->feed();
        $printer->setEmphasis(false);
        $printer->text("------------------------------------------------\n");
        if ($order[0]['is_dropship'] == false) {
            foreach ($data_item as $item) {
                $space = spaces(strlen($no) + 2);
                $spacenote = spaces(strlen($no) + 3);
                $name_lines = str_split($no++ . ". " . $item['qty'] . "x " . $item['name'] . ' (@' . thousand($item['price']) . ')', 39);
                $num = 1;
                foreach ($name_lines as $k => $l) {
                    if ($num++ != 1) {
                        $l = trim($l);
                        $l = $space . $l;
                    } else {
                        $l = trim($l);
                    }
                    $name_lines[$k] = addSpaces($l, 41);
                }
                $total_price = str_split(nominal_inv(thousand($item['qty'] * $item['price'])), 7);
                foreach ($total_price as $k => $l) {
                    $total_price[$k] = addSpaces($l, 7);
                }
                $counter = 0;
                $temp = [];
                $temp[] = count($name_lines);
                $temp[] = count($total_price);
                $counter = max($temp);
                for ($i = 0; $i < $counter; $i++) {
                    $line = '';
                    if (isset($name_lines[$i])) {
                        $line .= ($name_lines[$i]);
                    }
                    if (isset($total_price[$i])) {
                        $line .= ($total_price[$i]);
                    }
                    $printer->setFont(Printer::FONT_A);
                    $printer->setTextSize(1, 1);
                    $printer->text($line . "\n");
                }
                if ($item['note']) {
                    $item_note = preg_replace("/\r|\n/", ",", $item['note']);
                    $note_lines = str_split(remove_icon($item_note), 60 - strlen($no));
                    foreach ($note_lines as $k => $l) {
                        $l = trim($l);
                        $note_lines[$k] = addSpaces($l, 60 - strlen($no));
                    }
                    $counter = 0;
                    $temp = [];
                    $temp[] = count($note_lines);
                    $counter = max($temp);
                    for ($i = 0; $i < $counter; $i++) {
                        $line = '';
                        if (isset($note_lines[$i])) {
                            $line .= ($note_lines[$i]);
                        }
                        $printer->setFont(Printer::FONT_B);
                        $printer->setTextSize(1, 1);
                        $printer->text($spacenote . $line . "\n");
                    }
                }
            }
        } else {
            foreach ($data_item as $item) {
                $name_lines = str_split($no++ . ". " . $item['qty'] . "x " . $item['name'], 48);
                $num = 1;
                $space = spaces(strlen($no) + 2);
                $spacenote = spaces(strlen($no) + 3);
                foreach ($name_lines as $k => $l) {
                    if ($num++ != 1) {
                        $l = trim($l);
                        $l = $space . $l;
                    } else {
                        $l = trim($l);
                    }
                    $name_lines[$k] = addSpaces($l, 48);
                }
                $counter = 0;
                $temp = [];
                $temp[] = count($name_lines);
                $counter = max($temp);
                for ($i = 0; $i < $counter; $i++) {
                    $line = '';
                    if (isset($name_lines[$i])) {
                        $line .= ($name_lines[$i]);
                    }
                    $printer->setFont(Printer::FONT_A);
                    $printer->setTextSize(1, 1);
                    $printer->text($line . "\n");
                }
                if ($item['note']) {
                    $item_note = preg_replace("/\r|\n/", ",", $item['note']);
                    $note_lines = str_split(remove_icon($item_note), 60 - strlen($no));
                    foreach ($note_lines as $k => $l) {
                        $l = trim($l);
                        $note_lines[$k] = addSpaces($l, 60 - strlen($no));
                    }
                    $counter = 0;
                    $temp = [];
                    $temp[] = count($note_lines);
                    $counter = max($temp);
                    for ($i = 0; $i < $counter; $i++) {
                        $line = '';
                        if (isset($note_lines[$i])) {
                            $line .= ($note_lines[$i]);
                        }
                        $printer->setFont(Printer::FONT_B);
                        $printer->setTextSize(1, 1);
                        $printer->text($spacenote . $line . "\n");
                    }
                }
            }
            $printer->text("------------------------------------------------\n");
        }
        $printer->setFont(Printer::FONT_A);
        $printer->setTextSize(1, 1);
        $printer->setEmphasis(true);
        if ($order[0]['is_dropship'] == false) {
            $printer->text("------------------------------------------------\n");
            $printer->text($subtotal);
            $printer->setEmphasis(false);
            $printer->text($tax);
            if ($order[0]['voucher']) {
                $printer->text($voucher);
            }
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text($total);
            $printer->selectPrintMode();
        }
        $printer->feed(2);
        $printer->setEmphasis(true);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Follow Instagram @ArataMart.id\n");
        $printer->text("Dan ikuti Flash Sale setiap kamis jam 10-13\n");
        $printer->cut();
        $printer->pulse();
        $printer->close();
    }
    public function test($id)
    {
        $connector = new FilePrintConnector("//localhost/TM-T82");
        $this->load->model('order_model');
        $order = $this->order_model->order_packinglist($id);
        $no = 1;
        $items = json_decode(json_encode($order[0]['items']), true);
        foreach ($items as $val) {
            foreach ($val as $val1) {
                $data_item[] = $val1;
            }
        }
        array_multisort(array_column($data_item, 'name'), SORT_ASC, $data_item);
        $address = preg_replace("/\r|\n/", " ", $order[0]['recipient']->address);
        $merchant_notes = preg_replace("/\r|\n/", " ", $order[0]['merchant_notes']);
        $subtotal = new item('Subtotal', thousand($order[0]['price']->subtotal));
        $voucher = new item('Voucher (' . $order[0]['voucher'] . ')', '- ' . thousand($order[0]['price']->discount));
        $tax = new item('Ongkir', thousand($order[0]['price']->shipping));
        $total = new item('Total', thousand($order[0]['price']->total), true);
        $date = dateindo($order[0]['transaction_date']);
        $logo = EscposImage::load("../public/assets/img/aratamart_logo.png");
        $printer = new Printer($connector);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setFont(Printer::FONT_A);
        $printer->setTextSize(2, 2);
        $printer->text("INVOICE\n");
        $printer->feed();
        $printer->bitImage($logo);
        $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer->selectPrintMode();
        $printer->feed();
        $printer->setEmphasis(true);
        $printer->setFont(Printer::FONT_A);
        $printer->setTextSize(1, 1);
        $printer->text($order[0]['invno'] . "\n");
        $printer->text($date . "\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->feed();
        $printer->text('Nama   : ' . $order[0]['recipient']->name . "\n");
        $printer->text('Alamat : ' . $address . "\n");
        $printer->text('No HP  : ' . $order[0]['recipient']->phone . "\n");
        $printer->text('Payment: ' . payment_string($order[0]['payment']) . "\n");
        if ($order[0]['merchant_notes']) {
            $printer->setFont(Printer::FONT_A);
            $printer->setTextSize(1, 1);
            $printer->text('Catatan: ' . $merchant_notes . "\n");
        }
        $printer->feed();
        $printer->setEmphasis(false);
        $printer->text("------------------------------------------------\n");
        if ($order[0]['is_dropship'] == false) {
            foreach ($data_item as $item) {
                $name_lines = str_split($no++ . ". " . $item['qty'] . "x " . $item['name'] . ' (@' . thousand($item['price']) . ')', 39);
                $num = 1;
                foreach ($name_lines as $k => $l) {
                    if ($num++ != 1) {
                        $l = trim($l);
                        $l = '   ' . $l;
                    } else {
                        $l = trim($l);
                    }
                    $name_lines[$k] = addSpaces($l, 41);
                }
                $total_price = str_split(nominal_inv(thousand($item['qty'] * $item['price'])), 7);
                foreach ($total_price as $k => $l) {
                    $total_price[$k] = addSpaces($l, 7);
                }
                $counter = 0;
                $temp = [];
                $temp[] = count($name_lines);
                $temp[] = count($total_price);
                $counter = max($temp);
                for ($i = 0; $i < $counter; $i++) {
                    $line = '';
                    if (isset($name_lines[$i])) {
                        $line .= ($name_lines[$i]);
                    }
                    if (isset($total_price[$i])) {
                        $line .= ($total_price[$i]);
                    }
                    $printer->setFont(Printer::FONT_A);
                    $printer->setTextSize(1, 1);
                    $printer->text($line . "\n");
                }
                if ($item['note']) {
                    $itemnote = preg_replace("/\r|\n/", ",", $item['note']);
                    $note_lines = str_split(remove_icon($itemnote), 60);
                    foreach ($note_lines as $k => $l) {
                        $l = trim($l);
                        $note_lines[$k] = addSpaces($l, 60);
                    }
                    $counter = 0;
                    $temp = [];
                    $temp[] = count($note_lines);
                    $counter = max($temp);
                    for ($i = 0; $i < $counter; $i++) {
                        $line = '';
                        if (isset($note_lines[$i])) {
                            $line .= ($note_lines[$i]);
                        }
                        $printer->setFont(Printer::FONT_B);
                        $printer->setTextSize(1, 1);
                        $printer->text('    ' . $line . "\n");
                    }
                }
            }
        } else {
            foreach ($data_item as $item) {
                $name_lines = str_split($no++ . ". " . $item['qty'] . "x " . $item['name'], 48);
                $num = 1;
                foreach ($name_lines as $k => $l) {
                    if ($num++ != 1) {
                        $l = trim($l);
                        $l = '   ' . $l;
                    } else {
                        $l = trim($l);
                    }
                    $name_lines[$k] = addSpaces($l, 48);
                }
                $counter = 0;
                $temp = [];
                $temp[] = count($name_lines);
                $counter = max($temp);
                for ($i = 0; $i < $counter; $i++) {
                    $line = '';
                    if (isset($name_lines[$i])) {
                        $line .= ($name_lines[$i]);
                    }
                    $printer->setFont(Printer::FONT_A);
                    $printer->setTextSize(1, 1);
                    $printer->text($line . "\n");
                }
                if ($item['note']) {
                    $itemnote = preg_replace("/\r|\n/", ",", $item['note']);
                    $note_lines = str_split(remove_icon($itemnote), 60);
                    foreach ($note_lines as $k => $l) {
                        $l = trim($l);
                        $note_lines[$k] = addSpaces($l, 60);
                    }
                    $counter = 0;
                    $temp = [];
                    $temp[] = count($note_lines);
                    $counter = max($temp);
                    for ($i = 0; $i < $counter; $i++) {
                        $line = '';
                        if (isset($note_lines[$i])) {
                            $line .= ($note_lines[$i]);
                        }
                        $printer->setFont(Printer::FONT_B);
                        $printer->setTextSize(1, 1);
                        $printer->text('    ' . $line . "\n");
                    }
                }
            }
            $printer->text("------------------------------------------------\n");
        }
        $printer->setFont(Printer::FONT_A);
        $printer->setTextSize(1, 1);
        $printer->setEmphasis(true);
        if ($order[0]['is_dropship'] == false) {
            $printer->text("------------------------------------------------\n");
            $printer->text($subtotal);
            $printer->setEmphasis(false);
            $printer->text($tax);
            if ($order[0]['voucher']) {
                $printer->text($voucher);
            }
            $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
            $printer->text($total);
            $printer->selectPrintMode();
        }
        $printer->feed(2);
        $printer->setEmphasis(true);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("IG Story-in pengalaman belanjamu.\n");
        $printer->text("Tag @ArataMart.id\n");
        $printer->text("dan pakai hashtag #UnboxingFreshness.\n");
        $printer->text("Dapatkan hadiah menarik, diundi setiap minggu.\n");
        $printer->cut();
        $printer->pulse();
        $printer->close();
    }
}
class item
{
    private $name;
    private $price;
    private $dollarSign;

    public function __construct($name = '', $price = '', $dollarSign = false)
    {
        $this->name = $name;
        $this->price = $price;
        $this->dollarSign = $dollarSign;
    }

    public function __toString()
    {
        $rightCols = 10;
        $leftCols = 38;
        if ($this->dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this->name, $leftCols);

        $sign = ($this->dollarSign ? 'Rp ' : '');
        $right = str_pad($sign . $this->price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right\n";
    }
}
