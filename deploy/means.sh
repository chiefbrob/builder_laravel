#!/bin/sh
mkdir -p /var/www/means.on.chiefbrob.info
rm -f /etc/nginx/sites-enabled/default
cat <<EOF > /etc/nginx/sites-available/means.on.chiefbrob.info
server {
    listen 80;
    #listen [::]:80 default_server ipv6only=on;

    root /var/www/on/means/public;
    index index.php index.html index.htm index.nginx-debian.html;

    server_name means.on.chiefbrob.info;

    location / {
    try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ \.php$ {
      try_files $uri /index.php =404;
      fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
      fastcgi_index index.php;
      fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
      include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
EOF
mkdir -p /var/repo/means.on.chiefbrob.info.git
cd /var/repo/means.on.chiefbrob.info.git
git init --bare
cd hooks
cat <<EOF > post-receive
#!/bin/sh
Unset GIT_INDEX_FILE
git --work-tree=/var/www/means.on.chiefbrob.info --git-dir=/var/repo/means.on.chiefbrob.info.git checkout -f

cd /var/www/means.on.chiefbrob.info
chown -R :www-data .
chmod -R 777 .

composer install --no-dev
php artisan opcache:clear
php artisan migrate --force
php artisan optimize
npm run build
EOF
chmod +x post-receive
mysql
CREATE DATABASE builder_laravel;
CREATE USER 'clutchbagskenya'@'%' IDENTIFIED BY 'KenyYhd4887&9!';
GRANT ALL PRIVILEGES ON clutchbagskenya.* TO 'clutchbagskenya'@'%';
FLUSH PRIVILEGES;
exit;

cp .env.example .env
nano .env
//update url,environment, debug, mysql e.t.c
#RUN
nano config/app.php
//set url, timezone
#RUN
php artisan key:generate
php artisan config:cache
php artisan migrate
php artisan db:seed
composer dump-autoload
certbot --nginx -d means.on.chiefbrob.info
certbot renew --dry-run
// if you have passport installed 
php artisan passport:install

clear


