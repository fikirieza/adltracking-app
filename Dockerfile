# Gunakan base image PHP dengan Composer & NodeJS
FROM php:8.2-fpm

# Install dependencies sistem dan tools
RUN apt-get update && apt-get install -y \
    git curl zip unzip nodejs npm

# Install Composer (manual)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy composer & npm files terlebih dahulu (biar caching optimal)
COPY composer.json composer.lock package.json package-lock.json ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install JS dependencies dan build Vite
RUN npm ci && npm run build

# Copy semua project ke container
COPY . .

# Set permission agar Laravel bisa akses storage dan cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port Laravel
EXPOSE 8000

# Jalankan Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
