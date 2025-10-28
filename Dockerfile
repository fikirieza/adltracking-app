# Gunakan image PHP
FROM php:8.2-fpm

# Install dependensi
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev zip curl && \
    docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

WORKDIR /var/www/html
COPY . .

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# 🔧 Tambahan penting: copy .env.example jadi .env
RUN cp .env.example .env

# Generate app key & migrate
RUN php artisan key:generate
RUN php artisan migrate --force || true

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
