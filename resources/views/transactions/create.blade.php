@extends('layouts.admin')

@section('title', 'New Transaction')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="m-0">Create New Transaction</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Service Report (Optional)</label>
                            <select name="report_id" class="form-control @error('report_id') is-invalid @enderror">
                                <option value="">Select Service Report</option>
                                @foreach($reports as $report)
                                    <option value="{{ $report->id }}" {{ (old('report_id') == $report->id || request('report_id') == $report->id) ? 'selected' : '' }}>
                                        #{{ $report->id }} - {{ $report->customer_name }} ({{ $report->appliance_name }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Select a service report if this payment is linked to a
                                repair job.</small>
                            @error('report_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- TODO: Add Parts Selection Logic later if complex, simpler version for now -->

                        <div class="form-group">
                            <label>Total Amount</label>
                            <input type="number" step="0.01" name="total_amount"
                                class="form-control @error('total_amount') is-invalid @enderror"
                                value="{{ old('total_amount') }}" required>
                            @error('total_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Payment Status</label>
                            <select name="payment_status"
                                class="form-control @error('payment_status') is-invalid @enderror">
                                <option value="Unpaid" {{ old('payment_status') == 'Unpaid' ? 'selected' : '' }}>Unpaid
                                </option>
                                <option value="Paid" {{ old('payment_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                            </select>
                            @error('payment_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mt-4 text-right">
                            @if(request('report_id'))
                                <a href="{{ route('services.show', request('report_id')) }}"
                                    class="btn btn-secondary">Cancel</a>
                            @else
                                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Cancel</a>
                            @endif
                            <button type="submit" class="btn btn-success">Save Transaction</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection