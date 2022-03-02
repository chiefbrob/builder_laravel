# builder_laravel

This is a template repository used to build Laravel Applications for chiefbrob/builder

# Local Setup

Valet is required

```bash
cd ~/Sites
valet park
```

OR

```bash
valet link laravel-builder
```

THEN

```bash
valet secure laravel-builder
```

# Pull changes to your repository

```bash
git remote add template git@github.com:chiefbrob/builder_laravel.git
git fetch template
git rebase template/master
```
