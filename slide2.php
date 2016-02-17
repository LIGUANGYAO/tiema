<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_slide2.php');

require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
///修改1,查询语句
//sort_no,tzsy 要记得添加
    $sql="select id,slide2_sn,slide2_name,sort_no,tzsy,last_update,slide2_note_1,type,action_url from slide2";
    $slide2_list = get_slide2_list($Num,"slide2",$sql);
    //print_r($slide2_list);
    $smarty->assign('slide2_list', $slide2_list['items']);
     $smarty->assign('fall', 1);
    
     $smarty->assign('title', $aaa);
   
    $smarty->assign('p_Array', $slide2_list['page']);
    $smarty->display('slide2.tpl');


}

if ($_REQUEST['act'] == 'add_slide2_list') {

   //$sql="select xmlx_sn ,xmlx_name from xmlx";
//   $res_xmlx = $GLOBALS['db']->getAll($sql);
//  $smarty->assign('res_xmlx', $res_xmlx);
    $smarty->assign('fall', 'add_slide2_list');
    $smarty->display('slide2_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];
    
    ///修改2,查询语句
    $sql="select id,slide2_sn,slide2_name,sort_no,tzsy,last_update,slide2_note_1,type,action_url
  from slide2 ";
    $slide2_mx=get_slide2_mx("slide2",$sql);
    
   // print_r($slide2_mx);exit;
    $img_cod=$_REQUEST['slide2_sn'];
    
    
    //图片部分。没图片则删除
    $slide2_imgs2 = get_slide2_imgs_list("slide2_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
//print_r($slide2_imgs2);
    $slide2_imgs = arr_push($slide2_imgs2['items']);
    $smarty->assign('slide2_imgs', $slide2_imgs);
    
    
    $smarty->assign('slide2_mx', $slide2_mx['items'][0]);
    $smarty->assign('res_xmlx', $slide2_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('slide2_mx.tpl');
}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if(isset($_REQUEST['img_code']))
    {
        $img_code=trim($_REQUEST['img_code']);
                        
        $sql="delete from slide2_imgs where  img_outer_id= '".$img_code."'";     
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

if ($_REQUEST['act'] == 'delete_slide2') {

    //echo 1;
    if(isset($_REQUEST['slide2_sn']))
    {
        $slide2_sn=trim($_REQUEST['slide2_sn']);
                        
        $sql="delete from slide2 where  slide2_sn= '".$slide2_sn."'";     
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
                        
        $sql="update  slide2_imgs set ss=".$alt."  where  img_outer_id= '".$img_code."'";     
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
if ($_REQUEST['act'] == 'slide2_xs') {

    //echo 1;
   
    if(isset($_REQUEST['slide2_code']) && isset($_REQUEST['alt']))
    {
        $slide2_code=urldecode(trim($_REQUEST['slide2_code']));
        $alt=urldecode(trim($_REQUEST['alt']));
                        
        $sql="update  slide2 set tzsy=".$alt."  where  slide2_sn= '".$slide2_code."'";     
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
    $path=$p->upload_path='upload/slide2';
    $p->uplood_img();
    $img_array = $p->upload_file;
   
    for($i=0;$i<count($img_array['guige']);$i++)
    {
        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
    }
    $aaa = $_POST['slide2_sn'];
    // print_r($aaa);exit;
    //图片部分。没图片则删除
    img_insert($aaa, $img_array,"slide2_imgs");
    //修改3，更新语句
     $time_field=array(
    //array("type"=>"2","field"=>"add_time","method"=>"1"),
    array("type"=>"2","field"=>"last_update","method"=>"2"),
    array("type"=>"1","field"=>"last_update_2","method"=>"2")
    );
    update_slide2_mx("slide2","slide2_name,slide2_note_1,type,type_name,sort_no,action_url","slide2_sn",$time_field);
    $smarty->assign('fall', 'post');
    $smarty->display('slide2_mx.tpl');
}


if ($_REQUEST['act'] == 'post_add') {
      if(isset($_REQUEST['slide2_sn']))
    {
        $slide2_sn=trim($_REQUEST['slide2_sn']);
    }
   
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one=" select slide2_sn from slide2 where slide2_sn ='".$slide2_sn."'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($get_one);exit;
    if(empty($res))
    {
        //echo 1;
        $p = new upload;
        $path=$p->upload_path='upload/slide2';
        $p->uplood_img();
        $img_array = $p->upload_file;
        for($i=0;$i<count($img_array['guige']);$i++)
        {
        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
        }
        //print_r($img_array);exit;
        $aaa = $slide2_sn;
        //插入图片记录//图片部分。没图片则删除
        img_insert($aaa, $img_array,"slide2_imgs");
        //修改4，增加语句
        //保存修改后商品明细
        $time_field=array(
        array("type"=>"2","field"=>"add_time","method"=>"1"),
       // array("type"=>"2","field"=>"last_update","method"=>"2"),
        //array("type"=>"1","field"=>"last_update_2","method"=>"2")
        );
        //修改4，增加语句
        //保存修改后商品明细
        insert_slide2_mx("slide2","slide2_sn,slide2_name,slide2_note_1,type,type_name,sort_no,action_url",$time_field);
        
        $smarty->assign('fall', 'post');
        $smarty->display('slide2_mx.tpl');
    }
    else
    {
        $smarty->assign('fall', 'post');
        $smarty->display('slide2_mx.tpl');   
    }
    
  
}


?>