# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.52-0ubuntu0.14.04.1)
# Database: lygit
# Generation Time: 2016-12-13 12:25:36 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table ly_admin_access
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ly_admin_access`;

CREATE TABLE `ly_admin_access` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `group` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '管理员用户组',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台管理员与用户组对应关系表';

LOCK TABLES `ly_admin_access` WRITE;
/*!40000 ALTER TABLE `ly_admin_access` DISABLE KEYS */;

INSERT INTO `ly_admin_access` (`id`, `uid`, `group`, `create_time`, `update_time`, `sort`, `status`)
VALUES
	(1,1,1,1438651748,1438651748,0,1);

/*!40000 ALTER TABLE `ly_admin_access` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ly_admin_addon
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ly_admin_addon`;

CREATE TABLE `ly_admin_addon` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(32) DEFAULT NULL COMMENT '插件名或标识',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '中文名',
  `description` text NOT NULL COMMENT '插件描述',
  `config` text COMMENT '配置',
  `author` varchar(32) NOT NULL DEFAULT '' COMMENT '作者',
  `version` varchar(8) NOT NULL DEFAULT '' COMMENT '版本号',
  `adminlist` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台列表',
  `type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '插件类型',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='插件表';

LOCK TABLES `ly_admin_addon` WRITE;
/*!40000 ALTER TABLE `ly_admin_addon` DISABLE KEYS */;

INSERT INTO `ly_admin_addon` (`id`, `name`, `title`, `description`, `config`, `author`, `version`, `adminlist`, `type`, `create_time`, `update_time`, `sort`, `status`)
VALUES
	(1,'RocketToTop','小火箭返回顶部','小火箭返回顶部','{\"status\":\"1\"}','OpenCMF','1.3.0',0,0,1476718525,1476718525,0,1);

/*!40000 ALTER TABLE `ly_admin_addon` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ly_admin_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ly_admin_config`;

CREATE TABLE `ly_admin_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '配置标题',
  `name` varchar(32) DEFAULT NULL COMMENT '配置名称',
  `value` text NOT NULL COMMENT '配置值',
  `group` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组',
  `type` varchar(16) NOT NULL DEFAULT '' COMMENT '配置类型',
  `options` varchar(255) NOT NULL DEFAULT '' COMMENT '配置额外值',
  `tip` varchar(100) NOT NULL DEFAULT '' COMMENT '配置说明',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统配置表';

LOCK TABLES `ly_admin_config` WRITE;
/*!40000 ALTER TABLE `ly_admin_config` DISABLE KEYS */;

INSERT INTO `ly_admin_config` (`id`, `title`, `name`, `value`, `group`, `type`, `options`, `tip`, `create_time`, `update_time`, `sort`, `status`)
VALUES
	(1,'站点开关','TOGGLE_WEB_SITE','1',1,'select','0:关闭\r\n1:开启','站点关闭后将不能访问',1378898976,1406992386,1,1),
	(2,'网站标题','WEB_SITE_TITLE','lygit',1,'text','','网站标题前台显示标题',1378898976,1379235274,2,1),
	(3,'网站口号','WEB_SITE_SLOGAN','lygit轻量级git私有化部署系统',1,'text','','网站口号、宣传标语、一句话介绍',1434081649,1434081649,3,1),
	(4,'网站LOGO','WEB_SITE_LOGO','',1,'picture','','网站LOGO',1407003397,1407004692,4,1),
	(5,'网站反色LOGO','WEB_SITE_LOGO_INVERSE','',1,'picture','','匹配深色背景上的LOGO',1476700797,1476700797,5,1),
	(6,'网站描述','WEB_SITE_DESCRIPTION','lygit是一套轻量级git私有化部署系统，追求简单、高效、卓越。',1,'textarea','','网站搜索引擎描述',1378898976,1379235841,6,1),
	(7,'网站关键字','WEB_SITE_KEYWORD','lygit、南京科斯克网络科技',1,'textarea','','网站搜索引擎关键字',1378898976,1381390100,7,1),
	(8,'版权信息','WEB_SITE_COPYRIGHT','Copyright © 南京科斯克网络科技有限公司 All rights reserved.',1,'text','','设置在网站底部显示的版权信息，如“版权所有 © 2014-2015 科斯克网络科技”',1406991855,1406992583,8,1),
	(9,'网站备案号','WEB_SITE_ICP','苏ICP备1502009号',1,'text','','设置在网站底部显示的备案号，如“苏ICP备1502009号\"',1378900335,1415983236,9,1),
	(10,'站点统计','WEB_SITE_STATISTICS','',1,'textarea','','支持百度、Google、cnzz等所有Javascript的统计代码',1378900335,1415983236,10,1),
	(11,'文件上传大小','UPLOAD_FILE_SIZE','10',2,'num','','文件上传大小单位：MB',1428681031,1428681031,1,1),
	(12,'图片上传大小','UPLOAD_IMAGE_SIZE','2',2,'num','','图片上传大小单位：MB',1428681071,1428681071,2,1),
	(13,'后台多标签','ADMIN_TABS','0',2,'radio','0:关闭\r\n1:开启','',1453445526,1453445526,3,1),
	(14,'分页数量','ADMIN_PAGE_ROWS','10',2,'num','','分页时每页的记录数',1434019462,1434019481,4,1),
	(15,'后台主题','ADMIN_THEME','admin',2,'select','admin:默认主题\r\naliyun:阿里云风格','后台界面主题',1436678171,1436690570,5,1),
	(16,'导航分组','NAV_GROUP_LIST','top:顶部导航\r\nmain:主导航\r\nbottom:底部导航',2,'array','','导航分组',1458382037,1458382061,6,1),
	(17,'配置分组','CONFIG_GROUP_LIST','1:基本\r\n2:系统\r\n3:开发\r\n4:部署',2,'array','','配置分组',1379228036,1426930700,7,1),
	(18,'开发模式','DEVELOP_MODE','1',3,'select','1:开启\r\n0:关闭','开发模式下会显示菜单管理、配置管理、数据字典等开发者工具',1432393583,1432393583,1,1),
	(19,'是否显示页面Trace','SHOW_PAGE_TRACE','0',3,'select','0:关闭\r\n1:开启','是否显示页面Trace信息',1387165685,1387165685,2,1),
	(21,'URL模式','URL_MODEL','3',4,'select','1:PATHINFO模式\r\n2:REWRITE模式\r\n3:兼容模式','',1438423248,1438423248,1,1),
	(22,'默认模块','DEFAULT_MODULE','Git',4,'select','callback:D(\'Admin/Module\')->getNameList','',1471458914,1471458914,4,1),
	(23,'默认模块布局','DEFAULT_MODULE_LAYOUT','1',4,'radio','1:开启\r\n0:关闭','启用默认模块的布局layout全局生效',1481267362,1481267389,4,1);

/*!40000 ALTER TABLE `ly_admin_config` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ly_admin_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ly_admin_group`;

