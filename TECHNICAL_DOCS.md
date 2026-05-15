# Technical Documentation - Estilo Jalisco

## Architecture Overview

```
┌─────────────────────────────────────────────────────────────┐
│                     Web Browser                             │
│  (Customer/Admin/Staff accessing through web interface)     │
└────────────────────────┬────────────────────────────────────┘
                         │ HTTP/AJAX
         ┌───────────────┴────────────────┐
         │                                │
    ┌────▼─────┐                   ┌──────▼──────┐
    │   Views  │                   │  API Routes │
    │ (Blade)  │                   │   (AJAX)    │
    └────┬─────┘                   └──────┬──────┘
         │                                │
    ┌────▼────────────────────────────────▼────┐
    │         Laravel Router                   │
    │     (routes/web.php, auth.php)          │
    └────┬─────────────────────────────────────┘
         │
    ┌────▼────────────────────────────────────────┐
    │         Controllers                        │
    │  ├── Admin/*Controller                     │
    │  ├── Customer/*Controller                  │
    │  └── Staff/*Controller                     │
    └────┬───────────────────────────────────────┘
         │
    ┌────▼────────────────────────────────────────┐
    │         Business Logic                     │
    │  ├── Models                                │
    │  └── Services                              │
    └────┬───────────────────────────────────────┘
         │
    ┌────▼───────────────────────────────────────┐
    │         Database Layer                    │
    │  └── MySQL via Eloquent ORM               │
    └───────────────────────────────────────────┘
```

## Directory Structure Explained

### `/app`
- **Http/Controllers/Admin/** - Admin panel controllers for categories, food items, discounts, settings, orders
- **Http/Controllers/Customer/** - Customer-facing controllers for menu, cart, checkout
- **Http/Controllers/Staff/** - Staff dashboard controllers
- **Http/Middleware/** - Custom middleware for admin and staff role checks
- **Models/** - Eloquent models for database tables

### `/database`
- **migrations/** - Database schema definitions
- **factories/** - Model factories for testing/seeding
- **seeders/** - Database seeders with sample data

### `/resources`
- **views/layouts/** - Main layout templates
- **views/components/** - Reusable view components
- **views/customer/** - Customer-facing templates
- **views/admin/** - Admin panel templates
- **views/staff/** - Staff templates
- **views/auth/** - Authentication templates (Breeze)
- **css/** - Tailwind CSS styling
- **js/** - JavaScript files

### `/routes`
- **web.php** - Main application routes
- **auth.php** - Authentication routes (Breeze)

## Core Concepts

### Model Relationships

```
Category (1) ──────── (Many) FoodItem
                          │
                          ├── (Many) Discount
                          └── (Many) OrderItem

Order (1) ──────── (Many) OrderItem
                       │
                       └── (1) FoodItem

User (1) ──────---- (Many) Order

Discount (1) ──────---- (Many) FoodItem (optional)

Holiday (standalone)
RestaurantSetting (key-value store)
```

### Request Flow Example: Placing an Order

```
1. Customer adds items to cart (jQuery AJAX to CartController)
2. Session stores cart data
3. Customer navigates to /checkout
4. CheckoutController displays checkout form
5. Customer submits form (guest or registered)
6. CheckoutController.processGuestCheckout() or processRegisteredCheckout()
7. Validates input and cart
8. Creates Order record (with auto-generated order_number)
9. Creates OrderItem records for each cart item
10. Clears session cart
11. Redirects to confirmation page
12. Confirmation page displays order details
```

### Discount Calculation Flow

```
1. FoodItem model has getActiveDiscount() method
2. Checks if current discount is within date range
3. If discount exists and active, getPriceWithDiscount() applies it
4. On order creation, both original_price and final_price stored
5. discount_amount = original_price - final_price
6. Admin can see discount breakdown in order details
```

### Authentication & Authorization

```
Middleware Chain:
  auth  →  Authenticated? → Check is_admin/is_staff → Grant access
  
Routes protected by:
  - admin middleware: /admin/* routes
  - staff middleware: /staff/* routes
  - auth middleware: /checkout/* routes
  - (public): /, /cart/*, /order/*/confirmation, /auth/*
```

## Key Controllers & Methods

### CategoryController
```php
index()      // List all categories
create()     // Show create form
store()      // Save new category
edit()       // Show edit form
update()     // Save changes
destroy()    // Delete category
```

### FoodItemController
```php
index()      // List food items with category filter
create()     // Show create form
store()      // Save new food item
edit()       // Show edit form
update()     // Save changes
destroy()    // Delete food item
```

### DiscountController
```php
index()      // List all discounts
create()     // Show create form
store()      // Save new discount
edit()       // Show edit form
update()     // Save changes
destroy()    // Delete discount
```

### SettingsController
```php
index()              // Show settings form
updateTimings()      // Update open/close times
addHoliday()        // Add holiday date
removeHoliday()     // Remove holiday date
```

### OrderManagementController
```php
index()         // List all orders with pagination
show()          // Display order details
updateStatus()  // Change order status
markAsPaid()    // Mark order as paid
```

### CartController (AJAX)
```php
addToCart()      // Add item to session cart
removeFromCart() // Remove item from session cart
updateQuantity() // Update item quantity
getCart()        // Return cart contents (JSON)
```

### CheckoutController
```php
show()                      // Display checkout form
processGuestCheckout()      // Process guest order
processRegisteredCheckout() // Process logged-in user order
confirmation()              // Show order confirmation
```

## Models in Detail

### Category
```php
class Category extends Model {
    hasMany(FoodItem)
    
    Attributes:
    - name (unique)
    - description
    - image (URL/path)
    - order (display order)
    - active (boolean)
}
```

### FoodItem
```php
class FoodItem extends Model {
    belongsTo(Category)
    hasMany(Discount)
    hasMany(OrderItem)
    
    Methods:
    - getActiveDiscount() // Get current valid discount
    - getPriceWithDiscount() // Get price after discount
    
    Attributes:
    - category_id (FK)
    - name
    - description
    - price (decimal 10,2)
    - image
    - available (boolean)
    - order (display order)
}
```

### Order
```php
class Order extends Model {
    belongsTo(User, nullable)
    hasMany(OrderItem)
    
    Boot Method:
    - Auto-generates order_number in format: ORD-YYYYMMDD-{UNIQUE_ID}
    
    Attributes:
    - order_number (unique, auto-generated)
    - user_id (nullable FK)
    - customer_name
    - customer_phone
    - customer_email
    - customer_notes
    - status (enum: pending, preparing, ready, completed, cancelled)
    - original_price (decimal 10,2)
    - discount_amount (decimal 10,2)
    - final_price (decimal 10,2)
    - paid (boolean)
    - paid_at (timestamp, nullable)
}
```

### OrderItem
```php
class OrderItem extends Model {
    belongsTo(Order)
    belongsTo(FoodItem)
    
    Attributes:
    - order_id (FK)
    - food_item_id (FK)
    - quantity
    - price (snapshot at order time)
    - subtotal (quantity * price)
}
```

### RestaurantSetting
```php
class RestaurantSetting extends Model {
    Key-Value Configuration Store
    
    Static Methods:
    - get($key, $default)
    - set($key, $value, $type)
    
    Attributes:
    - key (unique)
    - value
    - type (string, time, number, etc.)
}
```

### Holiday
```php
class Holiday extends Model {
    Static Methods:
    - isHolidayToday() // Check if today is holiday
    
    Attributes:
    - name
    - date
    - note
}
```

## Database Schema

### categories
```sql
id | name (unique) | description | image | order | active | created_at | updated_at
```

### food_items
```sql
id | category_id (FK) | name | description | price | image | available | order | created_at | updated_at
```

### discounts
```sql
id | food_item_id (FK, nullable) | name | description | type | value | start_date | end_date | active | created_at | updated_at
```

### orders
```sql
id | user_id (FK, nullable) | order_number (unique) | customer_name | customer_phone | customer_email | customer_notes | status (enum) | original_price | discount_amount | final_price | paid | paid_at | created_at | updated_at
```

### order_items
```sql
id | order_id (FK) | food_item_id (FK) | quantity | price | subtotal | created_at | updated_at
```

### restaurant_settings
```sql
id | key (unique) | value | type | created_at | updated_at
```

### holidays
```sql
id | name | date | note | created_at | updated_at
```

### users (Laravel default + custom)
```sql
... (default Laravel fields) ... | is_admin | is_staff
```

## Session Management

### Cart Session Structure
```php
session('cart') = [
    'food_item_id_1' => [
        'price' => 12.99,
        'quantity' => 2,
    ],
    'food_item_id_2' => [
        'price' => 8.99,
        'quantity' => 1,
    ],
]
```

## Middleware Stack

### IsAdmin Middleware
```php
// Check if user is authenticated and has is_admin = true
// If not, redirect to home with error message
```

### IsStaff Middleware
```php
// Check if user is authenticated and has is_staff = true
// If not, redirect to home with error message
```

## Frontend JavaScript

### Cart Operations (jQuery AJAX)
```javascript
// Add to cart
POST /cart/add/{foodItem}

// Remove from cart
POST /cart/remove/{foodItem}

// Update quantity
POST /cart/update/{foodItem}

// Get cart contents
GET /cart
```

### Response Format
```json
{
    "success": true,
    "cart": {
        "food_item_id": {
            "price": 12.99,
            "quantity": 2
        }
    },
    "cartCount": 3
}
```

## View Components

### Navigation Component
```blade
@include('components.navbar')
- Display logo/restaurant name
- Show auth status
- Show role-based menu items
- Show cart counter (updates via AJAX)
```

### Error/Success Messages
```blade
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>
    @endforeach
@endif

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
```

## Extending the System

### Adding a New Food Item Type
1. Create migration for new table
2. Create Model with relationships
3. Create Controller with CRUD methods
4. Create views (index, create, edit)
5. Add routes to web.php
6. Add navigation link

### Adding Custom Discount Type
1. Update Discount model type enum
2. Update discount creation form
3. Update getPriceWithDiscount() logic in FoodItem
4. Update admin discount edit view

### Adding Email Notifications
1. Create Mailable class: `php artisan make:mail OrderConfirmation`
2. In CheckoutController.createOrder(), add: `Mail::send(new OrderConfirmation($order))`
3. Configure MAIL_* variables in .env

### Adding WhatsApp Notifications
1. Install Vonage: `composer require vonage/client-core` (optional - currently using HTTP API)
2. Create WhatsAppNotificationService
3. In appropriate controller, dispatch: `WhatsAppNotificationService::send(...)`
4. Add VONAGE_* variables to .env

### Adding API Endpoints (for mobile app)
1. Create ApiController with JSON responses
2. Define routes in routes/api.php
3. Use Token-based authentication (Sanctum)
4. Return JSON instead of views

## Performance Optimization

### Query Optimization
```php
// Use eager loading
Order::with('items', 'items.foodItem', 'user')->get();

// Avoid N+1 queries
```

### Caching
```php
// Cache expensive queries
Cache::remember('categories', 3600, function () {
    return Category::where('active', true)->get();
});
```

### Asset Bundling
```bash
npm run build      # Production build with minification
npm run dev        # Development build with hot reload
```

## Testing Recommendations

### Unit Tests
```bash
php artisan make:test Models/FoodItemTest --unit
php artisan make:test Models/DiscountTest --unit
```

### Feature Tests
```bash
php artisan make:test Feature/OrderPlacementTest
php artisan make:test Feature/CheckoutTest
php artisan make:test Feature/AdminPanelTest
```

### Run Tests
```bash
php artisan test
php artisan test --filter=OrderTest
```

## Debugging

### Enable Debug Mode
```env
APP_DEBUG=true    # Set in .env
```

### Use Tinker
```bash
php artisan tinker
> Order::all()
> FoodItem::find(1)->getActiveDiscount()
```

### Log Errors
```php
Log::info('Order created', ['order_id' => $order->id]);
Log::error('Checkout failed', $exception->getMessage());
```

### Laravel Debugbar
```bash
composer require barryvdh/laravel-debugbar --dev
```

## Security Best Practices

### CSRF Protection
- All forms include @csrf token
- Middleware automatically validates

### Authorization
- Always check user roles in controllers
- Use middleware to protect routes
- Validate user ownership of resources

### Input Validation
- Server-side validation on all inputs
- Client-side validation for UX
- Use Laravel's validation rules

### SQL Injection Prevention
- Use Eloquent/Query Builder (not raw SQL)
- Use parameter binding for raw queries

## Deployment Considerations

### Environment Variables
```env
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
CACHE_DRIVER=redis
SESSION_DRIVER=database
```

### Security Headers
```php
// Add to .htaccess or server config
Header set X-Frame-Options "SAMEORIGIN"
Header set X-Content-Type-Options "nosniff"
Header set X-XSS-Protection "1; mode=block"
```

### Database Backup
```bash
mysqldump -u user -p database_name > backup.sql
```

### Monitoring
- Set up error logging (Sentry/Rollbar)
- Monitor database performance
- Track API response times
- Set up uptime monitoring

## Troubleshooting Common Issues

### Issue: SQLSTATE[HY000]
**Cause:** Database connection failed
**Solution:** Check DB credentials in .env, ensure MySQL is running

### Issue: Session data not persisting
**Cause:** Session driver misconfigured
**Solution:** Check SESSION_DRIVER in .env, ensure storage/framework/sessions is writable

### Issue: Images not displaying
**Cause:** Storage symlink missing
**Solution:** Run `php artisan storage:link`

### Issue: Routes not recognized
**Cause:** Route cache stale
**Solution:** Run `php artisan route:cache` then `php artisan route:clear`

---

**For additional help, refer to:**
- Laravel Documentation: https://laravel.com/docs
- Blade Documentation: https://laravel.com/docs/blade
- Eloquent Documentation: https://laravel.com/docs/eloquent
