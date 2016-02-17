<?php

//$obj数组，一页显示数量
function get_page($obj, $pager_Size)
{

    //print_R($smartyArr);
    //记录总数，每页显示记录条数，总页数
    $pager_Total = $obj; //总记录数
    //echo $pager_Total;
    //$pager_Number='';
    //$pager_Size = $pager_Size;//设定每页显示的记录数
    $pager_Number = ceil($pager_Total / $pager_Size); //得到总页数，如果有小时就进一步取整
    //$pager_URL = "dummyhost.php?action=View";

    if (isset($_GET['pager_PageID']) && !empty($_GET['pager_PageID'])) {
        $pager_PageID = intval($_GET['pager_PageID']);
    } else {
        //如果是第一次访问，则设定当前页为第一页
        $pager_PageID = 1;
    }
    //echo $pager_PageID;

    //$pager_PageID=2;
    if ($pager_PageID == 1) {
        $pager_StartNum = 0;
        //如果当前页不是第一页，则记录是从当前的页数减去1乘以每页的显示记录数开始的
    } else {
        $pager_StartNum = ($pager_PageID - 1) * $pager_Size;
    }
    $pager_EndNum = $pager_StartNum + $pager_Size - 1;
    //如果当前页是第一页，且总页数大于1
    if ($pager_PageID == 1 && $pager_Number > 1) {
        //第一页
        $pager_Links = "上一页 | 下一页";
        //否则如果当前页是最后一页，且总页数大于1
    } elseif ($pager_PageID == $pager_Number && $pager_Number > 1) {
        //最后一页
        $pager_Links = "上一页 | 下一页";
        //否则如果当前页不是第一页，且当前页小于等于最后一页
    } elseif ($pager_PageID > 1 && $pager_PageID <= $pager_Number) {
        //中间
        $pager_Links = "上一页 | 下一页";
        //否则
    } else {
        $pager_Links = "上一页 | 下一页";
    }
    $pager_mod = $pager_Total % $pager_Size;
    if ($pager_EndNum > $pager_Total) {

        $now_PageNum = $pager_Total - $pager_StartNum;

    } else {
        $now_PageNum = $pager_EndNum - $pager_StartNum + 1;
        // echo 2;
    }
    //上一页
    if ($pager_PageID == 1) {
        $pager_PageID_ow = 1;
    } else {
        $pager_PageID_ow = $pager_PageID - 1;
    }
    if ($pager_PageID == $pager_Number) {
        $pager_PageID_next = $pager_Number;
    } else {
        $pager_PageID_next = $pager_PageID + 1;
    }

    $limit_obj = limit_array($pager_StartNum, $pager_Size);
    // pager_Total总数，
    //pager_Number总页数,
    //pager_PageID当前页数,
    //pager_PageID_ow上一页id,
    //pager_PageID_next下一页id,
    //pager_Size每页个数,
    //pager_StartNum本页开始记录数id,
    //pager_EndNum本页结束记录数id,
    //now_PageNum当页个数,
    //limit_obj数据库limit
    //  [page] => Array
    //        (
    //            [pager_Total] => 369
    //            [pager_Number] => 37
    //            [pager_PageID] => 36
    //            [pager_PageID_ow] => 35
    //            [pager_PageID_next] => 37
    //            [pager_Size] => 10
    //            [pager_StartNum] => 350
    //            [pager_EndNum] => 359
    //            [now_PageNum] => 10
    //            [limit_obj] =>  limit 350,10
    //        )

    $url = '?' . $_SERVER['QUERY_STRING'];
    return $page_Array = array(
        'pager_Total' => $pager_Total,
        'pager_Number' => $pager_Number,
        'pager_PageID' => $pager_PageID,
        'pager_PageID_ow' => $pager_PageID_ow,
        'pager_PageID_next' => $pager_PageID_next,
        'pager_Size' => $pager_Size,
        'pager_StartNum' => $pager_StartNum,
        'pager_EndNum' => $pager_EndNum,
        'now_PageNum' => $now_PageNum,
        'limit_obj' => $limit_obj,
        'url' => $url);
}

//$num 20/页面显示 limit数量，$page_no显示第几页select * from action limit 0,20
function limit_array($page_no, $num)
{
    if (isset($page_no) && isset($num)) {

        $limit = " limit " . $page_no . "," . $num;
        return $limit;
    } else {
        return false;
    }

}
function get_table_count($table, $filer)
{
    $count = "SELECT count(*) from " . $table . " " . $filer . ";";
    $res = $GLOBALS['db']->getAll($count);
    $res2 = $res[0]['count(*)'];
    return $res2;
}


function describe_tabel($table)
{
    $sql = "describe " . $table;
    $res = $GLOBALS['db']->getAll($sql);
    for ($i = 0; $i < count($res); $i++) {
        $dh = ",";
        if ($i == count($res)) {
            $dh = "";
        }
        $res2 .= $res[$i]['Field'] . $dh;

    }
    return $res2;
}
//echo limit_array(8,8);

//$now=date('Y-m-d H:i:s',time());


function get_table_count2($table, $filer)
{
    $count = "SELECT count(*) from " . $table . " " . $filer . " group by goods_sn;";
    $res = $GLOBALS['db']->getAll($count);
    $res2 = count($res);
    return $res2;
}

function grl()
{
    $url = $_SERVER['PHP_SELF'];
    $arr = explode('/', $url);
    $filename = $arr[count($arr) - 1];

    $us = getlogin_name();
    
    $u_info = "select user_code,user_name,user_name2 from admin_user where user_name ='" .
        $us . "'";
    $u_info = $GLOBALS['db']->getRow($u_info);
    if ($u_info['user_code'] == '000') {
        return array("000");
    } else {
        
        $sql = "SELECT a.action_id FROM action a  inner join role_act b on a.action_id=b.act_id inner join role_user c on  c.p_id=b.p_id where a.is_show=1  and  a.type='c3' and b.val=1 and a.action_code='" .
            $filename . "' and c.user_sn='" . $u_info['user_code'] .
            "'  group by b.val ,b.act_id,c.user_name  order by -a.sort_order,-b.act_id desc;";
        $res = $GLOBALS['db']->getAll($sql);

        return $res;
    }


}

$err = grl();

if (empty($err)) {
    $smarty->assign('role', '');
    $smarty->assign('url', $filename);
    $smarty->display('err.tpl');
    exit;
}

?>