/*
Navicat MySQL Data Transfer

Source Server         : localPHPStudy
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : antdream

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2016-02-05 01:22:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tbhome_users_insurance
-- ----------------------------
DROP TABLE IF EXISTS `tbhome_users_insurance`;
CREATE TABLE `tbhome_users_insurance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appid` varchar(20) NOT NULL DEFAULT 'wx',
  `originalid` varchar(20) NOT NULL DEFAULT 'gh_xx' COMMENT '公众号原始id',
  `opneid` varchar(30) NOT NULL,
  `up_openid` varchar(50) NOT NULL,
  `up_nickname` varchar(50) NOT NULL,
  `orderid` varchar(50) NOT NULL,
  `truename` varchar(20) NOT NULL,
  `nationalid` varchar(20) NOT NULL COMMENT '居民身份证',
  `mobile` varchar(20) NOT NULL,
  `vin` varchar(30) NOT NULL COMMENT '车辆识别码',
  `plateid` varchar(10) NOT NULL COMMENT '车牌号',
  `vehicle_insur` decimal(9,0) NOT NULL COMMENT '车险',
  `traffic_insur` decimal(9,0) NOT NULL COMMENT '交强险',
  `business_insur` decimal(9,0) NOT NULL COMMENT '商业险',
  `business_insur_ispay` decimal(9,0) NOT NULL,
  `duetime` int(11) NOT NULL DEFAULT '0' COMMENT '到期时间',
  `is_pay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已付款. 0未付款，1已付清',
  `is_split` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分利状态。0未分成，1已分',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态。0未审核，1已审核',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `createtime` int(11) NOT NULL,
  `updatetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `openid` (`opneid`),
  KEY `mobile` (`mobile`),
  KEY `orderid` (`orderid`),
  KEY `is_split` (`is_split`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户保险信息';

-- ----------------------------
-- Records of tbhome_users_insurance
-- ----------------------------
INSERT INTO `tbhome_users_insurance` VALUES ('1', 'wx', 'gh_xx', 'lkdfjalksdjfj', '', '', '', '吴汉青', '350502155444', '15980016080', '', '', '0', '0', '0', '0', '0', '1', '0', '1', '', '0', '2016-02-04 14:22:49');
