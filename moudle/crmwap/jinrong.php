<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/f/sub_jinrong.php');

require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['g'])) {
    $_REQUEST['g'] = 'default';
} else {
    $_REQUEST['g'] = trim($_REQUEST['g']);
}


//�趨����������
$g_add=substr(md5("a_jinrong"),0,17); //��Ӳ���
$g_e=substr(md5("e_jinrong"),0,17); //�༭
$g_post=substr(md5("post_jinrong"),0,17); //�޸ı���
$g_d=substr(md5("d_jinrong"),0,17); //ɾ��
$g_in=substr(md5("in_jinrong"),0,17); //����
$g_xs=substr(md5("xs_jinrong"),0,17); //��ʾ

//g= defaultĬ�� e�༭dɾ�� p�����޸� i�������
if ($_REQUEST['g'] == 'default') {


    ///�޸�1,��ѯ���
    //sort_no,tzsy Ҫ�ǵ����
    
    
    $sql = "select jinrong_sn,jinrong_name,bz,yinhang_id,gongsi_id,leixing  from jinrong";


    $list = get_jinrong_list($Num, "jinrong", $sql);

    //��������
 
 
    $leixing= trim($_REQUEST['leixing']);    
    if($leixing=='')
    {
        $leixing='';
    }
    $smarty->assign('leixing',$leixing);
 
 
 
 
    function yinhang_id_select($obj){
        $sql="select id,yinhang_sn as sn,yinhang_name as name from yinhang where tzsy=0 and 1=1 and id='".$obj."'";
    
        $res = $GLOBALS['db']->getRow($sql);
        //print_r($sql);exit;
        return $res;
    }   
    for($j=0;$j<count($list['items']);$j++)
    {
        $yinhang_id_select =yinhang_id_select($list['items'][$j]['yinhang_id']);
        $list['items'][$j]['yinhang_id_bm']=$yinhang_id_select['name'];
    }
    function gongsi_id_select($obj){
        $sql="select id,gongsi_sn as sn,gongsi_name as name from gongsi where tzsy=0 and 1=1 and id='".$obj."'";
    
        $res = $GLOBALS['db']->getRow($sql);
        //print_r($sql);exit;
        return $res;
    }   
    for($j=0;$j<count($list['items']);$j++)
    {
        $gongsi_id_select =gongsi_id_select($list['items'][$j]['gongsi_id']);
        $list['items'][$j]['gongsi_id_bm']=$gongsi_id_select['name'];
    }


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
    
    

    
    
    $smarty->assign('jinrong_list', $list['items']);
    $smarty->assign('fall', 1);
    //$smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $list['page']);
    $smarty->display('w/jinrong.html');


}



if ($_REQUEST['g'] == 'getnextpage') {


    ///�޸�1,��ѯ���
    //sort_no,tzsy Ҫ�ǵ����
    
    
    $sql = "select jinrong_sn,jinrong_name,bz,yinhang_id,gongsi_id,leixing  from jinrong";


    $list = get_jinrong_list($Num, "jinrong", $sql);

    //��������
 
 
    $leixing= trim($_REQUEST['leixing']);    
    if($leixing=='')
    {
        $leixing='';
    }
    $smarty->assign('leixing',$leixing);
 
 
 
 
    function yinhang_id_select($obj){
        $sql="select id,yinhang_sn as sn,yinhang_name as name from yinhang where tzsy=0 and 1=1 and id='".$obj."'";
    
        $res = $GLOBALS['db']->getRow($sql);
        //print_r($sql);exit;
        return $res;
    }   
    for($j=0;$j<count($list['items']);$j++)
    {
        $yinhang_id_select =yinhang_id_select($list['items'][$j]['yinhang_id']);
        $list['items'][$j]['yinhang_id_bm']=$yinhang_id_select['name'];
    }
    function gongsi_id_select($obj){
        $sql="select id,gongsi_sn as sn,gongsi_name as name from gongsi where tzsy=0 and 1=1 and id='".$obj."'";
    
        $res = $GLOBALS['db']->getRow($sql);
        //print_r($sql);exit;
        return $res;
    }   
    for($j=0;$j<count($list['items']);$j++)
    {
        $gongsi_id_select =gongsi_id_select($list['items'][$j]['gongsi_id']);
        $list['items'][$j]['gongsi_id_bm']=$gongsi_id_select['name'];
    }


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
    
    

    $list['sl']=count($list['items']);
    
    require (dirname(__file__) . '/sub/rest.php');
    $aaa = new arraytojson();
    $json = $aaa->JSON($list);

    print_r($json);

}

if ($_REQUEST['g'] == $g_add) {
 
 
 
    function yinhang_id_select(){
        $sql='select id,yinhang_sn as sn,yinhang_name as name from yinhang where tzsy=0';
        $res = $GLOBALS['db']->getAll($sql);
        return $res;
    }
 
    $yinhang_id_select=yinhang_id_select();
    $smarty->assign('yinhang_id_select', $yinhang_id_select);
 
    function gongsi_id_select(){
        $sql='select id,gongsi_sn as sn,gongsi_name as name from gongsi where tzsy=0';
        $res = $GLOBALS['db']->getAll($sql);
        return $res;
    }
 
    $gongsi_id_select=gongsi_id_select();
    $smarty->assign('gongsi_id_select', $gongsi_id_select);
 
 
 
        
    
    $smarty->assign('fall', 'add_list');
    $smarty->display('w/jinrong_mx.html');
}

//�ж��Ƿ��б༭����
//�б༭����
if ($_REQUEST['g'] == $g_e) {
    //$aaa=$_GET['goods_sn'];
    ///�޸�2,��ѯ���
    
 
    $fi.="jinrong_sn,";
    //���ֶ�
    $bianset='jinrong_sn';
 
    $fi.="jinrong_name,";
 
    $fi.="leixing,";
    function yinhang_id_select(){
        $sql='select id,yinhang_sn as sn,yinhang_name as name from yinhang where tzsy=0';
        $res = $GLOBALS['db']->getAll($sql);
        return $res;
    }
 
    $yinhang_id_select=yinhang_id_select();
    $smarty->assign('yinhang_id_select', $yinhang_id_select);
 
    $fi.="yinhang_id,";
    function gongsi_id_select(){
        $sql='select id,gongsi_sn as sn,gongsi_name as name from gongsi where tzsy=0';
        $res = $GLOBALS['db']->getAll($sql);
        return $res;
    }
 
    $gongsi_id_select=gongsi_id_select();
    $smarty->assign('gongsi_id_select', $gongsi_id_select);
 
    $fi.="gongsi_id,";
 
    $fi.="bz";
    $sql = "select $fi  from jinrong ";
    $jinrong_mx = get_jinrong_mx($bianset, $sql);

   
    $smarty->assign('jinrong_mx', $jinrong_mx['items'][0]);
    
    //print_r($jinrong_mx);
    // $smarty->assign('res_xmlx', $color_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('w/jinrong_mx.html');
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
    $bianset='jinrong_sn';
    //echo 1;
    $arr=array();
    if (isset($_REQUEST[$bianset]) && empty($arr)) {
        $jinrong_sn = trim(urldecode($_REQUEST[$bianset]));

        $sql = "delete from jinrong where  $bianset= '" . $jinrong_sn . "'";
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
    $bianset='jinrong_sn';

    if (isset($_REQUEST[$bianset]) && isset($_REQUEST['alt'])) {
        $code = urldecode(trim($_REQUEST[$bianset]));
        $alt = urldecode(trim($_REQUEST['alt']));

        $sql = "update  jinrong set tzsy=" . $alt . "  where  $bianset= '" . $code .
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
    
    $fi2.="jinrong_sn,";
    //���ֶ�
    $bianset2='jinrong_sn';
    
    $fi2.="jinrong_name,";
    $fi2.="leixing,";
    $fi2.="yinhang_id,";
    $fi2.="gongsi_id,";
    $fi2.="bz";

    update_jinrong_mx("jinrong",$fi2,$bianset2, $time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('w/jinrong_mx.html');

    
}


if ($_REQUEST['g'] == $g_in) {
    //echo 1;exit;
    //���ֶ�
    $bianset='jinrong_sn';
    
    
    
    
    
    
    $_REQUEST[$bianset] = 'JR'.date('ymd') . substr(time(), -5) . substr(microtime(), 2, 5);
    if (isset($_REQUEST[$bianset])) {
        $code_wy = trim($_REQUEST[$bianset]);
    }


    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one = " select $bianset from jinrong where $bianset ='" . $code_wy .
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
        
    $fi2.="jinrong_sn,";
    //���ֶ�
    $bianset2='jinrong_sn';
    
    $fi2.="jinrong_name,";
    $fi2.="leixing,";
    $fi2.="yinhang_id,";
    $fi2.="gongsi_id,";
    $fi2.="bz";
        insert_jinrong_mx("jinrong",
            $fi2,
            $time_field);
        
        $smarty->assign('fall', 'post2');
        $smarty->display('w/jinrong_mx.html');

      


    } else {
        $smarty->assign('val', '�����Ѵ���');
        $smarty->assign('fall', 'fs');
        $smarty->display('w/jinrong_mx.html');
    }


}


?>