<?php

function openid($Nu,$tb,$f)
{
    $sql = "select id,
                    p_id,
                    openid,
                    users_sn,
                    nick_name,
                    status,
                    tzsy,
                    is_send,
                    err_code,push_id,
                    error 
                    from  appsend_users";
    //关注时间,id,城市,省，国家，图片,用户昵称,


    if (isset($_REQUEST['Action'])) {
        $filer = $_REQUEST['Action'];
    }

    if (isset($_REQUEST['m_key'])) {
        $filer1 = " and ( nick_name like '%" . trim($_REQUEST['m_key'])."%' or openid like '%" . trim($_REQUEST['m_key'])."%' or users_sn like '%" . trim($_REQUEST['m_key'])."%' or province like '%" . trim($_REQUEST['m_key'])."%' or city like '%" . trim($_REQUEST['m_key'])."%' )";
    } else {
        $filer1 = '';
    }

    $action_list = array();
    $filer = " where p_id='".$f."' $filer1 ";
    $res2 = get_table_count($tb, $filer);
    $obj = get_page($res2, $Nu);


    //$sql="select id,order_info_sn,order_info_name,order_info_outer_name,order_info_note_1,order_info_note_2,order_info_note_3,order_info_note_4,order_info_note_5,order_info_name_eg,zz,tzsy,action_url,last_update,last_update_2,start_time,end_time,sort_no  from order_info ";
    $sql = $sql . $filer . " " . $obj['limit_obj'] . ";";
    //$sql = $sql . $filer . " order  by -sort_no  desc " . $obj['limit_obj'] . ";";
    $res = $GLOBALS['db']->getAll($sql);

    return array(
        'item' => $res,
        'page' => $obj);
   
}




?>