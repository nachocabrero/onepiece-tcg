FROM composer:2 AS vendor

WORKDIR /app

COPY . .
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --optimize-autoloader \
    --ignore-platform-req=php

FROM php:8.3-fpm-alpine AS app

ARG APP_ENV=production

RUN apk add --no-cache \
        libzip-dev \
        icu-dev \
        libxml2-dev \
        oniguruma-dev \
        sqlite-dev \
    && docker-php-ext-install \
        pdo_sqlite \
        mbstring \
        intl \
        zip \
        opcache \
        bcmath \
    && apk add --no-cache \
        libzip \
        icu \
        libxml2 \
        oniguruma \
        sqlite \
    && docker-php-ext-enable pdo_sqlite mbstring intl zip opcache bcmath

WORKDIR /var/www/html

COPY . .
COPY --from=vendor /app/vendor ./vendor

RUN chown -R www-data:www-data storage bootstrap/cache database \
    && mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views \
    && chown -R www-data:www-data storage/framework \
    && mkdir -p /app-seed \
    && cp database/database.sqlite /app-seed/database.sqlite

COPY docker/php.ini /usr/local/etc/php/conf.d/app.ini
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]
