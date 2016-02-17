<?php


header("Content-type: text/html; charset=utf-8");
ini_set("error_reporting", E_ALL ^ E_NOTICE);


define('IN_ECS', true);
require (dirname(__file__) . '/includes/init.php');

require (dirname(__file__) . '/sub/sub_weixin_token.php');
//require (dirname(__file__) . '/sub/sub_weixin_send.php');


if (empty($_REQUEST['m'])) {
    $_REQUEST['m'] = 'default';
} else {
    $_REQUEST['m'] = trim($_REQUEST['m']);
}


if ($_REQUEST['m'] == 'wx_send_msgs2') {

    if (isset($_REQUEST['p_id'])) {
        $p_id = trim($_REQUEST['p_id']);
    }
    //echo $p_id;exit;
    if (empty($p_id)) {
        exit;
    }

    function https_request($data)
    {
        $obj = new getArrToken();
        $result = $obj->getToken();

        $type = "image";

        $data = array("media" => "@" . $data);
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=$result&type=$type";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);

        return $output;
    }

    function send($data)
    {
        $obj = new getArrToken();
        $result = $obj->getToken();
        //echo $result;
        //foreach ($data as $res) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,
            // "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$result.'");
            "https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token='.$result.'");

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
        //print_r($tmpInfo3);exit;
        //exit;
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
        } elseif ($tmpInfo3['errcode'] == '40007') {
            $error = "invalid media_id,媒体上传失败,图文模板图片,超过128K或者非JPG格式,请删除重新上传该图文";
            $msg = array('errcode' => '40007', 'errmsg' => $error);
            return $msg;
        } else {
            $msg = $tmpInfo3;

            return $msg;
            // print_r(json_encode($msg));
        }

        if (curl_errno($ch)) {
            echo 'Errno' . curl_error($ch);
        }
        curl_close($ch);
        //}
    }


    function mpnews($data)
    {
        $obj = new getArrToken();
        $result = $obj->getToken();
        //echo $result;
        //foreach ($data as $res) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,
            // "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$result.'");
            "https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$result.'");

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
        //print_r($tmpInfo3);exit;
        //exit;
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
        } elseif ($tmpInfo3['errcode'] == '40007') {
            $error = "invalid media_id,媒体上传失败,图文模板图片,超过128K或者非JPG格式,请删除重新上传该图文";
            $msg = array('errcode' => '40007', 'errmsg' => $error);
            return $msg;
        } else {
            $msg = $tmpInfo3;

            return $msg;
            // print_r(json_encode($msg));
        }

        if (curl_errno($ch)) {
            echo 'Errno' . curl_error($ch);
        }
        curl_close($ch);
        //}
    }

    function content_h($type, $list)
    {
        //print_r($list);exit;
        $obj = new getArrToken();
        $result = $obj->getToken();

        switch ($type) {

            case 'news':
                $array = array();


                function myjson($code) {
                    $code = json_encode(urlencodeAry($code));
                    return urldecode($code);
                }
                function urlencodeAry($data) {
                    if (is_array($data)) {
                        foreach ($data as $key => $val) {
                            $data[$key] = urlencodeAry($val);
                        }
                        return $data;
                    } else {
                        return urlencode($data);
                    }
                }

                function dotran($str) {
                    $str = str_replace('"', '//"', $str);
                    $str = str_replace("/r/n", '//r//n', $str);
                    $str = str_replace("/t", '//t', $str);
                    $str = str_replace("//", '//', $str);
                    $str = str_replace("/b", '//b', $str);
                    return $str;
                }

                function compress_html($string) {
                    $string = str_replace("\r\n", '', $string); //清除换行符
                    $string = str_replace("\n", '', $string); //清除换行符
                    $string = str_replace("\t", '', $string); //清除制表符
                    $pattern = array(
                        "/> *([^ ]*) *</", //去掉注释标记
                        "/[\s]+/",
                        "/<!--[^!]*-->/",
                        "/\" /",
                        "/ \"/",
                        "'/\*[^*]*\*/'");
                    $replace = array(
                        ">\\1<",
                        " ",
                        "",
                        "\"",
                        "\"",
                        "");
                    return preg_replace($pattern, $replace, $string);
                }

                //   //拼凑json
                //                $head = '{"articles":[';
                //
                //                $end = ']}';
                //                for ($i = 0; $i < count($list); $i++) {
                //
                //
                //                    $main1 = '{"thumb_media_id":"' . str_replace("\"", "'", $list[$i]['media_id']) .
                //                        '","author":"' . str_replace("\"", "'", $list[$i]['author']) . '","title":"' .
                //                        str_replace("\"", "'", $list[$i]['title']) . '","content_source_url":"' .
                //                        str_replace("\"", "'", $list[$i]['link']) . '","content":"' .dotran( str_replace("\"",
                //                        "'", $list[$i]['content']) ). '","digest":"' . str_replace("\"", "'", $list[$i]['digest']) .
                //                        '","show_cover_pic":"' . str_replace("\"", "'", $list[$i]['show_cover_pic']) .
                //                        '"}';
                //                    $m2 .= $main1;
                //                }
                //                $text = $head . $m2 . $end;
                //
                //                echo $text;
                //                exit;
                for ($i = 0; $i < count($list); $i++) {

                    $result = https_request(dirname(__file__) . "/" . $list[$i]['cover']);
                    //print_r($result);
                    $result = (array )json_decode($result);


                    //        //media_id
                    $array['articles'][$i]['thumb_media_id'] = urlencode($result['media_id']);
                    // echo $array['articles'][$i]['thumb_media_id'];
                    $array['articles'][$i]['author'] = urlencode(str_replace("\"", "'", $list[$i]['author']));
                    $array['articles'][$i]['title'] = urlencode(str_replace("\"", "'", $list[$i]['title']));
                    $array['articles'][$i]['content_source_url'] = urlencode(str_replace("\"", "'",
                        $list[$i]['link']));
                    // $array['articles'][$i]['content'] = str_replace("\"","'",addslashes($list[$i]['content']));
                    $array['articles'][$i]['content'] = urlencode(compress_html(str_replace("\"",
                        "'", $list[$i]['content'])));
                    // echo $array['articles'][$i]['content'];exit;

                    $array['articles'][$i]['digest'] = urlencode(str_replace("\"", "'", $list[$i]['digest']));
                    $array['articles'][$i]['show_cover_pic'] = urlencode($list[$i]['show_cover_pic']);


                }


                $datas = json_encode($array, JSON_HEX_TAG);
                //$datas=strtr($datas, array('<'=>'\u003C',">"=>'\u003E'));
                $data = urldecode($datas);


                //print_r($data);
                //                                exit;
                break;
        }
        return $data;
    }

    $se = "select sendmsg_sn,role,re_type,re_code from sendmsg where sendmsg_sn='" .
        $p_id . "'";
    $se = $GLOBALS['db']->getRow($se);


    function getAllopenid()
    {
        $sql = "select openid from users  where openid is not null";
        $res = $GLOBALS['db']->getAll($sql);

        return $res;
    }


    $ar2 = array();
    if ($se['role'] == 'All') {
        $user_list = getAllopenid();

        $ar = array();
        for ($i = 0; $i < count($user_list); $i++) {
            $ar[$i] = $user_list[$i]['openid'];
        }

        $ar2['touser'] = $ar;
        //print_r(json_encode($ar2));exit;
    } else {
        // $sql = "select openid from wx_users_group  where group_sn='" . $se['role'] . "'";
        //        $user_list = $GLOBALS['db']->getAll($sql);

        $sql = "select p_id,
                    openid,
                    users_sn,
                    nick_name,
                    status,
                    tzsy,
                    is_send,
                    err_code,
                    error from sendmsg_users where is_send =0 and p_id='" . $p_id .
            "' ";

        $res1 = $GLOBALS['db']->getAll($sql);
        //print_r($res);exit;

        if (empty($res1)) {
            $error = array(
                "errcode" => "999999",
                "errmsg" => "已经发送完毕",
                "nick_name" => "");
            print_r(json_encode($error));
            exit;
        }

        $ar = array();
        for ($i = 0; $i < count($res1); $i++) {
            $ar[$i] = $res1[$i]['openid'];
        }

        $ar2['touser'] = $ar;
    }

    //print_r($se);exit;
    if ($se['re_type'] == "text") {


        $text = "select text2 from text2_reply where text2_sn='" . $se['re_code'] . "'";
        $text_list = $GLOBALS['db']->getRow($text);

        $msg = $text_list['text2'];
        
        if (empty($msg)) {
            $error = array(
                "errcode" => "999999",
                "errmsg" => "发送失败,内容为空",
                "nick_name" => "");
            print_r(json_encode($error));
            exit;
        }
     //   {
//            "filter" : {
//                "group_id" : "2"}
//            , "text" : {
//                "content" : "CONTENT"}
//            , "msgtype" : "text"}
//
         $ar2['text']['content'] = urlencode($msg);
         $ar2['msgtype'] = "text";

         $sendlist = json_encode($ar2);
          $sendlist1 = urldecode($sendlist);
        //print_r($sendlist1);
        $err_date = mpnews($sendlist1);

        $up = "update sendmsg_users set is_send =1,err_code='" . $err_date['errcode'] .
            "',error='" . $err_date['errmsg'] . "' where p_id='" . $p_id . "'";

        $res = $GLOBALS['db']->query($up);

        print_r(json_encode($err_date));
        
        
        
        exit;


    } elseif ($se['re_type'] == "imgtext") {
        echo "高级群发无法使用普通图文,该群发无效";
        exit;


    } elseif ($se['re_type'] == "imgtext_h") {
        $imgtext = "select b.img_note_1 as title,b.img_note_2 as digest,b.img_note_3 as author,b.img_note_4 as content,b.show_cover_pic,b.b_img_url as cover,b.img_action_url as link from imgtext3 a,imgtext3_imgs b where a.imgtext3_sn=b.p_id and b.ss=1 and a.imgtext3_sn='" .
            $se['re_code'] . "'";


        $img_list = $GLOBALS['db']->getAll($imgtext);

        //     $imgtext = "select b.img_note_1 as title,b.img_note_2 as note,b.b_img_url as cover,b.img_action_url as link from imgtext2 a,imgtext2_imgs b where a.imgtext2_sn=b.p_id and b.ss=1 and a.imgtext2_sn='" .
        //            $se['re_code'] . "'";
        //
        //
        //        $img_list = $GLOBALS['db']->getAll($imgtext);

        //print_r($img_list) ;exit;
        $reuslt = content_h('news', $img_list);

        if ($error['errcode'] == 40007) {
            //
        } else {
            //    print_r($reuslt);
            //            exit;
            $error = send($reuslt);

            //print_r($error);exit;
            function sendmsg_h($sn, $type, $media_id, $created_at)
            {
                $one = "select sendmsg_sn  from sendmsg_h where sendmsg_sn='" . $sn . "'";
                $one = $GLOBALS['db']->getRow($one);
                if (empty($one)) {
                    $now_time = date('Y-m-d H:i:s', time());
                    $sql = "insert into sendmsg_h(sendmsg_sn,type,media_id,created_at,add_time) values ('" .
                        $sn . "','" . $type . "','" . $media_id . "','" . $created_at . "','" . $now_time .
                        "')";

                    $res = $GLOBALS['db']->query($sql);
                } else {
                    $sql = "update sendmsg_h set sendmsg_sn='" . $sn . "',type='" . $type .
                        "',media_id='" . $media_id . "',created_at='" . $created_at .
                        "' where sendmsg_sn='" . $sn . "'";

                    $res = $GLOBALS['db']->query($sql);
                }

            }
            sendmsg_h($p_id, $error['type'], $error['media_id'], $error['created_at']);


            $ar2['mpnews']['media_id'] = $error['media_id'];
            $ar2['msgtype'] = "mpnews";

            $sendlist = json_encode($ar2);


            //print_r($sendlist);
            //exit;
        }


        //将生成的批量发送的media_id保存在数据库里面$sendlist已经生成的需要发送的json


        $err_date = mpnews($sendlist);

        $up = "update sendmsg_users set is_send =1,err_code='" . $err_date['errcode'] .
            "',error='" . $err_date['errmsg'] . "' where p_id='" . $p_id . "'";

        $res = $GLOBALS['db']->query($up);

        print_r(json_encode($err_date));
        exit;


    }


}


?>