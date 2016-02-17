<?php

define('IN_ECS', true);


require(dirname(__FILE__) . '/includes/init2.php');
$is_allow = $GLOBALS['db']->getOne(" select sesskey from sessions where sesskey='" .
        $_COOKIE['user_name'] . "' limit 1 ;");
       //echo $is_allow;exit;
    if ($is_allow) {
        //echo 1;
        echo "<script>window.location.href='privilege.php';</script>";
    }
    else
    {   
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
<link rel="stylesheet" href="css/sh/style.default.css" type="text/css" />


<script type="text/javascript" src="js/sh/jquery-1.9.1.min.js"></script>

<script type="text/javascript" src="js/sh/jquery.cookie.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#login').submit(function(){
            var u = jQuery('#username').val();
            var p = jQuery('#password').val();
            if(u == '' || p == '') {
                jQuery('.login-alert').fadeIn();
                return false;
            }
           
        });
         $("#username").focus();
    });
    
    if(navigator.userAgent.indexOf("MSIE")>0){   
      if(navigator.userAgent.indexOf("MSIE 6.0")>0){   
        //alert("ie6"); 
        location='index.php';   
      }   
      if(navigator.userAgent.indexOf("MSIE 7.0")>0){  
        location='index.php'; 
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

<div class="loginpanel">
    <div class="loginpanelinner">
        <div class="logo animate0 bounceIn"><img src="images/logo.png" alt=""  style="display: none;" /></div>
        <form id="login" action="login.php" method="post">
            <div class="inputwrapper login-alert">
                <div class="alert alert-error">用户名 / 密码不能为空</div>
            </div>
            <div class="inputwrapper animate1 bounceIn">
                <input type="text" name="qudao" id="qudao" placeholder="输入渠道" value="000"  style="display: none;" />
            </div>
            <div class="inputwrapper animate0 bounceIn">
                <input type="text" name="us_name" id="username" placeholder="输入用户名" />
            </div>
            <div class="inputwrapper animate1 bounceIn">
                <input type="password" name="psword" id="password" placeholder="输入密码" />
            </div>
            <div class="inputwrapper animate2 bounceIn">
                <button name="submit">登陆</button>
            </div>
        
             <div class="inputwrapper animate5 bounceIn"  style="display: none;" >
                <label><input type="checkbox" class="remember" name="signin" />记住密码</label>
            </div>
            
        </form>
    </div><!--loginpanelinner-->
</div><!--loginpanel-->



</body>
</html>

