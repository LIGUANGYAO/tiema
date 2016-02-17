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
	

	 <form name="myform" method="post" id="myform" action="role.php?act=post" >
 

   
	<div class="tabcon" id="leftcon"  >
    
    <div  id="m1">
    <table class="table" width="100%" border="0">
    <th colspan="4">编辑角色</th>
    <tr  >
    <input  value="{$role_mx.role_sn}" id="role_sn" type="hidden"/>
    <td  style="width:150px">代码<a style="color: red;">&nbsp;(代码默认无法修改)</a></td><td colspan="3" ><input  name="role_sn" type="hidden" value="{$role_mx.role_sn}"/>{$role_mx.role_sn}</td>
    </tr>
    <tr>
    <td  >名称</td><td colspan="3" ><textarea  name="role_name" style="width: 300px; height: 50px;">{$role_mx.role_name}</textarea></td>
    </tr>
    
     <tr><td colspan="4" style="background-color:    #E8E8E8;"><b>绑定用户</b></td></tr>
    <tr style="background-color:#ffffff;">
	<td colspan="4" style="padding-left:5px; padding-bottom:5px;">
	  <img src="images/icon_search.gif" width="16" height="16" border="0" alt="search" />搜索用户
	  <input type="text"  id="b_ysss" name="color_keyword" />
   
    
	  <input type="button" value=" 搜索 " id="ysss" class="button"  />    
      <span id="tishi" style="color:red;display: none;" >请输入会员号/昵称/手机号</span>        
	</td>
    
  </tr>
   </table>
   
      <table class="table" width="100%" border="0">
    
  <tr style="background-color: #3187CE; height: 25px;">
            <th align="center" style="font-weight:bold;">用户</th>
            <th align="center" style="font-weight:bold;">操作</th>
            <th align="center" style="font-weight:bold;">选择用户</th>
   </tr>
  <tr>
    
    <td>
        <div style="float:left">
        <select name="select1[]" class="sortable" multiple="multiple" id="select1" style="width:500px;height:200px; float:left; border:1px #A0A0A4 outset; padding:4px; "></select>
        </div>
        </td>
        <td>
        <div style="float:left"> 
          <span id="add">
          <input type="button" class="btn" value=">"/>
          </span><br />
          <span id="add_all">
          <input type="button" class="btn" value=">>"/>
          </span> <br />
          <span id="remove">
          <input type="button" class="btn" value="<"/>
          </span><br />
          <span id="remove_all">
          <input type="button" class="btn" value="<<"/>
          </span>  </div>
         
          </td>
          <td>
        <div style="float:left">
            
          <select name="select2[]" multiple="multiple" id="select2" style="width:500px;height:200px; float:lfet;border:1px #A0A0A4 outset; padding:4px;">  
                   
           {foreach from=$users_list item=users_list}
           
          
            <option id="select2_2" value="{$users_list.users_id}">{$users_list.users_sn}({$users_list.nick_name})</option>
           {/foreach}
          </select>
        </div>
      </td>
  </tr>
  <input type="hidden" value="{$group.v1}"  id="sv1"/>
  <input type="hidden" value="{$group.v2}"  id="sv2"/>
  <input type="hidden" value="{$group.v3}"  id="sv3"/>
  <input type="hidden" value="{$group.v4}"  id="sv4"/>
  <input type="hidden" value="{$group.v5}"  id="sv5"/>
  <input type="hidden" value="{$group.v6}"  id="sv6"/>
  <tr><td colspan="3">
          <div  style="text-align: center;"> 
          <span id="zd_queren"><input type="submit" class="btn" id="form_zd" value="确认"/></span> 
          <span id="zd_quxiao"><input type="button" class="btn" value="取消"  onclick="location='role.php'"/></span>
		  </div>
		  </td></tr>
    
    
    </table>
    
    
    
    </div>
    
   
    
	</form>


	
</div><!--tabbox end-->







{/if}
	
{if $fall==post}



<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>编辑角色</b></td></tr>
 <tr><td>修改成功<a href="role.php">返回</a></td></tr>
