<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init2.php');
require (dirname(__file__) . '/sub/sub_wxgrowth.php');

if (empty($_REQUEST['m'])) {
    $_REQUEST['m'] = 'default';
} else {
    $_REQUEST['m'] = trim($_REQUEST['m']);
}




if ($_REQUEST['m'] == 'exXm') {


    $week = $_REQUEST['week'];
    $op = $_REQUEST['openid'];
    if (isset($_REQUEST['code'])) {
        $code = $_REQUEST['code'];

        $array = explode(",", $code);

        function up_xm($op, $wk, $arr)
        {
            //$sql="update "
            $sql = "select a.wx_growth_sn,b.* from wxgrowth a inner join wxgrowth_mx b on a.wx_growth_sn=b.p_id where a.openid='" .
                $op . "' and a.week='" . $wk . "' and b.day='" . $arr[0] . "'";
            $res = $GLOBALS['db']->getRow($sql);
            if ($res[$arr[1]] == 1) {
                $update = "update wxgrowth_mx set " . $arr[1] . "='0' where p_id='" . $res['wx_growth_sn'] .
                    "' and day='" . $arr[0] . "'";
                $update2 = $GLOBALS['db']->query($update);
                $xm_val = 0;

            } elseif ($res[$arr[1]] == 0) {
                $update = "update wxgrowth_mx set " . $arr[1] . "='1' where p_id='" . $res['wx_growth_sn'] .
                    "' and day='" . $arr[0] . "'";
                $update2 = $GLOBALS['db']->query($update);
                $xm_val = 1;
            }


            $mx = "select *,((case when xm1=1 then 1 when xm1!=1 then 0 end) +
    (case when xm2=1 then 1 when xm2!=1 then 0 end)+
    (case when xm3=1 then 1 when xm3!=1 then 0 end)+
    (case when xm4=1 then 1 when xm4!=1 then 0 end)+
    (case when xm5=1 then 1 when xm5!=1 then 0 end)+
    (case when xm6=1 then 1 when xm6!=1 then 0 end)+
    (case when xm7=1 then 1 when xm7!=1 then 0 end)+
    (case when xm8=1 then 1 when xm8!=1 then 0 end)
    
    ) as c_sl
   
    
     from wxgrowth_mx where p_id='" . $res['wx_growth_sn'] . "' and day='" . $arr[0] .
                "'";
            $res_mx = $GLOBALS['db']->getAll($mx);

            //统计总数量

            $sum = "select sum(xm1) as xm1,sum(xm2) as xm2,sum(xm3) as xm3,sum(xm4) as xm4,sum(xm5) as xm5,sum(xm6) as xm6,sum(xm7) as xm7,sum(xm8) as xm8,sum((case when xm1=1 then 1 when xm1!=1 then 0 end) +
    (case when xm2=1 then 1 when xm2!=1 then 0 end)+
    (case when xm3=1 then 1 when xm3!=1 then 0 end)+
    (case when xm4=1 then 1 when xm4!=1 then 0 end)+
    (case when xm5=1 then 1 when xm5!=1 then 0 end)+
    (case when xm6=1 then 1 when xm6!=1 then 0 end)+
    (case when xm7=1 then 1 when xm7!=1 then 0 end)+
    (case when xm8=1 then 1 when xm8!=1 then 0 end)
    
    ) as c_sl
   
    
     from wxgrowth_mx where p_id='" . $res['wx_growth_sn'] . "'";
            $sum = $GLOBALS['db']->getRow($sum);
            return array(
                "val" => $xm_val,
                "sl1" => $res_mx[0]['c_sl'],
                "sl2" => $sum[$arr[1]],
                "sl2_xm" => $arr[1],
                "sl3" => $sum['c_sl']);
            //return $res;

        }


        $date = up_xm($op, $week, $array);
        print_r(json_encode($date));
        //print_r($date);
    }

}



if ($_REQUEST['m'] == 'exResult') {
    
    $type = trim($_REQUEST['type1']);
    $val = trim($_REQUEST['val']);
    $week = $_REQUEST['week'];
    
    
    if(isset($_REQUEST['openid']))
    {
        $op = $_REQUEST['openid'];
        $update = "update wxgrowth  set " . $type . "='".$val."' where openid='" . $op .
                    "' and week='" . $week . "'";
        //echo $update;
        $update2 = $GLOBALS['db']->query($update);
    }

     
}


?>