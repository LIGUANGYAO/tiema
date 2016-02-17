<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init2.php');

require (dirname(__file__) . '/sub/sub_openid.php');



if (empty($_REQUEST['g'])) {
    $_REQUEST['g'] = 'default';
} else {
    $_REQUEST['g'] = trim($_REQUEST['g']);
}


if ($_REQUEST['g'] == 'default') {

    
    
    
    //获取二维码信息
    require_once "jssdk.php";
    $jssdk = new JSSDK("wx7ca88298b4e7db53", "e6b3ba9a6bdadcd9d6d48e2fc949f01c");
    $signPackage = $jssdk->GetSignPackage();
    
    
    $smarty->assign('signPackage', $signPackage);

    $smarty->assign('company', $company);
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $goods_list['page']);
    $smarty->display('cs/feedback.html');


}




?>