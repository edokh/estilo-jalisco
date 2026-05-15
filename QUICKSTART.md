# Quick Start Guide - Estilo Jalisco

## 🚀 Get Started in 5 Minutes

### Step 1: Install Dependencies
```bash
cd e:\my-sites\estilo-jalisco
composer install
npm install
```

### Step 2: Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### Step 3: Configure Database
Edit `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=estilo_jalisco
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Create Database & Run Migrations
```bash
# Create database first in MySQL:
# CREATE DATABASE estilo_jalisco;

php artisan migrate
php artisan db:seed
```

### Step 5: Build Assets
```bash
npm run build
```

### Step 6: Start Server
```bash
php artisan serve
```

Visit: **http://localhost:8000**

## 🔑 Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | password |
| Staff | staff@example.com | password |
| Customer | customer@example.com | password |

## 📍 Key Routes

| Path | Purpose |
|------|---------|
| `/` | Customer menu/home |
| `/checkout` | Checkout page |
| `/admin/categories` | Manage categories |
| `/admin/food-items` | Manage food items |
| `/admin/discounts` | Manage discounts |
| `/admin/settings` | Restaurant settings |
| `/admin/orders` | Order management |
| `/staff/dashboard` | Staff dashboard |

## 💡 Common Commands

```bash
# Development server
php artisan serve

# Run migrations only
php artisan migrate

# Seed database
php artisan db:seed

# Clear all caches
php artisan cache:clear
php artisan config:clear

# Fresh migrations + seed
php artisan migrate:refresh --seed

# Tinker shell
php artisan tinker

# Watch assets during development
npm run dev
```

## 📦 What's Included

✅ Complete Laravel Breeze authentication
✅ Role-based admin and staff access
✅ Shopping cart system
✅ Order management workflow
✅ Discount system with time-based validity
✅ Restaurant hours and holiday management
✅ Responsive Tailwind CSS design
✅ jQuery AJAX for cart operations

## 🐛 Troubleshooting

**Problem: "SQLSTATE[HY000]: General error: 1030"**
- Solution: Check MySQL is running and database exists

**Problem: "Route [xxx] not defined"**
- Solution: Run `php artisan route:cache` then `php artisan route:clear`

**Problem: "Blade template not found"**
- Solution: Clear view cache: `php artisan view:clear`

**Problem: "jQuery not loading"**
- Solution: Run `npm run build` and check public/build folder exists

## 📚 Next Steps

1. **Customize Menu**: Go to Admin panel → Categories/Food Items
2. **Set Hours**: Admin → Settings to set open/close times
3. **Add Promotions**: Create discounts in Admin → Discounts
4. **Configure Staff**: Create staff user accounts with is_staff role
5. **Test Workflow**: Place test order through guest checkout

## 🎓 Learning Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Blade Template Guide](https://laravel.com/docs/blade)
- [Tailwind CSS](https://tailwindcss.com/)
- [jQuery Documentation](https://jquery.com/)

---

**Enjoy building your restaurant ordering system! 🍽️**
