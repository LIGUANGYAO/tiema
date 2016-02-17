<?php
define('IN_ECS', true);


require (dirname(__file__) . '/sub/is_weixin.php');
require (dirname(__file__) . '/includes/init2.php');
//require (dirname(__file__) . '/sub/sub_extel.php');

//echo $openid;

//echo "<script>window.location.href='openshop2.php';</script>";

if (empty($_REQUEST['m'])) {
    $_REQUEST['m'] = 'default';
} else {
    $_REQUEST['m'] = trim($_REQUEST['m']);
}

if (isset($_REQUEST['openid'])) {
    $openid = $_REQUEST['openid'];
    //print_r($openid);
} else {
    //print_r(1111111);
}

//$openid='o9NG0jmFhogdI8p0o0StlhCL9U0Y';
if ($_REQUEST['m'] == 'default') {


    if (empty($openid)) {
        echo "请从公众号登陆";
    } else {


        $sel = "select wx_tel from users where openid='" . $openid . "'";
        $sel = $GLOBALS['db']->getRow($sel);

        if (empty($sel['wx_tel'])) {
            $smarty->assign('openid', $openid);

            //20140824判断是否首次进入个人中心增加积分、实物券
            function mcenter_int()
            {
                $sql = "select a.val,b.p_id,b.type,b.type_val,b.note from set_sys a inner join set_sys_mx b on a.keyword=b.p_id where a.keyword='mcenter_int' order by type";
                $res = $GLOBALS['db']->getAll($sql);

                return array("list" => $res, "mcenter_int" => $res[0]['val']);
            }
            $mcenter_int = mcenter_int();
            if ($mcenter_int['mcenter_int'] == 1 && $mcenter_int['list'][0]['type_val'] > 0) {
                $smarty->assign('type_val', $mcenter_int['list'][0]['type_val']);
                $smarty->assign('mcenter_int', '1');
            }

            function mcenter_dyq()
            {
                $sql = "select a.val,b.p_id,b.type,b.type_val,b.note from set_sys a inner join set_sys_mx b on a.keyword=b.p_id where a.keyword='mcenter_dyq' order by type";
                $res = $GLOBALS['db']->getAll($sql);

                return array("list" => $res, "mcenter_dyq" => $res[0]['val']);
            }
            $mcenter_dyq = mcenter_dyq();

            if ($mcenter_dyq['mcenter_dyq'] == 1 && $mcenter_dyq['list'][0]['note'] != '') {
                 $smarty->assign('note', $mcenter_dyq['list'][0]['note']);
                $smarty->assign('mcenter_dyq', '1');
            }

            function set_sys($obj)
            {
                $sql = "select val from set_sys where keyword='" . $obj . "'";
                $res = $GLOBALS['db']->getRow($sql);
                return $res['val'];
            }

            $val = set_sys("wxextel");
            if ($val == 1) {
                $smarty->display('exTel/index3.htm');
            } else {
                $smarty->display('exTel/index2.htm');
            }


            //$smarty->display('exTel/index3.htm');
            //不需要验证手机号的用下面的


        } else {
            echo "<script>window.location.href='mcenter.php?openid=" . $openid .
                "';</script>";
        }
    }


    //  ///修改1,查询语句
    //    //sort_no,tzsy 要记得添加
    //    $sql = "select id,article_sn,article_name,sort_no,tzsy,last_update,article_note_1,title,type,article_lx,article_msg from article";
    //
    //
    //    $article_list = get_article_list($Num, "article", $sql);
    //
    //    //print_r($article_list);
    //    $smarty->assign('article_list', $article_list['items']);
    //    $smarty->assign('fall', 1);
    //    //$smarty->assign('title', $aaa);
    //    $smarty->assign('p_Array', $article_list['page']);


}


if ($_REQUEST['m'] == 'telonly') {


    if (isset($_REQUEST['tel'])) {
        $tel = $_REQUEST['tel'];
        $sql = "select openid from users where wx_tel='" . $tel . "'";
        $res = $GLOBALS['db']->getRow($sql);
        if (empty($res)) {
            echo "1";
        } else {
            echo "2";
        }
    } else {
        echo "0";
    }

}

if ($_REQUEST['m'] == 'telonly2') {


    if (isset($_REQUEST['tel'])) {
        $tel = $_REQUEST['tel'];
        $random = $_REQUEST['random'];


        $sql = "select openid from users where wx_tel='" . $tel . "'";
        $res = $GLOBALS['db']->getRow($sql);

        $sql2 = "select * from  sms_random  where  tel='" . $tel .
            "' and is_use=0 order by add_time desc";
        $res2 = $GLOBALS['db']->getAll($sql2);

        //print_r($res2);exit;
        if (empty($res) && $res2[0]['random_code'] == $random) {
            echo "1";
        } elseif (!empty($res)) {
            echo "2";
        } else {
            echo "3";
        }
    } else {
        echo "0";
    }

}

if ($_REQUEST['m'] == 'exOk') {


    if (isset($_REQUEST['mobile_phone']) && isset($_REQUEST['openid'])) {


        $tel = $_REQUEST['mobile_phone'];

        $op = $_REQUEST['openid'];


        $sel = "select wx_tel from users where openid='" . $op . "'";
        $sel = $GLOBALS['db']->getRow($sel);

        if (empty($sel['wx_tel'])) {
            $ran = rand(100000, 999999);
            $sql = "update users set wx_tel='" . $tel . "',wx_pwd='" . $ran .
                "' where openid='" . $op . "'";
            ;
            $res = $GLOBALS['db']->query($sql);


            //20140823增加 验证成功 首次进入个人中心添加积分
            function mcenter_int()
            {
                $sql = "select a.val,b.p_id,b.type,b.type_val,b.note from set_sys a inner join set_sys_mx b on a.keyword=b.p_id where a.keyword='mcenter_int' order by type";
                $res = $GLOBALS['db']->getAll($sql);

                return array("list" => $res, "mcenter_int" => $res[0]['val']);
            }
            $mcenter_int = mcenter_int();

            if ($mcenter_int['mcenter_int'] == 1 && $mcenter_int['list'][0]['type_val'] > 0) {

                $get_one = "select openid from users_check_log where type=99 and openid='" . $op .
                    "'";
                $get_one = $GLOBALS['db']->getRow($get_one);


                if (empty($get_one)) {
                    $add_time = date('Y-m-d H:i:s', time());
                    $last_update_2 = date('Y-m-d', time());

                    $dele_chech = "delete from users_check_log where openid='" . $op .
                        "' and last_update_2='" . $last_update_2 . "' ";
                    $dele_chech = $GLOBALS['db']->query($dele_chech);


                    $sql_check = "insert into users_check_log(openid,is_check,add_time,last_update_2,rank_points,type) values ('" .
                        $op . "','1','" . $add_time . "','" . $last_update_2 . "','" . $mcenter_int['list'][0]['type_val'] .
                        "',99)";

                    $sql_check = $GLOBALS['db']->query($sql_check);
                }

            }

            //20140823增加 验证成功 首次进入个人中心添加 抵用券
            function mcenter_dyq()
            {
                $sql = "select a.val,b.p_id,b.type,b.type_val,b.note from set_sys a inner join set_sys_mx b on a.keyword=b.p_id where a.keyword='mcenter_dyq' order by type";
                $res = $GLOBALS['db']->getAll($sql);

                return array("list" => $res, "mcenter_dyq" => $res[0]['val']);
            }
            $mcenter_dyq = mcenter_dyq();
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


            if ($mcenter_dyq['mcenter_dyq'] == 1 && $mcenter_dyq['list'][0]['note'] != '') {
                $random_code = int_password();

                $time = date('Y-m-d', time());
                $time2 = date('Y-m-d H:i:s', time());
                $time3 = datetounit($time2);
                $limittime = unittodate($time3, 180); //到期时间
                $sql = "select random_code from wx_sncode_real where  hd_sn='A000999' and openid='" .
                    $op . "'";
                $res = $GLOBALS['db']->getRow($sql);

                if (empty($res)) {
                    $sql3 = "insert into wx_sncode_real(type_val,note,openid,sncode,prizetype,add_time,limit_time,hd_sn,lo_date,random_code) values ('" .
                        $type_val . "','" . $mcenter_dyq['list'][0]['note'] . "','" . $op . "','" . $random_code .
                        "','0','" . $time2 . "','" . $limittime . "','A000999','100','" . $random_code .
                        "')";
                    // print_r($sql3);exit;
                    $sql3 = $GLOBALS['db']->query($sql3);
                    //return 1;
                } else {
                    //return 0;
                }

            }
            //---end
            $smarty->assign('mcenter_dyq_val', $mcenter_dyq['mcenter_dyq']);
            $smarty->assign('mcenter_dyq', $mcenter_dyq['list'][0]);


            header("location: mcenter.php?openid=" . $op);
        } else {
            echo "wx手机号已经存在,执行失败";
        }


    }


}


if ($_REQUEST['m'] == 'get_random') {


    function timeDiff_x($aTime, $bTime)
    {
        // 分割第一个时间
        $ayear = substr($aTime, 0, 4);
        $amonth = substr($aTime, 4, 2);
        $aday = substr($aTime, 6, 2);
        $ahour = substr($aTime, 8, 2);
        $aminute = substr($aTime, 10, 2);
        $asecond = substr($aTime, 12, 2);
        // 分割第二个时间
        $byear = substr($bTime, 0, 4);
        $bmonth = substr($bTime, 4, 2);
        $bday = substr($bTime, 6, 2);
        $bhour = substr($bTime, 8, 2);
        $bminute = substr($bTime, 10, 2);
        $bsecond = substr($bTime, 12, 2);
        // 生成时间戳
        $a = mktime($ahour, $aminute, $asecond, $amonth, $aday, $ayear);
        $b = mktime($bhour, $bminute, $bsecond, $bmonth, $bday, $byear);
        $timeDiff['second'] = $a - $b;
        // 采用了四舍五入,可以修改
        $timeDiff['mintue'] = round($timeDiff['second'] / 60);
        $timeDiff['hour'] = round($timeDiff['mintue'] / 60);
        $timeDiff['day'] = round($timeDiff['hour'] / 24);
        $timeDiff['week'] = round($timeDiff['day'] / 7);
        $timeDiff['month'] = round($timeDiff['day'] / 30); // 按30天来算
        $timeDiff['year'] = round($timeDiff['day'] / 365); // 按365天来算
        return $timeDiff;
    }
    function get_time_diff($t)
    {
        $time = date('Y-m-d H:i:s', time());
        $time = strtotime($time);
        //echo $time;exit;
        $aaa = date("YmdHis", $time);
        // $time = date('Y-m-d H:i:s', time());
        $t = strtotime($t);
        //echo $time;exit;
        $t = date("YmdHis", $t);
        $a = timeDiff_x($aaa, $t);
        return $a;
    }

    //短信插入方法
    //插入短信验证码

    function insert_sms_random($openid, $tel)
    {
        $code = rand(100000, 999999);

        $n_time = date('Y-m-d H:i:s', time());
        $sql2 = "insert into sms_random (random_code,openid,tel,add_time) values ('" . $code .
            "','" . $openid . "','" . $tel . "','" . $n_time . "')";
        $res2 = $GLOBALS['db']->query($sql2);
        //更新随机码
        return $code;

    }

    function get_sms_random($openid)
    {
        $sql2 = "select * from  sms_random  where openid='" . $openid .
            "' and is_use=0 order by add_time desc";
        $res2 = $GLOBALS['db']->getAll($sql2);
        return $res2;
    }

    function get_count_sms_random($openid)
    {
        $time1 = date('Y-m-d 00:00:0', time());
        $time2 = date('Y-m-d 23:59:59', time());
        $sql2 = "select count(openid) as sl from  sms_random  where openid='" . $openid .
            "' and  add_time between '" . $time1 . "' and '" . $time2 . "'";
        $res2 = $GLOBALS['db']->getRow($sql2);
        return $res2;
    }


    if (isset($_REQUEST['tel']) && isset($_REQUEST['openid'])) {
        $tel = $_REQUEST['tel'];
        $openid = $_REQUEST['openid'];


        //开始短信接口测试
        $sms_list = get_sms_random($openid);

        $uu = get_time_diff($sms_list[0]['add_time']);


        $smscount = get_count_sms_random($openid);
        //exit(W::response($xml, $smscount['sl']));
        if ($smscount['sl'] >= 3) {
            $data = "获取失败,今天已经获取3个短信验证码";


        } elseif ($uu['second'] <= 60) {
            $data = (60 - $uu['second']) . "秒后,可重新获取验证码";

        } else {

            //插入验证随机码
            $sms = insert_sms_random($openid, $tel);
            if (!empty($sms)) {

                require (dirname(__file__) . '/duanxin/sms_curl.php');

                function get_wxextel()
                {
                    $sql = "select a.val,b.p_id,b.type,b.type_val,b.note from set_sys a inner join set_sys_mx b on a.keyword=b.p_id where a.keyword='wxextel' order by type";
                    $res = $GLOBALS['db']->getAll($sql);

                    return array("list" => $res, "wxextel" => $res[0]['val']);
                }
                $get_wxextel = get_wxextel();

                $sms_err = Sms1($tel, $sms, $get_wxextel['list'][0]['note'], $get_wxextel['list'][1]['note']);

                // exit(W::response($xml, $sms_err));
                if ($sms_err == 100) {
                    //15259575716

                    $data = "验证码已发送!";

                } else {


                    $data = "验证码发送异常,错误信息" . $sms_err . "";


                }

            } else {

                $data = "验证信息发送失败";

            }
        }


        $sql = "select openid from users where wx_tel='" . $tel . "'";
        $res = $GLOBALS['db']->getRow($sql);
        if (empty($res)) {
            echo $data;
        } else {
            echo "2";
        }
    } else {
        echo "0";
    }

}

?>