# Oбраз для PHP

# Объявляем аргумент и задаем значение по умолчанию
ARG PHP_VERSION=8.2

# Используем аргумент в названии образа
FROM php:${PHP_VERSION}-cli

# Устанавливаем полезные расширения
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /app

EXPOSE 8000