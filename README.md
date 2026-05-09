# 🍜 FooDash — Food Delivery Website
## Complete XAMPP Setup & Connection Guide

---

## 📦 Project Structure

```
foodash/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── Admin/  (Dashboard, Products, Orders, Vouchers, Clients)
│   │   │   └── Client/ (Home, Cart, Checkout, Orders)
│   │   └── Middleware/RoleMiddleware.php
│   ├── Models/         (User, Product, Category, Order, OrderItem, Voucher, DeliveryLocation)
│   └── Providers/
├── config/
├── database/
│   └── foodash.sql     ← Import this into phpMyAdmin
├── public/
│   ├── css/            (client.css, admin.css, auth.css)
│   ├── js/             (client.js, admin.js)
│   ├── images/products/
│   ├── index.php
│   └── .htaccess
├── resources/views/
│   ├── auth/           (login, register)
│   ├── layouts/        (client, admin)
│   └── client/ & admin/ (all pages)
├── routes/web.php
├── .env.example
└── .htaccess
```

---

## ✅ STEP-BY-STEP XAMPP SETUP

### STEP 1 — Install Requirements

Make sure you have:
- **XAMPP** (PHP 8.1+ required) → https://www.apachefriends.org
- **Composer** → https://getcomposer.org
- **Git** (optional) → https://git-scm.com

> ⚠️ Check PHP version: Open XAMPP Shell → type `php -v`
> Must show PHP 8.1 or higher.

---

### STEP 2 — Place Project in htdocs

1. Open your XAMPP installation folder (usually `C:\xampp`)
2. Navigate to `htdocs`
3. **Copy the entire `foodash` folder** into `C:\xampp\htdocs\`

Result: `C:\xampp\htdocs\foodash\`

---

### STEP 3 — Install PHP Dependencies (Composer)

1. Open **XAMPP Shell** (from XAMPP Control Panel → Shell button)
   OR open **Command Prompt** / **PowerShell**

2. Navigate to the project:
   ```
   cd C:\xampp\htdocs\foodash
   ```

3. Install dependencies:
   ```
   composer install
   ```
   > This will download Laravel and all required packages into `vendor/` folder.
   > It takes 2–5 minutes. Wait for it to finish.

---

### STEP 4 — Configure Environment File

1. In the `foodash` folder, find `.env.example`
2. **Copy and rename it** to `.env`:
   ```
   copy .env.example .env
   ```
   OR right-click → Copy → Rename to `.env`

3. Open `.env` in Notepad or VS Code and set:
   ```
   APP_NAME=FooDash
   APP_URL=http://localhost/foodash/public

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=foodash
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   > If your XAMPP MySQL has a password, enter it after `DB_PASSWORD=`

---

### STEP 5 — Generate Application Key

In XAMPP Shell (inside foodash folder):
```
php artisan key:generate
```
You will see: `Application key set successfully.`

---

### STEP 6 — Create Database & Import SQL

1. Start **Apache** and **MySQL** in XAMPP Control Panel
2. Open browser → go to: `http://localhost/phpmyadmin`
3. Click **"New"** in the left sidebar
4. Database name: `foodash` → Encoding: `utf8mb4_unicode_ci` → Click **Create**
5. Click on `foodash` database (left sidebar)
6. Click **"Import"** tab at the top
7. Click **"Choose File"** → navigate to:
   `C:\xampp\htdocs\foodash\database\foodash.sql`
8. Click **"Go"** at the bottom
9. ✅ You should see "Import has been successfully finished"

> This creates all tables AND inserts demo data (products, categories, vouchers, demo users).

---

### STEP 7 — Set Storage Permissions (Windows)

In XAMPP Shell:
```
cd C:\xampp\htdocs\foodash
php artisan storage:link
```

On Windows, XAMPP usually handles permissions automatically.
If you see permission errors, right-click the `storage` folder → Properties → Security → give full control.

---

### STEP 8 — Enable mod_rewrite in XAMPP

1. Open XAMPP Control Panel
2. Click **Config** next to Apache → click **httpd.conf**
3. Find this line:
   ```
   #LoadModule rewrite_module modules/mod_rewrite.so
   ```
4. Remove the `#` to uncomment it:
   ```
   LoadModule rewrite_module modules/mod_rewrite.so
   ```
