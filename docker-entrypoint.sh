#!/bin/bash

# Install composer dependencies
composer install --no-interaction --optimize-autoloader

# Set permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Generate application key if not exists
if [ ! -f .env ]; then
    cp .env.example .env
fi

php artisan key:generate --force 2>/dev/null || true

# Run migrations
php artisan migrate --force 2>/dev/null || true

# Clear and cache config
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Start PHP-FPM
exec php-fpm
