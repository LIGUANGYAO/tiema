<?php


//记录sql日志
//$this->otxt('gettokeninfo',$sql);

//需要返回这样格式的
//$list = array("item" => $list, "sum" => count($list),"time"=>date('Y-m-d H:i:s', time()));
$us_name = $this->users_sn;
$psword = $this->password;


$user_id = $GLOBALS['db']->getOne("select count(id) as sl from menber where menber_sn='" .
    $us_name . "' and tzsy!=1 limit 1");
//echo 1;exit;
//echo $user_id;exit;
//echo md5('730615'."^&*(ll");

if ($user_id) {


    $is_allow = $GLOBALS['db']->getOne(" select count(id) as sl from menber where menber_sn='" .
        $us_name . "' and password_md5='" . $psword . "' limit 1");
    //print_r($is_allow);exit;
    if ($is_allow >= 1) {
        $timesa = date('Y-m-d H:i:s', time());
        $cookie_name = md5($us_name . "sdmaldieiow12!@#$" . md5("~+!MMD@*&#&(!!)#@#*&NCNSP#@") .
            rand(1, 999999) . md5($timesa));
        $session_un = md5(md5($cookie_name));
        //$_COOKIE['user_name']=$session_un;

        $sql = "update menber set token='" . $session_un . "',temporary_time='" . $timesa .
            "' where menber_sn='" . $us_name . "' ";

        $res = $GLOBALS['db']->query($sql);
        
        $ls=array('users_sn' => $us_name,'temporary_key'=>$session_un);

        $list = array(
            "item" => $ls,
            "sum" => count($ls),
            "time" => date('Y-m-d H:i:s', time()),
            "status" => "1",
            "error_msg" => "ok");

    } else {
        $session_un = '';
        $ls=array('users_sn' => $us_name,'temporary_key'=>$session_un);
        $list = array(
            "item" => $ls,
            "sum" => count($ls),
            "time" => date('Y-m-d H:i:s', time()),
            "status" => "2",
            "error_msg" => "user_name or password error!");

    }


} else {
    $session_un = '';
    $ls=array('users_sn' => $us_name,'temporary_key'=>$session_un);
    $list = array(
        "item" => $ls,
        "sum" => count($ls),
        "time" => date('Y-m-d H:i:s', time()),
        "status" => "3",
        "error_msg" => "user_sn  error!");
}

?>