CREATE TABLE `ly_admin_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '部门ID',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上级部门ID',
  `title` varchar(31) NOT NULL DEFAULT '' COMMENT '部门名称',
  `icon` varchar(31) NOT NULL DEFAULT '' COMMENT '图标',
  `menu_auth` text NOT NULL COMMENT '权限列表',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='部门信息表';

LOCK TABLES `ly_admin_group` WRITE;
/*!40000 ALTER TABLE `ly_admin_group` DISABLE KEYS */;

INSERT INTO `ly_admin_group` (`id`, `pid`, `title`, `icon`, `menu_auth`, `create_time`, `update_time`, `sort`, `status`)
VALUES
	(1,0,'超级管理员','','',1426881003,1427552428,0,1);

/*!40000 ALTER TABLE `ly_admin_group` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ly_admin_hook
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ly_admin_hook`;

CREATE TABLE `ly_admin_hook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '钩子ID',
  `name` varchar(32) DEFAULT NULL COMMENT '钩子名称',
  `description` text NOT NULL COMMENT '描述',
  `addons` varchar(255) NOT NULL DEFAULT '' COMMENT '钩子挂载的插件',
  `type` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='钩子表';

LOCK TABLES `ly_admin_hook` WRITE;
/*!40000 ALTER TABLE `ly_admin_hook` DISABLE KEYS */;

INSERT INTO `ly_admin_hook` (`id`, `name`, `description`, `addons`, `type`, `create_time`, `update_time`, `status`)
VALUES
	(1,'AdminIndex','后台首页小工具','后台首页小工具',1,1446522155,1446522155,1),
	(2,'FormBuilderExtend','FormBuilder类型扩展Builder','',1,1447831268,1447831268,1),
	(3,'UploadFile','上传文件钩子','',1,1407681961,1407681961,1),
	(4,'PageHeader','页面header钩子，一般用于加载插件CSS文件和代码','',1,1407681961,1407681961,1),
	(5,'PageFooter','页面footer钩子，一般用于加载插件CSS文件和代码','RocketToTop',1,1407681961,1407681961,1),
	(6,'CommonHook','通用钩子，自定义用途，一般用来定制特殊功能','',1,1456147822,1456147822,1);

/*!40000 ALTER TABLE `ly_admin_hook` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ly_admin_module
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ly_admin_module`;

