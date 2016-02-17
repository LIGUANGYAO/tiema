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
{if $fall==addlist}

<form action="set_list.php?action=add"  method="post">
 <table class="table" width="100%" border="0" style="margin-bottom: 7px;">
 <tr><th colspan="2">修改文章列表1</th></tr>
	<tr>
		<td>分类名:</td>
		<td><input type="text" name="list_name"  size="30" value=""></input></td>
	</tr>
	<tr>
	<td>类型:</td>
		<td>
		<select name="list_fl" size="1">
		  <option value="1" selected="selected">列表</option>
		  <option value="2">明细</option>
		 
		</select>
		
		</td>
	</tr>
	<td>是否显示:</td>
		<td>
		<input type="radio" name="is_show"  value="1" checked />是<input type="radio" name="is_show"  value="2" />否
		
		</td>
	</tr>
	
	<tr>
		<td>描述:</td>
		<td>
			<input type="text" name="list_note"  size="30" value=""></input>
		</td>
	</tr>
	
	<tr>
		<td>排序:</td>
		<td>
			<input type="text" name="sort_no"  size="30" value=""></input>
		</td>
	</tr>
	
	<tr>
		<td  colspan="2" align="center"><input name="tijiao" type="submit" value="提交" />
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="reset" type="reset" value="重置" />		
		</td>
		</tr>
</table>
</form>
{/if}  
  
  
{if $fall==update}

<form action="set_list.php?action=edit&id={$set_list.id}"  method="post">
<table class="table" width="100%" border="0" style="margin-bottom: 7px;">
 <tr><th colspan="2">修改文章列表</th></tr>
	<tr>
		<td>分类名:</td>
		<td><input type="text" name="list_name"  size="30" value="{$set_list.list_name}"></input></td>
	</tr>
	<tr>
	<td>类型:</td>
		<td>
		<select name="list_fl" size="1">
		
		<option value="{$set_list.list_fl}"  selected="selected">
  {if $set_list.list_fl==1}列表{/if}
   {if $set_list.list_fl==2}明细{/if}
    <option value="1" >列表</option>
		  <option value="2">明细</option>
		</select>
		
		</td>
	</tr>
	<td>是否显示:</td>
		<td>
		{if $set_list.is_show==1}
		<input type="radio" name="is_show"  value="1" checked />是
		<input type="radio" name="is_show"  value="2" />否
		{/if}
		{if $set_list.is_show==2}
		<input type="radio" name="is_show"  value="1"  />是
		<input type="radio" name="is_show"  value="2" checked />否
		{/if}
		</td>
	</tr>
	
	<tr>
		<td>描述:</td>
		<td>
        <textarea type="text" name="list_note" style="width:250px;height:100px">{$set_list.list_note}</textarea>
			
		</td>
	</tr>
	
	<tr>
		<td>排序:</td>
		<td>
			<input type="text" name="sort_no"  size="30" value="{$set_list.sort_no}"></input>
		</td>
	</tr>
	
	<tr>
		<td  colspan="2" align="center"><input name="tijiao" type="submit" value="提交" />
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="reset" type="reset" value="重置" />		
		</td>
		</tr>
</table>
</form>
{/if}
{if $fall==i_staus}
<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>添加文本模板</b></td></tr>
 <tr><td>{$val}<a href="set_list.php">&nbsp;&nbsp;&nbsp;返回</a></td></tr>
</table>
{/if}
</div>
   <!-- end .content --></div>
<!-- end .container --></div>
</body>
</html>
