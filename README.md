# Laravel Builder Template

This template allows you to quickly start building laravel applications from scratch.

[View Demo](https://builder-laravel.on.chiefbrob.info)

## Features

- Full Authentication
- Admin & User Sections
- Blog
- Feature Flags - control new features
- Easy to deploy (Docker, VPS)
- Contact, Terms & Conditions & Privacy policy pages
- E-commerce shop
- Language selector
- Tests with PHPUnit and Jest
- GraphQL
- UI with [BootstrapVue](https://bootstrap-vue.org/)

## Features WIP

- Tasks management
- Mpesa Payment Gateway
- Search Website Content
- Offline apps
- Automation of deployment with Github

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
Update `resources/js/store/index.js`
Update Deploy Folder Notes

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

## Fix Style

```
composer check-style
composer fix-style
/vendor/bin/pint
```
