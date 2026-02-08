@extends('layouts.admin')

@section('title', 'Add New Service')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="m-0">Create New Service Report</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('services.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Customer Name</label>
                                    <input type="text" name="customer_name" list="customer_list"
                                        class="form-control @error('customer_name') is-invalid @enderror"
                                        value="{{ old('customer_name') }}" required placeholder="Type or select customer">
                                    <datalist id="customer_list">
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->first_name }} {{ $customer->last_name }}">
                                        @endforeach
                                    </datalist>
                                    @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date Received</label>
                                    <input type="date" name="date_in"
                                        class="form-control @error('date_in') is-invalid @enderror"
                                        value="{{ old('date_in', date('Y-m-d')) }}" required>
                                    @error('date_in') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Appliance Type</label>
                                    <input type="text" name="appliance_name"
                                        class="form-control @error('appliance_name') is-invalid @enderror"
                                        value="{{ old('appliance_name') }}" placeholder="e.g. Washing Machine" required>
                                    @error('appliance_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Brand/Model</label>
                                    <input type="text" name="brand_model"
                                        class="form-control @error('brand_model') is-invalid @enderror"
                                        value="{{ old('brand_model') }}" placeholder="e.g. Samsung Top Load">
                                    @error('brand_model') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Problem Description</label>
                            <textarea name="problem_desc" class="form-control @error('problem_desc') is-invalid @enderror"
                                rows="3" required>{{ old('problem_desc') }}</textarea>
                            @error('problem_desc') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Initial Cost (Labor)</label>
                                    <input type="number" step="0.01" name="labor_cost"
                                        class="form-control @error('labor_cost') is-invalid @enderror"
                                        value="{{ old('labor_cost', 0) }}">
                                    @error('labor_cost') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="In Progress" {{ old('status') == 'In Progress' ? 'selected' : '' }}>In
                                            Progress</option>
                                        <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>
                                            Completed</option>
                                        <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                    </select>
                                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4 text-right">
                            <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Create Service Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection