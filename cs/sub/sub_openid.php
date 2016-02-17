<?php


require_once "wxpay/lib/WxPay.Api.php";       
require_once "wxpay/WxPay.JsApiPay.php";
require_once 'wxpay/log.php';


//初始化日志
//$logHandler= new CLogFileHandler("wxpay/logs/".date('Y-m-d').'.log');
//$log = Log::Init($logHandler, 15);



        
        
        
        
        
        session_start();
        
        if(isset($_SESSION['C_OpenId']) and !empty($_SESSION['C_OpenId']))
        {
           $openId=$_SESSION['C_OpenId'];
        }
        else
        {
            //①、获取用户openid
            $tools = new JsApiPay();
            $openId = $tools->GetOpenid();
            $_SESSION['C_OpenId']=$openId;
        }
        
        
        //$openId='o9dBxw8-uSeaRsn8VxjKT2swujsE';
        //$openId='o9dBxwwxzlYWNAxQyu0oChvwRpSA';
        //$openId='oPfflwSrnPwk_7Cr9czMOYL6rq-c';
        //$openId='oPfflwelaFPSv7rhKEdvPUeIMuM8';
        
        //获取当前url
        
        $nurl= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].$_SERVER['HTTP_REFERER'];
        
        $nurl2= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        
        
        $nurl3=dirname('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']); 
        
        
        $company='晋江测试';;
        
        
        class Uinfo
        {
            public function openidGetInfo($openid)
            {
                $sql="select id,id as user_id,wx_pay,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,p_openid,headimgurl,tg_img,sex,province,city,login_status from users where openid ='".$openid."'";
                $res = $GLOBALS['db']->getRow($sql);
        
                return $res;
            }
            
            
            public function IdGetInfo($id)
            {
                $sql="select id,id as user_id,wx_pay,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,p_openid,headimgurl,tg_img,sex,province,city,login_status,tg_erweimaup as has_wx_code from users where id ='".$id."'";
                $res = $GLOBALS['db']->getRow($sql);
        
                return $res;
            }
            
            
            
            public function UserCount()
            {
                $sql="select count(*) as sl from users ";
                $res = $GLOBALS['db']->getRow($sql);
                
                return $res['sl'];
            }
            
            
            public function OpenIdGetPopenId($openid)
            {
                $sql="select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,p_openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime,tg_erweimaup as has_wx_code from users where p_openid ='".$openid."'  ";
                $res = $GLOBALS['db']->getAll($sql);
        
                return $res;
            }
            
            
            
        }
        
        
        
        function limit_array($page_no, $num)
        {
            if (isset($page_no) && isset($num)) {
        
                $limit = " limit " . $page_no*$num . "," . $num;
                return $limit;
            } else {
                return false;
            }
        
        }
            
            
            
        $App_id="wxeb117968565e9fce";
        $App_sercret="044d0baecced071c4190d320285ce517";
        
      
        
        $bookjj="<p></p>
   <p></p>";
        
        
        
        
     
        
?>