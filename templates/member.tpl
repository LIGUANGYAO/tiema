<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>个人中心</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no" />
   	<link href="css/member/member.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript">
	document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
    WeixinJSBridge.call('hideOptionMenu');
    });
    </script>
<style>
.proHeader{width:100%;height:44px;background:#E50065;overflow:hidden;margin:0 auto;font-family:微软雅黑;font-size:14px;}
.proHeader li{float:left;color:#fff;height:44px;line-height:44px;text-align:center; width:35px}
.proHeader li.back{width:58px;border-right:solid 1px #BD0155;}
.proHeader li.back a{color:#fff;font-size:14px;}
.proHeader li.xq{width:80px;border-left:solid 1px #ED4D95;font-size:16px;}
.proHeader li.fl{width:59px;border-left:solid 1px #BD0155;padding-top:2px;}
.proHeader li img{vertical-align:-3px;}



.user_m div{width:100%;height:10px;line-height:10px;overflow:hidden;padding:8px;}
.user ul li a:hover,.user ul li a.sel{background:#E50065;color:#fff;}
.user ul li a{display:block;height:35px;width:90px;color:#000000;font-size:14px;line-height:40px; text-align:center}
.user .user_ul div{width:100%;height:50px;line-height:50px;overflow:hidden;padding:0 8px;border-bottom:solid 1px #CCCCCC;background:url(images/member/record_bg.jpg) no-repeat 280px 18px 8px 12px;}
.user .user_ul div a{color:#000000;}
.user .user_ul div span{display:inline-block;width:231px;float:left;padding:0 0 0 39px;height:50px;line-height:50px;}
.user .user_ul div span.user_s6{background:url(images/member/user06.jpg) no-repeat 0 13px ;background-size:25px 25px;}
</style>
</head>
<body>

{if $fall=='list'}
    <ul class="proHeader">
        <li class="back"><a href="javascript:history.go(-1);"><img src="images/member/jianzuo.png" width="8" style="vertical-align:-1px;margin-right:3px;">返回</a></li>
        <li class="xq">个人中心</li>
    </ul>


<div class="user">
<div class="userM">
<div class="user_m">
<p>备注：</p>
<p>1.抵用券可在区域门店兑换,点击“<a href="wxcitylist.php"><font color="#FF0000">店铺查询</font></a>”查看附近店铺。</p>
<p>2.若区域无销售网点可到我司官方商城使用，网址：www.caslon.net.cn</p>
<p>3.抵用券不能兑换现金、不找零。</p>
<p>4.单笔消费满59元方可使用，淘金网消费时满59元包邮。</p>
<p>5.抵用券一单只允许用一张，不可累积使用。</p>
<p>6.抵用券使用时需在门店出示中奖码与手机号，经验证后方可使用。</p>
<p>7.本券可赠予他人，凭奖券编码及中奖人手机号，即可使用。</p>
<p>8.当月奖券第3张起，凭奖券(中奖记录)可参加爱心善捐活动或其它消费等。</p>
<p>9.本券不得购买非卡西龙产品(关联活动除外)，如有违规，消费者凭购买单，可向卡西龙总部投诉，当店将以一赔十，投诉电话：400-8877075</p>

</p>
</div>
    <ul class="user_ul">
	
	    <li><span class="user_s5" onclick="window.location='http://www.caslon.net.cn'">淘金网:<font color="#FF0000">http://www.caslon.net.cn</font></span></li>
        <li><span class="user_s5">您的淘金网账号:{$openid.wx_tel}</span></li>
        <li><span class="user_s5">淘金网原始密码:{$openid.wx_pwd}</span></li>
		<div><a href="member.php?fall=ewm&openid={$openid.openid}&is_active=1"><span class="user_s6">点击查询我的中奖记录</span></a></div>
    </ul>      
        <!--<li><a href="#"><span class="user_s4">我的积分</span></a></li>-->
</div>
</div>
{/if}
				 
{if $fall=='ewm'}

    <ul class="proHeader">
        <li class="back"><a href="javascript:history.go(-1);"><img src="images/member/jianzuo.png" width="8" style="vertical-align:-1px;margin-right:3px;">返回</a></li>
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
			        <li style="border-right:1px solid #CCCCCC;color:#000000;float:left; height:35px; width:32%;text-align:center;font-family:微软雅黑;font-size:14px; padding-left:5px;"><a  href="member.php?fall=ewm&openid={$openid2}&is_active=1" {if $is_active==1} class="sel"{/if}>未使用</a></li>
					
                    <li style="border-right:1px solid #CCCCCC;color:#000000;float:left;height:35px;  width:32%;text-align:center;font-family:微软雅黑;font-size:14px; padding-left:1px;"><a  href="member.php?fall=ewm&openid={$openid2}&is_active=0" {if $is_active==0} class="sel"{/if}>已使用</a></li>
					
					<li style="float:left;height:35px;  width:32%;text-align:center;font-family:微软雅黑;font-size:14px;padding-left:1px;"><a  href="member.php?fall=ewm&openid={$openid2}&is_active=2" {if $is_active==2} class="sel"{/if}>已作废</a></li>
			</ul>
</p>
</div>


{foreach from=$sncode item=sncode}
   <div class="user_m">
                <div>★&nbsp;活动名称：{$sncode.hd_sn}/{$sncode.activity_name}</div>
                <div>★&nbsp;奖项：{$sncode.jpmc}</div>
                <div>★&nbsp;中奖时间：{$sncode.add_time}</div>
		        <div>★&nbsp;中奖码：{$sncode.sncode}</div>
				<div>★&nbsp;有效期至：{$sncode.end_time}</div>
				{if $is_active==1}
                
                
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
                <p style="padding: 10px;">暂无记录</p>
                {/foreach}   
        <!--<li><a href="#"><span class="user_s4">我的积分</span></a></li>-->
</div>
</div>
{/if}


</body>
</html>
