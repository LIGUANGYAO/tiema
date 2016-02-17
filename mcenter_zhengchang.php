<?php

define('IN_ECS', true);


require (dirname(__file__) . '/sub/is_weixin.php');
require (dirname(__file__) . '/includes/init2.php');
$sql = " select app_id,app_secret from app_id where weixin_id=1";
$res = $GLOBALS['db']->getRow($sql);


if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}
//function getopenid()
//{
//    $cookie = stripslashes($_COOKIE['L_openid']);
//
//    $tmpUnSerialize = unserialize($cookie);
//    return $tmpUnSerialize;
//}
//
//$openid=getopenid();

if ($_REQUEST['act'] == 'default') {

    if (empty($_REQUEST['openid'])) {
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $res['app_id'] .
                '&secret=' . $res['app_secret'] . '&code=' . $code .
                '&grant_type=authorization_code';
            $headers = array("Content-Type: text/xml; charset=utf-8");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $output = curl_exec($ch);
            curl_close($ch);
            $jsonstr = json_decode($output);
            $access_token = $jsonstr->access_token;
            $refresh_token = $jsonstr->refresh_token;
            $openid = $jsonstr->openid;
        }

    } else {
        $openid = $_REQUEST['openid'];
    }
    //echo $openid;
    //$openid = 'osh4wuKUgkYxnGR9xowRaG7jwFz8';

    // $openid = serialize($openid);
    //
    //    setcookie("L_openid", $openid);

    $sql123 = "select openid,qrcode,wx_tel,wx_pwd,headimgurl,users_sn,nick_name,sn_imgurl from users where openid='" .
        $openid . "' ";
    $res = $GLOBALS['db']->getAll($sql123);
    //print_r($res);exit;
    if (empty($res[0]['wx_tel'])) {

        echo "<script>window.location.href='wxextel.php?openid=" . $openid .
            "';</script>";
    } else {


        $get_point = "select * from tgpoint  where openid ='" . $openid . "'";
        $get_point = $GLOBALS['db']->getAll($get_point);
        //print_r($get_point);
        if (empty($get_point)) {
            $smarty->assign('fenxiao', '0');
        } else {

            $smarty->assign('fenxiao', '1');
        }

        //开始判断是否有权限来进入兑奖中心

        function user_group($obj)
        {
            $sql = "SELECT a.group_sn,b.openid,b.nick_name FROM `wx_group` a inner join wx_users_group b on a.group_sn=b.group_sn where a.tzsy=0 and b.openid='" .
                $obj . "'";
            $res = $GLOBALS['db']->getAll($sql);
            return $res;
        }
        $group = user_group($openid);
        //print_r($group);
        if (!empty($group)) {
            $smarty->assign('djuser', '1');
        }

        //---------开始生成二维码

        //判断是否生成

        if ($res[0]['sn_imgurl'] != '') {
            //echo 1;
        } else {
            $code = $res[0]['users_sn'];
            $PNG_TEMP_DIR = dirname(__file__) . DIRECTORY_SEPARATOR . 'upload/temp' .
                DIRECTORY_SEPARATOR;
            $PNG_WEB_DIR = 'upload/temp/';
            include "wx/phpqrcode/qrlib.php";
            if (!file_exists($PNG_TEMP_DIR))
                mkdir($PNG_TEMP_DIR);
            $filename = $PNG_TEMP_DIR . 'test.png';
            $errorCorrectionLevel = 'L';
            //if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
            //    $errorCorrectionLevel = $_REQUEST['level'];

            $matrixPointSize = 10;
            //if (isset($_REQUEST['size']))
            //    $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


            if (isset($code)) {
                if (trim($code) == '')
                    die('data cannot be empty! <a href="?">back</a>');
                $filename = $PNG_TEMP_DIR . '' . md5($code . '|' . $errorCorrectionLevel . '|' .
                    $matrixPointSize) . '.png';
                QRcode::png($code, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

            } else {
                echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';
                QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize,
                    2);

            }
            $temp_qrcode = '' . md5($code . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) .
                '.png';
            $up_lo = "update users set sn_imgurl='" . $temp_qrcode . "' where openid='" . $openid .
                "'";
            $up_lo = $GLOBALS['db']->query($up_lo);

            $up_lo2 = "select sn_imgurl from users where openid='" . $openid . "' ";
            $up_lo2 = $GLOBALS['db']->getRow($up_lo2);
            $res[0]['sn_imgurl'] = $up_lo2['sn_imgurl'];

        }

        //-------end

        $smarty->assign('op', $openid);
        $smarty->assign('fall', 'list');
        $smarty->assign('openid', $res[0]);

        if ($openid == 'oRq2yuKBPELdlAjIp1ZxGwJg4-6s') {
            $dis = 1;
        }
        $dis = 1;
        if ($dis == 1) {

            $ar = array(
                "m1",
                "m2",
                "m3",
                "m4",
                "m5",
                "m6",
                "m7",
                "m8",
                "m9",
                "m10",
                "m11",
                "m12",
                "m13",
                "m14",
                "m15",
                "m16");
            shuffle($ar);
            //print_r($ar);
            $smarty->assign('arr', $ar);
            $smarty->display('other/xc/index2.html');
        } else {
            $smarty->display('mcenter_3.tpl');
        }


    }
}


if ($_REQUEST['act'] == 'fenxiang') {

    if (empty($_REQUEST['openid'])) {
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $res['app_id'] .
                '&secret=' . $res['app_secret'] . '&code=' . $code .
                '&grant_type=authorization_code';
            $headers = array("Content-Type: text/xml; charset=utf-8");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $output = curl_exec($ch);
            curl_close($ch);
            $jsonstr = json_decode($output);
            $access_token = $jsonstr->access_token;
            $refresh_token = $jsonstr->refresh_token;
            $openid = $jsonstr->openid;
        }

    } else {
        $openid = $_REQUEST['openid'];
    }
    
    header("Location: fenxiang.php?openid=".$openid.""); 
}


if ($_REQUEST['act'] == 'cen2') {

    if (empty($_REQUEST['openid'])) {
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $res['app_id'] .
                '&secret=' . $res['app_secret'] . '&code=' . $code .
                '&grant_type=authorization_code';
            $headers = array("Content-Type: text/xml; charset=utf-8");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $output = curl_exec($ch);
            curl_close($ch);
            $jsonstr = json_decode($output);
            $access_token = $jsonstr->access_token;
            $refresh_token = $jsonstr->refresh_token;
            $openid = $jsonstr->openid;
        }

    } else {
        $openid = $_REQUEST['openid'];
    }
    //echo $openid;
    //$openid = 'osh4wuKUgkYxnGR9xowRaG7jwFz8';

    // $openid = serialize($openid);
    //
    //    setcookie("L_openid", $openid);

    $sql123 = "select openid,qrcode,wx_tel,wx_pwd,headimgurl,users_sn,nick_name,sn_imgurl from users where openid='" .
        $openid . "' ";
    $res = $GLOBALS['db']->getAll($sql123);
    //print_r($res);exit;
    if (empty($res[0]['wx_tel'])) {

        echo "<script>window.location.href='wxextel.php?openid=" . $openid .
            "';</script>";
    } else {


        $get_point = "select * from tgpoint  where openid ='" . $openid . "'";
        $get_point = $GLOBALS['db']->getAll($get_point);
        //print_r($get_point);
        if (empty($get_point)) {
            $smarty->assign('fenxiao', '0');
        } else {

            $smarty->assign('fenxiao', '1');
        }

        //开始判断是否有权限来进入兑奖中心

        function user_group($obj)
        {
            $sql = "SELECT a.group_sn,b.openid,b.nick_name FROM `wx_group` a inner join wx_users_group b on a.group_sn=b.group_sn where a.tzsy=0 and b.openid='" .
                $obj . "'";
            $res = $GLOBALS['db']->getAll($sql);
            return $res;
        }
        $group = user_group($openid);
        //print_r($group);
        if (!empty($group)) {
            $smarty->assign('djuser', '1');
        }

        //---------开始生成二维码

        //判断是否生成

        if ($res[0]['sn_imgurl'] != '') {
            //echo 1;
        } else {
            $code = $res[0]['users_sn'];
            $PNG_TEMP_DIR = dirname(__file__) . DIRECTORY_SEPARATOR . 'upload/temp' .
                DIRECTORY_SEPARATOR;
            $PNG_WEB_DIR = 'upload/temp/';
            include "wx/phpqrcode/qrlib.php";
            if (!file_exists($PNG_TEMP_DIR))
                mkdir($PNG_TEMP_DIR);
            $filename = $PNG_TEMP_DIR . 'test.png';
            $errorCorrectionLevel = 'L';
            //if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
            //    $errorCorrectionLevel = $_REQUEST['level'];

            $matrixPointSize = 10;
            //if (isset($_REQUEST['size']))
            //    $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


            if (isset($code)) {
                if (trim($code) == '')
                    die('data cannot be empty! <a href="?">back</a>');
                $filename = $PNG_TEMP_DIR . '' . md5($code . '|' . $errorCorrectionLevel . '|' .
                    $matrixPointSize) . '.png';
                QRcode::png($code, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

            } else {
                echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';
                QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize,
                    2);

            }
            $temp_qrcode = '' . md5($code . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) .
                '.png';
            $up_lo = "update users set sn_imgurl='" . $temp_qrcode . "' where openid='" . $openid .
                "'";
            $up_lo = $GLOBALS['db']->query($up_lo);

            $up_lo2 = "select sn_imgurl from users where openid='" . $openid . "' ";
            $up_lo2 = $GLOBALS['db']->getRow($up_lo2);
            $res[0]['sn_imgurl'] = $up_lo2['sn_imgurl'];

        }

        //-------end

        $smarty->assign('op', $openid);
        $smarty->assign('fall', 'list');
        $smarty->assign('openid', $res[0]);

        if ($openid == 'oRq2yuKBPELdlAjIp1ZxGwJg4-6s') {
            $dis = 1;
        }
        $dis = 0;
        if ($dis == 1) {

            $ar = array(
                "m1",
                "m2",
                "m3",
                "m4",
                "m5",
                "m6",
                "m7",
                "m8",
                "m9",
                "m10",
                "m11",
                "m12",
                "m13",
                "m14",
                "m15",
                "m16");
            shuffle($ar);
            //print_r($ar);
            $smarty->assign('arr', $ar);
            $smarty->display('other/xc/index.html');
        } else {
            $smarty->display('mcenter_3.tpl');
        }


    }
}


if ($_REQUEST['act'] == 'list2') {


    $openid = $_REQUEST['openid'];

    $sql123 = "select openid,qrcode,wx_tel,wx_pwd,headimgurl,users_sn,nick_name,sn_imgurl from users where openid='" .
        $openid . "' ";
    $res = $GLOBALS['db']->getAll($sql123);
    //print_r($res);exit;
    if (empty($res[0]['wx_tel'])) {

        echo "<script>window.location.href='wxextel.php?openid=" . $openid .
            "';</script>";
    } else {

        $get_point = "select * from tgpoint  where openid ='" . $openid . "'";
        $get_point = $GLOBALS['db']->getAll($get_point);
        //print_r($get_point);
        if (empty($get_point)) {
            $smarty->assign('fenxiao', '0');
        } else {

            $smarty->assign('fenxiao', '1');
        }

        //开始判断是否有权限来进入兑奖中心

        function user_group($obj)
        {
            $sql = "SELECT a.group_sn,b.openid,b.nick_name FROM `wx_group` a inner join wx_users_group b on a.group_sn=b.group_sn where a.tzsy=0 and b.openid='" .
                $obj . "'";
            $res = $GLOBALS['db']->getAll($sql);
            return $res;
        }
        $group = user_group($openid);
        //print_r($group);
        if (!empty($group)) {
            $smarty->assign('djuser', '1');
        }

        //---------开始生成二维码

        //判断是否生成

        if ($res[0]['sn_imgurl'] != '') {
            // echo 1;
        } else {
            $code = $res[0]['users_sn'];
            $PNG_TEMP_DIR = dirname(__file__) . DIRECTORY_SEPARATOR . 'upload/temp' .
                DIRECTORY_SEPARATOR;
            $PNG_WEB_DIR = 'upload/temp/';
            include "wx/phpqrcode/qrlib.php";
            if (!file_exists($PNG_TEMP_DIR))
                mkdir($PNG_TEMP_DIR);
            $filename = $PNG_TEMP_DIR . 'test.png';
            $errorCorrectionLevel = 'L';
            //if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
            //    $errorCorrectionLevel = $_REQUEST['level'];

            $matrixPointSize = 10;
            //if (isset($_REQUEST['size']))
            //    $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


            if (isset($code)) {
                if (trim($code) == '')
                    die('data cannot be empty! <a href="?">back</a>');
                $filename = $PNG_TEMP_DIR . '' . md5($code . '|' . $errorCorrectionLevel . '|' .
                    $matrixPointSize) . '.png';
                QRcode::png($code, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

            } else {
                echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';
                QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize,
                    2);

            }
            $temp_qrcode = '' . md5($code . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) .
                '.png';
            $up_lo = "update users set sn_imgurl='" . $temp_qrcode . "' where openid='" . $openid .
                "'";
            $up_lo = $GLOBALS['db']->query($up_lo);

            $up_lo2 = "select sn_imgurl from users where openid='" . $openid . "' ";
            $up_lo2 = $GLOBALS['db']->getRow($up_lo2);
            $res[0]['sn_imgurl'] = $up_lo2['sn_imgurl'];

        }

        //-------end
        $smarty->assign('fall', 'list2');
        $smarty->assign('op', $openid);
        $smarty->assign('openid', $res[0]);
        $smarty->display('mcenter_3.tpl');
    }
}


if ($_REQUEST['act'] == 'jiameng') {
    function generate_password($length = 30)
    {
        // 密码字符集，可任意添加你需要的字符
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            // 这里提供两种字符获取方式
            // 第一种是使用 substr 截取$chars中的任意一位字符；
            // 第二种是取字符数组 $chars 的任意元素
            // $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        $t = date('Y-m-d H:i:s', time());
        return md5($password . $t);
    }

    $random_code = generate_password(20);
    $smarty->assign('random_code', $random_code);

    if (empty($_REQUEST['openid'])) {
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $res['app_id'] .
                '&secret=' . $res['app_secret'] . '&code=' . $code .
                '&grant_type=authorization_code';
            $headers = array("Content-Type: text/xml; charset=utf-8");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $output = curl_exec($ch);
            curl_close($ch);
            $jsonstr = json_decode($output);
            $access_token = $jsonstr->access_token;
            $refresh_token = $jsonstr->refresh_token;
            $openid = $jsonstr->openid;
        }

    } else {
        $openid = $_REQUEST['openid'];
    }

    $get_point = "select * from tgpoint  where openid ='" . $openid . "'";
    $get_point = $GLOBALS['db']->getAll($get_point);
    //print_r($get_point);
    if (empty($get_point)) {
        $smarty->assign('fenxiao', '0');
    } else {

        $smarty->assign('fenxiao', '1');
    }


    //$openid = $_REQUEST['openid'];
    $smarty->assign('fall', 'jiameng');
    $smarty->assign('op', $openid);
    $smarty->display('mcenter_3.tpl');
}

