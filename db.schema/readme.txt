
=====================================
radius
=====================================
1, �������ݿ�radius
echo "create database radius;" | mysql �Cu root �Cp

2, ������ṹ
mysql �Cu root �Cp radius < /etc/freeradius/sql/mysql/schema.sql

3, �������ݿ��û�
mysql �Cu root �Cp radius < /etc/freeradius/sql/mysql/admin.sql

4, ������¼�û�
echo ��insert into radcheck (username, attribute, op, value) values (��user1��, ��Cleartext-Password��, ��:=��, ��password��);�� | mysql �Cu root �Cp radius



=====================================
wlsp
=====================================
1, �������ݿ�wlsp
echo "create database wlsp;" | mysql �Cu root �Cp

2, ������ṹ(base.sqlΪ������.ihost.sqlΪihost�ϵ���ͼ����������iserver���ã�)
mysql �Cu root �Cp  wlsp <  db.schema/wlsp.sys.base.sql
mysql �Cu root �Cp  wlsp <  db.schema/wlsp.sys.ihost.sql

3, �������ݿ��û�
mysql �Cu root �Cp  wlsp <  db.schema/wlsp.sys.users.sql