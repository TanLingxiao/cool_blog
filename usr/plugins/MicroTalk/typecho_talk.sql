CREATE TABLE `typecho_talk` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `authorId` int(10) unsigned NOT NULL DEFAULT '0',
  `content` varchar(511) NOT NULL DEFAULT '',
  `created` int(10) unsigned NOT NULL DEFAULT '0',
  `isShow` tinyint(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created` (`created`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=%charset%;