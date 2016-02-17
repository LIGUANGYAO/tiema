<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init2.php');


if (empty($_REQUEST['m'])) {
    $_REQUEST['m'] = 'default';
} else {
    $_REQUEST['m'] = trim($_REQUEST['m']);
}


if ($_REQUEST['m'] == 'default') {

    function int_password($length = 8)
    {
        // 密码字符集，可任意添加你需要的字符
        $chars = '123456789';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            // 这里提供两种字符获取方式
            // 第一种是使用 substr 截取$chars中的任意一位字符；
            // 第二种是取字符数组 $chars 的任意元素
            // $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        $t = date('Y-m-d H:i:s', time());
        return $password;
    }

    if (isset($_REQUEST['hd_sn'])) {
        $time = date('Y-m-d', time());
        $time2 = date('Y-m-d H:i:s', time());
        $hd_sn = $_REQUEST['hd_sn'];
        $md_list = "SELECT a.*,b.openid,c.wx_tel FROM `wx_zan_md` a left  join joinin b on a.tel=b.mu_tel left join users c on b.openid=c.openid
 where a.hd_sn='" . $hd_sn . "' and a.send_sn_code=0 ";
        $md_list = $GLOBALS['db']->getAll($md_list);

        for ($i = 0; $i < count($md_list); $i++) {
            for ($j = 0; $j < $md_list[$i]['sl']; $j++) {


                $lo_sn = int_password();
                //判断是否存在
                $sele = "select sncode from wx_sncode where  sncode='" . $lo_sn . "'";
                $sele = $GLOBALS['db']->getRow($sele);
                if (!empty($sele)) {
                    $lo_sn = int_password();
                }

                if ($md_list[$i]['je'] == "100") {
                    $ty = "11";
                } elseif ($md_list[$i]['je'] == "30") {
                    $ty = "12";
                }

                $sql3 = "insert into wx_sncode(openid,sncode,prizetype,add_time,limit_time,hd_sn,lo_date) values ('" .
                    $md_list[$i]['openid'] . "','" . $lo_sn . "','" . $ty . "','" . $time2 .
                    "','2014-12-08 00:00:00','" . $md_list[$i]['hd_sn'] . "','" . $time . "')";
                $sql3 = $GLOBALS['db']->query($sql3);

            }
            $up = "update wx_zan_md set send_sn_code=1 where name='" . $md_list[$i]['name'] .
                "' and tel='" . $md_list[$i]['tel'] . "'";

            $up = $GLOBALS['db']->query($up);


            //插入openshop数据库


            $sncode_list = "SELECT a.*,b.mu_tel FROM `wx_sncode` a left  join joinin b on a.openid=b.openid left join users c on a.openid=c.openid where a.openid='" .
                $md_list[$i]['openid'] . "' and a.sn_issend!=1 and a.hd_sn='" . $hd_sn . "'";


            $sncode_list = $GLOBALS['db']->getAll($sncode_list);

            //print_r($sncode_list);exit;
            for ($k = 0; $k < count($sncode_list); $k++) {
                //一二三等奖设置奖励金额
                if ($sncode_list[$k]['prizetype'] == 11) {
                    $amount = 100;
                } elseif ($sncode_list[$k]['prizetype'] == 12) {
                    $amount = 30;
                }

                $os_sql = "insert into shop_vouchers (pr_id,card_sn,pwd,start_time,end_time,provide_time,user_id,cv_amount,lowest_amount,is_active,sendTo) values ('10','" .
                    $sncode_list[$k]['sncode'] . "','" . $sncode_list[$k]['sncode'] . "','" . $sncode_list[$k]['add_time'] .
                    "','" . $sncode_list[$k]['limit_time'] . "','" . $sncode_list[$k]['add_time'] .
                    "','" . $sncode_list[$k]['mu_tel'] . "','" . $amount . "','" . $amount .
                    "','1','" . $sncode_list[$k]['mu_tel'] . "') ";
                $os_sql = $GLOBALS['db2']->query($os_sql);


                //判断是否已经传输到os
                $up = "update wx_sncode set sn_issend =1 where sncode='" . $sncode_list[$k]['sncode'] .
                    "' and hd_sn='" . $hd_sn . "'";
                $up = $GLOBALS['db']->query($up);

            }


        }


        //插入openshop


       // print_r($md_list);
    }


}


if ($_REQUEST['m'] == 'type2') {
     if (isset($_REQUEST['hd_sn'])) {
         $up = "select count(*) from wx_sncode where limit_time='2014-12-08 00:00:00' and hd_sn='".$_REQUEST['hd_sn']."' ";
                $up = $GLOBALS['db']->getRow($up);
                
                
                print_r($up)."<hr>";
         $up2 = "select count(*) from shop_vouchers where end_time='2014-12-08 00:00:00'";
                $up2 = $GLOBALS['db2']->getRow($up2);
                print_r($up2)."<hr>";
                
                $up3 = "select sum(cv_amount) from shop_vouchers where end_time='2014-12-08 00:00:00'";
                $up3 = $GLOBALS['db2']->getRow($up3);
                print_r($up3)."<hr>";
                
     }
}
?>