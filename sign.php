<?php

define('IN_ECS', true);
include('page.php');
require (dirname(__file__) . '/includes/init1.php');
$sql = " select app_id,app_secret from app_id where weixin_id=1 ";
$res = $GLOBALS['db']->getRow($sql);

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
    
   
    if (isset($_GET['code'])) {
        $code = $_GET['code'];
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$res['app_id'].'&secret='.$res['app_secret'].'&code=' .
            $code . '&grant_type=authorization_code';

        $headers = array("Content-Type: text/xml; charset=utf-8");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $output = curl_exec($ch);
        curl_close($ch);
        

        $jsonstr = json_decode($output);
        //print_r($jsonstr);
        //print_r($jsonstr->access_token . "</br>");
        //print_r($jsonstr->refresh_token . "</br>");
        //print_r($jsonstr->openid . "</br>");
        $access_token = $jsonstr->access_token;
        $refresh_token = $jsonstr->refresh_token;
        $openid = $jsonstr->openid;
        
        //print_r($openid);
      }
    //require (dirname(__file__) . '/sub/sub_g_id.php');
    $sql123="select openid from users where openid='".$openid."' ";
    $res = $GLOBALS['db']->getAll($sql123);
    
    $user_id3 = "select id from users where openid='" . $openid . "'";
    $user_id4 = $GLOBALS['db']->getRow($user_id3);
           // print_r($user_id4);
    if (empty($user_id4))
       {
       $smarty->display('sign1.tpl');
       }
       else
       {
       $smarty->assign('openid', $res[0]);
       $smarty->display('sign.tpl');   
       }
       
    
}

if ($_REQUEST['act'] == 'submit'){
    
   require (dirname(__file__) . '/sub/rest.php');    
     
     if (isset($_REQUEST['mu_name'])) {
    $mu_name = $_REQUEST['mu_name'];
    }        
    
    if (isset($_REQUEST['mu_tel'])) {
    $mu_tel = $_REQUEST['mu_tel'];
    }        
  
   if (isset($_REQUEST['mu_car'])) {
    $mu_car = $_REQUEST['mu_car'];
    }  
//   
if (isset($_REQUEST['openid'])) {
    
     $openid = trim($_REQUEST['openid']);
     $time=date('Y-m-d H:i:s',time());
     
     $sel="select mu_tel from joinin where mu_tel='".$mu_tel."'";
     $sel = $GLOBALS['db']->getRow($sel);
     if(empty($sel['mu_tel']))
     {
     $sql_11 = "insert into joinin(openid,mu_name,mu_tel,mu_car,add_time) values ('".$openid."','".$mu_name."','".$mu_tel."','".$mu_car."','".$time."');";
     $opq = $GLOBALS['db']->query($sql_11);
     $userinfo=array("openid"=>$openid,"mu_name"=>$mu_name,"mu_tel"=>$mu_tel,"mu_car"=>$mu_car);
     $aaa = new arraytojson();
     $json = $aaa->JSON($userinfo);
     print_r($json);
     }
 
}
       
    
  
   //$smarty->display('sign.tpl');
    



}
?>
