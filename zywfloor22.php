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

if(isset($_REQUEST['wxfloor_sn']))
{
    $wxfloor_sn=$_REQUEST['wxfloor_sn'];
}

   $q = "select wxfloor_name from wxfloor where wxfloor_sn='".$wxfloor_sn."' ";
   $res2 = $GLOBALS['db']->getRow($q);


    $sql="select wxfloor2_sn,wxfloor2_name from wxfloor2 where type2= '".$wxfloor_sn."'";
    $res = $GLOBALS['db']->getAll($sql);
    for ($i = 0; $i<count($res); $i++) {
       $res[$i]['i'] = $i+1;
    }
    //print_r($res);
    $smarty->assign('wxfloor_name', $res2['wxfloor_name']);
    $smarty->assign('wxfloor2_list', $res);
    $smarty->display('zyw/wxfloor22.html');
}





?>