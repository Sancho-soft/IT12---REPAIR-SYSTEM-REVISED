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

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'part_no' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'numeric',
            'quantity_stock' => 'integer',
        ]);

        \App\Models\Part::create($request->all());

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

    // Changing method signature to rely on Laravel's implicit binding resolution
    // If route param is 'inventory', I should match variable name or explicitly bind.
    // I'll stick to a simpler implementation for now.
    public function destroy($id)
    {
        \App\Models\Part::destroy($id);
        return redirect()->route('inventory.index')->with('success', 'Part deleted successfully.');
    }
}
