<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->decimal('cubic_meters', 8, 2);
            $table->integer('month');
            $table->integer('year');
            $table->decimal('rate_per_cubic_meter', 10, 2);
            $table->decimal('total_amount', 12, 2);
            $table->timestamps();
            
            // Indexes
            $table->index(['customer_id', 'month', 'year']);
            $table->index(['month', 'year']);
            
            // Unique constraint to prevent duplicate usage for same customer/month/year
            $table->unique(['customer_id', 'month', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_usages');
    }
};