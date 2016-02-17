<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>推送信息</title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>

<script type="text/javascript" src="js/Calendar3.js"></script>
<script type="text/javascript" src="js/jquery.tabso_yeso.js"></script>
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
     <table class="table" width="100%" border="0" style="margin-bottom: 7px;">
    <form name="myform" method="post" action="appsend.php?act=post" enctype="multipart/form-data">  
	
<tr><th colspan="4">消息推送</th></tr>
  <tr><td>代码:</td><td><input disabled="true"  type="text" value="{$appsend_mx.appsend_sn}" /><input name="appsend_sn" id="appsend_sn"  type="hidden" value="{$appsend_mx.appsend_sn}" /><a style="color:red;">*</a></td>
  <td width="150">日期</td><td><input  class="rq" value="{$appsend_mx.rq}" name="rq" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this);" readonly="readonly" /><a style="color:red;">*</a></td>
  </tr>

  
 <tr><td>名称:</td><td><input name="appsend_name"  id="appsend_name" type="text" value="{$appsend_mx.appsend_name}" /><a style="color:red;">*</a></td>
 <td width="150">推送类型</td><td>
          <select  name="re_type" id="type" style="width: 150px;"> 
            <option value="">请选择</option>
            <option value="text">文本</option>
             <!--  <option value="imgtext">图文</option>-->
          
       </select>
 </td></tr>
   <tr>
   <td>状态</td>
   
   <td>{if $appsend_mx.tzsy==1}
        已验收
       {else}
        未验收
        {/if}</td> 
   
   <td>模板</td><td>
     
       <select  name="re_code" id="type2" style="width: 150px;"> 
            <option value="">请选择</option>
      
       </select>
       
       </td>  
   </tr>
 
   <tr ><td colspan="4" style="text-align: center;">
   {if $appsend_mx.tzsy==1}
        <input  type="button" onclick="location='appsend.php'" value="返回" />
       {else}
          <input  type="submit"  id="btn_queren2" value="确认" />&nbsp;&nbsp;&nbsp;<input  type="button" onclick="location='appsend.php'" value="返回" />
        {/if}
</td></tr>
 
</table>
    </div>

{include file="appsendsearch.tpl"}

	</form>

{/if}
	
{if $fall==post}
<div class="demo">	
	

	<ul class="tabbtn" id="move-animate-left">
		<li class="current" id="sub1"><a >修改成功</a></li>
	<li class="current" id="sub1" onclick="location='appsend.php'"><a >返回</a></li>
	
	</ul><!--tabbtn end-->


	
    


	
</div><!--tabbox end-->

{/if}
{if $fall==add_appsend_list}
<div class="demo">
     <table class="table" width="100%" border="0" style="margin-bottom: 7px;">
    <form name="myform" method="post" action="appsend.php?act=post_add" enctype="multipart/form-data">  
	
<tr><th colspan="4">消息推送</th></tr>
  <tr><td>代码:</td><td><input  type="text" value="" id="appsend_sn" name="appsend_sn" /><a style="color:red;">*</a></td>
  <td width="150">日期</td><td><input  class="rq" value="" name="rq" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this);" readonly="readonly" /><a style="color:red;">*</a></td>
  </tr>

  
 <tr><td>名称:</td><td><input name="appsend_name"  id="appsend_name" type="text" value="" /><a style="color:red;">*</a></td>
 <td width="150">推送类型</td><td>
          <select  name="re_type" id="type3" style="width: 150px;"> 
            <option value="">请选择</option>
            <option value="text">文本</option>
          <!--  <option value="imgtext">图文</option>-->
          
       </select>
 </td></tr>
   <tr>
   <td>状态</td>
   
   <td>
        
        未验收
        </td> 
   
   <td>模板</td><td>
     
       <select  name="re_code" id="type4" style="width: 150px;"> 
            <option value="1">请选择</option>
      
       </select>
       
       </td>  
   </tr>
 
   <tr ><td colspan="4" style="text-align: center;">

          <input  type="submit"  id="btn_queren2" value="确认" />&nbsp;&nbsp;&nbsp;<input  type="button" onclick="location='appsend.php'" value="返回" />
    
</td></tr>
 
</table>
    </div>



	</form>



{/if}



