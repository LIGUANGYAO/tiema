<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
include ('page.php');
require (dirname(__file__) . '/sub/sub_color.php');
require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
///修改1,查询语句
//sort_no,tzsy 要记得添加
    $sql="select id,color_sn,color_name,sort_no,tzsy,outer_color_code,color_note_1,last_update from color";
    
    $color_list = get_color_list($Num,"color",$sql);
    
    $smarty->assign('color_list', $color_list['items']);
    
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $color_list['page']);
    $smarty->display('color.html');


}

if ($_REQUEST['act'] == 'add_color_list') {

   $sql="select xmlx_sn ,xmlx_name from xmlx";
   $res_xmlx = $GLOBALS['db']->getAll($sql);
    $smarty->assign('res_xmlx', $res_xmlx);
    $smarty->assign('fall', 'add_color_list');
    $smarty->display('color_mx.html');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];
    
    ///修改2,查询语句
    $sql="select id,color_sn,color_name,sort_no,tzsy,outer_color_code,last_update,color_note_1
  from color ";
    $color_mx=get_color_mx("color",$sql);
    
   // print_r($color_mx);exit;
    $img_cod=$_REQUEST['color_sn'];
    
    
    
    $smarty->assign('color_mx', $color_mx['items'][0]);
    $smarty->assign('res_xmlx', $color_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('color_mx.html');
}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if(isset($_REQUEST['img_code']))
    {
        $img_code=trim($_REQUEST['img_code']);
                        
        $sql="delete from color_imgs where  img_outer_id= '".$img_code."'";     
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

if ($_REQUEST['act'] == 'delete_color') {

    //echo 1;
    if(isset($_REQUEST['color_sn']))
    {
        $color_sn=trim($_REQUEST['color_sn']);
                        
        $sql="delete from color where  color_sn= '".$color_sn."'";     
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
                        
        $sql="update  color_imgs set ss=".$alt."  where  img_outer_id= '".$img_code."'";     
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
if ($_REQUEST['act'] == 'color_xs') {

    //echo 1;
   
    if(isset($_REQUEST['color_code']) && isset($_REQUEST['alt']))
    {
        $color_code=trim($_REQUEST['color_code']);
        $alt=trim($_REQUEST['alt']);
                        
        $sql="update  color set tzsy=".$alt."  where  color_sn= '".$color_code."'";     
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

  
    //修改3，更新语句
     $time_field=array(
    //array("type"=>"2","field"=>"add_time","method"=>"1"),
    array("type"=>"2","field"=>"last_update","method"=>"2"),
    array("type"=>"1","field"=>"last_update_2","method"=>"2")
    );
    //print_r($time_field);exit;
    update_color_mx("color","color_name,sort_no,outer_color_code,color_note_1","color_sn",$time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('color_mx.html');
}


if ($_REQUEST['act'] == 'post_add') {
      if(isset($_REQUEST['color_sn']))
    {
        $p_id=trim($_REQUEST['color_sn']);
    }
    //print_r($p_id);
    //res_xmlx
    
    $get_one=" select color_sn from color where color_sn ='".$color_sn."'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($res);exit;
    if(empty($res))
    {
        
        //修改4，增加语句
        //保存修改后商品明细
           $time_field=array(
        array("type"=>"2","field"=>"add_time","method"=>"1"),
       // array("type"=>"2","field"=>"last_update","method"=>"2"),
        //array("type"=>"1","field"=>"last_update_2","method"=>"2")
        );
        //修改4，增加语句
        //保存修改后商品明细
        insert_color_mx("color","color_sn,color_name,sort_no,outer_color_code,color_note_1",$time_field);
        
        $smarty->assign('fall', 'post');
        $smarty->display('color_mx.html');
    }
    else
    {
         $smarty->assign('fall', 'fs');
        $smarty->display('color_mx.html');   
    }
    
  
}



?>