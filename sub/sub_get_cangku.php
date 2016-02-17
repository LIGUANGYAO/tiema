<?php



function get_cangku()
{
    $sql = "select id,cangku_sn,cangku_name
 from cangku;";
    $item = $GLOBALS['db']->getAll($sql);
    return $item;
}


function get_cangku2($obj)
{
    if(isset($obj))
    {
       $sql = "select id,cangku_sn,cangku_name
 from cangku where id='".$obj."';";
    $item = $GLOBALS['db']->getAll($sql);
   // print_r($item);
    return $item; 
    }
    
}

?>