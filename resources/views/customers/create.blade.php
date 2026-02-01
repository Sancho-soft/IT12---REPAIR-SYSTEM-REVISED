@extends('layouts.admin')

@section('title', 'Add Customer')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="m-0">Add New Customer</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name"
                                class="form-control @error('first_name') is-invalid @enderror"
                                value="{{ old('first_name') }}" required>
                            @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name"
                                class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}"
                                required>
                            @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="phone_no" class="form-control @error('phone_no') is-invalid @enderror"
                                value="{{ old('phone_no') }}" required>
                            @error('phone_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                                rows="3">{{ old('address') }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mt-4 text-right">
                            <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Save Customer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection