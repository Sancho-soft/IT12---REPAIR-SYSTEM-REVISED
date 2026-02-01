@extends('layouts.admin')

@section('title', 'Edit Part')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="m-0">Edit Part</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('inventory.update', $part) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Part Number</label>
                            <input type="text" name="part_no" class="form-control @error('part_no') is-invalid @enderror"
                                value="{{ old('part_no', $part->part_no) }}" required>
                            @error('part_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="description"
                                class="form-control @error('description') is-invalid @enderror"
                                value="{{ old('description', $part->description) }}" required>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="number" step="0.01" name="price"
                                        class="form-control @error('price') is-invalid @enderror"
                                        value="{{ old('price', $part->price) }}" required>
                                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Current Stock</label>
                                    <input type="number" name="quantity_stock"
                                        class="form-control @error('quantity_stock') is-invalid @enderror"
                                        value="{{ old('quantity_stock', $part->quantity_stock) }}" required>
                                    @error('quantity_stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4 text-right">
                            <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Part</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection