<?php
define('IN_ECS', true);
require_once ('includes/init2.php');
require_once ('sub/sub_rest.php');
require (dirname(__file__) . '/sub/sub_weixin_token.php');
//写一个类，让他们写入一条语句的时候直接执行，判断语法是否错误，错误返回语法错误。
//我现在要写一个类，让他们在输入接口的时候选择表，选择字段，修改字段。

//数组转 json 类
//$url_this = "http://".$_SERVER ['HTTP_HOST'].dirname(dirname($_SERVER['PHP_SELF']));
//echo $url_this;

set_time_limit(0);

$method = '';
$format = '';
$sql = '';

//method设置


if (isset($_REQUEST['method'])) {
        
    
    if ($_REQUEST['method'] == "get.dalei.list") {
        $method = "get.dalei.list";
    } 
    
        
    
    if ($_REQUEST['method'] == "get.search.list") {
        $method = "get.search.list";
    } 
    
        
    
    if ($_REQUEST['method'] == "get.token.info") {
        $method = "get.token.info";
    } 
    
        
    
    if ($_REQUEST['method'] == "get.buslbs.list") {
        $method = "get.buslbs.list";
    } 
    
        
    
    if ($_REQUEST['method'] == "get.menber.info") {
        $method = "get.menber.info";
    } 
    
        
    
    if ($_REQUEST['method'] == "get.region.list") {
        $method = "get.region.list";
    } 
    
    
}

/*暂时不使用
if (isset($_REQUEST['format'])) {
    if ($_REQUEST['format'] == "json") {
        $format = "json";
    } else {
        $format = "array";
    }
    ;

}
*/
if (isset($_REQUEST['sql'])) {

    $sql = $_REQUEST['sql'];

} else {
    $sql = "0";
}

if (isset($_REQUEST['page'])) {
    $n_page = intval($_REQUEST['page']);

}
if (isset($_REQUEST['num'])) {
    $p_num = intval($_REQUEST['num']);

}

function crlog($txtname,$content)
{
    $of = fopen($txtname.'.txt', 'a'); //创建并打开dir.txt
    if ($of) {
        fwrite($of, "[" . date('Y-m-d H:i:s', time()) . "]\r\n" . $content . "\r\n"); //把执行文件的结果写入txt文件
    }
}


