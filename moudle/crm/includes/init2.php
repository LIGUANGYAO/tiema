<?php
//session_start();
//$_SESSION['username']="aaa";
//unset($_SESSION['username']);


if (!defined('IN_ECS')) {
    die('Hacking attempt');
}

define('ECS_ADMIN', true);

error_reporting(E_ALL);

if (__file__ == '') {
    die('Fatal error code: 0');
}

/* 初始化设置 */
@ini_set('memory_limit', '512M');
@ini_set('session.cache_expire', 180);
@ini_set('session.use_trans_sid', 0);
@ini_set('session.use_cookies', 1);
@ini_set('session.auto_start', 0);
@ini_set('display_errors', 1);

if (DIRECTORY_SEPARATOR == '\\') {
    @ini_set('include_path', '.;' . ROOT_PATH);
} else {
    @ini_set('include_path', '.:' . ROOT_PATH);
}

if (file_exists('data/config.php')) {
    include ('data/config.php');
} else {
    
    if (file_exists('../../data/config.php')) {
         
        include ('../../data/config.php');
    }
    else
    {
        //echo dirname(dirname(__file__)).'/data/config.php';
       include ( dirname(dirname(__file__)).'/data/config.php' );
    }
  

    //include('../includes/config.php');
}


if (!defined('ADMIN_PATH')) {
    define('ADMIN_PATH', 'admin');
}
//define('ROOT_PATH', str_replace(ADMIN_PATH . '/includes/init.php', '', str_replace('\\', '/', __FILE__)));

define('ROOT_PATH', dirname(dirname(__file__)) . "/");

//echo sprintf('%s',ROOT_PATH) . sprintf('%s',ADMIN_PATH);
if (defined('DEBUG_MODE') == false) {
    define('DEBUG_MODE', 0);
}

if (PHP_VERSION >= '5.1' && !empty($timezone)) {
    date_default_timezone_set($timezone);
}

if (isset($_SERVER['PHP_SELF'])) {
    define('PHP_SELF', $_SERVER['PHP_SELF']);
} else {
    define('PHP_SELF', $_SERVER['SCRIPT_NAME']);
}




/* 对路径进行安全处理 */
if (strpos(PHP_SELF, '.php/') !== false) {
    ecs_header("Location:" . substr(PHP_SELF, 0, strpos(PHP_SELF, '.php/') + 4) . "\n");
    exit();
}
$math='';
require (dirname(dirname(__file__)) . '/includes/cls_mach.php');
require (dirname(dirname(__file__)) . '/includes/waf.php');
/* 初始化数据库类 */
//echo dirname(dirname(__file__)) . '/includes/cls_mysql.php';
require (dirname(dirname(__file__)) . '/includes/cls_mysql.php');
$db = new cls_mysql($db_host, $db_user, $db_pass, $db_name);
$db_host = $db_user = $db_pass = $db_name = null;




/*初始化附属数据库*/
if(U_DB2==1)
{
    $db2 = new cls_mysql($db_host_2, $db_user_2, $db_pass_2, $db_name_2);
    $db_host_2 = $db_user_2 = $db_pass_2 = $db_name_2 = null;
 
}




/* 初始化 action */
if (!isset($_REQUEST['act'])) {
    $_REQUEST['act'] = '';
}

if (!file_exists('../temp/caches')) {
    @mkdir('../temp/caches', 0777);
    @chmod('../temp/caches', 0777);
}

if (!file_exists('../temp/compiled/admin')) {
    @mkdir('../temp/compiled/admin', 0777);
    @chmod('../temp/compiled/admin', 0777);
}

clearstatcache();


//代码作用：实例化smarty模板
//*************************************************************************/
//include "libs/Smarty.class.php";
//
//$smarty = new Smarty();				//建立smarty实例对象$smarty
//$smarty->template_dir = "templates/";	//设置模板目录
//$smarty->compile_dir = "templates_c/";	//设置编译目录
//$smarty->cache_dir = "cache/";	//设置缓存目录
//$smarty->left_delimiter = '<{';	//这里是调试时设为false,发布时请使用true
//$smarty->right_delimiter = '}>';	//设置右边界符
//$smarty->caching = false;			//这里是调试时设为false,发布时请使用true
//$smarty->cache_lifetime = 0;	//设置缓存时间
//

