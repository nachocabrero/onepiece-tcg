#!/bin/sh
set -e

SEED_DB=/app-seed/database.sqlite
DB_DIR=/var/www/html/database
DB_FILE=$DB_DIR/database.sqlite

mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs
chown -R www-data:www-data storage bootstrap/cache database 2>/dev/null || true

if [ ! -f "$DB_FILE" ]; then
    echo "[entrypoint] First boot: seeding database..."
    mkdir -p "$DB_DIR"
    cp "$SEED_DB" "$DB_FILE"
    chown www-data:www-data "$DB_FILE"
fi

echo "[entrypoint] Running migrations..."
php artisan migrate --force

echo "[entrypoint] Caching config and views..."
php artisan config:cache || true
php artisan view:cache || true

exec "$@"
