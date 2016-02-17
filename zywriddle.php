<?php
define('IN_ECS', true);

require (dirname(__file__) . '/sub/is_weixin.php');
require (dirname(__file__) . '/includes/init1.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
///修改1,查询语句
//sort_no,tzsy 要记得添加

if(isset($_REQUEST['wxriddle_sn']))

{
    $wxriddle_sn=$_REQUEST['wxriddle_sn'];
}

   $q = "select wxfloor_name from wxfloor where wxfloor_sn='".$wxriddle_sn."' ";
   $res2 = $GLOBALS['db']->getRow($q);


    $sql="select wxriddle_sn,wxriddle_name,title,wxriddle_note_2,wxriddle_lx from wxriddle where wxriddle_lx= '".$wxriddle_sn."'";
    $res = $GLOBALS['db']->getAll($sql);
   
    $smarty->assign('wxfloor_name', $res2['wxfloor_name']);
    $smarty->assign('wxriddle_list', $res);
    $smarty->display('zyw/zywriddle.html');
}





?>