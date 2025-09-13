<?php

use App\Http\Controllers\BillingRateController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerUsageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\WhatsappTemplateController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Customer management
    Route::resource('customers', CustomerController::class);
    
    // Billing rates management
    Route::resource('billing-rates', BillingRateController::class);
    
    // Customer usage management
    Route::resource('usages', CustomerUsageController::class);
    
    // Invoice management
    Route::resource('invoices', InvoiceController::class)->except(['create', 'destroy']);
    
    // WhatsApp templates management
    Route::resource('whatsapp-templates', WhatsappTemplateController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
