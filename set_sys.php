<?php

define('IN_ECS', true);

require (dirname(__file__) . '/includes/init.php');


if (empty($_REQUEST['m'])) {
    $_REQUEST['m'] = 'default';
} else {
    $_REQUEST['m'] = trim($_REQUEST['m']);
}


if ($_REQUEST['m'] == 'default') {


    function get_setsys()
    {
        $sql = "select * from set_sys where keyword='check_in'";
        $res = $GLOBALS['db']->getRow($sql);
        return $res;
    }
    $sys_list = get_setsys();

    $smarty->assign('sys_list', $sys_list);

    //验证码32/8位
    function get_active_pwd()
    {
        $sql = "select * from set_sys where keyword='active_pwd'";
        $res = $GLOBALS['db']->getRow($sql);
        return $res;
    }
    $active_pwd = get_active_pwd();

    $smarty->assign('active_pwd', $active_pwd['val']);


    //获取短信验证账号密码
    function get_wxextel()
    {
        $sql = "select a.val,b.p_id,b.type,b.type_val,b.note from set_sys a inner join set_sys_mx b on a.keyword=b.p_id where a.keyword='wxextel' order by type";
        $res = $GLOBALS['db']->getAll($sql);

        return array("list" => $res, "wxextel" => $res[0]['val']);
    }
    $get_wxextel = get_wxextel();
    // print_r($get_wxextel);
    $smarty->assign('wxextel_val', $get_wxextel['wxextel']);
    $smarty->assign('get_wxextel', $get_wxextel['list']);
    //-----------------

    // print_r($get_wxextel);
    function get_ex_point()
    {
        $sql = "select a.val,b.p_id,b.type,b.type_val from set_sys a inner join set_sys_mx b on a.keyword=b.p_id where a.keyword='ex_point' order by type";
        $res = $GLOBALS['db']->getAll($sql);

        return array("list" => $res, "ex_point" => $res[0]['val']);
    }
    $get_ex_point = get_ex_point();

    $smarty->assign('ex_point_val', $get_ex_point['ex_point']);
    $smarty->assign('get_ex_point', $get_ex_point['list']);
    $smarty->assign('sys_list', $sys_list);


    function get_ex_real()
    {
        $sql = "select a.val,b.p_id,b.type,b.type_val,b.note from set_sys a inner join set_sys_mx b on a.keyword=b.p_id where a.keyword='ex_real' order by type";
        $res = $GLOBALS['db']->getAll($sql);

        return array("list" => $res, "ex_real" => $res[0]['val']);
    }
    $get_ex_real = get_ex_real();
    // print_r($get_ex_real);
    $smarty->assign('ex_real_val', $get_ex_real['ex_real']);
    $smarty->assign('get_ex_real', $get_ex_real['list']);


    //--留言
    function get_lvmsg()
    {
        $sql = "select * from set_sys where keyword='lv_msg'";
        $res = $GLOBALS['db']->getRow($sql);
        return $res;
    }
    $lv_msg = get_lvmsg();

    $smarty->assign('lv_msg', $lv_msg);

    // print_r($list);
    
    
    
    
    //获取是否进入个人中心进行赠送积分
    function mcenter_int()
    {
        $sql = "select a.val,b.p_id,b.type,b.type_val,b.note from set_sys a inner join set_sys_mx b on a.keyword=b.p_id where a.keyword='mcenter_int' order by type";
        $res = $GLOBALS['db']->getAll($sql);

        return array("list" => $res, "mcenter_int" => $res[0]['val']);
    }
    $mcenter_int = mcenter_int();
  
    $smarty->assign('mcenter_int_val', $mcenter_int['mcenter_int']);
    $smarty->assign('mcenter_int', $mcenter_int['list'][0]);
    //-----------------
    
      //获取是否进入个人中心 赠送抵用券
    function mcenter_dyq()
    {
        $sql = "select a.val,b.p_id,b.type,b.type_val,b.note from set_sys a inner join set_sys_mx b on a.keyword=b.p_id where a.keyword='mcenter_dyq' order by type";
        $res = $GLOBALS['db']->getAll($sql);

        return array("list" => $res, "mcenter_dyq" => $res[0]['val']);
    }
    $mcenter_dyq = mcenter_dyq();
  
    $smarty->assign('mcenter_dyq_val', $mcenter_dyq['mcenter_dyq']);
    $smarty->assign('mcenter_dyq', $mcenter_dyq['list'][0]);
    //-----------------
    
    
    
    
    
     //spjg
    //--留言
    function get_spjg()
    {
        $sql = "select * from set_sys where keyword='spjg'";
        $res = $GLOBALS['db']->getRow($sql);
        return $res;
    }
    $spjg = get_spjg();

    $smarty->assign('spjg', $spjg);
    //-----------------
    
    
    
    //--分成
    function get_fc()
    {
        $sql = "select * from wxpay_fc ";
        $res = $GLOBALS['db']->getAll($sql);
        return $res;
    }
    $fc = get_fc();

    $smarty->assign('fc', $fc);
    //-----------------
    

    $smarty->display('set_sys.tpl');
}


