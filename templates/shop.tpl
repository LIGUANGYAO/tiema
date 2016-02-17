<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商店管理</title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script src="http://api.map.baidu.com/api?v=1.5&ak=ULZzR8MYgQwHvkOeFTk0Or0l"></script>
</head>

<body>

<div class="container">
  <div class="content">
  <div class="botable">
{if $fall==shop}
<table class="table" width="100%" border="0" style="margin-bottom: 7px;">
<form>
 <tr>
 <th style="text-align: left;border-right-style:none"><input id="a_text" value="添加商店" type="button" onclick="location='shop.php?act=a_shop'" />
 &nbsp;注：场景值ID为1的是永久场景微信公众号二维码（和微信后台生成的二维码是一致的）<!--<input id="sc_code" value="批量生成二维码" type="button"/>--></th>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>


 </form>
</table>


   <table class="table" width="100%" border="0">
   
   <tr>
   <th>商店代码</th>
   <th>商店名称</th>
   <th>商店类型</th>
   <th>所属渠道</th>
   <th>场景值ID（1到100000）</th>
   <th>二维码</th>
      <th>推广信息</th>
   <th>添加时间</th>
   <th>操作</th>
   </tr>
<tbody  id="table_t">
   {foreach from=$shop_list item=shop_list}
  <tr>
  <td>{$shop_list.shop_sn}</td>
  <td>{$shop_list.shop_name}</td>
  <td>{if $shop_list.shop_type==0}直营{/if}{if $shop_list.shop_type==1}加盟{/if}</td>
  <td>{$shop_list.p_id}</td>
  <td>{$shop_list.qrcid}</td>
  <td> <a href="shop.php?act=view_qrcode&ticket={$shop_list.ticket}">查看</a></td>
 <!-- <td><img src="{$shop_list.shop_qy}"  width="40" height="40"/></td>-->
 
  <td>{foreach from=$shop_list.point item=point_l} 
  <p>{$point_l.users_sn}({$point_l.nick_name})/<a style="color:red">{$point_l.point}%</a></p>{foreachelse}无{/foreach}
  </td>
  <td>{$shop_list.add_time}</td>
  
  <td > 
  {if $shop_list.tzsy==1}
   <img  title="启用" name="{$shop_list.shop_sn}" id="qiyong"  src="images/no.gif" />&nbsp;
  <img  title="修改" name="{$shop_list.shop_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <img id="de1" name="{$shop_list.shop_sn}" title="删除" src="images/icon_drop.gif"/>
  {else if }
  <img  title="禁用" name="{$shop_list.shop_sn}" id="jinyong"  src="images/yes.gif" />&nbsp;
  <img  title="修改" name="{$shop_list.shop_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <img id="de1" name="{$shop_list.shop_sn}" title="删除" src="images/icon_drop.gif"/>
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


{if $fall==e_shop}
<form action="shop.php?act=post" method="POST">
<table class="table" width="100%" border="0">
    <tr><td colspan="2"><b>编辑</b></td></tr>
	
  <tr>
    <td>商店代码:</td>
    <td><input  type="text" value="{$shop.shop_sn}" disabled="disabled"/><a style="color:red;">*</a></td></tr>
    <input name="shop_sn" id="shop_sn"  type="hidden" value="{$shop.shop_sn}" />
  <tr>
    <td>商店名称:</td>
    <td><input name="shop_name"  id="shop_name" type="text" value="{$shop.shop_name}"  size="50"/><a style="color:red;">*</a></td></tr>
  <tr><td>商店类型:</td><td>
  
  {if $shop.shop_type==0}<input type="radio" name="shop_type" value="0" checked />直营{else}<input type="radio" name="shop_type" value="0"/>直营{/if}
  {if $shop.shop_type==1}<input type="radio" name="shop_type" value="1" checked />加盟{else}<input type="radio" name="shop_type" value="1"/>加盟{/if}
  
 
  </td> 
  </tr>
  <tr>
    <td>场景值ID:</td>
    <td><input   type="text"  value="{$shop.qrcid}" disabled="disabled">
    <input name="qrcid" id="qrcid"  type="hidden" value="{$shop.qrcid}" />
    </td>
  </tr>
  
  
  <tr>
    <tr>
      <td>上级渠道:</td>
      <td>
     <label>渠道类型：</label>
	 <select  name="b_id" id="b_id"> 
          <option value="">请选择</option>
          <option value="0">总公司</option>
		  <option value="1">分公司</option>
		 
	 </select>
     <label>所属渠道：</label> <select name="p_id" id="p_id">{$shop.p_id}
            <option value="">请选择</option>
            {foreach from=$shop.qs item=qs}
            <option  value ="{$qs.qudao_sn}">{$qs.qudao_name}</option>    
            {/foreach}
	 
	 </select> 
  </td> 
  </tr>
  
  <!-- sheng省市区设定-->
  
   <tr>
    <td>省、市、区：</td>
    <td>
    
    
     省份:<select  name="province" id="province" style="width: 150px;" > 
            <option  value ="">请选择</option>  
            {foreach from=$shop.region.province item=province}
            <option  value ="{$province.region_sn}">{$province.region_name}</option>    
            {/foreach}
            </select>
            
            城市:<select  name="city" id="city" style="width: 150px;" > 
            <option  value ="">请选择</option> 
            {foreach from=$shop.region.city item=city}
            <option  value ="{$city.region_sn}">{$city.region_name}</option>    
            {/foreach}
            </select>
            地区:<select  name="district" id="district" style="width: 150px;" > 
            <option  value ="">请选择</option> 
            {foreach from=$shop.region.district item=district}
            <option  value ="{$district.region_sn}">{$district.region_name}</option>    
            {/foreach}
            </select>
    
    
    
    </td>
  </tr>
  <!-- sheng省市区设定-->
     <tr>
    <td>详细地址：</td>
    <td><input type="text"  value="{$shop.shop_address}" id="shop_address" name=" shop_address" size="50">
    </td>
  </tr>
  
     <tr>
    <td>联系人：</td>
    <td><input type="text"  value="{$shop.shop_lxr}" id="shop_lxr" name=" shop_lxr" >
    </td>
  </tr>
  
 
  
   <tr>
   <td>地址定位:</td>
   <td>
			<input type="text" value="{$shop.lbsaddress}" name="lbsaddress" id="lbsaddress"  size="50"/><button id="locate-btn" >定位</button>
				<span class="maroon">*</span><br>
				<span class="help-inline">输入地址后，点击“自动定位”按钮可以在地图上定位。</span><br>
				<span class="help-inline">（如果输入地址后无法定位，请在地图上直接点击选择地点）</span>
			</td>
   </tr>
   
   <tr style="display: none;" id="ditu"><td >定位：</td><td>
<div id="map" style="width:800px;height:500px;"></div><input type="text" value = "{$shop.lbsjd}" name="lbsjd" id="lbsjd" onfocus="this.blur()" /><input type="text" value = "{$shop.lbswd}" name="lbswd" id="lbswd" onfocus="this.blur()"/></td></tr>
  
  
  
     <!-- 设置推广关注者-->
     <tr><td colspan="2" style="background-color:    #E8E8E8;"><b>绑定关注信息</b></td></tr>
  <tr>
   <tr>
    <td>关注者信息:</td>
    <td>
    <input  id="openid" type="hidden"/>
    
    <input name="qdbtn1" type="button" id="qdbtn1" onclick=" window.open('shop.php?act=select_openid', 'newwindow', 'height=600, width=800, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no')" value="选择" class="button"/>
    </td>
    
    </tr>
    
    <tr>
    <td>关注者推广比例:</td>
    <td>
    <table class="table" width="100%" >
        <tr><th colspan="3">信息</th></tr>
      
    </table>
     <table class="table" width="100%"  id="tgxx">
     {foreach from=$shop.point item=point}
        <tr><td>{$point.users_sn}({$point.nick_name})</td><td style='width: 30%;'><input name='open[]' id='open' value='{$point.users_sn}({$point.nick_name})' type='hidden' /><input name='oppoint[]' id='oppoint' value='{$point.point}' style='width: 130px; text-align: center;'/>%</td></tr>
     {/foreach}
      
    </table>
    </td></tr>
    
    
        <!-- 设置导购分成 -->
    <tr><td colspan="2" style="background-color:    #E8E8E8;"><b>导购设置</b></td></tr>
    <tr>
    <td>店铺下级导购推广比例:</td>
    <!--<td>  <input name="point" id="point" value="0" />%<a style="color:red;">&nbsp;&nbsp;&nbsp;注:请输入比例</a></td>-->
      <td> 导购默认比例:<input name="dgpoint" id="dgpoint" value="{$shop.dgpoint}" />%<a style="color:red;">&nbsp;&nbsp;&nbsp;注:请输入比例</a></td>
     <td>

    
   
    </td>
    </tr>
    <!--
    <tr><td>导购详细设置</td>
    <td>
    <input name="set_sales" type="button" id="set_sales" onclick=" window.open('qudao.php?act=set_sales&qudao={$qudao.qudao_sn}&qudao_name={$qudao.qudao_name}', 'set_sales', 'height=600, width=1000, top=0, left=0, toolbar=yes, menubar=no, scrollbars=yes, resizable=no, location=no, status=no  ')" value="设置" class="button"/>
    </td>
     
    </tr>-->
    
    <!-- end设置推广关注者-->
    
  
  
  <tr><td colspan="2"  style="text-align: center;"><input  id="queding" type="submit" value="确定"/>&nbsp;<input  type="button" value="取消" id="quxiao" onclick="location='shop.php'"/></td></tr>
