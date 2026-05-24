#!/bin/sh
set -e

cd /app

mkdir -p database storage bootstrap/cache

export DB_CONNECTION="${DB_CONNECTION:-sqlite}"
export DB_DATABASE="${DB_DATABASE:-/app/database/database.sqlite}"
export SESSION_DRIVER="${SESSION_DRIVER:-file}"
export CACHE_STORE="${CACHE_STORE:-file}"
export QUEUE_CONNECTION="${QUEUE_CONNECTION:-sync}"
export FILESYSTEM_DISK="${FILESYSTEM_DISK:-public}"

if [ ! -f .env ]; then
  cp .env.example .env
fi

if [ -z "${APP_KEY:-}" ]; then
  if ! grep -q '^APP_KEY=base64:' .env 2>/dev/null; then
    php artisan key:generate --force
  fi
fi

if [ ! -f "$DB_DATABASE" ]; then
  echo "Database file $DB_DATABASE not found. Initializing SQLite..."
  mkdir -p "$(dirname "$DB_DATABASE")"
  touch "$DB_DATABASE"
  php artisan migrate --force --no-interaction
  php artisan db:seed --force --no-interaction || true
fi

php artisan storage:link || true

exec "$@"