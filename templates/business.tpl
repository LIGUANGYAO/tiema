<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商家管理</title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script src="http://api.map.baidu.com/api?v=1.5&ak=ULZzR8MYgQwHvkOeFTk0Or0l"></script>


<script charset="utf-8" src="kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="kindeditor/lang/zh_CN.js"></script>
<script>
        var editor;
        KindEditor.ready(function(K) {
                editor = K.create('#editor_id',{
					resizeType : 1,
					allowPreviewEmoticons : true,
					allowImageUpload : true,
					items : [
						'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
						'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
						'insertunorderedlist', '|', 'emoticons', 'image', 'link']
				});
                editor = K.create('#editor_id2',{
					resizeType : 1,
					allowPreviewEmoticons : true,
					allowImageUpload : true,
					items : [
						'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
						'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
						'insertunorderedlist', '|', 'emoticons', 'image', 'link']
				});
				
        });
</script>
<script type="text/javascript">
 function SwapTxt()
  {

  var business_pp = $('#business_pp').find("option:selected").text();//获取文本框里的值 
  var province = $("#province").find("option:selected").text();
   var city = $("#city").find("option:selected").text();
    var district = $("#district").find("option:selected").text();
	var business_address = $("#business_address").val();
  //alert(business_pp);  
  $("#business_name").val(province+city+district+business_address);
  
		}
</script> 
</head>

<body>

<div class="container">
  <div class="content">
  <div class="botable">
{if $fall==business}
<table class="table" width="100%" border="0" style="margin-bottom: 7px;">
<form>
 <tr>
 <th style="text-align: left;border-right-style:none"><input id="a_text" value="添加商家" type="button" onclick="location='business.php?act=a_business'" /></th>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>


 </form>
</table>


   <table class="table" width="100%" border="0">
   
   <tr>
   <th>商家代码</th>
   <th>商家名称</th>
   <th>商家类型</th>
<!-- <th>所属渠道</th>
   <th>场景值ID（1到100000）</th>
   <th>二维码</th>-->
   <th>添加时间</th>
   <th>操作</th>
   </tr>
<tbody  id="table_t">
   {foreach from=$business_list item=business_list}
  <tr>
  <td>{$business_list.business_sn}</td>
  <td>{$business_list.business_name}</td>
  <td>{if $business_list.business_type==0}直营{/if}{if $business_list.business_type==1}加盟{/if}</td>
<!--  <td>{$business_list.p_id}</td>
  <td>{$business_list.qrcid}</td>
  <td> <a href="business.php?act=view_qrcode&ticket={$business_list.ticket}">查看</a></td>
<td><img src="{$business_list.business_qy}"  width="40" height="40"/></td>-->
  <td>{$business_list.add_time}</td>
  
  <td > 
  {if $business_list.tzsy==1}
   <img  title="启用" name="{$business_list.business_sn}" id="qiyong"  src="images/no.gif" />&nbsp;
  <img  title="修改" name="{$business_list.business_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <img id="delete" name="{$business_list.business_sn}" title="删除" src="images/icon_drop.gif"/>
  {else if }
  <img  title="禁用" name="{$business_list.business_sn}" id="jinyong"  src="images/yes.gif" />&nbsp;
  <img  title="修改" name="{$business_list.business_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <img id="delete" name="{$business_list.business_sn}" title="删除" src="images/icon_drop.gif"/>
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


{if $fall==e_business}
<form action="business.php?act=post" method="POST">
<table class="table" width="100%" border="0">
    <tr><td colspan="2"><b>编辑</b></td></tr>
	
  <tr>
    <td>商家代码:</td>
    <td><input  type="text" value="{$business.business_sn}" disabled="disabled"/><a style="color:red;">*</a></td></tr>
    <input name="business_sn" id="business_sn"  type="hidden" value="{$business.business_sn}" />
  <tr>
    <td>商家名称:</td>
    <td><input name="business_name"  id="business_name" type="text" value="{$business.business_name}"  size="50"/><a style="color:red;">*</a></td></tr>
  <tr><td>商家类型:</td><td>
  
  {if $business.business_type==0}<input type="radio" name="business_type" value="0" checked />直营{else}<input type="radio" name="business_type" value="0"/>直营{/if}
  {if $business.business_type==1}<input type="radio" name="business_type" value="1" checked />加盟{else}<input type="radio" name="business_type" value="1"/>加盟{/if}
  
 
  </td> 
  </tr>
  

  
  
