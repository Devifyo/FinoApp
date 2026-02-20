FROM php:8.4-fpm-alpine

# Install essential system dependencies (Added libzip-dev here)
RUN apk add --no-cache git curl libpng-dev oniguruma-dev libxml2-dev zip unzip libzip-dev mysql-client
# Install PHP extensions (Added zip here)
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Force PHP-FPM to listen on IPv4 9000
RUN sed -i 's/listen = 127.0.0.1:9000/listen = 0.0.0.0:9000/g' /usr/local/etc/php-fpm.d/www.conf || true

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
RUN chown -R www-data:www-data /var/www

USER www-data