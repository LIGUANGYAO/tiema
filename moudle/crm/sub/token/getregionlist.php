<?php



class getregionlist{
    public $page;
    public $num;
    // �õ�sql���ж�����Ƿ������⡣��ִ�����
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
        


        //�粻����getregionlist_uc.php�ļ�,�����н���һ���հ�php�ļ�
        require (dirname(__file__) . '/getregionlist_uc.php');
        
        //��������
        //$list = array("item" => $ls, "sum" => count($ls),"time"=>date('Y-m-d H:i:s', time()));
        return $list;
        
        
       
    }
    public function get_more($obj)
    {

        //$string = "1,2,3,4,5";
        // echo 1;
        $array = explode(",", $obj);
        for ($i = 0; $i < count($array); $i++) {
            $f1 = "'";
            $f2 = "',";
            if ($i == count($array) - 1) {
                $f2 = "'";
            }
            $str .= $f1 . $array[$i] . $f2;
        }
        return $str;

    }
    
     public function get_more2($obj)
    {

        //$string = "1,2,3,4,5";
        // echo 1;
        $array = explode(",", $obj);
        for ($i = 0; $i < count($array); $i++) {
            $f1 = '"';
            $f2 = '",';
            if ($i == count($array) - 1) {
                $f2 = '"';
            }
            $str .= $f1 . $array[$i] . $f2;
        }
        return $str;

    }
    public function otxt($name,$content)
    {
        if($name=='')
        {
            $name="test";
        }
        $of = fopen("logs/".$name.'.txt', 'a'); //��������dir.txt
        if ($of) {
            fwrite($of, "[" . date('Y-m-d H:i:s', time()) . "]\r\n" . $content . "\r\n"); //��ִ���ļ��Ľ��д��txt�ļ�
        }
    }
    //$note=note("djbh",$lsxhd_list[$i]['djbh'],$note);
    private function note($res,$obj,$note)
    {
        $obj2 = str_replace("{".$res."}", $obj, $note);
       
        return $obj2;
    }
}





?>