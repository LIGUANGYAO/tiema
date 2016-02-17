<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>导购管理</title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
</head>

<body>

<div class="container">
  <div class="content">
  <div class="botable">
{if $fall==sales}
<table class="table" width="100%" border="0" style="margin-bottom: 7px;">
<form>
 <tr>
 <th style="text-align: left;border-right-style:none"><input id="a_text" value="添加导购" type="button" onclick="location='sales.php?act=a_sales'" />
 &nbsp;注：场景值ID为1的是永久场景微信公众号二维码（和微信后台生成的二维码是一致的）</th>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>


 </form>
</table>


   <table class="table" width="100%" border="0">
   
   <tr>
   <th>导购代码</th>
   <th>导购名称</th>
   <th>导购类型</th>
   <th>所属商店</th>
   <th>场景值ID（1到100000）</th>
   <th>二维码</th>
   <th>推广信息</th>
   <th>添加时间</th>
   <th>操作</th>
   </tr>
<tbody  id="table_t">
   {foreach from=$sales_list item=sales_list}
  <tr>
  <td>{$sales_list.sales_sn}</td>
  <td>{$sales_list.sales_name}</td>
  <td>{if $sales_list.sales_type==0}导购员{/if}{if $sales_list.sales_type==1}收银员{/if}</td>
  <td>{$sales_list.p_id}</td>
  <td>{$sales_list.qrcid}</td>
  <td> <a href="sales.php?act=view_qrcode&ticket={$sales_list.ticket}">查看</a></td>
   <td>{foreach from=$sales_list.point item=point_l} 
  <p>{$point_l.users_sn}({$point_l.nick_name})/<a style="color:red">{$point_l.point}%</a></p>{foreachelse}无{/foreach}
  </td>
  <td>{$sales_list.add_time}</td>
  
  <td > 
  {if $sales_list.tzsy==1}
   <img  title="启用" name="{$sales_list.sales_sn}" id="qiyong"  src="images/no.gif" />&nbsp;
  <img  title="修改" name="{$sales_list.sales_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <img id="delete" name="{$sales_list.sales_sn}" title="删除" src="images/icon_drop.gif"/>
  {else if }
  <img  title="禁用" name="{$sales_list.sales_sn}" id="jinyong"  src="images/yes.gif" />&nbsp;
  <img  title="修改" name="{$sales_list.sales_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <img id="delete" name="{$sales_list.sales_sn}" title="删除" src="images/icon_drop.gif"/>
  {/if}
  </td>
  
  </tr>
  {foreachelse}
  <tr>
  <td style="width:70px" colspan="20">无记录</td>
  </tr>
   {/foreach}
  
</tbody>
</table>


<table class="table" width="100%" border="0">
<tr><td style="text-align: right;">{include file="foot.tpl"}</td></tr> 
</table>


{/if}


{if $fall==e_sales}
<form action="sales.php?act=post" method="POST">
<table class="table" width="100%" border="0">
    <tr><td colspan="2"><b>编辑</b></td></tr>
	
  <tr>
    <td>导购代码:</td>
    <td><input   type="text" value="{$sales.sales_sn}" disabled="disabled"/><a style="color:red;">*</a></td></tr>
  <input name="sales_sn" id="sales_sn"  type="hidden" value="{$sales.sales_sn}"/>
  <tr>
    <td>导购名称:</td>
    <td><input name="sales_name"  id="sales_name" type="text" value="{$sales.sales_name}" /><a style="color:red;">*</a></td></tr>
  <tr><td>导购类型:</td><td>
  
  {if $sales.sales_type==0}<input type="radio" name="sales_type" value="0" checked />导购员{else}<input type="radio" name="sales_type" value="0"/>导购员{/if}
  {if $sales.sales_type==1}<input type="radio" name="sales_type" value="1" checked />收银员{else}<input type="radio" name="sales_type" value="1"/>收银员{/if}
  
 
  </td> 
  </tr>
  
  
  
 <tr>
    <td>场景值ID:</td>
    <td><input   type="text"  value="{$sales.qrcid}" disabled="disabled">
    <input name="qrcid" id="qrcid"  type="hidden" value="{$sales.qrcid}" />
    </td>
  </tr>
  
    <tr>
      <td>上级渠道:</td>
      <td>
     <label>上级渠道：</label>
	 <select  name="b_id" id="b_id"> 
        <option value="">请选择</option>
        {foreach from=$qudao_list item=qudao_list}
        <option value="{$qudao_list.qudao_sn}">{$qudao_list.qudao_name}</option>
		{/foreach}
	 </select>
     <label>所属商店：</label> <select name="p_id" id="p_id">
     <option value="">请选择</option>
	  <option value="{$sales.p_id}">{$s_list.shop_name}</option>
	 </select> 
   
 
  </td> 
  </tr>
  
  <!-- 设置推广关注者-->
     <tr><td colspan="2" style="background-color:    #E8E8E8;"><b>绑定关注信息</b></td></tr>
  <tr>
   <tr>
    <td>关注者信息:</td>
    <td>
    <input  id="openid" type="hidden"/>
    
    <input name="qdbtn1" type="button" id="qdbtn1" onclick=" window.open('sales.php?act=select_openid', 'newwindow', 'height=600, width=800, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no')" value="选择" class="button"/>
    </td>
    
    </tr>
    
    <tr>
    <td>关注者推广比例:</td>
    <td>
    <table class="table" width="100%" >
        <tr><th colspan="3">信息</th></tr>
      
    </table>
     <table class="table" width="100%"  id="tgxx">
     {foreach from=$sales.point item=point}
        <tr><td>{$point.users_sn}({$point.nick_name})</td><td style='width: 30%;'><input name='open[]' id='open' value='{$point.users_sn}({$point.nick_name})' type='hidden' /><input name='oppoint[]' id='oppoint' value='{$point.point}' style='width: 130px; text-align: center;'/>%</td></tr>
     {/foreach}
      
    </table>
    </td></tr>
    <!-- end设置推广关注者-->
    
  
 
 
  <tr><td colspan="2"  style="text-align: center;"><input  id="queding" type="submit" value="确定"/>&nbsp;<input  type="button" value="取消" id="quxiao" onclick="location='sales.php'"/></td></tr>
</table>
</form>
<!--二级联动菜单-->
<script type="text/javascript">
<!--
$(function(){      
$("#b_id").change(function(){         
getSelectVal();    
}); 
}); 

function getSelectVal(){
		var list='list';
		     $.getJSON("sales.php",{b_id:$("#b_id").val(),act:list},function(json){
			          var p_id = $("#p_id");
					  $("option",p_id).remove(); //清空原有的选项
                      
                      
                       var option="<option  value =''>请选择</option>";
                       p_id.append(option); 
					    $.each(json,function(index,array){
						             var option = "<option value='"+array['shop_sn']+"'>"+array['shop_name']+"</option>";
									 p_id.append(option);         
			});
		 });
} 
</script>
<!--二级联动菜单-->
{/if}



{if $fall==a_sales}
<form action="sales.php?act=i_sales" method="POST">
<table class="table" width="100%" border="0">
    <tr>
      <td colspan="2"><strong>新增导购</strong></td>
    </tr>
  <tr>
    <td>导购代码:</td>
    <td><input name="sales_sn" id="sales_sn"  type="text" /><a style="color:red;">*</a></td></tr>
  <tr>
    <td>导购名称:</td>
    <td><input name="sales_name"  id="sales_name" type="text" /><a style="color:red;">*</a></td></tr>
  <tr><td>导购类型:</td><td>
  
   <input type="radio" name="sales_type" value="0" checked />导购员
   <input type="radio" name="sales_type" value="1" />收银员
 
  </td> 
  </tr>
  
  
    <tr>
    <td>场景值ID:</td>
    <td><input name="qrcid" id="qrcid"  type="text" maxlength="5" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" value="{$bh.bh}">
    <span style="width:150px;" id="abc"></span>  <a style="color:red;"> <span style="width:150px;" id="abc"></span> *点击空白处验证场景ID（40000到89999）</a></td>
  </tr>
  
  
      <tr>
      <td>上级渠道:</td>
      <td>
     <label>上级渠道：</label>
	  <select  name="b_id" id="b_id"> 
        <option value="">请选择</option>
        {foreach from=$qudao_list item=qudao_list}
        <option value="{$qudao_list.qudao_sn}">{$qudao_list.qudao_name}</option>
		{/foreach}
	 </select>
     <label>所属商店：</label> <select name="p_id" id="p_id">
     <option value="">请选择</option>
	  <option value="{$sales.p_id}">{$s_list.shop_name}</option>
	 </select> 
   
 
  </td> 
  </tr>
  
  
  <!-- 设置推广关注者-->
     <tr><td colspan="2" style="background-color:    #E8E8E8;"><b>绑定关注信息</b></td></tr>
  <tr>
   <tr>
    <td>关注者信息:</td>
    <td>
    <input  id="openid" type="hidden"/>
    
    <input name="qdbtn1" type="button" id="qdbtn1" onclick=" window.open('sales.php?act=select_openid', 'newwindow', 'height=600, width=800, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no')" value="选择" class="button"/>
    </td>
    
    </tr>
    
    <tr>
    <td>关注者推广比例:</td>
    <td>
    <table class="table" width="100%" >
        <tr><th colspan="3">信息</th></tr>
      
    </table>
     <table class="table" width="100%"  id="tgxx">
     {foreach from=$sales.point item=point}
        <tr><td>{$point.users_sn}({$point.nick_name})</td><td style='width: 30%;'><input name='open[]' id='open' value='{$point.users_sn}({$point.nick_name})' type='hidden' /><input name='oppoint[]' id='oppoint' value='{$point.point}' style='width: 130px; text-align: center;'/>%</td></tr>
     {/foreach}
      
    </table>
    </td></tr>
    <!-- end设置推广关注者-->
  
 <tr>
  <tr><td colspan="2"  style="text-align: center;"><input  id="queding" type="submit" value="确定"/>&nbsp;<input  type="button" value="取消" id="quxiao" onclick="location='sales.php'"/></td></tr>
