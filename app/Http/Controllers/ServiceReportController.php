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
            // Auto-create customer if not found
            $parts = explode(' ', $request->customer_name, 2);
            $firstName = $parts[0];
            $lastName = $parts[1] ?? '';

            $customer = \App\Models\Customer::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
            ]);
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

        if ($request->has('brand_model')) {
            $validated['remarks'] = $request->brand_model;
        }

        $report = \App\Models\ServiceReport::create($validated);

        // Create initial Service Detail
        \App\Models\ServiceDetail::create([
            'report_id' => $report->id,
            'service_types' => [], // Default empty array as it is required
            'labor' => $request->labor_cost ?? 0,
            'total_amount' => $request->labor_cost ?? 0,
            'complaint' => $request->problem_desc, // Also save problem desc as complaint
        ]);

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

        // Find customer by full name
        $customer = \App\Models\Customer::whereRaw("CONCAT(first_name, ' ', last_name) = ?", [$request->customer_name])->first();

        if (!$customer) {
            // Auto-create customer if not found
            $parts = explode(' ', $request->customer_name, 2);
            $firstName = $parts[0];
            $lastName = $parts[1] ?? '';

            $customer = \App\Models\Customer::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
            ]);
        }

        $validated['customer_id'] = $customer->id;

        // Map recommendation to findings
        if ($request->has('recommendation')) {
            $validated['findings'] = $request->recommendation;
        }

        // Map brand_model to remarks if accessible
        if ($request->has('brand_model')) {
            $validated['remarks'] = $request->brand_model;
        }

        $service->update($validated);

        // Update or Create ServiceDetail
        \App\Models\ServiceDetail::updateOrCreate(
            ['report_id' => $service->id],
            [
                'complaint' => $request->problem_desc,
                'labor' => $request->labor_cost ?? 0,
                'service_types' => $service->details ? $service->details->service_types : [], // Preserve or default
                // total_amount calculation? For now just use labor or keep existing logic
                'total_amount' => $request->labor_cost ?? ($service->details ? $service->details->total_amount : 0),
            ]
        );

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
