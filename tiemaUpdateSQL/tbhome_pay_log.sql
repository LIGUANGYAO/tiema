/*
Navicat MySQL Data Transfer

Source Server         : 鞋服通
Source Server Version : 50169
Source Host           : 127.0.0.1:3306
Source Database       : lyjy

Target Server Type    : MYSQL
Target Server Version : 50169
File Encoding         : 65001

Date: 2016-02-05 12:36:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tbhome_pay_log
-- ----------------------------
DROP TABLE IF EXISTS `tbhome_pay_log`;
CREATE TABLE `tbhome_pay_log` (
  `id` int(11) NOT NULL,
  `partner_trade_no` varchar(255) DEFAULT NULL,
  `payment_time` varchar(50) DEFAULT NULL,
  `truename` varchar(20) DEFAULT NULL,
  `amount` decimal(9,2) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL,
  `mch_appid` varchar(50) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbhome_pay_log
-- ----------------------------
