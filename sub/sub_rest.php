<?php

class API_key_value
{
    public $app_key ;
    public $app_secret;
    function get_secrt()
    {
        $obj=md5(md5($this->app_secret."09~!@#ajdleg").md5($this->app_key."oi!#&*1#LNoijoPIJOI"));
        return $obj;
    }
}

class arraytojson
{
     public function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
      {
          static $recursive_counter = 0;
          if (++$recursive_counter > 1000) {
              die('possible deep recursion attack');
          }
         foreach ($array as $key => $value) {
              if (is_array($value)) {
                  $this->arrayRecursive($array[$key], $function, $apply_to_keys_also);
             } else {
                  $array[$key] = $function($value);
              }
      
              if ($apply_to_keys_also && is_string($key)) {
                  $new_key = $function($key);
                  if ($new_key != $key) {
                      $array[$new_key] = $array[$key];
                      //unset($array[$key]);
                  }
              }
          }
          $recursive_counter--;
      }
      
      /**************************************************************
       *
       *	将数组转换为JSON字符串（兼容中文）
       *	@param	array	$array		要转换的数组
       *	@return string		转换得到的json字符串
       *	@access public
       *
       *************************************************************/
       public function JSON($array) {
      	$this->arrayRecursive($array, 'urlencode', true);
      	$json = json_encode($array);
      	//return urldecode($json);
        return $json;
          //return urldecode($json);
      }
    
      
       //$obj数据源items,$num 单页数据量，$pa第几页
        public function Ms_p_limit($obj,$num,$pa)
        {
            
             $num=intval($num) ;
             
             $pa=intval($pa);
            if($pa<=1){$pa=1;}else{}
            if($num<1){$num=20;}else{}
            $count=count($obj);
            //输入超出，暂时没写
            if ($num*$pa>$count)
            {
               //$pa=$count%$sum;
            }
            $start_p=($num*($pa-1)+1)-1;
            $stop_p=$num;
           $sql=" limit " .$start_p. ",".$stop_p." ";
           return $sql;
        }
}


function timeDiff($aTime, $bTime)
{
    // 分割第一个时间
    $ayear = substr($aTime, 0, 4);
    $amonth = substr($aTime, 4, 2);
    $aday = substr($aTime, 6, 2);
    $ahour = substr($aTime, 8, 2);
    $aminute = substr($aTime, 10, 2);
    $asecond = substr($aTime, 12, 2);
    // 分割第二个时间
    $byear = substr($bTime, 0, 4);
    $bmonth = substr($bTime, 4, 2);
    $bday = substr($bTime, 6, 2);
    $bhour = substr($bTime, 8, 2);
    $bminute = substr($bTime, 10, 2);
    $bsecond = substr($bTime, 12, 2);
    // 生成时间戳
    $a = mktime($ahour, $aminute, $asecond, $amonth, $aday, $ayear);
    $b = mktime($bhour, $bminute, $bsecond, $bmonth, $bday, $byear);
    $timeDiff['second'] = $a - $b;
    // 采用了四舍五入,可以修改
    $timeDiff['mintue'] = round($timeDiff['second'] / 60);
    $timeDiff['hour'] = round($timeDiff['mintue'] / 60);
    $timeDiff['day'] = round($timeDiff['hour'] / 24);
    $timeDiff['week'] = round($timeDiff['day'] / 7);
    $timeDiff['month'] = round($timeDiff['day'] / 30); // 按30天来算
    $timeDiff['year'] = round($timeDiff['day'] / 365); // 按365天来算
    return $timeDiff;
}
function get_time_diff($t)
{
    $time = date('Y-m-d H:i:s', time());
    $time = strtotime($time);
    //echo $time;exit;
     $aaa=date("YmdHis", $time);
     // $time = date('Y-m-d H:i:s', time());
    $t = strtotime($t);
    //echo $time;exit;
     $t=date("YmdHis", $t);
     $a = timeDiff($aaa, $t);
     return $a;
}
//
//class apilog
//{
//     private $app_key_login=1;//登陆记录api记录log
//     public $timestamp=date('Y-m-d H:i:s',time());
//     public $method;
//     
//    
//}
//print_r(get_time_diff("2013-10-30 13:58:14"));
?>