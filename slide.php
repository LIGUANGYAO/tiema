<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_slide.php');

require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
///�޸�1,��ѯ���
//sort_no,tzsy Ҫ�ǵ����
    $sql="select id,slide_sn,slide_name,sort_no,tzsy,last_update,slide_note_1,type from slide";
    
    $slide_list = get_slide_list($Num,"slide",$sql);
    //print_r($slide_list);
    $smarty->assign('slide_list', $slide_list['items']);
     $smarty->assign('fall', 1);
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $slide_list['page']);
    $smarty->display('slide.tpl');


}

if ($_REQUEST['act'] == 'add_slide_list') {

   //$sql="select xmlx_sn ,xmlx_name from xmlx";
//   $res_xmlx = $GLOBALS['db']->getAll($sql);
//    $smarty->assign('res_xmlx', $res_xmlx);
    $smarty->assign('fall', 'add_slide_list');
    $smarty->display('slide_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];
    
    ///�޸�2,��ѯ���
    $sql="select id,slide_sn,slide_name,sort_no,tzsy,last_update,slide_note_1,type
  from slide ";
    $slide_mx=get_slide_mx("slide",$sql);
    
   // print_r($slide_mx);exit;
    $img_cod=$_REQUEST['slide_sn'];
    
    
    //ͼƬ���֡�ûͼƬ��ɾ��
    $slide_imgs2 = get_slide_imgs_list("slide_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
//print_r($slide_imgs2);
    $slide_imgs = arr_push($slide_imgs2['items']);
    $smarty->assign('slide_imgs', $slide_imgs);
    
    
    $smarty->assign('slide_mx', $slide_mx['items'][0]);
    $smarty->assign('res_xmlx', $slide_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('slide_mx.tpl');
}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if(isset($_REQUEST['img_code']))
    {
        $img_code=trim($_REQUEST['img_code']);
                        
        $sql="delete from slide_imgs where  img_outer_id= '".$img_code."'";     
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

if ($_REQUEST['act'] == 'delete_slide') {

    //echo 1;
    if(isset($_REQUEST['slide_sn']))
    {
        $slide_sn=trim($_REQUEST['slide_sn']);
                        
        $sql="delete from slide where  slide_sn= '".$slide_sn."'";     
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
if ($_REQUEST['act'] == 'img_xs') {

    //echo 1;
    if(isset($_REQUEST['img_code']) && isset($_REQUEST['alt']))
    {
        $img_code=trim($_REQUEST['img_code']);
        $alt=trim($_REQUEST['alt']);
                        
        $sql="update  slide_imgs set ss=".$alt."  where  img_outer_id= '".$img_code."'";     
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
if ($_REQUEST['act'] == 'slide_xs') {

    //echo 1;
   
    if(isset($_REQUEST['slide_code']) && isset($_REQUEST['alt']))
    {
        $slide_code=urldecode(trim($_REQUEST['slide_code']));
        $alt=urldecode(trim($_REQUEST['alt']));
                        
        $sql="update  slide set tzsy=".$alt."  where  slide_sn= '".$slide_code."'";     
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


if ($_REQUEST['act'] == 'post') {

    
    $p = new upload;
    $path=$p->upload_path='upload/slide';
    $p->uplood_img();
    $img_array = $p->upload_file;
   
    for($i=0;$i<count($img_array['guige']);$i++)
    {
        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
    }
    $aaa = $_POST['slide_sn'];
    // print_r($aaa);exit;
    //ͼƬ���֡�ûͼƬ��ɾ��
    img_insert($aaa, $img_array,"slide_imgs");
    //�޸�3���������
     $time_field=array(
    //array("type"=>"2","field"=>"add_time","method"=>"1"),
    array("type"=>"2","field"=>"last_update","method"=>"2"),
    array("type"=>"1","field"=>"last_update_2","method"=>"2")
    );
    //print_r($time_field);exit;
    update_slide_mx("slide","slide_name,slide_note_1,type,type_name,sort_no","slide_sn",$time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('slide_mx.tpl');
}


if ($_REQUEST['act'] == 'post_add') {
      if(isset($_REQUEST['slide_sn']))
    {
        $slide_sn=trim($_REQUEST['slide_sn']);
    }
    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one=" select slide_sn from slide where slide_sn ='".$slide_sn."'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($get_one);exit;
    if(empty($res))
    {
        //echo 1;
        $p = new upload;
        $path=$p->upload_path='upload/slide';
        $p->uplood_img();
        $img_array = $p->upload_file;
        for($i=0;$i<count($img_array['guige']);$i++)
        {
        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
        }
        //print_r($img_array);exit;
        $aaa = $slide_sn;
        
        //����ͼƬ��¼//ͼƬ���֡�ûͼƬ��ɾ��
         img_insert($aaa, $img_array,"slide_imgs");
        //�޸�4���������
        //�����޸ĺ���Ʒ��ϸ
           $time_field=array(
        array("type"=>"2","field"=>"add_time","method"=>"1"),
       // array("type"=>"2","field"=>"last_update","method"=>"2"),
        //array("type"=>"1","field"=>"last_update_2","method"=>"2")
        );
        //�޸�4���������
        //�����޸ĺ���Ʒ��ϸ
        insert_slide_mx("slide","slide_sn,slide_name,slide_note_1,type,type_name,sort_no",$time_field);
        
        $smarty->assign('fall', 'post');
        $smarty->display('slide_mx.tpl');
    }
    else
    {
        $smarty->assign('fall', 'post');
        $smarty->display('slide_mx.tpl');   
    }
    
  
}


if ($_REQUEST['act'] == 'guanwang') {
   
    
   
    $img_cod="0001";
     $slide_imgs22 = get_slide_imgs_list("slide_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
    // print_r($slide_imgs22);
     

    $smarty->assign('slide_imgs22', $slide_imgs22['items']);
    $smarty->display('mb/2/index.htm');
}


if ($_REQUEST['act'] == 'guanyu') {
    $smarty->display('mb/2/guanyu.htm');
}
?>