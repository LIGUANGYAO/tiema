
function md_val(){
    var md33=$.md5($.md5($.md5("!@#$%^&*("+$("#PassWord").val()+$("#mobile").val())+"tiemal"));
    $("#PassWord").val(md33);
    $("#rePassWord").val(md33);
    
    
}


function md_login(){
    var md33=$.md5($("#pwd").val());
    $("#pwd").val(md33);
    
    
}