<?php
/*************************************
*	���ݿ�MySql����---H_mysql.php
*	������: huang_xiang
*	����ʱ�䣺2008-12-25 9:29
*	����ʱ�䣺2009-2-18 13:37
*	Email��yin273642232@163.com QQ:273642232
*************************************/
/*************************************
ʵ������
	include_once("H_mysql.php");													//�����ļ�
	$H_mysql = new H_mysql();														//��������
	$H_mysql -> H_conn();															//����:���ݿ�����,����:��;';
	$H_mysql -> H_sele($H_db);														//����:ѡ�����ݿ�,����:$H_db-���ݿ���;';
	$H_mysql -> H_set($H_char="utf8");												//����:�ַ�������,����:$Hchar-��������(Ĭ��utf8);';
	$H_mysql -> H_query($H_sql);													//����:ѡ�����ݿ�,����:$H_sql-sql���;';
	$H_mysql -> H_array($H_rest);													//����:ѡ�����ݿ�,����:$H_rest-���ݿ�����;';
	$H_mysql -> H_nums($H_rest);													//����:ѡ�����ݿ�,����:$H_rest-���ݿ�����;';
	$H_mysql -> H_afect();															//����:ѡ�����ݿ�,����:��;';
	$H_mysql -> H_close();															//����:�ر����ݿ�,����:��;';
	$H_mysql -> H_list_dbs();														//����:���ط����������е����ݿ�,����:��;';
	$H_mysql -> H_fetch_obj();														//����:����������,����:$H_list_dbs-���ݿ��б�;';
	$H_mysql -> H_list_table($H_db);												//����:����ָ�����ݿ��е��������ݱ�,����:$H_db-���ݿ���;';
	$H_mysql -> H_table_name($H_list_table,$H_i);									//����:����ָ�����ݿ��е����ݱ���,����:$H_list_table-�������ݱ�.$H_i-�ڼ�����;';
	$H_mysql -> H_num_fiels($H_resut);												//����:����ָ�����ݿ��е����ݱ���ֶ���,����:$H_resut-��ѯ��Ľ����;';
	$H_mysql -> H_fetch_field($H_field_name,$H_i);									//����:����ָ�����ݿ��е����ݱ���ֶ���Ϣ(��),����:$H_resut-��ѯ��Ľ����.$H_i-�ڼ�����;';
	$H_mysql -> H_mysql_dump($H_data,$H_table,$H_mode);								//����:�������ݿ�,����:$H_data-���ݿ���.$H_table-���ݱ���(table1,table2,..).$H_mode-���ݿ���(""or"T"or"TD");';
	$H_mysql -> H_mysql_table($H_table);											//����:���ش����ñ��sql,����:$H_table-���ݱ���;';
	$H_mysql -> H_mysql_table_data($H_table);										//����:���ظñ�����ݵ�sql,����:$H_table-���ݱ���;';
	$H_mysql -> H_wirte_sql($H_fname,$H_mode,$H_temp_sql);							//����:���ظñ�����ݵ�sql,����:$H_fname-�����ļ���.$H_mode-����ģʽ,$H_temp_sql-���ݵ�sql���;';
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
	public $H_desce;					//����
	public $H_ROOT_DIR;					//�ļ���ַ·��
	public $H_log;
	public $H_url;						//����·��
	public $H_name;						//�����û�
	
	public function __construct(){
		//��ʵ����һ�������ʱ��������������������ȱ�����
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
 		//��ɾ��һ���������������ֹ��ʱ�򣬵��ø÷���
 		return '';
 	}
 	public function __get($key){
 		//����ͼ��ȡһ���������ڵ����Ե�ʱ�򱻵���
  		return '['.$key.'] Variable not find';
  	}
  	public function __set($key,$val){
 		//����ͼ��һ���������ڵ�����д��ֵ��ʱ�򱻵���
  		return '['.$key.'] Variable not find';
  	}
  	public function __call($key,$args){
  		//����ͼ����һ�����󲢲����ڵķ���ʱ�����ø÷���
  		return '['.$key.'] Function not find';
	}
	public function __toString(){
		//����ӡһ�������ʱ�򱻵���
		return $this -> H_desce();
  	}
  	public function __clone(){
  		//�����󱻿�¡ʱ��������
  		return "clone";
  	}
	public function H_desce(){
		//��������
		$this -> H_desce .= '����:H_mysql-���ݿ�MySql����;';
		$this -> H_desce .= '����:H_conn(),����:���ݿ�����,����:��;';
		$this -> H_desce .= '����:H_sele($H_db),����:ѡ�����ݿ�,����:$H_db-���ݿ���;';
		$this -> H_desce .= '����:H_set($H_char="utf8"),����:�ַ�������,����:$Hchar-��������(Ĭ��utf8);';
		$this -> H_desce .= '����:H_query($H_sql),����:ѡ�����ݿ�,����:$H_sql-sql���;';
		$this -> H_desce .= '����:H_array($H_rest),����:ѡ�����ݿ�,����:$H_rest-���ݿ�����;';
		$this -> H_desce .= '����:H_nums($H_rest),����:ѡ�����ݿ�,����:$H_rest-���ݿ�����;';
		$this -> H_desce .= '����:H_afect(),����:ѡ�����ݿ�,����:��;';
		$this -> H_desce .= '����:H_close(),����:�ر����ݿ�,����:��;';
		$this -> H_desce .= '����:H_list_dbs(),����:�����������е����ݿ�,����:��;';
		$this -> H_desce .= '����:H_fetch_obj(),����:������,����:$H_list_dbs-���ݿ��б�;';
		$this -> H_desce .= '����:H_list_table($H_db),����:ָ�����ݿ��е��������ݱ�,����:$H_db-���ݿ���;';
		$this -> H_desce .= '����:H_table_name($H_list_table,$H_i),����:ָ�����ݿ��е����ݱ���,����:$H_list_table-�������ݱ�.$H_i-�ڼ�����;';
		$this -> H_desce .= '����:H_num_fiels($H_resut),����:ָ�����ݿ��е����ݱ���ֶ���,����:$H_resut-��ѯ��Ľ����;';
		$this -> H_desce .= '����:H_fetch_field($H_field_name,$H_i),����:ָ�����ݿ��е����ݱ���ֶ���Ϣ(��),����:$H_resut-��ѯ��Ľ����.$H_i-�ڼ�����;';
		$this -> H_desce .= '����:H_mysql_dump($H_data,$H_table,$H_mode),����:�������ݿ�,����:$H_data-���ݿ���.$H_table-���ݱ���(table1,table2������).$H_mode-���ݿ���(""or"T"or"TD");';
		$this -> H_desce .= '����:H_mysql_table($H_table),����:�����ñ��sql,����:$H_table-���ݱ���;';
		$this -> H_desce .= '����:H_mysql_table_data($H_table),����:�ñ�����ݵ�sql,����:$H_table-���ݱ���;';
		$this -> H_desce .= '����:H_wirte_sql($H_fname,$H_mode,$H_temp_sql),����:�ñ�����ݵ�sql,����:$H_fname-�����ļ���.$H_mode-����ģʽ,$H_temp_sql-���ݵ�sql���;';
		return $this -> H_desce;
	}
	public function H_conn(){
		//�������ݿ�
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
		//ѡ�����ݿ�
		if($this->H_debug){
			return mysql_select_db($this->H_data,$H_db);
		}else{
			return @mysql_select_db($this->H_data,$H_db);
		}
	}
	public function H_set($H_char="utf8"){
		//���÷����ַ�������
		if($this->H_debug){
			return mysql_query("SET NAMES '$H_char'");
		}else{
			return @mysql_query("SET NAMES '$H_char'");
		}
	}
	public function H_query($H_sql){
		//����sql���
		if($this -> H_log_flag) $this -> H_log -> H_wlog($this -> H_url,$this -> H_name,"mysql",$H_sql);
		if($this->H_debug){
			return mysql_query($H_sql);
		}else{
			return @mysql_query($H_sql);
		}
	}
	public function H_array($H_rest){
		//������������
		if($this->H_debug){
			return mysql_fetch_array($H_rest);
		}else{
			return @mysql_fetch_array($H_rest);
		}
	}
	public function H_nums($H_rest){
		//������������
		if($this->H_debug){
			return mysql_num_rows($H_rest);
		}else{
			return @mysql_num_rows($H_rest);
		}
	}
	public function H_afect(){
		//�������ϱ䶯����
		if($this->H_debug){
			return mysql_affected_rows();
		}else{
			return @mysql_affected_rows();
		}
	}
	public function H_close(){
		//�������ϱ䶯����
		if($this->H_debug){
			return mysql_close($this -> H_db);
		}else{
			return @mysql_close($this -> H_db);
		}
	}
	public function H_list_dbs(){
		//���ط����������е����ݿ�
		if($this->H_debug){
			return mysql_list_dbs($this -> H_db);
		}else{
			return @mysql_list_dbs($this -> H_db);
		}	
	}
	public function H_fetch_obj($H_list_dbs){
		//����������
		if($this->H_debug){
			return mysql_fetch_object($H_list_dbs);
		}else{
			return @mysql_fetch_object($H_list_dbs);
		}
	}
	public function H_list_table($H_db){
		//����ָ�����ݿ��е��������ݱ�
		if($this->H_debug){
			return mysql_list_tables($H_db);
		}else{
			return @mysql_list_tables($H_db);
		}	
	}
	public function H_table_name($H_list_table,$H_i){
		//����ָ�����ݿ��е����ݱ���
		if($this->H_debug){
			return mysql_tablename($H_list_table,$H_i);
		}else{
			return @mysql_tablename($H_list_table,$H_i);
		}	
	}
	public function H_num_fiels($H_resut){
		//����ָ�����ݿ��е����ݱ���ֶ���
		if($this->H_debug){
			return mysql_num_fields($H_resut);
		}else{
			return @mysql_num_fields($H_resut);
		}	
	}
	public function H_fetch_field($H_resut,$H_i){
		//����ָ�����ݿ��е����ݱ���ֶ���Ϣ(��)
		if($this->H_debug){
			return mysql_fetch_field($H_resut,$H_i);
		}else{
			return @mysql_fetch_field($H_resut,$H_i);
		}
	}
	public function H_mysql_dump($H_fname,$H_data,$H_table,$H_mode){
		//�������ݿ�
		$H_T = $H_D = 0;
		$this -> H_data = $H_data != "" ? $H_data : $this -> H_data;
		if($this -> H_data == "") return ;
		$this -> H_conn();
		$H_table_list = $this -> H_list_table($this -> H_data);
		$H_sum = $this -> H_nums($H_table_list);
		$H_temp_sql = 	"# --------------------------------------------------------\n".
						"# ���ݱ���\n".
						"#\n".
						"# ������---".($this->H_port == "" ? $this->H_host : $this->H_host.":".$this->H_port)."\n".
						"# MySql-���ݿ�---".$this -> H_data."\n".
						"# MySql-�����---".$H_sum."��\n".
						"# ����ʱ��: ".date("Y-m-d H:i:s")."\n".
						"# ��    ��: huang_xiang\n".
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
		//���ش����ñ��sql
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
		//���ظñ�����ݵ�sql
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
		//��sqlд���ļ���
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