<?php

function shop($Nu, $tb)
{
    $sql = "select id,
            shop_sn,
            shop_name,
            shop_type,
            p_id,
            qrcid,
            shop_qy,
            ticket,
            province,
            city,
            district,
            shop_address,
            shop_lxr,
            lbsaddress,
            lbsjd,
            lbswd,
            tzsy,
            add_time,
            last_update,
            last_update_2 
            from shop";
    //关注时间,id,城市,省，国家，图片,用户昵称,


    if (isset($_REQUEST['Action'])) {
        $filer = $_REQUEST['Action'];
    }

    if (isset($_REQUEST['m_key'])) {
        $filer1 = " and ( shop_sn like '%" . trim($_REQUEST['m_key']) .
            "%' or shop_name like '%" . trim($_REQUEST['m_key']) . "%')";
    } else {
        $filer1 = '';
    }

    $action_list = array();
    $filer = " where 1=1 $filer1 ";
    $res2 = get_table_count($tb, $filer);
    $obj = get_page($res2, $Nu);


    //$sql="select id,order_info_sn,order_info_name,order_info_outer_name,order_info_note_1,order_info_note_2,order_info_note_3,order_info_note_4,order_info_note_5,order_info_name_eg,zz,tzsy,action_url,last_update,last_update_2,start_time,end_time,sort_no  from order_info ";
    $sql = $sql . $filer . " order by add_time desc " . $obj['limit_obj'] . " ;";
    //$sql = $sql . $filer . " order  by -sort_no  desc " . $obj['limit_obj'] . ";";
    $res = $GLOBALS['db']->getAll($sql);
    
    
     //显示推广信息
    for($j=0;$j<count($res);$j++)
    {
        $point="select * from tgpoint where p_id='".$res[$j]['shop_sn']."' and p_type=2 order by users_sn";
       
        $res[$j]['point']=$GLOBALS['db']->getAll($point);
    }

    return array('item' => $res, 'page' => $obj);

}


function get_qudao_list()
{
//    if (isset($_REQUEST['id'])) {
//      $where=" where id='".$_REQUEST['id'];  
//           // echo $filer;
//        }
  $sql="select qudao_sn,qudao_name,qudao_type,p_id from qudao where qudao_type='0' or qudao_type='1' ";
    $res = $GLOBALS['db']->getAll($sql);
        //$noNum=20;
    return array('items'=>$res,'sql'=>$sql);
}

function get_qudao_mx($code)
{
 
    $sql="select qudao_sn,qudao_name,qudao_type from qudao where qudao_sn='".$code."' ";
    $res = $GLOBALS['db']->getAll($sql);
      // print_r($sql);
    return array('items'=>$res,'sql'=>$sql);
}



function page_count($obj, $page_no, $page_num)
{
    if (isset($obj)) {
        $obj = $obj;
    }
    if (isset($page_no)) {
        $page_no = $page_no;
    } else {
        $page_no = 1;
    }
    if (isset($page_num)) {
        $page_num = $page_num;
    } else {
        $page_num = 20;
    }

}


function i_shop($tb, $field, $time_f)
{

    $array = explode(",", $field);

    for ($i = 0; $i < count($array); $i++) {
        $dh1 = "";
        $dh2 = ",";

        if ($i == count($array) - 1) {
            $dh2 = "";
        }
        $f1 .= $dh1 . $array[$i] . $dh2;

        $fh1 = "'";
        $fh2 = "',";

        if ($i == count($array) - 1) {
            $fh2 = "'";
        }
        $f2 .= $fh1 . req($array[$i]) . $fh2;

    }
    // print_r($i);exit;
    $time = date('Y-m-d H:i:s', time());
    $sql = "insert into " . $tb . "(" . $f1 . "," . $time_f[0]['field'] .
        ") values(" . $f2 . ",'" . $time . "')";
    //print_r($sql);exit;
    $res = $GLOBALS['db']->query($sql);
    return array('sql' => $sql);


}


function req($obj)
{
    //print_r($obj);
  if (isset($_REQUEST[$obj])) {
    if(is_string($_REQUEST[$obj]))
    {
        $aaa = addslashes(trim($_REQUEST[$obj]));
        if($aaa=="timeL")
        {
        $aaa=date('Y-m-d H:i:s', time());
        }
        elseif($aaa=="timeS")
        {
        $aaa=date('Y-m-d', time());
        }
        return $aaa;
    }
    else
    {
        $aaa =addslashes($_REQUEST[$obj])  ;
         if($aaa=="timeL")
        {
        $aaa=date('Y-m-d H:i:s', time());
        }
        elseif($aaa=="timeS")
        {
        $aaa=date('Y-m-d', time());
        }
        return $aaa;
    }
        
    }
 
}





