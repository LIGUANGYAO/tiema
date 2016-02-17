
<?php

//
//参数说明
//字段	 是否必须	说明
//com	必须	快递公司代码（英文），所支持快递公司见如下列表
//nu	必须	快递单号，长度必须大于5位
//id	必须	授权KEY，申请请点击快递查询API申请方式
//在新版中ID为一个纯数字型，此时必须添加参数secret（secret为一个小写的字符串）
//secret	必选(新增)	该参数为新增加，老用户可以使用申请时填写的邮箱和接收到的KEY值登录http://api.ickd.cn/users/查看对应secret值
//type	可选	返回结果类型，值分别为 html | json（默认） | text | xml
//encode	可选	gbk（默认）| utf8
//ord	可选	asc（默认）|desc，返回结果排序
//lang	可选	en返回英文结果，目前仅支持部分快递（EMS、顺丰、DHL）
//
//

//
//status	int	查询结果状态，0|1|2|3|4，0表示查询失败，1正常，2派送中，3已签收，4退回,5其他问题
//errCode	int	错误代码，0无错误，1单号不存在，2验证码错误，3链接查询服务器失败，4程序内部错误，5程序执行错误，6快递单号格式错误，7快递公司错误，10未知错误，20API错误，21API被禁用，22API查询量耗尽。
//message	string	错误消息
//data	array	进度
//html	string	其他HTML，该字段不一定存在
//mailNo	string	快递单号
//expSpellName	string	快递公司英文代码
//expTextName	string	快递公司中文名
//update	int	最后更新时间（unix 时间戳）
//cache	int	缓存时间，当前时间与 update 之间的差值，单位为：秒
//ord	string	排序，ASC | DESC
//$typeCom = $_GET["com"];//快递公司
//$typeNu = $_GET["nu"];  //快递单号


//efast快递列表
//sf	顺丰速运
//ems	EMS
//sto	申通快递
//yto	圆通速递
//zto	中通速递
//zjs	宅急送
//yunda	韵达
//cces	cces快递
//pick	上门提货
//grxj	个人现金
//other	当当COD
//htky	汇通快运
//ttkdex	天天快递
//vems	V+EMS
//Vsf	V+顺丰
//vyunda	V+韵达
//vzjs	V+宅急送
//vyto	V+圆通
//JDex	京东快递
//jdsf	京东顺丰
//jd	京东快递1
//2794	OTHER	-1	其他
//2795	POST	1	中国邮政平邮
//2796	AIR	507	亚风
//2797	CYEXP	511	长宇
//2798	DTW	512	大田
//2799	YUD	513	长发
//2800	DFH	1137	东方汇	^[0-9]{10}$|^LBX[0-9]{15}-[2-9AZ]{1}-[1-9A-Z]{1}
//2801	SY	1138	首业	^29[0-9]{8}$
//2802	YC	1139	远长	^96[0-9]{12}$
//2803	UNIPS	1237	发网
//2804	GZLT	200427	飞远配送
//2805	QFKD	1216	全峰快递	^[0-9]{12}$|^[0-9]{15}$
//2806	SCKJ	1236	成都东骏快捷	^[0-9]{13}$|^[0-9]{15}$|^[0-9]{15}-[1-9A-Z]{1}-[1-9A-Z]{1}$
//2807	UAPEX	1259	全一快递	^d{12}|d{11}$
//2808	GDEMS	1269	广东EMS	^[a-zA-Z]{2}[0-9]{9}[a-zA-Z]{2}$
//2809	EYB	3	EMS经济快递	^(50|51)[0-9]{11}$
//2810	HZABC	1121	杭州爱彼西	^[0-9]{10,11}$|^T[0-9]{10}$|^LBX[0-9]{15}-[2-9AZ]{1}-[1-9A-Z]{1}$
//2811	ZJS	103	宅急送	^[a-zA-Z0-9]{10}$
//2812	FEDEX	106	联邦快递	^[0-9]{12}$
//2813	SF	505	顺丰速运	^[0-9]{12}$|\d{9}
//2814	LB	1195	龙邦速递	^[0-9]{12}$|^LBX[0-9]{15}-[2-9AZ]{1}-[1-9A-Z]{1}$|^[0-9]{15}$|^[0-9]{15}-[1-9A-Z]{1}-[1-9A-Z]{1}$
//2815	FAST	1204	快捷速递	^[A-Z]{2}[0-9]{9}[A-Z]{2}$|^[0-9]{13}$
//2816	YCT	1185	黑猫宅急便	^[0-9]{12}$
//2817	NEDA	1192	港中能达	^((88|)[0-9]{10})$|^((1|2|3|5|)[0-9]{9})$|^(900[0-9]{9})$
//2818	UC	1207	优速快递	^VIP[0-9]{9}|V[0-9]{11}|[0-9]{12}$|^LBX[0-9]{15}-[2-9AZ]{1}-[1-9A-Z]{1}
//2819	GZFY	202857	凡宇速递	^[0-9]{12}$
//2820	LTS	1214	联昊通	^[0-9]{9,12}$
//2821	BJCS	1262	城市100	^(CS[0-9]{13})$|^([0-9]{13})$|^([0-9]{9})$
//2822	ZHQKD	200982	汇强快递	^([0-9]{11})$|^([0-9]{12})$
//2823	SURE	201174	速尔	^[0-9]{11}[0-9]{1}$
//2824	EMS	2	EMS	^[A-Z]{2}[0-9]{9}[A-Z]{2}$|^[0-9]{13}$
//2825	YTO	101	圆通速递	^(0|1|2|3|5|6|7|8|E|D|F|G|V|W|e|d|f|g|v|w)[0-9]{9}$
//2826	ZTO	500	中通速递	^((618|680|778|768|688|618|828|988|118|888|571|518|010|628|205|880|717|718|728|738|761|762|763|701|757)[0-9]{9})$|^((2008|2010|8050|7518)[0-9]{8})$
//2827	YUNDA	102	韵达快运	^[s]*[1-9][0-9]{12}[s]*$
//2828	TTKDEX	504	天天快递	^[0-9]{12}$
//2829	CNEX	1056	佳吉快运	^[0-9]{9,10}$
//2830	BEST	105	百世物流	^[0-9]{10}$
//2831	DBL	107	德邦物流	^[0-9]{8,10}$
//2832	SHQ	108	华强物流	^[A-Za-z0-9]*[0|2|4|6|8]$
//2833	HTKY	502	汇通快运	^(A|B|C|D|E|H|0)(D|X|[0-9])(A|[0-9])[0-9]{10}$|^(21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37|38|39)[0-9]{10}$|^50[0-9]{12}$
//2834	CRE	1016	中铁快运	^K[0-9]{13}$
//2835	XFWL	202855	信丰物流	^1[38]{1}[8-9]{1}[0-9]{9}$
//2836	STO	100	申通E物流	^(268|888|588|688|368|468|568|668|768|868|968)[0-9]{9}$|^(268|888|588|688|368|468|568|668|768|868|968)[0-9]{10}$|^(STO)[0-9]{10}$
//2837	HOAU	1191	天地华宇	^[0-9]{8}$
//2838	POSTB	200734	邮政国内小包	^[GA]{2}[0-9]{9}([2-5][0-9]|[1][1-9]|[6][0-5])$|^[99]{2}[0-9]{11}$
//2839	XB	1186	新邦物流	[0-9]{8}
//2840	QRT	1208	全日通快递	^[0-9]{12}$
//2841	GTO	200143	国通快递	^(2|3|8|5|6|7)[0-9]{9}$
//2842	ESB	200740	E速宝	[0-9a-zA-Z-]{5,20}
//2843	JD	-1	京东物流	[0-9]{12}
//


function preg_zz($obj)
{
    $zhengze = array(
        array("name" => "sf", "preg" => "/^[0-9]{12}$|\d{9}/"),
        array("name" => "ems", "preg" => "/^[A-Z]{2}[0-9]{9}[A-Z]{2}$|^[0-9]{13}$/"),
        array("name" => "sto", "preg" =>
                "/^(268|888|588|688|368|468|568|668|768|868|968)[0-9]{9}$|^(268|888|588|688|368|468|568|668|768|868|968)[0-9]{10}$|^(STO)[0-9]{10}$/"),
        array("name" => "zto", "preg" =>
                "/^((618|680|778|768|688|618|828|988|118|888|571|518|010|628|205|880|717|718|728|738|761|762|763|701|757)[0-9]{9})$|^((2008|2010|8050|7518)[0-9]{8})$/"),
        array("name" => "zjs", "preg" => "/^[a-zA-Z0-9]{10}/"),
        array("name" => "yunda", "preg" => "/^[s]*[1-9][0-9]{12}[s]*$/"),
        array("name" => "htky", "preg" => "/^(A|B|C|D|E|H|0)(D|X|[0-9])(A|[0-9])[0-9]{10}$|^(21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37|38|39)[0-9]{10}$|^50[0-9]{12}$"),
        array("name" => "ttkdex", "preg" => "/^[0-9]{12}$/"),
        array("name" => "jd", "preg" => "/^[0-9]{12}/"),
        array("name" => "yto", "preg" =>
                "/^(0|1|2|3|5|6|7|8|E|D|F|G|V|W|e|d|f|g|v|w)[0-9]{9}$/"),
        );

    $a = array();
    for ($i = 0; $i < count($zhengze); $i++) {
        $dat = preg_match($zhengze[$i]['preg'], $obj);
        //print_r($dat) ;
        if ($dat == 1) {
            array_push($a, $zhengze[$i]['name']);
        }


    }

    $kuaidi_arr = array();
    for ($j = 0; $j < count($a); $j++) {
        $action = shipping($a[$j]);
        $inf = kuaidi_action($action, $obj);

        if ($inf['errCode'] == 0) {
            array_push($kuaidi_arr, $inf);
        }
    }
    return $kuaidi_arr;
}


//print_r($zhengze);


function shipping($obj)
{
    switch ($obj) {
        case 'sf':
            $data = "shunfeng";
            break;
        case 'ems':
            $data = "ems";
            break;
        case 'sto':
            $data = "shentong";
            break;
        case 'yto':
            $data = "yuantong";
            break;
        case 'zto':
            $data = "zhongtong";
            break;
        case 'zjs':
            $data = "zhaijisong";
            break;
        case 'yunda':
            $data = "yunda";
            break;
        case 'cces':
            $data = "cces";
            break;
        case 'pick':
            $data = "pick";
            break;
        case 'htky':
            $data = "huitong";
            break;
        case 'ttkdex':
            $data = "tiantian";
            break;
        case 'vems':
            $data = "ems";
            break;
        case 'Vsf':
            $data = "shunfeng";
            break;
        case 'vyunda':
            $data = "yunda";
            break;
        case 'vzjs':
            $data = "zhaijisong";
            break;
        case 'vyto':
            $data = "yuantong";
            break;
        case 'JDex':
            $data = "jingdong";
            break;
        case 'jdsf':
            $data = "jingdong";
            break;
        case 'jd':
            $data = "jingdong";
            break;

    }
    return $data;
}


$typeCom = "shentong";
$typeNu = "868020761205";


function kuaidi_action($typeCom, $typeNu)
{
    $type = 'json';
    $encode = 'utf8';

    $id = '104235';
    $AppKey = 'f359c979eb8ccc941819175e3c577333'; //请将XXXXXX替换成您在http://kuaidi100.com/app/reg.html申请到的KEY

    $url = "http://api.ickd.cn/?id=$id&secret=$AppKey&com=$typeCom&nu=$typeNu&type=$type&ord=desc&encode=$encode&ver=2&button=%CC%E1%BD%BB";


    //优先使用curl模式发送数据
    if (function_exists('curl_init') == 1) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        $get_content = curl_exec($curl);
        curl_close($curl);
    } else {
        /*
        include("snoopy.php");
        $snoopy = new snoopy();
        $snoopy->referer = 'http://www.google.com/';//伪装来源
        $snoopy->fetch($url);
        $get_content = $snoopy->results;*/
    }


    $get_content = json_decode($get_content);

    $get_content = (array )$get_content;
    $get_content['data'] = objtoarr($get_content['data']);
    return $get_content;
    // $fre = objtoarr($get_content);
    //    return $fre;
}
function objtoarr($obj)
{
    $ret = array();
    foreach ($obj as $key => $value) {
        if (gettype($value) == 'array' || gettype($value) == 'object') {
            $ret[$key] = objtoarr($value);
        } else {
            $ret[$key] = $value;
        }
    }
    return $ret;
}
//$aa=kuaidi_action($typeCom,$typeNu);

