#!/bin/bash

# Install composer
curl -sS https://getcomposer.org/installer | php
php composer.phar install --no-dev --optimize-autoloader

# Install npm & build
npm install
npm run build

# Laravel setup
cp .env.example .env
php artisan key:generate
php artisan config:clear