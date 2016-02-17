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
 if(isset($_REQUEST['id'])){
   $id=$_REQUEST['id'];
                 }   

//    $sql="select id,shop_sn,shop_name,shop_address,shop_lxr,district from shop where district='".$id."'";
//    $res = $GLOBALS['db']->getAll($sql);
//    
//
//    $sql2 = "select region_name from region where id='".$id."'";
//    $res2 = $GLOBALS['db']->getAll($sql2); 

    $sql="select id,shop_name,lxr,tel,district_id from wxarea where district_id='".$id."'";
    $res = $GLOBALS['db']->getAll($sql);
    
    $sql2 = "select region_name from region where id='".$id."'";
    $res2 = $GLOBALS['db']->getAll($sql2); 
    
   
    $smarty->assign('shop_list', $res);
    $smarty->assign('region_name', $res2[0]['region_name']);
    $smarty->display('citylist/shoplist.html');
}





?>