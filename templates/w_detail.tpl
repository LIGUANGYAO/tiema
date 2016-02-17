<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<title>{$news1.title}</title> 
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta charset="utf-8">
<link href="templates/css/news3_5.css" rel="stylesheet" type="text/css" />
<script src="js/audio.min.js" type="text/javascript"></script>
   
    <script>
      audiojs.events.ready(function() {
        audiojs.createAll();
      });
    </script>

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
<body id="news">
<div id="mcover" onclick="document.getElementById('mcover').style.display='';"><img src="index/images/guide.png"></div>
<div id="ui-header">
<div class="fixed">
<a class="ui-title" id="popmenu">导航</a>
<a class="ui-btn-left_pre" href="javascript:history.go(-1);"></a><a class="ui-btn-right_home" href="w_index.php"></a></div>
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
<div class="page-bizinfo">

<div class="header" style="position: relative;">
<h1 id="activity-name">{$news1.title}</h1>
<span id="post-date">{$news1.add_time}</span>　<span class="commentNum">浏览次数:20</span></div>
<div class="showpic"></div> 
<div class="text" id="content">
{$news1.content}</div>                      
<div id="insert3" ></div>
</div>

 <script src="js/play.js" type="text/javascript"></script>
   
 <script>
function dourl(url){
location.href= url;
}
</script>
<div class="page-content" ></div>
</div>


</div>	
        
<a class="footer" href="#" target="_self"><span class="top">返回顶部</span></a>



 
<div style="display:none"> </div>
</div>
 <script type="text/javascript">
 	        document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
        window.shareData = {  
            "imgUrl": "http://bcs.duapp.com/picstore/7Fs0N8aKu4.jpg", 
            "timeLineLink": 'http://www.sixianpu.com/buluo.php?ac=news3&tid=5035&from=app',
            "sendFriendLink": 'http://www.sixianpu.com/buluo.php?ac=news3&tid=5035&from=app',
            "weiboLink": 'http://www.sixianpu.com/buluo.php?ac=news3&tid=5035&from=app',
            "tTitle": "天堂是图书馆的模样",
            "tContent": "",
            "fTitle": "天堂是图书馆的模样",
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
