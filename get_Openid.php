<?php


header('Content-Type: text/html; charset=utf-8');


define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'default') {

    //会员全量更新
    class getArr
    {
        public $reqUrl = '';
        public $openid;
        public function get_time_diff($t)
        {
            $time = date('Y-m-d H:i:s', time());
            $time = strtotime($time);
            //echo $time;exit;
            $aaa = date("YmdHis", $time);
            // $time = date('Y-m-d H:i:s', time());
            $t = strtotime($t);
            //echo $time;exit;
            $t = date("YmdHis", $t);
            $a = $this->timeDiff($aaa, $t);
            return $a;
        }
        public function timeDiff($aTime, $bTime)
        {
            // 分割第一个时间
            $ayear = substr($aTime, 0, 4);
            $amonth = substr($aTime, 4, 2);
            $aday = substr($aTime, 6, 2);
            $ahour = substr($aTime, 8, 2);
            $aminute = substr($aTime, 10, 2);
            $asecond = substr($aTime, 12, 2);
            // 分割第二个时间
            $byear = substr($bTime, 0, 4);
            $bmonth = substr($bTime, 4, 2);
            $bday = substr($bTime, 6, 2);
            $bhour = substr($bTime, 8, 2);
            $bminute = substr($bTime, 10, 2);
            $bsecond = substr($bTime, 12, 2);
            // 生成时间戳
            $a = mktime($ahour, $aminute, $asecond, $amonth, $aday, $ayear);
            $b = mktime($bhour, $bminute, $bsecond, $bmonth, $bday, $byear);
            $timeDiff['second'] = $a - $b;
            // 采用了四舍五入,可以修改
            $timeDiff['mintue'] = round($timeDiff['second'] / 60);
            $timeDiff['hour'] = round($timeDiff['mintue'] / 60);
            $timeDiff['day'] = round($timeDiff['hour'] / 24);
            $timeDiff['week'] = round($timeDiff['day'] / 7);
            $timeDiff['month'] = round($timeDiff['day'] / 30); // 按30天来算
            $timeDiff['year'] = round($timeDiff['day'] / 365); // 按365天来算
            return $timeDiff;
        }
        public function getToken()
        {
            $get_app = "select app_id ,app_secret from app_id where weixin_id=1";
            $get_app = $GLOBALS['db']->getRow($get_app);
            //print_r($get_app);exit;

            $APPID = $get_app['app_id'];
            $APPSECRET = $get_app['app_secret'];
            if (empty($APPID)) {
                echo "appid missing";
                exit;
            } elseif (empty($APPSECRET)) {
                echo "appsecret missing";
                exit;
            } else {

            }
            //https://api.weixin.qq.com/cgi-bin/user/get?access_token=ACCESS_TOKEN&next_openid=NEXT_OPENID


            //                return $ACC_TOKEN;
            $a_token_time = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
            $a_token_time = $GLOBALS['db']->getRow($a_token_time);
            //print_r($a_token_time);exit;

            $time_diff = $this->get_time_diff($a_token_time['last_update']);
            //print_r($time_diff);
            //            exit;
            if ($time_diff['second'] >= 3600 or $time_diff['second'] <= -1) {

                $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                    $APPID . "&secret=" . $APPSECRET;

                $json = file_get_contents($TOKEN_URL);
                $result = json_decode($json);
                $ACC_TOKEN = $result->access_token;


                $i = 0;
                while ($result->access_token == '') {

                    $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                        $APPID . "&secret=" . $APPSECRET;

                    $json = file_get_contents($TOKEN_URL);
                    $result = json_decode($json);


                    $i++;

                    if ($result->access_token != '') {


                        $ACC_TOKEN = $result->access_token;


                        break;
                    } elseif ($i >= 5) {
                        break;
                    }

                }


                $time = date('Y-m-d H:i:s', time());
                $u_acc_token = "update temporary_tb set access_token='" . $ACC_TOKEN .
                    "',last_update='" . $time . "' where type=1 and app_id=1";
                $u_acc_token = $GLOBALS['db']->query($u_acc_token);


                //echo 1;
                $a_token_time2 = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
                $a_token_time2 = $GLOBALS['db']->getRow($a_token_time2);
                return $a_token_time2['access_token'];
                //echo $time_diff['second'] . "1";
                //exit;
            } else {
                //echo 2;
                $a_token_time2 = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
                $a_token_time2 = $GLOBALS['db']->getRow($a_token_time2);

                //print_r(empty($a_token_time2));exit;

                $i = 0;
                while ($a_token_time2['access_token'] == '') {

                    $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                        $APPID . "&secret=" . $APPSECRET;

                    $json = file_get_contents($TOKEN_URL);
                    $result = json_decode($json);

                    $i++;
                    //echo $i;
                    $a_token_time2['access_token'] = $result->access_token;
                    //print_r($a_token_time2['access_token']) ;
                    if ($a_token_time2['access_token'] != '') {


                        $ACC_TOKEN = $result->access_token;
                        $time = date('Y-m-d H:i:s', time());
                        $u_acc_token = "update temporary_tb set access_token='" . $ACC_TOKEN .
                            "',last_update='" . $time . "' where type=1 and app_id=1";
                        $u_acc_token = $GLOBALS['db']->query($u_acc_token);


                        break;
                    } elseif ($i >= 5) {
                        break;
                    }

                }


                $a_token_time3 = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
                $a_token_time3 = $GLOBALS['db']->getRow($a_token_time3);

                //exit;

                return $a_token_time3['access_token'];
            }
            //exit;

        }

        public function getOpenid()
        {
            $MENU_URL = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=" . $this->
                getToken();
            
            //print_r($MENU_URL);exit;
            $json = file_get_contents($MENU_URL);
            $result = json_decode($json);
            //print_r($json);exit;
            //递归stdClass Object 对象
            function objtoarr($obj)
            {
                $ret = array();
                foreach ($obj as $key => $value) {
                    if (gettype($value) == 'array' || gettype($value) == 'object') {
                        $ret[$key] = objtoarr($value);
                    } else {
                        $ret[$key] = $value;
                    }
                }
                return $ret;
            }

            $result2 = objtoarr($result);
            return $result2;


        }

        public function getopen()
        {
            //https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN
            $MENU_URL = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $this->
                getToken() . "&openid=" . $this->openid . "&lang=zh_CN";

            //print_r($MENU_URL);exit;
            $json = file_get_contents($MENU_URL);
            $result = json_decode($json);
            //print_r($json);exit;
            //递归stdClass Object 对象
            function objtoarr2($obj)
            {
                $ret = array();
                foreach ($obj as $key => $value) {
                    if (gettype($value) == 'array' || gettype($value) == 'object') {
                        $ret[$key] = objtoarr($value);
                    } else {
                        $ret[$key] = $value;
                    }
                }
                return $ret;
            }

            $result2 = objtoarr2($result);
            return $result2;

        }

    }


    if (isset($_REQUEST['id'])) {
        if ($id == '-1') {
            echo "结束";
        }
        $id = $_REQUEST['id'];
        // echo $id;
        //        echo $now_time;
        $ex = new getArr();
        $obj = $ex->getOpenid();
        //            print_r($obj);
        $ex->openid = $obj['data']['openid'][$id];
        //          print_r($ex->openid);
        $opend_msg = $ex->getopen();
        
        $opend_msg['nickname']=addslashes($opend_msg['nickname']);
        if ($opend_msg['errcode'] != 0) {
            //   echo "api freq out of limit";
            print_r($opend_msg);
        } else {
            //print_r($opend_msg) ;
            print_r($opend_msg['openid'] . "  " . $opend_msg['nickname']);
            $user_id = "select id from users where openid='" . $opend_msg['openid'] . "'";
            $user_id2 = $GLOBALS['db']->getRow($user_id);
            if (empty($user_id2)) {
               // $values = "'" . $opend_msg['subscribe_time'] . "','" . $opend_msg['openid'] .
//                    "','" . $opend_msg['language'] . "','" . $opend_msg['city'] . "','" . $opend_msg['province'] .
//                    "','" . $opend_msg['country'] . "','" . $opend_msg['headimgurl'] . "','" . $opend_msg['nickname'] .
//                    "'";
//                $sql = "insert into users(subscribe_time,openid,language,city,province,country,headimgurl,nick_name) values (" .
//                    $values . ")";

                $add_time = date('Y-m-d H:i:s', time());
                $last_update_2=date('Y-m-d', time());
                
                
                $values = "'" . $opend_msg['subscribe_time'] . "','" . $opend_msg['openid'] .
                    "','" . $opend_msg['language'] . "','" . $opend_msg['city'] . "','" . $opend_msg['province'] .
                    "','" . $opend_msg['country'] . "','" . $opend_msg['headimgurl'] . "','" . $opend_msg['nickname'] .
                    "','".$add_time."','".$last_update_2."'";
                $sql = "insert into users(subscribe_time,openid,language,city,province,country,headimgurl,nick_name,add_time,last_update_2) values (" .
                    $values . ")";

                
                $opq = $GLOBALS['db']->query($sql);
                $uid = "select id from users where openid='" . $opend_msg['openid'] . "'";
                $uid = $GLOBALS['db']->getRow($uid);
                //print_r($uid) ;
                $var = sprintf("%09d", $uid['id']);
                //echo $var;
                $sql2 = "update users set users_sn=concat('WXVIP','" . $var .
                    "') where openid='" . $opend_msg['openid'] . "'";
                //echo $sql2;
                $opq2 = $GLOBALS['db']->query($sql2);

                //添加图片

                //GrabImage($opend_msg['headimgurl'],$opend_msg['openid']);

                echo "添加成功";
            } else {
                $up = "update users set subscribe_time='" . $opend_msg['subscribe_time'] .
                    "',language='" . $opend_msg['language'] . "',city='" . $opend_msg['city'] .
                    "',province='" . $opend_msg['province'] . "',country='" . $opend_msg['country'] .
                    "',headimgurl='" . $opend_msg['headimgurl'] . "',nick_name='" . $opend_msg['nickname'] .
                    "' where openid='" . $opend_msg['openid'] . "'";
                $up = $GLOBALS['db']->query($up);

                //GrabImage($opend_msg['headimgurl'],$opend_msg['openid']);
                echo "  已刷新";
            }


            // print_r($opend_msg['openid']."  ".$opend_msg['nickname']);
        }


    }


    exit;

}


