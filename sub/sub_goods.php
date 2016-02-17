<?php

//echo 1;


function get_goods_list($Nu, $ma, $sql)
{

    if (isset($_REQUEST['Action'])) {
        $filer = $_REQUEST['Action'];
    }
    $ma_key = $ma . "_key";
    if (isset($_REQUEST[$ma_key])) {
        $ma_sn = $ma . "_sn";
        $filer = " where " . $ma_sn . " like '%" . trim($_REQUEST[$ma_key]) . "%' or goods_name like '%" . trim($_REQUEST[$ma_key]) . "%'";
    }

    $action_list = array();

    $res2 = get_table_count($ma, $filer);
    $obj = get_page($res2, $Nu);


    //$sql="select id,goods_sn,goods_name,goods_outer_name,goods_note_1,goods_note_2,goods_note_3,goods_note_4,goods_note_5,goods_name_eg,zz,tzsy,action_url,last_update,last_update_2,start_time,end_time,sort_no  from goods ";
    $sql = $sql . $filer . " order by -sort_no  desc " . $obj['limit_obj'] . ";";
    $res = $GLOBALS['db']->getAll($sql);

    return array(
        'items' => $res,
        'page' => $obj,
        'sql' => $sql);

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


function get_goods_mx($ma, $sql)
{
    $ma_sn = $ma . "_sn";
    if (isset($_REQUEST[$ma_sn])) {
        $where = " where " . $ma_sn . "='" . $_REQUEST[$ma_sn];
        // echo $filer;
    }

    //$sql = "select goods_sn,goods_name,goods_outer_name,goods_note_1,goods_note_2,goods_note_3,goods_note_4,goods_note_5,goods_name_eg,zz,tzsy,action_url,last_update,last_update_2,start_time,end_time,sort_no  from goods "
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


function goods_color($aaa, $color_ids_sn)
{
  //print_r($color_ids_sn);exit;
    $color_sql = "delete from goods_color where goods_sn='" . $aaa . "'";
    $res = $GLOBALS['db']->query($color_sql);
    if (!empty($color_ids_sn[0])) {
        
        for ($i=0;$i < count($color_ids_sn); $i++) {
            // $sql="insert into goods_colr(goods_sn,goods_color,goods_name) values('".$aaa."','".$color_ids_sn[$i]."',(select distinct(color_name) from color where color_sn='".$color_ids_sn[$i]."')) where goods_sn='"$aaa"' ";
       
            $ss = "insert into goods_color (goods_sn,color_sn,color_name) values ('" . $aaa .
                "','" . $color_ids_sn[$i] .
                "',(select color_name from color where color_sn='" . $color_ids_sn[$i] .
                "' group by color_sn))";
            $res = $GLOBALS['db']->query($ss);
        }
    }


}
function goods_size($aaa, $size_ids_sn)
{
   //print_r($size_ids_sn);exit;
    $size_sql = "delete from goods_size where goods_sn='" . $aaa . "'";
    $res = $GLOBALS['db']->query($size_sql);
    if (!empty($size_ids_sn[0])) {
        
        for ($i=0;$i < count($size_ids_sn); $i++) {
            // $sql="insert into goods_colr(goods_sn,goods_size,goods_name) values('".$aaa."','".$size_ids_sn[$i]."',(select distinct(size_name) from size where size_sn='".$size_ids_sn[$i]."')) where goods_sn='"$aaa"' ";
       
            $ss = "insert into goods_size (goods_sn,size_sn,size_name) values ('" . $aaa .
                "','" . $size_ids_sn[$i] .
                "',(select size_name from size where size_sn='" . $size_ids_sn[$i] .
                "' group by size_sn))";
            $res = $GLOBALS['db']->query($ss);
        }
    }


}

function update_goods_mx($tb, $field, $u_id, $time_f)
{
    //$tb,$field,$u_id表，字段，关键字
    
    //print_r($field);
    // $field="goods_name,goods_note_1,goods_note_2";
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
//print_r($sql);exit;
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

        $img_note_mx_update = " update goods_imgs set img_note_1 ='" . $img_note_1[$i] .
            "', img_note_2 ='" . $img_note_2[$i] . "', img_note_3 ='" . $img_note_3[$i] .
            "', img_action_url ='" . $img_action_url[$i] . "',last_update='" . $last_update .
            "' where img_outer_id='" . $img_code[$i] . "';";

        //  print_r($img_note_mx_update);


        $res = $GLOBALS['db']->query($img_note_mx_update);
    }

    //for($i=0;$i<)

    return array('sql' => $sql);

}


function insert_goods_mx($tb, $field, $time_f)
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
            " insert goods_imgs(p_id,img_note_1,img_note_2,img_note_3,img_action_url,last_update) values ('" .
            $goods_sn . "','" . $img_note_1[$i] . "','" . $img_note_2[$i] . "','" . $img_note_3[$i] .
            "','" . $img_action_url[$i] . "',);";

        // $img_note_mx_update=" update goods_imgs set img_note_1 ='".$img_note_1[$i]."', img_note_2 ='".$img_note_2[$i]."', img_note_3 ='".$img_note_3[$i]."', img_action_url ='".$img_action_url[$i]."',last_update='".$last_update."' where img_outer_id='".$img_code[$i]."';";

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
            //$sql=" insert into goods_imgs (p_id,b_img_url,s_img_url,add_time,img_sum) values ('".$arr."','".$obj[$i]."','".$s_url."','".$now."',1);";
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

            $outer_goods_sn_2 = $res_img2[0]['img_sum'] + 1;
            //print_r($res_img2);exit;

            $sql = " insert into " . $tb .
                " (p_id,b_img_url,s_img_url,add_time,img_sum,width,height,resize_width,resize_height) values ('" .
                $arr . "','" . $obj[$i] . "','" . $s_url[$i] . "','" . $now . "'," . $outer_goods_sn_2 .
                ",'" . $obj['guige'][$i]['width'] . "','" . $obj['guige'][$i]['height'] . "','" .
                $obj['guige'][$i]['resize_width'] . "','" . $obj['guige'][$i]['resize_height'] .
                "');";
            //$sql=" insert into goods_imgs (p_id,b_img_url,s_img_url,add_time,img_sum) values ('".$arr."','".$obj[$i]."','".$s_url."','".$now."',".$outer_goods_sn_2.");";
            //$sql=" insert into goods_images (img_goods_sn,img_url,outer_goods_sn) values ('".$arr."','".$obj[$i]."',".$outer_goods_sn_2.");";
            //print_r($sql);exit;
            $res = $GLOBALS['db']->query($sql);
            $update = " update " . $tb .
                " set img_outer_id=concat(p_id,'_',img_sum) where p_id='" . $arr . "';";
            $res = $GLOBALS['db']->query($update);

        }

        //print_r($sql);

    }

}


function get_goods_imgs_list($img_tb, $img_field, $img_u_id)
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
    // $sql = "select p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update  from goods_imgs  where  p_id ='" . $obj . "'";
    $res = $GLOBALS['db']->getAll($sql);
    //$noNum=20;
    return array('items' => $res, 'sql' => $sql);

}
?>