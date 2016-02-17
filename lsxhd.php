<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require_once '/phpexcel/PHPExcel.php';       
require_once '/phpexcel/PHPExcel/Writer/Excel5.php';  




if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
       
        
    // 创建一个处理对象实例       
$objExcel = new PHPExcel();       
      
// 创建文件格式写入对象实例, uncomment       
$objWriter = new PHPExcel_Writer_Excel5($objExcel);      
//设置文档基本属性       
$objProps = $objExcel->getProperties();       
$objProps->setCreator("零售销货单");       
$objProps->setLastModifiedBy("零售销货单2");       
$objProps->setTitle("零售销货单3");       
$objProps->setSubject("零售销货单4");       
$objProps->setDescription("零售销货单5");       
$objProps->setKeywords("零售销货单6");       
$objProps->setCategory("零售销货单7");  


//*************************************       
//设置当前的sheet索引，用于后续的内容操作。       
//一般只有在使用多个sheet的时候才需要显示调用。       
//缺省情况下，PHPExcel会自动创建第一个sheet被设置SheetIndex=0       
$objExcel->setActiveSheetIndex(0);       
$objActSheet = $objExcel->getActiveSheet();       
      
//设置当前活动sheet的名称       
$objActSheet->setTitle('零售销货单');   




//*************************************       
//       
//设置宽度，这个值和EXCEL里的不同，不知道是什么单位，略小于EXCEL中的宽度   
$objActSheet->getColumnDimension('A')->setWidth(20);    
$objActSheet->getColumnDimension('B')->setWidth(10);    
$objActSheet->getColumnDimension('C')->setWidth(6);    
$objActSheet->getColumnDimension('D')->setWidth(20);    
$objActSheet->getColumnDimension('E')->setWidth(12);    
$objActSheet->getColumnDimension('F')->setWidth(10);    
$objActSheet->getColumnDimension('G')->setWidth(20);    
$objActSheet->getColumnDimension('H')->setWidth(18);    
$objActSheet->getColumnDimension('I')->setWidth(12);    
$objActSheet->getColumnDimension('J')->setWidth(8);    
$objActSheet->getColumnDimension('K')->setWidth(8);    
$objActSheet->getColumnDimension('L')->setWidth(12);    
$objActSheet->getColumnDimension('M')->setWidth(10);    
$objActSheet->getColumnDimension('N')->setWidth(10);    
  
$objActSheet->getRowDimension(1)->setRowHeight(30);    
$objActSheet->getRowDimension(2)->setRowHeight(27);    
$objActSheet->getRowDimension(3)->setRowHeight(16);  



//设置单元格的值     
$objActSheet->setCellValue('A1', '零售销货单11'); 



//合并单元格   
$objActSheet->mergeCells('A1:N1');    
//设置样式   
$objStyleA1 = $objActSheet->getStyle('A1');       
$objStyleA1->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objFontA1 = $objStyleA1->getFont();       
$objFontA1->setName('宋体');       
$objFontA1->setSize(18);     
$objFontA1->setBold(true);       
  
//设置居中对齐   
$objActSheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
$objActSheet->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   



$objActSheet->setCellValue('A2', '现所在单位');    
$objActSheet->setCellValue('B2', '姓名');    
$objActSheet->setCellValue('C2', '性别');    
$objActSheet->setCellValue('D2', '身份证号码');    
$objActSheet->setCellValue('E2', '参保时间');    
$objActSheet->setCellValue('F2', '增减原因');    
$objActSheet->setCellValue('G2', '原所在单位');    
$objActSheet->setCellValue('H2', '增减时间');    
$objActSheet->setCellValue('I2', '退休时间');    
$objActSheet->setCellValue('J2', '原工资');    
$objActSheet->setCellValue('K2', '现工资');    
$objActSheet->setCellValue('L2', '定点医院');    
$objActSheet->setCellValue('M2', '操作人');    
$objActSheet->setCellValue('N2', '备注');    


  
$objActSheet->getStyle('A2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('A2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('A2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('A2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('B2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('B2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('B2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('B2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('C2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('C2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('C2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('C2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('D2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('D2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('D2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('D2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('E2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('E2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('E2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('E2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('F2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('F2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('F2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('F2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
            $objActSheet->getStyle('G2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('G2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('G2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('G2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
            $objActSheet->getStyle('H2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('H2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('H2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('H2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('I2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('I2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('I2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('I2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('J2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('J2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('J2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('J2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('K2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('K2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('K2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('K2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('L2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('L2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('L2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('L2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('M2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('M2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('M2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('M2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
            $objActSheet->getStyle('N2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('N2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('N2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('N2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
       
             
        
        $sql="select order_sn from lsxhd";
        $list= $GLOBALS['db']->getAll($sql);
        for($n=0;$n<count($list);$n++)
        {
              $objActSheet->getStyle('B'.$n)->getNumberFormat()->setFormatCode('@');   
    $objActSheet->getStyle('E'.$n)->getNumberFormat()->setFormatCode('@');   
       
    $objActSheet->getRowDimension($n)->setRowHeight(16);    
       
    $objActSheet->getStyle('A'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('A'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('A'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('A'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('B'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('B'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('B'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('B'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('C'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('C'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('C'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('C'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('D'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('D'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('D'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('D'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('E'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('E'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('E'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('E'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('F'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('F'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('F'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('F'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
            $objActSheet->getStyle('G'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('G'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('G'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('G'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
            $objActSheet->getStyle('H'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('H'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('H'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('H'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('I'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('I'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('I'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('I'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('J'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('J'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('J'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('J'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('K'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('K'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('K'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('K'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->getStyle('L'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('L'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('L'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('L'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
            $objActSheet->getStyle('M'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('M'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('M'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('M'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
            $objActSheet->getStyle('N'.$n)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('N'.$n)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('N'.$n)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
    $objActSheet->getStyle('N'.$n)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN );   
        $objActSheet->setCellValue('A'.$n, $list[$n]['order_sn']);    
        }
        $outputFileName = "addminus.xls";       
//到文件       
$objWriter->save($outputFileName);       
        
}



?>