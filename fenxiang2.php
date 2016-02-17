<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init2.php');
//require (dirname(__file__) . '/sub/page.php');


if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {


    if (empty($_REQUEST['openid'])) {
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $res['app_id'] .
                '&secret=' . $res['app_secret'] . '&code=' . $code .
                '&grant_type=authorization_code';
            $headers = array("Content-Type: text/xml; charset=utf-8");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $output = curl_exec($ch);
            curl_close($ch);
            $jsonstr = json_decode($output);
            $access_token = $jsonstr->access_token;
            $refresh_token = $jsonstr->refresh_token;
            $openid = $jsonstr->openid;
        }

    } else {
        $openid = $_REQUEST['openid'];
    }
    echo $openid;

}



?>