
<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/login2.php');


if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {

    //获取登陆信息
    $us = getlogin_name();
    $u_info = "select user_code,user_name,user_name2 from admin_user where user_name ='" .
        $us . "'";
    $u_info = $GLOBALS['db']->getRow($u_info);


    //
    $new_list = new new_login_on();
    $new_list->user_sn = $u_info['user_code'];

    $action_1 = $new_list->get_action_c1();
    for ($i = 0; $i < count($action_1); $i++) {

        $action_1[$i]['ke'] = "tree" . ($i + 1);
        $new_list->obj = $action_1[$i]['action_id'];
        $action_1[$i]['action_2'] = $new_list->get_action_c2();

        for ($k = 0; $k < count($action_1[$i]['action_2']); $k++) {
            $new_list->obj2 = $action_1[$i]['action_2'][$k]['action_id'];
            $action_1[$i]['action_2'][$k]['action_3'] = $new_list->get_action_c3();
            $action_1[$i]['action_2'][$k]['sum'] = count($action_1[$i]['action_2'][$k]['action_3']);

            $action_1[$i]["a_sum"] += $action_1[$i]['action_2'][$k]['sum'];
        }

    }
    //print_r($action_1);exit;

}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head><script type="text/javascript">
<!--
	  function killerrors() {
                return true;
            }
            window.onerror = killerrors;
            
            


-->
</script>
    <title>微信推广平台</title>
    <link href="css/lib/ligerUI/skins/Aqua/css/ligerui-all.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
    </style>

    <script src="css/lib/jquery/jquery-1.3.2.min.js" type="text/javascript"></script>    
    <script src="css/lib/ligerUI/js/ligerui.min.js" type="text/javascript"></script>
    <script src="css/lib/ligerUI/js/plugins/ligerTab.js" type="text/javascript"></script>
        <script type="text/javascript">
          
            
            var tab = null;
            var accordion = null;
            var tree = null;
            $(function ()
            {

                //布局
                $("#layout1").ligerLayout({ leftWidth: 190, height: '100%', onHeightChanged: f_heightChanged });

                var height = $(".l-layout-center").height();

                //Tab
                $("#framecenter").ligerTab({ height: height });

                //面板
                $("#accordion1").ligerAccordion({ height: height - 24, speed: null });

                $(".l-link").hover(function ()
                {
                    $(this).addClass("l-link-over");
                }, function ()
                {
                    $(this).removeClass("l-link-over");
                });
                //树
                $("#tree1").ligerTree({
                    checkbox: false,
                    slide: false,
                    nodeWidth: 120,
                    attribute: ['nodename', 'url'],
                    onSelect: function (node)
                    {
                        if (!node.data.url) return;
                        var tabid = $(node.target).attr("tabid");
                        if (!tabid)
                        {
                            tabid = new Date().getTime();
                            $(node.target).attr("tabid", tabid)
                        }
                        /*if ($(">ul >li", tab.tab.links).length >= 4)
                        {
                            var currentTabid = $("li.l-selected", tab.tab.links).attr("tabid"); //当前选择的tabid
                            if (currentTabid == "home") return;
                            tab.overrideTabItem(currentTabid, { tabid: tabid, url: node.data.url, text: node.data.text });
                            return;
                        }*/
                        f_addTab(tabid, node.data.text, node.data.url);
                    }
                });
                
                $("#tree2").ligerTree({
                    checkbox: false,
                    slide: false,
                    nodeWidth: 120,
                    attribute: ['nodename', 'url'],
                    onSelect: function (node)
                    {
                        if (!node.data.url) return;
                        var tabid = $(node.target).attr("tabid");
                        if (!tabid)
                        {
                            tabid = new Date().getTime();
                            $(node.target).attr("tabid", tabid)
                        }
                        /*if ($(">ul >li", tab.tab.links).length >= 4)
                        {
                            var currentTabid = $("li.l-selected", tab.tab.links).attr("tabid"); //当前选择的tabid
                            if (currentTabid == "home") return;
                            tab.overrideTabItem(currentTabid, { tabid: tabid, url: node.data.url, text: node.data.text });
                            return;
                        }*/
                        f_addTab(tabid, node.data.text, node.data.url);
                    }
                });
                
                 $("#tree3").ligerTree({
                    checkbox: false,
                    slide: false,
                    nodeWidth: 120,
                    attribute: ['nodename', 'url'],
                    onSelect: function (node)
                    {
                        if (!node.data.url) return;
                        var tabid = $(node.target).attr("tabid");
                        if (!tabid)
                        {
                            tabid = new Date().getTime();
                            $(node.target).attr("tabid", tabid)
                        }
                        /*if ($(">ul >li", tab.tab.links).length >= 4)
                        {
                            var currentTabid = $("li.l-selected", tab.tab.links).attr("tabid"); //当前选择的tabid
                            if (currentTabid == "home") return;
                            tab.overrideTabItem(currentTabid, { tabid: tabid, url: node.data.url, text: node.data.text });
                            return;
                        }*/
                        f_addTab(tabid, node.data.text, node.data.url);
                    }
                });
                
                 $("#tree4").ligerTree({
                    checkbox: false,
                    slide: false,
                    nodeWidth: 120,
                    attribute: ['nodename', 'url'],
                    onSelect: function (node)
                    {
                        if (!node.data.url) return;
                        var tabid = $(node.target).attr("tabid");
                        if (!tabid)
                        {
                            tabid = new Date().getTime();
                            $(node.target).attr("tabid", tabid)
                        }
                        /*if ($(">ul >li", tab.tab.links).length >= 4)
                        {
                            var currentTabid = $("li.l-selected", tab.tab.links).attr("tabid"); //当前选择的tabid
                            if (currentTabid == "home") return;
                            tab.overrideTabItem(currentTabid, { tabid: tabid, url: node.data.url, text: node.data.text });
                            return;
                        }*/
                        f_addTab(tabid, node.data.text, node.data.url);
                    }
                });
                
                 $("#tree5").ligerTree({
                    checkbox: false,
                    slide: false,
                    nodeWidth: 120,
                    attribute: ['nodename', 'url'],
                    onSelect: function (node)
                    {
                        if (!node.data.url) return;
                        var tabid = $(node.target).attr("tabid");
                        if (!tabid)
                        {
                            tabid = new Date().getTime();
                            $(node.target).attr("tabid", tabid)
                        }
                        /*if ($(">ul >li", tab.tab.links).length >= 4)
                        {
                            var currentTabid = $("li.l-selected", tab.tab.links).attr("tabid"); //当前选择的tabid
                            if (currentTabid == "home") return;
                            tab.overrideTabItem(currentTabid, { tabid: tabid, url: node.data.url, text: node.data.text });
                            return;
                        }*/
                        f_addTab(tabid, node.data.text, node.data.url);
                    }
                });
                tab = $("#framecenter").ligerGetTabManager();
                accordion = $("#accordion1").ligerGetAccordionManager();
                tree = $("#tree1").ligerGetTreeManager();
                $("#pageloading").hide();
                
                
                
                
            });
            function f_heightChanged(options)
            {
                if (tab)
                    tab.addHeight(options.diff);
                if (accordion && options.middleHeight - 24 > 0)
                    accordion.setHeight(options.middleHeight - 24);
            }
            function f_addTab(tabid,text, url)
            { 
                //alert(tabid);
                tab.addTabItem({ tabid : tabid,text: text, url: url });
            } 
             
            
     </script> 
<style type="text/css"> 
        body,html{height:100%;}
    body{ padding:0px; margin:0;   overflow:hidden;}  
    .l-link{ display:block; height:26px; line-height:26px; padding-left:10px; text-decoration:underline; color:#333;}
    .l-link2{text-decoration:underline; color:white;}
    .l-layout-top{background:#102A49; color:White;}
    .l-layout-bottom{ background:#E5EDEF; text-align:center; }
    #pageloading{position:absolute; left:0px; top:0px; background:white url('') no-repeat center; width:100%; height:100%;z-index:99999;}
    .l-link{ display:block; line-height:22px; height:22px; padding-left:20px;border:1px solid white; margin:4px;}
    .l-link-over{ background:#FFEEAC; border:1px solid #DB9F00;}
    
    .l-winbar{ background:#2B5A76; height:30px; position:absolute; left:0px; bottom:0px; width:100%; z-index:99999;}
 </style>
 
 <link media="screen" rel="stylesheet" href="css/demo.css"/>


<script type="text/javascript">
jQuery(document).ready(function(){
	var qcloud={};
	$('[_t_nav]').hover(function(){
		var _nav = $(this).attr('_t_nav');
		clearTimeout( qcloud[ _nav + '_timer' ] );
		qcloud[ _nav + '_timer' ] = setTimeout(function(){
		$('[_t_nav]').each(function(){
		$(this)[ _nav == $(this).attr('_t_nav') ? 'addClass':'removeClass' ]('nav-up-selected');
		});
		$('#'+_nav).stop(true,true).slideDown(200);
		}, 150);
	},function(){
		var _nav = $(this).attr('_t_nav');
		clearTimeout( qcloud[ _nav + '_timer' ] );
		qcloud[ _nav + '_timer' ] = setTimeout(function(){
		$('[_t_nav]').removeClass('nav-up-selected');
		$('#'+_nav).stop(true,true).slideUp(200);
		}, 150);
	});
});
</script>

</head>
<body style="padding:0px;">  
<div id="pageloading"></div> 

<!-- -->
<!--
      <div class="head-v3" onclick="//$(this).slideUp();" >
      
	<div class="navigation-up">
		<div class="navigation-inner">
			<div class="navigation-v3">
				<ul>
                        <?php foreach ($action_1 as $acl) {
                if ($acl['a_sum'] > 0) {
                ?>
                    <li class="nav-up-selected-inpage" _t_nav="<?php echo $acl['action_id']; ?>">
						<h2>
							<a ><b><?php echo $acl['action_name']; ?></b></a>
						</h2>
					</li>
                <?php 
                } }?>
					<li class="" _t_nav="message">
						<h2>
							<a ><b>信息</b><b style="color: red;">(0)</b> </a> </a>
						</h2>
					</li>
                    
                    <li class="" _t_nav="" onclick="location='login.php?act=log_out'">
						<h2>
							<a ><b>注销</b></a>
						</h2>
					</li>
					<!--
					<li class="" _t_nav="cooperate">
                    
                    <!--
						<h2>
							<a ><b>会员管理</b></a>
						</h2>
					</li>
				    <li class="" _t_nav="cooperate2">
						<h2>
							<a ><b>基础档案</b></a>
						</h2>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="navigation-down">
		
        <?php foreach ($action_1 as $acl) {
            if ($acl['a_sum'] > 0) {
        ?>
            <div id="<?php echo $acl['action_id']; ?>" class="nav-down-menu menu-3 menu-1" style="display: none;" _t_nav="<?php echo $acl['action_id']; ?>">
            <div class="navigation-down-inner">
                <?php foreach ($acl['action_2'] as $act2) {
                if ($act2['sum'] > 0) {
                
                ?>
				<dl style="margin-left: 25px;">
                 <dt><?php echo $act2['action_name']; ?></dt>
                    <?php foreach ($act2['action_3'] as $acl3) { ?>
					<dd>
						<a class="link" hotrep="hp.header.1.1" cid="<?php echo $acl3['action_id']; ?>"  url="<?php echo $acl3['action_code']; ?>" ><?php echo $acl3['action_name']; ?></a>
					</dd>
                    <?php 
                    } ?>
                   
				</dl>
				<?php 
                } }?>
			</div>
		  </div>
        <?php 
        } }?>
        
	
        
        <div id="message" class="nav-down-menu menu-3 menu-1" style="display: none;" _t_nav="message">
			<div class="navigation-down-inner" >
				<dl style="margin-left: 320px;">
					<dd>
						<a class="link1" hotrep="hp.header.message.1" >新信息</a>
					</dd>
				</dl>
                <dl >
					<dd>
						<a class="link1" hotrep="hp.header.message.1" >系统信息</a>
					</dd>
				</dl>
			</div>
		</div>
        
	</div>
</div>
        -->
    
    <!-- -->
    <div id="layout1" style="width:100%;" >
       <div position="top" style="background:#102A49; color:White; float: left;"  >
        <div style="margin-top:10px; margin-left:10px;width: 190px; float: left;">     
        <span >微信平台管理&nbsp;&nbsp;&nbsp;</span> 
        </div>
    
    
    </div> 
        
        
        <div   position="left"  title="<?php
echo $u_info['user_name'] . "[" . $u_info['user_name2'] . "]";
?>" id="accordion1"> 
              <?php foreach ($action_1 as $acl) {
    if ($acl['a_sum'] > 0) {
?>
                <div title="<?php echo $acl['action_name']; ?>" >
               <ul id="<?php echo $acl['ke']; ?>" style="margin-top:3px;" >
               
                             <?php foreach ($acl['action_2'] as $act2) {
            if ($act2['sum'] > 0) {

?>
                                
                             <li isexpand="false"><span><?php echo $act2['action_name']; ?></span>
                                 <ul> 
                                 <?php foreach ($act2['action_3'] as $acl3) { ?>
                                    <li url="<?php echo $acl3['action_code']; ?>"><span><?php echo
                    $acl3['action_name']; ?></span></li>
                                    <?php } ?>
                                 </ul>
                             </li>
                             <?php }
        } ?>
                             
                </ul>          
                </div>
              <?php }
} ?>
               
                    
                    
                    <div title="关于">
                    <div style=" height:7px;"></div>         
                   
                         <a class="l-link" href="login.php?act=log_out">注销</a> 
                       
                    </div>  
            </div>
        <div position="center" id="framecenter"> 
            <div  title="我的主页" style="height:300px" >
                <iframe frameborder="0" name="home" id="home" src="frame.php"></iframe>
            </div> 
        </div> 
        <!--
        <div position="bottom" style=" padding-top:5px; " >
            铁马科技 www.tiemal.com
        </div>-->
    </div>  

        
    <!-- 流量统计代码<div style="display:none"> </div> --> 
   
</body>
</html>

<script type="text/javascript">
<!--


    $("#accordion1 div").each(function(){
            var ti=$(this).attr('title');
            if(ti=="会员管理")
            {
                 //alert($(this).attr('title'));
                 $(this).change();
            }
           
        })
    
        
        
        $(".link").click(function(){
            var url=$(this).attr("url");
            var va=$(this).text();
            var cid=$(this).attr("cid");
            //alert(url);
            tabid = new Date().getTime();
            
            tab.addTabItem({ tabid : cid,text: va, url: url });
            //$("#framecenter div iframe").attr("src",url);
        })
        
        $(".head-v3").click(function(){
            //$(this).slideUp(500,function(){
//                 //alert(1);
//                // alert(tab.setTabButton());
//            })
        })
      

-->
</script>