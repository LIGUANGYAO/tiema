<?php

define('IN_ECS', true);

require (dirname(__file__) . '/includes/init.php');
//require (dirname(__file__) . '/sub/sub_wx_fans.php');


if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'default') {
    
    $start_time=date("Y-m-d",mktime(0,0,0,date("m")-1,date("d"),date("Y")));
    $end_time=date('Y-m-d', time());
    
//    $start_time=date("Y-m-d H:i:s",mktime(0,0,0,date("m")-1,date("d"),date("Y")));
//    $end_time=date('Y-m-d H:i:s',time());
    
    $smarty->assign('start_time', $start_time);
    $smarty->assign('end_time', $end_time);
    $smarty->assign('fall', 'fans');
    $smarty->display('wx_fans.tpl');
}

if ($_REQUEST['act'] == 'cx') {
    
    if($_REQUEST['start_time']){
        $start_time=$_REQUEST['start_time'];        
    }
    if($_REQUEST['end_time']){
        $end_time=$_REQUEST['end_time'];
    }
    
    if($_REQUEST['qudao']){
        $qudao=$_REQUEST['qudao'];        
    }
    if($_REQUEST['kehu']){
        $kehu=$_REQUEST['kehu'];        
    }
    
    
    if (!empty($qudao)){
        $sqlwhere =" and cj_sn in(".$qudao.")";
    }
    
    if (!empty($kehu)){
        $sqlwhere = " and cj_sn in(".$kehu.")";
    }
    
//    if aaa!=k 
//    $sqlwhere =" and c.qudao-sn = $aaa"
//    if $sddm!=k 
//    $sqlwhere = $sqlwhere ." and shop-sn = $aaa"


//     b.add_time between '".$start_time.' 00:00:00'."' and '".$end_time.' 23:59:59'."'
    $sql="
          select (case  when qudao.qudao_sn  is null then qudao_a.qudao_sn else qudao.qudao_sn  end) qudao_sn,
          (case  when qudao.qudao_name  is null then qudao_a.qudao_name else qudao.qudao_name  end) qudao_name
          ,shop.shop_sn,shop.shop_name
          ,a.cj_sn,cj_type,b.sl1,b.sl2,b.sl from 
          (select cj_sn,cj_type  from cj_qrcode_stat
          where 1=1 ".$sqlwhere." group by cj_sn,cj_type )  a left join
          (select cj_sn,count(openid) sl ,
          sum(case when add_time<'".$start_time.' 00:00:00'."'  then 1 else 0 end) sl1  ,
          sum(case when add_time between '".$start_time.' 00:00:00'."' and '".$end_time.' 23:59:59'."'  then 1 else 0 end) sl2
          from cj_qrcode_stat
          where 1=1  group by cj_sn) b
          on a.cj_sn=b.cj_sn
          left join qudao on a.cj_sn=qudao.qudao_sn
          left join shop on a.cj_sn=shop.shop_sn
          left join qudao qudao_a on shop.p_id=qudao_a.qudao_sn
          "
          ;
    $res = $GLOBALS['db']->getAll($sql);
    
    //print_r($sql);
    
        $sql1="select sum(a.sl1) as sqzsl,sum(a.sl2) as bqzsl,sum(a.sl) as hjzsl from (
          select (case  when qudao.qudao_sn  is null then qudao_a.qudao_sn else qudao.qudao_sn  end) qudao_sn,
          (case  when qudao.qudao_name  is null then qudao_a.qudao_name else qudao.qudao_name  end) qudao_name
          ,shop.shop_sn,shop.shop_name
          ,a.cj_sn,cj_type,b.sl,b.sl1,b.sl2 from 
          (select cj_sn,cj_type  from cj_qrcode_stat
          where 1=1 ".$sqlwhere." group by cj_sn,cj_type )  a left join
          (select cj_sn,count(openid) sl ,
          sum(case when add_time<'".$start_time.' 00:00:00'."'  then 1 else 0 end) sl1  ,
          sum(case when add_time between '".$start_time.' 00:00:00'."' and '".$end_time.' 23:59:59'."'  then 1 else 0 end) sl2
          from cj_qrcode_stat
          where 1=1  group by cj_sn) b
          on a.cj_sn=b.cj_sn
          left join qudao on a.cj_sn=qudao.qudao_sn
          left join shop on a.cj_sn=shop.shop_sn
          left join qudao qudao_a on shop.p_id=qudao_a.qudao_sn
          ) a
          "
          ;
    $res1 = $GLOBALS['db']->getAll($sql1);
    
    
    
    
    
    
    $smarty->assign('start_time', $start_time);
    $smarty->assign('end_time', $end_time);
    
    $smarty->assign('qudao', $qudao);
    $smarty->assign('kehu', $kehu);
    
    $smarty->assign('list', $res);
    $smarty->assign('sqzsl', $res1[0]['sqzsl']);
    $smarty->assign('bqzsl', $res1[0]['bqzsl']);
    $smarty->assign('hjzsl', $res1[0]['hjzsl']);
    
    $smarty->assign('fall', 'fans');
    $smarty->display('wx_fans.tpl');
}