</table>
</form>
<!--二级联动菜单-->
<script type="text/javascript">
<!--
$(function(){      
$("#b_id").change(function(){         
getSelectVal();    
}); 
}); 

function getSelectVal(){
		var list='list';
		     $.getJSON("shop.php",{b_id:$("#b_id").val(),act:list},function(json){
			          var p_id = $("#p_id");
					  $("option",p_id).remove(); //清空原有的选项
                        var option="<option  value =''>请选择</option>";
                       p_id.append(option); 
					    $.each(json,function(index,array){
						              option = "<option value='"+array['qudao_sn']+"'>"+array['qudao_name']+"</option>";
									 p_id.append(option);         
			});
		 });
} 
</script>
<!--二级联动菜单-->
{/if}



{if $fall==a_shop}
<form action="shop.php?act=i_shop" method="POST">
<table class="table" width="100%" border="0">
    <tr>
      <td colspan="2"><strong>新增商店</strong></td>
    </tr>
  <tr>
    <td>商店代码:</td>
    <td><input name="shop_sn" id="shop_sn"  type="text" /><a style="color:red;">*</a></td></tr>
  <tr>
    <td>商店名称:</td>
    <td><input name="shop_name"  id="shop_name" type="text"  size="50"/><a style="color:red;">*</a></td></tr>
  <tr><td>商店类型:</td><td>
  
   <input type="radio" name="shop_type" value="0" checked />直营
   <input type="radio" name="shop_type" value="1" />加盟
 
  </td> 
  </tr>
  
    <tr>
    <td>场景值ID:</td>
    <td><input name="qrcid" id="qrcid"  type="text" maxlength="5" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" value="{$bh.bh}">
   <span style="width:150px;" id="abc"></span> <a style="color:red;">*点击空白处验证场景ID（20000到39999）</a></td>
  </tr>
  
  
    <tr>
      <td>上级渠道:</td>
      <td>
     <label>渠道类型：</label>
	 <select  name="b_id" id="b_id"> 
          <option value="">请选择</option>
          <option value="0">总公司</option>
		  <option value="1">分公司</option>
		 
	 </select>
     <label>所属渠道：</label> <select name="p_id" id="p_id">{$shop.p_id}
            <option value="">请选择</option>
            {foreach from=$shop.qs item=qs}
            <option  value ="{$qs.qudao_sn}">{$qs.qudao_name}</option>    
            {/foreach}
	 
	 </select>  
   
 
  </td> 
  </tr>
  
  
  
     <tr>
    <td>
    
     
     
    省、市、区：
    
    </td>
    <td>
       
	省份:<select  name="province" id="province" style="width: 150px;" > 
            <option  value ="">请选择</option>  
            {foreach from=$region.province item=province}
            <option  value ="{$province.region_sn}">{$province.region_name}</option>    
            {/foreach}
            </select>
            
            城市:<select  name="city" id="city" style="width: 150px;" > 
            <option  value ="">请选择</option> 
            {foreach from=$region.city item=city}
            <option  value ="{$city.region_sn}">{$city.region_name}</option>    
            {/foreach}
            </select>
            地区:<select  name="district" id="district" style="width: 150px;" > 
            <option  value ="">请选择</option> 
            {foreach from=$region.district item=district}
            <option  value ="{$district.region_sn}">{$district.region_name}</option>    
            {/foreach}
            </select>
    
   
    </td>
  </tr>
  
  <tr>
    <td>详细地址：</td>
    <td><input type="text"  value="" id="shop_address" name=" shop_address" size="50">
    </td>
  </tr>
  
    <tr>
    <td>联系人：</td>
    <td><input type="text"  value="" id="shop_lxr" name=" shop_lxr" >
    </td>
  </tr>
  
  
   <tr>
   <td>地址定位:</td>
   <td>
			<input type="text" value="" name="lbsaddress" id="lbsaddress"  size="50"/><button id="locate-btn">定位</button>
				<span class="maroon">*</span><br>
				<span class="help-inline">输入地址后，点击“自动定位”按钮可以在地图上定位。</span><br>
				<span class="help-inline">（如果输入地址后无法定位，请在地图上直接点击选择地点）</span>
			</td>
   </tr>
   
   <tr style="display: none;"  id="ditu"><td >定位：</td><td>
<div id="map" style="width:800px;height:500px;"></div>
<input type="text" value = "118.628209" name="lbsjd" id="lbsjd" onfocus="this.blur()" />
<input type="text" value = "24.873773" name="lbswd" id="lbswd" onfocus="this.blur()"/></td></tr>
  
  
  
  
     <!-- 设置推广关注者-->
     <tr><td colspan="2" style="background-color:    #E8E8E8;"><b>绑定关注信息</b></td></tr>
  <tr>
   <tr>
    <td>关注者信息:</td>
    <td>
    <input  id="openid" type="hidden"/>
    
    <input name="qdbtn1" type="button" id="qdbtn1" onclick=" window.open('shop.php?act=select_openid', 'newwindow', 'height=600, width=800, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no')" value="选择" class="button"/>
    </td>
    
    </tr>
    
    <tr>
    <td>关注者推广比例:</td>
    <td>
    <table class="table" width="100%" >
        <tr><th colspan="3">信息</th></tr>
      
    </table>
     <table class="table" width="100%"  id="tgxx">
     {foreach from=$shop.point item=point}
        <tr><td>{$point.users_sn}({$point.nick_name})</td><td style='width: 30%;'><input name='open[]' id='open' value='{$point.users_sn}({$point.nick_name})' type='hidden' /><input name='oppoint[]' id='oppoint' value='{$point.point}' style='width: 130px; text-align: center;'/>%</td></tr>
     {/foreach}
      
    </table>
    </td></tr>
    <!-- end设置推广关注者-->
  
  
  
  
  

  <tr>
  <tr><td colspan="2"  style="text-align: center;"><input  id="queding" type="submit" value="确定"/>&nbsp;<input  type="button" value="取消" id="quxiao" onclick="location='shop.php'"/></td></tr>
</table>
</form>

<!--二级联动菜单-->
<script type="text/javascript">
<!--
<!--判断场景ID是否存在-->
  $("#queding").attr("disabled","true");
	 		$("#qrcid").blur(function () { 
			    var qrcid = jQuery.trim($("#qrcid").attr('value'));
				 var html="";
				//alert(qrcid);
				$.post('shop.php?act=checkshop&qrcid='+qrcid,
				function(data) {
					if (data.success == true) {
					//0可用  1不可用
					if(data.check=='1'){
					$("#queding").attr("disabled","true");
					$('#abc').html(data.msg); 
					     //setTimeout('window.location.href=location.href',1000);
					}
					
					if(data.check=='0'){
					$("#queding").removeAttr("disabled");
					$('#abc').html(data.msg); 
					  
                        //setTimeout('window.location.href=location.href',1000);
					}
					
					return; 
					} else {
					
					}
				},
				"json")
			});  
<!--判断场景ID是否存在-->


<!--二级联动菜单-->
$(function(){     
getSelectVal();     
$("#b_id").change(function(){         
getSelectVal();    
}); 
}); 

function getSelectVal(){
		var list='list';
		     $.getJSON("shop.php",{b_id:$("#b_id").val(),act:list},function(json){
			          var p_id = $("#p_id");
					  $("option",p_id).remove(); //清空原有的选项
                      
                        var option="<option  value =''>请选择</option>";
                       p_id.append(option); 
					    $.each(json,function(index,array){
						             var option = "<option value='"+array['qudao_sn']+"'>"+array['qudao_name']+"</option>";
									 p_id.append(option);         
			});
		 });
} 
</script>
<!--二级联动菜单-->

