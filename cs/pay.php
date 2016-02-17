<?php

define('IN_ECS', true);


require (dirname(__file__) . '/includes/init2.php');

require (dirname(__file__) . '/sub/sub_openid.php');

if (empty($_REQUEST['g'])) {
        $_REQUEST['g'] = 'default';
} else {
        $_REQUEST['g'] = trim($_REQUEST['g']);
}




if ($_REQUEST['g'] == 'default') {
        
        
        if(isset($_POST['bookNum']))
        {
            $bookNum=trim($_POST['bookNum']);
        }
        else
        {
            $bookNum=1;
        }
        
        //echo 1;exit;
        ini_set('date.timezone','Asia/Shanghai');
        //error_reporting(E_ERROR);
        require_once "wxpay/lib/WxPay.Api.php";
        
        require_once "wxpay/WxPay.JsApiPay.php";
        //echo 1;exit;
        //require_once 'wxpay/example/log.php';
       
        header('Content-type:text/json'); 
        //初始化日志
        //$logHandler= new CLogFileHandler("wxpay/logs/".date('Y-m-d').'.log');
        //$log = Log::Init($logHandler, 15);
        
        
        //打印输出数组信息
        function printf_info($data)
        {
            foreach($data as $key=>$value){
                echo "<font color='#00ff55;'>$key</font> : $value <br/>";
            }
        }
        

//        //①、获取用户openid
//        $tools = new JsApiPay();
//        $openId = $tools->GetOpenid();
        
        
        if(empty($openId))
        {
            
            
        }
        else
        {

            session_start();

            //echo $_SESSION['C_OpenId'];exit;
            /**
             * 获取商品信息
             */
            //$fee='0.01'
            
            
            function get_spjg()
            {
                $sql = "select * from set_sys where keyword='spjg'";
                $res = $GLOBALS['db']->getRow($sql);
                return $res;
            }
            $spjg = get_spjg();
            
            $fee=(double)$spjg['note'];
            if($fee<=0)
            {
                $fee=0;
            }
            else
            {
                $fee=$fee*100;
            }
             
             
             
            //$url='http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]; exit;
            $notify_url=dirname('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
             
             
             
            //$openId=$_SESSION['C_OpenId'];                        
            //②、统一下单
            $input = new WxPayUnifiedOrder();
            
            $orderSn=WxPayConfig::MCHID.date("YmdHis"); 
            $_SESSION['C_orderSn']=$orderSn;
            
            
        
            
            $input->SetBody("微支付");
            $input->SetAttach("微支付");
            $input->SetOut_trade_no($orderSn);
            $input->SetTotal_fee($fee);
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600));
            $input->SetGoods_tag("test");
            $input->SetNotify_url($notify_url."/notify.php");
            $input->SetTrade_type("JSAPI");
            $input->SetOpenid($openId);
            $order = WxPayApi::unifiedOrder($input);
            //echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
            
            //print_r($order);
            //printf_info($order);
            
            $tools = new JsApiPay();
            $jsApiParameters = $tools->GetJsApiParameters($order);
            
            
            print_r($jsApiParameters);
            
            /**
             * 增加数据库购买记录
             */
            $time = time();
            $REarr=array("openid"=>$openId,'code'=>$orderSn,"money"=>$fee,"pay_type"=>"微信支付","status"=>"未付款","time"=>$time,'score'=>0,"scookies"=>serialize($jsApiParameters),"notify_url"=>$notify_url."/notify.php");
            
            
            $arr2 = $GLOBALS['db']->autoExecute("addmoney_record", $REarr, 'INSERT');
            
            
   
            
        }
       
      
        

        
}
?>
