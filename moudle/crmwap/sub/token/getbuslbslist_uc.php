<?php

    
            //记录sql日志
            //$this->otxt('getbuslbslist',$sql);

            //需要返回这样格式的
            //$list = array("item" => $list, "sum" => count($list),"time"=>date('Y-m-d H:i:s', time()));
            //计算经纬度
            class get_region
            {
                //获取所有省的信息
                function GetProvince()
                {
                    
                    //获取p_id为1中国的省份
                    $sql="select id,p_id,region_name,region_type,region_outer_name,region_nick from region where p_id=1 and tzsy=0 order by sort_no,id";
                    $res = $GLOBALS['db']->getAll($sql);
                    return $res;
                }
                
                //获取所有省的信息
                function GetCity($obj)
                {
                    
                    $sql="select id,p_id,region_name,region_type,region_outer_name,region_nick,pinyin from region where p_id='".$obj."'  and tzsy=0 order by sort_no,id";
                    $res = $GLOBALS['db']->getAll($sql);
                    return $res;
                }
                //通过城市名字获取全拼
                function GetPinyin($obj)
                {
                    $sql="select id,p_id,region_name,region_type,region_outer_name,region_nick,pinyin from region where region_name like '%".$obj."%'  and tzsy=0 order by sort_no,id";
                    //echo $sql;
                    $res = $GLOBALS['db']->getRow($sql);
                    return $res;
                }
                
                //通过城市拼音获取全拼
                function GetPinyinAll($obj)
                {
                    $sql="select id,p_id,region_name,region_type,region_outer_name,region_nick,pinyin from region where pinyin = '".$obj."'  and tzsy=0 order by sort_no,id";
                    $res = $GLOBALS['db']->getRow($sql);
                    return $res;
                }
                
                function GetHotCity()
                {
                    $sql="select id,p_id,region_name,region_type,region_outer_name,region_nick,pinyin from region where is_hot='1'  and region_type=2  and tzsy=0 order by sort_no,id";
                    $res = $GLOBALS['db']->getAll($sql);
                    return $res;
                }
                
                function GetId($obj)
                {
                    $sql="select id,p_id,region_name,region_type,region_outer_name,region_nick,pinyin from region where id='".$obj."'  and tzsy=0 order by sort_no,id";
                    $res = $GLOBALS['db']->getRow($sql);
                    return $res;
                }
                
                
                function GetDis($obj)
                {
                    $sql="select id,p_id,region_name,region_type,region_outer_name,region_nick,pinyin from region where  pinyin = '".$obj."'   and tzsy=0  order by sort_no,id";
                    $res = $GLOBALS['db']->getRow($sql);
                    
                    $sql2="select id,p_id,region_name,region_type,region_outer_name,region_nick,pinyin from region where  p_id='".$res['id']."'   and tzsy=0   order by sort_no,id";
                    $res2 = $GLOBALS['db']->getAll($sql2);
                    return $res2;
                }
                
                
                function IdGetDis($obj)
                {
                    
                    
                    $sql2="select id,p_id,region_name,region_type,region_outer_name,region_nick,pinyin from region where  p_id='".$obj."'   and tzsy=0   order by sort_no,id";
                    $res2 = $GLOBALS['db']->getAll($sql2);
                    return $res2;
                }
                
                
                //根据区的id获取省和市的id
                function DisIdGetCityP($obj)
                {
                    
                    
                    $sql2="select id,p_id from region where  id='".$obj."'   and tzsy=0   order by sort_no,id";
                    $res2 = $GLOBALS['db']->getRow($sql2);
                    
                    $sql3="select id,p_id from region where  id='".$res2['p_id']."'   and tzsy=0   order by sort_no,id";
                    $res3 = $GLOBALS['db']->getRow($sql3);
                    return array('dis_id'=>$obj,'city_id'=>$res2['p_id'],'p_id'=>$res3['p_id']);
                }
            }
            
            function rad($d)
            {
                   return $d * 3.1415926535898 / 180.0;
            }
            function GetDistance($lat1, $lng1, $lat2, $lng2)
            {
                $EARTH_RADIUS = 6378.137;
                $radLat1 = rad($lat1);
                //echo $radLat1;
               $radLat2 = rad($lat2);
               $a = $radLat1 - $radLat2;
               $b = rad($lng1) - rad($lng2);
               $s = 2 * asin(sqrt(pow(sin($a/2),2) +
                cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));
               $s = $s *$EARTH_RADIUS;
               $s = round($s * 10000) / 10000;
               
              
               return $s;
            }
            
            function getRealyAddress($wei,$jing)
            	{
            		$place_url='http://api.map.baidu.com/geocoder?output=json&location='.$wei.','.$jing.'&key=ccea36ece20a7a6eb0666bc726957e85';
            		$json_place=file_get_contents($place_url);
            		$place_arr=json_decode($json_place,true);
            		$address=$place_arr['result']['formatted_address'];
            		return $place_arr;
            	}
                
            $ge=new get_region();
            
            
            $coty=urldecode($this->city);
            
            $ctlist=getRealyAddress($this->lbswd,$this->lbsjd);
         
            $chengshi_city=$ctlist['result']['addressComponent']['city']; 
            $chengshi_district=$ctlist['result']['addressComponent']['district'];
            $ct=$ge->GetPinyin($chengshi_city);
            //$ct2=$ge->GetPinyin($chengshi_district);
            //print_r($ct);
            $getbuslist="select a.id,a.business_sn,a.business_name,a.reg_time,a.tel,a.is_special,a.bs_rank,a.is_warn,a.address,a.user_name,a.province,a.city,a.note,a.dis,a.pinglun,a.image_url,a.lbsjd,a.lbswd,b.sx_name,left(b.sx_name,1) as sx_name2 from business  a left join fjsx1 b on a.fw_fjsx1=b.id where a.city='".$ct['id']."'   and a.tzsy=0 ";
            
            
            //$getbuslist="select a.id,a.business_sn,a.business_name,a.reg_time,a.qq,a.tel,a.moblie_phone,a.reg_type,a.is_special,a.bs_rank,a.is_warn,a.address,a.fw_fjsx1,a.sample_note,a.work_starttime,a.note,a.work_endtime,a.user_name,a.province,a.city,a.dis,a.pinglun,a.image_url,a.lbsjd,a.lbswd,b.sx_name,left(b.sx_name,1) as sx_name2 from business  a left join fjsx1 b on a.fw_fjsx1=b.id where a.city='".$ct['id']."'   and a.tzsy=0 ";
            
            
            //print_r($getbuslist);
            //order by a.is_special desc,a.bs_rank,a.pinglun desc limit 50
            $this->otxt('getbuslbslist',$getbuslist);
            $res = $GLOBALS['db']->getAll($getbuslist);
            
            $arr1=array();
            $arr2=array();
            
            
            if($this->dis=='' and $this!='{dis}')
            {
                
            }
            else
            {
                $this->dis=10;
            }
           
            
            for($k=0;$k<count($res);$k++)
            {
                
                if($this->lbsjd=='' or $this->lbswd=='' or $this->lbsjd ==0 or $this->lbswd ==0)
                {
                    $res[$k]['max_distance']=$this->dis;
                    $res[$k]['distance']='';
                    array_push($arr2,$res[$k]);
                }else
                {
                    $res[$k]['max_distance']=$this->dis;
                   // $res[$k]['distance']=GetDistance($res[$k]['lbsjd'],$res[$k]['lbswd'],$this->lbsjd,$this->lbswd);
                    
                    //echo  GetDistance('118.60018','24.89794','118.614825','24.914384')."<br>";
//                    echo $this->lbsjd."_".$this->lbswd."_".$res[$k]['lbsjd']."_".$res[$k]['lbswd']."<br>";
                    $res[$k]['distance']=sprintf("%.2f", GetDistance($this->lbsjd,$this->lbswd,$res[$k]['lbsjd'],$res[$k]['lbswd'])); 
                    
                    //echo $res[$k]['distance']."<br>";
                    if($res[$k]['distance']<=$res[$k]['max_distance'])
                    {
                        array_push($arr1,$res[$k]);
                    }else
                    {
                        array_push($arr2,$res[$k]);
                    }
                }
                
            }
            //ksort($arr1,'distance');
            
            $sort = array(  
                    'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序  
                    'field'     => 'distance',       //排序字段  
            );  
            
            //重新排列数组根据最近的排列在最前面
            function multi_array_sort($multi_array,$sort_key,$sort=SORT_ASC){ 
                    if(is_array($multi_array)){ 
                    foreach ($multi_array as $row_array){ 
                    if(is_array($row_array)){ 
                    $key_array[] = $row_array[$sort_key]; 
                    }else{ 
                    return false; 
                    } 
                    } 
                    }else{ 
                    return false; 
                    } 
                    array_multisort($key_array,$sort,$multi_array); 
                    return $multi_array; 
                    } 
                    //处理 

                    $arr1= multi_array_sort($arr1,'distance');
                    $alist=array();
                    for($j=0;$j<count($arr1);$j++)
                    {
                        
                        //只显示最近40个地理位置
                        if($j<40)
                        {
                            array_push($alist,$arr1[$j]);
                            continue;
                        }
                       
                    }
            //$arrSort = array();  
//            foreach($arrUsers AS $uniqid => $row){  
//                foreach($row AS $key=>$value){  
//                    $arrSort[$key][$uniqid] = $value;  
//                }  
//            }  
//            if($sort['direction']){  
//                array_multisort($arrSort[$sort['field']], constant($sort['direction']), $arrUsers);  
//            }  
//              
//            var_dump($arrUsers);  
            
            
           
            
            $list = array("item" => $alist, "sum" => count($alist),"time"=>date('Y-m-d H:i:s', time()));
            
            
?>