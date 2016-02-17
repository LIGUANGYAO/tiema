<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');

error_reporting(NULL);
//require_once 'Classes/PHPExcel/Reader/Excel2007.php';
require_once 'Classes/PHPExcel/Reader/Excel5.php';
include 'Classes/PHPExcel/IOFactory.php';
/*
 * 本函数用于将数组读入excel表单
 * $excelname,输出表单名
 * $title,表头
 * $data数据
 * $times,一维数组还是二给数组，1为一维，2为二维
 */
function arrayToExcel($excelname,$title,$data,$times=1){
$row=1;
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle($title);
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
//$letters_arr = array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E',6=>'F',7=>'G',8=>'H',9=>'I',10=>'J',11=>'K',12=>'L',13=>'M', 14=>'N',15=>'O',16=>'P',17=>'Q',18=>'R',19=>'S',20=>'T',21=>'U',22=>'V',23=>'W',24=>'X',25=>'Y',26=>'Z');
$letters_arr = array(1=>A,2=>B,3=>C,4=>D,5=>E,6=>F,7=>G,8=>H,9=>I,10=>J,11=>K,12=>L,13=>M, 14=>N,15=>O,16=>P,17=>Q,18=>R,19=>S,20=>T,21=>U,22=>V,23=>W,24=>X,25=>Y,26=>Z);
//add data
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
if($times==2){
	$row=2;
	$objPHPExcel->getActiveSheet()->setCellValue('A1', $title);//为单元格赋值
	//$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//设置水平居中 
	//设置A1单元格加粗，居中：
	$styleArray1 = array(
	'font' => array(
	'bold' => true,
	'color'=>array(
	'argb' => '00000000',
	),
	),
	'alignment' => array(
	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	),
	);

// 将A1单元格设置为加粗，居中
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray1);
	foreach($data as $key=>$val){
				$lan=count($val);
				$objPHPExcel->getActiveSheet()->mergeCells('A1:'.$letters_arr[$lan].'1');
                $hight_temp=12.75;
				$key2num=1;//当前列
		foreach($val as $key2=>$val2){
                        //$width=8.43+0.67*(strlen($val2)-10);//长度超过13的加宽
                        //$times=ceil($width/45);//长度超过45的加行高
                        //$width=$width<45?$width:45;
                        $hight=12.75;
                        $hight=$times>1?$hight*$times:$hight;//设置行高
                        $hight_temp=max($hight,$hight_temp);
                        //$objPHPExcel->getActiveSheet()->getColumnDimension($letters_arr[$key2num])->setWidth($width);//设置列宽
						$objPHPExcel->getActiveSheet()->getColumnDimension($letters_arr[$key2num])->setAutoSize(true); //设置列宽自适应  
                        $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight($hight_temp);//设置行高
                        $objPHPExcel->getActiveSheet()->getStyle($letters_arr[$key2num].$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//设置垂直居中 
                        $objPHPExcel->getActiveSheet()->getStyle($letters_arr[$key2num].$row)->getAlignment()->setWrapText(true);//设置文字自动换行
						$objPHPExcel->getActiveSheet()->setCellValue($letters_arr[$key2num].$row, $val2);//为单元格赋值
						$key2num++;
		}
		$row++;
	}
}
elseif($times==1){
	$key2num=1;//当前行
	foreach($data as $key=>$val){
                    $width=8.43+0.67*(strlen($val)-10);//长度超过13的加宽
                    $times=ceil($width/45);//长度超过45的加行高
                    $width=$width<45?$width:45;
                    $hight=12.75;
                    $hight=$times>1?$hight*$times:$hight;//设置行高
                    $objPHPExcel->getActiveSheet()->getStyle($letters_arr[$key2num].$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//设置垂直居中 
                    $objPHPExcel->getActiveSheet()->getColumnDimension($letters_arr[$key2num])->setWidth($width);//设置列宽
                    $objPHPExcel->getActiveSheet()->getRowDimension($key2num-1)->setRowHeight($hight);//设置行高
                    $objPHPExcel->getActiveSheet()->getStyle($letters_arr[$key2num].$row)->getAlignment()->setWrapText(true);//设置文字自动换行
                    $objPHPExcel->getActiveSheet()->setCellValue($letters_arr[$key2num].$row, $val);//为单元格赋值
					$key2num++;
                }
}else{
	exit ('参数有问题');
}
$title=iconv("utf-8","gbk",$excelname);
$file = $title.'.xls';
//phpexcel 保存时可以选择路径 开始
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename=$file");
header('Cache-Control: max-age=0');
$objWriter->save('php://output');
//phpexcel 保存时可以选择路径结束
//$objWriter->save($file);//默认导出phpexcel 保存时不可以选择路径 
}

//$testdata=array('商品1','商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2','aa');
//测试数据$testdata为一维索引数组
//arrayToExcel('测试表名','测试标题',$testdata);
//$testdata2=array('f'=>'商品1','g'=>'商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2','h'=>'aa');
//测试数据$testdata2为一维关联数组
//arrayToExcel('测试表名','测试标题',$testdata2);
//$testdata3=array(array('商品1','商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2','aa'),array('商品1','商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2','aa'));
//测试数据$testdata3为二维索引数组
//arrayToExcel('测试表名','测试标题',$testdata3,2);
//$testdata4=array('a'=>array('f'=>'商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2','g'=>'ggg'),'b'=>array('f'=>'商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2'));
//测试数据$testdata4为二维关联数组
//arrayToExcel('测试表名','测试标题',$testdata4,2);
//$testdata5=array(2=>'商品1',5=>'商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2','aa');
//测试数据$testdata5为一维混合数组
//arrayToExcel('测试表名','测试标题',$testdata5,2);
$testdata6=array(54=>array(3=>'商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2','g'=>'ggg'),'b'=>array(6=>'商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2商品2'));
//测试数据$testdata6为二维混合数组
$testdata6[]=array('aa','bb');
arrayToExcel('测试表名','测试标题',$testdata6,2);
?>