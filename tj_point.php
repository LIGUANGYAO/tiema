<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_tj_point.php');


if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
    
    if (isset($_REQUEST['t1'])) {
        $t1 = $_REQUEST['t1'];

    }
    if (isset($_REQUEST['t2'])) {
        $t2 = $_REQUEST['t2'];
    }
    
     $is_att= trim($_REQUEST['is_att']);
    if($is_att=='')
    {
        $is_att=2;
    }
    
    
      //添加时间间隔
    $time = date('Y-m-d', time());
    $data = strtotime($time); //减去三天的时间
    $data = $data - (60 * 60 * 24 * 30); //打印出三天的时间
    $th_time = date("Y-m-d", $data);
    if (isset($_REQUEST['t1'])) {
        $th_time = $_REQUEST['t1'];
    }
    if (isset($_REQUEST['t2'])) {
        $time = $_REQUEST['t2'];
    }

    
   
    
    //用户签到积分
    function check_inlog($openid,$t1,$t2)
    {
        $sql = "select * from users_check_log where openid='" . $openid .
            "' and add_time between '".$t1."' and '".$t2."'  order by add_time desc";
        $res = $GLOBALS['db']->getAll($sql);
        //echo $sql;
        $sum = "select sum(rank_points) as sl,last_update_2 from users_check_log where openid='" . $openid .
            "' and add_time between '".$t1."' and '".$t2."' order by add_time desc";
        $sum = $GLOBALS['db']->getRow($sum);
       // return array("list" => $res, "sum" => $sum['sl']);
       return array( "sum" => $sum['sl'],"last_update_2" => $sum['last_update_2'],"count" => count($res));
    }

    //用户将奖券兑换成积分
    function expoint_inlog($openid,$t1,$t2)
    {
        $sql = "select * from users_expoint_log where openid='" . $openid .
            "' and add_time between '".$t1."' and '".$t2."' order by add_time desc";
        $res = $GLOBALS['db']->getAll($sql);

        $sum = "select sum(rank_points) as sl from users_expoint_log where openid='" . $openid .
            "' and add_time between '".$t1."' and '".$t2."' order by add_time desc";
        $sum = $GLOBALS['db']->getRow($sum);
        return array("count" => count($res), "sum" => $sum['sl']);
    }
    //兑换实物券扣除积分
    function sncode_real($openid,$t1,$t2)
    {
        $sql = "select add_time,type_val,note from wx_sncode_real where openid='" . $openid .
            "' and add_time between '".$t1."' and '".$t2."' order by add_time desc";
        $res = $GLOBALS['db']->getAll($sql);

        $sum = "select sum(type_val) as sl from wx_sncode_real where openid='" . $openid .
            "' and add_time between '".$t1."' and '".$t2."' order by add_time desc";
        $sum = $GLOBALS['db']->getRow($sum);
        return array("count" => count($res), "sum" => $sum['sl']);
    }
    
    $sql="select a.openid,d.nick_name,d.users_sn,d.is_att from users_check_log a left join users_expoint_log b on a.openid=b.openid left join wx_sncode_real c on a.openid=b.openid inner join users d on a.openid=d.openid ";
    
    
    $tj_point_list = get_tj_point_list($Num, "weixiaodian", $sql);
    
    
    for($j=0;$j<count($tj_point_list['items']);$j++)
    {
        $ch= check_inlog($tj_point_list['items'][$j]['openid'],$th_time,$time);
        if($ch['sum']=='')
        {
            $ch['sum']=0;
        }
        $tj_point_list['items'][$j]['check_inlog_sum']  =$ch['sum'];
        $tj_point_list['items'][$j]['check_last_update_2']  =$ch['last_update_2'];
        $tj_point_list['items'][$j]['check_count']  =$ch['count'];
        //拼装积分兑换
        $exp= expoint_inlog($tj_point_list['items'][$j]['openid'],$th_time,$time);
        if($exp['sum']=='')
        {
            $exp['sum']=0;
        }
        $tj_point_list['items'][$j]['exp_sum']  =$exp['sum'];
        $tj_point_list['items'][$j]['exp_count']  =$exp['count'];
        
        //扣除兑换积分
        $real= sncode_real($tj_point_list['items'][$j]['openid'],$th_time,$time);
        if($real['sum']=='')
        {
            $real['sum']=0;
        }
        $tj_point_list['items'][$j]['real_sum']  =$real['sum'];
        $tj_point_list['items'][$j]['real_count']  =$real['count'];
        
        $tj_point_list['items'][$j]['point_sum']=$tj_point_list['items'][$j]['check_inlog_sum'] + $tj_point_list['items'][$j]['exp_sum'] - $tj_point_list['items'][$j]['real_sum'];
    }
   // print_r($tj_point_list);


   
    
    
    


    $smarty->assign('th_time', $th_time);
    $smarty->assign('now_time', $time);
      $smarty->assign('is_att',$is_att);
    $smarty->assign('tj_point_list', $tj_point_list['items']);
    $smarty->assign('fall', 1);
    $smarty->assign('p_Array', $tj_point_list['page']);
    $smarty->display('tj_point.tpl');
}

?>