<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>渠道管理</title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>

</head>
<style type="text/css">
<!--
	.table tr td p{margin:0px 0 0 0;padding:0;text-indent:0em;line-height:150%;}
-->
</style>
<body>

<div class="container">
  <div class="content">
  <div class="botable">
{if $fall==qudao}
<table class="table" width="100%" border="0" style="margin-bottom: 7px;">
<form>
 <tr>
 <th style="text-align: left;border-right-style:none"><input id="a_text" value="添加渠道" type="button" onclick="location='qudao.php?act=a_qudao'" />
 &nbsp;注：场景值ID为1的是永久场景微信公众号二维码（和微信后台生成的二维码是一致的）</th>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>


 </form>
</table>


   <table class="table" width="100%" border="0">
   
   <tr>
   <th>渠道代码</th>
   <th>渠道名称</th>
   <th>渠道类型</th>
   <th>上级ID</th>
   <th>场景值ID（1到100000）</th>
   <th>二维码</th>
   <th>推广信息</th>
   <th>添加时间</th>
   <th>操作</th>
   </tr>
<tbody  id="table_t">
   {foreach from=$qudao_list item=qudao_list}
  <tr>
  <td>{$qudao_list.qudao_sn}</td>
  <td>{$qudao_list.qudao_name}</td>
  <td>{if $qudao_list.qudao_type==0}总公司{/if}{if $qudao_list.qudao_type==1}分公司{/if}{if $qudao_list.qudao_type==2}代理/加盟{/if}</td>
  <td>{$qudao_list.p_id}</td>
  <td>{$qudao_list.qrcid}</td>
  <td> <a href="qudao.php?act=view_qrcode&ticket={$qudao_list.ticket}">查看</a></td>
 
  <td>{foreach from=$qudao_list.point item=point_l} 
  <p>{$point_l.users_sn}({$point_l.nick_name})/<a style="color:red">{$point_l.point}%</a></p>{foreachelse}无{/foreach}
  </td>
  <td>{$qudao_list.add_time}</td>
  
  <td > 
  {if $qudao_list.tzsy==1}
   <img  title="启用" name="{$qudao_list.qudao_sn}" id="qiyong"  src="images/no.gif" />&nbsp;
  <img  title="修改" name="{$qudao_list.qudao_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <img id="delete" name="{$qudao_list.qudao_sn}" title="删除" src="images/icon_drop.gif"/>
  {else if }
  <img  title="禁用" name="{$qudao_list.qudao_sn}" id="jinyong"  src="images/yes.gif" />&nbsp;
 <img  title="修改" name="{$qudao_list.qudao_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <img id="delete" name="{$qudao_list.qudao_sn}" title="删除" src="images/icon_drop.gif"/>
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


