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

    require_once "jssdk.php";
    $jssdk = new JSSDK($App_id, $App_sercret);
    $signPackage = $jssdk->GetSignPackage();
   
   //print_r($signPackage);exit;

    //获取是否有上传二维码
    $getqrcid = "select tg_userweima,tg_erweimaup from users where   openid='" . $openId .
        "' ";
    $getqrcid = $GLOBALS['db']->getRow($getqrcid);


     $smarty->assign('signPackage', $signPackage);
    $smarty->assign('getqrcid', $getqrcid);
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $goods_list['page']);
    $smarty->display('cs/uploadcode.html');

}


if ($_REQUEST['g'] == 'upimg') {

    require_once "sub/sub_cj_qrcode.php";
    $tk = new getArr();
    $access_token = $tk->getToken();

    $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=$access_token&media_id=" .
        $_REQUEST['serverId'];

    //    require_once 'wxpay/example/log.php';
    //
    //
    //$logHandler= new CLogFileHandler("wxpay/logs/".date('Y-m-d').'.log');
    //$log = Log::Init($logHandler, 15);
    //
    //
    //    Log::DEBUG($url);


    require (dirname(__file__) . '/sub/sub_image.php');


    $fileInfo = downloadWeixinFile($url);
    $filename = "upload/users/" . $_REQUEST['serverId'] . ".jpg";
    $savetype = saveWeixinFile($filename, $fileInfo["body"]);


    if ($savetype == true) {
      

        if ($openId != '') {

            $getf = "select tg_userweima from  users  where  openid='" . $openId . "' ";
            $getf = $GLOBALS['db']->getRow($getf);


            if (file_exists($getf['tg_userweima'])) {
                $result = unlink($getf['tg_userweima']);
                //echo $result;
            }

            $getqrcid = "update users set tg_userweima='" . $filename .
                "',tg_erweimaup=1 where  openid='" . $openId . "' ";
            $getqrcid = $GLOBALS['db']->query($getqrcid);
        }
        $retarr = array('msg' => "二维码上传成功!", 'msgtype' => 1, 'status' => 'ok');
        print_r(json_encode($retarr));
    } else {
        $retarr = array('msg' => "上传异常!请重新上传", 'msgtype' => 0, 'status' => 'error');
        print_r(json_encode($retarr));
    }

}


if ($_REQUEST['g'] == 'shuoming') {


    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $goods_list['page']);
    $smarty->display('cs/shuoming.html');

}




?>




