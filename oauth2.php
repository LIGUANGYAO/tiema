<?php
define('IN_ECS', true);



if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {

    
    $smarty->display('activity.tpl');

}





?>