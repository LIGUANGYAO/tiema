<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_wxarticle.php');
require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
    ///修改1,查询语句
    //sort_no,tzsy 要记得添加
    $sql = "select id,wxarticle_sn,wxarticle_name,sort_no,tzsy,last_update,wxarticle_note_1,title,type,wxarticle_lx,wxarticle_msg from wxarticle";
    $wxarticle_list = get_wxarticle_list($Num, "wxarticle", $sql);
    

  
    //print_r($wxarticle_list);
    $smarty->assign('wxarticle_list', $wxarticle_list['items']);
    $smarty->assign('fall', 1);
    //$smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $wxarticle_list['page']);
    $smarty->display('wxarticle.tpl');


}

if ($_REQUEST['act'] == 'add_wxarticle_list') {

    $sql="select wxfloor2_sn ,wxfloor2_name from wxfloor2 where type=1";
    $res_wxfloor2 = $GLOBALS['db']->getAll($sql);
    // print_r($res_wxfloor2);
    $smarty->assign('res_wxfloor2', $res_wxfloor2);
    $smarty->assign('fall', 'add_wxarticle_list');
    $smarty->display('wxarticle_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];

    ///修改2,查询语句
    $sql = "select id,wxarticle_sn,wxarticle_name,sort_no,tzsy,last_update,wxarticle_note_1,wxarticle_note_2,type,is_tuig,seo,title,wxarticle_lx,wxarticle_msg from wxarticle";
    
    $wxarticle_mx = get_wxarticle_mx("wxarticle", $sql);
    $img_cod = $_REQUEST['wxarticle_sn'];
    $wxarticle_lx=$wxarticle_mx['items'][0]['wxarticle_lx'];
    ////图片部分。没图片则删除
    //    $wxarticle_imgs2 = get_wxarticle_imgs_list("wxarticle_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
    ////print_r($wxarticle_imgs2);
    //    $wxarticle_imgs = arr_push($wxarticle_imgs2['items']);
    //    $smarty->assign('wxarticle_imgs', $wxarticle_imgs);
    //
    $sql="select wxfloor2_sn ,wxfloor2_name from wxfloor2 where type=1 ";
    $res_wxfloor2 = $GLOBALS['db']->getAll($sql);
    
    $sql="select wxfloor2_sn ,wxfloor2_name from wxfloor2 where wxfloor2_sn='".$wxarticle_lx."' and type=1 ";
    $res_wxfloor222 = $GLOBALS['db']->getAll($sql);
    
     // print_r($res_wxfloor2);
    $smarty->assign('res_wxfloor2', $res_wxfloor2);
    $smarty->assign('res_wxfloor222', $res_wxfloor222[0]);
     // print_r($res_wxfloor222[0]);
    $smarty->assign('wxarticle_mx', $wxarticle_mx['items'][0]);
    // $smarty->assign('res_xmlx', $wxarticle_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('wxarticle_mx.tpl');
}


if ($_REQUEST['act'] == 'delete_wxarticle') {

    //echo 1;
    if (isset($_REQUEST['wxarticle_sn'])) {
        $wxarticle_sn = trim($_REQUEST['wxarticle_sn']);

        $sql = "delete from wxarticle where  wxarticle_sn= '" . $wxarticle_sn . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}

if ($_REQUEST['act'] == 'wxarticle_xs') {

    //echo 1;

    if (isset($_REQUEST['wxarticle_code']) && isset($_REQUEST['alt'])) {
        $wxarticle_code = urldecode(trim($_REQUEST['wxarticle_code']));
        $alt = urldecode(trim($_REQUEST['alt']));

        $sql = "update  wxarticle set tzsy=" . $alt . "  where  wxarticle_sn= '" . $wxarticle_code .
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
    update_wxarticle_mx("wxarticle",
        "wxarticle_name,wxarticle_note_1,wxarticle_note_2,type,type_name,sort_no,is_tuig,seo,title,wxarticle_lx,wxarticle_msg",
        "wxarticle_sn", $time_field);

    $smarty->assign('fall', 'post');
    $smarty->display('wxarticle_mx.tpl');

    if (isset($_REQUEST['wxarticle_sn'])) {
        $wxarticle_sn = trim($_REQUEST['wxarticle_sn']);
    }

    //生成html
    
    $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);

    //print_r($url_this."/html_".$wxarticle_sn.".html");exit;//http://localhost:8081\

    $htmlname = $wxarticle_sn;
    $sql2 = "select wxarticle_sn,wxarticle_name,wxarticle_lx,wxarticle_note_1,wxarticle_note_2,type,type_name,sort_no,is_tuig,seo,title,add_time from wxarticle where wxarticle_sn='" .
        $htmlname . "'";
    $res = $GLOBALS['db']->getAll($sql2);

 for ($i = 0; $i < count($res); $i++) {
       $sql3 = "select wxarticle_sn,is_tuig,title from wxarticle where is_tuig=1 and wxarticle_lx='".$res[$i]['wxarticle_lx']."' order by add_time DESC limit 5  ";
       $ress = $GLOBALS['db']->getAll($sql3);
       $res[$i]['wxarticletj'] = $ress;
       
       for($j = 0; $j < count($res[$i]['wxarticletj']); $j++)
       {
        $res[$i]['wxarticletj'][$j]['tj_url']=$url_this.'/cs/html/wxarticle/'.'html_'.$res[$i]['wxarticletj'][$j]['wxarticle_sn'].'.html';
       }
       
      // $res[$i]['wxarticletj'][$i]['tj_url']=$url_this.'/html/wxarticle/'.'html_'.$ress[$i]['wxarticle_sn'].'.html';
       
    }
    //print_r($res);
       // $smarty->assign('wxarticletj', $ress);
    $smarty->assign('wxarticle', $res[0]);   
    $content = $smarty->fetch('zyw/wxarticle_html.tpl', null, null, false); //用$Content[$i] 得到每页的内容
    //print_r($content);
    //替换完了，我们把内容写到文件里
    $htmlname = 'html_' . $htmlname;
    if (file_exists($htmlname)) {
        @unlink($htmlname); //如果文件已经存在就把它删除
    }
    $fp = fopen('cs/html/wxarticle/' . $htmlname . '.html', "w"); //以可写方式打开$HtmlName ，第一次循环是打开index_1.html
    fwrite($fp, $content); //用fwrite()函数， 把内容写入每个文件
    fclose($fp);
}


if ($_REQUEST['act'] == 'post_add') {
    if (isset($_REQUEST['wxarticle_sn'])) {
        $wxarticle_sn = trim($_REQUEST['wxarticle_sn']);
    }

    $get_one = " select wxarticle_sn from wxarticle where wxarticle_sn ='" . $wxarticle_sn .
        "'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($get_one);exit;
    if (empty($res)) {
        
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
        insert_wxarticle_mx("wxarticle",
            "wxarticle_sn,wxarticle_name,wxarticle_note_1,wxarticle_note_2,type,type_name,sort_no,is_tuig,seo,title,wxarticle_lx,wxarticle_msg",
            $time_field);

        $smarty->assign('fall', 'post');
        $smarty->display('wxarticle_mx.tpl');

        //生成html

        $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);

        //print_r($url_this."/html_".$wxarticle_sn.".html");exit;//http://localhost:8081\

        $htmlname = $wxarticle_sn;
        $sql2 = "select wxarticle_sn,wxarticle_name,wxarticle_note_1,wxarticle_note_2,type,type_name,sort_no,is_tuig,seo,title,add_time from wxarticle where wxarticle_sn='" .$htmlname . "'";
        $res = $GLOBALS['db']->getAll($sql2);
        
       for ($i = 0; $i < count($res); $i++) {
       $sql3 = "select wxarticle_sn,is_tuig,title from wxarticle where is_tuig=1";
       $ress = $GLOBALS['db']->getAll($sql3);
       $res[$i]['wxarticletj'] = $ress;
       
        for($j = 0; $j < count($res[$i]['wxarticletj']); $j++)
       {
        $res[$i]['wxarticletj'][$j]['tj_url']=$url_this.'/cs/html/wxarticle/'.'html_'.$res[$i]['wxarticletj'][$j]['wxarticle_sn'].'.html';
       }
       
    }
        
        $smarty->assign('wxarticle', $res[0]);
       
        
        $content = $smarty->fetch('zyw/wxarticle_html.tpl', null, null, false); //用$Content[$i] 得到每页的内容
        $htmlname = 'html_' . $htmlname;
        if (file_exists($htmlname)) {
            @unlink($htmlname); //如果文件已经存在就把它删除
        }
        $fp = fopen('cs/html/wxarticle/' . $htmlname . '.html', "w"); //以可写方式打开$HtmlName ，第一次循环是打开index_1.html
        fwrite($fp, $content); //用fwrite()函数， 把内容写入每个文件
        fclose($fp);


    } else {
        $smarty->assign('fall', 'fs');
        $smarty->display('wxarticle_mx.tpl');
    }


}


?>