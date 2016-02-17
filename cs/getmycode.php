<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init2.php');

require (dirname(__file__) . '/sub/sub_openid.php');



if (empty($_REQUEST['g'])) {
    $_REQUEST['g'] = 'default';
} else {
    $_REQUEST['g'] = trim($_REQUEST['g']);
}


if ($_REQUEST['g'] == 'default') {

    
   
    function getUserInfo($obj)
    {
        $sql="select id,wx_pay,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,openid,headimgurl from users where openid ='".$obj."'";
        $res = $GLOBALS['db']->getRow($sql);
        
        return $res;
    }
    
    $userInfo=getUserInfo($openId);
    
     
      if($userInfo['wx_pay']==1)
    {
         
        $smarty->assign('wx_pay', 1);
         
        header("Location: mycode.php?u=".$userInfo['id']);
    
    }
    else
    {
          header("location: topay.php");
          exit;
         $smarty->assign('wx_pay', 0);
    }
    
   
    
}
?>