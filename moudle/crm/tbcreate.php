<?php
define('IN_ECS', true);


require (dirname(__file__) . '/includes/init.php');


if (empty($_REQUEST['g'])) {
    $_REQUEST['g'] = 'default';
} else {
    $_REQUEST['g'] = trim($_REQUEST['g']);
}

if ($_REQUEST['g'] == 'default') {

        
    

        //开始增加判断表格是否存在并删除
        $drop = "drop TABLE  if exists kehu";
        $drop = $GLOBALS['db']->query($drop);
        
        $drop = "drop TABLE  if exists kehu_mx";
        $drop = $GLOBALS['db']->query($drop);
        
        //建立主表
        $create_z = "CREATE TABLE IF NOT EXISTS kehu (id int unsigned auto_increment primary key ,kehu_sn varchar(100)   NULL default NULL  comment '客户代码',kehu_name varchar(100)   NULL default NULL  comment '客户名称',tel varchar(20)   NULL default NULL  comment '固定电话',mobile varchar(20)   NULL default NULL  comment '移动电话',bz text  NULL default NULL  comment '客户备注',gongsimingcheng varchar(100)   NULL default NULL  comment '客户公司',zhiwei varchar(100)   NULL default NULL  comment '职位',email varchar(100)   NULL default NULL  comment 'email',chuanzhen varchar(30)   NULL default NULL  comment '传真号',khlx int(11)   NULL default '0'  comment '客户类型(0普通客户,1vip客户,2潜在客户,3失效客户)',hangye varchar(100)   NULL default NULL  comment '行业',hangye_bz varchar(200)   NULL default NULL  comment '行业描述',sl int(0)   NULL default '1'  comment '数量',sort_no int(11) default '0' comment '排列顺序',add_time DATETIME default '0000-00-00 00:00:00' comment '添加时间',last_update  timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP comment '最近更新',last_update2 DATE default '0000-00-00' comment '时间2',tzsy int(11) default 0 comment '停用')engine=MyISAM default charset=utf8 auto_increment=1";
        $create_z = $GLOBALS['db']->query($create_z);
        
        //循环加入索引
        $create_index = "create UNIQUE index kehu_sn on kehu(kehu_sn); ";
        $create_index = $GLOBALS['db']->query($create_index);
        
        //如果有细表建立细表
        

        //----end------
        
    

        //开始增加判断表格是否存在并删除
        $drop = "drop TABLE  if exists pinggu";
        $drop = $GLOBALS['db']->query($drop);
        
        $drop = "drop TABLE  if exists pinggu_mx";
        $drop = $GLOBALS['db']->query($drop);
        
        //建立主表
        $create_z = "CREATE TABLE IF NOT EXISTS pinggu (id int unsigned auto_increment primary key ,pinggu_sn varchar(100)   NULL default NULL  comment '评估代码',pinggu_name varchar(100)   NULL default NULL  comment '评估名称',kehu_id int(11)   NULL default NULL  comment '客户id',kehu_name varchar(100)   NULL default NULL  comment '客户名称',pinggu_obj text  NULL default NULL  comment '评估对象',jianzhumianji varchar(30)   NULL default NULL  comment '建筑面积',danjia varchar(30)   NULL default '0'  comment '评估单价',shichangzongjia varchar(30)   NULL default NULL  comment '市场总价',shoufei decimal(30,2)   NULL default NULL  comment '收费',gongsi_id int(11)   NULL default NULL  comment '评估公司id',pinggu_time date  NULL default '0000-00-00'  comment '评估日期',yinhang_id int(11)   NULL default NULL  comment '银行id',yinhang_lianxiren varchar(100)   NULL default NULL  comment '银行联系人',yinhang_lxr_tel varchar(100)   NULL default NULL  comment '银行联系人电话',chubaogao_sl int(11)   NULL default '0'  comment '出报告数量',naben1_time date  NULL default '0000-00-00'  comment '拿报告1时间',naben2_time date  NULL default '0000-00-00'  comment '拿报告2时间',naben3_time date  NULL default '0000-00-00'  comment '拿报告3时间',bz text  NULL default NULL  comment '备注',kehu_tel varchar(30)   NULL default NULL  comment '客户电话',sort_no int(11) default '0' comment '排列顺序',add_time DATETIME default '0000-00-00 00:00:00' comment '添加时间',last_update  timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP comment '最近更新',last_update2 DATE default '0000-00-00' comment '时间2',tzsy int(11) default 0 comment '停用')engine=MyISAM default charset=utf8 auto_increment=1";
        $create_z = $GLOBALS['db']->query($create_z);
        
        //循环加入索引
        $create_index = "create UNIQUE index pinggu_sn on pinggu(pinggu_sn); ";
        $create_index = $GLOBALS['db']->query($create_index);
        
        //如果有细表建立细表
        

        //----end------
        
    

        //开始增加判断表格是否存在并删除
        $drop = "drop TABLE  if exists gongsi";
        $drop = $GLOBALS['db']->query($drop);
        
        $drop = "drop TABLE  if exists gongsi_mx";
        $drop = $GLOBALS['db']->query($drop);
        
        //建立主表
        $create_z = "CREATE TABLE IF NOT EXISTS gongsi (id int unsigned auto_increment primary key ,gongsi_sn varchar(100)   NULL default NULL  comment '公司代码',gongsi_name varchar(100)   NULL default NULL  comment '公司名称',lianxiren varchar(100)   NULL default NULL  comment '公司联系人',tel varchar(30)   NULL default NULL  comment '联系人电话',bz text  NULL default NULL  comment '备注',sort_no int(11) default '0' comment '排列顺序',add_time DATETIME default '0000-00-00 00:00:00' comment '添加时间',last_update  timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP comment '最近更新',last_update2 DATE default '0000-00-00' comment '时间2',tzsy int(11) default 0 comment '停用')engine=MyISAM default charset=utf8 auto_increment=1";
        $create_z = $GLOBALS['db']->query($create_z);
        
        //循环加入索引
        $create_index = "create UNIQUE index gongsi_sn on gongsi(gongsi_sn); ";
        $create_index = $GLOBALS['db']->query($create_index);
        
        //如果有细表建立细表
        

        //----end------
        
    

        //开始增加判断表格是否存在并删除
        $drop = "drop TABLE  if exists yinhang";
        $drop = $GLOBALS['db']->query($drop);
        
        $drop = "drop TABLE  if exists yinhang_mx";
        $drop = $GLOBALS['db']->query($drop);
        
        //建立主表
        $create_z = "CREATE TABLE IF NOT EXISTS yinhang (id int unsigned auto_increment primary key ,yinhang_sn varchar(100)   NULL default NULL  comment '银行代码',yinhang_name varchar(100)   NULL default NULL  comment '银行名称',lianxiren varchar(100)   NULL default NULL  comment '联系人',tel varchar(30)   NULL default NULL  comment '联系人电话',bz text  NULL default NULL  comment '备注',sort_no int(11) default '0' comment '排列顺序',add_time DATETIME default '0000-00-00 00:00:00' comment '添加时间',last_update  timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP comment '最近更新',last_update2 DATE default '0000-00-00' comment '时间2',tzsy int(11) default 0 comment '停用')engine=MyISAM default charset=utf8 auto_increment=1";
        $create_z = $GLOBALS['db']->query($create_z);
        
        //循环加入索引
        $create_index = "create UNIQUE index yinhang_sn on yinhang(yinhang_sn); ";
        $create_index = $GLOBALS['db']->query($create_index);
        
        //如果有细表建立细表
        

        //----end------
        
    

        //开始增加判断表格是否存在并删除
        $drop = "drop TABLE  if exists loupan";
        $drop = $GLOBALS['db']->query($drop);
        
        $drop = "drop TABLE  if exists loupan_mx";
        $drop = $GLOBALS['db']->query($drop);
        
        //建立主表
        $create_z = "CREATE TABLE IF NOT EXISTS loupan (id int unsigned auto_increment primary key ,loupan_sn varchar(100)   NULL default NULL  comment '楼盘代码',loupan_name varchar(100)   NULL default NULL  comment '楼盘名称',yongtu int(11)   NULL default '1'  comment '楼盘用户(1住宅,2商业)',tudijb_lb varchar(100)   NULL default NULL  comment '土地级别及类型',weizhi text  NULL default NULL  comment '位置状况',weizhi_pj int(11)   NULL default '1'  comment '位置评价(1优,2较优,3普通,4较劣,5劣)',zhuzhaijuji text  NULL default NULL  comment '住宅聚集水平',zhuzhaijuji_pj int(11)   NULL default '1'  comment '住宅聚集水平取值(1高,2较高,3普通,4较低,5低)',jiaotong text  NULL default NULL  comment '交通状况',jiaotong_pj int(11)   NULL default '1'  comment '交通状况取值(1好,2较好,3普通,4较差,5差)',peitao text  NULL default NULL  comment '城市基础及公共服务配套设施',peitao_pj int(11)   NULL default '1'  comment '配套取值(1完善,2较完善,3普通,4较不完善,5不完善)',huanjing text  NULL default NULL  comment '环境和景观',huanjing_pj int(11)   NULL default '1'  comment '环境取值(1好,2较好,3普通,4较差,5差)',loucengshu int(11)   NULL default '1'  comment '楼层',chaoxiang int(11)   NULL default '1'  comment '坐向(1坐北朝南,2坐南朝北)',zhongdianxuexiao text  NULL default NULL  comment '重点学校',zhongdianxuexiao_pj int(11)   NULL default '1'  comment '有无重点学校(1无,2有)',fangwuquanli text  NULL default NULL  comment '房屋权利性质',fangwuquanli_qt text  NULL default NULL  comment '他项权利设定情况',wuyeguanli text  NULL default NULL  comment '物业管理及安防系统',wuyeguanli_pj int(11)   NULL default '1'  comment '物业评价(1好,2较好,3普通,4较差,5差)',chengxinlv varchar(200)   NULL default NULL  comment '成新率',waiguan varchar(200)   NULL default NULL  comment '外观及外墙面饰材',waiguan_pj int(11)   NULL default '1'  comment '外观评价(1好,2较好,3普通,4较差,5差)',jiegouzhishi varchar(100)   NULL default NULL  comment '结构质式',dianti int(11)   NULL default '1'  comment '电梯(1无,2有)',jianzhumianji int(11)   NULL default '0'  comment '建筑面积(㎡）',suochuxiaoquweizhi varchar(200)   NULL default NULL  comment '所处小区位置',suochuxiaoquweizhi_pj int(11)   NULL default '1'  comment '小区位置评价(1好,2一般,3较差)',xiaoquhuanjingjingguan varchar(200)   NULL default NULL  comment '小区环境景观',xiaoquhuanjingjingguan_pj int(11)   NULL default '1'  comment '小区环境评价(1好,2较好,3普通,4较差,5差)',xiaoqupeitao text  NULL default NULL  comment '小区内配套设施',xiaoqupeitao_pj int(11)   NULL default '1'  comment '小区内配套评价(1完善,2较完善,3普通,4较不完善,5不完善)',kongjianbuju varchar(200)   NULL default NULL  comment '空间格局',kongjianbuju_pj int(11)   NULL default NULL  comment '空间格局评价(1好,2较好,3普通,4较差,5差)',caiguangtongfeng varchar(200)   NULL default NULL  comment '采光通风',caiguangtongfeng_pj int(11)   NULL default '1'  comment '采光通风评价(1好,2较好,3普通,4较差,5差)',tudijibie_leixing varchar(255)   NULL default NULL  comment '土地级别及类型（商业）',fanhuachengdu text  NULL default NULL  comment '商业繁华程度',fanhuachengdu_pj int(11)   NULL default '1'  comment '商业繁华程度取值(1高,2较高,3普通,4较低,5低)',weizhizhuangkuang text  NULL default NULL  comment '位置状况',weizhizhuangkuang_pj int(11)   NULL default '1'  comment '位置状况评价(1优,2较优,3普通,4较劣,5劣)',linjiezhuangkuang varchar(200)   NULL default NULL  comment '临街状况',linjiezhuangkuang_pj int(11)   NULL default '1'  comment '临街状况评价(1优,2较优,3普通,4较劣,5劣)',shichangzhuanyedu varchar(200)   NULL default NULL  comment '市场专业度',shichangzhuanyedu_pj int(11)   NULL default '1'  comment '市场专业度评价(1高,2普通)',dianmianpeitao varchar(200)   NULL default NULL  comment '店面配套设施',dianmianpeitao_pj int(11)   NULL default '1'  comment '店面配套评价(1好,2较好,3普通,4较差,5差)',duocengzhuzhai_junjia decimal(15,0)   NULL default NULL  comment '多层住宅均价',tiaozhengfudu varchar(100)   NULL default NULL  comment '住宅调整幅度',zhudianmianjunjia decimal(15,0)   NULL default NULL  comment '主街店面均价',dmtiaozhengfudu varchar(100)   NULL default NULL  comment '店面调整幅度',duoceng varchar(100)   NULL default NULL  comment '多层',gaoceng varchar(100)   NULL default NULL  comment '高层',bz text  NULL default NULL  comment '备注',lbsjd varchar(100)   NULL default NULL  comment '经度',lbswd varchar(100)   NULL default NULL  comment '纬度',dizhi text  NULL default NULL  comment '地址',tuwen text  NULL default NULL  comment '图文信息',lbsweizhi varchar(100)   NULL default NULL  comment '地理坐标',lbsaddress varchar(255)   NULL default NULL  comment '地理地址',sort_no int(11) default '0' comment '排列顺序',add_time DATETIME default '0000-00-00 00:00:00' comment '添加时间',last_update  timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP comment '最近更新',last_update2 DATE default '0000-00-00' comment '时间2',tzsy int(11) default 0 comment '停用')engine=MyISAM default charset=utf8 auto_increment=1";
        $create_z = $GLOBALS['db']->query($create_z);
        
        //循环加入索引
        $create_index = "create UNIQUE index loupan_sn on loupan(loupan_sn); ";
        $create_index = $GLOBALS['db']->query($create_index);
        
        //如果有细表建立细表
        

        //----end------
        
    

        //开始增加判断表格是否存在并删除
        $drop = "drop TABLE  if exists daohang";
        $drop = $GLOBALS['db']->query($drop);
        
        $drop = "drop TABLE  if exists daohang_mx";
        $drop = $GLOBALS['db']->query($drop);
        
        //建立主表
        $create_z = "CREATE TABLE IF NOT EXISTS daohang (id int unsigned auto_increment primary key ,daohang_sn varchar(100)   NULL default NULL  comment '导航代码',daohang_name varchar(200)   NULL default NULL  comment '导航名称',url text  NULL default NULL  comment '网址',bz text  NULL default NULL  comment '备注',sort_no int(11) default '0' comment '排列顺序',add_time DATETIME default '0000-00-00 00:00:00' comment '添加时间',last_update  timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP comment '最近更新',last_update2 DATE default '0000-00-00' comment '时间2',tzsy int(11) default 0 comment '停用')engine=MyISAM default charset=utf8 auto_increment=1";
        $create_z = $GLOBALS['db']->query($create_z);
        
        //循环加入索引
        $create_index = "create UNIQUE index daohang_sn on daohang(daohang_sn); ";
        $create_index = $GLOBALS['db']->query($create_index);
        
        //如果有细表建立细表
        

        //----end------
        
    

       
    

        //开始增加判断表格是否存在并删除
        $drop = "drop TABLE  if exists kehuhuifang";
        $drop = $GLOBALS['db']->query($drop);
        
        $drop = "drop TABLE  if exists kehuhuifang_mx";
        $drop = $GLOBALS['db']->query($drop);
        
        //建立主表
        $create_z = "CREATE TABLE IF NOT EXISTS kehuhuifang (id int unsigned auto_increment primary key ,kehuhuifang_sn varchar(100)   NULL default NULL  comment '回访代码',kehu_id int(11)   NULL default NULL  comment '所属客户id',huifang_time datetime  NULL default '0000-00-00 00:00:00'  comment '回访时间',bz text  NULL default NULL  comment '备注',user_name varchar(100)   NULL default NULL  comment '登陆用户',user_id int(11)   NULL default NULL  comment '用户id',sort_no int(11) default '0' comment '排列顺序',add_time DATETIME default '0000-00-00 00:00:00' comment '添加时间',last_update  timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP comment '最近更新',last_update2 DATE default '0000-00-00' comment '时间2',tzsy int(11) default 0 comment '停用')engine=MyISAM default charset=utf8 auto_increment=1";
        $create_z = $GLOBALS['db']->query($create_z);
        
        //循环加入索引
        $create_index = "create UNIQUE index kehuhuifang_sn on kehuhuifang(kehuhuifang_sn); ";
        $create_index = $GLOBALS['db']->query($create_index);
        
        //如果有细表建立细表
        

        //----end------
        
    

        //开始增加判断表格是否存在并删除
        $drop = "drop TABLE  if exists msgsend";
        $drop = $GLOBALS['db']->query($drop);
        
        $drop = "drop TABLE  if exists msgsend_mx";
        $drop = $GLOBALS['db']->query($drop);
        
        //建立主表
        $create_z = "CREATE TABLE IF NOT EXISTS msgsend (id int unsigned auto_increment primary key ,msgsend_sn varchar(100)   NULL default NULL  comment '发送代码',user_name varchar(100)   NULL default NULL  comment '操作人',send_time datetime  NULL default '0000-00-00 00:00:00'  comment '发送时间',msgsend_time datetime  NULL default '0000-00-00 00:00:00'  comment '添加时间',bz text  NULL default NULL  comment '备注',fasongleixing int(11)   NULL default '1'  comment '发送类型(1邮件,2短信)',kehu_id int(11)   NULL default NULL  comment '客户id',is_send int(11)   NULL default '0'  comment '是否发送',error_msg text  NULL default NULL  comment '错误信息',sort_no int(11) default '0' comment '排列顺序',add_time DATETIME default '0000-00-00 00:00:00' comment '添加时间',last_update  timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP comment '最近更新',last_update2 DATE default '0000-00-00' comment '时间2',tzsy int(11) default 0 comment '停用')engine=MyISAM default charset=utf8 auto_increment=1";
        $create_z = $GLOBALS['db']->query($create_z);
        
        //循环加入索引
        $create_index = "create UNIQUE index msgsend_sn on msgsend(msgsend_sn); ";
        $create_index = $GLOBALS['db']->query($create_index);
        
        //如果有细表建立细表
        

        //----end------
        
    

       
    

        //开始增加判断表格是否存在并删除
        $drop = "drop TABLE  if exists jinrong";
        $drop = $GLOBALS['db']->query($drop);
        
        $drop = "drop TABLE  if exists jinrong_mx";
        $drop = $GLOBALS['db']->query($drop);
        
        //建立主表
        $create_z = "CREATE TABLE IF NOT EXISTS jinrong (id int unsigned auto_increment primary key ,jinrong_sn varchar(100)   NULL default NULL  comment '金融代码',jinrong_name varchar(200)   NULL default NULL  comment '产品名称',bz text  NULL default NULL  comment '备注',yinhang_id int(11)   NULL default NULL  comment '银行id',gongsi_id int(11)   NULL default NULL  comment '公司id',leixing int(11)   NULL default '6'  comment '金融类型',sort_no int(11) default '0' comment '排列顺序',add_time DATETIME default '0000-00-00 00:00:00' comment '添加时间',last_update  timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP comment '最近更新',last_update2 DATE default '0000-00-00' comment '时间2',tzsy int(11) default 0 comment '停用')engine=MyISAM default charset=utf8 auto_increment=1";
        $create_z = $GLOBALS['db']->query($create_z);
        
        //循环加入索引
        $create_index = "create UNIQUE index jinrong_sn on jinrong(jinrong_sn); ";
        $create_index = $GLOBALS['db']->query($create_index);
        
        //如果有细表建立细表
        

        //----end------
        
    

        //开始增加判断表格是否存在并删除
        $drop = "drop TABLE  if exists jinrongbanli";
        $drop = $GLOBALS['db']->query($drop);
        
        $drop = "drop TABLE  if exists jinrongbanli_mx";
        $drop = $GLOBALS['db']->query($drop);
        
        //建立主表
        $create_z = "CREATE TABLE IF NOT EXISTS jinrongbanli (id int unsigned auto_increment primary key ,jinrongbanli_sn varchar(100)   NULL default NULL  comment '业务代码',jinrongbanli_name varchar(100)   NULL default NULL  comment '业务名称',kehu_id int(11)   NULL default NULL  comment '客户id',banli_time datetime  NULL default '0000-00-00 00:00:00'  comment '办理时间',jinrong_id int(11)   NULL default NULL  comment '金融产品id',sort_no int(11) default '0' comment '排列顺序',add_time DATETIME default '0000-00-00 00:00:00' comment '添加时间',last_update  timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP comment '最近更新',last_update2 DATE default '0000-00-00' comment '时间2',tzsy int(11) default 0 comment '停用')engine=MyISAM default charset=utf8 auto_increment=1";
        $create_z = $GLOBALS['db']->query($create_z);
        
        //循环加入索引
        $create_index = "create UNIQUE index jinrongbanli_sn on jinrongbanli(jinrongbanli_sn); ";
        $create_index = $GLOBALS['db']->query($create_index);
        
        //如果有细表建立细表
        

        //----end------
        
    

        //开始增加判断表格是否存在并删除
        $drop = "drop TABLE  if exists gonggao";
        $drop = $GLOBALS['db']->query($drop);
        
        $drop = "drop TABLE  if exists gonggao_mx";
        $drop = $GLOBALS['db']->query($drop);
        
        //建立主表
        $create_z = "CREATE TABLE IF NOT EXISTS gonggao (id int unsigned auto_increment primary key ,gonggao_sn varchar(100)   NULL default NULL  comment '公告代码',gonggao_name varchar(100)   NULL default NULL  comment '公告名称',bz text  NULL default NULL  comment '备注',leixing int(11)   NULL default '1'  comment '类型(1系统公告2日常公告)',sort_no int(11) default '0' comment '排列顺序',add_time DATETIME default '0000-00-00 00:00:00' comment '添加时间',last_update  timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP comment '最近更新',last_update2 DATE default '0000-00-00' comment '时间2',tzsy int(11) default 0 comment '停用')engine=MyISAM default charset=utf8 auto_increment=1";
        $create_z = $GLOBALS['db']->query($create_z);
        
        //循环加入索引
        $create_index = "create UNIQUE index gonggao_sn on gonggao(gonggao_sn); ";
        $create_index = $GLOBALS['db']->query($create_index);
        
        //如果有细表建立细表
        

        //----end------
        
           
       
       // unlink('tbcreate.php'); 

}




?>