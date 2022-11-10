FROM php:8.1.6-fpm-alpine

WORKDIR /var/www

RUN apk --update upgrade
RUN docker-php-ext-install -j$(nproc)  \
    pdo_mysql \
    opcache

COPY . /var/www
EXPOSE 9000

RUN docker-php-ext-enable opcache