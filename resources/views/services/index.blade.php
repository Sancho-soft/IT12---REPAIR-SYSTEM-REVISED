@extends('layouts.admin')

@section('title', 'Service Reports')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6 p-0 flex justify-content-lg-start justify-content-center">
                            <h2 class="ml-lg-2">Manage Service Reports</h2>
                        </div>
                        <div class="col-sm-6 p-0 flex justify-content-lg-end justify-content-center">
                            <a href="{{ route('services.create') }}" class="btn btn-success">
                                <i class="material-icons">&#xE147;</i>
                                <span>Add New Service</span>
                            </a>
                        </div>
                    </div>
                </div>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Appliance</th>
                            <th>Date In</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                            <tr>
                                <td>{{ $service->id }}</td>
                                <td>{{ $service->customer_name }}</td>
                                <td>{{ $service->appliance_name }}</td>
                                <td>{{ $service->date_in->format('M d, Y') }}</td>
                                <td>
                                    <span
                                        class="badge {{ $service->status === 'Completed' ? 'badge-success' : ($service->status === 'Pending' ? 'badge-warning' : 'badge-secondary') }}">
                                        {{ $service->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('services.show', $service) }}" class="view" title="View"
                                        data-bs-toggle="tooltip">
                                        <i class="material-icons text-info">&#xE8F4;</i>
                                    </a>
                                    <a href="{{ route('services.edit', $service) }}" class="edit" title="Edit"
                                        data-bs-toggle="tooltip">
                                        <i class="material-icons">&#xE254;</i>
                                    </a>
                                    <form action="{{ route('services.destroy', $service) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete this service report?');">
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
                                <td colspan="6" class="text-center">No service reports found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection