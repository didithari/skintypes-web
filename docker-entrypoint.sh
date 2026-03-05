#!/bin/bash

cd /var/www

# Fix git safe directory warning
git config --global --add safe.directory /var/www || true

# Install composer dependencies
composer install --no-interaction --optimize-autoloader --no-dev || true

# Set proper permissions
chown -R www-data:www-data /var/www
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
for i in {1..30}; do
    if nc -z db 3306 2>/dev/null; then
        echo "MySQL is ready!"
        break
    fi
    echo "MySQL not ready, waiting... ($i/30)"
    sleep 2
done

# Start PHP-FPM
exec php-fpm
