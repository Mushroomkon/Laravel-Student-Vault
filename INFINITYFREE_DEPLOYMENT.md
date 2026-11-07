# Deploy to InfinityFree

## Requirements

- PHP 8.2 or newer, with PDO MySQL enabled
- An InfinityFree MySQL database
- FTP/File Manager access

## 1. Prepare Laravel locally

Run:

```powershell
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

Do not upload `.env`, SQLite files, `node_modules`, or your local test database.

## 2. Upload files

InfinityFree serves the domain from `/htdocs`.

Upload the application folders and files outside `/htdocs` when your plan allows it, such as into `/laravel_app`. If outside folders are unavailable, upload the Laravel files into `/htdocs` and keep `.env` protected with server rules.

Then upload everything inside this project's `public` directory into `/htdocs`.

Copy `infinityfree.htaccess` to `/htdocs/.htaccess`.

Because Laravel's front controller normally references application files outside `public`, the simplest fully supported layout for shared hosting is to place the Laravel source in `/htdocs/laravel`, and replace the copied wrapper with:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ laravel/public/$1 [L]
</IfModule>
```

Or upload all application files one level above `htdocs` and configure the web root from InfinityFree control panel if available.

## 3. Configure production environment

Copy `.env.example` to `.env` in the Laravel root and fill in:

```dotenv
APP_NAME="Student Management"
APP_ENV=production
APP_KEY=base64:GENERATED_KEY
APP_DEBUG=false
APP_URL=https://YOUR-DOMAIN

DB_CONNECTION=mysql
DB_HOST=YOUR_INFINITYFREE_MYSQL_HOST
DB_PORT=3306
DB_DATABASE=YOUR_DATABASE_NAME
DB_USERNAME=YOUR_DATABASE_USERNAME
DB_PASSWORD=YOUR_DATABASE_PASSWORD

SESSION_DRIVER=database
QUEUE_CONNECTION=sync
CACHE_STORE=file
```

Generate a key locally with:

```powershell
php artisan key:generate --show
```

Never reuse the local `.env`; copy the generated key into the hosting `.env`.

## 4. Create database tables

Run migrations through a hosting-compatible terminal if provided. Otherwise, import exported migration SQL through phpMyAdmin, or temporarily use a secure deployment script that calls `$kernel = require 'bootstrap/app.php'; Artisan::call('migrate', ['--force' => true]);` and delete it immediately afterward.

Create the database tables before opening the site:

```text
php artisan migrate --force
php artisan db:seed --force
```

Run seed only if you need the seed data.

## 5. Storage permissions

Ensure these directories are writable by PHP:

```text
storage/
bootstrap/cache/
```

## 6. Security checks

- Keep the local `.env`, database credentials, and secrets out of `htdocs/public`.
- Set `APP_DEBUG=false`.
- Do not enable `queue:work` or other long-running processes on InfinityFree.
- Database and Redis connections must not use localhost; use InfinityFree's provided MySQL host.
- InfinityFree limits long-running scripts and cron jobs; keep background work disabled with `QUEUE_CONNECTION=sync`.
