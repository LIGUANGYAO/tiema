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
{if $fall==1}

   
 <table class="table" width="100%" border="0" style="margin-bottom: 7px;">

 <form>
 <tr>
 <th style="text-align: left;border-right-style:none"><input id="a_text" value="添加模板" type="button" onclick="location='imgtext.php?act=add_imgtext_list'" />&nbsp;<input id="down_hy" value="头像下载" type="hidden" /></th>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>


 </form>
</table>
    


   <table class="table" width="100%" border="0">
   
 <tr>
  
    <td id="td2">分类Id</td>
    <td>分类名称</td>
    <td>分类描述</td>
	<td>显示顺序</td>
	<td>分类类型</td>
	<td>是否显示</td>
    <td>最后修改</td>
    <td>添加时间1</td>
<td>操作1</td>
</tr>
 
<tbody  id="table_t">
 {foreach from=$list item=list}
            <tr>
	
			<td >{$list.id}</td>
            <td >{$list.list_name}</td>
            <td >{$list.list_note}</td>
            <td>{$list.sort_no}</td>
			<td>{$list.list_fl}</td>
			<td>{$list.tzsy}</td>
            <td>{$list.last_update}</td>
            <td>{$list.add_time}</td>
            <td> <a href="set_list.php?action=update&id={$list.id}">修改</a>  <a href="set_list.php?action=delete&id={$list.id}">删除</a></td>
			</tr>
    {foreachelse}
    <tr><td class="no-records" colspan="10">无记录</td></tr>
  {/foreach}
</tbody>  
</table>


<table class="table" width="100%" border="0">
<tr><td style="text-align: right;">{include file="foot.tpl"}</td></tr> 
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
    
    
})
-->
</script>
