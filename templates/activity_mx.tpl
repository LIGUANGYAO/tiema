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
margin-top:5px;
  
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
	
  <form name="myform" method="post" action="activity.php?act=post" enctype="multipart/form-data">  
	
    <ul class="tabbtn" id="move-animate-left">
		<li class="current" id="sub1"><a >活动信息</a></li>
	
	
	</ul><!--tabbtn end-->

   
	<div class="tabcon" id="leftcon"  >
    <div  id="m1"><table class="table" width="100%" border="0">

  <tr><td>代码:</td><td><input disabled="true"  type="text" value="{$activity_mx.activity_sn}" /><input name="activity_sn" id="activity_sn"  type="hidden" value="{$activity_mx.activity_sn}" /><a style="color:red;">*</a></td>
  <td width="150">开始时间</td><td><input  class="start_time" value="{$activity_mx.start_time}" name="start_time" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this);" readonly="readonly" /><a style="color:red;">*</a></td>
  </tr>

  
 <tr><td>名称:</td><td><input name="activity_name"  id="activity_name" type="text" value="{$activity_mx.activity_name}" /><a style="color:red;">*</a></td>
 <td width="150">结束时间</td><td><input    class="end_time" value="{$activity_mx.end_time}" name="end_time" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this);" readonly="readonly" /><a style="color:red;">*</a></td></tr>
  
 
  <tr><td>优先级:</td><td colspan="3"><input name="sort_no"  id="sort_no" type="text" value="{$activity_mx.sort_no}" /></td></tr>
  <tr>
  <td>参与次数:</td><td ><input name="hd_number"  id="hd_number" type="text" value="{$activity_mx.hd_number}" />次/天</td>
  <td>奖券过期时间:</td><td ><input name="limit_time"  id="limit_time" type="text" value="{$activity_mx.limit_time}" />天</td>
  </tr>
  <tr><td  colspan="4"><input type="checkbox" />与其它活动重叠(暂无效)</td></tr>
  <tr><td>大转盘地址</td><td  colspan="3"><textarea style="width:800px">{$url_this}</textarea></tr>
 <tr><td  colspan="4">  <input type="radio" name="ac_lx[]" id="dazhuanpan" value="1" />大转盘&nbsp;&nbsp;
  <input type="radio" name="ac_lx[]"   id="zadan" value="2" />砸金蛋&nbsp;&nbsp;
  <input type="radio" name="ac_lx[]"   id="guaguaka" value="3" />刮刮卡&nbsp;&nbsp;
  <input type="radio" name="ac_lx[]"   id="bobing" value="4" />博饼&nbsp;&nbsp;
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
  
  
  <tr id="ac_id2" style="display:none" ><td  colspan="4" >暂未开放</tr>
</table>
    
    
    
    </div>
	
    <div align="center" style="padding: 10px;"><input  type="submit"  id="btn_queren2" value="确认"  class="bttnn"/>&nbsp;<input  type="button" onclick="location='activity.php'" value="返回" class="bttnn"/></div>
	</div>
    
    
    
	</form>


	
</div><!--tabbox end-->







{/if}
	
{if $fall==post}
<div class="demo">	
	


	
    <table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>修改成功</b></td></tr>
 <tr><td>修改成功<a href="activity.php">返回</a></td></tr>
</table>

	
    


	
</div><!--tabbox end-->

