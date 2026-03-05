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

# Create SQLite database if not exists
if [ ! -f database/database.sqlite ]; then
    echo "Creating SQLite database..."
    touch database/database.sqlite
fi

# Set proper permissions
echo "Setting permissions..."
chown -R www-data:www-data /var/www
chmod -R 775 storage bootstrap/cache database
chmod 664 database/database.sqlite

# Run migrations
echo "Running migrations..."
php artisan migrate --force 2>/dev/null || true

# Clear cache
php artisan config:clear
php artisan cache:clear

# Start PHP-FPM
echo "Starting PHP-FPM..."
exec php-fpm