{if $fall==e_qudao}
<form action="qudao.php?act=post" method="POST">
<table class="table" width="100%" border="0">
    <tr><td colspan="2"><b>编辑</b></td></tr>
	
  <tr>
    <td>渠道代码:</td>
    <td><input   type="text" value="{$qudao.qudao_sn}"  disabled="disabled"/><a style="color:red;">*</a></td></tr>
  <input name="qudao_sn" id="qudao_sn"  type="hidden" value="{$qudao.qudao_sn}" />
  <tr>
    <td>渠道名称:</td>
    <td><input name="qudao_name"  id="qudao_name" type="text" value="{$qudao.qudao_name}" /><a style="color:red;">*</a></td></tr>
  <tr><td>渠道类型:</td><td>
  
  {if $qudao.qudao_type==0}<input type="radio" name="qudao_type" value="0" checked />总公司{else}<input type="radio" name="qudao_type" value="0"/>总公司{/if}
  {if $qudao.qudao_type==1}<input type="radio" name="qudao_type" value="1" checked />分公司{else}<input type="radio" name="qudao_type" value="1"/>分公司{/if}
  {if $qudao.qudao_type==2}<input type="radio" name="qudao_type" value="2" checked />代理/加盟{else}<input type="radio" name="qudao_type" value="2"/>代理/加盟{/if}
 
  </td> 
  </tr>
  <tr>
    <td>场景值ID:</td>
    <td><input   type="text"  value="{$qudao.qrcid}" disabled="disabled">
    <input name="qrcid" id="qrcid"  type="hidden" value="{$qudao.qrcid}" />
    </td>
  </tr>
  <tr>
   <tr><td>指定上级:</td><td>
  
 <select  name="p_id" id="p_id"> 
            <option value="000">总部</option>
       </select>
   
 
  </td> 
 
  
  </tr>
    <!-- 设置推广关注者-->
   <tr><td colspan="2" style="background-color:    #E8E8E8;"><b>绑定关注信息</b></td></tr>
 
   

  <tr>
   <tr>
    <td>关注者信息:</td>
    <td>
    <input  id="openid" type="hidden"/>
    
    <input name="qdbtn1" type="button" id="qdbtn1" onclick=" window.open('qudao.php?act=select_openid', 'newwindow', 'height=600, width=800, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no')" value="选择" class="button"/>
    </td>
    
    </tr>
    
    <tr>
    <td>本级推广比例:</td>
    <td>
    <table class="table" width="100%" >
        <tr><th colspan="3">信息</th></tr>
      
    </table>
     <table class="table" width="100%"  id="tgxx">
     {foreach from=$qudao.point item=point}
        <tr><td>{$point.users_sn}({$point.nick_name})</td><td style='width: 30%;'><input name='open[]' id='open' value='{$point.users_sn}({$point.nick_name})' type='hidden' /><input name='oppoint[]' id='oppoint' value='{$point.point}' style='width: 130px; text-align: center;'/>%</td></tr>
     {/foreach}
      
    </table>
    </td></tr>
    
    <!-- 设置商店分成 -->
    <tr><td colspan="2" style="background-color:    #E8E8E8;"><b>商店设置</b></td></tr>
    <tr>
    <td>下级商店推广比例:</td>
    <td> 商店默认比例:<input name="sdpoint" id="sdpoint" value="{$qudao.sdpoint}" />%<a style="color:red;">&nbsp;&nbsp;&nbsp;注:请输入比例</a></td>
    
     
    </tr>
    <tr>
    <td>商店详细设置</td>
    <td>

    
    <input name="set_s_fc" type="button" id="set_s_fc" onclick=" window.open('qudao.php?act=set_s_fc&qudao={$qudao.qudao_sn}&qudao_name={$qudao.qudao_name}', 's_fc', 'height=600, width=1000, top=0, left=0, toolbar=yes, menubar=no, scrollbars=yes, resizable=no, location=no, status=no  ')" value="设置" class="button"/>
    </td>
    </tr>
    
      <!-- 设置导购分成 -->
    <tr><td colspan="2" style="background-color:    #E8E8E8;"><b>导购设置</b></td></tr>
    <tr>
    <td>店铺下级导购推广比例:</td>
    <!--<td>  <input name="point" id="point" value="0" />%<a style="color:red;">&nbsp;&nbsp;&nbsp;注:请输入比例</a></td>-->
      <td> 导购默认比例:<input name="dgpoint" id="dgpoint" value="{$qudao.dgpoint}" />%<a style="color:red;">&nbsp;&nbsp;&nbsp;注:请输入比例</a></td>
     <td>

    
   
    </td>
    </tr>
    
    <tr><td>导购详细设置</td>
    <td>
    <input name="set_sales" type="button" id="set_sales" onclick=" window.open('qudao.php?act=set_sales&qudao={$qudao.qudao_sn}&qudao_name={$qudao.qudao_name}', 'set_sales', 'height=600, width=1000, top=0, left=0, toolbar=yes, menubar=no, scrollbars=yes, resizable=no, location=no, status=no  ')" value="设置" class="button"/>
    </td>
     
    </tr>
    
    <!-- end设置推广关注者-->
  <tr>
  
  <tr>
  <tr><td colspan="2"  style="text-align: center;"><input  id="queding" type="submit" value="确定"/>&nbsp;<input  type="button" value="取消" id="quxiao" onclick="location='qudao.php'"/></td></tr>
</table>
</form>
{/if}



