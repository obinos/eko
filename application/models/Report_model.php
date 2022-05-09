<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('mongo_db', array('activate' => 'arata'), 'aratadb');
        $this->merchant = '606eba1c099777608a38aeda';
    }
    public function uploadData()
    {
        if (isset($_POST["import"])) {
            $fileName = $_FILES["file"]["tmp_name"];
            if ($_FILES["file"]["size"] > 0) {
                $file = fopen($fileName, "r");
                while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                    $arata = $this->mongo_db->get_where('arata', ['phone_number' => nohp($column[1])]);
                    if (!$arata) {
                        $data = [
                            "name"          => ucwords(strtolower(htmlspecialchars($column[2]))),
                            "phone_number"  => nohp($column[1]),
                            "created_at"    => new MongoDB\BSON\UTCDateTime((new DateTime($column[0]))->getTimestamp() * 1000)
                        ];
                        $result = $this->mongo_db->insert('arata', $data);
                    }
                    $data = [
                        "name"          => ucwords(strtolower(htmlspecialchars($column[2]))),
                        "phone_number"  => nohp($column[1]),
                        "created_at"    => new MongoDB\BSON\UTCDateTime((new DateTime($column[0]))->getTimestamp() * 1000),
                        "nominal"       => $column[3]
                    ];
                    $result = $this->mongo_db->insert('arata_trx', $data);
                    if (!empty($result)) {
                        sweetalert('Data Leads Merchant', 'berhasil diupload', 'success');
                    } else {
                        sweetalert('Data Leads Merchant', 'gagal diupload', 'error');
                    }
                }
            }
        }
    }
    public function report_purchase($start = null, $end = null)
    {
        if ($start) {
            $startDate = $this->mongo_db->date(strtotime("$start") * 1000);
            $endDate = $this->mongo_db->date((strtotime("$end") + 86399) * 1000);
            $params['transaction_date']['$gte'] = $startDate;
            $params['transaction_date']['$lte'] = $endDate;
        }
        $params['$nor'] = [['_id' => null]];
        $params_item['merchant'] = $this->merchant;
        $supplier = $this->aratadb->order_by(['name' => 'ASC'])->get('supplier');
        $items = $this->aratadb->order_by(['name' => 'ASC'])->where($params_item)->get('items');
        $dt = $this->aratadb->order_by(['transaction_date' => 'DESC'])->where($params)->get('purchase');
        foreach ($dt as $ord) {
            $cancel = $ord['is_cancel'] === true ? 'cancel' : 'aktif';
            $key1 = array_search($ord['id_supplier'], array_column($supplier, "_id"));
            if ($key1 !== false) {
                $supp = $supplier[$key1]['name'];
            } else {
                $supp = null;
            }
            foreach ($ord['items'] as $key => $val) {
                $key2 = array_search($val->id_item, array_column($items, "_id"));
                if ($key2 !== false) {
                    $name = $items[$key2]['name'];
                    $sku = $items[$key2]['barcode'];
                } else {
                    $name = null;
                }
                $data = [
                    "no"                => $ord['no'],
                    "transaction_date"  => $ord['transaction_date'],
                    "supplier"          => $supp,
                    "who_update"        => $ord['who_update'],
                    "notes"             => $ord['notes'],
                    "sku"               => $sku,
                    "name"              => $name,
                    "qty_unit"          => $val->qty_unit,
                    "qty"               => $val->qty,
                    "price"             => $val->price,
                    "total_price"       => $val->total_price,
                    "total"             => $ord['total'],
                    "status"            => $cancel
                ];
                $newitems[] = $data;
            }
        }
        if (!$newitems) {
            return [];
        } else {
            return $newitems;
        }
    }
    public function getCohort($tgl = null)
    {
        if ($tgl) {
            $week = date("W", strtotime($tgl)) - 1;
            $month = date("m", strtotime($tgl));
            $year = date("Y", strtotime($tgl));
        } else {
            $week = date("W") - 1;
            $month = date("m");
            $year = date("Y");
        }
        if ($week == 51 && $month == 1) {
            $year = $year - 1;
        }
        $newyear = $year - 2021;
        if ($newyear > 0) {
            $selisih = $newyear * 52;
            $week = $week + $selisih;
        }
        $date = getStartAndEndDate($week, 2021);
        for ($x = $week; $x > 21; $x--) {
            $date_user = getStartAndEndDate($x, 2021);
            $id = $date_user['week_start'] . ' - ' . $date_user['week_end'];
            $no_week = $week - $x;
            $filter_start = $date_user['week_start'];
            $filter_end = $date_user['week_end'];
            $startDate = $this->mongo_db->date(strtotime("$filter_start") * 1000);
            $endDate = $this->mongo_db->date((strtotime("$filter_end") + 86399) * 1000);
            if ($filter_start && $filter_end) {
                $params['created_at']['$gte'] = $startDate;
                $params['created_at']['$lte'] = $endDate;
            }
            $params['merchant'] = $this->merchant;
            $user = $this->aratadb->get_where('customers', $params);
            $phone_number = [];
            foreach ($user as $data) {
                $phone_number[] = ['customer.phone' => $data['phone']];
            }
            $filter_start = $date['week_start'];
            $filter_end = $date['week_end'];
            $startDate = $this->mongo_db->date((new DateTime($filter_start))->getTimestamp() * 1000);
            $endDate = $this->mongo_db->date(((new DateTime($filter_end))->getTimestamp() + 86399) * 1000);
            $pipeline = $this->pipeline($startDate, $endDate, $phone_number);
            $data_pipeline = $this->aratadb->aggregate('orders', $pipeline);
            $countUser = count($user);
            $count_data_pipeline = count($data_pipeline) / $countUser * 100;
            if ($no_week == 0) {
                $data_cohort = [
                    "_id"        => (string) new MongoDB\BSON\ObjectId(),
                    "cohort"     => $id,
                    "merchant"   => $countUser,
                    $no_week     => 100,
                    "filter"     => 'trx1',
                    "created_at" => $this->mongo_db->date()
                ];
                $this->mongo_db->insert('arata_cohort', $data_cohort);
            } else {
                $this->mongo_db->where(['cohort' => $id, "filter" => 'trx1'])->set([$no_week => round($count_data_pipeline, 2)])->update('arata_cohort');
            }
        }
    }
    public function pipeline($startDate, $endDate, $phone_number)
    {
        $pipeline = [
            ['$match' => ['$and' => [['merchant' => $this->merchant, 'created_at' => ['$gte' => $startDate, '$lte' => $endDate], '$or' => $phone_number]]]],
            ['$group' => ['_id' => '$customer.phone']]
        ];
        return $pipeline;
    }
    public function reportCluster()
    {
        $pipeline = [
            ['$match' => ['$and' => [['$nor' => [['status' => 'canceled'], ['recipient.id_cluster' => ''], ['recipient.id_cluster' => null]], 'merchant' => '606eba1c099777608a38aeda']]]],
            ['$group' => ['_id' => ['idcluster' => '$recipient.id_cluster', 'phone' => '$recipient.phone'], 'count' => ['$sum' => 1]]],
            ['$group' => ['_id' => '$_id.idcluster', 'transaction' => ['$sum' => '$count'], 'customer' => ['$sum' => 1]]],
            ['$lookup' => [
                'from' => 'cluster',
                'localField' => '_id',
                'foreignField' => '_id',
                'as' => 'cluster'
            ]],
            ['$project' => ['_id' => '$_id', 'transaction' => '$transaction', 'customer' => '$customer', 'avg' => ['$round' => [['$divide' => ['$transaction', '$customer']], 2]], 'cluster' => ['$arrayElemAt' => ['$cluster.name', 0]], 'code' => ['$arrayElemAt' => ['$cluster.code', 0]]]],
            ['$sort'  => ['code' => 1]]
        ];
        $count = $this->aratadb->aggregate('orders', $pipeline);
        $id['03'] = '60e53cf14df99744eb351e13';
        $id['09'] = '60e53cf14df99744eb351e16';
        $id['10'] = '60e53cf14df99744eb351e14';
        $name['03'] = 'Barat: Citraland, Citraland Utara, Manukan, Sambikerep, Graha Natura';
        $name['09'] = 'Timur: Galaxy Bumi Permai, Sukolilo, Kertajaya Indah, Dharmahusada Permai, Nginden, Manyar Jaya, Manyar Tirto, Dharmahusada Indah';
        $name['10'] = 'Selatan: Ketintang, Gayungsari, Karah, Jemursari, Kutisari, Siwalankerto, Tropodo, Pondok Chandra, Juanda';
        foreach ($count as $c) {
            $idcluster = $id[$c['code']] ? $id[$c['code']] : $c['_id'];
            $namecluster = $name[$c['code']] ? $name[$c['code']] : $c['cluster'];
            $newcount[$c['code']]['_id'] = $idcluster;
            $newcount[$c['code']]['transaction'] = $newcount[$c['code']]['transaction'] + $c['transaction'];
            $newcount[$c['code']]['customer'] = $newcount[$c['code']]['customer'] + $c['customer'];
            $newcount[$c['code']]['avg'] = round($newcount[$c['code']]['transaction'] / $newcount[$c['code']]['customer'], 2);
            $newcount[$c['code']]['cluster'] = $namecluster;
            $newcount[$c['code']]['code'] = $c['code'];
        }
        foreach ($newcount as $k => $c) {
            $code[$c['_id']] = $c['code'];
            $transaction[$c['_id']] = $c['transaction'];
            $customer2[$c['_id']] = $c['customer'];
            $avg[$c['_id']] = $c['avg'];
            $cluster['data'][] = $c;
            $cluster['customer1'][] = $c['customer'];
            $cluster['transaction'] = $transaction;
            $cluster['customer2'] = $customer2;
            $cluster['avg'] = $avg;
            $cluster['code'] = $code;
        }
        return $cluster;
    }
}
