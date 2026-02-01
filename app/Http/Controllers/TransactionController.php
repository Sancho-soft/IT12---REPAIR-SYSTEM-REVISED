<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = \App\Models\Transaction::with('report')->latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'report_id' => 'required|exists:service_reports,id',
            'total_amount' => 'required|numeric',
            'payment_status' => 'required|string',
        ]);

        \App\Models\Transaction::create($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaction recorded successfully.');
    }

    public function show(\App\Models\Transaction $transaction)
    {
        return view('transactions.show', compact('transaction'));
    }

    public function edit(\App\Models\Transaction $transaction)
    {
        return view('transactions.edit', compact('transaction'));
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Transaction $transaction)
    {
        $validated = $request->validate([
            'total_amount' => 'numeric',
            'payment_status' => 'string',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    public function destroy(\App\Models\Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}
