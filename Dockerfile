FROM php:8.1.6-fpm-alpine

WORKDIR /var/www

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install extensions
RUN docker-php-ext-install -j$(nproc)  \
    pdo_mysql \
    opcache

RUN docker-php-ext-enable pdo_mysql opcache

COPY . /var/www
EXPOSE 9000

RUN composer install