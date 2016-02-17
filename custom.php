<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_custom.php');
require (dirname(__file__) . '/sub/sub_tree_menu.php');


require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
///修改1,查询语句
//sort_no,tzsy 要记得添加
    $sql="select id,custom_sn,custom_name,sort_no,tzsy,last_update,custom_note_1,type,re_type,re_code,p_id from custom ";
    
    $custom_list = get_custom_list($Num,"custom",$sql);
    
    //$custom_list['items']=getTree($custom_list['items'],0);
    //print_r($custom_list);
    function re($obj1){
         $sql_t="select text_sn as sn,title as name from text_reply where tzsy=0 and text_sn='".$obj1."'";
        $sql_t = $GLOBALS['db']->getRow($sql_t);
        
        return $sql_t;
        
    }
    function re2($obj2){
        $sql_t2="select imgtext_sn as sn,imgtext_name as name from imgtext where tzsy=0 and imgtext_sn='".$obj2."'";
        $sql_t2 = $GLOBALS['db']->getRow($sql_t2);
        return $sql_t2;
    }
    
     function re3($obj3){
        $sql_t="select actionurl_sn as sn,actionurl_name as name from actionurl where tzsy=0 and actionurl_sn='".$obj3."'";
        $sql_t = $GLOBALS['db']->getRow($sql_t);
        return $sql_t;
    }
    
     function re4($obj4){
        $sql_t="select article_sn as sn,article_name as name from article where tzsy=0 and article_sn='".$obj4."'";
        $sql_t = $GLOBALS['db']->getRow($sql_t);
        return $sql_t;
    }

     for($i=0;$i<count($custom_list['items']);$i++)
     {
      
        if($custom_list['items'][$i]['re_type']=="imgtext")
        {
            $custom_list['items'][$i]['re_type_name']="图文";
            $custom_list['items'][$i]['re_code_name']=re2($custom_list['items'][$i]['re_code']);
        }
        elseif($custom_list['items'][$i]['re_type']=="text")
        {
            $custom_list['items'][$i]['re_type_name']="文本";
             $custom_list['items'][$i]['re_code_name']=re($custom_list['items'][$i]['re_code']);
        }
        elseif($custom_list['items'][$i]['re_type']=="url")
        {
            $custom_list['items'][$i]['re_type_name']="URL";
             $custom_list['items'][$i]['re_code_name']=re3($custom_list['items'][$i]['re_code']);
        }
         elseif($custom_list['items'][$i]['re_type']=="html")
        {
            $custom_list['items'][$i]['re_type_name']="HTML";
             $custom_list['items'][$i]['re_code_name']=re4($custom_list['items'][$i]['re_code']);
        }
       
        
     }

    //print_r($custom_list);
    $smarty->assign('custom_list', $custom_list['items']);
     $smarty->assign('fall', 1);
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $custom_list['page']);
    $smarty->display('custom.tpl');


}

if ($_REQUEST['act'] == 'add_custom_list') {

   //$sql="select xmlx_sn ,xmlx_name from xmlx";
//   $res_xmlx = $GLOBALS['db']->getAll($sql);
//    $smarty->assign('res_xmlx', $res_xmlx);
    $smarty->assign('fall', 'add_custom_list');
    $smarty->display('custom_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];
    
    ///修改2,查询语句
    $sql="select id,custom_sn,custom_name,sort_no,tzsy,last_update,custom_note_1,type,re_type,re_code,p_id
  from custom ";
    $custom_mx=get_custom_mx("custom",$sql);
    
    
    $sql="select id,custom_sn,custom_name from custom ";
    
    $custom_list = get_custom_list($Num,"custom",$sql);
    
   // print_r($custom_mx);exit;
    $img_cod=$_REQUEST['custom_sn'];
    
    
   // //图片部分。没图片则删除
//    $custom_imgs2 = get_custom_imgs_list("custom_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
////print_r($custom_imgs2);
//    $custom_imgs = arr_push($custom_imgs2['items']);
//    $smarty->assign('custom_imgs', $custom_imgs);
    
    $smarty->assign('custom_list', $custom_list['items']);
    $smarty->assign('custom_mx', $custom_mx['items'][0]);
    $smarty->assign('res_xmlx', $custom_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('custom_mx.tpl');
}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if(isset($_REQUEST['img_code']))
    {
        $img_code=trim($_REQUEST['img_code']);
                        
        $sql="delete from custom_imgs where  img_outer_id= '".$img_code."'";     
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

if ($_REQUEST['act'] == 'delete_custom') {

    //echo 1;
    if(isset($_REQUEST['custom_sn']))
    {
        $custom_sn=trim($_REQUEST['custom_sn']);
                        
        $sql="delete from custom where  custom_sn= '".$custom_sn."'";     
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
                        
        $sql="update  custom_imgs set ss=".$alt."  where  img_outer_id= '".$img_code."'";     
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
if ($_REQUEST['act'] == 'custom_xs') {

    //echo 1;
   
    if(isset($_REQUEST['custom_code']) && isset($_REQUEST['alt']))
    {
        $custom_code=urldecode(trim($_REQUEST['custom_code']));
        $alt=urldecode(trim($_REQUEST['alt']));
                        
        $sql="update  custom set tzsy=".$alt."  where  custom_sn= '".$custom_code."'";     
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

    
  //  $p = new upload;
//    $path=$p->upload_path='upload/custom';
//    $p->uplood_img();
//    $img_array = $p->upload_file;
//   
//    for($i=0;$i<count($img_array['guige']);$i++)
//    {
//        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
//    }
//    $aaa = $_POST['custom_sn'];
//    // print_r($aaa);exit;
//    //图片部分。没图片则删除
//    img_insert($aaa, $img_array,"custom_imgs");
    //修改3，更新语句
     $time_field=array(
    //array("type"=>"2","field"=>"add_time","method"=>"1"),
    array("type"=>"2","field"=>"last_update","method"=>"2"),
    array("type"=>"1","field"=>"last_update_2","method"=>"2")
    );
    //print_r($time_field);exit;
    //update_custom_mx("custom","custom_name,custom_note_1,type,sort_no,re_type,re_code","custom_sn",$time_field);
    update_custom_mx("custom","custom_name,custom_note_1,type,sort_no,re_type,re_code,p_id","custom_sn",$time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('custom_mx.tpl');
}


if ($_REQUEST['act'] == 'post_add') {
      if(isset($_REQUEST['custom_sn']))
    {
        $custom_sn=trim($_REQUEST['custom_sn']);
    }
      if(isset($_REQUEST['custom_name']))
    {
        $custom_name=trim($_REQUEST['custom_name']);
    }
    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one=" select custom_sn from custom where custom_sn ='".$custom_sn."' or custom_name ='".$custom_name."'  ";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($get_one);exit;
    if(empty($res))
    {
       // //echo 1;
//        $p = new upload;
//        $path=$p->upload_path='upload/custom';
//        $p->uplood_img();
//        $img_array = $p->upload_file;
//        for($i=0;$i<count($img_array['guige']);$i++)
//        {
//        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
//        }
//        //print_r($img_array);exit;
//        $aaa = $custom_sn;
//        
//        //插入图片记录//图片部分。没图片则删除
//         img_insert($aaa, $img_array,"custom_imgs");
        //修改4，增加语句
        //保存修改后商品明细
           $time_field=array(
        array("type"=>"2","field"=>"add_time","method"=>"1"),
       // array("type"=>"2","field"=>"last_update","method"=>"2"),
        //array("type"=>"1","field"=>"last_update_2","method"=>"2")
        );
        //修改4，增加语句
        //保存修改后商品明细
        //insert_custom_mx("custom","custom_sn,custom_name,custom_note_1,sort_no,re_type,re_code",$time_field);
        insert_custom_mx("custom","custom_sn,custom_name,custom_note_1,sort_no,re_type,re_code,p_id",$time_field);
        
        $smarty->assign('fall', 'post');
        $smarty->display('custom_mx.tpl');
    }
    else
    {
        $smarty->assign('fall', 'fs');
        $smarty->display('custom_mx.tpl');   
    }
    
  
}

if ($_REQUEST['act'] == 'get_type') {

    //echo 1;exit;
    //if(isset($_REQUEST['province'])){
    require (dirname(__file__) . '/sub/rest.php');
    $type = urldecode($_REQUEST['type']);
    
    if($type=="text")
    {
        $sql_t="select text_sn as sn,title as name from text_reply where tzsy=0";
        $sql_t = $GLOBALS['db']->getAll($sql_t);
         $aaa = new arraytojson();
         $json = $aaa->JSON($sql_t);

    print_r($json);
        
    }
    elseif($type=="imgtext")
    {
        $sql_t="select imgtext_sn as sn,imgtext_name as name from imgtext where tzsy=0";
        $sql_t = $GLOBALS['db']->getAll($sql_t);
        $aaa = new arraytojson();
        $json = $aaa->JSON($sql_t);

    print_r($json);
    }
     elseif($type=="url")
    {
        $sql_t="select actionurl_sn as sn,actionurl_name as name from actionurl where tzsy=0";
        $sql_t = $GLOBALS['db']->getAll($sql_t);
        $aaa = new arraytojson();
        $json = $aaa->JSON($sql_t);

    print_r($json);
    }
     elseif($type=="html")
    {
        $sql_t="select article_sn as sn,article_name as name from article where tzsy=0";
        $sql_t = $GLOBALS['db']->getAll($sql_t);
        $aaa = new arraytojson();
        $json = $aaa->JSON($sql_t);

    print_r($json);
    }
  
  
}


?>