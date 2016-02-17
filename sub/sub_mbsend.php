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


$openId = 'oPfflwSrnPwk_7Cr9czMOYL6rq-c';

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


$mbid = '3';

$sql = "select * from wx_mb where id='" . $mbid . "' ";
$res333 = $GLOBALS['db']->getRow($sql);


$keyarr = explode(',', $res333['keyword']);

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


//{{first.DATA}}
//用户名：{{keyword1.DATA}}
//代理级别：{{keyword2.DATA}}
//返利：{{keyword3.DATA}}
//{{remark.DATA}}

$fcjb="select * from wxpay_fc order by jibie ";
$fcjb = $GLOBALS['db']->getAll($fcjb);



/*
if($sanji['openid']!='' and $sanji['openid']!='000')
{
$senddata = array("first" => array("value" => "恭喜您有新的下级加入", "color" => "#92B901"),
        "keyword1" => array("value" => $bj['nick_name'], "color" => "#92B901"),
        "keyword2" => array("value" => "1级", "color" => "#92B901"),
        "keyword3" => array("value" => "", "color" => "#92B901"),
        "remark" => array("value" => "通过【".$sanji['nick_name']."】->【".$bj['nick_name']."】扫描成功", "color" => "#92B901"));

$mb->mbarr = $mb->create_mbarr($sanji['openid'], $res333['template_id'], $res333['url'], $res333['topcolor'],
    $senddata);
$mb->mbmsg();

}

if($erji['openid']!='' and $erji['openid']!='000')
{
$senddata2 = array("first" => array("value" => "恭喜您有新的下级加入", "color" => "#92B901"),
        "keyword1" => array("value" => $bj['nick_name'], "color" => "#92B901"),
        "keyword2" => array("value" => "2级", "color" => "#92B901"),
        "keyword3" => array("value" => "", "color" => "#92B901"),
        "remark" => array("value" => "通过【".$erji['nick_name']."】->【".$sanji['nick_name']."】->【".$bj['nick_name']."】扫描成功", "color" => "#92B901"));
$mb->mbarr = $mb->create_mbarr($erji['openid'], $res333['template_id'], $res333['url'], $res333['topcolor'],
    $senddata2);
$mb->mbmsg(); 
}

  
if($yiji['openid']!='' and $yiji['openid']!='000')
{ 
     
$senddata3 = array("first" => array("value" => "恭喜您有新的下级加入", "color" => "#92B901"),
        "keyword1" => array("value" => $bj['nick_name'], "color" => "#92B901"),
        "keyword2" => array("value" => "3级", "color" => "#92B901"),
        "keyword3" => array("value" =>"", "color" => "#92B901"),
        "remark" => array("value" => "通过【".$yiji['nick_name']."】->【".$erji['nick_name']."】->【".$sanji['nick_name']."】->【".$bj['nick_name']."】扫描成功", "color" => "#92B901"));


$mb->mbarr = $mb->create_mbarr($yiji['openid'], $res333['template_id'], $res333['url'], $res333['topcolor'],
    $senddata3);

$mb->mbmsg();
}
*/
//$openId='o9dBxw8-uSeaRsn8VxjKT2swujsE';



if($sanji['openid']!='' and $sanji['openid']!='000')
{
$senddata = array("first" => array("value" => "恭喜您有新伙伴扫描成功", "color" => "#92B901"),
        "keyword1" => array("value" => $bj['nick_name'], "color" => "#92B901"),
        "keyword2" => array("value" => date('Y-m-d H:i:s', time()), "color" => "#92B901"),

        "remark" => array("value" => "通过【".$sanji['nick_name']."】->【".$bj['nick_name']."】扫描成功", "color" => "#92B901"));

$mb->mbarr = $mb->create_mbarr($sanji['openid'], $res333['template_id'], $res333['url'], $res333['topcolor'],
    $senddata);
$mb->mbmsg();

}

/**
if($erji['openid']!='' and $erji['openid']!='000')
{
$senddata2 = array("first" => array("value" => "恭喜您有新的下级加入", "color" => "#92B901"),
        "keyword1" => array("value" => $bj['nick_name'], "color" => "#92B901"),
        "keyword2" => array("value" =>  date('Y-m-d H:i:s', time()), "color" => "#92B901"),
        "remark" => array("value" => "通过【".$erji['nick_name']."】->【".$sanji['nick_name']."】->【".$bj['nick_name']."】扫描成功", "color" => "#92B901"));
$mb->mbarr = $mb->create_mbarr($erji['openid'], $res333['template_id'], $res333['url'], $res333['topcolor'],
    $senddata2);
$mb->mbmsg(); 
}

  
if($yiji['openid']!='' and $yiji['openid']!='000')
{ 
     
$senddata3 = array("first" => array("value" => "恭喜您有新的下级加入", "color" => "#92B901"),
        "keyword1" => array("value" => $bj['nick_name'], "color" => "#92B901"),
        "keyword2" => array("value" =>  date('Y-m-d H:i:s', time()), "color" => "#92B901"),
        "remark" => array("value" => "通过【".$yiji['nick_name']."】->【".$erji['nick_name']."】->【".$sanji['nick_name']."】->【".$bj['nick_name']."】扫描成功", "color" => "#92B901"));


$mb->mbarr = $mb->create_mbarr($yiji['openid'], $res333['template_id'], $res333['url'], $res333['topcolor'],
    $senddata3);

$mb->mbmsg();
}
*/
  



//print_r($arr);


?>