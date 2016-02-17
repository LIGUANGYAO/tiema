<?php


define('IN_ECS', true);

error_reporting(E_ALL & ~ (E_STRICT | E_NOTICE));


require_once (dirname(dirname(__file__)) . '/service/init.php');

require_once (dirname(dirname(__file__)) . '/smtp/class.mail.php');



//获取smtp
function get_smtp()
{
    $sql = "select a.val,b.p_id,b.type,b.type_val,b.note from set_sys a inner join set_sys_mx b on a.keyword=b.p_id where a.keyword='smtp' order by type";
    $res = $GLOBALS['db']->getAll($sql);

    return array("list" => $res, "smtp" => $res[0]['val']);
}


//获取未发送的邮件
function get_sendlist()
{
  
    
    $time = date('Y-m-d H:i:s', time());
    
    $sql="select a.*,b.email,c.kehu_sn,c.kehu_name from msgsend a inner join admin_user b  on  a.user_name=b.user_name inner join kehu c on a.kehu_id=c.id where a.send_time<='".$time."' and a.is_send='0'  and a.fasongleixing='1'";
    $res = $GLOBALS['db']->getAll($sql);
    return $res;
}
$sendlist=get_sendlist();

//print_r($sendlist);

function send_smtp()
{
    $smtp_Arr = get_smtp();
    //判断是否开启发送邮箱
    if($smtp_Arr['smtp']=='1')
    {
        $MailServer = 'smtp.163.com';      //SMTP 服务器
        $MailPort   = '25';					 //SMTP服务器端口号 默认25
        $MailId     = $smtp_Arr['list'][0]['note'];  //服务器邮箱帐号
        $MailPw     = $smtp_Arr['list'][1]['note'];			     //服务器邮箱密码
        /**
        *客户端信息
        */
        //获取发送列表
        $sendlist=get_sendlist();
        for($i=0;$i<count($sendlist);$i++)
        {
            $sendlist[$i]['bz']= mb_convert_encoding($sendlist[$i]['bz'],"GBK","UTF-8"); 
            $sendlist[$i]['kehu_name']= mb_convert_encoding($sendlist[$i]['kehu_name'],"GBK","UTF-8"); 
             //获取邮件内容
            $Title      = '提醒信息';        //邮件标题
            $Content    = '来自CRM系统,提醒创建时间:'.$sendlist[$i]['msgsend_time']."<br>客户:".$sendlist[$i]['kehu_name']."<br>内容:<br>".$sendlist[$i]['bz'];        //邮件内容
            //$email      = '278520061@qq.com';//接收者邮箱
            
            
            if($sendlist[$i]['email']=='')
            {
                //将状态刷成空
           
                
                $up="update msgsend set error_msg='email is null' where msgsend_sn='".$sendlist[$i]['msgsend_sn']."'";
                $up = $GLOBALS['db']->query($up);
                echo $sendlist[$i]['msgsend_sn']."邮箱为空<br>";
                
            }
            else
            {
                $email=$sendlist[$i]['email'];
                
                
                $smtp = new smtp($MailServer,$MailPort,true,$MailId,$MailPw);
                //print_r($smtp);
                $smtp->debug = false;
                if($smtp->sendmail($email,$MailId, $Title, $Content, "HTML")){
                    
                    
                    $up="update msgsend set error_msg='send ok',is_send='1' where msgsend_sn='".$sendlist[$i]['msgsend_sn']."'";
                    $up = $GLOBALS['db']->query($up);
            
                	 echo $sendlist[$i]['msgsend_sn'].'邮件发送成功<br>';            //返回结果
                     //将状态刷成空
                        
                     
                } else {
                        
                     
                     $up="update msgsend set error_msg='send failed',is_send='0' where msgsend_sn='".$sendlist[$i]['msgsend_sn']."'";
                    $up = $GLOBALS['db']->query($up);
            
          
                	 echo $sendlist[$i]['msgsend_sn'].'邮件发送失败<br>';            //$succeed = 0;
                }
            
            }
            
            
            
            
        }
        
       
    }
    else
    {
        echo '系统未开启邮件提醒功能';
    }
}


send_smtp();