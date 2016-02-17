<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员中心</title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>

</head>
<style type="text/css">
<!--
    .alert{filter:alpha(opacity=20); /* IE */ -moz-opacity:0.2; /* Moz + FF */ opacity: 0.2; height:200%; width:100%; background:; left:0%; top:0%;margin-top:-0px;margin-left:-0px;position:absolute;z-index:99; text-align:center; padding:0px;}
	#leavemsg{left:20%; top:20%;margin-top:-0px;margin-left:-0px;position:absolute;z-index:99; text-align:center; padding:0px;
	width:500px;
	height:300px;
	border:0px solid #008800;}
-->
</style>
<body>

<div class="container">
  <div class="content">
  <div class="botable">

<table class="table" width="100%" border="0" style="margin-bottom: 7px;">

 <form>
 <tr>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;<input  value="导出excel" type="button" id="excel" /></th>
 
 </tr>


 </form>
</table>

   <table class="table" width="100%" border="0">
   <tr>
   <th>openid</th>
   <th>昵称</th>
   <th>关注扫描</th>
   <th>场景代码</th>
   <th>场景名称</th>
   <th>场景类型</th>
   <th>场景ID</th>
   <th>最近关注时间</th>
   <!--<th>操作</th>-->
   </tr>
<tbody  id="table_t">
   {foreach from=$cj_qrcode_list item=cj_qrcode_list}
  <tr><td>{$cj_qrcode_list.openid}</td><td>{$cj_qrcode_list.nick_name}({$cj_qrcode_list.users_sn})</td>
  <td>{$cj_qrcode_list.issubs}</td>
  <td>{$cj_qrcode_list.cj_sn}</td>
  <td>{$cj_qrcode_list.cj_name}</td>
  <td>{$cj_qrcode_list.cj_type}</td>
  <td>{$cj_qrcode_list.qrcid}</td>
  <td>{$cj_qrcode_list.add_time}</td>
  <!--<td>{if $cj_qrcode_list.tzsy==1}
   <img  title="启用" name="{$cj_qrcode_list.id}" id="qiyong"  src="images/no.gif" />&nbsp;
  <img id="delete" name="{$cj_qrcode_list.id}" title="删除" src="images/icon_drop.gif"/>
  {else if }
  <img  title="禁用" name="{$cj_qrcode_list.id}" id="jinyong"  src="images/yes.gif" />&nbsp;
  <img id="delete" name="{$cj_qrcode_list.id}" title="删除" src="images/icon_drop.gif"/>
  {/if}</td>-->
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
</div>
   <!-- end .content --></div>
<!-- end .container --></div>
</body>
</html>
<script type="text/javascript">
<!--
$(document).ready(function ()
{       

       
        $("img[id='qiyong']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("启用"+$(this).attr("name"))){
             
              htmlobj=$.ajax({url:"cj_qrcode_list.php?act=ed_status&qiyong="+encodeURI(encodeURI($(this).attr("name"))),async:false});
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
             
              htmlobj=$.ajax({url:"cj_qrcode_list.php?act=ed_status&jinyong="+encodeURI(encodeURI($(this).attr("name"))),async:false});
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
             
              htmlobj=$.ajax({url:"cj_qrcode_list.php?act=ed_status&delete="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
    
    
    
     $("#excel").click(function (){
               htmlobj=$.ajax({url:"excel.php?m=cj_count",async:false});
               var sl=htmlobj.responseText;
                for(var i=0;i<sl;i++)
                {
                      window.open('excel.php?m=cj_qrcode_stat&sl='+i); 
                }
               
        })
  
})
-->
</script>