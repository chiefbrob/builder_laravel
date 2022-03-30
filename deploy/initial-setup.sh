#!/bin/sh
apt update
#apt-get purge -y openssh-client
#apt-get install -y openssh-client
ufw --force enable
#ufw allow 80/tcp
#ufw allow 443/tcp
#ufw allow OpenSSH
add-apt-repository ppa:ondrej/php
DEBIAN_FRONTEND=noninteractive apt upgrade -y 
#ufw allow ssh
apt-get install -y fail2ban
apt install -y nginx
ufw allow 'Nginx FULL'
apt install -y mysql-server
#mysql_secure_installation
mysql -e "INSTALL COMPONENT 'file://component_validate_password'"
mysql -e "DELETE FROM mysql.user WHERE user=''"
mysql -e "DELETE FROM mysql.user WHERE user='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1')"
mysql -e "DROP DATABASE IF EXISTS test"
mysql -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test\\_%'"
mysql -e "FLUSH PRIVILEGES"
#secure_end
apt-get install -y php8.0 apache2- apache2-bin-
# apt-get install -y software-properties-common
# add-apt-repository -y ppa:ondrej/php
# apt-get update && apt-get install -y php-fpm
apt-get install -y unzip php-pear php8.0-curl php8.0-dev php8.0-gd php8.0-mbstring php8.0-zip php8.0-mysql php8.0-xml
service php8.0-fpm restart
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
add-apt-repository -y ppa:certbot/certbot
apt-get update && apt-get install -y python3-certbot-nginx
