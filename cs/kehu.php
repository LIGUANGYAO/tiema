<!Doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="telephone=no" name="format-detection">
<title>60万高端客户</title>
<link type="text/css" rel="stylesheet" href='/css/base.css?1444794438' />
<link type="text/css" rel="stylesheet" href='/css/layout.css?1444794438' />
<link type="text/css" rel="stylesheet" href='/css/style.css?1444794438' />
<link type="text/css" rel="stylesheet" href='/css/scrollBar.css?1444794438' />
<script src="/js/zepto.min.js?1444794438" type="text/javascript"></script>
<script src="/js/layer.m.js?1444794438" type="text/javascript"></script>
<script src="/js/iscroll.js?1444794438" type="text/javascript"></script>
<script src="/js/validate.js?1444794438" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	if (window.history && window.history.pushState) {

		$(window).on('popstate', function () {
		var hashLocation = location.hash;
		var hashSplit = hashLocation.split("#!/");
		var hashName = hashSplit[1];
		if (hashName !== '') {
		var hash = window.location.hash;
		if (hash === '') {
			$('.qt img').attr('src','/images/quan.jpg?1444794438');
			$(".qt").hide();
			$("#bodyDiv").show();
		}
		}
		});
		
	}
})
</script>
</head>
<body> 
<div class="qt" style="width:100%;height:100%;display:none;"> 
 <div class="mcheck">
    <div> 
        <img src="/images/quan.jpg?1444794438" onclick="$('.qt img').attr('src','/images/quan.jpg');$('.qt').hide();$('#bodyDiv').show();history.go(-1);"/>
    </div>
</div>
</div>

<div id="bodyDiv">
<!--顶部bar-->
<div class="index_bar">
	<a href="/fanGroup/search">
		<div class="sousuo"><i class="icon-fdj">&nbsp;&nbsp;搜索</i></div>
	</a>
	<!--<a href="javascript:;" onclick="report();">
		<div class="index_hongbao">
			<div class="red">
			<label>举报</label></div>
		</div>
	</a>-->
</div>
<!--顶部bar结束-->
<div id="wrapper" style="top:42px;bottom:50px;">
	<div id="scroller">
		<div id="data_list">
		</div>
		<div id="pullUp">
			<span class="pullUpIcon"></span><span class="pullUpLabel">上拉加载更多...</span>
		</div>
	</div>
</div>
  
<!--底部导航-->
<!--顶层菜单 -->

<!--主菜单开始-->
  <div class="navigation_bar_abs">
    <ul class="list">
      <a href="/fanGroup/index" opt='directd'>
					<div class="botml on">60万高端客户</div>
		      </a> 
	  <a href="/Me/eBook" opt='directd'>
					<div class="botmm">在线阅读</div>
		      </a> 
	  <!--<a href="/DreamSinks/index" opt='directd'>
					<li class="icon-friends wx"></li>
		      </a> -->
	  <a href="/me/Index" opt='directd'>
					<div class="botmr">个人中心</div>
		      </a>
    </ul>
  </div>
<!--主菜单结束-->

<!--底部导航end-->
</div>

<script type="text/javascript">
var myScroll,
	pullDownEl, pullDownOffset,
	pullUpEl, pullUpOffset,
	page = 1,
	pagesize = 10,
	datas,
	j = 0,
	baseUrl = "",
	cHeight = document.documentElement.clientHeight,
	index_barH = $(".index_bar").get(0).offsetHeight,
	navigation_barH = $(".navigation_bar_abs").get(0).offsetHeight,
	pullUpH = $("#pullUp").get(0).offsetHeight,
	infolineH,
	wapperH = cHeight-index_barH-navigation_barH,
	hasDiv,
	randInt = parseInt(2000*Math.random());   //取0-2000的随机整数;

pullUpAction();

/**
 * 滚动翻页 （自定义实现此方法）
 * myScroll.refresh();		// 数据加载完成后，调用界面更新方法
 */
