<?php

    
            //��¼sql��־
            //$this->otxt('getmenberinfo',$sql);

            //��Ҫ����������ʽ��
            //$list = array("item" => $list, "sum" => count($list),"time"=>date('Y-m-d H:i:s', time()));
            $sql="select id,menber_sn,menber_name,nick_name,figureurl as img_url,10086 as kefu  from menber where token ='".$this->temporary_key."'";
            $res = $GLOBALS['db']->getRow($sql);
            $this->otxt('getmenberinfo',$sql);
            
            $list = array("item" => $res, "sum" => count($res),"time"=>date('Y-m-d H:i:s', time()));
?>