<?php

define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'default') {


    class Statistics
    {
        
    }
    
    
     $ext=new Statistics();
     $sql="select count(*) as sl from kehu where tzsy=0";
     $kehu = $GLOBALS['db']->getRow($sql);
     
     $smarty->assign('kehu', $kehu['sl']);
     
     $sql="select count(*) as sl from pinggu where tzsy=0";
     $pinggu = $GLOBALS['db']->getRow($sql);
     
     $smarty->assign('pinggu', $pinggu['sl']);
  $smarty->display('frame.tpl');
}

?>
