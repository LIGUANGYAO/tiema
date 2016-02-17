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
    
    
    $uinfo="select tg_img,tg_qrcid,wx_pay,openid,wx_isfc,wx_fctime,p_openid from   users  where  openid='".$openId."' ";
    $uinfo = $GLOBALS['db']->getRow($uinfo);
    
    $smarty->assign('pay', $uinfo['wx_pay']);
  
    
    $smarty->assign('bookjj', $bookjj);
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $goods_list['page']);
    $smarty->display('cs/bookbuy.html');


}




?>