if ($_REQUEST['act'] == 'duijiang') {


    $openid = $_REQUEST['openid'];

    $smarty->assign('fall', 'duijiang');
    $smarty->assign('op', $openid);
    $smarty->display('mcenter_3.tpl');
}

if ($_REQUEST['act'] == 'up_info') {
    $openid = $_REQUEST['openid'];
    $smarty->assign('fall', 'duijiang');
    $smarty->assign('op', $openid);
    $smarty->display('mcenter_3.tpl');
}


if ($_REQUEST['act'] == 'lvmsg') {


    $openid = $_REQUEST['op'];
    $name = trim($_REQUEST['xingming']);
    $tel = trim($_REQUEST['tel']);
    $email = trim($_REQUEST['email']);
    $address = trim($_REQUEST['address']);
    $random = trim($_REQUEST['random_code']);

    $note = trim($_REQUEST['leavemsg']);
    $t1 = date('Y-m-d H:i:s', time());
    $t2 = date('Y-m-d', time());


    $get_ont = "select openid from wx_lv_msg where random_code='" . $random . "'";
    $get_ont = $GLOBALS['db']->getRow($get_ont);
    if (empty($get_ont)) {
        $sql = "insert into wx_lv_msg (openid,name,tel,email,note,add_time,last_update_2,address,random_code) values ('" .
            $openid . "','" . $name . "','" . $tel . "','" . $email . "','" . $note . "','" .
            $t1 . "','" . $t2 . "','" . $address . "','" . $random . "')";
        $res = $GLOBALS['db']->query($sql);

    }


    $smarty->assign('fall', 'lvmsg');
    $smarty->assign('op', $openid);
    $smarty->display('mcenter_3.tpl');
    //header("Location: mcenter.php?openid=" . $openid);
}

if ($_REQUEST['act'] == 'search_code') {

    if (isset($_REQUEST['sncode'])) {
        $t1 = date('Y-m-d H:i:s', time());

        $sncode = trim($_REQUEST['sncode']);
        $openid = trim($_REQUEST['openid']);

        function get_sn($obj)
        {
            $sql = "select a.activity_sn,a.activity_name,b.*,c.*,case when c.prizetype=1 then b.prize1_jpms  when c.prizetype=2 then b.prize2_jpms when c.prizetype=3 then b.prize3_jpms end as jpmc  from activity a inner join activity_mx b on a.activity_sn=b.p_id inner join wx_sncode c on a.activity_sn=c.hd_sn where c.sncode='" .
                $obj . "'";
            $res = $GLOBALS['db']->getRow($sql);
            //print_r($res);
            return $res;

        }
        $sntype = get_sn($sncode);
        if (empty($sntype)) {


            //不存在奖券；
            $sql_sn = "select hd_sn as hd_sn,'实物券' as activity_name,note as jpmc,sncode,add_time,is_use,limit_time from wx_sncode_real where sncode='" .
                $sncode . "'";
            $sql_sn = $GLOBALS['db']->getRow($sql_sn);
            if (empty($sql_sn)) {
                $err = array(
                    "err_code" => 1,
                    "err_msg" => "兑奖码输入错误/兑奖码不存在",
                    "list" => array());

            } elseif ($sql_sn['is_use'] == 1) {
                $err = array(
                    "err_code" => 1,
                    "err_msg" => "兑奖码已使用",
                    "list" => array());

            } elseif ($t1 < $sql_sn['add_time'] || $t1 > $sql_sn['limit_time']) {
                $err = array(
                    "err_code" => 1,
                    "err_msg" => "兑奖码已经过期,最后使用日期为\n" . $sql_sn['limit_time'],
                    "list" => array());
            } else {
                $err = array(
                    "err_code" => 0,
                    "err_msg" => "兑奖码可以使用",
                    "list" => $sql_sn);
            }
            //增加实物券兑换判断

            //


        } elseif ($sntype['is_use'] == 1) {
            $err = array(
                "err_code" => 1,
                "err_msg" => "兑奖码已使用",
                "list" => array());

        } elseif ($t1 < $sntype['add_time'] || $t1 > $sntype['limit_time']) {
            $err = array(
                "err_code" => 1,
                "err_msg" => "兑奖码已经过期,最后使用日期为\n" . $sntype['limit_time'],
                "list" => array());
        } else {
            $err = array(
                "err_code" => 0,
                "err_msg" => "兑奖码可以使用",
                "list" => $sntype);
        }

        print_r(json_encode($err));
        //print_r(get_sn($sncode));
    }

}

if ($_REQUEST['act'] == 'search_code2') {

    if (isset($_REQUEST['sncode'])) {
        $t1 = date('Y-m-d H:i:s', time());
        $sncode = trim($_REQUEST['sncode']);
        $openid = trim($_REQUEST['openid']);

        function get_sn($obj)
        {
            $sql = "select a.activity_sn,a.activity_name,b.*,c.*,case when c.prizetype=1 then b.prize1_jpms  when c.prizetype=2 then b.prize2_jpms when c.prizetype=3 then b.prize3_jpms end as jpmc  from activity a inner join activity_mx b on a.activity_sn=b.p_id inner join wx_sncode c on a.activity_sn=c.hd_sn where c.sncode='" .
                $obj . "'";
            $res = $GLOBALS['db']->getRow($sql);
            //print_r($res);
            return $res;

        }
        $sntype = get_sn($sncode);
        if (empty($sntype)) {
            //兑换实物券

            $sql_sn = "select hd_sn as hd_sn,'实物券' as activity_name,note as jpmc,sncode,add_time,is_use,limit_time from wx_sncode_real where sncode='" .
                $sncode . "'";
            $sql_sn = $GLOBALS['db']->getRow($sql_sn);
            //不存在奖券；
            if (empty($sql_sn)) {
                //不存在奖券；
                $err = array(
                    "err_code" => 1,
                    "err_msg" => "兑奖码输入错误/兑奖码不存在",
                    "list" => array());

            } elseif ($sql_sn['is_use'] == 1) {
                $err = array(
                    "err_code" => 1,
                    "err_msg" => "兑奖码已使用",
                    "list" => array());

            } elseif ($t1 < $sql_sn['add_time'] || $t1 > $sql_sn['limit_time']) {
                $err = array(
                    "err_code" => 1,
                    "err_msg" => "兑奖码已经过期,最后使用日期为\n" . $sql_sn['limit_time'],
                    "list" => array());
            } else {
                $sql = "update wx_sncode_real set is_use=1 where sncode='" . $sncode . "'";
                $sql = $GLOBALS['db']->query($sql);


                //插入类
                function insert_shop_coupon($code, $openid, $t1)
                {
                    $sql111 = "select card_sn from  wx_excheck where  card_sn='" . $code . "'";
                    $res111 = $GLOBALS['db']->getRow($sql111);
                    if (empty($res111)) {

                        $sql = "insert into wx_excheck(user_id,card_sn,add_time) values ('" . $openid .
                            "','" . $code . "','" . $t1 . "') ";
                        $res = $GLOBALS['db']->query($sql);

                    }


                }

                insert_shop_coupon($sncode, $openid, $t1);
                //插入积分兑换单

                $err = array(
                    "err_code" => 0,
                    "err_msg" => "兑换成功",
                    "list" => $sql_sn);
            }

        } elseif ($sntype['is_use'] == 1) {
            $err = array(
                "err_code" => 1,
                "err_msg" => "兑奖码已使用",
                "list" => array());

        } elseif ($t1 < $sntype['add_time'] || $t1 > $sntype['limit_time']) {
            $err = array(
                "err_code" => 1,
                "err_msg" => "兑奖码已经过期,最后使用日期为\n" . $sntype['limit_time'],
                "list" => array());
        } else {
            $sql = "update wx_sncode set is_use=1 where sncode='" . $sncode . "'";
            $sql = $GLOBALS['db']->query($sql);


            //插入类
            function insert_shop_coupon($code, $openid, $t1)
            {
                $sql111 = "select card_sn from  wx_excheck where  card_sn='" . $code . "'";
                $res111 = $GLOBALS['db']->getRow($sql111);
                if (empty($res111)) {

                    $sql = "insert into wx_excheck(user_id,card_sn,add_time) values ('" . $openid .
                        "','" . $code . "','" . $t1 . "') ";
                    $res = $GLOBALS['db']->query($sql);

                }


            }

            insert_shop_coupon($sncode, $openid, $t1);
            //插入积分兑换单

            $err = array(
                "err_code" => 0,
                "err_msg" => "兑换成功",
                "list" => $sntype);
        }

        print_r(json_encode($err));
        //print_r(get_sn($sncode));
    }

}


if ($_REQUEST['act'] == 'duihuanjifen') {

    function get_ex_point()
    {
        $sql = "select a.val,b.p_id,b.type,b.type_val from set_sys a inner join set_sys_mx b on a.keyword=b.p_id where a.keyword='ex_point' order by type";
        $res = $GLOBALS['db']->getAll($sql);

        return array("list" => $res, "ex_point" => $res[0]['val']);

    }
    $get_ex_point = get_ex_point();
    if ($get_ex_point['ex_point'] == 0) {
        $err = array(
            "err_code" => 1,
            "err_msg" => "不允许将奖券兑换成积分",
            "list" => array());

        print_r(json_encode($err));
        exit;
    }

    if (isset($_REQUEST['sncode'])) {
        $t1 = date('Y-m-d H:i:s', time());
        $sncode = trim($_REQUEST['sncode']);
        $openid = trim($_REQUEST['openid']);
        $ex_point = $_REQUEST['ex_point'];
        function get_sn($obj)
        {
            $sql = "select a.activity_sn,a.activity_name,b.*,c.*,case when c.prizetype=1 then b.prize1_jpms  when c.prizetype=2 then b.prize2_jpms when c.prizetype=3 then b.prize3_jpms end as jpmc  from activity a inner join activity_mx b on a.activity_sn=b.p_id inner join wx_sncode c on a.activity_sn=c.hd_sn where c.sncode='" .
                $obj . "'";
            $res = $GLOBALS['db']->getRow($sql);
            //print_r($res);
            return $res;

        }
        $sntype = get_sn($sncode);
        if (empty($sntype)) {
            //不存在奖券；
            $err = array(
                "err_code" => 1,
                "err_msg" => "兑奖码输入错误/兑奖码不存在",
                "list" => array());

        } elseif ($sntype['is_use'] == 1) {
            $err = array(
                "err_code" => 1,
                "err_msg" => "兑奖码已使用",
                "list" => array());

        } elseif ($t1 < $sntype['add_time'] || $t1 > $sntype['limit_time']) {
            $err = array(
                "err_code" => 1,
                "err_msg" => "兑奖码已经过期,最后使用日期为\n" . $sntype['limit_time'],
                "list" => array());
        } else {
            $sql = "update wx_sncode set is_use=1 where sncode='" . $sncode . "'";
            $sql = $GLOBALS['db']->query($sql);


            //插入类
            function insert_shop_coupon($code, $openid, $t1, $ex_point)
            {
                $sql111 = "select card_sn from  wx_excheck where  card_sn='" . $code . "'";
                $res111 = $GLOBALS['db']->getRow($sql111);
                if (empty($res111)) {

                    $sql = "insert into wx_excheck(user_id,card_sn,add_time,point) values ('" . $openid .
                        "','" . $code . "','" . $t1 . "','" . $ex_point . "') ";
                    $res = $GLOBALS['db']->query($sql);

                }
            }

            insert_shop_coupon($sncode, $openid, $t1, $ex_point);

            function insert_expoint($sncode, $openid, $ex_point)
            {
                $add_time = date('Y-m-d H:i:s', time());
                $last_update_2 = date('Y-m-d', time());
                $seach = "select openid,is_check,add_time,last_update_2 from users_expoint_log where sncode='" .
                    $sncode . "'   ";
                $seach = $GLOBALS['db']->getAll($seach);
                if (empty($seach)) {
                    $sql_check = "insert into users_expoint_log(openid,is_check,add_time,last_update_2,rank_points,type,sncode) values ('" .
                        $openid . "','1','" . $add_time . "','" . $last_update_2 . "','" . $ex_point .
                        "',1,'" . $sncode . "')";
                    $sql_check = $GLOBALS['db']->query($sql_check);

                }


            }
            insert_expoint($sncode, $openid, $ex_point);

            $err = array(
                "err_code" => 0,
                "err_msg" => "兑换成功",
                "list" => $sntype);
        }

        print_r(json_encode($err));
        //print_r(get_sn($sncode));
    }

}

if ($_REQUEST['act'] == 'dhreal') {
    $openid = $_REQUEST['openid'];
    function generate_password($length = 30)
    {
        // 密码字符集，可任意添加你需要的字符
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            // 这里提供两种字符获取方式
            // 第一种是使用 substr 截取$chars中的任意一位字符；
            // 第二种是取字符数组 $chars 的任意元素
            // $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        $t = date('Y-m-d H:i:s', time());
        return md5($password . $t);
    }

    $lo_sn = generate_password();

    function get_ex_real()
    {
        $sql = "select a.val,b.p_id,b.type,b.type_val,b.note from set_sys a inner join set_sys_mx b on a.keyword=b.p_id where a.keyword='ex_real' and type_val>0 order by type";
        $res = $GLOBALS['db']->getAll($sql);

        return array("list" => $res, "ex_real" => $res[0]['val']);
    }
    $get_ex_real = get_ex_real();


    //计算出实际积分
    function real_jifen($openid)
    {
        $sum1 = "select sum(rank_points) as sl from users_check_log where openid='" . $openid .
            "' order by add_time desc";
        $sum1 = $GLOBALS['db']->getRow($sum1);
        $sum2 = "select sum(rank_points) as sl from users_expoint_log where openid='" .
            $openid . "' order by add_time desc";
        $sum2 = $GLOBALS['db']->getRow($sum2);

        $sum3 = "select sum(type_val) as sl from wx_sncode_real where openid='" . $openid .
            "' order by add_time desc";
        $sum3 = $GLOBALS['db']->getRow($sum3);
        return $sum1['sl'] + $sum2['sl'] - $sum3['sl'];
    }
    $jifen = real_jifen($openid);

    //---
    // print_r($get_ex_real);
    $smarty->assign('ex_real_val', $get_ex_real['ex_real']);
    $smarty->assign('ex_real', $get_ex_real['list']);


    $smarty->assign('fall', 'dhreal');
    $smarty->assign('op', $openid);
    $smarty->assign('jifen', $jifen);
    $smarty->assign('sn', $lo_sn);
    $smarty->display('mcenter_3.tpl');
}


