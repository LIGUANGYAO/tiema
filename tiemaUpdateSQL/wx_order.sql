/*
Navicat MySQL Data Transfer

Source Server         : localPHPStudy
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : antdream

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2016-02-05 01:20:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for wx_order
-- ----------------------------
DROP TABLE IF EXISTS `wx_order`;
CREATE TABLE `wx_order` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `appid` varchar(20) NOT NULL DEFAULT 'wx',
  `originalid` varchar(20) NOT NULL DEFAULT 'gh_xx' COMMENT '公众号原始id',
  `order_sn` varchar(30) DEFAULT NULL,
  `order_name` varchar(50) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `sfz` varchar(20) DEFAULT NULL COMMENT '身份证',
  `p_openid` varchar(50) DEFAULT NULL COMMENT '推荐人openid',
  `p_name` varchar(20) DEFAULT NULL COMMENT '推荐人昵称',
  `tel` varchar(50) DEFAULT NULL COMMENT '联系电话',
  `sbdm` varchar(50) DEFAULT NULL COMMENT '车辆识别代码后四位',
  `car_no` varchar(10) DEFAULT NULL COMMENT '车牌号',
  `endtime` date DEFAULT NULL COMMENT '到期时间',
  `ccx` int(10) DEFAULT NULL COMMENT '船险车',
  `qzx` int(10) DEFAULT NULL COMMENT '强制险',
  `syx` int(10) DEFAULT NULL COMMENT '商业险',
  `sjsyx` int(10) DEFAULT NULL COMMENT '实缴商业险',
  `bz` text,
  `tzsy` int(11) DEFAULT '0' COMMENT '停止使用',
  `is_pay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已付款. 0未付款，1已付清',
  `is_split` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分利状态。0未分成，1已分',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态。0未审核，1已审核',
  `sort_no` int(20) DEFAULT '0',
  `add_time` datetime DEFAULT NULL,
  `createtime` int(11) NOT NULL,
  `last_update` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `last_update_2` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `text_sn` (`order_sn`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=186;

-- ----------------------------
-- Records of wx_order
-- ----------------------------
INSERT INTO `wx_order` VALUES ('32', 'wx', 'gh_xx', '2016241454574076063', '订单名', 'openidexample', '姓名22', '身份证3333', 'pppopenidxx', '上级昵称看看', '1588864646', '5464识别码', '车牌号99', '2016-02-09', '45', '848', '485', '555', 'pppopenidxx', '1', '1', '1', '0', '1', '2016-02-04 16:22:42', '0', '2016-02-05 01:20:04', '2016-02-04');
