<?php

define('IN_ECS', true);

require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/sub_cj_qrcode_list.php');
require (dirname(__file__) . '/sub/page.php');



if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'default') {

    $list = cj_qrcode_list($Num, "cj_qrcode_stat");
    
   
    for($i=0;$i<count($list['item']);$i++)
    {
        $sql="select users_sn,nick_name from users where openid='".$list['item'][$i]['openid']."'";
        
        //echo $sql;
        $jj=$GLOBALS['db']->getRow($sql);
        $list['item'][$i]['nick_name']=$jj['nick_name'];
         $list['item'][$i]['users_sn']=$jj['users_sn'];
    }
    //print_r($list);
    $smarty->assign('cj_qrcode_list', $list['item']);
    $smarty->assign('p_Array', $list['page']);
    $smarty->display('cj_qrcode_list.tpl');
}


//禁用启用删除等操作

if ($_REQUEST['act'] == 'ed_status') {
  
    if (isset($_REQUEST['qiyong'])) {
        $code = urldecode(trim($_REQUEST['qiyong']));

        $sql = "update cj_qrcode_stat set tzsy=0 where  id= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "启用成功";
    } else {
       
    }
    
    
    
    
     if (isset($_REQUEST['jinyong'])) {
        $code = urldecode(trim($_REQUEST['jinyong'])) ;
        $sql = "update cj_qrcode_stat set tzsy=1 where  id= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "禁用成功";
    } else {
        
    }
    
    
    
    
    
     if (isset($_REQUEST['delete'])) {
        $code = urldecode(trim($_REQUEST['delete'])) ;
        $sql = "delete from  cj_qrcode_stat where  id= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";
    } else {
        
    }
}
?>
