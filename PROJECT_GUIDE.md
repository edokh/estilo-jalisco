# Estilo Jalisco - Restaurant Food Ordering Website

A comprehensive restaurant food ordering system built with Laravel, Blade templates, jQuery, and Tailwind CSS.

## 🎯 Features

### Customer Features
- ✅ Browse menu by categories
- ✅ View food items with descriptions, prices, and images
- ✅ See real-time discounts on items
- ✅ Add items to cart with quantity selection
- ✅ Two checkout options:
  - Guest checkout (name, phone, optional notes)
  - Registered user checkout (with login)
- ✅ Order confirmation page with order number
- ✅ Order tracking status

### Admin Features
- ✅ Manage food categories
  - Create, edit, delete categories
  - Upload category images
  - Set display order
- ✅ Manage food items
  - Add/edit food items with images
  - Set prices and descriptions
  - Toggle availability
- ✅ Manage discounts
  - Create percentage or fixed amount discounts
  - Set discount validity periods
  - Apply to specific items or all items
- ✅ Restaurant settings
  - Set opening and closing hours
  - Manage holidays (auto-disable ordering)
- ✅ Order management
  - View all orders with real-time statistics
  - Update order status (Pending → Preparing → Ready → Completed)
  - Mark orders as paid
  - View order details with itemized breakdown

### Staff Features
- ✅ Dashboard with pending/preparing orders
- ✅ Update order status
- ✅ Real-time order statistics
- ✅ Quick access to order details

### System Features
- ✅ Role-based access control (Admin, Staff, Customer)
- ✅ User authentication with email verification
- ✅ Responsive design with Tailwind CSS
- ✅ Session-based shopping cart
- ✅ Automatic order numbering (ORD-YYYYMMDD-UNIQUEID)
- ✅ Discount calculation with price comparison display

## 🛠️ Tech Stack

- **Backend**: Laravel 11 with Eloquent ORM
- **Frontend**: Blade Templates, jQuery 3.6.0, Tailwind CSS
- **Database**: MySQL
- **Authentication**: Laravel Breeze (email/password)
- **File Storage**: Laravel storage (public disk)

## 📋 Prerequisites

- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js & npm

## ⚙️ Installation

### 1. Clone the repository
```bash
git clone <repository-url>
cd estilo-jalisco
```

### 2. Install PHP dependencies
```bash
composer install
```

### 3. Install Node dependencies
```bash
npm install
```

### 4. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configure database
Edit `.env` file and set your database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=estilo_jalisco
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Run migrations and seeders
```bash
php artisan migrate
php artisan db:seed
```

### 7. Build frontend assets
```bash
npm run build
```

### 8. Start development server
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## 👤 Test Credentials

After running seeders, use these credentials to test:

**Admin Account:**
- Email: `admin@example.com`
- Password: `password`

**Staff Account:**
- Email: `staff@example.com`
- Password: `password`

**Customer Account:**
- Email: `customer@example.com`
- Password: `password`

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── CategoryController.php
│   │   │   ├── FoodItemController.php
│   │   │   ├── DiscountController.php
│   │   │   ├── SettingsController.php
│   │   │   └── OrderManagementController.php
│   │   ├── Customer/
│   │   │   ├── MenuController.php
│   │   │   ├── CartController.php
│   │   │   └── CheckoutController.php
│   │   └── Staff/
│   │       └── DashboardController.php
│   └── Middleware/
│       ├── IsAdmin.php
│       └── IsStaff.php
├── Models/
│   ├── Category.php
│   ├── FoodItem.php
│   ├── Discount.php
│   ├── RestaurantSetting.php
│   ├── Holiday.php
│   ├── Order.php
│   ├── OrderItem.php
│   └── User.php
└── ...

database/
├── migrations/
├── factories/
│   ├── CategoryFactory.php
│   └── FoodItemFactory.php
└── seeders/
    └── DatabaseSeeder.php

resources/
├── views/
│   ├── layouts/
│   │   └── app.blade.php
│   ├── components/
│   │   └── navbar.blade.php
│   ├── customer/
│   │   ├── menu.blade.php
│   │   ├── checkout.blade.php
│   │   └── order-confirmation.blade.php
│   ├── admin/
│   │   ├── categories/
│   │   ├── food-items/
│   │   ├── discounts/
│   │   ├── settings/
│   │   └── orders/
│   └── staff/
│       └── dashboard.blade.php
├── css/
│   └── app.css
└── js/
    └── app.js