<!--  <tr>
    <td>场景值ID:</td>
    <td><input   type="text"  value="{$business.qrcid}" disabled="disabled">
    <input name="qrcid" id="qrcid"  type="hidden" value="{$business.qrcid}" />
    </td>
  </tr>
  
  
  <tr>
    <tr>
      <td>上级渠道:</td>
      <td>
     <label>渠道类型：</label>
	 <select  name="b_id" id="b_id"> 
	 <option value="{$q_list.qudao_type}">{if $q_list.qudao_type==0}总公司{/if}{if $q_list.qudao_type==1}分公司{/if}</option>
          <option value="0">总公司</option>
		  <option value="1">分公司</option>
		 
	 </select>
     <label>所属渠道：</label> <select name="p_id" id="p_id">
	  <option value="{$business.p_id}">{$q_list.qudao_name}</option>
	 </select> 
  </td> 
  </tr>
-->  
  <!-- sheng省市区设定-->
  
   <tr>
    <td>省、市、区：</td>
    <td>
    
    
     省份:<select  name="province" id="province" style="width: 150px;" > 
            <option  value ="">请选择</option>  
            {foreach from=$business.region.province item=province}
            <option  value ="{$province.region_sn}">{$province.region_name}</option>    
            {/foreach}
            </select>
            
            城市:<select  name="city" id="city" style="width: 150px;" > 
            <option  value ="">请选择</option> 
            {foreach from=$business.region.city item=city}
            <option  value ="{$city.region_sn}">{$city.region_name}</option>    
            {/foreach}
            </select>
            地区:<select  name="district" id="district" style="width: 150px;" > 
            <option  value ="">请选择</option> 
            {foreach from=$business.region.district item=district}
            <option  value ="{$district.region_sn}">{$district.region_name}</option>    
            {/foreach}
            </select>
    
    
    
    </td>
  </tr>
  <!-- sheng省市区设定-->
     <tr>
    <td>详细地址：</td>
    <td><input type="text"  value="{$business.business_address}" id="business_address" name=" business_address" size="50">
    </td>
  </tr>
  
     <tr>
    <td>联系人：</td>
    <td><input type="text"  value="{$business.business_lxr}" id="business_lxr" name=" business_lxr" >
    </td>
  </tr>
  
       <tr>
    <td>联系电话：</td>
    <td><input type="text"  value="{$business.business_tel}" id="business_tel" name=" business_tel" >
    </td>
  </tr>
  
   <tr>
   <td>地址定位:</td>
   <td>
			<input type="text" value="{$business.lbsaddress}" name="lbsaddress" id="lbsaddress"  size="50"/><button id="locate-btn" >定位</button>
				<span class="maroon">*</span><br>
				<span class="help-inline">输入地址后，点击“自动定位”按钮可以在地图上定位。</span><br>
				<span class="help-inline">（如果输入地址后无法定位，请在地图上直接点击选择地点）</span>
			</td>
   </tr>
   
   <tr><td >定位：</td><td>
<div id="map" style="width:800px;height:500px;"></div><input type="text" value = "{$business.lbsjd}" name="lbsjd" id="lbsjd" onfocus="this.blur()" /><input type="text" value = "{$business.lbswd}" name="lbswd" id="lbswd" onfocus="this.blur()"/></td></tr>
  
<!--  
  	<tr>
      <td>商家主图:</td>
      <td>
     <textarea id="editor_id"name="bz1"   style="width:620px;height:310px;">
      {$business.bz1} 
    </textarea>
    </td></tr>
    <tr>
      <td>商家描述:</td>
      <td>
      <textarea id="editor_id2"name="bz2"   style="width:620px;height:310px;">
      {$business.bz2} 
    </textarea>
    </td></tr>
-->	

  
  
  
  
  
  
  
  
  
  <tr><td colspan="2"  style="text-align: center;"><input  id="queding" type="submit" value="确定"/>&nbsp;<input  type="button" value="取消" id="quxiao" onclick="location='business.php'"/></td></tr>
</table>
</form>
{/if}



{if $fall==a_business}
<form action="business.php?act=i_business" method="POST">
<table class="table" width="100%" border="0">
    <tr>
      <td colspan="2"><strong>新增商家</strong></td>
    </tr>
  <tr>
    <td>商家代码:</td>
    <td><input name="business_sn" id="business_sn"  type="text" /><a style="color:red;">*</a></td></tr>
  <tr>
    <td>商家名称:</td>
    <td><input name="business_name" id="business_name" type="text"  size="50"/>
	<a style="color:red;">*</a></td></tr>
  <tr><td>商家类型:</td><td>
  
   <input type="radio" name="business_type" value="0" checked />直营
   <input type="radio" name="business_type" value="1" />加盟
 
  </td> 
  </tr>
  

<!--  
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
	     <option value="0">总公司</option>
		 <option value="1">分公司</option>
	 </select>
     <label>所属渠道：</label> <select name="p_id" id="p_id"></select> 
   
 
  </td> 
  </tr>
