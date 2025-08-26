# Stage 1: Install PHP dependencies with Composer
FROM composer:2 as composer_stage
WORKDIR /app
COPY database/ database/
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist --no-dev --optimize-autoloader

# Stage 2 (เดิม): Final production image
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    libzip-dev \
    zip \
    postgresql-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql zip

# Setup working directory
WORKDIR /var/www/html

# --- แก้ไขลำดับตรงนี้ ---
# 1. คัดลอก Dependencies และโค้ดทั้งหมดเข้ามาก่อน
COPY --from=composer_stage /app/vendor/ ./vendor/
COPY . .

# 2. ค่อยทำการเปลี่ยน Permission
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
# --- สิ้นสุดการแก้ไข ---

# Copy Nginx & Supervisor configurations
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose port 80 for Nginx
EXPOSE 80

# Run Supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
