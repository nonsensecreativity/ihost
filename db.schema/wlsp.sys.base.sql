﻿## Tables for user registration
## and authentication
## used by ## local server and (or) central server
## This file is used by both ihost and iserver to set up database.

###############################################################
## start from mysql 5.5, innodb is the default storage enginer
###############################################################



## ----------------------------
## Table structure for first_appearance
## table for local server to keep a record of the first visit of device
## mapping mac to local ip address in the local network
## ----------------------------
DROP TABLE IF EXISTS `first_appearance`;
CREATE TABLE `first_appearance` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `device_mac` varchar(36) DEFAULT NULL,
  `device_ip` varchar(64) DEFAULT NULL,
  `from_who` varchar(36) DEFAULT NULL,
  `hotspot_ip` varchar(64) DEFAULT NULL,
  `userurl` varchar(1024) DEFAULT NULL,
  `create_t` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mac` (`mac`),
  KEY `ip` (`ip`)
)  DEFAULT CHARSET=utf8;




##
## Tables for network visit and action recording (wlcap version)
##
##

## ----------------------------
## Table structure for device_ipvisit
## ----------------------------
DROP TABLE IF EXISTS `device_ipvisit`;
CREATE TABLE `device_ipvisit` (
  `id` int UNSIGNED  NOT NULL AUTO_INCREMENT,
  `pkt_time` datetime NOT NULL,
  `pkt_time_ms` SMALLINT UNSIGNED DEFAULT NULL,
  `pkt_src_mac` varchar(64) DEFAULT NULL,
  `pkt_src_ip` varchar(64) DEFAULT NULL,
  `pkt_target_ip` varchar(64) DEFAULT NULL,
  `url` varchar(1024) DEFAULT NULL,
  `create_t` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)  DEFAULT CHARSET=utf8;


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
)  DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pushrurl
-- ----------------------------


INSERT INTO `pushrurl` VALUES ('1', null, '1','default', '10', '', '2013-08-26 15:00:00', '20', 
'http://172.16.0.1/push/push1.html','172.16.0.1', '1', '2013-08-26 15:00:00',null,null,null,null);

INSERT INTO `pushrurl` VALUES ('2', null, '0','172.16.0.100', '10', null, '2013-08-26 15:00:00', 
'40', 'http://172.16.0.1/push/push2.html','172.16.0.1', '1', '2013-08-26 15:00:00',null,null,null,null);




## ----------------------------
## Table structure for device_act_history (wlsta)
## ----------------------------
DROP TABLE IF EXISTS `device_act_history`;
CREATE TABLE `device_act_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mac` varchar(36) NOT NULL,
  `status` varchar(64) NOT NULL,
  `firstseen` datetime NOT NULL,
  `lastseen` datetime DEFAULT NULL,
  `ssid` varchar(36) DEFAULT NULL,
  `create_t` datetime NOT NULL,             ## available in > mysql 5.6.5 DEFAULT NOW,
  PRIMARY KEY (`id`),
  KEY `mac` (`mac`)
)  DEFAULT CHARSET=utf8;


## ----------------------------
## Table structure for 802_11_packet (wlpkt)
## ----------------------------
DROP TABLE IF EXISTS `802_11_packet`;
CREATE TABLE `802_11_packet` (
  `id` int NOT NULL AUTO_INCREMENT,
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
  `frameproto` varchar(36) DEFAULT NULL,
  `chan` varchar(36) DEFAULT NULL,
  `create_t` datetime DEFAULT NULL,
  `src_ip_mac` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `packettime` (`pkttime`),
  KEY `mac` (`mac`)
)  DEFAULT CHARSET=utf8;


## ----------------------------
## Table structure for device_status (wlsta)
## ----------------------------
DROP TABLE IF EXISTS `device_status`;
CREATE TABLE `device_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mac` varchar(36) DEFAULT NULL,
  `ssid` varchar(36) DEFAULT NULL,
  `rssi` float DEFAULT NULL,
  `status` smallint DEFAULT NULL,
  `firstseen` datetime DEFAULT NULL,
  `lastseen` datetime DEFAULT NULL,
  `create_t` datetime DEFAULT NULL,
  'modify' datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mac` (`mac`)
) DEFAULT CHARSET=utf8;

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
  `userrole` varchar(30) default '0', #	不同角色，每个mac在每个userrole中有一个default userid #   100-代表 200-嘉宾 300-媒体 400-会务
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
  `cid` varchar(30) DEFAULT '000000',	#	证件号
  `ctype` varchar(10) DEFAULT NULL,	#	证件类别
  `regphone` varchar(30) DEFAULT NULL,	#	（预）注册所用的电话号码
  `captcha` varchar(10) DEFAULT NULL,	#	（预）注册所用的验证码
  `phone` varchar(30) DEFAULT NULL,	#	常用电话号码
  `backphone` varchar(30) DEFAULT NULL,	#	备用电话号码
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
  `pushflag` smallint  unsigned DEFAULT '1',
  PRIMARY KEY (`id`),	#	
  KEY `userid` (`userid`),	#	
  KEY `phone` (`phone`), #	
  KEY `usercode` (`usercode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;	#	

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
  `userrole` varchar(30) DEFAULT '0',	#	不同角色，每个mac在每个userrole中有一个default userid #   100-代表 200-嘉宾 300-媒体 400-会务
  `pntmaster` varchar(3) DEFAULT NULL,	#	积分主记录标识，100-此userid为主记录，一个mac只对一个userid积分
  `memo` varchar(128) DEFAULT NULL,	#	备注
  `srcip` varchar(64) DEFAULT NULL,	#	iserver字段
  `sender` varchar(36) DEFAULT NULL, 	#	iserver字段
  `netid` varchar(36) DEFAULT NULL, 	#	iserver字段
  `progid` varchar(36) DEFAULT NULL, 	#	iserver字段
  `updtime` datetime DEFAULT NULL,	#	记录更新时间
  `rectime` datetime DEFAULT NULL,	#	记录时间
  `pushflag` smallint  unsigned DEFAULT '1',
  PRIMARY KEY (`id`),	#	
  KEY `userid` (`userid`),	#	
  KEY `usercode` (`usercode`),	#	
  KEY `mac` (`mac`)
)  DEFAULT CHARSET=utf8;	#	

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
  `pushflag` smallint  unsigned DEFAULT '1',
  PRIMARY KEY (`id`),	#	
  KEY `userid` (`userid`),
  KEY `mac` (`mac`)
)  DEFAULT CHARSET=utf8;	#	


## ----------------------------
## Table structure for smspool
## ----------------------------
DROP TABLE IF EXISTS `smspool`;
CREATE TABLE `smspool` (
  `id` int NOT NULL AUTO_INCREMENT, 
  `msgtype` varchar(64) DEFAULT NULL, #短信type
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
)  DEFAULT CHARSET=utf8;

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
)  DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) DEFAULT CHARSET=utf8;


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
) DEFAULT CHARSET=utf8;


## ----------------------------
## Table structure for prodorder
## ----------------------------
DROP TABLE IF EXISTS `prodorder`;	#	products to be deliveried to user
CREATE TABLE `prodorder` (	#	
  `id` int NOT NULL AUTO_INCREMENT,	#	
  `userid` varchar(36) DEFAULT NULL,	#
  `username` varchar(36) DEFAULT NULL,	#	username	
  `srcid` int DEFAULT NULL,	#	iserver field
  `prodcode` varchar(10) DEFAULT NULL,	#	product code
  `prodname` varchar(36) DEFAULT NULL,	#	product name
  `prodtype` varchar(36) DEFAULT NULL,	#	product type 
  `prodspec` varchar(36) DEFAULT NULL,	#	product specification
  `proddesp` varchar(36) DEFAULT NULL,	#	product description
  `quan` decimal(10,2) DEFAULT NULL,	#	quantity of product
  `unit` varchar(36) DEFAULT NULL,	#	unit of product
  `pkg` varchar(36) DEFAULT NULL,	#	package of product
  `recipaddr` varchar(128) DEFAULT NULL,	#	recipient address
  `recipname` varchar(36) DEFAULT NULL,	#	recipient name
  `recipphone1` varchar(30) NOT NULL,	#	recipient phone number #1
  `recipphone2` varchar(30) DEFAULT NULL,	#	recipient phone number #2
  `recipemail` varchar(64) DEFAULT NULL,	#	recipient phone email
  `assignto` varchar(64) DEFAULT 'iserver',	#	processor of the order: iserver/local
  `delicode` varchar(36) NULL UNIQUE,	#	delivery code (link to delivery table)
  `delidesp` varchar(128) DEFAULT NULL,	#	delivery description
  `delimemo` varchar(128) DEFAULT NULL,	#	delivery memo
  `srcip` varchar(64) DEFAULT NULL,	#	iserver field
  `sender` varchar(36) DEFAULT NULL, 	#	iserver field
  `netid` varchar(36) DEFAULT NULL, 	#	iserver field
  `progid` varchar(36) DEFAULT NULL, 	#	iserver field
  `updtime` datetime DEFAULT NULL,	#	record updated time
  `rectime` datetime DEFAULT NULL,	#	record created time
  `pushflag` smallint  unsigned DEFAULT '1',
  PRIMARY KEY (`id`),	#	
  KEY `userid` (`userid`),	#	
  KEY `prodcode` (`prodcode`)	#	
) DEFAULT CHARSET=utf8;	