function pullUpAction () {
	//setTimeout(function () {	// <-- Simulate network congestion, remove setTimeout from production!
		$.ajax({
			url: baseUrl + "/fanGroup/getList/",
			type: "post",
			data: {'randInt':randInt,'cpage':page,'pagesize':pagesize},
			dataType: 'json',
			success:function(data){
				//if(page === 1)
					//$("#data_list").html("");
			    datas = data.results;
				if(datas.length != 0){
					var html = '';
					for(var i in datas)
					{
						var sex_class = datas[i].sex == 1 ? 'icon-man' : 'icon-women';
						var btn_class = datas[i].is_add == 1 ? 'addbtn_t' : 'addbtn';
						var place = (datas[i].province+datas[i].city).subByte(0,20);
						var temp_j = parseInt(j)+parseInt(i)+1;
						html += '<div class="infoline" j='+temp_j+'><div class="infopic"><img src="/images/smallAvatars/'+datas[i].user_id+'.jpeg?1444794438" onerror="javascript:this.src=\'/images/default.jpg\'"/></div><div class="infotxt"><div class="name"><i class="'+sex_class+'"></i>&nbsp;'+datas[i].nickname.subByte(0,10)+'</div><div class="locat"><i class="icon-location"></i>&nbsp;'+place+'</div></div><a href="javascript:;" onclick="add_friend(\''+datas[i].user_id+'\');"><div id="'+datas[i].user_id+'" class="'+btn_class+'"><i class="icon-add"></i> 添加</div></a></div>';
					}
					$("#data_list").append(html);
					infolineH = $(".infoline").get(0).offsetHeight;
					hasDiv = Math.ceil((wapperH-pullUpH)/infolineH);   //有多少个DIV可以显示
					
					page += 1;
					j = $("div.infoline").last().attr('j');
					myScroll.refresh();
				}else{
					//没数据继续从头开始加载
					randInt = 0;
					page = 1;
					pullUpAction();			
				}			
			}
		});
	//}, 1000);	// <-- Simulate network congestion, remove setTimeout from production!
}

/**
 * 初始化iScroll控件
 */
function loaded() {
	pullUpEl = document.getElementById('pullUp');	
	pullUpOffset = pullUpEl.offsetHeight;
	
	myScroll = new iScroll('wrapper', {
		//scrollbarClass: 'myScrollbar', /* 滚动条样式 */
		bounce:true,    //是否超过实际位置反弹
		vScrollbar:false,    //不显示垂直滚动条
		//useTransition: false, /* 此属性不知用意，本人从true改为false */
		//topOffset: pullDownOffset,
		onRefresh: function () {

		},
		onScrollMove: function () {

		},
		onScrollEnd: function () {
			//拉到最底部自动加载  40:头部 50:底部 40:上拉刷新DIV高度   51:iscroll计算的每个单位DIV高度				
			if (Math.abs(this.y) > ((j-hasDiv)*infolineH) && pullUpEl.querySelector('.pullUpLabel').innerHTML != '没数据咯...') {
				pullUpEl.className = 'loading';
				pullUpEl.querySelector('.pullUpLabel').innerHTML = '加载中...';				
				pullUpAction();	// Execute custom function (ajax call?)
			}
		}
	});
}

//初始化绑定iScroll控件 
document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
document.addEventListener('DOMContentLoaded', loaded, false); 

//加为好友 显示微信二维码 并记录加好友日志
function add_friend(user_id)
{
	//加入了粉丝团或者成为了赞助商，都可以无限量加好友
						layer.open({
				content:'对不起，您还没有上传二维码，请先上传自己的微信二维码。',
				btn:['上传二维码'],
				yes:function(){
					location.href = '/me/uploadCode';
				}
			});		
			}

//举报 
function report()
{
	layer.open({content:'涉嫌欺诈，色情，谣言，违法，侵权等请拨打<a href="tel:15067995220">15067995220</a>举报'});
}
</script>
</body>
</html>