<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_sendmsg.php');


require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
    ///修改1,查询语句
    //sort_no,tzsy 要记得添加
    $sql = "select id,sendmsg_sn,sendmsg_name,sort_no,tzsy,last_update,note,rq,re_code,re_type,role,qf_type,is_auto from sendmsg";


    $sendmsg_list = get_sendmsg_list($Num, "sendmsg", $sql);

    for ($i = 0; $i < count($sendmsg_list['items']); $i++) {


        $sendmsg_list['items'][$i]['send_sum'] = get_sendmsg_users_list($sendmsg_list['items'][$i]['sendmsg_sn']);

    }


    for ($i = 0; $i < count($sendmsg_list['items']); $i++) {

        $sendmsg_list['items'][$i]['role2'] = get_group_name($sendmsg_list['items'][$i]['role']);

    }

    //print_r($sendmsg_list);


    $smarty->assign('sendmsg_list', $sendmsg_list['items']);
    $smarty->assign('fall', 1);
    $smarty->assign('title', $aaa);

    $smarty->assign('p_Array', $sendmsg_list['page']);
    $smarty->display('sendmsg.tpl');


}

if ($_REQUEST['act'] == 'add_sendmsg_list') {

    //$sql="select xmlx_sn ,xmlx_name from xmlx";
    //   $res_xmlx = $GLOBALS['db']->getAll($sql);
    //    $smarty->assign('res_xmlx', $res_xmlx);
    $sendmsg_mx['ac_lx'] = 0;
    $smarty->assign('sendmsg_mx', $sendmsg_mx);
    $smarty->assign('fall', 'add_sendmsg_list');
    $smarty->display('sendmsg_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];

    ///修改2,查询语句
    $sql = "select id,sendmsg_sn,sendmsg_name,sort_no,tzsy,last_update,note,rq,re_code,re_type,role,qf_type  from sendmsg ";

    $sendmsg_mx = get_sendmsg_mx("sendmsg", $sql);

    //print_r($sendmsg_mx);exit;
    $img_cod = $_REQUEST['sendmsg_sn'];


    //    //图片部分。没图片则删除
    //    $sendmsg_imgs2 = get_sendmsg_imgs_list("sendmsg_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
    ////print_r($sendmsg_imgs2);
    //    $sendmsg_imgs = arr_push($sendmsg_imgs2['items']);
    //    $smarty->assign('sendmsg_imgs', $sendmsg_imgs);
    $sqlAA = " select app_id,app_secret from app_id where weixin_id=1 ";

    $resAA = $GLOBALS['db']->getRow($sqlAA);
    $url_this = "http://" . $_SERVER['HTTP_HOST'] . "/" . dirname($_SERVER['PHP_SELF']);


    //https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9982320676ebe24b&redirect_uri=http://www.tiemal.com/admin/api/wx/dazhuanpan.php&response_type=code&scope=snsapi_base&state=1#wechat_red
    $url_this = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $resAA['app_id'] .
        "&redirect_uri=" . $url_this .
        "/wx/dazhuanpan.php&response_type=code&scope=snsapi_base&state=1#wechat_red";
    //print_r($url_this);exit;
    $smarty->assign('sendmsg_mx', $sendmsg_mx['items'][0]);

    //获取用户组
    $group = get_group();
    $smarty->assign('group', $group);
    //print_r($group);
    //--
    $smarty->assign('url_this', $url_this);
    $smarty->assign('prize', $sendmsg_mx['items']['prize'][0]);
    $smarty->assign('res_xmlx', $sendmsg_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');


    //添加会员中心搜索

    require (dirname(__file__) . '/sub/sub_openid2.php');

    if (isset($_REQUEST['sendmsg_sn'])) {
        $sendmsg_sn = trim($_REQUEST['sendmsg_sn']);
        // echo $filer;
    }

    $list = openid($Num, "sendmsg_users", $sendmsg_sn);

    //$list=openid(5,"users");
    //print_r($list);

    $smarty->assign('searchUrl', "sendmsg.php?act=edit");
    $smarty->assign('openid_list', $list['item']);
    $smarty->assign('p_Array', $list['page']);

    //-----------------------------------------
    $smarty->display('sendmsg_mx.tpl');


}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if (isset($_REQUEST['img_code'])) {
        $img_code = trim($_REQUEST['img_code']);

        $sql = "delete from sendmsg_imgs where  img_outer_id= '" . $img_code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}

if ($_REQUEST['act'] == 'delete_sendmsg') {

    //echo 1;
    if (isset($_REQUEST['sendmsg_sn'])) {
        $sendmsg_sn = trim($_REQUEST['sendmsg_sn']);

        $sql = "delete from sendmsg where  sendmsg_sn= '" . $sendmsg_sn . "'";
        $res = $GLOBALS['db']->query($sql);
        $sql2 = "delete from sendmsg_mx where  p_id= '" . $sendmsg_sn . "'";
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

        $sql = "update  sendmsg_imgs set ss=" . $alt . "  where  img_outer_id= '" . $img_code .
            "'";
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}
if ($_REQUEST['act'] == 'sendmsg_xs') {

    //echo 1;

    if (isset($_REQUEST['sendmsg_code']) && isset($_REQUEST['alt'])) {
        $sendmsg_code = urldecode(trim($_REQUEST['sendmsg_code']));
        $alt = urldecode(trim($_REQUEST['alt']));

        $sql = "update  sendmsg set tzsy=" . $alt . "  where  sendmsg_sn= '" . $sendmsg_code .
            "'";
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";
    } else {
        echo "失败";
    }

    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}


if ($_REQUEST['act'] == 'is_auto') {

    //echo 1;

    if (isset($_REQUEST['sendmsg_code']) && isset($_REQUEST['alt'])) {
        $sendmsg_code = urldecode(trim($_REQUEST['sendmsg_code']));
        $alt = urldecode(trim($_REQUEST['alt']));

        $sql = "update  sendmsg set is_auto=1  where  sendmsg_sn= '" . $sendmsg_code .
            "'";
        $res = $GLOBALS['db']->query($sql);
        echo "已添加";
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
    //    $path=$p->upload_path='upload/sendmsg';
    //    $p->uplood_img();
    //    $img_array = $p->upload_file;
    //
    //    for($i=0;$i<count($img_array['guige']);$i++)
    //    {
    //        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
    //    }
    //    $aaa = $_POST['sendmsg_sn'];
    //    // print_r($aaa);exit;
    //    //图片部分。没图片则删除
    //    img_insert($aaa, $img_array,"sendmsg_imgs");
    //修改3，更新语句
    $time_field = array( //array("type"=>"2","field"=>"add_time","method"=>"1"),
            array(
            "type" => "2",
            "field" => "last_update",
            "method" => "2"), array(
            "type" => "1",
            "field" => "last_update_2",
            "method" => "2"));


    update_sendmsg_mx("sendmsg",
        "sendmsg_name,sort_no,last_update,note,rq,re_code,re_type,role,qf_type",
        "sendmsg_sn", $time_field);
    header("location:sendmsg.php"); 
    $smarty->assign('fall', 'post');
    $smarty->display('sendmsg_mx.tpl');
}


if ($_REQUEST['act'] == 'post_add') {
    if (isset($_REQUEST['sendmsg_sn'])) {
        $sendmsg_sn = trim($_REQUEST['sendmsg_sn']);
    }


    if (isset($_REQUEST['qf_type'])) {
        $qf_type = trim($_REQUEST['qf_type']);
    }
    //print_r($qf_type);exit;
    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one = " select sendmsg_sn from sendmsg where sendmsg_sn ='" . $sendmsg_sn .
        "'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($res);exit;
    if (empty($res)) {
        //echo 1;
        // $p = new upload;
        //        $path=$p->upload_path='upload/sendmsg';
        //        $p->uplood_img();
        //        $img_array = $p->upload_file;
        //        for($i=0;$i<count($img_array['guige']);$i++)
        //        {
        //        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
        //        }
        //        //print_r($img_array);exit;
        //        $aaa = $sendmsg_sn;
        //
        //        //插入图片记录//图片部分。没图片则删除
        //         img_insert($aaa, $img_array,"sendmsg_imgs");
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
        insert_sendmsg_mx("sendmsg",
            "sendmsg_sn,sendmsg_name,note,rq,re_code,re_type,qf_type", $time_field);

        header("location:sendmsg.php"); 
        $smarty->assign('fall', 'post');
        $smarty->display('sendmsg_mx.tpl');
    } else {
        $smarty->assign('fall', 'fs');
        $smarty->display('sendmsg_mx.tpl');
    }


}


if ($_REQUEST['act'] == 'send_users_list') {

    //添加发送信息列表

    if (isset($_REQUEST['p_id']) && isset($_REQUEST['list'])) {
        $p_id = trim($_REQUEST['p_id']);
        $list = trim($_REQUEST['list']);

        //添加sql
        if ($list == "All") {
            $sql2 = "delete from sendmsg_users where p_id='" . $p_id . "'";
            $sql2 = $GLOBALS['db']->query($sql2);
            $sql = "insert into sendmsg_users(p_id,nick_name,users_sn,openid) select '" . $p_id .
                "',nick_name,users_sn,openid from users where openid is not null";
            $res = $GLOBALS['db']->query($sql);


            $sql3 = "update sendmsg set role= '" . $list . "' where sendmsg_sn='" . $p_id .
                "'";
            $sql3 = $GLOBALS['db']->query($sql3);

        } elseif ($list == "") {
            $sql2 = "delete from sendmsg_users where p_id='" . $p_id . "'";
            $sql2 = $GLOBALS['db']->query($sql2);


            $sql3 = "update sendmsg set role= '" . $list . "' where sendmsg_sn='" . $p_id .
                "'";
            $sql3 = $GLOBALS['db']->query($sql3);
        } else {
            $sql2 = "delete from sendmsg_users where p_id='" . $p_id . "'";
            $sql2 = $GLOBALS['db']->query($sql2);
            $sql = "insert into sendmsg_users(p_id,nick_name,users_sn,openid) select '" . $p_id .
                "',nick_name,users_sn,openid from wx_users_group where group_sn='" . $list . "'";
            $res = $GLOBALS['db']->query($sql);


            $sql3 = "update sendmsg set role= '" . $list . "' where sendmsg_sn='" . $p_id .
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
     elseif ($type == "imgtext_h") {
        $sql_t = "select imgtext3_sn as sn,imgtext3_name as name from imgtext3 where tzsy=0";
        $sql_t = $GLOBALS['db']->getAll($sql_t);
        $aaa = new arraytojson();
        $json = $aaa->JSON($sql_t);

        print_r($json);
    }


}

?>