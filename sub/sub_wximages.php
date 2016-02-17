<?php

//echo 1;


function get_wximages_list($Nu, $ma, $sql)
{
    
    if (isset($_REQUEST['Action'])) {
        $filer = $_REQUEST['Action'];
    }
  
    if (isset($_REQUEST['m_key'])) {
        $filer1 = " and ( wximages_sn like '%" . trim($_REQUEST['m_key']) .
            "%' or wximages_name like '%" . trim($_REQUEST['m_key']) . "%' or wximages_note_1 like '%" . trim($_REQUEST['m_key']) . "%' )";
    } else {
        $filer1 = '';
    }
  
     $filer = " where 1=1 $filer1 ";
    $action_list = array();

    $res2 = get_table_count($ma, $filer);
    $obj = get_page($res2, $Nu);


    //$sql="select id,wximages_sn,wximages_name,wximages_outer_name,wximages_note_1,wximages_note_2,wximages_note_3,wximages_note_4,wximages_note_5,wximages_name_eg,zz,tzsy,action_url,last_update,last_update_2,start_time,end_time,sort_no  from wximages ";
    $sql = $sql . $filer . " order by id  desc " . $obj['limit_obj'] . ";";
    $res = $GLOBALS['db']->getAll($sql);
    
     $url_this = "http://".$_SERVER ['HTTP_HOST']."".dirname($_SERVER['PHP_SELF']);
    for($i=0;$i<count($res);$i++)
    {
          
    //print_r($url_this."/html_".$wximages_sn.".html")

      $res[$i]['art_url']=$url_this."/html/wximages/html_".$res[$i]['wximages_sn'].".html";
      
      $sql_get="select wxfloor_sn,wxfloor_name from wxfloor where type=3 and wxfloor_sn='".$res[$i]['wximages_lx']."'";
      $aaa = $GLOBALS['db']->getRow($sql_get);
      $res[$i]['wxfloor_name']=$aaa['wxfloor_name'];
      
       
    }
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




function get_wximages_mx($ma,$sql)
{   
    $ma_sn=$ma."_sn";
    if (isset($_REQUEST[$ma_sn])) {
        $where = " where ".$ma_sn."='" . $_REQUEST[$ma_sn];
        // echo $filer;
    }
    //$sql = "select wximages_sn,wximages_name,wximages_outer_name,wximages_note_1,wximages_note_2,wximages_note_3,wximages_note_4,wximages_note_5,wximages_name_eg,zz,tzsy,action_url,last_update,last_update_2,start_time,end_time,sort_no  from wximages " 
    $sql=$sql.$where."'";



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


function update_wximages_mx($tb,$field,$u_id,$time_f)
{   
     //$tb,$field,$u_id表，字段，关键字
    //print_r($field);
   // $field="wximages_name,wximages_note_1,wximages_note_2";
    $array = explode(",",$field);
 
    for($i=0;$i<count($array);$i++)
    {
        $dh1="='";$dh2="',";
        
        if($i==count($array)-1){$dh2="'";}
        $fi.=$array[$i].$dh1.req($array[$i]).$dh2;
        
    }
//      $content=$_REQUEST['wximages_note_1'];
//    if(preg_match("/<img.*>/",$content))
//{
//$string = $content;  
//$start = "<img";  
//$end = "/>";  
//$imgurl=get_between($string, $start, $end);  // output:hzhuti
//$imgurl=get_between($imgurl,"src=",".jpg");
////$imgurl=substr($imgurl,3);
//
//$imgurl=substr($imgurl,7);
//$imgurl=$imgurl.".jpg";
////print_r($imgurl);
//}
//else
//{
//    $imgurl="upload/noimg.jpg";
//    } 
    
    
    
    //print_r($fi);exit;
   // $sql="update ".$tb." set ".$fi.",imgurl='".$imgurl."' where ".$u_id." = '".req($u_id)."';";
     $sql="update ".$tb." set ".$fi." where ".$u_id." = '".req($u_id)."';";
    $res = $GLOBALS['db']->query($sql);
    //print_r($sql);exit;
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
    //设置推广
    $up="update ".$tb." set is_tuig=1 where is_tuig='on'";
    $up = $GLOBALS['db']->query($up);
    return array('sql' => $sql);

}


function insert_wximages_mx($tb,$field,$time_f)
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
    
    //$content=$_REQUEST['wximages_note_1'];
// if(preg_match("/<img.*>/",$content))
//{
//$string = $content;  
//$start = "<img";  
//$end = "/>";  
//$imgurl=get_between($string, $start, $end);  // output:hzhuti
//$imgurl=get_between($imgurl,"src=",".jpg");
////$imgurl=substr($imgurl,3);
//
//$imgurl=substr($imgurl,7);
//$imgurl=$imgurl.".jpg";
////print_r($imgurl);
//}
//else
//{
//    $imgurl="upload/noimg.jpg";
//    } 

   // print_r($i);exit;
    $time=date('Y-m-d H:i:s', time());
    //$sql="insert into ".$tb."(".$f1.",".$time_f[0]['field'].",imgurl) values(".$f2.",'".$time."','".$imgurl."')";
    $sql="insert into ".$tb."(".$f1.",".$time_f[0]['field'].") values(".$f2.",'".$time."')";
   //print_r($sql);exit;
    $res = $GLOBALS['db']->query($sql);

  
    
   //设置推广
    $up="update ".$tb." set is_tuig=1 where is_tuig='on'";
    $up = $GLOBALS['db']->query($up);
    $up="update ".$tb." set is_tuig=0 where is_tuig =''";
    $up = $GLOBALS['db']->query($up);

    return array('sql' => $sql);

}




function get_wximages_imgs_list($img_tb,$img_field,$img_u_id)
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
   // $sql = "select p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update  from wximages_imgs  where  p_id ='" . $obj . "'";
    $res = $GLOBALS['db']->getAll($sql);
    //$noNum=20;
    return array('items' => $res, 'sql' => $sql);

}


function get_between($input, $start, $end)
{  
$substr = substr($input, strlen($start)+strpos($input, $start),(strlen($input) - strpos($input, $end))*(-1));  
return $substr;  
} 
?>