CREATE TABLE IF NOT EXISTS `phpvms_codeshares` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schedid` int(11) NOT NULL,
  `airline` varchar(50) NOT NULL,
  'image' varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;
