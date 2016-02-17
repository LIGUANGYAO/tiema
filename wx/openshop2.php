<?php
define('IN_ECS', true);

define('CUSTOMER', 'CASLON');
require (dirname(__file__) . '/includes/init.php');


$Login_act = stripslashes($_COOKIE['OsLogin']);
$Login_act = unserialize($Login_act);
//print_r($Login_act);
$is_allow = $GLOBALS['db']->getOne(" select sesskey from sessions where sesskey='" .
    $Login_act['name'] . "' limit 1 ;");
//echo $is_allow;exit;
if ($is_allow) {
    //echo 1;

} else {
    //echo 2;
    header("Location: openshop.php");
}

if (!$Login_act) {
        return false;
}


if (empty($_REQUEST['m'])) {
    $_REQUEST['m'] = 'default';
} else {
    $_REQUEST['m'] = trim($_REQUEST['m']);
}


if ($_REQUEST['m'] == 'default') {

    $Login_act = stripslashes($_COOKIE['OsLogin']);
    $Login_act = unserialize($Login_act);
    $user_id = $Login_act['user_id'];
    $smarty->assign("user_id", $user_id);
    $smarty->display('excheck/index2.html');
}

if ($_REQUEST['m'] == 'log_out') {

    function log_out1()
    {
        setcookie("OsLogin", $tmpSerialize, time() - 999);
    }

    log_out1();
    echo "<script>window.location.href='openshop.php';</script>";


}


if ($_REQUEST['m'] == 'select') {

    $Login_act = stripslashes($_COOKIE['OsLogin']);
    $Login_act = unserialize($Login_act);
    $user_id = $Login_act['user_id'];

    $sql = "select user_id,card_sn,add_time from os_excheck where user_id='" . $user_id .
        "'";
    $res = $GLOBALS['db']->getAll($sql);
    //print_r($res);

    $smarty->assign("fall", "select");
    $smarty->assign("list", $res);
    $smarty->display('excheck/index3.html');
}


if ($_REQUEST['m'] == 'select2') {

    $Login_act = stripslashes($_COOKIE['OsLogin']);
    $Login_act = unserialize($Login_act);
    $user_id = $Login_act['user_id'];

    $sql = "SELECT b.id,b.openid,b.users_sn,b.nick_name,b.add_time FROM cj_qrcode_stat  a  inner join users b on a.openid=b.openid  where a.cj_sn ='".$user_id."'  order by b.add_time";
            $res = $GLOBALS['db']->getAll($sql);
    //print_r($res);
    $res['sum']=count($res);
   // print_r($res);
    $smarty->assign("fall", "select");
    $smarty->assign("list", $res);
    $smarty->display('excheck/index4.html');
}



if ($_REQUEST['m'] == 'check') {

    

    if (isset($_REQUEST['code'])) {
        $code = $_REQUEST['code'];
        if (CUSTOMER == 'CASLON' && U_DB2 == 1) {

            $sql32 = "select user_id,start_time,end_time,cv_amount from shop_vouchers where card_sn='" .
                $code . "' and is_active=1 and now() between start_time and end_time";
            $sql3 = $GLOBALS['db2']->getRow($sql32);

            //print_r($sql32);
            if (empty($sql3['user_id'])) {
                $arr = array(
                    "err" => "1",
                    "tel" => "",
                    "je" => "");
                print_r(json_encode($arr));
            } else {
                $arr = array(
                    "err" => "0",
                    "tel" => $sql3['user_id'],
                    "je" => $sql3['cv_amount']);
                print_r(json_encode($arr));
            }

        }
    }
}


if ($_REQUEST['m'] == 'check2') {

    
    function insert_shop_coupon()
    {
        $sql = "select * from os_excheck where is_send_coupon=0 ";
        $res = $GLOBALS['db']->getAll($sql);
        for ($i = 0; $i < count($res); $i++) {
            //insert shop_coupon(card_sn,pwd,start_time,end_time,provide_time,cc_amount,cc_aamount,user_id,sendTo,is_to_user) values ('123','123','2014-05-13 10:46:30','2014-05-13 10:46:30','2014-05-13 10:46:30','5','5','102198','102198',0)
            $sql1 = "select * from shop_vouchers where card_sn='" . $res[$i]['card_sn'] .
                "'  ";
            $res1 = $GLOBALS['db2']->getRow($sql1);
            if (!empty($res1)) {

                $sql111 = "select card_sn from  shop_coupon where  card_sn='" . $res[$i]['card_sn'] .
                    "'";
                $res111 = $GLOBALS['db2']->getRow($sql111);

                //获取奖券兑换单位
                $Os_sql = "select user_id from os_excheck where   card_sn='" . $res[$i]['card_sn'] .
                    "'";
                $Os_sql = $GLOBALS['db']->getRow($Os_sql);


                if (empty($res111)) {
                    //    $sql2 = "insert into shop_coupon(card_sn,pwd,start_time,end_time,provide_time,cc_amount,cc_aamount,user_id,sendTo,is_to_user) values ('" .
                    //                        $res1['card_sn'] . "','" . $res1['card_sn'] . "','" . $res1['start_time'] .
                    //                        "','" . $res1['end_time'] . "','" . $res1['provide_time'] . "','" . $res1['cv_amount'] .
                    //                        "','" . $res1['cv_amount'] . "','" . $Os_sql['user_id'] . "','" . $Os_sql['user_id'] .
                    //                        "',0)";

                    $sql2 = "insert into shop_coupon(card_sn,pwd,start_time,end_time,provide_time,cc_amount,cc_aamount,user_id,sendTo,is_to_user) values ('" .
                        $res1['card_sn'] . "','" . $res1['card_sn'] . "','" . $res1['start_time'] .
                        "','2020-01-01 00:00:00','" . $res1['provide_time'] . "','" . $res1['cv_amount'] .
                        "','" . $res1['cv_amount'] . "','" . $Os_sql['user_id'] . "','" . $Os_sql['user_id'] .
                        "',0)";


                    $sql2 = $GLOBALS['db2']->query($sql2);


                    $send = "update os_excheck set is_send_coupon=1 where card_sn='" . $res1['card_sn'] .
                        "' ";
                    $send = $GLOBALS['db']->query($send);
                }


            }


        }
    }


    if (isset($_REQUEST['code'])) {
        $code = $_REQUEST['code'];

        if (CUSTOMER == 'CASLON' && U_DB2 == 1) { //插入openshop,并将记录回写库
            $Login_act = stripslashes($_COOKIE['OsLogin']);
            $Login_act = unserialize($Login_act);
            $ime = date('Y-m-d H:i:s', time());


            $sql1 = "select card_sn,start_time,end_time from shop_vouchers where card_sn='" .
                $code . "' and  now() between start_time and end_time  ";
            $res1 = $GLOBALS['db2']->getRow($sql1);
            //now() not between d.start_time and d.end_time

            if (!empty($res1)) {

                $sql111 = "select card_sn from  os_excheck where  card_sn='" . $code . "'";
                $res111 = $GLOBALS['db']->getRow($sql111);
                if (empty($res111)) {
                    $sql32 = "update shop_vouchers set is_active=0 where card_sn='" . $code .
                        "' and is_active=1";
                    $sql3 = $GLOBALS['db2']->query($sql32);
                    $sql = "insert into os_excheck(user_id,card_sn,add_time) values ('" . $Login_act['user_id'] .
                        "','" . $code . "','" . $ime . "') ";
                    $res = $GLOBALS['db']->query($sql);

                    //增加逻辑20140603增加,将抵用券记录回传到现金券对应客户中
                    insert_shop_coupon();
                    echo "兑换成功";
                } else {
                    echo "已存在此兑换记录";
                }

            } else {
                echo "此奖券已过期作废";
            }


        }
    }
}


if ($_REQUEST['m'] == 'check3') {


    function insert_shop_coupon()
    {
        $sql = "select * from os_excheck where is_send_coupon=0 ";
        $res = $GLOBALS['db']->getAll($sql);
        for ($i = 0; $i < count($res); $i++) {
            //insert shop_coupon(card_sn,pwd,start_time,end_time,provide_time,cc_amount,cc_aamount,user_id,sendTo,is_to_user) values ('123','123','2014-05-13 10:46:30','2014-05-13 10:46:30','2014-05-13 10:46:30','5','5','102198','102198',0)
            $sql1 = "select * from shop_vouchers where card_sn='" . $res[$i]['card_sn'] .
                "'  ";
            $res1 = $GLOBALS['db2']->getRow($sql1);
            if (!empty($res1)) {

                $sql111 = "select card_sn from  shop_coupon where  card_sn='" . $res[$i]['card_sn'] .
                    "'";
                $res111 = $GLOBALS['db2']->getRow($sql111);

                //获取奖券兑换单位
                $Os_sql = "select user_id from os_excheck where   card_sn='" . $res[$i]['card_sn'] .
                    "'";
                $Os_sql = $GLOBALS['db']->getRow($Os_sql);

                if (empty($res111)) {
                    $sql2 = "insert into shop_coupon(card_sn,pwd,start_time,end_time,provide_time,cc_amount,cc_aamount,user_id,sendTo,is_to_user) values ('" .
                        $res1['card_sn'] . "','" . $res1['card_sn'] . "','" . $res1['start_time'] .
                        "','2020-01-01 00:00:00','" . $res1['provide_time'] . "','" . $res1['cv_amount'] .
                        "','" . $res1['cv_amount'] . "','" . $Os_sql['user_id'] . "','" . $Os_sql['user_id'] .
                        "',0)";
                    $sql2 = $GLOBALS['db2']->query($sql2);


                    $send = "update os_excheck set is_send_coupon=1 where card_sn='" . $res1['card_sn'] .
                        "' ";
                    $send = $GLOBALS['db']->query($send);
                }

            }


        }
    }

    insert_shop_coupon();

}



?>