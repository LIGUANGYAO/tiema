<?php

    
            //记录sql日志
            //$this->otxt('getsearchlist',$sql);
            $limit = $this->Ms_p_limit($this->num, $this->page);    


            
            
            //需要返回这样格式的
            //$list = array("item" => $list, "sum" => count($list),"time"=>date('Y-m-d H:i:s', time()));
            class get_dalei
            {
                function GetDaleiFjsx1()
                {
                    $sql="select id,dl_sn,dl_name,note,action_url,img_1 from dalei where  tzsy=0 order by sort_no,id";
                    $res = $GLOBALS['db']->getAll($sql);
                    
                    for($i=0;$i<count($res);$i++)
                    {
                        $sql2="select id,sx_sn,sx_name,note,p_id,action_url,img_1 from fjsx1 where p_id='".$res[$i]['id']."' and tzsy=0  order by sort_no,id";
                        $res[$i]['fjsx1'] = $GLOBALS['db']->getAll($sql2);
                        
                    }
                    return $res;
                }
                
                //获取某个类型的服务dalei
                function GetDalei($obj)
                {
                    $sql="select id,dl_sn,dl_name,note,action_url,img_1 from dalei where id='".$obj."' and tzsy=0 order by sort_no,id";
                    
                    $res = $GLOBALS['db']->getRow($sql);
                    
                    
                    return $res;
                }
                
                //获取某个id 获取fjsx1  id
                function GetFjsx1($obj)
                {
                    $sql="select id,sx_sn,sx_name,note,p_id,action_url,img_1 from fjsx1 where id='".$obj."' and tzsy=0  order by sort_no,id";
                    $res = $GLOBALS['db']->getRow($sql);
                    
                    
                    return $res;
                }
                
                
                //获取某个id 获取fjsx1  id
                function GetFjsx1mx($obj)
                {
                    $sql="select id,sx_sn,sx_name,note,p_id,action_url,img_1 from fjsx1 where p_id='".$obj."' and tzsy=0  order by sort_no,id";
                    $res = $GLOBALS['db']->getAll($sql);
                    
                    
                    return $res;
                }
                
                
                
            }
            
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
                
            }
            function Get_Business($Nu, $ma, $sql,$cid,$fei='',$limit)
            {
                /*
                if (isset($_REQUEST['Action'])) {
                    $filer = $_REQUEST['Action'];
                }
               */
                //获取市区代码
                
                if (isset($cid)) {
                    
                    $filer1 = " and ( city = '" . $cid .
                        "' )";
                        
                    //unset($_POST['keyword']);
                } else {
                    $filer1 = '';
                }
                
                 if ($fei!='') {
                    
                    $filer1 .= " and ( id = '" . $fei .
                        "' )";
                        
                    //unset($_POST['keyword']);
                } else {
                    $filer1 .= '';
                }
               
                
                if (isset($_REQUEST['keyword'])) {
                    
                    $filer1 .= " and ( business_name like '%" . trim($_REQUEST['keyword']) .
                        "%' )";
                        
                    //unset($_POST['keyword']);
                } else {
                    $filer1 .= '';
                }
                if (isset($_REQUEST['dis'])) {
                    
                    $filer1 .= " and ( dis ='" . trim($_REQUEST['dis']) .
                        "' )";
                        
                    //unset($_POST['keyword']);
                } else {
                    $filer1 .= '';
                }
                
                if (isset($_REQUEST['pj']) and trim($_REQUEST['pj']==1)) {
                    
                    $order .= " pinglun desc,";
                        
                    //unset($_POST['keyword']);
                } else {
                    $order .= '';
                }
                if (isset($_REQUEST['rank']) and trim($_REQUEST['rank']==1)) {
                    
                    $order .= " bs_rank desc,";
                        
                    //unset($_POST['keyword']);
                } else {
                    $order .= '';
                }
                
                
                if (isset($_REQUEST['dl'])) {
                    
                    $filer1 .= "and  dl='" . trim($_REQUEST['dl']) .
                        "' ";
                        
                    //unset($_POST['keyword']);
                } else {
                    $filer1 .= '';
                }
                
                if (isset($_REQUEST['fjsx1'])) {
                    
                    $filer1 .= "and  fw_fjsx1='" . trim($_REQUEST['fjsx1']) .
                        "' ";
                        
                    //unset($_POST['keyword']);
                } else {
                    $filer1 .= '';
                }
                
                
                $filer = " where 1=1  and tzsy=0 $filer1 ";
                $action_list = array();
            
               
                
                
              
                $sql = $sql . $filer ." order by ".$order." sort_no,id desc " . $limit . ";";
                //echo $sql;
                $res = $GLOBALS['db']->getAll($sql);
                
                
                //获取地址名称
                for($i=0;$i<count($res);$i++)
                {
                    $get="select id,p_id,region_name,region_nick from region where id='".$res[$i]['city']."' or id='".$res[$i]['dis']."' ";
                    $get1 = $GLOBALS['db']->getAll($get);
                    
                    $res[$i]['city_name']=$get1[0]['region_nick'];
                    $res[$i]['dis_name']=$get1[1]['region_nick'];
                }
                
                return array(
                    'items' => $res,
                    'page' => $obj
                    ,'sql' => $sql
                    );
            
            }
            
            
            
           
           $ccity=urldecode($this->city);
           // $this->otxt('getsearchlist',$ccity);
            
    $ex=new get_dalei();
    
    //echo $_COOKIE['c_pinyin'];exit;
    $ls=array();
    //首先要先获取到 dl  的id，否则不进行输出
    if(isset($_REQUEST['dl'])  )
    {
        
        $dl=trim($_REQUEST['dl']);
       
        $dalei=$ex->GetDalei($dl);
       
        $ls['dalei']=$dalei;
        //$smarty->assign('dalei', $dalei);
        
        /**
         * 拼装url
         */
        if(isset($_REQUEST['dl']))
        {
            $cfurl="?g=search&dl=".$dalei['id'];
        }
        /**
         * end
         */
        //再获取fjsx1
        
        $fj1=trim($_REQUEST['fjsx1']);
        
        $fjsx1= $ex->GetFjsx1($fj1);
        $ls['fjsx1']=$fjsx1;
        //$smarty->assign('fjsx1', $fjsx1);
        
        
        /**
         * 拼装url
         */
        if(isset($_REQUEST['fjsx1']))
        {
            $cfurl.="&fjsx1=".$fjsx1['id'];
        }
        /**
         * end
         */
        
       $re=new get_region();
        
        
       $ci=$re->GetPinyin($ccity);
        //print_r($this->city);
        
        //print_r($dis);
        
        if(isset($_REQUEST['dis']) )
        {
            $GetId=$re->GetId($_REQUEST['dis']);
            
            $ls['GetId']=$GetId;
            //$smarty->assign('GetId', $GetId);
        }
        
        /**
         * 拼装url
         */
        if(isset($_REQUEST['dis']))
        {
            $cfurl.="&dis=".$GetId['id'];
        }
        /**
         * end
         */
        
            if (isset($_REQUEST['pj']) and trim($_REQUEST['pj']==1)) {
        
                $cfurl .= "&pj=1";
                    
                //unset($_POST['keyword']);
            } 
            if (isset($_REQUEST['rank']) and trim($_REQUEST['rank']==1)) {
                
                $cfurl .= "&rank=1";
                    
                //unset($_POST['keyword']);
            } 
        
        
        
        //获取fjsx1mx
        $fjsx1mx=$ex->GetFjsx1mx($_REQUEST['dl']);
        $ls['fjsx1mx']=$fjsx1mx;
        //$smarty->assign('fjsx1mx', $fjsx1mx);
        
    }//elseif(isset($_REQUEST['dl']))
