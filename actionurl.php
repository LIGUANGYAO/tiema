<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_actionurl.php');

require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
///�޸�1,��ѯ���
//sort_no,tzsy Ҫ�ǵ����
    $sql="select id,actionurl_sn,actionurl_name,sort_no,tzsy,last_update,url,type from actionurl";
    
    $actionurl_list = get_actionurl_list($Num,"actionurl",$sql);
    //print_r($actionurl_list);
    $smarty->assign('actionurl_list', $actionurl_list['items']);
     $smarty->assign('fall', 1);
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $actionurl_list['page']);
    $smarty->display('actionurl.tpl');


}

if ($_REQUEST['act'] == 'add_actionurl_list') {

   //$sql="select xmlx_sn ,xmlx_name from xmlx";
//   $res_xmlx = $GLOBALS['db']->getAll($sql);
//    $smarty->assign('res_xmlx', $res_xmlx);
    $smarty->assign('fall', 'add_actionurl_list');
    $smarty->display('actionurl_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];
    
    ///�޸�2,��ѯ���
    $sql="select id,actionurl_sn,actionurl_name,sort_no,tzsy,last_update,url,type
  from actionurl ";
    $actionurl_mx=get_actionurl_mx("actionurl",$sql);
    
   // print_r($actionurl_mx);exit;
    $img_cod=$_REQUEST['actionurl_sn'];
    
    
//    //ͼƬ���֡�ûͼƬ��ɾ��
//    $actionurl_imgs2 = get_actionurl_imgs_list("actionurl_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
////print_r($actionurl_imgs2);
//    $actionurl_imgs = arr_push($actionurl_imgs2['items']);
//    $smarty->assign('actionurl_imgs', $actionurl_imgs);
    
    
    $smarty->assign('actionurl_mx', $actionurl_mx['items'][0]);
    $smarty->assign('res_xmlx', $actionurl_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('actionurl_mx.tpl');
}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if(isset($_REQUEST['img_code']))
    {
        $img_code=trim($_REQUEST['img_code']);
                        
        $sql="delete from actionurl_imgs where  img_outer_id= '".$img_code."'";     
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

if ($_REQUEST['act'] == 'delete_actionurl') {

    //echo 1;
    if(isset($_REQUEST['actionurl_sn']))
    {
        $actionurl_sn=trim($_REQUEST['actionurl_sn']);
                        
        $sql="delete from actionurl where  actionurl_sn= '".$actionurl_sn."'";     
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
                        
        $sql="update  actionurl_imgs set ss=".$alt."  where  img_outer_id= '".$img_code."'";     
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
if ($_REQUEST['act'] == 'actionurl_xs') {

    //echo 1;
   
    if(isset($_REQUEST['actionurl_code']) && isset($_REQUEST['alt']))
    {
        $actionurl_code=urldecode(trim($_REQUEST['actionurl_code']));
        $alt=urldecode(trim($_REQUEST['alt']));
                        
        $sql="update  actionurl set tzsy=".$alt."  where  actionurl_sn= '".$actionurl_code."'";     
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

    
    //$p = new upload;
//    $path=$p->upload_path='upload/actionurl';
//    $p->uplood_img();
//    $img_array = $p->upload_file;
//   
//    for($i=0;$i<count($img_array['guige']);$i++)
//    {
//        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
//    }
//    $aaa = $_POST['actionurl_sn'];
//    // print_r($aaa);exit;
//    //ͼƬ���֡�ûͼƬ��ɾ��
//    img_insert($aaa, $img_array,"actionurl_imgs");
    //�޸�3���������
     $time_field=array(
    //array("type"=>"2","field"=>"add_time","method"=>"1"),
    array("type"=>"2","field"=>"last_update","method"=>"2"),
    array("type"=>"1","field"=>"last_update_2","method"=>"2")
    );
    //print_r($time_field);exit;
    update_actionurl_mx("actionurl","actionurl_name,url,type,sort_no","actionurl_sn",$time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('actionurl_mx.tpl');
}


if ($_REQUEST['act'] == 'post_add') {
      if(isset($_REQUEST['actionurl_sn']))
    {
        $actionurl_sn=trim($_REQUEST['actionurl_sn']);
    }
    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one=" select actionurl_sn from actionurl where actionurl_sn ='".$actionurl_sn."'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($get_one);exit;
    if(empty($res))
    {
        //echo 1;
       // $p = new upload;
//        $path=$p->upload_path='upload/actionurl';
//        $p->uplood_img();
//        $img_array = $p->upload_file;
//        for($i=0;$i<count($img_array['guige']);$i++)
//        {
//        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
//        }
//        //print_r($img_array);exit;
//        $aaa = $actionurl_sn;
//        
//        //����ͼƬ��¼//ͼƬ���֡�ûͼƬ��ɾ��
//         img_insert($aaa, $img_array,"actionurl_imgs");
        //�޸�4���������
        //�����޸ĺ���Ʒ��ϸ
           $time_field=array(
        array("type"=>"2","field"=>"add_time","method"=>"1"),
       // array("type"=>"2","field"=>"last_update","method"=>"2"),
        //array("type"=>"1","field"=>"last_update_2","method"=>"2")
        );
        //�޸�4���������
        //�����޸ĺ���Ʒ��ϸ
        insert_actionurl_mx("actionurl","actionurl_sn,actionurl_name,url,type,sort_no",$time_field);
        
        $smarty->assign('fall', 'post');
        $smarty->display('actionurl_mx.tpl');
    }
    else
    {
        $smarty->assign('fall', 'fs');
        $smarty->display('actionurl_mx.tpl');   
    }
    
  
}



?>