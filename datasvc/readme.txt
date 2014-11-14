====================================
push data from ihost to iserver
====================================

1, copy wlspupload.xml to /root/
2, copy wlsp2iserver.py to /root/
3, corntab job
# setup cron job
echo "@reboot sudo python /root/wlsp2iserver.py &" >> /var/spool/cron/crontabs/root
- or -
crontab -e
@reboot sudo python /root/wlsp2iserver.py &

重启ihost
进入iserver检查上传结果

ssh to 182.92.195.40

root

bash  /root/chkdb.sh
