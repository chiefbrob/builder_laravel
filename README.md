# Laravel 10 Template

This template allows you to quickly start building laravel applications from scratch. php 8.1

[Demo](https://builder-laravel.on.chiefbrob.info)

[Hire Me](https://www.fiverr.com/share/xPWA7a)

[Buy me Coffee](https://www.buymeacoffee.com/chiefbrob)

## Features

- Full Authentication
- Admin & User Sections
- Blog
- Feature Flags - control new features
- Easy to deploy (Docker, VPS)
- Contact, Terms & Conditions & Privacy policy pages
- E-commerce shop
- Tests with PHPUnit and Jest
- GraphQL
- UI with [BootstrapVue](https://bootstrap-vue.org/)
- Tasks management
- Search Website Content

## Features WIP

- Language selector
- Mpesa Payment Gateway
- Offline apps
- Automation of deployment with Github
- Vite & Vue 3

## Available Feature Flags

Enable features `https://laravel.test/admin/feature_flags`

- shop
- blog
- languages
- teams

## Adding Features

You can easily create scaffolding for a new feature. i.e. Adding a new Resource like Contact

```
bash scaffold.sh Contact
```

This would create Controllers, Requests, TestFiles for both PHP & Vue and UI

# Using Template

Setup Environment

Copy `.env.example` to `.env`
Update `APP_NAME`, `APP_URL`
Update `MAIL_USERNAME` and `MAIL_PASSWORD`
Update `config/app.php`
Update `public/manifest.json`
Update `resources/views/header-links.blade.php`
Update deploy Folder Notes

## Local Setup

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

## Pull changes to your repository

```bash
git remote add template git@github.com:chiefbrob/builder_laravel.git
git fetch template
git rebase template/master
```

## Run with docker-compose

Login Docker

`docker login`

Build Image

```bash
npm run production
docker-compose build
```

Test Image

`docker-compose up -d` and `docker-compose stop`

## Testing

There are PHP Tests in the root `tests` folder and JavaScript Tests in `resources/js/tests`

To debug Backend tests, you need to install xdebug.

To debug Frontend tests using Jest on VSCode, select node.js then run script tdd.

With these you can add breakpoints and stop compiler to view variables

## Fix Style

```
composer check-style
composer fix-style
/vendor/bin/pint
```
