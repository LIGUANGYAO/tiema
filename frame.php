<?php

define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'default') {


    class Statistics
    {
        function  menu_list()
        {
            $sql="SELECT count(*) as sl FROM `menu_list` where menu_type=1";
            $res=$GLOBALS['db']->getRow($sql);
            
            $sql2="SELECT count(*) as sl FROM `menu_list` where menu_type=2";
            $res2=$GLOBALS['db']->getRow($sql2);
            
            return array("menu_sl1"=>$res['sl'],"menu_sl2"=>$res2['sl']);
        }
        function users_infolist()
        {
            
            $timetoday = date("Y-m-d 00:00:00",time());//今天0点的时间点
            $time2 = date("Y-m-d 23:59:59",time());//今天24点的时间点，两个值之间即为今天一天内的数据

            $sql="SELECT count(id) as sl FROM users_infolist where type='text'  and  add_time between '".$timetoday."' and '".$time2."'";
            $res=$GLOBALS['db']->getRow($sql);
            
            
            $sql2="SELECT count(id) as sl  FROM users_infolist where type='event' and event_type='click'  and  add_time between '".$timetoday."' and '".$time2."'";
            $res2=$GLOBALS['db']->getRow($sql2);
            
             $sql3="SELECT count(id) as sl  FROM users_infolist where type='event' and event_type='view'  and  add_time between '".$timetoday."' and '".$time2."'";
            $res3=$GLOBALS['db']->getRow($sql3);
            
            
             $sql3="SELECT count(id) as sl  FROM users_infolist where type='event' and event_type='view'  and  add_time between '".$timetoday."' and '".$time2."'";
            $res3=$GLOBALS['db']->getRow($sql3);
            
            
            $sql4="SELECT count(id) as sl  FROM users_infolist where type='event' and event_key='CHECK_IN'  and  add_time between '".$timetoday."' and '".$time2."'";
            $res4=$GLOBALS['db']->getRow($sql4);
            
            //SELECT count(id)  FROM `users_infolist` where type='text' ;

//SELECT count(id)  FROM `users_infolist` where type='event' and event_type='click' ;

            return array("list_sl"=>$res['sl'],"list_sl2"=>$res2['sl'],"list_sl3"=>$res3['sl'],"list_sl4"=>$res4['sl']);
        }
        
        
        function  users()
        {
            $timetoday = date("Y-m-d 00:00:00",time());//今天0点的时间点
            $time2 = date("Y-m-d 23:59:59",time());//今天24点的时间点，两个值之间即为今天一天内的数据
            $sql="SELECT count(*) as sl FROM users where lylx=1";
            $res=$GLOBALS['db']->getRow($sql);
            
            $sql2="SELECT count(*) as sl FROM  users where  lylx=1 and  add_time between '".$timetoday."' and '".$time2."'";
            $res2=$GLOBALS['db']->getRow($sql2);
            
            return array("user_sl"=>$res['sl'],"user_sl2"=>$res2['sl']);
        }
    }
    
    
     $ext=new Statistics();
     
     $menu=$ext->menu_list();
     
     $info=$ext->users_infolist();
     $users=$ext->users();
     
     
      $smarty->assign('info', $info);
      $smarty->assign('user', $users);
     //print_r($users);exit;
 //    $password=md5(md5("1tiema.com"));
//     echo $password;
  $smarty->display('frame.tpl');
}

?>
