<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<style type="text/css">
<!--
	.table tr td p{margin:0px 0 0 0;padding:0;text-indent:0em;line-height:150%;}
-->
</style>
</head>

<body>

<div class="container">
  <div class="content">
  
 
 
   <div class="botable">
{if $fall==1}


   
    <table class="table" width="100%" border="0" style="margin-bottom: 7px;">

 <form>
 <tr>
 <th style="text-align: left;border-right-style:none"><input id="a_text" value="添加角色" type="button" onclick="location='role.php?act=add_role_list'" />&nbsp;<input id="down_hy" value="头像下载" type="hidden" /></th>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>


 </form>
</table>

    


   <table class="table" width="100%" border="0">
   
   <tr>
   <th >角色代码</th>
   <th>角色名称</th>
   <!--<th>URL</th>-->
    <th>包含用户</th>
 

   <th>操作</th>
   
   
   
   </tr>
<tbody  id="table_t">
{foreach from=$role_list item=role}
    <tr>
    
        <td  >{$role.role_sn}</td>
        <td >{$role.role_name}</td>
        <td >
        {foreach from=$role.u_list item=u_list}
        <p>{$u_list.user_sn}({$u_list.user_name})</p>
        
        {/foreach}
        </td>
        
    
    
    
    
        <td  align="center"   style="width:120px">
        {if $role.tzsy==1}<img id="tzsy_qy" alt="0" title="{$role.role_sn}"  src="images/no.gif"/>{else}<img id="tzsy_jy"  title="{$role.role_sn}" alt="1" src="images/yes.gif"/>{/if}
        &nbsp;
        {if $role.tzsy==1}<img  title="修改角色" name="{$role.role_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;&nbsp;&nbsp;<img  title="权限" name="{$role.role_sn}" id="quanxian"  src="images/config.png" />&nbsp;&nbsp;&nbsp;<img id="delete_role"  alt="{$role.role_sn}" name="{$role.role_sn}" title="删除" src="images/icon_drop.gif"/>&nbsp;&nbsp;&nbsp;{else if } <img  title="修改角色" name="{$role.role_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;&nbsp;&nbsp;<img  title="权限" name="{$role.role_sn}" id="quanxian"  src="images/config.png" />&nbsp;{/if}</td>        
    
    </tr>
{foreachelse}
<tr><td class="no-records" colspan="4">无记录</td></tr>
{/foreach}
</tbody>
</table>


<table class="table" width="100%" border="0">
<tr><td style="text-align: right;">{include file="foot.tpl"}</td></tr> 
</table>


{/if}


{if $fall==2}




    

<form method="POST" action="role.php?act=role_post">
   <table class="table" width="100%" border="0">
   
        <tr><td colspan="4" style="background-color:    #E8E8E8;"><b>全选&nbsp;&nbsp;&nbsp;<input  type="checkbox" id="checkall"  name="checkall"/></b></td></tr>
      <tr><td colspan="4" style="background-color:    #d6e7fc;"><b>微信</b></td></tr>
      <input name="role_sn"  value="{$role_sn}" type="hidden"/>
        <tr>
            <td style="width:150px;"><input  type="checkbox" class="checkthis"  name="checkthis"/>&nbsp;&nbsp;&nbsp;自动回复</td>
            <td>
            {foreach from=$list item=list}
            {if $list.sort_no==1}
            <span style="width:200px;"> {if $list.val==1}<input  type="checkbox" name='chk_list' checked="checked"  />{else}<input  name='chk_list' type="checkbox"   />{/if}&nbsp;&nbsp;&nbsp;{$list.action_name}&nbsp;&nbsp;&nbsp;
             <input  type="hidden" value="{$list.val}"  name="listval[]" id="listval"/>
             <input  type="hidden" value="{$list.act_id}"  name="act_id[]"/>
             </span>
            {/if}
            {/foreach}
            </td>
        </tr>
         <tr>
            <td style="width:150px;"><input  type="checkbox" class="checkthis"  name="checkthis"/>&nbsp;&nbsp;&nbsp;模板设置</td>
            <td>
            {foreach from=$list item=list}
            {if $list.sort_no==2}
            <span style="width:200px;"> {if $list.val==1}<input  type="checkbox" name='chk_list' checked="checked"  />{else}<input  name='chk_list' type="checkbox"   />{/if}&nbsp;&nbsp;&nbsp;{$list.action_name}&nbsp;&nbsp;&nbsp;
             <input  type="hidden" value="{$list.val}"  name="listval[]" id="listval"/>
             <input  type="hidden" value="{$list.act_id}"  name="act_id[]" />
             </span>
            {/if}
            {/foreach}
            </td>
        </tr>
        <tr>
            <td style="width:150px;"><input  type="checkbox" class="checkthis"  name="checkthis"/>&nbsp;&nbsp;&nbsp;基础设置</td>
            <td>
            {foreach from=$list item=list}
            {if $list.sort_no==3}
            <span style="width:200px;"> {if $list.val==1}<input  type="checkbox" name='chk_list' checked="checked"  />{else}<input  name='chk_list' type="checkbox"   />{/if}&nbsp;&nbsp;&nbsp;{$list.action_name}&nbsp;&nbsp;&nbsp;
             <input  type="hidden" value="{$list.val}"  name="listval[]" id="listval"/>
             <input  type="hidden" value="{$list.act_id}"  name="act_id[]" />
             </span>
            {/if}
            {/foreach}
            </td>
        </tr>
         <tr>
            <td style="width:150px;"><input  type="checkbox" class="checkthis"  name="checkthis"/>&nbsp;&nbsp;&nbsp;微官网</td>
            <td>
            {foreach from=$list item=list}
            {if $list.sort_no==4}
            <span style="width:200px;"> {if $list.val==1}<input  type="checkbox" name='chk_list' checked="checked"  />{else}<input  name='chk_list' type="checkbox"   />{/if}&nbsp;&nbsp;&nbsp;{$list.action_name}&nbsp;&nbsp;&nbsp;
             <input  type="hidden" value="{$list.val}"  name="listval[]" id="listval"/>
             <input  type="hidden" value="{$list.act_id}"  name="act_id[]" />
             </span>
            {/if}
            {/foreach}
            </td>
        </tr>
        <tr>
            <td style="width:150px;"><input  type="checkbox" class="checkthis"  name="checkthis"/>&nbsp;&nbsp;&nbsp;小店</td>
            <td>
            {foreach from=$list item=list}
            {if $list.sort_no==5}
            <span style="width:200px;"> {if $list.val==1}<input  type="checkbox" name='chk_list' checked="checked"  />{else}<input  name='chk_list' type="checkbox"   />{/if}&nbsp;&nbsp;&nbsp;{$list.action_name}&nbsp;&nbsp;&nbsp;
             <input  type="hidden" value="{$list.val}"  name="listval[]" id="listval"/>
             <input  type="hidden" value="{$list.act_id}"  name="act_id[]"/>
             </span>
            {/if}
            {/foreach}
            </td>
        </tr>
        
      <tr><td colspan="4" style="background-color:    #d6e7fc;"><b>会员管理</b></td></tr>
        <tr>
            <td style="width:150px;"><input  type="checkbox" class="checkthis"  name="checkthis"/>&nbsp;&nbsp;&nbsp;会员中心</td>
            <td>
            {foreach from=$list item=list}
            {if $list.sort_no==7}
            <span style="width:200px;"> {if $list.val==1}<input  type="checkbox" name='chk_list' checked="checked"  />{else}<input  name='chk_list' type="checkbox"   />{/if}&nbsp;&nbsp;&nbsp;{$list.action_name}&nbsp;&nbsp;&nbsp;
             <input  type="hidden" value="{$list.val}"  name="listval[]" id="listval"/>
             <input  type="hidden" value="{$list.act_id}"  name="act_id[]" />
             </span>
            {/if}
            {/foreach}
            </td>
        </tr>
         <tr>
            <td style="width:150px;"><input  type="checkbox" class="checkthis"  name="checkthis"/>&nbsp;&nbsp;&nbsp;消息管理</td>
            <td>
            {foreach from=$list item=list}
            {if $list.sort_no==8}
            <span style="width:200px;"> {if $list.val==1}<input  type="checkbox" name='chk_list' checked="checked"  />{else}<input  name='chk_list' type="checkbox"   />{/if}&nbsp;&nbsp;&nbsp;{$list.action_name}&nbsp;&nbsp;&nbsp;
             <input  type="hidden" value="{$list.val}"  name="listval[]" id="listval"/>
             <input  type="hidden" value="{$list.act_id}"  name="act_id[]"/>
             </span>
            {/if}
            {/foreach}
            </td>
        </tr>
        <tr>
            <td style="width:150px;"><input  type="checkbox" class="checkthis"  name="checkthis"/>&nbsp;&nbsp;&nbsp;二维码管理</td>
            <td>
            {foreach from=$list item=list}
            {if $list.sort_no==9}
          <span style="width:200px;"> {if $list.val==1}<input  type="checkbox" name='chk_list' checked="checked"  />{else}<input  name='chk_list' type="checkbox"   />{/if}&nbsp;&nbsp;&nbsp;{$list.action_name}&nbsp;&nbsp;&nbsp;
             <input  type="hidden" value="{$list.val}"  name="listval[]" id="listval"/>
             <input  type="hidden" value="{$list.act_id}"  name="act_id[]"/>
             </span>
            {/if}
            {/foreach}
            </td>
        </tr>
        
      <tr><td colspan="4" style="background-color:    #d6e7fc;"><b>基础档案</b></td></tr>
        <tr>
            <td style="width:150px;"><input  type="checkbox" class="checkthis"  name="checkthis"/>&nbsp;&nbsp;&nbsp;商品信息</td>
            <td>
            {foreach from=$list item=list}
            {if $list.sort_no==10}
           <span style="width:200px;"> {if $list.val==1}<input  type="checkbox" name='chk_list' checked="checked"  />{else}<input  name='chk_list' type="checkbox"   />{/if}&nbsp;&nbsp;&nbsp;{$list.action_name}&nbsp;&nbsp;&nbsp;
             <input  type="hidden" value="{$list.val}"  name="listval[]" id="listval"/>
             <input  type="hidden" value="{$list.act_id}"  name="act_id[]" />
             </span>
            {/if}
            {/foreach}
            </td>
        </tr>
         <tr>
            <td style="width:150px;"><input  type="checkbox" class="checkthis"  name="checkthis"/>&nbsp;&nbsp;&nbsp;系统设置</td>
            <td>
            {foreach from=$list item=list}
            {if $list.sort_no==11}
            <span style="width:200px;"> {if $list.val==1}<input  type="checkbox" name='chk_list' checked="checked"  />{else}<input  name='chk_list' type="checkbox"   />{/if}&nbsp;&nbsp;&nbsp;{$list.action_name}&nbsp;&nbsp;&nbsp;
             <input  type="hidden" value="{$list.val}"  name="listval[]" id="listval"/>
             <input  type="hidden" value="{$list.act_id}"  name="act_id[]"/>
             </span>
            {/if}
            {/foreach}
            </td>
        </tr>
        
      
</table>
   <div align="center" style="padding: 10px;"><input  type="submit"  class="bttn"  id="btn_queren2" value="确认" />&nbsp;<input  type="button"  class="bttn"   onclick="location='role.php'" value="返回" /></div>
	</div>
 </form>

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
     $("img[id='edit']").each(function (){
            
            $(this).click(function (){
               location.href = "role.php?act=edit&role_sn="+encodeURI(encodeURI($(this).attr("name")));
            })
        })
        
        $("img[id='quanxian']").each(function (){
            
            $(this).click(function (){
               location.href = "role.php?act=set_role&role_sn="+encodeURI(encodeURI($(this).attr("name")));
            })
        })
        
        
        
           $("img[id='delete_role']").each(function (){
            
            $(this).click(function (){
        
            
              if(confirm("删除"+$(this).attr("name")+"角色？")){
               htmlobj=$.ajax({url:"role.php?act=delete_role&role_sn="+encodeURI(encodeURI($(this).attr("name"))),async:false});
             // alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
            })
        })
        
     
        
        $("img[id='tzsy_jy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("title")+"角色?")){
             
              htmlobj=$.ajax({url:"role.php?act=role_xs&role_code="+encodeURI(encodeURI($(this).attr("title")))+"&alt="+$(this).attr("alt"),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        $("img[id='tzsy_qy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("启用"+$(this).attr("title")+"角色?")){
             
              htmlobj=$.ajax({url:"role.php?act=role_xs&role_code="+encodeURI(encodeURI($(this).attr("title")))+"&alt="+$(this).attr("alt"),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        
        
        $("#checkall").click(function(){
            var arrChk=$("input[name='checkall']:checked");
            
           
            
            for (var i=0;i<arrChk.length;i++)
            {
               
                if(arrChk[i].value=='on')
                {
                  
                    $("input[name='chk_list']").attr("checked",true); 
                    $("input[name='chk_list']").each(function(){$(this).parent().find("#listval").val(1);
                    
                    })
                    $("input[name='checkthis']").attr("checked",true);  
                }
              
            }
            if(arrChk.length==0)
            {
                $("input[name='chk_list']").attr("checked",false);  
                $("input[name='chk_list']").each(function(){$(this).parent().find("#listval").val(0);
                
                })
                $("input[name='checkthis']").attr("checked",false);
            }
            
          
           
            
            
        })
        //单个按钮按下修改值
        $("input[name='chk_list']").each(function(){
            
            $(this).click(function(){
                if($(this).attr("checked")=="checked")
                {
                    $(this).parent().find("#listval").val(1);
                    
                }else
                {
                    $(this).parent().find("#listval").val(0);
                   
                }
                //返回值
                //alert( $(this).parent().find("#listval").val());  
            })
          
        })
      
        
        
        $(".checkthis").each(function(){
            $(this).click(function(){
                if($(this).attr("checked")=="checked")
                {
                    var aaa=   $(this).parent().parent().find("input[name='chk_list']");
                    for (var i=0;i<aaa.length;i++)
                    {
                    
                        if(aaa[i].value=='on')
                        {
                          
                            aaa.attr("checked",true);  
                        }
                        
                    
                    }
                    aaa.each(function(){$(this).parent().find("#listval").val(1);
                            
                        })
                }else
                {
                    var aaa=   $(this).parent().parent().find("input[name='chk_list']");
                    for (var i=0;i<aaa.length;i++)
                    {
                    
                        if(aaa[i].value=='on')
                        {
                          
                            aaa.attr("checked",false);  
                        }
                     
                    
                    }
                    aaa.each(function(){$(this).parent().find("#listval").val(0);
                            
                        })
                }
              
                
                 
                 

            })
        })
    
})
-->
</script>
