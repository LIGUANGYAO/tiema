<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<style type="text/css">
<!--
body {
	font: 100%/1.4 Verdana, Arial, Helvetica, sans-serif;
	background: #FFF;
	margin: 0;
	padding: 0;
	color: #000;
}

/* ~~ 元素/标签选择器 ~~ */
ul, ol, dl { /* 由于浏览器之间的差异，最佳做法是在列表中将填充和边距都设置为零。为了保持一致，您可以在此处指定需要的数值，也可以在列表所包含的列表项（LI、DT 和 DD）中指定需要的数值。请注意，除非编写一个更为具体的选择器，否则您在此处进行的设置将会层叠到 .nav 列表。 */
	padding: 0;
	margin: 0;
}
h1, h2, h3, h4, h5, h6, p {
	margin-top: 0;	 /* 删除上边距可以解决边距会超出其包含的 div 的问题。剩余的下边距可以使 div 与后面的任何元素保持一定距离。 */
	padding-right: 15px;
	padding-left: 15px; /* 向 div 内的元素侧边（而不是 div 自身）添加填充可避免使用任何方框模型数学。此外，也可将具有侧边填充的嵌套 div 用作替代方法。 */
}
a img { /* 此选择器将删除某些浏览器中显示在图像周围的默认蓝色边框（当该图像包含在链接中时） */
	border: none;
}
/* ~~ 站点链接的样式必须保持此顺序，包括用于创建悬停效果的选择器组在内。 ~~ */
a:link {
	color: #42413C;
	text-decoration: underline; /* 除非将链接设置成极为独特的外观样式，否则最好提供下划线，以便可从视觉上快速识别 */
}
a:visited {
	color: #6E6C64;
	text-decoration: underline;
}
a:hover, a:active, a:focus { /* 此组选择器将为键盘导航者提供与鼠标使用者相同的悬停体验。 */
	text-decoration: none;
}

/* ~~ 此固定宽度容器包含所有其它元素 ~~ */
.container {
	width: 100%;
	background: #FFF;
	margin: 0 auto; /* 侧边的自动值与宽度结合使用，可以将布局居中对齐 */
}

/* ~~ 这是布局信息。 ~~ 

1) 填充只会放置于 div 的顶部和/或底部。此 div 中的元素侧边会有填充。这样，您可以避免使用任何“方框模型数学”。请注意，如果向 div 自身添加任何侧边填充或边框，这些侧边填充或边框将与您定义的宽度相加，得出 *总计* 宽度。您也可以选择删除 div 中的元素的填充，并在该元素中另外放置一个没有任何宽度但具有设计所需填充的 div。

*/
.content {
	padding: 0px;
	margin: 20px;
}

/* ~~ 其它浮动/清除类 ~~ */
.fltrt {  /* 此类可用于在页面中使元素向右浮动。浮动元素必须位于其在页面上的相邻元素之前。 */
	float: right;
	margin-left: 8px;
}
.fltlft { /* 此类可用于在页面中使元素向左浮动。浮动元素必须位于其在页面上的相邻元素之前。 */
	float: left;
	margin-right: 8px;
}
.clearfloat { /* 如果从 .container 中删除了 overflow:hidden，则可以将此类放置在 <br /> 或空 div 中，作为 #container 内最后一个浮动 div 之后的最终元素 */
	clear:both;
	height:0;
	font-size: 1px;
	line-height: 0px;
}
.hea1 {
	font-size: 14px;
	font-weight: bold;
	padding-left: 0px;
	padding-right: 10px;
}
.hea2 {
	font-size: 12px;
	color: #999;
}
.table {
	border-collapse:collapse;border-spacing:0;border-left:0px solid #888;border-top:0px solid #888;background:#fff;
}
.table tr th {
	background-color: #F1F1F1;
	text-align: left;
	height: 30px;
	border: 1px solid #e2e2e2;
	margin: 0px;
	font-size: 12px;
	font-weight: bold;
	line-height: 30px;
	padding-top: 0px;
	padding-right: 0px;
	padding-bottom: 0px;
	padding-left: 5px;
}
.table tr td {
	background-color: #FFF;
	text-align: left;
	height: 30px;
	border: 1px solid #e2e2e2;
	margin: 0px;
	font-size: 12px;
	font-weight: normal;
	line-height: 30px;
	padding-top: 0px;
	padding-right: 0px;
	padding-bottom: 0px;
	padding-left: 5px;
}
.table tr td p{margin:0px 0 0 0;padding:0;text-indent:0em;line-height:150%;}
.input_sort {
	width: 60px;
	
}
.input_memu {
	 
	
}
-->
</style>
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
新建<img  id="add_images" src="images/icon_add.gif" onclick="location='set_list.php?action=addlist'"/>
</form>
	</div></td></tr>
	</table>
<table class="table" width="99%" height="30" border="1" cellpadding="0" cellspacing="0" > 
<thead><tr>
    <td><input id="check_all" type="checkbox"/></td> 
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
</thead> 
<tbody id="tbody_1">
 {foreach from=$list item=list}
            <tr>
			<td  style="width: 10px; "><input type="checkbox" id="chbox" /></td>
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
