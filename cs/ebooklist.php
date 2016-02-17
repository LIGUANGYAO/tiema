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
    
    
   
  
    
    
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $goods_list['page']);
    $smarty->display('cs/ebooklist.html');


}




?>