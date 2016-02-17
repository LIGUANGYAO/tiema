<?php



/**
 * 微信公众平台-多图文回复功能源代码
 * ================================
 * Copyright 2013-2014 David Tang
 * http://www.cnblogs.com/mchina/
 * http://www.joythink.net/
 * ================================
 * Author:David
 * 个人微信：mchina_tang
 * 公众微信：zhuojinsz
 * Date:2013-10-09
 */

//引入回复多图文的函数文件
require_once 'response_message.php';

//define your token
define("TOKEN", "c4ca4238a0b923820dcc509a6f75849b");


//$wechatObj->valid();

class wechatCallbackapi
{
    
    public $goods_list1=array(array("sn"=>"ppp","name"=>"中国"),array("sn"=>"sss","name"=>"中国3"));
    
    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];


        //extract post data
        if (!empty($postStr)) {

            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);


            switch ($RX_TYPE) {
                case "text":
                    $resultStr = $this->handleText($postObj);


                    $content = $resultStr; //得到文件执行的结果


                    break;
                case "event":
                    $resultStr = $this->handleEvent($postObj);
                    break;

                default:
                    $resultStr = "Unknow msg type: " . $RX_TYPE;
                    break;
            }
            echo $resultStr;
        } else {
            echo "";
            exit;
        }
    }

    public function handleText($postObj)
    {
        $keyword = trim($postObj->Content);
        //$num=1;
        if (!empty($keyword)) {


            if ($keyword == "t1") {
                $record = array(
                    'title' => '刮刮卡',
                    'description' => '刮刮卡',
                    'picUrl' => 'http://www.tiemal.com/admin/api/weixin/ggk/111.png',
                    'url' => 'http://www.tiemal.com/admin/api/weixin/ggk/guaguaka2.html');
                $resultStr = _response_news($postObj, $record);
                echo $resultStr;
            } elseif ($keyword == "t2") {
                $record = array(
                    'title' => '大转盘',
                    'description' => '大转盘',
                    'picUrl' => 'http://www.tiemal.com/admin/api/weixin/ggk/111.png',
                    'url' => 'http://www.tiemal.com/admin/api/weixin/dzp/dazhuanpan.html');
                $resultStr = _response_news($postObj, $record);
                echo $resultStr;
            } elseif ($keyword == "t3") {
                $record[0] = array(
                    'title' => '铁马科技',
                    'description' => '泉州铁马科技有限公司专注于手机APP企业个性开发，企业网站和软件开发
！为您提供最优质的解决方案和服务！',
                    'picUrl' => 'http://www.tiemal.com/images/mlogo1.png',
                    'url' => 'http://www.tiemal.com/about.php');
                $record[1] = array(
                    'title' => '铁马科技官方APP',
                    'description' => '泉州铁马科技有限公司是一家专注于移动互联网和互联网专业领域的技术研发、技
术培训、技术服务与技术咨询的高科技企业。在如今高速发展的网络技术领域中，我们以广阔的视野和业界前沿的技术实力，为客户提供低
成本，高可用性的技术方案，实现客户的网站和互联网产品高性能、高效率和用户的完美沟通、互动！',
                    'picUrl' => 'http://www.tiemal.com/case/tiemal.jpg',
                    'url' => 'http://www.tiemal.com/casedetail-tiemal.php');
                $record[2] = array(
                    'title' => '龙岩三洋活水馆',
                    'description' => '引以为豪，龙岩拥有了唯一一个全新潮流的，养生休闲新方式、新去处！',
                    'picUrl' => 'http://www.tiemal.com/case/sy.jpg',
                    'url' => 'http://www.tiemal.com/casedetail-sy.php');
                $resultStr = _response_multiNews($postObj, $record);
                echo $resultStr;
            } elseif ($keyword == "t4") {
                $musickeyword = "倒不了的塔";
                $resultStr = _response_music($postObj, $musickeyword);
                echo $resultStr;
            } elseif ($keyword == "t5") {

                $textkeyword = "Z00";
                $resultStr = _response_text($postObj, $textkeyword);
                echo $resultStr;
            } else {

               $contentStr = "回复下面的序列号进行相关操作:\n1.刮刮乐翻天\n2.幸运大转盘\n3.铁马科技\n4.在线听歌";
                //$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                $resultStr = _response_text($postObj, $keyword);
                echo $resultStr;
            }

       
            if($keyword == $postObj) {
                $textkeyword = "Z00";
                $resultStr = _response_text($postObj, $postObj);
                echo $resultStr;
            }

        } else {
            echo "Input something...";
        }
    }


    public function handleEvent($object)
    {
        $contentStr = "";
        switch ($object->Event) {
            case "subscribe":
                $record = array(
                    'title' => '铁马科技',
                    'description' => '回复下面的序列号进行相关操作:1.刮刮乐翻天2.幸运大转盘3.铁马科技4.在线听歌',
                    'picUrl' => 'http://www.tiemal.com/images/mlogo1.png',
                    'url' => 'http://www.tiemal.com/about.php');

                $resultStr = _response_news($object, $record);
                break;
            default:
                $resultStr = "Unknow Event: " . $object->Event;
                break;
        }
        return $resultStr;
    }


    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array(
            $token,
            $timestamp,
            $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }
}

$wechatObj = new wechatCallbackapi();


$wechatObj->responseMsg();
$aaa=$wechatObj->goods_list1;

print_r($aaa);


?>