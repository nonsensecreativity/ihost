﻿drop database if exists wms;
create database wms;
use wms;


## Tables for user registration
## and authentication
## used by ## local server and (or) central server
## This file is used by both ihost and iserver to set up database.

###############################################################
##1.  start from mysql 5.5, innodb is the default storage enginer
##2.  use unsigned
##3.  use NOT NULL if possible
##4.  use ENUM
##5.  table name in SINGULAR
## http://www.devshed.com/c/a/mysql/designing-a-mysql-database-tips-and-techniques/
###############################################################

###############################################################
# user_info
###############################################################
CREATE TABLE if not exists user_info (
    id             VARCHAR(36)       primary key NOT NULL,
    first_name     varchar(20)       DEFAULT NULL,	        #	名字 
    last_name      varchar(20)       DEFAULT NULL,	        #	姓   
    email          varchar(64)       NOT NULL DEFAULT '',
    byear          smallint          DEFAULT NULL,	        #	生日，年 // move to user_info. It can be obtained in different ways.
    bmonth         smallint          DEFAULT NULL,	        #	生日，月
    bday           smallint          DEFAULT NULL,	        #	生日，日
    gender         varchar(8)        NOT NULL DEFAULT 'M',	#	性别  //user info.
    occupation     varchar(30)       NOT NULL DEFAULT '',	#	职业 // user info
    company        varchar(64)       DEFAULT NULL,	        #	工作单位 //user info
    title          varchar(32)       DEFAULT NULL,	        #	职务 // user info.
    cid            varchar(30)       DEFAULT '000000',	    #	证件号, cid + ctype
    ctype          varchar(10)       DEFAULT NULL,	        #	证件类别 //remove.
    address        varchar(128)      DEFAULT NULL,	        #	地址 // to memo
    location       varchar(32)       DEFAULT NULL,	        #	所在区域 //to memo
)  DEFAULT CHARSET=utf8;



#############################################################
# account
#############################################################
##1，account base on ihost
##2，基于业务逻辑的上传，集中到iserver（与基于统计分析的上传不同）
##3，在另一个ihost上创建account时，可以选择下载，实现同步。如果不选择下载，则不同步（user account不同步不影响数据分析层面的identification）
CREATE TABLE if not exists account (
    id               VARCHAR(36)     primary key,                       #   id int unsigned NOT NULL auto_increment primary key, the same user can have differennt account at different ihost
    phone            varchar(30)     DEFAULT NULL,	                    #	常用电话号码 , mobile phone number for receiving sms., one account --> one phone number
    password         varchar(20)     DEFAULT ''                         #   password use for secure login, optional, try mac/password login first. For internal users
    point            int not null    DEFAULT '0',	                    #	userid下的积分 ?? better name
    factor           int not null    DEFAULT '1000',	                #	points转integral的因子，1000代表1 // put it together with integral in a separate table
    originator       varchar(36)     DEFAULT ''                         #   id of the agnet who creates this account
    hint             varchar(30)     NOT NULL,                          #   required for recover or change account, for example change phone number
    user_info_id     VARCHAR(36)     NOT NULL DEFAULT '',               #   foreign key to user_info table.
    sent_to_server   boolean         NOT NULL DEFAULT 0,                #   ?? flag for syn with iserver
    enabled          boolean         NOT NULL default 0,                #   for Admin usage
    create_t         datetime        DEFAULT NULL,	                    #	记录时间
    modify_t         datetime        DEFAULT NULL,	                    #	记录更新时间
    unique index account_idx1 (phone)
    foreign key    (user_info_id)    references user_info (id),
) DEFAULT CHARSET=utf8;

# one phone number mapping to an account, but it could be mapped to multiple mac
# pre_register table
# http://www.onurguzel.com/storing-mac-address-in-a-mysql-database/
#############################################################
# phone_mac
#############################################################
CREATE TABLE if not exists phone_mac (
    id            smallint unsigned  NOT NULL auto_increment primary key,
    phone         varchar(30)        NOT NULL,
    mac           BIGINT UNSIGNED    NOT NULL,
#    token         int UNSIGNED       NOT NULL,                         #   history. use the latest to verify account, sms 上网码/
    password      VARCHAR(36)        NOT NULL,                          #   password for mac/pw login
    smscheck      boolean            NOT NULL default 0,                #   if the user needs to be verified by sms
    enabled       boolean            NOT NULL default 0,                #   if false, disable the account login with mac/password, user login with phone/pw
    create_t      datetime           NOT NULL,
    modify_t      datetime           DEFAULT NULL
)DEFAULT CHARSET=utf8;

#############################################################
# token
#############################################################
create TABLE if not exists token (
    id            smallint unsigned  NOT NULL auto_increment primary key,
    phone         varchar(30)        NOT NULL,
    token         int UNSIGNED       NOT NULL,                          
    agent_id      varchar(36)        NOT NULL,
    create_t      datetime           NOT NULL,
    used          boolean            NOT NULL default 0
) DEFAULT CHARSET=utf8;

