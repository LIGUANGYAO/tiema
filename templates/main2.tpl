<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
                tab.addTabItem({ tabid : tabid,text: text, url: url });
            } 
             
            
     </script> 
<style type="text/css"> 
        body,html{height:100%;}
    body{ padding:0px; margin:0;   overflow:hidden;}  
    .l-link{ display:block; height:26px; line-height:26px; padding-left:10px; text-decoration:underline; color:#333;}
    .l-link2{text-decoration:underline; color:white;}
    .l-layout-top{background:#102A49; color:White;}
    .l-layout-bottom{ background:#E5EDEF; text-align:center;}
    #pageloading{position:absolute; left:0px; top:0px; background:white url('loading.gif') no-repeat center; width:100%; height:100%;z-index:99999;}
    .l-link{ display:block; line-height:22px; height:22px; padding-left:20px;border:1px solid white; margin:4px;}
    .l-link-over{ background:#FFEEAC; border:1px solid #DB9F00;}
    
    .l-winbar{ background:#2B5A76; height:30px; position:absolute; left:0px; bottom:0px; width:100%; z-index:99999;}
 </style>
</head>
<body style="padding:0px;">  
<div id="pageloading"></div> 
  <div id="layout1" style="width:100%">
        <div position="top" style="background:#102A49; color:White; ">
            <div style="margin-top:10px; margin-left:10px">
            
                    <span>微信平台管理</span> 
     
            </div>
     
        </div>
        <div position="left"  title="管理" id="accordion1"> 
                    
                    <div title="应用场景">
                    <div style=" height:7px;"></div>
                         <a class="l-link" href="javascript:f_addTab('listpage','列表页面','demos/case/listpage.htm')">列表页面</a> 
    
                    </div>    
        </div>
        <div position="center" id="framecenter"> 
            <div tabid="home" title="我的主页" style="height:300px" >
                <iframe frameborder="0" name="home" id="home" src="welcome.htm"></iframe>
            </div> 
        </div> 
        <div position="bottom" style=" padding-top:5px;">
            Copyright © 2011-2012 www.ligerui.com
        </div>
    </div>  

        <div style="display:none">
    <!-- 流量统计代码 --> 
    </div>
</body>
</html>
