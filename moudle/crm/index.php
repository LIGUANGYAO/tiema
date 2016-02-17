<?php

define('IN_ECS', true);


require (dirname(__file__) . '/includes/init2.php');
$is_allow = $GLOBALS['db']->getOne(" select sesskey from sessions where sesskey='" .
    $_COOKIE['user_name'] . "' limit 1 ;");
//echo $is_allow;exit;
if ($is_allow) {
    //echo 1;
    echo "<script>window.location.href='privilege.html';</script>";
} else {
    //echo 2;
    //echo "<script>window.location.href='index.php';</script>";
}
//log_out();

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>登陆</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
	<link href="css/templatemo_style.css" rel="stylesheet" type="text/css">	

<script type="text/javascript" src="js/sh/jquery-1.9.1.min.js"></script>

<script type="text/javascript" src="js/sh/jquery.cookie.js"></script>
<script type="text/javascript" src="js/jquery.md5.js"></script>
<script type="text/javascript" src="js/m.shop.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#login').submit(function(){
            
            var u = jQuery('#username').val();
            var p = jQuery('#password').val();
            
            if(u=='')
            {
                 $("#username").focus();
                return false;
            }else if(p=='')
            {
                 $("#password").focus();
                return false;
            }
              var password = $('#password').val().replace(/\s*/, ""); 
              
                md_login();  
        
            
        });
         $("#username").focus();
    });
    
    if(navigator.userAgent.indexOf("MSIE")>0){   
      if(navigator.userAgent.indexOf("MSIE 6.0")>0){   
        //alert("ie6"); 
        //location='indexf.php';   
      }   
      if(navigator.userAgent.indexOf("MSIE 7.0")>0){  
        //location='indexf.php'; 
        //alert("ie7");   
      }   
      if(navigator.userAgent.indexOf("MSIE 9.0")>0 && !window.innerWidth){//这里是重点，你懂的
        //alert("ie8");  
      }   
      if(navigator.userAgent.indexOf("MSIE 9.0")>0){  
        //alert("ie9");  
      }   
    }
</script>
</head>

<body class="loginpage">

<body class="templatemo-bg-gray">
	<div class="container" style="margin-top: 20px;">
		<div class="col-md-12">
			<h1 class="margin-bottom-15">登陆</h1>
			<form class="form-horizontal templatemo-container templatemo-login-form-1 margin-bottom-30" role="form" action="login.html" id="login" method="post">
                				
		        <div class="form-group">
		          <div class="col-xs-12">		            
		            <div class="control-wrapper">
		            	<label for="username" class="control-label fa-label"><i class="fa fa-user fa-medium"></i></label>
		            	<input type="text" class="form-control"  name="us_name" id="username" placeholder="用户名">
		            </div>		            	            
		          </div>              
		        </div>
		        <div class="form-group">
		          <div class="col-md-12">
		          	<div class="control-wrapper">
		            	<label for="password" class="control-label fa-label"><i class="fa fa-lock fa-medium"></i></label>
		            	<input type="password" class="form-control" name="psword" id="password" placeholder="密码">
		            </div>
		          </div>
		        </div>
		        <div class="form-group" style="display: none;">
		          <div class="col-md-12">
	             	<div class="checkbox control-wrapper">
	                	<label>
	                  		<input type="checkbox"> 记住
                		</label>
	              	</div>
		          </div>
		        </div>
		        <div class="form-group" style="display: none1;">
		          <div class="col-md-12">
		          	<div class="control-wrapper">
		          		<input type="submit" value="登陆" class="btn btn-info">
		          		<a href="" class="text-right pull-right"></a>
		          	</div>
		          </div>
		        </div>
		        <hr>
		        <div class="form-group" style="display: none;">
		        	<div class="col-md-12">
		        		<label>支持登录: </label>
		        		<div class="inline-block">
		        			<a href="#"><i class="fa fa-facebook-square login-with"></i></a>
			        		<a href="#"><i class="fa fa-twitter-square login-with"></i></a>
			        		<a href="#"><i class="fa fa-google-plus-square login-with"></i></a>
			        		<a href="#"><i class="fa fa-tumblr-square login-with"></i></a>
			        		<a href="#"><i class="fa fa-github-square login-with"></i></a>
		        		</div>		        		
		        	</div>
		        </div>
		      </form>
		      <div class="text-center"  style="display: none;" >
		      	<a href="" class="templatemo-create-new">创建新帐户 <i class="fa fa-arrow-circle-o-right"></i></a>	
		      </div>
		</div>
	</div>
</body>


</body>
</html>

<script type="text/javascript">
<!--
    
     $("#login").submit(function ()
    {   
        
      //  var password = $('#password').val().replace(/\s*/, ""); 
       // md_login();
        //alert($("#password").val());return false;
         
    })
    
    
    
-->
</script>

