<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SalesInvoice>
 */
class SalesInvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_number' => $this->faker->unique()->numerify('INV####'),
            'user_id' => \App\Models\User::factory(),
            'invoice_type_id' => \App\Models\InvoiceType::factory(),
            'total_amount' => $this->faker->numberBetween(500, 5000),
            'discount' => $this->faker->numberBetween(0, 500),
            'customer_name' => $this->faker->word(),
            'paid_amount' => $this->faker->numberBetween(500, 5000),
            //'payment_method' => $this->faker->randomElement(['cash', 'network']),
        ];
    }
}
