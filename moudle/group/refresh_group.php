<?php
/*
* 微信会员下载
*/

define('IN_ECS', true);

error_reporting(E_ALL & ~ (E_STRICT | E_NOTICE));


require_once (dirname(dirname(__file__)) . '/service/init.php');





//$sql = "select * from   response_sessions; ";
//$group = $GLOBALS['db']->getAll($sql);
//
//print_r($group);
////echo 1;
//exit;
$sql = "select group_sn,v1,v2,v3,v4,v5,v6 from wx_group where ( v1  is not null or  v1!='') and  ( v2  is not null or  v2!='') and  ( v3  is not null or  v3!='') and  ( v4  is not null or  v4!='') and  ( v5  is not null or  v5!='') and  ( v6  is not null or  v6!='')   ";
$group = $GLOBALS['db']->getAll($sql);

//print_r($group);

for ($j = 0; $j < count($group); $j++) {
    
    $group_sn= $group[$j]['group_sn'];
    
   // echo $group_sn;exit;
    $sqlaaa = "delete from wx_users_group where group_sn='" . $group_sn . "'";
    $resultaaa = $GLOBALS['db']->query($sqlaaa);
    
    $v6=$group[$j]['v6'];
    $v5=$group[$j]['v5'];
  
    
    $v4=$group[$j]['v4'];
    $v3=$group[$j]['v3'];
    $v2=$group[$j]['v2'];
    $v1=$group[$j]['v1'];
    
    //echo $v5;
    
    if ($v4 == 0) {
        if ($v1 != '' && $v1 != '请选择' && $v2 != '' && $v2 != '请选择' && $v3 != '' && $v3 !=
            '请选择') {
            $sql = "SELECT b.id,b.openid,b.users_sn,b.nick_name FROM cj_qrcode_stat  a  inner join users b on a.openid=b.openid  where a.cj_sn='" .
                $v3 . "'";


            $res1 = $GLOBALS['db']->getAll($sql);
            //print_r($res1);
        } elseif ($v1 != '' && $v1 != '请选择' && $v2 != '' && $v2 != '请选择') {
            $sql = "SELECT b.id,b.openid,b.users_sn,b.nick_name FROM cj_qrcode_stat  a  inner join users b on a.openid=b.openid  where a.cj_sn='" .
                $v2 . "'";


            $res1 = $GLOBALS['db']->getAll($sql);
            //print_r($res1);
        } elseif ($v1 != '' && $v1 != '请选择') {
            $sql = "SELECT b.id,b.openid,b.users_sn,b.nick_name FROM cj_qrcode_stat  a  inner join users b on a.openid=b.openid  where a.cj_sn='" .
                $v1 . "'";


            $res1 = $GLOBALS['db']->getAll($sql);
            //print_r($res1);
        }
        
        // print_r($res1);
        for ($i = 0; $i < count($res1); $i++) {

            $sql = "select id,openid,users_sn,nick_name from users where id='" . $res1[$i]['id'] .
                "' ";
            $res = $GLOBALS['db']->getAll($sql);

            $users_id = $res[0]['id'];
            $openid = $res[0]['openid'];
            $users_sn = $res[0]['users_sn'];
            $nick_name = addslashes($res[0]['nick_name']);
            $in = "insert into wx_users_group(group_sn,users_id,users_sn,nick_name,openid) values ('" .
                $group_sn . "','" . $users_id . "','" . $users_sn . "','" . $nick_name . "','" .
                $openid . "')";
            $res = $GLOBALS['db']->query($in);


        }

    } elseif ($v4 == 1) {
        if ($v1 != '' && $v1 != '请选择' && $v2 != '' && $v2 != '请选择' && $v3 != '' && $v3 !=
            '请选择') {
            $sql = "SELECT b.id,b.openid,b.users_sn,b.nick_name FROM cj_qrcode_stat  a  inner join users b on a.openid=b.openid  where a.cj_sn='" .
                $v3 . "'";


            $res1 = $GLOBALS['db']->getAll($sql);


            //print_r($res1);
        } elseif ($v1 != '' && $v1 != '请选择' && $v2 != '' && $v2 != '请选择') {
            $shop_mx = "select sales_sn from sales where p_id='" . $v2 . "' ";
            $shop_mx = $GLOBALS['db']->getAll($shop_mx);
            for ($j = 0; $j < count($shop_mx); $j++) {
                $d1 = ",'";
                $d2 = "'";
                if ($j == count($shop_mx) - 1) {
                    $d2 = "'";
                }
                $sn .= $d1 . $shop_mx[$j]['shop_sn'] . $d2;

            }

            //echo $sn;exit;
            $sql = "SELECT b.id,b.openid,b.users_sn,b.nick_name FROM cj_qrcode_stat  a  inner join users b on a.openid=b.openid  where a.cj_sn in ('" .
                $v2 . "'" . $sn . ") ";
            $res1 = $GLOBALS['db']->getAll($sql);
            //print_r($res1);
        } elseif ($v1 != '' && $v1 != '请选择') {


            $shop_mx = "select shop_sn from shop where p_id='" . $v1 . "' ";
            $shop_mx = $GLOBALS['db']->getAll($shop_mx);
            for ($j = 0; $j < count($shop_mx); $j++) {
                $d1 = ",'";
                $d2 = "'";

                $sn .= $d1 . $shop_mx[$j]['shop_sn'] . $d2;
            }
            //echo $sn;exit;
            $sql = "SELECT b.id,b.openid,b.users_sn,b.nick_name FROM cj_qrcode_stat  a  inner join users b on a.openid=b.openid  where a.cj_sn in ('" .
                $v1 . "'" . $sn . ") ";
            $res1 = $GLOBALS['db']->getAll($sql);


        }
           print_r($res1);
        for ($i = 0; $i < count($res1); $i++) {

            $sql = "select id,openid,users_sn,nick_name from users where id='" . $res1[$i]['id'] .
                "' ";
            $res = $GLOBALS['db']->getAll($sql);

            $users_id = $res[0]['id'];
            $openid = $res[0]['openid'];
            $users_sn = $res[0]['users_sn'];
            $nick_name = addslashes($res[0]['nick_name']);
            $in = "insert into wx_users_group(group_sn,users_id,users_sn,nick_name,openid) values ('" .
                $group_sn . "','" . $users_id . "','" . $users_sn . "','" . $nick_name . "','" .
                $openid . "')";
            $res = $GLOBALS['db']->query($in);


        }


    } elseif ($v4 == 2) {
        if ($v1 != '' && $v1 != '请选择' && $v2 != '' && $v2 != '请选择' && $v3 != '' && $v3 !=
            '请选择') {
            $sql = "SELECT b.id,b.openid,b.users_sn,b.nick_name FROM cj_qrcode_stat  a  inner join users b on a.openid=b.openid  where a.cj_sn='" .
                $v3 . "'";


            $res1 = $GLOBALS['db']->getAll($sql);


            //print_r($res1);
        } elseif ($v1 != '' && $v1 != '请选择' && $v2 != '' && $v2 != '请选择') {
            $shop_mx = "select sales_sn from sales where p_id='" . $v2 . "' ";
            $shop_mx = $GLOBALS['db']->getAll($shop_mx);
            for ($j = 0; $j < count($shop_mx); $j++) {
                $d1 = ",'";
                $d2 = "'";
                if ($j == count($shop_mx) - 1) {
                    $d2 = "'";
                }
                $sn .= $d1 . $shop_mx[$j]['shop_sn'] . $d2;

            }

            //echo $sn;exit;
            $sql = "SELECT b.id,b.openid,b.users_sn,b.nick_name FROM cj_qrcode_stat  a  inner join users b on a.openid=b.openid  where a.cj_sn in ('" .
                $v2 . "'" . $sn . ") ";
            $res1 = $GLOBALS['db']->getAll($sql);
            //print_r($res1);
        } elseif ($v1 != '' && $v1 != '请选择') {


            $shop_mx = "select shop_sn from shop where p_id='" . $v1 . "' ";
            $shop_mx = $GLOBALS['db']->getAll($shop_mx);
            for ($j = 0; $j < count($shop_mx); $j++) {
                $d1 = ",'";
                $d2 = "'";

                $sn .= $d1 . $shop_mx[$j]['shop_sn'] . $d2;
            }


            for ($k = 0; $k < count($shop_mx); $k++) {
                $sal = "select sales_sn from sales where p_id='" . $shop_mx[$k]['shop_sn'] .
                    "' ";
                $sal = $GLOBALS['db']->getAll($sal);
                for ($j = 0; $j < count($sal); $j++) {
                    $d1 = ",'";
                    $d2 = "'";

                    $sn .= $d1 . $sal[$j]['sales_sn'] . $d2;
                }

            }


            // echo $sn;exit;
            $sql = "SELECT b.id,b.openid,b.users_sn,b.nick_name FROM cj_qrcode_stat  a  inner join users b on a.openid=b.openid  where a.cj_sn in ('" .
                $v1 . "'" . $sn . ") ";
            $res1 = $GLOBALS['db']->getAll($sql);


        }
        
        
        
        for ($i = 0; $i < count($res1); $i++) {

            $sql = "select id,openid,users_sn,nick_name from users where id='" . $res1[$i]['id'] .
                "' ";
            $res = $GLOBALS['db']->getAll($sql);

            $users_id = $res[0]['id'];
            $openid = $res[0]['openid'];
            $users_sn = $res[0]['users_sn'];
            $nick_name = addslashes($res[0]['nick_name']);
            $in = "insert into wx_users_group(group_sn,users_id,users_sn,nick_name,openid) values ('" .
                $group_sn . "','" . $users_id . "','" . $users_sn . "','" . $nick_name . "','" .
                $openid . "')";
            $res = $GLOBALS['db']->query($in);


        }

    }
    //$res1=array();
    unset($res1);
   
    //开始第二部分
    
    if ($v6 == 0) {
        if ($v5 == 1) {
            $sql = "SELECT a.p_type,b.id,b.openid,b.users_sn,b.nick_name FROM tgpoint  a  inner join users b on a.openid=b.openid  group by b.openid";


            $res1 = $GLOBALS['db']->getAll($sql);
            //print_r($res1);

        } elseif ($v5 == 2) {
            $sql = "SELECT a.p_type,b.id,b.openid,b.users_sn,b.nick_name FROM tgpoint  a  inner join users b on a.openid=b.openid where a.p_type='1' group by b.openid";
            $res1 = $GLOBALS['db']->getAll($sql);

        } elseif ($v5 == 3) {
            $sql = "SELECT a.p_type,b.id,b.openid,b.users_sn,b.nick_name FROM tgpoint  a  inner join users b on a.openid=b.openid where a.p_type='2' group by b.openid";
            $res1 = $GLOBALS['db']->getAll($sql);
        } elseif ($v5 == 4) {
            $sql = "SELECT a.p_type,b.id,b.openid,b.users_sn,b.nick_name FROM tgpoint  a  inner join users b on a.openid=b.openid where a.p_type='3' group by b.openid";
            $res1 = $GLOBALS['db']->getAll($sql);
        } else {

        }
        
        for ($i = 0; $i < count($res1); $i++) {

            $sql = "select id,openid,users_sn,nick_name from users where id='" . $res1[$i]['id'] .
                "' ";
            $res = $GLOBALS['db']->getAll($sql);

            $users_id = $res[0]['id'];
            $openid = $res[0]['openid'];
            $users_sn = $res[0]['users_sn'];
            $nick_name = addslashes($res[0]['nick_name']);
            $in = "insert into wx_users_group(group_sn,users_id,users_sn,nick_name,openid) values ('" .
                $group_sn . "','" . $users_id . "','" . $users_sn . "','" . $nick_name . "','" .
                $openid . "')";
            $res = $GLOBALS['db']->query($in);


        }

    } elseif ($v6 == 1) {


        if ($v5 == 1) {
            $sql = "SELECT a.p_type,b.id,b.openid,b.users_sn,b.nick_name FROM tgpoint  a  inner join users b on a.openid=b.openid  group by b.openid";


            $res1 = $GLOBALS['db']->getAll($sql);
            //print_r($res1);

        } elseif ($v5 == 2) {
            $sql = "SELECT a.p_type,b.id,b.openid,b.users_sn,b.nick_name FROM tgpoint  a  inner join users b on a.openid=b.openid where a.p_type='1' group by b.openid";
            $res1 = $GLOBALS['db']->getAll($sql);
            for($i=0;$i<count($res1);$i++)
            {
                 
                    $d1 = "'";
                    $d2 = "',";
                    if($i==count($res1)-1)
                    {
                        $d2="'";
                    }
                    $sn .= $d1 . $res1[$i]['users_sn'] . $d2;
                
            }

            $list2 = "SELECT a.p_type,b.id,b.openid,b.users_sn,b.nick_name FROM tgpoint  a  inner join users b on a.openid=b.openid where a.p_type='2' and b.users_sn not in (".$sn.") group by b.openid";
            $list2 = $GLOBALS['db']->getAll($list2);
            for ($j = 0; $j < count($list2); $j++) {
                
                array_push($res1, $list2[$j]);
            }


        } elseif ($v5 == 3) {
            
            
            
            $sql = "SELECT a.p_type,b.id,b.openid,b.users_sn,b.nick_name FROM tgpoint  a  inner join users b on a.openid=b.openid where a.p_type='2' group by b.openid";
            $res1 = $GLOBALS['db']->getAll($sql);
            
            for($i=0;$i<count($res1);$i++)
            {
                 
                    $d1 = "'";
                    $d2 = "',";
                    if($i==count($res1)-1)
                    {
                        $d2="'";
                    }
                    $sn .= $d1 . $res1[$i]['users_sn'] . $d2;
                
            }
            
            
            $list3 = "SELECT a.p_type,b.id,b.openid,b.users_sn,b.nick_name FROM tgpoint  a  inner join users b on a.openid=b.openid where a.p_type='3' and b.users_sn not in (".$sn.") group by b.openid";
            $list3 = $GLOBALS['db']->getAll($list3);
            
            for ($j = 0; $j < count($list3); $j++) {
                
                array_push($res1, $list3[$j]);
            }
            
            
        } elseif ($v5 == 4) {
            $sql = "SELECT a.p_type,b.id,b.openid,b.users_sn,b.nick_name FROM tgpoint  a  inner join users b on a.openid=b.openid where a.p_type='3' group by b.openid";
            $res1 = $GLOBALS['db']->getAll($sql);
        } else {

        }
        
        
       
        for ($i = 0; $i < count($res1); $i++) {

            $sql = "select id,openid,users_sn,nick_name from users where id='" . $res1[$i]['id'] .
                "' ";
            $res = $GLOBALS['db']->getAll($sql);

            $users_id = $res[0]['id'];
            $openid = $res[0]['openid'];
            $users_sn = $res[0]['users_sn'];
            $nick_name = addslashes($res[0]['nick_name']);
            $in = "insert into wx_users_group(group_sn,users_id,users_sn,nick_name,openid) values ('" .
                $group_sn . "','" . $users_id . "','" . $users_sn . "','" . $nick_name . "','" .
                $openid . "')";
            $res = $GLOBALS['db']->query($in);


        }

    } elseif ($v6 == 2) {
        if ($v5 == 1) {
            $sql = "SELECT a.p_type,b.id,b.openid,b.users_sn,b.nick_name FROM tgpoint  a  inner join users b on a.openid=b.openid  group by b.openid";


            $res1 = $GLOBALS['db']->getAll($sql);
            //print_r($res1);

        } elseif ($v5 == 2) {
            $sql = "SELECT a.p_type,b.id,b.openid,b.users_sn,b.nick_name FROM tgpoint  a  inner join users b on a.openid=b.openid  group by b.openid";


            $res1 = $GLOBALS['db']->getAll($sql);
          
            
        } elseif ($v5 == 3) {
            
            
            $sql = "SELECT a.p_type,b.id,b.openid,b.users_sn,b.nick_name FROM tgpoint  a  inner join users b on a.openid=b.openid where a.p_type='2' group by b.openid";
            $res1 = $GLOBALS['db']->getAll($sql);
            
            for($i=0;$i<count($res1);$i++)
            {
                 
                    $d1 = "'";
                    $d2 = "',";
                    if($i==count($res1)-1)
                    {
                        $d2="'";
                    }
                    $sn .= $d1 . $res1[$i]['users_sn'] . $d2;
                
            }
            
            
            $list3 = "SELECT a.p_type,b.id,b.openid,b.users_sn,b.nick_name FROM tgpoint  a  inner join users b on a.openid=b.openid where a.p_type='3' and b.users_sn not in (".$sn.") group by b.openid";
            $list3 = $GLOBALS['db']->getAll($list3);
            
            for ($j = 0; $j < count($list3); $j++) {
                
                array_push($res1, $list3[$j]);
            }
            
            
        } elseif ($v5 == 4) {
            $sql = "SELECT a.p_type,b.id,b.openid,b.users_sn,b.nick_name FROM tgpoint  a  inner join users b on a.openid=b.openid where a.p_type='3' group by b.openid";
            $res1 = $GLOBALS['db']->getAll($sql);
        } else {

        }
        
       
        for ($i = 0; $i < count($res1); $i++) {

            $sql = "select id,openid,users_sn,nick_name from users where id='" . $res1[$i]['id'] .
                "' ";
            $res = $GLOBALS['db']->getAll($sql);

            $users_id = $res[0]['id'];
            $openid = $res[0]['openid'];
            $users_sn = $res[0]['users_sn'];
            $nick_name = addslashes($res[0]['nick_name']);
            $in = "insert into wx_users_group(group_sn,users_id,users_sn,nick_name,openid) values ('" .
                $group_sn . "','" . $users_id . "','" . $users_sn . "','" . $nick_name . "','" .
                $openid . "')";
            $res = $GLOBALS['db']->query($in);


        }
    }
    
    
    
    
    $v6='';
    $v5='';
  
    
    $v4='';
    $v3='';
    $v2='';
    $v1='';
      $res1=array();
}
