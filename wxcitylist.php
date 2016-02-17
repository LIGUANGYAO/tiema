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

////////////
//    $sql="select id, region_name  from region where region_type=1";
//    $res = $GLOBALS['db']->getAll($sql);
//    for ($i = 0; $i<count($res); $i++) {
//        
//     $sql1 = "select id,region_name  from region where p_id='".$res[$i]['id']."'";
//     $res1 = $GLOBALS['db']->getAll($sql1);
//     $res[$i]['city'] = $res1; 
//     
//     for($j = 0; $j<count($res[$i]['city']); $j++)
//     {
//      $sql2 = "select id,region_name from region where p_id='".$res[$i]['city'][$j]['id']."'";
//      $res2 = $GLOBALS['db']->getAll($sql2); 
//      $res[$i]['city'][$j]['district'] = $res2; 
//     }
//    }
/////////////

    $sql="select id, region_name,tzsy  from region where region_type=1 order by sort_no desc";
    $res = $GLOBALS['db']->getAll($sql);
    for ($i = 0; $i<count($res); $i++) {
        
     $sql1 = "select id,region_name  from region where p_id='".$res[$i]['id']."'";
     $res1 = $GLOBALS['db']->getAll($sql1);
     $res[$i]['city'] = $res1; 
     
     for($j = 0; $j<count($res[$i]['city']); $j++)
     {
      $sql2 = "select id,region_name,tzsy from region where p_id='".$res[$i]['city'][$j]['id']."'";
      $res2 = $GLOBALS['db']->getAll($sql2); 
      $res[$i]['city'][$j]['district'] = $res2; 
     }
     
     
    }

   // print_r($res[0]);
    $smarty->assign('province_list', $res);
    $smarty->display('citylist/citylist.html');
}





?>