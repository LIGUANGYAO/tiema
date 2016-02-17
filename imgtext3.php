<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init3.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_imgtext3.php');

require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
///修改1,查询语句
//sort_no,tzsy 要记得添加
    $sql="select id,imgtext3_sn,imgtext3_name,sort_no,tzsy,last_update,imgtext3_note_1,type from imgtext3";
    
    $imgtext3_list = get_imgtext3_list($Num,"imgtext3",$sql);
    //print_r($imgtext3_list);
    $smarty->assign('imgtext3_list', $imgtext3_list['items']);
     $smarty->assign('fall', 1);
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $imgtext3_list['page']);
    $smarty->display('imgtext3.tpl');


}

if ($_REQUEST['act'] == 'add_imgtext3_list') {

   //$sql="select xmlx_sn ,xmlx_name from xmlx";
//   $res_xmlx = $GLOBALS['db']->getAll($sql);
//    $smarty->assign('res_xmlx', $res_xmlx);
    $smarty->assign('fall', 'add_imgtext3_list');
    $smarty->display('imgtext3_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];
    
    ///修改2,查询语句
    $sql="select id,imgtext3_sn,imgtext3_name,sort_no,tzsy,last_update,imgtext3_note_1,type
  from imgtext3 ";
    $imgtext3_mx=get_imgtext3_mx("imgtext3",$sql);
    
   // print_r($imgtext3_mx);exit;
    $img_cod=$_REQUEST['imgtext3_sn'];
    
    
    //图片部分。没图片则删除
    $imgtext3_imgs2 = get_imgtext3_imgs_list("imgtext3_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_note_4,img_note_5,img_action_url,ss,img_outer_id,add_time,last_update,show_cover_pic",$img_cod);
//print_r($imgtext3_imgs2);
    $imgtext3_imgs = arr_push($imgtext3_imgs2['items']);
    
    //print_r($imgtext3_imgs);
    for($i=0;$i<count($imgtext3_imgs);$i++)
    {
        $imgtext3_imgs[$i]['ed']=  "editor_id". ($imgtext3_imgs[$i][0]+1);
    }
    $smarty->assign('imgtext3_imgs', $imgtext3_imgs);
    
    
 
    
    $smarty->assign('imgtext3_mx', $imgtext3_mx['items'][0]);
    $smarty->assign('res_xmlx', $imgtext3_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('imgtext3_mx.tpl');
}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if(isset($_REQUEST['img_code']))
    {
        $img_code=trim($_REQUEST['img_code']);
                        
        $sql="delete from imgtext3_imgs where  img_outer_id= '".$img_code."'";     
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

if ($_REQUEST['act'] == 'delete_imgtext3') {

    //echo 1;
    if(isset($_REQUEST['imgtext3_sn']))
    {
        $imgtext3_sn=trim($_REQUEST['imgtext3_sn']);
                        
        $sql="delete from imgtext3 where  imgtext3_sn= '".$imgtext3_sn."'";     
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
                        
        $sql="update  imgtext3_imgs set ss=".$alt."  where  img_outer_id= '".$img_code."'";     
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
if ($_REQUEST['act'] == 'imgtext3_xs') {

    //echo 1;
   
    if(isset($_REQUEST['imgtext3_code']) && isset($_REQUEST['alt']))
    {
        $imgtext3_code=urldecode(trim($_REQUEST['imgtext3_code']));
        $alt=urldecode(trim($_REQUEST['alt']));
                        
        $sql="update  imgtext3 set tzsy=".$alt."  where  imgtext3_sn= '".$imgtext3_code."'";     
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
    $path=$p->upload_path='upload/imgtext3';
    $p->uplood_img();
    $img_array = $p->upload_file;
   
    for($i=0;$i<count($img_array['guige']);$i++)
    {
        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
    }
    $aaa = $_POST['imgtext3_sn'];
    // print_r($aaa);exit;
    //图片部分。没图片则删除
    img_insert($aaa, $img_array,"imgtext3_imgs");
    //修改3，更新语句
     $time_field=array(
    //array("type"=>"2","field"=>"add_time","method"=>"1"),
    array("type"=>"2","field"=>"last_update","method"=>"2"),
    array("type"=>"1","field"=>"last_update_2","method"=>"2")
    );
    //print_r($time_field);exit;
    update_imgtext3_mx("imgtext3","imgtext3_name,imgtext3_note_1,type,type_name,sort_no","imgtext3_sn",$time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('imgtext3_mx.tpl');
}


if ($_REQUEST['act'] == 'post_add') {
      if(isset($_REQUEST['imgtext3_sn']))
    {
        $imgtext3_sn=trim($_REQUEST['imgtext3_sn']);
    }
    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one=" select imgtext3_sn from imgtext3 where imgtext3_sn ='".$imgtext3_sn."'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($get_one);exit;
    if(empty($res))
    {
        //echo 1;
        $p = new upload;
        $path=$p->upload_path='upload/imgtext3';
        $p->uplood_img();
        $img_array = $p->upload_file;
        for($i=0;$i<count($img_array['guige']);$i++)
        {
        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
        }
        //print_r($img_array);exit;
        $aaa = $imgtext3_sn;
        
        //插入图片记录//图片部分。没图片则删除
         img_insert($aaa, $img_array,"imgtext3_imgs");
        //修改4，增加语句
        //保存修改后商品明细
           $time_field=array(
        array("type"=>"2","field"=>"add_time","method"=>"1"),
       // array("type"=>"2","field"=>"last_update","method"=>"2"),
        //array("type"=>"1","field"=>"last_update_2","method"=>"2")
        );
        //修改4，增加语句
        //保存修改后商品明细
        insert_imgtext3_mx("imgtext3","imgtext3_sn,imgtext3_name,imgtext3_note_1,type,type_name,sort_no",$time_field);
        
        $smarty->assign('fall', 'post');
        $smarty->display('imgtext3_mx.tpl');
    }
    else
    {
        $smarty->assign('fall', 'post');
        $smarty->display('imgtext3_mx.tpl');   
    }
    
  
}



?>