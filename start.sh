#!/bin/bash
set -e

cd /var/www/html

# Run migrations
php artisan migrate --force

# Cache config and routes for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Nginx and PHP-FPM manually
nginx
php-fpm8.3 --daemonize

# Keep container running
wait