CREATE TABLE `ly_admin_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(31) DEFAULT NULL COMMENT '名称',
  `title` varchar(63) NOT NULL DEFAULT '' COMMENT '标题',
  `logo` varchar(63) NOT NULL DEFAULT '' COMMENT '图片图标',
  `icon` varchar(31) NOT NULL DEFAULT '' COMMENT '字体图标',
  `icon_color` varchar(7) NOT NULL DEFAULT '' COMMENT '字体图标颜色',
  `description` varchar(127) NOT NULL DEFAULT '' COMMENT '描述',
  `developer` varchar(31) NOT NULL DEFAULT '' COMMENT '开发者',
  `version` varchar(7) NOT NULL DEFAULT '' COMMENT '版本',
  `user_nav` text NOT NULL COMMENT '个人中心导航',
  `config` text NOT NULL COMMENT '配置',
  `admin_menu` text NOT NULL COMMENT '菜单节点',
  `is_system` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否允许卸载',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模块功能表';

LOCK TABLES `ly_admin_module` WRITE;
/*!40000 ALTER TABLE `ly_admin_module` DISABLE KEYS */;

INSERT INTO `ly_admin_module` (`id`, `name`, `title`, `logo`, `icon`, `icon_color`, `description`, `developer`, `version`, `user_nav`, `config`, `admin_menu`, `is_system`, `create_time`, `update_time`, `sort`, `status`)
VALUES
	(1,'Admin','系统','','fa fa-cog','#3CA6F1','核心系统','南京科斯克网络科技有限公司','1.1.0','','','{\"1\":{\"pid\":\"0\",\"title\":\"\\u7cfb\\u7edf\",\"icon\":\"fa fa-cog\",\"level\":\"system\",\"id\":\"1\"},\"2\":{\"pid\":\"1\",\"title\":\"\\u7cfb\\u7edf\\u529f\\u80fd\",\"icon\":\"fa fa-folder-open-o\",\"id\":\"2\"},\"3\":{\"pid\":\"2\",\"title\":\"\\u7cfb\\u7edf\\u8bbe\\u7f6e\",\"icon\":\"fa fa-wrench\",\"url\":\"Admin\\/Config\\/group\",\"id\":\"3\"},\"4\":{\"pid\":\"3\",\"title\":\"\\u4fee\\u6539\\u8bbe\\u7f6e\",\"url\":\"Admin\\/Config\\/groupSave\",\"id\":\"4\"},\"5\":{\"pid\":\"2\",\"title\":\"\\u5bfc\\u822a\\u7ba1\\u7406\",\"icon\":\"fa fa-map-signs\",\"url\":\"Admin\\/Nav\\/index\",\"id\":\"5\"},\"6\":{\"pid\":\"5\",\"title\":\"\\u65b0\\u589e\",\"url\":\"Admin\\/Nav\\/add\",\"id\":\"6\"},\"7\":{\"pid\":\"5\",\"title\":\"\\u7f16\\u8f91\",\"url\":\"Admin\\/Nav\\/edit\",\"id\":\"7\"},\"8\":{\"pid\":\"5\",\"title\":\"\\u8bbe\\u7f6e\\u72b6\\u6001\",\"url\":\"Admin\\/Nav\\/setStatus\",\"id\":\"8\"},\"13\":{\"pid\":\"2\",\"title\":\"\\u914d\\u7f6e\\u7ba1\\u7406\",\"icon\":\"fa fa-cogs\",\"url\":\"Admin\\/Config\\/index\",\"id\":\"13\"},\"14\":{\"pid\":\"13\",\"title\":\"\\u65b0\\u589e\",\"url\":\"Admin\\/Config\\/add\",\"id\":\"14\"},\"15\":{\"pid\":\"13\",\"title\":\"\\u7f16\\u8f91\",\"url\":\"Admin\\/Config\\/edit\",\"id\":\"15\"},\"16\":{\"pid\":\"13\",\"title\":\"\\u8bbe\\u7f6e\\u72b6\\u6001\",\"url\":\"Admin\\/Config\\/setStatus\",\"id\":\"16\"},\"17\":{\"pid\":\"2\",\"title\":\"\\u4e0a\\u4f20\\u7ba1\\u7406\",\"icon\":\"fa fa-upload\",\"url\":\"Admin\\/Upload\\/index\",\"id\":\"17\"},\"18\":{\"pid\":\"17\",\"title\":\"\\u4e0a\\u4f20\\u6587\\u4ef6\",\"url\":\"Admin\\/Upload\\/upload\",\"id\":\"18\"},\"19\":{\"pid\":\"17\",\"title\":\"\\u5220\\u9664\\u6587\\u4ef6\",\"url\":\"Admin\\/Upload\\/delete\",\"id\":\"19\"},\"20\":{\"pid\":\"17\",\"title\":\"\\u8bbe\\u7f6e\\u72b6\\u6001\",\"url\":\"Admin\\/Upload\\/setStatus\",\"id\":\"20\"},\"21\":{\"pid\":\"17\",\"title\":\"\\u4e0b\\u8f7d\\u8fdc\\u7a0b\\u56fe\\u7247\",\"url\":\"Admin\\/Upload\\/downremoteimg\",\"id\":\"21\"},\"22\":{\"pid\":\"17\",\"title\":\"\\u6587\\u4ef6\\u6d4f\\u89c8\",\"url\":\"Admin\\/Upload\\/fileManager\",\"id\":\"22\"},\"23\":{\"pid\":\"1\",\"title\":\"\\u7cfb\\u7edf\\u6743\\u9650\",\"icon\":\"fa fa-folder-open-o\",\"id\":\"23\"},\"24\":{\"pid\":\"23\",\"title\":\"\\u7528\\u6237\\u7ba1\\u7406\",\"icon\":\"fa fa-user\",\"url\":\"Admin\\/User\\/index\",\"id\":\"24\"},\"25\":{\"pid\":\"24\",\"title\":\"\\u65b0\\u589e\",\"url\":\"Admin\\/User\\/add\",\"id\":\"25\"},\"26\":{\"pid\":\"24\",\"title\":\"\\u7f16\\u8f91\",\"url\":\"Admin\\/User\\/edit\",\"id\":\"26\"},\"27\":{\"pid\":\"24\",\"title\":\"\\u8bbe\\u7f6e\\u72b6\\u6001\",\"url\":\"Admin\\/User\\/setStatus\",\"id\":\"27\"},\"28\":{\"pid\":\"23\",\"title\":\"\\u7ba1\\u7406\\u5458\\u7ba1\\u7406\",\"icon\":\"fa fa-lock\",\"url\":\"Admin\\/Access\\/index\",\"id\":\"28\"},\"29\":{\"pid\":\"28\",\"title\":\"\\u65b0\\u589e\",\"url\":\"Admin\\/Access\\/add\",\"id\":\"29\"},\"30\":{\"pid\":\"28\",\"title\":\"\\u7f16\\u8f91\",\"url\":\"Admin\\/Access\\/edit\",\"id\":\"30\"},\"31\":{\"pid\":\"28\",\"title\":\"\\u8bbe\\u7f6e\\u72b6\\u6001\",\"url\":\"Admin\\/Access\\/setStatus\",\"id\":\"31\"},\"32\":{\"pid\":\"23\",\"title\":\"\\u7528\\u6237\\u7ec4\\u7ba1\\u7406\",\"icon\":\"fa fa-sitemap\",\"url\":\"Admin\\/Group\\/index\",\"id\":\"32\"},\"33\":{\"pid\":\"32\",\"title\":\"\\u65b0\\u589e\",\"url\":\"Admin\\/Group\\/add\",\"id\":\"33\"},\"34\":{\"pid\":\"32\",\"title\":\"\\u7f16\\u8f91\",\"url\":\"Admin\\/Group\\/edit\",\"id\":\"34\"},\"35\":{\"pid\":\"32\",\"title\":\"\\u8bbe\\u7f6e\\u72b6\\u6001\",\"url\":\"Admin\\/Group\\/setStatus\",\"id\":\"35\"},\"36\":{\"pid\":\"1\",\"title\":\"\\u6269\\u5c55\\u4e2d\\u5fc3\",\"icon\":\"fa fa-folder-open-o\",\"id\":\"36\"},\"44\":{\"pid\":\"36\",\"title\":\"\\u529f\\u80fd\\u6a21\\u5757\",\"icon\":\"fa fa-th-large\",\"url\":\"Admin\\/Module\\/index\",\"id\":\"44\"},\"45\":{\"pid\":\"44\",\"title\":\"\\u5b89\\u88c5\",\"url\":\"Admin\\/Module\\/install\",\"id\":\"45\"},\"46\":{\"pid\":\"44\",\"title\":\"\\u5378\\u8f7d\",\"url\":\"Admin\\/Module\\/uninstall\",\"id\":\"46\"},\"47\":{\"pid\":\"44\",\"title\":\"\\u66f4\\u65b0\\u4fe1\\u606f\",\"url\":\"Admin\\/Module\\/updateInfo\",\"id\":\"47\"},\"48\":{\"pid\":\"44\",\"title\":\"\\u8bbe\\u7f6e\\u72b6\\u6001\",\"url\":\"Admin\\/Module\\/setStatus\",\"id\":\"48\"},\"49\":{\"pid\":\"36\",\"title\":\"\\u63d2\\u4ef6\\u7ba1\\u7406\",\"icon\":\"fa fa-th\",\"url\":\"Admin\\/Addon\\/index\",\"id\":\"49\"},\"50\":{\"pid\":\"49\",\"title\":\"\\u5b89\\u88c5\",\"url\":\"Admin\\/Addon\\/install\",\"id\":\"50\"},\"51\":{\"pid\":\"49\",\"title\":\"\\u5378\\u8f7d\",\"url\":\"Admin\\/Addon\\/uninstall\",\"id\":\"51\"},\"52\":{\"pid\":\"49\",\"title\":\"\\u8fd0\\u884c\",\"url\":\"Admin\\/Addon\\/execute\",\"id\":\"52\"},\"53\":{\"pid\":\"49\",\"title\":\"\\u8bbe\\u7f6e\",\"url\":\"Admin\\/Addon\\/config\",\"id\":\"53\"},\"54\":{\"pid\":\"49\",\"title\":\"\\u540e\\u53f0\\u7ba1\\u7406\",\"url\":\"Admin\\/Addon\\/adminList\",\"id\":\"54\"},\"55\":{\"pid\":\"54\",\"title\":\"\\u65b0\\u589e\\u6570\\u636e\",\"url\":\"Admin\\/Addon\\/adminAdd\",\"id\":\"55\"},\"56\":{\"pid\":\"54\",\"title\":\"\\u7f16\\u8f91\\u6570\\u636e\",\"url\":\"Admin\\/Addon\\/adminEdit\",\"id\":\"56\"},\"57\":{\"pid\":\"54\",\"title\":\"\\u8bbe\\u7f6e\\u72b6\\u6001\",\"url\":\"Admin\\/Addon\\/setStatus\",\"id\":\"57\"}}',1,1438651748,1480832809,0,1),
	(2,'User','用户','','fa fa-users','#F9B440','用户中心模块','南京科斯克网络科技有限公司','1.6.0','{\"title\":{\"center\":\"\\u7528\\u6237\"},\"center\":[{\"title\":\"\\u4fee\\u6539\\u4fe1\\u606f\",\"icon\":\"fa fa-edit\",\"url\":\"User\\/Center\\/profile\",\"color\":\"#F68A3A\"},{\"title\":\"\\u6d88\\u606f\\u4e2d\\u5fc3\",\"icon\":\"fa fa-envelope-o\",\"url\":\"User\\/Message\\/index\",\"badge\":[\"User\\/Message\",\"newMessageCount\"],\"badge_class\":\"badge-danger\",\"color\":\"#80C243\"}]}','{\"reg_toggle\":\"1\",\"allow_reg_type\":[\"username\"],\"deny_username\":\"\",\"user_protocol\":\"\\u8bf7\\u5728\\u201c\\u540e\\u53f0\\u2014\\u2014\\u7528\\u6237\\u2014\\u2014\\u7528\\u6237\\u8bbe\\u7f6e\\u201d\\u4e2d\\u8bbe\\u7f6e\",\"behavior\":[\"User\"]}','{\"1\":{\"pid\":\"0\",\"title\":\"\\u7528\\u6237\",\"icon\":\"fa fa-user\",\"id\":\"1\"},\"2\":{\"pid\":\"1\",\"title\":\"\\u7528\\u6237\\u7ba1\\u7406\",\"icon\":\"fa fa-folder-open-o\",\"id\":\"2\"},\"3\":{\"pid\":\"2\",\"title\":\"\\u7528\\u6237\\u8bbe\\u7f6e\",\"icon\":\"fa fa-wrench\",\"url\":\"User\\/Index\\/module_config\",\"id\":\"3\"},\"4\":{\"pid\":\"2\",\"title\":\"\\u7528\\u6237\\u7edf\\u8ba1\",\"icon\":\"fa fa-area-chart\",\"url\":\"User\\/Index\\/index\",\"id\":\"4\"},\"5\":{\"pid\":\"2\",\"title\":\"\\u7528\\u6237\\u5217\\u8868\",\"icon\":\"fa fa-list\",\"url\":\"User\\/User\\/index\",\"id\":\"5\"},\"6\":{\"pid\":\"5\",\"title\":\"\\u65b0\\u589e\",\"url\":\"User\\/User\\/add\",\"id\":\"6\"},\"7\":{\"pid\":\"5\",\"title\":\"\\u7f16\\u8f91\",\"url\":\"User\\/User\\/edit\",\"id\":\"7\"},\"8\":{\"pid\":\"5\",\"title\":\"\\u8bbe\\u7f6e\\u72b6\\u6001\",\"url\":\"User\\/User\\/setStatus\",\"id\":\"8\"}}',0,1481631428,1481631428,0,1),
	(3,'Git','Git','','fa fa-git','#F9B440','Git模块','南京科斯克网络科技有限公司','1.0.0','{\"center\":[{\"title\":\"\\u6211\\u7684\\u9879\\u76ee\",\"icon\":\"fa fa-git\",\"url\":\"Git\\/Index\\/my\",\"color\":\"#398CD2\"},{\"title\":\"\\u6211\\u53c2\\u4e0e\\u7684\",\"icon\":\"fa fa-git\",\"url\":\"Git\\/Member\\/my\",\"color\":\"#DC6AC6\"}],\"main\":[{\"title\":\"\\u65b0\\u5efa\\u9879\\u76ee\",\"icon\":\"fa fa-plus\",\"url\":\"Git\\/Index\\/add\"}]}','{\"repo_root\":\"\\/home\\/git_repo\\/\",\"http_backend\":\"\"}','{\"1\":{\"pid\":\"0\",\"title\":\"Git\",\"icon\":\"fa fa-git\",\"id\":\"1\"},\"2\":{\"pid\":\"1\",\"title\":\"Git\\u7ba1\\u7406\",\"icon\":\"fa fa-folder-open-o\",\"id\":\"2\"},\"3\":{\"pid\":\"2\",\"title\":\"Git\\u8bbe\\u7f6e\",\"icon\":\"fa fa-wrench\",\"url\":\"Git\\/Index\\/module_config\",\"id\":\"3\"},\"4\":{\"pid\":\"2\",\"title\":\"\\u9879\\u76ee\\u5217\\u8868\",\"icon\":\"fa fa-list\",\"url\":\"Git\\/Index\\/index\",\"id\":\"4\"},\"5\":{\"pid\":\"4\",\"title\":\"\\u65b0\\u589e\",\"url\":\"Git\\/Index\\/add\",\"id\":\"5\"},\"6\":{\"pid\":\"4\",\"title\":\"\\u7f16\\u8f91\",\"url\":\"Git\\/Index\\/edit\",\"id\":\"6\"},\"7\":{\"pid\":\"4\",\"title\":\"\\u8bbe\\u7f6e\\u72b6\\u6001\",\"url\":\"Git\\/Index\\/setStatus\",\"id\":\"7\"},\"8\":{\"pid\":\"2\",\"title\":\"\\u5bfc\\u822a\\u7ba1\\u7406\",\"icon\":\"fa fa-map-signs\",\"url\":\"Git\\/Nav\\/index\",\"id\":\"8\"},\"9\":{\"pid\":\"8\",\"title\":\"\\u65b0\\u589e\",\"url\":\"Git\\/Nav\\/add\",\"id\":\"9\"},\"10\":{\"pid\":\"8\",\"title\":\"\\u7f16\\u8f91\",\"url\":\"Git\\/Nav\\/edit\",\"id\":\"10\"},\"11\":{\"pid\":\"8\",\"title\":\"\\u8bbe\\u7f6e\\u72b6\\u6001\",\"url\":\"Git\\/Nav\\/setStatus\",\"id\":\"11\"}}',0,1481631435,1481631435,0,1);

/*!40000 ALTER TABLE `ly_admin_module` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ly_admin_nav
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ly_admin_nav`;

