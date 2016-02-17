<?php

define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/sub_sign_list.php');
require (dirname(__file__) . '/sub/page.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'default') {

   
    $sign_list = sign_list($Num, "joinin");
    $smarty->assign('sign_list', $sign_list['item']);
    $smarty->assign('p_Array', $sign_list['page']);
    $smarty->display('sign_list.tpl');
}





//禁用启用删除等操作
if ($_REQUEST['act'] == 'sign_list_xs') {
        if (isset($_REQUEST['id']) && isset($_REQUEST['alt'])) {
        $id = urldecode(trim($_REQUEST['id']));
        $alt = urldecode(trim($_REQUEST['alt']));

        $sql = "update joinin set tzsy=" . $alt . "  where  id= '" . $id .
            "'";
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";
    } else {
        echo "失败";
    }
}

    
     if (isset($_REQUEST['delete'])) {
        $code = urldecode(trim($_REQUEST['delete'])) ;
        $sql = "delete from  joinin where  id= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";
    } else {
        
    }

?>
