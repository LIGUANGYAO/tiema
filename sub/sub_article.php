<?php

//echo 1;


function get_article_list($Nu, $ma, $sql)
{
    
    if (isset($_REQUEST['Action'])) {
        $filer = $_REQUEST['Action'];
    }
  
    if (isset($_REQUEST['m_key'])) {
        $filer1 = " and ( article_sn like '%" . trim($_REQUEST['m_key']) .
            "%' or article_name like '%" . trim($_REQUEST['m_key']) . "%' or article_note_1 like '%" . trim($_REQUEST['m_key']) . "%' )";
    } else {
        $filer1 = '';
    }
  
     $filer = " where 1=1 $filer1 ";
    $action_list = array();

    $res2 = get_table_count($ma, $filer);
    $obj = get_page($res2, $Nu);


    //$sql="select id,article_sn,article_name,article_outer_name,article_note_1,article_note_2,article_note_3,article_note_4,article_note_5,article_name_eg,zz,tzsy,action_url,last_update,last_update_2,start_time,end_time,sort_no  from article ";
    $sql = $sql . $filer . " order by id  desc " . $obj['limit_obj'] . ";";
    $res = $GLOBALS['db']->getAll($sql);
    
     $url_this = "http://".$_SERVER ['HTTP_HOST']."".dirname($_SERVER['PHP_SELF']);
    for($i=0;$i<count($res);$i++)
    {
          
    //print_r($url_this."/html_".$article_sn.".html")

      $res[$i]['art_url']=$url_this."/html_".$res[$i]['article_sn'].".html";
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




function get_article_mx($ma,$sql)
{   
    $ma_sn=$ma."_sn";
    if (isset($_REQUEST[$ma_sn])) {
        $where = " where ".$ma_sn."='" . $_REQUEST[$ma_sn];
        // echo $filer;
    }

    //$sql = "select article_sn,article_name,article_outer_name,article_note_1,article_note_2,article_note_3,article_note_4,article_note_5,article_name_eg,zz,tzsy,action_url,last_update,last_update_2,start_time,end_time,sort_no  from article " 
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


function update_article_mx($tb,$field,$u_id,$time_f)
{   
     //$tb,$field,$u_id表，字段，关键字
    //print_r($field);
   // $field="article_name,article_note_1,article_note_2";
    $array = explode(",",$field);
 
    for($i=0;$i<count($array);$i++)
    {
        $dh1="='";$dh2="',";
        
        if($i==count($array)-1){$dh2="'";}
        $fi.=$array[$i].$dh1.req($array[$i]).$dh2;
        
    }
      $content=$_REQUEST['article_note_1'];
    if(preg_match("/<img.*>/",$content))
{
$string = $content;  
$start = "<img";  
$end = "/>";  
$imgurl=get_between($string, $start, $end);  // output:hzhuti
$imgurl=get_between($imgurl,"src=",".jpg");
//$imgurl=substr($imgurl,3);

$imgurl=substr($imgurl,7);
$imgurl=$imgurl.".jpg";
//print_r($imgurl);
}
else
{
    $imgurl="upload/noimg.jpg";
    } 
    
    
    
    //print_r($fi);exit;
    $sql="update ".$tb." set ".$fi.",imgurl='".$imgurl."' where ".$u_id." = '".req($u_id)."';";
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


function insert_article_mx($tb,$field,$time_f)
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
    
    $content=$_REQUEST['article_note_1'];
    if(preg_match("/<img.*>/",$content))
{
$string = $content;  
$start = "<img";  
$end = "/>";  
$imgurl=get_between($string, $start, $end);  // output:hzhuti
$imgurl=get_between($imgurl,"src=",".jpg");
//$imgurl=substr($imgurl,3);

$imgurl=substr($imgurl,7);
$imgurl=$imgurl.".jpg";
//print_r($imgurl);
}
else
{
    $imgurl="upload/noimg.jpg";
    } 

   // print_r($i);exit;
    $time=date('Y-m-d H:i:s', time());
    $sql="insert into ".$tb."(".$f1.",".$time_f[0]['field'].",imgurl) values(".$f2.",'".$time."','".$imgurl."')";
   //print_r($sql);exit;
    $res = $GLOBALS['db']->query($sql);

  
    
   //设置推广
    $up="update ".$tb." set is_tuig=1 where is_tuig='on'";
    $up = $GLOBALS['db']->query($up);
    $up="update ".$tb." set is_tuig=0 where is_tuig =''";
    $up = $GLOBALS['db']->query($up);

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
            //$sql=" insert into article_imgs (p_id,b_img_url,s_img_url,add_time,img_sum) values ('".$arr."','".$obj[$i]."','".$s_url."','".$now."',1);";
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

            $outer_article_sn_2 = $res_img2[0]['img_sum'] + 1;
            //print_r($res_img2);exit;

            $sql = " insert into ".$tb." (p_id,b_img_url,s_img_url,add_time,img_sum,width,height,resize_width,resize_height) values ('" .
                $arr . "','" . $obj[$i] . "','" . $s_url[$i] . "','" . $now . "'," . $outer_article_sn_2 .
                ",'" . $obj['guige'][$i]['width'] . "','" . $obj['guige'][$i]['height'] . "','" .
                $obj['guige'][$i]['resize_width'] . "','" . $obj['guige'][$i]['resize_height'] .
                "');";
            //$sql=" insert into article_imgs (p_id,b_img_url,s_img_url,add_time,img_sum) values ('".$arr."','".$obj[$i]."','".$s_url."','".$now."',".$outer_article_sn_2.");";
            //$sql=" insert into article_images (img_article_sn,img_url,outer_article_sn) values ('".$arr."','".$obj[$i]."',".$outer_article_sn_2.");";
            //print_r($sql);exit;
            $res = $GLOBALS['db']->query($sql);
            $update = " update ".$tb." set img_outer_id=concat(p_id,'_',img_sum) where p_id='" .
                $arr . "';";
            $res = $GLOBALS['db']->query($update);

        }

        //print_r($sql);

    }

}


function get_article_imgs_list($img_tb,$img_field,$img_u_id)
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
   // $sql = "select p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update  from article_imgs  where  p_id ='" . $obj . "'";
    $res = $GLOBALS['db']->getAll($sql);
    //$noNum=20;
    return array('items' => $res, 'sql' => $sql);

}



function article_html($htmlname)
{
    
        $sql="select article_sn,article_name,article_note_1,article_note_2,type,type_name,sort_no,is_tuig,seo,title from article where article_sn='".$htmlname."'";
        $res = $GLOBALS['db']->getAll($sql);
        //print_r($res);exit;
        $smarty->assign('article', $res);
     
        $content = $smarty->fetch('article_html.tpl',null,null,false); //用$Content[$i] 得到每页的内容
         //print_r($content);
         //替换完了，我们把内容写到文件里
         if(file_exists($htmlname)){
         @unlink($htmlname) ; //如果文件已经存在就把它删除
         }
         $fp = fopen('html/'.$htmlname.'.html',"w"); //以可写方式打开$HtmlName ，第一次循环是打开index_1.html
         fwrite($fp,$content); //用fwrite()函数， 把内容写入每个文件
         fclose($fp);//关闭打开的文件指针
}
function get_between($input, $start, $end)
{  
$substr = substr($input, strlen($start)+strpos($input, $start),(strlen($input) - strpos($input, $end))*(-1));  
return $substr;  
} 
?>