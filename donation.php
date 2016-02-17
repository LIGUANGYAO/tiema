<?php

define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/sub_donation.php');
require (dirname(__file__) . '/sub/page.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'default') {

    //echo $Num;exit;
    $list = donation($Num, "donation");
   
     
    //print_r($list);
    $smarty->assign('donation_list', $list['item']);
    $smarty->assign('p_Array', $list['page']);
    $smarty->assign('fall', 'donation');
    $smarty->display('donation.tpl');
}


if ($_REQUEST['act'] == 'a_donation') {


    $smarty->assign('fall', 'a_donation');
    $smarty->display('donation.tpl');
}


if ($_REQUEST['act'] == 'e_donation') {

    //$aaa=$_GET['goods_sn'];
    
    ///修改2,查询语句
    if(isset($_REQUEST['edit']))
    {
        $code = urldecode(trim($_REQUEST['edit']));
        $list=get_donation_mx($code);
        //print_r($list);
        $smarty->assign('list_mx', $list['items'][0]);
        $smarty->assign('fall', 'e_donation');
        $smarty->display('donation.tpl');
    }
   
   
  
    
}

if ($_REQUEST['act'] == 'post') {


    //修改3，更新语句
     $time_field=array(
    //array("type"=>"2","field"=>"add_time","method"=>"1"),

    array("type"=>"1","field"=>"last_update_2","method"=>"2")
    );
    //print_r($time_field);exit;
    update_donation_mx("donation","donation_name,note,time,time2,bz1,bz2,bz3,bz4,bz5,address,je,type,sort_no","donation_sn",$time_field);
    
    $smarty->assign('fall', 'i_staus');
    $smarty->assign('val', '修改成功');
    $smarty->display('donation.tpl');
}

if ($_REQUEST['act'] == 'i_donation') {

    if (isset($_REQUEST['donation_sn'])) {
        $donation_sn = trim($_REQUEST['donation_sn']);
    }
    //print_r($p_id);exit;
    //res_xmlx

    $get_one = " select donation_sn from  donation where donation_sn='" . $donation_sn . "'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($res);exit;
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
        i_donation("donation", "donation_sn,donation_name,note,time,time2,bz1,bz2,bz3,bz4,bz5,address,je,type,sort_no", $time_field);

        $smarty->assign('fall', 'i_staus');
        $smarty->assign('val', '添加成功');
        $smarty->display('donation.tpl');
    } else {
        $smarty->assign('fall', 'i_staus');
        $smarty->assign('val', '代码已经存在,请重新输入');
        $smarty->display('donation.tpl');
    }


}


//禁用启用删除等操作

if ($_REQUEST['act'] == 'ed_status') {
  
    if (isset($_REQUEST['qiyong'])) {
        $code = urldecode(trim($_REQUEST['qiyong']));

        $sql = "update donation set tzsy=0 where  donation_sn= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "启用成功";
    } else {
       
    }
    
    
    
    
     if (isset($_REQUEST['jinyong'])) {
        $code = urldecode(trim($_REQUEST['jinyong'])) ;
        $sql = "update donation set tzsy=1 where  donation_sn= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "禁用成功";
    } else {
        
    }
    
    
    
    
    
     if (isset($_REQUEST['delete'])) {
        $code = urldecode(trim($_REQUEST['delete'])) ;
        $sql = "delete from  donation where  donation_sn= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";
    } else {
        
    }
}
?>