{/if}

{if $fall==i_staus}
<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>添加商店</b></td></tr>
 <tr><td>{$val}<a href="shop.php">返回</a></td></tr>
</table>
<script type="text/javascript">
<!--
	$(document).ready(function ()
{       
    var timer = setTimeout(function(){
      window.location="shop.php";
    }, 500);
   
})
-->
</script>
{/if}

{if $fall==view}
<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>商店二维码</b></td></tr>
 <tr><td><img src="upload/cj_qrcode/shop/{$val}"><a href="shop.php">返回</a></td></tr>
</table>
{/if}

</div>
   <!-- end .content --></div>
<!-- end .container --></div>
</body>
</html>
<script type="text/javascript">


//接受子页面信息
     function setValue(returnValue) {
        var type = returnValue.substring(0,1);
        returnValue = returnValue.substring(0,returnValue.length);
	    document.getElementById('openid').value=  returnValue;
        $("#tgxx").empty();
        
        arr=returnValue.split(',');//注split可以用字符或字符串分割
        for(var i=0;i<arr.length-1;i++)
        {
                //alert(arr[i]);
                 $("#tgxx").append("<tr><td>"+arr[i]+"</td><td style='width: 30%;'><input name='open[]' id='open' value='"+arr[i]+"' type='hidden' /><input name='oppoint[]' id='oppoint' value='0' style='width: 130px; text-align: center;'/>%</td></tr>" );
        }
        //$("#tgxx").append("<option id='select1_1' name="+ o.mc+" value="+o.dm+" >"+ o.dm +"(" + o.mc +")</option>" );});
       
        
        
        //alert(returnValue);
        
	
	}  

<!--
$(document).ready(function ()
{       

$("#shop_sn").focus();
       $("#queding").click(function(){
           if(jQuery.trim($("#shop_sn").attr('value'))=='' )
        {
            
            $("#shop_sn").focus();
            return false;
        }
         else if(jQuery.trim($("#shop_name").attr('value'))=='' )
         {
             
            $("#shop_name").focus();
            return false;
         }
		 else if(jQuery.trim($("#qrcid").attr('value'))=='' )
         {
             
            $("#qrcid").focus();
            return false;
         }
		 else if(jQuery.trim($("#p_id").attr('value'))=='' )
         {
             
            $("#p_id").focus();
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
       
        $("img[id='qiyong']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("启用"+$(this).attr("name"))){
             
              htmlobj=$.ajax({url:"shop.php?act=ed_status&qiyong="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        
        
         $("img[id='jinyong']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("name"))){
             
              htmlobj=$.ajax({url:"shop.php?act=ed_status&jinyong="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
          $("img[id='de1']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("删除"+$(this).attr("name"))){
             
              htmlobj=$.ajax({url:"shop.php?act=ed_status&de1="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        
        
        $("img[id='edit']").each(function (){
            
           $(this).click(function (){
        
           window.location='shop.php?act=e_shop&edit='+encodeURI(encodeURI($(this).attr("name")));
           
           
        })
        })
		
		
//		 $("#sc_code").click(function (){
//            if(confirm("确认批量生成？")){
//             htmlobj=$.ajax({url:"shop.php?act=sc_code",async:false});
//              //alert(htmlobj.responseText);
//			 alert("生成完毕");
//             window.location.reload();
//            }else return false;
//          })
		
		
		
        
    
})
-->
</script>
<script type="text/javascript"> 
//是否从未保存过定位信息，如果从未保存过，并且有填地址信息，那么进入页面后自动定位
var located = true;
//定位坐标
var destPoint = new BMap.Point($('#lbsjd').val(),$('#lbswd').val());
$(function(){
	/**开始处理百度地图**/
	var map = new BMap.Map("map");
	map.centerAndZoom(new BMap.Point(destPoint.lng, destPoint.lat), 12);//初始化地图
	map.enableScrollWheelZoom();
	map.addControl(new BMap.NavigationControl());
	var marker = new BMap.Marker(destPoint);
	map.addOverlay(marker);//添加标注
	map.addEventListener("click", function(e){
		if(confirm("确认选择这个位置？")){
			destPoint = e.point;
			$('#lbsjd').val(destPoint.lng);
			$('#lbswd').val(destPoint.lat);
			map.clearOverlays();
			var marker1 = new BMap.Marker(destPoint);  // 创建标注
			map.addOverlay(marker1); 
		}
	});
	
	
	
	var myValue;
 
	var local;
	function setPlace(){
	    map.clearOverlays();    //清除地图上所有覆盖物
	    local = new BMap.LocalSearch(map, { //智能搜索
	      renderOptions:{ map: map}
	    });
	    located = true;
	    local.setMarkersSetCallback(callback);
	    local.search(myValue);
	}
	
	function addEventListener(marker){
		marker.addEventListener("click", function(data){
			destPoint = data.target.getPosition(0);
		});
	}
	function callback(posi){
		$("#locate-btn").removeAttr("disabled");
		for(var i=0;i<posi.length;i++){
			if(i==0){
				destPoint = posi[0].point;
			}
			posi[i].marker.addEventListener("click", function(data){
				destPoint = data.target.getPosition(0);
			});  
		}
	}
	
	$("#lbsl_xianqu").change(function(){
		$("#locate-btn").attr("disabled","disabled");
		local = new BMap.LocalSearch(map, { //智能搜索
			renderOptions:{ map: map}
		});
		located = true;
		local.setMarkersSetCallback(callback);
		local.search($("#lbsl_xianqu").find('option:selected').text());
		return false;
	});
	$("#lbsl_shi").change(function(){
		$("#locate-btn").attr("disabled","disabled");
		local = new BMap.LocalSearch(map, { //智能搜索
			renderOptions:{ map: map}
		});
		located = true;
		local.setMarkersSetCallback(callback);
		local.search($("#lbsl_shi").find('option:selected').text());
		return false;
	});
	$("#locate-btn").click(function(){
	   
       $("#ditu").show();
		if($("#lbsaddress").val() == ""){
			alert("请输入门店地址！");
			return false;
		}
		$("#locate-btn").attr("disabled","disabled");
		local = new BMap.LocalSearch(map, { //智能搜索
			renderOptions:{ map: map}
		});
		located = true;
		local.setMarkersSetCallback(callback);
		local.search($("#lbsaddress").val());
		return false;
	});
	/**结束百度地图处理**/
});


</script>

<script type="text/javascript"> 
//省市区设定js



$("#province").val("{$shop.province}");
 $("#city").val("{$shop.city}");
 $("#district").val("{$shop.district}");


$('#province').change(function (){
    $('#city').val(""); 
    $('#district').val(""); 
     $('#address').val($("#province").find("option:selected").text()+" "); 
     
     
       //省选择清空市，市选择清空区
      htmlobj=$.ajax({
        url:"shop.php?act=get_city&province="+encodeURI(encodeURI($("#province").val()))
        ,async:false,dataType: 'json'}
      ); 
      
      
      json = $.parseJSON(htmlobj.responseText); 
      //alert(htmlobj.responseText);
      
      $('#city').empty();
        $("<option >请选择</option>").appendTo('#city');
       $.each(json, function (i, n) {  
       
                      
                        $("<option value=" + n.region_sn + ">" + n.region_name + "</option>").appendTo('#city');  
                    });  

     //alert($(this).find("option:selected").text());     
  })
  $('#city').change(function (){
    
    $('#district').val(""); 
     $('#address').val($("#province").find("option:selected").text()+" "+$("#city").find("option:selected").text()+" ");  
     
         htmlobj2=$.ajax({url:"shop.php?act=get_district&city="+encodeURI(encodeURI($("#city").val())),async:false,dataType: 'json'}); 
      json = $.parseJSON(htmlobj2.responseText); 
     // alert(htmlobj2.responseText);
      
      $('#district').empty();
        $("<option >请选择</option>").appendTo('#district');
       $.each(json, function (i, n) {  
       
                      
                        $("<option value=" + n.region_sn + ">" + n.region_name + "</option>").appendTo('#district');  
                    });  

     
  })
   $('#district').change(function (){
    
     $('#address').val($("#province").find("option:selected").text()+" "+$("#city").find("option:selected").text()+" "+$("#district").find("option:selected").text()+" ");  
   
  })
//省市区设定js end


    $("#b_id").val("{$shop.b_id}");
     $("#p_id").val("{$shop.p_id}");
    //getSelectVal();    
      
         
</script>