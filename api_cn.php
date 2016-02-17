
<?php
define('IN_ECS', true);
require_once ('includes/init.php');


$url_this = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
//echo $url_this;


/**

 * $json='{"item1":{"item11":{"n":"chenling","m":"llll"},"sex":"男","age":"25"},"item2":{"item21":"ling","sex":"女","age":"24"}}'; 
 * //$json2='[{"goods_id":"1","goods_sn":"A001","goods_name":"服装","goods_outer_name":"修改","goods_note":"333331111333","goods_name_eg":"","tzsy":"1","allow_sj":"0","dw":"个","goods_weight":"0.000","dj":"0.00","dj2":"0.00","dj3":"0.00","dj4":"0.00","dj5":"0.00","bzsj":"0.00","jj":"1.00","jj2":"0.00","jj3":"0.00","jj4":"0.00","jj5":"0.00","is_gift":"0","is_gift_allow_count":"0","add_time":"1","is_delete":"0","last_update":"0"}]';
 *  $J=json_decode($json2);  print_r($json);  
 * print_r($J);
 */

//连接参数
define('API_KEY', 'test');
//define('SECRET','8888');
define('SECRET', '60f372fb8fa9076f06f2c0872fbfd358');
define('URL', 'http://localhost:8081/all_test/shop/admin/api/rest.php');

//define('URL','http://localhost:8081/all_test/shop/admin/api/api_ceshi.php');



//微信

//发送信息,需要openid,msg内容http://localhost:8081/news/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=send.wx.msg&is_allow=1&users_sn=WXVIP000000307&temporary_key=1076efa654f9c698&openid=osh4wuJuCSpUbW5SaZUJ5vTQI6Gc&msg=aaa
//微信


//http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=exe.sql&is_allow=1&format=json&sql=select * from goods;
//http://localhost:8081/all_test/shop/admin/api/api_cn.php
function conn()
{
    $ms_sql = "select+*+from+goods";
    $url = URL . "?api_key=" . API_KEY . "&secret=" . SECRET .
        "&method=exe.sql&is_allow=1&num=5&page=1&format=json&sql=" . $ms_sql;


    $url = "http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=insert.user.id&is_allow=1&user_sn=9909&user_name=是品&mobile_phone=1379922233"; //插入测试

//http://localhost:8081/all_test/shop/admin/api/rest_login.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=get.temporary.key&is_allow=1&users_sn=354096054650650&password=1  //获取注册的key

//获取商品
   // http://www.tiemal.com/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=get.goods.list&u_met=0&page=1&num=9&goods_sn=111,11111111&g_type=999&sort_field=jj,jj2&sort_type=1
//u_met=0的时候查找所有商品记录，u_met=1的时候才能按照goods_sn查找商品,page是第几页，num是一页显示多少数量,goods_sn 多商品用逗号隔开,&g_type&sort_field=jj&sort_type=1


//增加sort_field=jj,goods_sn字段按照逗号分开，
//增加sort_type=1的时候desc 不等于1 为空





//新增g_type=999商品属性，如果有加入g_type=则按照属性代码搜索代码商品
//http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=get.goodstype.list获取商品大类
//http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=get.yuyue.list&u_met=0&yuyue_sn=0201&page=1&num=3获取所有预约信息，当u_met=1的时候可以根据yuyue_sn查找预约信息或者根据yuyue_name查找，u_met =0的时候搜索出所有的预约信息，page是第几页，num是一页显示多少数量，默认5个,
//http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=leave.yuyue.message&is_allow=1&u_met=0&yuyue_sn=999&yuyue_name=9992013&sdmc=北京&tel=13722222222&name=黄&sl=4&yuyue_time_1=2013-11-20&yuyue_time_2=333 
//提交预约信息，sdmc商店名称 yuyue_time_1预约日，yuyue_time_2预约时段，yuyue_sn不能为空，yuyue_sn=机器码,yuyue_name等于机器码+日期唯一码

   // http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=get.user.id&is_allow=1&users_sn=211231///查询会员资料15259575716
    //echo $url;
    //$url=URL."?api_key=".API_KEY."&secret=".SECRET;
    //$output = file_get_contents($url);
    // exit;
    //echo $output;
    // $list=json_decode($output,true);
    //测试用户 list
    
    
    //项目类型
// http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=get.xmlx.list&is_allow=1&u_met=0

//项目列表
//http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=get.xmlb.list&is_allow=1&u_met=0   、、增加 p_id选项，来设置显示一个&p_id=001
    $url = "http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=get.zhanshi.list&is_allow=1&u_met=0"; //查询列表


//http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=get.company.list&is_allow=1&u_met=    //公司简介

//http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=leave.word.message&is_allow=1&u_met=0&users_sn=111&users_name=222&tel=1233444&msg_note_1=3333&msg_note_2=3333&msg_note_3=3331313212&qq=27888888&weixin=4444    提交留言
//http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=update.user.id&is_allow=1&users_sn=213131&users_name=33322233333&nick_name=esscha  //更新会员资料
// http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=get.user.id&is_allow=1&users_sn=13799225939&temporary_key=1111///查询会员资料
// http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=insert.user.id&is_allow=1&users_sn=213131&users_name=33322233333&nick_name=esscha///插入会员资料

//http://localhost:8081/all_test/shop/admin/api/rest_login.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=get.temporary.key&is_allow=1&users_sn=213131aaaaaaaaa&password=0987654321 //获取加密key
//http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=get.back.password&is_allow=1&users_sn=213131aaaaaaaaa&question=a001&answer=a001&new_password=a002   //根据问题，答案修改密码，
//http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=update.user.password&is_allow=1&users_sn=213131aaaaaaaaa&password=3333&new_password=999/根据旧密码修改密码


//http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=get.back.question&is_allow=1&users_sn=13799225939 //获取问题

//http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=get.new.list&page=1&num=1&bid=1


//获取百度地图坐标http://www.tiemal.com/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=get.map.info&map_sn=009

//获取版本信息http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=get.edition.info&type=android   type? android/apple

//page是第几页，num是1页多少数量 ,bid是指类型case when bid=1 then '产品动态' when bid=2 then '企业动态' when bid=3 then '行业资讯' end as leixing 
    $json = @file_get_contents($url);
    print_r($json);
    echo "<hr>";
    if (preg_match('/^\xEF\xBB\xBF/', $json)) {
        $json = substr($json, 3);
    }
    //$json=urldecode($json);
    $arr = json_decode($json, true);
    //$arr = ($arr);
    print_r($arr);
    exit;
    $index = 0;
    for ($i = 0; $i < count($list); $i++) {
        /**
         *   foreach($list[$i] as $list2[$i])
         *         {
         *            // print_r($list2[$i]);
         *         }
         *         echo "<hr>";
         */
        //print_r($list[$i])."<hr>";

        //add_color($list[$i]);
        $count = add_color($list[$i]);
        if ($count['error'] == 1) {
            $index = $index + 1;
        }

    }
    if (count($list) == $index) {
        echo "no record";
    }


}

conn();


/*
function conn()
{

$url=URL."?key=".KEY."&secret=".SECRET;



//$url = "http://www.jb51.net"; 
$ch = curl_init(); 
$timeout = 5; 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
//在需要用户检测的网页里需要增加下面两行 
//curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY); 
//curl_setopt($ch, CURLOPT_USERPWD, US_NAME.":".US_PWD); 
$contents = curl_exec($ch); 
curl_close($ch); 
//$html=$contents;

//$contents=trim($contents);
//echo $contents; 
//输出连接字符类型
//echo mb_detect_encoding($contents);
$list=json_decode($contents);

//echo mb_detect_encoding($list);
print_r($list);
}

conn();


*/
//$aaa=array('color_id'=>'1','color_code'=>'001','color_note'=>'');

function add_color($arr)
{
    //$arr['color_code'];
    //$sql_one="select color_code from color where color_code='".$arr['color_code']."';";
    $one = only_values('add_color', 'color_code', $arr['color_code']);
    if ($one == 0) {
        $sql = "insert into add_color(color_name,color_code,color_note) values ('" . $arr['color_name'] .
            "','" . $arr['color_code'] . "','" . $arr['color_note'] . "');";
        echo $sql;
        mysql_query($sql);
        echo $arr['color_code'] . "添加成功<br>";
    } else {
        //echo $arr['color_code']."已存在,添加失败<br>";
        return array('error' => '1');
    }

}
//add_color($aaa);

//http://localhost:8081/all_test/shop/admin/api/rest.php?api_key=test&secret=60f372fb8fa9076f06f2c0872fbfd358&method=exe.sql&is_allow=1&format=json&sql=select * from goods&num=10&page=1

?>
