<?php


$sql_key = " select user_name as users_sn,password,temporary_time,temporary_key from admin_user  where temporary_key='" .
    $_REQUEST['temporary_key'] . "' ;";
//print_r($sql_key);exit;
$user_id = $GLOBALS['db']->getRow($sql_key);
if (!empty($user_id)) {
    $time_diff = get_time_diff($user_id['temporary_time']);
    //print_r($time_diff['hour']);
    if ($time_diff['hour'] >= 12) {
        $err = '';
        $err['err'] = 4;
        $err['msg'] = "temporary_key is expire ";
        $json_users = new arraytojson();
        $err = $json_users->JSON($err);

        print_r($err); //输出错误
        return $err;
    } else {

        if (isset($_REQUEST['temporary_key'])) {

            $temporary_key = $_REQUEST['temporary_key'];
            if (empty($temporary_key)) {
                $err = '';
                $err['err'] = 6;
                $err['msg'] = "temporary_key is null";
                $json_users = new arraytojson();
                $err = $json_users->JSON($err);

                print_r($err); //输出错误
                return $err;

            } else {
                $sql_one = "select temporary_key  from admin_user  where temporary_key='" . $temporary_key .
                    "' "; //and  users_sn ='" . $list_a['users_sn'] . "'
                $sql_one_r = $GLOBALS['db']->getRow($sql_one);

                //print_r($sql_one);
                if (!empty($sql_one_r)) {

                    require_once ('sub/sub_get_user.php');
                    $ex = new getusr;
                    $ex->method = $method;
                    $ex->list_array = $list_a;
                    $ex->update_method = $update_method;
                    $users_list = $ex->exes("user_code,user_name,user_name2,qddm,from_type", $sql_one_r['temporary_key']);

                    //users_sn,users_name,nick_name,sex,birthday,users_money,reg_time,last_login,is_warn,qq,weixin,sina,home_phone,mobile_phone,mobile_phone_2,mobile_phone_3,tzsy
                    $json_users = new arraytojson();
                    $ex->err = $json_users->JSON($users_list);

                    print_r($ex->err); //输出错误
                    return $ex->err;
                } else { //zhe
                    $err = '';
                    $err['err'] = 4;
                    $err['msg'] = "temporary_key is error";
                    $json_users = new arraytojson();
                    $err = $json_users->JSON($err);

                    print_r($err); //输出错误
                    return $err;
                }

            }


        }
    }


} else {
    $err = '';
    $err['err'] = 5;
    $err['msg'] = "temporary_key is unfind";
    $json_users = new arraytojson();
    $err = $json_users->JSON($err);

    print_r($err); //输出错误
    return $err;
}
}
else {
$err = '';
$err['err'] = 2;
$err['msg'] = "temporary_key is null";
$json_users = new arraytojson();
$err = $json_users->JSON($err);

print_r($err); //输出错误
return $err;

}

?>