<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=gbk"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>΢��֧������-��ҵ����</title>
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
//��ʼ����־
//$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
//$log = Log::Init($logHandler, 15);
/*
function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#f00;'>$key</font> : $value <br/>";
    }
}*/

// openid��check_name��partner_trade_no��amount��descΪ�������
if(isset($_REQUEST["openid"]) && $_REQUEST["amount"] != ""){
    $openid = $_REQUEST["openid"];
    $amount = $_REQUEST["amount"];
    $re_user_name=$_REQUEST['re_user_name'];
    $input = new WxPayTransfer();
    $input->SetOpenid($openid);//ת�˶���
    $input->SetAmount($amount);//��λ�֣�����100�ֲ���ת
    $input->SetRe_user_name($re_user_name);//��΢��ʵ����֤���û���ʵ����
    $input->SetCheck_name('FORCE_CHECK');//FORCE_CHECK��ǿУ����ʵ����
    $input->SetPartner_trade_no(WxPayConfig::MCHID.date("YmdHis"));//����ת�˵���
    $input->SetDesc('����ǲ��ԣ��⺺�ࣺȪ��~');//ת��˵�������
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
            echo 'APPID'.$result["mch_appid"].'�̻���'.$result["mchid"].'�̻�������'.$result["partner_trade_no"].'����ʱ��'.$result["payment_time"];
        }
    }
    /*NO_CHECK����У����ʵ����
    FORCE_CHECK��ǿУ����ʵ������δʵ����֤���û���У��ʧ�ܣ��޷�ת�ˣ�
OPTION_CHECK�������ʵ����֤���û���У����ʵ������δʵ����֤�û���У�飬����ת�˳ɹ���*/
//	exit();
}
?>
<body>
<form action="#" method="post">
    <div style="margin-left:2%;color:#f00">��ʾ���뱣�ܺ���Կ������Ǯ�ᱻ��ת�ߣ�</div><br/>
    <div style="margin-left:2%;">΢���û�openid��</div><br/>
    <input type="text" style="width:96%;height:35px;margin-left:2%;" name="openid" /><br /><br />
    <div style="margin-left:2%;">��֤��ʵ������</div><br/>
    <input type="text" style="width:96%;height:35px;margin-left:2%;" name="re_user_name" /><br /><br />
    <div style="margin-left:2%;">ת�˽��֣���</div><br/>
    <input type="text" style="width:96%;height:35px;margin-left:2%;" name="amount" /><br /><br />
    <div align="center">
        <input type="submit" value="ȷ��ת��" style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" />
    </div>
</form>
</body>
</html>