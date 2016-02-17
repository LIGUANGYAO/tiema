<?php



class getgoods
{

    public $is_allow = 1;
    public $update_method = 0; //新增、增量、全量,add/augmenter/full
    public $method;
    public $usr = "http://localhost:8081/all_test/shop/admin/api/rest.php";
    public $page;
    public $num;
    public $err;
    public $g_type;
    public $list_array;
    public $sort_field;
    public $sort_type;
    public $goods_sn;
    public $system='mshop';

    // 拿到sql先判断语句是否有问题。先执行语句
    function exes()
    {
        return $this->exx();
    }
    private function Ms_p_limit($num, $pa)
    {

        $num = intval($num);

        $pa = intval($pa);
        if ($pa <= 1) {
            $pa = 1;
        } else {
        }
        if ($num < 1) {
            $num = 10;
        } else {
        }

        $start_p = ($num * ($pa - 1) + 1) - 1;
        $stop_p = $num;
        $sql = " limit " . $start_p . "," . $stop_p . " ";
        return $sql;
    }
    private function exx()
    {

        if ($this->is_allow == 1 && $this->system == "mshop") {
            // echo 1;
            //update_method判断更新模式，如果是直接判断最后更新时间及zhanshi_list，则用0,如果判断最后更新时间用1
            if ($this->update_method == 1) {

                if (empty($this->goods_sn)) {
                    $where = ' and 1=0';
                } else {

                    $where1 = $this->goods_sn;
                    $where1 = $this->get_more($where1);

                    for ($i = 0; $i < count($where1); $i++) {

                        // select * from goods where goods_sn in ('111','222');
                        $dh = "'";
                        $dh2 = "',";
                        if ($i == count($where1) - 1) {
                            $dh2 = "'";
                        }

                        $where .= $dh . $where1[$i] . $dh2;

                    }
                    $where = " and goods_sn in (" . $where . ")";
                }


                // print_r($where) ;exit;
                $get_goods_list = "select id	,
                                    goods_sn	,
                                    goods_name	,
                                    goods_outer_name	,
                                    goods_note	,
                                    goods_name_eg	,
                                    tzsy	,
                                    allow_sj	,
                                    dw	,
                                    goods_weight	,
                                    dj	,
                                    dj2	,
                                    dj3	,
                                    dj4	,
                                    dj5	,
                                    bzsj	,
                                    jj	,
                                    jj2	,
                                    jj3	,
                                    jj4	,
                                    jj5	,
                                    is_gift	,
                                    is_gift_allow_count	,
                                    add_time	,
                                    is_delete	,
                                    sort_no	,
                                    last_update_2	,
                                    goods_note_1	,
                                    goods_note_2	,
                                    last_update	,
                                    goods_note_3	,goodstype_sn,
                                    goods_note_4	
                                    from  goods where  tzsy=0 " . $where .
                    "  order by -sort_no desc " . $limit . "; ";
                $goods_list = $GLOBALS['db']->getAll($get_goods_list);

                //print_r($get_goods_list);exit;
                // $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname(dirname($_SERVER['PHP_SELF']));
                for ($i = 0; $i < count($goods_list); $i++) {

                    $goods_color = "select id	,
                                    goods_sn	,
                                    color_id	,
                                    color_name	,
                                    color_sn	,
                                    outer_color_name	
                                    from goods_color where   goods_sn='" . $goods_list[$i]['goods_sn'] .
                        "';";
                    //print_r($goods_color);
                    $color_list = $GLOBALS['db']->getAll($goods_color);


                    $goods_list[$i]['color_count'] = count($color_list);
                    $goods_list[$i]['color_list'] = $color_list;


                }
                for ($i = 0; $i < count($goods_list); $i++) {

                    $goods_size = "select id	,
                                    goods_sn	,
                                    size_id	,
                                    size_name	,
                                    size_sn	,
                                    outer_size_name	
                                    from goods_size where   goods_sn='" . $goods_list[$i]['goods_sn'] .
                        "';";

                    $size_list = $GLOBALS['db']->getAll($goods_size);


                    $goods_list[$i]['size_count'] = count($size_list);
                    $goods_list[$i]['size_list'] = $size_list;


                }
                $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname(dirname($_SERVER['PHP_SELF']));
                for ($i = 0; $i < count($goods_list); $i++) {
                    $goods_img_list = "select p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,ss,title,img_action_url,add_time,last_update,img_sum,img_outer_id,width,height,resize_width,resize_height from goods_imgs where ss=1 and  p_id='" .
                        $goods_list[$i]['goods_sn'] . "' order by -img_sum  desc;";

                    $img_list = $GLOBALS['db']->getAll($goods_img_list);

                    //返回图片完整路径
                    for ($j = 0; $j < count($img_list); $j++) {
                        $img_list[$j]['b_img_url'] = $url_this . "/" . $img_list[$j]['b_img_url'];
                        $img_list[$j]['s_img_url'] = $url_this . "/" . $img_list[$j]['s_img_url'];

                    }
                    //$img_list[$i]['b_img_url']=$url_this."/".$img_list[$i]['b_img_url'];
                    // $img_list[$i]['s_img_url']=$url_this."/".$img_list[$i]['s_img_url'];

                    $goods_list[$i]['img_count'] = count($img_list);
                    $goods_list[$i]['img_list'] = $img_list;
                }
                //print_r($goods_list);exit;
                $list = array("item" => $goods_list, "sum" => count($goods_list));
                //print_r($list);exit;
                return $list;
            } else {
                $limit = $this->Ms_p_limit($this->num, $this->page);
                //echo $limit;exit;

                if (empty($this->sort_field)) {

                    $sort1 = " order by -sort_no desc ";
                } else {
                    $sort = $this->sort_field;
                    $sort = $this->get_more($sort);
                    //print_r($sort);exit;
                    for ($i = 0; $i < count($sort); $i++) {
                        $os = array(
                            "goods_sn","goods_name","goods_outer_name","dj","dj2","dj3","dj4","dj5","bzsj","jj","jj2","jj3","jj4","jj5","add_time","last_update_2","sort_no"
                            );
                            
                            
                        if (in_array($sort[$i], $os)) {
                            //echo $sort[$i];exit;
                            $sort1 .= $sort[$i] . ",";
                        }

                        //  // select * from goods where goods_sn in ('111','222');
                        //                        $dh = "'";
                        //                        $dh2 = "',";
                        //                        if ($i == count($sort) - 1) {
                        //                            $dh2 = "'";
                        //                        }
                        //
                        //                        $sort1 .= $dh . $sort[$i] . $dh2;

                    }
                    $sort1 = substr($sort1, 0, strlen($sort1) - 1);

                    // echo $sort1;exit;
                   
                    if ($this->sort_type == 1) {
                        $sort_type = " desc";
                    } else {
                        $sort_type = " ";
                    }
                    
                    
                    $sort1 = " order by " . $sort1 . $sort_type." ";
                    //echo $sort1;
//                    exit;

                }


                if (empty($this->g_type)) {
                    $g_type = "";
                } else {
                    $g_type = " and goodstype_sn='" . $this->g_type . "'";
                    //echo $g_type;exit;
                }

                $get_goods_list = "select id	,
                                    goods_sn	,
                                    goods_name	,
                                    goods_outer_name	,
                                    goods_note	,
                                    goods_name_eg	,
                                    tzsy	,
                                    allow_sj	,
                                    dw	,
                                    goods_weight	,
                                    dj	,
                                    dj2	,
                                    dj3	,
                                    dj4	,
                                    dj5	,
                                    bzsj	,
                                    jj	,
                                    jj2	,
                                    jj3	,
                                    jj4	,
                                    jj5	,
                                    is_gift	,
                                    is_gift_allow_count	,
                                    add_time	,
                                    is_delete	,
                                    sort_no	,
                                    last_update_2	,
                                    goods_note_1	,
                                    goods_note_2	,
                                    last_update	,
                                    goods_note_3	,
                                    goods_note_4	,goodstype_sn 
                                    from  goods where  tzsy=0 " . $g_type .
                    $sort1 . $limit . "; ";
                $goods_list = $GLOBALS['db']->getAll($get_goods_list);

                // print_r($get_goods_list);exit;
                // $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname(dirname($_SERVER['PHP_SELF']));
                for ($i = 0; $i < count($goods_list); $i++) {

                    $goods_color = "select id	,
                                    goods_sn	,
                                    color_id	,
                                    color_name	,
                                    color_sn	,
                                    outer_color_name	
                                    from goods_color where   goods_sn='" . $goods_list[$i]['goods_sn'] .
                        "';";
                    //print_r($goods_color);
                    $color_list = $GLOBALS['db']->getAll($goods_color);


                    $goods_list[$i]['color_count'] = count($color_list);
                    $goods_list[$i]['color_list'] = $color_list;


                }
                for ($i = 0; $i < count($goods_list); $i++) {

                    $goods_size = "select id	,
                                    goods_sn	,
                                    size_id	,
                                    size_name	,
                                    size_sn	,
                                    outer_size_name	
                                    from goods_size where   goods_sn='" . $goods_list[$i]['goods_sn'] .
                        "';";

                    $size_list = $GLOBALS['db']->getAll($goods_size);


                    $goods_list[$i]['size_count'] = count($size_list);
                    $goods_list[$i]['size_list'] = $size_list;


                }
                $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname(dirname($_SERVER['PHP_SELF']));
                for ($i = 0; $i < count($goods_list); $i++) {
                    $goods_img_list = "select p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,ss,title,img_action_url,add_time,last_update,img_sum,img_outer_id,width,height,resize_width,resize_height from goods_imgs where ss=1 and  p_id='" .
                        $goods_list[$i]['goods_sn'] . "' order by -img_sum  desc;";

                    $img_list = $GLOBALS['db']->getAll($goods_img_list);

                    //返回图片完整路径
                    for ($j = 0; $j < count($img_list); $j++) {
                        $img_list[$j]['b_img_url'] = $url_this . "/" . $img_list[$j]['b_img_url'];
                        $img_list[$j]['s_img_url'] = $url_this . "/" . $img_list[$j]['s_img_url'];

                    }
                    //$img_list[$i]['b_img_url']=$url_this."/".$img_list[$i]['b_img_url'];
                    // $img_list[$i]['s_img_url']=$url_this."/".$img_list[$i]['s_img_url'];

                    $goods_list[$i]['img_count'] = count($img_list);
                    $goods_list[$i]['img_list'] = $img_list;
                }
                //print_r($goods_list);exit;
                $list = array("item" => $goods_list, "sum" => count($goods_list));
                //print_r($list);exit;
                return $list;


            }


        }elseif($this->is_allow == 1 && $this->system == "efast")
        {
             if ($this->update_method == 1) {

               
            } else {
                $limit = $this->Ms_p_limit($this->num, $this->page);
                //echo $limit;exit;
                
                //排列字段
                if (empty($this->sort_field)) {

                    $sort1 = " order by -sort_no desc ";
                } else {
                    $sort = $this->sort_field;
                    $sort = $this->get_more($sort);
                    //print_r($sort);exit;
                    for ($i = 0; $i < count($sort); $i++) {
                        $os = array(
                            "goods_sn","goods_name","goods_outer_name","dj","dj2","dj3","dj4","dj5","bzsj","jj","jj2","jj3","jj4","jj5","add_time","last_update_2","sort_no"
                            );
                            
                            
                        if (in_array($sort[$i], $os)) {
                            //echo $sort[$i];exit;
                            $sort1 .= $sort[$i] . ",";
                        }

                        //  // select * from goods where goods_sn in ('111','222');
                        //                        $dh = "'";
                        //                        $dh2 = "',";
                        //                        if ($i == count($sort) - 1) {
                        //                            $dh2 = "'";
                        //                        }
                        //
                        //                        $sort1 .= $dh . $sort[$i] . $dh2;

                    }
                    $sort1 = substr($sort1, 0, strlen($sort1) - 1);

                    // echo $sort1;exit;
                   
                    if ($this->sort_type == 1) {
                        $sort_type = " desc";
                    } else {
                        $sort_type = " ";
                    }
                    
                    
                    $sort1 = " order by " . $sort1 . $sort_type." ";
                    //echo $sort1;
//                    exit;

                }


                if (empty($this->g_type)) {
                    $g_type = "";
                } else {
                    $g_type = " and goodstype_sn='" . $this->g_type . "'";
                    //echo $g_type;exit;
                }

                $get_goods_list = "select b.goods_sn,b.goods_name,c.color_code,c.color_name,d.size_code,d.size_name,a.barcode from goods_barcode a left join goods b on a.goods_id=b.goods_id left join color c on a.color_id=c.color_id left join size d on a.size_id=d.size_id  where  1=1 " . $g_type .
                    $sort1 . $limit . "; ";
                $goods_list = $GLOBALS['db2']->getAll($get_goods_list);

                // print_r($get_goods_list);exit;
                // $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname(dirname($_SERVER['PHP_SELF']));
                
                
                //商品图片
                /*
                for ($i = 0; $i < count($goods_list); $i++) {

                    $goods_color = "select id	,
                                    goods_sn	,
                                    color_id	,
                                    color_name	,
                                    color_sn	,
                                    outer_color_name	
                                    from goods_color where   goods_sn='" . $goods_list[$i]['goods_sn'] .
                        "';";
                    //print_r($goods_color);
                    $color_list = $GLOBALS['db']->getAll($goods_color);


                    $goods_list[$i]['color_count'] = count($color_list);
                    $goods_list[$i]['color_list'] = $color_list;


                }
                for ($i = 0; $i < count($goods_list); $i++) {

                    $goods_size = "select id	,
                                    goods_sn	,
                                    size_id	,
                                    size_name	,
                                    size_sn	,
                                    outer_size_name	
                                    from goods_size where   goods_sn='" . $goods_list[$i]['goods_sn'] .
                        "';";

                    $size_list = $GLOBALS['db']->getAll($goods_size);


                    $goods_list[$i]['size_count'] = count($size_list);
                    $goods_list[$i]['size_list'] = $size_list;


                }
                $url_this = "http://" . $_SERVER['HTTP_HOST'] . "" . dirname(dirname($_SERVER['PHP_SELF']));
                for ($i = 0; $i < count($goods_list); $i++) {
                    $goods_img_list = "select p_id,b_img_url,s_img_url,img_note_1,img_note_2,img_note_3,ss,title,img_action_url,add_time,last_update,img_sum,img_outer_id,width,height,resize_width,resize_height from goods_imgs where ss=1 and  p_id='" .
                        $goods_list[$i]['goods_sn'] . "' order by -img_sum  desc;";

                    $img_list = $GLOBALS['db']->getAll($goods_img_list);

                    //返回图片完整路径
                    for ($j = 0; $j < count($img_list); $j++) {
                        $img_list[$j]['b_img_url'] = $url_this . "/" . $img_list[$j]['b_img_url'];
                        $img_list[$j]['s_img_url'] = $url_this . "/" . $img_list[$j]['s_img_url'];

                    }
                    //$img_list[$i]['b_img_url']=$url_this."/".$img_list[$i]['b_img_url'];
                    // $img_list[$i]['s_img_url']=$url_this."/".$img_list[$i]['s_img_url'];

                    $goods_list[$i]['img_count'] = count($img_list);
                    $goods_list[$i]['img_list'] = $img_list;
                }
                
                */
                //--
                
                //print_r($goods_list);exit;
                $list = array("item" => $goods_list, "sum" => count($goods_list));
                //print_r($list);exit;
                return $list;


            }
        } 
        else {
            $this->err['err'] = 2;
            $this->err['user_error'] = null; //
            //print_r($err);
            return $this->err;
        }


    }
    public function get_more($obj)
    {

        //$string = "1,2,3,4,5";
        // echo 1;
        $array = explode(",", $obj);
        return $array;

    }
}





?>