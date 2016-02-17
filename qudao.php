<?php

define('IN_ECS', true);

require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/sub_qudao.php');
require (dirname(__file__) . '/sub/page.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'default') {

    $list = qudao($Num, "qudao");
    $smarty->assign('qudao_list', $list['item']);
    $smarty->assign('p_Array', $list['page']);
    $smarty->assign('fall', 'qudao');


    // print_r($list);

    $smarty->display('qudao.tpl');
}


if ($_REQUEST['act'] == 'a_qudao') {

    $bh = get_api_bhwh();
    $smarty->assign('bh', $bh['items'][0]);
    $smarty->assign('fall', 'a_qudao');
    $smarty->display('qudao.tpl');
}

if ($_REQUEST['act'] == 'checkqudao') {

    require (dirname(__file__) . '/sub/rest.php');
    if (isset($_REQUEST['qrcid'])) {
        $qrcid = trim($_REQUEST['qrcid']);
    }
    $sql_11 = "select * from qudao where qrcid='" . $qrcid . "'";
    $opq = $GLOBALS['db']->query($sql_11);
    if (is_array(mysql_fetch_array($opq))) {
        $userinfo = array(
            "msg" => "已存在",
            "success" => true,
            "check" => '1');
        $aaa = new arraytojson();
        $json = $aaa->JSON($userinfo);
        print_r($json);
    } else {
        $userinfo = array(
            "msg" => "可使用",
            "success" => true,
            "check" => '0');
        $aaa = new arraytojson();
        $json = $aaa->JSON($userinfo);
        print_r($json);
    }
}


if ($_REQUEST['act'] == 'e_qudao') {


    if (isset($_REQUEST['edit'])) {
        $code = urldecode(trim($_REQUEST['edit']));
        $list = get_qudao_mx($code);
        //print_r($list);
        $smarty->assign('qudao', $list['items'][0]);
        $smarty->assign('fall', 'e_qudao');
        $smarty->display('qudao.tpl');
    }


}

if ($_REQUEST['act'] == 'post') {


    $open = $_REQUEST['open'];
    $oppoint = $_REQUEST['oppoint'];
    $qudao_sn = $_REQUEST['qudao_sn'];
    set_point($open, $oppoint, $qudao_sn);


    //修改3，更新语句
    $time_field = array( //array("type"=>"2","field"=>"add_time","method"=>"1"),
            array(
            "type" => "1",
            "field" => "last_update_2",
            "method" => "2"));
    //print_r($time_field);exit;
    update_qudao_mx("qudao", "qudao_name,qudao_type,qrcid,p_id,tzsy,sdpoint,dgpoint",
        "qudao_sn", $time_field);

    $smarty->assign('fall', 'i_staus');
    $smarty->assign('val', '修改成功');
    $smarty->display('qudao.tpl');
}


