<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_wx_order_list.php');
require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
///修改1,查询语句
//sort_no,tzsy 要记得添加
    /*
    $sql="select id,
                 order_sn,
                 order_name,
                 openid,
                 username,
                 sfz,
                 p_openid,
                 p_name,
                 tel,
                 sbdm,
                 car_no,
                 endtime,
                 ccx,
                 qzx,
                 syx,
                 sjsyx,
                 bz,
                 sort_no,
                 tzsy,
                 last_update
                 from wx_order";
    */
    $sql="select * from wx_order";
    $order_list = get_order_list($Num,"wx_order",$sql);
    //print_r($order_list);
    $smarty->assign('order_list', $order_list['items']);
     $smarty->assign('fall', 1);
    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $order_list['page']);
    $smarty->display('wx_order_list.tpl');


}

if ($_REQUEST['act'] == 'add_order_list') {

   //$sql="select xmlx_sn ,xmlx_name from xmlx";
//   $res_xmlx = $GLOBALS['db']->getAll($sql);
//    $smarty->assign('res_xmlx', $res_xmlx);
    $smarty->assign('fall', 'add_order_list');
    $smarty->display('wx_order_list_mx.tpl');
}


if ($_REQUEST['act'] == 'edit') {
    //$aaa=$_GET['goods_sn'];
    
    ///修改2,查询语句
    /*
    $sql="select order_sn,
                 order_name,
                 openid,
                 username,
                 sfz,
                 p_openid,
                 p_name,
                 tel,
                 sbdm,
                 car_no,
                 endtime,
                 ccx,
                 qzx,
                 syx,
                 sjsyx,
                 bz,
                 sort_no,
                 tzsy,
                 last_update
                 from wx_order ";
    */
    $sql="select * from wx_order";
                  $order_mx=get_order_mx("order",$sql);
    //print_r($order_mx);exit;
  
    $img_cod=$_REQUEST['order_sn'];
    
    
//    //图片部分。没图片则删除
//    $order_imgs2 = get_order_imgs_list("order_imgs"," p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,img_action_url,ss,img_outer_id,add_time,last_update",$img_cod);
////print_r($order_imgs2);
//    $order_imgs = arr_push($order_imgs2['items']);
//    $smarty->assign('order_imgs', $order_imgs);
    
    
    $smarty->assign('order_mx', $order_mx['items'][0]);
    $smarty->assign('res_xmlx', $order_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('wx_order_list_mx.tpl');
}

if ($_REQUEST['act'] == 'delete') {

    //echo 1;
    if(isset($_REQUEST['img_code']))
    {
        $img_code=trim($_REQUEST['img_code']);
                        
        $sql="delete from order_imgs where  img_outer_id= '".$img_code."'";     
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

if ($_REQUEST['act'] == 'delete_order') {

    //echo 1;
    if(isset($_REQUEST['order_sn']))
    {
        $order_sn=trim($_REQUEST['order_sn']);
                        
        $sql="delete from wx_order where  order_sn= '".$order_sn."'";     
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
                        
        $sql="update  order_imgs set ss=".$alt."  where  img_outer_id= '".$img_code."'";     
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
if ($_REQUEST['act'] == 'order_xs') {

    //echo 1;
   
    if(isset($_REQUEST['order_sn']) && isset($_REQUEST['alt']))
    {
        $order_code=urldecode(trim($_REQUEST['order_sn']));
        $alt=urldecode(trim($_REQUEST['alt']));
                        
        $sql="update  wx_order set tzsy=".$alt."  where  order_sn= '".$order_code."'";     
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


if ($_REQUEST['act'] == 'order_split') {
require (dirname(__FILE__).'/wxtransfer/WxPay.Api.php');

       class Split {
          protected $values = array();
   //    public $values = array();

           public function GetUpInfo($int){
               $field=$this->values['field'];
               $table=$this->values['table'];
               $upfield=$this->values['upfield'];
               $fieldValue=$this->values['id'];
               $sql0="SELECT * FROM ".$table." WHERE ".$field." = '".$fieldValue. "'";
               $upinfo=array();
               $upinfo[0]=$this->QuerySql($sql0);
               if($int==0){
                   return $upinfo[0];
               }
               else{
                   for($i=1; $i<=$int; $i++){
                       $sqli="SELECT * FROM ".$table." WHERE ".$field." = '".$upinfo[($i-1)][$upfield]. "'";
                       $upinfo[$i]=$this->QuerySql($sqli);
                       $upinfo[$i] = empty($upinfo[$i]) ? 0 : $upinfo[$i];

                   }
                     return  $upinfo[$int];

               }

           }

           public function QuerySql($sql){
               $row=$GLOBALS['db']->getRow($sql);
               return $row;
           }

           public function SetTable($table){
               $this->values['table']=$table;
           }

           public function SetField($str){
               $this->values['field']=$str;
           }

           public function SetUpField($str){
               $this->values['upfield']=$str;
           }


           public function SetID($str)
           {
               $this->values['id']=$str;
           }


       }



    $sqlgh="select * from tbhome_wx_gh WHERE id = 1";
    $ghinfo=$GLOBALS['db']->getRow($sqlgh);

    define('WXAPPID',$ghinfo['appid']);
    define('WXAPPSECRET', $ghinfo['appkey']);
    define('WXMCHID', $ghinfo['mchid']);
    define('WXMCHSECRET', $ghinfo['mchkey']);
    $wxSSLcert= dirname(__file__).'/../../cert/apiclient_cert.pem';
    $wxSSLkey=dirname(__file__).'/../../cert/apiclient_key.pem';
    define('WXSSLCERT', $wxSSLcert);
    define('WXSSLKEY', $wxSSLkey);

    if(isset($_REQUEST['order_sn']))
    {
        $order_sn=$_REQUEST['order_sn'];
        $get_one=" select * from wx_order where order_sn ='".$order_sn."'";
        $resorder = $GLOBALS['db']->getRow($get_one);//订单详情
        $openid0=$resorder['openid'];//订单用户openid
        $syx0=$resorder['syx'];//订单商业险金额

        $sqlrate="SELECT * FROM tbhome_wxpay_fc WHERE id=1";
        $resrate=$GLOBALS['db']->getRow($sqlrate);
        $rate1=$resrate['feerate'];//一级分成佣金比率

        $user=new Split();
            $user->SetTable('users');
            $user->SetID($openid0);
            $user->SetField('openid');
            $user->SetUpField('p_openid');
        $user0=$user->GetUpInfo(0);
            $user1=$user->GetUpInfo(1);//一级上级用户信息

        $openid1=$user1['openid'];//一级上级openid
        $amount1=intval($syx0)*intval($rate1);//订单商业险金额 * 一级分成佣金比率 单位：分


        $order_sn1=WXMCHID.date("YmdHis").rand(100,999);//创建分成付款订单号
//         $re_user_name=$_REQUEST['re_user_name'];
            $input = new WxPayTransfer();
            $input->SetOpenid($openid1);//转账对象
            $input->SetAmount($amount1);//金额单位分，最少100分才能转
 //           $input->SetRe_user_name($re_user_name);//经微信实名认证的用户真实姓名
            $input->SetCheck_name('NO_CHECK');//FORCE_CHECK：强校验真实姓名
            $input->SetPartner_trade_no($order_sn1);//创建转账单号
            $input->SetDesc('这个是测试：吴汉青：泉州~');//转账说明，必填！
           $result=WxPayApi::transfer($input);


            if ($result['return_code']=='FAIL') {
                $remark=$result["return_msg"];
                $status=0;
                $payment_time=0;
                $truename = isset($user1['truename']) ? $user1['truename'] : '';
                $from=$user0['nickname'].'->'.$user1['nickname'];
                echo "返回失败";

            }else{
                if ($result['result_code']=='FAIL') {
                    $remark=$result["err_code_desc"];
                    $status=0;
                    $payment_time=0;
                    $truename = isset($user1['truename']) ? $user1['truename'] : '';
                    $from=$user0['nickname'].'->'.$user1['nickname'];
                    echo "结果错误";
                }else{
                    $remark='';
                    $status=1;
                    $payment_time= isset($result["payment_time"]) ? strtotime($result["payment_time"]): 1234567890;
                 //   $payment_time=$result["payment_time"];
                    $truename = isset($user1['truename']) ? $user1['truename'] : '';
                    $from=$user0['nick_name'].'->'.$user1['nick_name'];
                    $order_sn1=$result["partner_trade_no"];

                    $sql="update  wx_order set is_split=1 where  order_sn= '".$order_sn."'";
                    $res = $GLOBALS['db']->query($sql);

                }
            }

 //       print_r($user0);
   //     print_r($user1);




        $amount1=$amount1*0.01;

        $values = "'" . $order_sn1 . "',"
            . $payment_time . ",'"
            . $truename . "',"
            . $amount1 . ",'"
            . $openid1 . "','"
            . WXMCHID . "','"
            . $from . "','"
            . $remark . "',"
            . $status ;//. "'";

        $sqlNew = "insert into tbhome_pay_log(partner_trade_no,payment_time,truename,amount,openid,mch_appid,fromuser,remark,status) values (" .$values. ")";
        $tbhome_exeInsert=$GLOBALS['db']->query($sqlNew);
            //NO_CHECK：不校验真实姓名
         //   FORCE_CHECK：强校验真实姓名（未实名认证的用户会校验失败，无法转账）
     //   OPTION_CHECK：针对已实名认证的用户才校验真实姓名（未实名认证用户不校验，可以转账成功）
//	exit();



  //      $p_openid=urldecode(trim($_REQUEST['p_openid']));
   //     $alt=urldecode(trim($_REQUEST['alt']));









    }

}


if ($_REQUEST['act'] == 'post') {

    
    //$p = new upload;
//    $path=$p->upload_path='upload/order';
//    $p->uplood_img();
//    $img_array = $p->upload_file;
//   
//    for($i=0;$i<count($img_array['guige']);$i++)
//    {
//        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
//    }
//    $aaa = $_POST['order_sn'];
//    // print_r($aaa);exit;
//    //图片部分。没图片则删除
//    img_insert($aaa, $img_array,"order_imgs");
    //修改3，更新语句
     $time_field=array(
    //array("type"=>"2","field"=>"add_time","method"=>"1"),
    array("type"=>"2","field"=>"last_update","method"=>"2"),
    array("type"=>"1","field"=>"last_update_2","method"=>"2")
    );
   // print_r($time_field);exit;
    update_order_mx("wx_order","order_name,openid,username,sfz,p_openid,p_name,tel,sbdm,car_no,endtime,ccx,qzx,syx,sjsyx,bz,sort_no,is_pay","order_sn",$time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('wx_order_list_mx.tpl');
}


if ($_REQUEST['act'] == 'post_add') {
      if(isset($_REQUEST['order_sn']))
    {
        $order_sn=trim($_REQUEST['order_sn']);
    }
    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one=" select order_sn from wx_order where order_sn ='".$order_sn."'";
    $res = $GLOBALS['db']->getRow($get_one);
    //print_r($get_one);exit;
    if(empty($res))
    {
        //echo 1;
       // $p = new upload;
//        $path=$p->upload_path='upload/order';
//        $p->uplood_img();
//        $img_array = $p->upload_file;
//        for($i=0;$i<count($img_array['guige']);$i++)
//        {
//        $img_array['guige'][$i]=(array)$img_array['guige'][$i];
//        }
//        //print_r($img_array);exit;
//        $aaa = $order_sn;
//        
//        //插入图片记录//图片部分。没图片则删除
//         img_insert($aaa, $img_array,"order_imgs");
        //修改4，增加语句
        //保存修改后商品明细
           $time_field=array(
        array("type"=>"2","field"=>"add_time","method"=>"1"),
       // array("type"=>"2","field"=>"last_update","method"=>"2"),
        //array("type"=>"1","field"=>"last_update_2","method"=>"2")
        );
        //修改4，增加语句
        //保存修改后商品明细
        insert_order_mx("wx_order","order_sn,order_name,openid,username,sfz,p_openid,p_name,tel,sbdm,car_no,endtime,ccx,qzx,syx,sjsyx,bz,sort_no,is_pay",$time_field);
        
        $smarty->assign('fall', 'post');
        $smarty->display('wx_order_list.tpl');
    }
    else
    {
        $smarty->assign('fall', 'fs');
        $smarty->display('wx_order_list_mx.tpl');   
    }
    
  
}



?>
