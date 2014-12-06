
## ----------------------------
## Table structure for ihostloc
## ----------------------------
DROP TABLE IF EXISTS `ihostloc`;
CREATE TABLE `authmac` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mac` varchar(36) DEFAULT NULL,
  `priip` varchar(64) DEFAULT NULL,
  `pubip` varchar(64) DEFAULT NULL,
  `apptype` varchar(36) DEFAULT NULL,
  `location` varchar(64) DEFAULT NULL,
  `latitude` varchar(36) DEFAULT NULL,
  `longitude` varchar(36) DEFAULT NULL,
  `rectime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mac` (`mac`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;