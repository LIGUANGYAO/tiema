<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_wxfloor2.php');

//require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
///修改1,查询语句
//sort_no,tzsy 要记得添加
    $sql="select id,wxfloor2_sn,wxfloor2_name,sort_no,tzsy,last_update,wxfloor2_note_1,type,type2 from wxfloor2";
    
    $wxfloor2_list = get_wxfloor2_list($Num,"wxfloor2",$sql);
   

    
       //获取用户组
    $group=get_group ();
    $smarty->assign('group', $group);
    
     function get_fl($obj)
        {
            $sql="select wxfloor_sn ,wxfloor_name,type from wxfloor where tzsy=0 and wxfloor_sn='".$obj."'";
            $res = $GLOBALS['db']->getRow($sql);
            return $res;
        }
    for($i=0;$i<count($wxfloor2_list['items']);$i++)
    {
       
        $arr=get_fl($wxfloor2_list['items'][$i]['type2']);
        $wxfloor2_list['items'][$i]['wxfloor_sn']=$arr['wxfloor_sn'];
        $wxfloor2_list['items'][$i]['wxfloor_name']=$arr['wxfloor_name'];
    }
    //获取floor的数据
    //$sql="select wxfloor_sn ,wxfloor_name,type from wxfloor where tzsy=0 and wxfloor_sn='".."'";
//    $res_wxfloor = $GLOBALS['db']->getAll($sql);
//    $smarty->assign('res_wxfloor', $res_wxfloor);
//    
     //print_r($wxfloor2_list);
     
     
         $smarty->assign('wxfloor2_list', $wxfloor2_list['items']);
     $smarty->assign('fall', 1);
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $wxfloor2_list['page']);
    $smarty->display('wxfloor2.tpl');


}

if ($_REQUEST['act'] == 'add_wxfloor2_list') {

   $sql="select wxfloor_sn ,wxfloor_name from wxfloor";
   $res_wxfloor = $GLOBALS['db']->getAll($sql);
    $smarty->assign('res_wxfloor', $res_wxfloor);
    
    
    $smarty->assign('fall', 'add_wxfloor2_list');
    $smarty->display('wxfloor2_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];
    
    ///修改2,查询语句
    $sql="select id,wxfloor2_sn,wxfloor2_name,sort_no,tzsy,last_update,wxfloor2_note_1,type,type2
  from wxfloor2 ";
    $wxfloor2_mx=get_wxfloor2_mx("wxfloor2",$sql);
    
   // print_r($wxfloor2_mx);exit;
    $img_cod=$_REQUEST['wxfloor2_sn'];
    
    function get_fl($obj)
        {
            $sql="select wxfloor_sn ,wxfloor_name,type from wxfloor where tzsy=0 and wxfloor_sn='".$obj."'";
            $res = $GLOBALS['db']->getRow($sql);
            return $res;
        }
    for($i=0;$i<count($wxfloor2_mx['items']);$i++)
    {
       
        $arr=get_fl($wxfloor2_mx['items'][$i]['type2']);
        $wxfloor2_mx['items'][$i]['wxfloor_sn']=$arr['wxfloor_sn'];
        $wxfloor2_mx['items'][$i]['wxfloor_name']=$arr['wxfloor_name'];
    }

    
    
    $smarty->assign('wxfloor2_mx', $wxfloor2_mx['items'][0]);
    $smarty->assign('res_xmlx', $wxfloor2_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('wxfloor2_mx.tpl');
}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if(isset($_REQUEST['img_code']))
    {
        $img_code=trim($_REQUEST['img_code']);
                        
        $sql="delete from wxfloor2_imgs where  img_outer_id= '".$img_code."'";     
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

if ($_REQUEST['act'] == 'delete_wxfloor2') {

    //echo 1;
    if(isset($_REQUEST['wxfloor2_sn']))
    {
        $wxfloor2_sn=trim($_REQUEST['wxfloor2_sn']);
                        
        $sql="delete from wxfloor2 where  wxfloor2_sn= '".$wxfloor2_sn."'";     
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
                        
        $sql="update  wxfloor2_imgs set ss=".$alt."  where  img_outer_id= '".$img_code."'";     
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
if ($_REQUEST['act'] == 'wxfloor2_xs') {

    //echo 1;
   
    if(isset($_REQUEST['wxfloor2_code']) && isset($_REQUEST['alt']))
    {
        $wxfloor2_code=urldecode(trim($_REQUEST['wxfloor2_code']));
        $alt=urldecode(trim($_REQUEST['alt']));
                        
        $sql="update  wxfloor2 set tzsy=".$alt."  where  wxfloor2_sn= '".$wxfloor2_code."'";     
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

    
//    $p = new upload;
//    $path=$p->upload_path='upload/wxfloor2';
//    $p->uplood_img();
//    $img_array = $p->upload_file;
//   
//    for($i=0;$i<count($img_array['guige']);$i++)
//    {
//        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
//    }
//    $aaa = $_POST['wxfloor2_sn'];
//    // print_r($aaa);exit;
//    //图片部分。没图片则删除
//    img_insert($aaa, $img_array,"wxfloor2_imgs");
    //修改3，更新语句
     $time_field=array(
    //array("type"=>"2","field"=>"add_time","method"=>"1"),
    array("type"=>"2","field"=>"last_update","method"=>"2"),
    array("type"=>"1","field"=>"last_update_2","method"=>"2")
    );
    //print_r($time_field);exit;
    update_wxfloor2_mx("wxfloor2","wxfloor2_name,wxfloor2_note_1,type,type2,type_name,sort_no","wxfloor2_sn",$time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('wxfloor2_mx.tpl');
}


if ($_REQUEST['act'] == 'post_add') {
      if(isset($_REQUEST['wxfloor2_sn']))
    {
        $wxfloor2_sn=trim($_REQUEST['wxfloor2_sn']);
    }
    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one=" select wxfloor2_sn from wxfloor2 where wxfloor2_sn ='".$wxfloor2_sn."'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($get_one);exit;
    if(empty($res))
    {
        ////echo 1;
//        $p = new upload;
//        $path=$p->upload_path='upload/wxfloor2';
//        $p->uplood_img();
//        $img_array = $p->upload_file;
//        for($i=0;$i<count($img_array['guige']);$i++)
//        {
//        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
//        }
//        //print_r($img_array);exit;
//        $aaa = $wxfloor2_sn;
//        
//        //插入图片记录//图片部分。没图片则删除
//         img_insert($aaa, $img_array,"wxfloor2_imgs");
        //修改4，增加语句
        //保存修改后商品明细
           $time_field=array(
        array("type"=>"2","field"=>"add_time","method"=>"1"),
       // array("type"=>"2","field"=>"last_update","method"=>"2"),
        //array("type"=>"1","field"=>"last_update_2","method"=>"2")
        );
        //修改4，增加语句
        //保存修改后商品明细
        insert_wxfloor2_mx("wxfloor2","wxfloor2_sn,wxfloor2_name,wxfloor2_note_1,type,type2,type_name,sort_no",$time_field);
        
        $smarty->assign('fall', 'post');
        $smarty->display('wxfloor2_mx.tpl');
    }
    else
    {
        $smarty->assign('fall', 'post');
        $smarty->display('wxfloor2_mx.tpl');   
    }
    
  
}


if ($_REQUEST['act'] == 'get_type') {

    //echo 1;exit;
    //if(isset($_REQUEST['province'])){
    require (dirname(__file__) . '/sub/rest.php');
    $type = urldecode($_REQUEST['type']);
    
    if($type=="1")
    {
        $sql_t="select wxfloor_sn as sn,wxfloor_name as name from wxfloor where type=1 and tzsy=0 order by sort_no desc";
        $sql_t = $GLOBALS['db']->getAll($sql_t);
         $aaa = new arraytojson();
         $json = $aaa->JSON($sql_t);

    print_r($json);
        
    }
    elseif($type=="2")
    {
        $sql_t="select wxfloor_sn as sn,wxfloor_name as name from wxfloor where type=2 and tzsy=0 order by sort_no desc";
        $sql_t = $GLOBALS['db']->getAll($sql_t);
        $aaa = new arraytojson();
        $json = $aaa->JSON($sql_t);

    print_r($json);
    }
     elseif($type=="3")
    {
        $sql_t="select wxfloor_sn as sn,wxfloor_name as name from wxfloor where type=3 and tzsy=0 order by sort_no desc";
        $sql_t = $GLOBALS['db']->getAll($sql_t);
        $aaa = new arraytojson();
        $json = $aaa->JSON($sql_t);

    print_r($json);
    }
     elseif($type=="4")
    {
        $sql_t="select wxfloor_sn as sn,wxfloor_name as name from wxfloor where type=4 and tzsy=0 order by sort_no desc";
        $sql_t = $GLOBALS['db']->getAll($sql_t);
        $aaa = new arraytojson();
        $json = $aaa->JSON($sql_t);

    print_r($json);
    }
  
  
}
?>