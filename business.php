<?php

define('IN_ECS', true);
require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/sub_business.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_get_region.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'default') {
    $list = business($Num, "business");
    //print_r($list['item']);
    $smarty->assign('business_list', $list['item']);
    $smarty->assign('p_Array', $list['page']);
    $smarty->assign('fall', 'business');
    $smarty->display('business.tpl');
}


if ($_REQUEST['act'] == 'a_business') {

   
    $region = get_region2($list['items'][0]['province'], $list['items'][0]['city'], $list['items'][0]['district']);
        //print_r($region);
    $smarty->assign('region', $region);
    
  
   
    $smarty->assign('fall', 'a_business');
    $smarty->display('business.tpl');
}





if ($_REQUEST['act'] == 'e_business') {

    
    if(isset($_REQUEST['edit']))
    {
        
        
        $code = urldecode(trim($_REQUEST['edit']));
        $list=get_business_mx($code);
              
        $region = get_region2($list['items'][0]['province'], $list['items'][0]['city'], $list['items'][0]['district']);
        
        
        
        
        $list['items'][0]['region']=$region;
                // print_r($list);
       // print_r($q_list['items'][0]);
      
        $smarty->assign('business', $list['items'][0]);
        $smarty->assign('fall', 'e_business');
        $smarty->display('business.tpl');
    }
   
}

if ($_REQUEST['act'] == 'post') {


    //修改3，更新语句
    $time_field=array(
    //array("type"=>"2","field"=>"add_time","method"=>"1"),
    array("type"=>"1","field"=>"last_update_2","method"=>"2")
    );
    //print_r($time_field);exit;
    update_business_mx("business","business_name,business_type,qrcid,province,city,district,business_address,business_lxr,business_tel,lbsaddress,lbsjd,lbswd,tzsy,bz1,bz2,bz3,bz4,bz5","business_sn",$time_field);
    
    $smarty->assign('fall', 'i_staus');
    $smarty->assign('val', '修改成功');
    $smarty->display('business.tpl');
}


if ($_REQUEST['act'] == 'i_business') {

    if (isset($_REQUEST['business_sn'])) {
        $business_sn = trim($_REQUEST['business_sn']);
    }
    if (isset($_REQUEST['business_name'])) {
        $business_name = trim($_REQUEST['business_name']);
    }
    if (isset($_REQUEST['business_type'])) {
        $business_type = trim($_REQUEST['business_type']);
    }
    

    
    
    if (isset($_REQUEST['province'])) {
        $province = trim($_REQUEST['province']);
    }
    if (isset($_REQUEST['city'])) {
        $city = trim($_REQUEST['city']);
    }
    if (isset($_REQUEST['district'])) {
        $district = trim($_REQUEST['district']);
    }
    if (isset($_REQUEST['business_address'])) {
        $business_address = trim($_REQUEST['business_address']);
    }
    
     if (isset($_REQUEST['business_lxr'])) {
        $business_lxr = trim($_REQUEST['business_lxr']);
    }
    
     if (isset($_REQUEST['business_tel'])) {
        $business_tel = trim($_REQUEST['business_tel']);
    }
    
    
    if (isset($_REQUEST['lbsaddress'])) {
        $lbsaddress = trim($_REQUEST['lbsaddress']);
    }
    if (isset($_REQUEST['lbsjd'])) {
        $lbsjd = trim($_REQUEST['lbsjd']);
    }
    if (isset($_REQUEST['lbswd'])) {
        $lbswd = trim($_REQUEST['lbswd']);
    }
    
    
    $time = date('Y-m-d H:i:s', time());
    $last_update_2 = date('Y-m-d', time());
    $get_one = " select business_sn from business where business_sn='" . $business_sn . "'";
    $res = $GLOBALS['db']->getRow($get_one);
    if (empty($res)) {       
       $time_field = array(array(
                "type" => "2",
               "field" => "add_time",
                "method" => "1"), // array("type"=>"2","field"=>"last_update","method"=>"2"),
               //array("type"=>"1","field"=>"last_update_2","method"=>"2")
          );
        i_business("business", "business_sn,business_name,business_type,province,city,district,business_address,business_lxr,business_tel,lbsaddress,lbsjd,lbswd,tzsy,bz1,bz2,bz3,bz4,bz5", $time_field);

       
        $smarty->assign('fall', 'i_staus');
        $smarty->assign('val', '添加成功');
        $smarty->display('business.tpl');
    } else {
        $smarty->assign('fall', 'i_staus');
        $smarty->assign('val', '代码已经存在,请重新输入');
        $smarty->display('business.tpl');
    }


}







//禁用启用删除等操作

if ($_REQUEST['act'] == 'ed_status') {
  
    if (isset($_REQUEST['qiyong'])) {
        $code = urldecode(trim($_REQUEST['qiyong']));

        $sql = "update business set tzsy=0 where  business_sn= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "启用成功";
    } else {
       
    }
    
    
    
    
     if (isset($_REQUEST['jinyong'])) {
        $code = urldecode(trim($_REQUEST['jinyong'])) ;
        $sql = "update business set tzsy=1 where  business_sn= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "禁用成功";
    } else {
        
    }
    
    
    
    
    
     if (isset($_REQUEST['delete'])) {
        $code = urldecode(trim($_REQUEST['delete'])) ;
        
           
       $sql = "delete from  business  where  business_sn= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";
     
      
      
}

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

?>
