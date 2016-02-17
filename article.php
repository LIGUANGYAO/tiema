<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init3.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_article.php');

require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {


    ///修改1,查询语句
    //sort_no,tzsy 要记得添加
    $sql = "select id,article_sn,article_name,sort_no,tzsy,last_update,article_note_1,title,type,article_lx,article_msg from article";


    $article_list = get_article_list($Num, "article", $sql);

    //print_r($article_list);
    $smarty->assign('article_list', $article_list['items']);
    $smarty->assign('fall', 1);
    //$smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $article_list['page']);
    $smarty->display('article.tpl');


}

if ($_REQUEST['act'] == 'add_article_list') {

    $sql="select slide2_sn ,slide2_name from slide2";
    $res_slide2 = $GLOBALS['db']->getAll($sql);
     // print_r($res_slide2);
    $smarty->assign('res_slide2', $res_slide2);
    $smarty->assign('fall', 'add_article_list');
    $smarty->display('article_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];

    ///修改2,查询语句
    $sql = "select id,article_sn,article_name,sort_no,tzsy,last_update,article_note_1,article_note_2,type,is_tuig,seo,title,article_lx,article_msg
  from article ";
    $article_mx = get_article_mx("article", $sql);

    //print_r($article_mx);
    $img_cod = $_REQUEST['article_sn'];

    $article_msg=$article_mx['items'][0]['article_msg'];
    ////图片部分。没图片则删除
    //    $article_imgs2 = get_article_imgs_list("article_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
    ////print_r($article_imgs2);
    //    $article_imgs = arr_push($article_imgs2['items']);
    //    $smarty->assign('article_imgs', $article_imgs);
    //
    $sql="select slide2_sn ,slide2_name from slide2 ";
    $res_slide2 = $GLOBALS['db']->getAll($sql);
    
     $sql="select slide2_sn ,slide2_name from slide2 where slide2_sn='".$article_msg."' ";
     $res_slide222 = $GLOBALS['db']->getAll($sql);
    
     // print_r($res_slide2);
    $smarty->assign('res_slide2', $res_slide2);
    
    $smarty->assign('res_slide222', $res_slide222[0]);
     // print_r($res_slide222[0]);
    $smarty->assign('article_mx', $article_mx['items'][0]);
    // $smarty->assign('res_xmlx', $article_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('article_mx.tpl');
}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if (isset($_REQUEST['img_code'])) {
        $img_code = trim($_REQUEST['img_code']);

        $sql = "delete from article_imgs where  img_outer_id= '" . $img_code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}

if ($_REQUEST['act'] == 'delete_article') {

    //echo 1;
    if (isset($_REQUEST['article_sn'])) {
        $article_sn = trim($_REQUEST['article_sn']);

        $sql = "delete from article where  article_sn= '" . $article_sn . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}
if ($_REQUEST['act'] == 'img_xs') {

    //echo 1;
    if (isset($_REQUEST['img_code']) && isset($_REQUEST['alt'])) {
        $img_code = trim($_REQUEST['img_code']);
        $alt = trim($_REQUEST['alt']);

        $sql = "update  article_imgs set ss=" . $alt . "  where  img_outer_id= '" . $img_code .
            "'";
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}
if ($_REQUEST['act'] == 'article_xs') {

    //echo 1;

    if (isset($_REQUEST['article_code']) && isset($_REQUEST['alt'])) {
        $article_code = urldecode(trim($_REQUEST['article_code']));
        $alt = urldecode(trim($_REQUEST['alt']));

        $sql = "update  article set tzsy=" . $alt . "  where  article_sn= '" . $article_code .
            "'";
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";
    } else {
        echo "失败";
    }

    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}


if ($_REQUEST['act'] == 'post') {

if (isset($_REQUEST['is_tuig'])) {
        $is_tuig = trim($_REQUEST['is_tuig']);
    }
//print_r($is_tuig);exit;
    // print_r($_REQUEST['article_note_2']);
    //     exit;
    //  $p = new upload;
    //    $path=$p->upload_path='upload/article';
    //    $p->uplood_img();
    //    $img_array = $p->upload_file;
    //
    //    for($i=0;$i<count($img_array['guige']);$i++)
    //    {
    //        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
    //    }
    //    $aaa = $_POST['article_sn'];
    //    // print_r($aaa);exit;
    //    //图片部分。没图片则删除
    //    img_insert($aaa, $img_array,"article_imgs");
    //修改3，更新语句
    $time_field = array( //array("type"=>"2","field"=>"add_time","method"=>"1"),
            array(
            "type" => "2",
            "field" => "last_update",
            "method" => "2"), array(
            "type" => "1",
            "field" => "last_update_2",
            "method" => "2"));
    //print_r($time_field);exit;
    update_article_mx("article",
        "article_name,article_note_1,article_note_2,type,type_name,sort_no,is_tuig,seo,title,article_lx,article_msg",
        "article_sn", $time_field);

    $smarty->assign('fall', 'post');
    $smarty->display('article_mx.tpl');

    if (isset($_REQUEST['article_sn'])) {
        $article_sn = trim($_REQUEST['article_sn']);
    }

    //生成html

    $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);

    //print_r($url_this."/html_".$article_sn.".html");exit;//http://localhost:8081\

    $htmlname = $article_sn;
    $sql2 = "select article_sn,article_name,article_note_1,article_note_2,type,type_name,sort_no,is_tuig,seo,title,add_time from article where article_sn='" .
        $htmlname . "'";
    $res = $GLOBALS['db']->getAll($sql2);

    $smarty->assign('article', $res[0]);
    //$smarty->display('article_html.tpl');
    $content = $smarty->fetch('article_html.tpl', null, null, false); //用$Content[$i] 得到每页的内容
    //print_r($content);
    //替换完了，我们把内容写到文件里
    $htmlname = 'html_' . $htmlname;
    if (file_exists($htmlname)) {
        @unlink($htmlname); //如果文件已经存在就把它删除
    }
    $fp = fopen('' . $htmlname . '.html', "w"); //以可写方式打开$HtmlName ，第一次循环是打开index_1.html
    fwrite($fp, $content); //用fwrite()函数， 把内容写入每个文件
    fclose($fp);
}


if ($_REQUEST['act'] == 'post_add') {
    if (isset($_REQUEST['article_sn'])) {
        $article_sn = trim($_REQUEST['article_sn']);
    }


    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one = " select article_sn from article where article_sn ='" . $article_sn .
        "'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($get_one);exit;
    if (empty($res)) {
        //echo 1;
        // $p = new upload;
        //        $path=$p->upload_path='upload/article';
        //        $p->uplood_img();
        //        $img_array = $p->upload_file;
        //        for($i=0;$i<count($img_array['guige']);$i++)
        //        {
        //        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
        //        }
        //        //print_r($img_array);exit;
        //        $aaa = $article_sn;
        //
        //        //插入图片记录//图片部分。没图片则删除
        //         img_insert($aaa, $img_array,"article_imgs");
        //修改4，增加语句
        //保存修改后商品明细
        $time_field = array(array(
                "type" => "2",
                "field" => "add_time",
                "method" => "1"), // array("type"=>"2","field"=>"last_update","method"=>"2"),
                //array("type"=>"1","field"=>"last_update_2","method"=>"2")
            );
        //修改4，增加语句
        //保存修改后商品明细
        insert_article_mx("article",
            "article_sn,article_name,article_note_1,article_note_2,type,type_name,sort_no,is_tuig,seo,title,article_lx,article_msg",
            $time_field);

        $smarty->assign('fall', 'post');
        $smarty->display('article_mx.tpl');

        //生成html

        $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);

        //print_r($url_this."/html_".$article_sn.".html");exit;//http://localhost:8081\

        $htmlname = $article_sn;
        $sql2 = "select article_sn,article_name,article_note_1,article_note_2,type,type_name,sort_no,is_tuig,seo,title,add_time from article where article_sn='" .
            $htmlname . "'";
        $res = $GLOBALS['db']->getAll($sql2);

        $smarty->assign('article', $res[0]);
        //$smarty->display('article_html.tpl');
        $content = $smarty->fetch('article_html.tpl', null, null, false); //用$Content[$i] 得到每页的内容
        //print_r($content);
        //替换完了，我们把内容写到文件里
        $htmlname = 'html_' . $htmlname;
        if (file_exists($htmlname)) {
            @unlink($htmlname); //如果文件已经存在就把它删除
        }
        $fp = fopen('' . $htmlname . '.html', "w"); //以可写方式打开$HtmlName ，第一次循环是打开index_1.html
        fwrite($fp, $content); //用fwrite()函数， 把内容写入每个文件
        fclose($fp);


    } else {
        $smarty->assign('fall', 'fs');
        $smarty->display('article_mx.tpl');
    }


}


?>