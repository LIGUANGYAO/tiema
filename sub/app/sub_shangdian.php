<?php



function get_shangdian()
{
    $sql = "select sdmc,sddm
 from shangdian;";
    $item = $GLOBALS['db']->getAll($sql);
    return $item;
}


function get_shangdian2($obj)
{
    if(isset($obj))
    {
       $sql = "select sdmc,sddm
 from shangdian where id='".$obj."';";
    $item = $GLOBALS['db']->getAll($sql);
    return $item; 
    }
    
}

?>