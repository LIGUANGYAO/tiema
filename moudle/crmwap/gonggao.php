<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/f/sub_gonggao.php');

require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['g'])) {
    $_REQUEST['g'] = 'default';
} else {
    $_REQUEST['g'] = trim($_REQUEST['g']);
}


//�趨����������
$g_add=substr(md5("a_gonggao"),0,17); //��Ӳ���
$g_e=substr(md5("e_gonggao"),0,17); //�༭
$g_post=substr(md5("post_gonggao"),0,17); //�޸ı���
$g_d=substr(md5("d_gonggao"),0,17); //ɾ��
$g_in=substr(md5("in_gonggao"),0,17); //����
$g_xs=substr(md5("xs_gonggao"),0,17); //��ʾ

//g= defaultĬ�� e�༭dɾ�� p�����޸� i�������
if ($_REQUEST['g'] == 'default') {


    ///�޸�1,��ѯ���
    //sort_no,tzsy Ҫ�ǵ����
    
    
    $sql = "select gonggao_sn,gonggao_name,bz,leixing  from gonggao";


    $list = get_gonggao_list($Num, "gonggao", $sql);

    //��������
 
 
 
 


    if(1==1)
    {
                //�Ƿ񿪷�keyword��ס����ֵ
        $m_key= trim($_REQUEST['m_key']);
        $smarty->assign('m_key',$m_key);
        if($m_key=='')
        {
            $max_page=0;
        }
        else
        {
            $max_page=1;
        }
        if($list['page']['pager_Total']<=10)
        {
            $max_page=1;
        }
        $smarty->assign('max_page',$max_page);
    }
    
    

    
    
    $smarty->assign('gonggao_list', $list['items']);
    $smarty->assign('fall', 1);
    //$smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $list['page']);
    $smarty->display('w/gonggao.html');


}


if ($_REQUEST['g'] == 'getnextpage') {


    ///�޸�1,��ѯ���
    //sort_no,tzsy Ҫ�ǵ����
    
    
    $sql = "select gonggao_sn,gonggao_name,bz,leixing  from gonggao";


    $list = get_gonggao_list($Num, "gonggao", $sql);

    //��������
 
 
 
 


    if(1==1)
    {
                //�Ƿ񿪷�keyword��ס����ֵ
        $m_key= trim($_REQUEST['m_key']);
        $smarty->assign('m_key',$m_key);
        if($m_key=='')
        {
            $max_page=0;
        }
        else
        {
            $max_page=1;
        }
        if($list['page']['pager_Total']<=10)
        {
            $max_page=1;
        }
        $smarty->assign('max_page',$max_page);
    }
    
    

    
    
    //   $smarty->assign('kehu_list', $list['items']);
//    $smarty->assign('fall', 1);
//    //$smarty->assign('title', $aaa);
//    $smarty->assign('p_Array', $list['page']);
    $list['sl']=count($list['items']);
    
    require (dirname(__file__) . '/sub/rest.php');
    $aaa = new arraytojson();
    $json = $aaa->JSON($list);

    print_r($json);



}


if ($_REQUEST['g'] == $g_add) {
 
 
 
 
 
        
    
    $smarty->assign('fall', 'add_list');
    $smarty->display('f/gonggao_mx.html');
}

//�ж��Ƿ��б༭����
//�б༭����
if ($_REQUEST['g'] == $g_e) {
    //$aaa=$_GET['goods_sn'];
    ///�޸�2,��ѯ���
    
 
    $fi.="gonggao_sn,";
    //���ֶ�
    $bianset='gonggao_sn';
 
    $fi.="gonggao_name,";
 
    $fi.="bz,";
 
    $fi.="leixing";
    $sql = "select $fi  from gonggao ";
    $gonggao_mx = get_gonggao_mx($bianset, $sql);

   
    $smarty->assign('gonggao_mx', $gonggao_mx['items'][0]);
    
    
    //ͼƬ���֡�ûͼƬ��ɾ��
     $zzd=trim($_REQUEST[$bianset]);
    $imgtext_imgs2 = get_imgs_list("gonggao_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$zzd);
//print_r($imgtext_imgs2);
    $imgtext_imgs = arr_push($imgtext_imgs2['items']);
    $smarty->assign('imgtext_imgs', $imgtext_imgs);
    
    //print_r($gonggao_mx);
    // $smarty->assign('res_xmlx', $color_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('w/gonggao_mx.html');
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
    $bianset='gonggao_sn';
    //echo 1;
    $arr=array();
    if (isset($_REQUEST[$bianset]) && empty($arr)) {
        $gonggao_sn = trim(urldecode($_REQUEST[$bianset]));

        $sql = "delete from gonggao where  $bianset= '" . $gonggao_sn . "'";
        $res = $GLOBALS['db']->query($sql);
        
        echo "1";
    } else {
        echo "2";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}


//�ж��Ƿ������ô���
//�����ô���
if ($_REQUEST['g'] == $g_xs) {

    //���ֶ�
    $bianset='gonggao_sn';

    if (isset($_REQUEST[$bianset]) && isset($_REQUEST['alt'])) {
        $code = urldecode(trim($_REQUEST[$bianset]));
        $alt = urldecode(trim($_REQUEST['alt']));

        $sql = "update  gonggao set tzsy=" . $alt . "  where  $bianset= '" . $code .
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
    
    $fi2.="gonggao_sn,";
    //���ֶ�
    $bianset2='gonggao_sn';
    
    $fi2.="gonggao_name,";
    $fi2.="bz,";
    $fi2.="leixing";
    
     $zzd=trim($_REQUEST[$bianset2]);
   $p = new upload;
        $path=$p->upload_path='upload/gonggao';
        $p->allow = array('doc', 'docx', 'docm', 'dotx', 'dotm','dot', 'rtf', 'wps', 'ppt', 'pptx','xlsx','xlsm','xlsb','xls');
        $p->uplood_img();
        $img_array = $p->upload_file;
        //print_r($img_array);exit;
     img_insert($zzd, $img_array,"gonggao_imgs");

    update_gonggao_mx("gonggao",$fi2,$bianset2, $time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('w/gonggao_mx.html');

    
}


if ($_REQUEST['g'] == $g_in) {
    //echo 1;exit;
    //���ֶ�
    $bianset='gonggao_sn';
    
    
    
    
    $_REQUEST[$bianset] = ''.date('ymd') . substr(time(), -5) . substr(microtime(), 2, 5);
    if (isset($_REQUEST[$bianset])) {
        $code_wy = trim($_REQUEST[$bianset]);
    }


    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one = " select $bianset from gonggao where $bianset ='" . $code_wy .
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
        
    $fi2.="gonggao_sn,";
    //���ֶ�
    $bianset2='gonggao_sn';
    
    $fi2.="gonggao_name,";
    $fi2.="bz,";
    $fi2.="leixing";
        insert_gonggao_mx("gonggao",
            $fi2,
            $time_field);
        
        $smarty->assign('fall', 'post2');
        $smarty->display('w/gonggao_mx.html');

      


    } else {
        $smarty->assign('val', '�����Ѵ���');
        $smarty->assign('fall', 'fs');
        $smarty->display('w/gonggao_mx.html');
    }


}

if ($_REQUEST['g'] == 'delete') {

    //echo 1;
    if(isset($_REQUEST['img_code']))
    {
        $img_code=trim($_REQUEST['img_code']);
                        
        $sql="delete from gonggao_imgs where  img_outer_id= '".$img_code."'";     
        $res = $GLOBALS['db']->query($sql);
        echo "ɾ���ɹ�";                
    }
    else
    {
        echo "ʧ��";
    }
    
    
    
    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}
if ($_REQUEST['g'] == 'img_xs') {

    //echo 1;
    if(isset($_REQUEST['img_code']) && isset($_REQUEST['alt']))
    {
        $img_code=trim($_REQUEST['img_code']);
        $alt=trim($_REQUEST['alt']);
                        
        $sql="update  gonggao_imgs set ss=".$alt."  where  img_outer_id= '".$img_code."'";     
        $res = $GLOBALS['db']->query($sql);
        echo "�޸ĳɹ�";                
    }
    else
    {
        echo "ʧ��";
    }
    
    
    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}

?>