function get_shop_mx($obj)
{   
      $sql="select id,b_id,
            shop_sn,
            shop_name,
            shop_type,
            p_id,
            qrcid,
            shop_qy,
            province,
            city,
            district,
            shop_address,
            shop_lxr,
            lbsaddress,
            lbsjd,
            lbswd,
            tzsy,
            add_time,
            last_update,
            last_update_2 ,dgpoint 
            from shop where shop_sn='".$obj."' ";
    $res = $GLOBALS['db']->getAll($sql);
    
    $point="select * from tgpoint where p_id='".$obj."' and p_type=2 order by users_sn";
    $res[0]['point']= $GLOBALS['db']->getAll($point);
    
    //$noNum=20;
    return array('items' => $res);
}





function update_shop_mx($tb,$field,$u_id,$time_f)
{   
     //$tb,$field,$u_id表，字段，关键字
    //print_r($field);
   // $field="color_name,color_note_1,color_note_2";
    $array = explode(",",$field);
 
    for($i=0;$i<count($array);$i++)
    {
        $dh1="='";$dh2="',";
        
        if($i==count($array)-1){$dh2="'";}
        $fi.=$array[$i].$dh1.req($array[$i]).$dh2;
        
    }
    
    //print_r($fi);exit;
    $sql="update ".$tb." set ".$fi." where ".$u_id." = '".req($u_id)."';";
    

    $res = $GLOBALS['db']->query($sql);
    
      for($j=0;$j<count($time_f);$j++)
    {
        if($time_f[$j]['type']==2)
        {
            $time=date('Y-m-d H:i:s', time());
        }
        elseif( $time_f[$j]['type']==1)
        {
           $time=date('Y-m-d', time());
        }
        
        $sql_t="update ".$tb." set " .$time_f[$j]['field']. "='".$time."' where ".$u_id." = '".req($u_id)."';";
        
        $res = $GLOBALS['db']->query($sql_t);
           
    }
    
  

    return array('sql' => $sql);

}


function get_api_bhwh()
{
  $sql="select bh from api_bhwh where cj_name='shop'";
    $res = $GLOBALS['db']->getAll($sql);
        //$noNum=20;
    return array('items'=>$res,'sql'=>$sql);
}
function update_api_bhwh()
{
  $sql="update api_bhwh set bh=bh+1 where cj_name='shop'";
  $res = $GLOBALS['db']->query($sql);
}


function https_post($url, $data = null){
     $curl = curl_init();
     curl_setopt($curl, CURLOPT_URL, $url);
     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
     if (!empty($data)){
         curl_setopt($curl, CURLOPT_POST, 1);
         curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
     }
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
     $output = curl_exec($curl);
     curl_close($curl);
     return $output;
 }

function downloadImageFromWeiXin($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);    
    curl_setopt($ch, CURLOPT_NOBODY, 0);    //只取body头
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $package = curl_exec($ch);
    $httpinfo = curl_getinfo($ch);
    curl_close($ch);
    return array_merge(array('body' => $package), array('header' => $httpinfo)); 
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
            //exit;
            if ($time_diff['second'] >= 3600 or $time_diff['second'] <= -1) {

                $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                    $APPID . "&secret=" . $APPSECRET;

                $json = file_get_contents($TOKEN_URL);
                $result = json_decode($json);
                //print_r($result);
                //exit;

                $ACC_TOKEN = $result->access_token;
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
                //print_r($a_token_time2);exit;
                return $a_token_time2['access_token'];
            }
         
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




function get_qs($bid,$pid)
{


    $sql1 = "select qudao_sn,qudao_name
     from qudao where qudao_type='".$bid."'  ";
    $item= $GLOBALS['db']->getAll($sql1);
 
 
//return $sql2;exit;
    return $item;


}



function set_point($obj,$obj2,$obj3)
{
    $de="delete from tgpoint  where p_id='".$obj3."' and p_type=2";
    //print_r($de);exit;
        $de = $GLOBALS['db']->query($de);
    for($i=0;$i<count($obj);$i++)
    {
        $str = substr($obj[$i],0,14);
        
        $yonhu="select * from users  where users_sn='".$str."'";
        $yonhu = $GLOBALS['db']->getRow($yonhu);
        
        $qrcd="select shop_name,qrcid from shop  where shop_sn='".$obj3."'";
        $qrcd = $GLOBALS['db']->getRow($qrcd);
        
        $time = date('Y-m-d H:i:s', time());
                $last_update_2 = date('Y-m-d', time());
        
        $de="delete from  cj_qrcode_stat where  openid='".$yonhu['openid']."'";
        $sql = $GLOBALS['db']->query($de);
        
        $sql = "insert into cj_qrcode_stat(openid,issubs,cj_sn,cj_name,cj_type,qrcid,add_time,last_update_2) values('" .
                    $yonhu['openid'] . "',1,'" . $obj3 . "','" . $qrcd['shop_name'] . "','shop','" . $qrcd['qrcid'] .
                    "','" . $time . "','" . $last_update_2 . "')";
                $resaa = $GLOBALS['db']->query($sql);
        
        
        
        $sql="insert into tgpoint(p_type,p_id,openid,users_sn,nick_name,point) select 2,'".$obj3."',openid,users_sn,nick_name,".$obj2[$i]." from users  where users_sn='".$str."'";
        $sql = $GLOBALS['db']->query($sql);
        //print_r($sql);
    }
}


?>