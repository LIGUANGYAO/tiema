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
 <th style="text-align: left;border-right-style:none"><input id="a_text" value="添加模板" type="button" onclick="location='wx_order_list.php?act=add_order_list'" />&nbsp;<input id="down_hy" value="头像下载" type="hidden" /></th>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>


 </form>
</table>

    


   <table class="table" width="100%" border="0">
   
   <tr>
   <th>订单代码</th>
       <th>姓名</th>
   <th>身份证</th>
   <th>上级昵称</th>
   <th>联系电话</th>
   <th>车辆识别码</th>
   <th>车牌号</th>
   <th>到期时间</th>
   <th>车船险</th>
   <th>强制险</th>
   <th>商业险</th>
   <th>实缴商业险</th>
       <th>付款状态</th>
       <th>分成情况</th>
   
   <th>操作</th>
   </tr>
<tbody  id="table_t">
   {foreach from=$order_list item=order_list}
  <tr>
  <td style="width:70px">{$order_list.order_sn}</td>
  <td style="width:140px">{$order_list.username}</td>
  <td style="width:140px">{$order_list.sfz}</td>
  <td style="width:140px">{$order_list.p_name}</td>
  <td style="width:140px">{$order_list.tel}</td>
  <td style="width:140px">{$order_list.sbdm}</td>
  <td style="width:140px">{$order_list.car_no}</td>
  <td style="width:140px">{$order_list.endtime}</td>
  <td style="width:140px">{$order_list.ccx}</td>
  <td style="width:140px">{$order_list.qzx}</td>
  <td style="width:140px">{$order_list.syx}</td>
  <td style="width:140px">{$order_list.sjsyx}</td>

      <td style="width:50px">
          {if $order_list.is_pay==1}
              <img  title="已付清" name="{$order_list.is_pay}" src="images/yes.gif" />&nbsp;
          {else if }
              <img  title="未付清" name="{$order_list.is_pay}" src="images/no.gif" />&nbsp;
          {/if}
      </td>

      <td style="width:70px">
          {if $order_list.is_split==1}
              <img  title="已分成" name="{$order_list.is_split}" src="images/yes.gif" />已分成&nbsp;
          {elseif $order_list.is_pay==0}
              未清款
          {elseif $order_list.tzsy==0}
              未审核
          {elseif $order_list.is_pay==1 && $order_list.tzsy==1}
              <button id="split" name="{$order_list.order_sn}" class="">分成</button>
          {else}{/if}
      </td>




      <td style="width:70px">
  {if $order_list.tzsy==1}
      <img  title="禁用" name="{$order_list.order_sn}" id="tzsy_jy"  src="images/yes.gif" />&nbsp;
      <!--img  title="修改" name="{$order_list.order_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
      <img id="delete_order" name="{$order_list.order_sn}" title="删除" src="images/icon_drop.gif"/-->


  {else if }
      <img  title="启用" name="{$order_list.order_sn}" id="tzsy_qy"  src="images/no.gif" />&nbsp;
      <img  title="修改" name="{$order_list.order_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
      <!--img id="delete_order" name="{$order_list.order_sn}" title="删除" src="images/icon_drop.gif"/-->

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
        
           window.location='wx_order_list.php?act=edit&order_sn='+encodeURI(encodeURI($(this).attr("name")));
           
           
        })
        })
        
        
         $("img[id='delete_order']").each(function (){
            
            $(this).click(function (){
        
            
              if(confirm("删除"+$(this).attr("name")+"")){
               htmlobj=$.ajax({url:"wx_order_list.php?act=delete_order&order_sn="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
            })
        })
        
      
        
        
        $("img[id='tzsy_jy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("name")+"")){
             
              htmlobj=$.ajax({url:"wx_order_list.php?act=order_xs&order_sn="+encodeURI(encodeURI($(this).attr("name")))+"&alt=0",async:false});
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
             
              htmlobj=$.ajax({url:"wx_order_list.php?act=order_xs&order_sn="+encodeURI(encodeURI($(this).attr("name")))+"&alt=1",async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })

    $("button[id='split']").each(function (){

        $(this).click(function (){

            if(confirm("确认付款"+$(this).attr("name")+"")){

                htmlobj=$.ajax({url:"wx_order_list.php?act=order_split&order_sn="+encodeURI(encodeURI($(this).attr("name"))),async:false});
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
