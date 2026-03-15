<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private function checkCustomerAccess()
    {
        if (auth()->check() && !in_array(auth()->user()->role, ['Administrator', 'Secretary'])) {
            abort(403, 'Unauthorized. Only Secretaries and Administrators can manage Customers.');
        }
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $hasAppliances = $request->input('has_appliances');

        $customers = \App\Models\Customer::with('appliances')
            ->when($search, function ($q) use ($search) {
            $q->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%")
                        ->orWhere('phone_no', 'like', "%$search%");
                }
                );
            })
            ->when($hasAppliances, function ($q) use ($hasAppliances) {
            if ($hasAppliances === 'yes') {
                $q->has('appliances');
            }
            elseif ($hasAppliances === 'no') {
                $q->doesntHave('appliances');
            }
        })
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('customers.index', compact('customers', 'search', 'hasAppliances'));
    }

    public function create()
    {
        $this->checkCustomerAccess();
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $this->checkCustomerAccess();
        $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone_no' => 'required|numeric|digits_between:7,15',
        ], [
            'phone_no.required' => 'The phone number is required.',
            'phone_no.numeric' => 'The phone number must contain only numbers.',
            'phone_no.digits_between' => 'The phone number must be between 7 and 15 digits.',
        ]);

        \App\Models\Customer::create($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function show(\App\Models\Customer $customer)
    {
        $customer->load(['appliances', 'serviceReports' => function ($q) {
            $q->latest()->with('appliance');
        }]);
        return view('customers.show', compact('customer'));
    }

    public function edit(\App\Models\Customer $customer)
    {
        $this->checkCustomerAccess();
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, \App\Models\Customer $customer)
    {
        $this->checkCustomerAccess();
        $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone_no' => 'required|numeric|digits_between:7,15',
        ], [
            'phone_no.required' => 'The phone number is required.',
            'phone_no.numeric' => 'The phone number must contain only numbers.',
            'phone_no.digits_between' => 'The phone number must be between 7 and 15 digits.',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(\App\Models\Customer $customer)
    {
        $this->checkCustomerAccess();
        // Bypass $fillable: deleted_by should not be user-input controlled.
        $customer->forceFill(['deleted_by' => auth()->id()])->save();
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
