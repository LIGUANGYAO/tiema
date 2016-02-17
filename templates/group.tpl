<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>关注者组管理</title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/jquery.tabso_yeso.js"></script>
<style type="text/css">
<!--

.demo {
	width:98%;

  
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
         .table tr td p{margin:0px 0 0 0;padding:0;text-indent:0em;line-height:150%;}
-->
</style>
</head>

<body>

<div class="container">
<div class="content">
<div class="botable">
{if $fall==group}
<table class="table" width="100%" border="0" style="margin-bottom: 7px;">
<form>
 <tr>
 <th style="text-align: left;border-right-style:none"><input id="a_text" value="添加关注者组" type="button" onclick="location='group.php?act=a_group'" /></th>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>
</form>
</table>


   <table class="table" width="100%" border="0">
   
   <tr>
   <th>组代码</th>
   <th>组名称</th>
   <th>类型</th>
   <th>渠道用户</th>
   <th>推广用户</th>
   <th>添加时间</th>
   <th>操作</th>
   </tr>
<tbody  id="table_t">
   {foreach from=$group_list item=group_list}
  <tr>
  <td>{$group_list.group_sn}</td>
  <td>{$group_list.group_name}</td>
  <td>{if $group_list.group_type_sn==0}内部{/if}{if $group_list.group_type_sn==1}客服{/if}{if $group_list.group_type_sn==2}管理员{/if}</td>
 
  
   <td>
   
  
   <p>{if $group_list.v5==1}全部{elseif $group_list.v5==2}全部渠道{elseif $group_list.v5==3}全部商店{elseif $group_list.v5==2}全部店员{else}无{/if}/{if $group_list.v6==0}本级{elseif $group_list.v6==1}本级+直接下级{elseif $group_list.v6==2}本级+全部下级{/if}</p>
   
   
  </td>
  
   <td>
   
   <p>{if $group_list.v1=='' or $group_list.v1=='请选择' }无{else}{$group_list.v1}{/if}/{if $group_list.v2=='' or $group_list.v2=='请选择' }无{else}{$group_list.v2}{/if}/{if $group_list.v3=='' or $group_list.v3=='请选择' }无{else}{$group_list.v3}{/if}/{if $group_list.v4==0}本级{elseif $group_list.v4==1}本级+直接下级{elseif $group_list.v4==2}本级+全部下级{/if}</p>
  
   
   
  </td>
  
  <td>{$group_list.add_time}</td>
  <td > 
  {if $group_list.tzsy==1}
   <img  title="启用" name="{$group_list.group_sn}" id="qiyong"  src="images/no.gif" />&nbsp;
  <img  title="修改" name="{$group_list.group_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <img id="delete" name="{$group_list.group_sn}" title="删除" src="images/icon_drop.gif"/>
  {else if }
  <img  title="禁用" name="{$group_list.group_sn}" id="jinyong"  src="images/yes.gif" />&nbsp;
 <img  title="修改" name="{$group_list.group_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <img id="delete" name="{$group_list.group_sn}" title="删除" src="images/icon_drop.gif"/>
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


{if $fall==e_group}

<div class="demo">	
     <ul class="tabbtn" id="move-animate-left">
		<li class="current" id="sub1"><a >组信息</a></li>
		<li id="sub2"><a >用户列表</a></li>
		
	</ul>
<form action="group.php?act=post" method="POST">
<!--tabbtn end-->
<div class="tabcon" id="leftcon">
    <div id="m1">
<table class="table" width="100%" border="0">
    <tr><td colspan="2"><b>编辑</b></td></tr>
	
  <tr>
    <td>关注者组代码:</td>
    <td><input   type="text" value="{$group.group_sn}"  disabled="disabled"/><a style="color:red;">*</a></td></tr>
  <input name="group_sn" id="group_sn"  type="hidden" value="{$group.group_sn}" />
  <tr>
    <td>关注者组名称:</td>
    <td><input name="group_name"  id="group_name" type="text" value="{$group.group_name}" /><a style="color:red;">*</a></td></tr>
  <tr><td>关注者组类型:</td><td>
  
  {if $group.group_type_sn==0}<input type="radio" name="group_type_sn" value="0" checked />内部{else}<input type="radio" name="group_type_sn" value="0"/>内部{/if}
  {if $group.group_type_sn==1}<input type="radio" name="group_type_sn" value="1" checked />客服{else}<input type="radio" name="group_type_sn" value="1"/>客服{/if}
  {if $group.group_type_sn==2}<input type="radio" name="group_type_sn" value="2" checked />管理员{else}<input type="radio" name="group_type_sn" value="2"/>管理员{/if}
 
  </td> 
  </tr>
  <tr>
    <td>备注:</td>
    <td><input   type="text"  name="group_note2"  value="{$group.group_note}" /></td>
  </tr>
 
  <tr><td colspan="2"  style="text-align: center;">
  <input  id="queding" type="submit" value="确定"/>&nbsp;<input  type="button" value="取消" id="quxiao" onclick="location='group.php'"/></td></tr>
</table>
</div>
</div>
</form>	



<div style="display:none;" id="m2">
<div id="zdxsdiv" style="width: 700px;height: 300px; background-color: #fff;" >
<table  width="700" align="center" border="0" cellpadding="0" cellspacing="0" class="table">
  <tr style="background-color:#ffffff;">
	<td colspan="3" style="padding-left:5px; padding-bottom:5px;">
	  <img src="images/icon_search.gif" width="16" height="16" border="0" alt="search" />关注者
	  <input type="text"  id="b_ysss" name="color_keyword"/>
   
    
	  <input type="button" value=" 搜索 " id="ysss" class="button" />    
      <span id="tishi" style="color:red;display: none;" >请输入会员号/昵称/手机号</span>        
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
        <select name="select1[]" class="sortable" multiple="multiple" id="select1" style="width:540px;height:200px; float:left; border:1px #A0A0A4 outset; padding:4px; "></select>
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
       <select name="select2[]" multiple="multiple" id="select2" style="width:540px;height:200px; float:lfet;border:1px #A0A0A4 outset; padding:4px;">           
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
          <span id="zd_quxiao"><input type="button" class="btn" value="取消"  onclick="location='group.php'"/></span>
		  </div>
		  </td></tr>
          
           <tr style="background-color:#ffffff;">
              <td colspan="3" style="padding-left:5px; padding-bottom:5px;">
              <b>选择渠道绑定关注者信息</b></td>
              </tr>
           <tr style="background-color:#ffffff;">
	<td colspan="3" style="padding-left:5px; padding-bottom:5px;">
	  &nbsp;场景:<select  name="changjing" id="changjing" style="width: 150px;" > 
            <option  value ="0">请选择</option>  
                <option  value ="1">全部</option>
                <option  value ="2">所有渠道</option> 
                <option  value ="3">所有商店</option> 
                <option  value ="4">所有导购</option> 
            </select>
           
            &nbsp;类型:<select  name="cjleixing" id="cjleixing" style="width: 150px;" > 
            <option  value ="0">本级</option> 
            <option  value ="1">本级+直属下级</option>
            <option  value ="2">本级+全部下级</option> 
             
    
            </select>  
            &nbsp; <input type="button" value=" 确认 " id="ysss4" class="button" />      
	</td>
    
  </tr>
          
          
          
          
              <tr style="background-color:#ffffff;">
              <td colspan="3" style="padding-left:5px; padding-bottom:5px;">
              <b>选择通过下面渠道 关注微信公众号的 所有用户</b></td>
              </tr>
          
           <tr style="background-color:#ffffff;">
	<td colspan="3" style="padding-left:5px; padding-bottom:5px;">
	  &nbsp;渠道:<select  name="province" id="province" style="width: 150px;" > 
            <option  value ="">请选择</option>  
            {foreach from=$qudao.qudao item=qudao}
            <option  value ="{$qudao.qudao_sn}">{$qudao.qudao_sn}_{$qudao.qudao_name}</option>    
            {/foreach}
            </select>
            
            &nbsp;商店:<select  name="city" id="city" style="width: 150px;"  > 
            <option  value ="">请选择</option> 
            {foreach from=$qudao.shop item=shop}
            <option  value ="{$shop.shop_sn}">{$shop.shop_name}</option>    
            {/foreach}
            </select>
            &nbsp;导购:<select  name="district" id="district" style="width: 150px;" > 
            <option  value ="">请选择</option> 
            {foreach from=$qudao.sales item=sales}
            <option  value ="{$sales.sales_sn}">{$sales.sales_name}</option>    
            {/foreach}
            </select>  
            &nbsp;类型:<select  name="leixing" id="leixing" style="width: 150px;" > 
            <option  value ="0">本级</option> 
            <option  value ="1">本级+直属下级</option>
            <option  value ="2">本级+全部下级</option> 
             
    
            </select>  
            &nbsp; <input type="button" value=" 确认 " id="ysss3" class="button" />      
	</td>
    
  </tr>
</table>
</div>
</div>



</div>
<script type="text/javascript">
    
    
    
$('#form_zd').click(function ()
    {
       var aArray = {};//定义一个数组
       var st='';
       
       
         
       
       
            $("#select2 option").each(function (){
            aArray[$(this).index()]=$(this).val();
            st +=aArray[$(this).index()]+',';
            })
            //alert(st);
           //alert(aArray[0]);
           htmlobj=$.ajax({url:"group.php?act=i_users_list&group_sn={$group.group_sn}",type:"POST",data:{"st":st},async:false});
		   window.location.href="group.php";
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
		
		
		$("#ysss").click(function ()
        {
            if($("#b_ysss").val()=='')
          {
             $("#tishi").show();
             return false;
          }else
          {
             $("#tishi").hide();
          }
          
          
           htmlobj1=$.ajax({url:"group.php?act=ysss_sum&group_sn={$group.group_sn}&keyword="+encodeURI(encodeURI($("#b_ysss").val())),async:false,type: 'POST'});
          var sum=htmlobj1.responseText;
      
           //alert(sum);return;
           for(var i=0;i<sum;i++)
           {
            var aaa="html"+i;
          
            
            aaa=$.ajax({
                        type:"POST",
                        dataType: "json", 
                       
                        url:"group.php?act=ysss&group_sn={$group.group_sn}&keyword="+encodeURI(encodeURI($("#b_ysss").val())),
                        data:{"i":i},
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
            
            
          
            
           }
           
            
                                        
           
           $("#b_ysss").val("");
         })
         
         
       	$("#ysss2").click(function ()
        {
           var v1=$('#province').val();
           var v2=$('#city').val();
           var v3=$('#district').val();
           var v4=$('#leixing').val();
            
           //alert(v1+','+v2+'.'+v3+'_'+v4);
           if(v1!='' && v1!='请选择' && v2!='' && v2!='请选择' && v3!='' && v3!='请选择' )
           {
            //alert("3");
            
            //三个都选择,取第三个值
            htmlobj=$.ajax({url:"group.php?act=ysss2",data:{'v1':v1,'v2':v2,'v3':v3,'v4':v4},async:false,dataType: 'json'});
            $("#select1").html("");
           json = $.parseJSON(htmlobj.responseText); 
           $.each(json, function (i, o) {
           $("#select1").append("<option id='select1_1' name="+ o.users_sn+" value="+o.id+" >"+ o.users_sn +"(" + o.nick_name +")</option>" );});
          
                
           }
           else if(v1!='' && v1!='请选择' && v2!='' && v2!='请选择')
           {
            //alert("2");
            
            htmlobj=$.ajax({url:"group.php?act=ysss2",data:{'v1':v1,'v2':v2,'v4':v4},async:false,dataType: 'json'});
             $("#select1").html("");
           json = $.parseJSON(htmlobj.responseText); 
           $.each(json, function (i, o) {
           $("#select1").append("<option id='select1_1' name="+ o.users_sn+" value="+o.id+" >"+ o.users_sn +"(" + o.nick_name +")</option>" );});
           $("#b_ysss").val("");
           }
           else if(v1!='' && v1!='请选择')
           {
            //alert("1");
            
            htmlobj=$.ajax({url:"group.php?act=ysss2",data:{'v1':v1,'v4':v4},async:false,dataType: 'json'});
            $("#select1").html("");
           json = $.parseJSON(htmlobj.responseText); 
           $.each(json, function (i, o) {
           $("#select1").append("<option id='select1_1' name="+ o.users_sn+" value="+o.id+" >"+ o.users_sn +"(" + o.nick_name +")</option>" );});
           $("#b_ysss").val("");
           }
           else
           {
            //alert("不是");
           }
           
        })
         	$("#ysss3").click(function ()
        {
           var v1=$('#province').val();
           var v2=$('#city').val();
           var v3=$('#district').val();
           var v4=$('#leixing').val();
            
           window.location='group.php?act=post2&group_sn={$group.group_sn}&v1='+v1+'&v2='+v2+'&v3='+v3+'&v4='+v4;
           
        })
        
        
        	$("#ysss4").click(function ()
        {
           var v1=$('#changjing').val();
           var v2=$('#cjleixing').val();
          
           window.location='group.php?act=post3&group_sn={$group.group_sn}&v1='+v1+'&v2='+v2;
           
        })
         
         
  //20140619新增根据渠道店铺、导购选择粉丝组
  $('#province').change(function (){
    $('#city').val(""); 
    $('#district').val(""); 
     $('#address').val($("#province").find("option:selected").text()+" "); 
     
     
       //省选择清空市，市选择清空区
      htmlobj=$.ajax({
        url:"group.php?act=get_city&province="+encodeURI(encodeURI($("#province").val()))
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
     
         htmlobj2=$.ajax({url:"group.php?act=get_district&city="+encodeURI(encodeURI($("#city").val())),async:false,dataType: 'json'}); 
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
  
  
   
 
    sv1=$("#sv1").val();
    sv2=$("#sv2").val();
    sv3=$("#sv3").val();
    sv4=$("#sv4").val();
    sv5=$("#sv5").val();
    sv6=$("#sv6").val();
    $('#province').val(sv1);
    $('#province').change();
    $('#city').val(sv2);
    $('#city').change();
    $('#district').val(sv3);
    $('#leixing').val(sv4);
    
    $('#changjing').val(sv5);
    $('#cjleixing').val(sv6);
</script>


{/if}



{if $fall==a_group}
<div class="demo">	
     <ul class="tabbtn" id="move-animate-left">
		<li class="current" id="sub1"><a >组信息</a></li>
	</ul>
		
<form action="group.php?act=i_group"  method="POST">
<!--tabbtn end-->
<table class="table" width="100%" border="0">

  <tr>
    <td>关注者组代码:</td>
    <td><input name="group_sn" id="group_sn"  type="text" /><a style="color:red;">*</a></td></tr>
  <tr>
    <td>关注者组名称:</td>
    <td><input name="group_name"  id="group_name" type="text" /><a style="color:red;">*</a></td></tr>
  <tr><td>关注者组类型:</td><td>
  
  
   {if $group.group_type_sn==0}<input type="radio" name="group_type_sn" value="0" checked />内部{else}<input type="radio" name="group_type_sn" value="0"/>内部{/if}
  {if $group.group_type_sn==1}<input type="radio" name="group_type_sn" value="1" checked />客服{else}<input type="radio" name="group_type_sn" value="1"/>客服{/if}
  {if $group.group_type_sn==2}<input type="radio" name="group_type_sn" value="2" checked />管理员{else}<input type="radio" name="group_type_sn" value="2"/>管理员{/if}
  
 
  </td> 
  </tr>
  <tr>
    <td>备注:</td>
    <td><input name="group_note" id="group_note"  type="text" ></td>
    </tr>

</table>
<div align="center" style="padding: 10px;"><input  type="submit" value="确认" />&nbsp;<input  type="button" onclick="location='group.php'" value="返回" /></div>
</form>	
</div>
{/if}

















{if $fall==i_staus}
<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>添加关注者组</b></td></tr>
 <tr><td>{$val}<a href="group.php">返回</a></td></tr>
</table>
{/if}

{if $fall==view}
<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>关注者组二维码</b></td></tr>
 <tr><td>{$val}<a href="group.php">返回</a></td></tr>
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
 
    $("#group_sn").focus();
       $("#queding").click(function(){
           if(jQuery.trim($("#group_sn").attr('value'))=='' )
        {
            
            $("#group_sn").focus();
            return false;
        }
         else if(jQuery.trim($("#group_name").attr('value'))=='' )
         {
             
            $("#group_name").focus();
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
             
              htmlobj=$.ajax({url:"group.php?act=ed_status&qiyong="+encodeURI(encodeURI($(this).attr("name"))),async:false});
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
             
              htmlobj=$.ajax({url:"group.php?act=ed_status&jinyong="+encodeURI(encodeURI($(this).attr("name"))),async:false});
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
             htmlobj=$.ajax({url:"group.php?act=ed_status&delete="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
               
        })
        })
        
        $("img[id='edit']").each(function (){
        $(this).click(function (){        
        window.location='group.php?act=e_group&edit='+encodeURI(encodeURI($(this).attr("name")));           
        })
        })
		
		
		
    $("#sub1").click(function (){
	   $("#m2").hide();
       $("#m1").show();
	})
    $("#sub2").click(function (){
	    $("#m1").hide();
       $("#m2").show();
	}) 
	

	
	//左右滑动选项卡切换
	$("#move-animate-left").tabso({
		cntSelect:"#leftcon",
		tabEvent:"click",
		tabStyle:"move-animate",
		direction : "left"
	});
	
	
	
})
-->
</script>
