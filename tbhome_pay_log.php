<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');
require (dirname(__file__) . '/sub/page.php');
require (dirname(__file__) . '/sub/sub_fcsend.php');
require (dirname(__file__) . '/sub/tbhome_sub_g_id.php');


if (empty($_REQUEST['act'])) {
    $_REQUEST['act'] = 'default';
} else {
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'default') {
    
    if (isset($_REQUEST['t1'])) {
        $t1 = $_REQUEST['t1'];

    }
    if (isset($_REQUEST['t2'])) {
        $t2 = $_REQUEST['t2'];
    }
    
     $is_att= trim($_REQUEST['is_att']);
    if($is_att=='')
    {
        $is_att=2;
    }
    
    
      //添加时间间隔
    $time = date('Y-m-d', time());
    $data = strtotime($time); //减去三天的时间
    $data = $data - (60 * 60 * 24 * 30); //打印出三天的时间
    $th_time = date("Y-m-d", $data);
    if (isset($_REQUEST['t1'])) {
        $th_time = $_REQUEST['t1'];
    }
    if (isset($_REQUEST['t2'])) {
        $time = $_REQUEST['t2'];
    }

    

 //   $sql="select a.*,from_unixtime(a.add_time) as time,from_unixtime(a.send_time) as send_time2,b.openid,b.nick_name,b.sex,c.openid as p_openid2,c.nick_name as p_nick_name,c.sex as p_sex from  wxpay_fclog a inner join users b on a.openid=b.openid inner join users c on a.p_openid =c.openid";

    $sqlPay="select * from tbhome_pay_log";
    $payList=$GLOBALS['db']->getAll($sqlPay);

    
//   $fcsend_list = get_fcsend_list($Num, "wxpay_fclog", $sql);

 /*
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

$user=new Split();
    for($i=0; $i<count($payList); $i++){
     $user->SetTable('tbhome_wx_users');
    $user->SetID($payList[$i]['openid']);
     $user->SetField('openid');
         $user->SetUpField('up_openid');

   $inf03=$user->GetUpInfo(3);
  $inf02=$user->GetUpInfo(2);
  $inf01=$user->GetUpInfo(1);
        $payList[$i]['from']=$payList[$i]['nickname'].

    }
 */

    $smarty->assign('th_time', $th_time);
    $smarty->assign('now_time', $time);
      $smarty->assign('is_att',$is_att);
      $smarty->assign('m_key',$_REQUEST['m_key']);
      
      
//    $smarty->assign('fcsend_list', $fcsend_list['items']);
    $smarty->assign('fcsend_list', $payList);
    $smarty->assign('fall', 1);
 //   $smarty->assign('p_Array', $fcsend_list['page']);
    $smarty->display('tbhome_pay_log.html');


}

?>