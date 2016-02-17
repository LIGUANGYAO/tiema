<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');


require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['g'])) {
    $_REQUEST['g'] = 'default';
} else {
    $_REQUEST['g'] = trim($_REQUEST['g']);
}


//设定传入主参数
$g_add=substr(md5("a_kehu"),0,17); //添加参数
$g_e=substr(md5("e_kehu"),0,17); //编辑
$g_post=substr(md5("post_kehu"),0,17); //修改保存
$g_d=substr(md5("d_kehu"),0,17); //删除
$g_in=substr(md5("in_kehu"),0,17); //插入
$g_xs=substr(md5("xs_kehu"),0,17); //显示

//g= default默认 e编辑d删除 p接收修改 i接收添加
if ($_REQUEST['g'] == 'default') {

    
    

    $smarty->assign('fall', 'zichanpinggu');
//    //$smarty->assign('title', $aaa);
//    $smarty->assign('p_Array', $list['page']);
    $smarty->display('w/feiyong.html');


}


if ($_REQUEST['g'] == 'hejiashoufei') {

    

    $smarty->assign('fall', 'hejiashoufei');
    $smarty->display('w/feiyong.html');


}

if ($_REQUEST['g'] == 'yanzishoufei') {

    

    $smarty->assign('fall', 'yanzishoufei');
    $smarty->display('w/feiyong.html');


}
if ($_REQUEST['g'] == 'nianzhongjiesuanshencha') {

    

    $smarty->assign('fall', 'nianzhongjiesuanshencha');
    $smarty->display('w/feiyong.html');


}

