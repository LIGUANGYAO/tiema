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


    $sql = " select slide_sn from slide where tzsy=0 order by -sort_no ";
    //$sql = "select p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update  from slide_imgs  where  p_id ='" . $obj . "'";
    $res = $GLOBALS['db']->getAll($sql);
    //print_r($res[0]['slide_sn']);
    $img_cod = $res[0]['slide_sn'];
    $slide_imgs22 = get_slide_imgs_list("slide_imgs",
        " p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",
        $img_cod);
    //print_r($slide_imgs22);exit;
    //获取分模块信息
    $sql2 = " select slide2_sn,slide2_name,slide2_note_1,action_url from slide2 where tzsy=0 order by -sort_no,id ";
    //$sql = "select p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update  from slide_imgs  where  p_id ='" . $obj . "'";
    $slide2 = $GLOBALS['db']->getAll($sql2);
    //print_r($slide_imgs22);exit;
    $smarty->assign('slide2', $slide2);
    $smarty->assign('title', "微官网");
    $smarty->assign('slide_imgs22', $slide_imgs22['items']);
    $smarty->display('mb/2/index.htm');
}





if ($_REQUEST['act'] == 'index') {
    
    $type=$_REQUEST['type'];
    
    if($type==0){
    $slide2_sn=$_REQUEST['slide2_sn']; 
    //-------获取列表
    $sql2 = " select slide2_sn,slide2_name,type,slide2_note_1,action_url from slide2 where tzsy=0 order by -sort_no,id ";
    $slide2 = $GLOBALS['db']->getAll($sql2);
    $sql2 = "select article_sn,article_name,article_note_1,article_note_2,type,type_name,imgurl,sort_no,is_tuig,seo,title,add_time from article where article_msg='" .
        $slide2_sn . "'";
    $article = $GLOBALS['db']->getAll($sql2);
    $smarty->assign('slide2', $slide2);
    $smarty->assign('article', $article[0]);
    $smarty->assign('title', $article[0]['title']);
    $smarty->display('mb/2/single.htm');
    }
    
    
    if($type==1){
    $slide2_sn=$_REQUEST['slide2_sn']; 
    $sql2 = " select slide2_sn,slide2_name,slide2_note_1,action_url from slide2 where tzsy=0 order by -sort_no,id ";
    //$sql = "select p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update  from slide_imgs  where  p_id ='" . $obj . "'";
    $slide2 = $GLOBALS['db']->getAll($sql2);
    if (isset($_REQUEST['id'])){
        $article_sn=$_REQUEST['id'];
        //print_r($article_sn);
        $sql2 = "select article_sn,article_name,article_note_1,article_note_2,type,type_name,imgurl,sort_no,is_tuig,seo,title,add_time from article where article_sn='".$article_sn."' and tzsy=0 ";
        $article = $GLOBALS['db']->getAll($sql2);
        $smarty->assign('article', $article[0]);
        $smarty->assign('slide2', $slide2);
        $smarty->assign('fall', 'mx');
        $smarty->assign('type', "1");
        $smarty->assign('title',  $article[0]['article_name']);
        $smarty->display('mb/2/list.htm');
        
    } else {
        $sql2 = "select id,article_sn,article_name,title,imgurl,add_time from article where article_msg='".$slide2_sn."'  and tzsy=0 order by add_time desc";
        $article = $GLOBALS['db']->getAll($sql2);
        
        $smarty->assign('slide2', $slide2);
        $smarty->assign('article_1', $article);
        //$smarty->assign('article_2', $article_2);
        $smarty->assign('type', "1");
        $smarty->assign('fall', 'all');
        $smarty->assign('title',  $article[0]['article_name']);
        $smarty->display('mb/2/list.htm');
    }    
        
    }
    
    if($type==2){
       $sql="select * from ly where ly_name!=''  order by add_time desc ";
       $res = $GLOBALS['db']->getAll($sql);
       
          $sql1=" select relay_id,relay_info,relay_time from ly  where  ly_name is  null";
       $res1 = $GLOBALS['db']->getAll($sql1);
       
       
       $smarty->assign('ly', $res);
        $smarty->assign('relay', $res1);
    //   foreach($ids as $id) {
    //   $result[$id] = $this->send($id, $content);
	//	}
	
       
       
       $smarty->display('mb/2/ly.htm');
       }
}


?>