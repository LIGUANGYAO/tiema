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
    $sql = "select id,activity_sn,activity_name,sort_no,tzsy,last_update,activity_note_1,ac_lx,type,start_time,end_time,hd_number from activity ";
    $activity_list = get_activity_list1($Num, "activity", $sql);

    for ($i = 0; $i < count($activity_list['items']); $i++) {
        //$q = "select * from activity_mx where p_id='" . $activity_list['items'][$i]['activity_sn']."'";
        //$res = $GLOBALS['db']->getRow($q);
        //$activity_list['items'][$i]['prize_mx'] = $res;
        $q = "select count(id) as zsl from goods ";
        $res = $GLOBALS['db']->getRow($q);
        $activity_list['items'][$i]['goods_z'] = $res;
        
        $q1 = "select count(id) as yxsl from wx_zan_goods where activity_sn='" . $activity_list['items'][$i]['activity_sn']."'";
        $res1 = $GLOBALS['db']->getRow($q1);
        $activity_list['items'][$i]['goods_yx'] = $res1;
        
        $q2 = "select count(id) as rwsl from wx_zan_goods where activity_sn='" . $activity_list['items'][$i]['activity_sn']."' and is_choose=1";
        $res2 = $GLOBALS['db']->getRow($q2);
        $activity_list['items'][$i]['goods_rw'] = $res2;
        
    }
    //print_r($activity_list);
    $smarty->assign('activity_list', $activity_list['items']);
    $smarty->assign('fall', 1);
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $activity_list['page']);
    $smarty->display('wx_zan.tpl');


}

