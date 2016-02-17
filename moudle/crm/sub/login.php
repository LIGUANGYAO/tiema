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
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=0 order by -sort_order desc;" ;
            
        $res = $GLOBALS['db']->getAll($sql);
      return $res;
        //print_r($sql);
    
    }
    
    
        public function get_action_2()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=1 order by -sort_order desc;" ;
            
        $res = $GLOBALS['db']->getAll($sql);
      return $res;
        //print_r($sql);
    
    }
         public function get_action_3()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=2 order by -sort_order desc;" ;
            
        $res = $GLOBALS['db']->getAll($sql);
      return $res;
        //print_r($sql);
    
    }
    
            public function get_action_4()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=3 order by -sort_order desc;" ;
            
        $res = $GLOBALS['db']->getAll($sql);
      return $res;
        //print_r($sql);
    
    }
            public function get_action_5()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=4 order by -sort_order desc;" ;
            
        $res = $GLOBALS['db']->getAll($sql);
      return $res;
        //print_r($sql);
    
    }
    
           public function get_action_6()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=5 order by -sort_order desc;" ;
            
        $res = $GLOBALS['db']->getAll($sql);
      return $res;
        //print_r($sql);
    
    }
    
           public function get_action_7()
    {
        $action_list = array();
        $sql = "SELECT action_id,parent_id,type,action_name,action_code,sort_order,cid,priv_type FROM action where is_show=1  and parent_id=6 order by -sort_order desc;" ;
            
        $res = $GLOBALS['db']->getAll($sql);
      return $res;
        //print_r($sql);
    
    }
}



?>