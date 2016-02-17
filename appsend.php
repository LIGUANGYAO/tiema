<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_appsend.php');


require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
    ///修改1,查询语句
    //sort_no,tzsy 要记得添加
    $sql = "select id,appsend_sn,appsend_name,sort_no,tzsy,last_update,note,rq,re_code,re_type,role,qf_type from appsend";


    $appsend_list = get_appsend_list($Num, "appsend", $sql);

    for ($i = 0; $i < count($appsend_list['items']); $i++) {


        $appsend_list['items'][$i]['send_sum'] = get_appsend_users_list($appsend_list['items'][$i]['appsend_sn']);

    }


    for ($i = 0; $i < count($appsend_list['items']); $i++) {

        $appsend_list['items'][$i]['role2'] = get_group_name($appsend_list['items'][$i]['role']);

    }

    //print_r($appsend_list);


    $smarty->assign('appsend_list', $appsend_list['items']);
    $smarty->assign('fall', 1);
    $smarty->assign('title', $aaa);

    $smarty->assign('p_Array', $appsend_list['page']);
    $smarty->display('appsend.tpl');


}

if ($_REQUEST['act'] == 'add_appsend_list') {

    //$sql="select xmlx_sn ,xmlx_name from xmlx";
    //   $res_xmlx = $GLOBALS['db']->getAll($sql);
    //    $smarty->assign('res_xmlx', $res_xmlx);
    $appsend_mx['ac_lx'] = 0;
    $smarty->assign('appsend_mx', $appsend_mx);
    $smarty->assign('fall', 'add_appsend_list');
    $smarty->display('appsend_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];

    ///修改2,查询语句
    $sql = "select id,appsend_sn,appsend_name,sort_no,tzsy,last_update,note,rq,re_code,re_type,role,qf_type  from appsend ";

    $appsend_mx = get_appsend_mx("appsend", $sql);

    //print_r($appsend_mx);exit;
    $img_cod = $_REQUEST['appsend_sn'];


    //    //图片部分。没图片则删除
    //    $appsend_imgs2 = get_appsend_imgs_list("appsend_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
    ////print_r($appsend_imgs2);
    //    $appsend_imgs = arr_push($appsend_imgs2['items']);
    //    $smarty->assign('appsend_imgs', $appsend_imgs);
    $sqlAA = " select app_id,app_secret from app_id where weixin_id=1 ";

    $resAA = $GLOBALS['db']->getRow($sqlAA);
    $url_this = "http://" . $_SERVER['HTTP_HOST'] . "/" . dirname($_SERVER['PHP_SELF']);


    //https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9982320676ebe24b&redirect_uri=http://www.tiemal.com/admin/api/wx/dazhuanpan.php&response_type=code&scope=snsapi_base&state=1#wechat_red
    $url_this = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $resAA['app_id'] .
        "&redirect_uri=" . $url_this .
        "/wx/dazhuanpan.php&response_type=code&scope=snsapi_base&state=1#wechat_red";
    //print_r($url_this);exit;
    $smarty->assign('appsend_mx', $appsend_mx['items'][0]);

    //获取用户组
    $group = get_group();
    $smarty->assign('group', $group);
    //print_r($group);
    //--
    $smarty->assign('url_this', $url_this);
    $smarty->assign('prize', $appsend_mx['items']['prize'][0]);
    $smarty->assign('res_xmlx', $appsend_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');


    //添加会员中心搜索

    require (dirname(__file__) . '/sub/sub_appsendpushid.php');

    if (isset($_REQUEST['appsend_sn'])) {
        $appsend_sn = trim($_REQUEST['appsend_sn']);
        // echo $filer;
    }

    $list = openid($Num, "appsend_users", $appsend_sn);

    //$list=openid(5,"users");
    //print_r($list);

    $smarty->assign('searchUrl', "appsend.php?act=edit");
    $smarty->assign('openid_list', $list['item']);
    $smarty->assign('p_Array', $list['page']);

    //-----------------------------------------
    $smarty->display('appsend_mx.tpl');


}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if (isset($_REQUEST['img_code'])) {
        $img_code = trim($_REQUEST['img_code']);

        $sql = "delete from appsend_imgs where  img_outer_id= '" . $img_code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}

if ($_REQUEST['act'] == 'delete_appsend') {

    //echo 1;
    if (isset($_REQUEST['appsend_sn'])) {
        $appsend_sn = trim($_REQUEST['appsend_sn']);

        $sql = "delete from appsend where  appsend_sn= '" . $appsend_sn . "'";
        $res = $GLOBALS['db']->query($sql);
        $sql2 = "delete from appsend_mx where  p_id= '" . $appsend_sn . "'";
        $sql2 = $GLOBALS['db']->query($sql2);
        echo "删除成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}
if ($_REQUEST['act'] == 'img_xs') {

    //echo 1;
    if (isset($_REQUEST['img_code']) && isset($_REQUEST['alt'])) {
        $img_code = trim($_REQUEST['img_code']);
        $alt = trim($_REQUEST['alt']);

        $sql = "update  appsend_imgs set ss=" . $alt . "  where  img_outer_id= '" . $img_code .
            "'";
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}
if ($_REQUEST['act'] == 'appsend_xs') {

    //echo 1;

    if (isset($_REQUEST['appsend_code']) && isset($_REQUEST['alt'])) {
        $appsend_code = urldecode(trim($_REQUEST['appsend_code']));
        $alt = urldecode(trim($_REQUEST['alt']));

        $sql = "update  appsend set tzsy=" . $alt . "  where  appsend_sn= '" . $appsend_code .
            "'";
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";
    } else {
        echo "失败";
    }

    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}


if ($_REQUEST['act'] == 'post') {

    //$a=$_REQUEST['a'];
    //echo $a;exit;
    //$p = new upload;
    //    $path=$p->upload_path='upload/appsend';
    //    $p->uplood_img();
    //    $img_array = $p->upload_file;
    //
    //    for($i=0;$i<count($img_array['guige']);$i++)
    //    {
    //        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
    //    }
    //    $aaa = $_POST['appsend_sn'];
    //    // print_r($aaa);exit;
    //    //图片部分。没图片则删除
    //    img_insert($aaa, $img_array,"appsend_imgs");
    //修改3，更新语句
    $time_field = array( //array("type"=>"2","field"=>"add_time","method"=>"1"),
            array(
            "type" => "2",
            "field" => "last_update",
            "method" => "2"), array(
            "type" => "1",
            "field" => "last_update_2",
            "method" => "2"));


    update_appsend_mx("appsend",
        "appsend_name,sort_no,last_update,note,rq,re_code,re_type,role,qf_type",
        "appsend_sn", $time_field);

    $smarty->assign('fall', 'post');
    $smarty->display('appsend_mx.tpl');
}


if ($_REQUEST['act'] == 'post_add') {
    if (isset($_REQUEST['appsend_sn'])) {
        $appsend_sn = trim($_REQUEST['appsend_sn']);
    }


    if (isset($_REQUEST['qf_type'])) {
        $qf_type = trim($_REQUEST['qf_type']);
    }
    //print_r($qf_type);exit;
    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one = " select appsend_sn from appsend where appsend_sn ='" . $appsend_sn .
        "'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($res);exit;
    if (empty($res)) {
        //echo 1;
        // $p = new upload;
        //        $path=$p->upload_path='upload/appsend';
        //        $p->uplood_img();
        //        $img_array = $p->upload_file;
        //        for($i=0;$i<count($img_array['guige']);$i++)
        //        {
        //        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
        //        }
        //        //print_r($img_array);exit;
        //        $aaa = $appsend_sn;
        //
        //        //插入图片记录//图片部分。没图片则删除
        //         img_insert($aaa, $img_array,"appsend_imgs");
        //修改4，增加语句
        //保存修改后商品明细
        $time_field = array(array(
                "type" => "2",
                "field" => "add_time",
                "method" => "1"), // array("type"=>"2","field"=>"last_update","method"=>"2"),
                //array("type"=>"1","field"=>"last_update_2","method"=>"2")
            );
        //修改4，增加语句
        //保存修改后商品明细
        insert_appsend_mx("appsend",
            "appsend_sn,appsend_name,note,rq,re_code,re_type,qf_type", $time_field);


        $smarty->assign('fall', 'post');
        $smarty->display('appsend_mx.tpl');
    } else {
        $smarty->assign('fall', 'fs');
        $smarty->display('appsend_mx.tpl');
    }


}


if ($_REQUEST['act'] == 'send_users_list') {

    //添加发送信息列表

    if (isset($_REQUEST['p_id']) && isset($_REQUEST['list'])) {
        $p_id = trim($_REQUEST['p_id']);
        $list = trim($_REQUEST['list']);

        //添加sql
        if ($list == "All") {
            $sql2 = "delete from appsend_users where p_id='" . $p_id . "'";
            $sql2 = $GLOBALS['db']->query($sql2);
            $sql = "insert into appsend_users(p_id,nick_name,users_sn,openid,push_id) values ('".$p_id."','All','All','All','All') ";
            $res = $GLOBALS['db']->query($sql);


            $sql3 = "update appsend set role= '" . $list . "' where appsend_sn='" . $p_id .
                "'";
            $sql3 = $GLOBALS['db']->query($sql3);

        } 
        elseif ($list == "weixin") {
            
            $sql2 = "delete from appsend_users where p_id='" . $p_id . "'";
            $sql2 = $GLOBALS['db']->query($sql2);
            $sql = "insert into appsend_users(p_id,nick_name,users_sn,openid,push_id) select '" . $p_id .
                "',nick_name,users_sn,openid,push_id from users where openid is not null  and push_id is not null ";
            $res = $GLOBALS['db']->query($sql);


            $sql3 = "update appsend set role= '" . $list . "' where appsend_sn='" . $p_id .
                "'";
            $sql3 = $GLOBALS['db']->query($sql3);
        }
        elseif ($list == "") {
            $sql2 = "delete from appsend_users where p_id='" . $p_id . "'";
            $sql2 = $GLOBALS['db']->query($sql2);


            $sql3 = "update appsend set role= '" . $list . "' where appsend_sn='" . $p_id .
                "'";
            $sql3 = $GLOBALS['db']->query($sql3);
        } else {
            $sql2 = "delete from appsend_users where p_id='" . $p_id . "'";
            $sql2 = $GLOBALS['db']->query($sql2);
            //$sql = "insert into appsend_users(p_id,nick_name,users_sn,openid) select '" . $p_id .
               // "',nick_name,users_sn,openid from wx_users_group where group_sn='" . $list . "'";
                
            $sql = "insert into appsend_users(p_id,nick_name,users_sn,openid,push_id) select '" . $p_id .
                "',a.nick_name,a.users_sn,a.openid,b.push_id  from wx_users_group a inner join users b on a.openid=b.openid  where  b.push_id is not null and  a.group_sn='" . $list . "'";
            $res = $GLOBALS['db']->query($sql);
            //0703没写完的
            //select a.nick_name,a.users_sn,a.openid from wx_users_group a inner join users b on a.openid=b.openid  where  b.push_id is not null

            $sql3 = "update appsend set role= '" . $list . "' where appsend_sn='" . $p_id .
                "'";
            $sql3 = $GLOBALS['db']->query($sql3);
        }

    }
}


if ($_REQUEST['act'] == 'get_type') {

    //echo 1;exit;
    //if(isset($_REQUEST['province'])){
    require (dirname(__file__) . '/sub/rest.php');
    $type = urldecode($_REQUEST['type']);

    if ($type == "text") {
        $sql_t = "select text2_sn as sn,title as name from text2_reply where tzsy=0";
        $sql_t = $GLOBALS['db']->getAll($sql_t);
        $aaa = new arraytojson();
        $json = $aaa->JSON($sql_t);

        print_r($json);

    } elseif ($type == "imgtext") {
        $sql_t = "select imgtext2_sn as sn,imgtext2_name as name from imgtext2 where tzsy=0";
        $sql_t = $GLOBALS['db']->getAll($sql_t);
        $aaa = new arraytojson();
        $json = $aaa->JSON($sql_t);

        print_r($json);
    } elseif ($type == "url") {
        $sql_t = "select actionurl_sn as sn,actionurl_name as name from actionurl where tzsy=0";
        $sql_t = $GLOBALS['db']->getAll($sql_t);
        $aaa = new arraytojson();
        $json = $aaa->JSON($sql_t);

        print_r($json);
    } elseif ($type == "html") {
        $sql_t = "select article_sn as sn,article_name as name from article where tzsy=0";
        $sql_t = $GLOBALS['db']->getAll($sql_t);
        $aaa = new arraytojson();
        $json = $aaa->JSON($sql_t);

        print_r($json);
    }


}

?>