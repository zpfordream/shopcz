/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : shopcz

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-12-04 22:38:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cz_address
-- ----------------------------
DROP TABLE IF EXISTS `cz_address`;
CREATE TABLE `cz_address` (
  `address_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '地址编号',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '地址所属用户ID',
  `consignee` varchar(60) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `province` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '省份，保存是ID',
  `city` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '市',
  `district` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '区',
  `street` varchar(100) NOT NULL DEFAULT '' COMMENT '街道地址',
  `zipcode` varchar(10) NOT NULL DEFAULT '' COMMENT '邮政编码',
  `telephone` varchar(20) NOT NULL DEFAULT '' COMMENT '电话',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '移动电话',
  PRIMARY KEY (`address_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cz_address
-- ----------------------------

-- ----------------------------
-- Table structure for cz_admin
-- ----------------------------
DROP TABLE IF EXISTS `cz_admin`;
CREATE TABLE `cz_admin` (
  `admin_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员编号',
  `admin_name` varchar(30) NOT NULL DEFAULT '' COMMENT '管理员名称',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员邮箱',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cz_admin
-- ----------------------------
INSERT INTO `cz_admin` VALUES ('1', 'user', 'pass', '', '0');

-- ----------------------------
-- Table structure for cz_admin_nav
-- ----------------------------
DROP TABLE IF EXISTS `cz_admin_nav`;
CREATE TABLE `cz_admin_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mvc` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cz_admin_nav
-- ----------------------------
INSERT INTO `cz_admin_nav` VALUES ('3', '2', '商品分类', 'Admin/Category/index');
INSERT INTO `cz_admin_nav` VALUES ('2', '0', '商品管理', 'Admin/ShowNav/');
INSERT INTO `cz_admin_nav` VALUES ('4', '2', '商品类型', 'Admin/type/index');
INSERT INTO `cz_admin_nav` VALUES ('5', '2', '商品列表', 'Admin/goods/index');
INSERT INTO `cz_admin_nav` VALUES ('6', '2', '添加新商品', 'Admin/goods/add');
INSERT INTO `cz_admin_nav` VALUES ('7', '0', '权限控制', 'Admin/ShowNav/');
INSERT INTO `cz_admin_nav` VALUES ('8', '7', '权限管理', 'Admin/Rule/index');
INSERT INTO `cz_admin_nav` VALUES ('9', '7', '用户组管理', 'Admin/Group/index');
INSERT INTO `cz_admin_nav` VALUES ('10', '7', '管理员列表', 'Admin/User/index');
INSERT INTO `cz_admin_nav` VALUES ('11', '0', '配置管理', 'admin/nav');
INSERT INTO `cz_admin_nav` VALUES ('12', '11', '导航列表', 'admin/nav/index');

-- ----------------------------
-- Table structure for cz_attribute
-- ----------------------------
DROP TABLE IF EXISTS `cz_attribute`;
CREATE TABLE `cz_attribute` (
  `attr_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品属性ID',
  `attr_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品属性名称',
  `type_id` smallint(6) NOT NULL DEFAULT '0' COMMENT '商品属性所属类型ID',
  `attr_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '属性是否可选 0 为唯一，1为单选，2为多选',
  `attr_input_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '属性录入方式 0为手工录入，1为从列表中选择，2为文本域',
  `attr_value` text COMMENT '属性的值',
  `sort_order` tinyint(4) NOT NULL DEFAULT '50' COMMENT '属性排序依据',
  PRIMARY KEY (`attr_id`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cz_attribute
-- ----------------------------
INSERT INTO `cz_attribute` VALUES ('1', '作者', '1', '0', '0', '', '50');
INSERT INTO `cz_attribute` VALUES ('2', '观看人数', '1', '1', '1', '1人\r\n2人\r\n3人', '50');
INSERT INTO `cz_attribute` VALUES ('3', '观后感', '1', '0', '2', '', '50');
INSERT INTO `cz_attribute` VALUES ('4', '持有人', '3', '0', '0', '', '50');
INSERT INTO `cz_attribute` VALUES ('5', '大小', '3', '0', '1', '大\r\n中\r\n小', '50');

-- ----------------------------
-- Table structure for cz_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `cz_auth_group`;
CREATE TABLE `cz_auth_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(10) CHARACTER SET utf8 NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `rules` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cz_auth_group
-- ----------------------------
INSERT INTO `cz_auth_group` VALUES ('1', '全局管理员', '1', null);
INSERT INTO `cz_auth_group` VALUES ('2', '商品全局管理', '1', null);
INSERT INTO `cz_auth_group` VALUES ('3', '商品添加管理', '1', null);

-- ----------------------------
-- Table structure for cz_auth_group_id
-- ----------------------------
DROP TABLE IF EXISTS `cz_auth_group_id`;
CREATE TABLE `cz_auth_group_id` (
  `uid` int(10) unsigned NOT NULL,
  `groud_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cz_auth_group_id
-- ----------------------------
INSERT INTO `cz_auth_group_id` VALUES ('13', '1');
INSERT INTO `cz_auth_group_id` VALUES ('13', '2');
INSERT INTO `cz_auth_group_id` VALUES ('13', '3');
INSERT INTO `cz_auth_group_id` VALUES ('14', '2');
INSERT INTO `cz_auth_group_id` VALUES ('14', '3');
INSERT INTO `cz_auth_group_id` VALUES ('15', '1');
INSERT INTO `cz_auth_group_id` VALUES ('12', '1');
INSERT INTO `cz_auth_group_id` VALUES ('12', '2');
INSERT INTO `cz_auth_group_id` VALUES ('12', '3');

-- ----------------------------
-- Table structure for cz_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `cz_auth_rule`;
CREATE TABLE `cz_auth_rule` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 NOT NULL,
  `title` varchar(20) CHARACTER SET utf8 NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cz_auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for cz_brand
-- ----------------------------
DROP TABLE IF EXISTS `cz_brand`;
CREATE TABLE `cz_brand` (
  `brand_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品品牌ID',
  `brand_name` varchar(30) NOT NULL DEFAULT '' COMMENT '商品品牌名称',
  `brand_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '商品品牌描述',
  `url` varchar(100) NOT NULL DEFAULT '' COMMENT '商品品牌网址',
  `logo` varchar(50) NOT NULL DEFAULT '' COMMENT '品牌logo',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '50' COMMENT '商品品牌排序依据',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示，默认显示',
  PRIMARY KEY (`brand_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cz_brand
-- ----------------------------

-- ----------------------------
-- Table structure for cz_cart
-- ----------------------------
DROP TABLE IF EXISTS `cz_cart`;
CREATE TABLE `cz_cart` (
  `cart_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '购物车ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `goods_name` varchar(100) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_img` varchar(50) NOT NULL DEFAULT '' COMMENT '商品图片',
  `goods_attr` varchar(255) NOT NULL DEFAULT '' COMMENT '商品属性',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '商品数量',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价格',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成交价格',
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '小计',
  PRIMARY KEY (`cart_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cz_cart
-- ----------------------------

-- ----------------------------
-- Table structure for cz_category
-- ----------------------------
DROP TABLE IF EXISTS `cz_category`;
CREATE TABLE `cz_category` (
  `cat_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品类别ID',
  `cat_name` varchar(30) NOT NULL DEFAULT '' COMMENT '商品类别名称',
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品类别父ID',
  `cat_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '商品类别描述',
  `sort_order` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序依据',
  `unit` varchar(15) NOT NULL DEFAULT '' COMMENT '单位',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示，默认显示',
  PRIMARY KEY (`cat_id`),
  KEY `pid` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cz_category
-- ----------------------------
INSERT INTO `cz_category` VALUES ('1', '书', '0', '书', '50', '1', '1');
INSERT INTO `cz_category` VALUES ('2', '衣服', '0', '衣服包含很多', '50', '', '1');
INSERT INTO `cz_category` VALUES ('3', '鞋', '0', '鞋包括很多男鞋，女鞋', '50', '1', '1');
INSERT INTO `cz_category` VALUES ('4', '男人衣服', '2', '', '50', '1', '1');
INSERT INTO `cz_category` VALUES ('5', '女人衣服', '2', '', '50', '', '1');
INSERT INTO `cz_category` VALUES ('6', '衬衫', '4', '', '50', '', '1');
INSERT INTO `cz_category` VALUES ('7', '牛仔裤', '4', '', '50', '', '1');

-- ----------------------------
-- Table structure for cz_galary
-- ----------------------------
DROP TABLE IF EXISTS `cz_galary`;
CREATE TABLE `cz_galary` (
  `img_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '图片编号',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `img_url` varchar(50) NOT NULL DEFAULT '' COMMENT '图片URL',
  `thumb_url` varchar(50) NOT NULL DEFAULT '' COMMENT '缩略图URL',
  `img_desc` varchar(50) NOT NULL DEFAULT '' COMMENT '图片描述',
  PRIMARY KEY (`img_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cz_galary
-- ----------------------------

-- ----------------------------
-- Table structure for cz_goods
-- ----------------------------
DROP TABLE IF EXISTS `cz_goods`;
CREATE TABLE `cz_goods` (
  `goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品ID',
  `goods_sn` varchar(30) NOT NULL DEFAULT '' COMMENT '商品货号',
  `goods_name` varchar(100) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_brief` varchar(255) NOT NULL DEFAULT '' COMMENT '商品简单描述',
  `goods_desc` text COMMENT '商品详情',
  `cat_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品所属类别ID',
  `brand_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品所属品牌ID',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `shop_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '本店价格',
  `promote_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价格',
  `promote_start_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '促销起始时间',
  `promote_end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '促销截止时间',
  `goods_img` varchar(50) NOT NULL DEFAULT '' COMMENT '商品图片',
  `goods_thumb` varchar(50) NOT NULL DEFAULT '' COMMENT '商品缩略图',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品库存',
  `click_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击次数',
  `type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品类型ID',
  `is_promote` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否促销，默认为0不促销',
  `is_best` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否精品,默认为0',
  `is_new` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否新品，默认为0',
  `is_hot` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否热卖,默认为0',
  `is_onsale` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否上架,默认为1',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`goods_id`),
  KEY `cat_id` (`cat_id`),
  KEY `brand_id` (`brand_id`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cz_goods
-- ----------------------------
INSERT INTO `cz_goods` VALUES ('1', 'a1', 'a1', '', '', '6', '1', '3612.00', '3010.00', '0.00', '1243814400', '1417305600', '20171121/201711211540405a1448f8968a0.jpg', '', '0', '0', '0', '0', '1', '1', '1', '1', '1511278840');
INSERT INTO `cz_goods` VALUES ('2', 'a1', 'a1', '', '', '4', '1', '3612.00', '3010.00', '0.00', '1243814400', '1417305600', '20171121/201711211541495a14493df1368.jpg', '', '0', '0', '0', '0', '1', '1', '1', '1', '1511278909');
INSERT INTO `cz_goods` VALUES ('3', 'a1', 'a1', '', '', '6', '1', '3612.00', '3010.00', '0.00', '1243814400', '1417305600', '20171121/201711211551025a144b66df57a.jpg', '', '0', '0', '0', '0', '1', '1', '1', '1', '1511279462');
INSERT INTO `cz_goods` VALUES ('4', 'a4', 'a4', '', '', '4', '2', '3612.00', '3010.00', '0.00', '1243814400', '1417305600', '20171122/201711221412295a1585cd47bc0.png', '', '0', '0', '0', '0', '1', '1', '1', '1', '1511359949');

-- ----------------------------
-- Table structure for cz_goods_attr
-- ----------------------------
DROP TABLE IF EXISTS `cz_goods_attr`;
CREATE TABLE `cz_goods_attr` (
  `goods_attr_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `attr_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '属性ID',
  `attr_value` varchar(255) NOT NULL DEFAULT '' COMMENT '属性值',
  `attr_price` varchar(10) DEFAULT '0.00' COMMENT '属性价格',
  PRIMARY KEY (`goods_attr_id`),
  KEY `goods_id` (`goods_id`),
  KEY `attr_id` (`attr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cz_goods_attr
-- ----------------------------
INSERT INTO `cz_goods_attr` VALUES ('1', '1', '1', 'a1', '0.00');
INSERT INTO `cz_goods_attr` VALUES ('2', '1', '2', '1人', '0.00');
INSERT INTO `cz_goods_attr` VALUES ('3', '2', '1', '1', '0.00');
INSERT INTO `cz_goods_attr` VALUES ('4', '2', '2', '1人', '0.00');
INSERT INTO `cz_goods_attr` VALUES ('5', '3', '1', 'a1', '0');
INSERT INTO `cz_goods_attr` VALUES ('6', '3', '2', '1人', '0');
INSERT INTO `cz_goods_attr` VALUES ('7', '3', '3', '1', '');
INSERT INTO `cz_goods_attr` VALUES ('8', '4', '1', 'a4', '0');
INSERT INTO `cz_goods_attr` VALUES ('9', '4', '2', '2人', '0');
INSERT INTO `cz_goods_attr` VALUES ('10', '4', '3', 'aaaaa', '');

-- ----------------------------
-- Table structure for cz_goods_type
-- ----------------------------
DROP TABLE IF EXISTS `cz_goods_type`;
CREATE TABLE `cz_goods_type` (
  `type_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品类型ID',
  `type_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品类型名称',
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cz_goods_type
-- ----------------------------
INSERT INTO `cz_goods_type` VALUES ('1', '电影');
INSERT INTO `cz_goods_type` VALUES ('2', '类型1');
INSERT INTO `cz_goods_type` VALUES ('3', '手机');

-- ----------------------------
-- Table structure for cz_region
-- ----------------------------
DROP TABLE IF EXISTS `cz_region`;
CREATE TABLE `cz_region` (
  `region_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '地区ID',
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `region_name` varchar(30) NOT NULL DEFAULT '' COMMENT '地区名称',
  `region_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '地区类型 1 省份 2 市 3 区(县)',
  PRIMARY KEY (`region_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cz_region
-- ----------------------------

-- ----------------------------
-- Table structure for cz_user
-- ----------------------------
DROP TABLE IF EXISTS `cz_user`;
CREATE TABLE `cz_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户编号',
  `user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '用户密码,md5加密',
  `email` varchar(30) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `reg_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `last_login_ip` varchar(20) DEFAULT NULL,
  `last_login_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of cz_user
-- ----------------------------
INSERT INTO `cz_user` VALUES ('1', 'user', 'pass', 'user@qq.com', '1', '2017-12-03 12:50:18', null, '2017-12-03 12:50:18');
INSERT INTO `cz_user` VALUES ('15', 'user3', 'pass3', 'user3@qq.com', '1', null, null, null);
INSERT INTO `cz_user` VALUES ('14', 'user2', 'pass2', 'user2@qq.com', '1', null, null, null);
INSERT INTO `cz_user` VALUES ('13', 'user1', 'pass1', 'user1@qq.com', '1', null, null, null);
