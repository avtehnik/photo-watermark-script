# hadolint ignore=DL3007
FROM mlocati/php-extension-installer:latest as php-extension-installer
FROM php:7.1-fpm as php

# https://github.com/mlocati/docker-php-extension-installer
COPY --from=php-extension-installer /usr/bin/install-php-extensions /usr/bin/


USER root
RUN mkdir -p /srv/project && /etc/watermark && echo "memory_limit=512M" > "$PHP_INI_DIR/conf.d/memory.ini" &&  install-php-extensions imagick

COPY Pacifico.ttf /etc/watermark/Pacifico.ttf
COPY watermark /bin/watermark

ENV APP_STREAM_LOG php://stdout

WORKDIR /srv/project