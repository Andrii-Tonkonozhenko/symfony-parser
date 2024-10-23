FROM php:8.2.0-fpm-alpine

# Install packages
RUN apk add --no-cache curl git build-base zlib-dev oniguruma-dev autoconf bash
RUN apk add --update linux-headers

RUN apk add --no-cache yaml-dev && \
    pecl install yaml && \
    docker-php-ext-enable yaml

RUN apk add icu-dev
RUN docker-php-ext-configure intl && docker-php-ext-install intl

# MySQL extension and MySQL dev libraries
RUN apk add --no-cache mysql-dev && docker-php-ext-install pdo pdo_mysql

# Nginx
RUN apk add --update --no-cache nginx
COPY ./docker/php-fpm/nginx.conf /etc/nginx/
RUN chown -Rf www-data:www-data /var/lib/nginx

# Supervisor
RUN apk add --no-cache supervisor
COPY ./docker/php-fpm/supervisord.conf /etc/supervisord.conf

# Configure non-root user.
ARG PUID=1000
ARG PGID=1000
RUN apk --no-cache add shadow && \
    groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

# Source code
RUN chown www-data:www-data /var/www
COPY --chown=www-data:www-data ./ /var/www
WORKDIR /var/www

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ARG BUILD_MODE=dev
RUN composer install --no-dev --no-interaction --no-progress --no-scripts --optimize-autoloader
RUN chown -R www-data:www-data /var/www/vendor/

EXPOSE 8080

CMD ["/bin/sh", "./docker/php-fpm/run.sh"]
