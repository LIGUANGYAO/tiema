<?php

$sncode_list = "SELECT a.*,b.users_name,b.wx_tel FROM `wx_sncode` a inner join users b on a.openid=b.openid where a.openid='" .
    $openid . "' and a.sn_issend!=1";
$sncode_list = $GLOBALS['db']->getAll($sncode_list);

if (empty($sncode_list)) {

} else {
    if (CUSTOMER == 'CASLON' && U_DB2 == 1) {
        //print_r($sncode_list);exit;
        for ($i = 0; $i < count($sncode_list); $i++) {
            //一二三等奖设置奖励金额
            if ($sncode_list[$i]['prizetype'] == 1) {
                $amount = 100;
            } elseif ($sncode_list[$i]['prizetype'] == 2) {
                $amount = 50;
            } elseif ($sncode_list[$i]['prizetype'] == 3) {
                $amount = 20;
            }
            
            $sel="select card_sn from shop_vouchers where card_sn='".$sncode_list[$i]['sncode']."'";
            $sel = $GLOBALS['db2']->getRow($sel);
            if(empty($sel['card_sn']))
            {
                $os_sql = "insert into shop_vouchers (pr_id,card_sn,pwd,start_time,end_time,provide_time,user_id,cv_amount,lowest_amount,is_active,sendTo) values ('10','" .
                $sncode_list[$i]['sncode'] . "','" . $sncode_list[$i]['sncode'] .
                "','".$sncode_list[$i]['add_time']."','".$sncode_list[$i]['limit_time']."','" . $sncode_list[$i]['add_time'] .
                "','" . $sncode_list[$i]['wx_tel'] . "','" . $amount . "','" . $amount .
                "','1','" . $sncode_list[$i]['wx_tel'] . "') ";
                $os_sql = $GLOBALS['db2']->query($os_sql);
            }
                
            
            
            


            //判断是否已经传输到os
            $up = "update wx_sncode set sn_issend =1 where sncode='" . $sncode_list[$i]['sncode'] .
                "'";
            $up = $GLOBALS['db']->query($up);

        }
    }
}

?>