<?php



function get_lylx()
{
    $sql = "select id,name,
                    code,
                    enable,
                    reg_order_no,
                    reg_order_no2,
                    reg_order_no3,
                    is_bz
 from lylx;";
    $item = $GLOBALS['db']->getAll($sql);
    return $item;
}


function get_lylx2($obj)
{
    if(isset($obj))
    {
       $sql = "select id,name,
                    code,
                    enable,
                    reg_order_no,
                    reg_order_no2,
                    reg_order_no3,
                    is_bz
 from lylx where id='".$obj."';";
    $item = $GLOBALS['db']->getAll($sql);
    return $item; 
    }
    
}

?>