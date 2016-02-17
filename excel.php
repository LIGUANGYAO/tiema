<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');

error_reporting(null);
//require_once 'Classes/PHPExcel/Reader/Excel2007.php';
require_once 'phpexcel/PHPExcel/Reader/Excel5.php';
include 'phpexcel/PHPExcel/IOFactory.php';
/*
* 本函数用于将数组读入excel表单
* $excelname,输出表单名
* $title,表头
* $data数据
* $times,一维数组还是二给数组，1为一维，2为二维
*/


set_time_limit(0);
function arrayToExcel($excelname, $title, $data, $times = 1)
{
    $row = 1;
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle($title);
    $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
    $objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
    //$letters_arr = array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E',6=>'F',7=>'G',8=>'H',9=>'I',10=>'J',11=>'K',12=>'L',13=>'M', 14=>'N',15=>'O',16=>'P',17=>'Q',18=>'R',19=>'S',20=>'T',21=>'U',22=>'V',23=>'W',24=>'X',25=>'Y',26=>'Z');
    $letters_arr = array(
        1 => A,
        2 => B,
        3 => C,
        4 => D,
        5 => E,
        6 => F,
        7 => G,
        8 => H,
        9 => I,
        10 => J,
        11 => K,
        12 => L,
        13 => M,
        14 => N,
        15 => O,
        16 => P,
        17 => Q,
        18 => R,
        19 => S,
        20 => T,
        21 => U,
        22 => V,
        23 => W,
        24 => X,
        25 => Y,
        26 => Z);
    //add data
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    if ($times == 2) {
        $row = 2;
        //	$objPHPExcel->getActiveSheet()->setCellValue('A1', $title);//为单元格赋值

        //$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//设置水平居中
        //设置A1单元格加粗，居中：
        $styleArray1 = array(
            'font' => array(
                'bold' => true,
                'color' => array('argb' => '00000000', ),
                ),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::
                    HORIZONTAL_CENTER, ),
            );

        // 将A1单元格设置为加粗，居中
        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray1);
        foreach ($data as $key => $val) {
            $lan = count($val);
            $objPHPExcel->getActiveSheet()->mergeCells('A1:' . $letters_arr[$lan] . '1');
            $hight_temp = 12.75;
            $key2num = 1; //当前列
            foreach ($val as $key2 => $val2) {
                $width = 8.43 + 0.67 * (strlen($val2) - 10); //长度超过13的加宽
                $times = ceil($width / 45); //长度超过45的加行高
                $width = 20;
                $hight = 12.75;
                $hight = $times > 1 ? $hight * $times : $hight; //设置行高
                $hight_temp = max($hight, $hight_temp);
                $objPHPExcel->getActiveSheet()->getColumnDimension($letters_arr[$key2num])->
                    setWidth($width); //设置列宽
                //$objPHPExcel->getActiveSheet()->getColumnDimension($letters_arr[$key2num])->setAutoSize(true); //设置列宽自适应
                $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight($hight_temp); //设置行高
                $objPHPExcel->getActiveSheet()->getStyle($letters_arr[$key2num] . $row)->
                    getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); //设置垂直居中
                $objPHPExcel->getActiveSheet()->getStyle($letters_arr[$key2num] . $row)->
                    getAlignment()->setWrapText(true); //设置文字自动换行
                $objPHPExcel->getActiveSheet()->setCellValueExplicit($letters_arr[$key2num] . $row,
                    $val2); //为单元格赋值
                $key2num++;
            }
            $row++;
        }
    } elseif ($times == 1) {
        $key2num = 1; //当前行
        foreach ($data as $key => $val) {
            $width = 8.43 + 0.67 * (strlen($val) - 10); //长度超过13的加宽
            $times = ceil($width / 45); //长度超过45的加行高
            $width = $width < 45 ? $width : 45;
            $hight = 12.75;
            $hight = $times > 1 ? $hight * $times : $hight; //设置行高
            $objPHPExcel->getActiveSheet()->getStyle($letters_arr[$key2num] . $row)->
                getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); //设置垂直居中
            $objPHPExcel->getActiveSheet()->getColumnDimension($letters_arr[$key2num])->
                setWidth($width); //设置列宽
            $objPHPExcel->getActiveSheet()->getRowDimension($key2num - 1)->setRowHeight($hight); //设置行高
            $objPHPExcel->getActiveSheet()->getStyle($letters_arr[$key2num] . $row)->
                getAlignment()->setWrapText(true); //设置文字自动换行
            $objPHPExcel->getActiveSheet()->setCellValue($letters_arr[$key2num] . $row, $val); //为单元格赋值
            $key2num++;
        }
    } else {
        exit('参数有问题');
    }
    $title = iconv("utf-8", "gbk", $excelname);
    $file = $title . '.xls';
    //phpexcel 保存时可以选择路径 开始
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename=$file");
    header('Pragma:public');
    header('Content-Type:application/x-msexecl;name=$file');
    header("Content-Disposition:inline;filename=$file");

    header('Cache-Control: max-age=0');
    $objWriter->save('php://output');
    //phpexcel 保存时可以选择路径结束
    //$objWriter->save($file);//默认导出phpexcel 保存时不可以选择路径
}


if (empty($_REQUEST['m'])) {
    $_REQUEST['m'] = 'default';
} else {
    $_REQUEST['m'] = trim($_REQUEST['m']);
}


if ($_REQUEST['m'] == 'praise') {
    $sql = "select goods_sn,sum(praise_sl) as sl from wx_praise group by goods_sn order by sum(praise_sl) desc";

    $res = $GLOBALS['db']->getAll($sql);


    $arr = array(array("商品名称", "数量"));
    for ($i = 0; $i < count($res); $i++) {
        array_push($arr, $res[$i]);
    }

    // arrayToExcel('2','2',$res,2);

    //print_r($arr);exit;
    arrayToExcel('测试表名', '关注度排名', $arr, 2);

}


if ($_REQUEST['m'] == 'cj_count') {


    $sql = "select openid,cj_sn,cj_name,cj_type,tzsy,add_time,last_update_2 from cj_qrcode_stat  order by add_time ";

    $res = $GLOBALS['db']->getAll($sql);

    $sl = ceil(count($res) / 5000);
    echo $sl;


}

