<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\FoodItem;
use App\Models\Discount;
use App\Models\RestaurantSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
            'is_staff' => true,
        ]);

        // Create Staff User
        User::factory()->create([
            'name' => 'Staff User',
            'email' => 'staff@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
            'is_staff' => true,
        ]);

        // Create Regular Customer
        User::factory()->create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
            'is_staff' => false,
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Appetizers', 'description' => 'Delicious starters to begin your meal'],
            ['name' => 'Main Courses', 'description' => 'Hearty and satisfying main dishes'],
            ['name' => 'Desserts', 'description' => 'Sweet treats to end your meal'],
            ['name' => 'Beverages', 'description' => 'Refreshing drinks and beverages'],
        ];

        foreach ($categories as $index => $categoryData) {
            Category::create([
                'name' => $categoryData['name'],
                'description' => $categoryData['description'],
                'image' => 'https://via.placeholder.com/300x200?text=' . urlencode($categoryData['name']),
                'order' => $index + 1,
                'active' => true,
            ]);
        }

        // Create Food Items
        $foodItems = [
            ['category' => 'Appetizers', 'name' => 'Spring Rolls', 'price' => 4.99, 'description' => 'Crispy spring rolls with sweet dipping sauce'],
            ['category' => 'Appetizers', 'name' => 'Nachos Supreme', 'price' => 6.99, 'description' => 'Loaded nachos with cheese, jalapeños, and sour cream'],
            ['category' => 'Appetizers', 'name' => 'Garlic Bread', 'price' => 3.99, 'description' => 'Toasted bread with garlic butter and herbs'],
            
            ['category' => 'Main Courses', 'name' => 'Grilled Chicken Breast', 'price' => 12.99, 'description' => 'Tender grilled chicken with seasonal vegetables'],
            ['category' => 'Main Courses', 'name' => 'Ribeye Steak', 'price' => 18.99, 'description' => 'Premium aged ribeye steak, cooked to perfection'],
            ['category' => 'Main Courses', 'name' => 'Salmon Fillet', 'price' => 15.99, 'description' => 'Fresh salmon with lemon butter sauce'],
            ['category' => 'Main Courses', 'name' => 'Vegetarian Pasta', 'price' => 10.99, 'description' => 'Penne pasta with seasonal vegetables and basil'],
            
            ['category' => 'Desserts', 'name' => 'Chocolate Cake', 'price' => 5.99, 'description' => 'Rich chocolate layer cake with frosting'],
            ['category' => 'Desserts', 'name' => 'Tiramisu', 'price' => 6.99, 'description' => 'Traditional Italian tiramisu with mascarpone'],
            ['category' => 'Desserts', 'name' => 'Ice Cream Sundae', 'price' => 4.99, 'description' => 'Vanilla ice cream with chocolate sauce and nuts'],
            
            ['category' => 'Beverages', 'name' => 'Iced Tea', 'price' => 2.99, 'description' => 'Refreshing iced tea'],
            ['category' => 'Beverages', 'name' => 'Fresh Lemonade', 'price' => 3.49, 'description' => 'Freshly squeezed lemonade'],
            ['category' => 'Beverages', 'name' => 'Soft Drink', 'price' => 1.99, 'description' => 'Classic soft drink'],
        ];

        foreach ($foodItems as $item) {
            $category = Category::where('name', $item['category'])->first();
            if ($category) {
                FoodItem::create([
                    'category_id' => $category->id,
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'image' => 'https://via.placeholder.com/300x200?text=' . urlencode($item['name']),
                    'available' => true,
                ]);
            }
        }

        // Create Sample Discounts
        $appetizer = Category::where('name', 'Appetizers')->first();
        if ($appetizer) {
            $springRoll = FoodItem::where('name', 'Spring Rolls')->first();
            if ($springRoll) {
                Discount::create([
                    'food_item_id' => $springRoll->id,
                    'name' => '20% Spring Rolls Discount',
                    'description' => 'Limited time offer on spring rolls',
                    'type' => 'percentage',
                    'value' => 20,
                    'start_date' => now(),
                    'end_date' => now()->addDays(30),
                    'active' => true,
                ]);
            }
        }

        // Create Restaurant Settings
        RestaurantSetting::updateOrCreate(
            ['key' => 'open_time'],
            ['value' => '09:00', 'type' => 'time']
        );

        RestaurantSetting::updateOrCreate(
            ['key' => 'close_time'],
            ['value' => '22:00', 'type' => 'time']
        );

        RestaurantSetting::updateOrCreate(
            ['key' => 'restaurant_name'],
            ['value' => 'Estilo Jalisco', 'type' => 'string']
        );

        RestaurantSetting::updateOrCreate(
            ['key' => 'phone'],
            ['value' => '+1-555-0123', 'type' => 'string']
        );
    }
}
