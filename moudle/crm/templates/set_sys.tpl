<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>系统设置</title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>

</head>
<style type="text/css">
<!--
	.table tr td p{margin:0px 0 0 0;padding:0;text-indent:0em;line-height:150%;}
-->
</style>
<body>

<div class="container">
  <div class="content">
  <div class="botable">


<form action="set_sys.php?m=setsys" method="POST">

<table class="table" width="100%" border="0">
<tr><th colspan="2">短信设置</th></tr>   
   
  <tr>
  <td  style="text-align:right; width:40%" >短信设置&nbsp;&nbsp;&nbsp;</td>
  <td style="text-align:left; width:50%" >
   {if $wxextel_val==0}
  &nbsp;&nbsp;&nbsp;<input type="checkbox"  name="wxextel"/>
  {elseif $wxextel_val==1}
  &nbsp;&nbsp;&nbsp;<input type="checkbox"  name="wxextel"  checked="checked"/>
  {/if}
  </td>
  
  </tr>
    <tr>
  <td  style="text-align:right; width:40%" >账号&nbsp;&nbsp;&nbsp;</td>
  <td style="text-align:left; width:50%" >&nbsp;&nbsp;&nbsp;<input type="text" value="{$get_wxextel.0.note}"  name="wx_name"/></td>
  
  </tr>
    <tr>
  <td  style="text-align:right; width:40%" >密码&nbsp;&nbsp;&nbsp;</td>
  <td style="text-align:left; width:50%" >&nbsp;&nbsp;&nbsp;<input type="password" value="{$get_wxextel.1.note}" name="wx_password" /></td>
  
  </tr>
   
   
   
   <tr>
  <td  style="text-align:right; width:40%" >邮箱smtp账号设置&nbsp;&nbsp;&nbsp;</td>
  <td style="text-align:left; width:50%" >
   {if $smtp_val==0}
  &nbsp;&nbsp;&nbsp;<input type="checkbox"  name="smtp"/>
  {elseif $smtp_val==1}
  &nbsp;&nbsp;&nbsp;<input type="checkbox"  name="smtp"  checked="checked"/>
  {/if}
  </td>
  
  </tr>
    <tr>
  <td  style="text-align:right; width:40%" >账号&nbsp;&nbsp;&nbsp;</td>
  <td style="text-align:left; width:50%" >&nbsp;&nbsp;&nbsp;<input type="text" value="{$smtp.0.note}"  name="smtp1"/></td>
  
  </tr>
    <tr>
  <td  style="text-align:right; width:40%" >密码&nbsp;&nbsp;&nbsp;</td>
  <td style="text-align:left; width:50%" >&nbsp;&nbsp;&nbsp;<input type="password" value="{$smtp.1.note}" name="smtp2" /></td>
  
  </tr>
  
   <tr><td colspan="2"  style="text-align: center;"><input  id="queding" type="submit" value="确定"/>&nbsp;<input  type="button" value="取消" id="quxiao" onclick="location=location"/></td></tr>
</table>
</form>









</div>
   <!-- end .content --></div>
<!-- end .container --></div>
</body>
</html>

