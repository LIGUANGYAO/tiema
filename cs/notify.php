<?php

define('IN_ECS', true);
require (dirname(__file__) . '/includes/init2.php');



ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

//exit;
require_once "wxpay/lib/WxPay.Api.php";
require_once 'wxpay/lib/WxPay.Notify.php';
require_once 'wxpay/log.php';

//初始化日志
$logHandler= new CLogFileHandler("wxpay/logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
        
        
       
        if($result['trade_state']=='SUCCESS' and $result['out_trade_no']!='')
        {
           $this->change_order_status($result['out_trade_no'],$result);
        }
        
		Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		return true;
	}
    
    
    
    
    public function change_order_status($out_trade_no,$result){
        $sql="select * from addmoney_record where code='".$out_trade_no."' and status='未付款' ";
        $res=$GLOBALS['db']->getOne($sql);
        if($sql)
        {
            
            $field_values = array("scookies" => 0,"status"=>"已付款");
            $GLOBALS['db']->autoExecute('addmoney_record', $field_values, "UPDATE", "code='".$out_trade_no."'");
            
            
            unset($_SESSION['C_orderSn']);
        }
        else
        {
            exit;
        }
        $time=time();
        
        //插入日志
        $REarr=array("time"=>$time,"result"=>serialize($result),"type"=>"weixin");
        $arr2 = $GLOBALS['db']->autoExecute("pay_logs", $REarr, 'INSERT');
        
        
        $uinfo="select tg_img,tg_qrcid,wx_pay,openid,wx_isfc,wx_fctime,p_openid from   users  where  openid='".$result['openid']."' ";
        $uinfo = $GLOBALS['db']->getRow($uinfo);
        
        
        
        $this->jisuanfc($uinfo,$out_trade_no);
        
        
        
        
        
        if($uinfo['wx_pay']==0)
        {
            
            
            //计算上级分成
  
            
                //生成推广二维码
            require_once "sub/sub_cj_qrcode.php";
            $tk = new getArr();
            $access_token = $tk->getToken();
            
            //获取最小qrcid
            $getqrcid="select * from api_bhwh where  cj_name='agent' ";
            $getqrcid = $GLOBALS['db']->getRow($getqrcid);
            $qrcid=$getqrcid['bh'];
            
            
            
            $qrcode = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id":'.$qrcid.'}}}';
            $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
            $result2 = https_post($url,$qrcode);
            $jsoninfo = json_decode($result2, true);
            $ticket = $jsoninfo["ticket"];
            
            
            //增加编号+1
            $getqrcid="update api_bhwh set bh=(bh+1) where  cj_name='agent' ";
            $getqrcid = $GLOBALS['db']->query($getqrcid);
            
            
            if(!empty($ticket)){
            
             $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($ticket);
             $imageInfo = downloadImageFromWeiXin($url);
             $qrcodename=md5($ticket);
             $filename = $qrcodename.".jpg";
             
             
             $ur='upload/cj_qrcode/agent/'.$filename;
             
             //增加二维码记录
    
            $getqrcid="update users set tg_img='".$ur."',tg_qrcid='".$qrcid."',wx_pay=1,wx_paytime='".$time."' where  openid='".$result['openid']."' ";
            $getqrcid = $GLOBALS['db']->query($getqrcid);
             
             
             $local_file = fopen('upload/cj_qrcode/agent/'.$filename, 'w');
             if (false !== $local_file){
             if (false !== fwrite($local_file, $imageInfo["body"])) {
                fclose($local_file);
                }
             }
            }
            
        }
        
        
        
        
    }
    
    
    private function jisuanfc($obj,$out_trade_no)
    {
        
        
        
       
        //计算往上3级分成,第1级,通过openid搜索p_openid
        
        $sql="select * from wxpay_fc order by jibie ";
        $res = $GLOBALS['db']->getAll($sql);
        
        $openid=$obj['openid'];
        //计算第三级
        $n_openid_3=$obj['openid'];
        $p_openid_3=$obj['p_openid'];
        
        //插入分成金额
        $REarr3=array("add_time"=>time(),"openid"=>$openid,'n_openid'=>$n_openid_3,"p_openid"=>$p_openid_3,'out_trade_no'=>$out_trade_no,'jibie'=>$res[2]['jibie'],'fenchengjine'=>$res[2]['fenchengjine']);
        $arr3 = $GLOBALS['db']->autoExecute("wxpay_fclog", $REarr3, 'INSERT');
        
        
        $n_openid_2=$p_openid_3;
        $p_openid_2=$this->shangjiopenid($n_openid_2);
        
        
        
        
        
        $REarr2=array("add_time"=>time(),"openid"=>$openid,'n_openid'=>$n_openid_2,"p_openid"=>$p_openid_2,'out_trade_no'=>$out_trade_no,'jibie'=>$res[1]['jibie'],'fenchengjine'=>$res[1]['fenchengjine']);
        $arr2 = $GLOBALS['db']->autoExecute("wxpay_fclog", $REarr2, 'INSERT');
        
        $n_openid_1=$p_openid_2;
        $p_openid_1=$this->shangjiopenid($n_openid_1);
        
        $REarr1=array("add_time"=>time(),"openid"=>$openid,'n_openid'=>$n_openid_1,"p_openid"=>$p_openid_1,'out_trade_no'=>$out_trade_no,'jibie'=>$res[0]['jibie'],'fenchengjine'=>$res[0]['fenchengjine']);
        $arr1 = $GLOBALS['db']->autoExecute("wxpay_fclog", $REarr1, 'INSERT');
        
        
        require (dirname(__file__) . '/sub/sub_gettoken.php');

        require (dirname(__file__) . '/sub/sub_notifymbsend.php');
        //exit;

      
        
    }
    private function shangjiopenid($obj)
    {
        $uinfo="select tg_img,tg_qrcid,wx_pay,openid,wx_isfc,wx_fctime,p_openid from   users  where  openid='".$obj."' ";
        $uinfo = $GLOBALS['db']->getRow($uinfo);
        if($uinfo['openid']=='')
        {
            return '000';
        }
        else
        {
            return $uinfo['p_openid'];
        }
        
    }
    
    private function mbsend()
    {
        
    }
    
    //end
}

Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);


/*

session_start();
$C_orderSn=$_SESSION['C_orderSn'];

if ($C_orderSn!='')
{
    $status=$notify->Queryorder($C_orderSn); 
}
*/

//获取通知的数据
$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
//如果返回成功则验证签名
try {
	$result = WxPayResults::Init($xml);
} catch (WxPayException $e){
	$msg = $e->errorMessage();
	return false;
}

Log::DEBUG("out_trade_no:" . $result['out_trade_no']);




$C_orderSn=$result['out_trade_no'];

if ($C_orderSn!='')
{
    $status=$notify->Queryorder($C_orderSn); 
}
