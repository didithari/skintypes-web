#!/bin/bash

# Initialize Let's Encrypt SSL certificates for skintypes.dev

domains=(skintypes.dev www.skintypes.dev)
email="admin@skintypes.dev"
staging=0 # Set to 1 for testing to avoid rate limits

echo "### Preparing directories..."
mkdir -p certbot/www
mkdir -p certbot/conf

echo "### Creating temporary nginx config..."
cat > nginx-temp.conf << 'EOF'
server {
    listen 80;
    server_name skintypes.dev www.skintypes.dev;
    
    location /.well-known/acme-challenge/ {
        root /var/www/certbot;
    }
    
    location / {
        root /var/www/public;
        index index.html index.php;
        try_files $uri $uri/ /index.php?$query_string;
    }
}
EOF

echo "### Backing up nginx config..."
if [ -f nginx.conf ]; then
    cp nginx.conf nginx.conf.bak
fi

echo "### Using temporary nginx config..."
cp nginx-temp.conf nginx.conf

echo "### Starting nginx temporarily..."
docker compose up -d nginx

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
        -d ${domains[0]} -d ${domains[1]}
else
    echo "### Using production server"
    docker compose run --rm certbot certonly --webroot -w /var/www/certbot \
        --email $email \
        --agree-tos \
        --no-eff-email \
        -d ${domains[0]} -d ${domains[1]}
fi

echo "### Restoring original nginx config..."
if [ -f nginx.conf.bak ]; then
    mv nginx.conf.bak nginx.conf
else
    echo "Warning: No backup found, manual restoration may be needed"
fi

echo "### Restarting nginx with SSL config..."
docker compose restart nginx

echo ""
echo "### SSL Certificate setup complete!"
echo "### Your site should now be accessible at:"
echo "###   https://skintypes.dev"
echo "###   https://www.skintypes.dev"
echo ""
echo "### To renew certificates, run:"
echo "###   docker compose run --rm certbot renew"
