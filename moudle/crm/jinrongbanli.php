<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/f/sub_jinrongbanli.php');

require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['g'])) {
    $_REQUEST['g'] = 'default';
} else {
    $_REQUEST['g'] = trim($_REQUEST['g']);
}


//�趨����������
$g_add=substr(md5("a_jinrongbanli"),0,17); //��Ӳ���
$g_e=substr(md5("e_jinrongbanli"),0,17); //�༭
$g_post=substr(md5("post_jinrongbanli"),0,17); //�޸ı���
$g_d=substr(md5("d_jinrongbanli"),0,17); //ɾ��
$g_in=substr(md5("in_jinrongbanli"),0,17); //����
$g_xs=substr(md5("xs_jinrongbanli"),0,17); //��ʾ

//g= defaultĬ�� e�༭dɾ�� p�����޸� i�������
if ($_REQUEST['g'] == 'default') {


    ///�޸�1,��ѯ���
    //sort_no,tzsy Ҫ�ǵ����
    
    
    $sql = "select jinrongbanli_sn,jinrongbanli_name,kehu_id,banli_time,jinrong_id  from jinrongbanli";


    $list = get_jinrongbanli_list($Num, "jinrongbanli", $sql);

    //��������
 
 
 
    $banli_time_1= trim($_REQUEST['banli_time_1']);    
    $smarty->assign('banli_time_1',$banli_time_1);
    $banli_time_2= trim($_REQUEST['banli_time_2']);    
    $smarty->assign('banli_time_2',$banli_time_2);
 
 
 
    function kehu_id_select($obj){
        $sql="select id,kehu_sn as sn,kehu_name as name from kehu where tzsy=0 and 1=1 and id='".$obj."'";
    
        $res = $GLOBALS['db']->getRow($sql);
        //print_r($sql);exit;
        return $res;
    }   
    for($j=0;$j<count($list['items']);$j++)
    {
        $kehu_id_select =kehu_id_select($list['items'][$j]['kehu_id']);
        $list['items'][$j]['kehu_id_bm']=$kehu_id_select['name'];
    }
    function jinrong_id_select($obj){
        $sql="select id,jinrong_sn as sn,jinrong_name as name from jinrong where tzsy=0 and 1=1 and id='".$obj."'";
    
        $res = $GLOBALS['db']->getRow($sql);
        //print_r($sql);exit;
        return $res;
    }   
    for($j=0;$j<count($list['items']);$j++)
    {
        $jinrong_id_select =jinrong_id_select($list['items'][$j]['jinrong_id']);
        $list['items'][$j]['jinrong_id_bm']=$jinrong_id_select['name'];
    }


    if(1==1)
    {
                //�Ƿ񿪷�keyword��ס����ֵ
        $m_key= trim($_REQUEST['m_key']);
        $smarty->assign('m_key',$m_key);
    }
    
    

    
    
    $smarty->assign('jinrongbanli_list', $list['items']);
    $smarty->assign('fall', 1);
    //$smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $list['page']);
    $smarty->display('f/jinrongbanli.html');


}


if ($_REQUEST['g'] == $g_add) {
 
 
    function kehu_id_select(){
        $sql='select id,kehu_sn as sn,kehu_name as name from kehu where tzsy=0';
        $res = $GLOBALS['db']->getAll($sql);
        return $res;
    }
 
    $kehu_id_select=kehu_id_select();
    $smarty->assign('kehu_id_select', $kehu_id_select);
 
 
    function jinrong_id_select(){
        $sql='select id,jinrong_sn as sn,jinrong_name as name from jinrong where tzsy=0';
        $res = $GLOBALS['db']->getAll($sql);
        return $res;
    }
 
    $jinrong_id_select=jinrong_id_select();
    $smarty->assign('jinrong_id_select', $jinrong_id_select);
 
 
        
    
    $smarty->assign('fall', 'add_list');
    $smarty->display('f/jinrongbanli_mx.html');
}

//�ж��Ƿ��б༭����
//�б༭����
if ($_REQUEST['g'] == $g_e) {
    //$aaa=$_GET['goods_sn'];
    ///�޸�2,��ѯ���
    
 
    $fi.="jinrongbanli_sn,";
    //���ֶ�
    $bianset='jinrongbanli_sn';
 
    $fi.="jinrongbanli_name,";
    function kehu_id_select(){
        $sql='select id,kehu_sn as sn,kehu_name as name from kehu where tzsy=0';
        $res = $GLOBALS['db']->getAll($sql);
        return $res;
    }
 
    $kehu_id_select=kehu_id_select();
    $smarty->assign('kehu_id_select', $kehu_id_select);
 
    $fi.="kehu_id,";
 
    $fi.="banli_time,";
    function jinrong_id_select(){
        $sql='select id,jinrong_sn as sn,jinrong_name as name from jinrong where tzsy=0';
        $res = $GLOBALS['db']->getAll($sql);
        return $res;
    }
 
    $jinrong_id_select=jinrong_id_select();
    $smarty->assign('jinrong_id_select', $jinrong_id_select);
 
    $fi.="jinrong_id";
    $sql = "select $fi  from jinrongbanli ";
    $jinrongbanli_mx = get_jinrongbanli_mx($bianset, $sql);

   
    $smarty->assign('jinrongbanli_mx', $jinrongbanli_mx['items'][0]);
    
    //print_r($jinrongbanli_mx);
    // $smarty->assign('res_xmlx', $color_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('f/jinrongbanli_mx.html');
}

if ($_REQUEST['g'] == 'd') {

    //echo 1;
    if (isset($_REQUEST['img_code'])) {
        $img_code = trim($_REQUEST['img_code']);

        $sql = "delete from color_imgs where  img_outer_id= '" . $img_code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "ɾ���ɹ�";
    } else {
        echo "ʧ��";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}

//�ж��Ƿ���ɾ������
//��ɾ������
if ($_REQUEST['g'] == $g_d) {

    //���ֶ�
    $bianset='jinrongbanli_sn';
    //echo 1;
    $arr=array();
    if (isset($_REQUEST[$bianset]) && empty($arr)) {
        $jinrongbanli_sn = trim(urldecode($_REQUEST[$bianset]));

        $sql = "delete from jinrongbanli where  $bianset= '" . $jinrongbanli_sn . "'";
        $res = $GLOBALS['db']->query($sql);
        
        echo "1";
    } else {
        echo "2";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}

if ($_REQUEST['g'] == 'img_xs') {

    //echo 1;
    if (isset($_REQUEST['img_code']) && isset($_REQUEST['alt'])) {
        $img_code = trim($_REQUEST['img_code']);
        $alt = trim($_REQUEST['alt']);

        $sql = "update  color_imgs set ss=" . $alt . "  where  img_outer_id= '" . $img_code .
            "'";
        $res = $GLOBALS['db']->query($sql);
        echo "�޸ĳɹ�";
    } else {
        echo "ʧ��";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}



//�ж��Ƿ������ô���
//�����ô���
if ($_REQUEST['g'] == $g_xs) {

    //���ֶ�
    $bianset='jinrongbanli_sn';

    if (isset($_REQUEST[$bianset]) && isset($_REQUEST['alt'])) {
        $code = urldecode(trim($_REQUEST[$bianset]));
        $alt = urldecode(trim($_REQUEST['alt']));

        $sql = "update  jinrongbanli set tzsy=" . $alt . "  where  $bianset= '" . $code .
            "'";

        $res = $GLOBALS['db']->query($sql);
        echo "���³ɹ�";
    } else {
        echo "ʧ��";
    }

    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}


if ($_REQUEST['g'] == $g_post) {
 
    $time_field = array( //array("type"=>"2","field"=>"add_time","method"=>"1"),
            array(
            "type" => "1",
            "field" => "last_update2",
            "method" => "2"));
    //print_r($time_field);exit;
    
    $fi2.="jinrongbanli_sn,";
    //���ֶ�
    $bianset2='jinrongbanli_sn';
    
    $fi2.="jinrongbanli_name,";
    $fi2.="kehu_id,";
    $fi2.="banli_time,";
    $fi2.="jinrong_id";

    update_jinrongbanli_mx("jinrongbanli",$fi2,$bianset2, $time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('f/jinrongbanli_mx.html');

    
}


if ($_REQUEST['g'] == $g_in) {
    //echo 1;exit;
    //���ֶ�
    $bianset='jinrongbanli_sn';
    
    
    
    
    
    $_REQUEST[$bianset] = 'BL'.date('ymd') . substr(time(), -5) . substr(microtime(), 2, 5);
    if (isset($_REQUEST[$bianset])) {
        $code_wy = trim($_REQUEST[$bianset]);
    }


    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one = " select $bianset from jinrongbanli where $bianset ='" . $code_wy .
        "'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($get_one);exit;
    if (empty($res)) {
        //echo 1;
        // $p = new upload;
        //        $path=$p->upload_path='upload/color';
        //        $p->uplood_img();
        //        $img_array = $p->upload_file;
        //        for($i=0;$i<count($img_array['guige']);$i++)
        //        {
        //        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
        //        }
        //        //print_r($img_array);exit;
        //        $aaa = $color_sn;
        //
        //        //����ͼƬ��¼//ͼƬ���֡�ûͼƬ��ɾ��
        //         img_insert($aaa, $img_array,"color_imgs");
        //�޸�4���������
        //�����޸ĺ���Ʒ��ϸ
        $time_field = array(array(
                "type" => "2",
                "field" => "add_time",
                "method" => "1"), // array("type"=>"2","field"=>"last_update","method"=>"2"),
                //array("type"=>"1","field"=>"last_update_2","method"=>"2")
            );
        //�޸�4���������
        //�����޸ĺ���Ʒ��ϸ
        
    $fi2.="jinrongbanli_sn,";
    //���ֶ�
    $bianset2='jinrongbanli_sn';
    
    $fi2.="jinrongbanli_name,";
    $fi2.="kehu_id,";
    $fi2.="banli_time,";
    $fi2.="jinrong_id";
        insert_jinrongbanli_mx("jinrongbanli",
            $fi2,
            $time_field);
        
        $smarty->assign('fall', 'post2');
        $smarty->display('f/jinrongbanli_mx.html');

      


    } else {
        $smarty->assign('val', '�����Ѵ���');
        $smarty->assign('fall', 'fs');
        $smarty->display('f/jinrongbanli_mx.html');
    }


}


?>