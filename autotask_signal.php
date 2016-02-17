<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_autotask_signal.php');

require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
///修改1,查询语句
//sort_no,tzsy 要记得添加
    $sql="select *,from_unixtime(last_exec_time) as last_time from autotask_signal";
    
    $autotask_signal_list = get_autotask_signal_list($Num,"autotask_signal",$sql);
    //print_r($autotask_signal_list);
    $smarty->assign('autotask_signal_list', $autotask_signal_list['items']);
     $smarty->assign('fall', 1);
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $autotask_signal_list['page']);
    $smarty->display('autotask_signal.tpl');


}

if ($_REQUEST['act'] == 'add_autotask_signal_list') {

   //$sql="select xmlx_sn ,xmlx_name from xmlx";
//   $res_xmlx = $GLOBALS['db']->getAll($sql);
//    $smarty->assign('res_xmlx', $res_xmlx);
    $smarty->assign('fall', 'add_autotask_signal_list');
    $smarty->display('autotask_signal_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];
    
    ///修改2,查询语句
    $sql="select *
  from autotask_signal  where id='".$_REQUEST['pid']."'";
    $autotask_signal_mx = $GLOBALS['db']->getAll($sql);
    
    //print_r($autotask_signal_mx);
//    exit;
    
    $smarty->assign('autotask_signal_mx', $autotask_signal_mx[0]);
    $smarty->assign('res_xmlx', $autotask_signal_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('autotask_signal_mx.tpl');
}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if(isset($_REQUEST['img_code']))
    {
        $img_code=trim($_REQUEST['img_code']);
                        
        $sql="delete from autotask_signal_imgs where  img_outer_id= '".$img_code."'";     
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

if ($_REQUEST['act'] == 'is_on') {

    $p_id=$_REQUEST['pid'];
    
    $sql="select id,is_on from autotask_signal where id='".$p_id."'";
    $res = $GLOBALS['db']->getRow($sql);
    if($res['is_on']==1)
    {
        $sql="update  autotask_signal set is_on=0  where   id='".$p_id."'";     
        $res = $GLOBALS['db']->query($sql);   
    }
    else
    {
        $sql="update  autotask_signal set is_on=1  where   id='".$p_id."'";     
        $res = $GLOBALS['db']->query($sql);  
    }
    //echo $p_id;
    
}

if ($_REQUEST['act'] == 'last_t') {

    $p_id=$_REQUEST['pid'];
    
    
        $sql="update  autotask_signal set last_exec_time=''  where   id='".$p_id."'";     
        $res = $GLOBALS['db']->query($sql);   
   
    
}


if ($_REQUEST['act'] == 'refre') {

   //刷新所有任务
   function refre()
   {
        $sql="truncate autotask_signal;";
        $res = $GLOBALS['db']->query($sql);   //清空表
        
        
        $sql="insert into  autotask_signal(api_type,api_module,api_path,sd_id_list,lx_time,is_on,last_exec_time,exec_status,auto_desc,total_execution_time,allow_ips) values ('weixiaodian','trade','moudle/weixiaodian/i_order_list_down.php',1,15,0,0,0,'增量下载模式',0,'127.0.0.1');";
        $res = $GLOBALS['db']->query($sql); 
        
        $sql="insert into  autotask_signal(api_type,api_module,api_path,sd_id_list,lx_time,is_on,last_exec_time,exec_status,auto_desc,total_execution_time,allow_ips) values ('weixiaodian','trade','moudle/weixiaodian/f_order_list_down.php',1,15,0,0,0,'全量下载模式',0,'127.0.0.1');";
        $res = $GLOBALS['db']->query($sql); 
        
        $sql="insert into  autotask_signal(api_type,api_module,api_path,sd_id_list,lx_time,is_on,last_exec_time,exec_status,auto_desc,total_execution_time,allow_ips) values ('weixin','trade','moudle/sendmsg/f_sendmsg.php',1,1,0,0,0,'客服信息自动发送',0,'127.0.0.1');";
        $res = $GLOBALS['db']->query($sql); 
        
        $sql="insert into  autotask_signal(api_type,api_module,api_path,sd_id_list,lx_time,is_on,last_exec_time,exec_status,auto_desc,total_execution_time,allow_ips) values ('weixin','trade','moudle/users/f_openid_list_down.php',1,720,0,0,0,'关注者下载',0,'127.0.0.1');";
        $res = $GLOBALS['db']->query($sql); 
        
        $sql="insert into  autotask_signal(api_type,api_module,api_path,sd_id_list,lx_time,is_on,last_exec_time,exec_status,auto_desc,total_execution_time,allow_ips) values ('weixin','trade','moudle/group/refresh_group.php',1,30,0,0,0,'刷新用户组',0,'127.0.0.1');";
        $res = $GLOBALS['db']->query($sql); 
        
        $sql="insert into  autotask_signal(api_type,api_module,api_path,sd_id_list,lx_time,is_on,last_exec_time,exec_status,auto_desc,total_execution_time,allow_ips) values ('chuanxiao','trade','cs/moudle/chuanxiao/redpacksend_sc.php',1,30,0,0,0,'sc',0,'127.0.0.1');";
         $res = $GLOBALS['db']->query($sql); 
        
        $sql="insert into  autotask_signal(api_type,api_module,api_path,sd_id_list,lx_time,is_on,last_exec_time,exec_status,auto_desc,total_execution_time,allow_ips) values ('chuanxiao','trade','cs/moudle/chuanxiao/redpacksend_send.php',1,1,0,0,0,'sendredpack',0,'127.0.0.1');";
        $res = $GLOBALS['db']->query($sql); 
        
        
        
        $sql="insert into  autotask_signal(api_type,api_module,api_path,sd_id_list,lx_time,is_on,last_exec_time,exec_status,auto_desc,total_execution_time,allow_ips) values ('chuanxiao','trade','cs/moudle/chuanxiao/transfers_send.php',1,1,0,0,0,'transfers_send',0,'127.0.0.1');";
        $res = $GLOBALS['db']->query($sql); 
        
        
        
        $sql="insert into  autotask_signal(api_type,api_module,api_path,sd_id_list,lx_time,is_on,last_exec_time,exec_status,auto_desc,total_execution_time,allow_ips) values ('chuanxiao','trade','cs/moudle/chuanxiao/wxpay_fclog.php',1,1,0,0,0,'wxpay_fclog',0,'127.0.0.1');";
        $res = $GLOBALS['db']->query($sql); 
        
   }
   refre();
   header("location: autotask_signal.php");
}


if ($_REQUEST['act'] == 'delete_autotask_signal') {

    //echo 1;
    if(isset($_REQUEST['autotask_signal_sn']))
    {
        $autotask_signal_sn=trim($_REQUEST['autotask_signal_sn']);
                        
        $sql="delete from autotask_signal where  autotask_signal_sn= '".$autotask_signal_sn."'";     
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
                        
        $sql="update  autotask_signal_imgs set ss=".$alt."  where  img_outer_id= '".$img_code."'";     
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
if ($_REQUEST['act'] == 'autotask_signal_xs') {

    //echo 1;
   
    if(isset($_REQUEST['autotask_signal_code']) && isset($_REQUEST['alt']))
    {
        $autotask_signal_code=urldecode(trim($_REQUEST['autotask_signal_code']));
        $alt=urldecode(trim($_REQUEST['alt']));
                        
        $sql="update  autotask_signal set tzsy=".$alt."  where  autotask_signal_sn= '".$autotask_signal_code."'";     
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

    
    //$p = new upload;
//    $path=$p->upload_path='upload/autotask_signal';
//    $p->uplood_img();
//    $img_array = $p->upload_file;
//   
//    for($i=0;$i<count($img_array['guige']);$i++)
//    {
//        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
//    }
//    $aaa = $_POST['autotask_signal_sn'];
//    // print_r($aaa);exit;
//    //图片部分。没图片则删除
//    img_insert($aaa, $img_array,"autotask_signal_imgs");
    //修改3，更新语句
     $time_field=array(
    //array("type"=>"2","field"=>"add_time","method"=>"1"),
    //array("type"=>"2","field"=>"last_update","method"=>"2"),
    //array("type"=>"1","field"=>"last_update_2","method"=>"2")
    );
    //print_r($time_field);exit;
    update_autotask_signal_mx("autotask_signal","auto_desc,lx_time","id",$time_field);
    
    $smarty->assign('fall', 'post');
    
    header("location: autotask_signal.php");
    $smarty->display('autotask_signal_mx.tpl');
}


if ($_REQUEST['act'] == 'post_add') {
      if(isset($_REQUEST['autotask_signal_sn']))
    {
        $autotask_signal_sn=trim($_REQUEST['autotask_signal_sn']);
    }
    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one=" select autotask_signal_sn from autotask_signal where autotask_signal_sn ='".$autotask_signal_sn."'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($get_one);exit;
    if(empty($res))
    {
        //echo 1;
       // $p = new upload;
//        $path=$p->upload_path='upload/autotask_signal';
//        $p->uplood_img();
//        $img_array = $p->upload_file;
//        for($i=0;$i<count($img_array['guige']);$i++)
//        {
//        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
//        }
//        //print_r($img_array);exit;
//        $aaa = $autotask_signal_sn;
//        
//        //插入图片记录//图片部分。没图片则删除
//         img_insert($aaa, $img_array,"autotask_signal_imgs");
        //修改4，增加语句
        //保存修改后商品明细
           $time_field=array(
        array("type"=>"2","field"=>"add_time","method"=>"1"),
       // array("type"=>"2","field"=>"last_update","method"=>"2"),
        //array("type"=>"1","field"=>"last_update_2","method"=>"2")
        );
        //修改4，增加语句
        //保存修改后商品明细
        insert_autotask_signal_mx("autotask_signal","autotask_signal_sn,autotask_signal_name,url,type,sort_no",$time_field);
        
        $smarty->assign('fall', 'post');
        $smarty->display('autotask_signal_mx.tpl');
    }
    else
    {
        $smarty->assign('fall', 'fs');
        $smarty->display('autotask_signal_mx.tpl');   
    }
    
  
}



?>