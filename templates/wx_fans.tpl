<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>粉丝统计报表</title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/Calendar3.js"></script>
</head>

<body>

<div class="container">
  <div class="content">
  <div class="botable">
{if $fall==fans}
<table class="table" width="100%" border="0" style="margin-bottom: 7px;">
<form action="wx_fans.php?act=cx"  method="post"  enctype="multipart/form-data">
 <tr>
 <th style="text-align: left;border-right-style:none"><input id="a_text" value="点击查询" type="submit" />
 &nbsp;<!--<input id="sc_code" value="批量生成二维码" type="button"/>-->统计时间：
 <input  class="start_time" value="{$start_time}" name="start_time" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this);" readonly="readonly" />
 
 <input  class="end_time" value="{$end_time}" name="end_time" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this);" readonly="readonly" />
 
渠道： <input id="qudao" name="qudao" type="text" value="{$qudao}" />

<input name="qdbtn1" type="button" id="qdbtn1" onclick=" window.open('wx_fans.php?act=select_qudao', 'newwindow', 'height=600, width=800, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no')" value="选择" class="button"/>

客户： <input id="kehu"  name="kehu"  type="text" value="{$kehu}" />
 
<input name="khbtn1" type="button" id="khbtn1" onclick=" window.open('wx_fans.php?act=select_kehu', 'newwindow', 'height=600, width=800, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no')" value="选择" class="button"/>

<input  value="导出excel" type="button" id="excel" />
 </th>
</form>
</table>
<table class="table" width="100%" border="0">
   <tr>
   <th width="8%">渠道代码</th>
   <th width="8%">渠道名称</th>
   <th width="8%">店铺代码</th>
   <th width="28%">店铺名称</th>
   <th width="8%">场景性质</th>
   <th width="8%">场景代码</th>
   <th width="8%">上期数量</th>
   <th width="8%">本期数量</th>
   <th width="8%">合计数量</th>
   </tr>
   <tr>
  <td colspan="9">
{foreach from=$list item=list}	
   <table class="table" width="100%" border="0">
   <tr>
   <td  width="8%">{$list.qudao_sn}</td>
   <td  width="8%">{$list.qudao_name}</td>
   <td  width="8%">{$list.shop_sn}</td>
   <td width="28%">{$list.shop_name}</td>
   <td width="8%">{$list.cj_type}</td>
   <td width="8%">{$list.cj_sn}</td>
   <td width="8%">{$list.sl1}</td>
   <td width="8%">{$list.sl2}</td>
   <td width="8%">{$list.sl}</td>
   </tr>
   </table>
   {/foreach}   
</td>
   </tr>
   
    <tr>
  <td colspan="9" >
  <div style="text-align: right">
  上期总数量：{$sqzsl}
  本期总数量：{$bqzsl}
  合计总数量：{$hjzsl}
  </div>
  </td>
  </tr>
   
</table>
{/if}
<script type="text/javascript"> 
 function setValue(returnValue) {
    var type = returnValue.substring(0,1);
	returnValue = returnValue.substring(1,returnValue.length);
	
   
	if (type==1) 
	{
	 document.getElementById('qudao').value=  returnValue;
	} 
	else if(type==2) 
	{
	 document.getElementById('kehu').value=  returnValue;
	}
	}
	
	$("#excel").click(function (){
	start_time = $(".start_time").val();
	end_time = $(".end_time").val();
	qudao = $("#qudao").val();
	kehu = $("#kehu").val();
	
	//alert(start_time);
	 window.open("excel.php?m=wx_fans&start_time="+start_time+"&end_time="+end_time+"&qudao="+qudao+"&kehu="+kehu); 
        })
	
	
</script> 
</div>
</div>
</div>
</body>
</html>
