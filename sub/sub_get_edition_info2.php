<?php



class geteditioninfo
{

    public $is_allow = 1;
    public $update_method = 0; //新增、增量、全量,add/augmenter/full
    public $method;
    public $usr = "http://localhost:8081/all_test/shop/admin/api/rest.php";
    public $page;
    public $num;
    public $bid;
    public $err;
    public $list_array;
    public $type;


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


        if (empty($this->type)) {
            if ($this->is_allow == 1 && $this->method == "get.dition.info") {


                //echo 1;
                $get_dition_info = "select no,type,add_time,code,down_load_url,level from edition_info order by id desc ;";
                $get_dition_info = $GLOBALS['db']->getAll($get_dition_info);
                $list = array("item" => $get_dition_info, "sum" => count($get_dition_info));
                // print_r($new_list);exit;
                return $list;


            } else {
                $this->err['err'] = 1;
                $this->err['type_error'] = null; //
                //print_r($err);
                return $this->err;
            }
        }
        else
        {
            if ($this->is_allow == 1 && $this->method == "get.dition.info") {


                //echo 1;
                $get_dition_info = "select no,type,add_time,code,down_load_url,level from edition_info where  type='".$this->type."';";
                $get_dition_info = $GLOBALS['db']->getAll($get_dition_info);
                $list = array("item" => $get_dition_info, "sum" => count($get_dition_info));
                // print_r($new_list);exit;
                return $list;


            } else {
                $this->err['err'] = 2;
                $this->err['type_error'] = null; //
                //print_r($err);
                return $this->err;
            }
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