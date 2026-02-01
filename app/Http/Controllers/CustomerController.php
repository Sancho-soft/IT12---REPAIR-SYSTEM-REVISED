<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = \App\Models\Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone_no' => 'nullable|string|max:20',
        ]);

        \App\Models\Customer::create($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function show(\App\Models\Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    public function edit(\App\Models\Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Customer $customer)
    {
        $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone_no' => 'nullable|string|max:20',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(\App\Models\Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
