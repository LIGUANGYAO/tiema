<?php


function get_Wxgrowth($openid,$week)
{
    $sql="select * from wxgrowth where openid='".$openid."' and week='".$week."'";
    
    $res = $GLOBALS['db']->getRow($sql);
    $mx="select *,((case when xm1=1 then 1 when xm1!=1 then 0 end) +
    (case when xm2=1 then 1 when xm2!=1 then 0 end)+
    (case when xm3=1 then 1 when xm3!=1 then 0 end)+
    (case when xm4=1 then 1 when xm4!=1 then 0 end)+
    (case when xm5=1 then 1 when xm5!=1 then 0 end)+
    (case when xm6=1 then 1 when xm6!=1 then 0 end)+
    (case when xm7=1 then 1 when xm7!=1 then 0 end)+
    (case when xm8=1 then 1 when xm8!=1 then 0 end)
    
    ) as c_sl
   
    
     from wxgrowth_mx where p_id='".$res['wx_growth_sn']."'";
    $res_mx = $GLOBALS['db']->getAll($mx);
    
    //统计总数量
    
    $sum="select sum(xm1) as xm1,sum(xm2) as xm2,sum(xm3) as xm3,sum(xm4) as xm4,sum(xm5) as xm5,sum(xm6) as xm6,sum(xm7) as xm7,sum(xm8) as xm8,sum((case when xm1=1 then 1 when xm1!=1 then 0 end) +
    (case when xm2=1 then 1 when xm2!=1 then 0 end)+
    (case when xm3=1 then 1 when xm3!=1 then 0 end)+
    (case when xm4=1 then 1 when xm4!=1 then 0 end)+
    (case when xm5=1 then 1 when xm5!=1 then 0 end)+
    (case when xm6=1 then 1 when xm6!=1 then 0 end)+
    (case when xm7=1 then 1 when xm7!=1 then 0 end)+
    (case when xm8=1 then 1 when xm8!=1 then 0 end)
    
    ) as c_sl
   
    
     from wxgrowth_mx where p_id='".$res['wx_growth_sn']."'";
    $sum = $GLOBALS['db']->getRow($sum);
    //--
    $res['mx']=$res_mx;
    return array("item"=>$res,"sum"=>$sum);
}



function get_Wxgrowth2($openid,$year)
{
    $sql="select 
sum((case when b.xm1=1 then 1 when b.xm1!=1 then 0 end) +
    (case when b.xm2=1 then 1 when b.xm2!=1 then 0 end)+
    (case when b.xm3=1 then 1 when b.xm3!=1 then 0 end)+
    (case when b.xm4=1 then 1 when b.xm4!=1 then 0 end)+
    (case when b.xm5=1 then 1 when b.xm5!=1 then 0 end)+
    (case when b.xm6=1 then 1 when b.xm6!=1 then 0 end)+
    (case when b.xm7=1 then 1 when b.xm7!=1 then 0 end)+
    (case when b.xm8=1 then 1 when b.xm8!=1 then 0 end)
    
    ) as c_sl

 from wxgrowth  a inner join wxgrowth_mx b on a.wx_growth_sn=b.p_id where a.openid='".$openid."' and a.week_start<'".$year."'";
    
    
    $res = $GLOBALS['db']->getRow($sql);
   
    return $res;
}







?>