{if $fall==a_qudao}
<form action="qudao.php?act=i_qudao" method="POST">
<table class="table" width="100%" border="0">
    <tr>
      <td colspan="2"><strong>新增渠道</strong></td>
    </tr>
  <tr>
    <td>渠道代码:</td>
    <td><input name="qudao_sn" id="qudao_sn"  type="text" /><a style="color:red;">*</a></td></tr>
  <tr>
    <td>渠道名称:</td>
    <td><input name="qudao_name"  id="qudao_name" type="text" /><a style="color:red;">*</a></td></tr>
  <tr><td>渠道类型:</td><td>
  
   <input type="radio" name="qudao_type" value="0" checked />总公司
   <input type="radio" name="qudao_type" value="1" />分公司
   <input type="radio" name="qudao_type" value="2" />代理/加盟
 
  </td> 
  </tr>
  
    <tr>
    <td>场景值ID:</td>
    <td><input name="qrcid" id="qrcid"  type="text" maxlength="5" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" value="{$bh.bh}">
    <span style="width:150px;" id="abc"></span><a style="color:red;">*点击空白处验证场景ID（10000到19999）</a></td>
    </tr>
  
  
  
    <tr><td>指定上级:</td><td>
  
 <select  name="p_id" id="p_id"> 
            <option value="000">总部</option>
       </select>
   
 
  </td> 
  </tr>
  
  
    
   <tr><td colspan="2" style="background-color:    #E8E8E8;"><b>绑定关注信息</b></td></tr>
  
  <!--
   <tr>
    <td>推广比例:</td>
    <td>  <input name="point" id="point" value="0" />%<a style="color:red;">&nbsp;&nbsp;&nbsp;注:请输入比例</a></td></tr>-->
  
  <tr>
   <tr>
    <td>关注者信息:</td>
    <td>
    <input  id="openid" type="hidden"/>
    
    <input name="qdbtn1" type="button" id="qdbtn1" onclick=" window.open('qudao.php?act=select_openid', 'newwindow', 'height=600, width=800, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no')" value="选择" class="button"/>
    </td>
    
    </tr>
    
    <tr>
    <td>关注者推广比例:</td>
    <td>
    <table class="table" width="100%" >
        <tr><th colspan="3">信息</th></tr>
      
    </table>
     <table class="table" width="100%"  id="tgxx">
     {foreach from=$qudao.point item=point}
        <tr><td>{$point.users_sn}({$point.nick_name})</td><td style='width: 30%;'><input name='open[]' id='open' value='{$point.users_sn}({$point.nick_name})' type='hidden' /><input name='oppoint[]' id='oppoint' value='{$point.point}' style='width: 130px; text-align: center;'/>%</td></tr>
     {/foreach}
      
    </table>
    </td></tr>

  <tr>
  <tr><td colspan="2"  style="text-align: center;"><input  id="queding" type="submit" value="确定"/>&nbsp;<input  type="button" value="取消" id="quxiao" onclick="location='qudao.php'"/></td></tr>
</table>
</form>
<script type="text/javascript">
  $("#queding").attr("disabled","true");
	 		$("#qrcid").blur(function () { 
			    var qrcid = jQuery.trim($("#qrcid").attr('value'));
				 var html="";
				//alert(qrcid);
				$.post('qudao.php?act=checkqudao&qrcid='+qrcid,
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

</script>

{/if}

{if $fall==i_staus}
<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>添加渠道</b></td></tr>
 <tr><td>{$val}<a href="qudao.php">返回</a></td></tr>
</table>
<script type="text/javascript">
<!--
	$(document).ready(function ()
{       
    var timer = setTimeout(function(){
      window.location="qudao.php";
    }, 500);
   
})
-->
</script>
{/if}

{if $fall==view}
<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>渠道二维码</b></td></tr>
 <tr><td><img src="upload/cj_qrcode/qudao/{$val}"><a href="qudao.php">返回</a></td></tr>
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
 
    $("#qudao_sn").focus();
       $("#queding").click(function(){
           if(jQuery.trim($("#qudao_sn").attr('value'))=='' )
        {
            
            $("#qudao_sn").focus();
            return false;
        }
         else if(jQuery.trim($("#qudao_name").attr('value'))=='' )
         {
             
            $("#qudao_name").focus();
            return false;
         }
		 else if(jQuery.trim($("#qrcid").attr('value'))=='' )
         {
             
            $("#qrcid").focus();
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
             
              htmlobj=$.ajax({url:"qudao.php?act=ed_status&qiyong="+encodeURI(encodeURI($(this).attr("name"))),async:false});
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
             
              htmlobj=$.ajax({url:"qudao.php?act=ed_status&jinyong="+encodeURI(encodeURI($(this).attr("name"))),async:false});
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
             
              htmlobj=$.ajax({url:"qudao.php?act=ed_status&delete="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        
        
        $("img[id='edit']").each(function (){
            
           $(this).click(function (){
        
           window.location='qudao.php?act=e_qudao&edit='+encodeURI(encodeURI($(this).attr("name")));
           
           
        })
        })
     
	 
  
   
   
    
        
    
})
-->
</script>
