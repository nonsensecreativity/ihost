�����ݿ��ļ�

============================================================
radius
============================================================
radius server���û����ݿ�

���ʹ�ã�
1, ���û�еĻ����������ݿ�radius
echo "create database radius;" | mysql �Cu root �Cp

2, ��github�ϵ����ݿ��ļ����Ƶ�����λ��
cp  -r  ./db/radius  /media/ihost/data/
chown -R  mysql:mysql  /media/ihost/data/radius

3, ��github�ϵ����ݿ��ļ����ԭ�ļ�
mv /var/lib/mysql/radius  /var/lib/mysql/radius.bak
ln  -sf  /media/ihostdata/data/radius   /var/lib/mysql/radius



============================================================
wlsp
============================================================
ihost�Ĺ������ݿ�,������
1, db.shcema/wlsp.sys.base.sql
2, db.shcema/wlsp.sys.ihost.sql
3, db.shcema/wlsp.sys.users.sql

���ʹ�ã�
1, ���û�еĻ����������ݿ�wlsp
echo "create database wlsp;" | mysql �Cu root �Cp

2, ��github�ϵ����ݿ��ļ����Ƶ�����λ��
#cp  -r  ./db/wlsp  /media/ihost/data/
#chown -R  mysql:mysql  /media/ihost/data/wlsp

3, ��github�ϵ����ݿ��ļ����ԭ�ļ�
mv /var/lib/mysql/wlsp  /var/lib/mysql/wlsp.bak

# ���������Ϊ�˱��ݵ�Ŀ�ģ����ݿ��ļ�����/media/ihostdata/data��
# ln  -sf  /media/ihostdata/data/wlsp   /var/lib/mysql/wlsp
# Ȼ������ϵͳӦ�ã�Ҫ�����ݿ���/var/lib/mysql�£��������
cp  -r  ./db/wlsp  /var/lib/mysql/
chown -R  mysql:mysql  /var/lib/mysql/wlsp