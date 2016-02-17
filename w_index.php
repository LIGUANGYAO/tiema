<?php

define('IN_ECS', true);
require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/sub_w_index.php');
if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'default') {
    
  $w_index=get_w_index_mx();
  $smarty->assign('w_index', $w_index['items'][0]);
  $w_list=get_w_list();
  $smarty->assign('w_list', $w_list['items']);
        // print_r($w_list['items']);
  //print_r($menu_list);
  //$smarty->assign('menu_list', "ฮาสวหญ");
  $smarty->display('w_index.tpl');
}

?>