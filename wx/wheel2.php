<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/rest.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
    
    
    //开始设置活动的开始
    $whell = date('Y-m-d', time());
    $activity = "select a.activity_sn,a.activity_name,a.tzsy,a.hd_number,a.add_time,a.limit_time,a.start_time,a.end_time,b.* from activity a , activity_mx b  where a.ac_lx=2 and a.tzsy=0 and (a.start_time<='".$whell."' and a.end_time>'".$whell."') and a.activity_sn=b.p_id order by a.sort_no desc";
    

    $activity = $GLOBALS['db']->getAll($activity);
    
    
    $ac_sn=$activity[0]['activity_sn'];
    $hd_number=$activity[0]['hd_number'];
    $limit_time = $activity[0]['limit_time'];
    
    if (empty($activity)) {
       
            $data1 = array("error" => "activend", "msg" => "该时段无砸金蛋活动,活动时间请留意微信公众号");
          
          
            $bbb = new arraytojson();
            $json1 = $bbb->JSON($data1);
            print_r($json1);
            exit;
                
    }
    
    
    
    $ac_sn=$activity[0]['activity_sn'];
   
    $tot=($activity[0]['prize1_sl']-$activity[0]['prize1_sl2'])+($activity[0]['prize2_sl']-$activity[0]['prize2_sl2'])+($activity[0]['prize3_sl']-$activity[0]['prize3_sl2']);
    
    
    $GL1=$activity[0]['prize1_gl'];
    $GL2=$activity[0]['prize2_gl'];
    $GL3=$activity[0]['prize3_gl'];
    if($activity[0]['prize1_sl2']>=$activity[0]['prize1_sl'])
    {
         $GL1=0;
    }
    if($activity[0]['prize2_sl2']>=$activity[0]['prize2_sl'])
    {
         $GL2=0;
    }
    if($activity[0]['prize3_sl2']>=$activity[0]['prize3_sl'])
    {
         $GL3=0;
    }
    //print_r($activity);exit;
 //   echo $GL1;
//    echo $GL2;
//    echo $GL3;
//    exit;
   
    //获取概率
    function getReward($total = 1000,$gl1=0,$gl2=0,$gl3=0)
    {
    //    $win1 = floor((0.12 * $total) / 100);
//        $win2 = floor((3 * $total) / 100);
//        $win3 = floor((12 * $total) / 100);
        $win1 = floor(($gl1 * $total) / 100);
        $win2 = floor(($gl2 * $total) / 100);
        $win3 = floor(($gl3 * $total) / 100);
        $other = $total - $win1 - $win2 - $win3;
        $return = array();
        for ($i = 0; $i < $win1; $i++) {
            $return[] = 1;
        }
        for ($j = 0; $j < $win2; $j++) {
            $return[] = 2;
        }
        for ($m = 0; $m < $win3; $m++) {
            $return[] = 3;
        }
        for ($n = 0; $n < $other; $n++) {
            $return[] = 0;
        }
        shuffle($return);
        return $return[array_rand($return)];
    }
//print_r(getReward(1000,0.1,0.1,60)) ;exit;
     ///////////////////////////日期转换函数
function datetounit($obj)
{
   if (isset($obj)) 
   {
   $obj=strtotime($obj) ;
   }
   return $obj;
}

