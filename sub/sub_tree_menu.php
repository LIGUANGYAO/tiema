<?php

/**
 * @author Steve Smith
 * @copyright 2014
 */
function getTree($data, $pId)
{
$tree = '';
foreach($data as $k => $v)
{
   if($v['p_id'] == $pId)
   {         //╦╦гвур╣╫╤Ывс
    $v['p_id2'] = getTree($data, $v['custom_sn']);
    $tree[] = $v;
    //unset($data[$k]);
   }
}
return $tree;
}


?>