if ($_REQUEST['m'] == 'cj_qrcode_stat') {
    if (isset($_REQUEST['sl'])) {

        $sl = trim($_REQUEST['sl']);

        //$num 20/页面显示 limit数量，$page_no显示第几页select * from action limit 0,20
        function limit_array($page_no, $num)
        {
            if (isset($page_no) && isset($num)) {

                $limit = " limit " . $page_no . "," . $num;
                return $limit;
            } else {
                return false;
            }

        }
        $limit = limit_array($sl * 5000, 5000);

        $sql = "select openid,cj_sn,cj_name,cj_type,tzsy,add_time,last_update_2 from cj_qrcode_stat  order by add_time " .
            $limit;

        $res = $GLOBALS['db']->getAll($sql);


        $arr = array(array(
                "关注openid",
                "场景代码",
                "场景名称",
                "类型",
                "是否使用",
                "添加时间",
                "添加日期"));
        for ($i = 0; $i < count($res); $i++) {
            array_push($arr, $res[$i]);

        }
        arrayToExcel('场景二维码 ' . ($sl + 1), '场景二维码' . ($sl + 1), $arr, 2);
    }


    //    id	mediumint	8	0	0	-1	-1	0	0		0					-1	0
    //openid	varchar	250	0	-1	0	0	0	0		0	用户的唯一身份ID	utf8	utf8_general_ci		0	0
    //issubs	int	10	0	-1	0	0	0	0		0	是否关注时				0	0
    //cj_sn	varchar	30	0	-1	0	0	0	0		0	二维码场景ID	utf8	utf8_general_ci		0	0
    //cj_name	varchar	50	0	-1	0	0	0	0		0	场景名称	utf8	utf8_general_ci		0	0
    //cj_type	varchar	50	0	-1	0	0	0	0		0		utf8	utf8_general_ci		0	0
    //qrcid	varchar	10	0	-1	0	0	0	0		0		utf8	utf8_general_ci		0	0
    //tzsy	int	11	0	-1	0	0	0	0	0	0					0	0
    //sort_no	int	20	0	-1	0	0	0	0	0	0					0	0
    //add_time	datetime	0	0	-1	0	0	0	0		0					0	0
    //last_update	timestamp	0	0	-1	0	0	0	0		-1					0	0
    //last_update_2	date	0	0	-1	0	0	0	0		0					0	0


}


