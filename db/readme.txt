空数据库文件

============================================================
radius
============================================================
radius server的用户数据库

如何使用：
1, 如果没有的话，创建数据库radius
echo "create database radius;" | mysql –u root –p

2, 把github上的数据库文件复制到工作位置
cp  -r  ./db/radius  /media/ihost/data/
chown -R  mysql:mysql  /media/ihost/data/radius

3, 用github上的数据库文件替代原文件
mv /var/lib/mysql/radius  /var/lib/mysql/radius.bak
ln  -sf  /media/ihostdata/data/radius   /var/lib/mysql/radius



============================================================
wlsp
============================================================
ihost的工作数据库,包含了
1, db.shcema/wlsp.sys.base.sql
2, db.shcema/wlsp.sys.ihost.sql
3, db.shcema/wlsp.sys.users.sql

如何使用：
1, 如果没有的话，创建数据库wlsp
echo "create database wlsp;" | mysql –u root –p

2, 把github上的数据库文件复制到工作位置
#cp  -r  ./db/wlsp  /media/ihost/data/
#chown -R  mysql:mysql  /media/ihost/data/wlsp

3, 用github上的数据库文件替代原文件
mv /var/lib/mysql/wlsp  /var/lib/mysql/wlsp.bak

# 理想情况，为了备份的目的，数据库文件放在/media/ihostdata/data下
# ln  -sf  /media/ihostdata/data/wlsp   /var/lib/mysql/wlsp
# 然而会务系统应用，要求数据库在/var/lib/mysql下，否则出错
cp  -r  ./db/wlsp  /var/lib/mysql/
chown -R  mysql:mysql  /var/lib/mysql/wlsp