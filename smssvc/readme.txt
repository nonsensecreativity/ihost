
=========================================================
I. smsgen.py

run on ihost
nohup python smsgen.py

insert a sms record to ihost database every 3 seconds

Deployment：

cp  ./smsgen.py  /root/smsgen.py
cp  ./smsupload.xml  /root/smsupload.xml

###sql statement for ihost to insert a sms to be pushed
INSERT INTO `authsms` VALUES (NULL,NULL,'[Cert Code:]','951065','[Supported by:]','00-16-6D-C0-76-3C','192.168.10.10','18833500052',0,0,559435030,'2015-09-17 21:19:19',NULL,NULL,NULL,NULL,NULL);


=========================================================


=========================================================
II. sms2iserver.py

run on ihost
python sms2iserver.py

check ihost's database for new coming sms record every 1 second
and
push sms to iserver REST service
upstream iserver is defined in configupload.xml

REST service header & payload:

Content-Type: application/json;charset=UTF-8

{"id":0,"srcid":"104","prefix":"验证码测试Cert Code:","sms":"123457","postfix":"Supported by:紫光软件","mac":null,"ip":null,"phone":"18833500052","stat":0,"optflag":0,"token":null,"rectime":null,"sender":"node001","netid":"SSID-A","progid":"pushsms.py","optime":"2014-09-28T07:56:03.000+0800","sendtime":null}
 

Deployment：

cp  ./sms2iserver.py  /root/sms2iserver.py
cp  ./smsupload.xml  /root/smsupload.xml
echo "@reboot sudo python /root/sms2iserver.py &" >> /var/spool/cron/crontabs/root
==========================================================

