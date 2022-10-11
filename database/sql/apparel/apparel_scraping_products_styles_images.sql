/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 50728
 Source Host           : localhost:3306
 Source Schema         : arena_api_test

 Target Server Type    : MySQL
 Target Server Version : 50728
 File Encoding         : 65001

 Date: 01/07/2020 05:16:52
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for apparel_scraping_products_styles_images
-- ----------------------------
DROP TABLE IF EXISTS `apparel_scraping_products_styles_images`;
CREATE TABLE `apparel_scraping_products_styles_images` (
  `row_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `row_uuid` char(36) COLLATE utf8_bin NOT NULL,
  `style_id` bigint(20) unsigned NOT NULL,
  `style_uuid` char(36) COLLATE utf8_bin NOT NULL,
  `file_id` bigint(20) unsigned NOT NULL,
  `file_uuid` char(36) COLLATE utf8_bin NOT NULL,
  `flag_type` varchar(255) COLLATE utf8_bin NOT NULL,
  `stamp_created` bigint(20) unsigned DEFAULT NULL,
  `stamp_created_at` timestamp NULL DEFAULT NULL,
  `stamp_created_by` bigint(20) unsigned DEFAULT NULL,
  `stamp_updated` bigint(20) unsigned DEFAULT NULL,
  `stamp_updated_at` timestamp NULL DEFAULT NULL,
  `stamp_updated_by` bigint(20) unsigned DEFAULT NULL,
  `stamp_deleted` bigint(20) unsigned DEFAULT NULL,
  `stamp_deleted_at` timestamp NULL DEFAULT NULL,
  `stamp_deleted_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`row_id`),
  UNIQUE KEY `uidx_row-id` (`row_id`),
  UNIQUE KEY `uidx_row-uuid` (`row_uuid`),
  UNIQUE KEY `uidx_row-id_style-id` (`row_id`,`style_id`),
  UNIQUE KEY `uidx_row-uuid_style-uuid` (`row_uuid`,`style_uuid`),
  UNIQUE KEY `uidx_style-id_row-id` (`style_id`,`row_id`),
  UNIQUE KEY `uidx_style-uuid_row-uuid` (`style_uuid`,`row_uuid`),
  UNIQUE KEY `uidx_row-id_file-id` (`row_id`,`file_id`),
  UNIQUE KEY `uidx_row-uuid_file-uuid` (`row_uuid`,`file_uuid`),
  UNIQUE KEY `uidx_file-id_row-id` (`file_id`,`row_id`),
  UNIQUE KEY `uidx_file-uuid_row-uuid` (`file_uuid`,`row_uuid`),
  UNIQUE KEY `uidx_style-id_file-id` (`style_id`,`file_id`),
  UNIQUE KEY `uidx_style-uuid_file-uuid` (`style_uuid`,`file_uuid`),
  UNIQUE KEY `uidx_file-id_style-id` (`file_id`,`style_id`),
  UNIQUE KEY `uidx_file-uuid_style-uuid` (`file_uuid`,`style_uuid`),
  UNIQUE KEY `uidx_row-id_style-id_file-id` (`row_id`,`style_id`,`file_id`),
  UNIQUE KEY `uidx_style-id_row-id_file-id` (`style_id`,`row_id`,`file_id`),
  UNIQUE KEY `uidx_style-id_file-id_row-id` (`style_id`,`file_id`,`row_id`),
  UNIQUE KEY `uidx_file-id_style-id_row-id` (`file_id`,`style_id`,`row_id`),
  UNIQUE KEY `uidx_file-id_row-id_style-id` (`file_id`,`row_id`,`style_id`),
  UNIQUE KEY `uidx_row-id_file-id_style-id` (`row_id`,`file_id`,`style_id`),
  UNIQUE KEY `uidx_row-uuid_style-uuid_file-uuid` (`row_uuid`,`style_uuid`,`file_uuid`),
  UNIQUE KEY `uidx_style-uuid_row-uuid_file-uuid` (`style_uuid`,`row_uuid`,`file_uuid`),
  UNIQUE KEY `uidx_style-uuid_file-uuid_row-uuid` (`style_uuid`,`file_uuid`,`row_uuid`),
  UNIQUE KEY `uidx_file-uuid_style-uuid_row-uuid` (`file_uuid`,`style_uuid`,`row_uuid`),
  UNIQUE KEY `uidx_file-uuid_row-uuid_style-uuid` (`file_uuid`,`row_uuid`,`style_uuid`),
  UNIQUE KEY `uidx_row-uuid_file-uuid_style-uuid` (`row_uuid`,`file_uuid`,`style_uuid`),
  KEY `idx_row-id` (`row_id`),
  KEY `idx_row-uuid` (`row_uuid`),
  KEY `idx_style-id` (`style_id`),
  KEY `idx_style-uuid` (`style_uuid`),
  KEY `idx_file-id` (`file_id`),
  KEY `idx_file-uuid` (`file_uuid`),
  KEY `idx_flag-type` (`flag_type`),
  KEY `idx_stamp-created` (`stamp_created`),
  KEY `idx_stamp-updated` (`stamp_updated`),
  KEY `idx_stamp-deleted` (`stamp_deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

SET FOREIGN_KEY_CHECKS = 1;
