#!/bin/bash

sed  -i  "s|@reboot sudo python /root/wlsp2iserver.py|#@reboot sudo python /root/wlsp2iserver.py|g"  /var/spool/cron/crontabs/root
sed  -i  "s|@reboot sudo python /root/user2iserver.py|#@reboot sudo python /root/user2iserver.py|g"  /var/spool/cron/crontabs/root


