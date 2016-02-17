<?php
function insert_set_index_mx()
{
    
    if(isset($_REQUEST['title']))
    {
        $title=trim($_REQUEST['title']);
    }
    
      if(isset($_REQUEST['keyword']))
    {
        $keyword=trim($_REQUEST['keyword']);
    }
    
      if(isset($_REQUEST['mate']))
    {
        $mate=trim($_REQUEST['mate']);
    }
    
    
      if(isset($_REQUEST['imgurl']))
    {
        $imgurl=trim($_REQUEST['imgurl']);
    }
     if(isset($_REQUEST['content']))
    {
        $content=trim($_REQUEST['content']);
     }
    // if(isset($_REQUEST['bid']))
//    {
//        $bid=trim($_REQUEST['bid']);
//    }
    $time=date('Y-m-d H:i:s',time());
    $sql="insert into set_index(title,keyword,mate,content,imgurl,add_time) values ('".$title."','".$keyword."','".$mate."','".$content."','".$imgurl."','".$time."');";
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




function get_set_index_mx()
{
    if (isset($_REQUEST['id'])) {
      $where=" where id='".$_REQUEST['id'];  
           // echo $filer;
        }
       
  
   // $sql="select * from  set_index ".$where."'";
   
   $sql="select * from  set_index limit 1";
    $res = $GLOBALS['db']->getAll($sql);
        //$noNum=20;
    return array('items'=>$res,'sql'=>$sql);
}


//function get_newsmenu()
//{
//      }
//  
//    $sql="select * from menu_list where p_name is null";
//    $res = $GLOBALS['db']->getAll($sql);
//        //$noNum=20;
//    return array('items'=>$res,'sql'=>$sql);
//}




function update_set_index_mx($id)
{
   
   if(isset($_REQUEST['title']))
    {
        $title=trim($_REQUEST['title']);
    }
    
      if(isset($_REQUEST['keyword']))
    {
        $keyword=trim($_REQUEST['keyword']);
    }
    
      if(isset($_REQUEST['mate']))
    {
        $mate=trim($_REQUEST['mate']);
    }
    
    
      if(isset($_REQUEST['imgurl']))
    {
        $imgurl=trim($_REQUEST['imgurl']);
    }
     if(isset($_REQUEST['content']))
    {
        $content=trim($_REQUEST['content']);
     }

    
    $time=date('Y-m-d H:i:s',time());
    
    $sql="update set_index set title='".$title."',keyword ='".$keyword."',mate='".$mate."',imgurl='".$imgurl."',content='".$content."',last_update='".$time."' where id=$id;";
    $res = $GLOBALS['db']->query($sql);
    
//    $sql1="select * from news where id=$id";
//   $res1=$GLOBALS['db']->getAll($sql1);
//   $imgname=$res1[0]["imgurl"];
//   $htmlname="html/".$res1[0]["htmlurl"];
//    
//   if(file_exists($imgname)&&file_exists($htmlname)&&($imgname!="../images/noimg.jpg"))
//   {
//    
//    unlink($htmlname);
//    $htmlname=date("YmdHis").".html";
//    $sql="update news set title='".$title."',bid ='".$bid."',content='".$content."',imgurl='".$imgurl."',htmlurl='".$htmlname."',last_update='".$time."' where id=$id;";
//    $res = $GLOBALS['db']->query($sql);
//    }
//   elseif (file_exists($htmlname)&&($imgname=="../images/noimg.jpg"))
//   {
//    unlink($htmlname);
//    $htmlname=date("YmdHis").".html";
//    $sql="update news set title='".$title."',bid ='".$bid."',content='".$content."',imgurl='".$imgurl."',htmlurl='".$htmlname."',last_update='".$time."' where id=$id;";
//    $res = $GLOBALS['db']->query($sql);
//    
//   
//    
//   }
//   else
//   {
//    echo "<script>alert('文件未找到！');window.go(-1)</script>";    
//    exit;
//   }
    
}

function get_between($input, $start, $end)
{  
$substr = substr($input, strlen($start)+strpos($input, $start),(strlen($input) - strpos($input, $end))*(-1));  
return $substr;  
}  
?>