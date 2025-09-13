<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWhatsappTemplateRequest;
use App\Http\Requests\UpdateWhatsappTemplateRequest;
use App\Models\WhatsappTemplate;
use Inertia\Inertia;

class WhatsappTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = WhatsappTemplate::latest()->paginate(10);
        
        return Inertia::render('whatsapp-templates/index', [
            'templates' => $templates
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('whatsapp-templates/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWhatsappTemplateRequest $request)
    {
        $template = WhatsappTemplate::create($request->validated());

        return redirect()->route('whatsapp-templates.show', $template)
            ->with('success', 'WhatsApp template created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WhatsappTemplate $whatsappTemplate)
    {
        return Inertia::render('whatsapp-templates/show', [
            'template' => $whatsappTemplate
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WhatsappTemplate $whatsappTemplate)
    {
        return Inertia::render('whatsapp-templates/edit', [
            'template' => $whatsappTemplate
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWhatsappTemplateRequest $request, WhatsappTemplate $whatsappTemplate)
    {
        $whatsappTemplate->update($request->validated());

        return redirect()->route('whatsapp-templates.show', $whatsappTemplate)
            ->with('success', 'WhatsApp template updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WhatsappTemplate $whatsappTemplate)
    {
        $whatsappTemplate->delete();

        return redirect()->route('whatsapp-templates.index')
            ->with('success', 'WhatsApp template deleted successfully.');
    }
}