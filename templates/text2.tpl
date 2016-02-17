<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员中心</title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>

</head>

<body>

<div class="container">
  <div class="content">
  
 
 
   <div class="botable">
{if $fall==text2}

   

    <table class="table" width="100%" border="0" style="margin-bottom: 7px;">

 <form>
 <tr>
 <th style="text-align: left;border-right-style:none"><input id="a_text2" value="添加模板" type="button" onclick="location='text2.php?act=a_text2'" />&nbsp;<input id="down_hy" value="头像下载" type="hidden" /></th>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>


 </form>
</table>


   <table class="table" width="100%" border="0">
   
   <tr><th >模板代码</th><th>模板名称</th><th>内容</th><th>最后更新时间</th><th>操作</th></tr>
<tbody  id="table_t">
   {foreach from=$text2_list item=text2_list}
  <tr><td style="width:70px">{$text2_list.text2_sn}</td><td style="width:140px">{$text2_list.title}</td><td  title="{$text2_list.text2}">{$text2_list.text2}</td><td style="width:150px">{$text2_list.last_update}</td>
  
  <td style="width:70px"> 
  {if $text2_list.tzsy==1}
   <img  title="启用" name="{$text2_list.text2_sn}" id="qiyong"  src="images/no.gif" />&nbsp;
  <img  title="修改" name="{$text2_list.text2_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <img id="delete" name="{$text2_list.text2_sn}" title="删除" src="images/icon_drop.gif"/>
  {else if }
  <img  title="禁用" name="{$text2_list.text2_sn}" id="jinyong"  src="images/yes.gif" />&nbsp;
  <img  title="修改" name="{$text2_list.text2_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <img id="delete" name="{$text2_list.text2_sn}" title="删除" src="images/icon_drop.gif"/>
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


{if $fall==e_text2}
<form action="text2.php?act=post" method="POST">
<table class="table" width="100%" border="0">
    <tr><td colspan="2"><b>编辑文本模板</b></td></tr>
  <tr><td>代码:</td><td><input   type="text2"  value="{$list_mx.text2_sn}"  disabled="true"readonly="true"/><input name="text2_sn" id="text2_sn"  type="hidden"  value="{$list_mx.text2_sn}" /><a style="color:red;">*</a></td></tr>
  <tr><td>名称:</td><td><input name="title"  id="title" type="text2" value="{$list_mx.title}" /><a style="color:red;">*</a></td></tr>
  <tr><td>内容:</td><td><textarea name="text2" id="text2" style="width:300px;height:150px;" >{$list_mx.text2}</textarea></td></tr>
  <tr><td>排序:</td><td><input name="sort_no"  id="sort_no" type="text2"  value="{$list_mx.sort_no}"/></td></tr>
  <tr><td>事件类型:</td><td>
      <select name="type">
        <option>未定义</option>
        <option>aaa</option>
        <option>bbb</option>
      </select>
  </td> 
  </tr>
  
  <tr><td colspan="2"  style="text-align: center;"><input  id="queding" type="submit" value="确定"/>&nbsp;<input  type="button" value="取消" id="quxiao" onclick="location='text2.php'"/></td></tr>
</table>
</form>
{/if}



{if $fall==a_text2}
<form action="text2.php?act=i_text2" method="POST">
<table class="table" width="100%" border="0">
    <tr><td colspan="2"><b>添加文本模板</b></td></tr>
  <tr><td>代码:</td><td><input name="text2_sn" id="text2_sn"  type="text2" /><a style="color:red;">*</a></td></tr>
  <tr><td>名称:</td><td><input name="title"  id="title" type="text2" /><a style="color:red;">*</a></td></tr>
  <tr><td>内容:</td><td><textarea name="text2" id="text2" style="width:300px;height:150px;"></textarea></td></tr>
  <tr><td>排序:</td><td><input name="sort_no"  id="sort_no" type="text2" /></td></tr>
  <tr><td>事件类型:</td><td>
      <select name="type">
        <option>未定义</option>
        <option>aaa</option>
        <option>bbb</option>
      </select>
  </td> 
  </tr>
  
  <tr><td colspan="2"  style="text-align: center;"><input  id="queding" type="submit" value="确定"/>&nbsp;<input  type="button" value="取消" id="quxiao" onclick="location='text2.php'"/></td></tr>
</table>
</form>
{/if}





{if $fall==i_staus}
<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>添加文本模板</b></td></tr>
 <tr><td>{$val}<a href="text2.php">返回</a></td></tr>
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
     $("#text2_sn").focus();
       $("#queding").click(function(){
           if(jQuery.trim($("#text2_sn").attr('value'))=='' )
        {
            
            $("#text2_sn").focus();
            return false;
        }
         else if(jQuery.trim($("#title").attr('value'))=='' )
         {
             
            $("#title").focus();
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
             
              htmlobj=$.ajax({url:"text2.php?act=ed_status&qiyong="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responsetext2);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        
        
         $("img[id='jinyong']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("name"))){
             
              htmlobj=$.ajax({url:"text2.php?act=ed_status&jinyong="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responsetext2);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
          $("img[id='delete']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("删除"+$(this).attr("name"))){
             
              htmlobj=$.ajax({url:"text2.php?act=ed_status&delete="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responsetext2);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        
        
        $("img[id='edit']").each(function (){
            
           $(this).click(function (){
        
           window.location='text2.php?act=e_text2&edit='+encodeURI(encodeURI($(this).attr("name")));
           
           
        })
        })
        
        
        
    
})
-->
</script>
