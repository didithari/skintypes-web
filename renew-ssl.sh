#!/bin/bash

# Renew SSL certificates

echo "### Renewing SSL certificates..."
docker compose run --rm certbot renew

echo "### Reloading nginx..."
docker compose exec nginx nginx -s reload

echo "### SSL certificates renewed successfully!"
