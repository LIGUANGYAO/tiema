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

    if ($_REQUEST['method'] == "get.goods.list") {
        $method = "get.goods.list";
    }
    ;
    if ($_REQUEST['method'] == "get.user.id") {
        $method = "get.user.id";
    }
    ;

    //获取版本信息
    if ($_REQUEST['method'] == "send.wx.msg") {
        $method = "send.wx.msg";
    }
    ;
    //获取版本信息
    if ($_REQUEST['method'] == "get.edition.info") {
        $method = "get.edition.info";
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

        //获取商品接口
        if ($method == "get.goods.list") {

            if (isset($_REQUEST['u_met'])) {

                $update_method = trim($_REQUEST['u_met']);
            } else {
                $update_method = 0;
            }

            //u_met=1时个别查找，u_met=0的时候查找全部
            if (isset($_REQUEST['page'])) {

                $page = (int)($_REQUEST['page']);
                //echo $page;
            } else {
                $page = '1';
            }
            if (isset($_REQUEST['num'])) {

                $num = (int)($_REQUEST['num']);
                //echo $page;
            } else {
                $num = '5';
            }
            if (isset($_REQUEST['goods_sn'])) {

                $goods_sn = trim($_REQUEST['goods_sn']);
                //echo $page;
            } else {
                $goods_sn = '';
            }
            if (isset($_REQUEST['g_type'])) {

                $g_type = trim($_REQUEST['g_type']);
                //echo $page;
            } else {
                $g_type = '';
            }
            if (isset($_REQUEST['sort_field'])) {

                $sort_field = trim($_REQUEST['sort_field']);
                //echo $page;
            } else {
                $sort_field = '';
            }
            if (isset($_REQUEST['sort_type'])) {

                $sort_type = trim($_REQUEST['sort_type']);
                //echo $page;
            } else {
                $sort_type = '0';
            }


            require_once ('sub/sub_get_goods_list.php');
            $ex = new getgoods;
            //$string = "1,2,3,4,5";
            // echo 1;
            //print_r($array = explode(",",$string));
            /// $ex->user_array = $user_array;
            // echo 1;
          
            //判断是否启用附属数据库
            
            if (U_DB2 == 1) {
                $ex->system = "efast";
                $ex->method = $method;
                $ex->update_method = $update_method;
                $ex->page = $page;
                $ex->num = $num;
                $ex->g_type = $g_type;
                $ex->goods_sn = $goods_sn;
                $ex->sort_field = $sort_field;
                $ex->sort_type = $sort_type;
                $zhanshi_list = $ex->exes();
                $json_users = new arraytojson();
                $ex->err = $json_users->JSON($zhanshi_list);
                //
                print_r($ex->err); //输出错误
                return $ex->err;

            } else {
                $ex->method = $method;
                $ex->update_method = $update_method;
                $ex->page = $page;
                $ex->num = $num;
                $ex->g_type = $g_type;
                $ex->goods_sn = $goods_sn;
                $ex->sort_field = $sort_field;
                $ex->sort_type = $sort_type;
                $zhanshi_list = $ex->exes();
                $json_users = new arraytojson();
                $ex->err = $json_users->JSON($zhanshi_list);
                //
                print_r($ex->err); //输出错误
                return $ex->err;

            }


            //}


        }
        //----

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
                                    $users_list = $ex->exes("openid,users_sn,question,users_name,headimgurl,nick_name,sex,birthday,users_money,reg_time,last_login,is_warn,qq,weixin,sina,home_phone,mobile_phone,mobile_phone_2,mobile_phone_3,tzsy",
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
                $openid = trim($_REQUEST['openid']);
            }

            if (isset($_REQUEST['msg'])) {
                $msg = trim($_REQUEST['msg']);
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


                                    //单独的亚特efast搜索版本
                                    //
                                    define('CUSTOMER', 'YATE');
                                    if (CUSTOMER == 'YATE' && U_DB2 == 1) {


                                        //更新用户当前的操作状态
                                        require_once ('sub/sub_rest_send.php');
                                        $exe = new wx_response();
                                        $exe->openid = $openid;
                                        //未有状态插入
                                        $exe->in_response();
                                        $list = $exe->get_response();
                                        //更新为SD_SHOPPING状态
                                        $exe->p_id = "SD_SHOPPING";
                                        $exe->response_sn = "";
                                        $sql = $exe->update_response();


                                        //----------------------------

                                        //    $exe = new wx_response();
                                        //                                        $exe->openid = $openid;
                                        //                                        $exe->in_response();
                                        //                                        $list = $exe->get_response();
                                        //                                        $exe->p_id = "SHANGPIN_000";
                                        //                                        $exe->response_sn = "";
                                        //                                        $sql = $exe->update_response();

                                        //转义字符
                                        $msg = addslashes($msg);

                                        $array = explode(",", $msg);
                                        //插入临时购物sessionsss
                                        function in_shopping_sessions($openid, $msg)
                                        {
                                            $de = "delete from shopping_sessions where openid='" . $openid . "'";
                                            $de = $GLOBALS['db']->query($de);

                                            $sql = "insert into shopping_sessions(openid,msg) values('" . $openid . "','" .
                                                $msg . "')";
                                            $res = $GLOBALS['db']->query($sql);
                                        }
                                        in_shopping_sessions($openid, $msg);
                                        //-----
                                        function get_goods_info($obj)
                                        {


                                            $sql = "select b.market_price,a.barcode,b.goods_sn,b.goods_name,c.color_name,c.color_code,d.size_name,d.size_code,d.outer_size_code from goods_barcode a inner join goods b on a.goods_id =b.goods_id inner join color c on a.color_id=c.color_id inner join size d on a.size_id=d.size_id where a.barcode='" .
                                                $obj . "'";
                                            $res = $GLOBALS['db2']->getRow($sql);
                                            return $res;
                                        }

                                        $sum_array = count($array) - 1;
                                        $wuxiao = 0;
                                        for ($i = 0; $i < (count($array) - 1); $i++) {
                                            $arr = get_goods_info($array[$i]);
                                            if (empty($arr)) {
                                                $txt .= "第" . ($i + 1) . "行\n" . $array[$i] . "\n无效\n-------------------\n";
                                                $sum_array = $sum_array - 1;
                                                $wuxiao++;
                                            } else {
                                                $txt .= "第" . ($i + 1) . "行\n" . $arr['barcode'] . "\n" . $arr['goods_name'] .
                                                    "(" . $arr['goods_sn'] . ")\n" . $arr['color_name'] . "   " . $arr['size_name'] .
                                                    "\n零售价:¥" . $arr['market_price'] . "\n-------------------\n";
                                                $market_price += $arr['market_price'];
                                            }

                                        }
                                        $market_price = sprintf("%.2f", $market_price);

                                        $txt2 = "数量:" . $sum_array . " 合计:¥" . $market_price . "\n无效:" . $wuxiao;
                                        $msg = $txt . $txt2;
                                    }


                                    //单独的亚特efast搜索版本
                                    //
                                    //添加文本信息
                                    //前台收银模式

                                    //根据自定义代码回复相应   文本/图文信息
                                    $exx = new wx_custom();
                                    $exx->custom_sn = "BEGIN_SHOPPING";


                                    $respone = $exx->get_response();


                                    if (is_array($respone)) {
                                        $re_img = content2('news', $openid, $respone);
                                        send($re_img);
                                    } else {
                                        $re_text = content('text', $openid, $respone);
                                        send($re_text);
                                    }

                                    //----------------------------------------


                                    //回复APP上传上来的回复信息
                                    $reuslt = content('text', $openid, $msg);
                                    //    print_r($reuslt)

                                    $aaa = send($reuslt);


                                    //根据自定义代码回复相应   文本/图文信息
                                    $exx = new wx_custom();
                                    $exx->custom_sn = "SHOPPING";


                                    $respone = $exx->get_response();


                                    if (is_array($respone)) {
                                        $re_img = content2('news', $openid, $respone);
                                        send($re_img);
                                    } else {
                                        $re_text = content('text', $openid, $respone);
                                        send($re_text);
                                    }

                                    //----------------------------------------


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


        if ($method == "get.edition.info") {


            if (isset($_REQUEST['type'])) {

                $type = $_REQUEST['type'];
                //echo $page;
            }


            require_once ('sub/sub_get_edition_info2.php');
            $ex = new geteditioninfo;

            $ex->type = $type;
            $ex->method = "get.dition.info";


            $edition_list = $ex->exes();
            $json_users = new arraytojson();
            $ex->err = $json_users->JSON($edition_list);
            //
            print_r($ex->err); //输出错误
            return $ex->err;
            //}


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