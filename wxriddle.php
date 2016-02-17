<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_wxriddle.php');
require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
    ///修改1,查询语句
    //sort_no,tzsy 要记得添加
    $sql = "select id,wxriddle_sn,wxriddle_name,sort_no,tzsy,last_update,wxriddle_note_1,wxriddle_note_2,title,type,wxriddle_lx,wxriddle_msg from wxriddle";
    $wxriddle_list = get_wxriddle_list($Num, "wxriddle", $sql);
    
    
    
    function get_fl($obj)
        {
            $sql="select wxfloor_sn ,wxfloor_name,type from wxfloor where tzsy=0 and wxfloor_sn='".$obj."'";
            $res = $GLOBALS['db']->getRow($sql);
            return $res;
        }
    for($i=0;$i<count($wxriddle_list['items']);$i++)
    {
       
        $arr=get_fl($wxriddle_list['items'][$i]['wxriddle_lx']);
        $wxriddle_list['items'][$i]['lx_sn']=$arr['wxfloor_sn'];
        $wxriddle_list['items'][$i]['lx_name']=$arr['wxfloor_name'];
    }
    
  
    //print_r($wxriddle_list);
    $smarty->assign('wxriddle_list', $wxriddle_list['items']);
    $smarty->assign('fall', 1);
    //$smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $wxriddle_list['page']);
    $smarty->display('wxriddle.tpl');


}

