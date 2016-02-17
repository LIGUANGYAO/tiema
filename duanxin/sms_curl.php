<?php


header("Content-Type: text/html; charset=utf-8");
function Post($curlPost,$url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
		$return_str = curl_exec($curl);
		curl_close($curl);
		return $return_str;
}


function Sms1($tel='',$r_code='',$u,$p)
{
    if(empty($tel) || empty($r_code))
    {
        $gets="err";
    }
    else
    {
        $target = "http://sms.106jiekou.com/utf8/sms.aspx";
//替换成自己的测试账号,参数顺序和wenservice对应
        $post_data = "account=".$u."&password=".$p."&mobile=".$tel."&content=".rawurlencode("您的验证码是：".$r_code."。请不要把验证码泄露给其他人。如非本人操作，可不用理会！");
        $gets = Post($post_data, $target);
    }
    return $gets;
 
}


//echo Sms("13799225939","1234");
//请自己解析$gets字符串并实现自己的逻辑
//100 表示成功,其它的参考文档

?>