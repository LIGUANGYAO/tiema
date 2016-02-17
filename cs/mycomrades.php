<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init2.php');

require (dirname(__file__) . '/sub/sub_openid.php');


if (empty($_REQUEST['g'])) {
    $_REQUEST['g'] = 'default';
} else {
    $_REQUEST['g'] = trim($_REQUEST['g']);
}


if ($_REQUEST['g'] == 'default') {


    $dt = date("Y-m-d");

    //获取一级总数量
    $yjfx = "select IFNULL(count(*),0) as sl  from users where p_openid ='" . $openId .
        "'  ";

    $yjfx = $GLOBALS['db']->getRow($yjfx);

    $today = "select IFNULL(count(*),0) as tdsl  from users where p_openid ='" . $openId .
        "' and (add_time between '" . $dt . " 00:00:00'  and  '" . $dt . " 23:59:59' )";

    $today = $GLOBALS['db']->getRow($today);


    $fcarr = array();
    $fcarr['yjfx'] = array('sl' => $yjfx['sl'], 'tdsl' => $today['tdsl']);


    //$yjfxarr="select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime from users where p_openid ='".$openId."'  ";

    $yjfxarr = "select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,p_openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime from users where p_openid ='" .
        $openId . "'  ";

    $yjfxarr = $GLOBALS['db']->getAll($yjfxarr);


    if (!empty($yjfxarr)) {


        $fie = '';

        for ($i = 0; $i < count($yjfxarr); $i++) {
            $yh = "'";
            $yh2 = "',";


            //echo $yh.$yjfxarr[$i]['openid'].$yh2."<br>";

            $fie .= $yh . $yjfxarr[$i]['openid'] . $yh2;

        }
        $fie = substr($fie, 0, -1);


        //获取二级总数量
        $ejfx = "select IFNULL(count(*),0) as sl  from users where p_openid  in (" . $fie .
            ")  ";

        $ejfx = $GLOBALS['db']->getRow($ejfx);

        $ejtoday = "select IFNULL(count(*),0) as tdsl  from users where p_openid in (" .
            $fie . ") and (add_time between '" . $dt . " 00:00:00'  and  '" . $dt .
            " 23:59:59' )";

        $ejtoday = $GLOBALS['db']->getRow($ejtoday);

        $ejfxarr = "select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,p_openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime from users where p_openid in (" .
            $fie . ")  ";

        $ejfxarr = $GLOBALS['db']->getAll($ejfxarr);
        if (!empty($ejfxarr)) {

            $fie3 = '';
            for ($i = 0; $i < count($ejfxarr); $i++) {
                $yh = "'";
                $yh2 = "',";


                //echo $yh.$yjfxarr[$i]['openid'].$yh2."<br>";

                $fie3 .= $yh . $ejfxarr[$i]['openid'] . $yh2;

            }
            $fie3 = substr($fie3, 0, -1);


            //获取二级总数量
            $sjfx = "select IFNULL(count(*),0) as sl  from users where p_openid  in (" . $fie3 .
                ")  ";

            $sjfx = $GLOBALS['db']->getRow($sjfx);

            $sjtoday = "select IFNULL(count(*),0) as tdsl  from users where p_openid in (" .
                $fie3 . ") and (add_time between '" . $dt . " 00:00:00'  and  '" . $dt .
                " 23:59:59' )";

            $sjtoday = $GLOBALS['db']->getRow($sjtoday);

            $sjfxarr = "select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,p_openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime from users where p_openid in (" .
                $fie3 . ")  ";

            $sjfxarr = $GLOBALS['db']->getAll($sjfxarr);
        }
    }

    $fcarr['yjfx'] = array('sl' => $yjfx['sl'] = ($yjfx['sl'] ? $yjfx['sl'] : 0),
        'tdsl' => $today['tdsl'] = ($today['tdsl'] ? $today['tdsl'] : 0));
    $fcarr['ejfx'] = array('sl' => $ejfx['sl'] = ($ejfx['sl'] ? $ejfx['sl'] : 0),
        'tdsl' => $ejtoday['tdsl'] = ($ejtoday['tdsl'] ? $ejtoday['tdsl'] : 0));
    $fcarr['sjfx'] = array('sl' => $sjfx['sl'] = ($sjfx['sl'] ? $sjfx['sl'] : 0),
        'tdsl' => $sjtoday['tdsl'] = ($sjtoday['tdsl'] ? $sjtoday['tdsl'] : 0));


    //print_r($fcarr);

    $smarty->assign('fcarr', $fcarr);
    //exit;
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $goods_list['page']);
    $smarty->display('cs/mycomrades.html');


}


if ($_REQUEST['g'] == 'memberlist') {


    $dt = date("Y-m-d");
    $fcarr = array();


    if (isset($_REQUEST['type'])) {
        $type = trim($_REQUEST['type']);


        $u = trim($_REQUEST['u']);

        if ($type == '1') {

            //获取一级总数量
            $yjfx = "select IFNULL(count(*),0) as sl  from users where p_openid ='" . $openId .
                "'  ";

            $yjfx = $GLOBALS['db']->getRow($yjfx);

            $today = "select IFNULL(count(*),0) as tdsl  from users where p_openid ='" . $openId .
                "' and (add_time between '" . $dt . " 00:00:00'  and  '" . $dt . " 23:59:59' )";

            $today = $GLOBALS['db']->getRow($today);

            $wx_pay = "select IFNULL(count(*),0) as paysl  from users where p_openid ='" . $openId .
                "' and  wx_pay=1";

            $wx_pay = $GLOBALS['db']->getRow($wx_pay);


            $fcarr = array();
            $fcarr['yjfx'] = array('sl' => $yjfx['sl'], 'tdsl' => $today['tdsl']);


            //$yjfxarr="select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime from users where p_openid ='".$openId."'  ";

            $yjfxarr = "select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,p_openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime from users where p_openid ='" .
                $openId . "'  ";

            $yjfxarr = $GLOBALS['db']->getAll($yjfxarr);


            $fcarr['fc'] = array('sl' => $yjfx['sl'], 'tdsl' => $today['tdsl'], 'paysl' => $wx_pay['paysl']);
            //print_r($fcarr);
            $smarty->assign('userInfo', $yjfxarr);
            $smarty->assign('fcarr', $fcarr);


        } elseif ($type == '2') {

            //获取一级总数量
            $yjfx = "select IFNULL(count(*),0) as sl  from users where p_openid ='" . $openId .
                "'  ";

            $yjfx = $GLOBALS['db']->getRow($yjfx);

            $today = "select IFNULL(count(*),0) as tdsl  from users where p_openid ='" . $openId .
                "' and (add_time between '" . $dt . " 00:00:00'  and  '" . $dt . " 23:59:59' )";

            $today = $GLOBALS['db']->getRow($today);


            $fcarr = array();
            $fcarr['yjfx'] = array('sl' => $yjfx['sl'], 'tdsl' => $today['tdsl']);


            //$yjfxarr="select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime from users where p_openid ='".$openId."'  ";

            $yjfxarr = "select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,p_openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime from users where p_openid ='" .
                $openId . "'  ";

            $yjfxarr = $GLOBALS['db']->getAll($yjfxarr);

            if (!empty($yjfxarr)) {


                $fie = '';

                for ($i = 0; $i < count($yjfxarr); $i++) {
                    $yh = "'";
                    $yh2 = "',";


                    //echo $yh.$yjfxarr[$i]['openid'].$yh2."<br>";

                    $fie .= $yh . $yjfxarr[$i]['openid'] . $yh2;

                }
                $fie = substr($fie, 0, -1);


                //获取二级总数量
                $ejfx = "select IFNULL(count(*),0) as sl  from users where p_openid  in (" . $fie .
                    ")  ";

                $ejfx = $GLOBALS['db']->getRow($ejfx);

                $ejtoday = "select IFNULL(count(*),0) as tdsl  from users where p_openid in (" .
                    $fie . ") and (add_time between '" . $dt . " 00:00:00'  and  '" . $dt .
                    " 23:59:59' )";

                $ejtoday = $GLOBALS['db']->getRow($ejtoday);

                $wx_pay = "select IFNULL(count(*),0) as paysl  from users where p_openid in (" .
                    $fie . ")  and wx_pay=1";

                $wx_pay = $GLOBALS['db']->getRow($wx_pay);


                $ejfxarr = "select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,p_openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime from users where p_openid in (" .
                    $fie . ")  ";

                $ejfxarr = $GLOBALS['db']->getAll($ejfxarr);
            }

            $fcarr['fc'] = array('sl' => $ejfx['sl'] = ($ejfx['sl'] ? $ejfx['sl'] : 0),
                'tdsl' => $ejtoday['tdsl'] = ($ejtoday['tdsl'] ? $ejtoday['tdsl'] : 0), 'paysl' =>
                $wx_pay['paysl'] = ($wx_pay['paysl'] ? $wx_pay['paysl'] : 0));


            //print_r($fcarr);
            $smarty->assign('userInfo', $yjfxarr);
            $smarty->assign('fcarr', $fcarr);

        } elseif ($type == '3') {


            //获取一级总数量
            $yjfx = "select IFNULL(count(*),0) as sl  from users where p_openid ='" . $openId .
                "'  ";

            $yjfx = $GLOBALS['db']->getRow($yjfx);

            $today = "select IFNULL(count(*),0) as tdsl  from users where p_openid ='" . $openId .
                "' and (add_time between '" . $dt . " 00:00:00'  and  '" . $dt . " 23:59:59' )";

            $today = $GLOBALS['db']->getRow($today);


            $fcarr = array();
            $fcarr['yjfx'] = array('sl' => $yjfx['sl'], 'tdsl' => $today['tdsl']);


            //$yjfxarr="select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime from users where p_openid ='".$openId."'  ";

            $yjfxarr = "select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,p_openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime from users where p_openid ='" .
                $openId . "'  ";

            $yjfxarr = $GLOBALS['db']->getAll($yjfxarr);

            if (!empty($yjfxarr)) {

                $fie = '';

                for ($i = 0; $i < count($yjfxarr); $i++) {
                    $yh = "'";
                    $yh2 = "',";


                    //echo $yh.$yjfxarr[$i]['openid'].$yh2."<br>";

                    $fie .= $yh . $yjfxarr[$i]['openid'] . $yh2;

                }
                $fie = substr($fie, 0, -1);


                //获取二级总数量
                $ejfx = "select IFNULL(count(*),0) as sl  from users where p_openid  in (" . $fie .
                    ")  ";

                $ejfx = $GLOBALS['db']->getRow($ejfx);

                $ejtoday = "select IFNULL(count(*),0) as tdsl  from users where p_openid in (" .
                    $fie . ") and (add_time between '" . $dt . " 00:00:00'  and  '" . $dt .
                    " 23:59:59' )";

                $ejtoday = $GLOBALS['db']->getRow($ejtoday);

                $ejfxarr = "select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,p_openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime from users where p_openid in (" .
                    $fie . ")  ";

                $ejfxarr = $GLOBALS['db']->getAll($ejfxarr);
                if (!empty($ejfxarr)) {

                    $fie3 = '';
                    for ($i = 0; $i < count($ejfxarr); $i++) {
                        $yh = "'";
                        $yh2 = "',";


                        //echo $yh.$yjfxarr[$i]['openid'].$yh2."<br>";

                        $fie3 .= $yh . $ejfxarr[$i]['openid'] . $yh2;

                    }
                    $fie3 = substr($fie3, 0, -1);


                    //获取二级总数量
                    $sjfx = "select IFNULL(count(*),0) as sl  from users where p_openid  in (" . $fie3 .
                        ")  ";

                    $sjfx = $GLOBALS['db']->getRow($sjfx);

                    $sjtoday = "select IFNULL(count(*),0) as tdsl  from users where p_openid in (" .
                        $fie3 . ") and (add_time between '" . $dt . " 00:00:00'  and  '" . $dt .
                        " 23:59:59' )";

                    $sjtoday = $GLOBALS['db']->getRow($sjtoday);


                    $wx_pay = "select IFNULL(count(*),0) as paysl  from users where p_openid in (" .
                        $fie3 . ")  and wx_pay=1";

                    $wx_pay = $GLOBALS['db']->getRow($wx_pay);


                    $sjfxarr = "select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,p_openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime from users where p_openid in (" .
                        $fie3 . ")  ";

                    $sjfxarr = $GLOBALS['db']->getAll($sjfxarr);
                }
            }

            $fcarr['fc'] = array('sl' => $sjfx['sl'] = ($sjfx['sl'] ? $sjfx['sl'] : 0),
                'tdsl' => $sjtoday['tdsl'] = ($sjtoday['tdsl'] ? $sjtoday['tdsl'] : 0), 'paysl' =>
                $wx_pay['paysl'] = ($wx_pay['paysl'] ? $wx_pay['paysl'] : 0));


            $smarty->assign('userInfo', $yjfxarr);
            $smarty->assign('fcarr', $fcarr);


        } else {
            $type = '1';
        }


        $smarty->assign('type', $type);
    }


    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $goods_list['page']);
    $smarty->display('cs/memberlist.html');


}


if ($_REQUEST['g'] == 'mlist') {


    if (isset($_REQUEST['type'])) {
        $type = trim($_REQUEST['type']);


        $u = trim($_REQUEST['u']);

        $cpage = trim($_REQUEST['cpage']);
        $cpage = $cpage - 1;
        $pagesize = trim($_REQUEST['pagesize']);


        $limit = limit_array($cpage, $pagesize);


        if ($type == '1') {

            //获取一级总数量
            $yjfx = "select IFNULL(count(*),0) as sl  from users where p_openid ='" . $openId .
                "'  ";

            $yjfx = $GLOBALS['db']->getRow($yjfx);

            $today = "select IFNULL(count(*),0) as tdsl  from users where p_openid ='" . $openId .
                "' and (add_time between '" . $dt . " 00:00:00'  and  '" . $dt . " 23:59:59' )";

            $today = $GLOBALS['db']->getRow($today);

            $wx_pay = "select IFNULL(count(*),0) as paysl  from users where p_openid ='" . $openId .
                "' and  wx_pay=1";

            $wx_pay = $GLOBALS['db']->getRow($wx_pay);


            $fcarr = array();
            $fcarr['yjfx'] = array('sl' => $yjfx['sl'], 'tdsl' => $today['tdsl']);


            //$yjfxarr="select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime from users where p_openid ='".$openId."'  ";

            $yjfxarr = "select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,p_openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime,tg_erweimaup as has_wx_code from users where p_openid ='" .
                $openId . "'   " . $limit;


            $yjfxarr = $GLOBALS['db']->getAll($yjfxarr);


            $return = $yjfxarr;


            $fcarr['fc'] = array('sl' => $yjfx['sl'], 'tdsl' => $today['tdsl'], 'paysl' => $wx_pay['paysl']);


        } elseif ($type == '2') {

            //获取一级总数量
            $yjfx = "select IFNULL(count(*),0) as sl  from users where p_openid ='" . $openId .
                "'  ";

            $yjfx = $GLOBALS['db']->getRow($yjfx);

            $today = "select IFNULL(count(*),0) as tdsl  from users where p_openid ='" . $openId .
                "' and (add_time between '" . $dt . " 00:00:00'  and  '" . $dt . " 23:59:59' )";

            $today = $GLOBALS['db']->getRow($today);


            $fcarr = array();
            $fcarr['yjfx'] = array('sl' => $yjfx['sl'], 'tdsl' => $today['tdsl']);


            //$yjfxarr="select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime from users where p_openid ='".$openId."'  ";

            $yjfxarr = "select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,p_openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime,tg_erweimaup as has_wx_code from users where p_openid ='" .
                $openId . "'  ";

            $yjfxarr = $GLOBALS['db']->getAll($yjfxarr);


            if (!empty($yjfxarr)) {


                $fie = '';

                for ($i = 0; $i < count($yjfxarr); $i++) {
                    $yh = "'";
                    $yh2 = "',";


                    //echo $yh.$yjfxarr[$i]['openid'].$yh2."<br>";

                    $fie .= $yh . $yjfxarr[$i]['openid'] . $yh2;

                }
                $fie = substr($fie, 0, -1);


                //获取二级总数量
                $ejfx = "select IFNULL(count(*),0) as sl  from users where p_openid  in (" . $fie .
                    ")  ";

                $ejfx = $GLOBALS['db']->getRow($ejfx);

                $ejtoday = "select IFNULL(count(*),0) as tdsl  from users where p_openid in (" .
                    $fie . ") and (add_time between '" . $dt . " 00:00:00'  and  '" . $dt .
                    " 23:59:59' )";

                $ejtoday = $GLOBALS['db']->getRow($ejtoday);

                $wx_pay = "select IFNULL(count(*),0) as paysl  from users where p_openid in (" .
                    $fie . ")  and wx_pay=1";

                $wx_pay = $GLOBALS['db']->getRow($wx_pay);


                $ejfxarr = "select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,p_openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime,tg_erweimaup as has_wx_code from users where p_openid in (" .
                    $fie . ")  " . $limit;

                $ejfxarr = $GLOBALS['db']->getAll($ejfxarr);
            }
            $return = $ejfxarr;


            $fcarr['fc'] = array('sl' => $ejfx['sl'] = ($ejfx['sl'] ? $ejfx['sl'] : 0),
                'tdsl' => $ejtoday['tdsl'] = ($ejtoday['tdsl'] ? $ejtoday['tdsl'] : 0), 'paysl' =>
                $wx_pay['paysl'] = ($wx_pay['paysl'] ? $wx_pay['paysl'] : 0));


        } elseif ($type == '3') {


            //获取一级总数量
            $yjfx = "select IFNULL(count(*),0) as sl  from users where p_openid ='" . $openId .
                "'  ";

            $yjfx = $GLOBALS['db']->getRow($yjfx);

            $today = "select IFNULL(count(*),0) as tdsl  from users where p_openid ='" . $openId .
                "' and (add_time between '" . $dt . " 00:00:00'  and  '" . $dt . " 23:59:59' )";

            $today = $GLOBALS['db']->getRow($today);


            $fcarr = array();
            $fcarr['yjfx'] = array('sl' => $yjfx['sl'], 'tdsl' => $today['tdsl']);


            //$yjfxarr="select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime from users where p_openid ='".$openId."'  ";

            $yjfxarr = "select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,p_openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime,tg_erweimaup as has_wx_code from users where p_openid ='" .
                $openId . "'  ";

            $yjfxarr = $GLOBALS['db']->getAll($yjfxarr);
            if (!empty($yjfxarr)) {


                $fie = '';

                for ($i = 0; $i < count($yjfxarr); $i++) {
                    $yh = "'";
                    $yh2 = "',";


                    //echo $yh.$yjfxarr[$i]['openid'].$yh2."<br>";

                    $fie .= $yh . $yjfxarr[$i]['openid'] . $yh2;

                }
                $fie = substr($fie, 0, -1);


                //获取二级总数量
                $ejfx = "select IFNULL(count(*),0) as sl  from users where p_openid  in (" . $fie .
                    ")  ";

                $ejfx = $GLOBALS['db']->getRow($ejfx);

                $ejtoday = "select IFNULL(count(*),0) as tdsl  from users where p_openid in (" .
                    $fie . ") and (add_time between '" . $dt . " 00:00:00'  and  '" . $dt .
                    " 23:59:59' )";

                $ejtoday = $GLOBALS['db']->getRow($ejtoday);

                $ejfxarr = "select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,p_openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime,tg_erweimaup as has_wx_code from users where p_openid in (" .
                    $fie . ")  ";

                $ejfxarr = $GLOBALS['db']->getAll($ejfxarr);
                if (!empty($ejfxarr)) {

                    $fie3 = '';
                    for ($i = 0; $i < count($ejfxarr); $i++) {
                        $yh = "'";
                        $yh2 = "',";


                        //echo $yh.$yjfxarr[$i]['openid'].$yh2."<br>";

                        $fie3 .= $yh . $ejfxarr[$i]['openid'] . $yh2;

                    }
                    $fie3 = substr($fie3, 0, -1);


                    //获取二级总数量
                    $sjfx = "select IFNULL(count(*),0) as sl  from users where p_openid  in (" . $fie3 .
                        ")  ";

                    $sjfx = $GLOBALS['db']->getRow($sjfx);

                    $sjtoday = "select IFNULL(count(*),0) as tdsl  from users where p_openid in (" .
                        $fie3 . ") and (add_time between '" . $dt . " 00:00:00'  and  '" . $dt .
                        " 23:59:59' )";

                    $sjtoday = $GLOBALS['db']->getRow($sjtoday);


                    $wx_pay = "select IFNULL(count(*),0) as paysl  from users where p_openid in (" .
                        $fie3 . ")  and wx_pay=1";

                    $wx_pay = $GLOBALS['db']->getRow($wx_pay);


                    $sjfxarr = "select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,p_openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime,tg_erweimaup as has_wx_code from users where p_openid in (" .
                        $fie3 . ")  " . $limit;

                    $sjfxarr = $GLOBALS['db']->getAll($sjfxarr);
                }
            }
            $return = $sjfxarr;


            $fcarr['fc'] = array('sl' => $sjfx['sl']=($sjfx['sl']?$sjfx['sl']:0), 'tdsl' => $sjtoday['tdsl']=($sjtoday['tdsl']?$sjtoday['tdsl']:0), 'paysl' =>
                $wx_pay['paysl']=($wx_pay['paysl']?$wx_pay['paysl']:0));


        }


    }


    $rarr = array();

    $rarr['results'] = $return;

    print_r(json_encode($rarr));
    //echo $sql;
}


?>