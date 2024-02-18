FROM php:8.2-fpm

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN apt-get update -y

RUN apt-get install -y libzip-dev unzip

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

WORKDIR /var/www

EXPOSE 9000
