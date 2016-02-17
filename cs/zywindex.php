<?php
define('IN_ECS', true);

//require (dirname(__file__) . '/sub/is_weixin.php');
require (dirname(__file__) . '/includes/init2.php');

require (dirname(__file__) . '/sub/sub_openid.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
///修改1,查询语句
//sort_no,tzsy 要记得添加
    
    
     function getidUserInfo($obj)
    {
        $sql="select id,wx_pay,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,openid,headimgurl,tg_img from users where openid ='".$obj."'";
        $res = $GLOBALS['db']->getRow($sql);
        
        return $res;
    }
    

    
    $userInfo=getidUserInfo($openId);
    
    
    if($userInfo['wx_pay']==1)
    {
        $smarty->assign('wx_pay', 1);
    }
    else
    {
         $smarty->assign('wx_pay', 0);
    }
    
    
    
    $sql1="select a.wxfloor_sn,a.wxfloor_name,a.sort_no,a.type,b.s_img_url,b.b_img_url from wxfloor a 
    left join wxfloor_imgs b on b.p_id=a.wxfloor_sn where type=1";
    $res1 = $GLOBALS['db']->getAll($sql1);
    for ($i = 0; $i<count($res1); $i++) {
       $res1[$i]['i'] = 'color_'.($i+1);
    }
    //print_r($res1);
    
    $sql2="select a.wxfloor_sn,a.wxfloor_name,a.sort_no,a.type,b.s_img_url,b.b_img_url from wxfloor a 
    left join wxfloor_imgs b on b.p_id=a.wxfloor_sn where type=2";
    $res2 = $GLOBALS['db']->getAll($sql2);
    for ($i = 0; $i<count($res2); $i++) {
       $res2[$i]['i'] = 'color_'.($i+3);
    }
    
    $sql3="select a.wxfloor_sn,a.wxfloor_name,a.sort_no,a.type,b.s_img_url,b.b_img_url from wxfloor a 
    left join wxfloor_imgs b on b.p_id=a.wxfloor_sn where type=3";
    $res3 = $GLOBALS['db']->getAll($sql3);
    for ($i = 0; $i<count($res3); $i++) {
       $res3[$i]['i'] = 'color_'.($i+2);
    }
    
    $sql4="select a.wxfloor_sn,a.wxfloor_name,a.sort_no,a.type,b.s_img_url,b.b_img_url from wxfloor a 
    left join wxfloor_imgs b on b.p_id=a.wxfloor_sn where type=4 order by a.sort_no desc";
    $res4 = $GLOBALS['db']->getAll($sql4);
    for ($i = 0; $i<count($res4); $i++) {
       $res4[$i]['i'] = 'color_'.($i+4);
    }
    

    //print_r($res1);
    $smarty->assign('wxfloor1_list', $res1);
    $smarty->assign('wxfloor2_list', $res2);
    $smarty->assign('wxfloor3_list', $res3);
    $smarty->assign('wxfloor4_list', $res4);
    
    $smarty->display('zyw/zywindex.html');
}





?>