<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员中心</title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/tablecloth.js"></script></head>

<body>

<div class="container">
  <div class="content">
  <div class="botable">
{if $fall==cj_qrcode}
<table class="table" width="100%" border="0" style="margin-bottom: 7px;">
<form>
 <tr>
 <th style="text-align: left;border-right-style:none"><input id="a_text" value="添加场景" type="button" onclick="location='cj_qrcode.php?act=a_cj_qrcode'" />
 &nbsp;注：第一次请先添加一条场景值ID为1的永久场景微信公众号二维码（和微信后台生成的二维码是一致的）</th>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>


 </form>
</table>


   <table class="table" width="100%" border="0">
   
   <tr>
   <th >场景代码</th>
   <th>场景名称</th>
   <th>二维码类型</th>
   <th>过期时间（秒）</th>
   <th>场景值ID（1到100000）</th>
   <th>二维码</th>
   <th>生成时间</th>
   <th>操作</th>
   </tr>
<tbody  id="table_t">
   {foreach from=$cj_qrcode_list item=cj_qrcode_list}
  <tr>
  <td>{$cj_qrcode_list.cj_sn}</td>
  <td>{$cj_qrcode_list.cj_name}</td>
  <td>{if $cj_qrcode_list.type==0}永久{/if}{if $cj_qrcode_list.type==1}临时{/if}</td>
  <td>{$cj_qrcode_list.expire}</td>
  <td>{$cj_qrcode_list.qrcid}</td>
  <td><a href="cj_qrcode.php?act=view_qrcode&ticket={$cj_qrcode_list.ticket}">查看</a></td>
  <td>{$cj_qrcode_list.add_time}</td>
  
  <td > 
  {if $cj_qrcode_list.tzsy==1}
   <img  title="启用" name="{$cj_qrcode_list.cj_sn}" id="qiyong"  src="images/no.gif" />&nbsp;
<!--  <img  title="修改" name="{$cj_qrcode_list.cj_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;-->
  <img id="delete" name="{$cj_qrcode_list.cj_sn}" title="删除" src="images/icon_drop.gif"/>
  {else if }
  <img  title="禁用" name="{$cj_qrcode_list.cj_sn}" id="jinyong"  src="images/yes.gif" />&nbsp;
 <!-- <img  title="修改" name="{$cj_qrcode_list.cj_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;-->
  <img id="delete" name="{$cj_qrcode_list.cj_sn}" title="删除" src="images/icon_drop.gif"/>
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


{if $fall==e_cj_qrcode}
<form action="cj_qrcode.php?act=post" method="POST">
<table class="table" width="100%" border="0">
    <tr><td colspan="2"><b>编辑文本模板</b></td></tr>
	
  <tr>
    <td>场景代码:</td>
    <td><input name="cj_sn" id="cj_sn"  type="text" value="{$cj_qrcode.cj_sn}" /><a style="color:red;">*</a></td></tr>
  <tr>
    <td>场景名称:</td>
    <td><input name="cj_name"  id="cj_name" type="text" value="{$cj_qrcode.cj_name}" /><a style="color:red;">*</a></td></tr>
  <tr><td>生成类型:</td><td>
  
  {if $cj_qrcode.type==0}<input type="radio" name="type" value="0" checked />永久{else}<input type="radio" name="type" value="0"/>永久{/if}
  {if $cj_qrcode.type==1}<input type="radio" name="type" value="1" checked />临时{else}<input type="radio" name="type" value="1"/>临时{/if}
 
  </td> 
  </tr>
  <tr>
    <td>场景值ID:</td>
    <td><input name="qrcid" id="qrcid"  type="text"  value="{$cj_qrcode.qrcid}"/><a style="color:red;">*（1到1000000）</a></td></tr>
  <tr>
  <tr><td>排序:</td><td><input name="sort_no"  id="sort_no" type="text"   value="{$cj_qrcode.sort_no}"/></td></tr>
  
  <tr><td colspan="2"  style="text-align: center;"><input  id="queding" type="submit" value="确定"/>&nbsp;<input  type="button" value="取消" id="quxiao" onclick="location='cj_qrcode.php'"/></td></tr>
