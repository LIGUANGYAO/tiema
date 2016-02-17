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
<style type="text/css">
<!--
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
{if $fall==openid}



    
     <table class="table" width="100%" border="0" style="margin-bottom: 7px;">

 <form>
 <tr>
 <th style="text-align: left;border-right-style:none"><input id="down_hy" value="会员下载" type="button" />&nbsp;<input id="down_hy" value="头像下载" type="hidden" /></th>
 <th style="text-align: right; border-left-style:none">
 关注状态(<a  style="color:#749c18">{$getatt_sl.sl1}</a>/<a  style="color:red">{$getatt_sl.sl2}</a>)<select id="is_att" name="is_att">
    <option  value="2">全部</option> 
    <option  value="1">关注中</option>
    <option  value="0">已取消</option>
 </select>&nbsp;
 
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;<input  value="导出excel" type="submit" onclick="window.open('openid.php?act=excel')" /></th>
 
 </tr>


 </form>
</table>

   <table class="table" width="100%" border="0">
   
   <tr><th >状态</th><th >会员代码</th><th>昵称</th><th>openid</th><th>区域</th><th>注册手机号</th><th>添加时间</th><th>最近关注时间</th><th>头像</th></tr>
<tbody  id="table_t">
   {foreach from=$openid_list item=openid_list}
   <tr>
  <tr>
  <td>{if $openid_list.is_att==1}<a  style="color:green">关注</a>{else}<a  style="color:red">取消</a>{/if}</td>
  <td>{$openid_list.users_sn}</td>
  <td>{$openid_list.nick_name}</td>
  <td>{$openid_list.openid}</td>
  <td>{$openid_list.province}  {$openid_list.city}</td>
   <td>{$openid_list.wx_tel}</td>
  <td>{$openid_list.add_time}</td>
  <td>{$openid_list.sub_time}</td>
  <td>{if $openid_list.headimgurl==''}无头像&nbsp;&nbsp;&nbsp;<img src="images/icon_title.gif" class="lmsg" nick_name="{$openid_list.nick_name}" openid="{$openid_list.openid}" title="留言" />
  {elseif $openid_list.headimg_down==1}<img  class="img" url="{$openid_list.openid}"  width="30px" height="30px"/><img src="images/icon_title.gif" class="lmsg"  openid="{$openid_list.openid}" nick_name="{$openid_list.nick_name}" title="留言" />{else}
  <img src="images/img_img.png" class="headimgurl" name="{$openid_list.headimgurl}" n_id="{$openid_list.openid}" />&nbsp;&nbsp;&nbsp;<img src="images/icon_title.gif" class="lmsg"  openid="{$openid_list.openid}" nick_name="{$openid_list.nick_name}" title="留言" />
  {/if}</td>
  
  

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

<div class="alert" style="display:none;">

</div>
<div id="leavemsg" style="display:none;">
<input type="hidden" id="leaveid"/><input type="hidden" id="leavename"/>
<table class="table" width="100%" border="0" style="margin-bottom: 7px;">
<tr><th colspan="2" style="text-align: center;" >发送信息</th></tr>
<tr><td style="width:70px">接收人</td><td id="ni_name"></td></tr>
<tr><th colspan="2">发送类型 图文/文本</th></tr>
<tr><th colspan="2">内容</th></tr>
<tr style="height:100px"><td colspan="2"><textarea  id="neirong" style="height:100px;width:500px;"></textarea></td></tr>
<tr ><td style="text-align: right;" colspan="2"><input  type="button" id="msgsend" value="发送"/><input  type="button" value="取消" id="msgquxiao" /></td></tr>


<tr><th colspan="2" style="text-align: center;color:red;"  id="errmes"></th></tr>
</table>
</div>


