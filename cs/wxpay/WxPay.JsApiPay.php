<?php
require_once "lib/WxPay.Api.php";
/**
 * 
 * JSAPI支付实现类
 * 该类实现了从微信公众平台获取code、通过code获取openid和access_token、
 * 生成jsapi支付js接口所需的参数、生成获取共享收货地址所需的参数
 * 
 * 该类是微信支付提供的样例程序，商户可根据自己的需求修改，或者使用lib中的api自行开发
 * 
 * @author widy
 *
 */
class JsApiPay
{
	/**
	 * 
	 * 网页授权接口微信服务器返回的数据，返回样例如下
	 * {
	 *  "access_token":"ACCESS_TOKEN",
	 *  "expires_in":7200,
	 *  "refresh_token":"REFRESH_TOKEN",
	 *  "openid":"OPENID",
	 *  "scope":"SCOPE",
	 *  "unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"
	 * }
	 * 其中access_token可用于获取共享收货地址
	 * openid是微信支付jsapi支付接口必须的参数
	 * @var array
	 */
	public $data = null;
    
	public $url = null;
    public $token = null;
	
	/**
	 * 
	 * 通过跳转获取用户的openid，跳转流程如下：
	 * 1、设置自己需要调回的url及其其他参数，跳转到微信服务器https://open.weixin.qq.com/connect/oauth2/authorize
	 * 2、微信服务处理完成之后会跳转回用户redirect_uri地址，此时会带上一些参数，如：code
	 * 
	 * @return 用户的openid
	 */
	public function GetOpenid()
	{
		//通过code获得openid
		if (!isset($_GET['code'])){
			//触发微信返回code码
			$baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
			$url = $this->__CreateOauthUrlForCode($baseUrl);
			Header("Location: $url");
			exit();
		} else {
			//获取code码，以获取openid
		    $code = $_GET['code'];
			$openid = $this->getOpenidFromMp($code);
			return $openid;
		}
	}
    
    
    public function GetToken()
	{
		//通过code获得openid
		if (!isset($_GET['code'])){
			//触发微信返回code码
			$baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
			$url = $this->__CreateOauthUrlForCode($baseUrl);
			Header("Location: $url");
			exit();
		} else {
			//获取code码，以获取openid
		    $code = $_GET['code'];
			$openid = $this->getTokenFromMp($code);
			return $openid;
		}
	}
	
	/**
	 * 
	 * 获取jsapi支付的参数
	 * @param array $UnifiedOrderResult 统一支付接口返回的数据
	 * @throws WxPayException
	 * 
	 * @return json数据，可直接填入js函数作为参数
	 */
	public function GetJsApiParameters($UnifiedOrderResult)
	{
		if(!array_key_exists("appid", $UnifiedOrderResult)
		|| !array_key_exists("prepay_id", $UnifiedOrderResult)
		|| $UnifiedOrderResult['prepay_id'] == "")
		{
			throw new WxPayException("参数错误");
		}
		$jsapi = new WxPayJsApiPay();
		$jsapi->SetAppid($UnifiedOrderResult["appid"]);
		$timeStamp = time();
		$jsapi->SetTimeStamp("$timeStamp");
		$jsapi->SetNonceStr(WxPayApi::getNonceStr());
		$jsapi->SetPackage("prepay_id=" . $UnifiedOrderResult['prepay_id']);
		$jsapi->SetSignType("MD5");
		$jsapi->SetPaySign($jsapi->MakeSign());
		$parameters = json_encode($jsapi->GetValues());
		return $parameters;
	}
	