</table>
{/if}
{if $fall==add_role_list}
<div class="demo">	
<form name="myform" method="post" action="role.php?act=post_add" enctype="multipart/form-data">   
   <div class="tabcon" id="leftcon"  >
    <div  id="m1"><table class="table" width="100%" border="0" >
 <th colspan="2">添加角色</th>
 <tr><td>代码:</td><td><input name="role_sn" id="role_sn"  type="text" /><a style="color:red;">*</a></td></tr>
  <tr><td>名称:</td><td><textarea  name="role_name" style="width: 300px; height: 50px;">{$role_mx.role_name}</textarea><a style="color:red;">*</a></td></tr>
 
     <tr><td colspan="4" style="background-color:    #E8E8E8;"><b>绑定用户</b></td></tr>
    <tr style="background-color:#ffffff;">
	<td colspan="4" style="padding-left:5px; padding-bottom:5px;">
	  <img src="images/icon_search.gif" width="16" height="16" border="0" alt="search" />搜索用户
	  <input type="text"  id="b_ysss" name="color_keyword" />
   
    
	  <input type="button" value=" 搜索 " id="ysss" class="button"  />    
      <span id="tishi" style="color:red;display: none;" >请输入会员号/昵称/手机号</span>        
	</td>
    
  </tr>
   </table>
   
      <table class="table" width="100%" border="0">
    
  <tr style="background-color: #3187CE; height: 25px;">
            <th align="center" style="font-weight:bold;">用户</th>
            <th align="center" style="font-weight:bold;">操作</th>
            <th align="center" style="font-weight:bold;">选择用户</th>
   </tr>
  <tr>
    
    <td>
        <div style="float:left">
        <select name="select1[]" class="sortable" multiple="multiple" id="select1" style="width:500px;height:200px; float:left; border:1px #A0A0A4 outset; padding:4px; "></select>
        </div>
        </td>
        <td>
        <div style="float:left"> 
          <span id="add">
          <input type="button" class="btn" value=">"/>
          </span><br />
          <span id="add_all">
          <input type="button" class="btn" value=">>"/>
          </span> <br />
          <span id="remove">
          <input type="button" class="btn" value="<"/>
          </span><br />
          <span id="remove_all">
          <input type="button" class="btn" value="<<"/>
          </span>  </div>
         
          </td>
          <td>
        <div style="float:left">
            
          <select name="select2[]" multiple="multiple" id="select2" style="width:500px;height:200px; float:lfet;border:1px #A0A0A4 outset; padding:4px;">  
                   
           {foreach from=$users_list item=users_list}
           
          
            <option id="select2_2" value="{$users_list.users_id}">{$users_list.users_sn}({$users_list.nick_name})</option>
           {/foreach}
          </select>
        </div>
      </td>
  </tr>
  <input type="hidden" value="{$group.v1}"  id="sv1"/>
  <input type="hidden" value="{$group.v2}"  id="sv2"/>
  <input type="hidden" value="{$group.v3}"  id="sv3"/>
  <input type="hidden" value="{$group.v4}"  id="sv4"/>
  <input type="hidden" value="{$group.v5}"  id="sv5"/>
  <input type="hidden" value="{$group.v6}"  id="sv6"/>
  <tr><td colspan="3">
          <div  style="text-align: center;"> 
          <span id="zd_queren"><input type="submit" class="btn" id="form_zd" value="确认"/></span> 
          <span id="zd_quxiao"><input type="button" class="btn" value="取消"  onclick="location='role.php'"/></span>
		  </div>
		  </td></tr>
 

  
</table>
    
    
    
    </div>
	
    
    
    
    
	</form>


	
</div><!--tabbox end-->





{/if}



{if $fall==fs}
	
	



<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>代码已存在</b></td></tr>
 <tr><td>代码已存在<a href="role.php">返回</a></td></tr>
</table>
	
    



{/if}

</body>  
</html>
{literal}
<script type="text/javascript">
$(document).ready(function ()
{    
       
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
		
        $("#ysss").bind("click",function(){
                $.ajax({
                type:"POST",
                dataType: "json", 
                
                url:"role.php?act=ysss",
                data:{"role_sn":$("#role_sn").val(),"keyword":$("#b_ysss").val()},
                async:false,
                beforeSend:function(XMLHttpRequest){
                },
                success:function(data,textStatus){
                     $.each(data, function (i, o) {
                        $("#select1").append("<option id='select1_1' name="+ o.users_sn+" value="+o.id+" >"+ o.users_sn +"(" + o.nick_name +")</option>" );});
                    },
                complete:function(XMLHttpRequest,textStatus){
                },
                error:function(XMLHttpRequest,textStatus,errorThrown){   
                }
                });
        })
        
        
        
           
        $('#form_zd').click(function ()
            {
               var aArray = {};//定义一个数组
               var st='';
               
               
                 
               
               
                    $("#select2 option").each(function (){
                    aArray[$(this).index()]=$(this).val();
                    st +=aArray[$(this).index()]+',';
                    })
                    //alert(st);return false;
                   //alert(aArray[0]);
                   htmlobj=$.ajax({url:"role.php?act=i_u",type:"POST",data:{"st":st,"role_sn":$("#role_sn").val()},async:false});
        		  // window.location.href="group.php";
            })





})
</script>
{/literal}