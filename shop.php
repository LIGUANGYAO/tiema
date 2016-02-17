<?php

define('IN_ECS', true);

require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/sub_shop.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_get_region.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'default') {
    $list = shop($Num, "shop");
    //print_r($list['item']);
    $smarty->assign('shop_list', $list['item']);
    $smarty->assign('p_Array', $list['page']);
    $smarty->assign('fall', 'shop');
    $smarty->display('shop.tpl');
}


if ($_REQUEST['act'] == 'a_shop') {
    $bh = get_api_bhwh();
    $smarty->assign('bh', $bh['items'][0]);
    $qudao_list = get_qudao_list();


    //tianjia 添加省市区
    $region = get_region2($list['items'][0]['province'], $list['items'][0]['city'],
        $list['items'][0]['district']);
    //print_r($region);
    $smarty->assign('region', $region);

    //
    $smarty->assign('qudao_list', $qudao_list['items']);
    $smarty->assign('fall', 'a_shop');
    $smarty->display('shop.tpl');
}


if ($_REQUEST['act'] == 'list') {
    $bigid = $_GET["b_id"];
    if (isset($bigid)) {
        $q = mysql_query("select * from qudao where qudao_type = '" . $bigid . "'");
        while ($row = mysql_fetch_array($q)) {
            $select[] = array("qudao_sn" => $row[qudao_sn], "qudao_name" => $row[qudao_name]);
        }
        echo json_encode($select);
    }
}
//////////////////////////////////


