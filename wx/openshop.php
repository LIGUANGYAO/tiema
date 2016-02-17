<?php
define('IN_ECS', true);

define('CUSTOMER', 'CASLON');
require (dirname(__file__) . '/includes/init.php');

$Login_act = stripslashes($_COOKIE['OsLogin']);
$Login_act = unserialize($Login_act);
//print_r($Login_act);
$is_allow = $GLOBALS['db']->getOne(" select sesskey from sessions where sesskey='" .
        $Login_act['name'] . "' limit 1 ;");
       //echo $is_allow;exit;
    if ($is_allow) {
        //echo 1;
        echo "<script>window.location.href='openshop2.php';</script>";
    }
    else
    {   
        //echo 2;
        //echo "<script>window.location.href='index.php';</script>";
    }

if (empty($_REQUEST['m'])) {
    $_REQUEST['m'] = 'default';
} else {
    $_REQUEST['m'] = trim($_REQUEST['m']);
}

if ($_REQUEST['m'] == 'default') {

//
//    $sql = " select slide_sn from slide where tzsy=0 order by -sort_no ";
//    //$sql = "select p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update  from slide_imgs  where  p_id ='" . $obj . "'";
//    $res = $GLOBALS['db']->getAll($sql);
//    //print_r($res[0]['slide_sn']);
//    $img_cod = $res[0]['slide_sn'];
//    $slide_imgs22 = get_slide_imgs_list("slide_imgs",
//        " p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",
//        $img_cod);
//    //print_r($slide_imgs22);exit;
//    //获取分模块信息
//    $sql2 = " select slide2_sn,slide2_name,slide2_note_1,action_url from slide2 where tzsy=0 order by -sort_no,id ";
//    //$sql = "select p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update  from slide_imgs  where  p_id ='" . $obj . "'";
//    $slide2 = $GLOBALS['db']->getAll($sql2);
//    //print_r($slide_imgs22);exit;
//    $smarty->assign('slide2', $slide2);
//    $smarty->assign('title', "微官网");
//    $smarty->assign('slide_imgs22', $slide_imgs22['items']);
    $smarty->display('excheck/index.html');
}



if ($_REQUEST['m'] == 'login') {
        if(isset($_REQUEST['password']) && isset($_REQUEST['user_name']))
        {
            $password=$_REQUEST['password'];
            $user_name=$_REQUEST['user_name'];
             if (CUSTOMER == 'CASLON' && U_DB2 == 1) {

                    function login($n,$p)
                    {
                        $sql32 = "select user_id from user_users where user_id='".$n."' and password='".$p."' and promotion_id!='6'  ";
                        $sql3 = $GLOBALS['db2']->getRow($sql32);
                        if(empty($sql3['user_id']))
                        {
                            echo "用户名/密码错误<hr><a href='openshop.php'>返回</a>";
                        }
                        else
                        {
                            $log_info=md5(md5("$%^&*#*&^$^&*$(KHFHKEEEKDNddio".$n.rand(1, 999999).$p."*&U#UJJF")."4444dhU");
                            $sql = "insert into sessions(sesskey) values ('" . $log_info . "')";
                            $GLOBALS['db']->query($sql);
                            $login=array("name"=>$log_info,"user_id"=>$n);
                            $tmpSerialize = serialize($login);
                            setcookie("OsLogin", $tmpSerialize, time() + 76400);
                            echo "<script>window.location.href='openshop2.php';</script>";
                        }
                    }
                    
                    login($user_name,$password);
             }
            
            
        }
        
        
    
}
if ($_REQUEST['m'] == 'privilege') {
    
}



?>