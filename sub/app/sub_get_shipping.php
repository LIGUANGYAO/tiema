<?php



function get_shipping()
{
    $sql = "select shipping_sn,shipping_name
 from shipping;";
    $item = $GLOBALS['db']->getAll($sql);
    return $item;
}


function get_shipping2($obj)
{
    if(isset($obj))
    {
       $sql = "select shipping_sn,shipping_name
 from shipping where shipping_sn='".$obj."';";
    $item = $GLOBALS['db']->getAll($sql);
   // print_r($item);
    return $item; 
    }
    
}

?>