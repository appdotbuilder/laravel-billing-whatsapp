<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerUsageRequest;
use App\Models\Customer;
use App\Models\CustomerUsage;
use App\Models\BillingRate;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class CustomerUsageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usages = CustomerUsage::with(['customer', 'invoice'])
            ->latest()
            ->paginate(10);
        
        return Inertia::render('usages/index', [
            'usages' => $usages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::active()->get();
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        // Get current billing rate
        $currentRate = BillingRate::where('month', $currentMonth)
            ->where('year', $currentYear)
            ->where('is_active', true)
            ->first();
        
        return Inertia::render('usages/create', [
            'customers' => $customers,
            'currentMonth' => $currentMonth,
            'currentYear' => $currentYear,
            'currentRate' => $currentRate
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerUsageRequest $request)
    {
        $validated = $request->validated();
        
        // Get billing rate for the specified month/year
        $billingRate = BillingRate::where('month', $validated['month'])
            ->where('year', $validated['year'])
            ->where('is_active', true)
            ->first();
            
        if (!$billingRate) {
            return back()->withErrors(['month' => 'No billing rate found for the selected month/year.']);
        }
        
        // Calculate total amount
        $totalAmount = $validated['cubic_meters'] * $billingRate->price_per_cubic_meter;
        
        $usage = CustomerUsage::create([
            'customer_id' => $validated['customer_id'],
            'cubic_meters' => $validated['cubic_meters'],
            'month' => $validated['month'],
            'year' => $validated['year'],
            'rate_per_cubic_meter' => $billingRate->price_per_cubic_meter,
            'total_amount' => $totalAmount,
        ]);
        
        // Generate invoice
        $this->generateInvoice($usage);

        return redirect()->route('usages.index')
            ->with('success', 'Customer usage recorded and invoice generated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerUsage $usage)
    {
        $usage->load(['customer', 'invoice']);
        
        return Inertia::render('usages/show', [
            'usage' => $usage
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerUsage $usage)
    {
        $customers = Customer::active()->get();
        
        return Inertia::render('usages/edit', [
            'usage' => $usage,
            'customers' => $customers
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCustomerUsageRequest $request, CustomerUsage $usage)
    {
        $validated = $request->validated();
        
        // Get billing rate for the specified month/year
        $billingRate = BillingRate::where('month', $validated['month'])
            ->where('year', $validated['year'])
            ->where('is_active', true)
            ->first();
            
        if (!$billingRate) {
            return back()->withErrors(['month' => 'No billing rate found for the selected month/year.']);
        }
        
        // Calculate total amount
        $totalAmount = $validated['cubic_meters'] * $billingRate->price_per_cubic_meter;
        
        $usage->update([
            'customer_id' => $validated['customer_id'],
            'cubic_meters' => $validated['cubic_meters'],
            'month' => $validated['month'],
            'year' => $validated['year'],
            'rate_per_cubic_meter' => $billingRate->price_per_cubic_meter,
            'total_amount' => $totalAmount,
        ]);
        
        // Update invoice amount
        if ($usage->invoice) {
            $usage->invoice->update(['amount' => $totalAmount]);
        }

        return redirect()->route('usages.show', $usage)
            ->with('success', 'Customer usage updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerUsage $usage)
    {
        // Delete associated invoice if exists
        if ($usage->invoice) {
            $usage->invoice->delete();
        }
        
        $usage->delete();

        return redirect()->route('usages.index')
            ->with('success', 'Customer usage deleted successfully.');
    }

    /**
     * Generate invoice for the usage.
     */
    protected function generateInvoice(CustomerUsage $usage): void
    {
        $invoiceNumber = 'INV-' . $usage->year . str_pad((string)$usage->month, 2, '0', STR_PAD_LEFT) . '-' . str_pad((string)$usage->customer_id, 4, '0', STR_PAD_LEFT);
        
        // Due date is always 10th of the month
        $dueDate = Carbon::create($usage->year, $usage->month, 10);
        
        Invoice::create([
            'invoice_number' => $invoiceNumber,
            'customer_id' => $usage->customer_id,
            'customer_usage_id' => $usage->id,
            'amount' => $usage->total_amount,
            'status' => 'unpaid',
            'due_date' => $dueDate,
            'month' => $usage->month,
            'year' => $usage->year,
        ]);
    }
}