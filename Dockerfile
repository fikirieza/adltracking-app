# Gunakan image PHP
FROM php:8.2-fpm

# Install dependensi sistem
RUN apt-get update && apt-get install -y \
    git curl zip unzip nodejs npm

# Set working dir
WORKDIR /var/www/html

# Copy composer & npm files
COPY composer.json composer.lock package.json package-lock.json ./

# Install PHP & JS dependencies
RUN composer install --no-dev --optimize-autoloader
RUN npm ci && npm run build

# Copy semua project
COPY . .

# Set permission (biar storage & cache bisa diakses)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
