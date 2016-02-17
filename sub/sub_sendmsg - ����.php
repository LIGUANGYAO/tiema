<?php

//echo 1;


function get_sendmsg_list($Nu, $ma, $sql)
{
    
    if (isset($_REQUEST['Action'])) {
        $filer = $_REQUEST['Action'];
    }
  
    if (isset($_REQUEST['m_key'])) {
        $filer1 = " and ( sendmsg_sn like '%" . trim($_REQUEST['m_key']) .
            "%' or sendmsg_name like '%" . trim($_REQUEST['m_key']) . "%' or sendmsg_note_1 like '%" . trim($_REQUEST['m_key']) . "%' )";
    } else {
        $filer1 = '';
    }
  
     $filer = " where 1=1 $filer1 ";
    $action_list = array();

    $res2 = get_table_count($ma, $filer);
    $obj = get_page($res2, $Nu);


    //$sql="select id,sendmsg_sn,sendmsg_name,sendmsg_outer_name,sendmsg_note_1,sendmsg_note_2,sendmsg_note_3,sendmsg_note_4,sendmsg_note_5,sendmsg_name_eg,zz,tzsy,action_url,last_update,last_update_2,start_time,end_time,sort_no  from sendmsg ";
    $sql = $sql . $filer . " order by id  desc " . $obj['limit_obj'] . ";";
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




function get_sendmsg_mx($ma,$sql)
{   
    $ma_sn=$ma."_sn";
    if (isset($_REQUEST[$ma_sn])) {
        $where = " where ".$ma_sn."='" . $_REQUEST[$ma_sn];
        // echo $filer;
    }

    //$sql = "select sendmsg_sn,sendmsg_name,sendmsg_outer_name,sendmsg_note_1,sendmsg_note_2,sendmsg_note_3,sendmsg_note_4,sendmsg_note_5,sendmsg_name_eg,zz,tzsy,action_url,last_update,last_update_2,start_time,end_time,sort_no  from sendmsg " 
    $sql=$sql.$where . "'";


    $res = $GLOBALS['db']->getAll($sql);
   $q="select * from sendmsg_mx where p_id='".$_REQUEST[$ma_sn]."'";
     $res['prize'] = $GLOBALS['db']->getAll($q);
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


function update_sendmsg_mx($tb,$field,$u_id,$time_f)
{   
     //$tb,$field,$u_id表，字段，关键字
    //print_r($field);
   // $field="sendmsg_name,sendmsg_note_1,sendmsg_note_2";
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
    
  
    
    //for($i=0;$i<)

    return array('sql' => $sql);

}


function insert_sendmsg_mx($tb,$field,$time_f)
{
    $array = explode(",",$field);
 
    for($i=0;$i<count($array);$i++)
    {
        $dh1="";$dh2=",";
        
        if($i==count($array)-1){$dh2="";}
        $f1.=$dh1.$array[$i].$dh2;
        
        $fh1="'";$fh2="',";
        
        if($i==count($array)-1){$fh2="'";}
        $f2.=$fh1.req($array[$i]).$fh2;
        
    }
   // print_r($i);exit;
    $time=date('Y-m-d H:i:s', time());
    $sql="insert into ".$tb."(".$f1.",".$time_f[0]['field'].") values(".$f2.",'".$time."')";
   //print_r($sql);exit;
    $res = $GLOBALS['db']->query($sql);

  
    
    if(isset($_REQUEST['img_note_1']))
    {
        $img_note_1=$_REQUEST['img_note_1'];
    }
    if(isset($_REQUEST['img_note_2']))
    {
        $img_note_2=$_REQUEST['img_note_2'];
    }
    if(isset($_REQUEST['img_note_3']))
    {
        $img_note_3=$_REQUEST['img_note_3'];
    }
    if(isset($_REQUEST['img_code']))
    {
        $img_code=$_REQUEST['img_code'];
    }
    if(isset($_REQUEST['img_action_url']))
    {
        $img_action_url=$_REQUEST['img_action_url'];
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
    
    
    for($i=0;$i<count($img_code);$i++)
    {
        $img_note_mx_update=" insert sendmsg_imgs(p_id,img_note_1,img_note_2,img_note_3,img_action_url,last_update) values ('".$sendmsg_sn."','".$img_note_1[$i]."','".$img_note_2[$i]."','".$img_note_3[$i]."','".$img_action_url[$i]."',);";
        
       // $img_note_mx_update=" update sendmsg_imgs set img_note_1 ='".$img_note_1[$i]."', img_note_2 ='".$img_note_2[$i]."', img_note_3 ='".$img_note_3[$i]."', img_action_url ='".$img_action_url[$i]."',last_update='".$last_update."' where img_outer_id='".$img_code[$i]."';";
        
      //  print_r($img_note_mx_update);
        
        
        $res = $GLOBALS['db']->query($img_note_mx_update);
    }
    
    //for($i=0;$i<)
    

    return array('sql' => $sql);

}

function img_insert($arr, $obj,$tb)
{
    //print_r($obj);exit;
    for ($i = 0; $i < count($obj) - 1; $i++) {
        $img_sum = " select count(*) as sl  from ".$tb." where p_id='" . $arr .
            "';";
        $res_img = $GLOBALS['db']->getAll($img_sum);
        //print_r($img_sum);exit;
        if ($res_img[0]['sl'] == 0) {
            $s_url[$i] = "s_" . $obj[$i];
            $now = date('Y-m-d H:i:s', time());
            //$sql=" insert into sendmsg_imgs (p_id,b_img_url,s_img_url,add_time,img_sum) values ('".$arr."','".$obj[$i]."','".$s_url."','".$now."',1);";
            $sql = " insert into ".$tb." (p_id,b_img_url,s_img_url,add_time,img_sum,width,height,resize_width,resize_height) values ('" .
                $arr . "','" . $obj[$i] . "','" . $s_url[$i] . "','" . $now . "',1,'" . $obj['guige'][$i]['width'] .
                "','" . $obj['guige'][$i]['height'] . "','" . $obj['guige'][$i]['resize_width'] .
                "','" . $obj['guige'][$i]['resize_height'] . "');";

            //print_r($sql);exit;
            $res = $GLOBALS['db']->query($sql);
            $update = " update ".$tb." set img_outer_id=concat(p_id,'_',img_sum) where p_id='" .
                $arr . "';";
            $res = $GLOBALS['db']->query($update);

        } else {
            $s_url[$i] = "s_" . $obj[$i];
            $now = date('Y-m-d H:i:s', time());

            $img_count = " select max(img_sum) as img_sum from ".$tb."  where p_id='" .
                $arr . "';";

            $res_img2 = $GLOBALS['db']->getAll($img_count);

            $outer_sendmsg_sn_2 = $res_img2[0]['img_sum'] + 1;
            //print_r($res_img2);exit;

            $sql = " insert into ".$tb." (p_id,b_img_url,s_img_url,add_time,img_sum,width,height,resize_width,resize_height) values ('" .
                $arr . "','" . $obj[$i] . "','" . $s_url[$i] . "','" . $now . "'," . $outer_sendmsg_sn_2 .
                ",'" . $obj['guige'][$i]['width'] . "','" . $obj['guige'][$i]['height'] . "','" .
                $obj['guige'][$i]['resize_width'] . "','" . $obj['guige'][$i]['resize_height'] .
                "');";
            //$sql=" insert into sendmsg_imgs (p_id,b_img_url,s_img_url,add_time,img_sum) values ('".$arr."','".$obj[$i]."','".$s_url."','".$now."',".$outer_sendmsg_sn_2.");";
            //$sql=" insert into sendmsg_images (img_sendmsg_sn,img_url,outer_sendmsg_sn) values ('".$arr."','".$obj[$i]."',".$outer_sendmsg_sn_2.");";
            //print_r($sql);exit;
            $res = $GLOBALS['db']->query($sql);
            $update = " update ".$tb." set img_outer_id=concat(p_id,'_',img_sum) where p_id='" .
                $arr . "';";
            $res = $GLOBALS['db']->query($update);

        }

        //print_r($sql);

    }

}


function get_sendmsg_imgs_list($img_tb,$img_field,$img_u_id)
{   
        function req2($obj)
    {
    if (isset($_REQUEST[$obj])) {$aaa = trim($_REQUEST[$obj]);}
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
    
    if (isset($_REQUEST[$img_u_id])) {
        $obj = $_REQUEST[$img_u_id];
        // echo $filer;
    }
    
    $obj = trim($obj);
    $sql="select ".$img_field." from ".$img_tb." where p_id='".$img_u_id."'";    
   // $sql = "select p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update  from sendmsg_imgs  where  p_id ='" . $obj . "'";
    $res = $GLOBALS['db']->getAll($sql);
    //$noNum=20;
    return array('items' => $res, 'sql' => $sql);

}




function get_sendmsg_users_list($p_id)
{
    
    //$sql="select p_id,
//                    openid,
//                    users_sn,
//                    nick_name,
//                    status,
//                    tzsy,
//                    is_send,
//                    err_code,
//                    error from sendmsg_users where is_send =0 and p_id='".$p_id."'";
    $sql="select count(openid) as sum from sendmsg_users where  p_id='".$p_id."'";
    $res = $GLOBALS['db']->getRow($sql);
    
    $sum="select count(openid) as unsend_sum from sendmsg_users where is_send =0 and p_id='".$p_id."'";
    $sum = $GLOBALS['db']->getRow($sum);
    
    
    $sum2="select count(openid) as timeout from sendmsg_users where error='发送失败,该用户48小时内未产生交互信息' and p_id='".$p_id."'";
    $sum2 = $GLOBALS['db']->getRow($sum2);
    
    
    $sum3="select count(openid) as send_su from sendmsg_users where error='消息发送成功' and p_id='".$p_id."'";
    $sum3 = $GLOBALS['db']->getRow($sum3);
    
    $res1=array("sum"=>$res['sum'],"send_sum"=>$res['sum']-$sum['unsend_sum'],"unsend_sum"=>$sum['unsend_sum'],"timeout"=>$sum2['timeout'],"send_su"=>$sum3['send_su']);
    return $res1;

}




?>