if ($_REQUEST['act'] == 'add_activity_list') {
    $smarty->assign('fall', 'add_activity_list');
    $smarty->display('wx_zan_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];

    ///修改2,查询语句
    $sql = "select id,activity_sn,activity_name,sort_no,tzsy,last_update,activity_note_1,type,start_time,end_time,ac_lx,hd_number,sh 
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
    elseif($activity_mx['items'][0]['ac_lx']==4)
    {
        $lx_url="wx_praise.php";
    }
    
    //    //图片部分。没图片则删除
    //    $activity_imgs2 = get_activity_imgs_list("activity_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
    ////print_r($activity_imgs2);
    //    $activity_imgs = arr_push($activity_imgs2['items']);
    //    $smarty->assign('activity_imgs', $activity_imgs);
    $sqlAA = " select app_id,app_secret from app_id where weixin_id=1 ";
    $resAA = $GLOBALS['db']->getRow($sqlAA);
    $url_this = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    
    
    //https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9982320676ebe24b&redirect_uri=http://www.tiemal.com/admin/api/wx/dazhuanpan.php&response_type=code&scope=snsapi_base&state=1#wechat_red
    $url_this="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$resAA['app_id']."&redirect_uri=".$url_this."/".$lx_url."?hd_sn=".$img_cod."&response_type=code&scope=snsapi_base&state=1#wechat_red";
    //print_r($url_this);exit;
    
     $goods_list=get_zan_goods_mx($img_cod);
     $smarty->assign('goods_list', $goods_list['items']);
     $goods_choose_list=get_zan_goods_choose_mx($img_cod);
     $smarty->assign('goods_choose_list', $goods_choose_list['items']);
    
   
    $smarty->assign('activity_mx', $activity_mx['items'][0]);
    $smarty->assign('url_this', $url_this);
    $smarty->assign('prize', $activity_mx['items']['prize'][0]);
    $smarty->assign('res_xmlx', $activity_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('wx_zan_mx.tpl');
    
    
    
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
        "activity_name,activity_note_1,type_name,sort_no,start_time,end_time,hd_number",
        "activity_sn", $time_field);

    $smarty->assign('fall', 'post');
    $smarty->display('wx_zan_mx.tpl');
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
      $time_field = array(array(
                "type" => "2",
                "field" => "add_time",
                "method" => "1"), // array("type"=>"2","field"=>"last_update","method"=>"2"),
                //array("type"=>"1","field"=>"last_update_2","method"=>"2")
            );
        //修改4，增加语句
        //保存修改后商品明细
        insert_activity_mx("activity",
            "activity_sn,activity_name,activity_note_1,type,type_name,sort_no,start_time,end_time,hd_number",
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
        
        
        $smarty->assign('fall', 'edit');
       /////插入后直接跳转修改页面
      $sql = "select id,activity_sn,activity_name,sort_no,tzsy,last_update,activity_note_1,type,start_time,end_time,ac_lx,hd_number 
       from activity ";
      $activity_mx = get_activity_mx("activity", $sql);
      
       $sqlAA = " select app_id,app_secret from app_id where weixin_id=1 ";

       $resAA = $GLOBALS['db']->getRow($sqlAA);
       $url_this = "http://" . $_SERVER['HTTP_HOST'] . "/" . dirname($_SERVER['PHP_SELF']);
    
      $url_this="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$resAA['app_id']."&redirect_uri=".$url_this."/wx/".$lx_url."&response_type=code&scope=snsapi_base&state=1#wechat_red";
      $smarty->assign('activity_mx', $activity_mx['items'][0]);
      $smarty->assign('url_this', $url_this);
      $smarty->assign('prize', $activity_mx['items']['prize'][0]);
      /////插入后直接跳转修改页面
      $smarty->display('wx_zan_mx.tpl');
    } else {
        $smarty->assign('fall', 'fs');
        $smarty->display('wx_zan_mx.tpl');
    }


}


if ($_REQUEST['act'] == 'ysss') {

    require (dirname(__file__) . '/sub/rest.php');
    if (isset($_REQUEST['activity_sn']))
    {
        $activity_sn= $_REQUEST['activity_sn'];
    }
    if(isset($_REQUEST['keyword'])){
        $keyword= urldecode($_REQUEST['keyword']);
        
        if($keyword=="all")
        {
         // $sql="select id,openid,users_sn,nick_name from users where lylx=1 and id not in (select users_id from wx_users_group where group_sn='".$group_sn."')";
         $sql="select id,goods_sn,goods_name from goods where  id not in (select goods_id from wx_zan_goods where activity_sn='".$activity_sn."')";
         $res = $GLOBALS['db']->getAll($sql);
        }
        else
        {
         $where="where goods_sn like '%".$keyword."%' or goods_name like '%".$keyword."%'";
         $sql="select id,goods_sn,goods_name from goods ".$where;
         $res = $GLOBALS['db']->getAll($sql);
        }
     }
     //$sql="select color_sn,color_name from color ";
     $res = $GLOBALS['db']->getAll($sql);
     $aaa=new arraytojson();
     $json=$aaa->JSON($res);
     print_r($json);
}


if ($_REQUEST['act'] == 'yssss') {

    require (dirname(__file__) . '/sub/rest.php');
    if (isset($_REQUEST['activity_sn']))
    {
        $activity_sn= $_REQUEST['activity_sn'];
    }
    
     $sql="select id,activity_sn,sh from activity where activity_sn='".$activity_sn."' ";
     $res = $GLOBALS['db']->getAll($sql);
     $sh=$res[0]['sh'];
    
    if($sh==1){
    if(isset($_REQUEST['keyword'])){
        $keyword= urldecode($_REQUEST['keyword']);
        if($keyword=="all")
        {
         // $sql="select id,openid,users_sn,nick_name from users where lylx=1 and id not in (select users_id from wx_users_group where group_sn='".$group_sn."')";
         $sql="select id,activity_sn,goods_id,goods_sn,goods_name,is_choose,add_time from wx_zan_goods where activity_sn='".$activity_sn."' and is_choose=0 "; //where  id not in (select goods_id from wx_zan_goods where activity_sn='".$activity_sn."')";
         $res = $GLOBALS['db']->getAll($sql);
        }
        else
        {
         $where="where activity_sn='".$activity_sn."' and goods_sn like '%".$keyword."%' or goods_name like '%".$keyword."%'";
         $sql="select id,activity_sn,goods_id,goods_sn,goods_name,is_choose,add_time from wx_zan_goods ".$where;
         $res = $GLOBALS['db']->getAll($sql);
        }
      }
      }
      else{
        
      }
     $aaa=new arraytojson();
     $json=$aaa->JSON($res);
     print_r($json);
}





if ($_REQUEST['act'] == 'i_goods_list') {
    
     if (isset($_REQUEST['activity_sn'])) {
        $activity_sn = trim($_REQUEST['activity_sn']);
    }
      if(isset($_REQUEST['st']))
    {
        $st = explode(",", $_REQUEST['st']);
       // print_r($st);
    }
     //print_r(count($st));
      $sqlaaa="delete from wx_zan_goods where activity_sn='".$activity_sn."'";
      $resultaaa=$GLOBALS['db']->query($sqlaaa);  
     
     
     for ($i = 0; $i < count($st)-1; $i++) {
         if(!empty($st)){
            $sql="select id,goods_sn,goods_name from goods where id='".$st[$i]."' ";
            $res = $GLOBALS['db']->getAll($sql);
            
            $goods_id=$res[0]['id'];
            $goods_sn=$res[0]['goods_sn'];
            $goods_name=$res[0]['goods_name'];
            $time=date('Y-m-d H:i:s', time());
            $in = "insert into wx_zan_goods(activity_sn,goods_id,goods_sn,goods_name,add_time) values ('" .
            $activity_sn . "','".$goods_id."','" . $goods_sn . "','" . $goods_name. "','".$time."')";
            $res = $GLOBALS['db']->query($in);
          }    
     }
}


if ($_REQUEST['act'] == 'u_goods_list') {
    
     if (isset($_REQUEST['activity_sn'])) {
        $activity_sn = trim($_REQUEST['activity_sn']);
    }
      if(isset($_REQUEST['st']))
    {
        $st = explode(",", $_REQUEST['st']);
       print_r($st);
    }
    
      $sqlaaa="update wx_zan_goods set is_choose=0 where activity_sn='".$activity_sn."'";
      $resultaaa=$GLOBALS['db']->query($sqlaaa);  
     
     
     for ($i = 0; $i < count($st)-1; $i++) {
         if(!empty($st)){
            $sql="select id,goods_sn,goods_name from goods where id='".$st[$i]."' ";
            $res = $GLOBALS['db']->getAll($sql);
            
            $goods_id=$res[0]['id'];
            $goods_sn=$res[0]['goods_sn'];
            $goods_name=$res[0]['goods_name'];
            $time=date('Y-m-d H:i:s', time());
            $in = "update wx_zan_goods set is_choose=1 where goods_id= '".$goods_id."' ";
            $res = $GLOBALS['db']->query($in);
          }    
     }
}


if ($_REQUEST['act'] == 'shenhe') {

    //echo 1;

    if (isset($_REQUEST['activity_sn']) && isset($_REQUEST['alt'])) {
        $activity_sn = urldecode(trim($_REQUEST['activity_sn']));
        $alt = urldecode(trim($_REQUEST['alt']));

        $sql = "update activity set sh=" . $alt . "  where  activity_sn= '" . $activity_sn .
            "'";
        $res = $GLOBALS['db']->query($sql);
       
    } else {
       
    }

    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}
?>