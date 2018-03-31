/*
SQLyog Ultimate v12.3.1 (64 bit)
MySQL - 10.1.22-MariaDB : Database - laramall
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `ps_admin_role` */

DROP TABLE IF EXISTS `ps_admin_role`;

CREATE TABLE `ps_admin_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL COMMENT '管理员编号',
  `role_id` int(11) NOT NULL COMMENT '角色编号',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `ps_admin_role` */

insert  into `ps_admin_role`(`id`,`admin_id`,`role_id`,`created_at`,`updated_at`) values 
(3,7,10,'2017-02-07 04:46:01','2017-02-07 04:46:01'),
(4,6,7,'2017-11-30 16:51:59','2017-11-30 16:51:59'),
(5,6,10,'2017-11-30 16:51:59','2017-11-30 16:51:59');

/*Table structure for table `ps_admins` */

DROP TABLE IF EXISTS `ps_admins`;

CREATE TABLE `ps_admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_admin` int(10) NOT NULL,
  `remember_token` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `qq` varchar(255) NOT NULL,
  `add_time` int(10) NOT NULL,
  `is_show` int(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_icon` varchar(255) NOT NULL,
  `role_id` int(10) NOT NULL,
  `address_id` int(10) NOT NULL,
  `nickname` varchar(255) NOT NULL COMMENT '昵称',
  `sex` int(10) NOT NULL COMMENT '性别',
  `birthday` varchar(255) NOT NULL COMMENT '生日',
  `sfz` varchar(255) NOT NULL COMMENT '身份证',
  `country` int(10) NOT NULL COMMENT '国家编号',
  `province` int(10) NOT NULL COMMENT '省会编号',
  `city` int(10) NOT NULL COMMENT '城市编号',
  `district` int(10) NOT NULL COMMENT '地区编号',
  `sort_order` int(10) NOT NULL,
  `rank_id` int(10) NOT NULL,
  `login_ip` varchar(255) NOT NULL COMMENT '登录ip',
  `reg_from` varchar(255) NOT NULL COMMENT '注册来源',
  `login_time` int(10) NOT NULL,
  `last_login_ip` varchar(255) NOT NULL,
  `last_login_time` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `ps_admins` */

insert  into `ps_admins`(`id`,`_id`,`username`,`email`,`is_admin`,`remember_token`,`phone`,`ip`,`qq`,`add_time`,`is_show`,`password`,`user_icon`,`role_id`,`address_id`,`nickname`,`sex`,`birthday`,`sfz`,`country`,`province`,`city`,`district`,`sort_order`,`rank_id`,`login_ip`,`reg_from`,`login_time`,`last_login_ip`,`last_login_time`,`created_at`,`updated_at`) values 
(6,'','admin','bluetooth_swh@163.com',1,'mhbrLb2RHQaM1WNJy6Mc6EyYkm8rTRzYKBouWAOMnvJ5WL64015o9hg5BXWm','13810597838','192.168.1.80','',1431762352,1,'$2y$10$tyfMMsV4MJGih8I1cbFFX.19MYzR3X2K7zEIEO.sEahl.l45mMTrm','images//201604/2208c62b0df9a8387a1a33016d8070d4.png',7,0,'',0,'','',0,0,0,0,0,0,'::1','',0,'',0,'2018-03-04 21:48:53','2018-03-04 13:48:53'),
(7,'','demo','demo@163.com',0,'WLMitPJDCiWDdOqzDs6xpfTBReOsOronwYoKAIAd0bwZkx4SGAvmh7BeAA2U','13810597838','','',1486442761,1,'$2y$10$zMlKrbX8FRfYTHt9tBDKNuoTHTG.iJWWkRbYlOpIU0oHhsopsKBY2','',0,0,'',0,'','',0,0,0,0,0,0,'','',0,'',0,'2017-02-07 15:30:57','2017-02-07 07:30:57');

/*Table structure for table `ps_advice` */

DROP TABLE IF EXISTS `ps_advice`;

CREATE TABLE `ps_advice` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `order_sn` varchar(255) NOT NULL COMMENT '订单编号',
  `goods_id` int(10) NOT NULL COMMENT '商品编号',
  `add_time` int(10) NOT NULL COMMENT '投诉时间戳',
  `user_id` int(10) NOT NULL COMMENT '投诉人',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ps_advice` */

/*Table structure for table `ps_article` */

DROP TABLE IF EXISTS `ps_article`;

CREATE TABLE `ps_article` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cat_id` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL COMMENT '文章作者',
  `content` text NOT NULL,
  `article_code` text NOT NULL,
  `is_show` int(10) NOT NULL,
  `add_time` int(10) NOT NULL,
  `diy_url` varchar(255) NOT NULL,
  `file_url` varchar(255) NOT NULL,
  `sort_order` int(10) NOT NULL,
  `keywords` varchar(255) NOT NULL COMMENT '关键词',
  `description` varchar(255) NOT NULL COMMENT '简单介绍',
  `position` varchar(255) NOT NULL COMMENT '推荐位置',
  `thumb` varchar(255) NOT NULL COMMENT '文章缩略图',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `ps_article` */

/*Table structure for table `ps_article_cat` */

DROP TABLE IF EXISTS `ps_article_cat`;

CREATE TABLE `ps_article_cat` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  `parent_id` int(10) NOT NULL,
  `cat_pic` varchar(255) NOT NULL,
  `is_show` int(10) NOT NULL,
  `cat_desc` text NOT NULL,
  `sort_order` int(10) NOT NULL,
  `is_help` int(10) NOT NULL COMMENT '是否是帮助中心',
  `diy_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `ps_article_cat` */

insert  into `ps_article_cat`(`id`,`cat_name`,`parent_id`,`cat_pic`,`is_show`,`cat_desc`,`sort_order`,`is_help`,`diy_url`,`created_at`,`updated_at`) values 
(1,'网店帮助中心',0,'',1,'',0,1,'','2016-04-18 11:02:38','2016-04-18 03:02:38'),
(2,'使用帮助',0,'',1,'',0,1,'','2016-04-18 10:55:55','2016-04-18 02:55:55'),
(3,'如何处理数据库',0,'',1,'',0,0,'','2016-04-18 11:01:53','2016-04-18 03:01:53'),
(4,'系统帮助',0,'',1,'',0,1,'help','2016-04-18 10:49:20','2016-04-18 02:49:20'),
(5,'支付方式',0,'',1,'',0,0,'','2016-02-22 03:27:54','2016-02-22 03:27:54'),
(6,'授权相关',0,'',1,'',0,0,'','2016-02-23 08:54:51','2016-02-23 08:54:51'),
(7,'安装使用',0,'',1,'',0,0,'','2016-02-24 14:20:38','2016-02-24 14:20:38'),
(8,'模板开发教程',0,'',1,'',0,0,'','2016-02-24 14:39:26','2016-02-24 14:39:26'),
(9,'建议和意见',0,'',1,'',0,0,'','2016-03-01 03:51:49','2016-03-01 03:51:49'),
(10,'视频教程',0,'images/common/201610/bb0cca92765a0ad49a4b64c6653a474a.png',1,'',0,1,'','2016-10-08 12:19:06','2016-10-08 04:19:06');

/*Table structure for table `ps_ask` */

DROP TABLE IF EXISTS `ps_ask`;

CREATE TABLE `ps_ask` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) NOT NULL,
  `goods_id` mediumint(8) NOT NULL,
  `email` varchar(60) COLLATE utf8_bin NOT NULL,
  `username` varchar(60) COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `comment_rank` tinyint(1) NOT NULL,
  `add_time` int(10) NOT NULL,
  `ip_address` varchar(15) COLLATE utf8_bin NOT NULL,
  `status` tinyint(3) NOT NULL,
  `parent_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `ps_ask` */

insert  into `ps_ask`(`id`,`type`,`goods_id`,`email`,`username`,`content`,`comment_rank`,`add_time`,`ip_address`,`status`,`parent_id`,`user_id`,`created_at`,`updated_at`) values 
(1,1,3076,'11111111111@qqq.com','11111','11111111111111111111111111111111111111111111111',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(2,1,3076,'11111111111@qqq.com','11111','11111111111111111111111111111111111111111111111',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(3,1,3076,'11111111111@qqq.com','11111','11111111111111111111111111111111111111111111111',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(4,1,3076,'11111111111@qqq.com','11111','11111111111111111111111111111111111111111111111',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(5,1,3076,'11111111111@qqq.com','11111','11111111111111111111111111111111111111111111111',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(6,1,3076,'11111111111@qqq.com','11111','11111111111111111111111111111111111111111111111',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(7,1,3076,'11111111111@qqq.com','11111','11111111111111111111111111111111111111111111111',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(8,1,3076,'11111111111@qqq.com','11111','11111111111111111111111111111111111111111111111',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(9,1,3076,'11111111111@qqq.com','11111','11111111111111111111111111111111111111111111111',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(10,1,3076,'11111111111@qqq.com','11111','11111111111111111111111111111111111111111111111',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(11,2,3076,'22222222222@qqq.com','22222','22222222222222222222222222222222222222222222222',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(12,2,3076,'22222222222@qqq.com','22222','22222222222222222222222222222222222222222222222',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(13,2,3076,'22222222222@qqq.com','22222','22222222222222222222222222222222222222222222222',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(14,2,3076,'22222222222@qqq.com','22222','22222222222222222222222222222222222222222222222',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(15,2,3076,'22222222222@qqq.com','22222','22222222222222222222222222222222222222222222222',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(16,2,3076,'22222222222@qqq.com','22222','22222222222222222222222222222222222222222222222',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(17,2,3076,'22222222222@qqq.com','22222','22222222222222222222222222222222222222222222222',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(18,2,3076,'22222222222@qqq.com','22222','22222222222222222222222222222222222222222222222',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(19,2,3076,'22222222222@qqq.com','22222','22222222222222222222222222222222222222222222222',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(20,2,3076,'22222222222@qqq.com','22222','22222222222222222222222222222222222222222222222',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(21,3,3076,'33333333333@qqq.com','33333','33333333333333333333333333333333333333333333333',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(22,3,3076,'33333333333@qqq.com','33333','33333333333333333333333333333333333333333333333',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(23,3,3076,'33333333333@qqq.com','33333','33333333333333333333333333333333333333333333333',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(24,3,3076,'33333333333@qqq.com','33333','33333333333333333333333333333333333333333333333',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(25,3,3076,'33333333333@qqq.com','33333','33333333333333333333333333333333333333333333333',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(26,3,3076,'33333333333@qqq.com','33333','33333333333333333333333333333333333333333333333',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(27,3,3076,'33333333333@qqq.com','33333','33333333333333333333333333333333333333333333333',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(28,3,3076,'33333333333@qqq.com','33333','33333333333333333333333333333333333333333333333',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(29,3,3076,'33333333333@qqq.com','33333','33333333333333333333333333333333333333333333333',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(30,3,3076,'33333333333@qqq.com','33333','33333333333333333333333333333333333333333333333',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(31,4,3076,'44444444444@qqq.com','44444','44444444444444444444444444444444444444444444444',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(32,4,3076,'44444444444@qqq.com','44444','44444444444444444444444444444444444444444444444',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(33,4,3076,'44444444444@qqq.com','44444','44444444444444444444444444444444444444444444444',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(34,4,3076,'44444444444@qqq.com','44444','44444444444444444444444444444444444444444444444',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(35,4,3076,'44444444444@qqq.com','44444','44444444444444444444444444444444444444444444444',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(36,4,3076,'44444444444@qqq.com','44444','44444444444444444444444444444444444444444444444',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(37,4,3076,'44444444444@qqq.com','44444','44444444444444444444444444444444444444444444444',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(38,4,3076,'44444444444@qqq.com','44444','44444444444444444444444444444444444444444444444',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(39,4,3076,'44444444444@qqq.com','44444','44444444444444444444444444444444444444444444444',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00'),
(40,4,3076,'44444444444@qqq.com','44444','44444444444444444444444444444444444444444444444',0,1435306394,'',0,0,0,'2015-06-26 16:13:14','0000-00-00 00:00:00');

/*Table structure for table `ps_attribute` */

DROP TABLE IF EXISTS `ps_attribute`;

CREATE TABLE `ps_attribute` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `attr_name` varchar(255) NOT NULL,
  `attr_type` int(10) NOT NULL,
  `color_tag` varchar(255) NOT NULL,
  `img_tag` varchar(255) NOT NULL,
  `type_id` int(10) NOT NULL COMMENT '商品类型',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sort_order` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `ps_attribute` */

insert  into `ps_attribute`(`id`,`attr_name`,`attr_type`,`color_tag`,`img_tag`,`type_id`,`created_at`,`updated_at`,`sort_order`) values 
(3,'颜色',0,'1','1',5,'2016-04-11 23:37:54','2016-04-11 15:37:54',0),
(4,'尺码',0,'0','0',5,'2016-04-11 23:37:49','2016-04-11 15:37:49',0),
(5,'产地',1,'0','0',5,'2016-05-21 15:49:44','2016-05-21 15:49:44',0),
(9,'颜色',0,'1','1',6,'2016-10-18 17:47:52','2016-10-18 17:47:52',0),
(10,'产地',0,'0','0',6,'2016-11-22 11:04:15','2016-11-22 03:04:15',0);

/*Table structure for table `ps_brand` */

DROP TABLE IF EXISTS `ps_brand`;

CREATE TABLE `ps_brand` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(60) NOT NULL DEFAULT '',
  `brand_logo` varchar(80) NOT NULL DEFAULT '',
  `brand_desc` text NOT NULL,
  `brand_url` varchar(255) NOT NULL DEFAULT '',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '50',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `brand_cat` varchar(255) NOT NULL,
  `delete_type` int(10) NOT NULL DEFAULT '0',
  `diy_url` varchar(255) NOT NULL,
  `tag` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `is_show` (`is_show`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `ps_brand` */

insert  into `ps_brand`(`id`,`brand_name`,`brand_logo`,`brand_desc`,`brand_url`,`sort_order`,`is_show`,`brand_cat`,`delete_type`,`diy_url`,`tag`,`created_at`,`updated_at`) values 
(1,'宜家','images//201604/cd57422716ca87fe42ffb73cdf619bb4.png','<p>来自瑞典的经典品牌 ikea 美观大方的设计风格<br/></p>','http://www.ikea.cn',0,1,'',0,'',0,'2016-04-18 19:18:53','2016-04-18 11:18:53'),
(2,'Apple','images//201604/37fe0c933afe033f9e7e6716db30a167.png','','www.apple.com.cn',0,1,'',0,'',0,'2016-04-18 19:00:06','2016-04-18 11:00:06'),
(3,'PHPStore','','','www.phpstore.cn',0,1,'',0,'',0,'2016-04-18 19:00:58','2016-04-18 11:00:58'),
(4,'LaraStore','images/common/201703/20170308133881488980308_vaeKpd9pMn.png','','http://www.phpstore.cn',50,1,'',0,'',0,'2017-03-08 21:38:28','2017-03-08 13:38:28');

/*Table structure for table `ps_brand_collect` */

DROP TABLE IF EXISTS `ps_brand_collect`;

CREATE TABLE `ps_brand_collect` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `brand_id` int(10) NOT NULL COMMENT '品牌编号',
  `user_id` int(10) NOT NULL COMMENT '用户编号',
  `add_time` int(10) NOT NULL COMMENT '收藏时间戳',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='品牌收藏表';

/*Data for the table `ps_brand_collect` */

/*Table structure for table `ps_card` */

DROP TABLE IF EXISTS `ps_card`;

CREATE TABLE `ps_card` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL COMMENT '用户编号',
  `admin_id` int(10) NOT NULL COMMENT '管理员编号',
  `card_sn` varchar(255) NOT NULL COMMENT '礼品卡编号',
  `add_time` int(11) NOT NULL COMMENT '时间戳',
  `price` decimal(10,2) NOT NULL COMMENT '礼品卡金额',
  `end_time` int(11) NOT NULL COMMENT '到期日期时间戳',
  `tag` int(11) NOT NULL COMMENT '礼品卡状态',
  `pay_time` int(11) NOT NULL COMMENT '消费时间',
  `sort_order` int(11) NOT NULL COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `ps_card` */

insert  into `ps_card`(`id`,`user_id`,`admin_id`,`card_sn`,`add_time`,`price`,`end_time`,`tag`,`pay_time`,`sort_order`,`created_at`,`updated_at`) values 
(1,1,6,'IwBhqNEsRQ12',1480550400,123.00,1483056000,2,0,0,'2016-12-09 13:31:31','2016-12-26 13:18:00'),
(2,1,6,'9ep08apca7',1480550400,3000.00,1513728000,1,0,0,'2016-12-09 13:48:51','2017-02-20 14:30:21');

/*Table structure for table `ps_cart` */

DROP TABLE IF EXISTS `ps_cart`;

CREATE TABLE `ps_cart` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `session_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_sn` varchar(60) NOT NULL DEFAULT '',
  `product_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_name` varchar(120) NOT NULL DEFAULT '',
  `market_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `shop_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '0',
  `goods_attr` text NOT NULL,
  `is_real` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `extension_code` varchar(30) NOT NULL DEFAULT '',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `rec_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_gift` smallint(5) unsigned NOT NULL DEFAULT '0',
  `is_shipping` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `can_handsel` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `goods_attr_id` varchar(255) NOT NULL DEFAULT '',
  `thumb` varchar(255) NOT NULL,
  `is_checked` int(10) NOT NULL COMMENT '购物车中记录是否被选中',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`)
) ENGINE=MyISAM AUTO_INCREMENT=318 DEFAULT CHARSET=utf8;

/*Data for the table `ps_cart` */

/*Table structure for table `ps_cat_ad` */

DROP TABLE IF EXISTS `ps_cat_ad`;

CREATE TABLE `ps_cat_ad` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cat_id` int(10) NOT NULL COMMENT '分类编号',
  `img_src` varchar(255) NOT NULL COMMENT '图片地址',
  `img_name` varchar(255) NOT NULL COMMENT '图片名称',
  `img_url` varchar(255) NOT NULL COMMENT '分类广告链接',
  `sort_order` int(10) NOT NULL COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='分类广告表';

/*Data for the table `ps_cat_ad` */

insert  into `ps_cat_ad`(`id`,`cat_id`,`img_src`,`img_name`,`img_url`,`sort_order`,`created_at`,`updated_at`) values 
(2,1,'images/common/201610/909e14cd30eeb57651690af0aa9dcbfe.png','','http://www.phpstore.cn',0,'2016-10-09 12:29:14','2016-10-09 04:29:14'),
(3,14,'images/common/201610/0822cc7dc916d3735bb6de394e25b194.jpg','','http://www.phpstore.cn',0,'2016-10-09 12:29:02','2016-10-09 04:29:02');

/*Table structure for table `ps_category` */

DROP TABLE IF EXISTS `ps_category`;

CREATE TABLE `ps_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `cat_name` varchar(255) NOT NULL COMMENT '分类名称',
  `measure_unit` varchar(255) NOT NULL COMMENT '数量单位',
  `cat_desc` varchar(255) NOT NULL COMMENT '分类描述',
  `keywords` varchar(255) NOT NULL COMMENT '分类关键字',
  `cat_template` varchar(255) NOT NULL COMMENT '分类模板名称',
  `is_show` int(11) NOT NULL COMMENT '是否显示',
  `is_nav` int(11) NOT NULL COMMENT '显示在导航栏',
  `grade` int(11) NOT NULL COMMENT '分类等级',
  `cat_img` varchar(255) NOT NULL COMMENT '分类图标',
  `diy_url` varchar(255) NOT NULL COMMENT '自定义链接',
  `sort_order` int(11) NOT NULL COMMENT '排序',
  `left` int(11) DEFAULT NULL,
  `right` int(11) DEFAULT NULL,
  `depth` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `category_parent_id_index` (`parent_id`),
  KEY `category_left_index` (`left`),
  KEY `category_right_index` (`right`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

/*Data for the table `ps_category` */

insert  into `ps_category`(`id`,`parent_id`,`cat_name`,`measure_unit`,`cat_desc`,`keywords`,`cat_template`,`is_show`,`is_nav`,`grade`,`cat_img`,`diy_url`,`sort_order`,`left`,`right`,`depth`,`created_at`,`updated_at`) values 
(1,NULL,'测试分类','','','','',1,1,0,'','',0,79,84,0,'2016-05-14 17:31:43','2017-02-27 09:44:41'),
(2,NULL,'家电','','','','',1,1,5,'','',0,69,76,0,'2016-05-14 17:31:51','2017-02-27 09:44:41'),
(3,NULL,'智能家具','','','','',1,1,0,'','',0,1,4,0,'2016-05-14 17:32:03','2016-11-05 16:36:43'),
(4,NULL,'化妆品/护肤品','','','','',1,1,0,'','',0,5,16,0,'2016-05-14 17:32:19','2016-11-05 16:36:43'),
(5,4,'基础护理','','','','',1,1,0,'','',0,6,11,1,'2016-05-14 17:32:30','2016-11-05 16:36:43'),
(6,4,'彩妆系列','','','','',1,1,0,'','',0,12,15,1,'2016-05-14 17:32:40','2016-11-05 16:36:43'),
(7,6,'兰蔻','','','','',1,1,0,'','',0,13,14,2,'2016-05-14 17:32:55','2016-11-05 16:36:43'),
(8,NULL,'编程书籍','','','','',1,1,0,'','',0,17,32,0,'2016-05-14 17:33:06','2016-11-05 16:36:43'),
(9,8,'PHP编程书籍','','','','',1,1,0,'','',0,18,21,1,'2016-05-14 17:33:16','2016-11-05 16:36:43'),
(10,8,'python','','','','',1,1,0,'','',0,22,23,1,'2016-05-14 17:33:25','2016-11-05 16:36:43'),
(11,8,'ruby','','','','',1,1,0,'','',0,24,25,1,'2016-05-14 17:33:34','2016-11-05 16:36:43'),
(12,8,'swift','','','','',1,1,0,'','',0,26,27,1,'2016-05-14 17:33:49','2016-11-05 16:36:43'),
(13,8,'javascript','','','','',1,1,0,'','',0,28,31,1,'2016-05-14 17:34:03','2016-11-05 16:36:43'),
(14,9,'django','','','','',1,1,0,'','',0,19,20,2,'2016-05-14 17:34:13','2016-11-05 16:36:43'),
(15,13,'vuejs','','','','',1,1,0,'','',0,29,30,2,'2016-05-14 17:34:21','2016-11-05 16:36:43'),
(16,NULL,'苹果产品','','','','',1,1,0,'','',0,33,44,0,'2016-05-14 17:34:54','2016-11-05 16:36:43'),
(17,16,'Mac电脑系列','','','','',1,1,0,'','',0,34,39,1,'2016-05-14 17:35:03','2016-11-05 16:36:43'),
(18,16,'iPad平板系列','','','','',1,1,0,'','',0,40,41,1,'2016-05-14 17:35:14','2016-11-05 16:36:43'),
(19,16,'iPhone手机系列','','','','',1,1,0,'','',0,42,43,1,'2016-05-14 17:35:23','2016-11-05 16:36:43'),
(20,17,'MacPro台式机','','','','',1,1,0,'','',0,35,36,2,'2016-05-14 17:35:35','2016-11-05 16:36:43'),
(21,17,'MacBookPro笔记本','','','','',1,1,0,'','',0,37,38,2,'2016-05-14 17:35:47','2016-11-05 16:36:43'),
(22,2,'洗衣机','','','','',1,1,0,'','',0,70,71,1,'2016-05-14 17:36:02','2017-02-27 09:44:41'),
(23,2,'冰箱','','','','',1,1,0,'','',0,72,73,1,'2016-05-14 17:36:10','2017-02-27 09:44:41'),
(24,2,'电视机','','','','',1,1,0,'','',0,74,75,1,'2016-05-14 17:36:25','2017-02-27 09:44:41'),
(25,1,'智能机器人','','','','',1,1,0,'','',0,80,81,1,'2016-05-14 17:36:47','2017-02-27 09:44:41'),
(26,1,'无人机','','','','',1,1,0,'','',0,82,83,1,'2016-05-14 17:36:56','2017-02-27 09:44:41'),
(27,NULL,'生鲜水果','','','','',1,1,0,'','',0,45,48,0,'2016-05-14 17:37:15','2016-11-05 16:36:43'),
(28,NULL,'绿色植物','','','','',1,1,0,'','',0,49,52,0,'2016-05-14 17:37:21','2016-11-05 16:36:43'),
(29,NULL,'珠宝首饰','','','','',1,1,0,'','',0,53,56,0,'2016-05-14 17:37:46','2016-11-05 16:36:43'),
(30,NULL,'奢侈品','','','','',1,1,0,'','',0,57,64,0,'2016-05-14 17:37:59','2016-11-05 16:36:43'),
(31,NULL,'电动汽车','','','','',1,1,0,'','',0,65,68,0,'2016-05-14 17:38:11','2016-11-05 16:36:43'),
(32,3,'扫地机器人','','','','',1,1,0,'','',0,2,3,1,'2016-05-14 17:40:32','2016-11-05 16:36:43'),
(33,27,'有机牧场水果','','','','',1,1,0,'','',0,46,47,1,'2016-05-14 17:40:59','2016-11-05 16:36:43'),
(34,28,'绿萝','','','','',1,1,0,'','',0,50,51,1,'2016-05-14 17:41:09','2016-11-05 16:36:43'),
(35,29,'彩宝石','','','','',1,1,0,'','',0,54,55,1,'2016-05-14 17:41:28','2016-11-05 16:36:43'),
(36,30,'LV','','','','',1,1,0,'','',0,58,59,1,'2016-05-14 17:41:43','2016-11-05 16:36:43'),
(37,30,'欧米茄手表','','','','',1,1,0,'','',0,60,63,1,'2016-05-14 17:41:58','2016-11-05 16:36:43'),
(38,31,'特斯拉电动汽车','','','','',1,1,0,'','',0,66,67,1,'2016-05-14 17:42:09','2016-11-05 16:36:43'),
(39,5,'科颜氏','','','','',1,1,0,'images/category/201605/d201bf9ddc94f54e971ac5233d6a6cb7.png','',0,7,10,2,'2016-05-14 18:02:07','2016-11-05 16:36:43'),
(40,37,'海淘 ','','','','',1,1,0,'','',0,61,62,2,'2016-05-15 16:20:09','2016-11-05 16:36:43'),
(41,39,'积雪草洗面奶','','','','',1,1,0,'','',0,8,9,3,'2016-05-15 16:51:17','2016-11-05 16:36:43'),
(42,NULL,'filofax活页本123','','','','',1,1,0,'images/category/201610/b866f7604de1dc6afb84d6d79f97025f.jpg','',0,77,78,0,'2016-06-22 17:42:32','2017-02-27 09:44:41');

/*Table structure for table `ps_city_site` */

DROP TABLE IF EXISTS `ps_city_site`;

CREATE TABLE `ps_city_site` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(255) NOT NULL,
  `site_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_show` int(10) NOT NULL,
  `sort_order` int(10) NOT NULL,
  `site_code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `ps_city_site` */

insert  into `ps_city_site`(`id`,`site_name`,`site_url`,`created_at`,`updated_at`,`is_show`,`sort_order`,`site_code`) values 
(9,'北京站','www.phpstore.cn/beijing','2015-08-26 00:40:24','2015-08-26 00:40:24',1,0,'beijing'),
(10,'上海站','www.phpstore.cn/shanghai','2015-08-26 00:40:36','2015-08-26 00:40:36',1,0,'shanghai'),
(11,'广州站','gz.phpstore.cn','2016-01-05 12:13:17','2016-01-05 04:13:17',0,1,'guangzhou');

/*Table structure for table `ps_collect_goods` */

DROP TABLE IF EXISTS `ps_collect_goods`;

CREATE TABLE `ps_collect_goods` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0',
  `is_attention` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `goods_id` (`goods_id`),
  KEY `is_attention` (`is_attention`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `ps_collect_goods` */

insert  into `ps_collect_goods`(`id`,`user_id`,`goods_id`,`add_time`,`is_attention`,`created_at`,`updated_at`) values 
(6,1,1,1482899663,0,'2016-12-28 04:34:23','2016-12-28 04:34:23'),
(3,1,4,1482845627,0,'2016-12-27 13:33:47','2016-12-27 13:33:47'),
(4,1,8,1482845632,0,'2016-12-27 13:33:52','2016-12-27 13:33:52'),
(5,1,7,1482893478,0,'2016-12-28 02:51:18','2016-12-28 02:51:18');

/*Table structure for table `ps_comment` */

DROP TABLE IF EXISTS `ps_comment`;

CREATE TABLE `ps_comment` (
  `comment_id` int(10) NOT NULL AUTO_INCREMENT,
  `commet_type` tinyint(3) NOT NULL,
  `id_value` mediumint(8) NOT NULL,
  `email` varchar(60) COLLATE utf8_bin NOT NULL,
  `user_name` varchar(60) COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `comment_rank` tinyint(1) NOT NULL,
  `add_time` int(10) NOT NULL,
  `ip_address` varchar(15) COLLATE utf8_bin NOT NULL,
  `status` tinyint(3) NOT NULL,
  `parent_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `ps_comment` */

insert  into `ps_comment`(`comment_id`,`commet_type`,`id_value`,`email`,`user_name`,`content`,`comment_rank`,`add_time`,`ip_address`,`status`,`parent_id`,`user_id`,`created_at`,`updated_at`) values 
(1,0,0,'','网络部1','1这里是用来写产品使用心得滴1',0,1434598298,'',0,0,0,'2015-06-18 11:50:29','0000-00-00 00:00:00'),
(2,0,0,'','网络部2','这里是用来写产品使用心得滴1',0,1434598299,'',0,0,0,'2015-06-18 11:32:57','0000-00-00 00:00:00'),
(3,0,0,'','网络部3','这里是用来写产品使用心得滴1',0,1434598300,'',0,0,0,'2015-06-18 11:33:02','0000-00-00 00:00:00'),
(4,0,0,'','网络部4','这里是用来写产品使用心得滴4',0,1434598364,'',0,0,0,'2015-06-18 11:32:44','0000-00-00 00:00:00'),
(5,0,0,'','网络部5','这里是用来写产品使用心得滴5',0,1434598364,'',0,0,0,'2015-06-18 11:32:44','0000-00-00 00:00:00'),
(6,0,0,'','网络部6','这里是用来写产品使用心得滴6',0,1434598364,'',0,0,0,'2015-06-18 11:32:44','0000-00-00 00:00:00'),
(7,0,0,'','网络部7','这里是用来写产品使用心得滴7',0,1434598364,'',0,0,0,'2015-06-18 11:32:44','0000-00-00 00:00:00'),
(8,0,0,'','网络部8','这里是用来写产品使用心得滴8',0,1434598364,'',0,0,0,'2015-06-18 11:32:44','0000-00-00 00:00:00');

/*Table structure for table `ps_database_field` */

DROP TABLE IF EXISTS `ps_database_field`;

CREATE TABLE `ps_database_field` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `field` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `db_id` int(10) NOT NULL,
  `db_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ps_database_field` */

/*Table structure for table `ps_databases` */

DROP TABLE IF EXISTS `ps_databases`;

CREATE TABLE `ps_databases` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `db_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ps_databases` */

/*Table structure for table `ps_demo` */

DROP TABLE IF EXISTS `ps_demo`;

CREATE TABLE `ps_demo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL COMMENT '用户名称',
  `password` varchar(255) NOT NULL COMMENT '用户密码',
  `remember_token` varchar(100) DEFAULT NULL,
  `ip` varchar(255) NOT NULL COMMENT '注册ip地址',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  `sort_order` int(11) NOT NULL COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `ps_demo` */

insert  into `ps_demo`(`id`,`username`,`password`,`remember_token`,`ip`,`add_time`,`sort_order`,`created_at`,`updated_at`) values 
(1,'demo','$2y$10$4lp65KEbBFZ2UU73bBA1fOF.8EEnkB7ol/NhdoY4KMRD5tWJ6/3Pu','wiEPEw4ugG2mCRFIzzvCGVhYFI7IdNSd3GK9E3QpDpJI75wo8lc18D6zgYe1','::1',1460444030,0,'2016-04-12 06:53:50','2016-07-26 18:42:31');

/*Table structure for table `ps_experience_shop` */

DROP TABLE IF EXISTS `ps_experience_shop`;

CREATE TABLE `ps_experience_shop` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `shop_name` varchar(255) NOT NULL COMMENT '店铺名称',
  `site` varchar(255) NOT NULL COMMENT '所属分站',
  `supplier_id` int(10) NOT NULL COMMENT '供货商编号',
  `shop_address` varchar(255) NOT NULL COMMENT '店铺地址',
  `shop_desc` varchar(255) NOT NULL COMMENT '店铺说明',
  `shop_service` varchar(255) NOT NULL COMMENT '店铺服务',
  `shop_fp_type` varchar(255) NOT NULL COMMENT '发票类型',
  `shop_bank` varchar(255) NOT NULL COMMENT '开户银行',
  `shop_bank_account` varchar(255) NOT NULL COMMENT '账号',
  `shop_bank_address` int(11) NOT NULL COMMENT '开户行地址',
  `shop_contact` varchar(255) NOT NULL COMMENT '店铺联系人',
  `shop_phone` varchar(255) NOT NULL COMMENT '店铺手机',
  `shop_tel` varchar(255) NOT NULL COMMENT '店铺座机',
  `shop_email` varchar(255) NOT NULL COMMENT '店铺邮件',
  `shop_qq` varchar(255) NOT NULL COMMENT '店铺qq',
  `cw_username` varchar(255) NOT NULL COMMENT '财务联系人',
  `kf_username` varchar(255) NOT NULL COMMENT '客服联系人',
  `cat_id` int(10) NOT NULL COMMENT '推荐分类编号',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='体验馆的数据表';

/*Data for the table `ps_experience_shop` */

insert  into `ps_experience_shop`(`id`,`shop_name`,`site`,`supplier_id`,`shop_address`,`shop_desc`,`shop_service`,`shop_fp_type`,`shop_bank`,`shop_bank_account`,`shop_bank_address`,`shop_contact`,`shop_phone`,`shop_tel`,`shop_email`,`shop_qq`,`cw_username`,`kf_username`,`cat_id`,`created_at`,`updated_at`) values 
(1,'八角居然之家体验店','beijing',0,'北京市石景山区八角居然之家2层厨卫百分百店','','','','','',0,'','15072309522','','','','','',1,'2015-06-08 17:10:13','0000-00-00 00:00:00'),
(2,'八角居然之家体验店1','shanghai',0,'北京市石景山区八角居然之家2层厨卫百分百店','','','','','',0,'','15072309522','','','','','',1,'2015-06-08 17:10:13','0000-00-00 00:00:00'),
(3,'八角居然之家体验店2','beijing',0,'北京市丰台区中福丽宫品牌基地三单元310','','','','','',0,'','15072309522','','','','','',1,'2015-06-08 17:10:13','0000-00-00 00:00:00'),
(4,'八角居然之家体验店3','shanghai',0,'北京市石景山区八角居然之家2层厨卫百分百店','','','','','',0,'','15072309522','','','','','',1,'2015-06-08 17:10:13','0000-00-00 00:00:00'),
(5,'八角居然之家体验店4','beijing',0,'北京市石景山区八角居然之家2层厨卫百分百店','','','','','',0,'','15072309522','','','','','',1,'2015-06-08 17:10:13','0000-00-00 00:00:00'),
(6,'八角居然之家体验店5','beijing',0,'北京市丰台区中福丽宫品牌基地三单元310','','','','','',0,'','15072309522','','','','','',1,'2015-06-08 17:10:13','0000-00-00 00:00:00');

/*Table structure for table `ps_field` */

DROP TABLE IF EXISTS `ps_field`;

CREATE TABLE `ps_field` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `field_name` varchar(255) NOT NULL COMMENT '规格名称',
  `type_id` int(10) NOT NULL COMMENT '商品类型',
  `sort_order` int(10) NOT NULL COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `ps_field` */

insert  into `ps_field`(`id`,`field_name`,`type_id`,`sort_order`,`created_at`,`updated_at`) values 
(4,'质地',6,0,'2017-01-10 21:47:02','2017-01-10 13:47:02'),
(5,'城市',6,0,'2017-01-10 21:46:56','2017-01-10 13:46:56'),
(8,'原材料来源',6,0,'2017-01-12 11:35:33','2017-01-12 03:35:33');

/*Table structure for table `ps_fp` */

DROP TABLE IF EXISTS `ps_fp`;

CREATE TABLE `ps_fp` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `order_id` int(10) NOT NULL COMMENT '订单编号',
  `fp_title` varchar(255) NOT NULL COMMENT '发票抬头',
  `fp_type` int(10) NOT NULL COMMENT '发票类型',
  `fp_content` varchar(255) NOT NULL COMMENT '发票内容',
  `user_id` int(10) NOT NULL COMMENT '会员编号',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='发票表格';

/*Data for the table `ps_fp` */

insert  into `ps_fp`(`id`,`order_id`,`fp_title`,`fp_type`,`fp_content`,`user_id`,`created_at`,`updated_at`) values 
(1,1,'个人',0,'',0,'2017-02-22 10:19:56','2017-02-22 10:19:56'),
(2,2,'个人',0,'',0,'2017-02-22 10:20:18','2017-02-22 10:20:18'),
(3,3,'个人',0,'',0,'2017-02-22 10:20:49','2017-02-22 10:20:49'),
(4,5,'个人',0,'',0,'2017-02-23 03:01:27','2017-02-23 03:01:27'),
(5,6,'个人',0,'',0,'2017-02-23 03:28:57','2017-02-23 03:28:57'),
(6,7,'个人',0,'',0,'2017-02-24 01:04:08','2017-02-24 01:04:08'),
(7,1,'个人',0,'',0,'2017-02-24 01:08:16','2017-02-24 01:08:16'),
(8,2,'个人',0,'',0,'2017-02-24 01:08:34','2017-02-24 01:08:34'),
(9,4,'个人',0,'',0,'2017-02-24 01:48:32','2017-02-24 01:48:32'),
(10,5,'个人',0,'',0,'2017-02-24 01:48:54','2017-02-24 01:48:54'),
(11,7,'个人',0,'',0,'2017-09-08 14:20:20','2017-09-08 14:20:20');

/*Table structure for table `ps_friend_link` */

DROP TABLE IF EXISTS `ps_friend_link`;

CREATE TABLE `ps_friend_link` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `link_name` varchar(255) NOT NULL,
  `link_url` varchar(255) NOT NULL,
  `link_site` varchar(255) NOT NULL,
  `sort_order` int(10) NOT NULL COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `ps_friend_link` */

insert  into `ps_friend_link`(`id`,`link_name`,`link_url`,`link_site`,`sort_order`,`created_at`,`updated_at`) values 
(5,'测试链接','http://www.cw100.com','beijing',0,'2015-08-26 05:54:48','2015-08-26 05:54:48'),
(6,'威锋商城','http://www.fengbuy.com','0',0,'2016-01-05 04:30:14','2016-01-05 04:30:14');

/*Table structure for table `ps_goods` */

DROP TABLE IF EXISTS `ps_goods`;

CREATE TABLE `ps_goods` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` int(10) NOT NULL,
  `goods_sn` varchar(60) NOT NULL DEFAULT '',
  `goods_name` varchar(120) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `goods_name_style` varchar(60) NOT NULL DEFAULT '+',
  `click_count` int(10) unsigned NOT NULL DEFAULT '0',
  `brand_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `provider_name` varchar(100) NOT NULL DEFAULT '',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '0',
  `goods_weight` decimal(10,3) unsigned NOT NULL DEFAULT '0.000',
  `market_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `shop_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `refe_price` decimal(10,2) NOT NULL,
  `promote_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `promote_start_date` int(11) unsigned NOT NULL DEFAULT '0',
  `promote_end_date` int(11) unsigned NOT NULL DEFAULT '0',
  `warn_number` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `keywords` varchar(255) NOT NULL DEFAULT '',
  `goods_brief` varchar(255) NOT NULL DEFAULT '',
  `goods_desc` text NOT NULL,
  `goods_thumb` varchar(255) NOT NULL DEFAULT '',
  `goods_img` varchar(255) NOT NULL DEFAULT '',
  `original_img` varchar(255) NOT NULL DEFAULT '',
  `is_real` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `extension_code` varchar(30) NOT NULL DEFAULT '',
  `is_on_sale` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_alone_sale` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_shipping` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `integral` int(10) unsigned NOT NULL DEFAULT '0',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `sort_order` smallint(4) unsigned NOT NULL DEFAULT '100',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_best` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_new` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_promote` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `bonus_type_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `last_update` int(10) unsigned NOT NULL DEFAULT '0',
  `goods_type` smallint(5) unsigned NOT NULL DEFAULT '0',
  `seller_note` varchar(255) NOT NULL DEFAULT '',
  `give_integral` int(11) NOT NULL DEFAULT '-1',
  `rank_integral` int(11) NOT NULL DEFAULT '-1',
  `suppliers_id` smallint(5) unsigned DEFAULT NULL,
  `is_check` tinyint(1) unsigned DEFAULT NULL,
  `diy_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `site` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `goods_sn` (`goods_sn`),
  KEY `last_update` (`last_update`),
  KEY `brand_id` (`brand_id`),
  KEY `goods_weight` (`goods_weight`),
  KEY `promote_end_date` (`promote_end_date`),
  KEY `promote_start_date` (`promote_start_date`),
  KEY `goods_number` (`goods_number`),
  KEY `sort_order` (`sort_order`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `ps_goods` */

insert  into `ps_goods`(`id`,`cat_id`,`goods_sn`,`goods_name`,`goods_name_style`,`click_count`,`brand_id`,`provider_name`,`goods_number`,`goods_weight`,`market_price`,`shop_price`,`refe_price`,`promote_price`,`promote_start_date`,`promote_end_date`,`warn_number`,`keywords`,`goods_brief`,`goods_desc`,`goods_thumb`,`goods_img`,`original_img`,`is_real`,`extension_code`,`is_on_sale`,`is_alone_sale`,`is_shipping`,`integral`,`add_time`,`sort_order`,`is_delete`,`is_best`,`is_new`,`is_hot`,`is_promote`,`bonus_type_id`,`last_update`,`goods_type`,`seller_note`,`give_integral`,`rank_integral`,`suppliers_id`,`is_check`,`diy_url`,`created_at`,`updated_at`,`site`) values 
(1,2,'ps-20161018103118-WtQ','Libratone Zipp 无线音箱','+',0,1,'',122,0.000,1980.00,1200.00,0.00,0.00,0,0,0,'','','<h2>产品信息</h2><p><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161018/1476786791237610.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161018/1476786791210504.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161018/1476786791448289.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161018/1476786791184227.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161018/1476786791499312.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161018/1476786791523067.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161018/1476786791330336.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161018/1476786791288612.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161018/1476786791727631.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161018/1476786791291534.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161018/1476786791738230.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161018/1476786792156786.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161018/1476786792790935.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161018/1476786792251946.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161018/1476786792942786.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161018/1476786792110393.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161018/1476786792505900.jpg\" style=\"opacity: 1;\"/></p><p><br/></p>','','','',1,'',1,1,0,0,0,321,0,1,1,1,0,0,0,0,'',0,-1,NULL,NULL,'libratone-zipp','2016-11-22 15:36:47','2016-11-22 07:36:47',''),
(2,2,'ps-20161027040227-IlD','第一代 iPod 发布','+',0,0,'',1111,0.000,100.00,54.00,0.00,0.00,0,0,1,'','','<h2>产品信息</h2><p><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/B3/1000123/pieces/1_1449550547_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/B3/1000123/pieces/2_1449550547_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/B3/1000123/pieces/3_1449550547_detail.jpg\" style=\"opacity: 1;\"/></p><p><br/></p>','','','',1,'',1,1,0,0,0,0,0,1,1,1,0,0,0,0,'',0,-1,NULL,NULL,'','2017-01-09 11:08:18','2017-01-09 03:08:18',''),
(3,2,'ps-20161027043327-mRU','JBL E30 便携式头戴耳机','+',0,0,'',100,0.000,600.00,400.00,0.00,0.00,0,0,0,'','','<h2>产品信息</h2><p><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161027/1477542848650315.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" style=\"opacity: 1; transition: opacity 0.5s ease 0s;\" src=\"/ueditor/php/upload/image/20161027/1477542848520249.jpg\"/><img class=\"ng-scope ng-isolate-scope\" style=\"opacity: 1; transition: opacity 0.5s ease 0s;\" src=\"/ueditor/php/upload/image/20161027/1477542848669532.jpg\"/><img class=\"ng-scope ng-isolate-scope\" style=\"opacity: 1; transition: opacity 0.5s ease 0s;\" src=\"/ueditor/php/upload/image/20161027/1477542848706955.jpg\"/></p><p><br/></p>','','','',1,'',1,1,0,0,0,0,0,1,1,1,0,0,0,0,'',0,-1,NULL,NULL,'jbl-e30','2017-01-09 11:08:35','2017-01-09 03:08:35',''),
(4,2,'ps-20161027044627-ifT','JBL FLIP3 蓝牙便携音响','+',0,1,'',122,0.000,1000.00,233.00,0.00,0.00,0,0,0,'','','<h2>产品信息</h2><p><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161027/1477543663994224.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161027/1477543663340882.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161027/1477543663858042.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161027/1477543663680233.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161027/1477543663524618.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161027/1477543664448342.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161027/1477543664534089.jpg\" style=\"opacity: 1;\"/></p><p><br/></p>','','','',1,'',1,1,0,0,0,0,0,1,1,1,0,0,0,0,'',0,-1,NULL,NULL,'','2016-10-27 12:52:33','2016-10-27 04:52:33',''),
(5,2,'ps-20161027050327-clB','Sennheiser Urbanite XL 耳机','+',0,4,'',1111,0.000,2000.00,1500.00,0.00,0.00,0,0,0,'','','<h2>产品信息</h2><p><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161027/1477544702992604.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161027/1477544702544204.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161027/1477544702349498.jpg\" style=\"opacity: 1;\"/></p><p><br/></p>','','','',1,'',1,1,0,0,0,0,0,1,1,1,0,0,0,0,'',0,-1,NULL,NULL,'','2016-11-16 16:04:01','2016-11-16 08:04:01',''),
(6,2,'ps-20161027050827-Bdn','adidas/阿迪达斯 经典款全保护背壳 手机保护壳 for iPhone 7-天空蓝','+',0,2,'',1111,0.000,400.00,100.00,0.00,0.00,0,0,0,'','','<p><br/></p><p><a target=\"_blank\" href=\"http://www.fengbuy.com/activity/topic_140.html\"><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"http://www.fengbuy.com/media/catalog/photos/otherImage/8/APP_-750x430_.jpg\" alt=\"\" width=\"750\" height=\"637\"/></a></p><p><br/></p><p style=\"text-align: center;\"><strong><span style=\"font-family: verdana, geneva; font-size: large; color: #ff0000;\">❈推荐理由❈</span></strong></p><p style=\"text-align: center;\"><span style=\"color: #ff0000; font-family: verdana, geneva; font-size: small;\">①阿迪达斯官方授权设计</span></p><p style=\"text-align: center;\"><span style=\"color: #ff0000; font-family: verdana, geneva; font-size: small;\">②50%TPU和50%PC双材料结合</span></p><p style=\"text-align: center;\"><span style=\"font-family: verdana, geneva; font-size: small; color: #ff0000;\">③采用四边包边及按键全方位保护设计</span></p><p style=\"text-align: center;\"><span style=\"font-family: verdana, geneva; font-size: small; color: #ff0000;\">④边角特有耐磨防撞设计，是手机的坚强后盾</span></p><p><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"http://www.fengbuy.com/media/catalog/photos/product/8988/__01_1.jpg\" alt=\"\" width=\"790\"/></p><p><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"http://www.fengbuy.com/media/catalog/photos/product/8988/__02_1.jpg\" alt=\"\" width=\"790\"/></p><p><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"http://www.fengbuy.com/media/catalog/photos/product/8988/__03_1.jpg\" alt=\"\" width=\"790\"/></p><p><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"http://www.fengbuy.com/media/catalog/photos/product/8988/__04_1.jpg\" alt=\"\" width=\"790\"/></p><p><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"http://www.fengbuy.com/media/catalog/photos/product/8988/__05_1.jpg\" alt=\"\" width=\"790\"/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><h3>规格参数Specifications</h3><p><br/></p><p><br/></p><p><br/></p><table class=\"pro_data\"><caption>adidas/阿迪达斯 经典款全保护背壳 手机保护壳 for iPhone 7-天空蓝</caption><thead><tr class=\"firstRow\"><th class=\"pro_data_col\">规格名</th><th>内容</th></tr></thead><tbody><tr><td class=\"pro_data_col\">支持类型</td><td>iPhone 7</td></tr><tr class=\"pro_data_even\"><td class=\"pro_data_col\">品牌名称</td><td>adidas/阿迪达斯</td></tr><tr><td class=\"pro_data_col\">品牌地点</td><td>德国（Germany）</td></tr><tr class=\"pro_data_even\"><td class=\"pro_data_col\">商品型号</td><td>adidas/阿迪达斯 经典款全保护背壳</td></tr><tr class=\"pro_data_even\"><td class=\"pro_data_col\">商品材质</td><td>TPU&amp;PC材质</td></tr></tbody></table><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><h3>产品实拍Product Photos</h3><p><br/></p><p><br/></p><p><br/></p><p><img alt=\"\" src=\"http://www.fengbuy.com/media/catalog/photos/product/9426/_750-1.jpg\" longdesc=\"http://www.fengbuy.com/media/catalog/photos/product/9426/_750-1.jpg\" style=\"\" width=\"762\" height=\"762\"/></p><p><br/></p><p><img alt=\"\" src=\"http://www.fengbuy.com/media/catalog/photos/product/9426/_750-2.jpg\" longdesc=\"http://www.fengbuy.com/media/catalog/photos/product/9426/_750-2.jpg\" style=\"\" width=\"750\" height=\"750\"/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><p><br/></p><h3>包装清单Packing List</h3><p><br/></p><p><br/></p><p><br/></p><table class=\"pro_data pro_data_nohead pro_pack\"><thead><tr class=\"firstRow\"><th class=\"pro_data_col\">规格名</th><th>内容</th></tr></thead><tbody><tr><td class=\"pro_data_col\">保护壳</td><td>adidas/阿迪达斯 经典款全保护背壳 x1</td></tr></tbody></table><p><br/></p><p><br/></p><p><br/></p><p><br/></p><h3>售后服务Customer Service</h3><p><br/></p><p><br/></p><p>威锋商城所售产品均为正品，如有任何问题可与我们的客服人员联系，我们会在第一时间跟您沟通处理。<br/>详情请查看<a href=\"http://www.fengbuy.com/others/index/index/id/13/\" target=\"_blank\"><strong style=\"color:#09f; padding:0 3px; text-decoration:underline\">售后服务政策</strong></a></p><p><br/></p><p><br/></p><table class=\"pro_data\"><tbody><tr class=\"firstRow\"><td class=\"pro_data_col\"><strong>售后服务</strong></td><td style=\"padding: 10px; text-align: left;\">支持<span style=\"color: red;\">7天无理由退换货<span style=\"color: #333333;\">、</span>30天质量问题换货</span>以及<span style=\"color: red;\">30天原品退换货</span>服务！</td></tr><tr><td class=\"pro_data_col\"><strong>质保及维修</strong></td><td style=\"padding: 10px; text-align: left;\">该商品为外观保护用途，属易耗品，不提供质保及维修。</td></tr><tr class=\"pro_data_even\"><td class=\"pro_data_col\"><strong>保修方式</strong></td><td style=\"padding: 10px; text-align: left;\">不提供保修。</td></tr></tbody></table><p><br/></p>','','','',1,'',1,1,0,0,0,0,0,1,1,1,0,0,0,0,'',0,-1,NULL,NULL,'','2016-11-23 11:57:56','2016-11-23 03:57:56',''),
(7,2,'ps-20161027052327-cBx','手机壳','+',0,0,'',1111,0.000,111.00,21.00,0.00,0.00,0,0,0,'','','            \r\n            ','','','',1,'',1,1,0,0,0,32,0,0,1,0,0,0,0,0,'',0,-1,NULL,NULL,'','2016-11-22 15:36:37','2016-11-22 07:36:37',''),
(8,2,'ps-20161027052627-x5V','弗莱明发现青霉素','+',0,0,'',1111,0.000,111.00,21.00,0.00,0.00,0,0,1,'','','<h2>产品信息</h2><p><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161027/1477545998118788.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161027/1477545998242554.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"/ueditor/php/upload/image/20161027/1477545998395923.jpg\" style=\"opacity: 1;\"/></p><p><br/></p>','','','',1,'',1,1,0,0,0,1,0,1,1,1,0,0,0,0,'',0,-1,NULL,NULL,'qms','2017-01-09 11:07:20','2017-01-09 03:07:20',''),
(9,2,'ps-20161027132627-GK3','告别宝丽来','+',0,4,'',5,0.000,111.00,25.00,0.00,0.00,0,0,0,'','TPU环保材质、细腻防滑、防油污','<h2>产品信息</h2><p><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/1_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/2_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/3_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/4_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/5_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/6_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/7_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/8_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/9_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/10_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/11_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/12_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/13_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/14_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/15_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/16_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/17_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/18_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/19_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/20_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/21_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/22_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/23_1478759958_detail.jpg\" style=\"opacity: 1;\"/><img class=\"ng-scope ng-isolate-scope\" src=\"http://img01.smartisanos.cn/9D/1000231/pieces/24_1478759958_detail.jpg\" style=\"opacity: 1;\"/></p><p><br/></p>','','','',1,'',1,1,0,0,0,123,0,1,0,0,0,0,0,0,'',0,-1,NULL,NULL,'','2017-10-31 14:23:34','2017-10-31 06:23:34','');

/*Table structure for table `ps_goods_article` */

DROP TABLE IF EXISTS `ps_goods_article`;

CREATE TABLE `ps_goods_article` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `goods_id` int(10) NOT NULL COMMENT '商品编号',
  `article_id` int(10) NOT NULL COMMENT '文章编号',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;

/*Data for the table `ps_goods_article` */

insert  into `ps_goods_article`(`id`,`goods_id`,`article_id`,`created_at`,`updated_at`) values 
(89,9,5,'2017-10-31 06:23:34','2017-10-31 06:23:34'),
(90,9,6,'2017-10-31 06:23:34','2017-10-31 06:23:34'),
(91,9,8,'2017-10-31 06:23:34','2017-10-31 06:23:34'),
(92,9,9,'2017-10-31 06:23:34','2017-10-31 06:23:34');

/*Table structure for table `ps_goods_attr` */

DROP TABLE IF EXISTS `ps_goods_attr`;

CREATE TABLE `ps_goods_attr` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `goods_id` mediumint(8) NOT NULL,
  `attr_id` tinyint(5) NOT NULL,
  `attr_value` text COLLATE utf8_bin NOT NULL,
  `attr_price` varchar(255) COLLATE utf8_bin NOT NULL,
  `color_value` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '颜色的16进制值',
  `color_img` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '颜色图片',
  `sort_order` int(10) NOT NULL COMMENT '颜色属性排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `ps_goods_attr` */

insert  into `ps_goods_attr`(`id`,`goods_id`,`attr_id`,`attr_value`,`attr_price`,`color_value`,`color_img`,`sort_order`,`created_at`,`updated_at`) values 
(1,1,9,'红色','','rgb(211, 22, 164)','images//201610/c6ceeb6273e7ea0d3cd55b60ca36e3ba.jpg',0,'2016-10-27 12:29:26','2016-10-27 04:29:26'),
(2,1,9,'白色','','rgb(227, 233, 218)','images//201610/6aad527bce2a1c556fc6125f8e1e573f.jpg',0,'2016-10-27 12:29:42','2016-10-27 04:29:42'),
(3,1,9,'黑色','','rgb(38, 35, 33)','images//201610/fa05e3babb27219cb3f7b37ac2bd612b.jpg',0,'2016-10-27 12:29:50','2016-10-27 04:29:50'),
(4,1,9,'绿色','','rgb(26, 169, 75)','images//201610/d2aa67b0c4f7b242997483382e743b3b.jpg',0,'2016-10-27 12:29:58','2016-10-27 04:29:58'),
(24,9,10,'老挝','','','',0,'2016-11-22 11:06:24','2016-11-22 03:06:24'),
(23,9,10,'柬埔寨','','','',0,'2016-11-22 11:06:24','2016-11-22 03:06:24'),
(22,9,10,'北京','','','',0,'2016-11-22 11:06:24','2016-11-22 03:06:24'),
(20,6,9,'白色','','','',0,'2016-11-17 11:13:40','2016-11-17 03:13:40'),
(17,9,9,'紫色','','','',0,'2016-11-22 11:06:24','2016-11-22 03:06:24'),
(16,9,9,'天湖蓝','','','',0,'2016-11-22 11:06:24','2016-11-22 03:06:24'),
(21,6,9,'红色','','','',0,'2016-11-17 11:13:40','2016-11-17 03:13:40'),
(25,9,9,'红色','','','',0,'2017-01-08 23:04:08','2017-01-08 15:04:08'),
(26,8,9,'红色','','','',0,'2017-01-09 11:07:20','2017-01-09 03:07:20'),
(27,8,10,'老挝','','','',0,'2017-01-09 11:07:20','2017-01-09 03:07:20'),
(28,2,9,'红色','','','',0,'2017-01-09 11:08:18','2017-01-09 03:08:18'),
(29,2,10,'北京','','','',0,'2017-01-09 11:08:18','2017-01-09 03:08:18'),
(30,3,9,'黑色','','','',0,'2017-01-09 11:08:35','2017-01-09 03:08:35'),
(31,3,10,'新加坡','','','',0,'2017-01-09 11:08:35','2017-01-09 03:08:35');

/*Table structure for table `ps_goods_cat` */

DROP TABLE IF EXISTS `ps_goods_cat`;

CREATE TABLE `ps_goods_cat` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `cat_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

/*Data for the table `ps_goods_cat` */

insert  into `ps_goods_cat`(`id`,`goods_id`,`cat_id`,`created_at`,`updated_at`) values 
(1,40,207,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2,41,215,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3,55,215,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(4,56,216,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(5,57,216,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(6,61,215,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(7,62,207,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(8,63,216,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(9,65,216,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(10,64,215,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(11,66,216,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(12,66,123,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(13,66,216,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(14,69,215,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(20,71,215,'2014-11-10 22:31:29','2014-11-10 22:31:29'),
(19,71,210,'2014-11-10 22:31:29','2014-11-10 22:31:29'),
(17,71,208,'2014-11-10 18:46:35','2014-11-10 18:46:35'),
(18,71,123,'2014-11-10 18:46:35','2014-11-10 18:46:35'),
(22,74,213,'2014-11-10 22:43:19','2014-11-10 22:43:19'),
(23,74,123,'2014-11-10 22:43:19','2014-11-10 22:43:19'),
(24,1,213,'2014-11-11 00:20:44','2014-11-11 00:20:44'),
(25,8,211,'2014-11-14 11:02:30','2014-11-14 11:02:30'),
(26,12,216,'2014-11-14 11:11:15','2014-11-14 11:11:15'),
(27,1,207,'2014-11-14 17:48:31','2014-11-14 17:48:31'),
(28,12,206,'2014-11-18 21:58:41','2014-11-18 21:58:41'),
(29,13,216,'2014-11-18 22:15:19','2014-11-18 22:15:19'),
(30,13,207,'2014-11-18 22:15:19','2014-11-18 22:15:19'),
(31,14,217,'2014-11-18 23:05:00','2014-11-18 23:05:00'),
(32,26,220,'2014-11-24 23:49:06','2014-11-24 23:49:06');

/*Table structure for table `ps_goods_colors` */

DROP TABLE IF EXISTS `ps_goods_colors`;

CREATE TABLE `ps_goods_colors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL COMMENT '商品编号',
  `goods_attr_id` int(11) NOT NULL COMMENT '商品属性编号',
  `thumb` varchar(255) NOT NULL COMMENT '颜色相册的缩略图',
  `img` varchar(255) NOT NULL COMMENT '颜色相册的详情页面的图片',
  `original` varchar(255) NOT NULL COMMENT '颜色详细的原始图片',
  `color_value` varchar(255) NOT NULL COMMENT '颜色的12进制的值',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ps_goods_colors` */

/*Table structure for table `ps_goods_field` */

DROP TABLE IF EXISTS `ps_goods_field`;

CREATE TABLE `ps_goods_field` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `goods_id` int(10) NOT NULL COMMENT '商品编号',
  `field_id` int(10) NOT NULL COMMENT '规格编号',
  `field_value` varchar(255) NOT NULL COMMENT '规格值',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='商品规格值表';

/*Data for the table `ps_goods_field` */

insert  into `ps_goods_field`(`id`,`goods_id`,`field_id`,`field_value`,`created_at`,`updated_at`) values 
(7,9,4,'不锈钢','2017-10-31 14:23:34','0000-00-00 00:00:00'),
(8,9,5,'北京','2017-10-31 14:23:34','0000-00-00 00:00:00'),
(9,9,8,'美国','2017-10-31 14:23:34','0000-00-00 00:00:00');

/*Table structure for table `ps_goods_gallery` */

DROP TABLE IF EXISTS `ps_goods_gallery`;

CREATE TABLE `ps_goods_gallery` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `original` varchar(255) NOT NULL,
  `img_desc` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

/*Data for the table `ps_goods_gallery` */

insert  into `ps_goods_gallery`(`id`,`goods_id`,`thumb`,`img`,`original`,`img_desc`,`created_at`,`updated_at`) values 
(44,1,'images/goods/201610/thumb/201610181726181476811582_chce9MGwHF-thumb.jpg','images/goods/201610/img/201610181726181476811582_chce9MGwHF-img.jpg','images/goods/201610/original/201610181726181476811582_chce9MGwHF-original.jpg','','2016-10-19 01:26:23','2016-10-18 17:26:23'),
(45,1,'images/goods/201610/thumb/201610181726181476811583_9kVvHQGvtu-thumb.jpg','images/goods/201610/img/201610181726181476811583_9kVvHQGvtu-img.jpg','images/goods/201610/original/201610181726181476811583_9kVvHQGvtu-original.jpg','','2016-10-19 01:26:23','2016-10-18 17:26:23'),
(46,2,'images/goods/201610/thumb/201610270403271477541004_bp7eGxGHEZ-thumb.jpg','images/goods/201610/img/201610270403271477541004_bp7eGxGHEZ-img.jpg','images/goods/201610/original/201610270403271477541004_bp7eGxGHEZ-original.jpg','','2016-10-27 12:03:30','2016-10-27 04:03:30'),
(47,2,'images/goods/201610/thumb/201610270403271477541010_UU8s4AB5DH-thumb.jpg','images/goods/201610/img/201610270403271477541010_UU8s4AB5DH-img.jpg','images/goods/201610/original/201610270403271477541010_UU8s4AB5DH-original.jpg','','2016-10-27 12:04:55','2016-10-27 04:04:55'),
(49,3,'images/goods/201610/thumb/201610270435271477542942_HrkcIA70HM-thumb.jpg','images/goods/201610/img/201610270435271477542942_HrkcIA70HM-img.jpg','images/goods/201610/original/201610270435271477542942_HrkcIA70HM-original.jpg','','2016-10-27 12:35:43','2016-10-27 04:35:43'),
(50,3,'images/goods/201610/thumb/201610270435271477542943_tK6vlDEcB4-thumb.jpg','images/goods/201610/img/201610270435271477542943_tK6vlDEcB4-img.jpg','images/goods/201610/original/201610270435271477542943_tK6vlDEcB4-original.jpg','','2016-10-27 12:35:43','2016-10-27 04:35:43'),
(51,3,'images/goods/201610/thumb/201610270435271477542943_wR6vzW03M8-thumb.jpg','images/goods/201610/img/201610270435271477542943_wR6vzW03M8-img.jpg','images/goods/201610/original/201610270435271477542943_wR6vzW03M8-original.jpg','','2016-10-27 12:35:43','2016-10-27 04:35:43'),
(52,4,'images/goods/201610/thumb/201610270447271477543667_VuzxoyCEP0-thumb.jpg','images/goods/201610/img/201610270447271477543667_VuzxoyCEP0-img.jpg','images/goods/201610/original/201610270447271477543667_VuzxoyCEP0-original.jpg','','2016-10-27 12:47:48','2016-10-27 04:47:48'),
(53,4,'images/goods/201610/thumb/201610270447271477543668_qzWKfz9Mxo-thumb.jpg','images/goods/201610/img/201610270447271477543668_qzWKfz9Mxo-img.jpg','images/goods/201610/original/201610270447271477543668_qzWKfz9Mxo-original.jpg','','2016-10-27 12:47:48','2016-10-27 04:47:48'),
(54,4,'images/goods/201610/thumb/201610270447271477543668_Q2UO4CJHK6-thumb.jpg','images/goods/201610/img/201610270447271477543668_Q2UO4CJHK6-img.jpg','images/goods/201610/original/201610270447271477543668_Q2UO4CJHK6-original.jpg','','2016-10-27 12:47:49','2016-10-27 04:47:49'),
(55,4,'images/goods/201610/thumb/201610270447271477543669_GB9HTjUDiV-thumb.jpg','images/goods/201610/img/201610270447271477543669_GB9HTjUDiV-img.jpg','images/goods/201610/original/201610270447271477543669_GB9HTjUDiV-original.jpg','','2016-10-27 12:47:49','2016-10-27 04:47:49'),
(57,5,'images/goods/201610/thumb/201610270505271477544708_MYJ3iGT0Uu-thumb.jpg','images/goods/201610/img/201610270505271477544708_MYJ3iGT0Uu-img.jpg','images/goods/201610/original/201610270505271477544708_MYJ3iGT0Uu-original.jpg','','2016-10-27 13:05:09','2016-10-27 05:05:09'),
(58,5,'images/goods/201610/thumb/201610270505271477544709_RomWiJgldP-thumb.jpg','images/goods/201610/img/201610270505271477544709_RomWiJgldP-img.jpg','images/goods/201610/original/201610270505271477544709_RomWiJgldP-original.jpg','','2016-10-27 13:05:09','2016-10-27 05:05:09'),
(59,5,'images/goods/201610/thumb/201610270505271477544709_76YQSyahcO-thumb.jpg','images/goods/201610/img/201610270505271477544709_76YQSyahcO-img.jpg','images/goods/201610/original/201610270505271477544709_76YQSyahcO-original.jpg','','2016-10-27 13:05:10','2016-10-27 05:05:10'),
(60,5,'images/goods/201610/thumb/201610270505271477544710_yl0Oc1fNdM-thumb.jpg','images/goods/201610/img/201610270505271477544710_yl0Oc1fNdM-img.jpg','images/goods/201610/original/201610270505271477544710_yl0Oc1fNdM-original.jpg','','2016-10-27 13:05:10','2016-10-27 05:05:10'),
(62,6,'images/goods/201610/thumb/201610270509271477544995_KDDIXUEouo-thumb.jpg','images/goods/201610/img/201610270509271477544995_KDDIXUEouo-img.jpg','images/goods/201610/original/201610270509271477544995_KDDIXUEouo-original.jpg','','2016-10-27 13:09:56','2016-10-27 05:09:56'),
(63,6,'images/goods/201610/thumb/201610270509271477544996_XaW35MgSRZ-thumb.jpg','images/goods/201610/img/201610270509271477544996_XaW35MgSRZ-img.jpg','images/goods/201610/original/201610270509271477544996_XaW35MgSRZ-original.jpg','','2016-10-27 13:09:56','2016-10-27 05:09:56'),
(64,7,'images/goods/201610/thumb/201610270524271477545853_ROdfwfDmJe-thumb.jpg','images/goods/201610/img/201610270524271477545853_ROdfwfDmJe-img.jpg','images/goods/201610/original/201610270524271477545853_ROdfwfDmJe-original.jpg','','2016-10-27 13:24:14','2016-10-27 05:24:14'),
(65,7,'images/goods/201610/thumb/201610270524271477545854_oM4Ifup0cU-thumb.jpg','images/goods/201610/img/201610270524271477545854_oM4Ifup0cU-img.jpg','images/goods/201610/original/201610270524271477545854_oM4Ifup0cU-original.jpg','','2016-10-27 13:24:15','2016-10-27 05:24:15'),
(66,8,'images/goods/201610/thumb/201610270527271477546039_bgrSwUEEJw-thumb.jpg','images/goods/201610/img/201610270527271477546039_bgrSwUEEJw-img.jpg','images/goods/201610/original/201610270527271477546039_bgrSwUEEJw-original.jpg','','2016-10-27 13:27:19','2016-10-27 05:27:19'),
(67,8,'images/goods/201610/thumb/201610270527271477546039_wsYSwplCT9-thumb.jpg','images/goods/201610/img/201610270527271477546039_wsYSwplCT9-img.jpg','images/goods/201610/original/201610270527271477546039_wsYSwplCT9-original.jpg','','2016-10-27 13:27:20','2016-10-27 05:27:20'),
(68,9,'images/goods/201610/thumb/201610271327271477574864_kIpo5yu7v4-thumb.jpg','images/goods/201610/img/201610271327271477574864_kIpo5yu7v4-img.jpg','images/goods/201610/original/201610271327271477574864_kIpo5yu7v4-original.jpg','','2016-10-27 21:27:44','2016-10-27 13:27:44'),
(69,9,'images/goods/201610/thumb/201610271327271477574864_x67G7F0H5U-thumb.jpg','images/goods/201610/img/201610271327271477574864_x67G7F0H5U-img.jpg','images/goods/201610/original/201610271327271477574864_x67G7F0H5U-original.jpg','','2016-10-27 21:27:45','2016-10-27 13:27:45'),
(70,3,'images/goods/201611/thumb/201611130716131479021377_IMZTIX2MNs-thumb.jpg','images/goods/201611/img/201611130716131479021377_IMZTIX2MNs-img.jpg','images/goods/201611/original/201611130716131479021377_IMZTIX2MNs-original.jpg','','2016-11-13 15:16:18','2016-11-13 07:16:18');

/*Table structure for table `ps_goods_relation` */

DROP TABLE IF EXISTS `ps_goods_relation`;

CREATE TABLE `ps_goods_relation` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `goods_id` int(10) NOT NULL COMMENT '商品编号',
  `relation_goods_id` int(10) NOT NULL COMMENT '关联的商品编号',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='关联商品表';

/*Data for the table `ps_goods_relation` */

insert  into `ps_goods_relation`(`id`,`goods_id`,`relation_goods_id`,`created_at`,`updated_at`) values 
(31,9,1,'2016-10-31 15:41:25','2016-10-31 15:41:25'),
(32,9,2,'2016-10-31 15:41:25','2016-10-31 15:41:25'),
(33,9,3,'2016-10-31 15:41:25','2016-10-31 15:41:25');

/*Table structure for table `ps_goods_type` */

DROP TABLE IF EXISTS `ps_goods_type`;

CREATE TABLE `ps_goods_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `type_name` varchar(255) NOT NULL COMMENT '类型名称',
  `sort_order` int(10) NOT NULL COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `ps_goods_type` */

insert  into `ps_goods_type`(`id`,`type_name`,`sort_order`,`created_at`,`updated_at`) values 
(1,'大家电',0,'2015-07-28 10:16:33','0000-00-00 00:00:00'),
(2,'家具',0,'2015-07-28 10:16:41','0000-00-00 00:00:00'),
(3,'测试产品',0,'2015-07-28 10:16:46','0000-00-00 00:00:00'),
(4,'冰箱',0,'2015-08-30 14:17:13','0000-00-00 00:00:00'),
(5,'测试类型',0,'2016-01-25 21:30:21','0000-00-00 00:00:00'),
(6,'数码产品',0,'2016-05-24 01:36:23','0000-00-00 00:00:00');

/*Table structure for table `ps_image` */

DROP TABLE IF EXISTS `ps_image`;

CREATE TABLE `ps_image` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `img_name` varchar(255) NOT NULL,
  `img_url` varchar(255) NOT NULL,
  `img_src` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `img_tag` varchar(255) NOT NULL,
  `img_site` int(10) NOT NULL,
  `sort_order` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `ps_image` */

insert  into `ps_image`(`id`,`img_name`,`img_url`,`img_src`,`position`,`img_tag`,`img_site`,`sort_order`,`cat_id`,`created_at`,`updated_at`) values 
(5,'测试图片','http://www.phpstore.cn','images/common/201611/20161107030471478487887_prNDXqJN8M.png','0','home_ad5',0,0,0,'2016-11-07 11:04:48','2016-11-07 03:04:48'),
(6,'ad1','http://www.phpstore.cn','images/common/201611/201611120425121478924756_V0Zqr16yuv.jpeg','0','ad1',0,0,0,'2016-11-12 04:25:56','2016-11-12 04:25:56'),
(7,'首页图片2','','images/common/201611/201611120426121478924781_XyKXVIHuAh.jpeg','0','ad2',0,0,0,'2016-11-12 04:26:21','2016-11-12 04:26:21'),
(8,'首页图片3','','images/common/201611/201611120426121478924798_lKZS1S1IJ7.jpeg','0','ad3',0,0,0,'2016-11-12 04:26:38','2016-11-12 04:26:38'),
(9,'首页图片4','','images/common/201611/201611120426121478924815_bLox41V37h.jpeg','0','ad4',0,0,0,'2016-11-12 04:26:55','2016-11-12 04:26:55');

/*Table structure for table `ps_log` */

DROP TABLE IF EXISTS `ps_log`;

CREATE TABLE `ps_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `log_info` text CHARACTER SET utf8 NOT NULL COMMENT '日志内容',
  `user_id` int(10) NOT NULL COMMENT '操作管理员id',
  `ip` varchar(255) NOT NULL COMMENT '登录ip',
  `add_time` int(10) NOT NULL COMMENT '操作的时间戳',
  `sort_order` int(10) NOT NULL COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `ps_log` */

/*Table structure for table `ps_message` */

DROP TABLE IF EXISTS `ps_message`;

CREATE TABLE `ps_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL COMMENT '类型',
  `id_value` varchar(255) NOT NULL COMMENT '商品或者文章的编号',
  `email` varchar(255) NOT NULL COMMENT '电子邮件',
  `username` varchar(255) NOT NULL COMMENT '会员名称',
  `content` text NOT NULL COMMENT '评价内容',
  `rank` int(11) NOT NULL COMMENT '评级等级',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  `front_ip` varchar(255) NOT NULL COMMENT '用户添加的ip',
  `admin_ip` varchar(255) NOT NULL COMMENT '管理员回复ip',
  `status` int(11) NOT NULL COMMENT '状态',
  `parent_id` int(11) NOT NULL COMMENT '管理员回复编号',
  `admin` varchar(255) NOT NULL COMMENT '管理员名字',
  `reply` text NOT NULL COMMENT '回复内容',
  `reply_time` int(10) NOT NULL COMMENT '回复时间',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

/*Data for the table `ps_message` */

insert  into `ps_message`(`id`,`type`,`id_value`,`email`,`username`,`content`,`rank`,`add_time`,`front_ip`,`admin_ip`,`status`,`parent_id`,`admin`,`reply`,`reply_time`,`created_at`,`updated_at`) values 
(6,'留言','','01111222111@163.com','sunweihua','12233',1,1482763374,'::1','::1',1,0,'admin','',1483000429,'2016-12-26 14:42:54','2016-12-29 08:33:49'),
(7,'留言','','admin@admin.com','sunweihua','使用以下给出的这份超级简单的 HTML 模版，或者修改这些实例。我们强烈建议你对这些实例按照自己的需求进行修改，而不要简单的复制、粘贴。\r\n\r\n拷贝并粘贴下面给出的 HTML 代码，这就是一个最简单的 Bootstrap 页面了。',5,1483003059,'::1','::1',1,0,'admin','',1483003074,'2016-12-29 09:17:39','2016-12-29 09:17:54'),
(8,'留言','','david.swh@vip.163.com','sunweihua','LaraStore商城系统是全网首款基于Laravel框架的商城系统。LaraStore系统的历时3年研发，基于Laravel LTS版本，代码工整，分层清晰！利于二次开发。整合阿里云oss存储，vuejs实现流畅的ajax应用！基于api的模式 方便对多个终端进行统一整合和管理。',5,1483005443,'::1','::1',1,0,'admin','谢谢支持',1483005762,'2016-12-29 09:57:23','2016-12-29 10:02:42'),
(9,'评价','9','17701228800@163.com','sunweihua','感觉很不错 谢谢',5,1484103370,'::1','',0,0,'','',0,'2017-01-11 02:56:10','2017-01-11 02:56:10'),
(10,'评价','9','17701228800@163.com','sunweihua','谢谢',2,1484105069,'::1','',0,0,'','',0,'2017-01-11 03:24:29','2017-01-11 03:24:29'),
(15,'评价','9','17701228800@163.com','sunweihua','感觉 还不错 很棒的',5,1484119256,'::1','::1',1,0,'admin','谢谢支持',1484119307,'2017-01-11 07:20:56','2017-01-11 07:21:47'),
(16,'评价','9','17701228800@163.com','sunweihua','1122222',3,1484119380,'::1','',1,0,'','',0,'2017-01-11 07:23:00','2017-01-11 07:23:00'),
(17,'评价','9','17701228800@163.com','sunweihua','感觉 还不错',2,1484119558,'::1','',1,0,'','',0,'2017-01-11 07:25:58','2017-01-11 07:25:58'),
(18,'评价','8','17701228800@163.com','sunweihua','1222',5,1484119666,'::1','',1,0,'','',0,'2017-01-11 07:27:46','2017-01-11 07:27:46'),
(19,'评价','1','17701228800@163.com','sunweihua','感觉不错',3,1484120159,'::1','::1',1,0,'admin','',1484122772,'2017-01-11 07:35:59','2017-01-11 08:19:32'),
(20,'评价','1','17701228800@163.com','sunweihua','谢谢支持',5,1486436812,'::1','',1,0,'','',0,'2017-02-07 03:06:52','2017-02-07 03:06:52'),
(21,'评价','5','17701228800@163.com','sunweihua','12222',5,1488187915,'::1','',1,0,'','',0,'2017-02-27 09:31:55','2017-02-27 09:31:55'),
(22,'评价','5','17701228800@163.com','sunweihua','12222',5,1488187919,'::1','',1,0,'','',0,'2017-02-27 09:31:59','2017-02-27 09:31:59');

/*Table structure for table `ps_migrations` */

DROP TABLE IF EXISTS `ps_migrations`;

CREATE TABLE `ps_migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `ps_migrations` */

insert  into `ps_migrations`(`migration`,`batch`) values 
('2016_02_24_021456_create_sessions_table',1),
('2016_02_24_024617_create_template_config_table',2),
('2016_03_14_130047_create_orderlog_table',3),
('2016_03_14_140756_create_order_express_table',4),
('2016_03_16_172716_create_order_return_table',5),
('2016_03_21_082405_create_user_account',6),
('2016_03_22_184147_create_message_table',7),
('2016_03_24_050932_create_sms_table',8),
('2016_03_24_054453_create_sms_table',9),
('2016_03_25_134414_create_card_table',10),
('2016_03_25_143502_create_gift_card_table',11),
('2016_04_09_155823_create_style_table',12),
('2016_04_09_183325_create_product_table',13),
('2016_04_12_063127_create_demo_table',14),
('2016_04_28_055751_create_wap_config_table',15),
('2016_05_12_143059_create_node_table',16),
('2016_05_12_143618_create_nodes_table',17),
('2016_05_12_144258_create_cats_table',18),
('2016_05_13_091801_create_categories_table',19),
('2016_06_27_021809_create_table_admins_role',20),
('2016_07_13_023452_create_tests_table',21),
('2016_09_30_034545_create_region_shipping_table',22),
('2016_10_18_175524_create_goods_colors_table',23),
('2016_11_07_150521_create_themes_table',24);

/*Table structure for table `ps_nav` */

DROP TABLE IF EXISTS `ps_nav`;

CREATE TABLE `ps_nav` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nav_name` varchar(255) NOT NULL,
  `nav_url` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL COMMENT '站外链接',
  `position` varchar(255) NOT NULL,
  `sort_order` int(10) NOT NULL,
  `opennew` int(10) NOT NULL,
  `nav_pic` varchar(255) NOT NULL,
  `is_show` int(10) NOT NULL,
  `nav_type` varchar(255) NOT NULL,
  `note` text NOT NULL COMMENT '导航栏说明',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

/*Data for the table `ps_nav` */

insert  into `ps_nav`(`id`,`nav_name`,`nav_url`,`link`,`position`,`sort_order`,`opennew`,`nav_pic`,`is_show`,`nav_type`,`note`,`created_at`,`updated_at`) values 
(56,'家电测试','category/2','','middle',0,1,'',1,'category','','2016-11-06 00:51:58','2016-11-05 16:51:58'),
(57,'供货商注册','supplier/register','','middle',0,1,'',1,'','','2016-07-27 03:15:05','2016-07-26 19:15:05'),
(59,'标签','tag','','middle',0,1,'',1,'','','2016-07-27 03:14:45','2016-07-26 19:14:45'),
(60,'供货商登录','supplier/login','','middle',0,1,'',1,'','','2016-07-27 03:14:33','2016-07-26 19:14:33'),
(61,'留言板','message','','middle',0,1,'',1,'','','2016-07-27 03:14:22','2016-07-26 19:14:22'),
(62,'品牌列表','brand','','middle',0,1,'',1,'','','2016-07-27 03:14:06','2016-07-26 19:14:06'),
(63,'批量下单','auth/batch-order','','middle',0,1,'images/common/201610/3dddc656dd6807ce94158c7d7e55664c.png',1,'','','2017-02-03 09:03:03','2017-02-03 01:03:03'),
(64,'首页','/','','middle',0,1,'',1,'','','2016-11-10 07:42:54','2016-11-10 07:42:54'),
(65,'测试标题-2311','category/2','','',0,1,'',1,'','<p>abdede<br/></p>','2017-02-09 23:18:53','2017-02-09 15:18:53');

/*Table structure for table `ps_order_express` */

DROP TABLE IF EXISTS `ps_order_express`;

CREATE TABLE `ps_order_express` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(255) NOT NULL COMMENT '订单号',
  `express_sn` varchar(255) NOT NULL COMMENT '快递单号',
  `express_name` varchar(255) NOT NULL COMMENT '快递名称',
  `add_time` int(11) NOT NULL COMMENT '发货时间',
  `address` varchar(255) NOT NULL COMMENT '收货地址',
  `consignee` varchar(255) NOT NULL COMMENT '收货人姓名',
  `phone` varchar(255) NOT NULL COMMENT '联系方式',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ps_order_express` */

/*Table structure for table `ps_order_goods` */

DROP TABLE IF EXISTS `ps_order_goods`;

CREATE TABLE `ps_order_goods` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_name` varchar(120) NOT NULL DEFAULT '',
  `goods_sn` varchar(60) NOT NULL DEFAULT '',
  `product_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '1',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shop_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `goods_attr` text NOT NULL,
  `send_number` smallint(5) unsigned NOT NULL DEFAULT '0',
  `is_real` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `extension_code` varchar(30) NOT NULL DEFAULT '',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `is_gift` smallint(5) unsigned NOT NULL DEFAULT '0',
  `goods_attr_id` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `ps_order_goods` */

insert  into `ps_order_goods`(`id`,`order_id`,`goods_id`,`goods_name`,`goods_sn`,`product_id`,`goods_number`,`market_price`,`shop_price`,`goods_attr`,`send_number`,`is_real`,`extension_code`,`parent_id`,`is_gift`,`goods_attr_id`,`created_at`,`updated_at`) values 
(1,1,9,'告别宝丽来','ps-20161027132627-GK3',0,1,111.00,25.00,'',0,0,'',0,0,'','2017-02-24 01:08:16','2017-02-24 01:08:16'),
(2,2,8,'弗莱明发现青霉素','ps-20161027052627-x5V',0,1,111.00,21.00,'',0,0,'',0,0,'','2017-02-24 01:08:34','2017-02-24 01:08:34'),
(3,3,8,'弗莱明发现青霉素','ps-20161027052627-x5V',0,1,111.00,21.00,'',0,0,'',0,0,'','2017-02-24 01:13:03','2017-02-24 01:13:03'),
(4,3,9,'告别宝丽来','ps-20161027132627-GK3',0,1,111.00,25.00,'',0,0,'',0,0,'','2017-02-24 01:13:03','2017-02-24 01:13:03'),
(5,4,6,'adidas/阿迪达斯 经典款全保护背壳 手机保护壳 for iPhone 7-天空蓝','ps-20161027050827-Bdn',0,1,400.00,100.00,'',0,0,'',0,0,'','2017-02-24 01:48:32','2017-02-24 01:48:32'),
(6,5,4,'JBL FLIP3 蓝牙便携音响','ps-20161027044627-ifT',0,1,1000.00,233.00,'',0,0,'',0,0,'','2017-02-24 01:48:54','2017-02-24 01:48:54'),
(7,6,4,'JBL FLIP3 蓝牙便携音响','ps-20161027044627-ifT',0,1,1000.00,233.00,'',0,0,'',0,0,'','2017-02-24 01:49:06','2017-02-24 01:49:06'),
(8,6,6,'adidas/阿迪达斯 经典款全保护背壳 手机保护壳 for iPhone 7-天空蓝','ps-20161027050827-Bdn',0,1,400.00,100.00,'',0,0,'',0,0,'','2017-02-24 01:49:06','2017-02-24 01:49:06'),
(9,7,1,'Libratone Zipp 无线音箱','ps-20161018103118-WtQ',0,2,1980.00,1200.00,'',0,0,'',0,0,'','2017-09-08 14:20:20','2017-09-08 14:20:20'),
(10,7,2,'第一代 iPod 发布','ps-20161027040227-IlD',0,1,100.00,54.00,'',0,0,'',0,0,'','2017-09-08 14:20:20','2017-09-08 14:20:20'),
(11,7,9,'告别宝丽来','ps-20161027132627-GK3',0,1,111.00,25.00,'紫色 老挝 ',0,0,'',0,0,'','2017-09-08 14:20:20','2017-09-08 14:20:20');

/*Table structure for table `ps_order_info` */

DROP TABLE IF EXISTS `ps_order_info`;

CREATE TABLE `ps_order_info` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(20) NOT NULL DEFAULT '' COMMENT '订单号',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `order_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态',
  `shipping_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '配送状态',
  `pay_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付状态',
  `consignee` varchar(60) NOT NULL DEFAULT '',
  `country` smallint(5) unsigned NOT NULL DEFAULT '0',
  `province` smallint(5) unsigned NOT NULL DEFAULT '0',
  `city` smallint(5) unsigned NOT NULL DEFAULT '0',
  `district` smallint(5) unsigned NOT NULL DEFAULT '0',
  `address` varchar(255) NOT NULL DEFAULT '',
  `zipcode` varchar(60) NOT NULL DEFAULT '',
  `tel` varchar(60) NOT NULL DEFAULT '',
  `phone` varchar(60) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `best_time` varchar(120) NOT NULL DEFAULT '',
  `sign_building` varchar(120) NOT NULL DEFAULT '',
  `postscript` varchar(255) NOT NULL DEFAULT '',
  `shipping_id` tinyint(3) NOT NULL DEFAULT '0',
  `shipping_name` varchar(120) NOT NULL DEFAULT '',
  `pay_id` tinyint(3) NOT NULL DEFAULT '0',
  `pay_name` varchar(120) NOT NULL DEFAULT '',
  `how_oos` varchar(120) NOT NULL DEFAULT '',
  `how_surplus` varchar(120) NOT NULL DEFAULT '',
  `pack_name` varchar(120) NOT NULL DEFAULT '',
  `card_name` varchar(120) NOT NULL DEFAULT '',
  `card_message` varchar(255) NOT NULL DEFAULT '',
  `inv_payee` varchar(120) NOT NULL DEFAULT '',
  `inv_content` varchar(120) NOT NULL DEFAULT '',
  `goods_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `insure_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pay_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pack_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `card_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `money_paid` decimal(10,2) NOT NULL DEFAULT '0.00',
  `surplus` decimal(10,2) NOT NULL DEFAULT '0.00',
  `integral` int(10) unsigned NOT NULL DEFAULT '0',
  `integral_money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `bonus` decimal(10,2) NOT NULL DEFAULT '0.00',
  `order_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `from_ad` smallint(5) NOT NULL DEFAULT '0',
  `referer` varchar(255) NOT NULL DEFAULT '',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `confirm_time` int(10) unsigned NOT NULL DEFAULT '0',
  `pay_time` int(10) unsigned NOT NULL DEFAULT '0',
  `shipping_time` int(10) unsigned NOT NULL DEFAULT '0',
  `pack_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `card_id` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '礼品卡编号',
  `bonus_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `invoice_no` varchar(255) NOT NULL DEFAULT '',
  `extension_code` varchar(30) NOT NULL DEFAULT '',
  `extension_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `to_buyer` varchar(255) NOT NULL DEFAULT '',
  `pay_note` varchar(255) NOT NULL DEFAULT '',
  `agency_id` smallint(5) unsigned NOT NULL,
  `inv_type` varchar(60) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `is_separate` tinyint(1) NOT NULL DEFAULT '0',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `discount` decimal(10,2) NOT NULL,
  `return_status` int(10) NOT NULL COMMENT '退货开关',
  `cancel_status` int(10) NOT NULL COMMENT '是否取消',
  `ip` varchar(255) NOT NULL,
  `order_note` varchar(255) NOT NULL COMMENT '订单说明',
  `order_from` varchar(255) NOT NULL COMMENT '订单来源',
  `order_type` int(10) NOT NULL DEFAULT '0' COMMENT '订单类型',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_sn` (`order_sn`),
  KEY `user_id` (`user_id`),
  KEY `order_status` (`order_status`),
  KEY `shipping_status` (`shipping_status`),
  KEY `pay_status` (`pay_status`),
  KEY `shipping_id` (`shipping_id`),
  KEY `pay_id` (`pay_id`),
  KEY `extension_code` (`extension_code`,`extension_id`),
  KEY `agency_id` (`agency_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `ps_order_info` */

insert  into `ps_order_info`(`id`,`order_sn`,`user_id`,`order_status`,`shipping_status`,`pay_status`,`consignee`,`country`,`province`,`city`,`district`,`address`,`zipcode`,`tel`,`phone`,`email`,`best_time`,`sign_building`,`postscript`,`shipping_id`,`shipping_name`,`pay_id`,`pay_name`,`how_oos`,`how_surplus`,`pack_name`,`card_name`,`card_message`,`inv_payee`,`inv_content`,`goods_amount`,`shipping_fee`,`insure_fee`,`pay_fee`,`pack_fee`,`card_fee`,`money_paid`,`surplus`,`integral`,`integral_money`,`bonus`,`order_amount`,`from_ad`,`referer`,`add_time`,`confirm_time`,`pay_time`,`shipping_time`,`pack_id`,`card_id`,`bonus_id`,`invoice_no`,`extension_code`,`extension_id`,`to_buyer`,`pay_note`,`agency_id`,`inv_type`,`tax`,`is_separate`,`parent_id`,`discount`,`return_status`,`cancel_status`,`ip`,`order_note`,`order_from`,`order_type`,`created_at`,`updated_at`) values 
(3,'2017022472577',1,0,0,1,'谢晓明',1,6,36,416,'广东佛山','','','17701228800','','','','',1,'顺丰速运',3,'余额支付','','','','','','','',46.00,20.00,0.00,0.00,0.00,0.00,0.00,0.00,0,0.00,0.00,86.00,0,'',1487898783,0,1487899771,0,0,0,0,'','',0,'','',0,'',0.00,0,0,0.00,0,0,'::1','','批量下单总订单',1,'2017-02-24 09:29:31','2017-02-24 01:29:31'),
(6,'2017022438448',1,0,0,1,'谢晓明',1,6,36,416,'广东佛山','','','17701228800','','','','',1,'顺丰速运',3,'余额支付','','','','','','','',333.00,20.00,0.00,0.00,0.00,0.00,0.00,0.00,0,0.00,0.00,385.00,0,'',1487900946,0,1487901070,0,0,0,0,'','',0,'','',0,'',0.00,0,0,0.00,0,0,'::1','','批量下单总订单',1,'2017-02-24 09:51:10','2017-02-24 01:51:10');

/*Table structure for table `ps_order_log` */

DROP TABLE IF EXISTS `ps_order_log`;

CREATE TABLE `ps_order_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `order_sn` varchar(255) NOT NULL COMMENT '订单号',
  `username` varchar(255) NOT NULL COMMENT '管理员名称',
  `log` varchar(255) NOT NULL COMMENT '管理员对订单操作的说明',
  `add_time` int(11) NOT NULL COMMENT '操作的时间',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `ps_order_log` */

insert  into `ps_order_log`(`id`,`order_sn`,`username`,`log`,`add_time`,`created_at`,`updated_at`) values 
(1,'2017022218812','admin','设置订单已发货：单号：2017022218812',1487772381,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2,'2017022218812','admin','确认了订单',1487772385,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3,'2017022218812','admin','批量设置订单所有状态为确认：单号：2017022218812',1487772390,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(4,'2017022234345','admin','添加发货单：快递公司名称:顺丰速运 单号：12344556',1487819640,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*Table structure for table `ps_order_return` */

DROP TABLE IF EXISTS `ps_order_return`;

CREATE TABLE `ps_order_return` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) NOT NULL COMMENT '订单编号',
  `user_id` int(10) NOT NULL COMMENT '用户编号',
  `username` varchar(255) NOT NULL COMMENT '退货会员',
  `type` varchar(255) NOT NULL COMMENT '退货类型',
  `return_note` varchar(255) NOT NULL COMMENT '退货说明',
  `bank_name` varchar(255) NOT NULL COMMENT '银行名称',
  `bank_account` varchar(255) NOT NULL COMMENT '银行账户',
  `return_amount` decimal(10,2) NOT NULL COMMENT '退货金额',
  `return_status` int(11) NOT NULL COMMENT '退货状态',
  `admin` varchar(255) NOT NULL COMMENT '审批管理员',
  `add_time` int(11) NOT NULL COMMENT '操作时间',
  `ip` varchar(255) NOT NULL COMMENT '退货申请的ip地址',
  `reg_from` varchar(255) NOT NULL COMMENT '退货申请来源',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ps_order_return` */

/*Table structure for table `ps_payment` */

DROP TABLE IF EXISTS `ps_payment`;

CREATE TABLE `ps_payment` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `pay_code` varchar(20) NOT NULL DEFAULT '',
  `pay_name` varchar(120) NOT NULL DEFAULT '',
  `pay_fee` varchar(10) NOT NULL DEFAULT '0',
  `pay_desc` text NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `tag` int(10) NOT NULL,
  `pid` varchar(255) NOT NULL,
  `account` varchar(255) NOT NULL COMMENT '收款账号',
  `pkey` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `pay_code` (`pay_code`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `ps_payment` */

insert  into `ps_payment`(`id`,`pay_code`,`pay_name`,`pay_fee`,`pay_desc`,`sort_order`,`tag`,`pid`,`account`,`pkey`,`created_at`,`updated_at`) values 
(1,'alipay','支付宝','0','阿里巴巴旗下的支付宝接口',0,1,'','','','2017-12-01 00:53:13','2017-11-30 16:53:13'),
(2,'weixin','微信支付','0','腾讯公司的微信支付接口',0,1,'','','','2016-01-29 06:13:10','2016-01-29 06:13:10'),
(3,'account','余额支付','0','使用用户账户余额来支付',0,1,'','','','2017-02-16 02:03:51','2017-02-16 02:03:51');

/*Table structure for table `ps_privi` */

DROP TABLE IF EXISTS `ps_privi`;

CREATE TABLE `ps_privi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `privi_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '权限名称',
  `privi_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '权限代码',
  `privi_route` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '权限路由',
  `parent_id` int(11) NOT NULL COMMENT '权限父亲结点',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `privi_privi_name_unique` (`privi_name`)
) ENGINE=InnoDB AUTO_INCREMENT=351 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `ps_privi` */

insert  into `ps_privi`(`id`,`privi_name`,`privi_code`,`privi_route`,`parent_id`,`created_at`,`updated_at`) values 
(1,'系统权限','privi','',0,'2015-07-12 17:16:27','2015-07-12 17:21:47'),
(2,'查看系统所有权限','admin.privi.index','admin/privi',1,'2015-07-12 17:17:39','2015-07-12 17:17:39'),
(3,'编辑权限','admin.privi.edit','',1,'2015-07-12 17:20:53','2015-07-12 17:20:53'),
(4,'添加系统权限','admin.privi.create','admin/privi/create',1,'2015-07-12 17:21:27','2015-07-12 17:21:27'),
(5,'删除系统权限','admin.privi.delete','',1,'2015-07-12 17:22:17','2015-07-12 17:22:17'),
(6,'存储权限','admin.privi.store','',1,'2015-07-12 17:23:53','2015-07-12 17:23:53'),
(7,'更新权限','admin.privi.update','',1,'2015-07-12 17:25:29','2015-07-12 17:25:29'),
(9,'角色管理','admin.role.index','admin/role',1,'2015-07-12 18:05:03','2015-07-12 18:05:03'),
(10,'添加角色','admin.role.create','admin/role/create',1,'2015-07-12 18:05:38','2015-07-12 18:05:38'),
(11,'编辑角色','admin.role.edit','',1,'2015-07-12 18:06:17','2015-07-12 18:06:17'),
(12,'存储角色','admin.role.store','',1,'2015-07-12 18:06:43','2015-07-12 18:06:43'),
(13,'更新角色','admin.role.update','',1,'2015-07-12 18:07:01','2015-07-12 18:07:01'),
(14,'角色删除','admin.role.delete','',1,'2015-07-12 18:07:39','2015-07-12 18:07:39'),
(15,'角色grid操作','admin.role.grid','admin/role/grid',1,'2015-07-12 18:11:49','2015-07-12 18:11:49'),
(16,'角色批量删除','admin.role.batch','',1,'2015-07-12 18:12:15','2016-01-30 14:29:10'),
(17,'查看管理员列表','admin.administrator.index','admin/administrator',1,'2015-07-12 18:19:17','2015-07-12 18:19:17'),
(18,'添加管理员','admin.administrator.create','',1,'2015-07-12 18:19:39','2015-07-12 18:19:39'),
(19,'管理员存储','admin.administrator.store','',1,'2015-07-12 18:19:58','2015-07-12 18:19:58'),
(20,'管理员编辑','admin.administrator.edit','',1,'2015-07-12 18:20:14','2015-07-12 18:20:14'),
(21,'管理员更新','admin.administrator.update','',1,'2015-07-12 18:20:40','2015-07-12 18:20:40'),
(22,'管理员删除','admin.administrator.delete','',1,'2015-07-12 18:21:02','2015-07-12 18:21:02'),
(23,'管理员grid操作','admin.administrator.grid','admin/administrator/grid',1,'2015-07-12 18:21:40','2015-07-12 18:21:40'),
(24,'管理员批量删除','admin.administrator.batch','admin/administrator/batch',1,'2015-07-12 18:22:06','2015-07-12 18:22:06'),
(25,'清除缓存','admin.cache.clear','admin/cache_clear',1,'2015-07-12 18:38:19','2015-07-12 18:38:19'),
(26,'退出登录','admin.administrator.logout','admin/administrator/logout',1,'2015-07-12 18:39:59','2015-07-12 18:42:23'),
(27,'控制面板','index','',0,'2015-07-12 18:55:51','2015-07-12 18:55:51'),
(28,'系统信息','admin.system.index','admin/index',27,'2015-07-12 18:56:41','2015-07-12 18:56:41'),
(29,'资讯管理','article','',0,'2015-07-12 20:11:44','2015-07-12 20:11:44'),
(30,'查看资讯','admin.article.index','admin/article',29,'2015-07-12 20:12:03','2015-07-12 20:12:03'),
(31,'添加资讯','admin.article.create','',29,'2015-07-12 20:12:33','2015-07-12 20:12:33'),
(32,'存储资讯','admin.article.store','',29,'2015-07-12 20:23:46','2015-07-12 20:23:46'),
(33,'编辑资讯','admin.article.edit','',29,'2015-07-12 20:24:11','2015-07-12 20:24:11'),
(34,'更新资讯','admin.article.update','',29,'2015-07-12 20:24:27','2015-07-12 20:24:27'),
(35,'资讯删除','admin.article.delete','',29,'2015-07-12 20:24:44','2015-07-12 20:24:44'),
(36,'资讯批量删除','admin.article.batch','admin/article/batch',29,'2015-07-12 20:25:16','2015-07-12 20:25:16'),
(37,'资讯grid操作','admin.article.grid','admin/article/grid',29,'2015-07-12 20:26:22','2015-07-12 20:26:22'),
(38,'资讯分类查看','admin.article_cat.index','',29,'2015-07-13 00:28:16','2015-07-13 00:28:16'),
(39,'资讯分类创建','admin.article_cat.create','',29,'2015-07-13 00:28:34','2015-07-13 00:28:34'),
(40,'资讯分类存储','admin.article_cat.store','',29,'2015-07-13 00:29:43','2015-07-13 00:29:43'),
(41,'资讯分类编辑','admin.article_cat.edit','',29,'2015-07-13 00:30:10','2015-07-13 00:30:10'),
(42,'资讯分类更新','admin.article_cat.update','',29,'2015-07-13 00:30:31','2015-07-13 00:30:31'),
(43,'资讯分类删除','admin.article_cat.delete','',29,'2015-07-13 00:31:02','2015-07-13 00:31:02'),
(44,'资讯分类批量删除','admin.article_cat.batch','',29,'2015-07-13 00:31:19','2015-07-13 00:31:19'),
(45,'资讯分类grid操作','admin.article_cat.grid','',29,'2015-07-13 00:32:51','2015-07-13 00:32:51'),
(46,'日志查看','admin.log.index','',1,'2015-07-14 17:05:59','2015-07-14 17:05:59'),
(47,'日志删除','admin.log.delete','',1,'2015-07-14 17:06:15','2015-07-14 17:06:15'),
(48,'日志ajax操作','admin.log.grid','admin/log/grid',1,'2015-07-14 17:06:34','2015-07-14 17:06:34'),
(49,'日志批量删除','admin.log.batch','',1,'2015-07-14 18:14:40','2015-07-14 18:14:40'),
(50,'会员管理','user','',0,'2015-07-14 18:25:59','2015-07-14 18:34:53'),
(51,'查看会员信息','admin.user.index','',50,'2015-07-14 18:30:01','2015-07-14 18:30:01'),
(52,'添加会员','admin.user.create','',50,'2015-07-14 18:30:19','2015-07-14 18:30:19'),
(53,'编辑会员','admin.user.edit','',50,'2015-07-14 18:30:38','2015-07-14 18:30:38'),
(54,'添加会员-插入数据库','admin.user.store','',50,'2015-07-14 18:31:08','2015-07-14 18:31:08'),
(55,'更新会员信息','admin.user.update','',50,'2015-07-14 18:31:25','2015-07-14 18:31:25'),
(56,'删除会员信息','admin.user.delete','',50,'2015-07-14 18:32:04','2015-07-14 18:32:04'),
(57,'批量删除会员信息','admin.user.batch','',50,'2015-07-14 18:32:24','2015-07-14 18:32:24'),
(58,'会员grid操作','admin.user.grid','',50,'2015-07-14 18:32:57','2015-07-14 18:32:57'),
(59,'用户等级查看','admin.user_rank.index','',50,'2015-07-15 22:05:40','2015-07-15 22:05:40'),
(60,'添加会员等级','admin.user_rank.create','',50,'2015-07-15 22:06:17','2015-07-15 22:06:17'),
(61,'会员等级存储','admin.user_rank.store','',50,'2015-07-15 22:06:43','2015-07-15 22:06:43'),
(62,'会员等级编辑','admin.user_rank.edit','',50,'2015-07-15 22:07:13','2015-07-15 22:07:13'),
(63,'会员等级更新','admin.user_rank.update','',50,'2015-07-15 22:07:30','2015-07-15 22:09:08'),
(64,'会员等级删除','admin.user_rank.delete','',50,'2015-07-15 22:07:52','2015-07-15 22:07:52'),
(65,'会员等级批量删除','admin.user_rank.batch','',50,'2015-07-15 22:08:12','2015-07-15 22:08:12'),
(66,'会员等级grid操作','admin.user_rank.grid','',50,'2015-07-15 22:08:38','2015-07-15 22:08:38'),
(67,'商品管理','goods','',0,'2015-07-19 14:48:56','2015-07-19 14:48:56'),
(68,'查看商品列表','admin.goods.index','',67,'2015-07-19 14:51:02','2015-07-19 14:51:02'),
(69,'添加商品','admin.goods.create','',67,'2015-07-19 14:51:20','2015-07-19 14:51:20'),
(70,'存储商品','admin.goods.store','',67,'2015-07-19 14:51:39','2015-07-19 14:51:39'),
(71,'编辑商品','admin.goods.edit','',67,'2015-07-19 14:51:57','2015-07-19 14:51:57'),
(72,'更新商品','admin.goods.update','',67,'2015-07-19 14:52:15','2015-07-19 14:52:15'),
(73,'商品批量上传','admin.goods.uploadify','admin/goods/uploadify',67,'2015-07-20 01:34:14','2015-07-20 01:34:14'),
(74,'商品分类','admin.category.index','',67,'2015-07-20 01:44:28','2015-07-20 01:44:28'),
(75,'商品品牌','admin.brand.index','',67,'2015-07-20 01:44:48','2015-07-20 01:45:39'),
(76,'商品批量删除','admin.goods.batch','',67,'2015-07-20 14:47:22','2015-07-20 14:47:22'),
(77,'商品grid','admin.goods.grid','',67,'2015-07-20 14:52:44','2015-07-20 14:52:44'),
(78,'商品删除','admin.goods.delete','',67,'2015-07-20 14:53:59','2015-07-20 14:53:59'),
(79,'添加分类','admin.category.create','',67,'2015-07-21 19:18:27','2015-07-21 19:18:27'),
(80,'存储分类','admin.category.store','',67,'2015-07-21 19:19:03','2015-07-21 19:19:03'),
(81,'编辑分类','admin.category.edit','',67,'2015-07-21 19:19:22','2015-07-21 19:19:22'),
(82,'更新分类','admin.category.update','',67,'2015-07-21 19:19:37','2015-07-21 19:19:37'),
(83,'分类排序','admin.category.grid','',67,'2015-07-21 19:19:58','2015-07-21 19:19:58'),
(84,'删除分类','admin.category.delete','',67,'2015-07-21 19:20:17','2015-07-21 19:20:17'),
(85,'商品分类批量删除','admin.category.batch','',67,'2015-07-21 19:20:32','2015-07-21 19:20:32'),
(86,'品牌添加','admin.brand.create','',67,'2015-07-21 19:55:16','2015-07-21 19:55:16'),
(87,'品牌存储','admin.brand.store','',67,'2015-07-21 19:55:31','2015-07-21 19:55:31'),
(88,'品牌编辑','admin.brand.edit','',67,'2015-07-21 19:56:04','2015-07-21 19:56:04'),
(89,'品牌更新','admin.brand.update','',67,'2015-07-21 19:56:16','2015-07-21 19:56:16'),
(90,'品牌删除','admin.brand.delete','',67,'2015-07-21 19:56:32','2015-07-21 19:56:32'),
(91,'品牌批量删除','admin.brand.batch','',67,'2015-07-21 19:56:45','2015-07-21 19:56:45'),
(92,'品牌grid操作','admin.brand.grid','',67,'2015-07-21 19:56:58','2015-07-21 19:56:58'),
(93,'商品类型查看','admin.type.index','',67,'2015-07-21 20:07:02','2015-07-21 20:07:02'),
(94,'商品类型添加','admin.type.create','',67,'2015-07-21 20:07:19','2015-07-21 20:07:19'),
(95,'商品类型存储','admin.type.store','',67,'2015-07-21 20:07:34','2015-07-21 20:07:34'),
(96,'商品类型编辑','admin.type.edit','',67,'2015-07-21 20:07:46','2015-07-21 20:07:46'),
(97,'商品类型更新','admin.type.update','',67,'2015-07-21 20:08:02','2015-07-21 20:08:02'),
(98,'商品类型删除','admin.type.delete','',67,'2015-07-21 20:08:18','2015-07-21 20:08:18'),
(99,'商品类型批量删除','admin.type.batch','',67,'2015-07-21 20:08:30','2015-07-21 20:08:30'),
(100,'商品类型grid','admin.type.grid','',67,'2015-07-21 20:08:45','2015-07-21 20:08:45'),
(101,'查看属性列表','admin.attribute.index','',67,'2015-07-21 22:04:26','2015-07-21 22:04:26'),
(102,'添加商品属性','admin.attribute.create','',67,'2015-07-21 22:04:41','2015-07-21 22:04:41'),
(103,'存储商品属性','admin.attribute.store','',67,'2015-07-21 22:04:57','2015-07-21 22:04:57'),
(104,'编辑商品属性','admin.attribute.edit','',67,'2015-07-21 22:05:19','2015-07-21 22:05:19'),
(105,'更新商品属性','admin.attribute.update','',67,'2015-07-21 22:05:35','2015-07-21 22:05:35'),
(106,'删除商品属性','admin.attribute.delete','',67,'2015-07-21 22:05:48','2015-07-21 22:05:48'),
(107,'批量删除商品属性','admin.attribute.batch','',67,'2015-07-21 22:06:08','2015-07-21 22:06:08'),
(108,'商品属性grid操作','admin.attribute.grid','',67,'2015-07-21 22:06:23','2015-07-21 22:06:23'),
(109,'商品ajax添加属性','admin.goods.attribute','',67,'2015-07-24 00:45:04','2015-07-24 00:45:04'),
(110,'商品规格查看','admin.field.index','',67,'2015-07-24 02:20:05','2015-07-24 02:20:05'),
(111,'商品规格添加','admin.field.create','',67,'2015-07-24 02:20:21','2015-07-24 02:20:21'),
(112,'商品规格存储','admin.field.store','',67,'2015-07-24 02:20:45','2015-07-24 02:20:45'),
(113,'商品规格编辑','admin.field.edit','',67,'2015-07-24 02:21:01','2015-07-24 02:21:01'),
(114,'商品规格更新','admin.field.update','',67,'2015-07-24 02:21:14','2015-07-24 02:21:14'),
(115,'商品规格删除','admin.field.delete','',67,'2015-07-24 02:21:30','2015-07-24 02:21:30'),
(116,'商品规格批量删除','admin.field.batch','',67,'2015-07-24 02:21:46','2015-07-24 02:21:46'),
(117,'商品规格ajax操作','admin.field.grid','',67,'2015-07-24 02:22:15','2015-07-24 02:22:15'),
(118,'动态添加商品字段','admin.goods.field','admin/field/ajax',67,'2015-07-24 02:43:26','2015-07-24 02:43:26'),
(119,'商品搜索','admin.goods.search','',67,'2015-07-26 18:41:43','2015-07-26 18:41:43'),
(120,'商品设置关联资讯','admin.goods.article','',67,'2015-07-26 19:48:01','2015-07-26 19:48:01'),
(121,'删除商品相册权限','admin.gallery.delete','admin/goods/gallery/delete',67,'2015-07-27 18:29:54','2015-07-27 18:29:54'),
(122,'一城一网','city','',0,'2015-08-26 00:05:39','2015-08-26 00:05:39'),
(125,'添加城市','admin.site.create','',122,'2015-08-26 00:21:40','2015-08-26 00:21:40'),
(126,'存储城市分站点','admin.site.store','',122,'2015-08-26 00:22:08','2015-08-26 00:22:08'),
(127,'编辑城市分站点','admin.site.edit','',122,'2015-08-26 00:22:23','2015-08-26 00:22:23'),
(128,'更新城市分站点','admin.site.update','',122,'2015-08-26 00:22:41','2015-08-26 00:22:41'),
(129,'删除城市分站点','admin.site.delete','',122,'2015-08-26 00:23:16','2015-08-26 00:23:16'),
(130,'分站批量删除','admin.site.batch','',122,'2015-08-26 00:39:39','2015-08-26 00:39:39'),
(131,'常用操作','common','',0,'2015-08-26 00:54:11','2015-08-26 00:54:11'),
(132,'自定义导航栏','admin.nav.index','',131,'2015-08-26 00:54:30','2015-08-26 00:54:30'),
(133,'整站图片管理','admin.image.index','',131,'2015-08-26 00:55:06','2015-08-26 00:55:06'),
(134,'友情链接管理','admin.link.index','',131,'2015-08-26 00:55:27','2015-08-26 00:55:27'),
(135,'导航栏grid','admin.nav.grid','',131,'2015-08-26 01:08:13','2015-08-26 01:08:13'),
(136,'添加导航栏','admin.nav.create','',131,'2015-08-26 01:08:27','2015-08-26 01:08:27'),
(137,'存储导航栏','admin.nav.store','',131,'2015-08-26 01:08:40','2015-08-26 01:08:40'),
(138,'编辑导航栏','admin.nav.edit','',131,'2015-08-26 01:08:52','2015-08-26 01:08:52'),
(139,'更新导航栏','admin.nav.update','',131,'2015-08-26 01:09:04','2015-08-26 01:09:04'),
(140,'删除导航栏','admin.nav.delete','',131,'2015-08-26 01:14:31','2015-08-26 01:14:31'),
(141,'批量删除导航栏','admin.nav.batch','',131,'2015-08-26 01:44:39','2015-08-26 01:44:39'),
(142,'图片添加','admin.image.create','',131,'2015-08-26 01:52:05','2015-08-26 01:52:05'),
(143,'图片存储','admin.image.store','',131,'2015-08-26 01:52:19','2015-08-26 01:52:19'),
(144,'图片编辑','admin.image.edit','',131,'2015-08-26 01:52:30','2015-08-26 01:52:30'),
(145,'图片更新','admin.image.update','',131,'2015-08-26 01:57:53','2015-08-26 01:57:53'),
(146,'图片grid','admin.image.grid','',131,'2015-08-26 01:58:06','2015-08-26 01:58:06'),
(147,'图片批量删除','admin.image.batch','',131,'2015-08-26 01:58:22','2015-08-26 01:58:40'),
(148,'图片删除','admin.image.delete','',131,'2015-08-26 02:01:01','2015-08-26 02:01:01'),
(149,'添加友情链接','admin.link.create','',131,'2015-08-26 02:43:18','2015-08-26 02:43:18'),
(150,'存储友情链接','admin.link.store','',131,'2015-08-26 02:43:30','2015-08-26 02:43:30'),
(151,'编辑友情链接','admin.link.edit','',131,'2015-08-26 02:43:52','2015-08-26 02:43:52'),
(152,'更新友情链接','admin.link.update','',131,'2015-08-26 02:44:08','2015-08-26 02:44:08'),
(153,'删除友情链接','admin.link.delete','',131,'2015-08-26 02:44:26','2015-08-26 02:44:26'),
(154,'批量删除友情链接','admin.link.batch','',131,'2015-08-26 02:44:40','2015-08-26 02:44:40'),
(155,'友情链接grid','admin.link.grid','',131,'2015-08-26 05:43:08','2015-08-26 05:43:08'),
(156,'系统配置','config','',0,'2015-09-09 05:38:07','2015-09-09 05:38:07'),
(157,'查看系统权限','admin.config.index','',156,'2015-09-09 05:38:27','2015-09-09 05:38:43'),
(158,'存储系统配置文件','admin.config.store','',156,'2015-09-09 05:39:20','2015-09-09 05:39:20'),
(159,'订单管理','order','',0,'2015-09-09 09:25:46','2015-09-09 09:25:46'),
(160,'订单列表','admin.order.index','',159,'2015-09-09 09:26:01','2015-09-09 09:26:01'),
(161,'添加订单','admin.order.create','',159,'2015-09-09 09:26:22','2015-09-09 09:26:22'),
(162,'订单存储','admin.order.store','',159,'2015-09-09 09:26:55','2015-09-09 09:26:55'),
(163,'订单编辑','admin.order.edit','',159,'2015-09-09 09:27:09','2015-09-09 09:27:09'),
(164,'订单更新','admin.order.update','',159,'2015-09-09 09:27:29','2015-09-09 09:27:29'),
(165,'订单删除','admin.order.delete','',159,'2015-09-09 09:28:57','2015-09-09 09:28:57'),
(166,'订单批量删除','admin.order.batch','',159,'2015-09-09 09:29:12','2015-09-09 09:29:12'),
(167,'订单ajax操作','admin.order.grid','',159,'2015-09-09 09:29:30','2015-09-09 09:29:30'),
(168,'幻灯片查看','admin.slider.index','',156,'2016-01-23 04:39:36','2016-01-23 04:39:36'),
(169,'幻灯添加','admin.slider.create','',156,'2016-01-23 04:47:21','2016-01-23 04:47:21'),
(170,'缓存存储','admin.slider.store','',156,'2016-01-23 04:47:38','2016-01-23 04:47:38'),
(171,'幻灯编辑','admin.slider.edit','',156,'2016-01-23 04:47:49','2016-01-23 04:47:49'),
(172,'幻灯更新','admin.slider.update','',156,'2016-01-23 04:48:06','2016-01-23 04:48:06'),
(173,'幻灯删除','admin.slider.delete','',156,'2016-01-23 04:48:20','2016-01-23 04:48:20'),
(174,'幻灯grid操作','admin.slider.grid','',156,'2016-01-23 04:58:07','2016-01-23 04:58:07'),
(175,'幻灯批量操作','admin.slider.batch','',156,'2016-01-23 04:58:27','2016-01-23 04:58:27'),
(176,'分类广告管理','admin.catad.index','',156,'2016-01-24 12:39:37','2016-01-24 12:39:37'),
(177,'分类广告创建','admin.catad.create','',156,'2016-01-24 12:40:11','2016-01-24 12:40:11'),
(178,'分类广告存储','admin.catad.store','',156,'2016-01-24 12:40:32','2016-01-24 12:40:32'),
(179,'分类广告编辑','admin.catad.edit','',156,'2016-01-24 12:42:42','2016-01-24 12:42:42'),
(180,'分类广告更新','admin.catad.update','',156,'2016-01-24 12:43:02','2016-01-24 12:43:02'),
(181,'分类广告删除','admin.catad.delete','',156,'2016-01-24 12:43:14','2016-01-24 12:43:14'),
(182,'分类广告grid操作','admin.catad.grid','',156,'2016-01-24 12:43:31','2016-01-24 12:43:31'),
(183,'分类广告批量操作','admin.catad.batch','',156,'2016-01-24 12:43:50','2016-01-24 12:43:50'),
(184,'查看支付方式','admin.payment.index','',156,'2016-01-28 13:23:35','2016-01-28 13:23:35'),
(185,'添加支付方式','admin.payment.create','',156,'2016-01-28 13:23:57','2016-01-28 13:23:57'),
(186,'存储支付方式','admin.payment.store','',156,'2016-01-28 13:24:12','2016-01-28 13:24:12'),
(187,'编辑支付方式','admin.payment.edit','',156,'2016-01-28 13:24:33','2016-01-28 13:24:33'),
(188,'更新支付方式','admin.payment.update','',156,'2016-01-28 13:24:56','2016-01-28 13:24:56'),
(189,'删除支付方式','admin.payment.delete','',156,'2016-01-28 13:25:18','2016-01-28 13:25:18'),
(190,'支付方式批量删除','admin.payment.batch','',156,'2016-01-28 13:25:38','2016-01-28 13:25:38'),
(191,'支付方式grid','admin.payment.grid','',156,'2016-01-28 13:25:53','2016-01-28 13:25:53'),
(192,'查看配送方式','admin.shipping.index','',156,'2016-01-28 14:37:23','2016-01-28 14:37:23'),
(193,'添加配送方式','admin.shipping.create','',156,'2016-01-28 14:37:39','2016-01-28 14:37:39'),
(194,'存储配送方式','admin.shipping.store','',156,'2016-01-28 14:38:04','2016-01-28 14:38:04'),
(195,'编辑配送方式','admin.shipping.edit','',156,'2016-01-28 14:38:19','2016-01-28 14:38:19'),
(196,'更新配送方式','admin.shipping.update','',156,'2016-01-28 14:38:36','2016-01-28 14:38:36'),
(197,'删除配送方式','admin.shipping.delete','',156,'2016-01-28 14:38:53','2016-01-28 14:38:53'),
(198,'批量删除配送方式','admin.shipping.batch','',156,'2016-01-28 14:39:11','2016-01-28 14:39:11'),
(199,'配送方式grid','admin.shipping.grid','',156,'2016-01-28 14:39:46','2016-01-28 14:39:46'),
(200,'地址三级ajax联查','admin.pcd.ajax','',1,'2016-01-30 18:23:39','2016-01-30 18:23:39'),
(201,'批量创建权限','admin.privi.batch','',1,'2016-02-17 15:25:47','2016-02-17 15:25:47'),
(202,'权限批量存储','admin.privi.batch.store','',1,'2016-02-17 15:26:29','2016-02-17 15:26:29'),
(203,'会员留言查看','admin.message.index','',50,'2016-02-17 15:42:44','2016-02-17 15:42:44'),
(204,'会员留言创建','admin.message.create','',50,'2016-02-17 15:42:44','2016-02-17 15:42:44'),
(205,'会员留言存储','admin.message.store','',50,'2016-02-17 15:42:44','2016-02-17 15:42:44'),
(206,'会员留言编辑','admin.message.edit','',50,'2016-02-17 15:42:44','2016-02-17 15:42:44'),
(207,'会员留言更新','admin.message.update','',50,'2016-02-17 15:42:44','2016-02-17 15:42:44'),
(208,'会员留言删除','admin.message.delete','',50,'2016-02-17 15:42:44','2016-02-17 15:42:44'),
(209,'会员留言批量','admin.message.batch','',50,'2016-02-17 15:42:44','2016-02-17 15:42:44'),
(210,'会员留言排序','admin.message.grid','',50,'2016-02-17 15:42:44','2016-02-17 15:42:44'),
(214,'颜色属性查看','admin.color.index','',67,'2016-03-01 14:09:58','2016-03-01 14:09:58'),
(215,'颜色属性创建','admin.color.create','',67,'2016-03-01 14:09:58','2016-03-01 14:09:58'),
(216,'颜色属性存储','admin.color.store','',67,'2016-03-01 14:09:58','2016-03-01 14:09:58'),
(217,'颜色属性编辑','admin.color.edit','',67,'2016-03-01 14:09:58','2016-03-01 14:09:58'),
(218,'颜色属性更新','admin.color.update','',67,'2016-03-01 14:09:58','2016-03-01 14:09:58'),
(219,'颜色属性删除','admin.color.delete','',67,'2016-03-01 14:09:58','2016-03-01 14:09:58'),
(220,'颜色属性批量','admin.color.batch','',67,'2016-03-01 14:09:58','2016-03-01 14:09:58'),
(221,'颜色属性排序','admin.color.grid','',67,'2016-03-01 14:09:58','2016-03-01 14:09:58'),
(222,'颜色属性图片删除','admin.color.img.delete','',67,'2016-03-03 17:00:11','2016-03-03 17:00:11'),
(223,'查看商品回收站','admin.cycle.index','',67,'2016-03-03 18:10:53','2016-03-03 18:10:53'),
(224,'商品回收站删除','admin.cycle.delete','',67,'2016-03-04 17:24:33','2016-03-04 17:24:33'),
(225,'商品回收站还原','admin.cycle.softdel','',67,'2016-03-04 17:30:16','2016-03-04 17:30:16'),
(226,'商品回收站批量操作','admin.cycle.batch','',67,'2016-03-04 17:52:47','2016-03-04 17:52:47'),
(227,'excel查看','admin.excel.index','',67,'2016-03-06 02:26:02','2016-03-06 02:26:02'),
(228,'excel导出','admin.excel.out','',67,'2016-03-06 02:26:22','2016-03-06 02:26:22'),
(229,'excel导入','admin.excel.in','',67,'2016-03-06 02:26:39','2016-03-06 02:26:39'),
(230,'导出所有商品到excel','admin.excel.all','',67,'2016-03-06 16:09:05','2016-03-06 16:09:05'),
(231,'商品excel批量导出','admin.excel.batch','',67,'2016-03-06 17:28:04','2016-03-06 17:28:04'),
(232,'excel导入查看','admin.excel.in.get','',67,'2016-03-06 17:40:34','2016-03-06 17:40:34'),
(233,'excel导入post操作','admin.excel.in.post','',67,'2016-03-06 17:40:56','2016-03-06 17:40:56'),
(234,'命令行批量添加商品','admin.command.index','',67,'2016-03-07 14:04:54','2016-03-07 14:04:54'),
(235,'商品图片批量处理查看','admin.goods.image','',67,'2016-03-07 14:33:10','2016-03-07 14:33:10'),
(236,'批量处理图片设置图片尺寸','admin.goods.config','',67,'2016-03-07 16:49:12','2016-03-07 16:49:12'),
(237,'批量生成新的商品图片尺寸','admin.goods.image.redo','',67,'2016-03-08 03:48:25','2016-03-08 03:48:25'),
(238,'后台订单确认取消操作','admin.order.action','',159,'2016-03-14 10:14:04','2016-03-14 10:14:04'),
(239,'订单发货操作','admin.order.express','',159,'2016-03-14 16:01:26','2016-03-14 16:01:26'),
(240,'查看订单日志','admin.order.log','',159,'2016-03-14 16:55:41','2016-03-14 16:55:41'),
(241,'订单日志删除','admin.order.log.delete','',159,'2016-03-14 17:22:48','2016-03-14 17:22:48'),
(242,'订单日志批量删除','admin.order.log.batch','',159,'2016-03-14 17:33:40','2016-03-14 17:33:40'),
(243,'快递发货单管理查看','admin.express.index','',159,'2016-03-15 14:26:45','2016-03-15 14:26:45'),
(244,'快递发货单管理创建','admin.express.create','',159,'2016-03-15 14:26:45','2016-03-15 14:26:45'),
(245,'快递发货单管理存储','admin.express.store','',159,'2016-03-15 14:26:45','2016-03-15 14:26:45'),
(246,'快递发货单管理编辑','admin.express.edit','',159,'2016-03-15 14:26:45','2016-03-15 14:26:45'),
(247,'快递发货单管理更新','admin.express.update','',159,'2016-03-15 14:26:45','2016-03-15 14:26:45'),
(248,'快递发货单管理删除','admin.express.delete','',159,'2016-03-15 14:26:45','2016-03-15 14:26:45'),
(249,'快递发货单管理批量','admin.express.batch','',159,'2016-03-15 14:26:45','2016-03-15 14:26:45'),
(250,'快递发货单管理排序','admin.express.grid','',159,'2016-03-15 14:26:45','2016-03-15 14:26:45'),
(251,'退货查看','admin.return.index','',159,'2016-03-16 17:37:31','2016-03-16 17:37:31'),
(252,'退货创建','admin.return.create','',159,'2016-03-16 17:37:31','2016-03-16 17:37:31'),
(253,'退货存储','admin.return.store','',159,'2016-03-16 17:37:31','2016-03-16 17:37:31'),
(254,'退货编辑','admin.return.edit','',159,'2016-03-16 17:37:31','2016-03-16 17:37:31'),
(255,'退货更新','admin.return.update','',159,'2016-03-16 17:37:31','2016-03-16 17:37:31'),
(256,'退货删除','admin.return.delete','',159,'2016-03-16 17:37:31','2016-03-16 17:37:31'),
(257,'退货批量','admin.return.batch','',159,'2016-03-16 17:37:31','2016-03-16 17:37:31'),
(258,'退货排序','admin.return.grid','',159,'2016-03-16 17:37:31','2016-03-16 17:37:31'),
(259,'订单打印','admin.order.print','',159,'2016-03-18 15:12:14','2016-03-18 15:12:14'),
(260,'订单打印post','admin.order.print.post','',159,'2016-03-18 15:32:35','2016-03-18 15:32:35'),
(270,'商品标签查看','admin.tag.index','',67,'2016-03-20 17:22:25','2016-03-20 17:22:25'),
(271,'商品标签创建','admin.tag.create','',67,'2016-03-20 17:22:25','2016-03-20 17:22:25'),
(272,'商品标签存储','admin.tag.store','',67,'2016-03-20 17:22:25','2016-03-20 17:22:25'),
(273,'商品标签编辑','admin.tag.edit','',67,'2016-03-20 17:22:25','2016-03-20 17:22:25'),
(274,'商品标签更新','admin.tag.update','',67,'2016-03-20 17:22:25','2016-03-20 17:22:25'),
(275,'商品标签删除','admin.tag.delete','',67,'2016-03-20 17:22:25','2016-03-20 17:22:25'),
(276,'商品标签批量','admin.tag.batch','',67,'2016-03-20 17:22:25','2016-03-20 17:22:25'),
(277,'商品标签排序','admin.tag.grid','',67,'2016-03-20 17:22:25','2016-03-20 17:22:25'),
(278,'用户账户查看','admin.account.index','',50,'2016-03-22 08:53:37','2016-03-22 08:53:37'),
(279,'用户账户创建','admin.account.create','',50,'2016-03-22 08:53:37','2016-03-22 08:53:37'),
(280,'用户账户存储','admin.account.store','',50,'2016-03-22 08:53:37','2016-03-22 08:53:37'),
(281,'用户账户编辑','admin.account.edit','',50,'2016-03-22 08:53:37','2016-03-22 08:53:37'),
(282,'用户账户更新','admin.account.update','',50,'2016-03-22 08:53:37','2016-03-22 08:53:37'),
(283,'用户账户删除','admin.account.delete','',50,'2016-03-22 08:53:37','2016-03-22 08:53:37'),
(284,'用户账户批量','admin.account.batch','',50,'2016-03-22 08:53:37','2016-03-22 08:53:37'),
(285,'用户账户排序','admin.account.grid','',50,'2016-03-22 08:53:37','2016-03-22 08:53:37'),
(286,'短消息查看','admin.sms.index','',50,'2016-03-24 05:17:30','2016-03-24 05:17:30'),
(287,'短消息创建','admin.sms.create','',50,'2016-03-24 05:17:30','2016-03-24 05:17:30'),
(288,'短消息存储','admin.sms.store','',50,'2016-03-24 05:17:30','2016-03-24 05:17:30'),
(289,'短消息编辑','admin.sms.edit','',50,'2016-03-24 05:17:30','2016-03-24 05:17:30'),
(290,'短消息更新','admin.sms.update','',50,'2016-03-24 05:17:30','2016-03-24 05:17:30'),
(291,'短消息删除','admin.sms.delete','',50,'2016-03-24 05:17:30','2016-03-24 05:17:30'),
(292,'短消息批量','admin.sms.batch','',50,'2016-03-24 05:17:30','2016-03-24 05:17:30'),
(293,'短消息排序','admin.sms.grid','',50,'2016-03-24 05:17:30','2016-03-24 05:17:30'),
(303,'商品属性链查看','admin.product.index','',67,'2016-04-21 08:42:06','2016-04-21 08:42:06'),
(304,'商品属性链创建','admin.product.create','',67,'2016-04-21 08:42:06','2016-04-21 08:42:06'),
(305,'商品属性链存储','admin.product.store','',67,'2016-04-21 08:42:06','2016-04-21 08:42:06'),
(306,'商品属性链编辑','admin.product.edit','',67,'2016-04-21 08:42:06','2016-04-21 08:42:06'),
(307,'商品属性链更新','admin.product.update','',67,'2016-04-21 08:42:06','2016-04-21 08:42:06'),
(308,'商品属性链删除','admin.product.delete','',67,'2016-04-21 08:42:06','2016-04-21 08:42:06'),
(309,'商品属性链批量','admin.product.batch','',67,'2016-04-21 08:42:06','2016-04-21 08:42:06'),
(310,'商品属性链排序','admin.product.grid','',67,'2016-04-21 08:42:06','2016-04-21 08:42:06'),
(319,'风格管理查看','admin.style.index','',211,'2016-04-23 18:05:09','2016-04-23 18:05:09'),
(320,'风格管理创建','admin.style.create','',211,'2016-04-23 18:05:09','2016-04-23 18:05:09'),
(321,'风格管理存储','admin.style.store','',211,'2016-04-23 18:05:09','2016-04-23 18:05:09'),
(322,'风格管理编辑','admin.style.edit','',211,'2016-04-23 18:05:09','2016-04-23 18:05:09'),
(323,'风格管理更新','admin.style.update','',211,'2016-04-23 18:05:09','2016-04-23 18:05:09'),
(324,'风格管理删除','admin.style.delete','',211,'2016-04-23 18:05:09','2016-04-23 18:05:09'),
(325,'风格管理批量','admin.style.batch','',211,'2016-04-23 18:05:09','2016-04-23 18:05:09'),
(326,'风格管理排序','admin.style.grid','',211,'2016-04-23 18:05:09','2016-04-23 18:05:09'),
(327,'属性链货品ajax操作','admin.product.ajax','',67,'2016-04-23 18:10:23','2016-04-23 18:10:23'),
(328,'移动版本设置','mobile','',0,'2016-04-28 05:49:35','2016-04-28 05:49:35'),
(337,'地区配送运费查看','admin.region_shipping.index','',211,'2016-09-30 14:41:01','2016-09-30 14:41:01'),
(338,'地区配送运费创建','admin.region_shipping.create','',211,'2016-09-30 14:41:01','2016-09-30 14:41:01'),
(339,'地区配送运费存储','admin.region_shipping.store','',211,'2016-09-30 14:41:01','2016-09-30 14:41:01'),
(340,'地区配送运费编辑','admin.region_shipping.edit','',211,'2016-09-30 14:41:01','2016-09-30 14:41:01'),
(341,'地区配送运费更新','admin.region_shipping.update','',211,'2016-09-30 14:41:01','2016-09-30 14:41:01'),
(342,'地区配送运费删除','admin.region_shipping.delete','',211,'2016-09-30 14:41:01','2016-09-30 14:41:01'),
(343,'地区配送运费批量','admin.region_shipping.batch','',211,'2016-09-30 14:41:01','2016-09-30 14:41:01'),
(344,'地区配送运费排序','admin.region_shipping.grid','',211,'2016-09-30 14:41:01','2016-09-30 14:41:01'),
(345,'删除商品的关联商品','admin.goods.relation.delete','',67,'2016-10-31 08:13:42','2016-10-31 08:13:42'),
(346,'获取系统所有主题','admin.theme.json','',211,'2016-11-08 08:09:15','2016-11-08 08:09:15'),
(347,'添加主题','admin.theme.add','',211,'2016-11-08 08:42:19','2016-11-08 08:42:19'),
(348,'删除主题','admin.theme.delete','',211,'2016-11-08 10:11:42','2016-11-08 10:11:42'),
(350,'ajax删除商品属性','admin.goods.attr.delete','',67,'2016-11-09 14:39:14','2016-11-09 14:39:14');

/*Table structure for table `ps_product` */

DROP TABLE IF EXISTS `ps_product`;

CREATE TABLE `ps_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL COMMENT '商品编号',
  `goods_attr` varchar(255) NOT NULL COMMENT '商品的属性链编号',
  `product_sn` varchar(255) NOT NULL COMMENT '货品编号',
  `product_number` int(11) NOT NULL COMMENT '货品库存',
  `sort_order` int(11) NOT NULL COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ps_product` */

/*Table structure for table `ps_region` */

DROP TABLE IF EXISTS `ps_region`;

CREATE TABLE `ps_region` (
  `region_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `region_name` varchar(120) NOT NULL DEFAULT '',
  `region_type` tinyint(1) NOT NULL DEFAULT '2',
  `agency_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`region_id`),
  KEY `parent_id` (`parent_id`),
  KEY `region_type` (`region_type`),
  KEY `agency_id` (`agency_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3409 DEFAULT CHARSET=utf8;

/*Data for the table `ps_region` */

insert  into `ps_region`(`region_id`,`parent_id`,`region_name`,`region_type`,`agency_id`,`created_at`,`updated_at`) values 
(1,0,'中国',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2,1,'北京',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3,1,'安徽',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(4,1,'福建',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(5,1,'甘肃',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(6,1,'广东',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(7,1,'广西',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(8,1,'贵州',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(9,1,'海南',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(10,1,'河北',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(11,1,'河南',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(12,1,'黑龙江',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(13,1,'湖北',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(14,1,'湖南',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(15,1,'吉林',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(16,1,'江苏',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(17,1,'江西',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(18,1,'辽宁',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(19,1,'内蒙古',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(20,1,'宁夏',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(21,1,'青海',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(22,1,'山东',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(23,1,'山西',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(24,1,'陕西',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(25,1,'上海',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(26,1,'四川',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(27,1,'天津',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(28,1,'西藏',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(29,1,'新疆',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(30,1,'云南',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(31,1,'浙江',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(32,1,'重庆',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(33,1,'香港',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(34,1,'澳门',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(35,1,'台湾',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(36,3,'安庆',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(37,3,'蚌埠',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(38,3,'巢湖',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(39,3,'池州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(40,3,'滁州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(41,3,'阜阳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(42,3,'淮北',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(43,3,'淮南',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(44,3,'黄山',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(45,3,'六安',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(46,3,'马鞍山',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(47,3,'宿州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(48,3,'铜陵',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(49,3,'芜湖',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(50,3,'宣城',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(51,3,'亳州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(52,2,'北京',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(53,4,'福州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(54,4,'龙岩',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(55,4,'南平',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(56,4,'宁德',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(57,4,'莆田',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(58,4,'泉州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(59,4,'三明',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(60,4,'厦门',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(61,4,'漳州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(62,5,'兰州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(63,5,'白银',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(64,5,'定西',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(65,5,'甘南',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(66,5,'嘉峪关',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(67,5,'金昌',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(68,5,'酒泉',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(69,5,'临夏',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(70,5,'陇南',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(71,5,'平凉',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(72,5,'庆阳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(73,5,'天水',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(74,5,'武威',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(75,5,'张掖',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(76,6,'广州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(77,6,'深圳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(78,6,'潮州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(79,6,'东莞',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(80,6,'佛山',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(81,6,'河源',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(82,6,'惠州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(83,6,'江门',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(84,6,'揭阳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(85,6,'茂名',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(86,6,'梅州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(87,6,'清远',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(88,6,'汕头',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(89,6,'汕尾',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(90,6,'韶关',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(91,6,'阳江',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(92,6,'云浮',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(93,6,'湛江',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(94,6,'肇庆',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(95,6,'中山',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(96,6,'珠海',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(97,7,'南宁',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(98,7,'桂林',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(99,7,'百色',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(100,7,'北海',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(101,7,'崇左',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(102,7,'防城港',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(103,7,'贵港',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(104,7,'河池',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(105,7,'贺州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(106,7,'来宾',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(107,7,'柳州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(108,7,'钦州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(109,7,'梧州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(110,7,'玉林',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(111,8,'贵阳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(112,8,'安顺',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(113,8,'毕节',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(114,8,'六盘水',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(115,8,'黔东南',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(116,8,'黔南',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(117,8,'黔西南',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(118,8,'铜仁',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(119,8,'遵义',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(120,9,'海口',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(121,9,'三亚',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(122,9,'白沙',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(123,9,'保亭',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(124,9,'昌江',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(125,9,'澄迈县',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(126,9,'定安县',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(127,9,'东方',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(128,9,'乐东',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(129,9,'临高县',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(130,9,'陵水',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(131,9,'琼海',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(132,9,'琼中',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(133,9,'屯昌县',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(134,9,'万宁',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(135,9,'文昌',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(136,9,'五指山',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(137,9,'儋州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(138,10,'石家庄',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(139,10,'保定',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(140,10,'沧州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(141,10,'承德',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(142,10,'邯郸',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(143,10,'衡水',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(144,10,'廊坊',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(145,10,'秦皇岛',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(146,10,'唐山',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(147,10,'邢台',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(148,10,'张家口',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(149,11,'郑州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(150,11,'洛阳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(151,11,'开封',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(152,11,'安阳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(153,11,'鹤壁',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(154,11,'济源',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(155,11,'焦作',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(156,11,'南阳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(157,11,'平顶山',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(158,11,'三门峡',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(159,11,'商丘',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(160,11,'新乡',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(161,11,'信阳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(162,11,'许昌',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(163,11,'周口',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(164,11,'驻马店',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(165,11,'漯河',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(166,11,'濮阳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(167,12,'哈尔滨',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(168,12,'大庆',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(169,12,'大兴安岭',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(170,12,'鹤岗',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(171,12,'黑河',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(172,12,'鸡西',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(173,12,'佳木斯',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(174,12,'牡丹江',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(175,12,'七台河',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(176,12,'齐齐哈尔',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(177,12,'双鸭山',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(178,12,'绥化',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(179,12,'伊春',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(180,13,'武汉',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(181,13,'仙桃',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(182,13,'鄂州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(183,13,'黄冈',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(184,13,'黄石',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(185,13,'荆门',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(186,13,'荆州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(187,13,'潜江',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(188,13,'神农架林区',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(189,13,'十堰',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(190,13,'随州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(191,13,'天门',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(192,13,'咸宁',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(193,13,'襄樊',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(194,13,'孝感',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(195,13,'宜昌',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(196,13,'恩施',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(197,14,'长沙',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(198,14,'张家界',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(199,14,'常德',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(200,14,'郴州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(201,14,'衡阳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(202,14,'怀化',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(203,14,'娄底',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(204,14,'邵阳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(205,14,'湘潭',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(206,14,'湘西',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(207,14,'益阳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(208,14,'永州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(209,14,'岳阳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(210,14,'株洲',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(211,15,'长春',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(212,15,'吉林',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(213,15,'白城',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(214,15,'白山',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(215,15,'辽源',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(216,15,'四平',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(217,15,'松原',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(218,15,'通化',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(219,15,'延边',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(220,16,'南京',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(221,16,'苏州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(222,16,'无锡',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(223,16,'常州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(224,16,'淮安',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(225,16,'连云港',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(226,16,'南通',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(227,16,'宿迁',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(228,16,'泰州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(229,16,'徐州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(230,16,'盐城',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(231,16,'扬州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(232,16,'镇江',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(233,17,'南昌',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(234,17,'抚州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(235,17,'赣州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(236,17,'吉安',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(237,17,'景德镇',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(238,17,'九江',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(239,17,'萍乡',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(240,17,'上饶',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(241,17,'新余',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(242,17,'宜春',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(243,17,'鹰潭',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(244,18,'沈阳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(245,18,'大连',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(246,18,'鞍山',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(247,18,'本溪',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(248,18,'朝阳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(249,18,'丹东',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(250,18,'抚顺',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(251,18,'阜新',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(252,18,'葫芦岛',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(253,18,'锦州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(254,18,'辽阳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(255,18,'盘锦',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(256,18,'铁岭',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(257,18,'营口',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(258,19,'呼和浩特',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(259,19,'阿拉善盟',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(260,19,'巴彦淖尔盟',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(261,19,'包头',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(262,19,'赤峰',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(263,19,'鄂尔多斯',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(264,19,'呼伦贝尔',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(265,19,'通辽',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(266,19,'乌海',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(267,19,'乌兰察布市',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(268,19,'锡林郭勒盟',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(269,19,'兴安盟',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(270,20,'银川',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(271,20,'固原',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(272,20,'石嘴山',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(273,20,'吴忠',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(274,20,'中卫',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(275,21,'西宁',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(276,21,'果洛',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(277,21,'海北',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(278,21,'海东',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(279,21,'海南',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(280,21,'海西',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(281,21,'黄南',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(282,21,'玉树',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(283,22,'济南',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(284,22,'青岛',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(285,22,'滨州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(286,22,'德州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(287,22,'东营',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(288,22,'菏泽',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(289,22,'济宁',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(290,22,'莱芜',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(291,22,'聊城',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(292,22,'临沂',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(293,22,'日照',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(294,22,'泰安',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(295,22,'威海',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(296,22,'潍坊',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(297,22,'烟台',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(298,22,'枣庄',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(299,22,'淄博',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(300,23,'太原',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(301,23,'长治',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(302,23,'大同',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(303,23,'晋城',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(304,23,'晋中',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(305,23,'临汾',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(306,23,'吕梁',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(307,23,'朔州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(308,23,'忻州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(309,23,'阳泉',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(310,23,'运城',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(311,24,'西安',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(312,24,'安康',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(313,24,'宝鸡',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(314,24,'汉中',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(315,24,'商洛',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(316,24,'铜川',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(317,24,'渭南',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(318,24,'咸阳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(319,24,'延安',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(320,24,'榆林',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(321,25,'上海',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(322,26,'成都',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(323,26,'绵阳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(324,26,'阿坝',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(325,26,'巴中',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(326,26,'达州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(327,26,'德阳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(328,26,'甘孜',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(329,26,'广安',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(330,26,'广元',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(331,26,'乐山',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(332,26,'凉山',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(333,26,'眉山',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(334,26,'南充',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(335,26,'内江',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(336,26,'攀枝花',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(337,26,'遂宁',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(338,26,'雅安',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(339,26,'宜宾',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(340,26,'资阳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(341,26,'自贡',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(342,26,'泸州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(343,27,'天津',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(344,28,'拉萨',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(345,28,'阿里',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(346,28,'昌都',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(347,28,'林芝',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(348,28,'那曲',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(349,28,'日喀则',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(350,28,'山南',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(351,29,'乌鲁木齐',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(352,29,'阿克苏',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(353,29,'阿拉尔',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(354,29,'巴音郭楞',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(355,29,'博尔塔拉',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(356,29,'昌吉',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(357,29,'哈密',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(358,29,'和田',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(359,29,'喀什',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(360,29,'克拉玛依',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(361,29,'克孜勒苏',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(362,29,'石河子',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(363,29,'图木舒克',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(364,29,'吐鲁番',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(365,29,'五家渠',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(366,29,'伊犁',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(367,30,'昆明',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(368,30,'怒江',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(369,30,'普洱',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(370,30,'丽江',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(371,30,'保山',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(372,30,'楚雄',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(373,30,'大理',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(374,30,'德宏',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(375,30,'迪庆',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(376,30,'红河',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(377,30,'临沧',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(378,30,'曲靖',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(379,30,'文山',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(380,30,'西双版纳',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(381,30,'玉溪',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(382,30,'昭通',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(383,31,'杭州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(384,31,'湖州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(385,31,'嘉兴',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(386,31,'金华',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(387,31,'丽水',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(388,31,'宁波',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(389,31,'绍兴',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(390,31,'台州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(391,31,'温州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(392,31,'舟山',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(393,31,'衢州',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(394,32,'重庆',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(395,33,'香港',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(396,34,'澳门',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(397,35,'台湾',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(398,36,'迎江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(399,36,'大观区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(400,36,'宜秀区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(401,36,'桐城市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(402,36,'怀宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(403,36,'枞阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(404,36,'潜山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(405,36,'太湖县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(406,36,'宿松县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(407,36,'望江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(408,36,'岳西县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(409,37,'中市区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(410,37,'东市区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(411,37,'西市区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(412,37,'郊区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(413,37,'怀远县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(414,37,'五河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(415,37,'固镇县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(416,38,'居巢区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(417,38,'庐江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(418,38,'无为县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(419,38,'含山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(420,38,'和县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(421,39,'贵池区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(422,39,'东至县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(423,39,'石台县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(424,39,'青阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(425,40,'琅琊区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(426,40,'南谯区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(427,40,'天长市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(428,40,'明光市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(429,40,'来安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(430,40,'全椒县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(431,40,'定远县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(432,40,'凤阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(433,41,'蚌山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(434,41,'龙子湖区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(435,41,'禹会区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(436,41,'淮上区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(437,41,'颍州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(438,41,'颍东区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(439,41,'颍泉区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(440,41,'界首市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(441,41,'临泉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(442,41,'太和县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(443,41,'阜南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(444,41,'颖上县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(445,42,'相山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(446,42,'杜集区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(447,42,'烈山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(448,42,'濉溪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(449,43,'田家庵区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(450,43,'大通区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(451,43,'谢家集区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(452,43,'八公山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(453,43,'潘集区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(454,43,'凤台县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(455,44,'屯溪区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(456,44,'黄山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(457,44,'徽州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(458,44,'歙县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(459,44,'休宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(460,44,'黟县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(461,44,'祁门县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(462,45,'金安区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(463,45,'裕安区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(464,45,'寿县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(465,45,'霍邱县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(466,45,'舒城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(467,45,'金寨县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(468,45,'霍山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(469,46,'雨山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(470,46,'花山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(471,46,'金家庄区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(472,46,'当涂县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(473,47,'埇桥区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(474,47,'砀山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(475,47,'萧县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(476,47,'灵璧县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(477,47,'泗县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(478,48,'铜官山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(479,48,'狮子山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(480,48,'郊区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(481,48,'铜陵县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(482,49,'镜湖区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(483,49,'弋江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(484,49,'鸠江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(485,49,'三山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(486,49,'芜湖县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(487,49,'繁昌县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(488,49,'南陵县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(489,50,'宣州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(490,50,'宁国市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(491,50,'郎溪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(492,50,'广德县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(493,50,'泾县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(494,50,'绩溪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(495,50,'旌德县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(496,51,'涡阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(497,51,'蒙城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(498,51,'利辛县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(499,51,'谯城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(500,52,'东城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(501,52,'西城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(502,52,'海淀区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(503,52,'朝阳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(504,52,'崇文区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(505,52,'宣武区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(506,52,'丰台区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(507,52,'石景山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(508,52,'房山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(509,52,'门头沟区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(510,52,'通州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(511,52,'顺义区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(512,52,'昌平区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(513,52,'怀柔区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(514,52,'平谷区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(515,52,'大兴区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(516,52,'密云县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(517,52,'延庆县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(518,53,'鼓楼区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(519,53,'台江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(520,53,'仓山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(521,53,'马尾区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(522,53,'晋安区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(523,53,'福清市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(524,53,'长乐市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(525,53,'闽侯县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(526,53,'连江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(527,53,'罗源县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(528,53,'闽清县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(529,53,'永泰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(530,53,'平潭县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(531,54,'新罗区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(532,54,'漳平市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(533,54,'长汀县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(534,54,'永定县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(535,54,'上杭县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(536,54,'武平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(537,54,'连城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(538,55,'延平区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(539,55,'邵武市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(540,55,'武夷山市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(541,55,'建瓯市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(542,55,'建阳市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(543,55,'顺昌县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(544,55,'浦城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(545,55,'光泽县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(546,55,'松溪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(547,55,'政和县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(548,56,'蕉城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(549,56,'福安市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(550,56,'福鼎市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(551,56,'霞浦县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(552,56,'古田县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(553,56,'屏南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(554,56,'寿宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(555,56,'周宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(556,56,'柘荣县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(557,57,'城厢区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(558,57,'涵江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(559,57,'荔城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(560,57,'秀屿区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(561,57,'仙游县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(562,58,'鲤城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(563,58,'丰泽区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(564,58,'洛江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(565,58,'清濛开发区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(566,58,'泉港区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(567,58,'石狮市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(568,58,'晋江市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(569,58,'南安市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(570,58,'惠安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(571,58,'安溪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(572,58,'永春县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(573,58,'德化县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(574,58,'金门县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(575,59,'梅列区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(576,59,'三元区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(577,59,'永安市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(578,59,'明溪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(579,59,'清流县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(580,59,'宁化县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(581,59,'大田县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(582,59,'尤溪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(583,59,'沙县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(584,59,'将乐县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(585,59,'泰宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(586,59,'建宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(587,60,'思明区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(588,60,'海沧区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(589,60,'湖里区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(590,60,'集美区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(591,60,'同安区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(592,60,'翔安区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(593,61,'芗城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(594,61,'龙文区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(595,61,'龙海市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(596,61,'云霄县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(597,61,'漳浦县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(598,61,'诏安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(599,61,'长泰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(600,61,'东山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(601,61,'南靖县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(602,61,'平和县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(603,61,'华安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(604,62,'皋兰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(605,62,'城关区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(606,62,'七里河区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(607,62,'西固区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(608,62,'安宁区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(609,62,'红古区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(610,62,'永登县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(611,62,'榆中县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(612,63,'白银区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(613,63,'平川区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(614,63,'会宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(615,63,'景泰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(616,63,'靖远县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(617,64,'临洮县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(618,64,'陇西县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(619,64,'通渭县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(620,64,'渭源县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(621,64,'漳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(622,64,'岷县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(623,64,'安定区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(624,64,'安定区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(625,65,'合作市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(626,65,'临潭县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(627,65,'卓尼县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(628,65,'舟曲县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(629,65,'迭部县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(630,65,'玛曲县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(631,65,'碌曲县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(632,65,'夏河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(633,66,'嘉峪关市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(634,67,'金川区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(635,67,'永昌县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(636,68,'肃州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(637,68,'玉门市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(638,68,'敦煌市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(639,68,'金塔县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(640,68,'瓜州县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(641,68,'肃北',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(642,68,'阿克塞',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(643,69,'临夏市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(644,69,'临夏县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(645,69,'康乐县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(646,69,'永靖县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(647,69,'广河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(648,69,'和政县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(649,69,'东乡族自治县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(650,69,'积石山',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(651,70,'成县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(652,70,'徽县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(653,70,'康县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(654,70,'礼县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(655,70,'两当县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(656,70,'文县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(657,70,'西和县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(658,70,'宕昌县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(659,70,'武都区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(660,71,'崇信县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(661,71,'华亭县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(662,71,'静宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(663,71,'灵台县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(664,71,'崆峒区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(665,71,'庄浪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(666,71,'泾川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(667,72,'合水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(668,72,'华池县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(669,72,'环县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(670,72,'宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(671,72,'庆城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(672,72,'西峰区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(673,72,'镇原县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(674,72,'正宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(675,73,'甘谷县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(676,73,'秦安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(677,73,'清水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(678,73,'秦州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(679,73,'麦积区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(680,73,'武山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(681,73,'张家川',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(682,74,'古浪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(683,74,'民勤县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(684,74,'天祝',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(685,74,'凉州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(686,75,'高台县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(687,75,'临泽县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(688,75,'民乐县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(689,75,'山丹县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(690,75,'肃南',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(691,75,'甘州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(692,76,'从化市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(693,76,'天河区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(694,76,'东山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(695,76,'白云区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(696,76,'海珠区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(697,76,'荔湾区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(698,76,'越秀区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(699,76,'黄埔区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(700,76,'番禺区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(701,76,'花都区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(702,76,'增城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(703,76,'从化区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(704,76,'市郊',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(705,77,'福田区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(706,77,'罗湖区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(707,77,'南山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(708,77,'宝安区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(709,77,'龙岗区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(710,77,'盐田区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(711,78,'湘桥区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(712,78,'潮安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(713,78,'饶平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(714,79,'南城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(715,79,'东城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(716,79,'万江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(717,79,'莞城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(718,79,'石龙镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(719,79,'虎门镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(720,79,'麻涌镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(721,79,'道滘镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(722,79,'石碣镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(723,79,'沙田镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(724,79,'望牛墩镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(725,79,'洪梅镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(726,79,'茶山镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(727,79,'寮步镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(728,79,'大岭山镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(729,79,'大朗镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(730,79,'黄江镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(731,79,'樟木头',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(732,79,'凤岗镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(733,79,'塘厦镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(734,79,'谢岗镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(735,79,'厚街镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(736,79,'清溪镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(737,79,'常平镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(738,79,'桥头镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(739,79,'横沥镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(740,79,'东坑镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(741,79,'企石镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(742,79,'石排镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(743,79,'长安镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(744,79,'中堂镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(745,79,'高埗镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(746,80,'禅城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(747,80,'南海区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(748,80,'顺德区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(749,80,'三水区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(750,80,'高明区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(751,81,'东源县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(752,81,'和平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(753,81,'源城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(754,81,'连平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(755,81,'龙川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(756,81,'紫金县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(757,82,'惠阳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(758,82,'惠城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(759,82,'大亚湾',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(760,82,'博罗县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(761,82,'惠东县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(762,82,'龙门县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(763,83,'江海区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(764,83,'蓬江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(765,83,'新会区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(766,83,'台山市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(767,83,'开平市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(768,83,'鹤山市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(769,83,'恩平市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(770,84,'榕城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(771,84,'普宁市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(772,84,'揭东县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(773,84,'揭西县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(774,84,'惠来县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(775,85,'茂南区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(776,85,'茂港区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(777,85,'高州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(778,85,'化州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(779,85,'信宜市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(780,85,'电白县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(781,86,'梅县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(782,86,'梅江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(783,86,'兴宁市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(784,86,'大埔县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(785,86,'丰顺县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(786,86,'五华县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(787,86,'平远县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(788,86,'蕉岭县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(789,87,'清城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(790,87,'英德市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(791,87,'连州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(792,87,'佛冈县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(793,87,'阳山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(794,87,'清新县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(795,87,'连山',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(796,87,'连南',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(797,88,'南澳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(798,88,'潮阳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(799,88,'澄海区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(800,88,'龙湖区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(801,88,'金平区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(802,88,'濠江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(803,88,'潮南区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(804,89,'城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(805,89,'陆丰市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(806,89,'海丰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(807,89,'陆河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(808,90,'曲江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(809,90,'浈江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(810,90,'武江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(811,90,'曲江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(812,90,'乐昌市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(813,90,'南雄市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(814,90,'始兴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(815,90,'仁化县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(816,90,'翁源县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(817,90,'新丰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(818,90,'乳源',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(819,91,'江城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(820,91,'阳春市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(821,91,'阳西县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(822,91,'阳东县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(823,92,'云城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(824,92,'罗定市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(825,92,'新兴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(826,92,'郁南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(827,92,'云安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(828,93,'赤坎区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(829,93,'霞山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(830,93,'坡头区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(831,93,'麻章区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(832,93,'廉江市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(833,93,'雷州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(834,93,'吴川市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(835,93,'遂溪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(836,93,'徐闻县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(837,94,'肇庆市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(838,94,'高要市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(839,94,'四会市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(840,94,'广宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(841,94,'怀集县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(842,94,'封开县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(843,94,'德庆县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(844,95,'石岐街道',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(845,95,'东区街道',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(846,95,'西区街道',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(847,95,'环城街道',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(848,95,'中山港街道',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(849,95,'五桂山街道',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(850,96,'香洲区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(851,96,'斗门区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(852,96,'金湾区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(853,97,'邕宁区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(854,97,'青秀区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(855,97,'兴宁区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(856,97,'良庆区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(857,97,'西乡塘区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(858,97,'江南区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(859,97,'武鸣县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(860,97,'隆安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(861,97,'马山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(862,97,'上林县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(863,97,'宾阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(864,97,'横县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(865,98,'秀峰区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(866,98,'叠彩区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(867,98,'象山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(868,98,'七星区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(869,98,'雁山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(870,98,'阳朔县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(871,98,'临桂县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(872,98,'灵川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(873,98,'全州县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(874,98,'平乐县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(875,98,'兴安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(876,98,'灌阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(877,98,'荔浦县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(878,98,'资源县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(879,98,'永福县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(880,98,'龙胜',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(881,98,'恭城',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(882,99,'右江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(883,99,'凌云县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(884,99,'平果县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(885,99,'西林县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(886,99,'乐业县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(887,99,'德保县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(888,99,'田林县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(889,99,'田阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(890,99,'靖西县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(891,99,'田东县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(892,99,'那坡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(893,99,'隆林',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(894,100,'海城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(895,100,'银海区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(896,100,'铁山港区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(897,100,'合浦县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(898,101,'江州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(899,101,'凭祥市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(900,101,'宁明县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(901,101,'扶绥县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(902,101,'龙州县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(903,101,'大新县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(904,101,'天等县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(905,102,'港口区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(906,102,'防城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(907,102,'东兴市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(908,102,'上思县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(909,103,'港北区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(910,103,'港南区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(911,103,'覃塘区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(912,103,'桂平市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(913,103,'平南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(914,104,'金城江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(915,104,'宜州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(916,104,'天峨县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(917,104,'凤山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(918,104,'南丹县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(919,104,'东兰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(920,104,'都安',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(921,104,'罗城',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(922,104,'巴马',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(923,104,'环江',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(924,104,'大化',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(925,105,'八步区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(926,105,'钟山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(927,105,'昭平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(928,105,'富川',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(929,106,'兴宾区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(930,106,'合山市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(931,106,'象州县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(932,106,'武宣县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(933,106,'忻城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(934,106,'金秀',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(935,107,'城中区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(936,107,'鱼峰区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(937,107,'柳北区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(938,107,'柳南区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(939,107,'柳江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(940,107,'柳城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(941,107,'鹿寨县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(942,107,'融安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(943,107,'融水',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(944,107,'三江',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(945,108,'钦南区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(946,108,'钦北区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(947,108,'灵山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(948,108,'浦北县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(949,109,'万秀区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(950,109,'蝶山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(951,109,'长洲区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(952,109,'岑溪市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(953,109,'苍梧县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(954,109,'藤县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(955,109,'蒙山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(956,110,'玉州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(957,110,'北流市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(958,110,'容县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(959,110,'陆川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(960,110,'博白县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(961,110,'兴业县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(962,111,'南明区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(963,111,'云岩区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(964,111,'花溪区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(965,111,'乌当区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(966,111,'白云区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(967,111,'小河区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(968,111,'金阳新区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(969,111,'新天园区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(970,111,'清镇市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(971,111,'开阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(972,111,'修文县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(973,111,'息烽县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(974,112,'西秀区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(975,112,'关岭',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(976,112,'镇宁',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(977,112,'紫云',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(978,112,'平坝县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(979,112,'普定县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(980,113,'毕节市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(981,113,'大方县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(982,113,'黔西县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(983,113,'金沙县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(984,113,'织金县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(985,113,'纳雍县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(986,113,'赫章县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(987,113,'威宁',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(988,114,'钟山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(989,114,'六枝特区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(990,114,'水城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(991,114,'盘县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(992,115,'凯里市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(993,115,'黄平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(994,115,'施秉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(995,115,'三穗县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(996,115,'镇远县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(997,115,'岑巩县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(998,115,'天柱县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(999,115,'锦屏县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1000,115,'剑河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1001,115,'台江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1002,115,'黎平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1003,115,'榕江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1004,115,'从江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1005,115,'雷山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1006,115,'麻江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1007,115,'丹寨县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1008,116,'都匀市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1009,116,'福泉市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1010,116,'荔波县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1011,116,'贵定县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1012,116,'瓮安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1013,116,'独山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1014,116,'平塘县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1015,116,'罗甸县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1016,116,'长顺县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1017,116,'龙里县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1018,116,'惠水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1019,116,'三都',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1020,117,'兴义市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1021,117,'兴仁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1022,117,'普安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1023,117,'晴隆县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1024,117,'贞丰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1025,117,'望谟县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1026,117,'册亨县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1027,117,'安龙县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1028,118,'铜仁市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1029,118,'江口县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1030,118,'石阡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1031,118,'思南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1032,118,'德江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1033,118,'玉屏',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1034,118,'印江',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1035,118,'沿河',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1036,118,'松桃',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1037,118,'万山特区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1038,119,'红花岗区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1039,119,'务川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1040,119,'道真县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1041,119,'汇川区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1042,119,'赤水市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1043,119,'仁怀市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1044,119,'遵义县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1045,119,'桐梓县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1046,119,'绥阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1047,119,'正安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1048,119,'凤冈县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1049,119,'湄潭县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1050,119,'余庆县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1051,119,'习水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1052,119,'道真',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1053,119,'务川',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1054,120,'秀英区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1055,120,'龙华区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1056,120,'琼山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1057,120,'美兰区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1058,137,'市区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1059,137,'洋浦开发区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1060,137,'那大镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1061,137,'王五镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1062,137,'雅星镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1063,137,'大成镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1064,137,'中和镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1065,137,'峨蔓镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1066,137,'南丰镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1067,137,'白马井镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1068,137,'兰洋镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1069,137,'和庆镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1070,137,'海头镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1071,137,'排浦镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1072,137,'东成镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1073,137,'光村镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1074,137,'木棠镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1075,137,'新州镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1076,137,'三都镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1077,137,'其他',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1078,138,'长安区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1079,138,'桥东区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1080,138,'桥西区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1081,138,'新华区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1082,138,'裕华区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1083,138,'井陉矿区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1084,138,'高新区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1085,138,'辛集市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1086,138,'藁城市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1087,138,'晋州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1088,138,'新乐市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1089,138,'鹿泉市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1090,138,'井陉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1091,138,'正定县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1092,138,'栾城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1093,138,'行唐县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1094,138,'灵寿县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1095,138,'高邑县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1096,138,'深泽县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1097,138,'赞皇县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1098,138,'无极县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1099,138,'平山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1100,138,'元氏县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1101,138,'赵县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1102,139,'新市区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1103,139,'南市区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1104,139,'北市区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1105,139,'涿州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1106,139,'定州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1107,139,'安国市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1108,139,'高碑店市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1109,139,'满城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1110,139,'清苑县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1111,139,'涞水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1112,139,'阜平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1113,139,'徐水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1114,139,'定兴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1115,139,'唐县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1116,139,'高阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1117,139,'容城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1118,139,'涞源县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1119,139,'望都县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1120,139,'安新县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1121,139,'易县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1122,139,'曲阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1123,139,'蠡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1124,139,'顺平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1125,139,'博野县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1126,139,'雄县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1127,140,'运河区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1128,140,'新华区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1129,140,'泊头市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1130,140,'任丘市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1131,140,'黄骅市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1132,140,'河间市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1133,140,'沧县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1134,140,'青县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1135,140,'东光县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1136,140,'海兴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1137,140,'盐山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1138,140,'肃宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1139,140,'南皮县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1140,140,'吴桥县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1141,140,'献县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1142,140,'孟村',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1143,141,'双桥区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1144,141,'双滦区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1145,141,'鹰手营子矿区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1146,141,'承德县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1147,141,'兴隆县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1148,141,'平泉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1149,141,'滦平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1150,141,'隆化县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1151,141,'丰宁',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1152,141,'宽城',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1153,141,'围场',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1154,142,'从台区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1155,142,'复兴区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1156,142,'邯山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1157,142,'峰峰矿区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1158,142,'武安市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1159,142,'邯郸县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1160,142,'临漳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1161,142,'成安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1162,142,'大名县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1163,142,'涉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1164,142,'磁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1165,142,'肥乡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1166,142,'永年县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1167,142,'邱县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1168,142,'鸡泽县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1169,142,'广平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1170,142,'馆陶县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1171,142,'魏县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1172,142,'曲周县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1173,143,'桃城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1174,143,'冀州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1175,143,'深州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1176,143,'枣强县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1177,143,'武邑县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1178,143,'武强县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1179,143,'饶阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1180,143,'安平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1181,143,'故城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1182,143,'景县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1183,143,'阜城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1184,144,'安次区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1185,144,'广阳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1186,144,'霸州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1187,144,'三河市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1188,144,'固安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1189,144,'永清县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1190,144,'香河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1191,144,'大城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1192,144,'文安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1193,144,'大厂',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1194,145,'海港区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1195,145,'山海关区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1196,145,'北戴河区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1197,145,'昌黎县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1198,145,'抚宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1199,145,'卢龙县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1200,145,'青龙',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1201,146,'路北区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1202,146,'路南区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1203,146,'古冶区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1204,146,'开平区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1205,146,'丰南区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1206,146,'丰润区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1207,146,'遵化市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1208,146,'迁安市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1209,146,'滦县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1210,146,'滦南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1211,146,'乐亭县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1212,146,'迁西县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1213,146,'玉田县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1214,146,'唐海县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1215,147,'桥东区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1216,147,'桥西区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1217,147,'南宫市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1218,147,'沙河市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1219,147,'邢台县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1220,147,'临城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1221,147,'内丘县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1222,147,'柏乡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1223,147,'隆尧县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1224,147,'任县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1225,147,'南和县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1226,147,'宁晋县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1227,147,'巨鹿县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1228,147,'新河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1229,147,'广宗县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1230,147,'平乡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1231,147,'威县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1232,147,'清河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1233,147,'临西县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1234,148,'桥西区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1235,148,'桥东区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1236,148,'宣化区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1237,148,'下花园区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1238,148,'宣化县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1239,148,'张北县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1240,148,'康保县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1241,148,'沽源县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1242,148,'尚义县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1243,148,'蔚县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1244,148,'阳原县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1245,148,'怀安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1246,148,'万全县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1247,148,'怀来县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1248,148,'涿鹿县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1249,148,'赤城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1250,148,'崇礼县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1251,149,'金水区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1252,149,'邙山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1253,149,'二七区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1254,149,'管城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1255,149,'中原区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1256,149,'上街区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1257,149,'惠济区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1258,149,'郑东新区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1259,149,'经济技术开发区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1260,149,'高新开发区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1261,149,'出口加工区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1262,149,'巩义市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1263,149,'荥阳市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1264,149,'新密市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1265,149,'新郑市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1266,149,'登封市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1267,149,'中牟县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1268,150,'西工区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1269,150,'老城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1270,150,'涧西区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1271,150,'瀍河回族区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1272,150,'洛龙区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1273,150,'吉利区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1274,150,'偃师市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1275,150,'孟津县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1276,150,'新安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1277,150,'栾川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1278,150,'嵩县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1279,150,'汝阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1280,150,'宜阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1281,150,'洛宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1282,150,'伊川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1283,151,'鼓楼区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1284,151,'龙亭区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1285,151,'顺河回族区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1286,151,'金明区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1287,151,'禹王台区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1288,151,'杞县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1289,151,'通许县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1290,151,'尉氏县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1291,151,'开封县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1292,151,'兰考县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1293,152,'北关区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1294,152,'文峰区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1295,152,'殷都区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1296,152,'龙安区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1297,152,'林州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1298,152,'安阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1299,152,'汤阴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1300,152,'滑县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1301,152,'内黄县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1302,153,'淇滨区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1303,153,'山城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1304,153,'鹤山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1305,153,'浚县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1306,153,'淇县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1307,154,'济源市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1308,155,'解放区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1309,155,'中站区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1310,155,'马村区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1311,155,'山阳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1312,155,'沁阳市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1313,155,'孟州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1314,155,'修武县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1315,155,'博爱县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1316,155,'武陟县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1317,155,'温县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1318,156,'卧龙区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1319,156,'宛城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1320,156,'邓州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1321,156,'南召县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1322,156,'方城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1323,156,'西峡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1324,156,'镇平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1325,156,'内乡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1326,156,'淅川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1327,156,'社旗县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1328,156,'唐河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1329,156,'新野县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1330,156,'桐柏县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1331,157,'新华区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1332,157,'卫东区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1333,157,'湛河区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1334,157,'石龙区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1335,157,'舞钢市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1336,157,'汝州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1337,157,'宝丰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1338,157,'叶县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1339,157,'鲁山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1340,157,'郏县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1341,158,'湖滨区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1342,158,'义马市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1343,158,'灵宝市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1344,158,'渑池县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1345,158,'陕县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1346,158,'卢氏县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1347,159,'梁园区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1348,159,'睢阳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1349,159,'永城市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1350,159,'民权县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1351,159,'睢县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1352,159,'宁陵县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1353,159,'虞城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1354,159,'柘城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1355,159,'夏邑县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1356,160,'卫滨区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1357,160,'红旗区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1358,160,'凤泉区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1359,160,'牧野区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1360,160,'卫辉市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1361,160,'辉县市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1362,160,'新乡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1363,160,'获嘉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1364,160,'原阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1365,160,'延津县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1366,160,'封丘县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1367,160,'长垣县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1368,161,'浉河区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1369,161,'平桥区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1370,161,'罗山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1371,161,'光山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1372,161,'新县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1373,161,'商城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1374,161,'固始县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1375,161,'潢川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1376,161,'淮滨县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1377,161,'息县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1378,162,'魏都区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1379,162,'禹州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1380,162,'长葛市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1381,162,'许昌县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1382,162,'鄢陵县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1383,162,'襄城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1384,163,'川汇区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1385,163,'项城市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1386,163,'扶沟县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1387,163,'西华县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1388,163,'商水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1389,163,'沈丘县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1390,163,'郸城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1391,163,'淮阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1392,163,'太康县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1393,163,'鹿邑县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1394,164,'驿城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1395,164,'西平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1396,164,'上蔡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1397,164,'平舆县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1398,164,'正阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1399,164,'确山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1400,164,'泌阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1401,164,'汝南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1402,164,'遂平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1403,164,'新蔡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1404,165,'郾城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1405,165,'源汇区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1406,165,'召陵区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1407,165,'舞阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1408,165,'临颍县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1409,166,'华龙区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1410,166,'清丰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1411,166,'南乐县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1412,166,'范县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1413,166,'台前县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1414,166,'濮阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1415,167,'道里区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1416,167,'南岗区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1417,167,'动力区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1418,167,'平房区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1419,167,'香坊区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1420,167,'太平区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1421,167,'道外区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1422,167,'阿城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1423,167,'呼兰区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1424,167,'松北区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1425,167,'尚志市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1426,167,'双城市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1427,167,'五常市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1428,167,'方正县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1429,167,'宾县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1430,167,'依兰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1431,167,'巴彦县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1432,167,'通河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1433,167,'木兰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1434,167,'延寿县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1435,168,'萨尔图区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1436,168,'红岗区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1437,168,'龙凤区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1438,168,'让胡路区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1439,168,'大同区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1440,168,'肇州县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1441,168,'肇源县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1442,168,'林甸县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1443,168,'杜尔伯特',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1444,169,'呼玛县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1445,169,'漠河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1446,169,'塔河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1447,170,'兴山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1448,170,'工农区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1449,170,'南山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1450,170,'兴安区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1451,170,'向阳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1452,170,'东山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1453,170,'萝北县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1454,170,'绥滨县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1455,171,'爱辉区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1456,171,'五大连池市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1457,171,'北安市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1458,171,'嫩江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1459,171,'逊克县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1460,171,'孙吴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1461,172,'鸡冠区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1462,172,'恒山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1463,172,'城子河区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1464,172,'滴道区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1465,172,'梨树区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1466,172,'虎林市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1467,172,'密山市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1468,172,'鸡东县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1469,173,'前进区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1470,173,'郊区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1471,173,'向阳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1472,173,'东风区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1473,173,'同江市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1474,173,'富锦市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1475,173,'桦南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1476,173,'桦川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1477,173,'汤原县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1478,173,'抚远县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1479,174,'爱民区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1480,174,'东安区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1481,174,'阳明区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1482,174,'西安区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1483,174,'绥芬河市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1484,174,'海林市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1485,174,'宁安市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1486,174,'穆棱市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1487,174,'东宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1488,174,'林口县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1489,175,'桃山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1490,175,'新兴区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1491,175,'茄子河区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1492,175,'勃利县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1493,176,'龙沙区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1494,176,'昂昂溪区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1495,176,'铁峰区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1496,176,'建华区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1497,176,'富拉尔基区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1498,176,'碾子山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1499,176,'梅里斯达斡尔区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1500,176,'讷河市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1501,176,'龙江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1502,176,'依安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1503,176,'泰来县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1504,176,'甘南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1505,176,'富裕县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1506,176,'克山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1507,176,'克东县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1508,176,'拜泉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1509,177,'尖山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1510,177,'岭东区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1511,177,'四方台区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1512,177,'宝山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1513,177,'集贤县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1514,177,'友谊县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1515,177,'宝清县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1516,177,'饶河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1517,178,'北林区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1518,178,'安达市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1519,178,'肇东市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1520,178,'海伦市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1521,178,'望奎县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1522,178,'兰西县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1523,178,'青冈县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1524,178,'庆安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1525,178,'明水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1526,178,'绥棱县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1527,179,'伊春区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1528,179,'带岭区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1529,179,'南岔区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1530,179,'金山屯区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1531,179,'西林区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1532,179,'美溪区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1533,179,'乌马河区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1534,179,'翠峦区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1535,179,'友好区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1536,179,'上甘岭区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1537,179,'五营区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1538,179,'红星区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1539,179,'新青区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1540,179,'汤旺河区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1541,179,'乌伊岭区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1542,179,'铁力市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1543,179,'嘉荫县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1544,180,'江岸区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1545,180,'武昌区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1546,180,'江汉区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1547,180,'硚口区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1548,180,'汉阳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1549,180,'青山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1550,180,'洪山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1551,180,'东西湖区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1552,180,'汉南区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1553,180,'蔡甸区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1554,180,'江夏区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1555,180,'黄陂区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1556,180,'新洲区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1557,180,'经济开发区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1558,181,'仙桃市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1559,182,'鄂城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1560,182,'华容区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1561,182,'梁子湖区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1562,183,'黄州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1563,183,'麻城市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1564,183,'武穴市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1565,183,'团风县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1566,183,'红安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1567,183,'罗田县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1568,183,'英山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1569,183,'浠水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1570,183,'蕲春县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1571,183,'黄梅县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1572,184,'黄石港区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1573,184,'西塞山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1574,184,'下陆区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1575,184,'铁山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1576,184,'大冶市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1577,184,'阳新县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1578,185,'东宝区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1579,185,'掇刀区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1580,185,'钟祥市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1581,185,'京山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1582,185,'沙洋县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1583,186,'沙市区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1584,186,'荆州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1585,186,'石首市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1586,186,'洪湖市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1587,186,'松滋市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1588,186,'公安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1589,186,'监利县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1590,186,'江陵县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1591,187,'潜江市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1592,188,'神农架林区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1593,189,'张湾区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1594,189,'茅箭区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1595,189,'丹江口市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1596,189,'郧县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1597,189,'郧西县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1598,189,'竹山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1599,189,'竹溪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1600,189,'房县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1601,190,'曾都区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1602,190,'广水市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1603,191,'天门市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1604,192,'咸安区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1605,192,'赤壁市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1606,192,'嘉鱼县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1607,192,'通城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1608,192,'崇阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1609,192,'通山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1610,193,'襄城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1611,193,'樊城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1612,193,'襄阳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1613,193,'老河口市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1614,193,'枣阳市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1615,193,'宜城市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1616,193,'南漳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1617,193,'谷城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1618,193,'保康县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1619,194,'孝南区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1620,194,'应城市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1621,194,'安陆市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1622,194,'汉川市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1623,194,'孝昌县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1624,194,'大悟县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1625,194,'云梦县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1626,195,'长阳',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1627,195,'五峰',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1628,195,'西陵区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1629,195,'伍家岗区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1630,195,'点军区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1631,195,'猇亭区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1632,195,'夷陵区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1633,195,'宜都市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1634,195,'当阳市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1635,195,'枝江市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1636,195,'远安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1637,195,'兴山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1638,195,'秭归县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1639,196,'恩施市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1640,196,'利川市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1641,196,'建始县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1642,196,'巴东县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1643,196,'宣恩县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1644,196,'咸丰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1645,196,'来凤县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1646,196,'鹤峰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1647,197,'岳麓区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1648,197,'芙蓉区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1649,197,'天心区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1650,197,'开福区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1651,197,'雨花区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1652,197,'开发区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1653,197,'浏阳市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1654,197,'长沙县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1655,197,'望城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1656,197,'宁乡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1657,198,'永定区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1658,198,'武陵源区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1659,198,'慈利县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1660,198,'桑植县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1661,199,'武陵区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1662,199,'鼎城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1663,199,'津市市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1664,199,'安乡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1665,199,'汉寿县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1666,199,'澧县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1667,199,'临澧县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1668,199,'桃源县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1669,199,'石门县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1670,200,'北湖区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1671,200,'苏仙区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1672,200,'资兴市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1673,200,'桂阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1674,200,'宜章县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1675,200,'永兴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1676,200,'嘉禾县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1677,200,'临武县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1678,200,'汝城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1679,200,'桂东县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1680,200,'安仁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1681,201,'雁峰区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1682,201,'珠晖区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1683,201,'石鼓区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1684,201,'蒸湘区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1685,201,'南岳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1686,201,'耒阳市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1687,201,'常宁市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1688,201,'衡阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1689,201,'衡南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1690,201,'衡山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1691,201,'衡东县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1692,201,'祁东县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1693,202,'鹤城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1694,202,'靖州',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1695,202,'麻阳',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1696,202,'通道',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1697,202,'新晃',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1698,202,'芷江',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1699,202,'沅陵县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1700,202,'辰溪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1701,202,'溆浦县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1702,202,'中方县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1703,202,'会同县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1704,202,'洪江市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1705,203,'娄星区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1706,203,'冷水江市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1707,203,'涟源市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1708,203,'双峰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1709,203,'新化县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1710,204,'城步',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1711,204,'双清区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1712,204,'大祥区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1713,204,'北塔区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1714,204,'武冈市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1715,204,'邵东县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1716,204,'新邵县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1717,204,'邵阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1718,204,'隆回县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1719,204,'洞口县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1720,204,'绥宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1721,204,'新宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1722,205,'岳塘区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1723,205,'雨湖区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1724,205,'湘乡市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1725,205,'韶山市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1726,205,'湘潭县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1727,206,'吉首市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1728,206,'泸溪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1729,206,'凤凰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1730,206,'花垣县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1731,206,'保靖县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1732,206,'古丈县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1733,206,'永顺县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1734,206,'龙山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1735,207,'赫山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1736,207,'资阳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1737,207,'沅江市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1738,207,'南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1739,207,'桃江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1740,207,'安化县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1741,208,'江华',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1742,208,'冷水滩区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1743,208,'零陵区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1744,208,'祁阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1745,208,'东安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1746,208,'双牌县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1747,208,'道县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1748,208,'江永县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1749,208,'宁远县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1750,208,'蓝山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1751,208,'新田县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1752,209,'岳阳楼区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1753,209,'君山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1754,209,'云溪区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1755,209,'汨罗市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1756,209,'临湘市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1757,209,'岳阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1758,209,'华容县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1759,209,'湘阴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1760,209,'平江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1761,210,'天元区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1762,210,'荷塘区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1763,210,'芦淞区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1764,210,'石峰区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1765,210,'醴陵市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1766,210,'株洲县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1767,210,'攸县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1768,210,'茶陵县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1769,210,'炎陵县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1770,211,'朝阳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1771,211,'宽城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1772,211,'二道区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1773,211,'南关区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1774,211,'绿园区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1775,211,'双阳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1776,211,'净月潭开发区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1777,211,'高新技术开发区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1778,211,'经济技术开发区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1779,211,'汽车产业开发区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1780,211,'德惠市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1781,211,'九台市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1782,211,'榆树市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1783,211,'农安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1784,212,'船营区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1785,212,'昌邑区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1786,212,'龙潭区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1787,212,'丰满区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1788,212,'蛟河市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1789,212,'桦甸市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1790,212,'舒兰市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1791,212,'磐石市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1792,212,'永吉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1793,213,'洮北区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1794,213,'洮南市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1795,213,'大安市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1796,213,'镇赉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1797,213,'通榆县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1798,214,'江源区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1799,214,'八道江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1800,214,'长白',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1801,214,'临江市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1802,214,'抚松县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1803,214,'靖宇县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1804,215,'龙山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1805,215,'西安区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1806,215,'东丰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1807,215,'东辽县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1808,216,'铁西区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1809,216,'铁东区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1810,216,'伊通',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1811,216,'公主岭市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1812,216,'双辽市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1813,216,'梨树县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1814,217,'前郭尔罗斯',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1815,217,'宁江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1816,217,'长岭县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1817,217,'乾安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1818,217,'扶余县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1819,218,'东昌区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1820,218,'二道江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1821,218,'梅河口市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1822,218,'集安市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1823,218,'通化县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1824,218,'辉南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1825,218,'柳河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1826,219,'延吉市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1827,219,'图们市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1828,219,'敦化市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1829,219,'珲春市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1830,219,'龙井市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1831,219,'和龙市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1832,219,'安图县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1833,219,'汪清县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1834,220,'玄武区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1835,220,'鼓楼区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1836,220,'白下区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1837,220,'建邺区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1838,220,'秦淮区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1839,220,'雨花台区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1840,220,'下关区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1841,220,'栖霞区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1842,220,'浦口区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1843,220,'江宁区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1844,220,'六合区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1845,220,'溧水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1846,220,'高淳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1847,221,'沧浪区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1848,221,'金阊区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1849,221,'平江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1850,221,'虎丘区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1851,221,'吴中区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1852,221,'相城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1853,221,'园区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1854,221,'新区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1855,221,'常熟市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1856,221,'张家港市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1857,221,'玉山镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1858,221,'巴城镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1859,221,'周市镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1860,221,'陆家镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1861,221,'花桥镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1862,221,'淀山湖镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1863,221,'张浦镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1864,221,'周庄镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1865,221,'千灯镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1866,221,'锦溪镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1867,221,'开发区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1868,221,'吴江市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1869,221,'太仓市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1870,222,'崇安区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1871,222,'北塘区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1872,222,'南长区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1873,222,'锡山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1874,222,'惠山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1875,222,'滨湖区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1876,222,'新区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1877,222,'江阴市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1878,222,'宜兴市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1879,223,'天宁区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1880,223,'钟楼区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1881,223,'戚墅堰区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1882,223,'郊区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1883,223,'新北区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1884,223,'武进区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1885,223,'溧阳市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1886,223,'金坛市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1887,224,'清河区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1888,224,'清浦区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1889,224,'楚州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1890,224,'淮阴区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1891,224,'涟水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1892,224,'洪泽县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1893,224,'盱眙县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1894,224,'金湖县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1895,225,'新浦区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1896,225,'连云区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1897,225,'海州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1898,225,'赣榆县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1899,225,'东海县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1900,225,'灌云县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1901,225,'灌南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1902,226,'崇川区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1903,226,'港闸区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1904,226,'经济开发区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1905,226,'启东市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1906,226,'如皋市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1907,226,'通州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1908,226,'海门市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1909,226,'海安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1910,226,'如东县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1911,227,'宿城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1912,227,'宿豫区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1913,227,'宿豫县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1914,227,'沭阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1915,227,'泗阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1916,227,'泗洪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1917,228,'海陵区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1918,228,'高港区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1919,228,'兴化市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1920,228,'靖江市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1921,228,'泰兴市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1922,228,'姜堰市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1923,229,'云龙区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1924,229,'鼓楼区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1925,229,'九里区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1926,229,'贾汪区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1927,229,'泉山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1928,229,'新沂市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1929,229,'邳州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1930,229,'丰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1931,229,'沛县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1932,229,'铜山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1933,229,'睢宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1934,230,'城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1935,230,'亭湖区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1936,230,'盐都区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1937,230,'盐都县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1938,230,'东台市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1939,230,'大丰市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1940,230,'响水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1941,230,'滨海县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1942,230,'阜宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1943,230,'射阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1944,230,'建湖县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1945,231,'广陵区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1946,231,'维扬区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1947,231,'邗江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1948,231,'仪征市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1949,231,'高邮市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1950,231,'江都市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1951,231,'宝应县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1952,232,'京口区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1953,232,'润州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1954,232,'丹徒区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1955,232,'丹阳市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1956,232,'扬中市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1957,232,'句容市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1958,233,'东湖区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1959,233,'西湖区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1960,233,'青云谱区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1961,233,'湾里区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1962,233,'青山湖区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1963,233,'红谷滩新区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1964,233,'昌北区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1965,233,'高新区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1966,233,'南昌县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1967,233,'新建县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1968,233,'安义县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1969,233,'进贤县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1970,234,'临川区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1971,234,'南城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1972,234,'黎川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1973,234,'南丰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1974,234,'崇仁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1975,234,'乐安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1976,234,'宜黄县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1977,234,'金溪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1978,234,'资溪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1979,234,'东乡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1980,234,'广昌县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1981,235,'章贡区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1982,235,'于都县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1983,235,'瑞金市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1984,235,'南康市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1985,235,'赣县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1986,235,'信丰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1987,235,'大余县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1988,235,'上犹县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1989,235,'崇义县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1990,235,'安远县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1991,235,'龙南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1992,235,'定南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1993,235,'全南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1994,235,'宁都县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1995,235,'兴国县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1996,235,'会昌县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1997,235,'寻乌县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1998,235,'石城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(1999,236,'安福县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2000,236,'吉州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2001,236,'青原区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2002,236,'井冈山市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2003,236,'吉安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2004,236,'吉水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2005,236,'峡江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2006,236,'新干县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2007,236,'永丰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2008,236,'泰和县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2009,236,'遂川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2010,236,'万安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2011,236,'永新县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2012,237,'珠山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2013,237,'昌江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2014,237,'乐平市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2015,237,'浮梁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2016,238,'浔阳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2017,238,'庐山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2018,238,'瑞昌市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2019,238,'九江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2020,238,'武宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2021,238,'修水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2022,238,'永修县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2023,238,'德安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2024,238,'星子县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2025,238,'都昌县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2026,238,'湖口县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2027,238,'彭泽县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2028,239,'安源区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2029,239,'湘东区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2030,239,'莲花县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2031,239,'芦溪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2032,239,'上栗县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2033,240,'信州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2034,240,'德兴市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2035,240,'上饶县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2036,240,'广丰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2037,240,'玉山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2038,240,'铅山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2039,240,'横峰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2040,240,'弋阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2041,240,'余干县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2042,240,'波阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2043,240,'万年县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2044,240,'婺源县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2045,241,'渝水区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2046,241,'分宜县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2047,242,'袁州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2048,242,'丰城市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2049,242,'樟树市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2050,242,'高安市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2051,242,'奉新县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2052,242,'万载县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2053,242,'上高县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2054,242,'宜丰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2055,242,'靖安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2056,242,'铜鼓县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2057,243,'月湖区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2058,243,'贵溪市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2059,243,'余江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2060,244,'沈河区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2061,244,'皇姑区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2062,244,'和平区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2063,244,'大东区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2064,244,'铁西区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2065,244,'苏家屯区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2066,244,'东陵区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2067,244,'沈北新区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2068,244,'于洪区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2069,244,'浑南新区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2070,244,'新民市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2071,244,'辽中县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2072,244,'康平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2073,244,'法库县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2074,245,'西岗区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2075,245,'中山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2076,245,'沙河口区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2077,245,'甘井子区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2078,245,'旅顺口区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2079,245,'金州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2080,245,'开发区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2081,245,'瓦房店市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2082,245,'普兰店市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2083,245,'庄河市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2084,245,'长海县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2085,246,'铁东区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2086,246,'铁西区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2087,246,'立山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2088,246,'千山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2089,246,'岫岩',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2090,246,'海城市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2091,246,'台安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2092,247,'本溪',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2093,247,'平山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2094,247,'明山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2095,247,'溪湖区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2096,247,'南芬区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2097,247,'桓仁',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2098,248,'双塔区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2099,248,'龙城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2100,248,'喀喇沁左翼蒙古族自治县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2101,248,'北票市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2102,248,'凌源市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2103,248,'朝阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2104,248,'建平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2105,249,'振兴区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2106,249,'元宝区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2107,249,'振安区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2108,249,'宽甸',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2109,249,'东港市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2110,249,'凤城市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2111,250,'顺城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2112,250,'新抚区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2113,250,'东洲区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2114,250,'望花区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2115,250,'清原',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2116,250,'新宾',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2117,250,'抚顺县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2118,251,'阜新',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2119,251,'海州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2120,251,'新邱区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2121,251,'太平区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2122,251,'清河门区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2123,251,'细河区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2124,251,'彰武县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2125,252,'龙港区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2126,252,'南票区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2127,252,'连山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2128,252,'兴城市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2129,252,'绥中县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2130,252,'建昌县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2131,253,'太和区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2132,253,'古塔区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2133,253,'凌河区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2134,253,'凌海市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2135,253,'北镇市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2136,253,'黑山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2137,253,'义县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2138,254,'白塔区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2139,254,'文圣区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2140,254,'宏伟区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2141,254,'太子河区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2142,254,'弓长岭区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2143,254,'灯塔市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2144,254,'辽阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2145,255,'双台子区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2146,255,'兴隆台区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2147,255,'大洼县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2148,255,'盘山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2149,256,'银州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2150,256,'清河区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2151,256,'调兵山市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2152,256,'开原市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2153,256,'铁岭县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2154,256,'西丰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2155,256,'昌图县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2156,257,'站前区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2157,257,'西市区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2158,257,'鲅鱼圈区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2159,257,'老边区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2160,257,'盖州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2161,257,'大石桥市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2162,258,'回民区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2163,258,'玉泉区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2164,258,'新城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2165,258,'赛罕区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2166,258,'清水河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2167,258,'土默特左旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2168,258,'托克托县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2169,258,'和林格尔县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2170,258,'武川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2171,259,'阿拉善左旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2172,259,'阿拉善右旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2173,259,'额济纳旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2174,260,'临河区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2175,260,'五原县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2176,260,'磴口县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2177,260,'乌拉特前旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2178,260,'乌拉特中旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2179,260,'乌拉特后旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2180,260,'杭锦后旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2181,261,'昆都仑区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2182,261,'青山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2183,261,'东河区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2184,261,'九原区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2185,261,'石拐区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2186,261,'白云矿区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2187,261,'土默特右旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2188,261,'固阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2189,261,'达尔罕茂明安联合旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2190,262,'红山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2191,262,'元宝山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2192,262,'松山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2193,262,'阿鲁科尔沁旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2194,262,'巴林左旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2195,262,'巴林右旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2196,262,'林西县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2197,262,'克什克腾旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2198,262,'翁牛特旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2199,262,'喀喇沁旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2200,262,'宁城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2201,262,'敖汉旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2202,263,'东胜区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2203,263,'达拉特旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2204,263,'准格尔旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2205,263,'鄂托克前旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2206,263,'鄂托克旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2207,263,'杭锦旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2208,263,'乌审旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2209,263,'伊金霍洛旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2210,264,'海拉尔区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2211,264,'莫力达瓦',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2212,264,'满洲里市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2213,264,'牙克石市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2214,264,'扎兰屯市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2215,264,'额尔古纳市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2216,264,'根河市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2217,264,'阿荣旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2218,264,'鄂伦春自治旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2219,264,'鄂温克族自治旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2220,264,'陈巴尔虎旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2221,264,'新巴尔虎左旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2222,264,'新巴尔虎右旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2223,265,'科尔沁区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2224,265,'霍林郭勒市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2225,265,'科尔沁左翼中旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2226,265,'科尔沁左翼后旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2227,265,'开鲁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2228,265,'库伦旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2229,265,'奈曼旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2230,265,'扎鲁特旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2231,266,'海勃湾区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2232,266,'乌达区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2233,266,'海南区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2234,267,'化德县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2235,267,'集宁区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2236,267,'丰镇市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2237,267,'卓资县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2238,267,'商都县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2239,267,'兴和县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2240,267,'凉城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2241,267,'察哈尔右翼前旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2242,267,'察哈尔右翼中旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2243,267,'察哈尔右翼后旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2244,267,'四子王旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2245,268,'二连浩特市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2246,268,'锡林浩特市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2247,268,'阿巴嘎旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2248,268,'苏尼特左旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2249,268,'苏尼特右旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2250,268,'东乌珠穆沁旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2251,268,'西乌珠穆沁旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2252,268,'太仆寺旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2253,268,'镶黄旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2254,268,'正镶白旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2255,268,'正蓝旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2256,268,'多伦县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2257,269,'乌兰浩特市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2258,269,'阿尔山市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2259,269,'科尔沁右翼前旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2260,269,'科尔沁右翼中旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2261,269,'扎赉特旗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2262,269,'突泉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2263,270,'西夏区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2264,270,'金凤区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2265,270,'兴庆区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2266,270,'灵武市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2267,270,'永宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2268,270,'贺兰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2269,271,'原州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2270,271,'海原县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2271,271,'西吉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2272,271,'隆德县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2273,271,'泾源县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2274,271,'彭阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2275,272,'惠农县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2276,272,'大武口区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2277,272,'惠农区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2278,272,'陶乐县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2279,272,'平罗县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2280,273,'利通区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2281,273,'中卫县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2282,273,'青铜峡市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2283,273,'中宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2284,273,'盐池县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2285,273,'同心县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2286,274,'沙坡头区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2287,274,'海原县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2288,274,'中宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2289,275,'城中区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2290,275,'城东区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2291,275,'城西区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2292,275,'城北区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2293,275,'湟中县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2294,275,'湟源县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2295,275,'大通',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2296,276,'玛沁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2297,276,'班玛县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2298,276,'甘德县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2299,276,'达日县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2300,276,'久治县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2301,276,'玛多县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2302,277,'海晏县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2303,277,'祁连县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2304,277,'刚察县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2305,277,'门源',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2306,278,'平安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2307,278,'乐都县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2308,278,'民和',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2309,278,'互助',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2310,278,'化隆',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2311,278,'循化',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2312,279,'共和县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2313,279,'同德县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2314,279,'贵德县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2315,279,'兴海县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2316,279,'贵南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2317,280,'德令哈市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2318,280,'格尔木市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2319,280,'乌兰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2320,280,'都兰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2321,280,'天峻县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2322,281,'同仁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2323,281,'尖扎县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2324,281,'泽库县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2325,281,'河南蒙古族自治县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2326,282,'玉树县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2327,282,'杂多县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2328,282,'称多县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2329,282,'治多县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2330,282,'囊谦县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2331,282,'曲麻莱县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2332,283,'市中区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2333,283,'历下区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2334,283,'天桥区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2335,283,'槐荫区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2336,283,'历城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2337,283,'长清区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2338,283,'章丘市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2339,283,'平阴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2340,283,'济阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2341,283,'商河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2342,284,'市南区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2343,284,'市北区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2344,284,'城阳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2345,284,'四方区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2346,284,'李沧区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2347,284,'黄岛区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2348,284,'崂山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2349,284,'胶州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2350,284,'即墨市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2351,284,'平度市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2352,284,'胶南市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2353,284,'莱西市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2354,285,'滨城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2355,285,'惠民县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2356,285,'阳信县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2357,285,'无棣县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2358,285,'沾化县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2359,285,'博兴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2360,285,'邹平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2361,286,'德城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2362,286,'陵县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2363,286,'乐陵市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2364,286,'禹城市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2365,286,'宁津县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2366,286,'庆云县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2367,286,'临邑县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2368,286,'齐河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2369,286,'平原县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2370,286,'夏津县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2371,286,'武城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2372,287,'东营区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2373,287,'河口区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2374,287,'垦利县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2375,287,'利津县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2376,287,'广饶县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2377,288,'牡丹区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2378,288,'曹县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2379,288,'单县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2380,288,'成武县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2381,288,'巨野县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2382,288,'郓城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2383,288,'鄄城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2384,288,'定陶县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2385,288,'东明县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2386,289,'市中区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2387,289,'任城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2388,289,'曲阜市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2389,289,'兖州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2390,289,'邹城市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2391,289,'微山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2392,289,'鱼台县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2393,289,'金乡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2394,289,'嘉祥县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2395,289,'汶上县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2396,289,'泗水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2397,289,'梁山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2398,290,'莱城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2399,290,'钢城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2400,291,'东昌府区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2401,291,'临清市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2402,291,'阳谷县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2403,291,'莘县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2404,291,'茌平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2405,291,'东阿县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2406,291,'冠县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2407,291,'高唐县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2408,292,'兰山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2409,292,'罗庄区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2410,292,'河东区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2411,292,'沂南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2412,292,'郯城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2413,292,'沂水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2414,292,'苍山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2415,292,'费县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2416,292,'平邑县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2417,292,'莒南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2418,292,'蒙阴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2419,292,'临沭县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2420,293,'东港区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2421,293,'岚山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2422,293,'五莲县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2423,293,'莒县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2424,294,'泰山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2425,294,'岱岳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2426,294,'新泰市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2427,294,'肥城市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2428,294,'宁阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2429,294,'东平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2430,295,'荣成市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2431,295,'乳山市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2432,295,'环翠区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2433,295,'文登市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2434,296,'潍城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2435,296,'寒亭区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2436,296,'坊子区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2437,296,'奎文区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2438,296,'青州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2439,296,'诸城市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2440,296,'寿光市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2441,296,'安丘市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2442,296,'高密市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2443,296,'昌邑市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2444,296,'临朐县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2445,296,'昌乐县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2446,297,'芝罘区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2447,297,'福山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2448,297,'牟平区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2449,297,'莱山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2450,297,'开发区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2451,297,'龙口市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2452,297,'莱阳市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2453,297,'莱州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2454,297,'蓬莱市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2455,297,'招远市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2456,297,'栖霞市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2457,297,'海阳市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2458,297,'长岛县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2459,298,'市中区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2460,298,'山亭区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2461,298,'峄城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2462,298,'台儿庄区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2463,298,'薛城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2464,298,'滕州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2465,299,'张店区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2466,299,'临淄区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2467,299,'淄川区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2468,299,'博山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2469,299,'周村区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2470,299,'桓台县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2471,299,'高青县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2472,299,'沂源县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2473,300,'杏花岭区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2474,300,'小店区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2475,300,'迎泽区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2476,300,'尖草坪区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2477,300,'万柏林区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2478,300,'晋源区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2479,300,'高新开发区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2480,300,'民营经济开发区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2481,300,'经济技术开发区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2482,300,'清徐县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2483,300,'阳曲县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2484,300,'娄烦县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2485,300,'古交市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2486,301,'城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2487,301,'郊区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2488,301,'沁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2489,301,'潞城市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2490,301,'长治县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2491,301,'襄垣县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2492,301,'屯留县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2493,301,'平顺县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2494,301,'黎城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2495,301,'壶关县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2496,301,'长子县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2497,301,'武乡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2498,301,'沁源县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2499,302,'城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2500,302,'矿区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2501,302,'南郊区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2502,302,'新荣区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2503,302,'阳高县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2504,302,'天镇县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2505,302,'广灵县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2506,302,'灵丘县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2507,302,'浑源县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2508,302,'左云县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2509,302,'大同县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2510,303,'城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2511,303,'高平市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2512,303,'沁水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2513,303,'阳城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2514,303,'陵川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2515,303,'泽州县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2516,304,'榆次区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2517,304,'介休市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2518,304,'榆社县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2519,304,'左权县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2520,304,'和顺县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2521,304,'昔阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2522,304,'寿阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2523,304,'太谷县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2524,304,'祁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2525,304,'平遥县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2526,304,'灵石县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2527,305,'尧都区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2528,305,'侯马市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2529,305,'霍州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2530,305,'曲沃县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2531,305,'翼城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2532,305,'襄汾县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2533,305,'洪洞县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2534,305,'吉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2535,305,'安泽县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2536,305,'浮山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2537,305,'古县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2538,305,'乡宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2539,305,'大宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2540,305,'隰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2541,305,'永和县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2542,305,'蒲县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2543,305,'汾西县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2544,306,'离石市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2545,306,'离石区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2546,306,'孝义市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2547,306,'汾阳市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2548,306,'文水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2549,306,'交城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2550,306,'兴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2551,306,'临县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2552,306,'柳林县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2553,306,'石楼县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2554,306,'岚县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2555,306,'方山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2556,306,'中阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2557,306,'交口县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2558,307,'朔城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2559,307,'平鲁区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2560,307,'山阴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2561,307,'应县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2562,307,'右玉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2563,307,'怀仁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2564,308,'忻府区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2565,308,'原平市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2566,308,'定襄县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2567,308,'五台县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2568,308,'代县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2569,308,'繁峙县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2570,308,'宁武县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2571,308,'静乐县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2572,308,'神池县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2573,308,'五寨县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2574,308,'岢岚县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2575,308,'河曲县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2576,308,'保德县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2577,308,'偏关县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2578,309,'城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2579,309,'矿区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2580,309,'郊区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2581,309,'平定县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2582,309,'盂县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2583,310,'盐湖区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2584,310,'永济市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2585,310,'河津市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2586,310,'临猗县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2587,310,'万荣县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2588,310,'闻喜县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2589,310,'稷山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2590,310,'新绛县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2591,310,'绛县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2592,310,'垣曲县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2593,310,'夏县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2594,310,'平陆县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2595,310,'芮城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2596,311,'莲湖区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2597,311,'新城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2598,311,'碑林区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2599,311,'雁塔区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2600,311,'灞桥区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2601,311,'未央区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2602,311,'阎良区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2603,311,'临潼区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2604,311,'长安区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2605,311,'蓝田县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2606,311,'周至县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2607,311,'户县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2608,311,'高陵县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2609,312,'汉滨区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2610,312,'汉阴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2611,312,'石泉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2612,312,'宁陕县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2613,312,'紫阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2614,312,'岚皋县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2615,312,'平利县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2616,312,'镇坪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2617,312,'旬阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2618,312,'白河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2619,313,'陈仓区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2620,313,'渭滨区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2621,313,'金台区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2622,313,'凤翔县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2623,313,'岐山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2624,313,'扶风县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2625,313,'眉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2626,313,'陇县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2627,313,'千阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2628,313,'麟游县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2629,313,'凤县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2630,313,'太白县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2631,314,'汉台区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2632,314,'南郑县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2633,314,'城固县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2634,314,'洋县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2635,314,'西乡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2636,314,'勉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2637,314,'宁强县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2638,314,'略阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2639,314,'镇巴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2640,314,'留坝县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2641,314,'佛坪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2642,315,'商州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2643,315,'洛南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2644,315,'丹凤县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2645,315,'商南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2646,315,'山阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2647,315,'镇安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2648,315,'柞水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2649,316,'耀州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2650,316,'王益区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2651,316,'印台区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2652,316,'宜君县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2653,317,'临渭区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2654,317,'韩城市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2655,317,'华阴市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2656,317,'华县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2657,317,'潼关县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2658,317,'大荔县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2659,317,'合阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2660,317,'澄城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2661,317,'蒲城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2662,317,'白水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2663,317,'富平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2664,318,'秦都区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2665,318,'渭城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2666,318,'杨陵区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2667,318,'兴平市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2668,318,'三原县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2669,318,'泾阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2670,318,'乾县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2671,318,'礼泉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2672,318,'永寿县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2673,318,'彬县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2674,318,'长武县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2675,318,'旬邑县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2676,318,'淳化县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2677,318,'武功县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2678,319,'吴起县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2679,319,'宝塔区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2680,319,'延长县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2681,319,'延川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2682,319,'子长县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2683,319,'安塞县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2684,319,'志丹县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2685,319,'甘泉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2686,319,'富县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2687,319,'洛川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2688,319,'宜川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2689,319,'黄龙县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2690,319,'黄陵县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2691,320,'榆阳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2692,320,'神木县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2693,320,'府谷县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2694,320,'横山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2695,320,'靖边县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2696,320,'定边县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2697,320,'绥德县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2698,320,'米脂县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2699,320,'佳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2700,320,'吴堡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2701,320,'清涧县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2702,320,'子洲县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2703,321,'长宁区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2704,321,'闸北区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2705,321,'闵行区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2706,321,'徐汇区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2707,321,'浦东新区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2708,321,'杨浦区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2709,321,'普陀区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2710,321,'静安区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2711,321,'卢湾区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2712,321,'虹口区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2713,321,'黄浦区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2714,321,'南汇区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2715,321,'松江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2716,321,'嘉定区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2717,321,'宝山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2718,321,'青浦区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2719,321,'金山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2720,321,'奉贤区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2721,321,'崇明县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2722,322,'青羊区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2723,322,'锦江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2724,322,'金牛区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2725,322,'武侯区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2726,322,'成华区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2727,322,'龙泉驿区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2728,322,'青白江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2729,322,'新都区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2730,322,'温江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2731,322,'高新区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2732,322,'高新西区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2733,322,'都江堰市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2734,322,'彭州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2735,322,'邛崃市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2736,322,'崇州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2737,322,'金堂县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2738,322,'双流县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2739,322,'郫县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2740,322,'大邑县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2741,322,'蒲江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2742,322,'新津县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2743,322,'都江堰市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2744,322,'彭州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2745,322,'邛崃市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2746,322,'崇州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2747,322,'金堂县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2748,322,'双流县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2749,322,'郫县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2750,322,'大邑县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2751,322,'蒲江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2752,322,'新津县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2753,323,'涪城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2754,323,'游仙区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2755,323,'江油市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2756,323,'盐亭县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2757,323,'三台县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2758,323,'平武县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2759,323,'安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2760,323,'梓潼县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2761,323,'北川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2762,324,'马尔康县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2763,324,'汶川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2764,324,'理县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2765,324,'茂县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2766,324,'松潘县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2767,324,'九寨沟县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2768,324,'金川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2769,324,'小金县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2770,324,'黑水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2771,324,'壤塘县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2772,324,'阿坝县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2773,324,'若尔盖县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2774,324,'红原县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2775,325,'巴州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2776,325,'通江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2777,325,'南江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2778,325,'平昌县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2779,326,'通川区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2780,326,'万源市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2781,326,'达县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2782,326,'宣汉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2783,326,'开江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2784,326,'大竹县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2785,326,'渠县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2786,327,'旌阳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2787,327,'广汉市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2788,327,'什邡市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2789,327,'绵竹市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2790,327,'罗江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2791,327,'中江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2792,328,'康定县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2793,328,'丹巴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2794,328,'泸定县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2795,328,'炉霍县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2796,328,'九龙县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2797,328,'甘孜县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2798,328,'雅江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2799,328,'新龙县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2800,328,'道孚县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2801,328,'白玉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2802,328,'理塘县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2803,328,'德格县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2804,328,'乡城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2805,328,'石渠县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2806,328,'稻城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2807,328,'色达县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2808,328,'巴塘县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2809,328,'得荣县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2810,329,'广安区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2811,329,'华蓥市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2812,329,'岳池县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2813,329,'武胜县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2814,329,'邻水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2815,330,'利州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2816,330,'元坝区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2817,330,'朝天区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2818,330,'旺苍县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2819,330,'青川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2820,330,'剑阁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2821,330,'苍溪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2822,331,'峨眉山市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2823,331,'乐山市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2824,331,'犍为县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2825,331,'井研县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2826,331,'夹江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2827,331,'沐川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2828,331,'峨边',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2829,331,'马边',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2830,332,'西昌市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2831,332,'盐源县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2832,332,'德昌县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2833,332,'会理县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2834,332,'会东县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2835,332,'宁南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2836,332,'普格县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2837,332,'布拖县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2838,332,'金阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2839,332,'昭觉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2840,332,'喜德县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2841,332,'冕宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2842,332,'越西县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2843,332,'甘洛县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2844,332,'美姑县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2845,332,'雷波县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2846,332,'木里',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2847,333,'东坡区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2848,333,'仁寿县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2849,333,'彭山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2850,333,'洪雅县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2851,333,'丹棱县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2852,333,'青神县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2853,334,'阆中市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2854,334,'南部县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2855,334,'营山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2856,334,'蓬安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2857,334,'仪陇县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2858,334,'顺庆区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2859,334,'高坪区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2860,334,'嘉陵区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2861,334,'西充县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2862,335,'市中区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2863,335,'东兴区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2864,335,'威远县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2865,335,'资中县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2866,335,'隆昌县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2867,336,'东  区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2868,336,'西  区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2869,336,'仁和区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2870,336,'米易县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2871,336,'盐边县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2872,337,'船山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2873,337,'安居区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2874,337,'蓬溪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2875,337,'射洪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2876,337,'大英县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2877,338,'雨城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2878,338,'名山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2879,338,'荥经县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2880,338,'汉源县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2881,338,'石棉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2882,338,'天全县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2883,338,'芦山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2884,338,'宝兴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2885,339,'翠屏区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2886,339,'宜宾县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2887,339,'南溪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2888,339,'江安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2889,339,'长宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2890,339,'高县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2891,339,'珙县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2892,339,'筠连县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2893,339,'兴文县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2894,339,'屏山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2895,340,'雁江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2896,340,'简阳市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2897,340,'安岳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2898,340,'乐至县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2899,341,'大安区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2900,341,'自流井区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2901,341,'贡井区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2902,341,'沿滩区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2903,341,'荣县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2904,341,'富顺县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2905,342,'江阳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2906,342,'纳溪区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2907,342,'龙马潭区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2908,342,'泸县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2909,342,'合江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2910,342,'叙永县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2911,342,'古蔺县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2912,343,'和平区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2913,343,'河西区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2914,343,'南开区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2915,343,'河北区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2916,343,'河东区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2917,343,'红桥区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2918,343,'东丽区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2919,343,'津南区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2920,343,'西青区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2921,343,'北辰区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2922,343,'塘沽区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2923,343,'汉沽区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2924,343,'大港区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2925,343,'武清区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2926,343,'宝坻区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2927,343,'经济开发区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2928,343,'宁河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2929,343,'静海县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2930,343,'蓟县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2931,344,'城关区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2932,344,'林周县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2933,344,'当雄县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2934,344,'尼木县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2935,344,'曲水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2936,344,'堆龙德庆县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2937,344,'达孜县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2938,344,'墨竹工卡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2939,345,'噶尔县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2940,345,'普兰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2941,345,'札达县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2942,345,'日土县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2943,345,'革吉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2944,345,'改则县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2945,345,'措勤县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2946,346,'昌都县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2947,346,'江达县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2948,346,'贡觉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2949,346,'类乌齐县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2950,346,'丁青县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2951,346,'察雅县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2952,346,'八宿县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2953,346,'左贡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2954,346,'芒康县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2955,346,'洛隆县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2956,346,'边坝县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2957,347,'林芝县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2958,347,'工布江达县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2959,347,'米林县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2960,347,'墨脱县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2961,347,'波密县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2962,347,'察隅县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2963,347,'朗县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2964,348,'那曲县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2965,348,'嘉黎县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2966,348,'比如县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2967,348,'聂荣县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2968,348,'安多县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2969,348,'申扎县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2970,348,'索县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2971,348,'班戈县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2972,348,'巴青县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2973,348,'尼玛县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2974,349,'日喀则市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2975,349,'南木林县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2976,349,'江孜县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2977,349,'定日县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2978,349,'萨迦县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2979,349,'拉孜县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2980,349,'昂仁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2981,349,'谢通门县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2982,349,'白朗县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2983,349,'仁布县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2984,349,'康马县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2985,349,'定结县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2986,349,'仲巴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2987,349,'亚东县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2988,349,'吉隆县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2989,349,'聂拉木县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2990,349,'萨嘎县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2991,349,'岗巴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2992,350,'乃东县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2993,350,'扎囊县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2994,350,'贡嘎县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2995,350,'桑日县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2996,350,'琼结县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2997,350,'曲松县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2998,350,'措美县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2999,350,'洛扎县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3000,350,'加查县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3001,350,'隆子县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3002,350,'错那县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3003,350,'浪卡子县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3004,351,'天山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3005,351,'沙依巴克区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3006,351,'新市区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3007,351,'水磨沟区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3008,351,'头屯河区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3009,351,'达坂城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3010,351,'米东区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3011,351,'乌鲁木齐县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3012,352,'阿克苏市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3013,352,'温宿县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3014,352,'库车县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3015,352,'沙雅县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3016,352,'新和县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3017,352,'拜城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3018,352,'乌什县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3019,352,'阿瓦提县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3020,352,'柯坪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3021,353,'阿拉尔市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3022,354,'库尔勒市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3023,354,'轮台县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3024,354,'尉犁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3025,354,'若羌县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3026,354,'且末县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3027,354,'焉耆',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3028,354,'和静县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3029,354,'和硕县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3030,354,'博湖县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3031,355,'博乐市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3032,355,'精河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3033,355,'温泉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3034,356,'呼图壁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3035,356,'米泉市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3036,356,'昌吉市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3037,356,'阜康市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3038,356,'玛纳斯县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3039,356,'奇台县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3040,356,'吉木萨尔县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3041,356,'木垒',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3042,357,'哈密市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3043,357,'伊吾县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3044,357,'巴里坤',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3045,358,'和田市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3046,358,'和田县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3047,358,'墨玉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3048,358,'皮山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3049,358,'洛浦县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3050,358,'策勒县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3051,358,'于田县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3052,358,'民丰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3053,359,'喀什市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3054,359,'疏附县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3055,359,'疏勒县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3056,359,'英吉沙县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3057,359,'泽普县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3058,359,'莎车县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3059,359,'叶城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3060,359,'麦盖提县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3061,359,'岳普湖县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3062,359,'伽师县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3063,359,'巴楚县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3064,359,'塔什库尔干',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3065,360,'克拉玛依市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3066,361,'阿图什市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3067,361,'阿克陶县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3068,361,'阿合奇县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3069,361,'乌恰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3070,362,'石河子市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3071,363,'图木舒克市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3072,364,'吐鲁番市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3073,364,'鄯善县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3074,364,'托克逊县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3075,365,'五家渠市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3076,366,'阿勒泰市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3077,366,'布克赛尔',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3078,366,'伊宁市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3079,366,'布尔津县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3080,366,'奎屯市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3081,366,'乌苏市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3082,366,'额敏县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3083,366,'富蕴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3084,366,'伊宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3085,366,'福海县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3086,366,'霍城县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3087,366,'沙湾县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3088,366,'巩留县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3089,366,'哈巴河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3090,366,'托里县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3091,366,'青河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3092,366,'新源县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3093,366,'裕民县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3094,366,'和布克赛尔',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3095,366,'吉木乃县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3096,366,'昭苏县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3097,366,'特克斯县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3098,366,'尼勒克县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3099,366,'察布查尔',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3100,367,'盘龙区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3101,367,'五华区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3102,367,'官渡区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3103,367,'西山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3104,367,'东川区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3105,367,'安宁市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3106,367,'呈贡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3107,367,'晋宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3108,367,'富民县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3109,367,'宜良县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3110,367,'嵩明县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3111,367,'石林县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3112,367,'禄劝',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3113,367,'寻甸',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3114,368,'兰坪',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3115,368,'泸水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3116,368,'福贡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3117,368,'贡山',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3118,369,'宁洱',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3119,369,'思茅区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3120,369,'墨江',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3121,369,'景东',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3122,369,'景谷',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3123,369,'镇沅',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3124,369,'江城',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3125,369,'孟连',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3126,369,'澜沧',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3127,369,'西盟',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3128,370,'古城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3129,370,'宁蒗',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3130,370,'玉龙',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3131,370,'永胜县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3132,370,'华坪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3133,371,'隆阳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3134,371,'施甸县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3135,371,'腾冲县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3136,371,'龙陵县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3137,371,'昌宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3138,372,'楚雄市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3139,372,'双柏县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3140,372,'牟定县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3141,372,'南华县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3142,372,'姚安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3143,372,'大姚县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3144,372,'永仁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3145,372,'元谋县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3146,372,'武定县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3147,372,'禄丰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3148,373,'大理市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3149,373,'祥云县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3150,373,'宾川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3151,373,'弥渡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3152,373,'永平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3153,373,'云龙县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3154,373,'洱源县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3155,373,'剑川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3156,373,'鹤庆县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3157,373,'漾濞',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3158,373,'南涧',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3159,373,'巍山',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3160,374,'潞西市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3161,374,'瑞丽市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3162,374,'梁河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3163,374,'盈江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3164,374,'陇川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3165,375,'香格里拉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3166,375,'德钦县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3167,375,'维西',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3168,376,'泸西县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3169,376,'蒙自县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3170,376,'个旧市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3171,376,'开远市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3172,376,'绿春县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3173,376,'建水县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3174,376,'石屏县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3175,376,'弥勒县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3176,376,'元阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3177,376,'红河县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3178,376,'金平',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3179,376,'河口',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3180,376,'屏边',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3181,377,'临翔区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3182,377,'凤庆县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3183,377,'云县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3184,377,'永德县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3185,377,'镇康县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3186,377,'双江',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3187,377,'耿马',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3188,377,'沧源',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3189,378,'麒麟区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3190,378,'宣威市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3191,378,'马龙县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3192,378,'陆良县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3193,378,'师宗县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3194,378,'罗平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3195,378,'富源县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3196,378,'会泽县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3197,378,'沾益县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3198,379,'文山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3199,379,'砚山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3200,379,'西畴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3201,379,'麻栗坡县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3202,379,'马关县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3203,379,'丘北县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3204,379,'广南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3205,379,'富宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3206,380,'景洪市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3207,380,'勐海县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3208,380,'勐腊县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3209,381,'红塔区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3210,381,'江川县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3211,381,'澄江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3212,381,'通海县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3213,381,'华宁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3214,381,'易门县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3215,381,'峨山',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3216,381,'新平',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3217,381,'元江',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3218,382,'昭阳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3219,382,'鲁甸县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3220,382,'巧家县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3221,382,'盐津县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3222,382,'大关县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3223,382,'永善县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3224,382,'绥江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3225,382,'镇雄县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3226,382,'彝良县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3227,382,'威信县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3228,382,'水富县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3229,383,'西湖区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3230,383,'上城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3231,383,'下城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3232,383,'拱墅区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3233,383,'滨江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3234,383,'江干区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3235,383,'萧山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3236,383,'余杭区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3237,383,'市郊',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3238,383,'建德市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3239,383,'富阳市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3240,383,'临安市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3241,383,'桐庐县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3242,383,'淳安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3243,384,'吴兴区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3244,384,'南浔区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3245,384,'德清县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3246,384,'长兴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3247,384,'安吉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3248,385,'南湖区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3249,385,'秀洲区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3250,385,'海宁市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3251,385,'嘉善县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3252,385,'平湖市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3253,385,'桐乡市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3254,385,'海盐县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3255,386,'婺城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3256,386,'金东区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3257,386,'兰溪市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3258,386,'市区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3259,386,'佛堂镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3260,386,'上溪镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3261,386,'义亭镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3262,386,'大陈镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3263,386,'苏溪镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3264,386,'赤岸镇',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3265,386,'东阳市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3266,386,'永康市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3267,386,'武义县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3268,386,'浦江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3269,386,'磐安县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3270,387,'莲都区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3271,387,'龙泉市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3272,387,'青田县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3273,387,'缙云县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3274,387,'遂昌县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3275,387,'松阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3276,387,'云和县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3277,387,'庆元县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3278,387,'景宁',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3279,388,'海曙区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3280,388,'江东区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3281,388,'江北区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3282,388,'镇海区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3283,388,'北仑区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3284,388,'鄞州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3285,388,'余姚市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3286,388,'慈溪市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3287,388,'奉化市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3288,388,'象山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3289,388,'宁海县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3290,389,'越城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3291,389,'上虞市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3292,389,'嵊州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3293,389,'绍兴县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3294,389,'新昌县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3295,389,'诸暨市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3296,390,'椒江区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3297,390,'黄岩区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3298,390,'路桥区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3299,390,'温岭市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3300,390,'临海市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3301,390,'玉环县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3302,390,'三门县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3303,390,'天台县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3304,390,'仙居县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3305,391,'鹿城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3306,391,'龙湾区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3307,391,'瓯海区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3308,391,'瑞安市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3309,391,'乐清市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3310,391,'洞头县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3311,391,'永嘉县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3312,391,'平阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3313,391,'苍南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3314,391,'文成县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3315,391,'泰顺县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3316,392,'定海区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3317,392,'普陀区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3318,392,'岱山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3319,392,'嵊泗县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3320,393,'衢州市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3321,393,'江山市',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3322,393,'常山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3323,393,'开化县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3324,393,'龙游县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3325,394,'合川区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3326,394,'江津区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3327,394,'南川区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3328,394,'永川区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3329,394,'南岸区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3330,394,'渝北区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3331,394,'万盛区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3332,394,'大渡口区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3333,394,'万州区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3334,394,'北碚区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3335,394,'沙坪坝区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3336,394,'巴南区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3337,394,'涪陵区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3338,394,'江北区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3339,394,'九龙坡区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3340,394,'渝中区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3341,394,'黔江开发区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3342,394,'长寿区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3343,394,'双桥区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3344,394,'綦江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3345,394,'潼南县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3346,394,'铜梁县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3347,394,'大足县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3348,394,'荣昌县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3349,394,'璧山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3350,394,'垫江县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3351,394,'武隆县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3352,394,'丰都县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3353,394,'城口县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3354,394,'梁平县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3355,394,'开县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3356,394,'巫溪县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3357,394,'巫山县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3358,394,'奉节县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3359,394,'云阳县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3360,394,'忠县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3361,394,'石柱',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3362,394,'彭水',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3363,394,'酉阳',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3364,394,'秀山',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3365,395,'沙田区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3366,395,'东区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3367,395,'观塘区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3368,395,'黄大仙区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3369,395,'九龙城区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3370,395,'屯门区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3371,395,'葵青区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3372,395,'元朗区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3373,395,'深水埗区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3374,395,'西贡区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3375,395,'大埔区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3376,395,'湾仔区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3377,395,'油尖旺区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3378,395,'北区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3379,395,'南区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3380,395,'荃湾区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3381,395,'中西区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3382,395,'离岛区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3383,396,'澳门',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3384,397,'台北',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3385,397,'高雄',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3386,397,'基隆',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3387,397,'台中',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3388,397,'台南',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3389,397,'新竹',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3390,397,'嘉义',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3391,397,'宜兰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3392,397,'桃园县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3393,397,'苗栗县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3394,397,'彰化县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3395,397,'南投县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3396,397,'云林县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3397,397,'屏东县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3398,397,'台东县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3399,397,'花莲县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3400,397,'澎湖县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3401,3,'合肥',2,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3402,3401,'庐阳区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3403,3401,'瑶海区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3404,3401,'蜀山区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3405,3401,'包河区',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3406,3401,'长丰县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3407,3401,'肥东县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3408,3401,'肥西县',3,0,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*Table structure for table `ps_region_shipping` */

DROP TABLE IF EXISTS `ps_region_shipping`;

CREATE TABLE `ps_region_shipping` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `region_id` int(11) NOT NULL COMMENT '地址编号',
  `shipping_id` int(11) NOT NULL COMMENT '快递编号',
  `fee` decimal(10,2) NOT NULL COMMENT '地区快递费用',
  `sort_order` int(11) NOT NULL COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `ps_region_shipping` */

insert  into `ps_region_shipping`(`id`,`region_id`,`shipping_id`,`fee`,`sort_order`,`created_at`,`updated_at`) values 
(1,2,1,12.00,0,'2016-09-30 14:47:57','2016-09-30 14:54:04'),
(2,7,1,120.00,0,'2016-09-30 14:52:18','2016-09-30 16:05:41'),
(3,12,1,34.00,0,'2016-09-30 14:52:28','2016-09-30 16:05:29'),
(5,2,4,123.00,0,'2016-09-30 14:56:47','2016-09-30 16:07:33');

/*Table structure for table `ps_return` */

DROP TABLE IF EXISTS `ps_return`;

CREATE TABLE `ps_return` (
  `id` int(10) NOT NULL COMMENT '主键编号',
  `order_sn` varchar(255) NOT NULL COMMENT '订单号',
  `type` int(10) NOT NULL COMMENT '类型：退货 换货还是维修',
  `goods_id` int(10) NOT NULL COMMENT '商品编号',
  `content` text NOT NULL COMMENT '相关说明备注',
  `price` decimal(10,2) NOT NULL COMMENT '退换货金额',
  `user_id` int(10) NOT NULL COMMENT '会员编号',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='返修或者退货或者换货表';

/*Data for the table `ps_return` */

/*Table structure for table `ps_role` */

DROP TABLE IF EXISTS `ps_role`;

CREATE TABLE `ps_role` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  `sort_order` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `ps_role` */

insert  into `ps_role`(`id`,`role_name`,`sort_order`,`created_at`,`updated_at`) values 
(7,'总管理员',0,'2015-05-19 16:28:15','2015-05-19 16:28:15'),
(10,'测试管理员',0,'2016-01-30 14:36:30','2016-01-30 14:36:30'),
(11,'商品管理员',0,'2016-02-18 03:38:35','2016-02-18 03:38:35');

/*Table structure for table `ps_role_privi` */

DROP TABLE IF EXISTS `ps_role_privi`;

CREATE TABLE `ps_role_privi` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `role_id` int(10) NOT NULL,
  `privi_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19614 DEFAULT CHARSET=utf8;

/*Data for the table `ps_role_privi` */

insert  into `ps_role_privi`(`id`,`role_id`,`privi_id`,`created_at`,`updated_at`) values 
(7673,10,1,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7674,10,25,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7675,10,26,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7676,10,27,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7677,10,28,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7678,10,29,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7679,10,30,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7680,10,31,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7681,10,32,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7682,10,33,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7683,10,34,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7684,10,35,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7685,10,36,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7686,10,37,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7687,10,38,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7688,10,39,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7689,10,40,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7690,10,41,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7691,10,42,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7692,10,43,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7693,10,44,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7694,10,45,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7695,10,50,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7696,10,51,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7697,10,52,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7698,10,53,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7699,10,54,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7700,10,55,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7701,10,56,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7702,10,57,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7703,10,58,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7704,10,59,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7705,10,60,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7706,10,61,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7707,10,62,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7708,10,63,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7709,10,64,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7710,10,65,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7711,10,66,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7712,10,67,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7713,10,68,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7714,10,69,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7715,10,70,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7716,10,71,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7717,10,72,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7718,10,73,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7719,10,74,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7720,10,75,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7721,10,76,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7722,10,77,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7723,10,78,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7724,10,79,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7725,10,80,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7726,10,81,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7727,10,82,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7728,10,83,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7729,10,84,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7730,10,85,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7731,10,86,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7732,10,87,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7733,10,88,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7734,10,89,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7735,10,90,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7736,10,91,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7737,10,92,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7738,10,93,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7739,10,94,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7740,10,95,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7741,10,96,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7742,10,97,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7743,10,98,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7744,10,99,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7745,10,100,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7746,10,101,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7747,10,102,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7748,10,103,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7749,10,104,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7750,10,105,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7751,10,106,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7752,10,107,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7753,10,108,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7754,10,109,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7755,10,110,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7756,10,111,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7757,10,112,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7758,10,113,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7759,10,114,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7760,10,115,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7761,10,116,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7762,10,117,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7763,10,118,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7764,10,119,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7765,10,120,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7766,10,121,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7767,10,131,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7768,10,132,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7769,10,133,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7770,10,134,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7771,10,135,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7772,10,136,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7773,10,137,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7774,10,138,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7775,10,139,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7776,10,140,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7777,10,141,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7778,10,142,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7779,10,143,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7780,10,144,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7781,10,145,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7782,10,146,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7783,10,147,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7784,10,148,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7785,10,149,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7786,10,150,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7787,10,151,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7788,10,152,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7789,10,153,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7790,10,154,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7791,10,155,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7792,10,156,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7793,10,157,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7794,10,158,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7795,10,168,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7796,10,169,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7797,10,170,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7798,10,171,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7799,10,172,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7800,10,173,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7801,10,174,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7802,10,175,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7803,10,176,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7804,10,177,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7805,10,178,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7806,10,179,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7807,10,180,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7808,10,181,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7809,10,182,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7810,10,183,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7811,10,184,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7812,10,185,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7813,10,186,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7814,10,187,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7815,10,188,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7816,10,189,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7817,10,190,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7818,10,191,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7819,10,192,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7820,10,193,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7821,10,194,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7822,10,195,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7823,10,196,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7824,10,197,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7825,10,198,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7826,10,199,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7827,10,159,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7828,10,160,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7829,10,161,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7830,10,162,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7831,10,163,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7832,10,164,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7833,10,165,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7834,10,166,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(7835,10,167,'2016-01-30 16:44:49','2016-01-30 16:44:49'),
(8234,11,1,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8235,11,25,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8236,11,26,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8237,11,27,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8238,11,28,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8239,11,67,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8240,11,68,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8241,11,69,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8242,11,70,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8243,11,71,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8244,11,72,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8245,11,73,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8246,11,74,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8247,11,75,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8248,11,76,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8249,11,77,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8250,11,78,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8251,11,79,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8252,11,80,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8253,11,81,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8254,11,82,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8255,11,83,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8256,11,84,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8257,11,85,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8258,11,86,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8259,11,87,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8260,11,88,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8261,11,89,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8262,11,90,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8263,11,91,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8264,11,92,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8265,11,93,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8266,11,94,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8267,11,95,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8268,11,96,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8269,11,97,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8270,11,98,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8271,11,99,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8272,11,100,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8273,11,101,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8274,11,102,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8275,11,103,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8276,11,104,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8277,11,105,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8278,11,106,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8279,11,107,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8280,11,108,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8281,11,109,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8282,11,110,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8283,11,111,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8284,11,112,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8285,11,113,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8286,11,114,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8287,11,115,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8288,11,116,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8289,11,117,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8290,11,118,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8291,11,119,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8292,11,120,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(8293,11,121,'2016-02-18 03:38:35','2016-02-18 03:38:35'),
(19299,7,1,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19300,7,2,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19301,7,3,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19302,7,4,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19303,7,5,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19304,7,6,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19305,7,7,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19306,7,9,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19307,7,10,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19308,7,11,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19309,7,12,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19310,7,13,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19311,7,14,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19312,7,15,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19313,7,16,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19314,7,17,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19315,7,18,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19316,7,19,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19317,7,20,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19318,7,21,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19319,7,22,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19320,7,23,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19321,7,24,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19322,7,25,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19323,7,26,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19324,7,46,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19325,7,47,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19326,7,48,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19327,7,49,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19328,7,200,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19329,7,201,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19330,7,202,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19331,7,27,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19332,7,28,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19333,7,29,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19334,7,30,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19335,7,31,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19336,7,32,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19337,7,33,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19338,7,34,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19339,7,35,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19340,7,36,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19341,7,37,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19342,7,38,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19343,7,39,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19344,7,40,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19345,7,41,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19346,7,42,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19347,7,43,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19348,7,44,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19349,7,45,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19350,7,50,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19351,7,51,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19352,7,52,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19353,7,53,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19354,7,54,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19355,7,55,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19356,7,56,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19357,7,57,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19358,7,58,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19359,7,59,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19360,7,60,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19361,7,61,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19362,7,62,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19363,7,63,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19364,7,64,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19365,7,65,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19366,7,66,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19367,7,203,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19368,7,204,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19369,7,205,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19370,7,206,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19371,7,207,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19372,7,208,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19373,7,209,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19374,7,210,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19375,7,278,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19376,7,279,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19377,7,280,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19378,7,281,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19379,7,282,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19380,7,283,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19381,7,284,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19382,7,285,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19383,7,286,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19384,7,287,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19385,7,288,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19386,7,289,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19387,7,290,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19388,7,291,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19389,7,292,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19390,7,293,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19391,7,67,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19392,7,68,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19393,7,69,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19394,7,70,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19395,7,71,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19396,7,72,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19397,7,73,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19398,7,74,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19399,7,75,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19400,7,76,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19401,7,77,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19402,7,78,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19403,7,79,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19404,7,80,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19405,7,81,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19406,7,82,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19407,7,83,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19408,7,84,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19409,7,85,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19410,7,86,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19411,7,87,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19412,7,88,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19413,7,89,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19414,7,90,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19415,7,91,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19416,7,92,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19417,7,93,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19418,7,94,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19419,7,95,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19420,7,96,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19421,7,97,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19422,7,98,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19423,7,99,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19424,7,100,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19425,7,101,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19426,7,102,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19427,7,103,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19428,7,104,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19429,7,105,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19430,7,106,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19431,7,107,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19432,7,108,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19433,7,109,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19434,7,110,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19435,7,111,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19436,7,112,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19437,7,113,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19438,7,114,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19439,7,115,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19440,7,116,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19441,7,117,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19442,7,118,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19443,7,119,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19444,7,120,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19445,7,121,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19446,7,214,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19447,7,215,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19448,7,216,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19449,7,217,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19450,7,218,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19451,7,219,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19452,7,220,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19453,7,221,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19454,7,222,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19455,7,223,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19456,7,224,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19457,7,225,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19458,7,226,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19459,7,227,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19460,7,228,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19461,7,229,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19462,7,230,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19463,7,231,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19464,7,232,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19465,7,233,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19466,7,234,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19467,7,235,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19468,7,236,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19469,7,237,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19470,7,270,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19471,7,271,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19472,7,272,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19473,7,273,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19474,7,274,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19475,7,275,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19476,7,276,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19477,7,277,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19478,7,303,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19479,7,304,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19480,7,305,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19481,7,306,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19482,7,307,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19483,7,308,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19484,7,309,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19485,7,310,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19486,7,327,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19487,7,345,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19488,7,350,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19489,7,122,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19490,7,125,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19491,7,126,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19492,7,127,'2018-03-07 13:01:51','2018-03-07 13:01:51'),
(19493,7,128,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19494,7,129,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19495,7,130,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19496,7,131,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19497,7,132,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19498,7,133,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19499,7,134,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19500,7,135,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19501,7,136,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19502,7,137,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19503,7,138,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19504,7,139,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19505,7,140,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19506,7,141,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19507,7,142,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19508,7,143,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19509,7,144,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19510,7,145,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19511,7,146,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19512,7,147,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19513,7,148,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19514,7,149,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19515,7,150,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19516,7,151,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19517,7,152,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19518,7,153,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19519,7,154,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19520,7,155,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19521,7,156,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19522,7,157,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19523,7,158,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19524,7,168,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19525,7,169,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19526,7,170,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19527,7,171,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19528,7,172,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19529,7,173,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19530,7,174,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19531,7,175,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19532,7,176,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19533,7,177,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19534,7,178,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19535,7,179,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19536,7,180,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19537,7,181,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19538,7,182,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19539,7,183,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19540,7,184,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19541,7,185,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19542,7,186,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19543,7,187,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19544,7,188,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19545,7,189,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19546,7,190,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19547,7,191,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19548,7,192,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19549,7,193,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19550,7,194,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19551,7,195,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19552,7,196,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19553,7,197,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19554,7,198,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19555,7,199,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19556,7,159,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19557,7,160,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19558,7,161,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19559,7,162,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19560,7,163,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19561,7,164,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19562,7,165,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19563,7,166,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19564,7,167,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19565,7,238,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19566,7,239,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19567,7,240,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19568,7,241,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19569,7,242,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19570,7,243,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19571,7,244,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19572,7,245,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19573,7,246,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19574,7,247,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19575,7,248,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19576,7,249,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19577,7,250,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19578,7,251,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19579,7,252,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19580,7,253,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19581,7,254,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19582,7,255,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19583,7,256,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19584,7,257,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19585,7,258,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19586,7,259,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19587,7,260,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19588,7,261,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19589,7,262,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19590,7,263,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19591,7,264,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19592,7,265,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19593,7,266,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19594,7,267,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19595,7,268,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19596,7,269,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19597,7,294,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19598,7,295,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19599,7,296,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19600,7,297,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19601,7,298,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19602,7,299,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19603,7,300,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19604,7,301,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19605,7,328,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19606,7,329,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19607,7,330,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19608,7,331,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19609,7,332,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19610,7,333,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19611,7,334,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19612,7,335,'2018-03-07 13:01:52','2018-03-07 13:01:52'),
(19613,7,336,'2018-03-07 13:01:52','2018-03-07 13:01:52');

/*Table structure for table `ps_sessions` */

DROP TABLE IF EXISTS `ps_sessions`;

CREATE TABLE `ps_sessions` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` text COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `ps_sessions` */

insert  into `ps_sessions`(`id`,`payload`,`last_activity`) values 
('125b38b77687118a3ef01dc69e7656088ae32e40','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiblpDY0RCakVWTkdyZ1lQTk53WWNObUNSbjJKRzkxczZWQjhoUVhReCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9sb2NhbGhvc3QvY3cxMDAvcHVibGljL2NhdGVnb3J5LzMiO31zOjU6ImZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NDQ6ImxvZ2luX2FkbWluX2E2NGEwYTc3MTczNmIwOGJlMjdhOTY0YTUxMjc5MjFhIjtpOjY7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfc2YyX21ldGEiO2E6Mzp7czoxOiJ1IjtpOjE0NTYyODA5MzY7czoxOiJjIjtpOjE0NTYyODA4NDQ7czoxOiJsIjtzOjE6IjAiO319',1456280937);

/*Table structure for table `ps_shipping` */

DROP TABLE IF EXISTS `ps_shipping`;

CREATE TABLE `ps_shipping` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `shipping_code` varchar(20) NOT NULL DEFAULT '',
  `shipping_name` varchar(120) NOT NULL DEFAULT '',
  `shipping_desc` varchar(255) NOT NULL DEFAULT '',
  `insure` varchar(10) NOT NULL DEFAULT '0',
  `fee` decimal(10,2) NOT NULL,
  `sort_order` int(10) NOT NULL,
  `tag` int(10) NOT NULL,
  `free_total` decimal(10,2) NOT NULL COMMENT '商品满多少 减免运费',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `shipping_code` (`shipping_code`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `ps_shipping` */

insert  into `ps_shipping`(`id`,`shipping_code`,`shipping_name`,`shipping_desc`,`insure`,`fee`,`sort_order`,`tag`,`free_total`,`created_at`,`updated_at`) values 
(1,'sf_express','顺丰速运','江、浙、沪地区首重15元/KG，续重2元/KG，其余城市首重20元/KG','0',20.00,0,1,100000.00,'2016-10-01 00:05:08','2016-09-30 16:05:08'),
(2,'cac','上门取货','买家自己到商家指定地点取货','0',0.00,1,0,0.00,'2016-01-28 23:27:31','0000-00-00 00:00:00'),
(3,'city_express','城际快递','配送的运费是固定的','0',0.00,0,0,0.00,'2016-01-28 22:26:34','0000-00-00 00:00:00'),
(4,'ems','EMS 国内邮政特快专递','EMS 国内邮政特快专递描述内容','0',32.00,0,1,0.00,'2016-09-30 10:42:39','2016-09-30 02:42:39'),
(5,'flat','市内快递','固定运费的配送方式内容','0',0.00,0,0,0.00,'2016-01-28 22:26:34','0000-00-00 00:00:00'),
(6,'fpd','运费到付','所购商品到达即付运费','0',0.00,0,0,0.00,'2016-01-28 22:26:34','0000-00-00 00:00:00'),
(7,'post_express','邮政快递包裹','邮政快递包裹的描述内容。','1%',0.00,0,0,0.00,'2016-01-28 22:26:34','0000-00-00 00:00:00'),
(8,'post_mail','邮局平邮','邮局平邮的描述内容。','0',0.00,0,0,0.00,'2016-01-28 22:26:34','0000-00-00 00:00:00'),
(9,'presswork','邮政挂号印刷品','邮政挂号印刷品的描述内容。','1%',23.00,0,0,0.00,'2016-09-30 10:42:15','2016-09-30 02:42:15');

/*Table structure for table `ps_shop_collect` */

DROP TABLE IF EXISTS `ps_shop_collect`;

CREATE TABLE `ps_shop_collect` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `shop_id` int(10) NOT NULL COMMENT '店铺编号',
  `user_id` int(10) NOT NULL COMMENT '用户编号',
  `add_time` int(10) NOT NULL COMMENT '收藏时间戳',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ps_shop_collect` */

/*Table structure for table `ps_slider` */

DROP TABLE IF EXISTS `ps_slider`;

CREATE TABLE `ps_slider` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `img_name` varchar(255) NOT NULL,
  `img_src` varchar(255) NOT NULL,
  `img_url` varchar(255) NOT NULL,
  `sort_order` int(10) NOT NULL,
  `img_desc` varchar(255) NOT NULL COMMENT '幻灯片描述',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='幻灯图片表';

/*Data for the table `ps_slider` */

insert  into `ps_slider`(`id`,`img_name`,`img_src`,`img_url`,`sort_order`,`img_desc`,`created_at`,`updated_at`) values 
(7,'LaraStore商城系统','images/common/201611/201611130211131479003076_7CAL004ORS.png','http://www.phpstore.cn',0,'LaraStore','2017-03-09 10:20:21','2017-03-09 02:20:21'),
(11,'全网首款','images/common/201611/201611130207131479002877_YH6AOBd52t.png','http://www.phpstore.cn',1,'','2017-03-09 10:20:10','2017-03-09 02:20:10');

/*Table structure for table `ps_sms` */

DROP TABLE IF EXISTS `ps_sms`;

CREATE TABLE `ps_sms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  `admin_id` int(11) NOT NULL COMMENT '管理员编号',
  `sms_content` varchar(255) NOT NULL COMMENT '短消息',
  `reply_content` text NOT NULL COMMENT '管理员回复',
  `user_status` int(11) NOT NULL COMMENT '用户是否查看',
  `admin_status` int(11) NOT NULL COMMENT '管理员状态',
  `post_time` int(11) NOT NULL COMMENT '时间戳',
  `reply_time` int(10) NOT NULL COMMENT '回复时间',
  `ip` varchar(255) NOT NULL COMMENT 'ip地址',
  `sort_order` int(11) NOT NULL COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

/*Data for the table `ps_sms` */

insert  into `ps_sms`(`id`,`user_id`,`admin_id`,`sms_content`,`reply_content`,`user_status`,`admin_status`,`post_time`,`reply_time`,`ip`,`sort_order`,`created_at`,`updated_at`) values 
(1,19,6,'感觉下 还不错','',0,0,1458830406,0,'::1',0,'2016-03-24 14:40:06','2016-03-24 14:40:06'),
(2,19,25,'感觉感觉下','',0,0,1458830475,0,'::1',0,'2016-03-24 14:41:15','2016-03-24 14:41:15'),
(3,23,25,'IphoneSE发布了 还不错','',0,0,1458831376,0,'::1',0,'2016-03-24 14:56:16','2016-03-24 14:56:16'),
(4,19,25,'感觉感觉感觉','',1,1,1458834552,0,'::1',0,'2016-03-24 15:49:12','2016-03-24 15:49:18'),
(5,19,6,'感觉有多少','',0,0,1458912389,0,'::1',0,'2016-03-25 13:26:30','2016-03-25 13:26:30'),
(6,19,6,'短消息','',0,0,1459273419,0,'::1',0,'2016-03-29 17:43:40','2016-03-29 17:43:40'),
(9,28,26,'谢谢您','不用客气',0,0,1460020998,1460021168,'::1',0,'2016-04-07 09:23:18','2016-04-07 09:26:08'),
(10,28,0,'什么时候发布？','',0,0,1460021730,0,'::1',0,'2016-04-07 09:35:30','2016-04-07 09:35:30'),
(11,28,0,'什么情况啊？','',0,0,1460021739,0,'::1',0,'2016-04-07 09:35:39','2016-04-07 09:35:39'),
(12,28,6,'谢谢大家的支持','请关照官网 即可',0,0,1460021746,1460021806,'::1',0,'2016-04-07 09:35:46','2016-04-07 09:36:46'),
(13,28,6,'phpstore啥时候更新啊？','每个月月底更新',0,0,1460022161,1460022186,'::1',0,'2016-04-07 09:42:41','2016-04-07 09:43:06'),
(14,28,0,'感觉很不错啊 这个界面','',0,0,1460022274,0,'::1',0,'2016-04-07 09:44:34','2016-04-07 09:44:34'),
(36,26,0,'咨询下 app啥时候发布','',0,0,1468095966,0,'192.168.1.3',0,'2016-07-09 20:26:06','2016-07-09 20:26:06'),
(37,26,0,'111','',0,0,1478364766,0,'::1',0,'2016-11-05 16:52:46','2016-11-05 16:52:46');

/*Table structure for table `ps_style` */

DROP TABLE IF EXISTS `ps_style`;

CREATE TABLE `ps_style` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `style_name` varchar(255) NOT NULL COMMENT '配色名称',
  `style_value` varchar(255) NOT NULL COMMENT '颜色16进制值',
  `sort_order` varchar(255) NOT NULL COMMENT '排序',
  `style_css_file` varchar(255) NOT NULL COMMENT '配色css文件',
  `is_checked` int(10) NOT NULL COMMENT '是否被选中',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `ps_style` */

insert  into `ps_style`(`id`,`style_name`,`style_value`,`sort_order`,`style_css_file`,`is_checked`,`created_at`,`updated_at`) values 
(1,'蓝色','#2196f3','0','blue.css',0,'2016-04-09 16:22:41','2016-04-09 17:36:29'),
(2,'青色','#a0ce4e','0','qin.css',0,'2016-04-09 16:38:38','2016-04-09 16:38:38'),
(3,'粉红色','#f73679','0','pink.css',0,'2016-04-09 16:39:49','2016-04-09 16:41:13'),
(4,'橙色','#f9b83e','0','org.css',0,'2016-04-09 16:40:27','2016-04-09 16:40:53'),
(5,'驼色','#baad7c','0','camel.css',0,'2016-04-09 16:42:15','2016-04-09 16:42:38'),
(6,'紫色','#8b4da5','0','purple.css',0,'2016-04-09 16:43:28','2016-04-09 16:44:11'),
(7,'浅紫色','#818edb','0','purple2.css',0,'2016-04-09 16:47:28','2016-04-09 16:47:28'),
(8,'蓝绿色','#23d1b7','0','bluegreen.css',0,'2016-04-09 16:49:42','2016-04-09 16:49:42'),
(9,'深蓝色','#2e7d32','0','deepgreen.css',0,'2016-04-09 16:50:24','2016-04-09 16:50:24'),
(10,'正红色','#d50000','0','red.css',0,'2016-04-09 16:50:52','2016-04-09 16:50:52'),
(11,'天鹅兰','#00bcd4','0','blue2.css',0,'2016-04-09 16:51:36','2016-07-10 09:37:46'),
(12,'灰黑色','#455a64','0','gray.css',0,'2016-04-09 16:52:16','2016-07-10 09:37:51');

/*Table structure for table `ps_supplier` */

DROP TABLE IF EXISTS `ps_supplier`;

CREATE TABLE `ps_supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `tag` int(10) NOT NULL COMMENT '审核状态',
  `add_time` int(10) NOT NULL COMMENT '注册时间',
  `reg_from` varchar(255) NOT NULL COMMENT '注册来源',
  `ip` varchar(255) NOT NULL COMMENT '注册ip地址',
  `sort_order` int(10) NOT NULL COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='供货商表';

/*Data for the table `ps_supplier` */

insert  into `ps_supplier`(`id`,`username`,`password`,`remember_token`,`email`,`phone`,`tag`,`add_time`,`reg_from`,`ip`,`sort_order`,`created_at`,`updated_at`) values 
(1,'sunweihua','$2y$10$Wci5FjxENyeh11XAKVr4z.zrGWCZzUQFOpoyq2hulWCBXmVFIPAIy','jHKh6OnQojHF3gTu59BgYFmZueMtD4LlVJQjBYPv0bh6KbrFHqPSNawDDCJj','bluetooth_swh@163.com','13810597838',0,1483067968,'pc版本','::1',0,'2016-12-30 11:53:52','2016-12-30 03:53:52'),
(2,'guotao','$2y$10$tLiRahMnbGznuPTt5IjMZ.CyTS0qgLu.YKTrqIDHurryv2UFc3uiC','','guotao1980@163.com','17701228800',0,1483069918,'pc版本','::1',0,'2016-12-30 03:51:58','2016-12-30 03:51:58');

/*Table structure for table `ps_sys_config` */

DROP TABLE IF EXISTS `ps_sys_config`;

CREATE TABLE `ps_sys_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父节点id，取值于该表id字段的值',
  `code` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '跟变量名的作用差不多，其实就是语言包中的字符串索引，如$_LANG[cfg_range][cart_confirm]',
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '该配置的类型，text，文本输入框；password，密码输入框；textarea，文本区域；select，单选；options，循环生成多选；file,文件上传；manual，手动生成多选；group，是标题分组;hidden，不在页面显示',
  `store_range` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '当语言包中的code字段对应的是一个数组时，那该处就是该数组的索引，如$_LANG[cfg_range][cart_confirm][1]；只有type字段为select,options时才有值',
  `store_dir` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '当type为file时才有值，文件上传后的保存目录',
  `value` text COLLATE utf8_unicode_ci COMMENT '该项配置的值',
  `sort_order` tinyint(4) DEFAULT '0' COMMENT '显示顺序',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `ps_sys_config` */

insert  into `ps_sys_config`(`id`,`parent_id`,`code`,`type`,`store_range`,`store_dir`,`value`,`sort_order`,`created_at`,`updated_at`) values 
(1,0,'shop_name','',NULL,NULL,'老酒易购品牌商城',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2,0,'shop_title','',NULL,NULL,'老酒易购品牌商城',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3,0,'shop_logo','',NULL,NULL,'images/config/201703/6076f578f79980ae2bedebe64b38a3b1.png',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(4,0,'shop_desc','',NULL,NULL,'老酒易购品牌商城',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(5,0,'shop_keywords','',NULL,NULL,'老酒易购品牌商城',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(6,0,'shop_address','',NULL,NULL,'深圳市程序源科技有限公司',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(7,0,'qq','',NULL,NULL,'383565309',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(8,0,'weixin','',NULL,NULL,'383565309',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(9,0,'tel','',NULL,NULL,'QQ383565309',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(10,0,'shop_closed','',NULL,NULL,'0',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(11,0,'shop_closed_note','',NULL,NULL,'暂时不关闭',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(12,0,'register_closed','',NULL,NULL,'0',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(13,0,'shop_notices','',NULL,NULL,'这里是网店的公告',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(14,0,'user_notices','',NULL,NULL,'这里是用户中心的公告',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(15,0,'lang','',NULL,NULL,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(16,0,'icp','',NULL,NULL,'京ICP备12016271号-2',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(17,0,'market_price_rate','',NULL,NULL,'1:2',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(18,0,'stats_code','',NULL,NULL,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(19,0,'goods_default_img','',NULL,NULL,'images/config/201610/56bbb18d0db0a0c5dc3ee3670ad12c98.png',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(20,0,'search_keywords','',NULL,NULL,'phpstore laravel5.1 在线搜索',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(21,0,'thumb_width','',NULL,NULL,'253',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(22,0,'thumb_height','',NULL,NULL,'253',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(23,0,'img_width','',NULL,NULL,'527',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(24,0,'img_height','',NULL,NULL,'527',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(25,0,'list_page_size','',NULL,NULL,'6',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(26,0,'admin_url','',NULL,NULL,'http://test.phpstore.cn',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(27,0,'wap_opened','',NULL,NULL,'0',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(28,0,'wap_logo','',NULL,NULL,'images/config/201601/7b876449b34861a4172cf2531856e184.png',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(29,0,'watermark','',NULL,NULL,'images/config/201601/e03ff09b980116baae68d6047f755951.png',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(30,0,'email','',NULL,NULL,'383565309@qq.com',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(31,0,'help_1','',NULL,NULL,'1',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(32,0,'help_2','',NULL,NULL,'3',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(33,0,'help_3','',NULL,NULL,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(34,0,'help_4','',NULL,NULL,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(35,0,'help_5','',NULL,NULL,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(36,0,'weixin_appid','',NULL,NULL,'wx24a42af762d23a6b',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(37,0,'weixin_secret','',NULL,NULL,'fd01093a25a0430d88fa1da79e883d89',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(38,0,'weixin_callback_url','',NULL,NULL,'http://www.phpstore.cn/weixin/callback',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(39,0,'weixin_scope','',NULL,NULL,'snsapi_userinfo',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(40,0,'weixin_aeskey','',NULL,NULL,'1DycB2YkS9nizymt58FYiCBJq6xYLHrAkmdujqIgcm8',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(41,0,'domain','',NULL,NULL,'localhost',0,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*Table structure for table `ps_tag` */

DROP TABLE IF EXISTS `ps_tag`;

CREATE TABLE `ps_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(255) NOT NULL COMMENT '标签名称',
  `goods_id` int(10) NOT NULL COMMENT '商品编号',
  `username` varchar(255) NOT NULL COMMENT '用户名称',
  `add_time` int(11) NOT NULL COMMENT '操作时间',
  `ip` varchar(255) NOT NULL COMMENT '添加标签ip地址',
  `sort_order` int(10) NOT NULL COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `ps_tag` */

insert  into `ps_tag`(`id`,`tag_name`,`goods_id`,`username`,`add_time`,`ip`,`sort_order`,`created_at`,`updated_at`) values 
(7,'1233',2,'sunweihua',0,'',0,'2016-12-23 15:24:29','2016-12-23 15:24:29'),
(8,'红色',2,'sunweihua',0,'',0,'2016-12-29 05:38:12','2016-12-29 05:38:12');

/*Table structure for table `ps_template_config` */

DROP TABLE IF EXISTS `ps_template_config`;

CREATE TABLE `ps_template_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '配置代码',
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '配置代码的值',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '类型',
  `add_time` int(11) NOT NULL COMMENT '添加的时间',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `template_config_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `ps_template_config` */

insert  into `ps_template_config`(`id`,`code`,`value`,`type`,`add_time`,`created_at`,`updated_at`) values 
(1,'tp_name','','',1478603999,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(2,'tp_thumb','images/config/201602/471fd9f1851d7c38b3511adb32fbbda8.png','',0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(3,'new_goods_number','8','',1478603999,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(4,'hot_goods_number','8','',1478603999,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(5,'best_goods_number','8','',1478603999,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(6,'promote_goods_number','8','',1478603999,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(7,'cat_goods_number','8','',1478603999,'0000-00-00 00:00:00','0000-00-00 00:00:00'),
(8,'footer_desc','phpstore simple版本为phpstore-b2c极速版本。去繁化简，专注于购物本身的功能实现。提供高效/安全/快捷的购物体验。基于Laravel5.1(LTS)版，可以非常方便的做二次开发和功能扩展。\r\n','',1478603999,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*Table structure for table `ps_tests` */

DROP TABLE IF EXISTS `ps_tests`;

CREATE TABLE `ps_tests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名称',
  `price` decimal(10,2) NOT NULL COMMENT '价格',
  `tag` int(11) NOT NULL COMMENT '标签',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*Data for the table `ps_tests` */

insert  into `ps_tests`(`id`,`name`,`price`,`tag`,`created_at`,`updated_at`) values 
(1,'ywilkinson',3.00,1,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(2,'sveum',4.00,1,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(3,'moen.danyka',6.00,1,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(4,'yost.ola',6.00,1,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(5,'fborer',10.00,1,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(6,'orn.dana',7.00,0,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(7,'jarvis51',6.00,0,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(8,'monty93',4.00,0,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(9,'nkertzmann',7.00,1,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(10,'brisa56',8.00,0,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(11,'eden25',9.00,0,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(12,'garnett.toy',7.00,0,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(13,'maudie87',3.00,0,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(14,'ghuel',7.00,1,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(15,'peter.nienow',6.00,0,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(16,'gustave.breitenberg',4.00,0,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(17,'davis.harrison',5.00,1,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(18,'trisha.glover',3.00,0,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(19,'seamus83',5.00,1,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(20,'efren37',4.00,0,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(21,'stanton02',8.00,0,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(22,'benedict.schuppe',5.00,1,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(23,'price.destin',10.00,0,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(24,'ibradtke',9.00,0,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(25,'trisha60',8.00,0,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(26,'qboyle',9.00,1,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(27,'schmitt.obie',8.00,0,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(28,'uwolf',8.00,0,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(29,'devan89',4.00,1,'2016-07-13 03:24:00','2016-07-13 03:24:00'),
(30,'margarita.dickinson',3.00,0,'2016-07-13 03:24:00','2016-07-13 03:24:00');

/*Table structure for table `ps_themes` */

DROP TABLE IF EXISTS `ps_themes`;

CREATE TABLE `ps_themes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '模板名称',
  `is_checked` int(11) NOT NULL COMMENT '当前模板',
  `type` varchar(255) NOT NULL COMMENT '模板类型',
  `sort_order` int(11) NOT NULL COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `ps_themes` */

insert  into `ps_themes`(`id`,`name`,`is_checked`,`type`,`sort_order`,`created_at`,`updated_at`) values 
(1,'smartisan',1,'pc',0,'2016-11-08 10:31:11','2017-01-10 08:15:25'),
(2,'matrix',0,'pc',0,'2016-11-08 10:31:18','2017-01-10 08:15:25');

/*Table structure for table `ps_txt_link` */

DROP TABLE IF EXISTS `ps_txt_link`;

CREATE TABLE `ps_txt_link` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `txt_name` varchar(255) NOT NULL,
  `txt_link` varchar(255) NOT NULL,
  `txt_tag` varchar(255) NOT NULL,
  `txt_site` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ps_txt_link` */

/*Table structure for table `ps_user_address` */

DROP TABLE IF EXISTS `ps_user_address`;

CREATE TABLE `ps_user_address` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `address_name` varchar(50) NOT NULL DEFAULT '',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `consignee` varchar(60) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `country` smallint(5) NOT NULL DEFAULT '0',
  `province` smallint(5) NOT NULL DEFAULT '0',
  `city` smallint(5) NOT NULL DEFAULT '0',
  `district` smallint(5) NOT NULL DEFAULT '0',
  `address` varchar(120) NOT NULL DEFAULT '',
  `zipcode` varchar(60) NOT NULL DEFAULT '',
  `tel` varchar(60) NOT NULL DEFAULT '',
  `phone` varchar(60) NOT NULL DEFAULT '',
  `sign_building` varchar(120) NOT NULL DEFAULT '',
  `best_time` varchar(120) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `ps_user_address` */

insert  into `ps_user_address`(`id`,`address_name`,`user_id`,`consignee`,`email`,`country`,`province`,`city`,`district`,`address`,`zipcode`,`tel`,`phone`,`sign_building`,`best_time`,`created_at`,`updated_at`) values 
(3,'',1,'张三丰','',1,3,37,410,'武当山','','','13810597838','','','2016-12-23 01:38:10','2016-12-23 01:38:10'),
(2,'',1,'谢晓明','',1,6,36,416,'广东佛山','','','17701228800','','','2016-12-27 21:35:38','2016-12-27 13:35:38');

/*Table structure for table `ps_user_histroy` */

DROP TABLE IF EXISTS `ps_user_histroy`;

CREATE TABLE `ps_user_histroy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `goods_id` int(10) NOT NULL,
  `login_time` int(10) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='记录用户的历史访问记录';

/*Data for the table `ps_user_histroy` */

/*Table structure for table `ps_user_rank` */

DROP TABLE IF EXISTS `ps_user_rank`;

CREATE TABLE `ps_user_rank` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `rank_name` varchar(30) NOT NULL DEFAULT '',
  `min_points` int(10) unsigned NOT NULL DEFAULT '0',
  `max_points` int(10) unsigned NOT NULL DEFAULT '0',
  `discount` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `show_price` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `special_rank` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `rank_pic` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

/*Data for the table `ps_user_rank` */

insert  into `ps_user_rank`(`id`,`rank_name`,`min_points`,`max_points`,`discount`,`show_price`,`special_rank`,`rank_pic`,`created_at`,`updated_at`) values 
(20,'注册会员',0,1000,100,1,0,'images/common/201610/15dd797d9f9dd3877f40f09063820f55.gif','2016-10-08 11:09:15','2016-10-08 03:09:15'),
(21,'vip会员',1001,5000,90,1,0,'images/common/201610/b4d7defa7a38fa60b89e8989f5b7822f.gif','2016-10-08 11:09:08','2016-10-08 03:09:08'),
(18,'白钻会员',5001,20000,80,1,0,'images/common/201610/d1883dc19383e034046189408323e861.gif','2016-10-08 11:09:30','2016-10-08 03:09:30'),
(19,'皇冠会员',20001,50000,50,0,1,'images/common/201610/b8b8b61d21da542472d969340ef96206.gif','2016-10-08 11:09:23','2016-10-08 03:09:23');

/*Table structure for table `ps_users` */

DROP TABLE IF EXISTS `ps_users`;

CREATE TABLE `ps_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_admin` int(10) NOT NULL,
  `remember_token` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `add_time` int(10) NOT NULL,
  `is_show` int(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_icon` varchar(255) NOT NULL,
  `role_id` int(10) NOT NULL,
  `address_id` int(10) NOT NULL,
  `nickname` varchar(255) NOT NULL COMMENT '昵称',
  `sex` int(10) NOT NULL COMMENT '性别',
  `birthday` varchar(255) NOT NULL COMMENT '生日',
  `sfz` varchar(255) NOT NULL COMMENT '身份证',
  `country` int(10) NOT NULL COMMENT '国家编号',
  `province` int(10) NOT NULL COMMENT '省会编号',
  `city` int(10) NOT NULL COMMENT '城市编号',
  `district` int(10) NOT NULL COMMENT '地区编号',
  `sort_order` int(10) NOT NULL,
  `rank_id` int(10) NOT NULL,
  `login_ip` varchar(255) NOT NULL COMMENT '登录ip',
  `pay_points` int(10) NOT NULL COMMENT '消费积分',
  `rank_points` int(10) NOT NULL COMMENT '等级积分',
  `last_login_time` int(10) NOT NULL COMMENT '上次登录的时间',
  `reg_from` varchar(255) DEFAULT NULL,
  `openid` varchar(255) NOT NULL COMMENT '微信的openid',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `ps_users` */

insert  into `ps_users`(`id`,`username`,`email`,`is_admin`,`remember_token`,`phone`,`ip`,`add_time`,`is_show`,`password`,`user_icon`,`role_id`,`address_id`,`nickname`,`sex`,`birthday`,`sfz`,`country`,`province`,`city`,`district`,`sort_order`,`rank_id`,`login_ip`,`pay_points`,`rank_points`,`last_login_time`,`reg_from`,`openid`,`created_at`,`updated_at`) values 
(1,'sunweihua','17701228800@163.com',0,'9pv65GwKDfuqH6IhZWenbv7gkfj13SYRCEEiD17RlKvZbSF1fSreow61xDsI','17701228800','',1482503655,0,'$2y$10$uxyKAUtmM.avWlsu8N36/uqBYJapQFwcAf6ca1o9GInXNr07vPDvK','images/common/201612/201612231435231482503709_dzT6qAOiaQ.png',0,2,'小佳',0,'1988-2-12','',0,0,0,0,0,0,'::1',0,0,1489040662,'手机短信验证码注册','','2017-03-09 14:24:22','2017-03-09 06:24:22');

/*Table structure for table `ps_users_account` */

DROP TABLE IF EXISTS `ps_users_account`;

CREATE TABLE `ps_users_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL COMMENT '用户名称',
  `amount` decimal(10,2) NOT NULL COMMENT '金额',
  `admin` varchar(255) NOT NULL COMMENT '操作管理员',
  `add_time` int(11) NOT NULL COMMENT '操作时间',
  `ip` varchar(255) NOT NULL COMMENT '申请的ip地址',
  `type` int(11) NOT NULL COMMENT '操作类型',
  `user_note` varchar(255) NOT NULL COMMENT '用户备注',
  `admin_note` varchar(255) NOT NULL COMMENT '管理员备注',
  `payment` varchar(255) NOT NULL COMMENT '支付方式',
  `pay_tag` int(11) NOT NULL COMMENT '是否支付',
  `sort_order` int(11) NOT NULL COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `ps_users_account` */

insert  into `ps_users_account`(`id`,`username`,`amount`,`admin`,`add_time`,`ip`,`type`,`user_note`,`admin_note`,`payment`,`pay_tag`,`sort_order`,`created_at`,`updated_at`) values 
(1,'sunweihua',123.00,'',1482847077,'::1',0,'通过支付宝充值','','支付宝',1,0,'2016-12-27 13:57:57','2016-12-28 03:29:02'),
(2,'sunweihua',2000.00,'',1482894872,'::1',0,'12222','','支付宝',1,0,'2016-12-28 03:14:32','2016-12-28 03:28:57'),
(3,'sunweihua',100.00,'',1482896993,'::1',1,'申请提现','','支付宝',1,0,'2016-12-28 03:49:53','2016-12-28 03:50:22'),
(4,'sunweihua',100.00,'',1482900236,'::1',0,'iiiii','','支付宝',0,0,'2016-12-28 04:43:56','2016-12-28 04:43:56'),
(5,'sunweihua',45.00,'',1487642303,'::1',1,'余额用于支付订单金额，订单号：2017022071816','','余额支付',1,0,'2017-02-21 01:58:23','2017-02-21 01:58:23'),
(6,'sunweihua',41.00,'',1487645583,'::1',1,'余额用于支付订单金额，订单号：2017022058829','','余额支付',1,0,'2017-02-21 02:53:03','2017-02-21 02:53:03'),
(7,'sunweihua',1220.00,'',1487645637,'::1',1,'余额用于支付订单金额，订单号：2017022104377','','余额支付',1,0,'2017-02-21 02:53:57','2017-02-21 02:53:57'),
(8,'sunweihua',45.00,'',1487728741,'::1',1,'余额用于支付订单金额，订单号：2017022276379','','余额支付',1,0,'2017-02-22 01:59:01','2017-02-22 01:59:01'),
(9,'sunweihua',2000.00,'admin',1487759496,'::1',0,'充值2000','无','支付宝',1,0,'2017-02-22 10:31:36','2017-02-22 10:31:36'),
(10,'sunweihua',772.00,'',1487759549,'::1',1,'余额用于支付订单金额，订单号：2017022218812','','余额支付',1,0,'2017-02-22 10:32:29','2017-02-22 10:32:29'),
(11,'sunweihua',86.00,'',1487899771,'::1',1,'余额用于支付订单金额，订单号：2017022472577','','余额支付',1,0,'2017-02-24 01:29:31','2017-02-24 01:29:31'),
(12,'sunweihua',385.00,'',1487901070,'::1',1,'余额用于支付订单金额，订单号：2017022438448','','余额支付',1,0,'2017-02-24 01:51:10','2017-02-24 01:51:10');

/*Table structure for table `ps_wap_config` */

DROP TABLE IF EXISTS `ps_wap_config`;

CREATE TABLE `ps_wap_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '配置文件名称',
  `code` varchar(255) NOT NULL COMMENT '配置文件代码 唯一',
  `value` varchar(255) NOT NULL COMMENT '配置文件的值',
  `add_time` int(11) NOT NULL COMMENT '添加时间的时间戳',
  `sort_order` int(11) NOT NULL COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `wap_config_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ps_wap_config` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
