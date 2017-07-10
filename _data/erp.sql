/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : erp

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-07-07 11:02:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `t_admin`
-- ----------------------------
DROP TABLE IF EXISTS `t_admin`;
CREATE TABLE `t_admin` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `c_login_random` char(4) NOT NULL DEFAULT '' COMMENT '登录的随机密码',
  `c_mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `c_password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `c_auth_key` char(32) NOT NULL DEFAULT '' COMMENT 'cookie用户认证',
  `c_access_token` char(43) NOT NULL DEFAULT '' COMMENT 'api 通过access_token参数登录',
  `c_admin_name` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `c_email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1正常 2无效',
  `c_role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色ID',
  `c_login_total` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `c_last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `c_last_ip` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`),
  UNIQUE KEY `c_mobile` (`c_mobile`),
  UNIQUE KEY `c_admin_name` (`c_admin_name`),
  UNIQUE KEY `c_email` (`c_email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of t_admin
-- ----------------------------
INSERT INTO `t_admin` VALUES ('10', 'Km53', '18016011672', 'b4450d1817135f363bea405e95655326', 'DP_BVeTGp8UGVT2b_r4Vm0xt_xIYnDxq', 'admin', '197442445@qq.com', '1', '1', '82', '1494809212', '2130706433', '1487044236', '2017-05-15 09:01:34');

-- ----------------------------
-- Table structure for `t_admin_login_log`
-- ----------------------------
DROP TABLE IF EXISTS `t_admin_login_log`;
CREATE TABLE `t_admin_login_log` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_login_name` varchar(20) NOT NULL DEFAULT '' COMMENT '登录名',
  `c_login_password` varchar(20) NOT NULL DEFAULT '' COMMENT '登录密码',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1成功 2失败',
  `c_login_ip` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员登录日志表';

-- ----------------------------
-- Records of t_admin_login_log
-- ----------------------------

-- ----------------------------
-- Table structure for `t_admin_operation_log`
-- ----------------------------
DROP TABLE IF EXISTS `t_admin_operation_log`;
CREATE TABLE `t_admin_operation_log` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_admin_name` varchar(20) NOT NULL DEFAULT '' COMMENT '管理员用户名',
  `c_route` varchar(100) NOT NULL DEFAULT '' COMMENT '路由',
  `c_data_before` text COMMENT '更新或删除之前的数据',
  `c_data_add` text COMMENT '新增的数据',
  `c_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '操作类型 1新增 2编辑 3删除',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 1成功 2失败',
  `c_admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `c_object_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '操作的对象ID',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员操作日志表';

-- ----------------------------
-- Records of t_admin_operation_log
-- ----------------------------

-- ----------------------------
-- Table structure for `t_admin_role`
-- ----------------------------
DROP TABLE IF EXISTS `t_admin_role`;
CREATE TABLE `t_admin_role` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `c_title` varchar(50) NOT NULL COMMENT '角色名称',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1正常 2无效',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员角色';

-- ----------------------------
-- Records of t_admin_role
-- ----------------------------
INSERT INTO `t_admin_role` VALUES ('1', '超级管理员', '1', '0', '0', '2017-04-11 16:07:21');

-- ----------------------------
-- Table structure for `t_admin_role_node`
-- ----------------------------
DROP TABLE IF EXISTS `t_admin_role_node`;
CREATE TABLE `t_admin_role_node` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '节点ID',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1正常 2无效',
  `c_role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色ID',
  `c_route_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '路由ID',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`),
  KEY `c_role_id` (`c_role_id`,`c_route_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员角色对应的权限节点';

-- ----------------------------
-- Records of t_admin_role_node
-- ----------------------------

-- ----------------------------
-- Table structure for `t_admin_route`
-- ----------------------------
DROP TABLE IF EXISTS `t_admin_route`;
CREATE TABLE `t_admin_route` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_title` varchar(50) NOT NULL COMMENT '路由名称',
  `c_route` varchar(50) NOT NULL DEFAULT '' COMMENT '路由地址',
  `c_icon` varchar(50) NOT NULL DEFAULT '' COMMENT '图标',
  `c_parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级类别',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '状态 1正常 2无效',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7309 DEFAULT CHARSET=utf8 COMMENT='权限路由表';

-- ----------------------------
-- Records of t_admin_route
-- ----------------------------
INSERT INTO `t_admin_route` VALUES ('1', '商品', 'goods/index', 'heart', '0', '9', '1', '1484882155', '2017-04-14 15:44:02');
INSERT INTO `t_admin_route` VALUES ('2', '用户', 'user/index', 'user', '0', '8', '1', '1484882155', '2017-04-14 15:44:04');
INSERT INTO `t_admin_route` VALUES ('3', '订单', 'order/index', 'th', '0', '7', '1', '1436167620', '2017-04-14 15:44:30');
INSERT INTO `t_admin_route` VALUES ('4', '营销', 'market-activity/index', 'bullhorn', '0', '6', '1', '1436167620', '2017-04-14 15:44:43');
INSERT INTO `t_admin_route` VALUES ('5', '统计', 'market-statistics/register', 'calendar', '0', '5', '1', '1436167620', '2017-04-14 15:45:34');
INSERT INTO `t_admin_route` VALUES ('6', '系统', 'site/index', 'cog', '0', '4', '1', '1443409950', '2017-04-14 19:08:46');
INSERT INTO `t_admin_route` VALUES ('7', '工具', 'content/index', 'wrench', '0', '3', '1', '1443409950', '2017-04-14 15:45:52');
INSERT INTO `t_admin_route` VALUES ('10', '商品管理', '', 'heart', '1', '9', '1', '1484882155', '2017-04-14 15:45:54');
INSERT INTO `t_admin_route` VALUES ('11', '商品类别', '', 'folder-open', '1', '8', '1', '1484882155', '2017-04-14 15:46:06');
INSERT INTO `t_admin_route` VALUES ('12', '商品品牌', '', 'globe', '1', '7', '1', '1436167620', '2017-04-14 15:46:15');
INSERT INTO `t_admin_route` VALUES ('13', '商品模型', '', 'road', '1', '6', '1', '1436167620', '2017-04-17 10:17:32');
INSERT INTO `t_admin_route` VALUES ('14', '商品搜索', '', 'search', '1', '5', '1', '1436167620', '2017-04-14 15:46:18');
INSERT INTO `t_admin_route` VALUES ('20', '用户管理', '', 'user', '2', '9', '1', '1484882155', '2017-04-14 15:46:20');
INSERT INTO `t_admin_route` VALUES ('21', '商户管理', '', 'user', '2', '8', '1', '1484882155', '2017-04-19 10:54:06');
INSERT INTO `t_admin_route` VALUES ('22', '网盟管理', '', 'user', '2', '7', '1', '1436167620', '2017-04-19 10:55:31');
INSERT INTO `t_admin_route` VALUES ('23', '信息处理', '', 'book', '2', '6', '1', '1436167620', '2017-04-19 10:55:11');
INSERT INTO `t_admin_route` VALUES ('30', '订单管理', '', '', '3', '9', '1', '1484882155', '2017-04-14 15:47:04');
INSERT INTO `t_admin_route` VALUES ('32', '发货地址', '', '', '32', '7', '1', '1436167620', '2017-03-09 22:12:52');
INSERT INTO `t_admin_route` VALUES ('40', '促销活动', '', '', '4', '9', '1', '1484882155', '2017-04-14 15:47:07');
INSERT INTO `t_admin_route` VALUES ('41', '营销活动', '', '', '4', '8', '1', '1484882155', '2017-04-14 15:47:08');
INSERT INTO `t_admin_route` VALUES ('42', '代金券管理', '', '', '4', '7', '1', '1436167620', '2016-09-19 13:52:59');
INSERT INTO `t_admin_route` VALUES ('50', '基础数据统计', '', '', '5', '9', '1', '1484882155', '2017-04-14 15:47:11');
INSERT INTO `t_admin_route` VALUES ('51', '日志操作记录', '', 'calendar', '5', '8', '1', '1484882155', '2017-04-14 15:47:15');
INSERT INTO `t_admin_route` VALUES ('52', '商户数据统计', '', '', '5', '7', '1', '1436167620', '2016-09-19 13:52:59');
INSERT INTO `t_admin_route` VALUES ('53', '网盟数据统计', '', '', '5', '6', '1', '1436167620', '2016-09-19 13:52:59');
INSERT INTO `t_admin_route` VALUES ('60', '网站管理', '', 'cog', '6', '9', '1', '1484882155', '2017-04-14 15:47:17');
INSERT INTO `t_admin_route` VALUES ('61', '支付管理', '', 'globe', '6', '8', '1', '1484882155', '2017-04-14 15:47:20');
INSERT INTO `t_admin_route` VALUES ('62', '第三方平台', '', 'cloud', '6', '7', '1', '1436167620', '2017-04-14 15:47:21');
INSERT INTO `t_admin_route` VALUES ('63', '配送管理', '', 'print', '6', '6', '1', '1436167620', '2017-04-14 15:47:24');
INSERT INTO `t_admin_route` VALUES ('64', '区域管理', '', 'globe', '6', '5', '1', '1436167620', '2017-04-14 15:47:25');
INSERT INTO `t_admin_route` VALUES ('65', '权限管理', '', 'user', '6', '4', '1', '1436167620', '2017-04-19 10:56:28');
INSERT INTO `t_admin_route` VALUES ('66', '消息模板', '', 'volume-up', '6', '3', '1', '0', '2017-04-19 10:57:35');
INSERT INTO `t_admin_route` VALUES ('71', '内容管理', '', 'book', '7', '8', '1', '1484882155', '2017-04-14 15:47:38');
INSERT INTO `t_admin_route` VALUES ('72', '广告管理', '', '', '7', '7', '1', '1436167620', '2017-04-14 15:47:45');
INSERT INTO `t_admin_route` VALUES ('73', '链接管理', '', 'sitemap', '7', '7', '1', '1436167620', '2017-04-14 15:47:47');
INSERT INTO `t_admin_route` VALUES ('74', '网站地图', '', 'globe', '7', '6', '1', '1436167620', '2017-04-14 15:47:49');
INSERT INTO `t_admin_route` VALUES ('1000', '商品列表', 'goods/index', '', '10', '99', '1', '1484882192', '2017-04-14 15:47:51');
INSERT INTO `t_admin_route` VALUES ('1001', '商品新增', 'goods/create', '', '10', '98', '1', '1484882228', '2017-04-14 15:47:54');
INSERT INTO `t_admin_route` VALUES ('1002', '商品编辑', 'goods/update', '', '10', '97', '2', '1436164311', '2016-03-20 20:51:44');
INSERT INTO `t_admin_route` VALUES ('1004', '商品上架设置', 'goods/online', '', '10', '95', '2', '1436164328', '2015-09-25 14:28:52');
INSERT INTO `t_admin_route` VALUES ('1005', '商品下架设置', 'goods/offline', '', '10', '94', '2', '1436164328', '2015-09-25 14:28:52');
INSERT INTO `t_admin_route` VALUES ('1006', '商品待审设置', 'goods/check', '', '10', '93', '2', '1436164328', '2015-09-25 14:28:52');
INSERT INTO `t_admin_route` VALUES ('1007', '商品标签设置', 'goods/label', '', '10', '92', '2', '1436164328', '2017-01-30 16:58:35');
INSERT INTO `t_admin_route` VALUES ('1008', '商品批量设置', 'goods/setting', '', '10', '91', '2', '1436164328', '2017-01-30 16:58:35');
INSERT INTO `t_admin_route` VALUES ('1100', '商品类别列表', 'goods-category/index', '', '11', '99', '1', '1443409950', '2017-04-14 15:48:02');
INSERT INTO `t_admin_route` VALUES ('1101', '商品类别新增', 'goods-category/create', '', '11', '98', '2', '1436171413', '2017-02-11 15:33:11');
INSERT INTO `t_admin_route` VALUES ('1102', '商品类别编辑', 'goods-category/update', '', '11', '97', '2', '1436171520', '2017-02-11 15:33:12');
INSERT INTO `t_admin_route` VALUES ('1103', '商品类别删除', 'goods-category/delete', '', '11', '96', '2', '1436171551', '2017-02-11 15:33:12');
INSERT INTO `t_admin_route` VALUES ('1200', '商品品牌列表', 'goods-brand/index', '', '12', '99', '1', '1443409950', '2017-04-14 15:48:03');
INSERT INTO `t_admin_route` VALUES ('1201', '商品品牌新增', 'goods-brand/create', '', '12', '98', '2', '1436171413', '2017-02-11 15:33:12');
INSERT INTO `t_admin_route` VALUES ('1202', '商品品牌编辑', 'goods-brand/update', '', '12', '97', '2', '1436171520', '2017-02-11 15:33:12');
INSERT INTO `t_admin_route` VALUES ('1203', '商品品牌删除', 'goods-brand/delete', '', '12', '96', '2', '1436171551', '2017-02-11 15:33:12');
INSERT INTO `t_admin_route` VALUES ('1204', '品牌类别列表', 'goods-brand-category/index', '', '12', '95', '1', '1443409950', '2017-04-14 15:48:05');
INSERT INTO `t_admin_route` VALUES ('1205', '品牌类别新增', 'goods-brand-category/create', '', '12', '94', '2', '1436171413', '2017-02-11 15:33:12');
INSERT INTO `t_admin_route` VALUES ('1206', '品牌类别编辑', 'goods-brand-category/update', '', '12', '93', '2', '1436171520', '2017-02-11 15:33:12');
INSERT INTO `t_admin_route` VALUES ('1207', '品牌类别删除', 'goods-brand-category/delete', '', '12', '92', '2', '1436171551', '2017-02-11 15:33:12');
INSERT INTO `t_admin_route` VALUES ('1300', '商品模型列表', 'goods-model/index', '', '13', '99', '1', '1443409950', '2017-04-14 15:48:07');
INSERT INTO `t_admin_route` VALUES ('1301', '商品模型新增', 'goods-model/create', '', '13', '98', '2', '1436171413', '2017-02-11 15:33:12');
INSERT INTO `t_admin_route` VALUES ('1302', '商品模型编辑', 'goods-model/update', '', '13', '97', '2', '1436171520', '2017-02-11 15:33:12');
INSERT INTO `t_admin_route` VALUES ('1303', '商品模型删除', 'goods-model/delete', '', '13', '96', '2', '1436171551', '2017-02-11 15:33:12');
INSERT INTO `t_admin_route` VALUES ('2000', '用户列表', 'user/index', '', '20', '99', '1', '1443409950', '2017-04-14 15:48:11');
INSERT INTO `t_admin_route` VALUES ('2001', '用户新增', 'user/create', '', '20', '98', '2', '1436160659', '2017-01-26 19:51:20');
INSERT INTO `t_admin_route` VALUES ('2002', '用户编辑', 'user/update', '', '20', '97', '2', '1436167171', '2017-01-26 19:51:31');
INSERT INTO `t_admin_route` VALUES ('2003', '用户禁用', 'user/delete', '', '20', '96', '2', '1436167203', '2017-01-26 19:51:53');
INSERT INTO `t_admin_route` VALUES ('2004', '用户账户管理', 'user/amount', '', '20', '95', '2', '1436167171', '2017-01-26 19:51:31');
INSERT INTO `t_admin_route` VALUES ('2005', '用户扣款', 'user/subtract', '', '20', '94', '2', '1436167203', '2017-01-26 19:51:53');
INSERT INTO `t_admin_route` VALUES ('2010', '用户组列表', 'user-group/index', '', '20', '89', '1', '1443409950', '2017-04-14 15:48:12');
INSERT INTO `t_admin_route` VALUES ('2011', '用户组新增', 'user-group/create', '', '20', '88', '2', '1436160659', '2017-01-26 19:52:18');
INSERT INTO `t_admin_route` VALUES ('2012', '用户组编辑', 'user-group/update', '', '20', '87', '2', '1436167171', '2017-01-26 19:52:30');
INSERT INTO `t_admin_route` VALUES ('2013', '用户组禁用', 'user-group/delete', '', '20', '86', '2', '1436167203', '2017-01-26 19:52:49');
INSERT INTO `t_admin_route` VALUES ('2300', '反馈列表', 'feedback/index', '', '23', '99', '1', '1433243513', '2017-04-14 15:48:15');
INSERT INTO `t_admin_route` VALUES ('2301', '反馈查看', 'feedback/view', '', '23', '98', '2', '1436163983', '2017-01-26 16:43:55');
INSERT INTO `t_admin_route` VALUES ('2302', '反馈处理', 'feedback/operation', '', '23', '97', '2', '1436164003', '2017-01-26 16:43:55');
INSERT INTO `t_admin_route` VALUES ('3000', '订单列表', 'order/index', '', '30', '99', '1', '1443409950', '2017-04-14 15:48:16');
INSERT INTO `t_admin_route` VALUES ('3001', '订单新增', 'order/create', '', '30', '98', '1', '1436160216', '2017-04-14 15:48:17');
INSERT INTO `t_admin_route` VALUES ('3002', '订单编辑', 'order/update', '', '30', '97', '2', '1436164311', '2016-03-20 20:51:44');
INSERT INTO `t_admin_route` VALUES ('3003', '订单查看', 'order/view', '', '30', '96', '2', '1436164328', '2015-09-25 14:28:52');
INSERT INTO `t_admin_route` VALUES ('3004', '订单支付', 'order/pay', '', '30', '95', '2', '1436164328', '2015-09-25 14:28:52');
INSERT INTO `t_admin_route` VALUES ('3005', '订单发货', 'order/delivery', '', '30', '94', '2', '1436164328', '2015-09-25 14:28:52');
INSERT INTO `t_admin_route` VALUES ('3006', '订单退款', 'order/refundment', '', '30', '93', '2', '1436164328', '2015-09-25 14:28:52');
INSERT INTO `t_admin_route` VALUES ('3007', '订单完成', 'order/finish', '', '30', '92', '2', '1436164328', '2015-09-25 14:28:52');
INSERT INTO `t_admin_route` VALUES ('3008', '订单取消', 'order/cancel', '', '30', '91', '2', '1436164328', '2015-09-25 14:28:52');
INSERT INTO `t_admin_route` VALUES ('3009', '订单导入', 'order/import', '', '30', '90', '1', '1436164328', '2017-04-14 15:48:20');
INSERT INTO `t_admin_route` VALUES ('4000', '促销活动列表', 'market-activity/index', '', '40', '99', '1', '1482396033', '2017-04-14 15:48:27');
INSERT INTO `t_admin_route` VALUES ('4001', '促销活动新增', 'market-activity/create', '', '40', '98', '2', '1436160659', '2017-02-21 23:10:58');
INSERT INTO `t_admin_route` VALUES ('4002', '促销活动编辑', 'market-activity/update', '', '40', '97', '2', '1436167171', '2017-01-26 19:51:31');
INSERT INTO `t_admin_route` VALUES ('4003', '促销活动删除', 'market-activity/delete', '', '40', '96', '2', '1436167203', '2017-01-26 19:51:53');
INSERT INTO `t_admin_route` VALUES ('4100', '限时抢购列表', 'market-speed/index', '', '41', '89', '1', '1482396033', '2017-04-14 15:48:30');
INSERT INTO `t_admin_route` VALUES ('4101', '限时抢购新增', 'market-speed/create', '', '41', '88', '2', '1436160659', '2017-02-21 23:11:51');
INSERT INTO `t_admin_route` VALUES ('4102', '限时抢购编辑', 'market-speed/update', '', '41', '87', '2', '1436167171', '2017-01-26 19:51:31');
INSERT INTO `t_admin_route` VALUES ('4103', '限时抢购删除', 'market-speed/delete', '', '41', '86', '2', '1436167203', '2017-01-26 19:51:53');
INSERT INTO `t_admin_route` VALUES ('4110', '团购列表', 'market-group/index', '', '41', '79', '1', '1482396033', '2017-04-14 15:48:31');
INSERT INTO `t_admin_route` VALUES ('4111', '团购新增', 'market-group/create', '', '41', '78', '2', '1436160659', '2017-02-21 23:16:30');
INSERT INTO `t_admin_route` VALUES ('4112', '团购编辑', 'market-group/update', '', '41', '77', '2', '1436167171', '2017-02-21 23:16:41');
INSERT INTO `t_admin_route` VALUES ('4113', '团购删除', 'market-group/delete', '', '41', '76', '2', '1436167203', '2017-02-21 23:16:52');
INSERT INTO `t_admin_route` VALUES ('4120', '特价活动列表', 'market-sale/index', '', '41', '69', '1', '1482396033', '2017-04-14 15:48:32');
INSERT INTO `t_admin_route` VALUES ('4121', '特价活动新增', 'market-sale/create', '', '41', '68', '2', '1436160659', '2017-02-21 23:11:28');
INSERT INTO `t_admin_route` VALUES ('4122', '特价活动编辑', 'market-sale/update', '', '41', '67', '2', '1436167171', '2017-01-26 19:51:31');
INSERT INTO `t_admin_route` VALUES ('4123', '特价活动删除', 'market-sale/delete', '', '41', '66', '2', '1436167203', '2017-01-26 19:51:53');
INSERT INTO `t_admin_route` VALUES ('4130', '代金券列表', 'market-ticket/index', '', '42', '59', '1', '1482396033', '2017-04-14 15:48:35');
INSERT INTO `t_admin_route` VALUES ('4131', '代金券新增', 'market-ticket/create', '', '42', '58', '2', '1436160659', '2017-03-05 13:31:21');
INSERT INTO `t_admin_route` VALUES ('4132', '代金券编辑', 'market-ticket/update', '', '42', '57', '2', '1436167171', '2017-03-05 13:31:39');
INSERT INTO `t_admin_route` VALUES ('4133', '代金券删除', 'market-ticket/delete', '', '42', '56', '2', '1436167203', '2017-03-05 13:31:53');
INSERT INTO `t_admin_route` VALUES ('4134', '代金券导出', 'market-ticket/export', '', '42', '55', '2', '1436167203', '2017-03-05 13:32:13');
INSERT INTO `t_admin_route` VALUES ('4135', '代金券新增卡号', 'market-ticket/add', '', '42', '54', '2', '1436167203', '2017-03-05 13:32:13');
INSERT INTO `t_admin_route` VALUES ('4140', '卡号列表', 'market-card/index', '', '42', '49', '2', '1482396033', '2017-04-14 15:48:36');
INSERT INTO `t_admin_route` VALUES ('4141', '卡号发放', 'market-card/send', '', '42', '48', '2', '1482396033', '2017-03-05 13:38:02');
INSERT INTO `t_admin_route` VALUES ('4142', '卡号禁用', 'market-card/used', '', '42', '47', '2', '1482396033', '2017-03-05 13:34:26');
INSERT INTO `t_admin_route` VALUES ('4143', '卡号删除', 'market-card/delete', '', '42', '46', '2', '1482396033', '2017-03-05 13:34:18');
INSERT INTO `t_admin_route` VALUES ('4144', '批量卡号发放', 'market-card/send-all', '', '42', '48', '2', '1482396033', '2017-03-05 13:38:02');
INSERT INTO `t_admin_route` VALUES ('4145', '批量卡号禁用', 'market-card/used-all', '', '42', '47', '2', '1482396033', '2017-03-05 13:34:26');
INSERT INTO `t_admin_route` VALUES ('4146', '批量卡号删除', 'market-card/delete-all', '', '42', '46', '2', '1482396033', '2017-03-05 13:34:18');
INSERT INTO `t_admin_route` VALUES ('5000', '用户注册统计', 'market-statistics/register', '', '50', '99', '1', '1482396033', '2017-01-25 06:31:32');
INSERT INTO `t_admin_route` VALUES ('5001', '销售额统计', 'market-statistics/sales', '', '50', '98', '1', '1482396033', '2017-01-25 06:31:32');
INSERT INTO `t_admin_route` VALUES ('5100', '资金操作记录', 'user-acount-log/index', '', '51', '97', '1', '1482396033', '2017-04-14 15:48:38');
INSERT INTO `t_admin_route` VALUES ('5101', '积分操作记录', 'user-point-log/index', '', '51', '96', '1', '1482396033', '2017-04-14 15:48:39');
INSERT INTO `t_admin_route` VALUES ('5102', '后台操作记录', 'admin-operation-log/index', '', '51', '95', '1', '1482396033', '2017-04-14 15:48:40');
INSERT INTO `t_admin_route` VALUES ('5103', '短信日志', 'sms-log/index', '', '51', '94', '1', '1482396033', '2017-04-14 15:48:41');
INSERT INTO `t_admin_route` VALUES ('5104', '邮件日志', 'email-log/index', '', '51', '93', '1', '1482396033', '2017-04-14 15:48:43');
INSERT INTO `t_admin_route` VALUES ('6000', '后台首页', 'site/index', 'home', '60', '99', '1', '1431423162', '2017-04-14 15:48:44');
INSERT INTO `t_admin_route` VALUES ('6001', '网站设置', 'config/index', 'sitemap', '60', '98', '1', '1431423162', '2017-04-14 15:48:47');
INSERT INTO `t_admin_route` VALUES ('6100', '支付方式列表', 'payment/index', '', '61', '99', '1', '1431423162', '2017-04-14 15:48:48');
INSERT INTO `t_admin_route` VALUES ('6101', '支付方式编辑', 'payment/update', '', '61', '98', '2', '1431423162', '2016-02-26 16:44:13');
INSERT INTO `t_admin_route` VALUES ('6200', 'oauth授权列表', 'oauth/index', '', '62', '99', '1', '1431423162', '2017-04-14 15:48:49');
INSERT INTO `t_admin_route` VALUES ('6201', 'oauth授权编辑', 'oauth/update', '', '62', '98', '2', '1431423162', '2016-02-26 16:44:13');
INSERT INTO `t_admin_route` VALUES ('6300', '配送方式列表', 'delivery/index', '', '63', '99', '1', '1431423162', '2017-04-14 15:49:02');
INSERT INTO `t_admin_route` VALUES ('6301', '配送方式新增', 'delivery/create', '', '63', '98', '2', '1431423162', '2016-02-26 16:44:13');
INSERT INTO `t_admin_route` VALUES ('6302', '配送方式编辑', 'delivery/update', '', '63', '97', '2', '1436164311', '2016-03-20 20:51:44');
INSERT INTO `t_admin_route` VALUES ('6310', '物流公司列表', 'freight-company/index', '', '63', '89', '1', '1431423162', '2017-04-14 15:49:04');
INSERT INTO `t_admin_route` VALUES ('6311', '物流公司新增', 'freight-company/create', '', '63', '88', '2', '1431423162', '2016-02-26 16:44:13');
INSERT INTO `t_admin_route` VALUES ('6312', '物流公司编辑', 'freight-company/update', '', '63', '87', '2', '1436164311', '2016-03-20 20:51:44');
INSERT INTO `t_admin_route` VALUES ('6320', '自提点列表', 'takeself/index', '', '63', '79', '1', '1431423162', '2017-04-19 10:52:33');
INSERT INTO `t_admin_route` VALUES ('6321', '自提点新增', 'takeself/create', '', '63', '78', '2', '1431423162', '2016-02-26 16:44:13');
INSERT INTO `t_admin_route` VALUES ('6322', '自提点编辑', 'takeself/update', '', '63', '77', '2', '1436164311', '2016-03-20 20:51:44');
INSERT INTO `t_admin_route` VALUES ('6401', '区域列表', 'areas/index', '', '64', '69', '1', '1431423162', '2017-04-14 15:49:06');
INSERT INTO `t_admin_route` VALUES ('6402', '区域新增', 'areas/create', '', '64', '68', '2', '1431423162', '2016-02-26 16:44:13');
INSERT INTO `t_admin_route` VALUES ('6403', '区域编辑', 'areas/update', '', '64', '67', '2', '1436164311', '2016-03-20 20:51:44');
INSERT INTO `t_admin_route` VALUES ('6404', '区域删除', 'areas/delete', '', '64', '66', '2', '1436164328', '2015-09-25 14:28:52');
INSERT INTO `t_admin_route` VALUES ('6405', '区域生成静态JS文件', 'areas/make', '', '64', '65', '2', '1436164328', '2015-09-25 14:28:52');
INSERT INTO `t_admin_route` VALUES ('6500', '管理员列表', 'admin/index', 'user', '65', '89', '1', '1443409950', '2017-04-19 10:58:10');
INSERT INTO `t_admin_route` VALUES ('6501', '管理员新增', 'admin/create', '', '65', '88', '2', '1436160659', '2017-01-26 16:40:44');
INSERT INTO `t_admin_route` VALUES ('6502', '管理员编辑', 'admin/update', '', '65', '87', '2', '1436167171', '2017-01-26 16:40:44');
INSERT INTO `t_admin_route` VALUES ('6503', '管理员禁用', 'admin/delete', '', '65', '86', '2', '1436167203', '2017-01-26 16:40:44');
INSERT INTO `t_admin_route` VALUES ('6510', '角色列表', 'admin-role/index', 'briefcase', '65', '79', '1', '1431327174', '2017-04-19 10:59:00');
INSERT INTO `t_admin_route` VALUES ('6511', '角色新增', 'admin-role/create', '', '65', '78', '2', '1436160847', '2017-01-26 16:40:44');
INSERT INTO `t_admin_route` VALUES ('6512', '角色编辑', 'admin-role/update', '', '65', '77', '2', '1436167503', '2017-01-26 16:40:44');
INSERT INTO `t_admin_route` VALUES ('6513', '角色删除', 'admin-role/delete', '', '65', '76', '2', '1436167524', '2017-01-26 16:40:44');
INSERT INTO `t_admin_route` VALUES ('6520', '路由列表', 'admin-route/index', '', '65', '69', '1', '1443409950', '2017-04-14 15:49:09');
INSERT INTO `t_admin_route` VALUES ('6521', '路由新增', 'admin-route/create', '', '65', '68', '2', '1436167704', '2016-04-10 23:00:24');
INSERT INTO `t_admin_route` VALUES ('6522', '路由编辑', 'admin-route/update', '', '65', '67', '2', '1436167646', '2016-04-10 23:00:40');
INSERT INTO `t_admin_route` VALUES ('6523', '路由删除', 'admin-route/delete', '', '65', '66', '2', '1436167681', '2016-04-10 23:00:55');
INSERT INTO `t_admin_route` VALUES ('6601', '消息模板列表', 'notity-template/index', '', '66', '0', '1', '0', '2017-04-14 15:49:12');
INSERT INTO `t_admin_route` VALUES ('6602', '消息模板新增', 'notity-template/create', '', '66', '0', '2', '0', '2017-03-17 10:38:30');
INSERT INTO `t_admin_route` VALUES ('6603', '消息模板编辑', 'notity-template/update', '', '66', '0', '2', '0', '2017-03-17 10:38:52');
INSERT INTO `t_admin_route` VALUES ('6900', '图片上传', 'uploader/picture', '', '65', '59', '2', '1436169223', '2017-01-25 06:31:32');
INSERT INTO `t_admin_route` VALUES ('6901', '附件上传', 'uploader/file', '', '65', '58', '2', '1436169223', '2017-01-25 06:31:32');
INSERT INTO `t_admin_route` VALUES ('6902', '附件删除', 'uploader/delete', '', '65', '57', '2', '1436169223', '2017-01-25 06:31:32');
INSERT INTO `t_admin_route` VALUES ('7100', '内容列表', 'content/index', '', '71', '99', '1', '1443409950', '2017-04-14 15:49:13');
INSERT INTO `t_admin_route` VALUES ('7101', '内容新增', 'content/create', '', '71', '98', '1', '1436160216', '2017-04-14 15:49:14');
INSERT INTO `t_admin_route` VALUES ('7102', '内容编辑', 'content/update', '', '71', '97', '2', '1436164311', '2016-03-20 20:51:44');
INSERT INTO `t_admin_route` VALUES ('7103', '内容删除', 'content/delete', '', '71', '96', '2', '1436164328', '2015-09-25 14:28:52');
INSERT INTO `t_admin_route` VALUES ('7104', '内容标签设置', 'content/label', '', '71', '95', '2', '1436164328', '2017-01-30 16:58:35');
INSERT INTO `t_admin_route` VALUES ('7110', '内容模型列表', 'content-model/index', '', '71', '89', '1', '1431423162', '2017-04-14 15:49:15');
INSERT INTO `t_admin_route` VALUES ('7111', '内容模型新增', 'content-model/create', '', '71', '88', '2', '1436167438', '2017-01-26 16:45:30');
INSERT INTO `t_admin_route` VALUES ('7112', '内容模型编辑', 'content-model/update', '', '71', '87', '2', '1436167399', '2017-01-26 16:45:30');
INSERT INTO `t_admin_route` VALUES ('7113', '内容模型删除', 'content-model/delete', '', '71', '86', '2', '1436167417', '2017-01-26 16:45:30');
INSERT INTO `t_admin_route` VALUES ('7120', '内容类别列表', 'content-category/index', '', '71', '79', '1', '1443409950', '2017-04-14 15:49:17');
INSERT INTO `t_admin_route` VALUES ('7121', '内容类别新增', 'content-category/create', '', '71', '78', '2', '1436171413', '2017-01-26 21:44:27');
INSERT INTO `t_admin_route` VALUES ('7122', '内容类别编辑', 'content-category/update', '', '71', '77', '2', '1436171520', '2017-01-26 16:45:30');
INSERT INTO `t_admin_route` VALUES ('7123', '内容类别删除', 'content-category/delete', '', '71', '76', '2', '1436171551', '2017-01-26 16:45:30');
INSERT INTO `t_admin_route` VALUES ('7130', '内容专题列表', 'content-special/index', '', '71', '69', '1', '1443409950', '2017-04-14 15:49:18');
INSERT INTO `t_admin_route` VALUES ('7131', '内容专题新增', 'content-special/create', '', '71', '68', '2', '1436171413', '2017-01-26 21:44:41');
INSERT INTO `t_admin_route` VALUES ('7132', '内容专题编辑', 'content-special/update', '', '71', '67', '2', '1436171520', '2017-01-26 16:45:30');
INSERT INTO `t_admin_route` VALUES ('7133', '内容专题删除', 'content-special/delete', '', '71', '66', '2', '1436171551', '2017-01-26 16:45:30');
INSERT INTO `t_admin_route` VALUES ('7200', '广告列表', 'ad-manage/index', '', '72', '99', '1', '1431511278', '2017-04-14 15:49:19');
INSERT INTO `t_admin_route` VALUES ('7201', '广告新增', 'ad-manage/create', '', '72', '98', '2', '1436161840', '2017-01-26 16:43:12');
INSERT INTO `t_admin_route` VALUES ('7202', '广告编辑', 'ad-manage/update', '', '72', '97', '2', '1436168158', '2017-01-26 16:43:12');
INSERT INTO `t_admin_route` VALUES ('7203', '广告删除', 'ad-manage/delete', '', '72', '96', '2', '1436168187', '2017-01-26 16:43:12');
INSERT INTO `t_admin_route` VALUES ('7210', '广告位列表', 'ad-position/index', '', '72', '89', '1', '1431511278', '2017-04-14 15:49:20');
INSERT INTO `t_admin_route` VALUES ('7211', '广告位新增', 'ad-position/create', '', '72', '88', '2', '1436161840', '2017-01-26 16:43:12');
INSERT INTO `t_admin_route` VALUES ('7212', '广告位编辑', 'ad-position/update', '', '72', '87', '2', '1436168158', '2017-01-26 16:43:12');
INSERT INTO `t_admin_route` VALUES ('7213', '广告位删除', 'ad-position/delete', '', '72', '86', '2', '1436168187', '2017-01-26 16:43:12');
INSERT INTO `t_admin_route` VALUES ('7300', '链接列表', 'link/index', '', '73', '99', '1', '1443409950', '2017-04-14 15:49:23');
INSERT INTO `t_admin_route` VALUES ('7301', '链接新增', 'link/create', '', '73', '98', '2', '1436161069', '2017-01-26 16:43:12');
INSERT INTO `t_admin_route` VALUES ('7302', '链接编辑', 'link/update', '', '73', '97', '2', '1436167798', '2017-01-26 16:43:12');
INSERT INTO `t_admin_route` VALUES ('7303', '链接删除', 'link/delete', '', '73', '96', '2', '1436167820', '2017-01-26 16:43:12');
INSERT INTO `t_admin_route` VALUES ('7304', '单据管理', '', 'bookmark', '3', '0', '1', '0', '2017-04-14 15:49:24');
INSERT INTO `t_admin_route` VALUES ('7305', '收款单', 'collection-doc/index', '', '7304', '0', '1', '0', '2017-04-14 15:49:25');
INSERT INTO `t_admin_route` VALUES ('7306', '退款单', 'refundment-doc/index', '', '7304', '0', '1', '0', '2017-04-14 15:49:27');
INSERT INTO `t_admin_route` VALUES ('7307', '发货单', 'delivery-doc/index', '', '7304', '0', '1', '0', '2017-04-14 15:49:28');
INSERT INTO `t_admin_route` VALUES ('7308', '退款申请单', 'refundment/index', '', '7304', '0', '1', '0', '2017-04-14 15:49:29');

-- ----------------------------
-- Table structure for `t_ad_manage`
-- ----------------------------
DROP TABLE IF EXISTS `t_ad_manage`;
CREATE TABLE `t_ad_manage` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告ID',
  `c_title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `c_url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接',
  `c_content` text COMMENT '广告内容 文字、图片、flash、html',
  `c_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '广告类型 1文字 2图片 3flash 4html',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '状态 1正常 2无效',
  `c_position_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '广告位ID',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `c_hits` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击次数',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告记录表';

-- ----------------------------
-- Records of t_ad_manage
-- ----------------------------

-- ----------------------------
-- Table structure for `t_ad_position`
-- ----------------------------
DROP TABLE IF EXISTS `t_ad_position`;
CREATE TABLE `t_ad_position` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告位ID',
  `c_title` varchar(50) NOT NULL COMMENT '标题',
  `c_note` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `c_height` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '图片高度',
  `c_width` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '图片高度',
  `c_count` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '广告显示数量',
  `c_type` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '类型 1系统广告位 2自定义广告位',
  `c_is_count` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否统计点击 1统计 2不统计',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1正常 2无效',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='广告位表';

-- ----------------------------
-- Records of t_ad_position
-- ----------------------------
INSERT INTO `t_ad_position` VALUES ('1', '首页幻灯片', '首页幻灯片', '300', '980', '5', '1', '1', '1', '0', '1482395759', '2016-12-22 16:35:59');

-- ----------------------------
-- Table structure for `t_areas`
-- ----------------------------
DROP TABLE IF EXISTS `t_areas`;
CREATE TABLE `t_areas` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_title` varchar(50) NOT NULL DEFAULT '' COMMENT '地区名称',
  `c_postcode` varchar(6) NOT NULL DEFAULT '0' COMMENT '邮政编码',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1正常 2无效',
  `c_parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级类别',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`c_id`),
  KEY `c_parent_id` (`c_parent_id`) USING BTREE,
  KEY `c_sort` (`c_sort`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3195 DEFAULT CHARSET=utf8 COMMENT='区域';

-- ----------------------------
-- Records of t_areas
-- ----------------------------
INSERT INTO `t_areas` VALUES ('2', '北京市', '0', '1', '0', '2');
INSERT INTO `t_areas` VALUES ('3', '天津市', '0', '1', '0', '3');
INSERT INTO `t_areas` VALUES ('4', '河北省', '0', '1', '0', '4');
INSERT INTO `t_areas` VALUES ('5', '山西省', '0', '1', '0', '5');
INSERT INTO `t_areas` VALUES ('6', '内蒙古自治区', '0', '1', '0', '6');
INSERT INTO `t_areas` VALUES ('7', '辽宁省', '0', '1', '0', '7');
INSERT INTO `t_areas` VALUES ('8', '吉林省', '0', '1', '0', '8');
INSERT INTO `t_areas` VALUES ('9', '黑龙江省', '0', '1', '0', '9');
INSERT INTO `t_areas` VALUES ('10', '上海市', '0', '1', '0', '10');
INSERT INTO `t_areas` VALUES ('11', '江苏省', '0', '1', '0', '11');
INSERT INTO `t_areas` VALUES ('12', '浙江省', '0', '1', '0', '12');
INSERT INTO `t_areas` VALUES ('13', '安徽省', '0', '1', '0', '13');
INSERT INTO `t_areas` VALUES ('14', '福建省', '0', '1', '0', '14');
INSERT INTO `t_areas` VALUES ('15', '江西省', '0', '1', '0', '15');
INSERT INTO `t_areas` VALUES ('16', '山东省', '0', '1', '0', '16');
INSERT INTO `t_areas` VALUES ('17', '河南省', '0', '1', '0', '17');
INSERT INTO `t_areas` VALUES ('18', '湖北省', '0', '1', '0', '18');
INSERT INTO `t_areas` VALUES ('19', '湖南省', '0', '1', '0', '19');
INSERT INTO `t_areas` VALUES ('20', '广东省', '0', '1', '0', '20');
INSERT INTO `t_areas` VALUES ('21', '广西壮族自治区', '0', '1', '0', '21');
INSERT INTO `t_areas` VALUES ('22', '海南省', '0', '1', '0', '22');
INSERT INTO `t_areas` VALUES ('23', '重庆市', '0', '1', '0', '23');
INSERT INTO `t_areas` VALUES ('25', '四川省', '0', '1', '0', '25');
INSERT INTO `t_areas` VALUES ('26', '贵州省', '0', '1', '0', '26');
INSERT INTO `t_areas` VALUES ('27', '云南省', '0', '1', '0', '27');
INSERT INTO `t_areas` VALUES ('28', '西藏自治区', '0', '1', '0', '28');
INSERT INTO `t_areas` VALUES ('29', '陕西省', '0', '1', '0', '29');
INSERT INTO `t_areas` VALUES ('30', '甘肃省', '0', '1', '0', '30');
INSERT INTO `t_areas` VALUES ('31', '青海省', '0', '1', '0', '31');
INSERT INTO `t_areas` VALUES ('32', '宁夏回族自治区', '0', '1', '0', '32');
INSERT INTO `t_areas` VALUES ('33', '新疆维吾尔自治区', '0', '1', '0', '33');
INSERT INTO `t_areas` VALUES ('34', '台湾省', '0', '1', '0', '34');
INSERT INTO `t_areas` VALUES ('35', '香港特别行政区', '0', '1', '0', '35');
INSERT INTO `t_areas` VALUES ('36', '澳门特别行政区', '0', '1', '0', '36');
INSERT INTO `t_areas` VALUES ('37', '东城区', '100000', '1', '2', '37');
INSERT INTO `t_areas` VALUES ('38', '西城区', '100000', '1', '2', '38');
INSERT INTO `t_areas` VALUES ('39', '崇文区', '100000', '1', '2', '39');
INSERT INTO `t_areas` VALUES ('40', '宣武区', '100000', '1', '2', '40');
INSERT INTO `t_areas` VALUES ('41', '朝阳区', '100000', '1', '2', '41');
INSERT INTO `t_areas` VALUES ('42', '丰台区', '100000', '1', '2', '42');
INSERT INTO `t_areas` VALUES ('43', '石景山区', '100000', '1', '2', '43');
INSERT INTO `t_areas` VALUES ('44', '海淀区', '100000', '1', '2', '44');
INSERT INTO `t_areas` VALUES ('45', '门头沟区', '102300', '1', '2', '45');
INSERT INTO `t_areas` VALUES ('46', '房山区', '102400', '1', '2', '46');
INSERT INTO `t_areas` VALUES ('47', '通州区', '101100', '1', '2', '47');
INSERT INTO `t_areas` VALUES ('48', '顺义区', '101300', '1', '2', '48');
INSERT INTO `t_areas` VALUES ('49', '昌平区', '102200', '1', '2', '49');
INSERT INTO `t_areas` VALUES ('50', '大兴区', '102600', '1', '2', '50');
INSERT INTO `t_areas` VALUES ('51', '怀柔区', '101400', '1', '2', '51');
INSERT INTO `t_areas` VALUES ('52', '平谷区', '101200', '1', '2', '52');
INSERT INTO `t_areas` VALUES ('53', '密云县', '101500', '1', '2', '53');
INSERT INTO `t_areas` VALUES ('54', '延庆县', '102100', '1', '2', '54');
INSERT INTO `t_areas` VALUES ('55', '和平区', '300000', '1', '3', '55');
INSERT INTO `t_areas` VALUES ('56', '河东区', '300000', '1', '3', '56');
INSERT INTO `t_areas` VALUES ('57', '河西区', '300000', '1', '3', '57');
INSERT INTO `t_areas` VALUES ('58', '南开区', '300000', '1', '3', '58');
INSERT INTO `t_areas` VALUES ('59', '河北区', '300000', '1', '3', '59');
INSERT INTO `t_areas` VALUES ('60', '红桥区', '300000', '1', '3', '60');
INSERT INTO `t_areas` VALUES ('61', '塘沽区', '300450', '1', '3', '61');
INSERT INTO `t_areas` VALUES ('62', '汉沽区', '300480', '1', '3', '62');
INSERT INTO `t_areas` VALUES ('63', '大港区', '300000', '1', '3', '63');
INSERT INTO `t_areas` VALUES ('64', '东丽区', '300000', '1', '3', '64');
INSERT INTO `t_areas` VALUES ('65', '西青区', '300000', '1', '3', '65');
INSERT INTO `t_areas` VALUES ('66', '津南区', '300000', '1', '3', '66');
INSERT INTO `t_areas` VALUES ('67', '北辰区', '300000', '1', '3', '67');
INSERT INTO `t_areas` VALUES ('68', '武清区', '301700', '1', '3', '68');
INSERT INTO `t_areas` VALUES ('69', '宝坻区', '301800', '1', '3', '69');
INSERT INTO `t_areas` VALUES ('70', '宁河县', '301500', '1', '3', '70');
INSERT INTO `t_areas` VALUES ('71', '静海县', '301600', '1', '3', '71');
INSERT INTO `t_areas` VALUES ('72', '蓟县', '301900', '1', '3', '72');
INSERT INTO `t_areas` VALUES ('73', '石家庄市', '050000', '1', '4', '73');
INSERT INTO `t_areas` VALUES ('74', '长安区', '050000', '1', '73', '74');
INSERT INTO `t_areas` VALUES ('75', '桥东区', '050000', '1', '73', '75');
INSERT INTO `t_areas` VALUES ('76', '桥西区', '050000', '1', '73', '76');
INSERT INTO `t_areas` VALUES ('77', '新华区', '050000', '1', '73', '77');
INSERT INTO `t_areas` VALUES ('78', '井陉矿区', '051000', '1', '73', '78');
INSERT INTO `t_areas` VALUES ('79', '裕华区', '050000', '1', '73', '79');
INSERT INTO `t_areas` VALUES ('80', '井陉县', '050300', '1', '73', '80');
INSERT INTO `t_areas` VALUES ('81', '正定县', '050800', '1', '73', '81');
INSERT INTO `t_areas` VALUES ('82', '栾城县', '051430', '1', '73', '82');
INSERT INTO `t_areas` VALUES ('83', '行唐县', '050600', '1', '73', '83');
INSERT INTO `t_areas` VALUES ('84', '灵寿县', '050500', '1', '73', '84');
INSERT INTO `t_areas` VALUES ('85', '高邑县', '051330', '1', '73', '85');
INSERT INTO `t_areas` VALUES ('86', '深泽县', '052500', '1', '73', '86');
INSERT INTO `t_areas` VALUES ('87', '赞皇县', '051230', '1', '73', '87');
INSERT INTO `t_areas` VALUES ('88', '无极县', '052400', '1', '73', '88');
INSERT INTO `t_areas` VALUES ('89', '平山县', '050400', '1', '73', '89');
INSERT INTO `t_areas` VALUES ('90', '元氏县', '051130', '1', '73', '90');
INSERT INTO `t_areas` VALUES ('91', '赵县', '051530', '1', '73', '91');
INSERT INTO `t_areas` VALUES ('92', '辛集市', '052300', '1', '73', '92');
INSERT INTO `t_areas` VALUES ('93', '藁城市', '052160', '1', '73', '93');
INSERT INTO `t_areas` VALUES ('94', '晋州市', '052200', '1', '73', '94');
INSERT INTO `t_areas` VALUES ('95', '新乐市', '050700', '1', '73', '95');
INSERT INTO `t_areas` VALUES ('96', '鹿泉市', '050200', '1', '73', '96');
INSERT INTO `t_areas` VALUES ('97', '唐山市', '063000', '1', '4', '97');
INSERT INTO `t_areas` VALUES ('98', '路南区', '063000', '1', '97', '98');
INSERT INTO `t_areas` VALUES ('99', '路北区', '063000', '1', '97', '99');
INSERT INTO `t_areas` VALUES ('100', '古冶区', '063000', '1', '97', '100');
INSERT INTO `t_areas` VALUES ('101', '开平区', '063000', '1', '97', '101');
INSERT INTO `t_areas` VALUES ('102', '丰南区', '063300', '1', '97', '102');
INSERT INTO `t_areas` VALUES ('103', '丰润区', '063000', '1', '97', '103');
INSERT INTO `t_areas` VALUES ('104', '滦县', '063700', '1', '97', '104');
INSERT INTO `t_areas` VALUES ('105', '滦南县', '063500', '1', '97', '105');
INSERT INTO `t_areas` VALUES ('106', '乐亭县', '063600', '1', '97', '106');
INSERT INTO `t_areas` VALUES ('107', '迁西县', '064300', '1', '97', '107');
INSERT INTO `t_areas` VALUES ('108', '玉田县', '064100', '1', '97', '108');
INSERT INTO `t_areas` VALUES ('109', '唐海县', '063200', '1', '97', '109');
INSERT INTO `t_areas` VALUES ('110', '遵化市', '064200', '1', '97', '110');
INSERT INTO `t_areas` VALUES ('111', '迁安市', '064400', '1', '97', '111');
INSERT INTO `t_areas` VALUES ('112', '秦皇岛市', '066000', '1', '4', '112');
INSERT INTO `t_areas` VALUES ('113', '海港区', '066000', '1', '112', '113');
INSERT INTO `t_areas` VALUES ('114', '山海关区', '066200', '1', '112', '114');
INSERT INTO `t_areas` VALUES ('115', '北戴河区', '066100', '1', '112', '115');
INSERT INTO `t_areas` VALUES ('116', '青龙满族自治县', '066500', '1', '112', '116');
INSERT INTO `t_areas` VALUES ('117', '昌黎县', '066600', '1', '112', '117');
INSERT INTO `t_areas` VALUES ('118', '抚宁县', '066300', '1', '112', '118');
INSERT INTO `t_areas` VALUES ('119', '卢龙县', '066400', '1', '112', '119');
INSERT INTO `t_areas` VALUES ('120', '邯郸市', '056000', '1', '4', '120');
INSERT INTO `t_areas` VALUES ('121', '邯山区', '056000', '1', '120', '121');
INSERT INTO `t_areas` VALUES ('122', '丛台区', '056000', '1', '120', '122');
INSERT INTO `t_areas` VALUES ('123', '复兴区', '056000', '1', '120', '123');
INSERT INTO `t_areas` VALUES ('124', '峰峰矿区', '056200', '1', '120', '124');
INSERT INTO `t_areas` VALUES ('125', '邯郸县', '056000', '1', '120', '125');
INSERT INTO `t_areas` VALUES ('126', '临漳县', '056600', '1', '120', '126');
INSERT INTO `t_areas` VALUES ('127', '成安县', '056700', '1', '120', '127');
INSERT INTO `t_areas` VALUES ('128', '大名县', '056900', '1', '120', '128');
INSERT INTO `t_areas` VALUES ('129', '涉县', '056400', '1', '120', '129');
INSERT INTO `t_areas` VALUES ('130', '磁县', '056500', '1', '120', '130');
INSERT INTO `t_areas` VALUES ('131', '肥乡县', '057550', '1', '120', '131');
INSERT INTO `t_areas` VALUES ('132', '永年县', '057150', '1', '120', '132');
INSERT INTO `t_areas` VALUES ('133', '邱县', '057450', '1', '120', '133');
INSERT INTO `t_areas` VALUES ('134', '鸡泽县', '057350', '1', '120', '134');
INSERT INTO `t_areas` VALUES ('135', '广平县', '057650', '1', '120', '135');
INSERT INTO `t_areas` VALUES ('136', '馆陶县', '057750', '1', '120', '136');
INSERT INTO `t_areas` VALUES ('137', '魏县', '056800', '1', '120', '137');
INSERT INTO `t_areas` VALUES ('138', '曲周县', '057250', '1', '120', '138');
INSERT INTO `t_areas` VALUES ('139', '武安市', '056300', '1', '120', '139');
INSERT INTO `t_areas` VALUES ('140', '邢台市', '054000', '1', '4', '140');
INSERT INTO `t_areas` VALUES ('141', '桥东区', '054000', '1', '140', '141');
INSERT INTO `t_areas` VALUES ('142', '桥西区', '054000', '1', '140', '142');
INSERT INTO `t_areas` VALUES ('143', '邢台县', '054000', '1', '140', '143');
INSERT INTO `t_areas` VALUES ('144', '临城县', '054300', '1', '140', '144');
INSERT INTO `t_areas` VALUES ('145', '内丘县', '054200', '1', '140', '145');
INSERT INTO `t_areas` VALUES ('146', '柏乡县', '055450', '1', '140', '146');
INSERT INTO `t_areas` VALUES ('147', '隆尧县', '055350', '1', '140', '147');
INSERT INTO `t_areas` VALUES ('148', '任县', '055150', '1', '140', '148');
INSERT INTO `t_areas` VALUES ('149', '南和县', '054400', '1', '140', '149');
INSERT INTO `t_areas` VALUES ('150', '宁晋县', '055550', '1', '140', '150');
INSERT INTO `t_areas` VALUES ('151', '巨鹿县', '055250', '1', '140', '151');
INSERT INTO `t_areas` VALUES ('152', '新河县', '051730', '1', '140', '152');
INSERT INTO `t_areas` VALUES ('153', '广宗县', '054600', '1', '140', '153');
INSERT INTO `t_areas` VALUES ('154', '平乡县', '054500', '1', '140', '154');
INSERT INTO `t_areas` VALUES ('155', '威县', '054700', '1', '140', '155');
INSERT INTO `t_areas` VALUES ('156', '清河县', '054800', '1', '140', '156');
INSERT INTO `t_areas` VALUES ('157', '临西县', '054900', '1', '140', '157');
INSERT INTO `t_areas` VALUES ('158', '南宫市', '051800', '1', '140', '158');
INSERT INTO `t_areas` VALUES ('159', '沙河市', '054100', '1', '140', '159');
INSERT INTO `t_areas` VALUES ('160', '保定市', '071000', '1', '4', '160');
INSERT INTO `t_areas` VALUES ('161', '新市区', '071000', '1', '160', '161');
INSERT INTO `t_areas` VALUES ('162', '北市区', '071000', '1', '160', '162');
INSERT INTO `t_areas` VALUES ('163', '南市区', '071000', '1', '160', '163');
INSERT INTO `t_areas` VALUES ('164', '满城县', '072150', '1', '160', '164');
INSERT INTO `t_areas` VALUES ('165', '清苑县', '071100', '1', '160', '165');
INSERT INTO `t_areas` VALUES ('166', '涞水县', '074100', '1', '160', '166');
INSERT INTO `t_areas` VALUES ('167', '阜平县', '073200', '1', '160', '167');
INSERT INTO `t_areas` VALUES ('168', '徐水县', '072550', '1', '160', '168');
INSERT INTO `t_areas` VALUES ('169', '定兴县', '072650', '1', '160', '169');
INSERT INTO `t_areas` VALUES ('170', '唐县', '072350', '1', '160', '170');
INSERT INTO `t_areas` VALUES ('171', '高阳县', '071500', '1', '160', '171');
INSERT INTO `t_areas` VALUES ('172', '容城县', '071700', '1', '160', '172');
INSERT INTO `t_areas` VALUES ('173', '涞源县', '102900', '1', '160', '173');
INSERT INTO `t_areas` VALUES ('174', '望都县', '072450', '1', '160', '174');
INSERT INTO `t_areas` VALUES ('175', '安新县', '071600', '1', '160', '175');
INSERT INTO `t_areas` VALUES ('176', '易县', '074200', '1', '160', '176');
INSERT INTO `t_areas` VALUES ('177', '曲阳县', '073100', '1', '160', '177');
INSERT INTO `t_areas` VALUES ('178', '蠡县', '071400', '1', '160', '178');
INSERT INTO `t_areas` VALUES ('179', '顺平县', '072250', '1', '160', '179');
INSERT INTO `t_areas` VALUES ('180', '博野县', '071300', '1', '160', '180');
INSERT INTO `t_areas` VALUES ('181', '雄县', '071800', '1', '160', '181');
INSERT INTO `t_areas` VALUES ('182', '涿州市', '072750', '1', '160', '182');
INSERT INTO `t_areas` VALUES ('183', '定州市', '073000', '1', '160', '183');
INSERT INTO `t_areas` VALUES ('184', '安国市', '071200', '1', '160', '184');
INSERT INTO `t_areas` VALUES ('185', '高碑店市', '074000', '1', '160', '185');
INSERT INTO `t_areas` VALUES ('186', '张家口市', '075000', '1', '4', '186');
INSERT INTO `t_areas` VALUES ('187', '桥东区', '075000', '1', '186', '187');
INSERT INTO `t_areas` VALUES ('188', '桥西区', '075000', '1', '186', '188');
INSERT INTO `t_areas` VALUES ('189', '宣化区', '075000', '1', '186', '189');
INSERT INTO `t_areas` VALUES ('190', '下花园区', '075000', '1', '186', '190');
INSERT INTO `t_areas` VALUES ('191', '宣化县', '075100', '1', '186', '191');
INSERT INTO `t_areas` VALUES ('192', '张北县', '076450', '1', '186', '192');
INSERT INTO `t_areas` VALUES ('193', '康保县', '076650', '1', '186', '193');
INSERT INTO `t_areas` VALUES ('194', '沽源县', '076550', '1', '186', '194');
INSERT INTO `t_areas` VALUES ('195', '尚义县', '076750', '1', '186', '195');
INSERT INTO `t_areas` VALUES ('196', '蔚县', '075700', '1', '186', '196');
INSERT INTO `t_areas` VALUES ('197', '阳原县', '075800', '1', '186', '197');
INSERT INTO `t_areas` VALUES ('198', '怀安县', '076150', '1', '186', '198');
INSERT INTO `t_areas` VALUES ('199', '万全县', '076250', '1', '186', '199');
INSERT INTO `t_areas` VALUES ('200', '怀来县', '075400', '1', '186', '200');
INSERT INTO `t_areas` VALUES ('201', '涿鹿县', '075600', '1', '186', '201');
INSERT INTO `t_areas` VALUES ('202', '赤城县', '075500', '1', '186', '202');
INSERT INTO `t_areas` VALUES ('203', '崇礼县', '076350', '1', '186', '203');
INSERT INTO `t_areas` VALUES ('204', '承德市', '067000', '1', '4', '204');
INSERT INTO `t_areas` VALUES ('205', '双桥区', '067000', '1', '204', '205');
INSERT INTO `t_areas` VALUES ('206', '双滦区', '067000', '1', '204', '206');
INSERT INTO `t_areas` VALUES ('207', '鹰手营子矿区', '067200', '1', '204', '207');
INSERT INTO `t_areas` VALUES ('208', '承德县', '067400', '1', '204', '208');
INSERT INTO `t_areas` VALUES ('209', '兴隆县', '067300', '1', '204', '209');
INSERT INTO `t_areas` VALUES ('210', '平泉县', '067500', '1', '204', '210');
INSERT INTO `t_areas` VALUES ('211', '滦平县', '068250', '1', '204', '211');
INSERT INTO `t_areas` VALUES ('212', '隆化县', '068150', '1', '204', '212');
INSERT INTO `t_areas` VALUES ('213', '丰宁满族自治县', '068350', '1', '204', '213');
INSERT INTO `t_areas` VALUES ('214', '宽城满族自治县', '067600', '1', '204', '214');
INSERT INTO `t_areas` VALUES ('215', '围场满族蒙古族自治县', '068450', '1', '204', '215');
INSERT INTO `t_areas` VALUES ('216', '沧州市', '061000', '1', '4', '216');
INSERT INTO `t_areas` VALUES ('217', '新华区', '061000', '1', '216', '217');
INSERT INTO `t_areas` VALUES ('218', '运河区', '061000', '1', '216', '218');
INSERT INTO `t_areas` VALUES ('219', '沧县', '061000', '1', '216', '219');
INSERT INTO `t_areas` VALUES ('220', '青县', '062650', '1', '216', '220');
INSERT INTO `t_areas` VALUES ('221', '东光县', '061600', '1', '216', '221');
INSERT INTO `t_areas` VALUES ('222', '海兴县', '061200', '1', '216', '222');
INSERT INTO `t_areas` VALUES ('223', '盐山县', '061300', '1', '216', '223');
INSERT INTO `t_areas` VALUES ('224', '肃宁县', '062350', '1', '216', '224');
INSERT INTO `t_areas` VALUES ('225', '南皮县', '061500', '1', '216', '225');
INSERT INTO `t_areas` VALUES ('226', '吴桥县', '061800', '1', '216', '226');
INSERT INTO `t_areas` VALUES ('227', '献县', '062250', '1', '216', '227');
INSERT INTO `t_areas` VALUES ('228', '孟村回族自治县', '061400', '1', '216', '228');
INSERT INTO `t_areas` VALUES ('229', '泊头市', '062150', '1', '216', '229');
INSERT INTO `t_areas` VALUES ('230', '任丘市', '062550', '1', '216', '230');
INSERT INTO `t_areas` VALUES ('231', '黄骅市', '061100', '1', '216', '231');
INSERT INTO `t_areas` VALUES ('232', '河间市', '062450', '1', '216', '232');
INSERT INTO `t_areas` VALUES ('233', '廊坊市', '065000', '1', '4', '233');
INSERT INTO `t_areas` VALUES ('234', '安次区', '065000', '1', '233', '234');
INSERT INTO `t_areas` VALUES ('235', '广阳区', '065000', '1', '233', '235');
INSERT INTO `t_areas` VALUES ('236', '固安县', '065500', '1', '233', '236');
INSERT INTO `t_areas` VALUES ('237', '永清县', '065600', '1', '233', '237');
INSERT INTO `t_areas` VALUES ('238', '香河县', '065400', '1', '233', '238');
INSERT INTO `t_areas` VALUES ('239', '大城县', '065900', '1', '233', '239');
INSERT INTO `t_areas` VALUES ('240', '文安县', '065800', '1', '233', '240');
INSERT INTO `t_areas` VALUES ('241', '大厂回族自治县', '065300', '1', '233', '241');
INSERT INTO `t_areas` VALUES ('242', '霸州市', '065700', '1', '233', '242');
INSERT INTO `t_areas` VALUES ('243', '三河市', '065200', '1', '233', '243');
INSERT INTO `t_areas` VALUES ('244', '衡水市', '053000', '1', '4', '244');
INSERT INTO `t_areas` VALUES ('245', '桃城区', '053000', '1', '244', '245');
INSERT INTO `t_areas` VALUES ('246', '枣强县', '053100', '1', '244', '246');
INSERT INTO `t_areas` VALUES ('247', '武邑县', '053400', '1', '244', '247');
INSERT INTO `t_areas` VALUES ('248', '武强县', '053300', '1', '244', '248');
INSERT INTO `t_areas` VALUES ('249', '饶阳县', '053900', '1', '244', '249');
INSERT INTO `t_areas` VALUES ('250', '安平县', '053600', '1', '244', '250');
INSERT INTO `t_areas` VALUES ('251', '故城县', '053800', '1', '244', '251');
INSERT INTO `t_areas` VALUES ('252', '景县', '053500', '1', '244', '252');
INSERT INTO `t_areas` VALUES ('253', '阜城县', '053700', '1', '244', '253');
INSERT INTO `t_areas` VALUES ('254', '冀州市', '053200', '1', '244', '254');
INSERT INTO `t_areas` VALUES ('255', '深州市', '052800', '1', '244', '255');
INSERT INTO `t_areas` VALUES ('256', '太原市', '030000', '1', '5', '256');
INSERT INTO `t_areas` VALUES ('257', '小店区', '030000', '1', '256', '257');
INSERT INTO `t_areas` VALUES ('258', '迎泽区', '030000', '1', '256', '258');
INSERT INTO `t_areas` VALUES ('259', '杏花岭区', '030000', '1', '256', '259');
INSERT INTO `t_areas` VALUES ('260', '尖草坪区', '030000', '1', '256', '260');
INSERT INTO `t_areas` VALUES ('261', '万柏林区', '030000', '1', '256', '261');
INSERT INTO `t_areas` VALUES ('262', '晋源区', '030000', '1', '256', '262');
INSERT INTO `t_areas` VALUES ('263', '清徐县', '030400', '1', '256', '263');
INSERT INTO `t_areas` VALUES ('264', '阳曲县', '030100', '1', '256', '264');
INSERT INTO `t_areas` VALUES ('265', '娄烦县', '030300', '1', '256', '265');
INSERT INTO `t_areas` VALUES ('266', '古交市', '030200', '1', '256', '266');
INSERT INTO `t_areas` VALUES ('267', '大同市', '037000', '1', '5', '267');
INSERT INTO `t_areas` VALUES ('268', '城区', '037000', '1', '267', '268');
INSERT INTO `t_areas` VALUES ('269', '矿区', '037000', '1', '267', '269');
INSERT INTO `t_areas` VALUES ('270', '南郊区', '037000', '1', '267', '270');
INSERT INTO `t_areas` VALUES ('271', '新荣区', '037000', '1', '267', '271');
INSERT INTO `t_areas` VALUES ('272', '阳高县', '038100', '1', '267', '272');
INSERT INTO `t_areas` VALUES ('273', '天镇县', '038200', '1', '267', '273');
INSERT INTO `t_areas` VALUES ('274', '广灵县', '037500', '1', '267', '274');
INSERT INTO `t_areas` VALUES ('275', '灵丘县', '034400', '1', '267', '275');
INSERT INTO `t_areas` VALUES ('276', '浑源县', '037400', '1', '267', '276');
INSERT INTO `t_areas` VALUES ('277', '左云县', '037100', '1', '267', '277');
INSERT INTO `t_areas` VALUES ('278', '大同县', '037300', '1', '267', '278');
INSERT INTO `t_areas` VALUES ('279', '阳泉市', '045000', '1', '5', '279');
INSERT INTO `t_areas` VALUES ('280', '城区', '045000', '1', '279', '280');
INSERT INTO `t_areas` VALUES ('281', '矿区', '045000', '1', '279', '281');
INSERT INTO `t_areas` VALUES ('282', '郊区', '045000', '1', '279', '282');
INSERT INTO `t_areas` VALUES ('283', '平定县', '045200', '1', '279', '283');
INSERT INTO `t_areas` VALUES ('284', '盂县', '045100', '1', '279', '284');
INSERT INTO `t_areas` VALUES ('285', '长治市', '046000', '1', '5', '285');
INSERT INTO `t_areas` VALUES ('286', '城区', '046000', '1', '285', '286');
INSERT INTO `t_areas` VALUES ('287', '郊区', '046000', '1', '285', '287');
INSERT INTO `t_areas` VALUES ('288', '长治县', '046000', '1', '285', '288');
INSERT INTO `t_areas` VALUES ('289', '襄垣县', '046200', '1', '285', '289');
INSERT INTO `t_areas` VALUES ('290', '屯留县', '046100', '1', '285', '290');
INSERT INTO `t_areas` VALUES ('291', '平顺县', '047400', '1', '285', '291');
INSERT INTO `t_areas` VALUES ('292', '黎城县', '047600', '1', '285', '292');
INSERT INTO `t_areas` VALUES ('293', '壶关县', '047300', '1', '285', '293');
INSERT INTO `t_areas` VALUES ('294', '长子县', '046600', '1', '285', '294');
INSERT INTO `t_areas` VALUES ('295', '武乡县', '046300', '1', '285', '295');
INSERT INTO `t_areas` VALUES ('296', '沁县', '046400', '1', '285', '296');
INSERT INTO `t_areas` VALUES ('297', '沁源县', '046500', '1', '285', '297');
INSERT INTO `t_areas` VALUES ('298', '潞城市', '047500', '1', '285', '298');
INSERT INTO `t_areas` VALUES ('299', '晋城市', '048000', '1', '5', '299');
INSERT INTO `t_areas` VALUES ('300', '城区', '048000', '1', '299', '300');
INSERT INTO `t_areas` VALUES ('301', '沁水县', '048200', '1', '299', '301');
INSERT INTO `t_areas` VALUES ('302', '阳城县', '048100', '1', '299', '302');
INSERT INTO `t_areas` VALUES ('303', '陵川县', '048300', '1', '299', '303');
INSERT INTO `t_areas` VALUES ('304', '泽州县', '048000', '1', '299', '304');
INSERT INTO `t_areas` VALUES ('305', '高平市', '046700', '1', '299', '305');
INSERT INTO `t_areas` VALUES ('306', '朔州市', '038500', '1', '5', '306');
INSERT INTO `t_areas` VALUES ('307', '朔城区', '038500', '1', '306', '307');
INSERT INTO `t_areas` VALUES ('308', '平鲁区', '038500', '1', '306', '308');
INSERT INTO `t_areas` VALUES ('309', '山阴县', '038400', '1', '306', '309');
INSERT INTO `t_areas` VALUES ('310', '应县', '037600', '1', '306', '310');
INSERT INTO `t_areas` VALUES ('311', '右玉县', '037200', '1', '306', '311');
INSERT INTO `t_areas` VALUES ('312', '怀仁县', '038300', '1', '306', '312');
INSERT INTO `t_areas` VALUES ('313', '晋中市', '030600', '1', '5', '313');
INSERT INTO `t_areas` VALUES ('314', '榆次区', '030600', '1', '313', '314');
INSERT INTO `t_areas` VALUES ('315', '榆社县', '031800', '1', '313', '315');
INSERT INTO `t_areas` VALUES ('316', '左权县', '032600', '1', '313', '316');
INSERT INTO `t_areas` VALUES ('317', '和顺县', '032700', '1', '313', '317');
INSERT INTO `t_areas` VALUES ('318', '昔阳县', '045300', '1', '313', '318');
INSERT INTO `t_areas` VALUES ('319', '寿阳县', '031700', '1', '313', '319');
INSERT INTO `t_areas` VALUES ('320', '太谷县', '030800', '1', '313', '320');
INSERT INTO `t_areas` VALUES ('321', '祁县', '030900', '1', '313', '321');
INSERT INTO `t_areas` VALUES ('322', '平遥县', '031100', '1', '313', '322');
INSERT INTO `t_areas` VALUES ('323', '灵石县', '031300', '1', '313', '323');
INSERT INTO `t_areas` VALUES ('324', '介休市', '031200', '1', '313', '324');
INSERT INTO `t_areas` VALUES ('325', '运城市', '044000', '1', '5', '325');
INSERT INTO `t_areas` VALUES ('326', '盐湖区', '044000', '1', '325', '326');
INSERT INTO `t_areas` VALUES ('327', '临猗县', '044100', '1', '325', '327');
INSERT INTO `t_areas` VALUES ('328', '万荣县', '044200', '1', '325', '328');
INSERT INTO `t_areas` VALUES ('329', '闻喜县', '043800', '1', '325', '329');
INSERT INTO `t_areas` VALUES ('330', '稷山县', '043200', '1', '325', '330');
INSERT INTO `t_areas` VALUES ('331', '新绛县', '043100', '1', '325', '331');
INSERT INTO `t_areas` VALUES ('332', '绛县', '043600', '1', '325', '332');
INSERT INTO `t_areas` VALUES ('333', '垣曲县', '043700', '1', '325', '333');
INSERT INTO `t_areas` VALUES ('334', '夏县', '044400', '1', '325', '334');
INSERT INTO `t_areas` VALUES ('335', '平陆县', '044300', '1', '325', '335');
INSERT INTO `t_areas` VALUES ('336', '芮城县', '044600', '1', '325', '336');
INSERT INTO `t_areas` VALUES ('337', '永济市', '044500', '1', '325', '337');
INSERT INTO `t_areas` VALUES ('338', '河津市', '043300', '1', '325', '338');
INSERT INTO `t_areas` VALUES ('339', '忻州市', '034000', '1', '5', '339');
INSERT INTO `t_areas` VALUES ('340', '忻府区', '034000', '1', '339', '340');
INSERT INTO `t_areas` VALUES ('341', '定襄县', '035400', '1', '339', '341');
INSERT INTO `t_areas` VALUES ('342', '五台县', '035500', '1', '339', '342');
INSERT INTO `t_areas` VALUES ('343', '代县', '034200', '1', '339', '343');
INSERT INTO `t_areas` VALUES ('344', '繁峙县', '034300', '1', '339', '344');
INSERT INTO `t_areas` VALUES ('345', '宁武县', '036000', '1', '339', '345');
INSERT INTO `t_areas` VALUES ('346', '静乐县', '035100', '1', '339', '346');
INSERT INTO `t_areas` VALUES ('347', '神池县', '036100', '1', '339', '347');
INSERT INTO `t_areas` VALUES ('348', '五寨县', '036200', '1', '339', '348');
INSERT INTO `t_areas` VALUES ('349', '岢岚县', '036300', '1', '339', '349');
INSERT INTO `t_areas` VALUES ('350', '河曲县', '036500', '1', '339', '350');
INSERT INTO `t_areas` VALUES ('351', '保德县', '036600', '1', '339', '351');
INSERT INTO `t_areas` VALUES ('352', '偏关县', '036400', '1', '339', '352');
INSERT INTO `t_areas` VALUES ('353', '原平市', '034100', '1', '339', '353');
INSERT INTO `t_areas` VALUES ('354', '临汾市', '041000', '1', '5', '354');
INSERT INTO `t_areas` VALUES ('355', '尧都区', '041000', '1', '354', '355');
INSERT INTO `t_areas` VALUES ('356', '曲沃县', '043400', '1', '354', '356');
INSERT INTO `t_areas` VALUES ('357', '翼城县', '043500', '1', '354', '357');
INSERT INTO `t_areas` VALUES ('358', '襄汾县', '041500', '1', '354', '358');
INSERT INTO `t_areas` VALUES ('359', '洪洞县', '031600', '1', '354', '359');
INSERT INTO `t_areas` VALUES ('360', '古县', '042400', '1', '354', '360');
INSERT INTO `t_areas` VALUES ('361', '安泽县', '042500', '1', '354', '361');
INSERT INTO `t_areas` VALUES ('362', '浮山县', '042600', '1', '354', '362');
INSERT INTO `t_areas` VALUES ('363', '吉县', '042200', '1', '354', '363');
INSERT INTO `t_areas` VALUES ('364', '乡宁县', '042100', '1', '354', '364');
INSERT INTO `t_areas` VALUES ('365', '大宁县', '042300', '1', '354', '365');
INSERT INTO `t_areas` VALUES ('366', '隰县', '041300', '1', '354', '366');
INSERT INTO `t_areas` VALUES ('367', '永和县', '041400', '1', '354', '367');
INSERT INTO `t_areas` VALUES ('368', '蒲县', '041200', '1', '354', '368');
INSERT INTO `t_areas` VALUES ('369', '汾西县', '031500', '1', '354', '369');
INSERT INTO `t_areas` VALUES ('370', '侯马市', '043000', '1', '354', '370');
INSERT INTO `t_areas` VALUES ('371', '霍州市', '031400', '1', '354', '371');
INSERT INTO `t_areas` VALUES ('372', '吕梁市', '033000', '1', '5', '372');
INSERT INTO `t_areas` VALUES ('373', '离石区', '033000', '1', '372', '373');
INSERT INTO `t_areas` VALUES ('374', '文水县', '032100', '1', '372', '374');
INSERT INTO `t_areas` VALUES ('375', '交城县', '030500', '1', '372', '375');
INSERT INTO `t_areas` VALUES ('376', '兴县', '035300', '1', '372', '376');
INSERT INTO `t_areas` VALUES ('377', '临县', '033200', '1', '372', '377');
INSERT INTO `t_areas` VALUES ('378', '柳林县', '033300', '1', '372', '378');
INSERT INTO `t_areas` VALUES ('379', '石楼县', '032500', '1', '372', '379');
INSERT INTO `t_areas` VALUES ('380', '岚县', '035200', '1', '372', '380');
INSERT INTO `t_areas` VALUES ('381', '方山县', '033100', '1', '372', '381');
INSERT INTO `t_areas` VALUES ('382', '中阳县', '033400', '1', '372', '382');
INSERT INTO `t_areas` VALUES ('383', '交口县', '032400', '1', '372', '383');
INSERT INTO `t_areas` VALUES ('384', '孝义市', '032300', '1', '372', '384');
INSERT INTO `t_areas` VALUES ('385', '汾阳市', '032200', '1', '372', '385');
INSERT INTO `t_areas` VALUES ('386', '呼和浩特市', '010000', '1', '6', '386');
INSERT INTO `t_areas` VALUES ('387', '新城区', '010000', '1', '386', '387');
INSERT INTO `t_areas` VALUES ('388', '回民区', '010000', '1', '386', '388');
INSERT INTO `t_areas` VALUES ('389', '玉泉区', '010000', '1', '386', '389');
INSERT INTO `t_areas` VALUES ('390', '赛罕区', '010000', '1', '386', '390');
INSERT INTO `t_areas` VALUES ('391', '土默特左旗', '010100', '1', '386', '391');
INSERT INTO `t_areas` VALUES ('392', '托克托县', '010200', '1', '386', '392');
INSERT INTO `t_areas` VALUES ('393', '和林格尔县', '011500', '1', '386', '393');
INSERT INTO `t_areas` VALUES ('394', '清水河县', '011600', '1', '386', '394');
INSERT INTO `t_areas` VALUES ('395', '武川县', '011700', '1', '386', '395');
INSERT INTO `t_areas` VALUES ('396', '包头市', '014000', '1', '6', '396');
INSERT INTO `t_areas` VALUES ('397', '东河区', '014000', '1', '396', '397');
INSERT INTO `t_areas` VALUES ('398', '昆都仑区', '014000', '1', '396', '398');
INSERT INTO `t_areas` VALUES ('399', '青山区', '014000', '1', '396', '399');
INSERT INTO `t_areas` VALUES ('400', '石拐区', '014000', '1', '396', '400');
INSERT INTO `t_areas` VALUES ('401', '白云矿区', '014000', '1', '396', '401');
INSERT INTO `t_areas` VALUES ('402', '九原区', '014000', '1', '396', '402');
INSERT INTO `t_areas` VALUES ('403', '土默特右旗', '014100', '1', '396', '403');
INSERT INTO `t_areas` VALUES ('404', '固阳县', '014200', '1', '396', '404');
INSERT INTO `t_areas` VALUES ('405', '达尔罕茂明安联合旗', '014500', '1', '396', '405');
INSERT INTO `t_areas` VALUES ('406', '乌海市', '016000', '1', '6', '406');
INSERT INTO `t_areas` VALUES ('407', '海勃湾区', '016000', '1', '406', '407');
INSERT INTO `t_areas` VALUES ('408', '海南区', '016000', '1', '406', '408');
INSERT INTO `t_areas` VALUES ('409', '乌达区', '016000', '1', '406', '409');
INSERT INTO `t_areas` VALUES ('410', '赤峰市', '024000', '1', '6', '410');
INSERT INTO `t_areas` VALUES ('411', '红山区', '024000', '1', '410', '411');
INSERT INTO `t_areas` VALUES ('412', '元宝山区', '024000', '1', '410', '412');
INSERT INTO `t_areas` VALUES ('413', '松山区', '024000', '1', '410', '413');
INSERT INTO `t_areas` VALUES ('414', '阿鲁科尔沁旗', '025500', '1', '410', '414');
INSERT INTO `t_areas` VALUES ('415', '巴林左旗', '025450', '1', '410', '415');
INSERT INTO `t_areas` VALUES ('416', '巴林右旗', '025150', '1', '410', '416');
INSERT INTO `t_areas` VALUES ('417', '林西县', '025250', '1', '410', '417');
INSERT INTO `t_areas` VALUES ('418', '克什克腾旗', '025350', '1', '410', '418');
INSERT INTO `t_areas` VALUES ('419', '翁牛特旗', '024500', '1', '410', '419');
INSERT INTO `t_areas` VALUES ('420', '喀喇沁旗', '024400', '1', '410', '420');
INSERT INTO `t_areas` VALUES ('421', '宁城县', '024200', '1', '410', '421');
INSERT INTO `t_areas` VALUES ('422', '敖汉旗', '024300', '1', '410', '422');
INSERT INTO `t_areas` VALUES ('423', '通辽市', '028000', '1', '6', '423');
INSERT INTO `t_areas` VALUES ('424', '科尔沁区', '028000', '1', '423', '424');
INSERT INTO `t_areas` VALUES ('425', '科尔沁左翼中旗', '029300', '1', '423', '425');
INSERT INTO `t_areas` VALUES ('426', '科尔沁左翼后旗', '028100', '1', '423', '426');
INSERT INTO `t_areas` VALUES ('427', '开鲁县', '028400', '1', '423', '427');
INSERT INTO `t_areas` VALUES ('428', '库伦旗', '028200', '1', '423', '428');
INSERT INTO `t_areas` VALUES ('429', '奈曼旗', '028300', '1', '423', '429');
INSERT INTO `t_areas` VALUES ('430', '扎鲁特旗', '029100', '1', '423', '430');
INSERT INTO `t_areas` VALUES ('431', '霍林郭勒市', '029200', '1', '423', '431');
INSERT INTO `t_areas` VALUES ('432', '鄂尔多斯市', '017000', '1', '6', '432');
INSERT INTO `t_areas` VALUES ('433', '东胜区', '017000', '1', '432', '433');
INSERT INTO `t_areas` VALUES ('434', '达拉特旗', '014300', '1', '432', '434');
INSERT INTO `t_areas` VALUES ('435', '准格尔旗', '017100', '1', '432', '435');
INSERT INTO `t_areas` VALUES ('436', '鄂托克前旗', '016200', '1', '432', '436');
INSERT INTO `t_areas` VALUES ('437', '鄂托克旗', '016100', '1', '432', '437');
INSERT INTO `t_areas` VALUES ('438', '杭锦旗', '017400', '1', '432', '438');
INSERT INTO `t_areas` VALUES ('439', '乌审旗', '017300', '1', '432', '439');
INSERT INTO `t_areas` VALUES ('440', '伊金霍洛旗', '017200', '1', '432', '440');
INSERT INTO `t_areas` VALUES ('441', '呼伦贝尔市', '021000', '1', '6', '441');
INSERT INTO `t_areas` VALUES ('442', '海拉尔区', '021000', '1', '441', '442');
INSERT INTO `t_areas` VALUES ('443', '阿荣旗', '162750', '1', '441', '443');
INSERT INTO `t_areas` VALUES ('444', '莫力达瓦达斡尔族自治旗', '162850', '1', '441', '444');
INSERT INTO `t_areas` VALUES ('445', '鄂伦春自治旗', '022450', '1', '441', '445');
INSERT INTO `t_areas` VALUES ('446', '鄂温克族自治旗', '021100', '1', '441', '446');
INSERT INTO `t_areas` VALUES ('447', '陈巴尔虎旗', '021500', '1', '441', '447');
INSERT INTO `t_areas` VALUES ('448', '新巴尔虎左旗', '021200', '1', '441', '448');
INSERT INTO `t_areas` VALUES ('449', '新巴尔虎右旗', '021300', '1', '441', '449');
INSERT INTO `t_areas` VALUES ('450', '满洲里市', '021400', '1', '441', '450');
INSERT INTO `t_areas` VALUES ('451', '牙克石市', '022150', '1', '441', '451');
INSERT INTO `t_areas` VALUES ('452', '扎兰屯市', '162650', '1', '441', '452');
INSERT INTO `t_areas` VALUES ('453', '额尔古纳市', '022250', '1', '441', '453');
INSERT INTO `t_areas` VALUES ('454', '根河市', '022350', '1', '441', '454');
INSERT INTO `t_areas` VALUES ('455', '巴彦淖尔市', '015000', '1', '6', '455');
INSERT INTO `t_areas` VALUES ('456', '临河区', '015000', '1', '455', '456');
INSERT INTO `t_areas` VALUES ('457', '五原县', '015100', '1', '455', '457');
INSERT INTO `t_areas` VALUES ('458', '磴口县', '015200', '1', '455', '458');
INSERT INTO `t_areas` VALUES ('459', '乌拉特前旗', '014400', '1', '455', '459');
INSERT INTO `t_areas` VALUES ('460', '乌拉特中旗', '015300', '1', '455', '460');
INSERT INTO `t_areas` VALUES ('461', '乌拉特后旗', '015500', '1', '455', '461');
INSERT INTO `t_areas` VALUES ('462', '杭锦后旗', '015400', '1', '455', '462');
INSERT INTO `t_areas` VALUES ('463', '乌兰察布市', '012000', '1', '6', '463');
INSERT INTO `t_areas` VALUES ('464', '集宁区', '012000', '1', '463', '464');
INSERT INTO `t_areas` VALUES ('465', '卓资县', '012300', '1', '463', '465');
INSERT INTO `t_areas` VALUES ('466', '化德县', '013350', '1', '463', '466');
INSERT INTO `t_areas` VALUES ('467', '商都县', '013400', '1', '463', '467');
INSERT INTO `t_areas` VALUES ('468', '兴和县', '013650', '1', '463', '468');
INSERT INTO `t_areas` VALUES ('469', '凉城县', '013750', '1', '463', '469');
INSERT INTO `t_areas` VALUES ('470', '察哈尔右翼前旗', '012200', '1', '463', '470');
INSERT INTO `t_areas` VALUES ('471', '察哈尔右翼中旗', '013500', '1', '463', '471');
INSERT INTO `t_areas` VALUES ('472', '察哈尔右翼后旗', '012400', '1', '463', '472');
INSERT INTO `t_areas` VALUES ('473', '四子王旗', '011800', '1', '463', '473');
INSERT INTO `t_areas` VALUES ('474', '丰镇市', '012100', '1', '463', '474');
INSERT INTO `t_areas` VALUES ('475', '兴安盟', '137400', '1', '6', '475');
INSERT INTO `t_areas` VALUES ('476', '乌兰浩特市', '137400', '1', '475', '476');
INSERT INTO `t_areas` VALUES ('477', '阿尔山市', '137400', '1', '475', '477');
INSERT INTO `t_areas` VALUES ('478', '科尔沁右翼前旗', '137400', '1', '475', '478');
INSERT INTO `t_areas` VALUES ('479', '科尔沁右翼中旗', '029400', '1', '475', '479');
INSERT INTO `t_areas` VALUES ('480', '扎赉特旗', '137600', '1', '475', '480');
INSERT INTO `t_areas` VALUES ('481', '突泉县', '137500', '1', '475', '481');
INSERT INTO `t_areas` VALUES ('482', '锡林郭勒盟', '026000', '1', '6', '482');
INSERT INTO `t_areas` VALUES ('483', '二连浩特市', '012600', '1', '482', '483');
INSERT INTO `t_areas` VALUES ('484', '锡林浩特市', '026000', '1', '482', '484');
INSERT INTO `t_areas` VALUES ('485', '阿巴嘎旗', '011400', '1', '482', '485');
INSERT INTO `t_areas` VALUES ('486', '苏尼特左旗', '011300', '1', '482', '486');
INSERT INTO `t_areas` VALUES ('487', '苏尼特右旗', '011200', '1', '482', '487');
INSERT INTO `t_areas` VALUES ('488', '东乌珠穆沁旗', '026300', '1', '482', '488');
INSERT INTO `t_areas` VALUES ('489', '西乌珠穆沁旗', '026200', '1', '482', '489');
INSERT INTO `t_areas` VALUES ('490', '太仆寺旗', '027000', '1', '482', '490');
INSERT INTO `t_areas` VALUES ('491', '镶黄旗', '013250', '1', '482', '491');
INSERT INTO `t_areas` VALUES ('492', '正镶白旗', '013800', '1', '482', '492');
INSERT INTO `t_areas` VALUES ('493', '正蓝旗', '027200', '1', '482', '493');
INSERT INTO `t_areas` VALUES ('494', '多伦县', '027300', '1', '482', '494');
INSERT INTO `t_areas` VALUES ('495', '阿拉善盟', '750306', '1', '6', '495');
INSERT INTO `t_areas` VALUES ('496', '阿拉善左旗', '750300', '1', '495', '496');
INSERT INTO `t_areas` VALUES ('497', '阿拉善右旗', '737300', '1', '495', '497');
INSERT INTO `t_areas` VALUES ('498', '额济纳旗', '735400', '1', '495', '498');
INSERT INTO `t_areas` VALUES ('499', '沈阳市', '110000', '1', '7', '499');
INSERT INTO `t_areas` VALUES ('500', '和平区', '110000', '1', '499', '500');
INSERT INTO `t_areas` VALUES ('501', '沈河区', '110000', '1', '499', '501');
INSERT INTO `t_areas` VALUES ('502', '大东区', '110000', '1', '499', '502');
INSERT INTO `t_areas` VALUES ('503', '皇姑区', '110000', '1', '499', '503');
INSERT INTO `t_areas` VALUES ('504', '铁西区', '110020', '1', '499', '504');
INSERT INTO `t_areas` VALUES ('505', '苏家屯区', '110100', '1', '499', '505');
INSERT INTO `t_areas` VALUES ('506', '东陵区', '110000', '1', '499', '506');
INSERT INTO `t_areas` VALUES ('507', '沈北新区', '110000', '1', '499', '507');
INSERT INTO `t_areas` VALUES ('508', '于洪区', '110000', '1', '499', '508');
INSERT INTO `t_areas` VALUES ('509', '辽中县', '110200', '1', '499', '509');
INSERT INTO `t_areas` VALUES ('510', '康平县', '110500', '1', '499', '510');
INSERT INTO `t_areas` VALUES ('511', '法库县', '110400', '1', '499', '511');
INSERT INTO `t_areas` VALUES ('512', '新民市', '110300', '1', '499', '512');
INSERT INTO `t_areas` VALUES ('513', '大连市', '116000', '1', '7', '513');
INSERT INTO `t_areas` VALUES ('514', '中山区', '116000', '1', '513', '514');
INSERT INTO `t_areas` VALUES ('515', '西岗区', '116000', '1', '513', '515');
INSERT INTO `t_areas` VALUES ('516', '沙河口区', '116000', '1', '513', '516');
INSERT INTO `t_areas` VALUES ('517', '甘井子区', '116000', '1', '513', '517');
INSERT INTO `t_areas` VALUES ('518', '旅顺口区', '116000', '1', '513', '518');
INSERT INTO `t_areas` VALUES ('519', '金州区', '116000', '1', '513', '519');
INSERT INTO `t_areas` VALUES ('520', '长海县', '116500', '1', '513', '520');
INSERT INTO `t_areas` VALUES ('521', '瓦房店市', '116300', '1', '513', '521');
INSERT INTO `t_areas` VALUES ('522', '普兰店市', '116200', '1', '513', '522');
INSERT INTO `t_areas` VALUES ('523', '庄河市', '116400', '1', '513', '523');
INSERT INTO `t_areas` VALUES ('524', '鞍山市', '114000', '1', '7', '524');
INSERT INTO `t_areas` VALUES ('525', '铁东区', '114000', '1', '524', '525');
INSERT INTO `t_areas` VALUES ('526', '铁西区', '114000', '1', '524', '526');
INSERT INTO `t_areas` VALUES ('527', '立山区', '114000', '1', '524', '527');
INSERT INTO `t_areas` VALUES ('528', '千山区', '114000', '1', '524', '528');
INSERT INTO `t_areas` VALUES ('529', '台安县', '114100', '1', '524', '529');
INSERT INTO `t_areas` VALUES ('530', '岫岩满族自治县', '118400', '1', '524', '530');
INSERT INTO `t_areas` VALUES ('531', '海城市', '114200', '1', '524', '531');
INSERT INTO `t_areas` VALUES ('532', '抚顺市', '113000', '1', '7', '532');
INSERT INTO `t_areas` VALUES ('533', '新抚区', '113000', '1', '532', '533');
INSERT INTO `t_areas` VALUES ('534', '东洲区', '113000', '1', '532', '534');
INSERT INTO `t_areas` VALUES ('535', '望花区', '113000', '1', '532', '535');
INSERT INTO `t_areas` VALUES ('536', '顺城区', '113000', '1', '532', '536');
INSERT INTO `t_areas` VALUES ('537', '抚顺县', '113100', '1', '532', '537');
INSERT INTO `t_areas` VALUES ('538', '新宾满族自治县', '113200', '1', '532', '538');
INSERT INTO `t_areas` VALUES ('539', '清原满族自治县', '113300', '1', '532', '539');
INSERT INTO `t_areas` VALUES ('540', '本溪市', '117000', '1', '7', '540');
INSERT INTO `t_areas` VALUES ('541', '平山区', '117000', '1', '540', '541');
INSERT INTO `t_areas` VALUES ('542', '溪湖区', '117000', '1', '540', '542');
INSERT INTO `t_areas` VALUES ('543', '明山区', '117000', '1', '540', '543');
INSERT INTO `t_areas` VALUES ('544', '南芬区', '117000', '1', '540', '544');
INSERT INTO `t_areas` VALUES ('545', '本溪满族自治县', '117100', '1', '540', '545');
INSERT INTO `t_areas` VALUES ('546', '桓仁满族自治县', '117200', '1', '540', '546');
INSERT INTO `t_areas` VALUES ('547', '丹东市', '118000', '1', '7', '547');
INSERT INTO `t_areas` VALUES ('548', '元宝区', '118000', '1', '547', '548');
INSERT INTO `t_areas` VALUES ('549', '振兴区', '118000', '1', '547', '549');
INSERT INTO `t_areas` VALUES ('550', '振安区', '118000', '1', '547', '550');
INSERT INTO `t_areas` VALUES ('551', '宽甸满族自治县', '118200', '1', '547', '551');
INSERT INTO `t_areas` VALUES ('552', '东港市', '118300', '1', '547', '552');
INSERT INTO `t_areas` VALUES ('553', '凤城市', '118100', '1', '547', '553');
INSERT INTO `t_areas` VALUES ('554', '锦州市', '121000', '1', '7', '554');
INSERT INTO `t_areas` VALUES ('555', '古塔区', '121000', '1', '554', '555');
INSERT INTO `t_areas` VALUES ('556', '凌河区', '121000', '1', '554', '556');
INSERT INTO `t_areas` VALUES ('557', '太和区', '121000', '1', '554', '557');
INSERT INTO `t_areas` VALUES ('558', '黑山县', '121400', '1', '554', '558');
INSERT INTO `t_areas` VALUES ('559', '义县', '121100', '1', '554', '559');
INSERT INTO `t_areas` VALUES ('560', '凌海市', '121200', '1', '554', '560');
INSERT INTO `t_areas` VALUES ('561', '北镇市', '121300', '1', '554', '561');
INSERT INTO `t_areas` VALUES ('562', '营口市', '115000', '1', '7', '562');
INSERT INTO `t_areas` VALUES ('563', '站前区', '115000', '1', '562', '563');
INSERT INTO `t_areas` VALUES ('564', '西市区', '115000', '1', '562', '564');
INSERT INTO `t_areas` VALUES ('565', '鲅鱼圈区', '115000', '1', '562', '565');
INSERT INTO `t_areas` VALUES ('566', '老边区', '115000', '1', '562', '566');
INSERT INTO `t_areas` VALUES ('567', '盖州市', '115200', '1', '562', '567');
INSERT INTO `t_areas` VALUES ('568', '大石桥市', '115100', '1', '562', '568');
INSERT INTO `t_areas` VALUES ('569', '阜新市', '123000', '1', '7', '569');
INSERT INTO `t_areas` VALUES ('570', '海州区', '123000', '1', '569', '570');
INSERT INTO `t_areas` VALUES ('571', '新邱区', '123000', '1', '569', '571');
INSERT INTO `t_areas` VALUES ('572', '太平区', '123000', '1', '569', '572');
INSERT INTO `t_areas` VALUES ('573', '清河门区', '123000', '1', '569', '573');
INSERT INTO `t_areas` VALUES ('574', '细河区', '123000', '1', '569', '574');
INSERT INTO `t_areas` VALUES ('575', '阜新蒙古族自治县', '123100', '1', '569', '575');
INSERT INTO `t_areas` VALUES ('576', '彰武县', '123200', '1', '569', '576');
INSERT INTO `t_areas` VALUES ('577', '辽阳市', '111000', '1', '7', '577');
INSERT INTO `t_areas` VALUES ('578', '白塔区', '111000', '1', '577', '578');
INSERT INTO `t_areas` VALUES ('579', '文圣区', '111000', '1', '577', '579');
INSERT INTO `t_areas` VALUES ('580', '宏伟区', '111000', '1', '577', '580');
INSERT INTO `t_areas` VALUES ('581', '弓长岭区', '111000', '1', '577', '581');
INSERT INTO `t_areas` VALUES ('582', '太子河区', '111000', '1', '577', '582');
INSERT INTO `t_areas` VALUES ('583', '辽阳县', '111200', '1', '577', '583');
INSERT INTO `t_areas` VALUES ('584', '灯塔市', '111300', '1', '577', '584');
INSERT INTO `t_areas` VALUES ('585', '盘锦市', '124000', '1', '7', '585');
INSERT INTO `t_areas` VALUES ('586', '双台子区', '124000', '1', '585', '586');
INSERT INTO `t_areas` VALUES ('587', '兴隆台区', '124000', '1', '585', '587');
INSERT INTO `t_areas` VALUES ('588', '大洼县', '124200', '1', '585', '588');
INSERT INTO `t_areas` VALUES ('589', '盘山县', '124100', '1', '585', '589');
INSERT INTO `t_areas` VALUES ('590', '铁岭市', '112000', '1', '7', '590');
INSERT INTO `t_areas` VALUES ('591', '银州区', '112000', '1', '590', '591');
INSERT INTO `t_areas` VALUES ('592', '清河区', '112000', '1', '590', '592');
INSERT INTO `t_areas` VALUES ('593', '铁岭县', '112600', '1', '590', '593');
INSERT INTO `t_areas` VALUES ('594', '西丰县', '112400', '1', '590', '594');
INSERT INTO `t_areas` VALUES ('595', '昌图县', '112500', '1', '590', '595');
INSERT INTO `t_areas` VALUES ('596', '调兵山市', '112700', '1', '590', '596');
INSERT INTO `t_areas` VALUES ('597', '开原市', '112300', '1', '590', '597');
INSERT INTO `t_areas` VALUES ('598', '朝阳市', '122000', '1', '7', '598');
INSERT INTO `t_areas` VALUES ('599', '双塔区', '122000', '1', '598', '599');
INSERT INTO `t_areas` VALUES ('600', '龙城区', '122000', '1', '598', '600');
INSERT INTO `t_areas` VALUES ('601', '朝阳县', '122000', '1', '598', '601');
INSERT INTO `t_areas` VALUES ('602', '建平县', '122400', '1', '598', '602');
INSERT INTO `t_areas` VALUES ('603', '喀喇沁左翼蒙古族自治县', '122300', '1', '598', '603');
INSERT INTO `t_areas` VALUES ('604', '北票市', '122100', '1', '598', '604');
INSERT INTO `t_areas` VALUES ('605', '凌源市', '122500', '1', '598', '605');
INSERT INTO `t_areas` VALUES ('606', '葫芦岛市', '125000', '1', '7', '606');
INSERT INTO `t_areas` VALUES ('607', '连山区', '125000', '1', '606', '607');
INSERT INTO `t_areas` VALUES ('608', '龙港区', '125000', '1', '606', '608');
INSERT INTO `t_areas` VALUES ('609', '南票区', '125000', '1', '606', '609');
INSERT INTO `t_areas` VALUES ('610', '绥中县', '125200', '1', '606', '610');
INSERT INTO `t_areas` VALUES ('611', '建昌县', '125300', '1', '606', '611');
INSERT INTO `t_areas` VALUES ('612', '兴城市', '125100', '1', '606', '612');
INSERT INTO `t_areas` VALUES ('613', '长春市', '130000', '1', '8', '613');
INSERT INTO `t_areas` VALUES ('614', '南关区', '130000', '1', '613', '614');
INSERT INTO `t_areas` VALUES ('615', '宽城区', '130000', '1', '613', '615');
INSERT INTO `t_areas` VALUES ('616', '朝阳区', '130000', '1', '613', '616');
INSERT INTO `t_areas` VALUES ('617', '二道区', '130000', '1', '613', '617');
INSERT INTO `t_areas` VALUES ('618', '绿园区', '130000', '1', '613', '618');
INSERT INTO `t_areas` VALUES ('619', '双阳区', '130600', '1', '613', '619');
INSERT INTO `t_areas` VALUES ('620', '农安县', '130200', '1', '613', '620');
INSERT INTO `t_areas` VALUES ('621', '九台市', '130500', '1', '613', '621');
INSERT INTO `t_areas` VALUES ('622', '榆树市', '130400', '1', '613', '622');
INSERT INTO `t_areas` VALUES ('623', '德惠市', '130300', '1', '613', '623');
INSERT INTO `t_areas` VALUES ('624', '吉林市', '132000', '1', '8', '624');
INSERT INTO `t_areas` VALUES ('625', '昌邑区', '132000', '1', '624', '625');
INSERT INTO `t_areas` VALUES ('626', '龙潭区', '132000', '1', '624', '626');
INSERT INTO `t_areas` VALUES ('627', '船营区', '132000', '1', '624', '627');
INSERT INTO `t_areas` VALUES ('628', '丰满区', '132000', '1', '624', '628');
INSERT INTO `t_areas` VALUES ('629', '永吉县', '132100', '1', '624', '629');
INSERT INTO `t_areas` VALUES ('630', '蛟河市', '132500', '1', '624', '630');
INSERT INTO `t_areas` VALUES ('631', '桦甸市', '132400', '1', '624', '631');
INSERT INTO `t_areas` VALUES ('632', '舒兰市', '132600', '1', '624', '632');
INSERT INTO `t_areas` VALUES ('633', '磐石市', '132300', '1', '624', '633');
INSERT INTO `t_areas` VALUES ('634', '四平市', '136000', '1', '8', '634');
INSERT INTO `t_areas` VALUES ('635', '铁西区', '136000', '1', '634', '635');
INSERT INTO `t_areas` VALUES ('636', '铁东区', '136000', '1', '634', '636');
INSERT INTO `t_areas` VALUES ('637', '梨树县', '136500', '1', '634', '637');
INSERT INTO `t_areas` VALUES ('638', '伊通满族自治县', '130700', '1', '634', '638');
INSERT INTO `t_areas` VALUES ('639', '公主岭市', '136100', '1', '634', '639');
INSERT INTO `t_areas` VALUES ('640', '双辽市', '136400', '1', '634', '640');
INSERT INTO `t_areas` VALUES ('641', '辽源市', '136200', '1', '8', '641');
INSERT INTO `t_areas` VALUES ('642', '龙山区', '136200', '1', '641', '642');
INSERT INTO `t_areas` VALUES ('643', '西安区', '136200', '1', '641', '643');
INSERT INTO `t_areas` VALUES ('644', '东丰县', '136300', '1', '641', '644');
INSERT INTO `t_areas` VALUES ('645', '东辽县', '136600', '1', '641', '645');
INSERT INTO `t_areas` VALUES ('646', '通化市', '134000', '1', '8', '646');
INSERT INTO `t_areas` VALUES ('647', '东昌区', '134000', '1', '646', '647');
INSERT INTO `t_areas` VALUES ('648', '二道江区', '134000', '1', '646', '648');
INSERT INTO `t_areas` VALUES ('649', '通化县', '134100', '1', '646', '649');
INSERT INTO `t_areas` VALUES ('650', '辉南县', '135100', '1', '646', '650');
INSERT INTO `t_areas` VALUES ('651', '柳河县', '135300', '1', '646', '651');
INSERT INTO `t_areas` VALUES ('652', '梅河口市', '135000', '1', '646', '652');
INSERT INTO `t_areas` VALUES ('653', '集安市', '134200', '1', '646', '653');
INSERT INTO `t_areas` VALUES ('654', '白山市', '134300', '1', '8', '654');
INSERT INTO `t_areas` VALUES ('655', '八道江区', '134300', '1', '654', '655');
INSERT INTO `t_areas` VALUES ('656', '江源区', '134700', '1', '654', '656');
INSERT INTO `t_areas` VALUES ('657', '抚松县', '134500', '1', '654', '657');
INSERT INTO `t_areas` VALUES ('658', '靖宇县', '135200', '1', '654', '658');
INSERT INTO `t_areas` VALUES ('659', '长白朝鲜族自治县', '134400', '1', '654', '659');
INSERT INTO `t_areas` VALUES ('660', '临江市', '134600', '1', '654', '660');
INSERT INTO `t_areas` VALUES ('661', '松原市', '138000', '1', '8', '661');
INSERT INTO `t_areas` VALUES ('662', '宁江区', '138000', '1', '661', '662');
INSERT INTO `t_areas` VALUES ('663', '前郭尔罗斯蒙古族自治县', '131100', '1', '661', '663');
INSERT INTO `t_areas` VALUES ('664', '长岭县', '131500', '1', '661', '664');
INSERT INTO `t_areas` VALUES ('665', '乾安县', '131400', '1', '661', '665');
INSERT INTO `t_areas` VALUES ('666', '扶余县', '131200', '1', '661', '666');
INSERT INTO `t_areas` VALUES ('667', '白城市', '137000', '1', '8', '667');
INSERT INTO `t_areas` VALUES ('668', '洮北区', '137000', '1', '667', '668');
INSERT INTO `t_areas` VALUES ('669', '镇赉县', '137300', '1', '667', '669');
INSERT INTO `t_areas` VALUES ('670', '通榆县', '137200', '1', '667', '670');
INSERT INTO `t_areas` VALUES ('671', '洮南市', '137100', '1', '667', '671');
INSERT INTO `t_areas` VALUES ('672', '大安市', '131300', '1', '667', '672');
INSERT INTO `t_areas` VALUES ('673', '延边朝鲜族自治州', '133000', '1', '8', '673');
INSERT INTO `t_areas` VALUES ('674', '延吉市', '133000', '1', '673', '674');
INSERT INTO `t_areas` VALUES ('675', '图们市', '133100', '1', '673', '675');
INSERT INTO `t_areas` VALUES ('676', '敦化市', '133700', '1', '673', '676');
INSERT INTO `t_areas` VALUES ('677', '珲春市', '133300', '1', '673', '677');
INSERT INTO `t_areas` VALUES ('678', '龙井市', '133400', '1', '673', '678');
INSERT INTO `t_areas` VALUES ('679', '和龙市', '133500', '1', '673', '679');
INSERT INTO `t_areas` VALUES ('680', '汪清县', '133200', '1', '673', '680');
INSERT INTO `t_areas` VALUES ('681', '安图县', '133600', '1', '673', '681');
INSERT INTO `t_areas` VALUES ('682', '哈尔滨市', '150000', '1', '9', '682');
INSERT INTO `t_areas` VALUES ('683', '道里区', '150000', '1', '682', '683');
INSERT INTO `t_areas` VALUES ('684', '南岗区', '150000', '1', '682', '684');
INSERT INTO `t_areas` VALUES ('685', '道外区', '150000', '1', '682', '685');
INSERT INTO `t_areas` VALUES ('686', '平房区', '150000', '1', '682', '686');
INSERT INTO `t_areas` VALUES ('687', '松北区', '150000', '1', '682', '687');
INSERT INTO `t_areas` VALUES ('688', '香坊区', '150036', '1', '682', '688');
INSERT INTO `t_areas` VALUES ('689', '呼兰区', '150500', '1', '682', '689');
INSERT INTO `t_areas` VALUES ('690', '阿城区', '150300', '1', '682', '690');
INSERT INTO `t_areas` VALUES ('691', '依兰县', '154800', '1', '682', '691');
INSERT INTO `t_areas` VALUES ('692', '方正县', '150800', '1', '682', '692');
INSERT INTO `t_areas` VALUES ('693', '宾县', '150400', '1', '682', '693');
INSERT INTO `t_areas` VALUES ('694', '巴彦县', '151800', '1', '682', '694');
INSERT INTO `t_areas` VALUES ('695', '木兰县', '151900', '1', '682', '695');
INSERT INTO `t_areas` VALUES ('696', '通河县', '150900', '1', '682', '696');
INSERT INTO `t_areas` VALUES ('697', '延寿县', '150700', '1', '682', '697');
INSERT INTO `t_areas` VALUES ('698', '双城市', '150100', '1', '682', '698');
INSERT INTO `t_areas` VALUES ('699', '尚志市', '150600', '1', '682', '699');
INSERT INTO `t_areas` VALUES ('700', '五常市', '150200', '1', '682', '700');
INSERT INTO `t_areas` VALUES ('701', '齐齐哈尔市', '161000', '1', '9', '701');
INSERT INTO `t_areas` VALUES ('702', '龙沙区', '161000', '1', '701', '702');
INSERT INTO `t_areas` VALUES ('703', '建华区', '161000', '1', '701', '703');
INSERT INTO `t_areas` VALUES ('704', '铁锋区', '161000', '1', '701', '704');
INSERT INTO `t_areas` VALUES ('705', '昂昂溪区', '161000', '1', '701', '705');
INSERT INTO `t_areas` VALUES ('706', '富拉尔基区', '161000', '1', '701', '706');
INSERT INTO `t_areas` VALUES ('707', '碾子山区', '161000', '1', '701', '707');
INSERT INTO `t_areas` VALUES ('708', '梅里斯达斡尔族区', '161000', '1', '701', '708');
INSERT INTO `t_areas` VALUES ('709', '龙江县', '161100', '1', '701', '709');
INSERT INTO `t_areas` VALUES ('710', '依安县', '161500', '1', '701', '710');
INSERT INTO `t_areas` VALUES ('711', '泰来县', '162400', '1', '701', '711');
INSERT INTO `t_areas` VALUES ('712', '甘南县', '162100', '1', '701', '712');
INSERT INTO `t_areas` VALUES ('713', '富裕县', '161200', '1', '701', '713');
INSERT INTO `t_areas` VALUES ('714', '克山县', '161600', '1', '701', '714');
INSERT INTO `t_areas` VALUES ('715', '克东县', '164800', '1', '701', '715');
INSERT INTO `t_areas` VALUES ('716', '拜泉县', '164700', '1', '701', '716');
INSERT INTO `t_areas` VALUES ('717', '讷河市', '161300', '1', '701', '717');
INSERT INTO `t_areas` VALUES ('718', '鸡西市', '158100', '1', '9', '718');
INSERT INTO `t_areas` VALUES ('719', '鸡冠区', '158100', '1', '718', '719');
INSERT INTO `t_areas` VALUES ('720', '恒山区', '158100', '1', '718', '720');
INSERT INTO `t_areas` VALUES ('721', '滴道区', '158100', '1', '718', '721');
INSERT INTO `t_areas` VALUES ('722', '梨树区', '158100', '1', '718', '722');
INSERT INTO `t_areas` VALUES ('723', '城子河区', '158100', '1', '718', '723');
INSERT INTO `t_areas` VALUES ('724', '麻山区', '158100', '1', '718', '724');
INSERT INTO `t_areas` VALUES ('725', '鸡东县', '158200', '1', '718', '725');
INSERT INTO `t_areas` VALUES ('726', '虎林市', '158400', '1', '718', '726');
INSERT INTO `t_areas` VALUES ('727', '密山市', '158300', '1', '718', '727');
INSERT INTO `t_areas` VALUES ('728', '鹤岗市', '154000', '1', '9', '728');
INSERT INTO `t_areas` VALUES ('729', '向阳区', '154000', '1', '728', '729');
INSERT INTO `t_areas` VALUES ('730', '工农区', '154100', '1', '728', '730');
INSERT INTO `t_areas` VALUES ('731', '南山区', '154100', '1', '728', '731');
INSERT INTO `t_areas` VALUES ('732', '兴安区', '154100', '1', '728', '732');
INSERT INTO `t_areas` VALUES ('733', '东山区', '154100', '1', '728', '733');
INSERT INTO `t_areas` VALUES ('734', '兴山区', '154100', '1', '728', '734');
INSERT INTO `t_areas` VALUES ('735', '萝北县', '154200', '1', '728', '735');
INSERT INTO `t_areas` VALUES ('736', '绥滨县', '156200', '1', '728', '736');
INSERT INTO `t_areas` VALUES ('737', '双鸭山市', '155100', '1', '9', '737');
INSERT INTO `t_areas` VALUES ('738', '尖山区', '155100', '1', '737', '738');
INSERT INTO `t_areas` VALUES ('739', '岭东区', '155100', '1', '737', '739');
INSERT INTO `t_areas` VALUES ('740', '四方台区', '155100', '1', '737', '740');
INSERT INTO `t_areas` VALUES ('741', '宝山区', '155100', '1', '737', '741');
INSERT INTO `t_areas` VALUES ('742', '集贤县', '155900', '1', '737', '742');
INSERT INTO `t_areas` VALUES ('743', '友谊县', '155800', '1', '737', '743');
INSERT INTO `t_areas` VALUES ('744', '宝清县', '155600', '1', '737', '744');
INSERT INTO `t_areas` VALUES ('745', '饶河县', '155700', '1', '737', '745');
INSERT INTO `t_areas` VALUES ('746', '大庆市', '163000', '1', '9', '746');
INSERT INTO `t_areas` VALUES ('747', '萨尔图区', '163000', '1', '746', '747');
INSERT INTO `t_areas` VALUES ('748', '龙凤区', '163000', '1', '746', '748');
INSERT INTO `t_areas` VALUES ('749', '让胡路区', '163000', '1', '746', '749');
INSERT INTO `t_areas` VALUES ('750', '红岗区', '163000', '1', '746', '750');
INSERT INTO `t_areas` VALUES ('751', '大同区', '163000', '1', '746', '751');
INSERT INTO `t_areas` VALUES ('752', '肇州县', '166400', '1', '746', '752');
INSERT INTO `t_areas` VALUES ('753', '肇源县', '166500', '1', '746', '753');
INSERT INTO `t_areas` VALUES ('754', '林甸县', '166300', '1', '746', '754');
INSERT INTO `t_areas` VALUES ('755', '杜尔伯特蒙古族自治县', '166200', '1', '746', '755');
INSERT INTO `t_areas` VALUES ('756', '伊春市', '153000', '1', '9', '756');
INSERT INTO `t_areas` VALUES ('757', '伊春区', '153000', '1', '756', '757');
INSERT INTO `t_areas` VALUES ('758', '南岔区', '153000', '1', '756', '758');
INSERT INTO `t_areas` VALUES ('759', '友好区', '153000', '1', '756', '759');
INSERT INTO `t_areas` VALUES ('760', '西林区', '153000', '1', '756', '760');
INSERT INTO `t_areas` VALUES ('761', '翠峦区', '153000', '1', '756', '761');
INSERT INTO `t_areas` VALUES ('762', '新青区', '153000', '1', '756', '762');
INSERT INTO `t_areas` VALUES ('763', '美溪区', '153000', '1', '756', '763');
INSERT INTO `t_areas` VALUES ('764', '金山屯区', '153000', '1', '756', '764');
INSERT INTO `t_areas` VALUES ('765', '五营区', '153000', '1', '756', '765');
INSERT INTO `t_areas` VALUES ('766', '乌马河区', '153000', '1', '756', '766');
INSERT INTO `t_areas` VALUES ('767', '汤旺河区', '153000', '1', '756', '767');
INSERT INTO `t_areas` VALUES ('768', '带岭区', '153000', '1', '756', '768');
INSERT INTO `t_areas` VALUES ('769', '乌伊岭区', '153000', '1', '756', '769');
INSERT INTO `t_areas` VALUES ('770', '红星区', '153000', '1', '756', '770');
INSERT INTO `t_areas` VALUES ('771', '上甘岭区', '153000', '1', '756', '771');
INSERT INTO `t_areas` VALUES ('772', '嘉荫县', '153200', '1', '756', '772');
INSERT INTO `t_areas` VALUES ('773', '铁力市', '152500', '1', '756', '773');
INSERT INTO `t_areas` VALUES ('774', '佳木斯市', '154000', '1', '9', '774');
INSERT INTO `t_areas` VALUES ('775', '向阳区', '154000', '1', '774', '775');
INSERT INTO `t_areas` VALUES ('776', '前进区', '154000', '1', '774', '776');
INSERT INTO `t_areas` VALUES ('777', '东风区', '154000', '1', '774', '777');
INSERT INTO `t_areas` VALUES ('778', '郊区', '154000', '1', '774', '778');
INSERT INTO `t_areas` VALUES ('779', '桦南县', '154400', '1', '774', '779');
INSERT INTO `t_areas` VALUES ('780', '桦川县', '154300', '1', '774', '780');
INSERT INTO `t_areas` VALUES ('781', '汤原县', '154700', '1', '774', '781');
INSERT INTO `t_areas` VALUES ('782', '抚远县', '156500', '1', '774', '782');
INSERT INTO `t_areas` VALUES ('783', '同江市', '156400', '1', '774', '783');
INSERT INTO `t_areas` VALUES ('784', '富锦市', '156100', '1', '774', '784');
INSERT INTO `t_areas` VALUES ('785', '七台河市', '154600', '1', '9', '785');
INSERT INTO `t_areas` VALUES ('786', '新兴区', '154600', '1', '785', '786');
INSERT INTO `t_areas` VALUES ('787', '桃山区', '154600', '1', '785', '787');
INSERT INTO `t_areas` VALUES ('788', '茄子河区', '154600', '1', '785', '788');
INSERT INTO `t_areas` VALUES ('789', '勃利县', '154500', '1', '785', '789');
INSERT INTO `t_areas` VALUES ('790', '牡丹江市', '157000', '1', '9', '790');
INSERT INTO `t_areas` VALUES ('791', '东安区', '157000', '1', '790', '791');
INSERT INTO `t_areas` VALUES ('792', '阳明区', '157000', '1', '790', '792');
INSERT INTO `t_areas` VALUES ('793', '爱民区', '157000', '1', '790', '793');
INSERT INTO `t_areas` VALUES ('794', '西安区', '157000', '1', '790', '794');
INSERT INTO `t_areas` VALUES ('795', '东宁县', '157200', '1', '790', '795');
INSERT INTO `t_areas` VALUES ('796', '林口县', '157600', '1', '790', '796');
INSERT INTO `t_areas` VALUES ('797', '绥芬河市', '157300', '1', '790', '797');
INSERT INTO `t_areas` VALUES ('798', '海林市', '157100', '1', '790', '798');
INSERT INTO `t_areas` VALUES ('799', '宁安市', '157400', '1', '790', '799');
INSERT INTO `t_areas` VALUES ('800', '穆棱市', '157500', '1', '790', '800');
INSERT INTO `t_areas` VALUES ('801', '黑河市', '164300', '1', '9', '801');
INSERT INTO `t_areas` VALUES ('802', '爱辉区', '164300', '1', '801', '802');
INSERT INTO `t_areas` VALUES ('803', '嫩江县', '161400', '1', '801', '803');
INSERT INTO `t_areas` VALUES ('804', '逊克县', '164400', '1', '801', '804');
INSERT INTO `t_areas` VALUES ('805', '孙吴县', '164200', '1', '801', '805');
INSERT INTO `t_areas` VALUES ('806', '北安市', '164000', '1', '801', '806');
INSERT INTO `t_areas` VALUES ('807', '五大连池市', '164100', '1', '801', '807');
INSERT INTO `t_areas` VALUES ('808', '绥化市', '152000', '1', '9', '808');
INSERT INTO `t_areas` VALUES ('809', '北林区', '152000', '1', '808', '809');
INSERT INTO `t_areas` VALUES ('810', '望奎县', '152100', '1', '808', '810');
INSERT INTO `t_areas` VALUES ('811', '兰西县', '151500', '1', '808', '811');
INSERT INTO `t_areas` VALUES ('812', '青冈县', '151600', '1', '808', '812');
INSERT INTO `t_areas` VALUES ('813', '庆安县', '152400', '1', '808', '813');
INSERT INTO `t_areas` VALUES ('814', '明水县', '151700', '1', '808', '814');
INSERT INTO `t_areas` VALUES ('815', '绥棱县', '152200', '1', '808', '815');
INSERT INTO `t_areas` VALUES ('816', '安达市', '151400', '1', '808', '816');
INSERT INTO `t_areas` VALUES ('817', '肇东市', '151100', '1', '808', '817');
INSERT INTO `t_areas` VALUES ('818', '海伦市', '152300', '1', '808', '818');
INSERT INTO `t_areas` VALUES ('819', '大兴安岭地区', '165000', '1', '9', '819');
INSERT INTO `t_areas` VALUES ('820', '加格达奇区', '165000', '1', '819', '820');
INSERT INTO `t_areas` VALUES ('821', '松岭区', '165000', '1', '819', '821');
INSERT INTO `t_areas` VALUES ('822', '新林区', '165000', '1', '819', '822');
INSERT INTO `t_areas` VALUES ('823', '呼中区', '165000', '1', '819', '823');
INSERT INTO `t_areas` VALUES ('824', '呼玛县', '165100', '1', '819', '824');
INSERT INTO `t_areas` VALUES ('825', '塔河县', '165200', '1', '819', '825');
INSERT INTO `t_areas` VALUES ('826', '漠河县', '165300', '1', '819', '826');
INSERT INTO `t_areas` VALUES ('827', '黄浦区', '200000', '1', '10', '827');
INSERT INTO `t_areas` VALUES ('828', '卢湾区', '200000', '1', '10', '828');
INSERT INTO `t_areas` VALUES ('829', '徐汇区', '200000', '1', '10', '829');
INSERT INTO `t_areas` VALUES ('830', '长宁区', '200000', '1', '10', '830');
INSERT INTO `t_areas` VALUES ('831', '静安区', '200000', '1', '10', '831');
INSERT INTO `t_areas` VALUES ('832', '普陀区', '200000', '1', '10', '832');
INSERT INTO `t_areas` VALUES ('833', '闸北区', '200000', '1', '10', '833');
INSERT INTO `t_areas` VALUES ('834', '虹口区', '200000', '1', '10', '834');
INSERT INTO `t_areas` VALUES ('835', '杨浦区', '200000', '1', '10', '835');
INSERT INTO `t_areas` VALUES ('836', '闵行区', '201100', '1', '10', '836');
INSERT INTO `t_areas` VALUES ('837', '宝山区', '201900', '1', '10', '837');
INSERT INTO `t_areas` VALUES ('838', '嘉定区', '201800', '1', '10', '838');
INSERT INTO `t_areas` VALUES ('839', '浦东新区', '200120', '1', '10', '839');
INSERT INTO `t_areas` VALUES ('840', '金山区', '201500', '1', '10', '840');
INSERT INTO `t_areas` VALUES ('841', '松江区', '201600', '1', '10', '841');
INSERT INTO `t_areas` VALUES ('842', '青浦区', '201700', '1', '10', '842');
INSERT INTO `t_areas` VALUES ('843', '南汇区', '201300', '1', '10', '843');
INSERT INTO `t_areas` VALUES ('844', '奉贤区', '201400', '1', '10', '844');
INSERT INTO `t_areas` VALUES ('845', '崇明县', '202150', '1', '10', '845');
INSERT INTO `t_areas` VALUES ('846', '南京市', '210000', '1', '11', '846');
INSERT INTO `t_areas` VALUES ('847', '玄武区', '210000', '1', '846', '847');
INSERT INTO `t_areas` VALUES ('848', '白下区', '210000', '1', '846', '848');
INSERT INTO `t_areas` VALUES ('849', '秦淮区', '210000', '1', '846', '849');
INSERT INTO `t_areas` VALUES ('850', '建邺区', '210000', '1', '846', '850');
INSERT INTO `t_areas` VALUES ('851', '鼓楼区', '210000', '1', '846', '851');
INSERT INTO `t_areas` VALUES ('852', '下关区', '210000', '1', '846', '852');
INSERT INTO `t_areas` VALUES ('853', '浦口区', '210000', '1', '846', '853');
INSERT INTO `t_areas` VALUES ('854', '栖霞区', '210000', '1', '846', '854');
INSERT INTO `t_areas` VALUES ('855', '雨花台区', '210000', '1', '846', '855');
INSERT INTO `t_areas` VALUES ('856', '江宁区', '211100', '1', '846', '856');
INSERT INTO `t_areas` VALUES ('857', '六合区', '211500', '1', '846', '857');
INSERT INTO `t_areas` VALUES ('858', '溧水县', '211200', '1', '846', '858');
INSERT INTO `t_areas` VALUES ('859', '高淳县', '211300', '1', '846', '859');
INSERT INTO `t_areas` VALUES ('860', '无锡市', '214000', '1', '11', '860');
INSERT INTO `t_areas` VALUES ('861', '崇安区', '214000', '1', '860', '861');
INSERT INTO `t_areas` VALUES ('862', '南长区', '214000', '1', '860', '862');
INSERT INTO `t_areas` VALUES ('863', '北塘区', '214000', '1', '860', '863');
INSERT INTO `t_areas` VALUES ('864', '锡山区', '214000', '1', '860', '864');
INSERT INTO `t_areas` VALUES ('865', '惠山区', '214000', '1', '860', '865');
INSERT INTO `t_areas` VALUES ('866', '滨湖区', '214000', '1', '860', '866');
INSERT INTO `t_areas` VALUES ('867', '江阴市', '214400', '1', '860', '867');
INSERT INTO `t_areas` VALUES ('868', '宜兴市', '214200', '1', '860', '868');
INSERT INTO `t_areas` VALUES ('869', '徐州市', '221000', '1', '11', '869');
INSERT INTO `t_areas` VALUES ('870', '鼓楼区', '221000', '1', '869', '870');
INSERT INTO `t_areas` VALUES ('871', '云龙区', '221000', '1', '869', '871');
INSERT INTO `t_areas` VALUES ('872', '九里区', '221000', '1', '869', '872');
INSERT INTO `t_areas` VALUES ('873', '贾汪区', '221000', '1', '869', '873');
INSERT INTO `t_areas` VALUES ('874', '泉山区', '221000', '1', '869', '874');
INSERT INTO `t_areas` VALUES ('875', '丰县', '221700', '1', '869', '875');
INSERT INTO `t_areas` VALUES ('876', '沛县', '221600', '1', '869', '876');
INSERT INTO `t_areas` VALUES ('877', '铜山县', '221100', '1', '869', '877');
INSERT INTO `t_areas` VALUES ('878', '睢宁县', '221200', '1', '869', '878');
INSERT INTO `t_areas` VALUES ('879', '新沂市', '221400', '1', '869', '879');
INSERT INTO `t_areas` VALUES ('880', '邳州市', '221300', '1', '869', '880');
INSERT INTO `t_areas` VALUES ('881', '常州市', '213000', '1', '11', '881');
INSERT INTO `t_areas` VALUES ('882', '天宁区', '213000', '1', '881', '882');
INSERT INTO `t_areas` VALUES ('883', '钟楼区', '213000', '1', '881', '883');
INSERT INTO `t_areas` VALUES ('884', '戚墅堰区', '213000', '1', '881', '884');
INSERT INTO `t_areas` VALUES ('885', '新北区', '213000', '1', '881', '885');
INSERT INTO `t_areas` VALUES ('886', '武进区', '213100', '1', '881', '886');
INSERT INTO `t_areas` VALUES ('887', '溧阳市', '213300', '1', '881', '887');
INSERT INTO `t_areas` VALUES ('888', '金坛市', '213200', '1', '881', '888');
INSERT INTO `t_areas` VALUES ('889', '苏州市', '215000', '1', '11', '889');
INSERT INTO `t_areas` VALUES ('890', '沧浪区', '215000', '1', '889', '890');
INSERT INTO `t_areas` VALUES ('891', '平江区', '215000', '1', '889', '891');
INSERT INTO `t_areas` VALUES ('892', '金阊区', '215000', '1', '889', '892');
INSERT INTO `t_areas` VALUES ('893', '虎丘区', '215000', '1', '889', '893');
INSERT INTO `t_areas` VALUES ('894', '吴中区', '215100', '1', '889', '894');
INSERT INTO `t_areas` VALUES ('895', '相城区', '215100', '1', '889', '895');
INSERT INTO `t_areas` VALUES ('896', '常熟市', '215500', '1', '889', '896');
INSERT INTO `t_areas` VALUES ('897', '张家港市', '215600', '1', '889', '897');
INSERT INTO `t_areas` VALUES ('898', '昆山市', '215300', '1', '889', '898');
INSERT INTO `t_areas` VALUES ('899', '吴江市', '215200', '1', '889', '899');
INSERT INTO `t_areas` VALUES ('900', '太仓市', '215400', '1', '889', '900');
INSERT INTO `t_areas` VALUES ('901', '南通市', '226000', '1', '11', '901');
INSERT INTO `t_areas` VALUES ('902', '崇川区', '226000', '1', '901', '902');
INSERT INTO `t_areas` VALUES ('903', '港闸区', '226000', '1', '901', '903');
INSERT INTO `t_areas` VALUES ('904', '海安县', '226600', '1', '901', '904');
INSERT INTO `t_areas` VALUES ('905', '如东县', '226400', '1', '901', '905');
INSERT INTO `t_areas` VALUES ('906', '启东市', '226200', '1', '901', '906');
INSERT INTO `t_areas` VALUES ('907', '如皋市', '226500', '1', '901', '907');
INSERT INTO `t_areas` VALUES ('908', '通州市', '226300', '1', '901', '908');
INSERT INTO `t_areas` VALUES ('909', '海门市', '226100', '1', '901', '909');
INSERT INTO `t_areas` VALUES ('910', '连云港市', '222000', '1', '11', '910');
INSERT INTO `t_areas` VALUES ('911', '连云区', '222000', '1', '910', '911');
INSERT INTO `t_areas` VALUES ('912', '新浦区', '222000', '1', '910', '912');
INSERT INTO `t_areas` VALUES ('913', '海州区', '222000', '1', '910', '913');
INSERT INTO `t_areas` VALUES ('914', '赣榆县', '222100', '1', '910', '914');
INSERT INTO `t_areas` VALUES ('915', '东海县', '222300', '1', '910', '915');
INSERT INTO `t_areas` VALUES ('916', '灌云县', '222200', '1', '910', '916');
INSERT INTO `t_areas` VALUES ('917', '灌南县', '223500', '1', '910', '917');
INSERT INTO `t_areas` VALUES ('918', '淮安市', '223000', '1', '11', '918');
INSERT INTO `t_areas` VALUES ('919', '清河区', '223001', '1', '918', '919');
INSERT INTO `t_areas` VALUES ('920', '楚州区', '223200', '1', '918', '920');
INSERT INTO `t_areas` VALUES ('921', '淮阴区', '223300', '1', '918', '921');
INSERT INTO `t_areas` VALUES ('922', '清浦区', '223001', '1', '918', '922');
INSERT INTO `t_areas` VALUES ('923', '涟水县', '223400', '1', '918', '923');
INSERT INTO `t_areas` VALUES ('924', '洪泽县', '223100', '1', '918', '924');
INSERT INTO `t_areas` VALUES ('925', '盱眙县', '211700', '1', '918', '925');
INSERT INTO `t_areas` VALUES ('926', '金湖县', '211600', '1', '918', '926');
INSERT INTO `t_areas` VALUES ('927', '盐城市', '224000', '1', '11', '927');
INSERT INTO `t_areas` VALUES ('928', '亭湖区', '224000', '1', '927', '928');
INSERT INTO `t_areas` VALUES ('929', '盐都区', '224000', '1', '927', '929');
INSERT INTO `t_areas` VALUES ('930', '响水县', '224600', '1', '927', '930');
INSERT INTO `t_areas` VALUES ('931', '滨海县', '224000', '1', '927', '931');
INSERT INTO `t_areas` VALUES ('932', '阜宁县', '224400', '1', '927', '932');
INSERT INTO `t_areas` VALUES ('933', '射阳县', '224300', '1', '927', '933');
INSERT INTO `t_areas` VALUES ('934', '建湖县', '224700', '1', '927', '934');
INSERT INTO `t_areas` VALUES ('935', '东台市', '224200', '1', '927', '935');
INSERT INTO `t_areas` VALUES ('936', '大丰市', '224100', '1', '927', '936');
INSERT INTO `t_areas` VALUES ('937', '扬州市', '225000', '1', '11', '937');
INSERT INTO `t_areas` VALUES ('938', '广陵区', '225000', '1', '937', '938');
INSERT INTO `t_areas` VALUES ('939', '邗江区', '225100', '1', '937', '939');
INSERT INTO `t_areas` VALUES ('940', '维扬区', '225200', '1', '937', '940');
INSERT INTO `t_areas` VALUES ('941', '宝应县', '225800', '1', '937', '941');
INSERT INTO `t_areas` VALUES ('942', '仪征市', '211400', '1', '937', '942');
INSERT INTO `t_areas` VALUES ('943', '高邮市', '225600', '1', '937', '943');
INSERT INTO `t_areas` VALUES ('944', '江都市', '225200', '1', '937', '944');
INSERT INTO `t_areas` VALUES ('945', '镇江市', '212000', '1', '11', '945');
INSERT INTO `t_areas` VALUES ('946', '京口区', '212000', '1', '945', '946');
INSERT INTO `t_areas` VALUES ('947', '润州区', '212000', '1', '945', '947');
INSERT INTO `t_areas` VALUES ('948', '丹徒区', '212100', '1', '945', '948');
INSERT INTO `t_areas` VALUES ('949', '丹阳市', '212300', '1', '945', '949');
INSERT INTO `t_areas` VALUES ('950', '扬中市', '212200', '1', '945', '950');
INSERT INTO `t_areas` VALUES ('951', '句容市', '212400', '1', '945', '951');
INSERT INTO `t_areas` VALUES ('952', '泰州市', '225300', '1', '11', '952');
INSERT INTO `t_areas` VALUES ('953', '海陵区', '225300', '1', '952', '953');
INSERT INTO `t_areas` VALUES ('954', '高港区', '225300', '1', '952', '954');
INSERT INTO `t_areas` VALUES ('955', '兴化市', '225700', '1', '952', '955');
INSERT INTO `t_areas` VALUES ('956', '靖江市', '214500', '1', '952', '956');
INSERT INTO `t_areas` VALUES ('957', '泰兴市', '225400', '1', '952', '957');
INSERT INTO `t_areas` VALUES ('958', '姜堰市', '225500', '1', '952', '958');
INSERT INTO `t_areas` VALUES ('959', '宿迁市', '223800', '1', '11', '959');
INSERT INTO `t_areas` VALUES ('960', '宿城区', '223800', '1', '959', '960');
INSERT INTO `t_areas` VALUES ('961', '宿豫区', '223800', '1', '959', '961');
INSERT INTO `t_areas` VALUES ('962', '沭阳县', '223600', '1', '959', '962');
INSERT INTO `t_areas` VALUES ('963', '泗阳县', '223700', '1', '959', '963');
INSERT INTO `t_areas` VALUES ('964', '泗洪县', '223900', '1', '959', '964');
INSERT INTO `t_areas` VALUES ('965', '杭州市', '310000', '1', '12', '965');
INSERT INTO `t_areas` VALUES ('966', '上城区', '310000', '1', '965', '966');
INSERT INTO `t_areas` VALUES ('967', '下城区', '310000', '1', '965', '967');
INSERT INTO `t_areas` VALUES ('968', '江干区', '310000', '1', '965', '968');
INSERT INTO `t_areas` VALUES ('969', '拱墅区', '310000', '1', '965', '969');
INSERT INTO `t_areas` VALUES ('970', '西湖区', '310000', '1', '965', '970');
INSERT INTO `t_areas` VALUES ('971', '滨江区', '310000', '1', '965', '971');
INSERT INTO `t_areas` VALUES ('972', '萧山区', '311200', '1', '965', '972');
INSERT INTO `t_areas` VALUES ('973', '余杭区', '311100', '1', '965', '973');
INSERT INTO `t_areas` VALUES ('974', '桐庐县', '311500', '1', '965', '974');
INSERT INTO `t_areas` VALUES ('975', '淳安县', '311700', '1', '965', '975');
INSERT INTO `t_areas` VALUES ('976', '建德市', '311600', '1', '965', '976');
INSERT INTO `t_areas` VALUES ('977', '富阳市', '311400', '1', '965', '977');
INSERT INTO `t_areas` VALUES ('978', '临安市', '311300', '1', '965', '978');
INSERT INTO `t_areas` VALUES ('979', '宁波市', '315000', '1', '12', '979');
INSERT INTO `t_areas` VALUES ('980', '海曙区', '315000', '1', '979', '980');
INSERT INTO `t_areas` VALUES ('981', '江东区', '315000', '1', '979', '981');
INSERT INTO `t_areas` VALUES ('982', '江北区', '315000', '1', '979', '982');
INSERT INTO `t_areas` VALUES ('983', '北仑区', '315800', '1', '979', '983');
INSERT INTO `t_areas` VALUES ('984', '镇海区', '315200', '1', '979', '984');
INSERT INTO `t_areas` VALUES ('985', '鄞州区', '315100', '1', '979', '985');
INSERT INTO `t_areas` VALUES ('986', '象山县', '315700', '1', '979', '986');
INSERT INTO `t_areas` VALUES ('987', '宁海县', '315600', '1', '979', '987');
INSERT INTO `t_areas` VALUES ('988', '余姚市', '315400', '1', '979', '988');
INSERT INTO `t_areas` VALUES ('989', '慈溪市', '315300', '1', '979', '989');
INSERT INTO `t_areas` VALUES ('990', '奉化市', '315500', '1', '979', '990');
INSERT INTO `t_areas` VALUES ('991', '温州市', '325000', '1', '12', '991');
INSERT INTO `t_areas` VALUES ('992', '鹿城区', '325000', '1', '991', '992');
INSERT INTO `t_areas` VALUES ('993', '龙湾区', '325000', '1', '991', '993');
INSERT INTO `t_areas` VALUES ('994', '瓯海区', '325000', '1', '991', '994');
INSERT INTO `t_areas` VALUES ('995', '洞头县', '325700', '1', '991', '995');
INSERT INTO `t_areas` VALUES ('996', '永嘉县', '325100', '1', '991', '996');
INSERT INTO `t_areas` VALUES ('997', '平阳县', '325400', '1', '991', '997');
INSERT INTO `t_areas` VALUES ('998', '苍南县', '325800', '1', '991', '998');
INSERT INTO `t_areas` VALUES ('999', '文成县', '325300', '1', '991', '999');
INSERT INTO `t_areas` VALUES ('1000', '泰顺县', '325500', '1', '991', '1000');
INSERT INTO `t_areas` VALUES ('1001', '瑞安市', '325200', '1', '991', '1001');
INSERT INTO `t_areas` VALUES ('1002', '乐清市', '325600', '1', '991', '1002');
INSERT INTO `t_areas` VALUES ('1003', '嘉兴市', '314000', '1', '12', '1003');
INSERT INTO `t_areas` VALUES ('1004', '南湖区', '314000', '1', '1003', '1004');
INSERT INTO `t_areas` VALUES ('1005', '秀洲区', '314000', '1', '1003', '1005');
INSERT INTO `t_areas` VALUES ('1006', '嘉善县', '314100', '1', '1003', '1006');
INSERT INTO `t_areas` VALUES ('1007', '海盐县', '314300', '1', '1003', '1007');
INSERT INTO `t_areas` VALUES ('1008', '海宁市', '314400', '1', '1003', '1008');
INSERT INTO `t_areas` VALUES ('1009', '平湖市', '314200', '1', '1003', '1009');
INSERT INTO `t_areas` VALUES ('1010', '桐乡市', '314500', '1', '1003', '1010');
INSERT INTO `t_areas` VALUES ('1011', '湖州市', '313000', '1', '12', '1011');
INSERT INTO `t_areas` VALUES ('1012', '吴兴区', '313000', '1', '1011', '1012');
INSERT INTO `t_areas` VALUES ('1013', '南浔区', '313000', '1', '1011', '1013');
INSERT INTO `t_areas` VALUES ('1014', '德清县', '313200', '1', '1011', '1014');
INSERT INTO `t_areas` VALUES ('1015', '长兴县', '313100', '1', '1011', '1015');
INSERT INTO `t_areas` VALUES ('1016', '安吉县', '313300', '1', '1011', '1016');
INSERT INTO `t_areas` VALUES ('1017', '绍兴市', '312000', '1', '12', '1017');
INSERT INTO `t_areas` VALUES ('1018', '越城区', '312000', '1', '1017', '1018');
INSERT INTO `t_areas` VALUES ('1019', '绍兴县', '312000', '1', '1017', '1019');
INSERT INTO `t_areas` VALUES ('1020', '新昌县', '312500', '1', '1017', '1020');
INSERT INTO `t_areas` VALUES ('1021', '诸暨市', '311800', '1', '1017', '1021');
INSERT INTO `t_areas` VALUES ('1022', '上虞市', '312300', '1', '1017', '1022');
INSERT INTO `t_areas` VALUES ('1023', '嵊州市', '312400', '1', '1017', '1023');
INSERT INTO `t_areas` VALUES ('1024', '金华市', '321000', '1', '12', '1024');
INSERT INTO `t_areas` VALUES ('1025', '婺城区', '321000', '1', '1024', '1025');
INSERT INTO `t_areas` VALUES ('1026', '金东区', '321000', '1', '1024', '1026');
INSERT INTO `t_areas` VALUES ('1027', '武义县', '321200', '1', '1024', '1027');
INSERT INTO `t_areas` VALUES ('1028', '浦江县', '322200', '1', '1024', '1028');
INSERT INTO `t_areas` VALUES ('1029', '磐安县', '322300', '1', '1024', '1029');
INSERT INTO `t_areas` VALUES ('1030', '兰溪市', '321100', '1', '1024', '1030');
INSERT INTO `t_areas` VALUES ('1031', '义乌市', '322000', '1', '1024', '1031');
INSERT INTO `t_areas` VALUES ('1032', '东阳市', '322100', '1', '1024', '1032');
INSERT INTO `t_areas` VALUES ('1033', '永康市', '321300', '1', '1024', '1033');
INSERT INTO `t_areas` VALUES ('1034', '衢州市', '324000', '1', '12', '1034');
INSERT INTO `t_areas` VALUES ('1035', '柯城区', '324000', '1', '1034', '1035');
INSERT INTO `t_areas` VALUES ('1036', '衢江区', '324000', '1', '1034', '1036');
INSERT INTO `t_areas` VALUES ('1037', '常山县', '324200', '1', '1034', '1037');
INSERT INTO `t_areas` VALUES ('1038', '开化县', '324300', '1', '1034', '1038');
INSERT INTO `t_areas` VALUES ('1039', '龙游县', '324400', '1', '1034', '1039');
INSERT INTO `t_areas` VALUES ('1040', '江山市', '324100', '1', '1034', '1040');
INSERT INTO `t_areas` VALUES ('1041', '舟山市', '316000', '1', '12', '1041');
INSERT INTO `t_areas` VALUES ('1042', '定海区', '316000', '1', '1041', '1042');
INSERT INTO `t_areas` VALUES ('1043', '普陀区', '316100', '1', '1041', '1043');
INSERT INTO `t_areas` VALUES ('1044', '岱山县', '316200', '1', '1041', '1044');
INSERT INTO `t_areas` VALUES ('1045', '嵊泗县', '202450', '1', '1041', '1045');
INSERT INTO `t_areas` VALUES ('1046', '台州市', '317000', '1', '12', '1046');
INSERT INTO `t_areas` VALUES ('1047', '椒江区', '317700', '1', '1046', '1047');
INSERT INTO `t_areas` VALUES ('1048', '黄岩区', '318020', '1', '1046', '1048');
INSERT INTO `t_areas` VALUES ('1049', '路桥区', '318000', '1', '1046', '1049');
INSERT INTO `t_areas` VALUES ('1050', '玉环县', '317600', '1', '1046', '1050');
INSERT INTO `t_areas` VALUES ('1051', '三门县', '317100', '1', '1046', '1051');
INSERT INTO `t_areas` VALUES ('1052', '天台县', '317200', '1', '1046', '1052');
INSERT INTO `t_areas` VALUES ('1053', '仙居县', '317300', '1', '1046', '1053');
INSERT INTO `t_areas` VALUES ('1054', '温岭市', '317500', '1', '1046', '1054');
INSERT INTO `t_areas` VALUES ('1055', '临海市', '317000', '1', '1046', '1055');
INSERT INTO `t_areas` VALUES ('1056', '丽水市', '323000', '1', '12', '1056');
INSERT INTO `t_areas` VALUES ('1057', '莲都区', '323000', '1', '1056', '1057');
INSERT INTO `t_areas` VALUES ('1058', '青田县', '323900', '1', '1056', '1058');
INSERT INTO `t_areas` VALUES ('1059', '缙云县', '321400', '1', '1056', '1059');
INSERT INTO `t_areas` VALUES ('1060', '遂昌县', '323300', '1', '1056', '1060');
INSERT INTO `t_areas` VALUES ('1061', '松阳县', '323400', '1', '1056', '1061');
INSERT INTO `t_areas` VALUES ('1062', '云和县', '323600', '1', '1056', '1062');
INSERT INTO `t_areas` VALUES ('1063', '庆元县', '323800', '1', '1056', '1063');
INSERT INTO `t_areas` VALUES ('1064', '景宁畲族自治县', '323500', '1', '1056', '1064');
INSERT INTO `t_areas` VALUES ('1065', '龙泉市', '323700', '1', '1056', '1065');
INSERT INTO `t_areas` VALUES ('1066', '合肥市', '230000', '1', '13', '1066');
INSERT INTO `t_areas` VALUES ('1067', '瑶海区', '230000', '1', '1066', '1067');
INSERT INTO `t_areas` VALUES ('1068', '庐阳区', '230000', '1', '1066', '1068');
INSERT INTO `t_areas` VALUES ('1069', '蜀山区', '230000', '1', '1066', '1069');
INSERT INTO `t_areas` VALUES ('1070', '包河区', '230000', '1', '1066', '1070');
INSERT INTO `t_areas` VALUES ('1071', '长丰县', '231100', '1', '1066', '1071');
INSERT INTO `t_areas` VALUES ('1072', '肥东县', '230000', '1', '1066', '1072');
INSERT INTO `t_areas` VALUES ('1073', '肥西县', '231200', '1', '1066', '1073');
INSERT INTO `t_areas` VALUES ('1074', '芜湖市', '241000', '1', '13', '1074');
INSERT INTO `t_areas` VALUES ('1075', '镜湖区', '241000', '1', '1074', '1075');
INSERT INTO `t_areas` VALUES ('1076', '弋江区', '241000', '1', '1074', '1076');
INSERT INTO `t_areas` VALUES ('1077', '鸠江区', '241000', '1', '1074', '1077');
INSERT INTO `t_areas` VALUES ('1078', '三山区', '241080', '1', '1074', '1078');
INSERT INTO `t_areas` VALUES ('1079', '芜湖县', '241100', '1', '1074', '1079');
INSERT INTO `t_areas` VALUES ('1080', '繁昌县', '241200', '1', '1074', '1080');
INSERT INTO `t_areas` VALUES ('1081', '南陵县', '242400', '1', '1074', '1081');
INSERT INTO `t_areas` VALUES ('1082', '蚌埠市', '233000', '1', '13', '1082');
INSERT INTO `t_areas` VALUES ('1083', '龙子湖区', '233000', '1', '1082', '1083');
INSERT INTO `t_areas` VALUES ('1084', '蚌山区', '233000', '1', '1082', '1084');
INSERT INTO `t_areas` VALUES ('1085', '禹会区', '233000', '1', '1082', '1085');
INSERT INTO `t_areas` VALUES ('1086', '淮上区', '233000', '1', '1082', '1086');
INSERT INTO `t_areas` VALUES ('1087', '怀远县', '233400', '1', '1082', '1087');
INSERT INTO `t_areas` VALUES ('1088', '五河县', '233300', '1', '1082', '1088');
INSERT INTO `t_areas` VALUES ('1089', '固镇县', '233700', '1', '1082', '1089');
INSERT INTO `t_areas` VALUES ('1090', '淮南市', '232000', '1', '13', '1090');
INSERT INTO `t_areas` VALUES ('1091', '大通区', '232000', '1', '1090', '1091');
INSERT INTO `t_areas` VALUES ('1092', '田家庵区', '232000', '1', '1090', '1092');
INSERT INTO `t_areas` VALUES ('1093', '谢家集区', '232000', '1', '1090', '1093');
INSERT INTO `t_areas` VALUES ('1094', '八公山区', '232000', '1', '1090', '1094');
INSERT INTO `t_areas` VALUES ('1095', '潘集区', '232000', '1', '1090', '1095');
INSERT INTO `t_areas` VALUES ('1096', '凤台县', '232100', '1', '1090', '1096');
INSERT INTO `t_areas` VALUES ('1097', '马鞍山市', '243000', '1', '13', '1097');
INSERT INTO `t_areas` VALUES ('1098', '金家庄区', '243000', '1', '1097', '1098');
INSERT INTO `t_areas` VALUES ('1099', '花山区', '243000', '1', '1097', '1099');
INSERT INTO `t_areas` VALUES ('1100', '雨山区', '243000', '1', '1097', '1100');
INSERT INTO `t_areas` VALUES ('1101', '当涂县', '243100', '1', '1097', '1101');
INSERT INTO `t_areas` VALUES ('1102', '淮北市', '235000', '1', '13', '1102');
INSERT INTO `t_areas` VALUES ('1103', '杜集区', '235000', '1', '1102', '1103');
INSERT INTO `t_areas` VALUES ('1104', '相山区', '235000', '1', '1102', '1104');
INSERT INTO `t_areas` VALUES ('1105', '烈山区', '235000', '1', '1102', '1105');
INSERT INTO `t_areas` VALUES ('1106', '濉溪县', '235100', '1', '1102', '1106');
INSERT INTO `t_areas` VALUES ('1107', '铜陵市', '244000', '1', '13', '1107');
INSERT INTO `t_areas` VALUES ('1108', '铜官山区', '244000', '1', '1107', '1108');
INSERT INTO `t_areas` VALUES ('1109', '狮子山区', '244000', '1', '1107', '1109');
INSERT INTO `t_areas` VALUES ('1110', '郊区', '244000', '1', '1107', '1110');
INSERT INTO `t_areas` VALUES ('1111', '铜陵县', '244100', '1', '1107', '1111');
INSERT INTO `t_areas` VALUES ('1112', '安庆市', '246000', '1', '13', '1112');
INSERT INTO `t_areas` VALUES ('1113', '迎江区', '246000', '1', '1112', '1113');
INSERT INTO `t_areas` VALUES ('1114', '大观区', '246000', '1', '1112', '1114');
INSERT INTO `t_areas` VALUES ('1115', '宜秀区', '246000', '1', '1112', '1115');
INSERT INTO `t_areas` VALUES ('1116', '怀宁县', '246100', '1', '1112', '1116');
INSERT INTO `t_areas` VALUES ('1117', '枞阳县', '246700', '1', '1112', '1117');
INSERT INTO `t_areas` VALUES ('1118', '潜山县', '246300', '1', '1112', '1118');
INSERT INTO `t_areas` VALUES ('1119', '太湖县', '246400', '1', '1112', '1119');
INSERT INTO `t_areas` VALUES ('1120', '宿松县', '246500', '1', '1112', '1120');
INSERT INTO `t_areas` VALUES ('1121', '望江县', '246200', '1', '1112', '1121');
INSERT INTO `t_areas` VALUES ('1122', '岳西县', '246600', '1', '1112', '1122');
INSERT INTO `t_areas` VALUES ('1123', '桐城市', '231400', '1', '1112', '1123');
INSERT INTO `t_areas` VALUES ('1124', '黄山市', '245000', '1', '13', '1124');
INSERT INTO `t_areas` VALUES ('1125', '屯溪区', '245000', '1', '1124', '1125');
INSERT INTO `t_areas` VALUES ('1126', '黄山区', '245000', '1', '1124', '1126');
INSERT INTO `t_areas` VALUES ('1127', '徽州区', '245000', '1', '1124', '1127');
INSERT INTO `t_areas` VALUES ('1128', '歙县', '245200', '1', '1124', '1128');
INSERT INTO `t_areas` VALUES ('1129', '休宁县', '245400', '1', '1124', '1129');
INSERT INTO `t_areas` VALUES ('1130', '黟县', '245500', '1', '1124', '1130');
INSERT INTO `t_areas` VALUES ('1131', '祁门县', '245600', '1', '1124', '1131');
INSERT INTO `t_areas` VALUES ('1132', '滁州市', '239000', '1', '13', '1132');
INSERT INTO `t_areas` VALUES ('1133', '琅琊区', '239000', '1', '1132', '1133');
INSERT INTO `t_areas` VALUES ('1134', '南谯区', '239000', '1', '1132', '1134');
INSERT INTO `t_areas` VALUES ('1135', '来安县', '239200', '1', '1132', '1135');
INSERT INTO `t_areas` VALUES ('1136', '全椒县', '239500', '1', '1132', '1136');
INSERT INTO `t_areas` VALUES ('1137', '定远县', '233200', '1', '1132', '1137');
INSERT INTO `t_areas` VALUES ('1138', '凤阳县', '233100', '1', '1132', '1138');
INSERT INTO `t_areas` VALUES ('1139', '天长市', '239300', '1', '1132', '1139');
INSERT INTO `t_areas` VALUES ('1140', '明光市', '239400', '1', '1132', '1140');
INSERT INTO `t_areas` VALUES ('1141', '阜阳市', '236000', '1', '13', '1141');
INSERT INTO `t_areas` VALUES ('1142', '颍州区', '236000', '1', '1141', '1142');
INSERT INTO `t_areas` VALUES ('1143', '颍东区', '236000', '1', '1141', '1143');
INSERT INTO `t_areas` VALUES ('1144', '颍泉区', '236000', '1', '1141', '1144');
INSERT INTO `t_areas` VALUES ('1145', '临泉县', '236400', '1', '1141', '1145');
INSERT INTO `t_areas` VALUES ('1146', '太和县', '236600', '1', '1141', '1146');
INSERT INTO `t_areas` VALUES ('1147', '阜南县', '236300', '1', '1141', '1147');
INSERT INTO `t_areas` VALUES ('1148', '颍上县', '236200', '1', '1141', '1148');
INSERT INTO `t_areas` VALUES ('1149', '界首市', '236500', '1', '1141', '1149');
INSERT INTO `t_areas` VALUES ('1150', '宿州市', '234000', '1', '13', '1150');
INSERT INTO `t_areas` VALUES ('1151', '埇桥区', '234000', '1', '1150', '1151');
INSERT INTO `t_areas` VALUES ('1152', '砀山县', '235300', '1', '1150', '1152');
INSERT INTO `t_areas` VALUES ('1153', '萧县', '235200', '1', '1150', '1153');
INSERT INTO `t_areas` VALUES ('1154', '灵璧县', '234200', '1', '1150', '1154');
INSERT INTO `t_areas` VALUES ('1155', '泗县', '234300', '1', '1150', '1155');
INSERT INTO `t_areas` VALUES ('1156', '巢湖市', '238000', '1', '13', '1156');
INSERT INTO `t_areas` VALUES ('1157', '居巢区', '238000', '1', '1156', '1157');
INSERT INTO `t_areas` VALUES ('1158', '庐江县', '231500', '1', '1156', '1158');
INSERT INTO `t_areas` VALUES ('1159', '无为县', '238300', '1', '1156', '1159');
INSERT INTO `t_areas` VALUES ('1160', '含山县', '238100', '1', '1156', '1160');
INSERT INTO `t_areas` VALUES ('1161', '和县', '238200', '1', '1156', '1161');
INSERT INTO `t_areas` VALUES ('1162', '六安市', '237000', '1', '13', '1162');
INSERT INTO `t_areas` VALUES ('1163', '金安区', '237000', '1', '1162', '1163');
INSERT INTO `t_areas` VALUES ('1164', '裕安区', '237000', '1', '1162', '1164');
INSERT INTO `t_areas` VALUES ('1165', '寿县', '232200', '1', '1162', '1165');
INSERT INTO `t_areas` VALUES ('1166', '霍邱县', '237400', '1', '1162', '1166');
INSERT INTO `t_areas` VALUES ('1167', '舒城县', '231300', '1', '1162', '1167');
INSERT INTO `t_areas` VALUES ('1168', '金寨县', '237300', '1', '1162', '1168');
INSERT INTO `t_areas` VALUES ('1169', '霍山县', '237200', '1', '1162', '1169');
INSERT INTO `t_areas` VALUES ('1170', '亳州市', '236000', '1', '13', '1170');
INSERT INTO `t_areas` VALUES ('1171', '谯城区', '236800', '1', '1170', '1171');
INSERT INTO `t_areas` VALUES ('1172', '涡阳县', '233600', '1', '1170', '1172');
INSERT INTO `t_areas` VALUES ('1173', '蒙城县', '233500', '1', '1170', '1173');
INSERT INTO `t_areas` VALUES ('1174', '利辛县', '236700', '1', '1170', '1174');
INSERT INTO `t_areas` VALUES ('1175', '池州市', '247100', '1', '13', '1175');
INSERT INTO `t_areas` VALUES ('1176', '贵池区', '247100', '1', '1175', '1176');
INSERT INTO `t_areas` VALUES ('1177', '东至县', '247200', '1', '1175', '1177');
INSERT INTO `t_areas` VALUES ('1178', '石台县', '245100', '1', '1175', '1178');
INSERT INTO `t_areas` VALUES ('1179', '青阳县', '242800', '1', '1175', '1179');
INSERT INTO `t_areas` VALUES ('1180', '宣城市', '242000', '1', '13', '1180');
INSERT INTO `t_areas` VALUES ('1181', '宣州区', '242000', '1', '1180', '1181');
INSERT INTO `t_areas` VALUES ('1182', '郎溪县', '242100', '1', '1180', '1182');
INSERT INTO `t_areas` VALUES ('1183', '广德县', '242200', '1', '1180', '1183');
INSERT INTO `t_areas` VALUES ('1184', '泾县', '242500', '1', '1180', '1184');
INSERT INTO `t_areas` VALUES ('1185', '绩溪县', '245300', '1', '1180', '1185');
INSERT INTO `t_areas` VALUES ('1186', '旌德县', '242600', '1', '1180', '1186');
INSERT INTO `t_areas` VALUES ('1187', '宁国市', '242300', '1', '1180', '1187');
INSERT INTO `t_areas` VALUES ('1188', '福州市', '350000', '1', '14', '1188');
INSERT INTO `t_areas` VALUES ('1189', '鼓楼区', '350000', '1', '1188', '1189');
INSERT INTO `t_areas` VALUES ('1190', '台江区', '350000', '1', '1188', '1190');
INSERT INTO `t_areas` VALUES ('1191', '仓山区', '350000', '1', '1188', '1191');
INSERT INTO `t_areas` VALUES ('1192', '马尾区', '350000', '1', '1188', '1192');
INSERT INTO `t_areas` VALUES ('1193', '晋安区', '350000', '1', '1188', '1193');
INSERT INTO `t_areas` VALUES ('1194', '闽侯县', '350100', '1', '1188', '1194');
INSERT INTO `t_areas` VALUES ('1195', '连江县', '350500', '1', '1188', '1195');
INSERT INTO `t_areas` VALUES ('1196', '罗源县', '350600', '1', '1188', '1196');
INSERT INTO `t_areas` VALUES ('1197', '闽清县', '350800', '1', '1188', '1197');
INSERT INTO `t_areas` VALUES ('1198', '永泰县', '350700', '1', '1188', '1198');
INSERT INTO `t_areas` VALUES ('1199', '平潭县', '350400', '1', '1188', '1199');
INSERT INTO `t_areas` VALUES ('1200', '福清市', '350300', '1', '1188', '1200');
INSERT INTO `t_areas` VALUES ('1201', '长乐市', '350200', '1', '1188', '1201');
INSERT INTO `t_areas` VALUES ('1202', '厦门市', '361000', '1', '14', '1202');
INSERT INTO `t_areas` VALUES ('1203', '思明区', '361000', '1', '1202', '1203');
INSERT INTO `t_areas` VALUES ('1204', '海沧区', '361000', '1', '1202', '1204');
INSERT INTO `t_areas` VALUES ('1205', '湖里区', '361000', '1', '1202', '1205');
INSERT INTO `t_areas` VALUES ('1206', '集美区', '361000', '1', '1202', '1206');
INSERT INTO `t_areas` VALUES ('1207', '同安区', '361100', '1', '1202', '1207');
INSERT INTO `t_areas` VALUES ('1208', '翔安区', '361100', '1', '1202', '1208');
INSERT INTO `t_areas` VALUES ('1209', '莆田市', '351100', '1', '14', '1209');
INSERT INTO `t_areas` VALUES ('1210', '城厢区', '351100', '1', '1209', '1210');
INSERT INTO `t_areas` VALUES ('1211', '涵江区', '351100', '1', '1209', '1211');
INSERT INTO `t_areas` VALUES ('1212', '荔城区', '351100', '1', '1209', '1212');
INSERT INTO `t_areas` VALUES ('1213', '秀屿区', '351100', '1', '1209', '1213');
INSERT INTO `t_areas` VALUES ('1214', '仙游县', '351200', '1', '1209', '1214');
INSERT INTO `t_areas` VALUES ('1215', '三明市', '365000', '1', '14', '1215');
INSERT INTO `t_areas` VALUES ('1216', '梅列区', '365000', '1', '1215', '1216');
INSERT INTO `t_areas` VALUES ('1217', '三元区', '365000', '1', '1215', '1217');
INSERT INTO `t_areas` VALUES ('1218', '明溪县', '365300', '1', '1215', '1218');
INSERT INTO `t_areas` VALUES ('1219', '清流县', '365300', '1', '1215', '1219');
INSERT INTO `t_areas` VALUES ('1220', '宁化县', '365400', '1', '1215', '1220');
INSERT INTO `t_areas` VALUES ('1221', '大田县', '366100', '1', '1215', '1221');
INSERT INTO `t_areas` VALUES ('1222', '尤溪县', '365100', '1', '1215', '1222');
INSERT INTO `t_areas` VALUES ('1223', '沙县', '365500', '1', '1215', '1223');
INSERT INTO `t_areas` VALUES ('1224', '将乐县', '353300', '1', '1215', '1224');
INSERT INTO `t_areas` VALUES ('1225', '泰宁县', '354400', '1', '1215', '1225');
INSERT INTO `t_areas` VALUES ('1226', '建宁县', '354500', '1', '1215', '1226');
INSERT INTO `t_areas` VALUES ('1227', '永安市', '366000', '1', '1215', '1227');
INSERT INTO `t_areas` VALUES ('1228', '泉州市', '362000', '1', '14', '1228');
INSERT INTO `t_areas` VALUES ('1229', '鲤城区', '362000', '1', '1228', '1229');
INSERT INTO `t_areas` VALUES ('1230', '丰泽区', '362000', '1', '1228', '1230');
INSERT INTO `t_areas` VALUES ('1231', '洛江区', '362000', '1', '1228', '1231');
INSERT INTO `t_areas` VALUES ('1232', '泉港区', '362100', '1', '1228', '1232');
INSERT INTO `t_areas` VALUES ('1233', '惠安县', '362100', '1', '1228', '1233');
INSERT INTO `t_areas` VALUES ('1234', '安溪县', '362400', '1', '1228', '1234');
INSERT INTO `t_areas` VALUES ('1235', '永春县', '362600', '1', '1228', '1235');
INSERT INTO `t_areas` VALUES ('1236', '德化县', '362500', '1', '1228', '1236');
INSERT INTO `t_areas` VALUES ('1237', '金门县', '362000', '1', '1228', '1237');
INSERT INTO `t_areas` VALUES ('1238', '石狮市', '362700', '1', '1228', '1238');
INSERT INTO `t_areas` VALUES ('1239', '晋江市', '362200', '1', '1228', '1239');
INSERT INTO `t_areas` VALUES ('1240', '南安市', '362300', '1', '1228', '1240');
INSERT INTO `t_areas` VALUES ('1241', '漳州市', '363000', '1', '14', '1241');
INSERT INTO `t_areas` VALUES ('1242', '芗城区', '363000', '1', '1241', '1242');
INSERT INTO `t_areas` VALUES ('1243', '龙文区', '363000', '1', '1241', '1243');
INSERT INTO `t_areas` VALUES ('1244', '云霄县', '363300', '1', '1241', '1244');
INSERT INTO `t_areas` VALUES ('1245', '漳浦县', '363200', '1', '1241', '1245');
INSERT INTO `t_areas` VALUES ('1246', '诏安县', '363500', '1', '1241', '1246');
INSERT INTO `t_areas` VALUES ('1247', '长泰县', '363900', '1', '1241', '1247');
INSERT INTO `t_areas` VALUES ('1248', '东山县', '363400', '1', '1241', '1248');
INSERT INTO `t_areas` VALUES ('1249', '南靖县', '363600', '1', '1241', '1249');
INSERT INTO `t_areas` VALUES ('1250', '平和县', '363700', '1', '1241', '1250');
INSERT INTO `t_areas` VALUES ('1251', '华安县', '363800', '1', '1241', '1251');
INSERT INTO `t_areas` VALUES ('1252', '龙海市', '363100', '1', '1241', '1252');
INSERT INTO `t_areas` VALUES ('1253', '南平市', '353000', '1', '14', '1253');
INSERT INTO `t_areas` VALUES ('1254', '延平区', '353000', '1', '1253', '1254');
INSERT INTO `t_areas` VALUES ('1255', '顺昌县', '353200', '1', '1253', '1255');
INSERT INTO `t_areas` VALUES ('1256', '浦城县', '353400', '1', '1253', '1256');
INSERT INTO `t_areas` VALUES ('1257', '光泽县', '354100', '1', '1253', '1257');
INSERT INTO `t_areas` VALUES ('1258', '松溪县', '353500', '1', '1253', '1258');
INSERT INTO `t_areas` VALUES ('1259', '政和县', '353600', '1', '1253', '1259');
INSERT INTO `t_areas` VALUES ('1260', '邵武市', '354000', '1', '1253', '1260');
INSERT INTO `t_areas` VALUES ('1261', '武夷山市', '354300', '1', '1253', '1261');
INSERT INTO `t_areas` VALUES ('1262', '建瓯市', '353100', '1', '1253', '1262');
INSERT INTO `t_areas` VALUES ('1263', '建阳市', '354200', '1', '1253', '1263');
INSERT INTO `t_areas` VALUES ('1264', '龙岩市', '364000', '1', '14', '1264');
INSERT INTO `t_areas` VALUES ('1265', '新罗区', '364000', '1', '1264', '1265');
INSERT INTO `t_areas` VALUES ('1266', '长汀县', '366300', '1', '1264', '1266');
INSERT INTO `t_areas` VALUES ('1267', '永定县', '364100', '1', '1264', '1267');
INSERT INTO `t_areas` VALUES ('1268', '上杭县', '364200', '1', '1264', '1268');
INSERT INTO `t_areas` VALUES ('1269', '武平县', '364300', '1', '1264', '1269');
INSERT INTO `t_areas` VALUES ('1270', '连城县', '366200', '1', '1264', '1270');
INSERT INTO `t_areas` VALUES ('1271', '漳平市', '364400', '1', '1264', '1271');
INSERT INTO `t_areas` VALUES ('1272', '宁德市', '352000', '1', '14', '1272');
INSERT INTO `t_areas` VALUES ('1273', '蕉城区', '352000', '1', '1272', '1273');
INSERT INTO `t_areas` VALUES ('1274', '霞浦县', '355100', '1', '1272', '1274');
INSERT INTO `t_areas` VALUES ('1275', '古田县', '352200', '1', '1272', '1275');
INSERT INTO `t_areas` VALUES ('1276', '屏南县', '352300', '1', '1272', '1276');
INSERT INTO `t_areas` VALUES ('1277', '寿宁县', '355500', '1', '1272', '1277');
INSERT INTO `t_areas` VALUES ('1278', '周宁县', '355400', '1', '1272', '1278');
INSERT INTO `t_areas` VALUES ('1279', '柘荣县', '355300', '1', '1272', '1279');
INSERT INTO `t_areas` VALUES ('1280', '福安市', '355000', '1', '1272', '1280');
INSERT INTO `t_areas` VALUES ('1281', '福鼎市', '355200', '1', '1272', '1281');
INSERT INTO `t_areas` VALUES ('1282', '南昌市', '330000', '1', '15', '1282');
INSERT INTO `t_areas` VALUES ('1283', '东湖区', '330000', '1', '1282', '1283');
INSERT INTO `t_areas` VALUES ('1284', '西湖区', '330000', '1', '1282', '1284');
INSERT INTO `t_areas` VALUES ('1285', '青云谱区', '330000', '1', '1282', '1285');
INSERT INTO `t_areas` VALUES ('1286', '湾里区', '330000', '1', '1282', '1286');
INSERT INTO `t_areas` VALUES ('1287', '青山湖区', '330000', '1', '1282', '1287');
INSERT INTO `t_areas` VALUES ('1288', '南昌县', '330200', '1', '1282', '1288');
INSERT INTO `t_areas` VALUES ('1289', '新建县', '330100', '1', '1282', '1289');
INSERT INTO `t_areas` VALUES ('1290', '安义县', '330500', '1', '1282', '1290');
INSERT INTO `t_areas` VALUES ('1291', '进贤县', '331700', '1', '1282', '1291');
INSERT INTO `t_areas` VALUES ('1292', '景德镇市', '333000', '1', '15', '1292');
INSERT INTO `t_areas` VALUES ('1293', '昌江区', '333000', '1', '1292', '1293');
INSERT INTO `t_areas` VALUES ('1294', '珠山区', '333000', '1', '1292', '1294');
INSERT INTO `t_areas` VALUES ('1295', '浮梁县', '333400', '1', '1292', '1295');
INSERT INTO `t_areas` VALUES ('1296', '乐平市', '333300', '1', '1292', '1296');
INSERT INTO `t_areas` VALUES ('1297', '萍乡市', '337000', '1', '15', '1297');
INSERT INTO `t_areas` VALUES ('1298', '安源区', '337000', '1', '1297', '1298');
INSERT INTO `t_areas` VALUES ('1299', '湘东区', '337000', '1', '1297', '1299');
INSERT INTO `t_areas` VALUES ('1300', '莲花县', '337100', '1', '1297', '1300');
INSERT INTO `t_areas` VALUES ('1301', '上栗县', '337000', '1', '1297', '1301');
INSERT INTO `t_areas` VALUES ('1302', '芦溪县', '337000', '1', '1297', '1302');
INSERT INTO `t_areas` VALUES ('1303', '九江市', '332000', '1', '15', '1303');
INSERT INTO `t_areas` VALUES ('1304', '庐山区', '332900', '1', '1303', '1304');
INSERT INTO `t_areas` VALUES ('1305', '浔阳区', '332000', '1', '1303', '1305');
INSERT INTO `t_areas` VALUES ('1306', '九江县', '332100', '1', '1303', '1306');
INSERT INTO `t_areas` VALUES ('1307', '武宁县', '332300', '1', '1303', '1307');
INSERT INTO `t_areas` VALUES ('1308', '修水县', '332400', '1', '1303', '1308');
INSERT INTO `t_areas` VALUES ('1309', '永修县', '330300', '1', '1303', '1309');
INSERT INTO `t_areas` VALUES ('1310', '德安县', '330400', '1', '1303', '1310');
INSERT INTO `t_areas` VALUES ('1311', '星子县', '332800', '1', '1303', '1311');
INSERT INTO `t_areas` VALUES ('1312', '都昌县', '332600', '1', '1303', '1312');
INSERT INTO `t_areas` VALUES ('1313', '湖口县', '332500', '1', '1303', '1313');
INSERT INTO `t_areas` VALUES ('1314', '彭泽县', '332700', '1', '1303', '1314');
INSERT INTO `t_areas` VALUES ('1315', '瑞昌市', '332200', '1', '1303', '1315');
INSERT INTO `t_areas` VALUES ('1316', '新余市', '336500', '1', '15', '1316');
INSERT INTO `t_areas` VALUES ('1317', '渝水区', '336500', '1', '1316', '1317');
INSERT INTO `t_areas` VALUES ('1318', '分宜县', '336600', '1', '1316', '1318');
INSERT INTO `t_areas` VALUES ('1319', '鹰潭市', '335000', '1', '15', '1319');
INSERT INTO `t_areas` VALUES ('1320', '月湖区', '335000', '1', '1319', '1320');
INSERT INTO `t_areas` VALUES ('1321', '余江县', '335200', '1', '1319', '1321');
INSERT INTO `t_areas` VALUES ('1322', '贵溪市', '335400', '1', '1319', '1322');
INSERT INTO `t_areas` VALUES ('1323', '赣州市', '341000', '1', '15', '1323');
INSERT INTO `t_areas` VALUES ('1324', '章贡区', '341000', '1', '1323', '1324');
INSERT INTO `t_areas` VALUES ('1325', '赣县', '341100', '1', '1323', '1325');
INSERT INTO `t_areas` VALUES ('1326', '信丰县', '341600', '1', '1323', '1326');
INSERT INTO `t_areas` VALUES ('1327', '大余县', '341500', '1', '1323', '1327');
INSERT INTO `t_areas` VALUES ('1328', '上犹县', '341200', '1', '1323', '1328');
INSERT INTO `t_areas` VALUES ('1329', '崇义县', '341300', '1', '1323', '1329');
INSERT INTO `t_areas` VALUES ('1330', '安远县', '342100', '1', '1323', '1330');
INSERT INTO `t_areas` VALUES ('1331', '龙南县', '341700', '1', '1323', '1331');
INSERT INTO `t_areas` VALUES ('1332', '定南县', '341900', '1', '1323', '1332');
INSERT INTO `t_areas` VALUES ('1333', '全南县', '341800', '1', '1323', '1333');
INSERT INTO `t_areas` VALUES ('1334', '宁都县', '342800', '1', '1323', '1334');
INSERT INTO `t_areas` VALUES ('1335', '于都县', '342300', '1', '1323', '1335');
INSERT INTO `t_areas` VALUES ('1336', '兴国县', '342400', '1', '1323', '1336');
INSERT INTO `t_areas` VALUES ('1337', '会昌县', '342600', '1', '1323', '1337');
INSERT INTO `t_areas` VALUES ('1338', '寻乌县', '342200', '1', '1323', '1338');
INSERT INTO `t_areas` VALUES ('1339', '石城县', '342700', '1', '1323', '1339');
INSERT INTO `t_areas` VALUES ('1340', '瑞金市', '342500', '1', '1323', '1340');
INSERT INTO `t_areas` VALUES ('1341', '南康市', '341400', '1', '1323', '1341');
INSERT INTO `t_areas` VALUES ('1342', '吉安市', '343000', '1', '15', '1342');
INSERT INTO `t_areas` VALUES ('1343', '吉州区', '343000', '1', '1342', '1343');
INSERT INTO `t_areas` VALUES ('1344', '青原区', '343000', '1', '1342', '1344');
INSERT INTO `t_areas` VALUES ('1345', '吉安县', '343100', '1', '1342', '1345');
INSERT INTO `t_areas` VALUES ('1346', '吉水县', '331600', '1', '1342', '1346');
INSERT INTO `t_areas` VALUES ('1347', '峡江县', '331400', '1', '1342', '1347');
INSERT INTO `t_areas` VALUES ('1348', '新干县', '331300', '1', '1342', '1348');
INSERT INTO `t_areas` VALUES ('1349', '永丰县', '331500', '1', '1342', '1349');
INSERT INTO `t_areas` VALUES ('1350', '泰和县', '343700', '1', '1342', '1350');
INSERT INTO `t_areas` VALUES ('1351', '遂川县', '343900', '1', '1342', '1351');
INSERT INTO `t_areas` VALUES ('1352', '万安县', '343800', '1', '1342', '1352');
INSERT INTO `t_areas` VALUES ('1353', '安福县', '343200', '1', '1342', '1353');
INSERT INTO `t_areas` VALUES ('1354', '永新县', '343400', '1', '1342', '1354');
INSERT INTO `t_areas` VALUES ('1355', '井冈山市', '343600', '1', '1342', '1355');
INSERT INTO `t_areas` VALUES ('1356', '宜春市', '336000', '1', '15', '1356');
INSERT INTO `t_areas` VALUES ('1357', '袁州区', '336000', '1', '1356', '1357');
INSERT INTO `t_areas` VALUES ('1358', '奉新县', '330700', '1', '1356', '1358');
INSERT INTO `t_areas` VALUES ('1359', '万载县', '336100', '1', '1356', '1359');
INSERT INTO `t_areas` VALUES ('1360', '上高县', '336400', '1', '1356', '1360');
INSERT INTO `t_areas` VALUES ('1361', '宜丰县', '336300', '1', '1356', '1361');
INSERT INTO `t_areas` VALUES ('1362', '靖安县', '330600', '1', '1356', '1362');
INSERT INTO `t_areas` VALUES ('1363', '铜鼓县', '336200', '1', '1356', '1363');
INSERT INTO `t_areas` VALUES ('1364', '丰城市', '331100', '1', '1356', '1364');
INSERT INTO `t_areas` VALUES ('1365', '樟树市', '331200', '1', '1356', '1365');
INSERT INTO `t_areas` VALUES ('1366', '高安市', '330800', '1', '1356', '1366');
INSERT INTO `t_areas` VALUES ('1367', '抚州市', '344000', '1', '15', '1367');
INSERT INTO `t_areas` VALUES ('1368', '临川区', '344100', '1', '1367', '1368');
INSERT INTO `t_areas` VALUES ('1369', '南城县', '344700', '1', '1367', '1369');
INSERT INTO `t_areas` VALUES ('1370', '黎川县', '344600', '1', '1367', '1370');
INSERT INTO `t_areas` VALUES ('1371', '南丰县', '344500', '1', '1367', '1371');
INSERT INTO `t_areas` VALUES ('1372', '崇仁县', '344200', '1', '1367', '1372');
INSERT INTO `t_areas` VALUES ('1373', '乐安县', '344300', '1', '1367', '1373');
INSERT INTO `t_areas` VALUES ('1374', '宜黄县', '344400', '1', '1367', '1374');
INSERT INTO `t_areas` VALUES ('1375', '金溪县', '344800', '1', '1367', '1375');
INSERT INTO `t_areas` VALUES ('1376', '资溪县', '335300', '1', '1367', '1376');
INSERT INTO `t_areas` VALUES ('1377', '东乡县', '331800', '1', '1367', '1377');
INSERT INTO `t_areas` VALUES ('1378', '广昌县', '344900', '1', '1367', '1378');
INSERT INTO `t_areas` VALUES ('1379', '上饶市', '334000', '1', '15', '1379');
INSERT INTO `t_areas` VALUES ('1380', '信州区', '334000', '1', '1379', '1380');
INSERT INTO `t_areas` VALUES ('1381', '上饶县', '334100', '1', '1379', '1381');
INSERT INTO `t_areas` VALUES ('1382', '广丰县', '334600', '1', '1379', '1382');
INSERT INTO `t_areas` VALUES ('1383', '玉山县', '334700', '1', '1379', '1383');
INSERT INTO `t_areas` VALUES ('1384', '铅山县', '334500', '1', '1379', '1384');
INSERT INTO `t_areas` VALUES ('1385', '横峰县', '334300', '1', '1379', '1385');
INSERT INTO `t_areas` VALUES ('1386', '弋阳县', '334400', '1', '1379', '1386');
INSERT INTO `t_areas` VALUES ('1387', '余干县', '335100', '1', '1379', '1387');
INSERT INTO `t_areas` VALUES ('1388', '鄱阳县', '333100', '1', '1379', '1388');
INSERT INTO `t_areas` VALUES ('1389', '万年县', '335500', '1', '1379', '1389');
INSERT INTO `t_areas` VALUES ('1390', '婺源县', '333200', '1', '1379', '1390');
INSERT INTO `t_areas` VALUES ('1391', '德兴市', '334200', '1', '1379', '1391');
INSERT INTO `t_areas` VALUES ('1392', '济南市', '250000', '1', '16', '1392');
INSERT INTO `t_areas` VALUES ('1393', '历下区', '250000', '1', '1392', '1393');
INSERT INTO `t_areas` VALUES ('1394', '市中区', '250000', '1', '1392', '1394');
INSERT INTO `t_areas` VALUES ('1395', '槐荫区', '250000', '1', '1392', '1395');
INSERT INTO `t_areas` VALUES ('1396', '天桥区', '250000', '1', '1392', '1396');
INSERT INTO `t_areas` VALUES ('1397', '历城区', '250100', '1', '1392', '1397');
INSERT INTO `t_areas` VALUES ('1398', '长清区', '250300', '1', '1392', '1398');
INSERT INTO `t_areas` VALUES ('1399', '平阴县', '250400', '1', '1392', '1399');
INSERT INTO `t_areas` VALUES ('1400', '济阳县', '251400', '1', '1392', '1400');
INSERT INTO `t_areas` VALUES ('1401', '商河县', '251600', '1', '1392', '1401');
INSERT INTO `t_areas` VALUES ('1402', '章丘市', '250200', '1', '1392', '1402');
INSERT INTO `t_areas` VALUES ('1403', '青岛市', '266000', '1', '16', '1403');
INSERT INTO `t_areas` VALUES ('1404', '市南区', '266000', '1', '1403', '1404');
INSERT INTO `t_areas` VALUES ('1405', '市北区', '266000', '1', '1403', '1405');
INSERT INTO `t_areas` VALUES ('1406', '四方区', '266000', '1', '1403', '1406');
INSERT INTO `t_areas` VALUES ('1407', '黄岛区', '266000', '1', '1403', '1407');
INSERT INTO `t_areas` VALUES ('1408', '崂山区', '266100', '1', '1403', '1408');
INSERT INTO `t_areas` VALUES ('1409', '李沧区', '266000', '1', '1403', '1409');
INSERT INTO `t_areas` VALUES ('1410', '城阳区', '266000', '1', '1403', '1410');
INSERT INTO `t_areas` VALUES ('1411', '胶州市', '266300', '1', '1403', '1411');
INSERT INTO `t_areas` VALUES ('1412', '即墨市', '266200', '1', '1403', '1412');
INSERT INTO `t_areas` VALUES ('1413', '平度市', '266700', '1', '1403', '1413');
INSERT INTO `t_areas` VALUES ('1414', '胶南市', '266400', '1', '1403', '1414');
INSERT INTO `t_areas` VALUES ('1415', '莱西市', '266600', '1', '1403', '1415');
INSERT INTO `t_areas` VALUES ('1416', '淄博市', '255100', '1', '16', '1416');
INSERT INTO `t_areas` VALUES ('1417', '淄川区', '255100', '1', '1416', '1417');
INSERT INTO `t_areas` VALUES ('1418', '张店区', '255000', '1', '1416', '1418');
INSERT INTO `t_areas` VALUES ('1419', '博山区', '255200', '1', '1416', '1419');
INSERT INTO `t_areas` VALUES ('1420', '临淄区', '255400', '1', '1416', '1420');
INSERT INTO `t_areas` VALUES ('1421', '周村区', '255300', '1', '1416', '1421');
INSERT INTO `t_areas` VALUES ('1422', '桓台县', '256400', '1', '1416', '1422');
INSERT INTO `t_areas` VALUES ('1423', '高青县', '256300', '1', '1416', '1423');
INSERT INTO `t_areas` VALUES ('1424', '沂源县', '256100', '1', '1416', '1424');
INSERT INTO `t_areas` VALUES ('1425', '枣庄市', '277000', '1', '16', '1425');
INSERT INTO `t_areas` VALUES ('1426', '市中区', '277000', '1', '1425', '1426');
INSERT INTO `t_areas` VALUES ('1427', '薛城区', '277000', '1', '1425', '1427');
INSERT INTO `t_areas` VALUES ('1428', '峄城区', '277300', '1', '1425', '1428');
INSERT INTO `t_areas` VALUES ('1429', '台儿庄区', '277400', '1', '1425', '1429');
INSERT INTO `t_areas` VALUES ('1430', '山亭区', '277200', '1', '1425', '1430');
INSERT INTO `t_areas` VALUES ('1431', '滕州市', '277500', '1', '1425', '1431');
INSERT INTO `t_areas` VALUES ('1432', '东营市', '257000', '1', '16', '1432');
INSERT INTO `t_areas` VALUES ('1433', '东营区', '257100', '1', '1432', '1433');
INSERT INTO `t_areas` VALUES ('1434', '河口区', '257200', '1', '1432', '1434');
INSERT INTO `t_areas` VALUES ('1435', '垦利县', '257500', '1', '1432', '1435');
INSERT INTO `t_areas` VALUES ('1436', '利津县', '257400', '1', '1432', '1436');
INSERT INTO `t_areas` VALUES ('1437', '广饶县', '257300', '1', '1432', '1437');
INSERT INTO `t_areas` VALUES ('1438', '烟台市', '264000', '1', '16', '1438');
INSERT INTO `t_areas` VALUES ('1439', '芝罘区', '264000', '1', '1438', '1439');
INSERT INTO `t_areas` VALUES ('1440', '福山区', '265500', '1', '1438', '1440');
INSERT INTO `t_areas` VALUES ('1441', '牟平区', '264100', '1', '1438', '1441');
INSERT INTO `t_areas` VALUES ('1442', '莱山区', '264000', '1', '1438', '1442');
INSERT INTO `t_areas` VALUES ('1443', '长岛县', '265800', '1', '1438', '1443');
INSERT INTO `t_areas` VALUES ('1444', '龙口市', '265700', '1', '1438', '1444');
INSERT INTO `t_areas` VALUES ('1445', '莱阳市', '265200', '1', '1438', '1445');
INSERT INTO `t_areas` VALUES ('1446', '莱州市', '261400', '1', '1438', '1446');
INSERT INTO `t_areas` VALUES ('1447', '蓬莱市', '265600', '1', '1438', '1447');
INSERT INTO `t_areas` VALUES ('1448', '招远市', '265400', '1', '1438', '1448');
INSERT INTO `t_areas` VALUES ('1449', '栖霞市', '265300', '1', '1438', '1449');
INSERT INTO `t_areas` VALUES ('1450', '海阳市', '265100', '1', '1438', '1450');
INSERT INTO `t_areas` VALUES ('1451', '潍坊市', '261000', '1', '16', '1451');
INSERT INTO `t_areas` VALUES ('1452', '潍城区', '261000', '1', '1451', '1452');
INSERT INTO `t_areas` VALUES ('1453', '寒亭区', '261100', '1', '1451', '1453');
INSERT INTO `t_areas` VALUES ('1454', '坊子区', '261200', '1', '1451', '1454');
INSERT INTO `t_areas` VALUES ('1455', '奎文区', '261000', '1', '1451', '1455');
INSERT INTO `t_areas` VALUES ('1456', '临朐县', '262600', '1', '1451', '1456');
INSERT INTO `t_areas` VALUES ('1457', '昌乐县', '262400', '1', '1451', '1457');
INSERT INTO `t_areas` VALUES ('1458', '青州市', '262500', '1', '1451', '1458');
INSERT INTO `t_areas` VALUES ('1459', '诸城市', '262200', '1', '1451', '1459');
INSERT INTO `t_areas` VALUES ('1460', '寿光市', '262700', '1', '1451', '1460');
INSERT INTO `t_areas` VALUES ('1461', '安丘市', '262100', '1', '1451', '1461');
INSERT INTO `t_areas` VALUES ('1462', '高密市', '261500', '1', '1451', '1462');
INSERT INTO `t_areas` VALUES ('1463', '昌邑市', '261300', '1', '1451', '1463');
INSERT INTO `t_areas` VALUES ('1464', '济宁市', '272000', '1', '16', '1464');
INSERT INTO `t_areas` VALUES ('1465', '市中区', '272000', '1', '1464', '1465');
INSERT INTO `t_areas` VALUES ('1466', '任城区', '272000', '1', '1464', '1466');
INSERT INTO `t_areas` VALUES ('1467', '微山县', '277600', '1', '1464', '1467');
INSERT INTO `t_areas` VALUES ('1468', '鱼台县', '272300', '1', '1464', '1468');
INSERT INTO `t_areas` VALUES ('1469', '金乡县', '272200', '1', '1464', '1469');
INSERT INTO `t_areas` VALUES ('1470', '嘉祥县', '272400', '1', '1464', '1470');
INSERT INTO `t_areas` VALUES ('1471', '汶上县', '272500', '1', '1464', '1471');
INSERT INTO `t_areas` VALUES ('1472', '泗水县', '273200', '1', '1464', '1472');
INSERT INTO `t_areas` VALUES ('1473', '梁山县', '272600', '1', '1464', '1473');
INSERT INTO `t_areas` VALUES ('1474', '曲阜市', '273100', '1', '1464', '1474');
INSERT INTO `t_areas` VALUES ('1475', '兖州市', '272000', '1', '1464', '1475');
INSERT INTO `t_areas` VALUES ('1476', '邹城市', '273500', '1', '1464', '1476');
INSERT INTO `t_areas` VALUES ('1477', '泰安市', '271000', '1', '16', '1477');
INSERT INTO `t_areas` VALUES ('1478', '泰山区', '271000', '1', '1477', '1478');
INSERT INTO `t_areas` VALUES ('1479', '岱岳区', '271000', '1', '1477', '1479');
INSERT INTO `t_areas` VALUES ('1480', '宁阳县', '271400', '1', '1477', '1480');
INSERT INTO `t_areas` VALUES ('1481', '东平县', '271500', '1', '1477', '1481');
INSERT INTO `t_areas` VALUES ('1482', '新泰市', '271200', '1', '1477', '1482');
INSERT INTO `t_areas` VALUES ('1483', '肥城市', '271600', '1', '1477', '1483');
INSERT INTO `t_areas` VALUES ('1484', '威海市', '264000', '1', '16', '1484');
INSERT INTO `t_areas` VALUES ('1485', '环翠区', '264200', '1', '1484', '1485');
INSERT INTO `t_areas` VALUES ('1486', '文登市', '264400', '1', '1484', '1486');
INSERT INTO `t_areas` VALUES ('1487', '荣成市', '264300', '1', '1484', '1487');
INSERT INTO `t_areas` VALUES ('1488', '乳山市', '264500', '1', '1484', '1488');
INSERT INTO `t_areas` VALUES ('1489', '日照市', '276800', '1', '16', '1489');
INSERT INTO `t_areas` VALUES ('1490', '东港区', '276800', '1', '1489', '1490');
INSERT INTO `t_areas` VALUES ('1491', '岚山区', '276800', '1', '1489', '1491');
INSERT INTO `t_areas` VALUES ('1492', '五莲县', '262300', '1', '1489', '1492');
INSERT INTO `t_areas` VALUES ('1493', '莒县', '276500', '1', '1489', '1493');
INSERT INTO `t_areas` VALUES ('1494', '莱芜市', '271100', '1', '16', '1494');
INSERT INTO `t_areas` VALUES ('1495', '莱城区', '271100', '1', '1494', '1495');
INSERT INTO `t_areas` VALUES ('1496', '钢城区', '271100', '1', '1494', '1496');
INSERT INTO `t_areas` VALUES ('1497', '临沂市', '276000', '1', '16', '1497');
INSERT INTO `t_areas` VALUES ('1498', '兰山区', '276000', '1', '1497', '1498');
INSERT INTO `t_areas` VALUES ('1499', '罗庄区', '276000', '1', '1497', '1499');
INSERT INTO `t_areas` VALUES ('1500', '河东区', '276000', '1', '1497', '1500');
INSERT INTO `t_areas` VALUES ('1501', '沂南县', '276300', '1', '1497', '1501');
INSERT INTO `t_areas` VALUES ('1502', '郯城县', '276100', '1', '1497', '1502');
INSERT INTO `t_areas` VALUES ('1503', '沂水县', '276400', '1', '1497', '1503');
INSERT INTO `t_areas` VALUES ('1504', '苍山县', '277700', '1', '1497', '1504');
INSERT INTO `t_areas` VALUES ('1505', '费县', '273400', '1', '1497', '1505');
INSERT INTO `t_areas` VALUES ('1506', '平邑县', '273300', '1', '1497', '1506');
INSERT INTO `t_areas` VALUES ('1507', '莒南县', '276600', '1', '1497', '1507');
INSERT INTO `t_areas` VALUES ('1508', '蒙阴县', '276200', '1', '1497', '1508');
INSERT INTO `t_areas` VALUES ('1509', '临沭县', '276700', '1', '1497', '1509');
INSERT INTO `t_areas` VALUES ('1510', '德州市', '253000', '1', '16', '1510');
INSERT INTO `t_areas` VALUES ('1511', '德城区', '253000', '1', '1510', '1511');
INSERT INTO `t_areas` VALUES ('1512', '陵县', '253500', '1', '1510', '1512');
INSERT INTO `t_areas` VALUES ('1513', '宁津县', '253400', '1', '1510', '1513');
INSERT INTO `t_areas` VALUES ('1514', '庆云县', '253700', '1', '1510', '1514');
INSERT INTO `t_areas` VALUES ('1515', '临邑县', '251500', '1', '1510', '1515');
INSERT INTO `t_areas` VALUES ('1516', '齐河县', '251100', '1', '1510', '1516');
INSERT INTO `t_areas` VALUES ('1517', '平原县', '253100', '1', '1510', '1517');
INSERT INTO `t_areas` VALUES ('1518', '夏津县', '253200', '1', '1510', '1518');
INSERT INTO `t_areas` VALUES ('1519', '武城县', '253300', '1', '1510', '1519');
INSERT INTO `t_areas` VALUES ('1520', '乐陵市', '253600', '1', '1510', '1520');
INSERT INTO `t_areas` VALUES ('1521', '禹城市', '251200', '1', '1510', '1521');
INSERT INTO `t_areas` VALUES ('1522', '聊城市', '252000', '1', '16', '1522');
INSERT INTO `t_areas` VALUES ('1523', '东昌府区', '252000', '1', '1522', '1523');
INSERT INTO `t_areas` VALUES ('1524', '阳谷县', '252300', '1', '1522', '1524');
INSERT INTO `t_areas` VALUES ('1525', '莘县', '252400', '1', '1522', '1525');
INSERT INTO `t_areas` VALUES ('1526', '茌平县', '252100', '1', '1522', '1526');
INSERT INTO `t_areas` VALUES ('1527', '东阿县', '252200', '1', '1522', '1527');
INSERT INTO `t_areas` VALUES ('1528', '冠县', '252500', '1', '1522', '1528');
INSERT INTO `t_areas` VALUES ('1529', '高唐县', '252800', '1', '1522', '1529');
INSERT INTO `t_areas` VALUES ('1530', '临清市', '252600', '1', '1522', '1530');
INSERT INTO `t_areas` VALUES ('1531', '滨州市', '256600', '1', '16', '1531');
INSERT INTO `t_areas` VALUES ('1532', '滨城区', '256600', '1', '1531', '1532');
INSERT INTO `t_areas` VALUES ('1533', '惠民县', '251700', '1', '1531', '1533');
INSERT INTO `t_areas` VALUES ('1534', '阳信县', '251800', '1', '1531', '1534');
INSERT INTO `t_areas` VALUES ('1535', '无棣县', '251900', '1', '1531', '1535');
INSERT INTO `t_areas` VALUES ('1536', '沾化县', '256800', '1', '1531', '1536');
INSERT INTO `t_areas` VALUES ('1537', '博兴县', '256500', '1', '1531', '1537');
INSERT INTO `t_areas` VALUES ('1538', '邹平县', '256200', '1', '1531', '1538');
INSERT INTO `t_areas` VALUES ('1539', '菏泽市', '274000', '1', '16', '1539');
INSERT INTO `t_areas` VALUES ('1540', '牡丹区', '274000', '1', '1539', '1540');
INSERT INTO `t_areas` VALUES ('1541', '曹县', '274400', '1', '1539', '1541');
INSERT INTO `t_areas` VALUES ('1542', '单县', '274300', '1', '1539', '1542');
INSERT INTO `t_areas` VALUES ('1543', '成武县', '274200', '1', '1539', '1543');
INSERT INTO `t_areas` VALUES ('1544', '巨野县', '274900', '1', '1539', '1544');
INSERT INTO `t_areas` VALUES ('1545', '郓城县', '274700', '1', '1539', '1545');
INSERT INTO `t_areas` VALUES ('1546', '鄄城县', '274600', '1', '1539', '1546');
INSERT INTO `t_areas` VALUES ('1547', '定陶县', '274100', '1', '1539', '1547');
INSERT INTO `t_areas` VALUES ('1548', '东明县', '274500', '1', '1539', '1548');
INSERT INTO `t_areas` VALUES ('1549', '郑州市', '450000', '1', '17', '1549');
INSERT INTO `t_areas` VALUES ('1550', '中原区', '450000', '1', '1549', '1550');
INSERT INTO `t_areas` VALUES ('1551', '二七区', '450000', '1', '1549', '1551');
INSERT INTO `t_areas` VALUES ('1552', '管城回族区', '450000', '1', '1549', '1552');
INSERT INTO `t_areas` VALUES ('1553', '金水区', '450000', '1', '1549', '1553');
INSERT INTO `t_areas` VALUES ('1554', '上街区', '450041', '1', '1549', '1554');
INSERT INTO `t_areas` VALUES ('1555', '惠济区', '450000', '1', '1549', '1555');
INSERT INTO `t_areas` VALUES ('1556', '中牟县', '451450', '1', '1549', '1556');
INSERT INTO `t_areas` VALUES ('1557', '巩义市', '452100', '1', '1549', '1557');
INSERT INTO `t_areas` VALUES ('1558', '荥阳市', '450100', '1', '1549', '1558');
INSERT INTO `t_areas` VALUES ('1559', '新密市', '452370', '1', '1549', '1559');
INSERT INTO `t_areas` VALUES ('1560', '新郑市', '451100', '1', '1549', '1560');
INSERT INTO `t_areas` VALUES ('1561', '登封市', '452470', '1', '1549', '1561');
INSERT INTO `t_areas` VALUES ('1562', '开封市', '475000', '1', '17', '1562');
INSERT INTO `t_areas` VALUES ('1563', '龙亭区', '475000', '1', '1562', '1563');
INSERT INTO `t_areas` VALUES ('1564', '顺河回族区', '475000', '1', '1562', '1564');
INSERT INTO `t_areas` VALUES ('1565', '鼓楼区', '475000', '1', '1562', '1565');
INSERT INTO `t_areas` VALUES ('1566', '禹王台区', '475000', '1', '1562', '1566');
INSERT INTO `t_areas` VALUES ('1567', '金明区', '475000', '1', '1562', '1567');
INSERT INTO `t_areas` VALUES ('1568', '杞县', '475200', '1', '1562', '1568');
INSERT INTO `t_areas` VALUES ('1569', '通许县', '452200', '1', '1562', '1569');
INSERT INTO `t_areas` VALUES ('1570', '尉氏县', '452100', '1', '1562', '1570');
INSERT INTO `t_areas` VALUES ('1571', '开封县', '475100', '1', '1562', '1571');
INSERT INTO `t_areas` VALUES ('1572', '兰考县', '475300', '1', '1562', '1572');
INSERT INTO `t_areas` VALUES ('1573', '洛阳市', '471000', '1', '17', '1573');
INSERT INTO `t_areas` VALUES ('1574', '老城区', '471000', '1', '1573', '1574');
INSERT INTO `t_areas` VALUES ('1575', '西工区', '471000', '1', '1573', '1575');
INSERT INTO `t_areas` VALUES ('1576', '瀍河回族区', '471000', '1', '1573', '1576');
INSERT INTO `t_areas` VALUES ('1577', '涧西区', '471000', '1', '1573', '1577');
INSERT INTO `t_areas` VALUES ('1578', '吉利区', '471000', '1', '1573', '1578');
INSERT INTO `t_areas` VALUES ('1579', '洛龙区', '471000', '1', '1573', '1579');
INSERT INTO `t_areas` VALUES ('1580', '孟津县', '471100', '1', '1573', '1580');
INSERT INTO `t_areas` VALUES ('1581', '新安县', '471800', '1', '1573', '1581');
INSERT INTO `t_areas` VALUES ('1582', '栾川县', '471500', '1', '1573', '1582');
INSERT INTO `t_areas` VALUES ('1583', '嵩县', '471400', '1', '1573', '1583');
INSERT INTO `t_areas` VALUES ('1584', '汝阳县', '471200', '1', '1573', '1584');
INSERT INTO `t_areas` VALUES ('1585', '宜阳县', '471600', '1', '1573', '1585');
INSERT INTO `t_areas` VALUES ('1586', '洛宁县', '471700', '1', '1573', '1586');
INSERT INTO `t_areas` VALUES ('1587', '伊川县', '471300', '1', '1573', '1587');
INSERT INTO `t_areas` VALUES ('1588', '偃师市', '471900', '1', '1573', '1588');
INSERT INTO `t_areas` VALUES ('1589', '平顶山市', '467000', '1', '17', '1589');
INSERT INTO `t_areas` VALUES ('1590', '新华区', '467000', '1', '1589', '1590');
INSERT INTO `t_areas` VALUES ('1591', '卫东区', '467000', '1', '1589', '1591');
INSERT INTO `t_areas` VALUES ('1592', '石龙区', '467000', '1', '1589', '1592');
INSERT INTO `t_areas` VALUES ('1593', '湛河区', '467000', '1', '1589', '1593');
INSERT INTO `t_areas` VALUES ('1594', '宝丰县', '467400', '1', '1589', '1594');
INSERT INTO `t_areas` VALUES ('1595', '叶县', '467200', '1', '1589', '1595');
INSERT INTO `t_areas` VALUES ('1596', '鲁山县', '467300', '1', '1589', '1596');
INSERT INTO `t_areas` VALUES ('1597', '郏县', '467100', '1', '1589', '1597');
INSERT INTO `t_areas` VALUES ('1598', '舞钢市', '462500', '1', '1589', '1598');
INSERT INTO `t_areas` VALUES ('1599', '汝州市', '467500', '1', '1589', '1599');
INSERT INTO `t_areas` VALUES ('1600', '安阳市', '455000', '1', '17', '1600');
INSERT INTO `t_areas` VALUES ('1601', '文峰区', '455000', '1', '1600', '1601');
INSERT INTO `t_areas` VALUES ('1602', '北关区', '455000', '1', '1600', '1602');
INSERT INTO `t_areas` VALUES ('1603', '殷都区', '455000', '1', '1600', '1603');
INSERT INTO `t_areas` VALUES ('1604', '龙安区', '455000', '1', '1600', '1604');
INSERT INTO `t_areas` VALUES ('1605', '安阳县', '455100', '1', '1600', '1605');
INSERT INTO `t_areas` VALUES ('1606', '汤阴县', '456150', '1', '1600', '1606');
INSERT INTO `t_areas` VALUES ('1607', '滑县', '456400', '1', '1600', '1607');
INSERT INTO `t_areas` VALUES ('1608', '内黄县', '456300', '1', '1600', '1608');
INSERT INTO `t_areas` VALUES ('1609', '林州市', '456500', '1', '1600', '1609');
INSERT INTO `t_areas` VALUES ('1610', '鹤壁市', '458000', '1', '17', '1610');
INSERT INTO `t_areas` VALUES ('1611', '鹤山区', '458000', '1', '1610', '1611');
INSERT INTO `t_areas` VALUES ('1612', '山城区', '458000', '1', '1610', '1612');
INSERT INTO `t_areas` VALUES ('1613', '淇滨区', '458000', '1', '1610', '1613');
INSERT INTO `t_areas` VALUES ('1614', '浚县', '456250', '1', '1610', '1614');
INSERT INTO `t_areas` VALUES ('1615', '淇县', '456750', '1', '1610', '1615');
INSERT INTO `t_areas` VALUES ('1616', '新乡市', '453000', '1', '17', '1616');
INSERT INTO `t_areas` VALUES ('1617', '红旗区', '453000', '1', '1616', '1617');
INSERT INTO `t_areas` VALUES ('1618', '卫滨区', '453000', '1', '1616', '1618');
INSERT INTO `t_areas` VALUES ('1619', '凤泉区', '453000', '1', '1616', '1619');
INSERT INTO `t_areas` VALUES ('1620', '牧野区', '453000', '1', '1616', '1620');
INSERT INTO `t_areas` VALUES ('1621', '新乡县', '453700', '1', '1616', '1621');
INSERT INTO `t_areas` VALUES ('1622', '获嘉县', '453800', '1', '1616', '1622');
INSERT INTO `t_areas` VALUES ('1623', '原阳县', '453500', '1', '1616', '1623');
INSERT INTO `t_areas` VALUES ('1624', '延津县', '453200', '1', '1616', '1624');
INSERT INTO `t_areas` VALUES ('1625', '封丘县', '453300', '1', '1616', '1625');
INSERT INTO `t_areas` VALUES ('1626', '长垣县', '453400', '1', '1616', '1626');
INSERT INTO `t_areas` VALUES ('1627', '卫辉市', '453100', '1', '1616', '1627');
INSERT INTO `t_areas` VALUES ('1628', '辉县市', '453600', '1', '1616', '1628');
INSERT INTO `t_areas` VALUES ('1629', '焦作市', '454150', '1', '17', '1629');
INSERT INTO `t_areas` VALUES ('1630', '解放区', '454150', '1', '1629', '1630');
INSERT INTO `t_areas` VALUES ('1631', '中站区', '454150', '1', '1629', '1631');
INSERT INTO `t_areas` VALUES ('1632', '马村区', '454150', '1', '1629', '1632');
INSERT INTO `t_areas` VALUES ('1633', '山阳区', '454150', '1', '1629', '1633');
INSERT INTO `t_areas` VALUES ('1634', '修武县', '454350', '1', '1629', '1634');
INSERT INTO `t_areas` VALUES ('1635', '博爱县', '454450', '1', '1629', '1635');
INSERT INTO `t_areas` VALUES ('1636', '武陟县', '454950', '1', '1629', '1636');
INSERT INTO `t_areas` VALUES ('1637', '温县', '454850', '1', '1629', '1637');
INSERT INTO `t_areas` VALUES ('1638', '济源市', '454650', '1', '1629', '1638');
INSERT INTO `t_areas` VALUES ('1639', '沁阳市', '454550', '1', '1629', '1639');
INSERT INTO `t_areas` VALUES ('1640', '孟州市', '454750', '1', '1629', '1640');
INSERT INTO `t_areas` VALUES ('1641', '濮阳市', '457000', '1', '17', '1641');
INSERT INTO `t_areas` VALUES ('1642', '华龙区', '457000', '1', '1641', '1642');
INSERT INTO `t_areas` VALUES ('1643', '清丰县', '457300', '1', '1641', '1643');
INSERT INTO `t_areas` VALUES ('1644', '南乐县', '457400', '1', '1641', '1644');
INSERT INTO `t_areas` VALUES ('1645', '范县', '457500', '1', '1641', '1645');
INSERT INTO `t_areas` VALUES ('1646', '台前县', '457600', '1', '1641', '1646');
INSERT INTO `t_areas` VALUES ('1647', '濮阳县', '457100', '1', '1641', '1647');
INSERT INTO `t_areas` VALUES ('1648', '许昌市', '461000', '1', '17', '1648');
INSERT INTO `t_areas` VALUES ('1649', '魏都区', '461000', '1', '1648', '1649');
INSERT INTO `t_areas` VALUES ('1650', '许昌县', '461100', '1', '1648', '1650');
INSERT INTO `t_areas` VALUES ('1651', '鄢陵县', '461200', '1', '1648', '1651');
INSERT INTO `t_areas` VALUES ('1652', '襄城县', '452670', '1', '1648', '1652');
INSERT INTO `t_areas` VALUES ('1653', '禹州市', '452570', '1', '1648', '1653');
INSERT INTO `t_areas` VALUES ('1654', '长葛市', '461500', '1', '1648', '1654');
INSERT INTO `t_areas` VALUES ('1655', '漯河市', '462000', '1', '17', '1655');
INSERT INTO `t_areas` VALUES ('1656', '源汇区', '462000', '1', '1655', '1656');
INSERT INTO `t_areas` VALUES ('1657', '郾城区', '462300', '1', '1655', '1657');
INSERT INTO `t_areas` VALUES ('1658', '召陵区', '462300', '1', '1655', '1658');
INSERT INTO `t_areas` VALUES ('1659', '舞阳县', '462400', '1', '1655', '1659');
INSERT INTO `t_areas` VALUES ('1660', '临颍县', '462600', '1', '1655', '1660');
INSERT INTO `t_areas` VALUES ('1661', '三门峡市', '472000', '1', '17', '1661');
INSERT INTO `t_areas` VALUES ('1662', '湖滨区', '472000', '1', '1661', '1662');
INSERT INTO `t_areas` VALUES ('1663', '渑池县', '472400', '1', '1661', '1663');
INSERT INTO `t_areas` VALUES ('1664', '陕县', '472100', '1', '1661', '1664');
INSERT INTO `t_areas` VALUES ('1665', '卢氏县', '472200', '1', '1661', '1665');
INSERT INTO `t_areas` VALUES ('1666', '义马市', '472300', '1', '1661', '1666');
INSERT INTO `t_areas` VALUES ('1667', '灵宝市', '472500', '1', '1661', '1667');
INSERT INTO `t_areas` VALUES ('1668', '南阳市', '473000', '1', '17', '1668');
INSERT INTO `t_areas` VALUES ('1669', '宛城区', '473000', '1', '1668', '1669');
INSERT INTO `t_areas` VALUES ('1670', '卧龙区', '473000', '1', '1668', '1670');
INSERT INTO `t_areas` VALUES ('1671', '南召县', '474650', '1', '1668', '1671');
INSERT INTO `t_areas` VALUES ('1672', '方城县', '473200', '1', '1668', '1672');
INSERT INTO `t_areas` VALUES ('1673', '西峡县', '474550', '1', '1668', '1673');
INSERT INTO `t_areas` VALUES ('1674', '镇平县', '474250', '1', '1668', '1674');
INSERT INTO `t_areas` VALUES ('1675', '内乡县', '474350', '1', '1668', '1675');
INSERT INTO `t_areas` VALUES ('1676', '淅川县', '474450', '1', '1668', '1676');
INSERT INTO `t_areas` VALUES ('1677', '社旗县', '473300', '1', '1668', '1677');
INSERT INTO `t_areas` VALUES ('1678', '唐河县', '473400', '1', '1668', '1678');
INSERT INTO `t_areas` VALUES ('1679', '新野县', '473500', '1', '1668', '1679');
INSERT INTO `t_areas` VALUES ('1680', '桐柏县', '474750', '1', '1668', '1680');
INSERT INTO `t_areas` VALUES ('1681', '邓州市', '474150', '1', '1668', '1681');
INSERT INTO `t_areas` VALUES ('1682', '商丘市', '476000', '1', '17', '1682');
INSERT INTO `t_areas` VALUES ('1683', '梁园区', '476000', '1', '1682', '1683');
INSERT INTO `t_areas` VALUES ('1684', '睢阳区', '476000', '1', '1682', '1684');
INSERT INTO `t_areas` VALUES ('1685', '民权县', '476800', '1', '1682', '1685');
INSERT INTO `t_areas` VALUES ('1686', '睢县', '476900', '1', '1682', '1686');
INSERT INTO `t_areas` VALUES ('1687', '宁陵县', '476700', '1', '1682', '1687');
INSERT INTO `t_areas` VALUES ('1688', '柘城县', '476200', '1', '1682', '1688');
INSERT INTO `t_areas` VALUES ('1689', '虞城县', '476300', '1', '1682', '1689');
INSERT INTO `t_areas` VALUES ('1690', '夏邑县', '476400', '1', '1682', '1690');
INSERT INTO `t_areas` VALUES ('1691', '永城市', '476600', '1', '1682', '1691');
INSERT INTO `t_areas` VALUES ('1692', '信阳市', '464000', '1', '17', '1692');
INSERT INTO `t_areas` VALUES ('1693', '浉河区', '464000', '1', '1692', '1693');
INSERT INTO `t_areas` VALUES ('1694', '平桥区', '464000', '1', '1692', '1694');
INSERT INTO `t_areas` VALUES ('1695', '罗山县', '464200', '1', '1692', '1695');
INSERT INTO `t_areas` VALUES ('1696', '光山县', '465450', '1', '1692', '1696');
INSERT INTO `t_areas` VALUES ('1697', '新县', '465500', '1', '1692', '1697');
INSERT INTO `t_areas` VALUES ('1698', '商城县', '465350', '1', '1692', '1698');
INSERT INTO `t_areas` VALUES ('1699', '固始县', '465200', '1', '1692', '1699');
INSERT INTO `t_areas` VALUES ('1700', '潢川县', '465150', '1', '1692', '1700');
INSERT INTO `t_areas` VALUES ('1701', '淮滨县', '464400', '1', '1692', '1701');
INSERT INTO `t_areas` VALUES ('1702', '息县', '464300', '1', '1692', '1702');
INSERT INTO `t_areas` VALUES ('1703', '周口市', '466000', '1', '17', '1703');
INSERT INTO `t_areas` VALUES ('1704', '川汇区', '466000', '1', '1703', '1704');
INSERT INTO `t_areas` VALUES ('1705', '扶沟县', '461300', '1', '1703', '1705');
INSERT INTO `t_areas` VALUES ('1706', '西华县', '466600', '1', '1703', '1706');
INSERT INTO `t_areas` VALUES ('1707', '商水县', '466100', '1', '1703', '1707');
INSERT INTO `t_areas` VALUES ('1708', '沈丘县', '466300', '1', '1703', '1708');
INSERT INTO `t_areas` VALUES ('1709', '郸城县', '477150', '1', '1703', '1709');
INSERT INTO `t_areas` VALUES ('1710', '淮阳县', '466700', '1', '1703', '1710');
INSERT INTO `t_areas` VALUES ('1711', '太康县', '475400', '1', '1703', '1711');
INSERT INTO `t_areas` VALUES ('1712', '鹿邑县', '477200', '1', '1703', '1712');
INSERT INTO `t_areas` VALUES ('1713', '项城市', '466200', '1', '1703', '1713');
INSERT INTO `t_areas` VALUES ('1714', '驻马店市', '463000', '1', '17', '1714');
INSERT INTO `t_areas` VALUES ('1715', '驿城区', '463000', '1', '1714', '1715');
INSERT INTO `t_areas` VALUES ('1716', '西平县', '463900', '1', '1714', '1716');
INSERT INTO `t_areas` VALUES ('1717', '上蔡县', '463800', '1', '1714', '1717');
INSERT INTO `t_areas` VALUES ('1718', '平舆县', '463400', '1', '1714', '1718');
INSERT INTO `t_areas` VALUES ('1719', '正阳县', '463600', '1', '1714', '1719');
INSERT INTO `t_areas` VALUES ('1720', '确山县', '463200', '1', '1714', '1720');
INSERT INTO `t_areas` VALUES ('1721', '泌阳县', '463700', '1', '1714', '1721');
INSERT INTO `t_areas` VALUES ('1722', '汝南县', '463300', '1', '1714', '1722');
INSERT INTO `t_areas` VALUES ('1723', '遂平县', '463100', '1', '1714', '1723');
INSERT INTO `t_areas` VALUES ('1724', '新蔡县', '463500', '1', '1714', '1724');
INSERT INTO `t_areas` VALUES ('1725', '武汉市', '430000', '1', '18', '1725');
INSERT INTO `t_areas` VALUES ('1726', '江岸区', '430014', '1', '1725', '1726');
INSERT INTO `t_areas` VALUES ('1727', '江汉区', '430000', '1', '1725', '1727');
INSERT INTO `t_areas` VALUES ('1728', '硚口区', '430000', '1', '1725', '1728');
INSERT INTO `t_areas` VALUES ('1729', '汉阳区', '430050', '1', '1725', '1729');
INSERT INTO `t_areas` VALUES ('1730', '武昌区', '430000', '1', '1725', '1730');
INSERT INTO `t_areas` VALUES ('1731', '青山区', '430080', '1', '1725', '1731');
INSERT INTO `t_areas` VALUES ('1732', '洪山区', '430070', '1', '1725', '1732');
INSERT INTO `t_areas` VALUES ('1733', '东西湖区', '430040', '1', '1725', '1733');
INSERT INTO `t_areas` VALUES ('1734', '汉南区', '430090', '1', '1725', '1734');
INSERT INTO `t_areas` VALUES ('1735', '蔡甸区', '430100', '1', '1725', '1735');
INSERT INTO `t_areas` VALUES ('1736', '江夏区', '430200', '1', '1725', '1736');
INSERT INTO `t_areas` VALUES ('1737', '黄陂区', '432200', '1', '1725', '1737');
INSERT INTO `t_areas` VALUES ('1738', '新洲区', '431400', '1', '1725', '1738');
INSERT INTO `t_areas` VALUES ('1739', '黄石市', '435000', '1', '18', '1739');
INSERT INTO `t_areas` VALUES ('1740', '黄石港区', '435000', '1', '1739', '1740');
INSERT INTO `t_areas` VALUES ('1741', '西塞山区', '435000', '1', '1739', '1741');
INSERT INTO `t_areas` VALUES ('1742', '下陆区', '435000', '1', '1739', '1742');
INSERT INTO `t_areas` VALUES ('1743', '铁山区', '435000', '1', '1739', '1743');
INSERT INTO `t_areas` VALUES ('1744', '阳新县', '435200', '1', '1739', '1744');
INSERT INTO `t_areas` VALUES ('1745', '大冶市', '435100', '1', '1739', '1745');
INSERT INTO `t_areas` VALUES ('1746', '十堰市', '442000', '1', '18', '1746');
INSERT INTO `t_areas` VALUES ('1747', '茅箭区', '442000', '1', '1746', '1747');
INSERT INTO `t_areas` VALUES ('1748', '张湾区', '442000', '1', '1746', '1748');
INSERT INTO `t_areas` VALUES ('1749', '郧县', '442500', '1', '1746', '1749');
INSERT INTO `t_areas` VALUES ('1750', '郧西县', '442600', '1', '1746', '1750');
INSERT INTO `t_areas` VALUES ('1751', '竹山县', '442200', '1', '1746', '1751');
INSERT INTO `t_areas` VALUES ('1752', '竹溪县', '442300', '1', '1746', '1752');
INSERT INTO `t_areas` VALUES ('1753', '房县', '442100', '1', '1746', '1753');
INSERT INTO `t_areas` VALUES ('1754', '丹江口市', '442700', '1', '1746', '1754');
INSERT INTO `t_areas` VALUES ('1755', '宜昌市', '443000', '1', '18', '1755');
INSERT INTO `t_areas` VALUES ('1756', '西陵区', '443000', '1', '1755', '1756');
INSERT INTO `t_areas` VALUES ('1757', '伍家岗区', '443000', '1', '1755', '1757');
INSERT INTO `t_areas` VALUES ('1758', '点军区', '443000', '1', '1755', '1758');
INSERT INTO `t_areas` VALUES ('1759', '猇亭区', '443000', '1', '1755', '1759');
INSERT INTO `t_areas` VALUES ('1760', '夷陵区', '443100', '1', '1755', '1760');
INSERT INTO `t_areas` VALUES ('1761', '远安县', '444200', '1', '1755', '1761');
INSERT INTO `t_areas` VALUES ('1762', '兴山县', '443700', '1', '1755', '1762');
INSERT INTO `t_areas` VALUES ('1763', '秭归县', '443600', '1', '1755', '1763');
INSERT INTO `t_areas` VALUES ('1764', '长阳土家族自治县', '443500', '1', '1755', '1764');
INSERT INTO `t_areas` VALUES ('1765', '五峰土家族自治县', '443400', '1', '1755', '1765');
INSERT INTO `t_areas` VALUES ('1766', '宜都市', '443000', '1', '1755', '1766');
INSERT INTO `t_areas` VALUES ('1767', '当阳市', '444100', '1', '1755', '1767');
INSERT INTO `t_areas` VALUES ('1768', '枝江市', '443200', '1', '1755', '1768');
INSERT INTO `t_areas` VALUES ('1769', '襄樊市', '441000', '1', '18', '1769');
INSERT INTO `t_areas` VALUES ('1770', '襄城区', '441000', '1', '1769', '1770');
INSERT INTO `t_areas` VALUES ('1771', '樊城区', '441000', '1', '1769', '1771');
INSERT INTO `t_areas` VALUES ('1772', '襄阳区', '441100', '1', '1769', '1772');
INSERT INTO `t_areas` VALUES ('1773', '南漳县', '441500', '1', '1769', '1773');
INSERT INTO `t_areas` VALUES ('1774', '谷城县', '441700', '1', '1769', '1774');
INSERT INTO `t_areas` VALUES ('1775', '保康县', '441600', '1', '1769', '1775');
INSERT INTO `t_areas` VALUES ('1776', '老河口市', '441800', '1', '1769', '1776');
INSERT INTO `t_areas` VALUES ('1777', '枣阳市', '441200', '1', '1769', '1777');
INSERT INTO `t_areas` VALUES ('1778', '宜城市', '441400', '1', '1769', '1778');
INSERT INTO `t_areas` VALUES ('1779', '鄂州市', '436000', '1', '18', '1779');
INSERT INTO `t_areas` VALUES ('1780', '梁子湖区', '436000', '1', '1779', '1780');
INSERT INTO `t_areas` VALUES ('1781', '华容区', '436000', '1', '1779', '1781');
INSERT INTO `t_areas` VALUES ('1782', '鄂城区', '436000', '1', '1779', '1782');
INSERT INTO `t_areas` VALUES ('1783', '荆门市', '448000', '1', '18', '1783');
INSERT INTO `t_areas` VALUES ('1784', '东宝区', '448000', '1', '1783', '1784');
INSERT INTO `t_areas` VALUES ('1785', '掇刀区', '448000', '1', '1783', '1785');
INSERT INTO `t_areas` VALUES ('1786', '京山县', '431800', '1', '1783', '1786');
INSERT INTO `t_areas` VALUES ('1787', '沙洋县', '448200', '1', '1783', '1787');
INSERT INTO `t_areas` VALUES ('1788', '钟祥市', '431900', '1', '1783', '1788');
INSERT INTO `t_areas` VALUES ('1789', '孝感市', '432000', '1', '18', '1789');
INSERT INTO `t_areas` VALUES ('1790', '孝南区', '432100', '1', '1789', '1790');
INSERT INTO `t_areas` VALUES ('1791', '孝昌县', '432900', '1', '1789', '1791');
INSERT INTO `t_areas` VALUES ('1792', '大悟县', '432800', '1', '1789', '1792');
INSERT INTO `t_areas` VALUES ('1793', '云梦县', '432500', '1', '1789', '1793');
INSERT INTO `t_areas` VALUES ('1794', '应城市', '432400', '1', '1789', '1794');
INSERT INTO `t_areas` VALUES ('1795', '安陆市', '432600', '1', '1789', '1795');
INSERT INTO `t_areas` VALUES ('1796', '汉川市', '432300', '1', '1789', '1796');
INSERT INTO `t_areas` VALUES ('1797', '荆州市', '434000', '1', '18', '1797');
INSERT INTO `t_areas` VALUES ('1798', '沙市区', '434000', '1', '1797', '1798');
INSERT INTO `t_areas` VALUES ('1799', '荆州区', '434020', '1', '1797', '1799');
INSERT INTO `t_areas` VALUES ('1800', '公安县', '434300', '1', '1797', '1800');
INSERT INTO `t_areas` VALUES ('1801', '监利县', '433300', '1', '1797', '1801');
INSERT INTO `t_areas` VALUES ('1802', '江陵县', '434100', '1', '1797', '1802');
INSERT INTO `t_areas` VALUES ('1803', '石首市', '434400', '1', '1797', '1803');
INSERT INTO `t_areas` VALUES ('1804', '洪湖市', '433200', '1', '1797', '1804');
INSERT INTO `t_areas` VALUES ('1805', '松滋市', '434200', '1', '1797', '1805');
INSERT INTO `t_areas` VALUES ('1806', '黄冈市', '438000', '1', '18', '1806');
INSERT INTO `t_areas` VALUES ('1807', '黄州区', '438000', '1', '1806', '1807');
INSERT INTO `t_areas` VALUES ('1808', '团风县', '438000', '1', '1806', '1808');
INSERT INTO `t_areas` VALUES ('1809', '红安县', '438400', '1', '1806', '1809');
INSERT INTO `t_areas` VALUES ('1810', '罗田县', '438600', '1', '1806', '1810');
INSERT INTO `t_areas` VALUES ('1811', '英山县', '438700', '1', '1806', '1811');
INSERT INTO `t_areas` VALUES ('1812', '浠水县', '438200', '1', '1806', '1812');
INSERT INTO `t_areas` VALUES ('1813', '蕲春县', '435300', '1', '1806', '1813');
INSERT INTO `t_areas` VALUES ('1814', '黄梅县', '435500', '1', '1806', '1814');
INSERT INTO `t_areas` VALUES ('1815', '麻城市', '438300', '1', '1806', '1815');
INSERT INTO `t_areas` VALUES ('1816', '武穴市', '435400', '1', '1806', '1816');
INSERT INTO `t_areas` VALUES ('1817', '咸宁市', '437000', '1', '18', '1817');
INSERT INTO `t_areas` VALUES ('1818', '咸安区', '437000', '1', '1817', '1818');
INSERT INTO `t_areas` VALUES ('1819', '嘉鱼县', '437200', '1', '1817', '1819');
INSERT INTO `t_areas` VALUES ('1820', '通城县', '437400', '1', '1817', '1820');
INSERT INTO `t_areas` VALUES ('1821', '崇阳县', '437500', '1', '1817', '1821');
INSERT INTO `t_areas` VALUES ('1822', '通山县', '437600', '1', '1817', '1822');
INSERT INTO `t_areas` VALUES ('1823', '赤壁市', '437300', '1', '1817', '1823');
INSERT INTO `t_areas` VALUES ('1824', '随州市', '441300', '1', '18', '1824');
INSERT INTO `t_areas` VALUES ('1825', '曾都区', '441300', '1', '1824', '1825');
INSERT INTO `t_areas` VALUES ('1826', '广水市', '432700', '1', '1824', '1826');
INSERT INTO `t_areas` VALUES ('1827', '恩施土家族苗族自治州', '445000', '1', '18', '1827');
INSERT INTO `t_areas` VALUES ('1828', '恩施市', '445000', '1', '1827', '1828');
INSERT INTO `t_areas` VALUES ('1829', '利川市', '445400', '1', '1827', '1829');
INSERT INTO `t_areas` VALUES ('1830', '建始县', '445300', '1', '1827', '1830');
INSERT INTO `t_areas` VALUES ('1831', '巴东县', '444300', '1', '1827', '1831');
INSERT INTO `t_areas` VALUES ('1832', '宣恩县', '445500', '1', '1827', '1832');
INSERT INTO `t_areas` VALUES ('1833', '咸丰县', '445600', '1', '1827', '1833');
INSERT INTO `t_areas` VALUES ('1834', '来凤县', '445700', '1', '1827', '1834');
INSERT INTO `t_areas` VALUES ('1835', '鹤峰县', '445800', '1', '1827', '1835');
INSERT INTO `t_areas` VALUES ('1836', '长沙市', '410000', '1', '19', '1836');
INSERT INTO `t_areas` VALUES ('1837', '芙蓉区', '410000', '1', '1836', '1837');
INSERT INTO `t_areas` VALUES ('1838', '天心区', '410000', '1', '1836', '1838');
INSERT INTO `t_areas` VALUES ('1839', '岳麓区', '410000', '1', '1836', '1839');
INSERT INTO `t_areas` VALUES ('1840', '开福区', '410000', '1', '1836', '1840');
INSERT INTO `t_areas` VALUES ('1841', '雨花区', '410000', '1', '1836', '1841');
INSERT INTO `t_areas` VALUES ('1842', '长沙县', '410100', '1', '1836', '1842');
INSERT INTO `t_areas` VALUES ('1843', '望城县', '410200', '1', '1836', '1843');
INSERT INTO `t_areas` VALUES ('1844', '宁乡县', '410600', '1', '1836', '1844');
INSERT INTO `t_areas` VALUES ('1845', '浏阳市', '410300', '1', '1836', '1845');
INSERT INTO `t_areas` VALUES ('1846', '株洲市', '412000', '1', '19', '1846');
INSERT INTO `t_areas` VALUES ('1847', '荷塘区', '412000', '1', '1846', '1847');
INSERT INTO `t_areas` VALUES ('1848', '芦淞区', '412000', '1', '1846', '1848');
INSERT INTO `t_areas` VALUES ('1849', '石峰区', '412000', '1', '1846', '1849');
INSERT INTO `t_areas` VALUES ('1850', '天元区', '412000', '1', '1846', '1850');
INSERT INTO `t_areas` VALUES ('1851', '株洲县', '412000', '1', '1846', '1851');
INSERT INTO `t_areas` VALUES ('1852', '攸县', '412300', '1', '1846', '1852');
INSERT INTO `t_areas` VALUES ('1853', '茶陵县', '412400', '1', '1846', '1853');
INSERT INTO `t_areas` VALUES ('1854', '炎陵县', '412500', '1', '1846', '1854');
INSERT INTO `t_areas` VALUES ('1855', '醴陵市', '412200', '1', '1846', '1855');
INSERT INTO `t_areas` VALUES ('1856', '湘潭市', '411100', '1', '19', '1856');
INSERT INTO `t_areas` VALUES ('1857', '雨湖区', '411100', '1', '1856', '1857');
INSERT INTO `t_areas` VALUES ('1858', '岳塘区', '411100', '1', '1856', '1858');
INSERT INTO `t_areas` VALUES ('1859', '湘潭县', '411200', '1', '1856', '1859');
INSERT INTO `t_areas` VALUES ('1860', '湘乡市', '411400', '1', '1856', '1860');
INSERT INTO `t_areas` VALUES ('1861', '韶山市', '411300', '1', '1856', '1861');
INSERT INTO `t_areas` VALUES ('1862', '衡阳市', '421000', '1', '19', '1862');
INSERT INTO `t_areas` VALUES ('1863', '珠晖区', '421000', '1', '1862', '1863');
INSERT INTO `t_areas` VALUES ('1864', '雁峰区', '421000', '1', '1862', '1864');
INSERT INTO `t_areas` VALUES ('1865', '石鼓区', '421000', '1', '1862', '1865');
INSERT INTO `t_areas` VALUES ('1866', '蒸湘区', '421000', '1', '1862', '1866');
INSERT INTO `t_areas` VALUES ('1867', '南岳区', '421000', '1', '1862', '1867');
INSERT INTO `t_areas` VALUES ('1868', '衡阳县', '421200', '1', '1862', '1868');
INSERT INTO `t_areas` VALUES ('1869', '衡南县', '421100', '1', '1862', '1869');
INSERT INTO `t_areas` VALUES ('1870', '衡山县', '421300', '1', '1862', '1870');
INSERT INTO `t_areas` VALUES ('1871', '衡东县', '421400', '1', '1862', '1871');
INSERT INTO `t_areas` VALUES ('1872', '祁东县', '421600', '1', '1862', '1872');
INSERT INTO `t_areas` VALUES ('1873', '耒阳市', '421800', '1', '1862', '1873');
INSERT INTO `t_areas` VALUES ('1874', '常宁市', '421500', '1', '1862', '1874');
INSERT INTO `t_areas` VALUES ('1875', '邵阳市', '422000', '1', '19', '1875');
INSERT INTO `t_areas` VALUES ('1876', '双清区', '422000', '1', '1875', '1876');
INSERT INTO `t_areas` VALUES ('1877', '大祥区', '422000', '1', '1875', '1877');
INSERT INTO `t_areas` VALUES ('1878', '北塔区', '422000', '1', '1875', '1878');
INSERT INTO `t_areas` VALUES ('1879', '邵东县', '422800', '1', '1875', '1879');
INSERT INTO `t_areas` VALUES ('1880', '新邵县', '422900', '1', '1875', '1880');
INSERT INTO `t_areas` VALUES ('1881', '邵阳县', '422100', '1', '1875', '1881');
INSERT INTO `t_areas` VALUES ('1882', '隆回县', '422200', '1', '1875', '1882');
INSERT INTO `t_areas` VALUES ('1883', '洞口县', '422300', '1', '1875', '1883');
INSERT INTO `t_areas` VALUES ('1884', '绥宁县', '422600', '1', '1875', '1884');
INSERT INTO `t_areas` VALUES ('1885', '新宁县', '422700', '1', '1875', '1885');
INSERT INTO `t_areas` VALUES ('1886', '城步苗族自治县', '422500', '1', '1875', '1886');
INSERT INTO `t_areas` VALUES ('1887', '武冈市', '422400', '1', '1875', '1887');
INSERT INTO `t_areas` VALUES ('1888', '岳阳市', '414000', '1', '19', '1888');
INSERT INTO `t_areas` VALUES ('1889', '岳阳楼区', '414000', '1', '1888', '1889');
INSERT INTO `t_areas` VALUES ('1890', '云溪区', '414000', '1', '1888', '1890');
INSERT INTO `t_areas` VALUES ('1891', '君山区', '414000', '1', '1888', '1891');
INSERT INTO `t_areas` VALUES ('1892', '岳阳县', '414100', '1', '1888', '1892');
INSERT INTO `t_areas` VALUES ('1893', '华容县', '414200', '1', '1888', '1893');
INSERT INTO `t_areas` VALUES ('1894', '湘阴县', '410500', '1', '1888', '1894');
INSERT INTO `t_areas` VALUES ('1895', '平江县', '410400', '1', '1888', '1895');
INSERT INTO `t_areas` VALUES ('1896', '汨罗市', '414400', '1', '1888', '1896');
INSERT INTO `t_areas` VALUES ('1897', '临湘市', '414300', '1', '1888', '1897');
INSERT INTO `t_areas` VALUES ('1898', '常德市', '415000', '1', '19', '1898');
INSERT INTO `t_areas` VALUES ('1899', '武陵区', '415000', '1', '1898', '1899');
INSERT INTO `t_areas` VALUES ('1900', '鼎城区', '415100', '1', '1898', '1900');
INSERT INTO `t_areas` VALUES ('1901', '安乡县', '415600', '1', '1898', '1901');
INSERT INTO `t_areas` VALUES ('1902', '汉寿县', '415900', '1', '1898', '1902');
INSERT INTO `t_areas` VALUES ('1903', '澧县', '415500', '1', '1898', '1903');
INSERT INTO `t_areas` VALUES ('1904', '临澧县', '415200', '1', '1898', '1904');
INSERT INTO `t_areas` VALUES ('1905', '桃源县', '415700', '1', '1898', '1905');
INSERT INTO `t_areas` VALUES ('1906', '石门县', '415300', '1', '1898', '1906');
INSERT INTO `t_areas` VALUES ('1907', '津市市', '415400', '1', '1898', '1907');
INSERT INTO `t_areas` VALUES ('1908', '张家界市', '427000', '1', '19', '1908');
INSERT INTO `t_areas` VALUES ('1909', '永定区', '427000', '1', '1908', '1909');
INSERT INTO `t_areas` VALUES ('1910', '武陵源区', '427400', '1', '1908', '1910');
INSERT INTO `t_areas` VALUES ('1911', '慈利县', '427200', '1', '1908', '1911');
INSERT INTO `t_areas` VALUES ('1912', '桑植县', '427100', '1', '1908', '1912');
INSERT INTO `t_areas` VALUES ('1913', '益阳市', '413000', '1', '19', '1913');
INSERT INTO `t_areas` VALUES ('1914', '资阳区', '413000', '1', '1913', '1914');
INSERT INTO `t_areas` VALUES ('1915', '赫山区', '413000', '1', '1913', '1915');
INSERT INTO `t_areas` VALUES ('1916', '南县', '413200', '1', '1913', '1916');
INSERT INTO `t_areas` VALUES ('1917', '桃江县', '413400', '1', '1913', '1917');
INSERT INTO `t_areas` VALUES ('1918', '安化县', '413500', '1', '1913', '1918');
INSERT INTO `t_areas` VALUES ('1919', '沅江市', '413100', '1', '1913', '1919');
INSERT INTO `t_areas` VALUES ('1920', '郴州市', '423000', '1', '19', '1920');
INSERT INTO `t_areas` VALUES ('1921', '北湖区', '423000', '1', '1920', '1921');
INSERT INTO `t_areas` VALUES ('1922', '苏仙区', '423000', '1', '1920', '1922');
INSERT INTO `t_areas` VALUES ('1923', '桂阳县', '424400', '1', '1920', '1923');
INSERT INTO `t_areas` VALUES ('1924', '宜章县', '424200', '1', '1920', '1924');
INSERT INTO `t_areas` VALUES ('1925', '永兴县', '423300', '1', '1920', '1925');
INSERT INTO `t_areas` VALUES ('1926', '嘉禾县', '424500', '1', '1920', '1926');
INSERT INTO `t_areas` VALUES ('1927', '临武县', '424300', '1', '1920', '1927');
INSERT INTO `t_areas` VALUES ('1928', '汝城县', '424100', '1', '1920', '1928');
INSERT INTO `t_areas` VALUES ('1929', '桂东县', '423500', '1', '1920', '1929');
INSERT INTO `t_areas` VALUES ('1930', '安仁县', '423600', '1', '1920', '1930');
INSERT INTO `t_areas` VALUES ('1931', '资兴市', '423400', '1', '1920', '1931');
INSERT INTO `t_areas` VALUES ('1932', '永州市', '425000', '1', '19', '1932');
INSERT INTO `t_areas` VALUES ('1933', '零陵区', '425000', '1', '1932', '1933');
INSERT INTO `t_areas` VALUES ('1934', '冷水滩区', '425000', '1', '1932', '1934');
INSERT INTO `t_areas` VALUES ('1935', '祁阳县', '421700', '1', '1932', '1935');
INSERT INTO `t_areas` VALUES ('1936', '东安县', '425900', '1', '1932', '1936');
INSERT INTO `t_areas` VALUES ('1937', '双牌县', '425200', '1', '1932', '1937');
INSERT INTO `t_areas` VALUES ('1938', '道县', '425300', '1', '1932', '1938');
INSERT INTO `t_areas` VALUES ('1939', '江永县', '425400', '1', '1932', '1939');
INSERT INTO `t_areas` VALUES ('1940', '宁远县', '425600', '1', '1932', '1940');
INSERT INTO `t_areas` VALUES ('1941', '蓝山县', '425800', '1', '1932', '1941');
INSERT INTO `t_areas` VALUES ('1942', '新田县', '425700', '1', '1932', '1942');
INSERT INTO `t_areas` VALUES ('1943', '江华瑶族自治县', '425500', '1', '1932', '1943');
INSERT INTO `t_areas` VALUES ('1944', '怀化市', '418000', '1', '19', '1944');
INSERT INTO `t_areas` VALUES ('1945', '鹤城区', '418000', '1', '1944', '1945');
INSERT INTO `t_areas` VALUES ('1946', '中方县', '418000', '1', '1944', '1946');
INSERT INTO `t_areas` VALUES ('1947', '沅陵县', '419600', '1', '1944', '1947');
INSERT INTO `t_areas` VALUES ('1948', '辰溪县', '419500', '1', '1944', '1948');
INSERT INTO `t_areas` VALUES ('1949', '溆浦县', '419300', '1', '1944', '1949');
INSERT INTO `t_areas` VALUES ('1950', '会同县', '418300', '1', '1944', '1950');
INSERT INTO `t_areas` VALUES ('1951', '麻阳苗族自治县', '419400', '1', '1944', '1951');
INSERT INTO `t_areas` VALUES ('1952', '新晃侗族自治县', '419200', '1', '1944', '1952');
INSERT INTO `t_areas` VALUES ('1953', '芷江侗族自治县', '419100', '1', '1944', '1953');
INSERT INTO `t_areas` VALUES ('1954', '靖州苗族侗族自治县', '418400', '1', '1944', '1954');
INSERT INTO `t_areas` VALUES ('1955', '通道侗族自治县', '418500', '1', '1944', '1955');
INSERT INTO `t_areas` VALUES ('1956', '洪江市', '418200', '1', '1944', '1956');
INSERT INTO `t_areas` VALUES ('1957', '娄底市', '417000', '1', '19', '1957');
INSERT INTO `t_areas` VALUES ('1958', '娄星区', '417000', '1', '1957', '1958');
INSERT INTO `t_areas` VALUES ('1959', '双峰县', '417700', '1', '1957', '1959');
INSERT INTO `t_areas` VALUES ('1960', '新化县', '417600', '1', '1957', '1960');
INSERT INTO `t_areas` VALUES ('1961', '冷水江市', '417500', '1', '1957', '1961');
INSERT INTO `t_areas` VALUES ('1962', '涟源市', '417100', '1', '1957', '1962');
INSERT INTO `t_areas` VALUES ('1963', '湘西土家族苗族自治州', '416000', '1', '19', '1963');
INSERT INTO `t_areas` VALUES ('1964', '吉首市', '416000', '1', '1963', '1964');
INSERT INTO `t_areas` VALUES ('1965', '泸溪县', '416100', '1', '1963', '1965');
INSERT INTO `t_areas` VALUES ('1966', '凤凰县', '416200', '1', '1963', '1966');
INSERT INTO `t_areas` VALUES ('1967', '花垣县', '416400', '1', '1963', '1967');
INSERT INTO `t_areas` VALUES ('1968', '保靖县', '416500', '1', '1963', '1968');
INSERT INTO `t_areas` VALUES ('1969', '古丈县', '416300', '1', '1963', '1969');
INSERT INTO `t_areas` VALUES ('1970', '永顺县', '416700', '1', '1963', '1970');
INSERT INTO `t_areas` VALUES ('1971', '龙山县', '416800', '1', '1963', '1971');
INSERT INTO `t_areas` VALUES ('1972', '广州市', '510000', '1', '20', '1972');
INSERT INTO `t_areas` VALUES ('1973', '荔湾区', '510000', '1', '1972', '1973');
INSERT INTO `t_areas` VALUES ('1974', '越秀区', '510000', '1', '1972', '1974');
INSERT INTO `t_areas` VALUES ('1975', '海珠区', '510000', '1', '1972', '1975');
INSERT INTO `t_areas` VALUES ('1976', '天河区', '510000', '1', '1972', '1976');
INSERT INTO `t_areas` VALUES ('1977', '白云区', '510000', '1', '1972', '1977');
INSERT INTO `t_areas` VALUES ('1978', '黄埔区', '510700', '1', '1972', '1978');
INSERT INTO `t_areas` VALUES ('1979', '番禺区', '511400', '1', '1972', '1979');
INSERT INTO `t_areas` VALUES ('1980', '花都区', '510800', '1', '1972', '1980');
INSERT INTO `t_areas` VALUES ('1981', '南沙区', '511458', '1', '1972', '1981');
INSERT INTO `t_areas` VALUES ('1982', '萝岗区', '510000', '1', '1972', '1982');
INSERT INTO `t_areas` VALUES ('1983', '增城市', '511300', '1', '1972', '1983');
INSERT INTO `t_areas` VALUES ('1984', '从化市', '510900', '1', '1972', '1984');
INSERT INTO `t_areas` VALUES ('1985', '韶关市', '512000', '1', '20', '1985');
INSERT INTO `t_areas` VALUES ('1986', '武江区', '512000', '1', '1985', '1986');
INSERT INTO `t_areas` VALUES ('1987', '浈江区', '512000', '1', '1985', '1987');
INSERT INTO `t_areas` VALUES ('1988', '曲江区', '512100', '1', '1985', '1988');
INSERT INTO `t_areas` VALUES ('1989', '始兴县', '512500', '1', '1985', '1989');
INSERT INTO `t_areas` VALUES ('1990', '仁化县', '512300', '1', '1985', '1990');
INSERT INTO `t_areas` VALUES ('1991', '翁源县', '512600', '1', '1985', '1991');
INSERT INTO `t_areas` VALUES ('1992', '乳源瑶族自治县', '512600', '1', '1985', '1992');
INSERT INTO `t_areas` VALUES ('1993', '新丰县', '511100', '1', '1985', '1993');
INSERT INTO `t_areas` VALUES ('1994', '乐昌市', '512200', '1', '1985', '1994');
INSERT INTO `t_areas` VALUES ('1995', '南雄市', '512400', '1', '1985', '1995');
INSERT INTO `t_areas` VALUES ('1996', '深圳市', '518000', '1', '20', '1996');
INSERT INTO `t_areas` VALUES ('1997', '罗湖区', '518000', '1', '1996', '1997');
INSERT INTO `t_areas` VALUES ('1998', '福田区', '518000', '1', '1996', '1998');
INSERT INTO `t_areas` VALUES ('1999', '南山区', '518000', '1', '1996', '1999');
INSERT INTO `t_areas` VALUES ('2000', '宝安区', '518100', '1', '1996', '2000');
INSERT INTO `t_areas` VALUES ('2001', '龙岗区', '518100', '1', '1996', '2001');
INSERT INTO `t_areas` VALUES ('2002', '盐田区', '518000', '1', '1996', '2002');
INSERT INTO `t_areas` VALUES ('2003', '珠海市', '519000', '1', '20', '2003');
INSERT INTO `t_areas` VALUES ('2004', '香洲区', '519000', '1', '2003', '2004');
INSERT INTO `t_areas` VALUES ('2005', '斗门区', '519100', '1', '2003', '2005');
INSERT INTO `t_areas` VALUES ('2006', '金湾区', '519090', '1', '2003', '2006');
INSERT INTO `t_areas` VALUES ('2007', '汕头市', '515000', '1', '20', '2007');
INSERT INTO `t_areas` VALUES ('2008', '龙湖区', '515000', '1', '2007', '2008');
INSERT INTO `t_areas` VALUES ('2009', '金平区', '515000', '1', '2007', '2009');
INSERT INTO `t_areas` VALUES ('2010', '濠江区', '515000', '1', '2007', '2010');
INSERT INTO `t_areas` VALUES ('2011', '潮阳区', '515100', '1', '2007', '2011');
INSERT INTO `t_areas` VALUES ('2012', '潮南区', '515100', '1', '2007', '2012');
INSERT INTO `t_areas` VALUES ('2013', '澄海区', '515800', '1', '2007', '2013');
INSERT INTO `t_areas` VALUES ('2014', '南澳县', '515900', '1', '2007', '2014');
INSERT INTO `t_areas` VALUES ('2015', '佛山市', '528000', '1', '20', '2015');
INSERT INTO `t_areas` VALUES ('2016', '禅城区', '528000', '1', '2015', '2016');
INSERT INTO `t_areas` VALUES ('2017', '南海区', '528200', '1', '2015', '2017');
INSERT INTO `t_areas` VALUES ('2018', '顺德区', '528000', '1', '2015', '2018');
INSERT INTO `t_areas` VALUES ('2019', '三水区', '528100', '1', '2015', '2019');
INSERT INTO `t_areas` VALUES ('2020', '高明区', '528500', '1', '2015', '2020');
INSERT INTO `t_areas` VALUES ('2021', '江门市', '529000', '1', '20', '2021');
INSERT INTO `t_areas` VALUES ('2022', '蓬江区', '529000', '1', '2021', '2022');
INSERT INTO `t_areas` VALUES ('2023', '江海区', '529000', '1', '2021', '2023');
INSERT INTO `t_areas` VALUES ('2024', '新会区', '529100', '1', '2021', '2024');
INSERT INTO `t_areas` VALUES ('2025', '台山市', '529200', '1', '2021', '2025');
INSERT INTO `t_areas` VALUES ('2026', '开平市', '529300', '1', '2021', '2026');
INSERT INTO `t_areas` VALUES ('2027', '鹤山市', '529700', '1', '2021', '2027');
INSERT INTO `t_areas` VALUES ('2028', '恩平市', '529400', '1', '2021', '2028');
INSERT INTO `t_areas` VALUES ('2029', '湛江市', '524000', '1', '20', '2029');
INSERT INTO `t_areas` VALUES ('2030', '赤坎区', '524000', '1', '2029', '2030');
INSERT INTO `t_areas` VALUES ('2031', '霞山区', '524000', '1', '2029', '2031');
INSERT INTO `t_areas` VALUES ('2032', '坡头区', '524000', '1', '2029', '2032');
INSERT INTO `t_areas` VALUES ('2033', '麻章区', '524000', '1', '2029', '2033');
INSERT INTO `t_areas` VALUES ('2034', '遂溪县', '524300', '1', '2029', '2034');
INSERT INTO `t_areas` VALUES ('2035', '徐闻县', '524100', '1', '2029', '2035');
INSERT INTO `t_areas` VALUES ('2036', '廉江市', '524400', '1', '2029', '2036');
INSERT INTO `t_areas` VALUES ('2037', '雷州市', '524200', '1', '2029', '2037');
INSERT INTO `t_areas` VALUES ('2038', '吴川市', '524500', '1', '2029', '2038');
INSERT INTO `t_areas` VALUES ('2039', '茂名市', '525000', '1', '20', '2039');
INSERT INTO `t_areas` VALUES ('2040', '茂南区', '525000', '1', '2039', '2040');
INSERT INTO `t_areas` VALUES ('2041', '茂港区', '525000', '1', '2039', '2041');
INSERT INTO `t_areas` VALUES ('2042', '电白县', '525400', '1', '2039', '2042');
INSERT INTO `t_areas` VALUES ('2043', '高州市', '525200', '1', '2039', '2043');
INSERT INTO `t_areas` VALUES ('2044', '化州市', '525100', '1', '2039', '2044');
INSERT INTO `t_areas` VALUES ('2045', '信宜市', '525300', '1', '2039', '2045');
INSERT INTO `t_areas` VALUES ('2046', '肇庆市', '526000', '1', '20', '2046');
INSERT INTO `t_areas` VALUES ('2047', '端州区', '526000', '1', '2046', '2047');
INSERT INTO `t_areas` VALUES ('2048', '鼎湖区', '526000', '1', '2046', '2048');
INSERT INTO `t_areas` VALUES ('2049', '广宁县', '526300', '1', '2046', '2049');
INSERT INTO `t_areas` VALUES ('2050', '怀集县', '526400', '1', '2046', '2050');
INSERT INTO `t_areas` VALUES ('2051', '封开县', '526500', '1', '2046', '2051');
INSERT INTO `t_areas` VALUES ('2052', '德庆县', '526600', '1', '2046', '2052');
INSERT INTO `t_areas` VALUES ('2053', '高要市', '526100', '1', '2046', '2053');
INSERT INTO `t_areas` VALUES ('2054', '四会市', '526200', '1', '2046', '2054');
INSERT INTO `t_areas` VALUES ('2055', '惠州市', '516000', '1', '20', '2055');
INSERT INTO `t_areas` VALUES ('2056', '惠城区', '516000', '1', '2055', '2056');
INSERT INTO `t_areas` VALUES ('2057', '惠阳区', '516200', '1', '2055', '2057');
INSERT INTO `t_areas` VALUES ('2058', '博罗县', '516100', '1', '2055', '2058');
INSERT INTO `t_areas` VALUES ('2059', '惠东县', '516300', '1', '2055', '2059');
INSERT INTO `t_areas` VALUES ('2060', '龙门县', '516800', '1', '2055', '2060');
INSERT INTO `t_areas` VALUES ('2061', '梅州市', '514000', '1', '20', '2061');
INSERT INTO `t_areas` VALUES ('2062', '梅江区', '514000', '1', '2061', '2062');
INSERT INTO `t_areas` VALUES ('2063', '梅县', '514700', '1', '2061', '2063');
INSERT INTO `t_areas` VALUES ('2064', '大埔县', '514200', '1', '2061', '2064');
INSERT INTO `t_areas` VALUES ('2065', '丰顺县', '514300', '1', '2061', '2065');
INSERT INTO `t_areas` VALUES ('2066', '五华县', '514400', '1', '2061', '2066');
INSERT INTO `t_areas` VALUES ('2067', '平远县', '514600', '1', '2061', '2067');
INSERT INTO `t_areas` VALUES ('2068', '蕉岭县', '514100', '1', '2061', '2068');
INSERT INTO `t_areas` VALUES ('2069', '兴宁市', '514500', '1', '2061', '2069');
INSERT INTO `t_areas` VALUES ('2070', '汕尾市', '516600', '1', '20', '2070');
INSERT INTO `t_areas` VALUES ('2071', '城区', '516600', '1', '2070', '2071');
INSERT INTO `t_areas` VALUES ('2072', '海丰县', '516400', '1', '2070', '2072');
INSERT INTO `t_areas` VALUES ('2073', '陆河县', '516700', '1', '2070', '2073');
INSERT INTO `t_areas` VALUES ('2074', '陆丰市', '516500', '1', '2070', '2074');
INSERT INTO `t_areas` VALUES ('2075', '河源市', '517000', '1', '20', '2075');
INSERT INTO `t_areas` VALUES ('2076', '源城区', '517000', '1', '2075', '2076');
INSERT INTO `t_areas` VALUES ('2077', '紫金县', '517400', '1', '2075', '2077');
INSERT INTO `t_areas` VALUES ('2078', '龙川县', '517300', '1', '2075', '2078');
INSERT INTO `t_areas` VALUES ('2079', '连平县', '517100', '1', '2075', '2079');
INSERT INTO `t_areas` VALUES ('2080', '和平县', '517200', '1', '2075', '2080');
INSERT INTO `t_areas` VALUES ('2081', '东源县', '517500', '1', '2075', '2081');
INSERT INTO `t_areas` VALUES ('2082', '阳江市', '529500', '1', '20', '2082');
INSERT INTO `t_areas` VALUES ('2083', '江城区', '529500', '1', '2082', '2083');
INSERT INTO `t_areas` VALUES ('2084', '阳西县', '529800', '1', '2082', '2084');
INSERT INTO `t_areas` VALUES ('2085', '阳东县', '529900', '1', '2082', '2085');
INSERT INTO `t_areas` VALUES ('2086', '阳春市', '529600', '1', '2082', '2086');
INSERT INTO `t_areas` VALUES ('2087', '清远市', '511500', '1', '20', '2087');
INSERT INTO `t_areas` VALUES ('2088', '清城区', '511500', '1', '2087', '2088');
INSERT INTO `t_areas` VALUES ('2089', '佛冈县', '511600', '1', '2087', '2089');
INSERT INTO `t_areas` VALUES ('2090', '阳山县', '513100', '1', '2087', '2090');
INSERT INTO `t_areas` VALUES ('2091', '连山壮族瑶族自治县', '513200', '1', '2087', '2091');
INSERT INTO `t_areas` VALUES ('2092', '连南瑶族自治县', '513300', '1', '2087', '2092');
INSERT INTO `t_areas` VALUES ('2093', '清新县', '511800', '1', '2087', '2093');
INSERT INTO `t_areas` VALUES ('2094', '英德市', '513000', '1', '2087', '2094');
INSERT INTO `t_areas` VALUES ('2095', '连州市', '513400', '1', '2087', '2095');
INSERT INTO `t_areas` VALUES ('2096', '东莞市', '523000', '1', '20', '2096');
INSERT INTO `t_areas` VALUES ('2097', '中山市', '528400', '1', '20', '2097');
INSERT INTO `t_areas` VALUES ('2098', '潮州市', '521000', '1', '20', '2098');
INSERT INTO `t_areas` VALUES ('2099', '湘桥区', '521000', '1', '2098', '2099');
INSERT INTO `t_areas` VALUES ('2100', '潮安县', '515600', '1', '2098', '2100');
INSERT INTO `t_areas` VALUES ('2101', '饶平县', '515700', '1', '2098', '2101');
INSERT INTO `t_areas` VALUES ('2102', '揭阳市', '522000', '1', '20', '2102');
INSERT INTO `t_areas` VALUES ('2103', '榕城区', '522000', '1', '2102', '2103');
INSERT INTO `t_areas` VALUES ('2104', '揭东县', '515500', '1', '2102', '2104');
INSERT INTO `t_areas` VALUES ('2105', '揭西县', '515400', '1', '2102', '2105');
INSERT INTO `t_areas` VALUES ('2106', '惠来县', '515200', '1', '2102', '2106');
INSERT INTO `t_areas` VALUES ('2107', '普宁市', '515300', '1', '2102', '2107');
INSERT INTO `t_areas` VALUES ('2108', '云浮市', '527300', '1', '20', '2108');
INSERT INTO `t_areas` VALUES ('2109', '云城区', '527300', '1', '2108', '2109');
INSERT INTO `t_areas` VALUES ('2110', '新兴县', '527400', '1', '2108', '2110');
INSERT INTO `t_areas` VALUES ('2111', '郁南县', '527100', '1', '2108', '2111');
INSERT INTO `t_areas` VALUES ('2112', '云安县', '527500', '1', '2108', '2112');
INSERT INTO `t_areas` VALUES ('2113', '罗定市', '527200', '1', '2108', '2113');
INSERT INTO `t_areas` VALUES ('2114', '南宁市', '530000', '1', '21', '2114');
INSERT INTO `t_areas` VALUES ('2115', '兴宁区', '530000', '1', '2114', '2115');
INSERT INTO `t_areas` VALUES ('2116', '青秀区', '530000', '1', '2114', '2116');
INSERT INTO `t_areas` VALUES ('2117', '江南区', '530000', '1', '2114', '2117');
INSERT INTO `t_areas` VALUES ('2118', '西乡塘区', '530000', '1', '2114', '2118');
INSERT INTO `t_areas` VALUES ('2119', '良庆区', '530200', '1', '2114', '2119');
INSERT INTO `t_areas` VALUES ('2120', '邕宁区', '530200', '1', '2114', '2120');
INSERT INTO `t_areas` VALUES ('2121', '武鸣县', '530100', '1', '2114', '2121');
INSERT INTO `t_areas` VALUES ('2122', '隆安县', '532700', '1', '2114', '2122');
INSERT INTO `t_areas` VALUES ('2123', '马山县', '530600', '1', '2114', '2123');
INSERT INTO `t_areas` VALUES ('2124', '上林县', '530500', '1', '2114', '2124');
INSERT INTO `t_areas` VALUES ('2125', '宾阳县', '530400', '1', '2114', '2125');
INSERT INTO `t_areas` VALUES ('2126', '横县', '530300', '1', '2114', '2126');
INSERT INTO `t_areas` VALUES ('2127', '柳州市', '545000', '1', '21', '2127');
INSERT INTO `t_areas` VALUES ('2128', '城中区', '545000', '1', '2127', '2128');
INSERT INTO `t_areas` VALUES ('2129', '鱼峰区', '545000', '1', '2127', '2129');
INSERT INTO `t_areas` VALUES ('2130', '柳南区', '545000', '1', '2127', '2130');
INSERT INTO `t_areas` VALUES ('2131', '柳北区', '545000', '1', '2127', '2131');
INSERT INTO `t_areas` VALUES ('2132', '柳江县', '545100', '1', '2127', '2132');
INSERT INTO `t_areas` VALUES ('2133', '柳城县', '545200', '1', '2127', '2133');
INSERT INTO `t_areas` VALUES ('2134', '鹿寨县', '545600', '1', '2127', '2134');
INSERT INTO `t_areas` VALUES ('2135', '融安县', '545400', '1', '2127', '2135');
INSERT INTO `t_areas` VALUES ('2136', '融水苗族自治县', '545300', '1', '2127', '2136');
INSERT INTO `t_areas` VALUES ('2137', '三江侗族自治县', '545500', '1', '2127', '2137');
INSERT INTO `t_areas` VALUES ('2138', '桂林市', '541000', '1', '21', '2138');
INSERT INTO `t_areas` VALUES ('2139', '秀峰区', '541000', '1', '2138', '2139');
INSERT INTO `t_areas` VALUES ('2140', '叠彩区', '541000', '1', '2138', '2140');
INSERT INTO `t_areas` VALUES ('2141', '象山区', '541000', '1', '2138', '2141');
INSERT INTO `t_areas` VALUES ('2142', '七星区', '541000', '1', '2138', '2142');
INSERT INTO `t_areas` VALUES ('2143', '雁山区', '541000', '1', '2138', '2143');
INSERT INTO `t_areas` VALUES ('2144', '阳朔县', '541900', '1', '2138', '2144');
INSERT INTO `t_areas` VALUES ('2145', '临桂县', '541100', '1', '2138', '2145');
INSERT INTO `t_areas` VALUES ('2146', '灵川县', '541200', '1', '2138', '2146');
INSERT INTO `t_areas` VALUES ('2147', '全州县', '541500', '1', '2138', '2147');
INSERT INTO `t_areas` VALUES ('2148', '兴安县', '541300', '1', '2138', '2148');
INSERT INTO `t_areas` VALUES ('2149', '永福县', '541800', '1', '2138', '2149');
INSERT INTO `t_areas` VALUES ('2150', '灌阳县', '541600', '1', '2138', '2150');
INSERT INTO `t_areas` VALUES ('2151', '龙胜各族自治县', '541700', '1', '2138', '2151');
INSERT INTO `t_areas` VALUES ('2152', '资源县', '541400', '1', '2138', '2152');
INSERT INTO `t_areas` VALUES ('2153', '平乐县', '542400', '1', '2138', '2153');
INSERT INTO `t_areas` VALUES ('2154', '荔蒲县', '546600', '1', '2138', '2154');
INSERT INTO `t_areas` VALUES ('2155', '恭城瑶族自治县', '542500', '1', '2138', '2155');
INSERT INTO `t_areas` VALUES ('2156', '梧州市', '543000', '1', '21', '2156');
INSERT INTO `t_areas` VALUES ('2157', '万秀区', '543000', '1', '2156', '2157');
INSERT INTO `t_areas` VALUES ('2158', '蝶山区', '543000', '1', '2156', '2158');
INSERT INTO `t_areas` VALUES ('2159', '长洲区', '543000', '1', '2156', '2159');
INSERT INTO `t_areas` VALUES ('2160', '苍梧县', '543100', '1', '2156', '2160');
INSERT INTO `t_areas` VALUES ('2161', '藤县', '543300', '1', '2156', '2161');
INSERT INTO `t_areas` VALUES ('2162', '蒙山县', '546700', '1', '2156', '2162');
INSERT INTO `t_areas` VALUES ('2163', '岑溪市', '543200', '1', '2156', '2163');
INSERT INTO `t_areas` VALUES ('2164', '北海市', '536000', '1', '21', '2164');
INSERT INTO `t_areas` VALUES ('2165', '海城区', '536000', '1', '2164', '2165');
INSERT INTO `t_areas` VALUES ('2166', '银海区', '536000', '1', '2164', '2166');
INSERT INTO `t_areas` VALUES ('2167', '铁山港区', '536000', '1', '2164', '2167');
INSERT INTO `t_areas` VALUES ('2168', '合浦县', '536100', '1', '2164', '2168');
INSERT INTO `t_areas` VALUES ('2169', '防城港市', '538000', '1', '21', '2169');
INSERT INTO `t_areas` VALUES ('2170', '港口区', '538000', '1', '2169', '2170');
INSERT INTO `t_areas` VALUES ('2171', '防城区', '538000', '1', '2169', '2171');
INSERT INTO `t_areas` VALUES ('2172', '上思县', '535500', '1', '2169', '2172');
INSERT INTO `t_areas` VALUES ('2173', '东兴市', '538100', '1', '2169', '2173');
INSERT INTO `t_areas` VALUES ('2174', '钦州市', '535000', '1', '21', '2174');
INSERT INTO `t_areas` VALUES ('2175', '钦南区', '535000', '1', '2174', '2175');
INSERT INTO `t_areas` VALUES ('2176', '钦北区', '535000', '1', '2174', '2176');
INSERT INTO `t_areas` VALUES ('2177', '灵山县', '535400', '1', '2174', '2177');
INSERT INTO `t_areas` VALUES ('2178', '浦北县', '535300', '1', '2174', '2178');
INSERT INTO `t_areas` VALUES ('2179', '贵港市', '537100', '1', '21', '2179');
INSERT INTO `t_areas` VALUES ('2180', '港北区', '537100', '1', '2179', '2180');
INSERT INTO `t_areas` VALUES ('2181', '港南区', '537100', '1', '2179', '2181');
INSERT INTO `t_areas` VALUES ('2182', '覃塘区', '537100', '1', '2179', '2182');
INSERT INTO `t_areas` VALUES ('2183', '平南县', '537300', '1', '2179', '2183');
INSERT INTO `t_areas` VALUES ('2184', '桂平市', '537200', '1', '2179', '2184');
INSERT INTO `t_areas` VALUES ('2185', '玉林市', '537000', '1', '21', '2185');
INSERT INTO `t_areas` VALUES ('2186', '玉州区', '537000', '1', '2185', '2186');
INSERT INTO `t_areas` VALUES ('2187', '容县', '537500', '1', '2185', '2187');
INSERT INTO `t_areas` VALUES ('2188', '陆川县', '537700', '1', '2185', '2188');
INSERT INTO `t_areas` VALUES ('2189', '博白县', '537600', '1', '2185', '2189');
INSERT INTO `t_areas` VALUES ('2190', '兴业县', '537800', '1', '2185', '2190');
INSERT INTO `t_areas` VALUES ('2191', '北流市', '537400', '1', '2185', '2191');
INSERT INTO `t_areas` VALUES ('2192', '百色市', '533000', '1', '21', '2192');
INSERT INTO `t_areas` VALUES ('2193', '右江区', '533000', '1', '2192', '2193');
INSERT INTO `t_areas` VALUES ('2194', '田阳县', '533600', '1', '2192', '2194');
INSERT INTO `t_areas` VALUES ('2195', '田东县', '531500', '1', '2192', '2195');
INSERT INTO `t_areas` VALUES ('2196', '平果县', '531400', '1', '2192', '2196');
INSERT INTO `t_areas` VALUES ('2197', '德保县', '533700', '1', '2192', '2197');
INSERT INTO `t_areas` VALUES ('2198', '靖西县', '533800', '1', '2192', '2198');
INSERT INTO `t_areas` VALUES ('2199', '那坡县', '533900', '1', '2192', '2199');
INSERT INTO `t_areas` VALUES ('2200', '凌云县', '533100', '1', '2192', '2200');
INSERT INTO `t_areas` VALUES ('2201', '乐业县', '533200', '1', '2192', '2201');
INSERT INTO `t_areas` VALUES ('2202', '田林县', '533300', '1', '2192', '2202');
INSERT INTO `t_areas` VALUES ('2203', '西林县', '533500', '1', '2192', '2203');
INSERT INTO `t_areas` VALUES ('2204', '隆林各族自治县', '533500', '1', '2192', '2204');
INSERT INTO `t_areas` VALUES ('2205', '贺州市', '542800', '1', '21', '2205');
INSERT INTO `t_areas` VALUES ('2206', '八步区', '552106', '1', '2205', '2206');
INSERT INTO `t_areas` VALUES ('2207', '昭平县', '546800', '1', '2205', '2207');
INSERT INTO `t_areas` VALUES ('2208', '钟山县', '542600', '1', '2205', '2208');
INSERT INTO `t_areas` VALUES ('2209', '富川瑶族自治县', '542700', '1', '2205', '2209');
INSERT INTO `t_areas` VALUES ('2210', '河池市', '547000', '1', '21', '2210');
INSERT INTO `t_areas` VALUES ('2211', '金城江区', '547000', '1', '2210', '2211');
INSERT INTO `t_areas` VALUES ('2212', '南丹县', '547200', '1', '2210', '2212');
INSERT INTO `t_areas` VALUES ('2213', '天峨县', '547300', '1', '2210', '2213');
INSERT INTO `t_areas` VALUES ('2214', '凤山县', '547600', '1', '2210', '2214');
INSERT INTO `t_areas` VALUES ('2215', '东兰县', '547400', '1', '2210', '2215');
INSERT INTO `t_areas` VALUES ('2216', '罗城仫佬族自治县', '546400', '1', '2210', '2216');
INSERT INTO `t_areas` VALUES ('2217', '环江毛南族自治县', '547100', '1', '2210', '2217');
INSERT INTO `t_areas` VALUES ('2218', '巴马瑶族自治县', '547500', '1', '2210', '2218');
INSERT INTO `t_areas` VALUES ('2219', '都安瑶族自治县', '530700', '1', '2210', '2219');
INSERT INTO `t_areas` VALUES ('2220', '大化瑶族自治县', '530800', '1', '2210', '2220');
INSERT INTO `t_areas` VALUES ('2221', '宜州市', '546300', '1', '2210', '2221');
INSERT INTO `t_areas` VALUES ('2222', '来宾市', '546100', '1', '21', '2222');
INSERT INTO `t_areas` VALUES ('2223', '兴宾区', '546100', '1', '2222', '2223');
INSERT INTO `t_areas` VALUES ('2224', '忻城县', '546200', '1', '2222', '2224');
INSERT INTO `t_areas` VALUES ('2225', '象州县', '545800', '1', '2222', '2225');
INSERT INTO `t_areas` VALUES ('2226', '武宣县', '545900', '1', '2222', '2226');
INSERT INTO `t_areas` VALUES ('2227', '金秀瑶族自治县', '545700', '1', '2222', '2227');
INSERT INTO `t_areas` VALUES ('2228', '合山市', '546500', '1', '2222', '2228');
INSERT INTO `t_areas` VALUES ('2229', '崇左市', '532200', '1', '21', '2229');
INSERT INTO `t_areas` VALUES ('2230', '江洲区', '532200', '1', '2229', '2230');
INSERT INTO `t_areas` VALUES ('2231', '扶绥县', '532100', '1', '2229', '2231');
INSERT INTO `t_areas` VALUES ('2232', '宁明县', '532500', '1', '2229', '2232');
INSERT INTO `t_areas` VALUES ('2233', '龙州县', '532400', '1', '2229', '2233');
INSERT INTO `t_areas` VALUES ('2234', '大新县', '532300', '1', '2229', '2234');
INSERT INTO `t_areas` VALUES ('2235', '天等县', '532800', '1', '2229', '2235');
INSERT INTO `t_areas` VALUES ('2236', '凭祥市', '532600', '1', '2229', '2236');
INSERT INTO `t_areas` VALUES ('2237', '海口市', '570100', '1', '22', '2237');
INSERT INTO `t_areas` VALUES ('2238', '秀英区', '570100', '1', '2237', '2238');
INSERT INTO `t_areas` VALUES ('2239', '龙华区', '570100', '1', '2237', '2239');
INSERT INTO `t_areas` VALUES ('2240', '琼山区', '571100', '1', '2237', '2240');
INSERT INTO `t_areas` VALUES ('2241', '美兰区', '570100', '1', '2237', '2241');
INSERT INTO `t_areas` VALUES ('2242', '三亚市', '572000', '1', '22', '2242');
INSERT INTO `t_areas` VALUES ('2243', '万州区', '404100', '1', '23', '2243');
INSERT INTO `t_areas` VALUES ('2244', '涪陵区', '408000', '1', '23', '2244');
INSERT INTO `t_areas` VALUES ('2245', '渝中区', '400010', '1', '23', '2245');
INSERT INTO `t_areas` VALUES ('2246', '大渡口区', '400052', '1', '23', '2246');
INSERT INTO `t_areas` VALUES ('2247', '江北区', '400020', '1', '23', '2247');
INSERT INTO `t_areas` VALUES ('2248', '沙坪坝区', '400030', '1', '23', '2248');
INSERT INTO `t_areas` VALUES ('2249', '九龙坡区', '400039', '1', '23', '2249');
INSERT INTO `t_areas` VALUES ('2250', '南岸区', '400060', '1', '23', '2250');
INSERT INTO `t_areas` VALUES ('2251', '北碚区', '400700', '1', '23', '2251');
INSERT INTO `t_areas` VALUES ('2252', '万盛区', '400800', '1', '23', '2252');
INSERT INTO `t_areas` VALUES ('2253', '双桥区', '400900', '1', '23', '2253');
INSERT INTO `t_areas` VALUES ('2254', '渝北区', '401120', '1', '23', '2254');
INSERT INTO `t_areas` VALUES ('2255', '巴南区', '401320', '1', '23', '2255');
INSERT INTO `t_areas` VALUES ('2256', '黔江区', '409000', '1', '23', '2256');
INSERT INTO `t_areas` VALUES ('2257', '长寿区', '401220', '1', '23', '2257');
INSERT INTO `t_areas` VALUES ('2258', '江津区', '402260', '1', '23', '2258');
INSERT INTO `t_areas` VALUES ('2259', '合川区', '401520', '1', '23', '2259');
INSERT INTO `t_areas` VALUES ('2260', '永川区', '402160', '1', '23', '2260');
INSERT INTO `t_areas` VALUES ('2261', '南川区', '408400', '1', '23', '2261');
INSERT INTO `t_areas` VALUES ('2262', '綦江县', '401420', '1', '23', '2262');
INSERT INTO `t_areas` VALUES ('2263', '潼南县', '402660', '1', '23', '2263');
INSERT INTO `t_areas` VALUES ('2264', '铜梁县', '402560', '1', '23', '2264');
INSERT INTO `t_areas` VALUES ('2265', '大足县', '402360', '1', '23', '2265');
INSERT INTO `t_areas` VALUES ('2266', '荣昌县', '402460', '1', '23', '2266');
INSERT INTO `t_areas` VALUES ('2267', '璧山县', '402760', '1', '23', '2267');
INSERT INTO `t_areas` VALUES ('2268', '梁平县', '405200', '1', '23', '2268');
INSERT INTO `t_areas` VALUES ('2269', '城口县', '405900', '1', '23', '2269');
INSERT INTO `t_areas` VALUES ('2270', '丰都县', '408200', '1', '23', '2270');
INSERT INTO `t_areas` VALUES ('2271', '垫江县', '408300', '1', '23', '2271');
INSERT INTO `t_areas` VALUES ('2272', '武隆县', '408500', '1', '23', '2272');
INSERT INTO `t_areas` VALUES ('2273', '忠县', '404300', '1', '23', '2273');
INSERT INTO `t_areas` VALUES ('2274', '开县', '405400', '1', '23', '2274');
INSERT INTO `t_areas` VALUES ('2275', '云阳县', '404500', '1', '23', '2275');
INSERT INTO `t_areas` VALUES ('2276', '奉节县', '404600', '1', '23', '2276');
INSERT INTO `t_areas` VALUES ('2277', '巫山县', '404700', '1', '23', '2277');
INSERT INTO `t_areas` VALUES ('2278', '巫溪县', '405800', '1', '23', '2278');
INSERT INTO `t_areas` VALUES ('2279', '石柱土家族自治县', '409100', '1', '23', '2279');
INSERT INTO `t_areas` VALUES ('2280', '秀山土家族苗族自治县', '409900', '1', '23', '2280');
INSERT INTO `t_areas` VALUES ('2281', '酉阳土家族苗族自治县', '409800', '1', '23', '2281');
INSERT INTO `t_areas` VALUES ('2282', '彭水苗族土家族自治县', '409600', '1', '23', '2282');
INSERT INTO `t_areas` VALUES ('2283', '成都市', '610000', '1', '25', '2283');
INSERT INTO `t_areas` VALUES ('2284', '锦江区', '610000', '1', '2283', '2284');
INSERT INTO `t_areas` VALUES ('2285', '青羊区', '610000', '1', '2283', '2285');
INSERT INTO `t_areas` VALUES ('2286', '金牛区', '610000', '1', '2283', '2286');
INSERT INTO `t_areas` VALUES ('2287', '武侯区', '610000', '1', '2283', '2287');
INSERT INTO `t_areas` VALUES ('2288', '成华区', '610000', '1', '2283', '2288');
INSERT INTO `t_areas` VALUES ('2289', '龙泉驿区', '610100', '1', '2283', '2289');
INSERT INTO `t_areas` VALUES ('2290', '青白江区', '610300', '1', '2283', '2290');
INSERT INTO `t_areas` VALUES ('2291', '新都区', '610500', '1', '2283', '2291');
INSERT INTO `t_areas` VALUES ('2292', '温江区', '611100', '1', '2283', '2292');
INSERT INTO `t_areas` VALUES ('2293', '金堂县', '610400', '1', '2283', '2293');
INSERT INTO `t_areas` VALUES ('2294', '双流县', '610200', '1', '2283', '2294');
INSERT INTO `t_areas` VALUES ('2295', '郫县', '611700', '1', '2283', '2295');
INSERT INTO `t_areas` VALUES ('2296', '大邑县', '611300', '1', '2283', '2296');
INSERT INTO `t_areas` VALUES ('2297', '蒲江县', '611600', '1', '2283', '2297');
INSERT INTO `t_areas` VALUES ('2298', '新津县', '611400', '1', '2283', '2298');
INSERT INTO `t_areas` VALUES ('2299', '都江堰市', '611800', '1', '2283', '2299');
INSERT INTO `t_areas` VALUES ('2300', '彭州市', '610000', '1', '2283', '2300');
INSERT INTO `t_areas` VALUES ('2301', '邛崃市', '611500', '1', '2283', '2301');
INSERT INTO `t_areas` VALUES ('2302', '崇州市', '611200', '1', '2283', '2302');
INSERT INTO `t_areas` VALUES ('2303', '自贡市', '643000', '1', '25', '2303');
INSERT INTO `t_areas` VALUES ('2304', '自流井区', '643000', '1', '2303', '2304');
INSERT INTO `t_areas` VALUES ('2305', '贡井区', '643020', '1', '2303', '2305');
INSERT INTO `t_areas` VALUES ('2306', '大安区', '643010', '1', '2303', '2306');
INSERT INTO `t_areas` VALUES ('2307', '沿滩区', '643030', '1', '2303', '2307');
INSERT INTO `t_areas` VALUES ('2308', '荣县', '643100', '1', '2303', '2308');
INSERT INTO `t_areas` VALUES ('2309', '富顺县', '643200', '1', '2303', '2309');
INSERT INTO `t_areas` VALUES ('2310', '攀枝花市', '617000', '1', '25', '2310');
INSERT INTO `t_areas` VALUES ('2311', '东区', '617000', '1', '2310', '2311');
INSERT INTO `t_areas` VALUES ('2312', '西区', '617000', '1', '2310', '2312');
INSERT INTO `t_areas` VALUES ('2313', '仁和区', '617000', '1', '2310', '2313');
INSERT INTO `t_areas` VALUES ('2314', '米易县', '617200', '1', '2310', '2314');
INSERT INTO `t_areas` VALUES ('2315', '盐边县', '617100', '1', '2310', '2315');
INSERT INTO `t_areas` VALUES ('2316', '泸州市', '646000', '1', '25', '2316');
INSERT INTO `t_areas` VALUES ('2317', '江阳区', '646000', '1', '2316', '2317');
INSERT INTO `t_areas` VALUES ('2318', '纳溪区', '646300', '1', '2316', '2318');
INSERT INTO `t_areas` VALUES ('2319', '龙马潭区', '646000', '1', '2316', '2319');
INSERT INTO `t_areas` VALUES ('2320', '泸县', '646100', '1', '2316', '2320');
INSERT INTO `t_areas` VALUES ('2321', '合江县', '646200', '1', '2316', '2321');
INSERT INTO `t_areas` VALUES ('2322', '叙永县', '646400', '1', '2316', '2322');
INSERT INTO `t_areas` VALUES ('2323', '古蔺县', '646500', '1', '2316', '2323');
INSERT INTO `t_areas` VALUES ('2324', '德阳市', '618000', '1', '25', '2324');
INSERT INTO `t_areas` VALUES ('2325', '旌阳区', '618000', '1', '2324', '2325');
INSERT INTO `t_areas` VALUES ('2326', '中江县', '618300', '1', '2324', '2326');
INSERT INTO `t_areas` VALUES ('2327', '罗江县', '618500', '1', '2324', '2327');
INSERT INTO `t_areas` VALUES ('2328', '广汉市', '618300', '1', '2324', '2328');
INSERT INTO `t_areas` VALUES ('2329', '什邡市', '618400', '1', '2324', '2329');
INSERT INTO `t_areas` VALUES ('2330', '绵竹市', '618200', '1', '2324', '2330');
INSERT INTO `t_areas` VALUES ('2331', '绵阳市', '621000', '1', '25', '2331');
INSERT INTO `t_areas` VALUES ('2332', '涪城区', '621000', '1', '2331', '2332');
INSERT INTO `t_areas` VALUES ('2333', '游仙区', '621000', '1', '2331', '2333');
INSERT INTO `t_areas` VALUES ('2334', '三台县', '621100', '1', '2331', '2334');
INSERT INTO `t_areas` VALUES ('2335', '盐亭县', '621600', '1', '2331', '2335');
INSERT INTO `t_areas` VALUES ('2336', '安县', '622650', '1', '2331', '2336');
INSERT INTO `t_areas` VALUES ('2337', '梓潼县', '622150', '1', '2331', '2337');
INSERT INTO `t_areas` VALUES ('2338', '北川羌族自治县', '622550', '1', '2331', '2338');
INSERT INTO `t_areas` VALUES ('2339', '平武县', '622550', '1', '2331', '2339');
INSERT INTO `t_areas` VALUES ('2340', '江油市', '621700', '1', '2331', '2340');
INSERT INTO `t_areas` VALUES ('2341', '广元市', '628000', '1', '25', '2341');
INSERT INTO `t_areas` VALUES ('2342', '市中区', '628000', '1', '2341', '2342');
INSERT INTO `t_areas` VALUES ('2343', '元坝区', '628000', '1', '2341', '2343');
INSERT INTO `t_areas` VALUES ('2344', '朝天区', '628000', '1', '2341', '2344');
INSERT INTO `t_areas` VALUES ('2345', '旺苍县', '628200', '1', '2341', '2345');
INSERT INTO `t_areas` VALUES ('2346', '青川县', '628100', '1', '2341', '2346');
INSERT INTO `t_areas` VALUES ('2347', '剑阁县', '628300', '1', '2341', '2347');
INSERT INTO `t_areas` VALUES ('2348', '苍溪县', '628400', '1', '2341', '2348');
INSERT INTO `t_areas` VALUES ('2349', '遂宁市', '629000', '1', '25', '2349');
INSERT INTO `t_areas` VALUES ('2350', '船山区', '629000', '1', '2349', '2350');
INSERT INTO `t_areas` VALUES ('2351', '安居区', '629000', '1', '2349', '2351');
INSERT INTO `t_areas` VALUES ('2352', '蓬溪县', '629100', '1', '2349', '2352');
INSERT INTO `t_areas` VALUES ('2353', '射洪县', '629200', '1', '2349', '2353');
INSERT INTO `t_areas` VALUES ('2354', '大英县', '629300', '1', '2349', '2354');
INSERT INTO `t_areas` VALUES ('2355', '内江市', '628000', '1', '25', '2355');
INSERT INTO `t_areas` VALUES ('2356', '市中区', '641000', '1', '2355', '2356');
INSERT INTO `t_areas` VALUES ('2357', '东兴区', '641100', '1', '2355', '2357');
INSERT INTO `t_areas` VALUES ('2358', '威远县', '642450', '1', '2355', '2358');
INSERT INTO `t_areas` VALUES ('2359', '资中县', '641200', '1', '2355', '2359');
INSERT INTO `t_areas` VALUES ('2360', '隆昌县', '642150', '1', '2355', '2360');
INSERT INTO `t_areas` VALUES ('2361', '乐山市', '614000', '1', '25', '2361');
INSERT INTO `t_areas` VALUES ('2362', '市中区', '614000', '1', '2361', '2362');
INSERT INTO `t_areas` VALUES ('2363', '沙湾区', '614900', '1', '2361', '2363');
INSERT INTO `t_areas` VALUES ('2364', '五通桥区', '614800', '1', '2361', '2364');
INSERT INTO `t_areas` VALUES ('2365', '金口河区', '614700', '1', '2361', '2365');
INSERT INTO `t_areas` VALUES ('2366', '犍为县', '614400', '1', '2361', '2366');
INSERT INTO `t_areas` VALUES ('2367', '井研县', '613100', '1', '2361', '2367');
INSERT INTO `t_areas` VALUES ('2368', '夹江县', '614100', '1', '2361', '2368');
INSERT INTO `t_areas` VALUES ('2369', '沐川县', '614500', '1', '2361', '2369');
INSERT INTO `t_areas` VALUES ('2370', '峨边彝族自治县', '614300', '1', '2361', '2370');
INSERT INTO `t_areas` VALUES ('2371', '马边彝族自治县', '614600', '1', '2361', '2371');
INSERT INTO `t_areas` VALUES ('2372', '峨眉山市', '614200', '1', '2361', '2372');
INSERT INTO `t_areas` VALUES ('2373', '南充市', '637000', '1', '25', '2373');
INSERT INTO `t_areas` VALUES ('2374', '顺庆区', '637000', '1', '2373', '2374');
INSERT INTO `t_areas` VALUES ('2375', '高坪区', '637100', '1', '2373', '2375');
INSERT INTO `t_areas` VALUES ('2376', '嘉陵区', '637500', '1', '2373', '2376');
INSERT INTO `t_areas` VALUES ('2377', '南部县', '637300', '1', '2373', '2377');
INSERT INTO `t_areas` VALUES ('2378', '营山县', '637700', '1', '2373', '2378');
INSERT INTO `t_areas` VALUES ('2379', '蓬安县', '637800', '1', '2373', '2379');
INSERT INTO `t_areas` VALUES ('2380', '仪陇县', '637600', '1', '2373', '2380');
INSERT INTO `t_areas` VALUES ('2381', '西充县', '637200', '1', '2373', '2381');
INSERT INTO `t_areas` VALUES ('2382', '阆中市', '637400', '1', '2373', '2382');
INSERT INTO `t_areas` VALUES ('2383', '眉山市', '620000', '1', '25', '2383');
INSERT INTO `t_areas` VALUES ('2384', '东坡区', '620000', '1', '2383', '2384');
INSERT INTO `t_areas` VALUES ('2385', '仁寿县', '620500', '1', '2383', '2385');
INSERT INTO `t_areas` VALUES ('2386', '彭山县', '620800', '1', '2383', '2386');
INSERT INTO `t_areas` VALUES ('2387', '洪雅县', '620300', '1', '2383', '2387');
INSERT INTO `t_areas` VALUES ('2388', '丹棱县', '620200', '1', '2383', '2388');
INSERT INTO `t_areas` VALUES ('2389', '青神县', '620400', '1', '2383', '2389');
INSERT INTO `t_areas` VALUES ('2390', '宜宾市', '644000', '1', '25', '2390');
INSERT INTO `t_areas` VALUES ('2391', '翠屏区', '644000', '1', '2390', '2391');
INSERT INTO `t_areas` VALUES ('2392', '宜宾县', '644600', '1', '2390', '2392');
INSERT INTO `t_areas` VALUES ('2393', '南溪县', '644100', '1', '2390', '2393');
INSERT INTO `t_areas` VALUES ('2394', '江安县', '644200', '1', '2390', '2394');
INSERT INTO `t_areas` VALUES ('2395', '长宁县', '644300', '1', '2390', '2395');
INSERT INTO `t_areas` VALUES ('2396', '高县', '645150', '1', '2390', '2396');
INSERT INTO `t_areas` VALUES ('2397', '珙县', '644500', '1', '2390', '2397');
INSERT INTO `t_areas` VALUES ('2398', '筠连县', '645250', '1', '2390', '2398');
INSERT INTO `t_areas` VALUES ('2399', '兴文县', '644400', '1', '2390', '2399');
INSERT INTO `t_areas` VALUES ('2400', '屏山县', '645350', '1', '2390', '2400');
INSERT INTO `t_areas` VALUES ('2401', '广安市', '638550', '1', '25', '2401');
INSERT INTO `t_areas` VALUES ('2402', '广安区', '638550', '1', '2401', '2402');
INSERT INTO `t_areas` VALUES ('2403', '岳池县', '638300', '1', '2401', '2403');
INSERT INTO `t_areas` VALUES ('2404', '武胜县', '638400', '1', '2401', '2404');
INSERT INTO `t_areas` VALUES ('2405', '邻水县', '638500', '1', '2401', '2405');
INSERT INTO `t_areas` VALUES ('2406', '华蓥市', '638600', '1', '2401', '2406');
INSERT INTO `t_areas` VALUES ('2407', '达州市', '635000', '1', '25', '2407');
INSERT INTO `t_areas` VALUES ('2408', '通川区', '635000', '1', '2407', '2408');
INSERT INTO `t_areas` VALUES ('2409', '达县', '635000', '1', '2407', '2409');
INSERT INTO `t_areas` VALUES ('2410', '宣汉县', '636150', '1', '2407', '2410');
INSERT INTO `t_areas` VALUES ('2411', '开江县', '636250', '1', '2407', '2411');
INSERT INTO `t_areas` VALUES ('2412', '大竹县', '635100', '1', '2407', '2412');
INSERT INTO `t_areas` VALUES ('2413', '渠县', '635200', '1', '2407', '2413');
INSERT INTO `t_areas` VALUES ('2414', '万源市', '636350', '1', '2407', '2414');
INSERT INTO `t_areas` VALUES ('2415', '雅安市', '625000', '1', '25', '2415');
INSERT INTO `t_areas` VALUES ('2416', '雨城区', '625000', '1', '2415', '2416');
INSERT INTO `t_areas` VALUES ('2417', '名山县', '625100', '1', '2415', '2417');
INSERT INTO `t_areas` VALUES ('2418', '荥经县', '625200', '1', '2415', '2418');
INSERT INTO `t_areas` VALUES ('2419', '汉源县', '625300', '1', '2415', '2419');
INSERT INTO `t_areas` VALUES ('2420', '石棉县', '625400', '1', '2415', '2420');
INSERT INTO `t_areas` VALUES ('2421', '天全县', '625500', '1', '2415', '2421');
INSERT INTO `t_areas` VALUES ('2422', '芦山县', '625600', '1', '2415', '2422');
INSERT INTO `t_areas` VALUES ('2423', '宝兴县', '625700', '1', '2415', '2423');
INSERT INTO `t_areas` VALUES ('2424', '巴中市', '636600', '1', '25', '2424');
INSERT INTO `t_areas` VALUES ('2425', '巴州区', '636600', '1', '2424', '2425');
INSERT INTO `t_areas` VALUES ('2426', '通江县', '636700', '1', '2424', '2426');
INSERT INTO `t_areas` VALUES ('2427', '南江县', '635600', '1', '2424', '2427');
INSERT INTO `t_areas` VALUES ('2428', '平昌县', '636400', '1', '2424', '2428');
INSERT INTO `t_areas` VALUES ('2429', '资阳市', '641300', '1', '25', '2429');
INSERT INTO `t_areas` VALUES ('2430', '雁江区', '641300', '1', '2429', '2430');
INSERT INTO `t_areas` VALUES ('2431', '安岳县', '642350', '1', '2429', '2431');
INSERT INTO `t_areas` VALUES ('2432', '乐至县', '641500', '1', '2429', '2432');
INSERT INTO `t_areas` VALUES ('2433', '简阳市', '641400', '1', '2429', '2433');
INSERT INTO `t_areas` VALUES ('2434', '阿坝藏族羌族自治州', '624000', '1', '25', '2434');
INSERT INTO `t_areas` VALUES ('2435', '汶川县', '623000', '1', '2434', '2435');
INSERT INTO `t_areas` VALUES ('2436', '理县', '623100', '1', '2434', '2436');
INSERT INTO `t_areas` VALUES ('2437', '茂县', '623200', '1', '2434', '2437');
INSERT INTO `t_areas` VALUES ('2438', '松潘县', '623300', '1', '2434', '2438');
INSERT INTO `t_areas` VALUES ('2439', '九寨沟县', '623400', '1', '2434', '2439');
INSERT INTO `t_areas` VALUES ('2440', '金川县', '624100', '1', '2434', '2440');
INSERT INTO `t_areas` VALUES ('2441', '小金县', '624200', '1', '2434', '2441');
INSERT INTO `t_areas` VALUES ('2442', '黑水县', '623500', '1', '2434', '2442');
INSERT INTO `t_areas` VALUES ('2443', '马尔康县', '624000', '1', '2434', '2443');
INSERT INTO `t_areas` VALUES ('2444', '壤塘县', '624300', '1', '2434', '2444');
INSERT INTO `t_areas` VALUES ('2445', '阿坝县', '624600', '1', '2434', '2445');
INSERT INTO `t_areas` VALUES ('2446', '若尔盖县', '624500', '1', '2434', '2446');
INSERT INTO `t_areas` VALUES ('2447', '红原县', '624400', '1', '2434', '2447');
INSERT INTO `t_areas` VALUES ('2448', '甘孜藏族自治州', '626000', '1', '25', '2448');
INSERT INTO `t_areas` VALUES ('2449', '康定县', '626000', '1', '2448', '2449');
INSERT INTO `t_areas` VALUES ('2450', '泸定县', '626100', '1', '2448', '2450');
INSERT INTO `t_areas` VALUES ('2451', '丹巴县', '626300', '1', '2448', '2451');
INSERT INTO `t_areas` VALUES ('2452', '九龙县', '616200', '1', '2448', '2452');
INSERT INTO `t_areas` VALUES ('2453', '雅江县', '627450', '1', '2448', '2453');
INSERT INTO `t_areas` VALUES ('2454', '道孚县', '626400', '1', '2448', '2454');
INSERT INTO `t_areas` VALUES ('2455', '炉霍县', '626500', '1', '2448', '2455');
INSERT INTO `t_areas` VALUES ('2456', '甘孜县', '626700', '1', '2448', '2456');
INSERT INTO `t_areas` VALUES ('2457', '新龙县', '626800', '1', '2448', '2457');
INSERT INTO `t_areas` VALUES ('2458', '德格县', '627250', '1', '2448', '2458');
INSERT INTO `t_areas` VALUES ('2459', '白玉县', '627150', '1', '2448', '2459');
INSERT INTO `t_areas` VALUES ('2460', '石渠县', '627350', '1', '2448', '2460');
INSERT INTO `t_areas` VALUES ('2461', '色达县', '626600', '1', '2448', '2461');
INSERT INTO `t_areas` VALUES ('2462', '理塘县', '624300', '1', '2448', '2462');
INSERT INTO `t_areas` VALUES ('2463', '巴塘县', '627650', '1', '2448', '2463');
INSERT INTO `t_areas` VALUES ('2464', '乡城县', '627850', '1', '2448', '2464');
INSERT INTO `t_areas` VALUES ('2465', '稻城县', '627750', '1', '2448', '2465');
INSERT INTO `t_areas` VALUES ('2466', '得荣县', '627950', '1', '2448', '2466');
INSERT INTO `t_areas` VALUES ('2467', '凉山彝族自治州', '615000', '1', '25', '2467');
INSERT INTO `t_areas` VALUES ('2468', '西昌市', '615000', '1', '2467', '2468');
INSERT INTO `t_areas` VALUES ('2469', '木里藏族自治县', '615800', '1', '2467', '2469');
INSERT INTO `t_areas` VALUES ('2470', '盐源县', '615700', '1', '2467', '2470');
INSERT INTO `t_areas` VALUES ('2471', '德昌县', '615500', '1', '2467', '2471');
INSERT INTO `t_areas` VALUES ('2472', '会理县', '615100', '1', '2467', '2472');
INSERT INTO `t_areas` VALUES ('2473', '会东县', '615200', '1', '2467', '2473');
INSERT INTO `t_areas` VALUES ('2474', '宁南县', '615400', '1', '2467', '2474');
INSERT INTO `t_areas` VALUES ('2475', '普格县', '615300', '1', '2467', '2475');
INSERT INTO `t_areas` VALUES ('2476', '布拖县', '615350', '1', '2467', '2476');
INSERT INTO `t_areas` VALUES ('2477', '金阳县', '616250', '1', '2467', '2477');
INSERT INTO `t_areas` VALUES ('2478', '昭觉县', '616150', '1', '2467', '2478');
INSERT INTO `t_areas` VALUES ('2479', '喜德县', '616750', '1', '2467', '2479');
INSERT INTO `t_areas` VALUES ('2480', '冕宁县', '615600', '1', '2467', '2480');
INSERT INTO `t_areas` VALUES ('2481', '越西县', '616650', '1', '2467', '2481');
INSERT INTO `t_areas` VALUES ('2482', '甘洛县', '616850', '1', '2467', '2482');
INSERT INTO `t_areas` VALUES ('2483', '美姑县', '616450', '1', '2467', '2483');
INSERT INTO `t_areas` VALUES ('2484', '雷波县', '616550', '1', '2467', '2484');
INSERT INTO `t_areas` VALUES ('2485', '贵阳市', '550000', '1', '26', '2485');
INSERT INTO `t_areas` VALUES ('2486', '南明区', '550000', '1', '2485', '2486');
INSERT INTO `t_areas` VALUES ('2487', '云岩区', '550000', '1', '2485', '2487');
INSERT INTO `t_areas` VALUES ('2488', '花溪区', '550000', '1', '2485', '2488');
INSERT INTO `t_areas` VALUES ('2489', '乌当区', '550000', '1', '2485', '2489');
INSERT INTO `t_areas` VALUES ('2490', '白云区', '550000', '1', '2485', '2490');
INSERT INTO `t_areas` VALUES ('2491', '小河区', '550000', '1', '2485', '2491');
INSERT INTO `t_areas` VALUES ('2492', '开阳县', '550300', '1', '2485', '2492');
INSERT INTO `t_areas` VALUES ('2493', '息烽县', '551100', '1', '2485', '2493');
INSERT INTO `t_areas` VALUES ('2494', '修文县', '550200', '1', '2485', '2494');
INSERT INTO `t_areas` VALUES ('2495', '清镇市', '551400', '1', '2485', '2495');
INSERT INTO `t_areas` VALUES ('2496', '六盘水市', '553000', '1', '26', '2496');
INSERT INTO `t_areas` VALUES ('2497', '钟山区', '553000', '1', '2496', '2497');
INSERT INTO `t_areas` VALUES ('2498', '六枝特区', '553400', '1', '2496', '2498');
INSERT INTO `t_areas` VALUES ('2499', '水城县', '553000', '1', '2496', '2499');
INSERT INTO `t_areas` VALUES ('2500', '盘县', '561600', '1', '2496', '2500');
INSERT INTO `t_areas` VALUES ('2501', '遵义市', '563000', '1', '26', '2501');
INSERT INTO `t_areas` VALUES ('2502', '红花岗区', '563000', '1', '2501', '2502');
INSERT INTO `t_areas` VALUES ('2503', '汇川区', '563000', '1', '2501', '2503');
INSERT INTO `t_areas` VALUES ('2504', '遵义县', '563100', '1', '2501', '2504');
INSERT INTO `t_areas` VALUES ('2505', '桐梓县', '563200', '1', '2501', '2505');
INSERT INTO `t_areas` VALUES ('2506', '绥阳县', '563300', '1', '2501', '2506');
INSERT INTO `t_areas` VALUES ('2507', '正安县', '563400', '1', '2501', '2507');
INSERT INTO `t_areas` VALUES ('2508', '道真仡佬族苗族自治县', '563500', '1', '2501', '2508');
INSERT INTO `t_areas` VALUES ('2509', '务川仡佬族苗族自治县', '564300', '1', '2501', '2509');
INSERT INTO `t_areas` VALUES ('2510', '凤冈县', '564200', '1', '2501', '2510');
INSERT INTO `t_areas` VALUES ('2511', '湄潭县', '564100', '1', '2501', '2511');
INSERT INTO `t_areas` VALUES ('2512', '余庆县', '564400', '1', '2501', '2512');
INSERT INTO `t_areas` VALUES ('2513', '习水县', '564600', '1', '2501', '2513');
INSERT INTO `t_areas` VALUES ('2514', '赤水市', '564700', '1', '2501', '2514');
INSERT INTO `t_areas` VALUES ('2515', '仁怀市', '564500', '1', '2501', '2515');
INSERT INTO `t_areas` VALUES ('2516', '安顺市', '561000', '1', '26', '2516');
INSERT INTO `t_areas` VALUES ('2517', '西秀区', '561000', '1', '2516', '2517');
INSERT INTO `t_areas` VALUES ('2518', '平坝县', '561100', '1', '2516', '2518');
INSERT INTO `t_areas` VALUES ('2519', '普定县', '562100', '1', '2516', '2519');
INSERT INTO `t_areas` VALUES ('2520', '镇宁布依族苗族自治县', '561200', '1', '2516', '2520');
INSERT INTO `t_areas` VALUES ('2521', '关岭布依族苗族自治县', '561300', '1', '2516', '2521');
INSERT INTO `t_areas` VALUES ('2522', '紫云苗族布依族自治县', '550800', '1', '2516', '2522');
INSERT INTO `t_areas` VALUES ('2523', '铜仁地区', '554300', '1', '26', '2523');
INSERT INTO `t_areas` VALUES ('2524', '铜仁市', '554300', '1', '2523', '2524');
INSERT INTO `t_areas` VALUES ('2525', '江口县', '554400', '1', '2523', '2525');
INSERT INTO `t_areas` VALUES ('2526', '玉屏侗族自治县', '554000', '1', '2523', '2526');
INSERT INTO `t_areas` VALUES ('2527', '石阡县', '555100', '1', '2523', '2527');
INSERT INTO `t_areas` VALUES ('2528', '思南县', '565100', '1', '2523', '2528');
INSERT INTO `t_areas` VALUES ('2529', '印江土家族苗族自治县', '555200', '1', '2523', '2529');
INSERT INTO `t_areas` VALUES ('2530', '德江县', '565200', '1', '2523', '2530');
INSERT INTO `t_areas` VALUES ('2531', '沿河土家族自治县', '565300', '1', '2523', '2531');
INSERT INTO `t_areas` VALUES ('2532', '松桃苗族自治县', '554100', '1', '2523', '2532');
INSERT INTO `t_areas` VALUES ('2533', '万山特区', '554200', '1', '2523', '2533');
INSERT INTO `t_areas` VALUES ('2534', '黔西南布依族苗族自治州', '562400', '1', '26', '2534');
INSERT INTO `t_areas` VALUES ('2535', '兴义市', '562400', '1', '2534', '2535');
INSERT INTO `t_areas` VALUES ('2536', '兴仁县', '562300', '1', '2534', '2536');
INSERT INTO `t_areas` VALUES ('2537', '普安县', '561500', '1', '2534', '2537');
INSERT INTO `t_areas` VALUES ('2538', '晴隆县', '561400', '1', '2534', '2538');
INSERT INTO `t_areas` VALUES ('2539', '贞丰县', '562200', '1', '2534', '2539');
INSERT INTO `t_areas` VALUES ('2540', '望谟县', '552300', '1', '2534', '2540');
INSERT INTO `t_areas` VALUES ('2541', '册亨县', '552200', '1', '2534', '2541');
INSERT INTO `t_areas` VALUES ('2542', '安龙县', '552400', '1', '2534', '2542');
INSERT INTO `t_areas` VALUES ('2543', '毕节地区', '551700', '1', '26', '2543');
INSERT INTO `t_areas` VALUES ('2544', '毕节市', '551700', '1', '2543', '2544');
INSERT INTO `t_areas` VALUES ('2545', '大方县', '551600', '1', '2543', '2545');
INSERT INTO `t_areas` VALUES ('2546', '黔西县', '551500', '1', '2543', '2546');
INSERT INTO `t_areas` VALUES ('2547', '金沙县', '551800', '1', '2543', '2547');
INSERT INTO `t_areas` VALUES ('2548', '织金县', '552100', '1', '2543', '2548');
INSERT INTO `t_areas` VALUES ('2549', '纳雍县', '553300', '1', '2543', '2549');
INSERT INTO `t_areas` VALUES ('2550', '威宁彝族回族苗族自治县', '553100', '1', '2543', '2550');
INSERT INTO `t_areas` VALUES ('2551', '赫章县', '553200', '1', '2543', '2551');
INSERT INTO `t_areas` VALUES ('2552', '黔东南苗族侗族自治州', '556000', '1', '26', '2552');
INSERT INTO `t_areas` VALUES ('2553', '凯里市', '556000', '1', '2552', '2553');
INSERT INTO `t_areas` VALUES ('2554', '黄平县', '556100', '1', '2552', '2554');
INSERT INTO `t_areas` VALUES ('2555', '施秉县', '556200', '1', '2552', '2555');
INSERT INTO `t_areas` VALUES ('2556', '三穗县', '556500', '1', '2552', '2556');
INSERT INTO `t_areas` VALUES ('2557', '镇远县', '557700', '1', '2552', '2557');
INSERT INTO `t_areas` VALUES ('2558', '岑巩县', '557800', '1', '2552', '2558');
INSERT INTO `t_areas` VALUES ('2559', '天柱县', '556600', '1', '2552', '2559');
INSERT INTO `t_areas` VALUES ('2560', '锦屏县', '556700', '1', '2552', '2560');
INSERT INTO `t_areas` VALUES ('2561', '剑河县', '556400', '1', '2552', '2561');
INSERT INTO `t_areas` VALUES ('2562', '台江县', '556300', '1', '2552', '2562');
INSERT INTO `t_areas` VALUES ('2563', '黎平县', '557300', '1', '2552', '2563');
INSERT INTO `t_areas` VALUES ('2564', '榕江县', '557200', '1', '2552', '2564');
INSERT INTO `t_areas` VALUES ('2565', '从江县', '557400', '1', '2552', '2565');
INSERT INTO `t_areas` VALUES ('2566', '雷山县', '557100', '1', '2552', '2566');
INSERT INTO `t_areas` VALUES ('2567', '麻江县', '557600', '1', '2552', '2567');
INSERT INTO `t_areas` VALUES ('2568', '丹寨县', '557500', '1', '2552', '2568');
INSERT INTO `t_areas` VALUES ('2569', '黔南布依族苗族自治州', '558000', '1', '26', '2569');
INSERT INTO `t_areas` VALUES ('2570', '都匀市', '558000', '1', '2569', '2570');
INSERT INTO `t_areas` VALUES ('2571', '福泉市', '550500', '1', '2569', '2571');
INSERT INTO `t_areas` VALUES ('2572', '荔波县', '558400', '1', '2569', '2572');
INSERT INTO `t_areas` VALUES ('2573', '贵定县', '551300', '1', '2569', '2573');
INSERT INTO `t_areas` VALUES ('2574', '瓮安县', '550400', '1', '2569', '2574');
INSERT INTO `t_areas` VALUES ('2575', '独山县', '558200', '1', '2569', '2575');
INSERT INTO `t_areas` VALUES ('2576', '平塘县', '558300', '1', '2569', '2576');
INSERT INTO `t_areas` VALUES ('2577', '罗甸县', '550100', '1', '2569', '2577');
INSERT INTO `t_areas` VALUES ('2578', '长顺县', '550700', '1', '2569', '2578');
INSERT INTO `t_areas` VALUES ('2579', '龙里县', '551200', '1', '2569', '2579');
INSERT INTO `t_areas` VALUES ('2580', '惠水县', '550600', '1', '2569', '2580');
INSERT INTO `t_areas` VALUES ('2581', '三都水族自治县', '558100', '1', '2569', '2581');
INSERT INTO `t_areas` VALUES ('2582', '昆明市', '650000', '1', '27', '2582');
INSERT INTO `t_areas` VALUES ('2583', '五华区', '650000', '1', '2582', '2583');
INSERT INTO `t_areas` VALUES ('2584', '盘龙区', '650000', '1', '2582', '2584');
INSERT INTO `t_areas` VALUES ('2585', '官渡区', '650200', '1', '2582', '2585');
INSERT INTO `t_areas` VALUES ('2586', '西山区', '650100', '1', '2582', '2586');
INSERT INTO `t_areas` VALUES ('2587', '东川区', '654100', '1', '2582', '2587');
INSERT INTO `t_areas` VALUES ('2588', '呈贡县', '650500', '1', '2582', '2588');
INSERT INTO `t_areas` VALUES ('2589', '晋宁县', '650600', '1', '2582', '2589');
INSERT INTO `t_areas` VALUES ('2590', '富民县', '650400', '1', '2582', '2590');
INSERT INTO `t_areas` VALUES ('2591', '宜良县', '652100', '1', '2582', '2591');
INSERT INTO `t_areas` VALUES ('2592', '石林彝族自治县', '652200', '1', '2582', '2592');
INSERT INTO `t_areas` VALUES ('2593', '嵩明县', '651700', '1', '2582', '2593');
INSERT INTO `t_areas` VALUES ('2594', '禄劝彝族苗族自治县', '651500', '1', '2582', '2594');
INSERT INTO `t_areas` VALUES ('2595', '寻甸回族彝族自治县', '655200', '1', '2582', '2595');
INSERT INTO `t_areas` VALUES ('2596', '安宁市', '650300', '1', '2582', '2596');
INSERT INTO `t_areas` VALUES ('2597', '曲靖市', '655000', '1', '27', '2597');
INSERT INTO `t_areas` VALUES ('2598', '麒麟区', '655000', '1', '2597', '2598');
INSERT INTO `t_areas` VALUES ('2599', '马龙县', '655100', '1', '2597', '2599');
INSERT INTO `t_areas` VALUES ('2600', '陆良县', '655600', '1', '2597', '2600');
INSERT INTO `t_areas` VALUES ('2601', '师宗县', '655700', '1', '2597', '2601');
INSERT INTO `t_areas` VALUES ('2602', '罗平县', '655800', '1', '2597', '2602');
INSERT INTO `t_areas` VALUES ('2603', '富源县', '655500', '1', '2597', '2603');
INSERT INTO `t_areas` VALUES ('2604', '会泽县', '654200', '1', '2597', '2604');
INSERT INTO `t_areas` VALUES ('2605', '沾益县', '655500', '1', '2597', '2605');
INSERT INTO `t_areas` VALUES ('2606', '宣威市', '655400', '1', '2597', '2606');
INSERT INTO `t_areas` VALUES ('2607', '玉溪市', '653100', '1', '27', '2607');
INSERT INTO `t_areas` VALUES ('2608', '红塔区', '653100', '1', '2607', '2608');
INSERT INTO `t_areas` VALUES ('2609', '江川县', '652600', '1', '2607', '2609');
INSERT INTO `t_areas` VALUES ('2610', '澄江县', '652500', '1', '2607', '2610');
INSERT INTO `t_areas` VALUES ('2611', '通海县', '652700', '1', '2607', '2611');
INSERT INTO `t_areas` VALUES ('2612', '华宁县', '652800', '1', '2607', '2612');
INSERT INTO `t_areas` VALUES ('2613', '易门县', '651100', '1', '2607', '2613');
INSERT INTO `t_areas` VALUES ('2614', '峨山彝族自治县', '653200', '1', '2607', '2614');
INSERT INTO `t_areas` VALUES ('2615', '新平彝族傣族自治县', '653400', '1', '2607', '2615');
INSERT INTO `t_areas` VALUES ('2616', '元江哈尼族彝族傣族自治县', '653300', '1', '2607', '2616');
INSERT INTO `t_areas` VALUES ('2617', '保山市', '678000', '1', '27', '2617');
INSERT INTO `t_areas` VALUES ('2618', '隆阳区', '678000', '1', '2617', '2618');
INSERT INTO `t_areas` VALUES ('2619', '施甸县', '678200', '1', '2617', '2619');
INSERT INTO `t_areas` VALUES ('2620', '腾冲县', '679100', '1', '2617', '2620');
INSERT INTO `t_areas` VALUES ('2621', '龙陵县', '678300', '1', '2617', '2621');
INSERT INTO `t_areas` VALUES ('2622', '昌宁县', '678100', '1', '2617', '2622');
INSERT INTO `t_areas` VALUES ('2623', '昭通市', '657000', '1', '27', '2623');
INSERT INTO `t_areas` VALUES ('2624', '昭阳区', '657000', '1', '2623', '2624');
INSERT INTO `t_areas` VALUES ('2625', '鲁甸县', '657100', '1', '2623', '2625');
INSERT INTO `t_areas` VALUES ('2626', '巧家县', '654600', '1', '2623', '2626');
INSERT INTO `t_areas` VALUES ('2627', '盐津县', '657500', '1', '2623', '2627');
INSERT INTO `t_areas` VALUES ('2628', '大关县', '657400', '1', '2623', '2628');
INSERT INTO `t_areas` VALUES ('2629', '永善县', '657300', '1', '2623', '2629');
INSERT INTO `t_areas` VALUES ('2630', '绥江县', '657700', '1', '2623', '2630');
INSERT INTO `t_areas` VALUES ('2631', '镇雄县', '657200', '1', '2623', '2631');
INSERT INTO `t_areas` VALUES ('2632', '彝良县', '657600', '1', '2623', '2632');
INSERT INTO `t_areas` VALUES ('2633', '威信县', '657900', '1', '2623', '2633');
INSERT INTO `t_areas` VALUES ('2634', '水富县', '657800', '1', '2623', '2634');
INSERT INTO `t_areas` VALUES ('2635', '丽江市', '674100', '1', '27', '2635');
INSERT INTO `t_areas` VALUES ('2636', '古城区', '674100', '1', '2635', '2636');
INSERT INTO `t_areas` VALUES ('2637', '玉龙纳西族自治县', '674100', '1', '2635', '2637');
INSERT INTO `t_areas` VALUES ('2638', '永胜县', '674200', '1', '2635', '2638');
INSERT INTO `t_areas` VALUES ('2639', '华坪县', '674800', '1', '2635', '2639');
INSERT INTO `t_areas` VALUES ('2640', '宁蒗彝族自治县', '674300', '1', '2635', '2640');
INSERT INTO `t_areas` VALUES ('2641', '普洱市', '665000', '1', '27', '2641');
INSERT INTO `t_areas` VALUES ('2642', '思茅区', '665000', '1', '2641', '2642');
INSERT INTO `t_areas` VALUES ('2643', '宁洱哈尼族彝族自治县', '665100', '1', '2641', '2643');
INSERT INTO `t_areas` VALUES ('2644', '墨江哈尼族自治县', '654800', '1', '2641', '2644');
INSERT INTO `t_areas` VALUES ('2645', '景东彝族自治县', '676200', '1', '2641', '2645');
INSERT INTO `t_areas` VALUES ('2646', '景谷傣族彝族自治县', '666400', '1', '2641', '2646');
INSERT INTO `t_areas` VALUES ('2647', '镇沅彝族哈尼族拉祜族自治县', '666500', '1', '2641', '2647');
INSERT INTO `t_areas` VALUES ('2648', '江城哈尼族彝族自治县', '665900', '1', '2641', '2648');
INSERT INTO `t_areas` VALUES ('2649', '孟连傣族拉祜族佤族自治县', '665800', '1', '2641', '2649');
INSERT INTO `t_areas` VALUES ('2650', '澜沧拉祜族自治县', '665600', '1', '2641', '2650');
INSERT INTO `t_areas` VALUES ('2651', '西盟佤族自治县', '665700', '1', '2641', '2651');
INSERT INTO `t_areas` VALUES ('2652', '临沧市', '677000', '1', '27', '2652');
INSERT INTO `t_areas` VALUES ('2653', '临翔区', '677000', '1', '2652', '2653');
INSERT INTO `t_areas` VALUES ('2654', '凤庆县', '675900', '1', '2652', '2654');
INSERT INTO `t_areas` VALUES ('2655', '云县', '675800', '1', '2652', '2655');
INSERT INTO `t_areas` VALUES ('2656', '永德县', '677600', '1', '2652', '2656');
INSERT INTO `t_areas` VALUES ('2657', '镇康县', '677700', '1', '2652', '2657');
INSERT INTO `t_areas` VALUES ('2658', '双江拉祜族佤族布朗族傣族自治县', '677300', '1', '2652', '2658');
INSERT INTO `t_areas` VALUES ('2659', '耿马傣族佤族自治县', '677500', '1', '2652', '2659');
INSERT INTO `t_areas` VALUES ('2660', '沧源佤族自治县', '677400', '1', '2652', '2660');
INSERT INTO `t_areas` VALUES ('2661', '楚雄彝族自治州', '675000', '1', '27', '2661');
INSERT INTO `t_areas` VALUES ('2662', '楚雄市', '675000', '1', '2661', '2662');
INSERT INTO `t_areas` VALUES ('2663', '双柏县', '675100', '1', '2661', '2663');
INSERT INTO `t_areas` VALUES ('2664', '牟定县', '675500', '1', '2661', '2664');
INSERT INTO `t_areas` VALUES ('2665', '南华县', '675200', '1', '2661', '2665');
INSERT INTO `t_areas` VALUES ('2666', '姚安县', '675300', '1', '2661', '2666');
INSERT INTO `t_areas` VALUES ('2667', '大姚县', '675400', '1', '2661', '2667');
INSERT INTO `t_areas` VALUES ('2668', '永仁县', '651400', '1', '2661', '2668');
INSERT INTO `t_areas` VALUES ('2669', '元谋县', '651300', '1', '2661', '2669');
INSERT INTO `t_areas` VALUES ('2670', '武定县', '651600', '1', '2661', '2670');
INSERT INTO `t_areas` VALUES ('2671', '禄丰县', '651200', '1', '2661', '2671');
INSERT INTO `t_areas` VALUES ('2672', '红河哈尼族彝族自治州', '661400', '1', '27', '2672');
INSERT INTO `t_areas` VALUES ('2673', '个旧市', '661000', '1', '2672', '2673');
INSERT INTO `t_areas` VALUES ('2674', '开远市', '661600', '1', '2672', '2674');
INSERT INTO `t_areas` VALUES ('2675', '蒙自县', '661100', '1', '2672', '2675');
INSERT INTO `t_areas` VALUES ('2676', '屏边苗族自治县', '661200', '1', '2672', '2676');
INSERT INTO `t_areas` VALUES ('2677', '建水县', '654300', '1', '2672', '2677');
INSERT INTO `t_areas` VALUES ('2678', '石屏县', '662200', '1', '2672', '2678');
INSERT INTO `t_areas` VALUES ('2679', '弥勒县', '652300', '1', '2672', '2679');
INSERT INTO `t_areas` VALUES ('2680', '泸西县', '652400', '1', '2672', '2680');
INSERT INTO `t_areas` VALUES ('2681', '元阳县', '662400', '1', '2672', '2681');
INSERT INTO `t_areas` VALUES ('2682', '红河县', '654400', '1', '2672', '2682');
INSERT INTO `t_areas` VALUES ('2683', '金平苗族瑶族傣族自治县', '661500', '1', '2672', '2683');
INSERT INTO `t_areas` VALUES ('2684', '绿春县', '662500', '1', '2672', '2684');
INSERT INTO `t_areas` VALUES ('2685', '河口瑶族自治县', '661300', '1', '2672', '2685');
INSERT INTO `t_areas` VALUES ('2686', '文山壮族苗族自治州', '663000', '1', '27', '2686');
INSERT INTO `t_areas` VALUES ('2687', '文山县', '663000', '1', '2686', '2687');
INSERT INTO `t_areas` VALUES ('2688', '砚山县', '663100', '1', '2686', '2688');
INSERT INTO `t_areas` VALUES ('2689', '西畴县', '663500', '1', '2686', '2689');
INSERT INTO `t_areas` VALUES ('2690', '麻栗坡县', '663600', '1', '2686', '2690');
INSERT INTO `t_areas` VALUES ('2691', '马关县', '663700', '1', '2686', '2691');
INSERT INTO `t_areas` VALUES ('2692', '丘北县', '663200', '1', '2686', '2692');
INSERT INTO `t_areas` VALUES ('2693', '广南县', '663300', '1', '2686', '2693');
INSERT INTO `t_areas` VALUES ('2694', '富宁县', '663400', '1', '2686', '2694');
INSERT INTO `t_areas` VALUES ('2695', '西双版纳傣族自治州', '666100', '1', '27', '2695');
INSERT INTO `t_areas` VALUES ('2696', '景洪市', '666100', '1', '2695', '2696');
INSERT INTO `t_areas` VALUES ('2697', '勐海县', '666200', '1', '2695', '2697');
INSERT INTO `t_areas` VALUES ('2698', '勐腊县', '666300', '1', '2695', '2698');
INSERT INTO `t_areas` VALUES ('2699', '大理白族自治州', '671000', '1', '27', '2699');
INSERT INTO `t_areas` VALUES ('2700', '大理市', '671000', '1', '2699', '2700');
INSERT INTO `t_areas` VALUES ('2701', '漾濞彝族自治县', '672500', '1', '2699', '2701');
INSERT INTO `t_areas` VALUES ('2702', '祥云县', '672100', '1', '2699', '2702');
INSERT INTO `t_areas` VALUES ('2703', '宾川县', '671600', '1', '2699', '2703');
INSERT INTO `t_areas` VALUES ('2704', '弥渡县', '675600', '1', '2699', '2704');
INSERT INTO `t_areas` VALUES ('2705', '南涧彝族自治县', '675700', '1', '2699', '2705');
INSERT INTO `t_areas` VALUES ('2706', '巍山彝族回族自治县', '672400', '1', '2699', '2706');
INSERT INTO `t_areas` VALUES ('2707', '永平县', '672600', '1', '2699', '2707');
INSERT INTO `t_areas` VALUES ('2708', '云龙县', '672700', '1', '2699', '2708');
INSERT INTO `t_areas` VALUES ('2709', '洱源县', '671200', '1', '2699', '2709');
INSERT INTO `t_areas` VALUES ('2710', '剑川县', '671300', '1', '2699', '2710');
INSERT INTO `t_areas` VALUES ('2711', '鹤庆县', '671500', '1', '2699', '2711');
INSERT INTO `t_areas` VALUES ('2712', '德宏傣族景颇族自治州', '678400', '1', '27', '2712');
INSERT INTO `t_areas` VALUES ('2713', '瑞丽市', '678600', '1', '2712', '2713');
INSERT INTO `t_areas` VALUES ('2714', '潞西市', '678400', '1', '2712', '2714');
INSERT INTO `t_areas` VALUES ('2715', '梁河县', '679200', '1', '2712', '2715');
INSERT INTO `t_areas` VALUES ('2716', '盈江县', '679300', '1', '2712', '2716');
INSERT INTO `t_areas` VALUES ('2717', '陇川县', '678700', '1', '2712', '2717');
INSERT INTO `t_areas` VALUES ('2718', '怒江傈僳族自治州', '673200', '1', '27', '2718');
INSERT INTO `t_areas` VALUES ('2719', '泸水县', '673200', '1', '2718', '2719');
INSERT INTO `t_areas` VALUES ('2720', '福贡县', '673400', '1', '2718', '2720');
INSERT INTO `t_areas` VALUES ('2721', '贡山独龙族怒族自治县', '673500', '1', '2718', '2721');
INSERT INTO `t_areas` VALUES ('2722', '兰坪白族普米族自治县', '671400', '1', '2718', '2722');
INSERT INTO `t_areas` VALUES ('2723', '迪庆藏族自治州', '674400', '1', '27', '2723');
INSERT INTO `t_areas` VALUES ('2724', '香格里拉县', '674400', '1', '2723', '2724');
INSERT INTO `t_areas` VALUES ('2725', '德钦县', '674500', '1', '2723', '2725');
INSERT INTO `t_areas` VALUES ('2726', '维西傈僳族自治县', '674600', '1', '2723', '2726');
INSERT INTO `t_areas` VALUES ('2727', '拉萨市', '850000', '1', '28', '2727');
INSERT INTO `t_areas` VALUES ('2728', '城关区', '850000', '1', '2727', '2728');
INSERT INTO `t_areas` VALUES ('2729', '林周县', '851600', '1', '2727', '2729');
INSERT INTO `t_areas` VALUES ('2730', '当雄县', '851500', '1', '2727', '2730');
INSERT INTO `t_areas` VALUES ('2731', '尼木县', '851600', '1', '2727', '2731');
INSERT INTO `t_areas` VALUES ('2732', '曲水县', '850600', '1', '2727', '2732');
INSERT INTO `t_areas` VALUES ('2733', '堆龙德庆县', '851400', '1', '2727', '2733');
INSERT INTO `t_areas` VALUES ('2734', '达孜县', '850100', '1', '2727', '2734');
INSERT INTO `t_areas` VALUES ('2735', '墨竹工卡县', '850200', '1', '2727', '2735');
INSERT INTO `t_areas` VALUES ('2736', '昌都地区', '854000', '1', '28', '2736');
INSERT INTO `t_areas` VALUES ('2737', '昌都县', '854000', '1', '2736', '2737');
INSERT INTO `t_areas` VALUES ('2738', '江达县', '854100', '1', '2736', '2738');
INSERT INTO `t_areas` VALUES ('2739', '贡觉县', '854200', '1', '2736', '2739');
INSERT INTO `t_areas` VALUES ('2740', '类乌齐县', '855600', '1', '2736', '2740');
INSERT INTO `t_areas` VALUES ('2741', '丁青县', '855700', '1', '2736', '2741');
INSERT INTO `t_areas` VALUES ('2742', '察雅县', '854300', '1', '2736', '2742');
INSERT INTO `t_areas` VALUES ('2743', '八宿县', '854600', '1', '2736', '2743');
INSERT INTO `t_areas` VALUES ('2744', '左贡县', '854400', '1', '2736', '2744');
INSERT INTO `t_areas` VALUES ('2745', '芒康县', '854500', '1', '2736', '2745');
INSERT INTO `t_areas` VALUES ('2746', '洛隆县', '855400', '1', '2736', '2746');
INSERT INTO `t_areas` VALUES ('2747', '边坝县', '855500', '1', '2736', '2747');
INSERT INTO `t_areas` VALUES ('2748', '山南地区', '856000', '1', '28', '2748');
INSERT INTO `t_areas` VALUES ('2749', '乃东县', '856100', '1', '2748', '2749');
INSERT INTO `t_areas` VALUES ('2750', '扎囊县', '850800', '1', '2748', '2750');
INSERT INTO `t_areas` VALUES ('2751', '贡嘎县', '850700', '1', '2748', '2751');
INSERT INTO `t_areas` VALUES ('2752', '桑日县', '856200', '1', '2748', '2752');
INSERT INTO `t_areas` VALUES ('2753', '琼结县', '856800', '1', '2748', '2753');
INSERT INTO `t_areas` VALUES ('2754', '曲松县', '856300', '1', '2748', '2754');
INSERT INTO `t_areas` VALUES ('2755', '措美县', '856900', '1', '2748', '2755');
INSERT INTO `t_areas` VALUES ('2756', '洛扎县', '851200', '1', '2748', '2756');
INSERT INTO `t_areas` VALUES ('2757', '加查县', '856400', '1', '2748', '2757');
INSERT INTO `t_areas` VALUES ('2758', '隆子县', '856600', '1', '2748', '2758');
INSERT INTO `t_areas` VALUES ('2759', '错那县', '856700', '1', '2748', '2759');
INSERT INTO `t_areas` VALUES ('2760', '浪卡子县', '851100', '1', '2748', '2760');
INSERT INTO `t_areas` VALUES ('2761', '日喀则地区', '857000', '1', '28', '2761');
INSERT INTO `t_areas` VALUES ('2762', '日喀则市', '857000', '1', '2761', '2762');
INSERT INTO `t_areas` VALUES ('2763', '南木林县', '857100', '1', '2761', '2763');
INSERT INTO `t_areas` VALUES ('2764', '江孜县', '857400', '1', '2761', '2764');
INSERT INTO `t_areas` VALUES ('2765', '定日县', '858200', '1', '2761', '2765');
INSERT INTO `t_areas` VALUES ('2766', '萨迦县', '857800', '1', '2761', '2766');
INSERT INTO `t_areas` VALUES ('2767', '拉孜县', '858100', '1', '2761', '2767');
INSERT INTO `t_areas` VALUES ('2768', '昂仁县', '858500', '1', '2761', '2768');
INSERT INTO `t_areas` VALUES ('2769', '谢通门县', '858900', '1', '2761', '2769');
INSERT INTO `t_areas` VALUES ('2770', '白朗县', '857300', '1', '2761', '2770');
INSERT INTO `t_areas` VALUES ('2771', '仁布县', '857200', '1', '2761', '2771');
INSERT INTO `t_areas` VALUES ('2772', '康马县', '857500', '1', '2761', '2772');
INSERT INTO `t_areas` VALUES ('2773', '定结县', '857900', '1', '2761', '2773');
INSERT INTO `t_areas` VALUES ('2774', '仲巴县', '858800', '1', '2761', '2774');
INSERT INTO `t_areas` VALUES ('2775', '亚东县', '857600', '1', '2761', '2775');
INSERT INTO `t_areas` VALUES ('2776', '吉隆县', '858700', '1', '2761', '2776');
INSERT INTO `t_areas` VALUES ('2777', '聂拉木县', '858300', '1', '2761', '2777');
INSERT INTO `t_areas` VALUES ('2778', '萨嘎县', '858600', '1', '2761', '2778');
INSERT INTO `t_areas` VALUES ('2779', '岗巴县', '857700', '1', '2761', '2779');
INSERT INTO `t_areas` VALUES ('2780', '那曲地区', '852000', '1', '28', '2780');
INSERT INTO `t_areas` VALUES ('2781', '那曲县', '852000', '1', '2780', '2781');
INSERT INTO `t_areas` VALUES ('2782', '嘉黎县', '852400', '1', '2780', '2782');
INSERT INTO `t_areas` VALUES ('2783', '比如县', '852300', '1', '2780', '2783');
INSERT INTO `t_areas` VALUES ('2784', '聂荣县', '853500', '1', '2780', '2784');
INSERT INTO `t_areas` VALUES ('2785', '安多县', '853400', '1', '2780', '2785');
INSERT INTO `t_areas` VALUES ('2786', '申扎县', '853100', '1', '2780', '2786');
INSERT INTO `t_areas` VALUES ('2787', '索县', '852200', '1', '2780', '2787');
INSERT INTO `t_areas` VALUES ('2788', '班戈县', '852500', '1', '2780', '2788');
INSERT INTO `t_areas` VALUES ('2789', '巴青县', '852100', '1', '2780', '2789');
INSERT INTO `t_areas` VALUES ('2790', '尼玛县', '853200', '1', '2780', '2790');
INSERT INTO `t_areas` VALUES ('2791', '阿里地区', '859000', '1', '28', '2791');
INSERT INTO `t_areas` VALUES ('2792', '普兰县', '859500', '1', '2791', '2792');
INSERT INTO `t_areas` VALUES ('2793', '札达县', '859600', '1', '2791', '2793');
INSERT INTO `t_areas` VALUES ('2794', '噶尔县', '859000', '1', '2791', '2794');
INSERT INTO `t_areas` VALUES ('2795', '日土县', '859700', '1', '2791', '2795');
INSERT INTO `t_areas` VALUES ('2796', '革吉县', '859100', '1', '2791', '2796');
INSERT INTO `t_areas` VALUES ('2797', '改则县', '859200', '1', '2791', '2797');
INSERT INTO `t_areas` VALUES ('2798', '措勤县', '859300', '1', '2791', '2798');
INSERT INTO `t_areas` VALUES ('2799', '林芝地区', '860000', '1', '28', '2799');
INSERT INTO `t_areas` VALUES ('2800', '林芝县', '860100', '1', '2799', '2800');
INSERT INTO `t_areas` VALUES ('2801', '工布江达县', '860200', '1', '2799', '2801');
INSERT INTO `t_areas` VALUES ('2802', '米林县', '860500', '1', '2799', '2802');
INSERT INTO `t_areas` VALUES ('2803', '墨脱县', '860700', '1', '2799', '2803');
INSERT INTO `t_areas` VALUES ('2804', '波密县', '860300', '1', '2799', '2804');
INSERT INTO `t_areas` VALUES ('2805', '察隅县', '860600', '1', '2799', '2805');
INSERT INTO `t_areas` VALUES ('2806', '朗县', '860400', '1', '2799', '2806');
INSERT INTO `t_areas` VALUES ('2807', '西安市', '710000', '1', '29', '2807');
INSERT INTO `t_areas` VALUES ('2808', '新城区', '710000', '1', '2807', '2808');
INSERT INTO `t_areas` VALUES ('2809', '碑林区', '710000', '1', '2807', '2809');
INSERT INTO `t_areas` VALUES ('2810', '莲湖区', '710000', '1', '2807', '2810');
INSERT INTO `t_areas` VALUES ('2811', '灞桥区', '710000', '1', '2807', '2811');
INSERT INTO `t_areas` VALUES ('2812', '未央区', '710000', '1', '2807', '2812');
INSERT INTO `t_areas` VALUES ('2813', '雁塔区', '710000', '1', '2807', '2813');
INSERT INTO `t_areas` VALUES ('2814', '阎良区', '710000', '1', '2807', '2814');
INSERT INTO `t_areas` VALUES ('2815', '临潼区', '710600', '1', '2807', '2815');
INSERT INTO `t_areas` VALUES ('2816', '长安区', '710100', '1', '2807', '2816');
INSERT INTO `t_areas` VALUES ('2817', '蓝田县', '710500', '1', '2807', '2817');
INSERT INTO `t_areas` VALUES ('2818', '周至县', '710400', '1', '2807', '2818');
INSERT INTO `t_areas` VALUES ('2819', '户县', '710300', '1', '2807', '2819');
INSERT INTO `t_areas` VALUES ('2820', '高陵县', '710200', '1', '2807', '2820');
INSERT INTO `t_areas` VALUES ('2821', '铜川市', '727000', '1', '29', '2821');
INSERT INTO `t_areas` VALUES ('2822', '王益区', '727000', '1', '2821', '2822');
INSERT INTO `t_areas` VALUES ('2823', '印台区', '727000', '1', '2821', '2823');
INSERT INTO `t_areas` VALUES ('2824', '耀州区', '727100', '1', '2821', '2824');
INSERT INTO `t_areas` VALUES ('2825', '宜君县', '727200', '1', '2821', '2825');
INSERT INTO `t_areas` VALUES ('2826', '宝鸡市', '721000', '1', '29', '2826');
INSERT INTO `t_areas` VALUES ('2827', '渭滨区', '721000', '1', '2826', '2827');
INSERT INTO `t_areas` VALUES ('2828', '金台区', '721000', '1', '2826', '2828');
INSERT INTO `t_areas` VALUES ('2829', '陈仓区', '721300', '1', '2826', '2829');
INSERT INTO `t_areas` VALUES ('2830', '凤翔县', '721400', '1', '2826', '2830');
INSERT INTO `t_areas` VALUES ('2831', '岐山县', '722400', '1', '2826', '2831');
INSERT INTO `t_areas` VALUES ('2832', '扶风县', '722200', '1', '2826', '2832');
INSERT INTO `t_areas` VALUES ('2833', '眉县', '722300', '1', '2826', '2833');
INSERT INTO `t_areas` VALUES ('2834', '陇县', '721200', '1', '2826', '2834');
INSERT INTO `t_areas` VALUES ('2835', '千阳县', '721100', '1', '2826', '2835');
INSERT INTO `t_areas` VALUES ('2836', '麟游县', '721500', '1', '2826', '2836');
INSERT INTO `t_areas` VALUES ('2837', '凤县', '721700', '1', '2826', '2837');
INSERT INTO `t_areas` VALUES ('2838', '太白县', '721600', '1', '2826', '2838');
INSERT INTO `t_areas` VALUES ('2839', '咸阳市', '712000', '1', '29', '2839');
INSERT INTO `t_areas` VALUES ('2840', '秦都区', '712000', '1', '2839', '2840');
INSERT INTO `t_areas` VALUES ('2841', '杨凌区', '712000', '1', '2839', '2841');
INSERT INTO `t_areas` VALUES ('2842', '渭城区', '712000', '1', '2839', '2842');
INSERT INTO `t_areas` VALUES ('2843', '三原县', '713800', '1', '2839', '2843');
INSERT INTO `t_areas` VALUES ('2844', '泾阳县', '713700', '1', '2839', '2844');
INSERT INTO `t_areas` VALUES ('2845', '乾县', '713300', '1', '2839', '2845');
INSERT INTO `t_areas` VALUES ('2846', '礼泉县', '713200', '1', '2839', '2846');
INSERT INTO `t_areas` VALUES ('2847', '永寿县', '713400', '1', '2839', '2847');
INSERT INTO `t_areas` VALUES ('2848', '彬县', '713500', '1', '2839', '2848');
INSERT INTO `t_areas` VALUES ('2849', '长武县', '713600', '1', '2839', '2849');
INSERT INTO `t_areas` VALUES ('2850', '旬邑县', '711300', '1', '2839', '2850');
INSERT INTO `t_areas` VALUES ('2851', '淳化县', '711200', '1', '2839', '2851');
INSERT INTO `t_areas` VALUES ('2852', '武功县', '712200', '1', '2839', '2852');
INSERT INTO `t_areas` VALUES ('2853', '兴平市', '713100', '1', '2839', '2853');
INSERT INTO `t_areas` VALUES ('2854', '渭南市', '714000', '1', '29', '2854');
INSERT INTO `t_areas` VALUES ('2855', '临渭区', '714000', '1', '2854', '2855');
INSERT INTO `t_areas` VALUES ('2856', '华县', '714100', '1', '2854', '2856');
INSERT INTO `t_areas` VALUES ('2857', '潼关县', '714300', '1', '2854', '2857');
INSERT INTO `t_areas` VALUES ('2858', '大荔县', '715100', '1', '2854', '2858');
INSERT INTO `t_areas` VALUES ('2859', '合阳县', '715300', '1', '2854', '2859');
INSERT INTO `t_areas` VALUES ('2860', '澄城县', '715200', '1', '2854', '2860');
INSERT INTO `t_areas` VALUES ('2861', '蒲城县', '715500', '1', '2854', '2861');
INSERT INTO `t_areas` VALUES ('2862', '白水县', '715600', '1', '2854', '2862');
INSERT INTO `t_areas` VALUES ('2863', '富平县', '711700', '1', '2854', '2863');
INSERT INTO `t_areas` VALUES ('2864', '韩城市', '715400', '1', '2854', '2864');
INSERT INTO `t_areas` VALUES ('2865', '华阴市', '714200', '1', '2854', '2865');
INSERT INTO `t_areas` VALUES ('2866', '延安市', '716000', '1', '29', '2866');
INSERT INTO `t_areas` VALUES ('2867', '宝塔区', '716000', '1', '2866', '2867');
INSERT INTO `t_areas` VALUES ('2868', '延长县', '717100', '1', '2866', '2868');
INSERT INTO `t_areas` VALUES ('2869', '延川县', '717200', '1', '2866', '2869');
INSERT INTO `t_areas` VALUES ('2870', '子长县', '717300', '1', '2866', '2870');
INSERT INTO `t_areas` VALUES ('2871', '安塞县', '717400', '1', '2866', '2871');
INSERT INTO `t_areas` VALUES ('2872', '志丹县', '717500', '1', '2866', '2872');
INSERT INTO `t_areas` VALUES ('2873', '吴起县', '717600', '1', '2866', '2873');
INSERT INTO `t_areas` VALUES ('2874', '甘泉县', '716100', '1', '2866', '2874');
INSERT INTO `t_areas` VALUES ('2875', '富县', '727500', '1', '2866', '2875');
INSERT INTO `t_areas` VALUES ('2876', '洛川县', '727400', '1', '2866', '2876');
INSERT INTO `t_areas` VALUES ('2877', '宜川县', '716200', '1', '2866', '2877');
INSERT INTO `t_areas` VALUES ('2878', '黄龙县', '715700', '1', '2866', '2878');
INSERT INTO `t_areas` VALUES ('2879', '黄陵县', '727300', '1', '2866', '2879');
INSERT INTO `t_areas` VALUES ('2880', '汉中市', '723000', '1', '29', '2880');
INSERT INTO `t_areas` VALUES ('2881', '汉台区', '723000', '1', '2880', '2881');
INSERT INTO `t_areas` VALUES ('2882', '南郑县', '723100', '1', '2880', '2882');
INSERT INTO `t_areas` VALUES ('2883', '城固县', '723200', '1', '2880', '2883');
INSERT INTO `t_areas` VALUES ('2884', '洋县', '723300', '1', '2880', '2884');
INSERT INTO `t_areas` VALUES ('2885', '西乡县', '723500', '1', '2880', '2885');
INSERT INTO `t_areas` VALUES ('2886', '勉县', '724200', '1', '2880', '2886');
INSERT INTO `t_areas` VALUES ('2887', '宁强县', '724400', '1', '2880', '2887');
INSERT INTO `t_areas` VALUES ('2888', '略阳县', '724300', '1', '2880', '2888');
INSERT INTO `t_areas` VALUES ('2889', '镇巴县', '723600', '1', '2880', '2889');
INSERT INTO `t_areas` VALUES ('2890', '留坝县', '724100', '1', '2880', '2890');
INSERT INTO `t_areas` VALUES ('2891', '佛坪县', '723400', '1', '2880', '2891');
INSERT INTO `t_areas` VALUES ('2892', '榆林市', '719000', '1', '29', '2892');
INSERT INTO `t_areas` VALUES ('2893', '榆阳区', '719000', '1', '2892', '2893');
INSERT INTO `t_areas` VALUES ('2894', '神木县', '719300', '1', '2892', '2894');
INSERT INTO `t_areas` VALUES ('2895', '府谷县', '719400', '1', '2892', '2895');
INSERT INTO `t_areas` VALUES ('2896', '横山县', '719200', '1', '2892', '2896');
INSERT INTO `t_areas` VALUES ('2897', '靖边县', '718500', '1', '2892', '2897');
INSERT INTO `t_areas` VALUES ('2898', '定边县', '718600', '1', '2892', '2898');
INSERT INTO `t_areas` VALUES ('2899', '绥德县', '718000', '1', '2892', '2899');
INSERT INTO `t_areas` VALUES ('2900', '米脂县', '718100', '1', '2892', '2900');
INSERT INTO `t_areas` VALUES ('2901', '佳县', '719200', '1', '2892', '2901');
INSERT INTO `t_areas` VALUES ('2902', '吴堡县', '718200', '1', '2892', '2902');
INSERT INTO `t_areas` VALUES ('2903', '清涧县', '718300', '1', '2892', '2903');
INSERT INTO `t_areas` VALUES ('2904', '子洲县', '718400', '1', '2892', '2904');
INSERT INTO `t_areas` VALUES ('2905', '安康市', '725000', '1', '29', '2905');
INSERT INTO `t_areas` VALUES ('2906', '汉滨区', '725000', '1', '2905', '2906');
INSERT INTO `t_areas` VALUES ('2907', '汉阴县', '725100', '1', '2905', '2907');
INSERT INTO `t_areas` VALUES ('2908', '石泉县', '725200', '1', '2905', '2908');
INSERT INTO `t_areas` VALUES ('2909', '宁陕县', '711600', '1', '2905', '2909');
INSERT INTO `t_areas` VALUES ('2910', '紫阳县', '725300', '1', '2905', '2910');
INSERT INTO `t_areas` VALUES ('2911', '岚皋县', '725400', '1', '2905', '2911');
INSERT INTO `t_areas` VALUES ('2912', '平利县', '725500', '1', '2905', '2912');
INSERT INTO `t_areas` VALUES ('2913', '镇坪县', '725600', '1', '2905', '2913');
INSERT INTO `t_areas` VALUES ('2914', '旬阳县', '725700', '1', '2905', '2914');
INSERT INTO `t_areas` VALUES ('2915', '白河县', '725800', '1', '2905', '2915');
INSERT INTO `t_areas` VALUES ('2916', '商洛市', '726000', '1', '29', '2916');
INSERT INTO `t_areas` VALUES ('2917', '商州区', '726000', '1', '2916', '2917');
INSERT INTO `t_areas` VALUES ('2918', '洛南县', '726100', '1', '2916', '2918');
INSERT INTO `t_areas` VALUES ('2919', '丹凤县', '726200', '1', '2916', '2919');
INSERT INTO `t_areas` VALUES ('2920', '商南县', '726300', '1', '2916', '2920');
INSERT INTO `t_areas` VALUES ('2921', '山阳县', '726400', '1', '2916', '2921');
INSERT INTO `t_areas` VALUES ('2922', '镇安县', '711500', '1', '2916', '2922');
INSERT INTO `t_areas` VALUES ('2923', '柞水县', '711400', '1', '2916', '2923');
INSERT INTO `t_areas` VALUES ('2924', '兰州市', '730000', '1', '30', '2924');
INSERT INTO `t_areas` VALUES ('2925', '城关区', '730030', '1', '2924', '2925');
INSERT INTO `t_areas` VALUES ('2926', '七里河区', '730050', '1', '2924', '2926');
INSERT INTO `t_areas` VALUES ('2927', '西固区', '730060', '1', '2924', '2927');
INSERT INTO `t_areas` VALUES ('2928', '安宁区', '730070', '1', '2924', '2928');
INSERT INTO `t_areas` VALUES ('2929', '红古区', '730080', '1', '2924', '2929');
INSERT INTO `t_areas` VALUES ('2930', '永登县', '730300', '1', '2924', '2930');
INSERT INTO `t_areas` VALUES ('2931', '皋兰县', '730200', '1', '2924', '2931');
INSERT INTO `t_areas` VALUES ('2932', '榆中县', '730100', '1', '2924', '2932');
INSERT INTO `t_areas` VALUES ('2933', '嘉峪关市', '737100', '1', '30', '2933');
INSERT INTO `t_areas` VALUES ('2934', '金昌市', '737100', '1', '30', '2934');
INSERT INTO `t_areas` VALUES ('2935', '金川区', '737100', '1', '2934', '2935');
INSERT INTO `t_areas` VALUES ('2936', '永昌县', '737200', '1', '2934', '2936');
INSERT INTO `t_areas` VALUES ('2937', '白银市', '730900', '1', '30', '2937');
INSERT INTO `t_areas` VALUES ('2938', '白银区', '730900', '1', '2937', '2938');
INSERT INTO `t_areas` VALUES ('2939', '平川区', '730900', '1', '2937', '2939');
INSERT INTO `t_areas` VALUES ('2940', '靖远县', '730600', '1', '2937', '2940');
INSERT INTO `t_areas` VALUES ('2941', '会宁县', '730700', '1', '2937', '2941');
INSERT INTO `t_areas` VALUES ('2942', '景泰县', '730400', '1', '2937', '2942');
INSERT INTO `t_areas` VALUES ('2943', '天水市', '741000', '1', '30', '2943');
INSERT INTO `t_areas` VALUES ('2944', '秦州区', '741000', '1', '2943', '2944');
INSERT INTO `t_areas` VALUES ('2945', '麦积区', '741000', '1', '2943', '2945');
INSERT INTO `t_areas` VALUES ('2946', '清水县', '741400', '1', '2943', '2946');
INSERT INTO `t_areas` VALUES ('2947', '秦安县', '741600', '1', '2943', '2947');
INSERT INTO `t_areas` VALUES ('2948', '甘谷县', '741200', '1', '2943', '2948');
INSERT INTO `t_areas` VALUES ('2949', '武山县', '741300', '1', '2943', '2949');
INSERT INTO `t_areas` VALUES ('2950', '张家川回族自治县', '733000', '1', '2943', '2950');
INSERT INTO `t_areas` VALUES ('2951', '武威市', '733000', '1', '30', '2951');
INSERT INTO `t_areas` VALUES ('2952', '凉州区', '733000', '1', '2951', '2952');
INSERT INTO `t_areas` VALUES ('2953', '民勤县', '733300', '1', '2951', '2953');
INSERT INTO `t_areas` VALUES ('2954', '古浪县', '733100', '1', '2951', '2954');
INSERT INTO `t_areas` VALUES ('2955', '天祝藏族自治县', '733200', '1', '2951', '2955');
INSERT INTO `t_areas` VALUES ('2956', '张掖市', '734000', '1', '30', '2956');
INSERT INTO `t_areas` VALUES ('2957', '甘州区', '734000', '1', '2956', '2957');
INSERT INTO `t_areas` VALUES ('2958', '肃南裕固族自治县', '734400', '1', '2956', '2958');
INSERT INTO `t_areas` VALUES ('2959', '民乐县', '734500', '1', '2956', '2959');
INSERT INTO `t_areas` VALUES ('2960', '临泽县', '734200', '1', '2956', '2960');
INSERT INTO `t_areas` VALUES ('2961', '高台县', '734300', '1', '2956', '2961');
INSERT INTO `t_areas` VALUES ('2962', '山丹县', '734100', '1', '2956', '2962');
INSERT INTO `t_areas` VALUES ('2963', '平凉市', '744000', '1', '30', '2963');
INSERT INTO `t_areas` VALUES ('2964', '崆峒区', '744000', '1', '2963', '2964');
INSERT INTO `t_areas` VALUES ('2965', '泾川县', '744300', '1', '2963', '2965');
INSERT INTO `t_areas` VALUES ('2966', '灵台县', '744400', '1', '2963', '2966');
INSERT INTO `t_areas` VALUES ('2967', '崇信县', '744200', '1', '2963', '2967');
INSERT INTO `t_areas` VALUES ('2968', '华亭县', '744100', '1', '2963', '2968');
INSERT INTO `t_areas` VALUES ('2969', '庄浪县', '744600', '1', '2963', '2969');
INSERT INTO `t_areas` VALUES ('2970', '静宁县', '743400', '1', '2963', '2970');
INSERT INTO `t_areas` VALUES ('2971', '酒泉市', '735000', '1', '30', '2971');
INSERT INTO `t_areas` VALUES ('2972', '肃州区', '735000', '1', '2971', '2972');
INSERT INTO `t_areas` VALUES ('2973', '金塔县', '735300', '1', '2971', '2973');
INSERT INTO `t_areas` VALUES ('2974', '瓜州县', '736100', '1', '2971', '2974');
INSERT INTO `t_areas` VALUES ('2975', '肃北蒙古族自治县', '736300', '1', '2971', '2975');
INSERT INTO `t_areas` VALUES ('2976', '阿克塞哈萨克族自治县', '736400', '1', '2971', '2976');
INSERT INTO `t_areas` VALUES ('2977', '玉门市', '735200', '1', '2971', '2977');
INSERT INTO `t_areas` VALUES ('2978', '敦煌市', '736200', '1', '2971', '2978');
INSERT INTO `t_areas` VALUES ('2979', '庆阳市', '745000', '1', '30', '2979');
INSERT INTO `t_areas` VALUES ('2980', '西峰区', '745000', '1', '2979', '2980');
INSERT INTO `t_areas` VALUES ('2981', '庆城县', '745000', '1', '2979', '2981');
INSERT INTO `t_areas` VALUES ('2982', '环县', '745700', '1', '2979', '2982');
INSERT INTO `t_areas` VALUES ('2983', '华池县', '745600', '1', '2979', '2983');
INSERT INTO `t_areas` VALUES ('2984', '合水县', '745400', '1', '2979', '2984');
INSERT INTO `t_areas` VALUES ('2985', '正宁县', '745300', '1', '2979', '2985');
INSERT INTO `t_areas` VALUES ('2986', '宁县', '745200', '1', '2979', '2986');
INSERT INTO `t_areas` VALUES ('2987', '镇原县', '744500', '1', '2979', '2987');
INSERT INTO `t_areas` VALUES ('2988', '定西市', '743000', '1', '30', '2988');
INSERT INTO `t_areas` VALUES ('2989', '安定区', '743000', '1', '2988', '2989');
INSERT INTO `t_areas` VALUES ('2990', '通渭县', '743300', '1', '2988', '2990');
INSERT INTO `t_areas` VALUES ('2991', '陇西县', '748100', '1', '2988', '2991');
INSERT INTO `t_areas` VALUES ('2992', '渭源县', '748200', '1', '2988', '2992');
INSERT INTO `t_areas` VALUES ('2993', '临洮县', '730500', '1', '2988', '2993');
INSERT INTO `t_areas` VALUES ('2994', '漳县', '748300', '1', '2988', '2994');
INSERT INTO `t_areas` VALUES ('2995', '岷县', '748400', '1', '2988', '2995');
INSERT INTO `t_areas` VALUES ('2996', '陇南市', '746000', '1', '30', '2996');
INSERT INTO `t_areas` VALUES ('2997', '武都区', '746000', '1', '2996', '2997');
INSERT INTO `t_areas` VALUES ('2998', '成县', '742500', '1', '2996', '2998');
INSERT INTO `t_areas` VALUES ('2999', '文县', '746400', '1', '2996', '2999');
INSERT INTO `t_areas` VALUES ('3000', '宕昌县', '748500', '1', '2996', '3000');
INSERT INTO `t_areas` VALUES ('3001', '康县', '746500', '1', '2996', '3001');
INSERT INTO `t_areas` VALUES ('3002', '西和县', '742100', '1', '2996', '3002');
INSERT INTO `t_areas` VALUES ('3003', '礼县', '742200', '1', '2996', '3003');
INSERT INTO `t_areas` VALUES ('3004', '徽县', '742300', '1', '2996', '3004');
INSERT INTO `t_areas` VALUES ('3005', '两当县', '742400', '1', '2996', '3005');
INSERT INTO `t_areas` VALUES ('3006', '临夏回族自治州', '731100', '1', '30', '3006');
INSERT INTO `t_areas` VALUES ('3007', '临夏市', '731100', '1', '3006', '3007');
INSERT INTO `t_areas` VALUES ('3008', '临夏县', '731800', '1', '3006', '3008');
INSERT INTO `t_areas` VALUES ('3009', '康乐县', '731500', '1', '3006', '3009');
INSERT INTO `t_areas` VALUES ('3010', '永靖县', '731600', '1', '3006', '3010');
INSERT INTO `t_areas` VALUES ('3011', '广河县', '731300', '1', '3006', '3011');
INSERT INTO `t_areas` VALUES ('3012', '和政县', '731200', '1', '3006', '3012');
INSERT INTO `t_areas` VALUES ('3013', '东乡族自治县', '731400', '1', '3006', '3013');
INSERT INTO `t_areas` VALUES ('3014', '积石山保安族东乡族撒拉族自治县', '731700', '1', '3006', '3014');
INSERT INTO `t_areas` VALUES ('3015', '甘南藏族自治州', '747000', '1', '30', '3015');
INSERT INTO `t_areas` VALUES ('3016', '合作市', '747000', '1', '3015', '3016');
INSERT INTO `t_areas` VALUES ('3017', '临潭县', '747500', '1', '3015', '3017');
INSERT INTO `t_areas` VALUES ('3018', '卓尼县', '747600', '1', '3015', '3018');
INSERT INTO `t_areas` VALUES ('3019', '舟曲县', '746300', '1', '3015', '3019');
INSERT INTO `t_areas` VALUES ('3020', '迭部县', '747400', '1', '3015', '3020');
INSERT INTO `t_areas` VALUES ('3021', '玛曲县', '747300', '1', '3015', '3021');
INSERT INTO `t_areas` VALUES ('3022', '碌曲县', '747200', '1', '3015', '3022');
INSERT INTO `t_areas` VALUES ('3023', '夏河县', '747100', '1', '3015', '3023');
INSERT INTO `t_areas` VALUES ('3024', '西宁市', '810000', '1', '31', '3024');
INSERT INTO `t_areas` VALUES ('3025', '城东区', '810000', '1', '3024', '3025');
INSERT INTO `t_areas` VALUES ('3026', '城中区', '810000', '1', '3024', '3026');
INSERT INTO `t_areas` VALUES ('3027', '城西区', '810000', '1', '3024', '3027');
INSERT INTO `t_areas` VALUES ('3028', '城北区', '810000', '1', '3024', '3028');
INSERT INTO `t_areas` VALUES ('3029', '大通回族土族自治县', '810100', '1', '3024', '3029');
INSERT INTO `t_areas` VALUES ('3030', '湟中县', '811600', '1', '3024', '3030');
INSERT INTO `t_areas` VALUES ('3031', '湟源县', '812100', '1', '3024', '3031');
INSERT INTO `t_areas` VALUES ('3032', '海东地区', '810699', '1', '31', '3032');
INSERT INTO `t_areas` VALUES ('3033', '平安县', '810600', '1', '3032', '3033');
INSERT INTO `t_areas` VALUES ('3034', '民和回族土族自治县', '810800', '1', '3032', '3034');
INSERT INTO `t_areas` VALUES ('3035', '乐都县', '810700', '1', '3032', '3035');
INSERT INTO `t_areas` VALUES ('3036', '互助土族自治县', '810500', '1', '3032', '3036');
INSERT INTO `t_areas` VALUES ('3037', '化隆回族自治县', '810900', '1', '3032', '3037');
INSERT INTO `t_areas` VALUES ('3038', '循化撒拉族自治县', '811100', '1', '3032', '3038');
INSERT INTO `t_areas` VALUES ('3039', '海北藏族自治州', '812200', '1', '31', '3039');
INSERT INTO `t_areas` VALUES ('3040', '门源回族自治县', '810300', '1', '3039', '3040');
INSERT INTO `t_areas` VALUES ('3041', '祁连县', '810400', '1', '3039', '3041');
INSERT INTO `t_areas` VALUES ('3042', '海晏县', '812200', '1', '3039', '3042');
INSERT INTO `t_areas` VALUES ('3043', '刚察县', '812300', '1', '3039', '3043');
INSERT INTO `t_areas` VALUES ('3044', '黄南藏族自治州', '811300', '1', '31', '3044');
INSERT INTO `t_areas` VALUES ('3045', '同仁县', '811300', '1', '3044', '3045');
INSERT INTO `t_areas` VALUES ('3046', '尖扎县', '811200', '1', '3044', '3046');
INSERT INTO `t_areas` VALUES ('3047', '泽库县', '811400', '1', '3044', '3047');
INSERT INTO `t_areas` VALUES ('3048', '河南蒙古族自治县', '811500', '1', '3044', '3048');
INSERT INTO `t_areas` VALUES ('3049', '海南藏族自治州', '813000', '1', '31', '3049');
INSERT INTO `t_areas` VALUES ('3050', '共和县', '813000', '1', '3049', '3050');
INSERT INTO `t_areas` VALUES ('3051', '同德县', '813200', '1', '3049', '3051');
INSERT INTO `t_areas` VALUES ('3052', '贵德县', '811700', '1', '3049', '3052');
INSERT INTO `t_areas` VALUES ('3053', '兴海县', '813300', '1', '3049', '3053');
INSERT INTO `t_areas` VALUES ('3054', '贵南县', '813100', '1', '3049', '3054');
INSERT INTO `t_areas` VALUES ('3055', '果洛藏族自治州', '814000', '1', '31', '3055');
INSERT INTO `t_areas` VALUES ('3056', '玛沁县', '814000', '1', '3055', '3056');
INSERT INTO `t_areas` VALUES ('3057', '班玛县', '814300', '1', '3055', '3057');
INSERT INTO `t_areas` VALUES ('3058', '甘德县', '814100', '1', '3055', '3058');
INSERT INTO `t_areas` VALUES ('3059', '达日县', '814200', '1', '3055', '3059');
INSERT INTO `t_areas` VALUES ('3060', '久治县', '624700', '1', '3055', '3060');
INSERT INTO `t_areas` VALUES ('3061', '玛多县', '813500', '1', '3055', '3061');
INSERT INTO `t_areas` VALUES ('3062', '玉树藏族自治州', '815000', '1', '31', '3062');
INSERT INTO `t_areas` VALUES ('3063', '玉树县', '815000', '1', '3062', '3063');
INSERT INTO `t_areas` VALUES ('3064', '杂多县', '815300', '1', '3062', '3064');
INSERT INTO `t_areas` VALUES ('3065', '称多县', '815100', '1', '3062', '3065');
INSERT INTO `t_areas` VALUES ('3066', '治多县', '815400', '1', '3062', '3066');
INSERT INTO `t_areas` VALUES ('3067', '囊谦县', '815200', '1', '3062', '3067');
INSERT INTO `t_areas` VALUES ('3068', '曲麻莱县', '815500', '1', '3062', '3068');
INSERT INTO `t_areas` VALUES ('3069', '海西蒙古族藏族自治州', '817000', '1', '31', '3069');
INSERT INTO `t_areas` VALUES ('3070', '格尔木市', '816000', '1', '3069', '3070');
INSERT INTO `t_areas` VALUES ('3071', '德令哈市', '817000', '1', '3069', '3071');
INSERT INTO `t_areas` VALUES ('3072', '乌兰县', '817100', '1', '3069', '3072');
INSERT INTO `t_areas` VALUES ('3073', '都兰县', '816100', '1', '3069', '3073');
INSERT INTO `t_areas` VALUES ('3074', '天峻县', '817200', '1', '3069', '3074');
INSERT INTO `t_areas` VALUES ('3075', '宁夏回族自治区', '750000', '1', '32', '3075');
INSERT INTO `t_areas` VALUES ('3076', '灵武市', '751400', '1', '32', '3076');
INSERT INTO `t_areas` VALUES ('3077', '平罗县', '753400', '1', '32', '3077');
INSERT INTO `t_areas` VALUES ('3078', '青铜峡市', '751600', '1', '32', '3078');
INSERT INTO `t_areas` VALUES ('3079', '彭阳县', '756500', '1', '32', '3079');
INSERT INTO `t_areas` VALUES ('3080', '乌鲁木齐市', '830000', '1', '33', '3080');
INSERT INTO `t_areas` VALUES ('3081', '天山区', '830000', '1', '3080', '3081');
INSERT INTO `t_areas` VALUES ('3082', '沙依巴克区', '830000', '1', '3080', '3082');
INSERT INTO `t_areas` VALUES ('3083', '新市区', '830000', '1', '3080', '3083');
INSERT INTO `t_areas` VALUES ('3084', '水磨沟区', '830000', '1', '3080', '3084');
INSERT INTO `t_areas` VALUES ('3085', '头屯河区', '830000', '1', '3080', '3085');
INSERT INTO `t_areas` VALUES ('3086', '达坂城区', '830000', '1', '3080', '3086');
INSERT INTO `t_areas` VALUES ('3087', '米东区', '831400', '1', '3080', '3087');
INSERT INTO `t_areas` VALUES ('3088', '乌鲁木齐县', '830000', '1', '3080', '3088');
INSERT INTO `t_areas` VALUES ('3089', '克拉玛依市', '834000', '1', '33', '3089');
INSERT INTO `t_areas` VALUES ('3090', '独山子区', '838600', '1', '3089', '3090');
INSERT INTO `t_areas` VALUES ('3091', '克拉玛依区', '834000', '1', '3089', '3091');
INSERT INTO `t_areas` VALUES ('3092', '白碱滩区', '834000', '1', '3089', '3092');
INSERT INTO `t_areas` VALUES ('3093', '乌尔禾区', '834000', '1', '3089', '3093');
INSERT INTO `t_areas` VALUES ('3094', '吐鲁番地区', '838000', '1', '33', '3094');
INSERT INTO `t_areas` VALUES ('3095', '吐鲁番市', '838000', '1', '3094', '3095');
INSERT INTO `t_areas` VALUES ('3096', '鄯善县', '838200', '1', '3094', '3096');
INSERT INTO `t_areas` VALUES ('3097', '托克逊县', '838100', '1', '3094', '3097');
INSERT INTO `t_areas` VALUES ('3098', '哈密地区', '839000', '1', '33', '3098');
INSERT INTO `t_areas` VALUES ('3099', '哈密市', '839000', '1', '3098', '3099');
INSERT INTO `t_areas` VALUES ('3100', '巴里坤哈萨克自治县', '839200', '1', '3098', '3100');
INSERT INTO `t_areas` VALUES ('3101', '伊吾县', '839300', '1', '3098', '3101');
INSERT INTO `t_areas` VALUES ('3102', '昌吉回族自治州', '831100', '1', '33', '3102');
INSERT INTO `t_areas` VALUES ('3103', '昌吉市', '831100', '1', '3102', '3103');
INSERT INTO `t_areas` VALUES ('3104', '阜康市', '831500', '1', '3102', '3104');
INSERT INTO `t_areas` VALUES ('3105', '呼图壁县', '831200', '1', '3102', '3105');
INSERT INTO `t_areas` VALUES ('3106', '玛纳斯县', '832200', '1', '3102', '3106');
INSERT INTO `t_areas` VALUES ('3107', '奇台县', '831800', '1', '3102', '3107');
INSERT INTO `t_areas` VALUES ('3108', '吉木萨尔县', '831700', '1', '3102', '3108');
INSERT INTO `t_areas` VALUES ('3109', '木垒哈萨克自治县', '831900', '1', '3102', '3109');
INSERT INTO `t_areas` VALUES ('3110', '博尔塔拉蒙古自治州', '833400', '1', '33', '3110');
INSERT INTO `t_areas` VALUES ('3111', '博乐市', '833400', '1', '3110', '3111');
INSERT INTO `t_areas` VALUES ('3112', '精河县', '833300', '1', '3110', '3112');
INSERT INTO `t_areas` VALUES ('3113', '温泉县', '833500', '1', '3110', '3113');
INSERT INTO `t_areas` VALUES ('3114', '巴音郭楞蒙古自治州', '841000', '1', '33', '3114');
INSERT INTO `t_areas` VALUES ('3115', '库尔勒市', '841000', '1', '3114', '3115');
INSERT INTO `t_areas` VALUES ('3116', '轮台县', '841600', '1', '3114', '3116');
INSERT INTO `t_areas` VALUES ('3117', '尉犁县', '841500', '1', '3114', '3117');
INSERT INTO `t_areas` VALUES ('3118', '若羌县', '841800', '1', '3114', '3118');
INSERT INTO `t_areas` VALUES ('3119', '且末县', '841900', '1', '3114', '3119');
INSERT INTO `t_areas` VALUES ('3120', '焉耆回族自治县', '841100', '1', '3114', '3120');
INSERT INTO `t_areas` VALUES ('3121', '和静县', '841300', '1', '3114', '3121');
INSERT INTO `t_areas` VALUES ('3122', '和硕县', '841200', '1', '3114', '3122');
INSERT INTO `t_areas` VALUES ('3123', '博湖县', '841400', '1', '3114', '3123');
INSERT INTO `t_areas` VALUES ('3124', '阿克苏地区', '843000', '1', '33', '3124');
INSERT INTO `t_areas` VALUES ('3125', '阿克苏市', '843000', '1', '3124', '3125');
INSERT INTO `t_areas` VALUES ('3126', '温宿县', '843100', '1', '3124', '3126');
INSERT INTO `t_areas` VALUES ('3127', '库车县', '842000', '1', '3124', '3127');
INSERT INTO `t_areas` VALUES ('3128', '沙雅县', '842200', '1', '3124', '3128');
INSERT INTO `t_areas` VALUES ('3129', '新和县', '842100', '1', '3124', '3129');
INSERT INTO `t_areas` VALUES ('3130', '拜城县', '842300', '1', '3124', '3130');
INSERT INTO `t_areas` VALUES ('3131', '乌什县', '843400', '1', '3124', '3131');
INSERT INTO `t_areas` VALUES ('3132', '阿瓦提县', '843200', '1', '3124', '3132');
INSERT INTO `t_areas` VALUES ('3133', '柯坪县', '845350', '1', '3124', '3133');
INSERT INTO `t_areas` VALUES ('3134', '克孜勒苏柯尔克孜自治州', '845350', '1', '33', '3134');
INSERT INTO `t_areas` VALUES ('3135', '阿图什市', '845350', '1', '3134', '3135');
INSERT INTO `t_areas` VALUES ('3136', '阿克陶县', '845550', '1', '3134', '3136');
INSERT INTO `t_areas` VALUES ('3137', '阿合奇县', '843500', '1', '3134', '3137');
INSERT INTO `t_areas` VALUES ('3138', '乌恰县', '845450', '1', '3134', '3138');
INSERT INTO `t_areas` VALUES ('3139', '喀什地区', '844000', '1', '33', '3139');
INSERT INTO `t_areas` VALUES ('3140', '喀什市', '844000', '1', '3139', '3140');
INSERT INTO `t_areas` VALUES ('3141', '疏附县', '844100', '1', '3139', '3141');
INSERT INTO `t_areas` VALUES ('3142', '疏勒县', '844200', '1', '3139', '3142');
INSERT INTO `t_areas` VALUES ('3143', '英吉沙县', '844500', '1', '3139', '3143');
INSERT INTO `t_areas` VALUES ('3144', '泽普县', '844800', '1', '3139', '3144');
INSERT INTO `t_areas` VALUES ('3145', '莎车县', '844700', '1', '3139', '3145');
INSERT INTO `t_areas` VALUES ('3146', '叶城县', '844900', '1', '3139', '3146');
INSERT INTO `t_areas` VALUES ('3147', '麦盖提县', '844600', '1', '3139', '3147');
INSERT INTO `t_areas` VALUES ('3148', '岳普湖县', '844400', '1', '3139', '3148');
INSERT INTO `t_areas` VALUES ('3149', '伽师县', '844300', '1', '3139', '3149');
INSERT INTO `t_areas` VALUES ('3150', '巴楚县', '843800', '1', '3139', '3150');
INSERT INTO `t_areas` VALUES ('3151', '塔什库尔干塔吉克自治县', '845250', '1', '3139', '3151');
INSERT INTO `t_areas` VALUES ('3152', '和田地区', '848000', '1', '33', '3152');
INSERT INTO `t_areas` VALUES ('3153', '和田市', '848000', '1', '3152', '3153');
INSERT INTO `t_areas` VALUES ('3154', '和田县', '848000', '1', '3152', '3154');
INSERT INTO `t_areas` VALUES ('3155', '墨玉县', '848100', '1', '3152', '3155');
INSERT INTO `t_areas` VALUES ('3156', '皮山县', '845150', '1', '3152', '3156');
INSERT INTO `t_areas` VALUES ('3157', '洛浦县', '848200', '1', '3152', '3157');
INSERT INTO `t_areas` VALUES ('3158', '策勒县', '848300', '1', '3152', '3158');
INSERT INTO `t_areas` VALUES ('3159', '于田县', '848400', '1', '3152', '3159');
INSERT INTO `t_areas` VALUES ('3160', '民丰县', '848500', '1', '3152', '3160');
INSERT INTO `t_areas` VALUES ('3161', '伊犁哈萨克自治州', '835000', '1', '33', '3161');
INSERT INTO `t_areas` VALUES ('3162', '伊宁市', '835000', '1', '3161', '3162');
INSERT INTO `t_areas` VALUES ('3163', '奎屯市', '833200', '1', '3161', '3163');
INSERT INTO `t_areas` VALUES ('3164', '伊宁县', '835100', '1', '3161', '3164');
INSERT INTO `t_areas` VALUES ('3165', '察布查尔锡伯自治县', '835300', '1', '3161', '3165');
INSERT INTO `t_areas` VALUES ('3166', '霍城县', '835200', '1', '3161', '3166');
INSERT INTO `t_areas` VALUES ('3167', '巩留县', '835400', '1', '3161', '3167');
INSERT INTO `t_areas` VALUES ('3168', '新源县', '835800', '1', '3161', '3168');
INSERT INTO `t_areas` VALUES ('3169', '昭苏县', '835600', '1', '3161', '3169');
INSERT INTO `t_areas` VALUES ('3170', '特克斯县', '835500', '1', '3161', '3170');
INSERT INTO `t_areas` VALUES ('3171', '尼勒克县', '835700', '1', '3161', '3171');
INSERT INTO `t_areas` VALUES ('3172', '塔城地区', '834700', '1', '33', '3172');
INSERT INTO `t_areas` VALUES ('3173', '塔城市', '834300', '1', '3172', '3173');
INSERT INTO `t_areas` VALUES ('3174', '乌苏市', '833300', '1', '3172', '3174');
INSERT INTO `t_areas` VALUES ('3175', '额敏县', '834600', '1', '3172', '3175');
INSERT INTO `t_areas` VALUES ('3176', '沙湾县', '832100', '1', '3172', '3176');
INSERT INTO `t_areas` VALUES ('3177', '托里县', '834500', '1', '3172', '3177');
INSERT INTO `t_areas` VALUES ('3178', '裕民县', '834800', '1', '3172', '3178');
INSERT INTO `t_areas` VALUES ('3179', '和布克赛尔蒙古自治县', '834400', '1', '3172', '3179');
INSERT INTO `t_areas` VALUES ('3180', '阿勒泰地区', '836500', '1', '33', '3180');
INSERT INTO `t_areas` VALUES ('3181', '阿勒泰市', '836500', '1', '3180', '3181');
INSERT INTO `t_areas` VALUES ('3182', '布尔津县', '836600', '1', '3180', '3182');
INSERT INTO `t_areas` VALUES ('3183', '富蕴县', '836100', '1', '3180', '3183');
INSERT INTO `t_areas` VALUES ('3184', '福海县', '836400', '1', '3180', '3184');
INSERT INTO `t_areas` VALUES ('3185', '哈巴河县', '836700', '1', '3180', '3185');
INSERT INTO `t_areas` VALUES ('3186', '青河县', '836200', '1', '3180', '3186');
INSERT INTO `t_areas` VALUES ('3187', '吉木乃县', '836800', '1', '3180', '3187');
INSERT INTO `t_areas` VALUES ('3188', '北部新区', '401120', '1', '23', '3188');
INSERT INTO `t_areas` VALUES ('3189', '两江新区', '400020', '1', '23', '3189');
INSERT INTO `t_areas` VALUES ('3190', '滨海新区', '300450', '1', '3', '3190');
INSERT INTO `t_areas` VALUES ('3191', '沈北新区', '110121', '1', '499', '3191');
INSERT INTO `t_areas` VALUES ('3192', '观山湖区', '550018', '1', '2485', '3192');
INSERT INTO `t_areas` VALUES ('3193', '高新区', '400039', '1', '23', '3193');
INSERT INTO `t_areas` VALUES ('3194', '高新区', '610041', '1', '2283', '3194');

-- ----------------------------
-- Table structure for `t_collection_doc`
-- ----------------------------
DROP TABLE IF EXISTS `t_collection_doc`;
CREATE TABLE `t_collection_doc` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '收款单ID',
  `c_order_no` char(20) NOT NULL DEFAULT '' COMMENT '订单号',
  `c_admin_name` varchar(20) NOT NULL DEFAULT '' COMMENT '管理员用户名',
  `c_user_name` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `c_note` varchar(1000) NOT NULL DEFAULT '' COMMENT '备注',
  `c_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `c_pay_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '支付状态 1已支付 2待支付',
  `c_order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `c_payment_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付方式ID',
  `c_admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收款单';

-- ----------------------------
-- Records of t_collection_doc
-- ----------------------------

-- ----------------------------
-- Table structure for `t_config`
-- ----------------------------
DROP TABLE IF EXISTS `t_config`;
CREATE TABLE `t_config` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_key` varchar(50) NOT NULL COMMENT '配置键',
  `c_content` text COMMENT '配置值',
  PRIMARY KEY (`c_id`),
  UNIQUE KEY `c_key` (`c_key`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='系统配置表';

-- ----------------------------
-- Records of t_config
-- ----------------------------
INSERT INTO `t_config` VALUES ('1', 'site', '{\"domian_frontend\":\"http:\\/\\/127.0.0.1\\/geneerp\\/frontend\\/web\",\"domian_backend\":\"http:\\/\\/127.0.0.1\\/geneerp\\/backend\\/web\",\"domian_file\":\"http:\\/\\/192.168.1.22\\/geneerp\\/upload\",\"domian_api\":\"http:\\/\\/127.0.0.1\",\"site_title\":\"\\u7f51\\u7ad9\\u540d\\u79f0\",\"site_seo\":\"\\u7f51\\u7ad9\\u9996\\u9875\\u9644\\u52a0\\u6807\\u9898\",\"site_keywords\":\"\\u7f51\\u7ad9\\u9996\\u9875\\u5173\\u952e\\u8bcd\",\"site_description\":\"\\u7f51\\u7ad9SEO\\u63cf\\u8ff0\\u4fe1\\u606f\",\"site_js\":\"\\u7b2c\\u4e09\\u65b9\\u7edf\\u8ba1\\u4ee3\\u7801\",\"site_icp\":\"ICP\\u5907\\u6848\\u5e8f\\u53f7\",\"site_contact\":\"\\u8054\\u7cfb\\u4eba\",\"site_mobile\":\"18016011673\",\"site_phone\":\"400-12345678\",\"site_email\":\"19744244@qq.com\",\"site_address\":\"\\u4e0a\\u6d77\\u5e02\",\"site_weixin\":\"jxsmcom\"}');
INSERT INTO `t_config` VALUES ('2', 'upload', '{\"upload_picture_status\":\"1\",\"upload_file_status\":\"1\",\"upload_file_login\":\"2\",\"upload_thumb_type\":\"2\",\"upload_thumb_width\":\"200\",\"upload_thumb_height\":\"200\"}');
INSERT INTO `t_config` VALUES ('3', 'shop', '{\"number_prefix\":\"JJ\",\"username_prefix\":\"JJ\",\"order_auto_cancel_hour\":\"48\",\"order_auto_finish_hour\":\"360\",\"order_auto_comment_hour\":\"720\",\"user_address_max\":\"10\",\"shop_tax\":\"0\",\"comment_status\":\"2\",\"store_status\":\"2\"}');
INSERT INTO `t_config` VALUES ('4', 'email', '{\"email_send_type\":\"1\",\"smtp_type\":\"1\",\"email_send\":\"wuxh@kangliyixue.com\",\"email_safe\":\"1\",\"email_smtp\":\"smtp.mxhichina.com\",\"smtp_user\":\"wuxh@kangliyixue.com\",\"smtp_password\":\"Mirror00o\",\"smtp_port\":\"465\",\"email_test\":\"42344344@qq.com\",\"email_expire\":\"300\",\"email_send_time\":\"60\",\"email_ip_count\":\"50\",\"email_send_count\":\"50\"}');
INSERT INTO `t_config` VALUES ('5', 'sms', '{\"sms_send_type\":\"1\",\"sms_app_key\":\"23422561\",\"sms_app_secret\":\"fef33e9af31c09dee78339bef34ea195\",\"sms_sign_name\":\"\\u7d20\\u98df\\u732b\",\"sms_expire\":\"300\",\"sms_send_time\":\"60\",\"sms_ip_count\":\"50\",\"sms_send_count\":\"50\"}');
INSERT INTO `t_config` VALUES ('6', 'plugin', '{\"qq_open\":\"2\",\"qq_list\":\"\",\"player_open\":\"2\",\"player_url\":\"\",\"notice_open\":\"2\",\"notice_message\":\"\"}');
INSERT INTO `t_config` VALUES ('7', 'system', '{\"system_site_open\":\"1\",\"system_site_close_msg\":\"\",\"user_login_status\":\"1\",\"user_log_status\":\"1\",\"system_log_status\":\"1\",\"mobile_register_status\":\"1\",\"email_register_status\":\"1\",\"system_template\":\"default\"}');

-- ----------------------------
-- Table structure for `t_content`
-- ----------------------------
DROP TABLE IF EXISTS `t_content`;
CREATE TABLE `t_content` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '内容ID',
  `c_title` varchar(255) NOT NULL COMMENT '标题',
  `c_short` varchar(150) NOT NULL DEFAULT '' COMMENT '短标题',
  `c_seo` varchar(255) NOT NULL DEFAULT '' COMMENT '标题优化',
  `c_keyword` varchar(255) NOT NULL DEFAULT '' COMMENT '关键词',
  `c_description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `c_author` varchar(150) NOT NULL DEFAULT '' COMMENT '作者',
  `c_editor` varchar(150) NOT NULL DEFAULT '' COMMENT '编辑',
  `c_source_site` varchar(150) NOT NULL DEFAULT '' COMMENT '来源网站',
  `c_source_url` varchar(255) NOT NULL DEFAULT '' COMMENT '来源网址',
  `c_picture` varchar(1000) NOT NULL DEFAULT '' COMMENT '缩略图地址',
  `c_file` varchar(1000) NOT NULL DEFAULT '' COMMENT '附件地址',
  `c_create_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '来源类型 1PC 2H5 3IOS 4Andriod 8其他 9平台',
  `c_source` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '来源类型 1原创 2转载 3翻译 4跳转',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '3' COMMENT '发布状态 1已发布 2已审核 3草稿',
  `c_special_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '内容专题ID',
  `c_category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '内容类别ID',
  `c_hits` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击总数',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='内容表';

-- ----------------------------
-- Records of t_content
-- ----------------------------

-- ----------------------------
-- Table structure for `t_content_category`
-- ----------------------------
DROP TABLE IF EXISTS `t_content_category`;
CREATE TABLE `t_content_category` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '内容类别ID',
  `c_title` varchar(50) NOT NULL COMMENT '类别名称',
  `c_short` varchar(150) NOT NULL DEFAULT '' COMMENT '类别短名称',
  `c_url` varchar(255) NOT NULL DEFAULT '' COMMENT '跳转网址',
  `c_seo` varchar(255) NOT NULL DEFAULT '' COMMENT '标题优化',
  `c_keyword` varchar(255) NOT NULL DEFAULT '' COMMENT '关键词',
  `c_description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `c_picture` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图地址',
  `c_home_block` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '首页板块 1开启 2关闭',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1顶部导航栏 2底部导航栏 3顶部底部显示 4不显示',
  `c_model_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '内容模型ID',
  `c_parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='内容类别表';

-- ----------------------------
-- Records of t_content_category
-- ----------------------------

-- ----------------------------
-- Table structure for `t_content_category_text`
-- ----------------------------
DROP TABLE IF EXISTS `t_content_category_text`;
CREATE TABLE `t_content_category_text` (
  `c_content_category_id` int(10) unsigned NOT NULL COMMENT '内容类别ID',
  `c_content` text COMMENT '正文',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_content_category_id`),
  UNIQUE KEY `c_category_id` (`c_content_category_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='内容类别正文 单页表';

-- ----------------------------
-- Records of t_content_category_text
-- ----------------------------

-- ----------------------------
-- Table structure for `t_content_goods_relation`
-- ----------------------------
DROP TABLE IF EXISTS `t_content_goods_relation`;
CREATE TABLE `t_content_goods_relation` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `c_content_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '内容ID',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='内容商品关联表';

-- ----------------------------
-- Records of t_content_goods_relation
-- ----------------------------

-- ----------------------------
-- Table structure for `t_content_hits`
-- ----------------------------
DROP TABLE IF EXISTS `t_content_hits`;
CREATE TABLE `t_content_hits` (
  `c_content_id` int(10) unsigned NOT NULL COMMENT '内容ID',
  `c_pc_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'PC点击数量',
  `c_h5_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'H5点击数量',
  `c_app_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'APP点击数量',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_content_id`),
  UNIQUE KEY `c_content_id` (`c_content_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='内容点击统计表';

-- ----------------------------
-- Records of t_content_hits
-- ----------------------------

-- ----------------------------
-- Table structure for `t_content_label`
-- ----------------------------
DROP TABLE IF EXISTS `t_content_label`;
CREATE TABLE `t_content_label` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_content_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '内容ID',
  `c_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '标签类型 1置顶 2推荐 3热门',
  PRIMARY KEY (`c_id`),
  UNIQUE KEY `c_content_id` (`c_content_id`,`c_type`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='内容标签表';

-- ----------------------------
-- Records of t_content_label
-- ----------------------------

-- ----------------------------
-- Table structure for `t_content_model`
-- ----------------------------
DROP TABLE IF EXISTS `t_content_model`;
CREATE TABLE `t_content_model` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '内容模型ID',
  `c_title` varchar(50) NOT NULL COMMENT '模型名称',
  `c_template_list` varchar(50) NOT NULL DEFAULT '' COMMENT '列表模板',
  `c_template_page` varchar(50) NOT NULL DEFAULT '' COMMENT '详情模板',
  `c_config` text COMMENT '配置',
  `c_pagesize` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '列表每页显示数目',
  `c_type` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '类型 1系统原型 2自定义模型',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1正常 2无效',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='内容模型表';

-- ----------------------------
-- Records of t_content_model
-- ----------------------------
INSERT INTO `t_content_model` VALUES ('1', '文章模型', 'list_article', 'page_article', '[\"c_special_id\",\"c_picture\",\"c_source\",\"c_seo\",\"c_keyword\",\"c_description\",\"label\"]', '10', '1', '1', '1', '1462799037', '2017-04-21 14:24:49');
INSERT INTO `t_content_model` VALUES ('2', '帮助模型', 'list_help', 'page_help', '[\"c_picture\"]', '10', '1', '1', '2', '1462799037', '2017-04-21 13:24:16');
INSERT INTO `t_content_model` VALUES ('3', '下载模型', 'list_download', 'page_download', '[\"c_file\"]', '10', '1', '1', '3', '1463179801', '2017-04-21 13:25:03');

-- ----------------------------
-- Table structure for `t_content_special`
-- ----------------------------
DROP TABLE IF EXISTS `t_content_special`;
CREATE TABLE `t_content_special` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_title` varchar(50) NOT NULL COMMENT '专题名称',
  `c_short` varchar(150) NOT NULL DEFAULT '' COMMENT '短名称',
  `c_seo` varchar(255) NOT NULL DEFAULT '' COMMENT '标题优化',
  `c_keyword` varchar(255) NOT NULL DEFAULT '' COMMENT '关键词',
  `c_description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `c_picture` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图地址',
  `c_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '列表显示方式 1 文字列表 2图片列表',
  `c_home_block` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '首页板块 1开启 2关闭',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1正常 2无效',
  `c_parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='内容专题表';

-- ----------------------------
-- Records of t_content_special
-- ----------------------------

-- ----------------------------
-- Table structure for `t_content_text`
-- ----------------------------
DROP TABLE IF EXISTS `t_content_text`;
CREATE TABLE `t_content_text` (
  `c_content_id` int(10) unsigned NOT NULL COMMENT '内容ID',
  `c_pc_content` text COMMENT 'PC内容正文',
  `c_h5_content` text COMMENT 'H5内容正文',
  `c_app_content` text COMMENT 'APP内容正文',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_content_id`),
  UNIQUE KEY `c_content_id` (`c_content_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='内容正文表';

-- ----------------------------
-- Records of t_content_text
-- ----------------------------

-- ----------------------------
-- Table structure for `t_delivery`
-- ----------------------------
DROP TABLE IF EXISTS `t_delivery`;
CREATE TABLE `t_delivery` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配送方式ID',
  `c_title` varchar(50) NOT NULL DEFAULT '' COMMENT '配送名称',
  `c_description` varchar(255) NOT NULL DEFAULT '' COMMENT '配送描述',
  `c_area_id_array` text COMMENT '配送区域ID',
  `c_first_price_array` text COMMENT '配送地区对应的首重费用',
  `c_second_price_array` text COMMENT '配送地区对应的续重费用',
  `c_first_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '首重费用',
  `c_second_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '续重费用',
  `c_insured_rate` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '保价费率',
  `c_low_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '最低保价',
  `c_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '配送类型 1先付款后发货 2先发货后付款 3自提点',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1正常 2无效',
  `c_is_insured` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '是否支持物流保价 1支持保价 2不支持保价',
  `c_price_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '运费类型 1统一区域运费 2指定区域运费',
  `c_open_default` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '其他地区是否启用默认费用 1启用 2不启用',
  `c_first_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '首重重量(克)',
  `c_second_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '续重重量(克)',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='配送方式表';

-- ----------------------------
-- Records of t_delivery
-- ----------------------------
INSERT INTO `t_delivery` VALUES ('1', '快递公司', '', '', '', '', '20.00', '10.00', '0.00', '0.00', '1', '1', '2', '1', '1', '1000', '1000', '9', '1487168561', '0000-00-00 00:00:00');
INSERT INTO `t_delivery` VALUES ('2', '货到付款', '', '', '', '', '20.00', '10.00', '0.00', '0.00', '2', '1', '2', '1', '1', '1000', '1000', '8', '1487168603', '0000-00-00 00:00:00');
INSERT INTO `t_delivery` VALUES ('3', '自提点', '', '', '', '', '5.00', '10.00', '10.00', '10.00', '3', '1', '1', '1', '1', '1000', '1000', '7', '1487670644', '2017-05-15 09:00:47');

-- ----------------------------
-- Table structure for `t_delivery_doc`
-- ----------------------------
DROP TABLE IF EXISTS `t_delivery_doc`;
CREATE TABLE `t_delivery_doc` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '发货单ID',
  `c_mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机',
  `c_phone` varchar(20) NOT NULL DEFAULT '' COMMENT '联系电话',
  `c_full_name` varchar(20) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `c_admin_name` varchar(20) NOT NULL DEFAULT '' COMMENT '管理员用户名',
  `c_address` varchar(100) NOT NULL DEFAULT '' COMMENT '收货地址',
  `c_delivery_code` varchar(255) NOT NULL DEFAULT '' COMMENT '物流单号',
  `c_note` varchar(1000) NOT NULL DEFAULT '' COMMENT '管理员备注',
  `c_real_freight` decimal(10,0) unsigned NOT NULL DEFAULT '0' COMMENT '实付运费',
  `c_postcode` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '邮政编码',
  `c_province_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '省份ID',
  `c_city_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '市级ID',
  `c_area_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '地区ID',
  `c_order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `c_freight_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '货运公司ID',
  `c_delivery_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '配送方式ID',
  `c_admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='发货单';

-- ----------------------------
-- Records of t_delivery_doc
-- ----------------------------

-- ----------------------------
-- Table structure for `t_email_log`
-- ----------------------------
DROP TABLE IF EXISTS `t_email_log`;
CREATE TABLE `t_email_log` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_title` varchar(100) NOT NULL DEFAULT '' COMMENT '邮件标题',
  `c_email` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱',
  `c_body` text COMMENT '邮件正文',
  `c_param` text COMMENT '模板替换参数  JSON格式',
  `c_error` text COMMENT '邮件发送错误提示信息',
  `c_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '消息类型',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '3' COMMENT '状态 1成功 2失败 3未发送',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_send_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '预约发送时间 可以用去定时发送',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='邮件发送日志表';

-- ----------------------------
-- Records of t_email_log
-- ----------------------------

-- ----------------------------
-- Table structure for `t_express_template`
-- ----------------------------
DROP TABLE IF EXISTS `t_express_template`;
CREATE TABLE `t_express_template` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_title` varchar(50) NOT NULL DEFAULT '' COMMENT '快递单模板名字',
  `c_picture` varchar(255) NOT NULL DEFAULT '' COMMENT '背景图片路径',
  `c_width` smallint(5) unsigned NOT NULL DEFAULT '900' COMMENT '背景图片路径',
  `c_height` smallint(5) unsigned NOT NULL DEFAULT '600' COMMENT '背景图片路径',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1正常 2无效',
  `c_config` text COMMENT '快递单结构数据 JSON格式',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='快递单模板';

-- ----------------------------
-- Records of t_express_template
-- ----------------------------
INSERT INTO `t_express_template` VALUES ('1', 'EMS特快专递', '', '900', '500', '1', 'a:12:{i:1;s:222:\"{\"x\":461,\"y\":350,\"typeId\":\"date_y\",\"typeText\":\"当前日期-年\",\"width\":33,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":18}\";i:5;s:227:\"{\"x\":70,\"y\":184,\"typeId\":\"dly_address\",\"typeText\":\"发货人-地址\",\"width\":318,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":54}\";i:6;s:224:\"{\"x\":271,\"y\":117,\"typeId\":\"dly_tel\",\"typeText\":\"发货人-电话\",\"width\":119,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":20}\";i:10;s:225:\"{\"x\":642,\"y\":237,\"typeId\":\"ship_zip\",\"typeText\":\"收货人-邮编\",\"width\":109,\"styleSheet\":{\"trackingLeft\":\"9\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":19}\";i:11;s:228:\"{\"x\":625,\"y\":117,\"typeId\":\"ship_mobile\",\"typeText\":\"收货人-手机\",\"width\":126,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":21}\";i:0;s:222:\"{\"x\":510,\"y\":348,\"typeId\":\"date_m\",\"typeText\":\"当前日期-月\",\"width\":29,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":21}\";i:9;s:224:\"{\"x\":458,\"y\":370,\"typeId\":\"order_memo\",\"typeText\":\"订单-备注\",\"width\":292,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":30}\";i:4;s:224:\"{\"x\":122,\"y\":120,\"typeId\":\"dly_name\",\"typeText\":\"发货人-姓名\",\"width\":94,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":24}\";i:8;s:223:\"{\"x\":301,\"y\":238,\"typeId\":\"dly_zip\",\"typeText\":\"发货人-邮编\",\"width\":99,\"styleSheet\":{\"trackingLeft\":\"9\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":19}\";i:3;s:246:\"{\"x\":409,\"y\":184,\"typeId\":\"ship_detail_addr\",\"typeText\":\"收货人-地区+详细地址\",\"width\":343,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":55}\";i:2;s:226:\"{\"x\":462,\"y\":117,\"typeId\":\"ship_name\",\"typeText\":\"收货人-姓名\",\"width\":104,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":27}\";i:7;s:222:\"{\"x\":559,\"y\":348,\"typeId\":\"date_d\",\"typeText\":\"当前日期-日\",\"width\":30,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":21}\";}');
INSERT INTO `t_express_template` VALUES ('2', '顺丰速运', '', '900', '550', '1', 'a:12:{i:1;s:224:\"{\"x\":265,\"y\":104,\"typeId\":\"dly_name\",\"typeText\":\"发货人-姓名\",\"width\":74,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":22}\";i:3;s:222:\"{\"x\":549,\"y\":314,\"typeId\":\"date_m\",\"typeText\":\"当前日期-月\",\"width\":32,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":22}\";i:0;s:224:\"{\"x\":522,\"y\":426,\"typeId\":\"order_memo\",\"typeText\":\"订单-备注\",\"width\":182,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":35}\";i:6;s:224:\"{\"x\":54,\"y\":337,\"typeId\":\"ship_tel\",\"typeText\":\"收货人-电话\",\"width\":143,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":17}\";i:11;s:227:\"{\"x\":207,\"y\":188,\"typeId\":\"dly_mobile\",\"typeText\":\"发货人-手机\",\"width\":129,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":18}\";i:4;s:245:\"{\"x\":55,\"y\":271,\"typeId\":\"ship_detail_addr\",\"typeText\":\"收货人-地区+详细地址\",\"width\":284,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":56}\";i:5;s:228:\"{\"x\":376,\"y\":118,\"typeId\":\"ship_time\",\"typeText\":\"订单-送货时间\",\"width\":52,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":22}\";i:10;s:228:\"{\"x\":207,\"y\":336,\"typeId\":\"ship_mobile\",\"typeText\":\"收货人-手机\",\"width\":132,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":18}\";i:7;s:227:\"{\"x\":82,\"y\":132,\"typeId\":\"dly_address\",\"typeText\":\"发货人-地址\",\"width\":255,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":52}\";i:8;s:225:\"{\"x\":267,\"y\":219,\"typeId\":\"ship_name\",\"typeText\":\"收货人-姓名\",\"width\":72,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":23}\";i:2;s:223:\"{\"x\":51,\"y\":190,\"typeId\":\"dly_tel\",\"typeText\":\"发货人-电话\",\"width\":152,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":18}\";i:9;s:222:\"{\"x\":585,\"y\":314,\"typeId\":\"date_d\",\"typeText\":\"当前日期-日\",\"width\":33,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":20}\";}');
INSERT INTO `t_express_template` VALUES ('3', '申通快递', '', '900', '520', '1', 'a:9:{i:1;s:222:\"{\"typeId\":\"date_d\",\"x\":153,\"typeText\":\"当前日期-日\",\"y\":389,\"width\":22,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":20}\";i:6;s:221:\"{\"typeId\":\"date_y\",\"x\":67,\"typeText\":\"当前日期-年\",\"y\":391,\"width\":35,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":22}\";i:8;s:224:\"{\"typeId\":\"dly_name\",\"x\":121,\"typeText\":\"发货人-姓名\",\"y\":97,\"width\":114,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":28}\";i:3;s:228:\"{\"typeId\":\"dly_address\",\"x\":114,\"typeText\":\"发货人-地址\",\"y\":167,\"width\":296,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":75}\";i:2;s:227:\"{\"typeId\":\"dly_mobile\",\"x\":140,\"typeText\":\"发货人-手机\",\"y\":240,\"width\":270,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":24}\";i:4;s:222:\"{\"typeId\":\"date_m\",\"x\":113,\"typeText\":\"当前日期-月\",\"y\":391,\"width\":24,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":18}\";i:5;s:228:\"{\"typeId\":\"ship_mobile\",\"x\":508,\"typeText\":\"收货人-手机\",\"y\":241,\"width\":274,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":21}\";i:0;s:225:\"{\"typeId\":\"ship_name\",\"x\":487,\"typeText\":\"收货人-姓名\",\"y\":95,\"width\":115,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":29}\";i:7;s:246:\"{\"typeId\":\"ship_detail_addr\",\"x\":474,\"typeText\":\"收货人-地区+详细地址\",\"y\":167,\"width\":310,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":72}\";}');
INSERT INTO `t_express_template` VALUES ('4', '宅急送', '', '900', '520', '1', 'a:13:{i:2;s:225:\"{\"typeId\":\"ship_tel\",\"x\":429,\"typeText\":\"收货人-电话\",\"y\":234,\"width\":139,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":24}\";i:8;s:226:\"{\"typeId\":\"ship_name\",\"x\":456,\"typeText\":\"收货人-姓名\",\"y\":120,\"width\":123,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":31}\";i:1;s:227:\"{\"typeId\":\"dly_mobile\",\"x\":254,\"typeText\":\"发货人-手机\",\"y\":237,\"width\":130,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":25}\";i:11;s:225:\"{\"typeId\":\"dly_name\",\"x\":114,\"typeText\":\"发货人-姓名\",\"y\":123,\"width\":120,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":28}\";i:10;s:222:\"{\"typeId\":\"date_d\",\"x\":120,\"typeText\":\"当前日期-日\",\"y\":438,\"width\":23,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":16}\";i:6;s:223:\"{\"typeId\":\"dly_tel\",\"x\":90,\"typeText\":\"发货人-电话\",\"y\":235,\"width\":132,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":26}\";i:9;s:231:\"{\"typeId\":\"dly_area_1\",\"x\":255,\"typeText\":\"发货人-地区2级\",\"y\":123,\"width\":127,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":27}\";i:12;s:246:\"{\"typeId\":\"ship_detail_addr\",\"x\":428,\"typeText\":\"收货人-地区+详细地址\",\"y\":151,\"width\":294,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":57}\";i:3;s:231:\"{\"typeId\":\"dly_area_1\",\"x\":599,\"typeText\":\"发货人-地区2级\",\"y\":122,\"width\":123,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":29}\";i:5;s:221:\"{\"typeId\":\"date_m\",\"x\":90,\"typeText\":\"当前日期-月\",\"y\":438,\"width\":27,\"styleSheet\":{\"fontWeight\":\"normal\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"trackingLeft\":\"0\"},\"height\":17}\";i:4;s:224:\"{\"typeId\":\"order_memo\",\"x\":445,\"typeText\":\"订单-备注\",\"y\":364,\"width\":166,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":32}\";i:7;s:228:\"{\"typeId\":\"ship_mobile\",\"x\":585,\"typeText\":\"收货人-手机\",\"y\":234,\"width\":136,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":22}\";i:0;s:227:\"{\"typeId\":\"dly_address\",\"x\":86,\"typeText\":\"发货人-地址\",\"y\":154,\"width\":286,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":55}\";}');
INSERT INTO `t_express_template` VALUES ('5', '中通速递', '', '900', '520', '1', 'a:11:{i:2;s:224:\"{\"typeId\":\"order_memo\",\"x\":372,\"typeText\":\"订单-备注\",\"y\":369,\"width\":145,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":34}\";i:10;s:222:\"{\"typeId\":\"date_d\",\"x\":159,\"typeText\":\"当前日期-日\",\"y\":379,\"width\":24,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":17}\";i:7;s:228:\"{\"typeId\":\"dly_address\",\"x\":130,\"typeText\":\"发货人-地址\",\"y\":137,\"width\":259,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":59}\";i:4;s:222:\"{\"typeId\":\"date_m\",\"x\":118,\"typeText\":\"当前日期-月\",\"y\":379,\"width\":34,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":19}\";i:0;s:225:\"{\"typeId\":\"dly_name\",\"x\":129,\"typeText\":\"发货人-姓名\",\"y\":103,\"width\":101,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":25}\";i:8;s:226:\"{\"typeId\":\"ship_name\",\"x\":476,\"typeText\":\"收货人-姓名\",\"y\":103,\"width\":110,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":22}\";i:6;s:224:\"{\"typeId\":\"dly_tel\",\"x\":122,\"typeText\":\"发货人-电话\",\"y\":242,\"width\":125,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":27}\";i:9;s:225:\"{\"typeId\":\"ship_zip\",\"x\":642,\"typeText\":\"收货人-邮编\",\"y\":244,\"width\":106,\"styleSheet\":{\"trackingLeft\":\"9\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":23}\";i:1;s:246:\"{\"typeId\":\"ship_detail_addr\",\"x\":476,\"typeText\":\"收货人-地区+详细地址\",\"y\":134,\"width\":262,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":61}\";i:5;s:224:\"{\"typeId\":\"dly_zip\",\"x\":291,\"typeText\":\"发货人-邮编\",\"y\":243,\"width\":103,\"styleSheet\":{\"trackingLeft\":\"9\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":27}\";i:3;s:228:\"{\"typeId\":\"ship_mobile\",\"x\":464,\"typeText\":\"收货人-手机\",\"y\":241,\"width\":142,\"styleSheet\":{\"trackingLeft\":\"0\",\"fontSize\":\"12\",\"fontStyle\":\"normal\",\"fontFamily\":\"宋体\",\"textAlign\":\"left\",\"fontWeight\":\"normal\"},\"height\":30}\";}');

-- ----------------------------
-- Table structure for `t_feedback`
-- ----------------------------
DROP TABLE IF EXISTS `t_feedback`;
CREATE TABLE `t_feedback` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '反馈ID',
  `c_mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `c_user_name` varchar(20) NOT NULL DEFAULT '' COMMENT '用户账号',
  `c_full_name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `c_admin_name` varchar(20) NOT NULL DEFAULT '' COMMENT '回复人用户名',
  `c_email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `c_phone` varchar(50) NOT NULL DEFAULT '' COMMENT '联系电话',
  `c_title` varchar(255) NOT NULL DEFAULT '' COMMENT '主题',
  `c_note` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `c_sex` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '性别 1男 2女 3保密',
  `c_reply_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '回复类型 0不用通知 1邮件通知 2短信通知 3电话回访',
  `c_is_delete` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '删除状态 1正常 2删除 3彻底删除',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '状态 1已处理 2未处理 3处理中',
  `c_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类型',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `c_reply_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '回复时间',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='反馈表';

-- ----------------------------
-- Records of t_feedback
-- ----------------------------

-- ----------------------------
-- Table structure for `t_feedback_text`
-- ----------------------------
DROP TABLE IF EXISTS `t_feedback_text`;
CREATE TABLE `t_feedback_text` (
  `c_feedback_id` int(10) unsigned NOT NULL COMMENT '反馈ID',
  `c_content` text COMMENT '反馈内容',
  `c_reply_content` text COMMENT '回复内容',
  PRIMARY KEY (`c_feedback_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='反馈内容表';

-- ----------------------------
-- Records of t_feedback_text
-- ----------------------------

-- ----------------------------
-- Table structure for `t_freight_company`
-- ----------------------------
DROP TABLE IF EXISTS `t_freight_company`;
CREATE TABLE `t_freight_company` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '物流公司ID',
  `c_title` varchar(255) NOT NULL DEFAULT '' COMMENT '物流公司名称',
  `c_type` varchar(255) NOT NULL DEFAULT '' COMMENT '物流公司代号',
  `c_url` varchar(255) NOT NULL DEFAULT '' COMMENT '官方网址',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1正常 2无效',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='物流公司';

-- ----------------------------
-- Records of t_freight_company
-- ----------------------------
INSERT INTO `t_freight_company` VALUES ('1', '邮政特快专递', 'EMS', 'http://www.ems.com.cn', '1', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `t_freight_company` VALUES ('2', '申通快递', 'STO', 'http://www.sto.cn', '1', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `t_freight_company` VALUES ('3', '天天快递', 'HHTT', 'http://www.ttkd.cn', '1', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `t_freight_company` VALUES ('4', '圆通速递', 'YTO', 'http://www.yto.net.cn', '1', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `t_freight_company` VALUES ('5', '顺丰速运', 'SF', 'http://www.sf-express.com', '1', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `t_freight_company` VALUES ('6', '韵达快递', 'YD', 'http://www.yundaex.com', '1', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `t_freight_company` VALUES ('7', '中通速递', 'ZTO', 'http://www.zto.cn', '1', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `t_freight_company` VALUES ('8', '龙邦物流', 'LB', 'http://www.lbex.com.cn', '1', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `t_freight_company` VALUES ('9', '宅急送', 'ZJS', 'http://www.zjs.com.cn', '1', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `t_freight_company` VALUES ('10', '全一快递', 'UAPEX', 'http://www.apex100.com', '1', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `t_freight_company` VALUES ('11', '汇通速递', 'HTKY', 'http://www.htky365.com', '1', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `t_freight_company` VALUES ('12', '民航快递', 'MHKD', 'http://www.cae.com.cn', '1', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `t_freight_company` VALUES ('13', '中铁快运', 'ZTKY', 'http://www.cre.cn', '1', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `t_freight_company` VALUES ('14', 'FedEx联邦快递', 'FEDEX', 'http://www.fedex.com/cn', '1', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `t_freight_company` VALUES ('15', 'DHL', 'DHL', 'http://www.cn.dhl.com', '1', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `t_freight_company` VALUES ('16', '德邦物流', 'DBL', 'http://www.deppon.com', '1', '0', '0', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `t_goods`
-- ----------------------------
DROP TABLE IF EXISTS `t_goods`;
CREATE TABLE `t_goods` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品ID',
  `c_title` varchar(255) NOT NULL COMMENT '商品名称',
  `c_short` varchar(150) NOT NULL DEFAULT '' COMMENT '短名称',
  `c_seo` varchar(255) NOT NULL DEFAULT '' COMMENT '标题优化',
  `c_keyword` varchar(255) NOT NULL DEFAULT '' COMMENT '关键词',
  `c_search_keyword` varchar(255) NOT NULL DEFAULT '' COMMENT '商品搜索词库 逗号分隔',
  `c_description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `c_ad_picture` varchar(255) NOT NULL DEFAULT '' COMMENT '宣传图片',
  `c_picture` varchar(1000) NOT NULL DEFAULT '' COMMENT '商品相册',
  `c_number` varchar(50) NOT NULL DEFAULT '' COMMENT '商品货号',
  `c_unit` varchar(10) NOT NULL DEFAULT '' COMMENT '计量单位',
  `c_cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成本价格',
  `c_market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价格',
  `c_sell_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '销售价格',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '商品状态 1已上架 2申请上架 3已下架',
  `c_brand_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '品牌ID',
  `c_model_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `c_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '重量',
  `c_exp` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '经验值',
  `c_point` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `c_favorite_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏次数',
  `c_grade_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评分总数',
  `c_sale_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '销售总量',
  `c_comment_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论次数',
  `c_store_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '库存总量',
  `c_hits_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击总数',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `c_up_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上架时间',
  `c_down_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下架时间',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品表';

-- ----------------------------
-- Records of t_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `t_goods_attr`
-- ----------------------------
DROP TABLE IF EXISTS `t_goods_attr`;
CREATE TABLE `t_goods_attr` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_attr_value` varchar(255) NOT NULL DEFAULT '' COMMENT '属性值',
  `c_attr_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '属性ID',
  `c_goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `c_model_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品属性值表';

-- ----------------------------
-- Records of t_goods_attr
-- ----------------------------

-- ----------------------------
-- Table structure for `t_goods_brand`
-- ----------------------------
DROP TABLE IF EXISTS `t_goods_brand`;
CREATE TABLE `t_goods_brand` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '品牌ID',
  `c_title` varchar(255) NOT NULL DEFAULT '' COMMENT '品牌名称',
  `c_picture` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  `c_url` varchar(255) NOT NULL DEFAULT '' COMMENT '网址',
  `c_category_ids` varchar(255) NOT NULL DEFAULT '' COMMENT '品牌类别ID 逗号分割',
  `c_seo` varchar(255) NOT NULL DEFAULT '' COMMENT '标题优化',
  `c_keyword` varchar(255) NOT NULL DEFAULT '' COMMENT '关键词',
  `c_description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='品牌表';

-- ----------------------------
-- Records of t_goods_brand
-- ----------------------------

-- ----------------------------
-- Table structure for `t_goods_brand_category`
-- ----------------------------
DROP TABLE IF EXISTS `t_goods_brand_category`;
CREATE TABLE `t_goods_brand_category` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '品牌类别ID',
  `c_title` varchar(255) NOT NULL COMMENT '类别名称',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `c_goods_category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品类别ID',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='品牌类别表';

-- ----------------------------
-- Records of t_goods_brand_category
-- ----------------------------

-- ----------------------------
-- Table structure for `t_goods_category`
-- ----------------------------
DROP TABLE IF EXISTS `t_goods_category`;
CREATE TABLE `t_goods_category` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品类别ID',
  `c_title` varchar(50) NOT NULL COMMENT '类别名称',
  `c_short` varchar(150) NOT NULL DEFAULT '' COMMENT '短标题',
  `c_seo` varchar(255) NOT NULL DEFAULT '' COMMENT '标题优化',
  `c_keyword` varchar(255) NOT NULL DEFAULT '' COMMENT '关键词',
  `c_description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `c_picture` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图地址',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1正常 2无效',
  `c_parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品类别表';

-- ----------------------------
-- Records of t_goods_category
-- ----------------------------

-- ----------------------------
-- Table structure for `t_goods_category_extend`
-- ----------------------------
DROP TABLE IF EXISTS `t_goods_category_extend`;
CREATE TABLE `t_goods_category_extend` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `c_category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品类别ID',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品与商品类别对应扩展表';

-- ----------------------------
-- Records of t_goods_category_extend
-- ----------------------------

-- ----------------------------
-- Table structure for `t_goods_comment`
-- ----------------------------
DROP TABLE IF EXISTS `t_goods_comment`;
CREATE TABLE `t_goods_comment` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_order_no` char(20) NOT NULL COMMENT '订单号',
  `c_admin_name` varchar(20) NOT NULL DEFAULT '' COMMENT '回复人 管理员用户名',
  `c_content` varchar(1000) NOT NULL DEFAULT '' COMMENT '评论内容',
  `c_reply_content` varchar(1000) NOT NULL DEFAULT '' COMMENT '回复评论',
  `c_point` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '评论分数',
  `c_is_delete` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '删除状态 1正常 2删除 3彻底删除',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '审核状态 1已审核 2未审核',
  `c_order_goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单商品ID',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `c_reply_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '回复时间',
  `c_order_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建订单时间',
  `c_comment_ip` int(11) NOT NULL DEFAULT '0' COMMENT '评论IP',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品评论表';

-- ----------------------------
-- Records of t_goods_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `t_goods_favorite`
-- ----------------------------
DROP TABLE IF EXISTS `t_goods_favorite`;
CREATE TABLE `t_goods_favorite` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `c_is_delete` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '删除状态 1正常 2删除 3彻底删除',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品收藏表';

-- ----------------------------
-- Records of t_goods_favorite
-- ----------------------------

-- ----------------------------
-- Table structure for `t_goods_hits`
-- ----------------------------
DROP TABLE IF EXISTS `t_goods_hits`;
CREATE TABLE `t_goods_hits` (
  `c_goods_id` int(10) unsigned NOT NULL COMMENT '商品ID',
  `c_pc_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'PC点击数量',
  `c_h5_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'H5点击数量',
  `c_app_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'APP点击数量',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_goods_id`),
  UNIQUE KEY `c_goods_id` (`c_goods_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品点击统计表';

-- ----------------------------
-- Records of t_goods_hits
-- ----------------------------

-- ----------------------------
-- Table structure for `t_goods_keyword`
-- ----------------------------
DROP TABLE IF EXISTS `t_goods_keyword`;
CREATE TABLE `t_goods_keyword` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_title` varchar(20) NOT NULL DEFAULT '' COMMENT '关键词',
  `c_is_hot` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '是否为热门 1热门 2非热门',
  `c_goods_count` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '商品数量',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关键词排序',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='关键词';

-- ----------------------------
-- Records of t_goods_keyword
-- ----------------------------

-- ----------------------------
-- Table structure for `t_goods_label`
-- ----------------------------
DROP TABLE IF EXISTS `t_goods_label`;
CREATE TABLE `t_goods_label` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `c_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '标签类型 1最新商品 2特价商品 3热卖排行 4推荐商品',
  PRIMARY KEY (`c_id`),
  UNIQUE KEY `c_goods_id` (`c_goods_id`,`c_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品标签表';

-- ----------------------------
-- Records of t_goods_label
-- ----------------------------

-- ----------------------------
-- Table structure for `t_goods_model`
-- ----------------------------
DROP TABLE IF EXISTS `t_goods_model`;
CREATE TABLE `t_goods_model` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '模型ID',
  `c_title` varchar(50) NOT NULL COMMENT '模型名称',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品模型表';

-- ----------------------------
-- Records of t_goods_model
-- ----------------------------

-- ----------------------------
-- Table structure for `t_goods_model_attr`
-- ----------------------------
DROP TABLE IF EXISTS `t_goods_model_attr`;
CREATE TABLE `t_goods_model_attr` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_title` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `c_value` text COMMENT '属性值 逗号分隔',
  `c_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '输入控件的类型 1单选 2复选 3下拉 4输入框',
  `c_search` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '是否支持搜索 1支持2不支持',
  `c_model_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品模型ID',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品模型属性表';

-- ----------------------------
-- Records of t_goods_model_attr
-- ----------------------------

-- ----------------------------
-- Table structure for `t_goods_notify`
-- ----------------------------
DROP TABLE IF EXISTS `t_goods_notify`;
CREATE TABLE `t_goods_notify` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机',
  `c_email` varchar(255) NOT NULL DEFAULT '' COMMENT 'email',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1未通知 2仅邮件通知 3仅短信通知 4已邮件、短信通知',
  `c_goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_notify_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '通知时间',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品到货通知表';

-- ----------------------------
-- Records of t_goods_notify
-- ----------------------------

-- ----------------------------
-- Table structure for `t_goods_text`
-- ----------------------------
DROP TABLE IF EXISTS `t_goods_text`;
CREATE TABLE `t_goods_text` (
  `c_goods_id` int(10) unsigned NOT NULL COMMENT '商品ID',
  `c_pc_content` text COMMENT 'PC商品内容',
  `c_h5_content` text COMMENT 'H5商品内容',
  `c_app_content` text COMMENT 'APP商品内容',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_goods_id`),
  UNIQUE KEY `c_goods_id` (`c_goods_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品内容表';

-- ----------------------------
-- Records of t_goods_text
-- ----------------------------

-- ----------------------------
-- Table structure for `t_group_price`
-- ----------------------------
DROP TABLE IF EXISTS `t_group_price`;
CREATE TABLE `t_group_price` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `c_group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户组ID',
  `c_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  PRIMARY KEY (`c_id`),
  KEY `c_goods_id` (`c_goods_id`),
  KEY `c_group_id` (`c_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优先权大于用户组设定的折扣率';

-- ----------------------------
-- Records of t_group_price
-- ----------------------------

-- ----------------------------
-- Table structure for `t_link`
-- ----------------------------
DROP TABLE IF EXISTS `t_link`;
CREATE TABLE `t_link` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_title` varchar(50) NOT NULL COMMENT '标题',
  `c_url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接',
  `c_picture` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `c_note` varchar(1000) NOT NULL DEFAULT '' COMMENT '备注',
  `c_type` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '链接类型 1友情链接 2常用网址 3媒体合作',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '状态 1已审核 2待审核 3审核失败',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `c_hits` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击次数',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='链接表';

-- ----------------------------
-- Records of t_link
-- ----------------------------

-- ----------------------------
-- Table structure for `t_market_card`
-- ----------------------------
DROP TABLE IF EXISTS `t_market_card`;
CREATE TABLE `t_market_card` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_title` varchar(50) NOT NULL COMMENT '代金券名称',
  `c_number` varchar(50) NOT NULL COMMENT '卡号',
  `c_password` varchar(64) NOT NULL COMMENT '密码',
  `c_value` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '面值',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '激活状态 1正常 2无效',
  `c_is_send` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '发放状态 1已发放 2未发放',
  `c_is_used` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '使用状态 1已使用 2未使用',
  `c_ticket_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '代金券类型',
  `c_start_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '生效时间',
  `c_end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '到期时间',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`),
  UNIQUE KEY `c_number` (`c_number`),
  KEY `c_ticket_id` (`c_ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='代金券卡密表';

-- ----------------------------
-- Records of t_market_card
-- ----------------------------

-- ----------------------------
-- Table structure for `t_market_ticket`
-- ----------------------------
DROP TABLE IF EXISTS `t_market_ticket`;
CREATE TABLE `t_market_ticket` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_admin_name` varchar(20) NOT NULL DEFAULT '' COMMENT '管理员用户名',
  `c_title` varchar(50) NOT NULL DEFAULT '' COMMENT '代金券名称',
  `c_goods_ids` varchar(255) NOT NULL DEFAULT '0' COMMENT '限定商品ID',
  `c_note` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `c_value` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '面值',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1正常 2无效',
  `c_number_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '卡号生成类型不区分大小写 1数字 2字母 3数字与字母混合',
  `c_password_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '密码生成类型不区分大小写 1数字 2字母 3数字与字母混合',
  `c_number_length` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '卡号位数',
  `c_password_length` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '密码位数',
  `c_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '卡号数量',
  `c_exp` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所需经验值 0表示禁止兑换',
  `c_point` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所需积分 0表示禁止兑换',
  `c_start_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '生效时间',
  `c_end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '到期时间',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`),
  UNIQUE KEY `c_title` (`c_title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='代金券类型表';

-- ----------------------------
-- Records of t_market_ticket
-- ----------------------------

-- ----------------------------
-- Table structure for `t_notity_template`
-- ----------------------------
DROP TABLE IF EXISTS `t_notity_template`;
CREATE TABLE `t_notity_template` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_title` varchar(50) NOT NULL DEFAULT '' COMMENT '模板描述',
  `c_sms_template_code` varchar(50) NOT NULL DEFAULT '' COMMENT '短信模板ID',
  `c_sms_sign_name` varchar(50) NOT NULL DEFAULT '' COMMENT '短信签名',
  `c_email_subject` varchar(50) NOT NULL DEFAULT '' COMMENT '邮件主题',
  `c_web_subject` varchar(50) NOT NULL DEFAULT '' COMMENT '站内信主题',
  `c_sms_template` text COMMENT '短信发送模板',
  `c_email_template` text COMMENT '邮件发送模板',
  `c_app_template` text COMMENT 'APP推送模板',
  `c_web_template` text COMMENT '站内信模板',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1正常 2无效',
  `c_email_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '邮件状态 1正常 2无效',
  `c_sms_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '短信状态 1正常 2无效',
  `c_app_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'APP状态 1正常 2无效',
  `c_web_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '站内信状态 1正常 2无效',
  `c_type` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '消息类型',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='消息模板表';

-- ----------------------------
-- Records of t_notity_template
-- ----------------------------
INSERT INTO `t_notity_template` VALUES ('1', '注册获取验证码', 'SMS_56720212', '素食猫', '邮箱注册校验码', '', '尊敬的用户：您的手机验证码：${code}，请输入验证码完成下一步操作，如非本人操作请忽略。', '尊敬的用户：您的邮箱校验码：${code}，请输入校验码完成下一步操作，如非本人操作请忽略。', '', '', '1', '1', '1', '2', '2', '101', '0', '1489909100', '2017-03-27 11:24:12');
INSERT INTO `t_notity_template` VALUES ('2', '注册成功通知', 'SMS_56595256', '素食猫', '通过邮箱注册成功', '通过邮箱注册成功', '尊敬的${user_name}：您已成功注册会员，关注官方微信：jxsmcom，如非本人操作请忽略。', '尊敬的${user_name}：您已成功注册会员，欢迎访问官方网站：<a href=\"${website}\">${website}</a>，关注官方微信：${weixin}，如非本人操作请忽略。', '', '尊敬的${user_name}：您已成功注册会员，关注官方微信：${weixin}。', '1', '1', '1', '2', '1', '200', '0', '1489909626', '2017-03-24 16:46:18');
INSERT INTO `t_notity_template` VALUES ('3', '找回密码获取验证码', 'SMS_56720212', '素食猫', '找回密码获取验证码', '', '尊敬的用户：您的手机验证码：${code}，请输入验证码完成下一步操作，如非本人操作请忽略。', '尊敬的用户：您的邮箱校验码：${code}，请输入校验码完成下一步操作，如非本人操作请忽略。', '', '', '1', '1', '1', '2', '2', '103', '0', '1490062433', '2017-03-27 11:19:24');
INSERT INTO `t_notity_template` VALUES ('4', '手机号设置获取验证码', 'SMS_56720212', '素食猫', '', '', '尊敬的用户：您的手机验证码：${code}，请输入验证码完成下一步操作，如非本人操作请忽略。', '', '', '', '1', '2', '1', '2', '2', '104', '0', '1490344405', '2017-03-27 11:18:36');
INSERT INTO `t_notity_template` VALUES ('5', '邮箱设置获取验证码', '', '素食猫', '邮箱设置获取验证码', '', '', '尊敬的用户：您的邮箱校验码：${code}，请输入校验码完成下一步操作，如非本人操作请忽略。', '', '', '1', '1', '2', '2', '2', '105', '0', '1490344468', '2017-03-27 11:18:58');
INSERT INTO `t_notity_template` VALUES ('6', '邮箱设置成功通知', '', '素食猫', '邮箱设置成功', '邮箱设置成功', '', '尊敬的${user_name}，您的邮箱设置成功，如非本人操作请致电${phone}。', '', '尊敬的${user_name}，您的邮箱设置成功，如非本人操作请致电${phone}。', '1', '1', '2', '2', '1', '201', '0', '1490344712', '2017-03-27 11:18:13');
INSERT INTO `t_notity_template` VALUES ('7', '手机号设置成功通知', '', '素食猫', '手机号设置成功', '手机号设置成功', '', '尊敬的${user_name}，您的手机号设置成功，如非本人操作请致电${phone}。', '', '尊敬的${user_name}，您的手机号设置成功，如非本人操作请致电${phone}。', '1', '1', '2', '2', '1', '202', '0', '1490344770', '2017-03-27 10:50:00');
INSERT INTO `t_notity_template` VALUES ('8', '登录密码设置成功通知', '', '素食猫', '登录密码设置成功', '登录密码设置成功', '', '亲爱的用户${user_name}，您的登录密码设置成功，如非本人操作请致电${phone}。', '', '亲爱的用户${user_name}，您的登录密码设置成功，如非本人操作请致电${phone}。', '1', '1', '2', '2', '1', '203', '0', '1490344859', '2017-03-27 11:17:24');
INSERT INTO `t_notity_template` VALUES ('9', '支付密码设置成功通知', '', '素食猫', '支付密码设置成功', '支付密码设置成功', '', '尊敬的用户${user_name}，您的支付密码设置成功，如非本人操作请致电${phone}。', '', '尊敬的用户${user_name}，您的支付密码设置成功，如非本人操作请致电${phone}。', '1', '1', '2', '2', '1', '204', '0', '1490345033', '2017-03-27 11:16:45');

-- ----------------------------
-- Table structure for `t_oauth`
-- ----------------------------
DROP TABLE IF EXISTS `t_oauth`;
CREATE TABLE `t_oauth` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_title` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `c_oatuh_id` varchar(100) NOT NULL DEFAULT '' COMMENT '接口标识',
  `c_description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `c_logo` varchar(255) NOT NULL DEFAULT '' COMMENT 'logo',
  `c_api_key` varchar(255) NOT NULL DEFAULT '' COMMENT 'API key',
  `c_api_secret` varchar(255) NOT NULL DEFAULT '' COMMENT 'API secret 或 API id',
  `c_url` varchar(255) NOT NULL DEFAULT '' COMMENT '申请地址',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '状态 1正常 2无效',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='认证方案';

-- ----------------------------
-- Records of t_oauth
-- ----------------------------
INSERT INTO `t_oauth` VALUES ('1', '人人网', 'renren', '人人网的开放平台', 'renren.gif', '', '', 'http://www.renren.com', '1', '0');
INSERT INTO `t_oauth` VALUES ('2', 'QQ', 'qq', '腾讯的开发平台', 'qq.gif', '', '', 'http://www.qq.com', '1', '0');
INSERT INTO `t_oauth` VALUES ('3', '新浪', 'sina', '新浪微博的开发平台', 'sina.gif', '', '', 'http://www.weibo.com', '1', '0');
INSERT INTO `t_oauth` VALUES ('4', '淘宝', 'taobao', '淘宝的开放平台', 'taobao.gif', '', '', 'http://www.taobao.com', '1', '0');
INSERT INTO `t_oauth` VALUES ('5', '微信', 'wechat', '微信的开放平台', 'wechat.png', '', '', 'http://weixin.qq.com', '1', '0');

-- ----------------------------
-- Table structure for `t_oauth_user`
-- ----------------------------
DROP TABLE IF EXISTS `t_oauth_user`;
CREATE TABLE `t_oauth_user` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_oauth_name` varchar(100) NOT NULL DEFAULT '' COMMENT '第三方平台的用户唯一标识',
  `c_oauth_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'oauth表关联平台id',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '系统内部的用户id',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '绑定时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='oauth开发平台绑定用户表';

-- ----------------------------
-- Records of t_oauth_user
-- ----------------------------

-- ----------------------------
-- Table structure for `t_order`
-- ----------------------------
DROP TABLE IF EXISTS `t_order`;
CREATE TABLE `t_order` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_postcode` char(6) NOT NULL DEFAULT '000000' COMMENT '邮政编码',
  `c_mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机',
  `c_order_no` char(20) NOT NULL COMMENT '订单号',
  `c_phone` varchar(20) NOT NULL DEFAULT '' COMMENT '联系电话',
  `c_user_name` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `c_full_name` varchar(20) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `c_address` varchar(100) NOT NULL DEFAULT '' COMMENT '收货地址',
  `c_invoice_title` varchar(100) NOT NULL DEFAULT '' COMMENT '发票抬头',
  `c_trade_no` varchar(255) NOT NULL DEFAULT '' COMMENT '支付平台交易号',
  `c_check_code` varchar(255) NOT NULL DEFAULT '' COMMENT '自提方式的验证码',
  `c_user_note` varchar(1000) NOT NULL DEFAULT '' COMMENT '用户附言',
  `c_admin_note` varchar(1000) NOT NULL DEFAULT '' COMMENT '管理员备注',
  `c_card_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '代金券面值',
  `c_payable_goods_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '应付商品总金额',
  `c_paid_goods_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实付商品总金额',
  `c_payable_freight_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '应付运费',
  `c_paid_freight_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实付运费',
  `c_insured_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '保价金额',
  `c_pay_fee_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付手续费',
  `c_tax_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '税金',
  `c_promotion_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销优惠金额',
  `c_admin_discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '平台增减金额 例如 折扣 去零头 减去金额加上负号',
  `c_payable_order_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '应付订单总金额',
  `c_order_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实付订单总金额',
  `c_refundment_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '退款金额',
  `c_delivery_amount_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '配送费用计算方式 1配送方式系统计算 2手工输入',
  `c_comment_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '是否评论 1已评论 2未评论',
  `c_order_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '订单状态',
  `c_pay_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '支付状态 1已支付 2待支付',
  `c_point_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '积分状态 1已发放 2未发放 3已退还',
  `c_distribution_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '配送状态 1已发货 2未发货 3部分发货',
  `c_order_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '订单类型 1普通订单 2团购订单 3限时抢购',
  `c_create_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '来源类型 1PC 2H5 3IOS 4Andriod 8其他 9平台',
  `c_is_checkout` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '营销联盟结算状态 1已结算 2未结算',
  `c_is_invoice` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '发票 1索要 2不索要',
  `c_accept_time` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户收货时间段',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单商品总重量',
  `c_payment_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付方式ID 默认0货到付款',
  `c_delivery_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '配送方式ID',
  `c_card_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '代金券ID',
  `c_province_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '省份ID',
  `c_city_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '市级ID',
  `c_area_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '地区ID',
  `c_order_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单商品种类数量',
  `c_order_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单商品总重量',
  `c_exp` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单可获取的经验值',
  `c_point` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单可获取的积分',
  `c_takeself_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '自提点ID',
  `c_active_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '促销活动ID',
  `c_union_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '营销联盟ID',
  `c_point_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分最后变动时间',
  `c_refundment_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '退款时间',
  `c_cancel_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '取消时间',
  `c_comment_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论时间',
  `c_finish_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '完成时间',
  `c_send_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发货时间',
  `c_pay_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '付款时间',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表';

-- ----------------------------
-- Records of t_order
-- ----------------------------

-- ----------------------------
-- Table structure for `t_order_goods`
-- ----------------------------
DROP TABLE IF EXISTS `t_order_goods`;
CREATE TABLE `t_order_goods` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_order_no` char(20) NOT NULL COMMENT '订单号',
  `c_number` varchar(50) NOT NULL DEFAULT '' COMMENT '商品货号',
  `c_title` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名称',
  `c_picture` varchar(255) NOT NULL DEFAULT '' COMMENT '商品图片',
  `c_sell_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品原价',
  `c_real_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实付金额',
  `c_is_send` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '是否已发货 1已发货 2未发货 3已退款',
  `c_exp` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '增加的经验',
  `c_point` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '增加的积分',
  `c_goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `c_delivery_doc_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '配送单ID',
  `c_union_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '营销联盟ID',
  `c_count` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '商品数量',
  `c_weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '重量',
  `c_order_id` int(10) unsigned NOT NULL COMMENT '订单ID',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单商品表';

-- ----------------------------
-- Records of t_order_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `t_order_log`
-- ----------------------------
DROP TABLE IF EXISTS `t_order_log`;
CREATE TABLE `t_order_log` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_order_no` char(20) NOT NULL DEFAULT '' COMMENT '订单号',
  `c_user_name` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `c_admin_name` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员用户名',
  `c_note` varchar(1000) NOT NULL DEFAULT '' COMMENT '备注',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '状态 1成功 2失败',
  `c_action_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '动作类型',
  `c_order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `c_admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单日志表';

-- ----------------------------
-- Records of t_order_log
-- ----------------------------

-- ----------------------------
-- Table structure for `t_payment`
-- ----------------------------
DROP TABLE IF EXISTS `t_payment`;
CREATE TABLE `t_payment` (
  `c_id` int(10) unsigned NOT NULL COMMENT '支付方式ID',
  `c_pay_id` varchar(50) NOT NULL DEFAULT '' COMMENT '支付标识',
  `c_title` varchar(50) NOT NULL DEFAULT '' COMMENT '支付名称',
  `c_logo` varchar(255) NOT NULL DEFAULT '' COMMENT '支付方式logo图片路径',
  `c_url` varchar(255) NOT NULL DEFAULT '' COMMENT '官方网址',
  `c_description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `c_content` text COMMENT '支付说明',
  `c_poundage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '手续费',
  `c_poundage_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '手续费方式 1按商品总额的百分比 2按固定金额',
  `c_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型 1线上 2线下',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '安装状态 1正常 2无效',
  `c_client_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '客户端类型 1PC端 2移动端 3通用',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='支付方式表';

-- ----------------------------
-- Records of t_payment
-- ----------------------------
INSERT INTO `t_payment` VALUES ('0', 'offline', '线下支付', 'pay_offline.gif', '', '线下付款结算', '', '0.00', '0', '2', '1', '3', '98', '0', '2017-02-21 20:29:49');
INSERT INTO `t_payment` VALUES ('1', 'balance', '预存款支付', 'pay_deposit.gif', '', '预存款是客户在您网站上的虚拟资金帐户，在个人用户中心可以充值获得。', '', '0.00', '1', '1', '1', '1', '99', '0', '2017-03-30 09:40:06');
INSERT INTO `t_payment` VALUES ('2', 'alipay_direct', '支付宝即时到帐', 'pay_alipay.gif', 'http://www.alipay.com', '即时到帐支付方式，买家的交易资金直接打入卖家支付宝账户，快速回笼交易资金。', '', '0.00', '1', '1', '1', '1', '96', '0', '2017-03-08 21:50:02');
INSERT INTO `t_payment` VALUES ('3', 'alipay_wap', '支付宝手机网站支付', 'pay_wap_alipay.png', 'http://www.alipay.com', '支付宝的手机网站支付方式。需要企业账号单独签约设置密钥。不能与电脑版本的支付宝混用。', '', '0.00', '1', '1', '1', '2', '95', '0', '2017-03-08 21:16:53');
INSERT INTO `t_payment` VALUES ('4', 'wechat_wap', '微信移动支付', 'pay_wap_wechat.png', 'https://mp.weixin.qq.com', '微信商城专用支付接口。必须在微信客户端中使用。', '', '0.00', '1', '1', '1', '2', '94', '0', '2017-03-08 21:17:00');
INSERT INTO `t_payment` VALUES ('5', 'wechat_scan', '微信二维码支付', 'pay_scan_wechat.gif', 'https://mp.weixin.qq.com', '微信二维码支付接口。', '支付说明', '0.00', '1', '1', '1', '1', '93', '0', '2017-03-08 21:57:19');

-- ----------------------------
-- Table structure for `t_refundment_doc`
-- ----------------------------
DROP TABLE IF EXISTS `t_refundment_doc`;
CREATE TABLE `t_refundment_doc` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '退款单ID',
  `c_order_no` char(20) NOT NULL DEFAULT '' COMMENT '订单号',
  `c_admin_name` varchar(20) NOT NULL DEFAULT '' COMMENT '管理员用户名',
  `c_user_name` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `c_note` varchar(1000) NOT NULL DEFAULT '' COMMENT '备注',
  `c_reply` varchar(1000) NOT NULL DEFAULT '' COMMENT '处理意见',
  `c_content` varchar(1000) NOT NULL DEFAULT '' COMMENT '申请退款原因',
  `c_order_goods_id` varchar(1000) NOT NULL DEFAULT '' COMMENT '订单与商品关联ID集合',
  `c_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '退款金额',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '退款状态 1退款成功 2申请退款 3退款失败',
  `c_way` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '退款流向 1用户余额 2其他方式',
  `c_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '退款计算方式 1系统计算 2手动输入',
  `c_order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `c_admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_dispose_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理时间',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='退款单';

-- ----------------------------
-- Records of t_refundment_doc
-- ----------------------------

-- ----------------------------
-- Table structure for `t_search`
-- ----------------------------
DROP TABLE IF EXISTS `t_search`;
CREATE TABLE `t_search` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `c_keyword` varchar(255) NOT NULL DEFAULT '' COMMENT '搜索关键字',
  `c_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '搜索类型 1商品 2内容',
  `c_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '搜索次数',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='全站搜索关键字';

-- ----------------------------
-- Records of t_search
-- ----------------------------

-- ----------------------------
-- Table structure for `t_sms_log`
-- ----------------------------
DROP TABLE IF EXISTS `t_sms_log`;
CREATE TABLE `t_sms_log` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `c_sms_request_id` varchar(50) NOT NULL DEFAULT '' COMMENT '发送短信的消息ID',
  `c_sms_model` varchar(100) NOT NULL DEFAULT '' COMMENT '返回结果',
  `c_sms_code` varchar(100) NOT NULL DEFAULT '' COMMENT '错误码',
  `c_sms_msg` varchar(1000) NOT NULL DEFAULT '' COMMENT '错误描述',
  `c_param` varchar(1000) NOT NULL DEFAULT '' COMMENT '模板替换参数  JSON格式',
  `c_body` varchar(1000) NOT NULL DEFAULT '' COMMENT '短信内容',
  `c_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '消息类型',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '3' COMMENT '状态 1成功 2失败 3未发送',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_send_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '预约发送时间 可以用去定时发送',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='短信发送日志表';

-- ----------------------------
-- Records of t_sms_log
-- ----------------------------

-- ----------------------------
-- Table structure for `t_system_log`
-- ----------------------------
DROP TABLE IF EXISTS `t_system_log`;
CREATE TABLE `t_system_log` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_admin_name` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员操作用户名',
  `c_note` text COMMENT '日志内容',
  `c_admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `c_login_ip` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统日志表';

-- ----------------------------
-- Records of t_system_log
-- ----------------------------

-- ----------------------------
-- Table structure for `t_takeself`
-- ----------------------------
DROP TABLE IF EXISTS `t_takeself`;
CREATE TABLE `t_takeself` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `c_title` varchar(20) NOT NULL DEFAULT '' COMMENT '名称',
  `c_phone` varchar(50) NOT NULL DEFAULT '' COMMENT '电话',
  `c_address` varchar(255) NOT NULL DEFAULT '' COMMENT '街道地址',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1正常 2无效',
  `c_province_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '省份ID',
  `c_city_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '市级ID',
  `c_area_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '地区ID',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品物流自提地点';

-- ----------------------------
-- Records of t_takeself
-- ----------------------------

-- ----------------------------
-- Table structure for `t_upload`
-- ----------------------------
DROP TABLE IF EXISTS `t_upload`;
CREATE TABLE `t_upload` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_title` varchar(50) NOT NULL DEFAULT '' COMMENT '原文件名',
  `c_path` varchar(255) NOT NULL DEFAULT '' COMMENT '上传路径',
  `c_extension` varchar(5) NOT NULL DEFAULT '' COMMENT '扩展名',
  `c_user_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户类型 1后台 2用户',
  `c_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '附件类型 1图片 2附件',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '状态 2未使用 1正常',
  `c_width` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '图片长度',
  `c_height` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '图片高度',
  `c_object_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '对象ID',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='附件上传表';

-- ----------------------------
-- Records of t_upload
-- ----------------------------

-- ----------------------------
-- Table structure for `t_user`
-- ----------------------------
DROP TABLE IF EXISTS `t_user`;
CREATE TABLE `t_user` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `c_login_random` char(4) NOT NULL DEFAULT '' COMMENT '登录秘密随机字符串',
  `c_pay_random` char(4) NOT NULL DEFAULT '' COMMENT '支付秘密随机字符串',
  `c_mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `c_login_password` char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `c_pay_password` char(32) NOT NULL DEFAULT '' COMMENT '支付密码',
  `c_auth_key` char(32) NOT NULL DEFAULT '' COMMENT 'cookie用户认证',
  `c_access_token` char(43) NOT NULL DEFAULT '' COMMENT 'api 通过access_token参数登录',
  `c_user_name` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `c_email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `c_group_id` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '用户组ID',
  `c_mobile_verify` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '手机验证 1已验证 2未绑定 3待验证',
  `c_email_verify` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '邮箱验证 1已验证 2未绑定 3待验证',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '用户登录状态 1正常 2无效',
  `c_create_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '来源类型 1PC 2H5 3IOS 4Andriod 8其他 9平台',
  `c_login_total` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `c_last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `c_reg_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册日期',
  `c_reg_ip` int(11) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `c_last_ip` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`),
  KEY `c_reg_date` (`c_reg_date`),
  KEY `c_mobile` (`c_mobile`),
  KEY `c_email` (`c_email`),
  KEY `c_user_name` (`c_user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户信息表';

-- ----------------------------
-- Records of t_user
-- ----------------------------

-- ----------------------------
-- Table structure for `t_user_acount`
-- ----------------------------
DROP TABLE IF EXISTS `t_user_acount`;
CREATE TABLE `t_user_acount` (
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '账户预存款',
  `c_frozen_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '冻结金额',
  `c_exp` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '经验值',
  `c_point` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1正常 2无效',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_user_id`),
  UNIQUE KEY `c_user_id` (`c_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户账户金额表';

-- ----------------------------
-- Records of t_user_acount
-- ----------------------------

-- ----------------------------
-- Table structure for `t_user_acount_log`
-- ----------------------------
DROP TABLE IF EXISTS `t_user_acount_log`;
CREATE TABLE `t_user_acount_log` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_order_no` char(20) NOT NULL DEFAULT '' COMMENT '订单号',
  `c_admin_name` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员用户名',
  `c_note` varchar(255) NOT NULL DEFAULT '' COMMENT '备注说明',
  `c_amount_old` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '账户修改前金额',
  `c_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '修改金额',
  `c_amount_new` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '账户修改后金额',
  `c_frozen_amount_old` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '冻结账户修改前金额',
  `c_frozen_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '修改金额',
  `c_frozen_amount_new` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '冻结账户修改后金额',
  `c_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '日志类型 1进账 2出账',
  `c_note_type` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '备注类型',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `c_order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户账户金额变动记录表';

-- ----------------------------
-- Records of t_user_acount_log
-- ----------------------------

-- ----------------------------
-- Table structure for `t_user_address`
-- ----------------------------
DROP TABLE IF EXISTS `t_user_address`;
CREATE TABLE `t_user_address` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_postcode` char(6) NOT NULL DEFAULT '000000' COMMENT '邮政编码',
  `c_mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `c_full_name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `c_phone` varchar(50) NOT NULL DEFAULT '' COMMENT '电话',
  `c_email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `c_address` varchar(255) NOT NULL DEFAULT '' COMMENT '街道地址',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1正常 2无效',
  `c_is_default` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '是否为默认发送地址 1默认 2非默认',
  `c_is_delete` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '删除状态 1正常 2删除 3彻底删除',
  `c_province_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '省份ID',
  `c_city_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '市级ID',
  `c_area_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '地区ID',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`),
  KEY `c_user_id` (`c_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户收货地址表';

-- ----------------------------
-- Records of t_user_address
-- ----------------------------

-- ----------------------------
-- Table structure for `t_user_bank`
-- ----------------------------
DROP TABLE IF EXISTS `t_user_bank`;
CREATE TABLE `t_user_bank` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_full_name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `c_account` varchar(20) NOT NULL DEFAULT '' COMMENT '账户号',
  `c_account_bank` varchar(50) NOT NULL DEFAULT '' COMMENT '开户行',
  `c_account_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '提现方式 1银行卡 2支付宝 3微信',
  `c_is_delete` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '删除状态 1正常 2删除 3彻底删除',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`),
  KEY `c_user_id` (`c_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户银行卡';

-- ----------------------------
-- Records of t_user_bank
-- ----------------------------

-- ----------------------------
-- Table structure for `t_user_card`
-- ----------------------------
DROP TABLE IF EXISTS `t_user_card`;
CREATE TABLE `t_user_card` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_card_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '卡号ID',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户代金券表';

-- ----------------------------
-- Records of t_user_card
-- ----------------------------

-- ----------------------------
-- Table structure for `t_user_group`
-- ----------------------------
DROP TABLE IF EXISTS `t_user_group`;
CREATE TABLE `t_user_group` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组ID',
  `c_title` varchar(20) NOT NULL COMMENT '用户组名称',
  `c_icon` varchar(50) NOT NULL DEFAULT '' COMMENT '用户组等级图标',
  `c_discount` tinyint(3) unsigned NOT NULL DEFAULT '100' COMMENT '折扣率',
  `c_minexp` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最小经验值',
  `c_maxexp` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最大经验值',
  `c_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户组';

-- ----------------------------
-- Records of t_user_group
-- ----------------------------
INSERT INTO `t_user_group` VALUES ('1', '默认用户组', '1.png', '100', '0', '100', '0', '1487214494', '2017-03-28 10:16:26');
INSERT INTO `t_user_group` VALUES ('2', '9折用户组', '2.png', '90', '100', '1000', '0', '1487897852', '2017-03-28 10:16:37');

-- ----------------------------
-- Table structure for `t_user_login_log`
-- ----------------------------
DROP TABLE IF EXISTS `t_user_login_log`;
CREATE TABLE `t_user_login_log` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_login_name` varchar(20) NOT NULL DEFAULT '' COMMENT '登录名',
  `c_login_password` varchar(20) NOT NULL DEFAULT '' COMMENT '登录密码',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '登录状态 1成功 2失败',
  `c_create_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '来源类型 1PC 2H5 3IOS 4Andriod 8其他 9平台',
  `c_login_ip` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户登录日志表';

-- ----------------------------
-- Records of t_user_login_log
-- ----------------------------

-- ----------------------------
-- Table structure for `t_user_message`
-- ----------------------------
DROP TABLE IF EXISTS `t_user_message`;
CREATE TABLE `t_user_message` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_title` varchar(50) NOT NULL DEFAULT '' COMMENT '主题',
  `c_body` varchar(1000) NOT NULL DEFAULT '' COMMENT '内容',
  `c_type` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '信息类型 1系统信息 2站内信',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户站内信';

-- ----------------------------
-- Records of t_user_message
-- ----------------------------

-- ----------------------------
-- Table structure for `t_user_operation_log`
-- ----------------------------
DROP TABLE IF EXISTS `t_user_operation_log`;
CREATE TABLE `t_user_operation_log` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_user_name` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `c_route` varchar(100) NOT NULL DEFAULT '' COMMENT '路由名称',
  `c_data_before` text COMMENT '更新或删除之前的数据',
  `c_data_add` text COMMENT '新增的数据',
  `c_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '操作类型 1新增 2编辑 3删除',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 1成功 2失败',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_object_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '操作的对象ID',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户操作日志表';

-- ----------------------------
-- Records of t_user_operation_log
-- ----------------------------

-- ----------------------------
-- Table structure for `t_user_point_log`
-- ----------------------------
DROP TABLE IF EXISTS `t_user_point_log`;
CREATE TABLE `t_user_point_log` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_order_no` char(20) NOT NULL DEFAULT '' COMMENT '订单号',
  `c_admin_name` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员用户名',
  `c_note` varchar(255) NOT NULL DEFAULT '' COMMENT '备注说明',
  `c_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '日志类型 1进账 2出账',
  `c_point_old` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改前积分',
  `c_point` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改积分',
  `c_point_new` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改后积分',
  `c_exp_old` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改前经验值',
  `c_exp` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改经验值',
  `c_exp_new` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改后经验值',
  `c_note_type` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '备注类型',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `c_order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户积分经验日志表';

-- ----------------------------
-- Records of t_user_point_log
-- ----------------------------

-- ----------------------------
-- Table structure for `t_user_profile`
-- ----------------------------
DROP TABLE IF EXISTS `t_user_profile`;
CREATE TABLE `t_user_profile` (
  `c_user_id` int(10) unsigned NOT NULL COMMENT '用户ID',
  `c_qq` varchar(15) NOT NULL DEFAULT '' COMMENT 'QQ',
  `c_full_name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `c_head` varchar(50) NOT NULL DEFAULT '' COMMENT '头像',
  `c_nick_name` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `c_phone` varchar(50) NOT NULL DEFAULT '' COMMENT '电话',
  `c_address` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `c_sign` varchar(255) NOT NULL DEFAULT '' COMMENT '签名',
  `c_sex` tinyint(1) unsigned NOT NULL DEFAULT '3' COMMENT '性别 1男 2女 3保密',
  `c_province_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '省份ID',
  `c_city_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '市级ID',
  `c_area_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '地区ID',
  `c_birthday` int(11) NOT NULL DEFAULT '0' COMMENT '生日',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户信息表';

-- ----------------------------
-- Records of t_user_profile
-- ----------------------------

-- ----------------------------
-- Table structure for `t_user_recharge`
-- ----------------------------
DROP TABLE IF EXISTS `t_user_recharge`;
CREATE TABLE `t_user_recharge` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_recharge_no` varchar(50) NOT NULL DEFAULT '' COMMENT '充值单号',
  `c_content` varchar(1000) NOT NULL DEFAULT '' COMMENT '附言',
  `c_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '充值金额',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '充值状态 1成功 2失败',
  `c_payment_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '充值方式ID',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='在线充值表';

-- ----------------------------
-- Records of t_user_recharge
-- ----------------------------

-- ----------------------------
-- Table structure for `t_user_withdrawals`
-- ----------------------------
DROP TABLE IF EXISTS `t_user_withdrawals`;
CREATE TABLE `t_user_withdrawals` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `c_full_name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `c_reply_content` varchar(1000) NOT NULL DEFAULT '' COMMENT '回复附言',
  `c_content` varchar(1000) NOT NULL DEFAULT '' COMMENT '附言',
  `c_account` varchar(20) NOT NULL DEFAULT '' COMMENT '账户号',
  `c_account_bank` varchar(50) NOT NULL DEFAULT '' COMMENT '开户行',
  `c_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `c_is_delete` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '删除状态 1正常 2删除 3彻底删除',
  `c_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '状态 提现成功 2待审核 3审核通过转账中 4已拒绝',
  `c_account_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '提现方式 1银行卡 2支付宝 3微信',
  `c_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `c_create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `c_update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='提现记录';

-- ----------------------------
-- Records of t_user_withdrawals
-- ----------------------------
