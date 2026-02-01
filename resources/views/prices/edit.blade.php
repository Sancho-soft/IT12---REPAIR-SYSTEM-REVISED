@extends('layouts.admin')

@section('title', 'Edit Price')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="m-0">Edit Service Price</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('prices.update', $price) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Service Name</label>
                            <input type="text" name="service_name"
                                class="form-control @error('service_name') is-invalid @enderror"
                                value="{{ old('service_name', $price->service_name) }}" required>
                            @error('service_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" step="0.01" name="service_price"
                                class="form-control @error('service_price') is-invalid @enderror"
                                value="{{ old('service_price', $price->service_price) }}" required>
                            @error('service_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mt-4 text-right">
                            <a href="{{ route('prices.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Price</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection