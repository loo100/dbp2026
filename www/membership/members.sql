CREATE TABLE IF NOT EXISTS `members2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(10) NOT NULL DEFAULT '',
  `password` varchar(10) NOT NULL DEFAULT '',
  `name` varchar(10) NOT NULL DEFAULT '',
  `sex` char(2) NOT NULL DEFAULT '',
  `cellphone` varchar(20) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `comment` text NOT NULL,
  `enable` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;