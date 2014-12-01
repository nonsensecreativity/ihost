============================================
** sta2pnt.py
============================================
为wlsta中的mac，记录积分到userpoints表
每分钟更新一次
读取configpnt.xml
userpoints表中第一次出现的mac，记录firstseen分值
之后每次累加step分值
============================================
** pnt2sta.py
============================================
结合useractive表
把针对mac地址的积分，转移到useraccounts表中
每10分钟更新一次
读取configpnt.xml
============================================

/usr/src/ihost/git pull
/usr/src/ihostupd/git pull
cp  -r  /usr/src/ihost/userpnt  /media/data/ihost/userpnt
ln  -sf  /media/data/ihost/userpnt/configpnt.xml  /root/configpnt.xml
ln  -sf  /media/data/ihost/userpnt/sta2pnt.py  /root/sta2pnt.py
ln  -sf  /media/data/ihost/userpnt/pnt2user.py  /root/pnt2user.py
# prepare database tables
mysql -uroot -p  wlsp <  /usr/src/ihostupd/db/tb4userpnt.sql
# setup cron job
echo "*/1 * * * * sudo python /root/sta2pnt.py &" >> /var/spool/cron/crontabs/root
echo "*/10 * * * * sudo python /root/pnt2user.py &" >> /var/spool/cron/crontabs/root