if ($_REQUEST['act'] == 'select_qudao')
{
     $smarty->assign('type', 1);
     $smarty->display('wx_select_2.tpl');
    }
    
if ($_REQUEST['act'] == 'select_kehu')
{
      $smarty->assign('type', 2);
      $smarty->display('wx_select_2.tpl');
    }
    
if ($_REQUEST['act'] == 'ysss') {

    require (dirname(__file__) . '/sub/rest.php');
    
    if (isset($_REQUEST['type']))
    {
        $type= $_REQUEST['type'];
    }
    
        if (!empty($_REQUEST['s']))
    {
        $aaa= $_REQUEST['s'];
        
    }
    
    
    
    if(isset($_REQUEST['keyword'])){
        $keyword= urldecode($_REQUEST['keyword']);
        
        
    if($type == "1"){
    $q1="select id,qudao_name as mc,qudao_sn as dm from qudao ";
    $q2="where qudao_sn like '%".$keyword."%' or qudao_name like '%".$keyword."%'"; 
    $q3="select id,qudao_name as mc,qudao_sn as dm from qudao".$q2;   
    }
    if($type == "2"){
     if(empty($aaa)){  
    $q1="select shop_sn as dm,shop_name as mc from shop";
    } 
    else
    {
      $q1="select shop_sn as dm,shop_name as mc from shop where p_id in (".$aaa.") ";  
    }
    $q2="where  shop_sn like '%".$keyword."%' or shop_name like '%".$keyword."%'  "; 
    $q3="select shop_sn as dm,shop_name as mc from shop".$q2;   
    }
        
        
        if($keyword=="all")
        {
         // $sql="select id,openid,users_sn,nick_name from users where lylx=1 and id not in (select users_id from wx_users_group where group_sn='".$group_sn."')";
         //$sql="select id,qudao_sn,qudao_name,qudao_type,p_id,qrcid,tzsy,add_time from qudao ";
         //$sql="select area_id,area_name,area_py from shop.system_area ";
         $sql=$q1;
         $res = $GLOBALS['db']->getAll($sql);
        }
        else
        {
         //$where="where area_py like '%".$keyword."%' or area_name like '%".$keyword."%'";
         //$sql="select area_id,area_name,area_py from shop.system_area ".$where;
         $where=$q2;
         $sql=$q3;
         $res = $GLOBALS['db']->getAll($sql);
        }
     }
     //$sql="select color_sn,color_name from color ";
     $res = $GLOBALS['db']->getAll($sql);
     $aaa=new arraytojson();
     $json=$aaa->JSON($res);
     print_r($json);
}    
    
    


?>
