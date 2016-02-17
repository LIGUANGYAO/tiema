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



   
    <table class="table" width="100%" border="0" style="margin-bottom: 7px;">

 <form>
 <tr>
 <th style="text-align: left;border-right-style:none">&nbsp;<input id="down_hy" value="头像下载" type="hidden" /></th>
 <th style="text-align: right; border-left-style:none">&nbsp;开始时间:
   <input  class="t1" value="{$th_time}" name="t1" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this)" readonly="readonly" />~结束时间: <input  class="t2" value="{$now_time}" name="t2" type="text" id="control_date2" size="20" maxlength="10" onclick="new Calendar().show(this)" readonly="readonly" />&nbsp;
 关注状态<select id="is_att" name="is_att">
    <option  value="2">全部</option> 
    <option  value="1">关注中</option>
    <option  value="0">已取消</option>
    
 </select>&nbsp;
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;
 
<input  value="导出excel" type="button" id="excel" />
 </th>
 
 </tr>


 </form>
</table>

    


   <table class="table" width="100%" border="0">
   
   <tr>
        <th  style="width:30px">状态</th>
        <th >昵称</th>
        <!--<th >openid</th>-->
        <th style="width:60px">签到积分</th>
        <th style="width:40px">次数</th>
        <th style="width:80px">最近签到时间</th>
        <th style="width:80px">奖券兑换积分</th>
        <th style="width:40px">次数</th>
        <th  style="width:80px">积分兑换实物</th>
        <th style="width:40px">次数</th>
        
        <th style="width:100px">总积分</th>
   </tr>
<tbody  id="table_t">
   {foreach from=$tj_point_list item=tj_point_list}
  <tr>
        
        <td >{if $tj_point_list.is_att==1}<a  style="color:green">关注</a>{else}<a  style="color:red">取消</a>{/if}</td>
        <td >{$tj_point_list.nick_name}({$tj_point_list.users_sn})</td>
       <!--<td >{$tj_point_list.openid}</td>-->
        <td >{$tj_point_list.check_inlog_sum}</td>
        <td >{$tj_point_list.check_count}</td>
        <td >{$tj_point_list.check_last_update_2}</td>
        
        <td >{$tj_point_list.exp_sum}</td>
        <td >{$tj_point_list.exp_count}</td>
        
        <td  >{$tj_point_list.real_sum}</td>
        <td >{$tj_point_list.real_count}</td>
        
        <td >{$tj_point_list.point_sum}</td>
        
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
        
           window.location='tj_point.php?act=edit&tj_point_sn='+encodeURI(encodeURI($(this).attr("name")));
           
           
        })
        })
        
        
         $("img[id='delete_tj_point']").each(function (){
            
            $(this).click(function (){
        
            
              if(confirm("删除"+$(this).attr("name")+"")){
               htmlobj=$.ajax({url:"tj_point.php?act=delete_tj_point&tj_point_sn="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
            })
        })
        
      
        
        
        $("img[id='tzsy_jy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("name")+"")){
             
              htmlobj=$.ajax({url:"tj_point.php?act=tj_point_xs&tj_point_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt=1",async:false});
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
             
              htmlobj=$.ajax({url:"tj_point.php?act=tj_point_xs&tj_point_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt=0",async:false});
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
	is_att = $("#is_att").val();

	

	 window.open("excel.php?m=tj_point&t1="+time+"&t2="+time2+"&is_att="+is_att); 
        })
        
        
        $("#is_att").val("{$is_att}");
})
-->
</script>
