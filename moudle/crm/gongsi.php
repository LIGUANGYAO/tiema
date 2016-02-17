<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/f/sub_gongsi.php');

require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['g'])) {
    $_REQUEST['g'] = 'default';
} else {
    $_REQUEST['g'] = trim($_REQUEST['g']);
}


//设定传入主参数
$g_add=substr(md5("a_gongsi"),0,17); //添加参数
$g_e=substr(md5("e_gongsi"),0,17); //编辑
$g_post=substr(md5("post_gongsi"),0,17); //修改保存
$g_d=substr(md5("d_gongsi"),0,17); //删除
$g_in=substr(md5("in_gongsi"),0,17); //插入
$g_xs=substr(md5("xs_gongsi"),0,17); //显示

//g= default默认 e编辑d删除 p接收修改 i接收添加
if ($_REQUEST['g'] == 'default') {


    ///修改1,查询语句
    //sort_no,tzsy 要记得添加
    
    
    $sql = "select gongsi_sn,gongsi_name,lianxiren,tel,bz  from gongsi";


    $list = get_gongsi_list($Num, "gongsi", $sql);

    //单独搜索
 
 
 
 
 


    if(1==1)
    {
                //是否开放keyword记住输入值
        $m_key= trim($_REQUEST['m_key']);
        $smarty->assign('m_key',$m_key);
    }
    
    

    
    
    $smarty->assign('gongsi_list', $list['items']);
    $smarty->assign('fall', 1);
    //$smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $list['page']);
    $smarty->display('f/gongsi.html');


}


if ($_REQUEST['g'] == $g_add) {
 
 
 
 
 
 
        
    
    $smarty->assign('fall', 'add_list');
    $smarty->display('f/gongsi_mx.html');
}

//判断是否有编辑功能
//有编辑代码
if ($_REQUEST['g'] == $g_e) {
    //$aaa=$_GET['goods_sn'];
    ///修改2,查询语句
    
 
    $fi.="gongsi_sn,";
    //主字段
    $bianset='gongsi_sn';
 
    $fi.="gongsi_name,";
 
    $fi.="lianxiren,";
 
    $fi.="tel,";
 
    $fi.="bz";
    $sql = "select $fi  from gongsi ";
    $gongsi_mx = get_gongsi_mx($bianset, $sql);

   
    $smarty->assign('gongsi_mx', $gongsi_mx['items'][0]);
    
    //print_r($gongsi_mx);
    // $smarty->assign('res_xmlx', $color_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('f/gongsi_mx.html');
}

if ($_REQUEST['g'] == 'd') {

    //echo 1;
    if (isset($_REQUEST['img_code'])) {
        $img_code = trim($_REQUEST['img_code']);

        $sql = "delete from color_imgs where  img_outer_id= '" . $img_code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}

//判断是否有删除功能
//有删除代码
if ($_REQUEST['g'] == $g_d) {

    //主字段
    $bianset='gongsi_sn';
    //echo 1;
    $arr=array();
    if (isset($_REQUEST[$bianset]) && empty($arr)) {
        $gongsi_sn = trim(urldecode($_REQUEST[$bianset]));

        $sql = "delete from gongsi where  $bianset= '" . $gongsi_sn . "'";
        $res = $GLOBALS['db']->query($sql);
        
        echo "1";
    } else {
        echo "2";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}

if ($_REQUEST['g'] == 'img_xs') {

    //echo 1;
    if (isset($_REQUEST['img_code']) && isset($_REQUEST['alt'])) {
        $img_code = trim($_REQUEST['img_code']);
        $alt = trim($_REQUEST['alt']);

        $sql = "update  color_imgs set ss=" . $alt . "  where  img_outer_id= '" . $img_code .
            "'";
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}



//判断是否有启用代码
//有启用代码
if ($_REQUEST['g'] == $g_xs) {

    //主字段
    $bianset='gongsi_sn';

    if (isset($_REQUEST[$bianset]) && isset($_REQUEST['alt'])) {
        $code = urldecode(trim($_REQUEST[$bianset]));
        $alt = urldecode(trim($_REQUEST['alt']));

        $sql = "update  gongsi set tzsy=" . $alt . "  where  $bianset= '" . $code .
            "'";

        $res = $GLOBALS['db']->query($sql);
        echo "更新成功";
    } else {
        echo "失败";
    }

    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}


if ($_REQUEST['g'] == $g_post) {
 
    $time_field = array( //array("type"=>"2","field"=>"add_time","method"=>"1"),
            array(
            "type" => "1",
            "field" => "last_update2",
            "method" => "2"));
    //print_r($time_field);exit;
    
    $fi2.="gongsi_sn,";
    //主字段
    $bianset2='gongsi_sn';
    
    $fi2.="gongsi_name,";
    $fi2.="lianxiren,";
    $fi2.="tel,";
    $fi2.="bz";

    update_gongsi_mx("gongsi",$fi2,$bianset2, $time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('f/gongsi_mx.html');

    
}


if ($_REQUEST['g'] == $g_in) {
    //echo 1;exit;
    //主字段
    $bianset='gongsi_sn';
    
    
    
    
    
    $_REQUEST[$bianset] = 'GS'.date('ymd') . substr(time(), -5) . substr(microtime(), 2, 5);
    if (isset($_REQUEST[$bianset])) {
        $code_wy = trim($_REQUEST[$bianset]);
    }


    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one = " select $bianset from gongsi where $bianset ='" . $code_wy .
        "'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($get_one);exit;
    if (empty($res)) {
        //echo 1;
        // $p = new upload;
        //        $path=$p->upload_path='upload/color';
        //        $p->uplood_img();
        //        $img_array = $p->upload_file;
        //        for($i=0;$i<count($img_array['guige']);$i++)
        //        {
        //        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
        //        }
        //        //print_r($img_array);exit;
        //        $aaa = $color_sn;
        //
        //        //插入图片记录//图片部分。没图片则删除
        //         img_insert($aaa, $img_array,"color_imgs");
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
        
    $fi2.="gongsi_sn,";
    //主字段
    $bianset2='gongsi_sn';
    
    $fi2.="gongsi_name,";
    $fi2.="lianxiren,";
    $fi2.="tel,";
    $fi2.="bz";
        insert_gongsi_mx("gongsi",
            $fi2,
            $time_field);
        
        $smarty->assign('fall', 'post2');
        $smarty->display('f/gongsi_mx.html');

      


    } else {
        $smarty->assign('val', '代码已存在');
        $smarty->assign('fall', 'fs');
        $smarty->display('f/gongsi_mx.html');
    }


}


?>