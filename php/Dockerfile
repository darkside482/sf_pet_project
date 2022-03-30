FROM php:fpm

RUN apt update && apt install -y git libpq-dev zip unzip libzip-dev \
	&& docker-php-ext-install pdo_pgsql pgsql zip

#install composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www