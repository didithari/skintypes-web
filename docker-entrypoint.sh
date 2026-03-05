#!/bin/bash
set -e

cd /var/www

# Install composer dependencies
echo "Installing dependencies..."
composer install --no-interaction --optimize-autoloader --no-dev

# Copy .env if not exists
if [ ! -f .env ]; then
    echo "Creating .env file..."
    cp .env.example .env
    php artisan key:generate --force
fi

# Set proper permissions
echo "Setting permissions..."
chown -R www-data:www-data /var/www
chmod -R 775 storage bootstrap/cache

# Start PHP-FPM
echo "Starting PHP-FPM..."
exec php-fpm
