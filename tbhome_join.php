<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>申请表单</title>
    <link rel="stylesheet" href="http://weui.github.io/weui/weui.css"/>
    <link rel="stylesheet" href="http://weui.github.io/weui/example.css"/>
    <!--script type="text/javascript">
        //获取共享地址
        function editAddress()
        {
            WeixinJSBridge.invoke(
                'editAddress',
                <?php// echo $editAddress; ?>,
                function(res){
                    var value1 = res.proviceFirstStageName;
                    var value2 = res.addressCitySecondStageName;
                    var value3 = res.addressCountiesThirdStageName;
                    var value4 = res.addressDetailInfo;
                    var tel = res.telNumber;

                    alert(value1 + value2 + value3 + value4 + ":" + tel);
                }
            );
        }

        window.onload = function(){
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', editAddress, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', editAddress);
                    document.attachEvent('onWeixinJSBridgeReady', editAddress);
                }
            }else{
                editAddress();
            }
        };

    </script-->
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016-02-03
 * Time: 18:36
 */
require_once "cs/wxpay/WxPay.JsApiPay.php";
$tools = new JsApiPay();
$openId = $tools->GetOpenid();
if (isset($_POST['truename'])){
    var_dump($_POST);

echo <<<EOF
<br/>
<div id="toast" style="display: visible;">
    <div class="weui_mask_transparent"></div>
    <div class="weui_toast">
        <i class="weui_icon_toast"></i>
        <p class="weui_toast_content">提交成功！</p>
    </div>
</div>

EOF;


}
//var_dump($openId);
//print_r($openId);
//①、获取用户openid

//获取共享收货地址js函数参数
//$editAddress = $tools->GetEditAddressParameters();
//var_dump($editAddress);
?>

<!--i class="weui_icon_msg weui_icon_info"></i-->

<font color="#9ACD32"><b><span style="color:#f00;font-size:30px">微信绑定</span></b></font>

<div align="center">

    <div class="weui_cells_title">申请表单</div>


    <form id="jion" action=" " method="post">

    <input type="hidden" name="openid" value="<?php print_r($openId) ?>">

    <div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">Openid</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <?php print_r($openId) ?>
            </div>
        </div>


        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">姓名</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" id="truename" name="truename" type="text" placeholder="输入姓名，与银行卡一致"/>
            </div>
        </div>


        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">身份证</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" name="nationalid" type="number" pattern="[0-9]*" placeholder="请输入身份证号"/>
            </div>
        </div>

        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">手机</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" name="mobile" type="number" pattern="[0-9]*" placeholder="请输入手机号"/>
            </div>
        </div>


        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">Q Q</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" name="qq" type="number" pattern="[0-9]*" placeholder="请输入QQ号"/>
            </div>
        </div>

        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">车辆识别码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" name="vin" type="text" placeholder=" "/>
            </div>
        </div>

        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">车牌号</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" name="plateid" type="text" placeholder=" "/>
            </div>
        </div>



    </div>
    <div class="weui_cells_tips">微信钱包需绑定银行卡才能进行提现,姓名须与绑定银行卡一致)</div>
    <div class="weui_btn_area">
        <button type="submit" class="weui_btn weui_btn_primary">绑定</button>

    </div>

    </form>

</div>
</body>
</html>
