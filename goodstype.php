<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
include ('page.php');
require (dirname(__file__) . '/sub/sub_goodstype.php');
require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
///修改1,查询语句
//sort_no,tzsy 要记得添加
    $sql="select id,p_id,goodstype_sn,goodstype_name,sort_no,tzsy,goodstype_note_1,last_update from goodstype";
    
    $goodstype_list = get_goodstype_list($Num,"goodstype",$sql);
    
    $smarty->assign('goodstype_list', $goodstype_list['items']);
    
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $goodstype_list['page']);
    $smarty->display('goodstype.html');


}

if ($_REQUEST['act'] == 'add_goodstype_list') {

   $sql="select xmlx_sn ,xmlx_name from xmlx";
   $res_xmlx = $GLOBALS['db']->getAll($sql);
    $smarty->assign('res_xmlx', $res_xmlx);
    $smarty->assign('fall', 'add_goodstype_list');
    $smarty->display('goodstype_mx.html');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];
    
    ///修改2,查询语句
    $sql="select id,goodstype_sn,goodstype_name,sort_no,tzsy,last_update,goodstype_note_1
  from goodstype ";
    $goodstype_mx=get_goodstype_mx("goodstype",$sql);
    
   // print_r($goodstype_mx);exit;
    $img_cod=$_REQUEST['goodstype_sn'];
    
     $goodstype_imgs2 = get_goodstype_imgs_list("goodstype_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
//print_r($goodstype_imgs2);
    $goodstype_imgs = arr_push($goodstype_imgs2['items']);
    $smarty->assign('goodstype_imgs', $goodstype_imgs);
    
    $smarty->assign('goodstype_mx', $goodstype_mx['items'][0]);
    $smarty->assign('res_xmlx', $goodstype_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('goodstype_mx.html');
}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if(isset($_REQUEST['img_code']))
    {
        $img_code=trim($_REQUEST['img_code']);
                        
        $sql="delete from goodstype_imgs where  img_outer_id= '".$img_code."'";     
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";                
    }
    else
    {
        echo "失败";
    }
    
    
    
    //$sql = "delete  from goodstype where goodstype_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}

if ($_REQUEST['act'] == 'delete_goodstype') {

    //echo 1;
    if(isset($_REQUEST['goodstype_sn']))
    {
        $goodstype_sn=trim($_REQUEST['goodstype_sn']);
                        
        $sql="delete from goodstype where  goodstype_sn= '".$goodstype_sn."'";     
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";                
    }
    else
    {
        echo "失败";
    }
    
    
    
    //$sql = "delete  from goodstype where goodstype_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}
if ($_REQUEST['act'] == 'img_xs') {

    //echo 1;
    if(isset($_REQUEST['img_code']) && isset($_REQUEST['alt']))
    {
        $img_code=trim($_REQUEST['img_code']);
        $alt=trim($_REQUEST['alt']);
                        
        $sql="update  goodstype_imgs set ss=".$alt."  where  img_outer_id= '".$img_code."'";     
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";                
    }
    else
    {
        echo "失败";
    }
    
    
    //$sql = "delete  from goodstype where goodstype_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}
if ($_REQUEST['act'] == 'goodstype_xs') {

    //echo 1;
   
    if(isset($_REQUEST['goodstype_code']) && isset($_REQUEST['alt']))
    {
        $goodstype_code=trim($_REQUEST['goodstype_code']);
        $alt=trim($_REQUEST['alt']);
                        
        $sql="update  goodstype set tzsy=".$alt."  where  goodstype_sn= '".$goodstype_code."'";     
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";                
    }
    else
    {
        echo "失败";
    }
    
    //$sql = "delete  from goodstype where goodstype_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}


if ($_REQUEST['act'] == 'post') {
$p = new upload;
    $path=$p->upload_path='upload/goodstype';
    $p->uplood_img();
    $img_array = $p->upload_file;
    for($i=0;$i<count($img_array['guige']);$i++)
    {
        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
    }
    $aaa = $_POST['goodstype_sn'];
    
    //图片部分。没图片则删除
    img_insert($aaa, $img_array,"goodstype_imgs");
  
    //修改3，更新语句
     $time_field=array(
    //array("type"=>"2","field"=>"add_time","method"=>"1"),
    array("type"=>"2","field"=>"last_update","method"=>"2"),
    array("type"=>"1","field"=>"last_update_2","method"=>"2")
    );
    //print_r($time_field);exit;
    update_goodstype_mx("goodstype","goodstype_name,sort_no,goodstype_note_1","goodstype_sn",$time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('goodstype_mx.html');
}


if ($_REQUEST['act'] == 'post_add') {
      if(isset($_REQUEST['goodstype_sn']))
    {
        $p_id=trim($_REQUEST['goodstype_sn']);
    }
    //print_r($p_id);
    //res_xmlx
    
    $get_one=" select goodstype_sn from goodstype where goodstype_sn ='".$goodstype_sn."'";
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
        insert_goodstype_mx("goodstype","goodstype_sn,goodstype_name,sort_no,goodstype_note_1",$time_field);
        
        $smarty->assign('fall', 'post');
        $smarty->display('goodstype_mx.html');
    }
    else
    {
         $smarty->assign('fall', 'fs');
        $smarty->display('goodstype_mx.html');   
    }
    
  
}



?>