if ($_REQUEST['act'] == 'add_wxriddle_list') {

    $sql="select wxfloor_sn ,wxfloor_name from wxfloor where type=4";
    $res_wxfloor = $GLOBALS['db']->getAll($sql);
    // print_r($res_wxfloor);
    $smarty->assign('res_wxfloor', $res_wxfloor);
    $smarty->assign('fall', 'add_wxriddle_list');
    $smarty->display('wxriddle_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];

    ///修改2,查询语句
    $sql = "select id,wxriddle_sn,wxriddle_name,sort_no,tzsy,last_update,wxriddle_note_1,wxriddle_note_2,type,is_tuig,seo,title,wxriddle_lx,wxriddle_msg from wxriddle";
    
    $wxriddle_mx = get_wxriddle_mx("wxriddle", $sql);
   
   
   
    $img_cod = $_REQUEST['wxriddle_sn'];
    $wxriddle_lx=$wxriddle_mx['items'][0]['wxriddle_lx'];
    ////图片部分。没图片则删除
    //    $wxriddle_imgs2 = get_wxriddle_imgs_list("wxriddle_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
    ////print_r($wxriddle_imgs2);
    //    $wxriddle_imgs = arr_push($wxriddle_imgs2['items']);
    //    $smarty->assign('wxriddle_imgs', $wxriddle_imgs);
    //
    $sql="select wxfloor_sn ,wxfloor_name from wxfloor where type=4 ";
    $res_wxfloor = $GLOBALS['db']->getAll($sql);
    
    $sql="select wxfloor_sn ,wxfloor_name from wxfloor where wxfloor_sn='".$wxriddle_lx."' and type=4 ";
    $res_wxfloor2 = $GLOBALS['db']->getAll($sql);
    
     // print_r($res_wxfloor);
    $smarty->assign('res_wxfloor', $res_wxfloor);
    $smarty->assign('res_wxfloor2', $res_wxfloor2[0]);
     // print_r($res_wxfloor22[0]);
    $smarty->assign('wxriddle_mx', $wxriddle_mx['items'][0]);
    // $smarty->assign('res_xmlx', $wxriddle_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('wxriddle_mx.tpl');
}


if ($_REQUEST['act'] == 'delete_wxriddle') {

    //echo 1;
    if (isset($_REQUEST['wxriddle_sn'])) {
        $wxriddle_sn = trim($_REQUEST['wxriddle_sn']);

        $sql = "delete from wxriddle where  wxriddle_sn= '" . $wxriddle_sn . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}

if ($_REQUEST['act'] == 'wxriddle_xs') {

    //echo 1;

    if (isset($_REQUEST['wxriddle_code']) && isset($_REQUEST['alt'])) {
        $wxriddle_code = urldecode(trim($_REQUEST['wxriddle_code']));
        $alt = urldecode(trim($_REQUEST['alt']));

        $sql = "update  wxriddle set tzsy=" . $alt . "  where  wxriddle_sn= '" . $wxriddle_code .
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
    update_wxriddle_mx("wxriddle",
        "wxriddle_name,wxriddle_note_1,wxriddle_note_2,type,type_name,sort_no,is_tuig,seo,title,wxriddle_lx,wxriddle_msg",
        "wxriddle_sn", $time_field);

    $smarty->assign('fall', 'post');
    $smarty->display('wxriddle_mx.tpl');

    if (isset($_REQUEST['wxriddle_sn'])) {
        $wxriddle_sn = trim($_REQUEST['wxriddle_sn']);
    }

    //生成html

    $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);

    //print_r($url_this."/html_".$wxriddle_sn.".html");exit;//http://localhost:8081\

    $htmlname = $wxriddle_sn;
    $sql2 = "select wxriddle_sn,wxriddle_name,wxriddle_note_1,wxriddle_note_2,type,type_name,sort_no,is_tuig,seo,title,add_time from wxriddle where wxriddle_sn='" .
        $htmlname . "'";
    $res = $GLOBALS['db']->getAll($sql2);

 for ($i = 0; $i < count($res); $i++) {
       $sql3 = "select wxriddle_sn,is_tuig,title from wxriddle where is_tuig=1";
       $ress = $GLOBALS['db']->getAll($sql3);
       $res[$i]['wxriddletj'] = $ress;
       
       for($j = 0; $j < count($res[$i]['wxriddletj']); $j++)
       {
        $res[$i]['wxriddletj'][$j]['tj_url']=$url_this.'/html/wxriddle/'.'html_'.$res[$i]['wxriddletj'][$j]['wxriddle_sn'].'.html';
       }
       
      // $res[$i]['wxriddletj'][$i]['tj_url']=$url_this.'/html/wxriddle/'.'html_'.$ress[$i]['wxriddle_sn'].'.html';
       
    }
    //print_r($res);
       // $smarty->assign('wxriddletj', $ress);
    $smarty->assign('wxriddle', $res[0]);   
    $content = $smarty->fetch('zyw/wxriddle_html.tpl', null, null, false); //用$Content[$i] 得到每页的内容
    //print_r($content);
    //替换完了，我们把内容写到文件里
    $htmlname = 'html_' . $htmlname;
    if (file_exists($htmlname)) {
        @unlink($htmlname); //如果文件已经存在就把它删除
    }
    $fp = fopen('html/wxriddle/' . $htmlname . '.html', "w"); //以可写方式打开$HtmlName ，第一次循环是打开index_1.html
    fwrite($fp, $content); //用fwrite()函数， 把内容写入每个文件
    fclose($fp);
}


if ($_REQUEST['act'] == 'post_add') {
    if (isset($_REQUEST['wxriddle_sn'])) {
        $wxriddle_sn = trim($_REQUEST['wxriddle_sn']);
    }

    $get_one = " select wxriddle_sn from wxriddle where wxriddle_sn ='" . $wxriddle_sn .
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
        insert_wxriddle_mx("wxriddle",
            "wxriddle_sn,wxriddle_name,wxriddle_note_1,wxriddle_note_2,type,type_name,sort_no,is_tuig,seo,title,wxriddle_lx,wxriddle_msg",
            $time_field);

        $smarty->assign('fall', 'post');
        $smarty->display('wxriddle_mx.tpl');

        //生成html

        $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);

        //print_r($url_this."/html_".$wxriddle_sn.".html");exit;//http://localhost:8081\

        $htmlname = $wxriddle_sn;
        $sql2 = "select wxriddle_sn,wxriddle_name,wxriddle_note_1,wxriddle_note_2,type,type_name,sort_no,is_tuig,seo,title,add_time from wxriddle where wxriddle_sn='" .$htmlname . "'";
        $res = $GLOBALS['db']->getAll($sql2);
        
       for ($i = 0; $i < count($res); $i++) {
       $sql3 = "select wxriddle_sn,is_tuig,title from wxriddle where is_tuig=1";
       $ress = $GLOBALS['db']->getAll($sql3);
       $res[$i]['wxriddletj'] = $ress;
       
        for($j = 0; $j < count($res[$i]['wxriddletj']); $j++)
       {
        $res[$i]['wxriddletj'][$j]['tj_url']=$url_this.'/html/wxriddle/'.'html_'.$res[$i]['wxriddletj'][$j]['wxriddle_sn'].'.html';
       }
       
    }
        
        $smarty->assign('wxriddle', $res[0]);
       
        
        $content = $smarty->fetch('zyw/wxriddle_html.tpl', null, null, false); //用$Content[$i] 得到每页的内容
        $htmlname = 'html_' . $htmlname;
        if (file_exists($htmlname)) {
            @unlink($htmlname); //如果文件已经存在就把它删除
        }
        $fp = fopen('html/wxriddle/' . $htmlname . '.html', "w"); //以可写方式打开$HtmlName ，第一次循环是打开index_1.html
        fwrite($fp, $content); //用fwrite()函数， 把内容写入每个文件
        fclose($fp);


    } else {
        $smarty->assign('fall', 'fs');
        $smarty->display('wxriddle_mx.tpl');
    }


}


?>