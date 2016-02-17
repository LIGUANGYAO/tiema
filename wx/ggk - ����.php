<?php
    define('IN_ECS', true);
    require (dirname(__file__) . '/includes/init.php');
    require (dirname(__file__) . '/sub/sub_openid3.php');
   
    if($_REQUEST['m'])
    {
        $openid=trim($_REQUEST['m']);
    }
      
    //$openid='oGehCt0ItOgYNXXippd-2sfZk-us';
    //echo $openid;exit;
    if(empty($openid))
    {
    ?>
<!DOCTYPE html>
<html>
	<head>
	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<title>刮刮卡活动</title>
		<link href="wheel/images/activity-style2.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript">
		function loading(canvas, options) {
			this.canvas = canvas;
			if (options) {
				this.radius = options.radius || 12;
				this.circleLineWidth = options.circleLineWidth || 4;
				this.circleColor = options.circleColor || 'lightgray';
				this.moveArcColor = options.moveArcColor || 'gray';
			} else {
				this.radius = 12;
				this.circelLineWidth = 4;
				this.circleColor = 'lightgray';
				this.moveArcColor = 'gray';
			}
		}
		loading.prototype = {
			show: function() {
				var canvas = this.canvas;
				if (!canvas.getContext) return;
				if (canvas.__loading) return;
				canvas.__loading = this;
				var ctx = canvas.getContext('2d');
				var radius = this.radius;
				var me = this;
				var rotatorAngle = Math.PI * 1.5;
				var step = Math.PI / 6;
				canvas.loadingInterval = setInterval(function() {
					ctx.clearRect(0, 0, canvas.width, canvas.height);
					var lineWidth = me.circleLineWidth;
					var center = {
						x: canvas.width / 2,
						y: canvas.height / 2
					};

					ctx.beginPath();
					ctx.lineWidth = lineWidth;
					ctx.strokeStyle = me.circleColor;
					ctx.arc(center.x, center.y + 20, radius, 0, Math.PI * 2);
					ctx.closePath();
					ctx.stroke();
					//在圆圈上面画小圆   
					ctx.beginPath();
					ctx.strokeStyle = me.moveArcColor;
					ctx.arc(center.x, center.y + 20, radius, rotatorAngle, rotatorAngle + Math.PI * .45);
					ctx.stroke();
					rotatorAngle += step;

				},
				100);
			},
			hide: function() {
				var canvas = this.canvas;
				canvas.__loading = false;
				if (canvas.loadingInterval) {
					window.clearInterval(canvas.loadingInterval);
				}
				var ctx = canvas.getContext('2d');
				if (ctx) ctx.clearRect(0, 0, canvas.width, canvas.height);
			}
		};
	</script>
	</head>
	<body data-role="page" class="activity-scratch-card-winning">
		<script src="wheel/images/jquery.js" type="text/javascript"></script>
		<script src="wheel/images/wScratchPad.js" type="text/javascript"></script>
		<div class="main">
		
			<div class="content">
				<div id="zjl" style="display:none" class="boxcontent boxwhite">
					<div class="box">
						<div class="title-orange">
							<span>
								恭喜你中奖了
							</span>
						</div>
						<div class="Detail">
						<p>您中了：<span class="red" id="pr1"></span>&nbsp;等奖</p>
			         	<p class="red" >兑奖码：<span class="red" id="pr_sn"></span></p>
							<p class="red"></p>
							<p>
								<input name="" class="px" id="tel" value="" type="text" placeholder="用户请输入您的手机号">
							</p>
							<p>
								<p>
									<input class="pxbtn" name="提 交" id="save-btn" type="button" value="用户提交">
								</p>
                                <!--
								<p>
									<input name="" class="px" id="parssword" type="password" value="" placeholder="商家输入兑奖密码">
								</p>
								<p>
									<input class="pxbtn" name="提 交" id="save-btnn" type="button" value="商家提交">
								</p>-->
						</div>
					</div>
				</div>
				<div class="boxcontent boxwhite">
					<div class="box">
						<div class="title-brown">
							<span>
								系统信息
							</span>
						</div>
						<div class="Detail">
								<p>
							 未获取用户信息,请重新进入活动界面
							</p>
						
						</div>
					</div>
				</div>
				
			</div>
			<div style="clear:both;">
			</div>
		</div>
		<script src="wheel/images/alert.js" type="text/javascript"></script>
		<script type="text/javascript">
        
			window.sncode = "null";
			window.prize = "谢谢参与";
            var openid1='<?php echo $openid;?>';
            var count = 0;
			var zjl = false;
			var num = 0;
			var goon = true;
			$(function() {
				$("#scratchpad").wScratchPad({
				   
					width: 150,
					height: 40,
					color: "#a9a9a7",
					scratchMove: function() {
					  
						num++;
                        if(num==1)
                        {
                           
                            //判断概率
                         	$.ajax({
        						url: "wheel3.php",
        						dataType: "json",
                                async:false,
        						data: {
                                    openid:openid1,
        						//	token:openid1,
        //							ac: "activityuser",
        //							tid: "387",
        //							t: Math.random()
        						},
        						beforeSend: function() {
        						
        						},
        						success: function(data) {
        						     
                                     
                                   
                                   //添加活动时间限制
                                   	if (data.error == "activend") {
        							 
        			                    alert(data.msg);
        		     	                count = 3;
        							
                                        goon=false;  
        								return
        							}
                                   
        							if (data.error == "invalid") {
        							 
        								alert(data.msg);
        								count = 3;
        							     
                                        goon=false;
        								return
        							}
                                    
                                    
                                   
        							if (data.error == "getsn") {
                                        alert(data.msg);
        								count = 3;
                                        goon=false;
        								return
        							}
        							if (data.success) {
        						        //alert(data.msg);
        							
                                        $("#pr1").text(data.c_sum);
                                        $("#pr_sn").text(data.sn);
                                        
                                        
                                       	document.getElementById('prize').innerHTML = data.msg;
                                    
                                        zjl=true;
                                        winprize=data.msg;
        								
        							} else {
        							     //alert(data.msg);
                                        
                                        document.getElementById('prize').innerHTML = "谢谢参与";
        								
        							}
        							running = false;
        							count++
        						},
        						error: function() {
        						  //alert(1);
        						  //alert(2);return;
        						},
        						
        					})
                      
                            //zjl=true;
                        }
                       
					//	if (num == 2) {
//						  
//							document.getElementById('prize').innerHTML = "谢谢参与";
//						}
                        
                   
						if (zjl && num > 5 && goon) {
						  
                          
                            
							//$("#zjl").fadeIn();
							goon = false;

							$("#zjl").slideToggle(500);
							//$("#outercont").slideUp(500)
						}
					}
				});

				//$("#prize").html("谢谢参与");
				//loadingObj.hide();
				//$(".loading-mask").remove();
			});

			$("#save-btn").bind("click", function() {
				var btn = $(this);
				var tel = $("#tel").val();
				if (tel == '') {
					alert("请输入手机号");
					return
				}

			//	var submitData = {
//					tid: 438,
//					code: $("#sncode").text(),
//					tel: tel,
//					action: "setTel"
//				};
//				$.post('index.php?ac=acw', submitData,
//				function(data) {
//					if (data.success == true) {
//						alert(data.msg);
//						return
//					} else {}
//				},
//				"json")

                	var submitData = {
				    openid:"<?php	echo $openid;?>",
					tid: 387,
					code:  $("#pr_sn").text(),
					tel: tel,
					action: "setTel"
				};
              
				$.post('wheel3.php?act=setTel', submitData,
				function(data) {
					if (data.success == true) {
						alert(data.msg);
                        
						if (data.changed == true) {
							window.location.href = location.href;
						}else
                        {
                            // run();
                                            
                        }
						return
					} else {}
				},
				"json")
                
                
			});

			// 保存数据
			$("#save-btnn").bind("click", function() {
				//var btn = $(this);
				var submitData = {
					tid: 438,
					code: $("#sncode").text(),
					parssword: $("#parssword").val(),
					action: "setTel"
				};
				$.post('index.php?ac=acw', submitData,
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

    <?php
    }
    else
    {
        
    
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
		<title>刮刮卡活动</title>
		<link href="wheel/images/activity-style2.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript">
		function loading(canvas, options) {
			this.canvas = canvas;
			if (options) {
				this.radius = options.radius || 12;
				this.circleLineWidth = options.circleLineWidth || 4;
				this.circleColor = options.circleColor || 'lightgray';
				this.moveArcColor = options.moveArcColor || 'gray';
			} else {
				this.radius = 12;
				this.circelLineWidth = 4;
				this.circleColor = 'lightgray';
				this.moveArcColor = 'gray';
			}
		}
		loading.prototype = {
			show: function() {
				var canvas = this.canvas;
				if (!canvas.getContext) return;
				if (canvas.__loading) return;
				canvas.__loading = this;
				var ctx = canvas.getContext('2d');
				var radius = this.radius;
				var me = this;
				var rotatorAngle = Math.PI * 1.5;
				var step = Math.PI / 6;
				canvas.loadingInterval = setInterval(function() {
					ctx.clearRect(0, 0, canvas.width, canvas.height);
					var lineWidth = me.circleLineWidth;
					var center = {
						x: canvas.width / 2,
						y: canvas.height / 2
					};

					ctx.beginPath();
					ctx.lineWidth = lineWidth;
					ctx.strokeStyle = me.circleColor;
					ctx.arc(center.x, center.y + 20, radius, 0, Math.PI * 2);
					ctx.closePath();
					ctx.stroke();
					//在圆圈上面画小圆   
					ctx.beginPath();
					ctx.strokeStyle = me.moveArcColor;
					ctx.arc(center.x, center.y + 20, radius, rotatorAngle, rotatorAngle + Math.PI * .45);
					ctx.stroke();
					rotatorAngle += step;

				},
				100);
			},
			hide: function() {
				var canvas = this.canvas;
				canvas.__loading = false;
				if (canvas.loadingInterval) {
					window.clearInterval(canvas.loadingInterval);
				}
				var ctx = canvas.getContext('2d');
				if (ctx) ctx.clearRect(0, 0, canvas.width, canvas.height);
			}
		};
	</script>
	</head>
	<body data-role="page" class="activity-scratch-card-winning">
		<script src="wheel/images/jquery.js" type="text/javascript"></script>
		<script src="wheel/images/wScratchPad.js" type="text/javascript"></script>
		<div class="main">
			<div class="cover">
				<img src="wheel/images/activity-scratch-card-bannerbg.png" style="height: 300px;">
				<div id="prize">
				</div>
				<div id="scratchpad">
				</div>
			</div>
			<div class="content">
				<div id="zjl" style="display:none" class="boxcontent boxwhite">
					<div class="box">
						<div class="title-orange">
							<span>
								恭喜你中奖了
							</span>
						</div>
						<div class="Detail">
						<p>您中了：<span class="red" id="pr1"></span>&nbsp;等奖</p>
			         	<p class="red" >兑奖码：<span class="red" id="pr_sn"></span></p>
							<p class="red"></p>
							<p>
								<input name="" class="px" id="tel" value="" type="text" placeholder="用户请输入您的手机号">
							</p>
							<p>
								<p>
									<input class="pxbtn" name="提 交" id="save-btn" type="button" value="用户提交">
								</p>
                                <!--
								<p>
									<input name="" class="px" id="parssword" type="password" value="" placeholder="商家输入兑奖密码">
								</p>
								<p>
									<input class="pxbtn" name="提 交" id="save-btnn" type="button" value="商家提交">
								</p>-->
						</div>
					</div>
				</div>
				<div class="boxcontent boxwhite">
					<div class="box">
						<div class="title-brown">
							<span>
								奖项设置：
							</span>
						</div>
						<div class="Detail">
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
				<div class="boxcontent boxwhite">
					<div class="box">
						<div class="title-brown">
							活动说明：
						</div>
						<div class="Detail">
							 <p>
								<?php if(!empty($jsonstr2->nickname)){
								    echo $jsonstr2->nickname;
								}?><br />
                                每人每天最多有		<?php if(!empty($hd_number)){echo $hd_number;
								}else{echo 0;}?>次机会!这是您第<a id="lo_sum"></a>次刮奖
							</p>
							<p  class="red">
								亲，请点击进入刮刮奖活动页面，祝您好运哦！
							</p>
						</div>
					</div>
				</div>
			</div>
            
            
            
            	<div id="nextone" style="display:none1" class="boxcontent boxwhite">
					<div class="box">
						
					
						
								<p>
									<input class="pxbtn" name="提 交" onclick="location='ggk.php?m=<?php echo $openid;?>'" id="save-btn" type="button" value="再来一次">
								</p>
                             
						</div>
					</div>
				</div>
            
			<div style="clear:both;">
			</div>
		</div>
		<script src="wheel/images/alert.js" type="text/javascript"></script>
		<script type="text/javascript">
        
			window.sncode = "null";
			window.prize = "谢谢参与";
            var openid1='<?php echo $openid;?>';
            var count = 0;
			var zjl = false;
			var num = 0;
			var goon = true;
			$(function() {
				$("#scratchpad").wScratchPad({
				   
					width: 150,
					height: 40,
					color: "#a9a9a7",
					scratchMove: function() {
					  
						num++;
                        if(num==1)
                        {
                           
                            //判断概率
                         	$.ajax({
        						url: "wheel3.php",
        						dataType: "json",
                                async:false,
        						data: {
                                    openid:openid1,
        						//	token:openid1,
        //							ac: "activityuser",
        //							tid: "387",
        //							t: Math.random()
        						},
        						beforeSend: function() {
        						
        						},
        						success: function(data) {
        						     
                                     
                                   
                                   //添加活动时间限制
                                   	if (data.error == "activend") {
        							 
        			                    alert(data.msg);
        		     	                count = 3;
        							
                                        goon=false;  
        								return
        							}
                                   
        							if (data.error == "invalid") {
        							 
        								alert(data.msg);
        								count = 3;
        							     
                                        goon=false;
        								return
        							}
                                    
                                    
                                   
        							if (data.error == "getsn") {
                                        alert(data.msg);
        								count = 3;
                                        goon=false;
        								return
        							}
        							if (data.success) {
        						        //alert(data.msg);
        							
                                        $("#pr1").text(data.c_sum);
                                        $("#pr_sn").text(data.sn);
                                        
                                        
                                       	document.getElementById('prize').innerHTML = data.msg;
                                    
                                        zjl=true;
                                        winprize=data.msg;
        								
        							} else {
        							     //alert(data.msg);
                                        
                                        document.getElementById('prize').innerHTML = "谢谢参与";
        								
        							}
        							running = false;
        							count++
        						},
        						error: function() {
        						  //alert(1);
        						  //alert(2);return;
        						},
        						
        					})
                      
                            //zjl=true;
                        }
                       
					//	if (num == 2) {
//						  
//							document.getElementById('prize').innerHTML = "谢谢参与";
//						}
                        
                   
						if (zjl && num > 5 && goon) {
						  
                          
                            
							//$("#zjl").fadeIn();
							goon = false;

							$("#zjl").slideToggle(500);
							//$("#outercont").slideUp(500)
						}
                        
					}
				});

				//$("#prize").html("谢谢参与");
				//loadingObj.hide();
				//$(".loading-mask").remove();
			});

			$("#save-btn").bind("click", function() {
				var btn = $(this);
				var tel = $("#tel").val();
				if (tel == '') {
					alert("请输入手机号");
					return
				}

			//	var submitData = {
//					tid: 438,
//					code: $("#sncode").text(),
//					tel: tel,
//					action: "setTel"
//				};
//				$.post('index.php?ac=acw', submitData,
//				function(data) {
//					if (data.success == true) {
//						alert(data.msg);
//						return
//					} else {}
//				},
//				"json")

                	var submitData = {
				    openid:"<?php	echo $openid;?>",
					tid: 387,
					code:  $("#pr_sn").text(),
					tel: tel,
					action: "setTel"
				};
              
				$.post('wheel3.php?act=setTel', submitData,
				function(data) {
					if (data.success == true) {
						alert(data.msg);
                    
						if (data.changed == true) {
							window.location.href = location.href;
						}else
                        {
                            // run();
                                            
                        }
						return
					} else {}
				},
				"json")
                
                
			});

			// 保存数据
			$("#save-btnn").bind("click", function() {
				//var btn = $(this);
				var submitData = {
					tid: 438,
					code: $("#sncode").text(),
					parssword: $("#parssword").val(),
					action: "setTel"
				};
				$.post('index.php?ac=acw', submitData,
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

<?php
	}
?>