<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/f/sub_kehu.php');

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


    ///�޸�1,��ѯ���
    //sort_no,tzsy Ҫ�ǵ����
    
    
    $sql = "select * from kehu";


    $list = get_kehu_list($Num, "kehu", $sql);

    //��������
 
 
    
 
    $khlx= trim($_REQUEST['khlx']);    
    if($khlx=='')
    {
        $khlx='';
    }
    $smarty->assign('khlx',$khlx);
 
 
   
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
  
    //print_r($list['page']);
    //print_r($list);
    
    
    
    $smarty->assign('kehu_list', $list['items']);
    $smarty->assign('fall', 1);
    //$smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $list['page']);
    $smarty->display('w/kehu.html');


}



if ($_REQUEST['g'] == 'getnextpage') {


    ///�޸�1,��ѯ���
    //sort_no,tzsy Ҫ�ǵ����
    
    
    $sql = "select * from kehu";


    $list = get_kehu_list($Num, "kehu", $sql);

    //��������
 
 
 
 
 
    $khlx= trim($_REQUEST['khlx']);    
    if($khlx=='')
    {
        $khlx='';
    }
    $smarty->assign('khlx',$khlx);
 
 
   
    if(1==1)
    {
                //�Ƿ񿪷�keyword��ס����ֵ
        $m_key= trim($_REQUEST['m_key']);
        $smarty->assign('m_key',$m_key);
    }
    
    
    //print_r($list);
    
    
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



if ($_REQUEST['g'] == 'kehuhuifang') {
        
    $kehu_sn=$_REQUEST['kehu_sn'];
    $smarty->assign('kehu_sn', $kehu_sn);
    $smarty->assign('fall', 'kehuhuifang');
    $smarty->display('w/kehu_mx.html');
}


if ($_REQUEST['g'] == 'tianjiakehuhuifang') {
        
    $kehu_sn=$_REQUEST['kehu_sn'];
    $smarty->assign('kehu_sn', $kehu_sn);
    $smarty->assign('fall', 'tianjiakehuhuifang');
    $smarty->display('w/kehu_mx.html');
}



if ($_REQUEST['g'] == $g_add) {
        
    $sn= 'KH'.date('ymd') . substr(time(), -5) . substr(microtime(), 2, 5);
    $smarty->assign('sn', $sn);
    $smarty->assign('fall', 'add_list');
    $smarty->display('w/kehu_mx.html');
}

//�ж��Ƿ��б༭����
//�б༭����
if ($_REQUEST['g'] == $g_e) {
    //$aaa=$_GET['goods_sn'];
    ///�޸�2,��ѯ���
    
    $fi.="kehu_sn,";
    //���ֶ�
    $bianset='kehu_sn';
    $fi.="id,kehu_name,";
    $fi.="tel,";
    $fi.="mobile,";
    $fi.="bz,";
    $fi.="gongsimingcheng,";
    $fi.="zhiwei,";
    $fi.="email,";
    $fi.="chuanzhen,";
    $fi.="hangye,";
    $fi.="hangye_bz,";
  
    $fi.="khlx";
    $sql = "select $fi  from kehu ";
    $kehu_mx = get_kehu_mx($bianset, $sql);

    $smarty->assign('kehu_mx', $kehu_mx['items'][0]);
  
    //��ȡ������¼
    $pinggu = "select pinggu_sn,pinggu_name,kehu_id,kehu_name,pinggu_obj,jianzhumianji,danjia,shichangzongjia,shoufei,gongsi_id,pinggu_time,yinhang_id,yinhang_lianxiren,yinhang_lxr_tel,chubaogao_sl,naben1_time,naben2_time,naben3_time,bz  from pinggu where kehu_id='".$kehu_mx['items'][0]['id']."' ";
    $pinggu = $GLOBALS['db']->getAll($pinggu);
    $smarty->assign('pinggu',$pinggu);
    
    //��ȡ��Ƽ�¼
    $jinrong = "select b.*,a.jinrong_name,a.jinrong_sn from jinrong a inner join jinrongbanli b on a.id=b.jinrong_id  where b.kehu_id='".$kehu_mx['items'][0]['id']."' ";
    $jinrong = $GLOBALS['db']->getAll($jinrong);
    $smarty->assign('jinrong',$jinrong);
    
     //echo $old;echo $new;
     $user="select user_name,is_admin from admin_user where user_name='". getlogin_name()."' and tzsy=0";
     //echo $_COOKIE['n1'];
     $user = $GLOBALS['db']->getRow($user);
     $smarty->assign('is_admin', $user['is_admin']);
    //print_r($user);
    
    
      //print_r($pinggu);exit;
    if($_REQUEST['xg']=='1')
    {
        
        $smarty->assign('g_e', $g_e);
        $smarty->assign('fall', 'edit2');
        $smarty->display('w/kehu_mx.html');
    }
    else
    {
        $smarty->assign('g_e', $g_e);
        $smarty->assign('fall', 'edit');
        $smarty->display('w/kehu_mx.html');
    }
    //print_r($kehu_mx);
    // $smarty->assign('res_xmlx', $color_mx['res_xmlx']);
    
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
    $bianset='kehu_sn';
    //echo 1;
    $arr=array();
    if (isset($_REQUEST[$bianset]) && empty($arr)) {
        $kehu_sn = trim(urldecode($_REQUEST[$bianset]));

        $sql = "delete from kehu where  $bianset= '" . $kehu_sn . "'";
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
    $bianset='kehu_sn';

    if (isset($_REQUEST[$bianset]) && isset($_REQUEST['alt'])) {
        $code = urldecode(trim($_REQUEST[$bianset]));
        $alt = urldecode(trim($_REQUEST['alt']));

        $sql = "update  kehu set tzsy=" . $alt . "  where  $bianset= '" . $code .
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
    
    $fi2.="kehu_sn,";
    //���ֶ�
    $bianset2='kehu_sn';
    
    $fi2.="kehu_name,";
    $fi2.="tel,";
    $fi2.="mobile,";
    $fi2.="bz,";
    $fi2.="gongsimingcheng,";
    $fi2.="zhiwei,";
    $fi2.="email,";
    $fi2.="chuanzhen,";
    $fi2.="hangye,";
    $fi2.="hangye_bz,";
  
    $fi2.="khlx";
//print_r($fi2);exit;
    update_kehu_mx("kehu",$fi2,$bianset2, $time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('f/kehu_mx.html');
     header("location: kehu.html");
    
}


if ($_REQUEST['g'] == $g_in) {
    //echo 1;exit;
    //���ֶ�
    $bianset='kehu_sn';
    
    
    
    
    
    
    
    
    
    
    
    $_REQUEST[$bianset] = 'KH'.date('ymd') . substr(time(), -5) . substr(microtime(), 2, 5);
    if (isset($_REQUEST[$bianset])) {
        $code_wy = trim($_REQUEST[$bianset]);
    }


    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one = " select $bianset from kehu where $bianset ='" . $code_wy .
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
        
    $fi2.="kehu_sn,";
    //���ֶ�
    $bianset2='kehu_sn';
    
    $fi2.="kehu_name,";
    $fi2.="tel,";
    $fi2.="mobile,";
    $fi2.="bz,";
   $fi2.="gongsimingcheng,";
    $fi2.="zhiwei,";
    $fi2.="email,";
    $fi2.="chuanzhen,";
    $fi2.="hangye,";
    $fi2.="hangye_bz,";
  
    $fi2.="khlx";
        insert_kehu_mx("kehu",
            $fi2,
            $time_field);
        
        $smarty->assign('fall', 'post2');
        $smarty->display('f/kehu_mx.html');

      


    } else {
        $smarty->assign('val', '�����Ѵ���');
        $smarty->assign('fall', 'fs');
        $smarty->display('f/kehu_mx.html');
    }

    header("location: kehu.html");
}


?>