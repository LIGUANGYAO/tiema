<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title></title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script charset="utf-8" src="kindeditor/kindeditor.js"></script>

</head>
<style type="text/css">
<!--

.demo {
	width:98%;
    margin-top:-15px;
  
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
	

	 <form name="myform" method="post" id="myform" action="admin_user.php?act=post" >
 

   
	<div class="tabcon" id="leftcon"  >
    
    <div  id="m1">
    <table class="table" width="100%" border="0">
    <th colspan="4">编辑用户</th>
     <tr  ><td width="180">用户代码<a style="color: red;">&nbsp;(代码默认无法修改)</a></td><td><input  name="user_code" type="hidden" value="{$admin_user_mx.user_code}"  id="user_code"/>{$admin_user_mx.user_code}</td></tr>
    <tr>
    <tr><td width="150">登陆名</td><td><textarea  name="user_name3" style="width: 300px; height: 50px;">{$admin_user_mx.user_name}</textarea></td></tr>
    <tr><td width="150">用户名</td><td><textarea  name="user_name2" style="width: 300px; height: 50px;">{$admin_user_mx.user_name2}</textarea></td></tr>
    </tr>
    
    
    
    
    </table>
    
    
    
    </div>
    <div align="center" style="padding: 10px;"><input  type="submit"  id="btn_queren" value="确认" />&nbsp;<input  type="button" onclick="location='admin_user.php'" value="返回" /></div>
	</div>
   
    
	</form>


	
</div><!--tabbox end-->







{/if}
	
{if $fall==post}



<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>编辑用户</b></td></tr>
 <tr><td>修改完成<a href="admin_user.php">返回</a></td></tr>
</table>
{/if}
{if $fall==add_admin_user_list}
<div class="demo">	
<form name="myform" method="post" action="admin_user.php?act=post_add" >   
   <div class="tabcon" id="leftcon"  >
    <div  id="m1"><table class="table" width="100%" border="0" >
 <th colspan="2">添加用户</th>
<tr  ><td width="200">用户代码<a style="color: red;">&nbsp;(添加后代码默认无法修改)</a></td><td><input id="user_code"  name="user_code" type="text"/><a style="color:red;">*</a></td></tr>
    <tr><td width="150">登陆名</td><td><textarea  name="user_name3" style="width: 300px; height: 50px;"></textarea></td></tr>
     <tr><td width="150">用户名称</td><td><textarea  name="user_name2" style="width: 300px; height: 50px;"></textarea></td></tr>
 
    
 

  
</table>
    
    
    
    </div>
	
    <div align="center" style="padding: 10px;"><input  type="submit"  id="btn_queren" value="确认" />&nbsp;<input  type="button" onclick="location='admin_user.php'" value="返回" /></div>
	</div>
    
    
    
	</form>


	
</div><!--tabbox end-->





{/if}



{if $fall==fs}
	
	



<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>代码已存在</b></td></tr>
 <tr><td>代码已存在<a href="admin_user.php">返回</a></td></tr>
</table>
	
    



{/if}

</body>  
</html>
{literal}
<script type="text/javascript">
$("#btn_queren").click(function (){
        
        if(jQuery.trim($("#user_code").attr('value'))=='' )
        {
           $("#user_code").focus();

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
     
</script>
{/literal}