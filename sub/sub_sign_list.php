<?php

function sign_list($Nu, $tb)
{
    $sql = "select id,
            openid,
            mu_name,
            mu_tel,
            mu_car,
            status,
            tzsy,
            add_time
            from joinin";
    //关注时间,id,城市,省，国家，图片,用户昵称,


    if (isset($_REQUEST['Action'])) {
        $filer = $_REQUEST['Action'];
    }

    if (isset($_REQUEST['m_key'])) {
        $filer1 = " and ( mu_name like '%" . trim($_REQUEST['m_key']) .
            "%' or mu_tel like '%" . trim($_REQUEST['m_key']) . "%' or mu_car like '%" . trim($_REQUEST['m_key']) . "%')";
    } else {
        $filer1 = '';
    }

    $action_list = array();
    $filer = " where 1=1 $filer1 ";
    $res2 = get_table_count($tb, $filer);
    $obj = get_page($res2, $Nu);


    //$sql="select id,order_info_sn,order_info_name,order_info_outer_name,order_info_note_1,order_info_note_2,order_info_note_3,order_info_note_4,order_info_note_5,order_info_name_eg,zz,tzsy,action_url,last_update,last_update_2,start_time,end_time,sort_no  from order_info ";
    $sql = $sql . $filer . " " . $obj['limit_obj'] . ";";
    //$sql = $sql . $filer . " order  by -sort_no  desc " . $obj['limit_obj'] . ";";
    $res = $GLOBALS['db']->getAll($sql);

    return array('item' => $res, 'page' => $obj);

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




function req($obj)
{
    //print_r($obj);
    if (isset($_REQUEST[$obj])) {
        if (is_string($_REQUEST[$obj])) {
            $aaa = trim($_REQUEST[$obj]);
            if ($aaa == "timeL") {
                $aaa = date('Y-m-d H:i:s', time());
            } elseif ($aaa == "timeS") {
                $aaa = date('Y-m-d', time());
            }
            return $aaa;
        } else {
            $aaa = $_REQUEST[$obj];
            if ($aaa == "timeL") {
                $aaa = date('Y-m-d H:i:s', time());
            } elseif ($aaa == "timeS") {
                $aaa = date('Y-m-d', time());
            }
            return $aaa;
        }

    }

}

?>