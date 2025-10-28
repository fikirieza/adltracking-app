# Gunakan image resmi PHP dengan ekstensi Laravel
FROM php:8.2-fpm

# Install dependencies sistem
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy seluruh project ke container
COPY . .

# Install dependencies Laravel
RUN composer install --no-dev --optimize-autoloader

# Jalankan migration otomatis saat build
RUN php artisan migrate --force || true


# Set permissions
RUN chmod -R 777 storage bootstrap/cache

# Expose port (Render pakai $PORT)
EXPOSE 10000

# Jalankan Laravel dengan artisan serve
CMD php artisan serve --host 0.0.0.0 --port 10000

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT

