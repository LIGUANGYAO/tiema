<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/Calendar3.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>

</head>
<style type="text/css">
<!--
	    .table tr td p{margin:0px 0 0 0;padding:0;text-indent:0em;line-height:150%;}
        .alert{filter:alpha(opacity=20); /* IE */ -moz-opacity:0.2; /* Moz + FF */ opacity: 0.2; height:200%; width:100%; background:; left:0%; top:0%;margin-top:-0px;margin-left:-0px;position:absolute;z-index:99; text-align:center; padding:0px;}
        #leavemsg{left:20%; top:80px;margin-top:-0px;margin-left:-0px;position:absolute;z-index:99; text-align:center; padding:0px;
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
 <th style="text-align: left;border-right-style:none">&nbsp;<input id="down_hy" value="头像下载" type="hidden" /></th>
 <th style="text-align: right; border-left-style:none">&nbsp;下单时间:
   <input  class="t1" value="{$th_time}" name="t1" type="text" id="control_date" size="20" maxlength="10" onclick="new Calendar().show(this)" readonly="readonly" />~下单结束时间: <input  class="t2" value="{$now_time}" name="t2" type="text" id="control_date2" size="20" maxlength="10" onclick="new Calendar().show(this)" readonly="readonly" />&nbsp;

 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;
 
<input  value="导出excel" type="button" id="excel" />
 </th>
 
 </tr>


 </form>
</table>

    


   <table class="table" width="100%" border="0">
   
   <tr>
    <th >来源</th>
  
    <th >昵称</th>
   <th>联系人/手机</th>
  
    <th>email</th>
    <th>地址</th>
    <th>留言</th>
    
    <th>时间</th>
    <th>操作</th>
   </tr>
<tbody  id="table_t">
   {foreach from=$wx_lv_msg_list item=wx_lv_msg_list}
  <tr>
  
  
   <td ><p>{$wx_lv_msg_list.type}</p><p>{$wx_lv_msg_list.cj_sn}/{$wx_lv_msg_list.cj_name}</p></td>

  <td  style="width:100px">{$wx_lv_msg_list.nick_name}<!--<p>{$wx_lv_msg_list.openid}</p>--></td>
  <td ><p>{$wx_lv_msg_list.name}</p><p>{$wx_lv_msg_list.tel}</p></td>
 
  <td >{$wx_lv_msg_list.email}</td>
  <td >{$wx_lv_msg_list.address}</td>
  <td >{$wx_lv_msg_list.note}</td>
  <td >{$wx_lv_msg_list.add_time}</td>
    <td style="width:50px"> 
  {if $wx_lv_msg_list.tzsy==0}
  <img  title="审核" name="{$wx_lv_msg_list.nick_name}" op="{$wx_lv_msg_list.openid}" openid="{$wx_lv_msg_list.openid}" nick_name="{$wx_lv_msg_list.nick_name}" id="tzsy_jy"  src="images/yanshou.png" />&nbsp;
  <img src="images/icon_title.gif" class="lmsg"  openid="{$wx_lv_msg_list.openid}" nick_name="{$wx_lv_msg_list.nick_name}" title="留言" />
  {else if }
    <img src="images/icon_title.gif" class="lmsg"  openid="{$wx_lv_msg_list.openid}" nick_name="{$wx_lv_msg_list.nick_name}" title="留言" />
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


</div>
   <!-- end .content --></div>
<!-- end .container --></div>


<!--隐藏层 -->
<div class="alert" style="display:none;">

</div>
<div id="leavemsg" style="display:none;">
<input type="hidden" id="leaveid"/><input type="hidden" id="leavename"/>
<table class="table" width="100%" border="0" style="margin-bottom: 7px;">
<tr><th colspan="2" style="text-align: center;" >发送信息</th></tr>
<tr><td style="width:70px">接收人</td><td id="ni_name"></td></tr>
<tr><th colspan="2">发送类型 图文/文本</th></tr>
<tr><th colspan="2">内容</th></tr>
<tr style="height:100px"><td colspan="2"><textarea  id="neirong" style="height:100px;width:500px;">{$lv_msg.bz}</textarea></td></tr>
<tr ><td style="text-align: right;" colspan="2"><input  type="button" id="msgsend" value="发送"/><input  type="button" value="取消" id="msgquxiao" /></td></tr>


<tr><th colspan="2" style="text-align: center;color:red;"  id="errmes"></th></tr>
</table>
</div>
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
        
           window.location='wx_lv_msg.php?act=edit&wx_lv_msg_sn='+encodeURI(encodeURI($(this).attr("name")));
           
           
        })
        })
        
        
         $("img[id='delete_wx_lv_msg']").each(function (){
            
            $(this).click(function (){
        
            
              if(confirm("删除"+$(this).attr("name")+"")){
               htmlobj=$.ajax({url:"wx_lv_msg.php?act=delete_wx_lv_msg&wx_lv_msg_sn="+encodeURI(encodeURI($(this).attr("name"))),async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
            })
        })
        
      
        
        
        $("img[id='tzsy_jy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("审核 "+$(this).attr("name")+" 的留言")){
             
                htmlobj=$.ajax({url:"wx_lv_msg.php?act=wx_lv_msg_xs&wx_lv_msg_code="+encodeURI(encodeURI($(this).attr("op")))+"&alt=1",async:false});
              //alert(htmlobj.responseText);
              //window.location.reload();
                var h1= 80;
                
                
                var h2=parseInt($(document).scrollTop());
                var h3=h1+h2;
                
                $("#leavemsg").css("top",h3+"px");
                
                h3=0;  
                $(".alert").fadeIn();
                $("#leavemsg").fadeIn();
                
                $("#ni_name").text($(this).attr("nick_name"));
                $("#leaveid").val($(this).attr("openid"));
              
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        $("img[id='tzsy_qy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("启用"+$(this).attr("name")+"")){
             
              htmlobj=$.ajax({url:"wx_lv_msg.php?act=wx_lv_msg_xs&wx_lv_msg_code="+encodeURI(encodeURI($(this).attr("name")))+"&alt=0",async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        
     $("#order_status").val("{$status}");
     
    $("#excel").click(function (){
	time = $(".t1").val();
	time2 = $(".t2").val();
	

	

	 window.open("excel.php?m=wx_lv_msg&t1="+time+"&t2="+time2); 
        })
        
        
        
        
        
        //开始测试留言信息
        $(".lmsg").each(function(){
            
             $(this).click(function(){
                
             var h1= 80;
         
       
             var h2=parseInt($(document).scrollTop());
             var h3=h1+h2;
  
             $("#leavemsg").css("top",h3+"px");
            
               h3=0;  
                $(".alert").fadeIn();
                 $("#leavemsg").fadeIn();
               
               $("#ni_name").text($(this).attr("nick_name"));
               $("#leaveid").val($(this).attr("openid"));

             })
            
        
        })
        $("#msgquxiao").click(function(){
             $(".alert").fadeOut();
             $("#leavemsg").fadeOut();
        })
        $("#msgsend").click(function(){
            
          
            
                htmlobj5=$.ajax({
                type:"POST",
                dataType: "json", 
               
                url:"wx_send_msg.php?m=wx_send",
                data:"openid="+ $("#leaveid").val()+"&msg="+$("#neirong").val(),async:false,
                beforeSend:function(XMLHttpRequest){
                
                   
                    },
                    success:function(data,textStatus){
                    //alert(data.errmsg);
                        if(data.errmsg=="token失效")
                        {
                            $("#msgsend").click();
                            $("#errmes").text(data.errmsg);
                            
                        }
                         $("#errmes").text(data.errmsg);
                         $("#msgsend").attr("disabled","disabled");
                         run();             //加载页面时启动定时器  
                         var interval;  
                         
                         function run() {  
                              interval = setInterval(chat, "2000");  
                                
                         }  
                         function chat() { 
                             $("#errmes").text("");
                              $("#msgsend").removeAttr("disabled"); 

                              clearTimeout(interval);
                         } 
                    
                    },
                    complete:function(XMLHttpRequest,textStatus){
          
                 
                  
                    },
                    error:function(XMLHttpRequest,textStatus,errorThrown){
                 
                    }
                
                
                
                });
          //   $(".alert").fadeOut();
//             $("#leavemsg").fadeOut();
        })
        
})
-->
</script>
