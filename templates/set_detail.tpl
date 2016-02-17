<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/menu.css" rel="stylesheet" type="text/css" />
<title>无标题文档</title>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>

</head>

<body>

<div class="container">
  <div class="content">
  <div class="botable">
  <table class="table" width="99%" height="20" border="1" cellpadding="0" cellspacing="0" > 
  <tr><td>
<div id="form_div">
<form id="form_1" >
页面搜索<input  type="text"  id="key"  name="key"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input  type="text"   name="title"/>&nbsp;<input  type="submit" value="搜索"/>
新建<img  id="add_images" src="images/icon_add.gif" onclick="location='set_detail.php?action=addnews'"/>
</form>
	</div></td></tr>
	</table>
<table class="table" width="99%" height="30" border="1" cellpadding="0" cellspacing="0" > 
<thead><tr>
    <td><input id="check_all" type="checkbox"/></td> 
    <td id="td2">新闻Id</td>
    <td>新闻代码</td>
    <td>类别</td>
    <td>最后修改</td>
    <td>添加时间1</td>
<td>操作1</td>
</tr>
</thead> 
<tbody id="tbody_1">
  {foreach from=$news item=news}
            <tr>
			<td  style="width: 10px; "><input type="checkbox" id="chbox" /></td>
			<td >{$news.id}</td>
            <td ><a href="html/{$news.htmlurl}" target="_blank">{$news.title}</a></td>
            <td >{$news.bid}</td>
            
            <td>{$news.last_update}1</td>
            <td>{$news.add_time}</td>
            <td> <a href="set_detail.php?action=update&id={$news.id}">修改</a>  <a href="set_detail.php?action=delete&id={$news.id}">删除</a></td>
        
			</tr>
     {foreachelse}
    <tr><td class="no-records" colspan="7">无记录</td></tr>
    {/foreach}
</tbody>  

</table>  
 <table class="table" width="99%" height="20" border="1" cellpadding="0" cellspacing="0" > 
<tr><td>

        <a >共 {$p_Array.pager_Total} 条记录，本页显示 {$p_Array.now_PageNum} 条,  当前第 {$p_Array.pager_PageID}/{$p_Array.pager_Number} 页 </a>每页显示<input id="pager_Size" style="width: 20px;height: 20px; text-align: center; "   type="text" value="{$p_Array.pager_Size}"/>
		<a href="{$p_Array.url}&pager_PageID=1">第一页</a>
		<a href="{$p_Array.url}&pager_PageID={$p_Array.pager_PageID_ow}">上一页</a>
		<a href="{$p_Array.url}&pager_PageID={$p_Array.pager_PageID_next}">下一页</a>
		<a href="{$p_Array.url}&pager_PageID={$p_Array.pager_Number}">最末页</a>
<input  type="hidden" id="now_url" value="{$p_Array.url}"/>
		跳转到<input type='text' size='3' id='page_num' value="{$p_Array.pager_PageID}"  />页
	</td></tr></table>
</div>
   <!-- end .content --></div>
<!-- end .container --></div>
</body>
</html>
