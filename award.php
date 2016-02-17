<?php

define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/sub_award.php');
require (dirname(__file__) . '/sub/page.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
    
  $list=award($Num,"wx_sncode");
  
  $smarty->assign('award_list',$list['item']);
  $smarty->assign('p_Array', $list['page']);
  $smarty->display('award.tpl');
}
if ($_REQUEST['act'] == 'award_xs') {
        if (isset($_REQUEST['id']) && isset($_REQUEST['alt'])) {
        $id = urldecode(trim($_REQUEST['id']));
        $alt = urldecode(trim($_REQUEST['alt']));

        $sql = "update wx_sncode set tzsy=" . $alt . " where  id= '" . $id .
            "'";
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";
    }else{
        echo "失败";
    }
}

if ($_REQUEST['act'] == 'award_dj') {
    require (dirname(__file__) . '/sub/rest.php'); 
    
    if (isset($_REQUEST['fid'])){
    $fid =urldecode(trim($_REQUEST['fid']));
    }        
    if (isset($_REQUEST['sncode'])){
    $sncode =trim($_REQUEST['sncode']);
    }   
    $sql = "select sncode from wx_sncode where id='".$fid."'";
    $res = $GLOBALS['db']->getAll($sql);
    $res=$res[0]['sncode'];
    
    if($sncode==$res){
    $time=date('Y-m-d H:i:s', time());
    $sql = "update wx_sncode set is_use=1,use_time='".$time."' where  id='".$fid."'";
    $res = $GLOBALS['db']->query($sql); 
    $userinfo=array("msg"=>"，恭喜您,验证成功","success"=>true); 
    $aaa = new arraytojson();
    $json = $aaa->JSON($userinfo);
    print_r($json); 
    }else{
    $userinfo=array("msg"=>"验证失败,请重新输入","success"=>true); 
    $aaa = new arraytojson();
    $json = $aaa->JSON($userinfo);
    print_r($json);
    }
    
    
    //$yzinfo=array("openid"=>$openid,"relay_info"=>$info,"msg"=>"OK","success"=>true);
    // print_r($res);
        
   
}





?>
