<?php


header("Content-type: text/html; charset=utf-8");
ini_set("error_reporting", E_ALL ^ E_NOTICE);


define('IN_ECS', true);
require (dirname(__file__) . '/includes/init.php');

require (dirname(__file__) . '/sub/sub_weixin_token.php');
//require (dirname(__file__) . '/sub/sub_weixin_send.php');


//$sql = "insert into msg_log(user_name) values('1')";
//$is_allow = $GLOBALS['db']->query($sql);


if (empty($_REQUEST['m'])) {
    $_REQUEST['m'] = 'default';
} else {
    $_REQUEST['m'] = trim($_REQUEST['m']);
}

if ($_REQUEST['m'] == 'wx_send') {
    if (isset($_REQUEST['openid'])) {
        $openid = trim($_REQUEST['openid']);
    }
    if (isset($_REQUEST['msg'])) {
        $msg = trim($_REQUEST['msg']);
        if (empty($msg)) {
            $msg = "无内容";
        }
    }

    class send_wx_msg
    {

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

    function send($data)
    {
        $obj = new getArrToken();
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
            if ($tmpInfo3['errcode'] == '45015') {
                $error = "发送失败,该用户48小时内未产生交互信息";
                $msg = array('errcode' => '0', 'errmsg' => $error);
                print_r(json_encode($msg));
            } elseif ($tmpInfo3['errcode'] == '40001') {
                $obj = new getArrToken();
                $result = $obj->resetToken();
                $error = "token失效";
                $msg = array('errcode' => '40001', 'errmsg' => $error);
                print_r(json_encode($msg));
            } elseif ($tmpInfo3['errcode'] == '0') {
                $error = "消息发送成功";
                $msg = array('errcode' => '0', 'errmsg' => $error);
                print_r(json_encode($msg));
            } else {
                print_r($tmpInfo2);
            }

            if (curl_errno($ch)) {
                echo 'Errno' . curl_error($ch);
            }
            curl_close($ch);
        }
    }
    $reuslt = content('text', $openid, $msg);
    //    print_r($reuslt)

    send($reuslt);
}


if ($_REQUEST['m'] == 'wx_send_msgs') {
    if (isset($_REQUEST['p_id'])) {
        $p_id = trim($_REQUEST['p_id']);
    }

    $sql = "select p_id,
                    openid,
                    users_sn,
                    nick_name,
                    status,
                    tzsy,
                    is_send,
                    err_code,
                    error from sendmsg_users where is_send =0 and p_id='" . $p_id .
        "' order by p_id,id  limit 1";

    $res = $GLOBALS['db']->getRow($sql);


    $msg = trim($_REQUEST['msg']);
    if (empty($msg)) {
        $msg = "无内容";
    }


    class send_wx_msg
    {

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
        $obj = new getArrToken();
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
            if ($tmpInfo3['errcode'] == '45015') {
                $error = "发送失败,该用户48小时内未产生交互信息";
                $msg = array('errcode' => '45015', 'errmsg' => $error);
                return $msg;
                // print_r(json_encode($msg));
            } elseif ($tmpInfo3['errcode'] == '40001') {
                $obj = new getArrToken();
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
                $msg = $tmpInfo2;

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
        //$openid="osh4wuJuCSpUbW5SaZUJ5vTQI6Gc";
        $openid = $res['openid'];
        $se = "select re_type,re_code from sendmsg where sendmsg_sn='" . $res['p_id'] .
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
            $error['nick_name'] = $res['nick_name'];
            print_r(json_encode($error));

        } elseif ($se['re_type'] == "imgtext") {
            $imgtext = "select b.img_note_1 as title,b.img_note_2 as note,b.b_img_url as cover,b.img_action_url as link from imgtext2 a,imgtext2_imgs b where a.imgtext2_sn=b.p_id and b.ss=1 and a.imgtext2_sn='" .
                $se['re_code'] . "'";
            $img_list = $GLOBALS['db']->getAll($imgtext);

            $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
            for ($i = 0; $i < count($img_list); $i++) {
                $img_list[$i]['cover'] = $url_this . "/" . $img_list[$i]['cover'];
            }
            //print_r($img_list);exit;


            //发送图文信息
            $reuslt = content2('news', $openid, $img_list);
            //$reuslt = content2('news', $openid, $img_list[0]['title'],$img_list[0]['note'],$img_list[0]['link'],$img_list[0]['cover']);


            $error = send($reuslt);
            //print_r($reuslt);exit;
            $error['nick_name'] = $res['nick_name'];
            print_r(json_encode($error));

        }

        //exit;
        $up = "update sendmsg_users set is_send =1,err_code='" . $error['errcode'] .
            "',error='" . $error['errmsg'] . "' where p_id='" . $p_id . "' and openid='" . $res['openid'] .
            "'";
        //echo $up;
        $res = $GLOBALS['db']->query($up);
    }

}


//增加预览列表
if ($_REQUEST['m'] == 'add_preview') {


    if (isset($_REQUEST['p_id']) && isset($_REQUEST['role'])) {
        $p_id = trim($_REQUEST['p_id']);
        $role = trim($_REQUEST['role']);

        $sql2 = "delete from preview_users where p_id='" . $p_id . "'";
        $sql2 = $GLOBALS['db']->query($sql2);
        $sql = "insert into preview_users(p_id,nick_name,users_sn,openid) select '" . $p_id .
            "',nick_name,users_sn,openid from wx_users_group where group_sn='" . $role . "'";
        $res = $GLOBALS['db']->query($sql);


        $error = array(
            "errcode" => $sql,
            "errmsg" => "临时发送组建立",
            "nick_name" => "");
        print_r(json_encode($error));
    } else {
        $error = array(
            "errcode" => "99",
            "errmsg" => "error",
            "nick_name" => "");
        print_r(json_encode($error));
    }


}


if ($_REQUEST['m'] == 'wx_send_preview') {
    if (isset($_REQUEST['p_id'])) {
        $p_id = trim($_REQUEST['p_id']);
    }

    $sql = "select p_id,
                    openid,
                    users_sn,
                    nick_name,
                    status,
                    tzsy,
                    is_send,
                    err_code,
                    error from preview_users where is_send =0 and p_id='" . $p_id .
        "' order by p_id,id  limit 1";

    $res = $GLOBALS['db']->getRow($sql);


    class send_wx_msg
    {

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
        $obj = new getArrToken();
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
            if ($tmpInfo3['errcode'] == '45015') {
                $error = "发送失败,该用户48小时内未产生交互信息";
                $msg = array('errcode' => '45015', 'errmsg' => $error);
                return $msg;
                // print_r(json_encode($msg));
            } elseif ($tmpInfo3['errcode'] == '40001') {
                $obj = new getArrToken();
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
                $msg = $tmpInfo2;

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
        //$openid="osh4wuJuCSpUbW5SaZUJ5vTQI6Gc";


        $openid = $res['openid'];
        $se = "select 'imgtext' as re_type,imgtext_sn as re_code,imgtext_name as re_code2 from imgtext where imgtext_sn='" .
            $p_id . "'";
        $se = $GLOBALS['db']->getRow($se);
        //$se['re_type']='imgtext';

        if ($se['re_type'] == "text") {

            $text = "select text from text_reply where text_sn='" . $se['re_code'] . "'";
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
            $error['nick_name'] = $res['nick_name'];
            print_r(json_encode($error));

        } elseif ($se['re_type'] == "imgtext") {
            $imgtext = "select b.img_note_1 as title,b.img_note_2 as note,b.b_img_url as cover,b.img_action_url as link from imgtext a,imgtext_imgs b where a.imgtext_sn=b.p_id and b.ss=1 and a.imgtext_sn='" .
                $se['re_code'] . "'";
            $img_list = $GLOBALS['db']->getAll($imgtext);

            $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
            for ($i = 0; $i < count($img_list); $i++) {
                $img_list[$i]['cover'] = $url_this . "/" . $img_list[$i]['cover'];
            }
            //print_r($img_list);exit;


            //发送图文信息
            $reuslt = content2('news', $openid, $img_list);
            //$reuslt = content2('news', $openid, $img_list[0]['title'],$img_list[0]['note'],$img_list[0]['link'],$img_list[0]['cover']);


            $error = send($reuslt);
            //print_r($reuslt);exit;
            $error['nick_name'] = $res['nick_name'];
            print_r(json_encode($error));

        }

        //exit;
        $up = "update preview_users set is_send =1,err_code='" . $error['errcode'] .
            "',error='" . $error['errmsg'] . "' where p_id='" . $p_id . "' and openid='" . $res['openid'] .
            "'";
        //echo $up;
        $res = $GLOBALS['db']->query($up);
    }

}


//app发送信息
if ($_REQUEST['m'] == 'app_send') {

    if (isset($_REQUEST['p_id'])) {
        $p_id = trim($_REQUEST['p_id']);
    }

    $sql = "select p_id,
                    openid,
                    users_sn,
                    nick_name,
                    status,
                    tzsy,
                    is_send,
                    err_code,push_id,
                    error from appsend_users where is_send =0 and p_id='" . $p_id .
        "' order by p_id,id  limit 1";

    $res = $GLOBALS['db']->getRow($sql);


    //  $sql1 = "select roll from appsend where tzsy=1 and appsend_sn='" . $p_id .
    //        "' ";
    //
    //    $res1 = $GLOBALS['db']->getRow($sql1);

    $msg = trim($_REQUEST['msg']);
    if (empty($msg)) {
        $msg = "无内容";
    }
    if (empty($res)) {
        $error = array(
            "errcode" => "999999",
            "errmsg" => "已经发送完毕",
            "nick_name" => "");
        print_r(json_encode($error));


    } else {

        $se = "select re_type,re_code from appsend where appsend_sn='" . $res['p_id'] .
            "'";
        $se = $GLOBALS['db']->getRow($se);


        if ($se['re_type'] == "text") {

            $text = "select title,text2 from text2_reply where text2_sn='" . $se['re_code'] .
                "'";
            $text_list = $GLOBALS['db']->getRow($text);

            $msg = $text_list['text2'];

            if (empty($msg)) {
                $msg = "无内容";
            }

            function dehtml($str)
            {
                $str = addslashes($str);
                $str = trim($str);
                $str = strip_tags($str, "");
                $str = str_replace("\t", "", $str);
                $str = str_replace("\r\n", "", $str);
                $str = str_replace("\r", "", $str);
                $str = str_replace("\n", "", $str);
                $str = str_replace("", "", $str);
                return trim($str);
            }

            //开始发送app推送信息
            require (dirname(__file__) . '/push/baidu/sample.php');
            $message = '{
            			"title": "' . dehtml($text_list['title']) . '",
            			"description": "' . dehtml($text_list['text2']) . '",
            			"notification_basic_style":7,
            			"open_type":0,
            			"url":"http:www.baidu.com",
                        "custom_content": {
            	           "receipts":"0"
            
            	       }
     		     }';
            //拼凑推送数组
            //$message = array(
            //                'title' => $text_list['title'],
            //                'description' => $text_list['text2'],
            //                'notification_basic_style' => '7',
            //                'open_type' => '0',
            //                'custom_content' => array('receipts' => 0));
            //print_r($message);exit;
            if ($res['push_id'] == 'All') {
                $list = tiemal_pushMessage_android('', '3', $message);
                //print_r($list);exit;
                $error = array();
                if ($list['response_params']['success_amount'] == 1) {
                    $error['errcode'] = '1';
                    $error['errmsg'] = '发送成功';
                    $error['nick_name'] = $res['nick_name'];
                    print_r(json_encode($error));
                } else {
                    $error['errcode'] = '0';
                    $error['errmsg'] = '机器id错误/程序已卸载';
                    $error['nick_name'] = $res['nick_name'];
                    print_r(json_encode($error));
                }
            } else {
                $list = tiemal_pushMessage_android($res['push_id'], '1', $message);
                //exit;
                $error = array();
                if ($list['response_params']['success_amount'] == 1) {
                    $error['errcode'] = '1';
                    $error['errmsg'] = '发送成功';
                    $error['nick_name'] = $res['nick_name'];
                    print_r(json_encode($error));
                } else {
                    $error['errcode'] = '0';
                    $error['errmsg'] = '机器id错误/程序已卸载';
                    $error['nick_name'] = $res['nick_name'];
                    print_r(json_encode($error));
                }
                //print_r($error['response_params']['success_amount']);
            }


        } elseif ($se['re_type'] == "imgtext") {
            $imgtext = "select b.img_note_1 as title,b.img_note_2 as note,b.b_img_url as cover,b.img_action_url as link from imgtext2 a,imgtext2_imgs b where a.imgtext2_sn=b.p_id and b.ss=1 and a.imgtext2_sn='" .
                $se['re_code'] . "'";
            $img_list = $GLOBALS['db']->getAll($imgtext);

            $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
            for ($i = 0; $i < count($img_list); $i++) {
                $img_list[$i]['cover'] = $url_this . "/" . $img_list[$i]['cover'];
            }
            //print_r($img_list);exit;


            //发送图文信息
            $reuslt = content2('news', $openid, $img_list);
            //$reuslt = content2('news', $openid, $img_list[0]['title'],$img_list[0]['note'],$img_list[0]['link'],$img_list[0]['cover']);


            $error = send($reuslt);
            //print_r($reuslt);exit;
            $error['nick_name'] = $res['nick_name'];
            print_r(json_encode($error));

        }

        //exit;
        $up = "update appsend_users set is_send =1,err_code='" . $error['errcode'] .
            "',error='" . $error['errmsg'] . "' where p_id='" . $p_id . "' and openid='" . $res['openid'] .
            "'";
        //echo $up;
        $res = $GLOBALS['db']->query($up);


    }


}


if ($_REQUEST['m'] == 'mbmsg') {
    function mbmsg($data)
    {
        $obj = new getArrToken();
        $result = $obj->getToken();
        
     
//echo $result;
            $ch = curl_init();
            $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$result.'";
            //echo $url;
            curl_setopt($ch, CURLOPT_URL,
                $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_USERAGENT,
                'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
            //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $tmpInfo2 = curl_exec($ch);
            $tmpInfo3 = (array )json_decode($tmpInfo2);
            print_r($tmpInfo3);
            //if ($tmpInfo3['errcode'] == '45015') {
            //                $error = "发送失败,该用户48小时内未产生交互信息";
            //                $msg = array('errcode' => '45015', 'errmsg' => $error);
            //                return $msg;
            //                // print_r(json_encode($msg));
            //            } elseif ($tmpInfo3['errcode'] == '40001') {
            //                $obj = new getArrToken();
            //                $result = $obj->resetToken();
            //                $error = "token失效";
            //                $msg = array('errcode' => '40001', 'errmsg' => $error);
            //                return $msg;
            //                // print_r(json_encode($msg));
            //            } elseif ($tmpInfo3['errcode'] == '0') {
            //                $error = "消息发送成功";
            //                $msg = array('errcode' => '0', 'errmsg' => $error);
            //                return $msg;
            //                // print_r(json_encode($msg));
            //            } else {
            //                $msg = $tmpInfo2;
            //
            //                return $msg;
            //                // print_r(json_encode($msg));
            //            }

          
            curl_close($ch);
        
    }
    //mbmsg("aaa");

    //拼凑json数据
    //$senddata = array(
//        "first" => array("value" => "黄先生", "color" => "#1ec7e6"),
//        "delivername" => array("value" => "顺丰快递", "color" => "#92B901"),
//        "ordername" => array("value" => "订单号：123456789", "color" => "#92B901"),
//        "remark" => array("value" => "自定义内容可以随便写", "color" => "#92B901"));
    
    $senddata = array(
        "name" => array("value" => "A00001", "color" => "#92B901"),
        "remark" => array("value" => "这块是自定义内容,", "color" => "#92B901"));

    $cojson = array(
        "touser" => "o9NG0jmFhogdI8p0o0StlhCL9U0Y",
        //"touser" => "o9NG0jp2gKGKFp66_eQCApaplKH0",
        //"touser" => "o9NG0jtgEJfHe5qrUqHUTXcrn3cs",
        "template_id" => "WAsY1C3kL-v7VKtbeNa5puMapdacsPgdQWVXt6Q9Za8",
        "url" => "",
        "topcolor" => "#FF0000",
        "data" => $senddata);


    function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
    {
        static $recursive_counter = 0;
        if (++$recursive_counter > 1000) {
            die('possible deep recursion attack');
        }
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                arrayRecursive($array[$key], $function, $apply_to_keys_also);
            } else {
                $array[$key] = $function($value);
            }

            if ($apply_to_keys_also && is_string($key)) {
                $new_key = $function($key);
                if ($new_key != $key) {
                    $array[$new_key] = $array[$key];
                    unset($array[$key]);
                }
            }
        }
        $recursive_counter--;
    }

    function json($array)
    {
        arrayRecursive($array, 'urlencode', true);
        $json = json_encode($array);
        return urldecode($json);
    }
    $data=json($cojson);
   
   
   
   
    mbmsg($data);
    //json实例
    //   {
    //        "touser" : "OPENID", "template_id" :
    //            "ngqIpbwh8bUfcSsECmogfXcV14J0tQlEpBO27izEYtY", "url" :
    //            "http://weixin.qq.com/download", "topcolor" : "#FF0000", "data" : {
    //            "User" : {
    //                "value" : "黄先生", "color" : "#173177"}
    //            , "Date" : {
    //                "value" : "06月07日 19时24分", "color" : "#173177"}
    //            , "CardNumber" : {
    //                "value" : "0426", "color" : "#173177"}
    //            , "Type" : {
    //                "value" : "消费", "color" : "#173177"}
    //            , "Money" : {
    //                "value" : "人民币260.00元", "color" : "#173177"}
    //            , "DeadTime" : {
    //                "value" : "06月07日19时24分", "color" : "#173177"}
    //            , "Left" : {
    //                "value" : "6504.09", "color" : "#173177"}
    //        }
    //    }

}


