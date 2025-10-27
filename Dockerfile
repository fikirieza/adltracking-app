# Gunakan image PHP
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git zip unzip curl libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy semua file project
COPY . .

# Install dependencies Laravel
RUN composer install --no-dev --optimize-autoloader

# Set permission folder storage & bootstrap/cache
RUN chmod -R 777 storage bootstrap/cache

# Jalankan Laravel dengan PHP built-in server
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000

EXPOSE 10000
