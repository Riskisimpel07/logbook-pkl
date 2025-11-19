FROM composer:2 AS builder
WORKDIR /app

# copy composer files and install dependencies (no dev for smaller image)
COPY composer.json composer.lock* ./
RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts --optimize-autoloader || true

# copy rest of the app
COPY . .

# final runtime image
FROM php:8.1-cli
WORKDIR /app

# system deps
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    libpng-dev \
    libonig-dev \
    git \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd \
    && rm -rf /var/lib/apt/lists/*

# copy vendor and app from builder
COPY --from=builder /app /app

# set permissions for storage (Render ephemeral, consider S3 for persistence)
RUN useradd -m appuser && chown -R appuser:appuser /app
USER appuser

EXPOSE 10000

# Note: using built-in server for simplicity. For production, use PHP-FPM + Nginx or Dockerfile with nginx.
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
