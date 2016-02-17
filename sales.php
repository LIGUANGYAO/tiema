<?php

define('IN_ECS', true);

require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/sub_sales.php');
require (dirname(__file__) . '/sub/page.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'default') {

    $list = sales($Num, "sales");
    $smarty->assign('sales_list', $list['item']);
    $smarty->assign('p_Array', $list['page']);
    $smarty->assign('fall', 'sales');
    $smarty->display('sales.tpl');
}


if ($_REQUEST['act'] == 'a_sales') {
    $bh = get_api_bhwh();
    $smarty->assign('bh', $bh['items'][0]);
    $qudao_list = get_qudao_list();
    $shop_list = get_shop_list();
    $smarty->assign('qudao_list', $qudao_list['items']);
    $smarty->assign('shop_list', $shop_list['items']);
    $smarty->assign('fall', 'a_sales');
    $smarty->display('sales.tpl');
}


if ($_REQUEST['act'] == 'checksales') {

    require (dirname(__file__) . '/sub/rest.php');
    if (isset($_REQUEST['qrcid'])) {
        $qrcid = trim($_REQUEST['qrcid']);
    }
    $sql_11 = "select * from sales where qrcid='" . $qrcid . "'";
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


if ($_REQUEST['act'] == 'list') {

    $bigid = $_GET["b_id"];
    // print_r($bigid);
    if (isset($bigid)) {
        $q = mysql_query("select * from shop where p_id = '" . $bigid . "'");

        while ($row = mysql_fetch_array($q)) {
            $select[] = array("shop_sn" => $row[shop_sn], "shop_name" => $row[shop_name]);
        }
        echo json_encode($select);
    }
}


if ($_REQUEST['act'] == 'e_sales') {


    if (isset($_REQUEST['edit'])) {
        $code = urldecode(trim($_REQUEST['edit']));
        //$q_list=get_qudao_mx($list['items'][0]['p_id']);
        $list = get_sales_mx($code);
        $s_list = get_shop_mx($list['items'][0]['p_id']);
        $q_list = get_qudao_mx($s_list['items'][0]['p_id']);
        $qudao_list = get_qudao_list();
        $smarty->assign('sales', $list['items'][0]);
        $smarty->assign('s_list', $s_list['items'][0]);
        $smarty->assign('q_list', $q_list['items'][0]);
        $smarty->assign('qudao_list', $qudao_list['items']);
        $smarty->assign('fall', 'e_sales');
        $smarty->display('sales.tpl');
    }

}

if ($_REQUEST['act'] == 'post') {


    $open = $_REQUEST['open'];
    $oppoint = $_REQUEST['oppoint'];
    $sales_sn = $_REQUEST['sales_sn'];
    set_point($open, $oppoint, $sales_sn);


    //修改3，更新语句
    $time_field = array( //array("type"=>"2","field"=>"add_time","method"=>"1"),
            array(
            "type" => "1",
            "field" => "last_update_2",
            "method" => "2"));
    //print_r($time_field);exit;
    update_sales_mx("sales", "sales_name,sales_type,qrcid,p_id,tzsy,b_id",
        "sales_sn", $time_field);

    $smarty->assign('fall', 'i_staus');
    $smarty->assign('val', '修改成功');
    $smarty->display('sales.tpl');
}


if ($_REQUEST['act'] == 'i_sales') {


    $open = $_REQUEST['open'];
    $oppoint = $_REQUEST['oppoint'];
    $sales_sn = $_REQUEST['sales_sn'];
    set_point($open, $oppoint, $sales_sn);


    if (isset($_REQUEST['sales_sn'])) {
        $sales_sn = trim($_REQUEST['sales_sn']);
    }
    if (isset($_REQUEST['sales_name'])) {
        $sales_name = trim($_REQUEST['sales_name']);
    }
    if (isset($_REQUEST['sales_type'])) {
        $sales_type = trim($_REQUEST['sales_type']);
    }
    if (isset($_REQUEST['qrcid'])) {
        $qrcid = trim($_REQUEST['qrcid']);
    }
    if (isset($_REQUEST['p_id'])) {
        $p_id = trim($_REQUEST['p_id']);
    }
    if (isset($_REQUEST['b_id'])) {
        $b_id = trim($_REQUEST['b_id']);
    }

    $time = date('Y-m-d H:i:s', time());
    $last_update_2 = date('Y-m-d', time());
    $get_one = " select sales_sn from sales where sales_sn='" . $sales_sn . "'";
    $res = $GLOBALS['db']->getRow($get_one);
    if (empty($res)) {
        //       $time_field = array(array(
        //                "type" => "2",
        //                "field" => "add_time",
        //                "method" => "1"), // array("type"=>"2","field"=>"last_update","method"=>"2"),
        //                //array("type"=>"1","field"=>"last_update_2","method"=>"2")
        //            );
        //        i_sales("sales", "sales_sn,sales_name,sales_type,qrcid,p_id,tzsy", $time_field);
        $tk = new getArr();
        $access_token = $tk->getToken();
        $qrcode = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id":' .
            $qrcid . '}}}';
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
        $result = https_post($url, $qrcode);
        $jsoninfo = json_decode($result, true);
        $ticket = $jsoninfo["ticket"];
        $sql = "insert into sales(sales_sn,sales_name,sales_type,qrcid,p_id,ticket,add_time,last_update_2,b_id) values('" .
            $sales_sn . "','" . $sales_name . "','" . $sales_type . "','" . $qrcid . "','" .
            $p_id . "','" . $ticket . "','" . $time . "','" . $last_update_2 . "','" . $b_id . "')";
        $res = $GLOBALS['db']->query($sql);
        update_api_bhwh();

        $smarty->assign('fall', 'i_staus');
        $smarty->assign('val', '添加成功');
        $smarty->display('sales.tpl');
    } else {
        $smarty->assign('fall', 'i_staus');
        $smarty->assign('val', '代码已经存在,请重新输入');
        $smarty->display('sales.tpl');
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
        $local_file = fopen('upload/cj_qrcode/sales/' . $filename, 'w');
        if (false !== $local_file) {
            if (false !== fwrite($local_file, $imageInfo["body"])) {
                fclose($local_file);
            }
        }
    }
    //print_r($filename);
    $smarty->assign('fall', 'view');
    $smarty->assign('val', $filename);
    $smarty->display('sales.tpl');


}

//禁用启用删除等操作

if ($_REQUEST['act'] == 'ed_status') {

    if (isset($_REQUEST['qiyong'])) {
        $code = urldecode(trim($_REQUEST['qiyong']));

        $sql = "update sales set tzsy=0 where  sales_sn= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "启用成功";
    } else {

    }


    if (isset($_REQUEST['jinyong'])) {
        $code = urldecode(trim($_REQUEST['jinyong']));
        $sql = "update sales set tzsy=1 where  sales_sn= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "禁用成功";
    } else {

    }

    if (isset($_REQUEST['delete'])) {
        $code = urldecode(trim($_REQUEST['delete']));


        //判断是否存在记录否则不能删除
        $is_use = "select openid from cj_qrcode_stat where cj_type='sales' and cj_sn='" .
            $code . "'";
        $is_use = $GLOBALS['db']->getRow($is_use);

        if (empty($is_use)) {
            $sql = "delete from  sales where  sales_sn= '" . $code . "'";
            $res = $GLOBALS['db']->query($sql);


            //删除推广信息
            $sql = "delete from  tgpoint where  p_id= '" . $code . "' and p_type=3";
            $res = $GLOBALS['db']->query($sql);
            echo "删除成功";
        } else {
            echo "已经产生相关信息,无法删除,禁用该条记录";

        }


    } else {

    }
}


//开始选择关注者信息
if ($_REQUEST['act'] == 'select_openid') {
    $smarty->assign('type', 1);
    $smarty->display('sales_s_openid.tpl');
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
?>
