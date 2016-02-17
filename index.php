<?php

define('IN_ECS', true);


require(dirname(__FILE__) . '/includes/init2.php');
$is_allow = $GLOBALS['db']->getOne(" select sesskey from sessions where sesskey='" .
        $_COOKIE['user_name'] . "' limit 1 ;");
       //echo $is_allow;exit;
    if ($is_allow) {
        //echo 1;
        echo "<script>window.location.href='tbhome_privilege.php';</script>";
    }
    else
    {   
        //echo 2;
        //echo "<script>window.location.href='index.php';</script>";
    }
//log_out();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登陆</title>
<link href="css/bs_login.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all" />
<link href="css/bs_demo.css" rel="stylesheet" rev="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>


<script type="text/javascript">
<!--
	
-->
</script>

<script type="text/javascript">
<!--
$(document).ready(function (){
	//$("#username").
     $("#username").focus();
});
-->
</script>
</head>

<body>




<div class="banner">

<div class="login-aside">
  <div id="o-box-up"></div>
  <div id="o-box-down"  style="table-layout:fixed;">
   <div class="error-box"></div>
   
   <form class="registerform"action="tbhome_login.php" method="POST">
   <div class="fm-item">
	   <label for="logonId" class="form-label">用户名</label>
	   <input type="text" value="" maxlength="100" id="username" name="us_name" class="i-text" />    
       <div class="ui-form-explain"></div>
  </div>
  
  <div class="fm-item">
	   <label for="logonId" class="form-label">登陆密码：</label>
	   <input type="password" value="" maxlength="100" id="password" name="psword" class="i-text" />    
       <div class="ui-form-explain"></div>
  </div>
  

  
  <div class="fm-item">
	   <label for="logonId" class="form-label"></label>
	   <input type="submit" value="" tabindex="4" id="send-btn" class="btn-login"/> 
       <div class="ui-form-explain"></div>
  </div>
  
  </form>
  
  </div>

</div>



	<div class="hd"><ul></ul></div>
</div>








</body>
</html>
