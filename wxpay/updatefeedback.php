<?php


include_once ("WxPayHelper.php");


$op = "oRq2yuDiVWbpXSw1-gYtS--M_KzQ";
$access_token="aBNTUNf6Gso9AKqbxWf-130Yg1CV62AwgcgLaDbtcGonpBrAavA2kp28thdgqkEsFAeFntDkgLjllkmPuJvDuA";
$url = "https://api.weixin.qq.com/payfeedback/update?access_token=".$access_token."&openid=".$op."&feedbackid=13308890365192809955";

$result = https_request($url);
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
?>