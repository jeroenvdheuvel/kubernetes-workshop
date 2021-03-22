FROM php:8.0-fpm

RUN apt-get update \
    && apt-get install -y \
        libfcgi-bin \
    && rm -rf /var/lib/apt/lists/*

COPY *.php /var/www/html/
