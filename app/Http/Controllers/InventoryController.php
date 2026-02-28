<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $parts = \App\Models\Part::all();
        return view('inventory.index', compact('parts'));
    }

    public function create()
    {
        return view('inventory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'numeric',
            'quantity_stock' => 'integer',
        ]);

        // Auto-generate Part Number (P-001, P-002, etc.)
        $latestPart = \App\Models\Part::orderBy('id', 'desc')->first();
        if ($latestPart && preg_match('/^P-(\d+)$/', $latestPart->part_no, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            // Fallback: count total parts if the latest doesn't match the format
            $nextNumber = \App\Models\Part::count() + 1;
        }
        $generatedPartNo = 'P-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $data = $request->all();
        $data['part_no'] = $generatedPartNo;

        \App\Models\Part::create($data);

        return redirect()->route('inventory.index')->with('success', 'Part added successfully.');
    }

    public function edit(\App\Models\Part $inventory) // Using $inventory to match route param usually, but simpler: $part
    {
        // Route resource maps 'inventory' to parameter names based on model or name.
        // 'inventory' resource -> 'inventory' param? Let's check route: Route::resource('inventory', ...).
        // Laravel logic: Singular of 'inventory' is 'inventory'. 
        // But model is Part.
        // I'll assume I can type hint Part but param might be $inventory.
        return view('inventory.edit', ['part' => $inventory]);
    }

    public function update(Request $request, \App\Models\Part $inventory)
    {
        $validated = $request->validate([
            'part_no' => 'required|string',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'quantity_stock' => 'required|integer',
        ]);

        $inventory->update($validated);

        return redirect()->route('inventory.index')->with('success', 'Part updated successfully.');
    }

    // Changing method signature to rely on Laravel's implicit binding resolution
    // If route param is 'inventory', I should match variable name or explicitly bind.
    // I'll stick to a simpler implementation for now.
    public function destroy($id)
    {
        \App\Models\Part::destroy($id);
        return redirect()->route('inventory.index')->with('success', 'Part deleted successfully.');
    }
}
