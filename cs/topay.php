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
    
    
    function getidUserInfo($obj)
    {
        $sql="select id,wx_pay,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,openid,headimgurl,tg_img from users where openid ='".$obj."'";
        $res = $GLOBALS['db']->getRow($sql);
        
        return $res;
    }
    $userInfo=getidUserInfo($openId);
    //print_r($userInfo);
    
    if($userInfo['wx_pay']==1)
    {
         header("location: index.php");
        $smarty->assign('wx_pay', 1);
    }
    else
    {
         $smarty->assign('wx_pay', 0);
    }
    
    
    
    
    $sql="select max(id) as sl from users";
    $count = $GLOBALS['db']->getRow($sql);
    
 
    $var=sprintf("%06d", $count['sl']);//生成4位数，不足前面补0 
    //echo $var;
    $arr =str_split($var);
        //print_r($a); ;
    //print_r($arr);
    $smarty->assign('arr', $arr);
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $goods_list['page']);
    $smarty->display('cs/topay.html');


}




?>