<?php

//echo 1;


function get_wxmusic_list($Nu, $ma, $sql)
{
    
    if (isset($_REQUEST['Action'])) {
        $filer = $_REQUEST['Action'];
    }
  
    if (isset($_REQUEST['m_key'])) {
        $filer1 = " and ( wxmusic_sn like '%" . trim($_REQUEST['m_key']) .
            "%' or wxmusic_name like '%" . trim($_REQUEST['m_key']) . "%' or wxmusic_note_1 like '%" . trim($_REQUEST['m_key']) . "%' )";
    } else {
        $filer1 = '';
    }
  
     $filer = " where 1=1 $filer1 ";
    $action_list = array();

    $res2 = get_table_count($ma, $filer);
    $obj = get_page($res2, $Nu);


    //$sql="select id,wxmusic_sn,wxmusic_name,wxmusic_outer_name,wxmusic_note_1,wxmusic_note_2,wxmusic_note_3,wxmusic_note_4,wxmusic_note_5,wxmusic_name_eg,zz,tzsy,action_url,last_update,last_update_2,start_time,end_time,sort_no  from wxmusic ";
    $sql = $sql . $filer . " order by id  desc " . $obj['limit_obj'] . ";";
    $res = $GLOBALS['db']->getAll($sql);
    
     $url_this = "http://".$_SERVER ['HTTP_HOST']."".dirname($_SERVER['PHP_SELF']);
    for($i=0;$i<count($res);$i++)
    {
          
    //print_r($url_this."/html_".$wxmusic_sn.".html")

      $res[$i]['art_url']=$url_this."/html/wxmusic/html_".$res[$i]['wxmusic_sn'].".html";
      
      $sql_get="select wxfloor2_sn,wxfloor2_name from wxfloor2 where type=2 and wxfloor2_sn='".$res[$i]['wxmusic_lx']."'";
      $aaa = $GLOBALS['db']->getRow($sql_get);
      $res[$i]['wxfloor2_name']=$aaa['wxfloor2_name'];
      
       
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




function get_wxmusic_mx($ma,$sql)
{   
    $ma_sn=$ma."_sn";
    if (isset($_REQUEST[$ma_sn])) {
        $where = " where ".$ma_sn."='" . $_REQUEST[$ma_sn];
        // echo $filer;
    }
    //$sql = "select wxmusic_sn,wxmusic_name,wxmusic_outer_name,wxmusic_note_1,wxmusic_note_2,wxmusic_note_3,wxmusic_note_4,wxmusic_note_5,wxmusic_name_eg,zz,tzsy,action_url,last_update,last_update_2,start_time,end_time,sort_no  from wxmusic " 
    $sql=$sql.$where."'";

//print_r($ma_sn);

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


function update_wxmusic_mx($tb,$field,$u_id,$time_f)
{   
     //$tb,$field,$u_id表，字段，关键字
    //print_r($field);
   // $field="wxmusic_name,wxmusic_note_1,wxmusic_note_2";
    $array = explode(",",$field);
 
    for($i=0;$i<count($array);$i++)
    {
        $dh1="='";$dh2="',";
        
        if($i==count($array)-1){$dh2="'";}
        $fi.=$array[$i].$dh1.req($array[$i]).$dh2;
        
    }
      $content=$_REQUEST['wxmusic_note_1'];
    if(preg_match("/<embed.*>/i",$content))
{
$string = $content;  
$start = "<embed";  
$end = "/>";  
$imgurl=get_between($string, $start, $end);  // output:hzhuti
$imgurl=get_between($imgurl,"src="," type"); //TYPE前空格不能去掉
$imgurl=remove_quote($imgurl);
$imgurl=substr($imgurl,8);  //    /weixin/ 8字符   根目录 1字符 注意修改
//print_r($imgurl);

//$filetype=substr(strrchr($imgurl,'.'),1); 
//print_r($filetype);

}


//else
//{
//    $imgurl="upload/noimg.jpg";
//    } 
    
    
    
    //print_r($fi);exit;
    $sql="update ".$tb." set ".$fi.",imgurl='".$imgurl."' where ".$u_id." = '".req($u_id)."';";
     //$sql="update ".$tb." set ".$fi." where ".$u_id." = '".req($u_id)."';";
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


function insert_wxmusic_mx($tb,$field,$time_f)
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
    
      $content=$_REQUEST['wxmusic_note_1'];
    if(preg_match("/<embed.*>/i",$content))
{
$string = $content;  
$start = "<embed";  
$end = "/>";  
$imgurl=get_between($string, $start, $end);  // output:hzhuti
$imgurl=get_between($imgurl,"src="," type"); //TYPE前空格不能去掉
$imgurl=remove_quote($imgurl);
$imgurl=substr($imgurl,8);  //    /weixin/ 8字符   根目录 1字符 注意修改
//print_r($imgurl);

//$filetype=substr(strrchr($imgurl,'.'),1); 
//print_r($filetype);

}

   // print_r($i);exit;
    $time=date('Y-m-d H:i:s', time());
    $sql="insert into ".$tb."(".$f1.",".$time_f[0]['field'].",imgurl) values(".$f2.",'".$time."','".$imgurl."')";
    //$sql="insert into ".$tb."(".$f1.",".$time_f[0]['field'].") values(".$f2.",'".$time."')";
   //print_r($sql);exit;
    $res = $GLOBALS['db']->query($sql);

  
    
   //设置推广
    $up="update ".$tb." set is_tuig=1 where is_tuig='on'";
    $up = $GLOBALS['db']->query($up);
    $up="update ".$tb." set is_tuig=0 where is_tuig =''";
    $up = $GLOBALS['db']->query($up);

    return array('sql' => $sql);

}




function get_wxmusic_imgs_list($img_tb,$img_field,$img_u_id)
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
   // $sql = "select p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update  from wxmusic_imgs  where  p_id ='" . $obj . "'";
    $res = $GLOBALS['db']->getAll($sql);
    //$noNum=20;
    return array('items' => $res, 'sql' => $sql);

}


function get_between($input, $start, $end)
{  
$substr = substr($input, strlen($start)+strpos($input, $start),(strlen($input) - strpos($input, $end))*(-1));  
return $substr;  
} 
function remove_quote($str) {
        if (preg_match("/^\"/",$str)){
            $str = substr($str, 1, strlen($str) - 1);
        }
        //判断字符串是否以'"'结束
        if (preg_match("/\"$/",$str)){
            $str = substr($str, 0, strlen($str) - 1);;
        }
        return $str;
  }

?>