require (dirname(dirname(__file__)) . '/includes/cls_template.php');
$smarty = new cls_template;

$smarty->template_dir = dirname(dirname(__file__)) . '/templates';
//$smarty->compile_dir = ROOT_PATH . 'temp/compiled/admin';
if ((DEBUG_MODE & 2) == 2) {
    $smarty->force_compile = true;
}

//
//$smarty->assign('lang', $_LANG);
//$smarty->assign('help_open', $_CFG['help_open']);
//
//
//$smarty->assign('token', $_CFG['token']);
//

//header('Cache-control: private');
header('content-type: text/html; charset=' . EC_CHARSET);
header('Expires: Fri, 14 Mar 1980 20:53:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

if ((DEBUG_MODE & 1) == 1) {
    error_reporting(E_ALL);
} else {
    error_reporting(E_ALL ^ E_NOTICE);
}
if ((DEBUG_MODE & 4) == 4) {
    include (ROOT_PATH . 'includes/lib.debug.php');
}

/* 判断是否支持gzip模式 */
//if (gzip_enabled()) {
//    ob_start('ob_gzhandler');
//} else {
//    ob_start();
//}


function set_cookie($name, $value)
{
    $obj = setcookie($name, $value, time() + 99999999);
    return $obj;

}

//echo $_GET['pager_Size'];
if (isset($_GET['pager_Size'])) {
    $p_cookie = $_GET['pager_Size'];
    setcookie('pager_Size', $p_cookie);

    echo $p_cookie;
} else {
    // echo 2;
}

if (isset($_COOKIE["pager_Size"])) {
    if($_COOKIE["pager_Size"]<=0)
    {
        $Num=20;
    }
    else
    { 
        $Num = $_COOKIE["pager_Size"];
    }
   $Num=(int)$Num;
    
    // print_r($noNum);
} else {
    $Num = 20;
    $Num=(int)$Num;
}
define('FULL', '1');


$cookie_time = '3600';


//if (defined('NOLOGIN')) {
////do something
//}
//else 
//{
//
//    $is_allow = $GLOBALS['db']->getOne(" select sesskey from sessions where sesskey='" .
//        $_COOKIE['user_name'] . "' limit 1 ;");
//       //echo $is_allow;exit;
//    if ($is_allow) {
//        //echo 1;
//        //echo "<script>window.location.href='index.php';</script>";
//    }
//    else
//    {   
//        //echo 2;
//          echo "<script>window.location.href='index.php';</script>";
//    }
//
//
//}
//

function log_out()
{
    setcookie("user_name", $session_un, time()-999);
}
//设置北京时间
date_default_timezone_set('PRC');


$now_time = date('Y-m-d H:i:s', time());



//添加系统日志


function get_real_ip()
{
$ip=false;
if(!empty($_SERVER["HTTP_CLIENT_IP"])){
  $ip = $_SERVER["HTTP_CLIENT_IP"];
}
if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
  $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
  if($ip){
   array_unshift($ips, $ip); $ip = FALSE;
  }
  for($i = 0; $i < count($ips); $i++){
   if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i])){
    $ip = $ips[$i];
    break;
   }
  }
}
return($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}



function getlogin_name()
{
    $cookie = stripslashes($_COOKIE['Login_wx_name']);

    $tmpUnSerialize = unserialize($cookie);
    return $tmpUnSerialize;
}

function action_log($action_sn, $action_name, $user_sn, $bz = '', $djbh = '')
{
    $t = date('Y-m-d H:i:s', time());
    $sql = "insert into action_log(action_sn,action_name,rq,user_sn,bz,djbh,ip) values ('" .
        $action_sn . "','" . $action_name . "','" . $t . "','" . $user_sn . "','" . $bz .
        "','" . $djbh . "','" . get_real_ip() . "')";
    $res = $GLOBALS['db']->query($sql);
}


?>