</table>
</form>

<!--二级联动菜单-->
<script type="text/javascript">
<!--

<!--判断场景ID是否存在-->
  $("#queding").attr("disabled","true");
	 		$("#qrcid").blur(function () { 
			    var qrcid = jQuery.trim($("#qrcid").attr('value'));
				 var html="";
				//alert(qrcid);
				$.post('sales.php?act=checksales&qrcid='+qrcid,
				function(data) {
					if (data.success == true) {
					//0可用  1不可用
					if(data.check=='1'){
					$("#queding").attr("disabled","true");
					$('#abc').html(data.msg); 
					     //setTimeout('window.location.href=location.href',1000);
					}
					
					if(data.check=='0'){
					$("#queding").removeAttr("disabled");
					$('#abc').html(data.msg); 
					  
                        //setTimeout('window.location.href=location.href',1000);
					}
					
					return; 
					} else {
					
					}
				},
				"json")
			});  
<!--判断场景ID是否存在-->





$(function(){   
getSelectVal();     
$("#b_id").change(function(){         
getSelectVal();    
}); 
}); 

function getSelectVal(){
		var list='list';
		     $.getJSON("sales.php",{b_id:$("#b_id").val(),act:list},function(json){
			          var p_id = $("#p_id");
					  $("option",p_id).remove(); //清空原有的选项
                      
                       var option="<option  value =''>请选择</option>";
                       p_id.append(option); 
					    $.each(json,function(index,array){
						var option = "<option value='"+array['shop_sn']+"'>"+array['shop_name']+"</option>";									                                     p_id.append(option);
									
									          
			});
		 });
} 
</script>
<!--二级联动菜单-->


{/if}

{if $fall==i_staus}
<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>添加导购</b></td></tr>
 <tr><td>{$val}<a href="sales.php">返回</a></td></tr>
</table>

<script type="text/javascript">
<!--
	$(document).ready(function ()
{       
    var timer = setTimeout(function(){
      window.location="sales.php";
    }, 500);
   
})
-->
</script>
{/if}

{if $fall==view}
<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>导购二维码</b></td></tr>
 <tr><td><img src="upload/cj_qrcode/sales/{$val}"><a href="sales.php">返回</a></td></tr>
</table>
{/if}

</div>
   <!-- end .content --></div>
<!-- end .container --></div>
</body>
</html>
<script type="text/javascript">

//接受子页面信息
     function setValue(returnValue) {
        var type = returnValue.substring(0,1);
        returnValue = returnValue.substring(0,returnValue.length);
	    document.getElementById('openid').value=  returnValue;
        $("#tgxx").empty();
        
        arr=returnValue.split(',');//注split可以用字符或字符串分割
        for(var i=0;i<arr.length-1;i++)
        {
                //alert(arr[i]);
                 $("#tgxx").append("<tr><td>"+arr[i]+"</td><td style='width: 30%;'><input name='open[]' id='open' value='"+arr[i]+"' type='hidden' /><input name='oppoint[]' id='oppoint' value='0' style='width: 130px; text-align: center;'/>%</td></tr>" );
        }
        //$("#tgxx").append("<option id='select1_1' name="+ o.mc+" value="+o.dm+" >"+ o.dm +"(" + o.mc +")</option>" );});
       
        
        
        //alert(returnValue);
        
	
	}  

<!--
$(document).ready(function ()
{       
     $("#sales_sn").focus();
       $("#queding").click(function(){
           if(jQuery.trim($("#sales_sn").attr('value'))=='' )
        {
            
            $("#sales_sn").focus();
            return false;
        }
         else if(jQuery.trim($("#sales_name").attr('value'))=='' )
         {
             
            $("#sales_name").focus();
            return false;
         }
		 else if(jQuery.trim($("#qrcid").attr('value'))=='' )
         {
             
            $("#qrcid").focus();
            return false;
        }
		 else if(jQuery.trim($("#p_id").attr('value'))=='' )
         {
             
            $("#p_id").focus();
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
       
        $("img[id='qiyong']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("启用"+$(this).attr("name"))){
             
              htmlobj=$.ajax({url:"sales.php?act=ed_status&qiyong="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        
        
         $("img[id='jinyong']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("name"))){
             
              htmlobj=$.ajax({url:"sales.php?act=ed_status&jinyong="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
          $("img[id='delete']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("删除"+$(this).attr("name"))){
             
              htmlobj=$.ajax({url:"sales.php?act=ed_status&delete="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        
        
        $("img[id='edit']").each(function (){
            
           $(this).click(function (){
        
           window.location='sales.php?act=e_sales&edit='+encodeURI(encodeURI($(this).attr("name")));
           
           
        })
        })
        
        
        $("#b_id").val("{$sales.b_id}");
        $("#p_id").val("{$sales.p_id}");
    
})
-->
</script>
