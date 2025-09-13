<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\BillingRate;
use App\Models\CustomerUsage;
use App\Models\WhatsappTemplate;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class WaterBillingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create WhatsApp templates
        WhatsappTemplate::create([
            'name' => 'Monthly Meter Reading Request',
            'type' => 'meter_reading_request',
            'message' => 'Halo {customer_name}, mohon kirim foto meteran air bulan ini sebelum tanggal 5. Terima kasih!',
            'is_active' => true,
        ]);

        WhatsappTemplate::create([
            'name' => 'Payment Reminder',
            'type' => 'payment_reminder',
            'message' => 'Halo {customer_name}, tagihan air bulan {month} sebesar {amount} telah jatuh tempo pada tanggal 10. Mohon segera dibayar. Terima kasih!',
            'is_active' => true,
        ]);

        // Create billing rates for current month
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        BillingRate::create([
            'price_per_cubic_meter' => 10000,
            'month' => $currentMonth,
            'year' => $currentYear,
            'is_active' => true,
        ]);

        // Create sample customers
        $customers = [
            [
                'name' => 'Budi Santoso',
                'whatsapp_number' => '+6281234567890',
                'address' => 'Jl. Merdeka No. 123, Jakarta Pusat',
                'is_active' => true,
            ],
            [
                'name' => 'Siti Rahayu',
                'whatsapp_number' => '+6281234567891',
                'address' => 'Jl. Sudirman No. 456, Jakarta Selatan',
                'is_active' => true,
            ],
            [
                'name' => 'Ahmad Wijaya',
                'whatsapp_number' => '+6281234567892',
                'address' => 'Jl. Thamrin No. 789, Jakarta Pusat',
                'is_active' => true,
            ],
            [
                'name' => 'Dewi Lestari',
                'whatsapp_number' => '+6281234567893',
                'address' => 'Jl. Gatot Subroto No. 101, Jakarta Selatan',
                'is_active' => true,
            ],
            [
                'name' => 'Eko Prasetyo',
                'whatsapp_number' => '+6281234567894',
                'address' => 'Jl. Kuningan No. 202, Jakarta Selatan',
                'is_active' => false,
            ],
        ];

        foreach ($customers as $customerData) {
            $customer = Customer::create($customerData);
            
            // Create sample usage for active customers (last 3 months)
            if ($customer->is_active) {
                for ($i = 2; $i >= 0; $i--) {
                    $date = now()->subMonths($i);
                    $month = $date->month;
                    $year = $date->year;
                    
                    // Get billing rate for that month (or use current)
                    $billingRate = BillingRate::where('month', $month)
                        ->where('year', $year)
                        ->where('is_active', true)
                        ->first();
                        
                    if (!$billingRate) {
                        // Create billing rate for past months if not exists
                        $billingRate = BillingRate::create([
                            'price_per_cubic_meter' => 9500 + random_int(0, 1000), // Slightly varying rates
                            'month' => $month,
                            'year' => $year,
                            'is_active' => true,
                        ]);
                    }
                    
                    $cubicMeters = random_int(10, 50) + (random_int(0, 99) / 100); // 10.00 to 50.99
                    $totalAmount = $cubicMeters * $billingRate->price_per_cubic_meter;
                    
                    CustomerUsage::create([
                        'customer_id' => $customer->id,
                        'cubic_meters' => $cubicMeters,
                        'month' => $month,
                        'year' => $year,
                        'rate_per_cubic_meter' => $billingRate->price_per_cubic_meter,
                        'total_amount' => $totalAmount,
                    ]);
                }
            }
        }
    }
}