function unittodate($obj,$limit_time)
{
   if (isset($obj)) 
   {
   $obj= $obj+($limit_time*24*3600);
   $obj= date('Y-m-d H:i:s', $obj);
   }
   return $obj;
}
 ///////////////////////////日期转换函数   

    
    
    
    //$openid = "oIAant6KJ012swmuQxk7UzDiR7dk";
    if (isset($_REQUEST['openid'])) {
        //if (1 == 1) {
        $openid = $_REQUEST['openid'];
        $time = date('Y-m-d', time());
        $time2 = date('Y-m-d H:i:s', time());
        
               //到期时间
        $time3=datetounit($time2);
        $limittime=unittodate($time3,$limit_time);
        //到期时间
        
        $sum = "select today_sum,hd_lo_sum,lo_date from wx_lottery where openid='" . $openid .
            "' and lo_date='" . $time . "'";
        $today_sum = $GLOBALS['db']->getRow($sum);
        if (empty($today_sum['lo_date'])) {
            //如果当天的抽奖记录为空，为用户插入当天的记录
            $day_lo = "insert into  wx_lottery(openid,add_time,hd_sn,hd_lo_sum,lo_date) values('" .
                $openid . "','" . $time2 . "','".$ac_sn."','".$hd_number."','" . $time . "');";
            $day_lo = $GLOBALS['db']->query($day_lo);
        }
         $sum = "select today_sum,hd_lo_sum,lo_date from wx_lottery where openid='" . $openid .
            "' and lo_date='" . $time . "'";
            // $sum = "select a.today_sum,a.hd_lo_sum as no_sum,b.hd_number as hd_lo_sum,a.lo_date from wx_lottery a,activity b where a.openid='" . $openid .
            "' and a.lo_date='" . $time . "' and a.hd_sn=b.activity_sn";
        $today_sum = $GLOBALS['db']->getRow($sum);
        
        if ($today_sum['today_sum'] < $today_sum['hd_lo_sum']) {
            //这边后续还要补充一个如果奖品已经送完，data要相应的修改其值
            $data = getReward($tot,$GL1,$GL2,$GL3);
            //增加一次该用户的抽奖次数
            $up_lo = "update wx_lottery set today_sum=(today_sum+1) where   openid='" . $openid .
                "' and lo_date='" . $time . "'";
            $up_lo = $GLOBALS['db']->query($up_lo);
            if ($data == 1) {
                $lo_sn = generate_password();
                $data1 = array(
                    "prizetype" => $data,
                    "sn" => $lo_sn,
                    "success" => "1",
                    "msg" => "1等奖","t_sum"=>$today_sum['today_sum']+1,"c_sum"=>$today_sum['hd_lo_sum']);
                $sql3 = "insert into wx_sncode(openid,sncode,prizetype,add_time,limit_time,hd_sn,lo_date) values ('" .
                    $openid . "','" . $lo_sn . "','1','" . $time2 . "','" . $limittime . "','".$ac_sn."','" . $time . "')";
                $sql3 = $GLOBALS['db']->query($sql3);
                
                //增加中奖人数
                $sqlA = "update activity_mx set  prize1_sl2=(prize1_sl2+1) where p_id='".$ac_sn."'";
                $sqlA = $GLOBALS['db']->query($sqlA);
                
                
            } elseif ($data == 2) {
                $lo_sn = generate_password();
                $data1 = array(
                    "prizetype" => $data,
                    "sn" => $lo_sn,
                    "success" => "1",
                    "msg" => "2等奖","t_sum"=>$today_sum['today_sum']+1,"c_sum"=>$today_sum['hd_lo_sum']);
                $sql3 = "insert into wx_sncode(openid,sncode,prizetype,add_time,limit_time,hd_sn,lo_date) values ('" .
                    $openid . "','" . $lo_sn . "','2','" . $time2 . "','" . $limittime . "','".$ac_sn."','" . $time . "')";
                $sql3 = $GLOBALS['db']->query($sql3);
                
                
                //增加中奖人数
                $sqlA = "update activity_mx set  prize2_sl2=(prize2_sl2+1) where p_id='".$ac_sn."'";
                $sqlA = $GLOBALS['db']->query($sqlA);
            } elseif ($data == 3) {
                $lo_sn = generate_password();
                $data1 = array(
                    "prizetype" => $data,
                    "sn" => $lo_sn,
                    "success" => "1",
                    "msg" => "3等奖","t_sum"=>$today_sum['today_sum']+1,"c_sum"=>$today_sum['hd_lo_sum']);

                $sql3 = "insert into wx_sncode(openid,sncode,prizetype,add_time,limit_time,hd_sn,lo_date) values ('" .
                    $openid . "','" . $lo_sn . "','3','" . $time2 . "','" . $limittime . "','".$ac_sn."','" . $time . "')";
                $sql3 = $GLOBALS['db']->query($sql3);
                
                   //增加中奖人数
                $sqlA = "update activity_mx set  prize3_sl2=(prize3_sl2+1) where p_id='".$ac_sn."'";
                $sqlA = $GLOBALS['db']->query($sqlA);
            } else {
                //echo 1;
                $data1 = array("msg" => "没中奖","t_sum"=>$today_sum['today_sum']+1,"c_sum"=>$today_sum['hd_lo_sum']);
            }
            $aaa = new arraytojson();
            $json = $aaa->JSON($data1);
            print_r($json);
        } elseif ($today_sum['today_sum'] >= $today_sum['hd_lo_sum']) {
            //echo "超过";
            $data1 = array("error" => "invalid", "msg" => "您今天已经抽了 ".$hd_number." 次奖,不能再抽了,明天再来吧!");
            $aaa = new arraytojson();
            $json = $aaa->JSON($data1);
            print_r($json);
        } else {
            //$data1 = array("error" => "invalid", "msg" => $today_sum['today_sum']);
            //            $aaa = new arraytojson();
            //            $json = $aaa->JSON($data1);
            //            print_r($json);
        }

    }

    //

}

function generate_password($length = 30)
{
    // 密码字符集，可任意添加你需要的字符
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        // 这里提供两种字符获取方式
        // 第一种是使用 substr 截取$chars中的任意一位字符；
        // 第二种是取字符数组 $chars 的任意元素
        // $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        $password .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    $t = date('Y-m-d H:i:s', time());
    return md5($password . $t);
}

//echo generate_password();


if ($_REQUEST['act'] == 'setTel') {
       $time = date('Y-m-d', time());
        $time2 = date('Y-m-d H:i:s', time());
        $code=$_REQUEST['code'];
        $openid=$_REQUEST['openid'];
    if (isset($_REQUEST['tel'])) {
        $tel=$_REQUEST['tel'];
        
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR = 'temp/';
    include "phpqrcode/qrlib.php";    
    if (!file_exists($PNG_TEMP_DIR))
    mkdir($PNG_TEMP_DIR);
    $filename = $PNG_TEMP_DIR.'test.png';
    $errorCorrectionLevel = 'L';
    //if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
    //    $errorCorrectionLevel = $_REQUEST['level'];    

    $matrixPointSize = 10;
    //if (isset($_REQUEST['size']))
    //    $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


    if (isset($code)) { 
        if (trim($code) == '')
            die('data cannot be empty! <a href="?">back</a>');
        $filename = $PNG_TEMP_DIR.'test'.md5($code.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($code, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    }
    else {    
        echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';    
        QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    }    
        $temp_qrcode='test'.md5($code.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
    //display generated file
    //echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';
        $up_lo = "update wx_sncode set tel='".$tel."',temp_qrcode='".$temp_qrcode."' where   openid='" . $openid .
        "' and lo_date='" . $time . "' and sncode='".$code."'";
        $up_lo = $GLOBALS['db']->query($up_lo);
        $data1 = array("success" => true, "msg" => "发送成功,谢谢您的参与","changed1"=>true);
        $aaa = new arraytojson();
        $json = $aaa->JSON($data1);
        print_r($json);
    }

}

?>