CREATE TABLE `ly_admin_nav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `group` varchar(11) NOT NULL DEFAULT '' COMMENT '分组',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `title` varchar(31) NOT NULL DEFAULT '' COMMENT '导航标题',
  `type` varchar(15) NOT NULL DEFAULT '' COMMENT '导航类型',
  `value` text COMMENT '导航值',
  `target` varchar(11) NOT NULL DEFAULT '' COMMENT '打开方式',
  `icon` varchar(32) NOT NULL DEFAULT '' COMMENT '图标',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='前台导航表';

LOCK TABLES `ly_admin_nav` WRITE;
/*!40000 ALTER TABLE `ly_admin_nav` DISABLE KEYS */;

INSERT INTO `ly_admin_nav` (`id`, `group`, `pid`, `title`, `type`, `value`, `target`, `icon`, `create_time`, `update_time`, `sort`, `status`)
VALUES
	(1,'bottom',0,'关于','link','','','',1449742225,1449742255,0,1),
	(2,'bottom',1,'关于我们','page','','','',1449742312,1449742312,0,1),
	(4,'bottom',1,'服务产品','page','','','',1449742597,1449742651,0,1),
	(5,'bottom',1,'商务合作','page','','','',1449742664,1449742664,0,1),
	(6,'bottom',1,'加入我们','page','','','',1449742678,1449742697,0,1),
	(7,'bottom',0,'帮助','page','','','',1449742688,1449742688,0,1),
	(8,'bottom',7,'用户协议','page','','','',1449742706,1449742706,0,1),
	(9,'bottom',7,'意见反馈','page','','','',1449742716,1449742716,0,1),
	(10,'bottom',7,'常见问题','page','','','',1449742728,1449742728,0,1),
	(11,'bottom',0,'联系方式','page','','','',1449742742,1449742742,0,1),
	(12,'bottom',11,'联系我们','page','','','',1449742752,1449742752,0,1),
	(13,'bottom',11,'新浪微博','page','','','',1449742802,1449742802,0,1),
	(14,'main',0,'首页','link','','','',1457084559,1472993801,0,1),
	(15,'main',0,'产品中心','page','','','',1457084559,1457084559,0,1),
	(16,'main',0,'客户服务','page','','','',1457084572,1457084572,0,1),
	(17,'main',0,'案例展示','page','','','',1457084583,1457084583,0,1),
	(18,'main',0,'新闻动态','page','','','',1457084714,1457084714,0,1),
	(19,'main',0,'联系我们','page','','','',1457084725,1457084725,0,1),
	(20,'top',0,'用户','module','User','','fa fa-users',1481631428,1481631428,0,1),
	(21,'top',0,'Git','module','Git','','fa fa-git',1481631435,1481631435,0,1);

/*!40000 ALTER TABLE `ly_admin_nav` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ly_admin_post
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ly_admin_post`;

