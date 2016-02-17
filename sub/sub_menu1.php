<?php

function menu1_list()
{
    $sql = "select id,p_id,menu_sn,menu_type,type,name,p_name,m_key,sort_no,type,action_url,add_time,re_type,re_code from menu_list where menu_type=1  order by -sort_no";
    $list = $GLOBALS['db']->getAll($sql);

    for ($i = 0; $i < count($list); $i++) {
        $sub = "select p_id,menu_sn,menu_type,type,name,p_name,m_key,sort_no,add_time,type,action_url,re_type,re_code from menu_list where menu_type=2 and p_id='" .
            $list[$i]['menu_sn'] . "' order by -sort_no;";

        $list[$i]['sub_button'] = $GLOBALS['db']->getAll($sub);
        $list[$i]['bt_count'] = count($list[$i]['sub_button']);
    }
    //print_r($list);
    return $list;
}


function update_menu1()
{
    if (isset($_REQUEST['sort_no'])) {
        $sort_no = $_REQUEST['sort_no'];

    }
    if (isset($_REQUEST['menu_sn'])) {
        $menu_sn = $_REQUEST['menu_sn'];

    }
    if (isset($_REQUEST['name'])) {
        $name = $_REQUEST['name'];

    }
    if (isset($_REQUEST['m_key'])) {
        $m_key = $_REQUEST['m_key'];

    }
    if (isset($_REQUEST['type'])) {
        $type = $_REQUEST['type'];


    }
    if (isset($_REQUEST['type2'])) {
        $type2 = $_REQUEST['type2'];

    }
   
    for ($i = 0; $i < count($menu_sn); $i++) {

        $menu_sn_u = " update menu_list set sort_no ='" . $sort_no[$i] . "', name ='" .
            $name[$i] . "', m_key ='" . $m_key[$i] . "', re_type ='" . $type[$i] .
            "',re_code='" . $type2[$i] . "',type='" . $tp[$i] . "' where menu_sn='" . $menu_sn[$i] .
            "';";

        //print_r($menu_sn_u);
        //echo "<br>";

        $res = $GLOBALS['db']->query($menu_sn_u);
    }
    $menu1 = "update menu_list set type='view',action_url=(select url from actionurl where actionurl_sn=re_code) where re_type='url' ;";
    
    //print_r($menu_sn_u);
    //echo "<br>";

    $res = $GLOBALS['db']->query($menu1);
    $menu2 = "update menu_list set type='click' where re_type='imgtext' or re_type='text' or re_type='';";

    //print_r($menu_sn_u);
    //echo "<br>";

    $res = $GLOBALS['db']->query($menu2);
    
    $menu3 = "update menu_list set type=re_type where re_type='scancode_push' or re_type='scancode_waitmsg' or re_type='pic_sysphoto' or re_type='pic_photo_or_album' or re_type='pic_weixin' or re_type='location_select' ;";
    
    //print_r($menu_sn_u);
    //echo "<br>";

    $res = $GLOBALS['db']->query($menu3);
    
    
    $url_this = "http://".$_SERVER ['HTTP_HOST']."".dirname($_SERVER['PHP_SELF'])."/html_";
     //$url=$url_this."/html_".$res[$i]['article_sn'].".html";
    
    
    $menu3 = "update menu_list set type='view',action_url=concat('".$url_this."',re_code,'.html') where re_type='html' ;";
    
    //print_r($menu_sn_u);
    //echo "<br>";

    $res = $GLOBALS['db']->query($menu3);


}

?>