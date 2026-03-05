#!/bin/bash

# Initialize Let's Encrypt SSL certificates for skintypes.dev

domains=(skintypes.dev www.skintypes.dev)
email="admin@skintypes.dev"
staging=0 # Set to 1 for testing to avoid rate limits

echo "### Preparing directories..."
mkdir -p certbot/www
mkdir -p certbot/conf

echo "### Starting containers..."
docker compose up -d

echo "### Waiting for nginx to start..."
sleep 5

echo "### Requesting Let's Encrypt certificate..."
if [ $staging != "0" ]; then
    echo "### Using staging server (for testing)"
    docker compose run --rm certbot certonly --webroot -w /var/www/certbot \
        --staging \
        --email $email \
        --agree-tos \
        --no-eff-email \
        --force-renewal \
        -d ${domains[0]} -d ${domains[1]}
else
    echo "### Using production server"
    docker compose run --rm certbot certonly --webroot -w /var/www/certbot \
        --email $email \
        --agree-tos \
        --no-eff-email \
        -d ${domains[0]} -d ${domains[1]}
fi

if [ $? -eq 0 ]; then
    echo ""
    echo "### SSL Certificate generated successfully!"
    echo "### Now switching to HTTPS configuration..."
    
    # Backup current config
    cp nginx.conf nginx.conf.backup
    
    # Use SSL config
    cp nginx-ssl.conf nginx.conf
    
    echo "### Restarting nginx with SSL..."
    docker compose restart nginx
    
    echo ""
    echo "### Setup complete!"
    echo "### Your site should now be accessible at:"
    echo "###   https://skintypes.dev"
    echo "###   https://www.skintypes.dev"
else
    echo ""
    echo "### Certificate generation failed!"
    echo "### Please check the errors above."
    echo "### Make sure:"
    echo "###   1. Domains are pointing to this server"
    echo "###   2. Ports 80 and 443 are open"
    echo "###   3. Nginx is running: docker compose ps"
fi

echo ""
echo "### To renew certificates later, run: ./renew-ssl.sh"
