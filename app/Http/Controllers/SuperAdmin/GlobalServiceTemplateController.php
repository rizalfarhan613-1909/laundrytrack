<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\GlobalServiceTemplate;
use Illuminate\Http\Request;

class GlobalServiceTemplateController extends Controller
{
    public function index()
    {
        $templates = GlobalServiceTemplate::latest()->paginate(10);
        return view('superadmin.templates.index', compact('templates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'base_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        GlobalServiceTemplate::create($validated);

        return redirect()->route('ceo.templates.index')->with('success', 'Template Layanan Global berhasil ditambahkan.');
    }

    public function update(Request $request, GlobalServiceTemplate $template)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'base_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $template->update($validated);

        return redirect()->route('ceo.templates.index')->with('success', 'Template Layanan Global berhasil diperbarui.');
    }

    public function destroy(GlobalServiceTemplate $template)
    {
        $template->delete();

        return redirect()->route('ceo.templates.index')->with('success', 'Template Layanan Global berhasil dihapus.');
    }
}