#############################################################
# role
#############################################################
CREATE TABLE if not exists role (
    id      smallint unsigned        NOT NULL auto_increment primary key,
    name    varchar(50)              NOT NULL                               #manager, agent, service, customer  4 roles
) DEFAULT CHARSET=utf8;

#############################################################
# permission
#############################################################
CREATE TABLE if not exists permission (
    id      smallint unsigned        NOT NULL auto_increment primary key,
    name    varchar(50)              NOT NULL
) DEFAULT CHARSET=utf8;


#############################################################
# account_role
#############################################################
CREATE TABLE if not exists account_role (
    id             int unsigned        NOT NULL auto_increment primary key,
    account_id     VARCHAR(36)         NOT NULL,
    role_id        smallint unsigned   NOT NULL,
    foreign key    (account_id)        references account (id),
    foreign key    (role_id)           references role (id),
    unique index   account_role_idx1   (account_id, role_id)
) DEFAULT CHARSET=utf8;


#############################################################
# role_permission
#############################################################
CREATE TABLE if not exists role_permission (
    id             smallint unsigned     NOT NULL auto_increment primary key,
    role_id        smallint unsigned     NOT NULL,
    permission_id  smallint unsigned     NOT NULL,
    foreign key    (role_id)             references role (id),
    foreign key    (permission_id)       references permission (id),
    unique index   role_permission_idx1  (role_id, permission_id)
) DEFAULT CHARSET=utf8;

#############################################################
# reception
#############################################################
CREATE TABLE if not exists reception (
    id             smallint unsigned     NOT NULL auto_increment primary key,
    agent_id       varchar(36)           NOT NULL,                             # this is binded with the phone which records the audio, account id
    person_cnt     smallint unsigned     NOT NULL default 1,
    gender         enum('F','M')         NOT NULL default 'F',       # for example 3M2F
    customer_name  varchar(30)           NOT NULL default '',
    phone          varchar(20)           NOT NULL default '',
    location       varchar(30)           NOT NULL default '',
    transport      varchar(20)           NOT NULL default '',                 #到店方式: closed sets?
    intention      varchar(20)           NOT NULL default '',                 #来店目的：咨询新车/预约提车/其他 ；选择或者新建，可维护
    visit_index    smallint unsigned     NOT NULL default 1,                  #来店频率：初次/再次；选择或者新建，可维护
    refer_source   varchar(20)           NOT NULL default "",                 #客户来源：报纸/杂志/电视/电台/网络/户外广告/车展/朋友介绍/路过；选择或者新建，可维护     
    car_usage      enum('private', 'gov', 'all') NOT NULL default 'private',
    car_style      varchar(20)           NOT NULL default '',
    car_model      varchar(20)           NOT NULL default '',
    car_color      varchar(4)            NOT NULL default '',
    buy_level      enum('A','B','C','D') NOT NULL default 'A',                #意向级别：A/B/C/D；选择或者新建，可维护
    description    varchar(200)          NOT NULL default '',                 #接待经过：调查问卷/试乘试驾/报价；选择或者新建，可维护
    result         varchar(100)          NOT NULL default '',                 #接待结果：信息留存/签单/提车；选择或者新建，可维护
    comparison     varchar(150)          NOT NULL default '',                 #竞品对比：输入内容，可口述录音, path to audio file or text??
    memo           varchar(150)          NOT NULL default '',                 #备注：输入内容，可口述录音 audio or text
    status         enum('new', 'update', 'delete') NOT NULL default 'new'      # 新建，更新，删除
    sibling        smallint unsigned,    NOT NULL default 0,                  # id of reception which occurs after current reception in time
    start_t        datetime              NOT NULL,                            #when record button is pressed
    end_t          datetime              default NULL                         #when reception ends, agent opens the app, press the "stop recording"
    foreign key    (agent_id)            references account (id),    
) DEFAULT CHARSET=utf8;

#############################################################
# recpt_activity
#############################################################
create table if not exists recpt_activity (
     id              smallint unsigned      NOT NULL auto_increment primary key,
     reception_id    smallint unsigned      NOT NULL auto_increment primary key,
     resource_type   varchar(10)            NOT NULL default '',                  #mac address, photo, audio etc.
     resource_info   varchar(25)            NOT NULL default ''                   #possible id, description
) default CHARSET=utf8



## ----------------------------------------------------------
## Table structure for first_appearance (old mac_ip table)
## table for local server to keep a record of the first visit of device
## mapping mac to local ip address in the local network
## ----------------------------------------------------------
#############################################################
# first_appearance
#############################################################
CREATE TABLE if not exists first_appearance (
    id                int UNSIGNED          NOT NULL AUTO_INCREMENT,
    device_mac        BIGINT UNSIGNED       DEFAULT NULL,                   #when wms receives the url from Chili, create a record here
    device_ip         varchar(64)           DEFAULT NULL,
    from_who          varchar(36)           DEFAULT NULL,                   #from_who, chili
    hotspot_ip        varchar(64)           DEFAULT NULL,
    userurl           varchar(1024)          DEFAULT NULL,
    create_t          datetime              DEFAULT NULL,
    PRIMARY           KEY                   (id),
    KEY               `device_mac`          (`device_mac`),
    KEY               `device_ip`           (`device_ip`)
)  DEFAULT CHARSET=utf8;


##
## Tables for network visit and action recording (wlcap version)
#############################################################
# device_ipvisit
#############################################################
CREATE TABLE if not exists device_ipvisit (
   id int             UNSIGNED              NOT NULL AUTO_INCREMENT,
   pkt_time           datetime              NOT NULL,
   pkt_time_ms        SMALLINT UNSIGNED     DEFAULT NULL,
   pkt_src_mac        BIGINT UNSIGNED           DEFAULT NULL,
   pkt_src_ip         varchar(64)           DEFAULT NULL,
   pkt_target_ip      varchar(64)           DEFAULT NULL,
   url                varchar(1024)         DEFAULT NULL,
   create_t           datetime              DEFAULT NULL,
  PRIMARY KEY (`id`)
)  DEFAULT CHARSET=utf8;



## ----------------------------
## Table structure for device_act_history (wlsta)
#############################################################
# device_act_history
#############################################################
CREATE TABLE IF not EXISTS device_act_history (
  `id`          int             NOT NULL AUTO_INCREMENT primary key,
  `mac`         BIGINT UNSIGNED NOT NULL,
  `status`      varchar(64)     NOT NULL,
  `firstseen`   datetime        NOT NULL,
  `lastseen`    datetime        DEFAULT NULL,
  `ssid`        varchar(36)     DEFAULT NULL,
  `create_t`    datetime        NOT NULL,             ## available in > mysql 5.6.5 DEFAULT NOW,
  KEY           `mac`           (`mac`)
)  DEFAULT CHARSET=utf8;


## ----------------------------
## Table structure for 802_11_packet (wlpkt)
#############################################################
# 802_11_packet
#############################################################
CREATE TABLE if not exists `802_11_packet` (
  `id`           int            NOT NULL AUTO_INCREMENT primary key,
  `mac`          BIGINT UNSIGNED    DEFAULT NULL,
  `ssid`         varchar(36)    DEFAULT NULL,
  `rssi`         smallint       DEFAULT NULL,
  `stat`         tinyint        DEFAULT NULL,
  `type`         varchar(36)    DEFAULT NULL,
  `subtype`      varchar(36)    DEFAULT NULL,
  `pmac`         BIGINT UNSIGNED    DEFAULT NULL,
  `bssid`        varchar(36)    DEFAULT NULL,
  `pkttime`      datetime       DEFAULT NULL,
  `timefrac`     float          DEFAULT NULL,
  `frameproto`   varchar(36)    DEFAULT NULL,
  `chan`         varchar(36)    DEFAULT NULL,
  `create_t`     datetime       DEFAULT NULL,
  `src_ip_mac`   BIGINT UNSIGNED    DEFAULT NULL,
  KEY `packettime` (`pkttime`),
  KEY `mac` (`mac`)
)  DEFAULT CHARSET=utf8;


## ----------------------------
## Table structure for device_status (wlsta)
#############################################################
# device_status
#############################################################
CREATE TABLE if not exists device_status (
  `id`            int            NOT NULL AUTO_INCREMENT,
  `mac`           BIGINT UNSIGNED    DEFAULT NULL,
  `ssid`          varchar(36)    DEFAULT NULL,
  `rssi`          float          DEFAULT NULL,
  `status`        smallint       DEFAULT NULL,
  `firstseen`     datetime       DEFAULT NULL,
  `lastseen`      datetime       DEFAULT NULL,
  `create_t`      datetime       DEFAULT NULL,
  modify_t        datetime       DEFAULT NULL,
  PRIMARY KEY     (`id`),
  KEY             `mac` (`mac`)
) DEFAULT CHARSET=utf8;

#############################################################
# ihost
#############################################################
CREATE TABLE if not exists ihost (
   id             VARCHAR(36)       primary key NOT NULL,
   name           varchar(20)       not null DEFAULT '',
   city           varchar(36)       not null DEFAULT '',
   brand          varchar(36)       not null DEFAULT '',
   create_t       datetime          not NULL,
   modify_t       datetime          DEFAULT NULL,
   PRIMARY KEY     (`id`),
) DEFAULT CHARSET=utf8;

