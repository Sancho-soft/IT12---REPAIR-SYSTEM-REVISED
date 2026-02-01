@extends('layouts.admin')

@section('title', 'Inventory')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6 p-0 flex justify-content-lg-start justify-content-center">
                            <h2 class="ml-lg-2">Manage Inventory</h2>
                        </div>
                        <div class="col-sm-6 p-0 flex justify-content-lg-end justify-content-center">
                            <a href="{{ route('inventory.create') }}" class="btn btn-success">
                                <i class="material-icons">&#xE147;</i>
                                <span>Add New Part</span>
                            </a>
                        </div>
                    </div>
                </div>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Part No</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($parts as $part)
                            <tr>
                                <td>{{ $part->part_no }}</td>
                                <td>{{ $part->description }}</td>
                                <td>₱{{ number_format($part->price, 2) }}</td>
                                <td>
                                    <span
                                        class="badge {{ $part->quantity_stock < 5 ? 'badge-danger' : ($part->quantity_stock < 10 ? 'badge-warning' : 'badge-success') }}">
                                        {{ $part->quantity_stock }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('inventory.edit', $part) }}" class="edit" title="Edit"
                                        data-bs-toggle="tooltip">
                                        <i class="material-icons">&#xE254;</i>
                                    </a>
                                    <form action="{{ route('inventory.destroy', $part) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this part?');">
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
                                <td colspan="5" class="text-center">No parts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection