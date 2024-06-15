#!/bin/sh
mkdir -p /var/www/test.chiefbrob.info
rm -f /etc/nginx/sites-enabled/default
cat <<EOF > /etc/nginx/sites-available/test.chiefbrob.info
server {
    listen 80;
    root /var/www/test.chiefbrob.info/public;
    index index.php index.html index.htm;
    server_name test.chiefbrob.info;
    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }
    location ~ \.php$ {
        include snippets/fastcgi-php8.0.conf;
        # try_files $uri /index.php = 404;
        # fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
        # fastcgi_index index.php;
        # include fastcgi_params;
    }
}
EOF
cat <<EOF > /etc/nginx/snippets/fastcgi-php8.0.conf
fastcgi_split_path_info ^(.+\.php)(/.+)$;

try_files $fastcgi_script_name =404;

set $path_info $fastcgi_path_info;
fastcgi_param PATH_INFO $path_info;

fastcgi_index index.php;
include fastcgi_params;

fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
fastcgi_read_timeout 300;

EOF
ln -s /etc/nginx/sites-available/test.chiefbrob.info /etc/nginx/sites-enabled/test.chiefbrob.info 
cat <<EOF > /etc/nginx/fastcgi_params
fastcgi_param  SCRIPT_FILENAME    $document_root$fastcgi_script_name;
fastcgi_param   QUERY_STRING            $query_string;
fastcgi_param   REQUEST_METHOD          $request_method;
fastcgi_param   CONTENT_TYPE            $content_type;
fastcgi_param   CONTENT_LENGTH          $content_length;

fastcgi_param   SCRIPT_FILENAME         $document_root$fastcgi_script_name;
fastcgi_param   SCRIPT_NAME             $fastcgi_script_name;
fastcgi_param   PATH_INFO               $fastcgi_path_info;
fastcgi_param   PATH_TRANSLATED         $document_root$fastcgi_path_info;
fastcgi_param   REQUEST_URI             $request_uri;
fastcgi_param   DOCUMENT_URI            $document_uri;
fastcgi_param   DOCUMENT_ROOT           $document_root;
fastcgi_param   SERVER_PROTOCOL         $server_protocol;

fastcgi_param   GATEWAY_INTERFACE       CGI/1.1;
fastcgi_param   SERVER_SOFTWARE         nginx/$nginx_version;

fastcgi_param   REMOTE_ADDR             $remote_addr;
fastcgi_param   REMOTE_PORT             $remote_port;
fastcgi_param   SERVER_ADDR             $server_addr;
fastcgi_param   SERVER_PORT             $server_port;
fastcgi_param   SERVER_NAME             $server_name;

fastcgi_param   HTTPS                   $https;

# PHP only, required if PHP was built with --enable-force-cgi-redirect
fastcgi_param   REDIRECT_STATUS         200;
EOF
service nginx restart

mkdir -p /var/repo/test.chiefbrob.info.git
cd /var/repo/test.chiefbrob.info.git
git init --bare
cd hooks
cat <<EOF > post-receive
#!/bin/sh
Unset GIT_INDEX_FILE
git --work-tree=/var/www/test.chiefbrob.info --git-dir=/var/repo/test.chiefbrob.info.git checkout -f

cd /var/www/test.chiefbrob.info
chown -R :www-data .
chmod -R 777 .

composer install --no-dev
php artisan opcache:clear
php artisan migrate --force
php artisan optimize
npm run build
EOF
chmod +x post-receive

mysql -e "CREATE DATABASE builder_laravel"
mysql -e "CREATE USER 'builder_laravel'@'%' IDENTIFIED BY 'Kenya1sHome!'"
mysql -e "GRANT ALL PRIVILEGES ON builder_laravel.* TO 'builder_laravel'@'%'"
mysql -e "FLUSH PRIVILEGES"


cat <<EOF > .env
APP_NAME=BuilderLaravel
APP_ENV=local
APP_KEY=
APP_DEBUG=false
APP_URL=http://test.chiefbrob.info

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=builder_laravel
DB_USERNAME=builder_laravel
DB_PASSWORD=Kenya1sHome!

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DRIVER=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.eu.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=builder@mg.chiefbrob.info
MAIL_PASSWORD=null
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=builder@chiefbrob.info
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

EOF

php artisan key:generate
php artisan config:cache
php artisan migrate
php artisan db:seed
composer dump-autoload
certbot --nginx -d test.chiefbrob.info
certbot renew --dry-run

clear


