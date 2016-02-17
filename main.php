<?php
//include "config/timstar.php";	//包含测试执行速度类
//include "config/H_mysql.php";	//数据库操作类
//$timer = new timer;  
//$timer->start();  //测试速度开始
//
//
///************************************************************************
//代码作用：实例化smarty模板
//*************************************************************************/
//include "libs/Smarty.class.php";
//$tpl = new Smarty();				//建立smarty实例对象$smarty
//$tpl->template_dir = "templates/";	//设置模板目录
//$tpl->compile_dir = "templates_c/";	//设置编译目录
//$tpl->cache_dir = "cache/";	//设置缓存目录
//$tpl->left_delimiter = '<{';	//这里是调试时设为false,发布时请使用true
//$tpl->right_delimiter = '}>';	//设置右边界符
//$tpl->caching = false;			//这里是调试时设为false,发布时请使用true
//$smarty->cache_lifetime = 0;	//设置缓存时间
//
//
///************************************************************************
//代码作用：调用数据库内容
//*************************************************************************/
//$H_conn = new H_mysql();
//$H_conn -> H_conn();
//$H_sql = "select * from cms_news order by DOC_ID desc";
//$H_resut = $H_conn -> H_query($H_sql);
//print_r($H_resut);exit;
//while($H_array = $H_conn -> H_array($H_resut)){
//	$H_doc_array[] = array('DOC_ID' => $H_array['DOC_ID'],'DOC_Title' => $H_array['DOC_Title'],'DOC_Time' => $H_array['DOC_Time'],'DOC_Num' => $H_array['DOC_Num']);
//}
//$tpl->assign("values",$H_doc_array);
//
///************************************************************************
//代码作用：数组循环实例
//*************************************************************************/
////$Doc_Array = array(1 => $Doc_Array['DOC_ID'],2 => $Doc_Array['DOC_Title'],3 => $Doc_Array['DOC_Time'],4 => $Doc_Array['DOC_Num']);
////$tpl->assign("values", $Doc_Array);
//
///************************************************************************
//代码作用：一下代码是生成html页面
//*************************************************************************/
//$content = $tpl->fetch('index.tpl',null,null,false); //下面这句取得页面中所有内容, 注意最后一个参数为false 
//$fp = fopen('html/'.date("YmdHis").'.html','w'); //下面将内容写入至一个静态文件 
//fwrite($fp, $content); 
//fclose($fp); 
//
//
//$tpl->display('index.tpl');
//
//
//$timer->stop();  
//echo "<br>页面执行时间:".$timer->spent();  
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');

if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}


if ($_REQUEST['act'] == 'default') {
 $sql="select * from cms_news";
  $sql_px = $GLOBALS['db']->getAll($sql);

  
  
  $smarty->display('main.tpl');
}

?>
