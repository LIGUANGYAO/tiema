<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>

</head>

<style type="text/css">
<!--
    .table tr td p{margin:0px 0 0 0;padding:0;text-indent:0em;line-height:150%;}
    .alert{filter:alpha(opacity=20); /* IE */ -moz-opacity:0.2; /* Moz + FF */ opacity: 0.2; height:200%; width:100%; background:; left:0%; top:0%;margin-top:-0px;margin-left:-0px;position:absolute;z-index:99; text-align:center; padding:0px;}
	#leavemsg{left:20%; top:20%;margin-top:-0px;margin-left:-0px;position:absolute;z-index:99; text-align:center; padding:0px;
	width:500px;
	height:300px;
	border:0px solid #008800;}
-->
</style>
<body>

<div class="container">
  <div class="content">
  
 
 
   <div class="botable">
{if $fall==1}


   

 <table class="table" width="100%" border="0" style="margin-bottom: 7px;">

 <form>
 <tr>
 <th style="text-align: left;border-right-style:none"><input id="a_text" value="添加推送" type="button" onclick="location='appsend.php?act=add_appsend_list'" />&nbsp;<input id="down_hy" value="头像下载" type="hidden" /></th>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>


 </form>
</table>

   <table class="table" width="100%" border="0">
   
   <tr>
   <th >推送代码</th>
   <th>推送名称</th>
   <th>类型</th>
   <th>进度</th>
   <th>会员组</th>
   <th>日期</th>

  
   <th>操作</th>
   </tr>
<tbody  id="table_t">
   {foreach from=$appsend_list item=appsend_list}
  <tr>
  <td style="width:70px">{$appsend_list.appsend_sn}</td>
  <td style="width:140px">{$appsend_list.appsend_name}</td>
  <td style="width:100px">{if $appsend_list.re_type=="text"}文本__{$appsend_list.re_code}{elseif $appsend_list.re_type=="imgtext"}图文__{$appsend_list.re_code}{else}{/if}</td>
  <td  title="">
 
     <p style="float: left;width:100px">发送数:&nbsp;{$appsend_list.send_sum.sum}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p><p style="float: left;width:100px;">已发送:<a style="color:green">&nbsp;{$appsend_list.send_sum.send_sum}</a>&nbsp;&nbsp;&nbsp;&nbsp;</p><p>未发送:<a style="color:red">&nbsp;{$appsend_list.send_sum.unsend_sum}</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p><p style="float: left;width:100px;">发送成功:&nbsp;{$appsend_list.send_sum.send_su}&nbsp;&nbsp;&nbsp;&nbsp;</p><p>未交互:&nbsp;{$appsend_list.send_sum.timeout}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
  </td>
   <td style="width:70px">{if $appsend_list.role=="All"}全部{else}{$appsend_list.role}{/if}</td>
  <td style="width:150px"><p>{$appsend_list.rq}</p></td>

 
  
  <td style="width:70px"> 
  {if $appsend_list.tzsy==0}
   <img  title="验收" name="{$appsend_list.appsend_sn}" id="tzsy_jy"  src="images/yanshou.png" />&nbsp;
  <img  title="查看" name="{$appsend_list.appsend_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  <img id="delete_appsend" name="{$appsend_list.appsend_sn}" title="删除" src="images/icon_drop.gif"/>
  {else if }
  <!--<img  title="禁用" name="{$appsend_list.appsend_sn}" id="tzsy_jy"  src="images/yanshou.png" />&nbsp;-->
  <img  title="查看" name="{$appsend_list.appsend_sn}" id="edit"  src="images/icon_edit.gif" />&nbsp;
  
   <img  title="发送通知" name="{$appsend_list.appsend_sn}" class="send"  src="images/send.gif"  sn="{$appsend_list.appsend_sn}" sl1="{$appsend_list.send_sum.sum}" sl2="{$appsend_list.send_sum.send_sum}" sl3="{$appsend_list.send_sum.unsend_sum}" re_code="{$appsend_list.re_code}" re_type="{$appsend_list.re_type}" role="{$appsend_list.role}"/>&nbsp;
  <!--<img id="delete_appsend" name="{$appsend_list.appsend_sn}" title="删除" src="images/icon_drop.gif"/>-->
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


