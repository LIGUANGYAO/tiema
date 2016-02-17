<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title></title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/jquery.tabso_yeso.js"></script>
<script type="text/javascript">
 function SwapTxt()
  {
  var url1='index.php?act=index&type=';
  var url2='&slide2_sn=';
  var slide2_sn = document.getElementById("slide2_sn").value;//获取文本框里的值 
  var type = document.getElementById("type").value;//获取文本框里的值 
	   //document.getElementById("action_url").value= url1+type+url2+slide2_sn ;
           document.getElementById("action_url").innerHTML= url1+type+url2+slide2_sn ;//在#lyny显示文本框的值
		}
</script> 
</head>
<style type="text/css">
<!--

.demo {
	width:98%;
    margin-top: 5px; 
  
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
				.bttnn{position:relative;overflow: hidden;margin-right:4px;display:inline-block; padding:4px;*display:inline;font-size:12px;line-height:14px;color:#fff;text-align:center;vertical-align:middle;cursor:pointer;background-color:#679ef0;border:1px solid #cccccc;border-color:#e6e6e6 #e6e6e6 #bfbfbf;border-bottom-color:#b3b3b3;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;}   
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
	

	 <form name="myform" method="post" action="slide2.php?act=post" enctype="multipart/form-data">
    <ul class="tabbtn" id="move-animate-left">
		<li class="current" id="sub1"><a >模板信息</a></li>
		<li id="sub2"><a >图片信息</a></li>
	
	</ul><!--tabbtn end-->

   
	<div class="tabcon" id="leftcon"  >
    
    <div  id="m1"><table class="table" width="100%" border="0">
   
  <tr><td>代码:</td><td><input disabled="true"  type="text" value="{$slide2_mx.slide2_sn}" /><input name="slide2_sn" id="slide2_sn"  type="hidden" value="{$slide2_mx.slide2_sn}" /><a style="color:red;">*</a></td></tr>
  <tr><td>名称:</td><td><input name="slide2_name"  id="slide2_name" type="text" value="{$slide2_mx.slide2_name}" /><a style="color:red;">*</a></td></tr>
  
   <tr><td>名称:</td><td>
       <select  name="type" id="type" style="width: 100px;" onchange="SwapTxt()"> 
            <option value="{$slide2_mx.type}">{if $slide2_mx.type==0}单页{/if}{if $slide2_mx.type==1}列表{/if}{if $slide2_mx.type==2}表单{/if}</option>
            <option value="0">单页</option> 
            <option value="1">列表</option>
            <option value="2">表单</option>
       </select></td></tr>
  
  
  <tr><td>内容:</td><td><textarea name="slide2_note_1" id="slide2_note_1" style="width:300px;height:150px;">{$slide2_mx.slide2_note_1}</textarea></td></tr>
  <tr><td>url指向:</td><td><textarea name="action_url" id="action_url" style="width:300px;height:100px;" onfocus="this.blur()">{$slide2_mx.action_url}</textarea></td></tr>

  <tr><td>排序:</td><td><input name="sort_no"  id="sort_no" type="text"  value="{$slide2_mx.sort_no}"/></td></tr>
 
  
</table>
    
    
    
    </div>
	<div  style="display: none;" id="m2">
    {foreach from=$slide2_imgs item=slide2_imgs}
      <table width="100%"  class="table_img" >
    <tr>

    <td> <img  id="img_mx"  src="{$slide2_imgs.s_img_url}" title="图片{$slide2_imgs.0}"/></td>
    <td><table class="table_img" style="width: 400px;height: 100px; text-align: left; padding: 0px;margin: 0px;"><tr style="height: 40px;"><td>图片编码:&nbsp;&nbsp;&nbsp;{$slide2_imgs.img_outer_id}&nbsp;&nbsp;&nbsp;&nbsp;添加时间:&nbsp;&nbsp;&nbsp;{$slide2_imgs.add_time}</td></tr>
<tr style="height: 40px;">
<td>操作:&nbsp;&nbsp;&nbsp;<img id="delete_z_sn"   name="{$slide2.slide2_sn}" title="{$slide2_imgs.img_outer_id}" src="images/icon_drop.gif"/>&nbsp;&nbsp;&nbsp;
是否显示在微信：&nbsp;&nbsp;&nbsp;{if $slide2_imgs.ss==1}<img id="img_jy"   name="{$slide2.slide2_sn}" title="{$slide2_imgs.img_outer_id}" alt="0" src="images/yes.gif"/>{else}
<img id="img_xs"  alt="1"  name="{$slide2.slide2_sn}" title="{$slide2_imgs.img_outer_id}" src="images/no.gif"/>{/if}</td>
</tr>
<tr style="height: 30px;"><td>url指向:&nbsp;<textarea  name="img_action_url[]" style="width: 300px; height: 40px;">{$slide2_imgs.img_action_url}</textarea></td></tr>
<tr style="height: 30px;"><td>备注1:&nbsp;&nbsp;&nbsp;<textarea  name="img_note_1[]" style="width: 300px; height: 40px;">{$slide2_imgs.img_note_1}</textarea></td></tr>
<tr style="height: 30px;"><td>备注2:&nbsp;&nbsp;&nbsp;<textarea  name="img_note_2[]" style="width: 300px; height: 40px;">{$slide2_imgs.img_note_2}</textarea></td></tr>
<tr style="height: 30px;"><td>备注3:&nbsp;&nbsp;&nbsp;<textarea  name="img_note_3[]" style="width: 300px; height: 40px;">{$slide2_imgs.img_note_3}</textarea></td></tr>
<tr style="height: 30px;"><td>最后更新时间:&nbsp;&nbsp;&nbsp;{$slide2_imgs.last_update}</td></tr>
    </table><input  type="hidden" name="img_code[]" value="{$slide2_imgs.img_outer_id}"/></td>
    
    </tr>
    </table>
 

    {/foreach }
        <a>&nbsp;<a style="color:red;">注:</a>为了微信显示美观,单图文图片上传需要 宽高 比例大约  2.5:1  的图片</a> 
<br />
<a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;多图文主图片 宽高 比例大约  2.5:1  ,附图比例为  1:1</a> 
        <br />
    &nbsp;图片1:<input  type="file" name="pic1"/>  &nbsp;<img  id="add_images" src="images/icon_add.gif" title="增加图片"/><br />
    
     <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
     
    
    
    </div>
    <div align="center" style="padding: 10px;"><input  type="submit"  id="btn_queren2" value="确认"  class="bttnn"/>&nbsp;<input  type="button" onclick="location='slide2.php'" value="返回" class="bttnn"/></div>
	</div>
    
    
    
	</form>


	
</div><!--tabbox end-->







{/if}
	
{if $fall==post}
<div class="demo">	
	

	<ul class="tabbtn" id="move-animate-left">
		<li class="current" id="sub1"><a >修改成功</a></li>
	<li class="current" id="sub1" onclick="location='slide2.php'"><a >返回</a></li>
	
	</ul><!--tabbtn end-->


	
    


	
</div><!--tabbox end-->

{/if}
{if $fall==add_slide2_list}
<div class="demo">	
	

	
    <ul class="tabbtn" id="move-animate-left">
		<li class="current" id="sub1"><a >模板信息</a></li>
		<li id="sub2"><a >图片信息</a></li>
	
	</ul><!--tabbtn end-->


	<div class="tabcon" id="leftcon"  >
    <div  id="m1"><table class="table" width="100%" border="0" >
    <form name="myform" method="post" action="slide2.php?act=post_add" enctype="multipart/form-data">   
  <tr><td>代码:</td><td><input name="slide2_sn" id="slide2_sn"  type="text" onkeyup="SwapTxt()"/><a style="color:red;">*</a></td></tr>
  <tr><td>名称:</td><td><input name="slide2_name"  id="slide2_name" type="text" /><a style="color:red;">*</a></td></tr>
  
  <tr><td>类型:</td><td>
  <select  name="type" id="type" style="width: 100px;" onchange="SwapTxt()"> 
            <option value="0">单页</option> 
            <option value="1">列表</option>
            <option value="2">表单</option>
       </select>
       </td></tr>
  
  <tr><td>内容:</td><td><textarea name="slide2_note_1" id="slide2_note_1" style="width:300px;height:150px;"></textarea></td></tr>
<tr><td>url指向:</td><td><textarea name="action_url" id="action_url" style="width:300px;height:100px;" onfocus="this.blur()"></textarea>

</td></tr>
  <tr><td>排序:</td><td><input name="sort_no"  id="sort_no" type="text"  value="0"/></td></tr>


 

  
</table>
    
    
    
    </div>
	<div  style="display: none;" id="m2">
    {foreach from=$slide2_imgs item=slide2_imgs}
      <table width="100%"  class="table_img" >
    <tr>

    <td> <img  id="img_mx"  src="{$slide2_imgs.s_img_url}" title="图片{$slide2_imgs.0}"/></td>
    <td><table class="table_img"  style="width: 400px;height: 100px; text-align: left; padding: 0px;margin: 0px;"><tr style="height: 40px;"><td>图片编码:&nbsp;&nbsp;&nbsp;{$slide2_imgs.img_outer_id}&nbsp;&nbsp;&nbsp;&nbsp;添加时间:&nbsp;&nbsp;&nbsp;{$slide2_imgs.add_time}</td></tr>
<tr style="height: 40px;">
<td>操作:&nbsp;&nbsp;&nbsp;<img id="delete_z_sn"   name="{$slide2.slide2_sn}" title="{$slide2_imgs.img_outer_id}" src="images/icon_drop.gif"/>&nbsp;&nbsp;&nbsp;
是否显示在微信：&nbsp;&nbsp;&nbsp;{if $slide2_imgs.ss==1}<img id="img_jy"   name="{$slide2.slide2_sn}" title="{$slide2_imgs.img_outer_id}" alt="0" src="images/yes.gif"/>{else}
<img id="img_xs"  alt="1"  name="{$slide2.slide2_sn}" title="{$slide2_imgs.img_outer_id}" src="images/no.gif"/>{/if}</td>
</tr>
<tr style="height: 30px;"><td>url指向:&nbsp;<textarea  name="img_action_url[]" style="width: 300px; height: 40px;">{$slide2_imgs.img_action_url}</textarea></td></tr>
<tr style="height: 30px;"><td>备注1:&nbsp;&nbsp;&nbsp;<textarea  name="img_note_1[]" style="width: 300px; height: 40px;">{$slide2_imgs.img_note_1}</textarea></td></tr>
<tr style="height: 30px;"><td>备注2:&nbsp;&nbsp;&nbsp;<textarea  name="img_note_2[]" style="width: 300px; height: 40px;">{$slide2_imgs.img_note_2}</textarea></td></tr>
<tr style="height: 30px;"><td>备注3:&nbsp;&nbsp;&nbsp;<textarea  name="img_note_3[]" style="width: 300px; height: 40px;">{$slide2_imgs.img_note_3}</textarea></td></tr>
<tr style="height: 30px;"><td>最后更新时间:&nbsp;&nbsp;&nbsp;{$slide2_imgs.last_update}</td></tr>
    </table><input  type="hidden" name="img_code[]" value="{$slide2_imgs.img_outer_id}"/></td>
    
    </tr>
    </table>
 

    {/foreach }
        <a>&nbsp;<a style="color:red;">注:</a>为了微信显示美观,单图文图片上传需要 宽高 比例大约  2.5:1  的图片</a> 
<br />
<a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;多图文主图片 宽高 比例大约  2.5:1  ,附图比例为  1:1</a> 
        <br />
    &nbsp;图片1:<input  type="file" name="pic1"/>  &nbsp;<img  id="add_images" src="images/icon_add.gif" title="增加图片"/><br />
    
     <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
     
    
    
    </div>
    <div align="center" style="padding: 10px;"><input  type="submit"  id="btn_queren2" value="确认" class="bttnn"/>&nbsp;<input  type="button" onclick="location='slide2.php'" value="返回" class="bttnn"/></div>
	</div>
    
    
    



	
</div><!--tabbox end-->

	</form>



{/if}



{if $fall==fs}
<div class="demo">	
	

	<ul class="tabbtn" id="move-animate-left">
		<li class="current" id="sub1"><a >代码已存在</a></li>
	    <li class="current" id="sub1" onclick="location='slide2.php'"><a >返回</a></li>
	
	</ul><!--tabbtn end-->


	
    


	
</div><!--tabbox end-->
{/if}

</body>  
</html>
{literal}
<script type="text/javascript">
        
        $("#slide2_sn").focus();
       $("#btn_queren2").click(function(){
           if(jQuery.trim($("#slide2_sn").attr('value'))=='')
        {
            
            $("#slide2_sn").focus();
            
            return false;
        }
        else if(jQuery.trim($("#slide2_name").attr('value'))=='')
        {
            $("#slide2_name").focus();
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
	$("#sub1").click(function (){
	   $("#m2").hide();
       $("#m1").show();
	})
    $("#sub2").click(function (){
	    $("#m1").hide();
       $("#m2").show();
	})
	//上下滑动选项卡切换
	$("#move-animate-top").tabso({
		cntSelect:"#topcon",
		tabEvent:"mouseover",
		tabStyle:"move-animate",
		direction : "top"
	});
	
	//左右滑动选项卡切换
	$("#move-animate-left").tabso({
		cntSelect:"#leftcon",
		tabEvent:"click",
		tabStyle:"move-animate",
		direction : "left"
	});
	
	//淡隐淡现选项卡切换
	$("#fadetab").tabso({
		cntSelect:"#fadecon",
		tabEvent:"mouseover",
		tabStyle:"fade"
	});
	
	//默认选项卡切换
	$("#normaltab").tabso({
		cntSelect:"#normalcon",
		tabEvent:"mouseover",
		tabStyle:"normal"
	});
	
      $("img[id='img_mx']").each(function (){
            
           $(this).dblclick(function (){
           //alert($(this).attr("name"));
           //$("#hide_img").slide2Toggle(200);
           
           
        })
        })
          $("img[id='delete_z_sn']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("是否删除图片"+$(this).attr("title"))){
             
              htmlobj=$.ajax({url:"slide2.php?act=delete&img_code="+encodeURI(encodeURI($(this).attr("title"))),async:false});
              alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slide2Toggle(200);
           
           
        })
        })
        
            $("img[id='img_jy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("title")+"图片？")){
             
              htmlobj=$.ajax({url:"slide2.php?act=img_xs&img_code="+encodeURI(encodeURI($(this).attr("title")))+"&alt="+$(this).attr("alt"),async:false});
              alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slide2Toggle(200);
           
           
        })
        })
         $("img[id='img_xs']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("显示"+$(this).attr("title")+"图片？")){
             
              htmlobj=$.ajax({url:"slide2.php?act=img_xs&img_code="+encodeURI(encodeURI($(this).attr("title")))+"&alt="+$(this).attr("alt"),async:false});
              alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slide2Toggle(200);
           
           
        })
        })
        
        $("#type").val({$slide2_mx.type});
      
       
        
</script>
{/literal}