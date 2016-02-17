<?php

function group($Nu, $tb)
{
    $sql = "select id,
            group_sn,
            group_name,
            group_type_sn,
            group_type_name,
            group_note,
            tzsy,
            add_time,
            last_update,
            last_update_2,v1,v2,v3,v4,v5,v6  
            from wx_group";
    //关注时间,id,城市,省，国家，图片,用户昵称,


    if (isset($_REQUEST['Action'])) {
        $filer = $_REQUEST['Action'];
    }

    if (isset($_REQUEST['m_key'])) {
        $filer1 = " and ( group_sn like '%" . trim($_REQUEST['m_key']) .
            "%' or group_name like '%" .trim($_REQUEST['m_key'])  . "%')";
    } else {
        $filer1 = '';
    }

    $action_list = array();
    $filer = " where 1=1 $filer1 ";
    $res2 = get_table_count($tb, $filer);
    $obj = get_page($res2, $Nu);


    //$sql="select id,order_info_sn,order_info_name,order_info_outer_name,order_info_note_1,order_info_note_2,order_info_note_3,order_info_note_4,order_info_note_5,order_info_name_eg,zz,tzsy,action_url,last_update,last_update_2,start_time,end_time,sort_no  from order_info ";
    $sql = $sql . $filer . "order by id desc " . $obj['limit_obj'] . ";";
    //$sql = $sql . $filer . " order  by -sort_no  desc " . $obj['limit_obj'] . ";";
    $res = $GLOBALS['db']->getAll($sql);

    return array('item' => $res, 'page' => $obj);

}


function group_list($sn)
{
  $sql="select id,group_sn,group_name,group_note,group_type_sn,group_type_name from wx_group where group_sn='" . $sn . "' ";
  $res = $GLOBALS['db']->getAll($sql);
  return array('items'=>$res,'sql'=>$sql);
}



function users_group($aaa, $color_ids_sn)
{
  //print_r($color_ids_sn);exit;
    $color_sql = "delete from wx_users_group where group_sn='" . $aaa . "'";
    $res = $GLOBALS['db']->query($color_sql);
    if (!empty($color_ids_sn[0])) {
        
        for ($i=0;$i < count($color_ids_sn); $i++) {
            // $sql="insert into goods_colr(goods_sn,goods_color,goods_name) values('".$aaa."','".$color_ids_sn[$i]."',(select distinct(color_name) from color where color_sn='".$color_ids_sn[$i]."')) where goods_sn='"$aaa"' ";
       
            $ss = "insert into wx_users_group(group_sn,users_sn,nick_name,openid) values ('" . $aaa .
                "','" . $color_ids_sn[$i] .
                "',(select nick_name from users where users_sn='" . $color_ids_sn[$i] .
                "' group by users_sn),(select openid from users where users_sn='" . $color_ids_sn[$i] .
                "' group by users_sn))";
                print_r($ss);
                
            $res = $GLOBALS['db']->query($ss);
        }
    }


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


function i_group($tb, $field, $time_f)
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
    return array('sql' => $sql);


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

function get_group_mx($obj)
{   
      $sql="select id,
            group_sn,
            group_name,
            group_type_sn,
            group_type_name,
            group_note,
            tzsy,
            add_time,
            last_update,
            last_update_2, qudao,shop,sales ,v1,v2,v3,v4,v5,v6 
            from wx_group where group_sn='".$obj."' ";
    $res = $GLOBALS['db']->getAll($sql);
    //$noNum=20;
    return array('items' => $res);
}

function get_users_group_mx($obj)
{   
      $sql="select id,
            group_sn,
            users_id,
            users_sn,
            nick_name,
            openid 
            from wx_users_group where group_sn='".$obj."' ";
    $res = $GLOBALS['db']->getAll($sql);
    //$noNum=20;
    return array('items' => $res);
}





function update_group_mx($tb,$field,$u_id,$time_f)
{   
     //$tb,$field,$u_id表，字段，关键字
    //print_r($field);
   // $field="color_name,color_note_1,color_note_2";
    $array = explode(",",$field);
 
    for($i=0;$i<count($array);$i++)
    {
        $dh1="='";$dh2="',";
        
        if($i==count($array)-1){$dh2="'";}
        $fi.=$array[$i].$dh1.req($array[$i]).$dh2;
        
    }
    
    //print_r($fi);exit;
    $sql="update ".$tb." set ".$fi." where ".$u_id." = '".req($u_id)."';";
    

    $res = $GLOBALS['db']->query($sql);
    
      for($j=0;$j<count($time_f);$j++)
    {
        if($time_f[$j]['type']==2)
        {
            $time=date('Y-m-d H:i:s', time());
        }
        elseif( $time_f[$j]['type']==1)
        {
           $time=date('Y-m-d', time());
        }
        
        $sql_t="update ".$tb." set " .$time_f[$j]['field']. "='".$time."' where ".$u_id." = '".req($u_id)."';";
        
        $res = $GLOBALS['db']->query($sql_t);
           
    }
     return array('sql' => $sql);
}
?>