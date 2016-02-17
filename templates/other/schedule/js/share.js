/* share.js by yukiiak */

(function(){

	function onBridgeReady() {

	    var appId  = 'wxe3e27533898a9694',
	        imgUrl = "",
	        link   = document.URL.replace(/wxid=([\w\-]+&?)|&wxid=([\w\-]+)/g,'').replace(/code=([\w]+&?)|&code=([\w]+)/,''),
	        title  = htmlDecode(document.title),
	        desc   = htmlDecode(document.title),
	        fakeid = "";
	        desc   = desc || link;  

        WeixinJSBridge.on('menu:share:appmessage', function(argv){
            WeixinJSBridge.invoke('sendAppMessage',{
                  "appid"      : appId,
                  "img_url"    : imgUrl,
                  "img_width"  : "640",
                  "img_height" : "640",
                  "link"       : link,
                  "desc"       : desc,
                  "title"      : title
            }, function(res) {});
        });

        WeixinJSBridge.on('menu:share:timeline', function(argv){
            WeixinJSBridge.invoke('shareTimeline',{
                  "img_url"    : imgUrl,
                  "img_width"  : "640",
                  "img_height" : "640",
                  "link"       : link,
                  "desc"       : desc,
                  "title"      : title
            }, function(res) {});
        
        });

        var weiboContent = '';
        WeixinJSBridge.on('menu:share:weibo', function(argv){
            WeixinJSBridge.invoke('shareWeibo',{
                  "content" : title + link,
                  "url"     : link
            }, function(res) {});
        });

        WeixinJSBridge.on('menu:share:facebook', function(argv){
            WeixinJSBridge.invoke('shareFB',{
                  "img_url"    : imgUrl,
                  "img_width"  : "640",
                  "img_height" : "640",
                  "link"       : link,
                  "desc"       : desc,
                  "title"      : title
            }, function(res) {} );
        });

	    WeixinJSBridge.on('menu:general:share', function(argv){
	        argv.generalShare({
                "appid"      : appId,
                "img_url"    : imgUrl,
                "img_width"  : "640",
                "img_height" : "640",
                "link"       : link,
                "desc"       : desc,
                "title"      : title
	        });
	    });
		
	}

	if (typeof WeixinJSBridge == "undefined"){
	    if( document.addEventListener ){
	        document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
	    }else if (document.attachEvent){
	        document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
	        document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
	    }
	}else{
	    onBridgeReady();
	}

})();
function htmlDecode(str){
return str
      .replace(/&#39;/g, '\'')
      .replace(/<br\s*(\/)?\s*>/g, '\n')
      .replace(/&nbsp;/g, ' ')
      .replace(/&lt;/g, '<')
      .replace(/&gt;/g, '>')
      .replace(/&quot;/g, '"')
      .replace(/&amp;/g, '&');
}