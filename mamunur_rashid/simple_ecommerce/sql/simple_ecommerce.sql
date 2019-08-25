/*
Navicat MySQL Data Transfer

Source Server         : localhost_laragon
Source Server Version : 50724
Source Host           : localhost:3307
Source Database       : simple_ecommerce

Target Server Type    : MYSQL
Target Server Version : 50724
File Encoding         : 65001

Date: 2019-08-19 11:12:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES ('1', 'sdfsd', 'DFSDFSD');
INSERT INTO `categories` VALUES ('2', 'sdfsd', 'DFSDFSD');
INSERT INTO `categories` VALUES ('3', 'SDFSD', 'SDFSD');
INSERT INTO `categories` VALUES ('4', 'FGDF', 'DFGDF');
INSERT INTO `categories` VALUES ('5', 'DFGDF', 'GDFG');
INSERT INTO `categories` VALUES ('6', 'FGDFG', 'DFGD');
INSERT INTO `categories` VALUES ('7', 'FGDFG', 'DFGD');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'nurhodelta', 'neovic');
INSERT INTO `users` VALUES ('2', 'gemalyn', 'cepe');
INSERT INTO `users` VALUES ('3', 'mosarraf', '123456');
