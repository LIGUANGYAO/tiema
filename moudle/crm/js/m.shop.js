
function md_val(){
    var md33=$.md5($.md5("!@#$%^&*("+$("#password").val())+"tiemal");
    $("#password").val(md33);
    $("#rePassWord").val(md33);
    
    
}


function md_login(){
    if($("#password").val()!='')
    {
        
       var md33=$.md5($.md5("!@#()"+$("#password").val()));
       //var md33=$.md5($("#password").val());
       $("#password").val(md33);
       
    }
    
    
    
}


