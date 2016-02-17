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
<script type="text/javascript">
<!--
	.table tr td p{margin:0px 0 0 0;padding:0;text-indent:0em;line-height:150%;}
-->
</script>
<body>

<div class="container">
  <div class="content">
  
 
 
   <div class="botable">
{if $fall==1}


   

 <table class="table" width="100%" border="0" style="margin-bottom: 7px;">

 <form>
 <tr>
 <th style="text-align: left;border-right-style:none">
     <input id="a_text" value="添加购险人" type="button" onclick="location='tbhome_users_buy.php?act=users_buy_list'" />&nbsp;
     <input id="down_hy" value="头像下载" type="hidden" />
 </th>
 <th style="text-align: right; border-left-style:none">
 <!--input  type="text" placeholder="检索项" id="key" name="key" /-->&nbsp;
     <input  placeholder="检索值" type="text"  id="m_key" name="m_key"/>&nbsp;
     <input  value="搜索" type="submit" />&nbsp;&nbsp;
 </th>
 
 </tr>


 </form>
</table>

   <table class="table" width="100%" border="0">
   
   <tr>
   <th >订单代码</th>
   <th>姓名</th>
   <th>身份证</th>
   <th>上级昵称</th>
   <th>联系电话</th>
   <th>车辆识别码</th>
       <th >车牌号</th>
       <th>到期时间</th>
       <th>车船险</th>
       <th>交强险</th>
       <th>商业险</th>
       <th>实缴商业险</th>
       <th>付款状态</th>
       <th>分成情况</th>

   <th>操作</th>
   </tr>
<tbody  id="table_t">
   {foreach from=$users_buy_list item=users_buy_list}
  <tr>
  <td style="width:30px">{$users_buy_list.id}</td>
  <td style="width:70px">{$users_buy_list.truename}</td>
      <td style="width:70px">{$users_buy_list.nationalid}</td>
      <td style="width:70px">{$users_buy_list.up_nickname}</td>
      <td style="width:70px">{$users_buy_list.mobile}</td>
      <td style="width:70px">{$users_buy_list.vin}</td>
      <td style="width:70px">{$users_buy_list.plateid}</td>
      <td style="width:70px">{$users_buy_list.duetime}</td>
      <td style="width:70px">{$users_buy_list.vehicle_insur}</td>
      <td style="width:70px">{$users_buy_list.traffic_insur}</td>
      <td style="width:70px">{$users_buy_list.business_insur}</td>
      <td style="width:70px">{$users_buy_list.business_insur_ispay}</td>
      <td style="width:50px">
          {if $users_buy_list.is_pay==1}
          <img  title="已付清" name="{$users_buy_list.is_pay}" src="images/yes.gif" />&nbsp;
          {else if }
          <img  title="未付清" name="{$users_buy_list.is_pay}" src="images/no.gif" />&nbsp;
          {/if}
      </td>

      <td style="width:60px">
          {if $users_buy_list.is_split==1}
              <img  title="已分成" name="{$users_buy_list.is_split}" src="images/yes.gif" />已分成&nbsp;
          {elseif $users_buy_list.is_pay==0}
              未清款
          {elseif $users_buy_list.status==0}
              未审核
              {elseif $users_buy_list.is_pay==1 && $users_buy_list.status==1}
              <button id="split" name="{$users_buy_list.orderid}">分成</button>
              {else}{/if}
      </td>


  <!--td style="width:70px">{if $activity_list.ac_lx==1}大转盘{elseif $activity_list.ac_lx==2}砸金蛋{elseif $activity_list.ac_lx==3}刮刮卡{elseif $activity_list.ac_lx==4}博饼{else}{/if}</td-->

  <!--td  title="">
 
      <p>一等奖数量:{$activity_list.prize_mx.prize1_sl}&nbsp;&nbsp;概率:{$activity_list.prize_mx.prize1_gl}%&nbsp;&nbsp;/已中数量{$activity_list.prize_mx.prize1_sl2}</p>
      <p>二等奖数量:{$activity_list.prize_mx.prize2_sl}&nbsp;&nbsp;概率:{$activity_list.prize_mx.prize2_gl}%&nbsp;&nbsp;/已中数量{$activity_list.prize_mx.prize2_sl2}</p>
      <p>三等奖数量:{$activity_list.prize_mx.prize3_sl}&nbsp;&nbsp;概率:{$activity_list.prize_mx.prize3_gl}%&nbsp;&nbsp;/已中数量{$activity_list.prize_mx.prize3_sl2}</p>
  </td>
   <td style="width:70px">{$activity_list.hd_number}</td>
  <td style="width:150px"><p>{$activity_list.start_time}至</p>
  <p>{$activity_list.end_time}</p></td-->

 
  
  <td style="width:70px"> 
  {if $activity_list.tzsy==0}
   <img  title="审核" name="{$users_buy_list.status}" id="tzsy_qy"  src="images/no.gif" />&nbsp;
  <img  title="修改" name="{$users_buy_list.status}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <!--<img id="delete_activity" name="{$users_buy_list.status}" title="删除" src="images/icon_drop.gif"/>-->
  {else if }
  <img  title="退回" name="{$users_buy_list.status}" id="tzsy_jy"  src="images/yes.gif" />&nbsp;
  <!--<img  title="修改" name="{$users_buy_list.status}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <img id="delete_activity" name="{$users_buy_list.status}" title="删除" src="images/icon_drop.gif"/>-->
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
        
           window.location='activity.php?act=edit&activity_sn='+encodeURI(encodeURI($(this).attr("name")));
           
           
        })
        })
        
        
         $("img[id='delete_activity']").each(function (){
            
            $(this).click(function (){
        
            
              if(confirm("删除"+$(this).attr("name")+"")){
               htmlobj=$.ajax({url:"activity.php?act=delete_activity&activity_sn="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
            })
        })
        
      
        
        
        $("img[id='tzsy_jy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("name")+"")){
             
              htmlobj=$.ajax({url:"activity.php?act=activity_xs&activity_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt=1",async:false});
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
             
              htmlobj=$.ajax({url:"activity.php?act=activity_xs&activity_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt=0",async:false});
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
