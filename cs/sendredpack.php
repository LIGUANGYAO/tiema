<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init2.php');

//require (dirname(__file__) . '/sub/sub_openid.php');
require (dirname(__file__) . '/sub/sub_sendredpack.php');

if (empty($_REQUEST['g'])) {
    $_REQUEST['g'] = 'default';
} else {
    $_REQUEST['g'] = trim($_REQUEST['g']);
}


if ($_REQUEST['g'] == 'default') {


    ini_set('date.timezone', 'Asia/Shanghai');

    require_once "wxpay/lib/WxPay.Api.php";

    require_once "wxpay/WxPay.JsApiPay.php";

    //header('Content-type:text/json');
    //WxPayConfig::APPID


    $tools = new JsApiPay();
    $sendRedPa = $tools->GetSendRedPack();
    //print_r($sendRedPa);
   
    
    /*
    class Xmlclass
    {
        public $values = array();
        function ToXml()
        {
            if (!is_array($this->values) || count($this->values) <= 0) {
                echo "数组数据异常！";
            }

            $xml = "<xml>";
            foreach ($this->values as $key => $val) {
                if (is_numeric($val)) {
                    $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
                } else {
                    $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
                }
            }
            $xml .= "</xml>";
            return $xml;
        }
    }


    $Xmlclass = new Xmlclass();

    $Xmlclass->values=(array)json_decode($sendRedPa) ;
    

    $xml=$Xmlclass->ToXml();
    */
   
    $res = WxPayApi::sendRedPack($sendRedPa);
    print_r($res);
    
    exit;

    $smarty->assign('title', $aaa);
    $smarty->assign('p_Array', $goods_list['page']);
    $smarty->display('cs/bookbuy.html');


}




?>