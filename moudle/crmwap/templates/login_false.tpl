<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登陆失败</title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
a{color:#333;text-decoration:none;}
a:hover{color:#990000;text-decoration:underline;}
/* choose */
.choose{width:260px;margin:100px auto 0 auto;border:solid 1px #ddd;padding:15px 30px 30px 30px;}
.choosetext{height:24px;padding:20px 0;font-size:14px;}
.choosebox{padding:10px 0 35px 0;}
.choosebox li{float:left;margin-right:10px;display:inline;}
.choosebox li a{float:left;background:#fff;font-size:14px;border:1px solid #ccc;height:14px;line-height:14px;padding:4px 12px; display:block;}
.choosebox li a.current{background:url(1images/right-icon.gif) no-repeat 100% 100%;border:1px solid #A10000;}
.choosebox li input{display:none;}
.choose .btn-img{width:160px;height:50px;overflow:hidden;background:url(images/cart.gif) no-repeat;cursor:pointer;border:0;}
.choose .btn-img span{display:block;font-size:18px;font-weight:800;color:#fff;font-family:"微软雅黑","宋体";padding:0 0 0 50px;line-height:50px;}
-->
</style>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>

</head>

<body>

<div class="container">
  <div class="content">
  

 
   <div class="botable">

{if $fall==i_staus}
<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>用户名/密码错误,请重新登陆</b></td></tr>
 <tr><td><a href="index.html">返回</a>&nbsp;<a style="color:red;">2秒后退出</a></td></tr>
</table>
{/if}

</div>
   <!-- end .content --></div>
<!-- end .container --></div>
</body>
</html>
<script type="text/javascript">
<!--
$(document).ready(function ()
{       
    var timer = setTimeout(function(){
      window.location="index.html";
    }, 2000);
   
})
-->
</script>
