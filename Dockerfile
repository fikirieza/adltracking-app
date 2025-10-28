# Gunakan base image PHP FPM
FROM php:8.2-fpm

# Install dependency sistem dan extension PHP yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git curl zip unzip nodejs npm libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy file yang dibutuhkan untuk install dependencies dulu (cache-friendly)
COPY composer.json composer.lock ./

# Install dependency PHP
RUN composer install --no-dev --no-scripts --optimize-autoloader

# Copy semua file project
COPY . .

# Jalankan script artisan setelah semua file ada
RUN composer install --no-dev --optimize-autoloader

# Install dependency Node dan build Vite assets
RUN npm install && npm run build

# Set permission untuk Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 8000 untuk Laravel
EXPOSE 8000

# Jalankan Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
