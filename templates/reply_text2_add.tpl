<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/menu.css" rel="stylesheet" type="text/css" />
<title>无标题文档</title>

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script charset="utf-8" src="kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="kindeditor/lang/zh_CN.js"></script>
<script>
        var editor;
        KindEditor.ready(function(K) {
                editor = K.create('#editor_id',{
					resizeType : 1,
					allowPreviewEmoticons : true,
					allowImageUpload : true,
					items : [
						'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
						'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
						'insertunorderedlist', '|', 'emoticons', 'image', 'link']
				});
        });
</script>
</head>

<body>

<div class="container">
<div class="content">
<div class="botable">
{if $action==addnews}

<form action="reply_text.php?action=add"  method="post">
<table class="table">
	<tr>
		<td>标题:</td>
		<td><input type="text" name="title"  size="30" value=""></input></td>
	</tr>
	<tr>
	<td>类型:</td>
		<td>
		<select name="bid" size="1">
		 {foreach from=$news_menu item=news_menu}
		  <option value="1" >{$news_menu.name}</option>
	
		  {/foreach}
		</select>
		
		<select name="bid" size="1">
		  <option value="1" selected="selected">综合</option>
		  <option value="2">娱乐</option>
		  <option value="3">生活</option>
		  <option value="4">科技</option>
		</select>
		
		</td>
	</tr>
	<tr>
		<td>内容:</td>
		<td>
			<textarea id="editor_id" name="content"   style="width:320px;height:300px;"></textarea>
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
  
  
{if $action==update}
<h1 align="center">修改新闻</h1>
<form action="reply_text.php?action=edit&id={$news_mx.id}"  method="post">
<table class="table">
	<tr>
		<td>标题:</td>
		<td><input type="text" name="title"  size="30" value="{$news_mx.title}"></input></td>
	</tr>
	<tr>
	<td>类型:</td>
		<td>
		<select name="bid" size="1">
  <option value="{$news_mx.bid}"  selected="selected">
  {if $news_mx.bid==1}综合{/if}
  {if $news_mx.bid==2}娱乐{/if}
  {if $news_mx.bid==3}生活{/if}
  {if $news_mx.bid==4}科技{/if}
  </option>
          <option value="1">综合</option>
		  <option value="2">娱乐</option>
		  <option value="3">生活</option>
		  <option value="4">科技</option>
  </select>
		</td>
	</tr>
	<tr>
		<td>内容:</td>
		<td>
			<textarea id="editor_id" name="content"   style="width:320px;height:480px;">{$news_mx.content}</textarea>
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
</div>
   <!-- end .content --></div>
<!-- end .container --></div>
</body>
</html>
