<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员中心</title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/tablecloth.js"></script>
<style type="text/css">
.btn{position: relative;overflow: hidden;margin-right: 4px;display:inline-block;*display:inline;padding:4px 10px 4px;font-size:14px;line-height:18px;*line-height:20px;color:#fff;text-align:center;vertical-align:middle;cursor:pointer;background-color:#5bb75b;border:1px solid #cccccc;border-color:#e6e6e6 #e6e6e6 #bfbfbf;border-bottom-color:#b3b3b3;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;}

.table tr td p{margin:0px 0 0 0;padding:0;text-indent:0em;line-height:150%;}
</style>
</head>

<body>
<div class="container">
  <div class="content">
 <div class="botable">
 <table class="table" width="100%" border="0" style="margin-bottom: 7px;">
<form>
 <tr>
   <th style="text-align: left;border-right-style:none">&nbsp;</th>
   <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>
 </form>
</table>

   <table class="table" width="100%" border="0">
   
   <tr>
   <th>用户信息</th>
   
    <th>中奖码</th>
   <th >中奖验证</th>
  
    <th>中奖手机</th>
   <th>中奖类型</th>
   <th>来源活动</th>
   <th>中奖时间</th>
   <th>兑奖时间</th>
   <th>状态</th>
   <th>操作</th>
   </tr>
<tbody  id="table_t">
   {foreach from=$award_list item=award_list}
  <tr>
   <td><p>{$award_list.users_sn}</p>
   <p>{$award_list.nick_name}</p>
   <p>{$award_list.openid}</p>
   </td>
  <td>{$award_list.sncode}</td>
  
  <td>
  {if $award_list.is_use==0}
  <input  type="text"  id="qrcode{$award_list.id}" name="qrcode"  size="40"/>
  <a class="yz" date="{$award_list.id}" href="javascript:void(0)"><div class="btn"><span>点击验证</span></div></a>{else}已验证{/if}
  </td>
  <td>{$award_list.tel}</td>
  <td>{$award_list.prizetype}</td>
  <td>{$award_list.hd_sn}</td>
  <td>{$award_list.lo_date}</td>
  <td>{$award_list.use_time}</td>
  <td> 
  {if $award_list.is_use==1}已使用{/if}
  {if $award_list.is_use==0}未使用{/if}
  </td>
  <td>
  {if $award_list.tzsy==1}<img  title="启用" name="{$award_list.id}" id="tzsy_qy"  src="images/no.gif" />{/if}
  {if $award_list.tzsy==0}<img  title="禁用" name="{$award_list.id}" id="tzsy_jy"  src="images/yes.gif" />{/if}

  </td>
  </tr>
 {foreachelse}
  <tr>
  <td style="width:70px" colspan="20">无记录</td>
  </tr>
   {/foreach}
  
</tbody>
</table>


<table class="table" width="100%" border="0">
<tr><td style="text-align: right;">{include file="foot.tpl"}</td></tr> 
</table>



</div>
</div>
</div>






<script type="text/javascript">
<!--

      
        $("img[id='tzsy_jy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("禁用"+$(this).attr("name")+"")){
             
            htmlobj=$.ajax({url:"award.php?act=award_xs&id="+encodeURI(encodeURI($(this).attr("name")))+"&alt=1",async:false});
             // alert("禁用"+$(this).attr("name")+"");
             window.location.reload();
            }else return false;
          
        })
        })
		
        $("img[id='tzsy_qy']").each(function (){
            
           $(this).click(function (){
        
           if(confirm("启用"+$(this).attr("name")+"")){
             
               htmlobj=$.ajax({url:"award.php?act=award_xs&id="+encodeURI(encodeURI($(this).attr("name")))+"&alt=0",async:false});
              //alert(htmlobj.responseText);
             window.location.reload();
            }else return false;
       })
       })
	   
	   
	   
	 $(".yz").click(function () { 
				var objid = $(this).attr("date");
				var sncode = $("#qrcode"+objid).val();
					if (sncode == '') {
					alert("请输入中奖码");
					return;
				}
				var submitData = {
					fid:objid,
					sncode:sncode,
					act: "award_dj"
				};
				$.post('award.php', submitData,
				function(data) {
					if (data.success == true) {
						alert(data.msg);
						setTimeout('window.location.href=location.href',1000);
						return;
					} else {}
				},
				"json")
			});  
			//

	   
	   
	   
	   
		  

</script>
</body>
</html>

