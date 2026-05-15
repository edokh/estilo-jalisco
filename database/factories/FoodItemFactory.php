<?php

namespace Database\Factories;

use App\Models\FoodItem;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FoodItem>
 */
class FoodItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(500, 5000) / 100,
            'image' => 'https://via.placeholder.com/300x200?text=' . urlencode($this->faker->word()),
            'available' => true,
            'order' => $this->faker->numberBetween(1, 20),
        ];
    }
}
