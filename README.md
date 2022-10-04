# builder_laravel

This is a template repository used to build Laravel Applications for chiefbrob/builder

# Using Template

Copy `.env.example` to `.env`
Update `APP_NAME`, `APP_URL`
Update `MAIL_USERNAME` and  `MAIL_PASSWORD`
Update `config/app.php`
Update `public/manifest.json`
Update `resources/js/store/index.js`
Update Deploy Folder Notes

# Local Setup

MySQL required
Valet is required


```bash
valet link builder_laravel
```

THEN

```bash
valet secure builder_laravel
npm run hotssl
```

View site on https://builder_laravel.test 

# Pull changes to your repository

```bash
git remote add template git@github.com:chiefbrob/builder_laravel.git
git fetch template
git rebase template/master
```

# Run with docker-compose

Login Docker

`docker login`

Build Image

```bash
npm run production
docker-compose build
```

Test Image

`docker-compose up -d` and `docker-compose stop`

## Fix Style

```
composer check-style
composer fix-style
/vendor/bin/pint
```
