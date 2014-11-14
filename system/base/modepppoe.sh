#!/bin/bash 

ln  -sf   /media/ihostdata/sys/base/interfaces.pppoe  /etc/network/interfaces
ln  -sf  /media/ihostdata/sys/chilli/defaults.pppoe  /etc/chilli/defaults
cp  /media/ihostdata/sys/base/root.pppoe  /var/spool/cron/crontabs/root
chown  root:crontab  /var/spool/cron/crontabs/root
