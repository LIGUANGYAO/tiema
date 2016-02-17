<table width="500" height="196" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#E7E7E7" style="margin-top:8px">
  <tr>
    <td height="30">Smarty forech 循环输出：</td>
  </tr>
  <tr>
    <td height="98" bgcolor="#FFFFFF">
	<{foreach item=dsfsadf from=$values}>
	<table width="500" height="30" border="0" cellpadding="5" cellspacing="1" bgcolor="#FCEDA7">
      <tr>
        <td><{$dsfsadf.DOC_Title}></td>
      </tr>
    </table>
	<{/foreach}>
	</td>
  </tr>
</table>