<?php
    function get_w_list_mx()
{
    if (isset($_REQUEST['id'])) {
      $where=" where bid='".$_REQUEST['id'];  
           // echo $filer;
        }
  
    $sql="select * from news ".$where."' order by id desc ";
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
  
    $sql="select * from set_list ";
    $res = $GLOBALS['db']->getAll($sql);
        //$noNum=20;
    return array('items'=>$res,'sql'=>$sql);
}

function get_w_list_one()
{
    if (isset($_REQUEST['id'])) {
      $where=" where id='".$_REQUEST['id'];  
//           // echo $filer;
        }
  
    $sql="select id,list_name from set_list ".$where."'";
    $res = $GLOBALS['db']->getAll($sql);
        //$noNum=20;
    return array('items'=>$res,'sql'=>$sql);
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



?>