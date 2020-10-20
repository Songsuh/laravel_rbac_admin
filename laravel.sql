/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50728
 Source Host           : localhost:3306
 Source Schema         : laravel

 Target Server Type    : MySQL
 Target Server Version : 50728
 File Encoding         : 65001

 Date: 20/10/2020 21:39:06
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admins
-- ----------------------------
BEGIN;
INSERT INTO `admins` VALUES (1, 'admin', 'admin@qq.com', '$2y$10$NKRKUWS4L8OAziq0D7iWoeqx7SrWCbcKB6cY4Iqx6XCNKkN/ZE0Ve', NULL, 1, 1, '2020-03-20 23:32:42', '2020-08-20 07:30:41');
INSERT INTO `admins` VALUES (2, 'admin1', 'admin1@qq.com', '$2y$10$NKRKUWS4L8OAziq0D7iWoeqx7SrWCbcKB6cY4Iqx6XCNKkN/ZE0Ve', NULL, 5, 1, '2020-03-20 23:32:42', '2020-08-20 07:30:41');
COMMIT;

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '名称',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父id',
  `route` varchar(50) DEFAULT NULL COMMENT '路由',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态:1=正常,0=隐藏',
  `icon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '图标',
  `sort` mediumint(5) unsigned DEFAULT '50' COMMENT '排序有小到大',
  `rank` tinyint(2) DEFAULT '0' COMMENT '级别',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COMMENT='菜单表';

-- ----------------------------
-- Records of menus
-- ----------------------------
BEGIN;
INSERT INTO `menus` VALUES (7, '权限管理', 0, '', 1, '', 50, 0, '2020-09-15 14:26:25', '2020-09-17 14:01:10');
INSERT INTO `menus` VALUES (8, '角色管理', 7, 'roles.index', 1, '', 50, 1, '2020-09-16 08:37:04', '2020-10-20 06:02:09');
INSERT INTO `menus` VALUES (9, '管理员管理', 7, 'admins.index', 1, '', 50, 1, '2020-09-17 06:09:52', '2020-10-20 06:02:19');
INSERT INTO `menus` VALUES (10, '菜单管理', 7, 'menus.index', 1, '', 50, 1, '2020-09-17 06:26:11', '2020-10-20 06:02:42');
INSERT INTO `menus` VALUES (12, '文章管理', 0, '', 1, '', 50, 0, '2020-09-17 14:00:59', '2020-09-17 14:00:59');
INSERT INTO `menus` VALUES (13, '权限规则', 7, 'permissions.index', 1, '', 50, 1, '2020-09-21 08:59:16', '2020-10-20 06:02:54');
COMMIT;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2020_08_19_082400_create_permission_tables', 1);
INSERT INTO `migrations` VALUES (4, '2020_08_20_061808_create_posts_table', 2);
INSERT INTO `migrations` VALUES (5, '2020_09_13_131445_create_admin_table', 3);
COMMIT;

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '路由',
  `method` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '请求方式',
  `cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属菜单id',
  `sort` int(11) DEFAULT '50' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
BEGIN;
INSERT INTO `permissions` VALUES (8, '欢迎页查看', 'web', 'dashboard.index', 'GET', 1, 50, '2020-09-23 03:53:12', '2020-10-20 03:53:33');
INSERT INTO `permissions` VALUES (9, '角色查看', 'web', 'roles.index', 'GET', 8, 50, '2020-09-24 08:12:43', '2020-10-20 05:44:12');
INSERT INTO `permissions` VALUES (10, '角色添加', 'web', 'roles.create', 'GET', 8, 50, '2020-09-24 08:13:27', '2020-10-20 05:44:26');
INSERT INTO `permissions` VALUES (11, '角色编辑', 'web', 'roles.edit', 'GET', 8, 50, '2020-09-24 08:19:36', '2020-10-20 05:44:45');
INSERT INTO `permissions` VALUES (12, '角色删除', 'web', 'roles.destroy', 'GET', 8, 50, '2020-09-24 08:26:21', '2020-10-20 05:44:55');
INSERT INTO `permissions` VALUES (13, '菜单查看', 'web', 'menus.index', 'GET', 10, 50, '2020-09-24 08:26:49', '2020-10-20 05:45:05');
INSERT INTO `permissions` VALUES (14, '菜单添加', 'web', 'menus.create', 'GET', 10, 50, '2020-09-28 13:06:08', '2020-10-20 05:45:15');
INSERT INTO `permissions` VALUES (15, '菜单编辑', 'web', 'menus.edit', 'GET', 10, 50, '2020-09-28 13:06:53', '2020-10-20 05:45:26');
INSERT INTO `permissions` VALUES (16, '菜单删除', 'web', 'menus.destroy', 'GET', 10, 50, '2020-09-28 13:10:12', '2020-10-20 05:45:37');
INSERT INTO `permissions` VALUES (17, '权限查看', 'web', 'permissions.index', 'GET', 13, 50, '2020-09-28 13:11:33', '2020-10-20 05:47:41');
INSERT INTO `permissions` VALUES (18, '权限添加', 'web', 'permissions.create', 'GET', 13, 50, '2020-09-28 13:12:06', '2020-10-20 05:47:51');
INSERT INTO `permissions` VALUES (19, '权限编辑', 'web', 'permissions.edit', 'GET', 13, 50, '2020-09-28 13:12:26', '2020-10-20 05:48:01');
INSERT INTO `permissions` VALUES (20, '权限删除', 'web', 'apermissions.destroy', 'GET', 13, 50, '2020-09-28 13:13:12', '2020-10-20 05:48:10');
INSERT INTO `permissions` VALUES (21, '管理员查看', 'web', 'admins.index', 'GET', 9, 50, '2020-10-20 05:50:55', '2020-10-20 05:50:55');
INSERT INTO `permissions` VALUES (22, '管理员添加', 'web', 'admins.create', 'GET', 9, 50, '2020-10-20 05:51:37', '2020-10-20 05:51:37');
INSERT INTO `permissions` VALUES (23, '管理员编辑', 'web', 'admins.edit', 'GET', 9, 50, '2020-10-20 05:52:01', '2020-10-20 05:52:01');
INSERT INTO `permissions` VALUES (24, '管理员删除', 'web', 'admins.destory', 'GET', 9, 50, '2020-10-20 05:52:34', '2020-10-20 05:53:02');
COMMIT;

-- ----------------------------
-- Table structure for posts
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
BEGIN;
INSERT INTO `role_has_permissions` VALUES (8, 5);
INSERT INTO `role_has_permissions` VALUES (9, 5);
INSERT INTO `role_has_permissions` VALUES (10, 5);
INSERT INTO `role_has_permissions` VALUES (11, 5);
INSERT INTO `role_has_permissions` VALUES (12, 5);
INSERT INTO `role_has_permissions` VALUES (13, 5);
INSERT INTO `role_has_permissions` VALUES (14, 5);
INSERT INTO `role_has_permissions` VALUES (8, 6);
INSERT INTO `role_has_permissions` VALUES (8, 8);
COMMIT;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '角色名',
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pid` int(11) DEFAULT '0' COMMENT '上级id',
  `sort` mediumint(5) DEFAULT '50' COMMENT '排序',
  `rank` mediumint(5) DEFAULT '0' COMMENT '等级',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
BEGIN;
INSERT INTO `roles` VALUES (1, '超级管理', 'web', 0, 50, 0, 1, '2020-09-20 09:24:54', '2020-09-20 09:24:54');
INSERT INTO `roles` VALUES (5, '管理员', 'web', 1, 50, 1, 1, '2020-09-20 09:24:54', '2020-09-20 09:25:26');
INSERT INTO `roles` VALUES (6, '运营部', 'web', 1, 50, 1, 1, '2020-09-20 09:25:44', '2020-09-20 09:25:44');
INSERT INTO `roles` VALUES (7, '运营专员', 'web', 6, 50, 2, 1, '2020-09-20 09:26:02', '2020-09-20 09:26:02');
INSERT INTO `roles` VALUES (8, '编辑', 'web', 1, 50, 1, 1, '2020-09-28 12:52:58', '2020-09-28 12:52:58');
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES (1, 'song', 'song@qq.com', '2020-07-30 16:35:19', '$2y$10$NKRKUWS4L8OAziq0D7iWoeqx7SrWCbcKB6cY4Iqx6XCNKkN/ZE0Ve', NULL, '2020-03-20 23:32:42', '2020-08-20 07:30:41');
INSERT INTO `users` VALUES (2, 'wang', 'wang@qq.con', NULL, '$2y$10$gB.AlWszCHXsHmRcxdZ5de4BC35lIIxK5scKUhtGB0/5.xUDWy6Ni', NULL, '2020-08-20 07:35:42', '2020-08-20 08:06:17');
INSERT INTO `users` VALUES (3, 'wu', 'wu@qq.com', NULL, '$2y$10$8u.D/rZ2Qe4QrBexvRWc2O/T..oKi0xvzM5L1.3E32DVJwUZ/uHAe', NULL, '2020-08-20 08:08:18', '2020-08-20 09:35:18');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
