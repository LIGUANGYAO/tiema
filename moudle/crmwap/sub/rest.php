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
      	return urldecode($json);
        //return $json;
          //return urldecode($json);
      }
    
      
       //$obj数据源items,$num 单页数据量，$pa第几页
        public function Ms_p_limit($obj,$num,$pa)
        {
            
             $num=intval($num) ;
             
             $pa=intval($pa);
            if($pa<=1){$pa=1;}else{}
            if($num<=1){$num=20;}else{}
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
?>