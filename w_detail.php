<?php

define('IN_ECS', true);

require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/sub_w_list.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'default') {
    
  $w_list= get_w_list(); 
    $smarty->assign('w_list', $w_list['items']);
  $news_list=get_newsmx();
  $smarty->assign('news1', $news_list['items'][0]);
 
  //print_r($news_list['items'][0]);
        
        
   //$w_list=get_w_list();
   //$smarty->assign('w_list', $w_list['items']);
        // print_r($w_list['items']);
  //print_r($menu_list);
  //$smarty->assign('menu_list', "我是谁");
  $smarty->display('w_detail.tpl');
}

?>
