<?php

define('IN_ECS', true);

error_reporting(E_ALL & ~ (E_STRICT | E_NOTICE));


require_once (dirname(dirname(__file__)) . '/service/init.php');


set_time_limit(0); 

//先判断今天产生的支付记录中有哪些已经完成


// 根据天数来获取

$time = date('Y-m-d', time());
$re_data = 3;

for ($k = 0; $k < $re_data; $k++) {
    //echo $k;

    $data = strtotime($time);
    $data = $data - (60 * 60 * 24 * $k);
    $th_time = date("Y-m-d", $data);




    sendPack($th_time);
}

function suiji($length = 12)
{
    // 密码字符集，可任意添加你需要的字符
    $chars = '0123456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {

        $password .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return date("YmdHis") . $password . rand(1000, 9999);
}




function sendPack($obj)
{
    $sql = "select * from wxpay_fclog_rb where is_send =0 and add_time='" . $obj .
        "'";
    $res = $GLOBALS['db']->getAll($sql);
    //print_r($res);


    ini_set('date.timezone', 'Asia/Shanghai');


    require_once (dirname(dirname(dirname(__file__))) . '/wxpay/lib/WxPay.Api.php');
    require_once (dirname(dirname(dirname(__file__))) . '/wxpay/WxPay.JsApiPay.php');
    
    /*
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
    */
    
    
    for($i=0;$i<count($res);$i++)
    {
        
        //GetTransfers($openid,$amount=0,$desc='企业付款',$re_user_name='测试')
        
        $openid =$res[$i]['send_openid'];
        $amount=$res[$i]['fenchengjine']*100;
   
        $desc="日期：".$res[$i]['add_time']."，金额：￥".($res[$i]['fenchengjine'])."，收款快乐!";

        $re_user_name='用户';
        
        
       
        $tools = new JsApiPay();
        $sendRedPa = $tools->GetTransfers($openid,$amount,$desc,$re_user_name);
        
    
        $retrun = WxPayApi::Transfers($sendRedPa);
        print_r($retrun);
        
        
        if(!empty($retrun))
        {
             $REarr = array("bz" => serialize($retrun), "add_time" => time(),'rq'=> date("Y-m-d H:i:s",time()));
             $arr2 = $GLOBALS['db']->autoExecute("wxpay_send_log", $REarr, 'INSERT');
            
        }
       
        
        
        //   [return_code] => SUCCESS
//    [return_msg] => 发放成功
//    [result_code] => SUCCESS
        if($retrun['return_code']=='SUCCESS'  and $retrun['result_code']=='SUCCESS')
        {
            //and $retrun['return_msg']=='发放成功'
            $field_values = array("is_send" => 1,"send_time"=>time(),"send_err"=>"发放成功");
            $GLOBALS['db']->autoExecute('wxpay_fclog_rb', $field_values, "UPDATE", "id='".$res[$i]['id']."'");
            
            
            
            
            $field_values = array("is_send" => 1,"send_time"=>time(),"send_type"=>'微信红包');
            $GLOBALS['db']->autoExecute('wxpay_fclog', $field_values, "UPDATE", "sc_sn='".$res[$i]['rb_sn']."'");
        }
        else
        {
            $field_values = array("send_err"=>$retrun['return_msg']);
            $GLOBALS['db']->autoExecute('wxpay_fclog_rb', $field_values, "UPDATE", "id='".$res[$i]['id']."'");
        }
        
        sleep(10);
        echo "usleep<br>";
        //exit;
    }
    
    
}
exit;