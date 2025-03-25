FROM php:8.4-fpm-alpine

RUN apk update && \
    apk add git yarn && \
    apk --no-cache add pcre-dev ${PHPIZE_DEPS} git openssh linux-headers icu-dev shadow && \
    pecl install xdebug git && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl opcache pdo_mysql && \
    docker-php-ext-enable xdebug && \
    apk del pcre-dev ${PHPIZE_DEPS}

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN groupmod --gid 1000 www-data && \
    usermod --uid 1000 --gid 1000 www-data && \
    chown -Rf www-data:www-data /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN chmod +x /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /var/www

RUN mkdir -p /opt/cache && \
    mkdir -p /opt/logs && \
    chown www-data:www-data /opt/logs && \
    chown www-data:www-data /opt/cache

EXPOSE 8001
CMD ["php-fpm"]

USER www-data