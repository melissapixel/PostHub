ARG PHP_VERSION=8.2

FROM php:${PHP_VERSION}-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_pgsql pgsql

WORKDIR /app

EXPOSE 8000