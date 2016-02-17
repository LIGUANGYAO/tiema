<?php
    define('IN_ECS', true);
    require (dirname(__file__) . '/includes/init.php');
    require (dirname(__file__) . '/sub/sub_openid.php');
    //echo $openid;
?>

<!DOCTYPE html>
<html>
	<head>
	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<title>
			大转盘抽奖
		</title>
		<link href="wheel/images/activity-style.css" rel="stylesheet" type="text/css">
	</head>
	<body class="activity-lottery-winning">
		<div class="main">
			<script type="text/javascript">
			//	var loadingObj = new loading(document.getElementById('loading'), {
//					radius: 20,
//					circleLineWidth: 8
//				});
//				loadingObj.show();
			</script>
			<script src="wheel/images/jquery.js" type="text/javascript">
			</script>
			<script src="wheel/images/alert.js" type="text/javascript">
			</script>
			<div id="outercont">
				<div id="outer-cont">
					<div id="outer">
						<img src="wheel/images/activity-lottery-3.png">
					</div>
				</div>
				<div id="inner-cont">
					<div id="inner">
						<img src="wheel/images/activity-lottery-2.png">
					</div>
				</div>
			</div>
			<div class="content">
				<div class="boxcontent boxyellow" id="result" style="display:none">
					<div class="box">
						<div class="title-orange">
							<span>
								恭喜你中奖了
							</span>
						</div>
						<div class="Detail">
							<p>
								你中了：
								<span class="red" id="prizetype">
								</span>
							</p>
							<p>
								兑奖SN码：
								<span class="red" id="sncode">
								</span>
							</p>
							<p class="red" id="red">
								本次兑奖码已经关联你的微信号，你可向公众号发送【大转盘】进行查询!
							</p>
							<p>
								<input name="" class="px" id="tel" value="" type="text" placeholder="用户请输入您的手机号">
							</p>
							<p>
								<p>
									<input class="pxbtn" name="提 交" id="save-btn" type="button" value="用户提交">
								</p>
								<!--<p>
									<input name="" class="px" id="parssword" type="password" value="" placeholder="商家输入兑奖密码">
								</p>
								<p>
									<input class="pxbtn" name="提 交" id="save-btnn" type="button" value="商家提交">
								</p>-->
						</div>
					</div>
				</div>
				<div class="boxcontent boxyellow">
					<div class="box">
						<div class="title-green">
							<span>
								奖项设置：
							</span>
						</div>
						<div class="Detail">
                            <p>
                                活动时间:
							</p>
							<p>
								一等奖： <?php if(empty($activity)){echo "礼品1";}
                                else{echo $activity[0]['prize1_jpms'];}?>。奖品数量：<?php if(empty($activity)){echo "0";}
                                else{echo $activity[0]['prize1_sl'];}?>
							</p>
							<p>
								二等奖： <?php if(empty($activity)){echo "礼品2";}
                                else{echo $activity[0]['prize2_jpms'];}?>。奖品数量：<?php if(empty($activity)){echo "0";}
                                else{echo $activity[0]['prize2_sl'];}?>
							</p>
							<p>
                                三等奖： <?php if(empty($activity)){echo "礼品3";}
                                else{echo $activity[0]['prize3_jpms'];}?>。奖品数量：<?php if(empty($activity)){echo "0";}
                                else{echo $activity[0]['prize3_sl'];}?>
							</p>
						</div>
					</div>
				</div>
				<div class="boxcontent boxyellow">
					<div class="box">
						<div class="title-green">
							活动说明：
						</div>
						<div class="Detail">
							<p class="red">
								<?php if(!empty($jsonstr2->nickname)){
								    echo $jsonstr2->nickname;
								}?><br />
                                本次活动总共可以转		<?php if(!empty($hd_number)){echo $hd_number;
								}else{echo 0;}?>次转盘!你已经转了<a id="lo_sum"></a>次
							</p>
							<p>
								亲，请点击进入大转盘抽奖活动页面，祝您好运哦！<div  id="id3"></div>
							</p>
                            	<p>
								<div  id="id4"></div>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
 
			$(function() {
			    
			 var openid1="<?php	echo $openid;?>";
             //alert(openid1);
				window.requestAnimFrame = (function() {
					return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame ||
					function(callback) {
						window.setTimeout(callback, 1000 / 60)
					}
				})();
				var totalDeg = 360 * 3 + 0;
                var steps = [];
				var lostDeg = [36, 96, 156, 216, 276, 336];
				var prizeDeg = [6, 66, 126, 186, 246, 306];
				var prize, sncode;
				var count = 0;
				var now = 0;
				var a = 0.01;
				var outter, inner, timer, running = false;
				function countSteps() {
					var t = Math.sqrt(2 * totalDeg / a);
					var v = a * t;
					for (var i = 0; i < t; i++) {
						steps.push((2 * v * i - a * i * i) / 2)
					}
					steps.push(totalDeg);
                   
                    //steps[steps.length]='2100';
				}
                
				function step() {
				    
               
                    outter.style.webkitTransform = 'rotate(' + steps[now++] + 'deg)';
					outter.style.MozTransform = 'rotate(' + steps[now++] + 'deg)';
                   
					
                   // alert(steps);
                  // $("#id2").html(steps.length);
                   //$("#id3").html(now);
                    //$("#id4").append(steps[now++]+"<br>");
                    
					if (now <= steps.length) {
				
						running = true;
						requestAnimFrame(step)
                       
					} else {
					  
						running = false;
						setTimeout(function() {
						    // prize=1;
							if (prize != null) {
								$("#sncode").text(sncode);
								var type = "";
                                if (prize == 1) {
									type = "一等奖"
								} else if (prize == 2) {
									type = "二等奖"
								} else if (prize == 3) {
									type = "三等奖"
								} else if (prize == 4) {
									type = "四等奖"
								} else if (prize == 5) {
									type = "五等奖"
								} else if (prize == 6) {
									type = "六等奖"
								}
								$("#prizetype").text(type);
								$("#result").slideToggle(500);
								$("#outercont").slideUp(500)
							} else {
							 
								alert("您未中奖哦！");
                               
							}
						},
						200)
					}
				}
                
				function start(deg) {
					deg = deg || lostDeg[parseInt(lostDeg.length * Math.random())];
                    //alert(deg);
					running = true;
					clearInterval(timer);
					totalDeg = 360 * 5 + deg;
					steps = [];
					now = 0;
					countSteps();
					requestAnimFrame(step)
				}
				window.start = start;
				outter = document.getElementById('outer');
				inner = document.getElementById('inner');
				i = 10;
				$("#inner").click(function() {
                    
					if (running) return;
					if (count >= 3) {
						alert("您已经抽了 3 次奖,不能再抽了,下次再来吧!");
						return
					}
					if (prize != null) {
						alert("亲，你不能再参加本次活动了喔！下次再来吧~");
						return
					}
					//alert(1);
					// 更新数据库
					$.ajax({
						url: "wheel.php",
						dataType: "json",
						data: {
                            openid:openid1,
							token:openid1,
							ac: "activityuser",
							tid: "387",
							t: Math.random()
						},
						beforeSend: function() {
							running = true;
                            //alert(1);
							timer = setInterval(function() {
								i += 5;
								outter.style.webkitTransform = 'rotate(' + i + 'deg)';
								outter.style.MozTransform = 'rotate(' + i + 'deg)'
							},
							1)
						},
						success: function(data) {
						   
                           
                           //添加活动时间限制
                           	if (data.error == "activend") {
							 
								alert(data.msg);
		     	                count = 3;
								clearInterval(timer);
                                
								return
							}
                           
							if (data.error == "invalid") {
							 
								alert(data.msg);
								count = 3;
								clearInterval(timer);
                                
								return
							}
                            
                            
                           
							if (data.error == "getsn") {
                                
								$("#tel").val(data.tel);
								if (data.state == 2) {
									$("#closedj").css("display", "none");

								}
								$("#red").text(data.msg);
								alert(data.msg + data.sn);
								count = 3;
								clearInterval(timer);
								prize = data.prizetype;
								sncode = data.sn;
								start(prizeDeg[data.prizetype - 1]);
								return
							}
							if (data.success) {
						        //alert(1);
								prize = data.prizetype;
								sncode = data.sn;
                                $("#lo_sum").text(data.t_sum);
                                $("#c_sum").text(data.c_sum);
								start(prizeDeg[data.prizetype - 1])
							} else {
							     //alert(data.msg);
                                 $("#lo_sum").text(data.t_sum);
                                 $("#c_sum").text(data.c_sum);
								prize = null;
								start()
							}
							running = false;
							count++
						},
						error: function() {
						  //alert(1);
							prize = null;
							start();
							running = false;
							count++
						},
						timeout: 1000
					})
				})
			});
			$("#save-btn").bind("click", function() {
				var btn = $(this);
				var tel = $("#tel").val();
				if (tel == '') {
					alert("请输入手机号");
					return
				}

				var submitData = {
				    openid:"<?php	echo $openid;?>",
					tid: 387,
					code: $("#sncode").text(),
					tel: tel,
					action: "setTel"
				};
              
				$.post('wheel.php?act=setTel', submitData,
				function(data) {
					if (data.success == true) {
						alert(data.msg);
						if (data.changed == true) {
							window.location.href = location.href;
						}
						return
					} else {}
				},
				"json")
                
			});

			$("#save-btnn").bind("click", function() {
				var submitData = {
					tid: 387,
					code: $("#sncode").text(),
					parssword: $("#parssword").val(),
					action: "setTel"
				};
				
				// 更新数据库
				$.post('提交的URL', submitData,
				function(data) {
					if (data.success == true) {
						alert(data.msg);
						if (data.changed == true) {
							window.location.href = location.href;
						}
						return
					} else {}
				},
				"json")
			});
		</script>
		
	</body>

</html>