if ($_REQUEST['act'] == 'increment') {
    class getArr
    {
        public $reqUrl = '';
        public $openid;
        public $next_openid;
         public function get_time_diff($t)
        {
            $time = date('Y-m-d H:i:s', time());
            $time = strtotime($time);
            //echo $time;exit;
            $aaa = date("YmdHis", $time);
            // $time = date('Y-m-d H:i:s', time());
            $t = strtotime($t);
            //echo $time;exit;
            $t = date("YmdHis", $t);
            $a = $this->timeDiff($aaa, $t);
            return $a;
        }
        public function timeDiff($aTime, $bTime)
        {
            // 分割第一个时间
            $ayear = substr($aTime, 0, 4);
            $amonth = substr($aTime, 4, 2);
            $aday = substr($aTime, 6, 2);
            $ahour = substr($aTime, 8, 2);
            $aminute = substr($aTime, 10, 2);
            $asecond = substr($aTime, 12, 2);
            // 分割第二个时间
            $byear = substr($bTime, 0, 4);
            $bmonth = substr($bTime, 4, 2);
            $bday = substr($bTime, 6, 2);
            $bhour = substr($bTime, 8, 2);
            $bminute = substr($bTime, 10, 2);
            $bsecond = substr($bTime, 12, 2);
            // 生成时间戳
            $a = mktime($ahour, $aminute, $asecond, $amonth, $aday, $ayear);
            $b = mktime($bhour, $bminute, $bsecond, $bmonth, $bday, $byear);
            $timeDiff['second'] = $a - $b;
            // 采用了四舍五入,可以修改
            $timeDiff['mintue'] = round($timeDiff['second'] / 60);
            $timeDiff['hour'] = round($timeDiff['mintue'] / 60);
            $timeDiff['day'] = round($timeDiff['hour'] / 24);
            $timeDiff['week'] = round($timeDiff['day'] / 7);
            $timeDiff['month'] = round($timeDiff['day'] / 30); // 按30天来算
            $timeDiff['year'] = round($timeDiff['day'] / 365); // 按365天来算
            return $timeDiff;
        }
        public function getToken()
        {
            $get_app = "select app_id ,app_secret from app_id where weixin_id=1";
            $get_app = $GLOBALS['db']->getRow($get_app);
            //print_r($get_app);exit;

            $APPID = $get_app['app_id'];
            $APPSECRET = $get_app['app_secret'];
            if (empty($APPID)) {
                echo "appid missing";
                exit;
            } elseif (empty($APPSECRET)) {
                echo "appsecret missing";
                exit;
            } else {

            }
            //https://api.weixin.qq.com/cgi-bin/user/get?access_token=ACCESS_TOKEN&next_openid=NEXT_OPENID


            //                return $ACC_TOKEN;
            $a_token_time = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
            $a_token_time = $GLOBALS['db']->getRow($a_token_time);
            //print_r($a_token_time);exit;

            $time_diff = $this->get_time_diff($a_token_time['last_update']);
            //print_r($time_diff);
            //            exit;
            if ($time_diff['second'] >= 3600 or $time_diff['second'] <= -1) {

                $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                    $APPID . "&secret=" . $APPSECRET;

                $json = file_get_contents($TOKEN_URL);
                $result = json_decode($json);
                $ACC_TOKEN = $result->access_token;


                $i = 0;
                while ($result->access_token == '') {

                    $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                        $APPID . "&secret=" . $APPSECRET;

                    $json = file_get_contents($TOKEN_URL);
                    $result = json_decode($json);


                    $i++;

                    if ($result->access_token != '') {


                        $ACC_TOKEN = $result->access_token;


                        break;
                    } elseif ($i >= 5) {
                        break;
                    }

                }


                $time = date('Y-m-d H:i:s', time());
                $u_acc_token = "update temporary_tb set access_token='" . $ACC_TOKEN .
                    "',last_update='" . $time . "' where type=1 and app_id=1";
                $u_acc_token = $GLOBALS['db']->query($u_acc_token);


                //echo 1;
                $a_token_time2 = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
                $a_token_time2 = $GLOBALS['db']->getRow($a_token_time2);
                return $a_token_time2['access_token'];
                //echo $time_diff['second'] . "1";
                //exit;
            } else {
                //echo 2;
                $a_token_time2 = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
                $a_token_time2 = $GLOBALS['db']->getRow($a_token_time2);

                //print_r(empty($a_token_time2));exit;

                $i = 0;
                while ($a_token_time2['access_token'] == '') {

                    $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                        $APPID . "&secret=" . $APPSECRET;

                    $json = file_get_contents($TOKEN_URL);
                    $result = json_decode($json);

                    $i++;
                    //echo $i;
                    $a_token_time2['access_token'] = $result->access_token;
                    //print_r($a_token_time2['access_token']) ;
                    if ($a_token_time2['access_token'] != '') {


                        $ACC_TOKEN = $result->access_token;
                        $time = date('Y-m-d H:i:s', time());
                        $u_acc_token = "update temporary_tb set access_token='" . $ACC_TOKEN .
                            "',last_update='" . $time . "' where type=1 and app_id=1";
                        $u_acc_token = $GLOBALS['db']->query($u_acc_token);


                        break;
                    } elseif ($i >= 5) {
                        break;
                    }

                }


                $a_token_time3 = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
                $a_token_time3 = $GLOBALS['db']->getRow($a_token_time3);

                //exit;

                return $a_token_time3['access_token'];
            }
            //exit;

        }
        public function getOpenid()
        {
            $MENU_URL = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=" . $this->
                getToken() . "&next_openid=" . $this->next_openid;
            //print_r($MENU_URL);exit;
            $json = file_get_contents($MENU_URL);
            $result = json_decode($json);
            //print_r($json);exit;
            //递归stdClass Object 对象
            function objtoarr($obj)
            {
                $ret = array();
                foreach ($obj as $key => $value) {
                    if (gettype($value) == 'array' || gettype($value) == 'object') {
                        $ret[$key] = objtoarr($value);
                    } else {
                        $ret[$key] = $value;
                    }
                }
                return $ret;
            }

            $result2 = objtoarr($result);
            return $result2;


        }

        public function getopen()
        {
            //https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN
            $MENU_URL = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $this->
                getToken() . "&openid=" . $this->openid . "&lang=zh_CN";

            //print_r($MENU_URL);exit;
            $json = file_get_contents($MENU_URL);
            $result = json_decode($json);
            //print_r($json);exit;
            //递归stdClass Object 对象
            function objtoarr2($obj)
            {
                $ret = array();
                foreach ($obj as $key => $value) {
                    if (gettype($value) == 'array' || gettype($value) == 'object') {
                        $ret[$key] = objtoarr($value);
                    } else {
                        $ret[$key] = $value;
                    }
                }
                return $ret;
            }

            $result2 = objtoarr2($result);
            return $result2;

        }

    }


    if (isset($_REQUEST['id'])) {
        if ($id == '-1') {
            echo "结束";
        }
        $id = $_REQUEST['id'];
        $next_openid = "select val from increment_log where tb_name='users' and f_name='next_openid'";
        $next_openid = $GLOBALS['db']->getRow($next_openid);
        //echo $next_openid['val'];exit;
        // echo $id;
        //        echo $now_time;
        $ex = new getArr();

        $next_openid = "select val from increment_log where tb_name='users' and f_name='next_openid'";
        $next_openid = $GLOBALS['db']->getRow($next_openid);
        $ex->next_openid = $next_openid['val'];
        $obj = $ex->getOpenid();
        //print_r($obj);exit;
        $ex->openid = $obj['data']['openid'][$id];

        //          print_r($ex->openid);
        $opend_msg = $ex->getopen();
        
        
        $opend_msg['nickname']=addslashes($opend_msg['nickname']);
        //print_r($opend_msg);exit;
        if ($opend_msg['errcode'] != 0) {
            //   echo "api freq out of limit";
            //print_r($opend_msg) ;
            echo "无记录";
        } else {
            //print_r($opend_msg) ;
            print_r($opend_msg['openid'] . "  " . $opend_msg['nickname']);
            $user_id3 = "select id from users where openid='" . $opend_msg['openid'] . "'";
            $user_id4 = $GLOBALS['db']->getRow($user_id3);
            if (empty($user_id4)) {
               // $values = "'" . $opend_msg['subscribe_time'] . "','" . $opend_msg['openid'] .
//                    "','" . $opend_msg['language'] . "','" . $opend_msg['city'] . "','" . $opend_msg['province'] .
//                    "','" . $opend_msg['country'] . "','" . $opend_msg['headimgurl'] . "','" . $opend_msg['nickname'] .
//                    "'";
//                $sql = "insert into users(subscribe_time,openid,language,city,province,country,headimgurl,nick_name) values (" .
//                    $values . ")";
//                $opq = $GLOBALS['db']->query($sql);

                $add_time = date('Y-m-d H:i:s', time());
                $last_update_2=date('Y-m-d', time());
                
                
                $values = "'" . $opend_msg['subscribe_time'] . "','" . $opend_msg['openid'] .
                    "','" . $opend_msg['language'] . "','" . $opend_msg['city'] . "','" . $opend_msg['province'] .
                    "','" . $opend_msg['country'] . "','" . $opend_msg['headimgurl'] . "','" . $opend_msg['nickname'] .
                    "','".$add_time."','".$last_update_2."'";
                $sql_11 = "insert into users(subscribe_time,openid,language,city,province,country,headimgurl,nick_name,add_time,last_update_2) values (" .
                    $values . ")";

                
                $uid = "select id from users where openid='" . $opend_msg['openid'] . "'";
                $uid = $GLOBALS['db']->getRow($uid);
                //print_r($uid) ;
                $var = sprintf("%09d", $uid['id']);
                //echo $var;
                $sql2 = "update users set users_sn=concat('WXVIP','" . $var .
                    "') where openid='" . $opend_msg['openid'] . "'";
                //echo $sql2;
                $opq2 = $GLOBALS['db']->query($sql2);


                $u_next_opid = "update increment_log set val='" . $opend_msg['openid'] .
                    "' where  tb_name='users' and f_name='next_openid'";
                //echo $sql2;
                $u_next_opid = $GLOBALS['db']->query($u_next_opid);


                //下载头像图片;
                //GrabImage($opend_msg['headimgurl'],$opend_msg['openid']);
                echo "添加成功";
            } else {
                $u_next_opid = "update increment_log set val='" . $opend_msg['openid'] .
                    "' where  tb_name='users' and f_name='next_openid'";
                //echo $sql2;
                $u_next_opid = $GLOBALS['db']->query($u_next_opid);

                $up = "update users set subscribe_time='" . $opend_msg['subscribe_time'] .
                    "',language='" . $opend_msg['language'] . "',city='" . $opend_msg['city'] .
                    "',province='" . $opend_msg['province'] . "',country='" . $opend_msg['country'] .
                    "',headimgurl='" . $opend_msg['headimgurl'] . "',nick_name='" . $opend_msg['nickname'] .
                    "' where openid='" . $opend_msg['openid'] . "'";
                $up = $GLOBALS['db']->query($up);


                //GrabImage($opend_msg['headimgurl'],$opend_msg['openid']);
                echo "  已刷新";
            }


            // print_r($opend_msg['openid']."  ".$opend_msg['nickname']);
        }


    }


}

if ($_REQUEST['act'] == 'de3') {

    //会员全量更新
    class getArr
    {
        public $reqUrl = '';
        public $openid;
        public function get_time_diff($t)
        {
            $time = date('Y-m-d H:i:s', time());
            $time = strtotime($time);
            //echo $time;exit;
            $aaa = date("YmdHis", $time);
            // $time = date('Y-m-d H:i:s', time());
            $t = strtotime($t);
            //echo $time;exit;
            $t = date("YmdHis", $t);
            $a = $this->timeDiff($aaa, $t);
            return $a;
        }
        public function timeDiff($aTime, $bTime)
        {
            // 分割第一个时间
            $ayear = substr($aTime, 0, 4);
            $amonth = substr($aTime, 4, 2);
            $aday = substr($aTime, 6, 2);
            $ahour = substr($aTime, 8, 2);
            $aminute = substr($aTime, 10, 2);
            $asecond = substr($aTime, 12, 2);
            // 分割第二个时间
            $byear = substr($bTime, 0, 4);
            $bmonth = substr($bTime, 4, 2);
            $bday = substr($bTime, 6, 2);
            $bhour = substr($bTime, 8, 2);
            $bminute = substr($bTime, 10, 2);
            $bsecond = substr($bTime, 12, 2);
            // 生成时间戳
            $a = mktime($ahour, $aminute, $asecond, $amonth, $aday, $ayear);
            $b = mktime($bhour, $bminute, $bsecond, $bmonth, $bday, $byear);
            $timeDiff['second'] = $a - $b;
            // 采用了四舍五入,可以修改
            $timeDiff['mintue'] = round($timeDiff['second'] / 60);
            $timeDiff['hour'] = round($timeDiff['mintue'] / 60);
            $timeDiff['day'] = round($timeDiff['hour'] / 24);
            $timeDiff['week'] = round($timeDiff['day'] / 7);
            $timeDiff['month'] = round($timeDiff['day'] / 30); // 按30天来算
            $timeDiff['year'] = round($timeDiff['day'] / 365); // 按365天来算
            return $timeDiff;
        }
        public function getToken()
        {
            $get_app = "select app_id ,app_secret from app_id where weixin_id=1";
            $get_app = $GLOBALS['db']->getRow($get_app);
            //print_r($get_app);exit;

            $APPID = $get_app['app_id'];
            $APPSECRET = $get_app['app_secret'];
            if (empty($APPID)) {
                echo "appid missing";
                exit;
            } elseif (empty($APPSECRET)) {
                echo "appsecret missing";
                exit;
            } else {

            }
            //https://api.weixin.qq.com/cgi-bin/user/get?access_token=ACCESS_TOKEN&next_openid=NEXT_OPENID


            //                return $ACC_TOKEN;
            $a_token_time = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
            $a_token_time = $GLOBALS['db']->getRow($a_token_time);
            //print_r($a_token_time);exit;

            $time_diff = $this->get_time_diff($a_token_time['last_update']);
            //print_r($time_diff);
            //            exit;
            if ($time_diff['second'] >= 3600 or $time_diff['second'] <= -1) {

                $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                    $APPID . "&secret=" . $APPSECRET;

                $json = file_get_contents($TOKEN_URL);
                $result = json_decode($json);
                $ACC_TOKEN = $result->access_token;


                $i = 0;
                while ($result->access_token == '') {

                    $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                        $APPID . "&secret=" . $APPSECRET;

                    $json = file_get_contents($TOKEN_URL);
                    $result = json_decode($json);


                    $i++;

                    if ($result->access_token != '') {


                        $ACC_TOKEN = $result->access_token;


                        break;
                    } elseif ($i >= 5) {
                        break;
                    }

                }


                $time = date('Y-m-d H:i:s', time());
                $u_acc_token = "update temporary_tb set access_token='" . $ACC_TOKEN .
                    "',last_update='" . $time . "' where type=1 and app_id=1";
                $u_acc_token = $GLOBALS['db']->query($u_acc_token);


                //echo 1;
                $a_token_time2 = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
                $a_token_time2 = $GLOBALS['db']->getRow($a_token_time2);
                return $a_token_time2['access_token'];
                //echo $time_diff['second'] . "1";
                //exit;
            } else {
                //echo 2;
                $a_token_time2 = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
                $a_token_time2 = $GLOBALS['db']->getRow($a_token_time2);

                //print_r(empty($a_token_time2));exit;

                $i = 0;
                while ($a_token_time2['access_token'] == '') {

                    $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                        $APPID . "&secret=" . $APPSECRET;

                    $json = file_get_contents($TOKEN_URL);
                    $result = json_decode($json);

                    $i++;
                    //echo $i;
                    $a_token_time2['access_token'] = $result->access_token;
                    //print_r($a_token_time2['access_token']) ;
                    if ($a_token_time2['access_token'] != '') {


                        $ACC_TOKEN = $result->access_token;
                        $time = date('Y-m-d H:i:s', time());
                        $u_acc_token = "update temporary_tb set access_token='" . $ACC_TOKEN .
                            "',last_update='" . $time . "' where type=1 and app_id=1";
                        $u_acc_token = $GLOBALS['db']->query($u_acc_token);


                        break;
                    } elseif ($i >= 5) {
                        break;
                    }

                }


                $a_token_time3 = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
                $a_token_time3 = $GLOBALS['db']->getRow($a_token_time3);

                //exit;

                return $a_token_time3['access_token'];
            }
            //exit;

        }
        public function getOpenid()
        {
            $MENU_URL = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=" . $this->
                getToken();
            //print_r($MENU_URL);exit;
            $json = file_get_contents($MENU_URL);
            $result = json_decode($json);
            //print_r($json);exit;
            //递归stdClass Object 对象
            function objtoarr($obj)
            {
                $ret = array();
                foreach ($obj as $key => $value) {
                    if (gettype($value) == 'array' || gettype($value) == 'object') {
                        $ret[$key] = objtoarr($value);
                    } else {
                        $ret[$key] = $value;
                    }
                }
                return $ret;
            }

            $result2 = objtoarr($result);
            return $result2;


        }


    }
    //echo 4444444444;
    $ex = new getArr();
    $obj = $ex->getOpenid();
    print_r((int)$obj['count']);


}

if ($_REQUEST['act'] == 'get_img') {
    if (isset($_REQUEST['img_url']) && isset($_REQUEST['id'])) {
        $url = $_REQUEST['img_url'];
        $id = $_REQUEST['id'];
        //echo $id;
        if (empty($url)) {
            echo "无图片";

        } else {
            $u = GrabImage($url, $id . ".jpg");
            $img_d = "update users set headimg_down=1 where openid='" . $id . "' ";
            $img_d = $GLOBALS['db']->query($img_d);
            echo $u . "下载成功";
            //echo $url;
        }

    }
}


?>