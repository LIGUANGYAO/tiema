<?php

define('IN_ECS', true);
include('page.php');
//require(dirname(__FILE__) . '/sub/sub_vipcard.php');
require (dirname(__file__) . '/includes/init1.php');


if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
    
    
         if (isset($_GET['code'])) {
        $code = $_GET['code'];
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx1e6d9bff1a01985b&secret=8c2928e1f9b20833b4f8b7bd46550bec&code=' .
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
        //echo $output;

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
    $sql123="select users_sn from users where openid='".$openid."' ";
    $res = $GLOBALS['db']->getAll($sql123);
   
  
    
    
   //print_r($res);

    
    
   $smarty->assign('vipcard', $res[0]);
    $smarty->display('vipcard.tpl');


}
?>
