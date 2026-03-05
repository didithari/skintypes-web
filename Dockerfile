FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    netcat-openbsd

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create entrypoint script
RUN cat > /usr/local/bin/docker-entrypoint.sh << 'EOF'
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
EOF

RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose port 9000
EXPOSE 9000

ENTRYPOINT ["docker-entrypoint.sh"]
