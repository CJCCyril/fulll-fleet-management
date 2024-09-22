FROM php:8.3.7-fpm-alpine

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN apk update && apk add --no-cache bash=5.2.26-r0
RUN set -eux; \
    install-php-extensions @composer pdo_pgsql
