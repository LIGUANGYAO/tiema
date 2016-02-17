<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>活动</title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/Calendar3.js"></script>
<script type="text/javascript" src="js/jquery.tabso_yeso.js"></script>
</head>
<style type="text/css">
<!--

.demo {
	width:98%;
margin-top:-10px;
  
}
.demo h2 {
	font-size:16px;
	height:44px;
	color:#3366cc;
	margin-top:0px;
}
.demo dl dt {
	font-size:14px;
	color:#ff6600;
	margin-top:0px;
	font-weight:800;
}
.demo dl dt, .demo dl dd {
	line-height:22px;
}
	.tabbtn {
	list-style-type:none;
	height:30px;
	background:url(images/tabbg.gif) repeat-x;
	border-left:solid 1px #ddd;
	border-right:solid 1px #ddd;
}
.tabbtn li {
	float:left;
	position:relative;
	margin:0 0 0 -1px;
}
.tabbtn li a {
	display:block;
	float:left;
	height:30px;
	line-height:30px;
	overflow:hidden;
	width:108px;
	text-align:center;
	font-size:12px;
	cursor:pointer;
}
.tabbtn li.current {
	border-left:solid 1px #d5d5d5;
	border-right:solid 1px #d5d5d5;
	border-top:solid 1px #c5c5c5;
}
.tabbtn li.current a {
	border-top:solid 2px #ff6600;
	height:27px;
	line-height:27px;
	background:#fff;
	color:#3366cc;
	font-weight:800;
}
/* tabcon */
.tabcon {
	border-width:0 1px 1px 1px;
	border-color:#ddd;
	border-style:solid;
	position:relative;/*必要元素*/
	

  
}
.tabcon .subbox {
	position:absolute;/*必要元素*/
	left:0;
	top:0;
}
.tabcon .sublist {
	padding:0px 0px;

}

  .table_img {   
          border: 1px solid #B1CDE3;   
            padding:0;    
           margin:0 auto;   
            border-collapse: collapse;   
       }   
         
    .table_img   td {   
            border: 1px solid #B1CDE3;   
           background: #fff;   
            font-size:12px;   
           padding: 3px 3px 3px 8px;   
          color: #4f6b72;   
        }   
						.bttnn{position:relative;overflow: hidden;margin-right:4px;display:inline-block; padding:4px;*display:inline;font-size:12px;line-height:14px;color:#fff;text-align:center;vertical-align:middle;cursor:pointer;background-color:#679ef0;border:1px solid #cccccc;border-color:#e6e6e6 #e6e6e6 #bfbfbf;border-bottom-color:#b3b3b3;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;}   
-->
</style>
<body  style=" margin-top: 0px;margin-left: 5px;  padding-top: 0px;"> 
<!--
<div id="dataLoad" style="display:block">
   <table width="100%" height="100%" border="0" align="center" >
    <tr height="50%"><td align="center">&nbsp;</td></tr>
    `
    <tr><td align="center">数据载入中，请稍后......</td></tr>
    <tr height="50%"><td align="center">&nbsp;</td></tr>
   </table>
  </div>
-->
{if $fall==edit}
<div class="demo">	
<ul class="tabbtn" id="move-animate-left">
		<li class="current" id="sub1"><a >活动信息</a></li>
		<li id="sub2"><a >商品设置</a></li>
		<li id="sub3"><a >入围商品</a></li>
	</ul><!--tabbtn end-->
	<div class="tabcon" id="leftcon"  >
	<div  id="m1">
	<form name="myform" method="post" action="wx_zan.php?act=post" enctype="multipart/form-data">  
	<table class="table" width="100%" border="0">

  <tr><td>代码:</td><td><input disabled="true"  type="text" value="{$activity_mx.activity_sn}" /><input name="activity_sn" id="activity_sn"  type="hidden" value="{$activity_mx.activity_sn}" /><a style="color:red;">*</a></td>
  <td width="150">开始时间</td><td><input  class="start_time" value="{$activity_mx.start_time}" name="start_time" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this);" readonly="readonly" /><a style="color:red;">*</a></td>
  </tr>

  
 <tr><td>名称:</td><td><input name="activity_name"  id="activity_name" type="text" value="{$activity_mx.activity_name}" /><a style="color:red;">*</a></td>
 <td width="150">结束时间</td><td><input    class="end_time" value="{$activity_mx.end_time}" name="end_time" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this);" readonly="readonly" /><a style="color:red;">*</a></td></tr>
  
 
  <tr><td>优先级:</td><td colspan="3"><input name="sort_no"  id="sort_no" type="text" value="{$activity_mx.sort_no}" /></td></tr>
  <tr><td>点赞次数:</td><td colspan="3"><input name="hd_number"  id="hd_number" type="text" value="{$activity_mx.hd_number}" />次</td></tr>
  	    <tr>
      <td>备注:</td>
      <td colspan="3"><textarea id="activity_note_1" name="activity_note_1"   style="width:520px;height:110px;">{$activity_mx.activity_note_1}</textarea></td>
    </tr>
  <tr><td  colspan="4"><input type="checkbox" />与其它活动重叠(暂无效)</td></tr>
  <tr><td>地址</td>
  <td  colspan="3"><textarea style="width:800px">{$url_this}</textarea></tr>
 <tr><td  colspan="4"><input type="radio" name="ac_lx[]"   id="dianzan" value="4" checked>点赞&nbsp;&nbsp;</td>
</tr>
 <tr class="ac_id" ><td  colspan="1">
中奖人数
  
  </td>
  <td  colspan="1">
概率
  
  </td>
   <td  colspan="2">
奖品描述
  
  </td>
  </tr>
  <tr class="ac_id"  ><td  colspan="1">
  一等奖:<input  type="text" name="prize_sl[]" value="{$prize.prize1_sl}"/><br />
  二等奖:<input  type="text"  name="prize_sl[]" value="{$prize.prize2_sl}"/><br />
  三等奖:<input  type="text"  name="prize_sl[]" value="{$prize.prize3_sl}"/><br />
  
  </td>
  <td  colspan="1">
  <input  type="text"  name="prize_gl[]" value="{$prize.prize1_gl}"/>%<br />
  <input  type="text"  name="prize_gl[]" value="{$prize.prize2_gl}"/>%<br />
  <input  type="text"   name="prize_gl[]" value="{$prize.prize3_gl}"/>%<br />
  
  </td>
  
    <td  colspan="2">
  <input  type="text"  name="prize_jpms[]" value="{$prize.prize1_jpms}"/><br />
  <input  type="text"  name="prize_jpms[]" value="{$prize.prize2_jpms}"/><br />
  <input  type="text"   name="prize_jpms[]" value="{$prize.prize3_jpms}"/><br />
  
  </td>
  </tr>

</table>
   
	<div align="center" style="padding: 10px;"><input  type="submit"  id="btn_queren2" value="确认"  class="bttnn"/>&nbsp;<input  type="button" onclick="location='wx_zan.php'" value="返回" class="bttnn"/></div>
	</form>
	  </div>
	 </div>
	 
	 

	 
<div style="display:none;" id="m2">
<div id="zdxsdiv" style="width: 100%;height: 300px; background-color: #fff;" >
<table  width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="table">
  <tr style="background-color:#ffffff;">
	<td colspan="3" style="padding-left:5px; padding-bottom:5px;">
	  <img src="images/icon_search.gif" width="16" height="16" border="0" alt="search" />商品
	  <input type="text"  id="b_ysss" name="color_keyword"/>
	  <input type="button" value=" 搜索 " id="ysss" class="bttnn" />            
	</td>
  </tr>

  <tr style="background-color: #3187CE; height: 25px;">
            <th align="center" style="font-weight:bold;">可用字段</th>
            <th align="center" style="font-weight:bold;">操作</th>
            <th align="center" style="font-weight:bold;">使用字段</th>
   </tr>
  <tr>
    
    <td>
        <div style="float:left">
        <select name="select1[]" class="sortable" multiple="multiple" id="select1" style="width:540px;height:300px; float:left; border:1px #A0A0A4 outset; padding:4px; "></select>
        </div>
        </td>
        <td>
        <div style="float:left"> 
          <span id="add">
          <input type="button" class="bttnn" value=">"/>
          </span><br />
          <span id="add_all">
          <input type="button" class="bttnn" value=">>"/>
          </span> <br />
          <span id="remove">
          <input type="button" class="bttnn" value="<"/>
          </span><br />
          <span id="remove_all">
          <input type="button" class="bttnn" value="<<"/>
          </span>  </div>
         
          </td>
          <td>
        <div style="float:left">
       <select name="select2[]" multiple="multiple" id="select2" style="width:540px;height:300px; float:lfet;border:1px #A0A0A4 outset; padding:4px;">     {foreach from=$goods_list item=goods_list}
            <option id="select2_2" value="{$goods_list.goods_id}">{$goods_list.goods_sn}({$goods_list.goods_name})</option>
           {/foreach}
		  </select>
        </div>
      </td>
  </tr>
  <tr><td colspan="3">
          <div  style="text-align: center;"> 
		  {if $activity_mx.sh==0}
          <span id="zd_queren"><input type="submit" class="bttnn" id="form_zd" value="确认"/></span> 
          <span id="zd_quxiao"><input type="button" class="bttnn" value="取消"  onclick="location='wx_zan.php'"/></span>
		  <span id="zd_queren"><input type="submit" class="bttnn" id="shenhe" value="审核"/></span> 
		  {else}
		  <span id="zd_queren"> <input type="button" class="bttnn" value="已审" disabled/></span> 
		  {/if}
		  
		  </div>
		  </td></tr>
</table>
</div>
</div>
	
<div style="display:none;" id="m3">
<div id="zdxsdiv" style="width:100%;height:300px; background-color:#fff;">

<table  width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="table">
  <tr style="background-color:#ffffff;">
	<td colspan="3" style="padding-left:5px; padding-bottom:5px;">
	  <img src="images/icon_search.gif" width="16" height="16" border="0" alt="search" />搜索商品
	  <input type="text"  id="b_yssss" name="color_keyword"/>
	  <input type="button" value=" 搜索 " id="yssss" class="bttnn" />若无数据，请先审核点赞商品列表           
	</td>
  </tr>

  <tr style="background-color: #3187CE; height: 25px;">
            <th align="center" style="font-weight:bold;">可用字段</th>
            <th align="center" style="font-weight:bold;">操作</th>
            <th align="center" style="font-weight:bold;">使用字段</th>
   </tr>
  <tr>
    
    <td>
        <div style="float:left">
        <select name="select3[]" class="sortable" multiple="multiple" id="select3" style="width:540px;height:300px; float:left; border:1px #A0A0A4 outset; padding:4px; "></select>
        </div>
        </td>
        <td>
        <div style="float:left"> 
          <span id="add1">
          <input type="button" class="bttnn" value=">"/>
          </span><br />
          <span id="add_all1">
          <input type="button" class="bttnn" value=">>"/>
          </span> <br />
          <span id="remove1">
          <input type="button" class="bttnn" value="<"/>
          </span><br />
          <span id="remove_all1">
          <input type="button" class="bttnn" value="<<"/>
          </span>  </div>
         
          </td>
          <td>
        <div style="float:left">
       <select name="select4[]" multiple="multiple"  id="select4" style="width:540px;height:300px; float:lfet;border:1px #A0A0A4 outset; padding:4px;">        {foreach from=$goods_choose_list item=goods_choose_list}
            <option id="select4_2" value="{$goods_choose_list.goods_id}">{$goods_choose_list.goods_sn}({$goods_choose_list.goods_name})</option>
           {/foreach}
		  
          </select>
        </div>
      </td>
  </tr>
  <tr><td colspan="3">
          <div  style="text-align: center;"> 
		   {if $activity_mx.sh==1}
          <span id="zd_queren"><input type="button" class="bttnn" id="form_zd2" value="确认"/></span> 
          <span id="zd_quxiao"><input type="button" class="bttnn" value="取消"  onclick="location='wx_zan.php'"/></span>
		  {else}
		  <span id="zd_queren">请先审核点赞商品列表</span>
		  {/if}
		  </div>
		  </td></tr>
</table>





 

</div>
</div>
	 
	 
	 
</div><!--tabbox end-->
<script type="text/javascript">

$("#ysss").click(function ()
        {
           if($("#b_ysss").val()=='')
          {
            $("#b_ysss").val("all");
          }
           htmlobj=$.ajax({url:"wx_zan.php?act=ysss&activity_sn={$activity_mx.activity_sn}&keyword="+encodeURI(encodeURI($("#b_ysss").val())),async:false,dataType: 'json'});
           $("#select1").html("");
           json = $.parseJSON(htmlobj.responseText); 
           $.each(json, function (i, o) {
           $("#select1").append("<option id='select1_1' name="+ o.goods_sn+" value="+o.id+" >"+ o.goods_sn +"(" + o.goods_name +")</option>" );});
           $("#b_ysss").val("");
         })


       $('#form_zd').click(function ()
       {
       var aArray = {};//定义一个数组
       var st='';
            $("#select2 option").each(function (){
            aArray[$(this).index()]=$(this).val();
            st +=aArray[$(this).index()]+',';
            })
            // alert(st);
           //alert(aArray[0]);
           htmlobj=$.ajax({url:"wx_zan.php?act=i_goods_list&activity_sn={$activity_mx.activity_sn}&st="+st,type:"POST",async:false});
		   setTimeout('alert("添加成功")',1000);
		   //window.location.href="wx_zan.php";
        })
		
		$("#shenhe").click(function ()
        {
            if(confirm("是否审核")){
            htmlobj=$.ajax({url:"wx_zan.php?act=shenhe&activity_sn={$activity_mx.activity_sn}&alt=1",async:false});
			alert("审核成功");
			window.location.href="wx_zan.php";
            }
			else 
			return false;
		   
			
			
			
			
         })
		

		
		
            $('#add').click(function() {
           //获取选中的选项，删除并追加给对方
            $('#select1 option:selected').appendTo('#select2');
  
            });
    //移到左边
    $('#remove').click(function() {
        $('#select2 option:selected').appendTo('#select1');
    });
    //全部移到右边
    $('#add_all').click(function() {
        //获取全部的选项,删除并追加给对方
        $('#select1 option').appendTo('#select2');
    });
    //全部移到左边
    $('#remove_all').click(function() {
        $('#select2 option').appendTo('#select1');
    });
    //双击选项
    $('#select1').dblclick(function(){ //绑定双击事件
        //获取全部的选项,删除并追加给对方
    $("option:selected",this).appendTo('#select2'); //追加给对方
    });
    //双击选项
    $('#select2').dblclick(function(){
    $("option:selected",this).appendTo('#select1');
    });
/////////////////////////////////////////////////////////////////////////////
    $("#yssss").click(function ()
        {
           if($("#b_yssss").val()=='')
          {
            $("#b_yssss").val("all");
          }
           htmlobj=$.ajax({url:"wx_zan.php?act=yssss&activity_sn={$activity_mx.activity_sn}&keyword="+encodeURI(encodeURI($("#b_yssss").val())),async:false,dataType: 'json'});
           $("#select3").html("");
           json = $.parseJSON(htmlobj.responseText); 
           $.each(json, function (i, o) {
           $("#select3").append("<option id='select3_1' name="+ o.goods_sn+" value="+o.goods_id+" >"+ o.goods_sn +"(" + o.goods_name +")</option>" );});
		   
           $("#b_yssss").val("");
         })


      
    //移到左边
    $('#remove1').click(function() {
     $('#select4 option:selected').appendTo('#select3');
    });
    //全部移到右边
    $('#add_all1').click(function() {
        //获取全部的选项,删除并追加给对方
    $('#select3 option').appendTo('#select4');
    });
    //全部移到左边
    $('#remove_all1').click(function() {
        $('#select4 option').appendTo('#select3');
    });
    //双击选项
    $('#select3').dblclick(function(){ //绑定双击事件
    //获取全部的选项,删除并追加给对方
    $("option:selected",this).appendTo('#select4'); //追加给对方
    });
    //双击选项
    $('#select4').dblclick(function(){
    $("option:selected",this).appendTo('#select3');
    });	
	
	 $('#form_zd2').click(function ()
       {
       var aArray = {};//定义一个数组
       var st='';   
            $("#select4 option").each(function (){
            aArray[$(this).index()]=$(this).val();
            st +=aArray[$(this).index()]+',';
            })
             //alert(st);
           //alert(aArray[0]);
           htmlobj=$.ajax({url:"wx_zan.php?act=u_goods_list&activity_sn={$activity_mx.activity_sn}&st="+st,type:"POST",async:false});
		   window.location.href="wx_zan.php";
        })
            $('#add1').click(function() {
           //获取选中的选项，删除并追加给对方
            $('#select3 option:selected').appendTo('#select4');
  
            });
</script>   


{/if}
	
{if $fall==post}
<div class="demo">	
 <table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>修改成功</b></td></tr>
 <tr><td>修改成功<a href="wx_zan.php">返回</a></td></tr>
</table>


	
</div><!--tabbox end-->

{/if}

{if $fall==add_activity_list}
<div class="demo">	
	 <ul class="tabbtn" id="move-animate-left">
		<li class="current" id="sub1"><a >活动信息</a></li>
	</ul><!--tabbtn end-->

  <form name="myform" method="post" action="wx_zan.php?act=post_add" enctype="multipart/form-data">  
	<div class="tabcon" id="leftcon"  >
    <div  id="m1"><table class="table" width="100%" border="0">
   
  <tr><td>代码:</td><td><input name="activity_sn" id="activity_sn"  type="text" /><a style="color:red;">*</a></td>
  <td width="150">开始时间</td><td><input  class="start_time" value="{$yuyue_mx.yuyue_time_1}" name="start_time" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this);" readonly="readonly" /><a style="color:red;">*</a></td>
  </tr>
   <tr><td>名称:</td><td><input name="activity_name"  id="activity_name" type="text" /><a style="color:red;">*</a></td><td width="150">结束时间</td><td><input    class="end_time" value="{$yuyue_mx.yuyue_time_1}" name="end_time" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this);" readonly="readonly" /><a style="color:red;">*</a></td></tr>
   
     <tr><td>优先级:</td><td colspan="3"><input name="sort_no"  id="sort_no" type="text" value="0" /></td></tr>
    <tr>
      <td>点赞次数:</td>
      <td colspan="3"><input name="hd_number"  id="hd_number" type="text" value="1" />
      次</td>
    </tr>
	
	    <tr>
      <td>备注:</td>
      <td colspan="3"><textarea id="activity_note_1" name="activity_note_1"   style="width:520px;height:110px;"></textarea></td>
    </tr>
	
	
    <tr><td  colspan="4"><input type="checkbox" />与其它活动重叠(暂无效)</td></tr>
<tr><td  colspan="4"><input type="radio" name="ac_lx[]"   id="dianzan" value="4" checked>点赞&nbsp;&nbsp;</td>
</tr>
 <tr class="ac_id"  style="display:none" >
 <td  colspan="1">
中奖人数
  </td>
  <td  colspan="1">
概率
  </td>
  <td  colspan="2">
奖品描述
  </td>
  </tr>
  <tr class="ac_id"  ><td  colspan="1">
  一等奖:<input  type="text" name="prize_sl[]" value="0"/><br />
  二等奖:<input  type="text"  name="prize_sl[]" value="0"/><br />
  三等奖:<input  type="text"  name="prize_sl[]" value="0"/><br />
  
  </td>
  <td  colspan="1">
  <input  type="text"  name="prize_gl[]" value="0.12"/>%<br />
  <input  type="text"  name="prize_gl[]" value="3"/>%<br />
  <input  type="text"   name="prize_gl[]" value="12"/>%<br />
  
  </td>
  
    <td  colspan="2">
  <input  type="text"  name="prize_jpms[]" value="礼品1"/><br />
  <input  type="text"  name="prize_jpms[]" value="礼品2"/><br />
  <input  type="text"   name="prize_jpms[]" value="礼品3"/><br />
  
  </td>

  </tr>

</table>
    </div>
    <div align="center" style="padding: 10px;"><input  type="submit"  id="btn_queren2" value="确认" class="bttnn"/>&nbsp;<input  type="button" onclick="location='wx_zan.php'" value="返回" class="bttnn"/></div>
	</div>
    </form>
	</div><!--tabbox end-->
{/if}



{if $fall==fs}
<div class="demo">	
<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>代码已存在</b></td></tr>
 <tr><td>代码已存在<a href="wx_zan.php">返回</a></td></tr>
</table>


	
</div><!--tabbox end-->
{/if}

</body>  
</html>
{literal}
<script type="text/javascript">
        
        $("#activity_sn").focus();
       $("#btn_queren2").click(function(){
           if(jQuery.trim($("#activity_sn").attr('value'))=='')
        {
            
            $("#activity_sn").focus();
            
            return false;
        }
        else if(jQuery.trim($("#activity_name").attr('value'))=='')
        {
            $("#activity_name").focus();
            return false;
        }
         else if(jQuery.trim($(".start_time").attr('value'))=='')
        {
            $(".start_time").focus();
            alert("开始时间不能为空！");
            return false;
        }
         else if(jQuery.trim($(".end_time").attr('value'))=='')
        {
            $(".end_time").focus();
            alert("结束时间不能为空！");
            return false;
        }
        else if($(".start_time").val()>=$(".end_time").val())
        {
            alert("开始时间不能晚于结束时间！");
            return false;
        }
		  else if(jQuery.trim($("#hd_number").attr('value'))=='')
        {
            $("#hd_number").focus();
            alert("次数不能为空！");
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
   

    
    var i=2;
   $("#add_images").click(function (){
        
        
        $("#m2").append('&nbsp;图片'+i+':<input type="file" name="pic'+i+'"/>  &nbsp;<br />');
        i++;

        //alert(1);
   })
	$("#sub1").click(function (){
	   $("#m3").hide();
	   $("#m2").hide();
       $("#m1").show();
	})
    $("#sub2").click(function (){
	    $("#m1").hide();
        $("#m2").show();
		$("#m3").hide();
	})
	$("#sub3").click(function (){
	    $("#m1").hide();
        $("#m2").hide();
		$("#m3").show();
	})
	
	
	
	//上下滑动选项卡切换
	$("#move-animate-top").tabso({
		cntSelect:"#topcon",
		tabEvent:"mouseover",
		tabStyle:"move-animate",
		direction : "top"
	});
	
	//左右滑动选项卡切换
	$("#move-animate-left").tabso({
		cntSelect:"#leftcon",
		tabEvent:"click",
		tabStyle:"move-animate",
		direction : "left"
	});
	
	//淡隐淡现选项卡切换
	$("#fadetab").tabso({
		cntSelect:"#fadecon",
		tabEvent:"mouseover",
		tabStyle:"fade"
	});
	
	//默认选项卡切换
	$("#normaltab").tabso({
		cntSelect:"#normalcon",
		tabEvent:"mouseover",
		tabStyle:"normal"
	});
	
      $("img[id='img_mx']").each(function (){
            
           $(this).dblclick(function (){
           //alert($(this).attr("name"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
          $("img[id='delete_z_sn']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("是否删除图片"+$(this).attr("title"))){
             
              htmlobj=$.ajax({url:"wx_zan.php?act=delete&img_code="+encodeURI(encodeURI($(this).attr("title"))),async:false});
              alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
            $("img[id='img_jy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("title")+"图片？")){
             
              htmlobj=$.ajax({url:"wx_zan.php?act=img_xs&img_code="+encodeURI(encodeURI($(this).attr("title")))+"&alt="+$(this).attr("alt"),async:false});
              alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
         $("img[id='img_xs']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("显示"+$(this).attr("title")+"图片？")){
             
              htmlobj=$.ajax({url:"wx_zan.php?act=img_xs&img_code="+encodeURI(encodeURI($(this).attr("title")))+"&alt="+$(this).attr("alt"),async:false});
              alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
      

</script>
{/literal}