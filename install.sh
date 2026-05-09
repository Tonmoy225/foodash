#!/bin/bash
echo "============================================"
echo " FooDash - Installation Script"
echo "============================================"

echo "[1/4] Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

echo "[2/4] Setting up environment..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo "Created .env file"
fi
php artisan key:generate

echo "[3/4] Setting permissions..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

echo "[4/4] Creating storage link..."
php artisan storage:link

echo ""
echo "============================================"
echo " DONE! Import database/foodash.sql then visit:"
echo " http://localhost/foodash/public"
echo "============================================"
