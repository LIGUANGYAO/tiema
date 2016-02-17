<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title></title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

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
                editor = K.create('#editor_id2',{
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
<style type="text/css">
<!--

.demo {
	width:98%;
margin-top:-15px;
  
}
.demo h2 {
	font-size:16px;
	height:44px;
	color:#3366cc;
	margin-top:0px;
}
.demo dl dt {
	font-size:14px;
	color:#ff6600;
	margin-top:0px;
	font-weight:800;
}
.demo dl dt, .demo dl dd {
	line-height:22px;
}
	.tabbtn {
	list-style-type:none;
	height:30px;
	background:url(images/tabbg.gif) repeat-x;
	border-left:solid 1px #ddd;
	border-right:solid 1px #ddd;
}
.tabbtn li {
	float:left;
	position:relative;
	margin:0 0 0 -1px;
}
.tabbtn li a {
	display:block;
	float:left;
	height:30px;
	line-height:30px;
	overflow:hidden;
	width:108px;
	text-align:center;
	font-size:12px;
	cursor:pointer;
}
.tabbtn li.current {
	border-left:solid 1px #d5d5d5;
	border-right:solid 1px #d5d5d5;
	border-top:solid 1px #c5c5c5;
}
.tabbtn li.current a {
	border-top:solid 2px #ff6600;
	height:27px;
	line-height:27px;
	background:#fff;
	color:#3366cc;
	font-weight:800;
}
/* tabcon */
.tabcon {
	border-width:0 1px 1px 1px;
	border-color:#ddd;
	border-style:solid;
	position:relative;/*必要元素*/
	

  
}
.tabcon .subbox {
	position:absolute;/*必要元素*/
	left:0;
	top:0;
}
.tabcon .sublist {
	padding:0px 0px;

}

  .table_img {   
          border: 1px solid #B1CDE3;   
            padding:0;    
           margin:0 auto;   
            border-collapse: collapse;   
       }   
         
    .table_img   td {   
            border: 1px solid #B1CDE3;   
           background: #fff;   
            font-size:12px;   
           padding: 3px 3px 3px 8px;   
          color: #4f6b72;   
        }   
-->
</style>
<body  style=" margin-top: 0px;margin-left: 5px;  padding-top: 0px;"> 
<!--
<div id="dataLoad" style="display:block">
   <table width="100%" height="100%" border="0" align="center" >
    <tr height="50%"><td align="center">&nbsp;</td></tr>
    `
    <tr><td align="center">数据载入中，请稍后......</td></tr>
    <tr height="50%"><td align="center">&nbsp;</td></tr>
   </table>
  </div>
-->
{if $fall==edit}
<div class="demo">	
	

	 <form name="myform" method="post" action="autotask_signal.php?act=post" enctype="multipart/form-data">
 

   
	<div class="tabcon" id="leftcon"  >
    
    <div  id="m1">
    
    <table class="table" width="100%" border="0">
    <th colspan="2">编辑任务</th>
    <tr><td>代码:</td><td><input disabled="true"  type="text" value="{$autotask_signal_mx.id}" /><input name="id" id="id"  type="hidden" value="{$autotask_signal_mx.id}" /><a style="color:red;">*</a></td></tr>
    <tr><td>名称:</td><td><input name="auto_desc"  id="auto_desc" type="text" value="{$autotask_signal_mx.auto_desc}" /><a style="color:red;">*</a></td></tr>
    
    
    <tr><td>运行间隔:</td><td><input name="lx_time"  id="lx_time" type="text"  value="{$autotask_signal_mx.lx_time}"/>分</td></tr>
   
    
    
    </table>

    
    
    </div>
	
    <div align="center" style="padding: 10px;"><input  type="submit"  id="btn_queren2" value="确认" />&nbsp;<input  type="button" onclick="location='autotask_signal.php'" value="返回" /></div>
	</div>
    
    
    
	</form>


	
</div><!--tabbox end-->







{/if}
	
{if $fall==post}



<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>编辑任务</b></td></tr>
 <tr><td>修改成功<a href="autotask_signal.php">返回</a></td></tr>
</table>
{/if}
{if $fall==add_autotask_signal_list}
<div class="demo">	
<form name="myform" method="post" action="autotask_signal.php?act=post_add" enctype="multipart/form-data">   
   <div class="tabcon" id="leftcon"  >
    <div  id="m1"><table class="table" width="100%" border="0" >
 <th colspan="2">编辑文章</th>
 <tr><td>代码:</td><td><input name="autotask_signal_sn" id="autotask_signal_sn"  type="text" /><a style="color:red;">*</a></td></tr>
  <tr><td>名称:</td><td><input name="autotask_signal_name"  id="autotask_signal_name" type="text" value="{$autotask_signal_mx.autotask_signal_name}" /><a style="color:red;">*</a></td></tr>
 
 
  <tr><td>排序:</td><td><input name="sort_no"  id="sort_no" type="text"  value="{$autotask_signal_mx.sort_no}"/></td></tr>
 <tr><td>标题:</td><td><input  style="width:300px" name="title"  id="title" type="text" value="{$autotask_signal_mx.title}" /></td></tr>
 
 <tr><td>类型:</td><td>
       <select  name="autotask_signal_lx" id="autotask_signal_lx" style="width: 100px;"> 
            <option value="0">未选择</option> 
            <option value="1">普通文章</option>
            <option value="2">后台文章</option>
       </select>
       &nbsp;&nbsp;&nbsp;
        <select  name="autotask_signal_msg" id="autotask_signal_msg" style="width: 100px;"> 
            <option value="0">未选择</option> 
            {foreach from=$res_slide2 item=res_slide2}
	        <option value="{$res_slide2.slide2_sn}">{$res_slide2.slide2_name}</option>
		    {/foreach}
       </select>
        &nbsp;&nbsp;&nbsp;<a style="color:red;">注:普通文章会在微网前台显示，后台文章则不会</a>
  </td> </tr>
 
<tr><td>文章内容:</td><td><textarea id="editor_id" name="autotask_signal_note_1"   style="width:620px;height:210px;"></textarea></td></tr>	
  <tr><td>添加企业推广</td><td><input type="checkbox" id="is_tuig" name="is_tuig" /></td></tr>
  <tr><td>二维码内容</td><td><textarea id="editor_id2" name="autotask_signal_note_2"   style="width:620px;height:210px;">
 

  </textarea></td></tr>
  <tr><td>seo关键字:</td><td><input name="seo"  id="seo" type="text" value="{$autotask_signal_mx.seo}" /></td></tr>
 

  
</table>
    
    
    
    </div>
	
    <div align="center" style="padding: 10px;"><input  type="submit"  id="btn_queren2" value="确认" />&nbsp;<input  type="button" onclick="location='autotask_signal.php'" value="返回" /></div>
	</div>
    
    
    
	</form>


	
</div><!--tabbox end-->





{/if}



{if $fall==fs}
	
	



<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>代码已存在</b></td></tr>
 <tr><td>代码已存在<a href="autotask_signal.php">返回</a></td></tr>
</table>
	
    



{/if}

</body>  
</html>
{literal}
<script type="text/javascript">
        
        $("#autotask_signal_sn").focus();
       $("#btn_queren2").click(function(){
           if(jQuery.trim($("#autotask_signal_sn").attr('value'))=='')
        {
            
            $("#autotask_signal_sn").focus();
            
            return false;
        }
        else if(jQuery.trim($("#autotask_signal_name").attr('value'))=='')
        {
            $("#autotask_signal_name").focus();
            return false;
        }
        else
        {
            
            if(confirm("确认修改")){
                
            }
            else
            {
                return false;
            }
        }
       })
   

    
    var i=2;
   $("#add_images").click(function (){
        
        
        $("#m2").append('&nbsp;图片'+i+':<input type="file" name="pic'+i+'"/>  &nbsp;<br />');
        i++;

        //alert(1);
   })

      $("img[id='img_mx']").each(function (){
            
           $(this).dblclick(function (){
           //alert($(this).attr("name"));
           //$("#hide_img").autotask_signalToggle(200);
           
           
        })
        })
          $("img[id='delete_z_sn']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("是否删除图片"+$(this).attr("title"))){
             
              htmlobj=$.ajax({url:"autotask_signal.php?act=delete&img_code="+encodeURI(encodeURI($(this).attr("title"))),async:false});
              alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").autotask_signalToggle(200);
           
           
        })
        })
        
            $("img[id='img_jy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("title")+"图片？")){
             
              htmlobj=$.ajax({url:"autotask_signal.php?act=img_xs&img_code="+encodeURI(encodeURI($(this).attr("title")))+"&alt="+$(this).attr("alt"),async:false});
              alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").autotask_signalToggle(200);
           
           
        })
        })
         $("img[id='img_xs']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("显示"+$(this).attr("title")+"图片？")){
             
              htmlobj=$.ajax({url:"autotask_signal.php?act=img_xs&img_code="+encodeURI(encodeURI($(this).attr("title")))+"&alt="+$(this).attr("alt"),async:false});
              alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").autotask_signalToggle(200);
           
           
        })
        })
        
        $("#type").val({$autotask_signal_mx.type});
       $("#autotask_signal_lx").val({$autotask_signal_mx.autotask_signal_lx});
       $("#autotask_signal_msg").val({$autotask_signal_mx.autotask_signal_msg});
            
      
        if({$autotask_signal_mx.is_tuig}==1)
        {
           
            $("#is_tuig").attr("checked",true);
        }
        else
        {
            $("#is_tuig").attr("checked",false);
        }
        
</script>
{/literal}