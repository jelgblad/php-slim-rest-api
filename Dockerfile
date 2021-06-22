ARG PHP_VERSION='7.4'

#
# PHP Dependencies
#
FROM composer:latest as vendor
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer install \
  --ignore-platform-reqs \
  --no-interaction \
  --no-plugins \
  --no-scripts \
  --prefer-dist \
  --no-dev

#
# Application
#
FROM php:${PHP_VERSION}-apache

# Install PHP extensions
RUN docker-php-ext-install opcache

# Enable apache modules
RUN a2enmod actions rewrite

# Set apache root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Configure PHP
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY docker/php/conf.d/* $PHP_INI_DIR/conf.d/

# Copy app code
COPY . .
COPY --from=vendor /app/vendor/ ./vendor/
