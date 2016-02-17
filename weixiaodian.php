<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_weixiaodian.php');

require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
    ///修改1,查询语句
    //sort_no,tzsy 要记得添加
    $sql = "select *, from_unixtime( order_create_time) as ad_time from weixiaodian";

    $weixiaodian_list = get_weixiaodian_list($Num, "weixiaodian", $sql);
    //print_r($weixiaodian_list);


    $smarty->assign('weixiaodian_list', $weixiaodian_list['items']);
    $smarty->assign('fall', 1);
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $weixiaodian_list['page']);


    //添加时间间隔
    $time = date('Y-m-d', time());

    $data = strtotime($time);
    //减去三天的时间
    $data = $data - (60 * 60 * 24 * 30);
    //打印出三天的时间
    $th_time = date("Y-m-d", $data);
    if (isset($_REQUEST['time'])) {
        $th_time = $_REQUEST['time'];
    }
    if (isset($_REQUEST['time2'])) {
        $time = $_REQUEST['time2'];
    }

    if (isset($_REQUEST['order_status'])) {
        $status = $_REQUEST['order_status'];
    }

    $smarty->assign('status', $status);
    $smarty->assign('th_time', $th_time);
    $smarty->assign('now_time', $time);
    $smarty->display('weixiaodian.tpl');


}

