<?php


include_once ("WxPayHelper.php");


//2.准备参数
$deliver_timestamp = time();
//2.1构造最麻烦的app_signature
$obj['deliver_timestamp'] = time();
$obj['appid'] = APPID;
$obj['appkey'] = APPKEY;
$obj['openid'] = "oRq2yuDiVWbpXSw1-gYtS--M_KzQ";
$obj['transid'] = "1219855801201407203171124697";
$obj['out_trade_no'] = "56656566";
//
//   	$d['transid']        = $_GET['transaction_id'];
//	$d['out_trade_no']   = $_GET['out_trade_no'];


$obj['deliver_status'] = "1";
$obj['deliver_msg'] = "OK";

$WxPayHelper = new WxPayHelper();
//get_biz_sign函数受保护，需要先取消一下，否则会报错
$app_signature = $WxPayHelper->get_biz_sign($obj);

//3. 将构造的json提交给微信服务器，查询
$jsonmenu = '
{
    "appid" : "' . $obj['appid'] . '",
    "openid" : "' . $obj['openid'] . '",
    "transid" : "' . $obj['transid'] . '",
    "out_trade_no" : "' . $obj['out_trade_no'] . '",
    "deliver_timestamp" : "' . $deliver_timestamp . '",
    "deliver_status" : "' . $obj['deliver_status'] . '",
    "deliver_msg" : "' . $obj['deliver_msg'] . '",
    "app_signature" : "' . $app_signature . '",
    "sign_method" : "sha1"
}';

$access_token="aBNTUNf6Gso9AKqbxWf-130Yg1CV62AwgcgLaDbtcGonpBrAavA2kp28thdgqkEsFAeFntDkgLjllkmPuJvDuA";
$url = "https://api.weixin.qq.com/pay/delivernotify?access_token=" . $access_token;
$result = https_request($url, $jsonmenu);
var_dump($result);

function https_request($url, $data = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}
