<?php



class mbxx
{
    public $token;
    public $mbarr;
    public $data;
    public $mbid;

    public function mbmsg()
    {
        $this->data = $this->json($this->mbarr);


        $ch = curl_init();
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" .
            $this->token . "";

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT,
            'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo2 = curl_exec($ch);
        $tmpInfo3 = (array )json_decode($tmpInfo2);
        //print_r($tmpInfo3);


        //插入发送记录

        $REarr1 = array(
            "mb_id" => $this->mbid,
            "error_msg" => serialize($tmpInfo3),
            "time" => time(),
            'send_data' => serialize($this->mbarr));
        $arr1 = $GLOBALS['db']->autoExecute("wx_mblog", $REarr1, 'INSERT');
        //end

        curl_close($ch);

    }
    private function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
    {
        static $recursive_counter = 0;
        if (++$recursive_counter > 1000) {
            die('possible deep recursion attack');
        }
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $this->arrayRecursive($array[$key], $function, $apply_to_keys_also);
            } else {
                $array[$key] = $function($value);
            }

            if ($apply_to_keys_also && is_string($key)) {
                $new_key = $function($key);
                if ($new_key != $key) {
                    $array[$new_key] = $array[$key];
                    unset($array[$key]);
                }
            }
        }
        $recursive_counter--;
    }


    private function json($array)
    {
        $this->arrayRecursive($array, 'urlencode', true);
        $json = json_encode($array);
        return urldecode($json);
    }

    public function create_mbarr($touser, $template_id, $url, $topcolor = '#FF0000',
        $data)
    {
        $senddata = array("name" => array("value" => "A00001", "color" => "#92B901"),
                "remark" => array("value" => "这块是自定义内容,", "color" => "#92B901"));

        $cojson = array(
            "touser" => $touser,
            "template_id" => $template_id,
            "url" => $url,
            "topcolor" => $topcolor,
            "data" => $data);

        return $cojson;
    }
}


//$openId = 'oPfflwQoEeNgdF7jeZ1WxffnFO2w';

$openId = $openid;



$mb = new mbxx();


//知道$p_openid['openid']

function shangjiopenid($obj)
{
    $uinfo = "select city,tg_img,tg_qrcid,wx_pay,openid,wx_isfc,wx_fctime,p_openid,nick_name from   users  where  openid='" .
        $obj . "' ";
    $uinfo = $GLOBALS['db']->getRow($uinfo);
    if ($uinfo['openid'] == '') {
        return '000';
    } else {
        return $uinfo;
    }

}

$bj=shangjiopenid($openId);

$sanji =shangjiopenid($bj['p_openid']);

$erji = shangjiopenid($sanji['p_openid']);

$yiji = shangjiopenid($erji['p_openid']);


$mbid = '1';

$sql = "select * from wx_mb where id='" . $mbid . "' ";
$res = $GLOBALS['db']->getRow($sql);


$keyarr = explode(',', $res['keyword']);

$senddata = array();
for ($i = 0; $i < count($keyarr); $i++) {


    $f = explode(':', $keyarr[$i]);
    //$arr=array("".$f[0].""=>array("value"=>"123","color"=>"#92B901"));
    $senddata[$f[0]] = array("value" => $f[1], "color" => $f[2]);
    //array_push($senddata,$arr);
}
//$senddata = array("name" => array("value" => "A00001", "color" => "#92B901"),
//        "remark" => array("value" => "这块是自定义内容,", "color" => "#92B901"));

// print_r($senddata);exit;
$obj = new getArrToken();

$mb->mbid = $mbid;
$mb->token = $obj->getToken();


//first:您分销的商品有买家已支付成功哦:#92B901,keyword1:小明:#92B901,keyword2:10.00元:#92B901,keyword3:支付成功:#92B901,remark:为您带来10.00的收益:#924531

//first:您的顾客消费啦:#92B901,keyword1:小明:#92B901,keyword2:10.00元:#92B901,remark:为您带来10.00的收益:#924531
//


$fcjb="select * from wxpay_fc order by jibie ";
$fcjb = $GLOBALS['db']->getAll($fcjb);




if($sanji['openid']!='' and $sanji['openid']!='000')
{
$senddata = array("first" => array("value" => "您分销的商品有买家已支付成功哦!!!!!!", "color" => "#92B901"),
        "keyword1" => array("value" => $bj['nick_name'], "color" => "#92B901"),
        "keyword2" => array("value" => $fcjb[2]['fenchengjine']."元", "color" => "#92B901"),
        //"keyword3" => array("value" => "支付成功", "color" => "#92B901"),
        "remark" => array("value" => "恭喜【".$sanji['nick_name']."】->【".$bj['nick_name']."】开启梦想征程", "color" => "#92B901"));
$mb->mbarr = $mb->create_mbarr($sanji['openid'], $res['template_id'], $res['url'], $res['topcolor'],
    $senddata);
$mb->mbmsg();
}



/**

if($erji['openid']!='' and $erji['openid']!='000')
{
$senddata2 = array("first" => array("value" => "您分销的商品有买家已支付成功哦", "color" => "#92B901"),
        "keyword1" => array("value" => $bj['nick_name'], "color" => "#92B901"),
        "keyword2" => array("value" => $fcjb[1]['fenchengjine']."元", "color" => "#92B901"),
        //"keyword3" => array("value" => "支付成功", "color" => "#92B901"),
        "remark" => array("value" => "恭喜【".$erji['nick_name']."】->【".$sanji['nick_name']."】->【".$bj['nick_name']."】开启梦想征程", "color" => "#92B901"));
$mb->mbarr = $mb->create_mbarr($erji['openid'], $res['template_id'], $res['url'], $res['topcolor'],
    $senddata2);
$mb->mbmsg(); 
}

  
if($yiji['openid']!='' and $yiji['openid']!='000')
{      
$senddata3 = array("first" => array("value" => "您分销的商品有买家已支付成功哦", "color" => "#92B901"),
        "keyword1" => array("value" => $bj['nick_name'], "color" => "#92B901"),
        "keyword2" => array("value" => $fcjb[0]['fenchengjine']."元", "color" => "#92B901"),
        //"keyword3" => array("value" => "支付成功", "color" => "#92B901"),
        "remark" => array("value" => "恭喜【".$yiji['nick_name']."】->【".$erji['nick_name']."】->【".$sanji['nick_name']."】->【".$bj['nick_name']."】开启梦想征程", "color" => "#92B901"));


$mb->mbarr = $mb->create_mbarr($yiji['openid'], $res['template_id'], $res['url'], $res['topcolor'],
    $senddata3);

$mb->mbmsg();
}  

*/
  


//exit;
//print_r($arr);


?>