FROM dunglas/frankenphp:1.12.7-php8.4-trixie

RUN install-php-extensions pdo_mysql intl zip opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . /app
RUN composer install --no-dev --optimize-autoloader --no-interaction

ENV SERVER_NAME=":80"