//print_r($aa);
//	aae	AAE快递
//2	anjie	安捷快递
//3	anxinda	安信达快递
//4	aramex	Aramex国际快递
//5	balunzhi	巴伦支
//6	baotongda	宝通达
//7	benteng	成都奔腾国际快递
//8	cces	CCES快递
//9	changtong	长通物流
//10	chengguang	程光快递
//11	chengji	城际快递
//12	chengshi100	城市100
//13	chuanxi	传喜快递
//14	chuanzhi	传志快递
//15	chukouyi	出口易物流
//16	citylink	CityLinkExpress
//17	coe	东方快递
//18	cszx	城市之星
//19	datian	大田物流
//20	dayang	大洋物流快递
//21	debang	德邦物流
//22	dechuang	德创物流
//23	dhl	DHL快递
//24	diantong	店通快递
//25	dida	递达快递
//26	dingdong	叮咚快递
//27	disifang	递四方速递
//28	dpex	DPEX快递
//29	dsu	D速快递
//30	ees	百福东方物流
//31	ems	EMS快递
//32	fanyu	凡宇快递
//33	fardar	Fardar
//34	fedex	国际Fedex
//35	fedexcn	Fedex国内
//36	feibang	飞邦物流
//37	feibao	飞豹快递
//38	feihang	原飞航物流
//39	feihu	飞狐快递
//40	feite	飞特物流
//41	feiyuan	飞远物流
//42	fengda	丰达快递
//43	fkd	飞康达快递
//44	gdyz	广东邮政物流
//45	gnxb	邮政国内小包
//46	gongsuda	共速达物流|快递
//47	guotong	国通快递
//48	haihong	山东海红快递
//49	haimeng	海盟速递
//50	haosheng	昊盛物流
//51	hebeijianhua	河北建华快递
//52	henglu	恒路物流
//53	huacheng	华诚物流
//54	huahan	华翰物流
//55	huaqi	华企快递
//56	huaxialong	华夏龙物流
//57	huayu	天地华宇物流
//58	huiqiang	汇强快递
//59	huitong	汇通快递
//60	hwhq	海外环球快递
//61	jiaji	佳吉快运
//62	jiayi	佳怡物流
//63	jiayunmei	加运美快递
//64	jinda	金大物流
//65	jingdong	京东快递
//66	jingguang	京广快递
//67	jinyue	晋越快递
//68	jixianda	急先达物流
//69	jldt	嘉里大通物流
//70	kangli	康力物流
//71	kcs	顺鑫(KCS)快递
//72	kuaijie	快捷快递
//73	kuanrong	宽容物流
//74	kuayue	跨越快递
//75	lejiedi	乐捷递快递
//76	lianhaotong	联昊通快递
//77	lijisong	成都立即送快递
//78	longbang	龙邦快递
//79	minbang	民邦快递
//80	mingliang	明亮物流
//81	minsheng	闽盛快递
//82	nell	尼尔快递
//83	nengda	港中能达快递
//84	ocs	OCS快递
//85	pinganda	平安达
//86	pingyou	中国邮政平邮
//87	pinsu	品速心达快递
//88	quanchen	全晨快递
//89	quanfeng	全峰快递
//90	quanjitong	全际通快递
//91	quanritong	全日通快递
//92	quanyi	全一快递
//93	rpx	RPX保时达
//94	rufeng	如风达快递
//95	saiaodi	赛澳递
//96	santai	三态速递
//97	scs	伟邦(SCS)快递
//98	shengan	圣安物流
//99	shengbang	晟邦物流
//100	shengfeng	盛丰物流
//101	shenghui	盛辉物流
//102	shentong	申通快递（可能存在延迟）
//103	shunfeng	顺丰快递
//104	suchengzhaipei	速呈宅配
//105	suijia	穗佳物流
//106	sure	速尔快递
//107	tiantian	天天快递
//108	tnt	TNT快递
//109	tongcheng	通成物流
//110	tonghe	通和天下物流
//111	ups	UPS快递
//112	usps	USPS快递
//113	wanbo	万博快递
//114	wanjia	万家物流
//115	weitepai	微特派
//116	xianglong	祥龙运通快递
//117	xinbang	新邦物流
//118	xinfeng	信丰快递
//119	xingchengzhaipei	星程宅配快递
//120	xiyoute	希优特快递
//121	yad	源安达快递
//122	yafeng	亚风快递
//123	yibang	一邦快递
//124	yinjie	银捷快递
//125	yinsu	音素快运
//126	yishunhang	亿顺航快递
//127	yousu	优速快递
//128	ytfh	北京一统飞鸿快递
//129	yuancheng	远成物流
//130	yuantong	圆通快递
//131	yuanzhi	元智捷诚
//132	yuefeng	越丰快递
//133	yumeijie	誉美捷快递
//134	yunda	韵达快递
//135	yuntong	运通中港快递
//136	yuxin	宇鑫物流
//137	ywfex	源伟丰
//138	zengyi	增益快递
//139	zhaijisong	宅急送快递
//140	zhengzhoujianhua	郑州建华快递
//141	zhima	芝麻开门快递
//142	zhongtian	济南中天万运
//143	zhongtie	中铁快运
//144	zhongtong	中通快递
//145	zhongxinda	忠信达快递
//146	zhongyou	中邮物流


//print_r(kuaidi_action("zto","718472812577"))



?>

