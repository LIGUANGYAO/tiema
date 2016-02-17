<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_role.php');
require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
    ///修改1,查询语句
    $sql = "select id,role_sn,role_name,sort_no,tzsy from role";

    $role_list = get_role_list($Num, "role", $sql);
    
    for($i=0;$i<count($role_list['items']);$i++)
    {
        $sql="select * from role_user where p_id='".$role_list['items'][$i]['role_sn']."' order by user_sn";
        $res = $GLOBALS['db']->getAll($sql);
        $role_list['items'][$i]['u_list']=$res;
    }
    //print_r($role_list);
    $smarty->assign('role_list', $role_list['items']);
    
    

    $smarty->assign('title', $aaa);
    $smarty->assign('fall', 1);
    $smarty->assign('p_Array', $role_list['page']);
    $smarty->display('role.tpl');


}

if ($_REQUEST['act'] == 'add_role_list') {

    $sql = "select xmlx_sn ,xmlx_name from xmlx";
    $res_xmlx = $GLOBALS['db']->getAll($sql);
    $smarty->assign('res_xmlx', $res_xmlx);
    $smarty->assign('fall', 'add_role_list');
    $smarty->display('role_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];

    ///修改2,查询语句
    $sql = "select  id,role_sn,role_name,sort_no
  from role ";
    $role_mx = get_role_mx("role", $sql);


    function get_users_group_mx($obj)
    {
        $sql = "select u_id as users_id,
            user_sn as users_sn,
           user_name as nick_name
            from role_user where p_id='" . $obj . "' ";
        $res = $GLOBALS['db']->getAll($sql);
        //$noNum=20;
        return array('items' => $res);
    }
    $users_list = get_users_group_mx($_REQUEST['role_sn']);
    $smarty->assign('users_list', $users_list['items']);


    $smarty->assign('role_mx', $role_mx['items'][0]);
    $smarty->assign('res_xmlx', $role_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('role_mx.tpl');
}

if ($_REQUEST['act'] == 'i_u') {

    if (isset($_REQUEST['role_sn'])) {
        $role_sn = trim($_REQUEST['role_sn']);
    }
    if (isset($_REQUEST['st'])) {
        $st = explode(",", $_REQUEST['st']);
        // print_r($st);
    }
    $select2 = array();
    for ($j = 0; $j < count($st) - 1; $j++) {
        array_push($select2, $st[$j]);
    }


    $de = "delete from  role_user where p_id='" . $_REQUEST['role_sn'] . "'";
    $de = $GLOBALS['db']->query($de);
    for ($i = 0; $i < count($select2); $i++) {
        $get_u_info = "select user_id,user_code,user_name from admin_user where user_id='" .
            $select2[$i] . "'";
        $get_u_info = $GLOBALS['db']->getRow($get_u_info);

        $get = "select u_id from role_user where p_id='" . $role_sn . "'  and u_id='" .
            $select2[$i] . "'";
        $get = $GLOBALS['db']->getRow($get);
        if (empty($get)) {
            $insert = "insert into role_user(p_id,u_id,user_sn,user_name)  values ('" . $_REQUEST['role_sn'] .
                "','" . $get_u_info['user_id'] . "','" . $get_u_info['user_code'] . "','" . $get_u_info['user_name'] .
                "')";
            $insert = $GLOBALS['db']->query($insert);
        }

    }

}
if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if (isset($_REQUEST['img_code'])) {
        $img_code = trim($_REQUEST['img_code']);

        $sql = "delete from role_imgs where  img_outer_id= '" . $img_code . "'";
        $res = $GLOBALS['db']->query($sql);
        //echo "删除成功";
    } else {
        //echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}

if ($_REQUEST['act'] == 'delete_role') {

    //echo 1;
    if (isset($_REQUEST['role_sn'])) {
        $role_sn = trim($_REQUEST['role_sn']);

        $sql = "delete from role where  role_sn= '" . $role_sn . "'";
        $res = $GLOBALS['db']->query($sql);
        
        
        $sql="delete from role_user where  p_id= '".$role_sn."'";     
        $res = $GLOBALS['db']->query($sql);
        
        
         $sql="delete from role_act where  p_id= '".$role_sn."'";     
        $res = $GLOBALS['db']->query($sql);
        //echo "删除成功";
    } else {
        //echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}
if ($_REQUEST['act'] == 'img_xs') {

    //echo 1;
    if (isset($_REQUEST['img_code']) && isset($_REQUEST['alt'])) {
        $img_code = trim($_REQUEST['img_code']);
        $alt = trim($_REQUEST['alt']);

        $sql = "update  role_imgs set ss=" . $alt . "  where  img_outer_id= '" . $img_code .
            "'";
        $res = $GLOBALS['db']->query($sql);
        //echo "修改成功";
    } else {
        //echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}
if ($_REQUEST['act'] == 'role_xs') {

    //echo 1;

    if (isset($_REQUEST['role_code']) && isset($_REQUEST['alt'])) {
        $role_code = trim($_REQUEST['role_code']);
        $alt = trim($_REQUEST['alt']);

        $sql = "update  role set tzsy=" . $alt . "  where  role_sn= '" . $role_code .
            "'";
        //echo $sql;
        $res = $GLOBALS['db']->query($sql);
        //echo "修改成功";
    } else {
        //echo "失败";
    }

    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}


if ($_REQUEST['act'] == 'post') {


    update_role_mx("role", "role_sn,role_name,sort_no", "role_sn");

    $smarty->assign('fall', 'post');
    $smarty->display('role_mx.tpl');
}


if ($_REQUEST['act'] == 'post_add') {
    if (isset($_REQUEST['role_sn'])) {
        $role_sn = trim($_REQUEST['role_sn']);
    }
    //print_r($p_id);
    if($role_sn=='')
    {
        $smarty->assign('fall', 'fs');
        $smarty->display('role_mx.tpl');
    }
    //res_xmlx

    $get_one = " select role_sn from role where role_sn ='" . $role_sn . "'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($res);exit;
    if (empty($res)) {

        //修改4，增加语句
        //保存修改后商品明细
        insert_role_mx("role", "role_sn,role_name,sort_no");

        $smarty->assign('fall', 'post');
        $smarty->display('role_mx.tpl');
    } else {
        $smarty->assign('fall', 'fs');
        $smarty->display('role_mx.tpl');
    }


}


//20140825添加搜索用户
if ($_REQUEST['act'] == 'ysss') {

    require (dirname(__file__) . '/sub/rest.php');
    if (isset($_REQUEST['role_sn'])) {
        $role_sn = $_REQUEST['role_sn'];
    }

    if (isset($_REQUEST['keyword'])) {
        $keyword = $_REQUEST['keyword'];

        if ($keyword == "") {
            //   $sql = "select id,openid,users_sn,nick_name from users where lylx=1 and id not in (select users_id from wx_users_group where group_sn='" .
            //                $group_sn . "') ";
            $sql = "select user_id as id,user_code as users_sn,user_name as nick_name from admin_user where user_name !='admin'";

            $res = $GLOBALS['db']->getAll($sql);
        } else {
            $where = "and  user_code like '%" . $keyword . "%' or user_name like '%" . $keyword .
                "%'";
            $sql = "select user_id as id,user_code as users_sn,user_name as nick_name from admin_user where user_name !='admin'" .
                $where;
            $res = $GLOBALS['db']->getAll($sql);
        }


    }


    $aaa = new arraytojson();
    $json = $aaa->JSON($res);
    print_r($json);
}


//设置权限

if ($_REQUEST['act'] == 'set_role') {

    
    $role_sn=urldecode($_REQUEST['role_sn']);
    
    
    function i_role_act($obj)
    {
        $sql="select count(p_id) as sl from role_act where p_id='".$obj."'";
        $res = $GLOBALS['db']->getRow($sql);
        //插入记录
        if($res['sl']<=0)
        {
            $in="insert into role_act(p_id,act_id,val) select '".$obj."',action_id,0 from action where is_show=1";
            $in = $GLOBALS['db']->query($in);
        }
        else
        {
            $in="insert into role_act(p_id,act_id,val) select '".$obj."',action_id,0 from action where is_show=1  and action_id not in (select act_id from role_act  where p_id='".$obj."')";
            $in = $GLOBALS['db']->query($in);
            $de="delete from role_act where act_id not in (select action_id from action where is_show=1) ";
            $de = $GLOBALS['db']->query($de);
        }
    }
    
    
    i_role_act($role_sn);
    
    
    
    function role_list($obj)
    {
        $sql="select a.parent_id,a.action_name,a.priv_type as sort_no,b.act_id,b.val from action a inner join role_act b on a.action_id=b.act_id  where b.p_id='".$obj."'  and a.is_show=1 and priv_type!=0 order by a.priv_type,a.action_id,a.sort_order";
        $res = $GLOBALS['db']->getAll($sql);
        return $res;
    }
    $list=role_list($role_sn);
    //echo $role_sn;
    //print_r($list);
    
    $smarty->assign('role_sn', $role_sn);
    $smarty->assign('list', $list);
    $smarty->assign('fall', 2);
    $smarty->display('role.tpl');
}
if ($_REQUEST['act'] == 'role_post') {
    
    $role_sn=$_REQUEST['role_sn'];
    $listval= $_REQUEST['listval'];
    $act_id= $_REQUEST['act_id'];
   // print_r($listval);
//     print_r($act_id)
//    ;die;
    
    for($i=0;$i<count($act_id);$i++)
    {
        $sql="update role_act set val='".$listval[$i]."' where p_id='".$role_sn."' and act_id='".$act_id[$i]."'";
        $res = $GLOBALS['db']->query($sql);
        //print_r($sql);
    }
    header("location: role.php");
        //print_r($_REQUEST['listval']);
//     print_r($_REQUEST['act_id']);
}

?>