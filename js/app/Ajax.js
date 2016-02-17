

function AjaxRequest(url,paramdata){
	var xmlHttp;
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }
    xmlHttp.open("POST", url, false);
    xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
    xmlHttp.send(paramdata);
   return xmlHttp.responseText;
}


function showHint(str)
{
var xmlhttp;
if (str.length==0)
  { 
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","/ajax/gethint.asp?q="+str,true);
xmlhttp.send();
}





function ajax(url,fnSucc,fnFaild)
{
    //1.����ajax����
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      var ajax=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      var ajax=new ActiveXObject("Microsoft.XMLHTTP");
      }
      //alert(readyState);
      //2.���ӷ�������
      //open (����,url,�첽����ture/ͬ��false)
      ajax.open('POST',url,true);
      //3.��������
      ajax.send();
      //4.��������
      ajax.onreadystatechange=function ()
      { 
        if (ajax.readyState==4)
        {
            if(ajax.status==200)
            {
                fnSucc(ajax.responseText);
            }
            else
            {
                if(fnFaild)
                {
                    fnFaild(ajax.status);
                }
                
            }
            //ajax.responseText;
        }
      }
}