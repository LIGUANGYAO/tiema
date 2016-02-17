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
<style type="text/css">
.btn{position: relative;overflow: hidden;margin-right: 4px;display:inline-block;*display:inline;padding:4px 10px 4px;font-size:14px;line-height:18px;*line-height:20px;color:#fff;text-align:center;vertical-align:middle;cursor:pointer;background-color:#5bb75b;border:1px solid #cccccc;border-color:#e6e6e6 #e6e6e6 #bfbfbf;border-bottom-color:#b3b3b3;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;}
.btn input {position: absolute;top: 0; right: 0;margin: 0;border: solid transparent;opacity: 0;filter:alpha(opacity=0); cursor: pointer;}
.progress { position:relative; margin-left:100px; margin-top:-24px; width:200px;padding: 1px; border-radius:3px; display:none}
.bar {background-color: green; display:block; width:0%; height:20px; border-radius: 3px; }
.percent { position:absolute; height:20px; display:inline-block; top:3px; left:2%; color:#fff }
.files{height:auto; line-height:22px; margin:10px 0}
.delimg{margin-left:20px; color:#090; cursor:pointer}
</style>
<script type="text/javascript" src="js/jquery-1.8.1.min.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript">
$(function () {
	var bar = $('.bar');
	var percent = $('.percent');
	var showimg = $('#showimg');
	var progress = $(".progress");
	var files = $(".files");
	var btn = $(".btn span");
	$("#fileupload").wrap("<form id='myupload' action='set_index_upload.php' method='post' enctype='multipart/form-data'></form>");
	$("#fileupload").change(function(){
		$("#myupload").ajaxSubmit({
			dataType:  'json',
			beforeSend: function() {
        		showimg.empty();
				progress.show();
        		var percentVal = '0%';
        		bar.width(percentVal);
        		percent.html(percentVal);
				btn.html("上传中...");
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
        		var percentVal = percentComplete + '%';
        		bar.width(percentVal);
        		percent.html(percentVal);
    		},
			success: function(data) {
			//	files.html("<b>"+data.name+"("+data.size+"k)"+data.pic+"</b>   <span class='delimg' rel='"+data.pic+"'>删除</span>");
			files.html("<span class='delimg' rel='"+data.pic+"'>删除</span>");
				var img = "files/"+data.pic;
                if(img!=""){
				
			    $("#fileupload").attr("disabled","true");
	            showimg.html("<img src='"+img+"' width='240' height='400'>");                    
                btn.html("已添加");
                $("#aaa").val(data.pic);
			}else{
			    showimg.html("<img src='"+img+"' width='240' height='400'>");
                btn.html("添加附件");    
			}
				
			},
			error:function(xhr){
				btn.html("上传失败");
				bar.width('0')
				files.html(xhr.responseText);
			}
		});
	});
	
	$(".delimg").live('click',function(){
		var pic = $(this).attr("rel");
         $("#fileupload").removeAttr("disabled");
		$.post("set_index_upload.php?act=delimg",{imagename:pic},function(msg){
			if(msg==1){
                btn.html("添加附件");
                files.html("删除成功.");
                $("#aaa").attr("value","");
				$("#shanchu").attr("disabled","true");
                showimg.empty();
				progress.hide();
			}else{
				alert(msg);
			}
		});
	});
});
</script>
</head>

<body>

<div class="container">
  <div class="content">
<div class="botable">

{if $action==addnews}
<form action="set_index.php?action=add"  method="post">
<table class="table" width="1000">
	<tr>
		<td>微官网标题:</td>
		<td><input type="text" name="title"  size="30" value=""></input></td>
	</tr>
		<tr>
		<td>触发关键词:</td>
		<td><input type="text" name="keyword"  size="30" value=""></input></td>
	</tr>
	
	<tr>
		<td>匹配模式:</td>
		<td><input type="radio" name="mate"  value="1" checked />完全匹配<input type="radio" name="mate"  value="2" />包含匹配</td>
	</tr>
	
		<tr>
		<td>图片消息封面:</td>
		<td><div class="btn">
            <span>添加附件(建议分辨率480*640像素)</span>
            <input id="fileupload" type="file" name="mypic">
            </div>
          <input id="aaa" type="text" name="imgurl" readonly>
          <div class="files"></div>
          <div id="showimg"></div>
		</td>
	</tr>
	<tr>
		<td>图文消息内容:</td>
		<td>
			<textarea id="editor_id" name="content"   style="width:720px;height:180px;"></textarea>
		</td>
	</tr>
		<tr>
		<td>首页地址:</td>
		<td>
			123123123
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
<form action="set_index.php?action=edit&id={$set_index.id}"  method="post">
<table class="table" width="1000">
	<tr>
		<td>微官网标题:</td>
		<td><input type="text" name="title"  size="30" value="{$set_index.title}"></input></td>
	</tr>
		<tr>
		<td>触发关键词:</td>
		<td><input type="text" name="keyword"  size="30" value="{$set_index.keyword}"></input></td>
	</tr>
	
	<tr>
		<td>匹配模式:</td>
		<td><input type="radio" name="mate"  value="1" checked />完全匹配<input type="radio" name="mate"  value="2" />包含匹配</td>
	</tr>
	
		<tr>
		<td>图片消息封面:</td>
		<td><div class="btn">
		{if $set_index.imgurl!=''}
            <span>已添加</span>添加附件(建议分辨率480*640像素)
			{else}
			<span>添加附件</span>添加附件(建议分辨率480*6400像素)
			{/if}
            <input id="fileupload" type="file" name="mypic">
            </div>
          <input id="aaa" type="text" name="imgurl" value="{$set_index.imgurl}" readonly>
		  {if ($set_index.imgurl!='') && ($file_path!='')}
		  <div class="files"><img src="files/{$set_index.imgurl}" width="150"><span class="delimg" id="shanchu" rel="{$set_index.imgurl}">删除</span></div>
		  {else}
          <div class="files"></div>
		  {/if}
          <div id="showimg"></div>
		</td>
	</tr>
	<tr>
		<td>图文消息内容:</td>
		<td>
			<textarea id="editor_id" name="content"   style="width:720px;height:180px;">{$set_index.content}</textarea>
		</td>
	</tr>
		<tr>
		<td>首页地址:</td>
		<td>
			123123123
		</td>
	</tr>
	<tr>
		<td  colspan="2" align="center"><input name="tijiao" type="submit" value="保存" />
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="reset" type="reset" value="重置" />		
			<input name="button" type="button" value="修改" onclick="location='set_index.php?action=update'" />
		
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
