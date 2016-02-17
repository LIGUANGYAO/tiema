<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_imgtext.php');

require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
///修改1,查询语句
//sort_no,tzsy 要记得添加
    $sql="select id,imgtext_sn,imgtext_name,sort_no,tzsy,last_update,imgtext_note_1,type from imgtext";
    
    $imgtext_list = get_imgtext_list($Num,"imgtext",$sql);
    //print_r($imgtext_list);
    $smarty->assign('imgtext_list', $imgtext_list['items']);
    
       //获取用户组
    $group=get_group ();
    $smarty->assign('group', $group);
    
    
     $smarty->assign('fall', 1);
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $imgtext_list['page']);
    $smarty->display('imgtext.tpl');


}

if ($_REQUEST['act'] == 'add_imgtext_list') {

   //$sql="select xmlx_sn ,xmlx_name from xmlx";
//   $res_xmlx = $GLOBALS['db']->getAll($sql);
//    $smarty->assign('res_xmlx', $res_xmlx);
    $smarty->assign('fall', 'add_imgtext_list');
    $smarty->display('imgtext_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];
    
    ///修改2,查询语句
    $sql="select id,imgtext_sn,imgtext_name,sort_no,tzsy,last_update,imgtext_note_1,type
  from imgtext ";
    $imgtext_mx=get_imgtext_mx("imgtext",$sql);
    
   // print_r($imgtext_mx);exit;
    $img_cod=$_REQUEST['imgtext_sn'];
    
    
    //图片部分。没图片则删除
    $imgtext_imgs2 = get_imgtext_imgs_list("imgtext_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
//print_r($imgtext_imgs2);
    $imgtext_imgs = arr_push($imgtext_imgs2['items']);
    $smarty->assign('imgtext_imgs', $imgtext_imgs);
    
    
    $smarty->assign('imgtext_mx', $imgtext_mx['items'][0]);
    $smarty->assign('res_xmlx', $imgtext_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('imgtext_mx.tpl');
}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if(isset($_REQUEST['img_code']))
    {
        $img_code=trim($_REQUEST['img_code']);
                        
        $sql="delete from imgtext_imgs where  img_outer_id= '".$img_code."'";     
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

if ($_REQUEST['act'] == 'delete_imgtext') {

    //echo 1;
    if(isset($_REQUEST['imgtext_sn']))
    {
        $imgtext_sn=trim($_REQUEST['imgtext_sn']);
                        
        $sql="delete from imgtext where  imgtext_sn= '".$imgtext_sn."'";     
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
                        
        $sql="update  imgtext_imgs set ss=".$alt."  where  img_outer_id= '".$img_code."'";     
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
if ($_REQUEST['act'] == 'imgtext_xs') {

    //echo 1;
   
    if(isset($_REQUEST['imgtext_code']) && isset($_REQUEST['alt']))
    {
        $imgtext_code=urldecode(trim($_REQUEST['imgtext_code']));
        $alt=urldecode(trim($_REQUEST['alt']));
                        
        $sql="update  imgtext set tzsy=".$alt."  where  imgtext_sn= '".$imgtext_code."'";     
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
    $path=$p->upload_path='upload/imgtext';
    $p->uplood_img();
    $img_array = $p->upload_file;
   
    for($i=0;$i<count($img_array['guige']);$i++)
    {
        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
    }
    $aaa = $_POST['imgtext_sn'];
    // print_r($aaa);exit;
    //图片部分。没图片则删除
    img_insert($aaa, $img_array,"imgtext_imgs");
    //修改3，更新语句
     $time_field=array(
    //array("type"=>"2","field"=>"add_time","method"=>"1"),
    array("type"=>"2","field"=>"last_update","method"=>"2"),
    array("type"=>"1","field"=>"last_update_2","method"=>"2")
    );
    //print_r($time_field);exit;
    update_imgtext_mx("imgtext","imgtext_name,imgtext_note_1,type,type_name,sort_no","imgtext_sn",$time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('imgtext_mx.tpl');
}


if ($_REQUEST['act'] == 'post_add') {
      if(isset($_REQUEST['imgtext_sn']))
    {
        $imgtext_sn=trim($_REQUEST['imgtext_sn']);
    }
    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one=" select imgtext_sn from imgtext where imgtext_sn ='".$imgtext_sn."'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($get_one);exit;
    if(empty($res))
    {
        //echo 1;
        $p = new upload;
        $path=$p->upload_path='upload/imgtext';
        $p->uplood_img();
        $img_array = $p->upload_file;
        for($i=0;$i<count($img_array['guige']);$i++)
        {
        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
        }
        //print_r($img_array);exit;
        $aaa = $imgtext_sn;
        
        //插入图片记录//图片部分。没图片则删除
         img_insert($aaa, $img_array,"imgtext_imgs");
        //修改4，增加语句
        //保存修改后商品明细
           $time_field=array(
        array("type"=>"2","field"=>"add_time","method"=>"1"),
       // array("type"=>"2","field"=>"last_update","method"=>"2"),
        //array("type"=>"1","field"=>"last_update_2","method"=>"2")
        );
        //修改4，增加语句
        //保存修改后商品明细
        insert_imgtext_mx("imgtext","imgtext_sn,imgtext_name,imgtext_note_1,type,type_name,sort_no",$time_field);
        
        $smarty->assign('fall', 'post');
        $smarty->display('imgtext_mx.tpl');
    }
    else
    {
        $smarty->assign('fall', 'post');
        $smarty->display('imgtext_mx.tpl');   
    }
    
  
}



?>