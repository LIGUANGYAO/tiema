<?php
define('IN_ECS', true);
require (dirname(__file__) . '/sub/is_weixin.php');
require (dirname(__file__) . '/includes/init2.php');

if (empty($_REQUEST['m'])) {
    $_REQUEST['m'] = 'default';
} else {
    $_REQUEST['m'] = trim($_REQUEST['m']);
}


if ($_REQUEST['m'] == 'default'){
    
    if (isset($_REQUEST['goods_sn'])) {
        $goods_sn=$_REQUEST['goods_sn'];
    } 
 $goods_img_list = "select p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,ss,title,img_action_url,add_time,last_update,img_sum,img_outer_id,width,height,resize_width,resize_height from goods_imgs where ss=1 and  p_id='" .
    $goods_sn . "' order by -img_sum  desc;";
 $img_list = $GLOBALS['db']->getAll($goods_img_list); 
  //  print_r($img_list);  
    
 $smarty->assign('goods_sn', $goods_sn);     
 $smarty->assign('img_list', $img_list);  
 $smarty->display('wxzan2/imglist.html');
}




?>