<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');


require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['g'])) {
    $_REQUEST['g'] = 'default';
} else {
    $_REQUEST['g'] = trim($_REQUEST['g']);
}


//�趨����������
$g_add=substr(md5("a_kehu"),0,17); //��Ӳ���
$g_e=substr(md5("e_kehu"),0,17); //�༭
$g_post=substr(md5("post_kehu"),0,17); //�޸ı���
$g_d=substr(md5("d_kehu"),0,17); //ɾ��
$g_in=substr(md5("in_kehu"),0,17); //����
$g_xs=substr(md5("xs_kehu"),0,17); //��ʾ

//g= defaultĬ�� e�༭dɾ�� p�����޸� i�������
if ($_REQUEST['g'] == 'default') {

    
   
    $smarty->assign('fall', '1');
//    //$smarty->assign('title', $aaa);
//    $smarty->assign('p_Array', $list['page']);
    $smarty->display('w/jslist.html');


}





?>