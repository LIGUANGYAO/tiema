<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/f/sub_loupan.php');

require (dirname(__file__) . '/sub/sub_image.php');

if (empty($_REQUEST['g'])) {
    $_REQUEST['g'] = 'default';
} else {
    $_REQUEST['g'] = trim($_REQUEST['g']);
}


//设定传入主参数
$g_add=substr(md5("a_loupan"),0,17); //添加参数
$g_e=substr(md5("e_loupan"),0,17); //编辑
$g_post=substr(md5("post_loupan"),0,17); //修改保存
$g_d=substr(md5("d_loupan"),0,17); //删除
$g_in=substr(md5("in_loupan"),0,17); //插入
$g_xs=substr(md5("xs_loupan"),0,17); //显示

//g= default默认 e编辑d删除 p接收修改 i接收添加
if ($_REQUEST['g'] == 'default') {


    ///修改1,查询语句
    //sort_no,tzsy 要记得添加
    
    
    $sql = "select loupan_sn,loupan_name,yongtu,tudijb_lb,weizhi,weizhi_pj,zhuzhaijuji,zhuzhaijuji_pj,jiaotong,jiaotong_pj,peitao,peitao_pj,huanjing,huanjing_pj,loucengshu,chaoxiang,zhongdianxuexiao,zhongdianxuexiao_pj,fangwuquanli,fangwuquanli_qt,wuyeguanli,wuyeguanli_pj,chengxinlv,waiguan,waiguan_pj,jiegouzhishi,dianti,jianzhumianji,suochuxiaoquweizhi,suochuxiaoquweizhi_pj,xiaoquhuanjingjingguan,xiaoquhuanjingjingguan_pj,xiaoqupeitao,xiaoqupeitao_pj,kongjianbuju,kongjianbuju_pj,caiguangtongfeng,caiguangtongfeng_pj,tudijibie_leixing,fanhuachengdu,fanhuachengdu_pj,weizhizhuangkuang,weizhizhuangkuang_pj,linjiezhuangkuang,linjiezhuangkuang_pj,shichangzhuanyedu,shichangzhuanyedu_pj,dianmianpeitao,dianmianpeitao_pj,duocengzhuzhai_junjia,tiaozhengfudu,zhudianmianjunjia,dmtiaozhengfudu,duoceng,gaoceng,bz,lbsjd,lbswd,dizhi,lbsaddress,lbsweizhi  from loupan";


    $list = get_loupan_list($Num, "loupan", $sql);

    //单独搜索
 
    $loupan_name= trim($_REQUEST['loupan_name']);
    $smarty->assign('loupan_name',$loupan_name);
 
 
 
 
 
    $dianti= trim($_REQUEST['dianti']);    
    if($dianti=='')
    {
        $dianti='';
    }
    $smarty->assign('dianti',$dianti);
 
 
 
 
 
 
 
    
   
    if(1==1)
    {
                //是否开放keyword记住输入值
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
    
    

    
    
    $smarty->assign('loupan_list', $list['items']);
    $smarty->assign('fall', 1);
    //$smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $list['page']);
    $smarty->display('w/loupan.html');


}


if ($_REQUEST['g'] == 'getnextpage') {


    $sql = "select loupan_sn,loupan_name,yongtu,tudijb_lb,weizhi,weizhi_pj,zhuzhaijuji,zhuzhaijuji_pj,jiaotong,jiaotong_pj,peitao,peitao_pj,huanjing,huanjing_pj,loucengshu,chaoxiang,zhongdianxuexiao,zhongdianxuexiao_pj,fangwuquanli,fangwuquanli_qt,wuyeguanli,wuyeguanli_pj,chengxinlv,waiguan,waiguan_pj,jiegouzhishi,dianti,jianzhumianji,suochuxiaoquweizhi,suochuxiaoquweizhi_pj,xiaoquhuanjingjingguan,xiaoquhuanjingjingguan_pj,xiaoqupeitao,xiaoqupeitao_pj,kongjianbuju,kongjianbuju_pj,caiguangtongfeng,caiguangtongfeng_pj,tudijibie_leixing,fanhuachengdu,fanhuachengdu_pj,weizhizhuangkuang,weizhizhuangkuang_pj,linjiezhuangkuang,linjiezhuangkuang_pj,shichangzhuanyedu,shichangzhuanyedu_pj,dianmianpeitao,dianmianpeitao_pj,duocengzhuzhai_junjia,tiaozhengfudu,zhudianmianjunjia,dmtiaozhengfudu,duoceng,gaoceng,bz,lbsjd,lbswd,dizhi,lbsaddress,lbsweizhi  from loupan";


    $list = get_loupan_list($Num, "loupan", $sql);

    //单独搜索
 
    $loupan_name= trim($_REQUEST['loupan_name']);
    $smarty->assign('loupan_name',$loupan_name);
 
 
 
 
 
    $dianti= trim($_REQUEST['dianti']);    
    if($dianti=='')
    {
        $dianti='';
    }
    $smarty->assign('dianti',$dianti);
 
 
    if(1==1)
    {
                //是否开放keyword记住输入值
        $m_key= trim($_REQUEST['m_key']);
        $smarty->assign('m_key',$m_key);
    }
    
    
    //print_r($list);
    
    
 //   $smarty->assign('kehu_list', $list['items']);
//    $smarty->assign('fall', 1);
//    //$smarty->assign('title', $aaa);
//    $smarty->assign('p_Array', $list['page']);
    $list['sl']=count($list['items']);
    
    require (dirname(__file__) . '/sub/rest.php');
    $aaa = new arraytojson();
    $json = $aaa->JSON($list);

    print_r($json);


}


if ($_REQUEST['g'] == $g_add) {
        
        
    
    $smarty->assign('fall', 'add_list');
    $smarty->display('f/loupan_mx.html');
}

//判断是否有编辑功能
//有编辑代码
if ($_REQUEST['g'] == $g_e) {
    //$aaa=$_GET['goods_sn'];
    ///修改2,查询语句
    
    $fi.="loupan_sn,";
    //主字段
    $bianset='loupan_sn';
    $fi.="loupan_name,";
    $fi.="yongtu,";
    $fi.="tudijb_lb,";
    $fi.="weizhi,";
    $fi.="weizhi_pj,";
    $fi.="zhuzhaijuji,";
    $fi.="zhuzhaijuji_pj,";
    $fi.="jiaotong,";
    $fi.="jiaotong_pj,";
    $fi.="peitao,";
    $fi.="peitao_pj,";
    $fi.="huanjing,";
    $fi.="huanjing_pj,";
    $fi.="loucengshu,";
    $fi.="chaoxiang,";
    $fi.="zhongdianxuexiao,";
    $fi.="zhongdianxuexiao_pj,";
    $fi.="fangwuquanli,";
    $fi.="fangwuquanli_qt,";
    $fi.="wuyeguanli,";
    $fi.="wuyeguanli_pj,";
    $fi.="chengxinlv,";
    $fi.="waiguan,";
    $fi.="waiguan_pj,";
    $fi.="jiegouzhishi,";
    $fi.="dianti,";
    $fi.="jianzhumianji,";
    $fi.="suochuxiaoquweizhi,";
    $fi.="suochuxiaoquweizhi_pj,";
    $fi.="xiaoquhuanjingjingguan,";
    $fi.="xiaoquhuanjingjingguan_pj,";
    $fi.="xiaoqupeitao,";
    $fi.="xiaoqupeitao_pj,";
    $fi.="kongjianbuju,";
    $fi.="kongjianbuju_pj,";
    $fi.="caiguangtongfeng,";
    $fi.="caiguangtongfeng_pj,";
    $fi.="tudijibie_leixing,";
    $fi.="fanhuachengdu,";
    $fi.="fanhuachengdu_pj,";
    $fi.="weizhizhuangkuang,";
    $fi.="weizhizhuangkuang_pj,";
    $fi.="linjiezhuangkuang,";
    $fi.="linjiezhuangkuang_pj,";
    $fi.="shichangzhuanyedu,";
    $fi.="shichangzhuanyedu_pj,";
    $fi.="dianmianpeitao,";
    $fi.="dianmianpeitao_pj,";
    $fi.="duocengzhuzhai_junjia,";
    $fi.="tiaozhengfudu,";
    $fi.="zhudianmianjunjia,";
    $fi.="dmtiaozhengfudu,";
    $fi.="duoceng,";
    $fi.="gaoceng,";
    $fi.="bz,";
    $fi.="lbsjd,";
    $fi.="lbswd,";
    $fi.="dizhi,lbsaddress,lbsweizhi";
    $sql = "select $fi  from loupan ";
    $loupan_mx = get_loupan_mx($bianset, $sql);

   
    $smarty->assign('loupan_mx', $loupan_mx['items'][0]);
    
    //print_r($loupan_mx);
    // $smarty->assign('res_xmlx', $color_mx['res_xmlx']);
    $smarty->assign('fall', 'edit');
    $smarty->display('w/loupan_mx.html');
}

if ($_REQUEST['g'] == 'tuwenxinxi') {
    //$aaa=$_GET['goods_sn'];
    ///修改2,查询语句
    
    $fi.="loupan_sn,";
    //主字段
    $bianset='loupan_sn';
    $fi.="loupan_name,";
    $fi.="yongtu,";
    $fi.="tudijb_lb,";
    $fi.="weizhi,";
    $fi.="weizhi_pj,";
    $fi.="zhuzhaijuji,";
    $fi.="zhuzhaijuji_pj,";
    $fi.="jiaotong,";
    $fi.="jiaotong_pj,";
    $fi.="peitao,";
    $fi.="peitao_pj,";
    $fi.="huanjing,";
    $fi.="huanjing_pj,";
    $fi.="loucengshu,";
    $fi.="chaoxiang,";
    $fi.="zhongdianxuexiao,";
    $fi.="zhongdianxuexiao_pj,";
    $fi.="fangwuquanli,";
    $fi.="fangwuquanli_qt,";
    $fi.="wuyeguanli,";
    $fi.="wuyeguanli_pj,";
    $fi.="chengxinlv,";
    $fi.="waiguan,";
    $fi.="waiguan_pj,";
    $fi.="jiegouzhishi,";
    $fi.="dianti,";
    $fi.="jianzhumianji,";
    $fi.="suochuxiaoquweizhi,";
    $fi.="suochuxiaoquweizhi_pj,";
    $fi.="xiaoquhuanjingjingguan,";
    $fi.="xiaoquhuanjingjingguan_pj,";
    $fi.="xiaoqupeitao,";
    $fi.="xiaoqupeitao_pj,";
    $fi.="kongjianbuju,";
    $fi.="kongjianbuju_pj,";
    $fi.="caiguangtongfeng,";
    $fi.="caiguangtongfeng_pj,";
    $fi.="tudijibie_leixing,";
    $fi.="fanhuachengdu,";
    $fi.="fanhuachengdu_pj,";
    $fi.="weizhizhuangkuang,";
    $fi.="weizhizhuangkuang_pj,";
    $fi.="linjiezhuangkuang,";
    $fi.="linjiezhuangkuang_pj,";
    $fi.="shichangzhuanyedu,";
    $fi.="shichangzhuanyedu_pj,";
    $fi.="dianmianpeitao,";
    $fi.="dianmianpeitao_pj,";
    $fi.="duocengzhuzhai_junjia,";
    $fi.="tiaozhengfudu,";
    $fi.="zhudianmianjunjia,";
    $fi.="dmtiaozhengfudu,";
    $fi.="duoceng,";
    $fi.="gaoceng,";
    $fi.="bz,";
    $fi.="lbsjd,";
    $fi.="lbswd,";
    $fi.="dizhi,tuwen";
    $sql = "select $fi  from loupan ";
    $loupan_mx = get_loupan_mx($bianset, $sql);

   
    $smarty->assign('loupan_mx', $loupan_mx['items'][0]);
    
    //print_r($loupan_mx);
    // $smarty->assign('res_xmlx', $color_mx['res_xmlx']);
    $smarty->assign('fall', 'tuwenxinxi');
    $smarty->display('w/loupan_mx.html');
}

if ($_REQUEST['g'] == 'd') {

    //echo 1;
    if (isset($_REQUEST['img_code'])) {
        $img_code = trim($_REQUEST['img_code']);

        $sql = "delete from color_imgs where  img_outer_id= '" . $img_code . "'";
        $res = $GLOBALS['db']->query($sql);
        echo "删除成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}

//判断是否有删除功能
//有删除代码
if ($_REQUEST['g'] == $g_d) {

    //主字段
    $bianset='loupan_sn';
    //echo 1;
    $arr=array();
    if (isset($_REQUEST[$bianset]) && empty($arr)) {
        $loupan_sn = trim(urldecode($_REQUEST[$bianset]));

        $sql = "delete from loupan where  $bianset= '" . $loupan_sn . "'";
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
        echo "修改成功";
    } else {
        echo "失败";
    }


    //$sql = "delete  from color where color_code='001000';";
    //$res = $GLOBALS['db']->getAll($sql);
}



//判断是否有启用代码
//有启用代码
if ($_REQUEST['g'] == $g_xs) {

    //主字段
    $bianset='loupan_sn';

    if (isset($_REQUEST[$bianset]) && isset($_REQUEST['alt'])) {
        $code = urldecode(trim($_REQUEST[$bianset]));
        $alt = urldecode(trim($_REQUEST['alt']));

        $sql = "update  loupan set tzsy=" . $alt . "  where  $bianset= '" . $code .
            "'";

        $res = $GLOBALS['db']->query($sql);
        echo "更新成功";
    } else {
        echo "失败";
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
    
    $fi2.="loupan_sn,";
    //主字段
    $bianset2='loupan_sn';
    
    $fi2.="loupan_name,";
    $fi2.="yongtu,";
    $fi2.="tudijb_lb,";
    $fi2.="weizhi,";
    $fi2.="weizhi_pj,";
    $fi2.="zhuzhaijuji,";
    $fi2.="zhuzhaijuji_pj,";
    $fi2.="jiaotong,";
    $fi2.="jiaotong_pj,";
    $fi2.="peitao,";
    $fi2.="peitao_pj,";
    $fi2.="huanjing,";
    $fi2.="huanjing_pj,";
    $fi2.="loucengshu,";
    $fi2.="chaoxiang,";
    $fi2.="zhongdianxuexiao,";
    $fi2.="zhongdianxuexiao_pj,";
    $fi2.="fangwuquanli,";
    $fi2.="fangwuquanli_qt,";
    $fi2.="wuyeguanli,";
    $fi2.="wuyeguanli_pj,";
    $fi2.="chengxinlv,";
    $fi2.="waiguan,";
    $fi2.="waiguan_pj,";
    $fi2.="jiegouzhishi,";
    $fi2.="dianti,";
    $fi2.="jianzhumianji,";
    $fi2.="suochuxiaoquweizhi,";
    $fi2.="suochuxiaoquweizhi_pj,";
    $fi2.="xiaoquhuanjingjingguan,";
    $fi2.="xiaoquhuanjingjingguan_pj,";
    $fi2.="xiaoqupeitao,";
    $fi2.="xiaoqupeitao_pj,";
    $fi2.="kongjianbuju,";
    $fi2.="kongjianbuju_pj,";
    $fi2.="caiguangtongfeng,";
    $fi2.="caiguangtongfeng_pj,";
    $fi2.="tudijibie_leixing,";
    $fi2.="fanhuachengdu,";
    $fi2.="fanhuachengdu_pj,";
    $fi2.="weizhizhuangkuang,";
    $fi2.="weizhizhuangkuang_pj,";
    $fi2.="linjiezhuangkuang,";
    $fi2.="linjiezhuangkuang_pj,";
    $fi2.="shichangzhuanyedu,";
    $fi2.="shichangzhuanyedu_pj,";
    $fi2.="dianmianpeitao,";
    $fi2.="dianmianpeitao_pj,";
    $fi2.="duocengzhuzhai_junjia,";
    $fi2.="tiaozhengfudu,";
    $fi2.="zhudianmianjunjia,";
    $fi2.="dmtiaozhengfudu,";
    $fi2.="duoceng,";
    $fi2.="gaoceng,";
    $fi2.="bz,";
    $fi2.="lbsjd,";
    $fi2.="lbswd,";
    $fi2.="dizhi";

    update_loupan_mx("loupan",$fi2,$bianset2, $time_field);
    
    $smarty->assign('fall', 'post');
    $smarty->display('f/loupan_mx.html');

    
}


if ($_REQUEST['g'] == $g_in) {
    //echo 1;exit;
    //主字段
    $bianset='loupan_sn';
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    $_REQUEST[$bianset] = 'LP'.date('ymd') . substr(time(), -5) . substr(microtime(), 2, 5);
    if (isset($_REQUEST[$bianset])) {
        $code_wy = trim($_REQUEST[$bianset]);
    }


    //print_r($p_id);
    //res_xmlx
    //echo $_REQUEST['pic1'];exit;
    $get_one = " select $bianset from loupan where $bianset ='" . $code_wy .
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
        //        //插入图片记录//图片部分。没图片则删除
        //         img_insert($aaa, $img_array,"color_imgs");
        //修改4，增加语句
        //保存修改后商品明细
        $time_field = array(array(
                "type" => "2",
                "field" => "add_time",
                "method" => "1"), // array("type"=>"2","field"=>"last_update","method"=>"2"),
                //array("type"=>"1","field"=>"last_update_2","method"=>"2")
            );
        //修改4，增加语句
        //保存修改后商品明细
        
    $fi2.="loupan_sn,";
    //主字段
    $bianset2='loupan_sn';
    
    $fi2.="loupan_name,";
    $fi2.="yongtu,";
    $fi2.="tudijb_lb,";
    $fi2.="weizhi,";
    $fi2.="weizhi_pj,";
    $fi2.="zhuzhaijuji,";
    $fi2.="zhuzhaijuji_pj,";
    $fi2.="jiaotong,";
    $fi2.="jiaotong_pj,";
    $fi2.="peitao,";
    $fi2.="peitao_pj,";
    $fi2.="huanjing,";
    $fi2.="huanjing_pj,";
    $fi2.="loucengshu,";
    $fi2.="chaoxiang,";
    $fi2.="zhongdianxuexiao,";
    $fi2.="zhongdianxuexiao_pj,";
    $fi2.="fangwuquanli,";
    $fi2.="fangwuquanli_qt,";
    $fi2.="wuyeguanli,";
    $fi2.="wuyeguanli_pj,";
    $fi2.="chengxinlv,";
    $fi2.="waiguan,";
    $fi2.="waiguan_pj,";
    $fi2.="jiegouzhishi,";
    $fi2.="dianti,";
    $fi2.="jianzhumianji,";
    $fi2.="suochuxiaoquweizhi,";
    $fi2.="suochuxiaoquweizhi_pj,";
    $fi2.="xiaoquhuanjingjingguan,";
    $fi2.="xiaoquhuanjingjingguan_pj,";
    $fi2.="xiaoqupeitao,";
    $fi2.="xiaoqupeitao_pj,";
    $fi2.="kongjianbuju,";
    $fi2.="kongjianbuju_pj,";
    $fi2.="caiguangtongfeng,";
    $fi2.="caiguangtongfeng_pj,";
    $fi2.="tudijibie_leixing,";
    $fi2.="fanhuachengdu,";
    $fi2.="fanhuachengdu_pj,";
    $fi2.="weizhizhuangkuang,";
    $fi2.="weizhizhuangkuang_pj,";
    $fi2.="linjiezhuangkuang,";
    $fi2.="linjiezhuangkuang_pj,";
    $fi2.="shichangzhuanyedu,";
    $fi2.="shichangzhuanyedu_pj,";
    $fi2.="dianmianpeitao,";
    $fi2.="dianmianpeitao_pj,";
    $fi2.="duocengzhuzhai_junjia,";
    $fi2.="tiaozhengfudu,";
    $fi2.="zhudianmianjunjia,";
    $fi2.="dmtiaozhengfudu,";
    $fi2.="duoceng,";
    $fi2.="gaoceng,";
    $fi2.="bz,";
    $fi2.="lbsjd,";
    $fi2.="lbswd,";
    $fi2.="dizhi";
        insert_loupan_mx("loupan",
            $fi2,
            $time_field);
        
        $smarty->assign('fall', 'post2');
        $smarty->display('f/loupan_mx.html');

      


    } else {
        $smarty->assign('val', '代码已存在');
        $smarty->assign('fall', 'fs');
        $smarty->display('f/loupan_mx.html');
    }


}


?>