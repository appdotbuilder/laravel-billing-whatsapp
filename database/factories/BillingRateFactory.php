<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BillingRate>
 */
class BillingRateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price_per_cubic_meter' => fake()->randomFloat(2, 5000, 15000),
            'month' => fake()->numberBetween(1, 12),
            'year' => fake()->numberBetween(2020, 2024),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the billing rate is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}