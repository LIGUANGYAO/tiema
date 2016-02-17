<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init2.php');

require (dirname(__file__) . '/sub/sub_openid.php');
require_once "wxpay/WxPay.JsApiPay.php";

function getUserInfo($obj)
{
    $sql="select id,wx_pay,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,openid,headimgurl from users where openid ='".$obj."'";
    $res = $GLOBALS['db']->getRow($sql);

    return $res;
}
$tools = new JsApiPay();
$openId = $tools->GetOpenid();
$userInfo=getUserInfo($openId);
$id=$userInfo['id'];




/*
if(isset($_REQUEST['u']))
    {
        $id=trim($_REQUEST['u']);
    }
    else
    {
        exit;
    }
*/
    //获取二维码信息
    require_once "jssdk.php";
    $jssdk = new JSSDK($App_id, $App_sercret);
    $signPackage = $jssdk->GetSignPackage();


    $smarty->assign('signPackage', $signPackage);




    $smarty->assign('nurl', $nurl2."?u=".$id);
    $smarty->assign('nurl2', $nurl2);



    function getidUserInfo($obj)
    {
        $sql="select id,wx_pay,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,openid,headimgurl,tg_img from users where id ='".$obj."'";
        $res = $GLOBALS['db']->getRow($sql);

        return $res;
    }

    // $address= $tools->GetEditAddressParameters();
//     print_r($address);
//

    $userInfo=getidUserInfo($id);

/*
    if($userInfo['wx_pay']==1)
    {
        //$smarty->assign('wx_pay', 1);
    }
    else
    {
        // $smarty->assign('wx_pay', 0);
    }

*/



    $smarty->assign('wx_pay', 1);
    $smarty->assign('tg_img', $nurl3.'/'.$userInfo['tg_img']);




    $smarty->assign('userInfo', $userInfo);


    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $goods_list['page']);
    $smarty->display('cs/tbhome_mycode.html');


?>