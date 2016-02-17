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
        $create_z = "CREATE TABLE IF NOT EXISTS kehu (id int unsigned auto_increment primary key ,kehu_sn varchar(100)   NULL default NULL  comment '客户代码',kehu_name varchar(100)   NULL default NULL  comment '客户名称',tel varchar(20)   NULL default NULL  comment '固定电话',mobile int(15)   NULL default '0'  comment '移动电话',bz text  NULL default NULL  comment '客户备注',lbsjd varchar(20)   NULL default NULL  comment '经度',lbswd varchar(20)   NULL default NULL  comment '纬度',province int(11)   NULL default NULL  comment '省份',city int(11)   NULL default NULL  comment '市',dis int(11)   NULL default NULL  comment '区',khlx int(11)   NULL default '0'  comment '客户类型(0普通客户,1vip客户,2潜在客户,3失效客户)',sort_no int(11) default '0' comment '排列顺序',add_time DATETIME default '0000-00-00 00:00:00' comment '添加时间',last_update  timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP comment '最近更新',last_update2 DATE default '0000-00-00' comment '时间2',tzsy int(11) default 0 comment '停用')engine=MyISAM default charset=utf8 auto_increment=1";
        $create_z = $GLOBALS['db']->query($create_z);
        
        //循环加入索引
        $create_index = "create UNIQUE index kehu_sn on kehu(kehu_sn); ";
        $create_index = $GLOBALS['db']->query($create_index);
        
        //如果有细表建立细表
        
        //生成测试数据
        for($k=0;$k<50;$k++)
        {
        $in = "insert into  kehu(kehu_sn) values ('测试".($k+1)."')";
        $in = $GLOBALS['db']->query($in);
        }
        

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
        
           
       
       // unlink('tbcreate.php'); 

}




?>