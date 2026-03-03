<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransactionController extends Controller
{
    private function checkTransactionAccess()
    {
        if (auth()->check() && !in_array(auth()->user()->role, ['Administrator', 'Cashier'])) {
            abort(403, 'Unauthorized. Only Cashiers and Administrators can manage Transactions.');
        }
    }

    private function applyWarrantyIfPaid(\App\Models\Transaction $transaction)
    {
        if ($transaction->payment_status === 'Paid') {
            $report = clone $transaction->report;
            if ($report && $report->appliance) {
                // Determine duration based on size (1, 3, or 6 months)
                $months = 0;
                $size = $report->appliance->appliance_size;
                if ($size === 'Small')
                    $months = 1;
                elseif ($size === 'Medium')
                    $months = 3;
                elseif ($size === 'Large')
                    $months = 6;

                if ($months > 0) {
                    $report->appliance->update([
                        'warranty_end' => now()->addMonths($months)
                    ]);
                }
            }
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
            'labor' => 'required|numeric|min:300',
            'materials' => 'required|numeric|min:0',
            'delivery' => 'required|numeric|min:300',
            'payment_status' => 'required|string|in:Paid,Unpaid,Partial',
        ], [
            'labor.min' => 'Labor cost must be at least ₱300.',
            'delivery.min' => 'Delivery cost must be at least ₱300.',
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
        $transaction = \App\Models\Transaction::create([
            'report_id' => $report->id,
            'parts_total' => $validated['materials'],
            'labor_total' => $validated['labor'],
            'total_amount' => $totalAmount,
            'payment_status' => $validated['payment_status'],
            'payment_date' => $validated['payment_status'] == 'Paid' ? now() : null,
            'received_by' => auth()->user() ? auth()->user()->first_name . ' ' . auth()->user()->last_name : 'System',
        ]);

        // Create PayMongo Payment Link if total >= 100 and not Paid
        if ($validated['payment_status'] !== 'Paid' && $totalAmount >= 100) {
            try {
                $response = Http::withBasicAuth(env('PAYMONGO_SECRET_KEY'), '')
                    ->withHeaders([
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ])
                    ->post('https://api.paymongo.com/v1/links', [
                    'data' => [
                        'attributes' => [
                            'amount' => intval($totalAmount * 100),
                            'description' => 'Repair Service Payment for Report #' . $report->id,
                            'remarks' => 'Transaction #' . $transaction->id
                        ]
                    ]
                ]);

                if ($response->successful()) {
                    $paymongoData = $response->json()['data'];
                    $transaction->update([
                        'paymongo_link_id' => $paymongoData['id'],
                        'payment_url' => $paymongoData['attributes']['checkout_url']
                    ]);
                }
            }
            catch (\Exception $e) {
                // Log error or ignore to prevent breaking the flow
                \Log::error('PayMongo Link Creation Failed: ' . $e->getMessage());
            }
        }

        $this->applyWarrantyIfPaid($transaction);

        return redirect()->route('transactions.index')->with('success', 'Transaction recorded successfully.');
    }

    public function paymongoWebhook(Request $request)
    {
        $payload = $request->all();

        // Check if this is a payment paid event from PayMongo
        if (isset($payload['data']['type']) && $payload['data']['type'] === 'event' && $payload['data']['attributes']['type'] === 'link.payment.paid') {

            // Extract the link ID that was just paid 
            $linkId = $payload['data']['attributes']['data']['attributes']['link_id'] ?? null;

            if ($linkId) {
                // Find our transaction matching this exact PayMongo Link
                $transaction = \App\Models\Transaction::where('paymongo_link_id', $linkId)->first();

                if ($transaction && $transaction->payment_status !== 'Paid') {
                    $transaction->update([
                        'payment_status' => 'Paid',
                        'payment_date' => now(),
                        // Could record 'amount' from payload if needed, but we trust the link generated.
                    ]);

                    // Trigger the warranty logic if applicable
                    $this->applyWarrantyIfPaid($transaction);

                    \Log::info("Webhook Success: Transaction #{$transaction->id} automatically marked as Paid.");
                }
            }
        }

        // Always return 200 OK so PayMongo knows we received it
        return response()->json(['status' => 'success']);
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

        if (isset($validated['payment_status'])) {
            if ($validated['payment_status'] === 'Paid' && !$transaction->payment_date) {
                $transaction->update(['payment_date' => now()]);
            }
            $this->applyWarrantyIfPaid($transaction);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    public function destroy(\App\Models\Transaction $transaction)
    {
        $this->checkTransactionAccess();
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}
