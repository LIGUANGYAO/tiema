<?php

function openid($Nu,$tb)
{
    $sql = "select users_sn,from_unixtime(subscribe_time) as sub_time,openid,language,city,province,country,headimgurl,nick_name,headimg_down,add_time,wx_tel,is_att from users";
    //关注时间,id,城市,省，国家，图片,用户昵称,


    if (isset($_REQUEST['Action'])) {
        $filer = $_REQUEST['Action'];
    }
    
    if($_REQUEST['is_att']==2)
    {
        $afi="";
    }else
    {
        $afi=" and is_att = '" . trim($_REQUEST['is_att'])."'";
    }
    
    
    if (isset($_REQUEST['m_key'])) {
        $filer1 = " and ( nick_name like '%" . trim($_REQUEST['m_key'])."%' or openid like '%" . trim($_REQUEST['m_key'])."%' or wx_tel like '%" . trim($_REQUEST['m_key'])."%' or users_sn like '%" . trim($_REQUEST['m_key'])."%' or province like '%" . trim($_REQUEST['m_key'])."%' or city like '%" . trim($_REQUEST['m_key'])."%' ) ".$afi;
    } else {
        $filer1 = '';
    }
    //echo $filer1;

    $action_list = array();
    $filer = " where 1=1 $filer1 ";
    $res2 = get_table_count($tb, $filer);
    $obj = get_page($res2, $Nu);


    //$sql="select id,order_info_sn,order_info_name,order_info_outer_name,order_info_note_1,order_info_note_2,order_info_note_3,order_info_note_4,order_info_note_5,order_info_name_eg,zz,tzsy,action_url,last_update,last_update_2,start_time,end_time,sort_no  from order_info ";
    $sql = $sql . $filer . "  order  by id  desc " . $obj['limit_obj'] . ";";
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