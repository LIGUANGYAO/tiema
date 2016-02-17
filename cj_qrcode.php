<?php

define('IN_ECS', true);

require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/sub_cj_qrcode.php');
require (dirname(__file__) . '/sub/page.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'default') {

    $list = cj_qrcode($Num, "cj_qrcode");
    $smarty->assign('cj_qrcode_list', $list['item']);
    $smarty->assign('p_Array', $list['page']);
    $smarty->assign('fall', 'cj_qrcode');
    $smarty->display('cj_qrcode.tpl');
}


if ($_REQUEST['act'] == 'a_cj_qrcode') {
    $bh=get_api_bhwh();
    $smarty->assign('bh', $bh['items'][0]);
    $smarty->assign('fall', 'a_cj_qrcode');
    $smarty->display('cj_qrcode.tpl');
}

if ($_REQUEST['act'] == 'checkagent') {
   
    require (dirname(__file__) . '/sub/rest.php'); 
    if (isset($_REQUEST['qrcid'])) {
        $qrcid = trim($_REQUEST['qrcid']);
    }
       $sql_11 = "select * from cj_qrcode where qrcid='".$qrcid."'";
       $opq = $GLOBALS['db']->query($sql_11);
        if(is_array(mysql_fetch_array($opq))){
		$userinfo=array("msg"=>"已存在","success"=>true,"check"=>'1');
        $aaa = new arraytojson();
        $json = $aaa->JSON($userinfo);
        print_r($json);
	    }else{
	    $userinfo=array("msg"=>"可使用","success"=>true,"check"=>'0');
        $aaa = new arraytojson();
        $json = $aaa->JSON($userinfo);
        print_r($json);
	}
}


if ($_REQUEST['act'] == 'e_cj_qrcode') {


    if(isset($_REQUEST['edit']))
    {
        $code = urldecode(trim($_REQUEST['edit']));
        $list=get_cj_qrcode_mx($code);
        $smarty->assign('cj_qrcode', $list['items'][0]);
        $smarty->assign('fall', 'e_cj_qrcode');
        $smarty->display('cj_qrcode.tpl');
    }
   
   
  
    
}

if ($_REQUEST['act'] == 'post') {


    //修改3，更新语句
    $time_field=array(
    //array("type"=>"2","field"=>"add_time","method"=>"1"),
    array("type"=>"1","field"=>"last_update_2","method"=>"2")
    );
    //print_r($time_field);exit;
    update_cj_qrcode_mx("cj_qrcode","cj_name,type,qrcid,tzsy,sort_no","cj_sn",$time_field);
    
    $smarty->assign('fall', 'i_staus');
    $smarty->assign('val', '修改成功');
    $smarty->display('cj_qrcode.tpl');
}


if ($_REQUEST['act'] == 'i_cj_qrcode') {

    if (isset($_REQUEST['cj_sn'])) {
        $cj_sn = trim($_REQUEST['cj_sn']);
    }
    if (isset($_REQUEST['cj_name'])) {
        $cj_name = trim($_REQUEST['cj_name']);
    }
    if (isset($_REQUEST['type'])) {
        $type = trim($_REQUEST['type']);
    }
    if (isset($_REQUEST['qrcid'])) {
        $qrcid = trim($_REQUEST['qrcid']);
    }
    if (isset($_REQUEST['sort_no'])) {
        $sort_no = trim($_REQUEST['sort_no']);
    }
    
    $time = date('Y-m-d H:i:s', time());
    $last_update_2 = date('Y-m-d', time());
    $get_one = " select cj_sn from cj_qrcode where cj_sn='" . $cj_sn . "'";
    $res = $GLOBALS['db']->getRow($get_one);
    if (empty($res)) {       
      //  $time_field = array(array(
//                "type" => "2",
//                "field" => "add_time",
//                "method" => "1"), // array("type"=>"2","field"=>"last_update","method"=>"2"),
//                //array("type"=>"1","field"=>"last_update_2","method"=>"2")
//            );
//        i_cj_qrcode("cj_qrcode", "cj_sn,cj_name,type,qrcid,tzsy,sort_no", $time_field);
        $tk = new getArr();
        $access_token = $tk->getToken();
        
        if($type==0){
        $qrcode = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id":'.$qrcid.'}}}';
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
        $result = https_post($url,$qrcode);
        $jsoninfo = json_decode($result, true);
        $ticket = $jsoninfo["ticket"];
        
       // print_r($url);
        }
        
        if($type==1){
        $qrcode = '{"expire_seconds": 1800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id":'.$qrcid.'}}}';
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
        $result = https_post($url,$qrcode);
        $jsoninfo = json_decode($result, true);
        $ticket = $jsoninfo["ticket"];
        $expire = $jsoninfo["expire_seconds"];
        }
        if(empty($expire)){
        $sql = "insert into cj_qrcode(cj_sn,cj_name,type,ticket,qrcid,sort_no,add_time,last_update_2) values('" . $cj_sn . "','" . $cj_name . "','" . $type . "','" . $ticket . "','" . $qrcid . "','" . $sort_no . "','" . $time . "','" . $last_update_2 . "')";
        $res = $GLOBALS['db']->query($sql);
        }
        else{
        $sql = "insert into cj_qrcode(cj_sn,cj_name,type,ticket,expire,qrcid,sort_no,add_time,last_update_2) values('" . $cj_sn . "','" . $cj_name . "','" . $type . "','" . $ticket . "','" . $expire . "','" . $qrcid . "','" . $sort_no . "','" . $time . "','" . $last_update_2 . "')";
        $res = $GLOBALS['db']->query($sql); 
        }
        update_api_bhwh();
        $smarty->assign('fall', 'i_staus');
        $smarty->assign('val', '添加成功');
        $smarty->display('cj_qrcode.tpl');
    } else {
        $smarty->assign('fall', 'i_staus');
        $smarty->assign('val', '代码已经存在,请重新输入');
        $smarty->display('cj_qrcode.tpl');
    }


}

//查看二维码

if ($_REQUEST['act'] == 'view_qrcode') {
  
    if (isset($_REQUEST['ticket'])) {
        $ticket=trim($_REQUEST['ticket']);
    } 
    
    if(!empty($ticket)){
        
     $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($ticket);
     $imageInfo = downloadImageFromWeiXin($url);
     $qrcodename=md5($ticket);
     $filename = $qrcodename.".jpg";
     $local_file = fopen('upload/cj_qrcode/agent/'.$filename, 'w');
     if (false !== $local_file){
     if (false !== fwrite($local_file, $imageInfo["body"])) {
        fclose($local_file);
        }
     }
    }
//print_r($filename);
        $smarty->assign('fall', 'view');
        $smarty->assign('val', $filename);
        $smarty->display('cj_qrcode.tpl');

    
}
//禁用启用删除等操作

if ($_REQUEST['act'] == 'ed_status') {
  
    if (isset($_REQUEST['qiyong'])) {
        $code = urldecode(trim($_REQUEST['qiyong']));

        $sql = "update cj_qrcode set tzsy=0 where  cj_sn= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "启用成功";
    } else {
       
    }
    
    
    
    
     if (isset($_REQUEST['jinyong'])) {
        $code = urldecode(trim($_REQUEST['jinyong'])) ;
        $sql = "update cj_qrcode set tzsy=1 where  cj_sn= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "禁用成功";
    } else {
        
    }
    
    
    
    
    
     if (isset($_REQUEST['delete'])) {
        $code = urldecode(trim($_REQUEST['delete'])) ;
        $sql = "delete from  cj_qrcode where  cj_sn= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";
    } else {
        
    }
}
?>
