FROM serversideup/php:8.3-fpm-nginx

USER root

# Install PHP extensions for PostgreSQL
RUN install-php-extensions intl bcmath exif gd zip pcntl opcache pdo_pgsql

# Copy application code
COPY --chown=www-data:www-data . /var/www/localhost

WORKDIR /var/www/localhost

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Build frontend assets

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

USER www-data

EXPOSE 8080
