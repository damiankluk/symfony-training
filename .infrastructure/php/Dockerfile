FROM php:8.3-fpm

RUN apt update \
    && apt-get install -y \
                libicu-dev \
                libpq-dev \
                libzip-dev \
                unzip \
                git \
                nano \
                bash

RUN docker-php-ext-install  \
    pdo \
    pdo_pgsql \
    intl \
    zip \
    opcache

RUN pecl install xdebug apcu
RUN docker-php-ext-enable xdebug apcu

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN useradd -ms /bin/bash dev
RUN chown -R dev:dev /var/www/html
USER dev

ENV COMPOSER_ALLOW_SUPERUSER=1
COPY ./app/composer.* ./

RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction
workdir /var/www/html
COPY ./app /var/www/html