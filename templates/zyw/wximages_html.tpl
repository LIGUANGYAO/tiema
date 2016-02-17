<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>{$wximages.title}</title>
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta charset="utf-8">
<link href="../../templates/zyw/css/css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../templates/zyw/js/zepto.min.js"></script>
</head>
<body>
<header>
<div class="back" onClick="history.go(-1)" ></div>
<div class="title">{$wximages.title}</div>
<div class="controls"><a href="../../zywindex.php"><img src="../../templates/zyw/images/icon-toggle.png"></a></div> 
</header>
<div class="block47"></div>
<div class="detail">

<h1>{$wximages.title}</h1>
<p>{$wximages.wximages_note_1}</p>
</div>
<div class="recommend">
<h1>推荐阅读</h1>
<ul>
     {foreach from=$wximages.wximagestj item=wximages.wximagestj}
	<a href="{$wximages.wximagestj.tj_url}"> <li>{$wximages.wximagestj.title}</li></a>
	 {/foreach}
</ul>
</div>

	
</body>
</html>
	
