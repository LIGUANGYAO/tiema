<?php
define('IN_ECS', true);
require (dirname(__file__) . '/sub/is_weixin.php');
require (dirname(__file__) . '/includes/init2.php');

if (empty($_REQUEST['m'])) {
    $_REQUEST['m'] = 'default';
} else {
    $_REQUEST['m'] = trim($_REQUEST['m']);
}

//可赞数量
//$hd_sn='888';
if (isset($_REQUEST['hd_sn'])) {
    $hd_sn=$_REQUEST['hd_sn'];
    $sql = " select activity_sn,hd_number,tzsy,start_time,end_time from activity where activity_sn='".$hd_sn."' ";
    $res = $GLOBALS['db']->getRow($sql);
    $zan_sl = $res['hd_number'];
    $tzsy = $res['tzsy'];
    $start_time = $res['start_time'];
    $end_time = $res['end_time'];
    $smarty->assign('zan', $zan_sl);
} 

if ($_REQUEST['m'] == 'default') {
    
  
    ///修改1,查询语句
    //sort_no,tzsy 要记得添加
    $zan = date('Y-m-d', time());
    if($start_time<=$zan && $end_time>=$zan && $tzsy==0 ){
    $sql = " select app_id,app_secret from app_id where weixin_id=1 ";
    $res = $GLOBALS['db']->getRow($sql);
    //print_r($_GET['code']);

    if (isset($_GET['code'])) {
        $code = $_GET['code'];

        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $res['app_id'] .
            '&secret=' . $res['app_secret'] . '&code=' . $code .
            '&grant_type=authorization_code';

        $headers = array("Content-Type: text/xml; charset=utf-8");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $output = curl_exec($ch);
        curl_close($ch);
        //echo $output;

        $jsonstr = json_decode($output);
        //print_r($jsonstr);
        //print_r($jsonstr->access_token . "</br>");
        //print_r($jsonstr->refresh_token . "</br>");
        //print_r($jsonstr->openid . "</br>");
        $access_token = $jsonstr->access_token;
        $refresh_token = $jsonstr->refresh_token;
        $openid = $jsonstr->openid;


        $url1 = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token .
            '&openid=' . $openid . '';
        $headers = array("Content-Type: text/xml; charset=utf-8");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $output = curl_exec($ch);
        curl_close($ch);
        $jsonstr2 = json_decode($output);
        //echo $jsonstr2->nickname;

        $nickname = $jsonstr2->nickname;


    }
    //$openid="oGehCt7YZrpXFzxwZs-z-AADN_Ak";
    if (empty($openid)) {
        $smarty->display('error.tpl');
     }else{
         header("location:wx_praise.php?m=dea2&openid=".$openid."&hd_sn=".$hd_sn);
     }


}else
{
    $smarty->display('error.tpl');
}




}
if ($_REQUEST['m'] == 'dea2') {
    
    	if (isset($_REQUEST['openid'])) {
 	    $openid = $_REQUEST['openid'];
        $sql = "select id,goods_sn,goods_name from wx_zan_goods";
        $goods_list = $GLOBALS['db']->getAll($sql);


        $arr = array();
        $arr2 = array();
        $max_sl=count($goods_list);

        $url_this = "http://" . $_SERVER['HTTP_HOST'] . "/weixin";
//print_r($url_this);exit;
        for ($i = 0; $i < count($goods_list); $i++) {

            $praize = "select case when goods_sn='' then 0 when goods_sn !='' then 1 end as praise from wx_praise where openid='" .
                $openid . "' and goods_sn='" . $goods_list[$i]['goods_sn'] . "'";
            $goods_list[$i]['praise'] = $GLOBALS['db']->getRow($praize);
            //获取图片
            $goods_img_list = "select p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,ss,title,img_action_url,add_time,last_update,img_sum,img_outer_id,width,height,resize_width,resize_height from goods_imgs where ss=1 and  p_id='" .
                $goods_list[$i]['goods_sn'] . "' order by -img_sum  desc;";

            $img_list = $GLOBALS['db']->getAll($goods_img_list);
            //print_r($img_list);exit;
            //返回图片完整路径
            for ($j = 0; $j < count($img_list); $j++) {
                $img_list[$j]['b_img_url'] = $url_this . "/" . $img_list[$j]['b_img_url'];
                $img_list[$j]['s_img_url'] = $url_this . "/" . $img_list[$j]['s_img_url'];

            }
            //$img_list[$i]['b_img_url']=$url_this."/".$img_list[$i]['b_img_url'];
            // $img_list[$i]['s_img_url']=$url_this."/".$img_list[$i]['s_img_url'];

            //$goods_list[$i]['img_count'] = count($img_list);
            $goods_list[$i]['img_list'] = $img_list;
        }

        /*
        for($i=0;$i<count($goods_list);$i++)
        {
        
        if($i%2==1)
        {
        array_push($arr,$goods_list[$i]); 
        
        
        }
        else
        {
        
        array_push($arr2,$goods_list[$i]);
        }       
        
        }
        
        
        */


        //打乱数组数据

        shuffle($goods_list);


        for ($i = 0; $i < count($goods_list); $i++) {

            if ($i < 10) {
                array_push($arr, $goods_list[$i]);

            }

        }


        //获取随机数组2个方式，打乱放在cookie,/判断，数组,现在先用cookie的方式
        //$tmpSerialize = serialize($arr);
        //    setcookie("goods_list", $tmpSerialize, time() + 3600);


        $sql2 = "select count(goods_sn) as sl from wx_praise where openid='" . $openid .
            "'";
        $res2 = $GLOBALS['db']->getRow($sql2);

        $smarty->assign('z_sl', $res2['sl']);

        //print_r($arr);
        //print_r($arr2);
        $get_one = " select openid,mu_name,mu_tel from joinin where openid='" . $openid . "'";
        $res = $GLOBALS['db']->getRow($get_one);
       // print_r($res);
        if (empty($res)){
         $smarty->assign('tj',0);   
        }else{
         $smarty->assign('tj',1);
         $smarty->assign('mu_name',$res['mu_name']);
         $smarty->assign('mu_tel',$res['mu_tel']);
        
        }  

        //print_r($_COOKIE['goods_list']);

        $smarty->assign('goods_list', $arr);
        $smarty->assign('openid', $openid);
        $smarty->assign('nickname', $nickname);
        $smarty->assign('zan_sl', $zan_sl);
        $smarty->assign('max_sl', $max_sl);
        $smarty->display('wxzan2/index.html');
    
}
else
{    
 $smarty->display('error.tpl');   
}

}

