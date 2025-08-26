#!/usr/bin/env bash

# Exit on error
# บรรทัดนี้สำคัญมาก! ถ้าคำสั่งไหนพลาด ให้หยุด Build ทันที
set -o errexit

# Install dependencies (Render's native PHP environment does this automatically)
# composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Generate application key (ควรตั้งค่าใน Environment Variables แทน)
# php artisan key:generate --force

# Clear caches
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run database migrations
# ถ้าคำสั่งนี้ล้มเหลว 'set -o errexit' จะทำให้ Build ทั้งหมดหยุด และแสดง Error ใน Log
echo "Running database migrations..."
php artisan migrate --force