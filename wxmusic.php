<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_wxmusic.php');
require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
    ///修改1,查询语句
    //sort_no,tzsy 要记得添加
    $sql = "select id,wxmusic_sn,wxmusic_name,sort_no,tzsy,last_update,wxmusic_note_1,title,type,wxmusic_lx,wxmusic_msg from wxmusic";
    $wxmusic_list = get_wxmusic_list($Num, "wxmusic", $sql);
    //print_r($wxmusic_list);
    $smarty->assign('wxmusic_list', $wxmusic_list['items']);
    $smarty->assign('fall', 1);
    //$smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $wxmusic_list['page']);
    $smarty->display('wxmusic.tpl');


}

if ($_REQUEST['act'] == 'add_wxmusic_list') {

    $sql="select wxfloor2_sn ,wxfloor2_name from wxfloor2 where type=2";
    $res_wxfloor2 = $GLOBALS['db']->getAll($sql);
    // print_r($res_wxfloor2);
    $smarty->assign('res_wxfloor2', $res_wxfloor2);
    $smarty->assign('fall', 'add_wxmusic_list');
    $smarty->display('wxmusic_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];

    ///修改2,查询语句
    $sql = "select id,wxmusic_sn,wxmusic_name,imgurl,sort_no,tzsy,last_update,wxmusic_note_1,wxmusic_note_2,type,is_tuig,seo,title,wxmusic_lx,wxmusic_msg from wxmusic";
    $wxmusic_mx = get_wxmusic_mx("wxmusic", $sql);
    $img_cod = $_REQUEST['wxmusic_sn'];
    $wxmusic_lx=$wxmusic_mx['items'][0]['wxmusic_lx'];
    
    $sql="select wxfloor2_sn ,wxfloor2_name from wxfloor2 where type=2 ";
    $res_wxfloor2 = $GLOBALS['db']->getAll($sql);
        
    $sql="select wxfloor2_sn ,wxfloor2_name from wxfloor2 where wxfloor2_sn='".$wxmusic_lx."' and type=2 ";
    $res_wxfloor222 = $GLOBALS['db']->getAll($sql);
    
     // print_r($res_wxfloor2);
    $smarty->assign('res_wxfloor2', $res_wxfloor2);
    $smarty->assign('res_wxfloor222', $res_wxfloor222[0]);
     // print_r($res_wxfloor222[0]);
    $smarty->assign('wxmusic_mx', $wxmusic_mx['items'][0]);
    // $smarty->assign('res_xmlx', $wxmusic_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('wxmusic_mx.tpl');
}


if ($_REQUEST['act'] == 'delete_wxmusic') {

    //echo 1;
    if (isset($_REQUEST['wxmusic_sn'])) {
        $wxmusic_sn = trim($_REQUEST['wxmusic_sn']);
        $sql = "delete from wxmusic where  wxmusic_sn= '" . $wxmusic_sn . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}

if ($_REQUEST['act'] == 'wxmusic_xs') {
    if (isset($_REQUEST['wxmusic_code']) && isset($_REQUEST['alt'])) {
        $wxmusic_code = urldecode(trim($_REQUEST['wxmusic_code']));
        $alt = urldecode(trim($_REQUEST['alt']));

        $sql = "update  wxmusic set tzsy=" . $alt . "  where  wxmusic_sn= '" . $wxmusic_code .
            "'";
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";
    } else {
        echo "失败";
    }
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
        update_wxmusic_mx("wxmusic",
        "wxmusic_name,wxmusic_note_1,wxmusic_note_2,type,type_name,sort_no,is_tuig,seo,title,wxmusic_lx,wxmusic_msg",
        "wxmusic_sn", $time_field);

    $smarty->assign('fall', 'post');
    $smarty->display('wxmusic_mx.tpl');

    if (isset($_REQUEST['wxmusic_sn'])) {
        $wxmusic_sn = trim($_REQUEST['wxmusic_sn']);
    }

    //生成html
    $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
    $htmlname = $wxmusic_sn;
    $sql2 = "select wxmusic_sn,wxmusic_name,imgurl,wxmusic_note_1,wxmusic_note_2,type,type_name,sort_no,is_tuig,seo,title,add_time from wxmusic where wxmusic_sn='" .
        $htmlname . "'";
    $res = $GLOBALS['db']->getAll($sql2);

    for ($i = 0; $i < count($res); $i++) {
       $sql3 = "select wxmusic_sn,is_tuig,title from wxmusic where is_tuig=1";
       $ress = $GLOBALS['db']->getAll($sql3);
       $res[$i]['wxmusictj'] = $ress;
       for($j = 0; $j < count($res[$i]['wxmusictj']); $j++)
       {
        $res[$i]['wxmusictj'][$j]['tj_url']=$url_this.'/html/wxmusic/'.'html_'.$res[$i]['wxmusictj'][$j]['wxmusic_sn'].'.html';
       }              
    }
    //print_r($res);
    //$smarty->assign('wxmusictj', $ress);
    $smarty->assign('wxmusic', $res[0]);   
    $content = $smarty->fetch('zyw/wxmusic_html.tpl', null, null, false); //用$Content[$i] 得到每页的内容
    //print_r($content);
    //替换完了，我们把内容写到文件里
    $htmlname = 'html_' . $htmlname;
    if (file_exists($htmlname)) {
        @unlink($htmlname); //如果文件已经存在就把它删除
    }
    $fp = fopen('html/wxmusic/' . $htmlname . '.html', "w"); //以可写方式打开$HtmlName ，第一次循环是打开index_1.html
    fwrite($fp, $content); //用fwrite()函数， 把内容写入每个文件
    fclose($fp);
}


if ($_REQUEST['act'] == 'post_add') {
    if (isset($_REQUEST['wxmusic_sn'])) {
        $wxmusic_sn = trim($_REQUEST['wxmusic_sn']);
    }

    $get_one = " select wxmusic_sn from wxmusic where wxmusic_sn ='" . $wxmusic_sn .
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
        insert_wxmusic_mx("wxmusic",
            "wxmusic_sn,wxmusic_name,wxmusic_note_1,wxmusic_note_2,type,type_name,sort_no,is_tuig,seo,title,wxmusic_lx,wxmusic_msg",
            $time_field);

        $smarty->assign('fall', 'post');
        $smarty->display('wxmusic_mx.tpl');

        //生成html

        $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);

        //print_r($url_this."/html_".$wxmusic_sn.".html");exit;//http://localhost:8081\

        $htmlname = $wxmusic_sn;
        $sql2 = "select wxmusic_sn,wxmusic_name,imgurl,wxmusic_note_1,wxmusic_note_2,type,type_name,sort_no,is_tuig,seo,title,add_time from wxmusic where wxmusic_sn='" .$htmlname . "'";
        $res = $GLOBALS['db']->getAll($sql2);
        
       for ($i = 0; $i < count($res); $i++) {
       $sql3 = "select wxmusic_sn,is_tuig,title from wxmusic where is_tuig=1";
       $ress = $GLOBALS['db']->getAll($sql3);
       $res[$i]['wxmusictj'] = $ress;
       
        for($j = 0; $j < count($res[$i]['wxmusictj']); $j++)
       {
        $res[$i]['wxmusictj'][$j]['tj_url']=$url_this.'/html/wxmusic/'.'html_'.$res[$i]['wxmusictj'][$j]['wxmusic_sn'].'.html';
       }
       
    }
        
        $smarty->assign('wxmusic', $res[0]);
       
        
        $content = $smarty->fetch('zyw/wxmusic_html.tpl', null, null, false); //用$Content[$i] 得到每页的内容
        $htmlname = 'html_' . $htmlname;
        if (file_exists($htmlname)) {
            @unlink($htmlname); //如果文件已经存在就把它删除
        }
        $fp = fopen('html/wxmusic/' . $htmlname . '.html', "w"); //以可写方式打开$HtmlName ，第一次循环是打开index_1.html
        fwrite($fp, $content); //用fwrite()函数， 把内容写入每个文件
        fclose($fp);


    } else {
        $smarty->assign('fall', 'fs');
        $smarty->display('wxmusic_mx.tpl');
    }


}


