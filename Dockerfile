# Build stage
FROM composer:2 AS builder
WORKDIR /app

# Copy composer files
COPY composer.json composer.lock* ./

# Install dependencies (PRODUCTION)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy full project
COPY . .

# Runtime stage
FROM php:8.1-cli
WORKDIR /app

# Install system dependencies + SQLite
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    libpng-dev \
    libonig-dev \
    sqlite3 \
    && docker-php-ext-install pdo pdo_sqlite mbstring zip gd \
    && rm -rf /var/lib/apt/lists/*

# Copy app from builder
COPY --from=builder /app /app

# Permissions
RUN chmod -R 775 storage bootstrap/cache

# Copy entrypoint and make executable
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Create user (optional)
RUN useradd -m appuser && chown -R appuser:appuser /app
USER appuser

# Koyeb and other platforms provide a runtime PORT via env var. Default to 8080.
EXPOSE 8080

# Entrypoint will run migrations/storage:link (if desired) and start the server on $PORT
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
