FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    ssh \
    curl \
    nodejs \
    npm

RUN docker-php-ext-install pdo_mysql pdo mysqli

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

WORKDIR /usr/share/nginx/html

RUN npm install -g pnpm
