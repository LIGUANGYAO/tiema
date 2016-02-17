<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');


require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['g'])) {
    $_REQUEST['g'] = 'default';
} else {
    $_REQUEST['g'] = trim($_REQUEST['g']);
}


//设定传入主参数
$g_add=substr(md5("a_kehu"),0,17); //添加参数
$g_e=substr(md5("e_kehu"),0,17); //编辑
$g_post=substr(md5("post_kehu"),0,17); //修改保存
$g_d=substr(md5("d_kehu"),0,17); //删除
$g_in=substr(md5("in_kehu"),0,17); //插入
$g_xs=substr(md5("xs_kehu"),0,17); //显示

//g= default默认 e编辑d删除 p接收修改 i接收添加
if ($_REQUEST['g'] == 'default') {

    
   
    $smarty->assign('fall', '1');
//    //$smarty->assign('title', $aaa);
//    $smarty->assign('p_Array', $list['page']);
    $smarty->display('w/jslist.html');


}





?>