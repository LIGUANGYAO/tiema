<?php
header("Content-type: text/html; charset=utf-8");  
ini_set("error_reporting",E_ALL ^ E_NOTICE);
function content($type)
{
    switch ($type) {
        case 'text':
            $array = array();
            $array[0]['touser'] = 'osh4wuJuCSpUbW5SaZUJ5vTQI6Gc';
            $array[0]['content'] = '111';


            $res = array();
            foreach ($array as $resc) {


                $res['touser'] = $resc['touser'];
                $res['msgtype'] = 'text';
                $res['text']['content'] = urlencode($resc['content']);

                $datas = json_encode($res);
                $data[] = urldecode($datas);
            }

            break;
        case 'news':
            $array = array();
            for ($i = 0; $i < 1; $i++) {
                $array[$i]['touser'] = 'osh4wuJuCSpUbW5SaZUJ5vTQI6Gc';
                $array[$i]['msgtype'] = 'msgtype';
                $array[$i]['news']['articles'][0]['title'] = '新的工单：我要报修';
                $array[$i]['news']['articles'][0]['description'] =
                    '我要报修我要报修我要报修我要报修我要报修我要报修我要报修我要报修我要报修';
                $array[$i]['news']['articles'][0]['url'] = 'http://baidu.com';
                $array[$i]['news']['articles'][0]['picurl'] = 'http://www.baidu.com';

            }

            $res = array();
            foreach ($array as $resc) {
                $res['touser'] = $resc['touser'];
                $res['msgtype'] = 'news';
                $re = array();
                $res['news']['articles'] = array();
                foreach ($resc['news']['articles'] as $articles) {
                    $re['title'] = urlencode($articles['title']);
                    $re['description'] = urlencode($articles['description']);
                    $re['url'] = urlencode($articles['url']);
                    $re['picurl'] = urlencode($articles['picurl']);
                    $res['news']['articles'][] = $re;

                }

                $datas = json_encode($res);
                $data[] = urldecode($datas);
            }
            break;
    }
    return $data;
}

function send($data)
{
    $obj=new getArrToken();
    $result=$obj->getToken();
    //echo $result;
    foreach ($data as $res) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,
            "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$result.'");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT,
            'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $res);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo2 = curl_exec($ch);
        print_r($tmpInfo2);
        if (curl_errno($ch)) {
            echo 'Errno' . curl_error($ch);
        }
        curl_close($ch);
    }
}

?>