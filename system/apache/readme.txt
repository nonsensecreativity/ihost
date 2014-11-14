Switch Web Server from nginx to apache

# 安装apache2
apt-get install apache2 apache2-doc apache2-utils
apt-get install libapache2-mod-php5 php5 php-pear php5-xcache

# 复制站点配置文件
wget https://github.com/usspupdates/ihost/blob/master/apache/wlsite
wget https://github.com/usspupdates/ihost/blob/master/apache/adminsite

cp  ./wlsite  /etc/apache2/sites-available/wlsite
cp  ./adminsite   /etc/apache2/sites-available/adminsite

# 激活站点配置文件
unlink  /etc/apache2/sites-enabled/000-default

ln  -sf  /etc/apache2/sites-available/wlsite  /etc/apache2/sites-enabled/000-default
ln  -sf  /etc/apache2/sites-available/adminsite  /etc/apache2/sites-enabled/001-admin


# 关nginx
update-rc.d  -f  nginx reomve
#insserv  -r nginx

# 开apache
update-rc.d  apache2 defaults
#insserv  -f  apache2
