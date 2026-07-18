# Website Desa Bakal Dalam — Repository Hosting

Repository ini berisi source code Laravel untuk website resmi Desa Bakal Dalam.

## Tidak disimpan di GitHub

- `.env`
- `vendor/`
- `node_modules/`
- database `.sql`
- session, log, cache, dan compiled view lokal
- `public/hot`

## Disimpan di GitHub

- source code Laravel
- migration dan route
- Blade/CSS/JavaScript
- `composer.lock` dan `package-lock.json`
- aset produksi `public/build`
- media website yang berada di `storage/app/public`

## Instalasi pada server

```bash
cp .env.hosting.example .env
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan storage:link
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Import database diberikan terpisah melalui file SQL. Jangan menyimpan file SQL produksi di repository publik.

Document root domain harus diarahkan ke folder `public`.

Folder berikut harus dapat ditulis oleh web server:

- `storage`
- `bootstrap/cache`

## Catatan media

Folder `storage/app/public` ikut disimpan karena berisi gambar website yang sudah digunakan. Setelah clone, jalankan `php artisan storage:link`.