if ($_REQUEST['act'] == 'duihuanreal') {

    $t1 = date('Y-m-d H:i:s', time());
    $lo_sn = trim($_REQUEST['lo_sn']);
    $openid = trim($_REQUEST['openid']);
    $type_val = $_REQUEST['type_val'];
    $note = $_REQUEST['note'];

    function get_ex_real()
    {
        $sql = "select a.val,b.p_id,b.type,b.type_val from set_sys a inner join set_sys_mx b on a.keyword=b.p_id where a.keyword='ex_real' order by type";
        $res = $GLOBALS['db']->getAll($sql);

        return array("list" => $res, "ex_real" => $res[0]['val']);

    }
    $get_ex_real = get_ex_real();
    if ($get_ex_real['ex_real'] == 0) {
        $err = array(
            "err_code" => 1,
            "err_msg" => "不允许将积分兑换成实物券",
            "list" => array());

        print_r(json_encode($err));
        exit;
    }

    function real_jifen($openid)
    {
        $sum1 = "select sum(rank_points) as sl from users_check_log where openid='" . $openid .
            "' order by add_time desc";
        $sum1 = $GLOBALS['db']->getRow($sum1);
        $sum2 = "select sum(rank_points) as sl from users_expoint_log where openid='" .
            $openid . "' order by add_time desc";
        $sum2 = $GLOBALS['db']->getRow($sum2);

        $sum3 = "select sum(type_val) as sl from wx_sncode_real where openid='" . $openid .
            "' order by add_time desc";
        $sum3 = $GLOBALS['db']->getRow($sum3);
        return $sum1['sl'] + $sum2['sl'] - $sum3['sl'];
    }
    $jifen = real_jifen($openid);


    if ($jifen < $type_val) {
        $err = array(
            "err_code" => 1,
            "err_msg" => "可用积分不够,无法兑换",
            "list" => array());

        print_r(json_encode($err));
        exit;
    }

    if (isset($_REQUEST['lo_sn'])) {

        function int_password($length = 8)
        {
            // 密码字符集，可任意添加你需要的字符
            $chars = '123456789';
            $password = '';
            for ($i = 0; $i < $length; $i++) {
                // 这里提供两种字符获取方式
                // 第一种是使用 substr 截取$chars中的任意一位字符；
                // 第二种是取字符数组 $chars 的任意元素
                // $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
                $password .= $chars[mt_rand(0, strlen($chars) - 1)];
            }
            $t = date('Y-m-d H:i:s', time());
            return $password;
        }
        ///////////////////////////日期转换函数
        function datetounit($obj)
        {
            if (isset($obj)) {
                $obj = strtotime($obj);
            }
            return $obj;
        }

        function unittodate($obj, $limit_time)
        {
            if (isset($obj)) {
                $obj = $obj + ($limit_time * 24 * 3600);
                $obj = date('Y-m-d H:i:s', $obj);
            }
            return $obj;
        }
        ///////////////////////////日期转换函数

        $code = int_password();


        function get_snreal($random_code, $openid, $type_val, $note, $code)
        {
            $time = date('Y-m-d', time());
            $time2 = date('Y-m-d H:i:s', time());
            $time3 = datetounit($time2);
            $limittime = unittodate($time3, 90); //到期时间
            $sql = "select random_code from wx_sncode_real where random_code='" . $random_code .
                "'";
            $res = $GLOBALS['db']->getRow($sql);
            if (empty($res)) {
                $sql3 = "insert into wx_sncode_real(type_val,note,openid,sncode,prizetype,add_time,limit_time,hd_sn,lo_date,random_code) values ('" .
                    $type_val . "','" . $note . "','" . $openid . "','" . $code . "','0','" . $time2 .
                    "','" . $limittime . "','000','100','" . $random_code . "')";
                $sql3 = $GLOBALS['db']->query($sql3);
                return 1;
            } else {
                return 0;
            }

        }

        $aa = get_snreal($lo_sn, $openid, $type_val, $note, $code);
        if ($aa == 1) {
            $err = array(
                "err_code" => 0,
                "err_msg" => "兑换成功",
                "list" => $sntype);

        } else {
            $err = array(
                "err_code" => 1,
                "err_msg" => "禁止重复兑换",
                "list" => $sntype);

        }


        print_r(json_encode($err));
        //print_r(get_sn($sncode));
    }

}

//中奖记录查询
if ($_REQUEST['act'] == 'ewm') {


    //----积分兑换
    function get_ex_point($obj)
    {
        $sql = "select a.val,b.* from set_sys a inner join set_sys_mx b  where a.keyword='ex_point' and b.type='" .
            $obj . "' order by type";
        $res = $GLOBALS['db']->getAll($sql);

        return array("list" => $res, "ex_point" => $res[0]['val']);
    }
    //----
    if (isset($_REQUEST['openid'])) {

    } else {
        exit;
    }

    $t1 = date('Y-m-d H:i:s', time());
    $openid = trim($_REQUEST['openid']);
    $is_active = trim($_REQUEST['is_active']);

    if ($is_active == 1) {
        // $ac1="select a.activity_sn,b.*,c.*,case when c.prizetype=1 then b.prize1_jpms  when c.prizetype=2 then b.prize2_jpms when c.prizetype=3 then b.prize3_jpms end as jpms  from activity a inner join activity_mx b on a.activity_sn=b.p_id inner join wx_sncode c on a.activity_sn=c.hd_sn where  now() between c.add_time and c.limit_time and is_user=0";
        $ac1 = "select a.activity_sn,a.activity_name,b.*,c.*,case when c.prizetype=1 then b.prize1_jpms  when c.prizetype=2 then b.prize2_jpms when c.prizetype=3 then b.prize3_jpms end as jpmc  from activity a inner join activity_mx b on a.activity_sn=b.p_id inner join wx_sncode c on a.activity_sn=c.hd_sn where ( '" .
            $t1 . "'>c.add_time and '" . $t1 .
            "'<c.limit_time ) and is_use=0 and c.openid='" . $openid .
            "' order by c.add_time desc";

        $res = $GLOBALS['db']->getAll($ac1);
        for ($i = 0; $i < count($res); $i++) {
            $ex = get_ex_point($res[$i]['prizetype']);
            //print_r($ex);
            $res[$i]['ex_point'] = $ex['list']['0']['type_val'];
        }
        //print_r($res);

    } elseif ($is_active == 2) {
        $ac1 = "select a.activity_sn,a.activity_name,b.*,c.*,case when c.prizetype=1 then b.prize1_jpms  when c.prizetype=2 then b.prize2_jpms when c.prizetype=3 then b.prize3_jpms end as jpmc  from activity a inner join activity_mx b on a.activity_sn=b.p_id inner join wx_sncode c on a.activity_sn=c.hd_sn where ( '" .
            $t1 . "'>c.add_time and '" . $t1 .
            "'<c.limit_time ) and is_use=1 and c.openid='" . $openid .
            "' order by c.add_time desc";

        $res = $GLOBALS['db']->getAll($ac1);

    } elseif ($is_active == 3) {
        $ac1 = "select a.activity_sn,a.activity_name,b.*,c.*,case when c.prizetype=1 then b.prize1_jpms  when c.prizetype=2 then b.prize2_jpms when c.prizetype=3 then b.prize3_jpms end as jpmc  from activity a inner join activity_mx b on a.activity_sn=b.p_id inner join wx_sncode c on a.activity_sn=c.hd_sn where  '" .
            $t1 . "'>=c.limit_time and c.openid='" . $openid . "' order by c.add_time desc";

        $res = $GLOBALS['db']->getAll($ac1);


    }

    //是否可以兑换成奖励

    $get_ex_point = get_ex_point("1");
    //print_r($get_ex_point);
    if ($get_ex_point['ex_point'] == 1) {
        $smarty->assign('ex_point', 1);
        $smarty->assign('get_ex_point', $get_ex_point['list']);
    } else {
        $smarty->assign('ex_point', 0);
    }


    $smarty->assign('is_active', $is_active);
    // $smarty->assign('openid2', $openid);
    $smarty->assign('sncode', $res);
    $smarty->assign('fall', 'ewm');
    $smarty->assign('op', $openid);
    $smarty->display('mcenter_3.tpl');
}

//中奖记录查询
if ($_REQUEST['act'] == 'ewm2') {


    //----积分兑换
    function get_ex_real($obj)
    {
        $sql = "select a.val,b.* from set_sys a inner join set_sys_mx b  where a.keyword='ex_real' and b.type='" .
            $obj . "' order by type";
        $res = $GLOBALS['db']->getAll($sql);

        return array("list" => $res, "ex_real" => $res[0]['val']);
    }
    //----
    if (isset($_REQUEST['openid'])) {

    } else {
        exit;
    }

    $t1 = date('Y-m-d H:i:s', time());
    $openid = trim($_REQUEST['openid']);
    $is_active = trim($_REQUEST['is_active']);

    if ($is_active == 1) {
        // $ac1="select a.activity_sn,b.*,c.*,case when c.prizetype=1 then b.prize1_jpms  when c.prizetype=2 then b.prize2_jpms when c.prizetype=3 then b.prize3_jpms end as jpms  from activity a inner join activity_mx b on a.activity_sn=b.p_id inner join wx_sncode c on a.activity_sn=c.hd_sn where  now() between c.add_time and c.limit_time and is_user=0";
        $ac1 = "select *  from wx_sncode_real  where ( '" . $t1 . "'>add_time and '" . $t1 .
            "'<limit_time ) and is_use=0 and openid='" . $openid .
            "' order by add_time desc";

        $res = $GLOBALS['db']->getAll($ac1);


    } elseif ($is_active == 2) {
        $ac1 = "select *  from wx_sncode_real  where ( '" . $t1 . "'>add_time and '" . $t1 .
            "'<limit_time ) and is_use=1 and openid='" . $openid .
            "' order by add_time desc";

        $res = $GLOBALS['db']->getAll($ac1);

    } elseif ($is_active == 3) {


        $ac1 = "select *  from wx_sncode_real  where  '" . $t1 .
            "'>=limit_time and openid='" . $openid . "' order by add_time desc";

        $res = $GLOBALS['db']->getAll($ac1);


    }

    //是否可以兑换成奖励

    $get_ex_real = get_ex_real("1");
    //print_r($get_ex_point);
    if ($get_ex_real['ex_real'] == 1) {
        $smarty->assign('ex_real', 1);
        $smarty->assign('get_ex_real', $get_ex_real['list']);
    } else {
        $smarty->assign('ex_real', 0);
    }

    //print_r($res);
    $smarty->assign('is_active', $is_active);

    $smarty->assign('sncode2', $res);
    $smarty->assign('fall', 'ewm2');
    $smarty->assign('op', $openid);
    $smarty->display('mcenter_3.tpl');
}


if ($_REQUEST['act'] == 'fxfc') {

    function downloadImageFromWeiXin($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, 0); //只取body头
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $package = curl_exec($ch);
        $httpinfo = curl_getinfo($ch);
        curl_close($ch);
        return array_merge(array('body' => $package), array('header' => $httpinfo));
    }

    function fenc_mx($p_id, $tp, $fenc)
    {
        $zfc = 0;
        $zbl = 0;
        $zje = 0;
        $wqje = 0;
        $zcje = 0;

        $sql_g = "select a.product_price,a.order_total_price,a.order_status,case when a.order_status=2 then '待发货' when a.order_status=3 then '已发货' when a.order_status=5 then '已完成' when a.order_status=8 then '维权' end  as status_name,a.order_express_price,a.buyer_nick,a.buyer_openid,b.cj_sn,b.cj_type, from_unixtime(a.order_create_time) as order_create_time,a.order_sn  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid where cj_type='" .
            $tp . "' and cj_sn='" . $p_id .
            "' group by b.openid,a.order_sn order by b.add_time desc   ";
        $res = $GLOBALS['db']->getAll($sql_g);


        //设置分成
        for ($j = 0; $j < count($res); $j++) {
            $res[$j]['fc'] = ($res[$j]['order_total_price'] - $res[$j]['order_express_price']) *
                $fenc / 100;
            $zfc += $res[$j]['fc'];
            $zbl += $res[$j]['point'];
            if ($res[$j]['order_status'] == 8) {
                $wqje += $res[$j]['order_total_price'];
            } else {
                $zcje += $res[$j]['order_total_price'];
            }

        }

        $arr = array();
        //显示明细数据
        //$arr['list']=$res;

        $arr['zfc'] = $zfc;
        $arr['zbl'] = $zbl;
        //$arr['zbl'] = $fenc;
        //正常金额
        $arr['zcje'] = $zcje;
        //维权金额
        $arr['wqje'] = $wqje;
        $arr['sjje'] = $fenc * $zcje / 100;
        $arr['zje'] = $wqje + $zcje;
        $zfc = 0;
        $zbl = 0;
        $zje = 0;
        $wqje = 0;
        $zcje = 0;

        return $arr;
    }

    // if($_REQUEST['openid']=='omQkMuMr0qxUYo86PbSVl3b0c7b8')
    //    {
    //            $_REQUEST['openid']='omQkMuIQND-MFcaSIUAxAYcdBh0Y';
    //    }
    if (isset($_REQUEST['openid'])) {
        $openid = $_REQUEST['openid'];

        $get_point = "select * from tgpoint where openid ='" . $openid . "'";
        $get_point = $GLOBALS['db']->getAll($get_point);

        $zfc = 0;
        $zbl = 0;
        $zje = 0;
        $wqje = 0;
        $zcje = 0;

        $li = array();

        function shop_to_sales2($p_id)
        {
            $t1 = date('Y-m-d H:i:s', time());

            $sql = "select a.shop_sn,a.shop_name,a.dgpoint,b.sales_sn,b.sales_name from shop a inner join sales b on a.shop_sn=b.p_id where a.shop_sn='" .
                $p_id . "' order by a.id desc";
            $res = $GLOBALS['db']->getAll($sql);

            $list = array();

            for ($i = 0; $i < count($res); $i++) {

                //   $get_tpoint = "select  point from tgpoint_sales where p_id='" . $p_id .
                //                            "' and sales_sn='" . $res[$i]['sales_sn'] . "'";
                //                        //print_r($get_tpoint);
                //                        $get_tpoint = $GLOBALS['db']->getRow($get_tpoint);
                //                        if (!empty($get_tpoint) && $get_tpoint['point'] != 0) {
                //                            $res[$i]['dgpoint'] = $get_tpoint['point'];
                //                        }

                $res[$i]['sd_dgfc'] = fenc_mx($res[$i]['sales_sn'], "sales", $res[$i]['dgpoint']);

            }
            //print_r($res);
            return $res;

        }

        function tg_shop($p_id)
        {
            $t1 = date('Y-m-d H:i:s', time());

            $sql = "select a.qudao_sn,a.qudao_name,b.shop_sn,b.shop_name,a.sdpoint,a.dgpoint from qudao a inner join shop b on a.qudao_sn=b.p_id where a.qudao_sn ='" .
                $p_id . "' order by a.id desc";
            $res = $GLOBALS['db']->getAll($sql);

            $list = array();
            for ($i = 0; $i < count($res); $i++) {

                $get_tpoint = "select  point from tgpoint_shop where p_id='" . $p_id .
                    "' and shop_sn='" . $res[$i]['shop_sn'] . "'";
                //print_r($get_tpoint);
                $get_tpoint = $GLOBALS['db']->getRow($get_tpoint);
                if (!empty($get_tpoint) && $get_tpoint['point'] != 0) {
                    $res[$i]['sdpoint'] = $get_tpoint['point'];
                }

                $res[$i]['sdfc'] = fenc_mx($res[$i]['shop_sn'], "shop", $res[$i]['sdpoint']);


            }
            return $res;

        }
        function tg_sales($p_id)
        {
            $t1 = date('Y-m-d H:i:s', time());

            $sql = "select a.qudao_sn,a.qudao_name,b.shop_sn,b.shop_name,a.sdpoint,a.dgpoint,c.sales_sn,c.sales_name from qudao a inner join shop b on a.qudao_sn=b.p_id inner join sales c on b.shop_sn=c.p_id where a.qudao_sn ='" .
                $p_id . "' order by a.id desc";
            $res = $GLOBALS['db']->getAll($sql);

            $list = array();
            for ($i = 0; $i < count($res); $i++) {

                $get_tpoint = "select  point from tgpoint_sales where p_id='" . $p_id .
                    "' and sales_sn='" . $res[$i]['sales_sn'] . "'";
                //print_r($get_tpoint);
                $get_tpoint = $GLOBALS['db']->getRow($get_tpoint);
                if (!empty($get_tpoint) && $get_tpoint['point'] != 0) {
                    $res[$i]['dgpoint'] = $get_tpoint['point'];
                }

                $res[$i]['dgfc'] = fenc_mx($res[$i]['sales_sn'], "sales", $res[$i]['dgpoint']);

            }
            return $res;

        }


        for ($i = 0; $i < count($get_point); $i++) {
            if ($get_point[$i]['p_type'] == "1") {
                $sql = "select qudao_sn,qudao_name,ticket from qudao where qudao_sn='" . $get_point[$i]['p_id'] .
                    "'";
                $res = $GLOBALS['db']->getRow($sql);
                $get_point[$i]['qudao_sn'] = $res['qudao_sn'];
                $get_point[$i]['qudao_name'] = $res['qudao_name'];

                $sql_g = "select a.product_price,a.order_total_price,a.order_status,case when a.order_status=2 then '待发货' when a.order_status=3 then '已发货' when a.order_status=5 then '已完成' when a.order_status=8 then '维权' end  as status_name,a.order_express_price,a.buyer_nick,a.buyer_openid,b.cj_sn,b.cj_type, from_unixtime(a.order_create_time) as order_create_time,a.order_sn  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid where cj_type='qudao' and cj_sn='" .
                    $res['qudao_sn'] . "' group by b.openid,a.order_sn order by b.add_time desc   ";
                $get_point[$i]['fc_list'] = $GLOBALS['db']->getAll($sql_g);


                //设置分成
                for ($j = 0; $j < count($get_point[$i]['fc_list']); $j++) {
                    $get_point[$i]['fc'] = ($get_point[$i]['fc_list'][$j]['order_total_price'] - $get_point[$i]['fc_list'][$j]['order_express_price']) *
                        $get_point[$i]['point'] / 100;
                    $zfc += $get_point[$i]['fc'];
                    $zbl += $get_point[$i]['point'];
                    if ($get_point[$i]['fc_list'][$j]['order_status'] == 8) {
                        $wqje += $get_point[$i]['fc_list'][$j]['order_total_price'];
                    } else {
                        $zcje += $get_point[$i]['fc_list'][$j]['order_total_price'];
                    }

                }
                $get_point[$i]['zfc'] = $zfc;
                $get_point[$i]['zbl'] = $zbl;
                //正常金额
                $get_point[$i]['zcje'] = $zcje;
                //维权金额
                $get_point[$i]['wqje'] = $wqje;
                $get_point[$i]['sjje'] = $get_point[$i]['point'] * $zcje / 100;
                $get_point[$i]['zje'] = $wqje + $zcje;
                $zfc = 0;
                $zbl = 0;
                $zje = 0;
                $wqje = 0;
                $zcje = 0;


                //开始计算渠道下属店铺的分成比例


                $get_point[$i]['shop_fenc'] = tg_shop($res['qudao_sn']);
                //--end结束下属商店结算

                //开始计算渠道下属店铺的分成比例


                $get_point[$i]['sales_fenc'] = tg_sales($res['qudao_sn']);
                //--end结束下属商店结算


                //获取二维码地址
                $ticket = $res['ticket'];
                if (!empty($ticket)) {

                    $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode($ticket);
                    $imageInfo = downloadImageFromWeiXin($url);
                    $qrcodename = md5($ticket);
                    $filename = 'upload/cj_qrcode/qudao/' . $qrcodename . ".jpg";
                    $local_file = fopen($filename, 'w');
                    if (false !== $local_file) {
                        if (false !== fwrite($local_file, $imageInfo["body"])) {
                            fclose($local_file);
                        }
                    }
                }
                $get_point[$i]['tgerm'] = $filename;


                $li['qudao'] = 1;
            } elseif ($get_point[$i]['p_type'] == "2") {
                $sql = "select shop_sn,shop_name,ticket from shop where shop_sn='" . $get_point[$i]['p_id'] .
                    "'";
                $res = $GLOBALS['db']->getRow($sql);
                //print_r($sql);exit;
                $get_point[$i]['qudao_sn'] = $res['shop_sn'];
                $get_point[$i]['qudao_name'] = $res['shop_name'];
                $sql_g = "select a.product_price,a.order_total_price,a.order_status,case when a.order_status=2 then '待发货' when a.order_status=3 then '已发货' when a.order_status=5 then '已完成' when a.order_status=8 then '维权' end  as status_name,a.order_express_price,a.buyer_nick,a.buyer_openid,b.cj_sn,b.cj_type, from_unixtime(a.order_create_time) as order_create_time,a.order_sn  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid where cj_type='shop' and cj_sn='" .
                    $res['shop_sn'] . "' group by b.openid,a.order_sn order by b.add_time desc   ";
                $get_point[$i]['fc_list'] = $GLOBALS['db']->getAll($sql_g);


                //设置分成
                for ($j = 0; $j < count($get_point[$i]['fc_list']); $j++) {
                    $get_point[$i]['fc'] = ($get_point[$i]['fc_list'][$j]['order_total_price'] - $get_point[$i]['fc_list'][$j]['order_express_price']) *
                        $get_point[$i]['point'] / 100;
                    $zfc += $get_point[$i]['fc'];
                    $zbl += $get_point[$i]['point'];
                    if ($get_point[$i]['fc_list'][$j]['order_status'] == 8) {
                        $wqje += $get_point[$i]['fc_list'][$j]['order_total_price'];
                    } else {
                        $zcje += $get_point[$i]['fc_list'][$j]['order_total_price'];
                    }

                }
                $get_point[$i]['zfc'] = $zfc;
                $get_point[$i]['zbl'] = $zbl;
                //正常金额
                $get_point[$i]['zcje'] = $zcje;
                //维权金额
                $get_point[$i]['wqje'] = $wqje;
                $get_point[$i]['sjje'] = $get_point[$i]['point'] * $zcje / 100;
                $get_point[$i]['zje'] = $wqje + $zcje;
                $zfc = 0;
                $zbl = 0;
                $zje = 0;
                $wqje = 0;
                $zcje = 0;

                //获取二维码地址
                $ticket = $res['ticket'];
                if (!empty($ticket)) {

                    $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode($ticket);
                    $imageInfo = downloadImageFromWeiXin($url);
                    $qrcodename = md5($ticket);
                    $filename = 'upload/cj_qrcode/shop/' . $qrcodename . ".jpg";
                    $local_file = fopen($filename, 'w');
                    if (false !== $local_file) {
                        if (false !== fwrite($local_file, $imageInfo["body"])) {
                            fclose($local_file);
                        }
                    }
                }
                $get_point[$i]['tgerm'] = $filename;


                //开始计算店铺下属导购的分成比例


                $get_point[$i]['shop_sales_fenc'] = shop_to_sales2($res['shop_sn']);
                //--end结束下属商店结算
                // print_r($get_point);


                $li['shop'] = 2;
            } elseif ($get_point[$i]['p_type'] == "3") {
                $sql = "select sales_sn,sales_name,ticket from sales where sales_sn='" . $get_point[$i]['p_id'] .
                    "'";
                $res = $GLOBALS['db']->getRow($sql);
                $get_point[$i]['qudao_sn'] = $res['sales_sn'];
                $get_point[$i]['qudao_name'] = $res['sales_name'];
                $sql_g = "select a.product_price,a.order_total_price,a.order_status,case when a.order_status=2 then '待发货' when a.order_status=3 then '已发货' when a.order_status=5 then '已完成' when a.order_status=8 then '维权' end  as status_name,a.order_express_price,a.buyer_nick,a.buyer_openid,b.cj_sn,b.cj_type, from_unixtime(a.order_create_time) as order_create_time,a.order_sn  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid where cj_type='sales' and cj_sn='" .
                    $res['sales_sn'] . "' group by b.openid,a.order_sn order by b.add_time desc   ";
                $get_point[$i]['fc_list'] = $GLOBALS['db']->getAll($sql_g);


                //设置分成
                for ($j = 0; $j < count($get_point[$i]['fc_list']); $j++) {
                    $get_point[$i]['fc'] = ($get_point[$i]['fc_list'][$j]['order_total_price'] - $get_point[$i]['fc_list'][$j]['order_express_price']) *
                        $get_point[$i]['point'] / 100;
                    $zfc += $get_point[$i]['fc'];
                    $zbl += $get_point[$i]['point'];
                    if ($get_point[$i]['fc_list'][$j]['order_status'] == 8) {
                        $wqje += $get_point[$i]['fc_list'][$j]['order_total_price'];
                    } else {
                        $zcje += $get_point[$i]['fc_list'][$j]['order_total_price'];
                    }

                }
                $get_point[$i]['zfc'] = $zfc;
                $get_point[$i]['zbl'] = $zbl;
                //正常金额
                $get_point[$i]['zcje'] = $zcje;
                //维权金额
                $get_point[$i]['wqje'] = $wqje;

                $get_point[$i]['sjje'] = $get_point[$i]['point'] * $zcje / 100;

                $get_point[$i]['zje'] = $wqje + $zcje;
                $zfc = 0;
                $zbl = 0;
                $zje = 0;
                $wqje = 0;
                $zcje = 0;
                //获取二维码地址
                $ticket = $res['ticket'];
                if (!empty($ticket)) {

                    $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode($ticket);
                    $imageInfo = downloadImageFromWeiXin($url);
                    $qrcodename = md5($ticket);
                    $filename = 'upload/cj_qrcode/sales/' . $qrcodename . ".jpg";
                    $local_file = fopen($filename, 'w');
                    if (false !== $local_file) {
                        if (false !== fwrite($local_file, $imageInfo["body"])) {
                            fclose($local_file);
                        }
                    }
                }
                $get_point[$i]['tgerm'] = $filename;


                $li['sales'] = 2;
            }


        }

        //   print_r($get_point);

        $smarty->assign('ptype', 1);

        $smarty->assign('fc', $get_point);
        $smarty->assign('fall', 'fxfc');
        $smarty->assign('op', $openid);
        $smarty->display('mcenter_3.tpl');
    }

}

