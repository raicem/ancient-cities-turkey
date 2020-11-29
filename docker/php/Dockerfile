FROM php:7.4-fpm

RUN apt-get update && apt-get install zip libzip-dev -y

RUN docker-php-ext-install -j$(nproc) pdo_mysql zip exif

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
