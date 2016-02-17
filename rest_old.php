<?php
define('IN_ECS', true);
require_once ('includes/init2.php');
require_once ('sub/sub_rest.php');
require (dirname(__file__) . '/sub/sub_weixin_token.php');
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
   
    if ($_REQUEST['method'] == "get.user.id") {
        $method = "get.user.id";
    }
    ;
    
    //获取版本信息
     if ($_REQUEST['method'] == "send.wx.msg") {
        $method = "send.wx.msg";
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
    //print_r( $user_id);

    if (!empty($user_id)) {

      

        if ($method == "get.user.id") {

            if (isset($_REQUEST['u_met'])) {
                $update_method = trim($_REQUEST['u_met']);
            }

            if (isset($_REQUEST['users_sn'])) {
                if (empty($_REQUEST['users_sn'])) {
                    $allow = 0;

                } else {
                    $allow = 1;
                    $list_a['users_sn'] = trim($_REQUEST['users_sn']);
                }

            }
            if ($allow != 0) {
                $user_id = '';
                $sql_key = " select users_sn,password,temporary_time,temporary_key from users  where users_sn='" .
                    $list_a['users_sn'] . "' ;";
                //print_r($sql_key);exit;
                $user_id = $GLOBALS['db']->getRow($sql_key);
                if (!empty($user_id)) {
                    $time_diff = get_time_diff($user_id['temporary_time']);
                    //print_r($time_diff['hour']);
                    if ($time_diff['hour'] >= 3) {
                        $err = '';
                        $err['err'] = 4;
                        $err['msg'] = "temporary_key is expire ";
                        $json_users = new arraytojson();
                        $err = $json_users->JSON($err);

                        print_r($err); //输出错误
                        return $err;
                    } else {
                       
                        if (isset($_REQUEST['temporary_key'])) {

                            $temporary_key = $_REQUEST['temporary_key'];
                            if (empty($temporary_key)) {
                                $err = '';
                                $err['err'] = 6;
                                $err['msg'] = "temporary_key is null";
                                $json_users = new arraytojson();
                                $err = $json_users->JSON($err);

                                print_r($err); //输出错误
                                return $err;

                            } else {
                                $sql_one = "select temporary_key  from users  where temporary_key='" . $temporary_key .
                                    "' and  users_sn ='" . $list_a['users_sn'] . "'";
                                $sql_one_r = $GLOBALS['db']->getRow($sql_one);

                                //print_r($sql_one);
                                if (!empty($sql_one_r)) {

                                    require_once ('sub/sub_get_user.php');
                                    $ex = new getusr;
                                    $ex->method = $method;
                                    $ex->list_array = $list_a;
                                    $ex->update_method = $update_method;
                                    $users_list = $ex->exes("openid,users_sn,question,users_name,nick_name,sex,birthday,users_money,reg_time,last_login,is_warn,qq,weixin,sina,home_phone,mobile_phone,mobile_phone_2,mobile_phone_3,tzsy",
                                        $list_a['users_sn']);

                                    //users_sn,users_name,nick_name,sex,birthday,users_money,reg_time,last_login,is_warn,qq,weixin,sina,home_phone,mobile_phone,mobile_phone_2,mobile_phone_3,tzsy
                                    $json_users = new arraytojson();
                                    $ex->err = $json_users->JSON($users_list);

                                    print_r($ex->err); //输出错误
                                    return $ex->err;
                                } else { //zhe
                                    $err = '';
                                    $err['err'] = 4;
                                    $err['msg'] = "temporary_key is error";
                                    $json_users = new arraytojson();
                                    $err = $json_users->JSON($err);

                                    print_r($err); //输出错误
                                    return $err;
                                }

                            }


                        }
                    }


                } else {
                    $err = '';
                    $err['err'] = 5;
                    $err['msg'] = "user_sn is unfind";
                    $json_users = new arraytojson();
                    $err = $json_users->JSON($err);

                    print_r($err); //输出错误
                    return $err;
                }
            } else {
                $err = '';
                $err['err'] = 2;
                $err['msg'] = "user_sn is null";
                $json_users = new arraytojson();
                $err = $json_users->JSON($err);

                print_r($err); //输出错误
                return $err;

            }

        }
        
        
        
        //发送会员信息
         if ($method == "send.wx.msg") {

            if (isset($_REQUEST['u_met'])) {
                $update_method = trim($_REQUEST['u_met']);
            }

            if (isset($_REQUEST['users_sn'])) {
                if (empty($_REQUEST['users_sn'])) {
                    $allow = 0;

                } else {
                    $allow = 1;
                    $list_a['users_sn'] = trim($_REQUEST['users_sn']);
                }

            }
             if (isset($_REQUEST['openid'])) {
                $openid=trim($_REQUEST['openid']);
            }
            
             if (isset($_REQUEST['msg'])) {
                $msg=trim($_REQUEST['msg']);
            }
            
            if ($allow != 0) {
                $user_id = '';
                $sql_key = " select users_sn,password,temporary_time,temporary_key from users  where users_sn='" .
                    $list_a['users_sn'] . "' ;";
                //print_r($sql_key);exit;
                $user_id = $GLOBALS['db']->getRow($sql_key);
                if (!empty($user_id)) {
                    $time_diff = get_time_diff($user_id['temporary_time']);
                    //print_r($time_diff['hour']);
                    if ($time_diff['hour'] >= 3) {
                        $err = '';
                        $err['err'] = 4;
                        $err['msg'] = "temporary_key is expire ";
                        $json_users = new arraytojson();
                        $err = $json_users->JSON($err);

                        print_r($err); //输出错误
                        return $err;
                    } else {
                       
                        if (isset($_REQUEST['temporary_key'])) {

                            $temporary_key = $_REQUEST['temporary_key'];
                            if (empty($temporary_key)) {
                                $err = '';
                                $err['err'] = 6;
                                $err['msg'] = "temporary_key is null";
                                $json_users = new arraytojson();
                                $err = $json_users->JSON($err);

                                print_r($err); //输出错误
                                return $err;

                            } else {
                                $sql_one = "select temporary_key  from users  where temporary_key='" . $temporary_key .
                                    "' and  users_sn ='" . $list_a['users_sn'] . "'";
                                $sql_one_r = $GLOBALS['db']->getRow($sql_one);

                                //print_r($sql_one);
                                if (!empty($sql_one_r)) {

                                    require_once ('sub/sub_send_wx_msg.php');
                                    
                                    
                                    
                                    
                                    //添加文本信息
                                    $reuslt = content('text',$openid,$msg);
                                        //    print_r($reuslt)
                                    
                                    $aaa=send($reuslt);
                                    //print_r($aaa);
                                    $json_users = new arraytojson();
                                    $ex->err = $json_users->JSON($aaa);

                                    print_r($ex->err); //输出错误
                                    return $ex->err;
                                } else { //zhe
                                    $err = '';
                                    $err['err'] = 4;
                                    $err['msg'] = "temporary_key is error";
                                    $json_users = new arraytojson();
                                    $err = $json_users->JSON($err);

                                    print_r($err); //输出错误
                                    return $err;
                                }

                            }


                        }
                    }


                } else {
                    $err = '';
                    $err['err'] = 5;
                    $err['msg'] = "user_sn is unfind";
                    $json_users = new arraytojson();
                    $err = $json_users->JSON($err);

                    print_r($err); //输出错误
                    return $err;
                }
            } else {
                $err = '';
                $err['err'] = 2;
                $err['msg'] = "user_sn is null";
                $json_users = new arraytojson();
                $err = $json_users->JSON($err);

                print_r($err); //输出错误
                return $err;

            }

        }
        
        //获取版本信息结束
    } else {
        $return = array('1' => 'api_key error or secret error!');
        print_r($return[1]);
    }


} else {
    echo "error!";

}

//http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=exe.sql&is_allow=2&format=json&sql=select * from goods































?>