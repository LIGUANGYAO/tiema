<?php

    
            //记录sql日志
            //$this->otxt('getmenberinfo',$sql);

            //需要返回这样格式的
            //$list = array("item" => $list, "sum" => count($list),"time"=>date('Y-m-d H:i:s', time()));
            $sql="select id,menber_sn,menber_name,nick_name,figureurl as img_url,10086 as kefu  from menber where token ='".$this->temporary_key."'";
            $res = $GLOBALS['db']->getRow($sql);
            $this->otxt('getmenberinfo',$sql);
            
            $list = array("item" => $res, "sum" => count($res),"time"=>date('Y-m-d H:i:s', time()));
?>