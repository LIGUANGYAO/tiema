<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员中心</title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
a{color:#333;text-decoration:none;}
a:hover{color:#990000;text-decoration:underline;}
/* choose */
.choose{width:260px;margin:100px auto 0 auto;border:solid 1px #ddd;padding:15px 30px 30px 30px;}
.choosetext{height:24px;padding:20px 0;font-size:14px;}
.choosebox{padding:10px 0 35px 0;}
.choosebox li{float:left;margin-right:10px;display:inline;}
.choosebox li a{float:left;background:#fff;font-size:14px;border:1px solid #ccc;height:14px;line-height:14px;padding:4px 12px; display:block;}
.choosebox li a.current{background:url(1images/right-icon.gif) no-repeat 100% 100%;border:1px solid #A10000;}
.choosebox li input{display:none;}
.choose .btn-img{width:160px;height:50px;overflow:hidden;background:url(images/cart.gif) no-repeat;cursor:pointer;border:0;}
.choose .btn-img span{display:block;font-size:18px;font-weight:800;color:#fff;font-family:"微软雅黑","宋体";padding:0 0 0 50px;line-height:50px;}
-->
</style>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>

</head>

<body>

<div class="container">
  <div class="content">
  

 
   <div class="botable">
{if $fall==1}

<form action="attention.php?act=post" method="POST">

   <table class="table" width="100%" border="0">
   
   <tr>
   <th  colspan="2">关注时回复内容</th>
  
   </tr>
<tbody  id="table_t">
  <tr>
   <td style="width:170px">回复类型</td><td > 
        <select  name="type" id="type" style="width: 200px;"> 
            <option value="">请选择</option>
            <option value="text">文本</option>
            <option value="imgtext">图文</option>
       </select></td>  
  </tr>
    <tr>
   <td style="width:170px">模板</td><td > 
        <select  name="type2" id="type2" style="width: 200px;"> 
            <option value="1">请选择</option>
      
       </select></td>  
  </tr>
    <tr>
   <td style="width:170px" colspan="2">&nbsp;<input  type="submit" value="确认"/>&nbsp;</td>  
  </tr>
  <!--
   <tr>
   <td style="width:170px">回复类型</td>
   <td >
  <div class="choosebox">
			<ul class="clearfix">
			     <li>
					<input type="radio" name="name" value="S" id="" />
					<a href="javascript:void(0);" class="size_radioToggle"><span class="value">文本</span></a>
				</li>
				<li>
					<input type="radio" name="name" value="M" id="" />
					<a href="javascript:void(0);" class="size_radioToggle"><span class="value">图文</span></a>
				</li>
				
			</ul>
		</div>
   </td>  
  </tr>
  <tr>
   <td style="width:170px">选择</td><td ></td>  
  </tr>
  -->
</tbody>

</table>

</form>



{/if}
{if $fall==i_staus}
<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>修改关注回复</b></td></tr>
 <tr><td>{$val}<a href="attention.php">返回</a></td></tr>
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
   
        
        //尺码
    
	$('.choosebox li a').click(function(){
		var thisToggle = $(this).is('.size_radioToggle') ? $(this) : $(this).prev();
		var checkBox = thisToggle.prev();
		checkBox.trigger('click');
		$('.size_radioToggle').removeClass('current');
		thisToggle.addClass('current');
		return false;
	});		


$(".choosebox li a").click(function(){
	var text = $(this).html();
	$(".choosetext span").html(text);
	$("#result").html("" + getSelectedValue("dress-size"));
});
			
function getSelectedValue(id){
	return 
	$("#" + id).find(".choosetext span.value").html();
}
    
})






//
$('#type').change(function (){
   
     
       //省选择清空市，市选择清空区
      htmlobj=$.ajax({url:"attention.php?act=get_type&type="+encodeURI(encodeURI($("#type").val())),async:false,dataType: 'json'}); 
      json = $.parseJSON(htmlobj.responseText); 
     // alert(htmlobj.responseText);
      
      $('#type2').empty();
        $("<option >请选择</option>").appendTo('#type2');
       $.each(json, function (i, n) {  
       
                      
                        $("<option value=" + n.sn + ">"+ n.sn + "___"+ n.name + "</option>").appendTo('#type2');  
                    });  

     //alert($(this).find("option:selected").text());     
  })
  
  
  
  $('#type').val("{$attention_list.re_type}");
  $('#type').change();
   $('#type2').val("{$attention_list.re_code}");
-->
</script>
