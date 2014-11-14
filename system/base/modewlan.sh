#!/bin/bash

ln -sf  /media/ihostdata/sys/base/interfaces.wlan  /etc/network/interfaces
ln  -sf  /media/ihostdata/sys/chilli/defaults.wlan  /etc/chilli/defaults
cp  /media/ihostdata/sys/base/root.wlan  /var/spool/cron/crontabs/root
chown  root:crontab  /var/spool/cron/crontabs/root
ln  -sf  /media/ihostdata/sys/base/iptab.sh.wlan  /root/iptab.sh
update-rc.d  hostapd defaults