{if $fall==down_hy}
<table class="table" width="100%" border="0">
  
   <tr><td style="text-align: center;"><a>总数量&nbsp;个&nbsp;</a><input id="zl_down_openid" value="增量下载" type="button" /><input id="down_openid" value="下载会员" type="button"    />&nbsp;</td></tr>
   <tr><td id="load_img"  style="text-align: center;"></td></tr>
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
   
      
      
        $("#down_openid").click(function(){
         
            run(); 
            run2();            //加载页面时启动定时器  
            var interval;  
            var interval2;
            var ti=5;
            var i=2;
            function run() {  
            
            interval = setInterval(chat, "1000"); 
          
            }  
            function run2(){
                  //interval2 = setInterval(get1, "1"); 
            }
            function chat() {  
            
            
            $("#down_openid").val(ti);
            ti=ti-1; 
            if(ti==-1)
            {
                 clearTimeout(interval); 
                 $("#down_openid").val("下载会员");
                 $("#down_openid").attr("disabled",false);
            }
            //  alert(ti);
            }  
            
            
            function get1()
            {
                 htmlobj=$.ajax({type:"POST",
                    url:"get_Openid.php",
                    async:false,//同步/异步加载
                    data:"id="+i,
                    beforeSend:function(XMLHttpRequest){
                    //alert('远程调用开始...');
                    //$("#load_img").html("<img width='78px' height='47px'  src='images/load.gif'/>");
                     $("#down_openid").attr("disabled",true);
                    },
                    success:function(data,textStatus){
                    
                    //alert(data);
                    
                     $("#load_img").append(data+"<br>");
                     
        
                    
                    },
                    complete:function(XMLHttpRequest,textStatus){
                    // alert('远程调用成功，状态文本值：'+textStatus);
                   
                   // $("#load_img").empty();
                 
                  
                    },
                    error:function(XMLHttpRequest,textStatus,errorThrown){
                    // alert('error...状态文本值：'+textStatus+" 异常信息："+errorThrown);
                    //$("#load_img").empty();
                    }
            });
                i=i-1; 
                if(i==-2)
                {
                     clearTimeout(interval2); 
                }
            }
            
            
            var co='0';
            function getcount()
            {htmlobj=$.ajax({type:"POST",
                    url:"get_Openid.php?act=de3",
                    async:false,//同步/异步加载
                    data:"id="+i,
                    beforeSend:function(XMLHttpRequest){
                    //alert('远程调用开始...');
                    //$("#load_img").html("<img width='78px' height='47px'  src='images/load.gif'/>");
                     $("#down_openid").attr("disabled",true);
                    },
                    success:function(data,textStatus){
                    
                   // alert(data);
                    
                     //$("#load_img").append(data+"<br>");
                     
                    co=data;
                    return co;
                    
                    },
                    complete:function(XMLHttpRequest,textStatus){
                    // alert('远程调用成功，状态文本值：'+textStatus);
                   
                   // $("#load_img").empty();
                 
                  
                    },
                    error:function(XMLHttpRequest,textStatus,errorThrown){
                    // alert('error...状态文本值：'+textStatus+" 异常信息："+errorThrown);
                    //$("#load_img").empty();
                    }
                  
                    })
                   
            }
            getcount();
            //alert(co);
        
            $("#load_img").empty();
            if(co<=0)
            {
                co=0;
           }
           
            for(var j=0;j<co;j++)
            {
                 htmlobj=$.ajax({type:"POST",
                    url:"get_Openid.php",
                    async:false,//同步/异步加载
                    data:"id="+j,
                    beforeSend:function(XMLHttpRequest){
                    //alert('远程调用开始...');
                    //$("#load_img").html("<img width='78px' height='47px'  src='images/load.gif'/>");
                     $("#down_openid").attr("disabled",true);
                    },
                    success:function(data,textStatus){
                    
                    //alert(data);
                    
                     $("#load_img").append(data+"<br>");
                     
        
                    
                    },
                    complete:function(XMLHttpRequest,textStatus){
                    // alert('远程调用成功，状态文本值：'+textStatus);
                   
                   // $("#load_img").empty();
                 
                  
                    },
                    error:function(XMLHttpRequest,textStatus,errorThrown){
                    // alert('error...状态文本值：'+textStatus+" 异常信息："+errorThrown);
                    //$("#load_img").empty();
                    }
            });
            }
        
      
        })
        
        
        
      
        
        
        
         $("#zl_down_openid").click(function(){
         
           
      
            for(var z=0;z<1;z++)
            {
                 htmlobj=$.ajax({type:"POST",
                    url:"get_Openid.php?act=increment",
                    async:false,//同步/异步加载
                    data:"id="+z,
                    beforeSend:function(XMLHttpRequest){
                    //alert('远程调用开始...');
                   // $("#load_img").html("<img width='78px' height='47px'  src='images/load.gif'/>");
                     $("#down_openid").attr("disabled",true);
                    },
                    success:function(data,textStatus){
                    
                    //alert(data);
                    
                     $("#load_img").append(data+"<br>");
                     
        
                    
                    },
                    complete:function(XMLHttpRequest,textStatus){
                    // alert('远程调用成功，状态文本值：'+textStatus);
                   
                   // $("#load_img").empty();
                 
                  
                    },
                    error:function(XMLHttpRequest,textStatus,errorThrown){
                    // alert('error...状态文本值：'+textStatus+" 异常信息："+errorThrown);
                    //$("#load_img").empty();
                    }
            });
            }
        
      
        })
        
        
        
        $("#down_hy").click(function (){
            window.open('openid.php?act=down_hy');
        })
        
        
        
        $(".headimgurl").each(function ()
        {
            $(this).click(function (){
              
                htmlobj4=$.ajax({type:"POST",
                url:"get_Openid.php?act=get_img",
                data:"img_url="+$(this).attr("name")+"&id="+$(this).attr("n_id"),async:false,
                beforeSend:function(XMLHttpRequest){
                    //alert('加载中...');
                   // $("#load_img").html("<img width='78px' height='47px'  src='images/load.gif'/>");
                   
                    },
                    success:function(data,textStatus){
                    
                    //alert(data);
                    window.location.reload();
                    },
                    complete:function(XMLHttpRequest,textStatus){
                    // alert('远程调用成功，状态文本值：'+textStatus);
                   
                   // $("#load_img").empty();
                 
                  
                    },
                    error:function(XMLHttpRequest,textStatus,errorThrown){
                    // alert('error...状态文本值：'+textStatus+" 异常信息："+errorThrown);
                    //$("#load_img").empty();
                    }
                
                
                
                });
                //alert(htmlobj4.responseText);
            })
        })
          
      
   
  
      $(".img").each(function(){
        $(this).attr("src","images/users/"+$(this).attr("url")+".jpg");
        
      })
      
      $(".lmsg").each(function(){
            
             $(this).click(function(){
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
         $("#is_att").val("{$is_att}");
})
-->
</script>
