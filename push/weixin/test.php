<?php
require "config.php";
require "include/WeiXin.php";
header("Content-type:text/html;charset=utf-8");  
$weiXin = new WeiXin($G_CONFIG['weiXin']);

$testFakeId = "1913296841"; //用户1的fakeid
//$testFakeId2 = "2593741120";//用户2的fakeid

// 发送消息
print_r($weiXin->send($testFakeId, "文字"));

// 发送图片, 图片必须要先在公共平台中上传, 得到图片Id
//print_r($weiXin->sendImage($testFakeId, "200058776"));

// 批量发送
//print_r($weiXin->batSend(array($testFakeId, $testFakeId2), "test batSend"));

// 得到用户信息
//print_r($weiXin->getUserInfo($testFakeId));

// 得到最新消息
//print_r($weiXin->getLatestMsgs());

// 得到用户fakeid
//print_r($weiXin->getFakeid(100)); //分页量

// 得到用户分组信息
//print_r($weiXin->getGroups());