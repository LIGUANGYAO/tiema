<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>条件选择</title>
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


<table  width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="table">
  <tr style="background-color:#ffffff;">
	<td colspan="3" style="padding-left:5px; padding-bottom:5px;">
	  <img src="images/icon_search.gif" width="16" height="16" border="0" alt="search" />搜索
	  <input type="text"  id="b_ysss" name="color_keyword"/>
	  <input type="button" value=" 搜索 " id="ysss" class="bttnn" />  <span id="tishi" style="color:red;display: none;" >请输入会员号/昵称/手机号</span>          
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
        <select name="select1[]" class="sortable" multiple="multiple" id="select1" style="width:370px;height:300px; float:left; border:1px #A0A0A4 outset; padding:4px; "></select>
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
       <select name="select2[]" multiple="multiple" id="select2" style="width:370px;height:300px; float:lfet;border:1px #A0A0A4 outset; padding:4px;">   <!--  {foreach from=$goods_list item=goods_list}
            <option id="select2_2" value="{$goods_list.goods_id}">{$goods_list.goods_sn}({$goods_list.goods_name})</option>
           {/foreach}-->
		  </select>
        </div>
      </td>
  </tr>
  <tr><td colspan="3">
          <div  style="text-align: center;"> 
		
          <span id="zd_queren"><input type="submit" class="bttnn" id="form_zd" value="确认"/></span> 
          <span id="zd_quxiao"><input type="button" class="bttnn" value="取消"  onclick="window.close();"/></span>
	
		  
		  </div>
		  </td></tr>
</table>
<script type="text/javascript">

$("#ysss").click(function ()
        {
		var s="";
           if($("#b_ysss").val()=='')
          {
             $("#tishi").show();
             return false;
          }else
          {
             $("#tishi").hide();
          }
         
		 //alert(window.opener.document.all.qudao.value);
		 if( window.opener.document.all.p_id.value!='')
		  {
		  s=window.opener.document.all.p_id.value;
		  htmlobj=$.ajax({url:"shop.php?act=ysss&type={$type}&s="+s+"&keyword="+encodeURI(encodeURI($("#b_ysss").val())),async:false,dataType: 'json'});
		  }
		  else
		  {
		  htmlobj=$.ajax({url:"shop.php?act=ysss&type={$type}&keyword="+encodeURI(encodeURI($("#b_ysss").val())),async:false,dataType: 'json'});
		  }
	       
		 
           $("#select1").html("");
           json = $.parseJSON(htmlobj.responseText); 
           $.each(json, function (i, o) {
		   
		   
           $("#select1").append("<option id='select1_1' name="+ o.mc+" value="+o.dm+" >"+ o.dm +"(" + o.mc +")</option>" );});
		   
		   
           $("#b_ysss").val("");
         })


       $('#form_zd').click(function ()
       {
       var aArray = {};//定义一个数组
       var st='';
       
     
                $("#select2 option").each(function (){
                        
                        aArray[$(this).index()]=$(this).val();
                        //st += '\'' + aArray[$(this).index()] + '\'' +',';
                        st +=  aArray[$(this).index()] + "("+ $(this).attr("name") +'),';
                })

                //st = st.substring(0,st.length-1);
                
                //alert(st);
                //alert({$type});
                // htmlobj=$.ajax({url:"wx_vouchers.php?act=abc&type={$type}",type:"POST",async:false});
   		        //setTimeout('alert("添加成功")',1000);
    		    valueExit(st);
    		    //window.location.href="wx_zan.php";
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

</script>   
	 
	   <script type="text/javascript">

       function valueExit(st) {
         // var returnValue =  docment.getElementById('select2[]').value;
		  var returnValue = st;
          opener.setValue(returnValue);                  
          window.close();
        }
       </script>

	 
</body>
</html>
