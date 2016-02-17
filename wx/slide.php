<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');

require (dirname(__file__) . '/sub/sub_index.php');



if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
       
       $sql=" select slide_sn from slide where tzsy=0 order by -sort_no desc";    
   //$sql = "select p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update  from slide_imgs  where  p_id ='" . $obj . "'";
    $res = $GLOBALS['db']->getAll($sql);
       print_r($res);
    $img_cod=$res[0];
     $slide_imgs22 = get_slide_imgs_list("slide_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
    // print_r($slide_imgs22);
     

    $smarty->assign('slide_imgs22', $slide_imgs22['items']);
    $smarty->display('mb/2/index.htm');
}


if ($_REQUEST['act'] == 'guanyu') {
    
    $htmlname='00102';
    $sql2 = "select article_sn,article_name,article_note_1,article_note_2,type,type_name,sort_no,is_tuig,seo,title,add_time from article where article_lx=1 and  article_sn='" .
        $htmlname . "'";
    $article = $GLOBALS['db']->getAll($sql2);
    
   // print_r($article);
    $smarty->assign('article', $article[0]);
    $smarty->display('mb/2/guanyu.htm');
}


if ($_REQUEST['act'] == 'lianxi') {
    
    
     $htmlname='1212';
    $sql2 = "select article_sn,article_name,article_note_1,article_note_2,type,type_name,sort_no,is_tuig,seo,title,add_time from article where article_sn='" .
        $htmlname . "'";
    $article = $GLOBALS['db']->getAll($sql2);
   
    $smarty->assign('article', $article);
    
    $smarty->display('mb/2/lianxi.htm');
}
?>