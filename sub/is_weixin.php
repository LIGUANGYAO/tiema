<?php


function is_weixin(){

if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {


return true;

}
else{
    header("Location: is_weixin.html"); 
?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>΢��</title>
		<meta name="viewport"
			content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
	
	
        
       </head>
		<!-- cms��Ƕҳ���°�cms����ҳ -->

	<body>
   <a style="color: green;">��ʹ��΢��������򿪸�ҳ��,linux_error</a>
</body>

</html>

<?php
exit;
return false;

}
}
is_weixin();



?>