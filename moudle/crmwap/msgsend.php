<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/f/sub_msgsend.php');

require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['g'])) {
    $_REQUEST['g'] = 'default';
} else {
    $_REQUEST['g'] = trim($_REQUEST['g']);
}


//设定传入主参数
$g_add=substr(md5("a_msgsend"),0,17); //添加参数
$g_e=substr(md5("e_msgsend"),0,17); //编辑
$g_post=substr(md5("post_msgsend"),0,17); //修改保存
$g_d=substr(md5("d_msgsend"),0,17); //删除
$g_in=substr(md5("in_msgsend"),0,17); //插入
$g_xs=substr(md5("xs_msgsend"),0,17); //显示

//g= default默认 e编辑d删除 p接收修改 i接收添加
if ($_REQUEST['g'] == 'default') {


    ///修改1,查询语句
    //sort_no,tzsy 要记得添加
    
    
    $sql = "select msgsend_sn,user_name,send_time,msgsend_time,bz,fasongleixing,is_send,error_msg  from msgsend";


    $list = get_msgsend_list($Num, "msgsend", $sql);

    //单独搜索
 
 
    $send_time_1= trim($_REQUEST['send_time_1']);    
    $smarty->assign('send_time_1',$send_time_1);
    $send_time_2= trim($_REQUEST['send_time_2']);    
    $smarty->assign('send_time_2',$send_time_2);
 
 
 
 
    $fasongleixing= trim($_REQUEST['fasongleixing']);    
    if($fasongleixing=='')
    {
        $fasongleixing='';
    }
    $smarty->assign('fasongleixing',$fasongleixing);
 
 


    if(1==1)
    {
                //是否开放keyword记住输入值
        $m_key= trim($_REQUEST['m_key']);
        $smarty->assign('m_key',$m_key);
    }
    
    
    $kehu_list="select * from kehu where id='".$_REQUEST['kehu_id']."'";
    $kehu_list = $GLOBALS['db']->getRow($kehu_list);
    $smarty->assign('kehu',$kehu_list);
    
    //print_r($list);
    $smarty->assign('msgsend_list', $list['items']);
    $smarty->assign('fall', 1);
    //$smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $list['page']);
    $smarty->display('w/msgsend.html');


}


if ($_REQUEST['g'] == $g_add) {
 
 
 
 
 
    $kehu_list="select * from kehu where id='".$_REQUEST['kehu_id']."'";
    $kehu_list = $GLOBALS['db']->getRow($kehu_list);
    $smarty->assign('kehu',$kehu_list);
 
    $smarty->assign('msgsend_time', date('Y-m-d H:i:s', time()));
        
    
    $smarty->assign('fall', 'add_list');
    $smarty->display('w/msgsend_mx.html');
}

//判断是否有编辑功能
//没有编辑代码

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
//没有删除代码

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
//没有启用代码


if ($_REQUEST['g'] == $g_post) {
 
    $time_field = array( //array("type"=>"2","field"=>"add_time","method"=>"1"),
            array(
            "type" => "1",
            "field" => "last_update2",
            "method" => "2"));
    //print_r($time_field);exit;
    
    $fi2.="msgsend_sn,";
    //主字段
    $bianset2='msgsend_sn';
    
    $fi2.="user_name,";
    $fi2.="send_time,";
    $fi2.="msgsend_time,";
    $fi2.="bz,";
    $fi2.="fasongleixing";

    update_msgsend_mx("msgsend",$fi2,$bianset2, $time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('f/msgsend_mx.html');

    
}


if ($_REQUEST['g'] == $g_in) {
    //echo 1;exit;
    //主字段
    $bianset='msgsend_sn';
    
    
    
    
    
    
    $_REQUEST[$bianset] = 'MS'.date('ymd') . substr(time(), -5) . substr(microtime(), 2, 5);
    if (isset($_REQUEST[$bianset])) {
        $code_wy = trim($_REQUEST[$bianset]);
    }


    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one = " select $bianset from msgsend where $bianset ='" . $code_wy .
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
    //强制设置字段
    $_REQUEST['user_name']=getlogin_name();
    
    
    
    $fi2.="msgsend_sn,";
    //主字段
    $bianset2='msgsend_sn';
    
    $fi2.="user_name,";
    $fi2.="send_time,";
    $fi2.="msgsend_time,kehu_id,";
    $fi2.="bz,";
    $fi2.="fasongleixing";
        insert_msgsend_mx("msgsend",
            $fi2,
            $time_field);
        
        $smarty->assign('fall', 'post2');
        $smarty->display('f/msgsend_mx.html');

      


    } else {
        $smarty->assign('val', '代码已存在');
        $smarty->assign('fall', 'fs');
        $smarty->display('f/msgsend_mx.html');
    }
    header("location: msgsend.html?kehu_id=".$_REQUEST['kehu_id']);

}


?>