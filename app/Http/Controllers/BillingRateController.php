<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBillingRateRequest;
use App\Models\BillingRate;
use Inertia\Inertia;

class BillingRateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $billingRates = BillingRate::orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->paginate(12);
        
        return Inertia::render('billing-rates/index', [
            'billingRates' => $billingRates
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('billing-rates/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBillingRateRequest $request)
    {
        // Deactivate existing rate for the same month/year if it exists
        BillingRate::where('month', $request->month)
            ->where('year', $request->year)
            ->where('is_active', true)
            ->update(['is_active' => false]);

        $billingRate = BillingRate::create(array_merge(
            $request->validated(),
            ['is_active' => true]
        ));

        return redirect()->route('billing-rates.index')
            ->with('success', 'Billing rate created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BillingRate $billingRate)
    {
        return Inertia::render('billing-rates/show', [
            'billingRate' => $billingRate
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BillingRate $billingRate)
    {
        return Inertia::render('billing-rates/edit', [
            'billingRate' => $billingRate
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBillingRateRequest $request, BillingRate $billingRate)
    {
        $billingRate->update($request->validated());

        return redirect()->route('billing-rates.show', $billingRate)
            ->with('success', 'Billing rate updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BillingRate $billingRate)
    {
        $billingRate->delete();

        return redirect()->route('billing-rates.index')
            ->with('success', 'Billing rate deleted successfully.');
    }
}