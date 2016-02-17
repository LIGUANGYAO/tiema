<?php 
/*
 * 淘宝退单转单
 */
define('IN_ECS', true);

error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));


require (dirname(__file__) . '/includes/init2.php');





$sql="insert into wx_lv_msg(name ) values(1)";
    $res_slide2 = $GLOBALS['db']->query($sql);

	echo 1;