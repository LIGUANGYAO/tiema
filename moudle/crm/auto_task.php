<?php
define('IN_ECS', true);

error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
define('ROOT_PATH', str_replace('auto_task.php', '', str_replace('\\', '/', __FILE__)));
@ini_set('memory_limit','512M');
@ini_set ('allow_call_time_pass_reference', 1);
@set_time_limit(60);

date_default_timezone_set('PRC');

include(ROOT_PATH . 'data/config.php');
require_once(ROOT_PATH . 'includes/cls_mysql.php');
$GLOBALS['db'] = new cls_mysql($db_host, $db_user, $db_pass, $db_name);

$sql = "select id,sd_id_list,lx_time,api_path,last_exec_time from autotask_signal where is_on=1 order by last_exec_time asc";
$aas_arr = $GLOBALS['db']->getAll($sql);



//print_r($aas_arr);exit;

$real_path = real_path();
$doc = ROOT_PATH;

foreach($aas_arr as $sub_aas){
	$last_exec_time = (int)$sub_aas['last_exec_time'];
	$lx_time = (int)$sub_aas['lx_time'];
	$id = (int)$sub_aas['id'];
	 if ($last_exec_time >= time() - $lx_time*60){
		continue;
	}

	$sd_id_list = $sub_aas['sd_id_list'];
	$api_path = $sub_aas['api_path'];
	$sd_id_arr = explode(',',$sd_id_list);
	foreach($sd_id_arr as $sd_id){
		if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN'){
			//window
			$exec_command = $real_path.' -f  '.$doc.$api_path.' s='.$sd_id;

			if (!win_chk_is_run($exec_command)){
				if(ip_check($id)){
					win_run($exec_command);
					echo $exec_command."\n";
					$time = time();
					$sql = "update autotask_signal set last_exec_time=$time where id=$id";
					$GLOBALS['db']->query($sql);
                    
                 
				}
			}else{
				echo "Is runing--".$exec_command."\n";
				continue;
			}
		}else{
			//linux
            
              
			$exec_command = $real_path.' -f '.$doc.$api_path.' s='.$sd_id;
			if (!chk_is_run($exec_command)){
				if(ip_check($id)){
					popen($exec_command.'  1>/dev/null 2>/dev/null &','r');
					echo $exec_command."\n";
					$time = time();
					$sql = "update autotask_signal set last_exec_time=$time where id=$id";
					$GLOBALS['db']->query($sql);
                    
                     $sql = "insert into wx_lv_msg(name) values(3)";
$sql = $GLOBALS['db']->query($sql);
				}
			}else{
				echo "Is runing--".$exec_command."\n";
				continue;
			}
		}
	}
}

function chk_is_run($cmd){
	$handle = popen("ps -ef | grep php 2>&1", 'r');
	$cmd_cont = '';
	while(!feof($handle)) {
		$buffer = fgets($handle);
		$cmd_cont .= $buffer;
	}
	pclose($handle);
	if (strpos($cmd_cont,$cmd) === false){
		return false;
	}else{
		return true;
	}
}

function win_run($cmd){
	$bat_str = "title efast_".md5($cmd)."\r\n".$cmd." \r\n exit";
	$bat_file_path =  ROOT_PATH .'temp/auto_task_bat/';
	if (!file_exists($bat_file_path)){
		mkdir($bat_file_path);
	}
	$bat_file = $bat_file_path . md5($cmd) .'.bat';
	file_put_contents($bat_file,$bat_str);
	popen('start /min '. $bat_file,'r');
	sleep(1);
}

function win_chk_is_run($cmd){
	$handle = popen("tasklist -v", 'r');
	$cmd_cont = '';
	while(!feof($handle)) {
		$buffer = fgets($handle);
		$cmd_cont .= $buffer;
	}
	pclose($handle);

	$find_cmd = "efast_".md5($cmd);

	if (strpos($cmd_cont,$find_cmd) === false){
		return false;
	}else{
		return true;
	}
}
/**
 *
 */
function ip_check($id){

	$mdl = new GetMacAddr();

	$server_type = substr(strtolower(PHP_OS), 0, 3) == 'win' ? '' : 'linux';

	$serverips = $mdl->GetClientMacAddr($server_type);
	$serverips[] = "127.0.0.1";

	$sql ="select allow_ips from autotask_signal where id ='{$id}'";
	$res = $GLOBALS['db']->getOne($sql);
	if(empty($res)){
		return true;
	}else{
		$ips = explode(',', $res);
		$exists = false;
		foreach ($serverips as $serverip)
		{
			if(in_array($serverip,$ips)){
				$exists = true;
				break;
			}
		}
		return $exists;
	}
}

/**
 */
function real_path()
{
	if(substr(strtolower(PHP_OS), 0, 3) == 'win'){
		$ini= ini_get_all();
		$path = $ini['extension_dir']['local_value'];
		$php_path = str_replace('\\','/',$path);
		$php_path = str_replace(array('/ext/','/ext'),array('/','/'),$php_path);
		$real_path = $php_path.'php.exe';
	}else{
		$real_path = PHP_BINDIR.'/php';
	}
	
	if(strpos($real_path, 'ephp.exe') !== FALSE)
	{
		$real_path = str_replace('ephp.exe', 'php.exe',$real_path);
	}
	
	return $real_path;
}

/**
 */
class GetMacAddr
{
	var $return_array = array(); //// 返回带有MAC地址的字串数组
	var $mac_addr;

	function __construct()
	{

	}

	function GetClientMacAddr($os_type)
	{
		switch ( strtolower($os_type) )
		{
			case "linux":
				$this->forLinux();
				break;
			case "solaris":
				break;
			case "unix":
				break;
			case "aix":
				break;
			default:
				$this->forWindows();
				break;
		}

		$temp_array = array();

		$this->mac_addr = array();

		foreach ( $this->return_array as $value )
		{
			$mac = "/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/";

			if (preg_match($mac,$value,$temp_array))
			{

				$this->mac_addr[] = $temp_array[0];
			}
		}

		unset($temp_array);
		return $this->mac_addr;
	}
	function forWindows(){
		@exec("ipconfig /all", $this->return_array);

		if ($this->return_array)
			return $this->return_array;
		else{

			$ipconfig = $_SERVER["WINDIR"]."\system32\ipconfig.exe";
			if ( is_file($ipconfig) )
				@exec($ipconfig." /all", $this->return_array);
			else
				@exec($_SERVER["WINDIR"]."\system\ipconfig.exe /all", $this->return_array);
			return $this->return_array;
		}
	}
	function forLinux(){
		@exec("/sbin/ifconfig -a", $this->return_array);
		return $this->return_array;
	}
}





