<?php

//$obj���飬һҳ��ʾ����
function get_page($obj, $pager_Size)
{

    //print_R($smartyArr);
    //��¼������ÿҳ��ʾ��¼��������ҳ��
    $pager_Total = $obj; //�ܼ�¼��
    //echo $pager_Total;
    //$pager_Number='';
    //$pager_Size = $pager_Size;//�趨ÿҳ��ʾ�ļ�¼��
    $pager_Number = ceil($pager_Total / $pager_Size); //�õ���ҳ���������Сʱ�ͽ�һ��ȡ��
    //$pager_URL = "dummyhost.php?action=View";

    if (isset($_GET['pager_PageID']) && !empty($_GET['pager_PageID'])) {
        $pager_PageID = intval($_GET['pager_PageID']);
    } else {
        //����ǵ�һ�η��ʣ����趨��ǰҳΪ��һҳ
        $pager_PageID = 1;
    }
    //echo $pager_PageID;

    //$pager_PageID=2;
    if ($pager_PageID == 1) {
        $pager_StartNum = 0;
        //�����ǰҳ���ǵ�һҳ�����¼�Ǵӵ�ǰ��ҳ����ȥ1����ÿҳ����ʾ��¼����ʼ��
    } else {
        $pager_StartNum = ($pager_PageID - 1) * $pager_Size;
    }
    $pager_EndNum = $pager_StartNum + $pager_Size - 1;
    //�����ǰҳ�ǵ�һҳ������ҳ������1
    if ($pager_PageID == 1 && $pager_Number > 1) {
        //��һҳ
        $pager_Links = "��һҳ | ��һҳ";
        //���������ǰҳ�����һҳ������ҳ������1
    } elseif ($pager_PageID == $pager_Number && $pager_Number > 1) {
        //���һҳ
        $pager_Links = "��һҳ | ��һҳ";
        //���������ǰҳ���ǵ�һҳ���ҵ�ǰҳС�ڵ������һҳ
    } elseif ($pager_PageID > 1 && $pager_PageID <= $pager_Number) {
        //�м�
        $pager_Links = "��һҳ | ��һҳ";
        //����
    } else {
        $pager_Links = "��һҳ | ��һҳ";
    }
    $pager_mod = $pager_Total % $pager_Size;
    if ($pager_EndNum > $pager_Total) {

        $now_PageNum = $pager_Total - $pager_StartNum;

    } else {
        $now_PageNum = $pager_EndNum - $pager_StartNum + 1;
        // echo 2;
    }
    //��һҳ
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
    // pager_Total������
    //pager_Number��ҳ��,
    //pager_PageID��ǰҳ��,
    //pager_PageID_ow��һҳid,
    //pager_PageID_next��һҳid,
    //pager_Sizeÿҳ����,
    //pager_StartNum��ҳ��ʼ��¼��id,
    //pager_EndNum��ҳ������¼��id,
    //now_PageNum��ҳ����,
    //limit_obj���ݿ�limit
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

//$num 20/ҳ����ʾ limit������$page_no��ʾ�ڼ�ҳselect * from action limit 0,20
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