if ($_REQUEST['m'] == 'end') {
    function mbmsg($data)
    {
        $obj = new getArrToken();
        $result = $obj->getToken();
        
     
//echo $result;
            $ch = curl_init();
            $url="https://api.weixin.qq.com/merchant/order/close?access_token='.$result.'";
            //echo $url;
            curl_setopt($ch, CURLOPT_URL,
                $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_USERAGENT,
                'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
            //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $tmpInfo2 = curl_exec($ch);
            $tmpInfo3 = (array )json_decode($tmpInfo2);
            print_r($tmpInfo3);
           
          
            curl_close($ch);
        
    }
    
  
    $cojson = array(
        "order_id" => "13261985555638225492",
        );


    function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
    {
        static $recursive_counter = 0;
        if (++$recursive_counter > 1000) {
            die('possible deep recursion attack');
        }
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                arrayRecursive($array[$key], $function, $apply_to_keys_also);
            } else {
                $array[$key] = $function($value);
            }

            if ($apply_to_keys_also && is_string($key)) {
                $new_key = $function($key);
                if ($new_key != $key) {
                    $array[$new_key] = $array[$key];
                    unset($array[$key]);
                }
            }
        }
        $recursive_counter--;
    }

    function json($array)
    {
        arrayRecursive($array, 'urlencode', true);
        $json = json_encode($array);
        return urldecode($json);
    }
    $data=json($cojson);
   
   
   
   
    mbmsg($data);
    //json实例
    //   {
    //        "touser" : "OPENID", "template_id" :
    //            "ngqIpbwh8bUfcSsECmogfXcV14J0tQlEpBO27izEYtY", "url" :
    //            "http://weixin.qq.com/download", "topcolor" : "#FF0000", "data" : {
    //            "User" : {
    //                "value" : "黄先生", "color" : "#173177"}
    //            , "Date" : {
    //                "value" : "06月07日 19时24分", "color" : "#173177"}
    //            , "CardNumber" : {
    //                "value" : "0426", "color" : "#173177"}
    //            , "Type" : {
    //                "value" : "消费", "color" : "#173177"}
    //            , "Money" : {
    //                "value" : "人民币260.00元", "color" : "#173177"}
    //            , "DeadTime" : {
    //                "value" : "06月07日19时24分", "color" : "#173177"}
    //            , "Left" : {
    //                "value" : "6504.09", "color" : "#173177"}
    //        }
    //    }

}

?>