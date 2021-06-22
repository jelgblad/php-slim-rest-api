ARG PHP_VERSION='7.4'

FROM php:${PHP_VERSION}-alpine

WORKDIR /var/www

# Install PHP extensions
RUN docker-php-ext-install opcache

# Configure PHP
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY ./conf.d/* $PHP_INI_DIR/conf.d/
