<?php
define('IN_ECS', true);
require (dirname(__file__) . '/includes/init.php');


if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}
if ($_REQUEST['act'] == 'default') {
    
   if ($_REQUEST['action'] == 'setly'){
    require (dirname(__file__) . '/sub/rest.php'); 
      
    if (isset($_REQUEST['nickname'])) {
    $lyname = $_REQUEST['nickname'];
    }        
    
    if (isset($_REQUEST['info'])) {
    $info = $_REQUEST['info'];
    }        
    
    if (isset($_REQUEST['openid']))
    {
    $openid = $_REQUEST['openid'];
    }
    else
    {
    $openid='1';   
    }
     
    $time=date('Y-m-d H:i:s',time());
    if (empty($_REQUEST['fid'])){
       $sql_11 = "insert into ly(openid,ly_name,ly_info,add_time) values ('".$openid."','".$lyname."','".$info."','".$time."');";
       $opq = $GLOBALS['db']->query($sql_11);
       $userinfo=array("openid"=>$openid,"ly_name"=>$lyname,"ly_info"=>$info,"msg"=>"OK","success"=>true);
       $aaa = new arraytojson();
       $json = $aaa->JSON($userinfo);
       print_r($json); 
      }  
      else{
       $sql_11 = "insert into ly(openid,relay_id,relay_info,relay_time) values ('".$openid."','".$_REQUEST['fid']."','".$info."','".$time."');";
       $opq = $GLOBALS['db']->query($sql_11);
       $userinfo=array("openid"=>$openid,"relay_info"=>$info,"msg"=>"OK","success"=>true); 
       $aaa = new arraytojson();
       $json = $aaa->JSON($userinfo);
       print_r($json); 
      }
      
    }
    
   
    
    
    
    
}




?>