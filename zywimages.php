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

if(isset($_REQUEST['wximages_sn']))

{
    $wximages_sn=$_REQUEST['wximages_sn'];
}

   $q = "select wxfloor_name from wxfloor where wxfloor_sn='".$wximages_sn."' ";
   $res2 = $GLOBALS['db']->getRow($q);


    $sql="select wximages_sn,wximages_name,wximages_lx from wximages where wximages_lx= '".$wximages_sn."'";
    $res = $GLOBALS['db']->getAll($sql);
    //print_r($sql);
    $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
     for ($i = 0; $i<count($res); $i++) {
        //$q = "select wxfloor2_name from wxfloor2 where wxfloor2_sn='".$res[$i]['wxarticle_lx']."' ";
        //$res2 = $GLOBALS['db']->getRow($q);
        //$res[$i]['p_name'] = $res2['wxfloor2_name'];
        $res[$i]['url']=$url_this.'/html/wximages/'.'html_'.$res[$i]['wximages_sn'].'.html';
    }   
   // print_r($res);
    $smarty->assign('wxfloor_name', $res2['wxfloor_name']);
    $smarty->assign('wximages_list', $res);
    $smarty->display('zyw/zywimages.html');
}





?>