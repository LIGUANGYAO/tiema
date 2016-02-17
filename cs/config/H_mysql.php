<?php
/*************************************
*	数据库MySql处理---H_mysql.php
*	创建人: huang_xiang
*	创建时间：2008-12-25 9:29
*	更新时间：2009-2-18 13:37
*	Email：yin273642232@163.com QQ:273642232
*************************************/
/*************************************
实例代码
	include_once("H_mysql.php");													//引入文件
	$H_mysql = new H_mysql();														//产生对象
	$H_mysql -> H_conn();															//返回:数据库连接,参数:无;';
	$H_mysql -> H_sele($H_db);														//返回:选择数据库,参数:$H_db-数据库名;';
	$H_mysql -> H_set($H_char="utf8");												//返回:字符串编码,参数:$Hchar-编码类型(默认utf8);';
	$H_mysql -> H_query($H_sql);													//返回:选择数据库,参数:$H_sql-sql语句;';
	$H_mysql -> H_array($H_rest);													//返回:选择数据库,参数:$H_rest-数据库结果集;';
	$H_mysql -> H_nums($H_rest);													//返回:选择数据库,参数:$H_rest-数据库结果集;';
	$H_mysql -> H_afect();															//返回:选择数据库,参数:无;';
	$H_mysql -> H_close();															//返回:关闭数据库,参数:无;';
	$H_mysql -> H_list_dbs();														//返回:返回服务器中所有的数据库,参数:无;';
	$H_mysql -> H_fetch_obj();														//返回:返回类资料,参数:$H_list_dbs-数据库列表;';
	$H_mysql -> H_list_table($H_db);												//返回:返回指定数据库中的所以数据表,参数:$H_db-数据库名;';
	$H_mysql -> H_table_name($H_list_table,$H_i);									//返回:返回指定数据库中的数据表名,参数:$H_list_table-所以数据表.$H_i-第几个表;';
	$H_mysql -> H_num_fiels($H_resut);												//返回:返回指定数据库中的数据表的字段数,参数:$H_resut-查询表的结果集;';
	$H_mysql -> H_fetch_field($H_field_name,$H_i);									//返回:返回指定数据库中的数据表的字段信息(类),参数:$H_resut-查询表的结果集.$H_i-第几个表;';
	$H_mysql -> H_mysql_dump($H_data,$H_table,$H_mode);								//返回:备份数据库,参数:$H_data-数据库名.$H_table-数据表名(table1,table2,..).$H_mode-数据库名(""or"T"or"TD");';
	$H_mysql -> H_mysql_table($H_table);											//返回:返回创建该表的sql,参数:$H_table-数据表名;';
	$H_mysql -> H_mysql_table_data($H_table);										//返回:返回该表的数据的sql,参数:$H_table-数据表名;';
	$H_mysql -> H_wirte_sql($H_fname,$H_mode,$H_temp_sql);							//返回:返回该表的数据的sql,参数:$H_fname-备份文件名.$H_mode-备份模式,$H_temp_sql-备份的sql语句;';
*************************************/
//Start Class
class H_mysql{
	public $H_debug = true;
	public $H_log_flag = false;
	public $H_db;
	public $H_host;
	public $H_port;
	public $H_user;
	public $H_pass;
	public $H_data;
	public $H_desce;					//描述
	public $H_ROOT_DIR;					//文件地址路径
	public $H_log;
	public $H_url;						//设置路径
	public $H_name;						//设置用户
	
