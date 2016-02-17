<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>订单</title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/jquery.tabso_yeso.js"></script>
<script type="text/javascript" src="js/Calendar3.js"></script>
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
	

	    <form name="myform" method="post" action="wx_order_list.php?act=post" enctype="multipart/form-data">
    <ul class="tabbtn" id="move-animate-left">
		<li class="current" id="sub1"><a >模板信息</a></li>
	
	</ul><!--tabbtn end-->

   
	<div class="tabcon" id="leftcon"  >
    
    <div  id="m1"><table class="table" width="100%" border="0">

  <tr><td>代码:</td><td><input disabled="true"  type="text" value="{$order_mx.order_sn}" /><input name="order_sn" id="order_sn"  type="hidden" value="{$order_mx.order_sn}" /><a style="color:red;">*</a></td></tr>
  <tr><td>名称:</td><td><input name="order_name"  id="order_name" type="text" value="{$order_mx.order_name}" /><a style="color:red;">*</a></td></tr>
  
  <tr><td>openid:</td><td><input name="openid"  id="openid" type="text" value="{$order_mx.openid}"/><a style="color:red;">*</a></td></tr>
  <tr><td>用户名:</td><td><input name="username"  id="username" type="text" value="{$order_mx.username}"/><a style="color:red;">*</a></td></tr>
   <tr><td>身份证:</td><td><input name="sfz"  id="sfz" type="text" value="{$order_mx.sfz}"/><a style="color:red;">*</a></td></tr>
  <tr><td>上级openid:</td><td><input name="p_openid"  id="p_openid" type="text" value="{$order_mx.p_openid}"/><a style="color:red;">*</a></td></tr>
  <tr><td>上级昵称:</td><td><input name="p_name"  id="p_name" type="text" value="{$order_mx.p_name}"/><a style="color:red;">*</a></td></tr>
  <tr><td>联系电话:</td><td><input name="tel"  id="tel" type="text" value="{$order_mx.tel}"/><a style="color:red;">*</a></td></tr>
  <tr><td>车辆识别代码:</td><td><input name="sbdm"  id="sbdm" type="text" value="{$order_mx.sbdm}"/><a style="color:red;">*</a></td></tr>
  <tr><td>车牌号:</td><td><input name="car_no"  id="car_no" type="text" value="{$order_mx.car_no}"/><a style="color:red;">*</a></td></tr>
  <tr><td>保险到期时间:</td><td><input  class="endtime" value="{$order_mx.endtime}" name="endtime" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this);"  />
  

  
  <a style="color:red;">*</a></td></tr>
  <tr><td>车船险:</td><td><input name="ccx"  id="ccx" type="text" value="{$order_mx.ccx}"/><a style="color:red;">*</a></td></tr>
  <tr><td>强制险:</td><td><input name="qzx"  id="qzx" type="text" value="{$order_mx.qzx}"/><a style="color:red;">*</a></td></tr>
  <tr><td>商业险:</td><td><input name="syx"  id="syx" type="text" value="{$order_mx.syx}"/><a style="color:red;">*</a></td></tr>
  <tr><td>实缴商业险:</td><td><input name="sjsyx"  id="sjsyx" type="text" value="{$order_mx.sjsyx}"/><a style="color:red;">*</a></td></tr>

            <tr>
                <td>
                    款项是否付清:
                </td>
                <td>


    <!--label>快速选择：</label-->
    <select id = "is_pay" name="is_pay" >
        <option value=1 >已付清</option>
        <option value=0 >未付清</option>

    </select>
<script type="text/javascript">
    document.getElementById("is_pay").value={$order_mx.is_pay};
</script>
            </tr>

  <tr><td>内容:</td><td><textarea name="bz" id="bz" style="width:300px;height:150px;">{$order_mx.bz}</textarea></td></tr>
  
  

  <td>排序:</td><td><input name="sort_no"  id="sort_no" type="text"  value="{$order_mx.sort_no}"/></td></tr>
 
  </tr>
  
</table>
    
    
    
    </div>
	
    <div align="center" style="padding: 10px;"><input  type="submit"  id="btn_queren2" value="确认" />&nbsp;<input  type="button" onclick="location='wx_order_list.php'" value="返回" /></div>
	</div>
    
    
    
	</form>


	
</div><!--tabbox end-->







{/if}
	
{if $fall==post}
<div class="demo">	
	<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>修改成功</b></td></tr>
 <tr><td>修改成功<a href="wx_order_list.php">返回</a></td></tr>
</table>


	
</div><!--tabbox end-->

