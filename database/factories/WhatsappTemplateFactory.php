<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WhatsappTemplate>
 */
class WhatsappTemplateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['meter_reading_request', 'payment_reminder']);
        
        $messages = [
            'meter_reading_request' => 'Halo {customer_name}, mohon kirim foto meteran air bulan ini. Terima kasih!',
            'payment_reminder' => 'Halo {customer_name}, tagihan air bulan {month} sebesar Rp {amount} telah jatuh tempo. Mohon segera dibayar. Terima kasih!',
        ];

        return [
            'name' => fake()->sentence(3),
            'type' => $type,
            'message' => $messages[$type],
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the template is for meter reading requests.
     */
    public function meterReadingRequest(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'meter_reading_request',
            'message' => 'Halo {customer_name}, mohon kirim foto meteran air bulan ini. Terima kasih!',
        ]);
    }

    /**
     * Indicate that the template is for payment reminders.
     */
    public function paymentReminder(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'payment_reminder',
            'message' => 'Halo {customer_name}, tagihan air bulan {month} sebesar Rp {amount} telah jatuh tempo. Mohon segera dibayar. Terima kasih!',
        ]);
    }

    /**
     * Indicate that the template is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}