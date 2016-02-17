<?php


function get_tk()
{
     $sql="select id,appid_sn,weixin_id,app_id,app_secret from app_id where weixin_id=1";
     $res = $GLOBALS['db']->getRow($sql);
      $token=md5(($res['appid_sn'])."tiemal");
      
      
       return $token;
}

class wx_response
{
    public $openid;
    public $p_id;
    public $response_sn;
    public $openid2;
    public $is_cu='0';
    public $wx_tel;
    public $wx_user_id;
    public function in_response()
    {
        //判断用户的session是否存在在系统中
        $one = "select openid from  response_sessions where openid='" . $this->openid .
            "'";
        $one = $GLOBALS['db']->getRow($one);

        if (!empty($one)) {

        } else {
            if (!empty($this->openid)) {
                $sql = "insert into response_sessions(openid) values('" . $this->openid . "') ";
                $res = $GLOBALS['db']->query($sql);

            }
        }


    }

    public function update_response()
    {
        if (!empty($this->openid)) {
            $sql = "update  response_sessions set p_id='" . $this->p_id . "',response_sn='" .
                $this->response_sn . "',wx_tel='". $this->wx_tel ."',wx_user_id='". $this->wx_user_id ."' where openid='" . $this->openid . "'";
            $res = $GLOBALS['db']->query($sql);
            $this->p_id=$this->openid='';
            //return $sql;
        }
    }
    
    public function update_response2()
    {
        if (!empty($this->openid)) {
            $sql = "update  response_sessions set p_id='" . $this->p_id . "',response_sn='" .
                $this->response_sn . "',openid2='".$this->openid2."',is_cu='".$this->is_cu."' where openid='" . $this->openid . "'";
            $res = $GLOBALS['db']->query($sql);
            $this->p_id=$this->openid='';
            //return $sql;
        }
    }


    public function get_response()
    {
        if (!empty($this->openid)) {
            $sql = " select * from response_sessions where openid='" . $this->openid . "'";
            $res = $GLOBALS['db']->getRow($sql);
            return $res;
        }
    }
}


$get_one = " select re_type,re_code from  attention ";
$res = $GLOBALS['db']->getRow($get_one);


function sub_list()
{

    $sub = "select m_key,type,re_type,re_code from menu_list where re_code!='CHECK_IN' ;";

    $sub_list = $GLOBALS['db']->getAll($sub);

    return $sub_list;
}
$sub_list = sub_list();


function custom_list()
{

    $custom = "select re_type,re_code,tzsy,custom_sn,custom_name,custom_note_1,text from custom where tzsy=0 and (p_id!='SHANGPIN_000' or p_id is null)";

    $custom_list = $GLOBALS['db']->getAll($custom);

    return $custom_list;
}
$custom_list = custom_list();


function custom_list_000()
{

    $custom = "select re_type,re_code,tzsy,custom_sn,custom_name,custom_note_1,text from custom where tzsy=0 and custom_sn='000' ;";

    $custom_list = $GLOBALS['db']->getAll($custom);

    return $custom_list;
}
$custom_list_000 = custom_list_000();


function shangpin_000()
{

    $custom = "select re_type,re_code,tzsy,custom_sn,custom_name,custom_note_1,text,case when p_id is null then custom_sn when p_id is not null then concat(p_id,'_',custom_sn) end   as p_id2  from custom where tzsy=0 and custom_sn='SHANGPIN_000' ;";

    $custom_list = $GLOBALS['db']->getAll($custom);

    return $custom_list;
}
$shangpin = shangpin_000();

function shangpin_p_id()
{

    $shangpin_p_id = "select re_type,re_code,tzsy,custom_sn,custom_name,custom_note_1,text,case when p_id is null then custom_sn when p_id is not null then concat(p_id,'_',custom_sn) end   as p_id2  from custom where tzsy=0 and p_id='SHANGPIN_000' and custom_sn!='SHANGPIN_END' and custom_sn!='SHANGPIN_SEARCH' and custom_sn!='BEGIN_SHOPPING';";

    $shangpin_p_id = $GLOBALS['db']->getAll($shangpin_p_id);

    return $shangpin_p_id;
}

//print_r($custom_list);

//  $text = "select text from text_reply where text_sn='" . $sub_list[0]['re_code'] .
//                            "'";
//                        $text_list = $GLOBALS['db']->getRow($text);
//                        print_r($text_list);

//----------------------------------------------------------
function shangpin_end()
{

    $shangpin_end = "select re_type,re_code,tzsy,custom_sn,custom_name,custom_note_1,text,case when p_id is null then custom_sn when p_id is not null then concat(p_id,'_',custom_sn) end   as p_id2  from custom where tzsy=0 and custom_sn='SHANGPIN_END' ;";

    $shangpin_end = $GLOBALS['db']->getAll($shangpin_end);

    return $shangpin_end;
}

function shangpin_serach()
{

    $shangpin_serach = "select re_type,re_code,tzsy,custom_sn,custom_name,custom_note_1,text,case when p_id is null then custom_sn when p_id is not null then concat(p_id,'_',custom_sn) end   as p_id2  from custom where tzsy=0 and custom_sn='SHANGPIN_SEARCH' ;";

    $shangpin_serach = $GLOBALS['db']->getAll($shangpin_serach);

    return $shangpin_serach;
}


function get_now_custom($obj)
{

    $list = "select re_type,re_code,tzsy,custom_sn,custom_name,custom_note_1,text,case when p_id is null then custom_sn when p_id is not null then concat(p_id,'_',custom_sn) end   as p_id2  from custom where tzsy=0 and custom_sn='".$obj."' ;";

    $list = $GLOBALS['db']->getAll($list);

    return $list;
}
 $chaxun=get_now_custom("SHANGPIN_SEARCH");
 
 
 
 
function get_now_menu_list($obj)
{

    $sub = "select m_key,type,re_type,re_code from menu_list where  re_code='".$obj."' ;";

    $sub_list = $GLOBALS['db']->getAll($sub);

    return $sub_list;

}
 $check_in=get_now_menu_list("CHECK_IN");
//print_r($chaxun);













///夸库查询
class SDB2
{
    public $goods_sn;
    public $order_sn;
    public $tel;
    public $order_id;
    
    public function get_goods_list()
    {
        $sql="select * from goods limit 1";
        $res = $GLOBALS['db2']->getAll($sql);
        return $res;
    }
    
    
    public function get_goods_mx()
    {
        $sql="select a.goods_sn,a.goods_name,b.color_code,b.color_name,c.size_code,c.size_name from goods a inner join goods_color b on a.goods_id=b.goods_id inner join goods_size c on a.goods_id=c.goods_id where a.goods_sn='".$this->goods_sn."' group by a.goods_sn,b.color_code ,c.size_code";
        $res = $GLOBALS['db2']->getAll($sql);
        return $res;
    }
    
    
    
    public function get_goods_color()
    {
        $sql="select a.goods_id,a.goods_sn,a.goods_name,b.color_id,b.color_code,b.color_name from goods a inner join goods_color b on a.goods_id=b.goods_id inner join goods_size c on a.goods_id=c.goods_id where a.goods_sn='".$this->goods_sn."' group by a.goods_sn,b.color_code ";
        $res = $GLOBALS['db2']->getAll($sql);
        for($i=0;$i<count($res);$i++)
        {
            
            $sql2="select b.size_code,b.size_name,a.sl,a.sl2,a.sl3 from spkcb a left join size b on a.size_id=b.size_id where  a.goods_id='".$res[$i]['goods_id']."' and a.color_id='".$res[$i]['color_id']."'";
            $res[$i]['size_mx'] = $GLOBALS['db2']->getAll($sql2);
        }
        return $res;
    }
    
    
    public function get_goods_sn()
    {
        $sql="select goods_sn,goods_name from goods where goods_sn like '%".$this->goods_sn."%'";
        $res = $GLOBALS['db2']->getAll($sql);
        return $res;
    }
    
    
    public function get_order_info()
    {
        $sql="select order_sn from order_info where order_sn='".$this->order_sn."'";
        $res = $GLOBALS['db2']->getAll($sql);
        return $res;
    }
     public function get_order_tel()
    {
        $sql="select order_sn,consignee,order_id,pay_status,order_status,is_send,shipping_status,shipping_name,invoice_no from order_info where tel='".$this->tel."' or  mobile='".$this->tel."' order by order_id desc";
        $res = $GLOBALS['db2']->getAll($sql);
        return $res;
    }
     public function get_order_action()
    {
        $sql="select *,from_unixtime(log_time) as action_time from order_action where order_id='".$this->order_id."' order by action_id desc";
        $res = $GLOBALS['db2']->getAll($sql);
        return $res;
    }
      public function get_user_info()
    {
        $sql="select a.user_name,a.nick_name,b.* from users a,user_address b where a.user_id=b.user_id and b.receiver_mobile='".$this->tel."'";
        $res = $GLOBALS['db2']->getRow($sql);
        return $res;
    }
}



//获取openid用户名
function get_nick_name($openid)
{
    $sql="select openid,nick_name from users where openid='".$openid."'";
    $res = $GLOBALS['db']->getRow($sql);
    
    return $res;
}



function insert_random_code($openid,$order_sn)
{
    $code=rand(1000,9999);
    
    $sql="select random_code from random_code where random_code ='".$code."' and is_use=0";
    $res = $GLOBALS['db']->getRow($sql);
    if(empty($res))
    {
         $sql2="insert into random_code (random_code,openid,order_sn) values ('".$code."','".$openid."','".$order_sn."')";
         $res2 = $GLOBALS['db']->query($sql2);
         //更新随机码
             $sql = "update shopping_sessions set random_code='" . $code .
                                "' where openid='" . $openid . "'";
             $res = $GLOBALS['db']->query($sql);
         
        return $code;
    }
    else
    {
       insert_random_code();
    }
    
   
}
function se_random_code($openid,$code)
{
    
    
    $sql="select random_code from random_code where random_code ='".$code."' ";
    $res = $GLOBALS['db']->getRow($sql);
    if(empty($res))
    {

        return "unfind";
    }
    else
    {
        $sql2="update random_code set is_use=1,openid2='".$openid."' where random_code='".$code."'";
        $res2 = $GLOBALS['db']->query($sql2);
        
        //生成积分单还没写
    }
    
   
}





