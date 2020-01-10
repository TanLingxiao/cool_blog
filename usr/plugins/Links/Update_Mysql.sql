ALTER TABLE `typecho_links`
ADD `sort` varchar( 200 ) default NULL COMMENT 'links分类' AFTER `url`, 
ADD `image` varchar( 200 ) default NULL COMMENT 'links图片' AFTER `sort`,
ADD `user` varchar( 200 ) default NULL COMMENT '自定义' AFTER `description`;
ADD COLUMN `is_show`  tinyint(1) NULL DEFAULT 1 AFTER `order`;