## Ancient Cities Turkey

Source code for the [ancientcitiesturkey.com](https://ancientcitiesturkey.com).
It is built with Laravel 13 and React 18.

### Stack

- PHP 8.3 (production: `pluto.cemunalan.com.tr`, 8.3-FPM)
- Laravel 13
- MySQL 8
- Vite (React 18, Mapbox GL, react-map-gl)
- Docker Compose for local development

### Local development

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
docker compose up -d --build
npm run dev   # Vite dev server
```

### Pipeline

![](https://github.com/raicem/ancient-cities-turkey/workflows/Pipeline/badge.svg)

- Installing Dependencies
- PHPUnit
- Build assets with Vite
- Check code style
- Static analysis with Larastan

### Production deployment

The production server runs PHP 8.3-FPM (nginx vhost: `php8.3-fpm.sock`) and the app lives in
`/var/www/ancientcitiesturkey.com/public` (nginx root: `public/public`).

```bash
# after deploying the code:
composer install --no-dev --optimize-autoloader
npm run build   # build locally, upload public/build
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
```