if ($_REQUEST['m'] == 'other_sn') {
    $g_sn = trim($_REQUEST['g_sn']);
    $openid=trim($_REQUEST['openid']);
    //$arr1 = array("g_sn" => $g_sn);
    //print_r(json_encode($arr));
    function get_more($obj)
    {

        //$string = "1,2,3,4,5";
        // echo 1;
        $array = explode(",", $obj);
        for ($i = 0; $i < count($array) - 1; $i++) {


            $fh1 = "'";
            $fh2 = "',";

            if ($i == count($array) - 2) {
                $fh2 = "'";
            }
            $f2 .= $fh1 . $array[$i] . $fh2;

        }
        return $f2;

    }

    $f2 = get_more($g_sn);


    //判断传输的数组是否已经显示在列表中
    $sql = "select id,goods_sn,goods_name from wx_zan_goods where id not in (" . $f2 .
        ")";
    $goods_list = $GLOBALS['db']->getAll($sql);

    if (empty($goods_list)) {

        $arr = array("error" => "0");
        print_r(json_encode($arr));

    } else {
        $arr = array();
        $arr2 = array();


        $url_this = "http://" . $_SERVER['HTTP_HOST'] . "/weixin";

        for ($i = 0; $i < count($goods_list); $i++) {

            $praize = "select case when goods_sn='' then 0 when goods_sn !='' then 1 end as praise from wx_praise where openid='" .
                $openid . "' and goods_sn='" . $goods_list[$i]['goods_sn'] . "'";
            $goods_list[$i]['praise'] = $GLOBALS['db']->getRow($praize);
            //获取图片
            $goods_img_list = "select p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,ss,title,img_action_url,add_time,last_update,img_sum,img_outer_id,width,height,resize_width,resize_height from goods_imgs where ss=1 and  p_id='" .
                $goods_list[$i]['goods_sn'] . "' order by -img_sum  desc;";

            $img_list = $GLOBALS['db']->getAll($goods_img_list);
            //print_r($img_list);exit;
            //返回图片完整路径
            for ($j = 0; $j < count($img_list); $j++) {
                $img_list[$j]['b_img_url'] = $url_this . "/" . $img_list[$j]['b_img_url'];
                $img_list[$j]['s_img_url'] = $url_this . "/" . $img_list[$j]['s_img_url'];

            }
            //$img_list[$i]['b_img_url']=$url_this."/".$img_list[$i]['b_img_url'];
            // $img_list[$i]['s_img_url']=$url_this."/".$img_list[$i]['s_img_url'];

            //$goods_list[$i]['img_count'] = count($img_list);
            $goods_list[$i]['img_list'] = $img_list;
        }
        //打乱数组数据

        shuffle($goods_list);

        for ($i = 0; $i < count($goods_list); $i++) {

            if ($i < 20) {
                array_push($arr, $goods_list[$i]);

            }

        }

        // $arr=array("g_sn"=>$f2);
        print_r(json_encode($arr));
    }


}


if ($_REQUEST['m'] == 'click') {
    
    if (isset($_REQUEST['goods_sn']) && isset($_REQUEST['openid'])) {
        $goods_sn = $_REQUEST['goods_sn'];
        $openid = $_REQUEST['openid'];
        $zan_sl = $_REQUEST['zan'];
        $n_time = date('Y-m-d H:i:s', time());

        $sql2 = "select count(goods_sn) as sl from wx_praise where openid='" . $openid .
            "'";
        $res2 = $GLOBALS['db']->getRow($sql2);
        //数量


        if ($res2['sl'] > $zan_sl - 1) {
            $err = array(
                "errcode" => "5",
                "errmsg" => "max sl",
                "z_sl" => $res2['sl'] + 1);
            $err = json_encode($err);
            print_r($err);
            exit;
        }
        $sql1 = "select goods_sn from wx_praise where openid='" . $openid .
            "' and goods_sn='" . $goods_sn . "'";
        $res1 = $GLOBALS['db']->getRow($sql1);
        if (empty($res1)) {
            $sql = "insert into wx_praise(goods_sn,goods_id,praise_sl,openid,user_id,add_time,last_update,last_update_2) values ('" .
                $goods_sn . "','','1','" . $openid . "','','" . $n_time . "','','')";
            $res = $GLOBALS['db']->query($sql);

            $err = array(
                "errcode" => "0",
                "errmsg" => "insert OK",
                "z_sl" => $res2['sl'] + 1);
            $err = json_encode($err);
            print_r($err);
        } else {
            $err = array("errcode" => "2", "errmsg" => "goods_sn is find");
            $err = json_encode($err);
            print_r($err);
        }


    } else {
        $err = array("errcode" => "1", "errmsg" => "goods_sn or openid is null");
        $err = json_encode($err);
        print_r($err);
    }


    //$smarty->display('appid.tpl');


}




?>