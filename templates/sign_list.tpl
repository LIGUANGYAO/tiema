<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员中心</title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/tablecloth.js"></script>
</head>

<body>

<div class="container">
  <div class="content">
  <div class="botable">
 <table class="table" width="100%" border="0" style="margin-bottom: 7px;">

 <form>
 <tr>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>


 </form>
</table>


   <table class="table" width="100%" border="0">
   
   <tr>
   <th >openid</th>
   <th >姓名</th>
   <th>电话</th>
<!--   <th>车型</th> -->
    <th>报名时间</th>
    <th>操作</th>
   </tr>
<tbody  id="table_t">
   {foreach from=$sign_list item=sign_list}
  <tr>
  <td >{$sign_list.openid}</td>
  <td >{$sign_list.mu_name}</td>
  <td>{$sign_list.mu_tel}</td>
<!--  <td >{$sign_list.mu_car}</td>-->
  <td >{$sign_list.add_time}</td>
   <td > {if $sign_list.tzsy==1}<img  title="启用" name="{$sign_list.id}" id="tzsy_qy"  src="images/no.gif" />{/if}
  {if $sign_list.tzsy==0}<img  title="禁用" name="{$sign_list.id}" id="tzsy_jy"  src="images/yes.gif" />{/if}&nbsp;
  
  <img id="delete" name="{$sign_list.id}" title="删除" src="images/icon_drop.gif"/>
  </td>

  
  </tr>
  {foreachelse}
  <tr>
  <td  colspan="20">无记录</td>
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
<script type="text/javascript">
<!--

    $(document).ready(function ()
{
   $("img[id='tzsy_jy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("name")+"")){
             
              htmlobj=$.ajax({url:"sign_list.php?act=sign_list_xs&id="+encodeURI(encodeURI($(this).attr("name")))+"&alt=1",async:false});
             // alert("禁用"+$(this).attr("name")+"");
             window.location.reload();
            }else return false;
          
        })
        })
        $("img[id='tzsy_qy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("启用"+$(this).attr("name")+"")){
             
               htmlobj=$.ajax({url:"sign_list.php?act=sign_list_xs&id="+encodeURI(encodeURI($(this).attr("name")))+"&alt=0",async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
       })
        })
        
		  $("img[id='delete']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("删除"+$(this).attr("name"))){
             
              htmlobj=$.ajax({url:"sign_list.php?delete="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
		
		

})
-->
</script>
</body>
</html>

