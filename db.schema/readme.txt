
=====================================
radius
=====================================
1, 创建数据库radius
echo "create database radius;" | mysql –u root –p

2, 创建表结构
mysql –u root –p radius < /etc/freeradius/sql/mysql/schema.sql

3, 创建数据库用户
mysql –u root –p radius < /etc/freeradius/sql/mysql/admin.sql

4, 创建登录用户
echo “insert into radcheck (username, attribute, op, value) values (‘user1’, ‘Cleartext-Password’, ‘:=’, ‘password’);” | mysql –u root –p radius



=====================================
wlsp
=====================================
1, 创建数据库wlsp
echo "create database wlsp;" | mysql –u root –p

2, 创建表结构(base.sql为基本表.ihost.sql为ihost上的视图、触发器（iserver不用）)
mysql –u root –p  wlsp <  db.schema/wlsp.sys.base.sql
mysql –u root –p  wlsp <  db.schema/wlsp.sys.ihost.sql

3, 创建数据库用户
mysql –u root –p  wlsp <  db.schema/wlsp.sys.users.sql