</table>
</form>
{/if}



{if $fall==a_cj_qrcode}
<form action="cj_qrcode.php?act=i_cj_qrcode" method="POST">
<table class="table" width="100%" border="0">
    <tr>
      <td colspan="2"><strong>生成二维码</strong></td>
    </tr>
  <tr>
    <td>场景代码:</td>
    <td><input name="cj_sn" id="cj_sn"  type="text" /><a style="color:red;">*</a></td></tr>
  <tr>
    <td>场景名称:</td>
    <td><input name="cj_name"  id="cj_name" type="text" /><a style="color:red;">*</a></td></tr>
  <tr><td>生成类型:</td><td>
  
   <input type="radio" name="type" value="0" checked />永久
  <input type="radio" name="type" value="1" />临时
 
  </td> 
  </tr>
  <tr>
    <td>场景值ID:</td>
    <td><input name="qrcid" id="qrcid"  type="text" maxlength="5" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" value="{$bh.bh}">
    <span style="width:150px;" id="abc"></span><a style="color:red;">*（90000到99999）</a></td></tr>
  <tr>
  <tr><td>排序:</td><td><input name="sort_no"  id="sort_no" type="text" /></td></tr>
  <tr><td colspan="2"  style="text-align: center;"><input  id="queding" type="submit" value="确定"/>&nbsp;<input  type="button" value="取消" id="quxiao" onclick="location='cj_qrcode.php'"/></td></tr>
</table>
</form>
<script type="text/javascript">
  $("#queding").attr("disabled","true");
	 		$("#qrcid").blur(function () { 
			    var qrcid = jQuery.trim($("#qrcid").attr('value'));
				 var html="";
				//alert(qrcid);
				$.post('cj_qrcode.php?act=checkagent&qrcid='+qrcid,
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

</script>
{/if}

{if $fall==i_staus}
<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>添加场景</b></td></tr>
 <tr><td>{$val}<a href="cj_qrcode.php">返回</a></td></tr>
</table>
{/if}

{if $fall==view}
<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>添加场景</b></td></tr>
 <tr><td><img src="upload/cj_qrcode/agent/{$val}"><a href="cj_qrcode.php">返回</a></td></tr>
</table>
{/if}

</div>
<!-- end .content --></div>
<!-- end .container --></div>
</body>
</html>
<script type="text/javascript">
<!--
$(document).ready(function ()
{       
     $("#cj_sn").focus();
       $("#queding").click(function(){
           if(jQuery.trim($("#cj_sn").attr('value'))=='' )
        {
            
            $("#cj_sn").focus();
            return false;
        }
         else if(jQuery.trim($("#cj_name").attr('value'))=='' )
         {
             
            $("#cj_name").focus();
            return false;
         }
		 else if(jQuery.trim($("#qrcid").attr('value'))=='' )
         {
             
            $("#qrcid").focus();
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
             
              htmlobj=$.ajax({url:"cj_qrcode.php?act=ed_status&qiyong="+encodeURI(encodeURI($(this).attr("name"))),async:false});
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
             
              htmlobj=$.ajax({url:"cj_qrcode.php?act=ed_status&jinyong="+encodeURI(encodeURI($(this).attr("name"))),async:false});
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
             
              htmlobj=$.ajax({url:"cj_qrcode.php?act=ed_status&delete="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        
        
        $("img[id='edit']").each(function (){
            
           $(this).click(function (){
        
           window.location='cj_qrcode.php?act=e_cj_qrcode&edit='+encodeURI(encodeURI($(this).attr("name")));
           
           
        })
        })
        
        
        
    
})
-->
</script>
