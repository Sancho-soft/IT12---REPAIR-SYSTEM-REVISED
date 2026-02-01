@extends('layouts.admin')

@section('title', 'Add Price')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="m-0">Add Service Price</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('prices.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Service Name</label>
                            <input type="text" name="service_name"
                                class="form-control @error('service_name') is-invalid @enderror"
                                value="{{ old('service_name') }}" required>
                            @error('service_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" step="0.01" name="service_price"
                                class="form-control @error('service_price') is-invalid @enderror"
                                value="{{ old('service_price') }}" required>
                            @error('service_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mt-4 text-right">
                            <a href="{{ route('prices.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Add Price</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection