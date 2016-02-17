<?php
/**
 * 1. 上传此文件到你的服务器
 * 2. 登录微信公众平台，接口配置信息,会看的都明白.
 * 3. 本代码由浩子开发 qq:48534085
 */
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_NOTICE);
header('Content-Type: text/html; charset=utf-8');


//铁马新增-------------------------------------------------
define('IN_ECS', true);
require (dirname(__file__) . '/includes/init.php');

$get_one = " select re_type,re_code from  attention ";
$res = $GLOBALS['db']->getRow($get_one);
//print_r($res);
//$text = "select text from text_reply where text_sn='".$res['re_code'] ."'";
//                $text_list['text'] = $GLOBALS['db']->getRow($text);
// print_r($text_list);


function sub_list()
{

    $sub = "select m_key,type,re_type,re_code from menu_list where menu_type=2 ;";

    $sub_list = $GLOBALS['db']->getAll($sub);

    return $sub_list;
}
$sub_list = sub_list();


function custom_list()
{

    $custom = "select re_type,re_code,tzsy,custom_sn,custom_name,custom_note_1,text from custom where tzsy=0   and custom_sn!='000';";

    $custom_list = $GLOBALS['db']->getAll($custom);

    return $custom_list;
}
$custom_list = custom_list();


function custom_list_000()
{

    $custom = "select re_type,re_code,tzsy,custom_sn,custom_name,custom_note_1,text from custom where tzsy=0 and custom_sn='000' ;";

    $custom_list = $GLOBALS['db']->getAll($custom);

    return $custom_list;
}
$custom_list_000 = custom_list_000();
//print_r($custom_list);
//print_r($sub_list);
//  $text = "select text from text_reply where text_sn='" . $sub_list[0]['re_code'] .
//                            "'";
//                        $text_list = $GLOBALS['db']->getRow($text);
//                        print_r($text_list);
                  
//----------------------------------------------------------


$appdir = dirname(__file__);
require $appdir . '/w.php';

// 接口验证 token
$token = 'lyl';

if (W::isGET()) {
    W::valid($token);
}

if (W::isPOST()) {
    $post = $GLOBALS["HTTP_RAW_POST_DATA"];
    $xml = simplexml_load_string($post, 'SimpleXMLElement', LIBXML_NOCDATA);
    $content = trim($xml->Content); // 获取消息内容
    $type = strtolower($xml->MsgType);
    $openid = $xml->FromUserName;

    // 接收 位置
    if ($type == 'location') {
        $distance = W::getDistance($xml->Location_X, $xml->Location_Y, 24.8907,
            118.5999923) . '公里';
        exit(W::response($xml, $distance));
    } elseif ($type == 'text') {
        //if ($content == '1') {
//            $data = array(array(
//                    'title' => '刮刮卡',
//                    'note' => '刮刮卡',
//                    'cover' => 'http:www.tiemal.com/images/mlogo1.png',
//                    'link' => 'http:www.tiemal.com/admin/api/weixin/ggk/guaguaka2.html'));
//            exit(W::response($xml, $data, 'news'));
//
//            $data = '你是说：'. $content;
//            exit(W::response($xml, $data));
//        } elseif ($content == '2') {
//            $data = array(array(
//                    'title' => '大转盘',
//                    'note' => '大转盘',
//                    'cover' => 'http:www.tiemal.com/images/mlogo1.png',
//                    'link' => 'http:www.tiemal.com/admin/api/weixin/dzp/dazhuanpan.html'));
//            exit(W::response($xml, $data, 'news'));
//            $data = array(
//                array('title'=>'标题', 'note'=>'描述', 'cover'=>'图片', 'link'=>'连接'),
//                array('title'=>'标题', 'note'=>'描述', 'cover'=>'图片', 'link'=>'连接'),
//                array('title'=>'标题', 'note'=>'描述', 'cover'=>'图片', 'link'=>'连接'),
//                array('title'=>'更多信息', 'note'=>'描述', 'cover'=>'图片', 'link'=>'连接')
//            );
//            exit(W::response($xml, $data, 'news'));
//        } elseif ($content == 'zhongguo') {
//            $data = array(array(
//                    'title' => '刮刮卡',
//                    'note' => '刮刮卡',
//                    'cover' => 'http:www.tiemal.com/images/mlogo1.png',
//                    'link' => 'http:www.tiemal.com/admin/api/weixin/ggk/guaguaka2.html'));
//            exit(W::response($xml, $data, 'news'));
//        }
       
            for($k = 0; $k < count($custom_list); $k++) {
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
                    }
                    
                }
               
                
            }
                if(empty($custom_list_000))
                {
                    
                }
                else
                {
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
                   
                
            
            
            
            
            
    } elseif ($type == 'event') {
        $event = strtolower($xml->Event);
        $enkey = $xml->EventKey;
        if ($event == 'click') {
            
            
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
                if ($res['re_type'] == 'text') {
                $text = "select text from text_reply where text_sn='" . $res['re_code'] . "'";
                $text_list = $GLOBALS['db']->getRow($text);

                $data = $text_list['text'];
                exit(W::response($xml, $data));
                }
                elseif ($res['re_type'] == 'imgtext')
                {
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
        }
    }
    
    
    
    //exit(W::response($xml, '类型无效!'));
}
