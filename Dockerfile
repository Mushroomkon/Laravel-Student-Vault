FROM serversideup/php:8.3-fpm-nginx

USER root

# Install PHP extensions
RUN install-php-extensions intl bcmath exif gd zip pcntl opcache pdo_pgsql

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Copy code to /var/www/html (the default document root for this image)
COPY --chown=www-data:www-data . /var/www/html

WORKDIR /var/www/html

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Build frontend assets
RUN npm ci && npm run build && rm -rf node_modules

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

USER www-data

EXPOSE 8080
