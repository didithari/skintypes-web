# Docker Build & Deploy Quick Start

## Build dan Deploy

```bash
# 1. Rebuild containers
sudo docker compose down
sudo docker compose build --no-cache
sudo docker compose up -d

# 2. Cek status
sudo docker compose ps

# 3. Cek logs jika ada error
sudo docker compose logs app
sudo docker compose logs nginx

# 4. Run migrations
sudo docker compose exec app php artisan migrate --force

# 5. Set permissions
sudo docker compose exec app chown -R www-data:www-data /var/www
sudo docker compose exec app chmod -R 775 storage bootstrap/cache
```

## Setup SSL (Setelah containers running)

```bash
# 1. Pastikan domain sudah pointing ke server
nslookup skintypes.dev
nslookup www.skintypes.dev

# 2. Generate SSL certificate
chmod +x init-letsencrypt.sh
sudo ./init-letsencrypt.sh

# 3. Jika berhasil, situs sudah bisa diakses via HTTPS
```

## Troubleshooting

### Container restart terus
```bash
sudo docker compose logs app -f
```

### MySQL connection refused
Pastikan di `.env`:
```
DB_HOST=db
DB_PORT=3306
DB_DATABASE=skintypes
DB_USERNAME=root
DB_PASSWORD=root
```

### Permission denied
```bash
sudo docker compose exec app chown -R www-data:www-data /var/www
sudo docker compose exec app chmod -R 775 storage bootstrap/cache
```

### SSL generation failed
- Pastikan domain pointing benar
- Pastikan port 80 dan 443 terbuka
- Coba dengan staging mode: edit `init-letsencrypt.sh` set `staging=1`

## Services

- **Laravel**: http://YOUR_IP atau https://skintypes.dev (dengan SSL)
- **phpMyAdmin**: http://YOUR_IP:8080
- **MySQL**: YOUR_IP:3306

## Commands Berguna

```bash
# Restart specific service
sudo docker compose restart app
sudo docker compose restart nginx

# Clear cache
sudo docker compose exec app php artisan cache:clear
sudo docker compose exec app php artisan config:clear
sudo docker compose exec app php artisan view:clear

# Run artisan commands
sudo docker compose exec app php artisan [command]

# Access container shell
sudo docker compose exec app bash

# View real-time logs
sudo docker compose logs -f

# Stop all containers
sudo docker compose down

# Remove all (including volumes)
sudo docker compose down -v
```
