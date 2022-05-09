<?php
function send_onboarding($name, $phone_number)
{
    $ci = get_instance();
    $message = $ci->mongo_db->get('message');
    $message_user = str_replace('$name', $name, $message[0]['active_free']);
    onboarding($phone_number, $message_user);
}
function check_active()
{
    $ci = get_instance();
    $all_user = $ci->mongo_db->get_where('users', ['active' => 'y']);
    foreach ($all_user as $data) {
        if ($data['expired_at']) {
            if (timephp($data['expired_at']) - time() <= 0) {
                $ci->mongo_db->where(['_id' => check_id($data['_id'])])->set(["active" => "n"])->update('users');
                edit_user(check_id($data['_id']), ["active" => "n"]);
            }
        }
    }
}
function sync_user()
{
    $ci = get_instance();
    $all_user = get_all_users();
    $all_user = $all_user['data']['users'];
    foreach ($all_user as $data) {
        if ((!empty($data['phone_number'])) ? $data['phone_number'] : NULL) {
            if ($data['role'] == 'owner' && $data['name']) {
                $id = $ci->mongo_db->get_where('users', ['_id' => check_id($data['_id'])]);
                if (!$id) {
                    if ($data['plan'] == 'plan1') {
                        $expired = (time() + 1209600) * 1000;
                        $expired_at = $ci->mongo_db->date($expired);
                    } elseif ($data['plan'] == 'plan3') {
                        $expired = (time() + 97200000) * 1000;
                        $expired_at = $ci->mongo_db->date($expired);
                    } else {
                        $expired_at = null;
                    }
                    $data_user[] = [
                        "_id"           => check_id($data['_id']),
                        "name"          => ucwords(strtolower($data['name'])),
                        "role"          => $data['role'],
                        "phone_number"  => nohp($data['phone_number']),
                        "email"         => $data['email'],
                        "merchant_name" => null,
                        "link"          => null,
                        "city"          => null,
                        "province"      => null,
                        "active"        => $data['active'],
                        "plan"          => $data['plan'],
                        "created_at"    => $ci->mongo_db->date($data['updated_at']['$date']['$numberLong']),
                        "expired_at"    => $expired_at,
                        "funnel"        => null,
                        "bc"            => null,
                        "onboarding"    => $data['username'],
                        "token"         => null,
                        "token_exp"     => null
                    ];
                }
            }
        }
    }
    if ($data_user) {
        $ci->mongo_db->batch_insert('users', $data_user);
    }
    redirect('user/merchant');
}
function expired($plan, $expired)
{
    if ($expired) {
        return datephp('d M Y', $expired);
    } else {
        return "-";
    }
}
function masa_aktif($plan, $expired)
{
    if ($expired) {
        if (timephp($expired) - time() > 0) {
            return day_range(date('Y-m-d', timephp($expired))) . " hari";
        } else {
            return "0 hari";
        }
    } else {
        return "-";
    }
}
function check_data($data, $id)
{
    return 'true';
}
function api_userpost($plan)
{
    $ci = get_instance();
    if ($plan == 'plan1') {
        $expired = (time() + 1209600) * 1000;
        $data['expired_at'] = $ci->mongo_db->date($expired);
    } elseif ($plan == 'plan3') {
        $expired = (time() + 97200000) * 1000;
        $data['expired_at'] = $ci->mongo_db->date($expired);
    }
    $data['onboarding'] = null;
    return $data;
}
