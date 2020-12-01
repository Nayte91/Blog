FROM php:rc-fpm-alpine

RUN apk add --no-cache --update --virtual buildDeps build-base autoconf \
     && pecl install xdebug > /dev/null \
     && docker-php-ext-install pdo_mysql \
     && docker-php-ext-configure pdo_mysql \
     && apk del buildDeps build-base autoconf

WORKDIR /app