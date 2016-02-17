<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
//include ('page.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_goods.php');
require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
///修改1,查询语句
//sort_no,tzsy 要记得添加
    $sql="select id,goods_sn,goods_name,sort_no,tzsy,add_time,last_update,last_update_2,bzsj from goods";
    
    $goods_list = get_goods_list($Num,"goods",$sql);
    
    $smarty->assign('goods_list', $goods_list['items']);
    
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $goods_list['page']);
    $smarty->display('goods.html');


}

if ($_REQUEST['act'] == 'add_goods_list') {

  $sql_goodstype="select goodstype_sn ,goodstype_name from goodstype";
   $res_goodstype = $GLOBALS['db']->getAll($sql_goodstype);

    
    
   $sql="select xmlx_sn ,xmlx_name from xmlx";
   $res_xmlx = $GLOBALS['db']->getAll($sql);
    $smarty->assign('res_xmlx', $res_xmlx);
    $smarty->assign('fall', 'add_goods_list');
     $smarty->assign('goodstype', $res_goodstype);
    $smarty->display('goods_mx.html');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];
    
    ///修改2,查询语句
    $sql="select  id,goods_sn,goods_name,sort_no,tzsy,add_time,last_update,last_update_2,bzsj,goods_weight,dw,note,allow_sj,goods_outer_name,goods_name_eg,dj,dj2,dj3,dj4,dj5,bzsj,jj,jj2,jj3,jj4,jj5,is_gift,is_gift_allow_count,is_delete,goods_note_1,goods_note_2,goods_note_3,goodstype_sn,goodstype_name  
  from goods ";
    $goods_mx=get_goods_mx("goods",$sql);
    
   // print_r($goods_mx);exit;
    $img_cod=$_REQUEST['goods_sn'];
    //颜色列表
    $get_color_list="select color_sn,color_name from goods_color where  goods_sn ='".$img_cod."' ";
    $color_list = $GLOBALS['db']->getAll($get_color_list);
    //尺码列表
     $get_size_list="select size_sn,size_name from goods_size where  goods_sn ='".$img_cod."' ";
    $size_list = $GLOBALS['db']->getAll($get_size_list);
    
    //print_r($color_list);exit;
    //图片部分。没图片则删除
    $goods_imgs2 = get_goods_imgs_list("goods_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
//print_r($goods_imgs2);
    $goods_imgs = arr_push($goods_imgs2['items']);
    
     $sql_goodstype="select goodstype_sn ,goodstype_name from goodstype";
   $res_goodstype = $GLOBALS['db']->getAll($sql_goodstype);
    
    
    $smarty->assign('goods_imgs', $goods_imgs);
     $smarty->assign('goodstype', $res_goodstype);
    
    $smarty->assign('color_list',$color_list);
    $smarty->assign('size_list',$size_list);
    
    $smarty->assign('goods_mx', $goods_mx['items'][0]);
    $smarty->assign('res_xmlx', $goods_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('goods_mx.html');
}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if(isset($_REQUEST['img_code']))
    {
        $img_code=trim($_REQUEST['img_code']);
                        
        $sql="delete from goods_imgs where  img_outer_id= '".$img_code."'";     
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

if ($_REQUEST['act'] == 'delete_goods') {

    //echo 1;
    if(isset($_REQUEST['goods_sn']))
    {
        $goods_sn=trim($_REQUEST['goods_sn']);
                        
        $sql="delete from goods where  goods_sn= '".$goods_sn."'";     
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
                        
        $sql="update  goods_imgs set ss=".$alt."  where  img_outer_id= '".$img_code."'";     
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
if ($_REQUEST['act'] == 'goods_xs') {

    //echo 1;
   
    if(isset($_REQUEST['goods_code']) && isset($_REQUEST['alt']))
    {
        $goods_code=trim($_REQUEST['goods_code']);
        $alt=trim($_REQUEST['alt']);
                        
        $sql="update  goods set tzsy=".$alt."  where  goods_sn= '".$goods_code."'";     
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


if ($_REQUEST['act'] == 'gift') {

    //echo 1;
   
    if(isset($_REQUEST['goods_sn']) && isset($_REQUEST['alt']))
    {
        $goods_sn=trim($_REQUEST['goods_sn']);
        $alt=trim($_REQUEST['alt']);
                        
        $sql="update  goods set is_gift=".$alt."  where  goods_sn= '".$goods_sn."'";     
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

if ($_REQUEST['act'] == 'gift_count') {

    //echo 1;
   
    if(isset($_REQUEST['goods_sn']) && isset($_REQUEST['alt']))
    {
        $goods_sn=trim($_REQUEST['goods_sn']);
        $alt=trim($_REQUEST['alt']);
                        
        $sql="update  goods set is_gift_allow_count=".$alt."  where  goods_sn= '".$goods_sn."'";     
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
if ($_REQUEST['act'] == 'allow_sj') {

    //echo 1;
   
    if(isset($_REQUEST['goods_sn']) && isset($_REQUEST['alt']))
    {
        $goods_sn=trim($_REQUEST['goods_sn']);
        $alt=trim($_REQUEST['alt']);
                        
        $sql="update  goods set allow_sj=".$alt."  where  goods_sn= '".$goods_sn."'";     
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




if ($_REQUEST['act'] == 'ysss') {
//echo 1;exit;
    require (dirname(__file__) . '/sub/rest.php');
     if(isset($_REQUEST['color_sn'])){
       
        $color_sn= urldecode($_REQUEST['color_sn']);
        //print_r($color_sn);exit;
        if($color_sn=="all")
        //if(1==1)
        {
              $sql="select color_sn,color_name from color ";
              //print_r($sql);exit;
              $res = $GLOBALS['db']->getAll($sql);
        }
        else
        {
              $where="where color_sn like '%".$color_sn."%' or color_name like '%".$color_sn."%'";
              $sql="select color_sn,color_name from color ".$where;
              //print_r($sql);exit;
              $res = $GLOBALS['db']->getAll($sql);
        }
      
     }
     //$sql="select color_sn,color_name from color ";
     $res = $GLOBALS['db']->getAll($sql);
     $aaa=new arraytojson();
     $json=$aaa->JSON($res);
     
     print_r($json);
    //$smarty->assign('color_list', $res);
    //$smarty->assign('fall', 'ysss');
    //$smarty->display('ysss.html');

}
if ($_REQUEST['act'] == 'ysss2') {
//echo 1;exit;
    require (dirname(__file__) . '/sub/rest.php');
     if(isset($_REQUEST['size_sn'])){
       
        $size_sn= urldecode($_REQUEST['size_sn']);
        //print_r($color_sn);exit;
        if($size_sn=="all")
        //if(1==1)
        {
              $sql="select size_sn,size_name from size ";
              //print_r($sql);exit;
              $res = $GLOBALS['db']->getAll($sql);
        }
        else
        {
              $where="where size_sn like '%".$size_sn."%' or size_name like '%".$size_sn."%'";
              $sql="select size_sn,size_name from size ".$where;
              //print_r($sql);exit;
              $res = $GLOBALS['db']->getAll($sql);
        }
      
     }
     //$sql="select color_sn,color_name from color ";
     $res = $GLOBALS['db']->getAll($sql);
     $aaa=new arraytojson();
     $json=$aaa->JSON($res);
     
     print_r($json);
    //$smarty->assign('color_list', $res);
    //$smarty->assign('fall', 'ysss');
    //$smarty->display('ysss.html');

}



if ($_REQUEST['act'] == 'post') {

    
    $p = new upload;
    $path=$p->upload_path='upload/goods';
    $p->uplood_img();
    $img_array = $p->upload_file;
    for($i=0;$i<count($img_array['guige']);$i++)
    {
        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
    }
    $aaa = $_POST['goods_sn'];
    
    //图片部分。没图片则删除
    img_insert($aaa, $img_array,"goods_imgs");
    //修改3，更新语句
     $time_field=array(
    //array("type"=>"2","field"=>"add_time","method"=>"1"),
    array("type"=>"2","field"=>"last_update","method"=>"2"),
    array("type"=>"1","field"=>"last_update_2","method"=>"2")
    );
    //print_r($time_field);exit;
  //  echo 1;
//    if(isset($_REQUEST['dw'])){
//        echo $_REQUEST['dw'];
//    }
//    else
//    {
//        echo "wu";
//    }

    
      if(isset($_REQUEST['color_ids_sn']))
    {
        //echo 1;
        $color_ids_sn=$_REQUEST['color_ids_sn'];
        //print_r($color_ids_sn);exit;
    }
      if(isset($_REQUEST['size_ids_sn']))
    {
        //echo 1;
        $size_ids_sn=$_REQUEST['size_ids_sn'];
        //print_r($color_ids_sn);exit;
    }
    
    
  //    if(isset($_REQUEST['goodstype_sn']))
//    {
//        //echo 1;
//       echo  $goodstype_sn=$_REQUEST['goodstype_sn'];exit;
//        //print_r($color_ids_sn);exit;
//    }
    
    goods_color($aaa,$color_ids_sn);
    goods_size($aaa,$size_ids_sn);
    update_goods_mx("goods","goods_name,sort_no,bzsj,goods_weight,dw,goods_outer_name,note,goods_name_eg,dj,dj2,dj3,dj4,dj5,bzsj,jj,jj2,jj3,jj4,jj5,goods_note_1,goods_note_2,goodstype_sn,goods_note_3","goods_sn",$time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('goods_mx.html');
}


if ($_REQUEST['act'] == 'post_add') {
      if(isset($_REQUEST['goods_sn']))
    {
        $p_id=trim($_REQUEST['goods_sn']);
    }
    //print_r($p_id);
    //res_xmlx
    
    $get_one=" select goods_sn from goods where goods_sn ='".$goods_sn."'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($res);exit;
    if(empty($res))
    {
        //echo 1;
        $p = new upload;
        $path=$p->upload_path='upload/goods';
        $p->uplood_img();
        $img_array = $p->upload_file;
  
       //print_r($img_array);exit;
        $aaa = $_REQUEST['goods_sn'];
       // print_r($aaa);exit;
        //插入图片记录//图片部分。没图片则删除
         img_insert($aaa, $img_array,"goods_imgs");
        //修改4，增加语句
        //保存修改后商品明细
           if(isset($_REQUEST['color_ids_sn']))
    {
        //echo 1;
        $color_ids_sn=$_REQUEST['color_ids_sn'];
        //print_r($color_ids_sn);exit;
    }
      if(isset($_REQUEST['size_ids_sn']))
    {
        //echo 1;
        $size_ids_sn=$_REQUEST['size_ids_sn'];
        //print_r($color_ids_sn);exit;
    }
    
    goods_color($aaa,$color_ids_sn);
    goods_size($aaa,$size_ids_sn);
        
           $time_field=array(
        array("type"=>"2","field"=>"add_time","method"=>"1"),
       // array("type"=>"2","field"=>"last_update","method"=>"2"),
        //array("type"=>"1","field"=>"last_update_2","method"=>"2")
        );
        //修改4，增加语句
        //保存修改后商品明细
        insert_goods_mx("goods","goods_sn,goods_name,sort_no,goods_weight,dw,goods_outer_name,note,goods_name_eg,dj,dj2,dj3,dj4,dj5,bzsj,jj,jj2,jj3,jj4,jj5,goods_note_1,goods_note_2,goodstype_sn,goods_note_3",$time_field);
        
        $smarty->assign('fall', 'post');
        $smarty->display('goods_mx.html');
    }
    else
    {
         $smarty->assign('fall', 'fs');
        $smarty->display('goods_mx.html');   
    }
    
  
}



?>