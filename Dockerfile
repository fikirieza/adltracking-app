# Gunakan image PHP dengan ekstensi yang dibutuhkan
FROM php:8.2-fpm

# Install dependensi sistem
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev zip curl && \
    docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copy file project
WORKDIR /var/www/html
COPY . .

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Jalankan migrate otomatis
RUN php artisan key:generate
RUN php artisan migrate --force || true

# Expose port untuk Railway
EXPOSE 8000

# Jalankan Laravel server
CMD php artisan serve --host=0.0.0.0 --port=8000
