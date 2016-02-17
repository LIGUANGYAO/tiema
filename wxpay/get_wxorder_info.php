<?php



$jsonmenu = '
{
"status": 2,

}';

//"begintime": 1397130460,
//"endtime": 1397130470

$access_token="Y-S-sW57VcBvyxaacGXKMPdvc3zToawW_NK_c6gMmiQicH5SPs5LkpKUUIilWc-VDM5naeYdeq0rKboiEd-vgQ";
$url = "https://api.weixin.qq.com/merchant/order/getbyfilter?access_token=" . $access_token;
$result = https_request($url, $jsonmenu);
print_r($result);

function https_request($url, $data = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}
