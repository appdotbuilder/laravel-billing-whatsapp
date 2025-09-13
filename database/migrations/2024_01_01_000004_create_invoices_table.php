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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_usage_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['unpaid', 'paid', 'overdue'])->default('unpaid');
            $table->date('due_date');
            $table->integer('month');
            $table->integer('year');
            $table->decimal('payment_amount', 12, 2)->nullable();
            $table->date('payment_date')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('invoice_number');
            $table->index('customer_id');
            $table->index('status');
            $table->index('due_date');
            $table->index(['month', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};