{/if}
{if $fall==add_order_list}
<div class="demo">	
	

	
    <ul class="tabbtn" id="move-animate-left">
		<li class="current" id="sub1"><a >模板信息</a></li>
	
	
	</ul><!--tabbtn end-->


	<div class="tabcon"  id="leftcon"  >
    <div  id="m1" >
	 <form name="myform" method="post" action="wx_order_list.php?act=post_add" enctype="multipart/form-data">   
	<table class="table" width="100%" border="0" >
<script type="text/javascript">

function current(){ 
var d=new Date();
str=''; 
str +=d.getFullYear(); //获取当前年份 
str +=d.getMonth()+1; //获取当前月份（0——11） 
str +=d.getDate(); 
str +=d.getTime(); 
return str; }  
 
$(function(){
var $timeStr=current();
$("#order_sn").val($timeStr) ;
});
 
</script> 
  <tr><td>代码:</td><td><input name="order_sn" id="order_sn"  type="text" /><a style="color:red;">*</a></td></tr>
  <tr><td>名称:</td><td><input name="order_name"  id="order_name" type="text" /><a style="color:red;">*</a></td></tr>
  
  <tr><td>openid:</td><td><input name="openid"  id="openid" type="text" /><a style="color:red;">*</a></td></tr>
  <tr><td>用户名:</td><td><input name="username"  id="username" type="text" /><a style="color:red;">*</a></td></tr>
   <tr><td>身份证:</td><td><input name="sfz"  id="sfz" type="text" /><a style="color:red;">*</a></td></tr>
  <tr><td>上级openid:</td><td><input name="p_openid"  id="p_openid" type="text" /><a style="color:red;">*</a></td></tr>
  <tr><td>上级昵称:</td><td><input name="p_name"  id="p_name" type="text" /><a style="color:red;">*</a></td></tr>
  <tr><td>联系电话:</td><td><input name="tel"  id="tel" type="text" /><a style="color:red;">*</a></td></tr>
  <tr><td>车辆识别代码:</td><td><input name="sbdm"  id="sbdm" type="text" /><a style="color:red;">*</a></td></tr>
  <tr><td>车牌号:</td><td><input name="car_no"  id="car_no" type="text" /><a style="color:red;">*</a></td></tr>
  <tr><td>保险到期时间:</td><td><input  class="endtime" value="" name="endtime" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this);"  /><a style="color:red;">*</a></td></tr>
  <tr><td>车船险:</td><td><input name="ccx"  id="ccx" type="text" /><a style="color:red;">*</a></td></tr>
  <tr><td>强制险:</td><td><input name="qzx"  id="qzx" type="text" /><a style="color:red;">*</a></td></tr>
  <tr><td>商业险:</td><td><input name="syx"  id="syx" type="text" /><a style="color:red;">*</a></td></tr>
  <tr><td>实缴商业险:</td><td><input name="sjsyx"  id="sjsyx" type="text" /><a style="color:red;">*</a></td></tr>
  <tr><td>内容:</td><td><textarea name="bz" id="bz" style="width:300px;height:150px;"></textarea></td></tr>
   
  <tr><td>排序:</td><td><input name="sort_no"  id="sort_no" type="text"  value="0"/></td></tr>
 
 
  
</table>
    
    <div align="center" style="padding: 10px;"><input  type="submit"  id="btn_queren2" value="确认" />&nbsp;<input  type="button" onclick="location='wx_order_list.php'" value="返回" /></div>
	</div>
    
      </div>
    
	</form>


	
</div><!--tabbox end-->





{/if}



{if $fall==fs}
<div class="demo">	
	



	
    	
    <table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>代码已存在</b></td></tr>
 <tr><td>代码已存在<a href="wx_order_list.php">返回</a></td></tr>
</table>



	
</div><!--tabbox end-->
{/if}

</body>  
</html>
{literal}
<script type="text/javascript">
        
        $("#order_sn").focus();
       $("#btn_queren2").click(function(){
           if(jQuery.trim($("#order_sn").attr('value'))=='')
        {
            
            $("#order_sn").focus();
            
            return false;
        }
        else if(jQuery.trim($("#order_name").attr('value'))=='')
        {
            $("#order_name").focus();
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
             
              htmlobj=$.ajax({url:"wx_order_list.php?act=delete&img_code="+encodeURI(encodeURI($(this).attr("title"))),async:false});
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
             
              htmlobj=$.ajax({url:"wx_order_list.php?act=img_xs&img_code="+encodeURI(encodeURI($(this).attr("title")))+"&alt="+$(this).attr("alt"),async:false});
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
             
              htmlobj=$.ajax({url:"wx_order_list.php?act=img_xs&img_code="+encodeURI(encodeURI($(this).attr("title")))+"&alt="+$(this).attr("alt"),async:false});
              alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        $("#type").val({$order_mx.type});
      
       
        
</script>
{/literal}