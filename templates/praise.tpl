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
 <th style="text-align: left;border-right-style:none"><!--<th>URL</th><input id="a_text" value="添加模板" type="button" onclick="location='wx_praise.php?act=add_wx_praise_list'" />&nbsp;<input id="down_hy" value="头像下载" type="hidden" /></th>
 --><th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;<input  value="导出excel" type="button" id="excel" /></th>

 </tr>


 </form>
</table>

    


   <table class="table" width="100%" border="0">
   
   <tr>
   <th >商品代码</th>
   <th>商品名称</th>
   <!--<th>URL</th>-->
  
   <th>关注数量</th>

   <!--<th>操作</th>-->
   </tr>
<tbody  id="table_t">
   {foreach from=$wx_praise_list item=wx_praise_list}
  <tr>
  <td style="width:70px">{$wx_praise_list.goods_sn}</td>
  <td style="width:140px">{$wx_praise_list.goods_sn}</td>
   <!--<td  title="{$wx_praise_list.url}">{$wx_praise_list.url}</td>-->

  <td style="width:150px" class="praise_sl"><a href="praise.php?act=praise_mx&goods_sn={$wx_praise_list.goods_sn}">{$wx_praise_list.sl}</a></td>

  
  <!--<td style="width:70px"> 
  {if $wx_praise_list.tzsy==1}
   <img  title="启用" name="{$wx_praise_list.wx_praise_sn}" id="tzsy_qy"  src="images/no.gif" />&nbsp;
  <img  title="修改" name="{$wx_praise_list.wx_praise_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <img id="delete_wx_praise" name="{$wx_praise_list.wx_praise_sn}" title="删除" src="images/icon_drop.gif"/>
  {else if }
  <img  title="禁用" name="{$wx_praise_list.wx_praise_sn}" id="tzsy_jy"  src="images/yes.gif" />&nbsp;
  <img  title="修改" name="{$wx_praise_list.wx_praise_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <img id="delete_wx_praise" name="{$wx_praise_list.wx_praise_sn}" title="删除" src="images/icon_drop.gif"/>
  {/if}
  </td>-->
  
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


{if $fall==2}


   


    


   <table class="table" width="100%" border="0">
   
   <tr>
   <th >商品名称</th>
   <th>openid</th>
   <!--<th>URL</th>-->
  
   <th>昵称</th>

   <!--<th>操作</th>-->
   </tr>
<tbody  id="table_t">
   {foreach from=$res item=wxpraise_list}
  <tr>
  <td style="width:70px">{$wxpraise_list.goods_sn}</td>
  <td style="width:140px">{$wxpraise_list.openid}</td>


  <td style="width:150px">{$wxpraise_list.nick_name}</td>

  

  
  </tr>
  {foreachelse}
  <tr>
  <td style="width:70px" colspan="20">无记录</td>
  </tr>
   {/foreach}
  <tr>
  <td style="width:70px" colspan="20"><a href="praise.php">返回</a></td>
  </tr>
</tbody>
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
        
           window.location='wx_praise.php?act=edit&wx_praise_sn='+encodeURI(encodeURI($(this).attr("name")));
           
           
        })
        })
        
        
         $("img[id='delete_wx_praise']").each(function (){
            
            $(this).click(function (){
        
            
              if(confirm("删除"+$(this).attr("name")+"")){
               htmlobj=$.ajax({url:"wx_praise.php?act=delete_wx_praise&wx_praise_sn="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
            })
        })
        
      
        
        
        $("img[id='tzsy_jy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("name")+"")){
             
              htmlobj=$.ajax({url:"wx_praise.php?act=wx_praise_xs&wx_praise_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt=1",async:false});
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
             
              htmlobj=$.ajax({url:"wx_praise.php?act=wx_praise_xs&wx_praise_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt=0",async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
     
            
           $("#excel").click(function (){
                window.open('excel.php?m=praise'); 
        })
        
        
    
})
-->
</script>
