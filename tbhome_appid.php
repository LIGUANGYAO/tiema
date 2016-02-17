<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
//require (dirname(__file__) . '/includes/init2.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_appid.php');

require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
///修改1,查询语句
//sort_no,tzsy 要记得添加
  //  $sql="select id,appid_sn,weixin_id,app_id,app_secret from app_id";
 //   $imgtext = "select a.lbs_name as title,a.lbs_note_1 as note,b.b_img_url as cover,b.img_action_url as link,a.lbsjd,a.lbswd from lbs a,lbs_imgs b where a.lbs_sn=b.p_id and b.ss=1 and a.tzsy=0";
   $sql="select a.id as id, a.appid_sn as appid_sn, a.weixin_id as weixin_id, a.app_id as app_id, a.app_secret as app_secret, b.mchid as mchid, b.mchkey as mchkey from app_id a, tbhome_wx_gh b where a.id=b.id";
    
     $url_this = "http://".$_SERVER ['HTTP_HOST']."".dirname($_SERVER['PHP_SELF'])."/tbhome_wx.api.php";

//    $appid_list = get_appid_list($Num,"app_id",$sql);
 //   $applist = $GLOBALS['db']->getAll[$sql];
    $applist = $GLOBALS['db']->getAll($sql);

 //   var_dump( $applist);
    //print_r($appid_list);
  //  $token=md5(($appid_list['items'][0]['appid_sn'])."tiemal");
    $token=md5(($appid_list['appid_sn'])."tiemal");
    //echo $token;
    //print_r($appid_list);
//    $smarty->assign('appid_list', $appid_list['items']);

    $smarty->assign('appid_list', $applist);
     $smarty->assign('fall', 1);
    $smarty->assign('title', $aaa);
    $smarty->assign('url_this', $url_this);
     $smarty->assign('token', $token);
 //   $smarty->assign('p_Array', $appid_list['page']);
    $smarty->display('tbhome_appid.tpl');


}

if ($_REQUEST['act'] == 'add_appid_list') {

   //$sql="select xmlx_sn ,xmlx_name from xmlx";
//   $res_xmlx = $GLOBALS['db']->getAll($sql);
//    $smarty->assign('res_xmlx', $res_xmlx);
    $smarty->assign('fall', 'add_appid_list');
    $smarty->display('appid_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];
    
    ///修改2,查询语句
  //  $sql="select  id,appid_sn,weixin_id,app_id,app_secret from app_id ";
    $sql="select a.id as id, a.appid_sn as appid_sn, a.weixin_id as weixin_id, a.app_id as app_id, a.app_secret as app_secret, b.mchid as mchid, b.mchkey as mchkey from app_id a, tbhome_wx_gh b where a.id=b.id";
//    $appid_mx=get_appid_mx("appid",$sql);

  //  $appmx = $GLOBALS['db']->getAll[$sql];
    $appmx = $GLOBALS['db']->getRow($sql);
   // print_r($appid_mx);exit;
    $img_cod=$_REQUEST['appid_sn'];
 //   var_dump($appmx);
    
//    //图片部分。没图片则删除
//    $appid_imgs2 = get_appid_imgs_list("appid_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
////print_r($appid_imgs2);
//    $appid_imgs = arr_push($appid_imgs2['items']);
//    $smarty->assign('appid_imgs', $appid_imgs);
    

//    $smarty->assign('appid_mx', $appid_mx['items'][0]);
    $smarty->assign('appid_mx', $appmx);
 //   $smarty->assign('res_xmlx', $appid_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('tbhome_appid_mx.tpl');

 }

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if(isset($_REQUEST['img_code']))
    {
        $img_code=trim($_REQUEST['img_code']);
                        
        $sql="delete from appid_imgs where  img_outer_id= '".$img_code."'";     
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";                
    }
    else
    {
        echo "失败";
    }
    
    
    
    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}

if ($_REQUEST['act'] == 'delete_appid') {

    //echo 1;
    if(isset($_REQUEST['appid_sn']))
    {
        $appid_sn=trim($_REQUEST['appid_sn']);
                        
        $sql="delete from appid where  appid_sn= '".$appid_sn."'";     
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";                
    }
    else
    {
        echo "失败";
    }
    
    
    
    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}
