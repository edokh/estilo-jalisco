# Testing Checklist - Estilo Jalisco

## Pre-Test Setup
- [ ] Database migrations have run successfully
- [ ] Database seeder has populated sample data
- [ ] Laravel Breeze authentication is working
- [ ] npm build has completed
- [ ] PHP development server is running on http://localhost:8000

## Customer Features Testing

### 1. Menu Browsing
- [ ] Can view homepage with all categories
- [ ] Can see food items grouped by category
- [ ] Product images load correctly
- [ ] Product prices display correctly
- [ ] Can see discount information when applicable
- [ ] Discount badge shows percentage/amount saved

### 2. Shopping Cart
- [ ] Can add item to cart via "Add to Cart" button
- [ ] Cart counter updates in navbar
- [ ] Can increase quantity before adding
- [ ] Can view cart items in cart page
- [ ] Can remove items from cart
- [ ] Can update item quantities
- [ ] Cart persists during session
- [ ] Cart total calculates correctly

### 3. Guest Checkout
- [ ] Can navigate to checkout page
- [ ] Can toggle to guest checkout tab
- [ ] Can enter name (required)
- [ ] Can enter phone (required)
- [ ] Can enter email (optional)
- [ ] Can enter notes (optional)
- [ ] Can submit guest checkout form
- [ ] Order is created successfully
- [ ] Cart is cleared after checkout
- [ ] Redirected to confirmation page

### 4. Registered Checkout
- [ ] Can toggle to registered checkout tab
- [ ] Can click login link
- [ ] Can login with customer@example.com / password
- [ ] Returns to checkout page after login
- [ ] Name auto-populated from user account
- [ ] Email auto-populated from user account
- [ ] Can enter phone number
- [ ] Can enter notes
- [ ] Can submit registered checkout
- [ ] Order is created with user_id

### 5. Order Confirmation
- [ ] Confirmation page shows order number
- [ ] Shows customer information
- [ ] Shows itemized product list
- [ ] Shows price breakdown (original, discount, final)
- [ ] Shows order status as "Pending"
- [ ] Can print order confirmation

### 6. Restaurant Hours
- [ ] Cannot checkout when restaurant is closed
- [ ] Can checkout during operating hours (9 AM - 10 PM by default)
- [ ] Message displays when trying to order outside hours

### 7. Holidays
- [ ] Cannot checkout on holiday dates
- [ ] Message displays blocking checkout on holidays

## Admin Features Testing

### 1. Authentication
- [ ] Can login with admin@example.com / password
- [ ] Non-admin users cannot access admin panel
- [ ] Admin middleware works correctly

### 2. Category Management
- [ ] Can view category list
- [ ] Can create new category with name, description, image
- [ ] Image upload works
- [ ] Can edit existing category
- [ ] Can delete category
- [ ] Categories display in order specified
- [ ] Active/inactive toggle works

### 3. Food Item Management
- [ ] Can view food items list
- [ ] Can filter/sort by category
- [ ] Can create new food item with all fields
- [ ] Price formats correctly (2 decimals)
- [ ] Image upload works for food items
- [ ] Can edit food item
- [ ] Can delete food item
- [ ] Availability toggle works
- [ ] Items display in specified order

### 4. Discount Management
- [ ] Can view discounts list
- [ ] Can create discount with percentage type
- [ ] Can create discount with fixed amount type
- [ ] Can set item-specific discount
- [ ] Can create site-wide discount (no item selected)
- [ ] Date range validation works
- [ ] Can edit discount details
- [ ] Can delete discount
- [ ] Active/inactive toggle works
- [ ] Expired discounts don't apply to new orders

### 5. Restaurant Settings
- [ ] Can view settings page
- [ ] Can set opening time
- [ ] Can set closing time
- [ ] Time format is correct (HH:MM)
- [ ] Can add holiday date
- [ ] Can remove holiday
- [ ] Holiday list displays all dates
- [ ] Settings persist after page refresh

### 6. Order Management - List View
- [ ] Can view all orders with pagination
- [ ] See order statistics (total, pending, unpaid, revenue)
- [ ] Order cards show status with color coding
- [ ] Customer name and phone visible
- [ ] Order total displayed correctly
- [ ] Payment status shows (Paid/Unpaid)
- [ ] Can update order status via dropdown
- [ ] Can mark unpaid order as paid
- [ ] Can click "View Details" for more info

### 7. Order Management - Detail View
- [ ] Can view individual order details
- [ ] Customer information displayed
- [ ] Full itemized list with quantities
- [ ] Discount breakdown shown (original, discount, final)
- [ ] Payment status with timestamp if paid
- [ ] Can update order status
- [ ] Can mark as paid if unpaid
- [ ] Timeline shows creation and update times
- [ ] Back button returns to orders list

## Staff Features Testing

### 1. Authentication
- [ ] Can login with staff@example.com / password
- [ ] Non-staff users cannot access staff panel
- [ ] Staff middleware works correctly

### 2. Dashboard
- [ ] Can view staff dashboard
- [ ] See pending orders count
- [ ] See preparing orders count
- [ ] See ready orders count
- [ ] Order cards display with relevant info
- [ ] Can update order status
- [ ] Status changes immediately update counter