if ($_REQUEST['act'] == 'i_qudao') {


    $open = $_REQUEST['open'];
    $oppoint = $_REQUEST['oppoint'];
    $qudao_sn = $_REQUEST['qudao_sn'];
    set_point($open, $oppoint, $qudao_sn);


    if (isset($_REQUEST['qudao_sn'])) {
        $qudao_sn = trim($_REQUEST['qudao_sn']);
    }
    if (isset($_REQUEST['qudao_name'])) {
        $qudao_name = trim($_REQUEST['qudao_name']);
    }
    if (isset($_REQUEST['qudao_type'])) {
        $qudao_type = trim($_REQUEST['qudao_type']);
    }
    if (isset($_REQUEST['qrcid'])) {
        $qrcid = trim($_REQUEST['qrcid']);
    }
    if (isset($_REQUEST['p_id'])) {
        $p_id = trim($_REQUEST['p_id']);
    }

    if (isset($_REQUEST['sdpoint'])) {
        $sdpoint = trim($_REQUEST['sdpoint']);
    }
    if (isset($_REQUEST['dgpoint'])) {
        $dgpoint = trim($_REQUEST['dgpoint']);
    }

    $time = date('Y-m-d H:i:s', time());
    $last_update_2 = date('Y-m-d', time());
    $get_one = " select qudao_sn from qudao where qudao_sn='" . $qudao_sn . "'";
    $res = $GLOBALS['db']->getRow($get_one);
    if (empty($res)) {

        //    $time_field = array(array(
        //                "type" => "2",
        //                "field" => "add_time",
        //                "method" => "1"),
        //            );
        //        i_qudao("qudao", "qudao_sn,qudao_name,qudao_type,qrcid,p_id,tzsy", $time_field);
        $tk = new getArr();
        $access_token = $tk->getToken();
        $qrcode = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id":' .
            $qrcid . '}}}';
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
        $result = https_post($url, $qrcode);
        $jsoninfo = json_decode($result, true);
        $ticket = $jsoninfo["ticket"];
        $sql = "insert into qudao(qudao_sn,qudao_name,qudao_type,qrcid,p_id,ticket,add_time,last_update_2,sdpoint,dgpoint) values('" .
            $qudao_sn . "','" . $qudao_name . "','" . $qudao_type . "','" . $qrcid . "','" .
            $p_id . "','" . $ticket . "','" . $time . "','" . $last_update_2 . "','" . $sdpoint .
            "','" . $dgpoint . "')";
        $res = $GLOBALS['db']->query($sql);
        update_api_bhwh();

        $smarty->assign('fall', 'i_staus');
        $smarty->assign('val', '添加成功');
        $smarty->display('qudao.tpl');
    } else {
        $smarty->assign('fall', 'i_staus');
        $smarty->assign('val', '代码已经存在,请重新输入');
        $smarty->display('qudao.tpl');
    }


}

//查看二维码

if ($_REQUEST['act'] == 'view_qrcode') {

    if (isset($_REQUEST['ticket'])) {
        $ticket = trim($_REQUEST['ticket']);
    }

    if (!empty($ticket)) {

        $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode($ticket);
        $imageInfo = downloadImageFromWeiXin($url);
        $qrcodename = md5($ticket);
        $filename = $qrcodename . ".jpg";
        $local_file = fopen('upload/cj_qrcode/qudao/' . $filename, 'w');
        if (false !== $local_file) {
            if (false !== fwrite($local_file, $imageInfo["body"])) {
                fclose($local_file);
            }
        }
    }
    //print_r($filename);
    $smarty->assign('fall', 'view');
    $smarty->assign('val', $filename);
    $smarty->display('qudao.tpl');


}


//禁用启用删除等操作

if ($_REQUEST['act'] == 'ed_status') {

    if (isset($_REQUEST['qiyong'])) {
        $code = urldecode(trim($_REQUEST['qiyong']));

        $sql = "update qudao set tzsy=0 where  qudao_sn= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "启用成功";
    } else {

    }


    if (isset($_REQUEST['jinyong'])) {
        $code = urldecode(trim($_REQUEST['jinyong']));
        $sql = "update qudao set tzsy=1 where  qudao_sn= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "禁用成功";
    } else {

    }


    if (isset($_REQUEST['delete'])) {
        $code = urldecode(trim($_REQUEST['delete']));
        
        //判断是否存在记录否则不能删除
        $is_use="select openid from cj_qrcode_stat where cj_type='qudao' and cj_sn='".$code."'";
        $is_use = $GLOBALS['db']->getRow($is_use);
        
        if(empty($is_use))
        {
           $sql = "delete from  qudao where  qudao_sn= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        
        
        //删除推广信息
            $sql = "delete from  tgpoint where  p_id= '" . $code . "' and p_type=1";
            $res = $GLOBALS['db']->query($sql);
            echo "删除成功";  
        }
        else
        {
            echo "已经产生相关信息,无法删除,禁用该条记录";
            
        }
       
    } else {

    }
}


//开始选择关注者信息
if ($_REQUEST['act'] == 'select_openid') {
    $smarty->assign('type', 1);
    $smarty->display('qudao_s_openid.tpl');
}


if ($_REQUEST['act'] == 'ysss') {

    require (dirname(__file__) . '/sub/rest.php');

    if (isset($_REQUEST['type'])) {
        $type = $_REQUEST['type'];
    }

    if (!empty($_REQUEST['s'])) {
        $aaa = $_REQUEST['s'];

    }


    if (isset($_REQUEST['keyword'])) {

        $keyword = urldecode($_REQUEST['keyword']);
        //print_r($keyword);exit;
        if ($keyword != '') {
            $keyword = urldecode($_REQUEST['keyword']);
            $q1 = "select openid,users_sn as dm,nick_name as mc  from users where users_sn  like '%" .
                $keyword . "%'  or nick_name  like '%" . $keyword . "%'   or wx_tel  like '%" .
                $keyword . "%'";
            $res = $GLOBALS['db']->getAll($q1);
        } else {
            $res = array();
        }


    }
    //print_r($q1);
    // exit;
    //$sql="select color_sn,color_name from color ";

    $aaa = new arraytojson();
    $json = $aaa->JSON($res);
    print_r($json);
}


//设置渠道店铺反馈给上级的比例
if ($_REQUEST['act'] == 'set_s_fc') {


    if (isset($_REQUEST['qudao'])) {

        $qudao = trim($_REQUEST['qudao']);
        $qudao_name = trim($_REQUEST['qudao_name']);
        //开始创建记录tgpoint_shop字段
        function tgpoint_shop($p_id)
        {
            $t1 = date('Y-m-d H:i:s', time());

            $sql = "select shop_sn from shop where p_id='" . $p_id . "' order by id desc";
            $res = $GLOBALS['db']->getAll($sql);


            for ($i = 0; $i < count($res); $i++) {


                $q = "select shop_sn from tgpoint_shop where  p_id='" . $p_id .
                    "'  and shop_sn ='" . $res[$i]['shop_sn'] . "'";
                $q = $GLOBALS['db']->getRow($q);

                //如果不存在记录插入，否则不管
                if (empty($q)) {
                    $qi = "insert into tgpoint_shop(p_id,shop_sn,add_time) values ('" . $p_id .
                        "','" . $res[$i]['shop_sn'] . "','" . $t1 . "')";
                    $qi = $GLOBALS['db']->query($qi);
                }


                //拼凑店铺代码
                $d1 = "'";
                $d2 = "',";
                if ($i == count($res) - 1) {
                    $d2 = "'";
                }
                $sn .= $d1 . $res[$i]['shop_sn'] . $d2;

            }
            
            
            if(empty($sn))
                {
                    $fil='';
                }
                else
                {
                    $fil="and  shop_sn not in (" . $sn . ")";
                }


            $de = "delete from tgpoint_shop where  p_id='" . $p_id .
                "'    ".$fil;
            $de = $GLOBALS['db']->query($de);

        }
        tgpoint_shop($qudao);


        //开始取出所有所属渠道的商店
        function getshop_list($obj)
        {
            $sql = "select a.shop_sn,a.shop_name,a.shop_address,b.region_name as province,c.region_name as city,d.region_name as district from shop a left join region b on a.province=b.id left join region c on a.city=c.id left join region d on a.district=d.id where a.tzsy=0 and a.p_id='" .
                $obj . "' order by a.id desc ";
            $res = $GLOBALS['db']->getAll($sql);

            $sd_point = "select sdpoint from qudao where qudao_sn='" . $obj . "'";
            $sd_point = $GLOBALS['db']->getRow($sd_point);
            // print_r($sd_point);
            //获取所属店铺的具体反馈比例
            for ($i = 0; $i < count($res); $i++) {

                $q = "select p_id,shop_sn,point from tgpoint_shop where  p_id='" . $obj .
                    "'  and shop_sn ='" . $res[$i]['shop_sn'] . "'";


                $ttg = $GLOBALS['db']->getRow($q);

                if ((int)$ttg['point'] == 0) {

                    $ttg['point'] = $sd_point['sdpoint'];
                } elseif ($ttg['point'] == $sd_point['sdpoint']) {
                    $ttg['point'] = $sd_point['sdpoint'];
                }
                $res[$i]['tg'] = $ttg;


            }

            return $res;
        }

        $shop_list = getshop_list($qudao);


        $smarty->assign('qudao_name', $qudao_name);
        //print_r($shop_list);
        $smarty->assign('qudao', $qudao);
        $smarty->assign('shop_list', $shop_list);
        $smarty->display('set_s_fc.tpl');
    }

}


