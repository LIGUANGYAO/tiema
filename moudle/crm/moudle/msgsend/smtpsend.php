<?php


define('IN_ECS', true);

error_reporting(E_ALL & ~ (E_STRICT | E_NOTICE));


require_once (dirname(dirname(__file__)) . '/service/init.php');

require_once (dirname(dirname(__file__)) . '/smtp/class.mail.php');



//��ȡsmtp
function get_smtp()
{
    $sql = "select a.val,b.p_id,b.type,b.type_val,b.note from set_sys a inner join set_sys_mx b on a.keyword=b.p_id where a.keyword='smtp' order by type";
    $res = $GLOBALS['db']->getAll($sql);

    return array("list" => $res, "smtp" => $res[0]['val']);
}


//��ȡδ���͵��ʼ�
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
    //�ж��Ƿ�����������
    if($smtp_Arr['smtp']=='1')
    {
        $MailServer = 'smtp.163.com';      //SMTP ������
        $MailPort   = '25';					 //SMTP�������˿ں� Ĭ��25
        $MailId     = $smtp_Arr['list'][0]['note'];  //�����������ʺ�
        $MailPw     = $smtp_Arr['list'][1]['note'];			     //��������������
        /**
        *�ͻ�����Ϣ
        */
        //��ȡ�����б�
        $sendlist=get_sendlist();
        for($i=0;$i<count($sendlist);$i++)
        {
            $sendlist[$i]['bz']= mb_convert_encoding($sendlist[$i]['bz'],"GBK","UTF-8"); 
            $sendlist[$i]['kehu_name']= mb_convert_encoding($sendlist[$i]['kehu_name'],"GBK","UTF-8"); 
             //��ȡ�ʼ�����
            $Title      = '������Ϣ';        //�ʼ�����
            $Content    = '����CRMϵͳ,���Ѵ���ʱ��:'.$sendlist[$i]['msgsend_time']."<br>�ͻ�:".$sendlist[$i]['kehu_name']."<br>����:<br>".$sendlist[$i]['bz'];        //�ʼ�����
            //$email      = '278520061@qq.com';//����������
            
            
            if($sendlist[$i]['email']=='')
            {
                //��״̬ˢ�ɿ�
           
                
                $up="update msgsend set error_msg='email is null' where msgsend_sn='".$sendlist[$i]['msgsend_sn']."'";
                $up = $GLOBALS['db']->query($up);
                echo $sendlist[$i]['msgsend_sn']."����Ϊ��<br>";
                
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
            
                	 echo $sendlist[$i]['msgsend_sn'].'�ʼ����ͳɹ�<br>';            //���ؽ��
                     //��״̬ˢ�ɿ�
                        
                     
                } else {
                        
                     
                     $up="update msgsend set error_msg='send failed',is_send='0' where msgsend_sn='".$sendlist[$i]['msgsend_sn']."'";
                    $up = $GLOBALS['db']->query($up);
            
          
                	 echo $sendlist[$i]['msgsend_sn'].'�ʼ�����ʧ��<br>';            //$succeed = 0;
                }
            
            }
            
            
            
            
        }
        
       
    }
    else
    {
        echo 'ϵͳδ�����ʼ����ѹ���';
    }
}


send_smtp();