<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/f/sub_kehuhuifang.php');

require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['g'])) {
    $_REQUEST['g'] = 'default';
} else {
    $_REQUEST['g'] = trim($_REQUEST['g']);
}


//�趨����������
$g_add=substr(md5("a_kehuhuifang"),0,17); //��Ӳ���
$g_e=substr(md5("e_kehuhuifang"),0,17); //�༭
$g_post=substr(md5("post_kehuhuifang"),0,17); //�޸ı���
$g_d=substr(md5("d_kehuhuifang"),0,17); //ɾ��
$g_in=substr(md5("in_kehuhuifang"),0,17); //����
$g_xs=substr(md5("xs_kehuhuifang"),0,17); //��ʾ

//g= defaultĬ�� e�༭dɾ�� p�����޸� i�������
if ($_REQUEST['g'] == 'default') {


    ///�޸�1,��ѯ���
    //sort_no,tzsy Ҫ�ǵ����
    
    
    $sql = "select kehuhuifang_sn,kehu_id,huifang_time,bz,user_name,user_id  from kehuhuifang";


    $list = get_kehuhuifang_list($Num, "kehuhuifang", $sql);

    //��������
 
 
    $huifang_time_1= trim($_REQUEST['huifang_time_1']);    
    $smarty->assign('huifang_time_1',$huifang_time_1);
    $huifang_time_2= trim($_REQUEST['huifang_time_2']);    
    $smarty->assign('huifang_time_2',$huifang_time_2);
 
 
 
 
    


    if(1==1)
    {
                //�Ƿ񿪷�keyword��ס����ֵ
        $m_key= trim($_REQUEST['m_key']);
        $smarty->assign('m_key',$m_key);
    }
    
    $kehu_list="select * from kehu where id='".$_REQUEST['kehu_id']."'";
    $kehu_list = $GLOBALS['db']->getRow($kehu_list);
    $smarty->assign('kehu',$kehu_list);
    //print_r($list['items']);
    
    $smarty->assign('kehuhuifang_list', $list['items']);
    $smarty->assign('fall', 1);
    //$smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $list['page']);
    $smarty->display('w/kehuhuifang.html');


}


if ($_REQUEST['g'] == $g_add) {
 
 
 
   
 
    $kehu_list="select * from kehu where id='".$_REQUEST['kehu_id']."'";
    $kehu_list = $GLOBALS['db']->getRow($kehu_list);
    $smarty->assign('kehu',$kehu_list);
 
    $smarty->assign('huifang_time', date('Y-m-d H:i:s', time()));
    
    $smarty->assign('fall', 'add_list');
    $smarty->display('w/kehuhuifang_mx.html');
}

//�ж��Ƿ��б༭����
//û�б༭����

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
//û��ɾ������

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
//û�����ô���


if ($_REQUEST['g'] == $g_post) {
 
    $time_field = array( //array("type"=>"2","field"=>"add_time","method"=>"1"),
            array(
            "type" => "1",
            "field" => "last_update2",
            "method" => "2"));
    //print_r($time_field);exit;
    
    $fi2.="kehuhuifang_sn,";
    //���ֶ�
    $bianset2='kehuhuifang_sn';
    
    $fi2.="kehu_id,";
    $fi2.="huifang_time,";
    $fi2.="bz,";
    $fi2.="user_name,";
    $fi2.="user_id";

    update_kehuhuifang_mx("kehuhuifang",$fi2,$bianset2, $time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('f/kehuhuifang_mx.html');

    
}


if ($_REQUEST['g'] == $g_in) {
    //echo 1;exit;
    //���ֶ�
    $bianset='kehuhuifang_sn';
    
    
    
    
    
    
    $_REQUEST[$bianset] = 'HF'.date('ymd') . substr(time(), -5) . substr(microtime(), 2, 5);
    if (isset($_REQUEST[$bianset])) {
        $code_wy = trim($_REQUEST[$bianset]);
    }
    //echo getlogin_name();

    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one = " select $bianset from kehuhuifang where $bianset ='" . $code_wy .
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
        
    //ǿ�������ֶ�
    $_REQUEST['user_name']=getlogin_name();
    
    
    $fi2.="kehuhuifang_sn,";
    //���ֶ�
    $bianset2='kehuhuifang_sn';
    
    $fi2.="kehu_id,";
    $fi2.="huifang_time,";
    $fi2.="bz,";
    $fi2.="user_name,";
    $fi2.="user_id";
        insert_kehuhuifang_mx("kehuhuifang",
            $fi2,
            $time_field);
        
        $smarty->assign('fall', 'post2');
        $smarty->display('w/kehuhuifang_mx.html');

      


    } else {
        $smarty->assign('val', '�����Ѵ���');
        $smarty->assign('fall', 'fs');
        $smarty->display('f/kehuhuifang_mx.html');
    }
    header("location: kehuhuifang.html?kehu_id=".$_REQUEST['kehu_id']);

}


?>