if ($_REQUEST['act'] == 'add_weixiaodian_list') {

    //$sql="select xmlx_sn ,xmlx_name from xmlx";
    //   $res_xmlx = $GLOBALS['db']->getAll($sql);
    //    $smarty->assign('res_xmlx', $res_xmlx);
    $smarty->assign('fall', 'add_weixiaodian_list');
    $smarty->display('weixiaodian_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];

    ///修改2,查询语句
    $sql = "select id,weixiaodian_sn,weixiaodian_name,sort_no,tzsy,last_update,url,type
  from weixiaodian ";
    $weixiaodian_mx = get_weixiaodian_mx("weixiaodian", $sql);

    // print_r($weixiaodian_mx);exit;
    $img_cod = $_REQUEST['weixiaodian_sn'];


    //    //图片部分。没图片则删除
    //    $weixiaodian_imgs2 = get_weixiaodian_imgs_list("weixiaodian_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
    ////print_r($weixiaodian_imgs2);
    //    $weixiaodian_imgs = arr_push($weixiaodian_imgs2['items']);
    //    $smarty->assign('weixiaodian_imgs', $weixiaodian_imgs);


    $smarty->assign('weixiaodian_mx', $weixiaodian_mx['items'][0]);
    $smarty->assign('res_xmlx', $weixiaodian_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('weixiaodian_mx.tpl');
}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if (isset($_REQUEST['img_code'])) {
        $img_code = trim($_REQUEST['img_code']);

        $sql = "delete from weixiaodian_imgs where  img_outer_id= '" . $img_code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}

if ($_REQUEST['act'] == 'delete_weixiaodian') {

    //echo 1;
    if (isset($_REQUEST['weixiaodian_sn'])) {
        $weixiaodian_sn = trim($_REQUEST['weixiaodian_sn']);

        $sql = "delete from weixiaodian where  weixiaodian_sn= '" . $weixiaodian_sn .
            "'";
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}
if ($_REQUEST['act'] == 'img_xs') {

    //echo 1;
    if (isset($_REQUEST['img_code']) && isset($_REQUEST['alt'])) {
        $img_code = trim($_REQUEST['img_code']);
        $alt = trim($_REQUEST['alt']);

        $sql = "update  weixiaodian_imgs set ss=" . $alt . "  where  img_outer_id= '" .
            $img_code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}
if ($_REQUEST['act'] == 'weixiaodian_xs') {

    //echo 1;

    if (isset($_REQUEST['weixiaodian_code']) && isset($_REQUEST['alt'])) {
        $weixiaodian_code = urldecode(trim($_REQUEST['weixiaodian_code']));
        $alt = urldecode(trim($_REQUEST['alt']));

        $sql = "update  weixiaodian set tzsy=" . $alt . "  where  weixiaodian_sn= '" . $weixiaodian_code .
            "'";
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";
    } else {
        echo "失败";
    }

    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}


if ($_REQUEST['act'] == 'post') {


    //$p = new upload;
    //    $path=$p->upload_path='upload/weixiaodian';
    //    $p->uplood_img();
    //    $img_array = $p->upload_file;
    //
    //    for($i=0;$i<count($img_array['guige']);$i++)
    //    {
    //        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
    //    }
    //    $aaa = $_POST['weixiaodian_sn'];
    //    // print_r($aaa);exit;
    //    //图片部分。没图片则删除
    //    img_insert($aaa, $img_array,"weixiaodian_imgs");
    //修改3，更新语句
    $time_field = array( //array("type"=>"2","field"=>"add_time","method"=>"1"),
            array(
            "type" => "2",
            "field" => "last_update",
            "method" => "2"), array(
            "type" => "1",
            "field" => "last_update_2",
            "method" => "2"));
    //print_r($time_field);exit;
    update_weixiaodian_mx("weixiaodian", "weixiaodian_name,url,type,sort_no",
        "weixiaodian_sn", $time_field);

    $smarty->assign('fall', 'post');
    $smarty->display('weixiaodian_mx.tpl');
}


if ($_REQUEST['act'] == 'post_add') {
    if (isset($_REQUEST['weixiaodian_sn'])) {
        $weixiaodian_sn = trim($_REQUEST['weixiaodian_sn']);
    }
    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one = " select weixiaodian_sn from weixiaodian where weixiaodian_sn ='" . $weixiaodian_sn .
        "'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($get_one);exit;
    if (empty($res)) {
        //echo 1;
        // $p = new upload;
        //        $path=$p->upload_path='upload/weixiaodian';
        //        $p->uplood_img();
        //        $img_array = $p->upload_file;
        //        for($i=0;$i<count($img_array['guige']);$i++)
        //        {
        //        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
        //        }
        //        //print_r($img_array);exit;
        //        $aaa = $weixiaodian_sn;
        //
        //        //插入图片记录//图片部分。没图片则删除
        //         img_insert($aaa, $img_array,"weixiaodian_imgs");
        //修改4，增加语句
        //保存修改后商品明细
        $time_field = array(array(
                "type" => "2",
                "field" => "add_time",
                "method" => "1"), // array("type"=>"2","field"=>"last_update","method"=>"2"),
                //array("type"=>"1","field"=>"last_update_2","method"=>"2")
            );
        //修改4，增加语句
        //保存修改后商品明细
        insert_weixiaodian_mx("weixiaodian",
            "weixiaodian_sn,weixiaodian_name,url,type,sort_no", $time_field);

        $smarty->assign('fall', 'post');
        $smarty->display('weixiaodian_mx.tpl');
    } else {
        $smarty->assign('fall', 'fs');
        $smarty->display('weixiaodian_mx.tpl');
    }


}


if ($_REQUEST['act'] == 'down_dj') {


    $time = date('Y-m-d', time());

    $data = strtotime($time);
    //减去三天的时间
    $data = $data - (60 * 60 * 24 * 3);
    //打印出三天的时间
    $th_time = date("Y-m-d", $data);

    $smarty->assign('th_time', $th_time);
    $smarty->assign('now_time', $time);
    $smarty->display('weixiaodian_xz.html');
}


if ($_REQUEST['act'] == 'down_order') {

    class getArr
    {
        public $reqUrl = '';
        public $openid;
        public function get_time_diff($t)
        {
            $time = date('Y-m-d H:i:s', time());
            $time = strtotime($time);
            //echo $time;exit;
            $aaa = date("YmdHis", $time);
            // $time = date('Y-m-d H:i:s', time());
            $t = strtotime($t);
            //echo $time;exit;
            $t = date("YmdHis", $t);
            $a = $this->timeDiff($aaa, $t);
            return $a;
        }
        public function timeDiff($aTime, $bTime)
        {
            // 分割第一个时间
            $ayear = substr($aTime, 0, 4);
            $amonth = substr($aTime, 4, 2);
            $aday = substr($aTime, 6, 2);
            $ahour = substr($aTime, 8, 2);
            $aminute = substr($aTime, 10, 2);
            $asecond = substr($aTime, 12, 2);
            // 分割第二个时间
            $byear = substr($bTime, 0, 4);
            $bmonth = substr($bTime, 4, 2);
            $bday = substr($bTime, 6, 2);
            $bhour = substr($bTime, 8, 2);
            $bminute = substr($bTime, 10, 2);
            $bsecond = substr($bTime, 12, 2);
            // 生成时间戳
            $a = mktime($ahour, $aminute, $asecond, $amonth, $aday, $ayear);
            $b = mktime($bhour, $bminute, $bsecond, $bmonth, $bday, $byear);
            $timeDiff['second'] = $a - $b;
            // 采用了四舍五入,可以修改
            $timeDiff['mintue'] = round($timeDiff['second'] / 60);
            $timeDiff['hour'] = round($timeDiff['mintue'] / 60);
            $timeDiff['day'] = round($timeDiff['hour'] / 24);
            $timeDiff['week'] = round($timeDiff['day'] / 7);
            $timeDiff['month'] = round($timeDiff['day'] / 30); // 按30天来算
            $timeDiff['year'] = round($timeDiff['day'] / 365); // 按365天来算
            return $timeDiff;
        }
        public function getToken()
        {
            $get_app = "select app_id ,app_secret from app_id where weixin_id=1";
            $get_app = $GLOBALS['db']->getRow($get_app);
            //print_r($get_app);exit;

            $APPID = $get_app['app_id'];
            $APPSECRET = $get_app['app_secret'];
            if (empty($APPID)) {
                echo "appid missing";
                exit;
            } elseif (empty($APPSECRET)) {
                echo "appsecret missing";
                exit;
            } else {

            }
            //https://api.weixin.qq.com/cgi-bin/user/get?access_token=ACCESS_TOKEN&next_openid=NEXT_OPENID


            //                return $ACC_TOKEN;
            $a_token_time = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
            $a_token_time = $GLOBALS['db']->getRow($a_token_time);
            //print_r($a_token_time);exit;

            $time_diff = $this->get_time_diff($a_token_time['last_update']);
            //print_r($time_diff);
            //            exit;
            if ($time_diff['second'] >= 3600 or $time_diff['second'] <= -1) {

                $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                    $APPID . "&secret=" . $APPSECRET;

                $json = file_get_contents($TOKEN_URL);
                $result = json_decode($json);
                $ACC_TOKEN = $result->access_token;


                $i = 0;
                while ($result->access_token == '') {

                    $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                        $APPID . "&secret=" . $APPSECRET;

                    $json = file_get_contents($TOKEN_URL);
                    $result = json_decode($json);


                    $i++;

                    if ($result->access_token != '') {


                        $ACC_TOKEN = $result->access_token;


                        break;
                    } elseif ($i >= 5) {
                        break;
                    }

                }


                $time = date('Y-m-d H:i:s', time());
                $u_acc_token = "update temporary_tb set access_token='" . $ACC_TOKEN .
                    "',last_update='" . $time . "' where type=1 and app_id=1";
                $u_acc_token = $GLOBALS['db']->query($u_acc_token);


                //echo 1;
                $a_token_time2 = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
                $a_token_time2 = $GLOBALS['db']->getRow($a_token_time2);
                return $a_token_time2['access_token'];
                //echo $time_diff['second'] . "1";
                //exit;
            } else {
                //echo 2;
                $a_token_time2 = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
                $a_token_time2 = $GLOBALS['db']->getRow($a_token_time2);

                //print_r(empty($a_token_time2));exit;

                $i = 0;
                while ($a_token_time2['access_token'] == '') {

                    $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                        $APPID . "&secret=" . $APPSECRET;

                    $json = file_get_contents($TOKEN_URL);
                    $result = json_decode($json);

                    $i++;
                    //echo $i;
                    $a_token_time2['access_token'] = $result->access_token;
                    //print_r($a_token_time2['access_token']) ;
                    if ($a_token_time2['access_token'] != '') {


                        $ACC_TOKEN = $result->access_token;
                        $time = date('Y-m-d H:i:s', time());
                        $u_acc_token = "update temporary_tb set access_token='" . $ACC_TOKEN .
                            "',last_update='" . $time . "' where type=1 and app_id=1";
                        $u_acc_token = $GLOBALS['db']->query($u_acc_token);


                        break;
                    } elseif ($i >= 5) {
                        break;
                    }

                }


                $a_token_time3 = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
                $a_token_time3 = $GLOBALS['db']->getRow($a_token_time3);

                //exit;

                return $a_token_time3['access_token'];
            }
            //exit;

        }

        public function getOpenid()
        {
            $MENU_URL = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=" . $this->
                getToken();

            //print_r($MENU_URL);exit;
            $json = file_get_contents($MENU_URL);
            $result = json_decode($json);
            //print_r($json);exit;
            //递归stdClass Object 对象
            function objtoarr($obj)
            {
                $ret = array();
                foreach ($obj as $key => $value) {
                    if (gettype($value) == 'array' || gettype($value) == 'object') {
                        $ret[$key] = objtoarr($value);
                    } else {
                        $ret[$key] = $value;
                    }
                }
                return $ret;
            }

            $result2 = objtoarr($result);
            return $result2;


        }

        public function getopen()
        {
            //https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN
            $MENU_URL = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $this->
                getToken() . "&openid=" . $this->openid . "&lang=zh_CN";

            //print_r($MENU_URL);exit;
            $json = file_get_contents($MENU_URL);
            $result = json_decode($json);
            //print_r($json);exit;
            //递归stdClass Object 对象
            function objtoarr2($obj)
            {
                $ret = array();
                foreach ($obj as $key => $value) {
                    if (gettype($value) == 'array' || gettype($value) == 'object') {
                        $ret[$key] = objtoarr($value);
                    } else {
                        $ret[$key] = $value;
                    }
                }
                return $ret;
            }

            $result2 = objtoarr2($result);
            return $result2;

        }

    }

    $ex = new getArr();
    $ACC_TOKEN = $ex->getToken();


    //拼装post数据
    $start_time = strtotime($_REQUEST['start_time']);
    $end_time = strtotime($_REQUEST['end_time']);


    function objtoarr($obj)
    {
        $ret = array();
        foreach ($obj as $key => $value) {
            if (gettype($value) == 'array' || gettype($value) == 'object') {
                $ret[$key] = objtoarr($value);
            } else {
                $ret[$key] = $value;
            }
        }
        return $ret;
    }
    function download_list($token, $res)
    {
        $MENU_URL = "https://api.weixin.qq.com/merchant/order/getbyfilter?access_token=" .
            $token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $MENU_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT,
            'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $res);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo2 = curl_exec($ch);
        //print_r($tmpInfo2);
        $obj = objtoarr(json_decode($tmpInfo2));
        if ($obj['errcode'] == 0) {
            $sl = count($obj['order_list']);
        }
        return $obj;

    }

    $status = array(
        array("status" => 2, "msg" => "待发货"),
        array("status" => 3, "msg" => "已发货"),
        array("status" => 5, "msg" => "已完成"),
        array("status" => 8, "msg" => "维权中"));

    $ret = array();


    function weixiaodian_order($obj)
    {
        $txt = "";
        $time1 = date('Y-m-d H:i:s', time());
        $time2 = date('Y-m-d', time());
        $obj2 = $obj['order_list'];

        for ($i = 0; $i < count($obj2); $i++) {

            $sel = "select order_sn from weixiaodian where order_sn='" . $obj2[$i]['order_id'] .
                "'";
            // print_r($sel);
            $sel = $GLOBALS['db']->getRow($sel);

            if (empty($sel)) {


                $obj2[$i]['order_total_price'] = $obj2[$i]['order_total_price'] / 100;
                $obj2[$i]['product_price'] = $obj2[$i]['product_price'] / 100;
                $obj2[$i]['order_express_price'] = $obj2[$i]['order_express_price'] / 100;

                $obj2[$i]['buyer_nick'] = addslashes($obj2[$i]['buyer_nick']);
                $obj2[$i]['receiver_name'] = addslashes($obj2[$i]['receiver_name']);
                $sql = "insert into weixiaodian (
                                    order_sn	,
                                    order_status	,
                                    order_total_price	,
                                    order_create_time	,
                                    add_time	,
                                    order_express_price	,
                                    buyer_openid	,
                                    buyer_nick	,
                                    receiver_name	,
                                    receiver_province	,
                                    receiver_city	,
                                    receiver_address	,
                                    receiver_mobile	,
                                    receiver_phone	,
                                    product_id	,
                                    product_name	,
                                    product_price	,
                                    product_sku	,
                                    product_count	,
                                    product_img	,
                                    delivery_id	,
                                    delivery_company	,
                                    trans_id	,
                                    
                                    last_update_2	
                                   
                                    ) values ('" . $obj2[$i]['order_id'] . "','" .
                    $obj2[$i]['order_status'] . "','" . $obj2[$i]['order_total_price'] . "','" . $obj2[$i]['order_create_time'] .
                    "','" . $time1 . "','" . $obj2[$i]['order_express_price'] . "','" . $obj2[$i]['buyer_openid'] .
                    "','" . $obj2[$i]['buyer_nick'] . "','" . $obj2[$i]['receiver_name'] . "','" . $obj2[$i]['receiver_province'] .
                    "','" . $obj2[$i]['receiver_city'] . "','" . $obj2[$i]['receiver_address'] .
                    "','" . $obj2[$i]['receiver_mobile'] . "','" . $obj2[$i]['receiver_phone'] .
                    "','" . $obj2[$i]['product_id'] . "','" . $obj2[$i]['product_name'] . "','" . $obj2[$i]['product_price'] .
                    "','" . $obj2[$i]['product_sku'] . "','" . $obj2[$i]['product_count'] . "','" .
                    $obj2[$i]['product_img'] . "','" . $obj2[$i]['delivery_id'] . "','" . $obj2[$i]['delivery_company'] .
                    "','" . $obj2[$i]['trans_id'] . "','" . $time2 . "')";
                $res = $GLOBALS['db']->query($sql);

                $txt .= $obj2[$i]['order_id'] . "/" . $obj2[$i]['buyer_nick'] . "下载成功<br>
                        ";
            } else {
                //如果已存在订单

                $up = "update weixiaodian set order_status='" . $obj2[$i]['order_status'] .
                    "' where order_sn='" . $obj2[$i]['order_id'] . "'";
                $res = $GLOBALS['db']->query($up);

                $txt .= $obj2[$i]['order_id'] . "/" . $obj2[$i]['buyer_nick'] . "更新成功<br>
                         ";
            }

        }
        return $txt;
    }
    //print_r($status);exit;
    for ($i = 0; $i < count($status); $i++) {
        $arr = array(
            "status" => $status[$i]['status'],
            "begintime" => $start_time,
            "endtime" => $end_time);
        $res = json_encode($arr);
        $order_list = download_list($ACC_TOKEN, $res);

        //  if ($order_list['errcode'] == -1) {
        //            $order_list = download_list($ACC_TOKEN, $res);
        //            if ($order_list['errcode'] == -1) {
        //                $order_list = download_list($ACC_TOKEN, $res);
        //                if ($order_list['errcode'] == -1) {
        //                    $order_list = download_list($ACC_TOKEN, $res);
        //                }
        //            }
        //        }

        while ($order_list['errcode'] == -1) {
            //echo "错误/";
            $order_list = download_list($ACC_TOKEN, $res);

            if ($order_list['errcode'] == 0) {
                //echo "成功/";
                break;
            }
        }
        //print_r($order_list);


        if (!empty($order_list['order_list'])) {
            //插入数据库


            $msg = weixiaodian_order($order_list);
            $xx .= $msg;
        }


        //print_r($order_list);
    }
    echo $xx;
}


if ($_REQUEST['act'] == 'count_order') {

    class getArr
    {
        public $reqUrl = '';
        public $openid;
        public function get_time_diff($t)
        {
            $time = date('Y-m-d H:i:s', time());
            $time = strtotime($time);
            //echo $time;exit;
            $aaa = date("YmdHis", $time);
            // $time = date('Y-m-d H:i:s', time());
            $t = strtotime($t);
            //echo $time;exit;
            $t = date("YmdHis", $t);
            $a = $this->timeDiff($aaa, $t);
            return $a;
        }
        public function timeDiff($aTime, $bTime)
        {
            // 分割第一个时间
            $ayear = substr($aTime, 0, 4);
            $amonth = substr($aTime, 4, 2);
            $aday = substr($aTime, 6, 2);
            $ahour = substr($aTime, 8, 2);
            $aminute = substr($aTime, 10, 2);
            $asecond = substr($aTime, 12, 2);
            // 分割第二个时间
            $byear = substr($bTime, 0, 4);
            $bmonth = substr($bTime, 4, 2);
            $bday = substr($bTime, 6, 2);
            $bhour = substr($bTime, 8, 2);
            $bminute = substr($bTime, 10, 2);
            $bsecond = substr($bTime, 12, 2);
            // 生成时间戳
            $a = mktime($ahour, $aminute, $asecond, $amonth, $aday, $ayear);
            $b = mktime($bhour, $bminute, $bsecond, $bmonth, $bday, $byear);
            $timeDiff['second'] = $a - $b;
            // 采用了四舍五入,可以修改
            $timeDiff['mintue'] = round($timeDiff['second'] / 60);
            $timeDiff['hour'] = round($timeDiff['mintue'] / 60);
            $timeDiff['day'] = round($timeDiff['hour'] / 24);
            $timeDiff['week'] = round($timeDiff['day'] / 7);
            $timeDiff['month'] = round($timeDiff['day'] / 30); // 按30天来算
            $timeDiff['year'] = round($timeDiff['day'] / 365); // 按365天来算
            return $timeDiff;
        }
        public function getToken()
        {
            $get_app = "select app_id ,app_secret from app_id where weixin_id=1";
            $get_app = $GLOBALS['db']->getRow($get_app);
            //print_r($get_app);exit;

            $APPID = $get_app['app_id'];
            $APPSECRET = $get_app['app_secret'];
            if (empty($APPID)) {
                echo "appid missing";
                exit;
            } elseif (empty($APPSECRET)) {
                echo "appsecret missing";
                exit;
            } else {

            }
            //https://api.weixin.qq.com/cgi-bin/user/get?access_token=ACCESS_TOKEN&next_openid=NEXT_OPENID


            //                return $ACC_TOKEN;
            $a_token_time = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
            $a_token_time = $GLOBALS['db']->getRow($a_token_time);
            //print_r($a_token_time);exit;

            $time_diff = $this->get_time_diff($a_token_time['last_update']);
            //print_r($time_diff);
            //            exit;
            if ($time_diff['second'] >= 3600 or $time_diff['second'] <= -1) {

                $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                    $APPID . "&secret=" . $APPSECRET;

                $json = file_get_contents($TOKEN_URL);
                $result = json_decode($json);
                $ACC_TOKEN = $result->access_token;


                $i = 0;
                while ($result->access_token == '') {

                    $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                        $APPID . "&secret=" . $APPSECRET;

                    $json = file_get_contents($TOKEN_URL);
                    $result = json_decode($json);


                    $i++;

                    if ($result->access_token != '') {


                        $ACC_TOKEN = $result->access_token;


                        break;
                    } elseif ($i >= 5) {
                        break;
                    }

                }


                $time = date('Y-m-d H:i:s', time());
                $u_acc_token = "update temporary_tb set access_token='" . $ACC_TOKEN .
                    "',last_update='" . $time . "' where type=1 and app_id=1";
                $u_acc_token = $GLOBALS['db']->query($u_acc_token);


                //echo 1;
                $a_token_time2 = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
                $a_token_time2 = $GLOBALS['db']->getRow($a_token_time2);
                return $a_token_time2['access_token'];
                //echo $time_diff['second'] . "1";
                //exit;
            } else {
                //echo 2;
                $a_token_time2 = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
                $a_token_time2 = $GLOBALS['db']->getRow($a_token_time2);

                //print_r(empty($a_token_time2));exit;

                $i = 0;
                while ($a_token_time2['access_token'] == '') {

                    $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                        $APPID . "&secret=" . $APPSECRET;

                    $json = file_get_contents($TOKEN_URL);
                    $result = json_decode($json);

                    $i++;
                    //echo $i;
                    $a_token_time2['access_token'] = $result->access_token;
                    //print_r($a_token_time2['access_token']) ;
                    if ($a_token_time2['access_token'] != '') {


                        $ACC_TOKEN = $result->access_token;
                        $time = date('Y-m-d H:i:s', time());
                        $u_acc_token = "update temporary_tb set access_token='" . $ACC_TOKEN .
                            "',last_update='" . $time . "' where type=1 and app_id=1";
                        $u_acc_token = $GLOBALS['db']->query($u_acc_token);


                        break;
                    } elseif ($i >= 5) {
                        break;
                    }

                }


                $a_token_time3 = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
                $a_token_time3 = $GLOBALS['db']->getRow($a_token_time3);

                //exit;

                return $a_token_time3['access_token'];
            }
            //exit;

        }

        public function getOpenid()
        {
            $MENU_URL = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=" . $this->
                getToken();

            //print_r($MENU_URL);exit;
            $json = file_get_contents($MENU_URL);
            $result = json_decode($json);
            //print_r($json);exit;
            //递归stdClass Object 对象
            function objtoarr($obj)
            {
                $ret = array();
                foreach ($obj as $key => $value) {
                    if (gettype($value) == 'array' || gettype($value) == 'object') {
                        $ret[$key] = objtoarr($value);
                    } else {
                        $ret[$key] = $value;
                    }
                }
                return $ret;
            }

            $result2 = objtoarr($result);
            return $result2;


        }

        public function getopen()
        {
            //https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN
            $MENU_URL = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $this->
                getToken() . "&openid=" . $this->openid . "&lang=zh_CN";

            //print_r($MENU_URL);exit;
            $json = file_get_contents($MENU_URL);
            $result = json_decode($json);
            //print_r($json);exit;
            //递归stdClass Object 对象
            function objtoarr2($obj)
            {
                $ret = array();
                foreach ($obj as $key => $value) {
                    if (gettype($value) == 'array' || gettype($value) == 'object') {
                        $ret[$key] = objtoarr($value);
                    } else {
                        $ret[$key] = $value;
                    }
                }
                return $ret;
            }

            $result2 = objtoarr2($result);
            return $result2;

        }

    }

    $ex = new getArr();
    $ACC_TOKEN = $ex->getToken();


    //拼装post数据
    $start_time = strtotime($_REQUEST['start_time']);
    $end_time = strtotime($_REQUEST['end_time']);


    function objtoarr($obj)
    {
        $ret = array();
        foreach ($obj as $key => $value) {
            if (gettype($value) == 'array' || gettype($value) == 'object') {
                $ret[$key] = objtoarr($value);
            } else {
                $ret[$key] = $value;
            }
        }
        return $ret;
    }
    function download_dj($token, $res)
    {
        $MENU_URL = "https://api.weixin.qq.com/merchant/order/getbyfilter?access_token=" .
            $token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $MENU_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT,
            'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $res);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo2 = curl_exec($ch);

        $obj = objtoarr(json_decode($tmpInfo2));
       // print_r($obj);
        return $obj;

    }

    $status = array(
        array("status" => 2, "msg" => "待发货"),
        array("status" => 3, "msg" => "已发货"),
        array("status" => 5, "msg" => "已完成"),
        array("status" => 8, "msg" => "维权中"));

    $ret = array();


    //----测试
    //   $arr = array(
    //            "status" => 8,
    //            "begintime" => $start_time,
    //            "endtime" => $end_time);
    //        $res = json_encode($arr);
    //        $order_sum = download_dj($ACC_TOKEN, $res);
    //        print_r($)
    //-----

    //print_r($status);exit;
    for ($i = 0; $i < count($status); $i++) {
        $arr = array(
            "status" => $status[$i]['status'],
            "begintime" => $start_time,
            "endtime" => $end_time);
        $res = json_encode($arr);
        $order_sum = download_dj($ACC_TOKEN, $res);


        while ($order_sum['errcode'] == -1) {
            //echo "错误/";
            $order_sum = download_dj($ACC_TOKEN, $res);

            if ($order_sum['errcode'] == 0) {
              //  echo "成功/";
                break;
            }
        }
        //print_r($order_sum);

        $list = array(
            "status" => $status[$i]['status'],
            "msg" => $status[$i]['msg'],
            "sl" => count($order_sum['order_list']));
        //echo $status[$i]['msg'].":".$order_sum;exit;
        array_push($ret, $list);

    }

    print_r(json_encode($ret));


}




if ($_REQUEST['act'] == 'set_or_status') {
    
    if(isset($_REQUEST['sn']))
    {
        
        $sql="update weixiaodian set or_status='".$_REQUEST['or_status']."' where order_sn='".$_REQUEST['sn']."'";
        $res = $GLOBALS['db']->query($sql);
        echo 1;
    }
    else
    {
        echo 2;
    }
}
?>