{/if}
{if $fall==add_activity_list}
<div class="demo">	
	

	
    <ul class="tabbtn" id="move-animate-left">
		<li class="current" id="sub1"><a >活动信息</a></li>
	
	
	</ul><!--tabbtn end-->

 
	<div class="tabcon" id="leftcon"  >
    <div  id="m1"><table class="table" width="100%" border="0">
    <form name="myform" method="post" action="activity.php?act=post_add" enctype="multipart/form-data">  
  <tr><td>代码:</td><td><input name="activity_sn" id="activity_sn"  type="text" /><a style="color:red;">*</a></td>
  <td width="150">开始时间</td><td><input  class="start_time" value="{$yuyue_mx.yuyue_time_1}" name="start_time" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this);" readonly="readonly" /><a style="color:red;">*</a></td>
  </tr>
   <tr><td>名称:</td><td><input name="activity_name"  id="activity_name" type="text" /><a style="color:red;">*</a></td><td width="150">结束时间</td><td><input    class="end_time" value="{$yuyue_mx.yuyue_time_1}" name="end_time" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this);" readonly="readonly" /><a style="color:red;">*</a></td></tr>
   
     <tr><td>优先级:</td><td colspan="3"><input name="sort_no"  id="sort_no" type="text" value="0" /></td></tr>
    <tr>
	<td>参与次数:</td><td ><input name="hd_number"  id="hd_number" type="text" value="1" />次/天</td>
	  <td>奖券过期时间:</td><td ><input name="limit_time"  id="limit_time" type="text" value="30" />天</td>
	</tr>
    <tr><td  colspan="4"><input type="checkbox" />与其它活动重叠(暂无效)</td></tr>
<tr><td  colspan="4">  <input type="radio" name="ac_lx[]" id="dazhuanpan" value="1" />大转盘&nbsp;&nbsp;
   <input type="radio" name="ac_lx[]"   id="zadan" value="2" />砸金蛋&nbsp;&nbsp;
  <input type="radio" name="ac_lx[]"   id="guaguaka" value="3" />刮刮卡&nbsp;&nbsp;
  <input type="radio" name="ac_lx[]"   id="bobing" value="4" />博饼&nbsp;&nbsp;
</tr>
 <tr class="ac_id"  ><td  colspan="1">
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
  <tr id="ac_id2" style="display:none" ><td  colspan="4" >暂未开放</tr>

</table>
    
    
    
    </div>

    <div align="center" style="padding: 10px;"><input  type="submit"  id="btn_queren2" value="确认" class="bttnn"/>&nbsp;<input  type="button" onclick="location='activity.php'" value="返回" class="bttnn"/></div>
	</div>
    
    
    
	</form>


	
</div><!--tabbox end-->





{/if}



{if $fall==fs}
<div class="demo">	
	



	
    <table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>代码已存在</b></td></tr>
 <tr><td>代码已存在<a href="activity.php">返回</a></td></tr>
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
	   $("#m2").hide();
       $("#m1").show();
	})
    $("#sub2").click(function (){
	    $("#m1").hide();
       $("#m2").show();
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
             
              htmlobj=$.ajax({url:"activity.php?act=delete&img_code="+encodeURI(encodeURI($(this).attr("title"))),async:false});
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
             
              htmlobj=$.ajax({url:"activity.php?act=img_xs&img_code="+encodeURI(encodeURI($(this).attr("title")))+"&alt="+$(this).attr("alt"),async:false});
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
             
              htmlobj=$.ajax({url:"activity.php?act=img_xs&img_code="+encodeURI(encodeURI($(this).attr("title")))+"&alt="+$(this).attr("alt"),async:false});
              alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        $("#type").val({$activity_mx.type});
      
      
      //大转盘活动
    //  $("#dazhuanpan").change(function (){
//        $(".ac_id").show();
//        $("#ac_id2").hide();
//      });
//      $("#guaguaka").change(function (){
//        $("#ac_id2").show();
//        $(".ac_id").hide();
//      });
 
      if({$activity_mx.ac_lx}==1)
      {
        $("#dazhuanpan").attr("checked",'checked');
         $("input:radio[name=ac_lx]").val("{$activity_mx.ac_lx}");
         //$("#dazhuanpan").change();
      }
      else if ({$activity_mx.ac_lx}==2)
      {
         $("#zadan").attr("checked",'checked');
         $("input:radio[name=ac_lx]").val("{$activity_mx.ac_lx}");
         //$("#zadan").change();
      }
        else if ({$activity_mx.ac_lx}==3)
      {
         $("#guaguaka").attr("checked",'checked');
         $("input:radio[name=ac_lx]").val("{$activity_mx.ac_lx}");
         //$("#guaguaka").change();
      }
      else if ({$activity_mx.ac_lx}==4)
      {
         $("#bobing").attr("checked",'checked');
         $("input:radio[name=ac_lx]").val("{$activity_mx.ac_lx}");
         //$("#guaguaka").change();
      }

     
  
        
      
        
</script>
{/literal}