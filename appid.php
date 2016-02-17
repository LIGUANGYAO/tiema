<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
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
    $sql="select id,appid_sn,weixin_id,app_id,app_secret from app_id";
    
     $url_this = "http://".$_SERVER ['HTTP_HOST']."".dirname($_SERVER['PHP_SELF'])."/wx_tiemal.php";
     
    $appid_list = get_appid_list($Num,"app_id",$sql);
    
    //print_r($appid_list);
    $token=md5(($appid_list['items'][0]['appid_sn'])."tiemal");
    //echo $token;
    //print_r($appid_list);
    $smarty->assign('appid_list', $appid_list['items']);
     $smarty->assign('fall', 1);
    $smarty->assign('title', $aaa);
    $smarty->assign('url_this', $url_this);
     $smarty->assign('token', $token);
    $smarty->assign('p_Array', $appid_list['page']);
    $smarty->display('appid.tpl');


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
    $sql="select  id,appid_sn,weixin_id,app_id,app_secret
  from app_id ";
    $appid_mx=get_appid_mx("appid",$sql);
    
   // print_r($appid_mx);exit;
    $img_cod=$_REQUEST['appid_sn'];
    
    
//    //图片部分。没图片则删除
//    $appid_imgs2 = get_appid_imgs_list("appid_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
////print_r($appid_imgs2);
//    $appid_imgs = arr_push($appid_imgs2['items']);
//    $smarty->assign('appid_imgs', $appid_imgs);
    
    
    $smarty->assign('appid_mx', $appid_mx['items'][0]);
    $smarty->assign('res_xmlx', $appid_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('appid_mx.tpl');
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
    
    $smarty->assign('fall', 'post');
    $smarty->display('appid_mx.tpl');
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