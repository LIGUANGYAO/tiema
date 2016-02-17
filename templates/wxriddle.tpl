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
{if $fall==1}

   
 <table class="table" width="100%" border="0" style="margin-bottom: 7px;">

 <form>
 <tr>
 <th style="text-align: left;border-right-style:none"><input id="a_text" value="添加谜语" type="button" onclick="window.location='wxriddle.php?act=add_wxriddle_list'" />&nbsp;<input id="down_hy" value="头像下载" type="hidden" /></th>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>


 </form>
</table>
    


   <table class="table" width="100%" border="0">
   
   <tr>
   <th >谜语代码</th>
   <th>谜语名称</th>
    <th>谜面</th>
      <th>谜底</th>
    <th>类型</th>
   <th>最后更新时间</th>

   <th>操作</th>
   </tr>
<tbody  id="table_t">
   {foreach from=$wxriddle_list item=wxriddle_list}
  <tr>
  <td style="width:70px">{$wxriddle_list.wxriddle_sn}</td>
  <td style="width:140px">{$wxriddle_list.wxriddle_name}</td>
<td style="width:140px">{$wxriddle_list.title}</td>
<td style="width:140px">{$wxriddle_list.wxriddle_note_2}</td>
 <td style="width:140px">{$wxriddle_list.lx_sn}_{$wxriddle_list.lx_name}</td>
  <td style="width:150px">{$wxriddle_list.last_update}</td>
 
  
  <td style="width:110px"> 
  {if $wxriddle_list.tzsy==1}
   <img  title="启用" name="{$wxriddle_list.wxriddle_sn}" id="tzsy_qy"  src="images/no.gif" />&nbsp;
  <img  title="修改" name="{$wxriddle_list.wxriddle_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <img id="delete_wxriddle" name="{$wxriddle_list.wxriddle_sn}" title="删除" src="images/icon_drop.gif"/>
 <!-- <img  id="fuzhi" title="复制url"  name="{$wxriddle_list.art_url}" src="images/icon_copy.gif"/>
    <img  id="yulan" title="预览"  name="{$wxriddle_list.art_url}" src="images/icon_view.gif"/> -->
  {else if }
  <img  title="禁用" name="{$wxriddle_list.wxriddle_sn}" id="tzsy_jy"  src="images/yes.gif" />&nbsp;
  <img  title="修改" name="{$wxriddle_list.wxriddle_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <img id="delete_wxriddle" name="{$wxriddle_list.wxriddle_sn}" title="删除" src="images/icon_drop.gif"/>

   <!--  <img  id="fuzhi" title="复制url" name="{$wxriddle_list.art_url}" src="images/icon_copy.gif"/>
      <img  id="yulan" title="预览"  name="{$wxriddle_list.art_url}" src="images/icon_view.gif"/> -->
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
        
           window.location='wxriddle.php?act=edit&wxriddle_sn='+encodeURI(encodeURI($(this).attr("name")));
           // window.open('wxriddle.php?act=edit&wxriddle_sn='+encodeURI(encodeURI($(this).attr("name"))));
           
        })
        })
        
        
         $("img[id='delete_wxriddle']").each(function (){
            
            $(this).click(function (){
        
            
              if(confirm("删除"+$(this).attr("name")+"")){
               htmlobj=$.ajax({url:"wxriddle.php?act=delete_wxriddle&wxriddle_sn="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
            })
        })
        
      
        
        
        $("img[id='tzsy_jy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("name")+"")){
             
              htmlobj=$.ajax({url:"wxriddle.php?act=wxriddle_xs&wxriddle_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt=1",async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").wxriddleToggle(200);
           
           
        })
        })
        $("img[id='tzsy_qy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("启用"+$(this).attr("name")+"")){
             
              htmlobj=$.ajax({url:"wxriddle.php?act=wxriddle_xs&wxriddle_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt=0",async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").wxriddleToggle(200);
           
           
        })
        })
         
         
         $("img[id='fuzhi']").each(function (){
                
                $(this).click(function(){
                    
                      window.clipboardData.setData("Text",$(this).attr("name"));
                     
                })
               
         })
        
        
          $("img[id='yulan']").each(function (){
                
                $(this).click(function(){
                   window.open($(this).attr("name"))
                })
               
         })
        
        
        

    
})
-->
</script>
