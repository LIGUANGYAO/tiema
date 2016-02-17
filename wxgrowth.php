<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init2.php');
require (dirname(__file__) . '/sub/sub_wxgrowth.php');
require (dirname(__file__) . '/sub/is_weixin.php');


if (empty($_REQUEST['m'])) {
    $_REQUEST['m'] = 'default';
} else {
    $_REQUEST['m'] = trim($_REQUEST['m']);
}

if ($_REQUEST['m'] == 'default') {
    
  
    ///修改1,查询语句
    //sort_no,tzsy 要记得添加
  
    $sql = " select app_id,app_secret from app_id where weixin_id=1 ";
    $res = $GLOBALS['db']->getRow($sql);
    //print_r($_GET['code']);

    if (isset($_GET['code'])) {
        $code = $_GET['code'];

        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $res['app_id'] .
            '&secret=' . $res['app_secret'] . '&code=' . $code .
            '&grant_type=authorization_code';

        $headers = array("Content-Type: text/xml; charset=utf-8");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $output = curl_exec($ch);
        curl_close($ch);
        //echo $output;

        $jsonstr = json_decode($output);
        //print_r($jsonstr);
        //print_r($jsonstr->access_token . "</br>");
        //print_r($jsonstr->refresh_token . "</br>");
        //print_r($jsonstr->openid . "</br>");
        $access_token = $jsonstr->access_token;
        $refresh_token = $jsonstr->refresh_token;
        $openid = $jsonstr->openid;


        $url1 = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token .
            '&openid=' . $openid . '';
        $headers = array("Content-Type: text/xml; charset=utf-8");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $output = curl_exec($ch);
        curl_close($ch);
        $jsonstr2 = json_decode($output);
        //echo $jsonstr2->nickname;

        $nickname = $jsonstr2->nickname;


    }
    //$openid="oGehCt7YZrpXFzxwZs-z-AADN_Ak";
    if (empty($openid)) {
        $smarty->display('error.tpl');
     }else{
         header("location:wxgrowth.php?m=dea2&openid=".$openid);
     }







}


if ($_REQUEST['m'] == 'dea2') {


    if (isset($_REQUEST['openid'])) {
 	    $openid = $_REQUEST['openid'];
    }
    $n_date = date("Y-m-d");

    $wk = "select count(week)  as sl from wxgrowth where openid='" . $openid . "'";
    $wk = $GLOBALS['db']->getRow($wk);


    function getNowweekStart($date = '')
    {

        //$date = date("Y-m-d");


        //当前日期
        $first = 1; //$first =1 表示每周星期一为开始时间 0表示每周日为开始时间
        $w = date("w", strtotime($date)); //获取当前周的第几天 周日是 0 周一 到周六是 1 -6
        $d = $w ? $w - $first : 6; //如果是周日 -6天
        $now_start = date("Y-m-d", strtotime("$date -" . $d . " days")); //本周开始时间
        $now_end = date("Y-m-d", strtotime("$now_start +6 days")); //本周结束时间
        $last_start = date('Y-m-d', strtotime("$now_start + 7 days")); //上周开始时间
        $last_end = date('Y-m-d', strtotime("$now_start + 13 days")); //上周结束时间

        return array(
            "now_start" => $now_start,
            "now_end" => $now_end,
            "last_start" => $last_start,
            "last_end" => $last_end);
    }
    function getChaBetweenTwoDate($date1, $date2)
    {

        $Date_List_a1 = explode("-", $date1);
        $Date_List_a2 = explode("-", $date2);

        $d1 = mktime(0, 0, 0, $Date_List_a1[1], $Date_List_a1[2], $Date_List_a1[0]);

        $d2 = mktime(0, 0, 0, $Date_List_a2[1], $Date_List_a2[2], $Date_List_a2[0]);

        $Days = round(($d1 - $d2) / 3600 / 24);

        return $Days;
    }

    //print_r(getNowweekStart("2014-05-27"));


    function getMaxweek($obj)
    {
        $sql = "select week,add_time from wxgrowth where openid='" . $obj .
            "' order by add_time desc";
        $res = $GLOBALS['db']->getRow($sql);
        $sql2 = "select week,add_time from wxgrowth where openid='" . $obj .
            "'  order by add_time ";
        $res2 = $GLOBALS['db']->getRow($sql2);
        return array("week_max" => $res, "week_min" => $res2);
    }
    
    $obj = getMaxweek($openid);
    //获取当前时间和数据库里面的最早的库存记录之间的间隔时间

    $max = getNowweekStart(date("Y-m-d"));
    $week_max = getNowweekStart($obj['week_max']['add_time']);
    //print_r($max);

    $btweek = (int)getChaBetweenTwoDate($max['now_start'], $week_max['now_start']) /
        7;

    //输出最近一周与现在时间的周间隔
    //  echo $week_max;


    if ($wk['sl'] == 0) {
        $insert_mi = "insert into wxgrowth(wx_growth_sn,openid,week,week_start,week_end,add_time) values ('" .
            $openid . "_1','" . $openid . "','1','" . $max['now_start'] . " 00:00:00','" . $max['now_end'] .
            " 23:59:59','" . $n_date . "') ";
        $insert_mi = $GLOBALS['db']->query($insert_mi);

        //插入明细

        for ($j = 0; $j < 7; $j++) {
            $insert_mx = "insert into wxgrowth_mx(p_id,day,add_time) values ('" . $openid .
                "_1','" . ($j + 1) . "','" . $n_date . "') ";
            $insert_mx = $GLOBALS['db']->query($insert_mx);
        }


    }


    //echo $btweek;exit;
    if ($btweek < 1) {

    } else {

        $week_min = getNowweekStart($obj['week_min']['add_time']);
        $btweek2 = (int)getChaBetweenTwoDate($max['now_start'], $week_min['now_start']) /
            7 + 1;


        //判断用户有多少系统周

        // echo $wk['sl'];
        $mi = $wk['sl'];
        // echo $mi + $btweek;  echo $btweek2;
        if (($mi + $btweek) <= $btweek2) {
            //判断需要增加多少周


            for ($i = $mi + 1; $i < $btweek2 + 1; $i++) {
                $aaa = $i - 1;

                $sel_week = "select week_start from wxgrowth where openid='" . $openid .
                    "' and week='" . $aaa . "'";

                $sel_week = $GLOBALS['db']->getRow($sel_week);
                $sel_aaa = getNowweekStart($sel_week['week_start']);
                //print_r($sel_aaa) ;exit;
                //获取结束时间

                $insert_mi = "insert into wxgrowth(wx_growth_sn,openid,week,week_start,week_end,add_time) values ('" .
                    $openid . "_" . $i . "','" . $openid . "','" . $i . "','" . $sel_aaa['last_start'] .
                    " 00:00:00','" . $sel_aaa['last_end'] . " 23:59:59','" . $n_date . "') ";
                $insert_mi = $GLOBALS['db']->query($insert_mi);


                //插入明细

                for ($k = 0; $k < 7; $k++) {
                    $insert_mx = "insert into wxgrowth_mx(p_id,day,add_time) values ('" . $openid .
                        "_" . $i . "','" . ($k + 1) . "','" . $n_date . "') ";
                    $insert_mx = $GLOBALS['db']->query($insert_mx);
                }

            }


        } else {

        }
        //输出最近一周与最大的周间隔
        //echo $btweek2;

    }

    if($_REQUEST['week'])
    {

        $n_week=(int)$_REQUEST['week'];
        
        $n_week1 = "select max(week)  as week from wxgrowth where openid='" . $openid . "'";
        $n_week1 = $GLOBALS['db']->getRow($n_week1);
     
       
        if($n_week<0 || $n_week>$n_week1['week'])
        {
            
            $n_week=$n_week1['week'];
        }
      
       
    }
    else
    {
        $n_week1 = "select max(week)  as week from wxgrowth where openid='" . $openid . "'";
        $n_week1 = $GLOBALS['db']->getRow($n_week1);
        
        $n_week=$n_week1['week'];
        
     
    }
    if($n_week==$n_week1['week'])
    {
        $w = date("w", strtotime($n_date));
        
        if($w==0)
        {
            $w=7;
        }
        //echo $w;
    }
    
    
    $growth_List = get_Wxgrowth($openid,$n_week);
   
    //
    //    $actionurl_list = get_actionurl_list($Num,"actionurl",$sql);
    //    //print_r($actionurl_list);
    $growth_List['item']['weekjia']=$growth_List['item']['week']+1;
    $growth_List['item']['weekjian']=$growth_List['item']['week']-1;
    
  
    $time = strtotime($growth_List['item']['week_start']);
    $growth_List['item']['week_start']=  date('m-d',$time); 
    
    
    $time = strtotime($growth_List['item']['week_end']);
    $growth_List['item']['week_end']=  date('m-d',$time); 

    //print_r($growth_List);
    if($growth_List['item']['week']==1)
    {
        $growth_List['item']['weekjian']=1;
    }
    
    
    $as=$wk['sl']-8;
    if($as<=0)
    {
        $as=0;
    }
    $sum_w = "select week from wxgrowth where openid='" . $openid . "' order by week   limit ".$as.",8";
    $sum_w = $GLOBALS['db']->getAll($sum_w);
    
    //print_r($growth_List);
    $smarty->assign('sum_w', $sum_w);
    $smarty->assign('taday', $w);
    $smarty->assign('openid', $openid);
    $smarty->assign('growth_List', $growth_List['item']);
    $smarty->assign('growth_sum', $growth_List['sum']);
    //     $smarty->assign('fall', 1);
    //    $smarty->assign('title', $aaa);
    //    $smarty->assign('p_Array', $actionurl_list['page']);
    $smarty->display('kalendar/index.html');


}

