<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/Calendar3.js"></script>

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

</head>

<body>

<div class="container">
  <div class="content">
  
 
 
   <div class="botable">
{if $fall==donation}

   

    <table class="table" width="100%" border="0" style="margin-bottom: 7px;">

 <form>
 <tr>
 <th style="text-align: left;border-right-style:none"><input id="a_donation" value="添加募捐" type="button" onclick="location='donation.php?act=a_donation'" class="bttnn"/>&nbsp;<input id="down_hy" value="头像下载" type="hidden" /></th>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>


 </form>
</table>


   <table class="table" width="100%" border="0">
   
   <tr><th >募捐代码</th><th>募捐名称</th><th>内容</th><th>地点</th><th>时间</th><th>计划募集资金</th><th>操作</th></tr>
<tbody  id="table_t">
   {foreach from=$donation_list item=donation_list}
  <tr><td style="width:70px">{$donation_list.donation_sn}</td><td style="width:140px">{$donation_list.donation_name}</td><td  title="{$donation_list.note}">{$donation_list.note}</td><td >{$donation_list.address}</td><td style="width:150px">{$donation_list.time}~{$donation_list.time2}</td><td style="width:100px">{$donation_list.je}</td>
  
  <td style="width:70px"> 
  {if $donation_list.tzsy==1}
   <img  title="启用" name="{$donation_list.donation_sn}" id="qiyong"  src="images/no.gif" />&nbsp;
  <img  title="修改" name="{$donation_list.donation_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <!--<img id="delete" name="{$donation_list.donation_sn}" title="删除" src="images/icon_drop.gif"/>-->
  {else if }
  <img  title="禁用" name="{$donation_list.donation_sn}" id="jinyong"  src="images/yes.gif" />&nbsp;
  <img  title="修改" name="{$donation_list.donation_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
   <!--<img id="delete" name="{$donation_list.donation_sn}" title="删除" src="images/icon_drop.gif"/>-->
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


{if $fall==e_donation}
<form action="donation.php?act=post" method="POST">
<table class="table" width="100%" border="0">

  <tr><td colspan="2"><b>编辑募捐</b></td></tr>
  <tr><td>代码:</td><td><input   type="text"  value="{$list_mx.donation_sn}"  disabled="true"readonly="true"/><input name="donation_sn" id="donation_sn"  type="hidden"  value="{$list_mx.donation_sn}" /><a style="color:red;">*</a></td></tr>
  
  <tr><td>名称:</td><td><input name="donation_name"  id="donation_name" type="text" value="{$list_mx.donation_name}"/><a style="color:red;">*</a></td></tr>
  <tr><td>内容:</td><td><textarea name="note" id="note" style="width:300px;height:50px;" >{$list_mx.note}</textarea></td></tr>
   <tr><td>时间:</td><td><input  class="time" value="{$list_mx.time}" name="time" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this);" readonly="readonly" />~<input  class="time2" value="{$list_mx.time2}" name="time2" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this);" readonly="readonly" /></td></tr>
  <tr><td>地点:</td><td><textarea name="address" id="address" style="width:300px;height:50px;" >{$list_mx.address}</textarea></td></tr>
    <tr><td>计划募集资金:￥</td><td><input name="je"  id="je" type="text" value="{$list_mx.je}" />
    
    </td></tr>
    <tr><td>备注1:</td><td>
     <textarea id="editor_id"name="bz1"   style="width:620px;height:310px;">
      {$list_mx.bz1} 
    </textarea>
    </td></tr>
    <tr><td>备注2:</td><td>
      <textarea id="editor_id2"name="bz2"   style="width:620px;height:310px;">
      {$list_mx.bz2} 
    </textarea>
    </td></tr>
   <!-- <tr><td>备注3:</td><td>
     <textarea id="editor_id"name="bz1"   style="width:620px;height:310px;">
    </td></tr>
    <tr><td>备注4:</td><td>
     <textarea id="editor_id"name="bz1"   style="width:620px;height:310px;">
    </td></tr>
    <tr><td>备注5:</td><td>
     <textarea id="editor_id"name="bz1"   style="width:620px;height:310px;">
    </td></tr>-->
   
 

  
  <tr><td colspan="2"  style="text-align: center;"><input  id="queding" type="submit" value="确定"/>&nbsp;<input  type="button" value="取消" id="quxiao" onclick="location='donation.php'"/></td></tr>
