#!/usr/bin/env bash

cd /srv/www

echo "Checking if .env file exists"
if [ -f app/.env ]; then
    echo ".env exists"
else
    echo "Set up .env file"
    cp .env.local .env
fi

echo "Composer install"
composer install

echo "Generate app key"
php artisan key:generate

echo "Migrate database"
php artisan migrate