	/**
	 * 
	 * 通过code从工作平台获取openid机器access_token
	 * @param string $code 微信跳转回来带上的code
	 * 
	 * @return openid
	 */
	public function GetOpenidFromMp($code)
	{
		$url = $this->__CreateOauthUrlForOpenid($code);
		//初始化curl
		$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->curl_timeout);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		if(WxPayConfig::CURL_PROXY_HOST != "0.0.0.0" 
			&& WxPayConfig::CURL_PROXY_PORT != 0){
			curl_setopt($ch,CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
			curl_setopt($ch,CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
		}
		//运行curl，结果以jason形式返回
		$res = curl_exec($ch);
		curl_close($ch);
		//取出openid
		$data = json_decode($res,true);
		$this->data = $data;
		$openid = $data['openid'];
		return $openid;
	}
    
    public function GetTokenFromMp($code)
	{
		$url = $this->__CreateOauthUrlForOpenid($code);
		//初始化curl
		$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->curl_timeout);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		if(WxPayConfig::CURL_PROXY_HOST != "0.0.0.0" 
			&& WxPayConfig::CURL_PROXY_PORT != 0){
			curl_setopt($ch,CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
			curl_setopt($ch,CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
		}
		//运行curl，结果以jason形式返回
		$res = curl_exec($ch);
		curl_close($ch);
		//取出openid
		$data = json_decode($res,true);
		$this->data = $data;
		$access_token = $data['access_token'];
		return array('access_token'=>$access_token,'code'=>$code);
	}
	
	/**
	 * 
	 * 拼接签名字符串
	 * @param array $urlObj
	 * 
	 * @return 返回已经拼接好的字符串
	 */
	private function ToUrlParams($urlObj)
	{
		$buff = "";
		foreach ($urlObj as $k => $v)
		{
			if($k != "sign"){
				$buff .= $k . "=" . $v . "&";
			}
		}
		
		$buff = trim($buff, "&");
		return $buff;
	}
	
	/**
	 * 
	 * 获取地址js参数
	 * 
	 * @return 获取共享收货地址js函数需要的参数，json格式可以直接做参数使用
	 */
	public function GetEditAddressParameters()
	{	
		$getData = $this->data;
		$data = array();
		$data["appid"] = WxPayConfig::APPID;
		$data["url"] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$time = time();
		$data["timestamp"] = "$time";
		$data["noncestr"] = "1234568";
		$data["accesstoken"] = $getData["access_token"];
		ksort($data);
		$params = $this->ToUrlParams($data);
		$addrSign = sha1($params);
		
		$afterData = array(
			"addrSign" => $addrSign,
			"signType" => "sha1",
			"scope" => "jsapi_address",
			"appId" => WxPayConfig::APPID,
			"timeStamp" => $data["timestamp"],
			"nonceStr" => $data["noncestr"]
		);
		$parameters = json_encode($afterData);
		return $parameters;
	}
    
	public function GetEditAddressParameters2()
	{	
		$getData = $this->data;
		$data = array();
		$data["appid"] = WxPayConfig::APPID;
		$data["url"] = $this->url;
		$time = time();
		$data["timestamp"] = "$time";
		$data["noncestr"] = "1234568";
		$data["accesstoken"] = $this->token;
		ksort($data);
		$params = $this->ToUrlParams($data);
		$addrSign = sha1($params);
		
		$afterData = array(
			"addrSign" => $addrSign,
			"signType" => "sha1",
			"scope" => "jsapi_address",
			"appId" => WxPayConfig::APPID,
			"timeStamp" => $data["timestamp"],
			"nonceStr" => $data["noncestr"]
		);
		$parameters = json_encode($afterData);
		return $parameters;
	}
	/**
	 * 
	 * 构造获取code的url连接
	 * @param string $redirectUrl 微信服务器回跳的url，需要url编码
	 * 
	 * @return 返回构造好的url
	 */
	private function __CreateOauthUrlForCode($redirectUrl)
	{
		$urlObj["appid"] = WxPayConfig::APPID;
		$urlObj["redirect_uri"] = "$redirectUrl";
		$urlObj["response_type"] = "code";
		$urlObj["scope"] = "snsapi_base";
		$urlObj["state"] = "STATE"."#wechat_redirect";
		$bizString = $this->ToUrlParams($urlObj);
		return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
	}
	
	/**
	 * 
	 * 构造获取open和access_toke的url地址
	 * @param string $code，微信跳转带回的code
	 * 
	 * @return 请求的url
	 */
	private function __CreateOauthUrlForOpenid($code)
	{
		$urlObj["appid"] = WxPayConfig::APPID;
		$urlObj["secret"] = WxPayConfig::APPSECRET;
		$urlObj["code"] = $code;
		$urlObj["grant_type"] = "authorization_code";
		$bizString = $this->ToUrlParams($urlObj);
		return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
	}
    
    
    
    
    
    /**
	 * 
	 * 获取现金红包js参数
	 * 
	 * @return 获取现金红包js函数需要的参数，json格式可以直接做参数使用
	 */
	public function GetSendRedPack()
	{	
	
        
        
        
		$afterData = array(
            
			"mch_billno" => WxPayConfig::MCHID . date("YmdHis") . rand(1000, 9999),
			"mch_id" => WxPayConfig::MCHID,
			"wxappid" => WxPayConfig::APPID,
			"send_name" => "测试1",
            "re_openid" => "oPfflwSrnPwk_7Cr9czMOYL6rq-c",
			"total_amount" => "100",
			"total_num" => "1",
			"wishing" => "感谢您参加活动，收款快乐！",
			"client_ip" => $_SERVER['REMOTE_ADDR'],
            "act_name" => "发送红包",
			"remark" => "发送红包备注",
            "nonce_str" => WxPayApi::getNonceStr()
		
		);
        
        //签名步骤一：按字典序排序参数
		ksort($afterData);
		$string = $this->ToUrlParams($afterData);
		//签名步骤二：在string后加入KEY
		$string = $string . "&key=".WxPayConfig::KEY;
		//签名步骤三：MD5加密
		$string = md5($string);
		//签名步骤四：所有字符转为大写
		$result = strtoupper($string);
	
        
         /*       
        ksort($afterData);
       	$params = $this->ToUrlParams($afterData);
        
        $stringSignTemp=$params."&key=".WxPayConfig::KEY;
        
        $stringSignTemp=strtoupper(MD5($stringSignTemp));
        */
        //echo $stringSignTemp;
        //exit;
//		$addrSign = sha1($params);
		$afterData['sign']=$result;
        //print_r($afterData);exit;
		//$parameters = json_encode($afterData);
		return $afterData;
	}
    
    
    
    	public function GetTransferstest()
	{	
	
        if($_SERVER['REMOTE_ADDR']=='')
        {
             $ip="127.0.0.1";
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
       
        
        
		$afterData = array(
            
			"partner_trade_no" => WxPayConfig::MCHID . date("YmdHis") . rand(1000, 9999),
			"mchid" => WxPayConfig::MCHID,
			"mch_appid" => WxPayConfig::APPID,
            //"device_info" => '',
            "check_name" => "NO_CHECK",
            "re_user_name" => "测试",
            
//NO_CHECK：不校验真实姓名 
//FORCE_CHECK：强校验真实姓名（未实名认证的用户会校验失败，无法转账） 
//OPTION_CHECK：针对已实名认证的用户才校验真实姓名（未实名认证用户不校验，可以转账成功）
            "openid" => "oPfflwSrnPwk_7Cr9czMOYL6rq-c",
			"amount" => "100",
			"spbill_create_ip" => $_SERVER['REMOTE_ADDR'],
            "desc" => "企业付款",
            "nonce_str" => WxPayApi::getNonceStr()
		
		);
        
        //签名步骤一：按字典序排序参数
		ksort($afterData);
		$string = $this->ToUrlParams($afterData);
		//签名步骤二：在string后加入KEY
		$string = $string . "&key=".WxPayConfig::KEY;
		//签名步骤三：MD5加密
		$string = md5($string);
		//签名步骤四：所有字符转为大写
		$result = strtoupper($string);
	
        
         /*       
        ksort($afterData);
       	$params = $this->ToUrlParams($afterData);
        
        $stringSignTemp=$params."&key=".WxPayConfig::KEY;
        
        $stringSignTemp=strtoupper(MD5($stringSignTemp));
        */
        //echo $stringSignTemp;
        //exit;
//		$addrSign = sha1($params);
		$afterData['sign']=$result;
        //print_r($afterData);exit;
		//$parameters = json_encode($afterData);
		return $afterData;
	}
    
    private function getIP()
    {
        static $realip;
        if (isset($_SERVER)){
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $realip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $realip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")){
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else {
                $realip = getenv("REMOTE_ADDR");
            } 
        }
        return $realip;
    }
    
    //批量发红包
    public function GetSendRedPack_arr($send_name,$re_openid,$total_amount=0,$total_num=0,$wishing,$act_name,$remark)
	{	
	   
       
        if($_SERVER['REMOTE_ADDR']=='')
        {
             $ip="127.0.0.1";
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
       
        
        
		$afterData = array(
            
			"mch_billno" => WxPayConfig::MCHID . date("YmdHis") . rand(1000, 9999),
			"mch_id" => WxPayConfig::MCHID,
			"wxappid" => WxPayConfig::APPID,
			"send_name" => $send_name,
            "re_openid" => $re_openid,
			"total_amount" => $total_amount,
			"total_num" => $total_num,
			"wishing" => $wishing,
			"client_ip" => $ip,
            "act_name" => $act_name,
			"remark" => $remark,
            "nonce_str" => WxPayApi::getNonceStr()
		
		);
        
        //签名步骤一：按字典序排序参数
		ksort($afterData);
		$string = $this->ToUrlParams($afterData);
		//签名步骤二：在string后加入KEY
		$string = $string . "&key=".WxPayConfig::KEY;
		//签名步骤三：MD5加密
		$string = md5($string);
		//签名步骤四：所有字符转为大写
		$result = strtoupper($string);
	
        

		$afterData['sign']=$result;

		return $afterData;
	}
    
    
    
    //批量发打款
    public function GetTransfers($openid,$amount=0,$desc='企业付款',$re_user_name='测试')
	{	
	   
       
        if($_SERVER['REMOTE_ADDR']=='')
        {
             $ip="127.0.0.1";
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
       
       
        
        $afterData = array(
            
			"partner_trade_no" => WxPayConfig::MCHID . date("YmdHis") . rand(1000, 9999),
			"mchid" => WxPayConfig::MCHID,
			"mch_appid" => WxPayConfig::APPID,
            //"device_info" => '',
            "check_name" => "NO_CHECK",
            "re_user_name" => $re_user_name,
            "openid" => $openid,
			"amount" => $amount,
			"spbill_create_ip" => $ip,
            "desc" => $desc,
            "nonce_str" => WxPayApi::getNonceStr()
		
		);
        
        
        //签名步骤一：按字典序排序参数
		ksort($afterData);
		$string = $this->ToUrlParams($afterData);
		//签名步骤二：在string后加入KEY
		$string = $string . "&key=".WxPayConfig::KEY;
		//签名步骤三：MD5加密
		$string = md5($string);
		//签名步骤四：所有字符转为大写
		$result = strtoupper($string);
	
        

		$afterData['sign']=$result;

		return $afterData;
	}
    
    
    
}