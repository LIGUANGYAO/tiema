<?php
    
 $sql = " select app_id,app_secret from app_id where weixin_id=1 ";

    $res = $GLOBALS['db']->getRow($sql);
    
    $whell = date('Y-m-d', time());
    $activity = "select a.activity_sn,a.activity_name,a.tzsy,a.start_time,a.end_time,a.hd_number,b.* from activity a , activity_mx b  where a.ac_lx=1 and a.tzsy=0 and (a.start_time<='".$whell."' and a.end_time>'".$whell."') and a.activity_sn=b.p_id";
    $activity = $GLOBALS['db']->getAll($activity);
    
    
    $hd_number=$activity[0]['hd_number'];
    
    //print_r($activity);
	if (isset($_GET['code'])) {
        $code = $_GET['code'];
        
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$res['app_id'].'&secret='.$res['app_secret'].'&code=' .
            $code . '&grant_type=authorization_code';

        $headers = array("Content-Type: text/xml; charset=utf-8");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $output = curl_exec($ch);
        curl_close($ch);
        //echo $output;

        $jsonstr = json_decode($output);
        //print_r($jsonstr);
        //print_r($jsonstr->access_token . "</br>");
        //print_r($jsonstr->refresh_token . "</br>");
        //print_r($jsonstr->openid . "</br>");
        $access_token = $jsonstr->access_token;
        $refresh_token = $jsonstr->refresh_token;
        $openid = $jsonstr->openid;

        $url1 = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token .
            '&openid=' . $openid . '';
        $headers = array("Content-Type: text/xml; charset=utf-8");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $output = curl_exec($ch);
        curl_close($ch);
        $jsonstr2 = json_decode($output);
       // echo $jsonstr2->nickname;


    }
    
    //echo $openid;exit;

?>