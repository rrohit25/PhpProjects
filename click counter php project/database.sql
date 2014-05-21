CREATE TABLE IF NOT EXISTS `banner_clicks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(250) NOT NULL,
  `clicks` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `banner_clicks` (`id`, `url`, `clicks`) VALUES
(1, 'http://www.temp.com', 2);
