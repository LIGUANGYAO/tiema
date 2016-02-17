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

if(isset($_REQUEST['wxfloor2_sn']))
{
    $wxfloor2_sn=$_REQUEST['wxfloor2_sn'];
}

   $q = "select wxfloor2_name from wxfloor2 where wxfloor2_sn='".$wxfloor2_sn."' ";
   $res2 = $GLOBALS['db']->getRow($q);


    $sql="select wxarticle_sn,wxarticle_name,wxarticle_lx from wxarticle where wxarticle_lx= '".$wxfloor2_sn."' order by id desc";
    $res = $GLOBALS['db']->getAll($sql);
    $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
     for ($i = 0; $i<count($res); $i++) {
        //$q = "select wxfloor2_name from wxfloor2 where wxfloor2_sn='".$res[$i]['wxarticle_lx']."' ";
        //$res2 = $GLOBALS['db']->getRow($q);
        //$res[$i]['p_name'] = $res2['wxfloor2_name'];
        $res[$i]['url']=$url_this.'/html/wxarticle/'.'html_'.$res[$i]['wxarticle_sn'].'.html';
    }   
    $smarty->assign('wxfloor2_name', $res2['wxfloor2_name']);
    $smarty->assign('wxarticle_list', $res);
    $smarty->display('zyw/zywlist.html');
}





?>