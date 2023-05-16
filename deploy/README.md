# Deploy

This document describes deploying this application to a VPS using `git remote`. Ideally, the changes would be pushed from your local computer to the vps.

## Local Setup

- Clone the repository to your local machine.

- Add the git remote

```
git remote add prod ssh://root@chiefbrob.info:22/var/repo/on/builder-laravel
```

## Server setup

- Create checkout repository

```
mkdir /var/repo/builder-laravel
cd /var/repo/builder-laravel
git init --bare
cd hooks
nano post-receive
```

The `post-receive` file is a bash script that would be executed after updates received. Contents for post-receive are available [here](post-receive).

- Save the post-receive and make it executable:

```
chmod +x post-receive
```

- Create website folder

```
mkdir /var/www/builder-laravel
```

Inside it, create `.env` file.

- Create Nginx Server block

```
nano /etc/nginx/sites-enabled/builder-laravel
```

Contents of the server block are available [here](nginx-server-block)

- Verify nginx is properly configured

```
nginx -t
```

- Secure server with certbot - OPTIONAL

```
add-apt-repository -y ppa:certbot/certbot
apt-get update && apt-get install -y python3-certbot-nginx

certbot --nginx -d builder-laravel.on.chiefbrob.info
certbot renew --dry-run
```

## Finally

On local machine, push changes to your server

```
git push prod master
```

The first deployment may fail because of env issues. Log into server and generate keys `php artisan key:generate`

Setup Passport with `php artisan passport:install`