if ($_REQUEST['act'] == 'img_xs') {

    //echo 1;
    if(isset($_REQUEST['img_code']) && isset($_REQUEST['alt']))
    {
        $img_code=trim($_REQUEST['img_code']);
        $alt=trim($_REQUEST['alt']);
                        
        $sql="update  appid_imgs set ss=".$alt."  where  img_outer_id= '".$img_code."'";     
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";                
    }
    else
    {
        echo "失败";
    }
    
    
    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}
if ($_REQUEST['act'] == 'appid_xs') {

    //echo 1;
   
    if(isset($_REQUEST['appid_code']) && isset($_REQUEST['alt']))
    {
        $appid_code=urldecode(trim($_REQUEST['appid_code']));
        $alt=urldecode(trim($_REQUEST['alt']));
                        
        $sql="update  appid set tzsy=".$alt."  where  appid_sn= '".$appid_code."'";     
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";                
    }
    else
    {
        echo "失败";
    }
    
    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}


if ($_REQUEST['act'] == 'post') {

    
    //$p = new upload;
//    $path=$p->upload_path='upload/appid';
//    $p->uplood_img();
//    $img_array = $p->upload_file;
//   
//    for($i=0;$i<count($img_array['guige']);$i++)
//    {
//        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
//    }
//    $aaa = $_POST['appid_sn'];
//    // print_r($aaa);exit;
//    //图片部分。没图片则删除
//    img_insert($aaa, $img_array,"appid_imgs");
    //修改3，更新语句
     $time_field=array(
    //array("type"=>"2","field"=>"add_time","method"=>"1"),
    //array("type"=>"2","field"=>"last_update","method"=>"2"),
    //array("type"=>"1","field"=>"last_update_2","method"=>"2")
    );
    //print_r($time_field);exit;
  update_appid_mx("app_id","app_id,app_secret","appid_sn",$time_field);
 //   $sql="update ".$tb." set ".$fi." where ".$u_id." = '".req($u_id)."';";
$sql_gh="update tbhome_wx_gh set appid='".$_POST['app_id']."', appkey='".$_POST['app_secret']."', mchid='".$_POST['mchid']."', mchkey='".$_POST['mchkey']."' where id=1";
    $res1=$GLOBALS['db']->query($sql_gh);

    
    $smarty->assign('fall', 'post');
    $smarty->display('tbhome_appid_mx.tpl');
}


if ($_REQUEST['act'] == 'post_add') {
      if(isset($_REQUEST['appid_sn']))
    {
        $appid_sn=trim($_REQUEST['appid_sn']);
    }
    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one=" select appid_sn from appid where appid_sn ='".$appid_sn."'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($get_one);exit;
    if(empty($res))
    {
        //echo 1;
       // $p = new upload;
//        $path=$p->upload_path='upload/appid';
//        $p->uplood_img();
//        $img_array = $p->upload_file;
//        for($i=0;$i<count($img_array['guige']);$i++)
//        {
//        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
//        }
//        //print_r($img_array);exit;
//        $aaa = $appid_sn;
//        
//        //插入图片记录//图片部分。没图片则删除
//         img_insert($aaa, $img_array,"appid_imgs");
        //修改4，增加语句
        //保存修改后商品明细
           $time_field=array(
        array("type"=>"2","field"=>"add_time","method"=>"1"),
       // array("type"=>"2","field"=>"last_update","method"=>"2"),
        //array("type"=>"1","field"=>"last_update_2","method"=>"2")
        );
        //修改4，增加语句
        //保存修改后商品明细
        insert_appid_mx("appid","appid_sn,appid_name,url,type,sort_no",$time_field);
        
        $smarty->assign('fall', 'post');
        $smarty->display('appid_mx.tpl');
    }
    else
    {
        $smarty->assign('fall', 'fs');
        $smarty->display('appid_mx.tpl');   
    }
    
  
}



?>