<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /*return [
            'category_id' => \App\Models\Category::factory(),
            'name' => $this->faker->word(),
            'price' => $this->faker->numberBetween(100, 1000),
            'stock_quantity' => $this->faker->numberBetween(0, 50),
            'stock' => $this->faker->numberBetween(0, 50),
            'status' => true,
        ];*/

        return [
    'category_id' => \App\Models\Category::factory(),
    'name' => $this->faker->word(),
    'price' => $this->faker->numberBetween(100, 1000),
    'stock' => $this->faker->numberBetween(0, 50), // استخدم فقط stock
    'status' => true,
];
    }
}
