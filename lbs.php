<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_lbs.php');
require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
///修改1,查询语句
//sort_no,tzsy 要记得添加
    $sql="select id,lbs_sn,lbs_name,lbsaddress,lbsjd,lbswd,lbstel,sort_no,tzsy,last_update,lbs_note_1,type from lbs";
    
    $lbs_list = get_lbs_list($Num,"lbs",$sql);
    //print_r($lbs_list);
    $smarty->assign('lbs_list', $lbs_list['items']);
     $smarty->assign('fall', 1);
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $lbs_list['page']);
    $smarty->display('lbs.tpl');


}

if ($_REQUEST['act'] == 'add_lbs_list') {

   //$sql="select xmlx_sn ,xmlx_name from xmlx";
//   $res_xmlx = $GLOBALS['db']->getAll($sql);
//    $smarty->assign('res_xmlx', $res_xmlx);
    $smarty->assign('fall', 'add_lbs_list');
    $smarty->display('lbs_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];
    
    ///修改2,查询语句
    $sql="select id,lbs_sn,lbs_name,lbsaddress,lbsjd,lbswd,lbstel,sort_no,tzsy,last_update,lbs_note_1,type
  from lbs ";
    $lbs_mx=get_lbs_mx("lbs",$sql);
    
   // print_r($lbs_mx);exit;
    $img_cod=$_REQUEST['lbs_sn'];
    
    
    //图片部分。没图片则删除
    $lbs_imgs2 = get_lbs_imgs_list("lbs_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
//print_r($lbs_imgs2);
    $lbs_imgs = arr_push($lbs_imgs2['items']);
    $smarty->assign('lbs_imgs', $lbs_imgs);
    
    
    $smarty->assign('lbs_mx', $lbs_mx['items'][0]);
    $smarty->assign('res_xmlx', $lbs_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('lbs_mx.tpl');
}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if(isset($_REQUEST['img_code']))
    {
        $img_code=trim($_REQUEST['img_code']);
                        
        $sql="delete from lbs_imgs where  img_outer_id= '".$img_code."'";     
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

if ($_REQUEST['act'] == 'delete_lbs') {

    //echo 1;
    if(isset($_REQUEST['lbs_sn']))
    {
        $lbs_sn=trim($_REQUEST['lbs_sn']);
                        
        $sql="delete from lbs where  lbs_sn= '".$lbs_sn."'";     
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
                        
        $sql="update  lbs_imgs set ss=".$alt."  where  img_outer_id= '".$img_code."'";     
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
if ($_REQUEST['act'] == 'lbs_xs') {

    //echo 1;
   
    if(isset($_REQUEST['lbs_code']) && isset($_REQUEST['alt']))
    {
        $lbs_code=urldecode(trim($_REQUEST['lbs_code']));
        $alt=urldecode(trim($_REQUEST['alt']));
                        
        $sql="update  lbs set tzsy=".$alt."  where  lbs_sn= '".$lbs_code."'";     
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

    
    $p = new upload;
    $path=$p->upload_path='upload/lbs';
    $p->uplood_img();
    $img_array = $p->upload_file;
   
    for($i=0;$i<count($img_array['guige']);$i++)
    {
        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
    }
    $aaa = $_POST['lbs_sn'];
    // print_r($aaa);exit;
    //图片部分。没图片则删除
    img_insert($aaa, $img_array,"lbs_imgs");
    //修改3，更新语句
     $time_field=array(
    //array("type"=>"2","field"=>"add_time","method"=>"1"),
    array("type"=>"2","field"=>"last_update","method"=>"2"),
    array("type"=>"1","field"=>"last_update_2","method"=>"2")
    );
    //print_r($time_field);exit;
    update_lbs_mx("lbs","lbs_name,lbs_note_1,type,type_name,lbsaddress,lbsjd,lbswd,lbstel,sort_no","lbs_sn",$time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('lbs_mx.tpl');
}


if ($_REQUEST['act'] == 'post_add') {
      if(isset($_REQUEST['lbs_sn']))
    {
        $lbs_sn=trim($_REQUEST['lbs_sn']);
    }
    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one=" select lbs_sn from lbs where lbs_sn ='".$lbs_sn."'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($get_one);exit;
    if(empty($res))
    {
        //echo 1;
        $p = new upload;
        $path=$p->upload_path='upload/lbs';
        $p->uplood_img();
        $img_array = $p->upload_file;
        for($i=0;$i<count($img_array['guige']);$i++)
        {
        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
        }
        //print_r($img_array);exit;
        $aaa = $lbs_sn;
        
        //插入图片记录//图片部分。没图片则删除
         img_insert($aaa, $img_array,"lbs_imgs");
        //修改4，增加语句
        //保存修改后商品明细
           $time_field=array(
        array("type"=>"2","field"=>"add_time","method"=>"1"),
       // array("type"=>"2","field"=>"last_update","method"=>"2"),
        //array("type"=>"1","field"=>"last_update_2","method"=>"2")
        );
        //修改4，增加语句
        //保存修改后商品明细
        insert_lbs_mx("lbs","lbs_sn,lbs_name,lbs_note_1,type,type_name,lbsaddress,lbsjd,lbswd,lbstel,sort_no",$time_field);
        
        $smarty->assign('fall', 'post');
        $smarty->display('lbs_mx.tpl');
    }
    else
    {
        $smarty->assign('fall', 'post');
        $smarty->display('lbs_mx.tpl');   
    }
    
  
}



?>