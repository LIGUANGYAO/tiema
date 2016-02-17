<?php

function business($Nu, $tb)
{
    $sql = "select id,
            business_sn,
            business_name,
            business_type,
            business_pp,
            p_id,
            qrcid,
            business_qy,
            ticket,
            province,
            city,
            district,
            business_address,
            business_lxr,
            business_tel,
            lbsaddress,
            lbsjd,
            lbswd,
            tzsy,
            img_url,
            bz1,
            bz2,
            bz3,
            bz4,
            bz5,
            add_time,
            last_update,
            last_update_2 
            from business";
    //关注时间,id,城市,省，国家，图片,用户昵称,


    if (isset($_REQUEST['Action'])) {
        $filer = $_REQUEST['Action'];
    }

    if (isset($_REQUEST['m_key'])) {
        $filer1 = " and ( business_sn like '%" . trim($_REQUEST['m_key']) .
            "%' or business_name like '%" . trim($_REQUEST['m_key']) . "%')";
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


function i_business($tb, $field, $time_f)
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
    
    
    
$content=$_REQUEST['bz1'];
if(preg_match("/<img.*>/i",$content))
{
$string = $content;  
$start = "<img";  
$end = "/>";  
$imgurl=get_between($string, $start, $end);  // output:hzhuti
$imgurl=get_between($imgurl,"src="," width"); //alt前空格不能去掉
$imgurl=remove_quote($imgurl);
$imgurl=substr($imgurl,8);  //    /weixin/ 8字符   根目录 1字符 注意修改
}
    // print_r($i);exit;
    $time = date('Y-m-d H:i:s', time());
    $sql = "insert into " . $tb . "(" . $f1 . "," . $time_f[0]['field'] .",img_url) values(" . $f2 . ",'" . $time . "','".$imgurl."')";
    //print_r($sql);exit;
    $res = $GLOBALS['db']->query($sql);
    return array('sql' => $sql);


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





function get_business_mx($obj)
{   
      $sql="select id,
            business_sn,
            business_name,
            business_type,
            p_id,
            qrcid,
            business_qy,
            province,
            city,
            district,
            business_address,
            business_lxr,
            business_tel,
            lbsaddress,
            lbsjd,
            lbswd,
            tzsy,
            img_url,
            bz1,
            bz2,
            bz3,
            bz4,
            bz5,
            add_time,
            last_update,
            
            last_update_2
            from business  where business_sn='".$obj."' ";
    $res = $GLOBALS['db']->getAll($sql);
    //$noNum=20;
    return array('items' => $res);
}





function update_business_mx($tb,$field,$u_id,$time_f)
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
    
$content=$_REQUEST['bz1'];
if(preg_match("/<img.*>/i",$content))
{
$string = $content;  
$start = "<img";  
$end = "/>";  
$imgurl=get_between($string, $start, $end);  // output:hzhuti
$imgurl=get_between($imgurl,"src="," width"); //alt前空格不能去掉
$imgurl=remove_quote($imgurl);
$imgurl=substr($imgurl,8);  //    /weixin/ 8字符   根目录 1字符 注意修改
//print_r($imgurl);

//$filetype=substr(strrchr($imgurl,'.'),1); 
//print_r($filetype);

}
    
    
    //print_r($string);
    $sql="update ".$tb." set ".$fi.",img_url='".$imgurl."' where ".$u_id." = '".req($u_id)."';";
    

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