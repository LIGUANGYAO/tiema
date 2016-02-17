
    function setCookie (name,value,iDay)
    {   
        var oDate=new Date();
        oDate.setDate(oDate.getDate()+iDay);
        document.cookie=name+'='+value+';expires='+oDate;
    }
   // alert(0);
    
    function getCookie(name)
    {
        var arr=document.cookie.split(';');
        for(var i=0;i<arr.length;i++)
        {
            var arr2=arr[i].split('=');
            if(arr2[0]==name)
            {
                return arr2[1];
            }
        }
        return '';
    }
    
    function removeCookie(name)
    {
        setCookie(name,1,-1);
    }

/*
 function onload()
 {
     var oForm1=document.getElementById('form1');
         
         var oUser=document.getElementsByName('user')[0];
         oForm1.onsubmit=function ()
         {
             setCookie('user',oUser.value,14);
         }
         oUser.value=getCookie('user');
 }
 onload();
 */
	window.onload =function ()
    {
        //alert(1);
        var oForm1=document.getElementById('form1');
        //alert(oForm1.id);
        var oUs=document.getElementById('user');
        var oPs=document.getElementById('password');
        var oSub=document.getElementById('submit1');
        var oUser=document.getElementsByName('user')[0];
        //alert(oForm1.action);
        //alert('login.php?ajax=1&u='+oUs.id+'&p='+oPs.id);
    /*
         oForm1.submit=function ()
             {
                 // alert(oForm1.action);
                 setCookie('user',oUser.value,14);
               
                 ajax('login.php?ajax=1&u='+oUs.value+'&p='+oPs.value,'GET',function(str)
                 {
                     alert(str);
                 }
                 )
                  oForm1.action='login.php';
             }
     */
        
        oUser.value=getCookie('user');
        oSub.onclick=function ()
        {   
            /*
             ajax('login.php?ajax=1&u='+oUs.value+'&p='+oPs.value,function (str)
                              {
                                 alert(str);
                              })
             */
            if(oUs.value==""||oPs.value=="")
            {
                alert("用户名或密码不能为空");
                document.forms.login.user.focus();
                return false;
            }
            else
            {   
                setCookie('user',oUser.value,14);
                 
                oForm1.submit();
            }
       
        }
       // setCookie('user',oUser.value,14);
        //alert(oInput[0].name);
        function   keyEnter(){if(event.keyCode   ==   13)  
         {oSub.onclick(); 
         
          }} 
        document.onkeydown   =keyEnter; 

        document.forms.login.user.focus();
    }