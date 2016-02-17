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
     
    
  $smarty->display('frame.tpl');
}

?>
