<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init2.php');
$is_allow = $GLOBALS['db']->getOne(" select sesskey from sessions where sesskey='" .
    $_COOKIE['user_name'] . "' limit 1 ;");
//echo $is_allow;exit;
if ($is_allow) {
    //echo 1;
    echo "<script>window.location.href='privilege.html';</script>";
} else {
    
}


if (empty($_REQUEST['g'])) {
    $_REQUEST['g'] = 'default';
} else {
    $_REQUEST['g'] = trim($_REQUEST['g']);
}



//g= defaultĬ�� e�༭dɾ�� p�����޸� i�������
if ($_REQUEST['g'] == 'default') {

    
    
    //
//    $smarty->assign('kehu_list', $list['items']);
//    $smarty->assign('fall', 1);
//    //$smarty->assign('title', $aaa);
//    $smarty->assign('p_Array', $list['page']);
    $smarty->display('w/index2.html');


}



?>