## Admin Access Control Testing

### 1. Role-Based Access
- [ ] Admin can access /admin/*  routes
- [ ] Staff cannot access /admin/* routes (redirected to home)
- [ ] Customer cannot access /admin/* routes
- [ ] Unauthenticated users cannot access /admin/* routes

### 2. Role-Based Access for Staff
- [ ] Staff can access /staff/dashboard
- [ ] Admin can access /staff/dashboard
- [ ] Customer cannot access /staff/dashboard
- [ ] Unauthenticated users cannot access /staff/dashboard

## Data Integrity Testing

### 1. Order Creation
- [ ] Order number auto-generates in correct format (ORD-YYYYMMDD-XXXXX)
- [ ] Each order has unique order number
- [ ] Order stores customer info correctly
- [ ] Order items reference correct food items
- [ ] Prices captured accurately at order time
- [ ] Discount amounts calculated correctly

### 2. Discount Application
- [ ] Discount applies only during valid date range
- [ ] Percentage discount calculates correctly
- [ ] Fixed amount discount applies correctly
- [ ] Item-specific discount only applies to that item
- [ ] Multiple items with discounts calculate independently

### 3. Stock Management
- [ ] Available/unavailable toggle prevents ordering unavailable items
- [ ] Unavailable items don't appear in cart calculations

## User Interface Testing

### 1. Responsiveness
- [ ] All pages render correctly on desktop (1920x1080)
- [ ] All pages render correctly on tablet (768x1024)
- [ ] All pages render correctly on mobile (375x667)
- [ ] Navigation works on all screen sizes
- [ ] Forms are usable on mobile

### 2. Visual Design
- [ ] Tailwind CSS styling applied consistently
- [ ] Colors and spacing look professional
- [ ] Text is readable (good contrast)
- [ ] Images load and display correctly
- [ ] Buttons are clearly clickable

### 3. Forms
- [ ] Form validation works on client-side
- [ ] Form validation works on server-side
- [ ] Error messages display clearly
- [ ] Success messages display after actions
- [ ] Required fields marked appropriately

## Error Handling Testing

### 1. Invalid Operations
- [ ] Cannot add non-existent item to cart
- [ ] Cannot checkout with empty cart
- [ ] Cannot create category without name
- [ ] Cannot create food item without required fields
- [ ] Cannot set invalid discount dates
- [ ] Database errors handled gracefully

### 2. Edge Cases
- [ ] Very long item names render correctly
- [ ] Very high prices format correctly
- [ ] Empty descriptions handled
- [ ] Missing images show placeholder
- [ ] Empty discounts list shows message

## Performance Testing

### 1. Page Load Times
- [ ] Homepage loads in < 2 seconds
- [ ] Admin pages load in < 2 seconds
- [ ] Cart operations < 500ms
- [ ] Order creation < 1 second

### 2. Database
- [ ] Can handle 100+ orders
- [ ] Category/item queries don't N+1
- [ ] Order list pagination works
- [ ] Searches complete quickly

## Security Testing

### 1. Authentication
- [ ] Cannot login with wrong password
- [ ] Cannot access protected routes without auth
- [ ] Logout works correctly
- [ ] Session expires appropriately

### 2. Authorization
- [ ] Users can only access their role's routes
- [ ] Cannot modify other users' data
- [ ] Cannot escalate privileges
- [ ] CSRF protection working

### 3. Input Validation
- [ ] XSS attempts don't execute
- [ ] SQL injection attempts fail
- [ ] Invalid data types rejected
- [ ] File uploads validated

## Sample Data Testing

### 1. Seeded Data
- [ ] Admin user created and can login
- [ ] Staff user created and can login
- [ ] Customer user created and can login
- [ ] 4 categories created
- [ ] 13 food items created
- [ ] Sample discount created for Spring Rolls
- [ ] Restaurant settings populated

### 2. Test Workflow
- [ ] Can complete full customer journey from menu to order
- [ ] Can process admin functions
- [ ] Can process staff functions

## Browser Compatibility

- [ ] Chrome latest
- [ ] Firefox latest
- [ ] Safari latest
- [ ] Edge latest
- [ ] Mobile Safari (iOS)
- [ ] Chrome (Android)

## Checklist Summary

Total Test Cases: _____ 
Passed: _____ 
Failed: _____ 
Skipped: _____ 

**Test Date:** _______________
**Tested By:** _______________
**Notes:** ___________________________

---

## Known Limitations

- [ ] WhatsApp notifications not implemented (requires Vonage setup)
- [ ] Real-time order notifications not implemented (requires WebSockets)
- [ ] Order tracking page for customers not implemented
- [ ] Payment gateway not integrated
- [ ] Cart not persistent across browser sessions
- [ ] No inventory management system

## Recommended Next Steps

1. Implement WhatsApp notification service
2. Add real-time order notifications
3. Create customer order tracking page
4. Integrate payment gateway
5. Add inventory management
6. Implement order rating system
7. Add analytics dashboard
8. Set up email notifications