if ($_REQUEST['act'] == 'fxfc2') {

    function downloadImageFromWeiXin($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, 0); //只取body头
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $package = curl_exec($ch);
        $httpinfo = curl_getinfo($ch);
        curl_close($ch);
        return array_merge(array('body' => $package), array('header' => $httpinfo));
    }

    function fenc_mx($p_id, $tp, $fenc)
    {
        $zfc = 0;
        $zbl = 0;
        $zje = 0;
        $wqje = 0;
        $zcje = 0;

        $sql_g = "select a.product_price,a.order_total_price,a.order_status,case when a.order_status=2 then '待发货' when a.order_status=3 then '已发货' when a.order_status=5 then '已完成' when a.order_status=8 then '维权' end  as status_name,a.order_express_price,a.buyer_nick,a.buyer_openid,b.cj_sn,b.cj_type, from_unixtime(a.order_create_time) as order_create_time,a.order_sn,a.product_name,a.product_count,a.order_total_price  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid where cj_type='" .
            $tp . "' and cj_sn='" . $p_id .
            "' group by b.openid,a.order_sn order by from_unixtime(a.order_create_time) desc   ";
        $res = $GLOBALS['db']->getAll($sql_g);


        //设置分成
        for ($j = 0; $j < count($res); $j++) {
            $res[$j]['fc'] = ($res[$j]['order_total_price'] - $res[$j]['order_express_price']) *
                $fenc / 100;
            $zfc += $res[$j]['fc'];
            $zbl += $res[$j]['point'];
            if ($res[$j]['order_status'] == 8) {
                $wqje += $res[$j]['order_total_price'];
            } else {
                $zcje += $res[$j]['order_total_price'];
            }

        }

        $arr = array();
        //显示明细数据
        //$arr['list']=$res;

        $arr['zfc'] = $zfc;
        $arr['zbl'] = $zbl;
        //$arr['zbl'] = $fenc;
        //正常金额
        $arr['zcje'] = $zcje;
        //维权金额
        $arr['wqje'] = $wqje;
        $arr['sjje'] = $fenc * $zcje / 100;
        $arr['zje'] = $wqje + $zcje;
        $zfc = 0;
        $zbl = 0;
        $zje = 0;
        $wqje = 0;
        $zcje = 0;

        return $arr;
    }


    if (isset($_REQUEST['openid'])) {
        $openid = $_REQUEST['openid'];

        $get_point = "select * from tgpoint where openid ='" . $openid . "'";
        $get_point = $GLOBALS['db']->getAll($get_point);

        $zfc = 0;
        $zbl = 0;
        $zje = 0;
        $wqje = 0;
        $zcje = 0;

        $li = array();

        for ($i = 0; $i < count($get_point); $i++) {
            if ($get_point[$i]['p_type'] == "1") {
                $sql = "select qudao_sn,qudao_name,ticket from qudao where qudao_sn='" . $get_point[$i]['p_id'] .
                    "'";
                $res = $GLOBALS['db']->getRow($sql);
                $get_point[$i]['qudao_sn'] = $res['qudao_sn'];
                $get_point[$i]['qudao_name'] = $res['qudao_name'];

                $sql_g = "select a.product_price,a.order_total_price,a.order_status,case when a.order_status=2 then '待发货' when a.order_status=3 then '已发货' when a.order_status=5 then '已完成' when a.order_status=8 then '维权' end  as status_name,a.order_express_price,a.buyer_nick,a.buyer_openid,b.cj_sn,b.cj_type, from_unixtime(a.order_create_time) as order_create_time,a.order_sn,a.product_name,a.product_count,a.order_total_price  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid where cj_type='qudao' and cj_sn='" .
                    $res['qudao_sn'] . "' group by b.openid,a.order_sn order by from_unixtime(a.order_create_time) desc   ";
                $get_point[$i]['fc_list'] = $GLOBALS['db']->getAll($sql_g);


                //设置分成
                for ($j = 0; $j < count($get_point[$i]['fc_list']); $j++) {
                    $get_point[$i]['fc'] = ($get_point[$i]['fc_list'][$j]['order_total_price'] - $get_point[$i]['fc_list'][$j]['order_express_price']) *
                        $get_point[$i]['point'] / 100;
                    $zfc += $get_point[$i]['fc'];
                    $zbl += $get_point[$i]['point'];
                    if ($get_point[$i]['fc_list'][$j]['order_status'] == 8) {
                        $wqje += $get_point[$i]['fc_list'][$j]['order_total_price'];
                    } else {
                        $zcje += $get_point[$i]['fc_list'][$j]['order_total_price'];
                    }

                }
                $get_point[$i]['zfc'] = $zfc;
                $get_point[$i]['zbl'] = $zbl;
                //正常金额
                $get_point[$i]['zcje'] = $zcje;
                //维权金额
                $get_point[$i]['wqje'] = $wqje;
                $get_point[$i]['sjje'] = $get_point[$i]['point'] * $zcje / 100;
                $get_point[$i]['zje'] = $wqje + $zcje;
                $zfc = 0;
                $zbl = 0;
                $zje = 0;
                $wqje = 0;
                $zcje = 0;


                //开始计算渠道下属店铺的分成比例


                function tg_shop($p_id)
                {
                    $t1 = date('Y-m-d H:i:s', time());

                    $sql = "select a.qudao_sn,a.qudao_name,b.shop_sn,b.shop_name,a.sdpoint,a.dgpoint from qudao a inner join shop b on a.qudao_sn=b.p_id where a.qudao_sn ='" .
                        $p_id . "' order by a.id desc";
                    $res = $GLOBALS['db']->getAll($sql);

                    $list = array();
                    for ($i = 0; $i < count($res); $i++) {

                        $get_tpoint = "select  point from tgpoint_shop where p_id='" . $p_id .
                            "' and shop_sn='" . $res[$i]['shop_sn'] . "'";
                        //print_r($get_tpoint);
                        $get_tpoint = $GLOBALS['db']->getRow($get_tpoint);
                        if (!empty($get_tpoint) && $get_tpoint['point'] != 0) {
                            $res[$i]['sdpoint'] = $get_tpoint['point'];
                        }

                        $res[$i]['sdfc'] = fenc_mx($res[$i]['shop_sn'], "shop", $res[$i]['sdpoint']);


                    }
                    return $res;

                }


                $get_point[$i]['shop_fenc'] = tg_shop($res['qudao_sn']);
                //--end结束下属商店结算

                //开始计算渠道下属店铺的分成比例


                function tg_sales($p_id)
                {
                    $t1 = date('Y-m-d H:i:s', time());

                    $sql = "select a.qudao_sn,a.qudao_name,b.shop_sn,b.shop_name,a.sdpoint,a.dgpoint,c.sales_sn,c.sales_name from qudao a inner join shop b on a.qudao_sn=b.p_id inner join sales c on b.shop_sn=c.p_id where a.qudao_sn ='" .
                        $p_id . "' order by a.id desc";
                    $res = $GLOBALS['db']->getAll($sql);

                    $list = array();
                    for ($i = 0; $i < count($res); $i++) {

                        $get_tpoint = "select  point from tgpoint_sales where p_id='" . $p_id .
                            "' and sales_sn='" . $res[$i]['sales_sn'] . "'";
                        //print_r($get_tpoint);
                        $get_tpoint = $GLOBALS['db']->getRow($get_tpoint);
                        if (!empty($get_tpoint) && $get_tpoint['point'] != 0) {
                            $res[$i]['dgpoint'] = $get_tpoint['point'];
                        }

                        $res[$i]['dgfc'] = fenc_mx($res[$i]['sales_sn'], "sales", $res[$i]['dgpoint']);

                    }
                    return $res;

                }


                $get_point[$i]['sales_fenc'] = tg_sales($res['qudao_sn']);
                //--end结束下属商店结算


                //获取二维码地址
                $ticket = $res['ticket'];
                if (!empty($ticket)) {

                    $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode($ticket);
                    $imageInfo = downloadImageFromWeiXin($url);
                    $qrcodename = md5($ticket);
                    $filename = 'upload/cj_qrcode/qudao/' . $qrcodename . ".jpg";
                    $local_file = fopen($filename, 'w');
                    if (false !== $local_file) {
                        if (false !== fwrite($local_file, $imageInfo["body"])) {
                            fclose($local_file);
                        }
                    }
                }
                $get_point[$i]['tgerm'] = $filename;


                $li['qudao'] = 1;
            } elseif ($get_point[$i]['p_type'] == "2") {
                $sql = "select shop_sn,shop_name,ticket from shop where shop_sn='" . $get_point[$i]['p_id'] .
                    "'";
                $res = $GLOBALS['db']->getRow($sql);
                //print_r($sql);exit;
                $get_point[$i]['qudao_sn'] = $res['shop_sn'];
                $get_point[$i]['qudao_name'] = $res['shop_name'];
                $sql_g = "select a.product_price,a.order_total_price,a.order_status,case when a.order_status=2 then '待发货' when a.order_status=3 then '已发货' when a.order_status=5 then '已完成' when a.order_status=8 then '维权' end  as status_name,a.order_express_price,a.buyer_nick,a.buyer_openid,b.cj_sn,b.cj_type, from_unixtime(a.order_create_time) as order_create_time,a.order_sn,a.product_name,a.product_count,a.order_total_price  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid where cj_type='shop' and cj_sn='" .
                    $res['shop_sn'] . "' group by b.openid,a.order_sn order by from_unixtime(a.order_create_time) desc   ";
                $get_point[$i]['fc_list'] = $GLOBALS['db']->getAll($sql_g);


                //设置分成
                for ($j = 0; $j < count($get_point[$i]['fc_list']); $j++) {
                    $get_point[$i]['fc'] = ($get_point[$i]['fc_list'][$j]['order_total_price'] - $get_point[$i]['fc_list'][$j]['order_express_price']) *
                        $get_point[$i]['point'] / 100;
                    $zfc += $get_point[$i]['fc'];
                    $zbl += $get_point[$i]['point'];
                    if ($get_point[$i]['fc_list'][$j]['order_status'] == 8) {
                        $wqje += $get_point[$i]['fc_list'][$j]['order_total_price'];
                    } else {
                        $zcje += $get_point[$i]['fc_list'][$j]['order_total_price'];
                    }

                }
                $get_point[$i]['zfc'] = $zfc;
                $get_point[$i]['zbl'] = $zbl;
                //正常金额
                $get_point[$i]['zcje'] = $zcje;
                //维权金额
                $get_point[$i]['wqje'] = $wqje;
                $get_point[$i]['sjje'] = $get_point[$i]['point'] * $zcje / 100;
                $get_point[$i]['zje'] = $wqje + $zcje;
                $zfc = 0;
                $zbl = 0;
                $zje = 0;
                $wqje = 0;
                $zcje = 0;

                //获取二维码地址
                $ticket = $res['ticket'];
                if (!empty($ticket)) {

                    $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode($ticket);
                    $imageInfo = downloadImageFromWeiXin($url);
                    $qrcodename = md5($ticket);
                    $filename = 'upload/cj_qrcode/shop/' . $qrcodename . ".jpg";
                    $local_file = fopen($filename, 'w');
                    if (false !== $local_file) {
                        if (false !== fwrite($local_file, $imageInfo["body"])) {
                            fclose($local_file);
                        }
                    }
                }
                $get_point[$i]['tgerm'] = $filename;


                //开始计算店铺下属导购的分成比例


                function shop_to_sales3($p_id)
                {
                    $t1 = date('Y-m-d H:i:s', time());

                    $sql = "select a.shop_sn,a.shop_name,a.dgpoint,b.sales_sn,b.sales_name from shop a inner join sales b on a.shop_sn=b.p_id where a.shop_sn='" .
                        $p_id . "' order by a.id desc";
                    $res = $GLOBALS['db']->getAll($sql);

                    $list = array();

                    for ($i = 0; $i < count($res); $i++) {

                        //   $get_tpoint = "select  point from tgpoint_sales where p_id='" . $p_id .
                        //                            "' and sales_sn='" . $res[$i]['sales_sn'] . "'";
                        //                        //print_r($get_tpoint);
                        //                        $get_tpoint = $GLOBALS['db']->getRow($get_tpoint);
                        //                        if (!empty($get_tpoint) && $get_tpoint['point'] != 0) {
                        //                            $res[$i]['dgpoint'] = $get_tpoint['point'];
                        //                        }

                        $res[$i]['sd_dgfc'] = fenc_mx($res[$i]['sales_sn'], "sales", $res[$i]['dgpoint']);

                    }
                    //print_r($res);
                    return $res;

                }


                $get_point[$i]['shop_sales_fenc'] = shop_to_sales3($res['shop_sn']);
                //--end结束下属商店结算
                // print_r($get_point);


                $li['shop'] = 2;
            } elseif ($get_point[$i]['p_type'] == "3") {
                $sql = "select sales_sn,sales_name,ticket from sales where sales_sn='" . $get_point[$i]['p_id'] .
                    "'";
                $res = $GLOBALS['db']->getRow($sql);
                $get_point[$i]['qudao_sn'] = $res['sales_sn'];
                $get_point[$i]['qudao_name'] = $res['sales_name'];
                $sql_g = "select a.product_price,a.order_total_price,a.order_status,case when a.order_status=2 then '待发货' when a.order_status=3 then '已发货' when a.order_status=5 then '已完成' when a.order_status=8 then '维权' end  as status_name,a.order_express_price,a.buyer_nick,a.buyer_openid,b.cj_sn,b.cj_type, from_unixtime(a.order_create_time) as order_create_time,a.order_sn,a.product_name,a.product_count,a.order_total_price  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid where cj_type='sales' and cj_sn='" .
                    $res['sales_sn'] . "' group by b.openid,a.order_sn order by from_unixtime(a.order_create_time) desc   ";
                $get_point[$i]['fc_list'] = $GLOBALS['db']->getAll($sql_g);


                //设置分成
                for ($j = 0; $j < count($get_point[$i]['fc_list']); $j++) {
                    $get_point[$i]['fc'] = ($get_point[$i]['fc_list'][$j]['order_total_price'] - $get_point[$i]['fc_list'][$j]['order_express_price']) *
                        $get_point[$i]['point'] / 100;
                    $zfc += $get_point[$i]['fc'];
                    $zbl += $get_point[$i]['point'];
                    if ($get_point[$i]['fc_list'][$j]['order_status'] == 8) {
                        $wqje += $get_point[$i]['fc_list'][$j]['order_total_price'];
                    } else {
                        $zcje += $get_point[$i]['fc_list'][$j]['order_total_price'];
                    }

                }
                $get_point[$i]['zfc'] = $zfc;
                $get_point[$i]['zbl'] = $zbl;
                //正常金额
                $get_point[$i]['zcje'] = $zcje;
                //维权金额
                $get_point[$i]['wqje'] = $wqje;

                $get_point[$i]['sjje'] = $get_point[$i]['point'] * $zcje / 100;

                $get_point[$i]['zje'] = $wqje + $zcje;
                $zfc = 0;
                $zbl = 0;
                $zje = 0;
                $wqje = 0;
                $zcje = 0;
                //获取二维码地址
                $ticket = $res['ticket'];
                if (!empty($ticket)) {

                    $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode($ticket);
                    $imageInfo = downloadImageFromWeiXin($url);
                    $qrcodename = md5($ticket);
                    $filename = 'upload/cj_qrcode/sales/' . $qrcodename . ".jpg";
                    $local_file = fopen($filename, 'w');
                    if (false !== $local_file) {
                        if (false !== fwrite($local_file, $imageInfo["body"])) {
                            fclose($local_file);
                        }
                    }
                }
                $get_point[$i]['tgerm'] = $filename;


                $li['sales'] = 2;
            }


        }

        //print_r($get_point);

        $smarty->assign('ptype', 1);

        $smarty->assign('fc', $get_point);
        $smarty->assign('fall', 'fxfc2');
        $smarty->assign('op', $openid);
        $smarty->display('mcenter_3.tpl');
    }

}


