<?php


//记录sql日志
//$this->otxt('getdaleilist',$sql);

//需要返回这样格式的
//$list = array("item" => $list, "sum" => count($list),"time"=>date('Y-m-d H:i:s', time()));

class get_dalei
{
    function GetDaleiFjsx1()
    {
        $sql = "select id,dl_sn,dl_name,note,action_url,img_1 from dalei where  tzsy=0 order by sort_no,id";
        $res = $GLOBALS['db']->getAll($sql);

        for ($i = 0; $i < count($res); $i++) {
            $sql2 = "select id,sx_sn,sx_name,note,p_id,action_url,img_1 from fjsx1 where p_id='" .
                $res[$i]['id'] . "' and tzsy=0  order by sort_no,id";
            $res[$i]['fjsx1'] = $GLOBALS['db']->getAll($sql2);

        }
        return $res;
    }

    //获取某个类型的服务dalei
    function GetDalei($obj)
    {
        $sql = "select id,dl_sn,dl_name,note,action_url,img_1 from dalei where id='" . $obj .
            "' and tzsy=0 order by sort_no,id";

        $res = $GLOBALS['db']->getRow($sql);


        return $res;
    }

    //获取某个id 获取fjsx1  id
    function GetFjsx1($obj)
    {
        $sql = "select id,sx_sn,sx_name,note,p_id,action_url,img_1 from fjsx1 where id='" .
            $obj . "' and tzsy=0  order by sort_no,id";
        $res = $GLOBALS['db']->getRow($sql);


        return $res;
    }


    //获取某个id 获取fjsx1  id
    function GetFjsx1mx($obj)
    {
        $sql = "select id,sx_sn,sx_name,note,p_id,action_url,img_1 from fjsx1 where p_id='" .
            $obj . "' and tzsy=0  order by sort_no,id";
        $res = $GLOBALS['db']->getAll($sql);


        return $res;
    }


}

    $ex=new get_dalei();
    $DaleiFjsx1=$ex->GetDaleiFjsx1();
    
    $list = array("item" => $DaleiFjsx1, "sum" => count($DaleiFjsx1),"time"=>date('Y-m-d H:i:s', time()));


?>