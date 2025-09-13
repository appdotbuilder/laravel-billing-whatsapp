<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\CustomerUsage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customer = Customer::factory()->create();
        $usage = CustomerUsage::factory()->for($customer)->create();
        
        return [
            'invoice_number' => 'INV-' . fake()->unique()->numerify('######'),
            'customer_id' => $customer->id,
            'customer_usage_id' => $usage->id,
            'amount' => $usage->total_amount,
            'status' => fake()->randomElement(['paid', 'unpaid', 'overdue']),
            'due_date' => fake()->date(),
            'month' => $usage->month,
            'year' => $usage->year,
            'payment_amount' => null,
            'payment_date' => null,
        ];
    }

    /**
     * Indicate that the invoice is paid.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
            'payment_amount' => $attributes['amount'],
            'payment_date' => fake()->date(),
        ]);
    }

    /**
     * Indicate that the invoice is overdue.
     */
    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'overdue',
            'due_date' => fake()->dateTimeBetween('-30 days', '-1 day'),
        ]);
    }
}