if ($_REQUEST['act'] == 'fxfc3') {

    function downloadImageFromWeiXin($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, 0); //只取body头
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $package = curl_exec($ch);
        $httpinfo = curl_getinfo($ch);
        curl_close($ch);
        return array_merge(array('body' => $package), array('header' => $httpinfo));
    }

    function fenc_mx($p_id, $tp, $fenc)
    {
        $zfc = 0;
        $zbl = 0;
        $zje = 0;
        $wqje = 0;
        $zcje = 0;

        $sql_g = "select a.product_price,a.order_total_price,a.order_status,case when a.order_status=2 then '待发货' when a.order_status=3 then '已发货' when a.order_status=5 then '已完成' when a.order_status=8 then '维权' end  as status_name,a.order_express_price,a.buyer_nick,a.buyer_openid,b.cj_sn,b.cj_type, from_unixtime(a.order_create_time) as order_create_time,a.order_sn,a.product_name,a.product_count,a.order_total_price  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid where cj_type='" .
            $tp . "' and cj_sn='" . $p_id .
            "' group by b.openid,a.order_sn order by from_unixtime(a.order_create_time) desc   ";
        $res = $GLOBALS['db']->getAll($sql_g);


        //设置分成
        for ($j = 0; $j < count($res); $j++) {
            $res[$j]['fc'] = ($res[$j]['order_total_price'] - $res[$j]['order_express_price']) *
                $fenc / 100;
            $zfc += $res[$j]['fc'];
            $zbl += $res[$j]['point'];
            if ($res[$j]['order_status'] == 8) {
                $wqje += $res[$j]['order_total_price'];
            } else {
                $zcje += $res[$j]['order_total_price'];
            }

        }

        $arr = array();
        //显示明细数据
        //$arr['list']=$res;

        $arr['zfc'] = $zfc;
        $arr['zbl'] = $zbl;
        //$arr['zbl'] = $fenc;
        //正常金额
        $arr['zcje'] = $zcje;
        //维权金额
        $arr['wqje'] = $wqje;
        $arr['sjje'] = $fenc * $zcje / 100;
        $arr['zje'] = $wqje + $zcje;
        $zfc = 0;
        $zbl = 0;
        $zje = 0;
        $wqje = 0;
        $zcje = 0;

        return $arr;
    }

    $secan = 1;//如果是1的时候是大华版本
    if ($secan == 1) {

        function fenc_2($p_id, $tp, $fenc)
        {

            $arr = array();

            $sql_g = "select  a.ori_price_total,a.ori_price,a.or_status,a.product_price,a.order_total_price,a.order_status,case when a.order_status=2 then '待发货' when a.order_status=3 then '已发货' when a.order_status=5 then '已完成' when a.order_status=8 then '维权' end  as status_name,a.order_express_price,a.buyer_nick,a.buyer_openid,b.cj_sn,b.cj_type, from_unixtime(a.order_create_time) as order_create_time,a.order_sn,a.product_name,a.product_count,a.order_total_price  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid where cj_type='" .
                $tp . "' and cj_sn='" . $p_id .
                "' group by b.openid,a.order_sn order by from_unixtime(a.order_create_time) desc   ";
            $res = $GLOBALS['db']->getAll($sql_g);
            //print_r($res);exit;

            //设置分成
            for ($j = 0; $j < count($res); $j++) {

                //  $res[$j]['fc'] =round(( round($res[$j]['product_price']/$res[$j]['order_total_price'],2) - $fenc/100 ) /round($res[$j]['product_price']/$res[$j]['order_total_price'],2) ,2)  * $res[$j]['product_price'];
                //
                //                   $res[$j]['djfc'] =round(( round($res[$j]['product_price']/$res[$j]['order_total_price'],2) - $fenc/100 ) /round($res[$j]['product_price']/$res[$j]['order_total_price'],2) ,2)  * $res[$j]['product_price'];

                /*
                $res[$j]['fc'] = round((round($res[$j]['order_total_price'] / $res[$j]['ori_price_total'],
                    2) - $fenc / 100) / round($res[$j]['order_total_price'] / $res[$j]['ori_price_total'],
                    2), 2) * $res[$j]['order_total_price'];

                $res[$j]['djfc'] = round((round($res[$j]['order_total_price'] / $res[$j]['ori_price_total'],
                    2) - $fenc / 100) / round($res[$j]['order_total_price'] / $res[$j]['ori_price_total'],
                    2), 2) * $res[$j]['order_total_price'];
                */
                $res[$j]['fc'] = $res[$j]['order_total_price'] - $res[$j]['ori_price_total'] *$fenc / 100;
                $res[$j]['djfc'] = $res[$j]['order_total_price'] - $res[$j]['ori_price_total'] *$fenc / 100;
                //echo $res[$j]['fc']." ".$res[$j]['ori_price_total'] *$fenc / 100;
                if ($res[$j]['or_status'] == '0') {
                    $wqrje += $res[$j]['fc'];
                } elseif ($res[$j]['or_status'] == '1') {
                    $yqrje += $res[$j]['fc'];
                } else {
                    $tkje += $res[$j]['fc'];
                }

            }


            $arr['wqrje'] = $wqrje;
            $arr['yqrje'] = $yqrje;
            $arr['tkje'] = $tkje;

            $wqrje = 0;
            $yqrje = 0;
            $tkje = 0;
            $arr['fxfc'] = $res;

            $zfc = 0;
            $zbl = 0;
            $zje = 0;
            $wqje = 0;
            $zcje = 0;

            return $arr;
        }

        function fenc_3($p_id, $tp, $fenc)
        {

            $arr = array();

            $sql_g = "select  a.ori_price_total,a.ori_price,a.or_status,a.product_price,a.order_total_price,a.order_status,case when a.order_status=2 then '待发货' when a.order_status=3 then '已发货' when a.order_status=5 then '已完成' when a.order_status=8 then '维权' end  as status_name,a.order_express_price,a.buyer_nick,a.buyer_openid,b.cj_sn,b.cj_type, from_unixtime(a.order_create_time) as order_create_time,a.order_sn,a.product_name,a.product_count,a.order_total_price  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid where cj_type='" .
                $tp . "' and cj_sn='" . $p_id .
                "' group by b.openid,a.order_sn order by from_unixtime(a.order_create_time) desc   ";
            //print_r($sql_g);exit;
            $res = $GLOBALS['db']->getAll($sql_g);


            //设置分成
            for ($j = 0; $j < count($res); $j++) {
                /*
                $res[$j]['fc'] = round($fenc / 100 / round($res[$j]['order_total_price'] / $res[$j]['ori_price_total'],
                    2), 2) * $res[$j]['order_total_price'];

                $res[$j]['djfc'] = round($fenc / 100 / round($res[$j]['order_total_price'] / $res[$j]['ori_price_total'],
                    2), 2) * $res[$j]['order_total_price'];*/
                
                $res[$j]['fc'] =$res[$j]['ori_price_total'] *$fenc / 100;
                $res[$j]['djfc'] =  $res[$j]['ori_price_total'] *$fenc / 100;


                if ($res[$j]['or_status'] == '0') {
                    $wqrje += $res[$j]['fc'];
                } elseif ($res[$j]['or_status'] == '1') {
                    $yqrje += $res[$j]['fc'];
                } else {
                    $tkje += $res[$j]['fc'];
                }

            }


            $arr['wqrje'] = $wqrje;
            $arr['yqrje'] = $yqrje;
            $arr['tkje'] = $tkje;

            $wqrje = 0;
            $yqrje = 0;
            $tkje = 0;
            $arr['fxfc'] = $res;

            $zfc = 0;
            $zbl = 0;
            $zje = 0;
            $wqje = 0;
            $zcje = 0;

            return $arr;
        }
    } else {
        function fenc_2($p_id, $tp, $fenc)
        {

            $arr = array();

            $sql_g = "select  a.ori_price_total,a.ori_price,a.or_status,a.product_price,a.order_total_price,a.order_status,case when a.order_status=2 then '待发货' when a.order_status=3 then '已发货' when a.order_status=5 then '已完成' when a.order_status=8 then '维权' end  as status_name,a.order_express_price,a.buyer_nick,a.buyer_openid,b.cj_sn,b.cj_type, from_unixtime(a.order_create_time) as order_create_time,a.order_sn,a.product_name,a.product_count,a.order_total_price  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid where cj_type='" .
                $tp . "' and cj_sn='" . $p_id .
                "' group by b.openid,a.order_sn order by from_unixtime(a.order_create_time) desc   ";
            $res = $GLOBALS['db']->getAll($sql_g);
            //print_r($res);exit;

            //设置分成
            for ($j = 0; $j < count($res); $j++) {

                //  $res[$j]['fc'] =round(( round($res[$j]['product_price']/$res[$j]['order_total_price'],2) - $fenc/100 ) /round($res[$j]['product_price']/$res[$j]['order_total_price'],2) ,2)  * $res[$j]['product_price'];
                //
                //                   $res[$j]['djfc'] =round(( round($res[$j]['product_price']/$res[$j]['order_total_price'],2) - $fenc/100 ) /round($res[$j]['product_price']/$res[$j]['order_total_price'],2) ,2)  * $res[$j]['product_price'];


               // $res[$j]['fc'] = round((round($res[$j]['order_total_price'] / $res[$j]['ori_price_total'],
//                    2) - $fenc / 100) / round($res[$j]['order_total_price'] / $res[$j]['ori_price_total'],
//                    2), 2) * $res[$j]['order_total_price'];
//
//                $res[$j]['djfc'] = round((round($res[$j]['order_total_price'] / $res[$j]['ori_price_total'],
//                    2) - $fenc / 100) / round($res[$j]['order_total_price'] / $res[$j]['ori_price_total'],
//                    2), 2) * $res[$j]['order_total_price'];
                $res[$j]['fc'] = ($res[$j]['order_total_price'] - $res[$j]['order_express_price']) *
                $fenc / 100;
                $res[$j]['djfc'] = ($res[$j]['order_total_price'] - $res[$j]['order_express_price']) *
                $fenc / 100;
                
                
                if ($res[$j]['or_status'] == '0') {
                    $wqrje += $res[$j]['fc'];
                } elseif ($res[$j]['or_status'] == '1') {
                    $yqrje += $res[$j]['fc'];
                } else {
                    $tkje += $res[$j]['fc'];
                }

            }


            $arr['wqrje'] = $wqrje;
            $arr['yqrje'] = $yqrje;
            $arr['tkje'] = $tkje;

            $wqrje = 0;
            $yqrje = 0;
            $tkje = 0;
            $arr['fxfc'] = $res;

            $zfc = 0;
            $zbl = 0;
            $zje = 0;
            $wqje = 0;
            $zcje = 0;

            return $arr;
        }

        function fenc_3($p_id, $tp, $fenc)
        {

            $arr = array();

            $sql_g = "select  a.ori_price_total,a.ori_price,a.or_status,a.product_price,a.order_total_price,a.order_status,case when a.order_status=2 then '待发货' when a.order_status=3 then '已发货' when a.order_status=5 then '已完成' when a.order_status=8 then '维权' end  as status_name,a.order_express_price,a.buyer_nick,a.buyer_openid,b.cj_sn,b.cj_type, from_unixtime(a.order_create_time) as order_create_time,a.order_sn,a.product_name,a.product_count,a.order_total_price  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid where cj_type='" .
                $tp . "' and cj_sn='" . $p_id .
                "' group by b.openid,a.order_sn order by from_unixtime(a.order_create_time) desc   ";
            //print_r($sql_g);exit;
            $res = $GLOBALS['db']->getAll($sql_g);


            //设置分成
            for ($j = 0; $j < count($res); $j++) {

                $res[$j]['fc'] = ($res[$j]['order_total_price'] - $res[$j]['order_express_price']) *
                $fenc / 100;
                $res[$j]['djfc'] = ($res[$j]['order_total_price'] - $res[$j]['order_express_price']) *
                $fenc / 100;


                if ($res[$j]['or_status'] == '0') {
                    $wqrje += $res[$j]['fc'];
                } elseif ($res[$j]['or_status'] == '1') {
                    $yqrje += $res[$j]['fc'];
                } else {
                    $tkje += $res[$j]['fc'];
                }

            }


            $arr['wqrje'] = $wqrje;
            $arr['yqrje'] = $yqrje;
            $arr['tkje'] = $tkje;

            $wqrje = 0;
            $yqrje = 0;
            $tkje = 0;
            $arr['fxfc'] = $res;

            $zfc = 0;
            $zbl = 0;
            $zje = 0;
            $wqje = 0;
            $zcje = 0;

            return $arr;
        }
    }

    function shop_to_sales4($p_id)
    {
        $t1 = date('Y-m-d H:i:s', time());

        $sql = "select a.shop_sn,a.shop_name,a.dgpoint,b.sales_sn,b.sales_name from shop a inner join sales b on a.shop_sn=b.p_id where a.shop_sn='" .
            $p_id . "' order by a.id desc";
        $res = $GLOBALS['db']->getAll($sql);

        $list = array();

        for ($i = 0; $i < count($res); $i++) {

            //   $get_tpoint = "select  point from tgpoint_sales where p_id='" . $p_id .
            //                            "' and sales_sn='" . $res[$i]['sales_sn'] . "'";
            //                        //print_r($get_tpoint);
            //                        $get_tpoint = $GLOBALS['db']->getRow($get_tpoint);
            //                        if (!empty($get_tpoint) && $get_tpoint['point'] != 0) {
            //                            $res[$i]['dgpoint'] = $get_tpoint['point'];
            //                        }

            $res[$i]['sd_dgfc'] = fenc_3($res[$i]['sales_sn'], "sales", $res[$i]['dgpoint']);

        }
        //print_r($res);
        return $res;

    }
    function tg_shop($p_id)
    {
        $t1 = date('Y-m-d H:i:s', time());

        $sql = "select a.qudao_sn,a.qudao_name,b.shop_sn,b.shop_name,a.sdpoint,a.dgpoint from qudao a inner join shop b on a.qudao_sn=b.p_id where a.qudao_sn ='" .
            $p_id . "' order by a.id desc";
        $res = $GLOBALS['db']->getAll($sql);
        //print_r($res);exit;
        $list = array();
        for ($i = 0; $i < count($res); $i++) {

            $get_tpoint = "select  point from tgpoint_shop where p_id='" . $p_id .
                "' and shop_sn='" . $res[$i]['shop_sn'] . "'";

            $get_tpoint = $GLOBALS['db']->getRow($get_tpoint);

            if (!empty($get_tpoint) && $get_tpoint['point'] != 0) {
                $res[$i]['sdpoint'] = $get_tpoint['point'];
            }

            $res[$i]['sdfc'] = fenc_3($res[$i]['shop_sn'], "shop", $res[$i]['sdpoint']);


        }
        return $res;

    }

    function tg_sales($p_id)
    {
        $t1 = date('Y-m-d H:i:s', time());

        $sql = "select a.qudao_sn,a.qudao_name,b.shop_sn,b.shop_name,a.sdpoint,a.dgpoint,c.sales_sn,c.sales_name from qudao a inner join shop b on a.qudao_sn=b.p_id inner join sales c on b.shop_sn=c.p_id where a.qudao_sn ='" .
            $p_id . "' order by a.id desc";
        $res = $GLOBALS['db']->getAll($sql);

        $list = array();
        for ($i = 0; $i < count($res); $i++) {

            $get_tpoint = "select  point from tgpoint_sales where p_id='" . $p_id .
                "' and sales_sn='" . $res[$i]['sales_sn'] . "'";
            //print_r($get_tpoint);
            $get_tpoint = $GLOBALS['db']->getRow($get_tpoint);
            if (!empty($get_tpoint) && $get_tpoint['point'] != 0) {
                $res[$i]['dgpoint'] = $get_tpoint['point'];
            }

            $res[$i]['dgfc'] = fenc_3($res[$i]['sales_sn'], "sales", $res[$i]['dgpoint']);

        }
        return $res;

    }


