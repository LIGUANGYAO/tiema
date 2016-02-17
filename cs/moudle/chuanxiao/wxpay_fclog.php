<?php

define('IN_ECS', true);

error_reporting(E_ALL & ~ (E_STRICT | E_NOTICE));


require_once (dirname(dirname(__file__)) . '/service/init.php');



require_once (dirname(dirname(dirname(__file__))) . '/wxpay/lib/WxPay.Api.php');
require_once (dirname(dirname(dirname(__file__))) . '/wxpay/lib/WxPay.Notify.php');
require_once (dirname(dirname(dirname(__file__))) . '/wxpay/log.php');





//初始化日志
$logHandler= new CLogFileHandler(dirname(dirname(dirname(__file__))) . "/wxpay/logs/dsq_".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

require_once 'sub_wxpay_fclog.php';



//先判断今天产生的支付记录中有哪些已经完成


// 根据天数来获取

$time = date('Y-m-d', time());
$re_data=3;

for ($k = 0; $k < $re_data; $k++) {
    //echo $k;

    $data = strtotime($time);
    $data = $data - (60 * 60 * 24 * $k);
    $th_time = date("Y-m-d", $data);

    //echo $th_time."<br/>";
    getpay_record($th_time,$k);
}




//获取某天所有的支付请求，如果由于网络原因未完成的重新刷新
function getpay_record($obj,$k)
{
    Log::DEBUG("begin notify");
    $notify = new PayNotifyCallBack();
    $notify->Handle(false);
    
    
    $record_list="select *,from_unixtime(time) as add_t from addmoney_record where from_unixtime(time) between '".$obj." 00:00:00' and '".$obj." 23:59:59'  and status='未付款'";
    
    $record_list=$GLOBALS['db']->getAll($record_list);
    
    //print_r($record_list);
    for($i=0;$i<count($record_list);$i++)
    {
        $C_orderSn=$record_list[$i]['code'] ;
        
        if ($C_orderSn!='')
        {
            $status=$notify->Queryorder($C_orderSn); 
            //print_r($status);
        }
         //exit;
    }
   
   
}





