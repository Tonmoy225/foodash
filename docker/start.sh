#!/bin/sh
set -e

php artisan config:cache
php artisan route:cache || true
php artisan view:cache || true
php artisan storage:link || true

if [ "$RUN_MIGRATIONS" = "true" ]; then
  php artisan migrate --force
fi

exec apache2-foreground
