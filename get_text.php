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
        public $text;
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
              $get_app = "select app_id ,app_secret from app_id where weixin_id=2";
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
                //https://api.weixin.qq.com/cgi-bin/user/get?access_token=ACCESS_TOKEN&next_text=NEXT_text


                $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                    $APPID . "&secret=" . $APPSECRET;

                $json = file_get_contents($TOKEN_URL);
                $result = json_decode($json);
                //print_r($result);exit;

                $ACC_TOKEN = $result->access_token;
                $time = date('Y-m-d H:i:s', time());
                $u_acc_token = "update temporary_tb set access_token='".$ACC_TOKEN."',last_update='".$time."' where type=1 and app_id=1";
                $u_acc_token = $GLOBALS['db']->query($u_acc_token);
                return $ACC_TOKEN;
          //  $a_token_time = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
//            $a_token_time = $GLOBALS['db']->getRow($a_token_time);
//            //print_r($a_token_time);exit;
//
//            $time_diff = $this->get_time_diff($a_token_time['last_update']);
//            //print_r($time_diff['mintue']);
//            //exit;
//            if ($time_diff['mintue'] >= 7000 or $time_diff['mintue'] <= -1 ) {
//
//                $get_app = "select app_id ,app_secret from app_id where weixin_id=2";
//                $get_app = $GLOBALS['db']->getRow($get_app);
//                //print_r($get_app);exit;
//
//                $APPID = $get_app['app_id'];
//                $APPSECRET = $get_app['app_secret'];
//                if (empty($APPID)) {
//                    echo "appid missing";
//                    exit;
//                } elseif (empty($APPSECRET)) {
//                    echo "appsecret missing";
//                    exit;
//                } else {
//
//                }
//                //https://api.weixin.qq.com/cgi-bin/user/get?access_token=ACCESS_TOKEN&next_text=NEXT_text
//
//
//                $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
//                    $APPID . "&secret=" . $APPSECRET;
//
//                $json = file_get_contents($TOKEN_URL);
//                $result = json_decode($json);
//                //print_r($result);exit;
//
//                $ACC_TOKEN = $result->access_token;
//                $time = date('Y-m-d H:i:s', time());
//                $u_acc_token = "update temporary_tb set access_token='".$ACC_TOKEN."',last_update='".$time."' where type=1 and app_id=1";
//                $u_acc_token = $GLOBALS['db']->query($u_acc_token);
//                return $ACC_TOKEN;
//            }
//            else
//            {
//                //echo $a_token_time['access_token'];exit;
//                return $a_token_time['access_token'];
//            }
        }

        public function gettext()
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
            //https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&text=text&lang=zh_CN
            $MENU_URL = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $this->
                getToken() . "&text=" . $this->text . "&lang=zh_CN";

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
        $obj = $ex->gettext();
        //            print_r($obj);
        $ex->text = $obj['data']['text'][$id];
        //          print_r($ex->text);
        $opend_msg = $ex->getopen();
        if ($opend_msg['errcode'] != 0) {
            //   echo "api freq out of limit";
            print_r($opend_msg);
        } else {
            //print_r($opend_msg) ;
            print_r($opend_msg['text'] . "  " . $opend_msg['nickname']);
            $user_id = "select id from users where text='" . $opend_msg['text'] . "'";
            $user_id2 = $GLOBALS['db']->getRow($user_id);
            if (empty($user_id2)) {
                $values = "'" . $opend_msg['subscribe_time'] . "','" . $opend_msg['text'] .
                    "','" . $opend_msg['language'] . "','" . $opend_msg['city'] . "','" . $opend_msg['province'] .
                    "','" . $opend_msg['country'] . "','" . $opend_msg['headimgurl'] . "','" . $opend_msg['nickname'] .
                    "'";
                $sql = "insert into users(subscribe_time,text,language,city,province,country,headimgurl,nick_name) values (" .
                    $values . ")";
                $opq = $GLOBALS['db']->query($sql);
                $uid = "select id from users where text='" . $opend_msg['text'] . "'";
                $uid = $GLOBALS['db']->getRow($uid);
                //print_r($uid) ;
                $var = sprintf("%09d", $uid['id']);
                //echo $var;
                $sql2 = "update users set users_sn=concat('WXVIP','" . $var .
                    "') where text='" . $opend_msg['text'] . "'";
                //echo $sql2;
                $opq2 = $GLOBALS['db']->query($sql2);

                //添加图片

                //GrabImage($opend_msg['headimgurl'],$opend_msg['text']);

                echo "添加成功";
            } else {
                $up = "update users set subscribe_time='" . $opend_msg['subscribe_time'] .
                    "',language='" . $opend_msg['language'] . "',city='" . $opend_msg['city'] .
                    "',province='" . $opend_msg['province'] . "',country='" . $opend_msg['country'] .
                    "',headimgurl='" . $opend_msg['headimgurl'] . "',nick_name='" . $opend_msg['nickname'] .
                    "' where text='" . $opend_msg['text'] . "'";
                $up = $GLOBALS['db']->query($up);

                //GrabImage($opend_msg['headimgurl'],$opend_msg['text']);
                echo "  已刷新";
            }


            // print_r($opend_msg['text']."  ".$opend_msg['nickname']);
        }


    }


    exit;

}


if ($_REQUEST['act'] == 'increment') {
    class getArr
    {
        public $reqUrl = '';
        public $text;
        public $next_text;
        public function getToken()
        {
            $get_app = "select app_id ,app_secret from app_id where weixin_id=2";
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
            //https://api.weixin.qq.com/cgi-bin/user/get?access_token=ACCESS_TOKEN&next_text=NEXT_text


            $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                $APPID . "&secret=" . $APPSECRET;

            $json = file_get_contents($TOKEN_URL);
            $result = json_decode($json);
            //print_r($result);exit;

            $ACC_TOKEN = $result->access_token;
            return $ACC_TOKEN;
        }

        public function gettext()
        {
            $MENU_URL = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=" . $this->
                getToken() . "&next_text=" . $this->next_text;
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
            //https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&text=text&lang=zh_CN
            $MENU_URL = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $this->
                getToken() . "&text=" . $this->text . "&lang=zh_CN";

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
        $next_text = "select val from increment_log where tb_name='users' and f_name='next_text'";
        $next_text = $GLOBALS['db']->getRow($next_text);
        //echo $next_text['val'];exit;
        // echo $id;
        //        echo $now_time;
        $ex = new getArr();

        $next_text = "select val from increment_log where tb_name='users' and f_name='next_text'";
        $next_text = $GLOBALS['db']->getRow($next_text);
        $ex->next_text = $next_text['val'];
        $obj = $ex->gettext();
        //print_r($obj);exit;
        $ex->text = $obj['data']['text'][$id];

        //          print_r($ex->text);
        $opend_msg = $ex->getopen();
        //print_r($opend_msg);exit;
        if ($opend_msg['errcode'] != 0) {
            //   echo "api freq out of limit";
            //print_r($opend_msg) ;
            echo "无记录";
        } else {
            //print_r($opend_msg) ;
            print_r($opend_msg['text'] . "  " . $opend_msg['nickname']);
            //$user_id="select id from users where text='".$opend_msg['text']."'";
            //$user_id2 = $GLOBALS['db']->getRow($user_id);
            if (empty($user_id2)) {
                $values = "'" . $opend_msg['subscribe_time'] . "','" . $opend_msg['text'] .
                    "','" . $opend_msg['language'] . "','" . $opend_msg['city'] . "','" . $opend_msg['province'] .
                    "','" . $opend_msg['country'] . "','" . $opend_msg['headimgurl'] . "','" . $opend_msg['nickname'] .
                    "'";
                $sql = "insert into users(subscribe_time,text,language,city,province,country,headimgurl,nick_name) values (" .
                    $values . ")";
                $opq = $GLOBALS['db']->query($sql);
                $uid = "select id from users where text='" . $opend_msg['text'] . "'";
                $uid = $GLOBALS['db']->getRow($uid);
                //print_r($uid) ;
                $var = sprintf("%09d", $uid['id']);
                //echo $var;
                $sql2 = "update users set users_sn=concat('WXVIP','" . $var .
                    "') where text='" . $opend_msg['text'] . "'";
                //echo $sql2;
                $opq2 = $GLOBALS['db']->query($sql2);


                $u_next_opid = "update increment_log set val='" . $opend_msg['text'] .
                    "' where  tb_name='users' and f_name='next_text'";
                //echo $sql2;
                $u_next_opid = $GLOBALS['db']->query($u_next_opid);


                //下载头像图片;
                //GrabImage($opend_msg['headimgurl'],$opend_msg['text']);
                echo "添加成功";
            } else {
                $u_next_opid = "update increment_log set val='" . $opend_msg['text'] .
                    "' where  tb_name='users' and f_name='next_text'";
                //echo $sql2;
                $u_next_opid = $GLOBALS['db']->query($u_next_opid);

                $up = "update users set subscribe_time='" . $opend_msg['subscribe_time'] .
                    "',language='" . $opend_msg['language'] . "',city='" . $opend_msg['city'] .
                    "',province='" . $opend_msg['province'] . "',country='" . $opend_msg['country'] .
                    "',headimgurl='" . $opend_msg['headimgurl'] . "',nick_name='" . $opend_msg['nick_name'] .
                    "' where text='" . $opend_msg['text'] . "'";
                $up = $GLOBALS['db']->query($up);


                //GrabImage($opend_msg['headimgurl'],$opend_msg['text']);
                echo "  已刷新";
            }


            // print_r($opend_msg['text']."  ".$opend_msg['nickname']);
        }


    }


}

if ($_REQUEST['act'] == 'de3') {

    //会员全量更新
    class getArr
    {
        public $reqUrl = '';
        public $text;
        public function getToken()
        {
            $get_app = "select app_id ,app_secret from app_id where weixin_id=2";
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
            //https://api.weixin.qq.com/cgi-bin/user/get?access_token=ACCESS_TOKEN&next_text=NEXT_text


            $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                $APPID . "&secret=" . $APPSECRET;

            $json = file_get_contents($TOKEN_URL);
            $result = json_decode($json);
            //print_r($result);exit;

            $ACC_TOKEN = $result->access_token;
            return $ACC_TOKEN;
        }

        public function gettext()
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
    $obj = $ex->gettext();
    print_r((int)$obj['count']);


}

if ($_REQUEST['act'] == 'get_img') {
    if(isset($_REQUEST['img_url']) && isset($_REQUEST['id']))
    {
        $url=$_REQUEST['img_url'];
        $id=$_REQUEST['id'];
        //echo $id;
        if(empty($url))
        {
            echo "无图片";
            
        }
        else
        {
            $u=GrabImage($url,$id.".jpg");
            $img_d = "update users set headimg_down=1 where text='".$id."' ";
            $img_d = $GLOBALS['db']->query($img_d);
            echo $u."下载成功";
            //echo $url;
        }
        
    }
}


?>