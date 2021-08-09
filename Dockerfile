# hadolint ignore=DL3007
FROM mlocati/php-extension-installer:latest as php-extension-installer
FROM php:7.1-fpm as php

# https://github.com/mlocati/docker-php-extension-installer
COPY --from=php-extension-installer /usr/bin/install-php-extensions /usr/bin/


RUN mkdir /etc/watermark

RUN install-php-extensions imagick
COPY Pacifico.ttf /etc/watermark/Pacifico.ttf
COPY watermark /bin/watermark

RUN echo "memory_limit=512M" > "$PHP_INI_DIR/conf.d/memory.ini"

ENV APP_STREAM_LOG php://stdout

USER root
RUN mkdir -p /srv/project
WORKDIR /srv/project