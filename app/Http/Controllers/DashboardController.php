<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\CustomerUsage;
use Inertia\Inertia;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        // Summary statistics
        $totalCustomers = Customer::active()->count();
        $totalInvoicesThisMonth = Invoice::where('month', $currentMonth)
            ->where('year', $currentYear)
            ->count();
        $totalRevenueThisMonth = Invoice::where('month', $currentMonth)
            ->where('year', $currentYear)
            ->where('status', 'paid')
            ->sum('amount');
        $unpaidInvoices = Invoice::where('status', 'unpaid')->count();
        
        // Recent customers
        $recentCustomers = Customer::with(['usages', 'invoices'])
            ->latest()
            ->limit(5)
            ->get();
        
        // Recent invoices
        $recentInvoices = Invoice::with(['customer'])
            ->latest()
            ->limit(5)
            ->get();
        
        // Monthly usage data for charts
        $monthlyUsage = CustomerUsage::selectRaw('month, year, SUM(cubic_meters) as total_usage, SUM(total_amount) as total_amount')
            ->where('year', $currentYear)
            ->groupBy('month', 'year')
            ->orderBy('month')
            ->get();
        
        // Payment status breakdown
        $paymentStats = Invoice::selectRaw('status, COUNT(*) as count, SUM(amount) as total_amount')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->groupBy('status')
            ->get();
        
        return Inertia::render('dashboard', [
            'stats' => [
                'totalCustomers' => $totalCustomers,
                'totalInvoicesThisMonth' => $totalInvoicesThisMonth,
                'totalRevenueThisMonth' => $totalRevenueThisMonth,
                'unpaidInvoices' => $unpaidInvoices,
            ],
            'recentCustomers' => $recentCustomers,
            'recentInvoices' => $recentInvoices,
            'monthlyUsage' => $monthlyUsage,
            'paymentStats' => $paymentStats,
            'currentMonth' => $currentMonth,
            'currentYear' => $currentYear,
        ]);
    }
}