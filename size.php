<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
include ('page.php');
require (dirname(__file__) . '/sub/sub_size.php');
require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
///修改1,查询语句
//sort_no,tzsy 要记得添加
    $sql="select id,size_sn,size_name,sort_no,tzsy,outer_size_code,size_note_1,last_update from size";
    
    $size_list = get_size_list($Num,"size",$sql);
    
    $smarty->assign('size_list', $size_list['items']);
    
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $size_list['page']);
    $smarty->display('size.html');


}

if ($_REQUEST['act'] == 'add_size_list') {

   $sql="select xmlx_sn ,xmlx_name from xmlx";
   $res_xmlx = $GLOBALS['db']->getAll($sql);
    $smarty->assign('res_xmlx', $res_xmlx);
    $smarty->assign('fall', 'add_size_list');
    $smarty->display('size_mx.html');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];
    
    ///修改2,查询语句
    $sql="select id,size_sn,size_name,sort_no,tzsy,outer_size_code,last_update,size_note_1
  from size ";
    $size_mx=get_size_mx("size",$sql);
    
   // print_r($size_mx);exit;
    $img_cod=$_REQUEST['size_sn'];
    
    
    
    $smarty->assign('size_mx', $size_mx['items'][0]);
    $smarty->assign('res_xmlx', $size_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('size_mx.html');
}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if(isset($_REQUEST['img_code']))
    {
        $img_code=trim($_REQUEST['img_code']);
                        
        $sql="delete from size_imgs where  img_outer_id= '".$img_code."'";     
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";                
    }
    else
    {
        echo "失败";
    }
    
    
    
    //$sql = "delete  from size where size_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}

if ($_REQUEST['act'] == 'delete_size') {

    //echo 1;
    if(isset($_REQUEST['size_sn']))
    {
        $size_sn=trim($_REQUEST['size_sn']);
                        
        $sql="delete from size where  size_sn= '".$size_sn."'";     
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";                
    }
    else
    {
        echo "失败";
    }
    
    
    
    //$sql = "delete  from size where size_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}
if ($_REQUEST['act'] == 'img_xs') {

    //echo 1;
    if(isset($_REQUEST['img_code']) && isset($_REQUEST['alt']))
    {
        $img_code=trim($_REQUEST['img_code']);
        $alt=trim($_REQUEST['alt']);
                        
        $sql="update  size_imgs set ss=".$alt."  where  img_outer_id= '".$img_code."'";     
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";                
    }
    else
    {
        echo "失败";
    }
    
    
    //$sql = "delete  from size where size_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}
if ($_REQUEST['act'] == 'size_xs') {

    //echo 1;
   
    if(isset($_REQUEST['size_code']) && isset($_REQUEST['alt']))
    {
        $size_code=trim($_REQUEST['size_code']);
        $alt=trim($_REQUEST['alt']);
                        
        $sql="update  size set tzsy=".$alt."  where  size_sn= '".$size_code."'";     
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";                
    }
    else
    {
        echo "失败";
    }
    
    //$sql = "delete  from size where size_code='001000';";
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
    update_size_mx("size","size_name,sort_no,outer_size_code,size_note_1","size_sn",$time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('size_mx.html');
}


if ($_REQUEST['act'] == 'post_add') {
      if(isset($_REQUEST['size_sn']))
    {
        $p_id=trim($_REQUEST['size_sn']);
    }
    //print_r($p_id);
    //res_xmlx
    
    $get_one=" select size_sn from size where size_sn ='".$size_sn."'";
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
        insert_size_mx("size","size_sn,size_name,sort_no,outer_size_code,size_note_1",$time_field);
        
        $smarty->assign('fall', 'post');
        $smarty->display('size_mx.html');
    }
    else
    {
         $smarty->assign('fall', 'fs');
        $smarty->display('size_mx.html');   
    }
    
  
}



?>