CREATE TABLE `ly_admin_post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `title` varchar(127) NOT NULL DEFAULT '' COMMENT '标题',
  `cover` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '封面',
  `abstract` varchar(255) DEFAULT '' COMMENT '摘要',
  `content` text COMMENT '内容',
  `view_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '阅读',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章列表';



# Dump of table ly_admin_upload
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ly_admin_upload`;

CREATE TABLE `ly_admin_upload` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'UID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '文件名',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '文件路径',
  `url` varchar(255) DEFAULT NULL COMMENT '文件链接',
  `ext` char(4) NOT NULL DEFAULT '' COMMENT '文件类型',
  `size` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `md5` char(32) DEFAULT NULL COMMENT '文件md5',
  `sha1` char(40) DEFAULT NULL COMMENT '文件sha1编码',
  `location` varchar(15) NOT NULL DEFAULT '' COMMENT '文件存储位置',
  `download` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文件上传表';



# Dump of table ly_admin_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ly_admin_user`;

CREATE TABLE `ly_admin_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'UID',
  `user_type` int(11) NOT NULL DEFAULT '1' COMMENT '用户类型',
  `nickname` varchar(63) DEFAULT NULL COMMENT '昵称',
  `username` varchar(31) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(63) NOT NULL DEFAULT '' COMMENT '密码',
  `email` varchar(63) NOT NULL DEFAULT '' COMMENT '邮箱',
  `email_bind` tinyint(1) NOT NULL DEFAULT '0' COMMENT '邮箱验证',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `mobile_bind` tinyint(1) NOT NULL DEFAULT '0' COMMENT '邮箱验证',
  `avatar` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '头像',
  `score` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `reg_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `reg_type` varchar(15) NOT NULL DEFAULT '' COMMENT '注册方式',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户账号表';

LOCK TABLES `ly_admin_user` WRITE;
/*!40000 ALTER TABLE `ly_admin_user` DISABLE KEYS */;

INSERT INTO `ly_admin_user` (`id`, `user_type`, `nickname`, `username`, `password`, `email`, `email_bind`, `mobile`, `mobile_bind`, `avatar`, `score`, `money`, `reg_ip`, `reg_type`, `create_time`, `update_time`, `status`)
VALUES
	(1,1,'超级管理员','admin','ca15e48778f1c20a79803ba73787cf93','',0,'',0,0,0,0.00,0,'',1438651748,1438651748,1);

/*!40000 ALTER TABLE `ly_admin_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ly_git_index
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ly_git_index`;

CREATE TABLE `ly_git_index` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'UID',
  `name` varchar(127) NOT NULL DEFAULT '' COMMENT '项目名称',
  `title` varchar(127) NOT NULL DEFAULT '' COMMENT '项目标题',
  `abstract` varchar(255) NOT NULL DEFAULT '' COMMENT '项目描述',
  `is_private` int(1) NOT NULL DEFAULT '0' COMMENT '是否私有项目',
  `repo_name` varchar(127) NOT NULL DEFAULT '' COMMENT '版本库名称',
  `view_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '查看次数',
  `star_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Star次数',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Git项目表';



# Dump of table ly_git_member
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ly_git_member`;

CREATE TABLE `ly_git_member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `data_id` int(11) DEFAULT NULL COMMENT 'git仓库',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'UID',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Git项目成员表';



# Dump of table ly_git_nav
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ly_git_nav`;

CREATE TABLE `ly_git_nav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `group` varchar(11) NOT NULL DEFAULT '' COMMENT '分组',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `title` varchar(31) NOT NULL DEFAULT '' COMMENT '导航标题',
  `type` varchar(15) NOT NULL DEFAULT '' COMMENT '导航类型',
  `value` text COMMENT '导航值',
  `target` varchar(11) NOT NULL DEFAULT '' COMMENT '打开方式',
  `icon` varchar(32) NOT NULL DEFAULT '' COMMENT '图标',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='前台导航表';

LOCK TABLES `ly_git_nav` WRITE;
/*!40000 ALTER TABLE `ly_git_nav` DISABLE KEYS */;

