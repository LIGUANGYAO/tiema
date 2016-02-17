<!DOCTYPE html>
<html>
<head>
<title>{$wxmusic.title}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta name="format-detection" content="telephone=no" />
<link rel="stylesheet" href="../../templates/zyw/css/css.css">
<script src="../../templates/zyw/js/jquery-2.0.0.min.js"></script>
<script src="../../templates/zyw/js/move.min.js"></script>
<script src="../../templates/zyw/js/common.js"></script>
<script>
 var nexturl;
 var preurl;
 var songtitle;
nexturl = "";
preurl = "";
songtitle = "{$wxmusic.title}";
function next_song()
	{
		if (nexturl == 'nextnan')
		{
			alert("所选资源列表播放结束！");		
		}else{
		window.location.href=nexturl;
		}
	}
	function prev_song()
	{
		if (preurl == 'prenan')
		{
			alert("这是所选列表的第一首,请点击下一首！");
		}else{
		window.location.href=preurl;
		}

	}

 </script>
</head>
<body>
<!-- <div class="gz"></div> -->
<header>
  <div class="title ico">{$wxmusic.title}</div>
  <!-- <div class="back" onclick="history.go(-1)" ></div>-->
  <div class="controls"><a href="../../zywindex.php"><img src="../../templates/zyw/images/icon-toggle.png"></a> </div>
</header>
<div class="cover_bg">
  <div class="cover_pic" id="cover_pic"><a href="javascript:void(0)" id="fmlist" class="homebtn"></a>
    <div class="playbg">
      <div class="songtitle" id="songtitle"></div>
      <div class="auther" id="auther">{$wxmusic.title}</div>
      <div class="progdiv">
        <div class="pgbg">
          <div id="pgbuf" class="pgbuf" style="width: 0%;"></div>
          <div id="pgtime" class="pgtime" style="width: 0%;"></div>
        </div>
      </div>
      <div class="playbtns"><a href="javascript:void(0)" id="prevbtn" class="prevbtn" onClick="prev_song()"></a> <a href="javascript:void(0)" id="playbtn" class="playbtn"></a> <a href="javascript:void(0)" id="nextbtn" class="nextbtn" onClick="next_song()"></a> </div>
    </div>
  </div>
</div>
<!-- <div class="songintro" id="songintro">www.Tom61.com</div> -->
<audio id="song_player" src="../../{$wxmusic.imgurl}" preload="auto" autoplay="autoplay"></audio>

<div id="fmlistbox" class="fmlistbox">
  <div class="header">
    <header> 
	   <a href="javascript:void(0)" id="all_list" class="list_style">资源列表</a> 
	   <a href="javascript:void(0)" id="fmlista" class="fmlista"></a> 
	</header>
  </div>
  
  <div id="fmlistdiv" class="fmlistdiv">
    <dl>
    </dl>
  </div>
</div>
<script>
$(function() {
	initsite();
		$('#fmlist').click(function(){
		move('#fmlistbox').set('left', 0).end();
		return false;
	});
	$('#fmlista').click(function(){
		move('#fmlistbox').sub('left', dwidth).end();
		return false;
	});
	player.init('#song_player');

});
</script>
</body>
</html>