-->  
  
  
     <tr>
    <td>
    
     
     
    省、市、区：
    
    </td>
    <td>
       
	省份:<select  name="province" id="province" style="width: 150px;" onchange="SwapTxt()"> 
            <option  value ="">请选择</option>  
            {foreach from=$region.province item=province}
            <option  value ="{$province.region_sn}">{$province.region_name}</option>    
            {/foreach}
            </select>
            
            城市:<select  name="city" id="city" style="width: 150px;" onchange="SwapTxt()"> 
            <option  value ="">请选择</option> 
            {foreach from=$region.city item=city}
            <option  value ="{$city.region_sn}">{$city.region_name}</option>    
            {/foreach}
            </select>
            地区:<select  name="district" id="district" style="width: 150px;" onchange="SwapTxt()"> 
            <option  value ="">请选择</option> 
            {foreach from=$region.district item=district}
            <option  value ="{$district.region_sn}">{$district.region_name}</option>    
            {/foreach}
            </select>
    
   
    </td>
  </tr>
  
  <tr>
    <td>详细地址：</td>
    <td><input type="text"  value="" id="business_address" name=" business_address" size="50" onkeyup="SwapTxt()">
    </td>
  </tr>
  
    <tr>
    <td>联系人：</td>
    <td><input type="text"  value="" id="business_lxr" name=" business_lxr" >
    </td>
  </tr>
  
      <tr>
    <td>联系电话：</td>
    <td><input type="text"  value="" id="business_tel" name=" business_tel" >
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
   
   <tr><td >定位：</td><td>
<div id="map" style="width:800px;height:500px;"></div>
<input type="text" value = "118.628209" name="lbsjd" id="lbsjd" onfocus="this.blur()" />
<input type="text" value = "24.873773" name="lbswd" id="lbswd" onfocus="this.blur()"/></td></tr>
  
  
 <!-- 
    	<tr>
      <td>商家主图:</td>
      <td>
     <textarea id="editor_id"name="bz1"   style="width:620px;height:310px;">
    </textarea>
    </td></tr>
    <tr>
      <td>商家描述:</td>
      <td>
      <textarea id="editor_id2"name="bz2"   style="width:620px;height:310px;">
    </textarea>
    </td></tr>
  -->
  
  
  
  
  

  <tr>
  <tr><td colspan="2"  style="text-align: center;"><input  id="queding" type="submit" value="确定"/>&nbsp;<input  type="button" value="取消" id="quxiao" onclick="location='business.php'"/></td></tr>
</table>
</form>

{/if}

{if $fall==i_staus}
<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>添加商家</b></td></tr>
 <tr><td>{$val}<a href="business.php">返回</a></td></tr>
</table>
{/if}

{if $fall==view}
<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>商家二维码</b></td></tr>
 <tr><td><img src="upload/cj_qrcode/business/{$val}"><a href="business.php">返回</a></td></tr>
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

$("#business_sn").focus();
       $("#queding").click(function(){
           if(jQuery.trim($("#business_sn").attr('value'))=='' )
        {
            
            $("#business_sn").focus();
            return false;
        }
         else if(jQuery.trim($("#business_name").attr('value'))=='' )
         {
             
            $("#business_name").focus();
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
             
              htmlobj=$.ajax({url:"business.php?act=ed_status&qiyong="+encodeURI(encodeURI($(this).attr("name"))),async:false});
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
             
              htmlobj=$.ajax({url:"business.php?act=ed_status&jinyong="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
          $("img[id='delete']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("删除"+$(this).attr("name"))){
             
              htmlobj=$.ajax({url:"business.php?act=ed_status&delete="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        
        
        $("img[id='edit']").each(function (){
            
           $(this).click(function (){
        
           window.location='business.php?act=e_business&edit='+encodeURI(encodeURI($(this).attr("name")));
           
           
        })
        })
		
		
//		 $("#sc_code").click(function (){
//            if(confirm("确认批量生成？")){
//             htmlobj=$.ajax({url:"business.php?act=sc_code",async:false});
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



$("#province").val("{$business.province}");
 $("#city").val("{$business.city}");
 $("#district").val("{$business.district}");


$('#province').change(function (){
    $('#city').val(""); 
    $('#district').val(""); 
     $('#address').val($("#province").find("option:selected").text()+" "); 
     
     
       //省选择清空市，市选择清空区
      htmlobj=$.ajax({
        url:"business.php?act=get_city&province="+encodeURI(encodeURI($("#province").val()))
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
     
         htmlobj2=$.ajax({url:"business.php?act=get_district&city="+encodeURI(encodeURI($("#city").val())),async:false,dataType: 'json'}); 
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
</script>