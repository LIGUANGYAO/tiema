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
{if $fall==1}

   
 <table class="table" width="100%" border="0" style="margin-bottom: 7px;">


 <form>
 <tr>
 <th style="text-align: left;border-right-style:none"><input class="button" id="a_text" value="添加模板" type="button"  onclick="location='custom.php?act=add_custom_list'" />&nbsp;<input id="down_hy" value="头像下载" type="hidden" /></th>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>


 </form>

</table>

   <table class="table" width="100%" border="0">
   
   <tr>
   <th >代码</th>
   
   <th>上级代码</th>
   <th>关键字</th>
   
   <!--<th>模糊类型</th>-->
   <th>回复类型</th>
   <th>模板</th>
   <th>更新时间</th>
 
   <th>图文数量</th>
   <th>操作</th>
   </tr>
<tbody  id="table_t">
   {foreach from=$custom_list item=custom_list}

  <tr>
  {if $custom_list.p_id==''}<td style="width:70px">{$custom_list.custom_sn}</td>
  {else}
  <td style="width:70px">﹂{$custom_list.custom_sn}</td>{/if}
  
   <td style="width:70px">{$custom_list.p_id}</td>
  <td style="width:140px">{$custom_list.custom_name}</td>
  <!--<td  title="{$custom_list.custom_note_1}">等于</td>-->
  <td style="width:70px">{$custom_list.re_type_name}</td>
  <td style="width:150px">{$custom_list.re_code}___{$custom_list.re_code_name.name}</td>
  <td style="width:150px">{$custom_list.last_update}</td>
  <td style="width:70px">{$custom_list.bdsl}</td>
  
  <td style="width:70px"> 
  {if $custom_list.tzsy==1}
   <img  title="启用" name="{$custom_list.custom_sn}" id="tzsy_qy"  src="images/no.gif" />&nbsp;
  <img  title="修改" name="{$custom_list.custom_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <img id="delete_custom" name="{$custom_list.custom_sn}" title="删除" src="images/icon_drop.gif"/>
  {else if }
  <img  title="禁用" name="{$custom_list.custom_sn}" id="tzsy_jy"  src="images/yes.gif" />&nbsp;
  <img  title="修改" name="{$custom_list.custom_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <img id="delete_custom" name="{$custom_list.custom_sn}" title="删除" src="images/icon_drop.gif"/>
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
        
           window.location='custom.php?act=edit&custom_sn='+encodeURI(encodeURI($(this).attr("name")));
           
           
        })
        })
        
        
         $("img[id='delete_custom']").each(function (){
            
            $(this).click(function (){
        
            
              if(confirm("删除"+$(this).attr("name")+"")){
               htmlobj=$.ajax({url:"custom.php?act=delete_custom&custom_sn="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
            })
        })
        
      
        
        
        $("img[id='tzsy_jy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("name")+"")){
             
              htmlobj=$.ajax({url:"custom.php?act=custom_xs&custom_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt=1",async:false});
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
             
              htmlobj=$.ajax({url:"custom.php?act=custom_xs&custom_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt=0",async:false});
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
