<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
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
 <th style="text-align: left;border-right-style:none">
 批量设置比例：
 <input name="point" id="point" value="0.00" />%<a style="color:red;"><input  type="button" value="批量设置" id="plset" />&nbsp;&nbsp;&nbsp;注:请输入比例</a>
 </th>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;</th>
 
 </tr>


 </form>
</table>

    


   <table class="table" width="100%" border="0">
    <tr><td colspan="10" style="background-color:    #E8E8E8;"><b>所属渠道&nbsp;({$qudao}/{$qudao_name})</b></td></tr>
   <tr>
   <th >导购代码</th>
   <th>导购员</th>
   <!--<th>URL</th>-->
  
   

   <th>设置比例</th>
   </tr>
<tbody  id="table_t">
<input  type="hidden" value="{$qudao}" id="qudao"/>
   {foreach from=$sales_list item=sales_list}
   
     <tr><td colspan="10" style="background-color:#;"><b>店铺&nbsp;({$sales_list.shop_sn}/{$sales_list.shop_name}/{$sales_list.province}&nbsp;{$sales_list.city}&nbsp;{$sales_list.district}&nbsp;{$sales_list.shop_address})</b></td></tr>
      
     {foreach from=$sales_list.sales item=sales}
  <tr>

 
  
  <td >{$sales.sales_sn}</td>
  <td >{$sales.sales_name}</td>
 


        <p>{$sales.sales_address}</p>
  </td>

  <td  style="width:200px">
  <input name="sales_point" class="sales_point" sales_sn="{$sales.sales_sn}" shop_sn="{$sales_list.shop_sn}" value="{$sales.tg.point}" />%
  </td>
  
  </tr>
  {foreachelse}
  <tr>
  <td style="width:70px" colspan="20">无记录</td>
  </tr>
  
  {/foreach}
  
  {foreachelse}
  <tr>
  <td style="width:70px" colspan="20">无记录</td>
  </tr>
   {/foreach}
  
</tbody>
</table>


<table class="table" width="100%" border="0">
<!--<tr><td style="text-align: right;">{include file="foot.tpl"}</td></tr> -->
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
       
        var qudao=$("#qudao").val();
        
       
        
        $(".sales_point").each(function (){
                       
                       
                
           
                        $(this).blur(function(){
                            
                             var sales_sn=$(this).attr("sales_sn");
                            var shop_sn=$(this).attr("shop_sn");
                            var tgpoint=$(this).val();
                            var xg='';
                            //开始ajax
                            htmlobj=$.ajax({
                            type:"POST",
                            //dataType: "json", 
                            url:"qudao.php?act=set_salesmx",
                            data:"&tp=2&qudao="+ qudao+"&shop_sn="+shop_sn+"&sales_sn="+ sales_sn+"&tgpoint="+tgpoint,
                            async:false,
                            beforeSend:function(XMLHttpRequest){
                            },
                            success:function(data,textStatus){
                                xg=data;
                               
                            },
                            complete:function(XMLHttpRequest,textStatus){
                            },
                            error:function(XMLHttpRequest,textStatus,errorThrown){
                            }
                            });
                            
                            
                            $(this).val(xg);
                            //end ajax
                        })
                        
                        
                      
        })
        
        
        
        //批量设置
        $("#plset").click(function(){
                            
                           
                            var point=$("#point").val();
                       
                            //开始ajax
                            htmlobj=$.ajax({
                            type:"POST",
                            //dataType: "json", 
                            url:"qudao.php?act=set_salesmx",
                            data:"&tp=1&qudao="+ qudao+"&tgpoint="+point,
                            async:false,
                            beforeSend:function(XMLHttpRequest){
                            },
                            success:function(data,textStatus){
                                location.reload();
                               
                            },
                            complete:function(XMLHttpRequest,textStatus){
                            },
                            error:function(XMLHttpRequest,textStatus,errorThrown){
                            }
                            });
                            $("#point").val("0.00");
                            
                            
                        })
                        
})
-->
</script>


