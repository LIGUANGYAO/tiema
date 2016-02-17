<?php



class restlogin
{

    public $is_allow = 1;
    public $err;
    public $temporary_time;
  
    function exes($users_sn,$password)
    {
        return $this->exe1($users_sn,$password);
    }
 
    
    private function exe1($users_sn,$password)
    {       
                    
                
                
              $timesa=date('Y-m-d H:i:s', time());
              $temporary_key=md5(substr(md5($us_name),8,16).substr(md5($password),8,16)."sdmaldieiow12!@#$".md5("~+!MMD@*&#&(!!)#@#*&NCNSP#@").rand(1,999999).md5($timesa));
              $temporary_key=substr(md5($temporary_key),8,16);
               $sql_u = " update  users set temporary_key='".$temporary_key."',temporary_time='".$timesa."' where users_sn='" .$users_sn . "' and password='" . $password . "';";
                $user_id = $GLOBALS['db']->query($sql_u);
                $this->err['err'] = 1;
                $this->err['msg'] = "success"; //
              
            return $temporary_key;
        

        
    }




}
?>