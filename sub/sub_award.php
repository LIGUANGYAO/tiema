<?php

function award($Nu,$tb)
{
    $sql = "select a.*,b.openid ,b.users_sn,b.nick_name from wx_sncode a left join users b on a.openid=b.openid ";


    if (isset($_REQUEST['Action'])) {
        $filer = $_REQUEST['Action'];
    }

    if (isset($_REQUEST['m_key'])) {
        $filer1 = " and ( a.tel like '%" . trim($_REQUEST['m_key'])."%' or b.users_sn like '%" . trim($_REQUEST['m_key'])."%' or b.nick_name like '%" . trim($_REQUEST['m_key'])."%' or a.openid like '%" . trim($_REQUEST['m_key'])."%' or a.sncode like '%" . trim($_REQUEST['m_key'])."%')";
    } else {
        $filer1 = '';
    }

    $action_list = array();
    $filer = " where 1=1 $filer1 ";
    //$res2 = get_table_count($tb, $filer);
    
    $f = "select count(*) as sl from wx_sncode a left join users b on a.openid=b.openid " .$filer;
    $f = $GLOBALS['db']->getRow($f);
    
    $obj = get_page($f['sl'], $Nu);


    //$sql="select id,order_info_sn,order_info_name,order_info_outer_name,order_info_note_1,order_info_note_2,order_info_note_3,order_info_note_4,order_info_note_5,order_info_name_eg,zz,tzsy,action_url,last_update,last_update_2,start_time,end_time,sort_no  from order_info ";
    $sql = $sql . $filer . " " . $obj['limit_obj'] . ";";
    //$sql = $sql . $filer . " order  by -sort_no  desc " . $obj['limit_obj'] . ";";
    $res = $GLOBALS['db']->getAll($sql);
    
    
    
    return array(
        'item' => $res,
        'page' => $obj);
   
}


function page_count($obj, $page_no, $page_num)
{
    if (isset($obj)) {
        $obj = $obj;
    }
    if (isset($page_no)) {
        $page_no = $page_no;
    } else {
        $page_no = 1;
    }
    if (isset($page_num)) {
        $page_num = $page_num;
    } else {
        $page_num = 20;
    }

}


?>