<?php
$sql_key = " select token,temporary_time from menber  where token='" .
    $_REQUEST['temporary_key'] . "' ;";
//print_r($sql_key);exit;
$user_id = $GLOBALS['db']->getRow($sql_key);
if (!empty($user_id)) {
    $time_diff = get_time_diff($user_id['temporary_time']);
    //print_r($time_diff['hour']);
    if ($time_diff['hour'] >= 120) {
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
                $sql_one = "select token from menber  where token='" . $temporary_key .
                    "' "; //and  users_sn ='" . $list_a['users_sn'] . "'
                $sql_one_r = $GLOBALS['db']->getRow($sql_one);

                //print_r($sql_one);
                if (!empty($sql_one_r)) {
                    $tk_allow = 1;

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
    $err['msg'] =stripslashes("temporary_key is unfind") ;
    // $err['msg'] = "temporary_key is unfind";
    $json_users = new arraytojson();
    $err = $json_users->JSON($err);

    print_r($err); //输出错误
    return $err;
}
?>