if ($_REQUEST['m'] == 'setsys') {


    //短信验证


    // ￥ = $_REQUEST['wxextel'];
    $wxextel = $_REQUEST['wxextel'];

    if ($wxextel == 'on') {
        $wxextel = 1;
    } else {
        $wxextel = 0;
    }

    //echo $wxextel;exit;
    if (isset($_REQUEST['wx_name'])) {
        $wx_name = $_REQUEST['wx_name'];
    }
    if (isset($_REQUEST['wx_password'])) {
        $wx_password = $_REQUEST['wx_password'];
    }
    function set_wxextel($val, $keyword, $wx_name, $wx_password)
    {
        $sql = "update set_sys set val='" . $val . "' where keyword='" . $keyword . "' ";

        $res = $GLOBALS['db']->query($sql);

        $sql1 = "update set_sys_mx set note='" . $wx_name . "' where type=1 and p_id='" .
            $keyword . "' ";
        $res1 = $GLOBALS['db']->query($sql1);
        $sql2 = "update set_sys_mx set note='" . $wx_password .
            "' where type=2 and p_id='" . $keyword . "' ";
        $sql2 = $GLOBALS['db']->query($sql2);

    }
    set_wxextel($wxextel, "wxextel", $wx_name, $wx_password);

    //积分兑换设置


    $ex_point_val = $_REQUEST['ex_point_val'];
    if ($ex_point_val == 'on') {
        $ex_point_val = 1;
    } else {
        $ex_point_val = 0;
    }


    if (isset($_REQUEST['point_type_val'])) {
        $point_type_val = $_REQUEST['point_type_val'];
    }
    function set_expoint($val, $keyword, $point_val)
    {
        $sql = "update set_sys set val='" . $val . "' where keyword='" . $keyword . "' ";
        $res = $GLOBALS['db']->query($sql);
        for ($i = 0; $i < count($point_val); $i++) {
            $sql1 = "update set_sys_mx set type_val='" . $point_val[$i] . "' where type='" . ($i +
                1) . "' and p_id='" . $keyword . "' ";
            $res1 = $GLOBALS['db']->query($sql1);
        }
    }
    set_expoint($ex_point_val, "ex_point", $point_type_val);

    //end积分兑换设置

    //实物兑换设置


    $ex_real_val = $_REQUEST['ex_real_val'];
    if ($ex_real_val == 'on') {
        $ex_real_val = 1;
    } else {
        $ex_real_val = 0;
    }


    if (isset($_REQUEST['real_type_val'])) {
        $real_type_val = $_REQUEST['real_type_val'];
    }
    if (isset($_REQUEST['real_note'])) {
        $real_note = $_REQUEST['real_note'];
    }
    function set_exreal($val, $keyword, $real_val, $real_note)
    {
        $sql = "update set_sys set val='" . $val . "' where keyword='" . $keyword . "' ";
        $res = $GLOBALS['db']->query($sql);
        for ($i = 0; $i < count($real_val); $i++) {
            $sql1 = "update set_sys_mx set type_val='" . $real_val[$i] . "',note='" . $real_note[$i] .
                "' where type='" . ($i + 1) . "' and p_id='" . $keyword . "' ";
            $res1 = $GLOBALS['db']->query($sql1);
        }
    }
    set_exreal($ex_real_val, "ex_real", $real_type_val, $real_note);

    //end实物兑换设置


    //设置签到积分
    $check_in = (int)$_REQUEST['check_in'];

    if ($check_in <= 0) {
        $check_in = 1;
    }
    //echo $check_in;
    $check_note = $_REQUEST['check_note'];
    //echo $check_note;

    function set_checkIn($val, $note)
    {
        $sql = "update set_sys set val='" . $val . "',note='" . $note .
            "' where keyword='check_in' ";
        $res = $GLOBALS['db']->query($sql);
    }
    set_checkIn($check_in, $check_note);
    //end设置签到积分

    //设定留言默认回复
    $lv_msg = $_REQUEST['lv_msg'];


    function set_lv_msg($lv_msg)
    {
        $sql = "update set_sys set bz='" . $lv_msg . "' where keyword='lv_msg' ";
        $res = $GLOBALS['db']->query($sql);
    }
    set_lv_msg($lv_msg);

    //end


    //设定8/32位
    $active_pwd = $_REQUEST['active_pwd'];
    if ($active_pwd == 'on') {
        $active_pwd = 1;
    } else {
        $active_pwd = 0;
    }

    function set_active_pwd($active_pwd)
    {
        $sql = "update set_sys set val='" . $active_pwd .
            "' where keyword='active_pwd' ";
        $res = $GLOBALS['db']->query($sql);
    }
    set_active_pwd($active_pwd);

    
    
    //首次登陆会员中心奖励积分
   
    $mcenter_int = $_REQUEST['mcenter_int'];

    if ($mcenter_int == 'on') {
        $mcenter_int = 1;
    } else {
        $mcenter_int = 0;
    }
    $mcenter_dyq = $_REQUEST['mcenter_dyq'];

    if ($mcenter_dyq == 'on') {
        $mcenter_dyq = 1;
    } else {
        $mcenter_dyq = 0;
    }

    //echo $wxextel;exit;
    if (isset($_REQUEST['mcenter_int_type_val'])) {
        $mcenter_int_type_val = $_REQUEST['mcenter_int_type_val'];
    }
    if (isset($_REQUEST['mcenter_dyq_note'])) {
        $mcenter_dyq_note = $_REQUEST['mcenter_dyq_note'];
    }
    function set_mcenter_int($mcenter_int,$keyword1, $mcenter_dyq,$keyword2, $mcenter_int_type_val, $mcenter_dyq_note)
    {
        $sql = "update set_sys set val='" . $mcenter_int . "' where keyword='" . $keyword1 . "' ";

        $res = $GLOBALS['db']->query($sql);
        
        $sql3 = "update set_sys set val='" . $mcenter_dyq . "' where keyword='" . $keyword2 . "' ";

        $res3 = $GLOBALS['db']->query($sql3);

        $sql1 = "update set_sys_mx set type_val='" . $mcenter_int_type_val . "' where  p_id='" .
            $keyword1 . "' ";
        $res1 = $GLOBALS['db']->query($sql1);
        
        $sql2 = "update set_sys_mx set note='" . $mcenter_dyq_note .
            "' where  p_id='" . $keyword2 . "' ";
        $sql2 = $GLOBALS['db']->query($sql2);

    }
    set_mcenter_int($mcenter_int, "mcenter_int",$mcenter_dyq,"mcenter_dyq", $mcenter_int_type_val, $mcenter_dyq_note);
    
    
    
    
    
    
    //设定商品价格
    $spjg =(double) $_REQUEST['spjg'];

   
    function set_spjg($spjg)
    {
        $sql = "update set_sys set note='" . $spjg . "' where keyword='spjg' ";
        $res = $GLOBALS['db']->query($sql);
    }
    set_spjg($spjg);
    
    
      //分成
    $fc =$_REQUEST['fc'];
    
   // print_r($fc);exit;
   
    function set_fc($fc)
    {
         $sql = "update wxpay_fc set fenchengjine='" . $fc[0] . "' where jibie='1' ";
        $res = $GLOBALS['db']->query($sql);
        
          $sql = "update wxpay_fc set fenchengjine='" . $fc[1] . "' where jibie='2' ";
        $res = $GLOBALS['db']->query($sql);
          $sql = "update wxpay_fc set fenchengjine='" . $fc[2] . "' where jibie='3' ";
        $res = $GLOBALS['db']->query($sql);
        
    }
    set_fc($fc);
    
    
    
    //exit;
    header("Location: set_sys.php");
    // print_r($list);


}



?>
