<?php

class getArrToken
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
    public function resetToken()
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
       

            $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                $APPID . "&secret=" . $APPSECRET;

            $json = file_get_contents($TOKEN_URL);
            $result = json_decode($json);
            //print_r($result);
            //exit;

            $ACC_TOKEN = $result->access_token;
            $time = date('Y-m-d H:i:s', time());
            $u_acc_token = "update temporary_tb set access_token='" . $ACC_TOKEN .
                "',last_update='" . $time . "' where type=1 and app_id=1";
            $u_acc_token = $GLOBALS['db']->query($u_acc_token);
        

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

?>