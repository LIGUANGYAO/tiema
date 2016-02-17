<?php

//define('IN_ECS', true);

date_default_timezone_set('PRC');

define('OPENAPI_ROOT_PATH', str_replace('service/init.php', '', str_replace('\\', '/', __FILE__))."openapi/log/");


$config_file_name = dirname(__FILE__).'/../../data/config.php';

if(!file_exists($config_file_name))
	$config_file_name = dirname(__file__) . '/data/config.php';	
	
require_once ($config_file_name);

require_once (dirname(__file__) . '/base/cls_mysql2.php');

//echo 1;exit;
require_once (dirname(__file__) . '/base/cls_pro_mysql.php');


$db = new cls_mysql($db_host, $db_user, $db_pass, $db_name);
$procedure_db = new cls_pro_mysql($db_host, $db_user, $db_pass, $db_name);


date_default_timezone_set('PRC');



function getIP()
{
    static $realip;
    if (isset($_SERVER)){
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $realip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $realip = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")){
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $realip = getenv("HTTP_CLIENT_IP");
        } else {
            $realip = getenv("REMOTE_ADDR");
        } 
    }
    return $realip;
}

$ip=getIP();
if($ip=='' or $ip =='127.0.0.1')
{
    
}
else
{
    exit;
}
//echo getIP();