5. Find `AllowOverride None` (there may be multiple) and change to:
   ```
   AllowOverride All
   ```
6. Save the file and **Restart Apache** in XAMPP Control Panel

---

### STEP 9 — Access the Website

Open your browser and go to:

| Page | URL |
|------|-----|
| 🏠 Client Home | http://localhost/foodash/public |
| 🔐 Login | http://localhost/foodash/public/login |
| 📝 Register | http://localhost/foodash/public/register |
| ⚙️ Admin Panel | http://localhost/foodash/public/admin |

---

## 🔐 Demo Login Credentials

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@foodash.com | password |
| **Client** | client@foodash.com | password |

---

## 🌟 Website Features

### 👤 Client Side
| Feature | Description |
|---------|-------------|
| 🏠 **Home Page** | Hero section, featured items, categories, how it works |
| 🍽️ **Menu Page** | Browse all food with category filters & search |
| 🛒 **Cart** | Add/remove items, update quantities, apply vouchers |
| 💳 **Checkout** | Delivery address, payment method selection |
| 💰 **Payment** | Cash, bKash, Nagad, Card payment flows |
| 📦 **Order History** | View all past orders with status |
| 📍 **Live Tracking** | Real-time delivery map using OpenStreetMap/Leaflet |

### ⚙️ Admin Side
| Feature | Description |
|---------|-------------|
| 📊 **Dashboard** | Revenue stats, order counts, recent orders |
| 🛍️ **Products** | Add/Edit/Delete products, set price, toggle availability |
| 📦 **Orders** | View all orders, update status, set rider GPS location |
| 🎟️ **Vouchers** | Create discount codes (% or fixed), set expiry/limits |
| 👥 **Client Database** | View all registered clients and their order history |

---

## 📁 Adding Product Images

1. Place product images in: `C:\xampp\htdocs\foodash\public\images\products\`
2. Supported formats: `.jpg`, `.jpeg`, `.png`, `.webp`
3. When adding a product in admin panel, upload image directly from the form
4. If no image is uploaded, a placeholder will be shown

---

## 🔧 Troubleshooting

### ❌ "Class not found" error
```
composer dump-autoload
```

### ❌ "No application encryption key" error
```
php artisan key:generate
```

### ❌ Blank page / 500 error
- Enable debug: In `.env` set `APP_DEBUG=true`
- Check `storage/logs/laravel.log` for error details

### ❌ "mod_rewrite" / page not found errors
- Make sure `AllowOverride All` is set in `httpd.conf`
- Restart Apache after any config change

### ❌ Database connection error
- Make sure MySQL is running in XAMPP
- Check `.env` DB credentials match your MySQL setup
- Default XAMPP MySQL: host=127.0.0.1, user=root, password=(empty)

### ❌ Storage permission error (Linux/Mac)
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### ❌ Images not showing
```
php artisan storage:link
```

---

## 🚀 Optional: Clean URL Setup

To use `http://localhost/foodash` instead of `http://localhost/foodash/public`:

1. Open `C:\xampp\htdocs\foodash\.htaccess` (the root one)
2. It already contains:
   ```apache
   RewriteEngine On
   RewriteRule ^(.*)$ public/$1 [L]
   ```
3. Update `.env`:
   ```
   APP_URL=http://localhost/foodash
   ```

---

## 🛠 Tech Stack

- **Backend**: PHP 8.1, Laravel 10
- **Frontend**: Blade Templates, Vanilla CSS, Vanilla JS
- **Database**: MySQL (via XAMPP)
- **Maps**: Leaflet.js + OpenStreetMap (free, no API key needed)
- **Fonts**: Google Fonts (Fraunces + DM Sans)

---

## 📞 Payment Gateway Notes

The payment system is **simulated** (demo mode):
- **bKash / Nagad**: User enters a transaction ID → order confirmed
- **Card**: Demo card form UI → no real charge
- **Cash**: One-click confirm → order placed

To integrate real payment gateways:
- **bKash**: Use bKash Merchant API (https://developer.bka.sh)
- **SSLCommerz**: Popular BD gateway (https://sslcommerz.com)
- **Stripe**: For international cards

---

*Built with ❤️ by FooDash*
