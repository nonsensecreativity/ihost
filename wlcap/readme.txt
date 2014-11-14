============================================
** srksreset.py
============================================
掉电重启时
ihost先于ruckus ap启动
需要重设一次ruckus的抓包功能
============================================
1), copy srksreset.py to /root/srksreset.py
2), setup cron job
echo "@reboot sudo python /root/srksreset.py &" >> /var/spool/cron/crontabs/root


============================================
** srks.py
============================================
定期检查ruckus ap的packet capture功能
如果发现capture功能关闭，则杀掉ihost上的抓包进程，开启ruckus抓包功能
============================================
1), copy srks.py to /root/srks.py
2), setup cron job
echo "*/2 * * * * sudo python /root/srks.py &" >> /var/spool/cron/crontabs/root


============================================
** wdog.py
============================================
定期检查ihost抓包进程是否正常
如果发现异常，则重启抓包进程
============================================
1), copy wdog.py to /root/wdog.py
2), setup cron job
echo "*/1 * * * * sudo python /root/wdog.py &" >> /var/spool/cron/crontabs/root

============================================
** rdpp.py
============================================
把packet写入数据库；被wdog.py监视和启动
读取config.xml和filter.xml
============================================
1), copy rdpp.py to /root/rdpp.py
2), copy config.xml to /root/config.xml
3), copy filter.xml to /root/filter.xml



============================================
** onsite.py
============================================
从wlsta中查找usermacs中的用户
建立并维护useractive表
读configauth.xml
============================================
1), copy onsite.py to /root/onsite.py
2), setup cron job
echo "*/1 * * * * sudo python /root/onsite.py &" >> /var/spool/cron/crontabs/root



============================================
** onsitechk.py
============================================
检查useractive表，
根据configauth.xml中的时间阈值（秒）；此阈值应根据不同应用场景调整
复位onsite、online，以及把userid从useractive中移除
读configauth.xml
============================================
1), copy onsitechk.py to /root/onsitechk.py
2), setup cron job
echo "*/2 * * * * sudo python /root/onsitechk.py &" >> /var/spool/cron/crontabs/root



============================================
** smspush.py
============================================
自动发送短信给useractive中的用户
针对useractive中的userid，phone
从smspool里提取短信息
写入到authsms表，等待发送给用户
读configauth.xml
============================================
1), copy smspush.py to /root/smspush.py
2), setup cron job
echo "*/1 * * * * sudo python /root/smspush.py &" >> /var/spool/cron/crontabs/root

============================================
** greeting.py
============================================
测试用的smspool数据
早上和中午各一条短信在smspool中
读configauth.xml
============================================
1), copy greeting.py to /root/greeting.py
2), setup cron job
echo "0 */6 * * * sudo python /root/greeting.py &" >> /var/spool/cron/crontabs/root




==============================================
测试用数据：
INSERT INTO `wlsta` VALUES (NULL,11,0,'00:1B:77:1C:92:55','OPEN-WIFI',-1,300,NULL,0,now(),now(),0,8,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,now());
INSERT INTO smspool set msgid='1',cnduserrole='100',sms='welcome',stat='100';

