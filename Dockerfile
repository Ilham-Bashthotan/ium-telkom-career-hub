# Build stage dengan PHP 8.4
FROM php:8.4-cli AS builder

WORKDIR /app

# Install system dependencies untuk composer, git, dan build tools
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    build-essential \
    autoconf \
    pkg-config \
    libsqlite3-dev \
    zlib1g-dev \
    libzip-dev \
    libxml2-dev \
    && rm -rf /var/lib/apt/lists/*

# Compile and enable PHP extensions yang diperlukan (PDO + SQLite)
RUN docker-php-ext-install pdo pdo_sqlite

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer files
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Runtime stage
FROM php:8.4-apache

WORKDIR /app

# Install system dependencies untuk Laravel
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    sqlite3 \
    git \
    curl \
    unzip \
    npm \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions untuk SQLite
RUN docker-php-ext-install pdo pdo_sqlite

# Enable Apache modules
RUN a2enmod rewrite
RUN a2enmod headers

# Copy PHP configuration
RUN echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/app.ini

# Copy vendor dari builder
COPY --from=builder /app/vendor ./vendor

# Copy aplikasi
COPY . .

# Create database directory
RUN mkdir -p database && chmod -R 775 database storage bootstrap/cache

# Remove cached bootstrap files so production doesn't boot stale dev providers
RUN rm -f bootstrap/cache/*.php

# Install Node dependencies dan build assets
RUN npm ci && npm run build

# Set Apache DocumentRoot ke public folder Laravel
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /app/public|g' /etc/apache2/sites-available/000-default.conf

# Add .htaccess untuk Laravel routing
RUN echo '<Directory /app/public>\n  Options Indexes FollowSymLinks\n  AllowOverride All\n  Require all granted\n</Directory>' >> /etc/apache2/apache2.conf

# Jalankan artisan commands
RUN php artisan key:generate --force || true
RUN mkdir -p database && touch database/database.sqlite
RUN php artisan migrate --force --no-interaction || true
RUN php artisan db:seed --force --no-interaction || true
RUN php artisan storage:link || true

# Set permissions
RUN chown -R www-data:www-data /app
RUN chmod -R 755 /app

EXPOSE 80

CMD ["apache2-foreground"]