if ($_REQUEST['act'] == 'set_sdmx') {
    //判断是批量还是个别
    if ($_REQUEST['tp'] == 1) {
        $qudao = $_REQUEST['qudao'];
        $tgpoint = $_REQUEST['tgpoint'];
        function upall_point($qd, $tg)
        {
            $sql = "update tgpoint_shop set point='" . $tg . "' where p_id='" . $qd . "' ";
            $res = $GLOBALS['db']->query($sql);


        }
        upall_point($qudao, $tgpoint);
    } elseif ($_REQUEST['tp'] == 2) {
        $shop_sn = $_REQUEST['shop_sn'];
        $qudao = $_REQUEST['qudao'];
        $tgpoint = $_REQUEST['tgpoint'];

        function upshop_point($qd, $ss, $tg)
        {
            $sql = "update tgpoint_shop set point='" . $tg . "' where p_id='" . $qd .
                "' and shop_sn='" . $ss . "'";
            $res = $GLOBALS['db']->query($sql);
            //print_r($sql);
            $get = "select point from tgpoint_shop  where p_id='" . $qd . "' and shop_sn='" .
                $ss . "'";
            $get = $GLOBALS['db']->getRow($get);

            return $get['point'];
        }
        $dat = upshop_point($qudao, $shop_sn, $tgpoint);
        echo $dat;
        //echo $shop_sn."/".$qudao;
    }

}


//设置渠道店铺下级的导购分成上级

