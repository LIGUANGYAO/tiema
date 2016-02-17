<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_attention.php');

require (dirname(__file__) . '/sub/sub_image.php');
//require (dirname(__file__) . '/sub/sub_err.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}





if ($_REQUEST['act'] == 'default') {
///修改1,查询语句
//sort_no,tzsy 要记得添加
    $sql="select id,attention_sn,attention_name,sort_no,tzsy,last_update,attention_note_1,type,re_type,re_code from attention";
    
    $attention_list = get_attention_list($Num,"attention",$sql);
    //print_r($attention_list);
    $smarty->assign('attention_list', $attention_list['items'][0]);
     $smarty->assign('fall', 1);
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $attention_list['page']);
    $smarty->display('attention.tpl');
    
    $url=md5($_SERVER['REQUEST_URI']);
  


}




///获取下拉二级列表

if ($_REQUEST['act'] == 'get_type') {

    //echo 1;exit;
    //if(isset($_REQUEST['province'])){
    require (dirname(__file__) . '/sub/rest.php');
    $type = urldecode($_REQUEST['type']);
    
    if($type=="text")
    {
        $sql_t="select text_sn as sn,title as name from text_reply where tzsy=0";
        $sql_t = $GLOBALS['db']->getAll($sql_t);
         $aaa = new arraytojson();
         $json = $aaa->JSON($sql_t);

    print_r($json);
        
    }
    elseif($type=="imgtext")
    {
        $sql_t="select imgtext_sn as sn,imgtext_name as name from imgtext where tzsy=0";
        $sql_t = $GLOBALS['db']->getAll($sql_t);
        $aaa = new arraytojson();
        $json = $aaa->JSON($sql_t);

    print_r($json);
    }
  
}


if ($_REQUEST['act'] == 'post') {
    
    
    
   $type1 = urldecode($_REQUEST['type']);
    $type2 = urldecode($_REQUEST['type2']);
    
     dj_log("edit","修改","类型修改成:".$type1." 模板修改成".$type2,"attention");
    
    
       $sql_t="update attention set re_type='".$type1."',re_code='".$type2."' where attention_sn='001'";
       $sql_t = $GLOBALS['db']->query($sql_t);
         $smarty->assign('fall', "i_staus");
         $smarty->assign('val', "修改成功");
         $smarty->display('attention.tpl');
       
}

?>