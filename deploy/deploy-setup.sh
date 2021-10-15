#!/bin/sh
mkdir -p /var/www/builder-laravel.on.chiefbrob.info
rm -f /etc/nginx/sites-enabled/default
cat <<EOF > /etc/nginx/sites-available/builder-laravel.on.chiefbrob.info
server {
    listen 80;
    root /var/www/builder-laravel.on.chiefbrob.info/public;
    index index.php index.html index.htm;
    server_name builder-laravel.on.chiefbrob.info;
    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }
    location ~ \.php$ {
            try_files $uri /index.php = 404;
            fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
            fastcgi_index index.php;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            include fastcgi_params;
    }
    location ~* \.(?:jpg|jpeg|gif|png|ico|cur|gz|svg|svgz|mp4|ogg|ogv|webm|htc|svg|woff|woff2|ttf)\$ {
        expires 1M;
        access_log off;
        add_header Cache-Control "public";
    }
}
EOF
mkdir -p /var/repo/builder-laravel.on.chiefbrob.info.git
cd /var/repo/builder-laravel.on.chiefbrob.info.git
git init --bare
cd hooks
cat <<EOF > post-receive
#!/bin/sh
Unset GIT_INDEX_FILE
git --work-tree=/var/www/builder-laravel.on.chiefbrob.info --git-dir=/var/repo/builder-laravel.on.chiefbrob.info.git checkout -f

cd /var/www/builder-laravel.on.chiefbrob.info
chown -R :www-data .
chmod -R 777 .

composer install --no-dev
php artisan opcache:clear
php artisan migrate --force
php artisan optimize
npm run production
EOF
chmod +x post-receive
mysql
CREATE DATABASE builder_laravel;
CREATE USER 'builder_laravel'@'%' IDENTIFIED BY 'Kenya1sHome!';
GRANT ALL PRIVILEGES ON builder_laravel.* TO 'builder_laravel'@'%';
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
certbot --nginx -d builder-laravel.on.chiefbrob.info
certbot renew --dry-run
// if you have passport installed 
php artisan passport:install

clear


