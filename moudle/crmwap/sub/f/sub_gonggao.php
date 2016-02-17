<?php

//echo 1;


function get_gonggao_list($Nu, $ma, $sql)
{
    
    if (isset($_REQUEST['Action'])) {
        $filer = $_REQUEST['Action'];
    }
  
    if (isset($_REQUEST['m_key'])) {
        
        $f2="";
        $f2.="gonggao_name like '%" . trim($_REQUEST['m_key']) . "%' ";
        if($f2=='')
        {
            $filer1=" ";
        }
        else
        {
            $filer1=" and ( ".$f2.")";
        }
        
        

        
        
    } else {
        $filer1 = '';
    }
 
 
 
 
  
    $filer = " where 1=1 $filer1 ";
    $action_list = array();

    $res2 = get_table_count($ma, $filer);
    
    $obj = get_page($res2, $Nu);


    //$sql="select id,color_sn,color_name,color_outer_name,color_note_1,color_note_2,color_note_3,color_note_4,color_note_5,color_name_eg,zz,tzsy,action_url,last_update,last_update_2,start_time,end_time,sort_no  from color ";
    $sql = $sql . $filer . " order by id desc " . $obj['limit_obj'] . ";";
    
    //echo $sql;
    //order by id  desc 
    $res = $GLOBALS['db']->getAll($sql);
    
    /*
     $url_this = "http://".$_SERVER ['HTTP_HOST']."".dirname($_SERVER['PHP_SELF']);
    for($i=0;$i<count($res);$i++)
    {
          
    //print_r($url_this."/html_".$color_sn.".html")

      $res[$i]['art_url']=$url_this."/html_".$res[$i]['color_sn'].".html";
    }*/
    return array(
        'items' => $res,
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



function get_gonggao_mx($ma,$sql)
{   
    
    if (isset($_REQUEST[$ma])) {
        $where = " where ".$ma."='" . urldecode($_REQUEST[$ma]);
        // echo $filer;
    }

    //$sql = "select appid_sn,appid_name,appid_outer_name,appid_note_1,appid_note_2,appid_note_3,appid_note_4,appid_note_5,appid_name_eg,zz,tzsy,action_url,last_update,last_update_2,start_time,end_time,sort_no  from appid " 
    $sql=$sql.$where . "'";


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


function update_gonggao_mx($tb,$field,$u_id,$time_f)
{   
     //$tb,$field,$u_id±í£¬×Ö¶Î£¬¹Ø¼ü×Ö
    
   // $field="appid_name,appid_note_1,appid_note_2";
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
   // /* Çå³ý»º´æ */
//    clear_cache_files();

}




function insert_gonggao_mx($tb,$field,$time_f)
{
    $array = explode(",",$field);
 
    for($i=0;$i<count($array);$i++)
    {
       // $dh1="";$dh2=",";
//        
//        
//        if($i==count($array)-1)//        $f3.=$dh1.$array[$i].$dh2;
        $dhfj=",";
      
        $fj.=$array[$i].$dhfj;
       
        
        $fh1="'";$fh2="',";
        if($i==count($array)-1){$fh2="'";}
        $f2.=$fh1.req($array[$i]).$fh2;
        
    }
    
    $fj = substr($fj,0,strlen($fj)-1);
    
    $time=date('Y-m-d H:i:s', time());
    $sql="insert into ".$tb."(".$fj.",".$time_f[0]['field'].") values(".$f2.",'".$time."')";
    //print_r($sql);exit;
    $res = $GLOBALS['db']->query($sql);

  
 

    return array('sql' => $sql);
    ///* Çå³ý»º´æ */
//    clear_cache_files();

}




function img_insert($arr, $obj,$tb)
{
    //print_r(count($obj));exit;
    for ($i = 0; $i < count($obj) ; $i++) {
        
        $img_sum = " select count(*) as sl  from ".$tb." where p_id='" . $arr .
            "';";
        $res_img = $GLOBALS['db']->getAll($img_sum);
        //print_r($img_sum);exit;
        if ($res_img[0]['sl'] == 0) {
            $s_url[$i] = "s_" . $obj[$i];
            $now = date('Y-m-d H:i:s', time());
            //$sql=" insert into imgtext_imgs (p_id,b_img_url,s_img_url,add_time,img_sum) values ('".$arr."','".$obj[$i]."','".$s_url."','".$now."',1);";
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

            $outer_imgtext_sn_2 = $res_img2[0]['img_sum'] + 1;
            //print_r($res_img2);exit;

            $sql = " insert into ".$tb." (p_id,b_img_url,s_img_url,add_time,img_sum,width,height,resize_width,resize_height) values ('" .
                $arr . "','" . $obj[$i] . "','" . $s_url[$i] . "','" . $now . "'," . $outer_imgtext_sn_2 .
                ",'" . $obj['guige'][$i]['width'] . "','" . $obj['guige'][$i]['height'] . "','" .
                $obj['guige'][$i]['resize_width'] . "','" . $obj['guige'][$i]['resize_height'] .
                "');";
            //$sql=" insert into imgtext_imgs (p_id,b_img_url,s_img_url,add_time,img_sum) values ('".$arr."','".$obj[$i]."','".$s_url."','".$now."',".$outer_imgtext_sn_2.");";
            //$sql=" insert into imgtext_images (img_imgtext_sn,img_url,outer_imgtext_sn) values ('".$arr."','".$obj[$i]."',".$outer_imgtext_sn_2.");";
            //print_r($sql);exit;
            $res = $GLOBALS['db']->query($sql);
            $update = " update ".$tb." set img_outer_id=concat(p_id,'_',img_sum) where p_id='" .
                $arr . "';";
            $res = $GLOBALS['db']->query($update);

        }

        //print_r($sql);

    }

}


function get_imgs_list($img_tb,$img_field,$img_u_id)
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
   // $sql = "select p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update  from imgtext_imgs  where  p_id ='" . $obj . "'";
    $res = $GLOBALS['db']->getAll($sql);
    //$noNum=20;
    return array('items' => $res, 'sql' => $sql);

}

?>