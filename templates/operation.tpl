<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员中心</title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/tablecloth.js"></script>
</head>

<body>

<div class="container">
  <div class="content">
  <div class="botable">
 <table class="table" width="100%" border="0" style="margin-bottom: 7px;">

 <form>
 <tr>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>


 </form>
</table>


   <table class="table" width="100%" border="0">
   
   <tr>
   <th >openid</th>
   <th >昵称</th>
   <th>类型</th>
   <th>内容</th>
   <th>事件类型</th>
   <th>关键字</th>
   <!--<th>回复url</th>-->
   <th>回复信息代码</th>
   <th>回复信息名称</th>
   <th>回复时间</th>
   
   </tr>
<tbody  id="table_t">
   {foreach from=$infolist item=infolist}
  <tr>
  <td >{$infolist.openid}</td>
  <td >{$infolist.nick_name}</td>
  <td>{$infolist.type}</td>
  <td >{$infolist.content}</td>
  <td >{$infolist.event_type}</td>
  <td >{$infolist.event_key}</td>
 <!-- <td >{$infolist.re_url}</td>-->
  <td >{$infolist.re_sn}</td>
  <td >{$infolist.re_name}</td>
  <td >{$infolist.add_time}</td>
  

  
  </tr>
  {foreachelse}
  <tr>
  <td  colspan="20">无记录</td>
  </tr>
   {/foreach}
  
</tbody>
</table>


<table class="table" width="100%" border="0">
<tr><td style="text-align: right;">{include file="foot.tpl"}</td></tr> 
</table>
















</div>
   <!-- end .content --></div>
<!-- end .container --></div>
</body>
</html>

