#!/bin/bash

# Install composer
curl -sS https://getcomposer.org/installer | php
php composer.phar install --no-dev --optimize-autoloader

# Build frontend
npm run build