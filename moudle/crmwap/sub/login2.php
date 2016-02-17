<?php
function get_user_rank_list()
{
    $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('user_rank') .
        " ORDER BY min_points";

    return $GLOBALS['db']->getAll($sql);
}

/**
 * 取得某商品的会员价格列表
 * @param   int     $goods_id   商品编号
 * @return  array   会员价格列表 user_rank => user_price
 */
function get_member_price_list($goods_id)
{
    /* 取得会员价格 */
    $price_list = array();
    $sql = "SELECT user_rank, user_price FROM " . $GLOBALS['ecs']->table('member_price') .
        " WHERE goods_id = '$goods_id'";
    $res = $GLOBALS['db']->query($sql);
    while ($row = $GLOBALS['db']->fetchRow($res)) {
        $price_list[$row['user_rank']] = $row['user_price'];
    }

    return $price_list;
}


class login_on
{
    //action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type
    public function get_action()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=0 order by -sort_order desc;";

        $res = $GLOBALS['db']->getAll($sql);
        return $res;
        //print_r($sql);

    }


    public function get_action_2()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=1 order by -sort_order desc;";

        $res = $GLOBALS['db']->getAll($sql);
        return $res;
        //print_r($sql);

    }
    public function get_action_3()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=2 order by -sort_order desc;";

        $res = $GLOBALS['db']->getAll($sql);
        return $res;
        //print_r($sql);

    }

    public function get_action_4()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=3 order by -sort_order desc;";

        $res = $GLOBALS['db']->getAll($sql);
        return $res;
        //print_r($sql);

    }
    public function get_action_5()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=4 order by -sort_order desc;";

        $res = $GLOBALS['db']->getAll($sql);
        return $res;
        //print_r($sql);

    }

    public function get_action_6()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=5 order by -sort_order desc;";

        $res = $GLOBALS['db']->getAll($sql);
        return $res;
        //print_r($sql);

    }

    public function get_action_7()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=6 order by -sort_order desc;";

        $res = $GLOBALS['db']->getAll($sql);
        return $res;
        //print_r($sql);

    }


    public function get_action_8()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=41 order by -sort_order desc;";

        $res = $GLOBALS['db']->getAll($sql);
        return $res;
        //print_r($sql);

    }


    public function get_action_9()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=42 order by -sort_order desc;";

        $res = $GLOBALS['db']->getAll($sql);
        return $res;
        //print_r($sql);

    }
    public function get_action_10()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=43 order by -sort_order desc;";

        $res = $GLOBALS['db']->getAll($sql);
        return $res;
        //print_r($sql);

    }
    public function get_action_11()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=44 order by -sort_order desc;";

        $res = $GLOBALS['db']->getAll($sql);
        return $res;
        //print_r($sql);

    }
    public function get_action_12()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=45 order by -sort_order desc;";

        $res = $GLOBALS['db']->getAll($sql);
        return $res;
        //print_r($sql);

    }
    public function get_action_13()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=46 order by -sort_order desc;";

        $res = $GLOBALS['db']->getAll($sql);
        return $res;
        //print_r($sql);

    }


    public function get_action_14()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=47 order by -sort_order desc;";

        $res = $GLOBALS['db']->getAll($sql);
        return $res;
        //print_r($sql);

    }

    public function get_action_15()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=48 order by -sort_order desc;";

        $res = $GLOBALS['db']->getAll($sql);
        return $res;
        //print_r($sql);

    }
    public function get_action_16()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=70 order by -sort_order desc;";

        $res = $GLOBALS['db']->getAll($sql);
        return $res;
        //print_r($sql);

    }


    public function get_action_17()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=71 order by -sort_order desc;";

        $res = $GLOBALS['db']->getAll($sql);
        return $res;
        //print_r($sql);

    }


    public function get_action_18()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=81 order by -sort_order desc;";

        $res = $GLOBALS['db']->getAll($sql);
        return $res;
        //print_r($sql);

    }


}


class new_login_on
{
    public $obj='';
    public $obj2='';
    public $user_sn='';
    
    public function get_action_c1()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and  type='c1' order by -sort_order desc;";
        
        $res = $GLOBALS['db']->getAll($sql);
        return $res;
    }
    public function get_action_c2()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and  type='c2' and parent_id='".$this->obj."' order by -sort_order desc;";
        //$sql = "SELECT a.* FROM action a  inner join role_act b on a.action_id=b.act_id inner join role_user c on  c.p_id=b.p_id where a.is_show=1  and  a.type='c2' and a.parent_id='".$this->obj."' order by -a.sort_order desc;";
        
//echo $sql;
        $res = $GLOBALS['db']->getAll($sql);
        return $res;
    }
    public function get_action_c3()
    {
        $action_list = array();
        if($this->user_sn=='000')
        {
          $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and  type='c3' and parent_id='".$this->obj2."' order by -sort_order desc;";  
        }
        else
        {
             $sql = "SELECT a.*,b.* FROM action a  inner join role_act b on a.action_id=b.act_id inner join role_user c on  c.p_id=b.p_id where a.is_show=1  and  a.type='c3' and b.val=1 and a.parent_id='".$this->obj2."' and c.user_sn='".$this->user_sn."'  group by b.val ,b.act_id,c.user_name  order by -a.sort_order,-b.act_id desc;";
        }
        
       
        //echo $sql."</br>";
        $res = $GLOBALS['db']->getAll($sql);
        return $res;
    }
}

?>