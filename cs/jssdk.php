<?php
class JSSDK
{
    private $appId;
    private $appSecret;

    public function __construct($appId, $appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    public function getSignPackage()
    {
        $jsapiTicket = $this->getJsApiTicket();

        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] ==
            443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array("appId" => $this->appId, "nonceStr" => $nonceStr,
            "timestamp" => $timestamp, "url" => $url, "signature" => $signature, "rawString" =>
            $string);
        return $signPackage;
    }

    private function createNonceStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket()
    {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(file_get_contents("jsapi_ticket.json"));
        if ($data->expire_time < time()) {
            $accessToken = $this->getAccessToken();
            // 如果是企业号用以下 URL 获取 ticket
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode($this->httpGet($url));
            $ticket = $res->ticket;
            if ($ticket) {
                $data->expire_time = time() + 7000;
                $data->jsapi_ticket = $ticket;
                $fp = fopen("jsapi_ticket.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $ticket = $data->jsapi_ticket;
        }

        return $ticket;
    }

    private function getAccessToken2()
    {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(file_get_contents("access_token.json"));
        if ($data->expire_time < time()) {
            // 如果是企业号用以下URL获取access_token
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
            $res = json_decode($this->httpGet($url));
            $access_token = $res->access_token;
            if ($access_token) {
                $data->expire_time = time() + 7000;
                $data->access_token = $access_token;
                $fp = fopen("access_token.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $access_token = $data->access_token;
        }
        return $access_token;
    }


    private function getAccessToken()
    {
        $get_app = "select app_id ,app_secret from app_id where weixin_id=1";
        $get_app = $GLOBALS['db']->getRow($get_app);
        //print_r($get_app);exit;

        $APPID = $get_app['app_id'];
        $APPSECRET = $get_app['app_secret'];


        $a_token_time = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
        $a_token_time = $GLOBALS['db']->getRow($a_token_time);


        $time_diff = $this->get_time_diff($a_token_time['last_update']);

        if ($time_diff['second'] >= 3600 or $time_diff['second'] <= -1) {

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
            //print_r($a_token_time2);exit;
            return $a_token_time2['access_token'];
        }
    }


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


    private function httpGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }
}
