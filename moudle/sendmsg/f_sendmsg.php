<?php

define('IN_ECS', true);

error_reporting(E_ALL & ~ (E_STRICT | E_NOTICE));


require_once (dirname(dirname(__file__)) . '/service/init.php');
require_once (dirname(dirname(__file__)) . '/service/get_token.php');



$sql = "select a.p_id,
                    a.openid,
                    a.users_sn,
                    a.nick_name,
                    a.status,
                    a.tzsy,
                    a.is_send,
                    a.err_code,
                    a.error from sendmsg_users a inner join sendmsg b on a.p_id=b.sendmsg_sn where a.is_send =0 and b.is_auto=1 and b.tzsy=1";

$res = $GLOBALS['db']->getAll($sql);


$msg = trim($_REQUEST['msg']);
if (empty($msg)) {
    $msg = "无内容";
}


function content($type, $openid, $msg)
{
    switch ($type) {
        case 'text':
            $array = array();
            $array[0]['touser'] = $openid;
            //$array[0]['touser'] = 'osh4wuKGcSNz2jhQY1Rll4nx0Bm4';
            $array[0]['content'] = $msg;


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
                $array[$i]['touser'] = $openid;
                //$array[$i]['touser'] = 'osh4wuKGcSNz2jhQY1Rll4nx0Bm4';
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

function content2($type, $openid, $list)
{
    switch ($type) {

        case 'news':
            $array = array();
            for ($i = 0; $i < count($list); $i++) {
                $array[0]['touser'] = $openid;
                //$array[$i]['touser'] = 'osh4wuKGcSNz2jhQY1Rll4nx0Bm4';
                $array[0]['msgtype'] = 'msgtype';
                $array[0]['news']['articles'][$i]['title'] = $list[$i]['title'];
                $array[0]['news']['articles'][$i]['description'] = $list[$i]['note'];
                $array[0]['news']['articles'][$i]['url'] = $list[$i]['link'];
                $array[0]['news']['articles'][$i]['picurl'] = $list[$i]['cover'];
                //$reuslt = content2('news', $openid, $img_list[0]['title'],$img_list[0]['note'],$img_list[0]['link'],$img_list[0]['cover']);
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
    $obj = new getArr();
    $result = $obj->getToken();
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
        $tmpInfo3 = (array )json_decode($tmpInfo2);
        //print_r($tmpInfo3);
        if ($tmpInfo3['errcode'] == '45015') {
            $error = "发送失败,该用户48小时内未产生交互信息";
            $msg = array('errcode' => '45015', 'errmsg' => $error);
            return $msg;
            // print_r(json_encode($msg));
        } elseif ($tmpInfo3['errcode'] == '40001') {
            $obj = new getArr();
            $result = $obj->resetToken();
            $error = "token失效";
            $msg = array('errcode' => '40001', 'errmsg' => $error);
            return $msg;
            // print_r(json_encode($msg));
        } elseif ($tmpInfo3['errcode'] == '0') {
            $error = "消息发送成功";
            $msg = array('errcode' => '0', 'errmsg' => $error);
            return $msg;
            // print_r(json_encode($msg));
        } else {
            $msg = $tmpInfo3;

            return $msg;
            // print_r(json_encode($msg));
        }

        if (curl_errno($ch)) {
            echo 'Errno' . curl_error($ch);
        }
        curl_close($ch);
    }
}


if (empty($res)) {
    $error = array(
        "errcode" => "999999",
        "errmsg" => "已经发送完毕",
        "nick_name" => "");
    print_r(json_encode($error));
} else {
 
    
//    exit;
    for ($i = 0; $i < count($res); $i++) {
        $openid = $res[$i]['openid'];
        $p_id2 = $res[$i]['p_id'];
        
        $se = "select re_type,re_code from sendmsg where sendmsg_sn='" . $res[$i]['p_id'] .
            "'";
        $se = $GLOBALS['db']->getRow($se);
        
        
        if ($se['re_type'] == "text") {

            $text = "select text2 from text2_reply where text2_sn='" . $se['re_code'] . "'";
            $text_list = $GLOBALS['db']->getRow($text);
            
            $msg = $text_list['text2'];
          
            if (empty($msg)) {
                $msg = "无内容";
            }
             
            //echo $msg;exit;
            //$msg = $res['nick_name'] . "\n关注联兴,天天签到有礼";
            $reuslt = content('text', $openid, $msg);
            //    print_r($reuslt)

            $error = send($reuslt);
            $error['nick_name'] = $res[$i]['nick_name'];
            
           // print_r($error);
            print_r(json_encode($error));

        } elseif ($se['re_type'] == "imgtext") {
            $imgtext = "select b.img_note_1 as title,b.img_note_2 as note,b.b_img_url as cover,b.img_action_url as link from imgtext2 a,imgtext2_imgs b where a.imgtext2_sn=b.p_id and b.ss=1 and a.imgtext2_sn='" .
                $se['re_code'] . "'";
            $img_list = $GLOBALS['db']->getAll($imgtext);
            
            
            $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" .dirname(dirname( dirname($_SERVER['PHP_SELF'])) );
            //echo $_SERVER["DOCUMENT_ROOT"];exit;
            for ($j = 0; $j < count($img_list); $j++) {
                $img_list[$j]['cover'] = "http://" .C_ADDRESS . "/" . $img_list[$j]['cover'];
            }
            
            

            //发送图文信息
            $reuslt = content2('news', $openid, $img_list);
            //$reuslt = content2('news', $openid, $img_list[0]['title'],$img_list[0]['note'],$img_list[0]['link'],$img_list[0]['cover']);
           // print_r($reuslt);
            $error = send($reuslt);
            $reuslt='';
            $img_list='';
            
            //print_r($reuslt);
            //print_r($reuslt);exit;
            $error['nick_name'] = $res[$i]['nick_name'];
            print_r(json_encode($error));

        }
      
        //exit;
        $up = "update sendmsg_users set is_send =1,err_code='" . $error['errcode'] .
            "',error='" . $error['errmsg'] . "' where p_id='" . $p_id2 . "' and openid='" . $openid .
            "'";
        //echo $up;
        $res11 = $GLOBALS['db']->query($up);
    }


}