<!--弹出层 end-->
<div class="alert" style="display:none;">

</div>
<div id="leavemsg" style="display:none;">
<input type="hidden" id="leaveid"/><input type="hidden" id="leavename"/>
<table class="table" width="100%" border="0" style="margin-bottom: 7px;">
<tr><th colspan="3" style="text-align: center;" >发送进度</th></tr>
<tr><th  >活动</th><td colspan="2" id="huodongsn" ></td></tr>
<tr style="height:40px;"><th style="width:70px;" >详情</th><td colspan=""> <p style="float: left;width:100px">发送数:<a id="a_sl1"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p><p style="float: left;width:100px;">已发送:<a id="a_sl2" style="color:green">&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;</p><p>未发送:<a id="a_sl3" style="color:red"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p><p style="float: left;width:100px;">发送成功:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p><p>未交互:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></td>
</tr>

<tr style="height:100px;"><td colspan="2" style="text-align: center;color:red;"  id="errmes"></td></tr>
<tr ><td style="text-align: right;" colspan="3"><input  type="button" id="msgssend" value="开始发送"/><input  type="button" value="取消" id="msgquxiao" /></td></tr>



</table>
</div>
<!--弹出层 end-->

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
     $("#text_sn").focus();
       $("#queding").click(function(){
           if(jQuery.trim($("#text_sn").attr('value'))=='' )
        {
            
            $("#text_sn").focus();
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
       
       
        
        
        $("img[id='edit']").each(function (){
            
           $(this).click(function (){
        
           window.location='appsend.php?act=edit&appsend_sn='+encodeURI(encodeURI($(this).attr("name")));
           
           //window.open('appsend.php?act=edit&appsend_sn='+encodeURI(encodeURI($(this).attr("name"))));
        })
        })
        
        
         $("img[id='delete_appsend']").each(function (){
            
            $(this).click(function (){
        
            
              if(confirm("删除"+$(this).attr("name")+"")){
               htmlobj=$.ajax({url:"appsend.php?act=delete_appsend&appsend_sn="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
            })
        })
        
      
        
        
        $("img[id='tzsy_jy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("确定验收"+$(this).attr("name")+"？")){
             
              htmlobj=$.ajax({url:"appsend.php?act=appsend_xs&appsend_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt=1",async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        $("img[id='tzsy_qy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("确定验收"+$(this).attr("name")+"？")){
             
              htmlobj=$.ajax({url:"appsend.php?act=appsend_xs&appsend_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt=0",async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        
        
        //批量发送信息
        
        $(".send").each(function(){
            
             $(this).click(function(){
                $(".alert").fadeIn();
                 $("#leavemsg").fadeIn();
               
      
               $("#huodongsn").text($(this).attr("sn"));
               $("#a_sl1").text($(this).attr("sl1"));
               $("#a_sl2").text($(this).attr("sl2"));
               $("#a_sl3").text($(this).attr("sl3"));
             })
            
        
      })
        $("#msgquxiao").click(function(){
             $(".alert").fadeOut();
             $("#leavemsg").fadeOut();
        })
        
        
        
       
        $("#msgssend").click(function(){
                
                 //var i=0;
                 run();             //加载页面时启动定时器  
                 var interval;                         
                 function run() {  
                      interval = setInterval(chat, "1000");  
                        
                 }  
                 function chat() { 

                        htmlobj=$.ajax({
                        //type:"POST",
                        dataType: "json", 
                       
                        url:"wx_send_msg.php?m=app_send",
                        data:"p_id="+ $("#huodongsn").text()+"&sl3="+ $("#a_sl3").text()+"",
                        //async:false,
                        beforeSend:function(XMLHttpRequest){
                        
                           
                            },
                            success:function(data,textStatus){
                           //alert(data);
                            //i++;
                                if(data.errcode==999999)
                                {   
                                    
                                    clearTimeout(interval);
                                    i=0;
                                    
                                }
                                $("#errmes").text(data.nick_name+"    "+data.errmsg);
                            },
                            complete:function(XMLHttpRequest,textStatus){
                  
                         
                          
                            },
                            error:function(XMLHttpRequest,textStatus,errorThrown){
                         
                            }
                        
                        
                        
                        });


                 } 
                
                
               

        })
    
})
-->
</script>
