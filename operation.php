<?php

define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/sub_operation.php');
require (dirname(__file__) . '/sub/page.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'default') {

   
    $infolist = infolist($Num, "users_infolist");
    $smarty->assign('infolist', $infolist['item']);
    $smarty->assign('p_Array', $infolist['page']);
    $smarty->display('operation.tpl');
}





//禁用启用删除等操作


    
     if (isset($_REQUEST['delete'])) {
        $code = urldecode(trim($_REQUEST['delete'])) ;
        $sql = "delete from  text_reply where  text_sn= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";
    } else {
        
    }

?>
