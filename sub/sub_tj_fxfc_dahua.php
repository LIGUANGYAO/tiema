<?php

//echo 1;


function get_tj_fxfc_list($Nu, $ma, $sql)
{

    if (isset($_REQUEST['Action'])) {
        $filer = $_REQUEST['Action'];
    }


    if (isset($_REQUEST['m_key'])) {

        if ($_REQUEST['order_status'] == '') {
            $or_filer = '';
        } else {
            $or_filer = " a.order_status ='" . trim($_REQUEST['order_status']) . "' and ";
        }


        $filer1 = " and ( a.order_sn like '%" . trim($_REQUEST['m_key']) .
            "%' or b.cj_sn like '%" . trim($_REQUEST['m_key']) .
            "%' or b.cj_type like '%" . trim($_REQUEST['m_key']) .
            "%' or a.order_sn like '%" . trim($_REQUEST['m_key']) . "%'  ) and " . $or_filer .
            " a.queren_time between '" . trim($_REQUEST['t1']) .
            " 00:00:00' and '" . trim($_REQUEST['t2']) . " 23:59:59' ";
            
            //" from_unixtime( a.order_create_time) between '" . trim($_REQUEST['t1']) .
//            "' and '" . trim($_REQUEST['t2']) . "'";
        //  print_r($filer1);exit;
    } else {
        $filer1 = '';
    }
    
    
   

    $filer = " where  b.cj_type !='zb' and a.or_status='1'   $filer1 ";
    $action_list = array();

    $sql_c = "select count(a.order_sn) as c_cl  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid  where b.cj_type !='zb' and a.or_status='1' group by a.order_sn order by b.add_time,b.id";
    $sql_c = $GLOBALS['db']->getAll($sql_c);

    
    //$res2 = get_table_count($ma, $filer);
    $obj = get_page(count($sql_c), $Nu);


    //$sql="select id,tj_fxfc_sn,tj_fxfc_name,tj_fxfc_outer_name,tj_fxfc_note_1,tj_fxfc_note_2,tj_fxfc_note_3,tj_fxfc_note_4,tj_fxfc_note_5,tj_fxfc_name_eg,zz,tzsy,action_url,last_update,last_update_2,start_time,end_time,sort_no  from tj_fxfc ";
    $sql = $sql . $filer . " group by a.order_sn order by from_unixtime( a.order_create_time) desc,b.id desc " . $obj['limit_obj'] .
        ";";

    //print_r($sql);
    $res = $GLOBALS['db']->getAll($sql);

    return array(
        'items' => $res,
        'page' => $obj
        );

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


function get_tj_fxfc_mx($ma, $sql)
{
    $ma_sn = $ma . "_sn";
    if (isset($_REQUEST[$ma_sn])) {
        $where = " where " . $ma_sn . "='" . $_REQUEST[$ma_sn];
        // echo $filer;
    }

    //$sql = "select tj_fxfc_sn,tj_fxfc_name,tj_fxfc_outer_name,tj_fxfc_note_1,tj_fxfc_note_2,tj_fxfc_note_3,tj_fxfc_note_4,tj_fxfc_note_5,tj_fxfc_name_eg,zz,tzsy,action_url,last_update,last_update_2,start_time,end_time,sort_no  from tj_fxfc "
    $sql = $sql . $where . "'";


    $res = $GLOBALS['db']->getAll($sql);
    //$noNum=20;
    return array('items' => $res, 'sql' => $sql);
}

function req($obj)
{
    //print_r($obj);
  if (isset($_REQUEST[$obj])) {
    if(is_string($_REQUEST[$obj]))
    {
        $aaa = addslashes(trim($_REQUEST[$obj]));
        if($aaa=="timeL")
        {
        $aaa=date('Y-m-d H:i:s', time());
        }
        elseif($aaa=="timeS")
        {
        $aaa=date('Y-m-d', time());
        }
        return $aaa;
    }
    else
    {
        $aaa = addslashes($_REQUEST[$obj]) ;
         if($aaa=="timeL")
        {
        $aaa=date('Y-m-d H:i:s', time());
        }
        elseif($aaa=="timeS")
        {
        $aaa=date('Y-m-d', time());
        }
        return $aaa;
    }
        
    }
 
}


function update_tj_fxfc_mx($tb, $field, $u_id, $time_f)
{
    //$tb,$field,$u_id表，字段，关键字
    //print_r($field);
    // $field="tj_fxfc_name,tj_fxfc_note_1,tj_fxfc_note_2";
    $array = explode(",", $field);

    for ($i = 0; $i < count($array); $i++) {
        $dh1 = "='";
        $dh2 = "',";

        if ($i == count($array) - 1) {
            $dh2 = "'";
        }
        $fi .= $array[$i] . $dh1 . req($array[$i]) . $dh2;

    }
    //print_r($fi);exit;
    $sql = "update " . $tb . " set " . $fi . " where " . $u_id . " = '" . req($u_id) .
        "';";
    $res = $GLOBALS['db']->query($sql);

    for ($j = 0; $j < count($time_f); $j++) {
        if ($time_f[$j]['type'] == 2) {
            $time = date('Y-m-d H:i:s', time());
        } elseif ($time_f[$j]['type'] == 1) {
            $time = date('Y-m-d', time());
        }

        $sql_t = "update " . $tb . " set " . $time_f[$j]['field'] . "='" . $time .
            "' where " . $u_id . " = '" . req($u_id) . "';";

        $res = $GLOBALS['db']->query($sql_t);

    }

    //img部分-------------------------------------------------------------------------
    if (isset($_REQUEST['img_note_1'])) {
        $img_note_1 = $_REQUEST['img_note_1'];
    }
    if (isset($_REQUEST['img_note_2'])) {
        $img_note_2 = $_REQUEST['img_note_2'];
    }
    if (isset($_REQUEST['img_note_3'])) {
        $img_note_3 = $_REQUEST['img_note_3'];
    }
    if (isset($_REQUEST['img_code'])) {
        $img_code = $_REQUEST['img_code'];
    }
    if (isset($_REQUEST['img_action_url'])) {
        $img_action_url = $_REQUEST['img_action_url'];
    }

    //  print_r($img_note_1);
    //  print_r($img_code);exit;
    //    if(isset($_REQUEST['img_note_mx']))
    //    {
    //    $img_note_mx=$_REQUEST['img_note_mx'];
    //    }
    //    if(isset($_REQUEST['img_code']))
    //    {
    //    $img_code=$_REQUEST['img_code'];
    //    }


    for ($i = 0; $i < count($img_code); $i++) {

        $img_note_mx_update = " update tj_fxfc_imgs set img_note_1 ='" . $img_note_1[$i] .
            "', img_note_2 ='" . $img_note_2[$i] . "', img_note_3 ='" . $img_note_3[$i] .
            "', img_action_url ='" . $img_action_url[$i] . "',last_update='" . $last_update .
            "' where img_outer_id='" . $img_code[$i] . "';";

        //  print_r($img_note_mx_update);


        $res = $GLOBALS['db']->query($img_note_mx_update);
    }

    //for($i=0;$i<)

    return array('sql' => $sql);

}


function insert_tj_fxfc_mx($tb, $field, $time_f)
{
    $array = explode(",", $field);

    for ($i = 0; $i < count($array); $i++) {
        $dh1 = "";
        $dh2 = ",";

        if ($i == count($array) - 1) {
            $dh2 = "";
        }
        $f1 .= $dh1 . $array[$i] . $dh2;

        $fh1 = "'";
        $fh2 = "',";

        if ($i == count($array) - 1) {
            $fh2 = "'";
        }
        $f2 .= $fh1 . req($array[$i]) . $fh2;

    }
    // print_r($i);exit;
    $time = date('Y-m-d H:i:s', time());
    $sql = "insert into " . $tb . "(" . $f1 . "," . $time_f[0]['field'] .
        ") values(" . $f2 . ",'" . $time . "')";
    //print_r($sql);exit;
    $res = $GLOBALS['db']->query($sql);


    if (isset($_REQUEST['img_note_1'])) {
        $img_note_1 = $_REQUEST['img_note_1'];
    }
    if (isset($_REQUEST['img_note_2'])) {
        $img_note_2 = $_REQUEST['img_note_2'];
    }
    if (isset($_REQUEST['img_note_3'])) {
        $img_note_3 = $_REQUEST['img_note_3'];
    }
    if (isset($_REQUEST['img_code'])) {
        $img_code = $_REQUEST['img_code'];
    }
    if (isset($_REQUEST['img_action_url'])) {
        $img_action_url = $_REQUEST['img_action_url'];
    }

    //  print_r($img_note_1);
    //  print_r($img_code);exit;
    //    if(isset($_REQUEST['img_note_mx']))
    //    {
    //    $img_note_mx=$_REQUEST['img_note_mx'];
    //    }
    //    if(isset($_REQUEST['img_code']))
    //    {
    //    $img_code=$_REQUEST['img_code'];
    //    }


    for ($i = 0; $i < count($img_code); $i++) {
        $img_note_mx_update =
            " insert tj_fxfc_imgs(p_id,img_note_1,img_note_2,img_note_3,img_action_url,last_update) values ('" .
            $tj_fxfc_sn . "','" . $img_note_1[$i] . "','" . $img_note_2[$i] . "','" . $img_note_3[$i] .
            "','" . $img_action_url[$i] . "',);";

        // $img_note_mx_update=" update tj_fxfc_imgs set img_note_1 ='".$img_note_1[$i]."', img_note_2 ='".$img_note_2[$i]."', img_note_3 ='".$img_note_3[$i]."', img_action_url ='".$img_action_url[$i]."',last_update='".$last_update."' where img_outer_id='".$img_code[$i]."';";

        //  print_r($img_note_mx_update);


        $res = $GLOBALS['db']->query($img_note_mx_update);
    }

    //for($i=0;$i<)


    return array('sql' => $sql);

}

function img_insert($arr, $obj, $tb)
{
    //print_r($obj);exit;
    for ($i = 0; $i < count($obj) - 1; $i++) {
        $img_sum = " select count(*) as sl  from " . $tb . " where p_id='" . $arr . "';";
        $res_img = $GLOBALS['db']->getAll($img_sum);
        //print_r($img_sum);exit;
        if ($res_img[0]['sl'] == 0) {
            $s_url[$i] = "s_" . $obj[$i];
            $now = date('Y-m-d H:i:s', time());
            //$sql=" insert into tj_fxfc_imgs (p_id,b_img_url,s_img_url,add_time,img_sum) values ('".$arr."','".$obj[$i]."','".$s_url."','".$now."',1);";
            $sql = " insert into " . $tb .
                " (p_id,b_img_url,s_img_url,add_time,img_sum,width,height,resize_width,resize_height) values ('" .
                $arr . "','" . $obj[$i] . "','" . $s_url[$i] . "','" . $now . "',1,'" . $obj['guige'][$i]['width'] .
                "','" . $obj['guige'][$i]['height'] . "','" . $obj['guige'][$i]['resize_width'] .
                "','" . $obj['guige'][$i]['resize_height'] . "');";

            //print_r($sql);exit;
            $res = $GLOBALS['db']->query($sql);
            $update = " update " . $tb .
                " set img_outer_id=concat(p_id,'_',img_sum) where p_id='" . $arr . "';";
            $res = $GLOBALS['db']->query($update);

        } else {
            $s_url[$i] = "s_" . $obj[$i];
            $now = date('Y-m-d H:i:s', time());

            $img_count = " select max(img_sum) as img_sum from " . $tb . "  where p_id='" .
                $arr . "';";

            $res_img2 = $GLOBALS['db']->getAll($img_count);

            $outer_tj_fxfc_sn_2 = $res_img2[0]['img_sum'] + 1;
            //print_r($res_img2);exit;

            $sql = " insert into " . $tb .
                " (p_id,b_img_url,s_img_url,add_time,img_sum,width,height,resize_width,resize_height) values ('" .
                $arr . "','" . $obj[$i] . "','" . $s_url[$i] . "','" . $now . "'," . $outer_tj_fxfc_sn_2 .
                ",'" . $obj['guige'][$i]['width'] . "','" . $obj['guige'][$i]['height'] . "','" .
                $obj['guige'][$i]['resize_width'] . "','" . $obj['guige'][$i]['resize_height'] .
                "');";
            //$sql=" insert into tj_fxfc_imgs (p_id,b_img_url,s_img_url,add_time,img_sum) values ('".$arr."','".$obj[$i]."','".$s_url."','".$now."',".$outer_tj_fxfc_sn_2.");";
            //$sql=" insert into tj_fxfc_images (img_tj_fxfc_sn,img_url,outer_tj_fxfc_sn) values ('".$arr."','".$obj[$i]."',".$outer_tj_fxfc_sn_2.");";
            //print_r($sql);exit;
            $res = $GLOBALS['db']->query($sql);
            $update = " update " . $tb .
                " set img_outer_id=concat(p_id,'_',img_sum) where p_id='" . $arr . "';";
            $res = $GLOBALS['db']->query($update);

        }

        //print_r($sql);

    }

}


function get_tj_fxfc_imgs_list($img_tb, $img_field, $img_u_id)
{
    function req2($obj)
    {
        if (isset($_REQUEST[$obj])) {
            $aaa = trim($_REQUEST[$obj]);
        }
        if ($aaa == "timeL") {
            $aaa = date('Y-m-d H:i:s', time());
        } elseif ($aaa == "timeS") {
            $aaa = date('Y-m-d', time());
        }
        return $aaa;
    }

    if (isset($_REQUEST[$img_u_id])) {
        $obj = $_REQUEST[$img_u_id];
        // echo $filer;
    }

    $obj = trim($obj);
    $sql = "select " . $img_field . " from " . $img_tb . " where p_id='" . $img_u_id .
        "'";
    // $sql = "select p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update  from tj_fxfc_imgs  where  p_id ='" . $obj . "'";
    $res = $GLOBALS['db']->getAll($sql);
    //$noNum=20;
    return array('items' => $res, 'sql' => $sql);

}




?>