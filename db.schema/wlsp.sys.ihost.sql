## Views and Triggers userd by ihost only 



## ----------------------------
## View structure for viewaction
## ----------------------------
DROP VIEW IF EXISTS `viewaction`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `viewaction` AS select `wlact`.`id` AS `id`,`wlact`.`event` AS `event`,`wlact`.`mac` AS `mac`,`wlact`.`firstseen` AS `firstseen`,`wlact`.`lastseen` AS `lastseen`,`wlact`.`rectime` AS `rectime`,`wlact`.`subevent` AS `subevent`,`wlact`.`oldvalue` AS `oldvalue`,`wlact`.`newvalue` AS `newvalue`,`wlact`.`stat` AS `stat`,`wlact`.`action` AS `action` from `wlact` order by `wlact`.`id` desc limit 150;

## ----------------------------
## View structure for viewstation
## ----------------------------
DROP VIEW IF EXISTS `viewstation`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `viewstation` AS select `wlsta`.`id` AS `id`,`wlsta`.`mac` AS `mac`,`wlsta`.`firstseen` AS `firstseen`,`wlsta`.`lastseen` AS `lastseen`,`wlsta`.`ssid` AS `ssid`,`wlsta`.`rssi` AS `rssi`,`wlsta`.`stat` AS `stat`,`wlsta`.`npacket` AS `npacket`,`wlsta`.`action` AS `action` from `wlsta`;

## ----------------------------
## Trigger structure for insrec
## ----------------------------
DELIMITER ;;
CREATE TRIGGER `insrec` AFTER INSERT ON `wlsta` FOR EACH ROW insert into wlact set  event = 'coming',subevent='stat',newvalue=NEW.stat, mac = NEW.mac,  stat=NEW.stat, action=NEW.action,firstseen=NEW.firstseen,lastseen=NEW.lastseen,ssid=NEW.ssid,rectime=now(),srcip=new.srcip;;
DELIMITER ;

## ----------------------------
## Trigger structure for chgrec
## ----------------------------
DELIMITER ;;
CREATE TRIGGER `chgrec` AFTER UPDATE ON `wlsta` FOR EACH ROW BEGIN

IF NEW.stat != OLD.stat THEN
    CASE NEW.stat

        WHEN '200' THEN SET @eventstr='staying';
        WHEN '300' THEN SET @eventstr='losting';
        ELSE  SET @eventstr='UNKNOWN';

    END CASE;
    insert into wlact set  event =@eventstr,subevent='stat',oldvalue=OLD.stat,newvalue=NEW.stat , mac = NEW.mac, stat=OLD.stat,action=OLD.action,firstseen=NEW.firstseen,lastseen=NEW.lastseen,ssid=NEW.ssid,rectime=now(),srcip=old.srcip;
ELSEIF NEW.action != OLD.action THEN

    set @tmp=' ';
END IF;
END;;
DELIMITER ;

## ----------------------------
## Trigger structure for delrec
## ----------------------------
DELIMITER ;;
CREATE TRIGGER `delrec` AFTER DELETE ON `wlsta` FOR EACH ROW insert into wlact set  event = 'gone', subevent='stat', mac = OLD.mac, stat= OLD.stat, action= OLD.action,firstseen=OLD.firstseen,lastseen= OLD.lastseen,ssid=OLD.ssid,rectime=now(),srcip=old.srcip;;
DELIMITER ;


