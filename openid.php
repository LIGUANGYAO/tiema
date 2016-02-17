<?php

define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/sub_openid.php');
require (dirname(__file__) . '/sub/page.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'default') {
    
  $is_att= trim($_REQUEST['is_att']);
    
  if($is_att=='')
  {
    $is_att=2;
  }
  
  
  function getatt_sl()
  {
    $sql="select count(openid) as sl from users where is_att=1";
    $res = $GLOBALS['db']->getRow($sql);
    $sql2="select count(openid) as sl from users where is_att=0";
    $res2 = $GLOBALS['db']->getRow($sql2);
    return array("sl1"=>$res['sl'],"sl2"=>$res2['sl']);
    
  }
  $getatt_sl=getatt_sl();
  //print_r($getatt_sl);
    //echo $Num;exit;
  $list=openid($Num,"users");
  //print_r($list);
  $smarty->assign('getatt_sl',$getatt_sl);
  $smarty->assign('is_att',$is_att);
  $smarty->assign('openid_list',$list['item']);
  $smarty->assign('p_Array', $list['page']);
  $smarty->assign('fall','openid');
  $smarty->display('openid.tpl');
}


if ($_REQUEST['act'] == 'down_hy') {
    
   
    $smarty->assign('fall','down_hy');
    $smarty->display('openid.tpl');
}


if ($_REQUEST['act'] == 'send_msg') {
    
    
    $smarty->assign('fall','send_msg');
    $smarty->display('openid.tpl');
}

?>
