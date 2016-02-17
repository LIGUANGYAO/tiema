<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_wximages.php');
require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
    ///修改1,查询语句
    //sort_no,tzsy 要记得添加
    $sql = "select id,wximages_sn,wximages_name,sort_no,tzsy,last_update,wximages_note_1,title,type,wximages_lx,wximages_msg from wximages";
    $wximages_list = get_wximages_list($Num, "wximages", $sql);
    
    
    
 function get_fl($obj)
        {
            $sql="select wxfloor_sn ,wxfloor_name,type from wxfloor where tzsy=0 and wxfloor_sn='".$obj."'";
            $res = $GLOBALS['db']->getRow($sql);
            return $res;
        }
    for($i=0;$i<count($wximages_list['items']);$i++)
    {
       
        $arr=get_fl($wximages_list['items'][$i]['wximages_lx']);
        $wximages_list['items'][$i]['lx_sn']=$arr['wxfloor_sn'];
        $wximages_list['items'][$i]['lx_name']=$arr['wxfloor_name'];
    }
  
    //print_r($wximages_list);
    $smarty->assign('wximages_list', $wximages_list['items']);
    $smarty->assign('fall', 1);
    //$smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $wximages_list['page']);
    $smarty->display('wximages.tpl');


}

if ($_REQUEST['act'] == 'add_wximages_list') {

    $sql="select wxfloor_sn ,wxfloor_name from wxfloor where type=3";
    $res_wxfloor = $GLOBALS['db']->getAll($sql);
    // print_r($res_wxfloor);
    $smarty->assign('res_wxfloor', $res_wxfloor);
    $smarty->assign('fall', 'add_wximages_list');
    $smarty->display('wximages_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];

    ///修改2,查询语句
    $sql = "select id,wximages_sn,wximages_name,sort_no,tzsy,last_update,wximages_note_1,wximages_note_2,type,is_tuig,seo,title,wximages_lx,wximages_msg from wximages";
    
    $wximages_mx = get_wximages_mx("wximages", $sql);
   
   
    $img_cod = $_REQUEST['wximages_sn'];
    $wximages_lx=$wximages_mx['items'][0]['wximages_lx'];
    ////图片部分。没图片则删除
    //    $wximages_imgs2 = get_wximages_imgs_list("wximages_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
    ////print_r($wximages_imgs2);
    //    $wximages_imgs = arr_push($wximages_imgs2['items']);
    //    $smarty->assign('wximages_imgs', $wximages_imgs);
    //
    $sql="select wxfloor_sn ,wxfloor_name from wxfloor where type=3 ";
    $res_wxfloor = $GLOBALS['db']->getAll($sql);
    
    $sql="select wxfloor_sn ,wxfloor_name from wxfloor where wxfloor_sn='".$wximages_lx."' and type=3 ";
    $res_wxfloor22 = $GLOBALS['db']->getAll($sql);
    
     // print_r($res_wxfloor);
    $smarty->assign('res_wxfloor', $res_wxfloor);
    $smarty->assign('res_wxfloor22', $res_wxfloor22[0]);
     // print_r($res_wxfloor22[0]);
    $smarty->assign('wximages_mx', $wximages_mx['items'][0]);
    // $smarty->assign('res_xmlx', $wximages_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('wximages_mx.tpl');
}


if ($_REQUEST['act'] == 'delete_wximages') {

    //echo 1;
    if (isset($_REQUEST['wximages_sn'])) {
        $wximages_sn = trim($_REQUEST['wximages_sn']);

        $sql = "delete from wximages where  wximages_sn= '" . $wximages_sn . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}

if ($_REQUEST['act'] == 'wximages_xs') {

    //echo 1;

    if (isset($_REQUEST['wximages_code']) && isset($_REQUEST['alt'])) {
        $wximages_code = urldecode(trim($_REQUEST['wximages_code']));
        $alt = urldecode(trim($_REQUEST['alt']));

        $sql = "update  wximages set tzsy=" . $alt . "  where  wximages_sn= '" . $wximages_code .
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
    update_wximages_mx("wximages",
        "wximages_name,wximages_note_1,wximages_note_2,type,type_name,sort_no,is_tuig,seo,title,wximages_lx,wximages_msg",
        "wximages_sn", $time_field);

    $smarty->assign('fall', 'post');
    $smarty->display('wximages_mx.tpl');

    if (isset($_REQUEST['wximages_sn'])) {
        $wximages_sn = trim($_REQUEST['wximages_sn']);
    }

    //生成html

    $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);

    //print_r($url_this."/html_".$wximages_sn.".html");exit;//http://localhost:8081\

    $htmlname = $wximages_sn;
    $sql2 = "select wximages_sn,wximages_name,wximages_lx,wximages_note_1,wximages_note_2,type,type_name,sort_no,is_tuig,seo,title,add_time from wximages where wximages_sn='" .
        $htmlname . "'";
    $res = $GLOBALS['db']->getAll($sql2);

    for ($i = 0; $i < count($res); $i++) {
       $sql3 = "select wximages_sn,is_tuig,title from wximages where is_tuig=1 and wximages_lx='".$res[$i]['wximages_lx']."' order by add_time DESC limit 5";
       $ress = $GLOBALS['db']->getAll($sql3);
       $res[$i]['wximagestj'] = $ress;
       
        for($j = 0; $j < count($res[$i]['wximagestj']); $j++)
       {
        $res[$i]['wximagestj'][$j]['tj_url']=$url_this.'/html/wximages/'.'html_'.$res[$i]['wximagestj'][$j]['wximages_sn'].'.html';
       }
      
    }
    
    $smarty->assign('wximages', $res[0]);
    //$smarty->display('wximages_html.tpl');
    $content = $smarty->fetch('zyw/wximages_html.tpl', null, null, false); //用$Content[$i] 得到每页的内容
    //print_r($content);
    //替换完了，我们把内容写到文件里
    $htmlname = 'html_' . $htmlname;
    if (file_exists($htmlname)) {
        @unlink($htmlname); //如果文件已经存在就把它删除
    }
    $fp = fopen('html/wximages/' . $htmlname . '.html', "w"); //以可写方式打开$HtmlName ，第一次循环是打开index_1.html
    fwrite($fp, $content); //用fwrite()函数， 把内容写入每个文件
    fclose($fp);
}


if ($_REQUEST['act'] == 'post_add') {
    if (isset($_REQUEST['wximages_sn'])) {
        $wximages_sn = trim($_REQUEST['wximages_sn']);
    }

    $get_one = " select wximages_sn from wximages where wximages_sn ='" . $wximages_sn .
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
        insert_wximages_mx("wximages",
            "wximages_sn,wximages_name,wximages_note_1,wximages_note_2,type,type_name,sort_no,is_tuig,seo,title,wximages_lx,wximages_msg",
            $time_field);

        $smarty->assign('fall', 'post');
        $smarty->display('wximages_mx.tpl');

        //生成html

        $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);

        //print_r($url_this."/html_".$wximages_sn.".html");exit;//http://localhost:8081\

        $htmlname = $wximages_sn;
        $sql2 = "select wximages_sn,wximages_name,wximages_note_1,wximages_note_2,type,type_name,sort_no,is_tuig,seo,title,add_time from wximages where wximages_sn='" .
            $htmlname . "'";
        $res = $GLOBALS['db']->getAll($sql2);
        
         for ($i = 0; $i < count($res); $i++) {
       $sql3 = "select wximages_sn,is_tuig,title from wximages where is_tuig=1";
       $ress = $GLOBALS['db']->getAll($sql3);
       $res[$i]['wximagestj'] = $ress;
       
        for($j = 0; $j < count($res[$i]['wximagestj']); $j++)
       {
        $res[$i]['wximagestj'][$j]['tj_url']=$url_this.'/html/wximages/'.'html_'.$res[$i]['wximagestj'][$j]['wximages_sn'].'.html';
       }
       
    }
        
        

        $smarty->assign('wximages', $res[0]);
        //$smarty->display('wximages_html.tpl');
        $content = $smarty->fetch('zyw/wximages_html.tpl', null, null, false); //用$Content[$i] 得到每页的内容
        //print_r($content);
        //替换完了，我们把内容写到文件里
        $htmlname = 'html_' . $htmlname;
        if (file_exists($htmlname)) {
            @unlink($htmlname); //如果文件已经存在就把它删除
        }
        $fp = fopen('html/wximages/' . $htmlname . '.html', "w"); //以可写方式打开$HtmlName ，第一次循环是打开index_1.html
        fwrite($fp, $content); //用fwrite()函数， 把内容写入每个文件
        fclose($fp);


    } else {
        $smarty->assign('fall', 'fs');
        $smarty->display('wximages_mx.tpl');
    }


}


?>