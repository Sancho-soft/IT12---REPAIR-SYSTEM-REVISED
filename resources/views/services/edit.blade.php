@extends('layouts.admin')

@section('title', 'Edit Service Report')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="m-0">Edit Service Report #{{ $service->id }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('services.update', $service) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Customer</label>
                                    <select name="customer_id"
                                        class="form-control @error('customer_id') is-invalid @enderror" required>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ old('customer_id', $service->customer_id) == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->first_name }} {{ $customer->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date Received</label>
                                    <input type="date" name="date_in"
                                        class="form-control @error('date_in') is-invalid @enderror"
                                        value="{{ old('date_in', $service->date_in->format('Y-m-d')) }}" required>
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
                                        value="{{ old('appliance_name', $service->appliance_name) }}" required>
                                    @error('appliance_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Brand/Model</label>
                                    <input type="text" name="brand_model"
                                        class="form-control @error('brand_model') is-invalid @enderror"
                                        value="{{ old('brand_model', $service->brand_model) }}">
                                    @error('brand_model') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Problem Description</label>
                            <textarea name="problem_desc" class="form-control @error('problem_desc') is-invalid @enderror"
                                rows="3" required>{{ old('problem_desc', $service->problem_desc) }}</textarea>
                            @error('problem_desc') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Diagnosis / Recommendation</label>
                            <textarea name="recommendation"
                                class="form-control @error('recommendation') is-invalid @enderror"
                                rows="3">{{ old('recommendation', $service->recommendation) }}</textarea>
                            @error('recommendation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Labor Cost</label>
                                    <input type="number" step="0.01" name="labor_cost"
                                        class="form-control @error('labor_cost') is-invalid @enderror"
                                        value="{{ old('labor_cost', $service->labor_cost) }}">
                                    @error('labor_cost') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="Pending" {{ old('status', $service->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="In Progress" {{ old('status', $service->status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="Completed" {{ old('status', $service->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="Cancelled" {{ old('status', $service->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4 text-right">
                            <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Service Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection