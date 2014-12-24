## Tables for user registration
## and authentication
## used by
## local server and (or) central server
## This file is used by both ihost and iserver to set up database.


SET FOREIGN_KEY_CHECKS=0;
## ----------------------------
## Table structure for authclient
## ----------------------------
DROP TABLE IF EXISTS `authclient`;
CREATE TABLE `authclient` (
  `id` int NOT NULL AUTO_INCREMENT,
  `srcid` int DEFAULT NULL,
  `cid` varchar(30) DEFAULT NULL,
  `ctype` varchar(10) DEFAULT NULL,
  `stat` varchar(3) DEFAULT '0',
  `phone` varchar(30) DEFAULT NULL,
  `sphone` varchar(30) DEFAULT NULL,
  `msg` varchar(8) DEFAULT NULL,
  `plan` varchar(20) DEFAULT NULL,
  `question` varchar(30) DEFAULT NULL,
  `answer` varchar(30) DEFAULT NULL,
  `token` int DEFAULT NULL,
  `mac` varchar(18) DEFAULT NULL,
  `img` varchar(128) DEFAULT '',
  `imgchk1` smallint DEFAULT '0',
  `imgchk2` smallint DEFAULT '0',
  `imgchk3` smallint DEFAULT '0',
  `manstat` smallint DEFAULT '0',
  `manchker` varchar(16) DEFAULT NULL,
  `manid` varchar(30) DEFAULT NULL,
  `mantype` varchar(10) DEFAULT NULL,
  `mantime` datetime DEFAULT NULL,
  `optflag` tinyint DEFAULT NULL,
  `srcip` varchar(64) DEFAULT NULL,
  `srcname` varchar(64) DEFAULT NULL,
  `rectime` datetime DEFAULT NULL,
  `sender` varchar(36) DEFAULT NULL, 
  `netid` varchar(36) DEFAULT NULL, 
  `progid` varchar(36) DEFAULT NULL, 
  `optime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`),
  KEY `phone` (`phone`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


## ----------------------------
## Table structure for authmac
## ----------------------------
DROP TABLE IF EXISTS `authmac`;
CREATE TABLE `authmac` (
  `id` int NOT NULL AUTO_INCREMENT,
  `srcid` int DEFAULT NULL,
  `mac` varchar(36) DEFAULT NULL,
  `ip` varchar(64) DEFAULT NULL,
  `stat` smallint DEFAULT NULL,
  `fromtime` datetime DEFAULT NULL,
  `lasting` int DEFAULT NULL,
  `pushflag` smallint DEFAULT NULL,
  `pushurl` varchar(127) DEFAULT NULL,
  `pushtime` int DEFAULT NULL,
  `cid` varchar(30) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `token` int DEFAULT NULL,
  `base` varchar(10) DEFAULT NULL,
  `srcip` varchar(64) DEFAULT NULL,
  `srcname` varchar(64) DEFAULT NULL,
  `rectime` datetime DEFAULT NULL,
  `sender` varchar(36) DEFAULT NULL, 
  `netid` varchar(36) DEFAULT NULL, 
  `progid` varchar(36) DEFAULT NULL, 
  `optime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mac` (`mac`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


## ----------------------------
## Table structure for authsms
## ----------------------------
DROP TABLE IF EXISTS `authsms`;
CREATE TABLE `authsms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `srcid` int DEFAULT NULL,
  `msgid` varchar(64) DEFAULT NULL,
  `prefix` varchar(64) DEFAULT '',
  `sms` varchar(128) DEFAULT NULL,
  `postfix` varchar(64) DEFAULT '',
  `mac` varchar(36) DEFAULT NULL,
  `ip` varchar(64) DEFAULT NULL,
  `phone` varchar(30) DEFAULT '',
  `stat` smallint DEFAULT '0',
  `optflag` smallint DEFAULT '0',
  `token` int DEFAULT NULL,
  `rectime` datetime DEFAULT NULL,
  `sender` varchar(36) DEFAULT NULL, 
  `netid` varchar(36) DEFAULT NULL, 
  `progid` varchar(36) DEFAULT NULL, 
  `optime` datetime DEFAULT NULL,
  `sendtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


## ----------------------------
## Table structure for authblkmac
## table for local server to keep a mac list to kick off
## ----------------------------
DROP TABLE IF EXISTS `authblkmac`;
CREATE TABLE `authblkmac` (
  `id` int NOT NULL AUTO_INCREMENT,
  `srcid` int DEFAULT NULL,
  `mac` varchar(20) DEFAULT NULL,
  `blktime` varchar(6) DEFAULT NULL,
  `rectime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


## ----------------------------
## Table structure for authmacip
## table for local server to keep a record of each visit
## ----------------------------
DROP TABLE IF EXISTS `authmacip`;
CREATE TABLE `authmacip` (
  `id` int NOT NULL AUTO_INCREMENT,
  `srcid` int DEFAULT NULL,
  `mac` varchar(36) DEFAULT NULL,
  `ip` varchar(64) DEFAULT NULL,
  `called` varchar(36) DEFAULT NULL,
  `srcip` varchar(64) DEFAULT NULL,
  `procid` varchar(36) DEFAULT NULL,
  `userurl` varchar(1024) DEFAULT NULL,
  `orgurl` varchar(1024) DEFAULT NULL,
  `token` int DEFAULT NULL,
  `rectime` datetime DEFAULT NULL,
  `sender` varchar(36) DEFAULT NULL, 
  `netid` varchar(36) DEFAULT NULL, 
  `progid` varchar(36) DEFAULT NULL, 
  `optime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mac` (`mac`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


## ----------------------------
## Table structure for authnlist
## table for central server side to keep a record
## of who can call the webservice
## ----------------------------
DROP TABLE IF EXISTS `authnlist`;
CREATE TABLE `authnlist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `srcid` int DEFAULT NULL,
  `mac` varchar(17) DEFAULT NULL,
  `ip` varchar(64) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `passwd` varchar(64) DEFAULT NULL,
  `secret` varchar(64) DEFAULT NULL,
  `rectime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

## ----------------------------
## Records of authnlist
## ----------------------------
INSERT INTO `authnlist` VALUES ('1', null, null, '192.168.1.252', 'zgbdh001', '1234567890', 'ab', '2013-05-12 10:23:25');



##
## Tables for network visit and action recording (wlcap version)
##
##

## ----------------------------
## Table structure for actvst
## ----------------------------
DROP TABLE IF EXISTS `actvst`;
CREATE TABLE `actvst` (
  `id` int NOT NULL AUTO_INCREMENT,
  `srcid` int DEFAULT NULL,
  `pkttime` datetime DEFAULT NULL,
  `timefrac` float DEFAULT NULL,
  `srcmac` varchar(64) DEFAULT NULL,
  `srcip` varchar(64) DEFAULT NULL,
  `destip` varchar(64) DEFAULT NULL,
  `url` varchar(1024) DEFAULT NULL,
  `rectime` datetime DEFAULT NULL,
  `sender` varchar(36) DEFAULT NULL, 
  `netid` varchar(36) DEFAULT NULL, 
  `progid` varchar(36) DEFAULT NULL, 
  `optime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


## ----------------------------
## Table structure for actvrf
## ----------------------------
DROP TABLE IF EXISTS `actvrf`;
CREATE TABLE `actvrf` (
  `id` int NOT NULL AUTO_INCREMENT,
  `srcid` int DEFAULT NULL,
  `level` varchar(16) DEFAULT NULL,
  `dname` varchar(36) DEFAULT NULL,
  `mlen` int DEFAULT NULL,
  `ltime` int DEFAULT NULL,
  `active` tinyint DEFAULT '1',
  `rectime` datetime DEFAULT NULL,
  `type` tinyint DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `dname` (`dname`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

## ----------------------------
## Records of actvrf
## ----------------------------
INSERT INTO `actvrf` VALUES ('1', null, '0001.0000.0000', 'www.baidu.com', '0', '0', '1', '2013-03-13 14:05:43', '20');
INSERT INTO `actvrf` VALUES ('2', null, '0002.0000.0000', 'www.google.com', '0', '0', '1', '2013-03-13 14:13:33', '20');
INSERT INTO `actvrf` VALUES ('3', null, '0001.0001.0000', 'im.baidu.com', '30', '45', '1', '2013-03-13 14:17:49', '20');
INSERT INTO `actvrf` VALUES ('4', null, '3000.0001.0000', '360.cn', '30', '1200', '1', '2013-03-13 14:18:19', '20');
INSERT INTO `actvrf` VALUES ('5', null, '9999.9999.9999', 'default', '20', '120', '1', '2013-03-13 14:19:00', '20');
INSERT INTO `actvrf` VALUES ('6', null, '3000.0002.0000', 'sogou.com', '20', '600', '1', '2013-03-13 14:29:41', '20');
INSERT INTO `actvrf` VALUES ('7', null, '9999.8001.0000', '.jpg', '4', '300', '1', '2013-03-13 15:29:11', '10');
INSERT INTO `actvrf` VALUES ('8', null, '9999.8002.0000', '.png', '4', '300', '1', '2013-03-13 15:29:11', '10');
INSERT INTO `actvrf` VALUES ('9', null, '9999.8003.0000', '.gif', '4', '300', '1', '2013-03-13 15:29:11', '10');
INSERT INTO `actvrf` VALUES ('10', null, '9999.8004.0000', '.js', '4', '300', '1', '2013-03-13 15:29:11', '10');
INSERT INTO `actvrf` VALUES ('11', null, '9999.8005.0000', '.swf', '4', '300', '1', '2013-03-14 09:27:18', '10');


##
## Tables for url push
##
-- ----------------------------
-- Table structure for pushrurl
-- ----------------------------
DROP TABLE IF EXISTS `pushrurl`;
CREATE TABLE `pushrurl` (
  `id` int NOT NULL AUTO_INCREMENT,
  `srcid` int DEFAULT NULL,
  `prio` int DEFAULT '0',
  `srcip` varchar(64) DEFAULT NULL,
  `type` int DEFAULT '1',
  `cnd` varchar(16) DEFAULT NULL,
  `ftime` datetime DEFAULT NULL,
  `dura` int DEFAULT '3',
  `rurl` varchar(128) DEFAULT NULL,
  `rurltoken` varchar(32) DEFAULT '',
  `active` tinyint DEFAULT '1',
  `rectime` datetime DEFAULT NULL,
  `sender` varchar(36) DEFAULT NULL, 
  `netid` varchar(36) DEFAULT NULL, 
  `progid` varchar(36) DEFAULT NULL, 
  `optime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`cnd`),
  KEY `dname` (`srcip`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pushrurl
-- ----------------------------


INSERT INTO `pushrurl` VALUES ('1', null, '1','default', '10', '', '2013-08-26 15:00:00', '20', 
'http://172.16.0.1/push/push1.html','172.16.0.1', '1', '2013-08-26 15:00:00',null,null,null,null);

INSERT INTO `pushrurl` VALUES ('2', null, '0','172.16.0.100', '10', null, '2013-08-26 15:00:00', 
'40', 'http://172.16.0.1/push/push2.html','172.16.0.1', '1', '2013-08-26 15:00:00',null,null,null,null);




##
## Tables, Views and Triggers
## for wireless packet sniffer
##


## ----------------------------
## Table structure for wlact
## ----------------------------
DROP TABLE IF EXISTS `wlact`;
CREATE TABLE `wlact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `srcid` int DEFAULT NULL,
  `event` varchar(64) DEFAULT NULL,
  `mac` varchar(36) DEFAULT NULL,
  `subevent` varchar(64) DEFAULT NULL,
  `oldvalue` varchar(64) DEFAULT NULL,
  `newvalue` varchar(64) DEFAULT NULL,
  `firstseen` datetime DEFAULT NULL,
  `lastseen` datetime DEFAULT NULL,
  `stat` smallint DEFAULT NULL,
  `ssid` varchar(36) DEFAULT NULL,
  `action` smallint DEFAULT NULL,
  `tcount` int DEFAULT NULL,
  `rectime` datetime DEFAULT NULL,
  `srcip` varchar(64) DEFAULT NULL,
  `sender` varchar(36) DEFAULT NULL, 
  `netid` varchar(36) DEFAULT NULL, 
  `progid` varchar(36) DEFAULT NULL, 
  `optime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mac` (`mac`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


## ----------------------------
## Table structure for wlpkt
## ----------------------------
DROP TABLE IF EXISTS `wlpkt`;
CREATE TABLE `wlpkt` (
  `id` int NOT NULL AUTO_INCREMENT,
  `srcid` int DEFAULT NULL,
  `mac` varchar(36) DEFAULT NULL,
  `ssid` varchar(36) DEFAULT NULL,
  `rssi` smallint DEFAULT NULL,
  `stat` tinyint DEFAULT NULL,
  `type` varchar(36) DEFAULT NULL,
  `subtype` varchar(36) DEFAULT NULL,
  `pmac` varchar(36) DEFAULT NULL,
  `bssid` varchar(36) DEFAULT NULL,
  `pkttime` datetime DEFAULT NULL,
  `timefrac` float DEFAULT NULL,
  `timebyminute` datetime DEFAULT NULL,
  `timesecond` tinyint DEFAULT NULL,
  `timebyhour` datetime DEFAULT NULL,
  `timeminute` tinyint DEFAULT NULL,
  `frameproto` varchar(36) DEFAULT NULL,
  `chan` varchar(36) DEFAULT NULL,
  `rectime` datetime DEFAULT NULL,
  `srcip` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `packettime` (`pkttime`),
  KEY `mac` (`mac`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


## ----------------------------
## Table structure for wlsta
## ----------------------------
DROP TABLE IF EXISTS `wlsta`;
CREATE TABLE `wlsta` (
  `id` int NOT NULL AUTO_INCREMENT,
  `srcid` int DEFAULT NULL,
  `tcount` int DEFAULT NULL,
  `mac` varchar(36) DEFAULT NULL,
  `ssid` varchar(36) DEFAULT NULL,
  `rssi` float DEFAULT NULL,
  `stat` smallint DEFAULT NULL,
  `setby` varchar(20) DEFAULT NULL,
  `keepalive` tinyint DEFAULT NULL,
  `firstseen` datetime DEFAULT NULL,
  `lastseen` datetime DEFAULT NULL,
  `rtrend` smallint DEFAULT NULL,
  `npacket` int DEFAULT NULL,
  `ptrend` smallint DEFAULT NULL,
  `action` smallint DEFAULT NULL,
  `ostype` varchar(36) DEFAULT NULL,
  `alivetime` int DEFAULT NULL,
  `rectime` datetime DEFAULT NULL,
  `srcip` varchar(64) DEFAULT NULL,
  `sender` varchar(36) DEFAULT NULL, 
  `netid` varchar(36) DEFAULT NULL, 
  `progid` varchar(36) DEFAULT NULL, 
  `optime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mac` (`mac`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

## ----------------------------
## Table structure for useraccounts
## ----------------------------
DROP TABLE IF EXISTS `useraccounts`;	#	用户主记录
CREATE TABLE `useraccounts` (	#	
  `id` bigint NOT NULL AUTO_INCREMENT,	#	
  `userid` varchar(36) DEFAULT NULL,	#	为user分配一个uuid. It is generated in ihost by php. 
  `srcid` int DEFAULT NULL,	#	iserver字段
  `token` int DEFAULT NULL,	#	8位随机数，由ihost产生
  `srcnode` varchar(10) DEFAULT NULL,	#	（预留）
  `usercode` varchar(30) DEFAULT NULL,	#	用户编码（预留）
  `user_uuid` varchar(36) DEFAULT NULL,	#	用户uuid. It is generated on iserver. Globally effective to cover cases that the user might change his phone and/or phone number.
  `mac` varchar(36) DEFAULT NULL,	#	mac地址
  `userpass` varchar(30) DEFAULT NULL,	#	用户密码
  `useremail1` varchar(64) DEFAULT NULL,	#	用户email
  `useremail2` varchar(64) DEFAULT NULL,	#	用户备用email
  `question` varchar(30) DEFAULT NULL,	#	密码提示问题
  `answer` varchar(30) DEFAULT NULL,	#	密码答案，用于找回密码
  `fname` varchar(20) DEFAULT NULL,	#	名字
  `lname` varchar(20) DEFAULT NULL,	#	姓
  `userrole` varchar(20) default NULL, #	不同角色，每个mac在每个userrole中有一个default userid #   100-代表 200-嘉宾 300-媒体 400-会务
  `usertype` varchar(10) DEFAULT NULL,	#	用户类型：预注册/现场注册
  `integral` int DEFAULT '0',	#	userid下的积分
  `pntfactor` int DEFAULT '1000',	#	points转integral的因子，1000代表1
  `byear` smallint DEFAULT NULL,	#	生日，年
  `bmonth` smallint DEFAULT NULL,	#	生日，月
  `bday` smallint DEFAULT NULL,	#	生日，日
  `gender` varchar(8) DEFAULT NULL,	#	性别
  `occup` varchar(30) DEFAULT NULL,	#	职业
  `orgn` varchar(64) DEFAULT NULL,	#	工作单位
  `title` varchar(32) DEFAULT NULL,	#	职务
  `cid` varchar(30) DEFAULT NULL,	#	证件号
  `ctype` varchar(10) DEFAULT NULL,	#	证件类别
  `regphone` varchar(30) DEFAULT NULL,	#	（预）注册所用的电话号码
  `captcha` varchar(10) DEFAULT NULL,	#	（预）注册所用的验证码
  `phone` varchar(30) DEFAULT NULL,	#	常用电话号码
  `address` varchar(128) DEFAULT NULL,	#	地址
  `location` varchar(32) DEFAULT NULL,	#	所在区域
  `action` varchar(128) DEFAULT NULL,	#	活动（预留）
  `stat` varchar(3) DEFAULT '100',	#	数据状态 100-有效 
  `open1` varchar(3) DEFAULT '100',	#	数据对招聘者公开，100-公开，0-不公开
  `open2` varchar(3) DEFAULT '100',	#	数据对求职者公开，100-公开，0-不公开
  `smscheck` varchar(3) DEFAULT '100',	#	短信验证，100-验证，0-不验证
  `memo` varchar(128) DEFAULT NULL,	#	备注
  `srcip` varchar(64) DEFAULT NULL,	#	iserver字段
  `sender` varchar(36) DEFAULT NULL, 	#	iserver字段
  `netid` varchar(36) DEFAULT NULL, 	#	iserver字段
  `progid` varchar(36) DEFAULT NULL, 	#	iserver字段
  `intid` varchar(30) DEFAULT NULL,	#	与phpyun的对应关系（记录学历等其他个人信息）
  `updtime` datetime DEFAULT NULL,	#	记录更新时间
  `rectime` datetime DEFAULT NULL,	#	记录时间
  `pushflag` smallint DEFAULT '1',
  PRIMARY KEY (`id`),	#	
  KEY `userid` (`userid`),	#	
  KEY `phone` (`phone`), #	
  KEY `usercode` (`usercode`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;	#	

## ----------------------------
## Table structure for usermacs
## ----------------------------
DROP TABLE IF EXISTS `usermacs`;	#	记录useraccount 与 终端、电话号码的多对多关系
CREATE TABLE `usermacs` (	#	
  `id` int NOT NULL AUTO_INCREMENT,	#	
  `userid` varchar(36) DEFAULT NULL,	#	mac对应的userid，多对多的关系
  `srcid` int DEFAULT NULL,	#	iserver字段
  `token` int DEFAULT NULL,	#	8位随机数，由ihost产生
  `srcnode` varchar(10) DEFAULT NULL,	#	（预留）
  `usercode` varchar(30) DEFAULT NULL,	#	用户编码（预留）
  `mac` varchar(36) DEFAULT NULL,	#	用户的mac地址（一个mac可以对多用户，一个用户可以有多mac）
  `phone` varchar(30) DEFAULT NULL,	#	用户提供的手机号（与用户多对多关系）
  `stat` varchar(3) DEFAULT '100',	#	数据状态 100-有效 
  `dft` varchar(3) DEFAULT '100',	#	100-此记录的mac-userid是默认值，一个mac一个userrole下同时只有一个默认userid
  `prio` varchar(3) DEFAULT '0',	#	多个mac-userrole-userid的排序优先级；大于0的最大值可用于自动签到
  `userrole` varchar(30) DEFAULT NULL,	#	不同角色，每个mac在每个userrole中有一个default userid #   100-代表 200-嘉宾 300-媒体 400-会务
  `pntmaster` varchar(3) DEFAULT NULL,	#	积分主记录标识，100-此userid为主记录，一个mac只对一个userid积分
  `memo` varchar(128) DEFAULT NULL,	#	备注
  `srcip` varchar(64) DEFAULT NULL,	#	iserver字段
  `sender` varchar(36) DEFAULT NULL, 	#	iserver字段
  `netid` varchar(36) DEFAULT NULL, 	#	iserver字段
  `progid` varchar(36) DEFAULT NULL, 	#	iserver字段
  `updtime` datetime DEFAULT NULL,	#	记录更新时间
  `rectime` datetime DEFAULT NULL,	#	记录时间
  `pushflag` smallint DEFAULT '1',
  PRIMARY KEY (`id`),	#	
  KEY `userid` (`userid`),	#	
  KEY `usercode` (`usercode`),	#	
  KEY `mac` (`mac`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;	#	

DROP TABLE IF EXISTS `useractive`;	#	当前活动用户
CREATE TABLE `useractive` (	#	
  `id` int NOT NULL AUTO_INCREMENT,	#	
  `srcid` int DEFAULT NULL,	#	iserver字段
  `mac` varchar(36) DEFAULT NULL,	#	用户的mac地址
  `phone` varchar(30) DEFAULT NULL,	#	用户的手机号（与用户多对多关系）
  `userrole` varchar(30) DEFAULT NULL,	#	不同角色，每个mac在每个userrole中有一个default userid
  `userid` varchar(36) DEFAULT NULL,	#	mac对应的userid，多对多的关系
  `onsite` tinyint DEFAULT '0',  # 0-not on site; 1-onsite
  `online` tinyint DEFAULT '0',  # 0-not online; 1-online
  `macfirst` datetime DEFAULT '1970-1-1 00:00:00',	#	mac首次发现时间
  `macmark` datetime DEFAULT NULL,	#	mac标记时间，中途更新积分时使用
  `maclast` datetime DEFAULT '1970-1-1 00:00:00',	#	mac最后一次发现时间
  `pagefirst` datetime DEFAULT '1970-1-1 00:00:00',	#	首次访问站点时间
  `pagemark` datetime DEFAULT NULL,	#	站点标记时间，中途更新积分时使用
  `pagelast` datetime DEFAULT '1970-1-1 00:00:00',	#	末次访问站点时间
  `updby` varchar(128) DEFAULT NULL,	#   更新记录的程序
  `insby` varchar(128) DEFAULT NULL,	#   创建记录的程序
  `srcip` varchar(64) DEFAULT NULL,	#	iserver字段
  `sender` varchar(36) DEFAULT NULL, 	#	iserver字段
  `netid` varchar(36) DEFAULT NULL, 	#	iserver字段
  `progid` varchar(36) DEFAULT NULL, 	#	iserver字段
  `updtime` datetime DEFAULT NULL,	#	记录更新时间
  `rectime` datetime DEFAULT NULL,	#	记录时间
  `pushflag` smallint DEFAULT '1',
  PRIMARY KEY (`id`),	#	
  KEY `userid` (`userid`),
  KEY `mac` (`mac`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;	#	


## ----------------------------
## Table structure for smspool
## ----------------------------
DROP TABLE IF EXISTS `smspool`;
CREATE TABLE `smspool` (
  `id` int NOT NULL AUTO_INCREMENT, 
  `msgid` varchar(64) DEFAULT NULL, #短信id
  `prefix` varchar(64) DEFAULT '', #短信前缀
  `sms` varchar(128) DEFAULT NULL, #短信内容
  `postfix` varchar(64) DEFAULT '', #短信后缀
  `stat` smallint DEFAULT '100', #是否生效 100-生效
  `cnduserrole` varchar(30) DEFAULT NULL,
  `cndmacfirst` int DEFAULT '0', #首见mac后多少秒，此信息生效
  `cndmacstay` int DEFAULT '0', #在场多长时间后（秒），此信息生效
  `cndpagefirst` int DEFAULT '0', #首次上线后多少秒，此信息生效
  `cndpagestay` int DEFAULT '0', #在线多长时间后（秒），此信息生效
  `cndonsite` tinyint DEFAULT '0', #是否只对onsite用户
  `cndonline` tinyint DEFAULT '0', #是否只对online用户
  `cndfromtime` datetime DEFAULT '1970-1-1 00:00:00', #生效开始时间
  `cndtotime` datetime DEFAULT '9999-1-1 00:00:00', #生效结束时间
  `updtime` datetime DEFAULT NULL, #更新操作时间
  `rectime` datetime DEFAULT NULL, #写入数据库时间
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

## ----------------------------
## Table structure for smsrcv
## ----------------------------
DROP TABLE IF EXISTS `smsrcv`;
CREATE TABLE `smsrcv` (
  `id` int NOT NULL AUTO_INCREMENT, 
  `msg` varchar(128) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `msgtime` datetime DEFAULT NULL, 
  `mlocation` varchar(32) DEFAULT NULL,
  `mfolder` varchar(16) DEFAULT NULL,
  `rectime` datetime DEFAULT NULL, 
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

## ----------------------------
## Table structure for userpoints
## ----------------------------
DROP TABLE IF EXISTS `userpoints`;
CREATE TABLE `userpoints` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `userid` varchar(36) DEFAULT NULL,	#	为user分配一个uuid
  `srcid` int DEFAULT NULL,	#	iserver字段
  `token` int DEFAULT NULL,	#	8位随机数，由ihost产生
  `srcnode` varchar(10) DEFAULT NULL,	#	（预留）
  `usercode` varchar(30) DEFAULT NULL,	#	用户编码（预留）
  `mac` varchar(36) DEFAULT NULL,	#	mac地址，不能确定user信息时，直接记录到MAC上
  `points` int(10) DEFAULT '0', # 累计积分值
  `action` varchar(128) DEFAULT NULL, # 给积分的原因
  `srcip` varchar(64) DEFAULT NULL,	#	iserver字段
  `sender` varchar(36) DEFAULT NULL, 	#	iserver字段
  `netid` varchar(36) DEFAULT NULL, 	#	iserver字段
  `progid` varchar(36) DEFAULT NULL, 	#	iserver字段
  `updtime` datetime DEFAULT NULL,	#	记录更新时间
  `rectime` datetime DEFAULT NULL,	#	记录时间
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `mac` (`mac`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

## ----------------------------
## Table structure for userlog
## ----------------------------
DROP TABLE IF EXISTS `userlog`;
CREATE TABLE `userlog` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `userid` varchar(36) DEFAULT NULL,	#	为user分配一个uuid
  `srcid` int DEFAULT NULL,	#	iserver字段
  `token` int DEFAULT NULL,	#	userpoints表ID
  `srcnode` varchar(10) DEFAULT NULL,	#	（预留）
  `usercode` varchar(30) DEFAULT NULL,	#	用户编码（预留）
  `mac` varchar(36) DEFAULT NULL,	#	mac地址，不能确定user信息时，直接记录到MAC上
  `integral` int(10) DEFAULT '0', # 原计积分值
  `dintegral` int(10) DEFAULT '0', # 积分值变化
  `action` varchar(128) DEFAULT NULL, # 给积分的原因
  `srcip` varchar(64) DEFAULT NULL,	#	iserver字段
  `sender` varchar(36) DEFAULT NULL, 	#	iserver字段
  `netid` varchar(36) DEFAULT NULL, 	#	iserver字段
  `progid` varchar(36) DEFAULT NULL, 	#	iserver字段
  `updtime` datetime DEFAULT NULL,	#	记录更新时间
  `rectime` datetime DEFAULT NULL,	#	记录时间
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `usercode` (`usercode`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


## ----------------------------
## Table structure for userinfochk
## ----------------------------
DROP TABLE IF EXISTS `userinfochk`;
CREATE TABLE `userinfochk` (
  `id` int NOT NULL AUTO_INCREMENT, 
  `obj` varchar(64) DEFAULT NULL,  # object of the rule, userid, or mac
  `useraction` varchar(64) DEFAULT NULL, #  user action to trigger the rule, eg: IntegralExchange
  `pagename` varchar(64) DEFAULT NULL, #  specific page name to use the rule (reserved)
  `cnd` varchar(64) DEFAULT NULL, # other condititions for the rule to take effect (reserved)
  `info` varchar(32) DEFAULT NULL, # information to be checked, eg: cid, identifacation card number and name
  `op` varchar(16) DEFAULT NULL, # operator, eg: 100-forced, 200-recommended
  `action` varchar(16) DEFAULT NULL, # , action to be taken, eg: 100-fill, 200-update
  `stat` varchar(3) DEFAULT '100',	#	status 100-valid
  `rectime` datetime DEFAULT NULL, 
  PRIMARY KEY (`id`),
  KEY `obj` (`obj`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
