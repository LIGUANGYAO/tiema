WEIXIN_SEND
==================

使用:

1. 先在conifg.php中配置公共账号信息:
```php
	$G_CONFIG["weiXin"] = array(
		'account' => '微信公告帐号',
		'password' => '微信密码',
		'cookiePath' => $G_ROOT. '/cache/cookie', // cookie缓存文件路径
		'webTokenPath' => $G_ROOT. '/cache/webToken', // webToken缓存文件路径
	);
```

2. test.php:
```php
	require "config.php";
	require "include/WeiXin.php";

	$weiXin = new WeiXin($G_CONFIG['weiXin']);
	
	$testFakeId = "30566715"; //用户1的fakeid
	$testFakeId2 = "2593741120";//用户2的fakeid
	
	// 发送消息
	print_r($weiXin->send($testFakeId, "test"));
	
	// 发送图片, 图片必须要先在公共平台中上传, 得到图片Id
	print_r($weiXin->sendImage($testFakeId, "10000001"));
	
	// 批量发送
	print_r($weiXin->batSend(array($testFakeId, $testFakeId2), "test batSend"));
	
	// 得到用户信息
	print_r($weiXin->getUserInfo($testFakeId));
	
	// 得到最新消息
	print_r($weiXin->getLatestMsgs());

	// 得到用户fakeid
	print_r($weiXin->getFakeid(100)); //分页量

	// 得到用户分组信息
	print_r($weiXin->getGroups());

```
