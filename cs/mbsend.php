<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init2.php');
require (dirname(__file__) . '/sub/sub_mbsend.php');
require (dirname(__file__) . '/sub/sub_gettoken.php');
require (dirname(__file__) . '/sub/sub_openid.php');


if (empty($_REQUEST['g'])) {
    $_REQUEST['g'] = 'default';
} else {
    $_REQUEST['g'] = trim($_REQUEST['g']);
}


if ($_REQUEST['g'] == 'default') {


    $mb = new mbxx();
    
    
    
    $mbid='3';

    $sql = "select * from wx_mb where id='".$mbid."' ";
    $res = $GLOBALS['db']->getRow($sql);
    
    
    
    $keyarr = explode(',',$res['keyword']); 
    
    $senddata=array();
    for($i=0;$i<count($keyarr);$i++)
    {
        
     
        $f= explode(':',$keyarr[$i]); 
        //$arr=array("".$f[0].""=>array("value"=>"123","color"=>"#92B901"));
        $senddata[$f[0]]=array("value"=>$f[1],"color"=>$f[2]);
        //array_push($senddata,$arr);
    }
//    $senddata = array("name" => array("value" => "A00001", "color" => "#92B901"),
//            "remark" => array("value" => "这块是自定义内容,", "color" => "#92B901"));

   // print_r($senddata);exit;
    $obj = new getArrToken();

    $mb->mbid=$mbid;
    $mb->token=$obj->getToken();
    
    
    //$openId='o9dBxw8-uSeaRsn8VxjKT2swujsE';
    
    $mb->mbarr= $mb->create_mbarr($openId,$res['template_id'],$res['url'],$res['topcolor'],$senddata);
    
    $mb->mbmsg();
    
    
    print_r($arr);   
}




?>