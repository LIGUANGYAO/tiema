<?php
/*
* 微信会员下载
*/

define('IN_ECS', true);

error_reporting(E_ALL & ~ (E_STRICT | E_NOTICE));


require_once (dirname(dirname(__file__)) . '/service/init.php');


//会员全量更新
class getArr
{
    public $reqUrl = '';
    public $openid;
    public $next = '';
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
            getToken() . "&next_openid=" . $this->next;

        //print_r($MENU_URL);
        $json = file_get_contents($MENU_URL);
        $result = json_decode($json);
        //print_r($result);exit;
        //递归stdClass Object 对象


        $result2 = $this->objtoarr($result);
        return $result2;


    }
    public function objtoarr($obj)
    {
        $ret = array();
        foreach ($obj as $key => $value) {
            if (gettype($value) == 'array' || gettype($value) == 'object') {
                $ret[$key] = $this->objtoarr($value);
            } else {
                $ret[$key] = $value;
            }
        }
        return $ret;
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
        // function objtoarr2($obj)
        //        {
        //            $ret = array();
        //            foreach ($obj as $key => $value) {
        //                if (gettype($value) == 'array' || gettype($value) == 'object') {
        //                    $ret[$key] = objtoarr2($value);
        //                } else {
        //                    $ret[$key] = $value;
        //                }
        //            }
        //            return $ret;
        //        }
        $result2 = $this->objtoarr($result);
        //$result2 = objtoarr2($result);
        return $result2;

    }


}


$ex = new getArr();

$obj = $ex->getOpenid();
$count_sl = (int)$obj['count'];
$oplist = $obj['data']['openid'];
$down_sl = ceil($obj['total'] / 10000);


//----
$sql = "update users set  l_att=0";
$sql = $GLOBALS['db']->query($sql);

//----

$ACC_TOKEN = $ex->getToken();

for ($k = 0; $k < $down_sl; $k++) {

    if ($k == 0) {

        $count_sl = (int)$obj['count'];
        $next = $obj['next_openid'];
        for ($i = 0; $i < $count_sl; $i++) {

            $ex->openid = $obj['data']['openid'][$i];
            //          print_r($ex->openid);
            $opend_msg = $ex->getopen();

            $opend_msg['nickname'] = addslashes($opend_msg['nickname']);
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
                    $last_update_2 = date('Y-m-d', time());


                    $values = "'" . $opend_msg['subscribe_time'] . "','" . $opend_msg['openid'] .
                        "','" . $opend_msg['language'] . "','" . $opend_msg['city'] . "','" . $opend_msg['province'] .
                        "','" . $opend_msg['country'] . "','" . $opend_msg['headimgurl'] . "','" . $opend_msg['nickname'] .
                        "','" . $add_time . "','" . $last_update_2 . "','".$opend_msg['sex'] ."'";
                    $sql = "insert into users(subscribe_time,openid,language,city,province,country,headimgurl,nick_name,add_time,last_update_2,sex) values (" .
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
                        "',sex='".$opend_msg['sex'] ."' where openid='" . $opend_msg['openid'] . "'";
                    $up = $GLOBALS['db']->query($up);

                    //GrabImage($opend_msg['headimgurl'],$opend_msg['openid']);
                    echo "  已刷新";
                }


                // print_r($opend_msg['openid']."  ".$opend_msg['nickname']);
            }


            $sql2 = "update users set  l_att=1 where openid ='" . $opend_msg['openid'] .
                "'";
            $sql2 = $GLOBALS['db']->query($sql2);
        }
        echo "第" . ($k + 1) . "组下载结束";
    } else {

        $ex->next = $next;
        //echo $next;
        $obj = $ex->getOpenid($next);

        //print_r($obj);exit;
        $count_sl = (int)$obj['count'];
        for ($i = 0; $i < $count_sl; $i++) {

            $ex->openid = $obj['data']['openid'][$i];
            //          print_r($ex->openid);
            $opend_msg = $ex->getopen();

            $opend_msg['nickname'] = addslashes($opend_msg['nickname']);
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
                    $last_update_2 = date('Y-m-d', time());


                    $values = "'" . $opend_msg['subscribe_time'] . "','" . $opend_msg['openid'] .
                        "','" . $opend_msg['language'] . "','" . $opend_msg['city'] . "','" . $opend_msg['province'] .
                        "','" . $opend_msg['country'] . "','" . $opend_msg['headimgurl'] . "','" . $opend_msg['nickname'] .
                        "','" . $add_time . "','" . $last_update_2 . "','".$opend_msg['sex'] ."'";
                    $sql = "insert into users(subscribe_time,openid,language,city,province,country,headimgurl,nick_name,add_time,last_update_2,sex) values (" .
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
                        "',sex='".$opend_msg['sex'] ."' where openid='" . $opend_msg['openid'] . "'";
                    $up = $GLOBALS['db']->query($up);

                    //GrabImage($opend_msg['headimgurl'],$opend_msg['openid']);
                    echo "  已刷新";
                }


                // print_r($opend_msg['openid']."  ".$opend_msg['nickname']);

                $sql2 = "update users set  l_att=1 where openid ='" . $opend_msg['openid'] .
                    "'";
                $sql2 = $GLOBALS['db']->query($sql2);
            }
        }
        echo "第" . ($k + 1) . "组下载结束";
        //echo $next;
    }


}



$s_att = "update users set  is_att=l_att";
$s_att = $GLOBALS['db']->query($s_att);
//next_openid
//print_r($obj);
exit;

/*

function set_att($arr)
{
for($i=0;$i<count($arr);$i++)
{
$d1="'";$d2="',";
if($i==count($arr)-1)
{
$d2="'";
}
$sn.=$d1.$arr[$i].$d2;

}
// echo $sn;
$sql="update users set  is_att=0";
$sql = $GLOBALS['db']->query($sql);
$sql2="update users set  is_att=1 where openid in (".$sn.")";
$sql2 = $GLOBALS['db']->query($sql2);
}
set_att($oplist);
exit;
*/
