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
<style type="text/css">
<!--
	    .table tr td p{margin:0px 0 0 0;padding:0;text-indent:0em;line-height:150%;}
-->
</style>
<body>

<div class="container">
  <div class="content">
  
 
 
   <div class="botable">
{if $fall==1}


   
    <table class="table" width="100%" border="0" style="margin-bottom: 7px;">

 <form>
 <tr>
 <th style="text-align: left;border-right-style:none">&nbsp;<input id="down_hy" value="头像下载" type="hidden" /></th>
 <th style="text-align: right; border-left-style:none">&nbsp;下单时间:
   <input  class="t1" value="{$th_time}" name="t1" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this)" readonly="readonly" />~下单结束时间: <input  class="t2" value="{$now_time}" name="t2" type="text" id="control_date2" size="20" maxlength="10" onclick="new Calendar().show(this)" readonly="readonly" />&nbsp;
 订单状态<select id="order_status" name="order_status">
    <option  value="">全部</option> 
    <option  value="2">待发货</option>
    <option  value="3">已发货</option>
    <option  value="5">已完成</option>
    <option  value="8">维权</option>
 </select>&nbsp;
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;
 
<input  value="导出excel" type="button" id="excel" />
 </th>
 
 </tr>


 </form>
</table>

    


   <table class="table" width="100%" border="0">
   
   <tr>
   <th >推广类型</th>
    <th >推广渠道</th>
   <th>关联关注者</th>
   <th>推广扣点</th>
    <th>分成</th>
    <th>分成总额</th>
    
    <th>店铺分成</th>
    <th>导购分成</th>
    
    <th>小店订单</th>
     <th>订单金额</th>
    <th>商品金额</th>
    <th>邮费</th>
    <th>购买人</th>
   <!--<th>购买人openid</th>-->
    <th>购买时间</th>
   
    <th>订单状态</th>
   </tr>
<tbody  id="table_t">
   {foreach from=$tj_fxfc_list item=tj_fxfc_list}
  <tr>
  <td >{if $tj_fxfc_list.cj_type=='qudao'}渠道{elseif $tj_fxfc_list.cj_type=='shop'}商店{elseif $tj_fxfc_list.cj_type=='sales'}店员{else}{/if}</td>
  <td >{$tj_fxfc_list.qudao_sn}_{$tj_fxfc_list.qudao_name}</td>
  
  <td >{foreach from=$tj_fxfc_list.tg item=tg}<p>{$tg.users_sn}({$tg.nick_name})</p> {/foreach}</td>
  <td >
  {foreach from=$tj_fxfc_list.tg item=tg}<p>{$tg.point}%</p> {/foreach}
  </td>

    <td >
  {foreach from=$tj_fxfc_list.tg item=tg}<p>￥{$tg.fc}</p> {/foreach}
  </td>
  <td >{$tj_fxfc_list.zbl}%/￥{$tj_fxfc_list.zfc}</td>
  
   <td >{if $tj_fxfc_list.p_tp==1}{$tj_fxfc_list.shop_fenc.zongfc}{elseif $tj_fxfc_list.p_tp==2}无{else}无{/if}</td>
   <td >
   {if $tj_fxfc_list.p_tp==1}{$tj_fxfc_list.sales_fenc.zongfc}{elseif $tj_fxfc_list.p_tp==2}{$tj_fxfc_list.shop_sales_fenc.zongfc}{else}无{/if}
   </td>
   
  <td >{$tj_fxfc_list.order_sn}</td>
  <td >{$tj_fxfc_list.order_total_price}</td>
  <td >{$tj_fxfc_list.product_price}</td>
  <td >{$tj_fxfc_list.order_express_price}</td>
  <td >{$tj_fxfc_list.buyer_nick}</td>
  <!--<td >{$tj_fxfc_list.buyer_openid}</td>-->
   <td >{$tj_fxfc_list.order_create_time}</td>
    <td >{if $tj_fxfc_list.order_status==2}待发货{elseif $tj_fxfc_list.order_status==3}已发货{elseif $tj_fxfc_list.order_status==5}已完成{elseif $tj_fxfc_list.order_status==8}<span style="color:red">维权</span>{else}{/if} </td >
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
        
           window.location='tj_fxfc.php?act=edit&tj_fxfc_sn='+encodeURI(encodeURI($(this).attr("name")));
           
           
        })
        })
        
        
         $("img[id='delete_tj_fxfc']").each(function (){
            
            $(this).click(function (){
        
            
              if(confirm("删除"+$(this).attr("name")+"")){
               htmlobj=$.ajax({url:"tj_fxfc.php?act=delete_tj_fxfc&tj_fxfc_sn="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
            })
        })
        
      
        
        
        $("img[id='tzsy_jy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("name")+"")){
             
              htmlobj=$.ajax({url:"tj_fxfc.php?act=tj_fxfc_xs&tj_fxfc_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt=1",async:false});
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
             
              htmlobj=$.ajax({url:"tj_fxfc.php?act=tj_fxfc_xs&tj_fxfc_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt=0",async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        
     $("#order_status").val("{$status}");
     
    $("#excel").click(function (){
	time = $(".t1").val();
	time2 = $(".t2").val();
	order_status = $("#order_status").val();

	

	 window.open("excel.php?m=tj_fxfc&t1="+time+"&t2="+time2+"&order_status="+order_status); 
        })
})
-->
</script>
