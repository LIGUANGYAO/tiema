<?php

define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');

if (empty($_REQUEST['g'])) {
        $_REQUEST['g'] = 'default';
} else {
        $_REQUEST['g'] = trim($_REQUEST['g']);
}
require_once 'wxpay/example/log.php';


$logHandler= new CLogFileHandler("wxpay/logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);


header("Content-type=html/text;charset=utf-8");
//Log::DEBUG($_REQUEST['serverId']);

//echo $_REQUEST['serverId'];

require_once "sub/sub_cj_qrcode.php";
$tk = new getArr();
$access_token = $tk->getToken();

$url= "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=$access_token&media_id=".$_REQUEST['serverId'];
Log::DEBUG($url);




//require (dirname(__file__) . '/sub/sub_image.php');


function curl_get_contents($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}







 
function downloadWeixinFile($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);    
    curl_setopt($ch, CURLOPT_NOBODY, 0);    //只取body头
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $package = curl_exec($ch);
    $httpinfo = curl_getinfo($ch);
    curl_close($ch);
    $imageAll = array_merge(array('header' => $httpinfo), array('body' => $package)); 
    return $imageAll;
}
 
function saveWeixinFile($filename, $filecontent)
{
    $local_file = fopen($filename, 'w');
    if (false !== $local_file){
        if (false !== fwrite($local_file, $filecontent)) {
            fclose($local_file);
        }
    }
}


$fileInfo = downloadWeixinFile($url);
$filename = "upload/users/".$_REQUEST['serverId'].".jpg";
saveWeixinFile($filename, $fileInfo["body"]);



//download_remote_file_with_fopen($url,'upload/users/1.jpg');


//file_put_contents('upload/users/1.jpg', $result );

//$list= curl_get_contents($url);
//ob_flush();
//file_put_contents('upload/users/1.jpg',$list);
//$ch = curl_init($url);
//$fp = fopen('upload/users/1b776066fa782b78.jpg', 'wb');
//curl_setopt($ch, CURLOPT_FILE, $fp);
//curl_setopt($ch, CURLOPT_HEADER, 0);
//curl_exec($ch);
//curl_close($ch);
//fclose($fp);
//$ur=GrabImage($url,$_REQUEST['serverId']. ".jpg");

//$u = GrabImage($url,  $_REQUEST['serverId']. ".jpg");


exit;



$st=unserialize('a:19:{s:5:"appid";s:18:"wx7ca88298b4e7db53";s:6:"attach";s:4:"test";s:9:"bank_type";s:3:"CFT";s:8:"cash_fee";s:1:"1";s:8:"fee_type";s:3:"CNY";s:12:"is_subscribe";s:1:"Y";s:6:"mch_id";s:10:"1260778401";s:9:"nonce_str";s:16:"14n204cjMhTIZi7u";s:6:"openid";s:28:"o9dBxw8-uSeaRsn8VxjKT2swujsE";s:12:"out_trade_no";s:24:"126077840120151021120127";s:11:"result_code";s:7:"SUCCESS";s:11:"return_code";s:7:"SUCCESS";s:10:"return_msg";s:2:"OK";s:4:"sign";s:32:"E877C0171EB7F42C6674B226424EE1A2";s:8:"time_end";s:14:"20151021120132";s:9:"total_fee";s:1:"1";s:11:"trade_state";s:7:"SUCCESS";s:10:"trade_type";s:5:"JSAPI";s:14:"transaction_id";s:28:"1006460073201510211275880901";}');

print_r($st);exit;
//生成推广二维码
        require_once "sub/sub_cj_qrcode.php";
        $tk = new getArr();
        $access_token = $tk->getToken();
        
        //获取最小qrcid
        $getqrcid="select * from api_bhwh where  cj_name='agent' ";
        $getqrcid = $GLOBALS['db']->getAll($getqrcid);
        $qrcid=$getqrcid['bh'];
        
        
        
        $qrcode = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id":'.$qrcid.'}}}';
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
        $result = https_post($url,$qrcode);
        $jsoninfo = json_decode($result, true);
        $ticket = $jsoninfo["ticket"];
        
        
        //增加编号+1
        $getqrcid="update api_bhwh set bh=(bh+1) where  cj_name='agent' ";
        $getqrcid = $GLOBALS['db']->query($getqrcid);
        
        
        if(!empty($ticket)){
        
         $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($ticket);
         $imageInfo = downloadImageFromWeiXin($url);
         $qrcodename=md5($ticket);
         $filename = $qrcodename.".jpg";
         
 
         
         $local_file = fopen('upload/cj_qrcode/agent/'.$filename, 'w');
         if (false !== $local_file){
         if (false !== fwrite($local_file, $imageInfo["body"])) {
            fclose($local_file);
            }
         }
        }


 exit;


if ($_REQUEST['g'] == 'default') {
        
    
        ini_set('date.timezone','Asia/Shanghai');
        error_reporting(E_ERROR);
        require_once "wxpay/lib/WxPay.Api.php";
        require_once 'wxpay/example/log.php';
        
        //初始化日志
        $logHandler= new CLogFileHandler("logs/".date('Y-m-d').'.log');
        $log = Log::Init($logHandler, 15);
        
        function printf_info($data)
        {
            foreach($data as $key=>$value){
                echo "<font color='#f00;'>$key</font> : $value <br/>";
            }
        }
        session_start();
        $_REQUEST["out_trade_no"]=$_SESSION['C_orderSn'];
        
        
        function change_order_status($out_trade_no){
            $sql="select * from addmoney_record where code='".$out_trade_no."' and status='未付款' ";
            $res=$GLOBALS['db']->getOne($sql);
            if($sql)
            {
                
                $field_values = array("scookies" => 0,"status"=>"已付款");
                $GLOBALS['db']->autoExecute('addmoney_record', $field_values, "UPDATE", "code='".$out_trade_no."'");
            }
            
        }
        
        if(isset($_REQUEST["transaction_id"]) && $_REQUEST["transaction_id"] != ""){
        	$transaction_id = $_REQUEST["transaction_id"];
        	$input = new WxPayOrderQuery();
        	$input->SetTransaction_id($transaction_id);
        	printf_info(WxPayApi::orderQuery($input));
        	exit();
        }
        
        if(isset($_REQUEST["out_trade_no"]) && $_REQUEST["out_trade_no"] != ""){
        	$out_trade_no = $_REQUEST["out_trade_no"];
        	$input = new WxPayOrderQuery();
        	$input->SetOut_trade_no($out_trade_no);
            
            $list=WxPayApi::orderQuery($input);
            
            $list['trade_state']='SUCCESS';
            
            $list['out_trade_no'];
            
            if($list['trade_state']='SUCCESS' and $list['out_trade_no']!='')
            {
                change_order_status($list['out_trade_no']);
            }
            
            print_r($list);exit();
            
            
            
            
            
        	printf_info(WxPayApi::orderQuery($input));
        	exit();
        }
             
        

            exit;
            /**
             * 增加数据库购买记录
             */
            $time = time();
            $REarr=array("openid"=>$openId,'code'=>$orderSn,"money"=>$fee,"pay_type"=>"微信支付","status"=>"未付款","time"=>$time,'score'=>0,"scookies"=>serialize($jsApiParameters));
            
            
            $arr2 = $GLOBALS['db']->autoExecute("addmoney_record", $REarr, 'INSERT');
            
            $_SESSION['C_orderSn']=$orderSn;
        
          
        
        
}
?>