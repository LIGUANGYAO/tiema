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
    function get_w_index_mx()
{
    if (isset($_REQUEST['id'])) {
      $where=" where id='".$_REQUEST['id'];  
           // echo $filer;
        }
  
    $sql="select * from set_index ";
    $res = $GLOBALS['db']->getAll($sql);
        //$noNum=20;
    return array('items'=>$res,'sql'=>$sql);
}


function get_w_list()
{
//    if (isset($_REQUEST['id'])) {
//      $where=" where id='".$_REQUEST['id'];  
//           // echo $filer;
//        }
  
    $sql="select * from set_list order by sort_no desc";
    $res = $GLOBALS['db']->getAll($sql);
        //$noNum=20;
    return array('items'=>$res,'sql'=>$sql);
}





?>