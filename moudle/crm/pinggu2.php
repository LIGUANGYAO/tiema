<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/f/sub_pinggu.php');

require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['g'])) {
    $_REQUEST['g'] = 'default';
} else {
    $_REQUEST['g'] = trim($_REQUEST['g']);
}


//�趨����������
$g_add=substr(md5("a_pinggu"),0,17); //��Ӳ���
$g_e=substr(md5("e_pinggu"),0,17); //�༭
$g_post=substr(md5("post_pinggu"),0,17); //�޸ı���
$g_d=substr(md5("d_pinggu"),0,17); //ɾ��
$g_in=substr(md5("in_pinggu"),0,17); //����
$g_xs=substr(md5("xs_pinggu"),0,17); //��ʾ

//g= defaultĬ�� e�༭dɾ�� p�����޸� i�������
if ($_REQUEST['g'] == 'default') {


    ///�޸�1,��ѯ���
    //sort_no,tzsy Ҫ�ǵ����
    
    
    $sql = "select pinggu_sn,pinggu_name,kehu_id,kehu_name,pinggu_obj,jianzhumianji,danjia,shichangzongjia,shoufei,gongsi_id,pinggu_time,yinhang_id,yinhang_lianxiren,yinhang_lxr_tel,chubaogao_sl,naben1_time,naben2_time,naben3_time,bz  from pinggu";


    $list = get_pinggu_list($Num, "pinggu", $sql);

    //��������
 
 
 
    
 
    function gongsi_select($obj){
        $sql="select id,gongsi_sn as sn,gongsi_name as name from gongsi where tzsy=0 and id='".$obj."'";
    
        $res = $GLOBALS['db']->getRow($sql);
        //print_r($sql);exit;
        return $res;
    }
     

    
    for($j=0;$j<count($list['items']);$j++)
    {
      
        $gongsi_select =gongsi_select($list['items'][$j]['gongsi_id']);
        $list['items'][$j]['gongsi_bm']=$gongsi_select['name'];
    }
    
 
 
 
 
 
   
    if(1==1)
    {
                //�Ƿ񿪷�keyword��ס����ֵ
        $m_key= trim($_REQUEST['m_key']);
        $smarty->assign('m_key',$m_key);
    }
    
    

    
    
    $smarty->assign('pinggu_list', $list['items']);
    $smarty->assign('fall', 1);
    //$smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $list['page']);
    $smarty->display('f/pinggu.html');


}


if ($_REQUEST['g'] == $g_add) {
        
        
    
    $smarty->assign('fall', 'add_list');
    $smarty->display('f/pinggu_mx.html');
}

//�ж��Ƿ��б༭����
//�б༭����
if ($_REQUEST['g'] == $g_e) {
    //$aaa=$_GET['goods_sn'];
    ///�޸�2,��ѯ���
    
    $fi.="pinggu_sn,";
    //���ֶ�
    $bianset='pinggu_sn';
    $fi.="pinggu_name,";
    $fi.="kehu_id,";
    $fi.="kehu_name,";
    $fi.="pinggu_obj,";
    $fi.="jianzhumianji,";
    $fi.="danjia,";
    $fi.="shichangzongjia,";
    $fi.="shoufei,";
    $fi.="gongsi_id,";
    $fi.="pinggu_time,";
    $fi.="yinhang_id,";
    $fi.="yinhang_lianxiren,";
    $fi.="yinhang_lxr_tel,";
    $fi.="chubaogao_sl,";
    $fi.="naben1_time,";
    $fi.="naben2_time,";
    $fi.="naben3_time,";
    $fi.="bz";
    $sql = "select $fi  from pinggu ";
    $pinggu_mx = get_pinggu_mx($bianset, $sql);
    
   
    $smarty->assign('pinggu_mx', $pinggu_mx['items'][0]);
    
    
    
    function gongsi_select(){
        $sql='select id,gongsi_sn as sn,gongsi_name as name from gongsi where tzsy=0';
        $res = $GLOBALS['db']->getAll($sql);
        return $res;
    }
 
    $gongsi_select=gongsi_select();
    $smarty->assign('gongsi_select', $gongsi_select);
    //print_r($gongsi_list);
    
    //print_r($pinggu_mx);
    // $smarty->assign('res_xmlx', $color_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('f/pinggu_mx.html');
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
    $bianset='pinggu_sn';
    //echo 1;
    $arr=array();
    if (isset($_REQUEST[$bianset]) && empty($arr)) {
        $pinggu_sn = trim(urldecode($_REQUEST[$bianset]));

        $sql = "delete from pinggu where  $bianset= '" . $pinggu_sn . "'";
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
    $bianset='pinggu_sn';

    if (isset($_REQUEST[$bianset]) && isset($_REQUEST['alt'])) {
        $code = urldecode(trim($_REQUEST[$bianset]));
        $alt = urldecode(trim($_REQUEST['alt']));

        $sql = "update  pinggu set tzsy=" . $alt . "  where  $bianset= '" . $code .
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
    
    $fi2.="pinggu_sn,";
    //���ֶ�
    $bianset2='pinggu_sn';
    
    $fi2.="pinggu_name,";
    $fi2.="kehu_id,";
    $fi2.="kehu_name,";
    $fi2.="pinggu_obj,";
    $fi2.="jianzhumianji,";
    $fi2.="danjia,";
    $fi2.="shichangzongjia,";
    $fi2.="shoufei,";
    $fi2.="gongsi_id,";
    $fi2.="pinggu_time,";
    $fi2.="yinhang_id,";
    $fi2.="yinhang_lianxiren,";
    $fi2.="yinhang_lxr_tel,";
    $fi2.="chubaogao_sl,";
    $fi2.="naben1_time,";
    $fi2.="naben2_time,";
    $fi2.="naben3_time,";
    $fi2.="bz";

    update_pinggu_mx("pinggu",$fi2,$bianset2, $time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('f/pinggu_mx.html');

    
}


if ($_REQUEST['g'] == $g_in) {
    //echo 1;exit;
    //���ֶ�
    $bianset='pinggu_sn';
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    $_REQUEST[$bianset] = 'PG'.date('ymd') . substr(time(), -5) . substr(microtime(), 2, 5);
    if (isset($_REQUEST[$bianset])) {
        $code_wy = trim($_REQUEST[$bianset]);
    }


    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one = " select $bianset from pinggu where $bianset ='" . $code_wy .
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
        
    $fi2.="pinggu_sn,";
    //���ֶ�
    $bianset2='pinggu_sn';
    
    $fi2.="pinggu_name,";
    $fi2.="kehu_id,";
    $fi2.="kehu_name,";
    $fi2.="pinggu_obj,";
    $fi2.="jianzhumianji,";
    $fi2.="danjia,";
    $fi2.="shichangzongjia,";
    $fi2.="shoufei,";
    $fi2.="gongsi_id,";
    $fi2.="pinggu_time,";
    $fi2.="yinhang_id,";
    $fi2.="yinhang_lianxiren,";
    $fi2.="yinhang_lxr_tel,";
    $fi2.="chubaogao_sl,";
    $fi2.="naben1_time,";
    $fi2.="naben2_time,";
    $fi2.="naben3_time,";
    $fi2.="bz";
        insert_pinggu_mx("pinggu",
            $fi2,
            $time_field);
        
        $smarty->assign('fall', 'post2');
        $smarty->display('f/pinggu_mx.html');

      


    } else {
        $smarty->assign('val', '�����Ѵ���');
        $smarty->assign('fall', 'fs');
        $smarty->display('f/pinggu_mx.html');
    }


}


?>