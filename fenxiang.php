<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init2.php');
//require (dirname(__file__) . '/sub/page.php');


if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {


    
    $openid=$_REQUEST['openid'];
    

    function downloadImageFromWeiXin($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, 0); //只取body头
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $package = curl_exec($ch);
        $httpinfo = curl_getinfo($ch);
        curl_close($ch);
        return array_merge(array('body' => $package), array('header' => $httpinfo));
    }

    function fenc_mx($p_id, $tp, $fenc)
    {
        $zfc = 0;
        $zbl = 0;
        $zje = 0;
        $wqje = 0;
        $zcje = 0;

        $sql_g = "select a.product_price,a.order_total_price,a.order_status,case when a.order_status=2 then '待发货' when a.order_status=3 then '已发货' when a.order_status=5 then '已完成' when a.order_status=8 then '维权' end  as status_name,a.order_express_price,a.buyer_nick,a.buyer_openid,b.cj_sn,b.cj_type, from_unixtime(a.order_create_time) as order_create_time,a.order_sn,a.product_name,a.product_count,a.order_total_price  from weixiaodian a inner join cj_qrcode_stat b on a.buyer_openid=b.openid where cj_type='" .
            $tp . "' and cj_sn='" . $p_id .
            "' group by b.openid,a.order_sn order by from_unixtime(a.order_create_time) desc   ";
        $res = $GLOBALS['db']->getAll($sql_g);


        //设置分成
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

        $arr = array();
        //显示明细数据
        //$arr['list']=$res;

        $arr['zfc'] = $zfc;
        $arr['zbl'] = $zbl;
        //$arr['zbl'] = $fenc;
        //正常金额
        $arr['zcje'] = $zcje;
        //维权金额
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

    //echo $_REQUEST['openid'];
    if (isset($_REQUEST['openid'])) {
        //echo 1;
        $openid = $_REQUEST['openid'];

        $get_point = "select * from tgpoint where openid ='" . $openid . "'";
        $get_point = $GLOBALS['db']->getAll($get_point);

        $zfc = 0;
        $zbl = 0;
        $zje = 0;
        $wqje = 0;
        $zcje = 0;

        $li = array();

        for ($i = 0; $i < count($get_point); $i++) {
            if ($get_point[$i]['p_type'] == "1") {
                $sql = "select qudao_sn,qudao_name,ticket from qudao where qudao_sn='" . $get_point[$i]['p_id'] .
                    "'";
                $res = $GLOBALS['db']->getRow($sql);
                


                $get_point[$i]['sales_fenc'] = tg_sales($res['qudao_sn']);
                //--end结束下属商店结算


                //获取二维码地址
                $ticket = $res['ticket'];
                if (!empty($ticket)) {

                    $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode($ticket);
                    $imageInfo = downloadImageFromWeiXin($url);
                    $qrcodename = md5($ticket);
                    $filename = 'upload/cj_qrcode/qudao/' . $qrcodename . ".jpg";
                    $local_file = fopen($filename, 'w');
                    if (false !== $local_file) {
                        if (false !== fwrite($local_file, $imageInfo["body"])) {
                            fclose($local_file);
                        }
                    }
                }
                $get_point[$i]['tgerm'] = $filename;


                $li['qudao'] = 1;
            } elseif ($get_point[$i]['p_type'] == "2") {
                $sql = "select shop_sn,shop_name,ticket from shop where shop_sn='" . $get_point[$i]['p_id'] .
                    "'";
                $res = $GLOBALS['db']->getRow($sql);
                

                //获取二维码地址
                $ticket = $res['ticket'];
                if (!empty($ticket)) {

                    $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode($ticket);
                    $imageInfo = downloadImageFromWeiXin($url);
                    $qrcodename = md5($ticket);
                    $filename = 'upload/cj_qrcode/shop/' . $qrcodename . ".jpg";
                    $local_file = fopen($filename, 'w');
                    if (false !== $local_file) {
                        if (false !== fwrite($local_file, $imageInfo["body"])) {
                            fclose($local_file);
                        }
                    }
                }
                $get_point[$i]['tgerm'] = $filename;


                


                $li['shop'] = 2;
            } elseif ($get_point[$i]['p_type'] == "3") {
                $sql = "select sales_sn,sales_name,ticket from sales where sales_sn='" . $get_point[$i]['p_id'] .
                    "'";
                $res = $GLOBALS['db']->getRow($sql);
                
                //获取二维码地址
                $ticket = $res['ticket'];
                if (!empty($ticket)) {

                    $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode($ticket);
                    $imageInfo = downloadImageFromWeiXin($url);
                    $qrcodename = md5($ticket);
                    $filename = 'upload/cj_qrcode/sales/' . $qrcodename . ".jpg";
                    $local_file = fopen($filename, 'w');
                    if (false !== $local_file) {
                        if (false !== fwrite($local_file, $imageInfo["body"])) {
                            fclose($local_file);
                        }
                    }
                }
                $get_point[$i]['tgerm'] = $filename;


                $li['sales'] = 2;
            }


        }

        

      
    }
    
    //print_r($get_point);
    if($get_point[0]['tgerm']=='')
    {
        $erweima='';
    }
    else
    {
        $erweima='<img  src="'.$get_point[0]['tgerm'].'"/>';
    }
    $smarty->assign('erweima', $erweima);
    $smarty->display('../html_000HTML.html');


}



?>