<?php
define('IN_ECS', true);
require_once ('includes/init2.php');
require_once ('sub/sub_rest.php');

//写一个类，让他们写入一条语句的时候直接执行，判断语法是否错误，错误返回语法错误。
//我现在要写一个类，让他们在输入接口的时候选择表，选择字段，修改字段。

//数组转 json 类
//$url_this = "http://".$_SERVER ['HTTP_HOST'].dirname(dirname($_SERVER['PHP_SELF']));
//echo $url_this;


define('API_KEY', 'test');
define('SECRET', '8888');
define('URL', 'http://localhost:8081/all_test/shop/admin/api/api_ceshi.php');


$url_this = "http://" . $_SERVER['HTTP_HOST'] . "/" . dirname(dirname($_SERVER['PHP_SELF']));

$method = '';
$format = '';
$sql = '';
if (isset($_REQUEST['method'])) {
    if ($_REQUEST['method'] == "get.temporary.key") {
        $method = "get.temporary.key";
    }
    ;


}

if (isset($_REQUEST['format'])) {
    if ($_REQUEST['format'] == "json") {
        $format = "json";
    } else {
        $format = "array";
    }
    ;

}
if (isset($_REQUEST['sql'])) {

    $sql = $_REQUEST['sql'];

} else {
    $sql = "0";
}

if (isset($_REQUEST['page'])) {
    $n_page = intval($_REQUEST['page']);

}
if (isset($_REQUEST['num'])) {
    $p_num = intval($_REQUEST['num']);

}


// echo $user_allow;

//print_r($user_array);exit;

//$timestamp=date('Y-m-d H:i:s',time());;
//echo $timestamp;
if (isset($_REQUEST['api_key']) && isset($_REQUEST['secret'])) {
    //$app=new API_key_value();
    //$app->app_key=API_KEY;
    //$app->app_secret=$_REQUEST['secret'];
    //$secret=$app->get_secrt();
    $sql_key = " select api_key from api_user  where api_key='" . $_REQUEST['api_key'] .
        "' and secret='" . $_REQUEST['secret'] . "';";
    $user_id = $GLOBALS['db']->getRow($sql_key);
    //print_r( $sql_key);
    //echo 1;
    if ($user_id) {
        if ($method == "get.temporary.key") {

            if (isset($_REQUEST['u_met'])) {
                $update_method = trim($_REQUEST['u_met']);
            }

            if (isset($_REQUEST['users_sn']) && isset($_REQUEST['password'])) {
                if (empty($_REQUEST['users_sn']) or empty($_REQUEST['password'])) {
                    $allow = 0;

                }elseif(empty($_REQUEST['users_sn']))
                {
                    $allow=2;
                }
                 else {
                    $allow = 1;
                    $users_sn = trim($_REQUEST['users_sn']);
                    $password = trim($_REQUEST['password']);
                    $password=md5(md5($password."tiema.com"));
                }

            }
            
            if ($allow != 0) {
                $user_id = '';
                $sql_key = " select users_sn,password,temporary_time,temporary_key from users  where users_sn='" .
                    $users_sn . "' and password='" . $password . "';";
                    //print_r($sql_key);exit;
                $user_id = $GLOBALS['db']->getRow($sql_key);
                if (!empty($user_id)) {
                    $time_diff=get_time_diff($user_id['temporary_time']);
                    //print_r($time_diff['hour']);
                    if($time_diff['hour']>=3)
                    {
                        
                        $user='';
                        require_once ('sub/sub_rest_login.php');
                        $ex = new restlogin;
                        $user['item']['users_sn']=$users_sn;
                        $user['item']['temporary_key']=$ex->exes($users_sn,$password);
                        $json_users = new arraytojson();
                        $err = $json_users->JSON($user);

                         print_r($err); //输出错误
                         return $err;
                         //http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=insert.user.id&is_allow=1&users_sn=213131aaaaaaaaa&password=0987654321&users_name=33322233333&nick_name=esscha
                    }
                    else
                    {
                        
                        $user='';
                        require_once ('sub/sub_rest_login.php');
                        $ex = new restlogin;
                        $user['item']['users_sn']=$users_sn;
                        $user['item']['temporary_key']=$ex->exes($users_sn,$password);
                        $json_users = new arraytojson();
                        $err = $json_users->JSON($user);

                         print_r($err); //输出错误
                         return $err;
                     //   $user='';
//                        $user['item']['users_sn']=$users_sn;
//                        $user['item']['temporary_key']=$user_id['temporary_key'];
//                        $json_users = new arraytojson();
//                        $err = $json_users->JSON($user);
//
//                         print_r($err); //输出错误
//                         return $err;
                    }
                 

                } else {
                    $err = '';
                    $err['err'] = 2;
                    $err['msg'] = "users_sn or password is error";
                    $json_users = new arraytojson();
                    $err = $json_users->JSON($err);

                    print_r($err); //输出错误
                    return $err;
                }
                
            }elseif($allow==2)
            {
                $err = '';
                $err['err'] = 1;
                $err['msg'] = "user_sn  is null";
                $json_users = new arraytojson();
                $err = $json_users->JSON($err);

                print_r($err); //输出错误
                return $err;
            }
             else {
                $err = '';
                $err['err'] = 2;
                $err['msg'] = "user_sn or password is null";
                $json_users = new arraytojson();
                $err = $json_users->JSON($err);

                print_r($err); //输出错误
                return $err;

            }

        }


    } else {
        $return = array('1' => 'api_key error or secret error!');
        print_r($return[1]);
    }

} else {
    echo "error!";

}

//http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=exe.sql&is_allow=2&format=json&sql=select * from goods


















?>