//    if($_REQUEST['openid']=='omQkMuMr0qxUYo86PbSVl3b0c7b8')
//        {
//                $_REQUEST['openid']='omQkMuG99BXz04f6CL1-Y616tcvQ';
//        }
    if (isset($_REQUEST['openid'])) {
        $openid = $_REQUEST['openid'];

        $get_point = "select * from tgpoint where openid ='" . $openid . "'";
        $get_point = $GLOBALS['db']->getAll($get_point);

        $zfc = 0;
        $zbl = 0;
        $zje = 0;
        $wqje = 0;
        $zcje = 0;

        $li = array();

        for ($i = 0; $i < count($get_point); $i++) {
            if ($get_point[$i]['p_type'] == "1") {
                $sql = "select qudao_sn,qudao_name,ticket from qudao where qudao_sn='" . $get_point[$i]['p_id'] .
                    "'";
                $res = $GLOBALS['db']->getRow($sql);
                $get_point[$i]['qudao_sn'] = $res['qudao_sn'];
                $get_point[$i]['qudao_name'] = $res['qudao_name'];
                /*
                $sql_g = "select a.or_status,a.product_price,a.order_total_price,a.order_status,case when a.order_status=2 then '待发货' when a.order_status=3 then '已发货' when a.order_status=5 then '已完成' when a.order_status=8 then '维权' end  as status_name,a.order_express_price,a.buyer_nick,a.buyer_openid,b.cj_sn,b.cj_type, from_unixtime(a.order_create_time) as order_create_time,a.order_sn,a.product_name,a.product_count,a.order_total_price  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid where cj_type='qudao' and cj_sn='" .
                $res['qudao_sn'] . "' group by b.openid,a.order_sn order by from_unixtime(a.order_create_time) desc   ";
                $get_point[$i]['fc_list'] = $GLOBALS['db']->getAll($sql_g);


                //设置分成
                for ($j = 0; $j < count($get_point[$i]['fc_list']); $j++) {
                $get_point[$i]['fc'] = ($get_point[$i]['fc_list'][$j]['order_total_price'] - $get_point[$i]['fc_list'][$j]['order_express_price']) *
                $get_point[$i]['point'] / 100;
                $zfc += $get_point[$i]['fc'];
                $zbl += $get_point[$i]['point'];
                if ($get_point[$i]['fc_list'][$j]['or_status'] != '1') {
                $wqje += $get_point[$i]['fc_list'][$j]['order_total_price'];
                } else {
                $zcje += $get_point[$i]['fc_list'][$j]['order_total_price'];
                }

                }
                $get_point[$i]['zfc'] = $zfc;
                $get_point[$i]['zbl'] = $zbl;
                //正常金额
                $get_point[$i]['zcje'] = $zcje;
                //维权金额
                $get_point[$i]['wqje'] = $wqje;
                $get_point[$i]['sjje'] = $get_point[$i]['point'] * $zcje / 100;
                $get_point[$i]['zje'] = $wqje + $zcje;
                $zfc = 0;
                $zbl = 0;
                $zje = 0;
                $wqje = 0;
                $zcje = 0;
                */

                //开始计算渠道下属店铺的分成比例
                $get_point[$i]['fc_list'] = fenc_2($res['qudao_sn'], 'qudao', $get_point[$i]['point']);
                //print_r($get_point[$i]['fc_list'] );


                $get_point[$i]['shop_fenc'] = tg_shop($res['qudao_sn']);
                //--end结束下属商店结算

                //开始计算渠道下属店铺的分成比例


                $get_point[$i]['sales_fenc'] = tg_sales($res['qudao_sn']);
                //--end结束下属商店结算

                //print_r($get_point[$i]);
                //获取二维码地址
                $ticket = $res['ticket'];
                if (!empty($ticket)) {

                    $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode($ticket);
                    $imageInfo = downloadImageFromWeiXin($url);
                    $qrcodename = md5($ticket);
                    $filename = 'upload/cj_qrcode/qudao/' . $qrcodename . ".jpg";
                    $local_file = fopen($filename, 'w');
                    if (false !== $local_file) {
                        if (false !== fwrite($local_file, $imageInfo["body"])) {
                            fclose($local_file);
                        }
                    }
                }
                $get_point[$i]['tgerm'] = $filename;


                $li['qudao'] = 1;
            } elseif ($get_point[$i]['p_type'] == "2") {
                $sql = "select shop_sn,shop_name,ticket from shop where shop_sn='" . $get_point[$i]['p_id'] .
                    "'";
                $res = $GLOBALS['db']->getRow($sql);
                //print_r($sql);exit;
                $get_point[$i]['qudao_sn'] = $res['shop_sn'];
                $get_point[$i]['qudao_name'] = $res['shop_name'];
                /*
                $sql_g = "select a.or_status,a.product_price,a.order_total_price,a.order_status,case when a.order_status=2 then '待发货' when a.order_status=3 then '已发货' when a.order_status=5 then '已完成' when a.order_status=8 then '维权' end  as status_name,a.order_express_price,a.buyer_nick,a.buyer_openid,b.cj_sn,b.cj_type, from_unixtime(a.order_create_time) as order_create_time,a.order_sn,a.product_name,a.product_count,a.order_total_price  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid where cj_type='shop' and cj_sn='" .
                $res['shop_sn'] . "' group by b.openid,a.order_sn order by from_unixtime(a.order_create_time) desc   ";
                $get_point[$i]['fc_list'] = $GLOBALS['db']->getAll($sql_g);

                //设置分成
                for ($j = 0; $j < count($get_point[$i]['fc_list']); $j++) {
                
                $get_point[$i]['fc'] =round(( round($get_point[$i]['fc_list'][$j]['product_price']/$get_point[$i]['fc_list'][$j]['order_total_price'],2) - $get_point[$i]['point']/100 ) /round($get_point[$i]['fc_list'][$j]['product_price']/$get_point[$i]['fc_list'][$j]['order_total_price'],2) ,2)  * $get_point[$i]['fc_list'][$j]['product_price'];
                
                $get_point[$i]['fc_list'][$j]['djfc'] =round(( round($get_point[$i]['fc_list'][$j]['product_price']/$get_point[$i]['fc_list'][$j]['order_total_price'],2) - $get_point[$i]['point']/100 ) /round($get_point[$i]['fc_list'][$j]['product_price']/$get_point[$i]['fc_list'][$j]['order_total_price'],2) ,2)  * $get_point[$i]['fc_list'][$j]['product_price'];
                
                //print_r($get_point[$i]['fc']."<br>");
                //round(5.045, 2)
                $zfc += $get_point[$i]['fc'];
                $zbl += $get_point[$i]['point'];
                if ($get_point[$i]['fc_list'][$j]['or_status'] != '1') {
                $wqje += $get_point[$i]['fc'];
                } else {
                $zcje += $get_point[$i]['fc'];
                }
                if ($get_point[$i]['fc_list'][$j]['or_status'] == '0') {
                $wqrje += $get_point[$i]['fc'];
                }elseif ($get_point[$i]['fc_list'][$j]['or_status'] == '1') {
                $yqrje += $get_point[$i]['fc'];
                } 
                else {
                $tkje += $get_point[$i]['fc'];
                }

                }
                //print_r($get_point[$i]['fc_list']);

                $get_point[$i]['zfc'] = $zfc;
                $get_point[$i]['zbl'] = $zbl;
                //正常金额
                $get_point[$i]['zcje'] = $zcje;
                //维权金额
                $get_point[$i]['wqje'] = $wqje;
                $get_point[$i]['sjje'] = $get_point[$i]['point'] * $zcje / 100;
                $get_point[$i]['zje'] = $wqje + $zcje;
                
                $get_point[$i]['wqrje'] = $wqrje;
                $get_point[$i]['yqrje'] = $yqrje;
                $get_point[$i]['tkje'] = $tkje;
                
                $wqrje=0;
                $yqrje=0;
                $tkje=0;
                
                
                $zfc = 0;
                $zbl = 0;
                $zje = 0;
                $wqje = 0;
                $zcje = 0;
                
                */
                $get_point[$i]['fc_list'] = fenc_2($res['shop_sn'], 'shop', $get_point[$i]['point']);

                //获取二维码地址
                $ticket = $res['ticket'];
                if (!empty($ticket)) {

                    $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode($ticket);
                    $imageInfo = downloadImageFromWeiXin($url);
                    $qrcodename = md5($ticket);
                    $filename = 'upload/cj_qrcode/shop/' . $qrcodename . ".jpg";
                    $local_file = fopen($filename, 'w');
                    if (false !== $local_file) {
                        if (false !== fwrite($local_file, $imageInfo["body"])) {
                            fclose($local_file);
                        }
                    }
                }
                $get_point[$i]['tgerm'] = $filename;


                //开始计算店铺下属导购的分成比例


                $get_point[$i]['shop_sales_fenc'] = shop_to_sales4($res['shop_sn']);
                //--end结束下属商店结算
                //print_r($get_point);


                $li['shop'] = 2;
            } elseif ($get_point[$i]['p_type'] == "3") {

                $sql = "select sales_sn,sales_name,ticket from sales where sales_sn='" . $get_point[$i]['p_id'] .
                    "'";
                $res = $GLOBALS['db']->getRow($sql);
                $get_point[$i]['qudao_sn'] = $res['sales_sn'];
                $get_point[$i]['qudao_name'] = $res['sales_name'];
                /*
                $sql_g = "select a.product_price,a.order_total_price,a.order_status,case when a.order_status=2 then '待发货' when a.order_status=3 then '已发货' when a.order_status=5 then '已完成' when a.order_status=8 then '维权' end  as status_name,a.order_express_price,a.buyer_nick,a.buyer_openid,b.cj_sn,b.cj_type, from_unixtime(a.order_create_time) as order_create_time,a.order_sn,a.product_name,a.product_count,a.order_total_price  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid where cj_type='sales' and cj_sn='" .
                $res['sales_sn'] . "' group by b.openid,a.order_sn order by from_unixtime(a.order_create_time) desc   ";
                $get_point[$i]['fc_list'] = $GLOBALS['db']->getAll($sql_g);


                //设置分成
                for ($j = 0; $j < count($get_point[$i]['fc_list']); $j++) {
                $get_point[$i]['fc'] = ($get_point[$i]['fc_list'][$j]['order_total_price'] - $get_point[$i]['fc_list'][$j]['order_express_price']) *
                $get_point[$i]['point'] / 100;
                $zfc += $get_point[$i]['fc'];
                $zbl += $get_point[$i]['point'];
                if ($get_point[$i]['fc_list'][$j]['order_status'] == 8) {
                $wqje += $get_point[$i]['fc_list'][$j]['order_total_price'];
                } else {
                $zcje += $get_point[$i]['fc_list'][$j]['order_total_price'];
                }

                }
                $get_point[$i]['zfc'] = $zfc;
                $get_point[$i]['zbl'] = $zbl;
                //正常金额
                $get_point[$i]['zcje'] = $zcje;
                //维权金额
                $get_point[$i]['wqje'] = $wqje;

                $get_point[$i]['sjje'] = $get_point[$i]['point'] * $zcje / 100;

                $get_point[$i]['zje'] = $wqje + $zcje;
                $zfc = 0;
                $zbl = 0;
                $zje = 0;
                $wqje = 0;
                $zcje = 0;*/

                $get_point[$i]['fc_list'] = fenc_2($res['sales_sn'], 'sales', $get_point[$i]['point']);
                //获取二维码地址
                $ticket = $res['ticket'];
                if (!empty($ticket)) {

                    $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode($ticket);
                    $imageInfo = downloadImageFromWeiXin($url);
                    $qrcodename = md5($ticket);
                    $filename = 'upload/cj_qrcode/sales/' . $qrcodename . ".jpg";
                    $local_file = fopen($filename, 'w');
                    if (false !== $local_file) {
                        if (false !== fwrite($local_file, $imageInfo["body"])) {
                            fclose($local_file);
                        }
                    }
                }
                $get_point[$i]['tgerm'] = $filename;


                $li['sales'] = 2;
            }


        }

        //print_r($get_point);

        $smarty->assign('ptype', 1);

        $smarty->assign('fc', $get_point);
        $smarty->assign('fall', 'fxfc2');
        $smarty->assign('op', $openid);
        $smarty->display('mcenter_3.tpl');
    }

}

