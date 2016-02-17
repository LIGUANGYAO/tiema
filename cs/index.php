<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init2.php');

require (dirname(__file__) . '/sub/sub_openid.php');

require_once 'wxpay/log.php';
//初始化日志
$logHandler= new CLogFileHandler("wxpay/logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);


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
         
        $smarty->assign('wx_pay', 1);
    }
    else
    {
         
         if($_REQUEST['t']=='wxpay')
         {
            
         }
         else
         {
            header("location: topay.php");
         }
         $smarty->assign('wx_pay', 0);
    }
    
    
    
    $us=new Uinfo();
    
    $userInfo=$us->openidGetInfo($openId);
    $smarty->assign('userInfo', $userInfo);
   
    $userCount=$us->UserCount();
    $smarty->assign('userCount', $userCount);
    
    
    
    
    
    
    $smarty->assign('company', $company);
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $goods_list['page']);
    $smarty->display('cs/index.html');


}



if ($_REQUEST['g'] == 'SwitchUserInfo') {
    
    
    $rarr=array();
    if(isset($_REQUEST['flag']))
    {
       
        $sql="update users set login_status='".trim($_REQUEST['flag'])."' where openid='".$openId."'";
        $res = $GLOBALS['db']->query($sql);
        
        $rarr['status']='success';
        if($_REQUEST['flag']==1)
        {
            $rarr['msg']='开启资料成功';
        }
        else
        {
            $rarr['msg']='关闭资料成功';
        }
        
        
        
    }
    else
    {
        $rarr['status']='';
        $rarr['msg']='已更新状态';
    }
    
    print_r( json_encode($rarr));
}
    


?>