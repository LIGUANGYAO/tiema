/*
Navicat MySQL Data Transfer

Source Server         : localPHPStudy
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : antdream

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2016-02-05 01:22:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tbhome_wx_users
-- ----------------------------
DROP TABLE IF EXISTS `tbhome_wx_users`;
CREATE TABLE `tbhome_wx_users` (
  `id` int(11) NOT NULL,
  `openid` varchar(50) NOT NULL,
  `appid` varchar(50) NOT NULL,
  `originalid` varchar(50) NOT NULL,
  `total_income` decimal(9,2) NOT NULL,
  `balance` decimal(9,2) NOT NULL,
  `withdraw` decimal(9,2) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `truename` varchar(50) NOT NULL,
  `nationalid` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `status` smallint(10) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `remarkname` varchar(50) NOT NULL,
  `qq` int(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `vin` varchar(50) NOT NULL,
  `plateid` varchar(20) NOT NULL,
  `up_openid` varchar(30) NOT NULL,
  `is_up` tinyint(1) NOT NULL,
  `city` varchar(20) NOT NULL,
  `province` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `headimgurl` varchar(255) NOT NULL,
  `nickname` varchar(30) NOT NULL,
  `sex` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbhome_wx_users
-- ----------------------------
