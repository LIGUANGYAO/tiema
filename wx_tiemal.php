<?php
/**
 * 1. 上传此文件到你的服务器
 * 2. 登录微信公众平台接口配置信息,会看的都明白.
 */
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_NOTICE);
header('Content-Type: text/html; charset=utf-8');


//铁马新增-------------------------------------------------
define('IN_ECS', true);
require (dirname(__file__) . '/includes/init2.php');
require (dirname(__file__) . '/sub/sub_wx.php');


$appdir = dirname(__file__);
require $appdir . '/w.php';


//获取token
$token = get_tk();
//echo $token;
$n_time = date('Y-m-d H:i:s', time());
define('CUSTOMER', 'YATE');


if (W::isGET()) {
    W::valid($token);
}

if (W::isPOST()) {
    $post = $GLOBALS["HTTP_RAW_POST_DATA"];
    $xml = simplexml_load_string($post, 'SimpleXMLElement', LIBXML_NOCDATA);
    $content = trim($xml->Content); // 获取消息内容
    $type = strtolower($xml->MsgType);
    $openid = $xml->FromUserName;


    //判断该openid是否已经有操作session
    $exe = new wx_response();
    $exe->openid = $openid;
    $exe->in_response();
    $list = $exe->get_response();


    //  if ($content=="999") //添加为yate商品查询的二次开发
    //         {
    //            $data=$list['openid'];
    //            exit(W::response($xml, $data));


    //判断是否回话过期

    /* $sqlb = "select add_time from users_infolist where openid='" . $openid .
    "' order by add_time desc limit 1";
    $resb = $GLOBALS['db']->getRow($sqlb);
    if (!empty($resb)) {
    $uu = get_time_diff($resb['add_time']);


    if ($uu['mintue'] >= 10) {
    $exe->openid = $openid;
    $exe->p_id = "";
    $exe->response_sn = "";
    $sql = $exe->update_response();
    //
    $sqlb = "update users set free_type=1  where openid='" . $openid . "'";
    $resb = $GLOBALS['db']->getRow($sqlb);
    //$data = "上次操作超时,已自动退出!";
    //             exit(W::response($xml, $data));
    }
    }*/


    // 接收 位置
    if ($type == 'location') {


        //$distance = W::getDistance($xml->Location_X, $xml->Location_Y, 24.8907,
        //            118.5999923) . '公里';
        //        exit(W::response($xml, $distance));

        $imgtext = "select a.lbs_name as title,a.lbs_note_1 as note,b.b_img_url as cover,b.img_action_url as link,a.lbsjd,a.lbswd from lbs a,lbs_imgs b where a.lbs_sn=b.p_id and b.ss=1 and a.tzsy=0";
        $img_list2 = $GLOBALS['db']->getAll($imgtext);
        
        $img_list=array();
        for($k=0;$k<count($img_list2);$k++)
        {
            $distance = W::getDistance($xml->Location_X, $xml->Location_Y, $img_list2[$k]['lbswd'],$img_list2[$k]['lbsjd']);
            //exit(W::response($xml, $distance.$img_list2[$k]['lbsjd'].$img_list2[$k]['lbswd']));
            if($distance<20)
            {
                array_push($img_list,$img_list2[$k]);
            }
        }
        
        $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
        for ($i = 0; $i < count($img_list); $i++) {
            $img_list[$i]['cover'] = $url_this . "/" . $img_list[$i]['cover'];
        }
        $data = $img_list;

        exit(W::response($xml, $data, 'news'));


    } elseif ($type == 'text' || $type == 'image' || $type == 'voice') {


        if (!empty($content)) {
            $sqla = "select nick_name from users where openid='" . $openid . "'";
            $resa = $GLOBALS['db']->getAll($sqla);
            $nick_name = $resa[0]['nick_name'];
            $add_time = date('Y-m-d H:i:s', time());
            $last_update_2 = date('Y-m-d', time());
            $sql = "insert into users_infolist(openid,nick_name,type,content,add_time,last_update_2) values('" .
                $openid . "','" . $nick_name . "','" . $type . "','" . $content . "','" . $add_time .
                "','" . $last_update_2 . "') ";
            $res = $GLOBALS['db']->query($sql);
        }
        //         }
        if (empty($list['p_id'])) {
            //$data=$list['openid'];
            //            exit(W::response($xml, $data));
            //-------------------------------默认不用修改

            for ($k = 0; $k < count($custom_list); $k++) {
                if ($content == $custom_list[$k]['custom_name']) {
                    if ($custom_list[$k]['re_type'] == 'text') {
                        $text = "select text from text_reply where text_sn='" . $custom_list[$k]['re_code'] .
                            "'";
                        $text_list = $GLOBALS['db']->getRow($text);
                        $data = $text_list['text'];
                        exit(W::response($xml, $data));
                    } elseif ($custom_list[$k]['re_type'] == 'imgtext') {
                        $imgtext = "select b.img_note_1 as title,b.img_note_2 as note,b.b_img_url as cover,b.img_action_url as link from imgtext a,imgtext_imgs b where a.imgtext_sn=b.p_id and b.ss=1 and a.imgtext_sn='" .
                            $custom_list[$k]['re_code'] . "'";
                        $img_list = $GLOBALS['db']->getAll($imgtext);

                        $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
                        for ($i = 0; $i < count($img_list); $i++) {
                            $img_list[$i]['cover'] = $url_this . "/" . $img_list[$i]['cover'];
                        }
                        $data = $img_list;
                        exit(W::response($xml, $data, 'news'));
                    } elseif ($custom_list[$k]['re_type'] == 'url') {
                        $url = "select actionurl_sn,actionurl_name,url from actionurl where actionurl_sn='" .
                            $custom_list[$k]['re_code'] . "'";
                        $url = $GLOBALS['db']->getRow($url);
                        $urltext = "<a href='" . $url['url'] . "'>" . $url['actionurl_name'] . "</a>";
                        $data = $urltext;
                        exit(W::response($xml, $data));
                    } elseif ($custom_list[$k]['re_type'] == 'html') {
                        $html = "select article_sn,article_name from article where article_sn='" . $custom_list[$k]['re_code'] .
                            "'";
                        $html = $GLOBALS['db']->getRow($html);

                        $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
                        $htmlname = 'html_' . $html['article_sn'];
                        $url_this = $url_this . "/" . $htmlname . ".html";
                        $urltext = "<a href='" . $url_this . "'>" . $html['article_name'] . "</a>";
                        $data = $urltext;
                        exit(W::response($xml, $data));
                    }


                }


            }


            //单独关键字可以这样设置
            $exx = new wx_custom2();
            $exx->custom_sn = "RE_POINTS"; //获取关键字中为该字符的回复信息
            $exx->content = $content;
            $respone = $exx->get_response();


            if ($respone == "error") {

            } else {

                $exe->p_id = "RE_POINTS"; //将状态表设置成为这个状态
                $exe->response_sn = "";
                $sql = $exe->update_response();
                if (is_array($respone)) {
                    exit(W::response($xml, $respone, 'news'));
                } else {
                    exit(W::response($xml, $respone));
                }
            }

            //个人中心
            $exx->custom_sn = "MEMBER_CENTER";
            $exx->content = $content;
            $respone = $exx->get_response();


            if ($respone == "error") {

            } else {

                $exe->p_id = "MEMBER_CENTER";
                $exe->response_sn = "";
                $sql = $exe->update_response();
                if (is_array($respone)) {
                    exit(W::response($xml, $respone, 'news'));
                } else {
                    exit(W::response($xml, $respone));
                }
            }


            //客服中心
            $exx->custom_sn = "C_SERVICE";
            $exx->content = $content;
            $respone = $exx->get_response();


            if ($respone == "error") {

            } else {

                $exe->p_id = "C_SERVICE";
                $exe->response_sn = "";
                $sql = $exe->update_response();
                if (is_array($respone)) {
                    exit(W::response($xml, $respone, 'news'));
                } else {
                    exit(W::response($xml, $respone));
                }
            }

            //微信多客服中心
            $exx->custom_sn = "WXSERVICE";
            $exx->content = $content;
            $respone = $exx->get_response();


            if ($respone == "error") {

            } else {

                $exe->p_id = "WXSERVICE";
                $exe->response_sn = "";
                $sql = $exe->update_response();

                if (is_array($respone)) {
                    exit(W::response($xml, $respone, 'news'));
                } else {
                    exit(W::response($xml, $respone));
                }
            }


            //------------------------------------------

            //订单查询
            $exx->custom_sn = "ORDER_SEARCH";
            $exx->content = $content;
            $respone = $exx->get_response();


            if ($respone == "error") {

            } else {


                function wx_efast_user($openid)
                {
                    $sql = "select wx_user_id from users where openid='" . $openid . "' ";

                    //$sql="select openid,note,is_deal from wx_users_lv_msg where is_deal=0";
                    $res = $GLOBALS['db']->getRow($sql);
                    return $res;
                }

                $ef_user = wx_efast_user($openid);
                //exit(W::response($xml, $ef_user['openid']));
                if (empty($ef_user['wx_user_id'])) { //未绑定
                    $exe->p_id = "ORDER_SEARCH";
                    $exe->response_sn = "bdtel";
                    $sql = $exe->update_response();
                    //判断是否已经绑定手机号
                    $data = "请输入平台购物时使用的手机号";
                    exit(W::response($xml, $data));
                } else {

                    $exe->p_id = "ORDER_SEARCH";
                    $exe->response_sn = "";
                    $sql = $exe->update_response();
                    //判断是否已经绑定手机号
                    if (is_array($respone)) {
                        exit(W::response($xml, $respone, 'news'));
                    } else {
                        exit(W::response($xml, $respone));
                    }

                }


            }


            //------------------------------------------


            if ($shangpin[0]['custom_name'] == $content) //添加为yate商品查询的二次开发
                {
                $exe->p_id = "SHANGPIN_000";
                $exe->response_sn = "";
                $sql = $exe->update_response();
                if ($shangpin[0]['re_type'] == 'text') {
                    $text = "select text from text_reply where text_sn='" . $shangpin[0]['re_code'] .
                        "'";
                    $text_list = $GLOBALS['db']->getRow($text);

                    $data = $text_list['text'];


                    exit(W::response($xml, $data));
                } elseif ($shangpin[0]['re_type'] == 'imgtext') {
                    $imgtext = "select b.img_note_1 as title,b.img_note_2 as note,b.b_img_url as cover,b.img_action_url as link from imgtext a,imgtext_imgs b where a.imgtext_sn=b.p_id and b.ss=1 and a.imgtext_sn='" .
                        $shangpin[0]['re_code'] . "'";
                    $img_list = $GLOBALS['db']->getAll($imgtext);

                    $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
                    for ($i = 0; $i < count($img_list); $i++) {
                        $img_list[$i]['cover'] = $url_this . "/" . $img_list[$i]['cover'];
                    }
                    $data = $img_list;
                    exit(W::response($xml, $data, 'news'));
                }

            }

            //关键字为000的查询 没有关键字000
            if (empty($custom_list_000)) {

            } else {
                if ($custom_list_000[0]['re_type'] == 'text') {
                    $text = "select text from text_reply where text_sn='" . $custom_list_000[0]['re_code'] .
                        "'";
                    $text_list = $GLOBALS['db']->getRow($text);

                    $data = $text_list['text'];
                    exit(W::response($xml, $data));
                } elseif ($custom_list_000[0]['re_type'] == 'imgtext') {
                    $imgtext = "select b.img_note_1 as title,b.img_note_2 as note,b.b_img_url as cover,b.img_action_url as link from imgtext a,imgtext_imgs b where a.imgtext_sn=b.p_id and b.ss=1 and a.imgtext_sn='" .
                        $custom_list_000[0]['re_code'] . "'";
                    $img_list = $GLOBALS['db']->getAll($imgtext);

                    $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
                    for ($i = 0; $i < count($img_list); $i++) {
                        $img_list[$i]['cover'] = $url_this . "/" . $img_list[$i]['cover'];
                    }
                    $data = $img_list;
                    exit(W::response($xml, $data, 'news'));
                }
            }

            //-------------------------------默认不用修改
        } elseif ($list['p_id'] == "SHANGPIN_000") {
            $shangpin_p_id = shangpin_p_id();
            for ($o = 0; $o < count($shangpin_p_id); $o++) {
                if ($content == $shangpin_p_id[$o]['custom_name']) {
                    if ($shangpin_p_id[$o]['re_type'] == 'text') {
                        $text = "select text from text_reply where text_sn='" . $shangpin_p_id[$o]['re_code'] .
                            "'";
                        $text_list = $GLOBALS['db']->getRow($text);

                        $data = $text_list['text'];
                        exit(W::response($xml, $data));
                    } elseif ($shangpin_p_id[$o]['re_type'] == 'imgtext') {
                        $imgtext = "select b.img_note_1 as title,b.img_note_2 as note,b.b_img_url as cover,b.img_action_url as link from imgtext a,imgtext_imgs b where a.imgtext_sn=b.p_id and b.ss=1 and a.imgtext_sn='" .
                            $shangpin_p_id[$o]['re_code'] . "'";
                        $img_list = $GLOBALS['db']->getAll($imgtext);

                        $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
                        for ($i = 0; $i < count($img_list); $i++) {
                            $img_list[$i]['cover'] = $url_this . "/" . $img_list[$i]['cover'];
                        }
                        $data = $img_list;
                        exit(W::response($xml, $data, 'news'));
                    }

                }


            }
            $shangpin_end = shangpin_end();
            if ($shangpin_end[0]['custom_name'] == $content) //添加为yate商品查询的二次开发
                {
                $exe->p_id = "";
                $exe->response_sn = "";
                $sql = $exe->update_response();
                if ($shangpin_end[0]['re_type'] == 'text') {
                    $text = "select text from text_reply where text_sn='" . $shangpin_end[0]['re_code'] .
                        "'";
                    $text_list = $GLOBALS['db']->getRow($text);

                    $data = $text_list['text'];


                    exit(W::response($xml, $data));
                } elseif ($shangpin_end[0]['re_type'] == 'imgtext') {
                    $imgtext = "select b.img_note_1 as title,b.img_note_2 as note,b.b_img_url as cover,b.img_action_url as link from imgtext a,imgtext_imgs b where a.imgtext_sn=b.p_id and b.ss=1 and a.imgtext_sn='" .
                        $shangpin_end[0]['re_code'] . "'";
                    $img_list = $GLOBALS['db']->getAll($imgtext);

                    $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
                    for ($i = 0; $i < count($img_list); $i++) {
                        $img_list[$i]['cover'] = $url_this . "/" . $img_list[$i]['cover'];
                    }
                    $data = $img_list;
                    exit(W::response($xml, $data, 'news'));
                }

            }
            //查询库存代码
            $shangpin_search = get_now_custom("SHANGPIN_SEARCH");
            if ($shangpin_search[0]['custom_name'] == $content) //添加为yate商品查询的二次开发
                {

                $exe->p_id = "SHANGPIN_000_SHANGPIN_SEARCH";
                $exe->response_sn = "";
                $exe->update_response();
                if ($shangpin_search[0]['re_type'] == 'text') {
                    $text = "select text from text_reply where text_sn='" . $shangpin_search[0]['re_code'] .
                        "'";
                    $text_list = $GLOBALS['db']->getRow($text);

                    $data = $text_list['text'];


                    exit(W::response($xml, $data));
                } elseif ($shangpin_search[0]['re_type'] == 'imgtext') {
                    $imgtext = "select b.img_note_1 as title,b.img_note_2 as note,b.b_img_url as cover,b.img_action_url as link from imgtext a,imgtext_imgs b where a.imgtext_sn=b.p_id and b.ss=1 and a.imgtext_sn='" .
                        $shangpin_search[0]['re_code'] . "'";
                    $img_list = $GLOBALS['db']->getAll($imgtext);

                    $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
                    for ($i = 0; $i < count($img_list); $i++) {
                        $img_list[$i]['cover'] = $url_this . "/" . $img_list[$i]['cover'];
                    }
                    $data = $img_list;
                    exit(W::response($xml, $data, 'news'));
                }

            }

            if ($shangpin[0]['re_type'] == 'text') {
                $text = "select text from text_reply where text_sn='" . $shangpin[0]['re_code'] .
                    "'";
                $text_list = $GLOBALS['db']->getRow($text);

                $data = $text_list['text'];


                exit(W::response($xml, $data));
            } elseif ($shangpin[0]['re_type'] == 'imgtext') {
                $imgtext = "select b.img_note_1 as title,b.img_note_2 as note,b.b_img_url as cover,b.img_action_url as link from imgtext a,imgtext_imgs b where a.imgtext_sn=b.p_id and b.ss=1 and a.imgtext_sn='" .
                    $shangpin[0]['re_code'] . "'";
                $img_list = $GLOBALS['db']->getAll($imgtext);

                $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
                for ($i = 0; $i < count($img_list); $i++) {
                    $img_list[$i]['cover'] = $url_this . "/" . $img_list[$i]['cover'];
                }
                $data = $img_list;
                exit(W::response($xml, $data, 'news'));
            }
            //$data=$list['p_id'];
            //            exit(W::response($xml, $data));
        } elseif ($list['p_id'] == "SHANGPIN_000_SHANGPIN_SEARCH") {
            $shangpin_end = shangpin_end();
            if ($shangpin_end[0]['custom_name'] == $content) //添加为yate商品查询的二次开发
                {
                $exe->p_id = "";
                $exe->response_sn = "";
                $sql = $exe->update_response();
                if ($shangpin_end[0]['re_type'] == 'text') {
                    $text = "select text from text_reply where text_sn='" . $shangpin_end[0]['re_code'] .
                        "'";
                    $text_list = $GLOBALS['db']->getRow($text);

                    $data = $text_list['text'];


                    exit(W::response($xml, $data));
                } elseif ($shangpin_end[0]['re_type'] == 'imgtext') {
                    $imgtext = "select b.img_note_1 as title,b.img_note_2 as note,b.b_img_url as cover,b.img_action_url as link from imgtext a,imgtext_imgs b where a.imgtext_sn=b.p_id and b.ss=1 and a.imgtext_sn='" .
                        $shangpin_end[0]['re_code'] . "'";
                    $img_list = $GLOBALS['db']->getAll($imgtext);

                    $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
                    for ($i = 0; $i < count($img_list); $i++) {
                        $img_list[$i]['cover'] = $url_this . "/" . $img_list[$i]['cover'];
                    }
                    $data = $img_list;
                    exit(W::response($xml, $data, 'news'));
                }

            }


            //单独的亚特efast搜索版本


            if (CUSTOMER == 'YATE' && U_DB2 == 1) {
                $newDB = new SDB2();
                $newDB->goods_sn = $content;
                //$newDB->goods_sn = "AR10M3001";

                $list = $newDB->get_goods_color();
                $goods_list = $newDB->get_goods_sn();
                if (count($goods_list) == 1) {

                    $newDB->goods_sn = $goods_list[0]['goods_sn'];
                    $list = $newDB->get_goods_color();
                    $char2 = "商品:" . $list[0]['goods_name'] . "(" . $list[0]['goods_sn'] . ")\n颜色数量:" .
                        count($list) . "\n今日销售:0件\n金额:￥0.00 \n销售占比:100%\n店铺达标率:0%\n库存情况:颜色/库存\n";
                    for ($i = 0; $i < count($list); $i++) {
                        $color_char = "" . $list[$i]['color_name'] . "\n";
                        for ($j = 0; $j < count($list[$i]['size_mx']); $j++) {
                            $size_char .= " " . $list[$i]['size_mx'][$j]['size_name'] . "/" . $list[$i]['size_mx'][$j]['sl'] .
                                "\n";
                        }
                        $ca .= $color_char . $size_char;
                        $size_char = '';

                    }
                    $data = $char2 . $ca . "\n输入9997可退出商品查询";
                    exit(W::response($xml, $data));


                } else {
                    $ch = "找不到商品 " . $content . "\n是不是想找\n";
                    for ($o = 0; $o < count($goods_list); $o++) {
                        $var .= $goods_list[$o]['goods_name'] . "(" . $goods_list[$o]['goods_sn'] . ")\n";
                    }
                    $data = $ch . $var;
                    exit(W::response($xml, $data));

                }

                //                print_r($list);

            }
            $data = "输入9997可以退出库存查询";

            //单独的亚特efast搜索版本
            exit(W::response($xml, $data));
        } elseif ($list['p_id'] == "MEMBER_CENTER") {
            if (CUSTOMER == 'YATE' && U_DB2 == 1) {
                if ($content == 1 && $list['response_sn'] == "") {
                    $o_list = "select b.order_sn,b.sl,b.je,b.real_money,b.random_code from  random_code a ,lsxhd b ,lsxhd_mx c   where a.order_sn=b.order_sn and a.order_sn=c.order_sn and a.openid2='" .
                        $openid . "' group by b.order_sn";
                    $o_list = $GLOBALS['db']->getAll($o_list);

                    for ($j = 0; $j < count($o_list); $j++) {
                        $te .= "小票编号:\n" . $o_list[$j]['order_sn'] . "\n数量:" . $o_list[$j]['sl'] . "\n金额:" .
                            $o_list[$j]['je'] . "\n实收:" . $o_list[$j]['real_money'] . "\n-------------------\n";
                    }
                    //$random['jf'] = sprintf("%.0f", (int)$random['jf']);


                    $exe->p_id = "MEMBER_CENTER";
                    $exe->response_sn = "";
                    $sql = $exe->update_response();

                    $data = $te;
                    exit(W::response($xml, $data));
                } elseif ($list['p_id'] == "MEMBER_CENTER" && $list['response_sn'] == "2") {


                    $data = "输入99可退出积分查询";
                    exit(W::response($xml, $data));
                } elseif ($content == 2 && $list['response_sn'] == "") {
                    $random = "select sum(b.real_money) as jf from  random_code a ,lsxhd b   where a.order_sn=b.order_sn and a.is_use=1 and  a.openid2='" .
                        $openid . "'";
                    $random = $GLOBALS['db']->getRow($random);

                    //$random['jf'] = sprintf("%.0f", (int)$random['jf']);

                    $user1 = "select openid,nick_name,users_sn,users_name,rank_points,check_points from users where openid='" .
                        $openid . "'";

                    $user = $GLOBALS['db']->getRow($user1);

                    $exe->p_id = "MEMBER_CENTER";
                    $exe->response_sn = "";
                    $sql = $exe->update_response();

                    $data = $user['nick_name'] . "\n您的卡号:\n" . $user['users_sn'] . "\n您的消费金额为\n" . $random['jf'] .
                        "\n可用积分为" . $random['jf'] . "\n输入99可退出积分查询";
                    exit(W::response($xml, $data));
                } elseif ($content == 3 && $list['response_sn'] == "") {


                    $user1 = "select openid,nick_name,users_sn,users_name,rank_points,check_points from users where openid='" .
                        $openid . "'";

                    $user = $GLOBALS['db']->getRow($user1);

                    //$random['jf'] = sprintf("%.0f", (int)$random['jf']);


                    $exe->p_id = "MEMBER_CENTER";
                    $exe->response_sn = "";
                    $sql = $exe->update_response();

                    $data = $user['nick_name'] . "\n您的卡号:\n" . $user['users_sn'] . "";
                    exit(W::response($xml, $data));
                } elseif ($content == 99 && $list['response_sn'] == "") {
                    $exe->p_id = "";
                    $exe->response_sn = "";
                    $sql = $exe->update_response();
                    $data = "退出积分查询";
                    exit(W::response($xml, $data));
                }

            }
        } elseif ($list['p_id'] == "SD_SHOPPING") {

            //
            //单独的亚特efast搜索版本

            if (CUSTOMER == 'YATE' && U_DB2 == 1) {
                if ($content == 1 && $list['response_sn'] == "") {
                    $exe->p_id = "SD_SHOPPING";
                    $exe->response_sn = "1";
                    $sql = $exe->update_response();
                    $data = "请输入实收金额,格式\n299";
                    exit(W::response($xml, $data));
                } elseif ($list['p_id'] == "SD_SHOPPING" && $list['response_sn'] == "1") {


                    $content = sprintf("%.2f", (float)$content);


                    //更新临时购物sessions
                    function up_shopping_sessions($openid, $real_money)
                    {


                        $sql = "update shopping_sessions set real_money='" . $real_money .
                            "' where openid='" . $openid . "'";
                        $res = $GLOBALS['db']->query($sql);
                    }
                    up_shopping_sessions($openid, $content);
                    //---

                    $data = "你输入的金额为:\n￥" . $content . "\n\n确认请回复【1】\n重新输入回复【2】";
                    $exe->p_id = "SD_SHOPPING";
                    $exe->response_sn = "1_1";
                    $sql = $exe->update_response();
                    exit(W::response($xml, $data));

                } elseif ($list['p_id'] == "SD_SHOPPING" && $list['response_sn'] == "1_1") {
                    $content = (int)$content;

                    if ($content == 1) {


                        $exe->p_id = "";
                        $exe->response_sn = "";
                        $sql = $exe->update_response();


                        $order_sn = date('ymd') . substr(time(), -5) . substr(microtime(), 2, 5);
                        $random_code = insert_random_code($openid, $order_sn);

                        //完成开票，设置零售销售报表


                        if (CUSTOMER == 'YATE' && U_DB2 == 1) {
                            $order_list = "select openid,order_type,real_money,random_code,msg from  shopping_sessions  where openid='" .
                                $openid . "'";
                            $order_list = $GLOBALS['db']->getRow($order_list);

                            $array = explode(",", $order_list['msg']);
                            function get_goods_info($obj)
                            {


                                $sql = "select b.market_price,a.barcode,b.goods_sn,b.goods_name,c.color_name,c.color_code,d.size_name,d.size_code,d.outer_size_code from goods_barcode a inner join goods b on a.goods_id =b.goods_id inner join color c on a.color_id=c.color_id inner join size d on a.size_id=d.size_id where a.barcode='" .
                                    $obj . "'";
                                $res = $GLOBALS['db2']->getRow($sql);
                                return $res;
                            }

                            //$order_sn =  date('ymd') . substr(time(), -5) . substr(microtime(), 2, 5);
                            $sum_array = count($array) - 1;
                            $add_time = date('Y-m-d H:i:s', time());
                            $last_update_2 = date('Y-m-d', time());

                            for ($i = 0; $i < (count($array) - 1); $i++) {
                                $arr = get_goods_info($array[$i]);
                                if (empty($arr)) {
                                    $in_lsxhd_mx = "insert into lsxhd_mx(order_sn,barcode,goods_sn,goods_name,color_code,color_name,size_code,size_name,sl,dj,is_wuxiao) values ('" .
                                        $order_sn . "','" . $array[$i] . "','" . $arr['goods_sn'] . "','" . $arr['goods_name'] .
                                        "','" . $arr['color_code'] . "','" . $arr['color_name'] . "','" . $arr['size_code'] .
                                        "','" . $arr['size_name'] . "','" . $arr['sl'] . "','" . $arr['dj'] . "',1)";
                                    $in_lsxhd_mx = $GLOBALS['db']->query($in_lsxhd_mx);
                                } else {
                                    $in_lsxhd_mx = "insert into lsxhd_mx(order_sn,barcode,goods_sn,goods_name,color_code,color_name,size_code,size_name,sl,dj,is_wuxiao) values ('" .
                                        $order_sn . "','" . $arr['barcode'] . "','" . $arr['goods_sn'] . "','" . $arr['goods_name'] .
                                        "','" . $arr['color_code'] . "','" . $arr['color_name'] . "','" . $arr['size_code'] .
                                        "','" . $arr['size_name'] . "','" . $arr['sl'] . "','" . $arr['dj'] . "',0)";
                                    $in_lsxhd_mx = $GLOBALS['db']->query($in_lsxhd_mx);
                                    $market_price += $arr['market_price'];
                                }

                            }

                            //插入主表记录
                            $in_lsxhd = "insert into lsxhd(order_sn,
                                                    order_type,
                                                    zdr,
                                                    sl,
                                                    real_money,
                                                    je,
                                                    zd_openid,
                                                    is_jifen,
                                                    js_openid,
                                                    add_time,
                                                    
                                                    last_update_2,
                                                    tzsy,
                                                    is_rijie,
                                                    random_code
                                                    ) values ('" . $order_sn .
                                "','" . $order_list['order_type'] . "','" . $order_list['openid'] . "','" . $sum_array .
                                "','" . $order_list['real_money'] . "','" . $market_price . "','" . $order_list['openid'] .
                                "',0,'','" . $add_time . "','" . $last_update_2 . "',0,0,'" . $order_list['random_code'] .
                                "')";
                            $in_lsxhd = $GLOBALS['db']->query($in_lsxhd);

                        }

                        $data = "开票完成,小票随机码为\n" . $random_code . "\n请通知顾客输入8000后,输入小票随机码获取积分\n已退出前台收银";
                        exit(W::response($xml, $data));
                    } elseif ($content == 2) {
                        $exe->p_id = "SD_SHOPPING";
                        $exe->response_sn = "1";
                        $sql = $exe->update_response();
                        $data = "请输入实收金额,格式 299";
                        exit(W::response($xml, $data));
                    } else {
                        $exe->p_id = "SD_SHOPPING";
                        $exe->response_sn = "1";
                        $sql = $exe->update_response();
                        $data = "回复错误,回复内容" . $content . "\n请输入实收金额,格式 299";
                        exit(W::response($xml, $data));
                    }
                } elseif ($content == 2 && $list['response_sn'] == "") {
                    $exe->p_id = "";
                    $exe->response_sn = "";
                    $sql = $exe->update_response();
                    $data = "放弃收银,退出前台收银";
                    exit(W::response($xml, $data));
                } elseif ($content == 3 && $list['response_sn'] == "") {


                    //单独关键字可以这样设置


                    //更新临时购物sessions
                    function up_shopping_sessions_order_type($openid, $order_type)
                    {


                        $sql = "update shopping_sessions set order_type='" . $order_type .
                            "' where openid='" . $openid . "'";
                        $res = $GLOBALS['db']->query($sql);
                    }


                    $order_type = "select order_type from  shopping_sessions  where openid='" . $openid .
                        "'";
                    $order_type = $GLOBALS['db']->getRow($order_type);
                    if ($order_type['order_type'] == '1') {
                        up_shopping_sessions_order_type($openid, '2');
                        $exx = new wx_custom2();
                        $exx->custom_sn = "SHOPPING2";
                        $content = "002";
                    } elseif ($order_type['order_type'] == '2') {
                        $exx = new wx_custom2();
                        $exx->custom_sn = "SHOPPING";
                        up_shopping_sessions_order_type($openid, '1');
                        $content = "001";
                    }


                    //---

                    //回复3默认转换成默认回复

                    $exx->content = $content;
                    $respone = $exx->get_response();


                    if ($respone == "error") {
                        exit(W::response($xml, $content));
                    } else {

                        $exe->p_id = "SD_SHOPPING";
                        $exe->response_sn = "";
                        $sql = $exe->update_response();
                        if (is_array($respone)) {
                            exit(W::response($xml, $respone, 'news'));
                        } else {
                            exit(W::response($xml, $respone));
                        }
                    }
                    //------------------------------------------


                } elseif ($content == 99 && $list['response_sn'] == "") {
                    $exe->p_id = "";
                    $exe->response_sn = "";
                    $sql = $exe->update_response();
                    $data = "退出前台收银";
                    exit(W::response($xml, $data));
                }

            }

        } elseif ($list['p_id'] == "RE_POINTS") {

            //
            //单独的亚特efast搜索版本

            if (CUSTOMER == 'YATE' && U_DB2 == 1) {
                $content = addslashes($content);
                $se_random_code = se_random_code($openid, $content);

                if ($se_random_code == 'unfind' && $content != 99) {

                    $data = "输入错误,请重新输入4位积分随机码\n如果您忘记验证码,输入99可退出获取积分";
                    exit(W::response($xml, $data));
                } elseif ($content == 99) {
                    $exe->p_id = "";
                    $exe->response_sn = "";
                    $sql = $exe->update_response();
                    $data = "退出获取积分\n您可以继续体验其它操作";
                    exit(W::response($xml, $data));
                } else {
                    $exe->p_id = "";
                    $exe->response_sn = "";
                    $sql = $exe->update_response();
                    $data = "积分兑换成功\n感谢您的输入,详细积分可到个人中心查询\n退出获取积分";
                    exit(W::response($xml, $data));
                }

            }

        } elseif ($list['p_id'] == "C_SERVICE") { //客服系统

            //
            //单独的亚特efast搜索版本

            if (CUSTOMER == 'YATE' && U_DB2 == 1) {


                $cu = "select id,users_sn,openid,free_type,nick_name from users where is_wx_customer=1";
                $cu = $GLOBALS['db']->getAll($cu);
                for ($j = 0; $j < count($cu); $j++) {
                    $sqlb = "select add_time from users_infolist where openid='" . $cu[$j]['openid'] .
                        "' order by add_time desc limit 1";
                    $resb = $GLOBALS['db']->getRow($sqlb);
                    if (!empty($resb)) {
                        $uu = get_time_diff($resb['add_time']);


                        if ($uu['mintue'] >= 10) {
                            $sql3 = "update response_sessions set p_id='',response_sn='',openid2='' where  openid='" .
                                $cu[$j]['openid'] . "'";
                            $resb = $GLOBALS['db']->query($sql3);

                            $sql4 = "update response_sessions set openid2='' where  openid2='" . $cu[$j]['openid'] .
                                "'";
                            $resb = $GLOBALS['db']->query($sql4);

                            $sqla = "select nick_name from users where openid='" . $cu[$j]['openid'] . "'";
                            $resa = $GLOBALS['db']->getAll($sqla);
                            $nick_name = $resa[0]['nick_name'];
                            $add_time = date('Y-m-d H:i:s', time());
                            $last_update_2 = date('Y-m-d', time());
                            $sql = "insert into users_infolist(openid,nick_name,type,content,add_time,last_update_2) values('" .
                                $cu[$j]['openid'] . "','" . $nick_name . "','" . $type . "','连接客服系统','" . $add_time .
                                "','" . $last_update_2 . "') ";
                            $res = $GLOBALS['db']->query($sql);

                            $sqlb = "update users set free_type=1  where openid='" . $cu[$j]['openid'] . "'";
                            $resb = $GLOBALS['db']->query($sqlb);
                            //$data = "上次操作超时,已自动退出!";
                            //                                exit(W::response($xml, $data));
                        }
                    }
                }


                $content = addslashes($content);
                //引进发送信息
                require (dirname(__file__) . '/sub/sub_send_wx_msg.php');
                //$se_list[0]['openid'];
                require (dirname(__file__) . '/sub/sub_weixin_token.php');


                function wx_free_type($openid, $free_type)
                {
                    $sql = "update users set free_type='" . $free_type . "' where openid='" . $openid .
                        "' and is_wx_customer=1";
                    $res = $GLOBALS['db']->query($sql);

                }
                if ($content == 1 && $list['response_sn'] == "") {
                    //暂时使用users表的记录。后续需要修改成用户的记录

                    /*
                    $cu = "select id,users_sn,openid,free_type,nick_name from users where is_wx_customer=1";
                    $cu = $GLOBALS['db']->getAll($cu);
                    for ($j = 0; $j < count($cu); $j++) {
                    $sqlb = "select add_time from users_infolist where openid='" . $cu[$j]['openid'] .
                    "' order by add_time desc limit 1";
                    $resb = $GLOBALS['db']->getRow($sqlb);
                    if (!empty($resb)) {
                    $uu = get_time_diff($resb['add_time']);


                    if ($uu['mintue'] >= 10) {
                    $exe->openid = $cu[$j]['openid'];
                    $exe->p_id = "";
                    $exe->response_sn = "";
                    $sql = $exe->update_response();

                    $sqlb = "update users set free_type=1  where openid='" . $cu[$j]['openid'] . "'";
                    $resb = $GLOBALS['db']->getRow($sqlb);
                    //$data = "上次操作超时,已自动退出!";
                    //                                exit(W::response($xml, $data));
                    }
                    }
                    }*/

                    $wx_customer = "select id,users_sn,openid,free_type,nick_name from users where is_wx_customer=1 and wx_customer_type=1 and free_type=1";
                    $se_list = $GLOBALS['db']->getAll($wx_customer);

                    $count = count($se_list);
                    //exit(W::response($xml, $count));

                    //获取空闲淘宝客服的数量
                    if (!empty($se_list)) {
                        //
                        //$op='o9NG0jmFhogdI8p0o0StlhCL9U0Y';
                        //exit(W::response($xml, $se_list[0]['nick_name']));

                        $n_time = date('Y-m-d H:i:s', time());


                        $nick = get_nick_name($openid);

                        //修改成忙碌状态
                        wx_free_type($se_list[0]['openid'], "2");

                        $txt = $se_list[0]['nick_name'] . "\n" . $n_time . "\n客服系统有客户连接,客户\n" . $nick['nick_name'] .
                            "\n的信息将推送到您的微信上,请及时回复";


                        $re_text = content('text', $se_list[0]['openid'], $txt);
                        //exit(W::response($xml, $re_text['item']]));
                        send($re_text);

                        $data = "您好,请问有什么可以帮您的?";

                        $re_text = content('text', $se_list[0]['openid'], $data);
                        send($re_text);

                        $data = "您好,请问您是否还有什么问题需要咨询呢?";

                        $re_text = content('text', $se_list[0]['openid'], $data);

                        send($re_text);


                        $exe->p_id = "C_SERVICE";
                        $exe->response_sn = "1";
                        $exe->openid = $openid;
                        $exe->openid2 = $se_list[0]['openid'];
                        $sql = $exe->update_response2();
                        //将客服和客户状态都修改成聊天状态

                        $exe->openid = $se_list[0]['openid'];
                        $exe->in_response();
                        $exe->openid2 = $openid;
                        $exe->p_id = "C_SERVICE";
                        $exe->response_sn = "1";
                        $exe->is_cu = "1";
                        $sql = $exe->update_response2();


                        $data = "您好,感谢您的耐心等待,已经为您连接人工客服\n客服为您服务,请问有什么可以帮您?\n回复【99】可主动退出客服服务";

                        exit(W::response($xml, $data));

                    } else {
                        function wx_msg_sum()
                        {
                            $sql = "select count(openid) as sl from wx_users_lv_msg where is_deal=0";
                            //$sql="select openid,note,is_deal from wx_users_lv_msg where is_deal=0";
                            $res = $GLOBALS['db']->getRow($sql);
                            return $res;
                        }
                        $msg_count = wx_msg_sum();


                        $msg_count['sl'] = $msg_count['sl'] + 1;
                        $exe->p_id = "C_SERVICE";
                        $exe->response_sn = "wait";
                        $sql = $exe->update_response();
                        $txt = "【系统消息】您好,您前面还有" . $msg_count['sl'] . "人\n正在接入人工服务,请稍后\n您可以选择\n【1】在线留言\n【2】确定退出";
                        exit(W::response($xml, $txt));

                    }

                } elseif ($content == 2 && $list['response_sn'] == "") {
                    //暂时使用users表的记录。后续需要修改成用户的记录
                    /*
                    $cu = "select id,users_sn,openid,free_type,nick_name from users where is_wx_customer=1";
                    $cu = $GLOBALS['db']->getAll($cu);
                    for ($j = 0; $j < count($cu); $j++) {
                    $sqlb = "select add_time from users_infolist where openid='" . $cu[$j]['openid'] .
                    "' order by add_time desc limit 1";
                    $resb = $GLOBALS['db']->getRow($sqlb);
                    if (!empty($resb)) {
                    $uu = get_time_diff($resb['add_time']);


                    if ($uu['mintue'] >= 10) {
                    $exe->openid = $cu[$j]['openid'];
                    $exe->p_id = "";
                    $exe->response_sn = "";
                    $sql = $exe->update_response();

                    $sqlb = "update users set free_type=1  where openid='" . $cu[$j]['openid'] . "'";
                    $resb = $GLOBALS['db']->getRow($sqlb);
                    //$data = "上次操作超时,已自动退出!";
                    //                                 exit(W::response($xml, $data));
                    }
                    }
                    }
                    */

                    $wx_customer = "select id,users_sn,openid,free_type,nick_name from users where is_wx_customer=1 and wx_customer_type=1 and free_type=1";
                    $se_list = $GLOBALS['db']->getAll($wx_customer);

                    $count = count($se_list);
                    //获取空闲淘宝客服的数量
                    if (!empty($se_list)) {
                        //
                        //$op='o9NG0jmFhogdI8p0o0StlhCL9U0Y';
                        //exit(W::response($xml, $se_list[0]['nick_name']));

                        $n_time = date('Y-m-d H:i:s', time());


                        $nick = get_nick_name($openid);


                        //修改成忙碌状态
                        wx_free_type($se_list[0]['openid'], "2");

                        $txt = $se_list[0]['nick_name'] . "\n" . $n_time . "\n客服系统有客户连接,客户\n" . $nick['nick_name'] .
                            "\n的信息将推送到您的微信上,请及时回复";
                        $re_text = content('text', $se_list[0]['openid'], $txt);
                        //exit(W::response($xml, $re_text['item']]));
                        send($re_text);

                        $data = "您好,请问有什么可以帮您的?";

                        $re_text = content('text', $se_list[0]['openid'], $data);
                        send($re_text);

                        $data = "您好,请问您是否还有什么问题需要咨询呢?";

                        $re_text = content('text', $se_list[0]['openid'], $data);

                        send($re_text);


                        $exe->p_id = "C_SERVICE";
                        $exe->response_sn = "1";
                        $exe->openid = $openid;
                        $exe->openid2 = $se_list[0]['openid'];
                        $sql = $exe->update_response2();
                        //将客服和客户状态都修改成聊天状态

                        $exe->openid = $se_list[0]['openid'];
                        $exe->in_response();
                        $exe->openid2 = $openid;
                        $exe->p_id = "C_SERVICE";
                        $exe->response_sn = "1";
                        $exe->is_cu = "1";
                        $sql = $exe->update_response2();


                        $data = "您好,感谢您的耐心等待,已经为您连接人工客服\n客服为您服务,请问有什么可以帮您?\n回复【99】可主动退出客服服务";

                        exit(W::response($xml, $data));

                    } else {
                        //获取未处理留言
                        function wx_msg_sum()
                        {
                            $sql = "select count(openid) as sl from wx_users_lv_msg where is_deal=0";
                            //$sql="select openid,note,is_deal from wx_users_lv_msg where is_deal=0";
                            $res = $GLOBALS['db']->getRow($sql);
                            return $res;
                        }

                        $msg_count = wx_msg_sum();
                        $msg_count['sl'] = $msg_count['sl'] + 1;
                        $exe->p_id = "C_SERVICE";
                        $exe->response_sn = "wait";
                        $sql = $exe->update_response();
                        $txt = "【系统消息】您好,您前面还有" . $msg_count['sl'] . "人\n正在接入人工服务,请稍后\n您可以选择\n【1】在线留言\n【2】确定退出";
                        exit(W::response($xml, $txt));

                    }

                } elseif ($list['p_id'] == "C_SERVICE" && $list['response_sn'] == "1") {


                    if ($content == 99 && $list['is_cu'] == "1") {
                        $data = "感谢您的支持和使用,为了能更好的为您服务,请对本次服务进行评价,祝您生活愉快!\n[1]非常满意\n[2]比较满意\n[3]不满意--客服\n[4]不满意--服务流程";

                        $re_text = content('text', $list['openid2'], $data);
                        send($re_text);


                        $exe->openid = $list['openid2'];
                        $exe->in_response();
                        $exe->openid2 = "";
                        $exe->p_id = "C_SERVICE";
                        $exe->response_sn = "pingjia";
                        $sql = $exe->update_response2();

                        //判断是否有留言，有就优先处理留言
                        function wx_msg_sum()
                        {
                            $sql = "select count(openid) as sl from wx_users_lv_msg where is_deal=0";
                            //$sql="select openid,note,is_deal from wx_users_lv_msg where is_deal=0";
                            $res = $GLOBALS['db']->getRow($sql);
                            return $res;
                        }
                        $msg_count = wx_msg_sum();

                        function wx_msg_openid2()
                        {
                            $sql = "select id,openid,note from wx_users_lv_msg where is_deal=0";
                            //$sql="select openid,note,is_deal from wx_users_lv_msg where is_deal=0";
                            $res = $GLOBALS['db']->getRow($sql);
                            return $res;
                        }
                        $wx_msg_openid2 = wx_msg_openid2();
                        if ($msg_count['sl'] > 0) {
                            $exe->openid = $openid;
                            $exe->p_id = "C_SERVICE";
                            $exe->response_sn = "deal_msg";


                            $exe->openid2 = $wx_msg_openid2['openid'];
                            $sql = $exe->update_response2();

                            //修改成空闲状态
                            wx_free_type($openid, "3");
                            $data = "有" . $msg_count['sl'] . "个客户留言\n回复【1】,处理留言信息";
                            exit(W::response($xml, $data));
                        } else {
                            $exe->openid = $openid;
                            $exe->p_id = "";
                            $exe->response_sn = "";
                            $exe->openid2 = "";
                            $sql = $exe->update_response2();

                            //修改成空闲状态
                            wx_free_type($openid, "1");
                            $data = "已经主送退出客服服务";
                            exit(W::response($xml, $data));
                        }


                        /*
                        $exe->p_id = "";
                        $exe->response_sn = "";
                        $exe->openid2 = "";
                        $sql = $exe->update_response2();
                        
                        //修改成空闲状态
                        wx_free_type($openid, "1");
                        */


                    }
                    if ($content == 99 && $list['is_cu'] == "0") {

                        //客户主动服务
                        function wx_msg_sum()
                        {
                            $sql = "select count(openid) as sl from wx_users_lv_msg where is_deal=0";
                            //$sql="select openid,note,is_deal from wx_users_lv_msg where is_deal=0";
                            $res = $GLOBALS['db']->getRow($sql);
                            return $res;
                        }
                        $msg_count = wx_msg_sum();

                        function wx_msg_openid2()
                        {
                            $sql = "select id,openid,note from wx_users_lv_msg where is_deal=0";
                            //$sql="select openid,note,is_deal from wx_users_lv_msg where is_deal=0";
                            $res = $GLOBALS['db']->getRow($sql);
                            return $res;
                        }
                        $wx_msg_openid2 = wx_msg_openid2();


                        $data = "客户已经主动结束客服服务";

                        $re_text = content('text', $list['openid2'], $data);
                        send($re_text);

                        $exe->p_id = "C_SERVICE";
                        $exe->response_sn = "pingjia";
                        $exe->openid2 = "";
                        $sql = $exe->update_response2();


                        //判断是否有留言
                        if ($msg_count['sl'] > 0) {
                            wx_free_type($list['openid2'], "3");

                            $exe->openid = $list['openid2'];
                            $exe->in_response();
                            $exe->openid2 = "";


                            $exe->p_id = "C_SERVICE";
                            $exe->response_sn = "deal_msg";
                            $sql = $exe->update_response2();

                            $data = "有" . $msg_count['sl'] . "个客户留言\n回复【1】,处理留言信息";

                            $re_text = content('text', $list['openid2'], $data);
                            send($re_text);
                        } else {
                            //修改成空闲状态
                            wx_free_type($list['openid2'], "1");

                            $exe->openid = $list['openid2'];
                            $exe->in_response();
                            $exe->openid2 = "";
                            $exe->p_id = "";
                            $exe->response_sn = "";
                            $sql = $exe->update_response2();
                            //$data = "已经主送退出客服服务";
                        }


                        $data = "感谢您的支持和使用,为了能更好的为您服务,请对本次服务进行评价,祝您生活愉快!\n[1]非常满意\n[2]比较满意\n[3]不满意--客服\n[4]不满意--服务流程";
                        exit(W::response($xml, $data));
                    }
                    if ($list['is_cu'] == "0") {


                        if ($type == 'image') {


                            $re_text = content('image', $list['openid2'], $xml->MediaId);
                            send($re_text);
                            exit;
                        } elseif ($type == 'voice') {
                            $re_text = content('voice', $list['openid2'], $xml->MediaId);
                            send($re_text);
                            exit;
                        }


                        $nick = get_nick_name($openid);
                        $n_time = date('Y-m-d H:i:s', time());
                        $data = "推送时间\n" . $n_time . "\n仅用于信息推送给内部客服,进行客服服务,下面为常用客服回复,客户\n" . $nick['nick_name'] .
                            "\n发送信息:\n-------------------\n" . $content;

                        $re_text = content('text', $list['openid2'], $data);

                        send($re_text);

                        // $data = "您好,请问有什么可以帮您的?";
                        //
                        //                        $re_text = content('text', $list['openid2'], $data);
                        //                        send($re_text);
                        //
                        //                        $data = "您好,请问您是否还有什么问题需要咨询呢?";
                        //
                        //                        $re_text = content('text', $list['openid2'], $data);
                        //
                        //                        send($re_text);
                    } else {
                        if ($type == 'image') {
                            $re_text = content('image', $list['openid2'], $xml->MediaId);
                            send($re_text);
                            exit;
                        } elseif ($type == 'voice') {
                            $re_text = content('voice', $list['openid2'], $xml->MediaId);
                            send($re_text);
                            exit;
                        }

                        $re_text = content('text', $list['openid2'], $content);

                        send($re_text);
                    }


                } elseif ($list['p_id'] == "C_SERVICE" && $list['response_sn'] == "wait") {
                    if ($content == 1) {
                        $data = "请输入您的留言(在150个汉字之内,大于10个字符内容)并发送,我们收到后会尽快给您处理并回复,谢谢!";
                        $exe->p_id = "C_SERVICE";
                        $exe->response_sn = "lv_msg";
                        $sql = $exe->update_response();

                        exit(W::response($xml, $data));

                    } elseif ($content == 2) {
                        $exe->p_id = "";
                        $exe->response_sn = "";
                        $sql = $exe->update_response();
                        $data = "退出在线客服\n您可以继续体验其它操作";
                        exit(W::response($xml, $data));
                    } else {
                        $data = "【1】在线留言\n【2】确定退出";
                        exit(W::response($xml, $data));
                    }


                } elseif ($list['p_id'] == "C_SERVICE" && $list['response_sn'] == "deal_msg") {
                    function wx_msg_sum()
                    {
                        $sql = "select count(openid) as sl from wx_users_lv_msg where is_deal=0";
                        //$sql="select openid,note,is_deal from wx_users_lv_msg where is_deal=0";
                        $res = $GLOBALS['db']->getRow($sql);
                        return $res;
                    }
                    $msg_count = wx_msg_sum();

                    function wx_msg_openid2()
                    {
                        $sql = "select id,openid,note from wx_users_lv_msg where is_deal=0";
                        //$sql="select openid,note,is_deal from wx_users_lv_msg where is_deal=0";
                        $res = $GLOBALS['db']->getRow($sql);
                        return $res;
                    }

                    $wx_msg_openid2 = wx_msg_openid2();

                    if ($msg_count['sl'] == 0) {
                        $exe->p_id = "";
                        $exe->response_sn = "";
                        $sql = $exe->update_response();
                        $data = "无客户留言,退出客服系统";
                        exit(W::response($xml, $data));
                    }

                    if ($content == 1) {
                        $exe->p_id = "C_SERVICE";
                        $exe->response_sn = "1";
                        $exe->is_cu = "1";
                        //$wx_msg_openid2 = wx_msg_openid2();
                        $exe->openid2 = $wx_msg_openid2['openid'];
                        $sql = $exe->update_response2();

                        //更新处理记录
                        function wx_msg_up($op, $id)
                        {
                            $sql = "update wx_users_lv_msg set is_deal=1,openid2='" . $op . "' where id='" .
                                $id . "'";
                            //$sql="select openid,note,is_deal from wx_users_lv_msg where is_deal=0";
                            $res = $GLOBALS['db']->query($sql);
                            //return $res;
                        }
                        wx_msg_up($openid, $wx_msg_openid2['id']);
                        $exe->p_id = "C_SERVICE";
                        $exe->response_sn = "1";
                        $exe->is_cu = "0";
                        //$wx_msg_openid2 = wx_msg_openid2();
                        $exe->openid = $wx_msg_openid2['openid'];

                        $exe->openid2 = $openid;
                        $sql = $exe->update_response2();

                        $data = "客户留言:\n" . $wx_msg_openid2['note'] . "\n请回复信息";
                        exit(W::response($xml, $data));

                    } elseif ($content == 99) {
                        $exe->p_id = "";
                        $exe->response_sn = "";
                        $sql = $exe->update_response();
                        $data = "退出在线客服\n您可以继续体验其它操作";
                        exit(W::response($xml, $data));
                    } else {
                        $data = "有" . $msg_count['sl'] . "个客户留言\n回复【1】,处理留言信息";
                        exit(W::response($xml, $data));
                    }


                } elseif ($list['p_id'] == "C_SERVICE" && $list['response_sn'] == "pingjia") {

                    $exe->p_id = "";
                    $exe->response_sn = "";
                    $sql = $exe->update_response();
                    $data = "感谢您的评价,您可以继续体验其它操作";
                    exit(W::response($xml, $data));


                } elseif ($list['p_id'] == "C_SERVICE" && $list['response_sn'] == "lv_msg") {


                    $str = strlen($content);
                    if ($str >= 20) {
                        function wx_lv_msg($openid, $msg)
                        {
                            $n_time = date('Y-m-d H:i:s', time());
                            $sql = "insert into wx_users_lv_msg(openid,note,add_time) values ('" . $openid .
                                "','" . $msg . "','" . $n_time . "')";
                            $sql = $GLOBALS['db']->query($sql);
                        }


                        wx_lv_msg($openid, $content);
                        $exe->p_id = "";
                        $exe->response_sn = "";
                        $sql = $exe->update_response();
                        $data = "留言成功,我们将在24小时内回复,感谢您的使用,谢谢!";
                        exit(W::response($xml, $data));
                    } else {
                        $data = "请输入大于20个字符的内容\n(20字符/7汉字)";
                        exit(W::response($xml, $data));
                    }


                } elseif ($content == 99) {
                    $exe->p_id = "";
                    $exe->response_sn = "";
                    $sql = $exe->update_response();
                    $data = "退出在线客服\n您可以继续体验其它操作";
                    exit(W::response($xml, $data));
                } else {
                    //                    $exe->p_id = "";
                    //                    $exe->response_sn = "";
                    //                    $sql = $exe->update_response();
                    $data = "欢迎进入客服系统\n回复【1】，联系淘宝客服\n回复【2】，联系京东客服\n回复【99】，退出在线客服";
                    exit(W::response($xml, $data));
                }

            }

        } //客服系统
        elseif ($list['p_id'] == "ORDER_SEARCH") { //订单查询

            //判断是否已经绑定手机号
            if ($list['p_id'] == "ORDER_SEARCH" && $list['response_sn'] == "bdtel") {

                //判断号码是否规则
                require (dirname(__file__) . '/kuaidi/tel/ExCheck.php');
                $ExCheck = ExCheck($content);
                // $data = $ExCheck['error'].$ExCheck['msg'];
                //                exit(W::response($xml, $data));

                if ($ExCheck['error'] == 1) {
                    $data = $ExCheck['msg'];
                    exit(W::response($xml, $data));
                }
                $exe->p_id = "ORDER_SEARCH";
                $exe->response_sn = "ExCheck";
                $sql = $exe->update_response();


                $data = "您输入的手机号是\n" . $ExCheck['msg'] . "\n回复【1】确认绑定(并免费获取验证码)\n回复【2】重新输入号码\n回复【99】退出绑定";

                insert_sms_sessions($openid, $content);
                exit(W::response($xml, $data));
                //-------------------
                $content = addslashes($content);
                $str = strlen($content);


                if ($content == 1) { //未绑定


                    $sel = "select wx_tel,wx_user_id from response_sessions where openid ='" . $openid .
                        "'";
                    $sel = $GLOBALS['db']->getRow($sel);
                    if (empty($sel['wx_user_id'])) {
                        $exe->p_id = "ORDER_SEARCH";
                        $exe->response_sn = "";
                        $sql = $exe->update_response();
                        $data = "绑定失败";
                        exit(W::response($xml, $data));
                    } else {


                        function bd_wx_tel($openid, $sel)
                        {


                            $sql = "update users set wx_tel='" . $sel['wx_tel'] . "',wx_user_id='" . $sel['wx_user_id'] .
                                "' where openid ='" . $openid . "'";
                            $sql = $GLOBALS['db']->query($sql);

                        }

                        $aaa = bd_wx_tel($openid, $sel);
                        $exe->p_id = "ORDER_SEARCH";
                        $exe->response_sn = "";
                        $sql = $exe->update_response();
                        $data = "绑定成功";
                        exit(W::response($xml, $data));
                    }

                } elseif ($content == 99) {
                    $exe->p_id = "";
                    $exe->response_sn = "";
                    $sql = $exe->update_response();
                    $data = "退出订单查询\n您可以继续体验其它操作";
                    exit(W::response($xml, $data));
                } else {

                    if (CUSTOMER == 'YATE' && U_DB2 == 1) {

                        $newDB = new SDB2();
                        $newDB->tel = $content;

                        $user_info = $newDB->get_user_info();


                        if (empty($user_info)) {
                            $data = "该号码在系统中无相应记录,请核对号码是否正确\n回复【99】退出绑定";
                        } else {
                            $data = "昵称：" . $user_info['nick_name'] . "\n姓名：" . $user_info['receiver_name'] .
                                "\n\n请确认昵称和姓名信息是否和您的信息一致\n回复【1】可将您的号码和微信号绑定";

                            $exe->p_id = "ORDER_SEARCH";
                            $exe->response_sn = "bdtel";
                            $exe->wx_tel = $content;
                            $exe->wx_user_id = $user_info['user_id'];
                            $sql = $exe->update_response();
                            //(绑定后无法自助修改,请慎重绑定,如果绑定错误请联系客服)
                        }
                        exit(W::response($xml, $data));

                    }
                }

            } //另
            elseif ($list['p_id'] == "ORDER_SEARCH" && $list['response_sn'] == "ExCheck") {

                if ($content == 1) { //未绑定


                    $sms_list = get_sms_random($openid);

                    $uu = get_time_diff($sms_list[0]['add_time']);


                    $smscount = get_count_sms_random($openid);
                    //exit(W::response($xml, $smscount['sl']));
                    if ($smscount['sl'] >= 5) {
                        $data = "获取失败,超出今天可获取验证码最大数\n回复【99】退出验证";

                        exit(W::response($xml, $data));
                    } elseif ($uu['second'] <= 60) {
                        $data = (60 - $uu['second']) . "秒后,可重新获取验证码\n回复【1】重新获取验证码\n回复【99】退出验证";
                        exit(W::response($xml, $data));
                    } elseif ($content == 99) {
                        $exe->p_id = "";
                        $exe->response_sn = "";
                        $sql = $exe->update_response();
                        $data = "退出会员绑定\n您可以继续体验其它操作";
                        exit(W::response($xml, $data));
                    } else {
                        $sms_sessions = get_sms_sessions($openid);

                        //插入验证随机码
                        $sms = insert_sms_random($openid, $sms_sessions[0]['tel']);


                        if (!empty($sms)) {

                            require (dirname(__file__) . '/duanxin/sms_curl.php');
                            $sms_err = Sms1($sms_sessions[0]['tel'], $sms);

                            // exit(W::response($xml, $sms_err));
                            if ($sms_err == 100) {

                                $exe->p_id = "ORDER_SEARCH";
                                $exe->response_sn = "ExCheck2";
                                $sql = $exe->update_response();
                                $data = "验证码已发送,请输入收到的4位验证码!";
                                exit(W::response($xml, $data));
                            } else {
                                $exe->p_id = "";
                                $exe->response_sn = "";
                                $sql = $exe->update_response();

                                $data = "验证码发送异常,错误信息" . $sms_err . "\n已退出会员绑定";
                                exit(W::response($xml, $data));
                            }

                        } else {
                            $exe->p_id = "";
                            $exe->response_sn = "";
                            $sql = $exe->update_response();
                            $data = "验证信息发送失败\n已退出会员绑定";
                            exit(W::response($xml, $data));
                        }
                    }


                }

            } elseif ($list['p_id'] == "ORDER_SEARCH" && $list['response_sn'] == "ExCheck2") {

                if ($content == 99) {
                    $exe->p_id = "";
                    $exe->response_sn = "";
                    $sql = $exe->update_response();
                    $data = "退出会员绑定\n您可以继续体验其它操作";
                    exit(W::response($xml, $data));
                }

                $ex_check = ex_check1($openid, $content);


                if (empty($ex_check['openid'])) {
                    $data = "验证码错误,请重新输入\n回复【99】可退出验证";
                    exit(W::response($xml, $data));
                } else {
                    //exit(W::response($xml,  $ex_check['tel']));


                    //验证是否存在efast
                    if (CUSTOMER == 'YATE' && U_DB2 == 1) {

                        $newDB = new SDB2();
                        $newDB->tel = $ex_check['tel'];

                        $user_info = $newDB->get_user_info();


                        if (empty($user_info)) {


                            $data = "该号码在系统中无相应记录,请核对号码是否正确\n回复【99】退出绑定";
                        } else {
                            $data = "绑定成功,系统还检测到您在平台中有购买记录\n昵称：" . $user_info['nick_name'] . "\n姓名：" . $user_info['receiver_name'] .
                                "\n\n也一起绑定在您的微信号上";

                            //  $exe->p_id = "ORDER_SEARCH";
                            //                            $exe->response_sn = "bdtel";
                            //                            $exe->wx_tel = $content;
                            //                            $exe->wx_user_id = $user_info['user_id'];
                            //                            $sql = $exe->update_response();
                            //(绑定后无法自助修改,请慎重绑定,如果绑定错误请联系客服)
                        }
                        exit(W::response($xml, $data));

                    }


                    $data = "绑定成功,";
                    exit(W::response($xml, $data));
                }

            } elseif ($list['p_id'] == "ORDER_SEARCH" && $list['response_sn'] == "") {
                if ($content == 1) {

                    function gre($openid)
                    {
                        $sql = "select wx_tel from users where openid ='" . $openid . "'";
                        $res = $GLOBALS['db']->getRow($sql);
                        return $res;
                    }
                    $tel = gre($openid);

                    if (CUSTOMER == 'YATE' && U_DB2 == 1) {
                        $newDB = new SDB2();

                        $newDB->tel = $tel['wx_tel'];

                        $user_info = $newDB->get_order_tel();
                        if (empty($user_info)) {
                            $data = "绑定手机号码无购买记录";
                            exit(W::response($xml, $data));
                        } else {

                            $newDB->order_id = $user_info[0]['order_id'];
                            //select order_sn,consignee,order_id,pay_status,order_status,is_send,shipping_status

                            if ($user_info[0]['order_status'] == 1 && $user_info[0]['is_send'] == 2 && $user_info[0]['shipping_status'] ==
                                1) {
                                $ac = $newDB->get_order_action();
                                for ($i = 0; $i < count($ac); $i++) {
                                    $t .= $ac[$i]['action_time'] . "\n" . $ac[$i]['action_user'] . " " . $ac[$i]['action_name'] .
                                        "\n";
                                }
                                $txt = "订单号:" . $user_info[0]['order_sn'] . "\n物流:" . $user_info[0]['shipping_name'] .
                                    "\n单号:" . $user_info[0]['invoice_no'] . "\n收件人:" . $user_info[0]['consignee'] .
                                    "\n发货进度:已发货\n";
                                //插入快递配送信息shipping_name,invoice_no
                                require (dirname(__file__) . '/kuaidi/get.php');

                                $shipping_name = shipping($user_info[0]['shipping_name']);
                                $kuaidi = kuaidi_action($shipping_name, $user_info[0]['invoice_no']);

                                $kd_txt = "\n物流公司信息\n" . $kuaidi['message'] . "";
                                $aak = $kuaidi['data'];
                                for ($k = 0; $k < count($aak); $k++) {
                                    $xx .= $aak[$k]['time'] . "\n" . $aak[$k]['context'] . "\n";

                                }
                                $sjtxt = "\n以下是商家发货信息\n";
                                $txt = $txt . $kd_txt . $xx . $sjtxt . $t;
                                exit(W::response($xml, $txt));

                            } else {
                                $ac = $newDB->get_order_action();
                                for ($i = 0; $i < count($ac); $i++) {
                                    $t .= $ac[$i]['action_time'] . "\n" . $ac[$i]['action_user'] . " " . $ac[$i]['action_name'] .
                                        "\n";
                                }
                                $txt = "订单号:" . $user_info[0]['order_sn'] . "\n收件人:" . $user_info[0]['consignee'] .
                                    "\n发货进度:未发货\n\n";
                                $txt = $txt . $t;
                                exit(W::response($xml, $txt));
                            }


                        }

                    }

                } elseif ($content == 3) {
                    $exe->p_id = "ORDER_SEARCH";
                    $exe->response_sn = "bdtel";
                    $sql = $exe->update_response();
                    $data = "请输入平台购物时使用的手机号";


                    exit(W::response($xml, $data));
                } elseif ($content == 99) {
                    $exe->p_id = "";
                    $exe->response_sn = "";
                    $sql = $exe->update_response();
                    $data = "退出订单查询\n您可以继续体验其它操作";
                    exit(W::response($xml, $data));
                } else {
                    $data = "欢迎进入订单查询 \n【1】查询最近订单进度 \n【2】查询历史订单 \n【3】重新绑定手机号 \n\n【99】退出订单查询";
                    exit(W::response($xml, $data));
                }
            }


            //
            //单独的亚特efast搜索版本


        } //快递查询
        elseif ($list['p_id'] == "EX_KD" && $list['response_sn'] == "1") {

            if ($content == 99) {
                $exe->p_id = "";
                $exe->response_sn = "";
                $sql = $exe->update_response();
                $data = "退出快递查询\n您可以继续体验其它操作";
                exit(W::response($xml, $xx));
            } else {
                require (dirname(__file__) . '/kuaidi/get.php');
                $preg = preg_zz($content);
                $kuaidi = $preg[0];
                //$data=$kuaidi[0]['errCode'];
                if (empty($kuaidi)) {
                    $xx = "( ⊙o⊙)?\n单号好像不存在呀, 请检查单号是否输入正确啦~";
                } else {
                    $kd_txt = "\n物流公司信息\n" . $kuaidi['message'] . "";
                    $aak = $kuaidi['data'];
                    for ($k = 0; $k < count($aak); $k++) {
                        $xx .= $aak[$k]['time'] . "\n" . $aak[$k]['context'] . "\n";

                    }
                }

                $xx = $xx . "\n\n输入99退出快递查询哦";
                exit(W::response($xml, $xx));
            }


        } elseif ($list['p_id'] == "WXSERVICE") {


            $exe->p_id = "";
            $exe->response_sn = "";
            $sql = $exe->update_response();
            $data = "退出多客服,欢迎您下次咨询~";

            exit(W::response($xml, $content, 'kefu'));


        }


    } elseif ($type == 'event') {
        $event = strtolower($xml->Event);
        $enkey = $xml->EventKey;

        if ($event == 'view') {
            $add_time = date('Y-m-d H:i:s', time());
            $last_update_2 = date('Y-m-d', time());
            $sqla = "select nick_name from users where openid='" . $openid . "'";
            $resa = $GLOBALS['db']->getAll($sqla);
            $nick_name = $resa[0]['nick_name'];
            $sql = "insert into users_infolist(openid,nick_name,type,event_type,re_url,add_time,last_update_2) values('" .
                $openid . "','" . $nick_name . "','" . $type . "','" . $event . "','" . $enkey .
                "','" . $add_time . "','" . $last_update_2 . "') ";
            $res = $GLOBALS['db']->query($sql);
        }


        if ($event == 'click') {

            //查询自定义菜单类型
            if (!empty($enkey)) {
                $sql = "select re_type from menu_list where m_key='" . $enkey . "'";
                $res = $GLOBALS['db']->getAll($sql);
                $re_type = $res[0]['re_type'];
            }
            //查询自定义菜单类型

            //自定义菜单类型为text时 插入其访问记录
            if ($re_type == 'text') {
                $sql1 = "select c.custom_sn,c.custom_name from menu_list m,custom c where m.m_key='" .
                    $enkey . "'  and m.re_code=c.custom_sn";
                $res1 = $GLOBALS['db']->getAll($sql1);
                $re_sn = $res1[0]['custom_sn'];
                $re_name = $res1[0]['custom_name'];
                $sqla = "select nick_name from users where openid='" . $openid . "'";
                $resa = $GLOBALS['db']->getAll($sqla);
                $nick_name = $resa[0]['nick_name'];
                $add_time = date('Y-m-d H:i:s', time());
                $last_update_2 = date('Y-m-d', time());
                $sql = "insert into users_infolist(openid,nick_name,type,event_type,event_key,re_type,re_sn,re_name,add_time,last_update_2) values('" .
                    $openid . "','" . $nick_name . "','" . $type . "','" . $event . "','" . $enkey .
                    "','" . $re_type . "','" . $re_sn . "','" . $re_name . "','" . $add_time . "','" .
                    $last_update_2 . "') ";
                $res = $GLOBALS['db']->query($sql);
            }
            //自定义菜单类型为text时 插入其访问记录

            //自定义菜单类型为imgtext时 插入其访问记录
            if ($re_type == 'imgtext') {
                $sql2 = "select i.imgtext_sn,i.imgtext_name from menu_list m,imgtext i where m.m_key='" .
                    $enkey . "' and m.re_code=i.imgtext_sn";
                $res2 = $GLOBALS['db']->getAll($sql2);
                $re_sn = $res2[0]['imgtext_sn'];
                $re_name = $res2[0]['imgtext_name'];
                $sqla = "select nick_name from users where openid='" . $openid . "'";
                $resa = $GLOBALS['db']->getAll($sqla);
                $nick_name = $resa[0]['nick_name'];
                $add_time = date('Y-m-d H:i:s', time());
                $last_update_2 = date('Y-m-d', time());
                $sql = "insert into users_infolist(openid,nick_name,type,event_type,event_key,re_type,re_sn,re_name,add_time,last_update_2) values('" .
                    $openid . "','" . $nick_name . "','" . $type . "','" . $event . "','" . $enkey .
                    "','" . $re_type . "','" . $re_sn . "','" . $re_name . "','" . $add_time . "','" .
                    $last_update_2 . "') ";
                $res = $GLOBALS['db']->query($sql);
            }
            //自定义菜单类型为imgtext时 插入其访问记录

            //单独为了签到而开发
            if ($enkey == "CHECK_IN") {
                if ($check_in[0]['re_type'] == 'text') {
                    //签到添加记录
                    $add_time = date('Y-m-d H:i:s', time());
                    $last_update_2 = date('Y-m-d', time());
                    $seach = "select openid,is_check,add_time,last_update_2 from users_check_log where openid='" .
                        $openid . "' and last_update_2='" . $last_update_2 . "' ";
                    $seach = $GLOBALS['db']->getAll($seach);


                    function get_setsys()
                    {
                        $sql = "select * from set_sys where keyword='check_in'";
                        $res = $GLOBALS['db']->getRow($sql);
                        return $res;
                    }
                    $sys_list = get_setsys();


                    if (count($seach) > 1) {
                        $dele_chech = "delete from users_check_log where openid='" . $openid .
                            "' and last_update_2='" . $last_update_2 . "' ";
                        $dele_chech = $GLOBALS['db']->query($dele_chech);
                        $sql_check = "insert into users_check_log(openid,is_check,add_time,last_update_2,rank_points) values ('" .
                            $openid . "','1','" . $add_time . "','" . $last_update_2 . "','".$sys_list['val']."')";
                        $sql_check = $GLOBALS['db']->query($sql_check);

                        $nick_name = get_nick_name($openid);
                        $ttxt = "" . $nick_name['nick_name'] . "\n";
                        $data = $ttxt . "
                        
                        您今天已经签到过了,已获得积分,明天签到可获得更多积分";


                    } elseif (count($seach) == 0) {
                        //如果未签到，插入签到数据
                        $sql_check = "insert into users_check_log(openid,is_check,add_time,last_update_2,rank_points) values ('" .
                            $openid . "','1','" . $add_time . "','" . $last_update_2 . "','".$sys_list['val']."')";
                        $sql_check = $GLOBALS['db']->query($sql_check);
                        //签到添加记录
                        $nick_name = get_nick_name($openid);
                        $ttxt = "" . $nick_name['nick_name'] . "\n";
                        $data = $ttxt . "
                        1、	每天登陆大华家纺官方微信，签到可得10积分。
2、	在大华家纺微信商城每消费1元可得1积分。
3、	积分可在积分兑换中心兑换您喜欢的商品。
4、	每2000积分可免费兑换价值88元的大华家纺萌萌兔1只或价值125元全棉印花枕套一对（花型随机）。
5、	每5000积分可免费兑换价值450元全棉印花四件套一套（花型随机）。
6、	每10000积分可免费兑换价值2000元蚕丝被一条.
7、	本活动解释权归大华家纺有限公司所有。

                        您已经签到,获得积分\n签到时间:\n" . $add_time . "";


                    } else {
                        $nick_name = get_nick_name($openid);
                        $ttxt = "" . $nick_name['nick_name'] . "\n";
                        $data = $ttxt . "
                        1、	每天登陆大华家纺官方微信，签到可得10积分。
2、	在大华家纺微信商城每消费1元可得1积分。
3、	积分可在积分兑换中心兑换您喜欢的商品。
4、	每2000积分可免费兑换价值88元的大华家纺萌萌兔1只或价值125元全棉印花枕套一对（花型随机）。
5、	每5000积分可免费兑换价值450元全棉印花四件套一套（花型随机）。
6、	每10000积分可免费兑换价值2000元蚕丝被一条.
7、	本活动解释权归大华家纺有限公司所有。

                        您今天已经签到过了,已获得积分,请明天再来";
                    }


                    // $text = "select text from text_reply where text_sn='" . $check_in[0]['re_code'] .
                    //                        "'";
                    //                    $text_list = $GLOBALS['db']->getRow($text);
                    //
                    //

                    exit(W::response($xml, $data));
                } elseif ($check_in[0]['re_type'] == 'imgtext') {
                    $imgtext = "select b.img_note_1 as title,b.img_note_2 as note,b.b_img_url as cover,b.img_action_url as link from imgtext a,imgtext_imgs b where a.imgtext_sn=b.p_id and b.ss=1 and a.imgtext_sn='" .
                        $check_in[0]['re_code'] . "'";
                    $img_list = $GLOBALS['db']->getAll($imgtext);
                    $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
                    for ($i = 0; $i < count($img_list); $i++) {
                        $img_list[$i]['cover'] = $url_this . "/" . $img_list[$i]['cover'];
                    }
                    $data = $img_list;
                    exit(W::response($xml, $data, 'news'));
                }

            }


            //单独快递查询
            if ($enkey == "EX_KD") {
                $data = "(^ω^)\n-直接输入快递单号即可";

                $exe->p_id = "EX_KD";
                $exe->response_sn = "1";
                $sql = $exe->update_response();
                exit(W::response($xml, $data));
                //require (dirname(__file__) . '/kuaidi/get.php');


            }


            //单独快递查询
            if ($enkey == "WXSERVICE") {
                $data = "欢迎使用客服系统,请直接回复信息即可~";

                $exe->p_id = "WXSERVICE";
                $exe->response_sn = "";
                $sql = $exe->update_response();
                exit(W::response($xml, $data));
                //require (dirname(__file__) . '/kuaidi/get.php');


            }


            if ($enkey == "C_SERVICE") {


                $cu = "select id,users_sn,openid,free_type,nick_name from users where is_wx_customer=1";
                $cu = $GLOBALS['db']->getAll($cu);
                for ($j = 0; $j < count($cu); $j++) {
                    $sqlb = "select add_time from users_infolist where openid='" . $cu[$j]['openid'] .
                        "' order by add_time desc limit 1";
                    $resb = $GLOBALS['db']->getRow($sqlb);
                    if (!empty($resb)) {
                        $uu = get_time_diff($resb['add_time']);


                        if ($uu['mintue'] >= 10) {
                            $sql3 = "update response_sessions set p_id='',response_sn='',openid2='' where  openid='" .
                                $cu[$j]['openid'] . "'";
                            $resb = $GLOBALS['db']->query($sql3);

                            $sql4 = "update response_sessions set openid2='' where  openid2='" . $cu[$j]['openid'] .
                                "'";
                            $resb = $GLOBALS['db']->query($sql4);

                            $sqla = "select nick_name from users where openid='" . $cu[$j]['openid'] . "'";
                            $resa = $GLOBALS['db']->getAll($sqla);
                            $nick_name = $resa[0]['nick_name'];
                            $add_time = date('Y-m-d H:i:s', time());
                            $last_update_2 = date('Y-m-d', time());
                            $sql = "insert into users_infolist(openid,nick_name,type,content,add_time,last_update_2) values('" .
                                $cu[$j]['openid'] . "','" . $nick_name . "','" . $type . "','连接客服系统','" . $add_time .
                                "','" . $last_update_2 . "') ";
                            $res = $GLOBALS['db']->query($sql);

                            $sqlb = "update users set free_type=1  where openid='" . $cu[$j]['openid'] . "'";
                            $resb = $GLOBALS['db']->query($sqlb);
                            //$data = "上次操作超时,已自动退出!";
                            //                                exit(W::response($xml, $data));
                        }
                    }
                }


                $exe = new wx_response();
                $exe->openid = $openid;
                $exe->in_response();


                $exe->p_id = "C_SERVICE";
                $exe->response_sn = "";
                $sql = $exe->update_response();
                $data = "欢迎进入客服系统\n回复【1】，联系淘宝客服\n回复【2】，联系京东客服";
                exit(W::response($xml, $data));

                if ($respone == "error") {

                } else {

                    $exe->p_id = "C_SERVICE";
                    $exe->response_sn = "";
                    $sql = $exe->update_response();
                    if (is_array($respone)) {
                        exit(W::response($xml, $respone, 'news'));
                    } else {
                        exit(W::response($xml, $respone));
                    }
                }
            }

            for ($j = 0; $j < count($sub_list); $j++) {
                if ($enkey == $sub_list[$j]['m_key']) {
                    if ($sub_list[$j]['re_type'] == 'text') {
                        $text = "select text from text_reply where text_sn='" . $sub_list[$j]['re_code'] .
                            "'";
                        $text_list = $GLOBALS['db']->getRow($text);

                        $data = $text_list['text'];
                        exit(W::response($xml, $data));
                    } elseif ($sub_list[$j]['re_type'] == 'imgtext') {
                        $imgtext = "select b.img_note_1 as title,b.img_note_2 as note,b.b_img_url as cover,b.img_action_url as link from imgtext a,imgtext_imgs b where a.imgtext_sn=b.p_id and b.ss=1 and a.imgtext_sn='" .
                            $sub_list[$j]['re_code'] . "'";
                        $img_list = $GLOBALS['db']->getAll($imgtext);
                        $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
                        for ($i = 0; $i < count($img_list); $i++) {
                            $img_list[$i]['cover'] = $url_this . "/" . $img_list[$i]['cover'];
                        }
                        $data = $img_list;
                        exit(W::response($xml, $data, 'news'));
                    }

                }
            }

            //if ($enkey == 'about') {
            //                $data = '泉州铁马科技有限公司是一家专注于移动互联网和互联网专业领域的技术研发、技术培训、技术服务与技术咨询的高科技企业。在如今高速发展的网络技术领域中，我们以广阔的视野和业界前沿的技术实力，为客户提供低成本，高可用性的技术方案，实现客户的网站和互联网产品高性能、高效率和用户的完美沟通、互动！';
            //                exit(W::response($xml, $data));
            //            } //elseif ($enkey == 'contact') {
            //                $data = '
            //铁马APP开发团队欢迎您前来咨询，我们期待与您进行愉快的交流！
            //———————————
            //电话：13799225939 13599244282
            //Email：zz5121314@126.com
            //地址：泉州市丰泽区泉秀路
            //                ';
            //                exit(W::response($xml, $data));
            //            } elseif ($enkey == 'app') {
            //                $data = 'app开发';
            //                exit(W::response($xml, $data));
            //            } elseif ($enkey == 'jiekou') {
            //                $data = '接口开发';
            //                exit(W::response($xml, $data));
            //            } elseif ($enkey == 'ruanjian') {
            //                $data = '软件开发';
            //                exit(W::response($xml, $data));
            //            } elseif ($enkey == 'dianshang') {
            //                $data = '电子商务';
            //                exit(W::response($xml, $data));
            //            } elseif ($enkey == 'case') {
            //                $data = array(
            //                    array(
            //                        'title' => '铁马科技',
            //                        'note' => '',
            //                        //'cover' => 'http://www.tiemal.com/images/mlogo1.png',
            //                        'cover' => 'http://www.tiemal.com/case/tiemal.jpg',
            //                        'link' => 'http://www.tiemal.com/about.php'),
            //                    array(
            //                        'title' => '铁马科技官方APP',
            //                        'note' => '',
            //                        //'cover' => 'http://www.tiemal.com/case/tiemal.jpg',
            //                        'cover' => 'http://www.tiemal.com/images/mlogo1.png',
            //                        'link' => 'http://www.tiemal.com/casedetail-tiemal.php'),
            //                    array(
            //                        'title' => '龙岩三洋活水馆',
            //                        'note' => '',
            //                        'cover' => 'http://www.tiemal.com/case/sy.jpg',
            //                        'link' => 'http://www.tiemal.com/casedetail-sy.php'),
            //                    //array('title'=>'更多信息', 'note'=>'描述', 'cover'=>'图片', 'link'=>'连接')
            //                    );
            //                exit(W::response($xml, $data, 'news'));
            //            } elseif ($enkey == 'fengling') {
            //                $data = '腾讯风铃';
            //                exit(W::response($xml, $data));
            //            } elseif ($enkey == 'weixin') {
            //                $data = '微信营销';
            //                exit(W::response($xml, $data));
            //            }
            //  else {
            //                $data = '菜单指令不匹配';
            //                exit(W::response($xml, $data));
            //            }
        } elseif ($event == 'subscribe') {

            require (dirname(__file__) . '/sub/sub_g_id.php');

            //关注场景事件
            if ($enkey != '') {
                $enkey1 = trim(str_replace("qrscene_", "", $enkey));
                
                
                //20151021增加3级分销保存上级openid
                $p_openid="select openid,tg_qrcid from users where tg_qrcid='".$enkey1."'";
                $p_openid= $GLOBALS['db']->getRow($p_openid);
                if(!empty($p_openid))
                { 
                    
                    $sel="select p_openid from users where openid='".$openid."' ";
                    $sel= $GLOBALS['db']->getRow($sel);
                    if($sel['p_openid']=='')
                    {
                        $up="update users set p_openid='".$p_openid['openid']."'  where openid='".$openid."'";
                        $up= $GLOBALS['db']->query($up);
                    }

                    $ins="insert into user_p_openid (openid,p_openid,tg_qrcid) values ('".$openid."','".$p_openid['openid']."','".$enkey1."')";
                    $ins= $GLOBALS['db']->query($ins);
                }
                
                
                $sqla = "select * from (
                     select qudao_sn as cj_sn,qudao_name as cj_name,qrcid,p_id,'qudao' as cj_type from qudao
                     union all 
                     select shop_sn as cj_sn,shop_name as cj_name,b.qrcid,b.p_id,'shop' as cj_type from qudao  a inner  join shop b on a.qudao_sn=b.p_id
                     union all 
                     select sales_sn as cj_sn,sales_name as cj_name,c.qrcid,c.p_id,'sales' as cj_type from qudao a,shop b,sales c where a.qudao_sn=b.p_id and b.shop_sn=c.p_id
                     union all
                     select cj_sn,cj_name,qrcid,p_id,'agent' as cj_type from cj_qrcode
                     ) a
                     where qrcid='" . $enkey1 . "'";

                //$sqla="select cj_sn,cj_name from cj_qrcode where qrcid='".$enkey1."'";
                $resa = $GLOBALS['db']->getAll($sqla);
                $cj_sn = $resa[0]['cj_sn'];
                $cj_name = $resa[0]['cj_name'];
                $cj_type = $resa[0]['cj_type'];
                $time = date('Y-m-d H:i:s', time());
                $last_update_2 = date('Y-m-d', time());
                $sql = "insert into cj_qrcode_stat(openid,issubs,cj_sn,cj_name,cj_type,qrcid,add_time,last_update_2) values('" .
                    $openid . "',1,'" . $cj_sn . "','" . $cj_name . "','" . $cj_type . "','" . $enkey1 .
                    "','" . $time . "','" . $last_update_2 . "')";
                $resaa = $GLOBALS['db']->query($sql);
            } else //当关注场景为微信公众自带二维码 其场景值默认为1
            {
                $cj_sn = '000';
                $cj_name = '微信公众号';
                $cj_type = 'zb';
                $time = date('Y-m-d H:i:s', time());
                $last_update_2 = date('Y-m-d', time());
                $sql = "insert into cj_qrcode_stat(openid,issubs,cj_sn,cj_name,cj_type,qrcid,add_time,last_update_2) values('" .
                    $openid . "',1,'" . $cj_sn . "','" . $cj_name . "','" . $cj_type . "','" . $enkey1 .
                    "','" . $time . "','" . $last_update_2 . "')";
                $resaa = $GLOBALS['db']->query($sql);
                
                
                $sel="select p_openid from users where openid='".$openid."' ";
                $sel= $GLOBALS['db']->getRow($sel);
                if($sel['p_openid']=='')
                {
                    $up="update users set p_openid='000'  where openid='".$openid."'";
                    $up= $GLOBALS['db']->query($up);
                }

                
                
            }
            //关注场景事件


            if ($res['re_type'] == 'text') {
                $text = "select text from text_reply where text_sn='" . $res['re_code'] . "'";
                $text_list = $GLOBALS['db']->getRow($text);

                $data = $text_list['text'];
                exit(W::response($xml, $data));
            } elseif ($res['re_type'] == 'imgtext') {
                $imgtext = "select b.img_note_1 as title,b.img_note_2 as note,b.b_img_url as cover,b.img_action_url as link from imgtext a,imgtext_imgs b where a.imgtext_sn=b.p_id and b.ss=1 and a.imgtext_sn='" .
                    $res['re_code'] . "'";
                $img_list = $GLOBALS['db']->getAll($imgtext);
                $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
                for ($i = 0; $i < count($img_list); $i++) {
                    $img_list[$i]['cover'] = $url_this . "/" . $img_list[$i]['cover'];
                }
                $data = $img_list;
                exit(W::response($xml, $data, 'news'));
            }

        } elseif ($event == 'unsubscribe') {
            $data = '铁马科技，再见';
            exit(W::response($xml, $data));
        } elseif ($event == 'scan') {

            if ($res['re_type'] == 'text') {
                $text = "select text from text_reply where text_sn='" . $res['re_code'] . "'";
                $text_list = $GLOBALS['db']->getRow($text);
                $data = $text_list['text'];
                exit(W::response($xml, $data));
            } elseif ($res['re_type'] == 'imgtext') {
                $imgtext = "select b.img_note_1 as title,b.img_note_2 as note,b.b_img_url as cover,b.img_action_url as link from imgtext a,imgtext_imgs b where a.imgtext_sn=b.p_id and b.ss=1 and a.imgtext_sn='" .
                    $res['re_code'] . "'";
                $img_list = $GLOBALS['db']->getAll($imgtext);
                $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
                for ($i = 0; $i < count($img_list); $i++) {
                    $img_list[$i]['cover'] = $url_this . "/" . $img_list[$i]['cover'];
                }
                $data = $img_list;
                exit(W::response($xml, $data, 'news'));
            }

        }


    }


    //exit(W::response($xml, '类型无效!'));
}
