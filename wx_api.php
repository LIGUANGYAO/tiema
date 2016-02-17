<?php
/**
 * 1. 上传此文件到你的服务器
 * 2. 登录微信公众平台接口配置信息,会看的都明白.
 */
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_NOTICE);
header('Content-Type: text/html; charset=utf-8');


//铁马新增-------------------------------------------------
define('IN_ECS', true);
$appdir = dirname(__file__);
require ($appdir . '/includes/init2.php');
require (dirname(__file__) . '/sub/sub_wx.php');


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
    $xml = simplexml_load_string($post, 'SimpleXMLElement', LIBXML_NOCDATA);//// 将推送的XML消息解析为对象；
    $content = trim($xml->Content); // 获取消息内容
    $type = strtolower($xml->MsgType);
    $openid = $xml->FromUserName;


    //判断该openid是否已经有操作session
    $exe = new wx_response();
    $exe->openid = $openid;
    $exe->in_response();//吴汉青：判断openid是否已存在response_sessions数据表中，若不存在，则插入。若已存在，不进行任何操作。
    $list = $exe->get_response();


    // 接收 位置  //吴汉青：根据上报的位置，获取最近的商户信息，回复图文消息。
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
                array_push($img_list,$img_list2[$k]);//向数组推送两个数组元素，追加到末尾
            }
        }
        
        $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);//'http://baidu.com'.'/index.php'
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


            if ($content=='加入我们'){
            $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
            $joinNews[0]['title'] = '申请成为分销商';
            $joinNews[0]['note'] = '填写信息，加入我们！';
            $joinNews[0]['cover'] = $url_this . "/upload/welcome.jpg";
            $joinNews[0]['link'] = $url_this . "/tbhome_join.php";

            exit(W::response($xml, $joinNews, 'news'));
            }
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


          

    }
    } elseif ($type == 'event') {//事件类型的消息
        $event = strtolower($xml->Event);//事件类型
        $enkey = $xml->EventKey;//事件KEY值，qrscene_为前缀，后面为二维码的参数值
//点击自定义菜单，进行如下处理
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
         //   exit(W::response($xml, '回复文本', 'text'));
         //   exit(W::response($xml, $enkey, $type = 'text')); //新增

        }


        if ($event == 'click') {

            //查询自定义菜单类型
            if (!empty($enkey)) {//根据自定义菜单的事件KEY值，从数据表查询re_type字段
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
            if ($enkey == "CHECK_IN") {//自定义菜单的事件KEY值，代表签到
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
                        $data = $ttxt . "您已经签到,获得积分\n签到时间:\n" . $add_time . "";


                    } else {
                        $nick_name = get_nick_name($openid);
                        $ttxt = "" . $nick_name['nick_name'] . "\n";
                        $data = $ttxt . "您今天已经签到过了,已获得积分,请明天再来";
                    }



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

      
        } elseif ($event == 'subscribe') {

            require (dirname(__file__) . '/sub/tbhome_sub_g_id.php');

            //关注场景事件
    //        if ($enkey != '') {
            if(!empty($enkey)){
                $enkey1 = trim(str_replace("qrscene_", "", $enkey));
                
                
                //20151021增加3级分销保存上级openid
                $p_openid="select openid,tg_qrcid from users where tg_qrcid='".$enkey1."'";
                $p_openid= $GLOBALS['db']->getRow($p_openid);////显示场景二维码ID所代表的用户信息
                if(!empty($p_openid))//场景二维码id在user表有对应的记录存在
                { 
                    //查询当前用户数据表记录
                    $sel="select p_openid,is_hpid from users where openid='".$openid."' ";
                    $sel= $GLOBALS['db']->getRow($sel);
                    if($sel['is_hpid']==0)//已有上级  0代表没有
                    {
                        $up="update users set p_openid='".$p_openid['openid']."',is_hpid=1  where openid='".$openid."'";//更新当前用户记录。p_openid，已有上级is_hpid=1
                        $up= $GLOBALS['db']->query($up);

                        $tbhome_sql2="update tbhome_wx_users set up_openid='".$p_openid['openid']."', is_up=1 where openid='".$openid."'";
                        $tbhome_update_user=$GLOBALS['db']->query($tbhome_sql2);
                    }

                    $ins="insert into user_p_openid (openid,p_openid,tg_qrcid) values ('".$openid."','".$p_openid['openid']."','".$enkey1."')";//把数据插入上下级关系数据表
                    $ins= $GLOBALS['db']->query($ins);
                    
                     //插入模板消息
                     require (dirname(__file__) . '/cs/sub/sub_gettoken.php');//$access_token
                     require (dirname(__file__) . '/sub/sub_mbsend.php');
                    
                      
                     
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
                
                
                $sel="select p_openid,is_hpid from users where openid='".$openid."' ";
                $sel= $GLOBALS['db']->getRow($sel);
                if($sel['is_hpid']==0)
                {
                    $up="update users set p_openid='000',is_hpid=1  where openid='".$openid."'";
                    $up= $GLOBALS['db']->query($up);

                    $tbhome_sql1="update tbhome_wx_users set up_openid='000', is_up=1 where openid='".$openid."'";
                    $tbhome_update_user=$GLOBALS['db']->query($tbhome_sql1);

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
