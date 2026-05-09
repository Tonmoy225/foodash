@echo off
echo ============================================
echo  FooDash - XAMPP Installation Script
echo ============================================
echo.

echo [1/4] Checking PHP...
php -v
if %errorlevel% neq 0 (
    echo ERROR: PHP not found. Make sure XAMPP is installed and added to PATH.
    pause
    exit /b 1
)

echo.
echo [2/4] Installing Composer dependencies...
composer install --no-dev --optimize-autoloader
if %errorlevel% neq 0 (
    echo ERROR: Composer failed. Make sure Composer is installed: https://getcomposer.org
    pause
    exit /b 1
)

echo.
echo [3/4] Setting up environment...
if not exist .env (
    copy .env.example .env
    echo Created .env file
)
php artisan key:generate

echo.
echo [4/4] Creating storage link...
php artisan storage:link

echo.
echo ============================================
echo  DONE! Now:
echo  1. Import database\foodash.sql into phpMyAdmin
echo  2. Edit .env and set your DB password if needed
echo  3. Visit: http://localhost/foodash/public
echo ============================================
pause
