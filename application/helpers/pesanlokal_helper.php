<?php
function send_onboarding($name, $phone_number)
{
    $ci = get_instance();
    $message = $ci->mongo_db->get('message');
    $message_user = str_replace('$name', $name, $message[0]['active_free']);
    onboarding($phone_number, $message_user);
    $message_onboarding = str_replace('$name', $name, $message[0]['onboarding1']);
    onboarding($phone_number, $message_onboarding);
}
function check_active()
{
    $ci = get_instance();
    $all_user = $ci->mongo_db->get_where('users', ['active' => 'y', '$nor' => [['plan' => 'plan1']]]);
    foreach ($all_user as $data) {
        if ($data['expired_at']) {
            if (timephp($data['expired_at']) - time() <= 0) {
                $ci->mongo_db->where(['_id' => check_id($data['_id'])])->set(["plan" => "plan1", "expired_at" => null])->update('users');
                edit_user(check_id($data['_id']), ["plan" => "plan1"]);
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
                    $name = ucwords(strtolower($data['name']));
                    $phone_number = nohp($data['phone_number']);
                    $data_user[] = [
                        "_id"           => check_id($data['_id']),
                        "name"          => $name,
                        "role"          => $data['role'],
                        "phone_number"  => $phone_number,
                        "email"         => $data['email'],
                        "merchant_name" => null,
                        "link"          => null,
                        "city"          => null,
                        "province"      => null,
                        "active"        => $data['active'],
                        "plan"          => $data['plan'],
                        "created_at"    => $ci->mongo_db->date($data['updated_at']['$date']['$numberLong']),
                        "expired_at"    => null,
                        "funnel"        => null,
                        "bc"            => null,
                        "onboarding"    => 1,
                        "token"         => null,
                        "token_exp"     => null
                    ];
                    send_onboarding($name, $phone_number);
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
    if ($plan != 'plan1') {
        if ($expired) {
            return datephp('d M Y', $expired);
        } else {
            return "-";
        }
    } else {
        return "-";
    }
}
function masa_aktif($plan, $expired)
{
    if ($plan != 'plan1') {
        if ($expired) {
            if (timephp($expired) - time() > 0) {
                return day_range(date('Y-m-d', timephp($expired))) . " hari";
            } else {
                return "0 hari";
            }
        } else {
            return "-";
        }
    } else {
        return "-";
    }
}
function check_data($data, $id)
{
    $ci = get_instance();
    $all_user_prod = get_all_users();
    if ($data == 'email') {
        $email = $ci->input->get_post('email');
        foreach ($all_user_prod['data']['users'] as $data) {
            if ($data['email'] == $email) {
                $result_id = $data['_id'];
            }
        }
    } else {
        $phone_number = nohpplus($ci->input->get_post('phone_number'));
        foreach ($all_user_prod['data']['users'] as $data) {
            if ($data['phone_number'] == $phone_number) {
                $result_id = $data['_id'];
            }
        }
    }
    if ($result_id) {
        if ($result_id == $id) {
            return 'true';
        } else {
            return 'false';
        }
    } else {
        return 'true';
    }
}
function api_userpost($plan)
{
    $data['expired_at'] = null;
    $data['onboarding'] = 1;
    return $data;
}