{if $fall==fs}
<div class="demo">	
	

	<ul class="tabbtn" id="move-animate-left">
		<li class="current" id="sub1"><a >推送代码已存在</a></li>
	<li class="current" id="sub1" onclick="location='appsend.php'"><a >返回</a></li>
	
	</ul><!--tabbtn end-->


	
    


	
</div><!--tabbox end-->
{/if}

</body>  
</html>
{literal}
<script type="text/javascript">
        
        $("#appsend_sn").focus();
       $("#btn_queren2").click(function(){
           if(jQuery.trim($("#appsend_sn").attr('value'))=='')
        {
            
            $("#appsend_sn").focus();
            
            return false;
        }
        else if(jQuery.trim($("#appsend_name").attr('value'))=='')
        {
            $("#appsend_name").focus();
            
            return false;
        }
        else if(jQuery.trim($(".rq").attr('value'))=='')
        {
            $(".rq").focus();
            alert("时间不能为空!");
            
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
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
          $("img[id='delete_z_sn']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("是否删除图片"+$(this).attr("title"))){
             
              htmlobj=$.ajax({url:"appsend.php?act=delete&img_code="+encodeURI(encodeURI($(this).attr("title"))),async:false});
              alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
            $("img[id='img_jy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("title")+"图片？")){
             
              htmlobj=$.ajax({url:"appsend.php?act=img_xs&img_code="+encodeURI(encodeURI($(this).attr("title")))+"&alt="+$(this).attr("alt"),async:false});
              alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
         $("img[id='img_xs']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("显示"+$(this).attr("title")+"图片？")){
             
              htmlobj=$.ajax({url:"appsend.php?act=img_xs&img_code="+encodeURI(encodeURI($(this).attr("title")))+"&alt="+$(this).attr("alt"),async:false});
              alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        //模板选择
        $('#type').change(function (){
   
     
       //省选择清空市，市选择清空区
      htmlobj2=$.ajax({url:"appsend.php?act=get_type&type="+encodeURI(encodeURI($("#type").val())),async:false,dataType: 'json'}); 
      json = $.parseJSON(htmlobj2.responseText); 
     // alert(htmlobj.responseText);
      
      $('#type2').empty();
        $("<option >请选择</option>").appendTo('#type2');
       $.each(json, function (i, n) {  
       
                      
                        $("<option value=" + n.sn + ">"+ n.sn + "___"+ n.name + "</option>").appendTo('#type2');  
                    });  

     //alert($(this).find("option:selected").text());     
  })
  $('#type').val("{$appsend_mx.re_type}");
  $('#type').change();
   $('#type2').val("{$appsend_mx.re_code}");
      
     $('#role').val("{$appsend_mx.role}");
     
        
        
        
         $('#type3').change(function (){
   
     
       //省选择清空市，市选择清空区
      htmlobj2=$.ajax({url:"appsend.php?act=get_type&type="+encodeURI(encodeURI($("#type3").val())),async:false,dataType: 'json'}); 
      json = $.parseJSON(htmlobj2.responseText); 
     // alert(htmlobj.responseText);
      
      $('#type4').empty();
        $("<option >请选择</option>").appendTo('#type4');
       $.each(json, function (i, n) {  
       
                      
                        $("<option value=" + n.sn + ">"+ n.sn + "___"+ n.name + "</option>").appendTo('#type4');  
                    });  

     //alert($(this).find("option:selected").text());     
  })
        
        
      //添加搜索拼装事件
      $("#searchBtn").click(function(){
        //alert($("#role").val());
                htmlobj=$.ajax({
                //type:"POST",
                url:"appsend.php?act=send_users_list",
                data:{"list":$("#role").val(),"p_id":$("#appsend_sn").val()},async:false,
                beforeSend:function(XMLHttpRequest){
                    
                   
                    },
                    success:function(data,textStatus){
                    
                    //alert(data);
                    window.location.reload();
                    },
                    complete:function(XMLHttpRequest,textStatus){
                    // alert('远程调用成功，状态文本值：'+textStatus);
                   
                   // $("#load_img").empty();
                 
                  
                    },
                    error:function(XMLHttpRequest,textStatus,errorThrown){
                    // alert('error...状态文本值：'+textStatus+" 异常信息："+errorThrown);
                    //$("#load_img").empty();
                    }
                
                
                
                });
        
        
      })
        
</script>


{/literal}