// 获取关键字

class wx_custom2
{
    public $custom_sn;
    public $content;
    

    function get_custom()
    {

        $sql = "select re_type,re_code,tzsy,custom_sn,custom_name,custom_note_1,text,case when p_id is null then custom_sn when p_id is not null then concat(p_id,'_',custom_sn) end   as p_id2  from custom where tzsy=0 and custom_sn='" .
            $this->custom_sn . "' and p_id is not null;";

        $list = $GLOBALS['db']->getRow($sql);

        return $list;
    }
    
    function get_response()
    {
        
        $arr=$this->get_custom();
      
        if ($arr['custom_name'] == $this->content) //添加为yate商品查询的二次开发
        //if (!empty($arr))
                {
                if ($arr['re_type'] == 'text') {
                    $text = "select text from text_reply where text_sn='" . $arr['re_code'] .
                        "'";
                    $text_list = $GLOBALS['db']->getRow($text);

                    $data = $text_list['text'];

                    return $data;
                    //exit(W::response($xml, $data));
                } elseif ($arr['re_type'] == 'imgtext') {
                    $imgtext = "select b.img_note_1 as title,b.img_note_2 as note,b.b_img_url as cover,b.img_action_url as link from imgtext a,imgtext_imgs b where a.imgtext_sn=b.p_id and b.ss=1 and a.imgtext_sn='" .
                        $arr['re_code'] . "'";
                    $img_list = $GLOBALS['db']->getAll($imgtext);

                    $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']);
                    for ($i = 0; $i < count($img_list); $i++) {
                        $img_list[$i]['cover'] = $url_this . "/" . $img_list[$i]['cover'];
                    }
                    $data = $img_list;
                    
                     return $data;
                    //exit(W::response($xml, $data, 'news'));
                }

            }
            else
            {
                //return $arr['custom_name'];
                return "error";
            }
    }
    
}



 function timeDiff_x($aTime, $bTime)
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
function get_time_diff($t)
    {
        $time = date('Y-m-d H:i:s', time());
        $time = strtotime($time);
        //echo $time;exit;
        $aaa = date("YmdHis", $time);
        // $time = date('Y-m-d H:i:s', time());
        $t = strtotime($t);
        //echo $time;exit;
        $t = date("YmdHis", $t);
        $a = timeDiff_x($aaa, $t);
        return $a;
    }






//插入短信验证码

function insert_sms_random($openid,$tel)
{
    $code=rand(1000,9999);
    
     $n_time = date('Y-m-d H:i:s', time());
         $sql2="insert into sms_random (random_code,openid,tel,add_time) values ('".$code."','".$openid."','".$tel."','".$n_time."')";
         $res2 = $GLOBALS['db']->query($sql2);
         //更新随机码
     return $code;
   
}

function get_sms_random($openid)
{
    $sql2="select * from  sms_random  where openid='".$openid."' and is_use=0 order by add_time desc";
         $res2 = $GLOBALS['db']->getAll($sql2);
         return $res2;
}

function get_count_sms_random($openid)
{
    $time1 = date('Y-m-d 00:00:0', time());
     $time2 = date('Y-m-d 23:59:59', time());
    $sql2="select count(openid) as sl from  sms_random  where openid='".$openid."' and  add_time between '".$time1."' and '".$time2."'";
         $res2 = $GLOBALS['db']->getRow($sql2);
         return $res2;
}


//插入sms_sessions
function insert_sms_sessions($openid,$tel)
{
    //$code=rand(1000,9999);
    
    $sql="select openid from sms_sessions where openid='".$openid."'";
    $res = $GLOBALS['db']->getRow($sql);
    
    if(empty($res))
    {
         $n_time = date('Y-m-d H:i:s', time());
         $sql2="insert into sms_sessions (openid,tel,add_time) values ('".$openid."','".$tel."','".$n_time."')";
         $res2 = $GLOBALS['db']->query($sql2);
         $err="0";
    }
    else
    {
        $sql2="update sms_sessions set  tel='".$tel."' where openid='".$openid."'";
         $res2 = $GLOBALS['db']->query($sql2);
          $err="1";
    }
    
    
         //更新随机码
     return $err;
   
}


function get_sms_sessions($openid)
{
    $sql2="select * from  sms_sessions  where openid='".$openid."' and is_use=0 order by add_time desc";
         $res2 = $GLOBALS['db']->getAll($sql2);
         return $res2;
}


function ex_check1($openid,$con)
{
    $sql2="select tel,openid from  sms_random  where openid='".$openid."' and is_use=0 and random_code='".$con."' order by add_time desc";
         $res2 = $GLOBALS['db']->getRow($sql2);
         return $res2;
}
?>