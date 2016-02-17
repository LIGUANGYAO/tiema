<?php

define('IN_ECS', true);

define('CUSTOMER', 'CASLON');


//require (dirname(__file__) . '/sub/is_weixin.php');
require (dirname(__file__) . '/includes/init2.php');
$sql = " select app_id,app_secret from app_id where weixin_id=1";
$res = $GLOBALS['db']->getRow($sql);

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
 
    if (empty($_REQUEST['openid'])){
    if (isset($_GET['code'])) {
        $code = $_GET['code'];
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$res['app_id'].'&secret='.$res['app_secret'].'&code=' .
        $code . '&grant_type=authorization_code';
        $headers = array("Content-Type: text/xml; charset=utf-8");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $output = curl_exec($ch);
        curl_close($ch);
        $jsonstr = json_decode($output);
        $access_token = $jsonstr->access_token;
        $refresh_token = $jsonstr->refresh_token;
        $openid = $jsonstr->openid;
      }
      
      }
      else
      {
      $openid=$_REQUEST['openid'];
      }
      
 $openid="oGehCt7YZrpXFzxwZs-z-AADN_Ak";
      
      $sql123="select openid,qrcode,wx_tel,wx_pwd from users where openid='".$openid."' ";
      $res = $GLOBALS['db']->getAll($sql123);
    
      if(empty($res[0]['wx_tel']))
      {
       
        echo "<script>window.location.href='extel.php?openid=".$openid."';</script>"; 
      }
      
      else
      {
      $user_id3 = "select id from users where openid='" . $openid . "'";
      $user_id4 = $GLOBALS['db']->getRow($user_id3);
           // print_r($user_id4);
      if (empty($user_id4))
       {
       $smarty->display('error.tpl');
       }
       else
       {
        
        
        //开始矫健是否有未插入的中奖记录
       require (dirname(__file__) . '/sub/wx_test_sncode.php');
        
        
        //-----end;
        if(empty($res[0]['qrcode'])){
        if (isset($res[0]['openid']) && strlen($res[0]['openid'])==28) {
        $code = trim($res[0]['openid']);
        $PNG_TEMP_DIR = dirname(__file__) . DIRECTORY_SEPARATOR . 'upload/qrcode' .DIRECTORY_SEPARATOR;
        $PNG_WEB_DIR = 'upload/qrcode/';
        include "wx/phpqrcode/qrlib.php";
        if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
        $filename = $PNG_TEMP_DIR . 'test.png';
        $errorCorrectionLevel = 'L';
        $matrixPointSize = 10;
        if (isset($code)) {
        if (trim($code) == '')
        die('data cannot be empty!');
        $filename = $PNG_TEMP_DIR . 'qrcode_' . md5($code . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';
        QRcode::png($code, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
        } else {
        echo 'You can provide data in GET parameter:';
        QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize,2);
        }
        $temp_qrcode = 'qrcode_' . md5($code . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) .'.png';
        $temp_qrcode = $PNG_WEB_DIR.$temp_qrcode;
        $up_lo = "update users set qrcode='".$temp_qrcode."' where  openid='" . $res[0]['openid'] ."'";
        $up_lo = $GLOBALS['db']->query($up_lo);
        $sql123="select openid,qrcode,wx_tel,wx_pwd from users where openid='".$res[0]['openid']."' ";
        $res = $GLOBALS['db']->getAll($sql123);
        }
        }
       
        if (empty($_REQUEST['fall'])){
        $fall = 'list';
        }else{
        $fall = trim($_REQUEST['fall']);
        }
       
       if ($fall=='ewm') {
        $openid = trim($_REQUEST['openid']);  
        $is_active = trim($_REQUEST['is_active']);
        
       
       // $sql123="select users.openid,users.wx_tel,b.hd_sn,b.sncode,b.temp_qrcode,b.prizetype,b.add_time,activity.activity_name,d.card_sn,d.is_active from users,(select openid,hd_sn,sncode,temp_qrcode,prizetype,add_time from wx_sncode where openid='".$openid."' group by  openid,hd_sn,sncode,temp_qrcode,prizetype,add_time) b,activity,shop.shop_vouchers d
       // where users.openid=b.openid and b.hd_sn=activity.activity_sn and b.sncode=d.card_sn and users.wx_tel=d.user_id and d.is_active='".$is_active."'";
       // $res = $GLOBALS['db']->getAll($sql123);  
        
        //$now=date('Y-m-d H:i:s', time());
        if($is_active==2)
        {
        $sql123="select users.openid,users.wx_tel,b.hd_sn,b.sncode,b.temp_qrcode,b.prizetype,b.add_time,activity.activity_name,d.card_sn,d.is_active,d.start_time,d.end_time from users,(select openid,hd_sn,sncode,temp_qrcode,prizetype,add_time from wx_sncode where openid='".$openid."' group by  openid,hd_sn,sncode,temp_qrcode,prizetype,add_time) b,activity,shop.shop_vouchers d
        where users.openid=b.openid and b.hd_sn=activity.activity_sn and b.sncode=d.card_sn and users.wx_tel=d.user_id and  now() not between d.start_time and d.end_time";
        $res = $GLOBALS['db']->getAll($sql123);  
        }                
        else
        {
                if($is_active==1)
                {
                    $sql123="select users.openid,users.wx_tel,b.hd_sn,b.sncode,b.temp_qrcode,b.prizetype,b.add_time,activity.activity_name,d.card_sn,d.is_active,d.start_time,d.end_time from users,(select openid,hd_sn,sncode,temp_qrcode,prizetype,add_time from wx_sncode where openid='".$openid."' group by  openid,hd_sn,sncode,temp_qrcode,prizetype,add_time) b,activity,shop.shop_vouchers d
        where users.openid=b.openid and b.hd_sn=activity.activity_sn and b.sncode=d.card_sn and users.wx_tel=d.user_id and d.is_active='".$is_active."' and  now() between d.start_time and d.end_time ";
                    $res = $GLOBALS['db']->getAll($sql123);  
                    if(count($res)<=2)
                    {
                            for($k=0;$k<count($res);$k++)
                            {
                                $res[$k]['is_share']=0;
                            }
                    }
                    else
                    {
                        //假设c=10;
                         for($k=0;$k<count($res)-2;$k++)
                            {
                                $res[$k]['is_share']=1;
                            }
                          for($l=count($res)-2;$l<count($res);$l++)
                            {
                                $res[$l]['is_share']=0;
                            }
                    }
                      //已经查处所有的数据  未使用
                      
                }else
                {
                    $sql123="select users.openid,users.wx_tel,b.hd_sn,b.sncode,b.temp_qrcode,b.prizetype,b.add_time,activity.activity_name,d.card_sn,d.is_active,d.start_time,d.end_time from users,(select openid,hd_sn,sncode,temp_qrcode,prizetype,add_time from wx_sncode where openid='".$openid."' group by  openid,hd_sn,sncode,temp_qrcode,prizetype,add_time) b,activity,shop.shop_vouchers d
        where users.openid=b.openid and b.hd_sn=activity.activity_sn and b.sncode=d.card_sn and users.wx_tel=d.user_id and d.is_active='".$is_active."' and  now() between d.start_time and d.end_time";
        $res = $GLOBALS['db']->getAll($sql123);  
                }
        
        
              
                                       
        }
                        
        
      for($i=0;$i<count($res);$i++)
        {
            if($res[$i]['prizetype']==3) 
            {
                $sql_get="select prize3_jpms from activity_mx where p_id='".$res[$i]['hd_sn']."'";
                $aaa = $GLOBALS['db']->getRow($sql_get);
                $res[$i]['jpmc']=$aaa['prize3_jpms'];
            }
            
             if($res[$i]['prizetype']==2) 
            {
                $sql_get="select prize2_jpms from activity_mx where p_id='".$res[$i]['hd_sn']."'";
                $aaa = $GLOBALS['db']->getRow($sql_get);
                $res[$i]['jpmc']=$aaa['prize2_jpms'];
            }
            
             if($res[$i]['prizetype']==1) 
            {
                $sql_get="select prize1_jpms from activity_mx where p_id='".$res[$i]['hd_sn']."'";
                $aaa = $GLOBALS['db']->getRow($sql_get);
                $res[$i]['jpmc']=$aaa['prize1_jpms'];
            }
            
             if($res[$i]['prizetype']==11) 
            {
               
                $res[$i]['jpmc']="100元抵用卷";
            }
             if($res[$i]['prizetype']==12) 
            {
               
                $res[$i]['jpmc']="30元抵用卷";
            }
            
            
        }
        
        
        //print_r($res);
        $smarty->assign('is_active', $is_active);
        $smarty->assign('openid2', $openid);
        $smarty->assign('sncode', $res);
        }else{
   
       }
       
       
       $smarty->assign('fall', $fall);
       $smarty->assign('openid', $res[0]);
       $smarty->display('member.tpl');   
       }
       }
}


?>
