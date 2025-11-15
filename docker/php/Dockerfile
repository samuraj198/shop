FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    zip unzip curl git libpq-dev libonig-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/laravel