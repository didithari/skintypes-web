#!/bin/bash

cd /var/www

# Fix git safe directory warning
git config --global --add safe.directory /var/www || true

# Install composer dependencies
composer install --no-interaction --optimize-autoloader --no-dev || true

# Set proper permissions
mkdir -p storage/app/public bootstrap/cache storage/framework/cache storage/framework/sessions storage/framework/testing storage/logs
mkdir -p storage/app/public/skins storage/app/public/products

# Create storage symlink properly
rm -rf public/storage 2>/dev/null || true
ln -s ../storage/app/public public/storage

# Fix all storage permissions
chmod -R 777 storage bootstrap/cache public/storage 2>/dev/null || true
chown -R www-data:www-data /var/www 2>/dev/null || true

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
