#!/bin/sh
set -e

# Fallback PORT
PORT=${PORT:-8080}

# Run migrations (ignore failures if DB not ready)
if [ -f artisan ]; then
  echo "Running migrations..."
  php artisan migrate --force || echo "Migrate failed or DB not ready; continuing..."
  echo "Ensuring storage link..."
  php artisan storage:link || echo "storage:link failed or already exists"
fi

# Start Laravel dev server on $PORT
echo "Starting Laravel on 0.0.0.0:$PORT"
exec php artisan serve --host=0.0.0.0 --port=$PORT
