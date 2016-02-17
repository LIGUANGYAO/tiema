<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>系统设置</title>
<link href="css/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jq.mshop.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>

</head>
<style type="text/css">
<!--
	.table tr td p{margin:0px 0 0 0;padding:0;text-indent:0em;line-height:150%;}
-->
</style>
<body>

<div class="container">
  <div class="content">
  <div class="botable">


<form action="set_sys.php?m=setsys" method="POST">

<table class="table" width="100%" border="0">
<tr><th colspan="2">短信设置</th></tr>   
   
  <tr>
  <td  style="text-align:right; width:40%" >个人中心短信验证&nbsp;&nbsp;&nbsp;</td>
  <td style="text-align:left; width:50%" >
   {if $wxextel_val==0}
  &nbsp;&nbsp;&nbsp;<input type="checkbox"  name="wxextel"/>
  {elseif $wxextel_val==1}
  &nbsp;&nbsp;&nbsp;<input type="checkbox"  name="wxextel"  checked="checked"/>
  {/if}
  </td>
  
  </tr>
    <tr>
  <td  style="text-align:right; width:40%" >账号&nbsp;&nbsp;&nbsp;</td>
  <td style="text-align:left; width:50%" >&nbsp;&nbsp;&nbsp;<input type="text" value="{$get_wxextel.0.note}"  name="wx_name"/></td>
  
  </tr>
    <tr>
  <td  style="text-align:right; width:40%" >密码&nbsp;&nbsp;&nbsp;</td>
  <td style="text-align:left; width:50%" >&nbsp;&nbsp;&nbsp;<input type="password" value="{$get_wxextel.1.note}" name="wx_password" /></td>
  
  </tr>
   <tr><th colspan="2">互动活动设置</th></tr>  
   <tr>
  <td  style="text-align:right; width:40%" >活动中奖码<a style="color:red">(默认生成8位数字码,勾选则生成32位随机码)</a>&nbsp;&nbsp;&nbsp;</td>
  <td style="text-align:left; width:50%" >
   {if $active_pwd==0}
  &nbsp;&nbsp;&nbsp;<input type="checkbox"  name="active_pwd"/>
  {elseif $active_pwd==1}
  &nbsp;&nbsp;&nbsp;<input type="checkbox"  name="active_pwd"  checked="checked"/>
  {/if}
  </td>
  
  
  
  </tr>  
  
    <tr>
  <td  style="text-align:right; width:40%" >奖券允许转换成积分<a style="color:red"></a>&nbsp;&nbsp;&nbsp;</td>
  <td style="text-align:left; width:50%" >
  {if $ex_point_val==0}
  &nbsp;&nbsp;&nbsp;<input type="checkbox" name="ex_point_val"/>
  {elseif $ex_point_val==1}
  &nbsp;&nbsp;&nbsp;<input type="checkbox"  name="ex_point_val"  checked="checked"/>
  {/if}
  </td>
  </tr> 
  {foreach from=$get_ex_point item=get_ex_point}   
   <tr>
  <td  style="text-align:right; width:40%" >
  {if $get_ex_point.type==1}一等奖&nbsp;&nbsp;&nbsp;
  {elseif $get_ex_point.type==2}二等奖&nbsp;&nbsp;&nbsp;
  {elseif $get_ex_point.type==3}三等奖&nbsp;&nbsp;&nbsp;
  {else}
  {/if}
  </td>
  <td style="text-align:left; width:50%" >
  {if $get_ex_point.type==1}&nbsp;&nbsp;&nbsp;<input type="text" value="{$get_ex_point.type_val}"  name="point_type_val[]"/>
  {elseif $get_ex_point.type==2}&nbsp;&nbsp;&nbsp;<input type="text" value="{$get_ex_point.type_val}"  name="point_type_val[]"/>
  {elseif $get_ex_point.type==3}&nbsp;&nbsp;&nbsp;<input type="text" value="{$get_ex_point.type_val}"  name="point_type_val[]"/>
  {else}
  {/if}
  分</td>
  
  </tr>
 
  {/foreach}
  
  <tr>
  <td  style="text-align:right; width:40%" >积分允许兑换成实物奖券<a style="color:red">(左边填写需要多少积分,右边填写兑换物品)</a><a style="color:red"></a>&nbsp;&nbsp;&nbsp;</td>
  <td style="text-align:left; width:50%" >
  {if $ex_real_val==0}
  &nbsp;&nbsp;&nbsp;<input type="checkbox" name="ex_real_val"/>
  {elseif $ex_real_val==1}
  &nbsp;&nbsp;&nbsp;<input type="checkbox"  name="ex_real_val"  checked="checked"/>
  {/if}
  </td>
  </tr> 
  {foreach from=$get_ex_real item=get_ex_real}   
   <tr>
  <td  style="text-align:right; width:40%" >
  {if $get_ex_real.type==1}<input type="text" value="{$get_ex_real.type_val}"  name="real_type_val[]"/>分&nbsp;&nbsp;&nbsp;
  {elseif $get_ex_real.type==2}<input type="text" value="{$get_ex_real.type_val}"  name="real_type_val[]"/>分&nbsp;&nbsp;&nbsp;
  {elseif $get_ex_real.type==3}<input type="text" value="{$get_ex_real.type_val}"  name="real_type_val[]"/>分&nbsp;&nbsp;&nbsp;
  {elseif $get_ex_real.type==4}<input type="text" value="{$get_ex_real.type_val}"  name="real_type_val[]"/>分&nbsp;&nbsp;&nbsp;
  {elseif $get_ex_real.type==5}<input type="text" value="{$get_ex_real.type_val}"  name="real_type_val[]"/>分&nbsp;&nbsp;&nbsp;
  {else}
  {/if}
  </td>
  <td style="text-align:left; width:50%" >
  {if $get_ex_real.type==1}&nbsp;&nbsp;&nbsp;<input type="text" value="{$get_ex_real.note}"  name="real_note[]"/>
  {elseif $get_ex_real.type==2}&nbsp;&nbsp;&nbsp;<input type="text" value="{$get_ex_real.note}"  name="real_note[]"/>
  {elseif $get_ex_real.type==3}&nbsp;&nbsp;&nbsp;<input type="text" value="{$get_ex_real.note}"  name="real_note[]"/>
  {elseif $get_ex_real.type==4}&nbsp;&nbsp;&nbsp;<input type="text" value="{$get_ex_real.note}"  name="real_note[]"/>
  {elseif $get_ex_real.type==5}&nbsp;&nbsp;&nbsp;<input type="text" value="{$get_ex_real.note}"  name="real_note[]"/>
  {else}
  {/if}
  </td>
  
  </tr>
 
  {/foreach}
  
  
    <tr>
   <tr><th colspan="2">会员中心首次验证奖励</th></tr> 
   
   <tr>
  <td  style="text-align:right; width:40%" >是否赠送积分<a style="color:red"></a>&nbsp;&nbsp;&nbsp;</td>
  <td style="text-align:left; width:50%" >
  {if $mcenter_int_val==0}
  &nbsp;&nbsp;&nbsp;<input type="checkbox" name="mcenter_int"/>
  {elseif $mcenter_int_val==1}
  &nbsp;&nbsp;&nbsp;<input type="checkbox"  name="mcenter_int"  checked="checked"/>
  {/if}
  
  &nbsp;&nbsp;&nbsp;<input type="text" value="{$mcenter_int.type_val}" name="mcenter_int_type_val"/>分
  </td>
  </tr> 
   
   <tr>
  <td  style="text-align:right; width:40%" >是否赠送实物券<a style="color:red"></a>&nbsp;&nbsp;&nbsp;</td>
  <td style="text-align:left; width:50%" >
  {if $mcenter_dyq_val==0}
  &nbsp;&nbsp;&nbsp;<input type="checkbox" name="mcenter_dyq"/>
  {elseif $mcenter_dyq_val==1}
  &nbsp;&nbsp;&nbsp;<input type="checkbox"  name="mcenter_dyq"  checked="checked"/>
  {/if}
  
  &nbsp;&nbsp;&nbsp;<input type="text" value="{$mcenter_dyq.note}" name="mcenter_dyq_note"/><a style="color:red">注:请输入抵用券名称,例:5元抵用券</a>
  </td>
  </tr> 
  
  </tr> 
  <tr>
   <tr><th colspan="2">签到设置</th></tr> 
  <td  style="text-align:right; width:40%" >签到积分设定&nbsp;&nbsp;&nbsp;</td>
  <td style="text-align:left; width:50%" >&nbsp;&nbsp;&nbsp;<input type="text" value="{$sys_list.val}" name="check_in"/>分/次</td>
  
  </tr> 
   <tr>
  <td  style="text-align:right; width:40%" >积分说明&nbsp;&nbsp;&nbsp;</td>
  <td style="text-align:left; width:50%" >&nbsp;&nbsp;&nbsp;<textarea style="width:300px;height:100px;" name="check_note" >{$sys_list.note}</textarea></td>
  
  </tr>
  
  <tr><th colspan="2">留言设定</th> </tr> 
  <tr>
  <td  style="text-align:right; width:40%" >留言默认回复&nbsp;&nbsp;&nbsp;</td>
  <td style="text-align:left; width:50%" >&nbsp;&nbsp;&nbsp;
  <textarea style="width:300px;height:100px;" name="lv_msg" >{$lv_msg.bz}</textarea>
  </td></tr>
  
  
  
  
  

   <tr><th colspan="2">商品设置</th></tr> 
    <tr>
  <td  style="text-align:right; width:40%" >价格&nbsp;&nbsp;&nbsp;</td>
  <td style="text-align:left; width:50%" >&nbsp;&nbsp;&nbsp;<input type="text" value="{$spjg.note}" name="spjg"/>&nbsp;元 (例:9.99)</td>
  
  </tr>
    <tr><th colspan="2">分销提成设置</th></tr> 
    <tr>
  <td  style="text-align:right; width:40%" >一级&nbsp;&nbsp;&nbsp;</td>
  <td style="text-align:left; width:50%" >&nbsp;&nbsp;&nbsp;<input type="text" value="{$fc.0.fenchengjine}" name="fc[]"/>&nbsp;元(例:1.11)</td>
  
  </tr>
  <tr>
  <td  style="text-align:right; width:40%" >二级&nbsp;&nbsp;&nbsp;</td>
  <td style="text-align:left; width:50%" >&nbsp;&nbsp;&nbsp;<input type="text" value="{$fc.1.fenchengjine}" name="fc[]"/>&nbsp;元(例:2.22)</td>
  
  </tr>
  <tr>
  <td  style="text-align:right; width:40%" >三级&nbsp;&nbsp;&nbsp;</td>
  <td style="text-align:left; width:50%" >&nbsp;&nbsp;&nbsp;<input type="text" value="{$fc.2.fenchengjine}" name="fc[]"/>&nbsp;元(例:3.33) <a style=" color:red">注：直接受益</a> </td>
  
  </tr>
   
   
   
   
   
   <tr><td colspan="2"  style="text-align: center;"><input  id="queding" type="submit" value="确定"/>&nbsp;<input  type="button" value="取消" id="quxiao" onclick="location=location"/></td></tr>
</table>
</form>









</div>
   <!-- end .content --></div>
<!-- end .container --></div>
</body>
</html>

