<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerUsage>
 */
class CustomerUsageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cubicMeters = fake()->randomFloat(2, 5, 50);
        $ratePerCubicMeter = fake()->randomFloat(2, 8000, 12000);
        $totalAmount = $cubicMeters * $ratePerCubicMeter;

        return [
            'customer_id' => Customer::factory(),
            'cubic_meters' => $cubicMeters,
            'month' => fake()->numberBetween(1, 12),
            'year' => fake()->numberBetween(2020, 2024),
            'rate_per_cubic_meter' => $ratePerCubicMeter,
            'total_amount' => $totalAmount,
        ];
    }
}