INSERT INTO `ly_git_nav` (`id`, `group`, `pid`, `title`, `type`, `value`, `target`, `icon`, `create_time`, `update_time`, `sort`, `status`)
VALUES
	(1,'main',0,'发现','link','Git/Index/lists','','',1468514235,1468572489,0,1),
	(2,'main',0,'帮助','page','<div class=\"scrollblock block-title\">\r\n  <h1>\r\n    <span style=\"color:inherit;font-family:inherit;font-size:30px;line-height:1.1;\">链接与资源</span> \r\n </h1>\r\n</div>\r\n<p>\r\n  <h3>\r\n    图形化界面\r\n </h3>\r\n <p>\r\n   <br />\r\n  </p>\r\n  <ul>\r\n    <li>\r\n      <a href=\"http://gitx.laullon.com/\">GitX (L) (OSX, open source)</a> \r\n   </li>\r\n   <li>\r\n      <a href=\"http://www.git-tower.com/\">Tower (OSX)</a> \r\n    </li>\r\n   <li>\r\n      <a href=\"http://www.sourcetreeapp.com/\">Source Tree (OSX, free)</a> \r\n    </li>\r\n   <li>\r\n      <a href=\"http://mac.github.com/\">GitHub for Mac (OSX, free)</a> \r\n    </li>\r\n   <li>\r\n      <a href=\"https://itunes.apple.com/gb/app/gitbox/id403388357?mt=12\">GitBox (OSX)</a> \r\n    </li>\r\n </ul>\r\n <p>\r\n   <br />\r\n  </p>\r\n  <h3>\r\n    指南与手册\r\n </h3>\r\n <p>\r\n   <br />\r\n  </p>\r\n  <ul>\r\n    <li>\r\n      <a href=\"http://book.git-scm.com/\">Git 社区参考书</a> \r\n   </li>\r\n   <li>\r\n      <a href=\"http://progit.org/book/\">专业 Git</a> \r\n   </li>\r\n   <li>\r\n      <a href=\"http://think-like-a-git.net/\">如 git 思考</a> \r\n    </li>\r\n </ul>\r\n <p>\r\n   <ul>\r\n      <li>\r\n        <a href=\"http://help.github.com/\">GitHub 帮助</a>\r\n     </li>\r\n   </ul>\r\n   <p>\r\n     <br />\r\n    </p>\r\n    <p>\r\n     <strong>下面整理一些在使用OpenCMFgit服务时容易遇到的问题：</strong>\r\n   </p>\r\n  </p>\r\n  <p>\r\n   <span style=\"font-family:\'Lantinghei SC\', \'Open Sans\', Arial, \'Hiragino Sans GB\', \'Microsoft YaHei\', STHeiti, \'WenQuanYi Micro Hei\', SimSun, sans-serif;font-size:14px;text-align:center;white-space:normal;\">报错：</span>\r\n  </p>\r\n  <p>\r\n   <span style=\"color:#777777;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">error:&nbsp;RPC&nbsp;failed;&nbsp;result=22,&nbsp;HTTP&nbsp;code&nbsp;=&nbsp;411</span>\r\n  </p>\r\n  <p>\r\n   <span style=\"font-size:14px;\"><span style=\"color:#777777;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">fatal:&nbsp;The&nbsp;remote&nbsp;</span><span class=\"hljs-keyword\" style=\"box-sizing:inherit;color:#859900;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">end</span><span style=\"color:#777777;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">&nbsp;hung&nbsp;up&nbsp;unexpectedly\r\nfatal:&nbsp;The&nbsp;remote&nbsp;</span><span class=\"hljs-keyword\" style=\"box-sizing:inherit;color:#859900;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">end</span><span style=\"color:#777777;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">&nbsp;hung&nbsp;up&nbsp;unexpectedly\r\nEverything&nbsp;up-</span><span class=\"hljs-keyword\" style=\"box-sizing:inherit;color:#859900;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">to</span><span style=\"color:#777777;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">-</span><span class=\"hljs-built_in\" style=\"box-sizing:inherit;color:#268BD2;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">date</span><br />\r\n</span>\r\n  </p>\r\n  <p>\r\n   原因：<span style=\"color:#293136;font-family:arial, helvetica, sans-serif;font-size:16px;white-space:normal;\">默认 Git 设置 http post 的缓存为 1MB，将其设置为 500MB</span>\r\n  </p>\r\n  <p>\r\n   解决：<span style=\"color:#777777;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">git&nbsp;config&nbsp;</span><span class=\"hljs-keyword\" style=\"box-sizing:inherit;color:#859900;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">http</span><span style=\"color:#777777;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">.postBuffer&nbsp;&nbsp;</span><span class=\"hljs-number\" style=\"box-sizing:inherit;color:#2AA198;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\">524288000</span>\r\n </p>\r\n  <p>\r\n   <span class=\"hljs-number\" style=\"box-sizing:inherit;color:#2AA198;font-family:monospace;font-size:13px;white-space:pre;background-color:#FDF6E3;\"><br />\r\n</span>\r\n </p>\r\n</p>','','',1468514385,1468810670,0,1);

/*!40000 ALTER TABLE `ly_git_nav` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ly_git_post
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ly_git_post`;

CREATE TABLE `ly_git_post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `title` varchar(127) NOT NULL DEFAULT '' COMMENT '标题',
  `cover` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '封面',
  `abstract` varchar(255) DEFAULT '' COMMENT '摘要',
  `content` text COMMENT '内容',
  `view_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '阅读',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章列表';



# Dump of table ly_user_attr
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ly_user_attr`;

CREATE TABLE `ly_user_attr` (
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'UID',
  `attr_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '属性ID',
  `value` text NOT NULL COMMENT '字段值'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户属性信息表';



# Dump of table ly_user_attribute
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ly_user_attribute`;

CREATE TABLE `ly_user_attribute` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '字段名',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '字段标题',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '数据类型',
  `value` varchar(100) NOT NULL DEFAULT '' COMMENT '字段默认值',
  `tip` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `options` varchar(255) NOT NULL DEFAULT '' COMMENT '参数',
  `type_id` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '文档模型',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户模块：用户属性字段表';

LOCK TABLES `ly_user_attribute` WRITE;
/*!40000 ALTER TABLE `ly_user_attribute` DISABLE KEYS */;

INSERT INTO `ly_user_attribute` (`id`, `name`, `title`, `type`, `value`, `tip`, `options`, `type_id`, `create_time`, `update_time`, `status`)
VALUES
	(1,'gender','性别','radio','0','性别','1:男\n-1:女\r\n0:保密\r\n',1,1438651748,1438651748,1),
	(2,'city','所在城市','text','','常住城市','',1,1442026468,1442123810,1),
	(3,'summary','签名','text','','签名','',1,1438651748,1438651748,1);

/*!40000 ALTER TABLE `ly_user_attribute` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ly_user_login_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ly_user_login_log`;

CREATE TABLE `ly_user_login_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(11) unsigned NOT NULL COMMENT 'UID',
  `ip` bigint(20) NOT NULL DEFAULT '0' COMMENT 'IP',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '登录方式',
  `device` varchar(127) NOT NULL DEFAULT '' COMMENT '设备信息',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户登录日志';



# Dump of table ly_user_message
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ly_user_message`;

CREATE TABLE `ly_user_message` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '消息ID',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '消息父ID',
  `title` varchar(1024) NOT NULL DEFAULT '' COMMENT '消息标题',
  `content` text COMMENT '消息内容',
  `type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '0系统消息,1评论消息,2私信消息',
  `to_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '接收用户ID',
  `from_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '私信消息发信用户ID',
  `is_read` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否已读',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发送时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户消息表';



# Dump of table ly_user_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ly_user_type`;

CREATE TABLE `ly_user_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(31) NOT NULL DEFAULT '' COMMENT '名称',
  `title` varchar(31) NOT NULL DEFAULT '' COMMENT '标题',
  `icon` varchar(31) NOT NULL DEFAULT '' COMMENT '缩略图',
  `home_template` varchar(127) NOT NULL DEFAULT '' COMMENT '主页模版',
  `center_template` varchar(127) NOT NULL DEFAULT '' COMMENT '个人中心模板',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户模块：用户类型表';

LOCK TABLES `ly_user_type` WRITE;
/*!40000 ALTER TABLE `ly_user_type` DISABLE KEYS */;

INSERT INTO `ly_user_type` (`id`, `name`, `title`, `icon`, `home_template`, `center_template`, `create_time`, `update_time`, `sort`, `status`)
VALUES
	(1,'person','个人','','','',1438651748,1481101582,0,1);

/*!40000 ALTER TABLE `ly_user_type` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
