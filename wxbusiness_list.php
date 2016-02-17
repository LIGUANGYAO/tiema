<?php
define('IN_ECS', true);

require (dirname(__file__) . '/sub/is_weixin.php');
require (dirname(__file__) . '/includes/init2.php');
require (dirname(__file__) . '/sub/sub_get_region.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
    
    
    
    
    $sql="select id,
            business_sn,
            business_name,
            business_type,
            p_id,
            qrcid,
            business_qy,
            ticket,
            province,
            city,
            district,
            business_address,
            business_lxr,
            business_tel,
            lbsaddress,
            lbsjd,
            lbswd,
            tzsy,
            img_url,
            bz1,
            bz2,
            bz3,
            bz4,
            bz5,
            add_time,
            last_update,
            last_update_2 
            from business where  tzsy=0 order by add_time desc";
    $res = $GLOBALS['db']->getAll($sql);
    
    $region = get_region2($list['items'][0]['province'], $list['items'][0]['city'], $list['items'][0]['district']);
        //print_r($region);
    $smarty->assign('region', $region);
    
   // $smarty->assign('pinpai_sn', $pinpai_sn);
    $smarty->assign('business_list', $res);
    $smarty->display('business/wxbusiness_list.html');
}

if ($_REQUEST['act'] == 'get_city') {

    //echo 1;exit;
    //if(isset($_REQUEST['province'])){
    require (dirname(__file__) . '/sub/rest.php');
    $province = urldecode($_REQUEST['province']);

    $sql2 = "select region_sn,region_name
     from region where region_type='2' and p_id='" . $province . "';";
    $city = $GLOBALS['db']->getAll($sql2);
    //$city=get_city($province);
    //echo $sql2;exit;

    //}
    // echo $sql2;exit;
    //$sql="select color_sn,color_name from color ";
    //$res = $GLOBALS['db']->getAll($sql);
    $aaa = new arraytojson();
    $json = $aaa->JSON($city);

    print_r($json);
}

if ($_REQUEST['act'] == 'get_district') {

    //echo 1;exit;
    //if(isset($_REQUEST['province'])){
    require (dirname(__file__) . '/sub/rest.php');
    $city = urldecode($_REQUEST['city']);

    $sql3 = "select region_sn,region_name
     from region where region_type='3' and p_id='" . $city . "';";
    $district = $GLOBALS['db']->getAll($sql3);

    $aaa = new arraytojson();
    $json = $aaa->JSON($district);

    print_r($json);
}

if ($_REQUEST['act'] == 'get_shop') {

    //echo 1;exit;
    //if(isset($_REQUEST['province'])){
    require (dirname(__file__) . '/sub/rest.php');
    
   
    $province = urldecode($_REQUEST['province']);
    $city = urldecode($_REQUEST['city']);
    $district =urldecode($_REQUEST['district']);
    

    if (!empty($province)){
    $sql2 = "select business_name,business_tel,business_address,lbswd,lbsjd from business where  province='" . $province . "'"; 
    $shop = $GLOBALS['db']->getAll($sql2);    
       } 
       else{
         $sql2 = "select business_name,business_tel,business_address,lbswd,lbsjd from business  "; 
    $shop = $GLOBALS['db']->getAll($sql2); 
        
       }
   
    if(!empty($city)){
    $sql2 = "select business_name,business_tel,business_address,lbswd,lbsjd from business where  province='" . $province . "' and city='".$city."'";
    $shop = $GLOBALS['db']->getAll($sql2);   
    }

    if(!empty($district)){
    $sql2 = "select business_name,business_tel,business_address,lbswd,lbsjd from business where  province='" . $province . "' and city='".$city."' and district='".$district."'";
    $shop = $GLOBALS['db']->getAll($sql2);   
    }
    
    
   
    $aaa = new arraytojson();
    $json = $aaa->JSON($shop);
    print_r($json);
}





?>