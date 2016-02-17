/*
Navicat MySQL Data Transfer

Source Server         : localPHPStudy
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : antdream

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2016-02-05 01:21:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tbhome_wx_gh
-- ----------------------------
DROP TABLE IF EXISTS `tbhome_wx_gh`;
CREATE TABLE `tbhome_wx_gh` (
  `id` int(11) NOT NULL,
  `appid` varchar(255) NOT NULL,
  `mchid` varchar(255) NOT NULL,
  `appkey` varchar(255) NOT NULL,
  `mchkey` varchar(255) NOT NULL,
  `originalid` varchar(255) NOT NULL,
  `login_email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbhome_wx_gh
-- ----------------------------
INSERT INTO `tbhome_wx_gh` VALUES ('1', 'wx9bd85e016d66c1eakk', 'tretteykk', '54356c820df3881da49edf6756f51cdfkk', 'mckeykk', '', '');
