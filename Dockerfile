FROM php:8.2-apache

RUN apt-get update && apt-get install -y unzip \
    && docker-php-ext-install pdo pdo_mysql \
    && pecl install pcov \
    && docker-php-ext-enable pcov

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html