<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_tj_fxfc_dahua.php');

require (dirname(__file__) . '/sub/sub_image.php');


if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'default') {
    ///修改1,查询语句
    //sort_no,tzsy 要记得添加

    //--------


    if (isset($_REQUEST['t1'])) {
        $t1 = $_REQUEST['t1'];

    }
    if (isset($_REQUEST['t2'])) {
        $t2 = $_REQUEST['t2'];
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
    
    $sql="select b.add_time,b.id,a.product_price,a.product_count,a.order_total_price,a.order_status,a.order_express_price,a.buyer_nick,a.buyer_openid,b.cj_sn,b.cj_type, from_unixtime(a.order_create_time) as order_create_time,a.order_sn,a.or_status,queren_time,a.ori_price,a.ori_price_total,a.bz  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid  ";
    //$sql="select c.p_type,c.p_id,c.users_sn,c.nick_name,c.point,a.product_price,a.order_total_price,a.order_express_price,a.buyer_nick,a.buyer_openid,from_unixtime(a.order_create_time) as order_create_time,a.order_sn  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid inner join tgpoint c on b.cj_sn=c.p_id  ";

    $tj_fxfc_list = get_tj_fxfc_list($Num, "weixiaodian", $sql);
    //print_r($tj_fxfc_list);exit;

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

    $smarty->assign('tj_fxfc_list', $tj_fxfc_list['items']);
    $smarty->assign('fall', 1);
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $tj_fxfc_list['page']);
    //添加时间间隔
    $time = date('Y-m-d', time());
    $data = strtotime($time); //减去三天的时间
    $data = $data - (60 * 60 * 24 * 30); //打印出三天的时间
    $th_time = date("Y-m-d", $data);
    if (isset($_REQUEST['t1'])) {
        $th_time = $_REQUEST['t1'];
    }
    if (isset($_REQUEST['t2'])) {
        $time = $_REQUEST['t2'];
    }

    if (isset($_REQUEST['order_status'])) {
        $status = $_REQUEST['order_status'];
    }

    $smarty->assign('status', $status);
    $smarty->assign('th_time', $th_time);
    $smarty->assign('now_time', $time);
    $smarty->display('tj_fxfc_dahua.tpl');
}