/*
    if(isset($_REQUEST['m_key']))
    {
           //资产评估计算率   资产评估总值
        $zcpg_val=(int)$_REQUEST['m_key'];
        
        $zcpg_val=$zcpg_val*10000;
    }
    else
    {
       
        $zcpg_val= 0;//以万为单位 
    }
    
    //echo $zcpg_val;exit;
    
    $zcpgjsl='0.8'/100;   //默认值
    
    //都加入计算组
    $zc_arr=array();
    $zc_arr_real=array();
    
    if($zcpg_val>=0 and $zcpg_val<=100*10000)  //100以下（含100）
    {
        //100w以下
        $val=$zcpg_val;$jsl='0.8'/100;
        $arr=array('val'=>$val,'jsl'=>$jsl,'sum'=>$val*$jsl);
        array_push($zc_arr_real,$arr);
        
        $zcpgjsl='0.8'/100;
    }
    elseif($zcpg_val>100*10000 and $zcpg_val<=1000*10000)  //101--1000（含1000）
    {
        
        //100w以下
        $val=100*10000;$jsl='0.8'/100;
        $arr=array('val'=>$val,'jsl'=>$jsl,'sum'=>$val*$jsl);
        array_push($zc_arr_real,$arr);
        
        //100w-1000w以下
        $zcpg_val_r=$zcpg_val-100*10000;
        $val2=$zcpg_val_r;$jsl2='0.35'/100;
        $arr2=array('val'=>$val2,'jsl'=>$jsl2,'sum'=>$val2*$jsl2);
        array_push($zc_arr_real,$arr2);
        $zcpgjsl='0.35'/100;
    }
    elseif($zcpg_val>100*100000 and $zcpg_val<=5000*10000) //1000-5000
    {
        //100w以下
        $val=100*10000;$jsl='0.8'/100;
        $arr=array('val'=>$val,'jsl'=>$jsl,'sum'=>$val*$jsl);
        array_push($zc_arr_real,$arr);
        
        //100w-1000w以下
        
        $val2=900*10000;$jsl2='0.35'/100;
        $arr2=array('val'=>$val2,'jsl'=>$jsl2,'sum'=>$val2*$jsl2);
        array_push($zc_arr_real,$arr2);
        
        //1000-5000
        $zcpg_val_r=$zcpg_val-1000*10000;
        $val3=$zcpg_val_r;$jsl3='0.12'/100;
        $arr3=array('val'=>$val3,'jsl'=>$jsl3,'sum'=>$val3*$jsl3);
        array_push($zc_arr_real,$arr3);
        $zcpgjsl='0.12'/100;
    }
    elseif($zcpg_val>5000*10000 and $zcpg_val<=10000*10000) //5000-10000
    {
         //100w以下
        $val=100*10000;$jsl='0.8'/100;
        $arr=array('val'=>$val,'jsl'=>$jsl,'sum'=>$val*$jsl);
        array_push($zc_arr_real,$arr);
        
        //100w-1000w以下
        
        $val2=900*10000;$jsl2='0.35'/100;
        $arr2=array('val'=>$val2,'jsl'=>$jsl2,'sum'=>$val2*$jsl2);
        array_push($zc_arr_real,$arr2);
        
        //1000-5000
        
        $val3=4000*10000;$jsl3='0.12'/100;
        $arr3=array('val'=>$val3,'jsl'=>$jsl3,'sum'=>$val3*$jsl3);
        array_push($zc_arr_real,$arr3);
        
        //5000-10000
        $zcpg_val_r=$zcpg_val-5000*10000;
        $val4=$zcpg_val_r;$jsl4='0.075'/100;
        $arr4=array('val'=>$val4,'jsl'=>$jsl4,'sum'=>$val4*$jsl4);
        array_push($zc_arr_real,$arr4);
        
        $zcpgjsl='0.075'/100;
    }
    elseif($zcpg_val>10000*10000 and $zcpg_val<=100000*10000)  //10000-100000
    {
        //100w以下
        $val=100*10000;$jsl='0.8'/100;
        $arr=array('val'=>$val,'jsl'=>$jsl,'sum'=>$val*$jsl);
        array_push($zc_arr_real,$arr);
        
        //100w-1000w以下
        
        $val2=900*10000;$jsl2='0.35'/100;
        $arr2=array('val'=>$val2,'jsl'=>$jsl2,'sum'=>$val2*$jsl2);
        array_push($zc_arr_real,$arr2);
        
        //1000-5000
        
        $val3=4000*10000;$jsl3='0.12'/100;
        $arr3=array('val'=>$val3,'jsl'=>$jsl3,'sum'=>$val3*$jsl3);
        array_push($zc_arr_real,$arr3);
        
        //5000-10000
        $val4=5000*10000;$jsl4='0.075'/100;
        $arr4=array('val'=>$val4,'jsl'=>$jsl4,'sum'=>$val4*$jsl4);
        array_push($zc_arr_real,$arr4);
        
        
         //10000-100000
         
        $zcpg_val_r=$zcpg_val-10000*10000;
        $val5=$zcpg_val_r;$jsl5='0.015'/100;
        $arr5=array('val'=>$val5,'jsl'=>$jsl5,'sum'=>$val5*$jsl5);
        array_push($zc_arr_real,$arr5);
        $zcpgjsl='0.015'/100;
    }
    elseif($zcpg_val>100000*10000)   //100000+
    {
        //100w以下
        $val=100*10000;$jsl='0.8'/100;
        $arr=array('val'=>$val,'jsl'=>$jsl,'sum'=>$val*$jsl);
        array_push($zc_arr_real,$arr);
        
        //100w-1000w以下
        
        $val2=900*10000;$jsl2='0.35'/100;
        $arr2=array('val'=>$val2,'jsl'=>$jsl2,'sum'=>$val2*$jsl2);
        array_push($zc_arr_real,$arr2);
        
        //1000-5000
        
        $val3=4000*10000;$jsl3='0.12'/100;
        $arr3=array('val'=>$val3,'jsl'=>$jsl3,'sum'=>$val3*$jsl3);
        array_push($zc_arr_real,$arr3);
        
        //5000-10000
        $val4=5000*10000;$jsl4='0.075'/100;
        $arr4=array('val'=>$val4,'jsl'=>$jsl4,'sum'=>$val4*$jsl4);
        array_push($zc_arr_real,$arr4);
        
        
         //10000-100000
        $val5=90000*10000;$jsl5='0.015'/100;
        $arr5=array('val'=>$val5,'jsl'=>$jsl5,'sum'=>$val5*$jsl5);
        array_push($zc_arr_real,$arr5);
         
        //100000+
        $zcpg_val_r=$zcpg_val-100000*10000;
        $val6=$zcpg_val_r;$jsl6='0.01'/100;
        $arr6=array('val'=>$val6,'jsl'=>$jsl6,'sum'=>$val6*$jsl6);
        array_push($zc_arr_real,$arr6);
        
        $zcpgjsl='0.01'/100;
    }
    
    $sum_conut=0;
    for($i=0;$i<count($zc_arr_real);$i++)
    {
        $sum+=$zc_arr_real[$i]['sum'];
        
    }
    */
?>