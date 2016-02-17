<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=gbk"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>微信支付样例-企业付款</title>
</head>
<?php
define('IN_ECS', true);
require (dirname(__file__) . '/includes/init.php');
    $sqlgh="select * from tbhome_wx_gh WHERE id = 1";
    $ghinfo=$GLOBALS['db']->getRow($sqlgh);

define('WXAPPID',$ghinfo['appid']);
define('WXAPPSECRET', $ghinfo['appkey']);
define('WXMCHID', $ghinfo['mchid']);
define('WXMCHSECRET', $ghinfo['mchkey']);
$wxSSLcert= dirname(__file__).'/wxtransfer/cert/apiclient_cert.pem';
$wxSSLkey=dirname(__file__).'/wxtransfer/cert/apiclient_key.pem';
define('WXSSLCERT', $wxSSLcert);
define('WXSSLKEY', $wxSSLkey);

require (dirname(__FILE__).'/wxtransfer/WxPay.Api.php');
ini_set('date.timezone','Asia/Shanghai');
ini_set('display_errors','On');
error_reporting(E_ALL);
///require_once "../lib/WxPay.Api.php";
//require_once 'log.php';
//初始化日志
//$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
//$log = Log::Init($logHandler, 15);
/*
function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#f00;'>$key</font> : $value <br/>";
    }
}*/

// openid、check_name、partner_trade_no、amount、desc为必填参数
if(isset($_REQUEST["openid"]) && $_REQUEST["amount"] != ""){
    $openid = $_REQUEST["openid"];
    $amount = $_REQUEST["amount"];
    $re_user_name=$_REQUEST['re_user_name'];
    $input = new WxPayTransfer();
    $input->SetOpenid($openid);//转账对象
    $input->SetAmount($amount);//金额单位分，最少100分才能转
    $input->SetRe_user_name($re_user_name);//经微信实名认证的用户真实姓名
    $input->SetCheck_name('FORCE_CHECK');//FORCE_CHECK：强校验真实姓名
    $input->SetPartner_trade_no(WxPayConfig::MCHID.date("YmdHis"));//创建转账单号
    $input->SetDesc('这个是测试：吴汉青：泉州~');//转账说明，必填！
    $result=WxPayApi::transfer($input);
//	printf_info(WxPayApi::transfer($input));
    var_dump($result);
    if ($result['return_code']=='FAIL') {
        echo $result["return_msg"];
    }else{
        if ($result['result_code']=='FAIL')
        {
            echo $result["err_code_desc"];
        }else{
            echo 'APPID'.$result["mch_appid"].'商户号'.$result["mchid"].'商户订单号'.$result["partner_trade_no"].'付款时间'.$result["payment_time"];
        }
    }
    /*NO_CHECK：不校验真实姓名
    FORCE_CHECK：强校验真实姓名（未实名认证的用户会校验失败，无法转账）
OPTION_CHECK：针对已实名认证的用户才校验真实姓名（未实名认证用户不校验，可以转账成功）*/
//	exit();
}
?>
<body>
<form action="#" method="post">
    <div style="margin-left:2%;color:#f00">提示：请保管好秘钥！否则钱会被人转走！</div><br/>
    <div style="margin-left:2%;">微信用户openid：</div><br/>
    <input type="text" style="width:96%;height:35px;margin-left:2%;" name="openid" /><br /><br />
    <div style="margin-left:2%;">验证真实姓名：</div><br/>
    <input type="text" style="width:96%;height:35px;margin-left:2%;" name="re_user_name" /><br /><br />
    <div style="margin-left:2%;">转账金额（分）：</div><br/>
    <input type="text" style="width:96%;height:35px;margin-left:2%;" name="amount" /><br /><br />
    <div align="center">
        <input type="submit" value="确认转账" style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" />
    </div>
</form>
</body>
</html>