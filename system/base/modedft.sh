#!/bin/bash
ln  -sf  /media/ihostdata/sys/base/interfaces.eth  /etc/network/interfaces
ln  -sf  /media/ihostdata/sys/chilli/defaults.eth  /etc/chilli/defaults
cp  /media/ihostdata/sys/base/root.eth  /var/spool/cron/crontabs/root
chown  root:crontab  /var/spool/cron/crontabs/root
ln  -sf  /media/ihostdata/sys/base/iptab.sh.eth  /root/iptab.sh
update-rc.d -f hostapd remove
