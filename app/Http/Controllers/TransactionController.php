<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private function checkTransactionAccess()
    {
        if (auth()->check() && !in_array(auth()->user()->role, ['Administrator', 'Cashier'])) {
            abort(403, 'Unauthorized. Only Cashiers and Administrators can manage Transactions.');
        }
    }

    public function index()
    {
        $this->checkTransactionAccess();
        $transactions = \App\Models\Transaction::with('report')->latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $this->checkTransactionAccess();
        $reports = \App\Models\ServiceReport::with(['customer', 'appliance', 'details'])
            ->where('status', 'Completed')
            ->latest()
            ->get();

        return view('transactions.create', compact('reports'));
    }

    public function store(Request $request)
    {
        $this->checkTransactionAccess();
        $validated = $request->validate([
            'report_id' => 'required|exists:service_reports,id',
            'labor' => 'required|numeric|min:0',
            'materials' => 'required|numeric|min:0',
            'delivery' => 'required|numeric|min:0',
            'payment_status' => 'required|string|in:Paid,Unpaid,Partial',
        ]);

        $report = \App\Models\ServiceReport::find($validated['report_id']);
        if ($report->status !== 'Completed') {
            return back()->withInput()->with('error', 'Only Completed service reports can be paid.');
        }

        $totalAmount = $validated['labor'] + $validated['materials'] + $validated['delivery'];

        // Update ServiceDetail
        \App\Models\ServiceDetail::updateOrCreate(
            ['report_id' => $report->id],
            [
                'labor' => $validated['labor'],
                'parts_total_charge' => $validated['materials'],
                'pullout_delivery' => $validated['delivery'],
                'total_amount' => $totalAmount,
            ]
        );

        // Create transaction
        \App\Models\Transaction::create([
            'report_id' => $report->id,
            'parts_total' => $validated['materials'],
            'labor_total' => $validated['labor'],
            'total_amount' => $totalAmount,
            'payment_status' => $validated['payment_status'],
            'payment_date' => $validated['payment_status'] == 'Paid' ? now() : null,
            'received_by' => auth()->user() ? auth()->user()->first_name . ' ' . auth()->user()->last_name : 'System',
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction recorded successfully.');
    }

    public function show(\App\Models\Transaction $transaction)
    {
        $this->checkTransactionAccess();
        return view('transactions.show', compact('transaction'));
    }

    public function edit(\App\Models\Transaction $transaction)
    {
        $this->checkTransactionAccess();
        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, \App\Models\Transaction $transaction)
    {
        $this->checkTransactionAccess();
        $validated = $request->validate([
            'total_amount' => 'numeric',
            'payment_status' => 'string',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    public function destroy(\App\Models\Transaction $transaction)
    {
        $this->checkTransactionAccess();
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}
