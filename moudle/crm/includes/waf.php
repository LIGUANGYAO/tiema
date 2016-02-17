<?php
/*云体检通用漏洞防护补丁v1.1
更新时间：2013-05-25
功能说明：防护XSS,SQL,代码执行，文件包含等多种高危漏洞
*/




$url_arr=array(
'xss'=>"\\=\\+\\/v(?:8|9|\\+|\\/)|\\%0acontent\\-(?:id|location|type|transfer\\-encoding)",
);

$args_arr=array(
'xss'=>"[\\'\\\"\\;\\*\\<\\>].*\\bon[a-zA-Z]{3,15}[\\s\\r\\n\\v\\f]*\\=|\\b(?:expression)\\(|\\<script[\\s\\\\\\/]|\\<\\!\\[cdata\\[|\\b(?:eval|alert|prompt|msgbox)\\s*\\(|url\\((?:\\#|data|javascript)",

'sql'=>"[^\\{\\s]{1}(\\s|\\b)+(?:select\\b|update\\b|insert(?:(\\/\\*.*?\\*\\/)|(\\s)|(\\+))+into\\b).+?(?:from\\b|set\\b)|[^\\{\\s]{1}(\\s|\\b)+(?:create|delete|drop|truncate|rename|desc)(?:(\\/\\*.*?\\*\\/)|(\\s)|(\\+))+(?:table\\b|from\\b|database\\b)|into(?:(\\/\\*.*?\\*\\/)|\\s|\\+)+(?:dump|out)file\\b|\\bsleep\\([\\s]*[\\d]+[\\s]*\\)|benchmark\\(([^\\,]*)\\,([^\\,]*)\\)|(?:declare|set|select)\\b.*@|union\\b.*(?:select|all)\\b|(?:select|update|insert|create|delete|drop|grant|truncate|rename|exec|desc|from|table|database|set|where)\\b.*(charset|ascii|bin|char|uncompress|concat|concat_ws|conv|export_set|hex|instr|left|load_file|locate|mid|sub|substring|oct|reverse|right|unhex)\\(|(?:master\\.\\.sysdatabases|msysaccessobjects|msysqueries|sysmodules|mysql\\.db|sys\\.database_name|information_schema\\.|sysobjects|sp_makewebtask|xp_cmdshell|sp_oamethod|sp_addextendedproc|sp_oacreate|xp_regread|sys\\.dbms_export_extension)",

'other'=>"\\.\\.[\\\\\\/].*\\%00([^0-9a-fA-F]|$)|%00[\\'\\\"\\.]");

$referer=empty($_SERVER['HTTP_REFERER']) ? array() : array($_SERVER['HTTP_REFERER']);
$query_string=empty($_SERVER["QUERY_STRING"]) ? array() : array($_SERVER["QUERY_STRING"]);

check_data($query_string,$url_arr);
check_data($_GET,$args_arr);
check_data($_POST,$args_arr);
check_data($_COOKIE,$args_arr);
check_data($referer,$args_arr);
function W_log($log)
{
	$logpath=$_SERVER["DOCUMENT_ROOT"]."/log.txt";
	$log_f=fopen($logpath,"a+");
	fputs($log_f,$log."\r\n");
	fclose($log_f);
}
function check_data($arr,$v) {
 foreach($arr as $key=>$value)
 {
	if(!is_array($key))
	{ check($key,$v);}
	else
	{ check_data($key,$v);}
	
	if(!is_array($value))
	{ check($value,$v);}
	else
	{ check_data($value,$v);}
 }
}
function check($str,$v)
{
	foreach($v as $key=>$value)
	{
	if (preg_match("/".$value."/is",$str)==1||preg_match("/".$value."/is",urlencode($str))==1)
		{
			//W_log("<br>IP: ".$_SERVER["REMOTE_ADDR"]."<br>时间: ".strftime("%Y-%m-%d %H:%M:%S")."<br>页面:".$_SERVER["PHP_SELF"]."<br>提交方式: ".$_SERVER["REQUEST_METHOD"]."<br>提交数据: ".$str);
			print "您的提交带有不合法参数,谢谢合作";
			exit();
		}
	}
}


class sqlsafe {
    private $getfilter = "'|(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
    private $postfilter = "\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
    private $cookiefilter = "\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
    /**
     * 构造函数
     */
    public function __construct() {
        foreach($_GET as $key=>$value){$this->stopattack($key,$value,$this->getfilter);}
        foreach($_POST as $key=>$value){$this->stopattack($key,$value,$this->postfilter);}
        foreach($_COOKIE as $key=>$value){$this->stopattack($key,$value,$this->cookiefilter);}
    }
    /**
     * 参数检查并写日志
     */
    public function stopattack($StrFiltKey, $StrFiltValue, $ArrFiltReq){
        if(is_array($StrFiltValue))$StrFiltValue = implode($StrFiltValue);
        if (preg_match("/".$ArrFiltReq."/is",$StrFiltValue) == 1){   
            $this->writeslog($_SERVER["REMOTE_ADDR"]."    ".strftime("%Y-%m-%d %H:%M:%S")."    ".$_SERVER["PHP_SELF"]."    ".$_SERVER["REQUEST_METHOD"]."    ".$StrFiltKey."    ".$StrFiltValue);
            showmsg('您提交的参数非法,系统已记录您的本次操作！','',0,1);
        }
    }
    /**
     * SQL注入日志
     */
    public function writeslog($log){
        $log_path = CACHE_PATH.'logs'.DIRECTORY_SEPARATOR.'sql_log.txt';
        $ts = fopen($log_path,"a+");
        fputs($ts,$log."\r\n");
        fclose($ts);
    }
}

$safe=new sqlsafe();
$safe->__construct();

function sty2($obj)
{
    
    //$obj = stripslashes($obj);
    $obj = addslashes($obj);
    //$obj = str_replace("'",'', $obj);
    return $obj;
}
class arraytojson2
{
    public function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
    {
        static $recursive_counter = 0;
        if (++$recursive_counter > 1000) {
            die('possible deep recursion attack');
        }
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $this->arrayRecursive($array[$key], $function, $apply_to_keys_also);
            } else {
                $array[$key] = $function($value);
            }

            if ($apply_to_keys_also && is_string($key)) {
                $new_key = $function($key);
                if ($new_key != $key) {
                    $array[$new_key] = $array[$key];
                    //unset($array[$key]);
                }
            }
        }
        $recursive_counter--;
    }

    /**************************************************************
    *
    *	将数组转换为JSON字符串（兼容中文）
    *	@param	array	$array		要转换的数组
    *	@return string		转换得到的json字符串
    *	@access public
    *
    *************************************************************/
    public function JSON($array)
    {
       
        $this->arrayRecursive($array, 'sty2', true);
         
        $this->arrayRecursive($array, 'urlencode', true);


        $json = json_encode($array);
        return urldecode($json);
        //return $json;
        //return urldecode($json);
    }
    
    public function RE_SET($array)
    {
       
        $this->arrayRecursive($array, 'sty2', true);
        
        return $array;
        
    }

    //   public function JSON2($array) {
    //
    //      	$this->arrayRecursive($array, 'urlencode', true);
    //        $this->arrayRecursive($array, 'addslashes', true);
    //      	$json = json_encode($array);
    //      	return urldecode($json);
    //        //return $json;
    //          //return urldecode($json);
    //      }


    //$obj数据源items,$num 单页数据量，$pa第几页
    public function Ms_p_limit($obj, $num, $pa)
    {

        $num = intval($num);

        $pa = intval($pa);
        if ($pa <= 1) {
            $pa = 1;
        } else {
        }
        if ($num < 1) {
            $num = 20;
        } else {
        }
        $count = count($obj);
        //输入超出，暂时没写
        if ($num * $pa > $count) {
            //$pa=$count%$sum;
        }
        $start_p = ($num * ($pa - 1) + 1) - 1;
        $stop_p = $num;
        $sql = " limit " . $start_p . "," . $stop_p . " ";
        return $sql;
    }
}





$nw= new arraytojson2();
$_REQUEST=$nw->RE_SET($_REQUEST);
$_POST=$nw->RE_SET($_POST);
$_GET=$nw->RE_SET($_GET);


?>