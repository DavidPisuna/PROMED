#!/bin/bash
git pull origin main
composer install --no-interaction
php artisan optimize:clear
npm run build
php artisan optimize
