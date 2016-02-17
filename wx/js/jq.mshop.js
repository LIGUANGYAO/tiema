$(document).ready(function (){
     $("#dataLoad").hide(); 
     $("#dataLoad").css({'opacity':'1','width':'100%','height':'100%'});
    $("#pager_Size").keydown(function (e){
       
       if(e.keyCode==13){
        //alert($(this).val());
        var aaa=parseInt($(this).val());
        $.cookie('pager_Size',aaa, { expires: 7 });
        window.location.reload();
        }
       
      
    });
    //$('#fir').attr('href','shoppeisong.php?addid='+value+''); 
    $("#page_num").keydown(function (e){
        if(e.keyCode==13){
        //alert($("#now_url").val());
        location.href =$("#now_url").val()+"&pager_PageID="+$(this).val();
        //window.location.reload();
        }
    })
    $("#table_1 tr:even td").addClass("li_bg1");
    $("#table_1 tr:odd td").addClass("li_bg2");

    $("#nex").click(function ()
    {
       $.get("table.php?act=update", {Action:"get",Name:"lulu"}, function (data, textStatus){
        //返回的 data 可以是 xmlDoc, jsonObj, html, text, 等等.
        this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
        //alert(textStatus);
        //请求状态：success，error等等。
        //当然这里捕捉不到error，因为error的时候根本不会运行该回调函数
        //alert(this);
        window.location.reload();
        
        });
    })
    
    $("#form_1").submit(function (){
        
    })
    
    
    
    $("#key").keyup(function(){
    //alert(1);
         $("#table_t tr").hide().filter(":contains('"+$(this).val()+"')").show();
         //$("#table_1 tbody tr").is(":visible").attr("name","Checkbox2");
        // $("#table_1 tbody tr").attr("name","Checkbox2");
        //alert( $("#table_1 tbody tr").hide().length);
    }).keyup();
    
  /*
     if(!$("#table_1").is(":hidden")){  
   //显示前要写的代码  
   alert(1);  
       }  
     
   */
  

  $("#check_all").click(function() {
   /*
     if($("#table_1 tbody tr").is(":visible")))
        {
            alert(1);
        } 
    */
    
    //if (!!$("#checkbox2").attr("checked")) {                    alert("ddd");                }
    
    //if($("input[id='chbox']").is(":visible")==true)
   // {
            
      /*
          for (var i=0;i< $("input[id='chbox']").length;i++)
                {
                      
                }
       */
           //var objNewDiv ='';
            $("input[id='chbox']").each(function (){
              
                if($(this).is(":visible")==true)
                {   
                     $(this).attr({'id':'chbox2'})
                   // alert($("input[id='chbox']").eq(i));
                    ////alert(i);
                    //$("input[id='chbox']").prop("checked", this.checked);
                    //$("input[id='chbox']").eq(i).append($("aaa"));
                   //$("input[id='chbox']").prop("checked", this.checked);
                }
                else
                {
                    $(this).attr({'id':'chbox'})
                    //$("input[id='chbox']").eq(i).attr({'id':'chbox2'})
                   // alert($("input[id='chbox']").eq(i).is(":visible"));
                }
                
            })
        //objNewDiv.prop("checked", this.checked);
         $("input[id='chbox2']").prop("checked", this.checked);
         
        // alert($("input[id='chbox']").filter(":visible"));
   // }
   
  });
 
  
  $("input[id='chbox']").click(function() {
    var $subs = $("input[id='chbox']");
    $("#check_all").prop("checked" , $subs.length == $subs.filter(":checked").length ? true :false);
  });
  
    $("#form_1").submit(function (){
        $("#dataLoad").show(); 
        
    })
    
});




/*
 $(function() { 
 $("#Text1").keyup(function() { 
 var filterText = $(this).val(); 
 $("#<%=GridView1.ClientID %> tr").not(":first").hide().filter(":contains('" + filterText + "')").show();; 
 }).keyup(); 
 }); 
 */