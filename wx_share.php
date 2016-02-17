<?php
define('IN_ECS', true);

require (dirname(__file__) . '/sub/is_weixin.php');
require (dirname(__file__) . '/includes/init2.php');


if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {


/////////////////////////////////////////////////////////分享页面

    
     function downloadImageFromWeiXin($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, 0); //只取body头
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $package = curl_exec($ch);
        $httpinfo = curl_getinfo($ch);
        curl_close($ch);
        return array_merge(array('body' => $package), array('header' => $httpinfo));
    }
    
    

 if(isset($_REQUEST['openid'])) 
    {
    $openid = $_REQUEST['openid'];
    }
    
    $sql="select p_id from tgpoint where openid='".$openid."'";
    $res = $GLOBALS['db']->getRow($sql);
    $p_id=$res['p_id'];
    
    $sql0="select article_note_1 from article where is_tuig=1  order by last_update desc limit 0,1 ";
    $res0 = $GLOBALS['db']->getRow($sql0);
    $article_note_1=$res0['article_note_1'];
    
    
    $sql1="select * from (
    select shop_sn as shop_sn,shop_name as shop_name,ticket from shop
    union
    select sales_sn as shop_sn,sales_name as shop_name,ticket from sales ) a
    where a.shop_sn='".$p_id."'  ";
    $res1 = $GLOBALS['db']->getRow($sql1);
    
    
     //获取二维码地址
                $ticket = $res1['ticket'];
                if (!empty($ticket)) {

                    $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode($ticket);
                    $imageInfo = downloadImageFromWeiXin($url);
                    $qrcodename = md5($ticket);
                    $filename = 'upload/cj_qrcode/shop/' . $qrcodename . ".jpg";
                    $local_file = fopen($filename, 'w');
                    if (false !== $local_file) {
                        if (false !== fwrite($local_file, $imageInfo["body"])) {
                            fclose($local_file);
                        }
                    }
                }
                $res1['tgerm'] = $filename;
    $res1['article_note_1']=$article_note_1;
    
    
    //print_r($res);
    $smarty->assign('list', $res1);
    $smarty->display('share/wx_share.tpl');




/////////////////////////////////////////////////////////分享页面





}





?>