if ($_REQUEST['act'] == 'order_search') {


    if (CUS == 'YATE' && U_DB2 == 11) {
        ///夸库查询
        class SDB2
        {
            public $goods_sn;
            public $order_sn;
            public $tel;
            public $order_id;

            public function get_goods_list()
            {
                $sql = "select * from goods limit 1";
                $res = $GLOBALS['db2']->getAll($sql);
                return $res;
            }


            public function get_goods_mx()
            {
                $sql = "select a.goods_sn,a.goods_name,b.color_code,b.color_name,c.size_code,c.size_name from goods a inner join goods_color b on a.goods_id=b.goods_id inner join goods_size c on a.goods_id=c.goods_id where a.goods_sn='" .
                    $this->goods_sn . "' group by a.goods_sn,b.color_code ,c.size_code";
                $res = $GLOBALS['db2']->getAll($sql);
                return $res;
            }


            public function get_goods_color()
            {
                $sql = "select a.goods_id,a.goods_sn,a.goods_name,b.color_id,b.color_code,b.color_name from goods a inner join goods_color b on a.goods_id=b.goods_id inner join goods_size c on a.goods_id=c.goods_id where a.goods_sn='" .
                    $this->goods_sn . "' group by a.goods_sn,b.color_code ";
                $res = $GLOBALS['db2']->getAll($sql);
                for ($i = 0; $i < count($res); $i++) {

                    $sql2 = "select b.size_code,b.size_name,a.sl,a.sl2,a.sl3 from spkcb a left join size b on a.size_id=b.size_id where  a.goods_id='" .
                        $res[$i]['goods_id'] . "' and a.color_id='" . $res[$i]['color_id'] . "'";
                    $res[$i]['size_mx'] = $GLOBALS['db2']->getAll($sql2);
                }
                return $res;
            }


            public function get_goods_sn()
            {
                $sql = "select goods_sn,goods_name from goods where goods_sn like '%" . $this->
                    goods_sn . "%'";
                $res = $GLOBALS['db2']->getAll($sql);
                return $res;
            }


            public function get_order_info()
            {
                $sql = "select order_sn from order_info where order_sn='" . $this->order_sn .
                    "'";
                $res = $GLOBALS['db2']->getAll($sql);
                return $res;
            }
            public function get_order_tel()
            {
                // $sql = "select order_sn,consignee,order_id,pay_status,order_status,is_send,shipping_status,shipping_name,invoice_no,from_unixtime(pay_time) as pay_time from order_info  where tel='" .
                //                    $this->tel . "' or  mobile='" . $this->tel . "' order by order_id desc";
                $sql = "select a.order_sn,a.consignee,a.order_id,a.pay_status,a.order_status,a.is_send,a.shipping_status,a.shipping_name,a.invoice_no,from_unixtime(a.pay_time) as pay_time,b.sdmc,b.sddm from order_info a inner join shangdian b on a.sd_id=b.id  where a.tel='" .
                    $this->tel . "' or  a.mobile='" . $this->tel . "' order by a.order_id desc";


                $res = $GLOBALS['db2']->getAll($sql);
                return $res;
            }
            public function get_order_action()
            {
                //$sql = "select *,from_unixtime(log_time) as action_time from order_action where order_id='" .
                //  $this->order_id . "' order by action_id desc";


                $sql = "select *,from_unixtime(log_time) as action_time from order_action where order_id='" .
                    $this->order_id . "' and action_no in ('order_delivery','updateDeliverySendAction','confirm')  order by action_id desc";
                $res = $GLOBALS['db2']->getAll($sql);
                return $res;
            }
            public function get_user_info()
            {
                $sql = "select a.user_name,a.nick_name,b.* from users a,user_address b where a.user_id=b.user_id and b.receiver_mobile='" .
                    $this->tel . "'";
                $res = $GLOBALS['db2']->getRow($sql);
                return $res;
            }
        }


        function preg_zz($obj)
        {
            $zhengze = array(
                array("name" => "sf", "preg" => "/^[0-9]{12}$|\d{9}/"),
                array("name" => "ems", "preg" => "/^[A-Z]{2}[0-9]{9}[A-Z]{2}$|^[0-9]{13}$/"),
                array("name" => "sto", "preg" =>
                        "/^(268|888|588|688|368|468|568|668|768|868|968)[0-9]{9}$|^(268|888|588|688|368|468|568|668|768|868|968)[0-9]{10}$|^(STO)[0-9]{10}$/"),
                array("name" => "zto", "preg" =>
                        "/^((618|680|778|768|688|618|828|988|118|888|571|518|010|628|205|880|717|718|728|738|761|762|763|701|757)[0-9]{9})$|^((2008|2010|8050|7518)[0-9]{8})$/"),
                array("name" => "zjs", "preg" => "/^[a-zA-Z0-9]{10}/"),
                array("name" => "yunda", "preg" => "/^[s]*[1-9][0-9]{12}[s]*$/"),
                array("name" => "htky", "preg" => "/^(A|B|C|D|E|H|0)(D|X|[0-9])(A|[0-9])[0-9]{10}$|^(21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37|38|39)[0-9]{10}$|^50[0-9]{12}$"),
                array("name" => "ttkdex", "preg" => "/^[0-9]{12}$/"),
                array("name" => "jd", "preg" => "/^[0-9]{12}/"),
                array("name" => "yto", "preg" =>
                        "/^(0|1|2|3|5|6|7|8|E|D|F|G|V|W|e|d|f|g|v|w)[0-9]{9}$/"),
                );

            $a = array();
            for ($i = 0; $i < count($zhengze); $i++) {
                $dat = preg_match($zhengze[$i]['preg'], $obj);
                //print_r($dat) ;
                if ($dat == 1) {
                    array_push($a, $zhengze[$i]['name']);
                }


            }

            $kuaidi_arr = array();
            for ($j = 0; $j < count($a); $j++) {
                $action = shipping($a[$j]);
                $inf = kuaidi_action($action, $obj);

                if ($inf['errCode'] == 0) {
                    array_push($kuaidi_arr, $inf);
                }
            }
            return $kuaidi_arr;
        }


        //print_r($zhengze);


        function shipping($obj)
        {
            switch ($obj) {
                case 'sf':
                    $data = "shunfeng";
                    break;
                case 'ems':
                    $data = "ems";
                    break;
                case 'sto':
                    $data = "shentong";
                    break;
                case 'yto':
                    $data = "yuantong";
                    break;
                case 'zto':
                    $data = "zhongtong";
                    break;
                case 'zjs':
                    $data = "zhaijisong";
                    break;
                case 'yunda':
                    $data = "yunda";
                    break;
                case 'cces':
                    $data = "cces";
                    break;
                case 'pick':
                    $data = "pick";
                    break;
                case 'htky':
                    $data = "huitong";
                    break;
                case 'ttkdex':
                    $data = "tiantian";
                    break;
                case 'vems':
                    $data = "ems";
                    break;
                case 'Vsf':
                    $data = "shunfeng";
                    break;
                case 'vyunda':
                    $data = "yunda";
                    break;
                case 'vzjs':
                    $data = "zhaijisong";
                    break;
                case 'vyto':
                    $data = "yuantong";
                    break;
                case 'JDex':
                    $data = "jingdong";
                    break;
                case 'jdsf':
                    $data = "jingdong";
                    break;
                case 'jd':
                    $data = "jingdong";
                    break;

            }
            return $data;
        }


        $typeCom = "shentong";
        $typeNu = "868020761205";


        function kuaidi_action($typeCom, $typeNu)
        {
            $type = 'json';
            $encode = 'utf8';

            $id = '104235';
            $AppKey = 'f359c979eb8ccc941819175e3c577333'; //请将XXXXXX替换成您在http://kuaidi100.com/app/reg.html申请到的KEY

            $url = "http://api.ickd.cn/?id=$id&secret=$AppKey&com=$typeCom&nu=$typeNu&type=$type&ord=desc&encode=$encode&ver=2&button=%CC%E1%BD%BB";


            //优先使用curl模式发送数据
            if (function_exists('curl_init') == 1) {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_HEADER, 0);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
                curl_setopt($curl, CURLOPT_TIMEOUT, 5);
                $get_content = curl_exec($curl);
                curl_close($curl);
            } else {
                /*
                include("snoopy.php");
                $snoopy = new snoopy();
                $snoopy->referer = 'http://www.google.com/';//伪装来源
                $snoopy->fetch($url);
                $get_content = $snoopy->results;*/
            }


            $get_content = json_decode($get_content);
            //print_r($get_content);
            $get_content = (array )$get_content;
            if (!empty($get_content['data'])) {
                $get_content['data'] = objtoarr($get_content['data']);
            }

            return $get_content;
        }
        function objtoarr($obj)
        {
            $ret = array();
            foreach ($obj as $key => $value) {
                if (gettype($value) == 'array' || gettype($value) == 'object') {
                    $ret[$key] = objtoarr($value);
                } else {
                    $ret[$key] = $value;
                }
            }
            return $ret;
        }


        if (isset($_REQUEST['openid'])) {
            $openid = $_REQUEST['openid'];
        }

        function gre($openid)
        {
            $sql = "select wx_tel from users where openid ='" . $openid . "'";
            $res = $GLOBALS['db']->getRow($sql);
            return $res;
        }
        $tel = gre($openid);

        $newDB = new SDB2();

        $newDB->tel = $tel['wx_tel'];

        $user_info = $newDB->get_order_tel();
        if (empty($user_info)) {
            $data = "绑定手机号码无购买记录";

        } else {


            for ($j = 0; $j < count($user_info); $j++) {
                $newDB->order_id = $user_info[$j]['order_id'];
                if ($user_info[$j]['order_status'] == 1 && $user_info[$j]['is_send'] == 2 && $user_info[$j]['shipping_status'] ==
                    1) {
                    $user_info[$j]['ac'] = $newDB->get_order_action();

                    //require (dirname(__file__) . '/kuaidi/get.php');
                    //print_r($user_info);
                    $shipping_name = shipping($user_info[$j]['shipping_name']);
                    $user_info[$j]['kd'] = kuaidi_action($shipping_name, $user_info[$j]['invoice_no']);

                } else {
                    $user_info[$j]['ac'] = $newDB->get_order_action();


                }
            }


        }
        // print_r($user_info);

        $smarty->assign('user_info', $user_info);
        $smarty->assign('kuaidi', $kuaidi);
        $smarty->assign('fall', 'yate');
        $smarty->assign('op', $openid);
        $smarty->display('mcenter_3.tpl');


    } else {

        $openid = $_REQUEST['openid'];


        function check_inlog($openid)
        {
            $sql = "select * from users_check_log where openid='" . $openid .
                "' order by add_time desc";
            $res = $GLOBALS['db']->getAll($sql);

            $sum = "select sum(rank_points) as sl from users_check_log where openid='" . $openid .
                "' order by add_time desc";
            $sum = $GLOBALS['db']->getRow($sum);
            return array("list" => $res, "sum" => $sum['sl']);
        }


        $check = check_inlog($openid);

        function expoint_inlog($openid)
        {
            $sql = "select * from users_expoint_log where openid='" . $openid .
                "' order by add_time desc";
            $res = $GLOBALS['db']->getAll($sql);

            $sum = "select sum(rank_points) as sl from users_expoint_log where openid='" . $openid .
                "' order by add_time desc";
            $sum = $GLOBALS['db']->getRow($sum);
            return array("list" => $res, "sum" => $sum['sl']);
        }


        $expoint_inlog = expoint_inlog($openid);


        function get_setsys()
        {
            $sql = "select * from set_sys where keyword='check_in'";
            $res = $GLOBALS['db']->getRow($sql);
            return $res;
        }
        $sys_list = get_setsys();

        //兑换实物券扣除积分

        function sncode_real($openid)
        {
            $sql = "select add_time,type_val,note from wx_sncode_real where openid='" . $openid .
                "' order by add_time desc";
            $res = $GLOBALS['db']->getAll($sql);

            $sum = "select sum(type_val) as sl from wx_sncode_real where openid='" . $openid .
                "' order by add_time desc";
            $sum = $GLOBALS['db']->getRow($sum);
            return array("list" => $res, "sum" => $sum['sl']);
        }
        $sncode_real = sncode_real($openid);
        $smarty->assign('sncode_real', $sncode_real['list']);
        //---


        $smarty->assign('sys_list', $sys_list);


        $smarty->assign('check_sum', $check['sum'] + $expoint_inlog['sum'] - $sncode_real['sum']);
        $smarty->assign('check', $check['list']);


        $smarty->assign('expoint_inlog', $expoint_inlog['list']);


        //是否允许兑换成实物券
        function get_ex_real()
        {
            $sql = "select a.val,b.p_id,b.type,b.type_val,b.note from set_sys a inner join set_sys_mx b on a.keyword=b.p_id where a.keyword='ex_real' order by type";
            $res = $GLOBALS['db']->getAll($sql);

            return array("list" => $res, "ex_real" => $res[0]['val']);
        }
        $get_ex_real = get_ex_real();


        //增加搜索微信小店订单
        function getweixiaodian_order($obj)
        {
            $sql = "select *,from_unixtime(order_create_time) as add_t from weixiaodian where buyer_openid='" .
                $obj . "' order by from_unixtime(order_create_time) desc ";
            $res = $GLOBALS['db']->getAll($sql);
            return $res;
        }
        $weixiaodian = getweixiaodian_order($openid);

        $smarty->assign('weixiaodian', $weixiaodian);
        //print_r($get_ex_real);

        $smarty->assign('ex_real', $get_ex_real['ex_real']);
        $smarty->assign('fall', 'yate');
        $smarty->assign('op', $openid);
        $smarty->display('mcenter_3.tpl');

    }


}


if ($_REQUEST['act'] == 'schedule') {


    $smarty->display('other/schedule/index.html');

}

/////////////////////////////////////////////////////////分享页面
if ($_REQUEST['act'] == 'fxqrcode') {
    
     function downloadImageFromWeiXin($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, 0); //只取body头
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $package = curl_exec($ch);
        $httpinfo = curl_getinfo($ch);
        curl_close($ch);
        return array_merge(array('body' => $package), array('header' => $httpinfo));
    }
    
    

 if(isset($_REQUEST['openid'])) 
    {
    $openid = $_REQUEST['openid'];
    }
    
    $sql="select p_id from tgpoint where openid='".$openid."'";
    $res = $GLOBALS['db']->getRow($sql);
    $p_id=$res['p_id'];
    
    $sql1="select * from shop where shop_sn='".$p_id."'";
    $res1 = $GLOBALS['db']->getRow($sql1);
    
    
     //获取二维码地址
                $ticket = $res1['ticket'];
                if (!empty($ticket)) {

                    $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode($ticket);
                    $imageInfo = downloadImageFromWeiXin($url);
                    $qrcodename = md5($ticket);
                    $filename = 'upload/cj_qrcode/shop/' . $qrcodename . ".jpg";
                    $local_file = fopen($filename, 'w');
                    if (false !== $local_file) {
                        if (false !== fwrite($local_file, $imageInfo["body"])) {
                            fclose($local_file);
                        }
                    }
                }
                $res1['tgerm'] = $filename;
    
    
    
    //print_r($res);
    $smarty->assign('list', $res1);
    $smarty->display('share/wx_share.tpl');
}



/////////////////////////////////////////////////////////分享页面



if ($_REQUEST['act'] == 'set_or_status') {

    if (isset($_REQUEST['sn'])) {

        $sql = "update weixiaodian set or_status='" . $_REQUEST['or_status'] .
            "' where order_sn='" . $_REQUEST['sn'] . "'";
        $res = $GLOBALS['db']->query($sql);
        echo 1;
    } else {
        echo 2;
    }
}
?>
