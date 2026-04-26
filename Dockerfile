# ===== Stage 1: Build frontend assets =====
FROM node:20-alpine AS node-builder

WORKDIR /app
COPY package.json package-lock.json* ./
RUN npm install

COPY vite.config.js ./
COPY resources/ resources/
RUN npm run build

# ===== Stage 2: Install PHP dependencies =====
FROM composer:2 AS composer-builder

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

COPY . .
RUN composer dump-autoload --optimize

# ===== Stage 3: Production image =====
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libsqlite3-dev \
    unzip \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_sqlite pdo_mysql zip bcmath \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copy composer dependencies
COPY --from=composer-builder /app/vendor vendor/

# Copy application code
COPY . .

# Copy built frontend assets
COPY --from=node-builder /app/public/build public/build/

# Set permissions
RUN mkdir -p storage/framework/{cache,sessions,views} \
    storage/logs \
    bootstrap/cache \
    database \
    && chmod -R 775 storage bootstrap/cache database \
    && chown -R www-data:www-data storage bootstrap/cache database

# Create SQLite database
RUN touch database/database.sqlite \
    && chmod 664 database/database.sqlite \
    && chown www-data:www-data database/database.sqlite

# Create storage link
RUN php artisan storage:link 2>/dev/null || true

# Expose port
EXPOSE 8080

# Startup script: run migrations then serve
CMD php artisan migrate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan serve --host=0.0.0.0 --port=8080