if (isset($_REQUEST['api_key']) && isset($_REQUEST['secret'])) {
    //$app=new API_key_value();
    //$app->app_key=API_KEY;
    //$app->app_secret=$_REQUEST['secret'];
    //$secret=$app->get_secrt();
    $sql_key = " select api_key from api_user  where api_key='" . $_REQUEST['api_key'] .
        "' and secret='" . $_REQUEST['secret'] . "';";
    $user_id = $GLOBALS['db']->getRow($sql_key);
    //print_r( $user_id);

    if (!empty($user_id)) {
        
        //新接口生成
        
         
        /**
         * -------new method-------------
         */
        if ($method == "get.dalei.list") {
            
            //循环传入条件
 
            if (isset($_REQUEST['jz_city'])) {
                $jz_city =trim($_REQUEST['jz_city']);
            } else {
                $jz_city = '';
            }  
 
            if (isset($_REQUEST['city'])) {
                $city =trim($_REQUEST['city']);
            } else {
                $city = '';
            }  
            
                require_once ('sub/token/getdaleilist.php');
                $ex = new getdaleilist; 
                $ex->jz_city = $jz_city; 
                $ex->city = $city;                //传入页数参数
                                                //返回数据
                $getdaleilist_list = $ex->exes();
                $json_users = new arraytojson();
                $ex->err = $json_users->JSON($getdaleilist_list);
                print_r($ex->err); //输出错误
                return $ex->err;
            
        
        }
         
        /**
         * -------new method-------------
         */
        if ($method == "get.search.list") {
            if (isset($_REQUEST['page'])) {
                $page =(int)trim($_REQUEST['page']);
            } else {
                $page=1;
            }   
            if (isset($_REQUEST['num'])) {
                $num =(int)trim($_REQUEST['num']);
            } else {
                $num=5;
                if($num<=0)
                {
                    $num=5;
                }
            }
            
            //循环传入条件
 
            if (isset($_REQUEST['c_pinyin'])) {
                $c_pinyin =trim($_REQUEST['c_pinyin']);
            } else {
                $c_pinyin = '';
            }  
 
            if (isset($_REQUEST['busid'])) {
                $busid =(int)trim($_REQUEST['busid']);
            } else {
                $busid = 0;
            }  
 
            if (isset($_REQUEST['rank'])) {
                $rank =(int)trim($_REQUEST['rank']);
            } else {
                $rank = 0;
            }  
 
            if (isset($_REQUEST['jz_city'])) {
                $jz_city =(int)trim($_REQUEST['jz_city']);
            } else {
                $jz_city = 0;
            }  
 
            if (isset($_REQUEST['pj'])) {
                $pj =(int)trim($_REQUEST['pj']);
            } else {
                $pj = 0;
            }  
 
            if (isset($_REQUEST['dis'])) {
                $dis =(int)trim($_REQUEST['dis']);
            } else {
                $dis = 0;
            }  
 
            if (isset($_REQUEST['fjsx1'])) {
                $fjsx1 =(int)trim($_REQUEST['fjsx1']);
            } else {
                $fjsx1 = 0;
            }  
 
            if (isset($_REQUEST['dl'])) {
                $dl =(int)trim($_REQUEST['dl']);
            } else {
                $err['err'] = 10001;
                $err['msg'] = "unfind field dl";
                $json_users = new arraytojson();
                $err = $json_users->JSON($err);
                
                print_r($err); //输出错误
                return $err;
            }  
 
            if (isset($_REQUEST['keyword'])) {
                $keyword =trim($_REQUEST['keyword']);
            } else {
                $keyword = '';
            }  
 
            if (isset($_REQUEST['city'])) {
                $city =trim($_REQUEST['city']);
            } else {
                $city = '';
            }  
            
                require_once ('sub/token/getsearchlist.php');
                $ex = new getsearchlist; 
                $ex->c_pinyin = $c_pinyin; 
                $ex->busid = $busid; 
                $ex->rank = $rank; 
                $ex->jz_city = $jz_city; 
                $ex->pj = $pj; 
                $ex->dis = $dis; 
                $ex->fjsx1 = $fjsx1; 
                $ex->dl = $dl; 
                $ex->keyword = $keyword; 
                $ex->city = $city;                //传入页数参数
                
               
                $ex->num=$num;
                $ex->page=$page;                                //返回数据
                $getsearchlist_list = $ex->exes();
                $json_users = new arraytojson();
                $ex->err = $json_users->JSON($getsearchlist_list);
                print_r($ex->err); //输出错误
                return $ex->err;
            
        
        }
         
        /**
         * -------new method-------------
         */
        if ($method == "get.token.info") {
            
            //循环传入条件
 
            if (isset($_REQUEST['users_sn'])) {
                $users_sn =trim($_REQUEST['users_sn']);
            } else {
                $err['err'] = 10001;
                $err['msg'] = "unfind field users_sn";
                $json_users = new arraytojson();
                $err = $json_users->JSON($err);
                
                print_r($err); //输出错误
                return $err;
            }  
 
            if (isset($_REQUEST['password'])) {
                $password =trim($_REQUEST['password']);
            } else {
                $err['err'] = 10001;
                $err['msg'] = "unfind field password";
                $json_users = new arraytojson();
                $err = $json_users->JSON($err);
                
                print_r($err); //输出错误
                return $err;
            }  
            
                require_once ('sub/token/gettokeninfo.php');
                $ex = new gettokeninfo; 
                $ex->users_sn = $users_sn; 
                $ex->password = $password;                //传入页数参数
                                                //返回数据
                $gettokeninfo_list = $ex->exes();
                $json_users = new arraytojson();
                $ex->err = $json_users->JSON($gettokeninfo_list);
                print_r($ex->err); //输出错误
                return $ex->err;
            
        
        }
         
        /**
         * -------new method-------------
         */
        if ($method == "get.buslbs.list") {
            
            //循环传入条件
 
            if (isset($_REQUEST['dis'])) {
                $dis =(int)trim($_REQUEST['dis']);
            } else {
                $err['err'] = 10001;
                $err['msg'] = "unfind field dis";
                $json_users = new arraytojson();
                $err = $json_users->JSON($err);
                
                print_r($err); //输出错误
                return $err;
            }  
 
            if (isset($_REQUEST['lbswd'])) {
                $lbswd =trim($_REQUEST['lbswd']);
            } else {
                $err['err'] = 10001;
                $err['msg'] = "unfind field lbswd";
                $json_users = new arraytojson();
                $err = $json_users->JSON($err);
                
                print_r($err); //输出错误
                return $err;
            }  
 
            if (isset($_REQUEST['lbsjd'])) {
                $lbsjd =trim($_REQUEST['lbsjd']);
            } else {
                $err['err'] = 10001;
                $err['msg'] = "unfind field lbsjd";
                $json_users = new arraytojson();
                $err = $json_users->JSON($err);
                
                print_r($err); //输出错误
                return $err;
            }  
 
            if (isset($_REQUEST['city'])) {
                $city =trim($_REQUEST['city']);
            } else {
                $city = '';
            }  
            
                require_once ('sub/token/getbuslbslist.php');
                $ex = new getbuslbslist; 
                $ex->dis = $dis; 
                $ex->lbswd = $lbswd; 
                $ex->lbsjd = $lbsjd; 
                $ex->city = $city;                //传入页数参数
                                                //返回数据
                $getbuslbslist_list = $ex->exes();
                $json_users = new arraytojson();
                $ex->err = $json_users->JSON($getbuslbslist_list);
                print_r($ex->err); //输出错误
                return $ex->err;
            
        
        }
         
        /**
         * -------new method-------------
         */
        if ($method == "get.menber.info") {
            
            //循环传入条件
            

            //判断是否验证唯一性
            $tk_allow = 0;
            require_once ('sub/check_token.php');
            if ($tk_allow == 1) {
                require_once ('sub/token/getmenberinfo.php');
                $ex = new getmenberinfo;                $ex->temporary_key =trim($_REQUEST['temporary_key']);
                //传入页数参数
                
                //返回数据
                $getmenberinfo_list = $ex->exes();
                $json_users = new arraytojson();
                $ex->err = $json_users->JSON($getmenberinfo_list);
                print_r($ex->err); //输出错误
                return $ex->err;
            
            }
            
        
        }
         
        /**
         * -------new method-------------
         */
        if ($method == "get.region.list") {
            
            //循环传入条件
            
                require_once ('sub/token/getregionlist.php');
                $ex = new getregionlist;                //传入页数参数
                                                //返回数据
                $getregionlist_list = $ex->exes();
                $json_users = new arraytojson();
                $ex->err = $json_users->JSON($getregionlist_list);
                print_r($ex->err); //输出错误
                return $ex->err;
            
        
        }
                
        
        
      

    } else {
        $return = array('1' => 'api_key error or secret error!');
        print_r($return[1]);
    }


} else {
    echo "error!";

}

?>