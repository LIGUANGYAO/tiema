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
 
 <th style="text-align: left;border-right-style:none"><input id="a_text" value="刷新任务" type="button" onclick="location.href='autotask_signal.php?act=refre' " />&nbsp;<input id="down_hy" value="头像下载" type="hidden" /></th>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>


 </form>
</table>
    


   <table class="table" width="100%" border="0">
   
   <tr>
   <th >类型</th>
   <th>任务名称</th>
    <th>间隔(分)</th>
   <th>运行状态</th>
   <th>最后运行时间</th>

   <th>操作</th>
   </tr>
<tbody  id="table_t">
   {foreach from=$autotask_signal_list item=autotask_signal_list}
  <tr>
  <td style="width:70px">{$autotask_signal_list.api_type}</td>
  <td style="width:140px">{$autotask_signal_list.auto_desc}</td>
  
<td style="width:7px">{$autotask_signal_list.lx_time}</td>
<td style="width:40px">{if $autotask_signal_list.is_on==1}<b id="is_on" title="点击禁用" name="{$autotask_signal_list.id}"  style="color:green">启用</b>{else}<b style="color:red" name="{$autotask_signal_list.id}" title="点击启用"  id="is_on">未启用</b>{/if}</td>
  <td style="width:100px"   > <a class="last_t" title="双击重置"  name="{$autotask_signal_list.id}">{$autotask_signal_list.last_time}</a></td>
 
  
  <td style="width:30px"> 
  {if $autotask_signal_list.tzsy==1}
   
  <img  title="修改" name="{$autotask_signal_list.id}" id="edit"  src="images/icon_edit.gif" />&nbsp;

  {else if }

  <img  title="修改" name="{$autotask_signal_list.id}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  
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
        
           window.location='autotask_signal.php?act=edit&pid='+encodeURI(encodeURI($(this).attr("name")));
           // window.open('autotask_signal.php?act=edit&autotask_signal_sn='+encodeURI(encodeURI($(this).attr("name"))));
           
        })
        })
        
        
         $("img[id='delete_autotask_signal']").each(function (){
            
            $(this).click(function (){
        
            
              if(confirm("删除"+$(this).attr("name")+"")){
               htmlobj=$.ajax({url:"autotask_signal.php?act=delete_autotask_signal&autotask_signal_sn="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
            })
        })
        
        
        
         $("b[id='is_on']").each(function (){
            
            $(this).click(function (){
        
            
              
               htmlobj=$.ajax({url:"autotask_signal.php?act=is_on&pid="+encodeURI(encodeURI($(this).attr("name"))),async:false});
                
             window.location.reload();
            })
        })
        
        $(".last_t").each(function (){
            
            $(this).dblclick(function (){
        
            
              
               htmlobj=$.ajax({url:"autotask_signal.php?act=last_t&pid="+encodeURI(encodeURI($(this).attr("name"))),async:false});
                
             window.location.reload();
            })
        })
        
      
        
        
        $("img[id='tzsy_jy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("name")+"")){
             
              htmlobj=$.ajax({url:"autotask_signal.php?act=autotask_signal_xs&autotask_signal_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt=1",async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").autotask_signalToggle(200);
           
           
        })
        })
        $("img[id='tzsy_qy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("启用"+$(this).attr("name")+"")){
             
              htmlobj=$.ajax({url:"autotask_signal.php?act=autotask_signal_xs&autotask_signal_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt=0",async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").autotask_signalToggle(200);
           
           
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
