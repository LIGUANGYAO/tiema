<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init2.php');

require (dirname(__file__) . '/sub/sub_openid.php');


if (empty($_REQUEST['g'])) {
    $_REQUEST['g'] = 'default';
} else {
    $_REQUEST['g'] = trim($_REQUEST['g']);
}


if ($_REQUEST['g'] == 'default') {


    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $goods_list['page']);
    $smarty->display('cs/fungroup.html');


}


if ($_REQUEST['g'] == 'getlist') {


    function getidUserInfo($obj)
    {

        //SELECT * FROM user  WHERE userId >= ((SELECT MAX(userId) FROM user )-(SELECT MIN(userId) FROM user )) * RAND() + (SELECT MIN(userId) FROM user )  LIMIT 5
        $sql = "select id as user_id,wx_pay,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name as nickname,openid,headimgurl,tg_img,sex,province,city from users  WHERE  login_status=1 and wx_pay=1 and tg_erweimaup=1 ORDER BY RAND()   limit 10";
        
        
        //select id as user_id,wx_pay,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name as nickname,openid,headimgurl,tg_img,sex,province,city from users  WHERE  login_status=1 and wx_pay=1 and tg_erweimaup=1 ORDER BY RAND()   limit 10
        
        
        //select id as user_id,wx_pay,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name as nickname,openid,headimgurl,tg_img,sex,province,city from users  WHERE id >= ((SELECT MAX(id) FROM users )-(SELECT MIN(id) FROM users )) * RAND()  and   login_status=1 and wx_pay=1 and tg_erweimaup=1    limit 10
        $res = $GLOBALS['db']->getAll($sql);

        return $res;
    }
    //+ (SELECT MIN(id) FROM users )


    $userInfo = getidUserInfo($id);

    $rarr = array('results' => $userInfo);

    print_r(json_encode($rarr));


}


if ($_REQUEST['g'] == 'jsonewmshow') {

        
    if (isset($_REQUEST['user_id'])) {
        $id = trim($_REQUEST['user_id']);
        
        $rarr=array();
        function getidUserInfo($obj)
        {
            $sql = "select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,p_openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime from users  where  id='" .
                $obj . "' ";
            $res = $GLOBALS['db']->getRow($sql);


            return $res;
        }
        

        $userInfo = getidUserInfo($id);
        
        
        
            $rarr=array(0,'',0,0,'1',$userInfo['tg_userweima']);
        
        
        
    }

  //您还没有购书，您无权在"粉丝团"添加好友。
    //$rarr = array('results' => $userInfo);

    print_r(json_encode($rarr));


}


if ($_REQUEST['g'] == 'queryaddfriend') {

        
    if (isset($_REQUEST['user_id'])) {
        $id = trim($_REQUEST['user_id']);
        
        $rarr=array();
        function getidUserInfo($obj)
        {
            $sql = "select id,id as user_id,wx_pay,wx_pay as role_type,wx_paytime,wx_isfc,wx_fctime,tg_userweima,tg_erweimaup,nick_name,nick_name as nickname,openid,p_openid,headimgurl,tg_img,sex,province,city,login_status,add_time as stime from users  where  openid='" .
                $obj . "' ";
            $res = $GLOBALS['db']->getRow($sql);


            return $res;
        }
        

        $userInfo = getidUserInfo($openId);
        
        
        if($userInfo['wx_pay']=='1')
        {
            $rarr=1;
        }
        else
        {
            $rarr=0;
        }
        
        
    }

  //您还没有购书，您无权在"粉丝团"添加好友。
    //$rarr = array('results' => $userInfo);

    print_r(json_encode($rarr));


}




?>