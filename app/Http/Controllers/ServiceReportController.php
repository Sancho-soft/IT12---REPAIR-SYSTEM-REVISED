<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceReportController extends Controller
{
    public function index()
    {
        $services = \App\Models\ServiceReport::orderBy('date_in', 'desc')->get();
        return view('services.index', compact('services'));
    }

    public function create()
    {
        $customers = \App\Models\Customer::all();
        return view('services.create', compact('customers'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string',
            'appliance_name' => 'required|string',
            'date_in' => 'required|date',
            'status' => 'required|string',
            'findings' => 'nullable|string',
        ]);

        // Find customer by full name
        $customer = \App\Models\Customer::whereRaw("CONCAT(first_name, ' ', last_name) = ?", [$request->customer_name])->first();

        if (!$customer) {
            return back()->withInput()->with('error', 'Customer not found. Please create the customer profile first or select from the suggestions.');
        }

        $validated['customer_id'] = $customer->id;

        // Check for duplicate service report
        $exists = \App\Models\ServiceReport::where('customer_id', $customer->id)
            ->where('appliance_name', $request->appliance_name)
            ->where('date_in', $request->date_in)
            ->where('status', $request->status)
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'A duplicate service report already exists for this customer, appliance, and date.');
        }

        \App\Models\ServiceReport::create($validated);

        return redirect()->route('services.index')->with('success', 'Service Report created successfully.');
    }

    public function show(\App\Models\ServiceReport $service)
    {
        $service->load(['comments.user', 'transactions']);
        return view('services.show', compact('service'));
    }

    public function edit(\App\Models\ServiceReport $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\ServiceReport $service)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string',
            'appliance_name' => 'required|string',
            'date_in' => 'required|date',
            'status' => 'required|string',
            'findings' => 'nullable|string',
        ]);

        $service->update($validated);

        return redirect()->route('services.index')->with('success', 'Service Report updated successfully.');
    }

    public function destroy(\App\Models\ServiceReport $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service Report deleted successfully.');
    }

    public function storeComment(\Illuminate\Http\Request $request, \App\Models\ServiceReport $service)
    {
        $request->validate([
            'comment_text' => 'required|string',
        ]);

        \App\Models\ServiceProgressComment::create([
            'report_id' => $service->id,
            'comment_text' => $request->comment_text,
            'created_by' => auth()->id(),
            'created_by_name' => auth()->user()->full_name, // Assuming full_name exists on User
            'progress_key' => 'update', // Default key
        ]);

        return back()->with('success', 'Comment added successfully.');
    }

    public function print(\App\Models\ServiceReport $service)
    {
        return view('services.print', compact('service'));
    }
}
