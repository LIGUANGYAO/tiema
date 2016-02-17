
<?php

define('IN_ECS', true);

define('NOLOGIN', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/login.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {

    if (isset($_REQUEST['us_name']) && isset($_REQUEST['psword'])) {
        $us_name = trim($_REQUEST['us_name']);
        //set_cookie("n1", $us_name, $cookie_time);
        $psword = trim($_REQUEST['psword']);


        //20140610修改登陆cookie
        $us_name2 = base64_encode($us_name);
        $us_name2 = serialize($us_name2);

        setcookie("Login_wx_name", $us_name2, time() + $cookie_time);


        //$_SESSION['longin']=$us_name;
        // print_r($_SESSION['longin']);exit;
        //$saaa="select user_id from admin_user where user_name='".$us_name."' limit 1";
        $user_id = $GLOBALS['db']->getOne("select count(user_id) as sl from admin_user where user_name='" .
            $us_name . "' and tzsy!=1 limit 1");
        //echo 1;exit;
        //echo $user_id;exit;
        if ($user_id >= 1) {

            $psword = md5($psword."^&*(ll");
            
            // $aaa=" select user_id from admin_user where user_name='".$us_name."' and password='".$psword."' limit 1";
            $is_allow = $GLOBALS['db']->getOne(" select count(user_id) as sl from admin_user where user_name='" .
                $us_name . "' and password='" . $psword . "' limit 1");
            //print_r($is_allow);
            if ($is_allow >= 1) {
                $timesa = date('Y-m-d H:i:s', time());
                $cookie_name = md5($us_name . "sdmaldieiow12!@#$" . md5("~+!MMD@*&#&(!!)#@#*&NCNSP#@") .
                    rand(1, 999999) . md5($timesa));
                $session_un = md5(md5($cookie_name));
                //$_COOKIE['user_name']=$session_un;

                setcookie("user_name", $session_un, time() + $cookie_time);
                $un = $GLOBALS['db']->getOne(" select sesskey from sessions where sesskey='" . $session_un .
                    "' limit 1");
                if ($un) {

                } else {
                    $sql = "insert into sessions(sesskey) values ('" . $session_un . "')";
                    $GLOBALS['db']->query($sql);
                }

       
                //echo get_real_ip();exit;
                //记录登陆日志
                action_log("dl", "登陆", $us_name, get_real_ip(), $us_name);
                echo "<script>window.location.href='privilege.html';</script>";


            } else {

                header("location: login_false.html");
                //echo "<script>alert('用户名或者密码错误,请重新登陆！');window.location.href='index.php';</script>";
            }

        } else {
            //echo "失败";exit;
            header("location: login_false.html");
            //echo "<script>alert('用户名或者密码错误!');window.location.href='index.php';</script>";
        }
    } else {
        header("location: login_false.html");
        // echo "<script>alert('您没有访问权限，请先登录!');window.location.href='index.php';</script>";
    }
    // $action_list=new login_on();
    // $action=$action_list->get_action();
    //print_r($aaa);exit;
    //get_action();
    //admin_u();
    //$sl='1';
    $smarty->assign('certi', 1);
    //$smarty->assign('title', "后台管理");
    //$smarty->display('main.htm');
}


if ($_REQUEST['act'] == 'log_out') {
    $cookie2 = stripslashes($_COOKIE['Login_wx_name']);

    $tmpUnSerialize2 = unserialize($cookie2);
    $tmpUnSerialize2 = base64_decode($tmpUnSerialize2);
    action_log("zhuxiao", "注销", $tmpUnSerialize2, get_real_ip());
    log_out();


    echo "<script>window.location.href='index.html';</script>";
}

?>
