$(function(){
    $(".footer_list li").bind("click",function(e){
        stopPropagation(e);
        var btn = $(this);
        btn.find("ul").toggle(0,function(){btn.siblings().find("ul").hide();});
    });
    function stopPropagation(e) {
        if (e.stopPropagation)
            e.stopPropagation();
        else
            e.cancelBubble = true;
    }
    $(window).bind("click scroll",function(){
        $(".sub_menu").hide();
    });

    $(":input").focus(function(){
    	$(".footer").hide();
    });
    $(":input").blur(function(){
    	$(".footer").show("fast");
    });
});