routes/
├── web.php
└── auth.php
```

## 🚀 Usage

### As an Admin:
1. Log in with admin credentials
2. Navigate to `/admin/categories` to manage food categories
3. Navigate to `/admin/food-items` to manage menu items
4. Navigate to `/admin/discounts` to create promotions
5. Navigate to `/admin/settings` to configure hours and holidays
6. Navigate to `/admin/orders` to view and manage customer orders

### As a Staff Member:
1. Log in with staff credentials
2. Navigate to `/staff/dashboard` to view pending orders
3. Update order statuses as items are prepared
4. Mark orders as completed

### As a Customer:
1. Browse menu on homepage
2. Add items to cart using quantity selector
3. Proceed to checkout
4. Choose guest checkout or login
5. Complete order
6. View order confirmation

## 🗄️ Database Schema

### Categories
- id, name, description, image, order, active, timestamps

### Food Items
- id, category_id, name, description, price, image, available, order, timestamps

### Discounts
- id, food_item_id (nullable), name, description, type (percentage/fixed), value, start_date, end_date, active, timestamps

### Orders
- id, user_id (nullable), order_number (unique), customer_name, customer_phone, customer_email, customer_notes, status (enum), original_price, discount_amount, final_price, paid, paid_at, timestamps

### Order Items
- id, order_id, food_item_id, quantity, price, subtotal, timestamps

### Restaurant Settings
- id, key (unique), value, type, timestamps

### Holidays
- id, name, date, note, timestamps

### Users
- All standard Laravel User fields + is_admin, is_staff booleans

## 🔐 Authentication & Authorization

The system uses role-based access control:

- **Admin**: Full access to all admin features
- **Staff**: Access to order management and status updates
- **Customer**: Access to menu and checkout

Middleware enforces these roles on protected routes.

## 🎨 Styling

The project uses Tailwind CSS for responsive, modern UI design. All components are built with:
- Mobile-first responsive design
- Consistent color scheme
- Form validation feedback
- Interactive elements and hover states

## 📝 Cart System

Cart is stored in Laravel sessions (not persistent across sessions). Items are:
- Added via AJAX POST requests
- Removed from cart
- Quantity can be updated
- Retrieved via AJAX GET requests

## 💰 Pricing & Discounts

- Base prices stored for each food item
- Discounts are time-bound (start_date to end_date)
- Can be percentage-based or fixed amount
- Automatically applied to order calculations
- Original price shown strikethrough when discount active

## ⏰ Restaurant Hours

- Opening and closing times configurable in admin panel
- Orders disabled when restaurant closed
- Holidays can be marked to disable ordering

## 📦 Order Management

Orders go through status workflow:
1. **Pending** - New order received
2. **Preparing** - Kitchen is preparing
3. **Ready** - Ready for pickup/delivery
4. **Completed** - Order fulfilled
5. **Cancelled** - Order cancelled

Staff can update status in real-time from dashboard.

## 🔮 Future Enhancements

- [ ] WhatsApp notifications via Vonage API
- [ ] Real-time WebSocket notifications
- [ ] Payment gateway integration (Stripe/PayPal)
- [ ] Delivery address management
- [ ] Order rating and review system
- [ ] Loyalty program
- [ ] Mobile app via API
- [ ] Order tracking for customers
- [ ] Advanced analytics dashboard
- [ ] Multi-language support
- [ ] Inventory management

## 📧 WhatsApp Integration (Future)

To implement WhatsApp notifications:

1. Install Vonage SDK (optional):
```bash
composer require vonage/client-core
```

2. Add Vonage credentials to `.env`:
```
   VONAGE_API_KEY=your_api_key
   VONAGE_API_SECRET=your_api_secret
```

3. Create notification service in `app/Services/WhatsAppNotificationService.php`

4. Dispatch notifications on order creation

## 🐛 Troubleshooting

### Database Migration Errors
- Ensure MySQL is running
- Check `.env` database credentials
- Run: `php artisan migrate:refresh --seed`

### Permission Issues
- Ensure `storage/` and `bootstrap/cache/` are writable
- Run: `chmod -R 775 storage bootstrap/cache`

### Asset Files Not Loading
- Run: `npm run build`
- Clear browser cache

### Cart Not Working
- Ensure sessions are enabled in `.env`
- Check browser console for JavaScript errors

## 📞 Support

For issues or questions, please refer to the Laravel documentation at https://laravel.com/docs

## 📄 License

This project is licensed under the MIT License.

## 👨‍💻 Development

### Running Tests
```bash
php artisan test
```

### Running Linter
```bash
./vendor/bin/pint
```

### Tinker Shell
```bash
php artisan tinker
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

## 📊 Performance

- Database queries optimized with eager loading
- Discount calculations cached where possible
- Frontend assets minified and bundled
- Static image placeholder service for demo

---

**Made with ❤️ for Estilo Jalisco**
