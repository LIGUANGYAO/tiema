<?php



function get_order_goods()
{
    $sql = "select a.goods_barcode,a.goods_sn,a.goods_name,b.color_name,b.color_sn,b.id,c.id,c.size_sn,c.size_name,a.goods_number,market_price,goods_price
 from order_goods a left join color b on a.color_id=b.id left join size c on a.size_id=c.id ;";
    $item = $GLOBALS['db']->getAll($sql);
    return $item;
}


function get_order_goods2($obj)
{
    if(isset($obj))
    {
       $sql = "select a.goods_barcode,a.goods_sn,a.goods_name,b.color_name,b.color_sn,b.id,c.id,c.size_sn,c.size_name,a.goods_number,market_price,goods_price
 from order_goods a left join color b on a.color_id=b.id left join size c on a.size_id=c.id  where order_id='".$obj."';";
    $item = $GLOBALS['db']->getAll($sql);
   // print_r($item);
    return $item; 
    }
    
}

?>