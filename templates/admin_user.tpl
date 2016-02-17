<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<style type="text/css">
<!--
	.table tr td p{margin:0px 0 0 0;padding:0;text-indent:0em;line-height:150%;}
-->
</style>
</head>

<body>

<div class="container">
  <div class="content">
  
 
 
   <div class="botable">
{if $fall==1}


   
    <table class="table" width="100%" border="0" style="margin-bottom: 7px;">

 <form>
 <tr>
 <th style="text-align: left;border-right-style:none"><input id="a_text" value="添加用户" type="button" onclick="location='admin_user.php?act=add_admin_user_list'" />&nbsp;<input id="down_hy" value="头像下载" type="hidden" /></th>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>


 </form>
</table>

    


   <table class="table" width="100%" border="0">
   
   <tr>
   <th >用户代码</th>
   <th>登录名</th>
   <th>名称</th>
   <!--<th>URL</th>-->
    <th>所属角色</th>
 

   <th>操作</th>
   
   
   
   </tr>
<tbody  id="table_t">
  {foreach from=$admin_user_list item=admin_user}
    <tr>
    
        	<td  >{$admin_user.user_code}</td>
            <td >{$admin_user.user_name}</td>
            <td >{$admin_user.user_name2}</td>
        <td >
        {foreach from=$admin_user.u_list item=u_list}
        <p>{$u_list.p_id}({$u_list.role_name})</p>
        
        {/foreach}
        </td>
        
    
    
    
    
        <td  align="center"   style="width:120px">
        {if $admin_user.tzsy==1}<img id="tzsy_qy" alt="0" title="{$admin_user.user_code}"  src="images/no.gif"/>{else}<img id="tzsy_jy"  title="{$admin_user.user_code}" alt="1" src="images/yes.gif"/>{/if}
        &nbsp;
        {if $admin_user.tzsy==1}<img  title="修改角色" name="{$admin_user.user_code}" id="edit"  src="images/icon_edit.gif" />&nbsp;&nbsp;&nbsp;<img  title="重置密码" name="{$admin_user.user_code}" id="reset"  src="images/pass_reset.gif" />&nbsp;&nbsp;&nbsp;<img id="delete_admin_user"  alt="{$admin_user.user_code}" name="{$admin_user.user_code}" title="删除" src="images/icon_drop.gif"/>&nbsp;&nbsp;&nbsp;{else if } <img  title="修改角色" name="{$admin_user.user_code}" id="edit"  src="images/icon_edit.gif" />&nbsp;&nbsp;&nbsp;<img  title="重置密码" name="{$admin_user.user_code}" id="reset"  src="images/pass_reset.gif" />&nbsp;&nbsp;&nbsp;{/if}</td>        
    
    </tr>
{foreachelse}
<tr><td class="no-records" colspan="4">无记录</td></tr>
{/foreach}
</tbody>
</table>


<table class="table" width="100%" border="0">
<tr><td style="text-align: right;">{include file="foot.tpl"}</td></tr> 
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
        
    
     $("img[id='edit']").each(function (){
            
            $(this).click(function (){
               location.href = "admin_user.php?act=edit&user_code="+encodeURI(encodeURI($(this).attr("name")));
            })
        })
           $("img[id='delete_admin_user']").each(function (){
            
            $(this).click(function (){
        
            
              if(confirm("删除"+$(this).attr("name")+"用户？")){
               htmlobj=$.ajax({url:"admin_user.php?act=delete_admin_user&user_code="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
            })
        })
        
    
        
        $("img[id='tzsy_jy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("title")+"用户?")){
             
              htmlobj=$.ajax({url:"admin_user.php?act=admin_user_xs&admin_user_code="+encodeURI(encodeURI($(this).attr("title")))+"&alt="+$(this).attr("alt"),async:false});
             // alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          
           
        })
        })
        $("img[id='tzsy_qy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("启用"+$(this).attr("title")+"用户?")){
             
              htmlobj=$.ajax({url:"admin_user.php?act=admin_user_xs&admin_user_code="+encodeURI(encodeURI($(this).attr("title")))+"&alt="+$(this).attr("alt"),async:false});
             // alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        $("img[id='reset']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("重置密码?")){
             
              htmlobj=$.ajax({url:"admin_user.php?act=reset&user_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt="+$(this).attr("alt"),async:false});
             //alert(htmlobj.responseText);return false;
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        
})
-->
</script>
