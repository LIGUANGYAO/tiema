<div  id="tfoot" ><span id="page_foot">
        <a >共 {$p_Array.pager_Total} 条记录，本页显示 {$p_Array.now_PageNum} 条,  当前第 {$p_Array.pager_PageID}/{$p_Array.pager_Number} 页 </a>每页显示<input id="pager_Size" style="width: 20px;height: 20px; text-align: center; "   type="text" value="{$p_Array.pager_Size}"/>
		<a href="{$p_Array.url}&pager_PageID=1">第一页</a>
		<a href="{$p_Array.url}&pager_PageID={$p_Array.pager_PageID_ow}">上一页</a>
		<a href="{$p_Array.url}&pager_PageID={$p_Array.pager_PageID_next}">下一页</a>
		<a href="{$p_Array.url}&pager_PageID={$p_Array.pager_Number}">最末页</a>
<input  type="hidden" id="now_url" value="{$p_Array.url}"/>
		跳转到<input type='text' size='3' id='page_num' value="{$p_Array.pager_PageID}"  />页
	</span>
</div>