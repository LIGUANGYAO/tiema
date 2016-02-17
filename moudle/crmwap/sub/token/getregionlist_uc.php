<?php

    
            //记录sql日志
            //$this->otxt('getregionlist',$sql);

            //需要返回这样格式的
            //$list = array("item" => $list, "sum" => count($list),"time"=>date('Y-m-d H:i:s', time()));
            
            $sql1 = "select region_sn,region_name,region_outer_name
     from region where region_type='1' and p_id=1 order by region_outer_name;";
            $res1 = $GLOBALS['db']->getAll($sql1);
            for($i=0;$i<count($res1);$i++)
            {
                $sql2 = "select region_sn,region_name,region_outer_name
     from region where region_type='2' and p_id='".$res1[$i]['region_sn']."' ;";
                $res1[$i]['city'] = $GLOBALS['db']->getAll($sql2);
                for($j=0;$j<count($res1[$i]['city']);$j++)
                {
                    $sql3 = "select region_sn,region_name
     from region where region_type='3' and p_id='".$res1[$i]['city'][$j]['region_sn']."';";
                    $res1[$i]['city'][$j]['district'] = $GLOBALS['db']->getAll($sql3);
                }
            }
            
            $list = array("item" => $res1, "sum" => count($res1),"time"=>date('Y-m-d H:i:s', time()));
?>