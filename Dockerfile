FROM php:8.1-cli

RUN apt-get update \
    && apt-get install --no-install-recommends -y \
        git \
        libzip-dev \
        make \
        p7zip-full \
        unzip

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer

RUN docker-php-ext-install \
        zip \
        sockets
