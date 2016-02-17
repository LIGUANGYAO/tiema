<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
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
 <th style="text-align: left;border-right-style:none">&nbsp;<input  id="zdxs" type="button" value="字段显示"/>&nbsp;<input  id="zdpx" type="button" value="字段排序"/></th>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<img id="lishi" title="用户关键字"  src="images/histroy.png"/>&nbsp;<input  type="text"  id="order_info" name="order_info"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>


 </form>
</table>

    


   <table class="table" width="100%" border="0">
   
   <tr>
   <th >公众号id</th>
   <th>公众号secret</th>
   <th>验证URL</th>
  
   <th>token</th>

   <th>操作</th>
   </tr>
<tbody  id="table_t">
   {foreach from=$appid_list item=appid_list}
  <tr>
  <td style="width:70px">{$appid_list.app_id}</td>
  <td style="width:140px">{$appid_list.app_secret}</td>
  <td  title="{$url_this}">{$url_this}</td>

  <td style="width:150px">{$token}</td>

  
  <td style="width:70px"> 
  {if $appid_list.tzsy==1}
  <!-- <img  title="启用" name="{$appid_list.appid_sn}" id="tzsy_qy"  src="images/no.gif" />&nbsp;-->
  <img  title="修改" name="{$appid_list.appid_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <!--<img id="delete_appid" name="{$appid_list.appid_sn}" title="删除" src="images/icon_drop.gif"/>-->
  {else if }
  <!--<img  title="禁用" name="{$appid_list.appid_sn}" id="tzsy_jy"  src="images/yes.gif" />&nbsp;-->
  <img  title="修改" name="{$appid_list.appid_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <!--<img id="delete_appid" name="{$appid_list.appid_sn}" title="删除" src="images/icon_drop.gif"/>-->
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




</div>
   <!-- end .content --></div>
<!-- end .container --></div>
</body>
</html>
<script type="text/javascript">
<!--
$(document).ready(function ()
{       
     $("#text_sn").focus();
       $("#queding").click(function(){
           if(jQuery.trim($("#text_sn").attr('value'))=='' )
        {
            
            $("#text_sn").focus();
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
       
       
        
        
        $("img[id='edit']").each(function (){
            
           $(this).click(function (){
        
           window.location='appid.php?act=edit&appid_sn='+encodeURI(encodeURI($(this).attr("name")));
           
           
        })
        })
        
        
         $("img[id='delete_appid']").each(function (){
            
            $(this).click(function (){
        
            
              if(confirm("删除"+$(this).attr("name")+"")){
               htmlobj=$.ajax({url:"appid.php?act=delete_appid&appid_sn="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
            })
        })
        
      
        
        
        $("img[id='tzsy_jy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("name")+"")){
             
              htmlobj=$.ajax({url:"appid.php?act=appid_xs&appid_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt=1",async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        $("img[id='tzsy_qy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("启用"+$(this).attr("name")+"")){
             
              htmlobj=$.ajax({url:"appid.php?act=appid_xs&appid_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt=0",async:false});
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
