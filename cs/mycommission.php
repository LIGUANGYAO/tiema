<?php


define('IN_ECS', true);


require (dirname(__file__) . '/includes/init2.php');
require (dirname(__file__) . '/sub/sub_openid.php');


if (empty($_REQUEST['g'])) {
    $_REQUEST['g'] = 'default';
} else {
    $_REQUEST['g'] = trim($_REQUEST['g']);
}


if ($_REQUEST['g'] == 'default') {


    if (!empty($openId)) {

        //select *,is_send as is_withdraw , (fenchengjine-send_fenchengjine) as unsettle1,concat(from_unixtime(add_time)) as create_time,fenchengjine as reward_money,jibie  from  wxpay_fclog
        //已结算金额
        $yjs = "select IFNULL(sum(fenchengjine),0) as je  from  wxpay_fclog  where  p_openid='" .
            $openId . "' and is_send=1 order by id desc ";
        $yjs = $GLOBALS['db']->getRow($yjs);


         //未结算金额
        $wjs = "select IFNULL(sum(fenchengjine),0) as je  from  wxpay_fclog  where  p_openid='" .
            $openId . "' and is_send=0 order by id desc ";
        $zjs = $GLOBALS['db']->getRow($wjs);

        //总结算金额
        /*
        $zjs = "select IFNULL(sum(fenchengjine),0) as je  from  wxpay_fclog  where  p_openid='" .
            $openId . "'  order by id desc ";
        $zjs = $GLOBALS['db']->getRow($zjs);*/

        //总收入数量
        $zjssl = "select IFNULL(count(*),0)  as sl  from  wxpay_fclog  where  p_openid='" .
            $openId . "'  order by id desc ";

        $zjssl = $GLOBALS['db']->getRow($zjssl);

        //未结算数量
        $wjssl = "select IFNULL(count(*),0) as sl  from  wxpay_fclog  where  p_openid='" .
            $openId . "' and is_send=0 order by id desc ";

        $wjssl = $GLOBALS['db']->getRow($wjssl);


    }

    $rarr = array("yjs" => $yjs['je'], "zjs" =>$zjs['je'], "zjssl" => $zjssl['sl'], "wjssl" => $wjssl['sl']);

    $smarty->assign('rarr', $rarr);
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $goods_list['page']);
    $smarty->display('cs/mycommission.html');

}


if ($_REQUEST['g'] == 'commissionList') {

  


    if (!empty($openId)) {
        //'cpage':page,'pagesize'

        if (isset($_REQUEST['cpage'])) {
            $cpage = $_REQUEST['cpage'];
            $cpage = ($cpage - 1);
        }
        if (isset($_REQUEST['pagesize'])) {
            $pagesize = $_REQUEST['pagesize'];
        }
        $limit = limit_array($cpage, $pagesize);

        $rearr = array();


        $getf = "select *,is_send as is_withdraw , (fenchengjine-send_fenchengjine) as unsettle1,from_unixtime(add_time) as create_time,fenchengjine as reward_money, case jibie when 3 then 1 when 1 then 3 when 2 then 2 end as jibie   from  wxpay_fclog  where  p_openid='" .
            $openId . "' order by id desc " . $limit;

        $getf = $GLOBALS['db']->getAll($getf);

        $rearr['results'] = $getf;


        print_r(json_encode($rearr));


    }

}
