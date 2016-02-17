<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>微信</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no" />
   	<link href="css/member/mcen.css" type="text/css" rel="stylesheet"/>
   <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript">
	document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
    WeixinJSBridge.call('hideOptionMenu');
    });
    </script>
<style>
.proHeader{width:100%;height:44px;background:#749c18;overflow:hidden;margin:0 auto;font-family:微软雅黑;font-size:14px;}
.proHeader li{float:left;color:#fff;height:44px;line-height:44px;text-align:center; width:35px}
.proHeader li.back{width:58px;border-right:solid 1px #FFFFff;}
.proHeader li.back a{color:#fff;font-size:14px;}
.proHeader li.xq{width:80px;border-left:solid 1px #FFFFff;font-size:16px;}
.proHeader li.xq2{width:90px;border-left:solid 0px #FFFFff;font-size:16px;}
.proHeader li.fl{width:59px;border-left:solid 1px #FFFFff;padding-top:2px;}
.proHeader li img{vertical-align:-3px;}



.user_m div{width:100%;height:10px;line-height:10px;overflow:hidden;padding:8px;}
.user ul li a:hover,.user ul li a.sel{background:#749c18;color:#fff;}
.user ul li a{display:block;height:35px;width:90px;color:#000000;font-size:14px;line-height:40px; text-align:center}
.user .user_ul div{width:100%;height:50px;line-height:50px;overflow:hidden;padding:0 8px;border-bottom:solid 1px #CCCCCC;background:url(images/member/record_bg.jpg) no-repeat 280px 18px 8px 12px;}
.user .user_ul div a{color:#000000;}
.user .user_ul div span{display:inline-block;width:231px;float:left;padding:0 0 0 39px;height:50px;line-height:50px;}
.user .user_ul div span.user_s6{background:url(images/member/user06.jpg) no-repeat 0 13px ;background-size:25px 25px;}


.radius5{
border: 1px solid; border-color: #EEE #CCC #CCC #EEE;
color: #000; font-weight: bold; background: #F5F5F5;
height:40px;width:100% ; line-height: 40px;border-radius:10px;
}
</style>
</head>
<body>

<input  type="hidden" id="op" value="{$op}"/>
{if $fall=='list'}
    <ul class="proHeader">
        <!--<li class="back"><a href="javascript:history.go(-1);"><img src="images/member/jianzuo.png" width="8" style="vertical-align:-1px;margin-right:3px;">返回</a></li> -->
        <li class="xq2" onclick="location='mcenter.php?act=cen2&openid={$op}'">店铺查询</li>
    </ul>


<div class="user">
<div class="userM">



<div style=" display:none1; margin:0 auto;margin-bottom: -13px; width:100%" id="headimgurl" >




<img width="100%" src="images/member/mcenter/2.png"/>

<b style="position: relative; left:34%; bottom:28px; margin-bottom: -7px; ">VIP卡号:{$openid.users_sn}</b>


</div>



<!--
<div class="user_m" >
<li>
<span >
{if $openid.headimgurl==''}<img  width="50px" height="50px" src="images/weixin.png"/>{else}<img  width="50px" height="50px" src="{$openid.headimgurl}"/>{/if}
</span>
<span  >&nbsp;{$openid.nick_name}&nbsp;({$openid.users_sn})</span>
</li>



</div>-->

<div class="user_m" id="sn_imgurl" style="display:none;">
<span  >&nbsp;我的二维码({$openid.users_sn})</span>
<p ><img width="96%" src="upload/temp/{$openid.sn_imgurl}"/></p>



</div>


 <!--
<ul class="user_ul">
	
	 
        <li><span class="user_s5">您输入的手机:{$openid.wx_tel}</span></li>
        <li><span class="user_s5">系统原始密码:{$openid.wx_pwd}</span></li>
	
        
        <li><span class="user_s5">个人信息更新</span></li>
       	<li onclick="location.href='mcenter.php?act=ewm&openid={$op}&is_active=1'"><span class="user_s6">点击查询我的抵用券</span></li>
        <li onclick="location.href='mcenter.php?act=ewm2&openid={$op}&is_active=1'"><span class="user_s6">点击查询我的实物券</span></li>
    </ul>  -->

 <ul class="user_ul">
	
    
    
	  
      
     
      
        {if $djuser=='1'}
            <li  onclick="location.href='mcenter.php?act=duijiang&openid={$op}'"><span class="user_s5">兑奖中心</span></li>
   
        {/if}
        
        {if $fenxiao==0}
        <!-- <li  onclick="location.href='mcenter.php?act=jiameng&openid={$op}'"><span class="user_s4">店铺&nbsp;</span></li>  -->
        {elseif $fenxiao==1}
         <li onclick="location.href='mcenter.php?act=fxfc&openid={$op}&v1=222'"><span class="user_s4">店铺二维码&nbsp;</span></li>
          <li onclick="location.href='mcenter.php?act=fxfc_w&openid={$op}&v1=222'"><span class="user_s4">店铺销售查询&nbsp;</span></li>
		 <li onclick="location.href='wx_share.php?openid={$op}&v1=222'"><span class="user_s4">店铺二维码分享&nbsp;</span></li> 
		 
		 <li><span class="user_s4">积累粉丝：{$fanssl}</span></li> 
        {/if}
      

        
	   
    </ul> 
       

    
    <!--
     <ul class="user_ul">
	
	  
        <li><span class="user_s2">微信商城</span></li>
 
	   
    </ul>      -->
 
</div>
</div>
{/if}


{if $fall=='list2'}
     <ul class="proHeader">
        <li class="back" onclick="location.href='mcenter.php?openid={$op}'"><img src="images/member/jianzuo.png" width="8" style="vertical-align:-1px;margin-right:3px;">返回</li>
        <li class="xq">会员信息</li>
    </ul>

<div class="user">
<div class="userM">








<div class="user_m" >
<li>
<span >
{if $openid.headimgurl==''}<img  width="50px" height="50px" src="images/weixin.png"/>{else}<img  width="50px" height="50px" src="{$openid.headimgurl}"/>{/if}
</span>
<span  >&nbsp;{$openid.nick_name}&nbsp;({$openid.users_sn})</span>
</li>



</div>

<div class="user_m" style="display:none1;">
<span  >&nbsp;我的二维码({$openid.users_sn})</span>
<p ><img width="96%" src="upload/temp/{$openid.sn_imgurl}"/></p>



</div>



<ul class="user_ul">
	
	  
        <li><span class="user_s5">您输入的手机:{$openid.wx_tel}</span></li>
        <li><span class="user_s5">系统原始密码:{$openid.wx_pwd}</span></li>
	
        
       
    </ul>  

<!--
       <div class="user_m">
<p>备注：</p>
<p>1.系统生成账户密码,后续可登陆官方APP直接使用,敬请期待!</p>


</p>
</div>-->
</div>
</div>
{/if}
				 
{if $fall=='ewm'}

    <ul class="proHeader">
        <li class="back" onclick="location.href='mcenter.php?openid={$op}'"><img src="images/member/jianzuo.png" width="8" style="vertical-align:-1px;margin-right:3px;">返回</li>
        <li class="xq">中奖记录</li>
    </ul>
<!-- <div class="myorder">
    <div class="myorderM">
        <div class="myorder_m">
           
			
			</div>
	</div>
</div>-->
<div class="user">
<div class="userM">
<div class="user_m">
<ul style="height:35px; text-align:center;">
			        <li style="border-right:1px solid #CCCCCC;color:#000000;float:left; height:35px; width:32%;text-align:center;font-family:微软雅黑;font-size:14px; padding-left:5px;"><a  href="mcenter.php?act=ewm&openid={$op}&is_active=1" {if $is_active==1} class="sel"{/if}>未使用</a></li>
					
                    <li style="border-right:1px solid #CCCCCC;color:#000000;float:left;height:35px;  width:32%;text-align:center;font-family:微软雅黑;font-size:14px; padding-left:1px;"><a  href="mcenter.php?act=ewm&openid={$op}&is_active=2" {if $is_active==2} class="sel"{/if}>已使用</a></li>
					
					<li style="float:left;height:35px;  width:32%;text-align:center;font-family:微软雅黑;font-size:14px;padding-left:1px;"><a  href="mcenter.php?act=ewm&openid={$op}&is_active=3" {if $is_active==3} class="sel"{/if}>已作废</a></li>
			</ul>
</p>
</div>


{foreach from=$sncode item=sncode}
   <div class="user_m">
                <div>★&nbsp;活动名称：{$sncode.hd_sn}/{$sncode.activity_name}</div>
                <div>★&nbsp;奖项：{$sncode.prizetype}等奖/{$sncode.jpmc}</div>
                <div>★&nbsp;中奖时间：{$sncode.add_time}</div>
		        <div>★&nbsp;中奖码：{$sncode.sncode}</div>
				<div>★&nbsp;有效期至：{$sncode.limit_time}</div>
                
              
                
				{if $is_active==1}
                
                
                  {if $ex_point==1}
                <ul style="height:50px; text-align:center; width:50px;" >
				<li style="color:#000000;float:left; height:35px; width:41%;text-align:center;font-family:微软雅黑;font-size:14px; padding-left:5px;padding-top:8px;" class="duihjf" sncode="{$sncode.sncode}" prize="{$sncode.prizetype}" ex_point="{$sncode.ex_point}"><a href="#" class="sel">兑换{$sncode.ex_point}积分</a></li>
		
				</ul>
                {/if}
                
                
                {if $sncode.is_share==1}
                <ul style="height:50px; text-align:center;">
				<li style="color:#000000;float:left; height:35px; width:31%;text-align:center;font-family:微软雅黑;font-size:14px; padding-left:5px;padding-top:8px;"><a href="#" class="sel">乐捐</a></li>
				<li style="color:#000000;float:left; height:35px; width:31%;text-align:center;font-family:微软雅黑;font-size:14px; padding-left:5px;padding-top:8px;"><a href="#" onclick="window.location.replace('wx_share.php?sncode={$sncode.sncode}')" class="sel" title="share">分享</a></li>
				<li style="color:#000000;float:left; height:35px; width:31%;text-align:center;font-family:微软雅黑;font-size:14px; padding-left:5px;padding-top:8px;"><a href="#" class="sel">优惠</a></li>
				</ul>
                {/if}
                {/if}
                
                
</div>
   {foreachelse}
   
     <div class="user_m">
                <p style="padding: 10px;">暂无记录</p>
	</div>
                {/foreach}   
        <!--<li><a href="#"><span class="user_s4">我的积分</span></a></li>-->
        
 <div class="user_m">
 <p style="padding: 5px;">
 <b style="font-size:15px"> 抵用卷使用说明<br /></b>



 </p>
 	</div>
        
</div>
</div>
{/if}

{if $fall=='ewm2'}

    <ul class="proHeader">
        <li class="back" onclick="location.href='mcenter.php?openid={$op}'"><img src="images/member/jianzuo.png" width="8" style="vertical-align:-1px;margin-right:3px;">返回</li>
        <li class="xq">实物券</li>
    </ul>
<!-- <div class="myorder">
    <div class="myorderM">
        <div class="myorder_m">
           
			
			</div>
	</div>
</div>-->
<div class="user">
<div class="userM">
<div class="user_m">
<ul style="height:35px; text-align:center;">
			        <li style="border-right:1px solid #CCCCCC;color:#000000;float:left; height:35px; width:32%;text-align:center;font-family:微软雅黑;font-size:14px; padding-left:5px;"><a  href="mcenter.php?act=ewm2&openid={$op}&is_active=1" {if $is_active==1} class="sel"{/if}>未使用</a></li>
					
                    <li style="border-right:1px solid #CCCCCC;color:#000000;float:left;height:35px;  width:32%;text-align:center;font-family:微软雅黑;font-size:14px; padding-left:1px;"><a  href="mcenter.php?act=ewm2&openid={$op}&is_active=2" {if $is_active==2} class="sel"{/if}>已使用</a></li>
					
					<li style="float:left;height:35px;  width:32%;text-align:center;font-family:微软雅黑;font-size:14px;padding-left:1px;"><a  href="mcenter.php?act=ewm2&openid={$op}&is_active=3" {if $is_active==3} class="sel"{/if}>已作废</a></li>
			</ul>
</p>
</div>

{foreach from=$sncode2 item=sncode2}
   <div class="user_m">
                <div>★&nbsp;活动名称：{$sncode2.hd_sn}</div>
                <div>★&nbsp;奖项：{$sncode2.note}</div>
                <div>★&nbsp;中奖时间：{$sncode2.add_time}</div>
		        <div>★&nbsp;中奖码：{$sncode2.sncode}</div>
				<div>★&nbsp;有效期至：{$sncode2.limit_time}</div>
                
              
                
				{if $is_active==1}
                
                
                  {if $ex_point==1}
                <ul style="height:50px; text-align:center; width:50px;" >
				<li style="color:#000000;float:left; height:35px; width:41%;text-align:center;font-family:微软雅黑;font-size:14px; padding-left:5px;padding-top:8px;" class="duihjf" sncode="{$sncode.sncode}" prize="{$sncode.prizetype}" ex_point="{$sncode.ex_point}"><a href="#" class="sel">兑换{$sncode.ex_point}积分</a></li>
		
				</ul>
                {/if}
                
                
                {if $sncode.is_share==1}
                <ul style="height:50px; text-align:center;">
				<li style="color:#000000;float:left; height:35px; width:31%;text-align:center;font-family:微软雅黑;font-size:14px; padding-left:5px;padding-top:8px;"><a href="#" class="sel">乐捐</a></li>
				<li style="color:#000000;float:left; height:35px; width:31%;text-align:center;font-family:微软雅黑;font-size:14px; padding-left:5px;padding-top:8px;"><a href="#" onclick="window.location.replace('wx_share.php?sncode={$sncode.sncode}')" class="sel" title="share">分享</a></li>
				<li style="color:#000000;float:left; height:35px; width:31%;text-align:center;font-family:微软雅黑;font-size:14px; padding-left:5px;padding-top:8px;"><a href="#" class="sel">优惠</a></li>
				</ul>
                {/if}
                {/if}
                
                
</div>
   {foreachelse}
   
     <div class="user_m">
                <p style="padding: 10px;">暂无记录</p>
	</div>
                {/foreach}   
        <!--<li><a href="#"><span class="user_s4">我的积分</span></a></li>-->
</div>
</div>
{/if}




{if $fall=='jiameng'}

    <ul class="proHeader">
        <li class="back" onclick="location.href='mcenter.php?openid={$op}'"><img src="images/member/jianzuo.png" width="8" style="vertical-align:-1px;margin-right:3px;">返回</li>
        <li class="xq">加盟信息</li>
    </ul>
<div class="user">
<div class="userM">

  {if $fenxiao==0}

<div class="user_m">
       <!--
<p style="padding: 5px;">
<b style="font-size:15px">成为笨笨鼠品牌商：零投资，高回报<br /></b>

1、申请成为笨笨鼠品牌一级经销商，公司将为其生成独立的分销二维码，消费者通过扫描该二维码关注后将成为其永久客户，以后无论该客户在何时何地在笨笨鼠微信、天猫、京东、1号店等商城消费，其均可获取17%的销售提成。<br />
2、申请成为二级分销商，公司可为其生成独立的二级分销二维码，消费者通过扫描该二维码关注后将成为其永久客户，以后无论该客户在何时何地在笨笨鼠微信、天猫、京东、1号店等商城消费，其均可获取12%的销售提成。<br />
3、一级经销商渠下的二级分销商产生的销售，其均可获得5%的销售提成。<br />
4、成为笨笨鼠品经销售可直接通过笨笨鼠官方微信申请，通过申核后，公司将会为其生成独立分销二维码，经销售只需通过对该二维码的传播（微信、微博、人际网、活动等），即可与消费者永久绑定，产生的销售均可获取相应提成。<br />


<b style="font-size:15px;color:red;">笨笨鼠分销商招幕条件：<br /></b>


1、人际网络广<br />
2、善长微信、微博传播<br />
3、有实体店铺<br />
4、善于活动<br />
申请成为二级分销商只需满足以上任一条件即可，零投入，零风险，高回报！<br />
申请成为一级分销商最少需满足以下2点中的一点：A、善长微信、微博传播，有相当数量的粉丝群（粉丝数量5000人以上）；<br />
B、具备3家以上实体店或连锁店、或原线下某品牌代理商。<br />

<b style="font-size:15px;color:red;">申请流程：<br /></b>

登陆关注笨笨鼠官方微信－点击个人中心－会员中心－申请成为分销商－填写个人申请信息及联系方式－通过申请－生成独立分销二维码－开始推广－高额回报


</p>
-->
</div>

<form action="mcenter.php?act=lvmsg" method="POST">


<div class="user_m">
<input  type="hidden" id="op" name="op" value="{$op}"/>
<input  type="hidden" value="{$random_code}" name="random_code"/>
<p>姓名:</p>
<p><input  name="xingming" class="radius5" id="xingming" type="text"   /> </p>
<p>联系手机:</p>
<p><input  name="tel" class="radius5" id="tel" type="text"   /> </p>
<p>邮箱:</p>
<p><input  name="email" class="radius5" id="email" type="text"   /> </p>
<p>地址:</p>
<p><input  name="address" class="radius5" id="address" type="text"   /> </p>

<p>留言:</p>
<p><input  name="leavemsg" class="radius5" id="leavemsg" type="text"   /> </p>



</div>
<input type="submit" class="pxbtn2" value="提交" id="tjmsg"  />

</form>

  {elseif $fenxiao==1}
  <div class="user_m">
       
<p style="padding: 5px;">
<b style="font-size:15px">您已经是分销商,请返回个人中心查询分销信息</b>



</p>

</div>
  
  
  {/if}

</div>




</div>

<script type="text/javascript">
<!--
	$("#tjmsg").click(function(){
           if(jQuery.trim($("#xingming").attr('value'))=='')
        {
            
            $("#xingming").focus();
            
            return false;
        }
        else if(jQuery.trim($("#tel").attr('value'))=='')
        {
            $("#tel").focus();
            return false;
        }
        else if(jQuery.trim($("#email").attr('value'))=='')
        {
            $("#email").focus();
            return false;
        }
        else if(jQuery.trim($("#leavemsg").attr('value'))=='')
        {
            $("#leavemsg").focus();
            return false;
        }
        else
        {
            
            if(confirm("确认提交")){
                
            }
            else
            {
                return false;
            }
        }
       })
-->
</script>
{/if}


{if $fall=='duijiang'}

	
    
  

    <ul class="proHeader">
        <li class="back" onclick="location.href='mcenter.php?openid={$op}'"><img src="images/member/jianzuo.png" width="8" style="vertical-align:-1px;margin-right:3px;">返回</li>
        <li class="xq" onclick="location='mcenter.php?act=duijiang&openid={$op}'">兑奖中心</li>
    </ul>
<div class="user">
<div class="userM">
 <div class="user_m">
                <p>使用说明:微信用户在公众号参与活动获得的活动奖券,在线客服可使用此兑奖功能进行验证、兑换。</p>
	</div>

        <div class="user_m">
        <p>请输入中奖奖券代码:</p>
        <p><input  name="txt_check" class="radius5" id="sncode" type="text"   /> </p>
        </div>
<div class="user_m"  style="display: none;" id="djmsg"> 
        <p id="msg1"></p>
       <p id="msg2"></p>
       <p id="msg3"></p>
       <p id="msg4"></p>
       <p id="msg5"></p>
</div>


<input type="button" class="pxbtn2" value="查询兑奖码" id="yanzheng"  />
<br />

<input type="button" class="pxbtn2" value="兑换" id="duij"   style="display: none;"  />


</div>
</div>
{/if}



{if $fall=='lvmsg'}

	
    
  

    <ul class="proHeader">
        <li class="back" onclick="location.href='mcenter.php?openid={$op}'"><img src="images/member/jianzuo.png" width="8" style="vertical-align:-1px;margin-right:3px;">返回</li>
        <li class="xq" >留言信息</li>
    </ul>
<div class="user">
<div class="userM">
 <div class="user_m" onclick="location.href='mcenter.php?openid={$op}'">
                <p>留言成功,我们会尽快回复您的留言信息</p>
                <p>(点击返回个人中心)</p>
	</div>



</div>
</div>
{/if}


{if $fall=='dhreal'}

    <ul class="proHeader">
        <li class="back" onclick="location.href='mcenter.php?openid={$op}'"><img src="images/member/jianzuo.png" width="8" style="vertical-align:-1px;margin-right:3px;">返回</li>
        <li class="xq">兑换实物券</li>
    </ul>
<div class="user">
<div class="userM">


<div class="user_m"  un="unclick">
       
<p>您的可用积分:{$jifen}<br />
请选择对应要兑换的实物券:</p>

<input  type="hidden" value="{$jifen}" id="kyjifen"/>
</div>
{if $ex_real_val==1}
<input  type="hidden" value="{$sn}" id="lo_sn"/>
{foreach from=$ex_real item=ex_real} 
<div class="user_m"  type_val="{$ex_real.type_val}" note="{$ex_real.note}">

<p>{$ex_real.type_val}积分兑换</p>
<p><a style="color:green" id="jifenmingxi">{$ex_real.note}</a></p>


</div>

{/foreach} 
{else}
<div class="user_m">
<b>    
<p>系统不允许兑换:</p>
</b>   

</div>
{/if}
</div>
</div>
<script type="text/javascript">
<!--
	 $(".user_m").each(function(){
	   
               
                $(this).click(function (){
                    
                    if($(this).attr("un")=="unclick")
                    {
                        return false;
                    }
                    
                   var note=$(this).attr("note");
                   var type_val=$(this).attr("type_val");
                   var openid=$("#op").val();
                   var lo_sn=$("#lo_sn").val();
                   var kyjifen=$("#kyjifen").val();
                
                   
                   if(kyjifen-type_val<0)
                   {
                        alert("可用积分不够,无法兑换");
                        return;
                   }
                   
                   if(confirm("确定将"+type_val+"积分兑换成\n"+note)){
                  
                        $.ajax({
            			url: "mcenter.php?act=duihuanreal",
            			dataType: "json",
                        type: 'POST',
                        //async:false,
            			data: {
            			 
                            "note":note,
                            "type_val":type_val,
                            "lo_sn":lo_sn,
                            "openid":openid
            			},
            			beforeSend: function() {
            			
            			},
            			success: function(data) {
            			 //alert(data);
            			      if(data.err_code==1)
                              {
                                   alert(data.err_msg); 
                              }
                              else
                              {
                                alert(data.err_msg); 
                            
                                
                              }
                              //location.reload() ;
                          
            			},
            			error: function() {
            			  //alert(1);
            			  //alert(2);return;
            			},
            			
            		})
                   
            
                   }else return false;
                   
                    
                   
                })
       })
-->
</script>
{/if}

{if $fall=='fxfc'}

    <ul class="proHeader">
        <li class="back" onclick="location.href='mcenter.php?act=cen2&openid={$op}'"><img src="images/member/jianzuo.png" width="8" style="vertical-align:-1px;margin-right:3px;">返回</li>
        <li class="xq">店铺销售</li>
    </ul>
<div class="user">
<div class="userM">

{foreach from=$fc item=fc} 
       <div class="user_m">
<p>用户:{$fc.nick_name}({$fc.users_sn})</p>
<p>渠道:{$fc.p_type}/{$fc.qudao_name}</p>
<p>店铺二维码:</p>
<p ><img width="100%" src="{$fc.tgerm}"/></p>



<!--<p>分成比例:{$fc.point}%</p>
<p>推广总金额:￥ {$fc.zje}</p>
<p>推广正常金额:￥ {$fc.zcje}</p>
<p>售后问题金额:￥ {$fc.wqje}</p>

<p>收益:￥ {$fc.sjje}</p>-->




</div>

{/foreach}
<div class="user_m">
       <!--
<p style="padding: 5px;">
<b style="font-size:15px">成为笨笨鼠品牌分销商：零投资，高回报<br /></b>

1、申请成为笨笨鼠品牌一级经销商，公司将为其生成独立的分销二维码，消费者通过扫描该二维码关注后将成为其永久客户，以后无论该客户在何时何地在笨笨鼠微信、天猫、京东、1号店等商城消费，其均可获取17%的销售提成。<br />
2、申请成为二级分销商，公司可为其生成独立的二级分销二维码，消费者通过扫描该二维码关注后将成为其永久客户，以后无论该客户在何时何地在笨笨鼠微信、天猫、京东、1号店等商城消费，其均可获取12%的销售提成。<br />
3、一级经销商渠下的二级分销商产生的销售，其均可获得5%的销售提成。<br />
4、成为笨笨鼠品经销售可直接通过笨笨鼠官方微信申请，通过申核后，公司将会为其生成独立分销二维码，经销售只需通过对该二维码的传播（微信、微博、人际网、活动等），即可与消费者永久绑定，产生的销售均可获取相应提成。<br />


<b style="font-size:15px;color:red;">笨笨鼠分销商招幕条件：<br /></b>


1、人际网络广<br />
2、善长微信、微博传播<br />
3、有实体店铺<br />
4、善于活动推广<br />
申请成为二级分销商只需满足以上任一条件即可，零投入，零风险，高回报！<br />
申请成为一级分销商最少需满足以下2点中的一点：A、善长微信、微博传播，有相当数量的粉丝群（粉丝数量5000人以上）；<br />
B、具备3家以上实体店或连锁店、或原线下某品牌代理商。<br />

<b style="font-size:15px;color:red;">申请流程：<br /></b>

登陆关注笨笨鼠官方微信－点击个人中心－会员中心－申请成为分销商－填写个人申请信息及联系方式－通过申请－生成独立分销二维码－开始推广－高额回报


</p>
-->
</div>




</div>
</div>
{/if}


{if $fall=='fxfc2'}

    <ul class="proHeader">
        <li class="back" onclick="location.href='mcenter.php?act=cen2&openid={$op}'"><img src="images/member/jianzuo.png" width="8" style="vertical-align:-1px;margin-right:3px;">返回</li>
        <li class="xq">店铺销售</li>
    </ul>
<div class="user">
<div class="userM">

{foreach from=$fc item=fc} 
       <div class="user_m">


<p>用户:{$fc.nick_name}({$fc.users_sn})</p>
<p>渠道:{$fc.p_type}/{$fc.qudao_name}</p>
<!--<p>分成比例:{$fc.point}%</p>
<p>推广总金额:￥ {$fc.zje}</p>
<p>推广正常金额:￥ {$fc.zcje}</p>
<p>售后问题金额:￥ {$fc.wqje}</p>

<p>收益:￥ {$fc.sjje}</p>-->

<p>已确认金额/未确认金额/退款金额</p>
<p><a style="color:green">￥ {if $fc.fc_list.yqrje==''}0{else}{$fc.fc_list.yqrje}{/if}</a>/<a style="color:red">￥ {if $fc.fc_list.wqrje==''}0{else}{$fc.fc_list.wqrje}{/if}</a>/<a style="color:red">￥ {if $fc.fc_list.tkje==''}0{else}{$fc.fc_list.tkje}{/if}</a></p>

&nbsp;<hr style="BORDER-BOTTOM-STYLE: dotted; BORDER-LEFT-STYLE: dotted; BORDER-RIGHT-STYLE: dotted; BORDER-TOP-STYLE: dotted;color:#77b900; size=1;"  />
{foreach from=$fc.fc_list.fxfc item=weixiaodian}
<p>

订单号:{$weixiaodian.order_sn}<br/>
购买日期:{$weixiaodian.order_create_time}<br/>
购买人:{$weixiaodian.buyer_nick}<br/>
商品:{$weixiaodian.product_name}<br/>
数量:{$weixiaodian.product_count}件<br/>
零售价:￥{$weixiaodian.ori_price_total}<br/>
金额:￥{$weixiaodian.order_total_price}<br/>

订单状态:
{if $weixiaodian.or_status=='0'}
买家已付款,未收货
{elseif $weixiaodian.or_status=='1'}
<a style="color:green">已收货</a>
{elseif $weixiaodian.or_status=='2' or $weixiaodian.or_status=='3' or $weixiaodian.or_status=='4' or $weixiaodian.or_status=='5'}
申请退款
{/if}
<br/>
商店销售金额:
{if $weixiaodian.or_status=='0'}
{$weixiaodian.djfc}(买家未确认)
{elseif $weixiaodian.or_status=='1'}
<a style="color:green">{$weixiaodian.djfc}(买家已确认)</a>
{elseif $weixiaodian.or_status=='2' or $weixiaodian.or_status=='3' or $weixiaodian.or_status=='4' or $weixiaodian.or_status=='5'}
{$weixiaodian.djfc}(已退款,无销售金额)
{/if}

</p>
<br />
{/foreach}


{if $ptype==1 }
<!-- 店铺级别 -->

{foreach from=$fc.shop_fenc item=shop_fenc} 
<p>下级店铺销售</p>
<p>店铺:&nbsp;{$shop_fenc.qudao_name}&nbsp;/&nbsp;{$shop_fenc.shop_name}&nbsp;</p>


<p>已确认金额/未确认金额/退款金额</p>
<p><a style="color:green">￥ {if $shop_fenc.sdfc.yqrje==''}0{else}{$shop_fenc.sdfc.yqrje}{/if}</a>/<a style="color:red">￥ {if $shop_fenc.sdfc.wqrje==''}0{else}{$shop_fenc.sdfc.wqrje}{/if}</a>/<a style="color:red">￥ {if $shop_fenc.sdfc.tkje==''}0{else}{$shop_fenc.sdfc.tkje}{/if}</a></p>

{/foreach}
<!-- end店铺级别 -->

<br />
<!-- 导购级别 -->

{foreach from=$fc.sales_fenc item=sales_fenc} 
<p>下级导购销售</p>
<p>导购:&nbsp;{$sales_fenc.qudao_name}&nbsp;/&nbsp;{$sales_fenc.shop_name}&nbsp;/&nbsp;{$sales_fenc.sales_name}&nbsp;</p>

<p>已确认金额/未确认金额/退款金额</p>
<p><a style="color:green">￥ {if $sales_fenc.dgfc.yqrje==''}0{else}{$sales_fenc.dgfc.yqrje}{/if}</a>/<a style="color:red">￥ {if $sales_fenc.dgfc.wqrje==''}0{else}{$sales_fenc.dgfc.wqrje}{/if}</a>/<a style="color:red">￥ {if $sales_fenc.dgfc.tkje==''}0{else}{$sales_fenc.dgfc.tkje}{/if}</a></p>


{/foreach}
<!-- end导购级别




</div>
<div class="user_m"> -->

<!-- 导购级别 -->

{foreach from=$fc.shop_sales_fenc item=sales_fenc} 
<p>下级导购分成</p>
<p>渠道:&nbsp;{$sales_fenc.shop_name}&nbsp;/&nbsp;{$sales_fenc.sales_name}&nbsp;</p>

<p>已确认金额/未确认金额/退款金额</p>
<p><a style="color:green">￥ {if $sales_fenc.sd_dgfc.yqrje==''}0{else}{$sales_fenc.sd_dgfc.yqrje}{/if}</a>/<a style="color:red">￥ {if $sales_fenc.sd_dgfc.wqrje==''}0{else}{$sales_fenc.sd_dgfc.wqrje}{/if}</a>/<a style="color:red">￥ {if $sales_fenc.sd_dgfc.tkje==''}0{else}{$sales_fenc.sd_dgfc.tkje}{/if}</a></p>

&nbsp;<hr style="BORDER-BOTTOM-STYLE: dotted; BORDER-LEFT-STYLE: dotted; BORDER-RIGHT-STYLE: dotted; BORDER-TOP-STYLE: dotted;color:#77b900; size=1;"  />
{foreach from=$sales_fenc.sd_dgfc.fxfc item=weixiaodian}
<p>

订单号:{$weixiaodian.order_sn}<br/>
购买日期:{$weixiaodian.order_create_time}<br/>
购买人:{$weixiaodian.buyer_nick}<br/>
商品:{$weixiaodian.product_name}<br/>
数量:{$weixiaodian.product_count}件<br/>
零售价:￥{$weixiaodian.ori_price_total}<br/>
金额:￥{$weixiaodian.product_price}<br/>
订单状态:
{if $weixiaodian.or_status=='0'}
买家已付款,未收货
{elseif $weixiaodian.or_status=='1'}
<a style="color:green">已收货</a>
{elseif $weixiaodian.or_status=='2' or $weixiaodian.or_status=='3' or $weixiaodian.or_status=='4' or $weixiaodian.or_status=='5'}
申请退款
{/if}
<br/>
商店销售金额:
{if $weixiaodian.or_status=='0'}
{$weixiaodian.djfc}(买家未确认)
{elseif $weixiaodian.or_status=='1'}
<a style="color:green">{$weixiaodian.djfc}(买家已确认)</a>
{elseif $weixiaodian.or_status=='2' or $weixiaodian.or_status=='3' or $weixiaodian.or_status=='4' or $weixiaodian.or_status=='5'}
{$weixiaodian.djfc}(已退款,无销售金额)
{/if}

</p>
&nbsp;<hr style="BORDER-BOTTOM-STYLE: dotted; BORDER-LEFT-STYLE: dotted; BORDER-RIGHT-STYLE: dotted; BORDER-TOP-STYLE: dotted;color:#77b900; size=1;"  />
{/foreach}

{/foreach}
<!-- end导购级别 -->




{/if}



</div>
{/foreach}





</div>
</div>
{/if}




{if $fall=='yate'}

    <ul class="proHeader">
        <li class="back" onclick="location.href='mcenter.php?openid={$op}'"><img src="images/member/jianzuo.png" width="8" style="vertical-align:-1px;margin-right:3px;">返回</li>
        <li class="xq">订单查询</li>
    </ul>
<div class="user">
<div class="userM">


 <div class="user_m">
 <b style="font-size:15px">您的总积分:<a style="color:green">{$check_sum}</a><br/></b>
 
 
 {$sys_list.note}
 <br />
 
 <a style="color:green" id="jifenmingxi">(查看积分明细)</a>
  <br />

 <a id="jfmx"  style="display: none;">
 
奖券兑换积分: 
  {foreach from=$expoint_inlog item=expoint_inlog} 
 <p>兑换时间:{$expoint_inlog.add_time}/积分:{$expoint_inlog.rank_points}</p>

 {foreachelse}
 <br />
暂无记录
</p>
{/foreach}
 </a>
<a id="jfmx2"  style="display: none;">
签到积分:
  {foreach from=$check item=check} 
 <p>签到时间:{$check.add_time}/积分:{$check.rank_points}</p>

 {foreachelse}
  <br />
暂无记录
</p>
{/foreach}

消耗积分:
<br/>
 {foreach from=$sncode_real item=sncode_real} 
 <p>兑换时间:{$sncode_real.add_time}/积分:{$sncode_real.type_val}<br/>实物券:{$sncode_real.note}</p>

 {foreachelse}
暂无记录
</p>
{/foreach}
 </a>


 
 </div>
{if $ex_real==1}
 <div class="user_m" onclick="location.href='mcenter.php?act=dhreal&openid={$op}'">
 
 <a style="color:green" id="jifenmingxi" >积分兑换实物券</a>
</div>
{/if}
       <div class="user_m">
    



{foreach from=$user_info item=order} 
<p>
商店名称:{$order.sdmc}<br/>
订单号:{$order.order_sn}<br/>
下单时间:{$order.pay_time}<br/>
物流:{$order.shipping_name}<br/>
快递单号:{$order.invoice_no}<br/>
收件人:{$order.consignee}<br/>
&nbsp;<br/>
<a style="color:#749c18">快递公司---物流信息</a> 
<br/>
{$kuaidi.message}
&nbsp;<br/>
{foreach from=$kuaidi.data item=kuaidi} 
{$kuaidi.time}&nbsp;/&nbsp;{$kuaidi.context}&nbsp;<br/>
{/foreach}
&nbsp;<br/>
<a style="color:#749c18">以下是商家发货信息</a> <br/>

{foreach from=$order.ac item=ac} 
{$ac.action_time}&nbsp;/&nbsp;{$ac.action_user}&nbsp;/&nbsp;{$ac.action_name}<br/>
{/foreach}
&nbsp;<hr style="BORDER-BOTTOM-STYLE: dotted; BORDER-LEFT-STYLE: dotted; BORDER-RIGHT-STYLE: dotted; BORDER-TOP-STYLE: dotted;color:#77b900; size=1;"  />

{foreachelse}

</p>
{/foreach}


{foreach from=$weixiaodian item=weixiaodian} 
<p>

订单号:{$weixiaodian.order_sn}<br/>
购买日期:{$weixiaodian.add_t}<br/>
订单状态:{if $weixiaodian.order_status==2}<span style="color:">待发货</span>{elseif $weixiaodian.order_status==3}<span style="color:green">已发货</span>{elseif $weixiaodian.order_status==5}已完成{elseif $weixiaodian.order_status==8}<span style="color:red">维权</span>{else}{/if}<br/>
<!--物流:{$order.shipping_name}<br/>
快递单号:{$order.invoice_no}<br/>-->
商品:{$weixiaodian.product_name}<br/>
数量:{$weixiaodian.product_count}件<br/>
零售价:￥{$weixiaodian.ori_price_total}<br/>
金额:￥{$weixiaodian.order_total_price}
</p>
{if $weixiaodian.or_status=='0'}
<p style="text-align: right;"><span  sn="{$weixiaodian.order_sn}" class="querensh" style="padding: 10px 20px 10px 20px;background-color: green;color:white; margin-bottom: -10px;">确认收货</span>&nbsp;&nbsp;&nbsp;<span  sn="{$weixiaodian.order_sn}" class="shenqtk" style="padding: 10px 20px 10px 20px;background-color: red;color:white; margin-bottom: -10px;">申请退款</span></p>
{elseif $weixiaodian.or_status=='1'}
<p style="text-align: right;"><span  class="" style="padding: 10px 20px 10px 20px;background-color: green;color:white; margin-bottom: -10px;">已完成</span></p>
{elseif $weixiaodian.or_status=='2' or $weixiaodian.or_status=='3'}
<p style="text-align: right;"><span  class="" style="padding: 10px 20px 10px 20px;background-color: green;color:white; margin-bottom: -10px;">申请退款中</span></p>
{elseif $weixiaodian.or_status=='4'}
<p style="text-align: right;"><span  class="" style="padding: 10px 20px 10px 20px;background-color: green;color:white; margin-bottom: -10px;">同意退款</span></p>
{elseif $weixiaodian.or_status=='5'}
<p style="text-align: right;"><span  class="" style="padding: 10px 20px 10px 20px;background-color: green;color:white; margin-bottom: -10px;">已退款</span></p>
{/if}
&nbsp;<hr style="BORDER-BOTTOM-STYLE: dotted; BORDER-LEFT-STYLE: dotted; BORDER-RIGHT-STYLE: dotted; BORDER-TOP-STYLE: dotted;color:#77b900; size=1;"  />



{foreachelse}
<p>
您暂时无购买记录
</p>

{/foreach}





</div>




</div>
</div>
{/if}
</body>
</html>
<script type="text/javascript">
<!--
        $("#yanzheng").click(function (){
            
            $("#djmsg").slideUp(0);
            $("#duij").hide();
            
            var sncode=$("#sncode").val();
            var openid=$("#op").val();
        $.ajax({
			url: "mcenter.php?act=search_code",
			dataType: "json",
            type: 'POST',
            //async:false,
			data: {
                "sncode":sncode,
                "openid":openid

			},
			beforeSend: function() {
			
			},
			success: function(data) {
			      if(data.err_code==1)
                  {
                       alert(data.err_msg); 
                  }
                  else
                  {
           
                    
                    $("#djmsg").slideDown();
                    $("#msg1").text("★活动名称："+data.list.hd_sn+"/"+data.list.activity_name);
                    $("#msg2").text("★奖项："+data.list.jpmc);
                    $("#msg3").text("★中奖时间："+data.list.add_time);
                    $("#msg4").text("★中奖码："+data.list.sncode);
                   
                    $("#msg5").text("★有效期至："+data.list.limit_time);
                    
                    $("#duij").show();
                  }
              
			},
			error: function() {
			  //alert(1);
			  //alert(2);return;
			},
			
		})
        })
        
        $("#duij").click(function (){
          
            
            var sncode=$("#sncode").val();
            var openid=$("#op").val();
        $.ajax({
			url: "mcenter.php?act=search_code2",
			dataType: "json",
            type: 'POST',
            //async:false,
			data: {
                "sncode":sncode,
                "openid":openid

			},
			beforeSend: function() {
			
			},
			success: function(data) {
			      if(data.err_code==1)
                  {
                       alert(data.err_msg); 
                  }
                  else
                  {
                    alert(data.err_msg); 
                    $("#djmsg").slideUp(0);
                    $("#duij").hide();
                    
                  }
              
			},
			error: function() {
			  //alert(1);
			  //alert(2);return;
			},
			
		})
            
        })
	   
       
       $("#jifenmingxi").click(function(){
            $("#jfmx").fadeToggle(100);
            $("#jfmx2").fadeToggle(100);
       })
       
       
       $(".duihjf").click(function (){
            
            var sncode=$(this).attr("sncode");
            var ex_point=$(this).attr("ex_point");
            
            var openid=$("#op").val();
            $.ajax({
    			url: "mcenter.php?act=duihuanjifen",
    			dataType: "json",
                type: 'POST',
                //async:false,
    			data: {
                    "sncode":sncode,
                    "openid":openid,
                    "ex_point":ex_point
    			},
    			beforeSend: function() {
    			
    			},
    			success: function(data) {
    			      if(data.err_code==1)
                      {
                           alert(data.err_msg); 
                      }
                      else
                      {
                        alert(data.err_msg); 
                    
                        
                      }
                      location.reload() ;
                  
    			},
    			error: function() {
    			  //alert(1);
    			  //alert(2);return;
    			},
    			
    		})
            
            
            
       })
       
       
       $("#headimgurl").click(function (){
            $("#sn_imgurl").fadeToggle(100);
       })
       
       $(".shenqtk").each(function(){
                $(this).click(function (){
                var sn=$(this).attr("sn");
                
                if(confirm("确认提交退款申请吗?")){
                     $.ajax({
            			url: "mcenter.php?act=set_or_status",
            			dataType: "json",
                        type: 'POST',
                        //async:false,
            			data: {
                            "sn":sn,
                            "or_status":'2'
            
            			},
            			beforeSend: function() {
            			
            			},
            			success: function(data) {
            			      if(data=='1')
                              {
                                   alert("请联系客服,说明退款信息"); 
                              }
                              else
                              {
                                    alert("异常"); 
                              }
                          
            			},
            			error: function() {
            			  
            			},
            			
            		})
                    
                }
                else
                {
                    return false;
                }
           
            
                 
            })
       })
       
       
       $(".querensh").each(function(){
                $(this).click(function (){
                var sn=$(this).attr("sn");
                
                if(confirm("确认后无法进行退款申请,购买10天后将自动确认收货")){
                     $.ajax({
            			url: "mcenter.php?act=set_or_status",
            			dataType: "json",
                        type: 'POST',
                        //async:false,
            			data: {
                            "sn":sn,
                            "or_status":'1'
            
            			},
            			beforeSend: function() {
            			
            			},
            			success: function(data) {
            			      if(data=='1')
                              {
                                   alert("已确认收货"); 
                              }
                              else
                              {
                                    alert("异常"); 
                              }
                          
            			},
            			error: function() {
            			  
            			},
            			
            		})
                    
                }
                else
                {
                    return false;
                }
           
            
                 
            })
       })
       
       
       
      
-->
</script>