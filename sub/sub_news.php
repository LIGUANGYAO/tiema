<?php
function get_news_list($Nu)
    {
           $filer="";
           if (isset($_GET['Action'])) {
            $filer = $_GET['Action'];
           // echo $filer;
        }
        
           if (isset($_GET['title'])) {
            $filer = "where title like '%".trim($_GET['title'])."%'";
           // echo $filer;
        }
        
        //$filer = '20';
        $action_list = array();
        $count = "SELECT count(*) from news ".$filer.";";
        $res = $GLOBALS['db']->getAll($count);
        $res2=$res[0]['count(*)'];
        $obj=get_page($res2,$Nu);
        $sql = "SELECT * from news  ".$filer." order by id desc ". $obj['limit_obj'] .";";
        $res = $GLOBALS['db']->getAll($sql);
        //$noNum=20;
        return array('items'=>$res,'page'=>$obj,'sql'=>$sql);
       // print_r($sql);

    }
    



function page_count($obj,$page_no,$page_num)
{
    if(isset($obj))
    {
        $obj=$obj;
    }
    if(isset($page_no))
    {
        $page_no=$page_no;
    }
    else
    {
        $page_no=1;
    }
    if(isset($page_num))
    {
        $page_num=$page_num;
    }
    else
    {
        $page_num=20;
    }
 
}

function insert_news_mx()
{
    
    if(isset($_POST['title']))
    {
        $title=trim($_POST['title']);
    }
     if(isset($_POST['content']))
    {
        $content=trim($_POST['content']);
        $content=strip_tags($content,"<p><div><img><span>");
        $content=str_replace("<script","<sscript",$content);
        $content=str_replace("/script>","/scripts>",$content);
        $content=str_replace("/script >","/scripts>",$content);
        $content=str_replace("&nbsp;","",$content);
        
        
if(preg_match("/<img.*>/",$content))
{
$string = $content; 
$start = "<img";  
$end = "/>";  
$imgurl=get_between($string, $start, $end);  // output:hzhuti
$imgurl=get_between($imgurl,"src=",".jpg");
$imgurl=substr($imgurl,2);
$imgurl=$imgurl.".jpg";

//print_r($imgurl);
}

else
{$imgurl="../images/noimg.jpg";} 
        //$filer="goods_name = '".$goods_name."'";
    }
      if(isset($_POST['bid']))
    {
        $bid=trim($_POST['bid']);
    }
    $time=date('Y-m-d H:i:s',time());
    $htmlname=date("YmdHis").".html";
    //print_r($htmlname);
    $sql="insert into news(title,content,bid,imgurl,htmlurl,add_time) values ('".$title."','".$content."','".$bid."','".$imgurl."','".$htmlname."','".$time."');";
    $res = $GLOBALS['db']->query($sql);
    }


function delete_news_mx($id)
{
   $sql1="select * from news where id=$id";
   $res1=$GLOBALS['db']->getAll($sql1);
   $imgname=$res1[0]["imgurl"];
   $htmlname="html/".$res1[0]["htmlurl"];
   
  // print_r($imgname);
  //  print_r($htmlname);
    
   if(file_exists($imgname)&&file_exists($htmlname)&&($imgname!="../images/noimg.jpg"))
   {
    unlink($imgname);
    unlink($htmlname);
    $sql="delete from news where id=$id";
   $res = $GLOBALS['db']->query($sql);
   }
   elseif (file_exists($htmlname)&&($imgname=="../images/noimg.jpg"))
   {
    unlink($htmlname);
    $sql="delete from news where id=$id";
   $res = $GLOBALS['db']->query($sql);
   }
   else
   {
    echo "<script>alert('文件未找到！');window.go(-1)</script>";    
    exit;
   }
}
function get_newsmx()
{
    if (isset($_REQUEST['id'])) {
      $where=" where id='".$_REQUEST['id'];  
           // echo $filer;
        }
  
    $sql="select * from news ".$where."'";
    $res = $GLOBALS['db']->getAll($sql);
        //$noNum=20;
    return array('items'=>$res,'sql'=>$sql);
}


function get_newsmenu()
{
//    if (isset($_REQUEST['id'])) {
//      $where=" where id='".$_REQUEST['id'];  
//           // echo $filer;
//        }
  
    $sql="select * from menu_list where p_name is null";
    $res = $GLOBALS['db']->getAll($sql);
        //$noNum=20;
    return array('items'=>$res,'sql'=>$sql);
}




function update_news_mx($id)
{
   
     if(isset($_POST['title']))
    {
        $title=trim($_POST['title']);
        //$filer="goods_name = '".$goods_name."'";
    }
      if(isset($_REQUEST['bid']))
    {
        $bid=trim($_REQUEST['bid']);
    }
        if(isset($_REQUEST['content']))
    {
        $content=trim($_REQUEST['content']);
        $content=strip_tags($content,"<p><div><img><span>");
        $content=str_replace("<script","<sscript",$content);
        $content=str_replace("/script>","/scripts>",$content);
        $content=str_replace("/script >","/scripts>",$content);
        $content=str_replace("&nbsp;","",$content);
        
if(preg_match("/<img.*>/",$content))
{$string = $content;  
$start = "<img";  
$end = "/>";  
$imgurl=get_between($string, $start, $end);  // output:hzhuti
$imgurl=get_between($imgurl,"src=",".jpg");
$imgurl=substr($imgurl,2);
$imgurl=$imgurl.".jpg";


}
else
{
$imgurl="../images/noimg.jpg";
}        

    }  
    $time=date('Y-m-d H:i:s',time());
    
    
    
    
    $sql1="select * from news where id=$id";
   $res1=$GLOBALS['db']->getAll($sql1);
   $imgname=$res1[0]["imgurl"];
   $htmlname="html/".$res1[0]["htmlurl"];
   
  // print_r($imgname);
  //  print_r($htmlname);
    
   if(file_exists($imgname)&&file_exists($htmlname)&&($imgname!="../images/noimg.jpg"))
   {
    
    unlink($htmlname);
    $htmlname=date("YmdHis").".html";
    $sql="update news set title='".$title."',bid ='".$bid."',content='".$content."',imgurl='".$imgurl."',htmlurl='".$htmlname."',last_update='".$time."' where id=$id;";
    $res = $GLOBALS['db']->query($sql);
    }
   elseif (file_exists($htmlname)&&($imgname=="../images/noimg.jpg"))
   {
    unlink($htmlname);
    $htmlname=date("YmdHis").".html";
    $sql="update news set title='".$title."',bid ='".$bid."',content='".$content."',imgurl='".$imgurl."',htmlurl='".$htmlname."',last_update='".$time."' where id=$id;";
    $res = $GLOBALS['db']->query($sql);
    
   
    
   }
   else
   {
    echo "<script>alert('文件未找到！');window.go(-1)</script>";    
    exit;
   }
    
}

function get_between($input, $start, $end)
{  
$substr = substr($input, strlen($start)+strpos($input, $start),(strlen($input) - strpos($input, $end))*(-1));  
return $substr;  
}  
?>