FROM php:8.3-fpm

RUN apt-get update && apt-get install -y zip libzip-dev unzip libpng-dev libjpeg62-turbo-dev libfreetype6-dev libonig-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo_mysql zip exif gd mbstring

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

COPY settings.ini /usr/local/etc/php/conf.d/settings.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ARG GROUP_ID=1000
ARG USER_ID=1000
ARG USERNAME=docker

RUN addgroup --gid $GROUP_ID $USERNAME
RUN adduser --disabled-password --gecos '' --uid ${USER_ID} --gid $GROUP_ID $USERNAME

USER $USERNAME

WORKDIR /var/www/html