	public function __construct(){
		//当实例化一个对象的时候，这个对象的这个方法首先被调用
		$this -> H_host = "192.168.2.200";
		$this -> H_port = "3306";
		$this -> H_user = "root";
		$this -> H_pass = "";
		$this -> H_data = "news";
		//include_once($this -> H_ROOT_DIR."H_log.php");
		//$this -> H_log = new H_log();
		//$this -> H_conn();
		return '';
 	}
 	public function __destruct(){
 		//当删除一个对象或对象操作终止的时候，调用该方法
 		return '';
 	}
 	public function __get($key){
 		//当试图读取一个并不存在的属性的时候被调用
  		return '['.$key.'] Variable not find';
  	}
  	public function __set($key,$val){
 		//当试图向一个并不存在的属性写入值的时候被调用
  		return '['.$key.'] Variable not find';
  	}
  	public function __call($key,$args){
  		//当试图调用一个对象并不存在的方法时，调用该方法
  		return '['.$key.'] Function not find';
	}
	public function __toString(){
		//当打印一个对象的时候被调用
		return $this -> H_desce();
  	}
  	public function __clone(){
  		//当对象被克隆时，被调用
  		return "clone";
  	}
	public function H_desce(){
		//返回描述
		$this -> H_desce .= '类名:H_mysql-数据库MySql处理;';
		$this -> H_desce .= '函数:H_conn(),返回:数据库连接,参数:无;';
		$this -> H_desce .= '函数:H_sele($H_db),返回:选择数据库,参数:$H_db-数据库名;';
		$this -> H_desce .= '函数:H_set($H_char="utf8"),返回:字符串编码,参数:$Hchar-编码类型(默认utf8);';
		$this -> H_desce .= '函数:H_query($H_sql),返回:选择数据库,参数:$H_sql-sql语句;';
		$this -> H_desce .= '函数:H_array($H_rest),返回:选择数据库,参数:$H_rest-数据库结果集;';
		$this -> H_desce .= '函数:H_nums($H_rest),返回:选择数据库,参数:$H_rest-数据库结果集;';
		$this -> H_desce .= '函数:H_afect(),返回:选择数据库,参数:无;';
		$this -> H_desce .= '函数:H_close(),返回:关闭数据库,参数:无;';
		$this -> H_desce .= '函数:H_list_dbs(),返回:服务器中所有的数据库,参数:无;';
		$this -> H_desce .= '函数:H_fetch_obj(),返回:类资料,参数:$H_list_dbs-数据库列表;';
		$this -> H_desce .= '函数:H_list_table($H_db),返回:指定数据库中的所以数据表,参数:$H_db-数据库名;';
		$this -> H_desce .= '函数:H_table_name($H_list_table,$H_i),返回:指定数据库中的数据表名,参数:$H_list_table-所以数据表.$H_i-第几个表;';
		$this -> H_desce .= '函数:H_num_fiels($H_resut),返回:指定数据库中的数据表的字段数,参数:$H_resut-查询表的结果集;';
		$this -> H_desce .= '函数:H_fetch_field($H_field_name,$H_i),返回:指定数据库中的数据表的字段信息(类),参数:$H_resut-查询表的结果集.$H_i-第几个表;';
		$this -> H_desce .= '函数:H_mysql_dump($H_data,$H_table,$H_mode),返回:备份数据库,参数:$H_data-数据库名.$H_table-数据表名(table1,table2。。。).$H_mode-数据库名(""or"T"or"TD");';
		$this -> H_desce .= '函数:H_mysql_table($H_table),返回:创建该表的sql,参数:$H_table-数据表名;';
		$this -> H_desce .= '函数:H_mysql_table_data($H_table),返回:该表的数据的sql,参数:$H_table-数据表名;';
		$this -> H_desce .= '函数:H_wirte_sql($H_fname,$H_mode,$H_temp_sql),返回:该表的数据的sql,参数:$H_fname-备份文件名.$H_mode-备份模式,$H_temp_sql-备份的sql语句;';
		return $this -> H_desce;
	}
	public function H_conn(){
		//连接数据库
		$H_host_port = $this->H_port == "" ? $this->H_host : $this->H_host.":".$this->H_port;
		if($this->H_debug){
			$this -> H_db = mysql_connect($H_host_port,$this->H_user,$this->H_pass);
		}else{
			$this -> H_db = @mysql_connect($H_host_port,$this->H_user,$this->H_pass);
		}
		$this -> H_sele($this -> H_db);
		$this -> H_set("utf8");
	}
	public function H_sele($H_db){
		//选择数据库
		if($this->H_debug){
			return mysql_select_db($this->H_data,$H_db);
		}else{
			return @mysql_select_db($this->H_data,$H_db);
		}
	}
	public function H_set($H_char="utf8"){
		//设置返回字符串编码
		if($this->H_debug){
			return mysql_query("SET NAMES '$H_char'");
		}else{
			return @mysql_query("SET NAMES '$H_char'");
		}
	}
	public function H_query($H_sql){
		//发送sql语句
		if($this -> H_log_flag) $this -> H_log -> H_wlog($this -> H_url,$this -> H_name,"mysql",$H_sql);
		if($this->H_debug){
			return mysql_query($H_sql);
		}else{
			return @mysql_query($H_sql);
		}
	}
	public function H_array($H_rest){
		//返回资料数组
		if($this->H_debug){
			return mysql_fetch_array($H_rest);
		}else{
			return @mysql_fetch_array($H_rest);
		}
	}
	public function H_nums($H_rest){
		//返回资料条数
		if($this->H_debug){
			return mysql_num_rows($H_rest);
		}else{
			return @mysql_num_rows($H_rest);
		}
	}
	public function H_afect(){
		//返回资料变动条数
		if($this->H_debug){
			return mysql_affected_rows();
		}else{
			return @mysql_affected_rows();
		}
	}
	public function H_close(){
		//返回资料变动条数
		if($this->H_debug){
			return mysql_close($this -> H_db);
		}else{
			return @mysql_close($this -> H_db);
		}
	}
	public function H_list_dbs(){
		//返回服务器中所有的数据库
		if($this->H_debug){
			return mysql_list_dbs($this -> H_db);
		}else{
			return @mysql_list_dbs($this -> H_db);
		}	
	}
	public function H_fetch_obj($H_list_dbs){
		//返回类资料
		if($this->H_debug){
			return mysql_fetch_object($H_list_dbs);
		}else{
			return @mysql_fetch_object($H_list_dbs);
		}
	}
	public function H_list_table($H_db){
		//返回指定数据库中的所以数据表
		if($this->H_debug){
			return mysql_list_tables($H_db);
		}else{
			return @mysql_list_tables($H_db);
		}	
	}
	public function H_table_name($H_list_table,$H_i){
		//返回指定数据库中的数据表名
		if($this->H_debug){
			return mysql_tablename($H_list_table,$H_i);
		}else{
			return @mysql_tablename($H_list_table,$H_i);
		}	
	}
	public function H_num_fiels($H_resut){
		//返回指定数据库中的数据表的字段数
		if($this->H_debug){
			return mysql_num_fields($H_resut);
		}else{
			return @mysql_num_fields($H_resut);
		}	
	}
	public function H_fetch_field($H_resut,$H_i){
		//返回指定数据库中的数据表的字段信息(类)
		if($this->H_debug){
			return mysql_fetch_field($H_resut,$H_i);
		}else{
			return @mysql_fetch_field($H_resut,$H_i);
		}
	}
	public function H_mysql_dump($H_fname,$H_data,$H_table,$H_mode){
		//备份数据库
		$H_T = $H_D = 0;
		$this -> H_data = $H_data != "" ? $H_data : $this -> H_data;
		if($this -> H_data == "") return ;
		$this -> H_conn();
		$H_table_list = $this -> H_list_table($this -> H_data);
		$H_sum = $this -> H_nums($H_table_list);
		$H_temp_sql = 	"# --------------------------------------------------------\n".
						"# 数据表备份\n".
						"#\n".
						"# 服务器---".($this->H_port == "" ? $this->H_host : $this->H_host.":".$this->H_port)."\n".
						"# MySql-数据库---".$this -> H_data."\n".
						"# MySql-表个数---".$H_sum."个\n".
						"# 备份时间: ".date("Y-m-d H:i:s")."\n".
						"# 作    者: huang_xiang\n".
						"#\n".
						"# --------------------------------------------------------\n\n\n";
		for($H_i = 0;$H_i < $H_sum; $H_i++) $H_table_array[] = $this -> H_table_name($H_table_list,$H_i);
		//for($H_i = $H_sum;$H_i >= 0; $H_i--) $H_table_array[] = $this -> H_table_name($H_table_list,$H_i-1);
		if($H_fname!=""){
			if(!$this -> H_wirte_sql($H_fname,"w",$H_temp_sql)) return ;
		}
		if($H_mode == ""){
			$H_T = $H_D = 1;
		}else{
			$H_T = strpos("my".$H_mode,"T") > 0 ? 1 : $H_T;
			$H_D = strpos("my".$H_mode,"D") > 0 ? 1 : $H_D;	
		}
		if($H_table != ""){
			$H_table_ary = explode(",",$H_table);
			foreach($H_table_ary as $H_val)
				foreach($H_table_array as $H_value)
					if($H_val == $H_value){
						if($H_T == 1) $this -> H_mysql_table($H_val,$H_fname);
						if($H_D == 1) $this -> H_mysql_table_data($H_val,$H_fname);
					}
		}else{
			foreach($H_table_array as $H_value){
				if($H_T == 1) $this -> H_mysql_table($H_value,$H_fname);
				if($H_D == 1) $this -> H_mysql_table_data($H_value,$H_fname);
				echo $H_value;
			}
		}
		$this -> H_close();
		return ;
	}
	public function H_mysql_table($H_table,$H_fname){
		//返回创建该表的sql
		if($H_table == "") return ;
		$H_temp_sql = "# ---------------$H_table Data Structure start-----------------\nDROP TABLE IF EXISTS $H_table;\n";
		if(!$this -> H_wirte_sql($H_fname,"a",$H_temp_sql)) return ;
		$H_temp_array = $this -> H_array($this -> H_query("SHOW CREATE TABLE $H_table"));
		$H_temp_sql = $H_temp_array[1].";\n"; 
		if(!$this -> H_wirte_sql($H_fname,"a",$H_temp_sql)) return ;
		$H_temp_sql = "# ---------------$H_table Data Structure end-----------------\n\n"; 
		if(!$this -> H_wirte_sql($H_fname,"a",$H_temp_sql)) return ;
		unset($H_temp_array,$H_temp_sql);
		return ;
	}
	public function H_mysql_table_data($H_table,$H_fname){
		//返回该表的数据的sql
		if($H_table == "") return ;
		$H_temp_resut = $this -> H_query("SELECT * FROM $H_table");
		$H_fiel_num = $this -> H_num_fiels($H_temp_resut);
		$H_sum = $this -> H_nums($H_temp_resut);
		if($H_sum < 1){
			$H_temp_sql = "# ---------------$H_table Data Recorder NULL-------------------\n\n";
			if(!$this -> H_wirte_sql($H_fname,"a",$H_temp_sql)) return ;
		}else{
			$H_temp_sql ="# ---------------$H_table Data Recorder start----------------\n";
			$H_si = 0;
			$H_size=10;
			while($H_si < $H_sum){
				$H_temp_resut = $this -> H_query("SELECT * FROM $H_table limit $H_si,$H_size");
				while($H_array = $this -> H_array($H_temp_resut)){
					$H_temp_sql .= "INSERT INTO $H_table VALUES(";
					for($H_i = 0;$H_i < $H_fiel_num; $H_i++) $H_temp_sql .= ($H_i == 0 ? "" : ",")."'".@mysql_escape_string($H_array[$H_i])."'";
					$H_temp_sql .= ");\n";
				}
				if(!$this -> H_wirte_sql($H_fname,"a",$H_temp_sql)) return ;
				unset($H_temp_sql);
				$H_si +=$H_size;
			}
			$H_temp_sql ="# ---------------$H_table Data Recorder end--------------------\n\n";
			if(!$this -> H_wirte_sql($H_fname,"a",$H_temp_sql)) return ;
		}
		return ;
	}
	public function H_wirte_sql($H_fname,$H_mode,$H_temp_sql){
		//将sql写入文件里
		if($H_fname=="") return false;
		$H_temp_fp = @fopen($H_fname,$H_mode);
		@set_file_buffer($H_temp_fp,0);
		@fwrite($H_temp_fp,$H_temp_sql);
		@clearstatcache();
		@fclose($H_temp_fp);
		unset($H_temp_sql);
		return true;
	}
}//End Class
?>