# SSL Setup Guide untuk skintypes.dev

Panduan lengkap untuk setup SSL certificate dengan Let's Encrypt dan Certbot.

## Prasyarat

1. Domain **skintypes.dev** dan **www.skintypes.dev** harus sudah pointing ke IP server Anda
2. Port 80 dan 443 harus terbuka di firewall
3. Docker dan Docker Compose sudah terinstall

## Langkah Setup SSL

### 1. Pastikan Domain Sudah Pointing

Cek DNS sudah benar:
```bash
nslookup skintypes.dev
nslookup www.skintypes.dev
```

### 2. Start Containers (HTTP Only)

```bash
docker compose up -d
```

Saat ini aplikasi berjalan di HTTP port 80.

### 3. Generate SSL Certificate

Jalankan script init-letsencrypt.sh:

```bash
chmod +x init-letsencrypt.sh
./init-letsencrypt.sh
```

Script ini akan:
- Membuat direktori untuk certbot
- Request certificate dari Let's Encrypt
- Otomatis setup untuk domain skintypes.dev dan www.skintypes.dev

### 4. Switch ke Konfigurasi HTTPS

Setelah certificate berhasil dibuat, ganti nginx config:

```bash
cp nginx-ssl.conf nginx.conf
docker compose restart nginx
```

### 5. Verifikasi SSL

Buka browser dan akses:
- https://skintypes.dev
- https://www.skintypes.dev

## Manual Certificate Generation

Jika script otomatis gagal, Anda bisa generate manual:

```bash
# Create directories
mkdir -p certbot/www certbot/conf

# Start nginx
docker compose up -d nginx

# Generate certificate
docker compose run --rm certbot certonly \
  --webroot \
  --webroot-path=/var/www/certbot \
  --email admin@skintypes.dev \
  --agree-tos \
  --no-eff-email \
  -d skintypes.dev \
  -d www.skintypes.dev

# Switch to SSL config
cp nginx-ssl.conf nginx.conf
docker compose restart nginx
```

## Renew Certificate

Certificate Let's Encrypt berlaku 90 hari. Untuk renew:

```bash
chmod +x renew-ssl.sh
./renew-ssl.sh
```

Atau manual:
```bash
docker compose run --rm certbot renew
docker compose exec nginx nginx -s reload
```

## Auto-Renewal dengan Cron

Tambahkan ke crontab untuk auto-renewal setiap hari jam 2 pagi:

```bash
crontab -e
```

Tambahkan line:
```
0 2 * * * cd /path/to/skintypes-web && ./renew-ssl.sh >> /var/log/certbot-renew.log 2>&1
```

## Testing dengan Staging

Untuk testing (menghindari rate limit), edit `init-letsencrypt.sh` dan set `staging=1`:

```bash
staging=1
```

## Troubleshooting

### Error: Domain tidak bisa diverifikasi

Pastikan:
- Domain sudah pointing ke server
- Port 80 terbuka
- Nginx container berjalan: `docker compose ps`

### Error: Rate limit exceeded

Tunggu beberapa jam atau gunakan staging mode untuk testing.

### Certificate tidak terdeteksi

Cek file certificate ada:
```bash
ls -la certbot/conf/live/skintypes.dev/
```

Harus ada:
- fullchain.pem
- privkey.pem

## File Konfigurasi

- `nginx.conf` - Config aktif (HTTP only by default)
- `nginx-http.conf` - Template HTTP only
- `nginx-ssl.conf` - Template HTTPS dengan SSL
- `init-letsencrypt.sh` - Script generate certificate
- `renew-ssl.sh` - Script renew certificate

## Ports

- **80** - HTTP (redirect ke HTTPS setelah SSL aktif)
- **443** - HTTPS
- **8080** - phpMyAdmin
- **3306** - MySQL

## Security Headers

SSL config sudah include security headers:
- Strict-Transport-Security (HSTS)
- X-Frame-Options
- X-Content-Type-Options  
- X-XSS-Protection

## Support

Jika ada masalah, cek logs:
```bash
docker compose logs nginx
docker compose logs certbot
```
