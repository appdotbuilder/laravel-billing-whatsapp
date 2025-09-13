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
        Schema::create('billing_rates', function (Blueprint $table) {
            $table->id();
            $table->decimal('price_per_cubic_meter', 10, 2);
            $table->integer('month');
            $table->integer('year');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Indexes
            $table->index(['month', 'year']);
            $table->index('is_active');
            
            // Unique constraint to prevent duplicate rates for same month/year
            $table->unique(['month', 'year', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_rates');
    }
};