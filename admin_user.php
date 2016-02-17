<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_admin_user.php');
require (dirname(__file__) . '/sub/sub_image.php');
//echo  getenv("HTTP_X_FORWARDED_FOR") ;
//print_r($_SERVER);
if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
///修改1,查询语句
//sort_no,tzsy 要记得添加
    $sql="select user_id,user_code,user_name,user_name2,sort_no,tzsy,add_time,last_update,last_update_2 from admin_user ";
  
    $admin_user_list = get_admin_user_list($Num,"admin_user",$sql);
     // print_r($admin_user_list);
     
      for($i=0;$i<count($admin_user_list['items']);$i++)
    {
        $sql="select a.*,b.role_name from role_user a inner join role b on a.p_id=b.role_sn where a.user_sn='".$admin_user_list['items'][$i]['user_code']."' order by a.user_sn";
        $res = $GLOBALS['db']->getAll($sql);
        $admin_user_list['items'][$i]['u_list']=$res;
    } 
    //print_r($admin_user_list);
    $smarty->assign('admin_user_list', $admin_user_list['items']);
    
    $smarty->assign('title', $aaa);
     $smarty->assign('fall', 1);
    $smarty->assign('p_Array', $admin_user_list['page']);
    $smarty->display('admin_user.tpl');


}

if ($_REQUEST['act'] == 'add_admin_user_list') {

   $sql="select xmlx_sn ,xmlx_name from xmlx";
   $res_xmlx = $GLOBALS['db']->getAll($sql);
    $smarty->assign('res_xmlx', $res_xmlx);
    $smarty->assign('fall', 'add_admin_user_list');
    $smarty->display('admin_user_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];
    
    ///修改2,查询语句
    $sql="select user_id,user_code,user_name,user_name2,sort_no,tzsy,add_time,last_update,last_update_2
  from admin_user ";
    $admin_user_mx=get_admin_user_mx("admin_user",$sql);
    
   // print_r($admin_user_mx);exit;
    $img_cod=$_REQUEST['user_code'];
    
    
    
    
    $smarty->assign('admin_user_mx', $admin_user_mx['items'][0]);
    $smarty->assign('res_xmlx', $admin_user_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('admin_user_mx.tpl');
}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if(isset($_REQUEST['img_code']))
    {
        $img_code=trim($_REQUEST['img_code']);
                        
        $sql="delete from admin_user_imgs where  img_outer_id= '".$img_code."'";     
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

if ($_REQUEST['act'] == 'reset') {

    //echo 1;
    if(isset($_REQUEST['user_code']))
    {
        $user_code=trim($_REQUEST['user_code']);
        //                
//        $sql="delete from admin_user where  user_code= '".$user_code."'";     
//        $res = $GLOBALS['db']->query($sql);
//        echo "删除成功";            
            $password = md5("8888");
            //$password=md5(md5($password."tiema.com"));   
            $sql="update admin_user set password='".$password."' where  user_code= '".$user_code."'";   
            
            //echo $sql;  
            $res = $GLOBALS['db']->query($sql); 
    }
    else
    {
        echo "失败";
    }
}

if ($_REQUEST['act'] == 'delete_admin_user') {

    //echo 1;
    if(isset($_REQUEST['user_code']))
    {
        $user_code=trim($_REQUEST['user_code']);
                        
        $sql="delete from admin_user where  user_code= '".$user_code."'";     
        $res = $GLOBALS['db']->query($sql);
        
        
        $sql="delete from role_user where  user_sn= '".$user_code."'";     
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
                        
        $sql="update  admin_user_imgs set ss=".$alt."  where  img_outer_id= '".$img_code."'";     
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
if ($_REQUEST['act'] == 'admin_user_xs') {

    //echo 1;
   
    if(isset($_REQUEST['admin_user_code']) && isset($_REQUEST['alt']))
    {
        $admin_user_code=trim($_REQUEST['admin_user_code']);
        $alt=trim($_REQUEST['alt']);
                        
        $sql="update  admin_user set tzsy=".$alt."  where  user_code= '".$admin_user_code."'";     
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
    //更新时间，长短型 ,1 --没有时分秒,2012-09-11   //2代表全 2012-10-12 23:11:22 //method 1代表只更新一次,2代表每次都要更新
   
     $time_field=array(
    //array("type"=>"2","field"=>"add_time","method"=>"1"),
    array("type"=>"2","field"=>"last_update","method"=>"2"),
    array("type"=>"1","field"=>"last_update_2","method"=>"2")
    );
    
    update_admin_user_mx("admin_user","sort_no,user_name2","user_code",$time_field);
    
    
    
    $smarty->assign('fall', 'post');
    $smarty->display('admin_user_mx.tpl');
}


if ($_REQUEST['act'] == 'post_add') {
      if(isset($_REQUEST['user_code']))
    {
        $p_id=trim($_REQUEST['user_code']);
    }
    //print_r($p_id);
    //res_xmlx
   
    $get_one=" select user_code from admin_user where user_code ='".$user_code."'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($_REQUEST['user_name3']);exit;
    if(empty($res))
    {
        //echo 1;
        $time_field=array(
        array("type"=>"2","field"=>"add_time","method"=>"1"),
       // array("type"=>"2","field"=>"last_update","method"=>"2"),
        //array("type"=>"1","field"=>"last_update_2","method"=>"2")
        );
        //修改4，增加语句
        //保存修改后商品明细
        insert_admin_user_mx("admin_user","user_code,user_name2,sort_no",$time_field);
        
        $smarty->assign('fall', 'post');
        $smarty->display('admin_user_mx.tpl');
    }
    else
    {
         $smarty->assign('fall', 'fs');
        $smarty->display('admin_user_mx.tpl');   
    }
    
  
}



?>