<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with(['customer', 'customerUsage'])
            ->latest()
            ->paginate(10);
        
        return Inertia::render('invoices/index', [
            'invoices' => $invoices
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'customerUsage']);
        
        return Inertia::render('invoices/show', [
            'invoice' => $invoice
        ]);
    }

    /**
     * Mark invoice as paid.
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'payment_amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
        ]);

        $invoice = Invoice::findOrFail($request->invoice_id);
        
        $invoice->update([
            'status' => 'paid',
            'payment_amount' => $request->payment_amount,
            'payment_date' => $request->payment_date,
        ]);

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Payment recorded successfully.');
    }

    /**
     * Download invoice as PDF.
     */
    public function edit(Invoice $invoice)
    {
        $invoice->load(['customer', 'customerUsage']);
        
        // For now, return a view that can be used to generate PDF
        // In a real implementation, you would use a PDF library like DOMPDF
        return Inertia::render('invoices/pdf', [
            'invoice' => $invoice
        ]);
    }

    /**
     * Update invoice status.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'status' => 'required|in:paid,unpaid,overdue',
        ]);

        $invoice->update([
            'status' => $request->status,
        ]);

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice status updated successfully.');
    }
}