if ($_REQUEST['m'] == 'tj_fxfc') {
    
    $time = $_REQUEST['t1'];
    $time2 = $_REQUEST['t2'];
    $order_status = $_REQUEST['order_status'];

   
    if (isset($_REQUEST['t2']) and isset($_REQUEST['t1'])) {

        $filer1 = " where a.queren_time between '" . trim($_REQUEST['t1']) .
            " 00:00:00' and '" . trim($_REQUEST['t2']) . " 23:59:59' ";
            

    } else {
        $filer1 = '';
    }
    
    function fc1_bj($p_id, $tp, $fenc,$res)
    {

            
         

        $get_tpoint = "select  *,point from tgpoint where p_id='" . $p_id .
            "' and p_type=1"; //print_r($get_tpoint);
        $get_tpoint = $GLOBALS['db']->getAll($get_tpoint);
        
        for($j=0;$j<count($get_tpoint);$j++)
        {
            $zongpoint+=$get_tpoint[$j]['point'];
        }
        
        
        $res['fc'] = $res['order_total_price'] - $res['ori_price_total'] *$zongpoint / 100;
        $res['djfc'] = $res['order_total_price'] - $res['ori_price_total'] *$zongpoint / 100;
        //echo $res[$j]['fc']." ".$res[$j]['ori_price_total'] *$fenc / 100;
        if ($res['or_status'] == '0') {
            $wqrje += $res['fc'];
        } elseif ($res['or_status'] == '1') {
            $yqrje += $res['fc'];
        } else {
            $tkje += $res['fc'];
        } 
        
        
        
       //print_r($res);exit;
        
        
        for($j=0;$j<count($get_tpoint);$j++)
        {
            $arr['fencheng'][$j]['list']=$get_tpoint[$j];
            if($zongpoint==0)
            {
                $arr['fencheng'][$j]['fc']= 0;
                $arr['fencheng'][$j]['djfc']=0;
            }
            else
            {
            $arr['fencheng'][$j]['fc']= sprintf("%.2f", $res['fc']*$get_tpoint[$j]['point']/$zongpoint);
            $arr['fencheng'][$j]['djfc']=sprintf("%.2f", $res['djfc']*$get_tpoint[$j]['point']/$zongpoint);
            }
            
        }
        

        $arr['wqrje'] = $wqrje;
        $arr['yqrje'] = $yqrje;
        $arr['tkje'] = $tkje;

        $wqrje = 0;
        $yqrje = 0;
        $tkje = 0;
        //$arr['fxfc'] = $res;

        $zfc = 0;
        $zbl = 0;
        $zje = 0;
        $wqje = 0;
        $zcje = 0;

        return $arr;
    }
    
    
    function fc2_bj($p_id, $tp, $fenc,$res)
    {

            
         

        $get_tpoint = "select  *,point from tgpoint where p_id='" . $p_id .
            "' and p_type=2"; //print_r($get_tpoint);
        $get_tpoint = $GLOBALS['db']->getAll($get_tpoint);
        
        for($j=0;$j<count($get_tpoint);$j++)
        {
            $zongpoint+=$get_tpoint[$j]['point'];
        }
        
        
        $res['fc'] = $res['order_total_price'] - $res['ori_price_total'] *$zongpoint / 100;
        $res['djfc'] = $res['order_total_price'] - $res['ori_price_total'] *$zongpoint / 100;
        //echo $res[$j]['fc']." ".$res[$j]['ori_price_total'] *$fenc / 100;
        if ($res['or_status'] == '0') {
            $wqrje += $res['fc'];
        } elseif ($res['or_status'] == '1') {
            $yqrje += $res['fc'];
        } else {
            $tkje += $res['fc'];
        } 
        
        
        
       //print_r($res);exit;
        
        
        for($j=0;$j<count($get_tpoint);$j++)
        {
            $arr['fencheng'][$j]['list']=$get_tpoint[$j];
            if($zongpoint==0)
            {
                $arr['fencheng'][$j]['fc']= 0;
                $arr['fencheng'][$j]['djfc']=0;
            }
            else
            {
            $arr['fencheng'][$j]['fc']= sprintf("%.2f", $res['fc']*$get_tpoint[$j]['point']/$zongpoint);
            $arr['fencheng'][$j]['djfc']=sprintf("%.2f", $res['djfc']*$get_tpoint[$j]['point']/$zongpoint);
            }
            
        }
        

        $arr['wqrje'] = $wqrje;
        $arr['yqrje'] = $yqrje;
        $arr['tkje'] = $tkje;

        $wqrje = 0;
        $yqrje = 0;
        $tkje = 0;
        //$arr['fxfc'] = $res;

        $zfc = 0;
        $zbl = 0;
        $zje = 0;
        $wqje = 0;
        $zcje = 0;

        return $arr;
    }
    
    
    function fc3_bj($p_id, $tp, $fenc,$res)
    {

            
         

        $get_tpoint = "select  *,point from tgpoint where p_id='" . $p_id .
            "' and p_type=3"; //print_r($get_tpoint);
        $get_tpoint = $GLOBALS['db']->getAll($get_tpoint);
        
        for($j=0;$j<count($get_tpoint);$j++)
        {
            $zongpoint+=$get_tpoint[$j]['point'];
        }
        //print_r($zongpoint) ."<br>";
        //($res['order_total_price'] - $res['order_express_price']) *$tgshop['point'] / 100;
        
         $res['fc'] = ($res['order_total_price'] - $res['order_express_price'] )*$zongpoint / 100;
        $res['djfc'] = ($res['order_total_price'] - $res['order_express_price']) *$zongpoint / 100;
        //echo $res[$j]['fc']." ".$res[$j]['ori_price_total'] *$fenc / 100;
        if ($res['or_status'] == '0') {
            $wqrje += $res['fc'];
        } elseif ($res['or_status'] == '1') {
            $yqrje += $res['fc'];
        } else {
            $tkje += $res['fc'];
        } 
        
        
        
       //print_r($res);exit;
        
        
        for($j=0;$j<count($get_tpoint);$j++)
        {
            $arr['fencheng'][$j]['list']=$get_tpoint[$j];
            if($zongpoint==0)
            {
                $arr['fencheng'][$j]['fc']= 0;
                $arr['fencheng'][$j]['djfc']=0;
            }
            else
            {
            $arr['fencheng'][$j]['fc']= sprintf("%.2f", $res['fc']*$get_tpoint[$j]['point']/$zongpoint);
            $arr['fencheng'][$j]['djfc']=sprintf("%.2f", $res['djfc']*$get_tpoint[$j]['point']/$zongpoint);
            }
            
        }
        

        $arr['wqrje'] = $wqrje;
        $arr['yqrje'] = $yqrje;
        $arr['tkje'] = $tkje;

        $wqrje = 0;
        $yqrje = 0;
        $tkje = 0;
        //$arr['fxfc'] = $res;

        $zfc = 0;
        $zbl = 0;
        $zje = 0;
        $wqje = 0;
        $zcje = 0;

        return $arr;
    }
    //通过渠道代码和商店代码获取分成比例和计算分成   //计算渠道分成
    function fc1_qd_sd($qddm,$dpdm,$res)
    {
        $tgshop = "select  point from tgpoint_shop where p_id='" . $qddm .
                "' and shop_sn='" . $dpdm . "'"; 
                
        $tgshop = $GLOBALS['db']->getRow($tgshop);
        
        //判断如果没有设置则默认渠道的默认商店店铺
        if($tgshop['point']==0)
        {
            $tgshop = "select  sdpoint as point from qudao where qudao_sn='" . $qddm .
                "' "; 
               
            $tgshop = $GLOBALS['db']->getRow($tgshop);
        }
        //print_r($tgshop);
        
        //order_total_price 是单价   ori_price_total是标准价
        $res['fc'] =$res['ori_price_total'] * $tgshop['point'] / 100;
        $res['djfc'] = $res['ori_price_total'] * $tgshop['point'] / 100;
        
        if ($res['or_status'] == '0') {
            $wqrje += $res['fc'];
        } elseif ($res['or_status'] == '1') {
            $yqrje += $res['fc'];
        } else {
            $tkje += $res['fc'];
        } 
        //print_r($res);exit;
        $get_tpoint = "select  *,point from tgpoint where p_id='" . $qddm .
                "' and p_type=1"; //print_r($get_tpoint);
        $get_tpoint = $GLOBALS['db']->getAll($get_tpoint);
        //print_r($get_tpoint);exit;
         $arr=array();
        for($j=0;$j<count($get_tpoint);$j++)
        {
            $zongpoint+=$get_tpoint[$j]['point'];
        }
       
        for($j=0;$j<count($get_tpoint);$j++)
        {
            $arr['fencheng'][$j]['list']=$get_tpoint[$j];
            if($zongpoint==0)
            {
                $arr['fencheng'][$j]['fc']= 0;
                $arr['fencheng'][$j]['djfc']=0;
            }
            else
            {
                $arr['fencheng'][$j]['fc']= sprintf("%.2f", $res['fc']*$get_tpoint[$j]['point']/$zongpoint);
                $arr['fencheng'][$j]['djfc']=sprintf("%.2f", $res['djfc']*$get_tpoint[$j]['point']/$zongpoint);
            }
            
            
            
        }
        
        
        $arr['wqrje'] = $wqrje;
        $arr['yqrje'] = $yqrje;
        $arr['tkje'] = $tkje;

        $wqrje = 0;
        $yqrje = 0;
        $tkje = 0;
        //$arr['fxfc'] = $res;

        $zfc = 0;
        $zbl = 0;
        $zje = 0;
        $wqje = 0;
        $zcje = 0;
        //print_r($arr);exit;
        return $arr;
        
    }
    
    
    
    function fc1_qd_dg($qddm,$dpdm,$res)
    {
        $tgshop = "select  b_id,point from tgpoint_sales where p_id='" . $qddm .
                "' and sales_sn='" . $dpdm . "'"; 
               
        $tgshop = $GLOBALS['db']->getRow($tgshop);
        $qddm=$tgshop['b_id'];
        
        
        //判断如果没有设置则默认渠道的默认商店店铺
        if($tgshop['point']==0)
        {
            $tgshop = "select  dgpoint as point from qudao where qudao_sn='" . $qddm .
                "' "; 
               
            $tgshop = $GLOBALS['db']->getRow($tgshop);
        }
         //print_r($tgshop);
        //print_r($qddm);
        //order_total_price 是单价   ori_price_total是标准价
        $res['fc'] =$res['ori_price_total'] * $tgshop['point'] / 100;
        $res['djfc'] = $res['ori_price_total'] * $tgshop['point'] / 100;
        
        if ($res['or_status'] == '0') {
            $wqrje += $res['fc'];
        } elseif ($res['or_status'] == '1') {
            $yqrje += $res['fc'];
        } else {
            $tkje += $res['fc'];
        } 
        //print_r($res);
        $get_tpoint = "select  *,point from tgpoint where p_id='" . $qddm .
                "' and p_type=1"; //print_r($get_tpoint);
        $get_tpoint = $GLOBALS['db']->getAll($get_tpoint);
    //    print_r($get_tpoint);
         $arr=array();
        for($j=0;$j<count($get_tpoint);$j++)
        {
            $zongpoint+=$get_tpoint[$j]['point'];
        }
       
        for($j=0;$j<count($get_tpoint);$j++)
        {
            $arr['fencheng'][$j]['list']=$get_tpoint[$j];
            if($zongpoint==0)
            {
                $arr['fencheng'][$j]['fc']= 0;
                $arr['fencheng'][$j]['djfc']=0;
            }
            else
            {
                $arr['fencheng'][$j]['fc']= sprintf("%.2f", $res['fc']*$get_tpoint[$j]['point']/$zongpoint);
                $arr['fencheng'][$j]['djfc']=sprintf("%.2f", $res['djfc']*$get_tpoint[$j]['point']/$zongpoint);
            }
            
            
            
        }
        
        
        $arr['wqrje'] = $wqrje;
        $arr['yqrje'] = $yqrje;
        $arr['tkje'] = $tkje;

        $wqrje = 0;
        $yqrje = 0;
        $tkje = 0;
        //$arr['fxfc'] = $res;

        $zfc = 0;
        $zbl = 0;
        $zje = 0;
        $wqje = 0;
        $zcje = 0;
        //print_r($arr);exit;
        return $arr;
        
    }
    
    
    function fc2_sd_dg($qddm,$dpdm,$res)
    {
      //  $tgshop = "select  b_id,point from tgpoint_sales where p_id='" . $qddm .
//                "' and sales_sn='" . $dpdm . "'"; 
//               
//        $tgshop = $GLOBALS['db']->getRow($tgshop);
//        $qddm=$tgshop['b_id'];
//        
//        
//        //判断如果没有设置则默认渠道的默认商店店铺
//        if($tgshop['point']==0)
//        {
            $tgshop = "select  dgpoint as point from shop where shop_sn='" . $qddm .
                "' "; 
               
            $tgshop = $GLOBALS['db']->getRow($tgshop);
        //}
         //print_r($tgshop);
        //print_r($qddm);
        //order_total_price 是单价   ori_price_total是标准价
        $res['fc'] =round($res['order_total_price'] *(($res['order_total_price']-$res['ori_price_total'] *$tgshop['point'] / 100) /$res['order_total_price']-10/100));
        $res['djfc'] = round($res['order_total_price'] *(($res['order_total_price']-$res['ori_price_total'] *$tgshop['point'] / 100) /$res['order_total_price']-10/100));
        //$res['fc'] =($res['order_total_price'] - $res['order_express_price']) *
//                $tgshop['point'] / 100;
//        $res['djfc'] = round($res['order_total_price'] *(($res['order_total_price']-$res['ori_price_total'] *$fenc / 100) /$res['order_total_price']-10/100));
                
      
        //echo $res['order_total_price'] - $res['order_express_price'];
        
        if ($res['or_status'] == '0') {
            $wqrje += $res['fc'];
        } elseif ($res['or_status'] == '1') {
            $yqrje += $res['fc'];
        } else {
            $tkje += $res['fc'];
        } 
        //print_r($res);
        $get_tpoint = "select  *,point from tgpoint where p_id='" . $qddm .
                "' and p_type=2"; //print_r($get_tpoint);
        $get_tpoint = $GLOBALS['db']->getAll($get_tpoint);
        //print_r($get_tpoint);
         $arr=array();
        for($j=0;$j<count($get_tpoint);$j++)
        {
            $zongpoint+=$get_tpoint[$j]['point'];
        }
       
        for($j=0;$j<count($get_tpoint);$j++)
        {
            $arr['fencheng'][$j]['list']=$get_tpoint[$j];
            if($zongpoint==0)
            {
                $arr['fencheng'][$j]['fc']= 0;
                $arr['fencheng'][$j]['djfc']=0;
            }
            else
            {
                $arr['fencheng'][$j]['fc']= sprintf("%.2f", $res['fc']*$get_tpoint[$j]['point']/$zongpoint);
                $arr['fencheng'][$j]['djfc']=sprintf("%.2f", $res['djfc']*$get_tpoint[$j]['point']/$zongpoint);
            }
            
            
            
        }
        
        
        $arr['wqrje'] = $wqrje;
        $arr['yqrje'] = $yqrje;
        $arr['tkje'] = $tkje;

        $wqrje = 0;
        $yqrje = 0;
        $tkje = 0;
        //$arr['fxfc'] = $res;

        $zfc = 0;
        $zbl = 0;
        $zje = 0;
        $wqje = 0;
        $zcje = 0;
        //print_r($arr);exit;
        return $arr;
        
    }
    
    //echo $t1.$t2;
    function fenc_mx($p_id, $tp, $fenc)
    {
        $zfc = 0;
        $zbl = 0;
        $zje = 0;
        $wqje = 0;
        $zcje = 0;


        $sql_g = "select a.product_price,a.order_total_price,a.order_status,case when a.order_status=2 then '待发货' when a.order_status=3 then '已发货' when a.order_status=5 then '已完成' when a.order_status=8 then '维权' end  as status_name,a.order_express_price,a.buyer_nick,a.buyer_openid,b.cj_sn,b.cj_type, from_unixtime(a.order_create_time) as order_create_time,a.order_sn  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid where cj_type='" .
            $tp . "' and cj_sn='" . $p_id .
            "' and  from_unixtime( a.order_create_time) between '" . trim($_REQUEST['t1']) .
            "' and '" . trim($_REQUEST['t2']) .
            "' group by b.openid,a.order_sn order by b.add_time desc   ";

        //print_r($sql_g);
        $res = $GLOBALS['db']->getAll($sql_g); //设置分成
        for ($j = 0; $j < count($res); $j++) {
            $res[$j]['fc'] = ($res[$j]['order_total_price'] - $res[$j]['order_express_price']) *
                $fenc / 100;
            $zfc += $res[$j]['fc'];
            $zbl += $res[$j]['point'];
            if ($res[$j]['order_status'] == 8) {
                $wqje += $res[$j]['order_total_price'];
            } else {
                $zcje += $res[$j]['order_total_price'];
            }

        }

        $arr = array(); //显示明细数据
        //$arr['list']=$res;

        $arr['zfc'] = $zfc;
        $arr['zbl'] = $zbl; //$arr['zbl'] = $fenc;
        //正常金额
        $arr['zcje'] = $zcje; //维权金额
        $arr['wqje'] = $wqje;
        $arr['sjje'] = $fenc * $zcje / 100;
        $arr['zje'] = $wqje + $zcje;
        $zfc = 0;
        $zbl = 0;
        $zje = 0;
        $wqje = 0;
        $zcje = 0;
        return $arr;
    }
    function tg_shop($p_id,$p_id2='')
    {
        $zongfc = 0;
        $t1 = date('Y-m-d H:i:s', time());
        $sql = "select a.qudao_sn,a.qudao_name,b.shop_sn,b.shop_name,a.sdpoint,a.dgpoint from qudao a inner join shop b on a.qudao_sn=b.p_id where a.qudao_sn ='" .
            $p_id . "' and b.shop_sn='".$p_id2."' order by a.id desc";
        $res = $GLOBALS['db']->getAll($sql);
        //print_r($res);exit;
        $list = array();
        for ($i = 0; $i < count($res); $i++) {

            $get_tpoint = "select  point from tgpoint_shop where p_id='" . $p_id .
                "' and shop_sn='" . $res[$i]['shop_sn'] . "'"; //print_r($get_tpoint);
            $get_tpoint = $GLOBALS['db']->getRow($get_tpoint);
            if (!empty($get_tpoint) && $get_tpoint['point'] != 0) {
                $res[$i]['sdpoint'] = $get_tpoint['point'];
            }

            $res[$i]['sdfc'] = fenc_mx($res[$i]['shop_sn'], "shop", $res[$i]['sdpoint']);
            $zongfc += $res[$i]['sdfc']['zfc'];
        }
        return array("res" => $res, "zongfc" => $zongfc);
    }
    function tg_sales($p_id)
    {
        $t1 = date('Y-m-d H:i:s', time());
        $sql = "select a.qudao_sn,a.qudao_name,b.shop_sn,b.shop_name,a.sdpoint,a.dgpoint,c.sales_sn,c.sales_name from qudao a inner join shop b on a.qudao_sn=b.p_id inner join sales c on b.shop_sn=c.p_id where a.qudao_sn ='" .
            $p_id . "' and b.shop_sn='".$p_id2."' order by a.id desc";
        $res = $GLOBALS['db']->getAll($sql);
        $list = array();
        for ($i = 0; $i < count($res); $i++) {

            $get_tpoint = "select  point from tgpoint_sales where p_id='" . $p_id .
                "' and sales_sn='" . $res[$i]['sales_sn'] . "'"; //print_r($get_tpoint);
            $get_tpoint = $GLOBALS['db']->getRow($get_tpoint);
            if (!empty($get_tpoint) && $get_tpoint['point'] != 0) {
                $res[$i]['dgpoint'] = $get_tpoint['point'];
            }

            $res[$i]['dgfc'] = fenc_mx($res[$i]['sales_sn'], "sales", $res[$i]['dgpoint']);
            $zongfc += $res[$i]['dgfc']['zfc'];
        }
        return array("res" => $res, "zongfc" => $zongfc);
    }


    //开始计算店铺下属导购的分成比例


    function shop_to_sales($p_id)
    {
        $t1 = date('Y-m-d H:i:s', time());
        $sql = "select a.shop_sn,a.shop_name,a.dgpoint,b.sales_sn,b.sales_name from shop a inner join sales b on a.shop_sn=b.p_id where a.shop_sn='" .
            $p_id . "' order by a.id desc";
        $res = $GLOBALS['db']->getAll($sql);
        $list = array();
        for ($i = 0; $i < count($res); $i++) {

            //   $get_tpoint = "select  point from tgpoint_sales where p_id='" . $p_id .
            //                            "' and sales_sn='" . $res[$i]['sales_sn'] . "'";
            //                        //print_r($get_tpoint);
            //                        $get_tpoint = $GLOBALS['db']->getRow($get_tpoint);
            //                        if (!empty($get_tpoint) && $get_tpoint['point'] != 0) {
            //                            $res[$i]['dgpoint'] = $get_tpoint['point'];
            //                        }

            $res[$i]['sd_dgfc'] = fenc_mx($res[$i]['sales_sn'], "sales", $res[$i]['dgpoint']);
            $zongfc += $res[$i]['sd_dgfc']['zfc'];
        }
        //print_r($res);
        return array("res" => $res, "zongfc" => $zongfc);
    }

    //--------

    //$sql = "select a.product_price,a.order_total_price,a.order_status,a.order_express_price,a.buyer_nick,a.buyer_openid,b.cj_sn,b.cj_type, from_unixtime(a.order_create_time) as order_create_time,a.order_sn  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid   ";
    
    $sql="select b.add_time,b.id,a.product_price,a.product_count,a.order_total_price,a.order_status,a.order_express_price,a.buyer_nick,a.buyer_openid,b.cj_sn,b.cj_type, from_unixtime(a.order_create_time) as order_create_time,a.order_sn,a.or_status,queren_time,a.ori_price,a.ori_price_total,a.bz  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid    ".$filer1." group by a.order_sn order by from_unixtime( a.order_create_time) desc,b.id desc ";
    
    $tj_fxfc_list['items'] = $GLOBALS['db']->getAll($sql);;
    
 //echo $time;
    for ($i = 0; $i < count($tj_fxfc_list['items']); $i++) {
        if ($tj_fxfc_list['items'][$i]['cj_type'] == "qudao") {
            $sql = "select qudao_sn,qudao_name from qudao where qudao_sn='" . $tj_fxfc_list['items'][$i]['cj_sn'] .
                "' and tzsy=0";
            $res = $GLOBALS['db']->getRow($sql);
            
            
            $tj_fxfc_list['items'][$i]['fc1'] = fc1_bj($res['qudao_sn'], 'qudao', $res['dgpoint'],$tj_fxfc_list['items'][$i]);
            
            $tj_fxfc_list['items'][$i]['qudao_sn'] = $res['qudao_sn'];
            $tj_fxfc_list['items'][$i]['qudao_name'] = $res['qudao_name'];
            $tj_fxfc_list['items'][$i]['p_tp'] = 1; //开始测试增加渠道


            
        } elseif ($tj_fxfc_list['items'][$i]['cj_type'] == "shop") {
            $sql = "select shop_sn,shop_name,p_id,dgpoint from shop where shop_sn='" . $tj_fxfc_list['items'][$i]['cj_sn'] .
                "'  and tzsy=0";
            $res = $GLOBALS['db']->getRow($sql);
            
            $tj_fxfc_list['items'][$i]['fc1'] = fc1_qd_sd($res['p_id'],$res['shop_sn'],$tj_fxfc_list['items'][$i]);
            
            $tj_fxfc_list['items'][$i]['fc2'] = fc2_bj($res['shop_sn'], 'shop', $res['dgpoint'],$tj_fxfc_list['items'][$i]);
            
            //print_r($tj_fxfc_list['items'][$i]);exit;
            
            //店铺需要两个部分、需要算本级的分成，和上级渠道的分成
            //本级
            
            
            
            
            $tj_fxfc_list['items'][$i]['qudao_sn'] = $res['shop_sn'];
            $tj_fxfc_list['items'][$i]['qudao_name'] = $res['shop_name'];
            $tj_fxfc_list['items'][$i]['p_tp'] = 2;
            
        } elseif ($tj_fxfc_list['items'][$i]['cj_type'] == "sales") {
            $sql = "select sales_sn,sales_name,p_id from sales where sales_sn='" . $tj_fxfc_list['items'][$i]['cj_sn'] .
                "'  and tzsy=0";
            $res = $GLOBALS['db']->getRow($sql);
            
            
            $tj_fxfc_list['items'][$i]['fc1'] = fc1_qd_dg($res['p_id'],$res['sales_sn'],$tj_fxfc_list['items'][$i]);
            $tj_fxfc_list['items'][$i]['fc2'] = fc2_sd_dg($res['p_id'],$res['sales_sn'],$tj_fxfc_list['items'][$i]);
            $tj_fxfc_list['items'][$i]['fc3'] = fc3_bj($res['sales_sn'], 'sales', $res['dgpoint'],$tj_fxfc_list['items'][$i]);
            
            
            $tj_fxfc_list['items'][$i]['qudao_sn'] = $res['sales_sn'];
            $tj_fxfc_list['items'][$i]['qudao_name'] = $res['sales_name'];
            $tj_fxfc_list['items'][$i]['p_tp'] = 3;
        }
        
        //$get_tgpoint = "select  p_type,p_id,users_sn,nick_name,point from tgpoint where p_id='" .
//            $tj_fxfc_list['items'][$i]['qudao_sn'] . "' and  p_type='" . $tj_fxfc_list['items'][$i]['p_tp'] .
//            "' ";
//        $tj_fxfc_list['items'][$i]['tg'] = $GLOBALS['db']->getAll($get_tgpoint);
//        for ($j = 0; $j < count($tj_fxfc_list['items'][$i]['tg']); $j++) {
//            $tj_fxfc_list['items'][$i]['tg'][$j]['fc'] = ($tj_fxfc_list['items'][$i]['order_total_price'] -
//                $tj_fxfc_list['items'][$i]['order_express_price']) * $tj_fxfc_list['items'][$i]['tg'][$j]['point'] /
//                100;
//            $zfc += $tj_fxfc_list['items'][$i]['tg'][$j]['fc'];
//            $zbl += $tj_fxfc_list['items'][$i]['tg'][$j]['point'];
//        }
//        $tj_fxfc_list['items'][$i]['zfc'] = $zfc;
//        $tj_fxfc_list['items'][$i]['zbl'] = $zbl;
//        $zfc = 0;
//        $zbl = 0;
    }
    //print_r($tj_fxfc_list);exit;
    //print_r($tj_fxfc_list);
   
   
   
   
   
   
   
    $res = $tj_fxfc_list['items'];
    
    
    $textarr=array();
    for($i=0;$i<count($res);$i++)
    {
        $fc1=$res[$i]['fc1'];
        $fc2=$res[$i]['fc2'];
        $fc3=$res[$i]['fc3'];
        for($j=0;$j<count($fc1['fencheng']);$j++)
        {
            if($res[$i]['cj_type']=="qudao")
            {
                $getarr['cj_type']="渠道";
            }
            elseif($res[$i]['cj_type']=="shop")
            {
                $getarr['cj_type']="店铺";
            }
            elseif($res[$i]['cj_type']=="sales")
            {
                $getarr['cj_type']="导购";
            }
            
            $getarr['openid']=$fc1['fencheng'][$j]['list']['openid'];
            $getarr['users_sn']=$fc1['fencheng'][$j]['list']['users_sn'];
            $getarr['nick_name']=$fc1['fencheng'][$j]['list']['nick_name'];
            
            $getarr['order_sn']=$res[$i]['order_sn'];
            $getarr['order_create_time']=$res[$i]['order_create_time'];
            $getarr['queren_time']=$res[$i]['queren_time'];
            
            $getarr['product_price']=$res[$i]['product_price'];
            $getarr['order_total_price']=$res[$i]['order_total_price'];
            $getarr['ori_price']=$res[$i]['ori_price'];
            $getarr['ori_price_total']=$res[$i]['ori_price_total'];
            
            
            
            
            $getarr['leixing']="渠道级别分成";
            $getarr['fc']=$fc1['fencheng'][$j]['fc'];
            $getarr['zfc']=$fc1['yqrje'];
            
            array_push($textarr,$getarr);
           
        }
        for($j=0;$j<count($fc2['fencheng']);$j++)
        {
            if($res[$i]['cj_type']=="qudao")
            {
                $getarr['cj_type']="渠道";
            }
            elseif($res[$i]['cj_type']=="shop")
            {
                $getarr['cj_type']="店铺";
            }
            elseif($res[$i]['cj_type']=="sales")
            {
                $getarr['cj_type']="导购";
            }
            
            $getarr['openid']=$fc2['fencheng'][$j]['list']['openid'];
            $getarr['users_sn']=$fc2['fencheng'][$j]['list']['users_sn'];
            $getarr['nick_name']=$fc2['fencheng'][$j]['list']['nick_name'];
            
            $getarr['order_sn']=$res[$i]['order_sn'];
            $getarr['order_create_time']=$res[$i]['order_create_time'];
            $getarr['queren_time']=$res[$i]['queren_time'];
            
            $getarr['product_price']=$res[$i]['product_price'];
            $getarr['order_total_price']=$res[$i]['order_total_price'];
            $getarr['ori_price']=$res[$i]['ori_price'];
            $getarr['ori_price_total']=$res[$i]['ori_price_total'];
            
            
            
            
            $getarr['leixing']="店铺级别分成";
            $getarr['fc']=$fc2['fencheng'][$j]['fc'];
            $getarr['zfc']=$fc2['yqrje'];
            
            array_push($textarr,$getarr);
           
        }
        for($j=0;$j<count($fc3['fencheng']);$j++)
        {
            if($res[$i]['cj_type']=="qudao")
            {
                $getarr['cj_type']="渠道";
            }
            elseif($res[$i]['cj_type']=="shop")
            {
                $getarr['cj_type']="店铺";
            }
            elseif($res[$i]['cj_type']=="sales")
            {
                $getarr['cj_type']="导购";
            }
            
            $getarr['openid']=$fc3['fencheng'][$j]['list']['openid'];
            $getarr['users_sn']=$fc3['fencheng'][$j]['list']['users_sn'];
            $getarr['nick_name']=$fc3['fencheng'][$j]['list']['nick_name'];
            
            $getarr['order_sn']=$res[$i]['order_sn'];
            $getarr['order_create_time']=$res[$i]['order_create_time'];
            $getarr['queren_time']=$res[$i]['queren_time'];
            
            $getarr['product_price']=$res[$i]['product_price'];
            $getarr['order_total_price']=$res[$i]['order_total_price'];
            $getarr['ori_price']=$res[$i]['ori_price'];
            $getarr['ori_price_total']=$res[$i]['ori_price_total'];
            
            
            
            
            $getarr['leixing']="店铺级别分成";
            $getarr['fc']=$fc3['fencheng'][$j]['fc'];
            $getarr['zfc']=$fc3['yqrje'];
            
            array_push($textarr,$getarr);
           
        }
        
    }
    
    
    $aResult = array();
    foreach($textarr as $value)
    {
       $date = $value['users_sn'];
       $sum = $value['fc'];
       if(array_key_exists($date,$aResult))
       {
          $aResult[$date] += $sum;
       } else
       {
          $aResult[$date] = $sum;
       }
    }
    //print_r($aResult);
    $rel=array();
    foreach($aResult as $k=>$v){
    $rel[]=$k;
    }
    $rel2=array();
    for($o=0;$o<count($aResult);$o++)
    {
         $rel2[$o]=array("sn"=>$rel[$o],"val"=>$aResult[$rel[$o]]);
    }
    
    
    //print_r($rel2);
    //exit;
//print_r($textarr);exit;

    $arr2 = array(array(
            
            "类型",
            
            "购买人openid",
            "购买人代码",
            "购买人昵称",
            "单据编号",
            "订单创建时间",
            "订单确认时间",
            "销售价格(￥)",
            "销售总价格(￥)",
            "标准售价(￥)",
            "标准总售价(￥)",
            
            "分成类型",
            "分成金额",
            "该类型总分成",
            ));
    for ($k = 0; $k < count($textarr); $k++) {
        array_push($arr2, $textarr[$k]);

    }
    
    
    $arrnull = array(array(
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            ));
    array_push($arr2, $arrnull);
    array_push($arr2, $arrnull);
    
    
    for($o=0;$o<count($aResult);$o++)
    {
         array_push($arr2, $rel2[$o]);
    }
     //print_r($arr2);exit;
    
    arrayToExcel('分销分成统计', '分销分成统计', $arr2, 2);

}
//留言导出
if ($_REQUEST['m'] == 'wx_lv_msg') {
    $time =f_req($_REQUEST['t1']) ;
    $time2 = f_req($_REQUEST['t2']);


    //$sql = "SELECT a.openid,b.nick_name,a.name,a.tel,a.email,a.address,a.note,a.add_time FROM wx_lv_msg  a inner join users  b on a.openid=b.openid where   a.last_update_2 between '" . $time .
    //  "' and '" . $time2 . "'  order by a.add_time desc";
    $sql = $sql = "SELECT case when c.cj_type ='qudao' then '渠道' when c.cj_type ='shop' then '商店' when c.cj_type ='sales' then '导购' else '微信公众号' end as type,c.cj_sn,c.cj_name,a.openid,b.nick_name,a.name,a.tel,a.email,a.address,a.note,a.add_time FROM wx_lv_msg  a inner join users  b on a.openid=b.openid left join cj_qrcode_stat c on a.openid=c.openid where   a.last_update_2 between '" .
        $time . "' and '" . $time2 . "' group by  c.openid order by a.add_time desc";
    $res = $GLOBALS['db']->getAll($sql);


    $arr = array(array(
            "来源类型",
            "来源代码",
            "来源名称",
            "申请人openid",
            "昵称",
            "联系人",
            "手机",
            "email",
            "地址",
            "留言",
            "时间"));
    for ($i = 0; $i < count($res); $i++) {
        array_push($arr, $res[$i]);

    }
    arrayToExcel('加盟留言 ', '加盟留言', $arr, 2);


    //    id	mediumint	8	0	0	-1	-1	0	0		0					-1	0
    //openid	varchar	250	0	-1	0	0	0	0		0	用户的唯一身份ID	utf8	utf8_general_ci		0	0
    //issubs	int	10	0	-1	0	0	0	0		0	是否关注时				0	0
    //cj_sn	varchar	30	0	-1	0	0	0	0		0	二维码场景ID	utf8	utf8_general_ci		0	0
    //cj_name	varchar	50	0	-1	0	0	0	0		0	场景名称	utf8	utf8_general_ci		0	0
    //cj_type	varchar	50	0	-1	0	0	0	0		0		utf8	utf8_general_ci		0	0
    //qrcid	varchar	10	0	-1	0	0	0	0		0		utf8	utf8_general_ci		0	0
    //tzsy	int	11	0	-1	0	0	0	0	0	0					0	0
    //sort_no	int	20	0	-1	0	0	0	0	0	0					0	0
    //add_time	datetime	0	0	-1	0	0	0	0		0					0	0
    //last_update	timestamp	0	0	-1	0	0	0	0		-1					0	0
    //last_update_2	date	0	0	-1	0	0	0	0		0					0	0


}


if ($_REQUEST['m'] == 'wx_fans') {

    if ($_REQUEST['start_time']) {
        $start_time = $_REQUEST['start_time'];
    }
    if ($_REQUEST['end_time']) {
        $end_time = $_REQUEST['end_time'];
    }

    if ($_REQUEST['qudao']) {
        $qudao = $_REQUEST['qudao'];
    }
    if ($_REQUEST['kehu']) {
        $kehu = $_REQUEST['kehu'];
    }


    if (!empty($qudao)) {
        $sqlwhere = " and cj_sn in(" . $qudao . ")";
    }

    if (!empty($kehu)) {
        $sqlwhere = " and cj_sn in(" . $kehu . ")";
    }


    $sql = "
          select (case  when qudao.qudao_sn  is null then qudao_a.qudao_sn else qudao.qudao_sn  end) qudao_sn,
          (case  when qudao.qudao_name  is null then qudao_a.qudao_name else qudao.qudao_name  end) qudao_name
          ,shop.shop_sn,shop.shop_name
          ,a.cj_sn,cj_type,b.sl1,b.sl2,b.sl from 
          (select cj_sn,cj_type  from cj_qrcode_stat
          where 1=1 " . $sqlwhere . " group by cj_sn,cj_type )  a left join
          (select cj_sn,count(openid) sl ,
          sum(case when add_time<'" . $start_time . ' 00:00:00' .
        "'  then 1 else 0 end) sl1  ,
          sum(case when add_time between '" . $start_time . ' 00:00:00' .
        "' and '" . $end_time . ' 23:59:59' . "'  then 1 else 0 end) sl2
          from cj_qrcode_stat
          where 1=1  group by cj_sn) b
          on a.cj_sn=b.cj_sn
          left join qudao on a.cj_sn=qudao.qudao_sn
          left join shop on a.cj_sn=shop.shop_sn
          left join qudao qudao_a on shop.p_id=qudao_a.qudao_sn
          ";
    $res = $GLOBALS['db']->getAll($sql);


    $arr = array(array(
            "渠道代码",
            "渠道名称",
            "店铺代码",
            "店铺名称",
            "场景代码",
            "场景类型",
            "上期数量",
            "本期数量",
            "合计数量"));
    for ($i = 0; $i < count($res); $i++) {
        array_push($arr, $res[$i]);
    }
    arrayToExcel('粉丝查询', '粉丝查询', $arr, 2);
}


///积分导出
if ($_REQUEST['m'] == 'tj_point') {

    $th_time = $_REQUEST['t1'];
    $time = $_REQUEST['t2'];
    $is_att = $_REQUEST['is_att'];
    if ($_REQUEST['is_att'] == 2) {
        
        $afi2 = "";
    } elseif ($_REQUEST['is_att'] == '') {

    } else {

        $afi2 = " where is_att = '" . trim($_REQUEST['is_att']) . "' ";
    }
    
    //用户签到积分
    function check_inlog($openid,$t1,$t2)
    {
        $sql = "select * from users_check_log where openid='" . $openid .
            "' and add_time between '".$t1."' and '".$t2."'  order by add_time desc";
        $res = $GLOBALS['db']->getAll($sql);
       // echo $sql;exit;
        $sum = "select sum(rank_points) as sl,last_update_2 from users_check_log where openid='" . $openid .
            "' and add_time between '".$t1."' and '".$t2."' order by add_time desc";
        $sum = $GLOBALS['db']->getRow($sum);
       // return array("list" => $res, "sum" => $sum['sl']);
       return array( "sum" => $sum['sl'],"last_update_2" => $sum['last_update_2'],"count" => count($res));
    }

    //用户将奖券兑换成积分
    function expoint_inlog($openid,$t1,$t2)
    {
        $sql = "select * from users_expoint_log where openid='" . $openid .
            "' and add_time between '".$t1."' and '".$t2."' order by add_time desc";
        $res = $GLOBALS['db']->getAll($sql);

        $sum = "select sum(rank_points) as sl from users_expoint_log where openid='" . $openid .
            "' and add_time between '".$t1."' and '".$t2."' order by add_time desc";
        $sum = $GLOBALS['db']->getRow($sum);
        return array("count" => count($res), "sum" => $sum['sl']);
    }
    //兑换实物券扣除积分
    function sncode_real($openid,$t1,$t2)
    {
        $sql = "select add_time,type_val,note from wx_sncode_real where openid='" . $openid .
            "' and add_time between '".$t1."' and '".$t2."' order by add_time desc";
        $res = $GLOBALS['db']->getAll($sql);

        $sum = "select sum(type_val) as sl from wx_sncode_real where openid='" . $openid .
            "' and add_time between '".$t1."' and '".$t2."' order by add_time desc";
        $sum = $GLOBALS['db']->getRow($sum);
        return array("count" => count($res), "sum" => $sum['sl']);
    }
    //--
    
    $sql = "select d.is_att,d.nick_name,d.users_sn,a.openid from users_check_log a left join users_expoint_log b on a.openid=b.openid left join wx_sncode_real c on a.openid=b.openid inner join users d on a.openid=d.openid ".$afi2." group by a.openid order by d.add_time desc ";
    $tj_point_list = $GLOBALS['db']->getAll($sql);

    for ($j = 0; $j < count($tj_point_list); $j++) {
        $ch = check_inlog($tj_point_list[$j]['openid'], $th_time, $time);
        if ($ch['sum'] == '') {
            $ch['sum'] = 0;
        }
        $tj_point_list[$j]['check_inlog_sum'] = $ch['sum'];
        $tj_point_list[$j]['check_last_update_2'] = $ch['last_update_2'];
        $tj_point_list[$j]['check_count'] = $ch['count'];
        //拼装积分兑换
        $exp = expoint_inlog($tj_point_list[$j]['openid'], $th_time, $time);
        if ($exp['sum'] == '') {
            $exp['sum'] = 0;
        }
        $tj_point_list[$j]['exp_sum'] = $exp['sum'];
        $tj_point_list[$j]['exp_count'] = $exp['count'];

        //扣除兑换积分
        $real = sncode_real($tj_point_list[$j]['openid'], $th_time, $time);
        if ($real['sum'] == '') {
            $real['sum'] = 0;
        }
        $tj_point_list[$j]['real_sum'] = $real['sum'];
        $tj_point_list[$j]['real_count'] = $real['count'];

        $tj_point_list[$j]['point_sum'] = $tj_point_list[$j]['check_inlog_sum'] +
         $tj_point_list[$j]['exp_sum'] - $tj_point_list[$j]['real_sum'];
    }
    
    //print_r($tj_point_list);exit;

    $arr = array(array(
            "状态",
            "昵称",
            "会员代码","openid",
            "签到积分",
            "次数",
            "最近签到时间",
            "奖券兑换积分",
            "次数",
            "积分兑换实物",
            "次数",
            "总积分"));
    for ($i = 0; $i < count($tj_point_list); $i++) {
        array_push($arr, $tj_point_list[$i]);
    }
    //print_r($arr);exit;
    arrayToExcel('积分查询', '积分查询', $arr, 2);
}



///积分导出
if ($_REQUEST['m'] == 'fcsend') {

    $th_time = $_REQUEST['t1'];
    $time = $_REQUEST['t2'];
    $is_att = $_REQUEST['is_att'];
    $m_key=$_REQUEST['m_key'];
    
 //   "交易单号",
//            "级别",
//            "获得分成昵称","openid",
//            "来源",
//            "openid",
//            "分成金额(元)",
//            "时间",
//            "发送状态",
//            "发送时间",
//    
    
     $sql="select a.out_trade_no,a.jibie,c.nick_name as p_nick_name,c.openid as p_openid2,b.nick_name,b.openid,a.fenchengjine,from_unixtime(a.add_time) as time,a.is_send,from_unixtime(a.send_time) as send_time2 from  wxpay_fclog a inner join users b on a.openid=b.openid inner join users c on a.p_openid =c.openid";
    if (isset($_REQUEST['Action'])) {
        $filer = $_REQUEST['Action'];
    }
    
    
    if($_REQUEST['is_att']==2)
    {
        $afi="";
        $afi2="";
    }elseif($_REQUEST['is_att']=='')
    {
        
    }
    else
    {
         $afi=" and a.is_send = '" . trim($_REQUEST['is_att'])."'";
        
        //$afi2=" where is_att = '" . trim($_REQUEST['is_att'])."' ";
    }

    if (isset($_REQUEST['m_key'])) {

        $filer1 = " and ( b.nick_name like '%" . trim($_REQUEST['m_key']) .
            "%' or c.nick_name like '%" . trim($_REQUEST['m_key']) .
            "%'  or a.out_trade_no like '%" . trim($_REQUEST['m_key']) .
            "%') " .$afi .
            " ";
        //  print_r($filer1);exit;
    } else {
        $filer1 = '';
    }
    
    
    if (isset($_REQUEST['t1']) or isset($_REQUEST['t2'])) {
         
          $t1 = $_REQUEST['t1'];
          $t2 = $_REQUEST['t2'];
          
          $filer1.=" and (from_unixtime(a.add_time) between '".$t1." 00:00:00' and  '".$t2." 23:59:59')";
         
    }
   

    
 
    $filer = " where a.p_openid !='' and a.p_openid !='000' $filer1 ";
    $action_list = array();



    //$sql="select id,fcsend_sn,fcsend_name,fcsend_outer_name,fcsend_note_1,fcsend_note_2,fcsend_note_3,fcsend_note_4,fcsend_note_5,fcsend_name_eg,zz,tzsy,action_url,last_update,last_update_2,start_time,end_time,sort_no  from fcsend ";
    $sql = $sql . $filer . " order by a.add_time desc " . $obj['limit_obj'] .
        ";";


    $res = $GLOBALS['db']->getAll($sql);
    
    
    //print_r($res);exit;
    $arr = array(array(
            "交易单号",
            "级别",
            "获得分成昵称","openid",
            "来源",
            "openid",
            "分成金额(元)",
            "时间",
            "发送状态",
            "发送时间",
            ));
    for ($i = 0; $i < count($res); $i++) {
        array_push($arr, $res[$i]);
    }
    //print_r($arr);exit;
    arrayToExcel('分销分成', '分销分成', $arr, 2);
}
?>