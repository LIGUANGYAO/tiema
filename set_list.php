<?php

define('IN_ECS', true);
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_set_list.php');
require (dirname(__file__) . '/includes/init.php');


if (empty($_REQUEST['action'])) {
    $_REQUEST['action'] = 'default';
} else {
    $_REQUEST['action'] = trim($_REQUEST['action']);
}

$action=$_GET['action'];
$id=$_GET['id'];
//print_r($action);
/**

 * if ($_REQUEST['act'] == 'default') {
 *     
 *     $smarty->display('reply_text.tpl');
 * }
 */

if ($_REQUEST['action'] == 'default') {
    $set_list = get_set_list($Num);
    
    
       
    $smarty->assign('fall', 1);
    $smarty->assign('list', $set_list['items']);
    $smarty->assign('p_Array', $set_list['page']);
    $smarty->display('set_list.tpl');
}
if ($_REQUEST['action'] == 'add') {
    insert_set_list_mx();
    $set_list = get_set_list($Num);
    $smarty->assign('list', $set_list['items']);
    $smarty->assign('p_Array', $set_list['page']);
    $smarty->display('set_list.tpl');
}
if ($_REQUEST['action'] == 'addlist') {
    $smarty->assign("fall", "addlist");
    $smarty->display('set_list_add.tpl');

}
if ($_REQUEST['action'] == 'delete') {
    delete_set_list_mx($id);
    $set_list = get_set_list($Num);
    $smarty->assign('list', $set_list['items']);
    $smarty->assign('p_Array', $set_list['page']);
    $smarty->display('set_list.tpl');

}
if ($_REQUEST['action'] == 'update') {
    $set_list = get_list_mx();
    //print_r($set_list);
    $smarty->assign('set_list', $set_list['items'][0]);
    $smarty->assign("fall", "update");
    $smarty->display('set_list_add.tpl');
}

if ($_REQUEST['action'] == 'edit') {
    update_set_list_mx($id);
    $set_list = get_set_list($Num);

    $smarty->assign('list', $set_list['items']);
    $smarty->assign('p_Array', $set_list['page']);
    $smarty->assign('fall', "i_staus");
     $smarty->assign('val', "文章修改成功");
    $smarty->display('set_list_add.tpl');
}


?>