//    {
//        $dl=trim($_REQUEST['dl']);
//       
//        $dalei=$ex->GetDalei($dl);
//       
//        $smarty->assign('dalei', $dalei);
//    }
    
    
    
    /**
     * 城市
     */
    //if(isset($_COOKIE['jz_city']))
//    {
//        $jz_city=$_COOKIE['jz_city'];
//        $smarty->assign('city_name', $jz_city);
//    }
//    else
//    {
//        header('location:?');
//    }
    
   
    
    $bus_id=$_REQUEST['busid'];
   
    //$smarty->assign('cfurl', $cfurl);
//    $smarty->assign('bus_id', $bus_id);
    if(isset($_REQUEST['busid']) and  $bus_id!='{busid}')
    {
          //print_r($fjsx1);exit;
        $sql = "select id,business_sn,business_name,reg_time,qq,tel,moblie_phone,reg_type,is_special,bs_rank,is_warn,address,fw_fjsx1,sample_note,work_starttime,note,work_endtime,user_name,province,city,dis,pinglun,image_url from business  ";
        
        //获取所属市下面的区域
        
        $dis=$re->GetDis($ci['pinyin']);
        //$smarty->assign('dis', $dis);
        //这边没有输出
        $ct=$re->GetPinyinAll($ci['pinyin']);
        $ls['dis']=$dis;
        
        $Buslist2 = Get_Business($Num, "business", $sql,$ct['id'],$bus_id,$limit);
        $ls['buslist']=$Buslist2['items'][0];
        
    }
    else
    {
        
         //print_r($fjsx1);exit;
        $sql = "select id,business_sn,business_name,reg_time,qq,tel,moblie_phone,reg_type,is_special,bs_rank,is_warn,address,fw_fjsx1,sample_note,work_starttime,note,work_endtime,user_name,province,city,dis,pinglun,image_url from business ";
        
        //获取所属市下面的区域
        
        $dis=$re->GetDis($ci['pinyin']);
        //$smarty->assign('dis', $dis);
        
        $ct=$re->GetPinyinAll($ci['pinyin']);
        
        $ls['dis']=$dis;
        
        $Buslist = Get_Business($Num, "business", $sql,$ct['id'],'',$limit);
        
        //print_r($Buslist);exit;
        //$smarty->assign('Buslist', $Buslist['items']);
        
        $ls['buslist']=$Buslist['items'];
    }
    $this->otxt('getsearchlist',$Buslist['sql']);
    
    //$list = array("item" => $_REQUEST['dl'], "sum" => $_REQUEST['city'],"time"=>date('Y-m-d H:i:s', time()));
           $list = array("item" => array($ls), "sum" => count($ls['buslist']),"time"=>date('Y-m-d H:i:s', time()));
            
?>