FROM php:8.4-fpm-alpine

RUN apk update
RUN apk add git yarn
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN chown -Rf www-data:www-data /var/www
RUN mkdir -p /opt/cache
RUN mkdir -p /opt/logs
RUN chown www-data:www-data /opt/logs
RUN chown www-data:www-data /opt/cache
RUN apk --no-cache add pcre-dev ${PHPIZE_DEPS} git openssh linux-headers icu-dev
RUN pecl install xdebug git
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl opcache pdo_mysql
RUN docker-php-ext-enable xdebug
RUN apk del pcre-dev ${PHPIZE_DEPS}
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

WORKDIR /var/www

EXPOSE 8001
CMD ["php-fpm"]