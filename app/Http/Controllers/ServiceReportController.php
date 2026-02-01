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
        return view('services.create');
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
