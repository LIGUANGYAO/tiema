<?php


header('Content-Type: text/html; charset=utf-8');


define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'default') {


    ////更换成自己的APPID和APPSECRET
    //    $APPID = "wx9982320676ebe24b";
    //    $APPSECRET = "be2c371c6ccbceeb95e681c7795e3e40";
    //
    //
    //
    //
    //    $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
    //        $APPID . "&secret=" . $APPSECRET;
    //
    //    $json = file_get_contents($TOKEN_URL);
    //    $result = json_decode($json);
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
    }


    //   $get_app="select app_id ,app_secret from app_id where weixin_id=1";
    //    $get_app = $GLOBALS['db']->getRow($get_app);
    //    //print_r($get_app);exit;
    //
    //    $APPID = $get_app['app_id'];
    //    $APPSECRET = $get_app['app_secret'];
    //    if(empty($APPID))
    //    {
    //        echo "appid missing";exit;
    //    }
    //    elseif(empty($APPSECRET))
    //    {
    //        echo "appsecret missing";exit;
    //    }else
    //    {
    //
    //    }
    //
    //
    //
    //    $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
    //        $APPID . "&secret=" . $APPSECRET;
    //
    //    $json = file_get_contents($TOKEN_URL);
    //    $result = json_decode($json);
    $ex = new getArr();


    $ACC_TOKEN = $ex->getToken();

    //print_r($ex->getToken());exit;
    //$ACC_TOKEN = $result->access_token;


    //$MENU_URL="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$ACC_TOKEN;
    $MENU_URL = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=" . $ACC_TOKEN;
    //print_r($MENU_URL);
    $json = file_get_contents($MENU_URL);
    $result = json_decode($json);
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


    // print_r($result2);
    $button = $result2['menu']['button'];
    $truncate = "truncate menu_list;";
    $truncate = $GLOBALS['db']->query($truncate);
    for ($i = 0; $i < count($button); $i++) {
        //echo $button[$i]['name']
        //刷新
        $sql = "insert into menu_list(menu_sn,menu_type,type,name,sort_no,add_time) values ('M00" .
            $i . "','1','','" . $button[$i]['name'] . "','0','$now_time');";
        $sql_px = $GLOBALS['db']->query($sql);


        for ($j = 0; $j < count($button[$i]['sub_button']); $j++) {
            $bu_sql = "insert into menu_list(menu_sn,menu_type,type,name,p_name,m_key,sort_no,add_time) values ('M00" .
                $i . "_" . $j . "','2','" . $button[$i]['sub_button'][$j]['type'] . "','" . $button[$i]['sub_button'][$j]['name'] .
                "','" . $button[$i]['name'] . "','" . $button[$i]['sub_button'][$j]['key'] .
                "','0','$now_time');";
            $bu_sql2 = $GLOBALS['db']->query($bu_sql);
        }
        $up = "update menu_list set menu_sn=concat('M00',menu_type,'_',id);";
        $up = $GLOBALS['db']->query($up);
    }
    //$me_v1="create view menu_1 as select a.p_id ,a.p_name,a.name,b.menu_sn from menu_list a,menu_list b where a.p_name=b.name;";
    //$me_v1 = $GLOBALS['db']->query($me_v1);
    $me_v2 = "update menu_1 set p_id=menu_sn;";
    $me_v2 = $GLOBALS['db']->query($me_v2);
    //$me_v3="drop view menu_1;";
    //$me_v3 = $GLOBALS['db']->query($me_v3);
}