if ($_REQUEST['act'] == 'set_sales') {


    if (isset($_REQUEST['qudao'])) {

        $qudao = trim($_REQUEST['qudao']);
        $qudao_name = trim($_REQUEST['qudao_name']);
        //开始创建记录tgpoint_shop字段
        function tgpoint_sales($p_id)
        {
            $t1 = date('Y-m-d H:i:s', time());

            $sql = "select shop_sn from shop where p_id='" . $p_id . "' order by id desc";
            $res = $GLOBALS['db']->getAll($sql);
            for ($i = 0; $i < count($res); $i++) {
                $q = "select shop_sn from tgpoint_shop where  p_id='" . $p_id .
                    "'  and shop_sn ='" . $res[$i]['shop_sn'] . "'";
                $q = $GLOBALS['db']->getRow($q);

                //如果不存在记录插入，否则不管
                if (empty($q)) {
                    $qi = "insert into tgpoint_shop(p_id,shop_sn,add_time) values ('" . $p_id .
                        "','" . $res[$i]['shop_sn'] . "','" . $t1 . "')";
                    $qi = $GLOBALS['db']->query($qi);
                }

                //开始插入导购记录

                $g_sales = "select b_id,p_id,sales_sn from sales where p_id='" . $res[$i]['shop_sn'] .
                    "' and b_id='" . $p_id . "' order by id desc";
                $g_sales = $GLOBALS['db']->getAll($g_sales);

                for ($k = 0; $k < count($g_sales); $k++) {
                    $q2 = "select sales_sn from tgpoint_sales where  b_id='" . $p_id .
                        "'  and p_id ='" . $res[$i]['shop_sn'] . "' and sales_sn='" . $g_sales[$k]['sales_sn'] .
                        "'";
                    $q2 = $GLOBALS['db']->getRow($q2);

                    //如果不存在记录插入，否则不管
                    if (empty($q2)) {
                        $qi2 = "insert into tgpoint_sales(b_id,p_id,sales_sn,add_time) values ('" . $p_id .
                            "','" . $res[$i]['shop_sn'] . "','" . $g_sales[$k]['sales_sn'] . "','" . $t1 .
                            "')";
                        $qi2 = $GLOBALS['db']->query($qi2);
                    }

                    //拼凑店铺代码
                    $d1 = "'";
                    $d2 = "',";
                    if ($k == count($g_sales) -1) {
                        $d2 = "'";
                    }
                    $sn .= $d1 . $g_sales[$k]['sales_sn'] . $d2;

                }
                
                if(empty($sn))
                {
                    $fil='';
                }
                else
                {
                    $fil="and  sales_sn not in (" . $sn . ")";
                }

                $de = "delete from tgpoint_sales where  b_id='" . $p_id .
                    "' and p_id='".$res[$i]['shop_sn']."' ".$fil;
                   
                $de = $GLOBALS['db']->query($de);
                $sn='';

            }


        }
        tgpoint_sales($qudao);


        //开始取出所有所属渠道的导购
        function getsales_list($obj)
        {

            $sql2 = "select a.shop_sn,a.shop_name,a.shop_address,b.region_name as province,c.region_name as city,d.region_name as district from shop a left join region b on a.province=b.id left join region c on a.city=c.id left join region d on a.district=d.id where a.tzsy=0 and a.p_id='" .
                $obj . "' order by a.id desc ";
            $res2 = $GLOBALS['db']->getAll($sql2);


            for ($j = 0; $j < count($res2); $j++) {

                $sql = "select a.sales_sn,a.sales_name from sales a  where a.tzsy=0 and a.p_id='" .
                    $res2[$j]['shop_sn'] . "' order by a.id desc ";
                $res = $GLOBALS['db']->getAll($sql);

                $dgpoint = "select dgpoint from qudao where qudao_sn='" . $obj . "'";
                $dgpoint = $GLOBALS['db']->getRow($dgpoint);
                // print_r($dgpoint);
                //获取所属店铺的具体反馈比例
                for ($i = 0; $i < count($res); $i++) {

                    $q = "select p_id,sales_sn,point from tgpoint_sales where  p_id='" . $res2[$j]['shop_sn'] .
                        "'  and sales_sn ='" . $res[$i]['sales_sn'] . "'";


                    $ttg = $GLOBALS['db']->getRow($q);

                    if ((int)$ttg['point'] == 0) {

                        $ttg['point'] = $dgpoint['dgpoint'];
                    } elseif ($ttg['point'] == $dgpoint['dgpoint']) {
                        $ttg['point'] = $dgpoint['dgpoint'];
                    }
                    $res[$i]['tg'] = $ttg;


                }

                //拼凑
                $res2[$j]['sales'] = $res;

            }


            return $res2;
        }

        $sales_list = getsales_list($qudao);


        $smarty->assign('qudao_name', $qudao_name);
        //print_r($sales_list);
        $smarty->assign('qudao', $qudao);
        $smarty->assign('sales_list', $sales_list);
        $smarty->display('set_sales.tpl');
    }

}


if ($_REQUEST['act'] == 'set_salesmx') {


    //判断是批量还是个别
    if ($_REQUEST['tp'] == 1) {
        $qudao = $_REQUEST['qudao'];
        $tgpoint = $_REQUEST['tgpoint'];
        function upall_point($qd, $tg)
        {
            $sql = "update tgpoint_sales set point='" . $tg . "' where b_id='" . $qd . "' ";
            $res = $GLOBALS['db']->query($sql);


        }
        upall_point($qudao, $tgpoint);
    } elseif ($_REQUEST['tp'] == 2) {
        $sales_sn = $_REQUEST['sales_sn'];
        $shop_sn = $_REQUEST['shop_sn'];
        $qudao = $_REQUEST['qudao'];
        $tgpoint = $_REQUEST['tgpoint'];

        function upshop_point($qd, $ss, $sa, $tg)
        {
            $sql = "update tgpoint_sales set point='" . $tg . "' where b_id='" . $qd .
                "' and p_id='" . $ss . "' and sales_sn='" . $sa . "'";
            $res = $GLOBALS['db']->query($sql);
            //print_r($sql);
            $get = "select point from tgpoint_sales  where b_id='" . $qd . "' and p_id='" .
                $ss . "' and sales_sn='" . $sa . "'";
            $get = $GLOBALS['db']->getRow($get);

            return $get['point'];
        }
        $dat = upshop_point($qudao, $shop_sn, $sales_sn, $tgpoint);
        echo $dat;
        //echo $shop_sn."/".$qudao;
    }

}
?>
