#!/bin/bash

apt-get update && apt-get install -y unzip curl libpq-dev

curl -sS https://getcomposer.org/installer | php
mv /var/www/composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer

docker-php-ext-install pdo pdo_pgsql

composer install

php artisan key:generate

php artisan migrate

php artisan serve --host=0.0.0.0 --port=80
