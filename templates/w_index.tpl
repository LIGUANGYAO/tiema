<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$list}</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link href="templates/css/iscroll.css" rel="stylesheet" type="text/css" />
<link href="templates/css/cate14_5.css" rel="stylesheet" type="text/css" />

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
<body  id="cate14">
<div class="mainbg"><img src="files/{$w_index.imgurl}" /></div>
<div class="mainmenu">
<ul><div id="insert1" ></div>
{foreach from=$w_list item=w_list}
<li>
<div class="menubtn">
<a href="w_list.php?id={$w_list.id}">{$w_list.list_name}</a>
</div>
</li>
{/foreach}
<div id="insert2" ></div>
<div class="clr"></div>
</ul>
</div>
<div class="copyright">版权所有：铁马科技</div> <div style="display:none"> </div>

<script>
var count = document.getElementById("thelist").getElementsByTagName("img").length;	

var count2 = document.getElementsByClassName("menuimg").length;
for(i=0;i<count;i++){
 document.getElementById("thelist").getElementsByTagName("img").item(i).style.cssText = " width:"+document.body.clientWidth+"px";

}
document.getElementById("scroller").style.cssText = " width:"+document.body.clientWidth*count+"px";

 setInterval(function(){
myScroll.scrollToPage('next', 0,400,count);
},3500 );
window.onresize = function(){ 
for(i=0;i<count;i++){
document.getElementById("thelist").getElementsByTagName("img").item(i).style.cssText = " width:"+document.body.clientWidth+"px";

}
 document.getElementById("scroller").style.cssText = " width:"+document.body.clientWidth*count+"px";
} 


</script>

 
 
 <script type="text/javascript">
 	        document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
        window.shareData = {  
           "imgUrl": "1", 
            "timeLineLink": "2",
            "sendFriendLink": "3",
            "weiboLink": "4",
            "tTitle": "1111",
            "tContent": "1111",
            "fTitle": "1111",
            "fContent": "1111",
            "wContent": "1111" 
        };
        // ���͸�����
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

        // ���������Ȧ
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

        // �����΢��
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