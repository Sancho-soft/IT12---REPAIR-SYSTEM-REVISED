@extends('layouts.admin')

@section('title', 'Service Prices')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6 p-0 flex justify-content-lg-start justify-content-center">
                            <h2 class="ml-lg-2">Manage Service Prices</h2>
                        </div>
                        <div class="col-sm-6 p-0 flex justify-content-lg-end justify-content-center">
                            <a href="{{ route('prices.create') }}" class="btn btn-success">
                                <i class="material-icons">&#xE147;</i>
                                <span>Add New Price</span>
                            </a>
                        </div>
                    </div>
                </div>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Service Name</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prices as $price)
                            <tr>
                                <td>{{ $price->service_name }}</td>
                                <td>₱{{ number_format($price->service_price, 2) }}</td>
                                <td>
                                    <a href="{{ route('prices.edit', $price) }}" class="edit" title="Edit"
                                        data-bs-toggle="tooltip">
                                        <i class="material-icons">&#xE254;</i>
                                    </a>
                                    <form action="{{ route('prices.destroy', $price) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this service price?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0 m-0"
                                            style="background:none; border:none; box-shadow:none;">
                                            <i class="material-icons delete" data-bs-toggle="tooltip"
                                                title="Delete">&#xE872;</i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No service prices found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection