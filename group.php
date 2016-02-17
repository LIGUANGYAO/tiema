<?php

define('IN_ECS', true);

require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/sub_group.php');
require (dirname(__file__) . '/sub/page.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'default') {
    $list = group($Num, "wx_group");
    $smarty->assign('group_list', $list['item']);
    $smarty->assign('p_Array', $list['page']);
    $smarty->assign('fall', 'group');
    $smarty->display('group.tpl');
}


if ($_REQUEST['act'] == 'a_group') {
    $smarty->assign('fall', 'a_group');
    $smarty->display('group.tpl');
}


if ($_REQUEST['act'] == 'ysss') {

    require (dirname(__file__) . '/sub/rest.php');
    if (isset($_REQUEST['group_sn'])) {
        $group_sn = $_REQUEST['group_sn'];
    }
    $sl = $_REQUEST['i'];
    function limit_array1($page_no, $num)
    {
        if (isset($page_no) && isset($num)) {

            $limit = " limit " . $page_no . "," . $num;
            return $limit;
        } else {
            return false;
        }

    }
    $limit = limit_array1($sl * 500, 500);
    if (isset($_REQUEST['keyword'])) {
        $keyword = urldecode($_REQUEST['keyword']);

        if ($keyword == "all") {
            //   $sql = "select id,openid,users_sn,nick_name from users where lylx=1 and id not in (select users_id from wx_users_group where group_sn='" .
            //                $group_sn . "') ";
            $sql = "select id,openid,users_sn,nick_name from users where lylx=1 " . $limit;

            $res = $GLOBALS['db']->getAll($sql);
        } else {
            $where = "where users_sn like '%" . $keyword . "%' or nick_name like '%" . $keyword .
                "%'";
            $sql = "select id,openid,users_sn,nick_name from users " . $where . $limit;
            $res = $GLOBALS['db']->getAll($sql);
        }


    }


    $aaa = new arraytojson();
    $json = $aaa->JSON($res);
    print_r($json);
}

if ($_REQUEST['act'] == 'ysss_sum') {

    require (dirname(__file__) . '/sub/rest.php');
    if (isset($_REQUEST['group_sn'])) {
        $group_sn = $_REQUEST['group_sn'];
    }
    if (isset($_REQUEST['keyword'])) {
        $keyword = urldecode($_REQUEST['keyword']);

        if ($keyword == "all") {
            //   $sql = "select id,openid,users_sn,nick_name from users where lylx=1 and id not in (select users_id from wx_users_group where group_sn='" .
            //                $group_sn . "') ";
            $sql = "select count(id) as sum from users where lylx=1 ";
            $res = $GLOBALS['db']->getAll($sql);
        } else {
            $where = "where users_sn like '%" . $keyword . "%' or nick_name like '%" . $keyword .
                "%'";
            $sql = "select count(id) as sum from users " . $where;
            $res = $GLOBALS['db']->getAll($sql);
        }


    }

    echo ceil($res[0]['sum'] / 500);


}


if ($_REQUEST['act'] == 'ysss2') {
    require (dirname(__file__) . '/sub/rest.php');
    $v1 = trim($_REQUEST['v1']);
    $v2 = trim($_REQUEST['v2']);
    $v3 = trim($_REQUEST['v3']);
    $v4 = trim($_REQUEST['v4']);

    if (!empty($v1) && !empty($v2) && !empty($v3)) {

        $sql = "SELECT b.id,b.openid,b.users_sn,b.nick_name FROM cj_qrcode_stat  a  inner join users b on a.openid=b.openid  where a.cj_sn='" .
            $v3 . "'";


        $res = $GLOBALS['db']->getAll($sql);
        $aaa = new arraytojson();
        $json = $aaa->JSON($res);
        print_r($json);
    } elseif (!empty($v1) && !empty($v2)) {
        $sql = "SELECT b.id,b.openid,b.users_sn,b.nick_name FROM cj_qrcode_stat  a  inner join users b on a.openid=b.openid  where a.cj_sn='" .
            $v2 . "'";
        $res = $GLOBALS['db']->getAll($sql);
        $aaa = new arraytojson();
        $json = $aaa->JSON($res);
        print_r($json);
    } elseif (!empty($v1)) {
        if ($v4 == 0) {
            $sql = "SELECT b.id,b.openid,b.users_sn,b.nick_name FROM cj_qrcode_stat  a  inner join users b on a.openid=b.openid  where a.cj_sn='" .
                $v1 . "'";
            $res = $GLOBALS['db']->getAll($sql);
        } elseif ($v4 == 1) {
            $shop_mx = "select * from shop where p_id='" . $v1 . "' ";
            $shop_mx = $GLOBALS['db']->getAll($shop_mx);
            for ($j = 0; $j < count($shop_mx); $j++) {
                $d1 = "'";
                $d2 = "',";
                if ($j == count($shop_mx) - 1) {
                    $d2 = "'";
                }
                $sn .= $d1 . $shop_mx[$j]['shop_sn'] . $d2;
            }
            //echo $sn;exit;
            $sql = "SELECT b.id,b.openid,b.users_sn,b.nick_name FROM cj_qrcode_stat  a  inner join users b on a.openid=b.openid  where a.cj_sn in ('" .
                $v1 . "'," . $sn . ") ";
            $res = $GLOBALS['db']->getAll($sql);
        } elseif ($v4 == 2) {

        }


        $aaa = new arraytojson();
        $json = $aaa->JSON($res);
        print_r($json);
    }
}


if ($_REQUEST['act'] == 'e_group') {


    if (isset($_REQUEST['edit'])) {


        $code =urldecode(trim($_REQUEST['edit'])) ;
        
        $list = get_group_mx($code);
        $smarty->assign('group', $list['items'][0]);

        $users_list = get_users_group_mx($code);
        $smarty->assign('users_list', $users_list['items']);
        //print_r( $list);


        function get_qudaolist($qudao = '', $shop = '', $sales = '')
        {


            $sql1 = "select qudao_sn,qudao_name,qudao_type,p_id from qudao where tzsy=0;";
            $item['qudao'] = $GLOBALS['db']->getAll($sql1);
            $sql2 = "select *
     from shop where  tzsy=0 and  p_id='" . $qudao . "';";
            $item['shop'] = $GLOBALS['db']->getAll($sql2);
            $sql3 = "select *
     from sales where tzsy=0 and p_id='" . $shop . "';";
            $item['sales'] = $GLOBALS['db']->getAll($sql3);

            //return $sql2;exit;
            return $item;


        }

        $qdlist = get_qudaolist('002', 'A002');

        //print_r($qudao);
        $smarty->assign('qudao', $qdlist);


        $smarty->assign('fall', 'e_group');
        $smarty->display('group.tpl');
    }
}

if ($_REQUEST['act'] == 'post') {

   //修改3，更新语句
    $time_field = array(array(
            "type" => "1",
            "field" => "last_update_2",
            "method" => "2"));
    update_group_mx("wx_group", "group_name,group_type_sn,group_note,tzsy",
        "group_sn", $time_field);
        
        
   
    
    $smarty->assign('fall', 'i_staus');
    $smarty->assign('val', '修改成功');
    $smarty->display('group.tpl');
}

if ($_REQUEST['act'] == 'post2') {


    $v1 = $_REQUEST['v1'];
    $v2 = $_REQUEST['v2'];
    $v3 = $_REQUEST['v3'];
    $v4 = $_REQUEST['v4'];
    if (isset($_REQUEST['group_sn'])) {
        $group_sn = trim($_REQUEST['group_sn']);
    }
    $sqlaaa = "delete from wx_users_group where group_sn='" . $group_sn . "'";
    $resultaaa = $GLOBALS['db']->query($sqlaaa);

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
    
    
    $up="update wx_group set v1='".$v1."',v2='".$v2."',v3='".$v3."',v4='".$v4."',v5='',v6='' where group_sn='".$group_sn."'";
    $up = $GLOBALS['db']->query($up);
    header("location:group.php?act=e_group&edit=" . $group_sn);
    //group.php?act=e_group&edit=001
}


if ($_REQUEST['act'] == 'post3') {


    $v1 = $_REQUEST['v1'];
    $v2 = $_REQUEST['v2'];

    if (isset($_REQUEST['group_sn'])) {
        $group_sn = trim($_REQUEST['group_sn']);

        $sqlaaa = "delete from wx_users_group where group_sn='" . $group_sn . "'";
        $resultaaa = $GLOBALS['db']->query($sqlaaa);

    }

    if ($v2 == 0) {
        if ($v1 == 1) {
            $sql = "SELECT a.p_type,b.id,b.openid,b.users_sn,b.nick_name FROM tgpoint  a  inner join users b on a.openid=b.openid  group by b.openid";


            $res1 = $GLOBALS['db']->getAll($sql);
            //print_r($res1);

        } elseif ($v1 == 2) {
            $sql = "SELECT a.p_type,b.id,b.openid,b.users_sn,b.nick_name FROM tgpoint  a  inner join users b on a.openid=b.openid where a.p_type='1' group by b.openid";
            $res1 = $GLOBALS['db']->getAll($sql);

        } elseif ($v1 == 3) {
            $sql = "SELECT a.p_type,b.id,b.openid,b.users_sn,b.nick_name FROM tgpoint  a  inner join users b on a.openid=b.openid where a.p_type='2' group by b.openid";
            $res1 = $GLOBALS['db']->getAll($sql);
        } elseif ($v1 == 4) {
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

    } elseif ($v2 == 1) {


        if ($v1 == 1) {
            $sql = "SELECT a.p_type,b.id,b.openid,b.users_sn,b.nick_name FROM tgpoint  a  inner join users b on a.openid=b.openid  group by b.openid";


            $res1 = $GLOBALS['db']->getAll($sql);
            //print_r($res1);

        } elseif ($v1 == 2) {
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


        } elseif ($v1 == 3) {
            
            
            
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
            
            
        } elseif ($v1 == 4) {
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

    } elseif ($v2 == 2) {
        if ($v1 == 1) {
            $sql = "SELECT a.p_type,b.id,b.openid,b.users_sn,b.nick_name FROM tgpoint  a  inner join users b on a.openid=b.openid  group by b.openid";


            $res1 = $GLOBALS['db']->getAll($sql);
            //print_r($res1);

        } elseif ($v1 == 2) {
            $sql = "SELECT a.p_type,b.id,b.openid,b.users_sn,b.nick_name FROM tgpoint  a  inner join users b on a.openid=b.openid  group by b.openid";


            $res1 = $GLOBALS['db']->getAll($sql);
          
            
        } elseif ($v1 == 3) {
            
            
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
            
            
        } elseif ($v1 == 4) {
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
    
    
    $v1 = $_REQUEST['v1'];
    $v2 = $_REQUEST['v2'];
    $up="update wx_group set v5='".$v1."',v6='".$v2."',v1='',v2='',v3='',v4='' where group_sn='".$group_sn."'";
    $up = $GLOBALS['db']->query($up);
    //header("location:group.php");
    header("location:group.php?act=e_group&edit=" . $group_sn);
}


if ($_REQUEST['act'] == 'i_users_list') {

    if (isset($_REQUEST['group_sn'])) {
        $group_sn = trim($_REQUEST['group_sn']);
    }
    if (isset($_REQUEST['st'])) {
        $st = explode(",", $_REQUEST['st']);
        // print_r($st);
    }
    //print_r(count($st));
    $sqlaaa = "delete from wx_users_group where group_sn='" . $group_sn . "'";
    $resultaaa = $GLOBALS['db']->query($sqlaaa);


    for ($i = 0; $i < count($st) - 1; $i++) {
        if (!empty($st)) {
            $sql = "select id,openid,users_sn,nick_name from users where id='" . $st[$i] .
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
    
     $up="update wx_group set v1='',v2='',v3='',v4='',v5='',v6='' where group_sn='".$group_sn."'";
    $up = $GLOBALS['db']->query($up);

    //print_r($group_sn);
    // if(isset($_REQUEST['edit']))
    //    {
    //        $code = urldecode(trim($_REQUEST['edit']));
    //        $list=get_group_mx($code);
    //        $smarty->assign('group', $list['items'][0]);
    //        $smarty->assign('fall', 'e_group');
    //  $smarty->display('group.tpl');
}


if ($_REQUEST['act'] == 'i_group') {

    if (isset($_REQUEST['group_sn'])) {
        $group_sn = trim($_REQUEST['group_sn']);
    }
    if (isset($_REQUEST['group_name'])) {
        $group_name = trim($_REQUEST['group_name']);
    }
    if (isset($_REQUEST['group_type_sn'])) {
        $group_type_sn = trim($_REQUEST['group_type_sn']);
    }
    if (isset($_REQUEST['group_note'])) {
        $group_note = trim($_REQUEST['group_note']);
    }

    //   if(isset($_REQUEST['st']))
    //    {
    //        $st = explode(",", $_REQUEST['st']);
    //        print_r($st);
    //    }
    //

    $time = date('Y-m-d H:i:s', time());
    $last_update_2 = date('Y-m-d', time());
    $get_one = " select group_sn from wx_group where group_sn='" . $group_sn . "'";
    $res = $GLOBALS['db']->getRow($get_one);
    if (empty($res)) {
        $time_field = array(array(
                "type" => "2",
                "field" => "add_time",
                "method" => "1"), );
        i_group("wx_group", "group_sn,group_name,group_type_sn,group_note,tzsy", $time_field);
        $smarty->assign('fall', 'e_group');
        $list = get_group_mx($group_sn);
        $smarty->assign('group', $list['items'][0]);


        $smarty->display('group.tpl');
    } else {
        $smarty->assign('fall', 'i_staus');
        $smarty->assign('val', '代码已经存在,请重新输入');
        $smarty->display('group.tpl');
    }
}


//禁用启用删除等操作

if ($_REQUEST['act'] == 'ed_status') {

    if (isset($_REQUEST['qiyong'])) {
        $code = urldecode(trim($_REQUEST['qiyong']));

        $sql = "update wx_group set tzsy=0 where  group_sn= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "启用成功";
    } else {

    }

    if (isset($_REQUEST['jinyong'])) {
        $code = urldecode(trim($_REQUEST['jinyong']));
        $sql = "update wx_group set tzsy=1 where  group_sn= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "禁用成功";
    } else {

    }

    if (isset($_REQUEST['delete'])) {
        $code = urldecode(trim($_REQUEST['delete']));
        $sql = "delete from  wx_group where  group_sn= '" . $code . "'";
        $res = $GLOBALS['db']->query($sql);
        $sql1 = "delete from  wx_users_group where  group_sn= '" . $code . "'";
        $res1 = $GLOBALS['db']->query($sql1);
        echo "删除成功";
    } else {

    }
}


if ($_REQUEST['act'] == 'get_city') {

    //echo 1;exit;
    //if(isset($_REQUEST['province'])){
    require (dirname(__file__) . '/sub/rest.php');
    $province = urldecode($_REQUEST['province']);

    $sql2 = "select shop_sn  as region_sn,shop_name as region_name 
     from shop where p_id='" . $province . "';";
    $city = $GLOBALS['db']->getAll($sql2);


    $aaa = new arraytojson();
    $json = $aaa->JSON($city);

    print_r($json);
}

if ($_REQUEST['act'] == 'get_district') {

    //echo 1;exit;
    //if(isset($_REQUEST['province'])){
    require (dirname(__file__) . '/sub/rest.php');
    $city = urldecode($_REQUEST['city']);

    $sql3 = "select sales_sn as region_sn,sales_name as region_name 
     from sales where  p_id='" . $city . "';";
    $district = $GLOBALS['db']->getAll($sql3);

    $aaa = new arraytojson();
    $json = $aaa->JSON($district);

    print_r($json);
}
?>
