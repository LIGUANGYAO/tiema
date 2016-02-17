 
  <!--<tr><td>发送会员组:</td><td colspan="3"> <select  name="re_type" id="type" style="width: 150px;"> 
            <option value="">请选择</option>
            <option value="text">全部</option>
            <option value="imgtext">图文</option>
              <option value="url">URL</option>
                <option value="html">HTML</option>
       </select></td></tr>-->
       
  <table class="table" width="98%" border="0" style="margin-bottom: 7px;">

<tr><th>发送会员组 <select  name="role" id="role" style="width:150px"> 
            <option value="">请选择</option>
            <option value="All">全部APP用户</option>
            <option value="weixin">全部微信用户</option>
             {foreach from=$group item=group}
             <option value="{$group.group_sn}">{$group.group_sn}_{$group.group_name}</option>
             {/foreach}
            
       </select>
       
       &nbsp;&nbsp; 
       {if $appsend_mx.tzsy==1}
       {else}
        <input  value="搜索" type="button"  id="searchBtn"/>
        {/if}
        &nbsp;&nbsp;
        <span style="color:red;">注:全部微信用户/用户组只包含 关注公众号,并有登陆App端用户</span>
</th></tr>
 <!--
 <tr>
 <th style="text-align: right; border-left-style:none">
 <input  type="text"  id="key" name="key" />&nbsp;<input  type="text"  id="m_key" name="m_key"/>&nbsp;<input  value="搜索" type="submit" />&nbsp;&nbsp;</th>
 
 </tr>-->



</table>

<table class="table" width="98%" border="0">
   
   <tr><th >会员代码</th><th>昵称</th><th>openid</th><th>机器id</th><th>操作</th><th>反馈</th></tr>
<tbody  id="table_t">
   {foreach from=$openid_list item=openid_list}
  <tr><td>{$openid_list.users_sn}</td>
  <td>{$openid_list.nick_name}</td>
  <td>{$openid_list.openid}</td>
    <td>{$openid_list.push_id}</td>
  <td>{if $openid_list.is_send=='0'}<a style="color:red">未发送</a>
  {elseif $openid_list.is_send=='1'}<a style="color:green">已发送</a>
  {else}
  {/if}</td>
  <td><a style="color:red">{$openid_list.error}</a></td>
  

  </tr>
 
  
  {foreachelse}
  <tr>
  <td style="width:70px" colspan="20">无记录</td>
  </tr>
   {/foreach}
  
</tbody>
</table>


<table class="table" width="98%" border="0">
<tr><td style="text-align: right;">{include file="foot.tpl"}</td></tr> 

</table>
<br />



