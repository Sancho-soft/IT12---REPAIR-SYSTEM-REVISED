@extends('layouts.admin')

@section('title', 'Transaction Details')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="m-0">Transaction #{{ $transaction->id }}</h5>
                    <div>
                        <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-primary btn-sm">Edit</a>
                        <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-sm ml-1">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <span class="text-muted">Date:</span><br>
                            <strong>{{ $transaction->created_at->format('M d, Y H:i:s') }}</strong>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <span class="text-muted">Status:</span><br>
                            <span
                                class="badge {{ $transaction->payment_status == 'Paid' ? 'badge-success' : 'badge-warning' }}">
                                {{ $transaction->payment_status }}
                            </span>
                        </div>
                    </div>

                    <hr>

                    @if($transaction->report)
                        <div class="mb-4">
                            <h6>Linked Service Report</h6>
                            <div class="p-3 bg-light rounded">
                                <strong>{{ $transaction->report->customer->first_name }}
                                    {{ $transaction->report->customer->last_name }}</strong><br>
                                {{ $transaction->report->appliance_name }} ({{ $transaction->report->brand_model }})<br>
                                <a href="{{ route('services.show', $transaction->report) }}"
                                    class="btn btn-sm btn-link pl-0">View Service Report</a>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12 text-center pt-3">
                            <h3 class="font-weight-bold text-success">₱{{ number_format($transaction->total_amount, 2) }}
                            </h3>
                            <span class="text-muted">Total Amount</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection