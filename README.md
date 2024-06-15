# Laravel 10 Template

### NOTE! Downgraded to 10 as tests are broken

This template allows you to quickly start building laravel applications from scratch. php 8.2

[Demo](https://builder-laravel.on.chiefbrob.info) | [Hire Me](https://www.fiverr.com/share/xPWA7a) | [Buy me Coffee](https://www.buymeacoffee.com/chiefbrob)

### In Use

[Means](https://means.dabotap.com) - Transport Platform

[Clutch Bags Kenya](https://clutchbagskenya.co.ke/) - Online shopping for ladies clutch bags

[Ifanye](https://ifanye.dabotap.com) - Tasks & Team work

[Starred Repos](http://starredrepos.on.chiefbrob.info/) - Fetch your Github Starred Repositories **opensource**

## Vue 3 Migration

This project would be updated to Vue 3 and Bootstrap Vue would be dropped.

## Quasar

V2 API is being built for [🔒 Quasar Builder](https://github.com/chiefbrob/quasar-builder). Links to various builds with it include:

- [Means App](https://app.means.dabotap.com)
- [Means Conductors App](https://conductors-app.means.dabotap.com)
- [Means Drivers Apk](https://bit.ly/means-drivers-app)
- [ClutchBagsKenya App](https://shop.on.clutchbagskenya.co.ke)

If you would want this, let me know :)

Separation of concerns is important.

## Features

- Full Authentication, Oauth2, Google Login
- Admin & User Sections
- Blog
- Feature Flags - control new features
- Easy to deploy (Docker, VPS)
- Contact, Terms & Conditions & Privacy policy pages
- E-commerce shop, cart, address manager
- Tests with PHPUnit and Jest
- GraphQL
- UI with [BootstrapVue](https://bootstrap-vue.org/)
- Tasks management
- Search Website Content
- WYSIWYG Editor
- Backup to Google [Read Tutorial](https://medium.com/@al_imran_ahmed/how-to-backup-your-laravel-application-in-google-drive-2803c31756a0) | [bugfix](https://github.com/masbug/flysystem-google-drive-ext/issues/77)

## Features WIP

- Language selector
- Mpesa Payment Gateway
- Offline apps
- Automation of deployment with GitHub
- Vite & Vue 3

## Setting Up Google Login

- Visit [Google Developers Console](https://console.developers.google.com/)
- New Project
- Setup OAuth consent screen
- Setup Credentials (OAuth Client ID)
- Add feature flag `socialite.google`

## Available Feature Flags

Enable features `https://laravel.test/admin/feature_flags`

- shop
- blog
- languages
- teams
- socialite.google

## Adding Features

You can easily create scaffolding for a new feature. i.e. Adding a new Resource like Contact

```
bash scaffold.sh Contact
```

This would create Controllers, Requests, and Test Files for both PHP & Vue and UI

# Using Template

Minimize editing existing HTML or code and instead extend Vue/PHP to minimize conflicts during rebase

### Setup Environment

Copy `.env.example` to `.env`
Update `APP_NAME`, `APP_URL`
Update `MAIL_USERNAME` and `MAIL_PASSWORD`
Update `config/app.php`
Update `public/manifest.json`
Update `resources/views/header-links.blade.php`
Update deploy Folder Notes
Setup passport

### Local Setup

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

## Deploying

Refer to [deploy/README.md](deploy/README.md)

## Run with docker-compose

Login Docker

`docker login`

Build Image

```bash
npm run build
docker-compose build
```

Test Image

`docker-compose up -d` and `docker-compose stop`

## Testing

There are PHP Tests in the root `tests` folder and JavaScript Tests in `resources/js/tests`

To debug Backend tests, you need to install xdebug.

To debug Frontend tests using Jest on VSCode, select node.js then run `npm run tdd`.

With these, you can add breakpoints and stop the compiler from viewing variables

## Fix Style

```
composer check-style
composer fix-style
/vendor/bin/pint
```
