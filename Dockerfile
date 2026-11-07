FROM serversideup/php:8.3-fpm-nginx

USER root

# Install PHP extensions for PostgreSQL
RUN install-php-extensions intl bcmath exif gd zip pcntl opcache pdo_pgsql

# Install Node.js 20 LTS for building frontend assets
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Copy application code
COPY --chown=www-data:www-data . /var/www/localhost

WORKDIR /var/www/localhost

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Build frontend assets then remove node_modules to keep image small
# RUN npm ci && npm run build && rm -rf node_modules

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

USER www-data

EXPOSE 8080
