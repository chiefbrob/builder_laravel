#!/bin/sh

# Prevents sending non production push & failing tests
npm i
npm run production
npm test
if [ $? -ne 0 ]; then
    echo "npm tests failed."
    exit 1
fi

# Run PHP tests (assuming you use PHPUnit)
composer install --no-progress --prefer-dist --optimize-autoloader
vendor/bin/phpunit
if [ $? -ne 0 ]; then
    echo "PHP tests failed."
    exit 1
fi

# Commit only JS files
git add .
git commit  --no-verify -m "Commit Run Prod"
git push