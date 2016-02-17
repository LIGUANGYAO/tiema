<?php

//开始判断登录类型 1渠道用户,2店铺用户
if ($is_allow['from_type'] == 1) {
    //bserp登录算法换算
    /**
     *  //加密用字符数组1
     * GC_CL1:array ['a'..'z'] of char=('q','w','e','r','t','y','u','i','o','p',
     * 'a','s','d','f','g','h','j','k','l',
     * 'z','x','c','v','b','n','m');
     * //加密用字符数组2
     * GC_CL2:array ['A'..'Z'] of char=('Q','W','E','R','T','Y','U','I','O','P',
     * 'A','S','D','F','G','H','J','K','L',
     * 'Z','X','C','V','B','N','M');
     * //加密用字符数组3
     * GC_CL3:array ['0'..'9'] of char=('2','9','1','4','7','0','3','8','5','6');
     */

    function ChangPwd($str)
    {
        if (preg_match('/^[a-z]+$/', $str)) {

            $az_array = array(
                "q" => "a",
                "w" => "b",
                "e" => "c",
                "r" => "d",
                "t" => "e",
                "y" => "f",
                "u" => "g",
                "i" => "h",
                "o" => "i",
                "p" => "j",
                "a" => "k",
                "s" => "l",
                "d" => "m",
                "f" => "n",
                "g" => "o",
                "h" => "p",
                "j" => "q",
                "k" => "r",
                "l" => "s",
                "z" => "t",
                "x" => "u",
                "c" => "v",
                "v" => "w",
                "b" => "x",
                "n" => "y",
                "m" => "z");
            $str2 = $az_array[$str];

        } elseif (preg_match('/^[A-Z]+$/', $str)) {
            $AZ_array = array(
                "Q" => "A",
                "W" => "B",
                "E" => "C",
                "R" => "D",
                "T" => "E",
                "Y" => "F",
                "U" => "G",
                "I" => "H",
                "O" => "I",
                "P" => "J",
                "A" => "K",
                "S" => "L",
                "D" => "M",
                "F" => "N",
                "G" => "O",
                "H" => "P",
                "J" => "Q",
                "K" => "R",
                "L" => "S",
                "Z" => "T",
                "X" => "U",
                "C" => "V",
                "V" => "W",
                "B" => "X",
                "N" => "Y",
                "M" => "Z");
            $str2 = $AZ_array[$str];

        } elseif (preg_match('/^\d+$/i', $str)) {
            //('2','9','1','4','7','0','3','8','5','6');
            switch ($str) {
                case 2;
                    $str2 = 0;
                    break;
                case 9;
                    $str2 = 1;
                    break;
                case 1;
                    $str2 = 2;
                    break;
                case 4;
                    $str2 = 3;
                    break;
                case 7;
                    $str2 = 4;
                    break;
                case 0;
                    $str2 = 5;
                    break;
                case 3;
                    $str2 = 6;
                    break;
                case 8;
                    $str2 = 7;
                    break;
                case 5;
                    $str2 = 8;
                    break;
                case 6;
                    $str2 = 9;
                    break;

            }
        } else {
            $str2 = $str;
        }
        return $str2;
    }

    function str_split_unicode($str, $l = 0)
    {
        if ($l > 0) {
            $ret = array();
            $len = mb_strlen($str, "UTF-8");
            for ($i = 0; $i < $len; $i += $l) {
                $ret[] = mb_substr($str, $i, $l, "UTF-8");
            }
            return $ret;
        }
        return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
    }

    if ($is_allow['password'] != '') {
        $pass = str_split_unicode($is_allow['password']);


        for ($k = 0; $k < count($pass); $k++) {
            $ChangPwd .= ChangPwd($pass[$k]);
        }
        //echo $ChangPwd . "<br>";
        //$.md5($.md5("!@#$%^&*("+$("#password").val())+"tiemal");


        //$ChangPwd = md5(md5("!@#()" . $ChangPwd));
        $ChangPwd = md5($ChangPwd);

    }

} elseif ($is_allow['from_type'] == 2) {
    function hex2bin_tm($str)
    {
        $sbin = "";
        $len = strlen($str);
        for ($i = 0; $i < $len; $i += 2) {
            $sbin .= pack("H*", substr($str, $i, 2));
        }
        //$sbin=base64_encode($sbin);
        return $sbin;
    }

    function sd_password($obj)
    {
        $obj = hex2bin_tm($obj);
        $msg = base64_encode($obj);
        return $msg;
    }
    //$msg = "8888";
//    $msg = md5($msg);
    $ChangPwd = sd_password($psword);

    
}

?>