</table>
</form>
{/if}



{if $fall==a_donation}
<form action="donation.php?act=i_donation" method="POST">
<table class="table" width="100%" border="0">
    <tr><td colspan="2"><b>添加募捐</b></td></tr>
  <tr><td>代码:</td><td><input name="donation_sn" id="donation_sn"  type="text" /><a style="color:red;">*</a></td></tr>
  <tr><td>名称:</td><td><input name="donation_name"  id="donation_name" type="text" /><a style="color:red;">*</a></td></tr>
  <tr><td>内容:</td><td><textarea name="note" id="note" style="width:300px;height:50px;"></textarea></td></tr>
   <tr><td>时间:</td><td><input  class="time" value="" name="time" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this);" readonly="readonly" />~<input  class="time2" value="{$list_mx.time2}" name="time2" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this);" readonly="readonly" /></td></tr>
  <tr><td>地点:</td><td><textarea name="address" id="address" style="width:300px;height:50px;"></textarea></td></tr>
    <tr><td>计划募集资金:￥</td><td><input name="je"  id="je" type="text" />
    
    </td></tr>
  <tr><td>备注1:</td><td>
     <textarea id="editor_id"name="bz1"   style="width:620px;height:310px;">
      {$list_mx.bz1} 
    </textarea>
    </td></tr>
    <tr><td>备注2:</td><td>
      <textarea id="editor_id2"name="bz2"   style="width:620px;height:310px;">
      {$list_mx.bz2} 
    </textarea>
    </td></tr>
   <!-- <tr><td>备注3:</td><td>
     <textarea id="editor_id"name="bz1"   style="width:620px;height:310px;">
    </td></tr>
    <tr><td>备注4:</td><td>
     <textarea id="editor_id"name="bz1"   style="width:620px;height:310px;">
    </td></tr>
    <tr><td>备注5:</td><td>
     <textarea id="editor_id"name="bz1"   style="width:620px;height:310px;">
    </td></tr>-->
   
  
  <tr><td colspan="2"  style="text-align: center;"><input  id="queding" type="submit" value="确定"/>&nbsp;<input  type="button" value="取消" id="quxiao" onclick="location='donation.php'"/></td></tr>
</table>
</form>
{/if}





{if $fall==i_staus}
<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>添加文本募捐</b></td></tr>
 <tr><td>{$val}<a href="donation.php">返回</a></td></tr>
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
     $("#donation_sn").focus();
       $("#queding").click(function(){
           if(jQuery.trim($("#donation_sn").attr('value'))=='' )
        {
            
            $("#donation_sn").focus();
            return false;
        }
         else if(jQuery.trim($("#donation_name").attr('value'))=='' )
         {
             
            $("#donation_name").focus();
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
             
              htmlobj=$.ajax({url:"donation.php?act=ed_status&qiyong="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responsedonation);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        
        
         $("img[id='jinyong']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("name"))){
             
              htmlobj=$.ajax({url:"donation.php?act=ed_status&jinyong="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responsedonation);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
          $("img[id='delete']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("删除"+$(this).attr("name"))){
             
              htmlobj=$.ajax({url:"donation.php?act=ed_status&delete="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responsedonation);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        
        
        $("img[id='edit']").each(function (){
            
           $(this).click(function (){
        
        
        window.open('donation.php?act=e_donation&edit='+encodeURI(encodeURI($(this).attr("name"))));
           //window.location='donation.php?act=e_donation&edit='+encodeURI(encodeURI($(this).attr("name")));
           
           
        })
        })
        
        
        
    
})
-->
</script>
