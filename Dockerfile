FROM serversideup/php:8.3-fpm-nginx

USER root

# Install additional PHP extensions if needed
RUN install-php-extensions intl bcmath exif gd zip pcntl opcache pdo_mysql pdo_pgsql

# Copy application code
COPY --chown=www-data:www-data . /var/www/localhost

WORKDIR /var/www/localhost

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Build frontend assets (adjust if you use yarn/pnpm)
RUN npm ci && npm run build && rm -rf node_modules

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

USER www-data

EXPOSE 8080
