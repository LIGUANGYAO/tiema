<?php
//----权限控制
function grl()
{
    $url = $_SERVER['PHP_SELF'];
    $arr = explode('/', $url);
    $filename = $arr[count($arr) - 1];

    $us = getlogin_name();
    $u_info = "select user_code,user_name,user_name2 from admin_user where user_name ='" .
        $us . "'";
    $u_info = $GLOBALS['db']->getRow($u_info);
    //echo $filename;
    $sql = "SELECT a.action_id FROM action a  inner join role_act b on a.action_id=b.act_id inner join role_user c on  c.p_id=b.p_id where a.is_show=1  and  a.type='c3' and b.val=1 and a.action_code='" .
        $filename . "' and c.user_sn='" . $u_info['user_code'] .
        "'  group by b.val ,b.act_id,c.user_name  order by -a.sort_order,-b.act_id desc;";
    $res = $GLOBALS['db']->getAll($sql);

    return $res;


}
$err = grl();
if (empty($err)) {
    $smarty->assign('role', '无访问权限');
    $smarty->assign('url', $filename);
    $smarty->display('err.tpl');
    exit;
}

//------------------

?>