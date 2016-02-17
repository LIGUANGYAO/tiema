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

    //echo $th_time."<br/>";
    getpay_record($th_time);


   
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


function getpay_record($obj)
{


    $openid = "select p_openid as send_openid from wxpay_fclog where from_unixtime(add_time) between '" .
        $obj . " 00:00:00' and '" . $obj .
        " 23:59:59' and p_openid!='000'  and p_openid!='' group by p_openid";

    $openid = $GLOBALS['db']->getAll($openid);


    for ($j = 0; $j < count($openid); $j++) {

        $sn = suiji();

        $record_list = "select *,from_unixtime(add_time) as add_t from wxpay_fclog where from_unixtime(add_time) between '" .
            $obj . " 00:00:00' and '" . $obj . " 23:59:59' and p_openid='" . $openid[$j]['send_openid'] .
            "' and is_sc=0 ";

        $record_list = $GLOBALS['db']->getAll($record_list);
        $je = 0;
        $out_trade_no = '';
        for ($i = 0; $i < count($record_list); $i++) {
            $je += $record_list[$i]['fenchengjine'];
            $out_trade_no .= $record_list[$i]['out_trade_no'] . ",";

            if ($record_list[$i]['is_sc'] == '0') {
                $up = "update wxpay_fclog set is_sc=1 ,sc_time='" . time() . "',sc_sn='" . $sn .
                    "'  where id='" . $record_list[$i]['id'] . "'";
                //echo $up;
                $GLOBALS['db']->query($up);
            }


        }
        /*
         if(($je+$record_list[$i]['fenchengjine'])>$redpackMax)
            {
                getpay_record($obj);
            }
            else
            {

                $je += $record_list[$i]['fenchengjine'];
            }*/

        //红包最大金额
        $redpackMax = 200;


        // echo $je."<br>";

        //echo ceil($je/20)."<br>";

        $zjl = ceil($je / $redpackMax);

        for ($k = 0; $k < $zjl; $k++) {

            if ($k == ($zjl - 1)) {
                $scje = $je - $redpackMax * $k;


            } else {
                $scje = $redpackMax;
            }


            $REarr = array("add_time" => $obj, "send_openid" => $openid[$j]['send_openid'],
                "rb_sn" => $sn, "fenchengjine" => $scje, "bz" => $out_trade_no);
            $arr2 = $GLOBALS['db']->autoExecute("wxpay_fclog_rb", $REarr, 'INSERT');
        }

        // $sql = "select * from wxpay_fclog_rb where add_time='" . $obj . "' and send_openid='".$openid[$j]['send_openid']."'";
        //        $res = $GLOBALS['db']->getOne($sql);
        //
        //
        //
        //        if (!$res) {


        //   }
        //        else
        //        {
        //            $field_values = array("fenchengjine" => $je,"bz"=>$out_trade_no);
        //            $GLOBALS['db']->autoExecute('wxpay_fclog_rb', $field_values, "UPDATE", "add_time='".$obj."' and send_openid='".$openid[$j]['send_openid']."'");
        //
        //        }


    }


}



exit;
