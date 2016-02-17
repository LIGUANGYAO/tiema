<?php



function get_region()
{
    $sql = "select region_sn,region_name
 from region ;";
    $item = $GLOBALS['db']->getAll($sql);
    return $item;
}


function get_region2($province,$city,$district)
{


    $sql1 = "select region_sn,region_name
     from region where region_type='1' and p_id=1;";
    $item['province'] = $GLOBALS['db']->getAll($sql1);
    $sql2 = "select region_sn,region_name
     from region where region_type='2' and p_id='".$province."';";
    $item['city'] = $GLOBALS['db']->getAll($sql2);
    $sql3 = "select region_sn,region_name
     from region where region_type='3' and p_id='".$city."';";
    $item['district'] = $GLOBALS['db']->getAll($sql3);


    return $item;


}


function get_region3($province,$city,$district)
{


    $sql1 = "select region_sn,region_name
     from region where region_sn='".$province."';";
    $item['province'] = $GLOBALS['db']->getAll($sql1);
    $sql2 = "select region_sn,region_name
     from region where region_sn='".$city."';";
    $item['city'] = $GLOBALS['db']->getAll($sql2);
     $sql3 = "select region_sn,region_name
     from region where region_sn='".$district."';";
    $item['district'] = $GLOBALS['db']->getAll($sql3);


    return $item;


}



function get_city($province)
{



    $sql2 = "select region_sn,region_name
     from region where region_type='2' and p_id='".$province."';";
    $item['city'] = $GLOBALS['db']->getAll($sql2);
    


    return $sql2;


}
?>