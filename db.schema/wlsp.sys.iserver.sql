﻿
## ----------------------------
## Table structure for ihostloc
## ----------------------------
DROP TABLE IF EXISTS `ihostloc`;
CREATE TABLE `ihostloc` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mac` varchar(36) DEFAULT NULL, #mac address of eth0
  `priip` varchar(64) DEFAULT NULL, #ip addr of eth0
  `pubip` varchar(64) DEFAULT NULL, #ip addr retrived form request url
  `rpttype` varchar(36) DEFAULT NULL, #status of this report:start;end;mid; of work
  `apptype` varchar(36) DEFAULT NULL, #ma-meeting affair;hr-human resource;ms-mobile station
  `dbinput` varchar(128) DEFAULT NULL, #db file imported into ihost at the begining (github url)
  `dboutput` varchar(128) DEFAULT NULL, #db file dumped from ihost in the end (github url)
  `city` varchar(64) DEFAULT NULL, #city name
  `location` varchar(64) DEFAULT NULL, #street name or building name
  `company` varchar(64) DEFAULT NULL, #company name
  `owner` varchar(64) DEFAULT NULL, #the owner of the ihost
  `latitude` varchar(36) DEFAULT NULL,
  `longitude` varchar(36) DEFAULT NULL,
  `admin` varchar(36) DEFAULT NULL, #administrator
  `phone` varchar(64) DEFAULT NULL, #phone number of the administrator
  `wechatid` varchar(64) DEFAULT NULL,
  `memo` varchar(128) DEFAULT NULL,
  `progid` varchar(36) DEFAULT NULL,
  `rectime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mac` (`mac`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;