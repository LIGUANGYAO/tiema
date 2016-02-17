<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/Calendar3.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>

</head>

<body>

<div class="container">
  <div class="content">
  
 
 
   <div class="botable">
{if $fall==1}


   
    <table class="table" width="100%" border="0" style="margin-bottom: 7px;">

 <form>
 <tr>
 <th style="text-align: left;border-right-style:none"><input id="a_text" value="订单下载" type="button" onclick="window.open('weixiaodian.php?act=down_dj')" />&nbsp;<input id="down_hy" value="头像下载" type="hidden" /></th>
 <th style="text-align: right; border-left-style:none">&nbsp;下单时间:
   <input  class="time" value="{$th_time}" name="time" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this)" readonly="readonly" />~下单结束时间: <input  class="time2" value="{$now_time}" name="time2" type="text" id="control_date2" size="20" maxlength="10" onclick="new Calendar().show(this)" readonly="readonly" />&nbsp;
 订单状态<select id="order_status" name="order_status">
    <option  value="">全部</option> 
    <option  value="2">待发货</option>
    <option  value="3">已发货</option>
    <option  value="5">已完成</option>
    <option  value="8">维权</option>
 </select>&nbsp;
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>


 </form>
</table>

    


   <table class="table" width="100%" border="0">
   
   <tr>
   <th >订单编号</th>
   <th>订单状态</th>
   <th>昵称</th>
    <th>收货人</th>
     <th>openid</th>
    <th>手机</th>
    <th>电话</th>
        <th>已付款</th>
   <th>地址</th>
    <th>订单创建时间</th>
   
   <th>操作</th>
   </tr>
<tbody  id="table_t">
   {foreach from=$weixiaodian_list item=weixiaodian_list}
  <tr>
  <td style="width:70px">{$weixiaodian_list.order_sn}</td>
  <td style="width:70px">{if $weixiaodian_list.order_status==2}待发货{elseif $weixiaodian_list.order_status==3}已发货{elseif $weixiaodian_list.order_status==5}已完成{elseif $weixiaodian_list.order_status==8}<span style="color:red">维权</span>{else}{/if}</td>
  <td >{$weixiaodian_list.buyer_nick}</td>
   <td >{$weixiaodian_list.receiver_name}</td>
    <td >{$weixiaodian_list.buyer_openid}</td>
    <td >{$weixiaodian_list.receiver_mobile}</td>
       <td >{$weixiaodian_list.receiver_phone}</td>
     <td >{$weixiaodian_list.order_total_price}</td>
  <td  title="{$weixiaodian_list.receiver_province} {$weixiaodian_list.receiver_city} {$weixiaodian_list.receiver_address}">{$weixiaodian_list.receiver_province} {$weixiaodian_list.receiver_city} {$weixiaodian_list.receiver_address}</td>

  <td >{$weixiaodian_list.ad_time}</td>

  
  <td style="width:170px">
  {if $weixiaodian_list.or_status=="0"}
  已付款 &nbsp;&nbsp;<a style="color:blue" class="shenqtk" sn='{$weixiaodian_list.order_sn}' status='2' >申请退款</a>
  {elseif $weixiaodian_list.or_status=="1"}
  <a style="color:green">状态:已成交</a> 
  {elseif $weixiaodian_list.or_status=="2"}
  <a style="color:red">状态:申请退款</a>&nbsp;&nbsp;<a style="color:blue" class="shenqtk" sn='{$weixiaodian_list.order_sn}' status='4' >同意退款</a>
  {elseif $weixiaodian_list.or_status=="3"}
  <a style="color:red">状态:申请部分退款</a>
  {elseif $weixiaodian_list.or_status=="4"}
  状态:同意退款&nbsp;&nbsp;<a style="color:blue" class="shenqtk" sn='{$weixiaodian_list.order_sn}' status='5' >已退款</a>
  {elseif $weixiaodian_list.or_status=="5"}
  状态:已经退款
  {/if}
  
  {if $weixiaodian_list.tzsy==1}
  <!-- <img  title="启用" name="{$weixiaodian_list.weixiaodian_sn}" id="tzsy_qy"  src="images/no.gif" />&nbsp;-->
  <!--<img  title="修改" name="{$weixiaodian_list.weixiaodian_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;-->
  <!--<img id="delete_weixiaodian" name="{$weixiaodian_list.weixiaodian_sn}" title="删除" src="images/icon_drop.gif"/>-->
  {else if }
  <!--<img  title="禁用" name="{$weixiaodian_list.weixiaodian_sn}" id="tzsy_jy"  src="images/yes.gif" />&nbsp;-->
  <!--<img  title="修改" name="{$weixiaodian_list.weixiaodian_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;-->
  <!--<img id="delete_weixiaodian" name="{$weixiaodian_list.weixiaodian_sn}" title="删除" src="images/icon_drop.gif"/>-->
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
        
           window.location='weixiaodian.php?act=edit&weixiaodian_sn='+encodeURI(encodeURI($(this).attr("name")));
           
           
        })
        })
        
        
         $("img[id='delete_weixiaodian']").each(function (){
            
            $(this).click(function (){
        
            
              if(confirm("删除"+$(this).attr("name")+"")){
               htmlobj=$.ajax({url:"weixiaodian.php?act=delete_weixiaodian&weixiaodian_sn="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
            })
        })
        
      
        
        
        $("img[id='tzsy_jy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("name")+"")){
             
              htmlobj=$.ajax({url:"weixiaodian.php?act=weixiaodian_xs&weixiaodian_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt=1",async:false});
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
             
              htmlobj=$.ajax({url:"weixiaodian.php?act=weixiaodian_xs&weixiaodian_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt=0",async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        
     $("#order_status").val("{$status}");
     
     
     
      $(".shenqtk").each(function(){
                $(this).click(function (){
                var sn=$(this).attr("sn");
                var status=$(this).attr("status");
                var txt=$(this).text();
                if(confirm("确认"+txt+"吗?")){
                     $.ajax({
            			url: "weixiaodian.php?act=set_or_status",
            			dataType: "json",
                        type: 'POST',
                        //async:false,
            			data: {
                            "sn":sn,
                            "or_status":status
            
            			},
            			beforeSend: function() {
            			
            			},
            			success: function(data) {
       			     
                          location.reload();
            			},
            			error: function() {
            			  
            			},
            			
            		})
                    
                }
                else
                {
                    return false;
                }
           
            
                 
            })
       })
     
})
-->
</script>
