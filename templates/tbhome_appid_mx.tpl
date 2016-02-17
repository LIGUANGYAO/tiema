<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title></title>
<link href="css/menu.css?v=1" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>


<script type="text/javascript" src="js/jquery.tabso_yeso.js"></script>
</head>
<style type="text/css">

</style>
<body  style=" margin-top: 0px;margin-left: 5px;  padding-top: 0px;"> 

{if $fall==edit}
<div class="demo">	
	

	    <form name="myform" method="post" action="tbhome_appid.php?act=post" enctype="multipart/form-data">
    <ul class="tabbtn" id="move-animate-left">
		<li class="current" id="sub1"><a >模板信息</a></li>
	
	</ul><!--tabbtn end-->

   
	<div class="tabcon" id="leftcon"  >
    
    <div  id="m1"><table class="table" width="100%" border="0">

  <tr>
      <td>
          代码:
      </td>
      <td>
          <input disabled="true"  type="text" value="{$appid_mx.appid_sn}" /><input name="appid_sn" id="appid_sn"  type="hidden" value="{$appid_mx.appid_sn}" /><a style="color:red;">*</a>
      </td>
  </tr>

  <tr>
      <td>Appid:</td>
      <td>
          <input name="app_id"  id="app_id" type="text" value="{$appid_mx.app_id}" /><a style="color:red;">*</a>
      </td>
  </tr>
  <tr>
      <td>
          appsecret:
      </td>
      <td>
          <textarea name="app_secret" id="app_secret" style="width:300px;height:150px;">{$appid_mx.app_secret}</textarea>
      </td>
  </tr>

            <tr>
                <td>MCHID:</td>
                <td>
                    <input name="mchid"  id="mchid" type="text" value="{$appid_mx.mchid}" /><a style="color:red;">*</a>
                </td>
            </tr>
            <tr>
                <td>
                    MCHkey:
                </td>
                <td>
                    <textarea name="mchkey" id="mchkey" style="width:300px;height:150px;">{$appid_mx.mchkey}</textarea>
                </td>
            </tr>



 <!--
</tr>
 
  </tr>
  -->
</table>
    
    
    
    </div>
	
    <div align="center" style="padding: 10px;"><input  type="submit"  id="btn_queren2" value="确认" />&nbsp;<input  type="button" onclick="location='tbhome_appid.php'" value="返回" /></div>
	</div>
    
    
    
	</form>


	
</div><!--tabbox end-->







{/if}
	
{if $fall==post}
<div class="demo">	
	

	<ul class="tabbtn" id="move-animate-left">
		<li class="current" id="sub1"><a >修改成功</a></li>
	<li class="current" id="sub1" onclick="location='appid.php'"><a >返回</a></li>
	
	</ul><!--tabbtn end-->


	
    


	
</div><!--tabbox end-->

{/if}


</body>  
</html>
{literal}
<script type="text/javascript">
        
        $("#appid_sn").focus();
       $("#btn_queren2").click(function(){
           if(jQuery.trim($("#appid_sn").attr('value'))=='')
        {
            
            $("#appid_sn").focus();
            
            return false;
        }
        else
        {
            
            if(confirm("确认修改")){
                
            }
            else
            {
                return false;
            }
        }
       })
   

    
    var i=2;
   $("#add_images").click(function (){
        
        
        $("#m2").append('&nbsp;图片'+i+':<input type="file" name="pic'+i+'"/>  &nbsp;<br />');
        i++;

        //alert(1);
   })
	$("#sub1").click(function (){
	   $("#m2").hide();
       $("#m1").show();
	})
    $("#sub2").click(function (){
	    $("#m1").hide();
       $("#m2").show();
	})
	//上下滑动选项卡切换
	$("#move-animate-top").tabso({
		cntSelect:"#topcon",
		tabEvent:"mouseover",
		tabStyle:"move-animate",
		direction : "top"
	});
	
	//左右滑动选项卡切换
	$("#move-animate-left").tabso({
		cntSelect:"#leftcon",
		tabEvent:"click",
		tabStyle:"move-animate",
		direction : "left"
	});
	
	//淡隐淡现选项卡切换
	$("#fadetab").tabso({
		cntSelect:"#fadecon",
		tabEvent:"mouseover",
		tabStyle:"fade"
	});
	
	//默认选项卡切换
	$("#normaltab").tabso({
		cntSelect:"#normalcon",
		tabEvent:"mouseover",
		tabStyle:"normal"
	});
	
      $("img[id='img_mx']").each(function (){
            
           $(this).dblclick(function (){
           //alert($(this).attr("name"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
          $("img[id='delete_z_sn']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("是否删除图片"+$(this).attr("title"))){
             
              htmlobj=$.ajax({url:"appid.php?act=delete&img_code="+encodeURI(encodeURI($(this).attr("title"))),async:false});
              alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
            $("img[id='img_jy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("title")+"图片？")){
             
              htmlobj=$.ajax({url:"appid.php?act=img_xs&img_code="+encodeURI(encodeURI($(this).attr("title")))+"&alt="+$(this).attr("alt"),async:false});
              alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
         $("img[id='img_xs']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("显示"+$(this).attr("title")+"图片？")){
             
              htmlobj=$.ajax({url:"appid.php?act=img_xs&img_code="+encodeURI(encodeURI($(this).attr("title")))+"&alt="+$(this).attr("alt"),async:false});
              alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
            
          //alert($(this).attr("title"));
           //$("#hide_img").slideToggle(200);
           
           
        })
        })
        
        $("#type").val({$appid_mx.type});
      
       
        
</script>
{/literal}