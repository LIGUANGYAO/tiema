<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>{$list.list_name}</title>
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta charset="utf-8">
<link href="templates/css/listhome1_5.css" rel="stylesheet" type="text/css" />


<style>
 #cate14 .mainmenu li a {
    background-color: rgba(4, 4, 4, 0.48);
    border-radius: 4px 4px 4px 4px;
    color: #FFFFFF;
    display: block;
    font-size: 16px;
    margin: 0 3px 3px 0;
    padding: 8px 10px;
    text-align: center;
    text-decoration: none;
}
 .themeStyle{ background-color:#3BA3FF !important; }  
</style>
</head>
<script>
window.onload = function ()
{
var oWin = document.getElementById("win");
var oLay = document.getElementById("overlay");	
var oBtn = document.getElementById("popmenu");
var oClose = document.getElementById("close");
oBtn.onclick = function ()
{
oLay.style.display = "block";
oWin.style.display = "block"	
};
oLay.onclick = function ()
{
oLay.style.display = "none";
oWin.style.display = "none"	
}
};
</script>
<body id="listhome1">
<div id="ui-header">
<div class="fixed">
<a class="ui-title" id="popmenu">导航</a>
<a class="ui-btn-left_pre" href="javascript:history.go(-1);"></a>
<a class="ui-btn-right"  href="w_list.php?id={$list.id}"></a></div>
</div>
<div id="overlay"></div>
<div id="win">
<ul class="dropdown"> 
{foreach from=$w_list item=w_list}
<li><a href="w_list.php?id={$w_list.id}"><span>{$w_list.list_name}</span></a></li>
{/foreach}
 	
<div class="clr"></div>
</ul>
</div>
<div class="Listpage">
<div class="top46"></div>
<!--
<div class="focus">
<ul>
<li>
<a href="http://www.sixianpu.com/buluo.php?ac=news3&wxrf=mp.weixin.qq.com&tid=1159">
<img alt="真实的泰坦尼克号故事。" src="http://bcs.duapp.com/tupian123/3zA0ExZply.jpg">
<div class="opacity"></div>
<h2>真实的泰坦尼克号故事。</h2>
</a>
</li>
</ul>
</div>
-->
<div id="todayList">
<ul  class="todayList">
{foreach from=$news_list item=news_list}      
<li>
<a href="w_detail.php?id={$news_list.id}">
<div class="img"><img src="{$news_list.imgurl}"></div>
<h2>{$news_list.title}</h2>
<p class="onlyheight"></p>
<div class="commentNum"></div>
</a></li>
{/foreach}
</ul>
</div>
<section id="Page_wrapper">
<div id="pNavDemo" class="c-pnav-con">
<section class="c-p-sec">
<div class="c-p-pre  c-p-grey  "><span class="c-p-p"><em></em></span><a   >上一页</a></div>
<div class="c-p-cur">
<div class="c-p-arrow c-p-down"><span>1/1</span><span></span></div>
                <select class="c-p-select" onchange="dourl('http://www.sixianpu.com/buluo.php?ac=listhome1&tid=2094&page='+this.value)">
<option   selected="selected"  value=1 >第1页</option>                </select>
</div>
<div class="c-p-next  c-p-grey  "  ><a    >下一页</a><span class="c-p-p"><em></em></span></div>
</section>
</div>
</section>
</div>
<script>
function dourl(url){
location.href= url;
}
</script>

 <div class="copyright"  >1223</div> <div style="display:none"> </div>
 <script type="text/javascript">
 	        document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
        window.shareData = {  
           "imgUrl": "", 
            "timeLineLink": "http://www.sixianpu.com/buluo.php?ac=listhome1&tid=2094&refex=mp.weixin.qq.com&from=app",
            "sendFriendLink": "http://www.sixianpu.com/buluo.php?ac=listhome1&tid=2094&refex=mp.weixin.qq.com&from=app",
            "weiboLink": "http://www.sixianpu.com/buluo.php?ac=listhome1&tid=2094&refex=mp.weixin.qq.com&from=app",
            "tTitle": "电影印迹",
            "tContent": "",
            "fTitle": "电影印迹",
            "fContent": "",
            "wContent": "" 
        };
        // 发送给好友
        WeixinJSBridge.on('menu:share:appmessage', function (argv) {
            WeixinJSBridge.invoke('sendAppMessage', { 
                "img_url": window.shareData.imgUrl,
                "img_width": "640",
                "img_height": "640",
                "link": window.shareData.sendFriendLink,
                "desc": window.shareData.fContent,
                "title": window.shareData.fTitle
            }, function (res) {
                _report('send_msg', res.err_msg);
            })
        });

        // 分享到朋友圈
        WeixinJSBridge.on('menu:share:timeline', function (argv) {
            WeixinJSBridge.invoke('shareTimeline', {
                "img_url": window.shareData.imgUrl,
                "img_width": "640",
                "img_height": "640",
                "link": window.shareData.timeLineLink,
                "desc": window.shareData.tContent,
                "title": window.shareData.tTitle
            }, function (res) {
                _report('timeline', res.err_msg);
            });
        });

        // 分享到微博
        WeixinJSBridge.on('menu:share:weibo', function (argv) {
            WeixinJSBridge.invoke('shareWeibo', {
                "content": window.shareData.wContent,
                "url": window.shareData.weiboLink,
            }, function (res) {
                _report('weibo', res.err_msg);
            });
        });
        }, false)
    </script>
</body>
</html>
