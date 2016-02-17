<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_activity.php');

require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
    ///修改1,查询语句
    //sort_no,tzsy 要记得添加
    $sql = "select id,activity_sn,activity_name,sort_no,tzsy,last_update,activity_note_1,ac_lx,type,start_time,end_time,hd_number,limit_time from activity";


    $activity_list = get_activity_list($Num, "activity", $sql);

    for ($i = 0; $i < count($activity_list['items']); $i++) {
        $q = "select * from activity_mx where p_id='" . $activity_list['items'][$i]['activity_sn'] .
            "'";
        $res = $GLOBALS['db']->getRow($q);
        $activity_list['items'][$i]['prize_mx'] = $res;
    }
    //print_r($activity_list);
    $smarty->assign('activity_list', $activity_list['items']);
    $smarty->assign('fall', 1);
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $activity_list['page']);
    $smarty->display('activity.tpl');


}

if ($_REQUEST['act'] == 'add_activity_list') {

    //$sql="select xmlx_sn ,xmlx_name from xmlx";
    //   $res_xmlx = $GLOBALS['db']->getAll($sql);
    //    $smarty->assign('res_xmlx', $res_xmlx);
    $activity_mx['ac_lx'] = 0;
    $smarty->assign('activity_mx', $activity_mx);
    $smarty->assign('fall', 'add_activity_list');
    $smarty->display('activity_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];

    ///修改2,查询语句
    $sql = "select id,activity_sn,activity_name,sort_no,tzsy,last_update,activity_note_1,type,start_time,end_time,ac_lx,hd_number,limit_time 
  from activity ";

    $activity_mx = get_activity_mx("activity", $sql);

    //print_r($activity_mx['items'][0]['ac_lx']);exit;
    $img_cod = $_REQUEST['activity_sn'];

    
    if($activity_mx['items'][0]['ac_lx']==1)
    {
        $lx_url="dazhuanpan.php";
    }
    elseif($activity_mx['items'][0]['ac_lx']==2)
    {
        $lx_url="zadan.php";
    }
    elseif($activity_mx['items'][0]['ac_lx']==3)
    {
        $lx_url="ggk.php";
    }
    
    //    //图片部分。没图片则删除
    //    $activity_imgs2 = get_activity_imgs_list("activity_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
    ////print_r($activity_imgs2);
    //    $activity_imgs = arr_push($activity_imgs2['items']);
    //    $smarty->assign('activity_imgs', $activity_imgs);
    $sqlAA = " select app_id,app_secret from app_id where weixin_id=1 ";

    $resAA = $GLOBALS['db']->getRow($sqlAA);
    $url_this = "http://" . $_SERVER['HTTP_HOST'] . "/" . dirname($_SERVER['PHP_SELF']);
    
    
    //https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9982320676ebe24b&redirect_uri=http://www.tiemal.com/admin/api/wx/dazhuanpan.php&response_type=code&scope=snsapi_base&state=1#wechat_red
    $url_this="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$resAA['app_id']."&redirect_uri=".$url_this."/wx/".$lx_url."&response_type=code&scope=snsapi_base&state=1#wechat_red";
    //print_r($url_this);exit;
    $smarty->assign('activity_mx', $activity_mx['items'][0]);
    $smarty->assign('url_this', $url_this);
    $smarty->assign('prize', $activity_mx['items']['prize'][0]);
    $smarty->assign('res_xmlx', $activity_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('activity_mx.tpl');
    
    
    
}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if (isset($_REQUEST['img_code'])) {
        $img_code = trim($_REQUEST['img_code']);

        $sql = "delete from activity_imgs where  img_outer_id= '" . $img_code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}

if ($_REQUEST['act'] == 'delete_activity') {

    //echo 1;
    if (isset($_REQUEST['activity_sn'])) {
        $activity_sn = trim($_REQUEST['activity_sn']);

        $sql = "delete from activity where  activity_sn= '" . $activity_sn . "'";
        $res = $GLOBALS['db']->query($sql);
        $sql2 = "delete from activity_mx where  p_id= '" . $activity_sn . "'";
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

        $sql = "update  activity_imgs set ss=" . $alt . "  where  img_outer_id= '" . $img_code .
            "'";
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}
if ($_REQUEST['act'] == 'activity_xs') {

    //echo 1;

    if (isset($_REQUEST['activity_code']) && isset($_REQUEST['alt'])) {
        $activity_code = urldecode(trim($_REQUEST['activity_code']));
        $alt = urldecode(trim($_REQUEST['alt']));

        $sql = "update  activity set tzsy=" . $alt . "  where  activity_sn= '" . $activity_code .
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
    //    $path=$p->upload_path='upload/activity';
    //    $p->uplood_img();
    //    $img_array = $p->upload_file;
    //
    //    for($i=0;$i<count($img_array['guige']);$i++)
    //    {
    //        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
    //    }
    //    $aaa = $_POST['activity_sn'];
    //    // print_r($aaa);exit;
    //    //图片部分。没图片则删除
    //    img_insert($aaa, $img_array,"activity_imgs");
    //修改3，更新语句
    $time_field = array( //array("type"=>"2","field"=>"add_time","method"=>"1"),
            array(
            "type" => "2",
            "field" => "last_update",
            "method" => "2"), array(
            "type" => "1",
            "field" => "last_update_2",
            "method" => "2"));
    //print_r($time_field);exit;
    // print_r($_REQUEST['ac_lx']);
    $ss = "update activity set ac_lx ='" . $_REQUEST['ac_lx'][0] .
        "' where  activity_sn='" . $_REQUEST['activity_sn'] . "'";
    //print_r($ss);exit;
    $ss = $GLOBALS['db']->query($ss);

    //更新概率数量

    $prize_sl = $_REQUEST['prize_sl'];
    $prize_gl = $_REQUEST['prize_gl'];
    $prize_jpms = $_REQUEST['prize_jpms'];
    $up = "update activity_mx set prize1_sl='" . $prize_sl[0] . "',prize2_sl='" . $prize_sl[1] .
        "',prize3_sl='" . $prize_sl[2] . "',prize1_gl='" . $prize_gl[0] .
        "',prize2_gl='" . $prize_gl[1] . "',prize3_gl='" . $prize_gl[2] .
        "',prize1_jpms='" . $prize_jpms[0] .
        "',prize2_jpms='" . $prize_jpms[1] . "',prize3_jpms='" . $prize_jpms[2] .
        "' where  p_id='" . $_REQUEST['activity_sn'] . "'";
    // print_r($up);exit;
    $up = $GLOBALS['db']->query($up);


    update_activity_mx("activity",
        "activity_name,activity_note_1,type_name,sort_no,start_time,end_time,hd_number,limit_time",
        "activity_sn", $time_field);

    $smarty->assign('fall', 'post');
    $smarty->display('activity_mx.tpl');
}


if ($_REQUEST['act'] == 'post_add') {
    if (isset($_REQUEST['activity_sn'])) {
        $activity_sn = trim($_REQUEST['activity_sn']);
    }
    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one = " select activity_sn from activity where activity_sn ='" . $activity_sn .
        "'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($get_one);exit;
    if (empty($res)) {
        //echo 1;
        // $p = new upload;
        //        $path=$p->upload_path='upload/activity';
        //        $p->uplood_img();
        //        $img_array = $p->upload_file;
        //        for($i=0;$i<count($img_array['guige']);$i++)
        //        {
        //        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
        //        }
        //        //print_r($img_array);exit;
        //        $aaa = $activity_sn;
        //
        //        //插入图片记录//图片部分。没图片则删除
        //         img_insert($aaa, $img_array,"activity_imgs");
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
        insert_activity_mx("activity",
            "activity_sn,activity_name,activity_note_1,type,type_name,sort_no,start_time,end_time,hd_number,limit_time",
            $time_field);
            
            
            $ss = "update activity set ac_lx ='" . $_REQUEST['ac_lx'][0] .
        "' where  activity_sn='" . $_REQUEST['activity_sn'] . "'";
    //print_r($ss);exit;
    $ss = $GLOBALS['db']->query($ss);
        $prize_sl = $_REQUEST['prize_sl'];
        $prize_gl = $_REQUEST['prize_gl'];
        $prize_jpms = $_REQUEST['prize_jpms'];
        // print_r($up);exit;

        $in = "insert into activity_mx(p_id,prize1_sl,prize2_sl,prize3_sl,prize1_gl,prize2_gl,prize3_gl,prize1_jpms,prize2_jpms,prize3_jpms) values ('" .
            $activity_sn . "','" . $prize_sl[0] . "','" . $prize_sl[1] . "','" . $prize_sl[2] .
            "','" . $prize_gl[0] . "','" . $prize_gl[1] . "','" . $prize_gl[2] . "','" . $prize_jpms[0] . "','" . $prize_jpms[1] . "','" . $prize_jpms[2] . "')";
            //print_r($in);exit;
        $in = $GLOBALS['db']->query($in);
        $smarty->assign('fall', 'post');
        $smarty->display('activity_mx.tpl');
    } else {
        $smarty->assign('fall', 'fs');
        $smarty->display('activity_mx.tpl');
    }


}



?>