<?php



class getusr
{

    public $is_allow = 1;
    public $update_method; //新增、增量、全量,add/augmenter/full
    public $method
    ;
    public $usr = "http://localhost:8081/all_test/shop/admin/api/rest.php";
    public $user_id;
    public $fields;
    public $err;
    public $user_array;


    // 拿到sql先判断语句是否有问题。先执行语句
    function exes($field, $users_sn)
    {
        return $this->get_user($field, $users_sn);
    }
    private function req($obj)
    {


        if (isset($_REQUEST[$obj])) {
            if (is_string($_REQUEST[$obj])) {
                $aaa = mysql_real_escape_string(trim($_REQUEST[$obj]));
                $aaa = str_replace(" ", "", $aaa); //转义掉”_”
                //$obj = str_replace("_","\_",$obj);//转义掉”_”
                $aaa = str_replace("%", "\%", $aaa); //转义掉”%”
                if ($aaa == "timeL") {
                    $aaa = date('Y-m-d H:i:s', time());
                } elseif ($aaa == "timeS") {
                    $aaa = date('Y-m-d', time());
                }
                return $aaa;
            } else {
                $aaa = $_REQUEST[$obj];
                if ($aaa == "timeL") {
                    $aaa = date('Y-m-d H:i:s', time());
                } elseif ($aaa == "timeS") {
                    $aaa = date('Y-m-d', time());
                }
                return $aaa;
            }

        }

    }

    private function get_user($field, $users_sn)
    {
        $tb = "users";
        //echo $this->method ;
        if ($this->is_allow == 1 && $this->method == "get.user.id") {

            $array = explode(",", $field);

            for ($i = 0; $i < count($array); $i++) {
                $dh1 = "";
                $dh2 = ",";

                if ($i == count($array) - 1) {
                    $dh2 = "";
                }
                $f1 .= $dh1 . $array[$i] . $dh2;

                $fh1 = "'";
                $fh2 = "',";

                if ($i == count($array) - 1) {
                    $fh2 = "'";
                }
                $f2 .= $fh1 . $this->req($array[$i]) . $fh2;

            }
            //print_r($f1);exit;
            // print_r($i);exit;
            $time = date('Y-m-d H:i:s', time());


            $sql1 = "select count(users_sn) as sl from " . $tb . " where users_sn = '" . $users_sn .
                "'";
            $res = $GLOBALS['db']->getRow($sql1);
            // print_r($sql1);exit;

            if ($res['sl'] == 1) {

                $sql1 = "select " . $f1 . " from " . $tb . " where users_sn = '" . $users_sn .
                    "'";
                // echo $sql1;exit;


                $res2['item'] = $GLOBALS['db']->getAll($sql1);
                $res2['sum'] = "1";
                $this->err['err'] = 1;
                $this->err['msg'] = "success"; //
                //print_r($sql1);
                return $res2;
            } else {
                $this->err['err'] = 2;
                $this->err['msg'] = "users_sn is not exists"; //
                //print_r($err);
                return $this->err;
            }

        } else {
            $this->err['err'] = 3;
            $this->err['msg'] = "message is already exists"; //
            //print_r($err);
            return $this->err;
        }


    }


}
?>