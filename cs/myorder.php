<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init2.php');

require (dirname(__file__) . '/sub/sub_openid.php');


if (empty($_REQUEST['g'])) {
    $_REQUEST['g'] = 'default';
} else {
    $_REQUEST['g'] = trim($_REQUEST['g']);
}

    ini_set('date.timezone','Asia/Shanghai');
    //error_reporting(E_ERROR);
    require_once "wxpay/lib/WxPay.Api.php";
    
    require_once "wxpay/WxPay.JsApiPay.php";
  
    
    $tools = new JsApiPay();



if ($_REQUEST['g'] == 'default') {
    
    
    $access_token = $tools->GetToken();
    
    
    
    $baseUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
           
      
    $smarty->assign('access_token', $access_token['access_token']);
    $smarty->assign('baseUrl', $baseUrl);
    
    
    
    //获取地址数据
    if(!empty($openId))
    {
        $wxaddress="select id, name as userName,phone as telNumber,province as proviceFirstStageName,city as addressCitySecondStageName,country as addressCountiesThirdStageName,detail_address as addressDetailInfo from wxaddress where openid ='".$openId."' order by id desc";
        //*,
        $wxaddress = $GLOBALS['db']->getRow($wxaddress);  
    }
    $smarty->assign('wxaddress', $wxaddress);
    
    if(!empty($wxaddress))
    {
        $smarty->assign('is_address', 1);
    }
    
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $goods_list['page']);
    $smarty->display('cs/myorder.html');


}

if ($_REQUEST['g'] == 'getpackageinfoeditaddress') {
    
    //'url':url,'accesstoken':accesstoken,
    $tools->url=$_REQUEST['url'];
    $tools->token=$_REQUEST['accesstoken'];
    
    
    $editaddressparameters = $tools->GetEditAddressParameters2();
    
    print_r($editaddressparameters);exit;
    
}
  
if ($_REQUEST['g'] == 'addresssave') {
    
    
    
    //'name':res.userName,'phone':res.telNumber,'zip_code':res.addressPostalCode,'province':res.proviceFirstStageName,'city':res.addressCitySecondStageName,'country':res.addressCountiesThirdStageName,'detail_address':res.addressDetailInfo
    if(!empty($openId))
    {
        $REarr=array("openid"=>$openId,'name'=>trim($_REQUEST['name']),'phone'=>trim($_REQUEST['phone']),'zip_code'=>trim($_REQUEST['zip_code']),'province'=>$_REQUEST['province'],'city'=>$_REQUEST['city'],'country'=>$_REQUEST['country'],'detail_address'=>$_REQUEST['detail_address']);
                
        $arr2 = $GLOBALS['db']->autoExecute("wxaddress", $REarr, 'INSERT');
        
        
        $rarr=array();
        $rarr['status']="success";
        $rarr["msg"]="添加成功";
        
        //msg
        print_r(json_encode($rarr));
        //result.status
        exit;
    }
    else
    {
        
        $rarr["msg"]="数据异常";
        
        //msg
        print_r(json_encode($rarr));
    }

    
    
    
    
    
}




?>