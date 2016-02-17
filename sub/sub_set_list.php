<?php
function get_set_list($Nu)
    {
           $filer="";
           if (isset($_GET['Action'])) {
            $filer = $_GET['Action'];
           // echo $filer;
        }
        
           if (isset($_GET['list_name'])) {
            $filer = "where title like '%".trim($_GET['list_name'])."%'";
           // echo $filer;
        }
        
        //$filer = '20';
        $action_list = array();
        $count = "SELECT count(*) from set_list ".$filer.";";
        $res = $GLOBALS['db']->getAll($count);
        $res2=$res[0]['count(*)'];
        $obj=get_page($res2,$Nu);
        $sql = "SELECT * from  set_list  ".$filer." order by id desc ". $obj['limit_obj'] .";";
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

function insert_set_list_mx()
{
    
    if(isset($_POST['list_name']))
    {
        $list_name=trim($_POST['list_name']);
    }
    
     if(isset($_POST['list_fl']))
    {
        $list_fl=trim($_POST['list_fl']);
    }
    
     if(isset($_POST['is_show']))
    {
        $is_show=trim($_POST['is_show']);
    }
    if(isset($_POST['list_note']))
    {
        $list_note=trim($_POST['list_note']);        
    }
      if(isset($_POST['sort_no']))
    {
        $sort_no=trim($_POST['sort_no']);
    }
    $time=date('Y-m-d H:i:s',time());
    //print_r($htmlname);
    $sql="insert into set_list(list_name,list_fl,is_show,list_note,sort_no,add_time) values ('".$list_name."','".$list_fl."','".$is_show."','".$list_note."','".$sort_no."','".$time."');";
    $res = $GLOBALS['db']->query($sql);
    }


function delete_set_list_mx($id)
{
 
    $sql="delete from set_list where id=$id";
   $res = $GLOBALS['db']->query($sql);
  
  
}
function get_list_mx()
{
    if (isset($_REQUEST['id'])) {
      $where=" where id='".$_REQUEST['id'];  
           // echo $filer;
        }
  
    $sql="select * from set_list ".$where."'";
    $res = $GLOBALS['db']->getAll($sql);
        //$noNum=20;
    return array('items'=>$res,'sql'=>$sql);
}


function get_menu_list()
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




function update_set_list_mx($id)
{
   
      if(isset($_POST['list_name']))
    {
        $list_name=trim($_POST['list_name']);
    }
    
     if(isset($_POST['list_fl']))
    {
        $list_fl=trim($_POST['list_fl']);
    }
    
     if(isset($_POST['is_show']))
    {
        $is_show=trim($_POST['is_show']);
    }
    if(isset($_POST['list_note']))
    {
        $list_note=trim($_POST['list_note']);        
    }
      if(isset($_POST['sort_no']))
    {
        $sort_no=trim($_POST['sort_no']);
    }
    $time=date('Y-m-d H:i:s',time());

     $sql="update set_list set list_name='".$list_name."',list_fl ='".$list_fl."',is_show='".$is_show."',list_note='".$list_note."',sort_no='".$sort_no."',last_update='".$time."' where id=$id;";
    $res = $GLOBALS['db']->query($sql);
}


?>