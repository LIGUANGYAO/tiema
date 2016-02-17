<?php


define('IN_ECS', true);
require (dirname(__file__) . '/includes/init.php');

//     $goods_list=array(array("sn"=>"002","name"=>"中国"),array("sn"=>"003","name"=>"中国3"));
//     print_r($goods_list);
//print_r($res);
//$text = "select text from text_reply where text_sn='".$res['re_code'] ."'";
//                $text_list['text'] = $GLOBALS['db']->getRow($text);
// print_r($text_list);


function get_list($obj)
{
    $obj = trim($obj);
    $goods = "select goods_sn,goods_name from goods where goods_sn like '%" . $obj .
        "%' or goods_name like '%" . $obj . "%';";

    $goods_list = $GLOBALS['db']->getAll($goods);
    return $goods_list;
}
print_r(get_list("55"));

/**
 * 微信公众平台-多图文回复函数
 * ================================
 * Copyright 2013-2014 David Tang
 * http://www.cnblogs.com/mchina/
 * http://www.joythink.net/
 * ================================
 * Author:David
 * 个人微信：mchina_tang
 * 公众微信：zhuojinsz
 * Date:2013-10-11
 */

/**
 * _response_news() 返回多图文格式信息
 * @param $object 消息类型
 * @param $newsContent 消息内容
 * 传入数组格式（多维数组）
 * Array
 * (
 * [0] => Array
 * (
 * [title] => 观前街
 * [description] => 观前街位于江苏苏州市区...
 * [picUrl] => http://joythink.duapp.com/images/suzhou.jpg
 * [url] => http://mp.weixin.qq.com
 * )

 * [1] => Array
 * (
 * [title] => 拙政园
 * [description] => 拙政园位于江苏省苏州市平江区...
 * [picUrl] => http://joythink.duapp.com/images/suzhouScenic/zhuozhengyuan.jpg
 * [url] => http://mp.weixin.qq.com
 * )

 * )
 * @return 处理过的具有格式的多图文消息
 */
//require_once('mysql_bae.func.php');
/*单消息*/
function _response_text($object, $textkeyword)
{
    $textTpl = "<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[text]]></MsgType>
				<Content><![CDATA[%s]]></Content>
				<FuncFlag>%d</FuncFlag>
				</xml>";


    $list = get_list($textkeyword);


    if (count($list) == 0) {
        $txt = "无相关商品记录";
    } else {
        for ($i = 0; $i < count($list); $i++) {
            $txt .= "代码:" . $list[$i]['goods_sn'] . "
名称:" . $list[$i]['goods_name'] . "
价格:

";
        }
    }
    $aaa = $list_arr; //得到文件执行的结果
    $of = fopen('dir.txt', 'w'); //创建并打开dir.txt
    if ($of) {
        fwrite($of, $aaa); //把执行文件的结果写入txt文件
    }
    fclose($of);


    $content = $txt;
    $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time
        (), $content, $flag);


    return $resultStr;
}
/*单图文*/
function _response_news($object, $newsContent)
{
    $newsTplHead = "<xml>
				    <ToUserName><![CDATA[%s]]></ToUserName>
				    <FromUserName><![CDATA[%s]]></FromUserName>
				    <CreateTime>%s</CreateTime>
				    <MsgType><![CDATA[news]]></MsgType>
				    <ArticleCount>1</ArticleCount>
				    <Articles>";
    $newsTplBody = "<item>
				    <Title><![CDATA[%s]]></Title> 
				    <Description><![CDATA[%s]]></Description>
				    <PicUrl><![CDATA[%s]]></PicUrl>
				    <Url><![CDATA[%s]]></Url>
				    </item>";
    $newsTplFoot = "</Articles>
					<FuncFlag>0</FuncFlag>
				    </xml>";

    $header = sprintf($newsTplHead, $object->FromUserName, $object->ToUserName, time
        ());

    $title = $newsContent['title'];
    $desc = $newsContent['description'];
    $picUrl = $newsContent['picUrl'];
    $url = $newsContent['url'];
    $body = sprintf($newsTplBody, $title, $desc, $picUrl, $url);

    $FuncFlag = 0;
    $footer = sprintf($newsTplFoot, $FuncFlag);

    return $header . $body . $footer;
}

/*多图文*/
function _response_multiNews($object, $newsContent)
{
    $newsTplHead = "<xml>
				    <ToUserName><![CDATA[%s]]></ToUserName>
				    <FromUserName><![CDATA[%s]]></FromUserName>
				    <CreateTime>%s</CreateTime>
				    <MsgType><![CDATA[news]]></MsgType>
				    <ArticleCount>%s</ArticleCount>
				    <Articles>";
    $newsTplBody = "<item>
				    <Title><![CDATA[%s]]></Title> 
				    <Description><![CDATA[%s]]></Description>
				    <PicUrl><![CDATA[%s]]></PicUrl>
				    <Url><![CDATA[%s]]></Url>
				    </item>";
    $newsTplFoot = "</Articles>
					<FuncFlag>0</FuncFlag>
				    </xml>";

    $bodyCount = count($newsContent);
    $bodyCount = $bodyCount < 10 ? $bodyCount : 10;

    $header = sprintf($newsTplHead, $object->FromUserName, $object->ToUserName, time
        (), $bodyCount);

    foreach ($newsContent as $key => $value) {
        $body .= sprintf($newsTplBody, $value['title'], $value['description'], $value['picUrl'],
            $value['url']);
    }

    $FuncFlag = 0;
    $footer = sprintf($newsTplFoot, $FuncFlag);

    return $header . $body . $footer;
}
/*音乐*/

function _response_music($object, $musicKeyword)
{
    $musicTpl = "<xml>
  				 <ToUserName><![CDATA[%s]]></ToUserName>
  				 <FromUserName><![CDATA[%s]]></FromUserName>
  				 <CreateTime>%s</CreateTime>
  				 <MsgType><![CDATA[music]]></MsgType>
  				 <Music>
  				 <Title><![CDATA[%s]]></Title>
  				 <Description><![CDATA[%s]]></Description>
  				 <MusicUrl><![CDATA[%s]]></MusicUrl>
  				 <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
  				 </Music>
  				 <FuncFlag>0</FuncFlag>
  				 </xml>";

    //$query = "SELECT * FROM tbl_music WHERE music_name LIKE '%".$musicKeyword."%'";
    //$query = "SELECT * FROM tbl_music WHERE music_name ='倒不了的塔'";
    $query = "select * from tbl_music where music_name ='dbldt' ";

    //$aaa=mysql_fetch_row($query);
    $result = _select_data($query);
    $rows = mysql_fetch_array($result, MYSQL_ASSOC);
    $music_id = $rows[music_name];


    if ($music_id <> '') {
        $music_name = $rows[music_name];
        $music_singer = $rows[music_singer];
        $musicUrl = "http://www.tiemal.com/admin/api/weixin/music/" . $music_id . ".mp3";
        $HQmusicUrl = "http://www.tiemal.com/admin/api/weixin/music/" . $music_id .
            ".mp3";

        $resultStr = sprintf($musicTpl, $object->FromUserName, $object->ToUserName, time
            (), $music_name, $music_singer, $musicUrl, $HQmusicUrl);
        return $resultStr;
    } else {
        return "";
    }
}

?>