if ($_REQUEST['act'] == 'add_tj_fxfc_list') {

    //$sql="select xmlx_sn ,xmlx_name from xmlx";
    //   $res_xmlx = $GLOBALS['db']->getAll($sql);
    //    $smarty->assign('res_xmlx', $res_xmlx);
    $smarty->assign('fall', 'add_tj_fxfc_list');
    $smarty->display('tj_fxfc_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];

    ///修改2,查询语句
    $sql = "select id,tj_fxfc_sn,tj_fxfc_name,sort_no,tzsy,last_update,url,type
  from tj_fxfc ";
    $tj_fxfc_mx = get_tj_fxfc_mx("tj_fxfc", $sql);
    // print_r($tj_fxfc_mx);exit;
    $img_cod = $_REQUEST['tj_fxfc_sn']; //    //图片部分。没图片则删除
    //    $tj_fxfc_imgs2 = get_tj_fxfc_imgs_list("tj_fxfc_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
    ////print_r($tj_fxfc_imgs2);
    //    $tj_fxfc_imgs = arr_push($tj_fxfc_imgs2['items']);
    //    $smarty->assign('tj_fxfc_imgs', $tj_fxfc_imgs);


    $smarty->assign('tj_fxfc_mx', $tj_fxfc_mx['items'][0]);
    $smarty->assign('res_xmlx', $tj_fxfc_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('tj_fxfc_mx.tpl');
}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if (isset($_REQUEST['img_code'])) {
        $img_code = trim($_REQUEST['img_code']);
        $sql = "delete from tj_fxfc_imgs where  img_outer_id= '" . $img_code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}

if ($_REQUEST['act'] == 'delete_tj_fxfc') {

    //echo 1;
    if (isset($_REQUEST['tj_fxfc_sn'])) {
        $tj_fxfc_sn = trim($_REQUEST['tj_fxfc_sn']);
        $sql = "delete from tj_fxfc where  tj_fxfc_sn= '" . $tj_fxfc_sn . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}
if ($_REQUEST['act'] == 'img_xs') {

    //echo 1;
    if (isset($_REQUEST['img_code']) && isset($_REQUEST['alt'])) {
        $img_code = trim($_REQUEST['img_code']);
        $alt = trim($_REQUEST['alt']);
        $sql = "update  tj_fxfc_imgs set ss=" . $alt . "  where  img_outer_id= '" . $img_code .
            "'";
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}
if ($_REQUEST['act'] == 'tj_fxfc_xs') {

    //echo 1;

    if (isset($_REQUEST['tj_fxfc_code']) && isset($_REQUEST['alt'])) {
        $tj_fxfc_code = urldecode(trim($_REQUEST['tj_fxfc_code']));
        $alt = urldecode(trim($_REQUEST['alt']));
        $sql = "update  tj_fxfc set tzsy=" . $alt . "  where  tj_fxfc_sn= '" . $tj_fxfc_code .
            "'";
        $res = $GLOBALS['db']->query($sql);
        echo "修改成功";
    } else {
        echo "失败";
    }

    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}


if ($_REQUEST['act'] == 'post') {


    //$p = new upload;
    //    $path=$p->upload_path='upload/tj_fxfc';
    //    $p->uplood_img();
    //    $img_array = $p->upload_file;
    //
    //    for($i=0;$i<count($img_array['guige']);$i++)
    //    {
    //        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
    //    }
    //    $aaa = $_POST['tj_fxfc_sn'];
    //    // print_r($aaa);exit;
    //    //图片部分。没图片则删除
    //    img_insert($aaa, $img_array,"tj_fxfc_imgs");
    //修改3，更新语句
    $time_field = array( //array("type"=>"2","field"=>"add_time","method"=>"1"),
            array(
            "type" => "2",
            "field" => "last_update",
            "method" => "2"), array(
            "type" => "1",
            "field" => "last_update_2",
            "method" => "2")); //print_r($time_field);exit;
    update_tj_fxfc_mx("tj_fxfc", "tj_fxfc_name,url,type,sort_no", "tj_fxfc_sn", $time_field);
    $smarty->assign('fall', 'post');
    $smarty->display('tj_fxfc_mx.tpl');
}


if ($_REQUEST['act'] == 'post_add') {
    if (isset($_REQUEST['tj_fxfc_sn'])) {
        $tj_fxfc_sn = trim($_REQUEST['tj_fxfc_sn']);
    }
    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one = " select tj_fxfc_sn from tj_fxfc where tj_fxfc_sn ='" . $tj_fxfc_sn .
        "'";
    $res = $GLOBALS['db']->getRow($get_one); //print_r($get_one);exit;
    if (empty($res)) {
        //echo 1;
        // $p = new upload;
        //        $path=$p->upload_path='upload/tj_fxfc';
        //        $p->uplood_img();
        //        $img_array = $p->upload_file;
        //        for($i=0;$i<count($img_array['guige']);$i++)
        //        {
        //        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
        //        }
        //        //print_r($img_array);exit;
        //        $aaa = $tj_fxfc_sn;
        //
        //        //插入图片记录//图片部分。没图片则删除
        //         img_insert($aaa, $img_array,"tj_fxfc_imgs");
        //修改4，增加语句
        //保存修改后商品明细
        $time_field = array(array(
                "type" => "2",
                "field" => "add_time",
                "method" => "1"), // array("type"=>"2","field"=>"last_update","method"=>"2"),
                //array("type"=>"1","field"=>"last_update_2","method"=>"2")
            ); //修改4，增加语句
        //保存修改后商品明细
        insert_tj_fxfc_mx("tj_fxfc", "tj_fxfc_sn,tj_fxfc_name,url,type,sort_no", $time_field);
        $smarty->assign('fall', 'post');
        $smarty->display('tj_fxfc_mx.tpl');
    } else {
        $smarty->assign('fall', 'fs');
        $smarty->display('tj_fxfc_mx.tpl');
    }


}


if ($_REQUEST['act'] == 'down_dj') {


    $time = date('Y-m-d', time());
    $data = strtotime($time); //减去三天的时间
    $data = $data - (60 * 60 * 24 * 3); //打印出三天的时间
    $th_time = date("Y-m-d", $data);
    $smarty->assign('th_time', $th_time);
    $smarty->assign('now_time', $time);
    $smarty->display('tj_fxfc_xz.html');
}


if ($_REQUEST['act'] == 'down_order') {

    class getArr
    {
        public $reqUrl = '';
        public $openid;
        public function get_time_diff($t)
        {
            $time = date('Y-m-d H:i:s', time());
            $time = strtotime($time);
            //echo $time;exit;
            $aaa = date("YmdHis", $time); // $time = date('Y-m-d H:i:s', time());
            $t = strtotime($t); //echo $time;exit;
            $t = date("YmdHis", $t);
            $a = $this->timeDiff($aaa, $t);
            return $a;
        }
        public function timeDiff($aTime, $bTime)
        {
            // 分割第一个时间
            $ayear = substr($aTime, 0, 4);
            $amonth = substr($aTime, 4, 2);
            $aday = substr($aTime, 6, 2);
            $ahour = substr($aTime, 8, 2);
            $aminute = substr($aTime, 10, 2);
            $asecond = substr($aTime, 12, 2); // 分割第二个时间
            $byear = substr($bTime, 0, 4);
            $bmonth = substr($bTime, 4, 2);
            $bday = substr($bTime, 6, 2);
            $bhour = substr($bTime, 8, 2);
            $bminute = substr($bTime, 10, 2);
            $bsecond = substr($bTime, 12, 2); // 生成时间戳
            $a = mktime($ahour, $aminute, $asecond, $amonth, $aday, $ayear);
            $b = mktime($bhour, $bminute, $bsecond, $bmonth, $bday, $byear);
            $timeDiff['second'] = $a - $b;
            // 采用了四舍五入,可以修改
            $timeDiff['mintue'] = round($timeDiff['second'] / 60);
            $timeDiff['hour'] = round($timeDiff['mintue'] / 60);
            $timeDiff['day'] = round($timeDiff['hour'] / 24);
            $timeDiff['week'] = round($timeDiff['day'] / 7);
            $timeDiff['month'] = round($timeDiff['day'] / 30);
            // 按30天来算
            $timeDiff['year'] = round($timeDiff['day'] / 365); // 按365天来算
            return $timeDiff;
        }
        public function getToken()
        {
            $get_app = "select app_id ,app_secret from app_id where weixin_id=1";
            $get_app = $GLOBALS['db']->getRow($get_app); //print_r($get_app);exit;

            $APPID = $get_app['app_id'];
            $APPSECRET = $get_app['app_secret'];
            if (empty($APPID)) {
                echo "appid missing";
                exit;
            } elseif (empty($APPSECRET)) {
                echo "appsecret missing";
                exit;
            } else {

            }
            //https://api.weixin.qq.com/cgi-bin/user/get?access_token=ACCESS_TOKEN&next_openid=NEXT_OPENID


            //                return $ACC_TOKEN;
            $a_token_time = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
            $a_token_time = $GLOBALS['db']->getRow($a_token_time);
            //print_r($a_token_time);exit;

            $time_diff = $this->get_time_diff($a_token_time['last_update']);
            //print_r($time_diff);
            //            exit;
            if ($time_diff['second'] >= 3600 or $time_diff['second'] <= -1) {

                $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                    $APPID . "&secret=" . $APPSECRET;
                $json = file_get_contents($TOKEN_URL);
                $result = json_decode($json);
                $ACC_TOKEN = $result->access_token;
                $i = 0;
                while ($result->access_token == '') {

                    $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                        $APPID . "&secret=" . $APPSECRET;
                    $json = file_get_contents($TOKEN_URL);
                    $result = json_decode($json);
                    $i++;
                    if ($result->access_token != '') {


                        $ACC_TOKEN = $result->access_token;
                        break;
                    } elseif ($i >= 5) {
                        break;
                    }

                }


                $time = date('Y-m-d H:i:s', time());
                $u_acc_token = "update temporary_tb set access_token='" . $ACC_TOKEN .
                    "',last_update='" . $time . "' where type=1 and app_id=1";
                $u_acc_token = $GLOBALS['db']->query($u_acc_token);
                //echo 1;
                $a_token_time2 = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
                $a_token_time2 = $GLOBALS['db']->getRow($a_token_time2);
                return $a_token_time2['access_token'];
                //echo $time_diff['second'] . "1";
                //exit;
            } else {
                //echo 2;
                $a_token_time2 = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
                $a_token_time2 = $GLOBALS['db']->getRow($a_token_time2);
                //print_r(empty($a_token_time2));exit;

                $i = 0;
                while ($a_token_time2['access_token'] == '') {

                    $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                        $APPID . "&secret=" . $APPSECRET;
                    $json = file_get_contents($TOKEN_URL);
                    $result = json_decode($json);
                    $i++; //echo $i;
                    $a_token_time2['access_token'] = $result->access_token;
                    //print_r($a_token_time2['access_token']) ;
                    if ($a_token_time2['access_token'] != '') {


                        $ACC_TOKEN = $result->access_token;
                        $time = date('Y-m-d H:i:s', time());
                        $u_acc_token = "update temporary_tb set access_token='" . $ACC_TOKEN .
                            "',last_update='" . $time . "' where type=1 and app_id=1";
                        $u_acc_token = $GLOBALS['db']->query($u_acc_token);
                        break;
                    } elseif ($i >= 5) {
                        break;
                    }

                }


                $a_token_time3 = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
                $a_token_time3 = $GLOBALS['db']->getRow($a_token_time3); //exit;

                return $a_token_time3['access_token'];
            }
            //exit;

        }

        public function getOpenid()
        {
            $MENU_URL = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=" . $this->
                getToken(); //print_r($MENU_URL);exit;
            $json = file_get_contents($MENU_URL);
            $result = json_decode($json);
            //print_r($json);exit;
            //递归stdClass Object 对象
            function objtoarr($obj)
            {
                $ret = array();
                foreach ($obj as $key => $value) {
                    if (gettype($value) == 'array' || gettype($value) == 'object') {
                        $ret[$key] = objtoarr($value);
                    } else {
                        $ret[$key] = $value;
                    }
                }
                return $ret;
            }

            $result2 = objtoarr($result);
            return $result2;
        }

        public function getopen()
        {
            //https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN
            $MENU_URL = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $this->
                getToken() . "&openid=" . $this->openid . "&lang=zh_CN";
            //print_r($MENU_URL);exit;
            $json = file_get_contents($MENU_URL);
            $result = json_decode($json);
            //print_r($json);exit;
            //递归stdClass Object 对象
            function objtoarr2($obj)
            {
                $ret = array();
                foreach ($obj as $key => $value) {
                    if (gettype($value) == 'array' || gettype($value) == 'object') {
                        $ret[$key] = objtoarr($value);
                    } else {
                        $ret[$key] = $value;
                    }
                }
                return $ret;
            }

            $result2 = objtoarr2($result);
            return $result2;
        }

    }

    $ex = new getArr();
    $ACC_TOKEN = $ex->getToken(); //拼装post数据
    $start_time = strtotime($_REQUEST['start_time']);
    $end_time = strtotime($_REQUEST['end_time']);
    function objtoarr($obj)
    {
        $ret = array();
        foreach ($obj as $key => $value) {
            if (gettype($value) == 'array' || gettype($value) == 'object') {
                $ret[$key] = objtoarr($value);
            } else {
                $ret[$key] = $value;
            }
        }
        return $ret;
    }
    function download_list($token, $res)
    {
        $MENU_URL = "https://api.weixin.qq.com/merchant/order/getbyfilter?access_token=" .
            $token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $MENU_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT,
            'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $res);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo2 = curl_exec($ch);
        //print_r($tmpInfo2);
        $obj = objtoarr(json_decode($tmpInfo2));
        if ($obj['errcode'] == 0) {
            $sl = count($obj['order_list']);
        }
        return $obj;
    }

    $status = array(
        array("status" => 2, "msg" => "待发货"),
        array("status" => 3, "msg" => "已发货"),
        array("status" => 5, "msg" => "已完成"),
        array("status" => 8, "msg" => "维权中"));
    $ret = array();
    function tj_fxfc_order($obj)
    {
        $txt = "";
        $time1 = date('Y-m-d H:i:s', time());
        $time2 = date('Y-m-d', time());
        $obj2 = $obj['order_list'];
        for ($i = 0; $i < count($obj2); $i++) {

            $sel = "select order_sn from tj_fxfc where order_sn='" . $obj2[$i]['order_id'] .
                "'"; // print_r($sel);
            $sel = $GLOBALS['db']->getRow($sel);
            if (empty($sel)) {


                $obj2[$i]['order_total_price'] = $obj2[$i]['order_total_price'] / 100;
                $obj2[$i]['product_price'] = $obj2[$i]['product_price'] / 100;
                $obj2[$i]['order_express_price'] = $obj2[$i]['order_express_price'] / 100;
                $obj2[$i]['buyer_nick'] = addslashes($obj2[$i]['buyer_nick']);
                $obj2[$i]['receiver_name'] = addslashes($obj2[$i]['receiver_name']);
                $sql = "insert into tj_fxfc (
                                    order_sn	,
                                    order_status	,
                                    order_total_price	,
                                    order_create_time	,
                                    add_time	,
                                    order_express_price	,
                                    buyer_openid	,
                                    buyer_nick	,
                                    receiver_name	,
                                    receiver_province	,
                                    receiver_city	,
                                    receiver_address	,
                                    receiver_mobile	,
                                    receiver_phone	,
                                    product_id	,
                                    product_name	,
                                    product_price	,
                                    product_sku	,
                                    product_count	,
                                    product_img	,
                                    delivery_id	,
                                    delivery_company	,
                                    trans_id	,
                                    
                                    last_update_2	
                                   
                                    ) values ('" . $obj2[$i]['order_id'] . "','" .
                    $obj2[$i]['order_status'] . "','" . $obj2[$i]['order_total_price'] . "','" . $obj2[$i]['order_create_time'] .
                    "','" . $time1 . "','" . $obj2[$i]['order_express_price'] . "','" . $obj2[$i]['buyer_openid'] .
                    "','" . $obj2[$i]['buyer_nick'] . "','" . $obj2[$i]['receiver_name'] . "','" . $obj2[$i]['receiver_province'] .
                    "','" . $obj2[$i]['receiver_city'] . "','" . $obj2[$i]['receiver_address'] .
                    "','" . $obj2[$i]['receiver_mobile'] . "','" . $obj2[$i]['receiver_phone'] .
                    "','" . $obj2[$i]['product_id'] . "','" . $obj2[$i]['product_name'] . "','" . $obj2[$i]['product_price'] .
                    "','" . $obj2[$i]['product_sku'] . "','" . $obj2[$i]['product_count'] . "','" .
                    $obj2[$i]['product_img'] . "','" . $obj2[$i]['delivery_id'] . "','" . $obj2[$i]['delivery_company'] .
                    "','" . $obj2[$i]['trans_id'] . "','" . $time2 . "')";
                $res = $GLOBALS['db']->query($sql);
                $txt .= $obj2[$i]['order_id'] . "/" . $obj2[$i]['buyer_nick'] . "下载成功<br>
                        ";
            } else {
                //如果已存在订单

                $up = "update tj_fxfc set order_status='" . $obj2[$i]['order_status'] .
                    "' where order_sn='" . $obj2[$i]['order_id'] . "'";
                $res = $GLOBALS['db']->query($up);
                $txt .= $obj2[$i]['order_id'] . "/" . $obj2[$i]['buyer_nick'] . "更新成功<br>
                         ";
            }

        }
        return $txt;
    }
    //print_r($status);exit;
    for ($i = 0; $i < count($status); $i++) {
        $arr = array(
            "status" => $status[$i]['status'],
            "begintime" => $start_time,
            "endtime" => $end_time);
        $res = json_encode($arr);
        $order_list = download_list($ACC_TOKEN, $res); //print_r($order_list);


        if (!empty($order_list['order_list'])) {
            //插入数据库


            $msg = tj_fxfc_order($order_list);
            $xx .= $msg;
        }


        //print_r($order_list);
    }
    echo $xx;
}


if ($_REQUEST['act'] == 'count_order') {

    class getArr
    {
        public $reqUrl = '';
        public $openid;
        public function get_time_diff($t)
        {
            $time = date('Y-m-d H:i:s', time());
            $time = strtotime($time);
            //echo $time;exit;
            $aaa = date("YmdHis", $time); // $time = date('Y-m-d H:i:s', time());
            $t = strtotime($t); //echo $time;exit;
            $t = date("YmdHis", $t);
            $a = $this->timeDiff($aaa, $t);
            return $a;
        }
        public function timeDiff($aTime, $bTime)
        {
            // 分割第一个时间
            $ayear = substr($aTime, 0, 4);
            $amonth = substr($aTime, 4, 2);
            $aday = substr($aTime, 6, 2);
            $ahour = substr($aTime, 8, 2);
            $aminute = substr($aTime, 10, 2);
            $asecond = substr($aTime, 12, 2); // 分割第二个时间
            $byear = substr($bTime, 0, 4);
            $bmonth = substr($bTime, 4, 2);
            $bday = substr($bTime, 6, 2);
            $bhour = substr($bTime, 8, 2);
            $bminute = substr($bTime, 10, 2);
            $bsecond = substr($bTime, 12, 2); // 生成时间戳
            $a = mktime($ahour, $aminute, $asecond, $amonth, $aday, $ayear);
            $b = mktime($bhour, $bminute, $bsecond, $bmonth, $bday, $byear);
            $timeDiff['second'] = $a - $b;
            // 采用了四舍五入,可以修改
            $timeDiff['mintue'] = round($timeDiff['second'] / 60);
            $timeDiff['hour'] = round($timeDiff['mintue'] / 60);
            $timeDiff['day'] = round($timeDiff['hour'] / 24);
            $timeDiff['week'] = round($timeDiff['day'] / 7);
            $timeDiff['month'] = round($timeDiff['day'] / 30);
            // 按30天来算
            $timeDiff['year'] = round($timeDiff['day'] / 365); // 按365天来算
            return $timeDiff;
        }
        public function getToken()
        {
            $get_app = "select app_id ,app_secret from app_id where weixin_id=1";
            $get_app = $GLOBALS['db']->getRow($get_app); //print_r($get_app);exit;

            $APPID = $get_app['app_id'];
            $APPSECRET = $get_app['app_secret'];
            if (empty($APPID)) {
                echo "appid missing";
                exit;
            } elseif (empty($APPSECRET)) {
                echo "appsecret missing";
                exit;
            } else {

            }
            //https://api.weixin.qq.com/cgi-bin/user/get?access_token=ACCESS_TOKEN&next_openid=NEXT_OPENID


            //                return $ACC_TOKEN;
            $a_token_time = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
            $a_token_time = $GLOBALS['db']->getRow($a_token_time);
            //print_r($a_token_time);exit;

            $time_diff = $this->get_time_diff($a_token_time['last_update']);
            //print_r($time_diff);
            //            exit;
            if ($time_diff['second'] >= 3600 or $time_diff['second'] <= -1) {

                $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                    $APPID . "&secret=" . $APPSECRET;
                $json = file_get_contents($TOKEN_URL);
                $result = json_decode($json);
                $ACC_TOKEN = $result->access_token;
                $i = 0;
                while ($result->access_token == '') {

                    $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                        $APPID . "&secret=" . $APPSECRET;
                    $json = file_get_contents($TOKEN_URL);
                    $result = json_decode($json);
                    $i++;
                    if ($result->access_token != '') {


                        $ACC_TOKEN = $result->access_token;
                        break;
                    } elseif ($i >= 5) {
                        break;
                    }

                }


                $time = date('Y-m-d H:i:s', time());
                $u_acc_token = "update temporary_tb set access_token='" . $ACC_TOKEN .
                    "',last_update='" . $time . "' where type=1 and app_id=1";
                $u_acc_token = $GLOBALS['db']->query($u_acc_token);
                //echo 1;
                $a_token_time2 = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
                $a_token_time2 = $GLOBALS['db']->getRow($a_token_time2);
                return $a_token_time2['access_token'];
                //echo $time_diff['second'] . "1";
                //exit;
            } else {
                //echo 2;
                $a_token_time2 = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
                $a_token_time2 = $GLOBALS['db']->getRow($a_token_time2);
                //print_r(empty($a_token_time2));exit;

                $i = 0;
                while ($a_token_time2['access_token'] == '') {

                    $TOKEN_URL = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
                        $APPID . "&secret=" . $APPSECRET;
                    $json = file_get_contents($TOKEN_URL);
                    $result = json_decode($json);
                    $i++; //echo $i;
                    $a_token_time2['access_token'] = $result->access_token;
                    //print_r($a_token_time2['access_token']) ;
                    if ($a_token_time2['access_token'] != '') {


                        $ACC_TOKEN = $result->access_token;
                        $time = date('Y-m-d H:i:s', time());
                        $u_acc_token = "update temporary_tb set access_token='" . $ACC_TOKEN .
                            "',last_update='" . $time . "' where type=1 and app_id=1";
                        $u_acc_token = $GLOBALS['db']->query($u_acc_token);
                        break;
                    } elseif ($i >= 5) {
                        break;
                    }

                }


                $a_token_time3 = "select access_token,last_update from temporary_tb where type=1 and app_id=1";
                $a_token_time3 = $GLOBALS['db']->getRow($a_token_time3); //exit;

                return $a_token_time3['access_token'];
            }
            //exit;

        }

        public function getOpenid()
        {
            $MENU_URL = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=" . $this->
                getToken(); //print_r($MENU_URL);exit;
            $json = file_get_contents($MENU_URL);
            $result = json_decode($json);
            //print_r($json);exit;
            //递归stdClass Object 对象
            function objtoarr($obj)
            {
                $ret = array();
                foreach ($obj as $key => $value) {
                    if (gettype($value) == 'array' || gettype($value) == 'object') {
                        $ret[$key] = objtoarr($value);
                    } else {
                        $ret[$key] = $value;
                    }
                }
                return $ret;
            }

            $result2 = objtoarr($result);
            return $result2;
        }

        public function getopen()
        {
            //https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN
            $MENU_URL = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $this->
                getToken() . "&openid=" . $this->openid . "&lang=zh_CN";
            //print_r($MENU_URL);exit;
            $json = file_get_contents($MENU_URL);
            $result = json_decode($json);
            //print_r($json);exit;
            //递归stdClass Object 对象
            function objtoarr2($obj)
            {
                $ret = array();
                foreach ($obj as $key => $value) {
                    if (gettype($value) == 'array' || gettype($value) == 'object') {
                        $ret[$key] = objtoarr($value);
                    } else {
                        $ret[$key] = $value;
                    }
                }
                return $ret;
            }

            $result2 = objtoarr2($result);
            return $result2;
        }

    }

    $ex = new getArr();
    $ACC_TOKEN = $ex->getToken(); //拼装post数据
    $start_time = strtotime($_REQUEST['start_time']);
    $end_time = strtotime($_REQUEST['end_time']);
    function objtoarr($obj)
    {
        $ret = array();
        foreach ($obj as $key => $value) {
            if (gettype($value) == 'array' || gettype($value) == 'object') {
                $ret[$key] = objtoarr($value);
            } else {
                $ret[$key] = $value;
            }
        }
        return $ret;
    }
    function download_dj($token, $res)
    {
        $MENU_URL = "https://api.weixin.qq.com/merchant/order/getbyfilter?access_token=" .
            $token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $MENU_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT,
            'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $res);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo2 = curl_exec($ch);
        //print_r($tmpInfo2);exit;
        $obj = objtoarr(json_decode($tmpInfo2));
        if ($obj['errcode'] == 0) {
            $sl = count($obj['order_list']);
        }
        return $sl;
    }

    $status = array(
        array("status" => 2, "msg" => "待发货"),
        array("status" => 3, "msg" => "已发货"),
        array("status" => 5, "msg" => "已完成"),
        array("status" => 8, "msg" => "维权中"));
    $ret = array(); //----测试
    //   $arr = array(
    //            "status" => 8,
    //            "begintime" => $start_time,
    //            "endtime" => $end_time);
    //        $res = json_encode($arr);
    //        $order_sum = download_dj($ACC_TOKEN, $res);
    //        print_r($)
    //-----

    //print_r($status);exit;
    for ($i = 0; $i < count($status); $i++) {
        $arr = array(
            "status" => $status[$i]['status'],
            "begintime" => $start_time,
            "endtime" => $end_time);
        $res = json_encode($arr);
        $order_sum = download_dj($ACC_TOKEN, $res);
        $list = array(
            "status" => $status[$i]['status'],
            "msg" => $status[$i]['msg'],
            "sl" => $order_sum); //echo $status[$i]['msg'].":".$order_sum;exit;
        array_push($ret, $list);
    }

    print_r(json_encode($ret));
}
?>