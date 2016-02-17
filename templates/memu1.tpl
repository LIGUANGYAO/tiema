<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.8.1.min.js"></script>
</head>

<body>

<div class="container">
  <div class="content">
  
 

   <div class="botable">
  {if $fall==1}
   <table class="table" width="100%" border="0">
   
   <tr><th >排序</th><th>主菜单名称</th><th>触发关键字</th><th>回复模板</th><th>操作&nbsp;<img src="images/icon_add.gif" id="add" /><a style="display: none; color: red;" id="maxmenu">主菜单已经达到3个,无法继续添加</a></th></tr>
   <form  action="memu1.php?act=post" method="POST">
   {foreach from=$menu_list item=menu_list}
   <tr class="mainmemu">
    <td>
   <input class="menu_sn"  style="width:20px"  name="menu_sn[]"  value="{$menu_list.menu_sn}" type="hidden" />
   <input class="input_sort"  style="width:20px"  name="sort_no[]"  value="{$menu_list.sort_no}" type="text" />
    </td>
    <td>
    <input  name="name[]"  value="{$menu_list.name}" maxlength="10" class="input_memu" type="text" /><img src="images/icon_add.gif" title="添加子菜单" name="{$menu_list.menu_sn}" bt_count="{$menu_list.bt_count}" class="submenu" />
    </td>

    <td>    <input   name="m_key[]"  maxlength="10" value="{$menu_list.m_key}" class="input_memu" type="text" /></td>
     <td>   <select  name="type[]" id="type" class="type" index1="{$menu_list.re_type}" style="width: 150px;"> 
            <option value="">请选择</option>
            <option value="text">文本</option>
            <option value="imgtext">图文</option>
            <option value="html">HTML</option>
            <option value="url">URL</option>
            
              <!-- 20141103-->
                <option value="scancode_push" title="用户点击按钮后，微信客户端将调起扫一扫工具，完成扫码操作后显示扫描结果（如果是URL，将进入URL），且会将扫码的结果传给开发者，开发者可以下发消息。">
                扫一扫事件</option>
                <option value="scancode_waitmsg" title="用户点击按钮后，微信客户端将调起扫一扫工具，完成扫码操作后，将扫码的结果传给开发者，同时收起扫一扫工具，然后弹出“消息接收中”提示框，随后可能会收到开发者下发的消息。">
                扫描后返回公众号</option>
                <option value="pic_sysphoto" title="用户点击按钮后，微信客户端将调起系统相机，完成拍照操作后，会将拍摄的相片发送给开发者，并推送事件给开发者，同时收起系统相机，随后可能会收到开发者下发的消息。">
                弹出系统拍照发图</option>
                <option value="pic_photo_or_album" title="用户点击按钮后，微信客户端将弹出选择器供用户选择“拍照”或者“从手机相册选择”。用户选择后即走其他两种流程。">
                弹出拍照或者相册发图</option>
                <option value="pic_weixin" title="用户点击按钮后，微信客户端将调起微信相册，完成选择操作后，将选择的相片发送给开发者的服务器，并推送事件给开发者，同时收起相册，随后可能会收到开发者下发的消息。">
                弹出微信相册发图器</option>
                <option value="location_select" title="用户点击按钮后，微信客户端将调起地理位置选择工具，完成选择操作后，将选择的地理位置发送给开发者的服务器，同时收起位置选择工具，随后可能会收到开发者下发的消息。">
                弹出地理位置选择器</option>
       </select>
       &nbsp;
        <select  name="type2[]" id="type2" class="type2"  index1="{$menu_list.re_code}" style="width: 150px;"> 
            <option value="">请选择</option>
      
       </select>
        </td>
     <td>
     
     <img id="delete" name="{$menu_list.menu_sn}" name2="{$menu_list.name}" title="删除" src="images/icon_drop.gif"/>
     </td>
  </tr>
        {foreach from=$menu_list.sub_button item=sub_button}
        <tr>
        <td><input class="menu_sn"  style="width:20px"  name="menu_sn[]"  value="{$sub_button.menu_sn}" type="hidden" />&nbsp;&nbsp;&nbsp;&nbsp;<input class="input_sort"  style="width:20px"  name="sort_no[]"   value="{$sub_button.sort_no}" type="text" /></td>
        <td>﹂<input  maxlength="10" value="{$sub_button.name}"  name="name[]"   class="input_memu" type="text" /></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;<input  maxlength="10"  value="{$sub_button.m_key}" name="m_key[]"  class="input_memu" type="text" /></td>  
        <td>  
            &nbsp;&nbsp;&nbsp;&nbsp;<select  name="type[]" id="type" class="type" index1="{$sub_button.re_type}" style="width: 150px;"> 
                <option value="">请选择</option>
                <option value="text">文本</option>
                <option value="imgtext">图文</option>
                <option value="html">HTML</option>
                <option value="url">URL</option>
                
                
                 <!-- 20141103-->
                <option value="scancode_push" title="用户点击按钮后，微信客户端将调起扫一扫工具，完成扫码操作后显示扫描结果（如果是URL，将进入URL），且会将扫码的结果传给开发者，开发者可以下发消息。">
                扫一扫事件</option>
                <option value="scancode_waitmsg" title="用户点击按钮后，微信客户端将调起扫一扫工具，完成扫码操作后，将扫码的结果传给开发者，同时收起扫一扫工具，然后弹出“消息接收中”提示框，随后可能会收到开发者下发的消息。">
                扫描后返回公众号</option>
                <option value="pic_sysphoto" title="用户点击按钮后，微信客户端将调起系统相机，完成拍照操作后，会将拍摄的相片发送给开发者，并推送事件给开发者，同时收起系统相机，随后可能会收到开发者下发的消息。">
                弹出系统拍照发图</option>
                <option value="pic_photo_or_album" title="用户点击按钮后，微信客户端将弹出选择器供用户选择“拍照”或者“从手机相册选择”。用户选择后即走其他两种流程。">
                弹出拍照或者相册发图</option>
                <option value="pic_weixin" title="用户点击按钮后，微信客户端将调起微信相册，完成选择操作后，将选择的相片发送给开发者的服务器，并推送事件给开发者，同时收起相册，随后可能会收到开发者下发的消息。">
                弹出微信相册发图器</option>
                <option value="location_select" title="用户点击按钮后，微信客户端将调起地理位置选择工具，完成选择操作后，将选择的地理位置发送给开发者的服务器，同时收起位置选择工具，随后可能会收到开发者下发的消息。">
                弹出地理位置选择器</option>
                
            </select>
            &nbsp;
            <select  name="type2[]" id="type2" class="type2"  index1="{$sub_button.re_code}"  style="width: 150px;"> 
                <option value="">请选择</option>
            
            </select>
        </td>
        <td>
        
     <img id="delete" name="{$sub_button.menu_sn}" name2="{$sub_button.name}" title="删除" src="images/icon_drop.gif"/>
        </td></tr>
        {/foreach}
   {/foreach}
  
  
</table>
<table class="table" width="100%" border="0">
  <tr><td><input id="save" value="保存" type="submit" />&nbsp;&nbsp; </td></tr>
  </form>
   <tr><td style="text-align: right;"><!--<input id="xzcd" value="下载菜单" type="button" />-->&nbsp;&nbsp;<input id="sccd" value="上传菜单" type="button" /></td></tr>
   
 

  
</table>
{/if}

{if $fall==2}
<table class="table" width="100%" border="0">
 <tr><td colspan="1"><b>编辑自定义菜单</b></td></tr>
 <tr><td>{$val}<a href="memu1.php">返回</a></td></tr>
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
   
   
      $(".submenu").live("click",function () {
     
            
             
             if($(this).attr("bt_count")>=5)
        {
            
            //$("#maxmenu").css("display","block");
         
            return false;
            
        }
        else
        {
             htmlobj=$.ajax({url:"memu1.php?act=add_menu_list&type=2&p_id="+encodeURI(encodeURI($(this).attr("name"))),async:false});
             $(this).attr("disabled",false);
             //alert(htmlobj.responseText);
             window.location.reload();
        }
             
             
           
     
     
      // $(this).parent().parent().after("<tr><td></td><td>﹂<input  maxlength="+"5"+"    class="+"input_memu"+" type="+"text"+" /></td><td><input  maxlength="+"5"+"    class="+"input_memu"+" type="+"text"+" /></td><td><input value="+"保存"+" type="+"button"+" />&nbsp;&nbsp;<input value="+"取消"+" type="+"button"+" /></td></tr>");
       })

     $("#add").click(function(){
     
    
        
        var ilen='';
        ilen=$(".mainmemu").length;
        //alert(ilen);
        if(ilen>2)
        {
            
            //$("#maxmenu").css("display","block");
         
            return false;
            
        }
        else
        {
             htmlobj=$.ajax({url:"memu1.php?act=add_menu_list&type=1&p_id=0",async:false});
             // alert(htmlobj.responseText);
             $(this).attr("disabled",false);
             window.location.reload();
          
            
           //var memuid='memu'+ilen;
//           //alert(memuid);
//            $(".table").append("<tr name="+"memuid"+" class="+"mainmemu"+"><td><input class="+"input_sort"+" value="+"0"+"  type="+"text"+" /></td><td><input maxlength="+"5"+"   class="+"input_memu"+" type="+"text"+" /><img src="+"images/icon_add.gif"+" title="+"添加子菜单"+" class="+"submenu"+"  /></td><td><input  maxlength="+"5"+"    class="+"input_memu"+" type="+"text"+" /></td><td><input value="+"保存"+" type="+"button"+" />&nbsp;&nbsp;<input value="+"取消"+" type="+"button"+" /></td></tr>");
        
       
        }
    
     });
        
        $("#xzcd").click(function(){
            
        
        htmlobj=$.ajax({type:"POST",
        url:"get_menu.php",
        async:false});
        
        
        //alert(htmlobj.responseText);
          window.location.reload();
        })
        
        $("#sccd").click(function(){
            
        
        htmlobj=$.ajax({type:"POST",
        url:"get_menu.php?act=edit_menu",
        async:false});
        
        
        alert(htmlobj.responseText);
        })
        
        
        //保存，删除
        $("img[id='qiyong']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("启用"+$(this).attr("name"))){
             
              htmlobj=$.ajax({url:"text.php?act=ed_status&qiyong="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        
        
        
        
        
        //二级列表
        
        $('.type').each(function (){
                $(this).change(function (){
                
                //htmlobj=$.ajax({
//                type:"POST",dataType: "json", 
//                url:"memu1.php?act=get_type",
//                data:{"type":$(this).val()},async:false,
//                beforeSend:function(XMLHttpRequest){
//                    
//                   
//                    },
//                    success:function(data,textStatus){
//                    
//                    
//                    },
//                    complete:function(XMLHttpRequest,textStatus){
//                  
//                  
//                    },
//                    error:function(XMLHttpRequest,textStatus,errorThrown){
//                 
//                    }
//                
//                
//                
//                });
                
                var json='';
                //省选择清空市，市选择清空区
                htmlobj=$.ajax({url:"memu1.php?act=get_type&type="+encodeURI(encodeURI($(this).val())),async:false,dataType: 'json'}); 
                json = $.parseJSON(htmlobj.responseText); 
                 //alert(htmlobj.responseText);
                
               $(this).parent().find(".type2").empty();
                $("<option >请选择</option>").appendTo($(this).parent().find(".type2"));
                  var   aaa=$(this).parent().find('.type2');
                $.each(json, function (i, n) {  
            
                    $("<option value=" + n.sn + ">"+ n.sn + "___"+ n.name + "</option>").appendTo(aaa);  
                });  
                
                //alert($(this).find("option:selected").text());     
                })
                
                
                 $(this).val($(this).attr("index1"));
                if($(this).val()!='')
                {
                      $(this).change(); 
                      
                      $(this).parent().find(".type2").val($(this).parent().find(".type2").attr("index1"));
                }
            
 
        })
        

        
        
        
        $("img[id='delete']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("是否删除  "+$(this).attr("name2"))){
             
              htmlobj=$.ajax({url:"memu1.php?act=delete&menu_sn="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        

})
-->
</script>
