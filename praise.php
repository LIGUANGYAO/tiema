<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_praise.php');

require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
///修改1,查询语句
//sort_no,tzsy 要记得添加
    $sql="select goods_sn,sum(praise_sl) as sl from wx_praise";
    
    
    
    $wx_praise_list = get_wx_praise_list($Num,"wx_praise",$sql);
    
    
   // for($i=0;$i<count($wx_praise_list);$i++)
//    {
//        $sql="select goods_name from goods where goods_sn ='".$wx_praise_list[$i]['goods_sn']."'";
//        $res = $GLOBALS['db']->getRow($sql);
//        $wx_praise_list[$i]['goods_name']=$res['goods_name'];
//    }
//    print_r($wx_praise_list);
    $smarty->assign('wx_praise_list', $wx_praise_list['items']);
     $smarty->assign('fall', 1);
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $wx_praise_list['page']);
    $smarty->display('praise.tpl');


}



if ($_REQUEST['act'] == 'praise_mx') {


    if(isset($_REQUEST['goods_sn']))
    {
            $goods_sn=trim($_REQUEST['goods_sn']);
    }
    
 $sql="select a.goods_sn,b.openid,b.nick_name from wx_praise a inner join users b on a.openid=b.openid where a.goods_sn='".$goods_sn."' order by b.id";
 
 $res = $GLOBALS['db']->getAll($sql);
 //print_r($res);
    
     $smarty->assign('fall', 2);
    $smarty->assign('res', $res);
    
    $smarty->display('praise.tpl');

}




if ($_REQUEST['act'] == 'p_excel') {

  
//引入PHPExcel相关文件  
require_once "phpexcel/PHPExcel.php";  
require_once 'phpexcel/PHPExcel/IOFactory.php';  
require_once 'phpexcel/PHPExcel/Writer/Excel5.php'; 
require_once 'phpexcel/PHPExcel/Writer/Excel2007.php'; 


$fileName = "test_excel";
$headArr = array("第1一列","第二列","第三列");
$data = array(array(1,2),array(1,3),array(5,7));



function getExcel($fileName,$headArr,$data){
    if(empty($data) || !is_array($data)){
        die("data must be a array");
    }
    if(empty($fileName)){
        exit;
    }
    $date = date("Y_m_d",time());
    $fileName .= ".xlsx";

    //创建新的PHPExcel对象
    $objPHPExcel = new PHPExcel();
    $objProps = $objPHPExcel->getProperties();
	
    //设置表头
    $key = ord("A");
    foreach($headArr as $v){
        $colum = chr($key);
        $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
        $key += 1;
    }
    
    $column = 2;
    $objActSheet = $objPHPExcel->getActiveSheet();
    foreach($data as $key => $rows){ //行写入
        $span = ord("A");
        foreach($rows as $keyName=>$value){// 列写入
            $j = chr($span);
            $objActSheet->setCellValue($j.$column, $value);
            $span++;
        }
        $column++;
    }

    $fileName = iconv("utf-8", "gb2312", $fileName);
    //重命名表
    $objPHPExcel->getActiveSheet()->setTitle('Simple');
    //设置活动单指数到第一个表,所以Excel打开这是第一个表
    $objPHPExcel->setActiveSheetIndex(0);
    //将输出重定向到一个客户端web浏览器(Excel2007)
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
          header("Content-Disposition: attachment; filename=\"$fileName\"");
          header('Cache-Control: max-age=0');
          
          header('Pragma:public');
            header('Content-Type:application/x-msexecl;name="$fileName"');
        header("Content-Disposition:inline;filename=\"$fileName\"");


          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
          if(!empty($_GET['excel'])){
            $objWriter->save('php://output'); //文件通过浏览器下载
        }else{
          $objWriter->save($fileName); //脚本方式运行，保存在当前目录
        }
  exit;

}

getExcel($fileName,$headArr,$data);


}



if ($_REQUEST['act'] == 'p_excel2') {



}

if ($_REQUEST['act'] == 'add_wx_praise_list') {

   //$sql="select xmlx_sn ,xmlx_name from xmlx";
//   $res_xmlx = $GLOBALS['db']->getAll($sql);
//    $smarty->assign('res_xmlx', $res_xmlx);
    $smarty->assign('fall', 'add_wx_praise_list');
    $smarty->display('wx_praise_mx.tpl');
}




if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];
    
    ///修改2,查询语句
    $sql="select id,wx_praise_sn,wx_praise_name,sort_no,tzsy,last_update,url,type
  from wx_praise ";
    $wx_praise_mx=get_wx_praise_mx("wx_praise",$sql);
    
   // print_r($wx_praise_mx);exit;
    $img_cod=$_REQUEST['wx_praise_sn'];
    
    
//    //图片部分。没图片则删除
//    $wx_praise_imgs2 = get_wx_praise_imgs_list("wx_praise_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
////print_r($wx_praise_imgs2);
//    $wx_praise_imgs = arr_push($wx_praise_imgs2['items']);
//    $smarty->assign('wx_praise_imgs', $wx_praise_imgs);
    
    
    $smarty->assign('wx_praise_mx', $wx_praise_mx['items'][0]);
    $smarty->assign('res_xmlx', $wx_praise_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('wx_praise_mx.tpl');
}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if(isset($_REQUEST['img_code']))
    {
        $img_code=trim($_REQUEST['img_code']);
                        
        $sql="delete from wx_praise_imgs where  img_outer_id= '".$img_code."'";     
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";                
    }
    else
    {
        echo "失败";
    }
    
    
    
    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}

if ($_REQUEST['act'] == 'delete_wx_praise') {

    //echo 1;
    if(isset($_REQUEST['wx_praise_sn']))
    {
        $wx_praise_sn=trim($_REQUEST['wx_praise_sn']);
                        
        $sql="delete from wx_praise where  wx_praise_sn= '".$wx_praise_sn."'";     
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";                
    }
    else
    {
        echo "失败";
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
                        
        $sql="update  wx_praise_imgs set ss=".$alt."  where  img_outer_id= '".$img_code."'";     
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";                
    }
    else
    {
        echo "失败";
    }
    
    
    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}
if ($_REQUEST['act'] == 'wx_praise_xs') {

    //echo 1;
   
    if(isset($_REQUEST['wx_praise_code']) && isset($_REQUEST['alt']))
    {
        $wx_praise_code=urldecode(trim($_REQUEST['wx_praise_code']));
        $alt=urldecode(trim($_REQUEST['alt']));
                        
        $sql="update  wx_praise set tzsy=".$alt."  where  wx_praise_sn= '".$wx_praise_code."'";     
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";                
    }
    else
    {
        echo "失败";
    }
    
    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}


if ($_REQUEST['act'] == 'post') {

    
    //$p = new upload;
//    $path=$p->upload_path='upload/wx_praise';
//    $p->uplood_img();
//    $img_array = $p->upload_file;
//   
//    for($i=0;$i<count($img_array['guige']);$i++)
//    {
//        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
//    }
//    $aaa = $_POST['wx_praise_sn'];
//    // print_r($aaa);exit;
//    //图片部分。没图片则删除
//    img_insert($aaa, $img_array,"wx_praise_imgs");
    //修改3，更新语句
     $time_field=array(
    //array("type"=>"2","field"=>"add_time","method"=>"1"),
    array("type"=>"2","field"=>"last_update","method"=>"2"),
    array("type"=>"1","field"=>"last_update_2","method"=>"2")
    );
    //print_r($time_field);exit;
    update_wx_praise_mx("wx_praise","wx_praise_name,url,type,sort_no","wx_praise_sn",$time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('wx_praise_mx.tpl');
}


if ($_REQUEST['act'] == 'post_add') {
      if(isset($_REQUEST['wx_praise_sn']))
    {
        $wx_praise_sn=trim($_REQUEST['wx_praise_sn']);
    }
    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one=" select wx_praise_sn from wx_praise where wx_praise_sn ='".$wx_praise_sn."'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($get_one);exit;
    if(empty($res))
    {
        //echo 1;
       // $p = new upload;
//        $path=$p->upload_path='upload/wx_praise';
//        $p->uplood_img();
//        $img_array = $p->upload_file;
//        for($i=0;$i<count($img_array['guige']);$i++)
//        {
//        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
//        }
//        //print_r($img_array);exit;
//        $aaa = $wx_praise_sn;
//        
//        //插入图片记录//图片部分。没图片则删除
//         img_insert($aaa, $img_array,"wx_praise_imgs");
        //修改4，增加语句
        //保存修改后商品明细
           $time_field=array(
        array("type"=>"2","field"=>"add_time","method"=>"1"),
       // array("type"=>"2","field"=>"last_update","method"=>"2"),
        //array("type"=>"1","field"=>"last_update_2","method"=>"2")
        );
        //修改4，增加语句
        //保存修改后商品明细
        insert_wx_praise_mx("wx_praise","wx_praise_sn,wx_praise_name,url,type,sort_no",$time_field);
        
        $smarty->assign('fall', 'post');
        $smarty->display('wx_praise_mx.tpl');
    }
    else
    {
        $smarty->assign('fall', 'fs');
        $smarty->display('wx_praise_mx.tpl');   
    }
    
  
}



?>