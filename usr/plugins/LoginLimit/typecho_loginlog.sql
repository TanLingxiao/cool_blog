CREATE TABLE IF NOT EXISTS `typecho_loginlog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `try_username` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '尝试登录的用户名',
  `try_password` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '尝试登录的密码',
  `ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '客户端ip',
  `add_time` int(11) unsigned NOT NULL COMMENT '记录添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='失败登录的日志' AUTO_INCREMENT=1 ;

