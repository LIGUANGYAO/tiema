<?php

define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/sub_menu1.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'default') {

    $menu_list = menu1_list();
    //print_r($menu_list);
    $smarty->assign('fall', 1);
    $smarty->assign('menu_list', $menu_list);
    $smarty->display('memu1.tpl');
}


if ($_REQUEST['act'] == 'post_add') {
    if (isset($_REQUEST['imgtext_sn'])) {
        $imgtext_sn = trim($_REQUEST['imgtext_sn']);
    }
    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one = " select imgtext_sn from imgtext where imgtext_sn ='" . $imgtext_sn .
        "'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($get_one);exit;
    if (empty($res)) {
        //echo 1;
        $p = new upload;
        $path = $p->upload_path = 'upload/imgtext';
        $p->uplood_img();
        $img_array = $p->upload_file;
        for ($i = 0; $i < count($img_array['guige']); $i++) {
            $img_array['guige'][$i] = (array )$img_array['guige'][$i];
        }
        //print_r($img_array);exit;
        $aaa = $imgtext_sn;

        //插入图片记录//图片部分。没图片则删除
        img_insert($aaa, $img_array, "imgtext_imgs");
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
        insert_imgtext_mx("imgtext",
            "imgtext_sn,imgtext_name,imgtext_note_1,type,type_name,sort_no", $time_field);

        $smarty->assign('fall', 'post');
        $smarty->display('imgtext_mx.tpl');
    } else {
        $smarty->assign('fall', 'post');
        $smarty->display('imgtext_mx.tpl');
    }


}

if ($_REQUEST['act'] == 'post') {

    update_menu1();
    $smarty->assign('fall', 2);
    $smarty->assign('val', '修改成功');
    $smarty->display('memu1.tpl');
}


///获取下拉二级列表
if ($_REQUEST['act'] == 'get_type') {

    //echo 1;exit;
    //if(isset($_REQUEST['province'])){
    require (dirname(__file__) . '/sub/rest.php');
    $type = urldecode($_REQUEST['type']);

    if ($type == "text") {
        $sql_t = "select text_sn as sn,title as name from text_reply where tzsy=0";
        $sql_t = $GLOBALS['db']->getAll($sql_t);
        $aaa = new arraytojson();
        $json = $aaa->JSON($sql_t);

        print_r($json);

    } elseif ($type == "imgtext") {
        $sql_t = "select imgtext_sn as sn,imgtext_name as name from imgtext where tzsy=0";
        $sql_t = $GLOBALS['db']->getAll($sql_t);
        $aaa = new arraytojson();
        $json = $aaa->JSON($sql_t);

        print_r($json);
    } elseif ($type == "url") {
        $sql_t = "select actionurl_sn as sn,actionurl_name as name from actionurl where tzsy=0";
        $sql_t = $GLOBALS['db']->getAll($sql_t);
        $aaa = new arraytojson();
        $json = $aaa->JSON($sql_t);

        print_r($json);
    } elseif ($type == "html") {
        $sql_t = "select article_sn as sn,article_name as name from article where tzsy=0";
        $sql_t = $GLOBALS['db']->getAll($sql_t);
        $aaa = new arraytojson();
        $json = $aaa->JSON($sql_t);

        print_r($json);
    }else
    {
        $arr=array();
        $aaa = new arraytojson();
        $json = $aaa->JSON($arr);

        print_r($json);
    }

}


if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if (isset($_REQUEST['menu_sn'])) {
        $menu_sn = trim($_REQUEST['menu_sn']);

        $sql = "delete from menu_list where  menu_sn= '" . $menu_sn . "'";
        $res = $GLOBALS['db']->query($sql);
        $sql2 = "delete from menu_list where  p_id= '" . $menu_sn . "'";
        $res2 = $GLOBALS['db']->query($sql2);
        echo "删除成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}


if ($_REQUEST['act'] == 'add_menu_list') {


    if (isset($_REQUEST['type']) && isset($_REQUEST['p_id'])) {
        $type = $_REQUEST['type'];
        $p_id = $_REQUEST['p_id'];
        //echo $type."  ".$p_id;exit;
        if ($type == 1) {
            $a_list = "insert into menu_list(type,menu_type,sort_no) values('',1,0)";
            // print_r($a_list);
            $a_list = $GLOBALS['db']->query($a_list);
            $up = "update menu_list set menu_sn=concat('M00',menu_type,'_',id) where menu_sn is null;";
            $up = $GLOBALS['db']->query($up);
        } elseif ($type == 2) {
            $a_list = "insert into menu_list(p_id,type,menu_type,sort_no) values('" . $p_id .
                "','click',2,0)";
            //print_r($a_list);
            $a_list = $GLOBALS['db']->query($a_list);
            $up = "update menu_list set menu_sn=concat('M00',menu_type,'_',id) where menu_sn is null;";
            $up = $GLOBALS['db']->query($up);

        }
    }
}
?>