if ($_REQUEST['act'] == 'edit_menu') {
    class arraytojson
    {
        public function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
        {
            static $recursive_counter = 0;
            if (++$recursive_counter > 1000) {
                die('possible deep recursion attack');
            }
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $this->arrayRecursive($array[$key], $function, $apply_to_keys_also);
                } else {
                    $array[$key] = $function($value);
                }

                if ($apply_to_keys_also && is_string($key)) {
                    $new_key = $function($key);
                    if ($new_key != $key) {
                        $array[$new_key] = $array[$key];
                        //unset($array[$key]);
                    }
                }
            }
            $recursive_counter--;
        }

        /**************************************************************
        *
        *	将数组转换为JSON字符串（兼容中文）
        *	@param	array	$array		要转换的数组
        *	@return string		转换得到的json字符串
        *	@access public
        *
        *************************************************************/
        public function JSON($array)
        {
            $this->arrayRecursive($array, 'urlencode', true);
            $json = json_encode($array);
            return urldecode($json);
            //return $json;
            //return urldecode($json);
        }


        //$obj数据源items,$num 单页数据量，$pa第几页
        public function Ms_p_limit($obj, $num, $pa)
        {

            $num = intval($num);

            $pa = intval($pa);
            if ($pa <= 1) {
                $pa = 1;
            } else {
            }
            if ($num < 1) {
                $num = 20;
            } else {
            }
            $count = count($obj);
            //输入超出，暂时没写
            if ($num * $pa > $count) {
                //$pa=$count%$sum;
            }
            $start_p = ($num * ($pa - 1) + 1) - 1;
            $stop_p = $num;
            $sql = " limit " . $start_p . "," . $stop_p . " ";
            return $sql;
        }
    }


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
    }
    //   $get_app="select app_id ,app_secret from app_id where weixin_id=1";
    //    $get_app = $GLOBALS['db']->getRow($get_app);
    //    //print_r($get_app);exit;
    //
    //    $APPID = $get_app['app_id'];
    //    $APPSECRET = $get_app['app_secret'];
    //    if(empty($APPID))
    //    {
    //        echo "appid missing";exit;
    //    }
    //    elseif(empty($APPSECRET))
    //    {
    //        echo "appsecret missing";exit;
    //    }else
    //    {
    //
    //    }
    //
    //
    //
    //    $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
    //        $APPID . "&secret=" . $APPSECRET;
    //
    //    $json = file_get_contents($TOKEN_URL);
    //    $result = json_decode($json);
    $ex = new getArr();


    $ACC_TOKEN = $ex->getToken();
    //print_r($ACC_TOKEN);exit;
    function menu1_list()
    {
        $sql = "select menu_sn,name,type,m_key as 'key',action_url as url  from menu_list where menu_type=1 order by -sort_no ";
        $list = $GLOBALS['db']->getAll($sql);
        for ($i = 0; $i < count($list); $i++) {

            $sub = "select type,name,m_key as 'key',action_url as url from menu_list where menu_type=2 and p_id='" .
                $list[$i]['menu_sn'] . "' order by -sort_no;";

            $arr = $GLOBALS['db']->getAll($sub);
            if (empty($arr)) {

            } else {
                $list[$i]['sub_button'] = $arr;
            }

        }
        return $list;
    }
    $date = array();
    $data['button'] = menu1_list();

    //print_r($data);exit;
    $json_users = new arraytojson();
    $data = $json_users->JSON($data);
    
    
    //
    //  print_r($data);
    //    exit;
    //
    //    $data = '{
    //        "button": [
    //            {
    //                "name": "铁马科技",
    //                "sub_button": [
    //                    {
    //                        "type": "click",
    //                        "name": "关于我们",
    //                        "key": "about"
    //                    },
    //                    {
    //                        "type": "click",
    //                        "name": "联系我们",
    //                        "key": "contact"
    //                    }
    //                ]
    //            },
    //            {
    //                "name": "服务项目",
    //                "sub_button": [
    //                    {
    //                        "type": "click",
    //                        "name": "APP开发",
    //                        "key": "app"
    //                    },
    //                    {
    //                        "type": "click",
    //                        "name": "接口开发",
    //                        "key": "jiekou"
    //                    },
    //                    {
    //                        "type": "click",
    //                        "name": "软件开发",
    //                        "key": "ruanjian"
    //                    },
    //                    {
    //                        "type": "click",
    //                        "name": "电子商务",
    //                        "key": "dianshang"
    //                    },
    //                    {
    //                        "type": "click",
    //                        "name": "经典案例",
    //                        "key": "case"
    //                    }
    //                ]
    //            },
    //            {
    //                "name": "企业微信",
    //                "sub_button": [
    //                    {
    //                        "type": "click",
    //                        "name": "腾讯风风铃",
    //                        "key": "fengling"
    //                    },
    //                    {
    //                        "type": "click",
    //                        "name": "微信营销",
    //                        "key": "weixin"
    //                    }
    //                ]
    //            }
    //        ]
    //    }';

    $MENU_URL = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $ACC_TOKEN;

    $ch = curl_init($MENU_URL);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
            'Content-Length: ' . strlen($data)));
    $info = curl_exec($ch);
    $menu = json_decode($info);
   // print_r($menu); //创建成功返回：{"errcode":0,"errmsg":"ok"}
//    exit;
    if ($menu->errcode == "0") {
        echo "菜单创建成功";
        //print_r($data);
    } else {
        echo "菜单创建失败,请输入菜单名和关键字";
        print_r($menu);
    }

}



?>