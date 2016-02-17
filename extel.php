<?php
define('IN_ECS', true);


define('CUSTOMER', 'CASLON');
require (dirname(__file__) . '/sub/is_weixin.php');
require (dirname(__file__) . '/includes/init2.php');
//require (dirname(__file__) . '/sub/sub_extel.php');

//echo $openid;

//echo "<script>window.location.href='openshop2.php';</script>";

if (empty($_REQUEST['m'])) {
    $_REQUEST['m'] = 'default';
} else {
    $_REQUEST['m'] = trim($_REQUEST['m']);
}

if(isset($_REQUEST['openid'])){
    $openid=$_REQUEST['openid'];
    //print_r($openid);
}
else{
    //print_r(1111111);
}

//$openid='oGehCt7YZrpXFzxwZs-z-AADN_Ak';
if ($_REQUEST['m'] == 'default') {




    if (empty($openid)) {
        echo "请从公众号登陆";
    }else {
        
        
        $sel = "select wx_tel from users where openid='" . $openid . "'";
        $sel = $GLOBALS['db']->getRow($sel);
        
        if (empty($sel['wx_tel'])) {
        $smarty->assign('openid', $openid);
        $smarty->display('exTel/index.htm');
        }
        else
        {
            echo "<script>window.location.href='member.php?openid=".$openid."';</script>";
        }
    }


    //  ///修改1,查询语句
    //    //sort_no,tzsy 要记得添加
    //    $sql = "select id,article_sn,article_name,sort_no,tzsy,last_update,article_note_1,title,type,article_lx,article_msg from article";
    //
    //
    //    $article_list = get_article_list($Num, "article", $sql);
    //
    //    //print_r($article_list);
    //    $smarty->assign('article_list', $article_list['items']);
    //    $smarty->assign('fall', 1);
    //    //$smarty->assign('title', $aaa);
    //    $smarty->assign('p_Array', $article_list['page']);


}


if ($_REQUEST['m'] == 'telonly') {


    if (isset($_REQUEST['tel'])) {
        $tel = $_REQUEST['tel'];
        $sql = "select openid from users where wx_tel='" . $tel . "'";
        $res = $GLOBALS['db']->getRow($sql);
        if (empty($res)) {
            echo "1";
        } else {
            echo "2";
        }
    } else {
        echo "0";
    }

}

if ($_REQUEST['m'] == 'exOk') {

    if (isset($_REQUEST['mobile_phone']) && isset($_REQUEST['openid'])) {


        $tel = $_REQUEST['mobile_phone'];

        $op = $_REQUEST['openid'];
       
       
        $sel = "select wx_tel from users where openid='" . $op . "'";
        $sel = $GLOBALS['db']->getRow($sel);
        
        if (empty($sel['wx_tel'])) {
            $ran=rand(100000,999999);
            $sql = "update users set wx_tel='" . $tel . "',wx_pwd='".$ran."' where openid='" . $op . "'";
            ;
            $res = $GLOBALS['db']->query($sql);


            if (CUSTOMER == 'CASLON' && U_DB2 == 1) {
                function os_user($t,$r,$open='')
                {
                    $n_t = date('Y-m-d H:i:s', time());
                    $sql="select user_id from user_users where user_id='".$t."'";
                    $sql = $GLOBALS['db2']->getRow($sql);
                    if(empty($sql['user_id']))
                    {
                               //user_id(用户名),area_id(区域id),email(用户名),user_name(用户名),password,sex--0,user_money(0),frozen_money(0),pay_points(0),rank_points(0),reg_time(插入时间),visit_count(0),is_special_rank(0),alias(用户名)
                               
                               //将用户直接插入到客户的openshop记录里面
                    $sql = "insert into user_users(user_id,area_id,email,user_name,password,sex,user_money,frozen_money,pay_points,rank_points,reg_time,visit_count,alias,promotion_id) values ('".$t."',32,'".$t."','".$t."','".md5($r)."',0,0,0,0,0,'".$n_t."',0,'".$t."',6)";
                    $res = $GLOBALS['db2']->query($sql);
                                //将用户曾经的中奖记录插入到openshop里面
                                
                                $sncode_list="SELECT a.*,b.users_name,b.wx_tel FROM `wx_sncode` a inner join users b on a.openid=b.openid where a.openid='".$open."' and a.sn_issend!=1";
                                $sncode_list = $GLOBALS['db']->getAll($sncode_list);
                                
                                //print_r($sncode_list);exit;
                                for($i=0;$i<count($sncode_list);$i++)
                                {
                                    //一二三等奖设置奖励金额
                                        if($sncode_list[$i]['prizetype']==1)
                                    {
                                        $amount=100;
                                    }
                                    elseif($sncode_list[$i]['prizetype']==2)
                                    {
                                        $amount=50;
                                    }
                                     elseif($sncode_list[$i]['prizetype']==3)
                                    {
                                        $amount=20;
                                    }
                                    $os_sql="insert into shop_vouchers(pr_id,card_sn,pwd,start_time,end_time,provide_time,user_id,cv_amount,lowest_amount,is_active,sendTo) values ('10','".$sncode_list[$i]['sncode']."','".$sncode_list[$i]['sncode']."','".$sncode_list[$i]['add_time']."','".$sncode_list[$i]['limit_time']."','".$sncode_list[$i]['add_time']."','".$sncode_list[$i]['wx_tel']."','".$amount."','".$amount."','1','".$sncode_list[$i]['wx_tel']."') ";
                                    $os_sql = $GLOBALS['db2']->query($os_sql);
                                    
                                    
                                    //判断是否已经传输到os
                                    $up="update wx_sncode set sn_issend =1 where sncode='".$sncode_list[$i]['sncode']."'";
                                    $up = $GLOBALS['db']->query($up);
                                    
                                }
                                
                             // echo "<script>window.location.href='member.php?openid=".$openid.";</script>";   
                                //--------------------------------------
                               
                        return "1";
                    }else
                    {
                        return "2";
                    }
             
                }
                $ss=os_user($tel,$ran,$op);
               //echo $ss; 
              header("location: member.php?openid=".$op);
                //echo "<script>window.location.href='member.php?openid=".$op.";</script>";   
            }
            
             header("location: member.php?openid=".$op);
         }
        else
        {
            echo "wx手机号已经存在,执行失败";
        }


    }


}


if ($_REQUEST['m'] == 'exOk') {
    echo "<script>window.location.href='member.php?openid=".$op.";</script>";   
}
 

?>