///////批量生成html
if($_REQUEST['act']=='makehtml'){
    
       $sqla = "select wxmusic_sn,wxmusic_name,imgurl,type,type_name,sort_no,is_tuig,seo,title,add_time from wxmusic";
       $resa = $GLOBALS['db']->getAll($sqla);
       
    
    for ($k = 0; $k < count($resa); $k++) {
     //    $resa[$i]['abc'] = $resa[$i]['wxmusic_sn'];
    //print_r($resa[$k]['wxmusic_sn']);
    $url_this = "http:" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
    $htmlname = $resa[$k]['wxmusic_sn'];
    $sql2 = "select wxmusic_sn,wxmusic_name,imgurl,wxmusic_note_1,wxmusic_note_2,type,type_name,sort_no,is_tuig,seo,title,add_time from wxmusic where wxmusic_sn='" .
        $htmlname . "'";
    $res = $GLOBALS['db']->getAll($sql2);

    for ($i = 0; $i < count($res); $i++) {
       $sql3 = "select wxmusic_sn,is_tuig,title from wxmusic where is_tuig=1";
       $ress = $GLOBALS['db']->getAll($sql3);
       $res[$i]['wxmusictj'] = $ress;
       for($j = 0; $j < count($res[$i]['wxmusictj']); $j++)
       {
        $res[$i]['wxmusictj'][$j]['tj_url']=$url_this.'/html/wxmusic/'.'html_'.$res[$i]['wxmusictj'][$j]['wxmusic_sn'].'.html';
       }              
    }   
    $smarty->assign('wxmusic', $res[0]);   
    $content = $smarty->fetch('zyw/wxmusic_html.tpl', null, null, false); //用$Content[$i] 得到每页的内容
    $htmlname = 'html_' . $htmlname;
    if (file_exists($htmlname)) {
        @unlink($htmlname); //如果文件已经存在就把它删除
    }
    $fp = fopen('html/wxmusic/' . $htmlname . '.html', "w"); //以可写方式打开$HtmlName ，第一次循环是打开index_1.html
    fwrite($fp, $content); //用fwrite()函数， 把内容写入每个文件
    fclose($fp);
    }
    
    echo "生成完毕";
}




?>