//////////////////////////////////
if ($_REQUEST['act'] == 'checkshop') {

    require (dirname(__file__) . '/sub/rest.php');
    if (isset($_REQUEST['qrcid'])) {
        $qrcid = trim($_REQUEST['qrcid']);
    }
    $sql_11 = "select * from shop where qrcid='" . $qrcid . "'";
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


if ($_REQUEST['act'] == 'e_shop') {


    if (isset($_REQUEST['edit'])) {


        $code =urldecode(trim($_REQUEST['edit'])) ;
        $list = get_shop_mx($code);

        //print_r($list);


        $region = get_region2($list['items'][0]['province'], $list['items'][0]['city'],
            $list['items'][0]['district']);


        $list['items'][0]['region'] = $region;


        $list['items'][0]['qs'] = get_qs($list['items'][0]['b_id'], $list['items'][0]['p_id']);
        // print_r($list);
        //print_r($q_list['items'][0]);
        $smarty->assign('shop', $list['items'][0]);
        $smarty->assign('q_list', $q_list['items'][0]);


        $smarty->assign('fall', 'e_shop');
        $smarty->display('shop.tpl');
    }

}

if ($_REQUEST['act'] == 'post') {


    // if(isset($_REQUEST['open']) && isset($_REQUEST['oppoint']))
    //    {
    $open = $_REQUEST['open'];
    $oppoint = $_REQUEST['oppoint'];
    $shop_sn = $_REQUEST['shop_sn'];

    set_point($open, $oppoint, $shop_sn);

    // }
    //exit;


    //修改3，更新语句
    $time_field = array( //array("type"=>"2","field"=>"add_time","method"=>"1"),
            array(
            "type" => "1",
            "field" => "last_update_2",
            "method" => "2"));
    //print_r($time_field);exit;
    update_shop_mx("shop",
        "shop_name,shop_type,qrcid,province,city,district,shop_address,shop_lxr,lbsaddress,lbsjd,lbswd,p_id,tzsy,b_id,dgpoint",
        "shop_sn", $time_field);

    $smarty->assign('fall', 'i_staus');
    $smarty->assign('val', '修改成功');
    $smarty->display('shop.tpl');
}


if ($_REQUEST['act'] == 'i_shop') {


    $open = $_REQUEST['open'];
    $oppoint = $_REQUEST['oppoint'];
    $shop_sn = $_REQUEST['shop_sn'];
    set_point($open, $oppoint, $shop_sn);


    if (isset($_REQUEST['shop_sn'])) {
        $shop_sn = trim($_REQUEST['shop_sn']);
    }
    if (isset($_REQUEST['shop_name'])) {
        $shop_name = trim($_REQUEST['shop_name']);
    }
    if (isset($_REQUEST['shop_type'])) {
        $shop_type = trim($_REQUEST['shop_type']);
    }
    if (isset($_REQUEST['qrcid'])) {
        $qrcid = trim($_REQUEST['qrcid']);
    }
    if (isset($_REQUEST['p_id'])) {
        $p_id = trim($_REQUEST['p_id']);
    }

    if (isset($_REQUEST['shop_province'])) {
        $shop_province = trim($_REQUEST['shop_province']);
    }
    if (isset($_REQUEST['shop_city'])) {
        $shop_city = trim($_REQUEST['shop_city']);
    }
    if (isset($_REQUEST['shop_district'])) {
        $shop_district = trim($_REQUEST['shop_district']);
    }
    if (isset($_REQUEST['shop_address'])) {
        $shop_address = trim($_REQUEST['shop_address']);
    }

    if (isset($_REQUEST['shop_lxr'])) {
        $shop_lxr = trim($_REQUEST['shop_lxr']);
    }

    if (isset($_REQUEST['lbsaddress'])) {
        $lbsaddress = trim($_REQUEST['lbsaddress']);
    }
    if (isset($_REQUEST['lbsjd'])) {
        $lbsjd = trim($_REQUEST['lbsjd']);
    }
    if (isset($_REQUEST['lbswd'])) {
        $lbswd = trim($_REQUEST['lbswd']);
    }
    if (isset($_REQUEST['b_id'])) {
        $b_id = trim($_REQUEST['b_id']);
    }

    if (isset($_REQUEST['dgpoint'])) {
        $dgpoint = trim($_REQUEST['dgpoint']);
    }

    $time = date('Y-m-d H:i:s', time());
    $last_update_2 = date('Y-m-d', time());
    $get_one = " select shop_sn from shop where shop_sn='" . $shop_sn . "'";
    $res = $GLOBALS['db']->getRow($get_one);
    if (empty($res)) {
        //  $time_field = array(array(
        //                "type" => "2",
        //                "field" => "add_time",
        //                "method" => "1"), // array("type"=>"2","field"=>"last_update","method"=>"2"),
        //                //array("type"=>"1","field"=>"last_update_2","method"=>"2")
        //            );
        //        i_shop("shop", "shop_sn,shop_name,shop_type,qrcid,p_id,tzsy", $time_field);
        $tk = new getArr();
        $access_token = $tk->getToken();
        $qrcode = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id":' .
            $qrcid . '}}}';
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
        $result = https_post($url, $qrcode);
        $jsoninfo = json_decode($result, true);
        $ticket = $jsoninfo["ticket"];
        $sql = "insert into shop(shop_sn,shop_name,shop_type,qrcid,p_id,ticket,province,city,district,shop_address,shop_lxr,lbsaddress,lbsjd,lbswd,add_time,last_update_2,b_id,dgpoint) values('" .
            $shop_sn . "','" . $shop_name . "','" . $shop_type . "','" . $qrcid . "','" . $p_id .
            "','" . $ticket . "','" . $shop_province . "','" . $shop_city . "','" . $shop_district .
            "','" . $shop_address . "','" . $shop_lxr . "','" . $lbsaddress . "','" . $lbsjd .
            "','" . $lbswd . "','" . $time . "','" . $last_update_2 . "','" . $b_id . "','" .
            $dgpoint . "')";
        $res = $GLOBALS['db']->query($sql);
        update_api_bhwh();


        $smarty->assign('fall', 'i_staus');
        $smarty->assign('val', '添加成功');
        $smarty->display('shop.tpl');
    } else {
        $smarty->assign('fall', 'i_staus');
        $smarty->assign('val', '代码已经存在,请重新输入');
        $smarty->display('shop.tpl');
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
        $local_file = fopen('upload/cj_qrcode/shop/' . $filename, 'w');
        if (false !== $local_file) {
            if (false !== fwrite($local_file, $imageInfo["body"])) {
                fclose($local_file);
            }
        }
    }
    //print_r($filename);
    $smarty->assign('fall', 'view');
    $smarty->assign('val', $filename);
    $smarty->display('shop.tpl');


}

//批量生成二维码

//if ($_REQUEST['act'] == 'sc_code') {
//    $sql="select shop_sn,shop_name,ticket from shop";
//     $res = $GLOBALS['db']->getAll($sql);
//     $list = $res;
//     for ($i = 0; $i < count($list); $i++) {
//     $code=$list[$i]['shop_sn'];
//     $ticket=$list[$i]['ticket'];
//     if(!empty($ticket)){
//     $url = "https:mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($ticket);
//     $imageInfo = downloadImageFromWeiXin($url);
//     $qrcodename=$code;
//     $filename = $qrcodename.".jpg";
//     $filepath="upload/cj_qrcode/shop/".$filename;
//     $local_file = fopen('upload/cj_qrcode/shop/'.$filename, 'w');
//     if (false !== $local_file){
//     if (false !== fwrite($local_file, $imageInfo["body"])) {
//     fclose($local_file);
//        }
//     }
//     $sql1 = "update shop set shop_qy='".$filepath."' where  shop_sn= '" . $code . "'";
//     $res1 = $GLOBALS['db']->query($sql1);
//    }
//    }
//}


//禁用启用删除等操作

if ($_REQUEST['act'] == 'ed_status') {

    if (isset($_REQUEST['qiyong'])) {
        $code = urldecode(trim($_REQUEST['qiyong']));

        $sql = "update shop set tzsy=0 where  shop_sn= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "启用成功";
    } else {

    }


    if (isset($_REQUEST['jinyong'])) {
        $code = urldecode(trim($_REQUEST['jinyong']));
        $sql = "update shop set tzsy=1 where  shop_sn= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "禁用成功";
    } else {

    }


    if (isset($_REQUEST['de1'])) {
        $code = urldecode(trim($_REQUEST['de1']));


        //判断是否存在记录否则不能删除
        $is_use = "select openid from cj_qrcode_stat where cj_type='shop' and cj_sn='" .
            $code . "'";
        $is_use = $GLOBALS['db']->getRow($is_use);

        if (empty($is_use)) {
            $sql = "delete from  shop where  shop_sn= '" . $code . "'";
            $res = $GLOBALS['db']->query($sql);

            //删除推广信息
            $sql = "delete from  tgpoint where  p_id= '" . $code . "' and p_type=2";
            $res = $GLOBALS['db']->query($sql);
            echo "删除成功";
        } else {
            echo "已经产生相关信息,无法删除,禁用该条记录";

        }


    } else {

    }
}


if ($_REQUEST['act'] == 'get_city') {

    //echo 1;exit;
    //if(isset($_REQUEST['province'])){
    require (dirname(__file__) . '/sub/rest.php');
    $province = urldecode($_REQUEST['province']);

    $sql2 = "select region_sn,region_name
     from region where region_type='2' and p_id='" . $province . "';";
    $city = $GLOBALS['db']->getAll($sql2);
    //$city=get_city($province);
    //echo $sql2;exit;

    //}
    // echo $sql2;exit;
    //$sql="select color_sn,color_name from color ";
    //$res = $GLOBALS['db']->getAll($sql);
    $aaa = new arraytojson();
    $json = $aaa->JSON($city);

    print_r($json);
}

if ($_REQUEST['act'] == 'get_district') {

    //echo 1;exit;
    //if(isset($_REQUEST['province'])){
    require (dirname(__file__) . '/sub/rest.php');
    $city = urldecode($_REQUEST['city']);

    $sql3 = "select region_sn,region_name
     from region where region_type='3' and p_id='" . $city . "';";
    $district = $GLOBALS['db']->getAll($sql3);

    $aaa = new arraytojson();
    $json = $aaa->JSON($district);

    print_r($json);
}


//开始选择关注者信息
if ($_REQUEST['act'] == 'select_openid') {
    $smarty->assign('type', 1);
    $smarty->display('shop_s_openid.tpl');
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
