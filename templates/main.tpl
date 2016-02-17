<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微信后台管理</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
</head>

<body>

<div class="container">
  <div class="header"><a  id="ida"><img  src="images/mlogo.jpg"/></a><span style="text-align: right;position: absolute;right: 30px;top:40px" onclick="window.location.href='login.php?act=log_out'">注销</span></div>
  <div class="content">
    <div class="uldiv" >
    
    <ul>
    <li ><a >自动回复</a>
    
        <ul id="ul1">
      
         <li class="fli" name="attention.php"><a>关注回复</a></li>
         <li  class="fli" name="memu1.php"><a>自定义菜单</a></li>
       <li  class="fli" name="custom.php"><a>自定义回复</a></li>
        </ul>
    </li>
    <li ><a >模板设置</a>
    
        <ul>
      
         <li class="fli" name="text.php"><a>文本模板</a></li>
          <li  class="fli" name="imgtext.php"><a>图文模板</a></li>
           <li  class="fli" name="article.php"><a>HTML页面</a></li>
       
        </ul>
    </li>
    <li ><a >基础设置</a>
    
        <ul>
          
          <li id=""><a>公众号</a></li>
          <li class="fli" name="activity.php"><a>活动列表</a></li>
        </ul>
    </li>
    
      <li ><a >会员中心</a>
    
        <ul>
          <li class="fli" id="openid" name="openid.php"><a>关注者列表</a></li>
        </ul>
    </li>
      
    <li ><a>微官网</a>
    
        <ul>
		<!-- <li class="fli"  name="set_index.php?action=addnews"><a >微网设置</a></li>
          <li class="fli"  name="set_index.php?action=update"><a >微网首页</a></li>
          <li class="fli"  name="set_list.php"><a >微网列表</a></li>
          <li class="fli"  name="set_detail.php"><a >微网详细</a></li>
		  -->
		  
		  <li class="fli"  name="slide.php"><a >幻灯片</a></li>
		<li class="fli"  name="slide2.php"><a >分模块</a></li>
        <li><a href="../wx/index.php" target="_blank">查看</a></li>
        </ul>
       </li>
    
    </ul></div>
    <div class="framediv"><iframe id="frame" src="frame.php" frameBorder="0" width="100%" scrolling="yes" height="500px"></iframe></div>
  <!-- end .content --></div>
 
<!-- end .container --></div>
</body>
</html>

<script type="text/javascript">
<!--
  
    $(document).ready(function ()
{
    $(".uldiv ul li a").parent().find("ul").hide();


// $(this).click(function(){
//        $(".uldiv ul li a").parent().find("ul").slideUp();
//        
//        
//        if($(this).parent().find("ul").is(":visible")==true)
//        {
//           //$(this).parent().find("ul").slideUp();
//        }
//        else
//        
//        {
//            $(this).parent().find("ul").slideDown();
//        }
//    });
//
        
         

     $(".uldiv ul li a").click(function(){
        //alert( $(this).parent().find("ul").is(":visible"));
        $(".uldiv ul li a").parent().find("ul").hide();
        if($(this).parent().find("ul").is(":visible")==false)
        {
            $(this).parent().find("ul").show();
        }
        else
        {
             $(this).parent().find("ul").hide();
        }
        //$(this).parent().find("ul").slideToggle();
        
    });
    $(".fli").each(function(){
        $(this).click(function(){
           
            $("#frame").attr("src",$(this).attr("name"));
            
               $(".fli").each(function(){
                    $(this).removeClass("li_select2");
               })
                $(this).addClass("li_select2");
                 $(this).parent().show();
        })
       
    })
    
      $(".uldiv ul li ul li").mouseover(function(){
         $(this).addClass("li_select");
        }).mouseout(function(){
         $(this).removeClass("li_select");
         
        });
   
   
    var screenWidth = $(window).width();//获取屏幕可视区域的宽度。
      var screenHeight = $(window).height();
     screenHeight2= parseInt(screenHeight)-105;
     //alert(screenHeight2);
         $(".uldiv").height(screenHeight2+"px");
          $(".framediv").height(screenHeight2+"px");
        

          
})


-->
</script>