if ($_REQUEST['m'] == 'duizhao') {
    
    if (isset($_REQUEST['openid'])) {
 	    $openid = $_REQUEST['openid'];
    }
    $smarty->assign('openid', $openid);
    $smarty->display('kalendar/duizhao.html');


}

if ($_REQUEST['m'] == 'zongjie') {
    
      if (isset($_REQUEST['openid'])) {
 	    $openid = $_REQUEST['openid'];
    }
    $year=date('Y')+1; 
    $zxx=get_Wxgrowth2($openid,$year);//总星星
    
$sql1=" select 
(select shengao from wxgrowth where shengao!=0 and openid='".$openid."'  and week_start<'".$year."' order by week desc limit 1)
-
(select shengao from wxgrowth where shengao!=0 and openid='".$openid."'  and week_start<'".$year."' order by week asc limit 1)
as
shengao";
$res1 = $GLOBALS['db']->getRow($sql1);

$sql2=" select 
(select weight from wxgrowth where shengao!=0 and openid='".$openid."'  and week_start<'".$year."' order by week desc limit 1)
-
(select weight from wxgrowth where shengao!=0 and openid='".$openid."'  and week_start<'".$year."' order by week asc limit 1)
as
weight";
$res2 = $GLOBALS['db']->getRow($sql2);

$sql3=" select sum(jiankang) as jiankang from wxgrowth where openid='".$openid."'  and week_start<'".$year."'";
$res3 = $GLOBALS['db']->getRow($sql3);

////////////////////成绩
//$sql_1=" select count(result_1) as tsl from wxgrowth where result_1!=0 and openid='".$openid."'  and week_start<'".$year."'";
//$res_1 = $GLOBALS['db']->getRow($sql_1);
//$shuxue_1=$res_1['tsl'];
//
//$sql_1_1=" select result_1 from wxgrowth where result_1!=0 and openid='".$openid."'  and week_start<'".$year."'";
//$res_1_1 = $GLOBALS['db']->getRow($sql_1_1);
//$shuxue_1_1=$res_1_1['result_1'];

$sql_1=" select 
(select sum(result_1) as result_1 from wxgrowth where result_1!=0 and openid='".$openid."'  and week_start<'".$year."')
/
(select count(result_1) as tsl from wxgrowth where result_1!=0 and openid='".$openid."'  and week_start<'".$year."')
as
shuxue";
$res_1 = $GLOBALS['db']->getRow($sql_1);
$smarty->assign('shuxue', $res_1['shuxue']);

$sql_2=" select 
(select sum(result_2) as result_2 from wxgrowth where result_2!=0 and openid='".$openid."'  and week_start<'".$year."')
/
(select count(result_2) as tsl from wxgrowth where result_2!=0 and openid='".$openid."'  and week_start<'".$year."')
as
yuwen";
$res_2 = $GLOBALS['db']->getRow($sql_2);
$smarty->assign('yuwen', $res_2['yuwen']);

$sql_3=" select 
(select sum(result_3) as result_3 from wxgrowth where result_3!=0 and openid='".$openid."'  and week_start<'".$year."')
/
(select count(result_3) as tsl from wxgrowth where result_3!=0 and openid='".$openid."'  and week_start<'".$year."')
as
yingyu";
$res_3 = $GLOBALS['db']->getRow($sql_3);
$smarty->assign('yingyu', $res_3['yingyu']);

$sql_4=" select 
(select sum(result_4) as result_4 from wxgrowth where result_4!=0 and openid='".$openid."'  and week_start<'".$year."')
/
(select count(result_4) as tsl from wxgrowth where result_4!=0 and openid='".$openid."'  and week_start<'".$year."')
as
tiyu";
$res_4 = $GLOBALS['db']->getRow($sql_4);
$smarty->assign('tiyu', $res_4['tiyu']);

$sql_5=" select 
(select sum(result_5) as result_5 from wxgrowth where result_5!=0 and openid='".$openid."'  and week_start<'".$year."')
/
(select count(result_5) as tsl from wxgrowth where result_5!=0 and openid='".$openid."'  and week_start<'".$year."')
as
meishu";
$res_5 = $GLOBALS['db']->getRow($sql_5);
$smarty->assign('meishu', $res_5['meishu']);

$sql_6=" select 
(select sum(result_6) as result_6 from wxgrowth where result_6!=0 and openid='".$openid."'  and week_start<'".$year."')
/
(select count(result_6) as tsl from wxgrowth where result_6!=0 and openid='".$openid."'  and week_start<'".$year."')
as
yinyue";
$res_6 = $GLOBALS['db']->getRow($sql_6);
$smarty->assign('yinyue', $res_6['yinyue']);

$sql_7=" select 
(select sum(result_7) as result_7 from wxgrowth where result_7!=0 and openid='".$openid."'  and week_start<'".$year."')
/
(select count(result_7) as tsl from wxgrowth where result_7!=0 and openid='".$openid."'  and week_start<'".$year."')
as
ziran";
$res_7 = $GLOBALS['db']->getRow($sql_7);
$smarty->assign('ziran', $res_7['ziran']);

$sql_8=" select 
(select sum(result_8) as result_8 from wxgrowth where result_8!=0 and openid='".$openid."'  and week_start<'".$year."')
/
(select count(result_8) as tsl from wxgrowth where result_8!=0 and openid='".$openid."'  and week_start<'".$year."')
as
shehui";
$res_8 = $GLOBALS['db']->getRow($sql_8);
$smarty->assign('shehui', $res_8['shehui']);

 
 
 
 
 
 
     $smarty->assign('zxx', $zxx['c_sl']);
      $smarty->assign('shengao', $res1['shengao']);
       $smarty->assign('weight', $res2['weight']);
        $smarty->assign('jiankang', $res3['jiankang']);
    
   
    
    $smarty->assign('openid', $openid);
      $smarty->display('kalendar/zongjie.html');


}


?>