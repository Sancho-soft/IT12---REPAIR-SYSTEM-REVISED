@extends('layouts.admin')

@section('title', 'Edit Transaction')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="m-0">Edit Transaction #{{ $transaction->id }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('transactions.update', $transaction) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Service Report</label>
                            <input type="text" class="form-control"
                                value="{{ $transaction->report_id ? '#' . $transaction->report_id . ' - ' . ($transaction->report->customer ? $transaction->report->customer->first_name : $transaction->report->customer_name) : 'N/A' }}"
                                disabled>
                            <small class="form-text text-muted">Service report linkage cannot be changed.</small>
                        </div>

                        <div class="form-group">
                            <label>Total Amount</label>
                            <input type="number" step="0.01" name="total_amount"
                                class="form-control @error('total_amount') is-invalid @enderror"
                                value="{{ old('total_amount', $transaction->total_amount) }}" required>
                            @error('total_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Payment Status</label>
                            <select name="payment_status"
                                class="form-control @error('payment_status') is-invalid @enderror">
                                <option value="Unpaid" {{ old('payment_status', $transaction->payment_status) == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="Paid" {{ old('payment_status', $transaction->payment_status) == 'Paid' ? 'selected' : '' }}>Paid</option>
                            </select>
                            @error('payment_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mt-4 text-right">
                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Transaction</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection